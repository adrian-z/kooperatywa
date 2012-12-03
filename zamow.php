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

<? 


polacz_z_baza();

$produkt=$_GET['produkt'];
$ilosc_p=$_GET['ilosc'];
$kat=$_GET['kategoria'];
$przecinek = ",";
$kropka = ".";

$ilosc = str_replace($przecinek, $kropka , $ilosc_p);


print("<p align=right><b>");
print("</b></P>");

if ($kat == 13 && ($ilosc%50 != 0)) {
	print("<h2><font color=red>B³±d! Przyprawy mo¿na zamawiaæ w paczkach po 50 lub 100 g!</font> </h2>");	
}

else {
	zamow_produkt($produkt,id_aktualnej_tury(),$_SESSION["userid"],$ilosc);
}

$url2="http://www.adrianzandberg.pl/kooperatywa_gdansk/admin.php#$kat";

print ("Wróæ na stronê z <a href=$url2>formularzem zamówieñ</a>!");



include("stopka.html"); ?>

<?php
}
?> 



