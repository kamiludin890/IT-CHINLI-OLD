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

function ambil_variabel_tanpa_kutip_where_distinct($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT DISTINCT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode(",", $datasecs);
	$hasil="".$data."";
return $hasil;}

function npwp($nilai){
	$NPWP2=substr($nilai,0,2);
	$NPWP3=substr($nilai,2,3);
	$NPWP4=substr($nilai,5,3);
	$NPWP5=substr($nilai,8,1);
	$NPWP6=substr($nilai,9,3);
	$NPWP7=substr($nilai,12,3);
	$nilai1="$NPWP2.$NPWP3.$NPWP4.$NPWP5-$NPWP6.$NPWP7";
	return $nilai1;}
?>

<?php
include 'style.css';
echo kalender();
echo combobox();
$bahasa=ina;

//TITLE
echo "<html>
<meta charset='UTF-8'>
<head><title>Import Master Karyawan</title></head>
<body>";
//END TITLE



//Jalankan Perintah Import
if ($_POST['eksekusi_import']) {
	include 'excel_reader2.php';
	// upload file xls
	$target = basename($_FILES['pelengkap']['name']) ;
	move_uploaded_file($_FILES['pelengkap']['tmp_name'], $target);
	// beri permisi agar file xls dapat di baca
	chmod($_FILES['pelengkap']['name'],0777);
	// mengambil isi file xls
	$data = new Spreadsheet_Excel_Reader($_FILES['pelengkap']['name'],false);
	// menghitung jumlah baris data yang ada


//SHEET 1
$tanggal=date('Y-m-d');
	$jumlah_baris = $data->rowcount($sheet_index=0);
	for ($i=2; $i<=$jumlah_baris; $i++){
		$no='';
		$nik=$data->val($i, 2, 0);
		$status_pegawai=$data->val($i, 3, 0);
		$nama=$data->val($i, 4, 0);
		$tanggal_masuk=$data->val($i, 5, 0);
		$bagian=$data->val($i, 6, 0);
		$ktp=$data->val($i, 7, 0);
		$npwp=$data->val($i, 8, 0);
		$tempat_lahir=$data->val($i, 9, 0);
		$tanggal_lahir=$data->val($i, 10, 0);
		$umur='';
		$jenis_kelamin=$data->val($i, 12, 0);
		$status_perkawinan=$data->val($i, 13, 0);
		$no_rekening=$data->val($i, 14, 0);
		$jumlah_anak=$data->val($i, 15, 0);
		$agama=$data->val($i, 16, 0);
		$alamat_ktp=$data->val($i, 17, 0);
		$alamat_domisili=$data->val($i, 18, 0);
		$pendidikan_terakhir=$data->val($i, 19, 0);
		$jurusan=$data->val($i, 20, 0);
		$tahun_lulus=$data->val($i, 21, 0);
		$nomor_hp=$data->val($i, 22, 0);
		$nomor_hp_keluarga=$data->val($i, 23, 0);
		$nomor_kartu_jamsostek=$data->val($i, 24, 0);
		$nomor_kartu_dana_pensiun=$data->val($i, 25, 0);
		$no_kartu_bpjs=$data->val($i, 26, 0);
		$kode_jabatan=$data->val($i, 27, 0);
		$upah_pokok=$data->val($i, 28, 0);
		$upah_tunjangan=$data->val($i, 29, 0);
		$upah_total='';
		$status_karyawan=$data->val($i, 31, 0);
		$masa_kerja='';
		$kontrak_awal1='';
		$kontrak_awal2='';
		$lama_kontrak1='';
		$kontrak_akhir1='';
		$kontrak_akhir2='';
		$lama_kontrak2='';
		$sp='';
		$cuti=$data->val($i, 40, 0);
		$cuti_yang_diambil='';
		$sisa_cuti='';
		$referensi=$data->val($i, 43, 0);
		$nilai_mtk=$data->val($i, 44, 0);
		$status_vaksin=$data->val($i, 45, 0);
		$status_vaksin2=$data->val($i, 46, 0);
		$bersedia_keluar_kota=$data->val($i, 47, 0);
		$id_card=$data->val($i, 48, 0);
		$keterangan_mutasi=$data->val($i, 49, 0);
		$surat_pernyataan=$data->val($i, 50, 0);
		$status_update='';


if (ambil_database(nik,hrd_data_karyawan,"nik='$nik' AND status_pegawai='Aktif'")=='' AND $nik!='') {

		mysql_query("INSERT INTO hrd_data_karyawan SET
			tanggal='$tanggal',
			nik='$nik',
			status_pegawai='$status_pegawai',
			nama='$nama',
			tanggal_masuk='$tanggal_masuk',
			bagian='$bagian',
			ktp='$ktp',
			npwp='$npwp',
			tempat_lahir='$tempat_lahir',
			tanggal_lahir='$tanggal_lahir',
			-- umur='$umur',
			jenis_kelamin='$jenis_kelamin',
			status_perkawinan='$status_perkawinan',
			no_rekening='$no_rekening',
			jumlah_anak='$jumlah_anak',
			agama='$agama',
			alamat_ktp='$alamat_ktp',
			alamat_domisili='$alamat_domisili',
			pendidikan_terakhir='$pendidikan_terakhir',
			jurusan='$jurusan',
			tahun_lulus='$tahun_lulus',
			nomor_hp='$nomor_hp',
			nomor_hp_keluarga='$nomor_hp_keluarga',
			nomor_kartu_jamsostek='$nomor_kartu_jamsostek',
			nomor_kartu_dana_pensiun='$nomor_kartu_dana_pensiun',
			no_kartu_bpjs='$no_kartu_bpjs',
			kode_jabatan='$kode_jabatan',
			upah_pokok='$upah_pokok',
			upah_tunjangan='$upah_tunjangan',
			-- upah_total='$upah_total',
			status_karyawan='$status_karyawan',
			-- masa_kerja='$masa_kerja',
			-- kontrak_awal1='$kontrak_awal1',
			-- kontrak_awal2='$kontrak_awal2',
			-- lama_kontrak1='$lama_kontrak1',
			-- kontrak_akhir1='$kontrak_akhir1',
			-- kontrak_akhir2='$kontrak_akhir2',
			-- lama_kontrak2='$lama_kontrak2',
			-- sp='$sp',
			cuti='$cuti',
			-- cuti_yang_diambil='$cuti_yang_diambil',
			-- sisa_cuti='$sisa_cuti',
			referensi='$referensi',
			nilai_mtk='$nilai_mtk',
			status_vaksin='$status_vaksin',
			status_vaksin2='$status_vaksin2',
			bersedia_keluar_kota='$bersedia_keluar_kota',
			id_card='$id_card',
			keterangan_mutasi='$keterangan_mutasi',
			surat_pernyataan='$surat_pernyataan'
			-- status_update='$status_update'
		");
	}else {
		//echo "Nik sudah terdaftar dan masih Aktif! $nik - $nama";
	}
	}
//SHEET 1 HEADER



echo "<script type='text/javascript'>window.close();</script>";
//SHEET 4 HEADER


	// hapus kembali file .xls yang di upload tadi
	unlink($_FILES['pelengkap']['name']);
}
//Jalankan Perintah Import END




//FORM UPLOAD
echo "<form method='post' enctype='multipart/form-data'>
			Browse:
			<input name='pelengkap' type='file' required='required'></br></br>
			<input type='hidden' name='eksekusi_import' value='import'>
			<input name='upload' type='submit' value='Import'>
			</form>";
//FORM UPLOAD END




//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END


?>
