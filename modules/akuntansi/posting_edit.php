<?php
session_start();
ob_start();
error_reporting(0);
include('../../../koneksi.php');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);

//KONEKSI DATABASE
function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function kalender(){
		echo "
		<link rel='stylesheet' href='../tools/kalender_combo/jquery-ui.css'>
		<link rel='stylesheet' href='/resources/demos/style.css'>
		<script src='../tools/kalender_combo/jquery-1.12.4.js'></script>
		<script src='../tools/kalender_combo/jquery-ui.js'></script>

		<script>
		$( function() {
			$( '.date' ).datepicker({
				dateFormat: 'yy-mm-dd'
			});
		} );
		</script>
		</head>
		<body>";
		//<label >Date:</label>
		//<input type='text' id='date'>
return;}

function combobox(){
	echo "
	 <link href='../tools/kalender_combo/select2.min.css' rel='stylesheet' />
	 <script src='../tools/kalender_combo/select2.min.js'></script>

	<script type='text/javascript'>
	 $(document).ready(function() {
	     $('.comboyuk').select2();
	 });
	</script>";
return;}

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

function ambil_variabel_tanpa_kutip_where_distinct($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT DISTINCT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode(",", $datasecs);
	$hasil="".$data."";
return $hasil;}

function qty_proses_per_size($po_nomor,$line_batch,$nama_kolom,$logo){
	$result=mysql_query("SELECT qty FROM deliverycl_invoice_items WHERE po_nomor='$po_nomor' AND line_batch='$line_batch' AND logo='$logo' AND size='$nama_kolom'");
	while ($rows=mysql_fetch_array($result)){
		$qty_telah_sent=$rows[qty]+$qty_telah_sent;
	}
	//$ambil_variabel_size1=ambil_variabel_tanpa_kutip_where_distinct(planningcls_spklaminating_qty_proces,induk,"WHERE po_nomor='$po_nomor_qty_proces' AND line_batch='$line_batch_qty_proces' ORDER BY induk");
	//$pecah_size1=pecah($ambil_variabel_size1);
	//$nilai_pecah_size1=nilai_pecah($ambil_variabel_size1);
	//$no_size1=0;for($i_size1=0; $i_size1 < $nilai_pecah_size1; ++$i_size1){
	//$nilai_qty_size1=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$pecah_size1[$no_size1]' AND logo='$logo'")+$nilai_qty_size1;
	//$no_size1++;}
return $qty_telah_sent;}

function tamount_bayar($nomor_aju,$jenis_doc,$id_posting){
	$result5=mysql_query("SELECT bayar FROM akuntansi_posting WHERE nomor_aju='$nomor_aju' AND jenis_doc='$jenis_doc' AND id NOT LIKE '$id_posting'");
	while ($rows5=mysql_fetch_array($result5)) {
		$tamount=$rows5[bayar]+$tamount;

	}
return $tamount;}

function buat_list_checkbox($list_akses,$jumlah_list_akses){
		$no=0;for($i=0; $i < $jumlah_list_akses; ++$i){
			$datasecs[]="".$list_akses[$no]."";
		$no++;}
			$data=implode(",", $datasecs);
return $data;}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
return $hasil_rupiah;}
?>

<?php
include 'style.css';
echo kalender();
echo combobox();
$bahasa=ina;
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");

//TITLE
echo "<html>
<meta charset='UTF-8'>
<head><title>Edit</title></head>
<body>";
//END TITLE


//UPDATE SELESAI ARRAY DARI FINISH
$nilai_ppn=$_POST['nilai_ppn'];
$bayar=$_POST['bayar'];
$catatan=$_POST['catatan'];
$id_item=$_POST['id_item'];
$nomor_aju=$_POST['nomor_aju'];
$jenis_doc=$_POST['jenis_doc'];

if ($id_item) {
$no=0;for($i=0; $i < count($_POST['id_item']); ++$i){

$harga_penyerahan=ambil_database(harga_penyerahan,inventory_distribusi,"jenis_doc='$jenis_doc[$no]' AND nomor_aju='$nomor_aju[$no]'");
$sudah_dibayarkan=tamount_bayar($nomor_aju[$no],$jenis_doc[$no],$id_item[$no])+$bayar[$no];

//if ($sudah_dibayarkan>$harga_penyerahan) {
//	echo "<h3 style='background-color:yellow;'>Nilai Harga Melebihi Harga Penyerahan</h3>";
//}else {
	$total_ppn=$bayar[$no]*$nilai_ppn[$no]/100;
	$hasil_bayar=$bayar[$no]+$total_ppn;
	mysql_query("UPDATE akuntansi_posting SET bayar='$bayar[$no]',nilai_ppn='$nilai_ppn[$no]',jumlah_ppn='$hasil_bayar',catatan='$catatan[$no]',ppn='$total_ppn',nominal_debit='$hasil_bayar',nominal_kredit='$hasil_bayar' WHERE id='$id_item[$no]'");
//}

$no++;}
}//UPDATE SELESAI ARRAY DARI FINISH END


//DELETE
$id_delete=$_POST['id_delete'];
if ($id_delete) {
	$no=0;for($i=0; $i < count($_POST['id_delete']); ++$i){
		if ($id_delete[$no]){
			mysql_query("DELETE FROM akuntansi_posting WHERE id='$id_delete[$no]'");
		}
	$no++;}
}//DELETE END


$column_header='ref,jenis_doc,kontak,tanggal_doc,nomor_aju,invoice_faktur,bayar,nilai_ppn,ppn,jumlah_ppn,catatan';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);

echo "<form method='POST' action='#'>";
echo "<table class='tabel_utama' style='width:auto;'>";
	//HEADER TABEL
	echo "<thead>";
		echo "<th style=''><strong>No</strong></th>";
	$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
		$sql3="SELECT $bahasa,kode FROM master_bahasa WHERE kode='$pecah_column_header[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);
		echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
	$no++;}
		echo "<th><input type='image' src='../../modules/gambar/delete.png' width='25' height'25' name='simpan' value='Simpan'></th>";
	echo "</thead>";
	//HEADER END


//ISI TABEL
//nilai_ppn,bayar,catatan
$result=mysql_query("SELECT * FROM akuntansi_posting WHERE induk='$id'");
$urut=1;
while ($rows=mysql_fetch_array($result)) {
	echo "<tr style='height:50px;'>";
	echo "<td>$urut</td>";
		$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
			//nilai_ppn
			if ($pecah_column_header[$no]=='nilai_ppn') {
				echo "<td><input type='text' name='nilai_ppn[]' value='".$rows[$pecah_column_header[$no]]."' style='width:50px; text-align:right;'></td>";
			}
			//bayar
			elseif ($pecah_column_header[$no]=='bayar') {
				echo "<td><input type='text' name='bayar[]' value='".$rows[$pecah_column_header[$no]]."' style='width:120px; text-align:right;'></td>";
			}
			//catatan
			elseif ($pecah_column_header[$no]=='catatan') {
				echo "<td><input type='text' name='catatan[]' value='".$rows[$pecah_column_header[$no]]."' style='width:160px; text-align:right;'></td>";
			}
			//NORMAL
			else{
				echo "<td>".$rows[$pecah_column_header[$no]]."</td>";
			}
		$no++;}

		echo "<input type='hidden' name='id_item[]' value='$rows[id]'>";
		echo "<input type='hidden' name='nomor_aju[]' value='$rows[nomor_aju]'>";
		echo "<input type='hidden' name='jenis_doc[]' value='$rows[jenis_doc]'>";


		echo "<td>";
			echo "<input type='checkbox' name='id_delete[]' value='$rows[id]'>";
		echo "</td>";

	echo "</tr>";
$urut++;}

echo "<tr><td colspan='12'><input type='image' src='../../modules/gambar/save.png' width='30' height'30' name='simpan' value='Simpan'></td></tr>";
echo "</form>";
echo "</table>";
//ISI TABEL END




//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END
?>
