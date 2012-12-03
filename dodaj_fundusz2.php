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

$dz = $_POST['dzien'];
$mi = $_POST['miesiac'];
$ro =$_POST['rok'];
$kwota = $_POST['kwota'];
$kwota = str_replace(",", "." , $kwota);
$tekst = $_POST['opis'];
$id=$_SESSION["userid"];


 
if (!$ro && !$mi && !$dz) {

	$dzis = date("Y-m-d");
	echo $dzis;
	$data = $dzis;
}
else {
	echo "ro: " . $ro . "mi: " . $mi . "dz: " . $dz; 
	if ($ro<30) {
		$ro = "20" . $ro;
	}
	$data = $ro . "-" . $mi . "-" . $dz;
}

//echo $data. $kwota;
$q2 = mysql_query("SELECT id, stan FROM spoldzielnia_fundusz ORDER BY id DESC LIMIT 0,1");
$r = mysql_fetch_row($q2);
$id_f=  $r[0];
$stan = $r[1];
$stan +=$kwota;

$q = mysql_query("INSERT INTO spoldzielnia_fundusz (id_usera, data, kwota,stan, opis) VALUES ($id, \"$data\", $kwota, $stan, \"$tekst\")");

echo "Dodano now± pozycjê w ramach funduszu gromadzkiego!";
?>
<?php
}
?> 



