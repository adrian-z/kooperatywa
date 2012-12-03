<?php
session_start ();
if (! session_is_registered ( "spoldzielnia" ) ) //if your variable isn't there, then the session must not be
{
session_unset (); //so lets destroy whatever session there was and bring them to login page
session_destroy ();
$url = "Location: index.php";
header ( $url );
}
else //otherwise, they can see the page
{
?>
<? include("top.php"); ?>
<? 

polacz_z_baza();

print("<h1>Zamówione produkty:</h1>");


pokaz_koszyk($_SESSION["userid"],id_aktualnej_tury());





?>
<? include("stopka.html"); ?>
<?php
}
?> 



