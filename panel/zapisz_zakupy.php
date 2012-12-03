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

<?
include("naglowek.php"); 
include("../funkcje.php");
polacz_z_baza();


$user1=$_GET['user'];
$tura=id_aktualnej_tury();
//$tura--;
$data=date("Y-m-d");
$q=mysql_query("SELECT id FROM spoldzielnia_userzy WHERE nazwisko=\"$user1\"");
$u=mysql_fetch_array($q);
$user=$u[0];
$qn=mysql_query("SELECT id_transakcji FROM spoldzielnia_transakcje WHERE id_user=$user AND id_tury=$tura");
$count= mysql_num_rows($qn);

?>


<div id="header">
	<h1>Kooperatywa</h1>
	<a href="admin.php" id="backButton">menu</a>
</div>
	<? 
if (!$count) {
$que=mysql_query("SELECT DISTINCT z.id_produktu, z.ilosc
FROM spoldzielnia_zamowienia AS z
JOIN spoldzielnia_produkty AS p ON z.id_produktu = p.id
JOIN spoldzielnia_ceny_uzyskane AS c ON z.id_tury = c.id_tury
WHERE z.id_usera =$user
AND z.id_tury =$tura
AND c.cena >0");
	
echo "SELECT DISTINCT z.id_produktu, z.ilosc
FROM spoldzielnia_zamowienia AS z
JOIN spoldzielnia_produkty AS p ON z.id_produktu = p.id
JOIN spoldzielnia_ceny_uzyskane AS c ON z.id_tury = c.id_tury
WHERE z.id_usera =$user
AND z.id_tury =$tura
AND c.cena >0";
	while($wyn=mysql_fetch_array($que)) {
		$id_produkt=$wyn[0];
		$ilosc=$wyn[1];
		$stan_dot = pokaz_stany($id_produkt);
		$query2 = "SELECT cena, id_tury from spoldzielnia_ceny_uzyskane WHERE id_produktu=$id_produkt ORDER BY id_tury DESC LIMIT 0,1";
		$res=mysql_fetch_array(mysql_query($query2));	
		$cena=$res[0];
		$kwota = $cena*$ilosc;
//		print ("$id_produkt . $ilosc . $stan_dot | ");
		if ($stan_dot >0 && $ilosc>0){
			$q = ("INSERT INTO spoldzielnia_transakcje (`id_produkt`, `id_tury`, `id_user`, `data`, `ilosc_wyszla`, `kwota`) VALUES ($id_produkt, $tura, $user, \"$data\", $ilosc, $kwota)");

			$produkty = mysql_query($q) or print ("b³±d");
			$qq = mysql_query("INSERT INTO transakcje_zapis (`id_usera`, `id_tury`) VALUES ('$user', '$tura')");
		}
	} 
}
else {
	print ("Kopiowanie ju¿ siê odby³o.$tura  $count</BR>");
}

if ($qq) {
		print ("Transakcje zapisane.</BR>");
	}
print ("<p> <a href=rachunki.php?tura=$tura> Powrót</a>");

//zwieksz_stan($id, $ilosc);
	include("stopka.php"); 


}
