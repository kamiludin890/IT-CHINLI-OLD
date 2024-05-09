<?php global $mod;
	$mod='hrdpayroll/absensi';
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


function tampilan_tgl($tanggal){
	$jumlah_karakter=strlen($tanggal);

	if ($jumlah_karakter=='1') {
		$show="0$tanggal";
	}else {
		$show="$tanggal";
	}

return $show;}

function home(){extract($GLOBALS);
include ('function.php');

$column_header='tanggal,departement,bagian,bulan_gaji,tahun_gaji';
$column='ket_revisi,tanggal,departement,bagian,bulan_gaji,tahun_gaji,pembuat,tgl_dibuat';//kontrak_awal1,kontrak_awal2,kontrak_akhir1,kontrak_akhir2,

$nama_database='hrd_payroll_absensi';
$nama_database_items='hrd_payroll_absensi_items';

$address='?mod=hrdpayroll/absensi';

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
echo "</tr></table>";
//Kembali END


$tahun_gaji=ambil_database(tahun_gaji,$nama_database,"id='$id'");
$bulan_gaji=ambil_database(bulan_gaji,$nama_database,"id='$id'");

//HEADER
echo "<table style='font-weight:bold; font-size:15px; margin-bottom:25px;'>";
	echo "<tr>";
		echo "<td>Departement</td>";echo "<td>:</td>";echo "<td>".ambil_database(departement,$nama_database,"id='$id'")."</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>Bagian</td>";echo "<td>:</td>";echo "<td>".ambil_database(bagian,$nama_database,"id='$id'")."</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>Periode</td>";echo "<td>:</td>";echo "<td>$tahun_gaji-$bulan_gaji</td>";
	echo "</tr>";
echo "</table>";
//HEADER END


//Tombol Input DOKUMEN BAYAR
if (ambil_database(status,$nama_database,"id='$id'")!='Selesai') {

	echo "<table style='margin-top:20px;'>";
		echo "<tr>";

			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/hrdpayroll/absensi_tambah.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Tambah".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";
				echo "<td> | </td>";
			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/hrdpayroll/absensi_edit.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Edit".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";
				echo "<td> | </td>";
			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/hrdpayroll/absensi_lemburan.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Lemburan".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";

		echo "</tr>";
	echo "</table>";
	}
//Tombol Input DOKUMEN BAYAR END

//TAMPILAN TABEL
echo "<table class='tabel_utama'>";

//START THEAD
echo "<thead>";
	echo "<th>No</th>";
	echo "<th>Nik</th>";
	echo "<th>Nama</th>";
	echo "<th>Bagian</th>";

	$jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"bulan='".ambil_database(bulan_gaji,$nama_database,"id='$id'")."' AND tahun='".ambil_database(tahun_gaji,$nama_database,"id='$id'")."'");
	$no_tgl=1;for($i=0; $i < $jumlah_hari; ++$i){

		$tgl_only=tampilan_tgl($no_tgl);
		$tanggal="$tahun_gaji-$bulan_gaji-$tgl_only";
		$nama_hari=ambilhari("$tanggal");
		if ($nama_hari=='Minggu'){$color_hari='yellow';}else{$color_hari='white';}

		echo "<th colspan='1' style='background-color:$color_hari; white-space:nowrap;'>$nama_hari</br>$tanggal";
		echo "</th>";

	$no_tgl++;}
	echo "<th>Total</th>";
echo "</thead>";
//START THEAD END



//START TABEL
$result2=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id' GROUP BY id_pegawai");
$no2=1;
while ($rows2=mysql_fetch_array($result2)) {

echo "<tr>";
		echo "<td>$no2</td>";
		echo "<td class='sticky-col zero-col'>$rows2[nik]</td>";
		echo "<td class='sticky-col first-col'>$rows2[nama]</td>";
		echo "<td class='sticky-col second-col'>$rows2[bagian]</td>";

		$no_tgl2=1;for($i=0; $i < $jumlah_hari; ++$i){
			$tgl_only=tampilan_tgl($no_tgl2);
			$tanggal="$tahun_gaji-$bulan_gaji-$tgl_only";

			$hk=ambil_database(hari_kerja,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$um=ambil_database(uang_makan,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$ut=ambil_database(uang_transport,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$us=ambil_database(uang_shift,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$alpa=ambil_database(alpa,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$ijin=ambil_database(ijin,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$cuti=ambil_database(cuti,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$dokter=ambil_database(dokter,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$setengah_hari=ambil_database(setengah_hari,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$telat=ambil_database(terlambat,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");
			$pulang_cepat=ambil_database(pulang_cepat,$nama_database_items,"id_pegawai='$rows2[id_pegawai]' AND tanggal='$tanggal'");

			echo "<td>";

					echo "<table>";
						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>HK</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$hk</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>UM</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$um</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>UT</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$ut</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>US</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$us</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>ABS</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$alpa</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>CUTI</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$cuti</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>IJIN</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$ijin</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>DOKTER</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$dokter</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>1/2 HARI (jam)</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$setengah_hari</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>TELAT (jam)</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$telat</td>";
						echo "<tr>";

						echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>P.CEPAT (jam)</td>";
							echo "<td style='border:0px solid; text-align:left;'>:</td>";
							echo "<td style='border:0px solid; text-align:left;'>$pulang_cepat</td>";
						echo "<tr>";

					echo "</table>";

			echo "</td>";
		$no_tgl2++;}


//TOTAL KANAN
echo "<td>";
		echo "<table>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>HK</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>UM</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>UT</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>US</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>ABS</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>IJIN</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>CUTI</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>DOKTER</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>TELAT</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
			echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>P.CEPAT</td>";
				echo "<td style='border:0px solid; text-align:left;'>:</td>";
				echo "<td style='border:0px solid; text-align:left;'></td>";
			echo "<tr>";
		echo "</table>";
echo "</td>";
//TOTAL KANAN END


echo "</tr>";

$no2++;}
//START TABEL END



echo "</table>";
//TAMPILAN TABEL END


}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
