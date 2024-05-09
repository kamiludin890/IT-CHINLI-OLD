<?php
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
$id = $_GET['id'];
$query = mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE id='$id'");
$row = mysql_fetch_array($query);
if(mysql_query("UPDATE akuntansiv3_faktur_masukkan SET tipe='tidak tampil' WHERE id ='$id'")){
    echo"<script>window.location.href=('http://192.168.2.16:8098/index.php?menu=home&mod=akuntansiv3/fakturmasukkan_dev')</script>";
}
?>