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


function tampil_td($username,$id,$database){
$script_ttd=ambil_database(script_ttd,pusat_ttd_items,"id_dokumen='$id' AND nama_database='$database' AND nama_ttd='$username'");
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
return ;}

function qr_code($id){
	include "../../qrcode/qrlib.php";
	$tempdir = "../gambarqrcode/"; //Nama folder tempat menyimpan file qrcode
	if (!file_exists($tempdir)) //Buat folder bername temp
		 mkdir($tempdir);
		 //isi qrcode jika di scan
		 $codeContents=$id;
	//simpan file kedalam folder temp dengan nama 001.png
	QRcode::png($codeContents,$tempdir."$id-INVOICE.png");
	//menampilkan file qrcode
}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
return $hasil_rupiah;}

function dollar($angka){
$hasil_rupiah = "$ " . number_format($angka,3,',','.');
return $hasil_rupiah;}

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
$nama_database='deliverycls_invoice';
$nama_database_items='deliverycls_invoice_items';

//AMBIL POST
$id=$_POST['id'];
$bahasa=$_POST['bahasa'];
$username=$_POST['username'];
//AMBIL POST END

//TITLE
echo "<html>
<head><title>".ambil_database(no_invoice,$nama_database,"id='$id'")."</title></head>
<body>";
//END TITLE

//HEADER PERTAMA
echo "<table style='width:100%;'>";
echo "<tr>
				<td style='width:25%;'><center><img src='../../gambar/logo_chinli.png' width='30%'/><center></td>
				<td style='width:50%;'><center><img src='../../gambar/logo_lengkap2.png' width='100%'/><center></td>
				<td style='width:25%;'><h2 align='center'><img src='../gambarqrcode/$id-INVOICE.png' width='100px' height='100px' align='right'/></h2></td>
			</tr>";
echo "<table>";

echo "<table style='width:100%;'>";
echo "<tr><td><center><h1>INVOICE</h1><center></td></tr>";
echo "<table>";
//HEADER PERTAMA END

//HEADER KEDUA
echo "<table style='width:100%; font-weight:bold; font-size:12px; border-style: ridge;'>";
echo "<tr>";
echo "<td style='width:75%;'>CONSIGNEE</td>";
echo "<td style='width:10%;'>INVOICE</td>";
echo "<td style='width:15%;'>: ".ambil_database(no_invoice,$nama_database,"id='$id'")."</td>";
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
echo "</table>";

echo "<table style='width:100%; font-weight:bold; font-size:10px; border-style: ridge; margin-top:5px;'>";
	echo "<tr>";
		echo "<td style='width:80%;' rowspan='2'>NOTIFY PARTY</td>";
		echo "<td style='width:auto;'>DESTINATION</td>";
		echo "<td style='width:auto;'>: Same as consignee</td>";
	echo "</tr>";

	echo "<tr>";
		echo "<td style='width:auto;'>PAYMENT TERM</td>";
		echo "<td>: ".ambil_database(payment_term,$nama_database,"id='$id'")." Day</td>";
	echo "</tr>";
echo "</table>";
//HEADER KEDUA END


//ISI KOLOM
echo "<table class='tabel_utama' style='margin-top:15px; width:100%;'>";

	echo "<thead>";
		echo "<th>NO</th>";
		echo "<th>QTY</th>";
		echo "<th>MATERIAL CODE</th>";
		echo "<th>ITEM NAME</th>";
		echo "<th>MODEL</th>";
		echo "<th>PO NOMOR</th>";
		echo "<th>SURAT JALAN</th>";
		echo "<th>U/PRICE</th>";
		echo "<th>AMOUNT</th>";
		echo "<th>OPSI</th>";
	echo "</thead>";


$isi_kolom='total_pairs,style_item_kode,material_description_po,model,po_nomor,surat_jalan,harga_satuan,total_harga_satuan';
$pecah_isi_kolom=explode (",",$isi_kolom);
$jumlah_isi_kolom=count($pecah_isi_kolom);

$number=1;
$result2=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows2=mysql_fetch_array($result2)) {
echo "<tr>";
echo "<td>$number</td>";
$no=0;for($i=0; $i < $jumlah_isi_kolom; ++$i){

//TAMPILAN HARGA
if ($pecah_isi_kolom[$no] == 'harga_satuan' OR $pecah_isi_kolom[$no] == 'total_harga_satuan') {
	if ($rows2[mata_uang]==Rupiah){$mata_uang='rupiah';}else{$mata_uang='dollar';}
	echo "<td style='text-align:right;'>".$mata_uang($rows2[$pecah_isi_kolom[$no]])."</td>";
}
//TAMPILAN NORMAL
else {
	echo "<td>".$rows2[$pecah_isi_kolom[$no]]."</td>";
}
$no++;}
echo "<td></td>";
echo "</tr>";$number++;

$grand_total_pairs=$rows2[total_pairs]+$grand_total_pairs;
$grand_total_harga_satuan=$rows2[total_harga_satuan]+$grand_total_harga_satuan;
}

echo "<tr>
				<td rowspan='3'></td>
				<td style='font-weight:bold;font-size:10px;'>$grand_total_pairs</td>
				<td rowspan='3'></td>
				<td colspan='5' style='text-align:left;font-weight:bold;font-size:10px;'>TOTAL</td>";
				if (ambil_database(mata_uang,$nama_database_items,"induk='$id'")==Rupiah){$mata_uang='rupiah';}else{$mata_uang='dollar';}
				echo "<td style='font-weight:bold;font-size:10px;text-align:right;'>".$mata_uang($grand_total_harga_satuan)."</td>
				<td rowspan='3'></td>
			</tr>";

$total_ppn=$grand_total_harga_satuan*ambil_database(ppn,$nama_database_items,"induk='$id'")/100;
echo "<tr>
				<td></td>
				<td colspan='5' style='text-align:left;font-weight:bold;font-size:10px;'>PPN ".ambil_database(ppn,$nama_database_items,"induk='$id'")."%</td>
				<td style='font-weight:bold;font-size:10px;text-align:right;'>".$mata_uang($total_ppn)."</td>
			</tr>";

$total_dikurangin_ppn=$grand_total_harga_satuan-$total_ppn;
echo "<tr>
				<td style='font-weight:bold;font-size:10px;'>".ambil_database(satuan,$nama_database_items,"induk='$id'")."</td>
				<td colspan='5' style='text-align:left;font-weight:bold;font-size:10px;'>GRAND TOTAL</td>
				<td style='font-weight:bold;font-size:10px;text-align:right;'>".$mata_uang($total_dikurangin_ppn)."</td>
			</tr>";

echo "</table>";
//ISI KOLOM END



//PENANDA TANGAN
echo "<table style='width:100%;'>";
$list_penanda_tangan=ambil_database(penanda_tangan,pusat_ttd,"nama_database='$nama_database'");
$pecah_ttd=explode (",",$list_penanda_tangan);
$jumlah_ttd=count($pecah_ttd);

echo "<tr>
			<td rowspan='4' style='text-align:left; width:65%;'>
			Please remit the payment to our account bank as follows : </br>
			Bank CTBC Indonesia </br>
			A/N PT. CHIN LI PLASTIC TECHNOLOGY INDONESIA </br>
			A/C : </br>
			- 102028100272002 (USD) </br>
			- 102018100272001 (RP)
			</td>
			<td style='text-align:center;'>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</td>
			</tr>";

echo "<tr>
			<td style='text-align:center;'>Tangerang, ".date('d F Y', strtotime(ambil_database(tanggal,$nama_database,"id='$id'")))."</td>
			</tr>";

echo "<tr>";
		 echo "<td style='text-align:center; color:red;'>";
		 echo tampil_td(signature,$id,$nama_database);
		 echo "</td>";
echo "</tr>";

echo "<tr>
			<td style='text-align:center;'>LU HUNG TA</br>DIREKTUR</td>
			</tr>";

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
