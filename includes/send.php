<?php
//
//Email script adapted from THE MOLITOR
//
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');


$logging = fopen('maillogs.txt', 'a');


 if(($_POST['email']=="")||($_POST['name']=="")||($_POST['message']=="")) {

  echo "<html><body><p>The following fields are <strong>required</strong>.</p><ul>";

  if($_POST['name'] == ""){
  	echo "<li>Name</li>";
  }
  if($_POST['email'] == ""){
  	echo "<li>Email</li>";
  }
  if($_POST['message'] == ""){
  	echo "<li>Message</li>";
  }
  echo "</ul><p>Please use your browser's back button to complete the form.</p></body></html>";
 }

 else {
	$message = "";
	$message .= "Name: " . htmlspecialchars($_POST['name'], ENT_QUOTES) . "<br>\n";
	$message .= "Email: " . htmlspecialchars($_POST['email'], ENT_QUOTES) . "<br>\n";
	$message .= "Message: " . htmlspecialchars($_POST['message'], ENT_QUOTES) . "<br>\n";
	$subject = htmlspecialchars($_POST['subject'], ENT_QUOTES);
	$repemail = htmlspecialchars($_POST['repemail'], ENT_QUOTES);
	$injection_strings = array ( "[content-type:]i","[charset=]i","[mime-version:]i","[multipart/mixed]i","[bcc:]i","[cc:]i");

  foreach($injection_strings as $suspect) {
    // eregi is now deprecated
   if((preg_match($suspect, $_POST['message'])) || (preg_match($suspect, strtolower($_POST['name']))) || (preg_match($suspect, strtolower($_POST['email'])))) {
	   die ( 'Illegal Input.  Go back and try again.  Your message has not been sent.' );
   }
  }

	$headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: \"" . $_POST['name'] . "\" <" . $_POST['email'] . ">\r\n";
	$headers .= "Reply-To: " . $_POST['email'] . "\r\n\r\n";

  try {
    if (mail($repemail, $subject, $message, $headers)) {
    } else {
       fwrite($logging, 'mail failure for '.$repemail.", ".$subject.", ".$message.", ".$headers);
    }
  } catch (\Exception $e) {
       //$out = fopen($logging, 'a');
       fwrite($logging,"mailbox error ".$e."\n");
  }
 header("Location: index.html");
 }

?>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      </head>
</html>