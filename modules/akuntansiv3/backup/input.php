<?php global $mod;
	$mod='akuntansiv3/input';
function editmenu(){extract($GLOBALS);}

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
		include 'modules/deliverycl/download/excel_reader.php';
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

		$induk=$_POST['id'];
		//hapus data sebelum IMPORT
		mysql_query("DELETE FROM deliverycl_invoice_items WHERE induk='$induk'");

		$berhasil = 0;
		for ($i=2; $i<=$jumlah_baris; $i++){
			// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
			$qty=$data->val($i, 1);//
			$item_name=$data->val($i, 2);//
			$bucket=$data->val($i, 3);//
			$material_code_customer=$data->val($i, 4);//
			$material_code=$data->val($i, 5);//
			$po=$data->val($i, 6);//
			$surat_jalan=$data->val($i, 7);//
			$jenis_mata_uang=$data->val($i, 8);//
			$price=$data->val($i, 9);//
			$amount=$price*$qty;

			$update_1="INSERT INTO deliverycl_invoice_items SET induk='$induk',qty='$qty',item_name='$item_name',bucket='$bucket',material_code_customer='$material_code_customer',material_code='$material_code',po='$po',surat_jalan='$surat_jalan',jenis_mata_uang='$jenis_mata_uang',price='$price',amount='$amount'";
			$eksekusi_update_1=mysql_query($update_1);
		}

		// hapus kembali file .xls yang di upload tadi
		unlink($_FILES['pelengkap']['name']);
return ;}


function format_tanggal_invoice($tanggal){

$tgl=substr($tanggal,8,2);
$bulan=substr($tanggal,5,2);
	if ($bulan=='01'){$bln='Januari';}
	elseif ($bulan=='02'){$bln='Februari';}
	elseif ($bulan=='03'){$bln='Maret';}
	elseif ($bulan=='04'){$bln='April';}
	elseif ($bulan=='05'){$bln='Mei';}
	elseif ($bulan=='06'){$bln='Juni';}
	elseif ($bulan=='07'){$bln='Juli';}
	elseif ($bulan=='08'){$bln='Agustus';}
	elseif ($bulan=='09'){$bln='September';}
	elseif ($bulan=='10'){$bln='Oktober';}
	elseif ($bulan=='11'){$bln='November';}
	elseif ($bulan=='12'){$bln='Desember';}
	else{$bln='';}
$tahun=substr($tanggal,0,4);
$tanggal="$tgl $bln $tahun";
return $tanggal;}

function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,no_invoice,perusahaan,alamat,tanggal_tutup_buku,po_nomor,paymen_term,kode_jenis_transaksi,fg_pengganti,nomor_faktur,masa_pajak,tahun_pajak,tanggal_faktur,user_upload,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,no_invoice,ppn_10,discount,kode_jenis_transaksi,fg_pengganti,nomor_faktur,masa_pajak,tahun_pajak,tanggal_faktur,pembuat,tgl_dibuat';

$nama_database='deliverycl_invoice';
$nama_database_items='deliverycl_invoice_items';

$address='?mod=akuntansiv3/input';

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

$no_invoice=ambil_database(no_invoice,deliverycl_invoice,"id='$id'");



//print
if ($_POST['save_list']=='1') {
	echo "<script type='text/javascript'>window.open('modules/laporanversidua/download/print_dokumen.php?jenis_dokumen=$jenis_dokumen&pilihan_bulan=$pilihan_bulan&pilihan_tahun=$pilihan_tahun')</script>";
}


//START ITEM
if ($opsi=='item'){
  include 'style.css';

	include kalender();
	include combobox();


		$column_header="Delivery Date,Nomor Aju,Surat Jalan,Sales Order,Invoice ,Invoice Date,Faktur,Faktur Date,QTY,Price,DPP (USD) ,PPN (USD),DPP (Rp),PPN (Rp),Total,Debit,Kredit,Input Date,Kode Voucher,Nama Barang,Nama Perusahaan";
		$pecah_header=pecah($column_header);
		$nilai_header=nilai_pecah($column_header);



	//Kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	echo "</td>";




//INSERT UPDATE
if ($_POST[insert_update]==1) {

	$debit=$_POST[debit];
	$kredit=$_POST[kredit];
	$tanggal=$_POST[tanggal];
	$kode_voucher=$_POST[kode_voucher];
	//$no_invoice2=$_POST[no_invoice2];
	$total=$_POST[total];
	$id_dipilih=$_POST[id_dipilih];

	if ($id_dipilih) {
	$no=0;for($i=0; $i < count($_POST['id_dipilih']); ++$i){

		$debit1=$debit[$no];
		$kredit1=$kredit[$no];
		$tanggal1=$tanggal[$no];
		$kode_voucher1=$kode_voucher[$no];
		$id_dipilih1=$id_dipilih[$no];
		$total1=$total[$no];
		//$no_invoice=$no_invoice[$no];


		$tanggal_input=date('Y-m-d');
		$nama=ambil_database(keterangan,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");



if (ambil_database(induk_invoice,akuntansiv3_jurnal,"induk_invoice='$id_dipilih1'")=='' AND $debit1!='' AND $kredit1!='') {
		//DEBIT
		$keterangan_debit=ambil_database(nama,akuntansiv3_akun,"nomor='$debit1'");
		$pembeda_saldo_awal_debit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$debit1'");
		$pembeda_laba_rugi_debit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$debit1'");
				mysql_query("INSERT INTO akuntansiv3_jurnal SET
					ref='$kode_voucher1',
					induk_invoice='$id_dipilih1',
					tanggal='$tanggal1',
					tanggal_input='$tanggal_input',
					nama='Debit',
					nomor='$debit1',
					keterangan='$keterangan_debit',
					keterangan_posting='$no_invoice',
					debit='$total1',
					kredit='',
					pembeda_neraca='$pembeda_saldo_awal_debit',
					pembeda_laba_rugi='$pembeda_laba_rugi_debit'
					");

		//KREDIT
		$keterangan_kredit=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit1'");
		$pembeda_saldo_awal_kredit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$kredit1'");
		$pembeda_laba_rugi_kredit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$kredit1'");
				mysql_query("INSERT INTO akuntansiv3_jurnal SET
					ref='$kode_voucher1',
					induk_invoice='$id_dipilih1',
					tanggal='$tanggal1',
					tanggal_input='$tanggal_input',
					nama='Kredit',
					nomor='$kredit1',
					keterangan='$keterangan_kredit',
					keterangan_posting='$no_invoice',
					debit='',
					kredit='$total1',
					pembeda_neraca='$pembeda_saldo_awal_kredit',
					pembeda_laba_rugi='$pembeda_laba_rugi_kredit'");

}elseif(ambil_database(induk_invoice,akuntansiv3_jurnal,"induk_invoice='$id_dipilih1'")!='' AND $debit1!='' AND $kredit1!=''){


	//DEBIT
	$keterangan_debit=ambil_database(nama,akuntansiv3_akun,"nomor='$debit1'");
	$pembeda_saldo_awal_debit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$debit1'");
	$pembeda_laba_rugi_debit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$debit1'");
			mysql_query("UPDATE akuntansiv3_jurnal SET
				ref='$kode_voucher1',
				induk_invoice='$id_dipilih1',
				tanggal='$tanggal1',
				tanggal_input='$tanggal_input',
				nama='Debit',
				nomor='$debit1',
				keterangan='$keterangan_debit',
				keterangan_posting='$no_invoice',
				debit='$total1',
				kredit='',
				pembeda_neraca='$pembeda_saldo_awal_debit',
				pembeda_laba_rugi='$pembeda_laba_rugi_debit'
				WHERE induk_invoice='$id_dipilih1' AND kredit='';
				");

	//KREDIT
	$keterangan_kredit=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit1'");
	$pembeda_saldo_awal_kredit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$kredit1'");
	$pembeda_laba_rugi_kredit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$kredit1'");
			mysql_query("UPDATE akuntansiv3_jurnal SET
				ref='$kode_voucher1',
				induk_invoice='$id_dipilih1',
				tanggal='$tanggal1',
				tanggal_input='$tanggal_input',
				nama='Kredit',
				nomor='$kredit1',
				keterangan='$keterangan_kredit',
				keterangan_posting='$no_invoice',
				debit='',
				kredit='$total1',
				pembeda_neraca='$pembeda_saldo_awal_kredit',
				pembeda_laba_rugi='$pembeda_laba_rugi_kredit'
				WHERE induk_invoice='$id_dipilih1' AND debit='';
				");



}else{}


	$no++;}
	}

}//INSERT UPDATE END






	echo "<form method='POST'>";
	echo "<td><input type='image' src='modules/gambar/save.png' width='25' height'25' name='print' value='print'></td>";

	echo "<input type='hidden' name='id' value='$id'>";
	echo "<input type='hidden' name='halaman' value='$nomor_halaman'>";
	echo "<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>";
	echo "<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>";
	echo "<input type='hidden' name='pencarian' value='$pencarian'>";
	echo "<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>";
	echo "<input type='hidden' name='opsi' value='item'>";
	echo "<input type='hidden' name='insert_update' value='1'>";

	echo "</tr></table>";




			$kurs=ambil_database(kurs,financecl_kurs,"tanggal='".ambil_database(tanggal,deliverycl_invoice,"id='$id'")."'");
			$discount=ambil_database(discount,deliverycl_invoice,"id='$id'");
			$ppn=11;


	echo "<table class='tabel_utama' style='width:auto;'>";
	//HEADER TABEL
	echo "<thead>";
	echo "<th style=''><strong>No</strong></th>";

		$no=0;for($i=0; $i < $nilai_header; ++$i){
			echo "<th>".$pecah_header[$no]."</th>";
		$no++;}

	echo "</thead>";



	$query=mysql_query("SELECT deliverycl_invoice.perusahaan,
														 deliverycl_invoice_items.tanggal,
	 													 deliverycl_invoice_items.item_name,
	 													 deliverycl_invoice_items.qty,
	 													 deliverycl_invoice_items.price,
	 													 deliverycl_invoice_items.amount,
	 													 deliverycl_invoice_items.id,
	 													 deliverycl_invoice_items.jenis_mata_uang,
	 													 deliverycl_invoice.no_invoice,
	 													 deliverycl_invoice.nomor_faktur,
	 													 deliverycl_invoice.tanggal_faktur,
	 													 deliverycl_invoice_items.surat_jalan
											FROM deliverycl_invoice
											INNER JOIN deliverycl_invoice_items
											ON deliverycl_invoice.no_invoice=deliverycl_invoice_items.induk
											WHERE deliverycl_invoice_items.induk='$no_invoice'");
	$no =1;



	while ($rows1=mysql_fetch_array($query)){


		//AMOUNT
		$dirupiahkan_amount_rp=$rows1['amount']*$kurs;
		$dirupiahkan_amount_usd=$rows1['amount'];

		//DISKON
		$hasil_diskon_rp=$dirupiahkan_amount_rp*$discount/100;
		$hasil_diskon_usd=$dirupiahkan_amount_usd*$discount/100;


		//SETELAH DI KURANG DISKON
		$hasil_dikurang_diskon_rp=$dirupiahkan_amount_rp-$hasil_diskon;
		$hasil_dikurang_diskon_usd=$dirupiahkan_amount_usd-$hasil_diskon;

		//PPN
		$hasil_ppn_rp=$hasil_dikurang_diskon_rp*$ppn/100;
		$hasil_ppn_usd=$hasil_dikurang_diskon_usd*$ppn/100;




		echo "<tr>";


		echo "<td>$no</td>";
		echo "<td>$rows1[tanggal]</td>";
		echo "<td>".ambil_database(nomor_aju,inventory_distribusi,"nomorinvoiceacc='$rows1[no_invoice]'")."</td>";
		echo "<td>$rows1[surat_jalan]</td>";
		echo "<td></td>";
		echo "<td style='white-space:nowrap; text-align:;'>$rows1[no_invoice]</td>";
		echo "<td>$rows1[tanggal]</td>";
		echo "<td>$rows1[nomor_faktur]</td>";
		echo "<td>$rows1[tanggal_faktur]</td>";
		echo "<td>$rows1[qty]</td>";
		echo "<td>$rows1[price]</td>";
		echo "<td style='white-space:nowrap; text-align:right;'>".dollar($hasil_dikurang_diskon_usd)."</td>";
		echo "<td style='white-space:nowrap; text-align:right;'>".dollar($hasil_ppn_usd)."</td>";
		echo "<td style='white-space:nowrap; text-align:right;'>".rupiah($hasil_dikurang_diskon_rp)."</td>";
		echo "<td style='white-space:nowrap; text-align:right;'>".rupiah($hasil_ppn_rp)."</td>";
		echo "<td style='white-space:nowrap; text-align:right;'>".rupiah($hasil_dikurang_diskon_rp)."</td>";

		echo "<input type='hidden' style='width:75px;' name='total[]' value='$hasil_dikurang_diskon_rp'>";

		//DEBIT
		$sql113="SELECT * FROM akuntansiv3_akun ORDER BY nomor";
	  $result113=mysql_query($sql113);
	  echo "<td>
	  <select class='comboyuk' style='width:150px;' name='debit[]'>
		<option value='".ambil_database(nomor,akuntansiv3_jurnal,"induk_invoice='$rows1[id]' AND kredit=''")."'>".ambil_database(nomor,akuntansiv3_jurnal,"induk_invoice='$rows1[id]' AND kredit=''")." | ".ambil_database(keterangan,akuntansiv3_jurnal,"induk_invoice='$rows1[id]' AND kredit=''")."</option>
	  <option value=''></option>";
	    while ($rows113=mysql_fetch_array($result113)) {
	  echo "<option value='$rows113[nomor]'>$rows113[nomor] | $rows113[nama]</option>";}
	  echo "
	  </select>
	  </td>";
		//DEBIT END

		//KREDIT
		$sql113="SELECT * FROM akuntansiv3_akun ORDER BY nomor";
		$result113=mysql_query($sql113);
		echo "<td>
		<select class='comboyuk' style='width:150px;' name='kredit[]'>
		<option value='".ambil_database(nomor,akuntansiv3_jurnal,"induk_invoice='$rows1[id]' AND debit=''")."'>".ambil_database(nomor,akuntansiv3_jurnal,"induk_invoice='$rows1[id]' AND debit=''")." | ".ambil_database(keterangan,akuntansiv3_jurnal,"induk_invoice='$rows1[id]' AND debit=''")."</option>
		<option value=''></option>";
			while ($rows113=mysql_fetch_array($result113)) {
		echo "<option value='$rows113[nomor]'>$rows113[nomor] | $rows113[nama]</option>";}
		echo "
		</select>
		</td>";
		//KREDIT END


		echo "<td><input type='text' style='width:75px;' class='date' name='tanggal[]' value='".ambil_database(tanggal,akuntansiv3_jurnal,"induk_invoice='$rows1[id]'")."'></td>";

		echo "<td><input type='text' style='width:75px;' name='kode_voucher[]' value='".ambil_database(ref,akuntansiv3_jurnal,"induk_invoice='$rows1[id]'")."'></td>";

		echo "<input type='hidden' style='width:75px;' name='id_dipilih[]' value='$rows1[id]'>";
		echo "<input type='hidden' style='width:75px;' name='no_invoice[]' value='$rows1[no_invoice]'>";


		echo "<td>$rows1[item_name]</td>";
		echo "<td>$rows1[perusahaan]</td>";
		echo "</tr>";
	$no++;}


echo "</form>";
echo "</table>";



}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);


	echo "<table>";
		echo "<tr>";
		echo "<td><form method ='POST' action='modules/akuntansiv3/cetak/print_excel_efaktur.php' target='_blank'>";
		echo "<input type='image' src='modules/gambar/save_excel.png' width='25' height'25' name='print' value='print'>
					<input type='hidden' name='nama_database1' value='$nama_database'>
					<input type='hidden' name='pilihan_tahun1' value='$_POST[pilihan_tahun]'>
					<input type='hidden' name='pilihan_bulan1' value='$_POST[pilihan_bulan]'>
					<input type='hidden' name='pencarian1' value='$_POST[pencarian]'>
					<input type='hidden' name='pilihan_pencarian1' value='$_POST[pilihan_pencarian]'>
					</form></td>";
		echo "</tr>";
	echo "</table>";


	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
