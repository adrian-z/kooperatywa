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
	
	<h1>Dodawanie użytkownika:</h1>
<? 
include("../funkcje.php");
polacz_z_baza();

$nazwa=$_GET['nazwa'];
$ilosc=$_GET['ilosc'];
$jednostka=$_GET['jednostka'];
$cena=$_GET['cena'];

$query="INSERT INTO spoldzielnia_produkty (nazwa,jednostka,ilosc_rozliczeniowa,cena_za_jednostke) VALUES ('$nazwa','$jednostka','$ilosc','$cena')";

$wykonaj = mysql_query($query) OR print("$query");

$poprzednia=id_aktualnej_tury()-1;
$idek=mysql_insert_id();


$query="INSERT INTO spoldzielnia_ceny_uzyskane (id_tury,id_produktu, cena) VALUES ('$poprzednia','$idek','$cena')";

$wykonaj = mysql_query($query) OR print("dupa");



print("Produkt dodany");


?>
<?php
}
?> 



