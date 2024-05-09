<?php //KONEKSI DATABASE
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
//KONEKSI DATABASE?>

<?php // START FUNCTION

function qr_code($id){
	include "../../qrcode/qrlib.php";
	$tempdir = "../gambarqrcode/"; //Nama folder tempat menyimpan file qrcode
	if (!file_exists($tempdir)) //Buat folder bername temp
		 mkdir($tempdir);
		 //isi qrcode jika di scan
		 $codeContents=$id;
	//simpan file kedalam folder temp dengan nama 001.png
	QRcode::png($codeContents,$tempdir."$id-PURCHASING.png");
	//menampilkan file qrcode
}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
return $hasil_rupiah;}

function dollar($angka){
$hasil_rupiah = "$ " . number_format($angka,3,',','.');
return $hasil_rupiah;}

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

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
$nama_database='admin_purchasing';
$nama_database_items='admin_purchasing_items';
include 'style.css';

//AMBIL POST
$id=$_POST['id'];
$bahasa=$_POST['bahasa'];
$username=$_POST['username'];
//AMBIL POST END

$column_items='po_nomor,line_batch,kode_barang,model,material_description_po,warna,size,satuan,qty_purchasing,price_usd,amount_usd,price_rp,amount_rp,etd,remark';
$nilai_column=nilai_pecah($column_items);
$jumlah_column=pecah($column_items);

//TITLE
echo "<html>
<head><title>".ambil_database(po_purchasing,$nama_database,"id='$id'")."</title></head>
<body>";
//END TITLE


//HEADER 1
echo "<div>";
echo "<table style='width:100%;'>";
echo "<tr>";
echo "<td><center><img src='../../gambar/logo_lengkap.png' width='80%' height='70%'/><center></td>";
echo "<td><center><img src='../gambarqrcode/$id-PURCHASING.png' width='100%' height='100%'/><center></td>";
echo "</tr>";echo "<tr>";
echo "<td><center><img src='../../gambar/po.png' width='20%' height='100%'/><center></td>";
echo "</tr>";
echo "</table></br></br></div>";
//HEADER 1 END

//HEADER 2
echo "<table  style='width:100%;'>";
echo "<tr>";echo "<td style='width:20%;'></td>";echo "<td style='width:20%;'></td>";echo "<td style='width:20%;'></td>";
echo "<td style='width:20%;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='tanggal'")."</strong></td>";
echo "<td style='width:20%;'>: ".ambil_database(tanggal,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='po_purchasing'")."</strong></td>";
echo "<td>: ".ambil_database(po_purchasing,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "<tr>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='paymen_term'")."</strong></td>";
echo "<td>: ".ambil_database(paymen_term,$nama_database,"id='$id'")." ".ambil_database($bahasa,pusat_bahasa,"kode='hari'")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='kepada'")."</strong></td>";
echo "<td>: ".ambil_database(kepada,$nama_database,"id='$id'")."</td>";
echo "<td></td>";
echo "<td><strong>".ambil_database($bahasa,pusat_bahasa,"kode='attn'")."</strong></td>";
echo "<td>: ".ambil_database(attn,$nama_database,"id='$id'")."</td>";
echo "</tr>";
echo "</table></br>";
//HEADER 2 END


//START TABLE
echo "<table class='tabel_utama' style='width:100%;'>";
//HEADER TABEL
echo "<thead>";
echo "<th style=''><strong>No</strong></th>";
$no=0;for($i=0; $i < $nilai_column; ++$i){
	$result1=mysql_query("SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$jumlah_column[$no]'");
	$rows1=mysql_fetch_array($result1);
	echo "<th><strong>".$rows1[$bahasa]."</strong></th>";
$no++;}
echo "</thead>";
//HEADER END

//ISI TABEL
$sql4=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
echo "<tr>";
$number=1;
while ($rows4=mysql_fetch_array($sql4)) {
	$warnaGenap="white";$warnaGanjil="#CEF6F5";if ($number % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}
	echo "<td style='background-color:$color;'>$number</td>";
	$no=0;for($i=0; $i < $nilai_column; ++$i){

		//Pembeda Format Kolom
		if($jumlah_column[$no]==price_usd OR $jumlah_column[$no]==amount_usd) {
			echo "<td style='background-color:$color;'>".dollar($rows4[$jumlah_column[$no]])."</td>";
		}elseif($jumlah_column[$no]==price_rp OR $jumlah_column[$no]==amount_rp) {
			echo "<td style='background-color:$color;'>".rupiah($rows4[$jumlah_column[$no]])."</td>";
		}else{
			echo "<td style='background-color:$color;'>".$rows4[$jumlah_column[$no]]."</td>";
		}

	$no++;}
echo "</tr>";
$number++;

//Grand TOTAL
$grand_price_usd=$rows4['price_usd']+$grand_price_usd;//DOLLAR
$grand_amount_usd=$rows4['amount_usd']+$grand_amount_usd;//DOLLAR
$grand_price_rp=$rows4['price_rp']+$grand_price_rp;//RP
$grand_amount_rp=$rows4['amount_rp']+$grand_amount_rp;//RP
$grand_qty_spk=$rows4['qty_purchasing']+$grand_qty_spk;
}//ISI TABEL END

//GRAND TOTAL
echo "<tr>";
echo "<td colspan='9' style='font-size:12px;'><strong>".ambil_database($bahasa,pusat_bahasa,"kode='total'")."</strong></td>";
echo "<td style='font-size:12px;'><strong>$grand_qty_spk</strong></td>";
echo "<td style='font-size:12px;'><strong>".dollar($grand_price_usd)."</strong></td>";
echo "<td style='font-size:12px;'><strong>".dollar($grand_amount_usd)."</strong></td>";
echo "<td style='font-size:12px;'><strong>".rupiah($grand_price_rp)."</strong></td>";
echo "<td style='font-size:12px;'><strong>".rupiah($grand_amount_rp)."</strong></td>";
echo "<td colspan='2'></td>";
echo "</tr>";
//GRAND TOTAL END
echo "</table>";

//NOTED
echo "<table>";
echo "<tr>";echo "<td style='font-size:11px;'>".ambil_database($bahasa,pusat_bahasa,"kode='note'")."</td>";echo "</tr>";
echo "<tr>";echo "<td style='font-size:11px;'>".ambil_database($bahasa,pusat_bahasa,"kode='note_1'")."</td>";echo "</tr>";
echo "<tr>";echo "<td style='font-size:11px;'>".ambil_database($bahasa,pusat_bahasa,"kode='note_2'")."</td>";echo "</tr>";
echo "<tr>";echo "<td style='font-size:11px;'>".ambil_database($bahasa,pusat_bahasa,"kode='note_3'")."</td>";echo "</tr>";
echo "<tr>";echo "<td style='font-size:11px;'>".ambil_database($bahasa,pusat_bahasa,"kode='note_4'")."</td>";echo "</tr>";
echo "</table></br>";
//NOTED END

//Tanda Tangan
echo "<table style='width:100%;'>";
echo "<tr>";
echo "<td style='width:25%;'>".ambil_database($bahasa,pusat_bahasa,"kode='ttd_1'")."</td>";
echo "<td style='width:25%;'>".ambil_database($bahasa,pusat_bahasa,"kode='ttd_2'")."</td>";
echo "<td style='width:25%;'>".ambil_database($bahasa,pusat_bahasa,"kode='ttd_3'")."</td>";
echo "<td style='width:25%;'>".ambil_database($bahasa,pusat_bahasa,"kode='ttd_4'")."</td>";
echo "</tr>";
echo "</table>";
//Tanda Tangan END

//Tanda Tangan
echo "<table style='width:100%; margin-top:90px;'>";
echo "<tr>";
echo "<td style='width:25%;'>".$username."</td>";
echo "</tr>";
echo "</table>";
//Tanda Tangan END

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
