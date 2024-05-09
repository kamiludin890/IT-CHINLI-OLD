<?php global $mod;
	$mod='hrddata/ijinabsensi';
function editmenu(){extract($GLOBALS);}

function ambil_variabel($nama_database,$kolom) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode('","', $datasecs);
	$hasil='"'.$data.'"';
return $hasil;}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function total_masuk_per_dokumen($id,$kodebarang,$nama,$satuan){
$sql="SELECT masuk FROM inventory_distribusi_items WHERE induk='$id' AND kodebarang='$kodebarang' AND nama='$nama' AND satuan='$satuan'";
$result=mysql_query($sql);
while ($rows=mysql_fetch_array($result)){
	$total_masuk=$rows[masuk]+$total_masuk;
}
return $total_masuk;}

function home(){extract($GLOBALS);
include ('function.php');

$column_header='tanggal,nik,nama,bagian,jenis_ijin,keterangan_ijin';
$column='ket_revisi,tanggal,id_pegawai,jenis_ijin,keterangan_ijin,pembuat,tgl_dibuat';//kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2,

$nama_database='hrd_data_absensi';
//$nama_database_items='admin_purchasing_items';

$address='?mod=hrddata/ijinabsensi';

if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}


if (base64_decrypt($_GET['opsi'],"XblImpl1!A@")=='item') {
$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$nomor_halaman=$_GET['halaman'];
$pilihan_tahun=$_GET['pilihan_tahun'];
$pilihan_bulan=$_GET['pilihan_bulan'];
$pilihan_pencarian=$_GET['pilihan_pencarian'];
$pencarian=$_GET['pencarian'];}
if ($_POST[opsi]=='item') {
$opsi=$_POST['opsi'];
$id=$_POST['id'];
$nomor_halaman=$_POST['halaman'];
$pilihan_tahun=$_POST['pilihan_tahun'];
$pilihan_bulan=$_POST['pilihan_bulan'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];
$pencarian=$_POST['pencarian'];}



//START ITEM
if ($opsi=='item'){

//ALL ONE
echo kalender();
echo combobox();
include 'style.css';


	//Kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	echo "</td>";
	echo "</tr></table>";
	//Kembali END









}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
