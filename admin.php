<?php
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
 
kto_kupuje();

print ("<i>Problem z systemem zam�wie�? Nie wiesz jak znale�� jaki� produkt? Nie mo�esz po�apa� si� w tych tabelkach? Ka�dy na pocz�tku miewa z tym k�opoty, wi�c nie przejmuj si�, tylko zadzwo� do Bartka Nowaczyka (506 043 906), �eby uzyska� pomoc, zg�osi� b��d w systemie, albo po prostu po�ali� si� na system :). Zapraszam, je�li tylko b�d� m�g� to odbior�, je�li nie - oddzwoni�. BN</i> </p> </br>");

$user = $_SESSION["userid"];

polacz_z_baza();
$zakupy = nazwa_aktualnej_tury();

$akt = czy_aktywna();
if ($akt) {
	formularz_nastanie(id_aktualnej_tury(), $user);
	formularz_sezonowe(id_aktualnej_tury(), $user);
	formularz_eko(id_aktualnej_tury(), $user);
	formularz_wlasne(id_aktualnej_tury(), $user);
	formularz_z_cena(id_aktualnej_tury(), $user);
	formularz_zamowienia(id_aktualnej_tury(), $user);
}
else {

	print ("Mo�liwo�� sk�adania i zmieniania zam�wie� tymczasowo zablokowana. Zam�wienia b�dzie mo�na sk�ada� po aktywowaniu kolejnej tury zakup�w.");
}
?>
<? include("stopka.html"); ?>

<?php
}
?> 



