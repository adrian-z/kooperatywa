<?php
session_start ();
if (! session_is_registered ( "spoldzielnia" ) ) //if your variable isn't there, then the session must not be
{
session_unset (); //so lets destroy whatever session there was and bring them to login page
session_destroy ();
$url = "Location: index.php";
header ( $url );
}
else //otherwise, they can see the page
{
?>
<?php
//let's completely teminate the session and bring them to login page
session_start(); //yes, you still have to start the session
session_unset();
session_destroy();
$url = "Location: index.php";
header ($url);
?> 
<?php
}
?> 



