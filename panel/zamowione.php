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
		<h1>Zamówienia</h1>
		<a href="admin.php" id="backButton">menu</a>&nbsp;
	</div>
<? 
include("../funkcje.php");
polacz_z_baza();
$tura=id_aktualnej_tury();
print("$tura");
$rachunki = podlicz_rachunki(id_aktualnej_tury());

foreach($rachunki as $user_id=>$rachunek){
	print("<div class=\"kwitek_rachunku\" style=\"padding-bottom:50px\">
			<h1 style=\"clear:both\">".$rachunek['nazwisko']."</h1>
			<ul class=\"data\">
						<li>");
	print($rachunek['html']);
	print("</li></ul></div>");

	$fundusz=$rachunek['suma']*0.10;
	$suma2=$rachunek['suma']+$fundusz;
	$suma2=money_format('%.2n', $suma2);
	print("<p><b>Razem: ".$rachunek['suma']." zl +$fundusz na fundusz gromadzki = $suma2 zl</b></p>");
}
	?>

<?include("stopka.php"); ?>
<?php
}
?> 

