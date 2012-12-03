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

	<? 
	include("../funkcje.php");
	polacz_z_baza();
	$id=$_POST['id'];
	$ilosc=$_POST['ilosc'];
	$cena=$_POST['cena'];
	$tura=id_aktualnej_tury();
	$data=date("Y-m-d");
	echo "Dodano zakup towaru nr" . $id . ", w ilosci: " . $ilosc . ", za " . $cena . " zl. Tura nr " . $tura ;
	echo "</BR> Dodaj kolejny towar: <p></br>";
	mysql_query("INSERT spoldzielnia_transakcje SET id_produkt=$id, id_tury=$tura, id_user=1, data=\"$data\", ilosc_doszla=$ilosc");
	mysql_query("INSERT INTO `adrianzandberg5`.`spoldzielnia_zamowienia` (`id_produktu`,`id_tury`,`id_usera`,`ilosc`) VALUES ('$id', '$tura', '1', '$ilosc')");
	mysql_query("INSERT spoldzielnia_ceny_uzyskane SET id_produktu=$id, id_tury=$tura, cena=$cena");
	$produkty = mysql_query("SELECT id, nazwa FROM spoldzielnia_produkty");
	zwieksz_stan($id, $ilosc);

print ("<form action=dodaj_zakup_2.php method=\"post\">");

$dodac=0;
//do {

print("<select name=\"id\">");
while ($row = mysql_fetch_array($produkty)) {
	$id= $row['id'];
	$nazwa=$row['nazwa'];
	print("<option value=$id> $nazwa</option>");
}

print("</select>");
print ("ILOSC: <input name=\"ilosc\" size=8> </input> ");
print ("CENA: <input name=\"cena\" size=8> </input> ");
//}

//while ($dodac==1);
print ("<input type=\"submit\" value=\"Dodaj!\">");
print ("</form>");


	include("stopka.php"); 
 }



