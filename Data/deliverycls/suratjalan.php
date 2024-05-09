<?php global $mod;
	$mod='deliverycls/suratjalan';
function editmenu(){extract($GLOBALS);}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}


function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,no_invoice,dari,alamat,komponent,no_dokumen_bc27,no_aju_bc27,tanggal_dokumen_bc27,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,id_packing_list,pembuat,tgl_dibuat';

$nama_database='deliverycls_surat_jalan';
$nama_database_items='deliverycls_surat_jalan_items';

$address='?mod=deliverycls/suratjalan';

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
echo "<form method ='POST' action='modules/deliverycls/cetak/cetak_suratjalan.php' target='_blank'>";
echo "<input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			</form>";
echo "</td></tr></table>";
//Print END


//UPDATE DOKUMEN 27
if ($_POST['update_dokumen_27']) {
mysql_query("UPDATE $nama_database SET no_dokumen_bc27='$_POST[no_dokumen_bc27]',no_aju_bc27='$_POST[no_aju_bc27]',tanggal_dokumen_bc27='$_POST[tanggal_dokumen_bc27]' WHERE id='$id'");
}//UPDATE DOKUMEN 27 END

//FINISH
if ($_GET['fnh']) {
	mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$id'");
}//FINISH END

//HEADER PERTAMA
echo "<table style='width:100%;'>";
echo "<tr><td><center><img src='modules/gambar/logo_lengkap.png' width='50%'/><center></td></tr>";
echo "<tr><td><center><h1>SURAT JALAN</h1><center></td></tr>";
echo "<table>";
//HEADER PERTAMA END

echo "<table><tr><td>";
if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo '<a onclick="return confirm(\''."Finish it?".' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt("$id","XblImpl1!A@")."&fnh=1&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/finish.png" height="25px"/></a>';
}
echo "</td></tr>";
echo "</table>";

//HEADER KEDUA
echo "<table style='width:100%; font-weight:bold; font-size:12px;'>";
echo "<tr>";
echo "<td style='width:70%;'>CONSIGNEE</td>";
echo "<td style='width:10%;'>INVOICE</td>";
echo "<td style='width:20%;'>: ".ambil_database(no_invoice,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>".ambil_database(dari,$nama_database,"id='$id'")."</td>";
echo "<td>DATE</td>";
echo "<td>: ".ambil_database(tanggal,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td rowspan='2' >".ambil_database(alamat,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='3'>STYLE : ".ambil_database(komponent,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<table>";
//HEADER KEDUA END

//HEADER KETIGA
echo "<table style='width:80%; margin-top:10px; margin-bottom:10px;'>";
echo "<form method='POST' action='$address'>";
	echo "<tr>";

	echo "<td>Nomor Dokumen BC 27</td>";
	echo "<td>:</td>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo "<td><input type='text' name='no_dokumen_bc27' value='".ambil_database(no_dokumen_bc27,$nama_database,"id='$id'")."'</td>";
	}else {
	echo "<td>".ambil_database(no_dokumen_bc27,$nama_database,"id='$id'")."</td>";
	}

	echo "<td>Nomor Aju BC 27</td>";
	echo "<td>:</td>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo "<td><input type='text' name='no_aju_bc27' value='".ambil_database(no_aju_bc27,$nama_database,"id='$id'")."'</td>";
	}else {
	echo "<td>".ambil_database(no_aju_bc27,$nama_database,"id='$id'")."</td>";
	}

	echo "<td>Tanggal BC 27</td>";
	echo "<td>:</td>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo "<td><input type='text' name='tanggal_dokumen_bc27' class='date' value='".ambil_database(tanggal_dokumen_bc27,$nama_database,"id='$id'")."'</td>";
	}else {
	echo "<td>".ambil_database(tanggal_dokumen_bc27,$nama_database,"id='$id'")."</td>";
	}

	if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo "
	<input type='hidden' name='id' value='$id'>
	<input type='hidden' name='opsi' value='$opsi'>
	<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
	<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
	<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
	<input type='hidden' name='pencarian' value='$pencarian'>
	<input type='hidden' name='update_dokumen_27' value='y'>
	<td><input type='image' src='modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";
	echo "</form>";}

echo "</tr>";
echo "</table>";
//HEADER KETIGA END

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

//ISI KOLOM
echo "<table class='tabel_utama' style='width:100%;'>";

//HEADER
echo "<thead>";
	echo "<th>PO #</th>";
	echo "<th>MODEL</th>";
	echo "<th>SPEC</th>";
	echo "<th>TOTAL</br>(PAIRS)</th>";
	echo "<th colspan='100'>SIZE/QTY</th>";
echo "</thead>";
//HEADER END

//ISI TABEL
$id_packing_list=ambil_database(id_packing_list,$nama_database,"id='$id'");
$result=mysql_query("SELECT * FROM deliverycls_packing_list_items WHERE induk='$id_packing_list'");
while ($rows=mysql_fetch_array($result)){

//ID SALES PO
//ID SALES PO END
$id_sales_po=ambil_database(id,sales_po,"po_nomor='$rows[po_nomor]' AND line_batch='$rows[line_batch]'");

//NILAI SIZE DAN COUNT
$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
//NILAI SIZE DAN COUNT END

//TOTAL ROWSPAN
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {$pengganti1=1;}else{$pengganti1=0;}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {$pengganti2=1;}else{$pengganti2=0;}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {$pengganti3=1;}else{$pengganti3=0;}
$total_pengganti1=$pengganti1+$pengganti2+$pengganti3;
$total_pengganti=$total_pengganti1*3+1;
//TOTAL ROWSPAN

echo "<tr>";
	echo "<td rowspan='$total_pengganti'>$rows[po_nomor] - $rows[line_batch]</td>";
	echo "<td rowspan='$total_pengganti'>$rows[model]</td>";
	echo "<td rowspan='$total_pengganti'>$rows[material_description_po]</td>";
	echo "<td rowspan='$total_pengganti'>$rows[total_pairs]</td>";
echo "</tr>";

//-------------------------------------------------------------------------------------------------- 1
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
echo "<tr>";
  echo "<td colspan='100'>".ambil_database(logo1,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size1,sales_po,"id='$id_sales_po'")."</td>";
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
echo "<td style='background-color:$color1;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah1[$no]'")."</td>";$no++;}
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$result1=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows[id]' AND logo='logo1' ORDER BY id");
	$rows1=mysql_fetch_array($result1);
	echo "<td>".$rows1[$pecah1[$no]]."</td>";
$no++;}
echo "</tr>";}
//-------------------------------------------------------------------------------------------------- 1

//-------------------------------------------------------------------------------------------------- 2
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
echo "<tr>";
  echo "<td colspan='100'>".ambil_database(logo2,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size2,sales_po,"id='$id_sales_po'")."</td>";
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
echo "<td style='background-color:$color2;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah2[$no]'")."</td>";$no++;}
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$result2=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows[id]' AND logo='logo2' ORDER BY id");
	$rows2=mysql_fetch_array($result2);
	echo "<td>".$rows2[$pecah2[$no]]."</td>";
$no++;}
echo "</tr>";
}
//-------------------------------------------------------------------------------------------------- 2

//-------------------------------------------------------------------------------------------------- 3
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
echo "<tr>";
echo "<td colspan='100'>".ambil_database(logo3,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size3,sales_po,"id='$id_sales_po'")."</td>";
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
echo "<td style='background-color:$color3;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah3[$no]'")."</td>";$no++;}
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$result3=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows[id]' AND logo='logo3' ORDER BY id");
	$rows3=mysql_fetch_array($result3);
	echo "<td>".$rows3[$pecah3[$no]]."</td>";
	$no++;}
echo "</tr>";
}
//-------------------------------------------------------------------------------------------------- 3

$grand_total_pairs=$rows['total_pairs']+$grand_total_pairs;
}//ISI TABEL END

//TOTAL
echo "<tr>";
echo "<td colspan='2'></td>";
echo "<td style='font-size:12px;'>TOTAL</td>";
echo "<td style='font-size:12px;'>$grand_total_pairs</td>";
echo "<td colspan='100'></td>";
echo "</tr>";
//TOTAL END

//LAINNYA
echo "<tr>";
echo "<td colspan='2' style='font-size:12px; text-align:left;'>
KET :	</br>
RANGKAP 1: DISIMPAN (PUTIH)	</br>
RANGKAP 2: FINANCE (MERAH) </br>
RANGKAP 3: PRODUKSI (KUNING) </br>
RANGKAP 4: CLIENT (BIRU) </br>
RANGKAP 5: CUSTOM
</td>";
echo "<td colspan='2' style='font-size:15px;'>No Invoice : </br>".ambil_database(no_invoice,$nama_database,"id='$id'")."</td>";
echo "<td colspan='100' style='font-size:10px; text-align:left; vertical-align:top;'>TANDA TANGAN & CAP PENERIMA</td>";
echo "</tr>";
//LAINNYA END

echo "</table>";
//ISI KOLOM END






}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
