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
		<h1>Pakunki</h1>
		<a href="admin.php" id="backButton">menu</a>
	</div>
<? 
include("../funkcje.php");
polacz_z_baza();

	
	$tura=id_aktualnej_tury();
	
	
	
	
	$query = "SELECT * FROM spoldzielnia_produkty ORDER BY nazwa";
	$wykonaj = mysql_query($query);
	
	
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{
	
		$id_produktu=$wiersz['id'];
		$jednostka=$wiersz['jednostka'];
		
		
		$podquery = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_tury=$tura AND id_produktu=$id_produktu)";
		$podwykonaj = mysql_query($podquery);
		if (mysql_num_rows($podwykonaj)>0) {
	
			print("<h1>".nazwa_produktu($id_produktu)."</h1><ul class=\"data\"><li>");
			while ($podwiersz = mysql_fetch_array($podwykonaj)) {
				$pid=$podwiersz['id'];
				$pid_produktu=$podwiersz['id_produktu'];
				$pid_usera=$podwiersz['id_usera'];
				$ilosc=$podwiersz['ilosc'];
			
				print("<P>".$ilosc." ".$jednostka." - (".nazwa_usera($pid_usera).") </P>");
		
			}
			print("</li></ul>");
		}

	}			
	$pq= mysql_query("SELECT a.`id_produktu` , b.`nazwa` , a.`ilosc` , c.`nazwisko` FROM `spoldzielnia_zamowienia` AS a JOIN `spoldzielnia_produkty` AS b ON a.`id_produktu` = b.`id` JOIN `spoldzielnia_userzy` AS c ON a.`id_usera` = c.`id` WHERE a.`id_tury` =30 LIMIT 0 , 30"); 
		
		while($pw = mysql_fetch_array($pq)){
		$naz = $pw[1];
		$ilo = $pw[2];
		$nazw = $pw[3];
		
		echo $nazw . ": " . $naz . " - " . $ilo . "<br>"; 
	}
	
		
	
	
	
	
	
	
	
	
	
	
	
	
print("<a href=admin.php>powrot do menu</a>");
	
	



?>
<?php
}
?> 



