function wplaty (id) {
if (id=="") {
	document.getElementById("wpl_sum").innerHTML="";
  return;
}
if (window.XMLHttpRequest) { 				// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else {							// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  } 
xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("wpl_sum").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","daj_wplaty.php?id="+id,true);
xmlhttp.send();
}
