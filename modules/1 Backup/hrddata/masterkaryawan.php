<?php global $mod;
	$mod='hrddata/masterkaryawan';
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

function total_masuk_per_dokumen($id,$kodebarang,$nama,$satuan){
$sql="SELECT masuk FROM inventory_distribusi_items WHERE induk='$id' AND kodebarang='$kodebarang' AND nama='$nama' AND satuan='$satuan'";
$result=mysql_query($sql);
while ($rows=mysql_fetch_array($result)){
	$total_masuk=$rows[masuk]+$total_masuk;
}
return $total_masuk;}

function home(){extract($GLOBALS);
include ('function.php');

$column_header='tanggal,foto,nik,status_pegawai,nama,tanggal_masuk,bagian,ktp,npwp,tempat_lahir,tanggal_lahir,umur,jenis_kelamin,status_perkawinan,no_rekening,jumlah_anak,agama,alamat_ktp,alamat_domisili,pendidikan_terakhir,jurusan,tahun_lulus,nomor_hp,nomor_hp_keluarga,nomor_kartu_jamsostek,nomor_kartu_dana_pensiun,no_kartu_bpjs,kode_jabatan,upah_pokok,upah_tunjangan,upah_total,status_karyawan,masa_kerja,kontrak_awal1,kontrak_awal2,lama_kontrak1,kontrak_akhir1,kontrak_akhir2,lama_kontrak2,sp,cuti,cuti_yang_diambil,sisa_cuti,referensi,nilai_mtk,status_vaksin,status_vaksin2,bersedia_keluar_kota,id_card,keterangan_mutasi,surat_pernyataan,status_update,tanggal_tidak_aktif,alasan_tidak_aktif,keterangan_tidak_aktif';
$column='ket_revisi,tanggal,foto,nik,status_pegawai,nama,tanggal_masuk,bagian,ktp,npwp,tempat_lahir,tanggal_lahir,jenis_kelamin,status_perkawinan,no_rekening,jumlah_anak,agama,alamat_ktp,alamat_domisili,pendidikan_terakhir,jurusan,tahun_lulus,nomor_hp,nomor_hp_keluarga,nomor_kartu_jamsostek,nomor_kartu_dana_pensiun,no_kartu_bpjs,kode_jabatan,upah_pokok,upah_tunjangan,status_karyawan,cuti,cuti_yang_diambil,referensi,nilai_mtk,status_vaksin,status_vaksin2,bersedia_keluar_kota,id_card,keterangan_mutasi,surat_pernyataan,status_update,pembuat,tgl_dibuat';//kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2,

$nama_database='hrd_data_karyawan';
//$nama_database_items='admin_purchasing_items';

$address='?mod=hrddata/masterkaryawan';

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



//UPDATE MASA KONTRAK
	//PERIODE
	$tahun_post=$_POST['pilihan_tahun'];
	$bulan_post=$_POST['pilihan_bulan'];
	if ($tahun_post=='All' OR $tahun_post==''){$periode="";}else{$periode="WHERE tanggal LIKE '$tahun_post-$bulan_post%'";}
	//PERIODE END

	//ARRAY
	$result_01=mysql_query("SELECT id,tanggal_masuk FROM $nama_database $periode");
	while ($rows_01=mysql_fetch_array($result_01)) {
		$id_pegawai=$rows_01['id'];
		$tanggal_masuk=$rows_01['tanggal_masuk'];

		//TOTAL KONTRAK 1 & TOTAL KONTRAK 2
		$result_02=mysql_query("SELECT
			SUM(IF(kontrak_ke='1', tambah_kontrak, 0)) as jumlah_kontrak_1,
			SUM(IF(kontrak_ke='2', tambah_kontrak, 0)) as jumlah_kontrak_2
			FROM hrd_data_masakerja WHERE id_pegawai='$id_pegawai'");
		$rows_02=mysql_fetch_array($result_02);
		$jumlah_kontrak_1="+$rows_02[jumlah_kontrak_1] months";
		$jumlah_kontrak_2="+$rows_02[jumlah_kontrak_2] months";
		//TOTAL KONTRAK 1 & TOTAL KONTRAK 2 END

					//DETAIL KONTRAK 1
						if ($rows_02[jumlah_kontrak_1]) {
							$kontrak_awal1=$tanggal_masuk;
							$kontrak_awal2_before_min1_day=date('Y-m-d',strtotime("$jumlah_kontrak_1", strtotime($tanggal_masuk)));
							$kontrak_awal2=date('Y-m-d',strtotime("-1 Days", strtotime($kontrak_awal2_before_min1_day)));
						}else{$kontrak_awal1='';$kontrak_awal2_before_min1_day='';$kontrak_awal2='';}
					//DETAIL KONTRAK 1 END

					//DETAIL KONTRAK 2
						if ($rows_02[jumlah_kontrak_2]) {
							$kontrak_akhir1=date('Y-m-d',strtotime("$jumlah_kontrak_1", strtotime($tanggal_masuk)));
							$kontrak_akhir2=date('Y-m-d',strtotime("$jumlah_kontrak_2", strtotime($kontrak_akhir1)));
						}else{$kontrak_akhir1='';$kontrak_akhir2='';}
					//DETAIL KONTRAK 2 END


	//UPDATE DATA KONTRAK
		mysql_query("UPDATE $nama_database SET kontrak_awal1='$kontrak_awal1',kontrak_awal2='$kontrak_awal2',kontrak_akhir1='$kontrak_akhir1',kontrak_akhir2='$kontrak_akhir2',lama_kontrak1='$rows_02[jumlah_kontrak_1]',lama_kontrak2='$rows_02[jumlah_kontrak_2]' WHERE id='$id_pegawai'");
	//UPDATE DATA KONTRAK END
	}
	//ARRAY END
//UPDATE MASA KONTRAK END

//IMPORT DATA
echo "<table style='margin-bottom:20px;'>";
echo "<tr>";
	echo "<td>";
		echo '<a href="#" style="" onClick="window.open(\''."modules/hrddata/masterkaryawan_import.php?id=#".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=300,height=100'.'\')">'."Import from excel".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
	echo "</td>";
echo "</tr>";
echo "</table>";
//IMPORT DATA END


//START ITEM
if ($opsi=='item'){

//ALL ONE
echo kalender();
echo combobox();
include 'style.css';


	//Kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	echo "</td>";
	echo "</tr></table>";
	//Kembali END




}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
