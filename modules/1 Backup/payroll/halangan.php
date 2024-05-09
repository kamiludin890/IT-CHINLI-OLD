<?php global $mod;
	$mod='payroll/halangan';
function editmenu(){extract($GLOBALS);}

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

function jumlahhari($month,$year){
$hai = date('t', mktime(0, 0, 0, $month, 1, $year));
return $hai;}

function datediff($tgl1, $tgl2){
$tgl1 = strtotime($tgl1);
$tgl2 = strtotime($tgl2);
$diff_secs = abs($tgl1 - $tgl2);
$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
}

function home(){extract($GLOBALS);
	echo kalender();
	echo combobox();
	include 'style.css';

	echo "<head>
	<style>
	table tr:hover td {
		background: #f2f2f2;
		background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(orange));
		background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
	}
	</style>
	</head>";

	//AMBIL POST UTAMA START
	$pilihan_departement=$_POST['pilihan_departement'];
	$pilihan_bagian=$_POST['pilihan_bagian'];
	//AMBIL POST UTAMA END


	//Pilihan Departement & Bagian START
	echo "<h2><center>Data Absensi Karyawan</center></h2>";
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Halangan'>
	<tr>
	<td width='60px' valign='top'>Departement</td>
	<td>:</td>
	<td valign='top'>
	 <select name='pilihan_departement' style='width:auto'>";
	 $sql113="SELECT Departement FROM payroll_pilihan ORDER BY urut";
	 $result113=mysql_query($sql113);
  	 echo "<option value='$pilihan_departement'>".$pilihan_departement."</option>";
	 while ($rows113=mysql_fetch_array($result113)) {
	   echo "<option value='$rows113[Departement]'>".$rows113[Departement]."</option>";}
	echo "
	</select>
	</td>
	</tr>";
	if ($pilihan_departement) {
	echo "
	<tr>
	<td>Bagian</td>
	<td>:</td>
	<td><select name='pilihan_bagian' class='comboyuk'>
		 <option value='$pilihan_bagian'>".$pilihan_bagian."</option>";
	$sql1="SELECT bagian FROM payroll_jamkerja WHERE departement='$pilihan_departement' ORDER by urut";
	$result1=mysql_query($sql1);
	while ($rows1=mysql_fetch_array($result1)) {
		 echo "<option value='$rows1[bagian]'>".$rows1[bagian]."</option>";}
	echo "
	</td>
	</tr>
	<tr>";}
	echo "
	 <td><input type='submit' value='Tampil'></td>
	</tr>
	</form>
	</table>
	</br>";
	//Pilihan Departement & Bagian END

//Jika Bagian Sudah Di Pilih
	if ($pilihan_bagian) {
	//AMBIL POST KEDUA START
	$pilihan_bulan=$_POST['pilihan_bulan'];
	$pilihan_tahun=$_POST['pilihan_tahun'];
	$pencarian=$_POST['pencarian'];
	//AMBIL POST KEDUA END

	//Pilihan TANGGAL & TAHUN START
	echo "<table>
	<form method ='post' action='?menu=home&mod=payroll/Halangan'>
	<tr>
	 <td>Bulan</td>
	 <td>:</td>
	 <td><select name='pilihan_bulan'>
			<option value='$pilihan_bulan'>".$pilihan_bulan."</option>
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
	 <td>Tahun</td>
	 <td>:</td>
	 <td><select name='pilihan_tahun'>
			<option value='$pilihan_tahun'>".$pilihan_tahun."</option>
			<option value='2020'>2020</option>
			<option value='2021'>2021</option>
			<option value='2022'>2022</option>
			<option value='2023'>2023</option>
	 </td>
	 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
	 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
	 <td><input type='submit' value='Tampil'></td>
	</tr>
	</form>
	</table>
	</br>";
	//Pilihan TANGGAL & TAHUN END

	//Pencarian START
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Halangan'>
	<tr>
	 <td>Cari</td>
	 <td>:</td>
	 <td><input type='text' name='pencarian' value='$pencarian'></td>
	</tr>
	 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
 	 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
 	 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
 	 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
	</form>
	</table>
	</br>";
	//Pencarian END

	//Tabel Pertama Start
	echo "<h2>Data Absensi $pilihan_bagian</h2>";

	//AMBIL POST KETIGA START
	$insert_edit=$_POST['insert_edit'];

	$insert_or_edit=$_POST['insert_or_edit'];
	$new=$_POST['new'];
	$id_absensi=$_POST['id_absensi'];
	$warna_pilih=$_POST['warna_pilih'];
	$data_terhapus=$_POST['data_terhapus'];

	$nomor_id=$_POST['nomor_id'];
	$tanggal=$_POST['tanggal'];
	$hari=ambilhari($tanggal);
	$jam_masuk=$_POST['jam_masuk'];
	$jam_pulang=$_POST['jam_pulang'];
	$scan_masuk=$_POST['scan_masuk'];
	$scan_pulang=$_POST['scan_pulang'];
	$terlambat=$_POST['terlambat'];
	$pulang_cepat=$_POST['pulang_cepat'];
	$lembur=$_POST['lembur'];
	$jumlah_kehadiran=$_POST['jumlah_kehadiran'];
	$status=$_POST['status'];
	$uang_makan=$_POST['uang_makan'];
	$shift=$_POST['shift'];
	//AMBIL POST KETIGA END


if ($insert_or_edit) {
$sql3="SELECT nik,nama,departement,bagian,jam_kerja FROM payroll_data_karyawan WHERE nomor_id='$nomor_id'";
$result3=mysql_query($sql3);
$rows3=mysql_fetch_array($result3);

if ($insert_or_edit=='insert') {

$sql4="SELECT nomor_id,tanggal FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal='$tanggal'";
$result4=mysql_query($sql4);
$rows4=mysql_fetch_array($result4);
$tanggal_penentu=$rows4['tanggal'];
if ($tanggal_penentu) {
echo "<table><tr><td style=background-color:#FFFF00;>Maaf Tanggal $tanggal_penentu Telah Ada Sebelumnya</td></tr></table></br>";
}else {
$mulai="INSERT INTO payroll_absensi SET
shift='$shift',
uang_makan='$uang_makan',
jumlah_kehadiran='$jumlah_kehadiran',
departement='$pilihan_departement',
bagian='$pilihan_bagian',
nomor_id='$nomor_id',
nik='$rows3[nik]',
nama='$rows3[nama]',
tanggal='$tanggal',
hari='$hari',
jam_kerja='$rows3[jam_kerja]',
jam_masuk='$jam_masuk',
jam_pulang='$jam_pulang',
scan_masuk='$scan_masuk',
scan_pulang='$scan_pulang',
terlambat='$terlambat',
pulang_cepat='$pulang_cepat',
lembur='$lembur',
status='$status'";
$eksekusi=mysql_query($mulai);}}

if ($insert_or_edit=='edit') {
$mulai="UPDATE payroll_absensi SET
shift='$shift',
uang_makan='$uang_makan',
jumlah_kehadiran='$jumlah_kehadiran',
nomor_id='$nomor_id',
nik='$rows3[nik]',
nama='$rows3[nama]',
tanggal='$tanggal',
hari='$hari',
jam_kerja='$rows3[jam_kerja]',
jam_masuk='$jam_masuk',
jam_pulang='$jam_pulang',
scan_masuk='$scan_masuk',
scan_pulang='$scan_pulang',
terlambat='$terlambat',
pulang_cepat='$pulang_cepat',
lembur='$lembur',
status='$status' WHERE id='$id_absensi'";
$eksekusi=mysql_query($mulai);}

if ($insert_or_edit=='delete') {echo "$data_terhapus - Telah Terhapus";
$mulai="DELETE FROM payroll_absensi WHERE id='$id_absensi'";
$eksekusi=mysql_query($mulai);}
}


	if ($insert_edit) {
		//TUTUP START
		echo "
		<table>
		<form method ='post' action='?menu=home&mod=payroll/Halangan'>
		<tr>
		<td>
		 <input type='submit' name='submit' value='close'>
		 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
		 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
		 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		</form>
		</td></tr></table></br>";
		//TUTUP END

if ($insert_edit=='delete'){}else {
		echo "
		<strong>KOLOM TANGGAL, SHIFT, JAM MASUK, JAM PULANG, SCAN MASUK, SCAN PULANG, TERLAMBAT, PULANG CEPAT, LEMBUR, JUMLAH KEHADIRAN, STATUS WAJIB DI ISI.</strong>
		<table style='background-color:white;' class='tabel_utama' width=120% align=center border=1>
		<thead style='background-color:#C0C0C0;'>
		<th align=center width=auto>Pegawai</th>
		<th align=center width=auto>Tanggal</th>
		<th align=center width=auto>Shift</th>
		<th align=center width=auto>Jam Masuk</th>
		<th align=center width=auto>Jam Pulang</th>
		<th align=center width=auto>Scan Masuk</th>
		<th align=center width=auto>Scan Pulang</th>
		<th align=center width=auto>Terlambat</th>
		<th align=center width=auto>Pulang Cepat</th>
		<th align=center width=auto>Lembur</th>
		<th align=center width=auto>Jumlah Kehadiran</th>
		<th align=center width=auto>Status</th>
		<th align=center width=auto>Uang Makan</th>
		</thead>";



		$sql14="SELECT * FROM payroll_absensi WHERE id='$id_absensi'";
		$result14=mysql_query($sql14);
		$rows14=mysql_fetch_array($result14);

		//Skrip Tambahan Kalender
			echo "
			<iframe width=174 height=189 name='gToday:normal:agenda.js' id='gToday:normal:agenda.js' src='modules/payroll/calender/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;'>
			</iframe>";
		//Skrip Tambahan Kalender

		echo "
		<form method ='post' action='?menu=home&mod=payroll/Halangan' name='forminputtanggal' enctype='multipart/form-data'>
		<tr>
		<td align=center><select name='nomor_id' class='comboyuk'>
			<option value='$rows14[nomor_id]'>".$rows14['nik']." ".$rows14['nama']."</option>";
				$sql2="SELECT nomor_id,nik,nama FROM payroll_data_karyawan WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian'";
				$result2=mysql_query($sql2);
			echo "<option value=''></option>";
				while ($rows2=mysql_fetch_array($result2)) {
			echo "
			<option value='$rows2[nomor_id]'>".$rows2['nik']." ".$rows2['nama']."</option>";}
			echo "</select></td>";

			echo "
			<td style='width:14%'><input name='tanggal' value='$rows14[tanggal]' size='10'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.tanggal);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>
			<td align=center><select name='shift'>
			  <option value='$rows14[shift]'>$rows14[shift]</option>
				<option value='Shift 1'>Shift 1</option>
				<option value='Shift 2'>Shift 2</option>
			  <option value='Shift 3'>Shift 3</option></select>
			</td>
			<td align=center><input type='text' style='width:51px;' name='jam_masuk' value='$rows14[jam_masuk]'></td>
			<td align=center><input type='text' style='width:51px;' name='jam_pulang' value='$rows14[jam_pulang]'></td>
			<td align=center><input type='text' style='width:51px;' name='scan_masuk' value='$rows14[scan_masuk]'></td>
			<td align=center><input type='text' style='width:51px;' name='scan_pulang' value='$rows14[scan_pulang]'></td>
			<td align=center><input type='text' style='width:51px;' name='terlambat' value='$rows14[terlambat]'></td>
			<td align=center><input type='text' style='width:51px;' name='pulang_cepat' value='$rows14[pulang_cepat]'></td>
			<td align=center><input type='text' style='width:51px;' name='lembur' value='$rows14[lembur]'></td>
			<td align=center><input type='text' style='width:51px;' name='jumlah_kehadiran' value='$rows14[jumlah_kehadiran]'></td>
			<td align=center><select name='status'>
			  <option value='$rows14[status]'>$rows14[status]</option>
				<option value=''></option>
				<option value='SETENGAH HARI'>SETENGAH HARI</option>
				<option value='CUTI'>CUTI</option>
			  <option value='IJIN'>IJIN</option>
			  <option value='MANGKIR'>MANGKIR</option>
			  <option value='DOKTER'>DOKTER</option>
			  <option value='DISPENSASI'>DISPENSASI</option></select>
			</td>
			<td align=center><select name='uang_makan'>
			  <option value='$rows14[uang_makan]'>$rows14[uang_makan]</option>
				<option value='Ya'>Ya</option>
			  <option value='Tidak'>Tidak</option></select>
			</td>
			</tr>

		<input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
		<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
		<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
 	  <input type='hidden' name='pencarian' value='$pencarian'>
 	  <input type='hidden' name='new' value='$insert_edit'>
 	  <input type='hidden' name='id_absensi' value='$id_absensi'>
 	  <input type='hidden' name='insert_or_edit' value='$insert_edit'>
		</table>
		<table>
		<tr>
			<td><input type='submit' name='' value='Simpan'></td>
		</tr>
		</form>
		</table></br>";}

	}else {
	//TAMBAH START
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Halangan'>
	<tr>
	<td>
	 <input type='submit' name='submit' value='Insert'>
	 <input type='hidden' name='insert_edit' value='insert'>
	 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
	 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
	 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
	 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
	 <input type='hidden' name='pencarian' value='$pencarian'>
	</form>
	</td>";
	//TAMBAH END

	//EDIT START
	echo "
	<form method ='post' action='?menu=home&mod=payroll/Halangan'>
	<td>
	 <input type='submit' name='submit' value='Edit'>
	 <input type='hidden' name='insert_edit' value='edit'>
	 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
	 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
	 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
	 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
	 <input type='hidden' name='pencarian' value='$pencarian'>
	</form>
	</td>
	</br>";

	//DELETE START
	echo "
	<form method ='post' action='?menu=home&mod=payroll/Halangan'>
	<td>
	 <input type='submit' name='submit' value='Delete'>
	 <input type='hidden' name='insert_edit' value='delete'>
	 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
	 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
	 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
	 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
	 <input type='hidden' name='pencarian' value='$pencarian'>
	</form>
	</td>
	</tr>
	</table>
	</br>";
}
	//EDIT END
	if ($insert_edit=='edit' OR $insert_edit=='delete') {
		$edit_tampil1="<th align=center width=auto></th>";}

	echo "
	<table class='tabel_utama' width=120% align=center >
	<thead style='background-color:#C0C0C0;'>
	$edit_tampil1
	<th align=center width=auto>No</th>
	<th align=center width=auto>Nomor ID</th>
	<th align=center width=auto>Nik</th>
	<th align=center width=auto>Nama</th>
	<th align=center width=auto>Tanggal</th>
	<th align=center width=auto>Hari</th>
	<th align=center width=auto>Shift</th>
	<th align=center width=auto>Jam Kerja</th>
	<th align=center width=auto>Jam Masuk</th>
	<th align=center width=auto>Jam Pulang</th>
	<th align=center width=auto>Scan Masuk</th>
	<th align=center width=auto>Scan Pulang</th>
	<th align=center width=auto>Terlambat</th>
	<th align=center width=auto>Pulang Cepat</th>
	<th align=center width=auto>Lembur</th>
	<th align=center width=auto>Jumlah Kehadiran</th>
	<th align=center width=auto>Departement</th>
	<th align=center width=auto>Bagian</th>
	<th align=center width=auto>Status</th>
	<th align=center width=auto>Uang Makan</th>
	<th align=center width=auto>Sisa Cuti</th>
	</thead>";

		if ($_POST['pencarian']) {
	$if_pencarian=" AND nomor_id LIKE '%$pencarian%' OR nik LIKE '%$pencarian%' OR nama LIKE '%$pencarian%' OR tanggal LIKE '%$pencarian%' OR jam_kerja LIKE '%$pencarian%' OR jam_masuk LIKE '%$pencarian%' OR jam_pulang LIKE '%$pencarian%' OR scan_masuk LIKE '%$pencarian%' OR scan_pulang LIKE '%$pencarian%' OR terlambat LIKE '%$pencarian%' OR pulang_cepat LIKE '%$pencarian%' OR lembur LIKE '%$pencarian%' OR bagian LIKE '%$pencarian%' OR status LIKE '%$pencarian%'";}

	$sql13="SELECT * FROM payroll_absensi WHERE bagian='$pilihan_bagian' AND  tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND departement='$pilihan_departement' $if_pencarian ORDER BY nomor_id,tanggal";
	$result13=mysql_query($sql13);
	$no=1;
	while ($rows13=mysql_fetch_array($result13)) {

	if ($insert_edit=='edit') {
		$edit_tampil="
		<form method ='post' action='?menu=home&mod=payroll/Halangan'>
		<td align=center>
		 <input type='image' src='modules/gambar/edit.png' width='30' height'30'  name='submit' value='Pilih'>
		 <input type='hidden' name='insert_edit' value='edit'>
		 <input type='hidden' name='warna_pilih' value='warna_pilih'>
		 <input type='hidden' name='id_absensi' value='$rows13[id]'>
		 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
		 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
		 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		</form>
		</td>";
	}

	if ($insert_edit=='delete') {
		$edit_tampil="
		<form method ='post' action='?menu=home&mod=payroll/Halangan'>
		<td align=center>
		 <input type='image' src='modules/gambar/delete.png'input type='image' src='modules/gambar/delete.png' width='30' height'30'  name='submit' value='Hapus'>
		 <input type='hidden' name='insert_edit' value='delete'>
		 <input type='hidden' name='insert_or_edit' value='delete'>
		 <input type='hidden' name='data_terhapus' value='".$rows13[tanggal]." ".$rows13[nik]." ".$rows13[nama]."'>
		 <input type='hidden' name='id_absensi' value='$rows13[id]'>
		 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
		 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
		 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		</form>
		</td>";
	}

	$warnaGenap="#FFFFF";
	$warnaGanjil="#CEF6F5";
	if ($no % 2 == 0){
		$color = $warnaGenap;
		$color5 = $warnaGenap;
	}else{
		$color = $warnaGanjil;
		$color5 = $warnaGanjil;
	}
	if ($rows13['scan_masuk'] != '00:00:00'){$color1=$color;}else{$color1='#F08080';}
	if ($rows13['scan_pulang'] != '00:00:00'){$color2=$color;}else{$color2='#F08080';}
	if ($rows13['terlambat'] != '00:00:00'){$color3='#FFFF00';}else{$color3=$color;}
	if ($rows13['pulang_cepat'] != '00:00:00'){$color4='#FFFF00';}else{$color4=$color;}
	if ($rows13['jam_masuk'] != '00:00:00'){$color5=$color;}else{$color5='#F08080';}
	if ($rows13['jam_pulang'] != '00:00:00'){$color6=$color;}else{$color6='#F08080';}
	if ($new != '' AND $tanggal != '' AND $nomor_id != '') {
		if ($tanggal_penentu){}else{
		if ($rows13['tanggal'] == $tanggal AND $rows13['nomor_id'] == $nomor_id){$color5='#00FFFF'; if($new=='insert'){$tanda="New..!!!";}else{$tanda="Update..!!!";}}else{$color5=$color; $tanda='';}}}
	if ($warna_pilih){
		if ($rows13['id']==$id_absensi){$color5='yellow';}else{$color5=$color;}
	}

	if ($rows13[shift]) {$color7=$color; $shift1=$rows13[shift];}else{$color7=red; $shift1="Mohon Diisi !";}

	echo "
	<tr>
	$edit_tampil
	<td style=background-color:$color; border='1' height='20px' align=center>$no</td>
	<td style=background-color:$color5; align=center>$rows13[nomor_id]</td>
	<td style=background-color:$color5; align=center>$rows13[nik]</td>
	<td style=background-color:$color5; align=center>$rows13[nama]</td>
	<td style=background-color:$color5; align=center><strong>".$rows13['tanggal']." ".$tanda."</strong></td>
	<td style=background-color:$color; align=center>$rows13[hari]</td>
	<td style=background-color:$color7; align=center>$shift1</td>
	<td style=background-color:$color; align=center>$rows13[jam_kerja]</td>
	<td style=background-color:$color5; align=center>$rows13[jam_masuk]</td>
	<td style=background-color:$color6; align=center>$rows13[jam_pulang]</td>
	<td style=background-color:$color1; align=center>$rows13[scan_masuk]</td>
	<td style=background-color:$color2; align=center>$rows13[scan_pulang]</td>
	<td style=background-color:$color3; align=center>$rows13[terlambat]</td>
	<td style=background-color:$color4; align=center>$rows13[pulang_cepat]</td>
	<td style=background-color:$color; align=center>$rows13[lembur]</td>
	<td style=background-color:$color; align=center>$rows13[jumlah_kehadiran]</td>
	<td style=background-color:$color; align=center>$rows13[departement]</td>
	<td style=background-color:$color; align=center>$rows13[bagian]</td>
	<td style=background-color:$color; align=center>$rows13[status]</td>
	<td style=background-color:$color; align=center>$rows13[uang_makan]</td>";

//Sisa Cuti
	$sql15="SELECT id FROM payroll_data_karyawan WHERE nomor_id='$rows13[nomor_id]'";
	$result15= mysql_query($sql15);
	$rows15=mysql_fetch_array($result15);
	$sql17="SELECT awal_masuk,total_cuti,mulai_kontrak,selesai_kontrak FROM payroll_cuti_tahunan WHERE induk='$rows15[id]'";
	$result17= mysql_query($sql17);
	$rows17=mysql_fetch_array($result17);

	$awal_masuk=$rows17['awal_masuk'];

	$tgl1=$awal_masuk;
	$tgl2=date("Y-m-d");
	$a = datediff($tgl1, $tgl2);
	//	echo $a[years]."</br>";
	$jumlah_tahun=$a[years];
	if ($a[years] == 1) {
		$tahun_pertama = $awal_masuk;
		$tahun_kedua = date('Y-m-d', strtotime('+1 years', strtotime($awal_masuk)));}
	if ($a[years] > 1) {
		$jumlah_tahun_dikurang_satu=$jumlah_tahun-1;
		$tahun_pertama = date('Y-m-d', strtotime("+$jumlah_tahun_dikurang_satu years", strtotime($awal_masuk)));
		$tahun_kedua = date('Y-m-d', strtotime("+$jumlah_tahun years", strtotime($awal_masuk)));}

	$sql16="SELECT status FROM payroll_absensi WHERE nomor_id='$rows13[nomor_id]' AND status='CUTI' AND tanggal BETWEEN '$tahun_pertama' AND '$tahun_kedua'";
	$result16= mysql_query($sql16);
	$count_header=mysql_num_rows($result16);
	$sisa_cuti=$rows17[total_cuti]-$count_header;

	echo "
	<td colspan=1; style=background-color:$color; align=center>$sisa_cuti</td>
	</tr>";
	$no++;}
	echo "</table>";
//Tabel Pertama END

}//Jika Bagian Sudah Di Pilih

}//END HOME
//END PHP?>
