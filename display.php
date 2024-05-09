<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Stokbarang</title>
<style type="text/css">
<!--
BODY {
font-family: Verdana, Trebuchet MS;
background-color:black;
background-position: center 240px;
}

p {
	font-size:16px;
	color:#003300;
}
input {
    border: 1px solid #006;
    background:black;
	color:green; 
	 border:none;
	text-align:left;
}
-->
</style>
</head>
<body>
<?php
$des=$_GET['d'];
$val=$_GET['v'];
function rp($rupiah){ return number_format($rupiah);}

$nilai=rp($val);

echo "<input value='$des' size='16' style='font-size:45px;'> .'<br>";
echo "<input value='$nilai' size='16' style='font-size:45px;'> .'<br>";

?>



</body>
</html>


