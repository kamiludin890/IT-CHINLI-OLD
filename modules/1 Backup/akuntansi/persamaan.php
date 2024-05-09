<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='akuntansi/persamaan';
	$tbl='akuntansi_persamaan';
	$fld='id,kelompok,keterangan,debit,kredit,kredit_kedua,status' ;

function editmenu(){extract($GLOBALS);
	if ($_POST['mysubmit']=='add'){echo usermenu('');}//insert,close
	elseif($_POST['mysubmit']=='edit'){echo usermenu('');}//save,salin,close
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('add,delete,filter,import,export,posting');}
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

function home(){extract($GLOBALS);
	$limit = 1000;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest";
	}

	$id_persamaan=$_POST['id_persamaan'];
	$edit_or_tambah=$_POST['edit_or_tambah'];

	$kelompok268=$_POST['kelompok268'];
	$keterangan268=$_POST['keterangan268'];
	$debit268=$_POST['debit268'];
	$kredit268=$_POST['kredit268'];
	$kredit_kedua268=$_POST['kredit_kedua268'];
	$status268=$_POST['status268'];

	if ($edit_or_tambah==edit){
		$update_persamaan="UPDATE akuntansi_persamaan SET kelompok='$kelompok268',keterangan='$keterangan268',debit='$debit268',kredit='$kredit268',kredit_kedua='$kredit_kedua268',status='$status268' WHERE id='$id_persamaan'";
		$eksekusi_update_persamaan=mysql_query($update_persamaan);
	}
	if ($edit_or_tambah==tambah){
		$insert_persamaan="INSERT INTO akuntansi_persamaan (kelompok,keterangan,debit,kredit,kredit_kedua,status) VALUES ('$kelompok268','$keterangan268','$debit268','$kredit268','$kredit_kedua268','$status268')";
		$eksekusi_insert_persamaan=mysql_query($insert_persamaan);
	}

function editform($id,$btn){ extract($GLOBALS);
	$induk=$id;

	if ($induk>0) {
		$penentu='edit';
	}else {
		$penentu='tambah';
	}

	$sql51="SELECT * FROM akuntansi_persamaan WHERE id='$id'";
	$result51= mysql_query($sql51);
	$rows51=mysql_fetch_array($result51);

	$sql2="SELECT * FROM akuntansi_akun ORDER BY id";
	$result2= mysql_query($sql2);
	$result3= mysql_query($sql2);
	$result4= mysql_query($sql2);


	echo kalender();
	echo combobox();
//	echo "<link rel='stylesheet' href='select_picker/css/style3.css' type='text/css'>
//				<link rel='stylesheet' href='select_picker/css/bootstrap-select.min.css' type='text/css'>";

			echo "<form method ='post' action='?menu=home&mod=akuntansi/persamaan'>
			<table>

	 <tr>
	 <td>Kelompok</td>
	 <td>:</td>
	 <td><select class='comboyuk' name='kelompok268'>
	 <option value='$rows51[kelompok]'>".$rows51['kelompok']."</option>
	 <option value='Aktiva'>Aktiva</option>
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
	 <option value='Prive/Dividen'>Prive/Dividen</option>
	</td>

	<tr>
	 <td>keterangan</td>
	 <td>:</td>
	 <td><input type='text' name='keterangan268' value='$rows51[keterangan]'></td>
	</tr>

	<tr>
	<div class='col-xs-12'>
	<div class='row'>
	<div class='col-sm-4'>
	<div class='form-group'>
	<td>debit</td>
	<td>:</td>
	<td><select class='comboyuk' name='debit268' class='form-control selectpicker show-tick' data-live-search='true'>";

	$sql52="SELECT * FROM akuntansi_akun WHERE nomor='$rows51[debit]'";
	$result52= mysql_query($sql52);
	$rows52=mysql_fetch_array($result52);

	echo "
	<option value='$rows52[nomor]'>".$rows52[nama]."</option>";
	while ($rows2=mysql_fetch_array($result2)){
	echo "
	<option value='$rows2[nomor]'>".$rows2[nama]."</option>
	";}
	echo "
	</select></td>
	</tr><tr></tr><tr></tr><tr></tr>

	<tr>
	<div class='col-xs-12'>
	<div class='row'>
	<div class='col-sm-4'>
	<div class='form-group'>
	<td>Kredit</td>
	<td>:</td>
	<td><select class='comboyuk' name='kredit268' class='form-control selectpicker show-tick' data-live-search='true'>";
	$sql53="SELECT * FROM akuntansi_akun WHERE nomor='$rows51[kredit]'";
	$result53= mysql_query($sql53);
	$rows53=mysql_fetch_array($result53);
	echo "
	<option value='$rows53[nomor]'>".$rows53[nama]."</option>";
	while ($rows3=mysql_fetch_array($result3)){
	echo "
	<option value='$rows3[nomor]'>".$rows3['nama']."</option>
	";}
	echo "
	</select></td>
	</tr><tr></tr><tr></tr><tr></tr>

	<tr>
	<div class='col-xs-12'>
	<div class='row'>
	<div class='col-sm-4'>
	<div class='form-group'>
	<td>Kredit Kedua</td>
	<td>:</td>
	<td><select class='comboyuk' name='kredit_kedua268' class='form-control selectpicker show-tick' data-live-search='true'>";

	$sql54="SELECT * FROM akuntansi_akun WHERE nomor='$rows51[kredit_kedua]'";
	$result54= mysql_query($sql54);
	$rows54=mysql_fetch_array($result54);

	echo "
	<option value='$rows54[nomor]'>".$rows54[nama]."</option>";
	while ($rows4=mysql_fetch_array($result4)){
	echo "
	<option value='$rows4[nomor]'>".$rows4['nama']."</option>
	";}
	echo "
	</select></td>
	</tr><tr></tr><tr></tr><tr></tr>

	<tr>
	<td>Status</td>
	<td>:</td>
	<td><select name='status268'>
	<option value='$rows51[status]'>".$rows51['status']."</option>
	<option value='tampil'>tampil</option>
	<option value='sembunyi'>sembunyi</option>
 </td>

 <input type='hidden' name='edit_or_tambah' value='$penentu'/></td>
 <input type='hidden' name='id_persamaan' value='$id'/></td>

 <tr>
	<td></td>
	<td></td>
	<td><input type='submit' value='Simpan'>
 </tr>";

echo "
	<script src='select_picker/js/jquery-1.11.2.min.js'></script>
	<script src='select_picker/js/bootstrap.js'></script>
	<script src='select_picker/js/bootstrap-select.min.js'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
	});
	</script>

	</table>
	</form>	";
 	}

function doimport(){ extract($GLOBALS);
	require_once 'addon/excel_reader2.php';
	$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);
	$sukses = 0; $gagal = 0;
	for ($i=2; $i<=$baris; $i++) {

	$id = $data->val($i, 1);
	$nama = $data->val($i, 2);
	$keterangan = $data->val($i, 3);

 	$query = "INSERT INTO $tbl VALUES ('$id','$nama','$keterangan')";

	$hasil = mysql_query($query)or die(mysql_error());
	if ($hasil) $sukses++;
	else $gagal++;
	}
	echo "<h3>Proses import data selesai.</h3>";
	echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
	echo "Jumlah data yang gagal diimport : ".$gagal."</p>";
	home();
 }

 function posting(){extract($GLOBALS);
	$tanggal=date('Y-m-d');
	$pembuat=$_SESSION['username'];
	$checked = $_POST['checkbox'];
	$count = count($checked);
	for($i=0; $i < $count; ++$i){

	$persamaan=getrow("*","akuntansi_persamaan"," where id='$checked[$i]'");

	$query="INSERT INTO akuntansi_posting SET
	tanggal='$tanggal'
	,pembuat='$pembuat'
	,keterangan='$persamaan[keterangan]'
	,persamaan='$persamaan[id]'
	,debit='$persamaan[debit]'
	,kredit='$persamaan[kredit]'
	,kredit_kedua='$persamaan[kredit_kedua]'
	,status='Proses'
	";
	$result=mysql_query($query) or die('Error Delete, '.$query);
	echo "Berhasil, memasukan transaksi dengan kontak: <strong> $kontak[nama] </strong> <br>";
	}
	$id=mysql_insert_id();
 	echo "<script type='text/javascript'>window.location.href='?mod=akuntansi/posting&menu=persamaan&id=$id'</script>";
//	home();
//	editform($id,'save');

	}

 ?>
