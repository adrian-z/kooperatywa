<?php
session_start ();
if (! session_is_registered ( "spoldzielnia" ) ) //if your variable isn't there, then the session must not be
{
session_unset (); //so lets destroy whatever session there was and bring them to login pagey!
session_destroy ();
$url = "Location: index.php";
header ( $url );
}
else //otherwise, they can see the page
{
$user = $_SESSION["userid"];

include("top.php");

zglos_udzial($user);

include("stopka.html"); 
}
?> 



