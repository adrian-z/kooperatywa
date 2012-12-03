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
<script src="skrypty.js" type="text/javascript"></script>	
<?include("naglowek.php"); ?>

<div id="header">
	<h1>Kooperatywa</h1>
	<a href="admin.php" id="backButton">menu</a>
</div>

<h1>Wprowadz wp³atê :</h1>
	<? 
	include("../funkcje.php");
	polacz_z_baza();
	$tura=id_aktualnej_tury();

$userzy = mysql_query("SELECT id, nazwisko FROM spoldzielnia_userzy ORDER BY nazwisko");
$tury = mysql_query("SELECT id, nazwa FROM spoldzielnia_tury_zakupow ORDER BY id DESC");

print ("<form action=wplata_form2.php method=\"post\">");

print("Wybierz osobê: <select name=\"id_user\" onchange=\"wplaty(this.value)\">");
while ($row = mysql_fetch_array($userzy)) {
	$id= $row['id'];
	$nazwisko=$row['nazwisko'];
	print("<option value=$id> $nazwisko</option>");
}

print("</select><p>");
print("Wybierz turê zakupów: <select name=\"id_tura\">");
while ($row2 = mysql_fetch_array($tury)) {
	$id_t= $row2['id'];
	$nazwa_t=$row2['nazwa'];
	print("<option value=$id_t> $nazwa_t</option>");
}
print("</select><p>");


print ("Kwota: <input name=\"kwota\" size=8> </input><p> ");
print ("<textarea name=uwagi rows=\"4\" cols=\"50\"> </textarea><p>");

print ("<input type=\"submit\" value=\"Dodaj!\">");
print ("</form>");


?>
<div id="wpl_sum"> </div>

<?

	include("stopka.php"); 
 }



