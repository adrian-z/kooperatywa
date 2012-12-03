<?php
//if they haven't pressed the submit button, then show the form
if (!isset($_POST['submit']))
{

?>
<?include("naglowek.php"); ?>
<h2>Logowanie</h2>
<form action="<?$_SERVER['PHP_SELF']?>" method="post">
<div>
Login: <input type="text" name="username" /><br />
Has這: <input type="password" name="password" /><br />
<input type="submit" name="submit" value="Zaloguj" /><br />
</div>
</form>
</body>
</html>

<?php
}
else //otherwise, let's process this stuff
{

include("../funkcje.php");

polacz_z_baza();

$email=$_POST['username'];
$haslo=crypt($_POST['password'], 'sjajja982u2washshy7278191hsbhga7a09aha');

$query="SELECT * FROM spoldzielnia_userzy WHERE (email='$email' AND haslo='$haslo' AND admin=1)";


$wykonaj=mysql_query($query);
$wiersz = mysql_fetch_array($wykonaj);

$userid=$wiersz['id'];

$ilosc=mysql_num_rows($wykonaj);



if($ilosc>0) //if they got it right, let's go on

{
session_start();
session_register("spoldzielnia_admin"); //set a variable for use later
$id = session_id(); //let's grab the session ID for those who don't have cookies
$_SESSION["userid"] = $userid; 
$url = "Location: admin.php?sid=" . $id;
header($url);
}
else //they got something wrong and we should tell them
{
?>

<html>
<head>
<title>Logowanie</title>
</head>
<body>
<span style="color:#ff0000;">Login/has這 nieprawid這we</span><br />
<form action="<?$PHP_SELF?>" method="post">
<div>
Login: <input type="text" name="username" /><br />
Has這: <input type="password" name="password" /><br />
<input type="submit" name="submit" value="Zaloguj" /><br />
</div>
</form>
</body>
</html>

<?php
}
}
?>

