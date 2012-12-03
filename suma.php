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
<? include("top.php"); ?>
<h1>Suma aktualnej tury zakupów (<?
polacz_z_baza();
print(nazwa_aktualnej_tury());?>)</h1><?

suma_zamowien(id_aktualnej_tury());
?>



<? include("stopka.html"); ?>

<?php
}
?> 



