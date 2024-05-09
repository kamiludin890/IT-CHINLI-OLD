<?php global $mod;
	$mod='hrddata/idcard';
function editmenu(){extract($GLOBALS);}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}


function buat_list_checkbox($list_akses,$jumlah_list_akses){
		$no=0;for($i=0; $i < $jumlah_list_akses; ++$i){
			$datasecs[]="".$list_akses[$no]."";
		$no++;}
			$data=implode(",", $datasecs);
return $data;}

function qr_code($id_qr){
	include "modules/qrcode/qrlib.php";
	$tempdir = "modules/cetakqrcode/gambarqrcode/"; //Nama folder tempat menyimpan file qrcode

	$pecah_column=explode (",",$id_qr);
	$nilai_jumlah_pecahan=count($pecah_column);
	$no=0;for($i=0; $i < $nilai_jumlah_pecahan; ++$i){
		$id=$pecah_column[$no];

  mkdir($tempdir);
  $codeContents=$id;
	QRcode::png($codeContents,$tempdir."$id-MASUK.png");

	$no++;}


	// if (!file_exists($tempdir)) //Buat folder bername temp
	// 	 mkdir($tempdir);
	// 	 //isi qrcode jika di scan
	// 	 $codeContents=$id;
	// //simpan file kedalam folder temp dengan nama 001.png
	// QRcode::png($codeContents,$tempdir."$id-MASUK.png");
	// //menampilkan file qrcode
}

function home(){extract($GLOBALS);
include ('function.php');
include 'style.css';
$column_header='nik,nama,bagian';

$nama_database='hrd_data_karyawan';
//='deliverycl_invoice_items';
$address='?mod=hrddata/idcard';

$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);
$nomor_halaman=$_POST['halaman'];

if ($_POST['pilihan_tahun']) {
	$pilihan_tahun=$_POST['pilihan_tahun'];
	$pilihan_bulan=$_POST['pilihan_bulan'];
	$pilihan_pencarian=$_POST['pilihan_pencarian'];
	$pencarian=$_POST['pencarian'];
}
if ($_GET['pilihan_tahun']) {
	$pilihan_tahun=$_GET['pilihan_tahun'];
	$pilihan_bulan=$_GET['pilihan_bulan'];
	$pilihan_pencarian=$_GET['pilihan_pencarian'];
	$pencarian=$_GET['pencarian'];
}
if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}



//UPDATE CHECK BOX
if ($_POST['save_list']) {
$list_pilihan=buat_list_checkbox($_POST['pilihan'],count($_POST['pilihan']));
$nilai_column_id=count($_POST['pilihan']);
$jumlah_column_id=pecah($list_pilihan);

$kunci_list_pilihan=base64_encrypt("$list_pilihan","XblImpl1!A@");
echo '<script type="text/javascript">window.open(\''."modules/hrddata/cetak/cetak_idcard.php?id_download=$kunci_list_pilihan&td=$nilai_column_id".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1,width=600'.'\')</script>';
}//UPDATE CHECK BOX END



// PILIHAN TANGGAL DAN PENCARIAN
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
 echo "<option value='All'>All</option>";
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
//END // PILIHAN TANGGAL DAN PENCARIAN


//PRINT
echo "<form method='POST' action='$address'>";
echo "<table><tr>";
echo "<td><input type='submit' name='kembali' value='Print'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='item' value='$item'>
			<input type='hidden' name='save_list' value='1'></td>";
echo "</tr></table>";



//HEADER TABEL
echo "<table class='tabel_utama' style='width:auto;'>";
echo "<thead>";
echo "<th>NO</th>";
echo "<th>Foto</th>";
$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
	echo "<th><strong>".ambil_database($bahasa,pusat_bahasa,"kode='".$pecah_column_header[$no]."'")."</strong></th>";
$no++;}

			//TOMBOL CENTANG
			echo "<th>";
			if ($_GET['centang']==1) {$point_centang=2;}else{$point_centang=1;}
				echo "<a href='$address&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&item=$item&centang=$point_centang&pencarian=$pencarian&pilihan_pencarian=$pilihan_pencarian'>All</a>";
			echo "</th>";
			//TOMBOL CENTANG END

echo "</thead>";
//HEADER TABEL END


if ($_GET['centang']==1) {$hasil="checked";}elseif($_GET['centang']==2){$hasil="";}else{$hasil="";}
if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
if ($pilihan_tahun=='All'){$pilihan_tahun2='20'; $pilihan_bulan2='';}else{$pilihan_tahun2=$pilihan_tahun; $pilihan_bulan2="-$pilihan_bulan";}


//PAGING
$halaman = 100;
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT	* FROM $nama_database WHERE tanggal LIKE '%$pilihan_tahun2$pilihan_bulan2%' AND status_pegawai='Aktif' $if_pencarian");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT	* FROM $nama_database WHERE tanggal LIKE '%$pilihan_tahun2$pilihan_bulan2%' AND status_pegawai='Aktif' $if_pencarian ORDER BY tanggal DESC LIMIT $mulai, $halaman")or die(mysql_error);
$no_urut =$mulai+1;
//PAGING

while ($rows1=mysql_fetch_array($query)) {

echo "<tr>";
echo "<td>$no_urut</td>";
if ($rows1[foto]) {
	echo "<td><img src='modules/hrddata/gambarkaryawan/$rows1[foto]' width='80px' height='100px'/></td>";
}else {
	echo "<td><img src='modules/hrddata/gambarkaryawan/keren.gif' width='80px' height='100px'/></td>";
}
echo "<td>$rows1[nik]</td>";
echo "<td>$rows1[nama]</td>";
echo "<td>$rows1[bagian]</td>";
echo "<td><input type='checkbox' name='pilihan[]' value='$rows1[id]' $hasil></td>";
echo "</tr>";



$no_urut++;}
echo "</form>";


//PAGING KLIK
if ($total > '9') {
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
		 <td><input type='submit' value='".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END



}//END HOME
//END PHP?>
