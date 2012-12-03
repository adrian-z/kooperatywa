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

<h1>Wprowad¼ ceny z dzisiejszych zakupów:</h1>
	<ul class="data">
	<li style="font-size:18px">
	<form action=rozliczenie2.php method="post">
	<table width=100% cellpadding=5>
	<tr><td><b>produkt</b></td><td>jedn.</td><td><b>cena za jedn.</b></td></tr>

	<? 
	include("../funkcje.php");
	polacz_z_baza();
	//formularz_uzyskanych_cen();
	$q="SELECT DISTINCT p.id,p.nazwa,p.jednostka,cu.cena FROM 
		spoldzielnia_ceny_uzyskane AS cu 
		RIGHT JOIN spoldzielnia_config AS co on co.aktualna_tura=cu.id_tury 
		RIGHT JOIN spoldzielnia_produkty AS p on p.id=cu.id_produktu";

	$produkty = mysql_query($q);

	$kant="#EEEEEE";

	while ($wiersz = mysql_fetch_array($produkty)){
		if ($kant=="#EEEEEE") {$kant="#DDDDDD";} else {$kant="#EEEEEE";}

		$id=$wiersz['id'];
		$nazwa=$wiersz['nazwa'];
		$jednostka=$wiersz['jednostka'];
		$cena=empty($wiersz['cena']) ? "0.0" :$wiersz['cena'];
		print("<tr bgcolor=\"$kant\"><td>$nazwa</td><td width=150>$jednostka</td><td width=100>");

		print("<input value='$cena' style=\"width:80px;height:50px;padding:5px;font-size:25px\" type=text  name=\"cena[$id]\">");
		print("</td></tr>\n");
	}

	?>

	<tr><td></td><td></td><td><input type=submit value=wyslij></form></td></tr>
	</table>
	</li>
	</ul>
<?include("stopka.php"); ?>
<?php }?> 



