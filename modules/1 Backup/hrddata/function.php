<?php

// ENKRIPSI
function base64_encrypt($plain_text, $password, $iv_len = 16)
{
$plain_text .= "\x13";
$n = strlen($plain_text);
if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
$i = 0;
$enc_text = get_rnd_iv($iv_len);
$iv = substr($password ^ $enc_text, 0, 512);
while ($i < $n) {
$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
$enc_text .= $block;
$iv = substr($block . $iv, 0, 512) ^ $password;
$i += 16;
}
$hasil=base64_encode($enc_text);
return str_replace('+', '@', $hasil);
}
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
function get_rnd_iv($iv_len)
{
$iv = '';
while ($iv_len-- > 0) {
$iv .= chr(mt_rand() & 0xff);
}
return $iv;
}//// ENKRIPSI END


function datediff($tgl1, $tgl2){
$tgl1 = strtotime($tgl1);
$tgl2 = strtotime($tgl2);
$diff_secs = abs($tgl1 - $tgl2);
$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
}

function selisih($tanggal){
		$tgl1=$tanggal;
		$tgl2=date("Y-m-d");
	$a = datediff($tgl1, $tgl2);
	//echo 'tanggal 1 = '.$tgl1; echo '<br>';
	//echo 'tanggal 2 = '.$tgl2; echo '<br>';
	$Selisih=$a[years].' tahun '.$a[months].' bulan '.$a[days].' hari';//.$a[hours].' jam '.$a[minutes].' menit '.$a[seconds].' detik';
//return "$nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$jenis";
return $Selisih;}

function selisih_tahun($tanggal1,$tanggal2){
		$tgl1=$tanggal1;
		$tgl2=$tanggal2;
	$a = datediff($tgl1, $tgl2);
	//echo 'tanggal 1 = '.$tgl1; echo '<br>';
	//echo 'tanggal 2 = '.$tgl2; echo '<br>';
	$Selisih=$a[years].' tahun ';//.$a[months].' bulan '.$a[days].' hari'.$a[hours].' jam '.$a[minutes].' menit '.$a[seconds].' detik';
//return "$nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$jenis";
return $Selisih;}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'',',');
return $hasil_rupiah;}

function dollar($angka){
	$hasil_rupiah = "$ " . number_format($angka,2,'.',',');//substr(number_format($angka,3,'.',','),0,-1)
return $hasil_rupiah;}

function dollar_price($angka){
$hasil_rupiah = "$ " . number_format($angka,4,'.',',');
return $hasil_rupiah;}

function nama_bulan($tanggal){
	$nilai_bulan=substr($tanggal,5,2);
	if ($nilai_bulan=='01'){$bulan='Januari';}
	elseif ($nilai_bulan=='02'){$bulan='Februari';}
	elseif ($nilai_bulan=='03'){$bulan='Maret';}
	elseif ($nilai_bulan=='04'){$bulan='April';}
	elseif ($nilai_bulan=='05'){$bulan='Mei';}
	elseif ($nilai_bulan=='06'){$bulan='Juni';}
	elseif ($nilai_bulan=='07'){$bulan='Juli';}
	elseif ($nilai_bulan=='08'){$bulan='Agustus';}
	elseif ($nilai_bulan=='09'){$bulan='September';}
	elseif ($nilai_bulan=='10'){$bulan='Oktober';}
	elseif ($nilai_bulan=='11'){$bulan='November';}
	elseif ($nilai_bulan=='12'){$bulan='Desember';}
	else {$bulan='';}
return $bulan;}

function nama_bulan_only($tanggal){
	$nilai_bulan=$tanggal;
	if ($nilai_bulan=='01'){$bulan='Januari';}
	elseif ($nilai_bulan=='02'){$bulan='Februari';}
	elseif ($nilai_bulan=='03'){$bulan='Maret';}
	elseif ($nilai_bulan=='04'){$bulan='April';}
	elseif ($nilai_bulan=='05'){$bulan='Mei';}
	elseif ($nilai_bulan=='06'){$bulan='Juni';}
	elseif ($nilai_bulan=='07'){$bulan='Juli';}
	elseif ($nilai_bulan=='08'){$bulan='Agustus';}
	elseif ($nilai_bulan=='09'){$bulan='September';}
	elseif ($nilai_bulan=='10'){$bulan='Oktober';}
	elseif ($nilai_bulan=='11'){$bulan='November';}
	elseif ($nilai_bulan=='12'){$bulan='Desember';}
	else {$bulan='';}
return $bulan;}


function upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file){
	$tgl_upload=date('Y-m-d H:i:s');
	$hanya_angka = preg_replace("/[^0-9]/", "", $tgl_upload);
	$nama_file2="$hanya_angka-$nama_file";

	if ($nama_file==''){$nama_file3=$nama_file;}else{$nama_file3=$nama_file2;}

	$path = "modules/hrddata/gambarkaryawan/".$nama_file3;
	if($tipe_file == "image/jpeg" || $tipe_file == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
	  if($ukuran_file <= 5000000){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
	    move_uploaded_file($tmp_file, $path);
		}else {
			echo "Ukuran File Terlalu Besar";
		}}
return $nama_file3;}

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

	function npwp($nilai){
		$NPWP2=substr($nilai,0,2);
		$NPWP3=substr($nilai,2,3);
		$NPWP4=substr($nilai,5,3);
		$NPWP5=substr($nilai,8,1);
		$NPWP6=substr($nilai,9,3);
		$NPWP7=substr($nilai,12,3);
		$nilai1="$NPWP2.$NPWP3.$NPWP4.$NPWP5-$NPWP6.$NPWP7";
		return $nilai1;}

function selisih_hari($tgl1,$tgl2){
	// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
	// dari tanggal pertama
	$pecah1 = explode("-", $tgl1);
	$date1 = $pecah1[2];
	$month1 = $pecah1[1];
	$year1 = $pecah1[0];
	// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
	// dari tanggal kedua
	$pecah2 = explode("-", $tgl2);
	$date2 = $pecah2[2];
	$month2 = $pecah2[1];
	$year2 =  $pecah2[0];
	// menghitung JDN dari masing-masing tanggal
	$jd1 = GregorianToJD($month1, $date1, $year1);
	$jd2 = GregorianToJD($month2, $date2, $year2);
	// hitung selisih hari kedua tanggal
	$selisih = $jd1 - $jd2;
return $selisih;}

function hari_kedepan($n,$tanggal){
	$hari=substr($tanggal, 8, 2);
	$bulan=substr($tanggal, 5, 2);
	$tahun=substr($tanggal, 0, 4);
	 // menentukan timestamp 10 hari berikutnya dari tanggal hari ini
	$nextN = mktime(0, 0, 0, date("$bulan"), date("$hari") + $n, date("$tahun"));
	// menentukan timestamp 10 hari sebelumnya dari tanggal hari ini
	//$prevN = mktime(0, 0, 0, date("m"), date("d") - $n, date("Y"));
return $nextN;}

function kalender(){
		echo "
		<link rel='stylesheet' href='modules/tools/kalender_combo/jquery-ui.css'>
		<link rel='stylesheet' href='/resources/demos/style.css'>
		<script src='modules/tools/kalender_combo/jquery-1.12.4.js'></script>
		<script src='modules/tools/kalender_combo/jquery-ui.js'></script>

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
	 <link href='modules/tools/kalender_combo/select2.min.css' rel='stylesheet' />
	 <script src='modules/tools/kalender_combo/select2.min.js'></script>

	<script type='text/javascript'>
	 $(document).ready(function() {
	     $('.comboyuk').select2();
	 });
	</script>";
return;}

function ambil_variabel_kutip_satu_where($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode("','", $datasecs);
	$hasil="'".$data."'";
return $hasil;}

function ambil_variabel_tanpa_kutip_where_distinct($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT DISTINCT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode(",", $datasecs);
	$hasil="".$data."";
return $hasil;}

function tampil_sp($id){
	$tanggal_sekarang=date('Y-m-d');
	$result=mysql_query("SELECT * FROM hrd_data_sp WHERE id_pegawai='$id' AND tanggal_berlaku_sp >= '$tanggal_sekarang'");
	while ($rows=mysql_fetch_array($result)) {

		if ($rows[sp]) {
			$show="SP $rows[sp] End $rows[tanggal_berakhir_sp]";
		}else{
			$show='';
		}

$datasecs[]=$show;
	}
$data=implode("</br>", $datasecs);
return "$data";}

function hapus($nama_database,$id,$nama_database_items){

	if($nama_database=='hrd_data_karyawan'){
		$ambil_foto=ambil_database(foto,$nama_database,"id='$id'");
		$target="modules/hrddata/gambarkaryawan/$ambil_foto";
		if (file_exists($target)){unlink($target);}}

	if($nama_database=='hrd_data_pengajuan_kontrak'){
		mysql_query("DELETE FROM hrd_data_masakerja WHERE id_pengajuan='$id'");
	}


	$string_delete="DELETE FROM $nama_database WHERE id='$id'";
	$ekskusi=mysql_query($string_delete);

	$string_delete_items="DELETE FROM $nama_database_items WHERE induk='$id'";
	$ekskusi2=mysql_query($string_delete_items);
return;}

function pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header){//Pilihan BULAN & TAHUN START
	$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");;
	if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
	if ($opsi != '') {
		//AMBIL GET
		$pilihan_tahun=$_GET['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_GET['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_GET['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_GET['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_GET['halaman'];//PAGING
		$opsi_tambahan=$_GET['opsi_tambahan'];//OPSI TAMBAHAN
	}else{
		//AMBIL POST
		$pilihan_tahun=$_POST['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_POST['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_POST['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_POST['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_POST['halaman'];//PAGING
		$opsi_tambahan=$_POST['opsi_tambahan'];//OPSI TAMBAHAN
	}
	//Ambil Nama Nama Kolom
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);

	//pecah dan ambil Untuk Header
	$pecah_column_header=explode (",",$column_header);
	$nilai_jumlah_pecahan_header=count($pecah_column_header);
	//AMBIL POST END
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
	//Pilihan TANGGAL & TAHUN END
return ;}//Pilihan BULAN & TAHUN START

function tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items){
	include 'style.css';
	if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
	$username=$_SESSION['username'];
	$validasi=ambil_database(validasi,master_user,"email='$username'");

	$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");;
	if ($opsi != '') {
		//AMBIL GET
		$id=base64_decrypt($_GET['id'],"XblImpl1!A@");;
		$pilihan_tahun=$_GET['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_GET['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_GET['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_GET['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_GET['halaman'];//PAGING
		$opsi_tambahan=$_GET['opsi_tambahan'];//OPSI TAMBAHAN
	}else{
		//AMBIL POST
		$id=$_POST['id'];
		$pilihan_tahun=$_POST['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_POST['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_POST['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_POST['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_POST['halaman'];//PAGING
		$opsi_tambahan=$_POST['opsi_tambahan'];//OPSI TAMBAHAN
	}

	//Pecah dan Ambil Nama Kolom
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);

	//pecah dan ambil Untuk Header
	$pecah_column_header=explode (",",$column_header);
	$nilai_jumlah_pecahan_header=count($pecah_column_header);

	//DELETE
	if ($opsi == 'delete') {
		echo hapus($nama_database,$id,$nama_database_items);}

	//UPDATE VALID
	if ($_POST[valid] == 'Valid') {
		mysql_query("UPDATE $nama_database SET validasi='$_POST[valid]',validasi_by='$username' WHERE id='$_POST[id]'");

		//Update PROSES untuk Purchasing
		if ($nama_database == 'hrd_data_karyawan') {
			//mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$_POST[id]'");
		}
	}//UPDATE VALID END

//PENENTU UPDATE INSERT
					// //Sales SPK
					// if ($nama_database == 'sales_spk') {
					// 		$po_nomor=ambil_database(po_nomor,sales_po,"id='$_POST[id_po]'");
					// 		$line_batch=ambil_database(line_batch,sales_po,"id='$_POST[id_po]'");
					// 	if ($_POST['jenis'] == tambah AND $po_nomor == ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor'") AND $line_batch == ambil_database(line_batch,$nama_database,"line_batch='$line_batch'") ) {
					// 		$ijin_tambah='tidak'; $notice=ambil_database($bahasa,pusat_bahasa,"kode='notice1'");}
					// 	else {$ijin_tambah='yes';}
					//
					// 		$id_khusus=$_POST['id'];$nilai_line_db_with_id=ambil_database(line_batch,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch' AND id='$id_khusus'");
					// 		$nilai_line_db_not_id=ambil_database(line_batch,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'");
					// 	if ($nilai_line_db_with_id == $line_batch AND $_POST['jenis'] == edit AND $po_nomor == ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'")) {
					// 		$ijin_update='yes';}
					// 	elseif ($nilai_line_db_not_id == 0 AND $_POST['jenis'] == edit AND $po_nomor != ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'")) {
					// 		$ijin_update='yes';}
					// 	else {$ijin_update='tidak';$notice=ambil_database($bahasa,pusat_bahasa,"kode='notice1'");}
					// }//Sales SPK END

					//Sales BUkan Penentu Update
					if ($nama_database == 'hrd_payroll_bagian' OR $nama_database == 'hrd_data_karyawan' OR $nama_database == 'hrd_data_sp' OR $nama_database == 'hrd_data_masakerja' OR $nama_database == 'hrd_data_absensi' OR $nama_database == 'hrd_data_pengajuan_kontrak') {
						$ijin_update='yes'; $ijin_tambah='yes';
					}//Sales BUkan Penentu Update


//TAMPILAN NORMAL
//else{$ijin_tambah='yes';$ijin_update='yes';}
//TAMPILAN NORMAL END
//PENENTU UPDATE INSERT END

//NOTICE INPUT
if ($_POST['isian_revisi']=='revisi' AND $_POST['ket_revisi'] == ''){echo "<table style='background-color:yellow;'><tr><td>".ambil_database($bahasa,pusat_bahasa,"kode='notice_isian_revisi'")."</td></tr></table>";}
if ($_POST['jenis'] == tambah AND $ijin_tambah == 'tidak' OR $_POST['jenis'] == edit AND $ijin_update == 'tidak'){echo "<table style='background-color:yellow;'><tr><td>".$notice."</td></tr></table>";}
//NOTICE INPUT END

	//UPDATE DATA ARRAY
	if ($_POST['jenis'] == 'edit' AND $ijin_update == 'yes'){
			  $no=0;for($i=0; $i < $nilai_jumlah_pecahan; ++$i){
				$nama_kolom=$pecah_column[$no];

				//ISIAN REVISI
				if ($_POST['isian_revisi'] == 'revisi' AND $_POST['ket_revisi'] != ''){$tgl=date('Y-m-d H:i:s'); mysql_query("UPDATE $nama_database SET validasi='',tgl_revisi='$tgl',status='' WHERE id='$id'");}

				if ($pecah_column[$no]==pembuat){$isi_kolom=$_SESSION['username'];}//Untuk Pembuat
				elseif ($pecah_column[$no]==kode_produk_internal){$nilai_kode_produk_internal=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}//Untuk Update Spesial Nilai Kodebarang dan lokasi
				elseif ($pecah_column[$no]==id_style_item_kode){$nilai_id_style_item_kode=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// PO ambil nilai untuk masterstyle
				elseif ($pecah_column[$no]==foto) {
									//FOTO
									$nama_file = $_FILES['gambar']['name'];
									$ukuran_file = $_FILES['gambar']['size'];
									$tipe_file = $_FILES['gambar']['type'];
									$tmp_file = $_FILES['gambar']['tmp_name'];
									$nama_gambar=upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file);
									$gambar_sebelumnya=$_POST['gambar_sebelumnya'];
									if ($nama_gambar==''){
										$isi_kolom=$gambar_sebelumnya;
									}else{
										$target="modules/hrddata/gambarkaryawan/$gambar_sebelumnya";
										if (file_exists($target)){unlink($target);}
										$isi_kolom=$nama_gambar;}}
				else{$isi_kolom=$_POST[$pecah_column[$no]];}

				if ($_POST['isian_revisi']=='revisi' AND $_POST['ket_revisi'] == ''){}
				else{$update="UPDATE $nama_database SET $nama_kolom='$isi_kolom' WHERE id='$id'";
					   mysql_query($update);}
				$no++;}

				//Master Data Karyawan
				if ($nama_database=='hrd_data_karyawan'){
					$tanggal_masuk=ambil_database(tanggal_masuk,$nama_database,"id='$id'");
					//date('Y-m-d',strtotime('+2 year', strtotime($kontrak_awal1)));
					$kontrak_awal1=$tanggal_masuk;
					$kontrak_awal2=date('Y-m-d',strtotime('-1 days', strtotime(date('Y-m-d',strtotime('+2 year', strtotime($kontrak_awal1))))));
					$kontrak_akhir1=date('Y-m-d',strtotime('+1 days', strtotime($kontrak_awal2)));
					$kontrak_akhir2=date('Y-m-d',strtotime('-1 days', strtotime(date('Y-m-d',strtotime('+1 year', strtotime($kontrak_akhir1))))));

					$tanggal_tidak_aktif=$_POST['tanggal_tidak_aktif'];
					$alasan_tidak_aktif=$_POST['alasan_tidak_aktif'];
					$keterangan_tidak_aktif=$_POST['keterangan_tidak_aktif'];

					mysql_query("UPDATE $nama_database SET tanggal_tidak_aktif='$tanggal_tidak_aktif',alasan_tidak_aktif='$alasan_tidak_aktif',keterangan_tidak_aktif='$keterangan_tidak_aktif',kontrak_awal1='$kontrak_awal1',kontrak_awal2='$kontrak_awal2',kontrak_akhir1='$kontrak_akhir1',kontrak_akhir2='$kontrak_akhir2' WHERE id='$id'");
				}//aster Data Karyawan


				//Master Data Karyawan
				if ($nama_database=='hrd_data_sp'){
					$id_pegawai=ambil_database(id_pegawai,$nama_database,"id='$id'");
					$tanggal_berlaku_sp=ambil_database(tanggal_berlaku_sp,$nama_database,"id='$id'");

					$nik=ambil_database(nik,hrd_data_karyawan,"id='$id_pegawai'");
					$nama=ambil_database(nama,hrd_data_karyawan,"id='$id_pegawai'");
					$bagian=ambil_database(bagian,hrd_data_karyawan,"id='$id_pegawai'");

					$tanggal_berakhir_sp=date('Y-m-d',strtotime('+6 month', strtotime($tanggal_berlaku_sp)));

					mysql_query("UPDATE $nama_database SET nik='$nik',nama='$nama',bagian='$bagian',tanggal_berakhir_sp='$tanggal_berakhir_sp' WHERE id='$id'");
				}//aster Data Karyawan


				//Master Data Karyawan
				if ($nama_database=='hrd_data_masakerja'){
					$id_pegawai=ambil_database(id_pegawai,$nama_database,"id='$id'");

					$nik=ambil_database(nik,hrd_data_karyawan,"id='$id_pegawai'");
					$nama=ambil_database(nama,hrd_data_karyawan,"id='$id_pegawai'");
					$bagian=ambil_database(bagian,hrd_data_karyawan,"id='$id_pegawai'");
					$tanggal_masuk=ambil_database(tanggal_masuk,hrd_data_karyawan,"id='$id_pegawai'");
					$kontrak_tahun_kesatu=$tanggal_masuk;

					mysql_query("UPDATE $nama_database SET nik='$nik',nama='$nama',bagian='$bagian',tanggal_masuk='$tanggal_masuk',kontrak_tahun_kesatu='$kontrak_tahun_kesatu' WHERE id='$id'");
				}//aster Data Karyawan


				//Master Data Karyawan
				if ($nama_database=='hrd_data_absensi'){
					$id_pegawai=ambil_database(id_pegawai,$nama_database,"id='$id'");

					$nik=ambil_database(nik,hrd_data_karyawan,"id='$id_pegawai'");
					$nama=ambil_database(nama,hrd_data_karyawan,"id='$id_pegawai'");
					$bagian=ambil_database(bagian,hrd_data_karyawan,"id='$id_pegawai'");

					mysql_query("UPDATE $nama_database SET nik='$nik',nama='$nama',bagian='$bagian' WHERE id='$id'");
				}//aster Data Karyawan



		}//END UPDATE DATA ARRAY

	//TAMBAH DATA ARRAY
	if ($_POST['jenis'] == 'tambah' AND $ijin_tambah == 'yes'){
				$no=0;for($i=0; $i < $nilai_jumlah_pecahan; ++$i){

				if ($pecah_column[$no]==pembuat){$isi_kolom=$_SESSION['username'];}//Untuk Pembuat
				elseif ($pecah_column[$no]==tgl_dibuat){$isi_kolom=date('Y-m-d H:i:s');}//Untuk Waktu Pertama di Input
				elseif ($pecah_column[$no]==kode_produk_internal){$nilai_kode_produk_internal=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}//masterstyle Untuk Update Spesial Nilai Kodebarang dan lokasi
				elseif ($pecah_column[$no]==id_style_item_kode){$nilai_id_style_item_kode=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// PO ambil nilai untuk masterstyle
				elseif ($pecah_column[$no]==foto) {
					//FOTO
					$nama_file = $_FILES['gambar']['name'];
					$ukuran_file = $_FILES['gambar']['size'];
					$tipe_file = $_FILES['gambar']['type'];
					$tmp_file = $_FILES['gambar']['tmp_name'];
					$isi_kolom=upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file);}
				elseif ($pecah_column[$no]==id_model){$nilai_id_model=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// PO ambil nilai untuk masterstyle
				elseif ($pecah_column[$no]==id_po){$nilai_id_po=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// SALES SPK - PO ambil nilai untuk SALES SPK

				else{$isi_kolom=$_POST[$pecah_column[$no]];}
				$datasecs[]=$pecah_column[$no]."='".$isi_kolom."'";$no++;}
				$data=implode(",", $datasecs);
				$insert ="INSERT INTO $nama_database SET $data";
				mysql_query($insert);

		//INSERT SPESIAL
		$data2=implode(" AND ", $datasecs);


		//DATA KARYAWAN
		if ($nama_database=='hrd_data_karyawan' AND $address=='?mod=hrddata/masterkaryawan'){
		$ambil_id=ambil_database(id,$nama_database,$data2);

		$tanggal_masuk=ambil_database(tanggal_masuk,$nama_database,"id='$ambil_id'");
		//date('Y-m-d',strtotime('+2 year', strtotime($kontrak_awal1)));
		$kontrak_awal1=$tanggal_masuk;
		$kontrak_awal2=date('Y-m-d',strtotime('-1 days', strtotime(date('Y-m-d',strtotime('+2 year', strtotime($kontrak_awal1))))));
		$kontrak_akhir1=date('Y-m-d',strtotime('+1 days', strtotime($kontrak_awal2)));
		$kontrak_akhir2=date('Y-m-d',strtotime('-1 days', strtotime(date('Y-m-d',strtotime('+1 year', strtotime($kontrak_akhir1))))));

		$tanggal_tidak_aktif=$_POST['tanggal_tidak_aktif'];
		$alasan_tidak_aktif=$_POST['alasan_tidak_aktif'];
		$keterangan_tidak_aktif=$_POST['keterangan_tidak_aktif'];

		mysql_query("UPDATE $nama_database SET tanggal_tidak_aktif='$tanggal_tidak_aktif',alasan_tidak_aktif='$alasan_tidak_aktif',keterangan_tidak_aktif='$keterangan_tidak_aktif',kontrak_awal1='$kontrak_awal1',kontrak_awal2='$kontrak_awal2',kontrak_akhir1='$kontrak_akhir1',kontrak_akhir2='$kontrak_akhir2' WHERE id='$ambil_id'");
		}//DATA KARYAWAN


		//DATA KARYAWAN
		if ($nama_database=='hrd_data_sp' AND $address=='?mod=hrddata/sp'){
		$ambil_id=ambil_database(id,$nama_database,$data2);

		$id_pegawai=ambil_database(id_pegawai,$nama_database,"id='$ambil_id'");
		$tanggal_berlaku_sp=ambil_database(tanggal_berlaku_sp,$nama_database,"id='$ambil_id'");

		$nik=ambil_database(nik,hrd_data_karyawan,"id='$id_pegawai'");
		$nama=ambil_database(nama,hrd_data_karyawan,"id='$id_pegawai'");
		$bagian=ambil_database(bagian,hrd_data_karyawan,"id='$id_pegawai'");

		$tanggal_berakhir_sp=date('Y-m-d',strtotime('+6 months', strtotime($tanggal_berlaku_sp)));

		mysql_query("UPDATE $nama_database SET nik='$nik',nama='$nama',bagian='$bagian',tanggal_berakhir_sp='$tanggal_berakhir_sp' WHERE id='$ambil_id'");
		}//DATA KARYAWAN


		//Master Data Karyawan
		if ($nama_database=='hrd_data_masakerja'){
			$ambil_id=ambil_database(id,$nama_database,$data2);
			$id_pegawai=ambil_database(id_pegawai,$nama_database,"id='$ambil_id'");

			$nik=ambil_database(nik,hrd_data_karyawan,"id='$id_pegawai'");
			$nama=ambil_database(nama,hrd_data_karyawan,"id='$id_pegawai'");
			$bagian=ambil_database(bagian,hrd_data_karyawan,"id='$id_pegawai'");
			$tanggal_masuk=ambil_database(tanggal_masuk,hrd_data_karyawan,"id='$id_pegawai'");
			$kontrak_tahun_kesatu=$tanggal_masuk;

			//URUTAN
			$total_data=mysql_num_rows(mysql_query("SELECT * FROM $nama_database WHERE id_pegawai='$id_pegawai'"));
			$urutan=$total_data;

			mysql_query("UPDATE $nama_database SET nik='$nik',nama='$nama',bagian='$bagian',tanggal_masuk='$tanggal_masuk',kontrak_tahun_kesatu='$kontrak_tahun_kesatu',urutan='$urutan' WHERE id='$ambil_id'");
		}//aster Data Karyawan


		//Master Data Karyawan
		if ($nama_database=='hrd_data_absensi'){
			$ambil_id=ambil_database(id,$nama_database,$data2);
			$id_pegawai=ambil_database(id_pegawai,$nama_database,"id='$ambil_id'");

			$nik=ambil_database(nik,hrd_data_karyawan,"id='$id_pegawai'");
			$nama=ambil_database(nama,hrd_data_karyawan,"id='$id_pegawai'");
			$bagian=ambil_database(bagian,hrd_data_karyawan,"id='$id_pegawai'");

			mysql_query("UPDATE $nama_database SET nik='$nik',nama='$nama',bagian='$bagian' WHERE id='$ambil_id'");
		}//aster Data Karyawan



if ($nama_database == '--') {//hrd_data_pengajuan_kontrak
	 echo "<script type='text/javascript'>window.location.href='$address&id=".base64_encrypt($ambil_id,"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'</script>";
 }

}	//TAMBAH DATA ARRAY END

//START EDIT TAMBAH
if ($opsi == 'tambah' OR $opsi =='edit') {

//ISIAN JIKA EDIT
$sql5="SELECT * FROM $nama_database WHERE id='$id'";
$result5=mysql_query($sql5);
$rows5=mysql_fetch_array($result5);

echo kalender();
echo combobox();

//TABEl START
echo "<table class='kolom_isi'>";
		echo "<form method ='post' enctype='multipart/form-data' action='$address'>";
		$no=0;for($i=0; $i < $nilai_jumlah_pecahan; ++$i){

			$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column[$no]'";
			$result3=mysql_query($sql3);
			$rows3=mysql_fetch_array($result3);
			echo "<tr>";
			//HEADER
			echo "<td id='kolom_isi_th'><strong>".$rows3[$bahasa]."</strong></td>";
			//HEADER END

		$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);

		if ($pecah_column[$no] == 'id' OR $pecah_column[$no] == 'pembuat' OR $pecah_column[$no] == 'tgl_dibuat'){$disabled='readonly';}else{$disabled='';}
		if ($pecah_column[$no] == 'tanggal_pkwtt' OR $pecah_column[$no] == 'jatuh_tempo_kontrak_kedua' OR $pecah_column[$no] == 'perpanjang_kontrak_kedua' OR $pecah_column[$no] == 'jatuh_tempo_kontrak_kesatu' OR $pecah_column[$no] == 'tanggal_masa_berlaku' OR $pecah_column[$no] == 'kontrak_akhir1' OR $pecah_column[$no] == 'kontrak_akhir2' OR $pecah_column[$no] == 'kontrak_awal1' OR $pecah_column[$no] == 'kontrak_awal2' OR $pecah_column[$no] == 'tanggal_lahir' OR $pecah_column[$no] == 'tanggal_masuk' OR $pecah_column[$no] == 'tanggal' OR $pecah_column[$no] == 'etd' OR $pecah_column[$no] == 'tanggal_revisi' OR $pecah_column[$no] == 'tanggal_pelanggaran' OR $pecah_column[$no] == 'tanggal_berlaku_sp'){$format_tgl="class='date' required";}else{$format_tgl="";}

if ($pecah_column[$no] == 'dari'){
$sql113="SELECT * FROM booking_perusahaan WHERE validasi='Valid' AND code='BUYER' ORDER BY perusahaan";
$result113=mysql_query($sql113);
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	while ($rows113=mysql_fetch_array($result113)) {
echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";}
echo "
</select>
</td>";
}
//KEPADA
elseif ($pecah_column[$no] == 'kepada'){
$sql113="SELECT * FROM booking_perusahaan WHERE validasi='Valid' AND code='SUPPLIER' ORDER BY perusahaan";
$result113=mysql_query($sql113);
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
while ($rows113=mysql_fetch_array($result113)) {
echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";}
echo "
</select>
</td>";
}
//MASTER MODEL - FOTO
elseif($pecah_column[$no] == 'foto'){
echo "<td>
<input type='file' name='gambar'>
<input type='hidden' name='gambar_sebelumnya' value='".$rows5[$pecah_column[$no]]."'>
</td>";
}
//MASTER MODEL - FOTO
elseif($pecah_column[$no] == 'status_update'){
$tgl=date('Y-m-d H:i:s');

echo "<td>
<input type='text' value='".$rows5[$pecah_column[$no]]."' disabled>
<input type='hidden' name='status_update' value='$tgl'>
</td>";
}
//Satuan
elseif ($pecah_column[$no] == 'id_pegawai') {
	$sql113="SELECT * FROM hrd_data_karyawan WHERE status_pegawai='Aktif'";
	$result113=mysql_query($sql113);
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]' style='width:250px;'>
	<option value='".$rows5[$pecah_column[$no]]."'>".ambil_database(nik,hrd_data_karyawan,"id='".$rows5[$pecah_column[$no]]."'")." | ".ambil_database(nama,hrd_data_karyawan,"id='".$rows5[$pecah_column[$no]]."'")." | ".ambil_database(tanggal_masuk,hrd_data_karyawan,"id='".$rows5[$pecah_column[$no]]."'")." | ".ambil_database(bagian,hrd_data_karyawan,"id='".$rows5[$pecah_column[$no]]."'")."</option>";
		while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[id]'>$rows113[nik] | $rows113[nama] | $rows113[tanggal_masuk] | $rows113[bagian]</option>";}
	echo "
	</select>
	</td>";
}
//Satuan
elseif ($pecah_column[$no] == 'bagian' AND $address=='?mod=hrddata/masterkaryawan') {
	$sql113="SELECT * FROM hrd_payroll_bagian";
	$result113=mysql_query($sql113);
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".ambil_database(departement,hrd_payroll_bagian,"id='".$rows5[$pecah_column[$no]]."'")." | ".ambil_database(departement,hrd_payroll_bagian,"id='".$rows5[$pecah_column[$no]]."'")."</option>";
		while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[bagian]'>$rows113[departement] | $rows113[bagian]</option>";}
	echo "
	</select>
	</td>";
}
//Jenis Kelamin
elseif ($pecah_column[$no] == 'jenis_kelamin') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='L'>L</option>";
	echo "<option value='P'>P</option>";
	echo "
	</select>
	</td>";
}
//Kontrak Ke
elseif ($pecah_column[$no] == 'kontrak_ke') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='1'>1</option>";
	echo "<option value='2'>2</option>";
	echo "
	</select>
	</td>";
}
//Jenis Kelamin
elseif ($pecah_column[$no] == 'status_pegawai' AND $address='?mod=hrddata/masterkaryawan') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='Aktif'>Aktif</option>";
	echo "<option value='Tidak Aktif'>Tidak Aktif</option>";
	echo "
	</select>
	</td>";

	echo "<td>";
	echo "Tanggal Tidak Aktif (opsional) ";
	echo "<input type='text' name='tanggal_tidak_aktif' value='$rows5[tanggal_tidak_aktif]' class='date'";
	echo "</td>";

	echo "<td>";
	echo "Alasan Tidak Aktif (opsional) ";
	echo "<input type='text' name='alasan_tidak_aktif' value='$rows5[alasan_tidak_aktif]'";
	echo "</td>";

	echo "<td>Keterangan Tidak Aktif (opsional) <textarea name='keterangan_tidak_aktif' rows='3' cols='30'>".$rows5[keterangan_tidak_aktif]."</textarea></td>";
}
//Status Nikah
elseif ($pecah_column[$no] == 'status_perkawinan') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='Kawin'>Kawin</option>";
	echo "<option value='Belum Kawin'>Belum Kawin</option>";
	echo "
	</select>
	</td>";
}
//Status Nikah
elseif ($pecah_column[$no] == 'sp') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='I'>I</option>";
	echo "<option value='II'>II</option>";
	echo "<option value='III'>III</option>";
	echo "
	</select>
	</td>";
}
//Status Nikah
elseif ($pecah_column[$no] == 'status_pkwtt' or $pecah_column[$no] == 'lanjut_kontrak' or $pecah_column[$no] == 'pemutusan_kontrak' or $pecah_column[$no] == 'id_card' or $pecah_column[$no] == 'status_vaksin2' or $pecah_column[$no] == 'status_vaksin' or $pecah_column[$no] == 'bersedia_keluar_kota' or $pecah_column[$no] == 'surat_pernyataan') {
	echo "<td>";
	if ($rows5[$pecah_column[$no]]=='v'){$checked='checked';}else{$checked='';}
	echo "<input type='checkbox' name='$pecah_column[$no]' value='v' $checked>";
echo "</td>";
}
//AGAMA
elseif ($pecah_column[$no] == 'agama') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='Islam'>Islam</option>";
	echo "<option value='Kristen'>Kristen</option>";
	echo "
	</select>
	</td>";
}
//STATUS KARYAWAN
elseif ($pecah_column[$no] == 'status_karyawan') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='PKWTT'>PKWTT</option>";
	echo "<option value='KONTRAK'>KONTRAK</option>";
	echo "
	</select>
	</td>";
}
//IJIN
elseif ($pecah_column[$no] == 'jenis_ijin') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='Cuti'>Cuti</option>";
	echo "<option value='Dokter'>Dokter</option>";
	echo "<option value='Alpa'>Alpa</option>";
	echo "<option value='Ijin'>Ijin</option>";
	echo "
	</select>
	</td>";
}
//PENDIDIKAN
elseif ($pecah_column[$no] == 'pendidikan_terakhir') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='SMP'>SMP</option>";
	echo "<option value='SMA/SMK'>SMA/SMK</option>";
	echo "<option value='D1'>D1</option>";
	echo "<option value='D2'>D2</option>";
	echo "<option value='D3'>D3</option>";
	echo "<option value='S1'>S1</option>";
	echo "<option value='S2'>S2</option>";
	echo "
	</select>
	</td>";
}
//BULAN PENGAJUAN
elseif ($pecah_column[$no] == 'bulan_pengajuan') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value='01'>Januari</option>";
	echo "<option value='02'>Februari</option>";
	echo "<option value='03'>Maret</option>";
	echo "<option value='04'>April</option>";
	echo "<option value='05'>Mei</option>";
	echo "<option value='06'>Juni</option>";
	echo "<option value='07'>Juli</option>";
	echo "<option value='08'>Agustus</option>";
	echo "<option value='09'>September</option>";
	echo "<option value='10'>Oktober</option>";
	echo "<option value='11'>November</option>";
	echo "<option value='12'>Desember</option>";
	echo "
	</select>
	</td>";
}
//Tahun Pengajuan
elseif ($pecah_column[$no] == 'tahun_pengajuan') {
	echo "
	<td><select class='comboyuk' name='$pecah_column[$no]'>";
	echo "<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	$now=date('Y')+2;
	for ($a=date('Y')-3;$a<=$now;$a++)
	 {echo "<option value='".$a."'>".$a."</option>";}
	 echo "</select></td>";
}
//PENDIDIKAN
elseif ($pecah_column[$no] == 'tahun_lulus' OR $pecah_column[$no] == 'tahun_pengajuan') {
	echo "
	<td><select class='comboyuk' name='$pecah_column[$no]'>";
	echo "<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	$now=date('Y')+0;
	for ($a=date('Y')-50;$a<=$now;$a++)
	 {echo "<option value='".$a."'>".$a."</option>";}
	 echo "</select></td>";
}
//No Invoice
elseif ($pecah_column[$no] == 'no_invoice') {
	$no_invoice_terpakai=ambil_variabel_kutip_satu_where(deliverycl_packinglist,no_invoice,"");
	$sql113="SELECT * FROM booking_invoice WHERE tanggal > '2021-01-01' AND no_invoice NOT IN ($no_invoice_terpakai) ORDER BY tanggal";
	$result113=mysql_query($sql113);
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "
	<option value='Backup'>Backup</option>";
		while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[no_invoice]'>$rows113[tanggal] | $rows113[no_invoice] | $rows113[dari]</option>";}

	$sql114="SELECT * FROM booking_invoice_turetur WHERE tanggal > '2021-04-01' AND no_invoice NOT IN ($no_invoice_terpakai) ORDER BY tanggal";
	$result114=mysql_query($sql114);
		while ($rows114=mysql_fetch_array($result114)) {
	echo "<option value='$rows114[no_invoice]'>$rows114[tanggal] | $rows114[no_invoice] | $rows114[dari]</option>";}

	echo "
	</select>
	</td>";
}
//NOMOR FAKTUR
elseif ($pecah_column[$no] == 'nomor_faktur') {
		echo "<td><input type='text' minlength='13' maxlength='13' name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."''></td>";
}
//Alamat
elseif ($pecah_column[$no] == 'keterangan_ijin' OR $pecah_column[$no] == 'alamat_ktp' OR $pecah_column[$no] == 'alamat_domisili' OR $pecah_column[$no] == 'alamat' OR $pecah_column[$no] == 'jenis_pelanggaran') {
		echo "<td><textarea name='$pecah_column[$no]' rows='3' cols='30'>".$rows5[$pecah_column[$no]]."</textarea></td>";
}
//ket_revisi
elseif ($pecah_column[$no] == 'ket_revisi') {
		echo "<input type='hidden' name='isian_revisi' value='$opsi_tambahan'>";
	if ($opsi_tambahan == 'revisi') {
		echo "<td><textarea name='$pecah_column[$no]' rows='3' cols='30'>".$rows5[$pecah_column[$no]]."</textarea></td>";
	}else {
		echo "<td><input type='hidden' name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</td>";
	}
}
//TAMPILAN SEBENARNYA
else{
echo "<td><input type='text' $format_tgl name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."' $disabled style='width:95%; border-radius:4px; text-align:center;' autocomplete='off' required></td>";
}
echo "</tr>";
$no++;}
	echo "</table><table>";
	echo "<tr><td><input type='image' src='modules/gambar/save.png' width='30' height'30' name='simpan' value='Simpan'>
				<input type='hidden' name='jenis' value='$opsi'>
				<input type='hidden' name='id' value='$rows5[id]'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'></td></form>";
	echo "<form method ='post' action='$address'>";
	echo "<td><input type='image' src='modules/gambar/back.png' width='30' height'30' name='kembali' value='kembali'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'></td></tr></form>";
	echo "</tr>";
	echo "</table>";


}else{//START ELSE OPSI ke TAMPILAN UTAMA
//Link tambah Data
$akses=ambil_database(akses,master_user,"email='$username'");
$id_menu=ambil_database(id,master_menu,"url='$address'");
$ada_tambah=ambil_database(tambah,master_akses,"id='$akses' AND tambah LIKE '%$id_menu%'");
$list_id=explode (",",$ada_tambah);
$jumlah_list_id=count($list_id);
$no=0;for($i=0; $i < $jumlah_list_id; ++$i){
  if ($list_id[$no]==$id_menu){$tampil_tambah=1;}else{$tampil_tambah=0;}
$total_tampil_tambah=$tampil_tambah+$total_tampil_tambah;
$no++;}
echo "<table><tr>";
if ($total_tampil_tambah=='1') {
	echo "<td>";
  echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("tambah","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/tambah.png' width='25px'/></a></br>";
	echo "</td>";
}


if ($address=='?mod=hrddata/masterkaryawan') {
echo "<td><form method ='POST' action='modules/hrddata/cetak/print_excel_master_karyawan.php' target='_blank'>";
echo "<input type='image' src='modules/gambar/save_excel.png' width='25' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$rows1[id]'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='nama_database1' value='$nama_database'>
			<input type='hidden' name='pilihan_tahun1' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan1' value='$pilihan_bulan'>
			<input type='hidden' name='pencarian1' value='$pencarian'>
			<input type='hidden' name='pilihan_pencarian1' value='$pilihan_pencarian'>
			<input type='hidden' name='address1' value='$address'>
			</form></td>";
			}

echo "</tr></table>";


				echo "<table class='tabel_utama' style='width:auto;'>";
				//HEADER TABEL
				echo "<thead>";
					echo "<th style=''><strong>No</strong></th>";
			$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
					$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column_header[$no]'";
					$result3=mysql_query($sql3);
					$rows3=mysql_fetch_array($result3);
					echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
			$no++;}
					//echo "<th colspan='3' style=''><strong>".ambil_database($bahasa,pusat_bahasa,"kode='valid'")."</strong></th>";
					echo "<th colspan='3' style=''><strong>".ambil_database($bahasa,pusat_bahasa,"kode='Opsi'")."</strong></th>";
				echo "</thead>";
				//HEADER END

				//ISI TABEL
				if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
				if ($pilihan_tahun=='All'){$pilihan_tahun2='20'; $pilihan_bulan2='';}else{$pilihan_tahun2=$pilihan_tahun; $pilihan_bulan2="-$pilihan_bulan";}
				if ($nama_database=='hrd_data_masakerja') {$tanggal_pencarian='tanggal'; $order_by='nama,urutan,kontrak_ke';}else{$tanggal_pencarian='tanggal'; $order_by='tanggal';}


//PAGING
$halaman = 50;
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT	* FROM $nama_database WHERE $tanggal_pencarian LIKE '%$pilihan_tahun2$pilihan_bulan2%' $if_pencarian");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT	* FROM $nama_database WHERE $tanggal_pencarian LIKE '%$pilihan_tahun2$pilihan_bulan2%' $if_pencarian ORDER BY $order_by DESC LIMIT $mulai, $halaman")or die(mysql_error);
$no =$mulai+1;
//PAGING
				while ($rows1=mysql_fetch_array($query)){
				$warnaGenap="white";$warnaGanjil="#CEF6F5";if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}
				echo "<tr>";
				echo "<td style='background-color:$color;'>$no</td>";
				$no_items=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
				//TAMPILAN TABEL - FOTO - MASTER MODEL
				if ($pecah_column_header[$no_items]=='foto' AND $address!='?mod=hrddata/masterkaryawan') {
					$nama_gambar_tampilan=$rows1[$pecah_column_header[$no_items]];
					echo "<td>";echo "<a href='modules/hrddata/gambarkaryawan/tampil_foto.php?gambar=$nama_gambar_tampilan' target='_blank'><img src='modules/hrddata/gambarkaryawan/$nama_gambar_tampilan' width='80px' height='100px'/></a>";echo "</td>";
				}
				//TAMPILAN TABEL - TOTAL USD - PO
				elseif ($pecah_column_header[$no_items]=='upah_pokok' OR $pecah_column_header[$no_items]=='upah_tunjangan') {
					echo "<td style='background-color:$color; white-space:nowrap;'>".rupiah($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//NPWP
				elseif ($pecah_column_header[$no_items]=='npwp') {
					echo "<td style='background-color:$color;'>".npwp($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//NPWP
				elseif ($pecah_column_header[$no_items]=='bulan_pengajuan') {
					echo "<td style='background-color:$color;'>".nama_bulan_only($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN
				elseif ($pecah_column_header[$no_items]=='sisa_cuti') {
					//TOTAL KONTRAK 1 & TOTAL KONTRAK 2
					$result_cuti=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows1[id]' AND tanggal BETWEEN '$rows1[kontrak_awal1]' AND '$rows1[kontrak_awal2]'");
					$total_cuti=mysql_num_rows($result_cuti);

					$result_cuti2=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows1[id]' AND tanggal BETWEEN '$rows1[kontrak_akhir1]' AND '$rows1[kontrak_akhir2]'");
					$total_cuti2=mysql_num_rows($result_cuti2);

					$total_asli2=$total_cuti+$total_cuti2;

					$sisa_cuti=$rows1[cuti]-$total_asli2;
					echo "<td style='background-color:$color;'>$sisa_cuti</td>";
				}
				//TAMPILAN
				elseif ($pecah_column_header[$no_items]=='umur'){
					echo "<td style='background-color:$color; white-space:nowrap;'>".selisih($rows1[tanggal_lahir])."</td>";
				}
				//TAMPILAN TANGGAL
				elseif ($pecah_column_header[$no_items]=='tanggal' AND $address=='?mod=hrddata/masterkaryawan'){
					echo "<td class='sticky-col zero-col' style='background-color:$color; white-space:nowrap;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				//TAMPILAN FOTO
				elseif ($pecah_column_header[$no_items]=='foto' AND $address=='?mod=hrddata/masterkaryawan'){
					$nama_gambar_tampilan=$rows1[$pecah_column_header[$no_items]];
					echo "<td class='sticky-col first-col'>";echo "<a href='modules/hrddata/gambarkaryawan/tampil_foto.php?gambar=$nama_gambar_tampilan' target='_blank'><img src='modules/hrddata/gambarkaryawan/$nama_gambar_tampilan' width='80px' height='100px'/></a>";echo "</td>";
				}
				//TAMPILAN TANGGAL
				elseif ($pecah_column_header[$no_items]=='nik' AND $address=='?mod=hrddata/masterkaryawan'){
					echo "<td class='sticky-col second-col' style='background-color:$color; white-space:nowrap;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				//TAMPILAN TANGGAL
				elseif ($pecah_column_header[$no_items]=='status_pegawai' AND $address=='?mod=hrddata/masterkaryawan'){
					echo "<td class='sticky-col three-col' style='background-color:$color; white-space:nowrap;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				//TAMPILAN TANGGAL
				elseif ($pecah_column_header[$no_items]=='nama' AND $address=='?mod=hrddata/masterkaryawan'){
					echo "<td class='sticky-col four-col' style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				//TAMPILAN TANGGAL
				elseif ($pecah_column_header[$no_items]=='tanggal_masuk' AND $address=='?mod=hrddata/masterkaryawan'){
					echo "<td class='sticky-col five-col' style='background-color:$color; white-space:nowrap;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				//TAMPILAN TANGGAL
				elseif ($pecah_column_header[$no_items]=='bagian' AND $address=='?mod=hrddata/masterkaryawan'){
					echo "<td class='sticky-col six-col' style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				//TAMPILAN
				elseif ($pecah_column_header[$no_items]=='lama_kontrak1' OR $pecah_column_header[$no_items]=='lama_kontrak2'){
					echo "<td style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]." Bulan</td>";
				}
				//TAMPILAN
				elseif ($pecah_column_header[$no_items]=='masa_kerja'){
					echo "<td style='background-color:$color; white-space:nowrap;'>".selisih($rows1[tanggal_masuk])."</td>";
				}
				//TAMPILAN
				elseif ($pecah_column_header[$no_items]=='upah_total'){
					$total_upah=$rows1[upah_pokok]+$rows1[upah_tunjangan];
					echo "<td style='background-color:$color; white-space:nowrap;'>".rupiah($total_upah)."</td>";
				}
				//TAMPILAN
				elseif ($pecah_column_header[$no_items]=='sp' AND $nama_database=='hrd_data_karyawan'){
					echo "<td style='background-color:$color; white-space:nowrap;'>";
						echo tampil_sp($rows1[id])."</br>";
					echo "</td>";
				}
				//CUTI YANG DIAMBIL
				elseif ($pecah_column_header[$no_items]=='cuti_yang_diambil' AND $nama_database=='hrd_data_karyawan'){
					//TOTAL KONTRAK 1 & TOTAL KONTRAK 2
					$result_cuti=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows1[id]' AND tanggal BETWEEN '$rows1[kontrak_awal1]' AND '$rows1[kontrak_awal2]'");
					$total_cuti=mysql_num_rows($result_cuti);

					$result_cuti2=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows1[id]' AND tanggal BETWEEN '$rows1[kontrak_akhir1]' AND '$rows1[kontrak_akhir2]'");
					$total_cuti2=mysql_num_rows($result_cuti2);

					$total_asli3=$total_cuti+$total_cuti2;

					echo "<td style='background-color:$color; white-space:nowrap;'>";
						echo "$total_asli3";
					echo "</td>";
				}
				//TAMPILAN
				elseif ($pecah_column_header[$no_items]=='sp' AND $nama_database=='hrd_data_masakerja'){
					$kontrak_tahun_kesatu=$rows1[kontrak_awal1];
					$jatuh_tempo_kontrak_kesatu=$rows1[kontrak_awal1];
					$perpanjang_kontrak_kedua=$rows1[kontrak_akhir1];
					$jatuh_tempo_kontrak_kedua=$rows1[kontrak_akhir2];

					if ($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua=='0000-00-00' AND $jatuh_tempo_kontrak_kedua=='0000-00-00') {
						$result=mysql_query("SELECT * FROM hrd_data_sp WHERE tanggal_berakhir_sp BETWEEN '$kontrak_tahun_kesatu' AND '$jatuh_tempo_kontrak_kesatu' AND id_pegawai='$rows1[id_pegawai]'");
						$total_hari=mysql_num_rows($result);
					}elseif($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua!='0000-00-00' AND $jatuh_tempo_kontrak_kedua!='0000-00-00') {
						$result=mysql_query("SELECT * FROM hrd_data_sp WHERE tanggal_berakhir_sp BETWEEN '$perpanjang_kontrak_kedua' AND '$jatuh_tempo_kontrak_kedua' AND id_pegawai='$rows1[id_pegawai]'");
						$total_hari=mysql_num_rows($result);
					}else{
						$total_hari='0';
					}
					echo "<td style='background-color:$color; white-space:nowrap;'>$total_hari</td>";

				}
				//IJIN
				elseif ($pecah_column_header[$no_items]=='dokter' AND $nama_database=='hrd_data_masakerja'){
									$kontrak_tahun_kesatu=$rows1[kontrak_tahun_kesatu];
									$jatuh_tempo_kontrak_kesatu=$rows1[jatuh_tempo_kontrak_kesatu];
									$perpanjang_kontrak_kedua=$rows1[perpanjang_kontrak_kedua];
									$jatuh_tempo_kontrak_kedua=$rows1[jatuh_tempo_kontrak_kedua];

									if ($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua=='0000-00-00' AND $jatuh_tempo_kontrak_kedua=='0000-00-00') {
										$result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$kontrak_tahun_kesatu' AND '$jatuh_tempo_kontrak_kesatu' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Dokter'");
										$total_hari=mysql_num_rows($result);
									}elseif($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua!='0000-00-00' AND $jatuh_tempo_kontrak_kedua!='0000-00-00') {
										$result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$perpanjang_kontrak_kedua' AND '$jatuh_tempo_kontrak_kedua' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Dokter'");
										$total_hari=mysql_num_rows($result);
									}else{
										$total_hari='0';
									}
									echo "<td style='background-color:$color; white-space:nowrap;'>$total_hari</td>";
				}
				//IJIN
				elseif ($pecah_column_header[$no_items]=='cuti' AND $nama_database=='hrd_data_masakerja'){
								  $kontrak_tahun_kesatu=$rows1[kontrak_tahun_kesatu];
								  $jatuh_tempo_kontrak_kesatu=$rows1[jatuh_tempo_kontrak_kesatu];
								  $perpanjang_kontrak_kedua=$rows1[perpanjang_kontrak_kedua];
								  $jatuh_tempo_kontrak_kedua=$rows1[jatuh_tempo_kontrak_kedua];

								  if ($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua=='0000-00-00' AND $jatuh_tempo_kontrak_kedua=='0000-00-00') {
								    $result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$kontrak_tahun_kesatu' AND '$jatuh_tempo_kontrak_kesatu' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Cuti'");
								    $total_hari=mysql_num_rows($result);
								  }elseif($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua!='0000-00-00' AND $jatuh_tempo_kontrak_kedua!='0000-00-00') {
								    $result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$perpanjang_kontrak_kedua' AND '$jatuh_tempo_kontrak_kedua' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Cuti'");
								    $total_hari=mysql_num_rows($result);
								  }else{
								    $total_hari='0';
								  }
								  echo "<td style='background-color:$color; white-space:nowrap;'>$total_hari</td>";
				}
				//IJIN
				elseif ($pecah_column_header[$no_items]=='alpa' AND $nama_database=='hrd_data_masakerja'){
								  $kontrak_tahun_kesatu=$rows1[kontrak_tahun_kesatu];
								  $jatuh_tempo_kontrak_kesatu=$rows1[jatuh_tempo_kontrak_kesatu];
								  $perpanjang_kontrak_kedua=$rows1[perpanjang_kontrak_kedua];
								  $jatuh_tempo_kontrak_kedua=$rows1[jatuh_tempo_kontrak_kedua];

								  if ($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua=='0000-00-00' AND $jatuh_tempo_kontrak_kedua=='0000-00-00') {
								    $result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$kontrak_tahun_kesatu' AND '$jatuh_tempo_kontrak_kesatu' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Alpa'");
								    $total_hari=mysql_num_rows($result);
								  }elseif($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua!='0000-00-00' AND $jatuh_tempo_kontrak_kedua!='0000-00-00') {
								    $result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$perpanjang_kontrak_kedua' AND '$jatuh_tempo_kontrak_kedua' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Alpa'");
								    $total_hari=mysql_num_rows($result);
								  }else{
								    $total_hari='0';
								  }
								  echo "<td style='background-color:$color; white-space:nowrap;'>$total_hari</td>";
				}
				//IJIN
				elseif ($pecah_column_header[$no_items]=='ijin' AND $nama_database=='hrd_data_masakerja'){
									$kontrak_tahun_kesatu=$rows1[kontrak_tahun_kesatu];
									$jatuh_tempo_kontrak_kesatu=$rows1[jatuh_tempo_kontrak_kesatu];
									$perpanjang_kontrak_kedua=$rows1[perpanjang_kontrak_kedua];
									$jatuh_tempo_kontrak_kedua=$rows1[jatuh_tempo_kontrak_kedua];

									if ($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua=='0000-00-00' AND $jatuh_tempo_kontrak_kedua=='0000-00-00') {
										$result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$kontrak_tahun_kesatu' AND '$jatuh_tempo_kontrak_kesatu' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Ijin'");
										$total_hari=mysql_num_rows($result);
									}elseif($kontrak_tahun_kesatu!='0000-00-00' AND $jatuh_tempo_kontrak_kesatu!='0000-00-00' AND $perpanjang_kontrak_kedua!='0000-00-00' AND $jatuh_tempo_kontrak_kedua!='0000-00-00') {
										$result=mysql_query("SELECT * FROM hrd_data_absensi WHERE tanggal BETWEEN '$perpanjang_kontrak_kedua' AND '$jatuh_tempo_kontrak_kedua' AND id_pegawai='$rows1[id_pegawai]' AND jenis_ijin='Ijin'");
										$total_hari=mysql_num_rows($result);
									}else{
										$total_hari='0';
									}
									echo "<td style='background-color:$color; white-space:nowrap;'>$total_hari</td>";
				}
        //TAMPILAN NORMAT TABEL
				else {
					echo "<td style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				$no_items++;}


				//ISI PEMBEDA VALID DAN STATUS
					if ($validasi=='ya' AND $rows1[validasi] == '' AND $nama_database=='') {
							echo "<td colspan='3' style='background-color:$color;'>";
							echo '<form method="POST" action="'.$address.'" onsubmit="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_valid'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\');">';
							echo "<input type='submit' name='valid' value='Valid'>
										<input type='hidden' name='halaman' value='$nomor_halaman'>
										<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
										<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
										<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
										<input type='hidden' name='pencarian' value='$pencarian'>
										<input type='hidden' name='id' value='$rows1[id]'></form>";
						echo "</td>";
					}else{
						//echo "<td colspan='3' style='background-color:$color;'><strong>$rows1[validasi] by $rows1[validasi_by]</strong></td>";
					}
				//ISI PEMBEDA VALID DAN STATUS



				//OPSI
				if ($rows1[validasi] == '') {
						if ($nama_database == ''){}else{
							echo "<td style='text-align: center; background-color: white; border-top-left-radius: 10px; border-bottom-left-radius: 10px;'><center>";
							echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("edit","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/edit.png' width='25px'/></a>";
							echo "</td>";}
			 }else{}//echo "<td style='width:10 background-color:$color;'></td>";

				if ($nama_database == 'hrd_payroll_bagian' OR $nama_database == 'hrd_data_karyawan' OR $nama_database == 'hrd_data_sp' OR $nama_database == 'hrd_data_masakerja' OR $nama_database == 'hrd_data_absensi'){}else{
					echo "<td style='text-align: center; background-color: white;'><center>";
					echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/item.png' width='25px'/></a>";
					echo "</td>";
				}

				if ($rows1[validasi] == '') {
							if ($nama_database == 'deliverycl_invoice'){}else{
									echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
									echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
									echo "</center></td>";}
							}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $terjadi_revisi_khusus_spk == 'yes'){
							if ($nama_database == 'deliverycl_invoice'){}else{
									echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
									echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
									echo "</center></td>";}
							}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $nama_database == 'hrd_data_karyawan' OR
							 $rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $nama_database == 'hrd_data_pengajuan_kontrak'){
				echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
				echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_revisi'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("edit","XblImpl1!A@")."&opsi_tambahan=revisi&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/revisi.png" width="25px"/></a>';
				echo "</center></td>";}else{}//echo "<td style='background-color:$color;'></td>";
				echo "</tr>";
				$no++;}
				//ISI TABEL END
				echo "</table>";//TABEl END

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
		 <td><input type='submit' value='".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END

}//END OPSI
return;}


//END?>
