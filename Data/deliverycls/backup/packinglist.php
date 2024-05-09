<?php global $mod;
	$mod='deliverycls/packinglist';
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

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function qty_proses_per_size($no_spk_cutting,$nama_kolom,$logo){
	$ambil_variabel_size1=ambil_variabel_tanpa_kutip_where_distinct(deliverycls_packing_list_items,id,"WHERE no_spk_cutting='$no_spk_cutting' ORDER BY induk");
	$pecah_size1=pecah($ambil_variabel_size1);
	$nilai_pecah_size1=nilai_pecah($ambil_variabel_size1);
	$no_size1=0;for($i_size1=0; $i_size1 < $nilai_pecah_size1; ++$i_size1){
	 $nilai_qty_size1=ambil_database($nama_kolom,deliverycls_packing_qty_proces,"induk='$pecah_size1[$no_size1]' AND logo='$logo'")+$nilai_qty_size1;
	$no_size1++;}
return $nilai_qty_size1;}

function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,no_invoice,tanggal_batas,no_kk,dari,alamat,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,no_invoice,tanggal_batas,no_kk,dari,pembuat,tgl_dibuat';

$nama_database='deliverycls_packing_list';
$nama_database_items='deliverycls_packing_list_items';

$address='?mod=deliverycls/packinglist';

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

//VARIABEL
$tbh=base64_decrypt($_GET['tbh'],"XblImpl1!A@");
$del=base64_decrypt($_GET['del'],"XblImpl1!A@");


//DELETE
if ($del) {
	mysql_query("DELETE FROM $nama_database_items WHERE id='$del'");
	mysql_query("DELETE FROM deliverycls_packing_qty_proces WHERE induk='$del'");
}//DELETE END

//FINISH
if ($_GET['fnh']) {
	mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$id'");
}
//FINISH END


//START ITEM
if ($opsi=='item'){
include 'style.css';
echo kalender();
echo combobox();


//INSERT
$no_spk_cutting=$_POST['no_spk_cutting'];
if($no_spk_cutting != '') {// AND ambil_database(no_spk_cutting,$nama_database_items,"no_spk_cutting='$no_spk_cutting'") == ''
	$komponent=ambil_database(komponent,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");
	$po_nomor=ambil_database(po_nomor,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");
	$line_batch=ambil_database(line_batch,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");
	$style_item_kode=ambil_database(style_item_kode,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");
	$material_description_po=ambil_database(material_description_po,sales_po,"id='".ambil_database(id_po,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'")."'");
	$model=ambil_database(model,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");
	$total_pairs=ambil_database(total_pairs,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");


	mysql_query("INSERT INTO $nama_database_items SET
							induk='$id',
							no_spk_cutting='$no_spk_cutting',
							komponent='$komponent',
							po_nomor='$po_nomor',
							line_batch='$line_batch',
							style_item_kode='$style_item_kode',
							material_description_po='$material_description_po',
							model='$model',
							kemasan='$_POST[kemasan]',
							jumlah_kemasan='$_POST[jumlah_kemasan]',
							berat_kotor='$_POST[berat_kotor]',
							berat_bersih='$_POST[berat_bersih]'");//total_pairs='$total_pairs',
}//INSERT END


	//Kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	//Kembali END
	echo "</td><td>";
	//Print
	echo "<form method ='POST' action='modules/deliverycls/cetak/cetak_packinglist.php' target='_blank'>";
	echo "<input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
				<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='bahasa' value='$bahasa'>
				</form>";
	echo "</td></tr></table>";
	//Print END

	//HEADER PERTAMA
	echo "<table style='width:100%;'>";
	echo "<tr><td><center><img src='modules/gambar/logo_lengkap.png' width='50%'/><center></td></tr>";
	echo "<tr><td><center><h1>PACKING LIST</h1><center></td></tr>";
	echo "<table>";
	//HEADER PERTAMA END

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
	echo "<td>DUE DATE</td>";
	echo "<td>: ".ambil_database(tanggal_batas,$nama_database,"id='$id'")."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>KK NO</td>";
	echo "<td>: ".ambil_database(no_kk,$nama_database,"id='$id'")."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='3'><center>NOTIFY PARTY</center></td>";
	echo "</tr>";
	echo "<table>";
	//HEADER KEDUA END

//ISI TABEL 1
//Tambah
echo "<table><tr><td>";
if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo "<a href='$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt("$id","XblImpl1!A@")."&tbh=".base64_encrypt("tbh","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/tambah.png' width='25px'/></a>";
}
if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo '<a onclick="return confirm(\''."Finish it?".' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt("$id","XblImpl1!A@")."&fnh=1&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/finish.png" height="25px"/></a>';
}
echo "</td></tr>";
echo "</table>";

if ($tbh) {
	echo "<table>";

	echo "<tr>";
	echo "<td>REFERENSI NO SPK</td>";
	echo "<td>:</td>";

	echo "<form method='POST' action='$address'>";

	echo "<td><select class='comboyuk' name='no_spk_cutting'>
				<option value=''></option>";
	$nilai_result6=ambil_variabel_kutip_satu_where(inventory_distribusi,wip_cutting_dies,"WHERE departement='CLS' AND kontak='BARANG JADI' AND status='Selesai' AND pengirim='WIP CUTTING DIES' AND kegiatan='Masuk'");
	$result6=mysql_query("SELECT * FROM planningcls_spkcuttingdies WHERE no_spk_cutting IN ($nilai_result6)");
	while ($rows6=mysql_fetch_array($result6)) {
	echo "<option value='$rows6[no_spk_cutting]'>$rows6[no_spk_cutting] | $rows6[tanggal] | ".ambil_database(po_nomor,sales_po,"id='$rows6[id_po]'")." - ".ambil_database(line_batch,sales_po,"id='$rows6[id_po]'")."</option>";
	}
	echo "</td>";

	echo "<td><select class='comboyuk' name='kemasan'>
				<option value=''>KEMASAN</option>
				<option value='PG'>PG</option>
				<option value='BOX KDS'>BOX KDS</option>
				<option value='BOX RED'>BOX RED</option>";
	echo "</select></td>";

	echo "<td><input type='text' name='jumlah_kemasan' value='' style='width:100px;' placeholder='Jumlah Kemasan'></td>";
	echo "<td><input type='text' name='berat_kotor' value='' style='width:100px;' placeholder='Berat Kotor'></td>";
	echo "<td><input type='text' name='berat_bersih' value='' style='width:100px;' placeholder='Berat Bersih'></td>";

	echo "
	<input type='hidden' name='id' value='$id'>
	<input type='hidden' name='opsi' value='$opsi'>
	<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
	<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
	<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
	<input type='hidden' name='pencarian' value='$pencarian'>
	<td><input type='image' src='modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";
	echo "</form>";

//KEMBALI
	echo "<td>";
	echo "<a href='$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt("$id","XblImpl1!A@")."&tbh=&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	echo "</td>";
//KEMBALI END

	echo "</tr>";
	echo "</table>";

}
//ISI TABEL 1 END


//ISI TABEL 2
$id_sales_po=ambil_database(id,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database_items,"induk='$id'")."' AND line_batch='".ambil_database(line_batch,$nama_database_items,"induk='$id'")."'");
$id_items=ambil_database(id,planningcls_spkcuttingdies,"no_spk_cutting='".ambil_database(no_spk_cutting,$nama_database_items,"induk='$id'")."'");

$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));

//TOTAL COLSPAN
$total_size_colspan=$nilai_pecah1+$nilai_pecah2+$nilai_pecah3+3;
//TOTAL COLSPAN END


echo "<table class='tabel_utama'>";
echo "<thead>";
echo "<th>NO</th>";
echo "<th>SPK CUTTING DIES</th>";
echo "<th>KOMPONENT</th>";
echo "<th>PO</th>";
echo "<th>LINE BATCH</th>";
echo "<th>ORDER CODE</th>";
echo "<th>MATERAL DESCRIPTION</th>";
echo "<th>MODEL</th>";
echo "<th colspan='$total_size_colspan'>SIZE</th>";
echo "<th>QTY</br>(".ambil_database(satuan,sales_po,"id='$id_sales_po'").")</th>";
echo "<th>KEMASAN</th>";
echo "<th colspan='2'>WEIGHT(KG)</th>";
echo "<th>OPSI</th>";
echo "</thead>";

$number=1;
$result8=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows8=mysql_fetch_array($result8)){//START ARRAY

echo "<tr>";
echo "<td rowspan='5'>$number</td>";
echo "<td rowspan='5'>$rows8[no_spk_cutting]</td>";
echo "<td rowspan='5'>$rows8[komponent]</td>";
echo "<td rowspan='5'>$rows8[po_nomor]</td>";
echo "<td rowspan='5'>$rows8[line_batch]</td>";
echo "<td rowspan='5'>$rows8[style_item_kode]</td>";
echo "<td rowspan='5'>$rows8[material_description_po]</td>";
echo "<td rowspan='5'>$rows8[model]</td>";
echo "</tr>";

$id_sales_po=ambil_database(id,sales_po,"po_nomor='$rows8[po_nomor]' AND line_batch='$rows8[line_batch]'");
$id_items=ambil_database(id,planningcls_spkcuttingdies,"no_spk_cutting='$rows8[no_spk_cutting]'");
$no_spk_cutting=$rows8['no_spk_cutting'];
$id_cuttingdies=ambil_database(id,planningcls_spkcuttingdies,"no_spk_cutting='$rows8[no_spk_cutting]'");

//INSERT OTOMATIS
$bucket_stage=ambil_database(bucket_stage,sales_po,"id='$id_sales_po'");
$line_batch=ambil_database(line_batch,sales_po,"id='$id_sales_po'");
$po_nomor=ambil_database(po_nomor,sales_po,"id='$id_sales_po'");
if(ambil_database(size,deliverycls_packing_qty_proces,"induk='$rows8[id]'") == '' AND ambil_database(induk,deliverycls_packing_qty_proces,"induk='$rows8[id]'") == '') {
		$po_nomor_insert=ambil_database(po_nomor,sales_po,"id='$id_sales_po'");
		$line_batch=ambil_database(line_batch,sales_po,"id='$id_sales_po'");
		$bucket_stage=ambil_database(bucket_stage,sales_po,"id='$id_sales_po'");
		$size1=ambil_database(size1,sales_po,"id='$id_sales_po'");
		$size2=ambil_database(size2,sales_po,"id='$id_sales_po'");
		$size3=ambil_database(size3,sales_po,"id='$id_sales_po'");
		mysql_query("INSERT INTO deliverycls_packing_qty_proces SET bucket_stage='$bucket_stage',line_batch='$line_batch',induk='$rows8[id]',logo='logo1',size='$size1',po_nomor='$po_nomor'");
		mysql_query("INSERT INTO deliverycls_packing_qty_proces SET bucket_stage='$bucket_stage',line_batch='$line_batch',induk='$rows8[id]',logo='logo2',size='$size2',po_nomor='$po_nomor'");
		mysql_query("INSERT INTO deliverycls_packing_qty_proces SET bucket_stage='$bucket_stage',line_batch='$line_batch',induk='$rows8[id]',logo='logo3',size='$size3',po_nomor='$po_nomor'");
}//END INSERT OTOMATIS

//UPDATE SIZE
if ($_POST[update]==logo1) {
	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){$nama_kolom=$pecah1[$no]; $isi_kolom=$_POST[$pecah1[$no]];
		$qty_sebelumnya1=ambil_database($pecah1[$no],deliverycls_packing_qty_proces,"id='$_POST[id_update]' AND logo='logo1'");
		if ($_POST["$pecah1[$no]_pembatas"]+$qty_sebelumnya1 < $_POST[$pecah1[$no]]) {
			echo "<h3 style='background-color:yellow;'>Size Out Limit $pecah1[$no]</h3>";
		}else {
			mysql_query("UPDATE deliverycls_packing_qty_proces SET $nama_kolom='$isi_kolom' WHERE id='$_POST[id_update]' AND logo='logo1'");
		}
	$no++;}}
if ($_POST[update]==logo2) {
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){$nama_kolom=$pecah2[$no]; $isi_kolom=$_POST[$pecah2[$no]];
		$qty_sebelumnya2=ambil_database($pecah2[$no],deliverycls_packing_qty_proces,"id='$_POST[id_update]' AND logo='logo2'");
		if ($_POST["$pecah2[$no]_pembatas"]+$qty_sebelumnya2 < $_POST[$pecah2[$no]]) {
			echo "<h3 style='background-color:yellow;'>Size Out Limit $pecah2[$no]</h3>";
		}else {
			mysql_query("UPDATE deliverycls_packing_qty_proces SET $nama_kolom='$isi_kolom' WHERE id='$_POST[id_update]' AND logo='logo2'");
		}
	$no++;}}
if ($_POST[update]==logo3) {
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){$nama_kolom=$pecah3[$no]; $isi_kolom=$_POST[$pecah3[$no]];
		$qty_sebelumnya3=ambil_database($pecah3[$no],deliverycls_packing_qty_proces,"id='$_POST[id_update]' AND logo='logo3'");
		if ($_POST["$pecah3[$no]_pembatas"]+$qty_sebelumnya3 < $_POST[$pecah3[$no]]) {
			echo "<h3 style='background-color:yellow;'>Size Out Limit $pecah3[$no]</h3>";
		}else {
			mysql_query("UPDATE deliverycls_packing_qty_proces SET $nama_kolom='$isi_kolom' WHERE id='$_POST[id_update]' AND logo='logo3'");
		}
	$no++;}}
//UPDATE SIZE END

//NILAI SIZE DAN COUNT
$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
//NILAI SIZE DAN COUNT END

//SALES PO

echo "<tr>";
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
  echo "<td colspan='$nilai_pecah1'>".ambil_database(logo1,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size1,sales_po,"id='$id_sales_po'")."</td>";
  echo "<td rowspan='3'></td>";}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
  echo "<td colspan='$nilai_pecah2'>".ambil_database(logo2,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size2,sales_po,"id='$id_sales_po'")."</td>";
  echo "<td rowspan='3'></td>";}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
  echo "<td colspan='$nilai_pecah3'>".ambil_database(logo3,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size3,sales_po,"id='$id_sales_po'")."</td>";
  echo "<td rowspan='3'></td>";}
//SALES PO END

//TOTAL QTY
$total_sum_spk=total_sum_spk($nilai_pecah1,$pecah1,$nilai_pecah2,$pecah2,$nilai_pecah3,$pecah3,deliverycls_packing_qty_proces,$rows8[id]);
mysql_query("UPDATE $nama_database_items SET total_pairs='$total_sum_spk' WHERE id='$rows8[id]'");
echo "<td rowspan='4'>$total_sum_spk</td>";
//TOTAL QTY END

echo "<td rowspan='2'>$rows8[kemasan]</td>";//KEMASAN
echo "<td rowspan='2'>GW</td>";//BERAT KOTOR
echo "<td rowspan='2'>NW</td>";//BERAT BERSIH

//DELETE
	echo "<td rowspan='4'>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses' ){
	echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt("$id","XblImpl1!A@")."&del=".base64_encrypt($rows8[id],"XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
	}
	echo "</td>";
//DELETE END

echo "</tr>";

//SIZE
echo "<tr>";
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	echo "<td style='background-color:$color1;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah1[$no]'")."</td>";$no++;}
	}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	echo "<td style='background-color:$color2;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah2[$no]'")."</td>";$no++;}
	}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	echo "<td style='background-color:$color3;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah3[$no]'")."</td>";$no++;}
	}
echo "</tr>";
//SIZE END

//LIST SIZE
echo "<tr>";
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
$result1=mysql_query("SELECT * FROM planningcls_spkcuttingdies_items WHERE induk='$id_cuttingdies' AND logo='logo1' ORDER BY id");
$rows1=mysql_fetch_array($result1);
	$sisa_belum_dikerjakan_size1=$rows1[$pecah1[$no]]-qty_proses_per_size($no_spk_cutting,$pecah1[$no],logo1);
	echo "<td style='background-color:$color1; width:18px;'>$sisa_belum_dikerjakan_size1</td>";
$no++;
}}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
$result2=mysql_query("SELECT * FROM planningcls_spkcuttingdies_items WHERE induk='$id_cuttingdies' AND logo='logo2' ORDER BY id");
$rows2=mysql_fetch_array($result2);
	$sisa_belum_dikerjakan_size2=$rows2[$pecah2[$no]]-qty_proses_per_size($no_spk_cutting,$pecah2[$no],logo2);
	echo "<td style='background-color:$color2; width:18px;'>$sisa_belum_dikerjakan_size2</td>";
$no++;
}}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
$result3=mysql_query("SELECT * FROM planningcls_spkcuttingdies_items WHERE induk='$id_cuttingdies' AND logo='logo3' ORDER BY id");
$rows3=mysql_fetch_array($result3);
	$sisa_belum_dikerjakan_size3=$rows3[$pecah3[$no]]-qty_proses_per_size($no_spk_cutting,$pecah3[$no],logo3);
	echo "<td style='background-color:$color3; width:18px;'>$sisa_belum_dikerjakan_size3</td>";
$no++;
}}
//LIST SIZE END

echo "<td rowspan='2'>$rows8[jumlah_kemasan]</td>";//KEMASAN
echo "<td rowspan='2'>$rows8[berat_kotor]</td>";//BERAT KOTOR
echo "<td rowspan='2'>$rows8[berat_bersih]</td>";//BERAT BERSIH

echo "</tr>";

//QTY PAIRS
echo "<tr>";

if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$result1=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows8[id]' AND logo='logo1' ORDER BY id");
	$rows1=mysql_fetch_array($result1);
	$sisa_belum_dikerjakan_size1=ambil_database($pecah1[$no],planningcls_spkcuttingdies_items,"induk='$id_cuttingdies' AND logo='logo1'")-qty_proses_per_size($no_spk_cutting,$pecah1[$no],logo1);//
	echo "<input type='hidden' name='$pecah1[$no]_pembatas' value='$sisa_belum_dikerjakan_size1'>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
	echo "<td style='background-color:$color1; width:15px;'><input type='text' name='".$pecah1[$no]."' value='".$rows1[$pecah1[$no]]."' style='width:30px;' autocomplete='off'></td>";
	}else {
	echo "<td>".$rows1[$pecah1[$no]]."</td>";
	}
$no++;
}//BARIS 4
if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
echo "	<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='opsi' value='$opsi'>
				<input type='hidden' name='id_update' value='$rows1[id]'>
				<input type='hidden' name='update' value='logo1'>";
echo "<td style='background-color:$color1;'><input type='image' src='modules/gambar/save.png' width='20' height'20' name='simpan' value='Simpan'></td>";
echo "</form>";}else{echo "<td></td>";}
}

if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$result2=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows8[id]' AND logo='logo2' ORDER BY id");
	$rows2=mysql_fetch_array($result2);
	$sisa_belum_dikerjakan_size2=ambil_database($pecah2[$no],planningcls_spkcuttingdies_items,"induk='$id_cuttingdies' AND logo='logo2'")-qty_proses_per_size($no_spk_cutting,$pecah2[$no],logo2);//
	echo "<input type='hidden' name='$pecah2[$no]_pembatas' value='$sisa_belum_dikerjakan_size2'>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
	echo "<td style='background-color:$color2; width:15px;'><input type='text' name='".$pecah2[$no]."' value='".$rows2[$pecah2[$no]]."' style='width:30px;' autocomplete='off'></td>";
	}else {
	echo "<td>".$rows2[$pecah2[$no]]."</td>";
	}
$no++;}
if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
echo "	<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='opsi' value='$opsi'>
				<input type='hidden' name='id_update' value='$rows2[id]'>
				<input type='hidden' name='update' value='logo2'>";
echo "<td style='background-color:$color2;'><input type='image' src='modules/gambar/save.png' width='20' height'20' name='simpan' value='Simpan'></td>";
echo "</form>";}else{echo "<td></td>";}
}

if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$result3=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows8[id]' AND logo='logo3' ORDER BY id");
	$rows3=mysql_fetch_array($result3);
	$sisa_belum_dikerjakan_size3=ambil_database($pecah3[$no],planningcls_spkcuttingdies_items,"induk='$id_cuttingdies' AND logo='logo3'")-qty_proses_per_size($no_spk_cutting,$pecah3[$no],logo3);//
	echo "<input type='hidden' name='$pecah3[$no]_pembatas' value='$sisa_belum_dikerjakan_size3'>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
	echo "<td style='background-color:$color3; width:15px;'><input type='text' name='".$pecah3[$no]."' value='".$rows3[$pecah3[$no]]."' style='width:30px;' autocomplete='off'></td>";
	}else {
	echo "<td>".$rows3[$pecah3[$no]]."</td>";
	}
	$no++;}
if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
echo "<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='opsi' value='$opsi'>
			<input type='hidden' name='id_update' value='$rows3[id]'>
			<input type='hidden' name='update' value='logo3'>";
echo "<td style='background-color:$color3;'><input type='image' src='modules/gambar/save.png' width='20' height'20' name='simpan' value='Simpan'></td>";
echo "</form>";}else{echo "<td></td>";}
}

echo "</tr>";
//QTY PAIRS END


$grand_total_pairs=$total_sum_spk+$grand_total_pairs;
$grand_total_jumlah_kemasan=$rows8[jumlah_kemasan]+$grand_total_jumlah_kemasan;
$grand_total_berat_kotor=$rows8[berat_kotor]+$grand_total_berat_kotor;
$grand_total_berat_bersih=$rows8[berat_bersih]+$grand_total_berat_bersih;

$number++;}//END ARRAY
$total=$total_size_colspan+8;
echo "<tr style='height:40px;'>
			<td colspan='$total'>TOTAL</td>
			<td colspan=''>$grand_total_pairs</td>
			<td colspan=''>$grand_total_jumlah_kemasan</td>
			<td colspan=''>$grand_total_berat_kotor</td>
			<td colspan=''>$grand_total_berat_bersih</td>
			<td colspan=''></td>
			</tr>";

echo "</table>";
//ISI TABEL 2 END


}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
