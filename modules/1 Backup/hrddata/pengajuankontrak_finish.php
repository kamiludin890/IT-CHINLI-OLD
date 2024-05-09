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

function tampil_sp($id_pegawai,$kontrak_terakhir_1,$kontrak_terakhir_2,$jenis_show){

	$result=mysql_query("SELECT * FROM hrd_data_sp WHERE id_pegawai='$id_pegawai' AND tanggal_berlaku_sp BETWEEN '$kontrak_terakhir_1' AND '$kontrak_terakhir_2'");
	while ($rows=mysql_fetch_array($result)) {

		if ($rows[sp]) {
			$show="$rows[sp]";
			$show_bulan="$rows[tanggal_berlaku_sp]";
		}else{
			$show='';
			$show_bulan='';
		}

$datasecs[]=$show;
$datasecs_bulan[]=$show_bulan;
	}
$data=implode("</br>", $datasecs);
$data_bulan=implode("</br>", $datasecs_bulan);

if ($jenis_show=='nilai_sp') {
	$nilai=$data;
}elseif ($jenis_show=='tanggal_berlaku_sp') {
	$nilai=$data_bulan;
}

return "$nilai";}


function nama_bulan($tanggal){
	$nilai_bulan=substr($tanggal,5,2);
	if ($nilai_bulan=='01'){$bulan='Januari';}
	elseif ($nilai_bulan=='02'){$bulan='Februari';}
	elseif ($nilai_bulan=='03'){$bulan='Maret';}
	elseif ($nilai_bulan=='04'){$bulan='April';}
	elseif ($nilai_bulan=='05'){$bulan='Mei';}
	elseif ($nilai_bulan=='06'){$bulan='Juni';}
	elseif ($nilai_bulan=='07'){$bulan='Juli';}
	elseif ($nilai_bulan=='08'){$bulan='Agustus';}
	elseif ($nilai_bulan=='09'){$bulan='September';}
	elseif ($nilai_bulan=='10'){$bulan='Oktober';}
	elseif ($nilai_bulan=='11'){$bulan='November';}
	elseif ($nilai_bulan=='12'){$bulan='Desember';}
	else {$bulan='';}
return $bulan;}


function kontrak_sebelum($id_pegawai,$kontrak_awal1,$kontrak_awal2,$kontrak_akhir1,$kontrak_akhir2,$penentu){

if($kontrak_awal2!='' AND $kontrak_akhir2==''){$kontrak_ke=1; $tanggal_start=$kontrak_awal1;}
elseif($kontrak_awal2!='' AND $kontrak_akhir2!=''){$kontrak_ke=2; $tanggal_start=$kontrak_akhir1;}
else{$kontrak_ke=''; $tanggal_start='';}


$result=mysql_query("SELECT * FROM hrd_data_masakerja WHERE id_pegawai='$id_pegawai' AND kontrak_ke='$kontrak_ke' ORDER BY urutan");
$urutan=1;
while ($rows=mysql_fetch_array($result)) {

		$bulan_terakhir=$rows[tambah_kontrak];
		$tambah_bulan=$bulan_terakhir+$tambah_bulan;

		if($kontrak_ke=='2'){
		$nilai=date('Y-m-d',strtotime("+$tambah_bulan Months", strtotime($tanggal_start)));
		$untuk_kontrak_2=$nilai;
		}
		elseif ($kontrak_ke=='1') {
		$nilai_belum_dikurang_satuhari=date('Y-m-d',strtotime("+$tambah_bulan Months", strtotime($tanggal_start)));
		$nilai=date('Y-m-d',strtotime("-1 Days", strtotime($nilai_belum_dikurang_satuhari)));
		$untuk_kontrak_2=$nilai_belum_dikurang_satuhari;
		}
		else{$nilai='';}

		$nama_bulan_nilai=nama_bulan($nilai);

		$nilai1=date('Y-m-d',strtotime("-$bulan_terakhir Months", strtotime($untuk_kontrak_2)));
		$nama_bulan_nilai1=nama_bulan($nilai1);

//		echo "$rows[urutan] - $rows[tambah_kontrak]>>> $nilai1 s/d $nilai>>> $nama_bulan_nilai1 s/d $nama_bulan_nilai</br>";

$urutan++;}

//		echo "$bulan_terakhir Bulan>>> $nilai1 s/d $nilai>>> $nama_bulan_nilai1 s/d $nama_bulan_nilai</br>";

if ($penentu=='kontrak_terakhir_1') {
	$show="$nilai1";
}
elseif($penentu=='kontrak_terakhir_2') {
	$show="$nilai";
}
elseif($penentu=='kontrak_sebelum') {
	if ($bulan_terakhir!='') {$tampil_bulan='Bulan';}else{$tampil_bulan='';}
	$show="$bulan_terakhir $tampil_bulan";
}
elseif($penentu=='masa_kontrak') {
	if ($nama_bulan_nilai1!='') {$tampil_sd='s/d';}else{$tampil_sd='';}
	$show="$nama_bulan_nilai1 $tampil_sd $nama_bulan_nilai";
}
else {
	$show='';
}
return $show;}


function absensi($id_pegawai,$kontrak_terakhir_1,$kontrak_terakhir_2,$jenis_ijin){

}


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

$column_header='tanggal,nik,status_pegawai,nama,tanggal_masuk,bagian,kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);

$pencarian=$_POST['pencarian'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];

echo "<title>Finish</title>";


//UPDATE FINISH
mysql_query("UPDATE hrd_data_pengajuan_kontrak SET status='Selesai',validasi='Valid' WHERE id='$id'");

		$result=mysql_query("SELECT * FROM hrd_data_pengajuan_kontrak_items WHERE induk='$id' AND lanjut_kontrak NOT LIKE ''");
		while ($rows=mysql_fetch_array($result)) {
			$id_pegawai="$rows[id_pegawai]";
			$tanggal=ambil_database(tanggal,hrd_data_pengajuan_kontrak,"id='$rows[induk]'");
			$nik="$rows[nik]";
			$nama="$rows[nama]";
			$bagian="$rows[bagian]";
			$tanggal_masuk="$rows[tanggal_masuk]";
			$kontrak_tahun_kesatu="$rows[tanggal_masuk]";
			$kontrak_ke="$rows[kontrak_ke]";

			$id_pengajuan="$rows[induk]";
			$id_pengajuan_items="$rows[id]";

			$urutan=mysql_num_rows(mysql_query("SELECT * FROM hrd_data_masakerja WHERE id_pegawai='$id_pegawai'"))+1;
			$tambah_kontrak="$rows[lanjut_kontrak]";

			mysql_query("INSERT INTO hrd_data_masakerja SET
					id_pegawai='$id_pegawai',
					tanggal='$tanggal',
					nik='$nik',
					nama='$nama',
					bagian='$bagian',
					tanggal_masuk='$tanggal_masuk',
					kontrak_tahun_kesatu='$kontrak_tahun_kesatu',
					urutan='$urutan',
					tambah_kontrak='$tambah_kontrak',
					kontrak_ke='$kontrak_ke',
					id_pengajuan='$id_pengajuan',
					id_pengajuan_items='$id_pengajuan_items'
			");

		}
//UPDATE FINISH END


//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END

echo "<script type='text/javascript'>window.close();</script>";
?>
