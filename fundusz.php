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

	include("top.php");
	polacz_z_baza();
	$user=$_SESSION["userid"];
	$tura=id_aktualnej_tury();
	print("<h1>Fundusz gromadzki</h1>");

 if ($user != 19) { 	
	pokaz_fundusz($_SESSION["userid"]);
 }
 else {
	echo "Dostêpne dla tylko dla zalogowanych u¿ytkowników";
 }

if ($user==6|| $user==26) {
	echo "<a href=dodaj_fundusz.php>dodaj wpis</a>";
}


?>
<? include("stopka.html"); ?>
<?php
}
?> 



