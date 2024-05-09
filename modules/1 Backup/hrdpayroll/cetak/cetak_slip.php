<?php //KONEKSI DATABASE
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
//KONEKSI DATABASE?>

<?php // START FUNCTION

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

	function base64_decrypt($enc_text, $password, $iv_len = 16)
	{
	$enc_text = str_replace('@', '+', $enc_text);
	$enc_text = base64_decode($enc_text);
	$n = strlen($enc_text);
	$i = $iv_len;
	$plain_text = '';
	$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
	while ($i < $n) {
	$block = substr($enc_text, $i, 16);
	$plain_text .= $block ^ pack('H*', md5($iv));
	$iv = substr($block . $iv, 0, 512) ^ $password;
	$i += 16;
	}
	return preg_replace('/\\x13\\x00*$/', '', $plain_text);
	}
	function get_rnd_iv($iv_len)
	{
	$iv = '';
	while ($iv_len-- > 0) {
	$iv .= chr(mt_rand() & 0xff);
	}
	return $iv;
	}//// ENKRIPSI END

	function datediff($tgl1, $tgl2){
	$tgl1 = strtotime($tgl1);
	$tgl2 = strtotime($tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
	}

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

	function rupiah($angka){
	$hasil_rupiah = "" . number_format($angka,0,'',',');
	return $hasil_rupiah;}
// START FUNCTION ?>

<?php // START AREA PRINT
include ('../style.css');
error_reporting(0);
$nama_database='hrd_data_karyawan';
$nama_database_absensi='hrd_payroll_absensi_items';
//$nama_database_items='deliverycl_invoice_items';

//AMBIL POST
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$induk_no_invoice=ambil_database(no_invoice,deliverycl_invoice,"id='$id'");
$bahasa='ina';
$username=$_GET['username'];

$list_pilihan=base64_decrypt($_GET['id_download'],"XblImpl1!A@");
$pecah_column_isi=explode (",",$list_pilihan);
$total_data=$_GET['td'];
$pilihan_tahun=$_GET['pilihan_tahun'];
$pilihan_bulan=$_GET['pilihan_bulan'];
//AMBIL POST END



//TITLE
echo "<html>
<head><title>Cetak Slip Gaji</title></head>
<body>";
//END TITLE


$jumlah_baris_kebawah=ceil($total_data/3);
$jumlah_table_kebawah=ceil($jumlah_baris_kebawah/3);

	$no=1;for($i=0; $i < $jumlah_table_kebawah; ++$i){
	echo "<div class='pagebreak'>";
	echo "<table align='center' style='	border:1px solid #999; width:auto; height:auto;'>";//width:570; height:912px;
	$no=8+$no;
	$total_awal_table=$no-11;

							$no_2=$total_awal_table;for($i_2=0; $i_2 < 2; ++$i_2){
							$no_2=2+$no_2;
								echo "<tr>";

													$no_3=$no_2;for($i_3=0; $i_3 < 1; ++$i_3){
														$id_pegawai=$pecah_column_isi[$no_3];
														$nik=ambil_database(nik,$nama_database,"id='$id_pegawai'");
														$nama=ambil_database(nama,$nama_database,"id='$id_pegawai'");
														$departement=ambil_database(bagian,$nama_database,"id='$id_pegawai'");

														echo "<td style='width:600px; height:302px; border:1px solid; vertical-align: text-top;'>";


														echo "<table style='font-size:14px; width:100%;'>";
																	echo "<tr>";
																		echo "<td style='font-size:170%; color:red; border-bottom:1px solid;'><center>PT CHINLI PLASTIC TECHNOLOGY INDONESIA</center></td>";
																	echo "</tr>";

																	echo "<tr>";
																		echo "<td style='color:red;'><center>SLIP GAJI KARYAWAN</center></td>";
																	echo "</tr>";
														echo "</table>";

														echo "<table style='width:100%; font-size:12px;'>";
																	echo "<tr>";
																		echo "<td>Nik</td>";
																		echo "<td>:</td>";
																		echo "<td>$nik</td>";

																		echo "<td>Tgl. Periode</td>";
																		echo "<td>:</td>";
																		echo "<td>$pilihan_tahun-$pilihan_bulan</td>";
																	echo "</tr>";

																	echo "<tr>";
																		echo "<td>Nama</td>";
																		echo "<td>:</td>";
																		echo "<td>$nama</td>";

																		echo "<td>Tgl. Cetak</td>";
																		echo "<td>:</td>";
																		echo "<td>".date('Y-m-d')."</td>";
																	echo "</tr>";

																	echo "<tr>";
																		echo "<td>Departement</td>";
																		echo "<td>:</td>";
																		echo "<td>$departement</td>";

																		echo "<td></td>";
																		echo "<td></td>";
																		echo "<td></td>";
																	echo "</tr>";
														echo "</table>";

												echo "<table style='width:100%; font-size:12px; border:1px solid;'>";

												echo "<tr>";
														echo "<td>ATTENDANCE</td>";
														echo "<td>ALLOWANCE</td>";
														echo "<td>DEDUCTION</td>";
												echo "</tr>";
																	echo "<tr>";

																	//ATTENDANCE
																	echo "<td style='width:20%;'>";
																	$hk=total_absensi(hari_kerja,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$alpa=total_absensi(alpa,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$cuti=total_absensi(cuti,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$dokter=total_absensi(dokter,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$telat=total_absensi(terlambat,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$pulang_cepat=total_absensi(pulang_cepat,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$lembur_1=total_absensi(lembur_1,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$lembur_2=total_absensi(lembur_2,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$lembur_3=total_absensi(lembur_3,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$lembur_4=total_absensi(lembur_4,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$total_lembur=$lembur_1+$lembur_2+$lembur_3+$lembur_4;
																	echo "<table style='width:100%; font-size:10px; border:1px solid;'>";

																	echo "<tr>";
																				echo "<td>Total Hari</td>";echo "<td>:</td>";echo "<td>$hk</td>";
																	echo "</tr>";

																	echo "<tr>";
																				echo "<td>Absen</td>";echo "<td>:</td>";echo "<td>$alpa</td>";
																	echo "</tr>";

																	echo "<tr>";
																				echo "<td>Sakit</td>";echo "<td>:</td>";echo "<td>$dokter</td>";
																	echo "</tr>";

																	echo "<tr>";
																				echo "<td>Cuti</td>";echo "<td>:</td>";echo "<td>$cuti</td>";
																	echo "</tr>";

																	echo "<tr>";
																				echo "<td>Terlambat</td>";echo "<td>:</td>";echo "<td>$telat</td>";
																	echo "</tr>";

																	echo "<tr>";
																				echo "<td>Pulang Cepat</td>";echo "<td>:</td>";echo "<td>$pulang_cepat</td>";
																	echo "</tr>";

																	echo "<tr>";
																				echo "<td>Total Lembur</td>";echo "<td>:</td>";echo "<td>$total_lembur</td>";
																	echo "</tr>";
																	echo "</table>";
																	echo "</td>";
																	//ATTENDANCE END


																	//	ALLOWANCE

																	//GAJI POKOK
																	$tunjangan_gaji_pokok=ambil_database(gaji_pokok,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	$pegawai_baru=pegawai_baru(ambil_database(tanggal_masuk,hrd_data_karyawan,"id='$id_pegawai'"),"$pilihan_tahun-$pilihan_bulan-$tunjangan_jumlah_hari");
																	if ($pegawai_baru=='yes') {
																		$gaji_pokok=$tunjangan_gaji_pokok/$tunjangan_jumlah_hari*$hk;
																	}else{
																		$gaji_pokok=$tunjangan_gaji_pokok;
																	}//GAJI POKOK END
																	//UANG PROFESIONAL
																	$uang_profesional=ambil_database(uang_profesional,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	//UANG PROFESIONAL END
																	//BONUS KEHADIRAN
																	$tunjangan_bonus_kehadiran=ambil_database(bonus_kehadiran,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	$jumlah_telat=total_telat_pulpet($id_pegawai,"$pilihan_tahun-$pilihan_bulan",terlambat);
																	$jumlah_pulang_cepat=total_telat_pulpet($id_pegawai,"$pilihan_tahun-$pilihan_bulan",pulang_cepat);
																	$jumlah_setengah_hari=total_telat_pulpet($id_pegawai,"$pilihan_tahun-$pilihan_bulan",setengah_hari);
																	$bonus_kehadiran=premi($tunjangan_bonus_kehadiran,$alpa,$cuti,$ijin,$dokter,$jumlah_telat,$jumlah_pulang_cepat,$jumlah_setengah_hari);
																	//BONUS KEHADIRAN END
																	//UANG MAKAN
																	$tunjangan_uang_makan=ambil_database(uang_makan,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	$um=total_absensi(uang_makan,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$uang_makan=$um*$tunjangan_uang_makan;
																	//BONUS MAKAN END
																	//UANG TRANSPORT
																	$tunjangan_uang_transport=ambil_database(uang_transport,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	$ut=total_absensi(uang_transport,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$uang_transport=$ut*$tunjangan_uang_transport;
																	//BONUS TRANSPORT END
																	//UANG LEMBUR
																	$tunjangan_lemburan=floor($tunjangan_gaji_pokok/173);
																	$nilai_lembur_1=1.5*$tunjangan_lemburan*$lembur_1;
																	$nilai_lembur_2=2*$tunjangan_lemburan*$lembur_2;
																	$nilai_lembur_3=3*$tunjangan_lemburan*$lembur_3;
																	$nilai_lembur_4=4*$tunjangan_lemburan*$lembur_4;
																	$total_lembur=$nilai_lembur_1+$nilai_lembur_2+$nilai_lembur_3+$nilai_lembur_4;
																	//UANG LEMBUR END
																	//UANG SHIFT
																	$tunjangan_uang_shift=ambil_database(uang_shift,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	$us=total_absensi(uang_shift,$nama_database_absensi,"id_pegawai='$id_pegawai' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'");
																	$uang_shift=$us*$tunjangan_uang_shift;
																	//UANG SHIFT END

																	echo "<td style='width:40%;'>";
																			echo "<table style='width:100%; font-size:10px; border:1px solid;'>";

																					echo "<tr>";
																								echo "<td>Gaji Pokok</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($gaji_pokok)."</td>";
																					echo "</tr>";

																					echo "<tr>";
																								echo "<td>Uang Profesional</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($uang_profesional)."</td>";
																					echo "</tr>";

																					echo "<tr>";
																								echo "<td>Premi Kehadiran</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($bonus_kehadiran)."</td>";
																					echo "</tr>";

																					echo "<tr>";
																								echo "<td>Uang Makan</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($uang_makan)."</td>";
																					echo "</tr>";

																					echo "<tr>";
																								echo "<td>Uang Transport</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($uang_transport)."</td>";
																					echo "</tr>";

																					echo "<tr>";
																								echo "<td>Lembur</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($total_lembur)."</td>";
																					echo "</tr>";

																					echo "<tr>";
																								echo "<td>Uang Shift</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($uang_shift)."</td>";
																					echo "</tr>";

																			echo "</table>";
																	echo "</td>";
																	//	ALLOWANCE END


																	//	DEDUCTION
																	//BPJS
																	$tunjangan_bpjs=ambil_database(bpjs,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	$tanggungan_bpjs=ambil_database(tambah_bpjs,$nama_database_absensi,"id_pegawai='".$id_pegawai."' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'")+1;
																	$bpjs=$tanggungan_bpjs*$tunjangan_bpjs;
																	//BPJS END
																	//JAMSOSTEK
																	$tunjangan_jamsostek=ambil_database(jamsostek,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	//JAMSOSTEK END
																	//DANA PENSIUN
																	$tunjangan_dana_pensiun=ambil_database(dana_pensiun,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");	$tunjangan_jumlah_hari=ambil_database(jumlah_hari,hrd_payroll_tunjangan,"tahun='$pilihan_tahun' AND bulan='$pilihan_bulan'");
																	//DANA PENSIUN END
																	//POT ABSENT
																	$gaji_pokok_uang_profesional=$gaji_pokok+$uang_profesional;
																	$rumus_pot_absent=$gaji_pokok_uang_profesional/$tunjangan_jumlah_hari;
																	$pot_absent_ijin=$rumus_pot_absent*$ijin;
																	$pot_absent_alpa=$rumus_pot_absent*$alpa;
																	$pot_absent=$pot_absent_ijin+$pot_absent_alpa;
																	//POT ABSENT END
																	//TERLAMBAT
																	$total_telat=terlambat($id_pegawai,"$pilihan_tahun-$pilihan_bulan",$gaji_pokok);
																	//TERLAMBAT END
																	//PULANG CEPAT
																	$total_pulang_cepat=pulang_cepat($id_pegawai,"$pilihan_tahun-$pilihan_bulan",$gaji_pokok);
																	//PULANG CEPAT END
																	//SETENGAH HARI
																	$total_setengah_hari=setengah_hari($id_pegawai,"$pilihan_tahun-$pilihan_bulan",$gaji_pokok);
																	//SETENGAH HARI END

																	echo "<td style='width:40%;'>";
																			echo "<table style='width:100%; font-size:10px; border:1px solid;'>";

																			echo "<tr>";
																						echo "<td>Potongan BPJS</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($bpjs)."</td>";
																			echo "</tr>";

																			echo "<tr>";
																						echo "<td>Potongan Jamsostek</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($tunjangan_jamsostek)."</td>";
																			echo "</tr>";

																			echo "<tr>";
																						echo "<td>Potongan Dana Pensiun</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($tunjangan_dana_pensiun)."</td>";
																			echo "</tr>";

																			echo "<tr>";
																						echo "<td>Potongan Absen</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($pot_absent)."</td>";
																			echo "</tr>";

																			echo "<tr>";
																						echo "<td>Potongan Terlambat</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($total_telat)."</td>";
																			echo "</tr>";

																			echo "<tr>";
																						echo "<td>Potongan Pulang Cepat</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($total_pulang_cepat)."</td>";
																			echo "</tr>";

																			echo "<tr>";
																						echo "<td>Potongan 1/2 Hari</td>";echo "<td>: Rp</td>";echo "<td style='text-align:right;'>".rupiah($total_setengah_hari)."</td>";
																			echo "</tr>";

																			echo "</table>";
																	echo "</td>";
																	//	DEDUCTION END
											echo "</tr>";

											echo "<tr>";
															$jumlah_pemasukan=$gaji_pokok+$uang_profesional+$bonus_kehadiran+$uang_makan+$uang_transport+$uang_shift+$nilai_lembur_1+$nilai_lembur_2+$nilai_lembur_3+$nilai_lembur_4;
															$jumlah_potongan=$bpjs+$tunjangan_jamsostek+$tunjangan_dana_pensiun+$pot_absent+$total_telat+$total_pulang_cepat+$total_setengah_hari;
															echo "<td style='font-size:12px; font-weight:bold;'>TOTAL</td>";
															echo "<td style='font-size:12px; font-weight:bold; text-align:right;'>Rp ".rupiah($jumlah_pemasukan)."</td>";
															echo "<td style='font-size:12px; font-weight:bold; text-align:right;'>Rp ".rupiah($jumlah_potongan)."</td>";
											echo "</tr>";


											echo "<tr>";
											$total_didapat=$jumlah_pemasukan-$jumlah_potongan;
											echo "<td colspan=2 style='border:1px solid; color:red; font-size:12px; font-weight:bold;'>TOTAL GAJI BERSIH</td>";
											echo "<td colspan=2 style='border:1px solid; color:red; font-size:12px; font-weight:bold; text-align:right;'>Rp ".rupiah($total_didapat)."</td>";
											echo "</tr>";

											echo "<tr>";
													echo "<td colspan=3 style='font-size:12px; font-weight:bold; text-align:right;'>Tanda Tangan Karyawan</td>";
											echo "</tr>";

											echo "<tr>";
													echo "<td colspan=3 style='font-size:9px; font-weight:bold;'>
													Keterangan (Penerimaan Gaji Cash) :</br>
													Sebelum meninggalkan ruangan mohon hitung kembali GAJI yang diterima, apabila komplain diluar</br>
													ruangan maka hal tersebut diluar tanggung jawab HRD & ACCOUNTING.</td>";
											echo "</tr>";

											echo "</table>";
											$no_3++;}
							$no_2++;}

	echo "</table>";
	echo "</div>";
	$no++;}





//PERINTAH PRINT
echo "<script>";
echo "
var css = '@page { size: portrait; }',
head = document.head || document.getElementsByTagName('head')[0],
style = document.createElement('style');
style.type = 'text/css';
style.media = 'print';
if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}
head.appendChild(style);
window.print();
</script>";
//PERINTAH PRINT END


echo "
</body>
</html>";
 // END AREA PRINT ?>
