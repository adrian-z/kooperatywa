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
	$suma = 0;
$q=mysql_query("SELECT p.`nazwa`, p.`jednostka`, SUM(z.`ilosc`), p.`nasza_cena`,  (SUM(z.`ilosc`)*p.`nasza_cena`) as wartosc FROM `spoldzielnia_zamowienia` as z INNER JOIN `spoldzielnia_produkty` as p ON z.`id_produktu`=p.`id` WHERE z.`id_tury`=$tura AND p.`kategoria`=16 GROUP BY p.`nazwa`");
		
while ($w=mysql_fetch_array($q)) {
	echo $w[0] . " " . $w[1] . " " . $w[2] . " " . $w[3] . " " .  $w[4] . "<br>";
	$suma += $w[4];
}
	echo "<p> Suma zamówieñ eko: " . $suma;
	
}
?>


