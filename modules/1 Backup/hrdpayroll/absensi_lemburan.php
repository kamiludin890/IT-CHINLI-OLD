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

function tampilan_tgl($tanggal){
	$jumlah_karakter=strlen($tanggal);

	if ($jumlah_karakter=='1') {
		$show="0$tanggal";
	}else {
		$show="$tanggal";
	}

return $show;}


function buat_list_checkbox($list_akses,$jumlah_list_akses){
		$no=0;for($i=0; $i < $jumlah_list_akses; ++$i){
			$datasecs[]="".$list_akses[$no]."";
		$no++;}
			$data=implode(",", $datasecs);
return $data;}

function ambilhari($tanggal){
	//fungsi mencari namahari
	//format $tgl YYYY-MM-DD
	//harviacode.com
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
	switch($info){
			case '0': return "Minggu"; break;
			case '1': return "Senin"; break;
			case '2': return "Selasa"; break;
			case '3': return "Rabu"; break;
			case '4': return "Kamis"; break;
			case '5': return "Jumat"; break;
			case '6': return "Sabtu"; break;
	};
}

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

$nama_database='hrd_payroll_absensi';
$nama_database_items='hrd_payroll_absensi_items';

$pencarian=$_POST['pencarian'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];

echo "<title>Lemburan</title>";


//delete
$id_delete=$_POST['id_delete'];
if ($_POST['id_delete']) {
	$urut_del=0;for($i_del=0; $i_del < count($_POST['id_delete']); ++$i_del){
		mysql_query("DELETE FROM $nama_database_items WHERE id_pegawai='$id_delete[$urut_del]' AND induk='$id'");
	$urut_del++;}
}else{}
//delete end


//UPDATE CHECK BOX
if ($_POST['save_list']) {
	$list_pilihan=buat_list_checkbox($_POST['id_pegawai'],count($_POST['id_pegawai']));
	$nilai_column_id=count($_POST['id_pegawai']);

	$id_pegawai=$_POST['id_pegawai'];
	$tanggal=$_POST['tanggal'];

	$lembur_1=$_POST['lembur_1'];
	$lembur_2=$_POST['lembur_2'];
	$lembur_3=$_POST['lembur_3'];
	$lembur_4=$_POST['lembur_4'];


	$urut=0;for($i=0; $i < $nilai_column_id; ++$i){

		mysql_query("UPDATE $nama_database_items SET
			lembur_1='$lembur_1[$urut]',
			lembur_2='$lembur_2[$urut]',
			lembur_3='$lembur_3[$urut]',
			lembur_4='$lembur_4[$urut]'
		WHERE id_pegawai='$id_pegawai[$urut]' AND tanggal='$tanggal[$urut]'");

	$urut++;}
//
// echo "<script type='text/javascript'>window.close();</script>";
}
//UPDATE CHECK BOX END


echo "<form method='POST'>";
echo "<input type='hidden' name='save_list' value='1'></td>";
echo "<table>";
	echo "<tr>";
		echo "<td><input type='image' src='../../modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";
	echo "</tr>";
echo "</table>";

//TAMPILAN TABEL
echo "<table class='tabel_utama'>";

//START THEAD
echo "<thead>";
	echo "<th rowspan='2'><input type='image' src='../../modules/gambar/delete.png' width='25' height'25' name='simpan' value='Simpan'></th>";
	echo "<th rowspan='2'>Nik</th>";
	echo "<th rowspan='2'>Nama</th>";
	echo "<th rowspan='2'>Bagian</th>";

	$tahun_gaji=ambil_database(tahun_gaji,$nama_database,"id='$id'");
	$bulan_gaji=ambil_database(bulan_gaji,$nama_database,"id='$id'");
	$jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"bulan='".ambil_database(bulan_gaji,$nama_database,"id='$id'")."' AND tahun='".ambil_database(tahun_gaji,$nama_database,"id='$id'")."'");
	$no_tgl=1;for($i=0; $i < $jumlah_hari; ++$i){

		$tgl_only=tampilan_tgl($no_tgl);
		$tanggal="$tahun_gaji-$bulan_gaji-$tgl_only";
		$nama_hari=ambilhari("$tanggal");
		if ($nama_hari=='Minggu'){$color_hari='yellow';}else{$color_hari='white';}
				echo "<th colspan='4' style='background-color:$color_hari; white-space:nowrap;'>$nama_hari</br>$tanggal";
				echo "</th>";
		$no_tgl++;}

		echo "<tr>";
		for($i_th=0; $i_th < $jumlah_hari; ++$i_th){
			echo "<th>OT 1.5</th>";
			echo "<th>OT 2</th>";
			echo "<th>OT 3</th>";
			echo "<th>OT 4</th>";
		}
		echo "</tr>";

echo "</thead>";
//START THEAD END


//START TABEL


$result2=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id' GROUP BY id_pegawai");
$no2=1;
while ($rows2=mysql_fetch_array($result2)) {

echo "<tr>";
		echo "<td><input type='checkbox' name='id_delete[]' value='$rows2[id_pegawai]'></td>";
		echo "<td class='sticky-col zero-col'>$rows2[nik]</td>";
		echo "<td class='sticky-col first-col'>$rows2[nama]</td>";
		echo "<td class='sticky-col second-col'>$rows2[bagian]</td>";

		$no_tgl2=1;for($i=0; $i < $jumlah_hari; ++$i){
			$tgl_only=tampilan_tgl($no_tgl2);
			$tanggal="$tahun_gaji-$bulan_gaji-$tgl_only";

			$lembur_1=ambil_database(lembur_1,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$lembur_2=ambil_database(lembur_2,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$lembur_3=ambil_database(lembur_3,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$lembur_4=ambil_database(lembur_4,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");


									echo "<td><input type='text' style='width:45px; text-align:center;' name='lembur_1[]' value='$lembur_1'></td>";
									echo "<td><input type='text' style='width:45px; text-align:center;' name='lembur_2[]' value='$lembur_2'></td>";
									echo "<td><input type='text' style='width:45px; text-align:center;' name='lembur_3[]' value='$lembur_3'></td>";
									echo "<td><input type='text' style='width:45px; text-align:center;' name='lembur_4[]' value='$lembur_4'></td>";

									echo "<input type='hidden' name='id_pegawai[]' value='$rows2[id_pegawai]'>";
									echo "<input type='hidden' name='tanggal[]' value='$tanggal'>";

		$no_tgl2++;}
echo "</tr>";
$no2++;}
echo "</form>";





//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END

//echo "<script type='text/javascript'>window.close();</script>";
?>
