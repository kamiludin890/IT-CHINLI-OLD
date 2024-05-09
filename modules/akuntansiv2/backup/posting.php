<?php global  $title, $mod, $tbl, $fld ,$p, $akses;
	$mod='akuntansiv2/posting';
	$tbl='akuntansiv2_posting';
	$fld='id,ref,kode,tanggal,tanggal_input,keterangan,invoice_faktur,jatuh_tempo,persamaan,kode_keterangan_debit,kode_keterangan_kredit,kode_keterangan_kredit_kedua,nominal_debit,nominal_kredit,nominal_kredit_kedua,nilai_ppn,ppn,jumlah_ppn,bayar,sisa,pembuat,status,jenis_kas,nomor_aju' ;

function editmenu(){extract($GLOBALS);
	if ($_POST['mysubmit']=='add'){echo usermenu('');}//insert,close
	elseif($_POST['mysubmit']=='edit'){echo usermenu('');}//save,close
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('add,deleteposting,filter,export');}
	}

function home(){extract($GLOBALS);

$jenis_kas_penentu=$_POST['jenis_kas'];
if ($jenis_kas_penentu=='ALL') {}
elseif($jenis_kas_penentu=='') {
	$username1012=$_SESSION['username'];
	$sql1212="SELECT * FROM master_user WHERE email='$username1012'";
	$result1212=mysql_query($sql1212);
	$rows1212=mysql_fetch_array($result1212);
	if ($rows1212[jenis_kas_posting]=='ALL'){}else{
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansiv2/posting'>
	<input type='hidden' name='list_dokumen' value='tampil'>
	<td><input type='submit' value='Tampilkan List Dokumen'></td>
	</tr>
	</form>
	</br>";}}
else{
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansiv2/posting'>
	<input type='hidden' name='list_dokumen' value='tampil'>
	<td><input type='submit' value='Tampilkan List Dokumen'></td>
	</tr>
	</form>
	</br>";
	}

	$list_dokumen=$_POST['list_dokumen'];


	if ($list_dokumen==tampil){

	//Update Pencarian List dokumen
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	$dokumen = $_POST['dokumen'];
	$kategori_pencarian = $_POST['kategori_pencarian'];
	$kolom_pencarian = $_POST['kolom_pencarian'];

	$username31=$_SESSION['username'];
	if ($bulan>0) {
		$upload="UPDATE master_user SET tanggal_pencarian_list_dokumen_posting='$tahun-$bulan', dokumen_pencarian_list_dokumen_posting='$dokumen' WHERE email='$username31'";
		$hasil = mysql_query($upload);
	}else {
		$id_tanggal_pencarian=date('Y-m');
		$upload="UPDATE master_user SET tanggal_pencarian_list_dokumen_posting='$id_tanggal_pencarian', dokumen_pencarian_list_dokumen_posting='0000' WHERE email='$username31'";
		$hasil = mysql_query($upload);
	}

	$tgl_list_dokumen=tanggal_waktu();
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansiv2/posting'>
	<input type='hidden' name='list_dokumen' value=''>
	<td><input type='submit' value='kembali'></td>
	</tr>
	</form>
	</br>";

	if($kategori_pencarian=='nomor_aju'){$kategori_pencarian2='Nomor Aju';} else {}
	if($kategori_pencarian=='nomorinvoiceacc'){$kategori_pencarian2='Invoice';} else {}
	if($kategori_pencarian=='nomor_doc'){$kategori_pencarian2='Nomor Dokumen';} else {}
	if($kategori_pencarian=='tanggal_doc'){$kategori_pencarian2='Tanggal Dokumen';} else {}
	if($kategori_pencarian=='bukti'){$kategori_pencarian2='Bukti';} else {}
	if($kategori_pencarian=='kontak'){$kategori_pencarian2='Kontak';} else {}

	if($dokumen=='BC '){$dokumen2='ALL';} else {}
	if($dokumen=='2.3 IMPORT'){$dokumen2='BC 23 IMPORT';} else {}
	if($dokumen=='3.0 PEB'){$dokumen2='BC 30 PEB';} else {}
	if($dokumen=='2.7 MASUK'){$dokumen2='BC 27 MASUK';} else {}
	if($dokumen=='2.7 KELUAR'){$dokumen2='BC 27 KELUAR';} else {}
	if($dokumen=='2.6.1 SUBKON'){$dokumen2='BC 261 SUBKON';} else {}
	if($dokumen=='2.6.2 HASIL SUBKON'){$dokumen2='BC 262 HASIL SUBKON';} else {}
	if($dokumen=='4.0 LOKAL'){$dokumen2='BC 40 LOKAL';} else {}
	if($dokumen=='4.1 PENGEMBALIAN'){$dokumen2='BC 41 PENGEMBALIAN';} else {}
	if($dokumen=='4.1 REPARASI'){$dokumen2='BC 41 REPARASI';} else {}
	if($dokumen=='4.0 HASIL REPARASI'){$dokumen2='BC 40 HASIL REPARASI';} else {}
	if($dokumen=='4.1 PENJUALAN'){$dokumen2='BC 41 PENJUALAN';} else {}
	if($dokumen=='2.5 PIB'){$dokumen2='BC 25 PIB';} else {}

		if($bulan=='01'){$bulan2='Januari';} else {}
		if($bulan=='02'){$bulan2='Februari';} else {}
		if($bulan=='03'){$bulan2='Maret';} else {}
		if($bulan=='04'){$bulan2='April';} else {}
		if($bulan=='05'){$bulan2='Mei';} else {}
		if($bulan=='06'){$bulan2='Juni';} else {}
		if($bulan=='07'){$bulan2='Juli';} else {}
		if($bulan=='08'){$bulan2='Agustus';} else {}
		if($bulan=='09'){$bulan2='September';} else {}
		if($bulan=='10'){$bulan2='Oktober';} else {}
		if($bulan=='11'){$bulan2='November';} else {}
		if($bulan=='12'){$bulan2='Desember';} else {}

	echo "
	<form action='?menu=home&mod=akuntansiv2/posting' method='POST'>
	<label>Cari :</label>
	</br>

	<input type='hidden' name='list_dokumen' value='tampil'>

	Jenis Dokumen
	<select name='dokumen'>";

	if ($dokumen=='') {//echo "<option value='BC '>All</option>";
	}else{echo "<option value='$dokumen'>$dokumen2</option>";}

	echo "
	<option value='2.3 IMPORT'>BC 23 IMPORT</option>
	<option value='3.0 PEB'>BC 30 PEB</option>
	<option value='2.7 MASUK'>BC 27 MASUK</option>
	<option value='2.7 KELUAR'>BC 27 KELUAR</option>
	<option value='2.6.1 SUBKON'>BC 261 SUBKON</option>
	<option value='2.6.2 HASIL SUBKON'>BC 262 HASIL SUBKON</option>
	<option value='4.0 LOKAL'>BC 40 LOKAL</option>
	<option value='4.1 PENGEMBALIAN'>BC 41 PENGEMBALIAN</option>
	<option value='4.1 REPARASI'>BC 41 REPARASI</option>
	<option value='4.0 HASIL REPARASI'>BC 40 HASIL REPARASI</option>
	<option value='4.1 PENJUALAN'>BC 41 PENJUALAN</option>
	<option value='2.5 PIB'>BC 25 PIB</option>
	</select>
	</br>
	</br>
	Kategori
	<select name='kategori_pencarian'>
	<option value='$kategori_pencarian'>$kategori_pencarian2</option>
	<option value='nomor_aju'>Nomor Aju</option>
	<option value='nomorinvoiceacc'>Invoice</option>
	<option value='nomor_doc'>Nomor Pendaftaran</option>
	<option value='tanggal_doc'>Tanggal Daftar</option>
	<option value='bukti'>Surat Jalan</option>
	<option value='kontak'>Kontak</option>
	</select>
	Cari
	<input type='text' name='kolom_pencarian' value='$kolom_pencarian'>
	Bulan
	<select name='bulan'>
		<option value='$bulan'>$bulan2</option>
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

<?php
	echo "
		<table width='100%' padding='100' border='1' cellspacing='1' cellpadding='0' border-color='black'>
				<td>
						<table align='center' width='100%' border='2' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC'>
							<tr>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='30px' bgcolor='#FFFFFF'><strong>Nomor Aju</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Nomor Invoice</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Jenis Dokumen</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Nomor Pendaftaran</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='60px' bgcolor='#FFFFFF'><strong>Tanggal Daftar</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Surat Jalan</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong>Kontak</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong>Nilai Transaksi</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong>Bayar/Dibayarkan</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong>Sisa</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong>------</strong></td>
								<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong>Catatan</strong></td>
						</tr>";

						$sql22="SELECT * FROM master_user WHERE email='$username31'";
						$result22= mysql_query($sql22);
						$rows22=mysql_fetch_array($result22);

									if ($kategori_pencarian=='') {} else {
										$pencarian_data="$kategori_pencarian LIKE '%$kolom_pencarian%' AND";
									}

									$sql1="SELECT * FROM inventory_distribusi WHERE $pencarian_data tanggal_doc LIKE '%$rows22[tanggal_pencarian_list_dokumen_posting]%' AND jenis_doc LIKE '%$rows22[dokumen_pencarian_list_dokumen_posting]%'";
								  $result1= mysql_query($sql1);
									while ($rows1=mysql_fetch_array($result1)){

										$sql21="SELECT * FROM akuntansiv2_posting WHERE nomor_aju='$rows1[nomor_aju]'";
										$result21= mysql_query($sql21);
										$rows21=mysql_fetch_array($result21);

										$query25="SELECT SUM(bayar) FROM akuntansiv2_posting WHERE nomor_aju='$rows1[nomor_aju]'";
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

										$sisa=$nilai_transaksi-$totalbayar;
										$sisa1=number_format($sisa, 0, ".", ".");
										$decimal_sisa=explode(".",$sisa);
										$decimal_sisa1=$decimal_sisa[1];

										if ($rows1[jenis_doc]=='BC 2.7 MASUK') {
											$query205="SELECT * FROM exim_bc27m WHERE f8='$rows1[nomor_doc]' AND f9='$rows1[tanggal_doc]'";
											$result205=mysql_query($query205);
											$row205=mysql_fetch_array($result205);
											$surat_jalan=$row205['f21'];
										}else {$surat_jalan='';}

										if ($rows1[jenis_doc]=='BC 2.7 KELUAR') {
											$query205="SELECT * FROM exim_bc27k WHERE f8='$rows1[nomor_doc]' AND f9='$rows1[tanggal_doc]'";
											$result205=mysql_query($query205);
											$row205=mysql_fetch_array($result205);
											$surat_jalan=$row205['f21'];
										}else {$surat_jalan='';}

										if ($rows1[jenis_doc]=='BC 2.6.2 HASIL SUBKON') {
											$query205="SELECT * FROM exim_bc262 WHERE bc262f6='$rows1[nomor_doc]' AND	bc262f7='$rows1[tanggal_doc]'";
											$result205=mysql_query($query205);
											$row205=mysql_fetch_array($result205);
											$surat_jalan=$row205['bc262f16'];
										}else {$surat_jalan='';}

										if ($rows1[jenis_doc]=='BC 2.6.1 SUBKON') {
											$query205="SELECT * FROM exim_bc261 WHERE bc261f45='$rows1[nomor_doc]' AND	bc261f46='$rows1[tanggal_doc]'";
											$result205=mysql_query($query205);
											$row205=mysql_fetch_array($result205);
											$surat_jalan=$row205['bc261f15'];
										}else {$surat_jalan='';}

																		echo "<tr>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nomor_aju]</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nomorinvoiceacc]</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[jenis_doc]</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nomor_doc]</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[tanggal_doc]</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[bukti]</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[kontak]</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:10px; text-align:right;'>Rp. $nilai_transaksi1,$decimal_nilai_transaksi1</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:right;'>Rp. $totalbayar1,$decimal_total_bayar1</td>
																						<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:right;'>Rp. $sisa1,$decimal_sisa1</td>";

																						$sql223="SELECT status,catatan FROM akuntansiv2_posting WHERE nomor_aju='$rows1[nomor_aju]' AND status='Selesai'";
																						$result223= mysql_query($sql223);
																						$rows223=mysql_fetch_array($result223);
																						$catatan_selesai=$rows223['catatan'];
																					if($rows223['status']=='Selesai'){
																						echo "<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>Selesai</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$catatan_selesai</td>
																					  </tr>";
																					}else{
																							$jenis_kas_bc=$rows22['jenis_kas'];
																							$tgl12=tanggal_waktu();

																							echo "
																							<form action='?menu=home&mod=akuntansiv2/posting' method='POST'>
																							<input type='hidden' name='jenis_kas' value='$jenis_kas_bc'/>
																							<input type='hidden' name='nomor_aju' value='$rows1[nomor_aju]'/>

																							<input type='hidden' name='nomor_doc' value='$rows1[nomor_doc]'/>
																							<input type='hidden' name='kontak' value='$rows1[kontak]'/>
																							<input type='hidden' name='tanggal_doc' value='$rows1[tanggal_doc]'/>

																							<input type='hidden' name='persamaan' value='728'/>

																							<input type='hidden' name='nominal_debit' value='$sisa'/>
																							<input type='hidden' name='nominal_kredit' value='$sisa'/>
																							<input type='hidden' name='tanggal' value='$tgl12'/>
																							<input type='hidden' name='edit_or_tambah' value='tambah'/>
																							<td style='font-weight:bold; text-align:center; '><input type='submit' name='submit1' value='Masuk Posting'></td>
																							</form>
																							<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'></td>
																					  </tr>";}
																				}
  }else{

	$jenis_kas=$_POST['jenis_kas'];
	$username10=$_SESSION['username'];
	$limit = 50;

	if ($jenis_kas=='') {
	}else {
		$update_jenis_kas="UPDATE master_user SET jenis_kas_posting='$jenis_kas' WHERE email='$username10'";
		$eksekusi_update_jenis_kas=mysql_query($update_jenis_kas);
	}

	$sql12="SELECT * FROM master_user WHERE email='$username10'";
	$result12=mysql_query($sql12);
	$rows12=mysql_fetch_array($result12);

	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansiv2/posting'>
	<tr>
	 <td>Jenis Kas</td>
	 <td>:</td>
	 <td><select name='jenis_kas'>
	<option value='$rows12[jenis_kas_posting]'>".$rows12[jenis_kas_posting]."</option>
	 <option value='ALL'>ALL (Khusus Pencarian)</option>
	 <option value='Pembelian'>Pembelian</option>
	 <option value='Penjualan'>Penjualan</option>
	 <option value='KAS CL TECHNO DOLLAR'>KAS CL TECHNO DOLLAR</option>
	 <option value='KAS CL TECHNO'>KAS CL TECHNO</option>
	 <option value='KAS SL TECHNO'>KAS SL TECHNO</option>
	 <option value='KAS CL INDUSTRI'>KAS CL INDUSTRI</option>
	 <option value='KAS SL INDUSTRI'>KAS SL INDUSTRI</option>
	 <option value='PPN MASUKAN'>PPN MASUKAN</option>
	 <option value='PPN KELUARAN'>PPN KELUARAN</option>
	 <option value='PPH'>PPH</option>
	 <option value='Kas MESH'>Kas MESH</option>
	 <option value='KAS BESAR CL BANK CT USD - 102028100272002'>KAS BESAR CL BANK CT USD - 102028100272002</option>
	 <option value='KAS BESAR CL BANK CT IDR - 102018100272001'>KAS BESAR CL BANK CT IDR - 102018100272001</option>
	 <option value='KAS BESAR SL BANK CT USD - 102018100272004'>KAS BESAR SL BANK CT USD - 102018100272004</option>
	 <option value='KAS BESAR SL BANK CT IDR - 102018100272003'>KAS BESAR SL BANK CT IDR - 102018100272003</option>
	 <option value='KAS BESAR BCA - 764051996'>KAS BESAR BCA - 764051996</option>
	 <option value='KAS BESAR BANK BCA IDR - 7641569996'>KAS BESAR BANK BCA IDR - 7641569996</option>
	 <option value='KAS BESAR BANK BNI - 2014012916'>KAS BESAR BANK BNI - 2014012916</option>
	 <option value='KAS BESAR CL BANK CT USD - 2020837701'>KAS BESAR CL BANK CT USD - 2020837701</option>
	 <option value='KAS BESAR SL BANK CT USD - 2010837705'>KAS BESAR SL BANK CT USD - 2010837705</option>
	 <option value='KAS BESAR CL BANK CT IDR - 1020837701'>KAS BESAR CL BANK CT IDR - 1020837701</option>
	 <option value='KAS BESAR SL BANK CT IDR - 1010837705'>KAS BESAR SL BANK CT IDR - 1010837705</option>
	 <option value='BAHAN BAKU GUDANG'>BAHAN BAKU GUDANG</option>
	 <option value='BAHAN BAKU GUDANG CAMPURAN'>BAHAN BAKU GUDANG CAMPURAN</option>
	 <option value='BARANG JADI'>BARANG JADI</option>
	 <option value='BARANG SETENGAH JADI'>BARANG SETENGAH JADI</option>
	 <option value='PENGECEKAN (BC 27 MASUK)'>PENGECEKAN (BC 27 MASUK)</option>
	</tr>

	<tr>
	 <td></td>
	 <td></td>
	 <td><input type='submit' value='Tampilkan'></td>
	</tr>
	</form>
	</br>";

	if ($rows12[jenis_kas_posting]==$rows12[jenis_kas_posting]) {

		if ($rest=='') {
		}else {
			$ambil_karakter_pencarian = substr($rest,6);
			$ambil_karakter_pencarian1 = "AND $ambil_karakter_pencarian";
		}

		if ($rows12[jenis_kas_posting]=='ALL') {
			$rest1="WHERE jenis_kas	IN ('Pembelian','Penjualan','KAS CL TECHNO DOLLAR','KAS CL TECHNO','KAS SL TECHNO','KAS CL INDUSTRI','KAS SL INDUSTRI','PPN MASUKAN','PPN KELUARAN','PPH','Kas MESH','KAS BESAR CL BANK CT USD - 102028100272002','KAS BESAR CL BANK CT IDR - 102018100272001','KAS BESAR SL BANK CT USD - 102018100272004','KAS BESAR SL BANK CT IDR - 102018100272003','KAS BESAR BCA - 764051996','KAS BESAR BANK BCA IDR - 7641569996','KAS BESAR BANK BNI - 2014012916','KAS BESAR CL BANK CT USD - 2020837701','KAS BESAR SL BANK CT USD - 2010837705','KAS BESAR CL BANK CT IDR - 1020837701','KAS BESAR SL BANK CT IDR - 1010837705','BAHAN BAKU GUDANG','BAHAN BAKU GUDANG CAMPURAN','BARANG JADI','BARANG SETENGAH JADI') $ambil_karakter_pencarian1 ORDER BY id DESC";
			echo "<h2>Posting $rows12[jenis_kas_posting] </h2>";
		}else {
			$rest1="WHERE jenis_kas='$rows12[jenis_kas_posting]' $ambil_karakter_pencarian1 ORDER BY id DESC";
			echo "<h2>Posting $rows12[jenis_kas_posting] </h2>";
		}

		table($tbl,$fld,$limit,$rest1,$mod);
	}

	$_SESSION['myquery']="SELECT $fld from $tbl $rest1 ";
	}
	}

	$username10=$_SESSION['username'];
	$sql12="SELECT * FROM master_user WHERE email='$username10'";
	$result12=mysql_query($sql12);
	$rows12=mysql_fetch_array($result12);

	$kode=$_POST['kode'];
	$tanggal=$_POST['tanggal'];
	$tanggal_update=tanggal_waktu();
	$keterangan=$_POST['keterangan'];
	$id_persamaan=$_POST['persamaan'];
	$pembuat=$_POST['pembuat'];
	$status=$_POST['status'];
	$nomor_aju=$_POST['nomor_aju'];
	$invoice_faktur=$_POST['invoice_faktur'];
	$jatuh_tempo=$_POST['jatuh_tempo'];
	$bayar=$_POST['bayar'];
	$catatan=$_POST['catatan'];
	$tanggal_doc=$_POST['tanggal_doc'];

	$kontak=$_POST['kontak'];
	$nomor_doc=$_POST['nomor_doc'];

	$kurs1=$_POST['kurs'];
	$nilai_ppn1=$_POST['nilai_ppn'];
	$nominal_debit1=$_POST['nominal_debit'];
  $nominal_kredit1=$_POST['nominal_kredit'];

	$id_posting=$_POST['id_posting'];

	$sql18="SELECT * FROM akuntansiv2_posting WHERE id='$id_posting'";
	$result18=mysql_query($sql18);
	$rows18=mysql_fetch_array($result18);
	if ($rows18['nilai_ppn']==$nilai_ppn1) {$kurs2='1';$nilai_ppn2='1';$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;} else {$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;$kurs2=$kurs1;$nilai_ppn2=$nilai_ppn1;}
	if ($rows18['kurs']==$kurs1) {$kurs2='1';$nilai_ppn2='1';$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;} else {$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;$kurs2=$kurs1;$nilai_ppn2=$nilai_ppn1;}
	if ($rows18['nominal_debit']==$nominal_debit1) {$kurs2='1';$nilai_ppn2='1';$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;} else {$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;$kurs2=$kurs1;$nilai_ppn2=$nilai_ppn1;}
	if ($rows18['nominal_kredit']==$nominal_kredit1) {$kurs2='1';$nilai_ppn2='1';$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;} else {$kurs=$kurs1;$nilai_ppn=$nilai_ppn1;$kurs2=$kurs1;$nilai_ppn2=$nilai_ppn1;}

	if ($kurs>0) {
		$nominal_kredit=$nominal_kredit1*$kurs2;

		$nominal_kredit_kedua1=$nominal_kredit*$nilai_ppn1;
		$nominal_kredit_kedua=$nominal_kredit_kedua1/100;

		$nominal_debit2=$nominal_debit1*$kurs2;

		//if ($kurs2==1) {
		//	$nominal_debit=$nominal_debit2;
		//}else{
		//	$nominal_debit=$nominal_debit2+$nominal_kredit_kedua;
		//}

		$ppn=$nominal_kredit_kedua;
		$jumlah_ppn=$ppn+$nominal_kredit;
		$nominal_debit=$jumlah_ppn;
	}else {

		$nominal_kredit=$nominal_kredit1;

		$nominal_kredit_kedua1=$nominal_kredit*$nilai_ppn1;
		$nominal_kredit_kedua=$nominal_kredit_kedua1/100;

		$nominal_debit2=$nominal_debit1;

	//	if ($nilai_ppn2==1) {echo "$nilai_ppn2";
	//		$nominal_debit=$nominal_debit2;
	//	}else{
	//		$nominal_debit=$nominal_debit2+$nominal_kredit_kedua;
	//	}

		$ppn=$nominal_kredit_kedua;
		$jumlah_ppn=$ppn+$nominal_kredit;
		$nominal_debit=$jumlah_ppn;
	}
	$sisa=$bayar-$jumlah_ppn;

	$jenis_kas=$rows12['jenis_kas_posting'];
	//$debit=$_POST['debit'];
	//$kredit=$_POST['kredit'];
	//$keterangan_debit=$_POST['keterangan_debit'];
	//$keterangan_kredit=$_POST['keterangan_kredit'];

	$edit_or_tambah=$_POST['edit_or_tambah'];
	$id_ke_jurnal_update=$_POST['id_ke_jurnal'];
	$id_ke_jurnal_kredit_kedua=$_POST['id_ke_jurnal_kredit_kedua'];
	$id_ke_jurnal_kredit=$_POST['id_ke_jurnal_kredit'];
	$id_ke_jurnal_debit=$_POST['id_ke_jurnal_debit'];

	$sql6="SELECT * FROM akuntansiv2_persamaan WHERE id='$id_persamaan'";
	$result6=mysql_query($sql6);
	$rows6=mysql_fetch_array($result6);
	$debit=$rows6['debit'];
	$kredit=$rows6['kredit'];
	$kredit_kedua=$rows6['kredit_kedua'];
	$persamaan=$rows6['keterangan'];
	$keterangan_persamaan=$rows6['keterangan'];

	$sql9="SELECT * FROM akuntansiv2_akun WHERE nomor='$debit'";
	$result9=mysql_query($sql9);
	$rows9=mysql_fetch_array($result9);
	$keterangan_debit=$rows9['nama'];
	$neraca_saldo_awal_debit=$rows9['kolom'];
	$pembeda_laba_rugi_debit=$rows9['pembeda_laba_rugi'];

	$sql10="SELECT * FROM akuntansiv2_akun WHERE nomor='$kredit'";
	$result10=mysql_query($sql10);
	$rows10=mysql_fetch_array($result10);
	$keterangan_kredit=$rows10['nama'];
	$neraca_saldo_awal_kredit=$rows10['kolom'];
	$pembeda_laba_rugi_kredit=$rows10['pembeda_laba_rugi'];

	$sql15="SELECT * FROM akuntansiv2_akun WHERE nomor='$kredit_kedua'";
	$result15=mysql_query($sql15);
	$rows15=mysql_fetch_array($result15);
	$keterangan_kredit_kedua=$rows15['nama'];
	$neraca_saldo_awal_kredit_kedua=$rows15['kolom'];
	$pembeda_laba_rugi_kredit_kedua=$rows15['pembeda_laba_rugi'];

				if ($edit_or_tambah==edit){

					//$sql14="SELECT * FROM akuntansiv2_posting WHERE id='$id_posting'";
					//$result14= mysql_query($sql14);
					//$rows14=mysql_fetch_array($result14);
					//$jenis_doc=$rows14['jenis_doc'];

		$update_posting="UPDATE akuntansiv2_posting SET tanggal_input='$tanggal_update',tanggal_doc='$tanggal_doc',catatan='$catatan',kode_keterangan_kredit_kedua='$kredit_kedua - $keterangan_kredit_kedua',kredit_kedua='$kredit_kedua',nominal_kredit_kedua='$nominal_kredit_kedua',keterangan_kredit_kedua='$keterangan_kredit_kedua',nilai_ppn='$nilai_ppn',sisa='$sisa',jumlah_ppn='$jumlah_ppn',ppn='$ppn',kode_keterangan_debit='$debit - $keterangan_debit',kode_keterangan_kredit='$kredit - $keterangan_kredit',invoice_faktur='$invoice_faktur',jatuh_tempo='$jatuh_tempo',kurs='$kurs',bayar='$bayar',nomor_aju='$nomor_aju',id_persamaan='$id_persamaan',kode='$kode',tanggal='$tanggal',keterangan='$keterangan',persamaan='$persamaan',debit='$debit',kredit='$kredit',pembuat='$pembuat',status='$status',keterangan_debit='$keterangan_debit',keterangan_kredit='$keterangan_kredit',nominal_debit='$nominal_debit',nominal_kredit='$nominal_kredit' WHERE id='$id_posting'";
		$eksekusi_update=mysql_query($update_posting);//,jenis_kas='$jenis_kas'

		$update_jurnal_debit="UPDATE akuntansiv2_jurnal SET tanggal_input='$tanggal_update',kode_posting='$kode',pembeda_laba_rugi='$pembeda_laba_rugi_debit',pembeda_saldo_awal='$neraca_saldo_awal_debit',tanggal='$tanggal',nomor='$debit',nama='$keterangan_persamaan',keterangan='$keterangan_debit',debit='$nominal_debit' WHERE nomor='$id_ke_jurnal_debit' AND ref='$id_ke_jurnal_update'";
		$eksekusi_update_jurnal_debit=mysql_query($update_jurnal_debit);

		$update_jurnal_kredit="UPDATE akuntansiv2_jurnal SET tanggal_input='$tanggal_update',kode_posting='$kode',pembeda_laba_rugi='$pembeda_laba_rugi_kredit',pembeda_saldo_awal='$neraca_saldo_awal_kredit',tanggal='$tanggal',nomor='$kredit',nama='$keterangan_persamaan',keterangan='$keterangan_kredit',kredit='$nominal_kredit' WHERE nomor='$id_ke_jurnal_kredit' AND ref='$id_ke_jurnal_update'";
		$eksekusi_update_jurnal_kredit=mysql_query($update_jurnal_kredit);

		$update_jurnal_kredit_kedua="UPDATE akuntansiv2_jurnal SET tanggal_input='$tanggal_update',kode_posting='$kode',pembeda_laba_rugi='$pembeda_laba_rugi_kredit_kedua',pembeda_saldo_awal='$neraca_saldo_awal_kredit_kedua',tanggal='$tanggal',nomor='$kredit_kedua',nama='$keterangan_persamaan',keterangan='$keterangan_kredit_kedua',kredit='$nominal_kredit_kedua' WHERE nomor='$id_ke_jurnal_kredit_kedua' AND ref='$id_ke_jurnal_update'";
		$eksekusi_update_jurnal_kredit_kedua=mysql_query($update_jurnal_kredit_kedua);

	}
	if ($edit_or_tambah==tambah){
		$tgl_id=date("Y-m-d h:i:sa");
    $id_ke_jurnal = preg_replace('/\D/', '', $tgl_id);

		$sql14="SELECT * FROM inventory_distribusi WHERE nomor_aju='$nomor_aju'";
		$result14= mysql_query($sql14);
		$rows14=mysql_fetch_array($result14);
		$jenis_doc=$rows14['jenis_doc'];

		$tambah_posting="INSERT INTO akuntansiv2_posting (tanggal_input,tanggal_doc,kontak,catatan,ref,kode_keterangan_kredit_kedua,kredit_kedua,nominal_kredit_kedua,keterangan_kredit_kedua,nilai_ppn,sisa,jumlah_ppn,ppn,kode_keterangan_debit,kode_keterangan_kredit,invoice_faktur,jatuh_tempo,kurs,bayar,jenis_doc,nomor_aju,id_jurnal,jenis_kas,id_persamaan,kode,tanggal,keterangan,persamaan,debit,kredit,pembuat,status,keterangan_debit,keterangan_kredit,nominal_debit,nominal_kredit) VALUES ('$tanggal_update','$tanggal_doc','$kontak','$catatan','$id_ke_jurnal','$kredit_kedua - $keterangan_kredit_kedua','$kredit_kedua','$nominal_kredit_kedua','$keterangan_kredit_kedua','$nilai_ppn','$sisa','$jumlah_ppn','$ppn','$debit - $keterangan_debit','$kredit - $keterangan_kredit','$invoice_faktur','$jatuh_tempo','$kurs','$bayar','$jenis_doc','$nomor_aju','$id_ke_jurnal','$jenis_kas','$id_persamaan','$kode','$tanggal','$keterangan','$persamaan','$debit','$kredit','$pembuat','$status','$keterangan_debit','$keterangan_kredit','$nominal_debit','$nominal_kredit')";
		$eksekusi_tambah=mysql_query($tambah_posting);

		$tambah_jurnal_debit="INSERT INTO akuntansiv2_jurnal (tanggal_input,kode_posting,pembeda_laba_rugi,pembeda_saldo_awal,ref,tanggal,nomor,nama,keterangan,debit) VALUES ('$tanggal_update','$kode','$pembeda_laba_rugi_debit','$neraca_saldo_awal_debit','$id_ke_jurnal','$tanggal','$debit','$keterangan_persamaan','$keterangan_debit','$nominal_debit')";
		$eksekusi_tambah_jurnal_debit=mysql_query($tambah_jurnal_debit);

		$tambah_jurnal_kredit="INSERT INTO akuntansiv2_jurnal (tanggal_input,kode_posting,pembeda_laba_rugi,pembeda_saldo_awal,ref,tanggal,nomor,nama,keterangan,kredit) VALUES ('$tanggal_update','$kode','$pembeda_laba_rugi_kredit','$neraca_saldo_awal_kredit','$id_ke_jurnal','$tanggal','$kredit','$keterangan_persamaan','$keterangan_kredit','$nominal_kredit')";
		$eksekusi_tambah_jurnal_kredit=mysql_query($tambah_jurnal_kredit);

		$tambah_jurnal_kredit_kedua="INSERT INTO akuntansiv2_jurnal (tanggal_input,kode_posting,pembeda_laba_rugi,pembeda_saldo_awal,ref,tanggal,nomor,nama,keterangan,kredit) VALUES ('$tanggal_update','$kode','$pembeda_laba_rugi_kredit_kedua','$neraca_saldo_awal_kredit_kedua','$id_ke_jurnal','$tanggal','$kredit_kedua','$keterangan_persamaan','$keterangan_kredit_kedua','$nominal_kredit_kedua')";
		$eksekusi_tambah_jurnal_kredit_kedua=mysql_query($tambah_jurnal_kredit_kedua);
	}


	function editform($id,$btn){ extract($GLOBALS);
		$induk=$id; // ID jika untuk Edit
		$username10=$_SESSION['username'];

		$sql5="SELECT * FROM akuntansiv2_posting WHERE id='$induk'";
		$result5=mysql_query($sql5);
		$rows5=mysql_fetch_array($result5);

		if ($induk>0) {
			$tgl="$rows5[tanggal_input]";
			$tgl201="$rows5[tanggal]";

			$pembuat="$rows5[pembuat]";
			$penentu='edit';
		} else {
			$tgl=tanggal_waktu();
			$tgl201=date('Y-m-d');

			$pembuat="$username10";
			$penentu='tambah';
		}



		echo "</br>
					<form action='?menu=home&mod=akuntansiv2/posting' method='POST'>
					<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
					</form>
					</br>";

					$sql1="SELECT * FROM akuntansiv2_persamaan ORDER BY id";
					$result1= mysql_query($sql1);

		echo "
		<link rel='stylesheet' href='select_picker/css/style3.css' type='text/css'>
		<link rel='stylesheet' href='select_picker/css/bootstrap-select.min.css' type='text/css'>
			<form method ='post' action='?menu=home&mod=akuntansiv2/posting'>
			<table>
			 <tr>
				<td>Kode</td>
				<td>:</td>
				<td><input type='text' name='kode' value='$rows5[kode]'></td>

				<td>No Invoice/Faktur</td>
				<td>:</td>
				<td><input type='text' name='invoice_faktur' value='$rows5[invoice_faktur]'></td>";

				$tgl1=tanggal_waktu();
				$tgl2=$rows5[jatuh_tempo];
				// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
				// dari tanggal pertama
				$pecah1 = explode("-", $tgl1);
				$date1 = $pecah1[2];
				$month1 = $pecah1[1];
				$year1 = $pecah1[0];
				// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
				// dari tanggal kedua
				$pecah2 = explode("-", $tgl2);
				$date2 = $pecah2[2];
				$month2 = $pecah2[1];
				$year2 =  $pecah2[0];
				// menghitung JDN dari masing-masing tanggal
				$jd1 = GregorianToJD($month1, $date1, $year1);
				$jd2 = GregorianToJD($month2, $date2, $year2);
				// hitung selisih hari kedua tanggal
				$terlambat = $jd2 - $jd1;

				echo "
				<td>Jatuh Tempo</td>
				<td>:</td>
				<td><input type='text' name='jatuh_tempo' value='$rows5[jatuh_tempo]'></td>

				<td>kurs</td>
				<td>:</td>
				<td><input type='text' name='kurs' value='$rows5[kurs]'></td>
			 </tr>

			 <tr>
				<td>Tanggal Transaksi</td>
				<td>:</td>
				<td><input type='text' name='tanggal' value='$tgl201'></td>
				<td>Tanggal Input</td>
				<td>:</td>
				<td><input type='text' name='tanggal_input' value='$tgl'></td>
				<td></td>
				<td></td>
				<td><input type='text' value='$terlambat Hari' disabled></td>
			 </tr>

			 <tr>
				<td>keterangan</td>
				<td>:</td>
				<td><input type='text' name='keterangan' value='$rows5[keterangan]'></td>

				<td>PPN</td>
				<td>:</td>
				<td><input type='text' name='nilai_ppn' value='$rows5[nilai_ppn]'></td>
			 </tr>

			 <tr>
			 <div class='col-xs-12'>
			 <div class='row'>
			 <div class='col-sm-4'>
			 <div class='form-group'>
			 <td>Persamaan</td>
			 <td>:</td>
			 <td><select name='persamaan' class='form-control selectpicker show-tick' data-live-search='true'>";

			 $sql11="SELECT * FROM akuntansiv2_persamaan WHERE id='$rows5[id_persamaan]'";
			 $result11= mysql_query($sql11);
			 $rows11=mysql_fetch_array($result11);

			 echo "
			 <option value='$rows5[id_persamaan]'>".$rows11[keterangan]."</option>";
			 while ($rows1=mysql_fetch_array($result1)){
			 echo "
			 <option value='$rows1[id]'>".$rows1['keterangan']."</option>
			 ";}
			 echo "
			 </select></td>
			 </tr>";


			 echo "

			 <tr></tr><tr>
			 </tr><tr></tr>

			 <tr>
				<td>Debit</td>
				<td>:</td>
				<td><input type='text' name='debit' value='$rows5[debit]' disabled></td>

				<td>Ket.Debit</td>
				<td>:</td>
				<td><input type='text' name='keterangan_debit' value='$rows5[keterangan_debit]' disabled></td>

				<td>Nominal Debit</td>
				<td>:</td>
				<td><input type='text' name='nominal_debit' value='$rows5[nominal_debit]'></td>
			 </tr>";

			 echo "<tr>
				<td>Kredit</td>
				<td>:</td>
				<td><input type='text' name='kredit' value='$rows5[kredit]' disabled></td>

				<td>Ket.Kredit</td>
				<td>:</td>
				<td><input type='text' name='keterangan_kredit' value='$rows5[keterangan_kredit]' disabled></td>

				<td>Nominal Kredit</td>
				<td>:</td>
				<td><input type='text' name='nominal_kredit' value='$rows5[nominal_kredit]'></td>
			 </tr>";

			 echo "<tr>
				<td>Kredit Kedua</td>
				<td>:</td>
				<td><input type='text' name='kredit_kedua' value='$rows5[kredit_kedua]' disabled></td>

				<td>Ket.Kredit Kedua</td>
				<td>:</td>
				<td><input type='text' name='keterangan_kredit_kedua' value='$rows5[keterangan_kredit_kedua]' disabled></td>

				<td>Nominal Kredit Kedua</td>
				<td>:</td>
				<td><input type='text' name='nominal_kredit_kedua' value='$rows5[nominal_kredit_kedua]'></td>
			 </tr>";

			 echo "</div>
			 </div>
			 </div>
			 </div>
			 </tr>

			 <tr>
		 	 <td>Sisa</td>
		 	 <td>:</td>
		 	 <td><input type='text' name='sisa' value='$rows5[sisa]' disabled	></td>
		 	 </tr>

			 <tr>
			 	<td>Pembuat</td>
			 	<td>:</td>
			 	<td><input type='text' name='pembuat' value='$pembuat' disabled></td>

				<td>Bayar</td>
				<td>:</td>
				<td><input type='text' name='bayar' value='$rows5[bayar]'></td>
			 </tr>

			 <tr>
				<td>Nomor Aju</td>
				<td>:</td>
				<td><input type='text' name='nomor_aju' value='$rows5[nomor_aju]'></td>
			 </tr>

			 <tr>
			 	<td>Status</td>
			 	<td>:</td>
				<td><select name='status'>
 			 <option value='$rows5[status]'>".$rows5['status']."</option>
	  		<option value='Proses'>Proses</option>
  			<option value='Selesai'>Selesai</option>

				<td>Catatan</td>
				<td>:</td>
				<td><input type='text' name='catatan' value='$rows5[catatan]'></td>
			 </tr>

			 <input type='hidden' name='edit_or_tambah' value='$penentu'/></td>
			 <input type='hidden' name='id_posting' value='$induk'/></td>
			 <input type='hidden' name='id_ke_jurnal' value='$rows5[id_jurnal]'/></td>
			 <input type='hidden' name='id_ke_jurnal_kredit_kedua' value='$rows5[kredit_kedua]'/></td>
			 <input type='hidden' name='id_ke_jurnal_kredit' value='$rows5[kredit]'/></td>
			 <input type='hidden' name='id_ke_jurnal_debit' value='$rows5[debit]'/></td>

			 <tr>
				<td></td>
				<td></td>
				<td><input type='submit' value='Simpan'></td>
			 </tr>

			 <script src='select_picker/js/jquery-1.11.2.min.js'></script>
			 <script src='select_picker/js/bootstrap.js'></script>
			 <script src='select_picker/js/bootstrap-select.min.js'></script>
			 <script type='text/javascript'>
			 $(document).ready(function(){
			 });
			 </script>

			</table>
		 </form>";

		}

function persamaan(){extract($GLOBALS);
	editform($induk,'save');
}

function selesai(){extract($GLOBALS);
	$nofak=getfaktur("posting","-KEU");
	$r=getrow("posting","master_setting","");
	$no= $r['posting']+1;
	$query ="UPDATE master_setting SET posting='$no' ";
	$result=mysql_query($query)or die('Error Upate, '.$query);

	$query="INSERT INTO akuntansiv2_posting SET
	kode= '$nofak'
	,tanggal='$_POST[2]'
	,keterangan='$_POST[3]'
	,persamaan='$_POST[4]'
	,debit='$_POST[5]'
	,kredit='$_POST[6]'
	,jumlah='$_POST[7]'
	,pembuat='$_POST[8]'

	,keterangan_debit='$_POST[10]'
	,keterangan_kredit='$_POST[11]'
	,nominal_debit='$_POST[12]'
	,nominal_kredit='$_POST[13]'

	,status='Selesai'
	";
	mysql_query($query)or die('Error 1'.$query);

	$akun=getrow("nomor, nama","akuntansiv2_akun"," where nomor='$_POST[5]'");
	$query="INSERT INTO akuntansiv2_jurnal SET
		ref='$_POST[1]'
		,tanggal='$_POST[2]'
		,nomor='$_POST[5]'
		,nama='$akun[nama]'
		,keterangan='$_POST[3]'
		,debit='$_POST[7]'";
	mysql_query($query)or die('Error 2'.$query);

	$akun=getrow("nomor, nama","akuntansiv2_akun"," where nomor='$_POST[6]'");
	$query="INSERT INTO akuntansiv2_jurnal SET
		ref='$_POST[1]'
		,tanggal='$_POST[2]'
		,nomor='$_POST[6]'
		,nama='$akun[nama]'
		,keterangan='$_POST[3]'
		,kredit='$_POST[7]' ";
	mysql_query($query)or die('Error 3'.$query);

	home();
  	}
?>
