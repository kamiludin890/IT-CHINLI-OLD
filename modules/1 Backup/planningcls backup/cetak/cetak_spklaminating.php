<?php //KONEKSI DATABASE
session_start();
ob_start();
error_reporting(0);
include('../../../koneksi.php');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

//$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
//$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);

$connection=mysql_connect(s('db_server'), s('db_user'), s('db_password')) or die(mysql_error()) ;
mysql_select_db(s('db_name'));

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function tampil_td($username,$id,$nama_database_items){
$script_ttd=ambil_database(script_ttd,pusat_ttd_items,"id_dokumen='$id' AND nama_database='$nama_database_items' AND nama_ttd='$username'");
$test="{'lines':[[";$test1="$script_ttd";$test2="]]});}";
if($script_ttd==''){$induk='';}else{$induk=$test."".$test1."".$test2;}
$test_script="$username";
echo "
<html>
    <head>
        <title>Tanda Tangan Berbasis Web</title>
        <link rel='stylesheet' href='../../ttd/js-lib/jquery.signature.css' />
        <link rel='stylesheet' href='../../ttd/js-lib/jquery-ui.css' />
        <link rel='stylesheet' href='../../ttd/js-lib/jquery.signature.css' />
        <script src='../../ttd/js-lib/jquery.min.js' type='text/javascript' ></script>
        <script src='../../ttd/js-lib/jquery-ui.min.js' type='text/javascript' > </script>
        <script src='../../ttd/js-lib/jquery.signature.js' type='text/javascript' ></script>
        <script src='../../ttd/js-lib/jquery.ui.touch-punch.min.js' type='text/javascript' ></script>
        <style>
            .kbw-signature{
              height: 900px;
              width: 900px;
              zoom: 15%;
            }
        </style>
        <script>
            $(function(){
                $('#tandatangan').signature({guideline: true});

                $('#draw$test_script').click(function(){
                    var json = $('#tandatangan').signature('toJSON');
                    $('#$test_script').signature('draw',$induk);

                $('#$test_script').signature({disabled: true, guideline: true});
                });
        </script>
    </head>
    <body>
        <p>
            <button id='draw$test_script' hidden>Tampil Tanda Tangan</button>
            <script type='text/javascript'>
            $(document).ready(function() {
              $('#draw$test_script').trigger('click');
            })
            </script>
        </p>
        <div id='$test_script'></div>
    </body>
</html>";
}

function qr_code($id){
	include "../../qrcode/qrlib.php";
	$tempdir = "../gambarqrcode/"; //Nama folder tempat menyimpan file qrcode
	if (!file_exists($tempdir)) //Buat folder bername temp
		 mkdir($tempdir);
		 //isi qrcode jika di scan
		 $codeContents=$id;
	//simpan file kedalam folder temp dengan nama 001.png
	QRcode::png($codeContents,$tempdir."$id-SPK-LAMINATING.png");
	//menampilkan file qrcode
}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}
// START FUNCTION ?>

<?php // START AREA PRINT
error_reporting(0);
$nama_database='planningcls_spklaminating';
$nama_database_items='planningcls_spklaminating_items';

//AMBIL POST
$id=$_POST['id'];
$bahasa=$_POST['bahasa'];
$username=$_POST['username'];
//AMBIL POST END

//TITLE
echo "<html>
<meta charset='UTF-8'>
<head><title>".ambil_database(no_spk,planningcls_spklaminating,"id='$id'")."</title></head>
<body>";
//END TITLE

include ('../style.css');

//JUDUL
echo "<h2 align='center'><img src='../gambarqrcode/$id-SPK-LAMINATING.png' width='100px' height='100px' align='right'/></h2>";
echo "<h1><center>CLS - 貼合</center></h1>";
echo "<h1><center>CLS - SPK LAMINATING</center></h1>";
//JUDUL END

//HEADER 1
echo "<table style='font-size:17px;'>";
echo "<tr>";
echo "<td>號碼/NOMOR</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(no_spk,planningcls_spklaminating,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>日期/TANGGAL</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(tanggal,planningcls_spklaminating,"id='$id'")."</td>";
echo "</tr>";
echo "</table>";
//HEADER 1 END

//HEADER 2
echo "<table class='tabel_utama' style='width:auto;'>";

echo "<tr style='background-color:#cccccc; font-weight:bold;'>";
echo "<th>顧客</th>";
echo "<th rowspan='2'>BUCKET</th>";
echo "<th>訂單號</th>";
echo "<th>線批</th>";
echo "<th>型體</th>";
echo "<th>布</th>";
echo "<th>材料</th>";
echo "<th colspan='2'>數量</th>";
echo "<th rowspan='2'>YIELD</th>";
echo "<th>備註</th>";
echo "<th rowspan='2'>STATUS</th>";
echo "</tr>";

echo "<tr style='background-color:#cccccc; font-weight:bold;'>";
echo "<th>CUSTOMER</th>";
echo "<th>PO NO</th>";
echo "<th>LINE BATCH</th>";
echo "<th>MODEL</th>";
echo "<th>KAIN</th>";
echo "<th>FOAM</th>";
echo "<th>SHEET</th>";
echo "<th>YARD</th>";
echo "<th>KETERANGAN</th>";
echo "</tr>";
//HEADER 2 END

//ISI KOLOM
$isi_kolom='customer,bucket_stage,po_nomor,line_batch,model,textile,foam,sheet,yard,yield,keterangan,status';
$pecah_isi_kolom=pecah($isi_kolom);
$nilai_pecah_isi_kolom=nilai_pecah($isi_kolom);

$result2=mysql_query("SELECT id,id_sales_po,tgl_revisi,$isi_kolom FROM planningcls_spklaminating_items WHERE induk='$id'");
while ($rows2=mysql_fetch_array($result2)) {
echo "<tr style='height:25px;'>";
$no=0;for($i=0; $i < $nilai_pecah_isi_kolom; ++$i){
	if ($pecah_isi_kolom[$no]==textile) {
		echo "<td style='background-color:$color;'>".ambil_database(nama,inventory_lokasi_items,"kode='$rows2[textile]' AND kategori='KAIN'")."</td>";
	}elseif ($pecah_isi_kolom[$no]==foam) {
		echo "<td style='background-color:$color;'>".ambil_database(nama,inventory_lokasi_items,"kode='$rows2[foam]' AND kategori='FOAM'")."</td>";
	}else{
		echo "<td style='background-color:$color;'>".$rows2[$pecah_isi_kolom[$no]]."</td>";
	}
$no++;}
echo "</tr>";
$total_sheet=$rows2['sheet']+$total_sheet;
$total_yard=$rows2['yard']+$total_yard;
}

//TOTAL
echo "<tr style='height:30px; font-weight:bold;'>";
	echo "<td colspan='7' style='font-size:12px;'>TOTAL</td>";
	echo "<td style='font-size:12px;'>$total_sheet</td>";
	echo "<td style='font-size:12px;'>$total_yard</td>";
	echo "<td colspan='3'></td>";
echo "<tr>";
//TOTAL END
echo "</table></br>";


echo "<table rules='cols' style='font-size:15px; width:60%; border:1px solid; text-align:center;'>";

	echo "<tr>";
			echo "<td style='border:1px solid; width:25%;'>Dibuat Oleh</td>";
			echo "<td style='border:1px solid; width:25%;'>Kepala Bagian</td>";
			echo "<td style='border:1px solid; width:25%;'>Mengetahui</td>";
			echo "<td style='border:1px solid; width:25%;'>Menyetujui</td>";
	echo "</tr>";

	echo "<tr style='height:100px;'>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
	echo "</tr>";

	echo "<tr>";
			echo "<td style='border:1px solid;'>$username</td>";
			echo "<td style='border:1px solid;'></td>";
			echo "<td style='border:1px solid;'></td>";
			echo "<td style='border:1px solid;'></td>";
	echo "</tr>";

echo "<table>";


//PENANDA TANGAN
echo "<table>";
$list_penanda_tangan=ambil_database(penanda_tangan,pusat_ttd,"nama_database='$nama_database_items'");
$pecah_ttd=explode (",",$list_penanda_tangan);
$jumlah_ttd=count($pecah_ttd);

echo "<tr>";
$no=0;for($i=0; $i < $jumlah_ttd; ++$i){
	echo "<td style='text-align:center;'></td>";//$pecah_ttd[$no]
$no++;}
echo "</tr>";
echo "<tr>";
$no=0;for($i=0; $i < $jumlah_ttd; ++$i){
		echo "<td style='width:auto; height:auto; align:center; color:red;'>";
		echo tampil_td($pecah_ttd[$no],$id,$nama_database_items);
		echo "</td>";
$no++;}
echo "</tr>";

echo "</table>";
//PENANDA TANGAN END

echo qr_code($id);

//PERINTAH PRINT
echo "<script>";
echo "
var css = '@page { size: landscape; }',
head = document.head || document.getElementsByTagName('head')[0],
style = document.createElement('style');
style.type = 'text/css';
style.media = 'print';
if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}
head.appendChild(style);
window.print();
</script>";
//PERINTAH PRINT END

echo "
</body>
</html>";

ob_end_flush();
 // END AREA PRINT ?>
