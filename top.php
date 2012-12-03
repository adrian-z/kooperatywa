<html>
<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"/> 


<link rel="stylesheet" href="style.css" type="text/css" media="screen">
 <script type="text/javascript">
        var GB_ROOT_DIR = "./greybox/";
    </script>

    <script type="text/javascript" src="greybox/AJS.js"></script>
    <script type="text/javascript" src="greybox/AJS_fx.js"></script>
    <script type="text/javascript" src="greybox/gb_scripts.js"></script>
    <link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />

    <script type="text/javascript" src="static_files/help.js"></script>
    <link href="static_files/help.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>

<div id=naglowek>
<?
include("funkcje.php");
polacz_z_baza();

$nazwisko=nazwisko_uzytkownika($_SESSION["userid"]);
$email=email_uzytkownika($_SESSION["userid"]);
$user = $_SESSION["userid"];

print($nazwisko." (".$email.")");
print("&nbsp;&nbsp;&nbsp;&nbsp;Najblizsze  (".id_aktualnej_tury().") zakupy: ");
print(nazwa_aktualnej_tury());
print("<br>");
?>

<img src=naglowek.png style="margin:auto">
<ul>

<li><a href="admin.php">Zamów produkty</a></li>
<li><a href="koszyk.php">Zobacz koszyk</a></li>
<li><a href="starerachunki.php">Moje rachunki</a></li>
<li><a href="stan.php">Na stanie</a></li>
<li><a href="suma.php">Suma zamówień</a></li>
<li><a href="fundusz.php">Fundusz gromadzki</a></li>
<?
if ($user !=19) {
	print ("<li><a href=\"zmiana_hasla.php\">Zmień hasło</a></li>");
}
?>
<li><a href="wyloguj.php">Wyloguj</a></li>
</ul>
</div>

<div id=glowny>
