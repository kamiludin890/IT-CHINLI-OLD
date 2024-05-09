<?php global $mod;
	$mod='akuntansiv3/output';
function editmenu(){extract($GLOBALS);}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function upload_item(){
	//PROSES IMPORT START
		include 'modules/deliverycl/download/excel_reader.php';
		// upload file xls
		$target = basename($_FILES['pelengkap']['name']) ;
		move_uploaded_file($_FILES['pelengkap']['tmp_name'], $target);
		// beri permisi agar file xls dapat di baca
		chmod($_FILES['pelengkap']['name'],0777);
		// mengambil isi file xls
		$data = new Spreadsheet_Excel_Reader($_FILES['pelengkap']['name'],false);
		// menghitung jumlah baris data yang ada
		$jumlah_baris = $data->rowcount($sheet_index=0);
		// jumlah default data yang berhasil di import

		$induk=$_POST['id'];
		//hapus data sebelum IMPORT
		mysql_query("DELETE FROM deliverycl_invoice_items WHERE induk='$induk'");

		$berhasil = 0;
		for ($i=2; $i<=$jumlah_baris; $i++){
			// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
			$qty=$data->val($i, 1);//
			$item_name=$data->val($i, 2);//
			$bucket=$data->val($i, 3);//
			$material_code_customer=$data->val($i, 4);//
			$material_code=$data->val($i, 5);//
			$po=$data->val($i, 6);//
			$surat_jalan=$data->val($i, 7);//
			$jenis_mata_uang=$data->val($i, 8);//
			$price=$data->val($i, 9);//
			$amount=$price*$qty;

			$update_1="INSERT INTO deliverycl_invoice_items SET induk='$induk',qty='$qty',item_name='$item_name',bucket='$bucket',material_code_customer='$material_code_customer',material_code='$material_code',po='$po',surat_jalan='$surat_jalan',jenis_mata_uang='$jenis_mata_uang',price='$price',amount='$amount'";
			$eksekusi_update_1=mysql_query($update_1);
		}

		// hapus kembali file .xls yang di upload tadi
		unlink($_FILES['pelengkap']['name']);
return ;}



function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,no_invoice,perusahaan,alamat,tanggal_tutup_buku,po_nomor,paymen_term,kode_jenis_transaksi,fg_pengganti,nomor_faktur,masa_pajak,tahun_pajak,tanggal_faktur,user_upload,pembuat,tgl_dibuat,ket_revisi,tgl_revisi,status';
$column='ket_revisi,tanggal,no_invoice,ppn_10,discount,kode_jenis_transaksi,fg_pengganti,nomor_faktur,masa_pajak,tahun_pajak,tanggal_faktur,pembuat,tgl_dibuat';

$nama_database='deliverycl_invoice';
$nama_database_items='deliverycl_invoice_items';

$periode1=$_POST[periode1];
$periode2=$_POST[periode2];

$address='?mod=akuntansiv3/output';


echo kalender();
echo combobox();


//PILIHAN PERIODE
	echo "<table>";
		echo "<tr>";
			echo "<form method='POST'>";

				echo "<td>Periode : </td>";
					echo "<td><input type='text' class='date' name='periode1' value='$periode1'></td>";
				echo "<td> s/d </td>";
					echo "<td><input type='text' class='date' name='periode2' value='$periode2'></td>";
				echo "<td><input type='submit' name='show' value='Tampil'></td>";

			echo "</form>";
		echo "</tr>";
	echo "</table>";
//PILIHAN PERIODE END



if ($periode1!='' AND $periode2!='') {

	echo "<h2>Periode $periode1 s/d $periode2</h2>";


//IMPORT
if ($_POST[import_excel_form]!='') {
	echo "<div style='border:1px solid; width:40%; border-radius:5px; margin-bottom:20px;'>";
	include 'output_import.php';

	echo "<form method ='post' action=''>";
	echo "<table><tr><td></br><input type='submit' name='kembali' value='kembali'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='periode1' value='$periode1'>
				<input type='hidden' name='periode2' value='$periode2'></td></tr></table></form>";
	echo "</div>";
}
//IMPORT END


	//PEMBELIAN
	echo "<table>";

		//HEADER PEMBELIAN
		echo "<tr><td style='font-weight:bold;' colspan='3'>PEMBELIAN :</td></tr>";


		//PEMBELIAN SALES
		echo "<tr>";
		echo "<td><form method ='POST' action='modules/akuntansiv3/cetak/pembelian_purchasing.php' target='_blank'>";
		echo "<input type='submit' style='width:100%;' name='submit' value='Purchasing'
					<input type='hidden' name='nama_database1' value='$nama_database'>
					<input type='hidden' name='periode1' value='$periode1'>
					<input type='hidden' name='periode2' value='$periode2'>
					</form></td>";
		echo "<td>";
			echo "<form method ='post' action=''>";
			echo "<input type='submit' name='Import' value='Import'>
						<input type='hidden' name='import_excel_form' value='PURCHASING'>
						<input type='hidden' name='periode1' value='$periode1'>
						<input type='hidden' name='periode2' value='$periode2'></form>";
		echo "</td>";
		echo "</tr>";
		//PEMBELIAN SALES


		//PEMBELIAN RECEIVE SALES
		echo "<tr>";
		echo "<td><form method ='POST' action='modules/akuntansiv3/cetak/pembelian_receive_purchasing.php' target='_blank'>";
		//<input type='image' src='modules/gambar/save_excel.png' width='25' height'25' name='print' value='print'>
		echo "<input type='submit' style='width:100%;' name='submit' value='Payment Purchasing'
					<input type='hidden' name='nama_database1' value='$nama_database'>
					<input type='hidden' name='periode1' value='$periode1'>
					<input type='hidden' name='periode2' value='$periode2'>
					</form></td>";
		echo "<td>";
			echo "<form method ='post' action=''>";
			echo "<input type='submit' name='Import' value='Import'>
						<input type='hidden' name='import_excel_form' value='RECEIVE PURCHASING'>
						<input type='hidden' name='periode1' value='$periode1'>
						<input type='hidden' name='periode2' value='$periode2'></form>";
		echo "</td>";
		echo "</tr>";
		//PEMBELIAN RECEIVE SALES END


		//PEMBELIAN Discount SALES
		echo "<tr>";
		echo "<td><form method ='POST' action='modules/akuntansiv3/cetak/pembelian_discount_purchasing.php' target='_blank'>";
		//<input type='image' src='modules/gambar/save_excel.png' width='25' height'25' name='print' value='print'>
		echo "<input type='submit' style='width:100%;' name='submit' value='Discount Purchasing'
					<input type='hidden' name='nama_database1' value='$nama_database'>
					<input type='hidden' name='periode1' value='$periode1'>
					<input type='hidden' name='periode2' value='$periode2'>
					</form></td>";
		echo "<td>";
			echo "<form method ='post' action=''>";
			echo "<input type='submit' name='Import' value='Import'>
						<input type='hidden' name='import_excel_form' value='DISCOUNT PURCHASING'>
						<input type='hidden' name='periode1' value='$periode1'>
						<input type='hidden' name='periode2' value='$periode2'></form>";
		echo "</td>";
		echo "</tr>";
		//PEMBELIAN Discount SALES

	echo "</table>";
	//PEMBELIAN END

}




}//END HOME
//END PHP?>
