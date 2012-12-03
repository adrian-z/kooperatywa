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

	include("top.php");
	polacz_z_baza();
	$user=$_SESSION["userid"];
	$tura=id_aktualnej_tury();
?>

<h1>Dodawanie pozycji przychodów/wydatków w funduszu gromadzkim</h1>


<form action="dodaj_fundusz2.php" method=POST>

	Dzieñ:<input type="text" name="dzien" value="" id="some_name" onclick="clickclear(this, 'Dzien')" onblur="clickrecall(this,'Dzien')" size=7 />, Miesi±c: 
	<input type="text" name="miesiac" value="" id="some_name" onclick="clickclear(this, 'Miesi±c')" onblur="clickrecall(this,'Miesi±c')" size=7 />, Rok: 
	<input type="text" name="rok" value="" id="some_name" onclick="clickclear(this, 'Rok')" onblur="clickrecall(this,'Rok')" size=7 />
	<i>Pozostaw puste, je¶li data ma byæ dzisiejsza </i>
	</p>
	Kwota: <input type="text" name="kwota" value="" id="some_name" onclick="clickclear(this, 'Kwota')" onblur="clickrecall(this,'Kwota')" /> <i>U¿yj znaku "-" dla oznaczenia wyp³at z funduszu!</i>
	</p>
	Opis:<br> <textarea rows="4" cols="20" name="opis">

	</textarea><p>

<input class="button white" type=submit value=dodaj>
</form>




<?
?>
<?php
}
?> 

</div>

