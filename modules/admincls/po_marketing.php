<?php
session_start();
ob_start();
error_reporting(0);
include('../../../koneksi.php');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);

//KONEKSI DATABASE
function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function kalender(){
		echo "
		<link rel='stylesheet' href='../tools/kalender_combo/jquery-ui.css'>
		<link rel='stylesheet' href='/resources/demos/style.css'>
		<script src='../tools/kalender_combo/jquery-1.12.4.js'></script>
		<script src='../tools/kalender_combo/jquery-ui.js'></script>

		<script>
		$( function() {
			$( '.date' ).datepicker({
				dateFormat: 'yy-mm-dd'
			});
		} );
		</script>
		</head>
		<body>";
		//<label >Date:</label>
		//<input type='text' id='date'>
return;}

function combobox(){
	echo "
	 <link href='../tools/kalender_combo/select2.min.css' rel='stylesheet' />
	 <script src='../tools/kalender_combo/select2.min.js'></script>

	<script type='text/javascript'>
	 $(document).ready(function() {
	     $('.comboyuk').select2();
	 });
	</script>";
return;}

function base64_decrypt($enc_text, $password, $iv_len = 16)
{
$enc_text = str_replace('@', '+', $enc_text);
$enc_text = base64_decode($enc_text);
$n = strlen($enc_text);
$i = $iv_len;
$plain_text = '';
$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
while ($i < $n) {
$block = substr($enc_text, $i, 16);
$plain_text .= $block ^ pack('H*', md5($iv));
$iv = substr($block . $iv, 0, 512) ^ $password;
$i += 16;
}
return preg_replace('/\\x13\\x00*$/', '', $plain_text);
}


function tamount_spk($induk,$jenis_bb,$kode){
	if ($jenis_bb=='LOGO' OR $jenis_bb=='SOCKLINER') {
		$amount=ambil_database(qty_po,sales_po,"id='$induk'");
	}elseif($jenis_bb=='FOAM' OR $jenis_bb=='KAIN') {
		$id_sales_po=$induk;
		$id_yield=ambil_database(id_yield,sales_po,"id='$induk'");
		$id_items=$induk;
		$textile=ambil_database(textile,sales_po,"id='$id_sales_po'");
		$foam=ambil_database(foam,sales_po,"id='$id_sales_po'");
		//NILAI SIZE DAN COUNT
		$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
		$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
		$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
		$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
		$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
		$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
		//TOTAL NILAI SUM
		$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
		$nilai=ambil_database($pecah1[$no],sales_po_items,"induk='$id_items' AND logo='logo1'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='$id_yield' AND size='".$pecah1[$no]."'");
		$nilai1=substr($nilai, 0,4); $total_nilai1=$nilai1+$total_nilai1;
		$no++;}
		$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
		$nilai=ambil_database($pecah2[$no],sales_po_items,"induk='$id_items' AND logo='logo2'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='$id_yield' AND size='".$pecah2[$no]."'");
		$nilai2=substr($nilai, 0,4); $total_nilai2=$nilai2+$total_nilai2;
		$no++;}
		$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
		$nilai=ambil_database($pecah3[$no],sales_po_items,"induk='$id_items' AND logo='logo3'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='$id_yield' AND size='".$pecah3[$no]."'");
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
	if ($yard==''){$amount=$sheet;}else{$amount=$yard;}
	}


return $amount;}
?>

<?php
include 'style.css';
echo kalender();
echo combobox();
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$id_spk=$_POST['id_spk'];
$jenis_bb=$_POST['jenis_bb'];



//UPDATE YIELD
$id_yield_dipilih=$_POST['id_yield_dipilih'];
if ($id_yield_dipilih) {
	   mysql_query("UPDATE sales_po SET id_yield='$id_yield_dipilih' WHERE id='$id_spk'");
}


//UPDATE SELESAI ARRAY DARI FINISH
$qty_post=$_POST['qty'];
$id_item_post=$_POST['id_item'];
$jenis_mata_uang_post=$_POST['jenis_mata_uang'];
$price_post=$_POST['price'];
$etd_post=$_POST['etd'];
$remark_post=$_POST['remark'];
$pcx_no_post=$_POST['pcx_no'];
$season_post=$_POST['season'];
$shoe_model_post=$_POST['shoe_model'];
$cauge_width_post=$_POST['cauge_width'];
$supplier_alocation_post=$_POST['supplier_alocation'];
$loss_post=$_POST['loss'];

if ($qty_post) {
$no=0;for($i=0; $i < count($_POST['qty']); ++$i){

	$id_item=$id_item_post[$no];
	$jenis_mata_uang=$jenis_mata_uang_post[$no];
	$price=$price_post[$no];
	$etd=$etd_post[$no];
	$remark=$remark_post[$no];
	$pcx_no=$pcx_no_post[$no];
	$season=$season_post[$no];
	$shoe_model=$shoe_model_post[$no];
	$cauge_width=$cauge_width_post[$no];
	$supplier_alocation=$supplier_alocation_post[$no];
	$loss=$loss_post[$no];
	$loss_rumus=$qty_post[$no]*$loss_post[$no]/100;
	$qty_purchasing=$qty_post[$no]+$loss_rumus;

	if ($jenis_mata_uang=='RP'){$price_rp=$price_post[$no]; $amount_rp=$price_post[$no]*$qty_purchasing;}else{$price_rp=''; $amount_rp='';}
	if ($jenis_mata_uang=='USD'){$price_usd=$price_post[$no]; $amount_usd=$price_post[$no]*$qty_purchasing;}else{$price_usd=''; $amount_usd='';}
	if ($jenis_mata_uang=='NT'){$price_nt=$price_post[$no]; $amount_nt=$price_post[$no]*$qty_purchasing;}else{$price_nt=''; $amount_nt='';}


if ($qty_purchasing>0) {

$po_nomor=ambil_database(po_nomor,sales_po,"id='$id_spk'");
$line_batch=ambil_database(line_batch,sales_po,"id='$id_spk'");
$kode_barang=ambil_database(kode,inventory_lokasi_items,"id='$id_item'");
$nama_barang=ambil_database(nama,inventory_lokasi_items,"id='$id_item'");
$material_description_po=ambil_database(material_description_po,sales_po,"id='$id_spk'");
$satuan=ambil_database(satuan,inventory_lokasi_items,"id='$id_item'");

$insert_otomatis=mysql_query("INSERT INTO admin_purchasing_items SET
induk='$id',
id_po='$id_spk',
po_nomor='$po_nomor',
line_batch='$line_batch',
departement='CLS',
kode_barang='$kode_barang',
material_description_po='$nama_barang',
qty_purchasing='$qty_purchasing',
satuan='$satuan',
jenis_mata_uang='$jenis_mata_uang',
price_usd='$price_usd',
price_rp='$price_rp',
price_nt='$price_nt',
amount_usd='$amount_usd',
amount_rp='$amount_rp',
amount_nt='$amount_nt',
etd='$etd',
remark='$remark',
pcx_no='$pcx_no',
season='$season',
shoe_model='$shoe_model',
cauge_width='$cauge_width',
supplier_alocation='$supplier_alocation',
loss='$loss'");
}
$no++;}

//echo "<script type='text/javascript'>window.close();</script>";
}//UPDATE SELESAI ARRAY DARI FINISH END


//TITLE
echo "<html>
<meta charset='UTF-8'>
<head><title>Data PO Marketing</title></head>
<body>";
//END TITLE


//PILIH SPK LAMINATING
echo "<form method='post'>";
echo "<table>";
	echo "<tr>";
		echo "<td>PO Nomor :</td>";
		$sql="SELECT * FROM sales_po WHERE status NOT LIKE 'Selesai' ORDER BY tanggal desc";//WHERE status LIKE 'Selesai'
		$result=mysql_query($sql);
		echo "<td>
		<select class='comboyuk' name='id_spk' style='width:250px;'>
		<option value='$id_spk'>".ambil_database(tanggal,sales_po,"id='$id_spk'")." | ".ambil_database(po_nomor,sales_po,"id='$id_spk'")." | ".ambil_database(line_batch,sales_po,"id='$id_spk'")."</option>";
		while ($rows=mysql_fetch_array($result)) {
		echo "<option value='$rows[id]'>$rows[tanggal] | $rows[po_nomor] | $rows[line_batch]</option>";}
		echo "
		</select>
		</td>";


		echo "<td>
		<select class='comboyuk' name='jenis_bb' style='width:80px;'>
		<option value='$jenis_bb'>$jenis_bb</option>";
		echo "<option value='KAIN'>KAIN</option>";
		echo "<option value='FOAM'>FOAM</option>";
		echo "<option value='LOGO'>LOGO</option>";
		echo "<option value='LEM'>LEM</option>";
		echo "
		</select>
		</td>";
		echo "<td><input type='submit' name='submit' value='Show'></td>";
	echo "</tr>";
echo "</table>";
echo "</form>";
//PILIH SPK LAMINATING END


if ($id_spk!='') {

echo "<table style='margin-bottom:30px;'>";
	echo "<tr>";
		echo "<td>YIELD</td>";
		echo "<td>:</td>";

		echo "<form method='POST' action='#'>";
		  echo "<td>
		  <select class='comboyuk' name='id_yield_dipilih'>
		  <option value='".ambil_database(id_yield,sales_po,"id='$id_spk'")."'>".ambil_database(yield,sales_mastermodel,"id='".ambil_database(id_yield,sales_po,"id='$id_spk'")."'")."</option>";
		  $result113=mysql_query("SELECT * FROM sales_mastermodel");
		  while ($rows113=mysql_fetch_array($result113)) {
		  echo "<option value='$rows113[id]'>$rows113[yield]</option>";}
		  echo "
		  </select>
		  </td>";

			echo "<input type='hidden' name='id_spk' value='$id_spk'>";
			echo "<input type='hidden' name='jenis_bb' value='$jenis_bb'>";
			echo "<td><input type='image' src='../../modules/gambar/save.png' width='30' height'30' name='simpan' value='Simpan'></td>";
		echo "</form>";

	echo "</tr>";
echo "</table>";}



//CARI OTOMATIS KODE BARANG
$result2=mysql_query("SELECT * FROM sales_po WHERE id='$id_spk'");
$rows2=mysql_fetch_array($result2);
$textile[]="'".$rows2[textile]."'";
$foam[]="'".$rows2[foam]."'";
$lem[]="'".$rows2[lem]."'";
$logo1[]="'".$rows2[logo1]."'";
$logo2[]="'".$rows2[logo2]."'";
$logo3[]="'".$rows2[logo3]."'";
$style_item_kode[]="'".ambil_database(kode,inventory_lokasi_items,"beacukai_kode_barang='$rows2[style_item_kode]'")."'";


$data_textile=implode(',',array_unique(explode(',', implode(",", $textile))));
$data_foam=implode(',',array_unique(explode(',', implode(",", $foam))));
$data_lem=implode(',',array_unique(explode(',', implode(",", $lem))));
$data_logo1=implode(',',array_unique(explode(',', implode(",", $logo1))));
$data_logo2=implode(',',array_unique(explode(',', implode(",", $logo2))));
$data_logo3=implode(',',array_unique(explode(',', implode(",", $logo3))));
$data_style_item_kode=implode(',',array_unique(explode(',', implode(",", $style_item_kode))));

$hasil_pencarian="$data_textile,$data_foam,$data_lem,$data_logo1,$data_logo2,$data_logo3,$data_style_item_kode";//$data_textile,$data_foam,$data_logo1,$data_logo2,$data_logo3,$data_style_item_kode
//CARI OTOMATIS KODE BARANG END

if ($id_spk) {
//ISI TABEL
echo "<table class='tabel_utama' style='width:auto;'>";
	echo "<thead>";
		echo "<th>NO</th>";
		echo "<th>KODE COSTOMER / BEACUKAI</th>";
		echo "<th>KODE</th>";
		echo "<th>KATEGORI</th>";
		echo "<th>NAMA</th>";
		echo "<th>SATUAN</th>";
		echo "<th>SISA STOK</th>";
		echo "<th>KET</th>";
		echo "<th>QTY</th>";
		//echo "<th>DESCRIPTION</th>";
		echo "<th>MATA UANG</th>";
		echo "<th>HARGA</th>";
		echo "<th>ETD</th>";
		echo "<th>REMARK</th>";
		echo "<th>PCX NO</th>";
		echo "<th>SEASON</th>";
		echo "<th>SHOE MODEL</th>";
		echo "<th>CAUGE / WIDTH</th>";
		echo "<th>SUPPLIER ALOCATION</th>";
		echo "<th>LOSS %</th>";
	echo "</thead>";

echo "<form method='POST' action='#'>";
//FOAM','KAIN','LOGO','LEM
	$result3=mysql_query("SELECT * FROM inventory_lokasi_items WHERE kode IN ($hasil_pencarian) AND kode NOT LIKE '' AND kategori IN ('$jenis_bb') AND lokasi NOT LIKE '28' ORDER BY kategori");
	$urut1=1;
	while ($rows3=mysql_fetch_array($result3)) {
		echo "<tr>";
			echo "<td>$urut1</td>";
			echo "<td>$rows3[beacukai_kode_barang]</td>";
			echo "<td>$rows3[kode]</td>";
			echo "<td>$rows3[kategori]</td>";
			echo "<td>$rows3[nama]</td>";
			echo "<td>$rows3[satuan]</td>";
			echo "<td>$rows3[banyak]</td>";
			echo "<td>$rows3[keterangan]</td>";

			//QTY
			$tamount=tamount_spk($id_spk,$rows3[kategori],$rows3[kode]);
			echo "<td style='background-color:yellow;'><input type='text' style='width:100px; text-align:right;' name='qty[]' value='$tamount' readonly></td>";

			//echo "<td>".ambil_database(material_description_po,sales_po,"id='$id_spk'")."</td>";

			//JENIS MATA UANG
			echo "<td>
			<select class='comboyuk' name='jenis_mata_uang[]' style='width:50px;' required>";
						echo "<option value=''></option>";
						echo "<option value='RP'>RP</option>";
						echo "<option value='USD'>USD</option>";
						echo "<option value='NT'>NT</option>";
			echo "</select></td>";

			//harga
			echo "<td><input type='text' name='price[]' value='' style='width:90px;' required></td>";

			//etd
			echo "<td><input type='text' name='etd[]' value='' class='date' style='width:80px;' required></td>";

			//remark
			echo "<td><input type='text' name='remark[]' value='' style='width:90px;'></td>";

			//pcx no
			echo "<td><input type='text' name='pcx_no[]' value='".ambil_database(pcx_no,inventory_barang,"kode='$rows3[kode]'")."'  style='width:50px;' readonly></td>";

			//season
			echo "<td><input type='text' name='season[]' value='".ambil_database(season,sales_po,"id='$id_spk'")."' style='width:50px;'  readonly></td>";

			//shoe model
			echo "<td><input type='text' name='shoe_model[]' value='".ambil_database(model,sales_masterstyle,"id='".ambil_database(id_style_item_kode,sales_po,"id='$id_spk'")."'")."' style='width:70px;' readonly></td>";

			//cauge width
			echo "<td><input type='text' name='cauge_width[]' value='' style='width:70px;'></td>";

			//supplier ALOCATION
			$sql113="SELECT * FROM sales_perusahaan WHERE validasi='Valid' AND code='SUPPLIER' ORDER BY perusahaan";
			$result113=mysql_query($sql113);
			echo "<td>
			<select class='comboyuk' name='supplier_alocation[]' style='width:180px;'>
			<option value=''></option>";
			while ($rows113=mysql_fetch_array($result113)) {
			echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";}
			echo "
			</select>
			</td>";

			//LOSS PERSEN
			echo "<td><input type='number' name='loss[]' value='' style='width:45px;'></td>";

		echo "</tr>";

		echo "<input type='hidden' name='id_item[]' value='$rows3[id]'>";
	$urut1++;}

	echo "<input type='hidden' name='id_spk' value='$id_spk'>";
	echo "<input type='hidden' name='jenis_bb' value='$jenis_bb'>";
	echo "<tr>";
	echo "<td colspan='19'><input type='image' src='../gambar/tambah.png' width='30' height'30' name='simpan' value='Simpan'></td>";
	echo "</tr>";

echo "</table>";
}//ISI TABEL END


//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END
?>
