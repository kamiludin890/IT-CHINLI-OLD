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
$pemutusan_kontrak=$_POST['pemutusan_kontrak'];
$lanjut_kontrak=$_POST['lanjut_kontrak'];
$keterangan=$_POST['keterangan'];
$kontrak_ke=$_POST['kontrak_ke'];
$id_item=$_POST['id_item'];

if ($id_item) {
$no=0;for($i=0; $i < count($_POST['id_item']); ++$i){
	mysql_query("UPDATE hrd_data_pengajuan_kontrak_items SET pemutusan_kontrak='$pemutusan_kontrak[$no]',lanjut_kontrak='$lanjut_kontrak[$no]',keterangan='$keterangan[$no]',kontrak_ke='$kontrak_ke[$no]' WHERE id='$id_item[$no]'");
$no++;}
}//UPDATE SELESAI ARRAY DARI FINISH END


//DELETE
$id_delete=$_POST['id_delete'];
if ($id_delete) {
	$no=0;for($i=0; $i < count($_POST['id_delete']); ++$i){
		if ($id_delete[$no]){
			mysql_query("DELETE FROM hrd_data_pengajuan_kontrak_items WHERE id='$id_delete[$no]'");

			mysql_query("DELETE FROM hrd_data_masakerja WHERE id_pengajuan_items='$id_delete[$no]'");
		}
	$no++;}
}//DELETE END


$column_header='nik,nama,bagian,tanggal_masuk,kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2,pemutusan_kontrak,lanjut_kontrak,kontrak_ke,keterangan,kontrak_sebelum,masa_kontrak,cuti,ijin,dokter,alpa,sp,masa_berlaku';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);

echo "<form method='POST' action='#'>";
echo "<table class='tabel_utama' style='width:auto;'>";
	//HEADER TABEL
	echo "<thead>";
		echo "<th style=''><strong>No</strong></th>";
	$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
		$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column_header[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);
		echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
	$no++;}
		echo "<th><input type='image' src='../../modules/gambar/delete.png' width='25' height'25' name='simpan' value='Simpan'></th>";
	echo "</thead>";
	//HEADER END


//ISI TABEL
//nilai_ppn,bayar,catatan
$result=mysql_query("SELECT * FROM hrd_data_pengajuan_kontrak_items WHERE induk='$id'");
$urut=1;
while ($rows=mysql_fetch_array($result)) {
	echo "<tr style='height:50px;'>";
	echo "<td>$urut</td>";
		$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
			//nilai_ppn
			if ($pecah_column_header[$no]=='pemutusan_kontrak') {
				echo "<td>";
				if ($rows[$pecah_column_header[$no]]=='v'){$checked='checked';}else{$checked='';}
				echo "<input type='checkbox' name='pemutusan_kontrak[]' value='v' $checked>";
			echo "</td>";
			}
			//bayar
			elseif ($pecah_column_header[$no]=='lanjut_kontrak') {
				echo "<td><input type='text' name='lanjut_kontrak[]' value='".$rows[$pecah_column_header[$no]]."' style='width:23px; text-align:right;'> Bulan</td>";
			}
			//catatan
			elseif ($pecah_column_header[$no]=='keterangan') {
				echo "<td><textarea name='keterangan[]' rows='3' cols='30'>".$rows[$pecah_column_header[$no]]."</textarea></td>";
			}
			//catatan
			elseif ($pecah_column_header[$no]=='kontrak_ke') {
				echo "<td>
				<select class='comboyuk' name='kontrak_ke[]'>
				<option value='".$rows[$pecah_column_header[$no]]."'>".$rows[$pecah_column_header[$no]]."</option>";
				echo "<option value=''></option>";
				echo "<option value='1'>1</option>";
				echo "<option value='2'>2</option>";
				echo "
				</select>
				</td>";
			}
			//NORMAL
			else{
				echo "<td>".$rows[$pecah_column_header[$no]]."</td>";
			}
		$no++;}

				echo "<input type='hidden' name='id_item[]' value='$rows[id]'>";

		echo "<td>";
			echo "<input type='checkbox' name='id_delete[]' value='$rows[id]'>";
		echo "</td>";

	echo "</tr>";
$urut++;}

echo "<tr><td colspan='21'><input type='image' src='../../modules/gambar/save.png' width='30' height'30' name='simpan' value='Simpan'></td></tr>";
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
