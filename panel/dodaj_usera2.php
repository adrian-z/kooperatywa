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
	
	<h1>Dodawanie u¿ytkownika:</h1>
<? 
include("../funkcje.php");
polacz_z_baza();

$nazwisko=$_GET['nazwisko'];
$email=$_GET['email'];
$haslo=crypt($_GET['haslo'], 'sjajja982u2washshy7278191hsbhga7a09aha');
$telefon=$_GET['telefon'];
$czy_prawko=$_GET['czy_prawko'];
$admin=$_GET['admin'];


$query="INSERT INTO spoldzielnia_userzy (email,haslo,nazwisko,telefon,czy_prawko,admin) VALUES ('$email','$haslo','$nazwisko','$telefon','$czy_prawko','$admin')";

$wykonaj = mysql_query($query) OR print("dupa");

print("U¿ytkownik <b>$email</b> dodany.");

$to  = $email;$subject = 'Rejestracja w Warszawskiej Kooperatywie Spó³dzielców';

// $message = "WAZNE - WEJDZ NA FORUM i potwierdz otrzymanie loginu! 
//Adres forum:\nhttp://www.cbs.edu.pl/spoldzielnia/forum/\n\nWitaj, $nazwisko\n\nTwoj login: $email\n\nTwoje haslo: $haslo\n\n
//System zamówieñ jest dostêpny pod adresem:\n
//http://www.cbs.edu.pl/spoldzielnia";// Additional headers$headers .= 'To: '.$nazwisko.' <'.$email.'>' . "\r\n";$headers .= 'From: Kooperatywa' . "\r\n";// Mail itmail($to, $subject, $message, $headers);




?>
<?php
}
?> 



