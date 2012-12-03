<?php
if (ereg('iPhone',$_SERVER['HTTP_USER_AGENT'])) {
$iphone = 1;
} 
elseif (ereg('iPod',$_SERVER['HTTP_USER_AGENT'])) {
$iphone = 1;
} 
else {
$iphone = 0;
}


if ($iphone==0)

{

?>

<HTML>
<HEAD>
<title>Spoldzielnia</title>
<meta http-equiv="Content-type" content="text/html;charset=iso-8859-2">
	<link rel="stylesheet" href="desktop.css" />

<script type="text/javascript" charset="iso8859-2">
		window.onload = function() {
		  setTimeout(function(){window.scrollTo(0, 1);}, 100);
		}
	</script>
	<script type="text/javascript">
	function clickclear(thisfield, defaulttext) {
	if (thisfield.value == defaulttext) {
	thisfield.value = "";
	}
	}
	function clickrecall(thisfield, defaulttext) {
	if (thisfield.value == "") {
	thisfield.value = defaulttext;
	}
	}
	
	</script>

</HEAD>
<BODY>
<div id="konteiner">



<?

}

else

{

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=iso-8859-2">
	<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>Kooperatywa</title>
	<link rel="stylesheet" href="stylesheets/iphone.css" />
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
	<script type="text/javascript" charset="iso8859-2">
		window.onload = function() {
		  setTimeout(function(){window.scrollTo(0, 1);}, 100);
		}
	</script>
	<script type="text/javascript">
	function clickclear(thisfield, defaulttext) {
	if (thisfield.value == defaulttext) {
	thisfield.value = "";
	}
	}
	function clickrecall(thisfield, defaulttext) {
	if (thisfield.value == "") {
	thisfield.value = defaulttext;
	}
	}
	
	</script>

</head>



<?

}

?>




