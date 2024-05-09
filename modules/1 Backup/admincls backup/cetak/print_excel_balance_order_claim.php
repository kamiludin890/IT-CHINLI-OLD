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

function format_tanggal_faktur($tanggal){
$tgl=substr($tanggal,8,2);
$bulan=substr($tanggal,5,2);
$tahun=substr($tanggal,0,4);
$tanggal="$tgl/$bulan/$tahun";
return $tanggal;}

function rubah_decimal($angka){
	//$nilai = "" . number_format($angka,2,'.',',');
	$nilai=number_format($angka,2);
	$hasil=preg_replace("/,/","", $nilai);
	$hasil2="$hasil";
return $angka;}

function total_setelah_diskon($induk,$id){
	$kurs=ambil_database(kurs,financecl_kurs,"tanggal='".ambil_database(tanggal,deliverycl_invoice,"id='$id'")."'");
	$discount=ambil_database(discount,deliverycl_invoice,"id='$id'");
	$ppn=10;
	$result=mysql_query("SELECT * FROM deliverycl_invoice_items WHERE induk='$induk' ORDER BY id");
	while ($rows=mysql_fetch_array($result)) {
	//AMOUNT
	if ($rows[jenis_mata_uang]=='USD') {
		$dirupiahkan_amount=$rows['amount']*$kurs;
	}else{
		$dirupiahkan_amount=$rows['amount'];
	}
	//DISKON
	$hasil_diskon=$dirupiahkan_amount*$discount/100;
	//SETELAH DI KURANG DISKON
	$hasil_dikurang_diskon=$dirupiahkan_amount-$hasil_diskon;
	//PPN
	$hasil_ppn=$hasil_dikurang_diskon*$ppn/100;
	//TOTAL SETELAH DISKON
	$total_hasil_dikurang_diskon=$hasil_dikurang_diskon+$total_hasil_dikurang_diskon;
	//TOTAL PPN
	$total_hasil_ppn=$hasil_ppn+$total_hasil_ppn;}
return floor($total_hasil_dikurang_diskon);}

function total_setelah_ppn($induk,$id){
	$kurs=ambil_database(kurs,financecl_kurs,"tanggal='".ambil_database(tanggal,deliverycl_invoice,"id='$id'")."'");
	$discount=ambil_database(discount,deliverycl_invoice,"id='$id'");
	$ppn=10;
	$result=mysql_query("SELECT * FROM deliverycl_invoice_items WHERE induk='$induk' ORDER BY id");
	while ($rows=mysql_fetch_array($result)) {
	//AMOUNT
	if ($rows[jenis_mata_uang]=='USD') {
		$dirupiahkan_amount=$rows['amount']*$kurs;
	}else{
		$dirupiahkan_amount=$rows['amount'];
	}
	//DISKON
	$hasil_diskon=$dirupiahkan_amount*$discount/100;
	//SETELAH DI KURANG DISKON
	$hasil_dikurang_diskon=$dirupiahkan_amount-$hasil_diskon;
	//PPN
	$hasil_ppn=$hasil_dikurang_diskon*$ppn/100;
	//TOTAL SETELAH DISKON
	$total_hasil_dikurang_diskon=$hasil_dikurang_diskon+$total_hasil_dikurang_diskon;
	//TOTAL PPN
	$total_hasil_ppn=$hasil_ppn+$total_hasil_ppn;}
return floor($total_hasil_ppn);}
//START FUNCTION END


$column_items='NO,TANGGAL,PENGIRIM,JENIS PO,NOMOR PO,BUCKET,KODE BARANG,MATERIAL DESCRIPTION,SATUAN,QTY ORDER,QTY DI TERIMA,SISA';
$nilai_column=nilai_pecah($column_items);
$jumlah_column=pecah($column_items);

// $column_items2='LT,NPWP,NAMA,JALAN,BLOK,NOMOR,RT,RW,KECAMATAN,KELURAHAN,KABUPATEN,PROPINSI,KODE_POS,NOMOR_TELEPON';
// $nilai_column2=nilai_pecah($column_items2);
// $jumlah_column2=pecah($column_items2);
//
// $column_items3='OF,KODE_OBJEK,NAMA,HARGA_SATUAN,JUMLAH_BARANG,HARGA_TOTAL,DISKON,DPP,PPN,TARIF_PPNBM,PPNBM';
// $nilai_column3=nilai_pecah($column_items3);
// $jumlah_column3=pecah($column_items3);

$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai,aj,ak,al,am,an,ao,ap,aq,ar,as,at,au,av,aw,ax,ay,az,ba,bb,bc,bd,be,bf,bg,bh,bi,bj,bk,bl,bm,bn,bo,bp,bq,br,bs,bt,bu,bv,bw,bx,by,bz';
$jumlah_column_alpabet=pecah($alpabet);
//PECAH END


require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

//BARIS 1
$no=0;for($i=0; $i < $nilai_column; ++$i){
		    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]1", "".$jumlah_column[$no]."");
$no++;}


$pilihan_tahun=$_GET['pilihan_tahun'];
$pilihan_bulan=$_GET['pilihan_bulan'];
$pilihan_pencarian=$_GET['pilihan_pencarian'];
$pencarian=$_GET['pencarian'];
if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
$result=mysql_query("SELECT * FROM admin_claim_purchasing WHERE status='Proses' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian ORDER BY tanggal");
$i=2;
$no_id=1;
while ($rows=mysql_fetch_array($result)){

	//BARIS 2
	$objPHPExcel->getActiveSheet()->setCellValue("a$i", "$no_id");
	$objPHPExcel->getActiveSheet()->setCellValue("b$i", "$rows[tanggal]");
	$objPHPExcel->getActiveSheet()->setCellValue("c$i", "$rows[kepada]");
	$objPHPExcel->getActiveSheet()->setCellValue("d$i", "$rows[jenis_po_purchasing]");
	$objPHPExcel->getActiveSheet()->setCellValue("e$i", "$rows[po_purchasing]");

	//BARIS 2 ROWSPAN
	$r = $i;
	$result1=mysql_query("SELECT * FROM admin_claim_purchasing_items WHERE induk='$rows[id]'");
	while ($rows1=mysql_fetch_array($result1)) {
	$urutan_item=$r;

		//OF
		$objPHPExcel->getActiveSheet()->setCellValue("f$urutan_item", "$rows1[etd]");
		$objPHPExcel->getActiveSheet()->setCellValue("g$urutan_item", "$rows1[kode_barang]");
		$objPHPExcel->getActiveSheet()->setCellValue("h$urutan_item", "$rows1[material_description_po]");
		$objPHPExcel->getActiveSheet()->setCellValue("i$urutan_item", "$rows1[satuan]");
		$objPHPExcel->getActiveSheet()->setCellValue("j$urutan_item", "$rows1[qty_purchasing]");

		//TOTAL QTY MASUK
		$result14=mysql_query("SELECT SUM(qty) as tqty FROM admin_claim_purchasing_dokumen_masuk WHERE induk='$rows[id]' AND kodebarang='$rows1[kode_barang]'");
		$rows14=mysql_fetch_array($result14);
		$objPHPExcel->getActiveSheet()->setCellValue("k$urutan_item", "$rows14[tqty]");

		//SISA STOCK
		$sisa=$rows1[qty_purchasing]-$rows14[tqty];
		$objPHPExcel->getActiveSheet()->setCellValue("l$urutan_item", "$sisa");


	$r++;}

$i=$r+1;
$no_id++;}






$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=balance_order_claim.xls");
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');

header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
