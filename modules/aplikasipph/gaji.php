<?php global $mod;
	$mod='aplikasipph/gaji';
function editmenu(){extract($GLOBALS);}

function ambil_variabel($nama_database,$kolom) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode('","', $datasecs);
	$hasil='"'.$data.'"';
return $hasil;}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

	function ekspor_kode_produk(){
	//	include 'function.php';
		$host2="localhost:3318";
		$user2="root";
		$password2="merdeka170845";
		$database2="sb_dagang";
		$koneksi2=mysql_connect($host2,$user2,$password2);
		mysql_select_db($database2,$koneksi2);
		require "excel_reader.php";

		$nama_database='aplikasipph_gaji';
		$column_items='id,tanggal,urut,nama_pegawai,status_pegawai,jenis_kelamin,status_ptkp,bulan_mulai_menerima_penghasilan,keterangan_evaluasi,bulan_terakhir_menerima_penghasilan,lama_bekerja,jabatan,npwp_pegawai,alamat_pegawai,karyawan_asing,negara,kode_negara,nik';
		$pecah_column=pecah($column_items);
		$jumlah_column=nilai_pecah($column_items);
		//jika tombol import ditekan
				$target = basename($_FILES['rumusgaji']['name']) ;
				move_uploaded_file($_FILES['rumusgaji']['tmp_name'], $target);
				$data = new Spreadsheet_Excel_Reader($_FILES['rumusgaji']['name'],false);
		//    menghitung jumlah baris file xls
				$baris = $data->rowcount($sheet_index=0);

		//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
				for ($i=2; $i<=$baris; $i++)
				{
		//       membaca data (kolom ke-1 sd terakhir)
					$id_pegawai=$data->val($i, 1);//id di database
					$tanggal=$data->val($i, 2);$ambil_tahun=substr($tanggal,0,4);
					$urut=$data->val($i, 3);
					$nama_pegawai=$data->val($i, 4);
					$status_pegawai=$data->val($i, 5);
					$jenis_kelamin=$data->val($i, 6);
					$status=$data->val($i, 7);
					$bulan_mulai_menerima_penghasilan=$data->val($i, 8);
					$keterangan_evaluasi=$data->val($i, 9);
					$bulan_terakhir_menerima_penghasilan=$data->val($i, 10);
					$lama_bekerja=$data->val($i, 11);
					$jabatan=$data->val($i, 12);
					$npwp_pegawai=$data->val($i, 13);
					$alamat_pegawai=$data->val($i, 14);
					$karyawan_asing=$data->val($i, 15);
					$negara=$data->val($i, 16);
					$kode_negara=$data->val($i, 17);
					$nik=$data->val($i, 18);

					// if (ambil_database(nik,$nama_database,"nik='$nik' AND tanggal LIKE '$ambil_tahun%'")=='') {
						$query_insert = "INSERT INTO $nama_database (dari_bulan,sampai_bulan,tanggal,urut,nama_pegawai,status_pegawai,jenis_kelamin,status_ptkp,bulan_mulai_menerima_penghasilan,keterangan_evaluasi,bulan_terakhir_menerima_penghasilan,lama_bekerja,jabatan,npwp_pegawai,alamat_pegawai,karyawan_asing,negara,kode_negara,nik)
																					values('$bulan_mulai_menerima_penghasilan','$bulan_terakhir_menerima_penghasilan','$tanggal','$urut','$nama_pegawai','$status_pegawai','$jenis_kelamin','$status','$bulan_mulai_menerima_penghasilan','$keterangan_evaluasi','$bulan_terakhir_menerima_penghasilan','$lama_bekerja','$jabatan','$npwp_pegawai','$alamat_pegawai','$karyawan_asing','$negara','$kode_negara','$nik')";
						$hasil = mysql_query($query_insert,$koneksi2);
					// }else{
					// 	$query_update = "UPDATE $nama_database SET dari_bulan='$bulan_mulai_menerima_penghasilan',sampai_bulan='$bulan_terakhir_menerima_penghasilan', tanggal='$tanggal',urut='$urut',nama_pegawai='$nama_pegawai',status_pegawai='$status_pegawai',jenis_kelamin='$jenis_kelamin',status_ptkp='$status',bulan_mulai_menerima_penghasilan='$bulan_mulai_menerima_penghasilan',keterangan_evaluasi='$keterangan_evaluasi',bulan_terakhir_menerima_penghasilan='$bulan_terakhir_menerima_penghasilan',lama_bekerja='$lama_bekerja',jabatan='$jabatan',npwp_pegawai='$npwp_pegawai',alamat_pegawai='$alamat_pegawai',karyawan_asing='$karyawan_asing',negara='$negara',kode_negara='$kode_negara',nik='$nik' WHERE id='$id_pegawai'";
					// 	$hasil = mysql_query($query_update,$koneksi2);
					// }
				}

					unlink($_FILES['rumusgaji']['name']);
	$impor_berhasil='Data Sukses di Import';
	return $impor_berhasil;}


function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,urut,nama_pegawai,status_pegawai,jenis_kelamin,status_ptkp,bulan_mulai_menerima_penghasilan,keterangan_evaluasi,bulan_terakhir_menerima_penghasilan,lama_bekerja,jabatan,npwp_pegawai,alamat_pegawai,karyawan_asing,negara,kode_negara,nik,pembuat,tgl_dibuat,ket_revisi';
$column='ket_revisi,tanggal,urut,nama_pegawai,status_pegawai,jenis_kelamin,status_ptkp,bulan_mulai_menerima_penghasilan,keterangan_evaluasi,bulan_terakhir_menerima_penghasilan,lama_bekerja,jabatan,npwp_pegawai,alamat_pegawai,karyawan_asing,negara,kode_negara,nik,pembuat,tgl_dibuat';

$nama_database='aplikasipph_gaji';

$address='?mod=aplikasipph/Gaji';

if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}


if (base64_decrypt($_GET['opsi'],"XblImpl1!A@")=='item') {
$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$nomor_halaman=$_GET['halaman'];
$pilihan_tahun=$_GET['pilihan_tahun'];
$pilihan_bulan=$_GET['pilihan_bulan'];
$pilihan_pencarian=$_GET['pilihan_pencarian'];
$pencarian=$_GET['pencarian'];}
if ($_POST[opsi]=='item') {
$opsi=$_POST['opsi'];
$id=$_POST['id'];
$nomor_halaman=$_POST['halaman'];
$pilihan_tahun=$_POST['pilihan_tahun'];
$pilihan_bulan=$_POST['pilihan_bulan'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];
$pencarian=$_POST['pencarian'];}


//IMPORT FROM EKCEL
if ($_POST[ekspor_excel] == 'ya') {
	echo ekspor_kode_produk();
}

echo "
<table style='margin-bottom:30px;'>
<form name='myForm' id='myForm' onSubmit='return validateForm()' action='$address' method='post' enctype='multipart/form-data'>
<tr>
		<td><strong>Tambah Data dari Excel</strong></td>
</tr>
<tr>
		<td><input type='file' id='rumusgaji' name='rumusgaji' required></td>
    <td><input type='submit' name='submit' value='Import'></td>
</tr>
<input type='hidden' name='ekspor_excel' value='ya'>
</form>
</table>";
//IMPORT FROM EXCEL END



//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA


}//END HOME
//END PHP?>
