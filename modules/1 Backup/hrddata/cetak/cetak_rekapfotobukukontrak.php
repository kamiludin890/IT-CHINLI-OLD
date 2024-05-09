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
//AMBIL POST END

//TITLE
echo "<html>
<head><title>Rekap Foto Buku Kontrak</title></head>
<body>";
//END TITLE


$column_header='nama,tanggal_masuk,bagian,keterangan';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);


//HEADER TABEL
echo "<table class='tabel_utama' style='width:100%;'>";
echo "<thead>";
echo "<th>NO</th>";
echo "<th>Nik</th>";
echo "<th>Foto</th>";
$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
	echo "<th><strong>".ambil_database($bahasa,pusat_bahasa,"kode='".$pecah_column_header[$no]."'")."</strong></th>";
$no++;}
echo "</thead>";
//HEADER TABEL END


$query=mysql_query("SELECT * FROM hrd_data_karyawan WHERE id IN ($list_pilihan)");
$no_urut=1;
while ($rows1=mysql_fetch_array($query)) {

echo "<tr>";
echo "<td>$no_urut</td>";
echo "<td>$rows1[nik]</td>";
if ($rows1[foto]) {
	echo "<td><img src='../gambarkaryawan/$rows1[foto]' width='80px' height='100px'/></td>";
}else {
	echo "<td><img src='../gambarkaryawan/keren.gif' width='80px' height='100px'/></td>";
}
echo "<td>$rows1[nama]</td>";
echo "<td>$rows1[tanggal_masuk]</td>";
echo "<td>$rows1[bagian]</td>";
echo "<td></td>";
echo "</tr>";

$no_urut++;}


echo "</table>";






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
