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

<?
include("naglowek.php"); 
include("../funkcje.php");

$user=$_POST['user'];
$id=$_POST['id'];
$ilosc=$_POST['ilosc'];
$tura=id_aktualnej_tury();
$data=date("Y-m-d");
?>

<div id="header">
	<h1>Kooperatywa</h1>
	<a href="admin.php" id="backButton">menu</a>
</div>
	<? 
	polacz_z_baza();
//	echo "INSERT INTO spoldzielnia_zamowienia (`id_produktu`, `id_tury`, `id_usera`, `ilosc`) VALUES ($id, $tura, $user, $ilosc)";

$produkty = mysql_query("INSERT INTO spoldzielnia_zamowienia (`id_produktu`, `id_tury`, `id_usera`, `ilosc`) VALUES ($id, $tura, $user, $ilosc)");

//$produkty = mysql_query("INSERT INTO spoldzielnia_transakcje (id_produkt, id_user, id_tury, data, ilosc_doszla) VALUES ($id, $user, $tura, \"$data\", $ilosc)");

//zwieksz_stan($id, $ilosc);
?>
<a href=rachunki.php>Wróæ do rachunków</a> i uzupe³nij zamówienie tej osoby. 
<?

	include("stopka.php"); 
 }



