<?php global $mod;
	$mod='aplikasipph/rumus';
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

function rumus_pph($id_pegawai,$nama_database){
					//UPDATE HASIL RUMUS
					$awal_perolehan=ambil_database(dari_bulan,$nama_database,"id='$id_pegawai'");
					$akhir_perolehan=ambil_database(sampai_bulan,$nama_database,"id='$id_pegawai'");
							$no_pensiunan_atau_jht=$awal_perolehan;for($i_pensiunan_atau_jht=0; $i_pensiunan_atau_jht < $akhir_perolehan; ++$i_pensiunan_atau_jht){$pensiunan_atau_jht=ambil_database(gaji."$no_pensiunan_atau_jht",$nama_database,"id='$id_pegawai'")+$pensiunan_atau_jht; $no_pensiunan_atau_jht++;}
							$no_premi_asuransi=$awal_perolehan;for($i_premi_asuransi=0; $i_premi_asuransi < $akhir_perolehan; ++$i_premi_asuransi){$premi_asuransi=ambil_database("premi$no_premi_asuransi",$nama_database,"id='$id_pegawai'")+$premi_asuransi; $no_premi_asuransi++;}
							$no_iuran_pensiun=$awal_perolehan;for($i_iuran_pensiun=0; $i_iuran_pensiun < $akhir_perolehan; ++$i_iuran_pensiun){$iuran_pensiun=ambil_database("iuran$no_iuran_pensiun",$nama_database,"id='$id_pegawai'")+$iuran_pensiun; $no_iuran_pensiun++;}
							$penghasilan_bruto_teratur=$pensiunan_atau_jht+ambil_database(tunjangan_pph,$nama_database,"id='$id_pegawai'")+ambil_database(tunjangan_lainnya,$nama_database,"id='$id_pegawai'")+ambil_database(honarium,$nama_database,"id='$id_pegawai'")+$premi_asuransi+ambil_database(natura_pph21,$nama_database,"id='$id_pegawai'");
							$jumlah_penghasilan_teratur_tidakteratur=$penghasilan_bruto_teratur+ambil_database(bonus_thr,$nama_database,"id='$id_pegawai'");
							$penghasilan_bruto=$jumlah_penghasilan_teratur_tidakteratur;
							$biaya_jabatan1_penentu=$penghasilan_bruto*5/100; if($biaya_jabatan1_penentu > 6000000){$biaya_jabatan1=6000000;}else{$biaya_jabatan1=$biaya_jabatan1_penentu;}
							$jumlah_pengurang=$iuran_pensiun+$biaya_jabatan1;
							$penghasilan_netto=$penghasilan_bruto-$jumlah_pengurang;
							$ptkp=ambil_database(setahun,aplikasipph_ptkp,"status='".ambil_database(status_ptkp,$nama_database,"id='$id_pegawai'")."'");
							$penghasilan_kena_pajak_penentu=$penghasilan_netto+ambil_database(penghasilan_netto_sebelumnya,$nama_database,"id='$id_pegawai'")-$ptkp; if($penghasilan_kena_pajak_penentu < 0){$penghasilan_kena_pajak=0;}else {$penghasilan_kena_pajak=$penghasilan_kena_pajak_penentu;}
											$pkp_rumus=$penghasilan_netto-$ptkp;
									if ($pkp_rumus <= 0){$pkp_rumus2=0;}else{$pkp_rumus2=floor($pkp_rumus);}
									if($pkp_rumus2 <= '50000000'){$pph_terutang=$pkp_rumus2*5/100;}
									if($pkp_rumus2 > '50000000' AND $pkp_rumus2 <= '250000000'){$pph_terutang=$pkp_rumus2*15/100;}
									if($pkp_rumus2 > '250000000' AND $pkp_rumus2 <= '500000000'){$pph_terutang=$pkp_rumus2*25/100;}
									if($pkp_rumus2 > '500000000'){$pph_terutang=$pkp_rumus2*30/100;}
											mysql_query("UPDATE $nama_database SET pensiunan_atau_jht='$pensiunan_atau_jht',premi_asuransi='$premi_asuransi',iuran_pensiun='$iuran_pensiun',penghasilan_bruto_teratur='$penghasilan_bruto_teratur',jumlah_penghasilan_teratur_tidakteratur='$jumlah_penghasilan_teratur_tidakteratur',
																								 penghasilan_bruto='$penghasilan_bruto',biaya_jabatan1='$biaya_jabatan1',jumlah_pengurang='$jumlah_pengurang',penghasilan_netto='$penghasilan_netto',penghasilan_netto_setahun='$penghasilan_netto',
																								 ptkp='$ptkp',penghasilan_kena_pajak='$penghasilan_kena_pajak',pph_terutang='$pph_terutang'
																								 WHERE id='$id_pegawai'");
					//UPDATE HASIL RUMUS END
return ;}


	$nama_database='aplikasipph_gaji';

	$column_items='id,urut,nama_pegawai,status_ptkp,keterangan_evaluasi,gaji1,gaji2,gaji3,gaji4,gaji5,gaji6,gaji7,gaji8,gaji9,gaji10,gaji11,gaji12,pensiunan_atau_jht,tunjangan_pph,tunjangan_lainnya,honarium,premi1,premi2,premi3,premi4,premi5,premi6,premi7,premi8,premi9,premi10,premi11,premi12,premi_asuransi,natura_pph21,penghasilan_bruto_teratur,bonus_thr,jumlah_penghasilan_teratur_tidakteratur,iuran1,iuran2,iuran3,iuran4,iuran5,iuran6,iuran7,iuran8,iuran9,iuran10,iuran11,iuran12,iuran_pensiun,pph21_telah_dipotong,pph_ditanggung_pemerintah,penghasilan_bruto,biaya_jabatan1,biaya_jabatan2,jumlah_pengurang,penghasilan_netto,penghasilan_netto_sebelumnya,penghasilan_netto_setahun,ptkp,penghasilan_kena_pajak,pph_terutang,pph_sebelumnya,dari_bulan,sampai_bulan';

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
				$id_pegawai=$data->val($i, 1);
			  $no_import=1; $no_import2=2;for($i_import=1; $i_import < $jumlah_column; ++$i_import){
				$urutkan=$pecah_column[$no_import]."='".$data->val($i, $no_import2)."'";
						mysql_query("UPDATE $nama_database SET $urutkan WHERE id='$id_pegawai'");
				$no_import++;$no_import2++;}
				echo rumus_pph($id_pegawai,$nama_database);
			}
$impor_berhasil='Data Sukses di Import';
return $impor_berhasil;}


function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,urut,nama_pegawai,status_ptkp,keterangan_evaluasi,gaji1,gaji2,gaji3,gaji4,gaji5,gaji6,gaji7,gaji8,gaji9,gaji10,gaji11,gaji12,pensiunan_atau_jht,tunjangan_pph,tunjangan_lainnya,honarium,premi1,premi2,premi3,premi4,premi5,premi6,premi7,premi8,premi9,premi10,premi11,premi12,premi_asuransi,natura_pph21,penghasilan_bruto_teratur,bonus_thr,jumlah_penghasilan_teratur_tidakteratur,iuran1,iuran2,iuran3,iuran4,iuran5,iuran6,iuran7,iuran8,iuran9,iuran10,iuran11,iuran12,iuran_pensiun,pph21_telah_dipotong,pph_ditanggung_pemerintah,penghasilan_bruto,biaya_jabatan1,jumlah_pengurang,penghasilan_netto,penghasilan_netto_sebelumnya,penghasilan_netto_setahun,ptkp,penghasilan_kena_pajak,pph_terutang,pph_sebelumnya,dari_bulan,sampai_bulan,pembuat,tgl_dibuat,ket_revisi';

$column='ket_revisi,tanggal,urut,gaji1,gaji2,gaji3,gaji4,gaji5,gaji6,gaji7,gaji8,gaji9,gaji10,gaji11,gaji12,tunjangan_pph,tunjangan_lainnya,honarium,premi1,premi2,premi3,premi4,premi5,premi6,premi7,premi8,premi9,premi10,premi11,premi12,natura_pph21,bonus_thr,iuran1,iuran2,iuran3,iuran4,iuran5,iuran6,iuran7,iuran8,iuran9,iuran10,iuran11,iuran12,pph21_telah_dipotong,pph_ditanggung_pemerintah,penghasilan_netto_sebelumnya,pph_sebelumnya,dari_bulan,sampai_bulan,pembuat,tgl_dibuat';

$nama_database='aplikasipph_gaji';

$address='?mod=aplikasipph/rumus';

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


//EKSPORT TO EKCEL
if ($_POST[ekspor_excel] == 'ya') {
	echo ekspor_kode_produk();
}

echo "
<table style='margin-bottom:30px;'>
<form name='myForm' id='myForm' onSubmit='return validateForm()' action='$address' method='post' enctype='multipart/form-data'>
<tr>
		<td><strong>Import Dari Excel</strong></td>
</tr>
<tr>
		<td><input type='file' id='rumusgaji' name='rumusgaji' required></td>
    <td><input type='submit' name='submit' value='Import'></td>
</tr>
<input type='hidden' name='ekspor_excel' value='ya'>
</form>
</table>";
//EKSPORT TO EKCEL END


//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA


}//END HOME
//END PHP?>
