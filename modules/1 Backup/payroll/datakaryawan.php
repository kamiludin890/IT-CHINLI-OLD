<?php global $mod;
	$mod='payroll/datakaryawan';
function editmenu(){extract($GLOBALS);}

function datediff($tgl1, $tgl2){
$tgl1 = strtotime($tgl1);
$tgl2 = strtotime($tgl2);
$diff_secs = abs($tgl1 - $tgl2);
$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
}

function dapatcuti($nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak){
	$tgl1=$awal_masuk;
	$tgl2=date("Y-m-d");
	$a = datediff($tgl1, $tgl2);
	$sql4="SELECT total_cuti,awal_masuk FROM payroll_cuti_tahunan WHERE induk='$nomor_id'";
	$result4= mysql_query($sql4);
	$rows4=mysql_fetch_array($result4);
	if ($a[years] > $rows4[tahun_ke]){
		$update="UPDATE payroll_cuti_tahunan SET total_cuti='12' WHERE induk='$nomor_id'";
		$eksekusi_update=mysql_query($update);}
	//echo 'tanggal 1 = '.$tgl1; echo '<br>';
	//echo 'tanggal 2 = '.$tgl2; echo '<br>';
	$Selisih=$a[years].' tahun '.$a[months].' bulan '.$a[days].' hari';//.$a[hours].' jam '.$a[minutes].' menit '.$a[seconds].' detik';
//return "$nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$jenis";
return $rows4[total_cuti];}

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;}

function selisihtgl($tgl1,$tgl2){
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
	if ($selisih<0) {
		$selisih1=0;
	}else {
		$selisih1=$selisih;
	}
	return "$selisih1 Hari";}

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

//AMBIL POST START
$pilihan_departement=$_POST['pilihan_departement'];
$departement_rincian=$_POST['departement_rincian'];
$bagian_rincian=$_POST['bagian_rincian'];
$delete_rincian=$_POST['delete_rincian'];
$tambah_edit_rincian=$_POST['tambah_edit_rincian'];
//AMBIL POST END


//Pilihan Departemen START
if ($_POST['bagian_rincian']){}else{
echo "</br>
<form method ='post' action='?menu=home&mod=payroll/datakaryawan'>
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
 <td><input type='submit' value='Tampil'></td>
</tr>
</form>
</br>";}
//Pilihan Departemen END


//IF Pilihan Departement Start
if ($_POST['pilihan_departement']) {
//TABEl START
	echo "<table class='tabel_utama'>
						<tr>
							<td style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='30px' bgcolor='#FFFFFF'><strong>No</strong></td>
							<td style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Bagian</strong></td>
							<td style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Departement</strong></td>
							<td style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Opsi</strong></td>
						</tr>";
						$sql1="SELECT	id,bagian,departement FROM payroll_jamkerja WHERE departement='$pilihan_departement' ORDER BY urut ";//WHERE status='Proses' AND kontak='$nama_kontak' AND selesai_keluar NOT LIKE '0000-00-00'
						$result1=mysql_query($sql1);
						$no=1;
						while ($rows1=mysql_fetch_array($result1)){

							$warnaGenap="white";
							$warnaGanjil="#CEF6F5";
							if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}

				echo "<tr>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:left;'>$rows1[bagian]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[departement]</td>";
							echo "
										<form action='?menu=home&mod=payroll/datakaryawan' method='POST'>
										<input type='hidden' name='bagian_rincian' value='$rows1[bagian]'/>
										<input type='hidden' name='departement_rincian' value='$rows1[departement]'/>";
							echo "<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='image' src='modules/gambar/item.png' width='30' height'30' name='submit1' value='Rincian'>";
							echo "</form>";
		  echo "</tr>";
						$no++;}
			echo "</table>";//TABEl END
}//IF Pilihan Departement END


//TABEl START
if ($bagian_rincian) {
//AMBIL POST START
$penentu_tambah_update=$_POST['penentu_tambah_update'];
$id_rincian=$_POST['id_rincian'];
$jam_kerja=$_POST['jam_kerja'];
$nomor_id=$_POST['nomor_id'];
$nik=$_POST['nik'];
$nama=$_POST['nama'];
$mulai_kontrak=$_POST['mulai_kontrak'];
$akhir_kontrak=$_POST['akhir_kontrak'];
$uang_profesional=$_POST['uang_profesional'];
$jumlah_tanggungan_bpjs=$_POST['jumlah_tanggungan_bpjs'];
$awal_masuk=$_POST['awal_masuk'];
//AMBIL POST END

	//UPDATE EDIT EKSEKUSI START
		if ($penentu_tambah_update=='Tambah') {

			$sql5="SELECT nama,bagian FROM payroll_data_karyawan WHERE nomor_id='$nomor_id' AND departement='$departement_rincian'";
			$result5=mysql_query($sql5);
			$rows5=mysql_fetch_array($result5);

			if ($rows5[nama]) {
				echo "Data telah ada sebelumnya ($rows5[nama] dari $rows5[bagian]) - GAGAL";
			}else {
			$tambah="INSERT INTO payroll_data_karyawan SET
			awal_masuk='$awal_masuk',
			jumlah_tanggungan_bpjs='$jumlah_tanggungan_bpjs',
			departement='$departement_rincian',
			bagian='$bagian_rincian',
			jam_kerja='$jam_kerja',
			nomor_id='$nomor_id',
			nik='$nik',
			nama='$nama',
			mulai_kontrak='$mulai_kontrak',
			akhir_kontrak='$akhir_kontrak',
			uang_profesional='$uang_profesional'";
			$eksekusi=mysql_query($tambah);

			$sql4="SELECT id,nomor_id,awal_masuk,mulai_kontrak,akhir_kontrak FROM payroll_data_karyawan WHERE nomor_id='$nomor_id' AND departement='$departement_rincian' AND bagian='$bagian_rincian'";
			$result4=mysql_query($sql4);
			$rows4=mysql_fetch_array($result4);
			$id_induk=$rows4['id'];
			$id_nomor_id=$rows4['nomor_id'];
			$id_awal_masuk=$rows4['awal_masuk'];
			$id_mulai_kontrak=$rows4['mulai_kontrak'];
			$id_akhir_kontrak=$rows4['akhir_kontrak'];
			$dapat_cuti=dapatcuti($id_nomor_id,$id_awal_masuk,$id_mulai_kontrak,$id_akhir_kontrak);

			$insert_cuti_tahunan="INSERT INTO payroll_cuti_tahunan SET induk='$id_induk',awal_masuk='$id_awal_masuk',mulai_kontrak='$id_mulai_kontrak',selesai_kontrak='$id_akhir_kontrak',total_cuti='$dapat_cuti'";
			mysql_query($insert_cuti_tahunan);
		}
		}
		if ($penentu_tambah_update=='Edit') {
			$tambah="UPDATE payroll_data_karyawan SET
			awal_masuk='$awal_masuk',
			jumlah_tanggungan_bpjs='$jumlah_tanggungan_bpjs',
			jam_kerja='$jam_kerja',
			nomor_id='$nomor_id',
			nik='$nik',
			nama='$nama',
			mulai_kontrak='$mulai_kontrak',
			akhir_kontrak='$akhir_kontrak',
			uang_profesional='$uang_profesional'
			WHERE id='$id_rincian'";
			$eksekusi=mysql_query($tambah);

			//CUTI TAHUNAN
			$tambah1="UPDATE payroll_cuti_tahunan SET
			awal_masuk='$awal_masuk',
			mulai_kontrak='$mulai_kontrak',
			selesai_kontrak='$akhir_kontrak'
			WHERE induk='$id_rincian'";
			$eksekusi1=mysql_query($tambah1);

			//POTONGAN PPH21
			$tambah2="UPDATE payroll_potongan_pph21 SET
			mulai_kerja='$awal_masuk'
			WHERE induk='$id_rincian'";
			$eksekusi2=mysql_query($tambah2);
		}
	//UPDATE EDIT EKSEKUSI START

	//kembali START
		echo "
		<form action='?menu=home&mod=payroll/datakaryawan' method='POST'>
		<table>
		<input type='hidden' name='pilihan_departement' value='$departement_rincian'/>
		<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='kembali'>
		</table>
		</form></br>";
	//kembali END

	//tambah start
	if ($_POST['tambah_edit_rincian']){}else {
		echo "
		<form action='?menu=home&mod=payroll/datakaryawan' method='POST'>
		<table>
		<input type='hidden' name='tambah_edit_rincian' value='tambah_edit_rincian'/>
		<input type='hidden' name='departement_rincian' value='$departement_rincian'/>
		<input type='hidden' name='bagian_rincian' value='$bagian_rincian'/>
		<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Tambah'>
		</table>
		</form>";}
	//tambah end

	//Tambah Edit Start
	if($_POST['tambah_edit_rincian']) {

	if ($_POST['tambah_edit_rincian']=='tambah_edit_rincian'){
		$sql3="SELECT departement,bagian FROM payroll_data_karyawan WHERE bagian='$bagian_rincian' AND departement='$departement_rincian'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);
		$penentu_tambah_update="Tambah";
	}else{
		$sql3="SELECT * FROM payroll_data_karyawan WHERE id='$tambah_edit_rincian'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);
		$penentu_tambah_update="Edit";
	}

//Skrip Tambahan Kalender
	echo "
	<iframe width=174 height=189 name='gToday:normal:agenda.js' id='gToday:normal:agenda.js' src='modules/payroll/calender/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;'>
	</iframe>";
//Skrip Tambahan Kalender

		echo "<form action='?menu=home&mod=payroll/datakaryawan' method='POST' name='forminputtanggal' enctype='multipart/form-data'>
					<table border='1'>
					<tr>
					<td>Departemen</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='' value='$departement_rincian' disabled></td>
					</tr>

					<tr>
					<td>Bagian</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='' value='$bagian_rincian' disabled></td>
					</tr>

					<tr>
					<td>Jam Kerja</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='jam_kerja' value='$bagian_rincian' disabled></td>
					</tr>

					<tr>
					<td>Nomor ID Mesin</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='nomor_id' value='$rows3[nomor_id]'></td>
					</tr>

					<tr>
					<td>NIK</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='nik' value='$rows3[nik]'></td>
					</tr>

					<tr>
					<td>Nama</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='nama' value='$rows3[nama]'></td>
					</tr>

					<tr>
					<td>Awal Masuk</td>
					<td>:</td>
					<td><input name='awal_masuk' value='$rows3[awal_masuk]' size='24'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.awal_masuk);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>
					</tr>

					<tr>
					<td>Mulai Kontrak</td>
					<td>:</td>
					<td><input name='mulai_kontrak' value='$rows3[mulai_kontrak]' size='24'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.mulai_kontrak);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>
					</tr>

					<tr>
					<td>Akhir Kontrak</td>
					<td>:</td>
					<td><input name='akhir_kontrak' value='$rows3[akhir_kontrak]' size='24'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.akhir_kontrak);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>
					</tr>

					<tr>
					<td>Uang Profesional</td>
					<td>:</td>
					<td><input type='number' style='width:250px' name='uang_profesional' value='$rows3[uang_profesional]'></td>
					</tr>

					<tr>
					<td>Tambah Tanggungan BPJS</td>
					<td>:</td>
					<td><input type='number' style='width:250px' name='jumlah_tanggungan_bpjs' value='$rows3[jumlah_tanggungan_bpjs]'></td>
					</tr>";

					if ($_POST['tambah_edit_rincian']=='tambah_edit_rincian'){
						echo "<input type='hidden' name='id_rincian' value='$rows3[id]'>
									<input type='hidden' name='departement_rincian' value='$departement_rincian'>
									<input type='hidden' name='bagian_rincian' value='$bagian_rincian'>
									<input type='hidden' name='jam_kerja' value='$bagian_rincian'>
									<input type='hidden' name='penentu_tambah_update' value='$penentu_tambah_update'>";
					}else{
						echo "
									<input type='hidden' name='bagian_rincian' value='$rows3[bagian]'>
									<input type='hidden' name='jam_kerja' value='$rows3[bagian]'>
									<input type='hidden' name='departement_rincian' value='$rows3[departement]'>
									<input type='hidden' name='id_rincian' value='$rows3[id]'>
									<input type='hidden' name='penentu_tambah_update' value='$penentu_tambah_update'>";
					}
					echo "</table>";
					echo "<table><td><center><input type='submit' name='submit' value='$penentu_tambah_update'></center></td>
					</form>";

					echo "
					<form action='?menu=home&mod=payroll/datakaryawan' method='POST'>";
					if ($_POST['tambah_edit_rincian']=='tambah_edit_rincian'){
						echo "<input type='hidden' name='bagian_rincian' value='$bagian_rincian'>
									<input type='hidden' name='departement_rincian' value='$departement_rincian'>";
					}else{
						echo "<input type='hidden' name='bagian_rincian' value='$rows3[bagian]'>
									<input type='hidden' name='departement_rincian' value='$rows3[departement]'>";
					}
					echo "
					<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Tutup'>
					</table>
					</form>";
		}
	//Tambah Edit End


	//Delete Rincian - START
	if ($_POST['delete_rincian']) {
		$delete_rincian_eksekusi="DELETE FROM payroll_data_karyawan WHERE id='$delete_rincian'";
		$delete_rincian_eksekusi2=mysql_query($delete_rincian_eksekusi);

		$delete_rincian_eksekusi3="DELETE FROM payroll_cuti_tahunan WHERE induk='$delete_rincian'";
		$delete_rincian_eksekusi3=mysql_query($delete_rincian_eksekusi3);

		$delete_rincian_eksekusi4="DELETE FROM payroll_potongan_pph21 WHERE induk='$delete_rincian'";
		$delete_rincian_eksekusi4=mysql_query($delete_rincian_eksekusi4);
	}
	//Delete Rincian - END


	echo "<h2><center>Data Karyawan $bagian_rincian, Departement $departement_rincian</center></h2>";
	echo "<table class='tabel_utama'>
						<thead>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='10px' bgcolor='#FFFFFF'><strong>No</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='30px' bgcolor='#FFFFFF'><strong>Nomor ID</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='60px' bgcolor='#FFFFFF'><strong>NIK</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='auto' bgcolor='#FFFFFF'><strong>Nama</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='70px' bgcolor='#FFFFFF'><strong>Awal Masuk</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='70px' bgcolor='#FFFFFF'><strong>Mulai Kontrak</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='70px' bgcolor='#FFFFFF'><strong>Akhir Kontrak</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='70px' bgcolor='#FFFFFF'><strong>Sisa Kontrak</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='50px' bgcolor='#FFFFFF'><strong>Dept</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='50px' bgcolor='#FFFFFF'><strong>Bagian</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='50px' bgcolor='#FFFFFF'><strong>Jam Kerja</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='auto' bgcolor='#FFFFFF'><strong>Uang Profesional</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='auto' bgcolor='#FFFFFF'><strong>Tambah Tanggungan BPJS</strong></th>
						<th style='padding: 5px; color:black; background-color: #D3D3D3;'' align='center' width='1px' bgcolor='#FFFFFF' colspan='2'><strong>Opsi</strong></th>
						</thead>";
						$sql2="SELECT	* FROM payroll_data_karyawan WHERE bagian='$bagian_rincian' AND departement='$departement_rincian' ORDER BY nama ";//WHERE status='Proses' AND kontak='$nama_kontak' AND selesai_keluar NOT LIKE '0000-00-00'
						$result2=mysql_query($sql2);
						$no=1;
						while ($rows2=mysql_fetch_array($result2)){
							if ($tambah_edit_rincian==$rows2['id']){$color='yellow';}else{$color='#FFFFFF';}
							$tgl_terkini=date('Y-m-d');
							$selisihtgl=selisihtgl("$rows2[akhir_kontrak]","$tgl_terkini");
							$uangprofesional=rupiah($rows2['uang_profesional']);

			echo "<tr>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[nomor_id]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[nik]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[nama]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[awal_masuk]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[mulai_kontrak]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[akhir_kontrak]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$selisihtgl</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[departement]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[bagian]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[jam_kerja]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$uangprofesional</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[jumlah_tanggungan_bpjs]</td>";
							//Start Edit
							echo "<form action='?menu=home&mod=payroll/datakaryawan' method='POST'>
										<input type='hidden' name='tambah_edit_rincian' value='$rows2[id]'/>
										<input type='hidden' name='bagian_rincian' value='$rows2[bagian]'/>
										<input type='hidden' name='departement_rincian' value='$rows2[departement]'/>";
							echo "<td style='background-color:#FFFFFF; text-align:center;'><input type='image' src='modules/gambar/edit.png' width='30' height'30'  name='submit' value='Edit'>";
							echo "</form>";
							//End Edit
							//Delete Start
							echo "<form action='?menu=home&mod=payroll/datakaryawan' method='POST'>
										<input type='hidden' name='delete_rincian' value='$rows2[id]'/>
										<input type='hidden' name='bagian_rincian' value='$rows2[bagian]'/>
										<input type='hidden' name='departement_rincian' value='$rows2[departement]'/>";
							echo "<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='image' src='modules/gambar/delete.png' width='30' height'30' name='submit1' value='Hapus'>";
							echo "</form>";
							//Delete End
		  echo "</tr>";
						$no++;}
			echo "</table>";}//TABEl END


}//END HOME
//END PHP?>
