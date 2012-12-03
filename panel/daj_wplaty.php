<?php
	include("../funkcje.php");
	polacz_z_baza();
	$user=$_GET["id"];
	$tura=id_aktualnej_tury();
?>

<h1>Rozliczenie wpłat</h1>
<p> 


<?


	$zob_poj;
	$zobowiazania;
	$wpl_poj;
	$wplaty;
	$do_zaplaty=0;
	$wplacono=0;
	$saldo=0;	
	$i=0;
	$j=0;

	$q = mysql_query("SELECT c.`id` , c.`nazwa` , b.`nazwisko` , (SUM( a.`kwota` )*1.1), c.koszt_trans FROM `spoldzielnia_transakcje` AS a JOIN `spoldzielnia_userzy` AS b ON a.`id_user` = b.`id` JOIN `spoldzielnia_tury_zakupow` AS c ON a.`id_tury` = c.`id` WHERE a.`id_user` =$user AND c.`id` >=30 GROUP BY c.`id`");

	while ($w=mysql_fetch_array($q)) {
		$zob_poj[0]=$w[0];
		$zob_poj[1]=$w[1];
		$zob_poj[2]=$w[2];
		$zob_poj[3]=number_format ( $w[3], $decimals = 2);
		$zob_poj[4]=$w[4];
		$zobowiazania[$i] = $zob_poj;
		$do_zaplaty += $zob_poj[3];
		$do_zaplaty += $zob_poj[4];		
		$i++;

		
	}
	echo "<p><hr><P>";
	$q1= mysql_query("SELECT w.`id_tury` , w.`data` , w.`kwota`, t.`nazwa`, w.`uwagi` FROM `spoldzielnia_wplaty` as w JOIN `spoldzielnia_tury_zakupow` as t ON w.`id_tury`=t.`id` WHERE w.`id_usera` =$user AND w.`id_tury`>=30 ORDER BY w.`id_tury` DESC");
	while ($w1=mysql_fetch_array($q1)) {
		$wpla_poj[0]=$w1[0];
		$wpla_poj[1]=$w1[1];
		$wpla_poj[2]=$w1[2];
		$wpla_poj[3]=$w1[3];
		$wpla_poj[4]=$w1[4];
		$wplaty[$j] = $wpla_poj;
		$wplacono +=$wpla_poj[2]; 	
		$j++;
	}
	
	
	$dlugosc = count($zobowiazania);
	$dlugosc--;
	echo "<p> Rachunki:<p>";
	for ($k=$dlugosc; $k>=0; $k--) {
	$kwota = $zobowiazania[$k][3]+$zobowiazania[$k][4];

		echo "". $zobowiazania[$k][1] . " " . $kwota ." (w tym koszt paliwa:" . $zobowiazania[$k][4] . ")<p>";

	}	
	echo "<p>Suma do zapłaty: ". $do_zaplaty;

	echo "<p><hr><p> Wpłaty:<p>";

	$dlugoscw = count($wplaty);
	$dlugoscw--;
	for ($z=$dlugoscw; $z>=0; $z--) {
	$dat = explode ("-", $wplaty[$z][1]);
	$data = $dat[2] ."." . $dat[1] . "." . $dat[0];
		echo "data wpłaty: ". $data . ", tura zakupów: " . $wplaty[$z][3] . ", kwota: ". $wplaty[$z][2]. ", uwagi: " . $wplaty[$z][4] ."<p>";

	}	
	echo "Wpłacono w sumie: " . $wplacono;	
	echo "<p><hr>";
	$saldo = $wplacono-$do_zaplaty;
	if ($saldo<0.01 && $saldo>-0.01) {
	$saldo=0;
	}

	if ($saldo>0) {
		echo "<p>Saldo: <span class=zielony>" . $saldo;
	}
	elseif ($saldo==0) {
		echo "<p><span> Saldo wynosi: " . $saldo;
	}
	else {
		echo "<p>Saldo: <span class=czerwony> " . $saldo;
	}	

?>

