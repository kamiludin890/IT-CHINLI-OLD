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

function tamount_bayar($nomor_aju,$jenis_doc){
	$result5=mysql_query("SELECT bayar FROM akuntansi_posting WHERE nomor_aju='$nomor_aju' AND jenis_doc='$jenis_doc'");
	while ($rows5=mysql_fetch_array($result5)) {
		$tamount=$rows5[bayar]+$tamount;

	}
return $tamount;}

function tamount_ppn($nomor_aju,$jenis_doc){
	$result5=mysql_query("SELECT ppn FROM akuntansi_posting WHERE nomor_aju='$nomor_aju' AND jenis_doc='$jenis_doc'");
	while ($rows5=mysql_fetch_array($result5)) {
		$tamount=$rows5[ppn]+$tamount;

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


//tambah
	//ISIAN KOLOM DARI HEADER
	$tanggal=ambil_database(tanggal,akuntansi_posting_master,"id='$id'");
	$kode=ambil_database(kode,akuntansi_posting_master,"id='$id'");
	$keterangan=ambil_database(keterangan,akuntansi_posting_master,"id='$id'");
	$id_persamaan=ambil_database(persamaan,akuntansi_posting_master,"id='$id'");
	$persamaan=ambil_database(keterangan,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
	$debit=ambil_database(debit,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
	$kredit=ambil_database(kredit,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
	$kredit_kedua=ambil_database(kredit_kedua,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
	$pembuat=ambil_database(pembuat,akuntansi_posting_master,"id='$id'");
	$keterangan_debit=ambil_database(nama,akuntansi_akun,"nomor='$debit'");
	$keterangan_kredit=ambil_database(nama,akuntansi_akun,"nomor='$kredit'");
	$keterangan_kredit_kedua=ambil_database(nama,akuntansi_akun,"nomor='$kredit_kedua'");
	$kode_keterangan_debit="$debit - $keterangan_debit";
	$kode_keterangan_kredit="$kredit - $keterangan_kredit";
	$kode_keterangan_kredit_kedua="$kredit_kedua - $keterangan_kredit_kedua";
	$jenis_kas=ambil_database(jenis_kas,akuntansi_posting_master,"id='$id'");
	$tanggal_input=ambil_database(tgl_dibuat,akuntansi_posting_master,"id='$id'");
	$kurs=ambil_database(kurs,financecl_kurs,"tanggal='$tanggal'");
	$tgl_id=date("Y-m-d h:i:sa");$ref_jurnal=preg_replace('/\D/', '', $tgl_id);
	$id_jurnal=$ref_jurnal;
	$ref=$ref_jurnal;
	//ISIAN KOLOM DARI HEADER END

	//INSERT INTO
	mysql_query("INSERT INTO akuntansi_posting SET
		induk='$id',
		kode='$kode',
		tanggal='$tanggal',
		keterangan='$keterangan',
		id_persamaan='$id_persamaan',
		persamaan='$persamaan',
		debit='$debit',
		kredit='$kredit',
		kredit_kedua='$kredit_kedua',
		pembuat='$pembuat',
		kode_keterangan_debit='$kode_keterangan_debit',
		kode_keterangan_kredit='$kode_keterangan_kredit',
		kode_keterangan_kredit_kedua='$kode_keterangan_kredit_kedua',
		keterangan_debit='$keterangan_debit',
		keterangan_kredit='$keterangan_kredit',
		keterangan_kredit_kedua='$keterangan_kredit_kedua',
		jenis_kas='$jenis_kas',
		tanggal_input='$tanggal_input',
		id_jurnal='$id_jurnal',
		ref='$ref',
		-- jenis_doc='$jenis_doc',
		-- kontak='$kontak',
		-- tanggal_doc='$tanggal_doc',
		-- nomor_aju='$nomor_aju',
		-- invoice_faktur='$invoice_faktur',
		kurs='$kurs'
		-- nominal_debit='$nominal_debit',
		-- nominal_kredit='$nominal_kredit',
		-- nominal_kredit_kedua='$nominal_kredit_kedua',
		-- bayar='$bayar'
		");
	//INSERT INTO END
//tambah END




//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END

echo "<script type='text/javascript'>window.close();</script>";
?>
