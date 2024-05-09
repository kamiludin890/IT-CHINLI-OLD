<?php

// ENKRIPSI
function base64_encrypt($plain_text, $password, $iv_len = 16)
{
$plain_text .= "\x13";
$n = strlen($plain_text);
if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
$i = 0;
$enc_text = get_rnd_iv($iv_len);
$iv = substr($password ^ $enc_text, 0, 512);
while ($i < $n) {
$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
$enc_text .= $block;
$iv = substr($block . $iv, 0, 512) ^ $password;
$i += 16;
}
$hasil=base64_encode($enc_text);
return str_replace('+', '@', $hasil);
}
function base64_decrypt($enc_text, $password, $iv_len = 16)
{
$enc_text = str_replace('@', '+', $enc_text);
$enc_text = base64_decode($enc_text);
$n = strlen($enc_text);
$i = $iv_len;
$plain_text = '';
$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
while ($i < $n) {
$block = substr($enc_text, $i, 16);
$plain_text .= $block ^ pack('H*', md5($iv));
$iv = substr($block . $iv, 0, 512) ^ $password;
$i += 16;
}
return preg_replace('/\\x13\\x00*$/', '', $plain_text);
}
function get_rnd_iv($iv_len)
{
$iv = '';
while ($iv_len-- > 0) {
$iv .= chr(mt_rand() & 0xff);
}
return $iv;
}//// ENKRIPSI END

function getRomawi($bln){
			switch ($bln){
			          case 1:
			              return "I";
			              break;
			          case 2:
			              return "II";
			              break;
			          case 3:
			              return "III";
			              break;
			          case 4:
			              return "IV";
			              break;
			          case 5:
			              return "V";
			              break;
			          case 6:
			              return "VI";
			              break;
			          case 7:
			              return "VII";
			              break;
			          case 8:
			              return "VIII";
			              break;
			          case 9:
			              return "IX";
			              break;
			          case 10:
			              return "X";
			              break;
			          case 11:
			              return "XI";
			              break;
			          case 12:
			              return "XII";
			              break;
			    }
}

function upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file){
	$tgl_upload=date('Y-m-d H:i:s');
	$hanya_angka = preg_replace("/[^0-9]/", "", $tgl_upload);
	$nama_file2="$hanya_angka-$nama_file";

	if ($nama_file==''){$nama_file3=$nama_file;}else{$nama_file3=$nama_file2;}

	$path = "modules/sales/gambarmodel/".$nama_file3;
	if($tipe_file == "image/jpeg" || $tipe_file == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
	  if($ukuran_file <= 5000000){ // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
	    move_uploaded_file($tmp_file, $path);
		}else {
			echo "Ukuran File Terlalu Besar";
		}}
return $nama_file3;}

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,0,'','.');
return $hasil_rupiah;}

function dollar($angka){
$hasil_rupiah = "$ " . number_format($angka,3,',','.');
return $hasil_rupiah;}

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

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

function hapus($nama_database,$id,$nama_database_items){

	// if($nama_database=='admin_purchasing'){
	// 	$target="modules/admincls/gambarqrcode/$id-PURCHASING.png";
	// 	if (file_exists($target)){unlink($target);}}

	$string_delete="DELETE FROM $nama_database WHERE id='$id'";
	$ekskusi=mysql_query($string_delete);

	$string_delete_items="DELETE FROM $nama_database_items WHERE induk='$id'";
	$ekskusi2=mysql_query($string_delete_items);
return;}

function pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header){//Pilihan BULAN & TAHUN START
	$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");;
	if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
	if ($opsi != '') {
		//AMBIL GET
		$pilihan_tahun=$_GET['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_GET['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_GET['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_GET['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_GET['halaman'];//PAGING
		$opsi_tambahan=$_GET['opsi_tambahan'];//OPSI TAMBAHAN
	}else{
		//AMBIL POST
		$pilihan_tahun=$_POST['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_POST['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_POST['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_POST['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_POST['halaman'];//PAGING
		$opsi_tambahan=$_POST['opsi_tambahan'];//OPSI TAMBAHAN
	}
	//Ambil Nama Nama Kolom
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);

	//pecah dan ambil Untuk Header
	$pecah_column_header=explode (",",$column_header);
	$nilai_jumlah_pecahan_header=count($pecah_column_header);
	//AMBIL POST END
	echo "<table>
	<form method ='post' action='$address'>
	<tr>
	 <td>".ambil_database($bahasa,pusat_bahasa,"kode='bulan'")."</td>
	 <td>:</td>
	 <td><select name='pilihan_bulan'>
			<option value='$pilihan_bulan'>".$pilihan_bulan."</option>
			<option value=''></option>
			<option value='01'>01</option>
			<option value='02'>02</option>
			<option value='03'>03</option>
			<option value='04'>04</option>
			<option value='05'>05</option>
			<option value='06'>06</option>
			<option value='07'>07</option>
			<option value='08'>08</option>
			<option value='09'>09</option>
			<option value='10'>10</option>
			<option value='11'>11</option>
			<option value='12'>12</option>
	 </td>
	 <td>".ambil_database($bahasa,pusat_bahasa,"kode='tahun'")."</td>
	 <td>:</td>";
	 echo "
	 <td><select name='pilihan_tahun'>";
	 echo "<option value='$pilihan_tahun'>$pilihan_tahun</option>";
	 $now=date('Y')+3;
	 for ($a=date('Y')-3;$a<=$now;$a++)
		{echo "<option value='".$a."'>".$a."</option>";}
		echo "</select></td>";
if ($pilihan_bulan != '' OR $pilihan_tahun != '') {
	echo "
	</table>
	<table>
	<tr>
	<td>".ambil_database($bahasa,pusat_bahasa,"kode='pencarian'")."</td>
	<td>:</td>
	<td><input type='text' name='pencarian' value='$pencarian'></td>
	<td><select name='pilihan_pencarian'>";
		$sql1="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pilihan_pencarian'";
		$result1=mysql_query($sql1);
		$rows1=mysql_fetch_array($result1);
		echo "<option value='$rows1[kode]'>".$rows1[$bahasa]."</option>";
	$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
		$sql2="SELECT $bahasa FROM pusat_bahasa WHERE kode='$pecah_column_header[$no]'";
		$result2=mysql_query($sql2);
		$rows2=mysql_fetch_array($result2);
		echo "<option value='$pecah_column_header[$no]'>".$rows2[$bahasa]."</option>";
	$no++;}
	echo "
	</select>
	</td>
	</tr>";}
	 echo "
	 <td><input type='submit' value='".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."'></td>
	</tr>
	</form>
	</table>
	</br>";
	//Pilihan TANGGAL & TAHUN END
return ;}//Pilihan BULAN & TAHUN START

function tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items){
	include 'style.css';
	if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
	$username=$_SESSION['username'];
	$validasi=ambil_database(validasi,master_user,"email='$username'");

	$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");;
	if ($opsi != '') {
		//AMBIL GET
		$id=base64_decrypt($_GET['id'],"XblImpl1!A@");;
		$pilihan_tahun=$_GET['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_GET['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_GET['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_GET['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_GET['halaman'];//PAGING
		$opsi_tambahan=$_GET['opsi_tambahan'];//OPSI TAMBAHAN
	}else{
		//AMBIL POST
		$id=$_POST['id'];
		$pilihan_tahun=$_POST['pilihan_tahun'];//TAHUN
		$pilihan_bulan=$_POST['pilihan_bulan'];//BULAN
		$pilihan_pencarian=$_POST['pilihan_pencarian'];//Pilihan Pencarian
		$pencarian=$_POST['pencarian'];//Pilihan Pencarian
		$nomor_halaman=$_POST['halaman'];//PAGING
		$opsi_tambahan=$_POST['opsi_tambahan'];//OPSI TAMBAHAN
	}

	//Pecah dan Ambil Nama Kolom
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);

	//pecah dan ambil Untuk Header
	$pecah_column_header=explode (",",$column_header);
	$nilai_jumlah_pecahan_header=count($pecah_column_header);

	//DELETE
	if ($opsi == 'delete') {
		$id_terakhir=ambil_database(id,$nama_database,"tanggal LIKE '$tahun_ini%' ORDER BY id DESC LIMIT 1");
		if ($id_terakhir==$id) {
			echo hapus($nama_database,$id,$nama_database_items);
		}else {
			echo "<table style='background-color:yellow;'><tr><td>Sudah ada User lain yang input dengan nomor baru, Gagal Hapus!</td></tr></table>";
		}

	}

	//UPDATE VALID
	if ($_POST[valid] == 'Valid') {
		mysql_query("UPDATE $nama_database SET validasi='$_POST[valid]',validasi_by='$username' WHERE id='$_POST[id]'");

		//Update PROSES untuk Purchasing
		if ($nama_database == 'booking_quotationurut' OR $nama_database == 'booking_notaretur' OR $nama_database == 'booking_debitnote' OR $nama_database == 'booking_packinglistreturn' OR $nama_database == 'booking_packinglist' OR $nama_database == 'booking_kontrakkerja' OR $nama_database == 'booking_kontrakjualbeli' OR $nama_database == 'booking_invoice' OR $nama_database == 'booking_invoice_turetur' OR $nama_database == 'booking_surat_jalan' OR $nama_database == 'booking_no_retur') {
			mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$_POST[id]'");
		}

	}//UPDATE VALID END


//PENENTU UPDATE INSERT
					// //Sales SPK
					// if ($nama_database == 'sales_spk') {
					// 		$po_nomor=ambil_database(po_nomor,sales_po,"id='$_POST[id_po]'");
					// 		$line_batch=ambil_database(line_batch,sales_po,"id='$_POST[id_po]'");
					// 	if ($_POST['jenis'] == tambah AND $po_nomor == ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor'") AND $line_batch == ambil_database(line_batch,$nama_database,"line_batch='$line_batch'") ) {
					// 		$ijin_tambah='tidak'; $notice=ambil_database($bahasa,pusat_bahasa,"kode='notice1'");}
					// 	else {$ijin_tambah='yes';}
					//
					// 		$id_khusus=$_POST['id'];$nilai_line_db_with_id=ambil_database(line_batch,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch' AND id='$id_khusus'");
					// 		$nilai_line_db_not_id=ambil_database(line_batch,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'");
					// 	if ($nilai_line_db_with_id == $line_batch AND $_POST['jenis'] == edit AND $po_nomor == ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'")) {
					// 		$ijin_update='yes';}
					// 	elseif ($nilai_line_db_not_id == 0 AND $_POST['jenis'] == edit AND $po_nomor != ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'")) {
					// 		$ijin_update='yes';}
					// 	else {$ijin_update='tidak';$notice=ambil_database($bahasa,pusat_bahasa,"kode='notice1'");}
					// }//Sales SPK END

if ($nama_database == 'booking_quotationurut' OR $nama_database == 'booking_notaretur' OR $nama_database == 'booking_debitnote' OR $nama_database == 'booking_packinglistreturn' OR $nama_database == 'booking_packinglist' OR $nama_database == 'booking_kontrakkerja' OR $nama_database == 'booking_kontrakjualbeli' OR $nama_database=='booking_invoice' OR $nama_database == 'booking_invoice_turetur' OR $nama_database == 'booking_surat_jalan'  OR $nama_database == 'booking_no_retur') {

	//SETTING TANGGAL TER URUT
		// dari tanggal pertama
		$tgl1=$_POST['tanggal'];
		$tgl2=ambil_database(tanggal,$nama_database,"tanggal NOT LIKE '0000-00-00' ORDER BY id DESC LIMIT 1");
		$pecah1 = explode("-", $tgl1);
		$date1 = $pecah1[2];
		$month1 = $pecah1[1];
		$year1 = $pecah1[0];
		// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun	// dari tanggal kedua
		$pecah2 = explode("-", $tgl2);
		$date2 = $pecah2[2];
		$month2 = $pecah2[1];
		$year2 =  $pecah2[0];
		// menghitung JDN dari masing-masing tanggal
		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);
		// hitung selisih hari kedua tanggal
		$selisih = $jd1 - $jd2;
	//SETTING TANGGAL TER URUT END

	//Dibawah jam 3 dan di atas jam 3
	$jam_saat_ini=date('G');
	$tgl_saat_ini=date('Y-m-d');
	$hari_saat_ini=ambilhari($tgl_saat_ini);
	$tgl_dipilih=$_POST['tanggal'];
	//Dibawah jam 3 dan di atas jam 3 END


	// if ($selisih < 0 AND $tgl1 != '') {
	// 	$ijin_update='tidak'; $ijin_tambah='tidak';
	// 	echo "<table style='background-color:yellow;'><tr><td>Tanggal tidak berurutan, Gagal Input</td></tr></table>";
	// }elseif($tgl_saat_ini==$tgl_dipilih AND $jam_saat_ini >= 15 AND $hari_saat_ini != 'Sabtu') {
	// 	$ijin_update='tidak'; $ijin_tambah='tidak';
	// 	echo "<table style='background-color:yellow;'><tr><td>Booking Tanggal Hari ini, Input dibatasi sampai Pukul 03.00 (Kecuali Sabtu)</td></tr></table>";
	// }elseif($tgl_dipilih != '' AND $tgl_saat_ini != $tgl_dipilih AND $jam_saat_ini < 15 AND $hari_saat_ini != 'Sabtu') {
	// 	$ijin_update='tidak'; $ijin_tambah='tidak';
	// 	echo "<table style='background-color:yellow;'><tr><td>Booking Tanggal Besok, Input di atas Pukul 03.00 (Kecuali Sabtu)</td></tr></table>";
	// }else{
		$ijin_update='yes'; $ijin_tambah='yes';
	// }
}

					//Sales BUkan Penentu Update
					//if ($nama_database == 'booking_invoice' OR $nama_database == 'booking_invoice_turetur' OR $nama_database == 'booking_surat_jalan') {
					//	$ijin_update='yes'; $ijin_tambah='yes';
					//}
					//Sales BUkan Penentu Update

//TAMPILAN NORMAL
//else{$ijin_tambah='yes';$ijin_update='yes';}
//TAMPILAN NORMAL END
//PENENTU UPDATE INSERT END

//NOTICE INPUT
if ($_POST['isian_revisi']=='revisi' AND $_POST['ket_revisi'] == ''){echo "<table style='background-color:yellow;'><tr><td>".ambil_database($bahasa,pusat_bahasa,"kode='notice_isian_revisi'")."</td></tr></table>";}
if ($_POST['jenis'] == tambah AND $ijin_tambah == 'tidak' OR $_POST['jenis'] == edit AND $ijin_update == 'tidak'){echo "<table style='background-color:yellow;'><tr><td>".$notice."</td></tr></table>";}
//NOTICE INPUT END

	//UPDATE DATA ARRAY
	if ($_POST['jenis'] == 'edit' AND $ijin_update == 'yes'){
			  $no=0;for($i=0; $i < $nilai_jumlah_pecahan; ++$i){
				$nama_kolom=$pecah_column[$no];

				//ISIAN REVISI
				if ($_POST['isian_revisi'] == 'revisi' AND $_POST['ket_revisi'] != ''){$tgl=date('Y-m-d H:i:s'); mysql_query("UPDATE $nama_database SET validasi='',tgl_revisi='$tgl',status='' WHERE id='$id'");}

				if ($pecah_column[$no]==pembuat){$isi_kolom=$_SESSION['username'];}//Untuk Pembuat
				elseif ($pecah_column[$no]==kode_produk_internal){$nilai_kode_produk_internal=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}//Untuk Update Spesial Nilai Kodebarang dan lokasi
				elseif ($pecah_column[$no]==id_style_item_kode){$nilai_id_style_item_kode=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// PO ambil nilai untuk masterstyle
				elseif ($pecah_column[$no]==foto) {
									//FOTO
									$nama_file = $_FILES['gambar']['name'];
									$ukuran_file = $_FILES['gambar']['size'];
									$tipe_file = $_FILES['gambar']['type'];
									$tmp_file = $_FILES['gambar']['tmp_name'];
									$nama_gambar=upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file);
									$gambar_sebelumnya=$_POST['gambar_sebelumnya'];
									if ($nama_gambar==''){
										$isi_kolom=$gambar_sebelumnya;
									}else{
										$target="modules/sales/gambarmodel/$gambar_sebelumnya";
										if (file_exists($target)){unlink($target);}
										$isi_kolom=$nama_gambar;}}
				elseif ($pecah_column[$no]==id_model){$nilai_id_model=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// PO ambil nilai untuk masterstyle
				elseif ($pecah_column[$no]==id_po){$nilai_id_po=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// SALES SPK - PO ambil nilai untuk SALES SPK
				else{$isi_kolom=$_POST[$pecah_column[$no]];}
				if ($_POST['isian_revisi']=='revisi' AND $_POST['ket_revisi'] == ''){}
				else{$update="UPDATE $nama_database SET $nama_kolom='$isi_kolom' WHERE id='$id'";
					   mysql_query($update);}

				$no++;}

				//PURCHASING-update
				if ($nama_database=='booking_invoice' OR $nama_database=='booking_surat_jalan' OR $nama_database=='booking_no_retur'){
					$departement=ambil_database(departement,master_user,"email='$username'");
					// $update=mysql_query("UPDATE $nama_database SET departement='$departement' WHERE id='$id'");
				}//PURCHASING

				//PURCHASING-update
				if ($nama_database=='booking_invoice_turetur'){
					$departement=ambil_database(departement,master_user,"email='$username'");

					$ambil_nomor=substr($_POST['no_invoice'],0,15);
					$ambil_jenis=$_POST['jenis_invoice'];
					$text="$ambil_nomor$ambil_jenis";

				$update=mysql_query("UPDATE $nama_database SET no_invoice='$text',departement='$departement' WHERE id='$id'");
				}//PURCHASING

		}//END UPDATE DATA ARRAY

	//TAMBAH DATA ARRAY
	if ($_POST['jenis'] == 'tambah' AND $ijin_tambah == 'yes'){
				$no=0;for($i=0; $i < $nilai_jumlah_pecahan; ++$i){

				if ($pecah_column[$no]==pembuat){$isi_kolom=$_SESSION['username'];}//Untuk Pembuat
				elseif ($pecah_column[$no]==tgl_dibuat){$isi_kolom=date('Y-m-d H:i:s');}//Untuk Waktu Pertama di Input
				elseif ($pecah_column[$no]==kode_produk_internal){$nilai_kode_produk_internal=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}//masterstyle Untuk Update Spesial Nilai Kodebarang dan lokasi
				elseif ($pecah_column[$no]==id_style_item_kode){$nilai_id_style_item_kode=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// PO ambil nilai untuk masterstyle
				elseif ($pecah_column[$no]==foto) {
					//FOTO
					$nama_file = $_FILES['gambar']['name'];
					$ukuran_file = $_FILES['gambar']['size'];
					$tipe_file = $_FILES['gambar']['type'];
					$tmp_file = $_FILES['gambar']['tmp_name'];
					$isi_kolom=upload_gambar($nama_file,$ukuran_file,$tipe_file,$tmp_file);}
				elseif ($pecah_column[$no]==id_model){$nilai_id_model=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// PO ambil nilai untuk masterstyle
				elseif ($pecah_column[$no]==id_po){$nilai_id_po=$_POST[$pecah_column[$no]]; $isi_kolom=$_POST[$pecah_column[$no]];}// SALES SPK - PO ambil nilai untuk SALES SPK

				elseif ($pecah_column[$no]==surat_jalan AND $nama_database=='booking_surat_jalan') {
					$tanggal=$_POST['tanggal'];
					$ambil_tahun=substr($tanggal,0,4);
					$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY surat_jalan DESC LIMIT 1");
					$rows15=mysql_fetch_array($result15);
					$ambil_nomor=substr($rows15['surat_jalan'],8,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor);

					if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

					$no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
					$departement=ambil_database(departement,master_user,"email='$username'");
					$isi_kolom=$no_invoice;}


					elseif ($pecah_column[$no]==surat_jalan AND $nama_database=='booking_no_retur') {
						$tanggal=$_POST['tanggal'];
						$ambil_tahun=substr($tanggal,0,4);
						$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY surat_jalan DESC LIMIT 1");
						$rows15=mysql_fetch_array($result15);
						$ambil_nomor=substr($rows15['surat_jalan'],8,5)+1;
						$jumlah_karakter_nol20=5-strlen($ambil_nomor);

						if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
						if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
						if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
						if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
						if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

						$ambil_bulan=substr($tanggal,5,2);
						$no_invoice="$hasil_nol$ambil_nomor/NR/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

						// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
						$departement=ambil_database(departement,master_user,"email='$username'");
						$isi_kolom=$no_invoice;}


						elseif ($pecah_column[$no]==nomor_kontrakjualbeli) {
							$tanggal=$_POST['tanggal'];
							$ambil_tahun=substr($tanggal,0,4);
							$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY nomor_kontrakjualbeli DESC LIMIT 1");
							$rows15=mysql_fetch_array($result15);
							$ambil_nomor=substr($rows15['nomor_kontrakjualbeli'],0,5)+1;
							$jumlah_karakter_nol20=5-strlen($ambil_nomor);

							echo "$ambil_nomor";

							if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
							if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
							if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
							if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
							if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

							$ambil_bulan=substr($tanggal,5,2);
							$no_invoice="$hasil_nol$ambil_nomor/KJB/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

							// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
							$departement=ambil_database(departement,master_user,"email='$username'");
							$isi_kolom=$no_invoice;}


							elseif ($pecah_column[$no]==nomor_kontrakkerja) {
								$tanggal=$_POST['tanggal'];
								$ambil_tahun=substr($tanggal,0,4);
								$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY nomor_kontrakkerja DESC LIMIT 1");
								$rows15=mysql_fetch_array($result15);
								$ambil_nomor=substr($rows15['nomor_kontrakkerja'],0,5)+1;
								$jumlah_karakter_nol20=5-strlen($ambil_nomor);

								// echo "$ambil_nomor";

								if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
								if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
								if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
								if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
								if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

								$ambil_bulan=substr($tanggal,5,2);
								$no_invoice="$hasil_nol$ambil_nomor/KK/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

								// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
								$departement=ambil_database(departement,master_user,"email='$username'");
								$isi_kolom=$no_invoice;}

								elseif ($pecah_column[$no]==nomor_packinglist) {
									$tanggal=$_POST['tanggal'];
									$ambil_tahun=substr($tanggal,0,4);
									$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY nomor_packinglist DESC LIMIT 1");
									$rows15=mysql_fetch_array($result15);
									$ambil_nomor=substr($rows15['nomor_packinglist'],0,5)+1;
									$jumlah_karakter_nol20=5-strlen($ambil_nomor);

									// echo "$ambil_nomor";

									if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
									if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
									if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
									if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
									if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

									$ambil_bulan=substr($tanggal,5,2);
									$no_invoice="$hasil_nol$ambil_nomor/PK/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

									// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
									$departement=ambil_database(departement,master_user,"email='$username'");
									$isi_kolom=$no_invoice;}


								elseif ($pecah_column[$no]==nomor_packinglistreturn) {
									$tanggal=$_POST['tanggal'];
									$ambil_tahun=substr($tanggal,0,4);
									$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY nomor_packinglistreturn DESC LIMIT 1");
									$rows15=mysql_fetch_array($result15);
									$ambil_nomor=substr($rows15['nomor_packinglistreturn'],0,5)+1;
									$jumlah_karakter_nol20=5-strlen($ambil_nomor);

									// echo "$ambil_nomor";

									if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
									if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
									if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
									if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
									if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

									$ambil_bulan=substr($tanggal,5,2);
									$no_invoice="$hasil_nol$ambil_nomor/RT/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

									// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
									$departement=ambil_database(departement,master_user,"email='$username'");
									$isi_kolom=$no_invoice;}

									elseif ($pecah_column[$no]==nomor_debitnote) {
										$tanggal=$_POST['tanggal'];
										$ambil_tahun=substr($tanggal,0,4);
										$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY nomor_debitnote DESC LIMIT 1");
										$rows15=mysql_fetch_array($result15);
										$ambil_nomor=substr($rows15['nomor_debitnote'],0,5)+1;
										$jumlah_karakter_nol20=5-strlen($ambil_nomor);

										// echo "$ambil_nomor";

										if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
										if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
										if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
										if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
										if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

										$ambil_bulan=substr($tanggal,5,2);
										$no_invoice="$hasil_nol$ambil_nomor/DN/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

										// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
										$departement=ambil_database(departement,master_user,"email='$username'");
										$isi_kolom=$no_invoice;}

										elseif ($pecah_column[$no]==nomor_notaretur) {
											$tanggal=$_POST['tanggal'];
											$ambil_tahun=substr($tanggal,0,4);
											$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY nomor_notaretur DESC LIMIT 1");
											$rows15=mysql_fetch_array($result15);
											$ambil_nomor=substr($rows15['nomor_notaretur'],0,5)+1;
											$jumlah_karakter_nol20=5-strlen($ambil_nomor);

											// echo "$ambil_nomor";

											if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
											if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
											if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
											if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
											if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

											$ambil_bulan=substr($tanggal,5,2);
											$no_invoice="$hasil_nol$ambil_nomor/NR/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

											// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
											$departement=ambil_database(departement,master_user,"email='$username'");
											$isi_kolom=$no_invoice;}


											elseif ($pecah_column[$no]==nomor_quotationurut) {
												$tanggal=$_POST['tanggal'];
												$ambil_tahun=substr($tanggal,0,4);
												$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
												$rows15=mysql_fetch_array($result15);
												$ambil_nomor=substr($rows15['nomor_quotationurut'],10,5)+1;
												$jumlah_karakter_nol20=5-strlen($ambil_nomor);

												// echo "$ambil_nomor";

												if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
												if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
												if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
												if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
												if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

												$ambil_bulan=substr($tanggal,5,2);
												// $no_invoice="$hasil_nol$ambil_nomor/NR/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";
												$no_invoice="CL-".substr($tanggal,8,2)."".substr($tanggal,5,2)."".substr($tanggal,2,2)."-$hasil_nol$ambil_nomor";

												// $no_invoice="CL-$ambil_tahun-$hasil_nol$ambil_nomor";
												$departement=ambil_database(departement,master_user,"email='$username'");
												$isi_kolom=$no_invoice;}



				elseif ($pecah_column[$no]==no_invoice AND $nama_database=='booking_invoice') {
					$tanggal=$_POST['tanggal'];
					$ambil_tahun=substr($tanggal,0,4);
					$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY no_invoice DESC LIMIT 1");
					$rows15=mysql_fetch_array($result15);
					$ambil_nomor=substr($rows15['no_invoice'],10,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor);

					if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}

					if ($_POST['tipe_transaksi']!='') {
						$tipe_transaksi='A';
					}

					$no_invoice="CPTI-$ambil_tahun-$hasil_nol$ambil_nomor$tipe_transaksi";
					$isi_kolom=$no_invoice;}

				elseif ($pecah_column[$no]==no_invoice AND $nama_database=='booking_invoice_turetur') {
					$tanggal=$_POST['tanggal'];
					$ambil_tahun=substr($tanggal,0,4);
					$jenis_invoice=$_POST['jenis_invoice'];
					$result15=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY no_invoice DESC LIMIT 1");
					$rows15=mysql_fetch_array($result15);
					$ambil_nomor=substr($rows15['no_invoice'],10,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor);
					if($jumlah_karakter_nol20=='0'){$hasil_nol='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol='0000';}
					$no_invoice="CPTI-$ambil_tahun-$hasil_nol$ambil_nomor$jenis_invoice";
					$isi_kolom=$no_invoice;}

				// elseif ($pecah_column[$no]==departement) {
				// $departement=ambil_database(departement,master_user,"email='$username'"); echo "TEST";
				// $isi_kolom=$departement;}

				else{$isi_kolom=$_POST[$pecah_column[$no]];}
				$datasecs[]=$pecah_column[$no]."='".$isi_kolom."'";$no++;}
				$data=implode(",", $datasecs);
				$insert ="INSERT INTO $nama_database SET $data";
				mysql_query($insert);

		//INSERT SPESIAL
		$data2=implode(" AND ", $datasecs);

		//booking_invoice-insert
		if ($nama_database=='booking_invoice'){
			$ambil_id=ambil_database(id,booking_invoice,$data2);
			$tanggal=ambil_database(tanggal,booking_invoice,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
						//TOTAL DOKUMEN
						if ($_POST['total_dokumen']!='') {
							$total_dokumen=$_POST['total_dokumen'];
							$tanggal=$_POST['tanggal'];
							$pembeli=$_POST['dari'];
							$keterangan=$_POST['keterangan'];
							$departement=$_POST['departement'];
							$tgl_pembuatan=date('Y-m-d H:i:s');
						$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
							$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
							$rows20=mysql_fetch_array($result20);
							$ambil_nomor20=substr($rows20['no_invoice'],10,5)+1;
							$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
							if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
							if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
							if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
							if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
							if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}

							if ($_POST['tipe_transaksi']!='') {
								$tipe_transaksi='A';
							}
							$no_invoice20="CPTI-$ambil_tahun-$hasil_nol20$ambil_nomor20$tipe_transaksi";

							if (ambil_database(no_invoice,$nama_database,"delete.png'$no_invoice20'")=='') {

								mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',no_invoice='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");

								if ($_POST['tipe_transaksi']!='') {
									$tanggal=$_POST['tanggal'];
									$pembeli=$_POST['dari'];
									$keterangan=$_POST['keterangan'];
									$departement=ambil_database(departement,master_user,"email='$username'");
									$tgl_pembuatan=date('Y-m-d H:i:s');
									$no_invoice30=substr($no_invoice20,0,15)."B";
									mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',no_invoice='$no_invoice30',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
								}

							}
						$nomor++;}////ARRAY TOTAL DOKUMEN
						}//TOTAL DOKUMEN END


						if ($_POST['tipe_transaksi']!='') {
							$tanggal=$_POST['tanggal'];
							$pembeli=$_POST['dari'];
							$keterangan=$_POST['keterangan'];
							$departement=$_POST['departement'];
							$tgl_pembuatan=date('Y-m-d H:i:s');
							$no_invoice30=substr(ambil_database(no_invoice,booking_invoice,"id='$ambil_id'"),0,15)."B";

							mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',no_invoice='$no_invoice30',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
						}


		}//


		//booking_invoice_turetur-insert
		if ($nama_database=='booking_invoice_turetur'){
			$ambil_id=ambil_database(id,booking_invoice_turetur,$data2);
			$tanggal=ambil_database(tanggal,booking_invoice_turetur,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
			$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
				$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
				$rows20=mysql_fetch_array($result20);
				$ambil_nomor20=substr($rows20['no_invoice'],10,5)+1;
				$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
				if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
				if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
				if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
				if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
				if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}
				$jenis_invoice=ambil_database(jenis_invoice,booking_invoice_turetur,"id='$ambil_id'");
				$no_invoice20="CPTI-$ambil_tahun-$hasil_nol20$ambil_nomor20$jenis_invoice";
				if (ambil_database(no_invoice,$nama_database,"no_invoice='$no_invoice20'")=='') {
					mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',no_invoice='$no_invoice20',jenis_invoice='$jenis_invoice',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
				}
			$nomor++;}////ARRAY TOTAL DOKUMEN
			}//TOTAL DOKUMEN END
		}//booking_invoice_turetur

		//booking_invoice-insert
		if ($nama_database=='booking_surat_jalan'){
			$ambil_id=ambil_database(id,booking_surat_jalan,$data2);
			$tanggal=ambil_database(tanggal,booking_surat_jalan,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
			  $total_dokumen=$_POST['total_dokumen'];
			  $tanggal=$_POST['tanggal'];
			  $pembeli=$_POST['dari'];
			  $keterangan=$_POST['keterangan'];
			  $departement=$_POST['departement'];
			  $tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
				  $result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
				  $rows20=mysql_fetch_array($result20);
				  $ambil_nomor20=substr($rows20['surat_jalan'],8,5)+1;
				  $jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
				  if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
				  if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
				  if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
				  if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}
				  $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";

					if (ambil_database(surat_jalan,$nama_database,"surat_jalan='$no_invoice20'")=='') {
				    mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',surat_jalan='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
				  }
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//booking_invoice


		//booking_invoice-insert
		if ($nama_database=='booking_no_retur'){
			$ambil_id=ambil_database(id,booking_no_retur,$data2);
			$tanggal=ambil_database(tanggal,booking_no_retur,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
					$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
					$rows20=mysql_fetch_array($result20);
					$ambil_nomor20=substr($rows20['surat_jalan'],0,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


					// $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";

					$no_invoice20="$hasil_nol20$ambil_nomor20/NR/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

					if (ambil_database(surat_jalan,$nama_database,"surat_jalan='$no_invoice20'")=='') {
						mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',surat_jalan='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
					}
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//booking_invoice


		//booking_invoice-insert
		if ($nama_database=='booking_kontrakjualbeli'){
			$ambil_id=ambil_database(id,booking_kontrakjualbeli,$data2);
			$tanggal=ambil_database(tanggal,booking_kontrakjualbeli,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
					$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
					$rows20=mysql_fetch_array($result20);
					$ambil_nomor20=substr($rows20['nomor_kontrakjualbeli'],0,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


					// $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";

					$no_invoice20="$hasil_nol20$ambil_nomor20/KJB/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

					if (ambil_database(nomor_kontrakjualbeli,$nama_database,"nomor_kontrakjualbeli='$no_invoice20'")=='') {
						mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',nomor_kontrakjualbeli='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
					}
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//booking_invoice


		//booking_invoice-insert
		if ($nama_database=='booking_kontrakkerja'){
			$ambil_id=ambil_database(id,booking_kontrakkerja,$data2);
			$tanggal=ambil_database(tanggal,booking_kontrakkerja,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
					$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
					$rows20=mysql_fetch_array($result20);
					$ambil_nomor20=substr($rows20['nomor_kontrakkerja'],0,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


					// $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";

					$no_invoice20="$hasil_nol20$ambil_nomor20/KK/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

					if (ambil_database(nomor_kontrakkerja,$nama_database,"nomor_kontrakkerja='$no_invoice20'")=='') {
						mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',nomor_kontrakkerja='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
					}
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//booking_invoice

		//booking_invoice-insert
		if ($nama_database=='booking_packinglist'){
			$ambil_id=ambil_database(id,booking_packinglist,$data2);
			$tanggal=ambil_database(tanggal,booking_packinglist,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
					$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
					$rows20=mysql_fetch_array($result20);
					$ambil_nomor20=substr($rows20['nomor_packinglist'],0,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


					// $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";

					$no_invoice20="$hasil_nol20$ambil_nomor20/PK/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

					if (ambil_database(nomor_packinglist,$nama_database,"nomor_packinglist='$no_invoice20'")=='') {
						mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',nomor_packinglist='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
					}
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//booking_invoice


		//booking_invoice-insert
		if ($nama_database=='booking_packinglistreturn'){
			$ambil_id=ambil_database(id,booking_packinglistreturn,$data2);
			$tanggal=ambil_database(tanggal,booking_packinglistreturn,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
					$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
					$rows20=mysql_fetch_array($result20);
					$ambil_nomor20=substr($rows20['nomor_packinglistreturn'],0,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


					// $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";

					$no_invoice20="$hasil_nol20$ambil_nomor20/PK/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

					if (ambil_database(nomor_packinglistreturn,$nama_database,"nomor_packinglistreturn='$no_invoice20'")=='') {
						mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',nomor_packinglistreturn='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
					}
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//booking_invoice


		//booking_invoice-insert
		if ($nama_database=='booking_debitnote'){
			$ambil_id=ambil_database(id,booking_debitnote,$data2);
			$tanggal=ambil_database(tanggal,booking_debitnote,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
					$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
					$rows20=mysql_fetch_array($result20);
					$ambil_nomor20=substr($rows20['nomor_debitnote'],0,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


					// $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";
					$no_invoice20="$hasil_nol20$ambil_nomor20/DN/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

					if (ambil_database(nomor_debitnote,$nama_database,"nomor_debitnote='$no_invoice20'")=='') {
						mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',nomor_debitnote='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
					}
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//Nota Retur
		if ($nama_database=='booking_notaretur'){
			$ambil_id=ambil_database(id,booking_notaretur,$data2);
			$tanggal=ambil_database(tanggal,booking_notaretur,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
				$total_dokumen=$_POST['total_dokumen'];
				$tanggal=$_POST['tanggal'];
				$pembeli=$_POST['dari'];
				$keterangan=$_POST['keterangan'];
				$departement=$_POST['departement'];
				$tgl_pembuatan=date('Y-m-d H:i:s');
				$nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
					$result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
					$rows20=mysql_fetch_array($result20);
					$ambil_nomor20=substr($rows20['nomor_notaretur'],0,5)+1;
					$jumlah_karakter_nol20=5-strlen($ambil_nomor20);
					if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
					if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
					if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
					if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
					if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


					// $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";
					$no_invoice20="$hasil_nol20$ambil_nomor20/NR/CPTI/".getRomawi($ambil_bulan)."/$ambil_tahun";

					if (ambil_database(nomor_notaretur,$nama_database,"nomor_notaretur='$no_invoice20'")=='') {
						mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',nomor_notaretur='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
					}
				$nomor++;}////ARRAY TOTAL DOKUMEN
				}//TOTAL DOKUMEN END
		}//booking_invoice

		if ($nama_database=='booking_quotationurut'){
			$ambil_id=ambil_database(id,booking_quotationurut,$data2);
			$tanggal=ambil_database(tanggal,booking_quotationurut,"id='$ambil_id'");
			$ambil_tahun=substr($tanggal,0,4);
			$ambil_bulan=substr($tanggal,5,2);

			//TOTAL DOKUMEN
			if ($_POST['total_dokumen']!='') {
			  $total_dokumen=$_POST['total_dokumen'];
			  $tanggal=$_POST['tanggal'];
			  $pembeli=$_POST['dari'];
			  $keterangan=$_POST['keterangan'];
			  $departement=$_POST['departement'];
			  $tgl_pembuatan=date('Y-m-d H:i:s');
			  $nomor=1;for($i=0; $i < $total_dokumen-1; ++$i){//ARRAY TOTAL DOKUMEN
			    $result20=mysql_query("SELECT * FROM $nama_database WHERE tanggal LIKE '$ambil_tahun%' ORDER BY id DESC LIMIT 1");
			    $rows20=mysql_fetch_array($result20);
			    $ambil_nomor20=substr($rows20['nomor_quotationurut'],10,5)+1;
			    $jumlah_karakter_nol20=5-strlen($ambil_nomor20);
			    if($jumlah_karakter_nol20=='0'){$hasil_nol20='';}
			    if($jumlah_karakter_nol20=='1'){$hasil_nol20='0';}
			    if($jumlah_karakter_nol20=='2'){$hasil_nol20='00';}
			    if($jumlah_karakter_nol20=='3'){$hasil_nol20='000';}
			    if($jumlah_karakter_nol20=='4'){$hasil_nol20='0000';}


			    // $no_invoice20="CL-$ambil_tahun-$hasil_nol20$ambil_nomor20";
			    $no_invoice20="CL-".substr($tanggal,8,2)."".substr($tanggal,5,2)."".substr($tanggal,2,2)."-$hasil_nol20$ambil_nomor20";

			    if (ambil_database(nomor_quotationurut,$nama_database,"nomor_quotationurut='$no_invoice20'")=='') {
			      mysql_query("INSERT INTO $nama_database SET tanggal='$tanggal',nomor_quotationurut='$no_invoice20',dari='$pembeli',pembuat='$username',departement='$departement',tgl_dibuat='$tgl_pembuatan',keterangan='$keterangan'");
			    }
			  $nomor++;}////ARRAY TOTAL DOKUMEN
			  }//TOTAL DOKUMEN END
		}//booking_invoice


		//END INSERT SPESIAL

		if ($nama_database == 'booking_invoice' OR $nama_database == 'booking_invoice_turetur' OR $nama_database == 'booking_surat_jalan' OR $nama_database == 'booking_no_retur' OR $nama_database == 'booking_kontrakjualbeli' OR $nama_database == 'booking_kontrakkerja') {
			 echo "<script type='text/javascript'>window.location.href='$address&id=".base64_encrypt($ambil_id,"XblImpl1!A@")."&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'</script>";}

}	//TAMBAH DATA ARRAY END

//START EDIT TAMBAH
if ($opsi == 'tambah' OR $opsi =='edit') {

//ISIAN JIKA EDIT
$sql5="SELECT * FROM $nama_database WHERE id='$id'";
$result5=mysql_query($sql5);
$rows5=mysql_fetch_array($result5);

echo kalender();
echo combobox();

//TABEl START
echo "<table class='kolom_isi'>";
		echo "<form method ='post' enctype='multipart/form-data' action='$address'>";
		$no=0;for($i=0; $i < $nilai_jumlah_pecahan; ++$i){

			$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column[$no]'";
			$result3=mysql_query($sql3);
			$rows3=mysql_fetch_array($result3);
			echo "<tr>";
			//HEADER
			echo "<td id='kolom_isi_th'><strong>".$rows3[$bahasa]."</strong></td>";
			//HEADER END

		$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);

		if ($pecah_column[$no] == 'nomor_quotationurut' OR $pecah_column[$no] == 'id' OR $pecah_column[$no] == 'pembuat' OR $pecah_column[$no] == 'tgl_dibuat'  OR $pecah_column[$no] == 'no_invoice' OR $pecah_column[$no] == 'surat_jalan' OR $pecah_column[$no] == 'nomor_kontrakjualbeli' OR $pecah_column[$no] == 'nomor_kontrakkerja' OR $pecah_column[$no] == 'nomor_packinglist' OR $pecah_column[$no] == 'nomor_packinglistreturn' OR $pecah_column[$no] == 'nomor_debitnote' OR $pecah_column[$no] == 'nomor_notaretur'){$disabled='readonly';}else{$disabled='';}

		if ($pecah_column[$no] == 'tanggal' OR $pecah_column[$no] == 'etd' OR $pecah_column[$no] == 'tanggal_revisi' OR $pecah_column[$no] == 'bucket_stage'  OR $pecah_column[$no] == 'tanggal_kirim'){$format_tgl="class='date' required";}else{$format_tgl="";}

if ($pecah_column[$no] == 'dari'){

if ($nama_database=='booking_quotationurut') {
	$db='sales_perusahaan';
}else {
	$db='booking_perusahaan';
}

$sql113="SELECT * FROM $db ORDER BY perusahaan";
$result113=mysql_query($sql113);
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	while ($rows113=mysql_fetch_array($result113)) {
echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";}
echo "
</select>
</td>";
}
//KEPADA
elseif ($pecah_column[$no] == 'kepada'){
$sql113="SELECT * FROM sales_perusahaan WHERE validasi='Valid' AND code='SUPPLIER' ORDER BY perusahaan";
$result113=mysql_query($sql113);
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
while ($rows113=mysql_fetch_array($result113)) {
echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";}
echo "
</select>
</td>";
}
//KEPADA
elseif ($pecah_column[$no] == 'jenis_invoice'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='PR'>PR - PENGEMBALIAN RETUR</option>";
// echo "<option value='TU'>TU - TIDAK UANG</option>";
echo "<option value='R'>R - RETUR</option>";
echo "<option value='FOC'>FOC</option>";
echo "
</select>
</td>";
}
//KEPADA
elseif ($pecah_column[$no] == 'departement'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]' required>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='CL'>CL</option>";
echo "<option value='CLS'>CLS</option>";
echo "<option value='SL'>SL</option>";
echo "
</select>
</td>";
}
//KEPADA
elseif ($pecah_column[$no] == 'tipe_transaksi'){

	if ($rows5[$pecah_column[$no]]=='') {
		echo "<td>
		<select class='comboyuk' name='$pecah_column[$no]'>
		<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
		echo "<option value='A & B'>A & B</option>";
		echo "
		</select>
		</td>";
	}else {
		echo "<td>".$rows5[$pecah_column[$no]]."</td>";
		echo "<input type='hidden' name='tipe_transaksi' value='".$rows5[$pecah_column[$no]]."'>";
	}


}
//TANGGAL REVISI
elseif ($pecah_column[$no] == 'ket_revisi') {
		echo "<input type='hidden' name='isian_revisi' value='$opsi_tambahan'>";
	if ($opsi_tambahan == 'revisi') {
		echo "<td><textarea name='$pecah_column[$no]' rows='3' cols='30'>".$rows5[$pecah_column[$no]]."</textarea></td>";
	}else {
		echo "<td><input type='hidden' name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</td>";
	}
}
//JENIS PO - PURCHASING
elseif($pecah_column[$no] == 'jenis_po_purchasing'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
 <option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='PRD'>PRD</option>";
echo "<option value='SMP'>SMP</option>";
echo "<option value='PL'>PL</option>";
echo "</select></td>";
}
//JENIS PO - PURCHASING
elseif($pecah_column[$no] == 'keterangan' AND $nama_database=='booking_kontrakjualbeli'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
 <option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='FOC'>FOC</option>";
echo "<option value='BAYAR'>BAYAR</option>";
echo "</select></td>";
}
//JENIS PO - PURCHASING
elseif($pecah_column[$no] == 'keterangan' AND $nama_database=='booking_packinglist'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
 <option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='AKB'>AKB</option>";
echo "<option value='DPIL'>DPIL</option>";
echo "</select></td>";
}
//JENIS PO - PURCHASING
elseif($pecah_column[$no] == 'keterangan' AND $nama_database=='booking_packinglistreturn'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
 <option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='AKB'>AKB</option>";
echo "<option value='DPIL'>DPIL</option>";
echo "</select></td>";
}
//BOOKING INVOICE - TOTAL DOKUMEN
elseif($pecah_column[$no] == 'total_dokumen'){
echo "<td>";
echo "<input type='number' name='total_dokumen' value=''>";
echo "</td>";
}
//TAMPILAN SEBENARNYA
else{
echo "<td><input type='text' $format_tgl name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."' $disabled style='width:95%; border-radius:4px; text-align:center;' autocomplete='off'></td>";
}
echo "</tr>";
$no++;}
	echo "</table><table>";
	echo "<tr><td><input type='image' src='modules/gambar/save.png' width='30' height'30' name='simpan' value='Simpan'>
				<input type='hidden' name='jenis' value='$opsi'>
				<input type='hidden' name='id' value='$rows5[id]'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'></td></form>";
	echo "<form method ='post' action='$address'>";
	echo "<td><input type='image' src='modules/gambar/back.png' width='30' height'30' name='kembali' value='kembali'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'></td></tr></form>";
	echo "</tr>";
	echo "</table>";


}else {//START ELSE OPSI ke TAMPILAN UTAMA
				//Link tambah Data
				$akses=ambil_database(akses,master_user,"email='$username'");
$id_menu=ambil_database(id,master_menu,"url='$address'");
$ada_tambah=ambil_database(tambah,master_akses,"id='$akses' AND tambah LIKE '%$id_menu%'");
$list_id=explode (",",$ada_tambah);
$jumlah_list_id=count($list_id);
$no=0;for($i=0; $i < $jumlah_list_id; ++$i){
  if ($list_id[$no]==$id_menu){$tampil_tambah=1;}else{$tampil_tambah=0;}
$total_tampil_tambah=$tampil_tambah+$total_tampil_tambah;
$no++;}
if ($total_tampil_tambah=='1') {
  echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("tambah","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/tambah.png' width='25px'/></a></br>";
}
				echo "<table class='tabel_utama' style='width:auto;'>";
				//HEADER TABEL
				echo "<thead>";
					echo "<th style=''><strong>No</strong></th>";
			$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
					$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column_header[$no]'";
					$result3=mysql_query($sql3);
					$rows3=mysql_fetch_array($result3);
					echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
			$no++;}
					echo "<th colspan='3' style=''><strong>".ambil_database($bahasa,pusat_bahasa,"kode='valid'")."</strong></th>";
					echo "<th colspan='3' style=''><strong>".ambil_database($bahasa,pusat_bahasa,"kode='Opsi'")."</strong></th>";
				echo "</thead>";
				//HEADER END

				//ISI TABEL
				if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}

				if ($nama_database=='booking_surat_jalan' OR $nama_database=='booking_no_retur') {$urutan='surat_jalan';}
				elseif ($nama_database=='booking_kontrakjualbeli') {
					$urutan='nomor_kontrakjualbeli';
				}
				elseif ($nama_database=='booking_kontrakkerja') {
					$urutan='nomor_kontrakkerja';
				}elseif ($nama_database=='booking_packinglist') {
					$urutan='nomor_packinglist';
				}elseif ($nama_database=='booking_packinglistreturn') {
					$urutan='nomor_packinglistreturn';
				}elseif ($nama_database=='booking_debitnote') {
					$urutan='nomor_debitnote';
				}elseif ($nama_database=='booking_notaretur') {
					$urutan='nomor_notaretur';
				}elseif ($nama_database=='booking_quotationurut') {
					$urutan='id';
				}
				else{$urutan='no_invoice';}


//PAGING
$halaman = 50;
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT	* FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT	* FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian ORDER BY $urutan DESC LIMIT $mulai, $halaman")or die(mysql_error);
$no =$mulai+1;
//PAGING
				while ($rows1=mysql_fetch_array($query)){
				$warnaGenap="white";$warnaGanjil="#CEF6F5";if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}
				echo "<tr>";
				echo "<td style='background-color:$color;'>$no</td>";
				$no_items=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
				//TAMPILAN TABEL - FOTO - MASTER MODEL
				if ($pecah_column_header[$no_items]=='foto') {
					$nama_gambar_tampilan=$rows1[$pecah_column_header[$no_items]];
					echo "<td>";echo "<a href='modules/sales/gambarmodel/tampil_foto.php?gambar=$nama_gambar_tampilan' target='_blank'><img src='modules/sales/gambarmodel/$nama_gambar_tampilan' width='80px' height='100px'/></a>";echo "</td>";
				}
				//TAMPILAN TABEL - TOTAL USD - PO
				elseif ($pecah_column_header[$no_items]=='amount_usd') {
					echo "<td style='background-color:$color;'>".dollar($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN TABEL - TOTAL RP - PO
				elseif ($pecah_column_header[$no_items]=='amount_rp') {
					echo "<td style='background-color:$color;'>".rupiah($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN TABEL - HARGA SATUAN USD - PO
				elseif ($pecah_column_header[$no_items]=='price_usd') {
					echo "<td style='background-color:$color;'>".dollar($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN TABEL - HARGA SATUAN RP - PO
				elseif ($pecah_column_header[$no_items]=='price_rp') {
					echo "<td style='background-color:$color;'>".rupiah($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN TABEL - PERINGATAN SPK RP - PO
				elseif ($pecah_column_header[$no_items]=='tgl_revisi' AND $nama_database=='sales_spk') {
					$tgl_revisi_po=ambil_database(tgl_revisi,sales_po,"id='".$rows1[id_po]."'");
					$tgl_revisi_spk=ambil_database(tgl_revisi,sales_spk,"id='".$rows1[id]."'");
					if ($tgl_revisi_po == $tgl_revisi_spk) {
					echo "<td style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}else{echo "<td style='background-color:yellow;'>".ambil_database($bahasa,pusat_bahasa,"kode='notice_update_revisi'")."</td>"; $terjadi_revisi_khusus_spk='yes';}
				}
				//TAMPILAN NORMAT TABEL
				else {
					echo "<td style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				$no_items++;}

				//ISI PEMBEDA VALID DAN STATUS
					if ($validasi=='ya' AND $rows1[validasi] == '') {
						echo "<td colspan='3' style='background-color:$color;'>";
							echo '<form method="POST" action="'.$address.'" onsubmit="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_valid'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\');">';
							echo "<input type='submit' name='valid' value='Valid'>
										<input type='hidden' name='halaman' value='$nomor_halaman'>
										<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
										<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
										<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
										<input type='hidden' name='pencarian' value='$pencarian'>
										<input type='hidden' name='id' value='$rows1[id]'></form>";
						echo "</td>";
					}else{echo "<td colspan='3' style='background-color:$color;'><strong>$rows1[validasi] by $rows1[validasi_by]</strong></td>";}
				//ISI PEMBEDA VALID DAN STATUS

				//OPSI
				if ($rows1[validasi] == '') {
				echo "<td style='text-align: center; background-color: white; border-top-left-radius: 10px; border-bottom-left-radius: 10px;'><center>";
				echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("edit","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/edit.png' width='25px'/></a>";
				echo "</td>";}else{}//echo "<td style='width:10 background-color:$color;'></td>";

				//echo "<td style='text-align: center; background-color: white;'><center>";
				//echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/item.png' width='25px'/></a>";
				//echo "</td>";

				if ($rows1[validasi] == '') {
					// $tahun_ini=date('Y');
					$tahun_ini=$pilihan_tahun;

					if ($nama_database=='booking_invoice' OR $nama_database=='booking_invoice_turetur') {
								$id_terakhir=ambil_database(id,$nama_database,"tanggal LIKE '$tahun_ini%' ORDER BY no_invoice DESC LIMIT 1");
									if ($id_terakhir==$rows1[id]) {
										 echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
										 echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
										 echo "</center></td>";
									}
				  }elseif ($nama_database=='booking_kontrakjualbeli') {
								$id_terakhir=ambil_database(id,$nama_database,"tanggal LIKE '$tahun_ini%' ORDER BY nomor_kontrakjualbeli DESC LIMIT 1");
									if ($id_terakhir==$rows1[id]) {
										 echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
										 echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
										 echo "</center></td>";
									}
					}elseif ($nama_database=='booking_kontrakkerja') {
								$id_terakhir=ambil_database(id,$nama_database,"tanggal LIKE '$tahun_ini%' ORDER BY nomor_kontrakkerja DESC LIMIT 1");
									if ($id_terakhir==$rows1[id]) {
										 echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
										 echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
										 echo "</center></td>";
									}
					}elseif ($nama_database=='booking_packinglist') {
								$id_terakhir=ambil_database(id,$nama_database,"tanggal LIKE '$tahun_ini%' ORDER BY nomor_packinglist DESC LIMIT 1");
									if ($id_terakhir==$rows1[id]) {
										 echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
										 echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
										 echo "</center></td>";
									}
					}elseif ($nama_database=='booking_quotationurut') {
								$id_terakhir=ambil_database(id,$nama_database,"tanggal LIKE '$tahun_ini%' ORDER BY id DESC LIMIT 1");
									if ($id_terakhir==$rows1[id]) {
										 echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
										 echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
										 echo "</center></td>";
									}
					}
					else {
								$id_terakhir=ambil_database(id,$nama_database,"tanggal LIKE '$tahun_ini%' ORDER BY surat_jalan DESC LIMIT 1");
									if ($id_terakhir==$rows1[id]) {
										 echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
										 echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
										 echo "</center></td>";
									}
					}




				}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $terjadi_revisi_khusus_spk == 'yes'){
				//echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
				//echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
				//echo "</center></td>";
				}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $nama_database != 'sales_spk'){
				//echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
				//echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_revisi'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("edit","XblImpl1!A@")."&opsi_tambahan=revisi&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/revisi.png" width="25px"/></a>';
				//echo "</center></td>";
				}else{}//echo "<td style='background-color:$color;'></td>";
				echo "</tr>";
				$no++;}
				//ISI TABEL END
				echo "</table>";//TABEl END

//PAGING KLIK
if ($total > '50') {
echo "<table>
<form method ='post' action='$address'>
<tr>
 <td>Halaman ($total)</td>
 <td>:</td>
			<td><select name='halaman'>";
if ($nomor_halaman_dokumen_proses!='') {
	echo "<option value='$nomor_halaman_dokumen_proses'>".$nomor_halaman_dokumen_proses."</option>";echo "TEST";
}
  for ($i=1; $i<=$pages; $i++){
echo "<option value='$i'>$i</option>";}
echo "</td>";
$total_halaman=$i-1;
echo "<td> / $total_halaman</td>";
		 echo "
		 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		 <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		 <td><input type='submit' value='".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END

}//END OPSI
return;}


//END?>
