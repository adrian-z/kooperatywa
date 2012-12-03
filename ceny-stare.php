<html>
<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"/> 


<link rel="stylesheet" href="style.css" type="text/css" media="screen">
</head>
<body>

<?


include("funkcje.php");







polacz_z_baza();

$towar=$_GET['id'];

$nazwa_produktu=nazwa_produktu($towar);
print("<H2>$nazwa_produktu</H2>");





$tura=id_aktualnej_tury();

$sumasredniej=0;
$iloscsredniej=0;

while ($tura>3)
{
$tura--;

$wydruk=cena_z_tury($towar,$tura);
if ($wydruk==0) {$wydruk="-";}
else
{$wydruk=round($wydruk,2);$sumasredniej+=$wydruk;$iloscsredniej++;}


$nazwa_tury=nazwa_tury($tura);
$naekran.="<tr><td style=\"border:1px solid black;background-color:#eeeeee;padding:10px;\">$nazwa_tury</td><td style=\"border:1px solid black;background-color:#eeeeee;padding:10px;\">$wydruk zł</td></tr>";


}	


if ($iloscsredniej>0)
{
print("ceny zakupu w poprzednich turach<p>");
print("<P>Zakupiono: $iloscsredniej razy<P>Średnia cena: <b>".round($sumasredniej/$iloscsredniej,2)." zł</b><P>");

Print("<table>$naekran</table>");

}


else

{

print("Jeszcze nigdy nie kupowaliśmy tego towaru.");

}


	
	
	
	

?>
