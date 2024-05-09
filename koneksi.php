<?php

function s($variable) {	$s = array();
	$s['db_server'] = 'localhost:3318';
	$s['db_user'] = 'root';
	$s['db_password'] = 'merdeka170845';
	$s['db_name'] = 'sb_dagang';
	$s['sis_theme'] = 'themes/outlook.html';
	return $s[$variable];
}


$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);

require_once('addon/maxchart/maxChart.class.php');

?>
