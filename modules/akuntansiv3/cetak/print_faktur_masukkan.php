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
//START FUNCTION END


$akhir_periode1=$_GET['akhir_periode1'];
$akhir_periode2=$_GET['akhir_periode2'];


//PECAH
$column_items='tanggal,pembeli,no_npwp,no_faktur,no_invoice_masukkan,no_pendaftaran,no_aju,jenis_doc,keterangan,amount_rp,ppn,nilai,hasil,departement,kasbank_cash_flow,outstanding,amount_usd,tgl_bayar,no_voucher,tidak_dipungut_dpp,tidak_dipungut_ppn,dipungut_dpp,dipungut_ppn,pembelian_bahan_baku_import,pembelian_bahan_penolong_produksi,jenis_faktur';//,pembelian_bahan_pembungkus,biaya_administrasi,biaya_pengiriman,biaya_kalibrasi,biaya_printing_sublimation,biaya_peralatan_produksi,biaya_maintenance,biaya_sewa_mesin_fotocopy,biaya_pengangkutan,biaya_pemeliharaan_kendaraan,biaya_pemeliharaan_mesin,biaya_listrik,air,telp_dan_internet,biaya_asuransi,biaya_penyusutan_mesin_peralatan,biaya_alat_listrik_alat_mekanik,biaya_bea_masuk_import,biaya_keperluan_pabrik,biaya_laboratorium_test,biaya_perlengkapan_kantor,biaya_iuran,biaya_pengobatan,biaya_keperluan_kantor,biaya_perijinan,biaya__bphtb_pbb,biaya_pemeliharaan_gedung,biaya_makan_minum,biaya_sewa_kendaraan,biaya_pemeliharaan_inv_kantor,biaya_angkut,biaya_adm_import,biaya_pajak,biaya_entertainment,biaya_bpjs,biaya_management_sdm,biaya_tips

$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai,aj,ak,al,am,an,ao,ap,aq,ar,as,at,au,av,aw,ax,ay,az,ba,bb,bc,bd,be,bf,bg,bh,bi,bj,bk,bl,bm,bn,bo,bp,bq,br,bs,bt,bu,bv,bw,bx,by,bz';
$nilai_column=nilai_pecah($column_items);

$jumlah_column=pecah($column_items);
$jumlah_column_alpabet=pecah($alpabet);
//PECAH END


require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();




//HEADER TABEL
$no=0;for($i=0; $i < $nilai_column; ++$i){
	$name=ambil_database(ina,master_bahasa,"kode='".$jumlah_column[$no]."'");
  $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]1", "$name");
$no++;}
//HEADER TABEL END


//ISI TABEL
$sql=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE tanggal BETWEEN '$akhir_periode1' AND '$akhir_periode2' AND no_faktur !='00000000%' AND no_faktur !='' ORDER BY tanggal ASC");
$urutan_bawah=2;
while ($rows=mysql_fetch_array($sql)) {

    $no=0;for($i=0; $i < $nilai_column; ++$i){
      $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$urutan_bawah", $rows[$jumlah_column[$no]]);
    $no++;}

$urutan_bawah++;}
//ISI TABEL END






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
	cellColor("K1:K500", "ffff00");//FAKTUR MASUKKAN
	cellColor("M1:M500", "ffff00");//FAKTUR MASUKKAN
	cellColor("P1:P500", "ffff00");//FAKTUR MASUKKAN
	cellColor("T1:W500", "ffff00");//FAKTUR MASUKKAN
	cellColor("Y1:Y500", "ffff00");//FAKTUR MASUKKAN








$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Faktur Masukkan $akhir_periode1 - $akhir_periode2.xls");
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