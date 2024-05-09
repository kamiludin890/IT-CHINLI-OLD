<?php
require_once "../../koneksi.php";

$connection=mysql_connect(s('db_server'), s('db_user'), s('db_password')) or die(mysql_error()) ;
mysql_select_db(s('db_name'));

$q = strtolower($_GET["q"]);
if (!$q) return;

$t=$_GET['t'];

$sql = "select DISTINCT keterangan as keterangan, id, debit, kredit from $t where keterangan LIKE '%$q%'";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$a1 = $rs['keterangan'];
	$a2 = $rs['id'];
	$a3 = $rs['debit'];
	$a4 = $rs['kredit'];
	echo "$a1|$a2|$a3|$a4\n";
}
?>
