<?php global $mod;
	$mod='hrdpayroll/gajian';
function editmenu(){extract($GLOBALS);}

function pegawai_baru($tanggal_masuk,$tanggal_gajian){
$tgl1=$tanggal_masuk;
$tgl2=$tanggal_gajian;
$a = datediff($tgl1, $tgl2);
$selisih_tahun=$a[years]*12;
$selisih_bulan=$a[months]+$selisih_tahun;
if ($selisih_bulan>=1) {
	$nilai='no';
}else {
	$nilai='yes';
}
return $nilai;}

function thr($tanggal_masuk,$tanggal_gajian,$thr){
$tgl1=$tanggal_masuk;
$tgl2=$tanggal_gajian;
$a = datediff($tgl1, $tgl2);
$selisih_tahun=$a[years]*12;
$selisih_bulan=$a[months]+$selisih_tahun;

if ($selisih_bulan>='1' AND $selisih_bulan<='11') {
	$nilai=$thr/12;
	$dapet_thr=$nilai*$selisih_bulan;
}elseif ($selisih_bulan>='12') {
	$dapet_thr=$thr;
}

return $dapet_thr;}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function buat_list_checkbox($list_akses,$jumlah_list_akses){
		$no=0;for($i=0; $i < $jumlah_list_akses; ++$i){
			$datasecs[]="".$list_akses[$no]."";
		$no++;}
			$data=implode(",", $datasecs);
return $data;}

function total_absensi($jenis,$nama_database,$where){
			$sql=mysql_query("SELECT SUM($jenis) FROM $nama_database WHERE $where");
			$rows=mysql_fetch_array($sql);
			$show=$rows["SUM($jenis)"];
return $show;}

function setengah_hari($id_pegawai,$periode,$gaji_pokok){
	$sql=mysql_query("SELECT * FROM hrd_payroll_absensi_items WHERE id_pegawai='$id_pegawai' AND tanggal LIKE '$periode%' AND setengah_hari NOT LIKE ''");
	while ($rows=mysql_fetch_array($sql)) {
		$nilai=floor($gaji_pokok/30/$rows[total_jam_kerja]*$rows[terlambat]);
		$grand_nilai=$nilai+$grand_nilai;
	}
return $grand_nilai;}

function terlambat($id_pegawai,$periode,$gaji_pokok){
	$sql=mysql_query("SELECT * FROM hrd_payroll_absensi_items WHERE id_pegawai='$id_pegawai' AND tanggal LIKE '$periode%' AND terlambat NOT LIKE ''");
	while ($rows=mysql_fetch_array($sql)) {
		$nilai=floor($gaji_pokok/30/$rows[total_jam_kerja]*$rows[terlambat]);
		$grand_nilai=$nilai+$grand_nilai;
	}
return $grand_nilai;}

function pulang_cepat($id_pegawai,$periode,$gaji_pokok){
	$sql=mysql_query("SELECT * FROM hrd_payroll_absensi_items WHERE id_pegawai='$id_pegawai' AND tanggal LIKE '$periode%' AND pulang_cepat NOT LIKE ''");
	while ($rows=mysql_fetch_array($sql)) {
		$nilai=floor($gaji_pokok/30/$rows[total_jam_kerja]*$rows[pulang_cepat]);
		$grand_nilai=$nilai+$grand_nilai;
	}
return $grand_nilai;}

function total_telat_pulpet($id_pegawai,$periode,$jenis){
	$sql=mysql_query("SELECT * FROM hrd_payroll_absensi_items WHERE id_pegawai='$id_pegawai' AND tanggal LIKE '$periode%' AND $jenis NOT LIKE ''");
	$data=mysql_num_rows($sql);
return $data;}

function premi($tunjangan_bonus_kehadiran,$alpa,$cuti,$ijin,$dokter,$telat,$pulang_cepat,$setengah_hari){
	$hasil_alpa=$alpa*100000;
	$hasil_cuti=$cuti*50000;
	$hasil_ijin=$ijin*50000;
	$hasil_dokter=$dokter*50000;
	$hasil_telat=$telat*25000;
	$hasil_pulang_cepat=$pulang_cepat*25000;
	$hasil_setengah_hari=$setengah_hari*25000;
$hasil=$tunjangan_bonus_kehadiran-$hasil_alpa-$hasil_cuti-$hasil_ijin-$hasil_dokter-$hasil_telat-$hasil_pulang_cepat-$hasil_setengah_hari;

if ($hasil<=0) {
	$nilai='0';
}else {
	$nilai=$hasil;
}

return $nilai;}

function home(){extract($GLOBALS);
include ('function.php');
include 'style.css';
$column_header='nik,nama,bagian';

$nama_database='hrd_payroll_absensi_items';
//='deliverycl_invoice_items';
$address='?mod=hrdpayroll/gajian';

$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);

if ($_POST['pilihan_tahun']) {
	$nomor_halaman=$_POST['halaman'];
	$pilihan_tahun=$_POST['pilihan_tahun'];
	$pilihan_bulan=$_POST['pilihan_bulan'];
	$pilihan_pencarian=$_POST['pilihan_pencarian'];
	$pencarian=$_POST['pencarian'];
}
if ($_GET['pilihan_tahun']) {
	$nomor_halaman=$_GET['halaman'];
	$pilihan_tahun=$_GET['pilihan_tahun'];
	$pilihan_bulan=$_GET['pilihan_bulan'];
	$pilihan_pencarian=$_GET['pilihan_pencarian'];
	$pencarian=$_GET['pencarian'];
}
if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}



//UPDATE CHECK BOX
if ($_POST['save_list']) {
$list_pilihan=buat_list_checkbox($_POST['pilihan'],count($_POST['pilihan']));
$nilai_column_id=count($_POST['pilihan']);
$jumlah_column_id=pecah($list_pilihan);

$kunci_list_pilihan=base64_encrypt("$list_pilihan","XblImpl1!A@");
echo '<script type="text/javascript">window.open(\''."modules/hrdpayroll/cetak/cetak_slip.php?id_download=$kunci_list_pilihan&td=$nilai_column_id&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1,width=600'.'\')</script>';
}//UPDATE CHECK BOX END



// PILIHAN TANGGAL DAN PENCARIAN
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
// echo "<option value='All'>All</option>";
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
//END // PILIHAN TANGGAL DAN PENCARIAN


//PRINT
echo "<form method='POST' action='$address'>";
echo "<table><tr>";
echo "<td><input type='submit' name='kembali' value='Print'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='item' value='$item'>
			<input type='hidden' name='save_list' value='1'></td>";
echo "</tr></table>";



//HEADER TABEL
echo "<table class='tabel_utama' style='width:auto;'>";
echo "<thead>";

//TOMBOL CENTANG
echo "<th>";
if ($_GET['centang']==1) {$point_centang=2;}else{$point_centang=1;}
	echo "<a href='$address&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&item=$item&centang=$point_centang&pencarian=$pencarian&pilihan_pencarian=$pilihan_pencarian'>All</a>";
echo "</th>";
//TOMBOL CENTANG END

echo "<th>NO</th>";
$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
	echo "<th><strong>".ambil_database($bahasa,pusat_bahasa,"kode='".$pecah_column_header[$no]."'")."</strong></th>";
$no++;}
echo "<th>Absensi</th>";
echo "<th>Lembur</th>";
echo "<th>Gaji Pokok</th>";
echo "<th>Uang</br>Profesional</th>";
echo "<th>Bonus</br>Kehadiran</th>";
echo "<th>Uang</br>Makan</th>";
echo "<th>Uang</br>Transport</th>";
echo "<th>Uang</br>Shift</th>";
echo "<th>Lembur 1</th>";
echo "<th>Lembur 2</th>";
echo "<th>Lembur 3</th>";
echo "<th>Lembur 4</th>";
echo "<th>THR</th>";
echo "<th>Jumlah</br>Pemasukan</th>";
echo "<th>BPJS</th>";
echo "<th>JAMSOSTEK</th>";
echo "<th>DANA</br>PENSIUN</th>";
echo "<th>POT ABSENT</th>";
echo "<th>POT 1/2 HARI</th>";
echo "<th>POT TELAT</th>";
echo "<th>POT PULANG CPT</th>";
echo "<th>Jumlah</br>Potongan</th>";
echo "<th>Total</br>Gaji</th>";

			//TOMBOL CENTANG
			// echo "<th>";
			// if ($_GET['centang']==1) {$point_centang=2;}else{$point_centang=1;}
			// 	echo "<a href='$address&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&item=$item&centang=$point_centang&pencarian=$pencarian&pilihan_pencarian=$pilihan_pencarian'>All</a>";
			// echo "</th>";
			//TOMBOL CENTANG END

echo "</thead>";
//HEADER TABEL END


if ($_GET['centang']==1) {$hasil="checked";}elseif($_GET['centang']==2){$hasil="";}else{$hasil="";}
if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
//if ($pilihan_tahun=='All'){$pilihan_tahun2='20'; $pilihan_bulan2='';}else{$pilihan_tahun2=$pilihan_tahun; $pilihan_bulan2="-$pilihan_bulan";}


//PAGING
$halaman = 100;
if ($_GET['centang']==1) {$hasil="checked";}elseif($_GET['centang']==2){$hasil="";}else{$hasil="";}


$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT	DISTINCT id_pegawai FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT DISTINCT id_pegawai FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian ORDER BY tanggal DESC LIMIT $mulai, $halaman")or die(mysql_error);
$no_urut =$mulai+1;
//PAGING

while ($rows1=mysql_fetch_array($query)) {

	echo "<tr style='height:30px;'>";
		echo "<td><input type='checkbox' name='pilihan[]' value='$rows1[id_pegawai]' $hasil></td>";
		echo "<td>$no_urut</td>";
		echo "<td>".ambil_database(nik,$nama_database,"id_pegawai='".$rows1[id_pegawai]."' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'")."</td>";
		echo "<td>".ambil_database(nama,$nama_database,"id_pegawai='".$rows1[id_pegawai]."' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'")."</td>";
		echo "<td>".ambil_database(bagian,$nama_database,"id_pegawai='".$rows1[id_pegawai]."' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'")."</td>";

		//Parameter Absensi
		echo "<td><table style='width:100px;'>";

		$hk=total_absensi(hari_kerja,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$um=total_absensi(uang_makan,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$ut=total_absensi(uang_transport,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$us=total_absensi(uang_shift,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$alpa=total_absensi(alpa,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$cuti=total_absensi(cuti,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$ijin=total_absensi(ijin,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$dokter=total_absensi(dokter,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$setengah_hari=total_absensi(setengah_hari,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$telat=total_absensi(terlambat,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$pulang_cepat=total_absensi(pulang_cepat,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");

				echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>HK</td>";
				echo "<td style='border:0px solid; text-align:left;'>: $hk</td>";
				echo "</tr>";
							echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>UM</td>";
							echo "<td style='border:0px solid; text-align:left;'>: $um</td>";
							echo "</tr>";
				echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>UT</td>";
				echo "<td style='border:0px solid; text-align:left;'>: $ut</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>US</td>";
				echo "<td style='border:0px solid; text-align:left;'>: $us</td>";
				echo "</tr>";
							echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>ABS</td>";
							echo "<td style='border:0px solid; text-align:left;'>: $alpa</td>";
							echo "</tr>";
				echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>CUTI</td>";
				echo "<td style='border:0px solid; text-align:left;'>: $cuti</td>";
				echo "</tr>";
							echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>IJIN</td>";
							echo "<td style='border:0px solid; text-align:left;'>: $ijin</td>";
							echo "</tr>";
				echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>DOKTER</td>";
				echo "<td style='border:0px solid; text-align:left;'>: $dokter</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>1/2 HARI (jam)</td>";
				echo "<td style='border:0px solid; text-align:left;'>: $setengah_hari</td>";
				echo "</tr>";
							echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>TELAT (jam)</td>";
							echo "<td style='border:0px solid; text-align:left;'>: $telat</td>";
							echo "</tr>";
				echo "<tr>";
				echo "<td style='border:0px solid; text-align:left;'>P.CEPAT (jam)</td>";
				echo "<td style='border:0px solid; text-align:left;'>: $pulang_cepat</td>";
				echo "</tr>";

		echo "</table></td>";
		//Parameter Absensi End


		//PARAMETER LEMBURAN
		echo "<td><table style='width:65px;'>";
		$lembur_1=total_absensi(lembur_1,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$lembur_2=total_absensi(lembur_2,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$lembur_3=total_absensi(lembur_3,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		$lembur_4=total_absensi(lembur_4,$nama_database,"id_pegawai='$rows1[id_pegawai]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");

			echo "<tr>";
			echo "<td style='border:0px solid; text-align:left;'>OT 1.5</td>";
			echo "<td style='border:0px solid; text-align:left;'>: $lembur_1</td>";
			echo "</tr>";
							echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>OT 2</td>";
							echo "<td style='border:0px solid; text-align:left;'>: $lembur_2</td>";
							echo "</tr>";
			echo "<tr>";
			echo "<td style='border:0px solid; text-align:left;'>OT 3</td>";
			echo "<td style='border:0px solid; text-align:left;'>: $lembur_3</td>";
			echo "</tr>";
							echo "<tr>";
							echo "<td style='border:0px solid; text-align:left;'>OT 4</td>";
							echo "<td style='border:0px solid; text-align:left;'>: $lembur_4</td>";
							echo "</tr>";

		echo "</table></td>";
		//PARAMETER LEMBURAN END

		//GAJI POKOK
		$tunjangan_gaji_pokok=ambil_database(gaji_pokok,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		$pegawai_baru=pegawai_baru(ambil_database(tanggal_masuk,hrd_data_karyawan,"id='".$rows1[id_pegawai]."'"),"$pilihan_tahun-$pilihan_bulan-$tunjangan_jumlah_hari");
		if ($pegawai_baru=='yes') {
			$gaji_pokok=$tunjangan_gaji_pokok/$tunjangan_jumlah_hari*$hk;
		}else{
			$gaji_pokok=$tunjangan_gaji_pokok;
		}
		echo "<td style='white-space:nowrap'>".rupiah($gaji_pokok)."</td>";
		//GAJI POKOK END

		//UANG PROFESIONAL
		$uang_profesional=ambil_database(uang_profesional,$nama_database,"id_pegawai='".$rows1[id_pegawai]."' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
		echo "<td style='white-space:nowrap'>".rupiah($uang_profesional)."</td>";
		//UANG PROFESIONAL END

		//BONUS KEHADIRAN
		$tunjangan_bonus_kehadiran=ambil_database(bonus_kehadiran,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		$jumlah_telat=total_telat_pulpet($rows1[id_pegawai],"$pilihan_tahun-$pilihan_bulan",terlambat);
		$jumlah_pulang_cepat=total_telat_pulpet($rows1[id_pegawai],"$pilihan_tahun-$pilihan_bulan",pulang_cepat);
		$jumlah_setengah_hari=total_telat_pulpet($rows1[id_pegawai],"$pilihan_tahun-$pilihan_bulan",setengah_hari);
		$bonus_kehadiran=premi($tunjangan_bonus_kehadiran,$alpa,$cuti,$ijin,$dokter,$jumlah_telat,$jumlah_pulang_cepat,$jumlah_setengah_hari);
		echo "<td style='white-space:nowrap'>".rupiah($bonus_kehadiran)."</td>";
		//BONUS KEHADIRAN END

		//UANG MAKAN
		$tunjangan_uang_makan=ambil_database(uang_makan,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		$uang_makan=$um*$tunjangan_uang_makan;
		echo "<td style='white-space:nowrap'>".rupiah($uang_makan)."</td>";
		//BONUS MAKAN END

		//UANG TRANSPORT
		$tunjangan_uang_transport=ambil_database(uang_transport,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		$uang_transport=$ut*$tunjangan_uang_transport;
		echo "<td style='white-space:nowrap'>".rupiah($uang_transport)."</td>";
		//BONUS TRANSPORT END

		//UANG SHIFT
		$tunjangan_uang_shift=ambil_database(uang_shift,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		$uang_shift=$us*$tunjangan_uang_shift;
		echo "<td style='white-space:nowrap'>".rupiah($uang_shift)."</td>";
		//UANG SHIFT END

		//UANG LEMBUR
		$tunjangan_lemburan=floor($tunjangan_gaji_pokok/173);
		$nilai_lembur_1=1.5*$tunjangan_lemburan*$lembur_1;
		echo "<td style='white-space:nowrap'>".rupiah($nilai_lembur_1)."</td>";
		$nilai_lembur_2=2*$tunjangan_lemburan*$lembur_2;
		echo "<td style='white-space:nowrap'>".rupiah($nilai_lembur_2)."</td>";
		$nilai_lembur_3=3*$tunjangan_lemburan*$lembur_3;
		echo "<td style='white-space:nowrap'>".rupiah($nilai_lembur_3)."</td>";
		$nilai_lembur_4=4*$tunjangan_lemburan*$lembur_4;
		echo "<td style='white-space:nowrap'>".rupiah($nilai_lembur_4)."</td>";
		//UANG LEMBUR END

		//UANG THR
		$tunjangan_thr=ambil_database(thr,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		$thr=thr(ambil_database(tanggal_masuk,hrd_data_karyawan,"id='".$rows1[id_pegawai]."'"),"$pilihan_tahun-$pilihan_bulan-$tunjangan_jumlah_hari",$tunjangan_thr);
		echo "<td style='white-space:nowrap'>".rupiah($thr)."</td>";
		//UANG THR END

		//JUMLAH PEMASUKAN
		$jumlah_pemasukan=$gaji_pokok+$uang_profesional+$bonus_kehadiran+$uang_makan+$uang_transport+$uang_shift+$nilai_lembur_1+$nilai_lembur_2+$nilai_lembur_3+$nilai_lembur_4+$thr;
		echo "<td style='white-space:nowrap'>".rupiah($jumlah_pemasukan)."</td>";
		//JUMLAH PEMASUKAN END

		//BPJS
		$tunjangan_bpjs=ambil_database(bpjs,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		$tanggungan_bpjs=ambil_database(tambah_bpjs,$nama_database,"id_pegawai='".$rows1[id_pegawai]."' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'")+1;
		$bpjs=$tanggungan_bpjs*$tunjangan_bpjs;
		echo "<td style='white-space:nowrap'>".rupiah($bpjs)."</td>";
		//BPJS END

		//JAMSOSTEK
		$tunjangan_jamsostek=ambil_database(jamsostek,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		echo "<td style='white-space:nowrap'>".rupiah($tunjangan_jamsostek)."</td>";
		//JAMSOSTEK END

		//DANA PENSIUN
		$tunjangan_dana_pensiun=ambil_database(dana_pensiun,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
		echo "<td style='white-space:nowrap'>".rupiah($tunjangan_dana_pensiun)."</td>";
		//DANA PENSIUN END

		//POT ABSENT
		$gaji_pokok_uang_profesional=$gaji_pokok+$uang_profesional;
		$rumus_pot_absent=$gaji_pokok_uang_profesional/$tunjangan_jumlah_hari;
		$pot_absent_ijin=$rumus_pot_absent*$ijin;
		$pot_absent_alpa=$rumus_pot_absent*$alpa;
		$pot_absent=$pot_absent_ijin+$pot_absent_alpa;
		echo "<td style='white-space:nowrap'>".rupiah($pot_absent)."</td>";
		//POT ABSENT END

		//SETENGAH HARI
		$total_setengah_hari=setengah_hari($rows1[id_pegawai],"$pilihan_tahun-$pilihan_bulan",$gaji_pokok);
		echo "<td style='white-space:nowrap'>".rupiah($total_setengah_hari)."</td>";
		//SETENGAH HARI END

		//TERLAMBAT
		$total_telat=terlambat($rows1[id_pegawai],"$pilihan_tahun-$pilihan_bulan",$gaji_pokok);
		echo "<td style='white-space:nowrap'>".rupiah($total_telat)."</td>";
		//TERLAMBAT END

		//PULANG CEPAT
		$total_pulang_cepat=pulang_cepat($rows1[id_pegawai],"$pilihan_tahun-$pilihan_bulan",$gaji_pokok);
		echo "<td style='white-space:nowrap'>".rupiah($total_pulang_cepat)."</td>";
		//PULANG CEPAT END

		//JUMLAH POTONGAN
		$jumlah_potongan=$bpjs+$tunjangan_jamsostek+$tunjangan_dana_pensiun+$pot_absent+$total_telat+$total_pulang_cepat+$total_setengah_hari;
		echo "<td style='white-space:nowrap'>".rupiah($jumlah_potongan)."</td>";
		//JUMLAH POTONGAN END

		//TOTAL GAJI
		$total_gaji=$jumlah_pemasukan-$jumlah_potongan;
		echo "<td style='white-space:nowrap'>".rupiah($total_gaji)."</td>";
		//TOTAL GAJI END

	echo "</tr>";

$no_urut++;}
echo "</form>";


//PAGING KLIK
if ($total > '100') {
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



}//END HOME
//END PHP?>
