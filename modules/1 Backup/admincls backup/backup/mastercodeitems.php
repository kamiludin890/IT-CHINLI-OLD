<?php global $mod;
	$mod='admincls/mastercodeitems';
function editmenu(){extract($GLOBALS);}

function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,kode_barang,model,material_description_po,warna,size,pembuat,tgl_dibuat,ket_revisi,tgl_revisi';
$column='ket_revisi,tanggal,kode_barang,model,material_description_po,warna,size,pembuat,tgl_dibuat';
$nama_database='sales_mastercodeitems';
//$nama_database_items='sales_po_items';
$address='?mod=sales/mastercodeitems';

//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA

}//END HOME
//END PHP?>
