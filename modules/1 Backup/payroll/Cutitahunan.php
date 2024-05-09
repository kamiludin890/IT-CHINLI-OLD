<?php global $mod;
	$mod='payroll/Cutitahunan';
function editmenu(){extract($GLOBALS);}

function datediff($tgl1, $tgl2){
$tgl1 = strtotime($tgl1);
$tgl2 = strtotime($tgl2);
$diff_secs = abs($tgl1 - $tgl2);
$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
}

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

function selisih($nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$jenis){
	if ($jenis=='sisakontrak') {
		$tgl1=date("Y-m-d");
		$tgl2=$selesai_kontrak;}
	if ($jenis=='lamakontrak') {
		$tgl1=$mulai_kontrak;
		$tgl2=$selesai_kontrak;}
	if ($jenis=='lamabekerja') {
		$tgl1=$awal_masuk;
		$tgl2=date("Y-m-d");}
	$a = datediff($tgl1, $tgl2);
	//echo 'tanggal 1 = '.$tgl1; echo '<br>';
	//echo 'tanggal 2 = '.$tgl2; echo '<br>';
	$Selisih=$a[years].' tahun '.$a[months].' bulan '.$a[days].' hari';//.$a[hours].' jam '.$a[minutes].' menit '.$a[seconds].' detik';
//return "$nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$jenis";
return $Selisih;}

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

function cutiterpakai($nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$id,$jenis){
	$tgl1=$awal_masuk;
	$tgl2=date("Y-m-d");
	$a = datediff($tgl1, $tgl2);
//	echo $a[years]."</br>";
	$jumlah_tahun=$a[years];
	if ($a[years] == 1 AND $a[days] == 0) {
		$tahun_pertama = $awal_masuk;
		$tahun_kedua = date('Y-m-d', strtotime('+1 years', strtotime($awal_masuk)));}
	if ($a[years] >= 1 AND $a[days] >= 1) {
		$jumlah_tahun_dikurang_satu=$jumlah_tahun;
		$jumlah_tahun_ditambah_satu=$jumlah_tahun+1;
		$ambil_tahunnya=substr($awal_masuk,0,4);
		$ambil_bulan_hari=substr($awal_masuk,5,5);
		$rill_tahun=$ambil_tahunnya+$jumlah_tahun_dikurang_satu;
		$tahun_pertama = "$rill_tahun-$ambil_bulan_hari";
		$tahun_kedua = date('Y-m-d', strtotime("+$jumlah_tahun_ditambah_satu years", strtotime($awal_masuk)));}
		$sql4="SELECT status FROM payroll_absensi WHERE nomor_id='$nomor_id' AND status='CUTI' AND tanggal BETWEEN '$tahun_pertama' AND '$tahun_kedua'";
		$result4= mysql_query($sql4);
		$count_header=mysql_num_rows($result4);
		$rows4=mysql_fetch_array($result4);
		$sql5="SELECT total_cuti FROM payroll_cuti_tahunan WHERE induk='$id'";
		$result5= mysql_query($sql5);
		$rows5=mysql_fetch_array($result5);
		if ($jenis=='cutiterpakai'){
			$total_cuti1="Periode $tahun_pertama s/d $tahun_kedua adalah $count_header";}
		if ($jenis=='cutitersisa'){
			$total_cuti1=$rows5['total_cuti']-$count_header;}
		return $total_cuti1;}

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
	echo "<h2><center>Data Cuti Tahunan Karyawan</center></h2>";
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Cutitahunan'>
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
	$sql1="SELECT bagian FROM payroll_jamkerja WHERE departement='$pilihan_departement' ORDER BY urut";
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

	echo kalender();
	echo combobox();

	if ($pilihan_update) {
	$sql4="SELECT id,nomor_id,nik,nama,awal_masuk,mulai_kontrak,akhir_kontrak FROM payroll_data_karyawan WHERE id='$pilihan_update'";
	$result4=mysql_query($sql4);
	$rows4=mysql_fetch_array($result4);}

	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Cutitahunan'>";
	echo "
	<tr>
	<td>Karyawan</td>
	<td>:</td>
	<td><select class='comboyuk' name='pilihan_update'>
		 <option value='$pilihan_update'>".$rows4[nik]." ".$rows4[nama]."</option>";
	$sql3="SELECT id,nomor_id,nik,nama FROM payroll_data_karyawan WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian' ORDER BY nomor_id";
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
	$awal_masuk=$_POST['awal_masuk'];
	$mulai_kontrak=$_POST['mulai_kontrak'];
	$selesai_kontrak=$_POST['selesai_kontrak'];
	$total_cuti=$_POST['total_cuti'];
	//AMBIL POST KEDUA END

	if ($simpan) {

		$sql6="SELECT induk FROM payroll_cuti_tahunan WHERE induk='$pilihan_update'";
		$result6=mysql_query($sql6);
		$rows6=mysql_fetch_array($result6);

		if ($rows6['induk'] == '' OR $rows6['induk'] == '0'){
			$update_data="INSERT INTO payroll_cuti_tahunan SET
			total_cuti='$total_cuti',
			induk='$pilihan_update',
			awal_masuk='$awal_masuk',
			mulai_kontrak='$mulai_kontrak',
			selesai_kontrak='$selesai_kontrak',
			sisa_kontrak='$sisa_kontrak',
			lama_kontrak='$lama_kontrak',
			lama_bekerja='$pph_bulan' ";
			$eksekusi_update_data=mysql_query($update_data);
			$berhasil="Data Berhasil di Simpan";
		}else {
		$update_data="UPDATE payroll_cuti_tahunan SET
		total_cuti='$total_cuti',
		awal_masuk='$awal_masuk',
		mulai_kontrak='$mulai_kontrak',
		selesai_kontrak='$selesai_kontrak',
		sisa_kontrak='$sisa_kontrak',
		lama_kontrak='$lama_kontrak',
		lama_bekerja='$pph_bulan' WHERE induk='$pilihan_update'";
		$eksekusi_update_data=mysql_query($update_data);
		$berhasil="Data Berhasil di Simpan";
		}
	}

	echo "
	<table class='tabel_utama'>
	<thead>
		<th align=center width=auto>Nomor ID</th>
		<th align=center width=auto>Nik</th>
		<th align=center width=auto>Nama</th>
		<th align=center width=auto>Awal Masuk</th>
		<th align=center width=auto>Mulai Kontrak</th>
		<th align=center width=auto>Selesai Kontrak</th>
		<th align=center width=auto>Cuti Tahunan</th>

		<th align=center width=auto>Sisa Kontrak</th>
		<th align=center width=auto>Lama Kontrak</th>
		<th align=center width=auto>Lama Bekerja</th>
	</thead>";

	//Skrip Tambahan Kalender
		echo "
		<iframe width=174 height=189 name='gToday:normal:agenda.js' id='gToday:normal:agenda.js' src='modules/payroll/calender/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;'>
		</iframe>";
	//Skrip Tambahan Kalender

	echo "
	<form method ='post' action='?menu=home&mod=payroll/Cutitahunan' name='forminputtanggal' enctype='multipart/form-data'>
	<tr>";
	$sql5="SELECT * FROM payroll_cuti_tahunan WHERE induk='$pilihan_update'";
	$result5=mysql_query($sql5);
	$rows5=mysql_fetch_array($result5);

		echo "<tr>
		<td align=center>$rows4[nomor_id]</td>
		<td align=center>$rows4[nik]</td>
		<td align=center>$rows4[nama]</td>";

if ($rows5[awal_masuk]=='' OR $rows5[awal_masuk]=='0000-00-00' OR $rows5[mulai_kontrak]=='' OR $rows5[mulai_kontrak]=='0000-00-00' OR $rows5[selesai_kontrak]=='' OR $rows5[selesai_kontrak]=='0000-00-00') {
	$awal_masuk_1=$rows4['awal_masuk'];
	$mulai_kontrak_1=$rows4['mulai_kontrak'];
	$selesai_kontrak_1=$rows4['akhir_kontrak'];
}else {
	$awal_masuk_1=$rows5['awal_masuk'];
	$mulai_kontrak_1=$rows5['mulai_kontrak'];
	$selesai_kontrak_1=$rows5['selesai_kontrak'];
}

		echo "
		<td><input name='awal_masuk' value='$awal_masuk_1' size='10'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.awal_masuk);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>
		<td><input name='mulai_kontrak' value='$mulai_kontrak_1' size='10'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.mulai_kontrak);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>
		<td><input name='selesai_kontrak' value='$selesai_kontrak_1' size='10'>&nbsp;<a href='javascript:void(0)' onClick='if(self.gfPop)gfPop.fPopCalendar(document.forminputtanggal.selesai_kontrak);return false;' ><img name='popcal' align='absmiddle' src='modules/payroll/calender/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>
		<td align=center><input type='number' style='width:125px;' name='total_cuti' value='$rows5[total_cuti]' disabled></td>
		<td align=center><input type='text' style='width:125px;' name='sisa_kontrak' value='$rows5[sisa_kontrak]' disabled></td>
		<td align=center><input type='text' style='width:125px;' name='lama_kontrak' value='$rows5[lama_kontrak]' disabled></td>
		<td align=center><input type='text' style='width:125px;' name='lama_bekerja' value='$rows5[lama_bekerja]' disabled></td>
		";

		echo "<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
					<input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
					<input type='hidden' name='update' value='update'>
					<input type='hidden' name='simpan' value='simpan'>
					<input type='hidden' name='pilihan_update' value='$pilihan_update'>";
		echo "</tr>
		<tr>
		<td><input type='submit' name='simpan' value='Simpan'></td>
		<td>$berhasil</td>
		</tr>
		</form></table>";
}
}//END PILIH KARYAWAN


	//UPDATE START
	if ($pilihan_bagian != '' AND $update == '') {
			echo "
			<form action='?menu=home&mod=payroll/Cutitahunan' method='POST'>
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
		<table class='tabel_utama'>
		<thead>
			<th align=center width=auto>No</th>
			<th align=center width=auto>Nomor ID</th>
			<th align=center width=auto>Nik</th>
			<th align=center width=auto>Nama</th>
			<th align=center width=auto>Departement</th>
			<th align=center width=auto>Bagian</th>
			<th align=center width=auto>Awal Masuk</th>
			<th align=center width=auto>Mulai Kontrak</th>
			<th align=center width=auto>Selesai Kontrak</th>
			<th align=center width=auto>Sisa Kontrak</th>
			<th align=center width=auto>Lama Kontrak</th>
			<th align=center width=auto>Lama Bekerja</th>
			<th align=center width=auto>Cuti Tahunan</th>
			<th align=center width=auto>Cuti Terpakai</th>
			<th align=center width=auto>Cuti Tersisa</th>
		</thead>";

$sql1="SELECT id,nomor_id,nik,nama,departement,bagian FROM payroll_data_karyawan WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian' ORDER BY nomor_id";
$result1=mysql_query($sql1);
$no=1;
while ($rows1=mysql_fetch_array($result1)) {

$warnaGenap="#FFFFF";
$warnaGanjil="#CEF6F5";
if ($no % 2 == 0){$color1 = $warnaGenap;}else{$color1 = $warnaGanjil;}

	echo "<tr>
	<td style='padding: 10px; background-color:$color1;' align='center' width='auto'>$no</td>
	<td style='background-color:$color1;' align='center' width='auto'>$rows1[nomor_id]</td>
	<td style='background-color:$color1;' align='center' width='auto'>$rows1[nik]</td>
	<td style='background-color:$color1;' align='center' width='auto'>$rows1[nama]</td>
	<td style='background-color:$color1;' align='center' width='auto'>$rows1[departement]</td>
	<td style='background-color:$color1;' align='center' width='auto'>$rows1[bagian]</td>";

$sql2="SELECT * FROM payroll_cuti_tahunan WHERE induk='$rows1[id]'";
$result2=mysql_query($sql2);
$rows2=mysql_fetch_array($result2);

$test=dapatcuti($rows1[id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[selesai_kontrak]);

echo "<td style='background-color:$color1;' align='center' width='auto'>$rows2[awal_masuk]</td>";
echo "<td style='background-color:$color1;' align='center' width='auto'>$rows2[mulai_kontrak]</td>";
echo "<td style='background-color:$color1;' align='center' width='auto'>$rows2[selesai_kontrak]</td>";

echo "<td style='background-color:$color1;' align='center' width='auto'>".selisih($rows1[id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[selesai_kontrak],sisakontrak)."</td>";
echo "<td style='background-color:$color1;' align='center' width='auto'>".selisih($rows1[id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[selesai_kontrak],lamakontrak)."</td>";
echo "<td style='background-color:$color1;' align='center' width='auto'>".selisih($rows1[id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[selesai_kontrak],lamabekerja)."</td>";

echo "<td style='background-color:$color1;' align='center' width='auto'>".dapatcuti($rows1[id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[selesai_kontrak])."</td>";


echo "<td style='background-color:$color1;' align='center' width='auto'>".cutiterpakai($rows1[nomor_id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[selesai_kontrak],$rows1[id],cutiterpakai)."</td>";
echo "<td style='background-color:$color1;' align='center' width='auto'>".cutiterpakai($rows1[nomor_id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[selesai_kontrak],$rows1[id],cutitersisa)."</td>";


$no++;}
}//END TABEL AWAL

echo "</tr></table>";
}//END HOME
//END PHP?>
