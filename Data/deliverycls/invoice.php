<?php global $mod;
	$mod='deliverycls/invoice';
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
$column_header='tanggal,no_invoice,tanggal_batas,dari,alamat,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,id_packing_list,pembuat,tgl_dibuat';

$nama_database='deliverycls_invoice';
$nama_database_items='deliverycls_invoice_items';

$address='?mod=deliverycls/invoice';

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


//UPDATE DAN DELETE
//BERDASARKAN NO INVOICE dan INDUK
$no_invoice=ambil_database(no_invoice,$nama_database,"id='$id'");
if (ambil_database(induk,$nama_database_items,"induk='$id'")=='' OR $no_invoice != ambil_database(no_invoice,$nama_database_items,"induk='$id'")) {
mysql_query("DELETE FROM $nama_database_items WHERE induk='$id'");//DELETE SEBELUM INSERT
$id_packing_list=ambil_database(id_packing_list,$nama_database,"id='$id'");
$result=mysql_query("SELECT * FROM deliverycls_packing_list_items WHERE induk='$id_packing_list'");
while ($rows=mysql_fetch_array($result)){
	$total_pairs=ambil_database(total_pairs,deliverycls_packing_list_items,"id='$rows[id]'");
	$style_item_kode=ambil_database(style_item_kode,deliverycls_packing_list_items,"id='$rows[id]'");
	$material_description_po=ambil_database(material_description_po,deliverycls_packing_list_items,"id='$rows[id]'");
	$model=ambil_database(model,deliverycls_packing_list_items,"id='$rows[id]'");
	$po_nomor=ambil_database(po_nomor,deliverycls_packing_list_items,"id='$rows[id]'");
	$no_spk_cutting=ambil_database(no_spk_cutting,deliverycls_packing_list_items,"id='$rows[id]'");
	$id_po=ambil_database(id_po,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");
	$harga_satuan=ambil_database(price_usd,sales_po,"id='$id_po'");
	$satuan=ambil_database(satuan,sales_po,"id='$id_po'");
	$total_harga_satuan=$harga_satuan*$total_pairs;
mysql_query("INSERT INTO $nama_database_items	SET
	 					induk='$id',
						id_packing_list='$rows[id]',
						no_invoice='$no_invoice',
						total_pairs='$total_pairs',
						style_item_kode='$style_item_kode',
						material_description_po='$material_description_po',
						model='$model',
						satuan='$satuan',
						po_nomor='$po_nomor',
						mata_uang='Dollar',
						harga_satuan='$harga_satuan',
						total_harga_satuan='$total_harga_satuan'");
}}else{}
//UPDATE DAN DELETE END

//UPDATE MATA UANG dan PPN
if($_POST['mata_uang'] != ''){
$mata_uang=$_POST['mata_uang'];
if ($mata_uang=='Rupiah'){$ambil_harga='price_rp';}
elseif ($mata_uang=='Dollar'){$ambil_harga='price_usd';}else{}
$result=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows=mysql_fetch_array($result)){
	$no_spk_cutting=ambil_database(no_spk_cutting,deliverycls_packing_list_items,"id='$rows[id_packing_list]'");
	$id_po=ambil_database(id_po,planningcls_spkcuttingdies,"no_spk_cutting='$no_spk_cutting'");
	$harga_satuan=ambil_database($ambil_harga,sales_po,"id='$id_po'");
	$total_harga_satuan=$harga_satuan*$rows['total_pairs'];
	mysql_query("UPDATE $nama_database_items SET mata_uang='$mata_uang',harga_satuan='$harga_satuan',total_harga_satuan='$total_harga_satuan',ppn='$_POST[ppn]' WHERE id='$rows[id]'");
}}////UPDATE MATA UANG

//UPDATE SURAT JALAN
if ($_POST['surat_jalan']) {
	mysql_query("UPDATE $nama_database_items SET surat_jalan='$_POST[surat_jalan]' WHERE id='$_POST[id_items]'");
}
//UPDATE SURAT JALAN END

//FINISH
if ($_GET['fnh']) {
	mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$id'");
}
//FINISH END


	//Kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	//Kembali END
	echo "</td><td>";
	//Print
	echo "<form method ='POST' action='modules/deliverycls/cetak/cetak_invoice.php' target='_blank'>";
	echo "<input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
				<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='bahasa' value='$bahasa'>
				</form>";
	echo "</td></tr></table>";
	//Print END

	//HEADER PERTAMA
	echo "<table style='width:100%;'>";
	echo "<tr><td><center><img src='modules/gambar/logo_lengkap.png' width='50%'/><center></td></tr>";
	echo "<tr><td><center><h1>INVOICE</h1><center></td></tr>";
	echo "<table>";
	//HEADER PERTAMA END

	//FINISH
	echo "<table><tr><td>";
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses'){
		echo '<a onclick="return confirm(\''."Finish it?".' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&opsi=".base64_encrypt("item","XblImpl1!A@")."&id=".base64_encrypt("$id","XblImpl1!A@")."&fnh=1&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/finish.png" height="25px"/></a>';
	}
	echo "</td></tr>";
	echo "</table>";
	//FINISH END

	//HEADER KEDUA
	echo "<table style='width:100%; font-weight:bold; font-size:12px; border-style: ridge;'>";
	echo "<tr>";
	echo "<td style='width:75%;'>CONSIGNEE</td>";
	echo "<td style='width:10%;'>INVOICE</td>";
	echo "<td style='width:15%;'>: ".ambil_database(no_invoice,$nama_database,"id='$id'")."</td>";
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
	echo "</table>";

	echo "<table style='width:100%; font-weight:bold; font-size:10px; border-style: ridge; margin-top:5px;'>";
		echo "<tr>";
			echo "<td style='width:80%;' rowspan='2'>NOTIFY PARTY</td>";
			echo "<td style='width:auto;'>DESTINATION</td>";
			echo "<td style='width:auto;'>: Same as consignee</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td style='width:auto;'>PAYMENT TERM</td>";
			echo "<td>: ".ambil_database(payment_term,$nama_database,"id='$id'")." Day</td>";
		echo "</tr>";
	echo "</table>";
	//HEADER KEDUA END

//PILIHAN MATA UANG
if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
echo "<table style='margin-top:10px;'>";
echo "<form method='POST' action='$address'>";
echo "<tr>";

echo "<td>Mata Uang : </td";
echo "<td>";
echo "<select name='mata_uang' class='comboyuk'>";
echo "<option>".ambil_database(mata_uang,$nama_database_items,"induk='$id'")."</option>";
echo "<option>Rupiah</option>";
echo "<option>Dollar</option>";
echo "</select>";
echo "</td>";

echo "<td>PPN : </td";
echo "<td>";
echo "<select name='ppn' class='comboyuk' style='width:50px;'>";
echo "<option>".ambil_database(ppn,$nama_database_items,"induk='$id'")."</option>";
echo "<option>0</option>";
echo "<option>10</option>";
echo "<option>15</option>";
echo "<option>20</option>";
echo "</select>";
echo "</td>";

echo "
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='opsi' value='$opsi'>
<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
<input type='hidden' name='pencarian' value='$pencarian'>
<td><input type='image' src='modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";

echo "</tr>";
echo "</form>";
echo "</table>";
}//PILIHAN MATA UANG END

//ISI KOLOM
echo "<table class='tabel_utama' style='margin-top:15px; width:100%;'>";

	echo "<thead>";
		echo "<th>NO</th>";
		echo "<th>QTY</th>";
		echo "<th>MATERIAL CODE</th>";
		echo "<th>ITEM NAME</th>";
		echo "<th>MODEL</th>";
		echo "<th>PO NOMOR</th>";
		echo "<th>SURAT JALAN</th>";
		echo "<th>U/PRICE</th>";
		echo "<th>AMOUNT</th>";
		echo "<th>OPSI</th>";
	echo "</thead>";


$isi_kolom='total_pairs,style_item_kode,material_description_po,model,po_nomor,surat_jalan,harga_satuan,total_harga_satuan';
$pecah_isi_kolom=pecah($isi_kolom);
$jumlah_isi_kolom=nilai_pecah($isi_kolom);
$number=1;
$result2=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows2=mysql_fetch_array($result2)) {
echo "<form method='POST' action='$address'>";
echo "<tr>";
echo "<td>$number</td>";
$no=0;for($i=0; $i < $jumlah_isi_kolom; ++$i){

//TAMPILAN HARGA
if ($pecah_isi_kolom[$no] == 'harga_satuan' OR $pecah_isi_kolom[$no] == 'total_harga_satuan') {
	if ($rows2[mata_uang]==Rupiah){$mata_uang='rupiah';}else{$mata_uang='dollar';}
	echo "<td style='text-align:right;'>".$mata_uang($rows2[$pecah_isi_kolom[$no]])."</td>";
}
//TAMPILAN SURAT JALAN
elseif ($pecah_isi_kolom[$no] == 'surat_jalan') {
	if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
	echo "<td><input type='text' name='surat_jalan' value='$rows2[surat_jalan]' style='width:60px;'></td>";
	}else {
	echo "<td>$rows2[surat_jalan]</td>";
	}
}
//TAMPILAN NORMAL
else {
	echo "<td>".$rows2[$pecah_isi_kolom[$no]]."</td>";
}
$no++;}

if (ambil_database(status,$nama_database,"id='$id'")=='Proses') {
	echo "
	<input type='hidden' name='id_items' value='$rows2[id]'>
	<input type='hidden' name='id' value='$id'>
	<input type='hidden' name='opsi' value='$opsi'>
	<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
	<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
	<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
	<input type='hidden' name='pencarian' value='$pencarian'>
	<td><input type='image' src='modules/gambar/save.png' width='25' height'25' name='simpan' value='Simpan'></td>";
	echo "</form>";
}else {
	echo "<td></td>";
}

echo "</tr>";$number++;

$grand_total_pairs=$rows2[total_pairs]+$grand_total_pairs;
$grand_total_harga_satuan=$rows2[total_harga_satuan]+$grand_total_harga_satuan;
}

echo "<tr>
				<td rowspan='3'></td>
				<td style='font-weight:bold;font-size:10px;'>$grand_total_pairs</td>
				<td rowspan='3'></td>
				<td colspan='5' style='text-align:left;font-weight:bold;font-size:10px;'>TOTAL</td>";
				if (ambil_database(mata_uang,$nama_database_items,"induk='$id'")==Rupiah){$mata_uang='rupiah';}else{$mata_uang='dollar';}
				echo "<td style='font-weight:bold;font-size:10px;text-align:right;'>".$mata_uang($grand_total_harga_satuan)."</td>
				<td rowspan='3'></td>
			</tr>";

$total_ppn=$grand_total_harga_satuan*ambil_database(ppn,$nama_database_items,"induk='$id'")/100;
echo "<tr>
				<td></td>
				<td colspan='5' style='text-align:left;font-weight:bold;font-size:10px;'>PPN ".ambil_database(ppn,$nama_database_items,"induk='$id'")."%</td>
				<td style='font-weight:bold;font-size:10px;text-align:right;'>".$mata_uang($total_ppn)."</td>
			</tr>";

$total_dikurangin_ppn=$grand_total_harga_satuan-$total_ppn;
echo "<tr>
				<td style='font-weight:bold;font-size:10px;'>".ambil_database(satuan,$nama_database_items,"induk='$id'")."</td>
				<td colspan='5' style='text-align:left;font-weight:bold;font-size:10px;'>GRAND TOTAL</td>
				<td style='font-weight:bold;font-size:10px;text-align:right;'>".$mata_uang($total_dikurangin_ppn)."</td>
			</tr>";

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
