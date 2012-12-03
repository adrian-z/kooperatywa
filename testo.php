<html>
<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"/> 


<link rel="stylesheet" href="style.css" type="text/css" media="screen">
</head>
<body>

<?

include("charts.php");

include("funkcje.php");







$tura=id_aktualnej_tury();

$licznik=1;
while ($licznik<$tura-1)
{

$licznik++;
$labele.=nazwa_tury($licznik)."|";
$data['suma zakupów'][]=suma_tury($licznik);
$data['fundusz gromadzki'][]=fundusz($licznik);
}	



	$moo= new googleChart();
	$moo->smartDataLabel($data);
	$moo->setLabelsMinMax(5,'left'); 
	$moo->setLabels($labele,'bottom'); 
	$moo->showGrid=1;
	$moo->colors='ff0000,0000ff';
	$moo->draw(true);
	
	
	
print("<P><table CELLPADDING=10 BGCOLOR=#EEEEEE><tr><td><b>tura</b></td><td><b>zamowienia</b></td><td><b>fundusz</b></td></tr>");

$tura=id_aktualnej_tury();

$licznik=1;
while ($licznik<$tura-1)
{

$licznik++;
print("<tr><td>".nazwa_tury($licznik)."</td><td>".suma_tury($licznik)."</td><td>".fundusz($licznik)."</td></tr>");

}	
print("<tr><td><b>razem</b></td><td><b>".sumuj_kase()."</b></td><td><b>".sumuj_fundusz()."</b></td></tr>");
	
print("</table>");
	
print("<P><I>UWAGA: Dane mają charakter szacunkowy - nie obejmują produktów zamówionych, a nie kupionych oraz produktów niezamówionych kupionych</I>");	

	
	
	

?>
