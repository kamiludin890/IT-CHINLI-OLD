<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row ,$p, $periode, $akses, $tl;
	$mod='akuntansiv3/laporan';
	$tbl='akuntansiv3_jurnal';


	function editmenu(){extract($GLOBALS);
		if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');}
		elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
		elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
		else{echo usermenu('add,delete');}
		}


		function rupiah($angka){
		  $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		  return $hasil_rupiah;
		 }


	function home(){extract($GLOBALS);
	$username10=$_SESSION['username'];

		echo "
		<h2 style='text-align:center'>PT. CHINLI PLASTIC MATERIALS INDONESIA</h2>
		";

$jenis_laporan=$_POST['jenis_laporan'];
echo "</br>
<form method ='post' action='?menu=home&mod=akuntansiv3/laporan'>
<tr>
 <td>LAPORAN</td>
 <td>:</td>
 <td><select name='jenis_laporan'>
<option value='$jenis_laporan'>".$jenis_laporan."</option>
 <option value='LAPORAN NERACA'>LAPORAN NERACA</option>
 <option value='LABA RUGI'>LABA RUGI</option>
 <option value='PERHITUNGAN POKOK HARGA PENJUALAN'>PERHITUNGAN POKOK HARGA PENJUALAN</option>
</tr>

<tr>
 <td></td>
 <td></td>
 <td><input type='submit' value='Tampilkan'></td>
</tr>
</form>
</br>";


//START JENIS-lAPORAN
if ($jenis_laporan=='LAPORAN NERACA') {

	$saldo_awal1=$_POST['saldo_awal1'];
	$saldo_awal2=$_POST['saldo_awal2'];
	$mutasi1=$_POST['mutasi1'];
	$mutasi2=$_POST['mutasi2'];

	if ($mutasi1>0) {
		$sql3="UPDATE master_user SET saldo_awal1='$saldo_awal1',saldo_awal2='$saldo_awal2',mutasi1='$mutasi1',mutasi2='$mutasi2' WHERE email='$username10'";
		$eksekusi_sql3=mysql_query($sql3);
	}

	$sql2="SELECT * FROM master_user WHERE email='$username10'";
	$result2= mysql_query($sql2);
	$rows2=mysql_fetch_array($result2);

echo "
<h3 style='text-align:left'>Periode Laporan</h3>";

echo "<form method ='post' action='?menu=home&mod=akuntansiv3/laporan'>
<table>
<tr>
 <td>Periode Saldo Awal</td>
 <td>:</td>
 <td><input type='date' name='saldo_awal1' value='$rows2[saldo_awal1]'></td>

 <td>Sampai</td>
 <td>:</td>
 <td><input type='date' name='saldo_awal2' value='$rows2[saldo_awal2]'></td>
</tr>

<tr>
 <td>Periode Mutasi</td>
 <td>:</td>
 <td><input type='date' name='mutasi1' value='$rows2[mutasi1]'></td>

 <td>Sampai</td>
 <td>:</td>
 <td><input type='date' name='mutasi2' value='$rows2[mutasi2]'></td>

 <td><input type='hidden' name='jenis_laporan' value='LAPORAN NERACA'></td>

 <td><input type='submit' value='Tampilkan'></td>
</tr>
</table>
</form>
";


echo "
<h2 style='text-align:center'>LAPORAN NERACA</h2>
<body>
		<table border='1' width='100%'>
				<tr style='background-color: #808080;'>
						<td rowspan='2' align='center'>No</td>
						<td rowspan='2' align='center'>NO.PERK</td>
						<td rowspan='2' align='center'>NAMA PERKIRAAN	</td>
						<td colspan='2' align='center'>SALDO AWAL</td>
						<td colspan='2' align='center'>MUTASI</td>
						<td colspan='2' align='center'>SALDO AKHIR</td>
				</tr>
				<tr style='background-color: #C0C0C0;'>
						<td align='center'>DEBET</td>
						<td align='center'>KREDIT</td>
						<td align='center'>DEBET</td>
						<td align='center'>KREDIT</td>
						<td align='center'>DEBET</td>
						<td align='center'>KREDIT</td>
				</tr>";

//$sql1="SELECT DISTINCT keterangan,nomor FROM akuntansiv3_jurnal WHERE tanggal BETWEEN '2019-08-01' AND '2019-08-31' AND nomor>'0' ORDER BY nomor";
$sql1="SELECT * FROM akuntansiv3_akun WHERE nomor>'0' AND kolom IN ('DEBIT','KREDIT') ORDER BY nomor";
$result1=mysql_query($sql1);
$n=1;
while ($rows1=mysql_fetch_array($result1)){

	if ($rows1[tampil]=='yes') {
		$warna_master='';
	}else {
		$warna_master="style='background-color:#87CEFA;'";
	}

echo "  <tr>
						<td $warna_master align='center'>$n</td>
						<td $warna_master >$rows1[nomor]</td>
						<td $warna_master >$rows1[nama]</td>";

						//Nilai Saldo Awal
						$query2="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal BETWEEN '$rows2[saldo_awal1]' AND '$rows2[saldo_awal2]'";
						$result2=mysql_query($query2);
						$row2=mysql_fetch_array($result2);

						$totaldebit=$row2['SUM(debit)'];
						$totalkredit=$row2['SUM(kredit)'];
						$hasil_total1=$totaldebit-$totalkredit;

						if ($rows1[kolom]=='DEBIT'){$hasil_total_debit=$hasil_total1; $hasil_total_kredit='';}
						if ($rows1[kolom]=='KREDIT'){$hasil_total_kredit=$hasil_total1; $hasil_total_debit='';}

						$grand_hasil_total_saldo_awal_debit=$grand_hasil_total_saldo_awal_debit+$hasil_total_debit;
						$grand_hasil_total_saldo_awal_kredit=$grand_hasil_total_saldo_awal_kredit+$hasil_total_kredit;

						$hasil_total_debit1=rupiah($hasil_total_debit);
						$hasil_total_kredit1=rupiah($hasil_total_kredit);

echo "      <td $warna_master align='right'>$hasil_total_debit1</td>
						<td $warna_master align='right'>$hasil_total_kredit1</td>";
						//End Nilai Saldo Awal

						//Nilai Mutasi
						$query3="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal BETWEEN '$rows2[mutasi1]' AND '$rows2[mutasi2]'";
						$result3=mysql_query($query3);
						$row3=mysql_fetch_array($result3);

						$totalmutasidebit=$row3['SUM(debit)'];
						$totalmutasikredit=$row3['SUM(kredit)'];

						$grand_hasil_total_mutasi_debit=$grand_hasil_total_mutasi_debit+$totalmutasidebit;
						$grand_hasil_total_mutasi_kredit=$grand_hasil_total_mutasi_kredit+$totalmutasikredit;

						$totalmutasidebit1=rupiah($totalmutasidebit);
						$totalmutasikredit1=rupiah($totalmutasikredit);

echo "   		<td $warna_master align='right'>$totalmutasidebit1</td>
						<td $warna_master align='right'>$totalmutasikredit1</td>";
						//End Mutasi

						//Saldo Akhir
						if ($hasil_total_debit==0) {
							$saldo_akhir_debit='';
							$saldo_akhir_kredit=$hasil_total_kredit-$totalmutasidebit+$totalmutasikredit;}
						if ($hasil_total_kredit==0) {
							$saldo_akhir_debit=$hasil_total_debit+$totalmutasidebit-$totalmutasikredit;
							$saldo_akhir_kredit='';}

						$grand_hasil_saldo_akhir_debit=$grand_hasil_saldo_akhir_debit+$saldo_akhir_debit;
						$grand_hasil_saldo_akhir_kredit=$grand_hasil_saldo_akhir_kredit+$saldo_akhir_kredit;

						$saldo_akhir_debit1=rupiah($saldo_akhir_debit);
						$saldo_akhir_kredit1=rupiah($saldo_akhir_kredit);

echo "   		<td $warna_master align='right'>$saldo_akhir_debit1</td>
						<td $warna_master align='right'>$saldo_akhir_kredit1</td></tr>";
						//END Saldo Akhir
$n++;}

$grand_hasil_total_saldo_awal_debit1=rupiah($grand_hasil_total_saldo_awal_debit);
$grand_hasil_total_saldo_awal_kredit1=rupiah($grand_hasil_total_saldo_awal_kredit);
$grand_hasil_total_mutasi_debit1=rupiah($grand_hasil_total_mutasi_debit);
$grand_hasil_total_mutasi_kredit1=rupiah($grand_hasil_total_mutasi_kredit);
$grand_hasil_saldo_akhir_debit1=rupiah($grand_hasil_saldo_akhir_debit);
$grand_hasil_saldo_akhir_kredit1=rupiah($grand_hasil_saldo_akhir_kredit);

echo"<tr>";
echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='3'>Jumlah</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_hasil_total_saldo_awal_debit1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_hasil_total_saldo_awal_kredit1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_hasil_total_mutasi_debit1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_hasil_total_mutasi_kredit1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_hasil_saldo_akhir_debit1</th>";
echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_hasil_saldo_akhir_kredit1</th>";
echo"</tr>";
echo"</table>";

echo "
</body>
";//END NERACA
}


//START LABA RUGI
if ($jenis_laporan=='LABA RUGI') {

	$periode_laba_rugi_update=$_POST['tahun'];

	if ($periode_laba_rugi_update>0) {
		$sql3="UPDATE master_user SET periode_laba_rugi='$periode_laba_rugi_update' WHERE email='$username10'";
		$eksekusi_sql3=mysql_query($sql3);
	}

	$sql2="SELECT * FROM master_user WHERE email='$username10'";
	$result2= mysql_query($sql2);
	$rows2=mysql_fetch_array($result2);
	$periode_laba_rugi=$rows2['periode_laba_rugi'];

	echo "
	<h3 style='text-align:left'>Periode Laporan</h3>";

	echo "<form method ='post' action='?menu=home&mod=akuntansiv3/laporan'>";?>
	Tahun
	<select name='tahun'>
	<?php
	$mulai= date('Y') - 50;
	for($i = $mulai;$i<$mulai + 100;$i++){
	    $sel = $i == date('Y') ? ' selected="selected"' : '';
	    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
	}
	?>

	<input type= "hidden" name="jenis_laporan" value="LABA RUGI">
	<input type="submit" value="Cari">
	</form>
	</select>

	<?php

//PENJUALAN
	echo "
	<h2 style='text-align:center'>LAPORAN LABA RUGI ($periode_laba_rugi)</h2>
	<body>
		<table border='1' width='100%'>
				<tr style='background-color: white;'>
						<td align='center'>KODE</td>
						<td align='right'>PENJUALAN</td>
						<td align='center'>-</td>
						<td align='center'>-</td>
						<td align='center'>-</td>
				</tr>";
	$sql1="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='PENJUALAN' ORDER BY nomor";
  $result1=mysql_query($sql1);
	$n=1;
	while ($rows1=mysql_fetch_array($result1)){
	$query34="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal LIKE '$periode_laba_rugi%'";
	$result34=mysql_query($query34);
	$row34=mysql_fetch_array($result34);
	$nilai_penjualan_kredit=$row34['SUM(kredit)'];
	$grand_total_penjualan=$grand_total_penjualan+$nilai_penjualan_kredit;

	$nilai_penjualan_kredit1=rupiah($nilai_penjualan_kredit);

	echo "<tr>
				<td align='center'>$rows1[nomor]</td>
				<td>$rows1[nama]</td>
				<td align='right'>$nilai_penjualan_kredit1</td>
				<td></td>
				<td></td>
				</tr>";
			}
			$sql1="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='RETUR/PPN PENJUALAN' ORDER BY nomor";
		  $result1=mysql_query($sql1);
			$n=1;
			while ($rows1=mysql_fetch_array($result1)){
			$query46="SELECT SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal LIKE '%$periode_laba_rugi%'";
			$result46=mysql_query($query46);
			$row46=mysql_fetch_array($result46);
			$nilai_penjualan_kredit47=$row46['SUM(kredit)'];
			$grand_total_ppn_penjualan=$grand_total_ppn_penjualan+$nilai_penjualan_kredit47;

			$nilai_penjualan_kredit471=rupiah($nilai_penjualan_kredit47);
			echo "<tr>
						<td align='center'>$rows1[nomor]</td>
						<td>$rows1[nama]</td>
						<td align='right'>$nilai_penjualan_kredit471</td>
						<td></td>
						<td></td>
						</tr>";}

			$grand_total_penjualan_bersih=$grand_total_penjualan+$grand_total_ppn_penjualan;
			$grand_total_penjualan_bersih1=rupiah($grand_total_penjualan_bersih);

			echo"<tr>";
			echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>PENJUALAN BERSIH</th>";
			echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
			echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
			echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_penjualan_bersih1</th>";
			echo"</tr>";
//END PENJUALAN



//HARGA POKOK PENJUALAN
			echo "
			<body>
						<tr style='background-color: white;'>
								<td align='center'></td>
								<td align='right'>HARGA POKOK PENJUALAN</td>
								<td align='center'>-</td>
								<td align='center'>-</td>
								<td align='center'>-</td>
						</tr>";
			$sql1="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='HARGA POKOK PENJUALAN' ORDER BY nomor";
		  $result1=mysql_query($sql1);
			$n=1;
			while ($rows1=mysql_fetch_array($result1)){
			$query38="SELECT SUM(debit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal LIKE '%$periode_laba_rugi%'";
			$result38=mysql_query($query38);
			$row38=mysql_fetch_array($result38);
			$nilai_penjualan_kredit=$row38['SUM(debit)'];
			$grand_total_harga_pokok_penjualan=$grand_total_harga_pokok_penjualan+$nilai_penjualan_kredit;
			$nilai_penjualan_kredit1=rupiah($nilai_penjualan_kredit);
			$grand_total_harga_pokok_penjualan1=rupiah($grand_total_harga_pokok_penjualan);

			echo "<tr>
						<td align='center'>$rows1[nomor]</td>
						<td>$rows1[nama]</td>
						<td align='right'>$nilai_penjualan_kredit1</td>
						<td></td>
						<td></td>
						</tr>";
					}
					$grand_total_penjualan_bersih_harga_pokok_penjualan=$grand_total_penjualan_bersih-$grand_total_harga_pokok_penjualan;
					$grand_total_penjualan_bersih_harga_pokok_penjualan1=rupiah($grand_total_penjualan_bersih_harga_pokok_penjualan);
					echo"<tr>";
					echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>BARANG TERSEDIA DI JUAL</th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_harga_pokok_penjualan1</th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_penjualan_bersih_harga_pokok_penjualan1</th>";
					echo"</tr>";
//END HARGA POKOK PENJUALAN



//HARGA PERSEDIAAN BARANG JADI
			echo "
			<body>
						<tr style='background-color: white;'>
								<td align='center'></td>
								<td align='right'>PERSEDIAAN BARANG JADI</td>
								<td align='center'>-</td>
								<td align='center'>-</td>
								<td align='center'>-</td>
						</tr>";
			$sql1="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='PERSEDIAAN BARANG JADI' ORDER BY nomor";
		  $result1=mysql_query($sql1);
			$n=1;
			while ($rows1=mysql_fetch_array($result1)){
			$query42="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal LIKE '%$periode_laba_rugi%'";
			$result42=mysql_query($query42);
			$row42=mysql_fetch_array($result42);
			$nilai_penjualan_debit=$row42['SUM(debit)'];
			$nilai_penjualan_kredit=$row42['SUM(kredit)'];
			$nilai_penjualan_debit_kredit=$nilai_penjualan_debit-$nilai_penjualan_kredit;

			$grand_total_persediaan_barang_jadi=$grand_total_persediaan_barang_jadi+$nilai_penjualan_debit_kredit;

			$grand_total_persediaan_barang_jadi1=rupiah($grand_total_persediaan_barang_jadi);
			$nilai_penjualan_debit_kredit1=rupiah($nilai_penjualan_debit_kredit);

			echo "<tr>
						<td align='center'>$rows1[nomor]</td>
						<td>$rows1[nama]</td>
						<td></td>
						<td align='right'>$nilai_penjualan_debit_kredit1</td>
						<td></td>
						</tr>";
					}

					echo"<tr>";
					echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>HARGA POKOK PENJUALAN</th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_persediaan_barang_jadi1</th>";
					echo"</tr>";
					//END PERSEDIAAN BARANG JADI


					// LABA OPERASI
					$grand_total_laba_operasi=$grand_total_penjualan_bersih_harga_pokok_penjualan-$grand_total_persediaan_barang_jadi;
					$grand_total_laba_operasi1=rupiah($grand_total_laba_operasi);
					echo"<tr>";
					echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>LABA OPERASI</th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_laba_operasi1</th>";
					echo"</tr>";
					// END LABA OPERASI

					//BIAYA USAHA OPERASIONAL
					echo "
					<body>
					<tr style='background-color: white;'>
					<td align='center'></td>
					<td align='right'>BIAYA USAHA OPERASIONAL</td>
		  		<td align='center'>-</td>
					<td align='center'>-</td>
					<td align='center'>-</td>
					</tr>
					<tr style='background-color: white;'>
					<td align='center'></td>
					<td align='right'>BIAYA PEMASARAN</td>
					<td align='center'>-</td>
					<td align='center'>-</td>
					<td align='center'>-</td>
					</tr>";
				  $sql1="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='BIAYA PEMASARAN' ORDER BY nomor";
				  $result1=mysql_query($sql1);
					$n=1;
					while ($rows1=mysql_fetch_array($result1)){
				  $query38="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal LIKE '%$periode_laba_rugi%'";
				  $result38=mysql_query($query38);
					$row38=mysql_fetch_array($result38);
			  	$nilai_penjualan_debit=$row38['SUM(debit)'];
			  	$nilai_penjualan_kredit=$row38['SUM(kredit)'];
					$nilai_penjualan_debit_kredit=$nilai_penjualan_kredit;//$nilai_penjualan_debit-

//					$grand_total_biaya_pemasaran=$grand_total_biaya_pemasaran+$nilai_penjualan_debit_kredit;

//					$grand_total_biaya_pemasaran1=rupiah($grand_total_biaya_pemasaran);
					$nilai_penjualan_debit_kredit1=rupiah($nilai_penjualan_debit_kredit);

					echo "<tr>
					<td align='center'>$rows1[nomor]</td>
					<td>$rows1[nama]</td>
					<td align='right'>$nilai_penjualan_debit_kredit1</td>
					<td></td>
					<td></td>
					</tr>";
		    	}

					$sqlbp="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='BIAYA POTONGAN' ORDER BY nomor";
					$resultbp=mysql_query($sqlbp);
					$n=1;
					while ($rowsbp=mysql_fetch_array($resultbp)){
					$querybp1="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rowsbp[nomor]' AND tanggal LIKE '%$periode_laba_rugi%'";
					$resultbp1=mysql_query($querybp1);
					$rowbp1=mysql_fetch_array($resultbp1);
					$biaya_potongan_debit=$rowbp1['SUM(debit)'];
					$biaya_potongan_kredit=$rowbp1['SUM(kredit)'];
					$biaya_potongan_debit_kredit=$biaya_potongan_debit-$biaya_potongan_kredit;//$nilai_penjualan_debit-
					$biaya_potongan_debit_kredit_test=$biaya_potongan_debit_kredit_test+$biaya_potongan_debit_kredit;
					$biaya_potongan_debit_kredit1=rupiah($biaya_potongan_debit_kredit);

					$grand_total_biaya_pemasaran=$biaya_potongan_debit_kredit_test+$nilai_penjualan_debit_kredit;
					$grand_total_biaya_pemasaran1=rupiah($grand_total_biaya_pemasaran);

					echo "<tr>
					<td align='center'>$rowsbp[nomor]</td>
					<td>$rowsbp[nama]</td>
					<td align='right'>$biaya_potongan_debit_kredit1</td>
					<td></td>
					<td></td>
					</tr>";
					}

					$grand_total_laba_operasi_biaya_pemasaran=$grand_total_laba_operasi-$grand_total_biaya_pemasaran;
					$grand_total_laba_operasi_biaya_pemasaran1=rupiah($grand_total_laba_operasi_biaya_pemasaran);

					echo"<tr>";
					echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>JUMLAH BEBAN PEMASARAN</th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_biaya_pemasaran1</th>";
					echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_laba_operasi_biaya_pemasaran1</th>";
					echo"</tr>";
	//END BIAYA USAHA OPERASIONAL



	//BIAYA ADMINISTRASI UMUM
	echo "
	<body>
	<tr style='background-color: white;'>
	<td align='center'></td>
	<td align='right'>BIAYA ADMINISTRASI UMUM</td>
	<td align='center'>-</td>
	<td align='center'>-</td>
	<td align='center'>-</td>
	</tr>";

	$sql1="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='BIAYA ADMINISTRASI UMUM' ORDER BY nomor";
	$result1=mysql_query($sql1);
	$n=1;
	while ($rows1=mysql_fetch_array($result1)){
	$query38="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal LIKE '%$periode_laba_rugi%'";
	$result38=mysql_query($query38);
	$row38=mysql_fetch_array($result38);
	$nilai_penjualan_debit=$row38['SUM(debit)'];
	$nilai_penjualan_kredit=$row38['SUM(kredit)'];

	$nilai_penjualan_debit_kredit=$nilai_penjualan_debit+$nilai_penjualan_kredit;
	$grand_total_biaya_administrasi_umum=$grand_total_biaya_administrasi_umum+$nilai_penjualan_debit_kredit;

	$nilai_penjualan_debit_kredit1=rupiah($nilai_penjualan_debit_kredit);
	$grand_total_biaya_administrasi_umum1=rupiah($grand_total_biaya_administrasi_umum);

	echo "<tr>
	<td align='center'>$rows1[nomor]</td>
	<td>$rows1[nama]</td>
	<td align='right'>$nilai_penjualan_debit_kredit1</td>
	<td></td>
	<td></td>
	</tr>";
	}

	$grand_total_beban_adm_umum=$grand_total_laba_operasi_biaya_pemasaran-$grand_total_biaya_administrasi_umum;
	$grand_total_beban_adm_umum1=rupiah($grand_total_beban_adm_umum);

	echo"<tr>";
	echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>JUMLAH BEBAN ADM UMUM</th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_biaya_administrasi_umum1</th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_beban_adm_umum1</th>";
	echo"</tr>";
	//END BIAYA ADMINISTRASI UMUM



	//BIAYA PENDAPATAN DAN KEUNTUNGAN LAIN LAIN
	echo "
	<body>
	<tr style='background-color: white;'>
	<td align='center'></td>
	<td align='right'>PENDAPATAN DAN KEUNTUNGAN LAIN LAIN</td>
	<td align='center'>-</td>
	<td align='center'>-</td>
	<td align='center'>-</td>
	</tr>";

	$sql1="SELECT * FROM akuntansiv3_akun WHERE pembeda_laba_rugi='PENDAPATAN LAIN LAIN' ORDER BY nomor";
	$result1=mysql_query($sql1);
	$n=1;
	while ($rows1=mysql_fetch_array($result1)){
	$query38="SELECT SUM(debit) FROM akuntansiv3_jurnal WHERE nomor='$rows1[nomor]' AND tanggal LIKE '%$periode_laba_rugi%'";
	$result38=mysql_query($query38);
	$row38=mysql_fetch_array($result38);
	$nilai_penjualan_debit=$row38['SUM(debit)'];

	$grand_total_nilai_penjualan_debit=$grand_total_nilai_penjualan_debit+$nilai_penjualan_debit;

	$nilai_penjualan_debit1=rupiah($nilai_penjualan_debit);
	$grand_total_nilai_penjualan_debit1=rupiah($grand_total_nilai_penjualan_debit);


	echo "<tr>
	<td align='center'>$rows1[nomor]</td>
	<td>$rows1[nama]</td>
	<td align='right'>$nilai_penjualan_debit1</td>
	<td></td>
	<td></td>
	</tr>";
	}

	$grand_total_pendapatan_lain_lain=$grand_total_beban_adm_umum+$grand_total_nilai_penjualan_debit;
	$grand_total_pendapatan_lain_lain1=rupiah($grand_total_pendapatan_lain_lain);

	echo"<tr>";
	echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>PENDAPATAN LAIN LAIN</th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_nilai_penjualan_debit1</th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'>$grand_total_pendapatan_lain_lain1</th>";
	echo"</tr>";

	echo"<tr>";
	echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>LABA SEBELUM PAJAK PENGHASILAN</th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'>$hasil_pendapatan_lain_lain1,$decimal_hasil_pendapatan_lain_lain1</th>";
	echo"</tr>";
	//END BIAYA PENDAPATAN DAN KEUNTUNGAN LAIN LAIN




	//BIAYA LABA BERSIH
	$query40="SELECT SUM(debit) FROM akuntansiv3_jurnal WHERE pembeda_laba_rugi='PAJAK PENGHASILAN' AND tanggal LIKE '%$periode_laba_rugi%'";
	$result40=mysql_query($query40);
	$row40=mysql_fetch_array($result40);
	$penjualan_bersih_debit=$row40['SUM(debit)'];
	$query41="SELECT SUM(kredit) FROM akuntansiv3_jurnal WHERE pembeda_laba_rugi='PAJAK PENGHASILAN' AND tanggal LIKE '%$periode_laba_rugi%'";
	$result41=mysql_query($query41);
	$row41=mysql_fetch_array($result41);
	$penjualan_bersih_kredit=$row41['SUM(kredit)'];
	$hasil_penjualan_bersih=$penjualan_bersih_debit-$penjualan_bersih_kredit; $rumus_hasil_pajak_penghasilan=$penjualan_bersih_debit-$penjualan_bersih_kredit;

	$rumus_hasil_pajak_penghasilan1=number_format($rumus_hasil_pajak_penghasilan, 0, ".", ".");
	$decimal_rumus_hasil_pajak_penghasilan=explode(".",$rumus_hasil_pajak_penghasilan);
	$decimal_rumus_hasil_pajak_penghasilan1=$decimal_rumus_hasil_pajak_penghasilan[1];

	$hasil_laba_bersih=$hasil_pendapatan_lain_lain-$rumus_hasil_pajak_penghasilan;
	$hasil_laba_bersih1=number_format($hasil_laba_bersih, 0, ".", ".");
	$decimal_hasil_laba_bersih=explode(".",$hasil_laba_bersih);
	$decimal_hasil_laba_bersih1=$decimal_hasil_laba_bersih[1];

	echo"<tr>";
	echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>PAJAK PENGHASILAN</th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'>$rumus_hasil_pajak_penghasilan1,$decimal_rumus_hasil_pajak_penghasilan1</th>";
	echo"</tr>";

	echo"<tr>";
	echo"<th style='background-color:#DCDCDC; text-align:center;' colspan='2'>LABA BERSIH</th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'></th>";
	echo"<th style='background-color:#DCDCDC; text-align:right;'>$hasil_laba_bersih1,$decimal_hasil_laba_bersih1</th>";
	echo"</tr>";
	echo"</table>";
	//END LABA BERSIH
//END LABA RUGI
}//END BUKU BESAR


//START PERHITUNGAN POKOK HARGA PENJUALAN
if ($jenis_laporan=='PERHITUNGAN POKOK HARGA PENJUALAN') {
	echo "
	<h1 style='text-align:center'>PERHITUNGAN POKOK HARGA PENJUALAN</h1>";

	$saldo_awal1=$_POST['saldo_awal1'];
	$saldo_awal2=$_POST['saldo_awal2'];
	$mutasi1=$_POST['mutasi1'];
	$mutasi2=$_POST['mutasi2'];


if ($mutasi1>0) {
	$sql3="UPDATE master_user SET saldo_awal1='$saldo_awal1',saldo_awal2='$saldo_awal2',mutasi1='$mutasi1',mutasi2='$mutasi2' WHERE email='$username10'";
	$eksekusi_sql3=mysql_query($sql3);
}

$sql2="SELECT * FROM master_user WHERE email='$username10'";
$result2= mysql_query($sql2);
$rows2=mysql_fetch_array($result2);

$saldo_awal1=$rows2[saldo_awal1];
$saldo_awal2=$rows2[saldo_awal2];
$mutasi1=$rows2[mutasi1];
$mutasi2=$rows2[mutasi2];


	echo "
	<h3 style='text-align:left'>Periode Laporan</h3>";
	echo "<form method ='post' action='?menu=home&mod=akuntansiv3/laporan'>
	<table>
	<tr>
	<td>Persediaan Awal</td>
	<td>:</td>
	<td><input type='date' name='saldo_awal1' value='$saldo_awal1'></td>
	<td>Sampai</td>
	<td>:</td>
	<td><input type='date' name='saldo_awal2' value='$saldo_awal2'></td>
	</tr>
	<tr>
	<td>Periode Mutasi</td>
	<td>:</td>
	<td><input type='date' name='mutasi1' value='$mutasi1'></td>
	<td>Sampai</td>
	<td>:</td>
	<td><input type='date' name='mutasi2' value='$mutasi2'></td>
	<td><input type='hidden' name='jenis_laporan' value='PERHITUNGAN POKOK HARGA PENJUALAN'></td>
	<td><input type='submit' value='Tampilkan'></td>
	</tr>
	</table>
	</form></br></br>
	";

echo "
<table rules='none' border='1' width='100%' >
<tr>
<th style='background-color:#DCDCDC; width:15%; text-align:center;' colspan='2'>BAHAN BAKU</th>
  <th></th>
	<th></th>
	<th></th>
	<th></th>
</tr>";

//PERSDIAAN AWAL
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='120.500' AND tanggal BETWEEN '$saldo_awal1' AND '$saldo_awal2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$persediaan_awal=rupiah($persediaan_awal_debit-$persediaan_awal_kredit);
$persediaan_awal1=$persediaan_awal_debit-$persediaan_awal_kredit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>120</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PERSEDIAAN AWAL</th>
	<th style='text-align:right;'>$persediaan_awal</th>
	<th></th>
</tr>";
//END PERSDIAAN AWAL

//PEMBELIAN BAHAN BAKU DAN IMPORT
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('120','120.500','120.100') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$pembelian_bahan_baku_dan_import=rupiah($persediaan_awal_debit);
$pembelian_bahan_baku_dan_import1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>120.500 / 120.100</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PEMBELIAN BAHAN BAKU & IMPORT</th>
	<th style='text-align:right;'>$pembelian_bahan_baku_dan_import</th>
	<th></th>
</tr>";
//END PEMBELIAN BAHAN BAKU DAN IMPORT

//PEMBELIAN BAHAN BAKU PENOLONG
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('120.300','120.200') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$pembelian_bahan_baku_penolong=rupiah($persediaan_awal_debit);
$pembelian_bahan_baku_penolong1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>120.500 / 120.100</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PEMBELIAN BAHAN BAKU PENOLONG</th>
	<th style='text-align:right;'>$pembelian_bahan_baku_penolong</th>
	<th></th>
</tr>";
//END PEMBELIAN BAHAN BAKU PENOLONG

//PEMBELIAN BAHAN PEMBUNGKUS
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('120.400') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$pembelian_bahan_pembungkus=rupiah($persediaan_awal_debit);
$pembelian_bahan_pembungkus1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>120.400</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PEMBELIAN BAHAN PEMBUNGKUS</th>
	<th style='text-align:right;'>$pembelian_bahan_pembungkus</th>
	<th></th>
</tr>";
//END PEMBELIAN BAHAN PEMBUNGKUS

//POTONGAN PEMBELIAN
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('407.100') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$potongan_pembelian=rupiah($persediaan_awal_debit);
$potongan_pembelian1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>407.100</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>POTONGAN PEMBELIAN</th>
	<th style='text-align:right;'><u>$potongan_pembelian</u></th>
	<th></th>
</tr>";
//END POTONGAN PEMBELIAN

//TOTALAN PERTAMA
$totalan_pertama=rupiah($persediaan_awal1+$pembelian_bahan_baku_dan_import1+$pembelian_bahan_baku_penolong1+$pembelian_bahan_pembungkus1-$potongan_pembelian1);
$totalan_pertama1=$persediaan_awal1+$pembelian_bahan_baku_dan_import1+$pembelian_bahan_baku_penolong1+$pembelian_bahan_pembungkus1-$potongan_pembelian1;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>---</th>
	<th style='background-color:; width:50%; text-align:Right;' colspan='2'>TOTAL</th>
	<th></th>
	<th style='text-align:right;'>$totalan_pertama	</th>
</tr>";
//END TOTALAN PERTAMA

//PERSEDIAAN AKHIR BAHAN BAKU
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor='120' AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$persediaan_akhir_bahan_baku=rupiah($persediaan_awal_debit-$persediaan_awal_kredit);
$persediaan_akhir_bahan_baku1=$persediaan_awal_debit-$persediaan_awal_kredit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>120</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PERSEDIAAN AKHIR BAHAN BAKU</th>
	<th style='text-align:right;'><u>$persediaan_akhir_bahan_baku</u></th>
	<th></th>
</tr>";
//END PERSEDIAAN AKHIR BAHAN BAKU

//BAHAN YANG DI GUNAKAN
$totalan_kedua=rupiah($totalan_pertama1-$persediaan_akhir_bahan_baku1);
$totalan_kedua1=$totalan_pertama1-$persediaan_akhir_bahan_baku1;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>---</th>
	<th style='background-color:; width:50%; text-align:Right;' colspan='2'>BAHAN BAKU YANG DI GUNAKAN</th>
	<th></th>
	<th style='text-align:right;'>$totalan_kedua</th>
</tr>";
//END BAHAN YANG DI GUNAKAN

//PERSEDIAAN AWAL BARANG DALAM PROSES
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('121') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$persediaan_awal_barang_dalam_proses=rupiah($persediaan_awal_debit);
$persediaan_awal_barang_dalam_proses1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>121</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PERSEDIAAN AWAL BARANG DALAM PROSES</th>
	<th style='text-align:right;'>$persediaan_awal_barang_dalam_proses</th>
	<th></th>
</tr>";
//END PERSEDIAAN AWAL BARANG DALAM PROSES

//PERSEDIAAN AKHIR BARANG DALAM PROSES
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('121') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$persediaan_akhir_barang_dalam_proses=rupiah($persediaan_awal_debit-$persediaan_awal_kredit);
$persediaan_akhir_barang_dalam_proses1=$persediaan_awal_debit-$persediaan_awal_kredit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>121</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PERSEDIAAN AKHIR BARANG DALAM PROSES</th>
	<th style='text-align:right;'><u>$persediaan_akhir_barang_dalam_proses</u></th>
	<th></th>
</tr>";
//END PERSEDIAAN AKHIR BARANG DALAM PROSES

//TOTALAN KETIGA
$totalan_ketiga=rupiah($totalan_kedua1-$persediaan_awal_barang_dalam_proses1-$persediaan_akhir_barang_dalam_proses1);
$totalan_ketiga1=$totalan_kedua1-$persediaan_awal_barang_dalam_proses1-$persediaan_akhir_barang_dalam_proses1;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>---</th>
	<th style='background-color:; width:50%; text-align:Right;' colspan='2'>TOTAL</th>
	<th></th>
	<th style='text-align:right;'>$totalan_ketiga</th>
</tr>";
//END TOTALAN KETIGA

//PERSEDIAAN AWAL BARANG JADI
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('122.100','122.500','122.501') AND tanggal BETWEEN '$saldo_awal1' AND '$saldo_awal2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$persediaan_awal_barang_jadi=rupiah($persediaan_awal_debit-$persediaan_awal_kredit);
$persediaan_awal_barang_jadi1=$persediaan_awal_debit-$persediaan_awal_kredit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>122.100 / 122.500 / 122.501</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PERSEDIAAN AWAL BARANG JADI</th>
	<th style='text-align:right;'>$persediaan_awal_barang_jadi</th>
	<th></th>
</tr>";
//END PERSEDIAAN AWAL BARANG JADI

//PERSEDIAAN AKHIR BARANG JADI
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('122.100','122.500','122.501') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$persediaan_akhir_barang_jadi=rupiah($persediaan_awal_debit-$persediaan_awal_kredit);
$persediaan_akhir_barang_jadi1=$persediaan_awal_debit-$persediaan_awal_kredit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>122.100 / 122.500 / 122.501</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>PERSEDIAAN AKHIR BARANG JADI</th>
	<th style='text-align:right;'><u>$persediaan_akhir_barang_jadi</u></th>
	<th></th>
</tr>";
//END PERSEDIAAN AKHIR BARANG JADI

//TOTALAN KEEMPAT
$totalan_keempat=rupiah($totalan_ketiga1-$persediaan_awal_barang_jadi1-$persediaan_akhir_barang_jadi1);
$totalan_keempat1=$totalan_ketiga1-$persediaan_awal_barang_jadi1-$persediaan_akhir_barang_jadi1;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>---</th>
	<th style='background-color:; width:50%; text-align:Right;' colspan='2'>JUMLAH BAHAN YANG DI GUNAKAN</th>
	<th></th>
	<th style='text-align:right;'>$totalan_keempat</th>
</tr>";
//END TOTALAN KEEMPAT

//PERSEDIAAN BIAYA TENAGA KERJA LANGSUNG (GAJI & LEMBUR KARYAWAN)
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('466.100','466.200','466.500','466.800') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_tenaga_kerja=rupiah($persediaan_awal_debit-$persediaan_awal_kredit);
$biaya_tenaga_kerja1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>466.100 / 466.200 / 466.500 / 466.800</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA TENAGA KERJA LANGSUNG (GAJI & LEMBUR KARYAWAN)</th>
	<th></th>
	<th style='text-align:right;'>$biaya_tenaga_kerja</th>
</tr>";
//END BIAYA TENAGA KERJA LANGSUNG (GAJI & LEMBUR KARYAWAN)

echo "<th style='background-color:#DCDCDC; width:15%; text-align:center;' colspan='2'>BIAYA OVERHEAD PABRIK</th>
  <th></th>
	<th></th>
	<th></th>
	<th></th>
</tr>";

//BIAYA MOLD
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('602') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_mold=rupiah($persediaan_awal_debit);
$biaya_mold1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>602</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA MOLD</th>
	<th style='text-align:right;'>$biaya_mold</th>
	<th></th>
</tr>";
//END BIAYA MOLD

//BIAYA OLI DAN SOLAR
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('802') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_oli_dan_solar=rupiah($persediaan_awal_debit);
$biaya_oli_dan_solar1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>802</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA OLI DAN SOLAR</th>
	<th style='text-align:right;'>$biaya_oli_dan_solar</th>
	<th></th>
</tr>";
//END BIAYA OLI DAN SOLAR

//BIAYA LISTRIK AIR DAN TELEPON
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('467.800','467.500','467.100') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_listrik_air_dan_telepon=rupiah($persediaan_awal_debit);
$biaya_listrik_air_dan_telepon1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>467.800 / 467.500 / 467.100</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA LISTRIK AIR DAN TELEPON</th>
	<th style='text-align:right;'>$biaya_listrik_air_dan_telepon</th>
	<th></th>
</tr>";
//END BIAYA LISTRIK AIR DAN TELEPON

//BIAYA ASURANSI
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('487') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_asuransi=rupiah($persediaan_awal_debit);
$biaya_asuransi1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>487</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA ASURANSI</th>
	<th style='text-align:right;'>$biaya_asuransi</th>
	<th></th>
</tr>";
//END BIAYA ASURANSI

//BIAYA PEMELIHARAAN MESIN
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('485') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_pemeliharaan_mesin=rupiah($persediaan_awal_debit);
$biaya_pemeliharaan_mesin1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>485</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA PEMELIHARAAN MESIN</th>
	<th style='text-align:right;'>$biaya_pemeliharaan_mesin</th>
	<th></th>
</tr>";
//END BIAYA PEMELIHARAAN MESIN

//BIAYA PENYUSUTAN MESIN DAN PERALATAN
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('154') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_penyusutan_mesin_dan_peralatan=rupiah($persediaan_awal_debit);
$biaya_penyusutan_mesin_dan_peralatan1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>154</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA PENYUSUTAN MESIN DAN PERALATAN</th>
	<th style='text-align:right;'>$biaya_penyusutan_mesin_dan_peralatan</th>
	<th></th>
</tr>";
//END BIAYA PENYUSUTAN MESIN DAN PERALATAN

//BIAYA KALIBRASI
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('813') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_kalibrasi=rupiah($persediaan_awal_debit);
$biaya_kalibrasi1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>813</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA KALIBRASI</th>
	<th style='text-align:right;'>$biaya_kalibrasi</th>
	<th></th>
</tr>";
//END BIAYA KALIBRASI

//BIAYA BAHAN PEMBUNGKUS
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('489') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_bahan_pembungkus=rupiah($persediaan_awal_debit);
$biaya_bahan_pembungkus1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>489</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA BAHAN PEMBUNGKUS</th>
	<th style='text-align:right;'>$biaya_bahan_pembungkus</th>
	<th></th>
</tr>";
//END BIAYA BAHAN PEMBUNGKUS

//BIAYA BAHAN PEMBANTU
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('513') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_bahan_pembantu=rupiah($persediaan_awal_debit);
$biaya_bahan_pembantu1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>513</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA BAHAN PEMBANTU</th>
	<th style='text-align:right;'>$biaya_bahan_pembantu</th>
	<th></th>
</tr>";
//END BIAYA BAHAN PEMBANTU

//BIAYA ALAT ALAT LISTRIK DAN MEKANIK
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('581') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_alat_alat_listrik_dan_mekanik=rupiah($persediaan_awal_debit);
$biaya_alat_alat_listrik_dan_mekanik1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>581</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA ALAT ALAT LISTRIK DAN MEKANIK</th>
	<th style='text-align:right;'>$biaya_alat_alat_listrik_dan_mekanik</th>
	<th></th>
</tr>";
//END BIAYA ALAT ALAT LISTRIK DAN MEKANIK

//BIAYA BEA MASUK IMPORT
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('588') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_bea_masuk_import=rupiah($persediaan_awal_debit);
$biaya_bea_masuk_import1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>588</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA BEA MASUK IMPORT</th>
	<th style='text-align:right;'>$biaya_bea_masuk_import</th>
	<th></th>
</tr>";
//END BIAYA BEA MASUK IMPORT

//BIAYA PRINTING
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('511') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_printing=rupiah($persediaan_awal_debit);
$biaya_printing1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>511</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA PRINTING</th>
	<th style='text-align:right;'>$biaya_printing</th>
	<th></th>
</tr>";
//END BIAYA PRINTING

//BIAYA KEPERLUAN PABRIK
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('808') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_keperluan_pabrik=rupiah($persediaan_awal_debit);
$biaya_keperluan_pabrik1=$persediaan_awal_debit;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>808</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA KEPERLUAN PABRIK</th>
	<th style='text-align:right;'>$biaya_keperluan_pabrik</th>
	<th></th>
</tr>";
//END BIAYA KEPERLUAN PABRIK

//BIAYA LABORATORIUM TEST
$cari_data="SELECT SUM(debit),SUM(kredit) FROM akuntansiv3_jurnal WHERE nomor IN ('816') AND tanggal BETWEEN '$mutasi1' AND '$mutasi2'";
$cari_data_result=mysql_query($cari_data);
$cari_data_rows=mysql_fetch_array($cari_data_result);
$persediaan_awal_debit=$cari_data_rows['SUM(debit)'];
$persediaan_awal_kredit=$cari_data_rows['SUM(kredit)'];
$biaya_laboratorium_test=rupiah($persediaan_awal_debit);
$biaya_laboratorium_test1=$persediaan_awal_debit;
echo "
<tr>
<th style='background-color:; text-align:center;' colspan='2'>816</th>
	<th style='background-color:; width:50%; text-align:left;' colspan='2'>BIAYA LABORATORIUM TEST</th>
	<th style='text-align:right;'><u>$biaya_keperluan_pabrik</u></th>
	<th></th>
</tr>";
//END BIAYA LABORATORIUM TEST

//TOTALAN KELIMA
$totalan_kelima=rupiah(
	$biaya_mold1+
	$biaya_oli_dan_solar1+
	$biaya_listrik_air_dan_telepon1+
	$biaya_asuransi1+
	$biaya_pemeliharaan_mesin1+
	$biaya_penyusutan_mesin_dan_peralatan1+
	$biaya_kalibrasi1+
	$biaya_bahan_pembungkus1+
	$biaya_bahan_pembantu1+
	$biaya_alat_alat_listrik_dan_mekanik1+
	$biaya_bea_masuk_import1+
	$biaya_printing1+
	$biaya_keperluan_pabrik1+
	$biaya_laboratorium_test1);

$totalan_kelima1=
	$biaya_mold1+
	$biaya_oli_dan_solar1+
	$biaya_listrik_air_dan_telepon1+
	$biaya_asuransi1+
	$biaya_pemeliharaan_mesin1+
	$biaya_penyusutan_mesin_dan_peralatan1+
	$biaya_kalibrasi1+
	$biaya_bahan_pembungkus1+
	$biaya_bahan_pembantu1+
	$biaya_alat_alat_listrik_dan_mekanik1+
	$biaya_bea_masuk_import1+
	$biaya_printing1+
	$biaya_keperluan_pabrik1+
	$biaya_laboratorium_test1;
echo "
<tr>
<th style='background-color:; width:15%; text-align:LEFT;' colspan='2'>TOTAL BIAYA OVERHEAD PABRIK</th>
  <th style='background-color:; text-align:center;' colspan='2'></th>
	<th></th>
	<th style='text-align:right;'><U>$totalan_kelima</U></th>
</tr>";
//END TOTALAN KEEMPAT

//TOTALAN KEENAM
$totalan_keenam=rupiah($totalan_keempat1+$biaya_tenaga_kerja1+$totalan_kelima1);
$totalan_keenam1=$totalan_keempat1+$biaya_tenaga_kerja1+$totalan_kelima1;
echo "
<tr>
  <th style='background-color:; text-align:center;' colspan='2'>---</th>
	<th style='background-color:; width:50%; text-align:Right;' colspan='2'>HARGA POKOK PENJUALAN</th>
	<th></th>
	<th style='text-align:right;'>$totalan_keenam</th>
</tr>";
//END TOTALAN KEENAM


echo "
</table>
";


}//END PERHITUNGAN POKOK HARGA PENJUALAN


}//Paling Akhir
