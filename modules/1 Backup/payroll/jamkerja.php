<?php global $mod;
	$mod='payroll/jamkerja';
	function editmenu(){extract($GLOBALS);}

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

//Daftar POST START
$pilihan_departement=$_POST['pilihan_departement'];
$id_jamkerja=$_POST['id_jamkerja'];
$departement_rincian=$_POST['departement_rincian'];
$delete_rincian=$_POST['delete_rincian'];
$tambah_edit_rincian=$_POST['tambah_edit_rincian'];

$penentu_tambah_update=$_POST['penentu_tambah_update'];
$id_jamkerja_rincian=$_POST['id_jamkerja_rincian'];
$departement_rincian=$_POST['departement_rincian'];
$bagian_rincian=$_POST['bagian_rincian'];
$shift_rincian=$_POST['shift_rincian'];
$jam_masuk_rincian=$_POST['jam_masuk_rincian'];
$jam_keluar_rincian=$_POST['jam_keluar_rincian'];
$durasi_istirahat_rincian=$_POST['durasi_istirahat_rincian'];
$lembur_awal_rincian=$_POST['lembur_awal_rincian'];
$lembur_akhir_rincian=$_POST['lembur_akhir_rincian'];
$hari_rincian=$_POST['hari_rincian'];
$keterangan_rincian=$_POST['keterangan_rincian'];
$jumlah_jam_potongan_terlambat_rincian=$_POST['jumlah_jam_potongan_terlambat_rincian'];
$jumlah_jam_potongan_pulang_cepat_rincian=$_POST['jumlah_jam_potongan_pulang_cepat_rincian'];
$uang_makan=$_POST['uang_makan'];
//Daftar POST END



//Pilihan Departemen Start
if ($_POST['id_jamkerja']){}else{
	echo "</br>
	<form method ='post' action='?menu=home&mod=payroll/jamkerja'>
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
	</br>";
}
//Pilihan Departemen End



//IF Pilihan Departement Start
if ($_POST['pilihan_departement']) {
//TABEl START
	echo "<table class='tabel_utama'>
						<thead>
							<th style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='30px' bgcolor='#FFFFFF'><strong>No</strong></th>
							<th style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Bagian</strong></th>
							<th style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Departement</strong></th>
							<th style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Opsi</strong></th>
						</thead>";
						$sql1="SELECT	id,bagian,departement FROM payroll_jamkerja WHERE departement='$pilihan_departement' ORDER BY urut ";//WHERE status='Proses' AND kontak='$nama_kontak' AND selesai_keluar NOT LIKE '0000-00-00'
						$result1=mysql_query($sql1);
						$no=1;
						while ($rows1=mysql_fetch_array($result1)){

							$warnaGenap="white";
							$warnaGanjil="#CEF6F5";
							if ($no % 2 == 0){$color1 = $warnaGenap;}else{$color1 = $warnaGanjil;}

			echo "<tr>
							<td style='background-color:$color1; padding-left:5px; padding-right:5px; text-align:center;'><div class='nyala'>$no</div></td>
							<td style='background-color:$color1; padding-left:5px; padding-right:5px; text-align:left;'><div class='nyala'>$rows1[bagian]</div></td>
							<td style='background-color:$color1; padding-left:5px; padding-right:5px; text-align:center;'><div class='nyala'>$rows1[departement]</div></td>";
							echo "
										<form action='?menu=home&mod=payroll/jamkerja' method='POST'>
										<input type='hidden' name='id_jamkerja' value='$rows1[id]'/>
										<input type='hidden' name='departement_rincian' value='$rows1[departement]'/>";
							echo "<td style='font-weight:bold; background-color:$color1; text-align:center; '><div class='nyala'><input type='image' src='modules/gambar/item.png' width='30' height'30'  name='submit1' value='Rincian'></div></td>";
							echo "</form>";
		  echo "</tr>";
						$no++;}
			echo "</table>";//TABEl END
}//IF Pilihan Departement END


//Rincian Jam Kerja Start
if ($_POST['id_jamkerja']) {

//UPDATE EDIT EKSEKUSI START
	if ($penentu_tambah_update=='Tambah') {
		$tambah="INSERT INTO payroll_jamkerjaitems SET uang_makan='$uang_makan',induk='$id_jamkerja',departement='$departement_rincian',bagian='$bagian_rincian',shift='$shift_rincian',jam_masuk='$jam_masuk_rincian',jam_keluar='$jam_keluar_rincian',durasi_istirahat='$durasi_istirahat_rincian',lembur_awal='$lembur_awal_rincian',lembur_akhir='$lembur_akhir_rincian',hari='$hari_rincian',keterangan='$keterangan_rincian',jumlah_jam_potongan_terlambat='$jumlah_jam_potongan_terlambat_rincian',jumlah_jam_potongan_pulang_cepat='$jumlah_jam_potongan_pulang_cepat_rincian'";
		$eksekusi=mysql_query($tambah);
	}
	if ($penentu_tambah_update=='Edit') {
		$tambah="UPDATE payroll_jamkerjaitems SET uang_makan='$uang_makan',induk='$id_jamkerja',departement='$departement_rincian',bagian='$bagian_rincian',shift='$shift_rincian',jam_masuk='$jam_masuk_rincian',jam_keluar='$jam_keluar_rincian',durasi_istirahat='$durasi_istirahat_rincian',lembur_awal='$lembur_awal_rincian',lembur_akhir='$lembur_akhir_rincian',hari='$hari_rincian',keterangan='$keterangan_rincian',jumlah_jam_potongan_terlambat='$jumlah_jam_potongan_terlambat_rincian',jumlah_jam_potongan_pulang_cepat='$jumlah_jam_potongan_pulang_cepat_rincian' WHERE id='$id_jamkerja_rincian'";
		$eksekusi=mysql_query($tambah);
	}
//UPDATE EDIT EKSEKUSI START

//kembali start
	echo "
	<form action='?menu=home&mod=payroll/jamkerja' method='POST'>
	<table>
	<input type='hidden' name='pilihan_departement' value='$departement_rincian'/>
	<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='kembali'>
	</table>
	</form></br>";
//kembali end

//tambah start
if ($_POST['tambah_edit_rincian']){}else {
	echo "
	<form action='?menu=home&mod=payroll/jamkerja' method='POST'>
	<table>
	<input type='hidden' name='tambah_edit_rincian' value='tambah_edit_rincian'/>
	<input type='hidden' name='departement_rincian' value='$departement_rincian'/>
	<input type='hidden' name='id_jamkerja' value='$id_jamkerja'/>
	<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Tambah'>
	</table>
	</form>";}
//tambah end

//Tambah Edit Start
if($_POST['tambah_edit_rincian']) {

if ($_POST['tambah_edit_rincian']=='tambah_edit_rincian'){
	$sql3="SELECT id,departement,bagian FROM payroll_jamkerja WHERE id='$id_jamkerja'";
	$result3=mysql_query($sql3);
	$rows3=mysql_fetch_array($result3);
	$penentu_tambah_update="Tambah";
}else{
	$sql3="SELECT * FROM payroll_jamkerjaitems WHERE id='$tambah_edit_rincian'";
	$result3=mysql_query($sql3);
	$rows3=mysql_fetch_array($result3);
	$penentu_tambah_update="Edit";
}

	echo "<table border='1'><form action='?menu=home&mod=payroll/jamkerja' method='post' enctype='multipart/form-data'>

				<tr>
				<td>Departement</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='departement_rincian' value='$rows3[departement]' disabled></td>
				</tr>

				<tr>
				<td>Bagian</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='bagian_rincian' value='$rows3[bagian]' disabled></td>
				</tr>

				<tr>
				<td>Shift</td>
				 <td>:</td>
				 <td><select name='shift_rincian' style='width:254px'>
				 <option value='$rows3[shift]'>$rows3[shift]</option>
				 <option value='Shift 1'>Shift 1</option>
				 <option value='Shift 2'>Shift 2</option>
				 <option value='Shift 3'>Shift 3</option>
				</tr>

				<tr>
				<td>Jam Masuk</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='jam_masuk_rincian' value='$rows3[jam_masuk]'></td>
				</tr>

				<tr>
				<td>Jam Keluar</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='jam_keluar_rincian' value='$rows3[jam_keluar]'></td>
				</tr>

				<tr>
				<td>Durasi Istirahat</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='durasi_istirahat_rincian' value='$rows3[durasi_istirahat]'></td>
				</tr>

				<tr>
				<td>Lembur Awal</td>
				 <td>:</td>
				 <td><select name='lembur_awal_rincian' style='width:254px'>
				 <option value='$rows3[lembur_awal]'>$rows3[lembur_awal]</option>
				 <option value='Ya'>Ya</option>
				 <option value='Tidak'>Tidak</option>
				</tr>

				<tr>
				<td>Lembur Akhir</td>
				 <td>:</td>
				 <td><select name='lembur_akhir_rincian' style='width:254px'>
				 <option value='$rows3[lembur_akhir]'>$rows3[lembur_akhir]</option>
				 <option value='Ya'>Ya</option>
				 <option value='Tidak'>Tidak</option>
				</tr>

				<tr>
				<td>Hari</td>
				 <td>:</td>
				 <td><select name='hari_rincian' style='width:254px'>
				 <option value='$rows3[hari]'>$rows3[hari]</option>
				 <option value='SENIN-KAMIS'>SENIN-KAMIS</option>
				 <option value='JUMAT'>JUMAT</option>
				 <option value='SENIN-JUMAT'>SENIN-JUMAT</option>
				 <option value='SABTU'>SABTU</option>
				 <option value='MINGGU'>MINGGU</option>
				</tr>

				<tr>
				<td>Keterangan</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='keterangan_rincian' value='$rows3[keterangan]'></td>
				</tr>

				<tr>
				<td>Jmlh Jam Kerja 1H Pot. Terlambat</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='jumlah_jam_potongan_terlambat_rincian' value='$rows3[jumlah_jam_potongan_terlambat]'></td>
				</tr>

				<tr>
				<td>Jmlh Jam Kerja 1H Pot. Plg Cepat</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='jumlah_jam_potongan_pulang_cepat_rincian' value='$rows3[jumlah_jam_potongan_pulang_cepat]'></td>
				</tr>

				<tr>
				<td>Uang Makan</td>
				 <td>:</td>
				 <td><select name='uang_makan' style='width:254px'>
				 <option value='$rows3[uang_makan]'>$rows3[uang_makan]</option>
				 <option value='Ya'>Ya</option>
				 <option value='Tidak'>Tidak</option>
				</tr>";

				if ($_POST['tambah_edit_rincian']=='tambah_edit_rincian'){
					echo "<input type='hidden' name='id_jamkerja' value='$rows3[id]'>
								<input type='hidden' name='departement_rincian' value='$rows3[departement]'>
								<input type='hidden' name='bagian_rincian' value='$rows3[bagian]'>
								<input type='hidden' name='penentu_tambah_update' value='$penentu_tambah_update'>";
				}else{
					echo "<input type='hidden' name='id_jamkerja' value='$rows3[induk]'>
								<input type='hidden' name='id_jamkerja_rincian' value='$rows3[id]'>
								<input type='hidden' name='departement_rincian' value='$rows3[departement]'>
								<input type='hidden' name='bagian_rincian' value='$rows3[bagian]'>
								<input type='hidden' name='penentu_tambah_update' value='$penentu_tambah_update'>";
				}
				echo "</table>";
				echo "<table><td><center><input type='submit' name='submit' value='$penentu_tambah_update'></center></td>
				</form>";

				echo "
				<form action='?menu=home&mod=payroll/jamkerja' method='POST'>";
				if ($_POST['tambah_edit_rincian']=='tambah_edit_rincian'){
					echo "<input type='hidden' name='id_jamkerja' value='$rows3[id]'>
								<input type='hidden' name='departement_rincian' value='$rows3[departement]'>";
				}else{
					echo "<input type='hidden' name='id_jamkerja' value='$rows3[induk]'>
								<input type='hidden' name='departement_rincian' value='$rows3[departement]'>";
				}
				echo "
				<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Tutup'>
				</table>
				</form></table>";

}
//Tambah Edit End

//Delete Rincian - START
if ($_POST['delete_rincian']) {
	$delete_rincian_eksekusi="DELETE FROM payroll_jamkerjaitems WHERE id='$delete_rincian'";
	$delete_rincian_eksekusi2=mysql_query($delete_rincian_eksekusi);}
//Delete Rincian - END

//Judul Start
$sql4="SELECT	bagian FROM payroll_jamkerjaitems WHERE induk='$id_jamkerja'";//WHERE status='Proses' AND kontak='$nama_kontak' AND selesai_keluar NOT LIKE '0000-00-00'
$result4=mysql_query($sql4);
$rows4=mysql_fetch_array($result4);
$judul_bagian_rincian=$rows4['bagian'];
echo "<center><h2>Rincian Jam Kerja '$judul_bagian_rincian'</h2></center>";
//Judul End

//TABEl START
	echo "<table class='tabel_utama'>
						<tr>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='10px' bgcolor='#FFFFFF'><strong>No</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='30px' bgcolor='#FFFFFF'><strong>Induk</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='60px' bgcolor='#FFFFFF'><strong>Departement</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Bagian</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Shift</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Jam Masuk</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Jam Keluar</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Durasi Istirahat</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Lembur Awal</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Lembur Akhir</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Hari</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Keterangan</strong></td>
							<td colspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='1px' bgcolor='#FFFFFF'><strong>Rumus</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='1px' bgcolor='#FFFFFF'><strong>Uang Makan</strong></td>
							<td rowspan='2' style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='1px' bgcolor='#FFFFFF' colspan='2'><strong>Opsi</strong></td>
						</tr>
						<tr>
							<td style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='10%' bgcolor='#FFFFFF'><strong>Jmlh Jam Kerja 1H Pot. Terlambat</strong></td>
							<td style='padding: 5px; color:black; background-color: #D3D3D3;' align='center' width='10%' bgcolor='#FFFFFF'><strong>Jmlh Jam Kerja 1H Pot. Plg Cepat</strong></td>
						</tr>";
						$sql2="SELECT	* FROM payroll_jamkerjaitems WHERE induk='$id_jamkerja' ORDER BY shift ";//WHERE status='Proses' AND kontak='$nama_kontak' AND selesai_keluar NOT LIKE '0000-00-00'
						$result2=mysql_query($sql2);
						$no=1;
						while ($rows2=mysql_fetch_array($result2)){

							$warnaGenap="white";
							$warnaGanjil="#CEF6F5";
							if ($no % 2 == 0){$color1 = $warnaGenap;}else{$color1 = $warnaGanjil;}

							if ($tambah_edit_rincian==$rows2['id']){$color='yellow';}else{$color=$color1;}


			echo "<tr>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[induk]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[departement]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[bagian]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[shift]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[jam_masuk]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[jam_keluar]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[durasi_istirahat]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[lembur_awal]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[lembur_akhir]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[hari]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[keterangan]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[jumlah_jam_potongan_terlambat]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[jumlah_jam_potongan_pulang_cepat]</td>
							<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows2[uang_makan]</td>";
							//Start Edit
							echo "<form action='?menu=home&mod=payroll/jamkerja' method='POST'>
										<input type='hidden' name='id_jamkerja' value='$rows2[induk]'/>
										<input type='hidden' name='tambah_edit_rincian' value='$rows2[id]'/>
										<input type='hidden' name='departement_rincian' value='$rows2[departement]'/>";
							echo "<td style='background-color:#FFFFFF; text-align:center;'><input type='image' src='modules/gambar/edit.png' width='30' height'30'  name='submit' value='Edit'>";
							echo "</form>";
							//End Edit
							//Delete Start
							echo "<form action='?menu=home&mod=payroll/jamkerja' method='POST'>
										<input type='hidden' name='id_jamkerja' value='$rows2[induk]'/>
										<input type='hidden' name='delete_rincian' value='$rows2[id]'/>
										<input type='hidden' name='departement_rincian' value='$rows2[departement]'/>";
							echo "<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='image' src='modules/gambar/delete.png' width='30' height'30' name='submit1' value='Hapus'>";
							echo "</form>";
							//Delete End
		  echo "</tr>";
						$no++;}//TABEl END
			echo "</table>";

}//Rincian Jam Kerja End



}//END HOME
//END PHP?>
