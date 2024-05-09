	<?php global $mod;
		$mod='akuntansiv3/kartupiutang';
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

	$nama_database='akuntansiv3_jurnal';
	//$nama_database_items='admin_purchasing_items';
	$address='?menu=home&mod=akuntansiv3/kartupiutang';

	if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
	$pilihan_tahun=$_POST['pilihan_tahun'];

	//HEADER
	echo "<h2 style='color:red;'>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</h2>";
	echo "<h3>Kartu Piutang</h3>";
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


	if ($akhir_periode1!='' AND $akhir_periode2!='') {

	// TAMPILAN TABEL
	echo "<table class='tabel_utama' style='width:100%;'>";

		echo "<thead>";
			echo "<th>No</th>";
			echo "<th>Tanggal</th>";
			echo "<th>Kontak</th>";
			echo "<th>Keterangan</th>";
			echo "<th>Ref/No</th>";
			echo "<th>Debet</th>";
			echo "<th>Kredit</th>";
			echo "<th>Saldo</th>";
		echo "</thead>";

	// $list_akun=
	//SALDO AWAL
	$saldo_awal=ambil_database("SUM(debit)",akuntansiv3_jurnal,"tanggal BETWEEN '$awal_periode1' AND '$awal_periode2' AND nomor LIKE '110.4%'");
	echo "<tr>";
	echo "<td>1</td>";
	echo "<td>$akhir_periode1</td>";
	echo "<td style='text-align:left; width:500px; height:20px;' colspan='5'>Saldo</td>";
	// echo "<td></td>";
	// echo "<td></td>";
	// echo "<td></td>";
	echo "<td style='text-align:right; width:90px;'>".rupiah($saldo_awal)."</td>";
	echo "</tr>";
	//SALDO AWAL END

	unset($_SESSION[test]);

	$sql=mysql_query("SELECT * FROM akuntansiv3_jurnal WHERE nomor LIKE '110.4%' AND tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2' ORDER BY tanggal,id");
	$no=2;
	while ($rows=mysql_fetch_array($sql)) {

		$saldo_array=$saldo_awal+$rows[debit]-$rows[kredit];
		if ($_SESSION[test]=='') {
			$_SESSION[test]=$saldo_array;
			$test=$saldo_array;
		}else {
			$test=$_SESSION[test]+$rows[debit]-$rows[kredit];
			$_SESSION[test]=$test;
		}

		echo "<tr>";
					echo "<td style='width:15px; height:20px;'>$no</td>";
					echo "<td style='width:90px;'>$rows[tanggal]</td>";
					echo "<td style='text-align:left; width:500px;'>$rows[kontak]</td>";
					echo "<td style='text-align:left; width:500px;'>$rows[keterangan]</td>";
					echo "<td>$rows[ref]</td>";
					echo "<td style='text-align:right; width:90px;'>".rupiah($rows[debit])."</td>";
					echo "<td style='text-align:right; width:90px;'>".rupiah($rows[kredit])."</td>";
					echo "<td style='text-align:right; width:90px;'>".rupiah($test)."</td>";
		echo "</tr>";


	$no++;}

	// echo "<tr>";
	// 	echo "<td colspan='6' style='font-size:12px; font-weight:bold;'>TOTAL</td>";
	// 	echo "<td style='font-size:12px; white-space:nowrap; font-weight:bold;'>".rupiah($total_saldo_akhir)."</td>";
	// echo "</tr>";

	echo "</table>";

	}
	// TAMPILAN TABEL END


	}//END HOME
	//END PHP?>
