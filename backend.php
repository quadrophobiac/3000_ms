<?php

// this uses the new SDK /facebook-php-sdk-v4
// requires PHP 5.4 -___- 
// that SDK further compartmentalises the src files previously obtained
// does not work on Chrome, unable to test it on other browsers because of web upload difficulty

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');
//ini_set('display_errors', 'On');
// Must pass session data for the library to work
// derived from http://www.benmarshall.me/facebook-sdk-php-v4/

session_start();
date_default_timezone_set('Europe/London');
// Include the libraries files
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/Entities/AccessToken.php' );
require_once( 'Facebook/Entities/SignedRequest.php' ); // added to assuage FacebookSignedRequestFromInputHelper error
require_once( 'Facebook/GraphNodes/GraphObject.php' );
require_once( 'Facebook/GraphNodes/GraphSessionInfo.php' );
require_once( 'Facebook/HttpClients/FacebookCurl.php' );
require_once( 'Facebook/HttpClients/FacebookHttpClientInterface.php' );
//require_once( 'Facebook/HttpClients/FacebookHttpable.php' ); FacebookHttpClientInterface
require_once( 'Facebook/HttpClients/FacebookCurlHttpClient.php' );
require_once( 'Facebook/Exceptions/FacebookSDKException.php' );
require_once( 'Facebook/Exceptions/FacebookRequestException.php' );
require_once( 'Facebook/Exceptions/FacebookAuthorizationException.php' );
require_once( 'Facebook/Helpers/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/Helpers/FacebookSignedRequestFromInputHelper.php'); // if added before JS loginHelper, no error thrown
require_once( 'Facebook/Helpers/FacebookJavaScriptLoginHelper.php' ); // <-- the problem

use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSession;
use Facebook\Entities\AccessToken; // adding entities to alias doesn't hinder it
use Facebook\Entities\SignedRequest;
use Facebook\GraphNodes\GraphSessionInfo;
use Facebook\GraphNodes\GraphObject;
use Facebook\HttpClients\FacebookCurl; // adding HttpClients to alias doesn't hinder it
use Facebook\HttpClients\FacebookHttpClientInterface;
use Facebook\HttpClients\FacebookCurlHttpClient; // adding HttpClients to alias doesn't hinder it
use Facebook\Exceptions\FacebookAuthorizationException;
use Facebook\Exceptions\FacebookRequestException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\Helpers\FacebookSignedRequestFromInputHelper;

use Facebook\Helpers\FacebookJavaScriptLoginHelper; // <-- the problem

// initialise FacebookSession::setDefaultApplication(APP_ID and APP_SECRET) with your apps credentials


$event = array('events'); // $identifier->location rather than ...->name of interest

$fieldEntitites = array ('education', 'work');

//$helper = new FacebookRedirectLoginHelper( 'http://localhost/api_tinkering/php/fb-sdk/min.php' ); // redirect helper
$helper = new FacebookJavaScriptLoginHelper(); // js helper
$logging = fopen('logs.txt', 'a');

try {
  $session = $helper->getSession(); // js helper
  //echo "has PHP extracted session <br>";
} catch( FacebookRequestException $fb ) {
  //echo "facebook req exception ".$ex;
    fwrite($logging,time().": there was a facebook error fetching the session"+print_r($fb)."\n");

} catch( Exception $ex ) {
  // When validation fails or other local issues
  fwrite($logging,time().": there was some other error fetching the session"+print_r($ex)."\n");
}


    if ( isset( $session ) ) {

      $_SESSION['fb_token'] = $session->getToken();

      $session = new FacebookSession( $session->getToken() );

      try {

        $pageObjectEdges = array ('books','movies','music','games','television','groups','interests');
        $like = array('likes'); // both $identifier->category and $identifier->name of use
        // id candidates = {545287250} 545287250
        $request = new FacebookRequest( $session, 'GET', '/me?fields=id,books.name,music,television,movies,education,family,favorite_athletes.name,favorite_teams,events,groups.name,inspirational_people,interests,interested_in,likes,work' );
        $response = $request->execute(); // using method from FacebookResponse
        $graphObject = $response->getGraphObject();
        $indices = $graphObject->getPropertyNames(); // returns an array of all properties for which values exist from FacebookRequest call above
        array_pop($indices); // an id element is included as part of the GraphObject class and is unneeded, this removes this for data munging
        array_shift($indices); // id is not used after this point

        $fetchedData = $graphObject->asArray(); // returns a slightly different data structure to var_dump graphObject
        fclose($logging); // closed here as the subroutines open the file themselves

        $fileOut = "jsonData/".$fetchedData['id'].".json"; // this will write a file identified by the users app ID
        $edgeOut = fbEdges($fetchedData, $pageObjectEdges, $indices); // compute edge page objects
        commit($fileOut, $edgeOut); // write fetched data to file
        $theLikes = fbLikes($fetchedData, $like, $indices); // get likes
        $likeOut = sortLikes($theLikes); // sort likes into a JSON like structure
        commit($fileOut, $likeOut); // write to file

      } catch (FacebookRequestException $fb) {
        fwrite($logging,time().": there was a facebook error "+print_r($fb)."\n");
        fclose($logging);
        // The Graph API returned an error
      } catch (\Exception $e) {
        fwrite($logging,time().": some other error occurred "+print_r($e)."\n");
        fclose($logging);
      }

    } else {
      // No session
      fwrite($logging,time().": no session\n");
      fclose($logging);
    }
    //echo '<br><a href="http://localhost/api_tinkering/php/fb-sdk/min.php">Home</a><br>';

// this was not running because var/www has permission issues
    function commit($file, $arrayForFormat){
      $toJSON = fopen($file, 'a');
      fwrite($toJSON,json_encode($arrayForFormat));
      fclose($toJSON);
    }

    function fbEdges($fbAsArray, $edges, $indices){
      // requires a GraphObject->asArray array, an array of valid FB API edges, and returned property names [->getPropertyNames()] as indices
      $logging = fopen('logs.txt', 'a');
      fwrite($logging,time().": inside fbEdges subroutine\n");
      $arrOfArr = array();
        foreach ($edges as $filter){
          if(in_array($filter, $indices)){
            $innerArray = $fbAsArray[$filter]->data; // this is the array which houses every page one has liked
            $assArr = array();
            foreach ($innerArray as $ting){ // $ting is each element of the array, which are represented as {name:__, id:__} objects
              $assArr[$ting->id] = $ting->name;
            }
          }
          $arrOfArr[$filter] = $assArr;
      }
      fclose($logging);
      return $arrOfArr;
    }

    function fbEvents($fbAsArray, $edges, $indices){
      // requires a GraphObject->asArray array, an array of valid FB API edges, and returned property names [->getPropertyNames()] as indices
      $logging = fopen('logs.txt', 'a');
      fwrite($logging,time().": inside fbEdges subroutine\n");
      $arrOfArr = array();
        foreach ($edges as $filter){
          if(in_array($filter, $indices)){
            $innerArray = $fbAsArray[$filter]->data; // this is the array which houses every page one has liked
            $assArr = array();
            foreach ($innerArray as $ting){ // $ting is each element of the array, which are represented as {name:__, id:__} objects
              $assArr[$ting->id] = $ting->location;
            }
          }
          $arrOfArr[$filter] = $assArr;
      }
      fclose($logging);
      return $arrOfArr;
    }

    function fbLikes($fbAsArray, $edges, $indices){
        $logging = fopen('logs.txt', 'a');
        fwrite($logging,time().": inside like gathering subroutine\n");
        $arrOfArr = array();
        foreach ($edges as $filter){
          if(in_array($filter, $indices)){
            $innerArray = $fbAsArray[$filter]->data; // this is the array which houses every page one has liked
            $assArr = array();
            foreach ($innerArray as $ting){ // $ting is each element of the array, which are represented as {name:__, id:__} objects
              $assArr['category'] = $ting->category;
              $assArr['name'] = $ting->name;
              $arrOfArr[$ting->id] = $assArr;
            }
          }
      }
      //print_r($arrOfArr); // an array of objects whose properties are associative arrays
      fclose($logging);
      return($arrOfArr);
    }

    function sortLikes($objAssArr){
      //$finalObject = {};
      $categories = array(); // empty array created to capture the Fb taxonomy for Liked Pages
      foreach ($objAssArr as $key=>$value) { // loop through object returned from fbLikes
        array_push($categories, $value['category']); // add category typology to new array
      }
      $categories = array_unique($categories); // reduce duplicate entries in category array
      foreach($categories as $key=>$value){
        $finalObject[$value] = array();
        // create an object with key properties like this:: key = array()
      }
      foreach ($objAssArr as $key=>$value){
        // if(in_array($value['category'])){ // need a keys only comparison array        }
        if(array_key_exists($value['category'], $finalObject)){
        // check if the category value of objAssArr exists as a key value in the final object
          $keyValPair = array(); // create empty associative array
          // $keyValPair[$key] = $value['name']; // this format closely mirror structure produced by fbEdges above
          $keyValPair['id'] = $key; // add key from objAssArray as the id property
          $keyValPair['name'] = $value['name']; // add name index from value associative array
          //array_push($finalObject[$value['category']],$value['name']);
          array_push($finalObject[$value['category']],$keyValPair);
        }
      }
    return $finalObject;
    }

?>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/themes/3000ms.css" />
    <link rel="stylesheet" href="css/themes/base.css" />
    <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile.structure-1.4.2.min.css" />

    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<!--     <script type="text/javascript" src="js/jquery.timer.js"></script>
    <script type="text/javascript" src="js/countdown.js"></script>
    <script type="text/javascript" src="js/adt.js"></script> -->
    <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
  </head>
  <body>
    <?php
      if ( isset( $session ) ) {
        //echo '<br> NICE ONE! <script type="text/javascript">alert("nice one!\n\n");</script>';
        //echo '<img src="img/success.jpg"/>'; // removing for sake of redirect
        header('Location: tos.html/');
      } else {
        //echo "<br> something went awry, click <a href='http://www.stephenfortune.net/projects/30sec/backend.php'>here</a> <br>(don't worry it'll get fixed)<br>";
        //echo '<br> <script type="text/javascript">alert("something went awry. refresh the page <br>(don\'t worry it\'ll get fixed)<br>");</script>';
        header('Location: privacy.html/');
        //echo '<img style  src="img/fail.jpg"/>';
      }
    ?>
  </body>
</html>