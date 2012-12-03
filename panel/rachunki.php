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
<?include("naglowek.php"); 
$fundusz_suma=0;
?>

<div id="header">
		<h1>Rachunki</h1>
		<a href="admin.php" id="backButton">menu</a>&nbsp;
		<a href="rachunki_ods.php" id="backButton" target="_blank">rachunki w openoffice</a>
	</div></br>
Poni¿ej znajduj± siê towary, które zosta³y zamówione i zosta³y kupione w tej turze zakupów, b±d¼ znajduj± siê w magazynie po poprzednich zakupach. W przypadku zakupów niezamówionych, dokonanych w czasie spotkania u¿yj linka "dodaj nowy zakup". Je¶li lista jest kompletna, proszê wcisn±æ "zapisz zakupy". Uwaga! Zapisaæ zakupy mo¿na tylko jeden raz!

<? 


include("../funkcje.php");
polacz_z_baza();
$tura_f=$_REQUEST['tura'];

$qw = mysql_query("SELECT id, nazwa FROM `spoldzielnia_tury_zakupow` ORDER BY id DESC");
?>
<p>
Wy¶wietl rachunki z tury:<br>
<form method="POST" action="">
<select name=tura>
<?
while($ww=mysql_fetch_array($qw, MYSQL_NUM)) {
$id_tura=$ww[0];
$nazwa_tura=$ww[1];
if ($tura_f==$id_tura) {
	print("<option value=$id_tura selected=\"selected\">$nazwa_tura</input>");

}
else {
	print("<option value=$id_tura>$nazwa_tura</input>");
}
}

?>
</select> 
<input type="submit" value=wy¶lij>
</form>

<?
if ($tura_f) {
	$tura = $tura_f;
}
else {
	$tura=id_aktualnej_tury();
}


$rachunki = podlicz_rachunki($tura);
$qqq = mysql_query("SELECT nazwa FROM spoldzielnia_tury_zakupow WHERE id=$tura");
$rrr = mysql_fetch_row($qqq);
$nazwa_tury = $rrr[0];

if ($tura_f) {
	print ("<h1> Rozliczenie zakupów z dnia $nazwa_tury</h1>");	
}
else {
	print ("<h1> Rozliczenie zakupów z bie¿±cej tury zakupów</h1>");	
}
foreach($rachunki as $user_id=>$rachunek){
$qq = mysql_query("SELECT id_transakcji FROM spoldzielnia_transakcje WHERE id_user=$user_id AND id_tury=$tura");
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
	$fundusz_suma += $fundusz;
	$suma2=$rachunek['suma']+$fundusz;
	$suma2=money_format('%.2n', $suma2);
	print("<p><b>Razem: ".$rachunek['suma']." zl +$fundusz na fundusz gromadzki = $suma2 zl</b>  ---> <a href=\"dodaj_towar_zak.php?user=$user\">dodaj nowy zakup</a>");
	if (!$licznik) {
		echo "---> <a href=\"zapisz_zakupy.php?user=$user\">Zapisz zakupy </a> (gdy powy¿sza lista jest kompletna!) </p>";
	}
	else {
		echo " // transakcje zapisane<P>";
	}
}

echo "<a href=dodaj_do_zakupow.php>Dodaj now± osobê do tej tury zakupów.</a> ";
	?>
<?
echo "<p> Fundusz Gromadzki za tê turê zakupów = " . $fundusz_suma . "<p>"; 
include("stopka.php"); ?>
<?php
}
?> 

