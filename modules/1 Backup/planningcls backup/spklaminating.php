<?php global $mod;
	$mod='planningcls/spklaminating';
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
include ('style.css');
include ('function.php');
$column_header='tanggal,no_spk,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,no_spk,pembuat,tgl_dibuat';
$nama_database='planningcls_spklaminating';
$nama_database_items='planningcls_spklaminating_items';
$address='?mod=planningcls/spklaminating';
if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}

if (base64_decrypt($_GET['opsi'],"XblImpl1!A@")=='item') {
$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$id_items=base64_decrypt($_GET['id_items'],"XblImpl1!A@");
$nomor_halaman=$_GET['halaman'];
$pilihan_tahun=$_GET['pilihan_tahun'];
$pilihan_bulan=$_GET['pilihan_bulan'];
$pilihan_pencarian=$_GET['pilihan_pencarian'];
$pencarian=$_GET['pencarian'];}
if ($_POST[opsi]=='item') {
$opsi=$_POST['opsi'];
$id=$_POST['id'];
$id_items=$_POST['id_items'];
$nomor_halaman=$_POST['halaman'];
$pilihan_tahun=$_POST['pilihan_tahun'];
$pilihan_bulan=$_POST['pilihan_bulan'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];
$pencarian=$_POST['pencarian'];}

$qty_proses=base64_decrypt($_GET['delete'],"XblImpl1!A@");



$id_sales_po=ambil_database(id_sales_po,$nama_database_items,"id='$id_items'");

//INSERT OTOMATIS
if (ambil_database(size,planningcls_spklaminating_qty_proces,"induk='$id_items'") == '' AND ambil_database(induk,planningcls_spklaminating_qty_proces,"induk='$id_items'") == '' AND $id_items != '') {
	$po_nomor_insert=ambil_database(po_nomor,sales_po,"id='$id_sales_po'");
	$line_batch=ambil_database(line_batch,sales_po,"id='$id_sales_po'");
	$bucket_stage=ambil_database(bucket_stage,sales_po,"id='$id_sales_po'");
	$size1=ambil_database(size1,sales_po,"id='$id_sales_po'");
	$size2=ambil_database(size2,sales_po,"id='$id_sales_po'");
	$size3=ambil_database(size3,sales_po,"id='$id_sales_po'");
	mysql_query("INSERT INTO planningcls_spklaminating_qty_proces SET bucket_stage='$bucket_stage',line_batch='$line_batch',induk='$id_items',logo='logo1',size='$size1',po_nomor='$po_nomor_insert'");
	mysql_query("INSERT INTO planningcls_spklaminating_qty_proces SET bucket_stage='$bucket_stage',line_batch='$line_batch',induk='$id_items',logo='logo2',size='$size2',po_nomor='$po_nomor_insert'");
	mysql_query("INSERT INTO planningcls_spklaminating_qty_proces SET bucket_stage='$bucket_stage',line_batch='$line_batch',induk='$id_items',logo='logo3',size='$size3',po_nomor='$po_nomor_insert'");
}
//END INSERT OTOMATIS

//NILAI SIZE DAN COUNT
$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));

//NILAI QTY DATABASE
//PENENTU UPDATE NILAI QTY ATAU TIDAK
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){$nama_kolom=$pecah1[$no]; $nilai_size1_2=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo1'")+$nilai_size1_2; $no++;}
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){$nama_kolom=$pecah2[$no]; $nilai_size2_2=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo2'")+$nilai_size2_2; $no++;}
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){$nama_kolom=$pecah3[$no]; $nilai_size3_2=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo3'")+$nilai_size3_2; $no++;}
//NILAI QTY INPUT
if ($_POST[update]==logo1) {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){$nama_kolom=$pecah1[$no]; $isi_kolom1=$_POST[$pecah1[$no]]+$isi_kolom1;$no++;}
$input1=$isi_kolom1+$nilai_size2_2+$nilai_size3_2;}
if ($_POST[update]==logo2) {
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){$nama_kolom=$pecah2[$no]; $isi_kolom2=$_POST[$pecah2[$no]]+$isi_kolom2;$no++;}
$input2=$isi_kolom2+$nilai_size1_2+$nilai_size3_2;}
if ($_POST[update]==logo3) {
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){$nama_kolom=$pecah3[$no]; $isi_kolom3=$_POST[$pecah3[$no]]+$isi_kolom3;$no++;}
$input3=$isi_kolom3+$nilai_size1_2+$nilai_size2_2;}
$total_kolam_input=$input1+$input2+$input3;
//PENENTU UPDATE NILAI QTY ATAU TIDAK end

//MULAI UPDATE
if ($total_kolam_input <= ambil_database(qty_po,sales_po,"id='$id_sales_po'")) {
	if ($_POST[update]==logo1) {
		$no=0;for($i=0; $i < $nilai_pecah1; ++$i){$nama_kolom=$pecah1[$no]; $isi_kolom=$_POST[$pecah1[$no]];
			$qty_sebelumnya1=ambil_database($pecah1[$no],planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo1'");
			if ($_POST["$pecah1[$no]_pembatas"]+$qty_sebelumnya1 < $_POST[$pecah1[$no]]) {
				echo "<h3 style='background-color:yellow;'>Size Out Limit $pecah1[$no]</h3>";
			}else {
				mysql_query("UPDATE planningcls_spklaminating_qty_proces SET $nama_kolom='$isi_kolom' WHERE induk='$id_items' AND logo='logo1'");
			}
		$no++;}}
	if ($_POST[update]==logo2) {
		$no=0;for($i=0; $i < $nilai_pecah2; ++$i){$nama_kolom=$pecah2[$no]; $isi_kolom=$_POST[$pecah2[$no]];
			$qty_sebelumnya2=ambil_database($pecah2[$no],planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo2'");
			if ($_POST["$pecah2[$no]_pembatas"]+$qty_sebelumnya2 < $_POST[$pecah2[$no]]) {
				echo "<h3 style='background-color:yellow;'>Size Out Limit $pecah2[$no]</h3>";
			}else {
				mysql_query("UPDATE planningcls_spklaminating_qty_proces SET $nama_kolom='$isi_kolom' WHERE induk='$id_items' AND logo='logo2'");
			}
		$no++;}}
	if ($_POST[update]==logo3) {
		$no=0;for($i=0; $i < $nilai_pecah3; ++$i){$nama_kolom=$pecah3[$no]; $isi_kolom=$_POST[$pecah3[$no]];
			$qty_sebelumnya3=ambil_database($pecah3[$no],planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo3'");
			if ($_POST["$pecah3[$no]_pembatas"]+$qty_sebelumnya3 < $_POST[$pecah3[$no]]) {
				echo "<h3 style='background-color:yellow;'>Size Out Limit $pecah3[$no]</h3>";
			}else {
				mysql_query("UPDATE planningcls_spklaminating_qty_proces SET $nama_kolom='$isi_kolom' WHERE induk='$id_items' AND logo='logo3'");
			}
		$no++;}}

		//UPDATE NILAI SHEET DAN YARD
		$id_yield=ambil_database(id_yield,planningcls_spklaminating_items,"id='$id_items'");
		$textile=ambil_database(textile,sales_po,"id='$id_sales_po'");
		$foam=ambil_database(foam,sales_po,"id='$id_sales_po'");
		//NILAI SIZE DAN COUNT

		//TOTAL NILAI SUM
		$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
		$nilai=ambil_database($pecah1[$no],planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo1'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='$id_yield' AND size='".$pecah1[$no]."'");
		$nilai1=substr($nilai, 0,4); $total_nilai1=$nilai1+$total_nilai1;
		$no++;}
		$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
		$nilai=ambil_database($pecah2[$no],planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo2'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='$id_yield' AND size='".$pecah2[$no]."'");
		$nilai2=substr($nilai, 0,4); $total_nilai2=$nilai2+$total_nilai2;
		$no++;}
		$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
		$nilai=ambil_database($pecah3[$no],planningcls_spklaminating_qty_proces,"induk='$id_items' AND logo='logo3'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='$id_yield' AND size='".$pecah3[$no]."'");
		$nilai3=substr($nilai, 0,4); $total_nilai3=$nilai3+$total_nilai3;
		$no++;}
		$total_seluruh=$total_nilai1+$total_nilai2+$total_nilai3;
		$yard_nilai=ceil($total_seluruh);
		$sheet_nilai=ceil($yard_nilai/2.8);
		if ($textile){$yard=$yard_nilai;}else{$yard=0;}// KAIN
		if ($foam){//FOAM
			$satuan_foam=ambil_database(satuan,inventory_lokasi_items,"kode='$foam' AND lokasi='26' AND departement='CLS'");
			if ($satuan_foam=='SHEET'){$sheet=$sheet_nilai;}else{$sheet='';}
		}//FOAM
		mysql_query("UPDATE planningcls_spklaminating_items SET yard='$yard',sheet='$sheet' WHERE id='$id_items'");
		//END UPDATE NILAI SHEET DAN YARD END
	}else {
		echo "<table>";
		echo "<tr><td style='background-color:yellow; font-size:13px;'>".ambil_database($bahasa,pusat_bahasa,"kode='warning_po'")."</td></tr>";
		echo "<table>";
	}//SELESAI UPDATE
//}



if ($opsi=='item') {
	echo kalender();
	echo combobox();
//TAMPILAN ITEM

//DELETE
if (base64_decrypt($_GET['delete'],"XblImpl1!A@")) {
	$id_delete=base64_decrypt($_GET['delete'],"XblImpl1!A@");
	mysql_query("DELETE FROM $nama_database_items WHERE id='$id_delete'");
	mysql_query("DELETE FROM planningcls_spklaminating_qty_proces WHERE induk='$id_delete'");
}
//DELETE END


//UPDATE SELESAI ARRAY DARI FINISH
$id_item_terpilih=$_POST['id_item_terpilih'];
if ($id_item_terpilih) {
$no=0;for($i=0; $i < count($_POST['id_item_terpilih']); ++$i){
mysql_query("UPDATE $nama_database_items SET status='Selesai' WHERE id='$id_item_terpilih[$no]'");
$no++;}
}//UPDATE SELESAI ARRAY DARI FINISH END


//INSERT OTOMATIS
if ($_POST['insert_po'] != '') {// AND $_POST['id_sales_po'] != ambil_database(id_sales_po,$nama_database_items,"id_sales_po='$_POST[id_sales_po]'")
	$id_sales_po=$_POST['id_sales_po'];
	$id_yield=$_POST['id_yield'];
	$keterangan=$_POST['keterangan'];

	$customer=ambil_database(dari,sales_po,"id='$id_sales_po'");
	$bucket_stage=ambil_database(bucket_stage,sales_po,"id='$id_sales_po'");
	$po_nomor=ambil_database(po_nomor,sales_po,"id='$id_sales_po'");
	$line_batch=ambil_database(line_batch,sales_po,"id='$id_sales_po'");
	$model=ambil_database(model,sales_po,"id='$id_sales_po'");
	$tgl_revisi=ambil_database(tgl_revisi,sales_po,"id='$id_sales_po'");
	$yield=ambil_database(yield,sales_mastermodel,"id='$id_yield'");
	$textile=ambil_database(textile,sales_po,"id='$id_sales_po'");
	$foam=ambil_database(foam,sales_po,"id='$id_sales_po'");

	mysql_query("INSERT INTO $nama_database_items SET
	induk='$id',id_sales_po='$id_sales_po',id_yield='$id_yield',customer='$customer',bucket_stage='$bucket_stage',po_nomor='$po_nomor',
	line_batch='$line_batch',model='$model',textile='$textile',foam='$foam',keterangan='$keterangan',
	yield='$yield',status='Proses',tgl_revisi='$tgl_revisi'");
}//INSERT OTOMATIS END


//KEMBALI
echo "<table><tr><td>";
echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
echo "</td>";
echo "<td>";
//KEMBALI END
//TAMBAH
echo "<form method ='POST' action='$address'>";
if (ambil_database(validasi,$nama_database,"id='$id'") != 'Valid'){
	echo "<input type='image' src='modules/gambar/tambah.png' width='25' height'25' name='print' value='print'>";
}
echo "<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='opsi' value='$opsi'>
			<input type='hidden' name='tambah_po' value='tambah_po'>
			<input type='hidden' name='nomor_halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			</form>";
echo "</td>";
//TAMBAH END
echo "<td>";
echo "<form method ='POST' action='modules/planningcls/cetak/cetak_spklaminating.php' target='_blank'>";
echo "<input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='username' value='$_SESSION[username]'>
			</form>";
echo "</td>";
echo "</tr></table>";


//PILIHAN TAMBAH PO
if ($_POST['tambah_po']) {
echo "<table class='tabel_utama' style='margin-top:20px;'>";
echo "<thead>";
echo "<th>".ambil_database($bahasa,pusat_bahasa,"kode='po_nomor'")."</th>";
echo "<th>:</th>";
//PILIHAN PO
echo "<th>";
echo "<form method='POST' action='$address'>";
echo "<select name='id_sales_po' class='comboyuk' style='width:100%;'>";
$ambil_variabel_id=ambil_variabel_kutip_satu(planningcls_spklaminating_items,id_sales_po);
$result=mysql_query("SELECT * FROM sales_po WHERE status='Proses' AND validasi='Valid' AND status='Proses' ORDER BY po_nomor,line_batch");
		echo "<option value=''></option>";
while ($rows=mysql_fetch_array($result)) {
		echo "<option value='$rows[id]'>$rows[po_nomor] - $rows[line_batch] -  $rows[dari]</option>";
}
echo "</select>";
echo "</th>";
echo "</thead>";

echo "<thead>";
echo "<th>".ambil_database($bahasa,pusat_bahasa,"kode='yield'")."</th>";
echo "<th>:</th>";
echo "<th><select name='id_yield' class='comboyuk'>";
$result1=mysql_query("SELECT id,yield FROM sales_mastermodel WHERE validasi='Valid' ORDER BY yield");
echo "<option value=''></option>";
while ($rows1=mysql_fetch_array($result1)) {
	echo "<option value='$rows1[id]'>$rows1[yield]</option>";
}
echo "</th></select>";
echo "</thead>";

echo "<thead>";
echo "<th>".ambil_database($bahasa,pusat_bahasa,"kode='keterangan'")."</th>";
echo "<th>:</th>";
echo "<th><input type='text' name='keterangan' value='' style='width:98%;'>";
echo "</th></select>";
echo "<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='opsi' value='$opsi'>
			<input type='hidden' name='insert_po' value='insert_po'>
			<input type='hidden' name='nomor_halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>";
echo "<th><input type='image' src='modules/gambar/save.png' width='30' height'30' name='simpan' value='Simpan'></th>";
echo "<th>"; // KEMBALI KE ITEM
echo "<a href='$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt($id,"XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
echo "</th>"; // KEMBALI KE ITEM END
//PILIHAN PO END
echo "</form>";
}
//PILIHAN TAMBAH PO END
echo "</thead>";
echo "</table>";

//JUDUL
echo "<h1><center>CLS - 貼合</center></h1>";
echo "<h1><center>CLS - SPK LAMINATING</center></h1>";
//JUDUL END

//HEADER 1
echo "<table style='font-size:17px;'>";
echo "<tr>";
echo "<td>號碼/NOMOR</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(no_spk,planningcls_spklaminating,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>日期/TANGGAL</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(tanggal,planningcls_spklaminating,"id='$id'")."</td>";
echo "</tr>";
echo "</table>";
//HEADER 1 END

//HEADER 2
echo "<table class='tabel_utama' style='width:auto;'>";

echo "<tr style='background-color:#cccccc; font-weight:bold;'>";
echo "<td rowspan='2'></td>";
echo "<td>顧客</td>";
echo "<td rowspan='2'>BUCKET</td>";
echo "<td>訂單號</td>";
echo "<td>線批</td>";
echo "<td>型體</td>";
echo "<td>布</td>";
echo "<td>材料</td>";
echo "<td colspan='2'>數量</td>";
echo "<td rowspan='2'>YIELD</td>";
echo "<td>備註</td>";
echo "<td rowspan='2'>STATUS</td>";
echo "<td rowspan='2'>NOTICE</td>";
echo "<td rowspan='2' colspan='2'>OPSI</td>";
echo "</tr>";

echo "<tr style='background-color:#cccccc; font-weight:bold;'>";
echo "<td>CUSTOMER</td>";
echo "<td>PO NO</td>";
echo "<td>LINE BATCH</td>";
echo "<td>MODEL</td>";
echo "<td>KAIN</td>";
echo "<td>FOAM</td>";
echo "<td>SHEET</td>";
echo "<td>YARD</td>";
echo "<td>KETERANGAN</td>";
echo "</tr>";
//HEADER 2 END

//ISI KOLOM
$isi_kolom='customer,bucket_stage,po_nomor,line_batch,model,textile,foam,sheet,yard,yield,keterangan,status';
$pecah_isi_kolom=pecah($isi_kolom);
$nilai_pecah_isi_kolom=nilai_pecah($isi_kolom);

$result2=mysql_query("SELECT id,id_sales_po,tgl_revisi,$isi_kolom FROM $nama_database_items WHERE induk='$id'");

//CHECKLIST FINISH
echo '<form method="POST" action="'.$address.'" onsubmit="return confirm(\''."Are you sure to Finish it?".'\');">';
	echo "<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='opsi' value='item'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>";

if (ambil_database(status,$nama_database_items,"induk='$id' AND status='Proses'")) {
	echo "<input type='image' src='modules/gambar/finish.png' width='60' height'60' name='simpan' value='Simpan'>";
}

while ($rows2=mysql_fetch_array($result2)) {

//WARNA
if ($id_items==$rows2['id']) {
	$color='yellow';
}else {
	$color='white';
}//WARNA END

	echo "<tr style='height:25px;'>";
echo "<td style='background-color:$color;'><input type='checkbox' name='id_item_terpilih[]' value='$rows2[id]'></td>";
//CHECKLIST FINISH END

$no=0;for($i=0; $i < $nilai_pecah_isi_kolom; ++$i){

if ($pecah_isi_kolom[$no]==textile) {
	echo "<td style='background-color:$color;'>".ambil_database(nama,inventory_lokasi_items,"kode='$rows2[textile]' AND kategori='KAIN'")."</td>";
}elseif ($pecah_isi_kolom[$no]==foam) {
	echo "<td style='background-color:$color;'>".ambil_database(nama,inventory_lokasi_items,"kode='$rows2[foam]' AND kategori='FOAM'")."</td>";
}else{
	echo "<td style='background-color:$color;'>".$rows2[$pecah_isi_kolom[$no]]."</td>";
}

$no++;}

//NOTICE
if (ambil_database(tgl_revisi,sales_po,"id='$rows2[id_sales_po]'") != $rows2['tgl_revisi']) {
	echo "<td style='background-color:yellow;'>".ambil_database($bahasa,pusat_bahasa,"kode='notice_update_revisi'")."</td>";
	$ijin_delete='yes';
}else{
	echo "<td></td>";
	$ijin_delete='tidak';
}
//NOTICE END

//DELETE
if (ambil_database(status,$nama_database_items,"id='$rows2[id]'") == 'Proses' OR $ijin_delete == 'yes') {
	//DELETE
	echo "<td>";
	echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt($id,"XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian&delete=".base64_encrypt($rows2['id'],"XblImpl1!A@")."".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
	echo "</td>";
	//DELETE END

	//INPUT QTY
	echo "<td>";
	echo '<a onclick="return confirm(\''."Input QTY Proses".'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id_items=".base64_encrypt($rows2['id'],"XblImpl1!A@")."&id=".base64_encrypt($id,"XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian&qty_proces=".base64_encrypt($rows2['id'],"XblImpl1!A@")."".'"><img src="modules/gambar/item.png" width="25px"/></a>';
	echo "</td>";
	//INPUT QTY PO
}
//DELETE END

$total_sheet=$rows2['sheet']+$total_sheet;
$total_yard=$rows2['yard']+$total_yard;
}
echo "</form>";
	echo "</tr>";

//TOTAL
echo "<tr style='height:30px; font-weight:bold;'>";
	echo "<td colspan='8' style='font-size:12px;'>TOTAL</td>";
	echo "<td style='font-size:12px;'>$total_sheet</td>";
	echo "<td style='font-size:12px;'>$total_yard</td>";
	echo "<td colspan='6'></td>";
echo "<tr>";
//TOTAL END

echo "</table>";
//ISI KOLOM END

//END ITEM
}else{
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
}//END UTAMA




//TAMPILAN ISI QTY........................................................................................................................
if ($id_items) {
	//kembali
	echo "<table style='margin-top:20px;'><tr><td>";
		echo '<a onclick="return confirm(\''."Close".'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id_items=".base64_encrypt($rows2['id'],"XblImpl1!A@")."&id=".base64_encrypt($id,"XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/back.png" width="25px"/></a>';
	echo "</td></tr></table>";
	//kembali

	//COLOR 1 2 3
	$color1='#00FFFF';
	$color2='';
	$color3='#00FFFF';
	//COLOR 1 2 3 END



		//TAMPIL HEADER ITEMS
			//NILAI QTY DATABASE
			$po_nomor_qty_proces=ambil_database(po_nomor,planningcls_spklaminating_qty_proces,"induk='$id_items'");
			$line_batch_qty_proces=ambil_database(line_batch,planningcls_spklaminating_qty_proces,"induk='$id_items'");
			$result7=mysql_query("SELECT DISTINCT induk FROM planningcls_spklaminating_qty_proces WHERE po_nomor='$po_nomor_qty_proces' AND line_batch='$line_batch_qty_proces'");
			$total_result7=mysql_num_rows($result7);
			while ($rows7=mysql_fetch_array($result7)){	$datasecs7[]="".$rows7[induk]."";}$data7=implode(",", $datasecs7);
			$pecah_data7=pecah($data7);
			$nilai_pecah_data7=nilai_pecah($data7);
			$no7=0;for($i7=0; $i7 < $nilai_pecah_data7; ++$i7){
				$no=0;for($i=0; $i < $nilai_pecah1; ++$i){$nama_kolom=$pecah1[$no]; $nilai_size1=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$pecah_data7[$no7]' AND logo='logo1'")+$nilai_size1; $no++;}
				$no=0;for($i=0; $i < $nilai_pecah2; ++$i){$nama_kolom=$pecah2[$no]; $nilai_size2=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$pecah_data7[$no7]' AND logo='logo2'")+$nilai_size2; $no++;}
				$no=0;for($i=0; $i < $nilai_pecah3; ++$i){$nama_kolom=$pecah3[$no]; $nilai_size3=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$pecah_data7[$no7]' AND logo='logo3'")+$nilai_size3; $no++;}
			$no7++;}
			$total_qty=$nilai_size1+$nilai_size2+$nilai_size3;

		echo "<h2>".ambil_database($bahasa,pusat_bahasa,"kode='po_nomor'")." : ".ambil_database(po_nomor,sales_po,"id='$id_sales_po'")." - ".ambil_database(line_batch,sales_po,"id='$id_sales_po'")."</h2>";
		echo "<h2>".ambil_database($bahasa,pusat_bahasa,"kode='qty_po'")." : ".ambil_database(qty_po,sales_po,"id='$id_sales_po'")."/$total_qty</h2>";
		//TAMPIL HEADER ITEMS END

	echo "<table class='tabel_utama'>";
	echo "<thead>";
	echo "<th>".ambil_database($bahasa,pusat_bahasa,"kode='po_nomor'")."</th>";
	if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
		echo "<th colspan='$nilai_pecah1'>".ambil_database(logo1,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size1,sales_po,"id='$id_sales_po'")."</th>";
		echo "<th></th>";}
	if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
		echo "<th colspan='$nilai_pecah2'>".ambil_database(logo2,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size2,sales_po,"id='$id_sales_po'")."</th>";
		echo "<th></th>";}
	if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
		echo "<th colspan='$nilai_pecah3'>".ambil_database(logo3,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size3,sales_po,"id='$id_sales_po'")."</th>";
		echo "<th></th>";}

	echo "<thead>";

	echo "<tr>";
	echo "<td>".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")."</td>";
	if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
		$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
		echo "<td style='background-color:$color1;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah1[$no]'")."</td>";$no++;}
		echo "<td style='background-color:$color1;'></td>";}
	if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
		$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
		echo "<td style='background-color:$color2;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah2[$no]'")."</td>";$no++;}
		echo "<td style='background-color:$color2;'></td>";}
	if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
		$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
		echo "<td style='background-color:$color3;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah3[$no]'")."</td>";$no++;}
		echo "<td style='background-color:$color3;'></td>";}

	echo "</td>";

	echo "<tr>";
	$result=mysql_query("SELECT * FROM sales_po_items WHERE induk='$id_sales_po' ORDER BY id");
	$rows=mysql_fetch_array($result);
	echo "<td>$rows[po_nomor]</td>";

	//JIKA SUDAH VALID BOX TIDAK BISA DIRUBAH
	if (ambil_database(validasi,sales_po,"id='$id_sales_po'") == '') {
		$disabled='';
	}else {$disabled='readonly';}

	if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
	echo "<form method='POST' action='$address'>";
	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$result1=mysql_query("SELECT * FROM sales_po_items WHERE induk='$id_sales_po' AND logo='logo1' ORDER BY id");
	$rows1=mysql_fetch_array($result1);
		$sisa_belum_dikerjakan_size1=$rows1[$pecah1[$no]]-qty_proses_per_size($po_nomor_qty_proces,$line_batch_qty_proces,$pecah1[$no],logo1);
		echo "<td style='background-color:$color1; width:18px;'>$sisa_belum_dikerjakan_size1</td>";
	$no++;
	}//BARIS 4
	echo "<td></td>";
	}

	if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
	echo "<form method='POST' action='$address'>";
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$result2=mysql_query("SELECT * FROM sales_po_items WHERE induk='$id_sales_po' AND logo='logo2' ORDER BY id");
	$rows2=mysql_fetch_array($result2);
		$sisa_belum_dikerjakan_size2=$rows2[$pecah2[$no]]-qty_proses_per_size($po_nomor_qty_proces,$line_batch_qty_proces,$pecah2[$no],logo2);
		echo "<td style='background-color:$color2; width:18px;'>$sisa_belum_dikerjakan_size2</td>";
	$no++;
	}//BARIS 4
	echo "<td></td>";
	}

	if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
	echo "<form method='POST' action='$address'>";
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$result3=mysql_query("SELECT * FROM sales_po_items WHERE induk='$id_sales_po' AND logo='logo3' ORDER BY id");
	$rows3=mysql_fetch_array($result3);
		$sisa_belum_dikerjakan_size3=$rows3[$pecah3[$no]]-qty_proses_per_size($po_nomor_qty_proces,$line_batch_qty_proces,$pecah3[$no],logo3);
		echo "<td style='background-color:$color3; width:18px;'>$sisa_belum_dikerjakan_size3</td>";
	$no++;
	}//BARIS 4
	echo "<td></td>";
	}
	echo "</tr>";


	//ISI KOLOM QTY YANG INGIN DI KERJAKAN
	echo "<tr>";

	if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
	echo "<form method='POST' action='$address'>";
	echo "<td></td>";
	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
		$result1=mysql_query("SELECT * FROM planningcls_spklaminating_qty_proces WHERE induk='$id_items' AND logo='logo1' ORDER BY id");
		$rows1=mysql_fetch_array($result1);
		$sisa_belum_dikerjakan_size1=ambil_database($pecah1[$no],sales_po_items,"induk='$id_sales_po' AND logo='logo1'")-qty_proses_per_size($po_nomor_qty_proces,$line_batch_qty_proces,$pecah1[$no],logo1);
		echo "<input type='hidden' name='$pecah1[$no]_pembatas' value='$sisa_belum_dikerjakan_size1'>";
		echo "<td style='background-color:$color1; width:18px;'><input type='text' name='".$pecah1[$no]."' value='".$rows1[$pecah1[$no]]."' style='width:30px;'></td>";
	$no++;
	}//BARIS 4
	echo "	<input type='hidden' name='id' value='$id'>
					<input type='hidden' name='id_items' value='$id_items'>
					<input type='hidden' name='halaman' value='$nomor_halaman'>
					<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
					<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
					<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
					<input type='hidden' name='pencarian' value='$pencarian'>
					<input type='hidden' name='opsi' value='$opsi'>
					<input type='hidden' name='id_update' value='$rows1[id]'>
					<input type='hidden' name='update' value='logo1'>";
	echo "<td style='background-color:$color1;'><input type='image' src='modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";
	echo "</form>";
	}

	if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
	echo "<form method='POST' action='$address'>";
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
		$result2=mysql_query("SELECT * FROM planningcls_spklaminating_qty_proces WHERE induk='$id_items' AND logo='logo2' ORDER BY id");
		$rows2=mysql_fetch_array($result2);
		$sisa_belum_dikerjakan_size2=ambil_database($pecah2[$no],sales_po_items,"induk='$id_sales_po' AND logo='logo2'")-qty_proses_per_size($po_nomor_qty_proces,$line_batch_qty_proces,$pecah2[$no],logo2);
		echo "<input type='hidden' name='$pecah2[$no]_pembatas' value='$sisa_belum_dikerjakan_size2'>";
		echo "<td style='background-color:$color2; width:18px;'><input type='text' name='".$pecah2[$no]."' value='".$rows2[$pecah2[$no]]."' style='width:30px;'></td>";
	$no++;}
	echo "	<input type='hidden' name='id' value='$id'>
					<input type='hidden' name='id_items' value='$id_items'>
					<input type='hidden' name='halaman' value='$nomor_halaman'>
					<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
					<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
					<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
					<input type='hidden' name='pencarian' value='$pencarian'>
					<input type='hidden' name='opsi' value='$opsi'>
					<input type='hidden' name='id_update' value='$rows2[id]'>
					<input type='hidden' name='update' value='logo2'>";
	echo "<td style='background-color:$color2;'><input type='image' src='modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";
	echo "</form>";
	}

	if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
	echo "<form method='POST' action='$address'>";
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
		$result3=mysql_query("SELECT * FROM planningcls_spklaminating_qty_proces WHERE induk='$id_items' AND logo='logo3' ORDER BY id");
		$rows3=mysql_fetch_array($result3);
		$sisa_belum_dikerjakan_size3=ambil_database($pecah3[$no],sales_po_items,"induk='$id_sales_po' AND logo='logo3'")-qty_proses_per_size($po_nomor_qty_proces,$line_batch_qty_proces,$pecah3[$no],logo3);
		echo "<input type='hidden' name='$pecah3[$no]_pembatas' value='$sisa_belum_dikerjakan_size3'>";
		echo "<td style='background-color:$color3; width:18px;'><input type='text' name='".$pecah3[$no]."' value='".$rows3[$pecah3[$no]]."' style='width:30px;'></td>";
	$no++;}
	echo "<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='id_items' value='$id_items'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='opsi' value='$opsi'>
				<input type='hidden' name='id_update' value='$rows3[id]'>
				<input type='hidden' name='update' value='logo3'>";
	echo "<td style='background-color:$color3;'><input type='image' src='modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";
	echo "</form>";}

	echo "</tr>";
	//ISI KOLOM QTY YANG INGIN DI KERJAKAN END


	echo "</table>";
}//TAMPILAN ISI QTY END


}//END HOME
//END PHP?>
