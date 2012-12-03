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

print("<h1>Zmiana has³a</h1>");

?>
<form action="zmiana_hasla_2.php" method="POST">
<label for="stare">Podaj stare haslo</label>
<input type="password" id="stare" name="stare"></input>
<br>
<label for="nowe">Podaj nowe haslo</label>
<input type="password" id="nowe" name="nowe"></input>
<br>
<label for="nowe2">Potwierd¼ nowe haslo</label>
<input type="password" id="nowe2" name="nowe2"></input>
<input type="submit" value="Zmieñ"></input>
</form>

<? include("stopka.html"); ?>
<?php
}
?> 



