<?php global $mod;
	$mod='admincls/balanceorderpurchasingclaim';
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

function total_masuk_per_dokumen($id,$kodebarang,$nama,$satuan){
$sql="SELECT masuk FROM inventory_distribusi_items WHERE induk='$id' AND kodebarang='$kodebarang' AND nama='$nama' AND satuan='$satuan'";
$result=mysql_query($sql);
while ($rows=mysql_fetch_array($result)){
	$total_masuk=$rows[masuk]+$total_masuk;}
return $total_masuk;}

function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,kepada,jenis_po_purchasing,po_purchasing';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);


$address='?mod=admincls/balanceorderpurchasingclaim';
if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}

$opsi=$_POST['opsi'];
$id=$_POST['id'];
$nomor_halaman=$_POST['halaman'];
$pilihan_tahun=$_POST['pilihan_tahun'];
$pilihan_bulan=$_POST['pilihan_bulan'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];
$pencarian=$_POST['pencarian'];



//UPDATE STATUS SELESAI DAN PROSES
	$result12_claim=mysql_query("SELECT * FROM admin_claim_purchasing WHERE status='Proses'");
	while ($rows12_claim=mysql_fetch_array($result12_claim)) {
		//STOK PURCHASING
		$result13_claim=mysql_query("SELECT SUM(qty_purchasing) as tqty_purchasing FROM admin_claim_purchasing_items WHERE induk='$rows12_claim[id]'");
		$rows13_claim=mysql_fetch_array($result13_claim);
		//STOK while
		$result14_claim=mysql_query("SELECT SUM(qty) as tqty FROM admin_claim_purchasing_dokumen_masuk WHERE induk='$rows12_claim[id]'");
		$rows14_claim=mysql_fetch_array($result14_claim);

		if ($rows13_claim['tqty_purchasing']==$rows14_claim['tqty']){
			mysql_query("UPDATE admin_claim_purchasing SET status='Selesai' WHERE id='$rows12_claim[id]'");
		}
	}
//UPDATE STATUS SELESAI DAN PROSES END



//START ITEM
echo "<table>
<form method ='post' action='$address'>
<tr>
 <td>".ambil_database($bahasa,pusat_bahasa,"kode='bulan'")."</td>
 <td>:</td>
 <td><select name='pilihan_bulan'>
		<option value='$pilihan_bulan'>".$pilihan_bulan."</option>
		<option value=''></option>
		<option value='01'>01</option>
		<option value='02'>02</option>
		<option value='03'>03</option>
		<option value='04'>04</option>
		<option value='05'>05</option>
		<option value='06'>06</option>
		<option value='07'>07</option>
		<option value='08'>08</option>
		<option value='09'>09</option>
		<option value='10'>10</option>
		<option value='11'>11</option>
		<option value='12'>12</option>
 </td>
 <td>".ambil_database($bahasa,pusat_bahasa,"kode='tahun'")."</td>
 <td>:</td>";
 echo "
 <td><select name='pilihan_tahun'>";
 echo "<option value='$pilihan_tahun'>$pilihan_tahun</option>";
 $now=date('Y')+3;
 for ($a=date('Y')-3;$a<=$now;$a++)
	{echo "<option value='".$a."'>".$a."</option>";}
	echo "</select></td>";
if ($pilihan_bulan != '' OR $pilihan_tahun != '') {
echo "
</table>
<table>
<tr>
<td>".ambil_database($bahasa,pusat_bahasa,"kode='pencarian'")."</td>
<td>:</td>
<td><input type='text' name='pencarian' value='$pencarian'></td>
<td><select name='pilihan_pencarian'>";
	$sql1="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pilihan_pencarian'";
	$result1=mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);
	echo "<option value='$rows1[kode]'>".$rows1[$bahasa]."</option>";
$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
	$sql2="SELECT $bahasa FROM pusat_bahasa WHERE kode='$pecah_column_header[$no]'";
	$result2=mysql_query($sql2);
	$rows2=mysql_fetch_array($result2);
	echo "<option value='$pecah_column_header[$no]'>".$rows2[$bahasa]."</option>";
$no++;}
echo "
</select>
</td>
</tr>";}
 echo "
 <td><input type='submit' value='".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."'></td>
</tr>
</form>
</table>
</br>";


//PRINT EXCEL
echo "<a href='modules/admincls/cetak/print_excel_balance_order_claim.php?pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pencarian=$pencarian&pilihan_pencarian=$pilihan_pencarian' target='_blank'><img src='modules/gambar/save_excel.png' width='25px'/></a></br>";


//TABEL
include 'style.css';
echo "<table class='tabel_utama' style='width:auto;'>";

	echo "<thead>";
	echo "<th>No</th>";
	echo "<th>Tanggal</th>";
	echo "<th>Pengirim</th>";
	echo "<th>Jenis PO</th>";
	echo "<th>Nomor PO</th>";
	echo "<th>Bucket</th>";
	echo "<th>Kode Barang</th>";
	echo "<th>Material Description</th>";
	echo "<th>Satuan</th>";
	echo "<th>QTY Order</th>";
	echo "<th style='width:110px; align:left;'>Tgl & QTY telah Diterima</th>";
	echo "<th>Total QTY</th>";
	echo "<th>Balance</th>";
	echo "</thead>";


if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
$result=mysql_query("SELECT * FROM admin_claim_purchasing WHERE status='Proses' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian");
$no=1;
while ($rows=mysql_fetch_array($result)){

$result1=mysql_query("SELECT * FROM admin_claim_purchasing_items WHERE induk='$rows[id]'");
$rowspan=mysql_num_rows($result1)+1;

echo "<tr>";
		echo "<td rowspan='$rowspan'>$no</td>";
		echo "<td rowspan='$rowspan'>$rows[tanggal]</td>";
		echo "<td rowspan='$rowspan'>$rows[kepada]</td>";
		echo "<td rowspan='$rowspan'>$rows[jenis_po_purchasing]</td>";
		echo "<td rowspan='$rowspan'>$rows[po_purchasing]</td>";
echo "</tr>";


$result1=mysql_query("SELECT * FROM admin_claim_purchasing_items WHERE induk='$rows[id]'");
while ($rows1=mysql_fetch_array($result1)){
echo "<tr>";
		echo "<td>$rows1[etd]</td>";
		echo "<td>$rows1[kode_barang]</td>";
		echo "<td>$rows1[material_description_po]</td>";
		echo "<td>$rows1[satuan]</td>";
		echo "<td>$rows1[qty_purchasing]</td>";
		echo "<td style='text-align:left; padding-left:10px;'>";
		$sql03="SELECT id_distribusi_masuk,qty FROM admin_claim_purchasing_dokumen_masuk WHERE induk='$rows[id]' AND kodebarang='$rows1[kode_barang]'";
		$result03=mysql_query($sql03);
		while ($rows03=mysql_fetch_array($result03)) {
			if ($rows03['qty']) {
				echo ambil_database(selesai_masuk,inventory_distribusi,"id='$rows03[id_distribusi_masuk]'")." : $rows03[qty]</br>";//total_masuk_per_dokumen($rows03[id_distribusi_masuk],$rows1[kode_barang])
			}
		}echo "</td>";

		$nilai_id_distribusi=ambil_variabel_kutip_satu_where(admin_claim_purchasing_dokumen_masuk,id_distribusi_masuk,"WHERE induk='$rows[id]'");
		$qty_nilai=ambil_variabel_satu_where(admin_claim_purchasing_dokumen_masuk,qty,"WHERE id_distribusi_masuk IN ($nilai_id_distribusi) AND kodebarang='$rows1[kode_barang]'");
		$di_kurang=$rows1[qty_purchasing]-$qty_nilai;
		echo "<td>$qty_nilai</td>";

		if ($di_kurang=='0'){$color='#00FFFF';}elseif($di_kurang<0){$color='red';}else{$color='yellow';}
		echo "<td style='background-color:$color;'>$di_kurang</td>";

echo "</tr>";}


$no++;}
echo "</table>";
}//END HOME
//END PHP?>
