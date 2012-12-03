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
$cos = "Kasia";
$cos2 = crypt($cos, 'KDKDJJSHHDUdhs');
$cos3 = crypt($cos, 'KDKDJJSHHDUdhs');
if ($cos2==$cos3)  {
	print ("zgadza siê");
}
else {
	print ("nie zgadza siê");

}
?>
<div id="header">
		<h1>Kooperatywa</h1>
	</div>
	
	<h1>Wybierz:</h1>
			
	<ul>
		<li><a href=rozliczenie_zakupow.php>rozliczenie zakupow</a></li>
		<li><a href=rachunki.php>poka¿ rachunki</a></li>
		<li><a href=wplata_form.php>dodaj wp³atê</a></li>
		<LI><a href=pakunki.php>poka¿ pakunki</a></li>
		<LI><a href=dodaj_usera.php>dodaj u¿ytkownika</a></li>
		<LI><a href=dodaj_produkt.php>dodaj produkt</a></li>
		<LI><a href=nowa_tura.php>rozpocznij now± turê</a></li>
		<LI><a href=blokada_tury.php>zablokuj zamówienia</a></li>
		
	</ul>
	
	<ul class="data">
		<li><p>Aby zakoñczyæ, zamknij przegl±darkê.</p></li>
	</ul>







<? 



?>
<?php
}
?> 
<?include("stopka.php"); ?>



