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
require_once("../funkcje.php");
require_once('../odsphpgenerator/ods.php');
polacz_z_baza();
$id_tury = id_aktualnej_tury();
$rachunki = podlicz_rachunki_ods($id_tury);
#print('<pre>'.print_r($rachunki,true).'</pre>');
$ods  = new ods();
foreach($rachunki as $rachunek){
	$table = new odsTable($rachunek['nazwisko']);
	$row  = new odsTableRow();
	$row->addCell( new odsTableCellString('NAZWA'));
	$row->addCell( new odsTableCellEmpty());
	$row->addCell( new odsTableCellString('ILOSC'));
	$row->addCell( new odsTableCellString('JEDNOSTKA'));
	$row->addCell( new odsTableCellString('CENA ZA JED.'));
	$row->addCell( new odsTableCellString('NETTO'));
	$row->addCell( new odsTableCellString('DLA CO-OP'));
	$row->addCell( new odsTableCellString('BRUTTO'));
	$table->addRow($row);
	
	$n_row = 2;
	foreach($rachunek['produkty'] as $produkt){
		$row  = new odsTableRow();
		$row->addCell( new odsTableCellString((string)$produkt['nazwa']));
		//$row->addCell( new odsTableCellString("ogórek kiszony"));
		//$l.=$produkt['nazwa'].'<br />';
		$row->addCell( new odsTableCellEmpty());
		$row->addCell( new odsTableCellFloat($produkt['ilosc']));
		$row->addCell( new odsTableCellString($produkt['jednostka']) );
		$row->addCell( new odsTableCellFloat($produkt['cena']));
		//Do zaplaty netto
		$cell = new odsTableCellFloat(0);
		$cell->setFormula("C$n_row*E$n_row");
		$row->addCell( $cell );

		//Dla co-op
		$cell = new odsTableCellFloat(0);
		$cell->setFormula("F$n_row*0.1");
		$row->addCell( $cell );

		//Do zaplaty brutto
		$cell = new odsTableCellFloat(0);
		$cell->setFormula("F$n_row*1.1");
		$row->addCell( $cell );
		$table->addRow($row);
		$n_row++;
	}
	
	$n_row--;
	$row  = new odsTableRow();
	$row->addCell( new odsTableCellString('SUMA'));
	$row->addCell( new odsTableCellEmpty());
	$row->addCell( new odsTableCellEmpty());
	$row->addCell( new odsTableCellEmpty());
	$row->addCell( new odsTableCellEmpty());

	$cell = new odsTableCellFloat(0);
	$cell->setFormula("SUM([.F2:.F$n_row])");
	$row->addCell( $cell );

	$cell = new odsTableCellFloat(0);
	$cell->setFormula("SUM([.G2:.G$n_row])");
	$row->addCell( $cell );

	$cell = new odsTableCellFloat(0);
	$last+=1;
	$cell->setFormula("SUM([.H2:.H$n_row])");
	$row->addCell( $cell );

	$table->addRow($row);
	$ods->addTable($table);
}
//print($l);
$ods->downloadOdsFile("Rachunki_z_tury-$id_tury.ods");
}
?>
