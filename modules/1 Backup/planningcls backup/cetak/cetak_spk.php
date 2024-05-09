<?php //KONEKSI DATABASE
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
//KONEKSI DATABASE?>

<?php // START FUNCTION

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
	QRcode::png($codeContents,$tempdir."$id-SPK.png");
	//menampilkan file qrcode
}


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
// START FUNCTION ?>

<?php // START AREA PRINT
include ('../style.css');
error_reporting(0);
$nama_database='planningcls_spkcuttingdies';
$nama_database_items='planningcls_spkcuttingdies_items';

//AMBIL POST
$id=$_POST['id'];
$bahasa=$_POST['bahasa'];
//AMBIL POST END

//TITLE
echo "<html>
<head><title>".ambil_database(no_spk_cutting,planningcls_spkcuttingdies,"id='$id'")."</title></head>
<body>";
//END TITLE

//HEADER
echo "<h2 align='center'>".ambil_database($bahasa,master_bahasa,"kode='spk'")."<img src='../gambarqrcode/$id-SPK.png' width='100px' height='100px' align='right'/></br>".ambil_database(no_spk_cutting,planningcls_spkcuttingdies,"id='$id'")."</br></h2>";
echo "<h3>".ambil_database(tanggal,$nama_database,"id='$id'")."</h3>";



echo "<table style='width:100%;'>";
echo "<tr>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='nama_klien'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='model'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='yield'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='komponent'")." :</td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='spesifikasi_bahan_kain'")." :</td>";
echo "</tr>";
echo "<tr>";
echo "<td>".ambil_database(dari,$nama_database,"id='$id'")."</td>";
echo "<td>".ambil_database(model,$nama_database,"id='$id'")."</td>";
echo "<td>".ambil_database(yield,$nama_database,"id='$id'")."</td>";
echo "<td>".ambil_database(komponent,$nama_database,"id='$id'")."</td>";
echo "<td>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(textile,$nama_database,"id='$id'")."' AND kategori='KAIN'")."</td>";
echo "</tr>";

echo "<tr>";
echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='bahan_spesifikasi_foam'")." :</td>";
echo "</tr>";echo "<tr>";
echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(foam,$nama_database,"id='$id'")."' AND kategori='FOAM'")."</td>";
echo "</tr>";echo "<table>";

echo "<table align='center'>
			<tr><td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='artikel'")." :</td></tr>
			<tr><td>".ambil_database(style_item_kode,$nama_database,"id='$id'")."</td></tr>
			</table>";
//HEADER END



//ISI TABEL START
echo "<table style='width:auto;' class='tabel_utama'>";

//NILAI SIZE DAN COUNT
$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,$nama_database,"id='$id'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,$nama_database,"id='$id'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,$nama_database,"id='$id'")."'"));

//COLOR 1 2 3
$color1='#00FFFF';
$color2='';
$color3='#00FFFF';

echo "<thead>";//BARIS 1
echo "<th colspan='5'>".ambil_database($bahasa,pusat_bahasa,"kode='spesifikasi_kertas_embos'")."</th>";
if (ambil_database(size1,$nama_database,"id='$id'")!='') {
echo "<th colspan='$nilai_pecah1'>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(logo1,$nama_database,"id='$id'")."' AND kategori='LOGO'")."  (".ambil_database(size1,$nama_database,"id='$id'").")</th>";}
if (ambil_database(size2,$nama_database,"id='$id'")!='') {
echo "<th colspan='$nilai_pecah2'>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(logo2,$nama_database,"id='$id'")."' AND kategori='LOGO'")."  (".ambil_database(size2,$nama_database,"id='$id'").")</th>";}
if (ambil_database(size3,$nama_database,"id='$id'")!='') {
echo "<th colspan='$nilai_pecah3'>".ambil_database(nama,inventory_lokasi_items,"kode='".ambil_database(logo3,$nama_database,"id='$id'")."' AND kategori='LOGO'")."  (".ambil_database(size3,$nama_database,"id='$id'").")</th>";}
echo "</thead>";//BARIS 1 END

echo "<tr>";//BARIS 2
echo "<td colspan='5'>".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")."</td>";
if (ambil_database(size1,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
echo "<td style='background-color:$color1;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah1[$no]'")."</td>";$no++;}}
if (ambil_database(size2,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
echo "<td style='background-color:$color2;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah2[$no]'")."</td>";$no++;}}
if (ambil_database(size3,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
echo "<td style='background-color:$color3;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah3[$no]'")."</td>";$no++;}}
echo "</tr>";//BARIS 2 END


$po_nomor=ambil_database(po_nomor,$nama_database,"id='$id'");
$result6=mysql_query("SELECT * FROM $nama_database WHERE po_nomor='$po_nomor' ORDER BY line_batch");
$total_result6=mysql_num_rows($result6);

$rowspan_baris_3_4=1+$total_result6;

echo "<tr>";//BARIS 3 DAN 4
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database($bahasa,pusat_bahasa,"kode='po_nomor'")."</td>";
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database($bahasa,pusat_bahasa,"kode='line'")."</td>";
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database($bahasa,pusat_bahasa,"kode='bucket'")."</td>";
echo "<td rowspan='$rowspan_baris_3_4'>".ambil_database(satuan,sales_mastermodel,"id='".ambil_database(id_yield,$nama_database,"id='$id'")."'")."</td>";

//TOTAL NILAI SUM
$po_nomor=ambil_database(po_nomor,$nama_database,"id='$id'");
$result6=mysql_query("SELECT * FROM $nama_database WHERE po_nomor='$po_nomor' ORDER BY line_batch");
$total_result6=mysql_num_rows($result6);
while ($rows6=mysql_fetch_array($result6)) {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
$nilai=ambil_database($pecah1[$no],$nama_database_items,"induk='$rows6[id]' AND logo='logo1'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah1[$no]."'");
$nilai1=substr($nilai, 0,4); $total_nilai1=$nilai1+$total_nilai1;
$no++;}
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
$nilai=ambil_database($pecah2[$no],$nama_database_items,"induk='$rows6[id]' AND logo='logo2'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah2[$no]."'");
$nilai2=substr($nilai, 0,4); $total_nilai2=$nilai2+$total_nilai2;
$no++;}
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
$nilai=ambil_database($pecah3[$no],$nama_database_items,"induk='$rows6[id]' AND logo='logo3'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah3[$no]."'");
$nilai3=substr($nilai, 0,4); $total_nilai3=$nilai3+$total_nilai3;
$no++;}
$total_seluruh=$total_nilai1+$total_nilai2+$total_nilai3;
}
echo "<td rowspan='$rowspan_baris_3_4'>".ceil($total_seluruh)."</td>";
//TOTAL NILAI SUM END

//BARIS 3
if (ambil_database(size1,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
echo "<td style='background-color:$color1; width:100px;'>".ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah1[$no]."'")." PRS</td>"; $no++;}}
if (ambil_database(size2,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
echo "<td style='background-color:$color2; width:100px;'>".ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah2[$no]."'")." PRS</td>"; $no++;}}
if (ambil_database(size3,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
echo "<td style='background-color:$color3; width:100px;'>".ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah3[$no]."'")." PRS</td>"; $no++;}}
//BARIS 3 END
echo "</tr>";//BARIS 3 DAN 4
echo "<tr>";//BARIS 4

//BARIS 4
$result7=mysql_query("SELECT * FROM $nama_database WHERE po_nomor='$po_nomor' ORDER BY line_batch");
$total_result7=mysql_num_rows($result7);
while ($rows7=mysql_fetch_array($result7)) {

if (ambil_database(size1,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
$nilai=ambil_database($pecah1[$no],$nama_database_items,"induk='$rows7[id]' AND logo='logo1'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah1[$no]."'");
$nilai1=substr($nilai, 0,4);
echo "<td style='background-color:$color1;'>$nilai1</td>"; $no++;}}

if (ambil_database(size2,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
$nilai=ambil_database($pecah2[$no],$nama_database_items,"induk='$rows7[id]' AND logo='logo2'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah2[$no]."'");
$nilai2=substr($nilai, 0,4);
echo "<td style='background-color:$color2;'>$nilai2</td>"; $no++;}}

if (ambil_database(size3,$nama_database,"id='$id'")!='') {
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
$nilai=ambil_database($pecah3[$no],$nama_database_items,"induk='$rows7[id]' AND logo='logo3'")/ambil_database(qty_customer,sales_mastermodel_items,"induk='".ambil_database(id_yield,$nama_database,"id='$id'")."' AND size='".$pecah3[$no]."'");
$nilai3=substr($nilai, 0,4);
echo "<td style='background-color:$color3;'>$nilai3</td>"; $no++;}}
//BARIS 4 END
echo "</tr>";//BARIS 4 END
}

//Baris 5
echo "<tr>";
$lebar_seluruh_kolom=5+$nilai_pecah1+$nilai_pecah2+$nilai_pecah3;
echo "<td colspan='$lebar_seluruh_kolom' style='height:50px;'></td>";
echo "</tr>";
//Baris 5 END

$result5=mysql_query("SELECT * FROM $nama_database WHERE po_nomor='$po_nomor' AND id='$id' ORDER BY line_batch");
$total_result5=mysql_num_rows($result5);
while ($rows5=mysql_fetch_array($result5)) {
echo "<tr>";//BARIS 6
echo "<td>".ambil_database(po_nomor,$nama_database,"id='$rows5[id]'")."</td>";
echo "<td>".ambil_database(line_batch,$nama_database_items,"induk='$rows5[id]'")."</td>";
echo "<td>".ambil_database(bucket_stage,$nama_database_items,"induk='$rows5[id]'")."</td>";
echo "<td>".ambil_database($bahasa,pusat_bahasa,"kode='total'")."</td>";
    //TOTAL NILAI SUM SPK
		echo "<td>";
		echo total_sum_spk($nilai_pecah1,$pecah1,$nilai_pecah2,$pecah2,$nilai_pecah3,$pecah3,$nama_database_items,$rows5[id]);
		echo "</td>";
    //TOTAL NILAI SUM SPK END
if (ambil_database(size1,$nama_database,"id='$rows5[id]'")!='') {
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$result1=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$rows5[id]' AND logo='logo1' ORDER BY id");
	$rows1=mysql_fetch_array($result1);
	echo "<td style='background-color:$color1; width:18px;'>".$rows1[$pecah1[$no]]."</td>"; $no++;}}

//SAVE KETIGA
if (ambil_database(size2,$nama_database,"id='$rows5[id]'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$result2=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$rows5[id]' AND logo='logo2' ORDER BY id");
	$rows2=mysql_fetch_array($result2);
	echo "<td style='background-color:$color2; width:28px;'>".$rows2[$pecah2[$no]]."</td>"; $no++;}}
//SAVE KETIGA END
//SAVE KEEMPAT
if (ambil_database(size3,$nama_database,"id='$rows5[id]'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$result3=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$rows5[id]' AND logo='logo3' ORDER BY id");
	$rows3=mysql_fetch_array($result3);
	echo "<td style='background-color:$color3; width:38px;'>".$rows3[$pecah3[$no]]."</td>"; $no++;}}
//SAVE KEEMPAT END
echo "</tr>";//BARIS 6 END
}

//Baris 7
echo "<tr>";
$lebar_seluruh_kolom=5+$nilai_pecah1+$nilai_pecah2+$nilai_pecah3;
echo "<td colspan='$lebar_seluruh_kolom' style='height:50px;'></td>";
echo "</tr>";
//Baris 7 END

//PISAH TABLE
echo "</table>";
echo "<table class='tabel_utama' border='0' cellpadding='5' cellspacing='0' style='width:50%;float:left'><tbody>";

//BARIS 8
echo "<tr>";
echo "<td colspan='4'>".ambil_database($bahasa,pusat_bahasa,"kode='mohon_dipacking_menjadi'")."</td>";
echo "<td>".ambil_database(box,$nama_database_items,"induk='$id'")."</td>";
echo "<td colspan='2'>".ambil_database($bahasa,pusat_bahasa,"kode='box'")."</td>";
echo "<td colspan='10' rowspan='2'></td>";
echo "</tr>";
//BARIS 8 END

//Baris 9
//CARI TOTAL QTY PO
$po_nomor=ambil_database(po_nomor,$nama_database,"id='$id'");
$result1=mysql_query("SELECT * FROM sales_po WHERE po_nomor='$po_nomor'");
while ($rows1=mysql_fetch_array($result1)){$nilai_qty_po=$rows1['qty_po']+$nilai_qty_po;}
//CARI TOTAL QTY PO END

echo "<tr>";
echo "<td colspan='4'>".ambil_database($bahasa,pusat_bahasa,"kode='qty_po'")."</td>";
echo "<td colspan='1'>$nilai_qty_po</td>";
echo "<td colspan='2'>".ambil_database($bahasa,pusat_bahasa,"kode='pairs'")."</td>";
echo "</tr>";
//Baris 9 END

//Baris 10
//START ARAY ITEM SPK
$result4=mysql_query("SELECT distinct line_batch,induk FROM $nama_database_items WHERE po_nomor='$po_nomor' ORDER BY line_batch");
$count4=mysql_num_rows($result4);//BAGI LOGO 1,2,3
$rowspan4=$count4+1;
echo "<tr>";
echo "<td rowspan='$rowspan4' colspan='4'>".ambil_database($bahasa,pusat_bahasa,"kode='qty_spk'")."</td>";
echo "</tr>";
while ($rows4=mysql_fetch_array($result4)) {
if ($id == $rows4[induk]){$color="style='background-color:yellow;'";}else{$color='';}
echo "<tr>";

echo "<td width='80px' $color >".ambil_nilai_logo_spk($rows4['induk'],$nama_database,$rows4['induk'],$nama_database_items)."</td>";
echo "<td width='80px' $color colspan='2'>".ambil_database($bahasa,pusat_bahasa,"kode='pairs'")."</td>";

echo "<td width='80px' $color >".ambil_database($bahasa,pusat_bahasa,"kode='line'")."</td>";
echo "<td width='80px' $color >$rows4[line_batch]</td>";

echo "<td width='80px' $color >".ambil_database($bahasa,pusat_bahasa,"kode='status'")."</td>";
echo "<td width='80px' $color >".ambil_database(status,$nama_database,"id='$rows4[induk]'")."</td>";

if ($id == $rows4[induk]){echo "<td style='height:20px; width:80px; background-color:yellow;'>".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."</td>";}else{
	echo "<td><center>";
	echo "";
	echo "</td>";}

$total_jumlah_spk=ambil_nilai_logo_spk($rows4['induk'],$nama_database,$rows4['induk'],$nama_database_items)+$total_jumlah_spk;
}//END ARAY ITEM SPK
echo "</tr>";
echo "<tr>
<td colspan='4'>TOTAL</td>
<td colspan='1'>$total_jumlah_spk</td>
<td colspan='7'></td>
</tr>";
echo "</tbody></table>";
//Baris 10 END

echo "<table border='1' cellpadding='5' cellspacing='0' style='width:auto; float:right; margin-right:20px;'><tbody>";
echo "<tr>";
	if (ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
		echo "<td><center>";
			echo "Logo 1";
		echo "</center></td>";
	}else{}
	if (ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
		echo "<td><center>";
			echo "Logo 2";
		echo "</center></td>";
	}else {}
	if (ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
		echo "<td><center>";
			echo "Logo 3";
		echo "</center></td>";
	}else{}
echo "</tr>";

echo "<tr>";
	if (ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
			$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='".ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			$id_foto=ambil_database(id,inventory_barang,"kode='".ambil_database(logo1,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			echo "<td>";
				echo '<a href="#" onClick="window.open(\''."modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan&id=$id_foto&nama_database=inventory_barang".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='../../warehouse/gambarproduk/$nama_gambar_tampilan' width='200px' height='auto'/>".'</a>';
			echo "</td>";
	}else{}
	if (ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
			$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='".ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			$id_foto=ambil_database(id,inventory_barang,"kode='".ambil_database(logo2,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			echo "<td>";
			  echo '<a href="#" onClick="window.open(\''."modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan&id=$id_foto&nama_database=inventory_barang".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='../../warehouse/gambarproduk/$nama_gambar_tampilan' width='80px' height='100px'/>".'</a>';
			echo "</td>";
	}else {}
	if (ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")) {
			$nama_gambar_tampilan=ambil_database(foto,inventory_barang,"kode='".ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			$id_foto=ambil_database(id,inventory_barang,"kode='".ambil_database(logo3,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database,"id='$id'")."'")."'");
			echo "<td>";
			  echo '<a href="#" onClick="window.open(\''."modules/warehouse/gambarproduk/tampil_foto.php?gambar=$nama_gambar_tampilan&id=$id_foto&nama_database=inventory_barang".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='../../warehouse/gambarproduk/$nama_gambar_tampilan' width='80px' height='100px'/>".'</a>';
			echo "</td>";
	}else{}
echo "</tr>";
echo "</tbody></table>";
//END TABEL

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
 // END AREA PRINT ?>
