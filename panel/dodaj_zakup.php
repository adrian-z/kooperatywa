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

<h1>Wprowadz dodatkowe towary :</h1>
W tym formularzu wprowadzamy towary, kt�re zosta�y kupione w czasie zakup�w na gie�dzie, a kt�re nie zosta�y przez nikogo zam�wione. Nale�y poda� og�ln� ilo�� zakupionego towaru, oraz cen� jaka zosta�a zakupiona za 1 jednostk� (kg, szt...). <p>
	<? 
	include("../funkcje.php");
	polacz_z_baza();
	$tura=id_aktualnej_tury();

$produkty = mysql_query("SELECT id, nazwa FROM spoldzielnia_produkty");

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



