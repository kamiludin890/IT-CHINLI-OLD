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


//PECAH
$column_items='Tgl,Pembeli,No. FP,PPN,Ket,CL,SL,CLS';
$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai,aj,ak,al,am,an,ao,ap,aq,ar,as,at,au,av,aw,ax,ay,az,ba,bb,bc,bd,be,bf,bg,bh,bi,bj,bk,bl,bm,bn,bo,bp,bq,br,bs,bt,bu,bv,bw,bx,by,bz';
$nilai_column=nilai_pecah($column_items);

$jumlah_column=pecah($column_items);
$jumlah_column_alpabet=pecah($alpabet);
//PECAH END


require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();



//FAKTUR KELUARAN
$objPHPExcel->getActiveSheet()->setCellValue("A1", "FAKTUR 010 KELUAR");
//HEADER TABEL
$no=0;for($i=0; $i < $nilai_column; ++$i){
	// $name=ambil_database(ina,master_bahasa,"kode='".$jumlah_column[$no]."'");
	$name=$jumlah_column[$no];
  $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]2", "$name");
$no++;}
//HEADER TABEL END
//ISI TABEL
$sql=mysql_query("SELECT * FROM akuntansiv3_faktur_keluaran WHERE tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2'");
$urutan_bawah=3;
while ($rows=mysql_fetch_array($sql)) {

      $objPHPExcel->getActiveSheet()->setCellValue("a$urutan_bawah", $rows[tanggal]);
			$objPHPExcel->getActiveSheet()->setCellValue("b$urutan_bawah", $rows[pembeli]);
			$objPHPExcel->getActiveSheet()->setCellValue("c$urutan_bawah", faktur($rows[no_faktur]));
			$objPHPExcel->getActiveSheet()->setCellValue("d$urutan_bawah", $rows[ppn]);
			$objPHPExcel->getActiveSheet()->setCellValue("e$urutan_bawah", $rows[departement]);

			if ($rows[departement]=='CL') {
				$satu=$rows[ppn]; $dua='0'; $tiga='0';
			}elseif ($rows[departement]=='SL') {
				$satu='0'; $dua=$rows[ppn]; $tiga='0';
			}elseif ($rows[departement]=='CLS') {
				$satu='0'; $dua='0'; $tiga=$rows[ppn];
			}elseif ($rows[departement]=='CL+SL') {
				$satu=($rows[ppn]*75)/100; $dua=($rows[ppn]*25)/100; $tiga='0';
			}else {
				$satu='';
			}

			$objPHPExcel->getActiveSheet()->setCellValue("f$urutan_bawah", $satu);
			$objPHPExcel->getActiveSheet()->setCellValue("g$urutan_bawah", $dua);
			$objPHPExcel->getActiveSheet()->setCellValue("h$urutan_bawah", $tiga);

			$grand_total_ppn=$rows[ppn]+$grand_total_ppn;
			$grand_total_satu=$satu+$grand_total_satu;
			$grand_total_dua=$dua+$grand_total_dua;
			$grand_total_tiga=$tiga+$grand_total_tiga;

$urutan_bawah++;}
//ISI TABEL END
$objPHPExcel->getActiveSheet()->setCellValue("d$urutan_bawah", $grand_total_ppn);
$objPHPExcel->getActiveSheet()->setCellValue("f$urutan_bawah", $grand_total_satu);
$objPHPExcel->getActiveSheet()->setCellValue("g$urutan_bawah", $grand_total_dua);
$objPHPExcel->getActiveSheet()->setCellValue("h$urutan_bawah", $grand_total_tiga);
//FAKTUR KELUARAN END



//FAKTUR KELUARAN
$urutan_kedua=$urutan_bawah+2;
$objPHPExcel->getActiveSheet()->setCellValue("A$urutan_kedua", "FAKTUR 010 MASUK");
//HEADER TABEL
$no=0;for($i=0; $i < $nilai_column; ++$i){
	// $name=ambil_database(ina,master_bahasa,"kode='".$jumlah_column[$no]."'");
	$name=$jumlah_column[$no];
  $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]".($urutan_kedua+1)."", "$name");
$no++;}
//HEADER TABEL END
//ISI TABEL
$sql2=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2' AND jenis_faktur=''");
$urutan_bawah2=$urutan_kedua+2;
while ($rows2=mysql_fetch_array($sql2)) {

      $objPHPExcel->getActiveSheet()->setCellValue("a$urutan_bawah2", $rows2[tanggal]);
			$objPHPExcel->getActiveSheet()->setCellValue("b$urutan_bawah2", $rows2[pembeli]);
			$objPHPExcel->getActiveSheet()->setCellValue("c$urutan_bawah2", faktur($rows2[no_faktur]));
			$objPHPExcel->getActiveSheet()->setCellValue("d$urutan_bawah2", $rows2[ppn]);
			$objPHPExcel->getActiveSheet()->setCellValue("e$urutan_bawah2", $rows2[departement]);

			if ($rows2[departement]=='CL') {
			  $satu2=$rows2[ppn]; $dua2='0'; $tiga2='0';
			}elseif ($rows2[departement]=='SL') {
			  $satu2='0'; $dua2=$rows2[ppn]; $tiga2='0';
			}elseif ($rows2[departement]=='CLS') {
			  $satu2='0'; $dua2='0'; $tiga2=$rows2[ppn];
			}elseif ($rows2[departement]=='CL+SL') {
			  $satu2=($rows2[ppn]*75)/100; $dua2=($rows2[ppn]*25)/100; $tiga2='0';
			}

			$objPHPExcel->getActiveSheet()->setCellValue("f$urutan_bawah2", $satu2);
			$objPHPExcel->getActiveSheet()->setCellValue("g$urutan_bawah2", $dua2);
			$objPHPExcel->getActiveSheet()->setCellValue("h$urutan_bawah2", $tiga2);

			$grand_total_ppn2=$rows2[ppn]+$grand_total_ppn2;
			$grand_total_satu2=$satu2+$grand_total_satu2;
			$grand_total_dua2=$dua2+$grand_total_dua2;
			$grand_total_tiga2=$tiga2+$grand_total_tiga2;

$urutan_bawah2++;}
//ISI TABEL END
$objPHPExcel->getActiveSheet()->setCellValue("d$urutan_bawah2", $grand_total_ppn2);
$objPHPExcel->getActiveSheet()->setCellValue("f$urutan_bawah2", $grand_total_satu2);
$objPHPExcel->getActiveSheet()->setCellValue("g$urutan_bawah2", $grand_total_dua2);
$objPHPExcel->getActiveSheet()->setCellValue("h$urutan_bawah2", $grand_total_tiga2);
//FAKTUR KELUARAN END


//FAKTUR LAIN LAIN
$urutan_ketiga=$urutan_bawah2+2;
$objPHPExcel->getActiveSheet()->setCellValue("A$urutan_ketiga", "FAKTUR DOKUMEN LAIN LAIN");
//HEADER TABEL
$no=0;for($i=0; $i < $nilai_column; ++$i){
	// $name=ambil_database(ina,master_bahasa,"kode='".$jumlah_column[$no]."'");
	$name=$jumlah_column[$no];
  $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]".($urutan_ketiga+1)."", "$name");
$no++;}
//HEADER TABEL END
//ISI TABEL
$sql3=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2' AND jenis_faktur='LAIN-LAIN'");
$urutan_bawah3=$urutan_ketiga+2;
while ($rows3=mysql_fetch_array($sql3)) {

	      $objPHPExcel->getActiveSheet()->setCellValue("a$urutan_bawah3", $rows3[tanggal]);
				$objPHPExcel->getActiveSheet()->setCellValue("b$urutan_bawah3", $rows3[pembeli]);
				$objPHPExcel->getActiveSheet()->setCellValue("c$urutan_bawah3", faktur($rows3[no_faktur]));
				$objPHPExcel->getActiveSheet()->setCellValue("d$urutan_bawah3", $rows3[ppn]);
				$objPHPExcel->getActiveSheet()->setCellValue("e$urutan_bawah3", $rows3[departement]);

				if ($rows3[departement]=='CL') {
				  $satu3=$rows3[ppn]; $dua3='0'; $tiga3='0';
				}elseif ($rows3[departement]=='SL') {
				  $satu3='0'; $dua3=$rows3[ppn]; $tiga3='0';
				}elseif ($rows3[departement]=='CLS') {
				  $satu3='0'; $dua3='0'; $tiga3=$rows3[ppn];
				}elseif ($rows3[departement]=='CL+SL') {
				  $satu3=($rows3[ppn]*75)/100; $dua3=($rows3[ppn]*25)/100; $tiga3='0';
				}

				$objPHPExcel->getActiveSheet()->setCellValue("f$urutan_bawah3", $satu3);
				$objPHPExcel->getActiveSheet()->setCellValue("g$urutan_bawah3", $dua3);
				$objPHPExcel->getActiveSheet()->setCellValue("h$urutan_bawah3", $tiga3);

				$grand_total_ppn3=$rows3[ppn]+$grand_total_ppn3;
				$grand_total_satu3=$satu3+$grand_total_satu3;
				$grand_total_dua3=$dua3+$grand_total_dua3;
				$grand_total_tiga3=$tiga3+$grand_total_tiga3;

	$urutan_bawah3++;}
//ISI TABEL END
$objPHPExcel->getActiveSheet()->setCellValue("d$urutan_bawah3", $grand_total_ppn3);
$objPHPExcel->getActiveSheet()->setCellValue("f$urutan_bawah3", $grand_total_satu3);
$objPHPExcel->getActiveSheet()->setCellValue("g$urutan_bawah3", $grand_total_dua3);
$objPHPExcel->getActiveSheet()->setCellValue("h$urutan_bawah3", $grand_total_tiga3);
//FAKTUR LAIN LAIN END







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
	cellColor("A$urutan_bawah:H$urutan_bawah", "ffff00");//FAKTUR MASUKKAN
	cellColor("A$urutan_bawah2:H$urutan_bawah2", "ffff00");//FAKTUR MASUKKAN
	cellColor("A$urutan_bawah3:H$urutan_bawah3", "ffff00");//FAKTUR MASUKKAN

//PERINTAH BORDER
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
)));
$objPHPExcel->getActiveSheet()->getStyle("A2:H$urutan_bawah")->applyFromArray($styleArray);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("A".($urutan_kedua+1).":H$urutan_bawah2")->applyFromArray($styleArray);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("A".($urutan_ketiga+1).":H$urutan_bawah3")->applyFromArray($styleArray);//FAKTUR MASUKKAN
unset($styleArray);
//PERINTAH BORDER END

/**autosize*/
for ($col = 'A'; $col != 'H'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}
/**autosize*/

//CENTER
$style3 = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
$objPHPExcel->getActiveSheet()->getStyle("A2:H2")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("A2:A$urutan_bawah")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("C2:C$urutan_bawah")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("E1:E$urutan_bawah")->applyFromArray($style3);//FAKTUR MASUKKAN

$objPHPExcel->getActiveSheet()->getStyle("A".($urutan_kedua+1).":A$urutan_bawah2")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("C".($urutan_kedua+1).":C$urutan_bawah2")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("E$urutan_kedua:E$urutan_bawah2")->applyFromArray($style3);//FAKTUR MASUKKAN

$objPHPExcel->getActiveSheet()->getStyle("A".($urutan_ketiga+1).":A$urutan_bawah3")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("C".($urutan_ketiga+1).":C$urutan_bawah3")->applyFromArray($style3);//FAKTUR MASUKKAN
$objPHPExcel->getActiveSheet()->getStyle("E$urutan_ketiga:E$urutan_bawah3")->applyFromArray($style3);//FAKTUR MASUKKAN


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
