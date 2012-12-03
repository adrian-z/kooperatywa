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
	
	<h1>Blokada zmiany zamówieñ</h1>
<? 
include("../funkcje.php");
polacz_z_baza();


$aktualna=id_aktualnej_tury();

$nowanazwa=$_GET['nazwa'];

$query = "UPDATE spoldzielnia_tury_zakupow SET aktywna=0 WHERE id=$aktualna";
mysql_query($query);
print ("Mo¿liwo¶æ zmiany zamówieñ w turze nr $aktualna zosta³a zablokowana.");
}
?>



