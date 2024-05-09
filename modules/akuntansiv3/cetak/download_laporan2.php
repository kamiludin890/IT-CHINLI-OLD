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
//START FUNCTION END


$akhir_periode1=$_GET['akhir_periode1'];
$akhir_periode2=$_GET['akhir_periode2'];

require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();



//HEADER
$tahun=substr($akhir_periode2,0,4);
$objPHPExcel->getActiveSheet()->setCellValue("B1", "LAPORAN PEMBAYARAN IN - OUT PPN $tahun");
$objPHPExcel->getActiveSheet()->getStyle("B1:M1")->getFont()->setSize(24);//SIZE
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:J1');

$objPHPExcel->getActiveSheet()->setCellValue("B2", "進銷貨營業稅11%明細表 (CHINLI TECHNOLOGY)");
$objPHPExcel->getActiveSheet()->getStyle("B2:M2")->getFont()->setSize(22);//SIZE
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:J2');


$objPHPExcel->getActiveSheet()->setCellValue("B4", "BULAN");
$objPHPExcel->getActiveSheet()->setCellValue("C4", "PPN11%");
$objPHPExcel->getActiveSheet()->setCellValue("D4", "FAKTUR 010 KELUAR");
$objPHPExcel->getActiveSheet()->setCellValue("E4", "FAKTUR 010 MASUK");
$objPHPExcel->getActiveSheet()->setCellValue("F4", "MASUKAN 010 LAIN-LAIN");
$objPHPExcel->getActiveSheet()->setCellValue("G4", "TOTAL");
$objPHPExcel->getActiveSheet()->setCellValue("H4", "LB BULAN SEBELUMNYA");
$objPHPExcel->getActiveSheet()->setCellValue("I4", "TOTAL");
$objPHPExcel->getActiveSheet()->setCellValue("J4", "TOTAL BAYAR");

$objPHPExcel->getActiveSheet()->setCellValue("B5", "月份");
$objPHPExcel->getActiveSheet()->setCellValue("C5", "");
$objPHPExcel->getActiveSheet()->setCellValue("D5", "銷貨 (收入PPN11%)");
$objPHPExcel->getActiveSheet()->setCellValue("E5", "進貨(支付PPN11%)");
$objPHPExcel->getActiveSheet()->setCellValue("F5", "賣進口原料或廢料付稅PPN11%");
$objPHPExcel->getActiveSheet()->setCellValue("G5", "總數");
$objPHPExcel->getActiveSheet()->setCellValue("H5", "上期剩餘抵扣");
$objPHPExcel->getActiveSheet()->setCellValue("I5", "應付PPN 11%");
$objPHPExcel->getActiveSheet()->setCellValue("J5", "應付PPN 11%");

//januari
$baris_januari1='6';
$baris_januari2='7';
$baris_januari3='8';
$baris_januari4='9';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_januari1", "JANUARI");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_januari1:B$baris_januari4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_januari1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_januari2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_januari3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_januari4", "TOTAL");

			$sljanuari1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-01%' AND departement='SL'");
			$cljanuari1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-01%' AND departement='CL'");
			$clsjanuari1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-01%' AND departement='CLS'");
			$total_januari1=$sljanuari1+$cljanuari1+$clsjanuari1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_januari1", "$sljanuari1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_januari2", "$cljanuari1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_januari3", "$clsjanuari1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_januari4", "$total_januari1");

$cl75januari2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25januari2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$sljanuari2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='' AND departement='SL'")+$sl25januari2;
$cljanuari2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='' AND departement='CL'")+$cl75januari2;
$clsjanuari2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='' AND departement='CLS'");
$total_januari2=$sljanuari2+$cljanuari2+$clsjanuari2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_januari1", "$sljanuari2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_januari2", "$cljanuari2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_januari3", "$clsjanuari2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_januari4", "$total_januari2");

			$cl75januari3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25januari3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$sljanuari3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25januari3;
			$cljanuari3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75januari3;
			$clsjanuari3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-01%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_januari3=$sljanuari3+$cljanuari3+$clsjanuari3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_januari1", "$sljanuari3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_januari2", "$cljanuari3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_januari3", "$clsjanuari3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_januari4", "$total_januari3");

$sljanuari4=$sljanuari1-$sljanuari2-$sljanuari3;
$cljanuari4=$cljanuari1-$cljanuari2-$cljanuari3;
$clsjanuari4=$clsjanuari1-$clsjanuari2-$clsjanuari3;
$total_januari4=$sljanuari4+$cljanuari4+$clsjanuari4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_januari1", "$sljanuari4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_januari2", "$cljanuari4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_januari3", "$clsjanuari4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_januari4", "$total_januari4");

$tahunlalu=$tahunlalu-1;

			$sldesemberlalu1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND departement='SL'");
			$cldesemberlalu1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND departement='CL'");
			$clsdesemberlalu1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND departement='CLS'");

			$cl75desemberlalu2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
			$sl25desemberlalu2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;
			$sldesemberlalu2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='' AND departement='SL'")+$sl25desemberlalu2;
			$cldesemberlalu2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='' AND departement='CL'")+$cl75desemberlalu2;
			$clsdesemberlalu2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='' AND departement='CLS'");

			$cl75desemberlalu3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25desemberlalu3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;
			$sldesemberlalu3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25desemberlalu3;
			$cldesemberlalu3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75desemberlalu3;
			$clsdesemberlalu3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal BETWEEN '2022-01-01' AND '$tahunlalu-12-31' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");

			$sldesemberlalu4=$sldesemberlalu1-$sldesemberlalu2-$sldesemberlalu3;
			$cldesemberlalu4=$cldesemberlalu1-$cldesemberlalu2-$cldesemberlalu3;
			$clsdesemberlalu4=$clsdesemberlalu1-$clsdesemberlalu2-$clsdesemberlalu3;
			// $total_desemberlalu4=$sldesemberlalu4+$cldesemberlalu4+$clsdesemberlalu4;

			$sljanuari5=$sldesemberlalu4;
			$cljanuari5=$cldesemberlalu4;
			$clsjanuari5=$clsdesemberlalu4;
			$total_januari5=$sljanuari5+$cljanuari5+$clsjanuari5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_januari1", "$sljanuari5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_januari2", "$cljanuari5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_januari3", "$clsjanuari5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_januari4", "$total_januari5");

$sljanuari6=$sljanuari4+$sljanuari5;
$cljanuari6=$cljanuari4+$cljanuari5;
$clsjanuari6=$clsjanuari4+$clsjanuari5;
$total_januari6=$sljanuari6+$cljanuari6+$clsjanuari6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_januari1", "$sljanuari6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_januari2", "$cljanuari6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_januari3", "$clsjanuari6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_januari4", "$total_januari6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_januari1", "$total_januari6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_januari1:J$baris_januari4");
//januari END

//februari
$baris_februari1='10';
$baris_februari2='11';
$baris_februari3='12';
$baris_februari4='13';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_februari1", "FEBRUARI");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_februari1:B$baris_februari4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_februari1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_februari2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_februari3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_februari4", "TOTAL");

			$slfebruari1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-02%' AND departement='SL'");
			$clfebruari1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-02%' AND departement='CL'");
			$clsfebruari1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-02%' AND departement='CLS'");
			$total_februari1=$slfebruari1+$clfebruari1+$clsfebruari1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_februari1", "$slfebruari1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_februari2", "$clfebruari1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_februari3", "$clsfebruari1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_februari4", "$total_februari1");

$cl75februari2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25februari2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$slfebruari2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='' AND departement='SL'")+$sl25februari2;
$clfebruari2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='' AND departement='CL'")+$cl75februari2;
$clsfebruari2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='' AND departement='CLS'");
$total_februari2=$slfebruari2+$clfebruari2+$clsfebruari2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_februari1", "$slfebruari2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_februari2", "$clfebruari2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_februari3", "$clsfebruari2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_februari4", "$total_februari2");

			$cl75februari3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25februari3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$slfebruari3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25februari3;
			$clfebruari3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75februari3;
			$clsfebruari3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-02%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_februari3=$slfebruari3+$clfebruari3+$clsfebruari3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_februari1", "$slfebruari3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_februari2", "$clfebruari3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_februari3", "$clsfebruari3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_februari4", "$total_februari3");

$slfebruari4=$slfebruari1-$slfebruari2-$slfebruari3;
$clfebruari4=$clfebruari1-$clfebruari2-$clfebruari3;
$clsfebruari4=$clsfebruari1-$clsfebruari2-$clsfebruari3;
$total_februari4=$slfebruari4+$clfebruari4+$clsfebruari4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_februari1", "$slfebruari4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_februari2", "$clfebruari4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_februari3", "$clsfebruari4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_februari4", "$total_februari4");

			$slfebruari5=$sljanuari6;
			$clfebruari5=$cljanuari6;
			$clsfebruari5=$clsjanuari6;
			$total_februari5=$slfebruari5+$clfebruari5+$clsfebruari5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_februari1", "$slfebruari5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_februari2", "$clfebruari5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_februari3", "$clsfebruari5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_februari4", "$total_februari5");

$slfebruari6=$slfebruari4+$slfebruari5;
$clfebruari6=$clfebruari4+$clfebruari5;
$clsfebruari6=$clsfebruari4+$clsfebruari5;
$total_februari6=$slfebruari6+$clfebruari6+$clsfebruari6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_februari1", "$slfebruari6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_februari2", "$clfebruari6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_februari3", "$clsfebruari6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_februari4", "$total_februari6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_februari1", "$total_februari6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_februari1:J$baris_februari4");
//februari END

//maret
$baris_maret1='14';
$baris_maret2='15';
$baris_maret3='16';
$baris_maret4='17';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_maret1", "MARET");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_maret1:B$baris_maret4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_maret1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_maret2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_maret3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_maret4", "TOTAL");

			$slmaret1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-03%' AND departement='SL'");
			$clmaret1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-03%' AND departement='CL'");
			$clsmaret1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-03%' AND departement='CLS'");
			$total_maret1=$slmaret1+$clmaret1+$clsmaret1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_maret1", "$slmaret1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_maret2", "$clmaret1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_maret3", "$clsmaret1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_maret4", "$total_maret1");

$cl75maret2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25maret2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$slmaret2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='' AND departement='SL'")+$sl25maret2;
$clmaret2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='' AND departement='CL'")+$cl75maret2;
$clsmaret2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='' AND departement='CLS'");
$total_maret2=$slmaret2+$clmaret2+$clsmaret2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_maret1", "$slmaret2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_maret2", "$clmaret2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_maret3", "$clsmaret2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_maret4", "$total_maret2");

			$cl75maret3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25maret3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$slmaret3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25maret3;
			$clmaret3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75maret3;
			$clsmaret3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-03%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_maret3=$slmaret3+$clmaret3+$clsmaret3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_maret1", "$slmaret3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_maret2", "$clmaret3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_maret3", "$clsmaret3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_maret4", "$total_maret3");

$slmaret4=$slmaret1-$slmaret2-$slmaret3;
$clmaret4=$clmaret1-$clmaret2-$clmaret3;
$clsmaret4=$clsmaret1-$clsmaret2-$clsmaret3;
$total_maret4=$slmaret4+$clmaret4+$clsmaret4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_maret1", "$slmaret4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_maret2", "$clmaret4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_maret3", "$clsmaret4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_maret4", "$total_maret4");

			$slmaret5=$slfebruari6;
			$clmaret5=$clfebruari6;
			$clsmaret5=$clsfebruari6;
			$total_maret5=$slmaret5+$clmaret5+$clsmaret5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_maret1", "$slmaret5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_maret2", "$clmaret5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_maret3", "$clsmaret5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_maret4", "$total_maret5");

$slmaret6=$slmaret4+$slmaret5;
$clmaret6=$clmaret4+$clmaret5;
$clsmaret6=$clsmaret4+$clsmaret5;
$total_maret6=$slmaret6+$clmaret6+$clsmaret6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_maret1", "$slmaret6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_maret2", "$clmaret6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_maret3", "$clsmaret6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_maret4", "$total_maret6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_maret1", "$total_maret6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_maret1:J$baris_maret4");
//maret END

//april
$baris_april1='18';
$baris_april2='19';
$baris_april3='20';
$baris_april4='21';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_april1", "APRIL");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_april1:B$baris_april4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_april1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_april2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_april3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_april4", "TOTAL");

			$slapril1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-04%' AND departement='SL'");
			$clapril1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-04%' AND departement='CL'");
			$clsapril1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-04%' AND departement='CLS'");
			$total_april1=$slapril1+$clapril1+$clsapril1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_april1", "$slapril1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_april2", "$clapril1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_april3", "$clsapril1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_april4", "$total_april1");

$cl75april2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25april2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$slapril2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='' AND departement='SL'")+$sl25april2;
$clapril2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='' AND departement='CL'")+$cl75april2;
$clsapril2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='' AND departement='CLS'");
$total_april2=$slapril2+$clapril2+$clsapril2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_april1", "$slapril2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_april2", "$clapril2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_april3", "$clsapril2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_april4", "$total_april2");

			$cl75april3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25april3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$slapril3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25april3;
			$clapril3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75april3;
			$clsapril3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-04%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_april3=$slapril3+$clapril3+$clsapril3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_april1", "$slapril3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_april2", "$clapril3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_april3", "$clsapril3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_april4", "$total_april3");

$slapril4=$slapril1-$slapril2-$slapril3;
$clapril4=$clapril1-$clapril2-$clapril3;
$clsapril4=$clsapril1-$clsapril2-$clsapril3;
$total_april4=$slapril4+$clapril4+$clsapril4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_april1", "$slapril4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_april2", "$clapril4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_april3", "$clsapril4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_april4", "$total_april4");

			$slapril5=$slmaret6;
			$clapril5=$clmaret6;
			$clsapril5=$clsmaret6;
			$total_april5=$slapril5+$clapril5+$clsapril5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_april1", "$slapril5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_april2", "$clapril5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_april3", "$clsapril5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_april4", "$total_april5");

$slapril6=$slapril4+$slapril5;
$clapril6=$clapril4+$clapril5;
$clsapril6=$clsapril4+$clsapril5;
$total_april6=$slapril6+$clapril6+$clsapril6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_april1", "$slapril6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_april2", "$clapril6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_april3", "$clsapril6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_april4", "$total_april6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_april1", "$total_april6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_april1:J$baris_april4");
//april END

//mei
$baris_mei1='22';
$baris_mei2='23';
$baris_mei3='24';
$baris_mei4='25';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_mei1", "MEI");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_mei1:B$baris_mei4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_mei1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_mei2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_mei3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_mei4", "TOTAL");

			$slmei1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-05%' AND departement='SL'");
			$clmei1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-05%' AND departement='CL'");
			$clsmei1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-05%' AND departement='CLS'");
			$total_mei1=$slmei1+$clmei1+$clsmei1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_mei1", "$slmei1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_mei2", "$clmei1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_mei3", "$clsmei1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_mei4", "$total_mei1");

$cl75mei2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25mei2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$slmei2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='' AND departement='SL'")+$sl25mei2;
$clmei2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='' AND departement='CL'")+$cl75mei2;
$clsmei2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='' AND departement='CLS'");
$total_mei2=$slmei2+$clmei2+$clsmei2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_mei1", "$slmei2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_mei2", "$clmei2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_mei3", "$clsmei2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_mei4", "$total_mei2");

			$cl75mei3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25mei3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$slmei3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25mei3;
			$clmei3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75mei3;
			$clsmei3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-05%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_mei3=$slmei3+$clmei3+$clsmei3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_mei1", "$slmei3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_mei2", "$clmei3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_mei3", "$clsmei3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_mei4", "$total_mei3");

$slmei4=$slmei1-$slmei2-$slmei3;
$clmei4=$clmei1-$clmei2-$clmei3;
$clsmei4=$clsmei1-$clsmei2-$clsmei3;
$total_mei4=$slmei4+$clmei4+$clsmei4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_mei1", "$slmei4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_mei2", "$clmei4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_mei3", "$clsmei4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_mei4", "$total_mei4");

			$slmei5=$slapril6;
			$clmei5=$clapril6;
			$clsmei5=$clsapril6;
			$total_mei5=$slmei5+$clmei5+$clsmei5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_mei1", "$slmei5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_mei2", "$clmei5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_mei3", "$clsmei5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_mei4", "$total_mei5");

$slmei6=$slmei4+$slmei5;
$clmei6=$clmei4+$clmei5;
$clsmei6=$clsmei4+$clsmei5;
$total_mei6=$slmei6+$clmei6+$clsmei6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_mei1", "$slmei6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_mei2", "$clmei6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_mei3", "$clsmei6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_mei4", "$total_mei6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_mei1", "$total_mei6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_mei1:J$baris_mei4");
//mei END

//juni
$baris_juni1='26';
$baris_juni2='27';
$baris_juni3='28';
$baris_juni4='29';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_juni1", "JUNI");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_juni1:B$baris_juni4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juni1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juni2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juni3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juni4", "TOTAL");

			$sljuni1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-06%' AND departement='SL'");
			$cljuni1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-06%' AND departement='CL'");
			$clsjuni1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-06%' AND departement='CLS'");
			$total_juni1=$sljuni1+$cljuni1+$clsjuni1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juni1", "$sljuni1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juni2", "$cljuni1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juni3", "$clsjuni1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juni4", "$total_juni1");

$cl75juni2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25juni2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$sljuni2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='' AND departement='SL'")+$sl25juni2;
$cljuni2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='' AND departement='CL'")+$cl75juni2;
$clsjuni2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='' AND departement='CLS'");
$total_juni2=$sljuni2+$cljuni2+$clsjuni2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juni1", "$sljuni2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juni2", "$cljuni2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juni3", "$clsjuni2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juni4", "$total_juni2");

			$cl75juni3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25juni3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$sljuni3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25juni3;
			$cljuni3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75juni3;
			$clsjuni3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-06%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_juni3=$sljuni3+$cljuni3+$clsjuni3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juni1", "$sljuni3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juni2", "$cljuni3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juni3", "$clsjuni3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juni4", "$total_juni3");

$sljuni4=$sljuni1-$sljuni2-$sljuni3;
$cljuni4=$cljuni1-$cljuni2-$cljuni3;
$clsjuni4=$clsjuni1-$clsjuni2-$clsjuni3;
$total_juni4=$sljuni4+$cljuni4+$clsjuni4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juni1", "$sljuni4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juni2", "$cljuni4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juni3", "$clsjuni4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juni4", "$total_juni4");

			$sljuni5=$slmei6;
			$cljuni5=$clmei6;
			$clsjuni5=$clsmei6;
			$total_juni5=$sljuni5+$cljuni5+$clsjuni5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juni1", "$sljuni5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juni2", "$cljuni5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juni3", "$clsjuni5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juni4", "$total_juni5");

$sljuni6=$sljuni4+$sljuni5;
$cljuni6=$cljuni4+$cljuni5;
$clsjuni6=$clsjuni4+$clsjuni5;
$total_juni6=$sljuni6+$cljuni6+$clsjuni6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juni1", "$sljuni6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juni2", "$cljuni6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juni3", "$clsjuni6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juni4", "$total_juni6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_juni1", "$total_juni6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_juni1:J$baris_juni4");
//juni END

//juli
$baris_juli1='30';
$baris_juli2='31';
$baris_juli3='32';
$baris_juli4='33';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_juli1", "JULI");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_juli1:B$baris_juli4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juli1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juli2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juli3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_juli4", "TOTAL");

			$sljuli1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-07%' AND departement='SL'");
			$cljuli1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-07%' AND departement='CL'");
			$clsjuli1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-07%' AND departement='CLS'");
			$total_juli1=$sljuli1+$cljuli1+$clsjuli1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juli1", "$sljuli1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juli2", "$cljuli1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juli3", "$clsjuli1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_juli4", "$total_juli1");

$cl75juli2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25juli2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$sljuli2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='' AND departement='SL'")+$sl25juli2;
$cljuli2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='' AND departement='CL'")+$cl75juli2;
$clsjuli2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='' AND departement='CLS'");
$total_juli2=$sljuli2+$cljuli2+$clsjuli2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juli1", "$sljuli2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juli2", "$cljuli2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juli3", "$clsjuli2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_juli4", "$total_juli2");

			$cl75juli3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25juli3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$sljuli3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25juli3;
			$cljuli3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75juli3;
			$clsjuli3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-07%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_juli3=$sljuli3+$cljuli3+$clsjuli3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juli1", "$sljuli3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juli2", "$cljuli3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juli3", "$clsjuli3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_juli4", "$total_juli3");

$sljuli4=$sljuli1-$sljuli2-$sljuli3;
$cljuli4=$cljuli1-$cljuli2-$cljuli3;
$clsjuli4=$clsjuli1-$clsjuli2-$clsjuli3;
$total_juli4=$sljuli4+$cljuli4+$clsjuli4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juli1", "$sljuli4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juli2", "$cljuli4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juli3", "$clsjuli4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_juli4", "$total_juli4");

			$sljuli5=$sljuni6;
			$cljuli5=$cljuni6;
			$clsjuli5=$clsjuni6;
			$total_juli5=$sljuli5+$cljuli5+$clsjuli5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juli1", "$sljuli5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juli2", "$cljuli5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juli3", "$clsjuli5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_juli4", "$total_juli5");

$sljuli6=$sljuli4+$sljuli5;
$cljuli6=$cljuli4+$cljuli5;
$clsjuli6=$clsjuli4+$clsjuli5;
$total_juli6=$sljuli6+$cljuli6+$clsjuli6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juli1", "$sljuli6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juli2", "$cljuli6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juli3", "$clsjuli6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_juli4", "$total_juli6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_juli1", "$total_juli6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_juli1:J$baris_juli4");
//juli END

//agustus
$baris_agustus1='34';
$baris_agustus2='35';
$baris_agustus3='36';
$baris_agustus4='37';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_agustus1", "AGUSTUS");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_agustus1:B$baris_agustus4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_agustus1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_agustus2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_agustus3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_agustus4", "TOTAL");

			$slagustus1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-08%' AND departement='SL'");
			$clagustus1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-08%' AND departement='CL'");
			$clsagustus1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-08%' AND departement='CLS'");
			$total_agustus1=$slagustus1+$clagustus1+$clsagustus1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_agustus1", "$slagustus1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_agustus2", "$clagustus1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_agustus3", "$clsagustus1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_agustus4", "$total_agustus1");

$cl75agustus2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25agustus2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$slagustus2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='' AND departement='SL'")+$sl25agustus2;
$clagustus2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='' AND departement='CL'")+$cl75agustus2;
$clsagustus2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='' AND departement='CLS'");
$total_agustus2=$slagustus2+$clagustus2+$clsagustus2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_agustus1", "$slagustus2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_agustus2", "$clagustus2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_agustus3", "$clsagustus2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_agustus4", "$total_agustus2");

			$cl75agustus3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25agustus3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$slagustus3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25agustus3;
			$clagustus3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75agustus3;
			$clsagustus3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-08%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_agustus3=$slagustus3+$clagustus3+$clsagustus3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_agustus1", "$slagustus3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_agustus2", "$clagustus3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_agustus3", "$clsagustus3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_agustus4", "$total_agustus3");

$slagustus4=$slagustus1-$slagustus2-$slagustus3;
$clagustus4=$clagustus1-$clagustus2-$clagustus3;
$clsagustus4=$clsagustus1-$clsagustus2-$clsagustus3;
$total_agustus4=$slagustus4+$clagustus4+$clsagustus4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_agustus1", "$slagustus4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_agustus2", "$clagustus4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_agustus3", "$clsagustus4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_agustus4", "$total_agustus4");

			$slagustus5=$sljuli6;
			$clagustus5=$cljuli6;
			$clsagustus5=$clsjuli6;
			$total_agustus5=$slagustus5+$clagustus5+$clsagustus5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_agustus1", "$slagustus5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_agustus2", "$clagustus5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_agustus3", "$clsagustus5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_agustus4", "$total_agustus5");

$slagustus6=$slagustus4+$slagustus5;
$clagustus6=$clagustus4+$clagustus5;
$clsagustus6=$clsagustus4+$clsagustus5;
$total_agustus6=$slagustus6+$clagustus6+$clsagustus6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_agustus1", "$slagustus6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_agustus2", "$clagustus6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_agustus3", "$clsagustus6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_agustus4", "$total_agustus6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_agustus1", "$total_agustus6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_agustus1:J$baris_agustus4");
//agustus END

//september
$baris_september1='38';
$baris_september2='39';
$baris_september3='40';
$baris_september4='41';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_september1", "SEPTEMBER");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_september1:B$baris_september4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_september1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_september2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_september3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_september4", "TOTAL");

			$slseptember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-09%' AND departement='SL'");
			$clseptember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-09%' AND departement='CL'");
			$clsseptember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-09%' AND departement='CLS'");
			$total_september1=$slseptember1+$clseptember1+$clsseptember1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_september1", "$slseptember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_september2", "$clseptember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_september3", "$clsseptember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_september4", "$total_september1");

$cl75september2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25september2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$slseptember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='' AND departement='SL'")+$sl25september2;
$clseptember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='' AND departement='CL'")+$cl75september2;
$clsseptember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='' AND departement='CLS'");
$total_september2=$slseptember2+$clseptember2+$clsseptember2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_september1", "$slseptember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_september2", "$clseptember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_september3", "$clsseptember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_september4", "$total_september2");

			$cl75september3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25september3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$slseptember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25september3;
			$clseptember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75september3;
			$clsseptember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-09%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_september3=$slseptember3+$clseptember3+$clsseptember3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_september1", "$slseptember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_september2", "$clseptember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_september3", "$clsseptember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_september4", "$total_september3");

$slseptember4=$slseptember1-$slseptember2-$slseptember3;
$clseptember4=$clseptember1-$clseptember2-$clseptember3;
$clsseptember4=$clsseptember1-$clsseptember2-$clsseptember3;
$total_september4=$slseptember4+$clseptember4+$clsseptember4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_september1", "$slseptember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_september2", "$clseptember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_september3", "$clsseptember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_september4", "$total_september4");

			$slseptember5=$slagustus6;
			$clseptember5=$clagustus6;
			$clsseptember5=$clsagustus6;
			$total_september5=$slseptember5+$clseptember5+$clsseptember5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_september1", "$slseptember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_september2", "$clseptember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_september3", "$clsseptember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_september4", "$total_september5");

$slseptember6=$slseptember4+$slseptember5;
$clseptember6=$clseptember4+$clseptember5;
$clsseptember6=$clsseptember4+$clsseptember5;
$total_september6=$slseptember6+$clseptember6+$clsseptember6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_september1", "$slseptember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_september2", "$clseptember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_september3", "$clsseptember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_september4", "$total_september6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_september1", "$total_september6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_september1:J$baris_september4");
//september END


//oktober
$baris_oktober1='42';
$baris_oktober2='43';
$baris_oktober3='44';
$baris_oktober4='45';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_oktober1", "OKTOBER");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_oktober1:B$baris_oktober4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_oktober1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_oktober2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_oktober3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_oktober4", "TOTAL");

			$sloktober1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-10%' AND departement='SL'");
			$cloktober1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-10%' AND departement='CL'");
			$clsoktober1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-10%' AND departement='CLS'");
			$total_oktober1=$sloktober1+$cloktober1+$clsoktober1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_oktober1", "$sloktober1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_oktober2", "$cloktober1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_oktober3", "$clsoktober1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_oktober4", "$total_oktober1");

$cl75oktober2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25oktober2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$sloktober2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='' AND departement='SL'")+$sl25oktober2;
$cloktober2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='' AND departement='CL'")+$cl75oktober2;
$clsoktober2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='' AND departement='CLS'");
$total_oktober2=$sloktober2+$cloktober2+$clsoktober2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_oktober1", "$sloktober2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_oktober2", "$cloktober2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_oktober3", "$clsoktober2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_oktober4", "$total_oktober2");

			$cl75oktober3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25oktober3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$sloktober3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25oktober3;
			$cloktober3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75oktober3;
			$clsoktober3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-10%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_oktober3=$sloktober3+$cloktober3+$clsoktober3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_oktober1", "$sloktober3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_oktober2", "$cloktober3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_oktober3", "$clsoktober3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_oktober4", "$total_oktober3");

$sloktober4=$sloktober1-$sloktober2-$sloktober3;
$cloktober4=$cloktober1-$cloktober2-$cloktober3;
$clsoktober4=$clsoktober1-$clsoktober2-$clsoktober3;
$total_oktober4=$sloktober4+$cloktober4+$clsoktober4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_oktober1", "$sloktober4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_oktober2", "$cloktober4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_oktober3", "$clsoktober4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_oktober4", "$total_oktober4");

			$sloktober5=$slseptember6;
			$cloktober5=$clseptember6;
			$clsoktober5=$clsseptember6;
			$total_oktober5=$sloktober5+$cloktober5+$clsoktober5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_oktober1", "$sloktober5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_oktober2", "$cloktober5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_oktober3", "$clsoktober5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_oktober4", "$total_oktober5");

$sloktober6=$sloktober4+$sloktober5;
$cloktober6=$cloktober4+$cloktober5;
$clsoktober6=$clsoktober4+$clsoktober5;
$total_oktober6=$sloktober6+$cloktober6+$clsoktober6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_oktober1", "$sloktober6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_oktober2", "$cloktober6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_oktober3", "$clsoktober6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_oktober4", "$total_oktober6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_oktober1", "$total_oktober6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_oktober1:J$baris_oktober4");
//oktober END

//november
$baris_november1='46';
$baris_november2='47';
$baris_november3='48';
$baris_november4='49';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_november1", "NOVEMBER");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_november1:B$baris_november4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_november1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_november2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_november3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_november4", "TOTAL");

			$slnovember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-11%' AND departement='SL'");
			$clnovember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-11%' AND departement='CL'");
			$clsnovember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-11%' AND departement='CLS'");
			$total_november1=$slnovember1+$clnovember1+$clsnovember1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_november1", "$slnovember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_november2", "$clnovember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_november3", "$clsnovember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_november4", "$total_november1");

$cl75november2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25november2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$slnovember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='' AND departement='SL'")+$sl25november2;
$clnovember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='' AND departement='CL'")+$cl75november2;
$clsnovember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='' AND departement='CLS'");
$total_november2=$slnovember2+$clnovember2+$clsnovember2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_november1", "$slnovember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_november2", "$clnovember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_november3", "$clsnovember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_november4", "$total_november2");

			$cl75november3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25november3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$slnovember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25november3;
			$clnovember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75november3;
			$clsnovember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-11%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_november3=$slnovember3+$clnovember3+$clsnovember3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_november1", "$slnovember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_november2", "$clnovember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_november3", "$clsnovember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_november4", "$total_november3");

$slnovember4=$slnovember1-$slnovember2-$slnovember3;
$clnovember4=$clnovember1-$clnovember2-$clnovember3;
$clsnovember4=$clsnovember1-$clsnovember2-$clsnovember3;
$total_november4=$slnovember4+$clnovember4+$clsnovember4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_november1", "$slnovember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_november2", "$clnovember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_november3", "$clsnovember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_november4", "$total_november4");

			$slnovember5=$sloktober6;
			$clnovember5=$cloktober6;
			$clsnovember5=$clsoktober6;
			$total_november5=$slnovember5+$clnovember5+$clsnovember5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_november1", "$slnovember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_november2", "$clnovember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_november3", "$clsnovember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_november4", "$total_november5");

$slnovember6=$slnovember4+$slnovember5;
$clnovember6=$clnovember4+$clnovember5;
$clsnovember6=$clsnovember4+$clsnovember5;
$total_november6=$slnovember6+$clnovember6+$clsnovember6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_november1", "$slnovember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_november2", "$clnovember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_november3", "$clsnovember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_november4", "$total_november6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_november1", "$total_november6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_november1:J$baris_november4");
//november END

//desember
$baris_desember1='50';
$baris_desember2='51';
$baris_desember3='52';
$baris_desember4='53';
$objPHPExcel->getActiveSheet()->setCellValue("B$baris_desember1", "DESEMBER");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B$baris_desember1:B$baris_desember4");

$objPHPExcel->getActiveSheet()->setCellValue("C$baris_desember1", "SL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_desember2", "CL");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_desember3", "CLS");
$objPHPExcel->getActiveSheet()->setCellValue("C$baris_desember4", "TOTAL");

			$sldesember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-12%' AND departement='SL'");
			$cldesember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-12%' AND departement='CL'");
			$clsdesember1=ambil_database("SUM(ppn)",akuntansiv3_faktur_keluaran,"tanggal LIKE '$tahun-12%' AND departement='CLS'");
			$total_desember1=$sldesember1+$cldesember1+$clsdesember1;

			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_desember1", "$sldesember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_desember2", "$cldesember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_desember3", "$clsdesember1");
			$objPHPExcel->getActiveSheet()->setCellValue("D$baris_desember4", "$total_desember1");

$cl75desember2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='' AND departement='CL+SL'")*75)/100;
$sl25desember2=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='' AND departement='CL+SL'")*25)/100;

$sldesember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='' AND departement='SL'")+$sl25desember2;
$cldesember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='' AND departement='CL'")+$cl75desember2;
$clsdesember2=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='' AND departement='CLS'");
$total_desember2=$sldesember2+$cldesember2+$clsdesember2;

$objPHPExcel->getActiveSheet()->setCellValue("E$baris_desember1", "$sldesember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_desember2", "$cldesember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_desember3", "$clsdesember2");
$objPHPExcel->getActiveSheet()->setCellValue("E$baris_desember4", "$total_desember2");

			$cl75desember3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*75)/100;
			$sl25desember3=(ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='LAIN-LAIN' AND departement='CL+SL'")*25)/100;

			$sldesember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='LAIN-LAIN' AND departement='SL'")+$sl25desember3;
			$cldesember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='LAIN-LAIN' AND departement='CL'")+$cl75desember3;
			$clsdesember3=ambil_database("SUM(ppn)",akuntansiv3_faktur_masukkan,"tanggal LIKE '$tahun-12%' AND jenis_faktur='LAIN-LAIN' AND departement='CLS'");
			$total_desember3=$sldesember3+$cldesember3+$clsdesember3;

			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_desember1", "$sldesember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_desember2", "$cldesember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_desember3", "$clsdesember3");
			$objPHPExcel->getActiveSheet()->setCellValue("F$baris_desember4", "$total_desember3");

$sldesember4=$sldesember1-$sldesember2-$sldesember3;
$cldesember4=$cldesember1-$cldesember2-$cldesember3;
$clsdesember4=$clsdesember1-$clsdesember2-$clsdesember3;
$total_desember4=$sldesember4+$cldesember4+$clsdesember4;

$objPHPExcel->getActiveSheet()->setCellValue("G$baris_desember1", "$sldesember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_desember2", "$cldesember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_desember3", "$clsdesember4");
$objPHPExcel->getActiveSheet()->setCellValue("G$baris_desember4", "$total_desember4");

			$sldesember5=$slnovember6;
			$cldesember5=$clnovember6;
			$clsdesember5=$clsnovember6;
			$total_desember5=$sldesember5+$cldesember5+$clsdesember5;

			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_desember1", "$sldesember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_desember2", "$cldesember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_desember3", "$clsdesember5");
			$objPHPExcel->getActiveSheet()->setCellValue("H$baris_desember4", "$total_desember5");

$sldesember6=$sldesember4+$sldesember5;
$cldesember6=$cldesember4+$cldesember5;
$clsdesember6=$clsdesember4+$clsdesember5;
$total_desember6=$sldesember6+$cldesember6+$clsdesember6;

$objPHPExcel->getActiveSheet()->setCellValue("I$baris_desember1", "$sldesember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_desember2", "$cldesember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_desember3", "$clsdesember6");
$objPHPExcel->getActiveSheet()->setCellValue("I$baris_desember4", "$total_desember6");

			$objPHPExcel->getActiveSheet()->setCellValue("J$baris_desember1", "$total_desember6");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("J$baris_desember1:J$baris_desember4");
//desember END



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
	cellColor("C$baris_januari4:I$baris_januari4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_februari4:I$baris_februari4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_maret4:I$baris_maret4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_april4:I$baris_april4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_mei4:I$baris_mei4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_juni4:I$baris_juni4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_juli4:I$baris_juli4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_agustus4:I$baris_agustus4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_september4:I$baris_september4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_oktober4:I$baris_oktober4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_november4:I$baris_november4", "ADD8E6");//FAKTUR MASUKKAN
	cellColor("C$baris_desember4:I$baris_desember4", "ADD8E6");//FAKTUR MASUKKAN

//PERINTAH BORDER
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
)));
$objPHPExcel->getActiveSheet()->getStyle("B6:J53")->applyFromArray($styleArray);//FAKTUR MASUKKAN
unset($styleArray);
//PERINTAH BORDER END

/**autosize*/
for ($col = 'B'; $col != 'J'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}
/**autosize*/

//CENTER
$style3 = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
$objPHPExcel->getActiveSheet()->getStyle("B1:J5")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("C6:C53")->applyFromArray($style3);//FAKTUR MASUKKAN

//CENTER
$style4 = array(
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);
$objPHPExcel->getActiveSheet()->getStyle("B6:B53")->applyFromArray($style4);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("J6:J53")->applyFromArray($style4);//FAKTUR MASUKKAN




$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=科技廠營業稅 LAP PPN 010 CL+SL MS YEN $akhir_periode1 - $akhir_periode2.xls");
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
