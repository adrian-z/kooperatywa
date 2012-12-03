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

$has_st=crypt($_POST['stare'], 'sjajja982u2washshy7278191hsbhga7a09aha');
$has_no=crypt($_POST['nowe'], 'sjajja982u2washshy7278191hsbhga7a09aha');
$has_po=crypt($_POST['nowe2'], 'sjajja982u2washshy7278191hsbhga7a09aha');
$id=$_SESSION["userid"];
$q=mysql_query("SELECT haslo FROM spoldzielnia_userzy WHERE id=$id");
$r=mysql_fetch_array($q);
$p = $r[0];

if ($has_no!=$has_po) {	
	echo "B³±d! W celu weryfikacji nale¿y wprowadziæ dwukrotnie to samo has³o!";
}
else {
	if ($has_st != $p) {
		Echo "B³±d! Stare has³o nie pasuje!";
	}
	else {
	echo $has_st . " " . $p . " " . $has_no . " " . $has_po;
	mysql_query("UPDATE `spoldzielnia_userzy` SET `haslo`=\"$has_po\" WHERE `id`=$id") or print ("B³±d zapisu do bazy danych.");
	


	}
 
}

?>
<?php
}
?> 



