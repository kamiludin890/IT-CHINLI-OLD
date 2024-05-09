<?php //KONEKSI DATABASE

require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setCellValue("A1", "QTY");
$objPHPExcel->getActiveSheet()->setCellValue("B1", "ITEM NAME");
$objPHPExcel->getActiveSheet()->setCellValue("C1", "BUCKET");
$objPHPExcel->getActiveSheet()->setCellValue("D1", "MATERIAL CODE CUSTOMER");
$objPHPExcel->getActiveSheet()->setCellValue("E1", "MATERIAL CODE CHINLI");
$objPHPExcel->getActiveSheet()->setCellValue("F1", "PO NO");
$objPHPExcel->getActiveSheet()->setCellValue("G1", "SURAT JALAN");
$objPHPExcel->getActiveSheet()->setCellValue("H1", "JENIS MATA UANG (USD/RP)");
$objPHPExcel->getActiveSheet()->setCellValue("I1", "PRICE");
$objPHPExcel->getActiveSheet()->setCellValue("J1", "NO INVOICE");

$objPHPExcel->getActiveSheet()->setCellValue("A2", "10");
$objPHPExcel->getActiveSheet()->setCellValue("B2", "nama barang");
$objPHPExcel->getActiveSheet()->setCellValue("C2", "bucket");
$objPHPExcel->getActiveSheet()->setCellValue("D2", "kode customer");
$objPHPExcel->getActiveSheet()->setCellValue("E2", "kode chinli");
$objPHPExcel->getActiveSheet()->setCellValue("F2", "nomor po");
$objPHPExcel->getActiveSheet()->setCellValue("G2", "nomor surat jalan");
$objPHPExcel->getActiveSheet()->setCellValue("H2", "USD");
$objPHPExcel->getActiveSheet()->setCellValue("I2", "3.120");
$objPHPExcel->getActiveSheet()->setCellValue("J2", "CPTI-2021-00079");

$objPHPExcel->getActiveSheet()->setCellValue("A3", "20");
$objPHPExcel->getActiveSheet()->setCellValue("B3", "nama barang");
$objPHPExcel->getActiveSheet()->setCellValue("C3", "bucket");
$objPHPExcel->getActiveSheet()->setCellValue("D3", "kode customer");
$objPHPExcel->getActiveSheet()->setCellValue("E3", "kode chinli");
$objPHPExcel->getActiveSheet()->setCellValue("F3", "nomor po");
$objPHPExcel->getActiveSheet()->setCellValue("G3", "nomor surat jalan");
$objPHPExcel->getActiveSheet()->setCellValue("H3", "RP");
$objPHPExcel->getActiveSheet()->setCellValue("I3", "10600.000");
$objPHPExcel->getActiveSheet()->setCellValue("J3", "CPTI-2021-00079");

$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=contoh.xls");
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
