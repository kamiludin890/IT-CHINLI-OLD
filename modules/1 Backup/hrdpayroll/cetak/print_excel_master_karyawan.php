<?php //KONEKSI DATABASE
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
//KONEKSI DATABASE


//START FUNCTION
function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function npwp($nilai){
	$NPWP2=substr($nilai,0,2);
	$NPWP3=substr($nilai,2,3);
	$NPWP4=substr($nilai,5,3);
	$NPWP5=substr($nilai,8,1);
	$NPWP6=substr($nilai,9,3);
	$NPWP7=substr($nilai,12,3);
	$nilai1="$NPWP2.$NPWP3.$NPWP4.$NPWP5-$NPWP6.$NPWP7";
	return $nilai1;}

	function datediff($tgl1, $tgl2){
	$tgl1 = strtotime($tgl1);
	$tgl2 = strtotime($tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
	}

function selisih($tanggal){
		$tgl1=$tanggal;
		$tgl2=date("Y-m-d");
	$a = datediff($tgl1, $tgl2);
	//echo 'tanggal 1 = '.$tgl1; echo '<br>';
	//echo 'tanggal 2 = '.$tgl2; echo '<br>';
	$Selisih=$a[years].' tahun '.$a[months].' bulan '.$a[days].' hari';//.$a[hours].' jam '.$a[minutes].' menit '.$a[seconds].' detik';
//return "$nomor_id,$awal_masuk,$mulai_kontrak,$selesai_kontrak,$jenis";
return $Selisih;}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'',',');
return $hasil_rupiah;}

function tampil_sp($id){
	$tanggal_sekarang=date('Y-m-d');
	$result=mysql_query("SELECT * FROM hrd_data_sp WHERE id_pegawai='$id' AND tanggal_berlaku_sp >= '$tanggal_sekarang'");
	while ($rows=mysql_fetch_array($result)) {

		if ($rows[sp]) {
			$show="SP $rows[sp] End $rows[tanggal_berakhir_sp]";
		}else{
			$show='';
		}

$datasecs[]=$show;
	}
$data=implode(', ', (array)$datasecs);

return $data;}
//START FUNCTION END


//AMBIL VARIABEL KIRIM
$id=$_POST['id'];
$bahasa=$_POST['bahasa'];

$nama_database=$_POST['nama_database1'];
$pilihan_tahun=$_POST['pilihan_tahun1'];
$pilihan_bulan=$_POST['pilihan_bulan1'];
$pencarian=$_POST['pencarian1'];
$pilihan_pencarian=$_POST['pilihan_pencarian1'];
$address=$_POST['address1'];
//AMBIL VARIABEL KIRIM END


//PECAH
	$column_items='no,nik,status_pegawai,nama,tanggal_masuk,bagian,ktp,npwp,tempat_lahir,tanggal_lahir,umur,jenis_kelamin,status_perkawinan,no_rekening,jumlah_anak,agama,alamat_ktp,alamat_domisili,pendidikan_terakhir,jurusan,tahun_lulus,nomor_hp,nomor_hp_keluarga,nomor_kartu_jamsostek,nomor_kartu_dana_pensiun,no_kartu_bpjs,kode_jabatan,upah_pokok,upah_tunjangan,upah_total,status_karyawan,masa_kerja,kontrak_awal1,kontrak_awal2,lama_kontrak1,kontrak_akhir1,kontrak_akhir2,lama_kontrak2,sp,cuti,cuti_yang_diambil,sisa_cuti,referensi,nilai_mtk,status_vaksin,status_vaksin2,bersedia_keluar_kota,id_card,keterangan_mutasi,surat_pernyataan,status_update';



$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai,aj,ak,al,am,an,ao,ap,aq,ar,as,at,au,av,aw,ax,ay,az,ba,bb,bc,bd,be,bf,bg,bh,bi,bj,bk,bl,bm,bn,bo,bp,bq,br,bs,bt,bu,bv,bw,bx,by,bz';
$nilai_column=nilai_pecah($column_items);

$jumlah_column=pecah($column_items);
$jumlah_column_alpabet=pecah($alpabet);
//PECAH END


//if ($id!='') {//PENENTU PRINT ATAU TIDAK
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// //GAMBAR CHINLI
// $objDrawing = new PHPExcel_Worksheet_Drawing();
// $objDrawing->setName('test_img');
// $objDrawing->setDescription('../../gambar/logo_lengkap.png');
// $objDrawing->setPath('../../gambar/logo_lengkap.png');
// $objDrawing->setCoordinates('C1');
// //setOffsetX works properly
// $objDrawing->setOffsetX(5);
// $objDrawing->setOffsetY(5);
// //set width, height
// $objDrawing->setWidth(50);
// $objDrawing->setHeight(90);
// $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// //GAMBAR CHINLI END


// //HEADER
// $objPHPExcel->getActiveSheet()->setCellValue("B10", "".ambil_database($bahasa,pusat_bahasa,"kode='kepada'").":");//Pemasok
// $objPHPExcel->getActiveSheet()->setCellValue("C10", "".ambil_database(kepada,$nama_database,"id='$id'")."");//Nama Pemasok
//
// $objPHPExcel->getActiveSheet()->setCellValue("G6", "".ambil_database($bahasa,pusat_bahasa,"kode='tanggal'").":");//Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("H6", "".ambil_database(tanggal,$nama_database,"id='$id'")."");//Nama Tanggal
//
// $objPHPExcel->getActiveSheet()->setCellValue("G7", "".ambil_database($bahasa,pusat_bahasa,"kode='po_purchasing'").":");//Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("H7", "".ambil_database(po_purchasing,$nama_database,"id='$id'")."");//Nama Tanggal
//
// $objPHPExcel->getActiveSheet()->setCellValue("G8", "".ambil_database($bahasa,pusat_bahasa,"kode='paymen_term'").":");//Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("H8", "".ambil_database(paymen_term,$nama_database,"id='$id'")."");//Nama Tanggal
//
// $objPHPExcel->getActiveSheet()->setCellValue("G9", "".ambil_database($bahasa,pusat_bahasa,"kode='attn'").":");//Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("H9", "".ambil_database(attn,$nama_database,"id='$id'")."");//Nama Tanggal
//
// $objPHPExcel->getActiveSheet()->setCellValue("G10", "".ambil_database($bahasa,pusat_bahasa,"kode='note'").":");//Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("H10", "".ambil_database(note,$nama_database,"id='$id'")."");//Nama Tanggal
// //HEADER END


//HEADER TABEL
$no=0;for($i=0; $i < $nilai_column; ++$i){
  $name=ambil_database($bahasa,pusat_bahasa,"kode='".$jumlah_column[$no]."'");
  $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]1", "$name");
$no++;}
//HEADER TABEL END

//ISI TABEL
if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
if ($pilihan_tahun=='All'){$pilihan_tahun2='20'; $pilihan_bulan2='';}else{$pilihan_tahun2=$pilihan_tahun; $pilihan_bulan2="-$pilihan_bulan";}
if ($nama_database=='hrd_data_masakerja') {$tanggal_pencarian='tanggal';}else{$tanggal_pencarian='tanggal';}

$sql4 = mysql_query("SELECT	* FROM $nama_database WHERE $tanggal_pencarian LIKE '%$pilihan_tahun2$pilihan_bulan2%' $if_pencarian")or die(mysql_error);
//$sql4=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
$jumlah_data=mysql_num_rows($sql4)+1;
$start_kolom=2;
$merge_kolom=1;
$nomor=1;
while ($rows4=mysql_fetch_array($sql4)) {

$no=0;for($i=0; $i < $nilai_column; ++$i){
	//NO
  if ($jumlah_column[$no]=='no') {
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$nomor");
  }
	//NPWP
	elseif ($jumlah_column[$no]=='npwp') {
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", npwp($rows4[$jumlah_column[$no]]));
	}
	//UMUR
  elseif ($jumlah_column[$no]=='umur') {
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", selisih($rows4[tanggal_lahir]));
  }
	//TOTAL UPAH
	elseif ($jumlah_column[$no]=='upah_total') {
		$total_upah=$rows4[upah_pokok]+$rows4[upah_tunjangan];
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", $total_upah);
	}
	//MASA KERJA
	elseif ($jumlah_column[$no]=='masa_kerja') {
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", selisih($rows4[tanggal_masuk]));
	}
	//LAMA KONTRAK 1
	elseif ($jumlah_column[$no]=='lama_kontrak1') {
		if ($rows4[$jumlah_column[$no]]!='') {$tampil_bulan='Bulan';}else{$tampil_bulan='';}
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[$jumlah_column[$no]]." $tampil_bulan");
	}
	//LAMA KONTRAK 2
	elseif ($jumlah_column[$no]=='lama_kontrak2') {
		if ($rows4[$jumlah_column[$no]]!='') {$tampil_bulan='Bulan';}else{$tampil_bulan='';}
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[$jumlah_column[$no]]." $tampil_bulan");
	}
	//SP
	elseif ($jumlah_column[$no]=='sp') {
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", tampil_sp($rows4[id]));
	}
	//cuti yang di ambil
	elseif ($jumlah_column[$no]=='cuti_yang_diambil') {
		//TOTAL KONTRAK 1 & TOTAL KONTRAK 2
		$result_cuti=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows4[id]' AND tanggal BETWEEN '$rows4[kontrak_awal1]' AND '$rows4[kontrak_awal2]'");
		$total_cuti=mysql_num_rows($result_cuti);

		$result_cuti2=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows4[id]' AND tanggal BETWEEN '$rows4[kontrak_akhir1]' AND '$rows4[kontrak_akhir2]'");
		$total_cuti2=mysql_num_rows($result_cuti2);

		$total=$total_cuti+$total_cuti2;
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$total");
	}
	//sisa cuti
	elseif ($jumlah_column[$no]=='sisa_cuti') {
		//TOTAL KONTRAK 1 & TOTAL KONTRAK 2
		$result_cuti=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows4[id]' AND tanggal BETWEEN '$rows4[kontrak_awal1]' AND '$rows4[kontrak_awal2]'");
		$total_cuti=mysql_num_rows($result_cuti);

		$result_cuti2=mysql_query("SELECT * FROM hrd_data_absensi WHERE id_pegawai='$rows4[id]' AND tanggal BETWEEN '$rows4[kontrak_akhir1]' AND '$rows4[kontrak_akhir2]'");
		$total_cuti2=mysql_num_rows($result_cuti2);

		$total=$total_cuti+$total_cuti2;

		$sisa_cuti=$rows4[cuti]-$total;

		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$sisa_cuti");
	}
	//TAMPILAN NORMAL
	else{
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[$jumlah_column[$no]]."");
  }
$no++;}


$start_kolom++;$nomor++;$merge_kolom++;}
//ISI TABEL END


/**autosize*/
for ($col = 'A'; $col != 'AY'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}/**autosize*/

//PERINTAH BORDER
// $styleArray = array(
//   'borders' => array(
//     'allborders' => array(
//       'style' => PHPExcel_Style_Border::BORDER_THIN
// )));
// $objPHPExcel->getActiveSheet()->getStyle("A1:T$jumlah_data")->applyFromArray($styleArray);
// unset($styleArray);
//PERINTAH BORDER END

//PERINTAH MERGER
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C10:E10');
//PERINTAH MERGER END

// //PERINTAH BOLD
// if ($address=='?mod=aplikasipph/rumus') {
// $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("C1:E1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("R1:R1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("AH1:AH1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("AJ1:AJ1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("AL1:AL1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("AY1:AY1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("BB1:BF1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// $objPHPExcel->getActiveSheet()->getStyle("BH1:BK1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
// //PERINTAH BOLD END
// }

//PERINTAH COLOR CELL
function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

//WARNA KOLOM YANG TIDAK TERPAKAI UNTUK IMPORT
	cellColor("K1:K1", "FFFF00");
	cellColor("AD1:AD1", "FFFF00");
	cellColor("AF1:AM1", "FFFF00");
	cellColor("AO1:AP1", "FFFF00");
	cellColor("AY1:AY1", "FFFF00");
//WARNA KOLOM YANG TIDAK TERPAKAI UNTUK IMPORT END


$sql5 = mysql_query("SELECT	* FROM $nama_database WHERE $tanggal_pencarian LIKE '%$pilihan_tahun2$pilihan_bulan2%' $if_pencarian")or die(mysql_error);
$urutan=2;
while ($rows5=mysql_fetch_array($sql5)) {

//WARNA
$nilai_penentu=substr($rows5[kontrak_awal2],5,2);
$nilai_penentu2=substr($rows5[kontrak_akhir2],5,2);

//JANUARI
if ($nilai_penentu=='01' AND $nilai_penentu2=='') {
	cellColor("AH$urutan:AH$urutan", "0000FF");
}
//FEBRUARI
elseif ($nilai_penentu=='02' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "8A2BE2");
}
//FEBRUARI
elseif ($nilai_penentu=='03' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "A52A2A");
}
//FEBRUARI
elseif ($nilai_penentu=='04' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "DEB887");
}
//FEBRUARI
elseif ($nilai_penentu=='05' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "5F9EA0");
}
//FEBRUARI
elseif ($nilai_penentu=='06' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "7FFF00");
}
//FEBRUARI
elseif ($nilai_penentu=='07' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "D2691E");
}
//FEBRUARI
elseif ($nilai_penentu=='08' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "FFD700");
}
//FEBRUARI
elseif ($nilai_penentu=='09' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "808080");
}
//FEBRUARI
elseif ($nilai_penentu=='10' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "008000");
}
//FEBRUARI
elseif ($nilai_penentu=='11' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "00FA9A");
}
//FEBRUARI
elseif ($nilai_penentu=='12' AND $nilai_penentu2==''){
	cellColor("AH$urutan:AH$urutan", "C71585");
}
//normal
else{}
//WARNA END


//JANUARI
if ($nilai_penentu!='' AND $nilai_penentu2=='01') {
	cellColor("AK$urutan:AK$urutan", "0000FF");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='02'){
	cellColor("AK$urutan:AK$urutan", "8A2BE2");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='03'){
	cellColor("AK$urutan:AK$urutan", "A52A2A");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='04'){
	cellColor("AK$urutan:AK$urutan", "DEB887");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='05'){
	cellColor("AK$urutan:AK$urutan", "5F9EA0");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='06'){
	cellColor("AK$urutan:AK$urutan", "7FFF00");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='07'){
	cellColor("AK$urutan:AK$urutan", "D2691E");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='08'){
	cellColor("AK$urutan:AK$urutan", "FFD700");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='09'){
	cellColor("AK$urutan:AK$urutan", "808080");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='10'){
	cellColor("AK$urutan:AK$urutan", "008000");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='11'){
	cellColor("AK$urutan:AK$urutan", "00FA9A");
}
//FEBRUARI
elseif ($nilai_penentu!='' AND $nilai_penentu2=='12'){
	cellColor("AK$urutan:AK$urutan", "C71585");
}
//normal
else{}
//WARNA END

$urutan++;}
//PERINTAH COLOR CELL END





$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=master_karyawan.xls");
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');

header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
//}//PENENTU PRINT ATAU TIDAK END


?>
