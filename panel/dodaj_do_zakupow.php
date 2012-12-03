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
include("naglowek.php"); 
include("../funkcje.php");
polacz_z_baza();
$tura=id_aktualnej_tury();
$qq= mysql_query("SELECT id, nazwisko FROM spoldzielnia_userzy ORDER BY nazwisko");
$qqq= mysql_query("SELECT id, nazwa FROM spoldzielnia_produkty ORDER BY nazwa");

?>
<?include("naglowek.php"); ?>
<div id="header">
		<h1></h1>
		<a href="admin.php" id="backButton">menu</a>&nbsp;
</div>

<form action="dodaj_do_zakupow2.php" method=POST>  
Wybierz osobê, która kupi³a co¶ podczas spotkania <br /> 
<SELECT name=user_dod> 
<?
while($res=mysql_fetch_row($qq)) {
	$id=$res[0];
	$naz=$res[1];
	echo "<option value=$id>$naz</option>";
}
echo "</SELECT>";
echo "<p>i jeden z kupionych towarów (resztê dodasz pó¼niej). Podaj ilo¶æ. <br />";
echo "<SELECT name=produkt_dod>";
while($ress=mysql_fetch_row($qqq)) {
	$idp=$ress[0];
	$nazp=$ress[1];
	echo "<option value=$idp>$nazp</option>";
}

echo "</SELECT>";
echo "<input type=text name=ilosc>";

echo "<input type=submit value=wy¶lij>";
?>

</form>

<?include("stopka.php"); ?>
<?php
}
?> 

