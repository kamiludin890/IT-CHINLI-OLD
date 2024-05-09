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

function ambil_variabel_tanpa_kutip_where_distinct($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT DISTINCT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode(",", $datasecs);
	$hasil="".$data."";
return $hasil;}

function qty_proses_per_size($po_nomor,$line_batch,$nama_kolom,$logo){
	$result=mysql_query("SELECT qty FROM deliverycl_invoice_items WHERE po_nomor='$po_nomor' AND line_batch='$line_batch' AND logo='$logo' AND size='$nama_kolom'");
	while ($rows=mysql_fetch_array($result)){
		$qty_telah_sent=$rows[qty]+$qty_telah_sent;
	}
	//$ambil_variabel_size1=ambil_variabel_tanpa_kutip_where_distinct(planningcls_spklaminating_qty_proces,induk,"WHERE po_nomor='$po_nomor_qty_proces' AND line_batch='$line_batch_qty_proces' ORDER BY induk");
	//$pecah_size1=pecah($ambil_variabel_size1);
	//$nilai_pecah_size1=nilai_pecah($ambil_variabel_size1);
	//$no_size1=0;for($i_size1=0; $i_size1 < $nilai_pecah_size1; ++$i_size1){
	//$nilai_qty_size1=ambil_database($nama_kolom,planningcls_spklaminating_qty_proces,"induk='$pecah_size1[$no_size1]' AND logo='$logo'")+$nilai_qty_size1;
	//$no_size1++;}
return $qty_telah_sent;}

function tamount_bayar($nomor_aju,$jenis_doc){
	$result5=mysql_query("SELECT bayar FROM akuntansiv3_posting WHERE nomor_aju='$nomor_aju' AND jenis_doc='$jenis_doc' AND pencatatan NOT LIKE 'ya'");
	while ($rows5=mysql_fetch_array($result5)) {
		$tamount=$rows5[bayar]+$tamount;

	}
return $tamount;}

function tamount_ppn($nomor_aju,$jenis_doc){
	$result5=mysql_query("SELECT ppn FROM akuntansiv3_posting WHERE nomor_aju='$nomor_aju' AND jenis_doc='$jenis_doc'");
	while ($rows5=mysql_fetch_array($result5)) {
		$tamount=$rows5[ppn]+$tamount;

	}
return $tamount;}

function buat_list_checkbox($list_akses,$jumlah_list_akses){
		$no=0;for($i=0; $i < $jumlah_list_akses; ++$i){
			$datasecs[]="".$list_akses[$no]."";
		$no++;}
			$data=implode(",", $datasecs);
return $data;}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
return $hasil_rupiah;}
?>

<?php
include 'style.css';
echo kalender();
echo combobox();
$bahasa=ina;
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");

//TITLE
echo "<html>
<meta charset='UTF-8'>
<head><title>Dokumen BC</title></head>
<body>";
//END TITLE

$column_header='nomor_aju,nomorinvoiceacc,jenis_doc,nomor_doc,tanggal_doc,nomorsuratjalanacc,kontak,harga_penyerahan';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);

//CARI POST
$pencarian=$_POST['pencarian'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];
$pilihan_bulan=$_POST['pilihan_bulan'];
$pilihan_tahun=$_POST['pilihan_tahun'];
$nomor_halaman=$_POST['halaman'];


//UPDATE CHECK BOX
if ($_POST['save_list']) {

//ISIAN KOLOM DARI HEADER
$tanggal=ambil_database(tanggal,akuntansiv3_posting_master,"id='$id'");
$kode=ambil_database(kode,akuntansiv3_posting_master,"id='$id'");
$keterangan=ambil_database(keterangan,akuntansiv3_posting_master,"id='$id'");
$id_persamaan=ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'");
$persamaan=ambil_database(keterangan,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
$debit=ambil_database(debit,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
$kredit=ambil_database(kredit,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
$kredit_kedua=ambil_database(kredit_kedua,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
$pembuat=ambil_database(pembuat,akuntansiv3_posting_master,"id='$id'");
$keterangan_debit=ambil_database(nama,akuntansiv3_akun,"nomor='$debit'");
$keterangan_kredit=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit'");
$keterangan_kredit_kedua=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit_kedua'");
$kode_keterangan_debit="$debit - $keterangan_debit";
$kode_keterangan_kredit="$kredit - $keterangan_kredit";
$kode_keterangan_kredit_kedua="$kredit_kedua - $keterangan_kredit_kedua";
$jenis_kas=ambil_database(jenis_kas,akuntansiv3_posting_master,"id='$id'");
$tanggal_input=ambil_database(tgl_dibuat,akuntansiv3_posting_master,"id='$id'");
$kurs=ambil_database(kurs,financecl_kurs,"tanggal='$tanggal'");
//ISIAN KOLOM DARI HEADER END

$list_pilihan=buat_list_checkbox($_POST['id_terpilih'],count($_POST['id_terpilih']));
$nilai_column_id=count($_POST['id_terpilih']);
$jumlah_column_id=pecah($list_pilihan);

$urut=0;for($i=0; $i < $nilai_column_id; ++$i){

//ISIAN KOLOM DARI ISIAN
$id_terpilih=$jumlah_column_id[$urut];
$tgl_id=date("Y-m-d h:i:sa");$ref_jurnal=preg_replace('/\D/', '', $tgl_id)."$urut";
$id_jurnal=$ref_jurnal;
$ref=$ref_jurnal;
$jenis_doc=ambil_database(jenis_doc,inventory_distribusi,"id='$id_terpilih'");
$kontak=ambil_database(kontak,inventory_distribusi,"id='$id_terpilih'");
$tanggal_doc=ambil_database(tanggal_doc,inventory_distribusi,"id='$id_terpilih'");
$nomor_aju=ambil_database(nomor_aju,inventory_distribusi,"id='$id_terpilih'");
	if (ambil_database(nomor_faktur,inventory_distribusi,"id='$id_terpilih'")){
		$invoice_faktur=ambil_database(nomor_faktur,inventory_distribusi,"id='$id_terpilih'");
	}elseif (ambil_database(nomorinvoiceacc,inventory_distribusi,"id='$id_terpilih'")) {
		$invoice_faktur=ambil_database(nomorinvoiceacc,inventory_distribusi,"id='$id_terpilih'");
	}else {
		$invoice_faktur='';
	}

	$nilai_sudah_dibayarkan=tamount_bayar($nomor_aju,$jenis_doc);
	$nominal_debit=ambil_database(harga_penyerahan,inventory_distribusi,"id='$id_terpilih'")-$nilai_sudah_dibayarkan;
	$nominal_kredit=ambil_database(harga_penyerahan,inventory_distribusi,"id='$id_terpilih'")-$nilai_sudah_dibayarkan;
	$nominal_kredit_kedua='';

	$bayar=$nominal_debit;
////ISIAN KOLOM DARI ISIAN END

//INSERT INTO
mysql_query("INSERT INTO akuntansiv3_posting SET
	induk='$id',
	kode='$kode',
	tanggal='$tanggal',
	keterangan='$keterangan',
	id_persamaan='$id_persamaan',
	persamaan='$persamaan',
	debit='$debit',
	kredit='$kredit',
	kredit_kedua='$kredit_kedua',
	pembuat='$pembuat',
	kode_keterangan_debit='$kode_keterangan_debit',
	kode_keterangan_kredit='$kode_keterangan_kredit',
	kode_keterangan_kredit_kedua='$kode_keterangan_kredit_kedua',
	keterangan_debit='$keterangan_debit',
	keterangan_kredit='$keterangan_kredit',
	keterangan_kredit_kedua='$keterangan_kredit_kedua',
	jenis_kas='$jenis_kas',
	tanggal_input='$tanggal_input',
	id_jurnal='$id_jurnal',
	ref='$ref',
	jenis_doc='$jenis_doc',
	kontak='$kontak',
	tanggal_doc='$tanggal_doc',
	id_inventory_distribusi='$id_terpilih',
	nomor_aju='$nomor_aju',
	invoice_faktur='$invoice_faktur',
	kurs='$kurs',
	nominal_debit='$nominal_debit',
	nominal_kredit='$nominal_kredit',
	nominal_kredit_kedua='$nominal_kredit_kedua',
	bayar='$bayar'");
//INSERT INTO END

$urut++;}//END

echo "<script type='text/javascript'>window.close();</script>";
}//UPDATE CHECK BOX END



//PENCARIAN
echo "<form method='POST'>";
echo "<table>";
echo "<tr>";
echo "
<td>".ambil_database($bahasa,master_bahasa,"kode='pencarian'")."</td>
<td>:</td>
<td><input type='text' name='pencarian' value='$pencarian'></td>
<td><select name='pilihan_pencarian'>";
	$sql1="SELECT $bahasa,kode FROM master_bahasa WHERE kode='$pilihan_pencarian'";
	$result1=mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);
	echo "<option value='$rows1[kode]'>".$rows1[$bahasa]."</option>";
$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
	$sql2="SELECT $bahasa FROM master_bahasa WHERE kode='$pecah_column_header[$no]'";
	$result2=mysql_query($sql2);
	$rows2=mysql_fetch_array($result2);
	echo "<option value='$pecah_column_header[$no]'>".$rows2[$bahasa]."</option>";
$no++;}
echo "
</select>
</td>";

echo "
<td>".ambil_database($bahasa,master_bahasa,"kode='bulan'")."</td>
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
<td>".ambil_database($bahasa,master_bahasa,"kode='tahun'")."</td>
<td>:</td>";
echo "
<td><select name='pilihan_tahun'>";
echo "<option value='$pilihan_tahun'>$pilihan_tahun</option>";
$now=date('Y')+3;
for ($a=date('Y')-3;$a<=$now;$a++)
 {echo "<option value='".$a."'>".$a."</option>";}
 echo "</select></td>";

echo "<td><input type='submit' name='submit' value='Show'></td>";
echo "</tr>";
echo "</table>";
echo "</form>";
//PENCARIAN END


//TABEL
echo "<table><tr>";
echo "<form method='POST' action='$address'>";
echo "<td>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='save_list' value='1'></td>";
echo "</tr></table>";
//DOWNLOAD EXCEL END


echo "<table class='tabel_utama' style='width:auto;'>";
	//HEADER TABEL
	echo "<thead>";
		echo "<th style=''><strong>No</strong></th>";
	$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
		$sql3="SELECT $bahasa,kode FROM master_bahasa WHERE kode='$pecah_column_header[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);
		echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
	$no++;}
		echo "<th>Total Dibayar / Diterima</th>";
		echo "<th>Sisa</th>";
		echo "<th>Total PPN</th>";
		echo "<th><input type='image' src='../../modules/gambar/tambah.png' width='25' height'25' name='simpan' value='Simpan'></th>";
	echo "</thead>";
	//HEADER END


	//ISI TABEL
		if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
		// $result=mysql_query("SELECT * FROM inventory_distribusi WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND jenis_doc	LIKE 'BC %' $if_pencarian");
		// $urut=1;

		//PAGING
		$halaman = 50;
		$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
		$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
		$result = mysql_query("SELECT * FROM inventory_distribusi WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND jenis_doc	LIKE 'BC %' $if_pencarian");
		$total = mysql_num_rows($result);
		$pages = ceil($total/$halaman);
		$query = mysql_query("SELECT * FROM inventory_distribusi WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND jenis_doc	LIKE 'BC %' $if_pencarian ORDER BY tanggal_doc ASC LIMIT $mulai, $halaman")or die(mysql_error);
		$urut=$mulai+1;
		//PAGING

		while ($rows=mysql_fetch_array($query)) {
			echo "<tr>";
			echo "<td>$urut</td>";
				$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
					//HARGA PENYERAHAN
					if ($pecah_column_header[$no]=='harga_penyerahan') {
						echo "<td style='text-align:right; height:25px; width:8%;'>".rupiah($rows[$pecah_column_header[$no]])."</td>";
					}
					//NORMAL
					else{
						echo "<td>".$rows[$pecah_column_header[$no]]."</td>";
					}
				$no++;}

				echo "<td style='text-align:right; height:25px; width:8%;'>".rupiah(tamount_bayar($rows[nomor_aju],$rows[jenis_doc]))."</td>";

				$hasil_sisa=$rows[harga_penyerahan]-tamount_bayar($rows[nomor_aju],$rows[jenis_doc]);
				if ($hasil_sisa<0) {$color='#F08080';}elseif($hasil_sisa==0){$color='#00FFFF';}else{$color='';}
				echo "<td style='text-align:right; height:25px; width:8%; background-color:$color;'>".rupiah($hasil_sisa)." </td>";

				echo "<td style='text-align:right; height:25px; width:8%;'>".rupiah(tamount_ppn($rows[nomor_aju],$rows[jenis_doc]))."</td>";

				echo "<td><input type='checkbox' name='id_terpilih[]' value='$rows[id]'></td>";
			echo "</tr>";
		$urut++;}
	//ISI TABEL END

echo "</form>";
echo "</table>";

//PAGING KLIK
if ($total > '50') {
echo "<table>
<form method ='post' action='$address'>
<tr>
 <td>Total Data($total) | </td>
 <td>Halaman</td>
 <td>:</td>
			<td><select name='halaman'>
			<option value='$nomor_halaman'>".$nomor_halaman."</option>";
  for ($i=1; $i<=$pages; $i++){
echo "<option value='$i'>$i</option>";}
echo "</td>";
echo "<td> / $pages</td>";
		 echo "
		 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		 <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		 <td><input type='submit' value='".ambil_database($bahasa,master_bahasa,"kode='tampil'")."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END
//END TABEL




//REFLESH PARENT CHROME WHEN CLOSE
echo "<script>
      window.onunload = refreshParent;
      function refreshParent(){window.opener.location.reload();}
      </script>";
//REFLESH PARENT CHROME WHEN CLOSE END
?>
