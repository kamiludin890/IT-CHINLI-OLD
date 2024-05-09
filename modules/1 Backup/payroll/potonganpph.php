<?php global $mod;
	$mod='payroll/potonganpph';
function editmenu(){extract($GLOBALS);}

function npwp($nilai){
	$NPWP2=substr($nilai,0,2);
	$NPWP3=substr($nilai,2,3);
	$NPWP4=substr($nilai,5,3);
	$NPWP5=substr($nilai,8,1);
	$NPWP6=substr($nilai,9,3);
	$NPWP7=substr($nilai,12,3);
	$nilai1="$NPWP2.$NPWP3.$NPWP4.$NPWP5-$NPWP6.$NPWP7";
	return $nilai1;}

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
	return $hasil_rupiah;}

function jkkdanjkm($nilai){
	$hasil=floor($nilai*1.19/100);
	return $hasil;}

function datediff($tgl1, $tgl2){
	$tgl1 = strtotime($tgl1);
	$tgl2 = strtotime($tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );}

function lama($awal_masuk){
	$tgl1=$awal_masuk;
	$tgl2=date("Y-m-d");
	$a = datediff($tgl1, $tgl2);
	if ($a[years] == 0) {$hasil=$a[months];}
	if ($a[years] >= 1) {$hasil=12;}
	return $hasil;}

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

	//AMBIL POST UTAMA START
	$pilihan_departement=$_POST['pilihan_departement'];
	$pilihan_bagian=$_POST['pilihan_bagian'];
	$update=$_POST['update'];
	$pilihan_update=$_POST['pilihan_update'];
	//AMBIL POST UTAMA END


	//Pilihan Departement & Bagian START
	echo "<h2><center>Potongan PPH21</center></h2>";
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Potonganpph'>
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
	<td><select name='pilihan_bagian'>
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


//START PILIH KARYAWAN
if ($update) {

	if ($pilihan_update) {
	$sql4="SELECT id,nomor_id,nik,nama,awal_masuk FROM payroll_data_karyawan WHERE id='$pilihan_update'";
	$result4=mysql_query($sql4);
	$rows4=mysql_fetch_array($result4);}

	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Potonganpph'>";
	echo "
	<tr>
	<td>Karyawan</td>
	<td>:</td>
	<td><select name='pilihan_update'>
		 <option value='$pilihan_update'>".$rows4[nik]." ".$rows4[nama]."</option>";
	$sql3="SELECT id,nomor_id,nik,nama FROM payroll_data_karyawan WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian' ORDER BY nama";
	$result3=mysql_query($sql3);
	while ($rows3=mysql_fetch_array($result3)) {
		 echo "<option value='$rows3[id]'>".$rows3[nik]." ".$rows3[nama]."</option>";}
	echo "
	</td>";
	echo "
		<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
		<input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
		<input type='hidden' name='update' value='$update'>
	 <td><input type='submit' value='Pilih'></td>
	</tr>
	</form></table>";

//TAMPIL KOLOM UPDATE KARYAWAN
if ($pilihan_update) {

	//AMBIL POST KEDUA START
	$simpan=$_POST['simpan'];
	$pilihan_update=$_POST['pilihan_update'];
	$npwp=$_POST['npwp'];
	$ktp=$_POST['ktp'];
	$alamat=$_POST['alamat'];
	$status_actual=$_POST['status_actual'];
	$status=$_POST['status'];
	$jenis_kelamin=$_POST['jenis_kelamin'];
	$jabatan=$_POST['jabatan'];
	$gaji_perbulan=$_POST['gaji_perbulan'];
	$jkk_dan_jkm=$_POST['jkk_dan_jkm'];
	$potongan=$_POST['potongan'];
	$jumlah=$_POST['jumlah'];
	$mulai_kerja=$_POST['mulai_kerja'];
	$lama=$_POST['lama'];
	$jumlah_gaji=$_POST['jumlah_gaji'];
	$bpjs=$_POST['bpjs'];
	$bruto=$_POST['bruto'];
	$biaya_jabatan=$_POST['biaya_jabatan'];
	$jamsostek=$_POST['jamsostek'];
	$premi_karyawan=$_POST['premi_karyawan'];
	$bonus_atau_thr=$_POST['bonus_atau_thr'];
	$dana_pensiun=$_POST['dana_pensiun'];
	$net=$_POST['net'];
	$ptkp=$_POST['ptkp'];
	$pkp=$_POST['pkp'];
	$limapersen=$_POST['limapersen'];
	$limabelaspersen=$_POST['limabelaspersen'];
	$duapuluhlimapersen=$_POST['duapuluhlimapersen'];
	$tigapuluhpersen=$_POST['tigapuluhpersen'];
	$total_tahun=$_POST['total_tahun'];
	$pph_bulan=$_POST['pph_bulan'];
	//AMBIL POST KEDUA END

	if ($simpan) {

		$sql6="SELECT induk FROM payroll_potongan_pph21 WHERE induk='$pilihan_update'";
		$result6=mysql_query($sql6);
		$rows6=mysql_fetch_array($result6);

		if ($rows6['induk'] == '' OR $rows6['induk'] == '0'){
			$update_data="INSERT INTO payroll_potongan_pph21 SET
			induk='$pilihan_update',
			npwp='$npwp',
			ktp='$ktp',
			alamat='$alamat',
			status_actual='$status_actual',
			status='$status',
			jenis_kelamin='$jenis_kelamin',
			jabatan='$jabatan',
			gaji_perbulan='$gaji_perbulan',
			jkk_dan_jkm='$jkk_dan_jkm',
			potongan='$potongan',
			jumlah='$jumlah',
			mulai_kerja='$mulai_kerja',
			lama='$lama',
			jumlah_gaji='$jumlah_gaji',
			bpjs='$bpjs',
			bruto='$bruto',
			biaya_jabatan='$biaya_jabatan',
			jamsostek='$jamsostek',
			premi_karyawan='$premi_karyawan',
			bonus_atau_thr='$bonus_atau_thr',
			dana_pensiun='$dana_pensiun',
			net='$net',
			ptkp='$ptkp',
			pkp='$pkp',
			limapersen='$limapersen',
			limabelaspersen='$limabelaspersen',
			duapuluhlimapersen='$duapuluhlimapersen',
			tigapuluhpersen='$tigapuluhpersen',
			total_tahun='$total_tahun',
			pph_bulan='$pph_bulan'";
			$eksekusi_update_data=mysql_query($update_data);
			$berhasil="Data Berhasil di Simpan";
		}else {
		$update_data="UPDATE payroll_potongan_pph21 SET
		npwp='$npwp',
		ktp='$ktp',
		alamat='$alamat',
		status_actual='$status_actual',
		status='$status',
		jenis_kelamin='$jenis_kelamin',
		jabatan='$jabatan',
		gaji_perbulan='$gaji_perbulan',
		jkk_dan_jkm='$jkk_dan_jkm',
		potongan='$potongan',
		jumlah='$jumlah',
		mulai_kerja='$mulai_kerja',
		lama='$lama',
		jumlah_gaji='$jumlah_gaji',
		bpjs='$bpjs',
		bruto='$bruto',
		biaya_jabatan='$biaya_jabatan',
		jamsostek='$jamsostek',
		premi_karyawan='$premi_karyawan',
		bonus_atau_thr='$bonus_atau_thr',
		dana_pensiun='$dana_pensiun',
		net='$net',
		ptkp='$ptkp',
		pkp='$pkp',
		limapersen='$limapersen',
		limabelaspersen='$limabelaspersen',
		duapuluhlimapersen='$duapuluhlimapersen',
		tigapuluhpersen='$tigapuluhpersen',
		total_tahun='$total_tahun',
		pph_bulan='$pph_bulan' WHERE induk='$pilihan_update'";
		$eksekusi_update_data=mysql_query($update_data);
		$berhasil="Data Berhasil di Simpan";
		}
	}

	echo "
	<table style='background-color:white;' class='tabel_utama' width=120% align=center>
	<thead style='background-color:#C0C0C0;'>
		<th align=center width=auto>Nomor ID</th>
		<th align=center width=auto>Nik</th>
		<th align=center width=auto>Nama</th>
		<th align=center width=auto>NPWP</th>
		<th align=center width=auto>KTP</th>
		<th align=center width=auto>Alamat</th>
		<th align=center width=auto>Status Actual</th>
		<th align=center width=auto>Status</th>
		<th align=center width=auto>Jenis Kelamin</th>
		<th align=center width=auto>Jabatan</th>
		<th align=center width=auto>Gaji Perbulan</th>
		<th align=center width=auto>JKK & JKM</th>
		<th align=center width=auto>Potongan</th>";
//		<th align=center width=auto>Jumlah</th>
echo "<th align=center width=auto>Mulai Kerja</th>";
//		<th align=center width=auto>Lama</th>
//		<th align=center width=auto>Jumlah Gaji</th>
echo "<th align=center width=auto>Bonus/THR</th>";
//		<th align=center width=auto>Bruto</th>
//		<th align=center width=auto>B. Jabatan</th>
echo "
		<th align=center width=auto>BPJS</th>
		<th align=center width=auto>Jamsostek</th>
		<th align=center width=auto>Dana Pensiun</th>";
//  	<th align=center width=auto>Premi Karyawan</th>
//		<th align=center width=auto>Net</th>
//		<th align=center width=auto>PTKP</th>
//		<th align=center width=auto>PKP</th>
//		<th align=center width=auto>5%</th>
//		<th align=center width=auto>15%</th>
//		<th align=center width=auto>25%</th>
//		<th align=center width=auto>30%</th>
//		<th align=center width=auto>Total Tahun</th>
echo "<th align=center width=auto>PPH/Bulan</th>
	</thead>";

	//Skrip Tambahan Kalender
		echo "
		<iframe width=174 height=189 name='gToday:normal:agenda.js' id='gToday:normal:agenda.js' src='modules/payroll/calender/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;'>
		</iframe>";
	//Skrip Tambahan Kalender

	echo "
	<form method ='post' action='?menu=home&mod=payroll/Potonganpph' name='forminputtanggal' enctype='multipart/form-data'>
	<tr>";
	$sql5="SELECT * FROM payroll_potongan_pph21 WHERE induk='$pilihan_update'";
	$result5=mysql_query($sql5);
	$rows5=mysql_fetch_array($result5);

		echo "<tr>
		<td align=center>$rows4[nomor_id]</td>
		<td align=center>$rows4[nik]</td>
		<td align=center>$rows4[nama]</td>";

		if ($rows5[awal_masuk]=='' OR $rows5[awal_masuk]=='0000-00-00') {
			$awal_masuk_1=$rows4['awal_masuk'];
		}else {
			$awal_masuk_1=$rows5['awal_masuk'];
		}

		echo "
		<td align=center><input type='text' style='width:125px;' name='npwp' value='$rows5[npwp]'></td>
		<td align=center><input type='text' style='width:125px;' name='ktp' value='$rows5[ktp]'></td>
		<td align=center><input type='text' style='width:125px;' name='alamat' value='$rows5[alamat]'></td>
		<td align=center><select name='status_actual'>
			<option value='$rows5[status_actual]'>$rows5[status_actual]</option>
			<option value='K1'>K1</option>
			<option value='K2'>K2</option>
			<option value='K3'>K3</option>
			<option value='TK'>TK</option></select></td>
		<td align=center><select name='status'>
			<option value='$rows5[status]'>$rows5[status]</option>
			<option value='K1'>K1</option>
			<option value='K2'>K2</option>
			<option value='K3'>K3</option>
			<option value='TK'>TK</option></select></td>
		<td align=center><select name='jenis_kelamin'>
			<option value='$rows5[jenis_kelamin]'>$rows5[jenis_kelamin]</option>
			<option value='PRIA'>PRIA</option>
			<option value='WANITA'>WANITA</option></select></td>
		<td align=center><input type='text' style='width:125px;' name='jabatan' value='$rows5[jabatan]'></td>
		<td align=center><input type='text' style='width:125px;' name='gaji_perbulan' value='$rows5[gaji_perbulan]' disabled></td>
		<td align=center><input type='text' style='width:125px;' name='jkk_dan_jkm' value='$rows5[jkk_dan_jkm]' disabled></td>
		<td align=center><input type='text' style='width:125px;' name='potongan' value='$rows5[potongan]' disabled></td>";
//		<td align=center><input type='text' style='width:125px;' name='jumlah' value='$rows5[jumlah]' disabled></td>
echo "<td><input name='mulai_kerja' value='$awal_masuk_1' size='10'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.mulai_kerja);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>";
//		<td align=center><input type='date' style='width:125px;' name='mulai_kerja' value='$awal_masuk_1'></td>
//		<td align=center><input type='text' style='width:125px;' name='lama' value='$rows5[lama]'></td>
//		<td align=center><input type='text' style='width:125px;' name='jumlah_gaji' value='$rows5[jumlah_gaji]' disabled></td>
echo "<td align=center><input type='text' style='width:125px;' name='bpjs' value='$rows5[bpjs]'></td>";
//		<td align=center><input type='text' style='width:125px;' name='bruto' value='$rows5[bruto]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='biaya_jabatan' value='$rows5[biaya_jabatan]' disabled></td>
echo "<td align=center><input type='text' style='width:125px;' name='jamsostek' value='$rows5[jamsostek]' disabled></td>";
//		<td align=center><input type='text' style='width:125px;' name='premi_karyawan' value='$rows5[premi_karyawan]' disabled></td>
echo "<td align=center><input type='text' style='width:125px;' name='bonus_atau_thr' value='$rows5[bonus_atau_thr]'></td>
		  <td align=center><input type='text' style='width:125px;' name='dana_pensiun' value='$rows5[dana_pensiun]' disabled></td>";
//		<td align=center><input type='text' style='width:125px;' name='net' value='$rows5[net]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='ptkp' value='$rows5[ptkp]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='pkp' value='$rows5[pkp]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='limapersen' value='$rows5[limapersen]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='limabelaspersen' value='$rows5[limabelaspersen]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='duapuluhlimapersen' value='$rows5[duapuluhlimapersen]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='tigapuluhpersen' value='$rows5[tigapuluhpersen]' disabled></td>
//		<td align=center><input type='text' style='width:125px;' name='total_tahun' value='$rows5[total_tahun]' disabled></td>
echo "<td align=center><input type='text' style='width:125px;' name='pph_bulan' value='$rows5[pph_bulan]' disabled></td>";

		echo "<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
					<input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
					<input type='hidden' name='update' value='update'>
					<input type='hidden' name='simpan' value='simpan'>
					<input type='hidden' name='pilihan_update' value='$pilihan_update'>";
		echo "</tr>
		<tr>
		<td colspan='2'><input type='submit' name='simpan' value='Simpan'></td>
		<td colspan='31'>$berhasil</td>
		</tr>
		</form></table>";
}
}//END PILIH KARYAWAN


	//UPDATE START
	if ($pilihan_bagian != '' AND $update == '') {
			echo "
			<form action='?menu=home&mod=payroll/Potonganpph' method='POST'>
			<table>
			<input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
			<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
			<input type='hidden' name='update' value='update'/>
			<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Update Data'>
			</table>
			</form></br>";}
	//UPDATE END

//START TABEL AWAL
	if ($pilihan_bagian!='' AND $update == '') {
	echo "
	<table style='background-color:white;' class='tabel_utama' width=300% align=left border=1>
		<tr style='background-color:#C0C0C0;'>
			<th align=center width=auto height=20px>No</th>
			<th align=center width=auto>Nomor ID</th>
			<th align=center width=50px>NIK</th>
			<th align=center width=75px>Nama</th>
			<th align=center width=auto>Departement</th>
			<th align=center width=auto>Bagian</th>
			<th align=center width=auto>NPWP</th>
			<th align=center width=auto>KTP</th>
			<th align=center width=auto>Alamat</th>
			<th align=center width=auto>Status Actual</th>
			<th align=center width=auto>Status</th>
			<th align=center width=auto>Jenis Kelamin</th>
			<th align=center width=auto>Jabatan</th>
			<th align=center width=auto>Gaji Perbulan</th>
			<th align=center width=auto>JKK & JKM</th>
			<th align=center width=auto>Potongan</th>
			<th align=center width=auto>Jumlah</th>
			<th align=center width=auto>Mulai Kerja</th>
			<th align=center width=auto>Lama</th>
			<th align=center width=auto>Jumlah Gaji</th>
			<th align=center width=auto>Bonus/THR</th>
			<th align=center width=auto>Bruto</th>
			<th align=center width=auto>B. Jabatan</th>
			<th align=center width=auto>BPJS</th>
			<th align=center width=auto>Jamsostek</th>
			<th align=center width=auto>Dana Pensiun</th>
			<th align=center width=auto>Premi Karyawan</th>
			<th align=center width=auto>Net</th>
			<th align=center width=auto>PTKP</th>
			<th align=center width=auto>PKP</th>
			<th align=center width=auto>5%</th>
			<th align=center width=auto>15%</th>
			<th align=center width=auto>25%</th>
			<th align=center width=auto>30%</th>
			<th align=center width=auto>Total Tahun</th>
			<th align=center width=auto>PPH/Bulan</th>";

$sql1="SELECT id,nomor_id,nik,nama,departement,bagian FROM payroll_data_karyawan WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian'";
$result1=mysql_query($sql1);
$no=1;
while ($rows1=mysql_fetch_array($result1)) {

$warnaGenap="#FFFFF";
$warnaGanjil="#CEF6F5";
if ($no % 2 == 0){$color1 = $warnaGenap;}else{$color1 = $warnaGanjil;}

	echo "<tr>
	<td style=background-color:$color1; align=center>$no</td>
	<td style=background-color:$color1; align=center>$rows1[nomor_id]</td>
	<td style=background-color:$color1; align=center>$rows1[nik]</td>
	<td style=background-color:$color1; align=center>$rows1[nama]</td>
	<td style=background-color:$color1; align=center>$rows1[departement]</td>
	<td style=background-color:$color1; align=center>$rows1[bagian]</td>";

$sql2="SELECT * FROM payroll_potongan_pph21 WHERE induk='$rows1[id]'";
$result2=mysql_query($sql2);
$rows2=mysql_fetch_array($result2);


if ($rows2[npwp]==''){$nilai_npwp='';}else{$nilai_npwp=npwp($rows2[npwp]);}
echo "<td style=background-color:$color1; align=center>".$nilai_npwp."</td>";
echo "<td style=background-color:$color1; align=center>$rows2[ktp]</td>";
echo "<td style=background-color:$color1; align=center>$rows2[alamat]</td>";
echo "<td style=background-color:$color1; align=center>$rows2[status_actual]</td>";
echo "<td style=background-color:$color1; align=center>$rows2[status]</td>";
echo "<td style=background-color:$color1; align=center>$rows2[jenis_kelamin]</td>";
echo "<td style=background-color:$color1; align=center>$rows2[jabatan]</td>";
echo "<td style=background-color:$color1; align=center>".rupiah($rows2[gaji_perbulan])."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah(jkkdanjkm($rows2[jkk_dan_jkm]))."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah($rows2[potongan])."</td>";

$jumlah_rumus=$rows2[gaji_perbulan]+jkkdanjkm($rows2[jkk_dan_jkm])+$rows2[potongan];
echo "<td style=background-color:$color1; align=center>".rupiah($jumlah_rumus)."</td>";
echo "<td style=background-color:$color1; align=center>$rows2[mulai_kerja]</td>";
echo "<td style=background-color:$color1; align=center>".lama($rows2[mulai_kerja])."</td>";

$gaji_perbulan_rumus=$jumlah_rumus*lama($rows2[mulai_kerja]);
echo "<td style=background-color:$color1; align=center>".rupiah($gaji_perbulan_rumus)."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah($rows2[bonus_atau_thr])."</td>";

$bruto_rumus=$rows2[bonus_atau_thr]+$gaji_perbulan_rumus;
echo "<td style=background-color:$color1; align=center>".rupiah($bruto_rumus)."</td>";

$biaya_jabatan_rumus=$bruto_rumus*5/100;
echo "<td style=background-color:$color1; align=center>".rupiah($biaya_jabatan_rumus)."</td>";

echo "<td style=background-color:$color1; align=center>".rupiah($rows2[bpjs])."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah($rows2[jamsostek])."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah($rows2[dana_pensiun])."</td>";

$premi_karyawan_rumus=$rows2[bpjs]+$rows2[jamsostek]+$rows2[dana_pensiun];
$premi_karyawan_rumus2=$premi_karyawan_rumus*lama($rows2[mulai_kerja]);
echo "<td style=background-color:$color1; align=center>".rupiah(floor($premi_karyawan_rumus2))."</td>";

$net_rumus=$bruto_rumus-$biaya_jabatan_rumus-$premi_karyawan_rumus2;
echo "<td style=background-color:$color1; align=center>".rupiah(floor($net_rumus))."</td>";

$sql7="SELECT * FROM payroll_ptkp WHERE status='$rows2[status]'";
$result7=mysql_query($sql7);
$rows7=mysql_fetch_array($result7);
$ptkp_rumus=$rows7['ptkp'];
echo "<td style=background-color:$color1; align=center>".rupiah($ptkp_rumus)."</td>";

$pkp_rumus=$net_rumus-$ptkp_rumus;
if ($pkp_rumus <= 0){$pkp_rumus2=0;}else{$pkp_rumus2=floor($pkp_rumus);}
echo "<td style=background-color:$color1; align=center>".rupiah(floor($pkp_rumus2))."</td>";

if($pkp_rumus2 <= '50000000'){$limapersen_rumus=$pkp_rumus2*5/100;}
echo "<td style=background-color:$color1; align=center>".rupiah(floor($limapersen_rumus))."</td>";

if($pkp_rumus2 > '50000000' AND $pkp_rumus2 <= '250000000'){$limabelaspersen_rumus=$pkp_rumus2*15/100;}
echo "<td style=background-color:$color1; align=center>".rupiah(floor($limabelaspersen_rumus))."</td>";

if($pkp_rumus2 > '250000000' AND $pkp_rumus2 <= '500000000'){$duapuluhlimapersen_rumus=$pkp_rumus2*25/100;}
echo "<td style=background-color:$color1; align=center>".rupiah(floor($duapuluhlimapersen_rumus))."</td>";

if($pkp_rumus2 > '500000000'){$tigapuluhpersen_rumus=$pkp_rumus2*30/100;}
echo "<td style=background-color:$color1; align=center>".rupiah(floor($tigapuluhpersen_rumus))."</td>";

$total_tahun_rumus=$limapersen_rumus+$limabelaspersen_rumus+$duapuluhlimapersen_rumus+$tigapuluhpersen_rumus;
echo "<td style=background-color:$color1; align=center>".rupiah($total_tahun_rumus)."</td>";

$pph_bulan_rumus=$total_tahun_rumus/lama($rows2[mulai_kerja]);
if (lama($rows2[mulai_kerja]) < 12){$pph_bulan_rumus2=0;}else {$pph_bulan_rumus2=$pph_bulan_rumus;}
echo "<td style=background-color:$color1; align=center>".rupiah(floor($pph_bulan_rumus2))."</td>";

$update_tabel="UPDATE payroll_potongan_pph21 SET pph_bulan='$pph_bulan_rumus2' WHERE induk='$rows1[id]'";
$eksekusi_update_tabel=mysql_query($update_tabel);

$no++;}
}//END TABEL AWAL

echo "</tr></table>";
}//END HOME
//END PHP?>
