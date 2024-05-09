<?php global $mod;
	$mod='payroll/absensi';
function editmenu(){extract($GLOBALS);}

function jumlahhari($month,$year){
$hai = date('t', mktime(0, 0, 0, $month, 1, $year));
return $hai;}

function home(){extract($GLOBALS);
	include 'style.css';

	echo "<head>
	<style>
	table tr:hover td {
		background: #f2f2f2;
		background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(yellow));
		background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
	}
	</style>
	</head>";


//Pilih Import Start
echo "<form method='post' enctype='multipart/form-data' action='?menu=home&mod=payroll/Absensi'>
			Format Excel adalah .xls
			<input name='pelengkap' type='file' required='required'></br></br>
			<input type='hidden' name='submit' value='submit'>
			<input name='upload' type='submit' value='Import'>
			</form>";
//Pilih Import End

//PROSES IMPORT START
if ($_POST['submit']) {

	//Pilih Kembali Start
	echo "</br><form method='POST' action='?menu=home&mod=payroll/Absensi'>
				<input name='' type='submit' value='Kembali'>
				</form>";
	//Pilih Kembali End

	include 'excel_reader2.php';
	// upload file xls
	$target = basename($_FILES['pelengkap']['name']) ;
	move_uploaded_file($_FILES['pelengkap']['tmp_name'], $target);
	// beri permisi agar file xls dapat di baca
	chmod($_FILES['pelengkap']['name'],0777);
	// mengambil isi file xls
	$data = new Spreadsheet_Excel_Reader($_FILES['pelengkap']['name'],false);
	// menghitung jumlah baris data yang ada
	$jumlah_baris = $data->rowcount($sheet_index=0);
	// jumlah default data yang berhasil di import

	$berhasil = 0;
	for ($i=2; $i<=$jumlah_baris; $i++){
		// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
		$nomor_id=$data->val($i, 2);//
		$nik=$data->val($i, 3);//
		$tanggal=$data->val($i, 6);//
		$jam_masuk=$data->val($i, 8);//
		$jam_pulang=$data->val($i, 9);//
		$scan_masuk=$data->val($i, 10);//
		$scan_pulang=$data->val($i, 11);//
		$terlambat=$data->val($i, 14);//
		$pulang_cepat=$data->val($i, 15);//
		$lembur=$data->val($i, 17);//
		$jumlah_kehadiran=$data->val($i, 26);//
			$tgl = substr($tanggal,0,2);
			$bln = substr($tanggal,3,2);
			$thn = substr($tanggal,6,4);
			$tanggal_sebenarnya="$thn-$bln-$tgl";
		$hari=ambilhari($tanggal_sebenarnya);

		$sql1="SELECT jam_kerja,departement,bagian,nama FROM payroll_data_karyawan WHERE nomor_id='$nomor_id'";
		$result1=mysql_query($sql1);
		$rows1=mysql_fetch_array($result1);
		$jam_kerja=$rows1['jam_kerja'];//
		$departement=$rows1['departement'];//
		$bagian=$rows1['bagian'];//
		$nama=$rows1['nama'];//

		//START PENENTU SHIFT
		$sql4="SELECT shift FROM payroll_jamkerjaitems WHERE departement='$departement' AND bagian='$bagian' AND jam_masuk='$jam_masuk:00'";
		$result4=mysql_query($sql4);
		$rows4=mysql_fetch_array($result4);
		$shift=$rows4['shift'];//
		//END PENENTU SHIFT

		//PENENTU UANG MAKAN ADA ATAU TIDAK START
		$sql_penentu_hari="SELECT hari FROM payroll_jamkerjaitems WHERE departement='$departement' AND bagian='$bagian' AND hari='SENIN-KAMIS'";
		$result_penentu_hari=mysql_query($sql_penentu_hari);
		$rows_penentu_hari=mysql_fetch_array($result_penentu_hari);

		if ($rows_penentu_hari[hari]=='SENIN-KAMIS') {
			if ($hari=='Senin'){$penentu_hari='SENIN-KAMIS';}
			if ($hari=='Selasa'){$penentu_hari='SENIN-KAMIS';}
			if ($hari=='Rabu'){$penentu_hari='SENIN-KAMIS';}
			if ($hari=='Kamis'){$penentu_hari='SENIN-KAMIS';}
			if ($hari=='Jumat'){$penentu_hari='JUMAT';}
			if ($hari=='Sabtu'){$penentu_hari='SABTU';}
			if ($hari=='Minggu'){$penentu_hari='MINGGU';}
		}else{
			if ($hari=='Senin'){$penentu_hari='SENIN-JUMAT';}
			if ($hari=='Selasa'){$penentu_hari='SENIN-JUMAT';}
			if ($hari=='Rabu'){$penentu_hari='SENIN-JUMAT';}
			if ($hari=='Kamis'){$penentu_hari='SENIN-JUMAT';}
			if ($hari=='Jumat'){$penentu_hari='SENIN-JUMAT';}
			if ($hari=='Sabtu'){$penentu_hari='SABTU';}
			if ($hari=='Minggu'){$penentu_hari='MINGGU';}}
		$sql3="SELECT uang_makan FROM payroll_jamkerjaitems WHERE departement='$departement' AND bagian='$bagian' AND shift='$shift' AND hari='$penentu_hari'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);
		$uang_makan=$rows3['uang_makan'];//
		//PENENTU UANG MAKAN ADA ATAU TIDAK END

		$sql2="SELECT * FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal='$tanggal_sebenarnya'";
		$result2=mysql_query($sql2);
		$rows2=mysql_fetch_array($result2);
		$tanggal_penentu=$rows2['tanggal'];

		if($nomor_id != "" OR $nik != "" OR $nama != "" OR $tanggal != "" OR $jam_masuk != "" OR  $jam_pulang != "" OR $scan_masuk != "" OR  $scan_pulang != "" OR  $terlambat != "" OR  $pulang_cepat != "" OR  $lembur != ""){

		if ($departement=='' OR $bagian==''){}else{
		if ($tanggal_penentu==$tanggal_sebenarnya){echo "<table><tr>";
			if ($scan_masuk=='' AND $scan_pulang==''){}else{echo "<td style=background-color:yellow;>$nomor_id - $tanggal - $nama Data Telah Ada Sebelumnya</td>";
			//$update_1="UPDATE payroll_absensi SET hari='$hari',nomor_id='$nomor_id',nik='$nik',nama='$nama',tanggal='$tanggal',jam_masuk='$jam_masuk',jam_pulang='$jam_pulang',scan_masuk='$scan_masuk',scan_pulang='$scan_pulang',terlambat='$terlambat',pulang_cepat='$pulang_cepat',lembur='$lembur',departement='$departement',bagian='$bagian',jam_kerja='$jam_kerja' WHERE nomor_id='$nomor_id' AND tanggal='$tanggal'";
			//$eksekusi_update_1=mysql_query($update_1);
			echo "</table></tr>";
		}
	}else {echo "<table><tr>";
			if ($scan_masuk=='' OR $scan_pulang=='' OR $nama=='' OR $shift==''){echo "<td style=background-color:#F08080;>$nomor_id - $tanggal - $nama Data Gagal di import (mohon check kolom scan masuk, scan pulang, nama,  jam masuk)</td>";}else{
					echo "<td style=background-color:#00FFFF;>$nomor_id - $tanggal - $nama Data Berhasil di import</td>";

					$tgl = substr($tanggal,0,2);
					$bln = substr($tanggal,3,2);
					$thn = substr($tanggal,6,4);
					$tanggal_sebenarnya="$thn-$bln-$tgl";

					$update_1="INSERT INTO payroll_absensi SET hari_uang_makan='$penentu_hari',shift='$shift',uang_makan='$uang_makan',jumlah_kehadiran='$jumlah_kehadiran',hari='$hari',nomor_id='$nomor_id',nik='$nik',nama='$nama',tanggal='$tanggal_sebenarnya',jam_masuk='$jam_masuk',jam_pulang='$jam_pulang',scan_masuk='$scan_masuk',scan_pulang='$scan_pulang',terlambat='$terlambat',pulang_cepat='$pulang_cepat',lembur='$lembur',departement='$departement',bagian='$bagian',jam_kerja='$jam_kerja'";
					$eksekusi_update_1=mysql_query($update_1);}

					//echo "<td style=background-color:#00FFFF;>$nomor_id - $tanggal - $nama Data Berhasil di import </td>";

				echo "</table></tr>";
		}}
		}
		}

	// hapus kembali file .xls yang di upload tadi
	unlink($_FILES['pelengkap']['name']);
}//PROSES IMPORT END

//TABEL AWAL START
if ($_POST['submit']=='') {
	$pilihan_departement=$_POST['pilihan_departement'];
	$pencarian=$_POST['pencarian'];

	echo "<h2><center>Data Absensi</center></h2>";

	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/absensi'>
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
	</tr>
	<tr>
	 <td>Cari</td>
	 <td>:</td>
	 <td><input type='text' name='pencarian' value='$pencarian'></td>
	</tr>
	<tr>
	 <td><input type='submit' value='Tampil'></td>
	</tr>
	</form>
	</table>
	</br>";

	echo "
	<table class='tabel_utama' width=100% align=center>
	<thead>
	<th align=center width=auto>No</th>
	<th align=center width=auto>Nomor ID</th>
	<th align=center width=auto>Nik</th>
	<th align=center width=auto>Nama</th>
	<th align=center width=auto>Tanggal</th>
	<th align=center width=auto>Hari</th>
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
	<th align=center width=auto>Shift</th>
	</thead>";

	if ($_POST['pencarian']) {
  $if_pencarian=" AND nomor_id LIKE '%$pencarian%' OR nik LIKE '%$pencarian%' OR nama LIKE '%$pencarian%' OR tanggal LIKE '%$pencarian%' OR jam_kerja LIKE '%$pencarian%' OR jam_masuk LIKE '%$pencarian%' OR jam_pulang LIKE '%$pencarian%' OR scan_masuk LIKE '%$pencarian%' OR scan_pulang LIKE '%$pencarian%' OR terlambat LIKE '%$pencarian%' OR pulang_cepat LIKE '%$pencarian%' OR lembur LIKE '%$pencarian%' OR bagian LIKE '%$pencarian%'";}

	$sql13="SELECT * FROM payroll_absensi WHERE departement='$pilihan_departement' $if_pencarian";
	$result13=mysql_query($sql13);
	$no=1;
	while ($rows13=mysql_fetch_array($result13)) {

		$warnaGenap="#FFFFF";
		$warnaGanjil="#CEF6F5";
		if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}

	echo "<tr>
	<td style=background-color:$color; align=center>$no</td>
	<td style=background-color:$color; align=center>$rows13[nomor_id]</td>
	<td style=background-color:$color; align=center>$rows13[nik]</td>
	<td style=background-color:$color; align=center>$rows13[nama]</td>
	<td style=background-color:$color; align=center>$rows13[tanggal]</td>
	<td style=background-color:$color; align=center>$rows13[hari]</td>
	<td style=background-color:$color; align=center>$rows13[jam_kerja]</td>
	<td style=background-color:$color; align=center>$rows13[jam_masuk]</td>
	<td style=background-color:$color; align=center>$rows13[jam_pulang]</td>
	<td style=background-color:$color; align=center>$rows13[scan_masuk]</td>
	<td style=background-color:$color; align=center>$rows13[scan_pulang]</td>
	<td style=background-color:$color; align=center>$rows13[terlambat]</td>
	<td style=background-color:$color; align=center>$rows13[pulang_cepat]</td>
	<td style=background-color:$color; align=center>$rows13[lembur]</td>
	<td style=background-color:$color; align=center>$rows13[jumlah_kehadiran]</td>
	<td style=background-color:$color; align=center>$rows13[departement]</td>
	<td style=background-color:$color; align=center>$rows13[bagian]</td>
	<td style=background-color:$color; align=center>$rows13[shift]</td>
	</tr>";
$no++;}
echo "</table>";

}//TABEL AWAL END


}//END HOME
//END PHP?>
