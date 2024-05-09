<?php session_start(); error_reporting(0);

include('../koneksi.php');

$connection=mysql_connect(s('db_server'), s('db_user'), s('db_password')) or die(mysql_error()) ;
mysql_select_db(s('db_name'));

if(isset($_GET['bhs'])){$_SESSION['bahasa']=$_GET['bhs'];}
if(isset($_SESSION['bahasa'])){$bhs=$_SESSION['bahasa']; } else {$bhs='ina';}

function l($id){ extract($GLOBALS);
 	$result=mysql_query("SELECT $bhs FROM master_bahasa where kode='$id'");  
	$r=mysql_fetch_array($result);
	return $r[0];
}

require_once "excelexport.php";
$xls = new ExcelExport();
  

$table=$_GET['table'];
$m=$_GET['m'];
$query=$_SESSION['myquery'];


$result=mysql_query($query) or die ("Sql error : " . mysql_error());
$fields = mysql_num_fields ($result);
for ( $i = 0; $i < $fields; $i++ ){$header1[]= l(mysql_field_name( $result , $i )); }
$xls->addRow($header1);


for ( $i = 0; $i < $fields; $i++ ){$header[]= mysql_field_name( $result , $i ); }
while ($row = mysql_fetch_assoc($result)) { 
for ( $i = 0; $i < $fields; $i++ ) { $kolom=$header[$i];$data[$i]=$row[$kolom];}
$xls->addRow($data);
}
$xls->download("$table.xls");

?>
