<?php global $mod;
	$mod='admincls/purchasing';
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
	$total_masuk=$rows[masuk]+$total_masuk;
}
return $total_masuk;}

function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,kepada,jenis_po_purchasing,po_purchasing,paymen_term,attn,note,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,kepada,jenis_po_purchasing,note,discount,pembuat,tgl_dibuat';

$column_items='po_nomor,line_batch,departement,kode_barang,material_description_po,cauge_width,satuan,qty_purchasing,harga,total_harga,etd,remark,pcx_no,season,shoe_model,supplier_alocation';
//po_nomor,line_batch,departement,kode_barang,material_description_po,cauge_width,satuan,qty_purchasing,price_usd,amount_usd,price_rp,amount_rp,etd,remark,pcx_no,season,shoe_model,supplier_alocation

$kolom_input='id_po,departement,kode_barang,material_description_po,satuan,qty_purchasing,jenis_mata_uang,harga,etd,remark,pcx_no,season,shoe_model,cauge_width,supplier_alocation';
//id_po,departement,kode_barang,material_description_po,satuan,qty_purchasing,price_usd,price_rp,price_nt,etd,remark,pcx_no,season,shoe_model,cauge_width,supplier_alocation

$nama_database='admin_purchasing';
$nama_database_items='admin_purchasing_items';

$address='?mod=admincls/purchasing';

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


//UPDATE STATUS SELESAI DAN PROSES
	$result12=mysql_query("SELECT * FROM admin_purchasing WHERE status='Proses'");
	while ($rows12=mysql_fetch_array($result12)) {
		//STOK PURCHASING
		$result13=mysql_query("SELECT SUM(qty_purchasing) as tqty_purchasing FROM admin_purchasing_items WHERE induk='$rows12[id]'");
		$rows13=mysql_fetch_array($result13);
		//STOK while
		$result14=mysql_query("SELECT SUM(qty) as tqty FROM admin_purchasing_dokumen_masuk WHERE induk='$rows12[id]'");
		$rows14=mysql_fetch_array($result14);

		if ($rows13['tqty_purchasing']==$rows14['tqty']){
			mysql_query("UPDATE admin_purchasing SET status='Selesai' WHERE id='$rows12[id]'");
		}
	}
//UPDATE STATUS SELESAI DAN PROSES END



//INSERT DOKUMEN KIRIM
if ($_POST['id_distribusi_masuk']){
	$id_distribusi_masuk=$_POST['id_distribusi_masuk'];
	$nomor_doc=ambil_database(nomor_doc,inventory_distribusi,"id='$id_distribusi_masuk'");
	$tanggal_doc=ambil_database(tanggal_doc,inventory_distribusi,"id='$id_distribusi_masuk'");
	$supplier=ambil_database(kontak,inventory_distribusi,"id='$id_distribusi_masuk'");

	if (ambil_database(id_distribusi_masuk,admin_purchasing_dokumen_masuk,"id_distribusi_masuk='$id_distribusi_masuk'")!=$id_distribusi_masuk) {
		mysql_query("INSERT INTO admin_purchasing_dokumen_masuk SET induk='$id',nomor_doc='$nomor_doc',tanggal_doc='$tanggal_doc',supplier='$supplier',id_distribusi_masuk='$id_distribusi_masuk'");
	}
}//INSERT DOKUMEN KIRIM END


//START ITEM
if ($opsi=='item'){

//ALL ONE
echo kalender();
echo combobox();
include 'style.css';
$nilai_column=nilai_pecah($column_items);
$jumlah_column=pecah($column_items);

$jumlah_kolom_input=pecah($kolom_input);
$nilai_kolom_input=nilai_pecah($kolom_input);


//EKSEKUSI

//TAMBAH START
if ($_POST[tambah] AND ambil_database(status,$nama_database,"id='$id'")=='') {
$no=0;for($i=0; $i < $nilai_kolom_input; ++$i){

// 1 Input Masuk 2
if ($jumlah_kolom_input[$no]==id_po){$nilai_id_po=$_POST[$jumlah_kolom_input[$no]]; $nama_kolom=$jumlah_kolom_input[$no]; $isi_kolom=$_POST[$jumlah_kolom_input[$no]];}
elseif ($jumlah_kolom_input[$no]==kode_barang){$nilai_id_kode_barang=$_POST[$jumlah_kolom_input[$no]]; $nama_kolom=$jumlah_kolom_input[$no]; $isi_kolom=$_POST[$jumlah_kolom_input[$no]];}
elseif ($jumlah_kolom_input[$no]==harga){
			if ($_POST['jenis_mata_uang']=='RP') {
				$mata_uang='price_rp';
			}elseif ($_POST['jenis_mata_uang']=='USD') {
				$mata_uang='price_usd';
			}elseif ($_POST['jenis_mata_uang']=='NT') {
				$mata_uang='price_nt';
			}else{}
	$nama_kolom=$mata_uang; $isi_kolom=$_POST[$jumlah_kolom_input[$no]];}
else {$nama_kolom=$jumlah_kolom_input[$no]; $isi_kolom=$_POST[$jumlah_kolom_input[$no]];}

$datasecs[]=$nama_kolom."='".$isi_kolom."'";$no++;}
$data=implode(",", $datasecs);

$insert ="INSERT INTO $nama_database_items SET $data";
mysql_query($insert);


//UPDATE SPESIAL
$data2=implode(" AND ", $datasecs);
$ambil_id=ambil_database(id,admin_purchasing_items,$data2);
$ambil_usd1=ambil_database(price_usd,admin_purchasing_items,"id='$ambil_id'");
$ambil_rp1=ambil_database(price_rp,admin_purchasing_items,"id='$ambil_id'");
$ambil_nt1=ambil_database(price_nt,admin_purchasing_items,"id='$ambil_id'");
$ambil_jumlah_spk=ambil_database(qty_purchasing,admin_purchasing_items,"id='$ambil_id'");

$ambil_nomor_po=ambil_database(po_nomor,sales_po,"id='$nilai_id_po'");
$ambil_line_batch=ambil_database(line_batch,sales_po,"id='$nilai_id_po'");

//JIKA CARI OTOMATIS KODE
if ($_POST['otomatis_input']) {
$ambil_kode_barang=ambil_database(beacukai_kode_barang,inventory_barang,"id='$nilai_id_kode_barang'");
$ambil_material_description_po=ambil_database(beacukai_nama_barang,inventory_barang,"id='$nilai_id_kode_barang'");
$ambil_satuan=ambil_database(satuan,inventory_barang,"id='$nilai_id_kode_barang'");
$ambil_departement=ambil_database(departement,inventory_barang,"id='$nilai_id_kode_barang'");
$otomatiskode="
kode_barang='$ambil_kode_barang',
material_description_po='$ambil_material_description_po',
satuan='$ambil_satuan',
departement='$ambil_departement',
";}////JIKA CARI OTOMATIS KODE END

if ($ambil_usd1=='0' AND $ambil_rp1=='0') {
	$ambil_usd=ambil_database(harga_usd,inventory_barang,"id='$nilai_id_kode_barang'");
	$ambil_rp=ambil_database(harga_rp,inventory_barang,"id='$nilai_id_kode_barang'");
	$ambil_nt=ambil_database(harga_nt,inventory_barang,"id='$nilai_id_kode_barang'");
	$otomatis_harga="
	price_rp='$ambil_rp',
	price_nt='$ambil_nt',
	price_usd='$ambil_usd',";
}else{
	$ambil_usd=$ambil_usd1;
	$ambil_rp=$ambil_rp1;
	$ambil_nt=$ambil_nt1;
}
$ambil_amount_usd=$ambil_usd*$ambil_jumlah_spk;
$ambil_amount_rp=$ambil_rp*$ambil_jumlah_spk;
$ambil_amount_nt=$ambil_nt*$ambil_jumlah_spk;

$update="UPDATE $nama_database_items SET
induk='$id',
$otomatiskode
$otomatis_harga
amount_usd='$ambil_amount_usd',
amount_rp='$ambil_amount_rp',
amount_nt='$ambil_amount_nt',
po_nomor='$ambil_nomor_po',
line_batch='$ambil_line_batch'
WHERE id='$ambil_id'";
mysql_query($update);
//UPDATE SPESIAL END
}//TAMBAH END

//HAPUS
if (base64_decrypt($_GET['hapus'],"XblImpl1!A@")) {
	$id_items=base64_decrypt($_GET['hapus'],"XblImpl1!A@");
	$delete="DELETE FROM $nama_database_items WHERE id='$id_items'";
	mysql_query($delete);
}
//HAPUS DOKUMEN
if (base64_decrypt($_GET['hapus_d'],"XblImpl1!A@")) {
	$id_items=base64_decrypt($_GET['hapus_d'],"XblImpl1!A@");
	$delete="DELETE FROM admin_purchasing_dokumen_masuk WHERE id='$id_items'";
	mysql_query($delete);
}
//EKSEKUSI END

//kembali
echo "<table><tr><td>";
echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
echo "</td>";

if (ambil_database(validasi,$nama_database,"id='$id'")=='Valid') {
echo "<td>";
      // <form method ='POST' action='modules/admincls/cetak/cetak_purchasing.php' target='_blank'>
      // <input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
			// <input type='hidden' name='id' value='$id'>
			// <input type='hidden' name='bahasa' value='$bahasa'>
			// <input type='hidden' name='username' value='$_SESSION[username]'>
			// </form>
echo '<a href="#" onClick="window.open(\''."modules/admincls/cetak/cetak_purchasing.php?id=$id&bahasa=$bahasa&username=$_SESSION[username]".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='modules/gambar/print.png' width='25' height='25'/>".'</a>';
echo "</td><td>
			<form method ='POST' action='modules/admincls/cetak/print_excel_purchasing.php' target='_blank'>
			<input type='image' src='modules/gambar/save_excel.png' width='25' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='username' value='$_SESSION[username]'>
			</form>
			</td>";
		}

echo "
</tr></table>";
//kembali


//HEADER 1
echo "<div>";
echo "<table style='width:100%;'>";
echo "<tr>";
if (ambil_database(kepada,$nama_database,"id='$id'")=='TIONG LIONG INDUSTRIAL CO., LTD.'){$logo_lengkap='logo_lengkap_taiwan.png';}else{$logo_lengkap='logo_lengkap.png';}
	echo "<td><center><img src='modules/gambar/$logo_lengkap' width='50%' height='10%'/><center></td>";

echo "</tr>";echo "<tr>";
echo "<td><center><h2>PURCHASE ORDER</br>採購訂單</h2><center></td>";
echo "</tr>";
echo "</table></br></br></div>";
//HEADER 1 END

//HEADER 2
echo "<table  style='width:100%;'>";
echo "<tr>";echo "<td style='width:20%;'></td>";echo "<td style='width:20%;'></td>";echo "<td style='width:20%;'></td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='tanggal'")."</strong></td>";
echo "<td style='width:20%;'>: ".ambil_database(tanggal,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='po_purchasing'")."</strong></td>";
echo "<td>: ".ambil_database(po_purchasing,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='paymen_term'")."</strong></td>";

if (ambil_database(kepada,$nama_database,"id='$id'")=='TIONG LIONG INDUSTRIAL CO., LTD.'){$day="";}else{$day=ambil_database($bahasa,pusat_bahasa,"kode='hari'");}

echo "<td>: ".ambil_database(paymen_term,$nama_database,"id='$id'")." $day</td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='kepada'")."</strong></td>";
echo "<td>: ".ambil_database(kepada,$nama_database,"id='$id'")."</td>";
echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='attn'")."</strong></td>";
echo "<td>: ".ambil_database(attn,$nama_database,"id='$id'")."</td>";
echo "</tr>";

echo "<tr>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='note'")."</strong></td>";
echo "<td><textarea disabled>".ambil_database(note,$nama_database,"id='$id'")."</textarea></td>";
echo "</tr>";

echo "</table></br></br></br>";
//HEADER 2 END


//TABEL PENGIRIMAN.
if (ambil_database(validasi,$nama_database,"id='$id'") != Valid AND 0==1) {
echo "<table>";
echo "<form method='POST' action='$address'>";
echo "<tr>";
	echo "<td>";
	echo "Dokumen";
	echo "</td>";
	$nilai_id_distribusi_masuk=ambil_variabel_kutip_satu(admin_purchasing_dokumen_masuk,id_distribusi_masuk);
	$sql01="SELECT * FROM inventory_distribusi WHERE status='Selesai' AND kegiatan='masuk' AND jenis_doc LIKE 'BC %' AND selesai_masuk NOT LIKE '0000-00-00' AND id NOT IN ($nilai_id_distribusi_masuk) AND tanggal > '2020-12-01' ORDER BY tanggal";
	$result01=mysql_query($sql01);
	echo "<td>
	<select class='comboyuk' name='id_distribusi_masuk'>
	<option value=''></option>";
		while ($rows01=mysql_fetch_array($result01)) {
	echo "<option value='$rows01[id]'>$rows01[nomor_doc] | $rows01[tanggal_doc] | $rows01[jenis_doc] | $rows01[kontak]</option>";}
	echo "
	</select>
	</td>";
	echo "<td>";
	echo "
	<input type='image' src='modules/gambar/tambah.png' width='30' height'30' name='simpan' value='simpan'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='opsi' value='$opsi'>
			<input type='hidden' name='id' value='$id'>";
	echo "</td>";

echo "</tr>";
echo "</form>";
echo "</table>";}


echo "<table class='tabel_utama' style='margin-bottom:25px;'>";
echo "<thead>";
	echo "<th>Tanggal Dok</th>";
	echo "<th>Dokumen</th>";
	echo "<th>Supplier</th>";
echo "</thead>";

$sql02="SELECT * FROM admin_purchasing_dokumen_masuk WHERE induk='$id'";
$result02=mysql_query($sql02);
	while ($rows02=mysql_fetch_array($result02)) {
		echo "<tr>";
		echo "<td>$rows02[tanggal_doc]</td>";
		echo "<td>$rows02[nomor_doc]</td>";
		echo "<td>$rows02[supplier]</td>";
		// echo "<td>";
		// if (ambil_database(validasi,$nama_database,"id='$id'") != Valid) {
		// echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").'\')" href="'."$address&id=".base64_encrypt($id,"XblImpl1!A@")."&hapus_d=".base64_encrypt($rows02[id],"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
		// }
		// echo "</td>";
		echo "</tr>";}
echo "</table>";
//TABEL PENGIRIMAN END


//POP UP KODE BARANG START
//BUKA POPUP
if (ambil_database(validasi,$nama_database,"id='$id'") != Valid) {
echo "<table><tr>";
	echo "<td>";
	echo "<form method ='post' action='$address'>
	<input type='image' src='modules/gambar/tambah.png' width='30' height'30' name='kembali' value='kembali'>
	<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='opsi' value='$opsi'>
				<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='popup' value='popupbuka'></form>";
	echo "<td>";

	//REFERENSI SPK
	echo "<td>";
		echo " | ";
		echo '<a href="#" style="" onClick="window.open(\''."modules/admincls/po_marketing.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=350'.'\')">'."PO Marketing".'</a>';
	echo "</td>";
echo "</tr></table>";
}


//SAVE EDIT
if ($_POST['edit_item_save']) {

$id_po_item=$_POST['id_po'];
$po_nomor=ambil_database(po_nomor,sales_po,"id='$id_po_item'");
$line_batch=ambil_database(line_batch,sales_po,"id='$id_po_item'");
$departement_item=$_POST['departement'];
$id_kode_barang_item=$_POST['kode_barang'];
$kode_barang_item=ambil_database(kode,inventory_barang,"id='$id_kode_barang_item'");
$material_description_po_item=ambil_database(nama,inventory_barang,"id='$id_kode_barang_item'");
$satuan_item=ambil_database(satuan,inventory_barang,"id='$id_kode_barang_item'");
$qty_purchasing_item=$_POST['qty_purchasing'];
$price_rp_item=$_POST['price_rp']; $price_usd_item=$_POST['price_usd']; $price_nt_item=$_POST['price_nt'];
$amount_rp_item=$price_rp_item*$qty_purchasing_item; $amount_usd_item=$price_usd_item*$qty_purchasing_item; $amount_nt_item=$price_nt_item*$qty_purchasing_item;
$etd_item=$_POST['etd'];
$remark_item=$_POST['remark'];
$pcx_no_item=$_POST['pcx_no'];
$season_item=$_POST['season'];
$shoe_model_item=$_POST['shoe_model'];
$cauge_width_item=$_POST['cauge_width'];
$supplier_alocation_item=$_POST['supplier_alocation'];

mysql_query("UPDATE $nama_database_items SET
	id_po='$id_po_item',
	po_nomor='$po_nomor',
	line_batch='$line_batch',
	departement='$departement_item',
	kode_barang='$kode_barang_item',
	material_description_po='$material_description_po_item',
	satuan='$satuan_item',
	qty_purchasing='$qty_purchasing_item',
	price_usd='$price_usd_item',
	price_rp='$price_rp_item',
	price_nt='$price_nt_item',
	amount_usd='$amount_usd_item',
	amount_rp='$amount_rp_item',
	amount_nt='$amount_nt_item',
	etd='$etd_item',
	remark='$remark_item',
	pcx_no='$pcx_no_item',
	season='$season_item',
	shoe_model='$shoe_model_item',
	cauge_width='$cauge_width_item',
	supplier_alocation='$supplier_alocation_item' WHERE id='$_POST[edit_item_save]'");
}//SAVE EDIT END


//EDIT ITEM
if (base64_decrypt($_GET['edit_item'],"XblImpl1!A@")) {
	$id_items=base64_decrypt($_GET['edit_item'],"XblImpl1!A@");

	echo "<table class='tabel_utama' style=''>";
					echo "<form method='POST' action='$address'>";

					$no=0;for($i=0; $i < $nilai_kolom_input; ++$i){
					echo "<tr>";

					//HEADER
					$result1=mysql_query("SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$jumlah_kolom_input[$no]'");
					$rows1=mysql_fetch_array($result1);
					echo "<td id='kolom_isi_th'><strong>".$rows1[$bahasa]." </strong></td>";
					echo "<td>:</td>";
					//END HEADER

					//KOLOM DISABLED
					if ($jumlah_kolom_input[$no]=='jenis_mata_uang' OR $jumlah_kolom_input[$no]=='material_description_po' OR $jumlah_kolom_input[$no]=='satuan') {
						$disabled='disabled';}else{$disabled='';}

					//KOLOM TANGGAL
					if ($jumlah_kolom_input[$no]=='etd') {
						$format_tgl="class='date'";}else{$format_tgl='';}


					//BANTU HARGA
					if ($jumlah_kolom_input[$no]=='jenis_mata_uang'){
						if (ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")=='RP'){$kolom_mata_uang='price_rp';}
						elseif (ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")=='USD'){$kolom_mata_uang='price_usd';}
						else {$kolom_mata_uang='price_nt';}
					}else{}
					//BANTU HARGA END



					//HARGA
					if ($jumlah_kolom_input[$no]=='harga') {
							echo "<td><input type='text' $format_tgl name='$kolom_mata_uang' value='".ambil_database($kolom_mata_uang,$nama_database_items,"id='$id_items'")."' style='width:95%;' autocomplete='off' $disabled required></td>";
					}
					//SUPPLIER ALOCATION
					elseif ($jumlah_kolom_input[$no] == 'supplier_alocation'){
					$sql113="SELECT * FROM sales_perusahaan WHERE validasi='Valid' AND code='SUPPLIER' ORDER BY perusahaan";
					$result113=mysql_query($sql113);
					echo "<td>
					<select class='comboyuk' name='$jumlah_kolom_input[$no]'>
					<option value='".ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")."'>".ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")."</option>";
					while ($rows113=mysql_fetch_array($result113)) {
					echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";}
					echo "
					</select>
					</td>";
					}
					//ID PO
					elseif($jumlah_kolom_input[$no] == 'id_po') {
						$id_po_option=ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'");
						$sql3="SELECT * FROM sales_po WHERE validasi='Valid' ORDER BY po_nomor,line_batch";
						$result3=mysql_query($sql3);
						echo "<td>
						<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;'>
						<option value='$id_po_option'>".ambil_database(po_nomor,sales_po,"id='$id_po_option'")." - ".ambil_database(line_batch,sales_po,"id='$id_po_option'")." - ".ambil_database(dari,sales_po,"id='$id_po_option'")."</option>";
						while ($rows3=mysql_fetch_array($result3)) {
						echo "<option value='$rows3[id]'>".$rows3[po_nomor]." - ".$rows3[line_batch]." - ".$rows3[dari]."</option>";}
						echo "
						</select>
						</td>";
					}
					//SATUAN
					elseif($jumlah_kolom_input[$no] == 'departement') {
						if ($_GET['cari_kode']) {$readonly='disabled';}
						echo "<td>
						<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;' required $readonly>
						<option value='".ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")."'>".ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")."</option>";
						echo "<option value='CLS'>CLS</option>";
						echo "<option value='CL'>CL</option>";
						echo "<option value='SL'>SL</option>";
						echo "
						</select>
						</td>";
					}
					//kode BARANG
					elseif ($jumlah_kolom_input[$no] == 'kode_barang') {
						$sql113="SELECT * FROM inventory_barang WHERE validasi='Valid' AND departement='CLS' AND keterangan NOT IN ('BARANG JADI')";
						$result113=mysql_query($sql113);
						echo "<td style='width:50%;'>
						<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;'>
						<option value='".ambil_database(id,inventory_barang,"kode='".ambil_database(kode_barang,$nama_database_items,"id='$id_items'")."' AND nama='".ambil_database(material_description_po,$nama_database_items,"id='$id_items'")."'")."'>".ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")."</option>";
						while ($rows113=mysql_fetch_array($result113)) {
						echo "<option value='$rows113[id]'>$rows113[departement] / $rows113[beacukai_kode_barang] / $rows113[beacukai_nama_barang]</option>";}
						echo "</select>
						</td>";
					}
					//TAMPILAN SEBENARNYA
					else {
							echo "<td><input type='text' $format_tgl name='$jumlah_kolom_input[$no]' value='".ambil_database($jumlah_kolom_input[$no],$nama_database_items,"id='$id_items'")."' style='width:95%;' autocomplete='off' $disabled required></td>";
					}

					echo "</tr>";
					$no++;}

					echo"<tr><td colspan='3' style='background-color:$color; white-space:nowrap;'>
							<input type='image' src='modules/gambar/save.png' width='30' height'30' name='simpan' value='simpan'>
							<input type='hidden' name='halaman' value='$nomor_halaman'>
							<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
							<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
							<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
							<input type='hidden' name='pencarian' value='$pencarian'>
							<input type='hidden' name='opsi' value='$opsi'>
							<input type='hidden' name='edit_item_save' value='$id_items'>
							<input type='hidden' name='id' value='$id'>";
					echo "</form>";

					//TUTUP POPUP
					echo "<form method ='post' action='$address'>
							<input type='image' src='modules/gambar/back.png' width='30' height'30' name='kembali' value='kembali'>
							</td>
							<input type='hidden' name='halaman' value='$nomor_halaman'>
							<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
							<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
							<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
							<input type='hidden' name='pencarian' value='$pencarian'>
							<input type='hidden' name='opsi' value='$opsi'>
							<input type='hidden' name='id' value='$id'>
							</tr>";
						echo "</form>";


	echo "</table>";
}////EDIT ITEM END



if ($_POST[popup] == '') { $popup='popup'; } else { $popup=$_POST['popup']; }
if ($_GET[popup] != '') { $popup=base64_decrypt($_GET['popup'],"XblImpl1!A@");}
echo "<div class='$popup'>
    	<div class='window'>";

//Isian POP UP START
echo "<table class='tabel_utama' style='align:center; width:100%;'>";
//HEADER & ISI TABEL
echo "<form method='POST' action='$address'>";

$no=0;for($i=0; $i < $nilai_kolom_input; ++$i){
echo "<tr>";

//HEADER
$result1=mysql_query("SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$jumlah_kolom_input[$no]'");
$rows1=mysql_fetch_array($result1);
echo "<td id='kolom_isi_th'><strong>".$rows1[$bahasa]." </strong></td>";
//END HEADER

//KOLOM INPUT
//SATUAN
if($jumlah_kolom_input[$no] == 'etd') {$format_tgl="class='date' "; }else{$format_tgl="";}
//ID PO
if($jumlah_kolom_input[$no] == 'id_po') {
	$sql3="SELECT * FROM sales_po WHERE validasi='Valid' ORDER BY po_nomor,line_batch";
	$result3=mysql_query($sql3);
	echo "<td>
	<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;'>
	<option value=''></option>";
	while ($rows3=mysql_fetch_array($result3)) {
	echo "<option value='$rows3[id]'>".$rows3[po_nomor]." - ".$rows3[line_batch]." - ".$rows3[dari]."</option>";}
	echo "
	</select>
	</td>";
}
//ID MASTER KODE ITEM
elseif($jumlah_kolom_input[$no] == 'kode_barang') {

	if ($_GET['cari_kode']=='') {
	$id_kolom=$jumlah_kolom_input[$no];
	echo "<td>
		<div class='autocomplete' style='width:100%;'>
		  <input id='$id_kolom' type='text' name='$jumlah_kolom_input[$no]' value='".$rows5[$jumlah_kolom_input[$no]]."' style='width:95%; border-radius:4px; text-align:center;' autocomplete='off';>
		</div>
		</td>";
	$isian_autocomplete=ambil_variabel(warehouse_barang,internal_kode_barang);
	include 'function_autocomplete.php';

	echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
	echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='ambil_dari_kode_sebelumnya'").'\')" href="'."$address&id=".base64_encrypt($id,'XblImpl1!A@')."&opsi=".base64_encrypt('item','XblImpl1!A@')."&popup=".base64_encrypt('popupbuka','XblImpl1!A@')."&cari_kode=cari_kode&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/search.png" width="25px"/></a>';
	echo "</center></td>";}

	//AMBIL DARI KODE SEBELUMNYA
	if ($_GET['cari_kode']) {
		$sql113="SELECT * FROM inventory_barang WHERE validasi='Valid' AND departement='CLS' AND keterangan NOT IN ('BARANG JADI')";
		$result113=mysql_query($sql113);
		echo "<td style='width:50%;'>
		<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;'>
		<option value=''></option>";
		while ($rows113=mysql_fetch_array($result113)) {
		echo "<option value='$rows113[id]'>$rows113[departement] / $rows113[beacukai_kode_barang] / $rows113[beacukai_nama_barang]</option>";}
		echo "</select>
		<input type='hidden' name='otomatis_input' value='otomatis_input'>
		</td>";

		//TUTUP PANEL
		echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
		echo '<a href="'."$address&id=".base64_encrypt($id,'XblImpl1!A@')."&opsi=".base64_encrypt('item','XblImpl1!A@')."&popup=".base64_encrypt('popupbuka','XblImpl1!A@')."&cari_kode=&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/back.png" width="25px"/></a>';		echo "</center></td>";
		}
	//AMBIL DARI KODE SEBELUMNYA END
}
//ID MASTER NAMA ITEM
elseif($jumlah_kolom_input[$no] == 'material_description_po') {
	$id_kolom=$jumlah_kolom_input[$no];
		if ($_GET['cari_kode']) {$readonly='readonly';}
	echo "<td>
		<div class='autocomplete' style='width:100%;'>
			<input id='$id_kolom' type='text' name='$jumlah_kolom_input[$no]' value='".$rows5[$jumlah_kolom_input[$no]]."' style='width:95%; border-radius:4px; text-align:center;' autocomplete='off'; $readonly>
		</div>
		</td>";
	$isian_autocomplete=ambil_variabel(warehouse_barang,internal_nama_barang);
	include 'function_autocomplete.php';
}
//SUPPLIER ALOCATION
elseif ($jumlah_kolom_input[$no] == 'supplier_alocation'){
$sql113="SELECT * FROM sales_perusahaan WHERE validasi='Valid' AND code='SUPPLIER' ORDER BY perusahaan";
$result113=mysql_query($sql113);
echo "<td>
<select class='comboyuk' name='$jumlah_kolom_input[$no]'>
<option value=''></option>";
while ($rows113=mysql_fetch_array($result113)) {
echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";}
echo "
</select>
</td>";
}
//SATUAN
elseif($jumlah_kolom_input[$no] == 'satuan') {
	if ($_GET['cari_kode']) {$readonly='disabled';}
	$result113=mysql_query("SELECT * FROM referensi_satuan ORDER BY kode_satuan");
	echo "<td>
	<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;' required $readonly>
	<option value=''></option>";
 	while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[kode_satuan]'>$rows113[kode_satuan] - $rows113[uraian_satuan]</option>";}
	echo "
	</select>
	</td>";
}
//SATUAN
elseif($jumlah_kolom_input[$no] == 'departement') {
	if ($_GET['cari_kode']) {$readonly='disabled';}
	echo "<td>
	<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;' required $readonly>
	<option value=''></option>";
	echo "<option value='CLS'>CLS</option>";
	echo "<option value='CL'>CL</option>";
	echo "<option value='SL'>SL</option>";
	echo "
	</select>
	</td>";
}
//JENIS MATA UANG
elseif($jumlah_kolom_input[$no] == 'jenis_mata_uang') {

	echo "<td>
	<select class='comboyuk' name='$jumlah_kolom_input[$no]' style='width:96%;' required>";
			if (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='') {
				echo "<option value=''></option>";
				echo "<option value='RP'>RP</option>";
				echo "<option value='USD'>USD</option>";
				echo "<option value='NT'>NT</option>";
			}else {
				echo "<option value='".ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")."'>".ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")."</option>";
			}

	echo "
	</select>
	</td>";
}
//TAMPILAN SEBENARNYA
else{
	echo "<td><input type='text' name='$jumlah_kolom_input[$no]' value='' style='width:95%;' $format_tgl  autocomplete='off'  required></td>";
}
//KOLOM INPUT END
echo "<tr>";
$no++;}

//SIMPAN INPUTAN
echo "<tr>
<input type='image' src='modules/gambar/save.png' width='30' height'30' name='simpan' value='simpan'>
		<input type='hidden' name='halaman' value='$nomor_halaman'>
		<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		<input type='hidden' name='pencarian' value='$pencarian'>
		<input type='hidden' name='opsi' value='$opsi'>
		<input type='hidden' name='tambah' value='tambah'>
		<input type='hidden' name='id' value='$id'>";
echo "</form>";
//TUTUP POPUP
echo "<form method ='post' action='$address'>
<input type='image' src='modules/gambar/back.png' width='30' height'30' name='kembali' value='kembali'>
<input type='hidden' name='halaman' value='$nomor_halaman'>
		<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		<input type='hidden' name='pencarian' value='$pencarian'>
		<input type='hidden' name='opsi' value='$opsi'>
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='popup' value=''></form>
		</tr>";

echo "</form>";
//HEADER & ISI TABEL END

echo "</table>";
//Isian POP UP END
echo "</div></div>";
//POP UP KODE BARANG END


//START TABLE
echo "<table class='tabel_utama' style='width:100%;'>";
//HEADER TABEL
echo "<thead>";
echo "<th style=''><strong>No</strong></th>";
$no=0;for($i=0; $i < $nilai_column; ++$i){
	$result1=mysql_query("SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$jumlah_column[$no]'");
	$rows1=mysql_fetch_array($result1);
	echo "<th><strong>".$rows1[$bahasa]."</strong></th>";
$no++;}
echo "<th><strong>".ambil_database($bahasa,pusat_bahasa,"kode='Opsi'")."</strong></th>";
echo "<th>Foto</th>";
echo "<th>Tgl & QTY telah Diterima</th>";
echo "<th>Loss (%)</th>";
echo "</thead>";
//HEADER END

//ISI TABEL
$sql4=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
echo "<tr>";
$number=1;
while ($rows4=mysql_fetch_array($sql4)) {
	$warnaGenap="white";$warnaGanjil="#CEF6F5";if ($number % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}
	echo "<td style='background-color:$color;'>$number</td>";
	$no=0;for($i=0; $i < $nilai_column; ++$i){

		//Pembeda Format Kolom


		if($jumlah_column[$no]==price_usd OR $jumlah_column[$no]==amount_usd) {
			echo "<td style='background-color:$color;'>".dollar($rows4[$jumlah_column[$no]])."</td>";
		}elseif($jumlah_column[$no]==price_rp OR $jumlah_column[$no]==amount_rp) {
			echo "<td style='background-color:$color;'>".rupiah($rows4[$jumlah_column[$no]])."</td>";
		}elseif($jumlah_column[$no]==price_nt OR $jumlah_column[$no]==amount_nt) {
			echo "<td style='background-color:$color;'>".dollar_nt($rows4[$jumlah_column[$no]])."</td>";
		}
		//HARGA
		elseif($jumlah_column[$no]==harga) {

			if ($rows4[jenis_mata_uang]=='RP') {
				echo "<td style='background-color:$color;'>".rupiah($rows4[price_rp])."</td>";
			}elseif($rows4[jenis_mata_uang]=='USD') {
				echo "<td style='background-color:$color;'>".dollar($rows4[price_usd])."</td>";
			}elseif ($rows4[jenis_mata_uang]=='NT') {
				echo "<td style='background-color:$color;'>".dollar_nt($rows4[price_nt])."</td>";
			}else{}
		}
		//TOTAL HARGA
		elseif($jumlah_column[$no]==total_harga) {
			if ($rows4[jenis_mata_uang]=='RP') {
				echo "<td style='background-color:$color;'>".rupiah($rows4[amount_rp])."</td>";
			}elseif($rows4[jenis_mata_uang]=='USD') {
				echo "<td style='background-color:$color;'>".dollar($rows4[amount_usd])."</td>";
			}elseif ($rows4[jenis_mata_uang]=='NT') {
				echo "<td style='background-color:$color;'>".dollar_nt($rows4[amount_nt])."</td>";
			}else{}
		}
		else{
			echo "<td style='background-color:$color;'>".$rows4[$jumlah_column[$no]]."</td>";
		}

$no++;}

$grand_price_usd=$rows4['price_usd']+$grand_price_usd;//DOLLAR
$grand_amount_usd=$rows4['amount_usd']+$grand_amount_usd;//DOLLAR
$grand_price_rp=$rows4['price_rp']+$grand_price_rp;//RP
$grand_amount_rp=$rows4['amount_rp']+$grand_amount_rp;//RP
$grand_price_nt=$rows4['price_nt']+$grand_price_rp;//NT
$grand_amount_nt=$rows4['amount_nt']+$grand_amount_nt;//NT
$grand_qty_spk=$rows4['qty_purchasing']+$grand_qty_spk;

if (ambil_database(validasi,$nama_database,"id='$id'") != Valid) {
echo "<td style='background-color:$color; white-space:nowrap;'><center>";

//DELETE
echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").'\')" href="'."$address&id=".base64_encrypt($id,"XblImpl1!A@")."&hapus=".base64_encrypt($rows4[id],"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="20px"/></a>';

//EDIT
echo '<a onclick="return confirm(\''."Edit item ini?".'\')" href="'."$address&id=".base64_encrypt($id,"XblImpl1!A@")."&edit_item=".base64_encrypt($rows4[id],"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/edit.png" width="20px"/></a>';
echo "</center></td>";
}else {
	echo "<td></td>";
}

//FOTO
echo "<td>";
$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='$rows4[kode_barang]' AND satuan='$rows4[satuan]'");//AND nama='$rows4[material_description_po]'
$id_foto=ambil_database(id,inventory_barang,"foto='$nama_gambar_tampilan'");
//echo "<a href='modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan' target='_blank'><img src='modules/warehouse/gambarproduk/$nama_gambar_tampilan' width='80px' height='100px'/></a>";
echo '<a href="#" onClick="window.open(\''."modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan&id=$id_foto&nama_database=inventory_barang".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='modules/warehouse/gambarproduk/$nama_gambar_tampilan' width='80' height='100'/>".'</a>';
echo "</td>";
//FOTO END

//TOTAL MASUK PER DOKUMEN
	$result15=mysql_query("SELECT SUM(qty) as tqty FROM admin_purchasing_dokumen_masuk WHERE induk='$id' AND kodebarang='$rows4[kode_barang]'");
	$rows15=mysql_fetch_array($result15);
	$total_masuk=$rows15[tqty]+$total_masuk;
echo "<td style='text-align:left; padding-left:10px; white-space:nowrap;'>";
	$result16=mysql_query("SELECT * FROM admin_purchasing_dokumen_masuk WHERE induk='$id' AND kodebarang='$rows4[kode_barang]'");
	while ($rows16=mysql_fetch_array($result16)) {
		echo "$rows16[tanggal_doc] : $rows16[qty]</br>";}
echo "</td>";
//TOTAL MASUK PER DOKUMEN

echo "<td>$rows4[loss]</td>";
echo "</tr>";
$number++;}//ISI TABEL END

//warna sama nilai QTY
if ($grand_qty_spk==$total_masuk) {
	$color_n='#00FFFF';
}else {
	$color_n='#FF6347';
}

//GRAND TOTAL
echo "<tr>";
echo "<td colspan='8' style='font-size:12px;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='total'")."</strong></td>";
echo "<td style='font-size:12px; background-color:$color_n;'><strong>$grand_qty_spk</strong></td>";
echo "<td style='font-size:12px;'><strong></strong></td>";//".dollar($grand_price_usd).

if (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='RP') {
	echo "<td style='font-size:12px;'><strong>".rupiah($grand_amount_rp)."</strong></td>";
}elseif (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='USD') {
	echo "<td style='font-size:12px;'><strong>".dollar($grand_amount_usd)."</strong></td>";
}elseif (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='NT') {
	echo "<td style='font-size:12px;'><strong>".dollar_nt($grand_amount_nt)."</strong></td>";
}else {
	echo "<td></td>";
}

echo "<td style='font-size:12px;'><strong></strong></td>";//".rupiah($grand_price_rp)."
echo "<td colspan='7'></td>";
echo "<td style='font-size:12px; background-color:$color_n;'><strong>$total_masuk</strong></td>";
echo "</tr>";
//GRAND TOTAL END


//Diskon
$jmlh_diskon=ambil_database(discount,$nama_database,"id='$id'");
$grand_amount_usd_diskon=$grand_amount_usd*$jmlh_diskon/100;
$grand_amount_rp_diskon=$grand_amount_rp*$jmlh_diskon/100;
$grand_amount_nt_diskon=$grand_amount_nt*$jmlh_diskon/100;

echo "<tr>";
echo "<td colspan='8' style='font-size:12px;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='discount'")."</strong></td>";
echo "<td style='font-size:12px;'><strong>".$jmlh_diskon."%</strong></td>";
echo "<td style='font-size:12px;'><strong></strong></td>";//".dollar($grand_price_usd)."

if (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='RP') {
	echo "<td style='font-size:12px;'><strong>".rupiah($grand_amount_rp_diskon)."</strong></td>";
}elseif (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='USD') {
	echo "<td style='font-size:12px;'><strong>".dollar($grand_amount_usd_diskon)."</strong></td>";
}elseif (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='NT') {
	echo "<td style='font-size:12px;'><strong>".dollar_nt($grand_amount_nt_diskon)."</strong></td>";
}else {
	echo "<td></td>";
}

echo "<td style='font-size:12px;'><strong></strong></td>";//".rupiah($grand_price_rp)."
echo "<td colspan='8'></td>";
echo "</tr>";
//Diskon END

//Total Setelah Diskon
echo "<tr>";
echo "<td colspan='8' style='font-size:12px;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='total'")."</strong></td>";
echo "<td style='font-size:12px;'><strong></strong></td>";
echo "<td style='font-size:12px;'><strong></strong></td>";//".dollar($grand_price_usd)."

if (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='RP') {
	echo "<td style='font-size:12px; white-space:nowrap;'><strong>".rupiah($grand_amount_rp-$grand_amount_rp_diskon)."</strong></td>";
}elseif (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='USD') {
	echo "<td style='font-size:12px; white-space:nowrap;'><strong>".dollar($grand_amount_usd-$grand_amount_usd_diskon)."</strong></td>";
}elseif (ambil_database(jenis_mata_uang,$nama_database_items,"induk='$id'")=='NT') {
	echo "<td style='font-size:12px; white-space:nowrap;'><strong>".dollar_nt($grand_amount_nt-$grand_amount_nt_diskon)."</strong></td>";
}else {
	echo "<td></td>";
}

echo "<td style='font-size:12px;'><strong></strong></td>";//".rupiah($grand_price_rp)."
echo "<td colspan='8'></td>";
echo "</tr>";
//Total Setelah Diskon END


echo "</table>";
//END TABLE



}//END ITEM
else{// TAMPILAN UTAMA
//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA
}//TAMPILAN UTAMA

}//END HOME
//END PHP?>
