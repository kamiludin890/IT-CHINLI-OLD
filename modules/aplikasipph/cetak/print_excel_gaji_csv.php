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
$column_items='masa_pajak,tahun_pajak,pembetulan,nomor_bukti_potong,dari_bulan,sampai_bulan,npwp_pegawai,nik,nama_pegawai,alamat_pegawai,jenis_kelamin,status_ptkp,jumlah_tanggungan,jabatan,karyawan_asing,kode_negara,kode_pajak,pensiunan_atau_jht,tunjangan_pph,tunjangan_lainnya,honarium,premi_asuransi,natura_pph21,bonus_thr,penghasilan_bruto,biaya_jabatan1,iuran_pensiun,jumlah_pengurang,penghasilan_netto,penghasilan_netto_sebelumnya,penghasilan_netto_setahun,ptkp,penghasilan_kena_pajak,pph_terutang,pph_sebelumnya,pph_terutang,pph_terutang,status_pindah,nip_pimpinan,nama_pimpinan,tanggal_bukti';


$alpabet='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,ab,ac,ad,ae,af,ag,ah,ai,aj,ak,al,am,an,ao,ap,aq,ar,as,at,au,av,aw,ax,ay,az,ba,bb,bc,bd,be,bf,bg,bh,bi,bj,bk,bl,bm,bn,bo,bp,bq,br,bs,bt,bu,bv,bw,bx,by,bz';
$nilai_column=nilai_pecah($column_items);

$jumlah_column=pecah($column_items);
$jumlah_column_alpabet=pecah($alpabet);


$header_items='Masa Pajak,Tahun Pajak,Pembetulan,Nomor Bukti Potong,Masa Perolehan Awal,Masa Perolehan Akhir,NPWP,NIK,Nama,Alamat,Jenis Kelamin,Status PTKP,Jumlah Tanggungan,Nama Jabatan,WP Luar Negeri,Kode Negara,Kode Pajak,Jumlah 1,Jumlah 2,Jumlah 3,Jumlah 4,Jumlah 5,Jumlah 6,Jumlah 7,Jumlah 8,Jumlah 9,Jumlah 10,Jumlah 11,Jumlah 12,Jumlah 13,Jumlah 14,Jumlah 15,Jumlah 16,Jumlah 17,Jumlah 18,Jumlah 19,Jumlah 20,Status Pindah,NPWP Pemotong,Nama Pemotong,Tanggal Bukti Potong';
$pecah_header=pecah($header_items);
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
  $name=$pecah_header[$no];
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
	//MASA PAJAK
  if ($jumlah_column[$no]=='masa_pajak') {
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "12");
  }
	//TAHUN PAJAK
	elseif($jumlah_column[$no]=='tahun_pajak') {
		$tahun_pajak=ambil_database(tahun_pajak,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'");//-1
    $objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$tahun_pajak");
  }
	//PEMBETULAN
	elseif($jumlah_column[$no]=='pembetulan') {
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "0");
  }
	//NOMOR BUKTI POTONG
	elseif($jumlah_column[$no]=='nomor_bukti_potong') {
		$tahun_pajak_2_digit=substr(ambil_database(tahun_pajak,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'"),2,2);//1
		$nomor_tahun=$tahun_pajak_2_digit-1;
		$urut=ambil_database(urut,aplikasipph_gaji,"id='$rows4[id]'");//10
		$jumlah_karakter_nol20=7-strlen(ambil_database(urut,aplikasipph_gaji,"id='$rows4[id]'"));
		if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
		if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
		if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
		if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
		if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}
		if($jumlah_karakter_nol20=='5'){$hasil_nol='00000';}
		if($jumlah_karakter_nol20=='6'){$hasil_nol='000000';}
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "1.1-12.$nomor_tahun-$hasil_nol$urut");
	}
	//STATUS PTKP
	elseif($jumlah_column[$no]=='status_ptkp') {
		$status_ptkp_penentu=ambil_database(status_ptkp,aplikasipph_gaji,"id='$rows4[id]'");
				if ($status_ptkp_penentu=='TK/0') {$k='TK';}
				if ($status_ptkp_penentu=='TK/1') {$k='TK';}
				if ($status_ptkp_penentu=='TK/2') {$k='TK';}
				if ($status_ptkp_penentu=='TK/3') {$k='TK';}
				if ($status_ptkp_penentu=='K/0') {$k='K';}
				if ($status_ptkp_penentu=='K/1') {$k='K';}
				if ($status_ptkp_penentu=='K/2') {$k='K';}
				if ($status_ptkp_penentu=='K/3') {$k='K';}
				if ($status_ptkp_penentu=='K/I/0') {$k='KI';}
				if ($status_ptkp_penentu=='K/I/1') {$k='KI';}
				if ($status_ptkp_penentu=='K/I/2') {$k='KI';}
				if ($status_ptkp_penentu=='K/I/3') {$k='KI';}
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$k");
	}
	//JUMLAH TANGGUNGAN
	elseif($jumlah_column[$no]=='jumlah_tanggungan') {
		$status_ptkp_penentu=ambil_database(status_ptkp,aplikasipph_gaji,"id='$rows4[id]'");
				if ($status_ptkp_penentu=='TK/0') {$k='0';}
				if ($status_ptkp_penentu=='TK/1') {$k='1';}
				if ($status_ptkp_penentu=='TK/2') {$k='2';}
				if ($status_ptkp_penentu=='TK/3') {$k='3';}
				if ($status_ptkp_penentu=='K/0') {$k='0';}
				if ($status_ptkp_penentu=='K/1') {$k='1';}
				if ($status_ptkp_penentu=='K/2') {$k='2';}
				if ($status_ptkp_penentu=='K/3') {$k='3';}
				if ($status_ptkp_penentu=='K/I/0') {$k='0';}
				if ($status_ptkp_penentu=='K/I/1') {$k='1';}
				if ($status_ptkp_penentu=='K/I/2') {$k='2';}
				if ($status_ptkp_penentu=='K/I/3') {$k='3';}
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$k");
	}
	//JENIS KELAMIN
	elseif($jumlah_column[$no]=='jenis_kelamin') {
		$jenis_kelamin1=ambil_database(jenis_kelamin,aplikasipph_gaji,"id='$rows4[id]'");
		if ($jenis_kelamin1=='PEREMPUAN'){$jenis_kelamin='F';}elseif($jenis_kelamin1=='LAKI-LAKI'){$jenis_kelamin='M';}else{}
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$jenis_kelamin");
	}
	//KODE PAJAK
	elseif($jumlah_column[$no]=='kode_pajak') {
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "21-100-01");
	}
	//NIP PIMPINAN
	elseif($jumlah_column[$no]=='nip_pimpinan') {
		$nip_pimpinan=ambil_database(nip_pimpinan,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'");
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$nip_pimpinan");
	}
	//NIP PIMPINAN
	elseif($jumlah_column[$no]=='nama_pimpinan') {
		$nama_pimpinan=ambil_database(nama_pimpinan,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'");
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$nama_pimpinan");
	}
	//NIP PIMPINAN
	elseif($jumlah_column[$no]=='tanggal_bukti') {
		$tanggal_bukti=ambil_database(tanggal_bukti,aplikasipph_entry,"nama_instansi='PT. CHINLI PLASTIC TECHNOLOGY INDONESIA'");
		$objPHPExcel->getActiveSheet()->setCellValue("$jumlah_column_alpabet[$no]$start_kolom", "$tanggal_bukti");
	}
	//TAMPILAN SEBENARNYA
	else{
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
//
// //PERINTAH COLOR CELL
// function cellColor($cells,$color){
//     global $objPHPExcel;
//
//     $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
//         'type' => PHPExcel_Style_Fill::FILL_SOLID,
//         'startcolor' => array(
//              'rgb' => $color
//         )
//     ));
// }
//
// cellColor("A2:A$jumlah_data", "FF0000");
// cellColor("C2:E$jumlah_data", "FF0000");
// cellColor("R2:R$jumlah_data", "FF0000");
// cellColor("AH2:AH$jumlah_data", "FF0000");
// cellColor("AJ2:AJ$jumlah_data", "FF0000");
// cellColor("AL2:AL$jumlah_data", "FF0000");
// cellColor("AY2:AY$jumlah_data", "FF0000");
// cellColor("BB2:BF$jumlah_data", "FF0000");
// cellColor("BH2:BK$jumlah_data", "FF0000");
// //PERINTAH COLOR CELL END
// }




$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=data_karyawan.xls");
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
