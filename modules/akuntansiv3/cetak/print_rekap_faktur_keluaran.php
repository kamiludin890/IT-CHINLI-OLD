<?php
//KONEKSI DATABASE
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

function faktur($nilai){
	if ($nilai=='' OR $nilai=='0') {
	// $nilai1="00.000.000.0-000.000";
	$nilai1="000.000.00.00000000";
	}else{
	$NPWP2=substr($nilai,0,3);
	$NPWP3=substr($nilai,3,3);
	$NPWP4=substr($nilai,6,2);
	$NPWP5=substr($nilai,8,8);
	$nilai1="$NPWP2.$NPWP3.$NPWP4.$NPWP5";
	}
return $nilai1;}

function npwp($nilai){
	if ($nilai=='' OR $nilai=='0') {
	$nilai1="00.000.000.0-000.000";
	// $nilai1="000.000.00.00000000";
	}else{
	$NPWP2=substr($nilai,0,2);
	$NPWP3=substr($nilai,2,3);
	$NPWP4=substr($nilai,5,3);
	$NPWP5=substr($nilai,8,1);
	$NPWP6=substr($nilai,9,3);
	$NPWP7=substr($nilai,12,3);
	$nilai1="$NPWP2.$NPWP3.$NPWP4.$NPWP5-$NPWP6.$NPWP7";
	}
return $nilai1;}
//START FUNCTION END


$akhir_periode1=$_GET['akhir_periode1'];
$akhir_periode2=$_GET['akhir_periode2'];


//PECAH
$column_items='Tgl,Pembeli,No. FP,PPN,Ket,CL,SL,CLS';
$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai,aj,ak,al,am,an,ao,ap,aq,ar,as,at,au,av,aw,ax,ay,az,ba,bb,bc,bd,be,bf,bg,bh,bi,bj,bk,bl,bm,bn,bo,bp,bq,br,bs,bt,bu,bv,bw,bx,by,bz';
$nilai_column=nilai_pecah($column_items);

$jumlah_column=pecah($column_items);
$jumlah_column_alpabet=pecah($alpabet);
//PECAH END


require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();


//HEADER
$objPHPExcel->getActiveSheet()->setCellValue("B1", "Rekap Faktur Pajak Keluaran");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B1:J1");

$objPHPExcel->getActiveSheet()->setCellValue("B2", "Periode $akhir_periode1 s/d $akhir_periode2");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B2:J2");

$objPHPExcel->getActiveSheet()->getStyle("B1:J2")->getFont()->setBold( true );
//HEADER END

//TABEL
$objPHPExcel->getActiveSheet()->setCellValue("B4", "Kode");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B4:B5");
					$objPHPExcel->getActiveSheet()->setCellValue("C4", "Tgl");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells("C4:C5");
$objPHPExcel->getActiveSheet()->setCellValue("D4", "Pembeli");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("D4:D5");
					$objPHPExcel->getActiveSheet()->setCellValue("E4", "No. NPWP");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells("E4:E5");
$objPHPExcel->getActiveSheet()->setCellValue("F4", "No. FP");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("F4:F5");
					$objPHPExcel->getActiveSheet()->setCellValue("G4", "No. Invoice");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells("G4:G5");
$objPHPExcel->getActiveSheet()->setCellValue("H4", "Amount RP");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("H4:I4");
					$objPHPExcel->getActiveSheet()->setCellValue("H5", "DPP");
					$objPHPExcel->getActiveSheet()->setCellValue("I5", "PPN");
$objPHPExcel->getActiveSheet()->setCellValue("J4", "Ket");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J4:J5");

$objPHPExcel->getActiveSheet()->setCellValue("L4", "TIDAK DIPUNGUT");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("L4:M4");
					$objPHPExcel->getActiveSheet()->setCellValue("L5", "DPP");
					$objPHPExcel->getActiveSheet()->setCellValue("M5", "PPN");

$objPHPExcel->getActiveSheet()->setCellValue("N4", "DIPUNGUT");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("N4:O4");
					$objPHPExcel->getActiveSheet()->setCellValue("N5", "DPP");
					$objPHPExcel->getActiveSheet()->setCellValue("O5", "PPN");
$objPHPExcel->getActiveSheet()->setCellValue("Q4", "NOMOR AJU");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("Q4:Q5");
					$objPHPExcel->getActiveSheet()->setCellValue("R4", "NOMOR DAFTAR");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells("R4:R5");
$objPHPExcel->getActiveSheet()->setCellValue("S4", "KURS");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("S4:S5");
					$objPHPExcel->getActiveSheet()->setCellValue("T4", "DPP USD");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells("T4:T5");
$objPHPExcel->getActiveSheet()->setCellValue("U4", "PPN USD");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("U4:U5");
					$objPHPExcel->getActiveSheet()->setCellValue("V4", "CIF DOC");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells("V4:V5");
$objPHPExcel->getActiveSheet()->setCellValue("W4", "Harga Penyerahan DOC");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("W4:W5");
					$objPHPExcel->getActiveSheet()->setCellValue("X4", "Kurs");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells("X4:X5");
$objPHPExcel->getActiveSheet()->setCellValue("Y4", "Selisih");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("Y4:Y5");


$objPHPExcel->getActiveSheet()->getStyle("B4:Y5")->getFont()->setBold( true );
//TABEL END


$result=mysql_query("SELECT * FROM akuntansiv3_faktur_keluaran WHERE tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2' AND no_faktur !='00000000%' AND no_faktur !='' ORDER BY tanggal ASC");
$start_tabel=6;
while ($rows=mysql_fetch_array($result)) {

	$objPHPExcel->getActiveSheet()->setCellValue("B$start_tabel", "-");
	$objPHPExcel->getActiveSheet()->setCellValue("C$start_tabel", "$rows[tanggal]");
	$objPHPExcel->getActiveSheet()->setCellValue("D$start_tabel", "$rows[pembeli]");
	$objPHPExcel->getActiveSheet()->setCellValue("E$start_tabel", npwp($rows[no_npwp]));
	$objPHPExcel->getActiveSheet()->setCellValue("F$start_tabel", faktur($rows[no_faktur]));
	$objPHPExcel->getActiveSheet()->setCellValue("G$start_tabel", "$rows[no_invoice_masukkan]");
	$objPHPExcel->getActiveSheet()->setCellValue("H$start_tabel", "$rows[amount_rp]");
	$objPHPExcel->getActiveSheet()->setCellValue("I$start_tabel", "$rows[ppn]");
	$objPHPExcel->getActiveSheet()->setCellValue("J$start_tabel", "$rows[departement]");


	if (substr($rows[no_faktur],0,3)=='070' OR substr($rows[no_faktur],0,3)=='080') {
		$objPHPExcel->getActiveSheet()->setCellValue("L$start_tabel", "$rows[amount_rp]");
		$objPHPExcel->getActiveSheet()->setCellValue("M$start_tabel", "$rows[ppn]");
	}elseif (substr($rows[no_faktur],0,3)=='010' OR substr($rows[no_faktur],0,3)=='040' OR substr($rows[no_faktur],0,3)=='050') {
		$objPHPExcel->getActiveSheet()->setCellValue("N$start_tabel", "$rows[amount_rp]");
		$objPHPExcel->getActiveSheet()->setCellValue("O$start_tabel", "$rows[ppn]");
	}else {}


	$objPHPExcel->getActiveSheet()->setCellValue("Q$start_tabel", "$rows[no_aju]");
	$objPHPExcel->getActiveSheet()->setCellValue("R$start_tabel", "$rows[no_pendaftaran]");
	$objPHPExcel->getActiveSheet()->setCellValue("S$start_tabel", "$rows[kurs]");
	$objPHPExcel->getActiveSheet()->setCellValue("T$start_tabel", "$rows[dpp_usd]");
	$objPHPExcel->getActiveSheet()->setCellValue("U$start_tabel", "$rows[ppn_usd]");
	$objPHPExcel->getActiveSheet()->setCellValue("V$start_tabel", "$rows[cif_dokumen]");
	$objPHPExcel->getActiveSheet()->setCellValue("W$start_tabel", "$rows[harga_penyerahan_dokumen]");
	$objPHPExcel->getActiveSheet()->setCellValue("X$start_tabel", "$rows[kurs_dokumen]");
	$objPHPExcel->getActiveSheet()->setCellValue("Y$start_tabel", "$rows[status_selisih]");




$start_tabel++;}



//STYLE
/**autosize*/
for ($col = 'C'; $col != 'Y'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}
/**autosize*/

//CENTER
$center = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '2F4F4F')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($center);
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($center);
$objPHPExcel->getActiveSheet()->getStyle("B4:Y5")->applyFromArray($center);
//CENTER END

//BORDER
$border = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
)));
$objPHPExcel->getActiveSheet()->getStyle("B4:J5")->applyFromArray($border);
$objPHPExcel->getActiveSheet()->getStyle("L4:O5")->applyFromArray($border);

$objPHPExcel->getActiveSheet()->getStyle("B6:J$start_tabel")->applyFromArray($border);
$objPHPExcel->getActiveSheet()->getStyle("L6:O$start_tabel")->applyFromArray($border);
$objPHPExcel->getActiveSheet()->getStyle("Q4:Y$start_tabel")->applyFromArray($border);
unset($styleArray);
//BORDER END
//STYLE END


$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=PPN KELUARAN $akhir_periode1 sd $akhir_periode2.xls");
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
