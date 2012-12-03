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
$id=$_GET['id'];

?>
<div id="header">
		<h1>Zmiana zakupu</h1>
		<a href="admin.php" id="backButton">menu</a>&nbsp;
	</div>
<? 
include("../funkcje.php");
polacz_z_baza();

$query = mysql_query("SELECT z.id, p.id, p.nazwa, u.id, u.nazwisko, z.id_tury, z.ilosc
FROM spoldzielnia_zamowienia AS z
LEFT JOIN spoldzielnia_userzy AS u ON u.id = z.id_usera
LEFT JOIN spoldzielnia_produkty AS p ON z.id_produktu = p.id
WHERE z.id =$id");
$wykonaj = mysql_fetch_row($query);
$id_produktu=$wykonaj[1];
$nazwa_produktu=$wykonaj[2];
$id_usera=$wykonaj[3];
$nazwisko_usera=$wykonaj[4];
$id_tury=$wykonaj[5];
$ilosc=$wykonaj[6];
?>
<form action=zmien_zakup_2.php method=\"post\">
<? print ("<input type=hidden name=id value=$id>");?>
<table width=70% border=0>

<tr><td width-50%><? print("Produkt: $nazwa_produktu. </td> <td>"); ?>
</td></tr>
<tr><td width-50%><? print("Kupuj±cy: $nazwisko_usera. </td> <td>"); ?>
</td></tr>
<tr><td width-50%><? print("Tura nr: $id_tury. </td> <td>"); ?>
</td></tr>
<tr><td width-50%><? print("Zamówiona ilo¶æ: $ilosc. Sprzedano:"); ?></td> <td><input name="ilosc" size=6> </input> </td></tr>
</table>
<input type=submit value=zmieñ!>
</form>
<?include("stopka.php"); ?>
<?php
}
?> 

