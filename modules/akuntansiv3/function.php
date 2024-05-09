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

function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
return $hasil_rupiah;}

function dollar($angka){
	$hasil_rupiah = "$ " . number_format($angka,2,'.',',');//substr(number_format($angka,3,'.',','),0,-1)
return $hasil_rupiah;}

function dollar_price($angka){
$hasil_rupiah = "$ " . number_format($angka,4,'.',',');
return $hasil_rupiah;}

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function selisih_hari($tgl1,$tgl2){
	// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
	// dari tanggal pertama
	$pecah1 = explode("-", $tgl1);
	$date1 = $pecah1[2];
	$month1 = $pecah1[1];
	$year1 = $pecah1[0];
	// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
	// dari tanggal kedua
	$pecah2 = explode("-", $tgl2);
	$date2 = $pecah2[2];
	$month2 = $pecah2[1];
	$year2 =  $pecah2[0];
	// menghitung JDN dari masing-masing tanggal
	$jd1 = GregorianToJD($month1, $date1, $year1);
	$jd2 = GregorianToJD($month2, $date2, $year2);
	// hitung selisih hari kedua tanggal
	$selisih = $jd1 - $jd2;
return $selisih;}

function hari_kedepan($n,$tanggal){
	$hari=substr($tanggal, 8, 2);
	$bulan=substr($tanggal, 5, 2);
	$tahun=substr($tanggal, 0, 4);
	 // menentukan timestamp 10 hari berikutnya dari tanggal hari ini
	$nextN = mktime(0, 0, 0, date("$bulan"), date("$hari") + $n, date("$tahun"));
	// menentukan timestamp 10 hari sebelumnya dari tanggal hari ini
	//$prevN = mktime(0, 0, 0, date("m"), date("d") - $n, date("Y"));
return $nextN;}

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

function ambil_variabel_kutip_satu_where($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode("','", $datasecs);
	$hasil="'".$data."'";
return $hasil;}

function ambil_variabel_tanpa_kutip_where_distinct($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT DISTINCT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode(",", $datasecs);
	$hasil="".$data."";
return $hasil;}

function hapus($nama_database,$id,$nama_database_items,$address){

	//DELETE
	$menu_akses=ambil_database(ina,master_bahasa,"kode='".ambil_database(judul,master_menu,"url='$address'")."'");
	$waktu_akses=date('Y-m-d H:i:s');
	$ip_address=getClientIP();
	mysql_query("INSERT INTO history_login SET waktu_akses='$waktu_akses',status='Hapus Data',username='$_SESSION[username]',ip_address_akses='$ip_address',keterangan='Delete ID:$id Menu:$menu_akses'");


	$string_delete="DELETE FROM $nama_database WHERE id='$id'";
	$ekskusi=mysql_query($string_delete);

	$string_delete_items="DELETE FROM $nama_database_items WHERE induk='$id'";
	$ekskusi2=mysql_query($string_delete_items);

	if ($nama_database=='akuntansiv3_posting_master') {
		$string_delete_jurnal="DELETE FROM akuntansiv3_jurnal WHERE induk_master='$id'";
		$ekskusi3=mysql_query($string_delete_jurnal);
	}

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
	<form method ='post' action='$address'>";

	if ($pilihan_bulan_tahun!=0) {
	echo "
	<tr>
	 <td>".ambil_database($bahasa,master_bahasa,"kode='bulan'")."</td>
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
	 <td>".ambil_database($bahasa,master_bahasa,"kode='tahun'")."</td>
	 <td>:</td>";
	 echo "
	 <td><select name='pilihan_tahun'>";
	 echo "<option value='$pilihan_tahun'>$pilihan_tahun</option>";
	 $now=date('Y')+3;
	 for ($a=date('Y')-3;$a<=$now;$a++)
		{echo "<option value='".$a."'>".$a."</option>";}
		echo "</select></td>";
		}


if ($pilihan_bulan != '' OR $pilihan_tahun != '' OR $pilihan_bulan_tahun==0) {
	echo "
	</table>
	<table>
	<tr>
	<td>".ambil_database($bahasa,master_bahasa,"kode='pencarian'")."</td>
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
	 <td><input type='submit' value='".ambil_database($bahasa,master_bahasa,"kode='tampil'")."'></td>
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
		echo hapus($nama_database,$id,$nama_database_items,$address);}

	//UPDATE VALID
	if ($_POST[valid] == 'Valid') {
		mysql_query("UPDATE $nama_database SET validasi='$_POST[valid]',validasi_by='$username' WHERE id='$_POST[id]'");

		//Update PROSES untuk Purchasing
		if ($nama_database == 'deliverycl_kodebarang' OR $nama_database == 'deliverycl_packinglist' OR $nama_database == 'deliverycl_invoice') {
			mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$_POST[id]'");
		}
	}//UPDATE VALID END

//PENENTU UPDATE INSERT
					// //Sales SPK
					// if ($nama_database == 'sales_spk') {
					// 		$po_nomor=ambil_database(po_nomor,sales_po,"id='$_POST[id_po]'");
					// 		$line_batch=ambil_database(line_batch,sales_po,"id='$_POST[id_po]'");
					// 	if ($_POST['jenis'] == tambah AND $po_nomor == ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor'") AND $line_batch == ambil_database(line_batch,$nama_database,"line_batch='$line_batch'") ) {
					// 		$ijin_tambah='tidak'; $notice=ambil_database($bahasa,master_bahasa,"kode='notice1'");}
					// 	else {$ijin_tambah='yes';}
					//
					// 		$id_khusus=$_POST['id'];$nilai_line_db_with_id=ambil_database(line_batch,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch' AND id='$id_khusus'");
					// 		$nilai_line_db_not_id=ambil_database(line_batch,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'");
					// 	if ($nilai_line_db_with_id == $line_batch AND $_POST['jenis'] == edit AND $po_nomor == ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'")) {
					// 		$ijin_update='yes';}
					// 	elseif ($nilai_line_db_not_id == 0 AND $_POST['jenis'] == edit AND $po_nomor != ambil_database(po_nomor,$nama_database,"po_nomor='$po_nomor' AND line_batch='$line_batch'")) {
					// 		$ijin_update='yes';}
					// 	else {$ijin_update='tidak';$notice=ambil_database($bahasa,master_bahasa,"kode='notice1'");}
					// }//Sales SPK END

					//Sales BUkan Penentu Update
					if ($nama_database == 'akuntansiv3_persamaan' OR $nama_database == 'akuntansiv3_akun') {
						$ijin_update='yes'; $ijin_tambah='yes';
					}//Sales BUkan Penentu Update

					if ($nama_database == 'akuntansiv3_posting_master') {
						$ref=ambil_database(ref,akuntansiv3_posting_master,"id='$_POST[ref]'");
						if ($ref) {
							$ijin_update='yes'; $ijin_tambah='tidak';
						}else{
							$ijin_update='yes'; $ijin_tambah='yes';
						}
					}




//TAMPILAN NORMAL
//else{$ijin_tambah='yes';$ijin_update='yes';}
//TAMPILAN NORMAL END
//PENENTU UPDATE INSERT END

//NOTICE INPUT
if ($_POST['isian_revisi']=='revisi' AND $_POST['ket_revisi'] == ''){echo "<table style='background-color:yellow;'><tr><td>".ambil_database($bahasa,master_bahasa,"kode='notice_isian_revisi'")."</td></tr></table>";}
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
				else{$isi_kolom=$_POST[$pecah_column[$no]];}

				if ($_POST['isian_revisi']=='revisi' AND $_POST['ket_revisi'] == ''){}
				else{$update="UPDATE $nama_database SET $nama_kolom='$isi_kolom' WHERE id='$id'";
					   mysql_query($update);}

						 //EDIT DATA
		 				$datasecs_history[]=$nama_kolom.":".$isi_kolom."  ";

				$no++;}

				//insert history login
				$data_history=implode(" ", $datasecs_history);
				$waktu_akses=date('Y-m-d H:i:s');
				$ip_address=getClientIP();
				mysql_query("INSERT INTO history_login SET waktu_akses='$waktu_akses',status='Edit Data',username='$_SESSION[username]',ip_address_akses='$ip_address',keterangan='$data_history'");


				//PACKING LIST-Update
				if ($nama_database=='deliverycl_packinglist' AND $address=='?mod=financecl/packinglistpairs'){
					$no_invoice=ambil_database(no_invoice,$nama_database,"id='$id'");
						if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
							$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
							$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
						}elseif($no_invoice=='Backup') {
							$tanggal=date('Y-m-d');
							$perusahaan='-';
						}else{
							$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
							$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
						}

					$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
					$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
					$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
					$update=mysql_query("UPDATE $nama_database SET tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$id'");
				}//INVOICE

				//PACKING LIST-Update
				if ($nama_database=='akuntansiv3_posting_master'){


					//ISIAN KOLOM DARI HEADER
					$tanggal=ambil_database(tanggal,akuntansiv3_posting_master,"id='$id'");
					$kode=ambil_database(kode,akuntansiv3_posting_master,"id='$id'");
					$keterangan=ambil_database(keterangan,akuntansiv3_posting_master,"id='$id'");
					$id_persamaan=ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'");
					$persamaan=ambil_database(keterangan,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
					$debit=ambil_database(debit,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
					$kredit=ambil_database(kredit,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
					$kredit_kedua=ambil_database(kredit_kedua,akuntansiv3_persamaan,"id='".ambil_database(persamaan,akuntansiv3_posting_master,"id='$id'")."'");
					$pembuat=ambil_database(pembuat,akuntansiv3_posting_master,"id='$id'");
					$keterangan_debit=ambil_database(nama,akuntansiv3_akun,"nomor='$debit'");
					$keterangan_kredit=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit'");
					$keterangan_kredit_kedua=ambil_database(nama,akuntansiv3_akun,"nomor='$kredit_kedua'");
					$kode_keterangan_debit="$debit - $keterangan_debit";
					$kode_keterangan_kredit="$kredit - $keterangan_kredit";
					$kode_keterangan_kredit_kedua="$kredit_kedua - $keterangan_kredit_kedua";
					$jenis_kas=ambil_database(jenis_kas,akuntansiv3_posting_master,"id='$id'");
					$tanggal_input=ambil_database(tgl_dibuat,akuntansiv3_posting_master,"id='$id'");
					$kurs=ambil_database(kurs,financecl_kurs,"tanggal='$tanggal'");
					$tgl_id=date("Y-m-d h:i:sa");$ref_jurnal=preg_replace('/\D/', '', $tgl_id);
					$id_jurnal=$ref_jurnal;
					$ref=$ref_jurnal;
					//ISIAN KOLOM DARI HEADER END

					//UPDATE INTO
					mysql_query("UPDATE akuntansiv3_posting SET
						induk='$id',
						kode='$kode',
						tanggal='$tanggal',
						keterangan='$keterangan',
						id_persamaan='$id_persamaan',
						persamaan='$persamaan',
						debit='$debit',
						kredit='$kredit',
						kredit_kedua='$kredit_kedua',
						pembuat='$pembuat',
						kode_keterangan_debit='$kode_keterangan_debit',
						kode_keterangan_kredit='$kode_keterangan_kredit',
						kode_keterangan_kredit_kedua='$kode_keterangan_kredit_kedua',
						keterangan_debit='$keterangan_debit',
						keterangan_kredit='$keterangan_kredit',
						keterangan_kredit_kedua='$keterangan_kredit_kedua',
						jenis_kas='$jenis_kas',
						tanggal_input='$tanggal_input',
						id_jurnal='$id_jurnal',
						ref='$ref',
						-- jenis_doc='$jenis_doc',
						-- kontak='$kontak',
						-- tanggal_doc='$tanggal_doc',
						-- nomor_aju='$nomor_aju',
						-- invoice_faktur='$invoice_faktur',
						kurs='$kurs'
						-- nominal_debit='$nominal_debit',
						-- nominal_kredit='$nominal_kredit',
						-- nominal_kredit_kedua='$nominal_kredit_kedua',
						-- bayar='$bayar'
						WHERE induk='$id'
						");
					//UPDATE INTO END



					$no_invoice=ambil_database(no_invoice,$nama_database,"id='$id'");
					mysql_query("UPDATE akuntansiv3_posting_master SET validasi='',status='' WHERE id='$id'");
				}//INVOICE

				//PACKING LIST-Update
				if ($nama_database=='deliverycl_packinglist' AND $address=='?mod=financecl/packinglistsheetyardmeter'){
					$no_invoice=ambil_database(no_invoice,$nama_database,"id='$id'");
						if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
							$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
							$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
						}elseif($no_invoice=='Backup') {
							$tanggal=date('Y-m-d');
							$perusahaan='-';
						}else{
							$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
							$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
						}

					$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
					$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
					$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
					$update=mysql_query("UPDATE $nama_database SET tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$id'");
				}//INVOICE

				//PACKING LIST-Update
				if ($nama_database=='deliverycl_packinglist' AND $address=='?mod=financecl/packinglistpcs'){
					$no_invoice=ambil_database(no_invoice,$nama_database,"id='$id'");
						if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
							$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
							$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
						}elseif($no_invoice=='Backup') {
							$tanggal=date('Y-m-d');
							$perusahaan='-';
						}else{
							$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
							$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
						}

					$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
					$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
					$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
					$update=mysql_query("UPDATE $nama_database SET tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$id'");
				}//PACKING LIST


				//INVOICE-Update
				if ($nama_database=='deliverycl_invoice'){
					$no_invoice=ambil_database(no_invoice,$nama_database,"id='$id'");
					if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
						$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
						$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
					}elseif($no_invoice=='Backup') {
						$tanggal=date('Y-m-d');
						$perusahaan='-';
					}else{
						$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
						$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
					}

					$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
					$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
					$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
					$update=mysql_query("UPDATE $nama_database SET tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$id'");
					//echo "UPDATE $nama_database SET tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$id'";
				}//INVOICE
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

				else{$isi_kolom=$_POST[$pecah_column[$no]];}
				$datasecs[]=$pecah_column[$no]."='".$isi_kolom."'";

					//TAMBAH DATA
					$datasecs_history[]=$pecah_column[$no].":".$isi_kolom."  ";

				$no++;}
				$data=implode(",", $datasecs);
				$insert ="INSERT INTO $nama_database SET $data";
				mysql_query($insert);

		//INSERT SPESIAL
		$data2=implode(" AND ", $datasecs);

		//insert history login
		$data_history=implode(" ", $datasecs_history);
		$waktu_akses=date('Y-m-d H:i:s');
		$ip_address=getClientIP();
		mysql_query("INSERT INTO history_login SET waktu_akses='$waktu_akses',status='Tambah Data',username='$_SESSION[username]',ip_address_akses='$ip_address',keterangan='$data_history'");


		//PACKING LIST-Update
		if ($nama_database=='deliverycl_packinglist' AND $address=='?mod=financecl/packinglistpairs'){
			$ambil_id=ambil_database(id,$nama_database,$data2);
			$no_invoice=ambil_database(no_invoice,$nama_database,"id='$ambil_id'");
				if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
					$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
					$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
				}elseif($no_invoice=='Backup') {
					$tanggal=date('Y-m-d');
					$perusahaan='-';
				}else{
					$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
					$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
				}
			$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
			$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
			$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
			$jenis_satuan='PAIRS';
			$update=mysql_query("UPDATE $nama_database SET jenis_satuan='$jenis_satuan',tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$ambil_id'");
		}//INVOICE

		//PACKING LIST-Update
		if ($nama_database=='deliverycl_packinglist' AND $address=='?mod=financecl/packinglistsheetyardmeter'){
			$ambil_id=ambil_database(id,$nama_database,$data2);
			$no_invoice=ambil_database(no_invoice,$nama_database,"id='$ambil_id'");
				if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
					$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
					$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
				}elseif($no_invoice=='Backup') {
					$tanggal=date('Y-m-d');
					$perusahaan='-';
				}else{
					$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
					$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
				}
			$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
			$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
			$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
			$jenis_satuan="SHEETYARDMETER";
			$update=mysql_query("UPDATE $nama_database SET jenis_satuan='$jenis_satuan',tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$ambil_id'");
		}//INVOICE

		//PACKING LIST-Update
		if ($nama_database=='deliverycl_packinglist' AND $address=='?mod=financecl/packinglistpcs'){
			$ambil_id=ambil_database(id,$nama_database,$data2);
			$no_invoice=ambil_database(no_invoice,$nama_database,"id='$ambil_id'");
				if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
					$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
					$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
				}elseif($no_invoice=='Backup') {
					$tanggal=date('Y-m-d');
					$perusahaan='-';
				}else{
					$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
					$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
				}
			$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
			$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
			$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
			$jenis_satuan='PCS';
			$update=mysql_query("UPDATE $nama_database SET jenis_satuan='$jenis_satuan',tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$ambil_id'");
		}//INVOICE
		//END INSERT SPESIAL

		//INVOICE-Update
		if ($nama_database=='deliverycl_invoice'){
			$ambil_id=ambil_database(id,$nama_database,$data2);
			$no_invoice=ambil_database(no_invoice,$nama_database,"id='$ambil_id'");
			if (ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'")=='' AND $no_invoice!='Backup') {
				$tanggal=ambil_database(tanggal,booking_invoice_turetur,"no_invoice='$no_invoice'");
				$perusahaan=ambil_database(dari,booking_invoice_turetur,"no_invoice='$no_invoice'");
			}elseif($no_invoice=='Backup') {
				$tanggal=date('Y-m-d');
				$perusahaan='-';
			}else{
				$tanggal=ambil_database(tanggal,booking_invoice,"no_invoice='$no_invoice'");
				$perusahaan=ambil_database(dari,booking_invoice,"no_invoice='$no_invoice'");
			}

			$alamat=ambil_database(alamat,booking_perusahaan,"perusahaan='$perusahaan'");
			$paymen_term=ambil_database(paymen_term,booking_perusahaan,"perusahaan='$perusahaan'");
			$tanggal_tutup_buku=ambil_database(tanggal_tutup_buku,booking_perusahaan,"perusahaan='$perusahaan'");
			$update=mysql_query("UPDATE $nama_database SET tanggal='$tanggal',perusahaan='$perusahaan',alamat='$alamat',paymen_term='$paymen_term',tanggal_tutup_buku='$tanggal_tutup_buku' WHERE id='$ambil_id'");
		}//INVOICE

		//FINANCE-Update
		if ($nama_database=='financecl_kurs'){
				$ambil_id=ambil_database(id,$nama_database,$data2);

				$tanggal=ambil_database(tanggal,$nama_database,"id='$ambil_id'");
				$tanggal_tujuan=ambil_database(tanggal_tujuan,$nama_database,"id='$ambil_id'");
				$kurs=ambil_database(kurs,$nama_database,"id='$ambil_id'");
				$pembuat=ambil_database(pembuat,$nama_database,"id='$ambil_id'");
				$tgl_dibuat=ambil_database(tgl_dibuat,$nama_database,"id='$ambil_id'");

				$selisih_hari=selisih_hari($tanggal_tujuan,$tanggal);
				$no=1;for($i=0; $i < $selisih_hari; ++$i){

					$tanggal_terurut=date("Y-m-d", hari_kedepan($no,$tanggal));
					$hari=ambilhari($tanggal_terurut);

						if (ambil_database(tanggal,$nama_database,"tanggal='$tanggal_terurut'")=='') {
							mysql_query("INSERT INTO financecl_kurs SET tanggal='$tanggal_terurut',kurs='$kurs',pembuat='$pembuat',tgl_dibuat='$tgl_dibuat'");
						}
				$no++;}
		}//FINANCE

if ($nama_database == 'akuntansiv3_posting_master') {
	$ambil_id=ambil_database(id,$nama_database,$data2);
	 echo "<script type='text/javascript'>window.location.href='$address&id=".base64_encrypt($ambil_id,"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'</script>";}

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

			$sql3="SELECT $bahasa,kode FROM master_bahasa WHERE kode='$pecah_column[$no]'";
			$result3=mysql_query($sql3);
			$rows3=mysql_fetch_array($result3);
			echo "<tr>";
			//HEADER
			echo "<td id='kolom_isi_th'><strong>".$rows3[$bahasa]."</strong></td>";
			//HEADER END

		$sql3="SELECT $bahasa,kode FROM master_bahasa WHERE kode='$pecah_column[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);

		if ($pecah_column[$no] == 'id' OR $pecah_column[$no] == 'pembuat' OR $pecah_column[$no] == 'tgl_dibuat'){$disabled='readonly';}else{$disabled='';}
		if ($pecah_column[$no] == 'tanggal_faktur' OR $pecah_column[$no] == 'tanggal_tujuan' OR $pecah_column[$no] == 'tanggal' OR $pecah_column[$no] == 'etd' OR $pecah_column[$no] == 'tanggal_revisi' OR $pecah_column[$no] == 'bucket_stage' OR $pecah_column[$no] == 'tanggal_kirim' OR $pecah_column[$no] == 'tanggal_batas'){$format_tgl="class='date' required";}else{$format_tgl="";}

if ($pecah_column[$no] == 'dari'){
$sql113="SELECT * FROM booking_perusahaan WHERE validasi='Valid' AND code_perusahaan='CUSTOMER' ORDER BY perusahaan";
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
//REF DAN TGL INPUT
elseif ($pecah_column[$no] == 'ref'){
	$tgl_id=date("Y-m-d h:i:sa");
	$id_ke_jurnal = preg_replace('/\D/', '', $tgl_id);

if ($rows5[$pecah_column[$no]]=='') {
	$isian_ref=$id_ke_jurnal;
}else {
	$isian_ref=$rows5[$pecah_column[$no]];
}
echo "<input type='hidden' name='$pecah_column[$no]' value='$isian_ref'>";
echo "<td><input type='text' name='disabled' value='$isian_ref' disabled></td>";
}
//KEPADA
elseif ($pecah_column[$no] == 'kepada'){
$sql113="SELECT * FROM booking_perusahaan WHERE validasi='Valid' AND code_perusahaan='SUPPLIER' ORDER BY perusahaan";
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
//kelompok
elseif ($pecah_column[$no] == 'kelompok'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]' style='width:100%;'>

<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";

echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";
echo " <option value='Aktiva'>Aktiva</option>
			 <option value='Passiva'>Passiva</option>
			 <option value='Ekuitas'>Ekuitas</option>
			 <option value='Pendapatan'>Pendapatan</option>
			 <option value='Beban'>Beban</option>
			 <option value='Aktiva Lancar'>Aktiva Lancar</option>
			 <option value='Penjualan'>Penjualan</option>
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
			 <option value='Prive/Dividen'>Prive/Dividen</option>";
echo "
</select>
</td>";
}
//status
elseif ($pecah_column[$no] == 'status' AND $nama_database=='akuntansiv3_persamaan'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]' style='width:100%;'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo " <option value='tampil'>tampil</option>
			 <option value='sembunyi'>sembunyi</option>";
echo "
</select>
</td>";
}
//jenis_kas
elseif ($pecah_column[$no] == 'jenis_kas'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]' style='width:100%;'>

<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";

echo "<option value='$rows113[perusahaan]'>$rows113[perusahaan]</option>";
echo " <option value='Pembelian'>Pembelian</option>
			 <option value='Penjualan'>Penjualan</option>
			 <option value='KAS CL TECHNO DOLLAR'>KAS CL TECHNO DOLLAR</option>
			 <option value='KAS CL TECHNO'>KAS CL TECHNO</option>
			 <option value='KAS SL TECHNO'>KAS SL TECHNO</option>
			 <option value='KAS CL INDUSTRI'>KAS CL INDUSTRI</option>
			 <option value='KAS SL INDUSTRI'>KAS SL INDUSTRI</option>
			 <option value='PPN MASUKAN'>PPN MASUKAN</option>
			 <option value='PPN KELUARAN'>PPN KELUARAN</option>
			 <option value='PPH'>PPH</option>
			 <option value='Kas MESH'>Kas MESH</option>
			 <option value='KAS BESAR CL BANK CT USD - 102028100272002'>KAS BESAR CL BANK CT USD - 102028100272002</option>
			 <option value='KAS BESAR CL BANK CT IDR - 102018100272001'>KAS BESAR CL BANK CT IDR - 102018100272001</option>
			 <option value='KAS BESAR SL BANK CT USD - 102018100272004'>KAS BESAR SL BANK CT USD - 102018100272004</option>
			 <option value='KAS BESAR SL BANK CT IDR - 102018100272003'>KAS BESAR SL BANK CT IDR - 102018100272003</option>
			 <option value='KAS BESAR BCA - 764051996'>KAS BESAR BCA - 764051996</option>
			 <option value='KAS BESAR BANK BCA IDR - 7641569996'>KAS BESAR BANK BCA IDR - 7641569996</option>
			 <option value='KAS BESAR BANK BNI - 2014012916'>KAS BESAR BANK BNI - 2014012916</option>
			 <option value='KAS BESAR CL BANK CT USD - 2020837701'>KAS BESAR CL BANK CT USD - 2020837701</option>
			 <option value='KAS BESAR SL BANK CT USD - 2010837705'>KAS BESAR SL BANK CT USD - 2010837705</option>
			 <option value='KAS BESAR CL BANK CT IDR - 1020837701'>KAS BESAR CL BANK CT IDR - 1020837701</option>
			 <option value='KAS BESAR SL BANK CT IDR - 1010837705'>KAS BESAR SL BANK CT IDR - 1010837705</option>
			 <option value='BAHAN BAKU GUDANG'>BAHAN BAKU GUDANG</option>
			 <option value='BAHAN BAKU GUDANG CAMPURAN'>BAHAN BAKU GUDANG CAMPURAN</option>
			 <option value='BARANG JADI'>BARANG JADI</option>
			 <option value='BARANG SETENGAH JADI'>BARANG SETENGAH JADI</option>
			 <option value='PENGECEKAN (BC 27 MASUK)'>PENGECEKAN (BC 27 MASUK)</option>";
echo "
</select>
</td>";
}
//Satuan
elseif ($pecah_column[$no] == 'satuan') {
	$sql113="SELECT * FROM referensi_satuan_ppiccl ORDER BY kode_satuan";
	$result113=mysql_query($sql113);
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
		while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[kode_satuan]'>$rows113[kode_satuan] - $rows113[uraian_satuan]</option>";}
	echo "
	</select>
	</td>";
}
//Persamaan
elseif ($pecah_column[$no] == 'persamaan') {
	$sql113="SELECT * FROM akuntansiv3_persamaan";
	$result113=mysql_query($sql113);
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]' style='width:450px;'>
	<option value='".$rows5[$pecah_column[$no]]."'>".ambil_database(kelompok,akuntansiv3_persamaan,"id='".$rows5[$pecah_column[$no]]."'")." | ".ambil_database(keterangan,akuntansiv3_persamaan,"id='".$rows5[$pecah_column[$no]]."'")."</option>";
		while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[id]'>$rows113[kelompok] - $rows113[keterangan]</option>";}
	echo "
	</select>
	</td>";
}
//debit
elseif ($pecah_column[$no] == 'debit' OR $pecah_column[$no] == 'kredit' OR $pecah_column[$no] == 'kredit_kedua') {
	$sql113="SELECT * FROM akuntansiv3_akun WHERE master NOT LIKE 'ya' ORDER BY id";
	$result113=mysql_query($sql113);
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]' style='width:450px;'>
	<option value='".$rows5[$pecah_column[$no]]."'>".ambil_database(kelompok,akuntansiv3_akun,"nomor='".$rows5[$pecah_column[$no]]."'")." | ".ambil_database(nomor,akuntansiv3_akun,"nomor='".$rows5[$pecah_column[$no]]."'")." | ".ambil_database(nama,akuntansiv3_akun,"nomor='".$rows5[$pecah_column[$no]]."'")."</option>";
		while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[nomor]'>$rows113[nomor] | $rows113[nama]</option>";}
	echo "
	</select>
	</td>";
}
//No Invoice
elseif ($pecah_column[$no] == 'no_invoice') {
	$no_invoice_terpakai=ambil_variabel_kutip_satu_where(deliverycl_packinglist,no_invoice,"");
	$sql113="SELECT * FROM booking_invoice WHERE tanggal > '2021-01-01' AND no_invoice NOT IN ($no_invoice_terpakai) ORDER BY tanggal";
	$result113=mysql_query($sql113);
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "
	<option value='Backup'>Backup</option>";
		while ($rows113=mysql_fetch_array($result113)) {
	echo "<option value='$rows113[no_invoice]'>$rows113[tanggal] | $rows113[no_invoice] | $rows113[dari]</option>";}

	$sql114="SELECT * FROM booking_invoice_turetur WHERE tanggal > '2021-04-01' AND no_invoice NOT IN ($no_invoice_terpakai) ORDER BY tanggal";
	$result114=mysql_query($sql114);
		while ($rows114=mysql_fetch_array($result114)) {
	echo "<option value='$rows114[no_invoice]'>$rows114[tanggal] | $rows114[no_invoice] | $rows114[dari]</option>";}

	echo "
	</select>
	</td>";
}
//NOMOR FAKTUR
elseif ($pecah_column[$no] == 'nomor_faktur') {
		echo "<td><input type='text' minlength='13' maxlength='13' name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."''></td>";
}
//Alamat
elseif ($pecah_column[$no] == 'master' AND $nama_database=='akuntansiv3_akun') {
	echo "<td>";
	if ($rows5[$pecah_column[$no]]=='ya'){$checked='checked';}else{$checked='';}
	echo "<input type='checkbox' name='$pecah_column[$no]' value='ya' $checked>";
echo "</td>";
}
//Alamat
elseif ($pecah_column[$no] == 'alamat') {
		echo "<td><textarea name='$pecah_column[$no]' rows='3' cols='30'>".$rows5[$pecah_column[$no]]."</textarea></td>";
}
//PEMBEDA NERACA
elseif ($pecah_column[$no] == 'pembeda_neraca') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value=''></option>";
	echo "<option value='Aset lancar'>Aset lancar</option>";
	echo "<option value='Aset Tetap'>Aset Tetap</option>";
	echo "<option value='Aset Lainnya'>Aset Lainnya</option>";
	echo "<option value='Kewajiban Lancar'>Kewajiban Lancar</option>";
	echo "<option value='Hutang Jangka Panjang'>Hutang Jangka Panjang</option>";
	echo "<option value='Ekuitas'>Ekuitas</option>";
	echo "
	</select>
	</td>";
}
//PEMBEDA LABA RUGI
elseif ($pecah_column[$no] == 'pembeda_laba_rugi') {
	echo "<td>
	<select class='comboyuk' name='$pecah_column[$no]'>
	<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
	echo "<option value=''></option>";
	echo "<option value='Total Pendapatan'>Total Pendapatan</option>";
	echo "<option value='Total Biaya Langsung'>Total Biaya Langsung</option>";
	echo "<option value='Total Biaya Tidak Langsung'>Total Biaya Tidak Langsung</option>";
	echo "<option value='Total Biaya Operasional'>Total Biaya Operasional</option>";
	echo "<option value='Total Biaya Umum dan Administrasi'>Total Biaya Umum dan Administrasi</option>";
	echo "<option value='Total PENDAPATAN LAINNYA'>Total PENDAPATAN LAINNYA</option>";
	echo "<option value='Total BIAYA LAINNYA'>Total BIAYA LAINNYA</option>";
	echo "<option value='Laba Setelah Pajak Penghasilan'>Laba Setelah Pajak Penghasilan</option>";
	echo "
	</select>
	</td>";
}
//ket_revisi
elseif ($pecah_column[$no] == 'ket_revisi') {
		echo "<input type='hidden' name='isian_revisi' value='$opsi_tambahan'>";
	if ($opsi_tambahan == 'revisi') {
		echo "<td><textarea name='$pecah_column[$no]' rows='3' cols='30'>".$rows5[$pecah_column[$no]]."</textarea></td>";
	}else {
		echo "<td><input type='hidden' name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</td>";
	}
}
//TAMPILAN SEBENARNYA
else{
echo "<td><input type='text' $format_tgl name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."' $disabled style='width:95%; border-radius:4px; text-align:center;' autocomplete='off' required></td>";
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


}else{//START ELSE OPSI ke TAMPILAN UTAMA
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


//menampilkan data duplikat
$no=0;
$query_duplikat=mysql_query("SELECT nomor, COUNT(*) duplikat FROM akuntansiv3_akun GROUP BY nomor HAVING COUNT(duplikat) > 1");
while($result_duplikat=mysql_fetch_array($query_duplikat)){
	if ($result_duplikat[nomor]) {
		echo "<h4 style='background-color:yellow; width:200px;'>Terjadi Duplikat Data di Nomor $result_duplikat[nomor]</h4>";
	}
}//menampilkan data duplikat


				echo "<table class='tabel_utama' style='width:auto;'>";
				//HEADER TABEL
				echo "<thead>";
					echo "<th style=''><strong>No</strong></th>";
			$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
					$sql3="SELECT $bahasa,kode FROM pusat_bahasa WHERE kode='$pecah_column_header[$no]'";
					$result3=mysql_query($sql3);
					$rows3=mysql_fetch_array($result3);

					//NOMOR jadi AKUN
					if ($pecah_column_header[$no]=='nomor' AND $nama_database=='akuntansiv3_akun') {
						echo "<th><strong>Kode Akun</strong></th>";
					}
					//Tampilan Normal
					else {
						echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
					}


			$no++;}
					//echo "<th colspan='3' style=''><strong>".ambil_database($bahasa,master_bahasa,"kode='valid'")."</strong></th>";
					if ($nama_database=='akuntansiv3_faktur_masukkan' OR $nama_database=='akuntansiv3_persamaan' OR $nama_database=='akuntansiv3_posting_master' OR $nama_database=='akuntansiv3_akun'OR $nama_database=='deliverycl_invoice' OR $nama_database=='akuntansiv3_jurnal') {
						echo "<th colspan='3' style=''><strong>".ambil_database($bahasa,pusat_bahasa,"kode='Opsi'")."</strong></th>";
					}

				echo "</thead>";
				//HEADER END

				//ISI TABEL
				if ($pilihan_bulan_tahun==0) {$if_tahun_bulan="tanggal NOT LIKE ''";}else{$if_tahun_bulan="tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'";}
				if ($pencarian) {$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
				if ($address=='?menu=home&mod=akuntansiv3/akun') {$order_by="nomor,id";}else{$order_by="tanggal,id";}


//PAGING
$halaman = 50;
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT	* FROM $nama_database WHERE $if_tahun_bulan $if_pencarian ");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT	* FROM $nama_database WHERE $if_tahun_bulan $if_pencarian ORDER BY $order_by ASC LIMIT $mulai, $halaman")or die(mysql_error);
$no =$mulai+1;
//PAGING
				while ($rows1=mysql_fetch_array($query)){
				$warnaGenap="white";$warnaGanjil="#CEF6F5";if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}
				echo "<tr>";
				echo "<td style='background-color:$color; height:25px;'>$no</td>";
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
				elseif ($pecah_column_header[$no_items]=='amount_rp' OR $pecah_column_header[$no_items]=='ppn' OR $pecah_column_header[$no_items]=='dipungut_dpp' OR $pecah_column_header[$no_items]=='dipungut_ppn' OR $pecah_column_header[$no_items]=='tidak_dipungut_dpp' OR $pecah_column_header[$no_items]=='tidak_dipungut_ppn' OR $pecah_column_header[$no_items]=='nilai' OR $pecah_column_header[$no_items]=='hasil') {
					echo "<td style='white-space:nowrap; background-color:$color;'>".rupiah($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN TABEL - HARGA SATUAN USD - PO
				elseif ($pecah_column_header[$no_items]=='price_usd') {
					echo "<td style='background-color:$color;'>".dollar($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN TABEL - HARGA SATUAN RP - PO
				elseif ($pecah_column_header[$no_items]=='price_rp') {
					echo "<td style='background-color:$color;'>".rupiah($rows1[$pecah_column_header[$no_items]])."</td>";
				}
				//TAMPILAN TABEL - HARGA SATUAN RP - PO
				elseif ($pecah_column_header[$no_items]=='persamaan') {
					echo "<td style='background-color:$color;'>".ambil_database(kelompok,akuntansiv3_persamaan,"id='".$rows1[$pecah_column_header[$no_items]]."'")." | ".ambil_database(keterangan,akuntansiv3_persamaan,"id='".$rows1[$pecah_column_header[$no_items]]."'")."</td>";
				}
        //TAMPILAN NORMAT TABEL
				else {
					echo "<td style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
				}
				$no_items++;}


				//ISI PEMBEDA VALID DAN STATUS
					if ($validasi=='NOT SHOW' AND $rows1[validasi] == '') {
							echo "<td colspan='3' style='background-color:$color;'>";
							echo '<form method="POST" action="'.$address.'" onsubmit="return confirm(\''.ambil_database($bahasa,master_bahasa,"kode='notice_valid'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\');">';
							echo "<input type='submit' name='valid' value='Valid'>
										<input type='hidden' name='halaman' value='$nomor_halaman'>
										<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
										<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
										<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
										<input type='hidden' name='pencarian' value='$pencarian'>
										<input type='hidden' name='id' value='$rows1[id]'></form>";
						echo "</td>";
					}else{
						//echo "<td colspan='3' style='background-color:$color;'><strong>$rows1[validasi] by $rows1[validasi_by]</strong></td>";
					}
				//ISI PEMBEDA VALID DAN STATUS



				//OPSI
//				if ($rows1[validasi] == 'NOT SHOW') {
	//akuntansiv3_faktur_masukkan
						if ($nama_database == 'akuntansiv3_persamaan' OR $nama_database == 'akuntansiv3_akun' OR $nama_database == 'akuntansiv3_posting_master' AND ambil_database(status,$nama_database,"id='$rows1[id]'")!='Selesai'){
							echo "<td style='text-align: center; background-color: white; border-top-left-radius: 10px; border-bottom-left-radius: 10px;'><center>";
							echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("edit","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/edit.png' width='25px'/></a>";
							echo "</td>";}else{}
//			 }else{}//echo "<td style='width:10 background-color:$color;'></td>";

				if ($nama_database == 'akuntansiv3_posting_master' OR $nama_database == 'deliverycl_invoice'){
					echo "<td style='text-align: center; background-color: white;'><center>";
					echo "<a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/item.png' width='25px'/></a>";
					echo "</td>";
				}else{}

				if ($rows1[validasi] == 'NOT SHOW' OR $nama_database == 'akuntansiv3_faktur_masukkan' OR $nama_database=='akuntansiv3_persamaan' OR $nama_database == 'akuntansiv3_posting_master'  OR $nama_database == 'akuntansiv3_jurnal' AND ambil_database(status,$nama_database,"id='$rows1[id]'")!='Selesai' OR $nama_database == 'akuntansiv3_akun') {
							if ($nama_database == 'akuntansiv3_faktur_masukkan' OR $nama_database == 'akuntansiv3_persamaan' OR $nama_database == 'akuntansiv3_posting_master' OR $nama_database == 'akuntansiv3_akun' OR $nama_database == 'akuntansiv3_jurnal'){
									echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
									echo '<a onclick="return confirm(\''."Delete?".'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
									echo "</center></td>";}else{}
							}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $terjadi_revisi_khusus_spk == 'yes'){
							if ($nama_database == 'deliverycl_invoice'){}else{
									echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
									echo '<a onclick="return confirm(\''.ambil_database($bahasa,master_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
									echo "</center></td>";}
							}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $nama_database != 'deliverycl_invoice'){
				echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
				echo '<a onclick="return confirm(\''.ambil_database($bahasa,master_bahasa,"kode='notice_revisi'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("edit","XblImpl1!A@")."&opsi_tambahan=revisi&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/revisi.png" width="25px"/></a>';
				echo "</center></td>";}else{}//echo "<td style='background-color:$color;'></td>";
				echo "</tr>";
				$no++;}
				//ISI TABEL END
				echo "</table>";//TABEl END

//PAGING KLIK
if ($total > '50') {
echo "<table>
<form method ='post' action='$address'>
<tr>
 <td>Total Data($total) | </td>
 <td>Halaman</td>
 <td>:</td>
			<td><select name='halaman'>
			<option value='$nomor_halaman'>".$nomor_halaman."</option>";
  for ($i=1; $i<=$pages; $i++){
echo "<option value='$i'>$i</option>";}
echo "</td>";
echo "<td> / $pages</td>";
		 echo "
		 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		 <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		 <td><input type='submit' value='".ambil_database($bahasa,master_bahasa,"kode='tampil'")."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END

}//END OPSI
return;}


//END?>
