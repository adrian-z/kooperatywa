<?php
session_start ();
if (! session_is_registered ( "spoldzielnia_admin" ) ) //if your variable isn't there, then the session must not be
{
		session_unset (); //so lets destroy whatever session there was and bring them to login page
		session_destroy ();
		$url = "Location: index.php";
		header ( $url );
}
else //otherwise, they can see the page
{
?>

<?include("naglowek.php"); ?>

<div id="header">
	<h1>Kooperatywa</h1>
	<a href="admin.php" id="backButton">menu</a>
</div>

<h1>Wprowad¼ kupione ilo¶ci:</h1>

	<? 
	include("../funkcje.php");
	polacz_z_baza();
	$tura=id_aktualnej_tury();
	rozlicz_zamowienie($tura);


?>Je¶li kupione zosta³y towary niezamówione, kliknij <a href=dodaj_zakup.php>tutaj</a>

<?php
	include("stopka.php"); 
 }



