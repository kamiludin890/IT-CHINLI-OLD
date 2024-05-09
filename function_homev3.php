<?php

// ENKRIPSI
function kunci($plain_text,$iv_len = 16)
{
$password='QwASDasd@!12}}[!mOI!8!7()!980!*0&!]';
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
function buka_kunci($enc_text,$iv_len = 16)
{
$password='QwASDasd@!12}}[!mOI!8!7()!980!*0&!]';
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

function kalender1(){
		echo "
		<link rel='stylesheet' href='../tools/kalender_combo/jquery-ui.css'>
		<link rel='stylesheet' href='/resources/demos/style.css'>
		<script src='../tools/kalender_combo/jquery-1.12.4.js'></script>
		<script src='../tools/kalender_combo/jquery-ui.js'></script>

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

function combobox1(){
	echo "
	 <link href='../tools/kalender_combo/select2.min.css' rel='stylesheet' />
	 <script src='../tools/kalender_combo/select2.min.js'></script>

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

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}

function check_list($jenis_check,$id_dipilih,$item){
	$ambil_akses=ambil_database($jenis_check,master_akses,"id='$item'");
	$pecah_ambil_akses=pecah($ambil_akses);
	$nilai_pecah_ambil_akses=nilai_pecah($ambil_akses);
	$no_akses=0;for($i=0; $i < $nilai_pecah_ambil_akses; ++$i){
		if ($pecah_ambil_akses[$no_akses]==$id_dipilih){$checked=1;}else{$checked=0;}
		$total=$checked+$total;
	$no_akses++;}
return $total;}

function b($kode){
	if ($_SESSION['bahasa']=='') {$j_bahasa='ina';}else{$j_bahasa=$_SESSION['bahasa'];}
	$sql="SELECT $j_bahasa FROM master_bahasa WHERE kode='$kode'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	return $rows[$j_bahasa];}

function check_akses($id_hal){
	$akses=ambil_database(akses,master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}

function check_print($id_hal){
	$akses=ambil_database('print',master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}

function check_print_pdf($id_hal){
	$akses=ambil_database('print_pdf',master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}

function check_edit($id_hal){
	$akses=ambil_database(edit,master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}

function check_tambah($id_hal){
	$akses=ambil_database(tambah,master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}

function check_hapus($id_hal){
	$akses=ambil_database(hapus,master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}

function check_item($id_hal){
	$akses=ambil_database(item,master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}

function check_validasi($id_hal){
	$akses=ambil_database(validasi,master_akses,"id='".ambil_database(akses,master_user,"email='$_SESSION[username]'")."'");
	$pecah_akses=pecah($akses);
	$nilai_pecah_akses=nilai_pecah($akses);
	$no_items=0;for($i=0; $i < $nilai_pecah_akses; ++$i){
	  if($pecah_akses[$no_items]==$id_hal){$akses_diterima='1';}else{$akses_diterima='0';}
	  $total_akses=$akses_diterima+$total_akses;
	$no_items++;}
return $total_akses;}


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

function buat_list_checkbox($list_akses,$jumlah_list_akses){
		$no=0;for($i=0; $i < $jumlah_list_akses; ++$i){
			$datasecs[]="".$list_akses[$no]."";
		$no++;}
			$data=implode(",", $datasecs);
return $data;}

function buat_list_checkbox_kutip_satu($list_akses,$jumlah_list_akses){
		$no=0;for($i=0; $i < $jumlah_list_akses; ++$i){
			$datasecs[]="'".$list_akses[$no]."'";
		$no++;}
			$data=implode(",", $datasecs);
return $data;}


?>
