<?php
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

// $sql1="SELECT * FROM inventory_distribusi WHERE id >='1813799'";
// $sql1run = mysql_query($sql1);
// while($row1=mysql_fetch_array($sql1run)){
//     $induk = $row1['id'];
//     $tanggal = $row1['tanggal'];
//     mysql_query("UPDATE inventory_distribusi_items SET tanggal='$tanggal' WHERE induk='$induk'");
// }

$sql1="SELECT * FROM inventory_distribusi_items WHERE id >='1813799'";
$sql1run = mysql_query($sql1);
while($row1=mysql_fetch_array($sql1run)){
    $tanggal = ambil_database(tanggal,inventory_distribusi,"id='$row1[induk]'");
    mysql_query("UPDATE inventory_distribusi_items SET tanggal='$tanggal' WHERE id='$row1[id]'");

    echo "UPDATE inventory_distribusi_items SET tanggal='$tanggal' WHERE id='$row1[id]'"."</br>";
}

?>