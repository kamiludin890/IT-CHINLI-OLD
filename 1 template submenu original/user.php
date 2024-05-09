<?php

//CHECK AKSES
$id_hal=ambil_database(id,master_menu,"url='$hal'");
if (check_akses($id_hal)==0) {header( "Location:logout.php");}
//CHECK AKSES END

//MASTER START
include ('../../function_home.php');
include ('function.php');

$column_header='nama,alamat,telpon,username,password,akses,status,pembuat,tgl_dibuat';
$column_input='nama,alamat,telpon,username,password,akses,status,pembuat,tgl_dibuat';
$column_print='nama,alamat,telpon,username,password,akses,status,pembuat,tgl_dibuat';

$pecah_column_header=pecah($column_header);
$nilai_pecah_column_header=nilai_pecah($column_header);

$pecah_column_input=pecah($column_input);
$nilai_pecah_column_input=nilai_pecah($column_input);

$nama_database='master_user';
$nama_database_items='';

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
//TAMPILAN ITEM

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
echo "</tr></table>";
//KEMBALI END


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
