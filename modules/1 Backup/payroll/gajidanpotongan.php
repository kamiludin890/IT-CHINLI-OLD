<?php global $mod;
$mod='payroll/gajidanpotongan';
function editmenu(){extract($GLOBALS);}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
return $hasil_rupiah;}

function jumlahhari($month){
$year=date('Y');
$hai = date('t', mktime(0, 0, 0, $month, 1, $year));
return $hai;}

function jumlah_sabtu_minggu($periode_awal,$periode_akhir,$nol){
//$periode_awal = "01-02-2020";
//$periode_akhir = "29-02-2020";
// pisahkan tanggal, bulan tahun dari periode_awal
$explodeTgl1 = explode("-", $periode_awal);
// membaca bagian-bagian dari periode_awal
$tgl1 = $explodeTgl1[0];
$bln1 = $explodeTgl1[1];
$thn1 = $explodeTgl1[2];
//echo "<p>Hari Minggu pada Periode $periode_awal s/d $periode_akhir Jatuh pada Tanggal-Tanggal Berikut:</p>";
// counter looping
$i = 0;
// counter untuk jumlah hari minggu
$sum = 0;
do{
    // mengenerate tanggal berikutnya
    $tanggal = date("d-m-Y", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1));
    // cek jika harinya minggu, maka counter $sum bertambah satu, lalu tampilkan tanggalnya
    if (date("w", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1)) == $nol)
    {
        $sum++;
        //echo $tanggal."<br>";
    }
    // increment untuk counter looping
    $i++;
}

while ($tanggal != $periode_akhir);
// looping di atas akan terus dilakukan selama tanggal yang digenerate tidak sama dengan periode awal.
// tampilkan jumlah hari Minggu
//echo "<p>Jumlah hari minggu antara ".$periode_awal." s/d ".$periode_akhir." adalah: ".$sum."</p>";
return $sum;
}//END JUMLAH MINGGU

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


$tampilan_halaman=$_POST['tampilan_halaman'];

//START TAMPILAN PERUBAHAN DATA
if ($tampilan_halaman=='perubahan_data'){

	//Ambil POST
	$edit_bulan=$_POST['edit_bulan'];
	$edit_id=$_POST['edit_id'];
	//End Ambil Post

//START UPDATE DATA
	if ($edit_id) {
	$edit_gaji_pokok=$_POST['edit_gaji_pokok'];
	$edit_bonus_kehadiran=$_POST['edit_bonus_kehadiran'];
	$edit_uang_makan_satu_hari=$_POST['edit_uang_makan_satu_hari'];
	$edit_uang_transport_satu_hari=$_POST['edit_uang_transport_satu_hari'];
	$edit_uang_shift_satu_hari=$_POST['edit_uang_shift_satu_hari'];
	$edit_thr=$_POST['thr'];
	$edit_jumlah_hari=jumlahhari($edit_id);
				$year=date('Y');//Pendukung
	$edit_jumlah_hari_minggu=jumlah_sabtu_minggu("01-$edit_id-$year","$edit_jumlah_hari-$edit_id-$year","0");
	$edit_jumlah_hari_sabtu=jumlah_sabtu_minggu("01-$edit_id-$year","$edit_jumlah_hari-$edit_id-$year","6");
				$jumlah_senin_jumat=$edit_jumlah_hari-$edit_jumlah_hari_sabtu-$edit_jumlah_hari_minggu;//Pendukung
				$jumlah_senin_sabtu=$edit_jumlah_hari-$edit_jumlah_hari_minggu;//Pendukung
	$edit_uang_makan_satu_bulan=$jumlah_senin_jumat*$edit_uang_makan_satu_hari;
	$edit_uang_transport_satu_bulan=$jumlah_senin_sabtu*$edit_uang_transport_satu_hari;
	//POTONGAN
	$edit_bpjs=$edit_gaji_pokok*1/100;
	$edit_jamsostek=$edit_gaji_pokok*2/100;
	$edit_dana_pensiun=$edit_gaji_pokok*1/100;

$update="UPDATE payroll_gaji_potongan SET thr=$edit_thr,gaji_pokok='$edit_gaji_pokok',bonus_kehadiran='$edit_bonus_kehadiran',uang_makan_satu_hari='$edit_uang_makan_satu_hari',uang_transport_satu_hari='$edit_uang_transport_satu_hari',uang_shift_satu_hari='$edit_uang_shift_satu_hari',jumlah_hari='$edit_jumlah_hari',jumlah_hari_sabtu='$edit_jumlah_hari_sabtu',jumlah_hari_minggu='$edit_jumlah_hari_minggu',uang_makan_satu_bulan='$edit_uang_makan_satu_bulan',uang_transport_satu_bulan='$edit_uang_transport_satu_bulan',bpjs='$edit_bpjs',jamsostek='$edit_jamsostek',dana_pensiun='$edit_dana_pensiun' WHERE id='$edit_id'";
$eksekusi_update=mysql_query($update);
}//END UPDATE DATA

	//Start BACK
	echo "<form action='?menu=home&mod=payroll/Gajidanpotongan' method='POST'>
				<input type='hidden' name='tampilan_halaman' value=''/>";
	echo "<input type='submit' name='submit' value='Kembali'>";
	echo "</form></br>";
	//End BACK

	//Start TAMPILKAN Bulan
	echo "</br>
	<form method ='post' action='?menu=home&mod=payroll/Gajidanpotongan'>
	<tr>
	 <td>Bulan</td>
	 <td>:</td>
	 <td><select name='edit_bulan'>
	<option value='$edit_bulan'>".$edit_bulan."</option>
	 <option value='Januari'>Januari</option>
	 <option value='Februari'>Februari</option>
	 <option value='Maret'>Maret</option>
	 <option value='April'>April</option>
	 <option value='Mei'>Mei</option>
	 <option value='Juni'>Juni</option>
	 <option value='Juli'>Juli</option>
	 <option value='Agustus'>Agustus</option>
	 <option value='September'>September</option>
	 <option value='Oktober'>Oktober</option>
	 <option value='November'>November</option>
	 <option value='Desember'>Desember</option>
	</tr>
	<tr>
	 <td></td>
	 <td></td>
	 <input type='hidden' name='tampilan_halaman' value='perubahan_data'/>
	 <td><input type='submit' value='Tampilkan'></td>
	</tr>
	</form>
	</br>";
	//End TAMPILKAN Bulan


	//Start Form Edit DATA
	if ($edit_bulan) {
		$sql3="SELECT * FROM payroll_gaji_potongan WHERE bulan='$edit_bulan'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);

	echo "<table border=''><form action='?menu=home&mod=payroll/Gajidanpotongan' method='post' enctype='multipart/form-data'>
						<tr>
						<td>Bulan</td>
						<td>:</td>
						<td><input type='text' style='width:250px' name='' value='$rows3[bulan]' disabled></td>
						</tr>
				<tr>
				<td>Gaji Pokok</td>
				<td>:</td>
				<td><input type='number' style='width:250px' name='edit_gaji_pokok' value='$rows3[gaji_pokok]'></td>
				</tr>
						<tr>
						<td>Bonus Kehadiran (1 Bulan)</td>
						<td>:</td>
						<td><input type='number' style='width:250px' name='edit_bonus_kehadiran' value='$rows3[bonus_kehadiran]'></td>
						</tr>
				<tr>
				<td>Uang Makan (1 Hari)</td>
				<td>:</td>
				<td><input type='number' style='width:250px' name='edit_uang_makan_satu_hari' value='$rows3[uang_makan_satu_hari]'></td>
				</tr>
						<tr>
						<td>Uang Transport (1 Hari)</td>
						<td>:</td>
						<td><input type='number' style='width:250px' name='edit_uang_transport_satu_hari' value='$rows3[uang_transport_satu_hari]'></td>
						</tr>
				<tr>
				<td>Uang Shift (1 Hari)</td>
				<td>:</td>
				<td><input type='number' style='width:250px' name='edit_uang_shift_satu_hari' value='$rows3[uang_shift_satu_hari]'></td>
				</tr>
          <tr>
  				<td>THR</td>
  				<td>:</td>
  				<td><input type='number' style='width:250px' name='thr' value='$rows3[thr]'></td>
  				</tr>";

				echo "<input type='hidden' name='edit_id' value='$rows3[id]'>
							<input type='hidden' name='edit_bulan' value='$rows3[bulan]'>
							<input type='hidden' name='tampilan_halaman' value='perubahan_data'>";
				echo "<td colspan='3'><center><input type='submit' name='submit' value='Update'></left></td>
				</form>";}
				echo "</table>";
//End Form Edit DATA

}//END TAMPILAN PERUBAHAN DATA


//START TAMPILAN UTAMA
if ($tampilan_halaman=='halaman_utama' or $tampilan_halaman=='') {
	echo "<h2><center>Nominal Penghasilan Kotor</center></h2>";

	//Start Edit
	echo "<form action='?menu=home&mod=payroll/Gajidanpotongan' method='POST'>
				<input type='hidden' name='tampilan_halaman' value='perubahan_data'/>";
	echo "<input type='submit' name='submit' value='Perubahan Data'>";
	echo "</form></br>";
	//End Edit

	//TABEl START
		echo "<table class='tabel_utama' width='120%'>
							<tr>
								<td rowspan='2' style='padding: 1px; color:black; background-color:#D3D3D3;' align='center' width='1px' bgcolor='#FFFFFF'><strong>No</strong></td>
								<td rowspan='2' style='padding: 1px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Bulan</strong></td>
								<td rowspan='2' style='padding: 1px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Jumlah</br>Hari</strong></td>
								<td rowspan='2' style='padding: 1px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Jumlah</br>Sabtu</strong></td>
								<td rowspan='2' style='padding: 1px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Jumlah</br>Minggu</strong></td>
								<td rowspan='2' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Gaji Pokok</br>(1 Bulan)</strong></td>
								<td rowspan='2' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Bonus Kehadiran</br>(1 Bulan)</strong></td>
								<td colspan='2' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Uang Makan</strong></td>
								<td colspan='2' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Uang Transport</strong></td>
								<td colspan='2' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Uang Shift</strong></td>
								<td rowspan='2' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Jumlah</br>(1 Bulan)</strong></td>
								<td colspan='3' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Potongan</br>(1 Bulan)</strong></td>
								<td rowspan='2' style='padding: 5px; color:black; background-color:#D3D3D3;' align='center' width='auto' bgcolor='#FFFFFF'><strong>THR</strong></td>
							</tr>
							<tr style='background-color: #C0C0C0;'>
									<td align='center'>1 Hari</td>
									<td align='center'>1 Bulan</td>
									<td align='center'>1 Hari</td>
									<td align='center'>1 Bulan</td>
									<td align='center'>1 Hari</td>
									<td align='center'>1 Bulan</td>
									<td align='center'>BPJS</td>
									<td align='center'>Jamsostek</td>
									<td align='center'>Dana Pensiun</td>
							</tr>";
							$sql2="SELECT	* FROM payroll_gaji_potongan";//WHERE status='Proses' AND kontak='$nama_kontak' AND selesai_keluar NOT LIKE '0000-00-00'
							$result2=mysql_query($sql2);
							$no=1;
							while ($rows2=mysql_fetch_array($result2)){
								$color='#FFFFFF';
								$jumlah_penghasilan_kotor=$rows2['gaji_pokok']+$rows2['bonus_kehadiran']+$rows2['uang_makan_satu_bulan']+$rows2['uang_transport_satu_bulan']+$rows2['uang_shift_satu_bulan'];
				echo "<tr>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>$no</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".$rows2[bulan]."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".$rows2[jumlah_hari]."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".$rows2[jumlah_hari_sabtu]."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".$rows2[jumlah_hari_minggu]."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[gaji_pokok])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[bonus_kehadiran])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[uang_makan_satu_hari])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[uang_makan_satu_bulan])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[uang_transport_satu_hari])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[uang_transport_satu_bulan])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[uang_shift_satu_hari])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[uang_shift_satu_bulan])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($jumlah_penghasilan_kotor)."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[bpjs])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[jamsostek])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[dana_pensiun])."</td>
								<td style='background-color:$color; padding-left:1px; padding-right:1px; text-align:center;'>".rupiah($rows2[thr])."</td>";
			  echo "</tr>";
							$no++;}//TABEl END
				echo "</table>";
}//TAMPILAN_HALAMAN_UTAMA

}//END HOME
//END PHP?>
