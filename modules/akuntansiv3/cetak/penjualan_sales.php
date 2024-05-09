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

function ambil_variabel($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode('","', $datasecs);
	$hasil='"'.$data.'"';
return $hasil;}

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
// $pilihan_tahun=$_POST['pilihan_tahun1'];
// $pilihan_bulan=$_POST['pilihan_bulan1'];
// $pencarian=$_POST['pencarian1'];
// $pilihan_pencarian=$_POST['pilihan_pencarian1'];
// $address=$_POST['address1'];
$periode1=$_POST[periode1];
$periode2=$_POST[periode2];
//AMBIL VARIABEL KIRIM END


//PECAH
$column_items='No,Invoice,Faktur,Faktur Date,Nilai,Debit,Kredit,Nilai USD,Debit USD,Kredit USD,Kode Voucher,Keterangan,Nama Perusahaan,Tanggal Transaksi';

$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai,aj,ak,al,am,an,ao,ap,aq,ar,as,at,au,av,aw,ax,ay,az,ba,bb,bc,bd,be,bf,bg,bh,bi,bj,bk,bl,bm,bn,bo,bp,bq,br,bs,bt,bu,bv,bw,bx,by,bz';
$nilai_column=nilai_pecah($column_items);

$jumlah_column=pecah($column_items);
$jumlah_column_alpabet=pecah($alpabet);
//PECAH END


require_once dirname(__FILE__) . '/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();


//HEADER TABEL
$no=0;for($i=0; $i < $nilai_column; ++$i){
  //$name=ambil_database($bahasa,pusat_bahasa,"kode='".$jumlah_column[$no]."'");
	$name=$jumlah_column[$no];
  $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]1", "$name");
$no++;}
//HEADER TABEL END


// $query=mysql_query("SELECT deliverycl_invoice.perusahaan,
// 													 deliverycl_invoice.no_invoice,
//  													 deliverycl_invoice.discount,
// 													 deliverycl_invoice.nomor_faktur,
// 													 deliverycl_invoice.kode_jenis_transaksi,
// 													 deliverycl_invoice.fg_pengganti,
// 													 deliverycl_invoice.tanggal_faktur,
// 													 deliverycl_invoice_items.item_name,
// 													 deliverycl_invoice_items.amount_rp,
// 													 deliverycl_invoice_items.amount
// 										FROM deliverycl_invoice
// 										INNER JOIN deliverycl_invoice_items
// 										ON deliverycl_invoice.no_invoice=deliverycl_invoice_items.induk
// 										WHERE deliverycl_invoice.status='Selesai' AND deliverycl_invoice.tanggal BETWEEN '$periode1' AND '$periode2'");
// $no =2;
//
//
//
// while ($rows1=mysql_fetch_array($query)){
// 	//echo "<td>$no</td>";
// 	$objPHPExcel->getActiveSheet()->setCellValue("A$no", "".($no-1)."");
//
// 	//echo "<td>$rows1[tanggal]</td>";
// 	$objPHPExcel->getActiveSheet()->setCellValue("B$no", "$rows1[no_invoice]");
//
// 	//echo "<td>$rows1[surat_jalan]</td>";
// 	$objPHPExcel->getActiveSheet()->setCellValue("C$no", "$rows1[kode_jenis_transaksi]$rows1[fg_pengganti]$rows1[nomor_faktur]");
//
// 	$objPHPExcel->getActiveSheet()->setCellValue("D$no", "$rows1[tanggal_faktur]");
// 	$objPHPExcel->getActiveSheet()->setCellValue("E$no", "$rows1[amount_rp]");
// 	$objPHPExcel->getActiveSheet()->setCellValue("H$no", "$rows1[amount]");
//
// 	$objPHPExcel->getActiveSheet()->setCellValue("L$no", "$rows1[item_name]");
// 	$objPHPExcel->getActiveSheet()->setCellValue("M$no", "$rows1[perusahaan]");
//
// $no++;}


$result1=mysql_query("SELECT * FROM akuntansiv3_faktur_keluaran WHERE tanggal BETWEEN '$periode1' AND '$periode2'");
$no =2;
while ($rows1=mysql_fetch_array($result1)) {
	//echo "<td>$no</td>";
	$objPHPExcel->getActiveSheet()->setCellValue("A$no", "".($no-1)."");

	//echo "<td>$rows1[tanggal]</td>";
	$objPHPExcel->getActiveSheet()->setCellValue("B$no", "$rows1[no_invoice_masukkan]");

	//echo "<td>$rows1[surat_jalan]</td>";
	$objPHPExcel->getActiveSheet()->setCellValue("C$no", "$rows1[no_faktur]");

	$objPHPExcel->getActiveSheet()->setCellValue("D$no", "$rows1[tanggal]");
	$objPHPExcel->getActiveSheet()->setCellValue("E$no", "$rows1[amount_rp]");
	$objPHPExcel->getActiveSheet()->setCellValue("H$no", "$rows1[dpp_usd]");

	// $keterangan=ambil_variabel(inventory_distribusi_items,keterangan,"WHERE nomor_aju='$rows1[no_aju]' GROUP BY keterangan");
// 	echo ambil_database(id,inventory_distribusi,"nomor_aju='$rows1[no_aju]'")."TEST";
// echo "$rows1[no_aju]</br>";

	$objPHPExcel->getActiveSheet()->setCellValue("L$no", "$rows1[keterangan]");//$keterangan
	$objPHPExcel->getActiveSheet()->setCellValue("M$no", "$rows1[pembeli]");
$no++;}




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
header("Content-Disposition: attachment;filename=Sales $periode1 s/d $periode2.xls");
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
