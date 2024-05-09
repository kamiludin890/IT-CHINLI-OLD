<?php
session_start();
ob_start();
error_reporting(0);
include('../../koneksi.php');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

$connection=mysql_connect(s('db_server'), s('db_user'), s('db_password')) or die(mysql_error()) ;
mysql_select_db(s('db_name'));

function kalender1(){
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
function combobox1(){
	echo "
	 <link href='../tools/kalender_combo/select2.min.css' rel='stylesheet' />
	 <script src='../tools/kalender_combo/select2.min.js'></script>

	<script type='text/javascript'>
	 $(document).ready(function() {
	     $('.comboyuk').select2();
	 });
	</script>";
return;}

function upload_gambar1($nama_file,$ukuran_file,$tipe_file,$tmp_file){
	$tgl_upload=date('Y-m-d H:i:s');
	$hanya_angka = preg_replace("/[^0-9]/", "", $tgl_upload);
	$nama_file2="$hanya_angka-$nama_file";

	if ($nama_file==''){$nama_file3="history-service-printer".$nama_file;}else{$nama_file3="history-service-printer".$nama_file2;}

	$path = "foto/".$nama_file3;
	if($tipe_file == "image/jpeg" || $tipe_file == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
	  if($ukuran_file <= 5000000){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
	    move_uploaded_file($tmp_file, $path);
		}else {
			echo "Ukuran File Terlalu Besar";
		}}
return $nama_file3;}
?>


<?php
include('../../function_home.php');
include 'style.css';

echo kalender1();
echo combobox1();

$bahasa=ina;
$id=buka_kunci($_GET['id']);

// $column_header='tanggal,nik,status_pegawai,nama,tanggal_masuk,bagian,kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2';
// $pecah_column_header=explode (",",$column_header);
// $nilai_jumlah_pecahan_header=count($pecah_column_header);
//
// $pencarian=$_POST['pencarian'];
// $pilihan_pencarian=$_POST['pilihan_pencarian'];

echo "<title>History Service</title>";


//SAVE
if($_POST['save_list']==1){

	//FOTO
	$nama_file = $_FILES['gambar']['name'];
	$ukuran_file = $_FILES['gambar']['size'];
	$tipe_file = $_FILES['gambar']['type'];
	$tmp_file = $_FILES['gambar']['tmp_name'];
	$nama_gambar=upload_gambar1($nama_file,$ukuran_file,$tipe_file,$tmp_file);


	$tanggal_service=$_POST['tanggal_service'];
	$keterangan=$_POST['keterangan'];
	$tanggal_selesai_service=$_POST['tanggal_selesai_service'];
	$tanggal_akhir_garansi=$_POST['tanggal_akhir_garansi'];
	$tempat_service=$_POST['tempat_service'];

			mysql_query("INSERT INTO datait_printer_history SET
				induk='$id',
				foto='$nama_gambar',
				tanggal_service='$tanggal_service',
				keterangan='$keterangan',
				tanggal_selesai_service='$tanggal_selesai_service',
				tanggal_akhir_garansi='$tanggal_akhir_garansi',
				tempat_service='$tempat_service'
			");


echo "<script type='text/javascript'>window.close();</script>";
}
//SAVE END



echo "<form method='POST' enctype='multipart/form-data'>";
echo "<table>";

	echo "<tr>";
		echo "<td>Tanggal Service</td>";
		echo "<td>:</td>";
		echo "<td><input type='text' name='tanggal_service' class='date'></td>";
	echo "</tr>";

	echo "<tr>";
		echo "<td>Keterangan</td>";
		echo "<td>:</td>";
		echo "<td><textarea style='width:176px;' name='keterangan' rows='3' cols='30'></textarea></td>";
	echo "</tr>";

	echo "<tr>";
		echo "<td>Foto</td>";
		echo "<td>:</td>";
		echo "<td>
		<input type='file' name='gambar'>
		</td>";
	echo "</tr>";

	echo "<tr>";
		echo "<td>Tanggal Selesai Service</td>";
		echo "<td>:</td>";
		echo "<td><input type='text' name='tanggal_selesai_service' class='date'></td>";
	echo "</tr>";

	echo "<tr>";
		echo "<td>Tanggal Akhir Garansi</td>";
		echo "<td>:</td>";
		echo "<td><input type='text' name='tanggal_akhir_garansi' class='date'></td>";
	echo "</tr>";

	echo "<tr>";
		echo "<td>Tempat Service</td>";
		echo "<td>:</td>";
		echo "<td><textarea style='width:176px;' name='tempat_service' rows='5' cols='30'></textarea></td>";
	echo "</tr>";

echo "</table>";

echo "<input type='hidden' name='save_list' value='1'>";
echo "<input type='submit' value='Simpan'>";
echo "</form>";



//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END

//echo "<script type='text/javascript'>window.close();</script>";
?>
