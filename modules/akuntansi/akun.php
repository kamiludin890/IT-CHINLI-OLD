<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='akuntansi/akun';
	$tbl='akuntansi_akun';
	$fld='id,kelompok,nomor,nama' ;
function editmenu(){extract($GLOBALS);}

//START HOME
function home(){extract($GLOBALS);
include 'style.css';

//AMBIL POST PERTAMA START
$halaman=$_POST['halaman'];
$induk=$_POST['induk'];
$nama_rincian=$_POST['nama_rincian'];
$pencarian=$_POST['pencarian'];
$pencarian_rincian=$_POST['pencarian_rincian'];
$jenis_tambah=$_POST['jenis_tambah'];
$hapus=$_POST['hapus'];
//AMBIL POST PERTAMA END

if ($halaman=='yakin') {
	echo "
			<td>Yakin nih?</td>
			<td style=width:1%; align:center>
				<form method ='post' action='?menu=home&mod=akuntansi/akun'>
					<input type='submit' name='submit' value='Ya'>
					<input type='hidden' name='hapus' value='$induk'>
					<input type='hidden' name='pencarian' value='$pencarian'>
					<input type='hidden' name='induk' value='$induk'>
					<input type='hidden' name='halaman' value=''>
				</form>
			</td>";
			//Kembali START
			echo "</br>
			<form method ='post' action='?menu=home&mod=akuntansi/akun'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<td><input type='submit' value='Tidak'></td>
			</form>
			</br></br>";
			//Kembali END
}

//Delete
if ($hapus) {
	if($halaman==''){
		$delete="DELETE FROM akuntansi_akun WHERE induk='$hapus'";
	}else{
		$delete="DELETE FROM akuntansi_akun WHERE id='$hapus'";
	}
	$eksekusi_delete=mysql_query($delete);
}//Delete

//Insert TAMBAH Data START
if ($jenis_tambah) {
//AMBIL POST KEDUA START
$kelompok=$_POST['kelompok'];
$nomor=$_POST['nomor'];
$nama=$_POST['nama'];
$kolom=$_POST['kolom'];
$pembeda_laba_rugi=$_POST['pembeda_laba_rugi'];
//AMBIL POST KEDUA END

if ($jenis_tambah=='tambah_data'){$tampil=''; $induk=$nomor;}
if ($jenis_tambah=='tambah_data_rincian'){$tampil='yes';}

$insert="INSERT INTO akuntansi_akun	SET induk='$induk',kelompok='$kelompok',nomor='$nomor',nama='$nama',kolom='$kolom',pembeda_laba_rugi='$pembeda_laba_rugi',tampil='$tampil'";
$eksekusi_insert=mysql_query($insert);
}//Insert TAMBAH Data START

//Tambah Data START
if ($halaman=='tambah_data' OR $halaman=='tambah_data_rincian') {

	if ($halaman=='tambah_data'){$halaman1='';}
	if ($halaman=='tambah_data_rincian'){$halaman1='rincian';}
	//Kembali START
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansi/akun'>
	<input type='hidden' name='pencarian' value='$pencarian'>
	<input type='hidden' name='induk' value='$induk'>
	<input type='hidden' name='halaman' value='$halaman1'>
	<input type='hidden' name='nama_rincian' value='$nama_rincian'>
	<td><input type='submit' value='Kembali'></td>
	</tr>
	</form>
	</br></br>";
	//Kembali END

$sql9="SELECT * FROM akuntansi_akun	WHERE nomor='$induk'";
$result9=mysql_query($sql9);
$rows9=mysql_fetch_array($result9);
//echo "$nama_rincian TEST";

	echo "
	<table class='tabel_utama'>
	<tr style='background-color:#C0C0C0;'>
		<th align=center width=52px>Kelompok</th>
		<th align=center width=52px>Nomor</th>
		<th align=center width=150px>Nama Terkait</th>
		<th align=center width=52px>Pembeda Neraca</th>
		<th align=center width=150px>Pembeda Laba Rugi</th>
	</tr>";

	echo "
  <tr>
	<form method ='post' action='?menu=home&mod=akuntansi/akun'>
		<td><select name='kelompok' style='width:100%;'>
				<option value='$rows9[kelompok]'>$rows9[kelompok]</option>
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
				<option value='Prive/Dividen'>Prive/Dividen</option></select>
		</td>
		<td align=center><input type='text' style='width:98%;' name='nomor' value='$rows9[induk]'></td>
		<td align=center><input type='text' style='width:98%;' name='nama' value=''></td>
		<td><select name='kolom' style='width:100%;'>
				<option value='$rows9[kolom]'>$rows9[kolom]</option>
				<option value='---'>---</option>
				<option value='DEBIT'>DEBIT</option>
				<option value='KREDIT'>KREDIT</option></select>
		</td>
		<td><select name='pembeda_laba_rugi' style='width:100%;'>
			<option value='$rows9[pembeda_laba_rugi]'>$rows9[pembeda_laba_rugi]</option>
			<option value='---'>---</option>
			<option value='BIAYA PEMASARAN'>BIAYA PEMASARAN</option>
			<option value='PAJAK PENGHASILAN'>PAJAK PENGHASILAN</option>
			<option value='RETUR/PPN PENJUALAN'>RETUR/PPN PENJUALAN</option>
			<option value='PERSEDIAAN BARANG JADI'>PERSEDIAAN BARANG JADI</option>
			<option value='PENDAPATAN LAIN LAIN'>PENDAPATAN LAIN LAIN</option>
			<option value='BIAYA ADMINISTRASI UMUM'>BIAYA ADMINISTRASI UMUM</option>
			<option value='HARGA POKOK PENJUALAN'>HARGA POKOK PENJUALAN</option>
			<option value='PENJUALAN'>PENJUALAN</option></select>
		</td>
	</tr>";

	echo "
	<tr>
		<td colspan=5><input type='submit' name='' style='width:100%;' value='Simpan'></td>
		<input type='hidden' name='pencarian' value='$pencarian'>
		<input type='hidden' name='jenis_tambah' value='$halaman'>
		<input type='hidden' name='induk' value='$rows9[induk]'>
		<input type='hidden' name='halaman' value='$halaman1'>
		<input type='hidden' name='nama_rincian' value='$nama_rincian'>
	</tr>";
	echo "
	</form>
	</table></tr>";
}
//Tambah Data END


//HALAMAN RINCIAN START
if($halaman=='rincian') {
	echo "<h1>Daftar Rincian Akun $nama_rincian</h1>";

	//Kembali START
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansi/akun'>
	<input type='hidden' name='pencarian' value='$pencarian'>
	<td><input type='submit' value='Kembali'></td>
	</tr>
	</form>
	</br></br>";
	//Kembali END

	//TAMBAH DATA START
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansi/akun'>
	<td><input type='submit' value='Tambah Data Rincian'></td>
	<input type='hidden' name='halaman' value='tambah_data_rincian'>
	<input type='hidden' name='pencarian' value='$pencarian'>
	<input type='hidden' name='induk' value='$induk'>
	<input type='hidden' name='nama_rincian' value='$nama_rincian'>
	</tr>
	</form>
	</br></br>";
	//TAMBAH DATA END

	//Pencarian START
		echo "
		<table>
		<form method ='post' action='?menu=home&mod=akuntansi/akun'>
		<tr>
		 <td>Cari</td>
		 <td>:</td>
		 <td><input type='text' name='pencarian_rincian' value='$pencarian_rincian'></td>
		 <td><input type='hidden' name='pencarian' value='$pencarian'></td>
		 <input type='hidden' name='halaman' value='rincian'>
		</tr>
		</form>
		</table>
		</br>";
	//Pencarian END
	//TABEL AWAL START
		echo "
		<table class='tabel_utama'>
		<tr style='background-color:#C0C0C0;'>
		<th align=center width=auto>No</th>
		<th align=center width=auto>Kelompok</th>
		<th align=center width=auto>Nomor</th>
		<th align=center width=auto>Nama Terkait</th>
		<th align=center width=auto>Pembeda Neraca</th>
		<th align=center width=auto>Pembeda Laba Rugi</th>
		<th align=center width=auto>Rincian</th>
		</tr>";

		if ($pencarian_rincian){$tambahan_pencarian_rincian="AND nama LIKE '%$pencarian_rincian%' AND tampil='yes' OR kelompok LIKE '%$pencarian_rincian%' AND tampil='yes' OR nomor LIKE '%$pencarian_rincian%' AND tampil='yes' OR kolom LIKE '%$pencarian_rincian%' AND tampil='yes' OR pembeda_laba_rugi LIKE '%$pencarian_rincian%' AND tampil='yes'";}
		$sql1="SELECT * FROM akuntansi_akun WHERE induk='$induk' AND tampil='yes' $tambahan_pencarian_rincian";
		$result1=mysql_query($sql1);
		$no=1;
		while($rows1=mysql_fetch_array($result1)){
			$warnaGenap="#FFFFF";	$warnaGanjil="#CEF6F5";
			if ($no % 2 == 0){$color = $warnaGenap;	$color5 = $warnaGenap;}else{$color = $warnaGanjil;	$color5 = $warnaGanjil;}
		echo "
		<tr>
			<td style=background-color:$color; align=center>$no</td>
			<td style=background-color:$color; align=center>$rows1[kelompok]</td>
			<td style=background-color:$color; align=center>$rows1[nomor]</td>
			<td style=background-color:$color; align=center>$rows1[nama]</td>
			<td style=background-color:$color; align=center>$rows1[kolom]</td>
			<td style=background-color:$color; align=center>$rows1[pembeda_laba_rugi]</td>";
	echo "
			<td style=width:1%;>
				<form method ='post' action='?menu=home&mod=akuntansi/akun'>
					<input type='image' src='modules/gambar/delete.png' width='30' height'30' name='submit' value='Hapus'>
					<input type='hidden' name='hapus' value='$rows1[id]'>
					<input type='hidden' name='pencarian' value='$pencarian'>
					<input type='hidden' name='induk' value='$rows1[induk]'>
					<input type='hidden' name='halaman' value='rincian'>
					<input type='hidden' name='nama_rincian' value='$nama_rincian'>
				</form>
			</td>";

		echo "
		</tr>";
	//TABEL AWAL END
	$no++;}echo "</table>";
//HALAMAN RINCIAN END
}if($halaman==''){
//HALAMAN UTAMA START
	echo "<h1>Daftar Akun</h1>";

	//TAMBAH DATA START
	echo "</br>
	<form method ='post' action='?menu=home&mod=akuntansi/akun'>
	<td><input type='submit' value='Tambah Data'></td>
	<input type='hidden' name='halaman' value='tambah_data'>
	<input type='hidden' name='pencarian' value='$pencarian'>
	</tr>
	</form>
	</br></br>";
	//TAMBAH DATA END

//Pencarian START
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=akuntansi/akun'>
	<tr>
	 <td>Cari</td>
	 <td>:</td>
	 <td><input type='text' name='pencarian' value='$pencarian'></td>
	</tr>
	</form>
	</table>
	</br>";
//Pencarian END
//TABEL AWAL START

	echo "
	<table class='tabel_utama'>
	<tr style='background-color:#C0C0C0;'>
	<th align=center width=auto>No</th>
	<th align=center width=auto>Kelompok</th>
	<th align=center width=auto>Nomor</th>
	<th align=center width=auto>Nama Terkait</th>
	<th align=center width=auto>Pembeda Neraca</th>
	<th align=center width=auto>Pembeda Laba Rugi</th>
	<th align=center width=auto></th>
	<th align=center width=auto></th>
	</tr>";

	if ($pencarian){$tambahan_pencarian="AND nama LIKE '%$pencarian%' AND tampil='' OR kelompok LIKE '%$pencarian%' AND tampil='' OR nomor LIKE '%$pencarian%' AND tampil='' OR kolom LIKE '%$pencarian%' AND tampil='' OR pembeda_laba_rugi LIKE '%$pencarian%' AND tampil=''";}
	$sql1="SELECT * FROM akuntansi_akun WHERE tampil='' $tambahan_pencarian";
	$result1=mysql_query($sql1);
	$no=1;
	while($rows1=mysql_fetch_array($result1)){
		$warnaGenap="#FFFFF";	$warnaGanjil="#CEF6F5";
		if ($no % 2 == 0){$color = $warnaGenap;	$color5 = $warnaGenap;}else{$color = $warnaGanjil;	$color5 = $warnaGanjil;}
	echo "
	<tr>
		<td style=background-color:$color; align=center>$no</td>
		<td style=background-color:$color; align=center>$rows1[kelompok]</td>
		<td style=background-color:$color; align=center>$rows1[nomor]</td>
		<td style=background-color:$color; align=center>$rows1[nama]</td>
		<td style=background-color:$color; align=center>$rows1[kolom]</td>
		<td style=background-color:$color; align=center>$rows1[pembeda_laba_rugi]</td>";
echo "
		<td style=width:1%;>
			<form method ='post' action='?menu=home&mod=akuntansi/akun'>
				<input type='image' src='modules/gambar/item.png' width='30' height'30' name='submit' value='Rincian'>
				<input type='hidden' name='halaman' value='rincian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='induk' value='$rows1[induk]'>
				<input type='hidden' name='nama_rincian' value='$rows1[nama]'>
			</form>
		</td>";
echo "
		<td style=width:1%;>
			<form method ='post' action='?menu=home&mod=akuntansi/akun'>
				<input type='image' src='modules/gambar/delete.png' width='30' height'30' name='submit' value='Hapus'>
				<input type='hidden' name='hapus' value='$rows1[induk]'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='induk' value='$rows1[induk]'>
				<input type='hidden' name='halaman' value='yakin'>
			</form>
		</td>";

	echo "
	</tr>";
//TABEL AWAL END
$no++;}echo "</table>";
}//HALAMAN UTAMA END


}//END HOME
//END PHP?>
