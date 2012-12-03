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
include("naglowek.php"); 
include("../funkcje.php");
polacz_z_baza();
$tura=id_aktualnej_tury();
$user=$_POST['user_dod'];
$prod=$_POST['produkt_dod'];
$ilosc=$_POST['ilosc'];

?>
<?include("naglowek.php"); ?>
<div id="header">
	
</div>

<?
	//echo "INSERT INTO `spoldzielnia_zamowienia`(`id_produktu`, `id_tury`, `id_usera`, `ilosc`) VALUES ($prod,$tura,$user,1)"; 
	$qq= mysql_query("INSERT INTO `spoldzielnia_zamowienia`(`id_produktu`, `id_tury`, `id_usera`, `ilosc`) VALUES ($prod,$tura,$user,$ilosc)");

	if ($qq) {
echo "Dodano now± osobê do zamówienia";
	}
	
?><p>
<a href=rachunki.php>Wróæ do rachunków</a> i uzupe³nij zamówienie tej osoby. 

<?include("stopka.php"); ?>
<?php
}
?> 

