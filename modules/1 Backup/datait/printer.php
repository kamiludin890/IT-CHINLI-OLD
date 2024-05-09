<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row,$id_user, $akses;
	$mod='datait/printer';
function editmenu(){extract($GLOBALS);}

function home(){extract($GLOBALS);
//JUDUL
echo "<center><h1>Data Printer PT Chinli Plastic Technology Indonesia</h1></center>";

//POST
$departement=$_POST['departement'];
$bagian=$_POST['bagian'];
$tambah_item=$_POST['tambah_item'];
$nama_komputer=$_POST['nama_komputer'];
$tanggal_pembelian=$_POST['tanggal_pembelian'];
$pengguna=$_POST['pengguna'];
$nama_komputer=$_POST['nama_komputer'];
$status=$_POST['status'];
$kondisi=$_POST['kondisi'];
$delete=$_POST['delete'];
$foto_cpu=$_POST['foto_cpu'];
$rincian=$_POST['rincian'];
$id_items=$_POST['id_items'];
$save=$_POST['save'];
$tambah_sparepart=$_POST['tambah_sparepart'];
$update_sparepart=$_POST['update_sparepart'];
$delete_sparepart=$_POST['delete_sparepart'];
$nama_sparepart=$_POST['nama_sparepart'];
$type=$_POST['type'];
$size=$_POST['size'];
$no_unik=$_POST['no_unik'];
$tanggal_pembelian_sparepart=$_POST['tanggal_pembelian_sparepart'];
$kondisi_sparepart=$_POST['kondisi_sparepart'];
$status_sparepart=$_POST['status_sparepart'];
$id_sparepart=$_POST['id_sparepart'];
$merek=$_POST['merek'];
$keterangan_sparepart=$_POST['keterangan_sparepart'];


//Skrip Tambah Foto
if($_POST['upload']){
	$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
	$nama1 = $_FILES['file']['name'];
	$idtgl=date('Y-m-d h:i:sa');
	$idtgl2 = preg_replace("/[^0-9]/", "", $idtgl);
	$nama="$idtgl2$nama1";
	$x = explode('.', $nama);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['file']['size'];
	$file_tmp = $_FILES['file']['tmp_name'];

	if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		if($ukuran < 1044070){
			move_uploaded_file($file_tmp, 'modules/datait/file/'.$nama);
			$query = mysql_query("INSERT INTO datait_printer SET foto_cpu='$nama',nama_komputer='$nama_komputer',tanggal_pembelian='$tanggal_pembelian',pengguna='$pengguna',status='$status',kondisi='$kondisi',departement='$departement',bagian='$bagian'");
			if($query){
				echo 'FILE BERHASIL DI UPLOAD';
			}else{
				echo 'GAGAL MENGUPLOAD GAMBAR';
			}
		}else{
			echo 'UKURAN FILE TERLALU BESAR';
		}
	}else{
		echo 'EKSTENSI FILE Jpeg atau PNG (*wajib cantumkan foto)';
	}
}//END SKRIP TAMBAH FOTO

//DELETE TABEL AWAL
if ($delete=='delete') {
$target="modules/datait/file/$foto_cpu";
unlink($target);//DELETE NOW
$delete_database="DELETE FROM datait_printer WHERE foto_cpu='$foto_cpu'";
$eksekusi=mysql_query($delete_database);
}

//SAVE
if ($save=='save') {

	if($_POST['save']){
		$ekstensi_diperbolehkan	= array('png','jpg');
		$nama1 = $_FILES['file']['name'];
		$idtgl=date('Y-m-d h:i:sa');
		$idtgl2 = preg_replace("/[^0-9]/", "", $idtgl);
		$nama="$idtgl2$nama1";
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];

		if ($nama1=='') {$query_update="";}else{$query_update="foto_cpu='$nama',"; move_uploaded_file($file_tmp, 'modules/datait/file/'.$nama);
			$target="modules/datait/file/$foto_cpu";
			unlink($target);}//DELETE NOW

				$query = mysql_query("UPDATE datait_printer SET $query_update nama_komputer='$nama_komputer',tanggal_pembelian='$tanggal_pembelian',pengguna='$pengguna',status='$status',kondisi='$kondisi',departement='$departement',bagian='$bagian'");
}}


//JUDUL DEPARTEMENT
if ($departement=='CL') {echo "<center><h2>Departement CL</h2></center>";}
if ($departement=='SL') {echo "<center><h2>Departement SL</h2></center>";}

//JUDUL BAGIAN
if ($bagian==''){}else{echo "<center><h3>Jenis Printer : $bagian</h3></center>";}

//AWAL PILIHAN DEPARTEMENT
echo "<form method ='post' action='?menu=home&mod=datait/printer'>
<table>
<tr>
 <td>Departement</td>
 <td>:</td>
 <td><select name='departement'>
 <option value='$departement'>$departement</option>
 <option value='CL'>CL</option>
 <option value='SL'>SL</option>
 <option value='CLS'>CLS</option>
 </select></td>
 <td><input type='submit' value='Pilih'></td>
</tr>
</table>
</form></br>
";

//AWAL PILIHAN BAGIAN
if($departement=='CL'){
	echo "<form method ='post' action='?menu=home&mod=datait/printer'>
	<table>
	<tr>
	 <td style='width:64px'>Jenis Printer</td>
	 <td>:</td>
	 <td><select name='bagian'>
	 <option value='$bagian'>$bagian</option>
	 <option value='Laserjet'>Laserjet</option>
	 <option value='Dotmatrix'>Dotmatrix</option>
	 <option value='Ink'>Ink</option>
	 </select></td>
	 <input type='hidden' name='departement' value='CL'>
	 <td><input type='submit' value='Pilih'></td>
	</tr>
	</table>
	</form></br></table>";}
if($departement=='SL'){
	echo "<form method ='post' action='?menu=home&mod=datait/printer'>
	<table>
	<tr>
  <td style='width:64px'>Jenis Printer</td>
	 <td>:</td>
	 <td><select name='bagian'>
	 <option value='$bagian'>$bagian</option>
	 <option value='Laserjet'>Laserjet</option>
	 <option value='Dotmatrix'>Dotmatrix</option>
	 <option value='Ink'>Ink</option>
	 </select></td>
	 <input type='hidden' name='departement' value='SL'>
	 <td><input type='submit' value='Pilih'></td>
	</tr>
	</form></br></table>";}

//TAMBAH ITEM
if ($tambah_item=='tambah_item'){

echo "<table><form action='?menu=home&mod=datait/printer' method='post' enctype='multipart/form-data'>
			<tr>
			<td>FOTO PRINTER</td>
			<td>:</td>
			<td><input type='file' name='file'></td>
	  	</tr>

			<tr>
			<td>KOMPUTER YANG TERHUBUNG PRINTER</td>
			<td>:</td>
			<td><input type='text' style='width:250px' name='nama_komputer' value=''></td>
			</tr>

			<tr>
			<td>TANGGAL PEMBELIAN</td>
			<td>:</td>
			<td><input type='date' style='width:250px' name='tanggal_pembelian' value=''></td>
			</tr>

			<tr>
			<td>LOKASI PRINTER</td>
			<td>:</td>
			<td><input type='text' style='width:250px' name='pengguna' value=''></td>
			</tr>

			<tr>
			 <td>STATUS</td>
			 <td>:</td>
			 <td><select name='status' style='width:254px'>
			 <option value='Digunakan'>Digunakan</option>
			 <option value='Disimpan'>Disimpan</option>
			 <option value='Diservis'>Diservis</option>
			 <option value='Dibuang'>Dibuang</option>
			</tr>

			<tr>
			 <td>KONDISI</td>
			 <td>:</td>
			 <td><select name='kondisi' style='width:254px'>
			 <option value='Baik'>Baik</option>
			 <option value='Sering Bermasalah'>Sering Bermasalah</option>
			 <option value='Rusak'>Rusak</option>
			</tr>
			<input type='hidden' name='bagian' value='$bagian'>
			<input type='hidden' name='departement' value='$departement'>
			<td><input type='submit' name='upload' value='Upload'></td>
			</form></table>";

}//END TAMBAH ITEM

//RINCIAN ITEM
elseif($rincian=='rincian') {

	$sql2="SELECT * FROM datait_printer WHERE id='$id_items'";
	$result2=mysql_query($sql2);
	$rows2=mysql_fetch_array($result2);

	echo "<table><form action='?menu=home&mod=datait/printer' method='post' enctype='multipart/form-data'>
				<tr>
				<td>FOTO PRINTER</td>
				<td>:</td>
				<td><input type='file' name='file'></td>
				<td style='border:1px solid;' align='center'><img src='modules/datait/file/$rows2[foto_cpu]' width='200' height='300' /><br/></td>
		  	</tr>

				<tr>
				<td>KOMPUTER YANG TERHUBUNG PRINTER</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='nama_komputer' value='$rows2[nama_komputer]'></td>
				</tr>

				<tr>
				<td>TANGGAL PEMBELIAN</td>
				<td>:</td>
				<td><input type='date' style='width:250px' name='tanggal_pembelian' value='$rows2[tanggal_pembelian]'></td>
				</tr>

				<tr>
				<td>LOKASI PRINTER</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='pengguna' value='$rows2[pengguna]'></td>
				</tr>

				<tr>
				 <td>STATUS</td>
				 <td>:</td>
				 <td><select name='status' style='width:254px'>
				<option value='$rows2[status]'>".$rows2[status]."</option>
				 <option value='Digunakan'>Digunakan</option>
				 <option value='Disimpan'>Disimpan</option>
				 <option value='Diservis'>Diservis</option>
				 <option value='Dibuang'>Dibuang</option>
				</tr>

				<tr>
				 <td>KONDISI</td>
				 <td>:</td>
				 <td><select name='kondisi' style='width:254px'>
				<option value='$rows2[kondisi]'>".$rows2[kondisi]."</option>
				 <option value='Baik'>Baik</option>
				 <option value='Sering Bermasalah'>Sering Bermasalah</option>
				 <option value='Rusak'>Rusak</option>
				</tr>
				<tr>
				<input type='hidden' name='bagian' value='$rows2[bagian]'>
				<input type='hidden' name='departement' value='$rows2[departement]'>
				<input type='hidden' name='id_items' value='$rows2[id_items]'>
				<input type='hidden' name='foto_cpu' value='$rows2[foto_cpu]'>
				<td><input type='submit' name='save' value='save'>
				</form>

				<form action='?menu=home&mod=datait/printer' method='POST'>
				<input type='hidden' name='departement' value='$rows2[departement]'/>
				<input type='hidden' name='bagian' value='$rows2[bagian]'/>
				<input type='submit' name='submit1' value='back'></td>
				</form>
				</tr></table></br></br>";


				echo "
				<form action='?menu=home&mod=datait/printer' method='POST'>
				<input type='hidden' name='departement' value='$departement'/>
				<input type='hidden' name='bagian' value='$bagian'/>
				<input type='hidden' name='id_items' value='$id_items'/>
				<input type='hidden' name='rincian' value='rincian'/>
				<input type='hidden' name='tambah_sparepart' value='tambah_sparepart'/>
				<td><input type='submit' style='width:100%;' value='Pergantian Sparepart'></td></tr>
				</form></br>";

				//Tambah Hapus Update Sparepart
				if ($tambah_sparepart=='tambah_sparepart') {
				$insert_sparepart="INSERT INTO datait_printer_items SET induk='$id_items'";
				mysql_query($insert_sparepart);
				}

				if ($update_sparepart=='update_sparepart') {
				$update_sparepart="UPDATE datait_printer_items SET merek='$merek',keterangan_sparepart='$keterangan_sparepart',status_sparepart='$status_sparepart',nama_sparepart='$nama_sparepart',type='$type',size='$size',no_unik='$no_unik',tanggal_pembelian_sparepart='$tanggal_pembelian_sparepart',kondisi_sparepart='$kondisi_sparepart' WHERE id='$id_sparepart'";
				mysql_query($update_sparepart);

				$update_sparepart_history="INSERT INTO datait_printer_history SET merek='$merek',keterangan_sparepart='$keterangan_sparepart',status_sparepart='$status_sparepart',nama_sparepart='$nama_sparepart',type='$type',size='$size',no_unik='$no_unik',tanggal_pembelian_sparepart='$tanggal_pembelian_sparepart',kondisi_sparepart='$kondisi_sparepart',induk='$id_items'";
				mysql_query($update_sparepart_history);
				}

				if ($delete_sparepart=='delete_sparepart') {
				$delete_sparepart="DELETE FROM datait_printer_items WHERE id='$id_sparepart'";
				mysql_query($delete_sparepart);
				}

				echo "
				<table class=table width=100% align=center border=1>
				<tr style='background-color:#C0C0C0;'>
				<th align=center width=1%>No</th>
				<th align=center width=7%>Nama Sparepart</th>
				<th align=center width=7%>Merek</th>
				<th align=center width=7%>Type</th>
				<th align=center width=3%>Size</th>
				<th align=center width=7%>ID/No Unik Sparepart</th>
				<th align=center width=1%>Tanggal Pergantian Sparepart</th>
				<th align=center width=7%>Status</th>
				<th align=center width=7%>Kondisi</th>
				<th align=center width=7%>Keterangan</th>
				<th align=center width=7%>---</th>
				<th align=center width=7%>---</th>
				</tr>";


				$sql3="SELECT * FROM datait_printer_items WHERE induk='$id_items' ORDER BY id";
				$result3=mysql_query($sql3);
				$n=1;
				while ($rows3=mysql_fetch_array($result3)) {
				echo "<form action='?menu=home&mod=datait/printer' method='POST'>
				<tr>
				<td style='padding: 5px; color:black; align='center' align='center' width='10px' bgcolor='#FFFFFF'><strong>$n</strong></td>
				<td style='padding: 3px; color:black; align='center'><input type='text' style='width:110px' name='nama_sparepart' value='$rows3[nama_sparepart]'></td>
				<td style='padding: 3px; color:black; align='center'><input type='text' style='width:110px' name='merek' value='$rows3[merek]'></td>
				<td style='padding: 3px; color:black; align='center'><input type='text' style='width:110px' name='type' value='$rows3[type]'></td>
				<td style='padding: 3px; color:black; align='center'><input type='text' style='width:110px' name='size' value='$rows3[size]'></td>
				<td style='padding: 3px; color:black; align='center'><input type='text' name='no_unik' value='$rows3[no_unik]'></td>
				<td style='padding: 3px; color:black; align='center'><input type='date' style='width:110px' name='tanggal_pembelian_sparepart' value='$rows3[tanggal_pembelian_sparepart]'></td>

				<td><select name='status_sparepart' style='width:110px'>
							<option value='$rows3[status_sparepart]'>$rows3[status_sparepart]</option>
							<option value='Baru'>Baru</option>
							<option value='Bekas'>Bekas</option>
						</select></td>

				<td><select name='kondisi_sparepart' style='width:110px'>
							<option value='$rows3[kondisi_sparepart]'>$rows3[kondisi_sparepart]</option>
							<option value='Baik'>Baik</option>
							<option value='Sering Bermasalah'>Sering Bermasalah</option>
							<option value='Rusak'>Rusak</option>
						</select></td>
				<td style='padding: 3px; color:black; background-color:#FFFFFF; align='center'><input type='text' style='width:110px' name='keterangan_sparepart' value='$rows3[keterangan_sparepart]'></td>";

				echo "
				<input type='hidden' name='departement' value='$departement'/>
				<input type='hidden' name='bagian' value='$bagian'/>
				<input type='hidden' name='id_items' value='$id_items'/>
				<input type='hidden' name='id_sparepart' value='$rows3[id]'/>
				<input type='hidden' name='rincian' value='rincian'/>
				<input type='hidden' size='20%' name='update_sparepart' value='update_sparepart'>
				<td style='padding:3px; background-color:#FFFFFF; color:black; align='center' width='0px' align='center'><input type='submit' style='width:100px align:center' name='submit1' value='Simpan'></td>";
				echo "</form>";

				echo "
				<form action='?menu=home&mod=datait/printer' method='POST'>
				<input type='hidden' name='departement' value='$departement'/>
				<input type='hidden' name='bagian' value='$bagian'/>
				<input type='hidden' name='id_items' value='$id_items'/>
				<input type='hidden' name='id_sparepart' value='$rows3[id]'/>
				<input type='hidden' name='rincian' value='rincian'/>
				<input type='hidden' name='delete_sparepart' value='delete_sparepart'/>
				<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Delete'>
				</tr>
				</form>";
				$n++;}

}//END TAMBAH RINCIAN ITEM

else {
if ($bagian==''){}else {
//PILIHAN TAMBAH ITEM
	echo "
	<form action='?menu=home&mod=datait/printer' method='POST'>
	<input type='hidden' name='departement' value='$departement'/>
	<input type='hidden' name='bagian' value='$bagian'/>
	<input type='hidden' name='tambah_item' value='tambah_item'/>
	<td><input type='submit' style='width:100%;' value='Tambah Item'></td></tr>
	</form></br>";

//TABEL
	echo "
	<body>
	<table width='100%' padding='' border='0' cellspacing='0' cellpadding='0' border-color='black'>
		<tr>
			<td>
				<form name='form1' method='post' action=''>
				<table align='center' width='100%' border='' cellpadding='' cellspacing='' bgcolor='#F0FFFF'>
					<tr>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>No</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Foto Printer</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Komputer Terhubung Printer</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Tanggal Pembelian</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Lokasi Printer</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Status</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>Kondisi</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>---</strong></td>
						<td style='padding: 5px; color:black; background-color: #F0FFFF;' align='center' width='auto' bgcolor='#FFFFFF'><strong>---</strong></td>";

//ISI TABEL
$sql1="SELECT * FROM datait_printer WHERE departement='$departement' AND bagian='$bagian'";
$result1=mysql_query($sql1);
$no=1;
while ($rows1=mysql_fetch_array($result1)){
	echo "<tr>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
	<td style='border:1px solid;' align='center'><img src='modules/datait/file/$rows1[foto_cpu]' width='150' height='150' /><br/></td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nama_komputer]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[tanggal_pembelian]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[pengguna]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[status]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[kondisi]</td>";
	echo "
	<form action='?menu=home&mod=datait/printer' method='POST'>
	<input type='hidden' name='departement' value='$rows1[departement]'/>
	<input type='hidden' name='bagian' value='$rows1[bagian]'/>
	<input type='hidden' name='id_items' value='$rows1[id]'/>
	<input type='hidden' name='rincian' value='rincian'/>
	<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit1' value='Rincian'>
	</form>";
	echo "
	<form action='?menu=home&mod=datait/printer' method='POST'>
	<input type='hidden' name='departement' value='$rows1[departement]'/>
	<input type='hidden' name='bagian' value='$rows1[bagian]'/>
	<input type='hidden' name='foto_cpu' value='$rows1[foto_cpu]'/>
	<input type='hidden' name='delete' value='delete'/>
	<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Delete'>
	</form>";
$no++;}//END ISI TABEL
echo "</table>";
}
}
if ($rincian=='rincian') {
echo "<table></br>
<h2 align='center'>History Printer</h2>
<table class=table width=100% align=center border=1>
<tr style='background-color:#C0C0C0;'>
<th align=center width=1%>No</th>
<th align=center width=7%>Nama Sparepart</th>
<th align=center width=7%>Merek</th>
<th align=center width=7%>Type</th>
<th align=center width=3%>Size</th>
<th align=center width=7%>ID/No Unik Sparepart</th>
<th align=center width=1%>Tanggal Pergantian Sparepart</th>
<th align=center width=7%>Status</th>
<th align=center width=7%>Kondisi</th>
<th align=center width=7%>Keterangan</th>
</tr>";

//ISI TABEL HISTORY
$sql4="SELECT * FROM datait_printer_history WHERE induk='$id_items' ORDER BY id";
$result4=mysql_query($sql4);
$no=1;
while ($rows4=mysql_fetch_array($result4)){
	echo "<tr>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[nama_sparepart]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[merek]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[type]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[size]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[no_unik]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[tanggal_pembelian_sparepart]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[status_sparepart]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[kondisi_sparepart]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows4[keterangan_sparepart]</td>";
$no++;}
echo "
</table>";}
}
?>
