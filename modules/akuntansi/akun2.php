<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='akuntansi/akun';
	$tbl='akuntansi_akun';
	$fld='id,kelompok,nomor,nama' ;

	function editmenu(){extract($GLOBALS);
		if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');}
		elseif($_POST['mysubmit']=='edit'){echo usermenu('');}
		elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
		//else{echo usermenu('add,delete,filter,import,export');}
		}

		function home(){extract($GLOBALS);

			//HOME
			$idhal=$_POST['idhal'];

			if ($idhal=='') {

				echo "
				<form action='?menu=home&mod=akuntansi/akun' method='POST'>
				<input type='hidden' name='idhal' value='230'/>

				<td style='font-weight:bold; text-align:center; '><input type='submit' name='submit1' value='Tambah Data'>
				</form>
				</br>
				";

				echo "
					<table width='100%' padding='100' border='1' cellspacing='1' cellpadding='0' border-color='black'>
							<td>
									<table align='center' width='100%' border='2' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC'>
										<tr>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Kelompok</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Nomor</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Nama Terkait</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Pembeda NERACA	</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Pembeda LABA RUGI</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong></strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong></strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong></strong></td>
									</tr>";

												$sql1="SELECT * FROM akuntansi_akun WHERE tampil='' order by nomor";
												$result1= mysql_query($sql1);
												while ($rows1=mysql_fetch_array($result1)){

																					echo "<tr>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[kelompok]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nomor]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nama]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[kolom]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[pembeda_laba_rugi]</td>

																									<form action='?menu=home&mod=akuntansi/akun' method='POST'>
																									<input type='hidden' name='idhal' value='$rows1[id]'/>
																									<td style='font-weight:bold; background-color: white; text-align:center; '><input type='submit' name='submit2' value='list'>
																									</form>

																									<form action='?menu=home&mod=akuntansi/akun' method='POST'>
																									<input type='hidden' name='idhal' value='210'/>
																									<input type='hidden' name='iddeletehome' value	='$rows1[id]'/>
																									<td style='font-weight:bold; background-color: white; text-align:center; '><input type='submit' name='submit3' value='Edit'>
																									</form>

																									<form action='?menu=home&mod=akuntansi/akun' method='POST'>
																									<input type='hidden' name='idhal' value='220'/>
																									<input type='hidden' name='iddeletehome' value='$rows1[id]'/>
																									<td style='font-weight:bold; background-color: white; text-align:center; '><input type='submit' name='submit4' value='Delete'>
																									</form>

																								</tr>";
			}
		  }


			//LIST ITEM
			if ($idhal>0) {

				$sql2="SELECT * FROM akuntansi_akun WHERE id='$idhal' order by nama";
				$result2= mysql_query($sql2);
				$rows2=mysql_fetch_array($result2);

			echo "
			<form action='?menu=home&mod=akuntansi/akun' method='POST'>
			<input type='hidden' name='idhal' value='130'/>
			<input type='hidden' name='idnomor' value='$rows2[nomor]'/>
			<input type='hidden' name='idkelompok' value='$rows2[kelompok]'/>
			<input type='hidden' name='iddaftarproduk' value='$rows2[id]'/>
				<tr><td><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit1' value='Tambah Item $rows2[nama]'></tr>
			</form>
			</br>
			<form action='?menu=home&mod=akuntansi/akun' method='POST'>
			<input type='hidden' name='idhal' value=''/>
			<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
			</form>
			</br>
			";

				echo "
								<table align='center' width='100%' border='2' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC'>
									<tr>
									<td  style='padding: 5px; color:black; background-color:white;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Daftar Item $rows2[nama]</strong></td>
									</tr>";
				echo "
					<table width='100%' padding='100' border='1' cellspacing='1' cellpadding='0' border-color='black'>
							<td>
									<table align='center' width='100%' border='2' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC'>
										<tr>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Kelompok</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='100px' bgcolor='#FFFFFF'><strong>Nomor</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Nama Terkait</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Pembeda NERACA</strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Pembeda LABAR RUGI</strong></td>

											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong></strong></td>
											<td style='padding: 5px; color:black; background-color: #E0FFFF;' align='center' width='40px' bgcolor='#FFFFFF'><strong></strong></td>


									</tr>";
												$sql3="SELECT * FROM akuntansi_akun WHERE tampil='yes' AND nomor LIKE '%$rows2[nomor].%' ORDER BY nomor";
												$result3= mysql_query($sql3);
												while ($rows3=mysql_fetch_array($result3)){

																					echo "<tr>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[kelompok]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[nomor]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[nama]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[kolom]</td>
																									<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[pembeda_laba_rugi]</td>

																									<form action='?menu=home&mod=akuntansi/akun' method='POST'>
																									<input type='hidden' name='idhal' value='110'/>
																									<input type='hidden' name='iddeletedaftar' value='$rows3[id]'/>
																									<input type='hidden' name='iddaftarproduk' value='$idhal'/>
																									<td style='font-weight:bold; background-color: white; text-align:center; '><input type='submit' name='submit3' value='Delete'>
																									</form>

																									<form action='?menu=home&mod=akuntansi/akun' method='POST'>
																									<input type='hidden' name='idhal' value='120'/>
																									<input type='hidden' name='iddaftarproduk' value='$idhal'/>
																									<input type='hidden' name='idupdatedaftar' value='$rows3[id]'/>
																									<td style='font-weight:bold; background-color: white; text-align:center; '><input type='submit' name='submit4' value='Edit'>
																									</form>
																								</tr>";
				}
				}



		//HOME - TAMBAH DATA
		if ($idhal==230) {
			echo "
			<form method ='post' action='?menu=home&mod=akuntansi/akun'>
			  <table>
				<tr>
				<td>Kelompok</td>
				<td>:</td>
				<td><select name='kelompok'>
				<option value='Aktiva'>Aktiva</option>
				<option value='Passiva'>Passiva</option>
				<option value='Ekuitas'>Ekuitas</option>
				<option value='Pendapatan'>Pendapatan</option>
				<option value='Beban'>Beban</option>
				<option value='Aktiva Lancar'>Aktiva Lancar</option>
				<option value='Investasi Jangka Panjang'>Investasi Jangka Panjang</option>
				<option value='Aktiva Tetap'>Aktiva Tetap</option>
				<option value='Aktiva Lain Lain'>Aktiva Lain Lain</option>
				<option value='Kewajiban Lancar'>Kewajiban Lancar</option>
				<option value='Modal'>Modal</option>
				<option value='Laba Ditahan'>Laba Ditahan</option>
				<option value='Penjualan'>Penjualan</option>
				<option value='Pembelian'>Pembelian</option>
				<option value='Biaya Penjualan'>Biaya Penjualan</option>
				<option value='Biaya ADM/UMUM'>Biaya ADM/UMUM</option>
				<option value='Tenaga Kerja Langsung'>Tenaga Kerja Langsung</option>
				<option value='Biaya Pabrikasi'>Biaya Pabrikasi</option>
				<option value='Pendapatan Lain Lain'>Pendapatan Lain Lain</option>
				<option value='Biaya Lain Lain'>Biaya Lain Lain</option>
				<option value='Prive/Dividen'>Prive/Dividen</option>
				</select></td>
				</tr>
			   <tr>
			    <td>Nomor</td>
			    <td>:</td>
			    <td><input type='text' name='nomor'></td>
			   </tr>
			   <tr>
			    <td>Nama</td>
			    <td>:</td>
			    <td><input type='text' name='nama'></td>
			   </tr>
				 <input type='hidden' name='idhal' value='233'/></td>
			   <tr>
				 <tr>
 				<td>Pembeda NERACA</td>
 				<td>:</td>
 				<td><select name='kolom'>
 				<option value='---'>---</option>
 				<option value='DEBIT'>DEBIT</option>
 				<option value='KREDIT'>KREDIT</option>
 				</select></td>
 				</tr>
				<tr>
			 <td>Pembeda LABA RUGI</td>
			 <td>:</td>
			 <td><select name='pembeda_laba_rugi'>
			 <option value=''>---</option>
			 <option value='BIAYA PEMASARAN'>BIAYA PEMASARAN</option>
			 <option value='PAJAK PENGHASILAN'>PAJAK PENGHASILAN</option>
			 <option value='RETUR/PPN PENJUALAN'>RETUR/PPN PENJUALAN</option>
			 <option value='PERSEDIAAN BARANG JADI'>PERSEDIAAN BARANG JADI</option>
			 <option value='PENDAPATAN LAIN LAIN'>PENDAPATAN LAIN LAIN</option>
			 <option value='BIAYA ADMINISTRASI UMUM'>BIAYA ADMINISTRASI UMUM</option>
			 <option value='HARGA POKOK PENJUALAN'>HARGA POKOK PENJUALAN</option>
			 <option value='PENJUALAN'>PENJUALAN</option>
			 </select></td>
			 </tr>
				 <input type='hidden' name='idhal' value='233'/></td>
				 <tr>
			    <td></td>
			    <td></td>
			    <td><input type='submit' value='KIRIM'></td>
			   </tr>
			  </table>
			 </form>";
		} elseif ($idhal==233) {
			$kelompok=$_POST['kelompok'];
			$nomor=$_POST['nomor'];
			$nama=$_POST['nama'];
			$kolom=$_POST['kolom'];
			$pembeda_laba_rugi=$_POST['pembeda_laba_rugi'];
			$upload = "INSERT IGNORE INTO akuntansi_akun (kelompok,nomor,nama,induk,kolom,pembeda_laba_rugi) VALUES('$kelompok','$nomor','$nama','$nomor','$kolom','$pembeda_laba_rugi')";
			$hasil = mysql_query($upload);
			echo "
				<h2>Data Telah Disimpan</h2>
			  <form action='?menu=home&mod=akuntansi/akun' method='POST'>
				<input type='hidden' name='idhal' value=''/>
				<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
				</form>";
		}


		//HOME - DELETE DATA
		if ($idhal==220) {
			$iddeletehome=$_POST['iddeletehome'];
			$upload = "DELETE FROM akuntansi_akun WHERE id='$iddeletehome'";
			$hasil = mysql_query($upload);
			echo "
				<h2>Data Telah Dihapus</h2>
			  <form action='?menu=home&mod=akuntansi/akun' method='POST'>
				<input type='hidden' name='idhal' value=''/>
				<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
				</form>";
		}

		//HOME - UPDATE DATA
		if ($idhal==210) {
			$iddeletehome=$_POST['iddeletehome'];
			$sql4="SELECT * FROM akuntansi_akun WHERE id='$iddeletehome'";
			$result4= mysql_query($sql4);
			$rows4=mysql_fetch_array($result4);
			echo "
			<form method ='post' action='?menu=home&mod=akuntansi/akun'>
				<table>
				<tr>
				<td>Kelompok</td>
				<td>:</td>
				<td><select name='kelompok'>

				<option value='$rows4[kelompok]'>$rows4[kelompok]		</option>

				<option value='Aktiva'>Aktiva</option>
				<option value='Passiva'>Passiva</option>
				<option value='Ekuitas'>Ekuitas</option>
				<option value='Pendapatan'>Pendapatan</option>
				<option value='Beban'>Beban</option>
				<option value='Aktiva Lancar'>Aktiva Lancar</option>
				<option value='Investasi Jangka Panjang'>Investasi Jangka Panjang</option>
				<option value='Aktiva Tetap'>Aktiva Tetap</option>
				<option value='Aktiva Lain Lain'>Aktiva Lain Lain</option>
				<option value='Kewajiban Lancar'>Kewajiban Lancar</option>
				<option value='Modal'>Modal</option>
				<option value='Laba Ditahan'>Laba Ditahan</option>
				<option value='Penjualan'>Penjualan</option>
				<option value='Pembelian'>Pembelian</option>
				<option value='Biaya Penjualan'>Biaya Penjualan</option>
				<option value='Biaya ADM/UMUM'>Biaya ADM/UMUM</option>
				<option value='Tenaga Kerja Langsung'>Tenaga Kerja Langsung</option>
				<option value='Biaya Pabrikasi'>Biaya Pabrikasi</option>
				<option value='Pendapatan Lain Lain'>Pendapatan Lain Lain</option>
				<option value='Biaya Lain Lain'>Biaya Lain Lain</option>
				<option value='Prive/Dividen'>Prive/Dividen</option>
				</select></td>
				</tr>
				 <tr>
					<td>Nomor</td>
					<td>:</td>
					<td><input type='text' name='nomor' value='$rows4[nomor]'></td>
				 </tr>
				 <tr>
					<td>Nama</td>
					<td>:</td>
					<td><input type='text' name='nama' value='$rows4[nama]'></td>
				 </tr>
				 <tr>
 				<td>Pembeda NERACA</td>
 				<td>:</td>
 				<td><select name='kolom'>

 				<option value='$rows4[kolom]'>$rows4[kolom]		</option>
 				<option value='---'>---</option>
 				<option value='DEBIT'>DEBIT</option>
 				<option value='KREDIT'>KREDIT</option>
 				</select></td>
 				</tr>
				<tr>
			 <td>Pembeda LABA RUGI</td>
			 <td>:</td>
			 <td><select name='pembeda_laba_rugi'>

			 <option value='$rows4[pembeda_laba_rugi]'>$rows4[pembeda_laba_rugi]</option>

			 <option value=''>---</option>
			 <option value='BIAYA PEMASARAN'>BIAYA PEMASARAN</option>
			 <option value='PAJAK PENGHASILAN'>PAJAK PENGHASILAN</option>
			 <option value='RETUR/PPN PENJUALAN'>RETUR/PPN PENJUALAN</option>
			 <option value='PERSEDIAAN BARANG JADI'>PERSEDIAAN BARANG JADI</option>
			 <option value='PENDAPATAN LAIN LAIN'>PENDAPATAN LAIN LAIN</option>
			 <option value='BIAYA ADMINISTRASI UMUM'>BIAYA ADMINISTRASI UMUM</option>
			 <option value='HARGA POKOK PENJUALAN'>HARGA POKOK PENJUALAN</option>
			 <option value='PENJUALAN'>PENJUALAN</option>
			 </select></td>
			 </tr>
				 <input type='hidden' name='idhal' value='211'/></td>
				 <input type='hidden' name='iddeletehome' value='$iddeletehome'/></td>
				 <tr>
					<td></td>
					<td></td>
					<td><input type='submit' value='Update'></td>
				 </tr>
				</table>
			 </form>";
		}elseif ($idhal==211) {
			$iddeletehome=$_POST['iddeletehome'];
			$kelompok=$_POST['kelompok'];
			$nomor=$_POST['nomor'];
			$nama=$_POST['nama'];
			$kolom=$_POST['kolom'];
			$pembeda_laba_rugi=$_POST['pembeda_laba_rugi'];
			$upload = "UPDATE akuntansi_akun SET pembeda_laba_rugi='$pembeda_laba_rugi',kolom='$kolom',kelompok='$kelompok',nomor='$nomor',nama='$nama' WHERE id='$iddeletehome' ";
			$hasil = mysql_query($upload);
			echo "
				<h2>Data Telah di Update</h2>
			  <form action='?menu=home&mod=akuntansi/akun' method='POST'>
				<input type='hidden' name='idhal' value=''/>
				<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
				</form>";
		}


		//DAFTAR ITEM - TAMBAH DATA
		if ($idhal==130) {
				$idnomor=$_POST['idnomor'];
				$idkelompok=$_POST['idkelompok'];
				$iddaftarproduk=$_POST['iddaftarproduk'];
			echo "
			<form method ='post' action='?menu=home&mod=akuntansi/akun'>
			  <table>
				<tr>
				<td>Kelompok</td>
				<td>:</td>
				<td><select name='kelompok'>
				<option value='$idkelompok'>$idkelompok</option>
				<option value='Aktiva'>Aktiva</option>
				<option value='Passiva'>Passiva</option>
				<option value='Ekuitas'>Ekuitas</option>
				<option value='Pendapatan'>Pendapatan</option>
				<option value='Beban'>Beban</option>
				<option value='Aktiva Lancar'>Aktiva Lancar</option>
				<option value='Investasi Jangka Panjang'>Investasi Jangka Panjang</option>
				<option value='Aktiva Tetap'>Aktiva Tetap</option>
				<option value='Aktiva Lain Lain'>Aktiva Lain Lain</option>
				<option value='Kewajiban Lancar'>Kewajiban Lancar</option>
				<option value='Modal'>Modal</option>
				<option value='Laba Ditahan'>Laba Ditahan</option>
				<option value='Penjualan'>Penjualan</option>
				<option value='Pembelian'>Pembelian</option>
				<option value='Biaya Penjualan'>Biaya Penjualan</option>
				<option value='Biaya ADM/UMUM'>Biaya ADM/UMUM</option>
				<option value='Tenaga Kerja Langsung'>Tenaga Kerja Langsung</option>
				<option value='Biaya Pabrikasi'>Biaya Pabrikasi</option>
				<option value='Pendapatan Lain Lain'>Pendapatan Lain Lain</option>
				<option value='Biaya Lain Lain'>Biaya Lain Lain</option>
				<option value='Prive/Dividen'>Prive/Dividen</option>
				</select></td>
				</tr>
			   <tr>
			    <td>Nomor</td>
			    <td>:</td>
			    <td><input type='text' name='nomor' value='$idnomor.'></td>
			   </tr>
			   <tr>
			    <td>Nama</td>
			    <td>:</td>
			    <td><input type='text' name='nama'></td>
			   </tr>
				 <tr>
				 <td>Pembeda NERACA</td>
				 <td>:</td>
				 <td><select name='kolom'>
				 <option value='---'>---</option>
				 <option value='DEBIT'>DEBIT</option>
				 <option value='KREDIT'>KREDIT</option>
				 </select></td>
				 </tr>
				 <tr>
				 <td>Pembeda LABA RUGI</td>
				 <td>:</td>
				 <td><select name='pembeda_laba_rugi'>
				 <option value=''>---</option>
				 <option value='BIAYA PEMASARAN'>BIAYA PEMASARAN</option>
				 <option value='PAJAK PENGHASILAN'>PAJAK PENGHASILAN</option>
				 <option value='RETUR/PPN PENJUALAN'>RETUR/PPN PENJUALAN</option>
				 <option value='PERSEDIAAN BARANG JADI'>PERSEDIAAN BARANG JADI</option>
				 <option value='PENDAPATAN LAIN LAIN'>PENDAPATAN LAIN LAIN</option>
				 <option value='BIAYA ADMINISTRASI UMUM'>BIAYA ADMINISTRASI UMUM</option>
				 <option value='HARGA POKOK PENJUALAN'>HARGA POKOK PENJUALAN</option>
				 <option value='PENJUALAN'>PENJUALAN</option>
				 </select></td>
				 </tr>
				 <input type='hidden' name='idhal' value='133'/></td>
				 <input type='hidden' name='tampil' value='yes'/></td>

				 <input type='hidden' name='nomorinduk' value='$idnomor	'/></td>
				 <input type='hidden' name='iddaftarproduk' value='$iddaftarproduk'/></td>
			   <tr>
			    <td></td>
			    <td></td>
			    <td><input type='submit' value='KIRIM'></td>
			   </tr>
			  </table>
			 </form>";
		} elseif ($idhal==133) {
			$kelompok=$_POST['kelompok'];
			$nomor=$_POST['nomor'];
			$nama=$_POST['nama'];
			$tampil=$_POST['tampil'];
			$kolom=$_POST['kolom'];
			$pembeda_laba_rugi=$_POST['pembeda_laba_rugi'];
			$nomorinduk=$_POST['nomorinduk'];
			$iddaftarproduk=$_POST['iddaftarproduk'];
			$upload = "INSERT IGNORE INTO akuntansi_akun (kolom,pembeda_laba_rugi,kelompok,nomor,nama,tampil,induk) VALUES('$kolom','$pembeda_laba_rugi','$kelompok','$nomor','$nama','$tampil','$nomorinduk')";
			$hasil = mysql_query($upload);
			echo "
				<h2>Data Telah Disimpan</h2>
			  <form action='?menu=home&mod=akuntansi/akun' method='POST'>
				<input type='hidden' name='idhal' value='$iddaftarproduk'/>
				<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
				</form>";
		}


		//DAFTAR ITEM - DELETE
		if ($idhal==110) {
			$iddeletedaftar=$_POST['iddeletedaftar'];
			$iddaftarproduk=$_POST['iddaftarproduk'];
			$upload = "DELETE FROM akuntansi_akun WHERE id='$iddeletedaftar'";
			$hasil = mysql_query($upload);
			echo "
				<h2>Data Telah Dihapus</h2>
			  <form action='?menu=home&mod=akuntansi/akun' method='POST'>
				<input type='hidden' name='idhal' value='$iddaftarproduk'/>
				<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
				</form>";
		}

		//DAFTAR ITEM - Update
		if ($idhal==120) {
			$iddeletehome=$_POST['idupdatedaftar'];
			$iddaftarproduk=$_POST['iddaftarproduk'];
			$sql4="SELECT * FROM akuntansi_akun WHERE id='$iddeletehome'";
			$result4= mysql_query($sql4);
			$rows4=mysql_fetch_array($result4);
			echo "
			<form method ='post' action='?menu=home&mod=akuntansi/akun'>
				<table>
				<tr>
				<td>Kelompok</td>
				<td>:</td>
				<td><select name='kelompok'>

				<option value='$rows4[kelompok]'>$rows4[kelompok]		</option>

				<option value='Aktiva'>Aktiva</option>
				<option value='Passiva'>Passiva</option>
				<option value='Ekuitas'>Ekuitas</option>
				<option value='Pendapatan'>Pendapatan</option>
				<option value='Beban'>Beban</option>
				<option value='Aktiva Lancar'>Aktiva Lancar</option>
				<option value='Investasi Jangka Panjang'>Investasi Jangka Panjang</option>
				<option value='Aktiva Tetap'>Aktiva Tetap</option>
				<option value='Aktiva Lain Lain'>Aktiva Lain Lain</option>
				<option value='Kewajiban Lancar'>Kewajiban Lancar</option>
				<option value='Modal'>Modal</option>
				<option value='Laba Ditahan'>Laba Ditahan</option>
				<option value='Penjualan'>Penjualan</option>
				<option value='Pembelian'>Pembelian</option>
				<option value='Biaya Penjualan'>Biaya Penjualan</option>
				<option value='Biaya ADM/UMUM'>Biaya ADM/UMUM</option>
				<option value='Tenaga Kerja Langsung'>Tenaga Kerja Langsung</option>
				<option value='Biaya Pabrikasi'>Biaya Pabrikasi</option>
				<option value='Pendapatan Lain Lain'>Pendapatan Lain Lain</option>
				<option value='Biaya Lain Lain'>Biaya Lain Lain</option>
				<option value='Prive/Dividen'>Prive/Dividen</option>
				</select></td>
				</tr>
				 <tr>
					<td>Nomor</td>
					<td>:</td>
					<td><input type='text' name='nomor' value='$rows4[nomor]'></td>
				 </tr>
				 <tr>
					<td>Nama</td>
					<td>:</td>
					<td><input type='text' name='nama' value='$rows4[nama]'></td>
				 </tr>
				 <tr>
				 <td>Pembeda NERACA</td>
				 <td>:</td>
				 <td><select name='kolom'>

				 <option value='$rows4[kolom]'>$rows4[kolom]		</option>
				 <option value='---'>---</option>
				 <option value='DEBIT'>DEBIT</option>
				 <option value='KREDIT'>KREDIT</option>
				 </select></td>
				 </tr>
				 <tr>
				 <td>Pembeda LABA RUGI</td>
				 <td>:</td>
				 <td><select name='pembeda_laba_rugi'>

				 <option value='$rows4[pembeda_laba_rugi]'>$rows4[pembeda_laba_rugi]</option>

				 <option value=''>---</option>
				 <option value='BIAYA PEMASARAN'>BIAYA PEMASARAN</option>
				 <option value='PAJAK PENGHASILAN'>PAJAK PENGHASILAN</option>
				 <option value='RETUR/PPN PENJUALAN'>RETUR/PPN PENJUALAN</option>
				 <option value='PERSEDIAAN BARANG JADI'>PERSEDIAAN BARANG JADI</option>
				 <option value='PENDAPATAN LAIN LAIN'>PENDAPATAN LAIN LAIN</option>
				 <option value='BIAYA ADMINISTRASI UMUM'>BIAYA ADMINISTRASI UMUM</option>
				 <option value='HARGA POKOK PENJUALAN'>HARGA POKOK PENJUALAN</option>
				 <option value='PENJUALAN'>PENJUALAN</option>
				 </select></td>
				 </tr>
				 <input type='hidden' name='idhal' value='122'/></td>
				 <input type='hidden' name='iddeletehome' value='$iddeletehome'/></td>
				 <input type='hidden' name='iddaftarproduk' value='$iddaftarproduk'/></td>
				 <tr>
					<td></td>
					<td></td>
					<td><input type='submit' value='Update'></td>
				 </tr>
				</table>
			 </form>";
		}elseif ($idhal==122) {

			$iddaftarproduk=$_POST['iddaftarproduk'];
			$iddeletehome=$_POST['iddeletehome'];
			$kelompok=$_POST['kelompok'];
			$nomor=$_POST['nomor'];
			$nama=$_POST['nama'];
			$kolom=$_POST['kolom'];
			$pembeda_laba_rugi=$_POST['pembeda_laba_rugi'];
			$upload = "UPDATE akuntansi_akun SET kolom='$kolom',pembeda_laba_rugi='$pembeda_laba_rugi',kelompok='$kelompok',nomor='$nomor',nama='$nama' WHERE id='$iddeletehome' ";
			$hasil = mysql_query($upload);
			echo "
				<h2>Data Telah di Update</h2>
			  <form action='?menu=home&mod=akuntansi/akun' method='POST'>
				<input type='hidden' name='idhal' value='$iddaftarproduk'/>
				<tr><td style='font-weight:bold; text-align:center; '><input type='submit' name='submit2' value='kembali'></tr>
				</form>";
		}



		}

function editform($id,$btn){ extract($GLOBALS);
	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $fld from $tbl");

	$r=getrow($fld,$tbl,"where id='$id'");
	echo  " <form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label>". drops(1,'Aktiva,Passiva,Ekuitas,Pendapatan,Beban',$r[1])."</li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]'/></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]'/></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>
	</form>	";
 	}

function doimport(){ extract($GLOBALS);
	require_once 'addon/excel_reader2.php';
	$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);
	$sukses = 0; $gagal = 0;
	for ($i=2; $i<=$baris; $i++) {


	$id = $data->val($i, 1);
	$kelompok = $data->val($i, 2);
	$nomor = $data->val($i, 3);
	$nama = $data->val($i, 4);

	$query = "INSERT INTO akuntansi_akun VALUES ('$id','$kelompok','$nomor','$nama')";

	$hasil = mysql_query($query)or die(mysql_error());
	if ($hasil) $sukses++;
	else $gagal++;
	}
	echo "<h3>Proses import data selesai.</h3>";
	echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
	echo "Jumlah data yang gagal diimport : ".$gagal."</p>";
	home();
 }
?>
