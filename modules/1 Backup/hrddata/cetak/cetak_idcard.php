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
include ('../style.css');
error_reporting(0);
$nama_database='hrd_data_karyawan';
//$nama_database_items='deliverycl_invoice_items';

//AMBIL POST
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$induk_no_invoice=ambil_database(no_invoice,deliverycl_invoice,"id='$id'");
$bahasa='ina';
$username=$_GET['username'];

$list_pilihan=base64_decrypt($_GET['id_download'],"XblImpl1!A@");
$pecah_column_isi=explode (",",$list_pilihan);
$total_data=$_GET['td'];
//AMBIL POST END

//TITLE
echo "<html>
<head><title>Cetak ID CARD</title></head>
<body>";
//END TITLE


$jumlah_baris_kebawah=ceil($total_data/3);
$jumlah_table_kebawah=ceil($jumlah_baris_kebawah/3);

	$no=1;for($i=0; $i < $jumlah_table_kebawah; ++$i){
	echo "<div class='pagebreak'>";
	echo "<table align='center' style='	border:1px solid #999; width:auto; height:auto;'>";//width:570; height:912px;
	$no=8+$no;
	$total_awal_table=$no-11;

							$no_2=$total_awal_table;for($i_2=0; $i_2 < 3; ++$i_2){
							$no_2=2+$no_2;
								echo "<tr>";

													$no_3=$no_2;for($i_3=0; $i_3 < 3; ++$i_3){
														$id_pegawai=$pecah_column_isi[$no_3];
														$nama_gambar_tampilan=ambil_database(foto,$nama_database,"id='$id_pegawai'");

																echo "<td style='width:188px; height:302px; border:1px solid; vertical-align: text-top;'>";

																echo "<table style='font-size:14px;'>";

																echo "<tr><td colspan='3' style='padding-bottom:10px;'><center>";
																echo "<img src='../gambarkaryawan/logo.png' width='100%;' height='40px'/>";
																echo "</center></td></tr>";

																echo "<tr><td colspan='3'  style='padding-bottom:10px;'><center>";
																if ($nama_gambar_tampilan) {
																	echo "<img src='../gambarkaryawan/$nama_gambar_tampilan' width='100px' height='120px'/>";
																}else {
																	echo "<img src='../gambarkaryawan/keren.gif' loop='infinite' width='100px' height='120px'/>";
																}
																echo "</center></td></tr>";

																echo "<tr>";
																echo "<td style='padding-left: 10px;'>Nik</td><td>:</td><td>".ambil_database(nik,$nama_database,"id='$id_pegawai'")."</td>";
																echo "</tr>";

																echo "<tr>";
																echo "<td style='padding-left: 10px;'>Nama</td><td>:</td><td>".ambil_database(nama,$nama_database,"id='$id_pegawai'")."</td>";
																echo "</tr>";

																echo "<tr>";
																echo "<td style='padding-left: 10px;'>Bagian</td><td>:</td><td>".ambil_database(bagian,$nama_database,"id='$id_pegawai'")."</td>";
																echo "</tr>";

																echo "<tr>";
																echo "<td style='padding-left: 10px;'>Tgl.Masuk</td><td>:</td><td>".ambil_database(tanggal_masuk,$nama_database,"id='$id_pegawai'")."</td>";
																echo "</tr>";

																echo "</table>";

																echo "</td>";

																// echo "<td style='width:188px; height:302px; border:1px solid; text-align:center;'>";
																// 	echo "<a>TEST</a>";
																// echo "</td>";

													$no_3++;}


								echo "</tr>";
							$no_2++;}

	echo "</table>";
	echo "</div>";
	$no++;}





//PERINTAH PRINT
echo "<script>";
echo "
var css = '@page { size: portrait; }',
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
