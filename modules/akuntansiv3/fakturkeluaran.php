 <?php global $mod;
	$mod='akuntansiv3/fakturkeluaran';
function editmenu(){extract($GLOBALS);}

function ambil_variabel($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database $where");
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

function total_setelah_diskon($induk,$id){
	$kurs=ambil_database(kurs,financecl_kurs,"tanggal='".ambil_database(tanggal,deliverycl_invoice,"no_invoice='$induk'")."'");
	$discount=ambil_database(discount,deliverycl_invoice,"no_invoice='$induk'");
	$ppn=11;
	$result=mysql_query("SELECT * FROM deliverycl_invoice_items WHERE induk='$induk' ORDER BY id");
	while ($rows=mysql_fetch_array($result)) {
	//AMOUNT
	if ($rows[jenis_mata_uang]=='USD') {
		$dirupiahkan_amount=$rows['amount']*$kurs;
	}else{
		$dirupiahkan_amount=$rows['amount'];
	}
	//DISKON
	$hasil_diskon=$dirupiahkan_amount*$discount/100;
	//SETELAH DI KURANG DISKON
	$hasil_dikurang_diskon=$dirupiahkan_amount-$hasil_diskon;
	//PPN
	$hasil_ppn=$hasil_dikurang_diskon*$ppn/100;
	//TOTAL SETELAH DISKON
	$total_hasil_dikurang_diskon=$hasil_dikurang_diskon+$total_hasil_dikurang_diskon;
	//TOTAL PPN
	$total_hasil_ppn=$hasil_ppn+$total_hasil_ppn;}
return floor($total_hasil_dikurang_diskon);}

function total_setelah_ppn($induk){
	$kurs=ambil_database(kurs,financecl_kurs,"tanggal='".ambil_database(tanggal,deliverycl_invoice,"no_invoice='$induk'")."'");
	$discount=ambil_database(discount,deliverycl_invoice,"no_invoice='$induk'");
	$ppn=11;
	$result=mysql_query("SELECT * FROM deliverycl_invoice_items WHERE induk='$induk' ORDER BY id");
	while ($rows=mysql_fetch_array($result)) {
	//AMOUNT
	if ($rows[jenis_mata_uang]=='USD') {
		$dirupiahkan_amount=$rows['amount']*$kurs;
	}else{
		$dirupiahkan_amount=$rows['amount'];
	}
	//DISKON
	$hasil_diskon=$dirupiahkan_amount*$discount/100;
	//SETELAH DI KURANG DISKON
	$hasil_dikurang_diskon=$dirupiahkan_amount-$hasil_diskon;
	//PPN
	$hasil_ppn=$hasil_dikurang_diskon*$ppn/100;
	//TOTAL SETELAH DISKON
	$total_hasil_dikurang_diskon=$hasil_dikurang_diskon+$total_hasil_dikurang_diskon;
	//TOTAL PPN
	$total_hasil_ppn=$hasil_ppn+$total_hasil_ppn;}
return floor($total_hasil_ppn);}

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
			git remote add origin https://github.com/kamiludin890/IT-CHINLI-OLD.git
			$pembelian_bahan_baku_import=str_replace("'"," ",$data->val($i,24));

			// $pembelian_bahan_penolong_produksi=str_replace("'"," ",$data->val($i,25));//PEMBELIAN BAHAN BAKU
			$pembelian_bahan_penolong_produksi=$amount_rp;//PEMBELIAN BAHAN BAKU
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
				pembelian_bahan_penolong_produksi='$pembelian_bahan_penolong_produksi'
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
					pembelian_bahan_penolong_produksi='$pembelian_bahan_penolong_produksi'
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

$column_header='tanggal,pembeli,no_npwp,no_faktur,no_invoice_masukkan,amount_rp,ppn,departement,tidak_dipungut_dpp,tidak_dipungut_ppn,dipungut_dpp,dipungut_ppn';
$column='tanggal,pembeli,no_npwp,no_faktur,no_invoice_masukkan,amount_rp,ppn,departement,tidak_dipungut_dpp,tidak_dipungut_ppn,dipungut_dpp,dipungut_ppn';

$nama_database='akuntansiv3_faktur_keluaran';
//$nama_database_items='admin_purchasing_items';

$address='?menu=home&mod=akuntansiv3/fakturkeluaran';

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
$tarik_data=$_POST['tarik_data'];
if ($tarik_data=='') {
echo "<table style='margin-bottom:10px;'><tr>";
echo "<form method ='post' action=''>";
echo "<td><input type='submit' name='submit' value='Tarik Data'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='tarik_data' value='1'></td></form>";
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




			if ($tarik_data) {
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

			// echo "<i>*Download excel untuk Update data dan tambah data,</br>*Jika nomor faktur sudah ada sebelumnya data akan terupdate,</br>*Jika nomor faktur belum ada sebelumnya data akan ditambah.</i>";

			//VARIABEL PERIODE
			// $awal_periode1="2018-01-01";
			// $awal_periode2=date('Y-m-d',strtotime('-1 days', strtotime($_POST[akhir_periode1])));
			$akhir_periode1=$_POST['akhir_periode1'];
			$akhir_periode2=$_POST['akhir_periode2'];
			//VARIABEL PERIODE END


			//FORM KALENDER
			echo "<table style='font-size:15px;'>";
			echo "<form method='POST' action='$address'>";

			echo "<tr>";
			echo "<td>Periode</td>";
			echo "<td>:</td>";
			echo "<td><input type='text' class='date' name='akhir_periode1' value='$akhir_periode1' autocomplete='off';></td>";
			echo "<td>s/d</td>";
			echo "<td><input type='text' class='date' name='akhir_periode2' value='$akhir_periode2' autocomplete='off';></td>";
			// echo "</tr>";
			// echo "</table>";

			echo "<input type='hidden' name='halaman' value='$nomor_halaman'>
						<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
						<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
						<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
						<input type='hidden' name='pencarian' value='$pencarian'>
						<input type='hidden' name='tarik_data' value='1'>";

			// echo "<table style='font-size:15px;'>";
			// echo "<tr>";
				echo "<td><input type='submit' name='show' value='Tarik'></td>";
			echo "</tr>";

			echo "</form>";
			echo "</table>";
			//FORM KALENDER END

// $query=mysql_query("SELECT *,SUM(amount_rp) AS tamount_rp FROM deliverycl_invoice_items WHERE tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2' GROUP BY induk");
// while ($rows1=mysql_fetch_array($query)){
// 		 echo "$rows1[induk] - $rows1[tamount_rp]</br></br></br>";
// }

if ($akhir_periode1!='' AND $akhir_periode2!='') {

$query=mysql_query("SELECT * FROM deliverycl_invoice WHERE tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2' AND status='Selesai' AND nomor_faktur!=''");
while ($rows1=mysql_fetch_array($query)){
				if (ambil_database(no_invoice_masukkan,akuntansiv3_faktur_keluaran,"no_invoice_masukkan='$rows1[no_invoice]'")) {
					$nilai='';
				}else {
					$nilai=$rows1['no_invoice'];
					$npwp=ambil_database(npwp,booking_perusahaan,"perusahaan='$rows1[perusahaan]'");
					$nilai_departement=ambil_database(departement,booking_invoice,"no_invoice='$rows1[no_invoice]'");
					if ($nilai_departement) {
						$departement=$nilai_departement;
					}else {
						$departement=ambil_database(departement,master_user,"email='".ambil_database(user_upload,deliverycl_invoice,"no_invoice='$rows1[no_invoice]'")."'");
					}

          $no_aju=ambil_database(NOMOR_AJU,ceisa_dokumen,"NOMOR_DOKUMEN='$rows1[no_invoice]'");
          $no_pendaftaran=ambil_database(NOMOR_DAFTAR,ceisa_header,"NOMOR_AJU='$no_aju'");
          $kurs=ambil_database(kurs,financecl_kurs,"tanggal='$rows1[tanggal]'");
          $cif_dokumen=ambil_database(CIF,ceisa_header,"NOMOR_AJU='$no_aju'");
          $harga_penyerahan_dokumen=ambil_database(HARGA_PENYERAHAN,ceisa_header,"NOMOR_AJU='$no_aju'");
          $kurs_dokumen=ambil_database(NDPBM,ceisa_header,"NOMOR_AJU='$no_aju'");

          $dpp=$rows1[jumlah_dpp];
          $ppn=$rows1[jumlah_ppn];

          $dpp_usd=$dpp/$kurs;
          $ppn_usd=$ppn/$kurs;

          $status_selisih=$dpp-$harga_penyerahan_dokumen;

          if ($no_aju=='') {
            $keterangan_barang="";
          }else {
            $keterangan_barang=ambil_variabel(inventory_distribusi_items,keterangan,"WHERE nomor_aju='$no_aju' GROUP BY keterangan");
          }
          $nomor_faktur="$rows1[kode_jenis_transaksi]$rows1[fg_pengganti]$rows1[nomor_faktur]";
					mysql_query("INSERT INTO akuntansiv3_faktur_keluaran SET tanggal='$rows1[tanggal]'
					pembeli='$rows1[perusahaan]',
					no_npwp='$npwp',
	                no_faktur='$nomor_faktur',
					no_invoice_masukkan='$rows1[no_invoice]',
					departement='$departement',
                    no_aju='$no_aju',
                    no_pendaftaran='$no_pendaftaran',
                    kurs='$kurs',
                    cif_dokumen='$cif_dokumen',
                    harga_penyerahan_dokumen='$harga_penyerahan_dokumen',
                    kurs_dokumen='$kurs_dokumen',
                    amount_rp='$dpp',
                    ppn='$ppn',
                    dpp_usd='$dpp_usd',
                    ppn_usd='$ppn_usd',
                    status_selisih='$status_selisih',
                    keterangan='$keterangan_barang'
					-- tanggal='$rows1[no_invoice]',
					");
          //INPUT ITEMS
          $result_items=mysql_query("SELECT * FROM deliverycl_invoice_items WHERE induk='$rows1[no_invoice]'");
          while ($rows_items=mysql_fetch_array($result_items)) {
            mysql_query("INSERT INTO akuntansiv3_faktur_keluaran_items SET no_faktur='$nomor_faktur',
                no_invoice_masukkan='$rows1[no_invoice]',
                material_code_customer='$rows_items[material_code_customer]',
                item_name='$rows_items[item_name]',
                satuan='$rows_items[satuan]',
                nilai_dpp='$rows_items[nilai_dpp]',
                nilai_ppn='$rows_items[nilai_ppn]',
                tanggal='$rows1[tanggal]',
                pembeli='$rows1[perusahaan]',
                no_npwp='$npwp',
                departement='$departement'
            ");
          }
          //INPUT ITEMS END



// tanggal,pembeli,no_npwp,no_faktur,no_invoice_masukkan,amount_rp ,ppn,nilai,hasil ,departement,tidak_dipungut_dpp,tidak_dipungut_ppn,dipungut_dpp,dipungut_ppn
				}
	$datasecs[]="".$nilai."";
}

$data=implode("','", $datasecs);
// // $query2=mysql_query("SELECT *,SUM(amount_rp) AS tamount_rp,SUM(amount) AS tamount FROM deliverycl_invoice_items WHERE induk IN ('$data') GROUP BY induk");
// $query2=mysql_query("SELECT * FROM deliverycl_invoice_items WHERE induk IN ('$data') GROUP BY induk");
// while ($rows2=mysql_fetch_array($query2)){
//
// 	// if ($rows2[jenis_mata_uang]=='USD') {
// 	// 	$dpp=$rows2[tamount_rp];
// 	// 	$ppn=floor(($dpp*11)/100);
// 	// }elseif ($rows2[jenis_mata_uang]=='RP') {
// 	// 	$dpp=$rows2[tamount];
// 	// 	$ppn=floor(($dpp*11)/100);
// 	// }
// 	$dpp=total_setelah_diskon($rows2[induk]);
// 	$ppn=total_setelah_ppn($rows2[induk]);
//
//   $dpp_usd=$dpp/$kurs;
//   $ppn_usd=$ppn/$kurs;
//
//   $status_selisih=
//
// 	mysql_query("UPDATE akuntansiv3_faktur_keluaran SET amount_rp='$dpp',
//                                                       ppn='$ppn',
//                                                       dpp_usd='$dpp_usd',
//                                                       ppn_usd='$ppn_usd',
//                                                       status_selisih=''
//                                                       WHERE no_invoice_masukkan='$rows2[induk]'");
// }

$query3=mysql_query("SELECT * FROM akuntansiv3_faktur_keluaran WHERE no_invoice_masukkan IN ('$data')");
while ($rows3=mysql_fetch_array($query3)){
		if(substr($rows3[no_faktur],0,2)=='01' OR substr($rows3[no_faktur],0,2)=='05' OR substr($rows3[no_faktur],0,2)=='04'){
			$dipungut_dpp=$rows3[amount_rp]; $dipungut_ppn=$rows3[ppn]; $tidak_dipungut_dpp=''; $tidak_dipungut_ppn='';
		}elseif (substr($rows3[no_faktur],0,2)=='07' OR substr($rows3[no_faktur],0,2)=='08') {
			$dipungut_dpp=''; $dipungut_ppn=''; $tidak_dipungut_dpp=$rows3[amount_rp]; $tidak_dipungut_ppn=$rows3[ppn];
		}else{}

			mysql_query("UPDATE akuntansiv3_faktur_keluaran SET dipungut_dpp='$dipungut_dpp',dipungut_ppn='$dipungut_ppn',tidak_dipungut_dpp='$tidak_dipungut_dpp',tidak_dipungut_ppn='$tidak_dipungut_ppn' WHERE id='$rows3[id]'");

}
echo "Tarik Data Berhasil";
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