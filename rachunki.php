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
		<h1>Rachunki</h1>
		<a href="admin.php" id="backButton">menu</a>&nbsp;
		<a href="rachunki_ods.php" id="backButton" target="_blank">rachunki w openoffice</a>
	</div></br>
Poni¿ej znajduj± siê towary, które zosta³y zamówione i zosta³y kupione w tej turze zakupów, b±d¼ znajduj± siê w magazynie po poprzednich zakupach. W przypadku zakupów niezamówionych, dokonanych w czasie spotkania u¿yj linka "dodaj nowy zakup". Je¶li lista jest kompletna, proszê wcisn±æ "zapisz zakupy". Uwaga! Zapisaæ zakupy mo¿na tylko jeden raz!

<? 


include("../funkcje.php");
polacz_z_baza();
$tura=id_aktualnej_tury();
$rachunki = podlicz_rachunki($tura);
	
foreach($rachunki as $user_id=>$rachunek){
$qq = mysql_query("SELECT id_usera FROM transakcje_zapis WHERE id_usera=$user_id AND id_tury=$tura");
$licznik=mysql_num_rows($qq);

	print("<div class=\"kwitek_rachunku\" style=\"padding-bottom:50px\">
			<h1 style=\"clear:both\">".$rachunek['nazwisko']."</h1>
			<ul class=\"data\">
						<li>");
	print($rachunek['html']);
	$id = $rachunek['id'];
	$id_zamowienia=$rachunek['id_zamowienia'];
//	print(" </P>");
	print("</li></ul></div>");

	$user=$rachunek['nazwisko'];
	$fundusz=$rachunek['suma']*0.10;
	$suma2=$rachunek['suma']+$fundusz;
	$suma2=money_format('%.2n', $suma2);
	print("<p><b>Razem: ".$rachunek['suma']." zl +$fundusz na fundusz gromadzki = $suma2 zl</b>  ---> <a href=\"dodaj_towar_zak.php?user=$user\">dodaj nowy zakup</a>";
	if (!$licznik) {
		echo "---> <a href=\"zapisz_zakupy.php?user=$user\">Zapisz zakupy </a> (gdy powy¿sza lista jest kompletna!) </p>");
	}
	else {
		echo "transakcje zapisane";
	}
}
	?>
<?include("stopka.php"); ?>
<?php
}
?> 

