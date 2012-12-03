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

print ("<i>Problem z systemem zamówieñ? Nie wiesz jak znale¼æ jaki¶ produkt? Nie mo¿esz po³apaæ siê w tych tabelkach? Ka¿dy na pocz±tku miewa z tym k³opoty, wiêc nie przejmuj siê, tylko zadzwoñ do Bartka Nowaczyka (506 043 906), ¿eby uzyskaæ pomoc, zg³osiæ b³±d w systemie, albo po prostu po¿aliæ siê na system :). Zapraszam, je¶li tylko bêdê móg³ to odbiorê, je¶li nie - oddzwoniê. BN</i> </p> </br>");

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

	print ("Mo¿liwo¶æ sk³adania i zmieniania zamówieñ tymczasowo zablokowana. Zamówienia bêdzie mo¿na sk³adaæ po aktywowaniu kolejnej tury zakupów.");
}
?>
<? include("stopka.html"); ?>

<?php
}
?> 



