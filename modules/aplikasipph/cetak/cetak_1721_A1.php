<?php //KONEKSI DATABASE
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
//KONEKSI DATABASE

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function npwp($nilai){
	$NPWP2=substr($nilai,0,2);
	$NPWP3=substr($nilai,2,3);
	$NPWP4=substr($nilai,5,3);
	$NPWP5=substr($nilai,8,1);
	$NPWP6=substr($nilai,9,3);
	$NPWP7=substr($nilai,12,3);
	$nilai1="$NPWP2.$NPWP3.$NPWP4.$NPWP5-$NPWP6.$NPWP7";
	return $nilai1;}

function rupiah_tanpa_rp($angka){
$hasil_rupiah = "" . number_format($angka,0,'','.');
return $hasil_rupiah;}

?>

<?php // START FUNCTION
if ($_POST['id']) {
	$id=$_POST['id'];
}else {
	$id=$_GET['id'];
}

// WORD START
$document = file_get_contents("../../aplikasipph/cetak/1721_A1.rtf");

//HEADER
$tahun_pajak_2_digit=substr(ambil_database(tahun_pajak,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'"),2,2);//1
$nama_instansi=ambil_database(nama_instansi,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'");//6
$npwp_instansi_12_digit=substr(npwp(ambil_database(npwp_instansi,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'")),0,12);//8
$npwp_instansi_3_digit_13=substr(npwp(ambil_database(npwp_instansi,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'")),13,3);//9
$npwp_instansi_3_digit_17=substr(npwp(ambil_database(npwp_instansi,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'")),17,3);//10
$dari_bulan=ambil_database(dari_bulan,aplikasipph_gaji,"id='$id'");//10
$sampai_bulan=ambil_database(sampai_bulan,aplikasipph_gaji,"id='$id'");//10
$nomor_tahun=$tahun_pajak_2_digit-1;

$urut=ambil_database(urut,aplikasipph_gaji,"id='$id'");//10
$jumlah_karakter_nol20=7-strlen(ambil_database(urut,aplikasipph_gaji,"id='$id'"));
if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}
if($jumlah_karakter_nol20=='5'){$hasil_nol='00000';}
if($jumlah_karakter_nol20=='6'){$hasil_nol='000000';}

$document = str_replace("[1]", "1.1", $document);
$document = str_replace("[2]", "12", $document);
$document = str_replace("[3]", "$nomor_tahun", $document);
$document = str_replace("[4]", "$hasil_nol$urut", $document);
$document = str_replace("[5]", "$dari_bulan", $document);
$document = str_replace("[6]", "$sampai_bulan", $document);
$document = str_replace("[7]", "$npwp_instansi_12_digit", $document);
$document = str_replace("[8]", "$npwp_instansi_3_digit_13", $document);
$document = str_replace("[9]", "$npwp_instansi_3_digit_17", $document);
$document = str_replace("[10]", "$nama_instansi", $document);
//HEADER END



//A. IDENTITAS PENERIMA PENGHASILAN YANG DIPOTONG
$npwp_pegawai_12_digit=substr(npwp(ambil_database(npwp_pegawai,aplikasipph_gaji,"id='$id'")),0,12);//8
$npwp_pegawai_3_digit_13=substr(npwp(ambil_database(npwp_pegawai,aplikasipph_gaji,"id='$id'")),13,3);//9
$npwp_pegawai_3_digit_17=substr(npwp(ambil_database(npwp_pegawai,aplikasipph_gaji,"id='$id'")),17,3);//10
$nik=ambil_database(nik,aplikasipph_gaji,"id='$id'");//10
$nama=ambil_database(nama_pegawai,aplikasipph_gaji,"id='$id'");//10
$alamat=ambil_database(alamat_pegawai,aplikasipph_gaji,"id='$id'");//10
$jenis_kelamin_penentu=ambil_database(jenis_kelamin,aplikasipph_gaji,"id='$id'");if($jenis_kelamin_penentu=='LAKI-LAKI'){$laki='X';$perempuan='';}else{$laki='';$perempuan='X';}
$status_ptkp_penentu=ambil_database(status_ptkp,aplikasipph_gaji,"id='$id'");
		if ($status_ptkp_penentu=='TK/0') {$k='-';$tk='0';$hb='-';}
		if ($status_ptkp_penentu=='TK/1') {$k='-';$tk='1';$hb='-';}
		if ($status_ptkp_penentu=='TK/2') {$k='-';$tk='2';$hb='-';}
		if ($status_ptkp_penentu=='TK/3') {$k='-';$tk='3';$hb='-';}
		if ($status_ptkp_penentu=='K/0') {$k='0';$tk='-';$hb='-';}
		if ($status_ptkp_penentu=='K/1') {$k='1';$tk='-';$hb='-';}
		if ($status_ptkp_penentu=='K/2') {$k='2';$tk='-';$hb='-';}
		if ($status_ptkp_penentu=='K/3') {$k='3';$tk='-';$hb='-';}
		if ($status_ptkp_penentu=='K/I/0') {$k='-';$tk='-';$hb='0';}
		if ($status_ptkp_penentu=='K/I/1') {$k='-';$tk='-';$hb='1';}
		if ($status_ptkp_penentu=='K/I/2') {$k='-';$tk='-';$hb='2';}
		if ($status_ptkp_penentu=='K/I/3') {$k='-';$tk='-';$hb='3';}
$jabatan=ambil_database(jabatan,aplikasipph_gaji,"id='$id'");//10
$karyawan_asing_penentu=ambil_database(karyawan_asing,aplikasipph_gaji,"id='$id'");if($karyawan_asing_penentu=='Y'){$karyawan_asing='X';}else{$karyawan_asing='';}
$kode_negara=ambil_database(kode_negara,aplikasipph_gaji,"id='$id'");//10

$document = str_replace("[11]", "$npwp_pegawai_12_digit", $document);
$document = str_replace("[12]", "$npwp_pegawai_3_digit_13", $document);
$document = str_replace("[13]", "$npwp_pegawai_3_digit_17", $document);
$document = str_replace("[14]", "$nik", $document);
$document = str_replace("[15]", "$nama", $document);
$document = str_replace("[16]", "$alamat", $document);
$document = str_replace("[17a]", "$laki", $document);
$document = str_replace("[17b]", "$perempuan", $document);
$document = str_replace("[18a]", "$k", $document);
$document = str_replace("[18b]", "$tk", $document);
$document = str_replace("[18c]", "$hb", $document);
$document = str_replace("[19]", "$jabatan", $document);
$document = str_replace("[20]", "$karyawan_asing", $document);
$document = str_replace("[21]", "$kode_negara", $document);
//A. IDENTITAS PENERIMA PENGHASILAN YANG DIPOTONG END



//B. RINCIAN PENGHASILAN DAN PENGHITUNGAN PPH PASAL 21
$status_pegawai_penentu=ambil_database(status_pegawai,aplikasipph_gaji,"id='$id'");if($status_pegawai_penentu=='TETAP'){$status_pegawai='X';}else{$status_pegawai='';}
$pensiunan_atau_jht=ambil_database(pensiunan_atau_jht,aplikasipph_gaji,"id='$id'");//10
$tunjangan_pph=ambil_database(tunjangan_pph,aplikasipph_gaji,"id='$id'");//10
$tunjangan_lainnya=ambil_database(tunjangan_lainnya,aplikasipph_gaji,"id='$id'");//10
$honarium=ambil_database(honarium,aplikasipph_gaji,"id='$id'");//10
$premi_asuransi=ambil_database(premi_asuransi,aplikasipph_gaji,"id='$id'");//10
$natura_obyek_pph21=ambil_database(natura_pph21,aplikasipph_gaji,"id='$id'");//10
$bonus_thr=ambil_database(bonus_thr,aplikasipph_gaji,"id='$id'");//10
$penghasilan_bruto=ambil_database(penghasilan_bruto,aplikasipph_gaji,"id='$id'");//10

$biaya_jabatan1=ambil_database(biaya_jabatan1,aplikasipph_gaji,"id='$id'");//10
$iuran_pensiun=ambil_database(iuran_pensiun,aplikasipph_gaji,"id='$id'");//10
$jumlah_pengurang=ambil_database(jumlah_pengurang,aplikasipph_gaji,"id='$id'");//10

$penghasilan_netto=ambil_database(penghasilan_netto,aplikasipph_gaji,"id='$id'");//10
$penghasilan_netto_sebelumnya=ambil_database(penghasilan_netto_sebelumnya,aplikasipph_gaji,"id='$id'");//10
$penghasilan_netto_setahun=ambil_database(penghasilan_netto_setahun,aplikasipph_gaji,"id='$id'");//10
$ptkp=ambil_database(ptkp,aplikasipph_gaji,"id='$id'");//10
$penghasilan_kena_pajak=ambil_database(penghasilan_kena_pajak,aplikasipph_gaji,"id='$id'");//10
$pph_terutang=ambil_database(pph_terutang,aplikasipph_gaji,"id='$id'");//10
$pph21_telah_dipotong=ambil_database(pph21_telah_dipotong,aplikasipph_gaji,"id='$id'");//10
$pph_sebelumnya=ambil_database(pph_sebelumnya,aplikasipph_gaji,"id='$id'");//10

$document = str_replace("[22]", "$status_pegawai", $document);
$document = str_replace("[23]", rupiah_tanpa_rp($pensiunan_atau_jht), $document);
$document = str_replace("[24]", rupiah_tanpa_rp($tunjangan_pph), $document);
$document = str_replace("[25]", rupiah_tanpa_rp($tunjangan_lainnya), $document);
$document = str_replace("[26]", rupiah_tanpa_rp($honarium), $document);
$document = str_replace("[27]", rupiah_tanpa_rp($premi_asuransi), $document);
$document = str_replace("[28]", rupiah_tanpa_rp($natura_obyek_pph21), $document);
$document = str_replace("[29]", rupiah_tanpa_rp($bonus_thr), $document);
$document = str_replace("[30]", rupiah_tanpa_rp($penghasilan_bruto), $document);
$document = str_replace("[31]", "", $document);
$document = str_replace("[32]", rupiah_tanpa_rp($biaya_jabatan1), $document);
$document = str_replace("[33]", rupiah_tanpa_rp($iuran_pensiun), $document);
$document = str_replace("[34]", rupiah_tanpa_rp($jumlah_pengurang), $document);
$document = str_replace("[35]", "", $document);
$document = str_replace("[36]", rupiah_tanpa_rp($penghasilan_netto), $document);
$document = str_replace("[37]", rupiah_tanpa_rp($penghasilan_netto_sebelumnya), $document);
$document = str_replace("[38]", rupiah_tanpa_rp($penghasilan_netto_setahun), $document);
$document = str_replace("[39]", rupiah_tanpa_rp($ptkp), $document);
$document = str_replace("[40]", rupiah_tanpa_rp($penghasilan_kena_pajak), $document);
$document = str_replace("[41]", rupiah_tanpa_rp($pph_terutang), $document);
$document = str_replace("[42]", rupiah_tanpa_rp($pph_sebelumnya), $document);
$document = str_replace("[43]", rupiah_tanpa_rp($pph_terutang), $document);
$document = str_replace("[44]", rupiah_tanpa_rp($pph21_telah_dipotong), $document);
//B. RINCIAN PENGHASILAN DAN PENGHITUNGAN PPH PASAL 21 END



//C. IDENTITAS PEMOTONG
$npwp_pimpinan_12_digit=substr(npwp(ambil_database(nip_pimpinan,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'")),0,12);//8
$npwp_pimpinan_3_digit_13=substr(npwp(ambil_database(nip_pimpinan,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'")),13,3);//9
$npwp_pimpinan_3_digit_17=substr(npwp(ambil_database(nip_pimpinan,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'")),17,3);//10
$nama_pimpinan=ambil_database(nama_pimpinan,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'");//10
$tgl_bukti=substr(ambil_database(tanggal_bukti,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'"),8,2);//8
$bln_bukti=substr(ambil_database(tanggal_bukti,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'"),5,2);//8
$thn_bukti=substr(ambil_database(tanggal_bukti,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'"),0,4);//8

$document = str_replace("[c1]", "$npwp_pimpinan_12_digit", $document);
$document = str_replace("[c2]", "$npwp_pimpinan_3_digit_13", $document);
$document = str_replace("[c3]", "$npwp_pimpinan_3_digit_17", $document);
$document = str_replace("[c4]", "$nama_pimpinan", $document);
$document = str_replace("[c5]", "$tgl_bukti", $document);
$document = str_replace("[c6]", "$bln_bukti", $document);
$document = str_replace("[c7]", "$thn_bukti", $document);
//C. IDENTITAS PEMOTONG END



$fr = fopen("../../aplikasipph/cetak/hasil_cetak/1721_A1_$hasil_nol$urut-$nama.rtf", "w") ;
fwrite($fr, $document);
fclose($fr);
echo "<script type='text/javascript'>window.open('../../aplikasipph/cetak/hasil_cetak/1721_A1_$hasil_nol$urut-$nama.rtf')</script>";
// WORD START END


//CLOSE TAB
echo "<script>
  setTimeout(window.close(), '5000');
</script>";
//CLOSE TAB END

//PRINT PER PAGE 1
// echo "
// <html>
// <head>
// <title>1721-A2</title>
// <body bgcolor='#ffffff'>
// <center>";
// //PRINT PER PAGE 1 END
//
// //PRINT PER PAGE 2 --------------------------------------------- START
// //echo "<div style='page-break-after:always;'></div>";
// //PRINT PER PAGE 2 --------------------------------------------- END
//
// //PRINT PER PAGE 3
// echo "
// </center>
// </body>
// </html>";
//PRINT PER PAGE 3

//PERINTAH PRINT
// echo "<script>";
// echo "
// var css = '@page { size: portrait; }',
// head = document.head || document.getElementsByTagName('head')[0],
// style = document.createElement('style');
// style.type = 'text/css';
// style.media = 'print';
// if (style.styleSheet){
//   style.styleSheet.cssText = css;
// } else {
//   style.appendChild(document.createTextNode(css));
// }
// head.appendChild(style);
// window.print();
// </script>";
//PERINTAH PRINT END
 // END AREA PRINT ?>
