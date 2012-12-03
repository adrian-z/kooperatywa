<?

############### polacz_z_baza #################


function polacz_z_baza()
{
	$mysql_link= mysql_connect("","",""); 
	if (!($mysql_link))
		{
			$error = mysql_error($mysql_link);
			print("Aktualizacja systemu. Zapraszamy pó¼niej!");
		} 
	mysql_select_db("", $mysql_link);
	mysql_query('SET NAMES latin2', $mysql_link);
}



############### id_aktualnej_tury ###############


function id_aktualnej_tury()
{

	$query = "SELECT * FROM spoldzielnia_config";

	$wykonaj = mysql_query($query) OR print("BLAD: nie udalo sie pobrac konfiguracji!\n");
	
	$wiersz = mysql_fetch_array($wykonaj);

	$aktualna_tura=$wiersz['aktualna_tura'];
	
	return $aktualna_tura;	
 			
}



############### nazwa_aktualnej_tury ###############


function nazwa_aktualnej_tury()
{

	$query = "SELECT * FROM spoldzielnia_config";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);

	$aktualna_tura=$wiersz['aktualna_tura'];

	$query = "SELECT * FROM spoldzielnia_tury_zakupow WHERE (id=$aktualna_tura)";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);

	$nazwa_aktualnej_tury=$wiersz['nazwa'];
	
	return $nazwa_aktualnej_tury;

 			
}




############### nazwa_aktualnej_tury ###############


function nazwa_tury($tura)
{

	

	$query = "SELECT * FROM spoldzielnia_tury_zakupow WHERE (id=$tura)";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);

	$nazwa_aktualnej_tury=$wiersz['nazwa'];
	
	return $nazwa_aktualnej_tury;

 			
}






############### nazwisko_uzytkownika ###############


function nazwisko_uzytkownika($id)
{

	$query = "SELECT * FROM spoldzielnia_userzy WHERE (id=$id)";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);

	$nazwisko=$wiersz['nazwisko'];
	
	return $nazwisko;

 			
}


############### email_uzytkownika ###############


function email_uzytkownika($id)
{

	$query = "SELECT * FROM spoldzielnia_userzy WHERE (id=$id)";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);

	$email=$wiersz['email'];
	
	return $email;

 			
}






############### pokaz_uzyskane_ceny ###############


function pokaz_uzyskane_ceny($tura)
{

	$query = "SELECT * FROM spoldzielnia_produkty";

	$wykonaj = mysql_query($query);
	
	print("<table>");
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$nazwa=$wiersz['nazwa'];
	$jednostka=$wiersz['jednostka'];
	$ilosc_rozliczeniowa=$wiersz['ilosc_rozliczeniowa'];
	
		$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura AND id_produktu=$id)";
		
		$wykonaj2= mysql_query($query2);
		$wiersz2=mysql_fetch_array($wykonaj2);
		
		$cena=$wiersz2['cena'];
		
		if (!$cena) {$cena="brak";}
		
	print("<tr><td>$id</td><td>$nazwa</td><td>$jednostka</td><td>$cena</td></tr>");
	}

	print("<table>");
	
}



function znajdz_cene($id,$tura)
{


$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura AND id_produktu=$id)";
		
		$wykonaj2= mysql_query($query2);
		$wiersz2=mysql_fetch_array($wykonaj2);
		
		$cena=$wiersz2['cena'];


if ($cena>0)

{

$re="$cena";

return $re;

}


elseif ($tura>3)

{

return znajdz_cene($id,$tura-1);



}

else


{

return "brak";

}



}

############### formularz_nastanie ###############
function formularz_nastanie($tura, $user) {

print ("<h1> Produkty znajduj±ce siê \"na stanie\"</h1><p>");

	print (" Poni¿ej znajduje siê lista towarów, które <strong>W TEJ CHWILI</strong> znajduj± siê w \"magazynie\" kooperatywy. Mo¿e potrzebujesz co¶ z nich? Uwaga. Przyprawy mo¿na zamawiaæ w opakowaniach po 50 lub 100g. Dziêki temu skróci siê czas potrzebny na wa¿enie zakupów (przyprawy bêd± ju¿ przygotowane w odpowiednich paczuszkach). <p> ");

	$querysez = "SELECT * FROM `spoldzielnia_produkty` ORDER BY `nazwa`";
	$wykonajsez = mysql_query($querysez);
	
		print("<table width=100%><tr><td><b>produkt</b></td><td><b>cena<br> (ostatnio uzyskana)</b></td><td><b>zamówiono</b></td><td><b>brakuje do pe³nego zamówienia</b></td><td>stan magazynu</td><td><b>twoje zamówienie</b></td><td><b><!--eko --></b></td></tr>");
	
	while ($wierszsez = mysql_fetch_array($wykonajsez)) {
	$id=$wierszsez['id'];
	$nazwa=$wierszsez['nazwa'];
	$jednostka=$wierszsez['jednostka'];
	$kategoria=$wierszsez['kategoria'];
	$ilosc_rozliczeniowa=$wierszsez['ilosc_rozliczeniowa'];
	$bazowa=$wierszsez['cena_za_jednostke'];
	$sezon=$wierszsez['sezon'];
	$towar_uwagi = !empty($wierszsez['uwagi']) ? (string) $wierszsez['uwagi'] : NULL;

	$cena=znajdz_cene($id,$tura);
	$cena=number_format($cena, 2);			
	$stan=pokaz_stany($id);
	if ($stan>0) {
 		if ($cena==0) {
			$cena="brak";
		}	
		$zamowiono=ile_zamowiono($id,id_aktualnej_tury());
		
		if ($zamowiono<$ilosc_rozliczeniowa) {
			$brakuje=$ilosc_rozliczeniowa-$zamowiono;
		}
		else {
			$brakuje=$ilosc_rozliczeniowa-($zamowiono % $ilosc_rozliczeniowa);
		}
		$kolor="zwykla";
		if ($zamowiono>0 && $zamowiono<$ilosc_rozliczeniowa){
			$kolor="zolta";
		}
		elseif ($zamowiono>0 && !($zamowiono%$ilosc_rozliczeniowa==0)){
			$kolor="rozowa";
		}
		if ($zamowiono % $ilosc_rozliczeniowa==0 && $zamowiono>=1){
			$kolor="zielona";		
		}
		$eko= null;
			
		print("<tr class=\"$kolor\"><td>" . htmlspecialchars($nazwa) . (!empty($towar_uwagi) ? ("<div style='margin-top: 12px; 	color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi) . "</div>") : '') . "</td><td width=120><a rel=\"gb_page_center[300, 380]\" href=ceny-stare.php?id=$id>$cena z³ za 1 $jednostka</a><br></td><td width=80>$zamowiono $jednostka</td><td width=110>$brakuje $jednostka (z $ilosc_rozliczeniowa $jednostka)</td><td>$stan $jednostka</td>");
	
		if ($user != 19) {
		print("<td><form action=zamow.php><input type=hidden name=produkt value=$id><input type=hidden name=kategoria value=$kategoria>
		<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
		");
		}
		print("<td style='border:0px;background-color:white' width=30>$eko&nbsp;</td></tr>");
	}
	}
	print("<table><BR><hr><P>");
	
}




############### formularz_sezonowe ###############
function formularz_sezonowe($tura, $user) {

print ("<h1> Warzywa i owoce sezonowe</h1><p>");
print ("<a name=\"11\">.<br></a>");
	print (" Poni¿ej znajduje siê lista dostêpnych <strong>W TEJ CHWILI</strong> towarów sezonowych. Nistety nasz klimat nas nie rozpieszcza, wiêc towary sezonowe s± dostêpne krótko, g³ównie wiosn±, latem i jesieni±. Ceny towarów sezonowych zmieniaj± siê z dnia na dzieñ, wiêc nie mamy mo¿liwo¶ci przewidzieæ ceny, za jak± kupimy produkt za kilka dni. Gwarantujemy, ¿e wybierzemy najkorzystniejsz± dostêpn± cenê. Produkty oznaczone zielonym listkiem to produkty ekologiczne (w przygotowaniu...) ");

	$querysez = "SELECT * FROM `spoldzielnia_produkty` WHERE `kategoria` = 11 AND `sezon` = 'tak' AND `dostepne`= 'tak' ORDER BY `nazwa`";
	$wykonajsez = mysql_query($querysez);
	
   if (mysql_num_rows($wykonajsez) == 0) {

		print ("<P> <h3>W tej chwili nie s± dostêpne ¿adne produkty sezonowe. Sprawd¼ za jaki¶ czas!</h3> <P><BR> <hr> <P>");
   }	
   else {
		print("<table width=100%><tr><td><b>produkt</b></td><td><b>cena<br> (ostatnio uzyskana)</b></td><td><b>zamówiono</b></td><td><b>brakuje do pe³nego zamówienia</b></td><td><b>twoje zamówienie</b></td><td><b><!--eko --></b></td></tr>");
	
	while ($wierszsez = mysql_fetch_array($wykonajsez)) {

	$id=$wierszsez['id'];
	$nazwa=$wierszsez['nazwa'];
	$jednostka=$wierszsez['jednostka'];
	$ilosc_rozliczeniowa=$wierszsez['ilosc_rozliczeniowa'];
	$bazowa=$wierszsez['cena_za_jednostke'];
	$sezon=$wierszsez['sezon'];
	$towar_uwagi = !empty($wierszsez['uwagi']) ? (string) $wierszsez['uwagi'] : NULL;

	$cena=znajdz_cene($id,$tura);
	$cena=number_format($cena, 2);			
		
	if ($cena==0) {$cena="brak";}
		
		
	$zamowiono=ile_zamowiono($id,id_aktualnej_tury());
		
	if ($zamowiono<$ilosc_rozliczeniowa) {
		$brakuje=$ilosc_rozliczeniowa-$zamowiono;
	}

	else {
		$brakuje=$ilosc_rozliczeniowa-($zamowiono % $ilosc_rozliczeniowa);
	}
		
	$kolor="zwykla";
		
	if ($zamowiono>0 && $zamowiono<$ilosc_rozliczeniowa){
		$kolor="zolta";
	}
		
	elseif ($zamowiono>0 && !($zamowiono%$ilosc_rozliczeniowa==0)){
		$kolor="rozowa";
	}
		
	if ($zamowiono % $ilosc_rozliczeniowa==0 && $zamowiono>=1){
		$kolor="zielona";		
	}
	
	$eko= null;
		
	print("<tr class=\"$kolor\"><td>" . htmlspecialchars($nazwa) . (!empty($towar_uwagi) ? ("<div style='margin-top: 12px; color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi) . "</div>") : '') . "</td><td width=120><a rel=\"gb_page_center[300, 380]\" href=ceny-stare.php?id=$id>$cena z³ za 1 $jednostka</a><br></td><td width=80>$zamowiono $jednostka</td><td width=110>$brakuje $jednostka (z $ilosc_rozliczeniowa $jednostka)</td>");
	
    if ($user != 19) {
	print("<td><form action=zamow.php><input type=hidden name=produkt value=$id>
	<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
	");
    }
	print("<td style='border:0px;background-color:white' width=30>$eko&nbsp;</td></tr>");
	}

	print("<table><BR><hr><P>");
   }
}


############### formularz_wlasne ###############
function formularz_wlasne($tura, $user) {

print ("<a name=\"14\">.</a>");
print ("<BR><h1> Produkcja w³asna</h1><p>");

	print (" Poni¿ej znajduje siê lista dostêpnych <strong>W TEJ CHWILI</strong> towarów naszej w³asnej produkcji. Przy przygotowaniu produktów nie u¿ywamy ¿adnych przyspieszaczy, chemicznych ulepszaczy itp. Korzystamy jedynie ze zwyk³ych przypraw i kooperatywnych warzyw i owoców. ");

	$querywla = "SELECT * FROM `spoldzielnia_produkty` WHERE `kategoria` = 14 AND `dostepne` = 'tak' ORDER BY `nazwa`";
	$wykonajwla = mysql_query($querywla);
	
   if (mysql_num_rows($wykonajwla) == 0) {

		print ("<P> <h3>W tej chwili nie s± dostêpne ¿adne produkty naszej produkcji. Sprawd¼ za jaki¶ czas!</h3> <p> <hr> <P><BR>");
   }	
   else {
print ("<hr />
	<font style=\"color: red;\">Na produkty <strong>mokre</strong> (np. kiszonki) obowiazuje w³asne opakowanie (np. torebka foliowa, plastikowy pojemnik)!</font><hr /><P>");

		print("<table width=100%><tr><td><b>produkt</b></td><td><b>nasza cena</b></td><td><b>zamówiono</b></td><td><b>brakuje do pe³nego zamówienia</b></td><td><b>stan magazynu</b></td><td><b>twoje zamówienie</b></td><td><b><!--eko --></b></td></tr>");
	
	while ($wierszsez = mysql_fetch_array($wykonajwla)) {

	$id=$wierszsez['id'];
	$nazwa=$wierszsez['nazwa'];
	$jednostka=$wierszsez['jednostka'];
	$ilosc_rozliczeniowa=$wierszsez['ilosc_rozliczeniowa'];
	$bazowa=$wierszsez['cena_za_jednostke'];
	$sezon=$wierszsez['sezon'];
	$towar_uwagi = !empty($wierszsez['uwagi']) ? (string) $wierszsez['uwagi'] : NULL;
	$cena=$wierszsez['nasza_cena'];
	$cena=number_format($cena, 2);
	$stan=pokaz_stany($id);
				
		
	if ($cena==0) {$cena="brak";}
		
		
	$zamowiono=ile_zamowiono($id,id_aktualnej_tury());
		
	if ($zamowiono<$ilosc_rozliczeniowa) {
		$brakuje=$ilosc_rozliczeniowa-$zamowiono;
	}

	else {
		$brakuje=$ilosc_rozliczeniowa-($zamowiono % $ilosc_rozliczeniowa);
	}
		
	$kolor="zwykla";
		
	if ($zamowiono>0 && $zamowiono<$ilosc_rozliczeniowa){
		$kolor="zolta";
	}
		
	elseif ($zamowiono>0 && !($zamowiono%$ilosc_rozliczeniowa==0)){
		$kolor="rozowa";
	}
		
	if ($zamowiono % $ilosc_rozliczeniowa==0 && $zamowiono>=1){
		$kolor="zielona";		
	}
	
	$eko= null;
		
	print("<tr class=\"$kolor\"><td>" . htmlspecialchars($nazwa) . (!empty($towar_uwagi) ? ("<div style='margin-top: 12px; color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi) . "</div>") : '') . "</td><td width=120><a rel=\"gb_page_center[300, 380]\" href=ceny-stare.php?id=$id>$cena z³ za 1 $jednostka</a><br></td><td width=80>$zamowiono $jednostka</td><td width=110>$brakuje $jednostka (z $ilosc_rozliczeniowa $jednostka)</td><td width=80>$stan $jednostka</td>");
	
   if ($user != 19) {	
	print("<td><form action=zamow.php><input type=hidden name=produkt value=$id>
	<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
	");
   }	
	print("<td style='border:0px;background-color:white' width=30>$eko&nbsp;</td></tr>");
	}

	print("<table><P><BR><hr><P>");
   }
}
############### formularz_eko ###############
function formularz_eko($tura, $user) {
	$q= mysql_query("SELECT `dzien_eko`, `godz_eko` FROM `spoldzielnia_tury_zakupow` WHERE `id`=$tura");
	$w= mysql_fetch_row($q);
	$dzien_eko= $w[0];
	$godz_eko= $w[1];
print ("<a name=\"16\">.</a>");
print ("<BR><h1> Produkty ekologiczne</h1><p>");
	print (" Poni¿ej znajduje siê lista towarów ekologicznych pochodz±cych z gospodarstwa ekologicznego w Juszkowie ko³o Pruszcza Gdañskiego.  Zamówienia na produkty z tej kategorii mo¿na sk³adaæ tylko do godziny <span class=gr> $godz_eko</span>, <span class=gr>$dzien_eko</span>. Nastêpnie zamówienie zostanie przekazane do realizacji. Odbiór zakupów eko razem z pozosta³ymi zakupami. <BR>
	
");

	$queryeko = "SELECT * FROM `spoldzielnia_produkty` WHERE `kategoria` = 16 ORDER BY `nazwa`";
	$wykonajeko = mysql_query($queryeko);
	
   if (mysql_num_rows($wykonajeko) == 0) {

		print ("<P> <h3>W tej chwili nie s± dostêpne ¿adne produkty w tej kategrorii. Sprawd¼ za jaki¶ czas!</h3> <p> <hr> <P><BR>");
   }	
   else {
		print("<table width=100%><tr><td><b>produkt</b></td><td><b>zamówiono</b></td><td><b>nasza cena</b></td><td><b>stan magazynu</b></td><td><b>twoje zamówienie</b></td><td><b><!--eko --></b></td></tr>");
	
	while ($wierszeko = mysql_fetch_array($wykonajeko)) {

	$id=$wierszeko['id'];
	$nazwa=$wierszeko['nazwa'];
	$jednostka=$wierszeko['jednostka'];
	$ilosc_rozliczeniowa=$wierszeko['ilosc_rozliczeniowa'];
	$bazowa=$wierszeko['cena_za_jednostke'];
	$sezon=$wierszeko['sezon'];
	$nasza_cena=$wierszeko['nasza_cena'];
	$stan=pokaz_stany($id);
	$towar_uwagi = !empty($wierszeko['uwagi']) ? (string) $wierszeko['uwagi'] : NULL;

	$cena=znajdz_cene($id,$tura);
	$nasza_cena=number_format($nasza_cena, 2);			
	if ($cena==0) {$cena="brak";}
		
		
	$zamowiono=ile_zamowiono($id,id_aktualnej_tury());
		
	if ($zamowiono<$ilosc_rozliczeniowa) {
		$brakuje=$ilosc_rozliczeniowa-$zamowiono;
	}

	else {
		$brakuje=$ilosc_rozliczeniowa-($zamowiono%$ilosc_rozliczeniowa);
	}
		
	$kolor="zwykla";			
	if ($zamowiono>0){
		$kolor="zielona";		
	}
	$eko= null;
		
	print("<tr class=\"$kolor\"><td>" . htmlspecialchars($nazwa) . (!empty($towar_uwagi) ? ("<div style='margin-top: 12px; color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi) . "</div>") : '') . "</td><td width=80>$zamowiono $jednostka</td><td width=60>$nasza_cena</td><td width=80>$stan $jednostka</td>");
	
   if ($user != 19) {	
	print("<td><form action=zamow.php><input type=hidden name=produkt value=$id>
	<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
	");
   }	
	print("<td style='border:0px;background-color:white' width=30>$eko&nbsp;</td></tr>");
	}

	print("<table><P><BR>");

   }
}


############### formularz_z_cena ###############
function formularz_z_cena($tura, $user) {

print ("<BR><h1> Produkty z cen± kontrolowan±</h1><p>");

	print (" Poni¿ej znajduje siê lista towarów suchych oraz przypraw, których cena jest kontrolowana. Przy ka¿dym produkcie widnieje cena, za jak± kupisz dany produkt w kooperatywie, oraz u¶redniona cena tego samego produktu z kilku du¿ych sklepów z terenu Gdañska. Ceny spisujemy w sklepach ¶rednio co miesi±c-dwa, wyci±gaj±c ¶redni± cenê za kilogram/paczkê/sztukê. Uwaga! Ceny w sklepach zmieniaj± siê, a czasami, w okresie promocji, cena  w konkretnym sklepie mo¿e byæ ni¿sza przez kilka dni ni¿ dostêpna u nas. Nas jednak bardziej interesuje ¶rednia cena, za jak± produkt mo¿na dostaæ w sklepie. Bêdziemy starali siê obj±æ monitoringiem ceny z kolejnych sklepów, tak aby uzyskaæ jeszcze lepszy przegl±d cen. Ostatni spis cen: marzec 2012. <BR>
	
");

	$querywla = "SELECT * FROM `spoldzielnia_produkty` WHERE `kategoria` = 12 ORDER BY `nazwa`";
	$wykonajwla = mysql_query($querywla);
	
   if (mysql_num_rows($wykonajwla) == 0) {

		print ("<P> <h3>W tej chwili nie s± dostêpne ¿adne produkty w tej kategrorii. Sprawd¼ za jaki¶ czas!</h3> <p> <hr> <P><BR>");
   }	
   else {
		print ("<a name=\"12\">.</a>");
		print("<table width=100%><tr><td><b>produkt</b></td><td><b>zamówiono</b></td><td><b>nasza cena</b></td><td><b>cena sklepowa</b></td><td><b>stan magazynu</b></td><td><b>twoje zamówienie</b></td><td><b><!--eko --></b></td></tr>");
	
	while ($wierszsez = mysql_fetch_array($wykonajwla)) {

	$id=$wierszsez['id'];
	$nazwa=$wierszsez['nazwa'];
	$jednostka=$wierszsez['jednostka'];
	$ilosc_rozliczeniowa=$wierszsez['ilosc_rozliczeniowa'];
	$bazowa=$wierszsez['cena_za_jednostke'];
	$sezon=$wierszsez['sezon'];
	$nasza_cena=$wierszsez['nasza_cena'];
	$sklepowa_cena=$wierszsez['cena_sklepowa'];
	$stan=pokaz_stany($id);
	$towar_uwagi = !empty($wierszsez['uwagi']) ? (string) $wierszsez['uwagi'] : NULL;

	$cena=znajdz_cene($id,$tura);
	$nasza_cena=number_format($nasza_cena, 2);			
	if ($cena==0) {$cena="brak";}
		
		
	$zamowiono=ile_zamowiono($id,id_aktualnej_tury());
		
	if ($zamowiono<$ilosc_rozliczeniowa) {
		$brakuje=$ilosc_rozliczeniowa-$zamowiono;
	}

	else {
		$brakuje=$ilosc_rozliczeniowa-($zamowiono%$ilosc_rozliczeniowa);
	}
		
	$kolor="zwykla";			
	if ($zamowiono>0){
		$kolor="zielona";		
	}
	$eko= null;
		
	print("<tr class=\"$kolor\"><td>" . htmlspecialchars($nazwa) . (!empty($towar_uwagi) ? ("<div style='margin-top: 12px; color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi) . "</div>") : '') . "</td><td width=80>$zamowiono $jednostka</td><td width=60>$nasza_cena</td><td width=60>$sklepowa_cena</td><td width=80>$stan $jednostka</td>");
	

   if ($user != 19) {	
	print("<td><form action=zamow.php><input type=hidden name=produkt value=$id>
	<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
	");
   }	
	print("<td style='border:0px;background-color:white' width=30>$eko&nbsp;</td></tr>");
	}

	print("<table><P><BR>");

   }

print ("<a name=\"13\">.</a>");
print ("<BR><h1> Przyprawy</h1><p>");


	$queryprz = "SELECT * FROM `spoldzielnia_produkty` WHERE `kategoria` = 13 ORDER BY `nazwa`";
	$wykonajprz = mysql_query($queryprz);
	
   if (mysql_num_rows($wykonajprz) == 0) {

		print ("<P> <h3>W tej chwili nie s± dostêpne ¿adne produkty w tej kategrorii. Sprawd¼ za jaki¶ czas!</h3> <p> <hr> <P><BR>");
   }	
   else {

		print("Uwaga. Przyprawy mo¿na zamawiaæ w opakowaniach po 50 lub 100g. Dziêki temu skróci siê czas potrzebny na wa¿enie zakupów (przyprawy bêd± ju¿ przygotowane w odpowiednich paczuszkach). <p>
<table width=100%><tr><td><b>produkt</b></td><td><b>zamówiono</b></td><td><b>nasza cena (za 100 g)</b></td><td><b>cena sklepowa (za 100 g)</b></td><td><b>Aktualny stan magazynu</b></td><td><b>twoje zamówienie</b></td><td><b><!--eko --></b></td></tr>");
	
	while ($wierszprz = mysql_fetch_array($wykonajprz)) {

	$id_prz=$wierszprz['id'];
	$nazwa_prz=$wierszprz['nazwa'];
	$jednostka_prz=$wierszprz['jednostka'];
	$ilosc_rozliczeniowa_prz=$wierszprz['ilosc_rozliczeniowa'];
	$bazowa_prz=$wierszprz['cena_za_jednostke'];
	$nasza_cena_prz=$wierszprz['nasza_cena'];
	$sklepowa_cena_prz=$wierszprz['cena_sklepowa'];
	$stan_prz=pokaz_stany($id_prz);
	$towar_uwagi_prz = !empty($wierszprz['uwagi']) ? (string) $wierszprz['uwagi'] : NULL;

	$cena_prz=znajdz_cene($id_prz,$tura);
	$nasza_cena_prz=number_format($nasza_cena_prz, 2);	
	
	if ($cena_prz==0) {$cena_prz="brak";}
		
		
	$zamowiono_prz=ile_zamowiono($id_prz,id_aktualnej_tury());
		
	if ($zamowiono_prz<$ilosc_rozliczeniowa_prz) {
		$brakuje_prz=$ilosc_rozliczeniowa_prz-$zamowiono_prz;
	}

	else {
		$brakuje_prz=$ilosc_rozliczeniowa_prz-($zamowiono_prz%$ilosc_rozliczeniowa_prz);
	}
		
	$kolor_prz="zwykla";
		
	if ($zamowiono_prz>0){
		$kolor_prz="zielona";		
	}
	
	$eko_prz= null;
		
	print("<tr class=\"$kolor_prz\"><td>" . htmlspecialchars($nazwa_prz) . (!empty($towar_uwagi_prz) ? ("<div style='margin-top: 12px; color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi_prz) . "</div>") : '') . "</td><td width=80>$zamowiono_prz $jednostka_prz</td> <td width=60>$nasza_cena_prz</td><td width=60>$sklepowa_cena_prz</td><td width=80>$stan_prz $jednostka_prz</td>");
	
   if ($user != 19) {	
	print("<td><form action=zamow.php><input type=hidden name=produkt value=$id_prz><input type=hidden name=kategoria value=13>
	<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka_prz&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
	");
   }	
	print("<td style='border:0px;background-color:white' width=30>$eko_prz&nbsp;</td></tr>");
	}

	print("<table><P><BR>");

   }

	print ("<hr><P>");
print ("<a name=\"15\">.</a>"); 
print ("<BR><h1> Sery owcze</h1><p>");

	$q= mysql_query("SELECT `dzien_ser`, `godz_ser` FROM `spoldzielnia_tury_zakupow` WHERE `id`=$tura");
	$w= mysql_fetch_row($q);
	$dzien_ser= $w[0];
	$godz_ser= $w[1];

	$queryser = "SELECT * FROM `spoldzielnia_produkty` WHERE `kategoria` = 15 ORDER BY `nazwa`";
	$wykonajser = mysql_query($queryser);
	
   if (mysql_num_rows($wykonajser) == 0) {

		print ("<P> <h3>W tej chwili nie s± dostêpne ¿adne produkty w tej kategrorii. Sprawd¼ za jaki¶ czas!</h3> <p> <hr> <P><BR>");
   }	
   else {

		print("Sery mo¿na obejrzeæ na stronie <a href=http://www.koludawielka.com.pl/sery_owcze.php target=new>www producenta z Ko³udy Wielkiej</a>. Sery przychodz± poczt± w dniu zakupów, wysy³ane s± dzieñ wcze¶niej. Uwaga! Sery mo¿na zamawiaæ jedynie do godziny <span class=gr>$godz_ser</span>, dnia <span class=gr>$dzien_ser</span>! Nastêpnie zamówienie przekazywane jest do realizacji. Odbiór serów razem z pozosta³ymi zakupami.<p>
<table width=100%><tr><td><b>produkt</b></td><td><b>zamówiono</b></td><td><b>nasza cena (za kg/sztukê)</b></td><!--<td><b>cena sklepowa (za 100 g)</b></td>--><td><b>Aktualny stan magazynu</b></td><td><b>twoje zamówienie</b></td><td><b><!--eko --></b></td></tr>");
	
	while ($wierszser = mysql_fetch_array($wykonajser)) {

	$id_ser=$wierszser['id'];
	$nazwa_ser=$wierszser['nazwa'];
	$jednostka_ser=$wierszser['jednostka'];
	$ilosc_rozliczeniowa_ser=$wierszser['ilosc_rozliczeniowa'];
	$bazowa_ser=$wierszser['cena_za_jednostke'];
	$nasza_cena_ser=$wierszser['nasza_cena'];
	$sklepowa_cena_ser=$wierszser['cena_sklepowa'];
	$stan_ser=pokaz_stany($id_ser);
	$towar_uwagi_ser = !empty($wierszser['uwagi']) ? (string) $wierszser['uwagi'] : NULL;

	$cena_ser=znajdz_cene($id_ser,$tura);
	$nasza_cena_ser=number_format($nasza_cena_ser, 2);	
	
	if ($cena_ser==0) {$cena_ser="brak";}
		
		
	$zamowiono_ser=ile_zamowiono($id_ser,id_aktualnej_tury());
		
	if ($zamowiono_ser<$ilosc_rozliczeniowa_ser) {
		$brakuje_ser=$ilosc_rozliczeniowa_ser-$zamowiono_ser;
	}

	else {
		$brakuje_ser=$ilosc_rozliczeniowa_ser-($zamowiono_ser%$ilosc_rozliczeniowa_ser);
	}
		
	$kolor_ser="zwykla";
		
	if ($zamowiono_ser>0){
		$kolor_ser="zielona";		
	}
	
	$eko_ser= null;
		
	print("<tr class=\"$kolor_ser\"><td>" . htmlspecialchars($nazwa_ser) . (!empty($towar_uwagi_ser) ? ("<div style='margin-top: 12px; color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi_ser) . "</div>") : '') . "</td><td width=80>$zamowiono_ser $jednostka_ser</td> <td width=60>$nasza_cena_ser</td><!--<td width=60>$sklepowa_cena_ser</td> --><td width=80>$stan_ser $jednostka_ser</td>");
	
   if ($user != 19) {	
	print("<td><form action=zamow.php><input type=hidden name=produkt value=$id_ser><input type=hidden name=kategoria value=15>
	<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka_ser&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
	");
   }	
	print("<td style='border:0px;background-color:white' width=30>$eko_ser&nbsp;</td></tr>");
	}

	print("<table><P><BR>");

   }

	print ("<hr><P>");
   
}


############### formularz_zamowienia ###############


function formularz_zamowienia($tura, $user)
{

print("<h1>Pozosta³e produkty</h1>");

	print("Poni¿sze produkty to wiêkszo¶æ produktów dostêpnych na gie³dzie. S± to wymieszane: produkty importowane, krajowe od producentów i od hurtowników. Najczê¶ciej gwarantuj± one ni¿sz± cenê ni¿ sklepowa. W miare mo¿liwo¶ci bêdziemy staraæ siê kupowaæ towary bezpo¶rednio od producentów, którzy produkty w³asnej produkcji przechowuj± w swoich ch³odniach. Przy produkcie widaæ cenê, za któr± kupowali¶my go ostatnim razem. Cena ma wiêc charakter orientacyjny (mog³a siê od tamtego czasu zmieniæ w górê lub w dó³). Je¿eli brakuje ceny to oznacza to, ¿e jeszcze nie kupowali¶my tego produktu.<P>
	Po klikniêciu na cenê produktu mo¿na zobaczyæ, za jakie ceny kupowali¶my go w poprzednich turach.<P> Informacja dotycz±ca znaczenia kolorów znajduje siê na dole strony. Czêsto udaje siê kupiæ towar, mimo ¿e ilo¶æ minimalna nie zosta³a osi±gniêta. W takim wypadku cena mo¿e byæ trochê wy¿sza ni¿ przy zakupie ca³ego worka, ale nie jest to zasad±. <hr />
	<font style=\"color: red;\">Na produkty <strong>mokre</strong> (np. kiszonki) obowi±zuje w³asne opakowanie (np. torebka foliowa, plastikowy pojemnik)!</font><hr /><P>
	");
	
	
	
print ("<a name=\"1\">.</a><a name=\"2\">.</a><a name=\"3\">.</a><a name=\"4\">.</a><a name=\"5\">.</a><a name=\"6\">.</a><a name=\"7\">.</a><a name=\"8\">.</a><a name=\"9\">.</a><a name=\"10\">.</a>");	
		$querykat = "SELECT * FROM spoldzielnia_kategorie WHERE `id` < 11";

	$wykonajkat = mysql_query($querykat);
	
	
	
	while ($wierszkat = mysql_fetch_array($wykonajkat))
	
	{

	$idkat=$wierszkat['id'];
	$nazwakat=$wierszkat['nazwa'];
	
	
	
	 print("<BR><h1>$nazwakat</h1>");
	 
		$query = "SELECT * FROM spoldzielnia_produkty WHERE kategoria=$idkat ORDER BY nazwa ";
		

	$wykonaj = mysql_query($query);
	
	print("<table width=100%><tr><td><b>produkt</b></td><td><b>cena (ostatnio uzyskana)</b></td><td><b>zamówiono</b></td><td><b>brakuje do pe³nego zamówienia</b></td><td><b>stan w magazynie</b></td><td><b>twoje zamówienie</b></td></tr>");
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$nazwa=$wiersz['nazwa'];
	$jednostka=$wiersz['jednostka'];
	$ilosc_rozliczeniowa=$wiersz['ilosc_rozliczeniowa'];
	$bazowa=$wiersz['cena_za_jednostke'];
	$nasz_cena = !empty($wiersz['nasza_cena']) ? (string) $wiersz['nasza_cena'] : NULL;
	$cena_sklepowa = !empty($wiersz['cena_sklepowa']) ? (string) $wiersz['cena_sklepowa'] : NULL;
	$stan =pokaz_stany($id); 
	$sezon=$wiersz['sezon'];
	$towar_uwagi = !empty($wiersz['uwagi']) ? (string) $wiersz['uwagi'] : NULL;
	
	$sezonowa="";
	
	if (strlen($sezon)>5)
	{
	
	$mamymiesiac=date('m');
	
	if ($sezon[$mamymiesiac-1]=="1") { $sezonowa="<img src=sezon.png>";} else {$sezonowa="";}
	
	
	}
	
	
		//$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura AND id_produktu=$id)";
		
		//$wykonaj2= mysql_query($query2);
		//$wiersz2=mysql_fetch_array($wykonaj2);
		
		//$cena=$wiersz2['cena'];
		
		$cena=znajdz_cene($id,$tura);
		$cena=number_format($cena, 2);			

		if ($cena==0) {$cena="brak";}
		
		
		$zamowiono=ile_zamowiono($id,id_aktualnej_tury());
		
		if ($zamowiono<$ilosc_rozliczeniowa) {$brakuje=$ilosc_rozliczeniowa-$zamowiono;}
		else
		
		{$brakuje=$ilosc_rozliczeniowa-($zamowiono % $ilosc_rozliczeniowa);}
		
		$kolor="zwykla";
		
		if ($zamowiono>0 && $zamowiono<$ilosc_rozliczeniowa)
		{
		$kolor="zolta";
		}
		
		elseif ($zamowiono>0 && !($zamowiono%$ilosc_rozliczeniowa==0))
		{
		$kolor="rozowa";
		}
		
		if ($zamowiono % $ilosc_rozliczeniowa==0 && $zamowiono>=1)
		{
		$kolor="zielona";		
		}
		
		
	print("<tr class=\"$kolor\"><td>" . htmlspecialchars($nazwa) . (!empty($towar_uwagi) ? ("<div style='margin-top: 12px; color: red; font-size: 8pt;'>" . htmlspecialchars($towar_uwagi) . "</div>") : '') . "</td><td width=150><a rel=\"gb_page_center[300, 380]\" href=ceny-stare.php?id=$id>$cena z³ za 1 $jednostka</a><br></td><td width=100>$zamowiono $jednostka</td><td width=150>$brakuje $jednostka (z $ilosc_rozliczeniowa $jednostka)</td><td>$stan $jednostka</td>");
	
   if ($user != 19) {	
	print("<td><form action=zamow.php><input type=hidden name=produkt value=$id>
	<input type=text style=\"width:40px\" name=\"ilosc\">$jednostka&nbsp;&nbsp;<input type=submit value=\"zamów\"></form></td>
	");
   }	
	print("</tr>");
	}

	print("<table><hr>");
	
	}
	
	print("<P>&nbsp;<P><hr><P><B>Znaczenie kolorów</b>
	<table><tr class=\"zwykla\"><td>brak zamówieñ</td></tr>
	<tr class=\"zielona\"><td>zamówiono ilo¶æ rozliczeniow± (yuppi! jest dla wszystkich)</td></tr>
	<tr class=\"zolta\"><td>zamówiona ilo¶æ nie gwarantuje zakupu, mo¿e siê zdarzyæ, ¿e zakup bêdzie niemo¿liwy lub cena mo¿e byæ trochê wy¿sza ni¿ przy zakupie wiêkszej paczki.</td></tr>
	<tr class=\"rozowa\"><td>na pewno bêdzie przynajmniej jedna paczka, ale brakuje jeszcze zamówieñ do kolejnej (dobierajcie do równych ilo¶ci! to u³atwi nam mocno rozliczenia przy rozdziale zakupów)</td></tr>
	</table>
	
	
	");
	
}




############### zamow_produkt ###############


function zamow_produkt($produkt,$tura,$user,$ilosc)
{

	$query = "INSERT INTO spoldzielnia_zamowienia (id_produktu,id_tury,id_usera,ilosc) VALUES ('$produkt','$tura','$user','$ilosc')";

	$wykonaj = mysql_query($query) or print("buuuu");
	
	print("W³o¿ono do koszyka: ");
	
	$query = "SELECT * FROM spoldzielnia_produkty WHERE id=$produkt";
	
	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);
	
	$jednostka=$wiersz['jednostka'];
	$nazwa=$wiersz['nazwa'];
	
	print("$nazwa ($ilosc $jednostka)");
	

 			
}




############### usun_produkt ###############


function usun_produkt($id_zamowienia)
{

	$query = "DELETE FROM spoldzielnia_zamowienia WHERE id=$id_zamowienia";

	$wykonaj = mysql_query($query) or print("$query");
	
	print("Usuniêto z koszyka. ");
	

 			
}






############### nazwa_produktu ###############


function jednostka_produktu($id)
{


$query = "SELECT * FROM spoldzielnia_produkty WHERE id=$id";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);
	
	$jednostka=$wiersz['jednostka'];
	
	return $jednostka;

}


############### jednostka_produktu ###############


function nazwa_produktu($idek)
{


$query = "SELECT * FROM spoldzielnia_produkty WHERE id=$idek";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);
	
	$nazwa=$wiersz['nazwa'];
	
	return $nazwa;

}




############### jednostka_produktu ###############


function nazwa_usera($idek)
{


$query = "SELECT * FROM spoldzielnia_userzy WHERE id=$idek";

	$wykonaj = mysql_query($query);
	
	$wiersz = mysql_fetch_array($wykonaj);
	
	$nazwa=$wiersz['nazwisko'];
	
	return $nazwa;

}





############### ile_zamowiono ###############


function ile_zamowiono($produkt,$tura)
{


$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_produktu=$produkt AND id_tury=$tura)";

	$wykonaj = mysql_query($query);
	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	{
	
	$ilosc=$wiersz['ilosc'];
	$suma=$suma+$ilosc;
	
	}
	
	
	return $suma;

}








############### pokaz_koszyk ###############


function pokaz_koszyk($user,$tura)
{

	$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_usera=$user AND id_tury=$tura)";
	$wykonaj = mysql_query($query);	
	$akt = czy_aktywna();	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$id_produktu=$wiersz['id_produktu'];
	$ilosc=$wiersz['ilosc'];
	
	$nazwa=nazwa_produktu($id_produktu);
	
	$jednostka=jednostka_produktu($id_produktu);
	
	$tura2=$tura-1;
	
	$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura2 AND id_produktu=$id_produktu)";
		
	$wykonaj2= mysql_query($query2);
	$wiersz2=mysql_fetch_array($wykonaj2);
		
	$cena=znajdz_cene($id_produktu,$tura2);
	$query3 = mysql_query("SELECT `nasza_cena` FROM `spoldzielnia_produkty` WHERE `id`=$id_produktu");
	$w3= mysql_fetch_row($query3);
	$cena2 = $w3[0];		
	if ($cena=="brak" && !$cena2) {
		$cena_ost="brak";$laczna="brak";

	}
	elseif (($cena!="brak" && !$cena2) || ($cena!="brak" && $cena2))
	{
		$laczna=$cena*$ilosc;
		$suma=$suma+$laczna;
		$cena_ost=$cena;
	}
	elseif ($cena && $cena2)
	{
		$laczna=$cena2*$ilosc;
		$suma=$suma+$laczna;
		$cena_ost=$cena2;
	}
		
	if ($akt) {
		print("$nazwa - $ilosc $jednostka - $laczna z³ ($cena_ost z³ za 1 $jednostka) <a href=usun.php?id_zamowienia=$id>usuñ z koszyka</a><P>");
	}
	else {
		print("$nazwa - $ilosc $jednostka - $laczna z³ ($cena_ost z³ za 1 $jednostka). Zakupy w toku - brak mo¿liwo¶ci modyfikowania zamówienia.<P>");	
	}
	
	
	}
	
	print("<P><B>Razem: $suma z³ + 10% na fundusz gromadzki = ".round($suma*1.1,2)." z³</b></p>
	<I>Uwaga! Wyliczenie jest orientacyjne (bazuje na cenach uzyskanych przy poprzednich zakupach oraz na cenach z cennika, które mog± ulec zmianie.)</i>");

	
}

############### pokaz_rachunek ###############





function pokaz_rachunek($user,$tura)
{

	$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_usera=$user AND id_tury=$tura) ";

	$wykonaj = mysql_query($query);
	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$id_produktu=$wiersz['id_produktu'];
	$ilosc=$wiersz['ilosc'];
	
	$nazwa=nazwa_produktu($id_produktu);
	
	$jednostka=jednostka_produktu($id_produktu);
	
	$tura2=$tura;
	
	$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura2 AND id_produktu=$id_produktu)";
		
	$wykonaj2= mysql_query($query2);
	$wiersz2=mysql_fetch_array($wykonaj2);
		
	$cena=$wiersz2['cena'];
		
	if (!$cena) {$cena="brak";$laczna="brak";}
	else
	{
	$laczna=$cena*$ilosc;
	$suma=$suma+$laczna;
	}	
	
	print("$nazwa - $ilosc $jednostka - $laczna zl ($cena zl za 1 $jednostka)<P>");
	
	
	}
	
	print("<P><B>Razem: $suma zl</b></p>");

	
}




############### podlicz_rachunki ###############

function podlicz_rachunki($tura)
{
	$query = "SELECT DISTINCT z.id_usera,u.nazwisko,p.nazwa, z.ilosc, p.jednostka, z.id, p.stan, z.id_produktu
				FROM spoldzielnia_produkty AS p 
				LEFT JOIN spoldzielnia_ceny_uzyskane AS cu ON cu.id_produktu=p.id 
				INNER JOIN spoldzielnia_zamowienia AS z ON z.id_produktu=p.id 
				INNER JOIN spoldzielnia_userzy AS u ON u.id=z.id_usera
				WHERE z.id_tury=$tura ORDER BY p.nazwa"; //  AND cu.id_tury=$tura
	
	$output = array();

	$wykonaj = mysql_query($query);

	while ($wiersz = mysql_fetch_array($wykonaj))
	{
		$id_usera = $wiersz['id_usera'];
		if(empty($output[$id_usera]['html']) || empty($output[$id_usera]['suma'])){
			$output[$id_usera]['html'] = '';
			$output[$id_usera]['suma'] = 0.0;
		}
		$nazwa=$wiersz['nazwa'];
		$jednostka=$wiersz['jednostka'];
		$ilosc=$wiersz['ilosc'];
//		$cena=$wiersz['cena'];
		$id=$wiersz['id_usera'];
		$id_zamowienia=$wiersz['id'];
		$id_produktu=$wiersz['id_produktu'];
		$stan=pokaz_stany($id_produktu); 		//$wiersz['stan'];	
		$query2 = "SELECT cena, id_tury from spoldzielnia_ceny_uzyskane WHERE id_produktu=$id_produktu ORDER BY id_tury DESC LIMIT 0,1";
		$res=mysql_fetch_array(mysql_query($query2));	
		$cena=$res[0];
		$id_tury_cena=$res[1]; 
		
		$output[$id_usera]['nazwisko'] = $wiersz['nazwisko'];
	

		if ($cena>0 && $id_tury_cena==$tura){
			$laczna=$cena*$ilosc;
			$output[$id_usera]['suma']+=$laczna;
			$output[$id_usera]['html'].="<P>$nazwa - $ilosc $jednostka - $laczna z³ ($cena z³ za 1 $jednostka).";
			$output[$id_usera]['html'].="---> <a href=\"zmien_zakup.php?id=$id_zamowienia\">zmieñ</a>";
			$output[$id_usera]['id']=$id;

			$output[$id_usera]['id_zamowienia']=$id_zamowienia;
		}	

		if ($stan>0 && $id_tury_cena!=$tura) {
			$laczna=$cena*$ilosc;
			$output[$id_usera]['suma']+=$laczna;
			$output[$id_usera]['html'].="<P>$nazwa - $ilosc $jednostka - $laczna z³ ($cena z³ za 1 $jednostka). Towar dostêpny w magazynie (tura nr $id_tury_cena)";
			$output[$id_usera]['html'].="---> <a href=\"zmien_zakup.php?id=$id_zamowienia\">zmieñ</a>";
			$output[$id_usera]['id']=$id;

			$output[$id_usera]['id_zamowienia']=$id_zamowienia;
			
		}	

	}

	return $output;
	
}

############### podlicz_rachunki_poj ###############


function podlicz_rachunki_poj($tura, $user)
{
	$query = "SELECT DISTINCT z.id_usera,u.nazwisko,p.nazwa, z.ilosc, p.jednostka, z.id, p.stan, z.id_produktu, c.koszt_trans
				FROM spoldzielnia_produkty AS p 
				LEFT JOIN spoldzielnia_ceny_uzyskane AS cu ON cu.id_produktu=p.id 
				INNER JOIN spoldzielnia_zamowienia AS z ON z.id_produktu=p.id 
				INNER JOIN spoldzielnia_userzy AS u ON u.id=z.id_usera
				INNER JOIN `spoldzielnia_tury_zakupow` AS c ON z.`id_tury` = c.`id`
				WHERE z.id_tury=$tura AND z.id_usera=$user ORDER BY z.id_produktu"; //  AND cu.id_tury=$tura
	
	$output = array();

	$wykonaj = mysql_query($query);

	while ($wiersz = mysql_fetch_array($wykonaj))
	{
		$id_usera = $wiersz['id_usera'];
		if(empty($output[$id_usera]['html']) || empty($output[$id_usera]['suma'])){
			$output[$id_usera]['html'] = '';
			$output[$id_usera]['suma'] = 0.0;
		}
		$nazwa=$wiersz['nazwa'];
		$jednostka=$wiersz['jednostka'];
		$ilosc=$wiersz['ilosc'];
//		$cena=$wiersz['cena'];
		$id=$wiersz['id_usera'];
		$id_zamowienia=$wiersz['id'];
		$id_produktu=$wiersz['id_produktu'];
		$stan=pokaz_stany($id_produktu);
		$query2 = "SELECT cena, id_tury from spoldzielnia_ceny_uzyskane WHERE id_produktu=$id_produktu ORDER BY id_tury DESC LIMIT 0,1";
		$res=mysql_fetch_array(mysql_query($query2));	
		$cena=$res[0];
		$id_tury_cena=$res[1]; 
		
		$output[$id_usera]['nazwisko'] = $wiersz['nazwisko'];
		$output[$id_usera]['koszt']=$wiersz['koszt_trans'];	
	

		if ($cena>0 && $id_tury_cena==$tura){
			$laczna=$cena*$ilosc;
			$output[$id_usera]['suma']+=$laczna;
			$output[$id_usera]['html'].="<P>$nazwa - $ilosc $jednostka - $laczna z³ ($cena z³ za 1 $jednostka).";
			$output[$id_usera]['id']=$id;
			$output[$id_usera]['id_zamowienia']=$id_zamowienia;
		}	

		if ($stan>0 && $id_tury_cena!=$tura) {
			$laczna=$cena*$ilosc;
			$output[$id_usera]['suma']+=$laczna;
			$output[$id_usera]['html'].="<P>$nazwa - $ilosc $jednostka - $laczna z³ ($cena z³ za 1 $jednostka). Towar dostêpny w magazynie (tura nr $id_tury_cena)";
			$output[$id_usera]['id']=$id;
			$output[$id_usera]['id_zamowienia']=$id_zamowienia;
			
		}	

	}

	return $output;
	
}



function podlicz_rachunki_ods($tura)
{
	$query = "SELECT p.id,z.id_usera,u.nazwisko,p.nazwa, cu.cena, z.ilosc, p.jednostka
				FROM spoldzielnia_produkty AS p 
				LEFT JOIN spoldzielnia_ceny_uzyskane AS cu ON cu.id_produktu=p.id 
				INNER JOIN spoldzielnia_zamowienia AS z ON z.id_produktu=p.id 
				INNER JOIN spoldzielnia_userzy AS u ON u.id=z.id_usera
				WHERE z.id_tury=$tura AND cu.id_tury=$tura";
	$output = array();

	$wykonaj = mysql_query($query);

	while ($wiersz = mysql_fetch_array($wykonaj))
	{
		$id_usera = $wiersz['id_usera'];
		if(empty($output[$id_usera]['suma'])){
			$output[$id_usera]['suma'] = 0.0;
		}
		if(empty($output[$id_usera][$wiersz['id']]) ){
			$output[$id_usera]['produkty'][$wiersz['id']] = array(
				'nazwa'=>$wiersz['nazwa'],
				'jednostka'=>$wiersz['jednostka'],
				'ilosc'=>$wiersz['ilosc'],
				'cena'=>$wiersz['cena']
			);
		}else{
			$output[$id_usera]['produkty'][$wiersz['id']]['ilosc']+=$wiersz['ilosc'];
		}
		$output[$id_usera]['nazwisko'] = $wiersz['nazwisko'];
		$output[$id_usera]['suma'] += $wiersz['ilosc']*$wiersz['cena'];
	}
	return $output;
}







############### lista_zakupów ###############


function pokaz_zakupy($tura)
{


	$query = "SELECT z.id_usera,u.nazwisko,p.nazwa, cu.cena, z.ilosc, p.jednostka
				FROM spoldzielnia_produkty AS p 
				LEFT JOIN spoldzielnia_ceny_uzyskane AS cu ON cu.id_produktu=p.id 
				INNER JOIN spoldzielnia_zamowienia AS z ON z.id_produktu=p.id 
				INNER JOIN spoldzielnia_userzy AS u ON u.id=z.id_usera
				WHERE z.id_tury=$tura AND cu.id_tury=$tura";
	$output = array();

	$wykonaj = mysql_query($query);

	while ($wiersz = mysql_fetch_array($wykonaj))
	{
		$id_usera = $wiersz['id_usera'];
		if(empty($output[$id_usera]['html']) || empty($output[$id_usera]['suma'])){
			$output[$id_usera]['html'] = '';
			$output[$id_usera]['suma'] = 0.0;
		}
		$nazwa=$wiersz['nazwa'];
		$jednostka=$wiersz['jednostka'];
		$ilosc=$wiersz['ilosc'];
		$cena=$wiersz['cena'];
		$output[$id_usera]['nazwisko'] = $wiersz['nazwisko'];

		if ($cena==0) {
			$cena="brak";
			$laczna="brak";
			$output[$id_usera]['html'].="<P>$nazwa - $ilosc $jednostka - nie uda³o siê kupiæ</P>";

		}else{
			$laczna=$cena*$ilosc;
			$output[$id_usera]['suma']+=$laczna;
			$output[$id_usera]['html'].="<P>$nazwa - $ilosc $jednostka - $laczna z³ ($cena z³ za 1 $jednostka)</P>";
		}	
	}

	return $output;
	
}




############### formularz_zamowienia ###############


function formularz_uzyskanych_cen()
{

}






############### suma_zamowien ###############


function suma_zamowien($tura)
{


	$query = "SELECT * FROM spoldzielnia_produkty ORDER BY nazwa";

	$wykonaj = mysql_query($query);
	
	
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{
	
		$id_produktu=$wiersz['id'];
		$jednostka=$wiersz['jednostka'];
		
		
		$podquery = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_tury=$tura AND id_produktu=$id_produktu)";

		$podwykonaj = mysql_query($podquery);
		
	
		$suma_wag=0;
	
		while ($podwiersz = mysql_fetch_array($podwykonaj))
	
		{

			$pid=$podwiersz['id'];
			$pid_produktu=$podwiersz['id_produktu'];
			$ilosc=$podwiersz['ilosc'];
			
			$suma_wag=$suma_wag+$ilosc;
	
		}
		
		if ($suma_wag) {
		print(nazwa_produktu($id_produktu)." - ".$suma_wag." ".$jednostka." <P>");}
		
		
	}	
	
	
}

############## rozlicz_zamowienie ###############


function rozlicz_zamowienie($tura)
{
	print ("	
	<form action=rozliczenie_zakupow_2.php method=\"post\">
	<table width=100% cellpadding=5>
	<tr><td><b>produkt</b></td><td><b>jednostka</b></td><td><b>ilo¶æ zamówiona</b></td><td><b>ilo¶æ kupiona</b></td><td><b>ilo¶æ kupiona</b></td><td><b>cena za jedn.</b></td><td><b>wprowad¼ cenê</b></td></tr>");

	$query = "SELECT * FROM spoldzielnia_produkty ORDER BY nazwa";
	$wykonaj = mysql_query($query);
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{
	
		$id_produktu=$wiersz['id'];
		$jednostka=$wiersz['jednostka'];
		
		
		$podquery = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_tury=$tura AND id_produktu=$id_produktu)";

		$podwykonaj = mysql_query($podquery);
		$wyk_cena = mysql_query("SELECT cena FROM spoldzielnia_ceny_uzyskane WHERE id_tury=$tura AND id_produktu=$id_produktu");
		$cena_q = mysql_fetch_array($wyk_cena);
		$cena = $cena_q['cena'];
		$suma_wag=0;
	
		while ($podwiersz = mysql_fetch_array($podwykonaj))
	
		{

			$pid=$podwiersz['id'];
			$pid_produktu=$podwiersz['id_produktu'];
			$ilosc=$podwiersz['ilosc'];
			$suma_wag=$suma_wag+$ilosc;
	
		}
		
		if ($suma_wag) {
		$nazwa_prod=nazwa_produktu($id_produktu);


		$quer=mysql_fetch_array(mysql_query("SELECT ilosc_doszla FROM spoldzielnia_transakcje WHERE id_produkt=$id_produktu AND id_tury=$tura"));
		if (!$ilo=$quer[0]) $ilo=0;
 
		
		
		print("<tr><td>$nazwa_prod</td><td>$jednostka</td><td> $suma_wag</td><td>$ilo</td><td><input value='' style=\"width:80px;height:50px;padding:5px;font-size:15px\" type=text  name=\"ilosc[$id_produktu]\"></td><td>$cena</td><td><input value='$cen' style=\"width:80px;height:50px;padding:5px;font-size:15px\" type=text  name=\"cena[$id_produktu]\"></td></tr> ");}

	}	
	
print ("</tr></table>");

	print ("<input type=submit value=wyslij></form></td></tr>");

}


############## zwieksz_stan ###############


function zwieksz_stan($id, $ilosc) {

$dot = mysql_fetch_row(mysql_query("SELECT stan FROM spoldzielnia_produkty WHERE id = $id"));
$dot_stan= $dot[0];
$ilosc += $dot_stan;
mysql_query ("UPDATE spoldzielnia_produkty SET stan=$ilosc WHERE id=$id");


}

############## popraw_stan ###############


function popraw_stan($id, $ilosc, $pop_ilosc) {

if ($ilosc>$pop_ilosc) {
	$ilosc -=$pop_ilosc;
}
else {
	$ilosc +=$pop_ilosc;
}

$dot = mysql_fetch_row(mysql_query("SELECT stan FROM spoldzielnia_produkty WHERE id = $id"));
$dot_stan= $dot[0];
$ilosc += $dot_stan;
mysql_query ("UPDATE spoldzielnia_produkty SET stan=$ilosc WHERE id=$id");


}

############## pokaz_stany ###############


function pokaz_stany($prod) {

if ($prod!=0) {
  	$q= mysql_query("SELECT a.id, a.nazwa, a.jednostka, b.nazwa, SUM( c.ilosc_doszla ) , SUM( c.ilosc_wyszla )
		FROM spoldzielnia_produkty AS a
		JOIN spoldzielnia_kategorie AS b ON ( a.kategoria = b.id )
		JOIN spoldzielnia_transakcje AS c ON ( a.id = c.id_produkt )
		WHERE a.id =$prod
		ORDER BY a.kategoria DESC ");
	$res=mysql_fetch_row($q);

	$id=$res[0];
	$nazwa=$res[1];
	$jednostka=$res[2];
	$kategoria=$res[3];
	$stanpl=$res[4];
	$stanmi=$res[5];
	return $stan = $stanpl-$stanmi;
}

else {
  $q1 = mysql_query("SELECT id, kategoria FROM spoldzielnia_produkty ORDER BY kategoria DESC");
  echo "<div class=pole> Nazwa produktu</div> <div class=pole>Kategoria </div> <div class=pole>Jednostka miary</div> <div class=pole> Stan magazynowy</div><br>";

  while($res1=mysql_fetch_array($q1)) {
	$id=$res1[0];
	$q= mysql_query("SELECT a.id, a.nazwa, a.jednostka, b.nazwa, SUM( c.ilosc_doszla ) , SUM( c.ilosc_wyszla )
		FROM spoldzielnia_produkty AS a
		JOIN spoldzielnia_kategorie AS b ON ( a.kategoria = b.id )
		JOIN spoldzielnia_transakcje AS c ON ( a.id = c.id_produkt )
		WHERE a.id =$id 
		ORDER BY a.kategoria DESC ");
	$res=mysql_fetch_row($q);

	$id=$res[0];
	$nazwa=$res[1];
	$jednostka=$res[2];
	$kategoria=$res[3];
	$stanpl=$res[4];
	$stanmi=$res[5];
	$stan = $stanpl-$stanmi;
   if ($stan !=0) {
	echo "<div class=tabelka>";
  if ($userek != 19) {
	echo "<div class=pole><a href=zob_transakcje.php?id=$id>" . $nazwa . "</a></div> <div class=pole>" . $kategoria . "</div> <div 	class=pole>" .  $jednostka . "</div> <div 		class=pole>" .  $stan . " " . $jednostka . "</div><br>";
  }	
  else {
	echo "<div class=pole>" . $nazwa . "</div> <div class=pole>" . $kategoria . "</div> <div 	class=pole>" .  $jednostka . "</div> <div 		class=pole>" .  $stan . " " . $jednostka . "</div><br>";

  }
	echo "</div>";
   }
  }
}
}

############## zobacz_transakcje ###############

function zobacz_transacje($id) {
$q = mysql_query ("SELECT a.data, b.nazwa, c.nazwisko, a.ilosc_doszla, a.ilosc_wyszla, b.jednostka, a.id_transakcji
FROM spoldzielnia_transakcje AS a
JOIN spoldzielnia_produkty AS b ON ( a.id_produkt = b.id )
JOIN spoldzielnia_userzy AS c ON ( a.id_user = c.id )
WHERE id_produkt =$id
ORDER BY a.data DESC , a.id_transakcji DESC");
	$sumapl=0.00;
	$sumami=0.00;

while ($res=mysql_fetch_array($q)) {
	$data=$res[0];
	$nazwa=$res[1];
	$nazwisko=$res[2];
	$stanpl=$res[3];
	$stanmi=$res[4];
	$jednostka=$res[5];
	$sumapl +=$stanpl;
	$sumami +=$stanmi;
	$stan = $sumapl-$sumami;
	if ($stanpl) {
	 $stanpl .= " " . $jednostka;
	}
	if ($stanmi) {
	 $stanmi .= " " . $jednostka;
	}
	echo "<div class=tabelka>";
	echo "<div class=pole2>" . $data . "</div><div class=pole2>" . $nazwa . "</div> <div class=pole2>" . $nazwisko . "</div> <div class=pole2>" .  $stanpl . "</div> <div class=pole2>" .  $stanmi . "</div><br>";

	echo "</div>";
}
	echo "<div class=tabelka>";
	echo "<div class=pole2> </div><div class=pole2> </div> <div class=pole2> </div> <div class=pole2><strong>" .  $sumapl ." " . $jednostka . "</strong></div> <div class=pole2><strong>" .  $sumami . " " . $jednostka . "</strong></div><br>";

	echo "</div>";

	echo "<div class=tabelka>";
	echo "<div class=pole2> </div><div class=pole2> </div> <div class=pole2> </div> <div class=pole2><strong>Stan aktualny: </strong></div> <div class=pole2><strong>" .  $stan . " " . $jednostka . "</strong></div><br>";

	echo "</div>";

}




############## zmniejsz_stan ###############


function zmniejsz_stan($id, $ilosc) {
$dot = mysql_fetch_row(mysql_query("SELECT stan FROM spoldzielnia_produkty WHERE id = $id"));
$dot_stan= $dot[0];
$dot_stan -= $ilosc;
mysql_query("UPDATE spoldzielnia_produkty SET stan=$dot_stan WHERE id=$id");


}


############## czy_aktywna ###############

function czy_aktywna() {
$tura = id_aktualnej_tury();
$q = "SELECT aktywna FROM spoldzielnia_tury_zakupow WHERE id = $tura";
$r = mysql_query($q);
$w = mysql_fetch_array($r);
$akt = $w[0];
return $akt;
}

############## czy_admin ###############

function czy_admim($id) {
$q=mysql_query("SELECT admin FROM spoldzielnia_userzy WHERE id=$id");
$r=mysql_fetch_array($q);
return $r[0];
}

############## pokaz_fundusz ###############

function pokaz_fundusz($userid) {
echo "Zestawienie wp³ywów i wydatków z funduszu gromadzkiego naszej kooperatywy. Uwzglêdnia operacje przeprowadzone po 6 kwietnia 2012 r (data dodania tej funkcji do naszego serwisu). <p>";
echo "<table border=0 width=100% class=\"fundusz\">";
echo "<tr> <td> <strong>data operacji</strong></td><td><strong>osoba dodaj±ca</strong><td style=\"text-align:right; padding-right:15px\"><strong>kwota operacji</strong></td><td style=\"text-align:right; padding-right:15px\"><strong>stan funduszu</strong></td><td style=\"text-align:centre; padding-right:15px\"><strong>opis</strong></td></tr>";
$admin = czy_admim($userid);
$q = mysql_query("SELECT f.id, u.nazwisko, f.data, f.kwota, f.stan, f.opis FROM spoldzielnia_fundusz AS f JOIN spoldzielnia_userzy AS u ON f.id_usera=u.id ORDER BY f.data DESC, f.id DESC");

while($r=mysql_fetch_array($q, MYSQL_NUM)) {
$id=$r[0];
$user=$r[1];
$data=$r[2];
$kwota=$r[3];
$stan=$r[4];
$opis=$r[5];
echo "<tr>";
print ("<td width=100px>$data</td> <td width=100px>$user</td> <td width=120px style=\"text-align:right; padding-right:15px\">$kwota</td> <td width=120px style=\"text-align:right; padding-right:15px\">$stan</td><td width=500px>$opis</td></tr>");
}

echo "</table>";

}

############## kto_kupuje ###############


function kto_kupuje() {
	$waga = array();	
	$id_tury = id_aktualnej_tury();
	$q1 = mysql_query("SELECT a.`id_osoba`, a.`rola`, b.`nazwisko` FROM `spoldzielnia_ludzie` AS a JOIN `spoldzielnia_userzy` AS b ON a.`id_osoba`=b.`id` WHERE `id_tura`=$id_tury");
	while ($w=mysql_fetch_array($q1)) {
		$us = $w[0];
		$pos = $w[1];		
		$naz = $w[2];
		switch ($pos) {
			case 1: $eko_kier = "<span class=gr>" . $naz . "</span>"; break;
			case 2: $eko_tow = "<span class=gr>" .$naz . "</span>"; break;
			case 3: $gie_kier = "<span class=gr>" .$naz . "</span>"; break;
			case 4: $gie_tow = "<span class=gr>" .$naz . "</span>"; break;
			case 5: array_push($waga, $naz); break;
		}	
	}
 	if (!$eko_kier) { $eko_kier="<span class=pogr>BRAK</span>"; }
 	if (!$eko_tow) { $eko_tow="<span class=pogr>BRAK</span>"; }
 	if (!$gie_kier) { $gie_kier="<span class=pogr>BRAK</span>"; }
 	if (!$gie_tow) { $gie_tow="<span class=pogr>BRAK</span>"; }

	echo "Osoby zg³oszone do udzia³u na najbli¿szych zakupach: <br>";
	echo "Zakupy ekoJuszkowo - kierowca/-czyni " .  $eko_kier . "; osoba towarzysz±ca: " . $eko_tow . "<br>";
	echo "Zakupy gie³da hurtowa - kierowca/-czyni " .  $gie_kier . "; osoba towarzysz±ca: " . $gie_tow . "<br>";
	echo "</span>Osoby do wa¿enia i podzia³u zakupów: " ;
	if (count($waga)<4) {
		$ile = 4;
	}
	else  {
		$ile = count($waga);
	}

	for ($i=0; $i<$ile; $i++) {
		$os = $waga[$i];
		if (!$os) {
			$os="BRAK";
		}
		$j = $i + 1;
		if ($os !="BRAK") {
			echo $j. " <span class=gr>" .  $os . "</span> | ";
		}
		else {
			echo $j. " <span class=pogr>" .  $os . "</span> | ";
		}
	}
	echo "<br>";
	$iile=count($waga);
	if ($eko_kier=="BRAK" || $eko_tow=="BRAK" || $gie_kier=="BRAK" || $gie_tow=="BRAK" || $iile<4) {
		echo "<p><span class=pogr>Uwaga! Jak dot±d brakuje pe³nej obsady najbli¿szych zakupów. W skrajnym wypadku mo¿e to oznaczaæ, ¿e zakupy nie bêd± siê mog³y odbyæ. Je¶li mo¿esz, kliknij <a href=zglos_udzial.php> tutaj</a> i zadeklaruj swój udzia³!</span><p>";
	}
	else {
		echo "<p>";
	}
}

############## zglos_udzial ###############

function zglos_udzial($id) {
	$waga = array();	
	$id_tury = id_aktualnej_tury();
	$q1 = mysql_query("SELECT a.`id_osoba`, a.`rola`, b.`nazwisko` FROM `spoldzielnia_ludzie` AS a JOIN `spoldzielnia_userzy` AS b ON a.`id_osoba`=b.`id` WHERE `id_tura`=$id_tury");
	while ($w=mysql_fetch_array($q1)) {
		$us = $w[0];
		$pos = $w[1];		
		$naz = $w[2];
		switch ($pos) {
			case 1: $eko_kier = $naz; break;
			case 2: $eko_tow = $naz; break;
			case 3: $gie_kier = $naz; break;
			case 4: $gie_tow = $naz; break;
			case 5: array_push($waga, $naz); break;
		}	
	}
	$q2 = mysql_query("SELECT `godz_waz` FROM `spoldzielnia_tury_zakupow` WHERE `id` =$id_tury");
	$w2 = mysql_fetch_array ($q2);
	$godzina_waz = $w2[0]; 

	$data = nazwa_aktualnej_tury();
	echo "<form method=POST action=zglos_udzial2.php>";
	echo "Je¶li mo¿esz pojechaæ na zakupy na gie³dê, pojechaæ odebraæ zakupy z gospodarstwa ekologicznego lub pomóc w wa¿eniu i podziale zakupów wybierz odpowiednie pole, poni¿ej.<p>";

	echo "Gospodarstwo ekologiczne w Juszkowie ko³o Pruszcza Gdañskiego:<P>";
	if (!$eko_kier) {
		echo "<label class=zglos><span>Tak! Pojadê do eko Juszkowa jako kierowca (mam samochód) :) </span><input type=checkbox name=eko_kier value=" . $id ."></label><p> ";
	}
	else {
		echo "<label class=zglos><span>Jako kierowca jedzie: </span><input value=$eko_kier disabled></label><p> ";
	}
	if (!$eko_tow) {
		echo "<label class=zglos><span>Tak! Pojadê do eko Juszkowa jako druga osoba :) </span><input type=checkbox name=eko_tow value=" . $id ."></label><p> ";
	}
	else {
		echo "<label class=zglos><span>Jako osoba tow. jedzie </span><input value=$eko_tow disabled></label><p> ";
	}
	echo "<br><hr>Hurtowa gie³da owocowo-warzywna:<P>";
	if (!$gie_kier) {
		echo "<label class=zglos><span> Pojadê na gie³dê jako kierowca (mam samochód) :) </span><input type=checkbox name=gie_kier value=" . $id ."></label><p> ";
	}
	else {
		echo "<label class=zglos><span>Jako kierowca jedzie </span><input value=$gie_kier disabled></label><p> ";
	}
	if (!$gie_tow) {
		echo "<label class=zglos><span> Tak!  Pojadê na gie³dê jako druga osoba :)</span><input type=checkbox name=gie_tow value=" . $id ."></label><p> ";
	}
	else {
		echo "<label class=zglos><span>Jako osoba tow. jedzie </span><input value=$gie_tow disabled ></label><p> ";
	}
	if (count($waga)<4) {
		$ile = 4;
	}
	else  {
		$ile = count($waga);
	}
	echo "<br><hr><p>Wa¿enie i podzia³ zakupów. Miejsce: Centrum spo³eczne MS, ul. Jana z Kolna 8. "  . $data . ", godz. " . $godzina_waz . ":<P>";
	for ($i=0; $i<$ile; $i++) {
		$os = $waga[$i];
		if (!$os) {
	echo "<label class=zglos><span>Tak! Wezmê udzia³ w wa¿eniu i podziale zakupów:)</span><input type=radio name=waz value=" . $id ."></label><p> ";
		}
		else {
			$j = $i + 1;
			echo "<label class=zglos><span> " . $j . ") " .  $os . " zadeklarowa³/a udzia³ w wa¿eniu zakupów. </span><input type=hidden></label><p>";
		}
	}
	echo "<br>";
	$iile=count($waga);

	echo "<input type=reset value=\"wyczy¶æ\"> ";
	echo "<input type=submit value=\"zatwierd¼\">";
	echo "</form>";


}


###################### modu³ statystyczny










function suma_tury($tura)
{

	$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_tury=$tura)";

	$wykonaj = mysql_query($query);
	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$id_produktu=$wiersz['id_produktu'];
	$ilosc=$wiersz['ilosc'];
	
	$nazwa=nazwa_produktu($id_produktu);
	
	$jednostka=jednostka_produktu($id_produktu);
	
	$tura2=$tura;
	
	$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura2 AND id_produktu=$id_produktu)";
		
	$wykonaj2= mysql_query($query2);
	$wiersz2=mysql_fetch_array($wykonaj2);
		
	$cena=$wiersz2['cena'];
		
	if (!$cena) {$cena="brak";$laczna="brak";}
	else
	{
	$laczna=$cena*$ilosc;
	$suma=$suma+$laczna;
	}	
	
	
	
	
	}
	
	$fundusz=$suma*0.10;
	$suma2=$suma+$fundusz;
	$suma2=money_format('%.2n', $suma2);
	

return ($suma);
	
}




function fundusz($tura)
{

	$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_tury=$tura)";

	$wykonaj = mysql_query($query);
	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$id_produktu=$wiersz['id_produktu'];
	$ilosc=$wiersz['ilosc'];
	
	$nazwa=nazwa_produktu($id_produktu);
	
	$jednostka=jednostka_produktu($id_produktu);
	
	$tura2=$tura;
	
	$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura2 AND id_produktu=$id_produktu)";
		
	$wykonaj2= mysql_query($query2);
	$wiersz2=mysql_fetch_array($wykonaj2);
		
	$cena=$wiersz2['cena'];
		
	if (!$cena) {$cena="brak";$laczna="brak";}
	else
	{
	$laczna=$cena*$ilosc;
	$suma=$suma+$laczna;
	}	
	
	
	
	
	}
	
	$fundusz=$suma*0.10;
	$suma2=$suma+$fundusz;
	$suma2=money_format('%.2n', $suma2);
	

return ($fundusz);
	
}



polacz_z_baza();







function sumuj_kase()
{

$tura=id_aktualnej_tury();

while ($tura>0)
{
$razem+=suma_tury($tura);
$tura--;

}

return $razem;

}


function sumuj_fundusz()
{

$tura=id_aktualnej_tury();

while ($tura>0)
{
$razem+=fundusz($tura);
$tura--;

}

return $razem;

}







function suma_produktu($id)
{

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
	
	$suma+=$zakup;
	
	}
	
	
	$suma=money_format('%.2n', $suma);
	

return ($suma);
	
}


function suma_produktu2($id)
{

	$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_produktu=$id AND id_tury>2)";

	$wykonaj = mysql_query($query);
	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$id_produktu=$wiersz['id_produktu'];
	$ilosc=$wiersz['ilosc'];
	$tura=$wiersz['id_tury'];
	$cena=znajdz_cene($id_produktu,$tura);
	
	$zakup=$cena*$ilosc;
	
	$suma+=$zakup;
	
	}
	
	
	$suma=money_format('%.2n', $suma);
	

return ($suma);
	
}





function najpopularniejsze_produkty_cena()
{


	$query = "SELECT * FROM spoldzielnia_produkty";

	$wykonaj = mysql_query($query);
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{
	
	$id=$wiersz['id'];
	$nazwa=$wiersz['nazwa'];
	$suma=suma_produktu($id);
	$nazwy[]=$nazwa;
	$kasa[]=$suma;
	
	
	
	}
	
	array_multisort($kasa,SORT_DESC,$nazwy);
	
	
$ilosc_elementow = count($nazwy);

//przechodzimy po wszystkich kluczach tablicy i wypisujemy ich warto¶æ
for($x = 0; $x < 10; $x++) {

if ($kasa[$x]>0)
	{    echo '<tr><td>'; echo $x+1; echo '. '.$nazwy[$x] . '</td><td>' . $kasa[$x] . ' z³</td></tr>';}
}

print("</table>");

	
	





}



function cena_z_tury($id,$tura)
{


$query2="SELECT * FROM spoldzielnia_ceny_uzyskane WHERE (id_tury=$tura AND id_produktu=$id)";
		
		$wykonaj2= mysql_query($query2);
		$wiersz2=mysql_fetch_array($wykonaj2);
		
		$cena=$wiersz2['cena'];

return $cena;

}



function najpopularniejsze_produkty_zamowienia()
{


	$query = "SELECT * FROM spoldzielnia_produkty";

	$wykonaj = mysql_query($query);
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{
	
	$id=$wiersz['id'];
	$nazwa=$wiersz['nazwa'];
	$suma=suma_produktu2($id);
	$nazwy[]=$nazwa;
	$kasa[]=$suma;
	
	
	
	}
	
	array_multisort($kasa,SORT_DESC,$nazwy);
	
	
$ilosc_elementow = count($nazwy);

//przechodzimy po wszystkich kluczach tablicy i wypisujemy ich warto¶æ
for($x = 0; $x < 10; $x++) {

if ($kasa[$x]>0)
	{    echo '<tr><td>'; echo $x+1; echo '. '.$nazwy[$x] . '</td><td>' . $kasa[$x] . ' z³</td></tr>';}
}

print("</table>");

	
	





}






function najpopularniejsze_produkty_kilogramy()
{


	$query = "SELECT * FROM spoldzielnia_produkty WHERE jednostka='kg'";

	$wykonaj = mysql_query($query);
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{
	
	$id=$wiersz['id'];
	$nazwa=$wiersz['nazwa'];
	$suma=suma_ilosci_produktu($id);
	$nazwy[]=$nazwa;
	$kasa[]=$suma;
	
	
	
	}
	
	array_multisort($kasa,SORT_DESC,$nazwy);
	
	
$ilosc_elementow = count($nazwy);

//przechodzimy po wszystkich kluczach tablicy i wypisujemy ich warto¶æ
for($x = 0; $x < 10; $x++) {

if ($kasa[$x]>0)
	{    echo '<tr><td>'; echo $x+1; echo '. '.$nazwy[$x] . '</td><td>' . $kasa[$x] . ' kg</td></tr>';}
}

print("</table>");

	
	





}



function suma_ilosci_produktu($id)
{

	$query = "SELECT * FROM spoldzielnia_zamowienia WHERE (id_produktu=$id AND id_tury>2)";

	$wykonaj = mysql_query($query);
	
	$suma=0;
	
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{

	$id=$wiersz['id'];
	$id_produktu=$wiersz['id_produktu'];
	$ilosc=$wiersz['ilosc'];
	
	
	$suma+=$ilosc;
	
	}
	
	
	$suma=money_format('%.2n', $suma);
	

return ($suma);
	
}







function lacznie_kilogramow()
{


	$query = "SELECT * FROM spoldzielnia_produkty WHERE jednostka='kg'";

	$wykonaj = mysql_query($query);
	
	$all=0;
	while ($wiersz = mysql_fetch_array($wykonaj))
	
	{
	
	$id=$wiersz['id'];
	$nazwa=$wiersz['nazwa'];
	$suma=suma_ilosci_produktu($id);
	$all+=$suma;
	
	
	
	}
	
	return $all;
	
	





}








?>
