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
$ilosc=$_GET['ilosc'];

?>
<div id="header">
		<h1>Zmiana zakupu</h1>
		<a href="admin.php" id="backButton">menu</a>&nbsp;
	</div>
<? 
include("../funkcje.php");
polacz_z_baza();

$query = mysql_query("UPDATE spoldzielnia_zamowienia SET ilosc=$ilosc WHERE id = $id");

echo "<a href=rachunki.php> Powrót</a>";
?>

<?include("stopka.php"); ?>
<?php
}
?> 

