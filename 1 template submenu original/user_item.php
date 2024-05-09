<?php

//CHECK AKSES
$id_hal=ambil_database(id,master_menu,"url='$hal'");
if (check_akses($id_hal)==0) {header( "Location:logout.php");}
//CHECK AKSES END

//MASTER START
include ('../../function_home.php');
include ('function.php');

$column_header='tanggal,foto,bagian,departement,subjek,nama_pemohon,status_permohonan,pembuat,tgl_dibuat';
$column_input='tanggal,foto,bagian,departement,subjek,nama_pemohon,status_permohonan,pembuat,tgl_dibuat';
$column_print='tanggal,foto,bagian,departement,subjek,nama_pemohon,status_permohonan,pembuat,tgl_dibuat';

$pecah_column_header=pecah($column_header);
$nilai_pecah_column_header=nilai_pecah($column_header);

$pecah_column_input=pecah($column_input);
$nilai_pecah_column_input=nilai_pecah($column_input);

$nama_database='management_purchasing_permohonan';
$nama_database_items='management_purchasing_permohonan_items';

$pilihan_bulan_tahun=0;//Jika pakai Pilihan Bulan dan Tahun nilai=1, jika tidak nilai=0
//MASTER END

//NILAI POST & GET
$pilihan_bulan=$_POST['pilihan_bulan'];//BULAN
$pilihan_tahun=$_POST['pilihan_tahun'];//TAHUN
$pencarian=$_POST['pencarian'];//Pencarian
$pilihan_pencarian=$_POST['pilihan_pencarian'];//Pilihan Pencarian
$nomor_halaman=$_POST['halaman'];//NOMOR HALAMAN

$item=$_POST['item'];
$tambah=$_POST['tambah'];
$edit=$_POST['edit'];
//NILAI POST & GET END


if ($item!='') {
include 'style.css';
echo kalender();
echo combobox();
//TAMPILAN ITEM


//ARRAY JUDUL
$column='nama,satuan,jumlah,keterangan';
$pecah=pecah($column);
$nilai=nilai_pecah($column);


//INSERT
if ($_POST['insert']==1) {
	$no=0;for($i=0; $i < $nilai; ++$i){
	//FOTO
	if($pecah[$no]==foto){
				$nama_file = $_FILES['gambar']['name'];
				$ukuran_file = $_FILES['gambar']['size'];
				$tipe_file = $_FILES['gambar']['type'];
				$tmp_file = $_FILES['gambar']['tmp_name'];
				$nama_gambar=upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file);
				$gambar_sebelumnya=ambil_database(foto,$nama_database,"id='$id'");
			if ($nama_gambar==''){
				$isi_kolom=$gambar_sebelumnya;
			}else{
				$target="modules/management_purchasing/foto/$gambar_sebelumnya";
				if (file_exists($target)){unlink($target);}
				$isi_kolom=$nama_gambar;
			}
	}
	//ISI KOLOM SEBENARNYA
	else{
		$isi_kolom=$_POST[$pecah[$no]];
	}
	$datasecs[]=$pecah[$no]."='".$isi_kolom."'";
$no++;}
$tgl_dibuat=date('Y-m-d H:i:s');
$data=implode(",", $datasecs);
mysql_query("INSERT INTO $nama_database_items SET $data,induk='$item',tgl_dibuat='$tgl_dibuat'");
}// END INSERT

//UPDATE
if ($_POST['update']==1) {
	$no=0;for($i=0; $i < $nilai; ++$i){
	//FOTO
	if($pecah[$no]==foto){
				$nama_file = $_FILES['gambar']['name'];
				$ukuran_file = $_FILES['gambar']['size'];
				$tipe_file = $_FILES['gambar']['type'];
				$tmp_file = $_FILES['gambar']['tmp_name'];
				$nama_gambar=upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file);
				$gambar_sebelumnya=ambil_database(foto,$nama_database_items,"id='$_POST[id_update]'");
			if ($nama_gambar==''){
				$isi_kolom=$gambar_sebelumnya;
			}else{
				$target="modules/management_purchasing/foto/$gambar_sebelumnya";
				if (file_exists($target)){unlink($target);}
				$isi_kolom=$nama_gambar;
			}
	}
	//ISI KOLOM SEBENARNYA
	else{
		$isi_kolom=$_POST[$pecah[$no]];
	}
	$datasecs[]=$pecah[$no]."='".$isi_kolom."'";
$no++;}
$tgl_dibuat=date('Y-m-d H:i:s');
$data=implode(",", $datasecs);
mysql_query("UPDATE $nama_database_items SET $data,tgl_dibuat='$tgl_dibuat' WHERE id='$_POST[id_update]'");
}// END UPDATE

//HAPUS FOTO
if ($_POST['delete_item']) {
		$id_item=$_POST['delete_item'];

		$foto=ambil_database(foto,$nama_database_items,"id='$id_item'");
		$target="modules/management_purchasing/foto/$foto";
		if ($foto){
			if (file_exists($target)){unlink($target);}else{}
		}else{}

		$string_delete_items="DELETE FROM $nama_database_items WHERE id='$id_item'";
		$ekskusi2=mysql_query($string_delete_items);
}//END HAPUS


//KEMBALI
echo "<table><tr>";
echo "<form method ='post' action=''>";
echo "<td><input type='image' src='themes/sub_menu/back.png' width='25' height'25' name='kembali' value='kembali'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='item' value=''></td></form>";
//echo "</tr></table>";
//KEMBALI END

//Tambah
//echo "<table><tr>";
echo "<form method ='post' action=''>";
echo "<td><input type='image' src='themes/sub_menu/tambah.png' width='25' height'25' name='kembali' value='kembali'>";
echo input_hidden_default($pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$nomor_halaman);
echo "<input type='hidden' name='item' value='$item'>
			<input type='hidden' name='tambah_item' value='1'></td></form>";
echo "</tr></table>";
//Tambah END


//FORM INPUT
//tampilan tambah item
if ($_POST['tambah_item']==1 OR $_POST['edit_item']!='') {

	if ($_POST[edit_item]=='') {$insert_or_update='insert';}else{$insert_or_update='update';}

	$result1=mysql_query("SELECT * FROM $nama_database_items WHERE id='$_POST[edit_item]'");
	$rows1=mysql_fetch_array($result1);

	//TABEL ISI / EDIT
	echo "<form method ='post' enctype='multipart/form-data'>";
			echo "<table class='kolom_isi' style=''>";
			$no=0;for($i=0; $i < $nilai; ++$i){
				echo "<tr>";
				//HEADER
				echo "<td id='kolom_isi_th'><strong>".b($pecah[$no])."</strong></td>";
				//HEADER END

				//PENENTU KOLOM DISABLED DAN TANGGAL
				if ($pecah[$no] == 'tanggal'){$format_tgl="class='date'";}else{$format_tgl="";}
				//PENENTU KOLOM DISABLED DAN TANGGAL END

				//KATEGORI
				if ($pecah[$no]=='kategori'){
					echo "<td>";
					echo "<select name='$pecah[$no]' class='comboyuk' required>";
								echo "<option value='".$rows1[$pecah[$no]]."'>".$rows1[$pecah[$no]]."</option>";
							$no_kategori=0;for($i_kategori=0; $i_kategori < $nilai_kategori; ++$i_kategori){
								echo "<option value='".b($pecah_kategori[$no_kategori])."'>".b($pecah_kategori[$no_kategori])."</option>";
							$no_kategori++;}
					echo "</select>";
					echo "</td>";
				}
				//FOTO
				elseif($pecah[$no]=='foto') {
					echo "<td>
					<input type='file' name='gambar'>
					<input type='hidden' name='foto'>
					<input type='hidden' name='gambar_sebelumnya' value='".$rows1[$pecah[$no]]."'>
					</td>";
				}
				//KETERANGAN
				elseif ($pecah[$no]=='keterangan') {
					echo "<td><textarea name='$pecah[$no]' rows='3' cols='30'>".$rows1[$pecah[$no]]."</textarea></td>";
				}
				//TAMPILAN SEBENARNYA
				else{
				//KOLOM ISI
				echo "<td><input type='text' $format_tgl name='$pecah[$no]' value='".$rows1[$pecah[$no]]."' style='width:95%; border-radius:4px; text-align:center;' autocomplete='off' required></td>";
				//KOLOM ISI END
				}

				echo "</tr>";
			$no++;}

		echo "</table><table style='margin-bottom:25px;'>";
		echo "<tr><td><input type='image' src='themes/sub_menu/save.png' width='25' height'25' name='simpan' value='Simpan'>";
		echo input_hidden_default($pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$nomor_halaman);
		echo "<input type='hidden' name='$insert_or_update' value='1'>
					<input type='hidden' name='id_update' value='$_POST[edit_item]'>
					<input type='hidden' name='item' value='$item'></td></form>";

		echo "<form method ='post'>";
		echo "<td><input type='image' src='themes/sub_menu/back.png' width='25' height'25' name='kembali' value='kembali'>";
		echo input_hidden_default($pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$nomor_halaman);
		echo "<input type='hidden' name='item' value='$item'></td></tr></form>";
		echo "</tr>";
		echo "</table>";
}//tampilan tambah item END
//FORM INPUT END



//JUDUl
echo "<table class='tabel_utama' style='margin-bottom:50px;'>";
echo "<thead>";
	echo "<th>No</th>";
$no=0;for($i=0; $i < $nilai; ++$i){
	echo "<th>".b($pecah[$no])."</th>";
$no++;}
	echo "<th>Tgl DIbuat</th>";
	echo "<th colspan='2'>Opsi</th>";
echo "<thead>";

//Isi Tabel
$result=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$item' ORDER BY id");
$urut=1;
while ($rows=mysql_fetch_array($result)) {
	echo "<tr>";
		echo "<td>$urut</td>";
	$no=0;for($i=0; $i < $nilai; ++$i){

	//TAMPILAN KETERANGAN
	if ($pecah[$no]=='keterangan') {
		echo "<td><textarea style='font-size:10px; width:100%; height:100px;' disabled>".$rows[$pecah[$no]]."</textarea></td>";
	}
	//Foto
	elseif ($pecah[$no]=='foto') {
		echo "<td style='width:100px;'>";
			echo '<a href="#" onClick="window.open(\''."modules/management_purchasing/foto/tampil_foto.php?gambar=".$rows[$pecah[$no]]."".'\', \''.'mywindow'.'\', \''.'status=1,toolbar=1'.'\')">'."<img src='modules/management_purchasing/foto/".$rows[$pecah[$no]]."' width='auto' height='auto'/>".'</a>';
		echo "</td>";
	}
	//TAMPILAN SEBENARNYA
	else {
		echo "<td>".$rows[$pecah[$no]]."</td>";
	}
	$no++;}

	//TGL DIbuat
	echo "<td>$rows[tgl_dibuat]</td>";

	//TOMBOL EDIT
	echo '<form method="POST" action="" onsubmit="return confirm(\''."Edit it?".'\');">';
	echo "<td><input type='image' src='themes/sub_menu/edit.png' width='25' height'25' name='kembali' value='kembali'>";
	echo input_hidden_default($pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$nomor_halaman);
	echo "<input type='hidden' name='item' value='$item'>";
	echo "<input type='hidden' name='edit_item' value='$rows[id]'></td></form>";

	//TOMBOL HAPUS
	echo '<form method="POST" action="" onsubmit="return confirm(\''."Delete it?".'\');">';
	echo "<td><input type='image' src='themes/sub_menu/delete.png' width='25' height'25' name='kembali' value='kembali'>";
	echo input_hidden_default($pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$nomor_halaman);
	echo "<input type='hidden' name='item' value='$item'>";
	echo "<input type='hidden' name='delete_item' value='$rows[id]'></td></form>";

	echo "</tr>";
$urut++;}
echo "</table>";







//TAMPILAN ITEM END
}elseif($tambah=='tambah' OR $edit!=''){
//TAMPILAN TAMBAH
  echo tampilan_tambah_edit($edit,$nama_database,$pecah_column_input,$nilai_pecah_column_input,$nomor_halaman,$pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian);
//TAMPILAN TAMBAH END
}else{
//TAMPILAN AWAL
  //echo pilihan_bulan_tahun($pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$pecah_column_header,$nilai_pecah_column_header);
  echo tabel($nama_database,$nama_database_items,$pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$pecah_column_header,$nilai_pecah_column_header,$nomor_halaman,$pilihan_bulan_tahun,$id_hal,$pecah_column_input,$nilai_pecah_column_input,$column_print);
//TAMPILAN AWAL END
}

?>
