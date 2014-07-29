You will need a facebook app (id and secret) to run this project
Additionally you will need to download the Facebook PHP SDK [facebook-php-sdk-v4] 
(alternatively if you have a server or dev environment that runs composer you will find that a much more fluid dependency management experience).
You can get the latest PHP SDK here
You will need to run a minimum of PHP 5.4 in your dev environment / server.

Other things to watch out for
PHP and JS authentication will expire as the cookie set by the JS SDK has a time limit.
If your app stops working (and you haven't got error reporting on, attempt to reauthenticate via Javascript before making any other changes).

These are your friends...
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');


A project that takes 30 seconds as its inspiration and seeks to build it into a web app
A learning exercise in
- jQuery (for user interaction)
- javascript APIs (specifically facebook)
- web technologies mobile application dev - hopefully node.js, phonegap

This read me will be a record of my process
19/06/2014 - requirement gathering, and problem breakdown
19/06/2014 - establish git folder
19/06/2014 - credit learning resources
21/06/2014 - wiring together the buttons and stuff 
22/06/2014 - added basic jQuery async json fetches

Mooted JSON adt

ALL_QUESTIONS {
[
[0]topic: [statements],
....
[N]topic: [statements]
]
}

methods

topicCounts( topicArray ){} returns true if all arrays have even counts, false if not
chosen5( topicArray ){} the array counts, locates the 5 highest, returns their indexes
grab5 ( [ arrayIndexes as args ] ){} // remove 1 element from 5 randomly* chosen topics – basically a deQueue operation, 
grabNext5() {} // not a grab ten, just cause it means reservoir will not get depleted
^ same as grab5, this method will need to have a way of interrupting the time – like this http://jsfiddle.net/joey6978/67sR2/3/
^ but because above will need to be called asynchronously, we will make this a 'peek' method, and the 5 indexes are peeked, and if the 'flip card' function is invoked they are then scheduled for a dequeue once the timer elapses

Resources - http://jqfundamentals.com/ : flags up antipatterns, useful
http://www.thinkful.com/learn/intro-to-jquery
http://try.jquery.com/
http://www.codecademy.com/tracks/jquery
jQuery Recipes: A Problem-Solution Approach
jQuery UI 1.7: The User Interface Library for jQuery

Working out specific jQuery - important references
http://api.jquery.com/parents/
http://weblogs.asp.net/yousefjadallah/grid-layout-in-jquery-mobile
