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
foreach ($produkt_c as $id=>$cena)
{
echo $id . " - " . $cena . "<br>";

//print $cena;
/*	$counter = mysql_fetch_array(mysql_query("SELECT COUNT(id_produktu) AS c
								FROM spoldzielnia_ceny_uzyskane 
								WHERE id_produktu=$id 
								AND id_tury=$obe"));
	mysql_query("UPDATE spoldzielnia_ceny_uzyskane SET cena=$cena 
					WHERE id_produktu=$id AND id_tury=$obe");
	if ($counter['c'] == 0){
		mysql_query("INSERT INTO spoldzielnia_ceny_uzyskane 
					(id_tury, id_produktu, cena) VALUES ($obe,$id,$cena)");
	}
*/
}

print("<a href=admin.php>powrot do menu</a>");
?>
<?php
}
?> 



