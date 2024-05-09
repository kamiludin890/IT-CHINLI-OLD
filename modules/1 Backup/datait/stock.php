<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row,$id_user, $akses;
	$mod='datait/stock';
function editmenu(){extract($GLOBALS);}

function rupiah($angka){
	$hasil_rupiah = "" . number_format($angka,2,',','.');
	return $hasil_rupiah;
 }

 function kalender(){
 		echo "
 		<link rel='stylesheet' href='modules/tools/kalender_combo/jquery-ui.css'>
 		<link rel='stylesheet' href='/resources/demos/style.css'>
 		<script src='modules/tools/kalender_combo/jquery-1.12.4.js'></script>
 		<script src='modules/tools/kalender_combo/jquery-ui.js'></script>

 		<script>
 		$( function() {
 			$( '.date' ).datepicker({
 				dateFormat: 'yy-mm-dd'
 			});
 		} );
 		</script>
 		</head>
 		<body>";
 		//<label >Date:</label>
 		//<input type='text' id='date'>
 return;}

 function combobox(){
 	echo "
 	 <link href='modules/tools/kalender_combo/select2.min.css' rel='stylesheet' />
 	 <script src='modules/tools/kalender_combo/select2.min.js'></script>

 	<script type='text/javascript'>
 	 $(document).ready(function() {
 	     $('.comboyuk').select2();
 	 });
 	</script>";
 return;}

 function ambil_database($kolom,$database,$where){
 	$sql="SELECT $kolom FROM $database WHERE $where";
 	$result=mysql_query($sql);
 	$rows=mysql_fetch_array($result);
 	return $rows[$kolom];}

function home(){extract($GLOBALS);
include 'style.css';

//ALL POST
$pilihan_halaman=$_POST['pilihan_halaman'];
$id_stock=$_POST['id_stock'];
$kategori=$_POST['kategori'];
$nama_barang=$_POST['nama_barang'];
$satuan=$_POST['satuan'];
$jumlah_sekarang=$_POST['jumlah_sekarang'];
$keterangan=$_POST['keterangan'];
$tanggal_awal_masuk_barang=$_POST['tanggal_awal_masuk_barang'];
$foto=$_POST['foto'];
$delete=$_POST['delete'];
$bulan3=$_POST['bulan'];
$tahun=$_POST['tahun'];
$periode_awal=$_POST['periode_awal'];
$periode_akhir=$_POST['periode_akhir'];

if ($periode_awal=='') {
	$tgl_periode_awal=date('Y-m');
	$periode_awal="$tgl_periode_awal-01";}else{$periode_awal="$periode_awal";}
if ($periode_akhir=='') {
	$tgl_periode_akhir=date('Y-m-d');
	$periode_akhir="$tgl_periode_akhir";}else{$periode_akhir="$periode_akhir";}

//Skrip Tambah Foto
if($_POST['upload']){
	$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
	$nama1 = $_FILES['file']['name'];
	$idtgl=date('Y-m-d h:i:sa');
	$idtgl2 = preg_replace("/[^0-9]/", "", $idtgl);
	$nama="stock$idtgl2$nama1";
	$x = explode('.', $nama);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['file']['size'];
	$file_tmp = $_FILES['file']['tmp_name'];
	if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		if($ukuran < 1044070){
			move_uploaded_file($file_tmp, 'modules/datait/file/'.$nama);
			$query = mysql_query("INSERT INTO datait_stock SET foto='$nama',kategori='$kategori',nama_barang='$nama_barang',satuan='$satuan',jumlah='$jumlah_sekarang',keterangan='$keterangan',tanggal_awal_masuk_barang='$tanggal_awal_masuk_barang'");
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
$target="modules/datait/file/$foto";
unlink($target);//DELETE NOW
$delete_database="DELETE FROM datait_stock WHERE foto='$foto'";
$eksekusi=mysql_query($delete_database);
}
//SAVE
	if($_POST['save']){
		$ekstensi_diperbolehkan	= array('png','jpg');
		$nama1 = $_FILES['file']['name'];
		echo "$nama1";
		$idtgl=date('Y-m-d h:i:sa');
		$idtgl2 = preg_replace("/[^0-9]/", "", $idtgl);
		$nama="stock$idtgl2$nama1";
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];
		if ($nama1){$query_update="foto='$nama',"; move_uploaded_file($file_tmp, 'modules/datait/file/'.$nama);
			$target="modules/datait/file/$foto";
			unlink($target);
		$foto_update="foto='$nama',";}//DELETE NOW
				$query = mysql_query("UPDATE datait_stock SET $foto_update kategori='$kategori',nama_barang='$nama_barang',satuan='$satuan',jumlah='$jumlah_sekarang',keterangan='$keterangan',tanggal_awal_masuk_barang='$tanggal_awal_masuk_barang' WHERE id='$id_stock'");
}


//START Halaman Utama
	if ($pilihan_halaman=='') {
		//JUDUL
		echo "<center><h1>Data Stock Barang IT $periode_awal s/d $periode_akhir </h1></center>";

		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value='lihat_pemasukan_pengeluaran'/>
		<td><input type='submit' style='width:100%;' value='Lihat Pemasukan/Pengeluaran'></td></tr>
		</form></br>";

		//INPUT PEMASUKAN PENGELUARAN
		//masuk_keluar_barang
		echo "
				<form action='?menu=home&mod=datait/stock' method='POST'>
				<input type='hidden' name='pilihan_halaman' value='list_input'/>
				<td><input type='submit' style='width:100%;' value='List Input'></td></tr>
				</form></br>";

//PILIHAN TAMBAH ITEM Baru
		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value='tambah_barang_baru'/>
		<td><input type='submit' style='width:100%;' value='Tambah Barang Baru'></td></tr>
		</form></br>";

		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<tr>
		<td>Periode</td>
		<td>:</td>
		<td><input type='date' style='width:150px' name='periode_awal' value='$periode_awal'></td>
		<td>s/d</td>
		<td><input type='date' style='width:150px' name='periode_akhir' value='$periode_akhir'></td>

		<td><input type='submit' style='width:10%;' value='Cari'></td></tr>
		</form></br>";

	//TABEL
	echo "
	<table class='tabel_utama' width=100% align=center>
	<thead style='background-color:#C0C0C0;'>
	<th align=center width=1%  height=25px>No</th>
	<th align=center width=7%>Foto</th>
	<th align=center width=7%>Kategori</th>
	<th align=center width=7%>Nama Barang</th>
	<th align=center width=7%>Satuan</th>
	<th align=center width=7%>Stock Sebelumnya</th>
	<th align=center width=7%>Masuk</th>
	<th align=center width=7%>Keluar</th>
	<th align=center width=3%>Jumlah</th>
	<th align=center width=7%>Keterangan</th>
	<th align=center width=7%>Tanggal Awal Masuk Barang</th>
	<th align=center width=1%></th>
	<th align=center width=1%></th>
	</thead>";

	//ISI TABEL
	$sql1="SELECT * FROM datait_stock";
	$result1=mysql_query($sql1);
	$no=1;
	while ($rows1=mysql_fetch_array($result1)){

		$query22="SELECT SUM(masuk),SUM(keluar) FROM datait_stock_transaksi WHERE induk='$rows1[id]' AND tanggal < '$periode_awal'";
		$result22=mysql_query($query22);
		$row22=mysql_fetch_array($result22);
		$total_masuk_sebelumnya=rupiah($row22['SUM(masuk)']);
		$total_keluar_sebelumnya=rupiah($row22['SUM(keluar)']);
		$total_sebelumnya=rupiah($total_masuk_sebelumnya-$total_keluar_sebelumnya);

		$query24="SELECT SUM(masuk),SUM(keluar) FROM datait_stock_transaksi WHERE induk='$rows1[id]' AND tanggal BETWEEN '$periode_awal' AND '$periode_akhir'";
		$result24=mysql_query($query24);
		$row24=mysql_fetch_array($result24);
		$total_masuk=rupiah($row24['SUM(masuk)']);
		$total_keluar=rupiah($row24['SUM(keluar)']);
		$total=rupiah($total_sebelumnya+$total_masuk-$total_keluar);

		echo "
		<tr>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
		<td style='border:1px solid;' align='center'><img src='modules/datait/file/$rows1[foto]' width='150' height='150' /><br/></td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[kategori]</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[nama_barang]</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[satuan]</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$total_sebelumnya</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$total_masuk</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$total_keluar</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$total</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[keterangan]</td>
		<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows1[tanggal_awal_masuk_barang]</td>";
		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value='tambah_barang_baru'/>
		<input type='hidden' name='id_stock' value='$rows1[id]'/>
		<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '>
		<input type='image' src='modules/gambar/edit.png' width='30' height'30' name='rincian' value='rincian'>
		</td>
		</form>";

		echo '<form method="POST" action="?menu=home&mod=datait/stock" onsubmit="return confirm(\''."Are you sure to Delete it?".'\');">';
		echo "
		<input type='hidden' name='delete' value='delete'/>
		<input type='hidden' name='foto' value='$rows1[foto]'/>
		<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '>
		<input type='image' src='modules/gambar/delete.png' width='30' height'30' name='hapus' value='hapus'>
		</td>
		</form>
		</tr>";

		$no++;
}//END ISI TABEL
echo "</table>";
}//END Halaman Utama


if ($pilihan_halaman=='tambah_barang_baru') {

	$sql2="SELECT * FROM datait_stock WHERE id='$id_stock'";
	$result2=mysql_query($sql2);
	$rows2=mysql_fetch_array($result2);
	if ($rows2['id']=='') {
		$penentu='upload';
	}else {
		$penentu='save';
	}

	//PILIHAN Kembali
		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value=''/>
		<td><input type='submit' style='width:100%;' value='Kembali'></td></tr>
		</form></br>";
	//END Pilihan Kembali

		echo "<table><form action='?menu=home&mod=datait/stock' method='post' enctype='multipart/form-data'>
					<tr>
					<td>FOTO</td>
					<td>:</td>
					<td><input type='file' name='file'></td>
					<td style='border:1px solid;' align='center'><img src='modules/datait/file/$rows2[foto]' width='200' height='300' /><br/></td>
					</tr>

					<tr>
					 <td>KATEGORI</td>
					 <td>:</td>
					 <td><select name='kategori' style='width:254px'>
					<option value='$rows2[kategori]'>".$rows2[kategori]."</option>
					 <option value='Komputer'>Komputer</option>
					 <option value='Printer'>Printer</option>
					 <option value='Cctv'>Cctv</option>
					 <option value='Lainnya'>Lainnya</option>
					</tr>

					<tr>
					<td>NAMA BARANG</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='nama_barang' value='$rows2[nama_barang]'></td>
					</tr>

					<tr>
					<td>SATUAN</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='satuan' value='$rows2[satuan]'></td>
					</tr>

					<tr>
					<td>JUMLAH SEKARANG</td>
					<td>:</td>
					<td>$rows2[jumlah]</td>
					</tr>

					<tr>
					<td>KETERANGAN</td>
					<td>:</td>
					<td><input type='text' style='width:250px' name='keterangan' value='$rows2[keterangan]'></td>
					</tr>

					<tr>
					<td>TGL AWAL MASUK BARANG</td>
					<td>:</td>
					<td><input type='date' style='width:250px' name='tanggal_awal_masuk_barang' value='$rows2[tanggal_awal_masuk_barang]'></td>
					</tr>

					<tr>
					<input type='hidden' name='$penentu' value='$penentu'>
					<input type='hidden' name='id_stock' value='$rows2[id]'>
					<input type='hidden' name='foto' value='$rows2[foto]'>
					<td><input type='submit' name='simpan' value='Simpan'>
					</form>
					</tr></table></br></br>";

//KELUAR MASUK BARANG
					echo "
					<table class=table width=100% align=center border=1>
					<tr style='background-color:#C0C0C0;'>
					<th align=center width=1%>No</th>
					<th align=center width=7%>Tanggal</th>
					<th align=center width=7%>Dari/Untuk</th>
					<th align=center width=7%>Bukti</th>
					<th align=center width=7%>Masuk</th>
					<th align=center width=7%>Keluar</th>
					</tr>";

					//ISI TABEL
					$sql3="SELECT * FROM datait_stock_transaksi WHERE induk='$id_stock'";
					$result3=mysql_query($sql3);
					$no=1;
					while ($rows3=mysql_fetch_array($result3)){

					if ($rows3['masuk']>0) {$color_masuk="#7FFFD4";$color_keluar="";$color="#7FFFD4";}
					if ($rows3['keluar']>0) {$color_masuk="";$color_keluar="#FFA07A";$color="#FFA07A";}

				  echo "
				  <tr>
				  <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
				  <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[tanggal]</td>
				  <td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[dari_untuk]</td>
				  <td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[bukti]</td>
				  <td style='background-color:$color_masuk; padding-left:5px; padding-right:5px; text-align:right;'>$rows3[masuk]</td>
				  <td style='background-color:$color_keluar; padding-left:5px; padding-right:5px; text-align:right;'>$rows3[keluar]</td>";
					$no++;}

					$query23="SELECT SUM(masuk),SUM(keluar) FROM datait_stock_transaksi WHERE induk='$id_stock'";
					$result23=mysql_query($query23);
					$row23=mysql_fetch_array($result23);

					$total_masuk=rupiah($row23['SUM(masuk)']);
					$total_keluar=rupiah($row23['SUM(keluar)']);
					$total=rupiah($total_masuk-$total_keluar);

					echo "
					<tr>
					<th colspan=4 align=center>Jumlah</th>
					<th align=right>$total_masuk</th>
					<th align=right>$total_keluar</th>
					</tr>";

					echo "
					<tr>
					<th colspan=4 align=center>Total</th>
					<th colspan=2 align=center>$total	</th>
					</tr>
					</table>";
}

//LIHAT PEMASUKAN DAN PENGELUARAN
if ($pilihan_halaman=='lihat_pemasukan_pengeluaran') {

	if ($bulan3=='') {
		$bulan4=date('m');
	}
	if($bulan4=='01'){$bulan2='Januari';} else {}
	if($bulan4=='02'){$bulan2='Februari';} else {}
	if($bulan4=='03'){$bulan2='Maret';} else {}
	if($bulan4=='04'){$bulan2='April';} else {}
	if($bulan4=='05'){$bulan2='Mei';} else {}
	if($bulan4=='06'){$bulan2='Juni';} else {}
	if($bulan4=='07'){$bulan2='Juli';} else {}
	if($bulan4=='08'){$bulan2='Agustus';} else {}
	if($bulan4=='09'){$bulan2='September';} else {}
	if($bulan4=='10'){$bulan2='Oktober';} else {}
	if($bulan4=='11'){$bulan2='November';} else {}
	if($bulan4=='12'){$bulan2='Desember';} else {}

	//START PILIHAN TANGGAL
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

	//JUDUL
	echo "<center><h1>Data Stock Barang IT $bulan2 $tahun</h1></center>";

		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value='lihat_pemasukan_pengeluaran'>
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
		if ($tahun) {
			$mulai= $tahun - 50; $tahun_1="$tahun";
		}else{
			$mulai= date('Y') - 50; $tahun_1=date('Y');
		}
		for($i = $mulai;$i<$mulai + 100;$i++){
				$sel = $i == $tahun_1 ? ' selected="selected"' : '';
				echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
		}
		?>
		<input type="submit" value="Cari">
		</form>
		</select>
		</br>
	<?php //END PILIHAN TANGGAL ?><?php

	//PILIHAN Kembali
		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value=''/>
		<td><input type='submit' style='width:10%;' value='Kembali'></td></tr>
		</form></br>";
	//END Pilihan Kembali

	echo "
	<table class='tabel_utama' width=100% align=center>
	<thead style='background-color:#C0C0C0;'>
	<th align=center width=1%>No</th>
	<th align=center width=7%>Nama Barang</th>
	<th align=center width=7%>Tanggal</th>
	<th align=center width=7%>Dari/Untuk</th>
	<th align=center width=7%>Bukti</th>
	<th align=center width=7%>Masuk</th>
	<th align=center width=7%>Keluar</th>
	</thead>";

	if ($bulan3) {
		$periode="$tahun-$bulan3";
	}else{
		$periode="$tahun-";
	}
	if ($periode=='-') {
		$periode=date('Y-m');
	}


	//ISI TABEL
	$sql3="SELECT * FROM datait_stock_transaksi WHERE tanggal LIKE '%$periode%' ORDER BY tanggal";
	$result3=mysql_query($sql3);
	$no=1;
	while ($rows3=mysql_fetch_array($result3)){

	if ($rows3['masuk']>0) {$color_masuk="#7FFFD4";$color_keluar="";$color="#7FFFD4";}
	if ($rows3['keluar']>0) {$color_masuk="";$color_keluar="#FFA07A";$color="#FFA07A";}

	echo "
	<tr>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[nama_barang]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[tanggal]</td>
	<td style='background-color:$color; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[dari_untuk]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows3[bukti]</td>
	<td style='background-color:$color_masuk; padding-left:5px; padding-right:5px; text-align:right;'>$rows3[masuk]</td>
	<td style='background-color:$color_keluar; padding-left:5px; padding-right:5px; text-align:right;'>$rows3[keluar]</td>";
	$no++;}

	$query23="SELECT SUM(masuk),SUM(keluar) FROM datait_stock_transaksi WHERE tanggal LIKE '%$periode%'";
	$result23=mysql_query($query23);
	$row23=mysql_fetch_array($result23);
	$total_masuk=rupiah($row23['SUM(masuk)']);
	$total_keluar=rupiah($row23['SUM(keluar)']);
	$total=rupiah($total_masuk-$total_keluar);

	echo "
	<tr>
	<th colspan=5 align=center>Jumlah</th>
	<th align=right>$total_masuk</th>
	<th align=right>$total_keluar</th>
	</tr>";

	echo "
	<tr>
	<th colspan=5 align=center>Total</th>
	<th colspan=2 align=center>$total	</th>
	</tr>
	</table>";

}//END lihat_pemasukan_pengeluaran

//START INPUT MASUK KELUAR BARANG
if ($pilihan_halaman=='masuk_keluar_barang') {

	$masuk_keluar_bukti=$_POST['masuk_keluar_bukti'];
	$masuk_keluar_tanggal=$_POST['masuk_keluar_tanggal'];
	$masuk_keluar_pengirim_penerima=$_POST['masuk_keluar_pengirim_penerima'];
	$input_masuk_keluar=$_POST['input_masuk_keluar'];
	$unik=$_POST['unik'];

$ijin_insert=ambil_database(unik,datait_stock_header,"unik='$unik'");
if ($input_masuk_keluar=='Simpan' AND $ijin_insert=='') {
	$insert="INSERT INTO datait_stock_header SET unik='$unik',masuk_keluar_bukti='$masuk_keluar_bukti',masuk_keluar_tanggal='$masuk_keluar_tanggal',masuk_keluar_pengirim_penerima='$masuk_keluar_pengirim_penerima'";
	$eksekusi_insert=mysql_query($insert);
}

$sql4="SELECT * FROM datait_stock_header WHERE unik='$unik'";
$result4=mysql_query($sql4);
$rows4=mysql_fetch_array($result4);

$idtgl=date('Y-m-d h:i:sa');
$idtgl2 = preg_replace("/[^0-9]/", "", $idtgl);
$unik1="unik$idtgl2$nama1";
	//PILIHAN Kembali
		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value='list_input'/>
		<td><input type='submit' style='width:10%;' value='Kembali'></td></tr>
		</form></br>";
	if ($rows4['unik']) {$disabled='disabled';}
	echo "<table><form action='?menu=home&mod=datait/stock' method='POST'>
				<tr>
				<td>BUKTI</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='masuk_keluar_bukti' value='$rows4[masuk_keluar_bukti]' $disabled></td>
				</tr>

				<tr>
				<td>TANGGAL</td>
				<td>:</td>
				<td><input type='date' style='width:250px' name='masuk_keluar_tanggal' value='$rows4[masuk_keluar_tanggal]' $disabled></td>
				</tr>

				<tr>
				<td>PENGIRIM/PENERIMA</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='masuk_keluar_pengirim_penerima' value='$rows4[masuk_keluar_pengirim_penerima]' $disabled></td>
				</tr>

				<tr>
				<input type='hidden' name='pilihan_halaman' value='masuk_keluar_barang'>
				<input type='hidden' name='unik' value='$unik1'>
				<td><input type='submit' name='input_masuk_keluar' value='Simpan' $disabled>
				</form>
				</tr></table></br></br>";


	if ($rows4['unik']) {

	$pilih_barang=$_POST['pilih_barang'];
	$tanggal=$_POST['tanggal'];
	$tambah=$_POST['tambah'];
	$dari_untuk=$_POST['dari_untuk'];
	$bukti=$_POST['bukti'];
	$masuk=$_POST['masuk'];
	$keluar=$_POST['keluar'];
	$id_transaksi=$_POST['id_transaksi'];
	if ($tambah) {
		$sql6="SELECT * FROM datait_stock WHERE id='$pilih_barang'";
		$result6=mysql_query($sql6);
		$rows6=mysql_fetch_array($result6);
		$insert="INSERT INTO datait_stock_transaksi SET unik='$unik',induk='$pilih_barang',nama_barang='$rows6[nama_barang]',tanggal='$tanggal',dari_untuk='$dari_untuk',bukti='$bukti'";
		$eksekusi_insert=mysql_query($insert);}

if($_POST['update_transaksi']){
	$insert="UPDATE datait_stock_transaksi SET masuk='$masuk',keluar='$keluar' WHERE unik='$unik' AND id='$id_transaksi'";
	$eksekusi_insert=mysql_query($insert);
}

if ($_POST['delete_transaksi']) {
	$insert="DELETE FROM datait_stock_transaksi WHERE unik='$unik' AND id='$id_transaksi'";
	$eksekusi_insert=mysql_query($insert);
}

echo kalender();
echo combobox();

				echo "<table><form action='?menu=home&mod=datait/stock' method='post' enctype='multipart/form-data'>
				      <tr>
				       <td>PILIH BARANG</td>
				       <td>:</td>
				       <td><select class='comboyuk' name='pilih_barang' style='width:254px'>";

							 $sql5="SELECT * FROM datait_stock";
							 $result5=mysql_query($sql5);
							 while ($rows5=mysql_fetch_array($result5)){
							 echo "
							 <option value='$rows5[id]'>".$rows5[nama_barang]."</option>";}

							 echo "
				      </tr>
				      <tr>
							<input type='hidden' name='nama_barang' value='$rows5[nama_barang]'>
							<input type='hidden' name='tanggal' value='$rows4[masuk_keluar_tanggal]'>
							<input type='hidden' name='dari_untuk' value='$rows4[masuk_keluar_pengirim_penerima]'>
							<input type='hidden' name='bukti' value='$rows4[masuk_keluar_bukti]'>
							<input type='hidden' name='unik' value='$rows4[unik]'>
							<input type='hidden' name='pilihan_halaman' value='masuk_keluar_barang'>
							<input type='hidden' name='tambah' value='tambah'>
				      <td><input type='submit' name='tambah' value='tambah'>
				      </form>
				      </tr></table></br></br>";

		echo "
		<table class='tabel_utama' width=100% align=center>
		<tr style='background-color:#C0C0C0;'>
		<th align=center width=1%>No</th>
		<th align=center width=7%>Nama Barang</th>
		<th align=center width=7%>Tanggal</th>
		<th align=center width=7%>Pengirim Penerima</th>
		<th align=center width=3%>Bukti</th>
		<th align=center width=7%>Masuk</th>
		<th align=center width=7%>Keluar</th>
		<th align=center width=1%>---</th>
		<th align=center width=1%>---</th>
		</tr>";

		$sql7="SELECT * FROM datait_stock_transaksi WHERE unik='$unik' ORDER BY id";
		$result7=mysql_query($sql7);
		$n=1;
		while ($rows7=mysql_fetch_array($result7)) {
		echo "<form action='?menu=home&mod=datait/stock' method='POST'>
		<tr>
		<td style='padding: 5px; color:black; align='center' align='center' width='10px' bgcolor='#FFFFFF'><strong>$n</strong></td>
		<td style='padding: 3px; color:black; align='center' align='center' width='10px' bgcolor='#FFFFFF'>$rows7[nama_barang]</td>
		<td style='padding: 3px; color:black; align='center' align='center' width='10px' bgcolor='#FFFFFF'>$rows7[tanggal]</td>
		<td style='padding: 3px; color:black; align='center' align='center' width='10px' bgcolor='#FFFFFF'>$rows7[dari_untuk]</td>
		<td style='padding: 3px; color:black; align='center' align='center' width='10px' bgcolor='#FFFFFF'>$rows7[bukti]</td>
		<td style='padding: 3px; color:black; align='right'><input type='text' style='width:80px' name='masuk' value='$rows7[masuk]'></td>
		<td style='padding: 3px; color:black; align='right'><input type='text' style='width:80px' name='keluar' value='$rows7[keluar]'></td>";

		echo "
		<input type='hidden' name='unik' value='$rows7[unik]'/>
		<input type='hidden' name='id_transaksi' value='$rows7[id]'/>
		<input type='hidden' name='update_transaksi' value='update_transaksi'/>
		<input type='hidden' size='20%' name='pilihan_halaman' value='masuk_keluar_barang'>
		<td style='padding:3px; background-color:#FFFFFF; color:black; align='center' width='0px' align='center'>
		<input type='image' src='modules/gambar/save.png' width='30' height'30' name='simpan' value='simpan'>";
		echo "</form>";

		echo '<form method="POST" action="?menu=home&mod=datait/stock" onsubmit="return confirm(\''."Are you sure to Delete it?".'\');">';
		echo "
		<input type='hidden' name='unik' value='$rows7[unik]'/>
		<input type='hidden' name='id_transaksi' value='$rows7[id]'/>
		<input type='hidden' name='delete_transaksi' value='delete_transaksi'/>
		<input type='hidden' size='20%' name='pilihan_halaman' value='masuk_keluar_barang'>
		<td style='font-weight:bold; background-color:#FFFFFF; text-align:center;'>
		<input type='image' src='modules/gambar/delete.png' width='30' height'30' name='hapus' value='hapus'>
		</tr>
		</form>";
		$n++;}

	}
}//END START INPUT MASUK KELUAR BARANG

//START LIST INPUT
if ($pilihan_halaman=='list_input') {
	$pencarian=$_POST['pencarian'];
	$unik_delete=$_POST['unik'];
	if ($_POST['delete_seluruh_transaksi']) {
		$insert="DELETE FROM datait_stock_header WHERE unik='$unik_delete'";
		$eksekusi_insert=mysql_query($insert);
		$insert2="DELETE FROM datait_stock_transaksi WHERE unik='$unik_delete'";
		$eksekusi_insert2=mysql_query($insert2);
	}

	//PILIHAN Kembali
		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value=''/>
		<td><input type='submit' style='width:100%;' value='Kembali'></td></tr>
		</form></br>";

	//PILIHAN Kembali
		echo "
		<form action='?menu=home&mod=datait/stock' method='POST'>
		<input type='hidden' name='pilihan_halaman' value='masuk_keluar_barang'/>
		<td><input type='submit' style='width:100%;' value='Input Pemasukan/Pengeluaran'></td></tr>
		</form></br>";

		//Pencarian
			echo "
			<form action='?menu=home&mod=datait/stock' method='POST'>
			<tr>
				<td>Pencarian</td>
				<td>:</td>
				<td><input type='text' style='width:250px' name='pencarian' value='$pencarian'></td>

			<input type='hidden' name='pilihan_halaman' value='list_input'/>
			<td><input type='submit' style='width:5%;' value='Cari'></td></tr>
			</form></br>";



	echo "
	<table class='tabel_utama' width=100% align=center>
	<thead style='background-color:#C0C0C0;'>
	<th align=center width=1%>No</th>
	<th align=center width=7%>Pengirim/Penerima</th>
	<th align=center width=7%>Bukti</th>
	<th align=center width=7%>Tanggal</th>
	<th align=center width=1%>---</th>
	<th align=center width=1%>---</th>
	</thead>";

$sql8="SELECT * FROM datait_stock_header WHERE masuk_keluar_bukti LIKE '%$pencarian%' OR masuk_keluar_tanggal LIKE '%$pencarian%' OR masuk_keluar_pengirim_penerima LIKE '%$pencarian%' ORDER BY masuk_keluar_tanggal";
$result8=mysql_query($sql8);
$no=1;
while ($rows8=mysql_fetch_array($result8)){
	echo "
	<tr>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$no</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows8[masuk_keluar_pengirim_penerima]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows8[masuk_keluar_bukti]</td>
	<td style='background-color:#FFFFFF; padding-left:5px; padding-right:5px; text-align:center;'>$rows8[masuk_keluar_tanggal]</td>";
	echo "
	<form action='?menu=home&mod=datait/stock' method='POST'>
	<input type='hidden' name='pilihan_halaman' value='masuk_keluar_barang'/>
	<input type='hidden' name='unik' value='$rows8[unik]'/>
	<td style='font-weight:bold; background-color:#FFFFFF; text-align:center;'>
	<input type='image' src='modules/gambar/edit.png' width='30' height'30' name='rincian' value='rincian'>
	</td>
	</form>";
	echo '<form method="POST" action="?menu=home&mod=datait/stock" onsubmit="return confirm(\''."Are you sure to Delete it?".'\');">';
	echo "
	<input type='hidden' name='pilihan_halaman' value='list_input'/>
	<input type='hidden' name='unik' value='$rows8[unik]'/>
	<input type='hidden' name='delete_seluruh_transaksi' value='delete_seluruh_transaksi'/>
	<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '>
	<input type='image' src='modules/gambar/delete.png' width='30' height'30' name='hapus' value='hapus'>
	</td>
	</form>
	</tr>";
$no++;}
}//END LIST INPUT

}
?>
