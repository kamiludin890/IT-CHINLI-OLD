<?php
include 'style.css';

$pencarian=$_POST['pencarian'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];

echo "<title>Import Excel</title>";

// //print excel
// if ($_POST['save_list_excel']=='1') {
// 	echo "<script type='text/javascript'>window.open('modules/hrd_payroll/cetak/print_absensi.php?id_download=$id')</script>";
// }//print excel END

$jenis_import=$_POST['import_excel_form'];
$tanggal_hari_ini=date('Y-m-d h-i-s');

echo "<h3>Jenis Import : $jenis_import</h3>";

//Jalankan Perintah Import
if ($_POST['eksekusi_import']) {
	include 'excel_reader.php';
	// upload file xls
	$target = basename($_FILES['pelengkap']['name']) ;
	move_uploaded_file($_FILES['pelengkap']['tmp_name'], $target);
	// beri permisi agar file xls dapat di baca
	chmod($_FILES['pelengkap']['name'],0777);
	// mengambil isi file xls
	$data = new Spreadsheet_Excel_Reader($_FILES['pelengkap']['name'],false);
	// menghitung jumlah baris data yang ada


//SALES
if ($jenis_import=='PURCHASING') {

				$jumlah_baris = $data->rowcount($sheet_index=0);
				for ($i=2; $i<=$jumlah_baris; $i++){
					$invoice=$data->val($i, 2, 0);
					$faktur=$data->val($i, 3, 0);
					$tanggal_faktur=$data->val($i, 4, 0);
					$nilai=$data->val($i, 5, 0);
					$debit=$data->val($i, 6, 0);
					$kredit=$data->val($i, 7, 0);
					$nilai_usd=$data->val($i, 8, 0);
					$debit_usd=$data->val($i, 9, 0);
					$kredit_usd=$data->val($i, 10, 0);
					$kode_voucher=$data->val($i, 11, 0);

					$nama_barang=$data->val($i, 12, 0);
					$perusahaan=$data->val($i, 13, 0);
					$tanggal_transaksi=$data->val($i, 14, 0);

					//RP
					$keterangan_debit=ambil_database(nama,akuntansiv3_akun,"nomor='$debit'");
					$pembeda_neraca_debit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$debit'");
					$pembeda_laba_rugi_debit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$debit'");

					$keterangan_kredit=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit'");
					$pembeda_neraca_kredit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$kredit'");
					$pembeda_laba_rugi_kredit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$kredit'");

					$nomor_daftar=ambil_database(nomor_doc,inventory_distribusi,"nomorinvoiceacc='$invoice'");
					$nomor_aju=ambil_database(nomor_aju,inventory_distribusi,"nomorinvoiceacc='$invoice'");

					if ($invoice!='' AND $nilai!='' AND ambil_database(induk_invoice,akuntansiv3_jurnal,"induk_invoice='$invoice' AND jenis_input='$jenis_import'")=='') {
					mysql_query("INSERT INTO akuntansiv3_jurnal SET
						induk_invoice='$invoice',
						ref='$faktur',
						tanggal='$tanggal_transaksi',
						tanggal_input='$tanggal_hari_ini',
						tanggal_faktur='$tanggal_faktur',
						nomor='$debit',
						nama='DEBIT',
						keterangan='$keterangan_debit',
						keterangan_posting='$jenis_import',
						debit='$nilai',
						pembeda_neraca='$pembeda_neraca_debit',
						pembeda_laba_rugi='$pembeda_laba_rugi_debit',
						nama_barang='$nama_barang',
						jenis_input='$jenis_import',
						kontak='$perusahaan',
						kode_voucher='$kode_voucher',
						nomor_daftar='$nomor_daftar',
						nomor_aju='$nomor_aju'
					");

					mysql_query("INSERT INTO akuntansiv3_jurnal SET
						induk_invoice='$invoice',
						ref='$faktur',
						tanggal='$tanggal_transaksi',
						tanggal_input='$tanggal_hari_ini',
						tanggal_faktur='$tanggal_faktur',
						nomor='$kredit',
						nama='KREDIT',
						keterangan='$keterangan_kredit',
						keterangan_posting='$jenis_import',
						kredit='$nilai',
						pembeda_neraca='$pembeda_neraca_kredit',
						pembeda_laba_rugi='$pembeda_laba_rugi_kredit',
						nama_barang='$nama_barang',
						jenis_input='$jenis_import',
						kontak='$perusahaan',
						kode_voucher='$kode_voucher',
						nomor_daftar='$nomor_daftar',
						nomor_aju='$nomor_aju'
					");
					}
					//RP END


						//USD
						$keterangan_debit_usd=ambil_database(nama,akuntansiv3_akun,"nomor='$debit_usd'");
						$pembeda_neraca_debit_usd=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$debit_usd'");
						$pembeda_laba_rugi_debit_usd=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$debit_usd'");

						$keterangan_kredit_usd=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit_usd'");
						$pembeda_neraca_kredit_usd=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$kredit_usd'");
						$pembeda_laba_rugi_kredit_usd=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$kredit_usd'");

						if ($invoice!='' AND $nilai_usd!='' AND ambil_database(induk_invoice,akuntansiv3_jurnal_usd,"induk_invoice='$invoice' AND jenis_input='$jenis_import'")=='') {
						mysql_query("INSERT INTO akuntansiv3_jurnal_usd SET
							induk_invoice='$invoice',
							ref='$faktur',
							tanggal='$tanggal_transaksi',
							tanggal_input='$tanggal_hari_ini',
							tanggal_faktur='$tanggal_faktur',
							nomor='$debit_usd',
							nama='DEBIT',
							keterangan='$keterangan_debit_usd',
							keterangan_posting='$jenis_import',
							debit='$nilai_usd',
							pembeda_neraca='$pembeda_neraca_debit_usd',
							pembeda_laba_rugi='$pembeda_laba_rugi_debit_usd',
							nama_barang='$nama_barang',
							jenis_input='$jenis_import',
							kontak='$perusahaan',
							kode_voucher='$kode_voucher',
							nomor_daftar='$nomor_daftar',
							nomor_aju='$nomor_aju'
						");

						mysql_query("INSERT INTO akuntansiv3_jurnal_usd SET
							induk_invoice='$invoice',
							ref='$faktur',
							tanggal='$tanggal_transaksi',
							tanggal_input='$tanggal_hari_ini',
							tanggal_faktur='$tanggal_faktur',
							nomor='$kredit_usd',
							nama='KREDIT',
							keterangan='$keterangan_kredit',
							keterangan_posting='$jenis_import',
							kredit='$nilai_usd',
							pembeda_neraca='$pembeda_neraca_kredit_usd',
							pembeda_laba_rugi='$pembeda_laba_rugi_kredit_usd',
							nama_barang='$nama_barang',
							jenis_input='$jenis_import',
							kontak='$perusahaan',
							kode_voucher='$kode_voucher',
							nomor_daftar='$nomor_daftar',
							nomor_aju='$nomor_aju'
						");
						}
						//USD END


					}
	}
	//SALES END



	//RECEIVE SALES
	if ($jenis_import=='RECEIVE PURCHASING' OR $jenis_import=='DISCOUNT PURCHASING') {

							$jumlah_baris = $data->rowcount($sheet_index=0);
							for ($i=2; $i<=$jumlah_baris; $i++){

								$nomor_aju=$data->val($i, 2, 0);
								$invoice=$data->val($i, 3, 0);
								$nomor_daftar=$data->val($i, 4, 0);
								$tanggal_daftar=$data->val($i, 5, 0);

								// $faktur=$data->val($i, 3, 0);
								// $tanggal_faktur=$data->val($i, 4, 0);

								$nilai=$data->val($i, 6, 0);
								$debit=$data->val($i, 7, 0);
								$kredit=$data->val($i, 8, 0);

								$nilai_usd=$data->val($i, 9, 0);
								$debit_usd=$data->val($i, 10, 0);
								$kredit_usd=$data->val($i, 11, 0);

								$kode_voucher=$data->val($i, 12, 0);

								$nama_barang=$data->val($i, 13, 0);
								$perusahaan=$data->val($i, 14, 0);


								//RP
								$keterangan_debit=ambil_database(nama,akuntansiv3_akun,"nomor='$debit'");
								$pembeda_neraca_debit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$debit'");
								$pembeda_laba_rugi_debit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$debit'");

								$keterangan_kredit=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit'");
								$pembeda_neraca_kredit=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$kredit'");
								$pembeda_laba_rugi_kredit=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$kredit'");

								mysql_query("INSERT INTO akuntansiv3_jurnal SET
									nomor_aju='$nomor_aju',
									induk_invoice='$invoice',
									nomor_daftar='$nomor_daftar',
									tanggal_daftar='$tanggal_daftar',
									tanggal='$tanggal_daftar',
									tanggal_input='$tanggal_hari_ini',
									nomor='$debit',
									nama='DEBIT',
									keterangan='$keterangan_debit',
									keterangan_posting='$jenis_import',
									debit='$nilai',
									pembeda_neraca='$pembeda_neraca_debit',
									pembeda_laba_rugi='$pembeda_laba_rugi_debit',
									nama_barang='$nama_barang',
									jenis_input='$jenis_import',
									kontak='$perusahaan',
									kode_voucher='$kode_voucher'
								");

								mysql_query("INSERT INTO akuntansiv3_jurnal SET
									nomor_aju='$nomor_aju',
									induk_invoice='$invoice',
									nomor_daftar='$nomor_daftar',
									tanggal_daftar='$tanggal_daftar',
									tanggal='$tanggal_daftar',
									tanggal_input='$tanggal_hari_ini',
									nomor='$kredit',
									nama='KREDIT',
									keterangan='$keterangan_kredit',
									keterangan_posting='$jenis_import',
									kredit='$nilai',
									pembeda_neraca='$pembeda_neraca_kredit',
									pembeda_laba_rugi='$pembeda_laba_rugi_kredit',
									nama_barang='$nama_barang',
									jenis_input='$jenis_import',
									kontak='$perusahaan',
									kode_voucher='$kode_voucher'
								");

								//RP END


									//USD
									$keterangan_debit_usd=ambil_database(nama,akuntansiv3_akun,"nomor='$debit_usd'");
									$pembeda_neraca_debit_usd=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$debit_usd'");
									$pembeda_laba_rugi_debit_usd=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$debit_usd'");

									$keterangan_kredit_usd=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit_usd'");
									$pembeda_neraca_kredit_usd=ambil_database(pembeda_neraca,akuntansiv3_akun,"nomor='$kredit_usd'");
									$pembeda_laba_rugi_kredit_usd=ambil_database(pembeda_laba_rugi,akuntansiv3_akun,"nomor='$kredit_usd'");


									mysql_query("INSERT INTO akuntansiv3_jurnal_usd SET
										nomor_aju='$nomor_aju',
										induk_invoice='$invoice',
										nomor_daftar='$nomor_daftar',
										tanggal_daftar='$tanggal_daftar',
										tanggal='$tanggal_daftar',
										tanggal_input='$tanggal_hari_ini',
										nomor='$debit_usd',
										nama='DEBIT',
										keterangan='$keterangan_debit_usd',
										keterangan_posting='$jenis_import',
										debit='$nilai_usd',
										pembeda_neraca='$pembeda_neraca_debit_usd',
										pembeda_laba_rugi='$pembeda_laba_rugi_debit_usd',
										nama_barang='$nama_barang',
										jenis_input='$jenis_import',
										kontak='$perusahaan',
										kode_voucher='$kode_voucher'
									");

									mysql_query("INSERT INTO akuntansiv3_jurnal_usd SET
										nomor_aju='$nomor_aju',
										induk_invoice='$invoice',
										nomor_daftar='$nomor_daftar',
										tanggal_daftar='$tanggal_daftar',
										tanggal='$tanggal_daftar',
										tanggal_input='$tanggal_hari_ini',
										nomor='$kredit_usd',
										nama='KREDIT',
										keterangan='$keterangan_kredit_usd',
										keterangan_posting='$jenis_import',
										kredit='$nilai_usd',
										pembeda_neraca='$pembeda_neraca_kredit_usd',
										pembeda_laba_rugi='$pembeda_laba_rugi_kredit_usd',
										nama_barang='$nama_barang',
										jenis_input='$jenis_import',
										kontak='$perusahaan',
										kode_voucher='$kode_voucher'
									");

									//USD END




								}
		}
		//RECEIVE SALES END


echo "<h3>Data Berhasil di Import</h3>";


//SHEET 4 HEADER


	// hapus kembali file .xls yang di upload tadi
	unlink($_FILES['pelengkap']['name']);
	//echo "<script type='text/javascript'>window.close();</script>";
}
//Jalankan Perintah Import END



// //PRINT
// echo "<table>";

// echo "<tr>";
// echo "<form method='POST'>";
// echo "<td><input type='submit' name='kembali' value='Download Excel'>";
// 			echo "<input type='hidden' name='halaman' value='$nomor_halaman'>
// 						<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
// 						<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
// 						<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
// 						<input type='hidden' name='pencarian' value='$pencarian'>
// 						<input type='hidden' name='item' value='$id'>
// 						<input type='hidden' name='save_list_excel' value='1'>
// 						<input type='hidden' name='import_excel_form' value='1'>
// 			</td></form>";
// echo "</tr></table>";


//FORM UPLOAD
echo "<table style='margin-top:20px; border:1px solid;'><tr><td>";

echo "<form method='post' enctype='multipart/form-data'>
			Browse:
			<input name='pelengkap' type='file' required='required'></br></br>
			<input type='hidden' name='eksekusi_import' value='import'>
			<input type='hidden' name='item' value='$id'>
			<input type='hidden' name='import_excel_form' value='$jenis_import'>
			<input type='hidden' name='periode1' value='$periode1'>
			<input type='hidden' name='periode2' value='$periode2'>
			<input name='upload' type='submit' value='Import'>
			</form>";

echo "</td></tr></table>";
//FORM UPLOAD END


//REFLESH PARENT CHROME WHEN CLOSE
// echo "<script>
//       window.onunload = refreshParent;
//       function refreshParent(){window.opener.location.reload();}
//       </script>";
//REFLESH PARENT CHROME WHEN CLOSE END

//echo "<script type='text/javascript'>window.close();</script>";
?>
