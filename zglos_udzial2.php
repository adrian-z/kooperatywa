<?php
$eko_kier=$_REQUEST['eko_kier'];
$eko_tow=$_POST['eko_tow'];
$gie_kier=$_POST['gie_kier'];
$gie_tow=$_POST['gie_tow'];
$waz=$_POST['waz'];
session_start ();
if (! session_is_registered ( "spoldzielnia" ) ) //if your variable isn't there, then the session must not be
{
session_unset (); //so lets destroy whatever session there was and bring them to login pagey!
session_destroy ();
$url = "Location: index.php";
header ( $url );
}
else //otherwise, they can see the page
{
include("top.php");
$tura = id_aktualnej_tury();
if ($eko_kier) {
	$q=mysql_query("INSERT INTO `spoldzielnia_ludzie` (`id_osoba`, `id_tura`, `rola`) VALUES ($eko_kier, $tura, 1) ");
	echo "Zg³osi³e¶/a¶ swój udzia³ jako kierowca do Juszkowa!";
}

if ($eko_tow) {
	$q=mysql_query("INSERT INTO `spoldzielnia_ludzie` (`id_osoba`, `id_tura`, `rola`) VALUES ($eko_tow, $tura, 2) ");
	echo "Zg³osi³e¶/a¶ swój udzia³ jako druga osoba do Juszkowa!";

}
if ($gie_kier) {
	$q=mysql_query("INSERT INTO `spoldzielnia_ludzie` (`id_osoba`, `id_tura`, `rola`) VALUES ($gie_kier, $tura, 3) ");
	echo "Zg³osi³e¶/a¶ swój udzia³ jako kierowca na gie³dê!";

}

if ($gie_tow) {
	$q=mysql_query("INSERT INTO `spoldzielnia_ludzie` (`id_osoba`, `id_tura`, `rola`) VALUES ($gie_tow, $tura, 4) ");
	echo "Zg³osi³e¶/a¶ swój udzia³ jako druga osoba na gie³dê!";

}
if ($waz) {
	$q=mysql_query("INSERT INTO `spoldzielnia_ludzie` (`id_osoba`, `id_tura`, `rola`) VALUES ($waz, $tura, 5) ");
	echo "Zg³osi³e¶/a¶ swój udzia³ w wa¿eniu i podziale zakupów!";

}



include("stopka.html"); 
}
?> 



