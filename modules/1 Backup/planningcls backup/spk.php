<?php global $mod;
	$mod='planningcls/spk';
function editmenu(){extract($GLOBALS);}

function total_sum_spk($nilai_pecah1,$pecah1,$nilai_pecah2,$pecah2,$nilai_pecah3,$pecah3,$nama_database_items,$id){
	//TOTAL NILAI SUM SPK
	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$nilai_spk1=ambil_database($pecah1[$no],$nama_database_items,"induk='$id' AND logo='logo1'");
	$total_nilai_spk1=$nilai_spk1+$total_nilai_spk1;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$nilai_spk2=ambil_database($pecah2[$no],$nama_database_items,"induk='$id' AND logo='logo2'");
	$total_nilai_spk2=$nilai_spk2+$total_nilai_spk2;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$nilai_spk3=ambil_database($pecah3[$no],$nama_database_items,"induk='$id' AND logo='logo3'");
	$total_nilai_spk3=$nilai_spk3+$total_nilai_spk3;
	$no++;}
	$total_seluruh_spk1=$total_nilai_spk1+$total_nilai_spk2+$total_nilai_spk3;
return $total_seluruh_spk1;}

function ambil_nilai_logo_spk($induk,$nama_database,$id,$nama_database_items){
	$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
	$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
	$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
	$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
	$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));
	$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));

	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$nilai_spk1_kedua=ambil_database($pecah1[$no],$nama_database_items,"induk='$induk' AND logo='logo1'");
	$total_nilai_spk1_kedua=$nilai_spk1_kedua+$total_nilai_spk1_kedua;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$nilai_spk2_kedua=ambil_database($pecah2[$no],$nama_database_items,"induk='$induk' AND logo='logo2'");
	$total_nilai_spk2_kedua=$nilai_spk2_kedua+$total_nilai_spk2_kedua;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$nilai_spk3_kedua=ambil_database($pecah3[$no],$nama_database_items,"induk='$induk' AND logo='logo3'");
	$total_nilai_spk3_kedua=$nilai_spk3_kedua+$total_nilai_spk3_kedua;
	$no++;}
	$total_seluruh_spk1_kedua=$total_nilai_spk1_kedua+$total_nilai_spk2_kedua+$total_nilai_spk3_kedua;
	return $total_seluruh_spk1_kedua;}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function home(){extract($GLOBALS);
include ('style.css');
include ('function.php');
$column_header='tanggal,no_spk_cutting,dari,line_batch,po_nomor,yield,model,komponent,style_item_kode,textile,foam,logo1,size1,logo2,size2,logo3,size3,qty_spk,bucket_stage,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='tanggal,no_spk_cutting,id_po,pembuat,tgl_dibuat';
$nama_database='planningcls_spkcuttingdies';
$nama_database_items='planningcls_spkcuttingdies_items';
$address='?mod=planningcls/spk';
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

//ID ITEMS
$id_items=$_POST['id_items'];

if ($opsi=='item') {
	//kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	echo "</td><td>";
	echo "<form method ='POST' action='modules/planningcls/cetak/cetak_spk.php' target='_blank'>";
	echo "<input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
				<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='bahasa' value='$bahasa'>
				</form>";
	echo "</td></tr></table>";


//START ITEM
//HEADER
echo "<h2 align='center'>".ambil_database($bahasa,master_bahasa,"kode='spk'")."</h2>";
echo "<h3>".ambil_database(tanggal,$nama_database,"id='$id'")."</h3>";
echo "<table style='width:100%;'>";

echo "<tr>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='nama_klien'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='model'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='yield'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='komponent'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='spesifikasi_bahan_kain'")." :</td>";
echo "</tr>";
echo "<tr>";
echo "<td>".ambil_database(dari,$nama_database,"id='$id'")."</td>";
echo "<td>".ambil_database(model,$nama_database,"id='$id'")."</td>";

//JIKA SUDAH VALID BOX TIDAK BISA DIRUBAH
if (ambil_database(validasi,$nama_database,"id='$id'") == '') {
	$disabled='';
}else {$disabled='readonly';}

//Pilihan Yield START
//MULAI UPDATE YIELD
if ($_POST[update]) {
	if ($_POST[update]==update_yield) {
		mysql_query("UPDATE $nama_database SET id_yield='$_POST[id_yield]',yield='".ambil_database(yield,sales_mastermodel,"id='$_POST[id_yield]'")."' WHERE id='$_POST[id]'");}
}//SELESAI UPDATE YIELD

// echo "<form method ='post' action='$address'>";
// $sql113="SELECT id,yield FROM sales_mastermodel WHERE validasi='Valid' ORDER BY yield";
// $result113=mysql_query($sql113);
echo "<td>".ambil_database(yield,$nama_database,"id='$id'")."</td>";
//echo "<td>";
//<select class='comboyuk' name='id_yield'  style='width:80%'>
//echo "<option value='".ambil_database(id_yield,$nama_database,"id='$id'")."'>".ambil_database(yield,$nama_database,"id='$id'")."</option>";
//while ($rows113=mysql_fetch_array($result113)) {
//echo "<option value='$rows113[id]'>$rows113[yield]</option>";}
//echo "
//</select>";
//echo "<input type='hidden' name='id' value='$id'>
			// <input type='hidden' name='halaman' value='$nomor_halaman'>
			// <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			// <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			// <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			// <input type='hidden' name='pencarian' value='$pencarian'>
			// <input type='hidden' name='opsi' value='$opsi'>
			// <input type='hidden' name='update' value='update_yield'>";
//if ($disabled=='') {echo "<input type='image' src='modules/gambar/save.png' width='25' height='25' align='center' name='simpan' value='Simpan'>";}
//echo "</td>";
//echo "</form>";
//Pilihan Yield END

echo "<td>".ambil_database(komponent,$nama_database,"id='$id'")."</td>";
echo "<td>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(textile,$nama_database,"id='$id'")."' AND kategori='KAIN'")."</td>";
echo "</tr>";

echo "<tr>";
echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='bahan_spesifikasi_foam'")." :</td>";
echo "</tr>";echo "<tr>";
echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(foam,$nama_database,"id='$id'")."' AND kategori='FOAM'")."</td>";
echo "</tr>";echo "<table>";

echo "<table align='center'>
			<tr><td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='artikel'")." :</td></tr>
			<tr><td>".ambil_database(style_item_kode,$nama_database,"id='$id'")."</td></tr>
			</table>";
//HEADER END

//Mulai TABEL
echo "<table style='width:auto;' class='tabel_utama'>";

//NILAI SIZE DAN COUNT
$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));

//MULAI UPDATE BOX
if ($_POST[update]) {
	if ($_POST[update]==bucket) {
		mysql_query("UPDATE $nama_database_items SET box='$_POST[box]' WHERE induk='$id'");
	}
}//SELESAI UPDATE BOX

//INSERT OTOMATIS
if (ambil_database(size,$nama_database_items,"induk='$id'") == '') {
	$po_nomor_insert=ambil_database(po_nomor,$nama_database,"id='$id'");
	$size1=ambil_database(size1,$nama_database,"id='$id'");
	$size2=ambil_database(size2,$nama_database,"id='$id'");
	$size3=ambil_database(size3,$nama_database,"id='$id'");

	$id_laminating=ambil_database(id_laminating,$nama_database,"id='$id'");
	$bucket_stage=ambil_database(bucket_stage,$nama_database,"id='$id'");
	$line_batch=ambil_database(line_batch,$nama_database,"id='$id'");
	$satuan_model=ambil_database(satuan,sales_po,"id='".ambil_database(id_po,$nama_database,"id='$id'")."'");

	if (ambil_database(line_batch,$nama_database_items,"line_batch='$line_batch' AND po_nomor='$po_nomor_insert' AND id_laminating='$id_laminating'") == '') {
	mysql_query("INSERT INTO $nama_database_items SET id_laminating='$id_laminating',satuan='$satuan_model',line_batch='$line_batch',bucket_stage='$bucket_stage',induk='$id',logo='logo1',size='$size1',po_nomor='$po_nomor_insert'");
	mysql_query("INSERT INTO $nama_database_items SET id_laminating='$id_laminating',satuan='$satuan_model',line_batch='$line_batch',bucket_stage='$bucket_stage',induk='$id',logo='logo2',size='$size2',po_nomor='$po_nomor_insert'");
	mysql_query("INSERT INTO $nama_database_items SET id_laminating='$id_laminating',satuan='$satuan_model',line_batch='$line_batch',bucket_stage='$bucket_stage',induk='$id',logo='logo3',size='$size3',po_nomor='$po_nomor_insert'");
	}

	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){$nama_kolom=$pecah1[$no]; $isi_kolom=ambil_database($pecah1[$no],planningcls_spklaminating_qty_proces,"logo='logo1' AND induk='".ambil_database(id_laminating,$nama_database,"id='$id'")."'");
	mysql_query("UPDATE $nama_database_items SET $nama_kolom='$isi_kolom' WHERE induk='$id' AND logo='logo1'");
	$no++;}

	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){$nama_kolom=$pecah2[$no]; $isi_kolom=ambil_database($pecah2[$no],planningcls_spklaminating_qty_proces,"logo='logo2' AND induk='".ambil_database(id_laminating,$nama_database,"id='$id'")."'");
	mysql_query("UPDATE $nama_database_items SET $nama_kolom='$isi_kolom' WHERE induk='$id' AND logo='logo2'");
	$no++;}

	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){$nama_kolom=$pecah3[$no]; $isi_kolom=ambil_database($pecah3[$no],planningcls_spklaminating_qty_proces,"logo='logo3' AND induk='".ambil_database(id_laminating,$nama_database,"id='$id'")."'");
	mysql_query("UPDATE $nama_database_items SET $nama_kolom='$isi_kolom' WHERE induk='$id' AND logo='logo3'");
	$no++;}
}//END INSERT OTOMATIS

//COLOR 1 2 3
$color1='#00FFFF';
$color2='';
$color3='#00FFFF';

echo "<thead>";//BARIS 1
echo "<th colspan='5'>".ambil_database($bahasa,pusat_bahasa,"kode='spesifikasi_kertas_embos'")."</th>";
if (ambil_database(size1,$nama_database,"id='$id'")!='') {
echo "<th colspan='$nilai_pecah1'>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(logo1,$nama_database,"id='$id'")."' AND kategori='LOGO'")."  (".ambil_database(size1,$nama_database,"id='$id'").")</th>";}
if (ambil_database(size2,$nama_database,"id='$id'")!='') {
echo "<th colspan='$nilai_pecah2'>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(logo2,$nama_database,"id='$id'")."' AND kategori='LOGO'")."  (".ambil_database(size2,$nama_database,"id='$id'").")</th>";}
if (ambil_database(size3,$nama_database,"id='$id'")!='') {
echo "<th colspan='$nilai_pecah3'>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(logo3,$nama_database,"id='$id'")."' AND kategori='LOGO'")."  (".ambil_database(size3,$nama_database,"id='$id'").")</th>";}
echo "</thead>";//BARIS 1 END

echo "<tr>";//BARIS 2
echo "<td colspan='5'>".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")."</td>";
if (ambil_database(size1,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
echo "<td style='background-color:$color1;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah1[$no]'")."</td>";$no++;}}
if (ambil_database(size2,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
echo "<td style='background-color:$color2;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah2[$no]'")."</td>";$no++;}}
if (ambil_database(size3,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
echo "<td style='background-color:$color3;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah3[$no]'")."</td>";$no++;}}
echo "</tr>";//BARIS 2 END

//TOTAL NILAI SUM
$po_nomor=ambil_database(po_nomor,$nama_database,"id='$id'");
$result6=mysql_query("SELECT * FROM $nama_database WHERE po_nomor='$po_nomor' ORDER BY line_batch");
$total_result6=mysql_num_rows($result6);

$rowspan_baris_3_4=1+$total_result6;
echo "<tr>";//BARIS 3 DAN 4
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database($bahasa,pusat_bahasa,"kode='po_nomor'")."</td>";
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database($bahasa,pusat_bahasa,"kode='line'")."</td>";
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database($bahasa,pusat_bahasa,"kode='bucket'")."</td>";
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database(satuan,planningcls_spkcuttingdies_items,"induk='$id'")."</td>";

while ($rows6=mysql_fetch_array($result6)) {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
$nilai=ambil_database($pecah1[$no],$nama_database_items,"induk='$rows6[id]' AND logo='logo1'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah1[$no]."'");
$nilai1=substr($nilai, 0,4); $total_nilai1=$nilai1+$total_nilai1;
$no++;}
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
$nilai=ambil_database($pecah2[$no],$nama_database_items,"induk='$rows6[id]' AND logo='logo2'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah2[$no]."'");
$nilai2=substr($nilai, 0,4); $total_nilai2=$nilai2+$total_nilai2;
$no++;}
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
$nilai=ambil_database($pecah3[$no],$nama_database_items,"induk='$rows6[id]' AND logo='logo3'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah3[$no]."'");
$nilai3=substr($nilai, 0,4); $total_nilai3=$nilai3+$total_nilai3;
$no++;}
$total_seluruh=$total_nilai1+$total_nilai2+$total_nilai3;
}
echo "<td rowspan='$rowspan_baris_3_4'>".ceil($total_seluruh)."</td>";
//TOTAL NILAI SUM END

//BARIS 3
if (ambil_database(size1,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
echo "<td style='background-color:$color1; width:100px;'>".ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah1[$no]."'")." PRS</td>"; $no++;}}
if (ambil_database(size2,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
echo "<td style='background-color:$color2; width:100px;'>".ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah2[$no]."'")." PRS</td>"; $no++;}}
if (ambil_database(size3,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
echo "<td style='background-color:$color3; width:100px;'>".ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah3[$no]."'")." PRS</td>"; $no++;}}
//BARIS 3 END

echo "</tr>";//BARIS 3 DAN 4

echo "<tr>";//BARIS 4

$result7=mysql_query("SELECT * FROM $nama_database WHERE po_nomor='$po_nomor' ORDER BY line_batch");
$total_result7=mysql_num_rows($result7);
while ($rows7=mysql_fetch_array($result7)) {
//BARIS 4
if (ambil_database(size1,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
$nilai=ambil_database($pecah1[$no],$nama_database_items,"induk='$rows7[id]' AND logo='logo1'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah1[$no]."'");
$nilai1=substr($nilai, 0,4);
echo "<td style='background-color:$color1;'>$nilai1</td>"; $no++;}}

if (ambil_database(size2,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
$nilai=ambil_database($pecah2[$no],$nama_database_items,"induk='$rows7[id]' AND logo='logo2'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah2[$no]."'");
$nilai2=substr($nilai, 0,4);
echo "<td style='background-color:$color2;'>$nilai2</td>"; $no++;}}

if (ambil_database(size3,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
$nilai=ambil_database($pecah3[$no],$nama_database_items,"induk='$rows7[id]' AND logo='logo3'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah3[$no]."'");
$nilai3=substr($nilai, 0,4);
echo "<td style='background-color:$color3;'>$nilai3</td>"; $no++;}}
//BARIS 4 END
echo "</tr>";//BARIS 4 END
}

//Baris 5
echo "<tr>";
$lebar_seluruh_kolom=5+$nilai_pecah1+$nilai_pecah2+$nilai_pecah3;
echo "<td colspan='$lebar_seluruh_kolom' style='height:50px;'></td>";
echo "</tr>";
//Baris 5 END


//KOLOM INPUT
echo kalender();
echo combobox();

$result5=mysql_query("SELECT * FROM $nama_database WHERE po_nomor='$po_nomor' AND id='$id' ORDER BY line_batch");
$total_result5=mysql_num_rows($result5);
while ($rows5=mysql_fetch_array($result5)) {
echo "<tr>";//BARIS 6
echo "<form method ='post' action='$address'>";
echo "<td>".ambil_database(po_nomor,$nama_database,"id='$rows5[id]'")."</td>";
echo "<td>".ambil_database(line_batch,$nama_database_items,"induk='$rows5[id]'")."</td>";
echo "<td>".ambil_database(bucket_stage,$nama_database_items,"induk='$rows5[id]'")."</td>";
echo "<td>".ambil_database($bahasa,pusat_bahasa,"kode='total'")."</td>";

$total_sum_spk=total_sum_spk($nilai_pecah1,$pecah1,$nilai_pecah2,$pecah2,$nilai_pecah3,$pecah3,$nama_database_items,$rows5[id]);
echo "<td>";
echo "$total_sum_spk";
echo "</td>";
mysql_query("UPDATE $nama_database SET total_pairs='$total_sum_spk' WHERE id='$rows5[id]'");//UPDATE TOTAL PAIRS
//TOTAL NILAI SUM SPK END

if (ambil_database(size1,$nama_database,"id='$rows5[id]'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$result1=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$rows5[id]' AND logo='logo1' ORDER BY id");
	$rows1=mysql_fetch_array($result1);
	echo "<td style='background-color:$color1; width:18px;'>".$rows1[$pecah1[$no]]."</td>"; $no++;}}


//SAVE KETIGA
if (ambil_database(size2,$nama_database,"id='$rows5[id]'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$result2=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$rows5[id]' AND logo='logo2' ORDER BY id");
	$rows2=mysql_fetch_array($result2);
	echo "<td style='background-color:$color2; width:28px;'>".$rows2[$pecah2[$no]]."</td>"; $no++;}}
//SAVE KETIGA END

//SAVE KEEMPAT
if (ambil_database(size3,$nama_database,"id='$rows5[id]'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$result3=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$rows5[id]' AND logo='logo3' ORDER BY id");
	$rows3=mysql_fetch_array($result3);
	echo "<td style='background-color:$color3; width:38px;'>".$rows3[$pecah3[$no]]."</td>"; $no++;}}
//SAVE KEEMPAT END
echo "</tr>";
}//BARIS 6 END

//Baris 7
echo "<tr>";
$lebar_seluruh_kolom=5+$nilai_pecah1+$nilai_pecah2+$nilai_pecah3;
echo "<td colspan='$lebar_seluruh_kolom' style='height:50px;'></td>";
echo "</tr>";
//Baris 7 END

//PISAH TABLE
echo "</table>";
echo "<table class='tabel_utama' border='0' cellpadding='2' cellspacing='0' style='width:50%; float:left;'><tbody>";

//BARIS 8
echo "<tr style='height:25px;'>";
echo "<form method ='post' action='$address'>";
echo "<td colspan='4'>".ambil_database($bahasa,pusat_bahasa,"kode='mohon_dipacking_menjadi'")."</td>";
echo "<td><input type='text' name='box' value='".ambil_database(box,$nama_database_items,"induk='$id'")."' style='width:16px; font-size:10px;' $disabled></td>";
echo "<td>".ambil_database($bahasa,pusat_bahasa,"kode='box'")."</td>";

//SAVE PERTAMA
echo "	<input type='hidden' name='id' value='$id'>
<input type='hidden' name='halaman' value='$nomor_halaman'>
<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
<input type='hidden' name='pencarian' value='$pencarian'>
<input type='hidden' name='opsi' value='$opsi'>
<input type='hidden' name='id_items' value='$rows1[id]'>
<input type='hidden' name='update' value='bucket'>";
echo "<td colspan='2'><input type='image' src='modules/gambar/save.png' width='20' height'20' name='simpan' value='Simpan'></td>";
echo "</form>";

echo "<td colspan='10' rowspan='2'></td>";
echo "</tr>";
//BARIS 8 END


//NILAI PO
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){$no++;}
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){$no++;}
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){$no++;}
//NILAI PO END

//Baris 9
//CARI TOTAL QTY PO
$po_nomor=ambil_database(po_nomor,$nama_database,"id='$id'");
$result1=mysql_query("SELECT * FROM sales_po WHERE po_nomor='$po_nomor'");
while ($rows1=mysql_fetch_array($result1)){$nilai_qty_po=$rows1['qty_po']+$nilai_qty_po;}
//CARI TOTAL QTY PO END

echo "<tr style='height:25px;'>";
echo "<td colspan='4'>".ambil_database($bahasa,pusat_bahasa,"kode='qty_po'")."</td>";
echo "<td colspan='2'>$nilai_qty_po</td>";
echo "<td colspan='2'>".ambil_database(satuan,$nama_database_items,"induk='$id'")."</td>";
echo "</tr>";
//Baris 9 END

//Baris 10
//START ARAY ITEM SPK
$result4=mysql_query("SELECT distinct line_batch,induk FROM $nama_database_items WHERE po_nomor='$po_nomor' ORDER BY line_batch");
$count4=mysql_num_rows($result4);//BAGI LOGO 1,2,3
$rowspan4=$count4+1;
echo "<tr>";
echo "<td rowspan='$rowspan4' colspan='4'>".ambil_database($bahasa,pusat_bahasa,"kode='qty_spk'")."</td>";
echo "</tr>";
while ($rows4=mysql_fetch_array($result4)) {
if ($id == $rows4[induk]){$color="style='background-color:yellow; width:200px;'";}else{$color='';}
echo "<tr style='height:25px;'>";
echo "<td $color width='80px' colspan='2'>".ambil_nilai_logo_spk($rows4['induk'],$nama_database,$rows4['induk'],$nama_database_items)."</td>";
echo "<td $color width='80px' colspan='2'>".ambil_database($bahasa,pusat_bahasa,"kode='pairs'")."</td>";

echo "<td $color width='80px' colspan='2'>".ambil_database($bahasa,pusat_bahasa,"kode='line'")."</td>";
echo "<td $color  colspan='2'>$rows4[line_batch]</td>";

echo "<td $color width='80px' colspan='2'>".ambil_database($bahasa,pusat_bahasa,"kode='status'")."</td>";
echo "<td $color width='80px' colspan='2'>".ambil_database(status,$nama_database,"id='$rows4[induk]'")."</td>";

if ($id == $rows4[induk]){echo "<td style='height:20px; width:80px; background-color:yellow;'>".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."</td>";}else{
	echo "<td><center>";
	echo "<a href='$address&id=".base64_encrypt($rows4[induk],"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/item.png' width='20px'/></a>";
	echo "</td>";}

$total_jumlah_spk=ambil_nilai_logo_spk($rows4['induk'],$nama_database,$rows4['induk'],$nama_database_items)+$total_jumlah_spk;
}//END ARAY ITEM SPK
echo "</tr>";
echo "<tr style='height:25px;'>
<td colspan='4'>TOTAL</td>
<td colspan='2'>$total_jumlah_spk</td>
<td></td>
<td colspan='10'></td>
</tr>";
//Baris 10 END
echo "</br></br></tbody></table>";


echo "<table border='1' cellpadding='5' cellspacing='0' style='width:auto; float:right; margin-right:20px;'><tbody>";
echo "<tr>";
	if (ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
		echo "<td><center>";
			echo "Logo 1";
		echo "</center></td>";
	}else{}
	if (ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
		echo "<td><center>";
			echo "Logo 2";
		echo "</center></td>";
	}else {}
	if (ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
		echo "<td><center>";
			echo "Logo 3";
		echo "</center></td>";
	}else{}
echo "</tr>";

echo "<tr>";
	if (ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
			$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='".ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			$id_foto=ambil_database(id,inventory_barang,"kode='".ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			echo "<td>";
				echo '<a href="#" onClick="window.open(\''."modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan&id=$id_foto&nama_database=inventory_barang".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='modules/warehouse/gambarproduk/$nama_gambar_tampilan' width='80px' height='100px'/>".'</a>';
			echo "</td>";
	}else{}
	if (ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
			$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='".ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			$id_foto=ambil_database(id,inventory_barang,"kode='".ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			echo "<td>";
			  echo '<a href="#" onClick="window.open(\''."modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan&id=$id_foto&nama_database=inventory_barang".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='modules/warehouse/gambarproduk/$nama_gambar_tampilan' width='80px' height='100px'/>".'</a>';
			echo "</td>";
	}else {}
	if (ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
			$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='".ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			$id_foto=ambil_database(id,inventory_barang,"kode='".ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			echo "<td>";
			  echo '<a href="#" onClick="window.open(\''."modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan&id=$id_foto&nama_database=inventory_barang".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='modules/warehouse/gambarproduk/$nama_gambar_tampilan' width='80px' height='100px'/>".'</a>';
			echo "</td>";
	}else{}
echo "</tr>";
echo "</tbody></table>";
//END TABEL


//END ITEM
}else{
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
}//END UTAMA

}//END HOME
//END PHP?>
