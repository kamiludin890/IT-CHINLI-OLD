<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row,$p, $akses ;

	$mod="akuntansi/bukubesar";
	$tbl='akuntansi_jurnal';
	$fld='id,tanggal,nomor,nama,keterangan,debit,kredit' ;
	$p = getrow("periode1,periode2","master_setting","");

function editmenu(){extract($GLOBALS);
echo usermenu('export');
	}

	function rupiah($angka){
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	 }

function home(){extract($GLOBALS);
	buku_besar();
	}

	//$sql234="SELECT * FROM inventory_distribusi WHERE tanggal_doc BETWEEN '2019-07-01' AND '2019-08-31'";
	//$result234= mysql_query($sql234);
  //while($rows234=mysql_fetch_array($result234)){

		//$sql2345="SELECT * FROM exim_bc27m WHERE f8='$rows234[nomor_doc]' AND f9='$rows234[tanggal_doc]'";
		//$result2345=mysql_query($sql2345);
		//$rows2345=mysql_fetch_array($result2345);

		//$nomor_aju = preg_replace("/[^0-9]/", "", $rows2345['f2']);
		//$harga_penyerahan= str_replace(".", "", $rows2345['f28']);

	//$test_update="UPDATE inventory_distribusi SET harga_penyerahan='$harga_penyerahan',nomor_aju='$nomor_aju' WHERE id='$rows234[id]'";
	//$eksekusi=mysql_query($test_update);
  //}

function buku_besar(){ extract($GLOBALS);
	//Pilihan Bulan
	$username10=$_SESSION['username'];

	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];

	if ($bulan>0) {
		$upload="UPDATE master_user SET tanggal_pencarian_buku_besar='$tahun-$bulan' WHERE email='$username10'";
		$hasil = mysql_query($upload);
	}

		$sql304="SELECT * FROM master_user WHERE email='$username10'";
		$result304= mysql_query($sql304);
		$data304=mysql_fetch_array($result304);
		$bulan4=$data304['tanggal_pencarian_buku_besar'];
		$bulan3 = substr($bulan4,5);


		if($bulan3=='01'){$bulan2='Januari';} else {}
		if($bulan3=='02'){$bulan2='Februari';} else {}
		if($bulan3=='03'){$bulan2='Maret';} else {}
		if($bulan3=='04'){$bulan2='April';} else {}
		if($bulan3=='05'){$bulan2='Mei';} else {}
		if($bulan3=='06'){$bulan2='Juni';} else {}
		if($bulan3=='07'){$bulan2='Juli';} else {}
		if($bulan3=='08'){$bulan2='Agustus';} else {}
		if($bulan3=='09'){$bulan2='September';} else {}
		if($bulan3=='10'){$bulan2='Oktober';} else {}
		if($bulan3=='11'){$bulan2='November';} else {}
		if($bulan3=='12'){$bulan2='Desember';} else {}

	echo "
	<form action='?menu=home&mod=akuntansi/bukubesar' method='POST'>
	</br>
	Bulan
	<select name='bulan'>
		<option value='$bulan3'>$bulan2</option>
	<option value='01'>Januari</option>
	<option value='02'>Februari</option>
	<option value='03'>Maret</option>
	<option value='04'>April</option>
	<option value='05'>Mei</option>
	<option value='06'>Juni</option>
	<option value='07'>Juli</option>
	<option value='08'>Agustus</option>
	<option value='09'>September</option>
	<option value='10'>Oktober</option>
	<option value='11'>November</option>
	<option value='12'>Desember</option>
	</select>";?>
	Tahun
	<select name='tahun'>
	<?php
	$mulai= date('Y') - 50;
	for($i = $mulai;$i<$mulai + 100;$i++){
	    $sel = $i == date('Y') ? ' selected="selected"' : '';
	    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
	}
	?>
	<input type="submit" value="Cari">
	</form>
	</select>
</br>

<body>

<?php
$list_buku_besar_dokumen=$_POST['list_buku_besar_dokumen'];
$kontak_buku_besar=$_POST['kontak_buku_besar'];

echo "</br>
<form method ='post' action='?menu=home&mod=akuntansi/bukubesar'>
<input type='hidden' name='list_buku_besar_dokumen' value='list_buku_besar_dokumen'>
<td><input type='submit' value='Buku Besar Dokumen'></td>
</tr>
</form>
</br>";



//List Buku Besar Dokumen
if ($list_buku_besar_dokumen==list_buku_besar_dokumen) {
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansi/bukubesar'>
	<input type='hidden' name='list_buku_besar_dokumen' value=''>
	<td><input type='submit' value='Kembali'></td>
	</tr>
	</form>
	</br></br></br>	";

  $sql1="SELECT * FROM inventory_distribusi WHERE tanggal_doc LIKE '$data304[tanggal_pencarian_buku_besar]%' AND jenis_doc LIKE 'BC %' AND kontak='$kontak_buku_besar'";
	$result4= mysql_query($sql1);
	$result1= mysql_query($sql1);
  $rows4=mysql_fetch_array($result4);
	echo "
			<link rel='stylesheet' href='select_picker/css/style3.css' type='text/css'>
			<link rel='stylesheet' href='select_picker/css/bootstrap-select.min.css' type='text/css'>";

			echo "<form method ='post' action='?menu=home&mod=akuntansi/bukubesar'>
			<table>

			<div class='col-xs-12'>
			<div class='row'>
			<div class='col-sm-4'>
			<div class='form-group'>
			<td>KONTAK</td>
			<td>:</td>
			<td><select name='kontak_buku_besar' class='form-control selectpicker show-tick' data-live-search='true'>";
			$sql53="SELECT DISTINCT kontak FROM inventory_distribusi WHERE tanggal_doc LIKE '%$data304[tanggal_pencarian_buku_besar]%' AND jenis_doc LIKE 'BC %' ORDER BY tanggal_doc";
			$result53= mysql_query($sql53);
			echo "
			<option value='$kontak_buku_besar'>".$kontak_buku_besar."</option>";
			while ($rows53=mysql_fetch_array($result53)){
			echo "
			<option value='$rows53[kontak]'>".$rows53['kontak']."</option>
			";}
			echo "
			</select></td>
             <input type='hidden' name='list_buku_besar_dokumen' value='list_buku_besar_dokumen'>
						 <td><input type='submit' value='Tampilkan'></td>
			</tr><tr></tr><tr></tr><tr></tr>";

		 echo "
		 	<script src='select_picker/js/jquery-1.11.2.min.js'></script>
		 	<script src='select_picker/js/bootstrap.js'></script>
		 	<script src='select_picker/js/bootstrap-select.min.js'></script>
		 	<script type='text/javascript'>
		 	$(document).ready(function(){
		 	});
		 	</script>

		 	</table>
		 	</form>	";



	echo "
		<table width='100%' padding='100' border='1' cellspacing='1' cellpadding='0' border-color='black'>
		<tr>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='5px' bgcolor='#FFFFFF'><strong>No</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='50px' bgcolor='#FFFFFF'><strong>Tanggal Daftar</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Jenis Dokumen</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='5px' bgcolor='#FFFFFF'><strong>Nomor Aju</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='5px' bgcolor='#FFFFFF'><strong>Tanggal Transaksi</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='10px' bgcolor='#FFFFFF'><strong>Nama PT</strong></td>
	  <td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong>Keterangan</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Debit</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Kredit</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Saldo</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Status</strong></td>
		<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Catatan</strong></td>
		</tr>";


  	$username31=$_SESSION['username'];
		$sql22="SELECT * FROM master_user WHERE email='$username31'";
		$result22= mysql_query($sql22);
		$rows22=mysql_fetch_array($result22);

					$n=1;
					while ($rows1=mysql_fetch_array($result1)){

						$sql21="SELECT * FROM akuntansi_posting WHERE nomor_aju='$rows1[nomor_aju]'";
						$result21= mysql_query($sql21);
						$rows21=mysql_fetch_array($result21);

						$query25="SELECT SUM(bayar) FROM akuntansi_posting WHERE nomor_aju='$rows1[nomor_aju]'";
						$result25=mysql_query($query25);
						$row25=mysql_fetch_array($result25);

						$totalbayar=$row25['SUM(bayar)'];
						$totalbayar1=number_format($totalbayar, 0, ".", ".");
						$decimal_total_bayar=explode(".",$totalbayar);
						$decimal_total_bayar1=$decimal_total_bayar[1];

						$nilai_transaksi=$rows1['harga_penyerahan'];
						$nilai_transaksi1=number_format($nilai_transaksi, 0, ".", ".");
						$decimal_nilai_transaksi=explode(".",$nilai_transaksi);
						$decimal_nilai_transaksi1=$decimal_nilai_transaksi[1];

						$jenis_doc=$rows1['jenis_doc'];
			      if($jenis_doc=='BC 2.7 MASUK'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet=$nilai_transaksi; $saldo_kredit=$totalbayar;} else {}
			      if($jenis_doc=='BC 4.0 LOKAL'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet=$nilai_transaksi; $saldo_kredit=$totalbayar;} else {}
						if($jenis_doc=='BC 2.3 IMPORT'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet=$nilai_transaksi; $saldo_kredit=$totalbayar;} else {}
						if($jenis_doc=='BC 2.6.2 HASIL SUBKON'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet=$nilai_transaksi; $saldo_kredit=$totalbayar;} else {}

						if($jenis_doc=='BC 3.0 PEB'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet=$totalbayar; $saldo_kredit=$nilai_transaksi;} else {}
			      if($jenis_doc=='BC 2.5 PIB'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet=$totalbayar; $saldo_kredit=$nilai_transaksi;} else {}
			      if($jenis_doc=='BC 2.6.1 SUBKON'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet=$totalbayar; $saldo_kredit=$nilai_transaksi;} else {}
			      if($jenis_doc=='BC 2.7 KELUAR'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet=$totalbayar; $saldo_kredit=$nilai_transaksi;} else {}
			      if($jenis_doc=='BC 4.1 PENJUALAN'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet=$totalbayar; $saldo_kredit=$nilai_transaksi;} else {}

							$saldo_debet1=rupiah($saldo_debet);
							$saldo_kredit1=rupiah($saldo_kredit);
							$sisa1=rupiah($sisa);

							$grand_total_debet=$grand_total_debet+$saldo_debet;
							$grand_total_kredit=$grand_total_kredit+$saldo_kredit;
							$grand_total_sisa=$grand_total_sisa+$sisa;

							$grand_total_debet1=rupiah($grand_total_debet);
							$grand_total_kredit1=rupiah($grand_total_kredit);
							$grand_total_sisa1=rupiah($grand_total_sisa);

//'BC 2.7 MASUK','BC 4.0 LOKAL','BC 2.3 IMPORT','BC 2.6.2 HASIL SUBKON'
	if ($rows1[jenis_doc]=='BC 4.0 LOKAL'){$keterangan_list_dokumen=$rows21['keterangan_kredit'];}
	elseif ($rows1[jenis_doc]=='BC 2.7 MASUK'){$keterangan_list_dokumen=$rows21['keterangan_kredit'];}
	elseif ($rows1[jenis_doc]=='BC 2.3 IMPORT'){$keterangan_list_dokumen=$rows21['keterangan_kredit'];}
	elseif ($rows1[jenis_doc]=='BC 2.6.2 HASIL SUBKON'){$keterangan_list_dokumen=$rows21['keterangan_kredit'];}else{$keterangan_list_dokumen=$rows21['keterangan_debit'];}


	echo "<tr>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$n</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[tanggal_doc]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[jenis_doc]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nomor_aju]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows21[tanggal]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[kontak]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$keterangan_list_dokumen</td>
    <td style='background-color:$warna_debet; padding-left:5px; padding-right:10px; text-align:right;'>$saldo_debet1</td>
    <td style='background-color:$warna_kredit; padding-left:5px; padding-right:5px; text-align:right;'>$saldo_kredit1</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:right;'>$sisa1</td>";

		//Pembeda Status
		$sql223="SELECT status,catatan FROM akuntansi_posting WHERE nomor_aju='$rows1[nomor_aju]' AND status='Selesai'";
		$result223= mysql_query($sql223);
		$rows223=mysql_fetch_array($result223);

		if ($rows223['status']=='Selesai'){$status_pembayaran='Selesai'; $catatan_pembayaran=$rows223['catatan'];}else{$status_pembayaran='Proses'; $catatan_pembayaran='';}

	echo "
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$status_pembayaran</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$catatan_pembayaran</td>";
			$n++;



//Ambil Dari Distribusi
$query26="SELECT SUM(harga_penyerahan) FROM inventory_distribusi WHERE kontak='$rows1[kontak]' AND tanggal_doc LIKE '%$rows22[tanggal_pencarian_buku_besar]%' AND jenis_doc IN ('BC 2.7 MASUK','BC 4.0 LOKAL','BC 2.3 IMPORT','BC 2.6.2 HASIL SUBKON')";
$result26=mysql_query($query26);
$row26=mysql_fetch_array($result26);
$total_debit=$row26['SUM(harga_penyerahan)'];

$query27="SELECT SUM(harga_penyerahan) FROM inventory_distribusi WHERE kontak='$rows1[kontak]' AND tanggal_doc LIKE '%$rows22[tanggal_pencarian_buku_besar]%' AND jenis_doc IN ('BC 3.0 PEB','BC 2.5 PIB','BC 2.6.1 SUBKON','BC 2.7 KELUAR','BC 4.1 PENJUALAN')";
$result27=mysql_query($query27);
$row27=mysql_fetch_array($result27);
$total_kredit=$row27['SUM(harga_penyerahan)'];

//Ambil Data Dari Posting
$query28="SELECT SUM(bayar) FROM akuntansi_posting WHERE kontak='$rows1[kontak]' AND tanggal LIKE '%$rows22[tanggal_pencarian_buku_besar]%' AND jenis_doc IN ('BC 2.7 MASUK','BC 4.0 LOKAL','BC 2.3 IMPORT','BC 2.6.2 HASIL SUBKON')";
$result28=mysql_query($query28);
$row28=mysql_fetch_array($result28);
$total_kredit_posting=$row28['SUM(bayar)'];

$query29="SELECT SUM(bayar) FROM akuntansi_posting WHERE kontak='$rows1[kontak]' AND tanggal LIKE '%$rows22[tanggal_pencarian_buku_besar]%' AND jenis_doc IN ('BC 3.0 PEB','BC 2.5 PIB','BC 2.6.1 SUBKON','BC 2.7 KELUAR','BC 4.1 PENJUALAN')";
$result29=mysql_query($query29);
$row29=mysql_fetch_array($result29);
$total_debit_posting=$row29['SUM(bayar)'];
}

echo"<tr>";
echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='7'>TOTAL</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_debet1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_kredit1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_sisa1</th>";
echo"</tr>";

//$seluruh_debit=$total_debit+$total_debit_posting;
//$seluruh_kredit=$total_kredit+$total_kredit_posting;
//$seluruh_sisa=$seluruh_debit-$seluruh_kredit;

//Seluruh Saldo Debit
//$seluruh_debit1=number_format($seluruh_debit, 0, ".", ".");
//$seluruh_debit_decimal=explode(".",$seluruh_debit);
//$seluruh_debit_decimal1=$seluruh_debit_decimal[1];

//Seluruh Saldo Kredit
//$seluruh_kredit1=number_format($seluruh_kredit, 0, ".", ".");
//$seluruh_kredit_decimal=explode(".",$seluruh_kredit);
//$seluruh_kredit_decimal1=$seluruh_kredit_decimal[1];

//$seluruh_sisa1=number_format($seluruh_sisa, 0, ".", ".");
//$seluruh_sisa_decimal=explode(".",$seluruh_sisa);
//$seluruh_sisa_decimal1=$seluruh_sisa_decimal[1];

//echo"<tr>";
//echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='7'>Jumlah</th>";
//echo"<th style='background-color:#DCDCDC; text-align:right;'>Rp $seluruh_debit1,$seluruh_debit_decimal1</th>";
//echo"<th style='background-color:#DCDCDC; text-align:right;'>Rp $seluruh_kredit1,$seluruh_kredit_decimal1</th>";
//echo"<th style='background-color:#DCDCDC; text-align:right;'>Rp $seluruh_sisa1,$seluruh_sisa_decimal1</th>";
//echo"</tr>";
//echo"</table>";
}else {
	$username10=$_SESSION['username'];
	$saldo_awal1='2019-06-01';
	$saldo_awal2=$_POST['saldo_awal2'];
	$mutasi1=$_POST['mutasi1'];
	$mutasi2=$_POST['mutasi2'];
	if ($mutasi1>0) {
	$sql3="UPDATE master_user SET saldo_awal_buku_besar1='$saldo_awal1',saldo_awal_buku_besar2='$saldo_awal2',mutasi_buku_besar1='$mutasi1',mutasi_buku_besar2='$mutasi2' WHERE email='$username10'";
	$eksekusi_sql3=mysql_query($sql3);}

	$sql23="SELECT * FROM master_user WHERE email='$username10'";
	$result23= mysql_query($sql23);
	$rows23=mysql_fetch_array($result23);
echo "
<h3 style='text-align:left'>Periode Laporan</h3>";
echo "<form method ='post' action='?menu=home&mod=akuntansi/bukubesar'>
<table>
<tr>
 <td>Periode Saldo Awal</td>
 <td>:</td>
 <td><input type='date' name='saldo_awal1' value='$saldo_awal1' disabled></td>
 <td>Sampai</td>
 <td>:</td>
 <td><input type='date' name='saldo_awal2' value='$rows23[saldo_awal_buku_besar2]'></td>
</tr>
<tr>
 <td>Periode Mutasi</td>
 <td>:</td>
 <td><input type='date' name='mutasi1' value='$rows23[mutasi_buku_besar1]'></td>
 <td>Sampai</td>
 <td>:</td>
 <td><input type='date' name='mutasi2' value='$rows23[mutasi_buku_besar2]'></td>
 <td><input type='hidden' name='jenis_laporan' value='LAPORAN NERACA'></td>
 <td><input type='submit' value='Simpan'></td>
</tr>
</table>
</form></br>
";

echo "
		<link rel='stylesheet' href='select_picker/css/style3.css' type='text/css'>
		<link rel='stylesheet' href='select_picker/css/bootstrap-select.min.css' type='text/css'>";

		echo "<form method ='post' action='?menu=home&mod=akuntansi/bukubesar'>
		<table>

		<div class='col-xs-12'>
		<div class='row'>
		<div class='col-sm-4'>
		<div class='form-group'>
		<td>KONTAK</td>
		<td>:</td>
		<td><select name='akun' class='form-control selectpicker show-tick' data-live-search='true'>";
		$sql54="SELECT * FROM akuntansi_akun WHERE nomor='$_POST[akun]'";
		$result54= mysql_query($sql54);
		$rows54=mysql_fetch_array($result54);
		$nomorakun=$rows54['nomor'];
		$namaakun=$rows54['nama'];

		$sql53="SELECT * FROM akuntansi_akun ORDER BY nomor";
		$result53= mysql_query($sql53);
		echo "
		<option value='$nomorakun'>".$namaakun."</option>";
		while ($rows53=mysql_fetch_array($result53)){
		echo "
		<option value='$rows53[nomor]'>".$rows53['nama']."</option>
		";}
		echo "
		</select></td>
					 <td><input type='submit' value='Tampilkan'></td>
		</tr><tr></tr><tr></tr><tr></tr>";

	 echo "
		<script src='select_picker/js/jquery-1.11.2.min.js'></script>
		<script src='select_picker/js/bootstrap.js'></script>
		<script src='select_picker/js/bootstrap-select.min.js'></script>
		<script type='text/javascript'>
		$(document).ready(function(){
		});
		</script>

		</table>
		</form>	";

	$limit = 10000;
	if (isset($_POST['akun']) ){
	$akun=$_POST['akun'];
	$bb = getrow("nomor,nama","akuntansi_akun","where nomor=$akun");

	$rest ="where nomor='$akun'  AND tanggal BETWEEN '$rows23[mutasi_buku_besar1]' AND '$rows23[mutasi_buku_besar2]' ORDER BY id,tanggal";}
	else { $rest =" where nomor='111' and tanggal BETWEEN '$rows23[mutasi_buku_besar1]' AND '$rows23[mutasi_buku_besar2]'";}

	if(isset($_POST['menu'])) {$rest="";}
	if(isset($_POST['sortir'])) {$sortir="order by ". $_POST['sortir'];} else {$sortir="";}
	$datasec=$_POST['test'];
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld;}
	if(isset($_GET['page'])){ $noPage = $_GET['page'];} else $noPage = 1;
	$offset = ($noPage - 1) * $limit;
	$query = "SELECT $data FROM $tbl $rest $sortir LIMIT $offset, $limit  ";
	$_SESSION['myquery']=$query;
	$result = mysql_query($query) or die('Error');
	echo "<div class=scroll>";
	echo "<form name=myform action=?mod=$mod&menu=aksi method=post ><input type=hidden name=mysubmit >";
	echo "<input type=hidden name=id value=$id >";
		echo "<input type=hidden name=tbl value=$tbl >";
		echo "<input type=hidden name=mod value=$mod >";
		echo "<input type=hidden name=ids >";

//Pilihan Akun Awal"
 	//$result1=mysql_query("SELECT nomor, nama FROM akuntansi_akun ");
	//echo "<select name='akun' onChange=submitform('buku_besar'); return false;>";
	//while ($r1=mysql_fetch_array($result1))  {
	//if($akun==$r1['nomor']){$t = 'selected'; }else{$t = '';}
	//echo"<option value=$r1[nomor] $t >$r1[nama] </option>";}
	//echo"</select>";

//	echo"<button type=submit value='buku_besar' name='mybutton' class='formbutton' >Tampil</button>";

if ($akun=='01') {
	$akun_all="nomor NOT IN ('','A-1','A-2','A-3')";
}else {
	$akun_all="nomor='$akun'";
}


	$query23="SELECT SUM(debit) FROM akuntansi_jurnal WHERE $akun_all AND tanggal BETWEEN '$rows23[saldo_awal_buku_besar1]' AND '$rows23[saldo_awal_buku_besar2]'";
	$result23=mysql_query($query23);
	$row23=mysql_fetch_array($result23);

	$query24="SELECT SUM(kredit) FROM akuntansi_jurnal WHERE $akun_all AND tanggal BETWEEN '$rows23[saldo_awal_buku_besar1]' AND '$rows23[saldo_awal_buku_besar2]'";
	$result24=mysql_query($query24);
	$row24=mysql_fetch_array($result24);

	$query31="SELECT * FROM akuntansi_jurnal WHERE $akun_all";
	$result31=mysql_query($query31);
	$row31=mysql_fetch_array($result31);

			$totaldebit=$row23['SUM(debit)'];
			$totalkredit=$row24['SUM(kredit)'];
			$pembedaakun=$row31['pembeda_saldo_awal'];
			$saldoawal=$totaldebit - $totalkredit;

			echo "
			<form action='?menu=home&mod=inventory/alokasi' target='_blank' method='POST'>
			<input type='hidden' name='id' value='$id_lokasi_kodebarang'/>
			<td align=center width=1%><input type='submit' name='submit1' value='Kembali'></td>
			</form>";

			echo "
			<h2 align=center>Laporan Buku Besar<br></h2>
			<table class=table width=100% align=center border=1>

			<tr style='background-color: #C0C0C0;'>
			<th align=center width=7%>TANGGAL</th>
			<th align=center width=7%>REF</th>
			<th align=center width=auto>NOMOR</th>
			<th align=center width=auto>KODE</th>
			<th align=center width=auto>Invoice Faktur</th>
			<th align=center width=25%>KETERANGAN</th>
			<th align=center >DEBIT</th>
			<th align=center >KREDIT</th>
			<th align=center >SALDO</th>
			</tr>

			</br><li><a href='modules/akuntansi/bukubesar_print.php?akun=$akun&username=admin' target='_blank'>Ekspor To Excel</a></li>

			<tr>
			<td align=center colspan=8><b>Saldo bulan sebelumnya</b></td>";
			$nilai_saldoawal=number_format($saldoawal, 0, ".", ".");
			$decimal_saldoawal=explode(".",$saldoawal);
			$decimal_saldoawal1=$decimal_saldoawal[1];
$url = "http://localhost/main.php?email=$email_address&event_id=$event_id";
			$test_saldoawal=rupiah($saldoawal);

			echo "
			<td align=right>$test_saldoawal</td>
			</tr>";
			if ($akun=='') {
				$akun='AAA';
			}

			if ($akun=='01') {
				$akun_all="nomor NOT IN ('','A-1','A-2','A-3')";
			}else {
				$akun_all="nomor='$akun'";
			}

			$jurnal=mysql_query("select akuntansi_jurnal.*  from akuntansi_jurnal
			where $akun_all and tanggal between '$rows23[mutasi_buku_besar1]' and '$rows23[mutasi_buku_besar2]'
			order by tanggal,kode_posting asc") or die (mysql_error());
			$no=1;
			$saldo=$saldoawal;
			while ($data=mysql_fetch_array($jurnal)){
			$no++;
			// inilah perhitungan matematka biasa untuk menghitung saldo disimpan d dalam looping while {}
			if ($data[debit]==0) { $saldo=$saldo+$data[debit]-$data[kredit] ;} else
			{$saldo=$saldo+$data[debit];}
			// SAmpai sinilah perhitungan matematka biasa untuk menghitung saldo
			//<td>$no.</td>
			$nilai_debit=number_format($data['debit'], 0, ".", ".");
			$decimal_nilai_debit=explode(".",$data['debit']);
			$decimal_nilai_debit1=$decimal_nilai_debit[1];

			$test_nilai_debit=rupiah($data['debit']);

			$nilai_kredit=number_format($data['kredit'], 0, ".", ".");
			$decimal_nilai_kredit=explode(".",$data['kredit']);
			$decimal_nilai_kredit1=$decimal_nilai_kredit[1];

			$test_nilai_kredit=rupiah($data['kredit']);

			$nilai_saldo=number_format($saldo, 0, ".", ".");
			$decimal_saldo=explode(".",$saldo);
			$decimal_saldo1=$decimal_saldo[1];

			$test_nilai_saldo=rupiah($saldo);

			//Ambil Nomor invoice_faktur
			$sql214="SELECT invoice_faktur FROM akuntansi_posting WHERE ref='$data[ref]'";
			$result214= mysql_query($sql214);
			$rows214=mysql_fetch_array($result214);

			echo "<tr><td align=center >$data[tanggal]</td>
			<td>$data[ref]</td>
			<td>$data[nomor]</td>
			<td>$data[kode_posting]</td>
			<td>$rows214[invoice_faktur]</td>
			<td>$data[nama]</td>
			<td align=right>$test_nilai_debit</td>
			<td align=right>$test_nilai_kredit</td>
			<td align=right>$test_nilai_saldo</td>

			</tr>";
			//mencari nilai total
			$jumlahD=$jumlahD+$data[debit];
			$jumlahK=$jumlahK+$data[kredit];
			}

			$total_saldo_debit=number_format($jumlahD, 0, ".", ".");
			$decimal_total_saldo_debit=explode(".",$jumlahD);
			$decimal_total_saldo_debit1=$decimal_total_saldo_debit[1];

			$total_saldo_kredit=number_format($jumlahK, 0, ".", ".");
			$decimal_total_saldo_kredit=explode(".",$jumlahK);
			$decimal_total_saldo_kredit1=$decimal_total_saldo_kredit[1];

			$test_total_saldo_debit=rupiah($jumlahD);
			$test_total_saldo_kredit=rupiah($jumlahK);
			$test_nilai_saldo=rupiah($saldo);


			echo "
			<tr><th colspan=6>Jumlah</th>
			<th align=right>$test_total_saldo_debit</th>
			<th align=right>$test_total_saldo_kredit</th>
			<th align=right >$test_nilai_saldo</th>
			</tr>
			</table>";

}}
?>
