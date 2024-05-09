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
$nama_database='admin_purchasing';
$nama_database_items='admin_purchasing_items';

$pilihan_tahun=$_POST['pilihan_tahun'];//TAHUN
$pilihan_bulan=$_POST['pilihan_bulan'];//BULAN
$pilihan_pencarian=$_POST['pilihan_pencarian'];//Pilihan Pencarian
$pencarian=$_POST['pencarian'];//Pilihan Pencarian

//$nomor_po=ambil_database(po_purchasing,$nama_database,"id='$id'");
//AMBIL VARIABEL KIRIM END

//PECAH
$column_items='no,kepada,tanggal,po_purchasing,paymen_term,attn,note,po_nomor,line_batch,departement,kode_barang,material_description_po,cauge_width,satuan,qty_purchasing,harga,total_harga,etd,remark,pcx_no,season,shoe_model,supplier_alocation,foto';
$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai';
$nilai_column=nilai_pecah($column_items);

$jumlah_column=pecah($column_items);
$jumlah_column_alpabet=pecah($alpabet);
//PECAH END


//if ($id!='') {//PENENTU PRINT ATAU TIDAK
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

//GAMBAR CHINLI
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
if (ambil_database(kepada,$nama_database,"id='$id'")=='TIONG LIONG INDUSTRIAL CO., LTD.'){$logo_lengkap='logo_lengkap_taiwan.png';}else{$logo_lengkap='logo_lengkap.png';}
$objDrawing->setDescription("../../gambar/$logo_lengkap");
$objDrawing->setPath("../../gambar/$logo_lengkap");
$objDrawing->setCoordinates('C1');
//setOffsetX works properly
$objDrawing->setOffsetX(5);
$objDrawing->setOffsetY(5);
//set width, height
$objDrawing->setWidth(50);
$objDrawing->setHeight(90);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
//GAMBAR CHINLI END


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
  $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]11", "$name");
$no++;}
//HEADER TABEL END

//ISI TABEL
if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}

$result17=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian");
while ($rows17=mysql_fetch_array($result17)) {
	$datasecs_excel[]="'".$rows17[id]."'";
}
$data_excel=implode(",", $datasecs_excel);

$sql4=mysql_query("SELECT * FROM $nama_database_items WHERE induk IN ($data_excel)");
$jumlah_data=mysql_num_rows($sql4)*4+13;
$start_kolom=9;
$merge_kolom=11;
$nomor=1;
while ($rows4=mysql_fetch_array($sql4)) {
$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='$rows4[kode_barang]' AND nama='$rows4[material_description_po]' AND satuan='$rows4[satuan]'");
$mata_uang=$rows4['jenis_mata_uang'];
$start_kolom=$start_kolom+3;
$merge_kolom=$merge_kolom+3;

$no=0;for($i=0; $i < $nilai_column; ++$i){
  if ($jumlah_column[$no]=='no') {
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$nomor");
  }elseif ($jumlah_column[$no]=='foto') {
    //$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$nomor / $jumlah_data");
  }
	//TOTAL HARGA
	elseif($jumlah_column[$no]==harga) {
		if ($rows4[jenis_mata_uang]=='RP') {
			$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[price_rp]."");
			//echo "<td style='background-color:$color;'>".rupiah($rows4[amount_rp])."</td>";
		}elseif($rows4[jenis_mata_uang]=='USD') {
			$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[price_usd]."");
			//echo "<td style='background-color:$color;'>".dollar($rows4[amount_usd])."</td>";
		}elseif ($rows4[jenis_mata_uang]=='NT') {
			$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[price_nt]."");
			//echo "<td style='background-color:$color;'>".dollar($rows4[amount_nt])."</td>";
		}else{}
	//TOTAL HARGA
  }elseif($jumlah_column[$no]==total_harga) {
		if ($rows4[jenis_mata_uang]=='RP') {
			$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[amount_rp]."");
			//echo "<td style='background-color:$color;'>".rupiah($rows4[amount_rp])."</td>";
		}elseif($rows4[jenis_mata_uang]=='USD') {
			$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[amount_usd]."");
			//echo "<td style='background-color:$color;'>".dollar($rows4[amount_usd])."</td>";
		}elseif ($rows4[jenis_mata_uang]=='NT') {
			$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[amount_nt]."");
			//echo "<td style='background-color:$color;'>".dollar($rows4[amount_nt])."</td>";
		}else{}
  }
	//kepada,tanggal,po_purchasing,paymen_term,attn,note
	//kepada,tanggal,po_purchasing,paymen_term,attn,note
	elseif($jumlah_column[$no]=='kepada' OR $jumlah_column[$no]=='tanggal' OR $jumlah_column[$no]=='po_purchasing' OR $jumlah_column[$no]=='paymen_term' OR $jumlah_column[$no]=='attn' OR $jumlah_column[$no]=='note') {
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".ambil_database($jumlah_column[$no],$nama_database,"id='$rows4[induk]'")."");
	}


	else{
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "".$rows4[$jumlah_column[$no]]."");
  }
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("$jumlah_column_alpabet[$no]$start_kolom:$jumlah_column_alpabet[$no]$merge_kolom");//MERGE 3 BARIS
$no++;}

//MERGE 3 BARIS
$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$start_kolom:A$merge_kolom");//MERGE 3 BARIS
//MERGE 3 BARIS END
//GAMBAR FOTO LOGO
if ($nama_gambar_tampilan!='') {
$objDrawing = new PHPExcel_Worksheet_Drawing();$objDrawing->setName('test_img');
$objDrawing->setDescription("../../warehouse/gambarproduk/$nama_gambar_tampilan");
$objDrawing->setPath("../../warehouse/gambarproduk/$nama_gambar_tampilan");
$objDrawing->setCoordinates("X$start_kolom");
//setOffsetX works properly
$objDrawing->setOffsetX(5);$objDrawing->setOffsetY(5);
//set width, height
$objDrawing->setWidth(60);$objDrawing->setHeight(55);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
}//GAMBAR  FOTO LOGO END


$total_order=$rows4['qty_purchasing']+$total_order;
$total_rp=$rows4['amount_rp']+$total_rp;
$total_usd=$rows4['amount_usd']+$total_usd;
$total_nt=$rows4['amount_nt']+$total_nt;

$start_kolom++;$nomor++;$merge_kolom++;}
//ISI TABEL END

if ($mata_uang=='RP') {
	$total_uang=$total_rp;
}elseif($mata_uang=='USD') {
	$total_uang=$total_usd;
}elseif ($mata_uang=='NT') {
	$total_uang=$total_nt;
}else{}

// //TOTAL
// $kolom_total=$jumlah_data-2;
// $objPHPExcel->getActiveSheet()->setCellValue("A$kolom_total", "TOTAL");//Nama Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("I$kolom_total", "$total_order");//Nama Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("K$kolom_total", "$total_uang");//Nama Tanggal
// //$objPHPExcel->getActiveSheet()->setCellValue("M$kolom_total", "$total_rp");//Nama Tanggal
// //TOTAL END
//
// //Diskon
// $kolom_diskon=$jumlah_data-1;
// $objPHPExcel->getActiveSheet()->setCellValue("A$kolom_diskon", "DISCOUNT");//Nama Tanggal
// $jmlh_diskon=ambil_database(discount,$nama_database,"id='$id'");
//
// $grand_amount_usd_diskon=$total_usd*$jmlh_diskon/100;
// $grand_amount_rp_diskon=$total_rp*$jmlh_diskon/100;
// $grand_amount_nt_diskon=$total_nt*$jmlh_diskon/100;
//
// if ($mata_uang=='RP') {
// 	$total_amount_uang=$grand_amount_rp_diskon;
// }elseif($mata_uang=='USD') {
// 	$total_amount_uang=$grand_amount_usd_diskon;
// }elseif ($mata_uang=='NT') {
// 	$total_amount_uang=$grand_amount_usd_diskon;
// }else{}
//
// $objPHPExcel->getActiveSheet()->setCellValue("I$kolom_diskon", "$jmlh_diskon%");//Nama Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("K$kolom_diskon", "$total_amount_uang");//Nama Tanggal
// //$objPHPExcel->getActiveSheet()->setCellValue("M$kolom_diskon", "$grand_amount_rp_diskon");//Nama Tanggal
// //Diskon END
//
// //Setelah Diskon
// $objPHPExcel->getActiveSheet()->setCellValue("A$jumlah_data", "TOTAL");//Nama Tanggal
//
// $grand_amount_usd_setelah_diskon=$total_usd-$grand_amount_usd_diskon;
// $grand_amount_rp_setelah_diskon=$total_rp-$grand_amount_rp_diskon;
// $grand_amount_nt_setelah_diskon=$total_nt-$grand_amount_nt_diskon;
//
// if ($mata_uang=='RP') {
// 	$total_amount_uang_setelah_diskon=$grand_amount_rp_setelah_diskon;
// }elseif($mata_uang=='USD') {
// 	$total_amount_uang_setelah_diskon=$grand_amount_usd_setelah_diskon;
// }elseif ($mata_uang=='NT') {
// 	$total_amount_uang_setelah_diskon=$grand_amount_nt_setelah_diskon;
// }else{}
//
// $objPHPExcel->getActiveSheet()->setCellValue("I$jumlah_data", "");//Nama Tanggal
// $objPHPExcel->getActiveSheet()->setCellValue("K$jumlah_data", "$total_amount_uang_setelah_diskon");//Nama Tanggal
// //$objPHPExcel->getActiveSheet()->setCellValue("M$jumlah_data", "$grand_amount_rp_setelah_diskon");//Nama Tanggal
// //Setelah Diskon END

/**autosize*/
for ($col = 'A'; $col != 'U'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}/**autosize*/

//PERINTAH BORDER
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
)));
$objPHPExcel->getActiveSheet()->getStyle("A11:X$jumlah_data")->applyFromArray($styleArray);
unset($styleArray);
//PERINTAH BORDER END

//PERINTAH MERGER
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C10:E10');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H6:L6');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H7:L7');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H8:L8');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H9:L9');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H10:L10');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C1:L5');
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jumlah_data:H$jumlah_data");
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells("L$jumlah_data:R$jumlah_data");
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$kolom_total:H$kolom_total");
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells("L$kolom_total:R$kolom_total");
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$kolom_diskon:H$kolom_diskon");
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells("L$kolom_diskon:R$kolom_diskon");
//PERINTAH MERGER END

//PERINTAH BOLD
$objPHPExcel->getActiveSheet()->getStyle("A11:X11")->getFont()->setBold( true );
$objPHPExcel->getActiveSheet()->getStyle("A$jumlah_data:X$jumlah_data")->getFont()->setBold( true );
//PERINTAH BOLD END


$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=po_purchasing_$nomor_po.xls");
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
