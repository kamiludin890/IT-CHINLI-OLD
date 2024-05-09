<?php global $mod;
	$mod='akuntansiv2/trialbalance';
function editmenu(){extract($GLOBALS);}

function ambil_variabel($nama_database,$kolom) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode('","', $datasecs);
	$hasil='"'.$data.'"';
return $hasil;}

function jumlahhari($month,$year){
$hai = date('t', mktime(0, 0, 0, $month, 1, $year));
return $hai;}

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
include 'style.css';
echo kalender();
echo combobox();

$column_header='tanggal,ref,nomor,keterangan,keterangan_posting,debit,kredit,kode_posting,tanggal_input';
//$column='ref,tanggal,tanggal_input,nomor,nama,keterangan,debit,kredit,kode_posting,pembuat,tgl_dibuat';

$nama_database='akuntansiv2_jurnal';
//$nama_database_items='admin_purchasing_items';
$address='?menu=home&mod=akuntansiv2/trialbalance';

if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
$pilihan_tahun=$_POST['pilihan_tahun'];

//HEADER
echo "<h2 style='color:red;'>PT. CHINLI PLASTIC MATERIAL INDONESIA</h2>";
echo "<h3>Trial Balance</h3>";
//HEADER END



//VARIABEL PERIODE
$awal_periode1="2018-01-01";
$awal_periode2=date('Y-m-d',strtotime('-1 days', strtotime($_POST[akhir_periode1])));
$akhir_periode1=$_POST['akhir_periode1'];
$akhir_periode2=$_POST['akhir_periode2'];
//VARIABEL PERIODE END


//FORM KALENDER
echo "<table style='font-size:15px;'>";
echo "<form method='POST' action='$address'>";

echo "<tr>";
echo "<td>Periode</td>";
echo "<td>:</td>";
echo "<td><input type='text' class='date' name='akhir_periode1' value='$akhir_periode1' autocomplete='off';></td>";
echo "<td>s/d</td>";
echo "<td><input type='text' class='date' name='akhir_periode2' value='$akhir_periode2' autocomplete='off';></td>";
echo "</tr>";
echo "</table>";

echo "<table style='font-size:15px;'>";
echo "<tr>";
	echo "<td><input type='submit' name='show' value='Show'></td>";
echo "</tr>";

echo "</form>";
echo "</table>";
//FORM KALENDER END


// TAMPILAN TABEL
echo "<table class='tabel_utama'>";

	echo "<thead>";
		echo "<th>No</th>";
		echo "<th>Akun</th>";;
		echo "<th>Nama</th>";;
		echo "<th>Saldo Awal</th>";;
		echo "<th>Debit</th>";;
		echo "<th>Kredit</th>";;
		echo "<th>Saldo Akhir</th>";
	echo "</thead>";

$sql=mysql_query("SELECT * FROM akuntansiv2_akun WHERE nomor NOT LIKE ''");
$no=1;
while ($rows=mysql_fetch_array($sql)) {
	echo "<tr>";
		echo "<td>$no</td>";
		echo "<td>$rows[nomor]</td>";
		echo "<td>$rows[nama]</td>";

		$result2=mysql_query("SELECT
			SUM(IF(tanggal BETWEEN '$awal_periode1' AND '$awal_periode2', debit, 0)) - SUM(IF(tanggal BETWEEN '$awal_periode1' AND '$awal_periode2', kredit, 0)) AS saldo_awal,
			SUM(IF(tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2', debit, 0)) AS jumlah_debit,
			SUM(IF(tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2', kredit, 0)) AS jumlah_kredit
			FROM $nama_database where nomor='$rows[nomor]'");
		$rows2=mysql_fetch_array($result2);

		echo "<td style='text-align:right; height:20px; width:90px;'>".rupiah($rows2[saldo_awal])."</td>";
		echo "<td style='text-align:right; width:90px;'>".rupiah($rows2[jumlah_debit])."</td>";
		echo "<td style='text-align:right; width:90px;'>".rupiah($rows2[jumlah_kredit])."</td>";
		$saldo_akhir=$rows2[saldo_awal]+$rows2[jumlah_debit]-$rows2[jumlah_kredit];
		echo "<td style='text-align:right; width:90px;'>".rupiah($saldo_akhir)."</td>";
	echo "</tr>";

$total_saldo_awal=$rows2[saldo_awal]+$total_saldo_awal;
$total_debit=$rows2[jumlah_debit]+$total_debit;
$total_kredit=$rows2[jumlah_kredit]+$total_kredit;
$total_saldo_akhir=$saldo_akhir+$total_saldo_akhir;

$no++;}

echo "<tr>";
	echo "<td colspan='3' style='font-size:12px; font-weight:bold;'>TOTAL</td>";
	echo "<td style='font-size:12px; white-space:nowrap; font-weight:bold;'>".rupiah($total_saldo_awal)."</td>";
	echo "<td style='font-size:12px; white-space:nowrap; font-weight:bold;'>".rupiah($total_debit)."</td>";
	echo "<td style='font-size:12px; white-space:nowrap; font-weight:bold;'>".rupiah($total_kredit)."</td>";
	echo "<td style='font-size:12px; white-space:nowrap; font-weight:bold;'>".rupiah($total_saldo_akhir)."</td>";
echo "</tr>";

echo "</table>";

// TAMPILAN TABEL END


}//END HOME
//END PHP?>
