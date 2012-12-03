<?
include("top.php");


function suma_produktu2($id)
{

print(nazwa_produktu($id));
print("<P>");
	$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_produktu=$id AND id_tury>2)";
	$wykonaj = mysql_query($query);
	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$id_produktu=$wiersz['id_produktu'];
	$ilosc=$wiersz['ilosc'];
	$tura=$wiersz['id_tury'];
	$cena=cena_z_tury($id_produktu,$tura);
	
	
	
	$zakup=$cena*$ilosc;
	
	print("tura $tura - ilosc $ilosc - cena $cena - razem zakup $zakup <P>");
	
	$suma+=$zakup;
	
	}
	
	
	$suma=money_format('%.2n', $suma);
	

print($suma);
	
}

suma_produktu2($_GET['oo']);

?>
