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

function rupiah_tanpa_rp($angka){
$hasil_rupiah = "" . number_format($angka,0,'','.');
return $hasil_rupiah;}

function dollar($angka){
$hasil_rupiah = "$ " . number_format($angka,3,',','.');
return $hasil_rupiah;}

function ambil_database($kolom,$database,$where){
	$sql="SELECT $kolom FROM $database WHERE $where";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$kolom];}

function ambil_variabel_tanpa_kutip_where($nama_database,$kolom,$where) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database $where");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode(",", $datasecs);
	$hasil="".$data."";
return $hasil;}

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

	if($nama_database=='admin_purchasing'){
		$target="modules/admincls/gambarqrcode/$id-PURCHASING.png";
		if (file_exists($target)){unlink($target);}}

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
		echo hapus($nama_database,$id,$nama_database_items);}

	//UPDATE VALID
	if ($_POST[valid] == 'Valid') {
		mysql_query("UPDATE $nama_database SET validasi='$_POST[valid]',validasi_by='$username' WHERE id='$_POST[id]'");

		//Update PROSES untuk Purchasing
		if ($nama_database == 'booking_invoice' OR $nama_database == 'booking_invoice_turetur' OR $nama_database == 'booking_surat_jalan') {
			mysql_query("UPDATE $nama_database SET status='Selesai' WHERE id='$_POST[id]'");
		}
	}//UPDATE VALID END


//PENENTU UPDATE INSERT
					 //Sales SPK
				 if ($address == '?mod=aplikasipph/Gaji' AND $nama_database=='aplikasipph_gaji') {

					 $id_post=$_POST['id'];
					 $nik=$_POST['nik'];
					 $ambil_tahun=substr($_POST['tanggal'],0,4);

					 $penentu=ambil_database(id,$nama_database,"tanggal LIKE '$ambil_tahun-%' AND nik='$nik'");
					 if ($penentu=='') {
						 $ijin_tambah='yes';
					 }else {
						 $ijin_tambah='yes'; $notice="Data sudah pernah di input di tahun ini";
					 }

					 $penentu2=ambil_database(nik,$nama_database,"id='$_POST[id]'");
					 $ambil_variabel=ambil_variabel_tanpa_kutip_where($nama_database,nik,"WHERE nik NOT IN ('$penentu2') AND tanggal LIKE '$ambil_tahun-%'");
					 $pecah_penentu_update=explode (",",$ambil_variabel);
					 $jumlah_penentu_update=count($pecah_penentu_update);
							 $no=0;for($i=0; $i < $jumlah_penentu_update; ++$i){
								 if ($pecah_penentu_update[$no]==$_POST[nik]){$nilai=1;}else{$nilai=0;}
								 $total_nilai=$nilai+$total_nilai;
							 $no++;}
					 if ($total_nilai>=1) {
						 $ijin_update='yes'; $notice="Data sudah ada di tahun ini";
					 }else {
						 $ijin_update='yes';
					 }
				 }


if ($nama_database=='aplikasipph_entry' OR $address=='?mod=aplikasipph/rumus' AND $nama_database=='aplikasipph_gaji') {
		$ijin_update='yes'; $ijin_tambah='yes';
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

				//RUMUS GAJI-update
				if ($nama_database=='aplikasipph_gaji' AND $address=='?mod=aplikasipph/rumus'){

					$awal_perolehan=ambil_database(dari_bulan,$nama_database,"id='$id'");
					$akhir_perolehan=ambil_database(sampai_bulan,$nama_database,"id='$id'");

					$no_pensiunan_atau_jht=$awal_perolehan;for($i_pensiunan_atau_jht=0; $i_pensiunan_atau_jht < $akhir_perolehan; ++$i_pensiunan_atau_jht){$pensiunan_atau_jht=$_POST["gaji$no_pensiunan_atau_jht"]+$pensiunan_atau_jht; $no_pensiunan_atau_jht++;}
					$no_premi_asuransi=$awal_perolehan;for($i_premi_asuransi=0; $i_premi_asuransi < $akhir_perolehan; ++$i_premi_asuransi){$premi_asuransi=$_POST["premi$no_premi_asuransi"]+$premi_asuransi; $no_premi_asuransi++;}
					$no_iuran_pensiun=$awal_perolehan;for($i_iuran_pensiun=0; $i_iuran_pensiun < $akhir_perolehan; ++$i_iuran_pensiun){$iuran_pensiun=$_POST["iuran$no_iuran_pensiun"]+$iuran_pensiun; $no_iuran_pensiun++;}
					$penghasilan_bruto_teratur=$pensiunan_atau_jht+$_POST['tunjangan_pph']+$_POST['tunjangan_lainnya']+$_POST['honarium']+$premi_asuransi+$_POST['natura_pph21'];
					$jumlah_penghasilan_teratur_tidakteratur=$penghasilan_bruto_teratur+$_POST['bonus_thr'];
					$penghasilan_bruto=$jumlah_penghasilan_teratur_tidakteratur;
					$biaya_jabatan1_penentu=$penghasilan_bruto*5/100; if($biaya_jabatan1_penentu > 6000000){$biaya_jabatan1=6000000;}else{$biaya_jabatan1=$biaya_jabatan1_penentu;}
					$jumlah_pengurang=$iuran_pensiun+$biaya_jabatan1;
					$penghasilan_netto=$penghasilan_bruto-$jumlah_pengurang;
					$ptkp=ambil_database(setahun,aplikasipph_ptkp,"status='".ambil_database(status_ptkp,$nama_database,"id='$id'")."'");
					$penghasilan_kena_pajak_penentu=$penghasilan_netto+$_POST['penghasilan_netto_sebelumnya']-$ptkp; if($penghasilan_kena_pajak_penentu < 0){$penghasilan_kena_pajak=0;}else {$penghasilan_kena_pajak=$penghasilan_kena_pajak_penentu;}

					$pkp_rumus=$penghasilan_netto-$ptkp;
							if ($pkp_rumus <= 0){$pkp_rumus2=0;}else{$pkp_rumus2=floor($pkp_rumus);}
							if($pkp_rumus2 <= '50000000'){$pph_terutang=$pkp_rumus2*5/100;}
							if($pkp_rumus2 > '50000000' AND $pkp_rumus2 <= '250000000'){$pph_terutang=$pkp_rumus2*15/100;}
							if($pkp_rumus2 > '250000000' AND $pkp_rumus2 <= '500000000'){$pph_terutang=$pkp_rumus2*25/100;}
							if($pkp_rumus2 > '500000000'){$pph_terutang=$pkp_rumus2*30/100;}


					mysql_query("UPDATE $nama_database SET pensiunan_atau_jht='$pensiunan_atau_jht',premi_asuransi='$premi_asuransi',iuran_pensiun='$iuran_pensiun',penghasilan_bruto_teratur='$penghasilan_bruto_teratur',jumlah_penghasilan_teratur_tidakteratur='$jumlah_penghasilan_teratur_tidakteratur',
						 																 penghasilan_bruto='$penghasilan_bruto',biaya_jabatan1='$biaya_jabatan1',jumlah_pengurang='$jumlah_pengurang',penghasilan_netto='$penghasilan_netto',penghasilan_netto_setahun='$penghasilan_netto',
																						 ptkp='$ptkp',penghasilan_kena_pajak='$penghasilan_kena_pajak',pph_terutang='$pph_terutang'
																						 WHERE id='$id'");
				}//RUMUS GAJI

				//RUMUS GAJI-update
				if ($nama_database=='aplikasipph_gaji' AND $address=='?mod=aplikasipph/Gaji'){

					$dari_bulan=ambil_database(bulan_mulai_menerima_penghasilan,$nama_database,"id='$id'");
					$sampai_bulan=ambil_database(bulan_terakhir_menerima_penghasilan,$nama_database,"id='$id'");

					mysql_query("UPDATE $nama_database SET dari_bulan='$dari_bulan',sampai_bulan='$sampai_bulan' WHERE id='$id'");
				}//RUMUS GAJI

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
				$datasecs[]=$pecah_column[$no]."='".$isi_kolom."'";$no++;}
				$data=implode(",", $datasecs);
				$insert ="INSERT INTO $nama_database SET $data";
				mysql_query($insert);

		//INSERT SPESIAL
		$data2=implode(" AND ", $datasecs);

		//RUMUS GAJI-update
		if ($nama_database=='aplikasipph_gaji' AND $address=='?mod=aplikasipph/Gaji'){
			$ambil_id=ambil_database(id,$nama_database,$data2);

			$dari_bulan=ambil_database(bulan_mulai_menerima_penghasilan,$nama_database,"id='$ambil_id'");
			$sampai_bulan=ambil_database(bulan_terakhir_menerima_penghasilan,$nama_database,"id='$ambil_id'");

			mysql_query("UPDATE $nama_database SET dari_bulan='$dari_bulan',sampai_bulan='$sampai_bulan' WHERE id='$ambil_id'");
		}//RUMUS GAJI

if ($nama_database == 'sales_mastermodel' OR $nama_database == 'sales_po' OR $nama_database == 'sales_spk' OR $nama_database == 'admin_purchasing') {
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

		if ($pecah_column[$no] == 'id' OR $pecah_column[$no] == 'pembuat' OR $pecah_column[$no] == 'tgl_dibuat'  OR $pecah_column[$no] == 'no_invoice' OR $pecah_column[$no] == 'surat_jalan' OR $pecah_column[$no] == 'departement'){$disabled='readonly';}else{$disabled='';}

		if ($pecah_column[$no] == 'tanggal' OR $pecah_column[$no] == 'etd' OR $pecah_column[$no] == 'tanggal_revisi' OR $pecah_column[$no] == 'bucket_stage'  OR $pecah_column[$no] == 'tanggal_kirim' OR $pecah_column[$no] == 'tanggal_bukti' OR $pecah_column[$no] == 'tanggal_pembuatan_spt'){$format_tgl="class='date' required";}else{$format_tgl="";}

if ($pecah_column[$no] == 'dari'){
$sql113="SELECT * FROM booking_perusahaan ORDER BY perusahaan";
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
echo "<option value='TU'>TU - TIDAK UANG</option>";
echo "
</select>
</td>";
}
//jenis kelamin
elseif ($pecah_column[$no] == 'jenis_kelamin'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='LAKI-LAKI'>LAKI-LAKI</option>";
echo "<option value='PEREMPUAN'>PEREMPUAN</option>";
echo "
</select>
</td>";
}
//STATUS PEGAWAI
elseif ($pecah_column[$no] == 'status_pegawai'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='TETAP'>TETAP</option>";
echo "<option value='TIDAK TETAP'>TIDAK TETAP</option>";
echo "
</select>
</td>";
}
//KARYAWAN ASING
elseif ($pecah_column[$no] == 'karyawan_asing'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='Y'>Y</option>";
echo "<option value='N'>N</option>";
echo "
</select>
</td>";
}
//KETERANGAN EVALUASI
elseif ($pecah_column[$no] == 'keterangan_evaluasi'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='Aktif'>Aktif</option>";
echo "<option value='Keluar'>Keluar</option>";
echo "
</select>
</td>";
}
//STATUS PEGAWAI
elseif ($pecah_column[$no] == 'bulan_mulai_menerima_penghasilan' OR $pecah_column[$no] == 'bulan_terakhir_menerima_penghasilan'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
// echo "<option value='Januari'>Januari</option>";
// echo "<option value='Februari'>Februari</option>";
// echo "<option value='Maret'>Maret</option>";
// echo "<option value='April'>April</option>";
// echo "<option value='Mei'>Mei</option>";
// echo "<option value='Juni'>Juni</option>";
// echo "<option value='Juli'>Juli</option>";
// echo "<option value='Agustus'>Agustus</option>";
// echo "<option value='September'>September</option>";
// echo "<option value='Oktober'>Oktober</option>";
// echo "<option value='November'>November</option>";
// echo "<option value='Desember'>Desember</option>";
echo "<option value='1'>1</option>";
echo "<option value='2'>2</option>";
echo "<option value='3'>3</option>";
echo "<option value='4'>4</option>";
echo "<option value='5'>5</option>";
echo "<option value='6'>6</option>";
echo "<option value='7'>7</option>";
echo "<option value='8'>8</option>";
echo "<option value='9'>9</option>";
echo "<option value='10'>10</option>";
echo "<option value='11'>11</option>";
echo "<option value='12'>12</option>";
echo "
</select>
</td>";
}
//Status PTKP
elseif ($pecah_column[$no] == 'status_ptkp'){
echo "<td>
<select class='comboyuk' name='$pecah_column[$no]'>
<option value='".$rows5[$pecah_column[$no]]."'>".$rows5[$pecah_column[$no]]."</option>";
echo "<option value='TK/0'>TK/0</option>";
echo "<option value='TK/1'>TK/1</option>";
echo "<option value='TK/2'>TK/2</option>";
echo "<option value='TK/3'>TK/3</option>";
echo "<option value='K/0'>K/0</option>";
echo "<option value='K/1'>K/1</option>";
echo "<option value='K/2'>K/2</option>";
echo "<option value='K/3'>K/3</option>";
echo "<option value='K/I/0'>K/I/0</option>";
echo "<option value='K/I/1'>K/I/1</option>";
echo "<option value='K/I/2'>K/I/2</option>";
echo "<option value='K/I/3'>K/I/3</option>";
echo "
</select>
</td>";
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
//BOOKING INVOICE - TOTAL DOKUMEN
elseif($pecah_column[$no] == 'total_dokumen'){
echo "<td>";
echo "<input type='number' name='total_dokumen' value=''>";
echo "</td>";
}
//BOOKING INVOICE - TOTAL DOKUMEN
elseif($pecah_column[$no] == 'jumlah_anak'){
echo "<td>";
echo "<input type='number' name='$pecah_column[$no]' value='".$rows5[$pecah_column[$no]]."'>";
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

echo "<table>";
echo "<tr>";
if ($total_tampil_tambah=='1') {
echo "<td><a href='$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("tambah","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/tambah.png' width='25px'/></a></td>";
}

if ($address=='?mod=aplikasipph/rumus' OR $address=='?mod=aplikasipph/Gaji') {
echo "<td><form method ='POST' action='modules/aplikasipph/cetak/print_excel_gaji.php' target='_blank'>";
echo "<input type='image' src='modules/gambar/save_excel.png' width='25' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$rows1[id]'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='nama_database1' value='$nama_database'>
			<input type='hidden' name='pilihan_tahun1' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan1' value='$pilihan_bulan'>
			<input type='hidden' name='pencarian1' value='$pencarian'>
			<input type='hidden' name='pilihan_pencarian1' value='$pilihan_pencarian'>
			<input type='hidden' name='address1' value='$address'>
			</form></td>";
			}

if ($address=='?mod=aplikasipph/rumus') {// OR $address=='?mod=aplikasipph/Gaji'
echo "<td><form method ='POST' action='modules/aplikasipph/cetak/print_excel_gaji_csv.php' target='_blank'>";
echo "<input type='image' src='modules/gambar/save_csv.png' width='23' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$rows1[id]'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='nama_database1' value='$nama_database'>
			<input type='hidden' name='pilihan_tahun1' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan1' value='$pilihan_bulan'>
			<input type='hidden' name='pencarian1' value='$pencarian'>
			<input type='hidden' name='pilihan_pencarian1' value='$pilihan_pencarian'>
			<input type='hidden' name='address1' value='$address'>
			</form></td>";}

if ($address=='?mod=aplikasipph/rumus') {// OR $address=='?mod=aplikasipph/Gaji'
echo "<td><form method ='POST' action='modules/aplikasipph/cetak/cetak_spt_all.php' target='_blank'>";
echo "<input type='image' src='modules/gambar/save_spt.png' width='65' height'25' name='print' value='print'>
			<input type='hidden' name='id' value='$rows1[id]'>
			<input type='hidden' name='bahasa' value='$bahasa'>
			<input type='hidden' name='nama_database1' value='$nama_database'>
			<input type='hidden' name='pilihan_tahun1' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan1' value='$pilihan_bulan'>
			<input type='hidden' name='pencarian1' value='$pencarian'>
			<input type='hidden' name='pilihan_pencarian1' value='$pilihan_pencarian'>
			<input type='hidden' name='address1' value='$address'>
			</form></td>";}

echo "</tr>";
echo "</table>";

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
//PAGING
$halaman = 50;
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT	* FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT	* FROM $nama_database WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' $if_pencarian ORDER BY id DESC LIMIT $mulai, $halaman")or die(mysql_error);
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
				elseif ($pecah_column_header[$no_items]=='price_rp' OR
								$address=='?mod=aplikasipph/rumus' AND $pecah_column_header[$no_items]!='tanggal' AND $pecah_column_header[$no_items]!='nama_pegawai' AND $pecah_column_header[$no_items]!='status_pegawai' AND $pecah_column_header[$no_items]!='keterangan_evaluasi' AND $pecah_column_header[$no_items]!='dari_bulan' AND $pecah_column_header[$no_items]!='sampai_bulan' AND $pecah_column_header[$no_items]!='status_ptkp'  AND $pecah_column_header[$no_items]!='pembuat' AND $pecah_column_header[$no_items]!='tgl_dibuat' AND $pecah_column_header[$no_items]!='ket_revisi' AND $pecah_column_header[$no_items]!='urut') {

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

				if ($rows1[validasi] == '' AND $nama_database=='aplikasipph_gaji' AND $address !='?mod=aplikasipph/rumus') {
				echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
				echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
				echo "</center></td>";
				}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $terjadi_revisi_khusus_spk == 'yes'){
				//echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
				//echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_delete'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("delete","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/delete.png" width="25px"/></a>';
				//echo "</center></td>";
				}
				elseif($rows1[validasi] == 'Valid' AND $validasi == 'ya' AND $nama_database == 'aplikasipph_gaji'){
				echo "<td style='text-align: center; background-color: white; border-top-right-radius: 10px; border-bottom-right-radius: 10px;'><center>";
				echo '<a onclick="return confirm(\''.ambil_database($bahasa,pusat_bahasa,"kode='notice_revisi'").' '. $rows1[po_nomor].' - '. $rows1[line_batch].'\')" href="'."$address&id=".base64_encrypt($rows1[id],"XblImpl1!A@")."&opsi=".base64_encrypt("edit","XblImpl1!A@")."&opsi_tambahan=revisi&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'"><img src="modules/gambar/revisi.png" width="25px"/></a>';
				echo "</center></td>";
				}else{}//echo "<td style='background-color:$color;'></td>";

				if($rows1[validasi] == 'Valid' AND $nama_database == 'aplikasipph_gaji') {
				echo "<td><form method ='POST' action='modules/aplikasipph/cetak/cetak_1721_A1.php' target='_blank'>";
				echo "<input type='image' src='modules/gambar/print.png' width='25' height'25' name='print' value='print'>
							<input type='hidden' name='id' value='$rows1[id]'>
							<input type='hidden' name='bahasa' value='$bahasa'>
							</form></td>";}

				echo "</tr>";
				$no++;}
				//ISI TABEL END
				echo "</table>";//TABEl END

//PAGING KLIK
if ($total > '50') {
echo "<table>
<form method ='post' action='$address'>
<tr>
 <td>(Total Data : $total) Halaman</td>
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
		 <td><input type='submit' value='".ambil_database($bahasa,pusat_bahasa,"kode='tampil'")."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END

}//END OPSI
return;}


//END?>
