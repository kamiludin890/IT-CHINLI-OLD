<?php //KONEKSI DATABASE
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
//KONEKSI DATABASE?>

<?php // START FUNCTION

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

	function base64_decrypt($enc_text, $password, $iv_len = 16)
	{
	$enc_text = str_replace('@', '+', $enc_text);
	$enc_text = base64_decode($enc_text);
	$n = strlen($enc_text);
	$i = $iv_len;
	$plain_text = '';
	$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
	while ($i < $n) {
	$block = substr($enc_text, $i, 16);
	$plain_text .= $block ^ pack('H*', md5($iv));
	$iv = substr($block . $iv, 0, 512) ^ $password;
	$i += 16;
	}
	return preg_replace('/\\x13\\x00*$/', '', $plain_text);
	}
	function get_rnd_iv($iv_len)
	{
	$iv = '';
	while ($iv_len-- > 0) {
	$iv .= chr(mt_rand() & 0xff);
	}
	return $iv;
	}//// ENKRIPSI END

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

// START FUNCTION ?>

<?php // START AREA PRINT
error_reporting(0);
$nama_database='inventory_distribusi_items';
//$nama_database_items='deliverycl_invoice_items';

//AMBIL POST
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$induk_no_invoice=ambil_database(no_invoice,deliverycl_invoice,"id='$id'");
$bahasa='ina';
$username=$_GET['username'];
$nama_database='hrd_data_pengajuan_kontrak';
$nama_database_items='hrd_data_pengajuan_kontrak_items';


//TITLE
echo "<html>
<title>Dokumen</title>
<meta charset='UTF-8'>
<body>";
//END TITLE

include ('../style.css');

//HEADER
echo "<h3>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</h3>";
echo "<h3 style='text-align:center;'>Data Pengajuan Perpanjangan Kontrak Karyawan</h3>";
echo "<h3 style='text-align:center;'>Bulan ".ambil_database(bulan_pengajuan,$nama_database,"id='$id'")." ".ambil_database(tahun_pengajuan,$nama_database,"id='$id'")."</h3>";
echo "<h3 style='text-align:center;'>Bagian ".ambil_database(bagian,$nama_database,"id='$id'")."</h3>";
//HEADER END



//ARRAY HEADER
$column_header='nik,nama,bagian,tanggal_masuk,kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2,pemutusan_kontrak,lanjut_kontrak,keterangan,kontrak_sebelum,masa_kontrak,cuti,ijin,dokter,alpa,sp,masa_berlaku';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);
//ARRAY HEADER


//SHOW TABEL
echo "<table class='tabel_utama' style='width:auto;'>";
	//HEADER TABEL
	echo "<thead>";
		echo "<th style=''><strong>No</strong></th>";

	$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
		$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column_header[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);

		if ($pecah_column_header[$no]=='nik') {
			echo "<th><strong>工號</br>".$rows3[$bahasa]."</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='nama') {
			echo "<th><strong>員工姓名</br>".$rows3[$bahasa]."</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='bagian') {
			echo "<th><strong>單位</br>".$rows3[$bahasa]."</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='tanggal_masuk') {
			echo "<th><strong>入境日期</br>".$rows3[$bahasa]."</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='kontrak_awal1') {
			echo "<th><strong>續簽合同一年</br>Kntrk  Thn (ke-I)</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='kontrak_awal2') {
			echo "<th><strong>合同到期日</br>Jatuh tempo kontrak</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='kontrak_akhir1') {
			echo "<th><strong>續簽合同一年</br>Perpanjang Kntrk 1 th (ke-II)</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='kontrak_akhir2') {
			echo "<th><strong>合同到期日</br>Jatuh tempo kontrak</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='pemutusan_kontrak') {
			echo "<th><strong>解决合同</br>".$rows3[$bahasa]."</strong></th>";
		}
		elseif ($pecah_column_header[$no]=='lanjut_kontrak') {
			echo "<th><strong>繼續簽合同</br>".$rows3[$bahasa]."</strong></th>";
		}
		else{
			echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
		}

	$no++;}

	echo "</thead>";
	//HEADER END



	$result1=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
	$urut=1;
	while ($rows1=mysql_fetch_array($result1)) {

		echo "<tr style='height:30px;'>";
			echo "<td>$urut</td>";
		$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
			echo "<td>".$rows1[$pecah_column_header[$no]]."</td>";
		$no++;}
		echo "</tr>";

	$urut++;}

	echo "</table>";









//PERINTAH PRINT
echo "<script>";
echo "
var css = '@page { size: landscape; }',
head = document.head || document.getElementsByTagName('head')[0],
style = document.createElement('style');
style.type = 'text/css';
style.media = 'print';
if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}
head.appendChild(style);
window.print();
</script>";
//PERINTAH PRINT END


echo "
</body>
</html>";
 // END AREA PRINT ?>
