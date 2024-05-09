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
if ($address=='?mod=aplikasipph/rumus') {
	$column_items='id,urut,nama_pegawai,status_ptkp,keterangan_evaluasi,gaji1,gaji2,gaji3,gaji4,gaji5,gaji6,gaji7,gaji8,gaji9,gaji10,gaji11,gaji12,pensiunan_atau_jht,tunjangan_pph,tunjangan_lainnya,honarium,premi1,premi2,premi3,premi4,premi5,premi6,premi7,premi8,premi9,premi10,premi11,premi12,premi_asuransi,natura_pph21,penghasilan_bruto_teratur,bonus_thr,jumlah_penghasilan_teratur_tidakteratur,iuran1,iuran2,iuran3,iuran4,iuran5,iuran6,iuran7,iuran8,iuran9,iuran10,iuran11,iuran12,iuran_pensiun,pph21_telah_dipotong,pph_ditanggung_pemerintah,penghasilan_bruto,biaya_jabatan1,biaya_jabatan2,jumlah_pengurang,penghasilan_netto,penghasilan_netto_sebelumnya,penghasilan_netto_setahun,ptkp,penghasilan_kena_pajak,pph_terutang,pph_sebelumnya,dari_bulan,sampai_bulan';
}elseif($address=='?mod=aplikasipph/Gaji') {
	$column_items='id,tanggal,urut,nama_pegawai,status_pegawai,jenis_kelamin,status_ptkp,bulan_mulai_menerima_penghasilan,keterangan_evaluasi,bulan_terakhir_menerima_penghasilan,lama_bekerja,jabatan,npwp_pegawai,alamat_pegawai,karyawan_asing,negara,kode_negara,nik';
}else {}


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

$sql4 = mysql_query("SELECT	* FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian ORDER BY nama_pegawai DESC")or die(mysql_error);
//$sql4=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
$jumlah_data=mysql_num_rows($sql4)+1;
$start_kolom=2;
$merge_kolom=1;
$nomor=1;
while ($rows4=mysql_fetch_array($sql4)) {

$no=0;for($i=0; $i < $nilai_column; ++$i){
  if ($jumlah_column[$no]=='no') {
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$nomor");
  }else{
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[$jumlah_column[$no]]."");
  }
$no++;}


$start_kolom++;$nomor++;$merge_kolom++;}
//ISI TABEL END


/**autosize*/
for ($col = 'A'; $col != 'BZ'; $col++) {
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

//PERINTAH BOLD
if ($address=='?mod=aplikasipph/rumus') {
$objPHPExcel->getActiveSheet()->getStyle("A1:A1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("C1:E1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("R1:R1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("AH1:AH1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("AJ1:AJ1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("AL1:AL1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("AY1:AY1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("BB1:BF1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle("BH1:BK1")->getFont()->setBold( true )->getColor()->setRGB('FF0000');
//PERINTAH BOLD END

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
$color_cell='7CFC00';
cellColor("A2:A$jumlah_data", "$color_cell");
cellColor("C2:E$jumlah_data", "$color_cell");
cellColor("R2:R$jumlah_data", "$color_cell");
cellColor("AH2:AH$jumlah_data", "$color_cell");
cellColor("AJ2:AJ$jumlah_data", "$color_cell");
cellColor("AL2:AL$jumlah_data", "$color_cell");
cellColor("AY2:AY$jumlah_data", "$color_cell");
cellColor("BB2:BF$jumlah_data", "$color_cell");
cellColor("BH2:BK$jumlah_data", "$color_cell");
cellColor("BM2:BN$jumlah_data", "$color_cell");
//PERINTAH COLOR CELL END
}




$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=formulis_spt.xls");
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
