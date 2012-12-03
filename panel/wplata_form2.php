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
		$user= $_POST['id_user'];
		$tura= $_POST['id_tura'];
		$kwota = str_replace(",", ".", $_POST['kwota']);
		$uwagi= $_POST['uwagi'];	
		$data = date("Y-m-d");
include("naglowek.php"); ?>

<div id="header">
	<h1>Kooperatywa</h1>
	<a href="admin.php" id="backButton">menu</a>
</div>

	<? 
	include("../funkcje.php");
	polacz_z_baza();

	echo " Dodano wp³atê: " . $user . " - " . $kwota . ". " . $uwagi;	

mysql_query("INSERT INTO spoldzielnia_wplaty (`id_usera`, `id_tury`, `data`, `kwota`, `uwagi` ) VALUES ('$user', '$tura', '$data', '$kwota', '$uwagi')");
echo "<p><a href=wplata_form.php>Powrót</a>";
	include("stopka.php"); 
 }



