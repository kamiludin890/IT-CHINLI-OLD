<?php global $mod;
	$mod='hrddata/pengajuankontrak';
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


// function nama_bulan($tanggal){
// 	$nilai_bulan=substr($tanggal,5,2);
// 	if ($nilai_bulan=='01'){$bulan='Januari';}
// 	elseif ($nilai_bulan=='02'){$bulan='Februari';}
// 	elseif ($nilai_bulan=='03'){$bulan='Maret';}
// 	elseif ($nilai_bulan=='04'){$bulan='April';}
// 	elseif ($nilai_bulan=='05'){$bulan='Mei';}
// 	elseif ($nilai_bulan=='06'){$bulan='Juni';}
// 	elseif ($nilai_bulan=='07'){$bulan='Juli';}
// 	elseif ($nilai_bulan=='08'){$bulan='Agustus';}
// 	elseif ($nilai_bulan=='09'){$bulan='September';}
// 	elseif ($nilai_bulan=='10'){$bulan='Oktober';}
// 	elseif ($nilai_bulan=='11'){$bulan='November';}
// 	elseif ($nilai_bulan=='12'){$bulan='Desember';}
// 	else {$bulan='';}
//
// return $bulan;}


function kontrak_sebelum($id_pegawai,$kontrak_awal1,$kontrak_awal2,$kontrak_akhir1,$kontrak_akhir2){

if($kontrak_awal2!='0000-00-00' AND $kontrak_akhir2=='0000-00-00'){$kontrak_ke=1; $tanggal_start=$kontrak_awal1;}
elseif($kontrak_awal2!='0000-00-00' AND $kontrak_akhir2!='0000-00-00'){$kontrak_ke=2; $tanggal_start=$kontrak_akhir1;}
else{$kontrak_ke='';}

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

$urutan++;}


		echo "$bulan_terakhir Bulan>>> $nilai1 s/d $nilai>>> $nama_bulan_nilai1 s/d $nama_bulan_nilai</br>";
return ;}



function home(){extract($GLOBALS);
include ('function.php');

$column_header='tanggal,bulan_pengajuan,tahun_pengajuan,bagian,status,pembuat,tgl_dibuat';
$column='ket_revisi,tanggal,bulan_pengajuan,tahun_pengajuan,bagian,pembuat,tgl_dibuat';//kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2,

$nama_database='hrd_data_pengajuan_kontrak';
$nama_database_items='hrd_data_pengajuan_kontrak_items';

$address='?mod=hrddata/pengajuankontrak';

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

	echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/hrddata/cetak/cetak_pengajuankontrak.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."<img src='modules/gambar/print.png' width='25px' height='25px'/>".'</a>';//<img src='modules/gambar/print.png' width='30px' height='30px'/>
	echo "</td>";

	// echo "<td>";
	// 			echo '<a href="#" style="" onClick="window.open(\''."modules/hrddata/cetak/print_excel_pengajuan.php?id=$id".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."<img src='modules/gambar/save_excel.png' width='25px' height='25px'/>".'</a>';//<img src='modules/gambar/print.png' width='30px' height='30px'/>
	// echo "</td>";

	echo "<td><form method ='POST' action='modules/hrddata/cetak/print_excel_pengajuan.php' target='_blank'>";
	echo "<input type='image' src='modules/gambar/save_excel.png' width='25' height'25' name='print' value='print'>
				<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='bahasa' value='$bahasa'>
				<input type='hidden' name='nama_database1' value='$nama_database'>
				<input type='hidden' name='pilihan_tahun1' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan1' value='$pilihan_bulan'>
				<input type='hidden' name='pencarian1' value='$pencarian'>
				<input type='hidden' name='pilihan_pencarian1' value='$pilihan_pencarian'>
				<input type='hidden' name='address1' value='$address'>
				</form></td>";

	echo "</tr></table>";
	//Kembali END



//HEADER
echo "<h3>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</h3>";
echo "<h3 style='text-align:center;'>Data Pengajuan Perpanjangan Kontrak Karyawan</h3>";
echo "<h3 style='text-align:center;'>Bulan ".nama_bulan_only(ambil_database(bulan_pengajuan,$nama_database,"id='$id'"))." ".ambil_database(tahun_pengajuan,$nama_database,"id='$id'")."</h3>";
echo "<h3 style='text-align:center;'>Bagian ".ambil_database(bagian,$nama_database,"id='$id'")."</h3>";
//HEADER END


//ARRAY HEADER
$column_header='nik,nama,bagian,tanggal_masuk,kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2,pemutusan_kontrak,lanjut_kontrak,kontrak_ke,keterangan,kontrak_sebelum,masa_kontrak,cuti,ijin,dokter,alpa,sp,masa_berlaku';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);
//ARRAY HEADER


//Tombol Input DOKUMEN BAYAR
if (ambil_database(status,$nama_database,"id='$id'")!='Selesai') {

	echo "<table style='margin-top:20px;'>";
		echo "<tr>";

			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/hrddata/pengajuankontrak_tambah.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Tambah".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";
				echo "<td> | </td>";
			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/hrddata/pengajuankontrak_edit.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Edit".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";
				echo "<td> | </td>";
			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/hrddata/pengajuankontrak_finish.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Finish".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";

		echo "</tr>";
	echo "</table>";
	}
//Tombol Input DOKUMEN BAYAR END



//SHOW TABEL
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

	echo "</thead>";
	//HEADER END


$result1=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
$urut=1;
while ($rows1=mysql_fetch_array($result1)) {

	echo "<tr>";
		echo "<td>$urut</td>";
	$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
		echo "<td>".$rows1[$pecah_column_header[$no]]."</td>";
	$no++;}
	echo "</tr>";

$urut++;}

echo "</table>";


}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
