<?php //KONEKSI DATABASE
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
//KONEKSI DATABASE?>

<?php // START FUNCTION

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function total_sum_spk($nilai_pecah1,$pecah1,$nilai_pecah2,$pecah2,$nilai_pecah3,$pecah3,$nama_database_items,$id){
	//TOTAL NILAI SUM SPK
	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$nilai_spk1=ambil_database($pecah1[$no],$nama_database_items,"induk='$id' AND logo='logo1'");
	$total_nilai_spk1=$nilai_spk1+$total_nilai_spk1;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$nilai_spk2=ambil_database($pecah2[$no],$nama_database_items,"induk='$id' AND logo='logo2'");
	$total_nilai_spk2=$nilai_spk2+$total_nilai_spk2;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$nilai_spk3=ambil_database($pecah3[$no],$nama_database_items,"induk='$id' AND logo='logo3'");
	$total_nilai_spk3=$nilai_spk3+$total_nilai_spk3;
	$no++;}
	$total_seluruh_spk1=$total_nilai_spk1+$total_nilai_spk2+$total_nilai_spk3;
return $total_seluruh_spk1;}

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
	QRcode::png($codeContents,$tempdir."$id-SURAT-JALAN.png");
	//menampilkan file qrcode
}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
return $hasil_rupiah;}

function dollar($angka){
$hasil_rupiah = "$ " . number_format($angka,3,',','.');
return $hasil_rupiah;}

function ambil_nilai_logo_spk($induk,$nama_database,$id,$nama_database_items){
	$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
	$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
	$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
	$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
	$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));
	$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));

	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$nilai_spk1_kedua=ambil_database($pecah1[$no],$nama_database_items,"induk='$induk' AND logo='logo1'");
	$total_nilai_spk1_kedua=$nilai_spk1_kedua+$total_nilai_spk1_kedua;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$nilai_spk2_kedua=ambil_database($pecah2[$no],$nama_database_items,"induk='$induk' AND logo='logo2'");
	$total_nilai_spk2_kedua=$nilai_spk2_kedua+$total_nilai_spk2_kedua;
	$no++;}
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$nilai_spk3_kedua=ambil_database($pecah3[$no],$nama_database_items,"induk='$induk' AND logo='logo3'");
	$total_nilai_spk3_kedua=$nilai_spk3_kedua+$total_nilai_spk3_kedua;
	$no++;}
	$total_seluruh_spk1_kedua=$total_nilai_spk1_kedua+$total_nilai_spk2_kedua+$total_nilai_spk3_kedua;
	return $total_seluruh_spk1_kedua;}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function ambil_variabel_kutip_satu_where($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode("','", $datasecs);
	$hasil="'".$data."'";
return $hasil;}

function ambil_variabel_tanpa_kutip_where_distinct($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT DISTINCT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode(",", $datasecs);
	$hasil="".$data."";
return $hasil;}

function qty_proses_per_size($no_spk_cutting,$nama_kolom,$logo){
	$ambil_variabel_size1=ambil_variabel_tanpa_kutip_where_distinct(deliverycls_packing_list_items,id,"WHERE no_spk_cutting='$no_spk_cutting' ORDER BY induk");
	$pecah_size1=pecah($ambil_variabel_size1);
	$nilai_pecah_size1=nilai_pecah($ambil_variabel_size1);
	$no_size1=0;for($i_size1=0; $i_size1 < $nilai_pecah_size1; ++$i_size1){
	 $nilai_qty_size1=ambil_database($nama_kolom,deliverycls_packing_qty_proces,"induk='$pecah_size1[$no_size1]' AND logo='$logo'")+$nilai_qty_size1;
	$no_size1++;}
return $nilai_qty_size1;}

// START FUNCTION ?>

<?php // START AREA PRINT
include ('../style.css');
error_reporting(0);
$nama_database='deliverycls_surat_jalan';
//$nama_database_items='deliverycls_packing_list_items';

//AMBIL POST
$id=$_POST['id'];
$bahasa=$_POST['bahasa'];
$username=$_POST['username'];
//AMBIL POST END

//TITLE
echo "<html>
<head><title>".ambil_database(po_purchasing,$nama_database,"id='$id'")."</title></head>
<body>";
//END TITLE

//HEADER PERTAMA
echo "<table style='width:100%;'>";
echo "<tr>
				<td style='width:25%;'><center><img src='../../gambar/logo_chinli.png' width='30%'/><center></td>
				<td style='width:50%;'><center><img src='../../gambar/logo_lengkap2.png' width='100%'/><center></td>
				<td style='width:25%;'><h2 align='center'><img src='../gambarqrcode/$id-SURAT-JALAN.png' width='100px' height='100px' align='right'/></h2></td>
			</tr>";

echo "<tr>
				<td colspan='3'><center><h2>SURAT JALAN</h2><center></td>
			</tr>";
echo "<table>";
//HEADER PERTAMA END


//HEADER KEDUA
echo "<table style='width:100%; font-weight:bold; font-size:12px;'>";
echo "<tr>";
echo "<td style='width:70%;'>CONSIGNEE</td>";
echo "<td style='width:10%;'>INVOICE</td>";
echo "<td style='width:20%;'>: ".ambil_database(no_invoice,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>".ambil_database(dari,$nama_database,"id='$id'")."</td>";
echo "<td>DATE</td>";
echo "<td>: ".ambil_database(tanggal,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td rowspan='2' >".ambil_database(alamat,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='3'>STYLE : ".ambil_database(komponent,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<table>";
//HEADER KEDUA END


echo "<table style='width:80%; margin-top:10px; margin-bottom:10px;'>";
	echo "<tr>";
	echo "<td>Nomor Dokumen BC 27</td>";
	echo "<td>:</td>";
	echo "<td>".ambil_database(no_dokumen_bc27,$nama_database,"id='$id'")."</td>";
	echo "<td>Nomor Aju BC 27</td>";
	echo "<td>:</td>";
	echo "<td>".ambil_database(no_aju_bc27,$nama_database,"id='$id'")."</td>";
	echo "<td>Tanggal BC 27</td>";
	echo "<td>:</td>";
	echo "<td>".ambil_database(tanggal_dokumen_bc27,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "</table>";
//HEADER KETIGA END

//ISI KOLOM
echo "<table class='tabel_utama' style='width:100%;'>";

//HEADER
echo "<thead>";
	echo "<th>PO #</th>";
	echo "<th>MODEL</th>";
	echo "<th>SPEC</th>";
	echo "<th>TOTAL</br>(PAIRS)</th>";
	echo "<th colspan='100'>SIZE/QTY</th>";
echo "</thead>";
//HEADER END

//ISI TABEL
$id_packing_list=ambil_database(id_packing_list,$nama_database,"id='$id'");
$result=mysql_query("SELECT * FROM deliverycls_packing_list_items WHERE induk='$id_packing_list'");
while ($rows=mysql_fetch_array($result)){

//ID SALES PO
//ID SALES PO END
$id_sales_po=ambil_database(id,sales_po,"po_nomor='$rows[po_nomor]' AND line_batch='$rows[line_batch]'");

//NILAI SIZE DAN COUNT
$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
//NILAI SIZE DAN COUNT END

//TOTAL ROWSPAN
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {$pengganti1=1;}else{$pengganti1=0;}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {$pengganti2=1;}else{$pengganti2=0;}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {$pengganti3=1;}else{$pengganti3=0;}
$total_pengganti1=$pengganti1+$pengganti2+$pengganti3;
$total_pengganti=$total_pengganti1*3+1;
//TOTAL ROWSPAN

echo "<tr>";
	echo "<td rowspan='$total_pengganti'>$rows[po_nomor] - $rows[line_batch]</td>";
	echo "<td rowspan='$total_pengganti'>$rows[model]</td>";
	echo "<td rowspan='$total_pengganti'>$rows[material_description_po]</td>";
	echo "<td rowspan='$total_pengganti'>$rows[total_pairs]</td>";
echo "</tr>";

//-------------------------------------------------------------------------------------------------- 1
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
echo "<tr>";
  echo "<td colspan='100'>".ambil_database(logo1,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size1,sales_po,"id='$id_sales_po'")."</td>";
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
echo "<td style='background-color:$color1;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah1[$no]'")."</td>";$no++;}
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$result1=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows[id]' AND logo='logo1' ORDER BY id");
	$rows1=mysql_fetch_array($result1);
	echo "<td>".$rows1[$pecah1[$no]]."</td>";
$no++;}
echo "</tr>";}
//-------------------------------------------------------------------------------------------------- 1

//-------------------------------------------------------------------------------------------------- 2
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
echo "<tr>";
  echo "<td colspan='100'>".ambil_database(logo2,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size2,sales_po,"id='$id_sales_po'")."</td>";
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
echo "<td style='background-color:$color2;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah2[$no]'")."</td>";$no++;}
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$result2=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows[id]' AND logo='logo2' ORDER BY id");
	$rows2=mysql_fetch_array($result2);
	echo "<td>".$rows2[$pecah2[$no]]."</td>";
$no++;}
echo "</tr>";
}
//-------------------------------------------------------------------------------------------------- 2

//-------------------------------------------------------------------------------------------------- 3
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
echo "<tr>";
echo "<td colspan='100'>".ambil_database(logo3,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size3,sales_po,"id='$id_sales_po'")."</td>";
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
echo "<td style='background-color:$color3;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah3[$no]'")."</td>";$no++;}
echo "</tr>";

echo "<tr>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$result3=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows[id]' AND logo='logo3' ORDER BY id");
	$rows3=mysql_fetch_array($result3);
	echo "<td>".$rows3[$pecah3[$no]]."</td>";
	$no++;}
echo "</tr>";
}
//-------------------------------------------------------------------------------------------------- 3

$grand_total_pairs=$rows['total_pairs']+$grand_total_pairs;
}//ISI TABEL END

//TOTAL
echo "<tr>";
echo "<td colspan='2'></td>";
echo "<td style='font-size:12px;'>TOTAL</td>";
echo "<td style='font-size:12px;'>$grand_total_pairs</td>";
echo "<td colspan='100'></td>";
echo "</tr>";
//TOTAL END

//LAINNYA
echo "<tr>";
echo "<td colspan='2' style='font-size:12px; text-align:left;'>
KET :	</br>
RANGKAP 1: DISIMPAN (PUTIH)	</br>
RANGKAP 2: FINANCE (MERAH) </br>
RANGKAP 3: PRODUKSI (KUNING) </br>
RANGKAP 4: CLIENT (BIRU) </br>
RANGKAP 5: CUSTOM
</td>";
echo "<td colspan='2' style='font-size:15px;'>No Invoice : </br>".ambil_database(no_invoice,$nama_database,"id='$id'")."</td>";
echo "<td colspan='100' style='font-size:10px; text-align:left; vertical-align:top;'>TANDA TANGAN & CAP PENERIMA</td>";
echo "</tr>";
//LAINNYA END

echo "</table>";
//ISI KOLOM END

echo "<table style='width:100%; font-weight:bold; font-size:20px; text-align:center;'>";
echo "<tr>";
echo "<td>Security</td>";
echo "<td>Supir</td>";
echo "<td>Pengisi Form</td>";
echo "<td>Kepala Bagian</td>";
echo "<td>Kepala Divisi</td>";
echo "</tr>";
echo "</table>";


echo qr_code($id);

//PERINTAH PRINT
echo "<script>";
echo "
var css = '@page { size: portrait; }',
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
 // END AREA PRINT ?>
