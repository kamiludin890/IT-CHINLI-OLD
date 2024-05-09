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
	QRcode::png($codeContents,$tempdir."$id-PACKINGLIST.png");
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
$nama_database='deliverycls_packing_list';
$nama_database_items='deliverycls_packing_list_items';

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
				<td style='width:25%;'><h2 align='center'><img src='../gambarqrcode/$id-PACKINGLIST.png' width='100px' height='100px' align='right'/></h2></td>
			</tr>";

echo "<tr>
				<td colspan='3'><center><h2>PACKING LIST</h2><center></td>
			</tr>";
echo "<table>";
//HEADER PERTAMA END

//HEADER KEDUA
echo "<table style='width:100%; font-weight:bold; font-size:15px;'>";
echo "<tr>";
echo "<td style='width:80%;'>CONSIGNEE</td>";
echo "<td style='width:10%;'>INVOICE</td>";
echo "<td style='width:10%;'>: ".ambil_database(no_invoice,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>".ambil_database(dari,$nama_database,"id='$id'")."</td>";
echo "<td>DATE</td>";
echo "<td>: ".ambil_database(tanggal,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td rowspan='2' >".ambil_database(alamat,$nama_database,"id='$id'")."</td>";
echo "<td>DUE DATE</td>";
echo "<td>: ".ambil_database(tanggal_batas,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>KK NO</td>";
echo "<td>: ".ambil_database(no_kk,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='3'><center>NOTIFY PARTY</center></td>";
echo "</tr>";
echo "<table>";
//HEADER KEDUA END



//ISI TABEL 2
$id_sales_po=ambil_database(id,sales_po,"po_nomor='".ambil_database(po_nomor,$nama_database_items,"induk='$id'")."' AND line_batch='".ambil_database(line_batch,$nama_database_items,"induk='$id'")."'");
$id_items=ambil_database(id,planningcls_spkcuttingdies,"no_spk_cutting='".ambil_database(no_spk_cutting,$nama_database_items,"induk='$id'")."'");

$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));

//TOTAL COLSPAN
$total_size_colspan=$nilai_pecah1+$nilai_pecah2+$nilai_pecah3+3;
echo "$total_size_colspan";
//TOTAL COLSPAN END


echo "<table class='tabel_utama'>";
echo "<thead>";
echo "<th>NO</th>";
echo "<th>KOMPONENT</th>";
echo "<th>PO</th>";
echo "<th>ORDER CODE</th>";
echo "<th>MATERAL DESCRIPTION</th>";
echo "<th>MODEL</th>";
echo "<th colspan='$total_size_colspan'>SIZE</th>";
echo "<th>QTY</br>(".ambil_database(satuan,sales_po,"id='$id_sales_po'").")</th>";
echo "<th>KEMASAN</th>";
echo "<th colspan='2'>WEIGHT(KG)</th>";
echo "</thead>";

$number=1;
$result8=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows8=mysql_fetch_array($result8)){//START ARRAY

echo "<tr>";
echo "<td rowspan='5'>$number</td>";
echo "<td rowspan='5'>$rows8[komponent]</td>";
echo "<td rowspan='5'>$rows8[po_nomor]</td>";
echo "<td rowspan='5'>$rows8[style_item_kode]</td>";
echo "<td rowspan='5'>$rows8[material_description_po]</td>";
echo "<td rowspan='5'>$rows8[model]</td>";
echo "</tr>";

$id_sales_po=ambil_database(id,sales_po,"po_nomor='$rows8[po_nomor]' AND line_batch='$rows8[line_batch]'");
$id_items=ambil_database(id,planningcls_spkcuttingdies,"no_spk_cutting='$rows8[no_spk_cutting]'");
$no_spk_cutting=$rows8['no_spk_cutting'];
$id_cuttingdies=ambil_database(id,planningcls_spkcuttingdies,"no_spk_cutting='$rows8[no_spk_cutting]'");
$bucket_stage=ambil_database(bucket_stage,sales_po,"id='$id_sales_po'");
$line_batch=ambil_database(line_batch,sales_po,"id='$id_sales_po'");
$po_nomor=ambil_database(po_nomor,sales_po,"id='$id_sales_po'");

//NILAI SIZE DAN COUNT
$pecah1=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah1=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size1,sales_po,"id='$id_sales_po'")."'"));
$pecah2=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah2=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size2,sales_po,"id='$id_sales_po'")."'"));
$pecah3=pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
$nilai_pecah3=nilai_pecah(ambil_database(size,sales_mastersize,"kode_ukuran='".ambil_database(size3,sales_po,"id='$id_sales_po'")."'"));
//NILAI SIZE DAN COUNT END

//SALES PO
echo "<tr>";
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
  echo "<td colspan='$nilai_pecah1'>".ambil_database(logo1,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size1,sales_po,"id='$id_sales_po'")."</td>";
  echo "<td rowspan='4'></td>";}else{$pengganti1=1;}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
  echo "<td colspan='$nilai_pecah2'>".ambil_database(logo2,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size2,sales_po,"id='$id_sales_po'")."</td>";
  echo "<td rowspan='4'></td>";}else{$pengganti2=1;}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
  echo "<td colspan='$nilai_pecah3'>".ambil_database(logo3,sales_po,"id='$id_sales_po'")." ".ambil_database($bahasa,pusat_bahasa,"kode='size_us'")." ".ambil_database(size3,sales_po,"id='$id_sales_po'")."</td>";
  echo "<td rowspan='4'></td>";}else{$pengganti3=1;}
//SALES PO END

$kolom_tidak_ada=$pengganti1+$pengganti2+$pengganti3;
if ($pengganti1==1) {
$total_pengganti1=$total_size_colspan-$nilai_pecah2-$nilai_pecah3;
}
if ($pengganti2==1) {
$total_pengganti2=$total_size_colspan-$nilai_pecah1-$nilai_pecah3;
}
if ($pengganti3==1) {
$total_pengganti3=$total_size_colspan-$nilai_pecah1-$nilai_pecah2;
}
if ($kolom_tidak_ada>=1) {
$grand_total_pengganti=$total_pengganti1+$total_pengganti2+$total_pengganti3;
$grand_total_pengganti_bagi=$grand_total_pengganti/$kolom_tidak_ada;
echo "<td colspan='$grand_total_pengganti_bagi' rowspan='4'>$total_pengganti1</td>";
}

//TOTAL QTY
$total_sum_spk=total_sum_spk($nilai_pecah1,$pecah1,$nilai_pecah2,$pecah2,$nilai_pecah3,$pecah3,deliverycls_packing_qty_proces,$rows8[id]);
echo "<td rowspan='4'>$total_sum_spk</td>";
//TOTAL QTY END

echo "<td>$rows8[kemasan]</td>";//KEMASAN
echo "<td>GW</td>";//BERAT KOTOR
echo "<td>NW</td>";//BERAT BERSIH
echo "</tr>";

//SIZE
echo "<tr>";
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	echo "<td style='background-color:$color1;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah1[$no]'")."</td>";$no++;}
	}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	echo "<td style='background-color:$color2;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah2[$no]'")."</td>";$no++;}
	}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
	$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	echo "<td style='background-color:$color3;'>".ambil_database($bahasa,pusat_bahasa,"kode='$pecah3[$no]'")."</td>";$no++;}
	}
//SIZE END

echo "<td rowspan='3'>$rows8[jumlah_kemasan]</td>";//KEMASAN
echo "<td rowspan='3'>$rows8[berat_kotor]</td>";//BERAT KOTOR
echo "<td rowspan='3'>$rows8[berat_bersih]</td>";//BERAT BERSIH
echo "</tr>";


//LIST SIZE
echo "<tr>";
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
$result1=mysql_query("SELECT * FROM planningcls_spkcuttingdies_items WHERE induk='$id_cuttingdies' AND logo='logo1' ORDER BY id");
$rows1=mysql_fetch_array($result1);
	$sisa_belum_dikerjakan_size1=$rows1[$pecah1[$no]]-qty_proses_per_size($no_spk_cutting,$pecah1[$no],logo1);
	//echo "<td style='background-color:$color1; width:18px;'>$sisa_belum_dikerjakan_size1 </br>".ambil_database(satuan,sales_po,"id='$id_sales_po'")."</td>";
$no++;
}}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
$result2=mysql_query("SELECT * FROM planningcls_spkcuttingdies_items WHERE induk='$id_cuttingdies' AND logo='logo2' ORDER BY id");
$rows2=mysql_fetch_array($result2);
	$sisa_belum_dikerjakan_size2=$rows2[$pecah2[$no]]-qty_proses_per_size($no_spk_cutting,$pecah2[$no],logo2);
	//echo "<td style='background-color:$color2; width:18px;'>$sisa_belum_dikerjakan_size2 </br>".ambil_database(satuan,sales_po,"id='$id_sales_po'")."</td>";
$no++;
}}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
$result3=mysql_query("SELECT * FROM planningcls_spkcuttingdies_items WHERE induk='$id_cuttingdies' AND logo='logo3' ORDER BY id");
$rows3=mysql_fetch_array($result3);
	$sisa_belum_dikerjakan_size3=$rows3[$pecah3[$no]]-qty_proses_per_size($no_spk_cutting,$pecah3[$no],logo3);
	//echo "<td style='background-color:$color3; width:18px;'>$sisa_belum_dikerjakan_size3 </br>".ambil_database(satuan,sales_po,"id='$id_sales_po'")."</td>";
$no++;
}}
echo "</tr>";
//LIST SIZE END


//QTY PAIRS
echo "<tr>";
if (ambil_database(size1,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah1; ++$i){
	$result1=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows8[id]' AND logo='logo1' ORDER BY id");
	$rows1=mysql_fetch_array($result1);
	$sisa_belum_dikerjakan_size1=ambil_database($pecah1[$no],planningcls_spkcuttingdies_items,"induk='$id_cuttingdies' AND logo='logo1'")-qty_proses_per_size($no_spk_cutting,$pecah1[$no],logo1);//
	echo "<input type='hidden' name='$pecah1[$no]_pembatas' value='$sisa_belum_dikerjakan_size1'>";
	echo "<td style='background-color:$color1; width:15px;'>".$rows1[$pecah1[$no]]."</td>";
$no++;}
echo "</form>";}
if (ambil_database(size2,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah2; ++$i){
	$result2=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows8[id]' AND logo='logo2' ORDER BY id");
	$rows2=mysql_fetch_array($result2);
	$sisa_belum_dikerjakan_size2=ambil_database($pecah2[$no],planningcls_spkcuttingdies_items,"induk='$id_cuttingdies' AND logo='logo2'")-qty_proses_per_size($no_spk_cutting,$pecah2[$no],logo2);//
	echo "<input type='hidden' name='$pecah2[$no]_pembatas' value='$sisa_belum_dikerjakan_size2'>";
	echo "<td style='background-color:$color2; width:15px;'>".$rows2[$pecah2[$no]]."</td>";
$no++;}
echo "</form>";}
if (ambil_database(size3,sales_po,"id='$id_sales_po'")!='') {
echo "<form method='POST' action='$address'>";
$no=0;for($i=0; $i < $nilai_pecah3; ++$i){
	$result3=mysql_query("SELECT * FROM deliverycls_packing_qty_proces WHERE induk='$rows8[id]' AND logo='logo3' ORDER BY id");
	$rows3=mysql_fetch_array($result3);
	$sisa_belum_dikerjakan_size3=ambil_database($pecah3[$no],planningcls_spkcuttingdies_items,"induk='$id_cuttingdies' AND logo='logo3'")-qty_proses_per_size($no_spk_cutting,$pecah3[$no],logo3);//
	echo "<input type='hidden' name='$pecah3[$no]_pembatas' value='$sisa_belum_dikerjakan_size3'>";
	echo "<td style='background-color:$color3; width:15px;'>".$rows3[$pecah3[$no]]."</td>";
$no++;}
echo "</form>";}
echo "</tr>";
//QTY PAIRS END

$grand_total_pairs=$total_sum_spk+$grand_total_pairs;
$grand_total_jumlah_kemasan=$rows8[jumlah_kemasan]+$grand_total_jumlah_kemasan;
$grand_total_berat_kotor=$rows8[berat_kotor]+$grand_total_berat_kotor;
$grand_total_berat_bersih=$rows8[berat_bersih]+$grand_total_berat_bersih;
$number++;}//END ARRAY

$total=$total_size_colspan+6;
echo "<tr style='height:40px;'>
			<td colspan='$total'>TOTAL</td>
			<td colspan=''>$grand_total_pairs</td>
			<td colspan=''>$grand_total_jumlah_kemasan</td>
			<td colspan=''>$grand_total_berat_kotor</td>
			<td colspan=''>$grand_total_berat_bersih</td>
			</tr>";

echo "</table>";
//ISI TABEL 2 END

//PENANDA TANGAN
echo "<table style='width:100%;'>";
$list_penanda_tangan=ambil_database(penanda_tangan,pusat_ttd,"nama_database='$nama_database'");
$pecah_ttd=explode (",",$list_penanda_tangan);
$jumlah_ttd=count($pecah_ttd);

echo "<tr>
			<td style='text-align:left;'>Penerima</td>
			<td style='text-align:right;'>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</td>
			</tr>";

echo "<tr>
			<td style='text-align:left;'></td>
			<td style='text-align:right;'>".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</td>
			</tr>";

echo "<tr>";

 $no=0;for($i=0; $i < $jumlah_ttd; ++$i){
	 	if ($pecah_ttd[$no]==signature) {
			echo "<td style='text-align:left; color:red;'>";
			echo tampil_td($pecah_ttd[$no],$id,$nama_database);
			echo "</td>";
	 	}else {
			echo "<td style='text-align:right; color:red;'>";
			echo tampil_td($pecah_ttd[$no],$id,$nama_database);
			echo "</td>";
	 	}
 $no++;}

echo "</tr>";

echo "<tr>
			<td>Warehouse</td>
			<td style='text-align:right;'>Warehouse</td>
			</tr>";

// echo "<tr>";
// $no=0;for($i=0; $i < $jumlah_ttd; ++$i){
// 		echo "<td style='width:auto; height:auto; align:center; color:red;'>";
// 		echo tampil_td($pecah_ttd[$no],$id,$nama_database);
// 		echo "</td>";
// $no++;}
// echo "</tr>";
//
// echo "<tr>";
// $no=0;for($i=0; $i < $jumlah_ttd; ++$i){
// 	echo "<td style='text-align:center;'>$pecah_ttd[$no]</td>";
// $no++;}
// echo "</tr>";

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
