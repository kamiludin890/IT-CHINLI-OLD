<?php global $mod;
	$mod='akuntansiv3/fakturmasukkan_dev';
	
function editmenu(){extract($GLOBALS);}
define('host','localhost:8098');
function usd($i){
	$value = "$".number_format("$i", 2, ".", ",");
	return $value;
}
function rp($i){
	$value = "Rp".number_format("$i", 0, ",", ".");
	return $value;
}
//import masukan
function excel_reader(){
    //excel reader start
    echo"<form class='' action='' method='post' enctype='multipart/form-data'>
<input type='file' name='excel' required value=''>
<input type='submit' name='import' value='Update'>
<input type='submit' name='insert' value='Upload'>
</form>";
//excel reader start
if(isset($_POST["import"])){
    require 'modules/akuntansiv3/excel_reader.php';
	$fileName = $_FILES["excel"]["name"];
	//     $fileExtension = explode('.', $fileName);
	// $fileExtension = strtolower(end($fileExtension));
	//     $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
	
	//     $targetDirectory = "upload/" . $newFileName;
		move_uploaded_file($_FILES['excel']['tmp_name'], $fileName);
	
		error_reporting(0);
		ini_set('display_errors', 0);
	
		$reader = new Spreadsheet_Excel_Reader($_FILES["excel"]["name"]);
		$jumlah_baris = $reader->rowcount($sheet_index=0);
    
    for($i=2; $i<=$jumlah_baris; $i++){
        $id = str_replace("'"," ",$reader->val($i, 1));
        $tanggal = str_replace("'"," ",$reader->val($i, 2));
        $pembeli = str_replace("'"," ",$reader->val($i, 3));
        $npwp = str_replace("'"," ",$reader->val($i, 4));
        $no_faktur = str_replace("'"," ",$reader->val($i, 5));
        $no_invoice_masukkan = str_replace("'"," ",$reader->val($i, 6));
        $no_pen = str_replace("'"," ",$reader->val($i, 7));
        $no_aju = str_replace("'"," ",$reader->val($i, 8));
        $jenis_doc = str_replace("'"," ",$reader->val($i, 9));
        $keterangan = str_replace("'"," ",$reader->val($i, 10));
        $amount_rp = str_replace("'"," ",$reader->val($i, 11));
        $ppn = str_replace("'"," ",$reader->val($i, 12));
        $departement = str_replace("'"," ",$reader->val($i, 13));
        $kasbank_cash_flow = str_replace("'"," ",$reader->val($i, 14));
        $outstanding = str_replace("'"," ",$reader->val($i, 15));
        $amount_usd = str_replace("'"," ",$reader->val($i, 16));
        $tanggal_bayar = str_replace("'"," ",$reader->val($i, 17));
        $no_voucher = str_replace("'"," ",$reader->val($i, 18));
        $tidak_dipungut_dpp = str_replace("'"," ",$reader->val($i, 19));
        $tidak_dipungut_ppn = str_replace("'"," ",$reader->val($i, 20));
        $dipungut_dpp = str_replace("'"," ",$reader->val($i, 21));
        $dipungut_ppn = str_replace("'"," ",$reader->val($i, 22));
        $nilai = str_replace("'"," ",$reader->val($i, 23));
        $hasil = str_replace("'"," ",$reader->val($i, 24));
        $pembelian_bahan_baku_import = str_replace("'"," ",$reader->val($i, 25));
		$pembelian_bahan_penolong_produksi = str_replace("'"," ",$reader->val($i, 26));
		if($id==''){

		}else{
			
		// $update = date("Y.m.d");
        $queryk = "UPDATE akuntansiv3_faktur_masukkan SET tanggal='$tanggal',
		pembeli='$pembeli',
		no_npwp='$npwp',
		no_faktur='$no_faktur',
		no_invoice_masukkan='$no_invoice_masukkan',
		no_pendaftaran='$no_pen',
		no_aju='$no_aju',
		jenis_doc='$jenis_doc',
		keterangan='$keterangan',
		amount_rp='$amount_rp',
		ppn='$ppn',
		departement='$departement',
		kasbank_cash_flow='$kasbank_cash_flow',
		outstanding='$outstanding',
		amount_usd='$amount_usd',
		tgl_bayar='$tgl_bayar',
		no_voucher='$no_voucher',
		tidak_dipungut_dpp='$tidak_dipungut_dpp',
		tidak_dipungut_ppn='$tidak_dipungut_ppn',
		dipungut_dpp='$dipungut_dpp',
		dipungut_ppn='$dipungut_ppn',
		nilai='$nilai',
		hasil='$hasil',
		pembelian_bahan_baku_import='$pembelian_bahan_baku_import',
		pembelian_bahan_penolong_produksi='$pembelian_bahan_penolong_produksi'
		WHERE id='$id'";
		mysql_query($queryk);
		// echo"$queryk <br>";
	}
    }
    unlink($_FILES["excel"]["name"]);
	echo
	"
	<script>
	alert('Succesfully Imported $customer');
	</script>
	";
}
if(isset($_POST["insert"])){
    require 'modules/akuntansiv3/excel_reader.php';
	$fileName = $_FILES["excel"]["name"];
	//     $fileExtension = explode('.', $fileName);
	// $fileExtension = strtolower(end($fileExtension));
	//     $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
	
	//     $targetDirectory = "upload/" . $newFileName;
		move_uploaded_file($_FILES['excel']['tmp_name'], $fileName);
	
		error_reporting(0);
		ini_set('display_errors', 0);
	
		$reader = new Spreadsheet_Excel_Reader($_FILES["excel"]["name"]);
		$jumlah_baris = $reader->rowcount($sheet_index=0);
    
    for($i=2; $i<=$jumlah_baris; $i++){
        $npwp = str_replace("'"," ",$reader->val($i, 1));
        $perusahaan = str_replace("'"," ",$reader->val($i, 2));
        $kode = 0..str_replace("'"," ",$reader->val($i, 3));
        $ganti = str_replace("'"," ",$reader->val($i, 4));
        $no_faktur = str_replace("'"," ",$reader->val($i, 5));
        $tgl_fp = str_replace("'"," ",$reader->val($i, 6));
        $dpp = str_replace("'"," ",$reader->val($i, 7));
        $ppn = str_replace("'"," ",$reader->val($i, 8));
        $ppnbm = str_replace("'"," ",$reader->val($i, 9));
        $kreditan = str_replace("'"," ",$reader->val($i, 10));
        $no_inv = str_replace("'"," ",$reader->val($i, 11));
        $keterangan = str_replace("'"," ",$reader->val($i, 12));
        $dept = str_replace("'"," ",$reader->val($i, 13));
		$no_ajuceisa= ambil_database(NOMOR_AJU,ceisa_dokumen,"NOMOR_DOKUMEN='$no_inv'");
		if(empty($no_ajuceisa)){
			$no_aju= ambil_database(f2,exim_bc27m,"f18='$no_inv' OR f19='$no_inv'");
		}else{
			$no_aju = $no_ajuceisa;
		}
		$no_pen= ambil_database(NOMOR_DAFTAR,ceisa_header,"NOMOR_AJU='$no_aju'");
		$kode_dok= ambil_database(KODE_DOKUMEN,ceisa_header,"NOMOR_AJU='$no_aju'");
		// $update = date("Y.m.d");
        $queryk = "INSERT akuntansiv3_faktur_masukkan SET tanggal='$tgl_fp',
		no_npwp='$npwp',
		pembeli='$perusahaan',
		no_faktur='$kode$ganti$no_faktur',
		amount_rp='$dpp',
		ppn='$ppn',
		departement='$dept',
		no_invoice_masukkan='$no_inv',
		keterangan='$keterangan',
		no_aju='$no_aju',
		no_pendaftaran='$no_pen',
		jenis_doc='$kode_dok'";
		mysql_query($queryk);
		// echo"$queryk <br>";
    }
    unlink($_FILES["excel"]["name"]);
	echo
	"
	<script>
	alert('Succesfully Imported $customer');
	</script>
	";
}};//reader end
//import masukan end

function home(){extract($GLOBALS);
// include('fakma.php');

include ('function.php');
echo"<div style='display:flex;align_item:left;text-align:center;'>";
//Search or Pencarian
$tipe=$_POST['search'];
if(!empty($_POST['cariapa'])){
	$valuecari = $_POST['cariapa'];
}
echo"<p style='margin-right:2px;margin-left:8px;'>Pencarian</p>";
echo"<form name='cari' method='POST' action='#' style='display:flex;align_item:left;margin-left:2px;'>";
echo"<input name='cariapa' type='text' style='margin-right: 2px;height:22px;' value='$valuecari'>";
echo"<select name='search' style='height:22px;'>
<option value='$tipe'>$tipe</option>
<option value=''></option>
<option value='tanggal'>Tanggal</option>
<option value='pembeli'>Perusahan</option>
<option value='no_pendaftaran'>No Pendaftaran</option>
<option value='no_invoice_masukan'>No Invoice</option>
<option value='no_faktur'>No Faktur</option>
<option value='no_voucher'>Nomor Voucher</option>
<option value='no_npwp'>NPWP</option>
<option value='no_aju'>No Aju</option>
<option value='jenis_doc'>Jenis Dokumen</option>
<option value='departement'>Departement</option>
<option value='keterangan'>Keterangan</option>
<input type='submit' name='caridata' value='Cari' style='height:22px;width:80px;margin-left:4px;'>
</select>";

echo"</form>";
echo"<button style='height:22px;width:100px;margin-left:4px;'><label for='submit-form' tabindex='0' >Export Excel</label>";
// echo"<form method='POST'><input type='submit' style='margin-left:7.5px;height:22px;margin-right:195px;' name='updbmasukan' value='Update Database'></form>";
// if(isset($_POST['updbmasukan'])){
// 	updbmasukan();
// 	// echo "<script>alert('Kamu keren')</script>";
// };
//UPDATE DATA
echo"</div>";

excel_reader();
//TABLE
echo"<table style='border-collapse: collapse;'>";
echo"<th>
<tr style='background-color:#BEBEBE;'>
<td style='text-align:center;border: 1px solid;'><input type='checkbox' id='checkAll'></td>
<td style='text-align:center;border: 1px solid;'>No</td>
<td style='text-align:center;border: 1px solid;'>Tanggal</td>
<td style='text-align:center;border: 1px solid;'>Pembeli</td>
<td style='text-align:center;border: 1px solid;'>NPWP</td>
<td style='text-align:center;border: 1px solid;'>No Faktur</td>
<td style='text-align:center;border: 1px solid;'>No Invoice</td>
<td style='text-align:center;border: 1px solid;'>No Pendaftaran</td>
<td style='text-align:center;border: 1px solid;'>No Aju</td>
<td style='text-align:center;border: 1px solid;'>Jenis Dok</td>
<td style='text-align:center;border: 1px solid;'>Keterangsn</td>
<td style='text-align:center;border: 1px solid;'>Total RP</td>
<td style='text-align:center;border: 1px solid;'>PPN</td>
<td style='text-align:center;border: 1px solid;'>Nilai</td>
<td style='text-align:center;border: 1px solid;'>Hasil</td>
<td style='text-align:center;border: 1px solid;'>Departemen</td>
<td style='text-align:center;border: 1px solid;'>KAS/BANK (CASH FLOW)</td>
<td style='text-align:center;border: 1px solid;'>OUTSTANDING</td>
<td style='text-align:center;border: 1px solid;'>Total USD</td>
<td style='text-align:center;border: 1px solid;'>TGL BAYAR</td>
<td style='text-align:center;border: 1px solid;'>NO VOUCHER</td>
<td style='text-align:center;border: 1px solid;'>TIDAK DIPUNGUT DPP</td>
<td style='text-align:center;border: 1px solid;'>TIDAK DIPUNGUT PPN</td>
<td style='text-align:center;border: 1px solid;'>DIPUNGUT DPP</td>
<td style='text-align:center;border: 1px solid;'>DIPUNGUT PPN</td>
<td style='text-align:center;border: 1px solid;'>PEMBELIAN BAHAN BAKU & IMPORT</td>
<td style='text-align:center;border: 1px solid;'>PEMBELIAN BAHAN PENOLONG PRODUKSI	</td>
<td colspan='2' style='text-align:center;border: 1px solid;'>Edit</td>
</tr>
</th>";
echo"<tb>";
// $halaman = 50;
// $page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
// $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
// $result = mysql_query("SELECT	* FROM ceisa_entitas  ");
// $total = mysql_num_rows($result);
// $pages = ceil($total/$halaman);
// $masukan_query = mysql_query("SELECT * FROM ceisa_entitas LIMIT $mulai, $halaman")or die(mysql_error);
// $no =$mulai+1;
// if ($no<=$total;$no++){}
$halaman = 50; /* page halaman*/
// $page    =isset($_GET["akuntansiv3/fakturmasukkan_dev"]) ? (int)$_GET["akuntansiv3/fakturmasukkan_dev"] : 1;
$nomor_halaman=$_POST['halaman'];//PAGING
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai =($page>1) ? ($page * $halaman) - $halaman : 0;
if(isset($_POST['caridata'])){
	$cariapa=$_POST['cariapa'];
	$tipe=$_POST['search'];
	if($cariapa!=='' && $tipe!==''){
		$result=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE $tipe LIKE'%$cariapa%' AND tipe!='tidak tampil'");
	}else{
		$result=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE tipe!='tidak tampil' ");
	};
}else{
	$result=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE tipe!='tidak tampil' ");
}
$total = mysql_num_rows($result);
if(isset($_POST['caridata'])){
	$cariapa=$_POST['cariapa'];
	$tipe=$_POST['search'];
	if($cariapa!=='' && $tipe!==''){
		$query=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE $tipe LIKE'%$cariapa%' AND tipe!='tidak tampil' ORDER BY tanggal");
		$pages = 1;
	}else{
		$query=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE tipe!='tidak tampil' ORDER BY tanggal DESC LIMIT $mulai, $halaman");
		$pages = ceil($total/$halaman);
	};
}else{
	$query=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE tipe!='tidak tampil' ORDER BY tanggal DESC LIMIT $mulai, $halaman");
	$pages = ceil($total/$halaman);
};

$no=$mulai+1;

echo"
<form method='POST' target='_blank' action='modules/akuntansiv3/fakmaexport.php'>";
while($rows=mysql_fetch_array($query)){
	
	$warnaGenap="white";$warnaGanjil="#CEF6F5";if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}
	echo"
	<tr style='background-color:$color;'>
	<td style='border: 1px solid;'><input type='checkbox' name='check_list[]' value='$rows[id]'>
	<input type='submit' name='downloadbox' value='submit' id='submit-form' style='display:none;' /></td>	
	<td style='border: 1px solid;'>".$no++."</td>";
	$querys=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE id ='$rows[id]'");
	$row = mysql_fetch_array($querys);
	echo"
		<td style='border: 1px solid;'>$row[tanggal]</td>
		<td style='border: 1px solid;'>$row[pembeli]</td>
		<td style='border: 1px solid;'>$row[no_npwp]</td>
		<td style='border: 1px solid;'>$row[no_faktur]</td>
		<td style='border: 1px solid;'>$row[no_invoice_masukkan]</td>
		<td style='border: 1px solid;'>$row[no_pendaftaran]</td>
		<td style='border: 1px solid;'>$row[no_aju]</td>
		<td style='border: 1px solid;'>$row[jenis_doc]</td>
		<td style='border: 1px solid;'>$row[keterangan]</td>
		<td style='border: 1px solid;'>".rp($row['amount_rp'])."</td>
		<td style='border: 1px solid;'>".rp($row['ppn'])."</td>
		<td style='border: 1px solid;'>".rp($row['nilai'])."</td>
		<td style='border: 1px solid;'>".rp($row['hasil'])."</td>
		<td style='border: 1px solid;'>$row[departement]</td>
		<td style='border: 1px solid;'>".rp($row['kasbank_cash_flow'])."</td>
		<td style='border: 1px solid;'>$row[outstanding]</td>
		<td style='border: 1px solid;'>".usd($row['amount_usd'])."</td>
		<td style='border: 1px solid;'>$row[tgl_bayar]</td>
		<td style='border: 1px solid;'>$row[no_voucher]</td>
		<td style='border: 1px solid;'>$row[tidak_dipungut_dpp]</td>
		<td style='border: 1px solid;'>$row[tidak_dipungut_ppn]</td>
		<td style='border: 1px solid;'>".rp($row['dipungut_dpp'])."</td>
		<td style='border: 1px solid;'>".rp($row['dipungut_ppn'])."</td>
		<td style='border: 1px solid;'>$row[pembelian_bahan_baku_import]</td>
		<td style='border: 1px solid;'>$row[pembelian_bahan_penolong_produksi]</td>
		<td style='border: 1px solid;'><div style='text-align:center;border-radius:5%;width:50px;background-color:grey;height:20px;margin:2px;'><a style='text-decoration:none;color:white;' href='modules/akuntansiv3/fakma.php?id=$rows[id]' style='margin:2px;'>Edit</a></div></td>
		<td style='border: 1px solid;'><div style='text-align:center;border-radius:5%;width:50px;background-color:grey;height:20px;margin:2px;'><a style='text-decoration:none;color:white;' href='modules/akuntansiv3/fakmadel.php?id=$rows[id]'>Hapus</a></div></td>
		";	
		//<td style='border: 1px solid;'><button href='modules/akuntansiv3/fakma.php=".$rows['id']."' style='width:40px;'>Edit</button></td>
		//<td style='border: 1px solid;'><button name='hapus'>Hapus</button></td>
		$rows;
}
echo"
</form>";

if(isset($_GET['click'])){
	$id= $_GET['click'];
	echo"<script>alert($id)</script>";
}

//onClick='window.open(`modules/akuntansiv3/fakma.php`)'
echo"</tb>";
echo"</table>";
echo"<br><button><label for='submit-form' tabindex='0'>Export Excel</label></button>";
if(isset($_POST['downloadbox'])){
	foreach($_POST["cekbox"] as $idk){
echo"$idk";
	}
}
// echo"<a href='modules/akuntansiv3/fakma.php'>akakak</a>";
// if(isset($_POST['edit'])){
//     $idtab = $_POST['id'];
// }
// echo "TEST - $idtab";
// $_SESSION['id'] = $idtab;
//PAGING KLIK
if ($total > '50') {
	echo "<table>
	<form method ='post' action='$address'>
	<tr>
	 <td>Total Data($total) | </td>
	 <td>Halaman</td>
	 <td>:</td>
				<td><select name='halaman'>
				<option value='$nomor_halaman'>".$nomor_halaman."</option>";
	  for ($i=1; $i<=$pages; $i++){
	echo "<option value='$i'>$i</option>";}
	echo "</td>";
	echo "<td> / $pages</td>";
			 echo "
			 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			 <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			 <input type='hidden' name='pencarian' value='$pencarian'>
			 <td><input type='submit' value='tampil'></td>
			</tr>
			</form>
			</table>";}
	//PAGING KLIK END
	echo"
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script><script>$('#checkAll').click(function() {
		$('input:checkbox').not(this).prop('checked', this.checked);
	});</script>";


// echo"<select name='halaman'>";
// for ($i=1; $i<=$pages ; $i++){
// 	echo"<option value='".$address.$i."'><u>".$i."</u></option>";
// }
// echo"</select>";

// if ($total > '50') {
// 	echo "<table>
// 	<form method ='post' action='$address'>
// 	<tr>
// 	 <td>Total Data($total) | </td>
// 	 <td>Halaman</td>
// 	 <td>:</td>
// 				<td><select name='halaman'>
// 				<option value='$nomor_halaman'>".$nomor_halaman."</option>";
// 	  for ($i=1; $i<=$pages; $i++){
// 	echo "<option value='$i'>$i</option>";}
// 	echo "</td>";
// 	echo "<td> / $pages</td>";
// 	echo "
// 	</form>
// 	</table>";}
// echo"";
// echo"";
// echo"";




}//END HOME
//END PHP?>