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


include("charts.php");







$tura=id_aktualnej_tury();

$licznik=1;
while ($licznik<$tura-1)
{

$licznik++;
$labele.=nazwa_tury($licznik)."|";
$data['suma'][]=suma_tury($licznik);
$data['fundusz'][]=fundusz($licznik);
}	



	$moo= new googleChart();
	
	
	$moo->dimensions='800x125'; 
	$moo->smartDataLabel($data);
	$moo->setLabelsMinMax(5,'left'); 
	$moo->setLabels($labele,'bottom');
	$moo->showGrid=1;
	$moo->colors='ff0000,0000ff';
	$moo->draw(true);
	
	
	   
	
	
print("<P><table cellpadding=10><tr><td valign=top width=50%>
<h2>Zamówienia w poszczególnych turach</h2><table CELLPADDING=10 BGCOLOR=#EEEEEE><tr><td><b>tura</b></td><td><b>zamowienia</b></td><td><b>fundusz</b></td></tr>");

$tura=id_aktualnej_tury();

$licznik=1;
while ($licznik<$tura-1)
{

$licznik++;
print("<tr><td>".nazwa_tury($licznik)."</td><td>".money_format('%.2n', suma_tury($licznik))." z³</td><td>".money_format('%.2n', fundusz($licznik))." z³</td></tr>");

}	
print("<tr><td><b>razem</b></td><td><b>".money_format('%.2n', sumuj_kase())." z³</b></td><td><b>".money_format('%.2n', sumuj_fundusz())." z³</b></td></tr>");
	
print("</table>");
	
print("<P><I>UWAGA: Dane maj± charakter szacunkowy - nie obejmuj± produktów zamówionych, a nie kupionych oraz produktów niezamówionych kupionych. W rzeczywisto¶ci suma zakupów i fundusz gromadzki s± wiêksze.</I><P> <h2>Najpopularniejsze produkty (wg. wagi zamówionych produktów)</h2><P><table CELLPADDING=10 BGCOLOR=#EEEEEE><tr><td><b>produkt</b></td><td><b>³±cznie zamówili¶my</b></td></tr>");	

najpopularniejsze_produkty_kilogramy();

print("<P><I>Uwaga! zestawienie obejmuje tylko produkty rozliczane w kilogramach</i><P>£±cznie zamówili¶my (wszystkich produktów): <B>");

print(lacznie_kilogramow());

print(" kg</b>");

print("</td><td valign=top width=50%><h2>Najpopularniejsze produkty (wg. faktycznie wydanych pieniêdzy)</h2><P><table CELLPADDING=10 BGCOLOR=#EEEEEE><tr><td><b>produkt</b></td><td><b>³±cznie kupili¶my za</b></td></tr>");

najpopularniejsze_produkty_cena();


print("<h2>Najpopularniejsze produkty (wg. warto¶ci z³o¿onych zamówieñ)</h2><table CELLPADDING=10 BGCOLOR=#EEEEEE><tr><td><b>produkt</b></td><td><b>³±cznie zamawiali¶my za</b></td></tr>");
najpopularniejsze_produkty_zamowienia();


print("</td></tr></table>");	
	
	

?>

<? include("stopka.html"); ?>
<?php
}
?> 



