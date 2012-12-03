<?php
session_start ();
if (! session_is_registered ( "spoldzielnia" ) ) //if your variable isn't there, then the session must not be
{
	session_unset (); //so lets destroy whatever session there was and bring them to login page
	session_destroy ();
	$url = "Location: index.php";
	header ( $url );
}
else { //otherwise, they can see the page 
	include("top.php");
	polacz_z_baza();
	$tura=id_aktualnej_tury();
	$q = mysql_query("SELECT DISTINCT a.`nazwisko` FROM `spoldzielnia_userzy` AS a JOIN `spoldzielnia_zamowienia` AS b ON a.`id` = b.`id_usera` WHERE b.`id_tury` < $tura");
	while ($w=mysql_fetch_array($q)) {
		echo $mail = $w[0] . "<br> ";
	}
}
?> 



