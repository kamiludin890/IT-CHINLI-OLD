<?php global $mod;
	$mod='akuntansiv3/fakturmasukkan';
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

function upload_item(){
	//PROSES IMPORT START
		include 'modules/akuntansiv3/excel_reader.php';
		// upload file xls
		$target = basename($_FILES['pelengkap']['name']) ;
		move_uploaded_file($_FILES['pelengkap']['tmp_name'], $target);
		// beri permisi agar file xls dapat di baca
		chmod($_FILES['pelengkap']['name'],0777);
		// mengambil isi file xls
		$data = new Spreadsheet_Excel_Reader($_FILES['pelengkap']['name'],false);
		// menghitung jumlah baris data yang ada
		$jumlah_baris = $data->rowcount($sheet_index=0);
		// jumlah default data yang berhasil di import



		$no1=1; for($i=2; $i<=$jumlah_baris; $i++){
			// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing

			$tanggal=str_replace("'"," ",$data->val($i,1));
			$pembeli=str_replace("'"," ",$data->val($i,2));
			$no_npwp=preg_replace("/[^0-9]/", "", str_replace("'"," ",$data->val($i,3)));
			$no_faktur=preg_replace("/[^0-9]/", "", str_replace("'"," ",$data->val($i,4)));
			$no_invoice_masukkan=str_replace("'"," ",$data->val($i,5));
			$no_pendaftaran=str_replace("'"," ",$data->val($i,6));
			$no_aju=preg_replace("/[^0-9]/", "", str_replace("'"," ",$data->val($i,7)));
			$jenis_doc=str_replace("'"," ",$data->val($i,8));
			$keterangan=str_replace("'"," ",$data->val($i,9));
			$amount_rp=str_replace("'"," ",$data->val($i,10));

			// $ppn=str_replace("'"," ",$data->val($i,11));//PPN
			$ppn=($amount_rp*11)/100;//PPN

			$nilai=str_replace("'"," ",$data->val($i,12));

			// $hasil=str_replace("'"," ",$data->val($i,13));//HASIL RUMUS
			$hasil=$nilai-$ppn;//HASIL RUMUS

			$departement=str_replace(" ","", str_replace("'"," ",$data->val($i,14)));
			$kasbank_cash_flow=str_replace("'"," ",$data->val($i,15));

			// $outstanding=str_replace("'"," ",$data->val($i,16));//OUTSTANDING
			$outstanding=$amount_rp+$nilai-$kasbank_cash_flow;//OUTSTANDING

			$amount_usd=str_replace("'"," ",$data->val($i,17));
			$tgl_bayar=str_replace("'"," ",$data->val($i,18));
			$no_voucher=str_replace("'"," ",$data->val($i,19));

			// $tidak_dipungut_dpp=str_replace("'"," ",$data->val($i,20));//DPP
			// $tidak_dipungut_ppn=str_replace("'"," ",$data->val($i,21));//DPP
			// $dipungut_dpp=str_replace("'"," ",$data->val($i,22));//DPP
			// $dipungut_ppn=str_replace("'"," ",$data->val($i,23));//DPP

			$nilai_dipungut_dan_tidak=substr($no_faktur,0,2);
			if ($nilai_dipungut_dan_tidak=='07' OR $nilai_dipungut_dan_tidak=='08') {
				$tidak_dipungut_dpp=$amount_rp;//DPP
				$tidak_dipungut_ppn=$amount_rp;//DPP
			}else{}

			if ($nilai_dipungut_dan_tidak=='01' OR $nilai_dipungut_dan_tidak=='05' OR $nilai_dipungut_dan_tidak=='04') {
				$dipungut_dpp=$amount_rp;//DPP
				$dipungut_ppn=$amount_rp;//DPP
			}else{}

			$pembelian_bahan_baku_import=str_replace("'"," ",$data->val($i,24));

			// $pembelian_bahan_penolong_produksi=str_replace("'"," ",$data->val($i,25));//PEMBELIAN BAHAN BAKU
			$pembelian_bahan_penolong_produksi=$amount_rp;//PEMBELIAN BAHAN BAKU

			$jenis_faktur=str_replace("'"," ",$data->val($i,26));




			$pembelian_bahan_pembungkus=str_replace("'"," ",$data->val($i,26));
			$biaya_administrasi=str_replace("'"," ",$data->val($i,27));
			$biaya_pengiriman=str_replace("'"," ",$data->val($i,28));
			$biaya_kalibrasi=str_replace("'"," ",$data->val($i,29));
			$biaya_printing_sublimation=str_replace("'"," ",$data->val($i,30));
			$biaya_peralatan_produksi=str_replace("'"," ",$data->val($i,31));
			$biaya_maintenance=str_replace("'"," ",$data->val($i,32));
			$biaya_sewa_mesin_fotocopy=str_replace("'"," ",$data->val($i,33));
			$biaya_pengangkutan=str_replace("'"," ",$data->val($i,34));
			$biaya_pemeliharaan_kendaraan=str_replace("'"," ",$data->val($i,35));
			$biaya_pemeliharaan_mesin=str_replace("'"," ",$data->val($i,36));
			$biaya_listrik=str_replace("'"," ",$data->val($i,37));
			$air=str_replace("'"," ",$data->val($i,38));
			$telp_dan_internet=str_replace("'"," ",$data->val($i,39));
			$biaya_asuransi=str_replace("'"," ",$data->val($i,40));
			$biaya_penyusutan_mesin_peralatan=str_replace("'"," ",$data->val($i,41));
			$biaya_alat_listrik_alat_mekanik=str_replace("'"," ",$data->val($i,42));
			$biaya_bea_masuk_import=str_replace("'"," ",$data->val($i,43));
			$biaya_keperluan_pabrik=str_replace("'"," ",$data->val($i,44));
			$biaya_laboratorium_test=str_replace("'"," ",$data->val($i,45));
			$biaya_perlengkapan_kantor=str_replace("'"," ",$data->val($i,46));
			$biaya_iuran=str_replace("'"," ",$data->val($i,47));
			$biaya_pengobatan=str_replace("'"," ",$data->val($i,48));
			$biaya_keperluan_kantor=str_replace("'"," ",$data->val($i,49));
			$biaya_perijinan=str_replace("'"," ",$data->val($i,50));
			$biaya__bphtb_pbb=str_replace("'"," ",$data->val($i,51));
			$biaya_pemeliharaan_gedung=str_replace("'"," ",$data->val($i,52));
			$biaya_makan_minum=str_replace("'"," ",$data->val($i,53));
			$biaya_sewa_kendaraan=str_replace("'"," ",$data->val($i,54));
			$biaya_pemeliharaan_inv_kantor=str_replace("'"," ",$data->val($i,55));
			$biaya_angkut=str_replace("'"," ",$data->val($i,56));
			$biaya_adm_import=str_replace("'"," ",$data->val($i,57));
			$biaya_pajak=str_replace("'"," ",$data->val($i,58));
			$biaya_entertainment=str_replace("'"," ",$data->val($i,59));
			$biaya_bpjs=str_replace("'"," ",$data->val($i,60));
			$biaya_management_sdm=str_replace("'"," ",$data->val($i,61));
			$biaya_tips=str_replace("'"," ",$data->val($i,62));


			if (ambil_database(no_faktur,akuntansiv3_faktur_masukkan,"no_faktur='$no_faktur'")=='' AND $no_faktur!='') {
			mysql_query("INSERT INTO akuntansiv3_faktur_masukkan SET
				tanggal='$tanggal',
				pembeli='$pembeli',
				no_npwp='$no_npwp',
				no_faktur='$no_faktur',
				no_invoice_masukkan='$no_invoice_masukkan',
				no_pendaftaran='$no_pendaftaran',
				no_aju='$no_aju',
				jenis_doc='$jenis_doc',
				keterangan='$keterangan',
				amount_rp='$amount_rp',
				ppn='$ppn',
				nilai='$nilai',
				hasil='$hasil',
				departement='$departement',
				kasbank_cash_flow='$kasbank_cash_flow',
				outstanding='$outstanding',
				amount_usd='$amount_usd',
				tgl_bayar='$tgl_bayar',
				no_voucher='$no_voucher',
				tidak_dipungut_dpp='$tidak_dipungut_dpp',
				tidak_dipungut_ppn='$tidak_dipungut_ppn',
				dipungut_dpp='$dipungut_dpp',
				dipungut_ppn='$dipungut_ppn',
				pembelian_bahan_baku_import='$pembelian_bahan_baku_import',
				pembelian_bahan_penolong_produksi='$pembelian_bahan_penolong_produksi',
				jenis_faktur='$jenis_faktur'
				-- pembelian_bahan_pembungkus='$pembelian_bahan_pembungkus',
				-- biaya_administrasi='$biaya_administrasi',
				-- biaya_pengiriman='$biaya_pengiriman',
				-- biaya_kalibrasi='$biaya_kalibrasi',
				-- biaya_printing_sublimation='$biaya_printing_sublimation',
				-- biaya_peralatan_produksi='$biaya_peralatan_produksi',
				-- biaya_maintenance='$biaya_maintenance',
				-- biaya_sewa_mesin_fotocopy='$biaya_sewa_mesin_fotocopy',
				-- biaya_pengangkutan='$biaya_pengangkutan',
				-- biaya_pemeliharaan_kendaraan='$biaya_pemeliharaan_kendaraan',
				-- biaya_pemeliharaan_mesin='$biaya_pemeliharaan_mesin',
				-- biaya_listrik='$biaya_listrik',
				-- air='$air',
				-- telp_dan_internet='$telp_dan_internet',
				-- biaya_asuransi='$biaya_asuransi',
				-- biaya_penyusutan_mesin_peralatan='$biaya_penyusutan_mesin_peralatan',
				-- biaya_alat_listrik_alat_mekanik='$biaya_alat_listrik_alat_mekanik',
				-- biaya_bea_masuk_import='$biaya_bea_masuk_import',
				-- biaya_keperluan_pabrik='$biaya_keperluan_pabrik',
				-- biaya_laboratorium_test='$biaya_laboratorium_test',
				-- biaya_perlengkapan_kantor='$biaya_perlengkapan_kantor',
				-- biaya_iuran='$biaya_iuran',
				-- biaya_pengobatan='$biaya_pengobatan',
				-- biaya_keperluan_kantor='$biaya_keperluan_kantor',
				-- biaya_perijinan='$biaya_perijinan',
				-- biaya__bphtb_pbb='$biaya__bphtb_pbb',
				-- biaya_pemeliharaan_gedung='$biaya_pemeliharaan_gedung',
				-- biaya_makan_minum='$biaya_makan_minum',
				-- biaya_sewa_kendaraan='$biaya_sewa_kendaraan',
				-- biaya_pemeliharaan_inv_kantor='$biaya_pemeliharaan_inv_kantor',
				-- biaya_angkut='$biaya_angkut',
				-- biaya_adm_import='$biaya_adm_import',
				-- biaya_pajak='$biaya_pajak',
				-- biaya_entertainment='$biaya_entertainment',
				-- biaya_bpjs='$biaya_bpjs',
				-- biaya_management_sdm='$biaya_management_sdm',
				-- biaya_tips='$biaya_tips'
			");
		}elseif(ambil_database(no_faktur,akuntansiv3_faktur_masukkan,"no_faktur='$no_faktur'")!='' AND $no_faktur!='') {
				mysql_query("UPDATE akuntansiv3_faktur_masukkan SET
					tanggal='$tanggal',
					pembeli='$pembeli',
					no_npwp='$no_npwp',
					no_faktur='$no_faktur',
					no_invoice_masukkan='$no_invoice_masukkan',
					no_pendaftaran='$no_pendaftaran',
					no_aju='$no_aju',
					jenis_doc='$jenis_doc',
					keterangan='$keterangan',
					amount_rp='$amount_rp',
					ppn='$ppn',
					nilai='$nilai',
					hasil='$hasil',
					departement='$departement',
					kasbank_cash_flow='$kasbank_cash_flow',
					outstanding='$outstanding',
					amount_usd='$amount_usd',
					tgl_bayar='$tgl_bayar',
					no_voucher='$no_voucher',
					tidak_dipungut_dpp='$tidak_dipungut_dpp',
					tidak_dipungut_ppn='$tidak_dipungut_ppn',
					dipungut_dpp='$dipungut_dpp',
					dipungut_ppn='$dipungut_ppn',
					pembelian_bahan_baku_import='$pembelian_bahan_baku_import',
					pembelian_bahan_penolong_produksi='$pembelian_bahan_penolong_produksi',
					jenis_faktur='$jenis_faktur'
					-- pembelian_bahan_pembungkus='$pembelian_bahan_pembungkus',
					-- biaya_administrasi='$biaya_administrasi',
					-- biaya_pengiriman='$biaya_pengiriman',
					-- biaya_kalibrasi='$biaya_kalibrasi',
					-- biaya_printing_sublimation='$biaya_printing_sublimation',
					-- biaya_peralatan_produksi='$biaya_peralatan_produksi',
					-- biaya_maintenance='$biaya_maintenance',
					-- biaya_sewa_mesin_fotocopy='$biaya_sewa_mesin_fotocopy',
					-- biaya_pengangkutan='$biaya_pengangkutan',
					-- biaya_pemeliharaan_kendaraan='$biaya_pemeliharaan_kendaraan',
					-- biaya_pemeliharaan_mesin='$biaya_pemeliharaan_mesin',
					-- biaya_listrik='$biaya_listrik',
					-- air='$air',
					-- telp_dan_internet='$telp_dan_internet',
					-- biaya_asuransi='$biaya_asuransi',
					-- biaya_penyusutan_mesin_peralatan='$biaya_penyusutan_mesin_peralatan',
					-- biaya_alat_listrik_alat_mekanik='$biaya_alat_listrik_alat_mekanik',
					-- biaya_bea_masuk_import='$biaya_bea_masuk_import',
					-- biaya_keperluan_pabrik='$biaya_keperluan_pabrik',
					-- biaya_laboratorium_test='$biaya_laboratorium_test',
					-- biaya_perlengkapan_kantor='$biaya_perlengkapan_kantor',
					-- biaya_iuran='$biaya_iuran',
					-- biaya_pengobatan='$biaya_pengobatan',
					-- biaya_keperluan_kantor='$biaya_keperluan_kantor',
					-- biaya_perijinan='$biaya_perijinan',
					-- biaya__bphtb_pbb='$biaya__bphtb_pbb',
					-- biaya_pemeliharaan_gedung='$biaya_pemeliharaan_gedung',
					-- biaya_makan_minum='$biaya_makan_minum',
					-- biaya_sewa_kendaraan='$biaya_sewa_kendaraan',
					-- biaya_pemeliharaan_inv_kantor='$biaya_pemeliharaan_inv_kantor',
					-- biaya_angkut='$biaya_angkut',
					-- biaya_adm_import='$biaya_adm_import',
					-- biaya_pajak='$biaya_pajak',
					-- biaya_entertainment='$biaya_entertainment',
					-- biaya_bpjs='$biaya_bpjs',
					-- biaya_management_sdm='$biaya_management_sdm',
					-- biaya_tips='$biaya_tips'
					WHERE no_faktur='$no_faktur';
				");
			}else{}


		 $no1++;}




		// hapus kembali file .xls yang di upload tadi
		unlink($_FILES['pelengkap']['name']);
return ;}














function home(){extract($GLOBALS);
include ('function.php');

$column_header='tanggal,pembeli,no_npwp,no_faktur,no_invoice_masukkan,no_pendaftaran,no_aju,jenis_doc,keterangan,amount_rp,ppn,nilai,hasil,departement,kasbank_cash_flow,outstanding,amount_usd,tgl_bayar,no_voucher,tidak_dipungut_dpp,tidak_dipungut_ppn,dipungut_dpp,dipungut_ppn,pembelian_bahan_baku_import,pembelian_bahan_penolong_produksi';//,pembelian_bahan_pembungkus,biaya_administrasi,biaya_pengiriman,biaya_kalibrasi,biaya_printing_sublimation,biaya_peralatan_produksi,biaya_maintenance,biaya_sewa_mesin_fotocopy,biaya_pengangkutan,biaya_pemeliharaan_kendaraan,biaya_pemeliharaan_mesin,biaya_listrik,air,telp_dan_internet,biaya_asuransi,biaya_penyusutan_mesin_peralatan,biaya_alat_listrik_alat_mekanik,biaya_bea_masuk_import,biaya_keperluan_pabrik,biaya_laboratorium_test,biaya_perlengkapan_kantor,biaya_iuran,biaya_pengobatan,biaya_keperluan_kantor,biaya_perijinan,biaya__bphtb_pbb,biaya_pemeliharaan_gedung,biaya_makan_minum,biaya_sewa_kendaraan,biaya_pemeliharaan_inv_kantor,biaya_angkut,biaya_adm_import,biaya_pajak,biaya_entertainment,biaya_bpjs,biaya_management_sdm,biaya_tips
$column='tanggal,pembeli,no_npwp,no_faktur,no_invoice_masukkan,no_pendaftaran,no_aju,jenis_doc,keterangan,amount_rp,ppn,nilai,hasil,departement,kasbank_cash_flow,outstanding,amount_usd,tgl_bayar,no_voucher,tidak_dipungut_dpp,tidak_dipungut_ppn,dipungut_dpp,dipungut_ppn,pembelian_bahan_baku_import,pembelian_bahan_penolong_produksi';

$nama_database='akuntansiv3_faktur_masukkan';
//$nama_database_items='admin_purchasing_items';

$address='?menu=home&mod=akuntansiv3/fakturmasukkan';

$pilihan_bulan_tahun=0;

if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
echo kalender();
echo combobox();


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


//AMBIL POST
$import_excel=$_POST['import_excel'];
if ($import_excel=='') {
echo "<table style='margin-bottom:10px;'><tr>";
echo "<form method ='post' action=''>";
echo "<td><input type='submit' name='submit' value='Import Excel'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='import_excel' value='1'></td></form>";
echo "</tr></table>";}
//START ITEM
if ($opsi=='item'){
	include 'style.css';
	//Kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	echo "</td>";
	echo "</tr></table>";
	//Kembali END
}else{




			if ($import_excel) {
			//KEMBALI
			echo "<table style='margin-bottom:10px;'><tr>";
			echo "<form method ='post' action=''>";
			echo "<td><input type='image' src='themesv3/sub_menu/back.png' width='25' height'25' name='kembali' value='kembali'>
						<input type='hidden' name='halaman' value='$nomor_halaman'>
						<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
						<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
						<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
						<input type='hidden' name='pencarian' value='$pencarian'>
						<input type='hidden' name='import_excel' value=''></td></form>";
			echo "</tr></table>";
			//KEMBALI END
			echo "<i>*Download excel untuk Update data dan tambah data,</br>*Jika nomor faktur sudah ada sebelumnya data akan terupdate,</br>*Jika nomor faktur belum ada sebelumnya data akan ditambah.</i>";
			//VARIABEL PERIODE
			$akhir_periode1=$_POST['akhir_periode1'];
			$akhir_periode2=$_POST['akhir_periode2'];
			//VARIABEL PERIODE END
			if ($_POST[download_excel]) {
				echo "<script type='text/javascript'>window.open('modules/akuntansiv3/cetak/print_faktur_masukkan.php?akhir_periode1=$akhir_periode1&akhir_periode2=$akhir_periode2')</script>";
			}
			//FORM KALENDER
			echo "<table style='font-size:15px;'>";
			echo "<form method='POST' action='$address'>";
					echo "<tr>";
					echo "<td>Periode</td>";
					echo "<td>:</td>";
					echo "<td><input type='text' class='date' name='akhir_periode1' value='$akhir_periode1' autocomplete='off';></td>";
					echo "<td>s/d</td>";
					echo "<td><input type='text' class='date' name='akhir_periode2' value='$akhir_periode2' autocomplete='off';></td>";
			echo "<input type='hidden' name='halaman' value='$nomor_halaman'>
						<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
						<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
						<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
						<input type='hidden' name='pencarian' value='$pencarian'>
						<input type='hidden' name='import_excel' value='1'>";
				echo "<td><input type='submit' name='show' value='Pilih'></td>";
			echo "</tr>";
			echo "</form>";
			echo "</table>";
			//FORM KALENDER END

			//DOWNLOAD
			echo "<table style='margin-bottom:10px;'><tr>";
			echo "<form method ='post' action=''>";
			echo "<td><input type='submit' src='themesv3/sub_menu/back.png' width='25' height'25' name='download' value='Download'>
						<input type='hidden' name='halaman' value='$nomor_halaman'>
						<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
						<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
						<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
						<input type='hidden' name='pencarian' value='$pencarian'>
									<input type='hidden' name='akhir_periode1' value='$akhir_periode1'>
									<input type='hidden' name='akhir_periode2' value='$akhir_periode2'>
									<input type='hidden' name='download_excel' value='1'>
						<input type='hidden' name='import_excel' value='1'></td></form>";
			echo "</tr></table>";
			//DOWNLOAD END

			//PILIHAN IMPORT
			echo "<table style='margin-top:45px;'>";
				echo "<tr>";
					echo "<td><form method='post' enctype='multipart/form-data' action=''>
					Upload Item
					<input name='pelengkap' type='file' required='required'></td>";
					echo "<td>";
					echo "<input type='hidden' name='halaman' value='$nomor_halaman'>
								<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
								<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
								<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
								<input type='hidden' name='pencarian' value='$pencarian'>
											<input type='hidden' name='akhir_periode1' value='$akhir_periode1'>
											<input type='hidden' name='akhir_periode2' value='$akhir_periode2'>
								<input type='hidden' name='import_excel' value='1'>";
					echo "<input name='upload' type='submit' value='Import'>";
					echo "</td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			//PILIHAN IMPORT END
			//EKSEKUSI UPLOAD
			if ($_POST['upload']) {
				echo upload_item();
				echo "<table>";
					echo "<tr>";echo "<td style='background-color:yellow;'>";
						echo "Data Item Barang Telah Di Upload";
					echo "</td>";	echo "</tr>";
				echo "</table>";
			}





			}else{
			//START UTAMA
			echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$pilihan_bulan_tahun);
			echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
			//END UTAMA
			}

}



}//END HOME
//END PHP?>
