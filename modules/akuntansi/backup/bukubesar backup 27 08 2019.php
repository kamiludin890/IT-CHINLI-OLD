<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row,$p, $akses ;

	$mod="akuntansi/bukubesar";
	$tbl='akuntansi_jurnal';
	$fld='id,tanggal,nomor,nama,keterangan,debit,kredit' ;
	$p = getrow("periode1,periode2","master_setting","");

function editmenu(){extract($GLOBALS);
echo usermenu('export');
	}
function home(){extract($GLOBALS);
	buku_besar();
	}

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
	<option value='12'>November</option>
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
			      if($jenis_doc=='BC 2.7 MASUK'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1"; $saldo_kredit="Rp. $totalbayar1,$decimal_total_bayar1";} else {}
			      if($jenis_doc=='BC 4.0 LOKAL'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1"; $saldo_kredit="Rp. $totalbayar1,$decimal_total_bayar1";} else {}
						if($jenis_doc=='BC 2.3 IMPORT'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1"; $saldo_kredit="Rp. $totalbayar1,$decimal_total_bayar1";} else {}
						if($jenis_doc=='BC 2.6.2 HASIL SUBKON'){$nomor_aju_debet=$rows1['nomor_aju']; $nomor_aju_kredit=''; $warna_debet='yellow'; $warna_kredit=''; $sisa=$nilai_transaksi-$totalbayar; $saldo_debet="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1"; $saldo_kredit="Rp. $totalbayar1,$decimal_total_bayar1";} else {}

						if($jenis_doc=='BC 3.0 PEB'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet="Rp. $totalbayar1,$decimal_total_bayar1"; $saldo_kredit="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1";} else {}
			      if($jenis_doc=='BC 2.5 PIB'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet="Rp. $totalbayar1,$decimal_total_bayar1"; $saldo_kredit="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1";} else {}
			      if($jenis_doc=='BC 2.6.1 SUBKON'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet="Rp. $totalbayar1,$decimal_total_bayar1"; $saldo_kredit="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1";} else {}
			      if($jenis_doc=='BC 2.7 KELUAR'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet="Rp. $totalbayar1,$decimal_total_bayar1"; $saldo_kredit="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1";} else {}
			      if($jenis_doc=='BC 4.1 PENJUALAN'){$nomor_aju_debet=''; $nomor_aju_kredit=$rows1['nomor_aju']; $warna_kredit='yellow'; $warna_debet=''; $sisa=$totalbayar-$nilai_transaksi; $saldo_debet="Rp. $totalbayar1,$decimal_total_bayar1"; $saldo_kredit="Rp. $nilai_transaksi1,$decimal_nilai_transaksi1";} else {}

							$sisa1=number_format($sisa, 0, ".", ".");
							$decimal_sisa=explode(".",$sisa);
							$decimal_sisa1=$decimal_sisa[1];

	echo "<tr>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$n</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[tanggal_doc]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[jenis_doc]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nomor_aju]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows21[tanggal]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[kontak]</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows21[keterangan_debit]</td>
    <td style='background-color:$warna_debet; padding-left:5px; padding-right:10px; text-align:right;'>$saldo_debet</td>
    <td style='background-color:$warna_kredit; padding-left:5px; padding-right:5px; text-align:right;'>$saldo_kredit</td>
    <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:right;'>Rp. $sisa1,$decimal_sisa1</td>";
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

$seluruh_debit=$total_debit+$total_debit_posting;
$seluruh_kredit=$total_kredit+$total_kredit_posting;
$seluruh_sisa=$seluruh_debit-$seluruh_kredit;

//Seluruh Saldo Debit
$seluruh_debit1=number_format($seluruh_debit, 0, ".", ".");
$seluruh_debit_decimal=explode(".",$seluruh_debit);
$seluruh_debit_decimal1=$seluruh_debit_decimal[1];

//Seluruh Saldo Kredit
$seluruh_kredit1=number_format($seluruh_kredit, 0, ".", ".");
$seluruh_kredit_decimal=explode(".",$seluruh_kredit);
$seluruh_kredit_decimal1=$seluruh_kredit_decimal[1];

$seluruh_sisa1=number_format($seluruh_sisa, 0, ".", ".");
$seluruh_sisa_decimal=explode(".",$seluruh_sisa);
$seluruh_sisa_decimal1=$seluruh_sisa_decimal[1];

echo"<tr>";
echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='7'>Jumlah</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>Rp $seluruh_debit1,$seluruh_debit_decimal1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>Rp $seluruh_kredit1,$seluruh_kredit_decimal1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>Rp $seluruh_sisa1,$seluruh_sisa_decimal1</th>";
echo"</tr>";
echo"</table>";

}else {

	$limit = 10000;
	if (isset($_POST['akun']) ){
	$akun=$_POST['akun'];
	$bb = getrow("nomor,nama","akuntansi_akun","where nomor=$akun");
	$rest ="where nomor='$akun'  AND tanggal LIKE '%$data304[tanggal_pencarian_buku_besar]%' ORDER BY id";}
	else { $rest =" where nomor='111'  and tanggal LIKE '%$data304[tanggal_pencarian_buku_besar]%'";}

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

 	$result1=mysql_query("SELECT nomor, nama FROM akuntansi_akun ");
	echo "<select name='akun' onChange=submitform('buku_besar'); return false;>";
	while ($r1=mysql_fetch_array($result1))  {
	if($akun==$r1['nomor']){$t = 'selected'; }else{$t = '';}
	echo"<option value=$r1[nomor] $t >$r1[nama] </option>";}
	echo"</select>";
//	echo"<button type=submit value='buku_besar' name='mybutton' class='formbutton' >Tampil</button>";
 	echo "<h2>".l('bukubesar')." $bb[nama] </h2>";
//	echo  "Periode :". $p[0] . " s/d ". $p[1];

 	echo "<table class=sortable id='table-k' ><thead><tr>";
 	echo "<th>No</th>";

	$no=1;
	$kolom = explode(",", $data);
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>$kolom[$i]</th>"; }
	echo "<th>Saldo</th>";
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  {

	$debit    = $debit + $row['debit'];
	$kredit   = $kredit + $row['kredit'];
	$saldo		= $debit - $kredit;

	echo "<tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' >";
	echo "<td>$no</td>";
	for ($i = 0; $i < count($kolom); ++$i) { echo "<td class=difcursor >$row[$i]</td> "; }
	echo "<td class=difcursor >".format_rupiah($saldo)."</td> ";
	echo "</tr>";
	$no++;
	}

	echo "<tr>
	<td colspan=6> Total</td>
	<td >".format_rupiah($debit)."</td>
	<td >".format_rupiah($kredit)." </td>
	<td >".format_rupiah($saldo)."</td>
	</tr>";
	echo "</tbody></table>";
	echo "</form>";
	echo "</div >";
}}
?>
