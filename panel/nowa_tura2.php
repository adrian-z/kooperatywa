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
	
	<h1>Nowa tura zakupów</h1>
<? 
include("../funkcje.php");
polacz_z_baza();


$aktualna=id_aktualnej_tury();

$nowanazwa=$_GET['nazwa'];

$query = "INSERT INTO spoldzielnia_tury_zakupow (nazwa) VALUES ('$nowanazwa')";

	if ($wykonaj = mysql_query($query)) {$aktualnat=mysql_insert_id();} else {print("blad!");}
	
$query2 = "UPDATE spoldzielnia_config SET aktualna_tura=$aktualnat";


if ($wykonaj2 = mysql_query($query2)) {print("$nowanazwa dodana ");} else {print("blad!");}


?> 
<?
}
?>



