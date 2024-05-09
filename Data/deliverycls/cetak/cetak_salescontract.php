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
        <div style='margin-left:15%;' id='$test_script'></div>
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
	QRcode::png($codeContents,$tempdir."$id-SALES-CONTRACT.png");
	//menampilkan file qrcode
}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
return $hasil_rupiah;}

function dollar($angka){
$hasil_rupiah = "$ " . number_format($angka,3,',','.');
return $hasil_rupiah;}

function dollar_2($angka){
$hasil_rupiah = "$ " . number_format($angka,2,',','.');
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

function nilai_per_satuan($jumlah_nilai_satuan,$nama_database_items,$id,$satuan,$kolom){
 $result3=mysql_query("SELECT $kolom FROM $nama_database_items WHERE induk='$id' AND satuan='$satuan'");
 	while ($rows3=mysql_fetch_array($result3)){
	$harga_per_satuan=$rows3[$kolom]+$harga_per_satuan;
 }
 return $harga_per_satuan;}

// START FUNCTION ?>

<?php // START AREA PRINT
include ('../style.css');
error_reporting(0);
$nama_database='deliverycls_sales_contract';
$nama_database_items='deliverycls_sales_contract_items';

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
				<td style='width:25%;'><h2 align='center'><img src='../gambarqrcode/$id-SALES-CONTRACT.png' width='100px' height='100px' align='right'/></h2></td>
			</tr>";
echo "<table>";

echo "<table style='width:100%; margin-top:20px;'>";
echo "<tr><td><center><h2>SALES CONTRACT</br>".ambil_database(no_sales_contract,$nama_database,"id='$id'")."</h2><center></td></tr>";
echo "</table>";
//HEADER PERTAMA END


//HEADER KEDUA
echo "<table>";
echo "<tr>";
echo "<td>Yang bertanda tangan dibawah ini</td>";
echo "<td>:</td>";
echo "<tr>";
echo "</table>";

echo "<table style='width:100%; text-align:left;'>";
echo "<tr>";
echo "<td>1.</td>";
echo "<td style='width:130px;'>NAMA</td>";
echo "<td>:</td>";
echo "<td>LU HUNG TA</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>JABATAN</td>";
echo "<td>:</td>";
echo "<td>DIREKTUR</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>ALAMAT</td>";
echo "<td>:</td>";
echo "<td>Jl. Millenium Raya Blok L3 No.1A,Kawasan Millenium, Kel.Peusar</td>";
echo "<tr>";
echo "</table>";
//HEADER KEDUA END

//HEADER KETIGA
echo "<table style='margin-top:20px;'>";
echo "<tr>";
echo "<td>Bertindak untuk dan atas nama PT CHINLI PLASTIC TECHNOLOGY INDONESIA Yang berkedudukan di Jl. Millenium Raya Blok L3 No.1A,Kawasan Millenium,</br>
Kel.Peusar, Kec. Panongan,Kab.Tangerang,Banten</br>
Yang mengeluarkan barang untuk tujuan dijual selanjutnya disebut pihak I (Pertama)</td>";
echo "<tr>";
echo "<table>";

echo "<table style='width:100%; text-align:left; margin-top:20px;'>";
echo "<tr>";
echo "<td>2.</td>";
echo "<td style='width:130px;'>NAMA</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(nama_penerima_barang,$nama_database,"id='$id'")."</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>JABATAN</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(jabatan_penerima_barang,$nama_database,"id='$id'")."</td>";
echo "<tr>";

echo "<tr>";
echo "<td></td>";
echo "<td>ALAMAT</td>";
echo "<td>:</td>";
echo "<td>".ambil_database(alamat,$nama_database,"id='$id'")."</td>";
echo "<tr>";
echo "</table>";
//HEADER KETIGA END


//HEADER KEEMPAT
echo "<table style='margin-top:20px;'>";
echo "<tr>";
echo "<td>Dalam hal ini bertindak untuk dan atas nama ".ambil_database(dari,$nama_database,"id='$id'").", sebagai pembeli barang, yang selanjutnya disebut</br>
sebagai Pihak II (Kedua).</td>";
echo "<tr>";
echo "</table>";

echo "<table style='margin-top:20px;'>";
echo "<tr>";
echo "<td>Pihak I (Pertama) dan Pihak II (Kedua) dengan ini mengadakan Kontrak Jual Beli.</br>Perjanjian Jual Beli ini diatur sebagai Berikut :</td>";
echo "</tr>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px;'>ARTICLE I: COMMODITY</td>";
echo "</tr>";
echo "</table>";
//HEADER KEEMPAT END

echo "<table style='margin-top:20px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 1</td>";
echo "</tr>";
echo "</table>";

echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>a. Pihak II (Kedua) membeli barang dari Pihak I  (Pertama), dengan Uraian sebagai berikut :</td>";
echo "</tr>";
echo "</table>";


echo "<table class='tabel_utama' style='margin-top:5px; width:100%;'>";
echo "<thead>";
echo "<th>No</th>";
echo "<th>GOODS DESCRIPTION</th>";
echo "<th>PO NO</th>";
echo "<th colspan='2'>QUANTITY</th>";
echo "<th>UNIT PRICE (USD)</th>";
echo "<th>AMOUNT (USD)</th>";
echo "</thead>";

$no=1;
$result1=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows1=mysql_fetch_array($result1)) {
echo "<tr>";
echo "<td>$no</td>";
echo "<td>$rows1[material_description_po]</td>";
echo "<td>$rows1[po_nomor]</td>";
echo "<td>$rows1[satuan]</td>";
echo "<td>$rows1[total_pairs]</td>";
echo "<td style=' text-align:right; padding: 0px 15px 0px 0px;'>".dollar($rows1[harga_satuan])."</td>";
echo "<td style=' text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($rows1[total_harga_satuan])."</td>";
echo "</tr>";

$total_pairs=$rows1[total_pairs]+$total_pairs;
$satuan=$rows1[satuan];
$total_harga=$rows1[total_harga_satuan]+$total_harga;
$no++;}

// echo "<tr>";
// echo "<td colspan='7'; style='background-color:black;'></td>";
// echo "</tr>";

$nilai_satuan=ambil_variabel_tanpa_kutip_where_distinct($nama_database_items,satuan,"WHERE induk='$id'");
$pecah_nilai_satuan=pecah($nilai_satuan);
$jumlah_nilai_satuan=nilai_pecah($nilai_satuan);

echo "<tr>";
echo "<td rowspan='4';></td>";
echo "<td style='font-weight:bold; font-size:12px;'>TOTAL</td>";

///////////////////////////////////////////////////////////////////////////////////////////////////
echo "<td style='font-weight:bold; font-size:12px;' colspan='2';>";
$no=0;for($i=0; $i < $jumlah_nilai_satuan; ++$i){

 echo "$pecah_nilai_satuan[$no]</br>";

$no++;}
echo "</td>";
///////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////
echo "<td style='font-weight:bold; font-size:12px;'>";
$no=0;for($i=0; $i < $jumlah_nilai_satuan; ++$i){
  echo nilai_per_satuan($jumlah_nilai_satuan,$nama_database_items,$id,$pecah_nilai_satuan[$no],total_pairs)."</br>";
$no++;}
echo "</td>";
///////////////////////////////////////////////////////////////////////////////////////////////////

echo "<td></td>";
///////////////////////////////////////////////////////////////////////////////////////////////////
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>";
$no=0;for($i=0; $i < $jumlah_nilai_satuan; ++$i){
  echo dollar_2(nilai_per_satuan($jumlah_nilai_satuan,$nama_database_items,$id,$pecah_nilai_satuan[$no],total_harga_satuan))."</br>";
$no++;}
echo "</td>";
//echo "<td style='font-weight:bold; font-size:12px;'>".dollar($total_harga)."</td>";
echo "</tr>";
///////////////////////////////////////////////////////////////////////////////////////////////////

//DISCOUNT
echo "<tr>";
echo "<td style='font-weight:bold; font-size:12px;'>DISCOUNT ".ambil_database(discount,$nama_database,"id='$id'")."%</td>";
$nilai_discount1=$total_harga*ambil_database(discount,$nama_database,"id='$id'")/100;
echo "<td colspan='4'></td>";
//echo "<td></td>";
//echo "<td></td>";
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($nilai_discount1)."</td>";
echo "</tr>";
//DISCOUNT END

//PPN
$total_harga_dikurang_discount=$total_harga-$nilai_discount1;
echo "<tr>";
echo "<td style='font-weight:bold; font-size:12px;'>PPN ".ambil_database(ppn,$nama_database,"id='$id'")."%</td>";
$nilai_ppn1=$total_harga_dikurang_discount*ambil_database(ppn,$nama_database,"id='$id'")/100;
echo "<td colspan='4'></td>";
//echo "<td></td>";
//echo "<td></td>";
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($nilai_ppn1)."</td>";
echo "</tr>";
//PPN END

echo "<tr>";
echo "<td style='font-weight:bold; font-size:12px;'>GRAND TOTAL</td>";
echo "<td colspan='4'></td>";
//echo "<td></td>";
//echo "<td></td>";

$nilai_grand_total=$total_harga_dikurang_discount-$nilai_ppn1;
echo "<td style='font-weight:bold; font-size:12px; text-align:right; padding: 0px 15px 0px 0px;'>".dollar_2($nilai_grand_total)."</td>";
echo "</tr>";
echo "</table>";

echo "<table>";
echo "<tr>";
echo "<td>
b. Tanggal Perjanjian Jual Beli : ".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</br>
c. Tanggal Pengiriman barang :  ".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</br>
d. Jangka waktu perjanjian : 30 hari ( 1 bulan )	</br>
e. Biaya proses pekerjaan seperti tertera pada PO dan cara pembayaran diatur tersendiri.
</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 2</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>Pengeluaran barang dari pihak I (Pertama) Ke pihak II (Kedua) akan dilaksanakan sekali pengiriman</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 3</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>Pihak I (Pertama) akan mengirim barang  seperti tertera pada pasal 1 kepada Pihak II (Kedua) dan sesuai</br>
mengenai jumlah/mutu dan ketepatan tanggal pengiriman barang jadi.</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 4</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
if (ambil_database(foc,$nama_database,"id='$id'")=='FOC') {
	echo "<td style='font-size:30px;'>FOC</td>";
}else {
	echo "<td style=''>
	Waktu pembayaran adalah 30 hari setelah tanggal pengiriman barang. Pembayaran dengan cara ditransfer</br>
	ke nomor rekening bank :</br>
	ACCOUNT NAMA: PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</br>
	BANK:  BANK CTBC INDONESIA</br>
	ACCOUNT NO.:  102028100272002 (USD)</br>
	ACCOUNT NO.:  102018100272001 (RP)
	</td>";
}
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 5</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>Kontrak jual beli ini dianggap sah/berlaku apabila telah selesai mengirim barang jadi</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; width:100%;'>";
echo "<tr>";
echo "<td style='font-weight:bold; font-size:15px; text-align:center;'>PASAL 6</td>";
echo "</tr>";
echo "</table>";
echo "<table style='margin-top:0px; width:100%;'>";
echo "<tr>";
echo "<td style=''>
Hal-hal lain yang terkait dengan proses perjanjian Jual beli tersebut diatas yang belum diatur dalam perjanjian ini akan dibicarakan</br>
/diatur kemudian
</td>";
echo "</tr>";
echo "</table>";


echo "<table style='margin-top:10px; font-size:17px;'>";
echo "<tr>
			<td style='text-align:center; font-weight:20px;'>Tangerang, ".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</td>
			</tr>";
echo "</table>";

echo "<table style='width:100%; font-size:17px;'>";
echo "<tr>
			<td style='width:40%; text-align:center; font-weight:20px;'>Pihak I</td>
						<td style='width:20%; text-align:center; font-weight:20px;'></td>
			<td style='width:40%; text-align:center; font-weight:20px;'>Pihak II</td>
			</tr>";
echo "<tr>
			<td style='text-align:center; font-weight:20px;'>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</td>
						<td style='text-align:center; font-weight:20px;'></td>
			<td style='text-align:center; font-weight:20px;'>".ambil_database(dari,$nama_database,"id='$id'")."</td>
			</tr>";
echo "</table>";


echo "<table style='width:100%; font-size:17px;'>";
echo "<tr>
			<td style=''>".tampil_td(signature,$id,$nama_database)."</td>
						<td></td>
			<td></td>
			</tr>";
echo "</table>";


echo "<table style='width:100%; font-size:17px; margin-top:0px;'>";
echo "<tr>
			<td style='width:40%; text-align:center; font-weight:20px;'>LU HUNG TA</td>
						<td style='width:20%; text-align:center; font-weight:20px;'></td>
			<td style='width:40%; text-align:center; font-weight:20px;'>".ambil_database(nama_penerima_barang,$nama_database,"id='$id'")."</td>
			</tr>";

echo "<tr>
			<td style='text-align:center; font-weight:20px;'>DIREKTUR</td>
						<td style='text-align:center; font-weight:20px;'></td>
			<td style='text-align:center; font-weight:20px;'>".ambil_database(jabatan_penerima_barang,$nama_database,"id='$id'")."</td>
			</tr>";
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
