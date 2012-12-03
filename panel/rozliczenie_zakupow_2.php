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

<h1>DONE</h1><P>
<? 
include("../funkcje.php");
polacz_z_baza();
$produkt_c=$_POST['cena'];
$produkt_i=$_POST['ilosc'];

$obe=id_aktualnej_tury();
foreach ($produkt_c as $id=>$cena) {
	

//	echo $cos ="SELECT COUNT(id_produktu) AS c FROM spoldzielnia_ceny_uzyskane WHERE id_produktu=$id AND id_tury=$obe </ br>" ;
//	echo $cos2 ="UPDATE spoldzielnia_ceny_uzyskane SET cena=$cena WHERE id_produktu=$id AND id_tury=$obe</ br>" ;
//	echo $cos3 = "INSERT INTO spoldzielnia_ceny_uzyskane (id_tury, id_produktu, cena) VALUES ($obe,$id,$cena)";
	
	$counter = mysql_fetch_array(mysql_query("SELECT COUNT(id_produktu) AS c
								FROM spoldzielnia_ceny_uzyskane 
								WHERE id_produktu=$id 
								AND id_tury=$obe"));

	if ($counter['c'] == 0){
		mysql_query("INSERT INTO spoldzielnia_ceny_uzyskane (id_tury, id_produktu, cena) VALUES ($obe,$id,$cena)");
	}
	else {
		mysql_query("UPDATE spoldzielnia_ceny_uzyskane SET cena=$cena WHERE id_produktu=$id AND id_tury=$obe");
	}


}

foreach ($produkt_i as $id=>$ilosc) {
echo $id;
	$resultat=mysql_query( "SELECT id_transakcji FROM spoldzielnia_transakcje WHERE id_produkt=$id AND id_tury=$obe");
	$c2 = mysql_fetch_array($resultat);
	$a=$c2[0];  //nr transakcji 
	$num_rows = mysql_num_rows($resultat);

	if ($num_rows==0) {
		$dzis = date("Y-m-d");
		if ($ilosc>0) {
			mysql_query ("INSERT INTO spoldzielnia_transakcje (id_produkt, id_user, id_tury, data, ilosc_doszla) VALUES 				($id,1,	$obe,\"$dzis\",$ilosc)");
			zwieksz_stan($id, $ilosc);
		}

//echo "INSERT INTO spoldzielnia_transakcje (id_produkt, id_user, id_tury, data, ilosc_doszla) VALUES ($id,1,$obe,\"$dzis\",$ilosc)";
	}
	else {
		$dzis = date("Y-m-d");
		if ($ilosc>0) {
			mysql_query ("UPDATE spoldzielnia_transakcje SET id_produkt=$id, id_user=1, id_tury=$obe, data=\"$dzis\", ilosc_doszla=$ilosc WHERE id_transakcji=$a");
			zwieksz_stan($id, $ilosc);
		}
	}	
	
}



print("<a href=admin.php>powrot do menu</a>");
?>
<?php
}
?> 
