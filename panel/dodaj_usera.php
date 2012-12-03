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
	
	<h1>Dodawanie u篡tkownika:</h1>
<? 
include("../funkcje.php");
polacz_z_baza();
?>
<form action=dodaj_usera2.php>
<ul class="form">
	<li><input type="text" name="nazwisko" value="Nazwisko" id="some_name" onclick="clickclear(this, 'Nazwisko')" onblur="clickrecall(this,'Nazwisko')" /></li>
	<li><input type="text" name="email" value="Email" id="some_name" onclick="clickclear(this, 'Email')" onblur="clickrecall(this,'Email')" /></li>
	<li><input type="text" name="haslo" value="Has這" id="some_name" onclick="clickclear(this, 'Has這')" onblur="clickrecall(this,'Has這')"  /></li>
	<li><input type="text" name="telefon" value="Telefon" id="some_name" onclick="clickclear(this, 'Telefon')" onblur="clickrecall(this,'Telefon')" /></li>		 	
	<li><select id="czy_prawko">
	<option value ="1">Ma prawo jazdy</option>
	<option value ="0">Nie ma prawa jazdy</option>
	</select></li>
	
	<li><select id="admin">
	<option value ="1">admin</option>
	<option value ="0">zwyk造 u篡tkownik</option>
	</select></li>

</ul>

<input class="button white" type=submit value=dodaj>
</form>




<?
?>
<?php
}
?> 



