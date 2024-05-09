<?php global $mod;
	$mod='deliverycls/salescontract';
function editmenu(){extract($GLOBALS);}

function dollar_2($angka){
$hasil_rupiah = "$ " . number_format($angka,2,',','.');
return $hasil_rupiah;}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function nilai_per_satuan($jumlah_nilai_satuan,$nama_database_items,$id,$satuan,$kolom){
 $result3=mysql_query("SELECT $kolom FROM $nama_database_items WHERE induk='$id' AND satuan='$satuan'");
 	while ($rows3=mysql_fetch_array($result3)){
	$harga_per_satuan=$rows3[$kolom]+$harga_per_satuan;
 }
 return $harga_per_satuan;}

function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,no_sales_contract,nama_penerima_barang,jabatan_penerima_barang,dari,alamat,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,nama_penerima_barang,jabatan_penerima_barang,dari,pembuat,tgl_dibuat';

$nama_database='deliverycls_sales_contract';
$nama_database_items='deliverycls_sales_contract_items';

$address='?mod=deliverycls/salescontract';

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
include 'style.css';
echo kalender();
echo combobox();

//Kembali
echo "<table><tr><td>";
echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
//Kembali END
echo "</td><td>";
//Print
echo "<form method ='POST' action='modules/deliverycls/cetak/cetak_salescontract.php' target='_blank'>";
echo "<input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			</form>";
echo "</td></tr></table>";
//Print END


//HEADER PERTAMA
echo "<table style='width:100%;'>";
echo "<tr>
				<td style='width:25%;'><center><img src='modules/gambar/logo_chinli.png' width='30%'/><center></td>
				<td style='width:50%;'><center><img src='modules/gambar/logo_lengkap2.png' width='100%'/><center></td>
				<td style='width:25%;'></td>
			</tr>";
echo "</table>";

echo "<table style='width:100%; margin-top:20px;'>";
echo "<tr><td><center><h2>SALES CONTRACT</br>".ambil_database(no_sales_contract,$nama_database,"id='$id'")."</h2><center></td></tr>";
echo "</table>";
//HEADER PERTAMA END

//HEADER KEDUA
echo "<table>";
echo "<tr>";
echo "<td>Yang bertanda tangan dibawah ini</td>";
echo "<td>:</td>";
echo "<tr>";
echo "</table>";

echo "<table style='width:100%; text-align:left;'>";
echo "<tr>";
echo "<td>1.</td>";
echo "<td style='width:130px;'>NAMA</td>";
echo "<td>:</td>";
echo "<td>LU HUNG TA</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>JABATAN</td>";
echo "<td>:</td>";
echo "<td>DIREKTUR</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>ALAMAT</td>";
echo "<td>:</td>";
echo "<td>Jl. Millenium Raya Blok L3 No.1A,Kawasan Millenium, Kel.Peusar</td>";
echo "<tr>";
echo "</table>";
//HEADER KEDUA END

//HEADER KETIGA
echo "<table style='margin-top:20px;'>";
echo "<tr>";
echo "<td>Bertindak untuk dan atas nama PT CHINLI PLASTIC TECHNOLOGY INDONESIA Yang berkedudukan di Jl. Millenium Raya Blok L3 No.1A,Kawasan Millenium,</br>
Kel.Peusar, Kec. Panongan,Kab.Tangerang,Banten</br>
Yang mengeluarkan barang untuk tujuan dijual selanjutnya disebut pihak I (Pertama)</td>";
echo "<tr>";
echo "<table>";

echo "<table style='width:100%; text-align:left; margin-top:20px;'>";
echo "<tr>";
echo "<td>2.</td>";
echo "<td style='width:130px;'>NAMA</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(nama_penerima_barang,$nama_database,"id='$id'")."</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>JABATAN</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(jabatan_penerima_barang,$nama_database,"id='$id'")."</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>ALAMAT</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(alamat,$nama_database,"id='$id'")."</td>";
echo "<tr>";
echo "</table>";
//HEADER KETIGA END


//HEADER KEEMPAT
echo "<table style='margin-top:20px;'>";
echo "<tr>";
echo "<td>Dalam hal ini bertindak untuk dan atas nama ".ambil_database(dari,$nama_database,"id='$id'").", sebagai pembeli barang, yang selanjutnya disebut</br>
sebagai Pihak II (Kedua).</td>";
echo "<tr>";
echo "</table>";

echo "<table style='margin-top:20px;'>";
echo "<tr>";
echo "<td>Pihak I (Pertama) dan Pihak II (Kedua) dengan ini mengadakan Kontrak Jual Beli.</br>Perjanjian Jual Beli ini diatur sebagai Berikut :</td>";
echo "</tr>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px;'>ARTICLE I: COMMODITY</td>";
echo "</tr>";
echo "</table>";
//HEADER KEEMPAT END

if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){

//UPDATE
if ($_POST['tambah_ppn']) {
mysql_query("UPDATE $nama_database SET ppn='$_POST[ppn]' WHERE id='$id'");}

if ($_POST['tambah_discount']) {
mysql_query("UPDATE $nama_database SET discount='$_POST[discount]' WHERE id='$id'");}
//UPDATE END

//INSERT
if ($_POST['tambah_invoice']) {
$id_invoice=$_POST['no_invoice'];
$no_invoice=ambil_database(no_invoice,deliverycls_invoice,"id='$id_invoice'");
if (ambil_database(no_invoice,$nama_database_items,"no_invoice='$no_invoice'")=='') {
$result=mysql_query("SELECT * FROM deliverycls_invoice_items WHERE induk='$id_invoice'");
while ($rows=mysql_fetch_array($result)) {
	$material_description_po=$rows['material_description_po'];
	$po_nomor=$rows['po_nomor'];
	$satuan=$rows['satuan'];
	$total_pairs=$rows['total_pairs'];
	if ($rows[mata_uang]=='Rupiah') {
		$harga_satuan='';
		$total_harga_satuan='';
	}else {
		$harga_satuan=$rows['harga_satuan'];
		$total_harga_satuan=$rows['total_harga_satuan'];
	}
	mysql_query("INSERT INTO $nama_database_items SET induk='$id',no_invoice='$no_invoice',material_description_po='$material_description_po',po_nomor='$po_nomor',satuan='$satuan',total_pairs='$total_pairs',harga_satuan='$harga_satuan',total_harga_satuan='$total_harga_satuan'");
}}}//INSERT END


//FINISH
if ($_GET['fnh']) {
	mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$id'");
}
echo "<table><tr><td>";
if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo '<a onclick="return confirm(\''."Finish it?".' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt("$id","XblImpl1!A@")."&fnh=1&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/finish.png" height="25px"/></a>';
}
echo "</td></tr>";
echo "</table>";
//FINISH END


if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
echo "<table style='margin-top:20px;'>";
echo "<tr>";
echo "<td>No Invoice</td>";
echo "<td>:</td>";

echo "<form method='POST' action='$address'>";
$nilai_no_invoice=ambil_variabel_kutip_satu_where($nama_database_items,no_invoice,"");
$dari=ambil_database(dari,$nama_database,"id='$id'");
$sql113="SELECT * FROM deliverycls_invoice WHERE status='Selesai' AND dari='$dari' AND no_invoice NOT IN ($nilai_no_invoice) ORDER BY tanggal";
$result113=mysql_query($sql113);
echo "<td>
<select class='comboyuk' name='no_invoice'>
<option value=''></option>";
while ($rows113=mysql_fetch_array($result113)) {
echo "<option value='$rows113[id]'>$rows113[no_invoice] | $rows113[tanggal] | $rows113[dari]</option>";}
echo "
</select>
</td>";

echo "
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='opsi' value='$opsi'>
<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
<input type='hidden' name='pencarian' value='$pencarian'>
<input type='hidden' name='tambah_invoice' value='y'>
<td><input type='image' src='modules/gambar/tambah.png' width='25' height'25' name='simpan' value='Simpan'></td>";
echo "</form>";
echo "</tr>";}
echo "</table>";}


echo "<table style='margin-top:20px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 1</td>";
echo "</tr>";
echo "</table>";

echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>a. Pihak II (Kedua) membeli barang dari Pihak I  (Pertama), dengan Uraian sebagai berikut :</td>";
echo "</tr>";
echo "</table>";


echo "<table class='tabel_utama' style='margin-top:5px; width:100%;'>";
echo "<thead>";
echo "<th>No</th>";
echo "<th>GOODS DESCRIPTION</th>";
echo "<th>PO NO</th>";
echo "<th colspan='2'>QUANTITY</th>";
echo "<th>UNIT PRICE (USD)</th>";
echo "<th>AMOUNT (USD)</th>";
echo "</thead>";

$no=1;
$result1=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows1=mysql_fetch_array($result1)) {
echo "<tr>";
echo "<td>$no</td>";
echo "<td>$rows1[material_description_po]</td>";
echo "<td>$rows1[po_nomor]</td>";
echo "<td>$rows1[satuan]</td>";
echo "<td>$rows1[total_pairs]</td>";
echo "<td style='text-align:right; text-align:right; padding: 0px 15px 0px 0px;'>".dollar($rows1[harga_satuan])."</td>";
echo "<td style='text-align:right; text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($rows1[total_harga_satuan])."</td>";
echo "</tr>";

$total_pairs=$rows1[total_pairs]+$total_pairs;
$satuan=$rows1[satuan];
$total_harga=$rows1[total_harga_satuan]+$total_harga;
$no++;}

// echo "<tr>";
// echo "<td colspan='7'; style='background-color:black;'></td>";
// echo "</tr>";

$nilai_satuan=ambil_variabel_tanpa_kutip_where_distinct($nama_database_items,satuan,"WHERE induk='$id'");
$pecah_nilai_satuan=pecah($nilai_satuan);
$jumlah_nilai_satuan=nilai_pecah($nilai_satuan);

echo "<tr>";
echo "<td rowspan='4';></td>";
echo "<td style='font-weight:bold; font-size:12px;'>TOTAL</td>";

///////////////////////////////////////////////////////////////////////////////////////////////////
echo "<td style='font-weight:bold; font-size:12px;' colspan='2';>";
$no=0;for($i=0; $i < $jumlah_nilai_satuan; ++$i){

 echo "$pecah_nilai_satuan[$no]</br>";

$no++;}
echo "</td>";
///////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////
echo "<td style='font-weight:bold; font-size:12px;'>";
$no=0;for($i=0; $i < $jumlah_nilai_satuan; ++$i){
  echo nilai_per_satuan($jumlah_nilai_satuan,$nama_database_items,$id,$pecah_nilai_satuan[$no],total_pairs)."</br>";
$no++;}
echo "</td>";
///////////////////////////////////////////////////////////////////////////////////////////////////

echo "<td></td>";
///////////////////////////////////////////////////////////////////////////////////////////////////
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>";
$no=0;for($i=0; $i < $jumlah_nilai_satuan; ++$i){
  echo dollar_2(nilai_per_satuan($jumlah_nilai_satuan,$nama_database_items,$id,$pecah_nilai_satuan[$no],total_harga_satuan))."</br>";
$no++;}
echo "</td>";
//echo "<td style='font-weight:bold; font-size:12px;'>".dollar($total_harga)."</td>";
echo "</tr>";
///////////////////////////////////////////////////////////////////////////////////////////////////

//DISCOUNT
echo "<tr>";
if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
echo "<form method='POST' action='$address'>";
echo "<td style='font-weight:bold; font-size:12px;'>DISCOUNT <input type='text' name='discount' value='".ambil_database(discount,$nama_database,"id='$id'")."' style='width:20px;'> %";
echo "
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='opsi' value='$opsi'>
<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
<input type='hidden' name='pencarian' value='$pencarian'>
<input type='hidden' name='tambah_discount' value='y'>
<input type='image' src='modules/gambar/save.png' width='15' name='simpan' value='Simpan'></td>";
echo "</form>";
}else {
echo "<td style='font-weight:bold; font-size:12px;'>DISCOUNT ".ambil_database(discount,$nama_database,"id='$id'")."%</td>";
}
$nilai_discount1=$total_harga*ambil_database(discount,$nama_database,"id='$id'")/100;
echo "<td colspan='4';></td>";
//echo "<td rowspan='3';></td>";
//echo "<td rowspan='3';></td>";
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($nilai_discount1)."</td>";
echo "</tr>";
//DISCOUNT END

//PPN
$total_harga_dikurang_discount=$total_harga-$nilai_discount1;
echo "<tr>";
if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
echo "<form method='POST' action='$address'>";
echo "<td style='font-weight:bold; font-size:12px;'>PPN <input type='text' name='ppn' value='".ambil_database(ppn,$nama_database,"id='$id'")."' style='width:20px;'> %";
echo "
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='opsi' value='$opsi'>
<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
<input type='hidden' name='pencarian' value='$pencarian'>
<input type='hidden' name='tambah_ppn' value='y'>
<input type='image' src='modules/gambar/save.png' width='15' name='simpan' value='Simpan'></td>";
echo "</form>";
}else {
echo "<td style='font-weight:bold; font-size:12px;'>PPN ".ambil_database(ppn,$nama_database,"id='$id'")."%</td>";
}
$nilai_ppn1=$total_harga_dikurang_discount*ambil_database(ppn,$nama_database,"id='$id'")/100;
echo "<td colspan='4';></td>";
//echo "<td rowspan='3';></td>";
//echo "<td rowspan='3';></td>";
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($nilai_ppn1)."</td>";
echo "</tr>";
//PPN END

echo "<tr>";
echo "<td style='font-weight:bold; font-size:12px;'>GRAND TOTAL</td>";

$nilai_grand_total=$total_harga_dikurang_discount-$nilai_ppn1;
echo "<td colspan='4';></td>";
//echo "<td rowspan='3';></td>";
//echo "<td rowspan='3';></td>";
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($nilai_grand_total)."</td>";
echo "</tr>";
echo "</table>";

echo "<table>";
echo "<tr>";
echo "<td>
b. Tanggal Perjanjian Jual Beli : ".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</br>
c. Tanggal Pengiriman barang :  ".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</br>
d. Jangka waktu perjanjian : 30 hari ( 1 bulan )	</br>
e. Biaya proses pekerjaan seperti tertera pada PO dan cara pembayaran diatur tersendiri.
</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 2</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>Pengeluaran barang dari pihak I (Pertama) Ke pihak II (Kedua) akan dilaksanakan sekali pengiriman</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 3</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>Pihak I (Pertama) akan mengirim barang  seperti tertera pada pasal 1 kepada Pihak II (Kedua) dan sesuai</br>
mengenai jumlah/mutu dan ketepatan tanggal pengiriman barang jadi.</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 4</td>";
echo "</tr>";
echo "</table>";

echo "<table>";
///////////////////////////////////////
echo "<tr>";
if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){

//UPDATE FOC
if ($_POST['foc']) {
	mysql_query("UPDATE $nama_database SET foc='$_POST[foc]' WHERE id='$id'");
}//UPDATE FOC END

echo "<form method='POST' action='$address'>";

echo "<td>
<select class='comboyuk' name='foc'>
<option value='".ambil_database(foc,$nama_database,"id='$id'")."'>".ambil_database(foc,$nama_database,"id='$id'")."</option>
<option value='FOC'>FOC</option>
<option value='No FOC'>No FOC</option>
</select>";

echo "
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='opsi' value='$opsi'>
<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
<input type='hidden' name='pencarian' value='$pencarian'>
<input type='image' src='modules/gambar/save.png' width='25' name='simpan' value='Simpan'></td>";
echo "</form>";
}
echo "</tr>";
////////////////////////////////////////

echo "<tr>";
if (ambil_database(foc,$nama_database,"id='$id'")=='FOC') {
	echo "<td style='font-size:30px;'>FOC</td>";
}else {
	echo "<td style=''>
	Waktu pembayaran adalah 30 hari setelah tanggal pengiriman barang. Pembayaran dengan cara ditransfer</br>
	ke nomor rekening bank :</br>
	ACCOUNT NAMA: PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</br>
	BANK:  BANK CTBC INDONESIA</br>
	ACCOUNT NO.:  102028100272002 (USD)</br>
	ACCOUNT NO.:  102018100272001 (RP)
	</td>";
}
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 5</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>Kontrak jual beli ini dianggap sah/berlaku apabila telah selesai mengirim barang jadi</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 6</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>
Hal-hal lain yang terkait dengan proses perjanjian Jual beli tersebut diatas yang belum diatur dalam perjanjian ini akan dibicarakan</br>
/diatur kemudian
</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; font-size:17px;'>";
echo "<tr>
			<td style='text-align:center; font-weight:20px;'>Tangerang, ".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</td>
			</tr>";
echo "</table>";

echo "<table style='width:100%; font-size:17px;'>";
echo "<tr>
			<td style='width:40%; text-align:center; font-weight:20px;'>Pihak I</td>
						<td style='width:20%; text-align:center; font-weight:20px;'></td>
			<td style='width:40%; text-align:center; font-weight:20px;'>Pihak II</td>
			</tr>";
echo "<tr>
			<td style='text-align:center; font-weight:20px;'>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</td>
						<td style='text-align:center; font-weight:20px;'></td>
			<td style='text-align:center; font-weight:20px;'>".ambil_database(dari,$nama_database,"id='$id'")."</td>
			</tr>";
echo "</table>";



echo "<table style='width:100%; font-size:17px; margin-top:100px;'>";
echo "<tr>
			<td style='width:40%; text-align:center; font-weight:20px;'>LU HUNG TA</td>
						<td style='width:20%; text-align:center; font-weight:20px;'></td>
			<td style='width:40%; text-align:center; font-weight:20px;'>".ambil_database(nama_penerima_barang,$nama_database,"id='$id'")."</td>
			</tr>";
echo "<tr>
			<td style='text-align:center; font-weight:20px;'>DIREKTUR</td>
						<td style='text-align:center; font-weight:20px;'></td>
			<td style='text-align:center; font-weight:20px;'>".ambil_database(jabatan_penerima_barang,$nama_database,"id='$id'")."</td>
			</tr>";
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
