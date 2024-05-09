<?php global $mod;
$mod='payroll/Perhitungan';
function editmenu(){extract($GLOBALS);}

function datediff($tgl1, $tgl2){
	$tgl1 = strtotime($tgl1);
	$tgl2 = strtotime($tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );}

function tidak_bekerja_pegawai_baru($pegawai_baru,$nomor_id,$pilihan_tahun,$pilihan_bulan,$tidak_hadir_lainnya){
$ambil_id_terkecil="SELECT MIN(tanggal) FROM payroll_absensi WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND nomor_id='$nomor_id'";
$result_ambil_id_terkecil=mysql_query($ambil_id_terkecil);
$rows_result_ambil_id_terkecil=mysql_fetch_array($result_ambil_id_terkecil);
$tgl1="$pilihan_tahun-$pilihan_bulan-01";
$tgl2=$rows_result_ambil_id_terkecil['MIN(tanggal)'];
$a = datediff($tgl1, $tgl2);
//	echo $a[years]."</br>";
$jumlah_hari_tidak_kerja=$a[days];//dapat nilai ga masuk sebelumnya di tanggal masuk
if ($pegawai_baru==ya){
$nilai=$jumlah_hari_tidak_kerja;}else{$nilai=0;}
return $nilai;}

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

function jumlahhari($month,$year){
$hai = date('t', mktime(0, 0, 0, $month, 1, $year));
return $hai;}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
return $hasil_rupiah;}

function thr($nilai,$tahun,$bulan){
$sql20="SELECT thr,jumlah_hari FROM payroll_gaji_potongan WHERE id='$bulan'";
$result20=mysql_query($sql20);
$rows20=mysql_fetch_array($result20);
$sql21="SELECT awal_masuk FROM payroll_data_karyawan WHERE id='$nilai'";
$result21=mysql_query($sql21);
$rows21=mysql_fetch_array($result21);
$tgl1=$rows21[awal_masuk];
$tgl2=$rows20[jumlah_hari]."-$bulan-$tahun";
$a = datediff($tgl1, $tgl2);
if ($a[years] == 0) {$hasil=$rows20[thr]/12*$a[months];}
if ($a[years] >= 1) {$hasil=$rows20[thr]*1;}
if ($tgl1 == '') {$hasil_sebenarnya='';} else {$hasil_sebenarnya=$hasil;}
return floor($hasil_sebenarnya);}

function halangan($nomor_id,$jenis_halangan,$pilihan_bulan,$pilihan_tahun){
$sql4="SELECT status FROM payroll_absensi WHERE nomor_id='$nomor_id' AND status='$jenis_halangan' AND tanggal LIKE '%$pilihan_tahun-$pilihan_bulan%'";
$result4= mysql_query($sql4);
$count_header=mysql_num_rows($result4);
$rows4=mysql_fetch_array($result4);
return $count_header;}

function gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja){
$sql7="SELECT gaji_pokok,jumlah_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result7= mysql_query($sql7);
$rows7=mysql_fetch_array($result7);
if ($hari_kerja==0){//$pegawai_baru==ya OR
$gaji_pokok=$rows7[gaji_pokok]/$rows7[jumlah_hari]*$hari_kerja;}else {$gaji_pokok=$rows7[gaji_pokok];}
return $gaji_pokok;}

function bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$nilai_tidak_bekerja,$setengah_hari){
$sql8="SELECT bonus_kehadiran FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result8= mysql_query($sql8);
$rows8=mysql_fetch_array($result8);
$hasil_cuti=$cuti*50000;
$hasil_ijin=$ijin*50000;
$hasil_mangkir=$mangkir*100000;
$hasil_dokter=$dokter*50000;
$hasil_dispensasi=$dispensasi*50000;
$hasil_terlambat=$terlambat*25000;
$hasil_pulang_cepat=$pulang_cepat*25000;
$hasil_setengah_hari=$setengah_hari*25000;
$hasil_sebenarnya2=$rows8[bonus_kehadiran]-$hasil_cuti-$hasil_ijin-$hasil_mangkir-$hasil_dokter-$hasil_dispensasi-$hasil_terlambat-$hasil_pulang_cepat-$hasil_setengah_hari;
if ($hasil_sebenarnya2 < 0){$hasil_sebenarnya=0;}else{$hasil_sebenarnya=$hasil_sebenarnya2;}
if ($nilai_tidak_bekerja>=1 OR $hari_kerja==0){$nilai=0;}else {$nilai=$hasil_sebenarnya;}
return $nilai;}

function uangshift($nomor_id,$pilihan_bulan,$pilihan_tahun){
$sql13="SELECT 	uang_shift_satu_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result13= mysql_query($sql13);
$rows13=mysql_fetch_array($result13);
$sql14="SELECT * FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('','SETENGAH HARI')";
$result14= mysql_query($sql14);
while ($rows14=mysql_fetch_array($result14)) {
$jam_pulang_shift3 = substr($rows14['scan_pulang'],0,2);
if ($jam_pulang_shift3 >= '03' AND $jam_pulang_shift3 <= '08'){$nilai=1;}else{$nilai=0;}
$total_nilai=$nilai+$total_nilai;}
$nilai_sebenarnya=$total_nilai*$rows13[uang_shift_satu_hari];
return $nilai_sebenarnya;}

function uangtransport($nomor_id,$pilihan_bulan,$pilihan_tahun){
$sql11="SELECT uang_transport_satu_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result11= mysql_query($sql11);
$rows11=mysql_fetch_array($result11);
$sql12="SELECT * FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('','SETENGAH HARI')";
$result12= mysql_query($sql12);
while ($rows12=mysql_fetch_array($result12)) {
if ($rows12[scan_masuk]=='00:00:00'){$uang_transport_seleksi='0';}else{$uang_transport_seleksi='1';}
$total_transport_seleksi=$uang_transport_seleksi+$total_transport_seleksi;}
$total_transport_diperoleh=$total_transport_seleksi*$rows11[uang_transport_satu_hari];
return $total_transport_diperoleh;}

function uangmakan($nomor_id,$pilihan_bulan,$pilihan_tahun){
$sql9="SELECT uang_makan_satu_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result9= mysql_query($sql9);
$rows9=mysql_fetch_array($result9);
$sql10="SELECT * FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status='' AND uang_makan IN ('Ya','')";
$result10= mysql_query($sql10);
while ($rows10=mysql_fetch_array($result10)) {
$ambiljam = substr($rows10['jumlah_kehadiran'],0,2);
$ambilmenit = substr($rows10['jumlah_kehadiran'],3,2);
$ambilmenitdarijam = $ambiljam*60;
$total_menit_lemburan = $ambilmenit+$ambilmenitdarijam;

$sql11="SELECT durasi_istirahat FROM payroll_jamkerjaitems WHERE hari='$rows10[hari_uang_makan]' AND departement='$rows10[departement]' AND bagian='$rows10[bagian]'";
$result11= mysql_query($sql11);
$rows11=mysql_fetch_array($result11);
$ambiljam1 = substr($rows11['durasi_istirahat'],0,2);
$ambilmenit1 = substr($rows11['durasi_istirahat'],3,2);
$ambilmenitdarijam1 = $ambiljam1*60;
$total_menit_lemburan1 = $ambilmenit1+$ambilmenitdarijam1;

$total_seluruh_menit=$total_menit_lemburan-$total_menit_lemburan1;

if ($total_seluruh_menit < 420){$tanggal_seleksi='0';}else{$tanggal_seleksi='1';}
$total_seleksi=$tanggal_seleksi+$total_seleksi;}
$total_diperoleh=$total_seleksi*$rows9[uang_makan_satu_hari];
return $total_diperoleh;}

function setengah_hari($nomor_id,$pilihan_bulan,$pilihan_tahun){
	$sql="SELECT status FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('SETENGAH HARI')";
  $result=mysql_query($sql);
  $rows=mysql_fetch_array($result);
  $setengah_hari=mysql_num_rows($result);
return $setengah_hari;}

function total_telat_diatas_35m($nomor_id,$jenis_terlambat,$pilihan_bulan,$pilihan_tahun){
$sql5="SELECT $jenis_terlambat FROM payroll_absensi WHERE nomor_id='$nomor_id' AND $jenis_terlambat != '00:00:00' AND tanggal LIKE '%$pilihan_tahun-$pilihan_bulan%' AND status != 'SETENGAH HARI'";
$result5= mysql_query($sql5);
while ($rows5=mysql_fetch_array($result5)) {
$ambiljam = substr($rows5["$jenis_terlambat"],0,2);
$ambilmenit = substr($rows5["$jenis_terlambat"],3,2);
$jumlah_jam = $ambiljam+$jumlah_jam;
$jumlah_menit = $ambilmenit+$jumlah_menit;
$dibagi60detik = $jumlah_menit/60;
$ambil_jam_dari_hasil = Floor($dibagi60detik);
$perkalian = $ambil_jam_dari_hasil*60;
$jam_sebenarnya = $jumlah_jam+$ambil_jam_dari_hasil;
$menit_sebenarnya = $jumlah_menit-$perkalian;
//return "$jam_sebenarnya:$menit_sebenarnya";
if ($jenis_terlambat==pulang_cepat){$nominal_nilai=1;}
if ($jenis_terlambat==terlambat){$nominal_nilai=6;}
$total_menit_sepenuhnya1=$jumlah_jam*60+$jumlah_menit;
if ($total_menit_sepenuhnya1 >= $nominal_nilai){$nilai=1;}else{$nilai=0;}
$total_telat=$nilai+$total_telat;
}
return $total_telat;
}

function potongan_telat_pulang_cepat($nomor_id,$jenis_potongan,$pilihan_bulan,$pilihan_tahun,$pilihan_departement,$pilihan_bagian){
$sql16="SELECT gaji_pokok,jumlah_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result16= mysql_query($sql16);
$rows16=mysql_fetch_array($result16);
$sql17="SELECT uang_profesional FROM payroll_data_karyawan WHERE nomor_id='$nomor_id'";
$result17= mysql_query($sql17);
$rows17=mysql_fetch_array($result17);
$jenis_potongan2="jumlah_jam_potongan_".$jenis_potongan;
$sql18="SELECT $jenis_potongan2 FROM payroll_jamkerjaitems WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian'";
$result18= mysql_query($sql18);
$rows18=mysql_fetch_array($result18);
$sql5="SELECT $jenis_potongan FROM payroll_absensi WHERE nomor_id='$nomor_id' AND $jenis_potongan != '00:00:00' AND tanggal LIKE '%$pilihan_tahun-$pilihan_bulan%'";
$result5= mysql_query($sql5);
while ($rows5=mysql_fetch_array($result5)) {
if ($jenis_potongan=='terlambat'){$tambah=5;}else{$tambah='';}
$ambiljam = substr($rows5["$jenis_potongan"],0,2);
$ambilmenit = substr($rows5["$jenis_potongan"],3,2)-$tambah;
$ubah_jam_ke_menit=$ambiljam*60;
$total_menit=$ambilmenit+$ubah_jam_ke_menit;
if ($ambilmenit >= 1 AND $ambilmenit <= 30){$nilai=0.5;}elseif($ambilmenit >= 31) {$nilai=1;}
$ubah_jam_ke_desimal=$ubah_jam_ke_menit/60;
$satukan_desimal_nilai=$ubah_jam_ke_desimal+$nilai;
//echo "$satukan_desimal_nilai</br>";
$hasil=$rows16[gaji_pokok]+$rows17[uang_profesional];
$hasil1=$hasil/$rows16[jumlah_hari];
$hasil2=$hasil1/$rows18["$jenis_potongan2"]*$satukan_desimal_nilai;

$hasil3=$hasil2+$hasil3;
}
return floor($hasil3);
}

function terlambat_pulangcepat($nomor_id,$jenis_terlambat,$pilihan_bulan,$pilihan_tahun){
$sql5="SELECT $jenis_terlambat FROM payroll_absensi WHERE nomor_id='$nomor_id' AND $jenis_terlambat != '00:00:00' AND tanggal LIKE '%$pilihan_tahun-$pilihan_bulan%'";
$result5= mysql_query($sql5);
while ($rows5=mysql_fetch_array($result5)) {
$ambiljam = substr($rows5["$jenis_terlambat"],0,2);
$ambilmenit = substr($rows5["$jenis_terlambat"],3,2);
$jumlah_jam = $ambiljam+$jumlah_jam;
$jumlah_menit = $ambilmenit+$jumlah_menit;
$dibagi60detik = $jumlah_menit/60;
$ambil_jam_dari_hasil = Floor($dibagi60detik);
$perkalian = $ambil_jam_dari_hasil*60;
$jam_sebenarnya = $jumlah_jam+$ambil_jam_dari_hasil;
$menit_sebenarnya = $jumlah_menit-$perkalian;
//return "$jam_sebenarnya:$menit_sebenarnya";
$total_menit_sepenuhnya1=$jumlah_jam*60+$jumlah_menit;}
if ($total_menit_sepenuhnya1==''){$total_menit_sepenuhnya=$total_menit_sepenuhnya=0;}else{$total_menit_sepenuhnya=$total_menit_sepenuhnya1;}
return $total_menit_sepenuhnya;}


function lembur($nomor_id,$jenis_lembur,$pilihan_bulan,$pilihan_tahun){
$sql6="SELECT SUM($jenis_lembur) FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '%$pilihan_tahun-$pilihan_bulan%'";
$result6= mysql_query($sql6);
while ($rows6=mysql_fetch_array($result6)){
  $total_lembur=$rows6["SUM($jenis_lembur)"];
  return $total_lembur;}}

function uanglembur($uang_lembur_ot,$pilihan_bulan,$pilihan_tahun){
$sql15="SELECT gaji_pokok FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result15= mysql_query($sql15);
$rows15=mysql_fetch_array($result15);
$nilai_satuan=floor($rows15['gaji_pokok']/173);
$total_uang_lembur=$nilai_satuan*$uang_lembur_ot;
return $total_uang_lembur;}

function potonganabsent($nomor_id,$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb){
$sql16="SELECT gaji_pokok,jumlah_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result16= mysql_query($sql16);
$rows16=mysql_fetch_array($result16);
$sql17="SELECT uang_profesional FROM payroll_data_karyawan WHERE nomor_id='$nomor_id'";
$result17= mysql_query($sql17);
$rows17=mysql_fetch_array($result17);
$total_pemasukan=$rows16['gaji_pokok']+$rows17['uang_profesional'];
$total_pemasukan1=$total_pemasukan/$rows16['jumlah_hari'];
$total_ijin=floor($total_pemasukan1)*$ijin;
$total_mangkir=floor($total_pemasukan1)*$mangkir;
$total_tidak_bekerja=floor($total_pemasukan1)*$tidak_bekerja_pb;
$ditambah=$total_ijin+$total_mangkir+$total_tidak_bekerja;
return $ditambah;}

function potonganbpjs($nomor_id,$jenis_potongan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja){
$sql16="SELECT gaji_pokok FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result16= mysql_query($sql16);
$rows16=mysql_fetch_array($result16);
$sql17="SELECT uang_profesional FROM payroll_data_karyawan WHERE nomor_id='$nomor_id'";
$result17= mysql_query($sql17);
$rows17=mysql_fetch_array($result17);
$total_potongan_bpjs1=$rows16['gaji_pokok']+$rows17['uang_profesional'];
$total_potongan_bpjs2=$total_potongan_bpjs1*$jenis_potongan/100;
$total_potongan_bpjs=round($total_potongan_bpjs2);
if ($pegawai_baru==ya OR $hari_kerja==0){$nilai=0;}else{$nilai=$total_potongan_bpjs;}
return $nilai;}

function home(){extract($GLOBALS);
include 'style.css';

//Pilihan Banyak Bagian
	echo "<head>
	 <title>Maribelajarcoding.com</title>
	 <script
	 src='https://code.jquery.com/jquery-3.4.1.min.js'
	 integrity='sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo='
	 crossorigin='anonymous'></script>
	  <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css' rel='stylesheet' />
	 <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js'></script>
	 <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/id.js' type='text/javascript'></script>
	 <script type='text/javascript'>
	  $(document).ready(function() {
	      $('#bagian').select2({
	       placeholder: 'Pilih bagian',
	    allowClear: true,
	    language: 'id'
	      });
	  });
	 </script>
	</head>";
	 $ambil_bagian=$_POST['pilihan_bagian'];
	 $semua=json_encode($_POST['semua']);
	 //$pilihan_bagian1="'".implode("','",$ambil_bagian)."'";
	 $pilihan_bagian=json_encode($ambil_bagian);
	 if ($pilihan_bagian=='"Array"'){}else{
		if ($pilihan_bagian=='["Semua"]') {
			$insert_bagian="UPDATE master_user SET banyak_bagian_payroll='$semua' WHERE email='$_SESSION[username]'";
			mysql_query($insert_bagian);
		}else{
			$insert_bagian="UPDATE master_user SET banyak_bagian_payroll='$pilihan_bagian' WHERE email='$_SESSION[username]'";
			mysql_query($insert_bagian);
		}}
		$sql23="SELECT banyak_bagian_payroll FROM master_user WHERE email='$_SESSION[username]'";
 		$result23=mysql_query($sql23);
 		$rows23=mysql_fetch_array($result23);
 		$teksperbaikan1 = str_replace("[", "(", $rows23['banyak_bagian_payroll']);
 		$teksperbaikan2 = str_replace("]", ")", $teksperbaikan1);
 		$teksperbaikan = str_replace('"', "'", $teksperbaikan2);
	 //Pilihan Banyak Bagian END


//Menyala Ketika Kursor ditempat
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
$tampil_akses_cepat=$_POST['tampil_akses_cepat'];
//AMBIL POST UTAMA END
//AMBIL POST KEDUA START
$pilihan_bulan=$_POST['pilihan_bulan'];
$pilihan_tahun=$_POST['pilihan_tahun'];
//AMBIL POST KEDUA END


//Pilihan Departement & Bagian START
//JUDUL BAGIAN
$judul_bagian1 = str_replace("[", "", $rows23['banyak_bagian_payroll']);
$judul_bagian2 = str_replace("]", "", $judul_bagian1);
$judul_bagian3 = str_replace('"', "", $judul_bagian2);
if ($judul_bagian3=='null'){$judul_bagian='';}else{$judul_bagian=$judul_bagian3;}
echo "<h2><center>Perhitungan Gaji $judul_bagian</center></h2>";
echo "
<table>
<form method ='post' action='?menu=home&mod=payroll/Perhitungan'>
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

	echo "<form method='POST' action='?menu=home&mod=payroll/Perhitungan'>
	   <tr>
	    <td width='60px' valign='top'>bagian</td>
			<td>:</td>
	    <td valign='top'>
	     <select id='bagian' name='pilihan_bagian[]' multiple='multiple' style='width:300px'>";
			 $sql1="SELECT bagian FROM payroll_jamkerja WHERE departement='$pilihan_departement' ORDER by urut";
			 $result1=mysql_query($sql1);
				 echo "<option value='Semua'>Semua</option>";
			 while ($rows1=mysql_fetch_array($result1)) {
			 	 echo "<option value='$rows1[bagian]'>".$rows1[bagian]."</option>";}
		echo "
	  </select>
	    </td>
	   </tr>";}

//UNTUK PILIHAN BANYAK BAGIAN
$sql19="SELECT bagian FROM payroll_jamkerja WHERE departement='$pilihan_departement'";
$result19=mysql_query($sql19);
while ($rows19=mysql_fetch_array($result19)) {
	echo "<input type='hidden' name='semua[]' value='$rows19[bagian]'/>";
}//end

	 echo "
	 <tr>
	 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'/>
	 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'/>
	  <td><input type='submit' value='Tampil'></td>
	 </tr>
	 </form>
	 </table>";
		 echo "
	 </form>";

//echo "
//<tr>
//<td>Bagian</td>
//<td>:</td>
//<td><select name='pilihan_bagian'>
//	 <option value='$pilihan_bagian'>".$pilihan_bagian."</option>";
//$sql1="SELECT bagian FROM payroll_jamkerja WHERE departement='$pilihan_departement'";
//$result1=mysql_query($sql1);
//while ($rows1=mysql_fetch_array($result1)) {
//	 echo "<option value='$rows1[bagian]'>".$rows1[bagian]."</option>";}
//echo "
//</td>
//</tr>
//<tr>";}
//echo "
// <td><input type='submit' value='Tampil'></td>
//</tr>
//</form>
//</table>
//</br>";
//Pilihan Departement & Bagian END


//Tabel Perhitungan START
if ($pilihan_bagian) {
//Pilihan TANGGAL & TAHUN START
echo "<table>
<form method ='post' action='?menu=home&mod=payroll/Perhitungan'>
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
 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>";


 echo "
 <td><input type='submit' value='Tampil'></td>
</tr>
</form>
</table>
</br>";
//Pilihan TANGGAL & TAHUN END


if ($pilihan_bulan) {
//Keterangan Warna START
echo "<table>
<tr><td style=background-color:; align=left>Keterangan Warna :</td></tr>
<tr><td style=background-color:#7CFC00; align=center>Scan Masuk dan Pulang Lengkap</td></tr>
<tr><td style=background-color:#F08080; align=center>Scan Masuk/Pulang tidak lengkap</td></tr>
<tr><td style=background-color:; align=center>No Data</td></tr>
<tr><td style=background-color:yellow; align=center>Cuti/Ijin/Mangkir/Dokter/Dispensasi</td></tr>
</table>";
//Keterangan Warna END

//Tampilan Akses Cepat
if ($tampil_akses_cepat) {
  echo "<table><tr>
  <form method ='post' action='?menu=home&mod=payroll/Perhitungan'>
  <td><input type='submit' name='submit' value='Kembali'></td>
  <input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
  <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
  <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'/>
  <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'/>
  <input type='hidden' name='tampil_akses_cepat' value=''/>
  </form>
  </tr></table>";
}else{
  echo "<table><tr>
  <form method ='post' action='?menu=home&mod=payroll/Perhitungan'>
  <td><input type='submit' name='submit' value='Update Data'></td>
      <input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
      <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
      <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'/>
      <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'/>
      <input type='hidden' name='tampil_akses_cepat' value='tampil_akses_cepat'/>
  </form>";

	echo "
	<td><a href='modules/payroll/print_gaji.php?pilihan_departement=$pilihan_departement&pilihan_bagian=$pilihan_bagian&pilihan_bulan=$pilihan_bulan&pilihan_tahun=$pilihan_tahun&username=$_SESSION[username]' target='_blank'>Ekspor ke Excel</a></td>";

	echo "
	<form method ='post' action='?menu=home&mod=payroll/Perhitungan'>
	<td><input type='submit' name='submit' value='Cetak Slip Gaji'></td>
	<input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
	<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
	<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'/>
	<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'/>
	<input type='hidden' name='ekspor' value='Ekspor'/>
	</form>
	</tr></table>";
}//Tampilan Akses Cepat END

echo "
<table style='background-color:white;' class='tabel_utama' width=auto align=left>
<thead style='background-color:#C0C0C0;'>";

if ($tampil_akses_cepat) {
echo "<th align=center width=auto></th>";
}

echo "
<th align=center width=auto>No</th>
<th align=center width=auto>Nomor ID</th>
<th align=center width=auto>Nik</th>
<th align=center width=auto>Nama</th>
<th align=center width=auto>Bagian</th>";

//Urutan Tanggal START
$jumlah_hari_satu_bulan=jumlahhari($pilihan_bulan,$pilihan_tahun);
$tgl=1;
for($i=0; $i < $jumlah_hari_satu_bulan; ++$i){
echo "
<th align=center width=auto>$tgl</th>";
$tgl++;
}//Urutan Tanggal END
//CUTI	IZIN	MANGKIR	DOKTER	Dispensasi	TERLAMBAT

echo "
<th align=center width=auto>Cuti</th>
<th align=center width=auto>Ijin</th>
<th align=center width=auto>Mangkir</th>
<th align=center width=auto>Dokter</th>
<th align=center width=auto>Dispensasi</th>
<th align=center width=auto>Tidak Bekerja</th>
<th align=center width=auto>Terlambat</th>
<th align=center width=auto>Pulang Cepat</th>
<th align=center width=auto>OT 1.5</th>
<th align=center width=auto>OT 2</th>
<th align=center width=auto>OT 3</th>
<th align=center width=auto>OT 4</th>
<th align=center width=auto>Pemasukan ></th>
<th align=center width=auto>Gaji Pokok</th>
<th align=center width=auto>Uang Profesional</th>
<th align=center width=auto>Bonus Kehadiran</th>
<th align=center width=auto>Uang Makan</th>
<th align=center width=auto>Transport</th>
<th align=center width=auto>Uang Shift</th>
<th align=center width=auto>Lembur 1</th>
<th align=center width=auto>Lembur 2</th>
<th align=center width=auto>Lembur 3</th>
<th align=center width=auto>Lembur 4</th>
<th align=center width=auto>THR</th>
<th align=center width=auto>Jumlah Pemasukan</th>
<th align=center width=auto>Potongan ></th>
<th align=center width=auto>BPJS</th>
<th align=center width=auto>JAMSOSTEK</th>
<th align=center width=auto>DANA PENSIUN</th>
<th align=center width=auto>POT ABSENT</th>
<th align=center width=auto>POT TELAT</th>
<th align=center width=auto>POT PULANG CPT</th>
<th align=center width=auto>Pph 21</th>
<th align=center width=auto>TOTAL POTONGAN</th>
<th align=center width=auto>TOTAL GAJI</th>
</thead>";

//Proses UPDATE untuk Akses CEPAT Start
if ($tampil_akses_cepat=='update_data') {
//AMBIL POST AKSES CEPAT
$departement_akses=$_POST['departement_akses'];
$bagian_akses=$_POST['bagian_akses'];
$tanggal_akses=$_POST['tanggal_akses'];
$kode_halangan=$_POST['kode_halangan'];
$nomor_id_akses=$_POST['nomor_id_akses'];
$nik_akses=$_POST['nik_akses'];
$nama_akses=$_POST['nama_akses'];
$no=0;
$count=count($_POST['nomor_id_akses']);
for($i=0; $i < $count; ++$i){
$hari_akses=ambilhari($tanggal_akses[$no]);
if ($kode_halangan[$no]=='CT'){$status_akses='CUTI';}
if ($kode_halangan[$no]=='I'){$status_akses='IJIN';}
if ($kode_halangan[$no]=='M'){$status_akses='MANGKIR';}
if ($kode_halangan[$no]=='D'){$status_akses='DOKTER';}
if ($kode_halangan[$no]=='DS'){$status_akses='DISPENSASI';}
if ($kode_halangan[$no] != '') {

$sql24="SELECT bagian,jam_kerja FROM payroll_data_karyawan WHERE nomor_id='$nomor_id_akses[$no]'";
$result24=mysql_query($sql24);
$rows24=mysql_fetch_array($result24);

$insert_halangan="INSERT INTO payroll_absensi SET nomor_id='$nomor_id_akses[$no]',nik='$nik_akses[$no]',nama='$nama_akses[$no]',tanggal='$tanggal_akses[$no]',jam_kerja='$rows24[jam_kerja]',hari='$hari_akses',departement='$departement_akses[$no]',bagian='$rows24[bagian]',status='$status_akses'";
$eksekusi_halangan=mysql_query($insert_halangan);}
$no++;}}
//Proses UPDATE untuk Akses CEPAT END

//Ambil Data Karyawan Start
$sql2="SELECT id,nomor_id,nik,nama,uang_profesional,departement,bagian,awal_masuk,mulai_kontrak,akhir_kontrak FROM payroll_data_karyawan WHERE departement='$pilihan_departement' AND bagian IN $teksperbaikan";
$result2=mysql_query($sql2);
$no=1;
while ($rows2=mysql_fetch_array($result2)) {
	//Bagian Nomor ID/NIK/NAMA START

	//JUMLAH HARI KERJA
  $sql201="SELECT tanggal,scan_masuk,scan_pulang,status FROM payroll_absensi WHERE nomor_id='$rows2[nomor_id]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('','SETENGAH HARI')";
  $result201=mysql_query($sql201);
  $rows201=mysql_fetch_array($result201);
  $hari_kerja=mysql_num_rows($result201);
  //JUMLAH HARI KERJA

  $warnaGenap="#FFFFF";
  $warnaGanjil="#CEF6F5";
  if ($no % 2 == 0){$color1 = $warnaGenap;}else{$color1 = $warnaGanjil;}

  //TAMPIL TOMBOL AKSES CEPAT
  echo "<tr>";
  if ($tampil_akses_cepat) {
  echo "<form method ='post' action='?menu=home&mod=payroll/Perhitungan'>
  <input type='hidden' name='tampil_akses_cepat' value='update_data'/>
  <input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
  <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
  <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'/>
  <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'/>
  <td><input type='submit' style='width:100%;' name='submit' value='Simpan'/></td>";
}//TAMPIL TOMBOL AKSES CEPAT END

  echo "
	<td class='sticky-col zero-col' style=background-color:$color1; align=center>$no</td>
	<td class='sticky-col first-col' style=background-color:$color1; align=center>$rows2[nomor_id]</td>
	<td class='sticky-col second-col' style=background-color:$color1; align=center>$rows2[nik]</td>
	<td class='sticky-col three-col' style=background-color:$color1; align=center>$rows2[nama]</td>
	<td class='sticky-col four-col' style=background-color:$color1; align=center>$rows2[bagian]</td>";
	//Bagian Nomor ID/NIK/NAMA END
	//Urutan Tanggal START
	$jumlah_hari_satu_bulan=jumlahhari($pilihan_bulan,$pilihan_tahun);
	$tgl=1;
	for($i=0; $i < $jumlah_hari_satu_bulan; ++$i){
		$sql3="SELECT tanggal,scan_masuk,scan_pulang,status FROM payroll_absensi WHERE nomor_id='$rows2[nomor_id]' AND tanggal='$pilihan_tahun-$pilihan_bulan-$tgl'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);

    //Cari Minggu
    $urutan_tanggal="$pilihan_tahun-$pilihan_bulan-$tgl";
    $namahari = date('l', strtotime($urutan_tanggal));
    if($namahari=='Sunday'){$ket_hari='Minggu';}else{$ket_hari='';}

    //Pembedaan Warna
		if($rows3['tanggal']==''){$color='';}
    elseif ($rows3['status'] != ''){$color='yellow';}
    elseif ($rows3['scan_masuk'] == '00:00:00' OR $rows3['scan_pulang'] == '00:00:00'){$color='#F08080';}
    else{$color='#7CFC00';}

    //FORMAT TGL
    if ($tgl <= 9){$tgl1="0$tgl";}else{$tgl1=$tgl;}
    $seluruh_tanggal="$pilihan_tahun-$pilihan_bulan-$tgl1";//SELURUH TANGGAL
    if ($namahari=='Sunday'){$tanggal_minggu=$seluruh_tanggal;}else{$tanggal_minggu='';}//AMBIL TGL MINGGU
    if ($rows3[tanggal] == $tanggal_minggu){$tanpa_minggu=$seluruh_tanggal;}else{$tanpa_minggu='';}//AMBIL TIDAK HADIR
    if ($seluruh_tanggal == $tanpa_minggu AND $tampil_akses_cepat != ''){
      echo "
        <td style=background-color:; align=center><select name='kode_halangan[]'>
          <option value=''>-</option>
          <option value='CT'>CT</option>
          <option value='I'>I</option>
          <option value='M'>M</option>
          <option value='D'>D</option>
          <option value='DS'>DS</option></select>
        </td>";
       echo
        "<input type='hidden' name='departement_akses[]' value='$pilihan_departement'/>
        <input type='hidden' name='bagian_akses[]' value='$pilihan_bagian'/>
        <input type='hidden' name='tanggal_akses[]' value='$tanpa_minggu'/>
        <input type='hidden' name='nomor_id_akses[]' value='$rows2[nomor_id]'/>
        <input type='hidden' name='nik_akses[]' value='$rows2[nik]'/>
        <input type='hidden' name='nama_akses[]' value='$rows2[nama]'/>";
      echo
       "<input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
        <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
        <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'/>
        <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'/>";
    }else{
    echo "
    <td style=background-color:$color; align=center>$ket_hari</td>";
    }

	$tgl++;
	}//Urutan Tanggal END
  echo "</form>";

  //Tidak Hadir Start
	$cuti=halangan($rows2[nomor_id],CUTI,$pilihan_bulan,$pilihan_tahun);
	$ijin=halangan($rows2[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
	$mangkir=halangan($rows2[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
	$dokter=halangan($rows2[nomor_id],DOKTER,$pilihan_bulan,$pilihan_tahun);
	$dispensasi=halangan($rows2[nomor_id],DISPENSASI,$pilihan_bulan,$pilihan_tahun);
  echo "<td style=background-color:$color1; align=center>".halangan($rows2[nomor_id],CUTI,$pilihan_bulan,$pilihan_tahun)."</td>";
  echo "<td style=background-color:$color1; align=center>".halangan($rows2[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun)."</td>";
  echo "<td style=background-color:$color1; align=center>".halangan($rows2[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun)."</td>";
  echo "<td style=background-color:$color1; align=center>".halangan($rows2[nomor_id],DOKTER,$pilihan_bulan,$pilihan_tahun)."</td>";
  echo "<td style=background-color:$color1; align=center>".halangan($rows2[nomor_id],DISPENSASI,$pilihan_bulan,$pilihan_tahun)."</td>";
  //Tidak Hadir End

	//TIDAK BEKERJA KARYAWAN BARU
	$awal_masuk_pegawai=$rows2['awal_masuk'];//Pegawai Baru/Tidak
	$awal_masuk_penentu1=$rows2['awal_masuk'];
	$awal_masuk_penentu=substr($awal_masuk_penentu1,0,7);
	$tahun_bulan_pilihan="$pilihan_tahun-$pilihan_bulan";
	if ($awal_masuk_penentu==$tahun_bulan_pilihan){$pegawai_baru='ya';}else{$pegawai_baru='tidak';}
	$tidak_hadir_lainnya=$cuti+$ijin+$mangkir+$dokter+$dispensasi;
	$nilai_tidak_bekerja=tidak_bekerja_pegawai_baru($pegawai_baru,$rows2[nomor_id],$pilihan_tahun,$pilihan_bulan,$tidak_hadir_lainnya);
	echo "<td style=background-color:$color1; align=center>".tidak_bekerja_pegawai_baru($pegawai_baru,$rows2[nomor_id],$pilihan_tahun,$pilihan_bulan,$tidak_hadir_lainnya)."</td>";
	//TIDAK BEKERJA KARYAWAN BARU END

  //Terlambat Dan Pulang Cepat Start
  echo "<td style=background-color:$color1; align=center>".terlambat_pulangcepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun)." Menit</td>";
  echo "<td style=background-color:$color1; align=center>".terlambat_pulangcepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun)." Menit</td>";
  //Terlambat Dan Pulang Cepat End

  //Lemburan START
	echo "<td style=background-color:$color1; align=center>".lembur($rows2[nomor_id],ot1,$pilihan_bulan,$pilihan_tahun)."</td>";
  echo "<td style=background-color:$color1; align=center>".lembur($rows2[nomor_id],ot2,$pilihan_bulan,$pilihan_tahun)."</td>";
  echo "<td style=background-color:$color1; align=center>".lembur($rows2[nomor_id],ot3,$pilihan_bulan,$pilihan_tahun)."</td>";
  echo "<td style=background-color:$color1; align=center>".lembur($rows2[nomor_id],ot4,$pilihan_bulan,$pilihan_tahun)."</td>";
  //Lemburan END

  //START PEMASUKAN
  echo "<td style=background-color:white; align=center></td>";
  echo "<td style=background-color:$color1; align=center>".rupiah(gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja))."</td>";
	if ($pegawai_baru==ya OR $hari_kerja==0){$uang_profesional=0;}else{$uang_profesional=$rows2[uang_profesional];}
  echo "<td style=background-color:$color1; align=center>".rupiah($uang_profesional)."</td>";
  //END PEMASUKAN

  //START UANG PREMI
  $cuti=halangan($rows2[nomor_id],CUTI,$pilihan_bulan,$pilihan_tahun);
  $ijin=halangan($rows2[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
  $mangkir=halangan($rows2[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
  $dokter=halangan($rows2[nomor_id],DOKTER,$pilihan_bulan,$pilihan_tahun);
  $dispensasi=halangan($rows2[nomor_id],DISPENSASI,$pilihan_bulan,$pilihan_tahun);
  $terlambat=total_telat_diatas_35m($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun);
  $pulang_cepat=total_telat_diatas_35m($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun);
	$setengah_hari=setengah_hari($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun);
  echo "<td style=background-color:$color1; align=center>".rupiah(bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$nilai_tidak_bekerja,$setengah_hari))."123</td>";
  //END UANG PREMI

  //START UANG MAKAN
  echo "<td style=background-color:$color1; align=center>".rupiah(uangmakan($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun))."</td>";

  //START TRANSPORT
  echo "<td style=background-color:$color1; align=center>".rupiah(uangtransport($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun))."</td>";

  //UANG SHIFT
  echo "<td style=background-color:$color1; align=center>".rupiah(uangshift($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun))."</td>";

//UANG LEMBUR
$uang_lembur_ot1=lembur($rows2[nomor_id],ot1,$pilihan_bulan,$pilihan_tahun);
$uang_lembur_ot2=lembur($rows2[nomor_id],ot2,$pilihan_bulan,$pilihan_tahun);
$uang_lembur_ot3=lembur($rows2[nomor_id],ot3,$pilihan_bulan,$pilihan_tahun);
$uang_lembur_ot4=lembur($rows2[nomor_id],ot4,$pilihan_bulan,$pilihan_tahun);
echo "<td style=background-color:$color1; align=center>".rupiah(uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun))."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah(uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun))."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah(uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun))."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah(uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun))."</td>";
//UANG LEMBUR

//THR
echo "<td style=background-color:$color1; align=center>".rupiah(thr($rows2[id],$pilihan_tahun,$pilihan_bulan))."</td>";

//TOTAL PEMASUKAN
$total_pemasukan=gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
$uang_profesional+
bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$nilai_tidak_bekerja,$setengah_hari)+
uangmakan($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
uangtransport($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
uangshift($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun)+
uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun)+
uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun)+
thr($rows2[id],$pilihan_tahun,$pilihan_bulan)+
uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun);
echo "<td style=background-color:$color1; align=center>".rupiah($total_pemasukan)."</td>";
//TOTAL PEMASUKAN

//POTONGAN BPJS
$sql18="SELECT jumlah_tanggungan_bpjs FROM payroll_data_karyawan WHERE nomor_id='$rows2[nomor_id]'";
$result18= mysql_query($sql18);
$rows18=mysql_fetch_array($result18);
$jumlah_tanggungan=$rows18['jumlah_tanggungan_bpjs']+1;
echo "<td style=background-color:white; align=center></td>";
echo "<td style=background-color:$color1; align=center>".rupiah(potonganbpjs($rows2[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja))."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah(potonganbpjs($rows2[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja))."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah(potonganbpjs($rows2[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja))."</td>";
//POTONGAN BPJS

//POTONGAN ABSENT
$ijin=halangan($rows2[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
$mangkir=halangan($rows2[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
$tidak_bekerja_pb=tidak_bekerja_pegawai_baru($pegawai_baru,$rows2[nomor_id],$pilihan_tahun,$pilihan_bulan,$tidak_hadir_lainnya);
echo "<td style=background-color:$color1; align=center>".rupiah(potonganabsent($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb))."456</td>";
//POTONGAN ABSENT

//POTONGAN TERLAMBAT PULANG CEPAT
$ijin=halangan($rows2[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
$mangkir=halangan($rows2[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
echo "<td style=background-color:$color1; align=center>".rupiah(potongan_telat_pulang_cepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian]))."</td>";
echo "<td style=background-color:$color1; align=center>".rupiah(potongan_telat_pulang_cepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian]))."</td>";
//POTONGAN TERLAMBAT PULANG CEPAT

$sql22="SELECT pph_bulan FROM payroll_potongan_pph21 WHERE induk='$rows2[id]'";
$result22=mysql_query($sql22);
$rows22=mysql_fetch_array($result22);
echo "<td style=background-color:$color1; align=center>".rupiah($rows22[pph_bulan])."</td>";

$total_potongan=
$rows22[pph_bulan]+
potonganbpjs($rows2[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
potonganbpjs($rows2[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
potonganbpjs($rows2[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
potonganabsent($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb)+
potongan_telat_pulang_cepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian])+
potongan_telat_pulang_cepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian]);
echo "<td style=background-color:$color1; align=center>".rupiah($total_potongan)."</td>";


//PPH 21 Proses
//Update Data Ke Database PPH 21
$bpjs_pph21=potonganbpjs($rows2[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja);
$jamsostek_pph21=potonganbpjs($rows2[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja);
$dana_pensiun_pph21=potonganbpjs($rows2[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja);
$total_pemasukan_pph21=gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
    $uang_profesional+
    bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$nilai_tidak_bekerja,$setengah_hari)+
    uangmakan($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
    uangtransport($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
    uangshift($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
    uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun)+
    uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun)+
    uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun)+
    uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun);
$thr_pph21=thr($rows2[id],$pilihan_tahun,$pilihan_bulan);
$gaji_uang_profesional=gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$uang_profesional;
$total_potongan_pph21=potonganabsent($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb)+
  potongan_telat_pulang_cepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian])+
  potongan_telat_pulang_cepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian]);
$update_pemasukan_pph21="UPDATE payroll_potongan_pph21 SET dana_pensiun='$dana_pensiun_pph21',jamsostek='$jamsostek_pph21',bpjs='$bpjs_pph21',bonus_atau_thr='$thr_pph21',gaji_perbulan='$total_pemasukan_pph21',jkk_dan_jkm='$gaji_uang_profesional',potongan='$total_potongan_pph21' WHERE induk='$rows2[id]'";
$eksekusi_update_pemasukan_pph21=mysql_query($update_pemasukan_pph21);
//PPH 21 Proses END

//TOTAL Gaji
$total_gaji=$total_pemasukan-$total_potongan;
echo "<td style=background-color:$color1; align=center>".rupiah($total_gaji)."</td>";

//SLIP GAJI START
$ekspor = $_POST['ekspor'];
if ($ekspor){
	$document = file_get_contents("modules/payroll/file/slipgaji.rtf");

	$document = str_replace("[nik]", $rows2[nik], $document);
	$document = str_replace("[nama]", $rows2[nama], $document);
	$document = str_replace("[departement]", $rows2[bagian], $document);
	$document = str_replace("[periode]", "$pilihan_bulan-$pilihan_tahun", $document);
	$document = str_replace("[tgl_cetak]", date('Y-m-d'), $document);

	//HARI KERJA
	$sql19="SELECT tanggal,scan_masuk,scan_pulang,status FROM payroll_absensi WHERE nomor_id='$rows2[nomor_id]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('','SETENGAH HARI')";
	$result19=mysql_query($sql19);
	$jumlah_hari_kerja=mysql_num_rows($result19);
	$document = str_replace("[hari_kerja]", $jumlah_hari_kerja, $document);

	$document = str_replace("[ijin]", $ijin, $document);
	$document = str_replace("[sakit_skd]", $dokter, $document);
	$document = str_replace("[cuti]", $cuti, $document);
	$document = str_replace("[dispensasi]", $dispensasi, $document);
	$document = str_replace("[mangkir]", $mangkir, $document);

	//TERLAMBAT & PULPET
//	$slip_terlambat=terlambat_pulangcepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun);
//	$slip_pulang_cepat=terlambat_pulangcepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun);
	if ($terlambat==''){$terlambat1=0;}else{$terlambat1=$terlambat;}
	if ($pulang_cepat==''){$pulang_cepat1=0;}else{$pulang_cepat1=$pulang_cepat;}
	$document = str_replace("[terlambat]", $terlambat1, $document);
	$document = str_replace("[pulang_cepat]", $pulang_cepat1, $document);

	//TOTAL LEMBUR
	$total_lembur_slip_gaji=
	lembur($rows2[nomor_id],ot1,$pilihan_bulan,$pilihan_tahun)+
	lembur($rows2[nomor_id],ot2,$pilihan_bulan,$pilihan_tahun)+
	lembur($rows2[nomor_id],ot3,$pilihan_bulan,$pilihan_tahun)+
	lembur($rows2[nomor_id],ot4,$pilihan_bulan,$pilihan_tahun);
	$document = str_replace("[total_lembur]", $total_lembur_slip_gaji, $document);

	//HARI KERJA
	$sisa_cuti=cutiterpakai($rows2[nomor_id],$rows2[awal_masuk],$rows2[mulai_kontrak],$rows2[akhir_kontrak],$rows2[id],cutitersisa);
	$document = str_replace("[sisa_cuti]", $sisa_cuti, $document);

	$document = str_replace("[gaji_pokok]", rupiah(gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)), $document);
	$document = str_replace("[u_profesional]", rupiah($uang_profesional), $document);
	$document = str_replace("[p_kehadiran]", rupiah(bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$nilai_tidak_bekerja,$setengah_hari)), $document);
	$document = str_replace("[u_makan]", rupiah(uangmakan($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)), $document);
	$document = str_replace("[u_transport]", rupiah(uangtransport($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)), $document);

	$total_uang_lembur_slip_gaji=
	uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun)+
	uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun)+
	uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun)+
	uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun);
	$document = str_replace("[lembur]", rupiah($total_uang_lembur_slip_gaji), $document);

	$document = str_replace("[u_shift]", rupiah(uangshift($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)), $document);

	//TOTAL MASUK
	$total_pemasukan_slip_gaji=gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
	$uang_profesional+
	bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$nilai_tidak_bekerja,$setengah_hari)+
	uangmakan($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
	uangtransport($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
	uangshift($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+
	uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun)+
	uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun)+
	uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun)+
	//thr($rows2[id],$pilihan_tahun,$pilihan_bulan)+
	uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun);
	$document = str_replace("[total_masuk]", rupiah($total_pemasukan_slip_gaji), $document);

	$document = str_replace("[pot_bpjs]", rupiah(potonganbpjs($rows2[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)), $document);
	$document = str_replace("[pot_jamsostek]", rupiah(potonganbpjs($rows2[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)), $document);
	$document = str_replace("[pot_dana_pen]", rupiah(potonganbpjs($rows2[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)), $document);
	$document = str_replace("[pot_absen]", rupiah(potonganabsent($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb)), $document);
	$document = str_replace("[pot_terlambat]", rupiah(potongan_telat_pulang_cepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian])), $document);
	$document = str_replace("[pot_pul_cepat]", rupiah(potongan_telat_pulang_cepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian])), $document);
	$document = str_replace("[pot_pph21]", rupiah($rows22[pph_bulan]), $document);
	$document = str_replace("[total_keluar]", rupiah($total_potongan), $document);

	$total_gaji_slip_gaji=$total_pemasukan_slip_gaji-$total_potongan;
	$document = str_replace("[gaji_bersih]", rupiah($total_gaji_slip_gaji), $document);

	$document = str_replace("[thr]", rupiah(thr($rows2[id],$pilihan_tahun,$pilihan_bulan)), $document);


	$fr = fopen("modules/payroll/file/slip_gaji_$rows2[nama].rtf", "w") ;
	fwrite($fr, $document);
	fclose($fr);
	echo "<script type='text/javascript'>window.open('modules/payroll/file/slip_gaji_$rows2[nama].rtf')</script>";}
//SLIP GAJI END

//NILAI TOTAL SEMUA KARYAWAN
$total_seluruh_cuti=$cuti+$total_seluruh_cuti;//TOTAL CUTI
$total_seluruh_ijin=$ijin+$total_seluruh_ijin;//TOTAL IJIN
$total_seluruh_mangkir=$mangkir+$total_seluruh_mangkir;//TOTAL MANGKIR
$total_seluruh_dokter=$dokter+$total_seluruh_dokter;//TOTAL DOKTER
$total_seluruh_dispensasi=$dispensasi+$total_seluruh_dispensasi;//TOTAL DISPENSASI
$total_seluruh_tidak_bekerja=$nilai_tidak_bekerja+$total_seluruh_tidak_bekerja;//TOTAL IJIN
$total_seluruh_terlambat=terlambat_pulangcepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_terlambat;// TOTAL TERLAMBAT
$total_seluruh_pulang_cepat=terlambat_pulangcepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_pulang_cepat;// TOTAL PULANG CEPAT
$total_seluruh_ot1=$uang_lembur_ot1+$total_seluruh_ot1;//LEMBUR 1
$total_seluruh_ot2=$uang_lembur_ot2+$total_seluruh_ot2;//LEMBUR 2
$total_seluruh_ot3=$uang_lembur_ot3+$total_seluruh_ot3;//LEMBUR 3
$total_seluruh_ot4=$uang_lembur_ot4+$total_seluruh_ot4;//LEMBUR 4

//PENGELUARAN
$total_seluruh_gaji_pokok=gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_gaji_pokok;//GAJI POKOK
$total_seluruh_uang_profesional=$uang_profesional+$total_seluruh_uang_profesional;//UANG PROFESIONAL
$total_seluruh_bonus_kehadiran=bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$nilai_tidak_bekerja,$setengah_hari)+$total_seluruh_bonus_kehadiran;//BONUS KEHADIRAN
$total_seluruh_uang_makan=uangmakan($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+$total_seluruh_uang_makan;//UANG MAKAN
$total_seluruh_uang_transport=uangtransport($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+$total_seluruh_uang_transport;//UANG TRANSPORT
$total_seluruh_uang_shift=uangshift($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun)+$total_seluruh_uang_shift;//UANG SHIFT
$total_seluruh_lembur_ot1=uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot1;//OT 1
$total_seluruh_lembur_ot2=uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot2;//OT 2
$total_seluruh_lembur_ot3=uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot3;//OT 3
$total_seluruh_lembur_ot4=uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot4;//OT 4
$total_seluruh_thr=thr($rows2[id],$pilihan_tahun,$pilihan_bulan)+$total_seluruh_thr;//THR
$total_seluruh_pemasukan=$total_pemasukan+$total_seluruh_pemasukan; $total_seluruh_pemasukan1=rupiah($total_seluruh_pemasukan);//SELURUH PEMASUKAN

//PEMASUKAN
$total_seluruh_potongan_bpjs=potonganbpjs($rows2[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_potongan_bpjs;//POTONGAN BPJS
$total_seluruh_potongan_jamsostek=potonganbpjs($rows2[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_potongan_jamsostek;//POTONGAN JAMSOSTEK
$total_seluruh_potongan_dana_pensiun=potonganbpjs($rows2[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_potongan_dana_pensiun;//TOTAL DANA PENSIUN
$total_seluruh_potongan_absent=potonganabsent($rows2[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb)+$total_seluruh_potongan_absent;//TOTAL SELURUH POTONGAN ABSENT
$total_seluruh_potongan_terlambat=potongan_telat_pulang_cepat($rows2[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian])+$total_seluruh_potongan_terlambat;//TOTAL TERLAMBAT
$total_seluruh_potongan_pulang_cepat=potongan_telat_pulang_cepat($rows2[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows2[departement],$rows2[bagian])+$total_seluruh_potongan_pulang_cepat;//TOTAL PULANG CEPAT
$total_seluruh_potongan_pph21=$rows22[pph_bulan]+$total_seluruh_potongan_pph21;// PPH 21
$total_seluruh_pengeluaran=$total_potongan+$total_seluruh_pengeluaran; $total_seluruh_pengeluaran1=rupiah($total_seluruh_pengeluaran);//SELURUH PENGELUARAN

$nilai_setelah_dikurang=$total_seluruh_pemasukan-$total_seluruh_pengeluaran; $nilai_setelah_dikurang1=rupiah($nilai_setelah_dikurang);//PEMASUKAN - PENGELUARAN
echo "</tr>";
$no++;}//Ambil Data Karyawan End

//BARIS TERAKHIR UNTUK TOTAL KESELURUHAN
$kolom_digabung=$jumlah_hari_satu_bulan+5;
echo "<tr style='background-color:#98FB98;'>";
echo "<td colspan='$kolom_digabung'><center><strong>TOTAL</strong></center></td>";//Judul

echo "<td><center><strong>$total_seluruh_cuti</strong></center></td>";//CUTI
echo "<td><center><strong>$total_seluruh_ijin</strong></center></td>";//IJIN
echo "<td><center><strong>$total_seluruh_mangkir</strong></center></td>";//MANGKIR
echo "<td><center><strong>$total_seluruh_dokter</strong></center></td>";//DOKTER
echo "<td><center><strong>$total_seluruh_dispensasi</strong></center></td>";//DISPENSASI
echo "<td><center><strong>$total_seluruh_tidak_bekerja</strong></center></td>";//TIDAK BEKERJA
echo "<td><center><strong>$total_seluruh_terlambat Menit</strong></center></td>";//TERLAMBAT
echo "<td><center><strong>$total_seluruh_pulang_cepat Menit</strong></center></td>";//PULANG CEPAT

echo "<td><center><strong>$total_seluruh_ot1</strong></center></td>";//OT 1
echo "<td><center><strong>$total_seluruh_ot2</strong></center></td>";//OT 2
echo "<td><center><strong>$total_seluruh_ot3</strong></center></td>";//OT 3
echo "<td><center><strong>$total_seluruh_ot4</strong></center></td>";//OT 4

echo "<td></td>";

echo "<td><center><strong>".rupiah($total_seluruh_gaji_pokok)."</strong></center></td>";//GAJI POKOK
echo "<td><center><strong>".rupiah($total_seluruh_uang_profesional)."</strong></center></td>";//UANG PROFESIONAL
echo "<td><center><strong>".rupiah($total_seluruh_bonus_kehadiran)."</strong></center></td>";//BONUS KEHADIRAN
echo "<td><center><strong>".rupiah($total_seluruh_uang_makan)."</strong></center></td>";//UANG MAKAN
echo "<td><center><strong>".rupiah($total_seluruh_uang_transport)."</strong></center></td>";//UANG TRANSPORT
echo "<td><center><strong>".rupiah($total_seluruh_uang_shift)."</strong></center></td>";//UANG SHIFT
echo "<td><center><strong>".rupiah($total_seluruh_lembur_ot1)."</strong></center></td>";//OT 1
echo "<td><center><strong>".rupiah($total_seluruh_lembur_ot2)."</strong></center></td>";//OT 2
echo "<td><center><strong>".rupiah($total_seluruh_lembur_ot3)."</strong></center></td>";//OT 3
echo "<td><center><strong>".rupiah($total_seluruh_lembur_ot4)."</strong></center></td>";//OT 4
echo "<td><center><strong>".rupiah($total_seluruh_thr)."</strong></center></td>";//THR
echo "<td><center><strong>$total_seluruh_pemasukan1</strong></center></td>";// TOTAL PEMASUKAN

echo "<td></td>";

echo "<td><center><strong>".rupiah($total_seluruh_potongan_bpjs)."</strong></center></td>";//
echo "<td><center><strong>".rupiah($total_seluruh_potongan_jamsostek)."</strong></center></td>";//
echo "<td><center><strong>".rupiah($total_seluruh_potongan_dana_pensiun)."</strong></center></td>";//
echo "<td><center><strong>".rupiah($total_seluruh_potongan_absent)."</strong></center></td>";//
echo "<td><center><strong>".rupiah($total_seluruh_potongan_terlambat)."</strong></center></td>";//
echo "<td><center><strong>".rupiah($total_seluruh_potongan_pulang_cepat)."</strong></center></td>";//
echo "<td><center><strong>".rupiah($total_seluruh_potongan_pph21)."</strong></center></td>";//

echo "<td><center><strong>$total_seluruh_pengeluaran1</strong></center></td>";
echo "<td><center><strong>$nilai_setelah_dikurang1</strong></center></td>";

}}//Tabel Perhitungan END
echo "</tr></table>";
}//END HOME
//END PHP?>
