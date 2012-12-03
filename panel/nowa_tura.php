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
	
	<h1>Nowa tura zakupów</h1>
<? 
include("../funkcje.php");
polacz_z_baza();


print("<ul class=\"data\">
	<li>Uwaga! Po rozpoczêciu nowej tury nie bêdzie mo¿liwy dostêp do informacji o rachunkach i pakunkach z poprzedniej!<P>Obecna tura (".id_aktualnej_tury()."): ");
print(nazwa_aktualnej_tury());
?>
<form action=nowa_tura2.php>
<ul class="form">
	<li><input type="text" name="nazwa" value="Nazwa nowej tury" id="some_name" onclick="clickclear(this, 'Nazwa nowej tury')" onblur="clickrecall(this,'Nazwa nowej tury')" /></li>
</ul>

<input class="button white" type=submit value="rozpocznij now± turê">
</form>





<?
?>
<?php
}
?> 



