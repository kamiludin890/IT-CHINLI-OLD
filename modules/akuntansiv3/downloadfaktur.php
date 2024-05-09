	<?php global $mod;
		$mod='akuntansiv3/downloadfaktur';
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

	// $column_header='tanggal,ref,nomor,keterangan,keterangan_posting,debit,kredit,kode_posting,tanggal_input';
	//$column='ref,tanggal,tanggal_input,nomor,nama,keterangan,debit,kredit,kode_posting,pembuat,tgl_dibuat';

	// $nama_database='akuntansiv3_jurnal';
	//$nama_database_items='admin_purchasing_items';
	$address='?menu=home&mod=akuntansiv3/downloadfaktur';

	if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
	$pilihan_tahun=$_POST['pilihan_tahun'];

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
	// echo "</tr>";
	// echo "</table>";
	//
	// echo "<table style='font-size:15px;'>";
	// echo "<tr>";
		echo "<td><input type='submit' name='show' value='Show'></td>";
	echo "</tr>";

	echo "</form>";
	echo "</table>";
	//FORM KALENDER END


	if ($akhir_periode1!='' AND $akhir_periode2!='') {

		if ($_POST[rekap_faktur_keluaran]) {
			echo "<script type='text/javascript'>window.open('modules/akuntansiv3/cetak/print_rekap_faktur_keluaran.php?akhir_periode1=$akhir_periode1&akhir_periode2=$akhir_periode2&awal_periode1=$awal_periode1&awal_periode2=$awal_periode2')</script>";
		}

		if ($_POST[rekap_faktur_keluaran_kode_barang]) {
			echo "<script type='text/javascript'>window.open('modules/akuntansiv3/cetak/print_rekap_faktur_keluaran_kode_barang.php?akhir_periode1=$akhir_periode1&akhir_periode2=$akhir_periode2&awal_periode1=$awal_periode1&awal_periode2=$awal_periode2')</script>";
		}



		echo "<table style='margin-top:10px;'><tr>";

		echo "<form method ='post' action=''>";
		echo "<td><input type='submit' name='submit' value='Rekap Faktur Pajak Keluaran'>
					<input type='hidden' name='halaman' value='$nomor_halaman'>
					<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
					<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
					<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
					<input type='hidden' name='pencarian' value='$pencarian'>
					<input type='hidden' name='akhir_periode1' value='$akhir_periode1'>
					<input type='hidden' name='akhir_periode2' value='$akhir_periode2'>
					<input type='hidden' name='rekap_faktur_keluaran' value='1'></td></form>";

		echo "<form method ='post' action=''>";
		echo "<td><input type='submit' name='submit' value='Rekap Faktur Pajak Keluaran (Kode Barang)'>
					<input type='hidden' name='halaman' value='$nomor_halaman'>
					<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
					<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
					<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
					<input type='hidden' name='pencarian' value='$pencarian'>
					<input type='hidden' name='akhir_periode1' value='$akhir_periode1'>
					<input type='hidden' name='akhir_periode2' value='$akhir_periode2'>
					<input type='hidden' name='rekap_faktur_keluaran_kode_barang' value='1'></td></form>";

		echo "</tr></table>";


		if ($_POST[download_laporan1]) {
			echo "<script type='text/javascript'>window.open('modules/akuntansiv3/cetak/download_laporan1.php?akhir_periode1=$akhir_periode1&akhir_periode2=$akhir_periode2&awal_periode1=$awal_periode1&awal_periode2=$awal_periode2')</script>";
		}

		if ($_POST[download_laporan2]) {
			echo "<script type='text/javascript'>window.open('modules/akuntansiv3/cetak/download_laporan2.php?akhir_periode1=$akhir_periode1&akhir_periode2=$akhir_periode2&awal_periode1=$awal_periode1&awal_periode2=$awal_periode2')</script>";
		}



		// echo "<table style='margin-top:10px;'><tr>";
		//
		// echo "<form method ='post' action=''>";
		// echo "<td><input type='submit' name='submit' value='Laporan 1'>
		// 			<input type='hidden' name='halaman' value='$nomor_halaman'>
		// 			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		// 			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		// 			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		// 			<input type='hidden' name='pencarian' value='$pencarian'>
		// 			<input type='hidden' name='akhir_periode1' value='$akhir_periode1'>
		// 			<input type='hidden' name='akhir_periode2' value='$akhir_periode2'>
		// 			<input type='hidden' name='download_laporan1' value='1'></td></form>";
		//
		// echo "<form method ='post' action=''>";
		// echo "<td><input type='submit' name='submit' value='Laporan 2'>
		// 			<input type='hidden' name='halaman' value='$nomor_halaman'>
		// 			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		// 			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		// 			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		// 			<input type='hidden' name='pencarian' value='$pencarian'>
		// 			<input type='hidden' name='akhir_periode1' value='$akhir_periode1'>
		// 			<input type='hidden' name='akhir_periode2' value='$akhir_periode2'>
		// 			<input type='hidden' name='download_laporan2' value='1'></td></form>";
		//
		// echo "</tr></table>";



	}
	// TAMPILAN TABEL END


	}//END HOME
	//END PHP?>
