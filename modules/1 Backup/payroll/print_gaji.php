<?php
include('../../koneksi.php');
$conn=mysql_connect(s('db_server'), s('db_user'), s('db_password')) or die(mysql_error()) ;
mysql_select_db(s('db_name'));

include('../../addon/xml/ExcelWriterXML.php');

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

function rupiah($angka){
$hasil_rupiah = "" . number_format($angka,0,'','');
return $hasil_rupiah;}

function datediff($tgl1, $tgl2){
$tgl1 = strtotime($tgl1);
$tgl2 = strtotime($tgl2);
$diff_secs = abs($tgl1 - $tgl2);
$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );}

function halangan($nomor_id,$jenis_halangan,$pilihan_bulan,$pilihan_tahun){
$sql4="SELECT status FROM payroll_absensi WHERE nomor_id='$nomor_id' AND status='$jenis_halangan' AND tanggal LIKE '%$pilihan_tahun-$pilihan_bulan%'";
$result4= mysql_query($sql4);
$count_header=mysql_num_rows($result4);
$rows4=mysql_fetch_array($result4);
return $count_header;}

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

function gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja){
$sql7="SELECT gaji_pokok,jumlah_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result7= mysql_query($sql7);
$rows7=mysql_fetch_array($result7);
if ($hari_kerja==0){//$pegawai_baru==ya OR
$gaji_pokok=$rows7[gaji_pokok]/$rows7[jumlah_hari]*$hari_kerja;}else {$gaji_pokok=$rows7[gaji_pokok];}
return floor($gaji_pokok);}

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
$total_telat=$nilai+$total_telat;}
return $total_telat;}

function bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$setengah_hari){
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
if ($pegawai_baru==ya OR $hari_kerja==0){$nilai=0;}else {$nilai=$hasil_sebenarnya;}
return $nilai;}

function uangshift($nomor_id,$pilihan_bulan,$pilihan_tahun){
$sql13="SELECT 	uang_shift_satu_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result13= mysql_query($sql13);
$rows13=mysql_fetch_array($result13);
$sql14="SELECT * FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('','PULANG CEPAT')";
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
$sql12="SELECT * FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('','PULANG CEPAT')";
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

function uanglembur($uang_lembur_ot,$pilihan_bulan,$pilihan_tahun){
$sql15="SELECT gaji_pokok FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result15= mysql_query($sql15);
$rows15=mysql_fetch_array($result15);
$nilai_satuan=floor($rows15['gaji_pokok']/173);
$total_uang_lembur=$nilai_satuan*$uang_lembur_ot;
return $total_uang_lembur;}

function thr($nilai,$tahun,$bulan){
$sql20="SELECT thr FROM payroll_gaji_potongan WHERE id='$bulan'";
$result20=mysql_query($sql20);
$rows20=mysql_fetch_array($result20);
$sql21="SELECT awal_masuk FROM payroll_data_karyawan WHERE id='$nilai'";
$result21=mysql_query($sql21);
$rows21=mysql_fetch_array($result21);
$tgl1=$rows21[awal_masuk];
$tgl2=date("Y-m-d");
$a = datediff($tgl1, $tgl2);
if ($rows20[thr]=='') {
  $hasil_sebenarnya='0';
}else {
if ($a[years] == 0) {$hasil=$rows20[thr]/$a[months];}
if ($a[years] >= 1) {$hasil=$rows20[thr]*1;}
if ($tgl1 == '') {$hasil_sebenarnya='';} else {$hasil_sebenarnya=$hasil;}}
return floor($hasil_sebenarnya);}

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
$hasil3=$hasil2+$hasil3;}
return floor($hasil3);}

function dapatcuti($nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak){
$tgl1=$awal_masuk;
$tgl2=date("Y-m-d");
$a = datediff($tgl1, $tgl2);
$sql4="SELECT total_cuti,awal_masuk FROM payroll_cuti_tahunan WHERE induk='$nomor_id'";
$result4= mysql_query($sql4);
$rows4=mysql_fetch_array($result4);
if ($a[years] > $rows4[tahun_ke]){
$dapat_cuti='12';}else{$dapat_cuti='0';}
//echo 'tanggal 1 = '.$tgl1; echo '<br>';
//echo 'tanggal 2 = '.$tgl2; echo '<br>';
$Selisih=$a[years].' tahun '.$a[months].' bulan '.$a[days].' hari';//.$a[hours].' jam '.$a[minutes].' menit '.$a[seconds].' detik';
//return "$nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$jenis";
return $dapat_cuti;}

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
$total_cuti1="$count_header";}//Periode $tahun_pertama s/d $tahun_kedua adalah
if ($jenis=='cutitersisa'){
$total_cuti1=$rows5['total_cuti']-$count_header;}
return $total_cuti1;}

$pilihan_departement=$_GET['pilihan_departement'];
$pilihan_bagian=$_GET['pilihan_bagian'];
$pilihan_bulan=$_GET['pilihan_bulan'];
$pilihan_tahun=$_GET['pilihan_tahun'];
$username=$_GET['username'];
//Ambil Data Kiriman END

//Ambil Bulan START
if ($pilihan_bulan==01){$bulan="Januari $pilihan_tahun";}
if ($pilihan_bulan==02){$bulan="Februari $pilihan_tahun";}
if ($pilihan_bulan==03){$bulan="Maret $pilihan_tahun";}
if ($pilihan_bulan==04){$bulan="April $pilihan_tahun";}
if ($pilihan_bulan==05){$bulan="Mei $pilihan_tahun";}
if ($pilihan_bulan==06){$bulan="Juni $pilihan_tahun";}
if ($pilihan_bulan==07){$bulan="Juli $pilihan_tahun";}
if ($pilihan_bulan==08){$bulan="Agustus $pilihan_tahun";}
if ($pilihan_bulan==09){$bulan="September $pilihan_tahun";}
if ($pilihan_bulan==10){$bulan="Oktober $pilihan_tahun";}
if ($pilihan_bulan==11){$bulan="Nopember $pilihan_tahun";}
if ($pilihan_bulan==12){$bulan="Desember $pilihan_tahun";}
//Ambil Bulan END

$xml = new ExcelWriterXML("Gaji $bulan.xml");

$xml->docTitle("Gaji $bulan");
$xml->docAuthor('Robert F Greer');
$xml->docCompany('Greers.Org');
$xml->docManager('Wife');

$xml->showErrorSheet(true);

$format3 = $xml->addStyle('wraptext_top');
$format3->alignWraptext();
$format3->alignHorizontal('Center');
$format3->fontSize('12');
$format3->fontBold();

$format1 = $xml->addStyle('th');
$format1->fontBold();
$format1->border('All',1,'Black','Continuous');

//Ambli Bagian Banyak
$sql23="SELECT banyak_bagian_payroll FROM master_user WHERE email='$username'";
$result23=mysql_query($sql23);
$rows23=mysql_fetch_array($result23);
$teksperbaikan1 = str_replace("[", "(", $rows23['banyak_bagian_payroll']);
$teksperbaikan2 = str_replace("]", ")", $teksperbaikan1);
$teksperbaikan = str_replace('"', "'", $teksperbaikan2);

//JUDUL BAGIAN
$judul_bagian1 = str_replace("[", "", $rows23['banyak_bagian_payroll']);
$judul_bagian2 = str_replace("]", "", $judul_bagian1);
$judul_bagian3 = str_replace('"', "", $judul_bagian2);
if ($judul_bagian3=='null'){$judul_bagian='';}else{$judul_bagian=$judul_bagian3;}

$sheet1 = $xml->addSheet("Gaji $bulan");

//Ambil Bulan
$sql_jumlah_hari="SELECT jumlah_hari FROM payroll_gaji_potongan WHERE id='$pilihan_bulan'";
$result_jumlah_hari= mysql_query($sql_jumlah_hari);
$rows_jumlah_hari=mysql_fetch_array($result_jumlah_hari);
$jumlah_tgl=$rows_jumlah_hari['jumlah_hari'];

$sheet1->writeString(1, 1, 'PT CHINLI PLASTIC TECHNOLOGY INDONESIA','wraptext_top');
$sheet1->writeString(2, 1, "Salary Report Departement $pilihan_departement","wraptext_top");
$sheet1->writeString(3, 1, "Dari 01-$pilihan_bulan-$pilihan_tahun s/d $jumlah_tgl-$pilihan_bulan-$pilihan_tahun","wraptext_top");
$sheet1->cellMerge(1,1,11,0);
$sheet1->cellMerge(2,1,11,0);
$sheet1->cellMerge(3,1,11,0);

$sheet1->writeString(4, 1, '編號 NO','th');$sheet1->cellMerge(4,1,0,1);
$sheet1->writeString(4, 2, '工號 NIK','th');$sheet1->cellMerge(4,2,0,1);
$sheet1->writeString(4, 3, '姓名 NAMA','th');$sheet1->cellMerge(4,3,0,1);
$sheet1->writeString(4, 4, '單位 DEPARTEMENT','th');$sheet1->cellMerge(4,4,0,1);
$sheet1->writeString(4, 5, '日期開始工作 TGL MULAI KERJA','th');$sheet1->cellMerge(4,5,0,1);
$sheet1->writeString(4, 6, '工作天 JUMLAH HK','th');$sheet1->cellMerge(4,6,0,1);
$sheet1->writeString(4, 7, '年假 CUTI TAHUNAN','th');$sheet1->cellMerge(4,7,0,1);
$sheet1->writeString(4, 8, '請假 CUTI TERPAKAI','th');$sheet1->cellMerge(4,8,0,1);
$sheet1->writeString(4, 9, '離開 SISA CUTI','th');$sheet1->cellMerge(4,9,0,1);
$sheet1->writeString(4, 10, '請假 IJIN','th');$sheet1->cellMerge(4,10,0,1);
$sheet1->writeString(4, 11, '年假 CUTI','th');$sheet1->cellMerge(4,11,0,1);
$sheet1->writeString(4, 12, '病假 DOKTER','th');$sheet1->cellMerge(4,12,0,1);
$sheet1->writeString(4, 13, '曠工 MANGKIR','th');$sheet1->cellMerge(4,13,0,1);
$sheet1->writeString(4, 14, 'DISPENSASI','th');$sheet1->cellMerge(4,14,0,1);
$sheet1->writeString(4, 15, '未到職 TIDAK BEKERJA','th');$sheet1->cellMerge(4,15,0,1);
$sheet1->writeString(4, 16, '遲到 TERLAMBAT','th');$sheet1->cellMerge(4,16,0,1);
$sheet1->writeString(4, 17, '早退 P.CEPAT','th');$sheet1->cellMerge(4,17,0,1);
$sheet1->writeString(4, 18, '加班 OT 1.5','th');$sheet1->cellMerge(4,18,0,1);
$sheet1->writeString(4, 19, '加班 OT 2','th');$sheet1->cellMerge(4,19,0,1);
$sheet1->writeString(4, 20, '加班 OT 3','th');$sheet1->cellMerge(4,20,0,1);
$sheet1->writeString(4, 21, '加班 OT 4','th');$sheet1->cellMerge(4,21,0,1);

$sheet1->writeString(4, 22, '給付 PEMASUKAN','th');$sheet1->cellMerge(4,22,9,0);
$sheet1->writeString(5, 22, '薪資 GAJI POKOK','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 23, '專業獎金 UANG PROFESIONAL','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 24, '獎金 BONUS KEHADIRAN','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 25, '飯錢 UANG MAKAN','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 26, '車費 UANG TRANSPORT','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 27, '深夜加給 UANG SHIFT','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 28, '加班 LEMBUR JAM 1.5','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 29, '加班 LEMBUR JAM 2','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 30, '加班 LEMBUR JAM 3','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 31, '加班 LEMBUR JAM 4','th');$sheet1->cellMerge(5,0,0,1);

$sheet1->writeString(4, 32, '合計 JUMLAH','th');$sheet1->cellMerge(4,32,0,1);

$sheet1->writeString(4, 33, '扣除 POTONGAN','th');$sheet1->cellMerge(4,33,6,0);
$sheet1->writeString(5, 33, '醫療保險 BPJS','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 34, '社會保險 JAMSOSTEK','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 35, '退休金 DANA PENSIUN','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 36, '曠工 POT. ABSENT','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 37, '遲到 POT. TELAT','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 38, '早退 POT. PULANG CEPAT','th');$sheet1->cellMerge(5,0,0,1);
$sheet1->writeString(5, 39, '所得稅 PPH 21','th');$sheet1->cellMerge(5,0,0,1);

$sheet1->writeString(4, 40, '扣除金額總計 TOTAL POTONGAN','th');$sheet1->cellMerge(4,40,0,1);
$sheet1->writeString(4, 41, '合計 JUMLAH','th');$sheet1->cellMerge(4,41,0,1);

//Ambli Bagian Banyak
$sql23="SELECT banyak_bagian_payroll FROM master_user WHERE email='$username'";
$result23=mysql_query($sql23);
$rows23=mysql_fetch_array($result23);
$teksperbaikan1 = str_replace("[", "(", $rows23['banyak_bagian_payroll']);
$teksperbaikan2 = str_replace("]", ")", $teksperbaikan1);
$teksperbaikan = str_replace('"', "'", $teksperbaikan2);

$ejaan_sql="SELECT ejaan FROM payroll_pilihan WHERE departement='$pilihan_departement'";
$ejaan_result=mysql_query($ejaan_sql);
$ejaan_rows=mysql_fetch_array($ejaan_result);
$ejaan=$ejaan_rows['ejaan'];

$sql1="SELECT id,nomor_id,nik,nama,uang_profesional,departement,bagian,awal_masuk,mulai_kontrak,akhir_kontrak FROM payroll_data_karyawan WHERE departement LIKE '$ejaan%' AND bagian IN $teksperbaikan";
$result1=mysql_query($sql1);
$no=1;
$i=6;
while ($rows1=mysql_fetch_array($result1)) {

  //penentu pegawai baru
  $awal_masuk_pegawai=$rows1['awal_masuk'];//Pegawai Baru/Tidak
  $awal_masuk_penentu1=$rows1['awal_masuk'];
  $awal_masuk_penentu=substr($awal_masuk_penentu1,0,7);
  $tahun_bulan_pilihan="$pilihan_tahun-$pilihan_bulan";
  if ($awal_masuk_penentu==$tahun_bulan_pilihan){$pegawai_baru='ya';}else{$pegawai_baru='tidak';}

  $sheet1->writeString($i, 1, $no);//NO URUT
  $sheet1->writeString($i, 2, $rows1['nik']);//NOMOR ID/NOMOR ID DI MESIN
  $sheet1->writeString($i, 3, $rows1['nama']);//NIK
  $sheet1->writeString($i, 4, $rows1['bagian']);//NAMA

  //RUBAH FORMAT TANGGAL
  $ambil_tahun_format=substr($rows1['awal_masuk'], 0,4);
  $ambil_bulan_format=substr($rows1['awal_masuk'], 5,2);
  $ambil_tanggal_format=substr($rows1['awal_masuk'], 8,2);
  //Ambil Bulan START
  if ($ambil_bulan_format==01){$bulan_format="Januari";}
  if ($ambil_bulan_format==02){$bulan_format="Februari";}
  if ($ambil_bulan_format==03){$bulan_format="Maret";}
  if ($ambil_bulan_format==04){$bulan_format="April";}
  if ($ambil_bulan_format==05){$bulan_format="Mei";}
  if ($ambil_bulan_format==06){$bulan_format="Juni";}
  if ($ambil_bulan_format==07){$bulan_format="Juli";}
  if ($ambil_bulan_format==08){$bulan_format="Agustus";}
  if ($ambil_bulan_format==09){$bulan_format="September";}
  if ($ambil_bulan_format==10){$bulan_format="Oktober";}
  if ($ambil_bulan_format==11){$bulan_format="Nopember";}
  if ($ambil_bulan_format==12){$bulan_format="Desember";}
  //Ambil Bulan END
  $sheet1->writeString($i, 5, "$ambil_tanggal_format $bulan_format $ambil_tahun_format");//TANGGAL MASUK

  //JUMLAH HARI KERJA
  $sql2="SELECT tanggal,scan_masuk,scan_pulang,status FROM payroll_absensi WHERE nomor_id='$rows1[nomor_id]' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' AND status IN ('','PULANG CEPAT')";
  $result2=mysql_query($sql2);
  $rows2=mysql_fetch_array($result2);
  $hari_kerja=mysql_num_rows($result2);
  $sheet1->writeString($i, 6, $hari_kerja);
  //JUMLAH HARI KERJA

  //CUTI
  $sheet1->writeString($i, 7, dapatcuti($rows1['bagian'],$rows1['awal_masuk'],$rows1['mulai_kontrak'],$rows1['akhir_kontrak']));
  $sheet1->writeString($i, 8, cutiterpakai($rows1['nomor_id'],$rows1['awal_masuk'],$rows1['mulai_kontrak'],$rows1['akhir_kontrak'],$rows1['id'],cutiterpakai));
  $sheet1->writeString($i, 9, cutiterpakai($rows1['nomor_id'],$rows1['awal_masuk'],$rows1['mulai_kontrak'],$rows1['akhir_kontrak'],$rows1['id'],cutitersisa));
  //CUTI

  //Tidak Hadir Start
  $cuti=halangan($rows1[nomor_id],CUTI,$pilihan_bulan,$pilihan_tahun);
  $ijin=halangan($rows1[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
  $mangkir=halangan($rows1[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
  $dokter=halangan($rows1[nomor_id],DOKTER,$pilihan_bulan,$pilihan_tahun);
  $dispensasi=halangan($rows1[nomor_id],DISPENSASI,$pilihan_bulan,$pilihan_tahun);
  $sheet1->writeString($i, 10, halangan($rows1[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 11, halangan($rows1[nomor_id],CUTI,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 12, halangan($rows1[nomor_id],DOKTER,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 13, halangan($rows1[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 14, halangan($rows1[nomor_id],DISPENSASI,$pilihan_bulan,$pilihan_tahun));
  //Tidak Hadir End

  //TIDAK BEKERJA
  //TIDAK BEKERJA KARYAWAN BARU
  $awal_masuk_pegawai=$rows1['awal_masuk'];//Pegawai Baru/Tidak
  $awal_masuk_penentu1=$rows1['awal_masuk'];
  $awal_masuk_penentu=substr($awal_masuk_penentu1,0,7);
  $tahun_bulan_pilihan="$pilihan_tahun-$pilihan_bulan";
  if ($awal_masuk_penentu==$tahun_bulan_pilihan){$pegawai_baru='ya';}else{$pegawai_baru='tidak';}
  $tidak_hadir_lainnya=$cuti+$ijin+$mangkir+$dokter+$dispensasi;
  $sheet1->writeString($i, 15, tidak_bekerja_pegawai_baru($pegawai_baru,$rows1[nomor_id],$pilihan_tahun,$pilihan_bulan,$tidak_hadir_lainnya));
  //TIDAK BEKERJA

  //Terlambat Dan Pulang Cepat Start
  $sheet1->writeString($i, 16, terlambat_pulangcepat($rows1[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 17, terlambat_pulangcepat($rows1[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun));
  //Terlambat Dan Pulang Cepat End

  //Lemburan START
  $sheet1->writeString($i, 18, lembur($rows1[nomor_id],ot1,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 19, lembur($rows1[nomor_id],ot2,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 20, lembur($rows1[nomor_id],ot3,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 21, lembur($rows1[nomor_id],ot4,$pilihan_bulan,$pilihan_tahun));
  //Lemburan END

  $sheet1->writeString($i, 22, gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja));//GAJI POKOK
  //Uang Profesional
  if ($pegawai_baru==ya OR $hari_kerja==0){$uang_profesional_riil=0;}else{$uang_profesional_riil=$rows1[uang_profesional];}
  $sheet1->writeString($i, 23, $uang_profesional_riil);//UANG PROFESIONAL

  //START UANG PREMI
      $cuti=halangan($rows1[nomor_id],CUTI,$pilihan_bulan,$pilihan_tahun);
      $ijin=halangan($rows1[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
      $mangkir=halangan($rows1[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
      $dokter=halangan($rows1[nomor_id],DOKTER,$pilihan_bulan,$pilihan_tahun);
      $dispensasi=halangan($rows1[nomor_id],DISPENSASI,$pilihan_bulan,$pilihan_tahun);
      $terlambat=total_telat_diatas_35m($rows1[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun);
      $pulang_cepat=total_telat_diatas_35m($rows1[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun);
      $setengah_hari=setengah_hari($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun);
      $bonus_kehadiran=bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$setengah_hari);
  $sheet1->writeString($i, 24, bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$setengah_hari));
  //END UANG PREMI

  //START UANG MAKAN
  $sheet1->writeString($i, 25, uangmakan($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun))."</td>";
  //START TRANSPORT
  $sheet1->writeString($i, 26, uangtransport($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun))."</td>";
  //UANG SHIFT
  $sheet1->writeString($i, 27, uangshift($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun))."</td>";

  //UANG LEMBUR
  $uang_lembur_ot1=lembur($rows1[nomor_id],ot1,$pilihan_bulan,$pilihan_tahun);
  $uang_lembur_ot2=lembur($rows1[nomor_id],ot2,$pilihan_bulan,$pilihan_tahun);
  $uang_lembur_ot3=lembur($rows1[nomor_id],ot3,$pilihan_bulan,$pilihan_tahun);
  $uang_lembur_ot4=lembur($rows1[nomor_id],ot4,$pilihan_bulan,$pilihan_tahun);
  $sheet1->writeString($i, 28, uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 29, uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 30, uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun));
  $sheet1->writeString($i, 31, uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun));
  //UANG LEMBUR

  //TOTAL PEMASUKAN
  $total_pemasukan=gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
  $uang_profesional_riil+
  $bonus_kehadiran+
  uangmakan($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun)+
  uangtransport($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun)+
  uangshift($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun)+
  uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun)+
  uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun)+
  uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun)+
  //thr($rows1[id],$pilihan_tahun,$pilihan_bulan)+
  uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun);
  $sheet1->writeString($i, 32, $total_pemasukan);
  //TOTAL PEMASUKAN

  //POTONGAN BPJS
  $sql18="SELECT jumlah_tanggungan_bpjs FROM payroll_data_karyawan WHERE nomor_id='$rows1[nomor_id]'";
  $result18= mysql_query($sql18);
  $rows18=mysql_fetch_array($result18);
  $jumlah_tanggungan=$rows18['jumlah_tanggungan_bpjs']+1;
  $sheet1->writeString($i, 33, potonganbpjs($rows1[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja))."</td>";
  $sheet1->writeString($i, 34, potonganbpjs($rows1[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja))."</td>";
  $sheet1->writeString($i, 35, potonganbpjs($rows1[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja))."</td>";
  //POTONGAN BPJS

  //POTONGAN ABSENT
  $ijin=halangan($rows1[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
  $mangkir=halangan($rows1[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
  $tidak_bekerja_pb=tidak_bekerja_pegawai_baru($pegawai_baru,$rows1[nomor_id],$pilihan_tahun,$pilihan_bulan,$tidak_hadir_lainnya);
  $sheet1->writeString($i, 36, potonganabsent($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb));
  //POTONGAN ABSENT

  //POTONGAN TERLAMBAT PULANG CEPAT
  $ijin=halangan($rows1[nomor_id],IJIN,$pilihan_bulan,$pilihan_tahun);
  $mangkir=halangan($rows1[nomor_id],MANGKIR,$pilihan_bulan,$pilihan_tahun);
  $sheet1->writeString($i, 37, potongan_telat_pulang_cepat($rows1[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows1[departement],$rows1[bagian]));
  $sheet1->writeString($i, 38, potongan_telat_pulang_cepat($rows1[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows1[departement],$rows1[bagian]));
  //POTONGAN TERLAMBAT PULANG CEPAT

  //PPH21
  $sql22="SELECT pph_bulan FROM payroll_potongan_pph21 WHERE induk='$rows1[id]'";
  $result22=mysql_query($sql22);
  $rows22=mysql_fetch_array($result22);
  $sheet1->writeString($i, 39, $rows22[pph_bulan]);

  //TOTAL POTONGAN
  $total_potongan=
  $rows22[pph_bulan]+
  potonganbpjs($rows1[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
  potonganbpjs($rows1[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
  potonganbpjs($rows1[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+
  potonganabsent($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb)+
  potongan_telat_pulang_cepat($rows1[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows1[departement],$rows1[bagian])+
  potongan_telat_pulang_cepat($rows1[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows1[departement],$rows1[bagian]);
  $sheet1->writeString($i, 40, $total_potongan);

  //TOTAL GAJI
  $total_gaji=$total_pemasukan-$total_potongan;
  $sheet1->writeString($i, 41, $total_gaji);

//Nilai KOLOM UNTUK TOTAL KESELURUHAN
//NILAI TOTAL SEMUA KARYAWAN
$total_seluruh_cuti=$cuti+$total_seluruh_cuti;//TOTAL CUTI
$total_seluruh_ijin=$ijin+$total_seluruh_ijin;//TOTAL IJIN
$total_seluruh_mangkir=$mangkir+$total_seluruh_mangkir;//TOTAL MANGKIR
$total_seluruh_dokter=$dokter+$total_seluruh_dokter;//TOTAL DOKTER
$total_seluruh_dispensasi=$dispensasi+$total_seluruh_dispensasi;//TOTAL DISPENSASI
$total_seluruh_tidak_bekerja=tidak_bekerja_pegawai_baru($pegawai_baru,$rows1[nomor_id],$pilihan_tahun,$pilihan_bulan,$tidak_hadir_lainnya)+$total_seluruh_tidak_bekerja;//TOTAL IJIN
$total_seluruh_terlambat=terlambat_pulangcepat($rows1[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_terlambat;// TOTAL TERLAMBAT
$total_seluruh_pulang_cepat=terlambat_pulangcepat($rows1[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_pulang_cepat;// TOTAL PULANG CEPAT
$total_seluruh_ot1=$uang_lembur_ot1+$total_seluruh_ot1;//LEMBUR 1
$total_seluruh_ot2=$uang_lembur_ot2+$total_seluruh_ot2;//LEMBUR 2
$total_seluruh_ot3=$uang_lembur_ot3+$total_seluruh_ot3;//LEMBUR 3
$total_seluruh_ot4=$uang_lembur_ot4+$total_seluruh_ot4;//LEMBUR 4

//PENGELUARAN
$total_seluruh_gaji_pokok=gajipokok($pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_gaji_pokok;//GAJI POKOK
$total_seluruh_uang_profesional=$uang_profesional+$total_seluruh_uang_profesional;//UANG PROFESIONAL
$total_seluruh_bonus_kehadiran=bonuskehadiran($pilihan_bulan,$pilihan_tahun,$cuti,$ijin,$mangkir,$dokter,$dispensasi,$terlambat,$pulang_cepat,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja,$setengah_hari)+$total_seluruh_bonus_kehadiran;//BONUS KEHADIRAN
$total_seluruh_uang_makan=uangmakan($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun)+$total_seluruh_uang_makan;//UANG MAKAN
$total_seluruh_uang_transport=uangtransport($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun)+$total_seluruh_uang_transport;//UANG TRANSPORT
$total_seluruh_uang_shift=uangshift($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun)+$total_seluruh_uang_shift;//UANG SHIFT
$total_seluruh_lembur_ot1=uanglembur($uang_lembur_ot1,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot1;//OT 1
$total_seluruh_lembur_ot2=uanglembur($uang_lembur_ot2,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot2;//OT 2
$total_seluruh_lembur_ot3=uanglembur($uang_lembur_ot3,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot3;//OT 3
$total_seluruh_lembur_ot4=uanglembur($uang_lembur_ot4,$pilihan_bulan,$pilihan_tahun)+$total_seluruh_lembur_ot4;//OT 4
$total_seluruh_thr=thr($rows1[id],$pilihan_tahun,$pilihan_bulan)+$total_seluruh_thr;//THR
$total_seluruh_pemasukan=$total_pemasukan+$total_seluruh_pemasukan; $total_seluruh_pemasukan1=rupiah($total_seluruh_pemasukan);//SELURUH PEMASUKAN

//PEMASUKAN
$total_seluruh_potongan_bpjs=potonganbpjs($rows1[nomor_id],$jumlah_tanggungan,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_potongan_bpjs;//POTONGAN BPJS
$total_seluruh_potongan_jamsostek=potonganbpjs($rows1[nomor_id],2,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_potongan_jamsostek;//POTONGAN JAMSOSTEK
$total_seluruh_potongan_dana_pensiun=potonganbpjs($rows1[nomor_id],1,$pilihan_bulan,$pilihan_tahun,$awal_masuk_pegawai,$pegawai_baru,$hari_kerja)+$total_seluruh_potongan_dana_pensiun;//TOTAL DANA PENSIUN
$total_seluruh_potongan_absent=potonganabsent($rows1[nomor_id],$pilihan_bulan,$pilihan_tahun,$ijin,$mangkir,$tidak_bekerja_pb)+$total_seluruh_potongan_absent;//TOTAL SELURUH POTONGAN ABSENT
$total_seluruh_potongan_terlambat=potongan_telat_pulang_cepat($rows1[nomor_id],terlambat,$pilihan_bulan,$pilihan_tahun,$rows1[departement],$rows1[bagian])+$total_seluruh_potongan_terlambat;//TOTAL TERLAMBAT
$total_seluruh_potongan_pulang_cepat=potongan_telat_pulang_cepat($rows1[nomor_id],pulang_cepat,$pilihan_bulan,$pilihan_tahun,$rows1[departement],$rows1[bagian])+$total_seluruh_potongan_pulang_cepat;//TOTAL PULANG CEPAT
$total_seluruh_potongan_pph21=$rows22[pph_bulan]+$total_seluruh_potongan_pph21;// PPH 21
$total_seluruh_pengeluaran=$total_potongan+$total_seluruh_pengeluaran; $total_seluruh_pengeluaran1=rupiah($total_seluruh_pengeluaran);//SELURUH PENGELUARAN

$nilai_setelah_dikurang=$total_seluruh_pemasukan-$total_seluruh_pengeluaran; $nilai_setelah_dikurang1=rupiah($nilai_setelah_dikurang);//PEMASUKAN - PENGELUARAN
$i1=1+$i1;

$total_seluruh_hari_kerja=$hari_kerja+$total_seluruh_hari_kerja;
$total_seluruh_cuti_tahunan=dapatcuti($rows1['bagian'],$rows1['awal_masuk'],$rows1['mulai_kontrak'],$rows1['akhir_kontrak'])+$total_seluruh_cuti_tahunan;
$total_seluruh_cuti_terpakai=cutiterpakai($rows1['nomor_id'],$rows1['awal_masuk'],$rows1['mulai_kontrak'],$rows1['akhir_kontrak'],$rows1['id'],cutiterpakai)+$total_seluruh_cuti_terpakai;
$total_seluruh_sisa_cuti=cutiterpakai($rows1['nomor_id'],$rows1['awal_masuk'],$rows1['mulai_kontrak'],$rows1['akhir_kontrak'],$rows1['id'],cutitersisa)+$total_seluruh_sisa_cuti;

$no++;$i++;}

//KOLOM UNTUK TOTAL KESELURUHAN
$i2=$i1+6;
$sheet1->writeString($i2, 1, TOTAL,"th");$sheet1->cellMerge($i2,1,4,0);

$sheet1->writeString($i2, 6, $total_seluruh_hari_kerja,"th");
$sheet1->writeString($i2, 7, $total_seluruh_cuti_tahunan,"th");
$sheet1->writeString($i2, 8, $total_seluruh_cuti_terpakai,"th");
$sheet1->writeString($i2, 9, $total_seluruh_sisa_cuti,"th");

$sheet1->writeString($i2, 10, $total_seluruh_ijin,"th");
$sheet1->writeString($i2, 11, $total_seluruh_cuti,"th");
$sheet1->writeString($i2, 12, $total_seluruh_dokter,"th");
$sheet1->writeString($i2, 13, $total_seluruh_mangkir,"th");
$sheet1->writeString($i2, 14, $total_seluruh_dispensasi,"th");
$sheet1->writeString($i2, 15, $total_seluruh_tidak_bekerja,"th");
$sheet1->writeString($i2, 16, $total_seluruh_terlambat,"th");
$sheet1->writeString($i2, 17, $total_seluruh_pulang_cepat,"th");
$sheet1->writeString($i2, 18, $total_seluruh_ot1,"th");
$sheet1->writeString($i2, 19, $total_seluruh_ot2,"th");
$sheet1->writeString($i2, 20, $total_seluruh_ot3,"th");
$sheet1->writeString($i2, 21, $total_seluruh_ot4,"th");

$sheet1->writeString($i2, 22, $total_seluruh_gaji_pokok,"th");
$sheet1->writeString($i2, 23, $total_seluruh_uang_profesional,"th");
$sheet1->writeString($i2, 24, $total_seluruh_bonus_kehadiran,"th");
$sheet1->writeString($i2, 25, $total_seluruh_uang_makan,"th");
$sheet1->writeString($i2, 26, $total_seluruh_uang_transport,"th");
$sheet1->writeString($i2, 27, $total_seluruh_uang_shift,"th");
$sheet1->writeString($i2, 28, $total_seluruh_lembur_ot1,"th");
$sheet1->writeString($i2, 29, $total_seluruh_lembur_ot2,"th");
$sheet1->writeString($i2, 30, $total_seluruh_lembur_ot3,"th");
$sheet1->writeString($i2, 31, $total_seluruh_lembur_ot4,"th");
$sheet1->writeString($i2, 32, $total_seluruh_pemasukan,"th");

$sheet1->writeString($i2, 33, $total_seluruh_potongan_bpjs,"th");
$sheet1->writeString($i2, 34, $total_seluruh_potongan_jamsostek,"th");
$sheet1->writeString($i2, 35, $total_seluruh_potongan_dana_pensiun,"th");
$sheet1->writeString($i2, 36, $total_seluruh_potongan_absent,"th");
$sheet1->writeString($i2, 37, $total_seluruh_potongan_terlambat,"th");
$sheet1->writeString($i2, 38, $total_seluruh_potongan_pulang_cepat,"th");
$sheet1->writeString($i2, 39, $total_seluruh_potongan_pph21,"th");
$sheet1->writeString($i2, 40, $total_seluruh_pengeluaran,"th");

$sheet1->writeString($i2, 41, $nilai_setelah_dikurang,"th");

$xml->sendHeaders();
$xml->writeData();
?>
