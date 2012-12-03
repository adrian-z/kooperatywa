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
	
	<h1>Dodawanie produktu:</h1>
<? 
include("../funkcje.php");
polacz_z_baza();
?>

<form action=dodaj_produkt2.php>
<ul class="form">
	<li><input type="text" name="nazwa" value="Nazwa" id="some_name" onclick="clickclear(this, 'Nazwa')" onblur="clickrecall(this,'Nazwa')" /></li>
	<li><input type="text" name="jednostka" value="Jednostka" id="some_name" onclick="clickclear(this, 'Jednostka')" onblur="clickrecall(this,'Jednostka')" /></li>
	<li><input type="text" name="ilosc" value="Minimalna ilo¶æ" id="some_name" onclick="clickclear(this, 'Minimalna ilo¶æ')" onblur="clickrecall(this,'Minimalna ilo¶æ')"  /></li>
	<li><input type="text" name="cena" value="Cena" id="some_name" onclick="clickclear(this, 'Cena')" onblur="clickrecall(this,'Cena')" /></li>		 	
</ul>

<input class="button white" type=submit value=dodaj>
</form>





<?
?>
<?php
}
?> 



