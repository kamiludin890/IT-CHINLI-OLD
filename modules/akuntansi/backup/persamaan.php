<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='akuntansi/persamaan';
	$tbl='akuntansi_persamaan';
	$fld='id,kelompok,keterangan,debit,kredit,status' ;

function editmenu(){extract($GLOBALS);
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');}
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,salin,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('add,delete,filter,import,export,posting');}
	}

function home(){extract($GLOBALS);
	$limit = 50;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}

function editform($id,$btn){ extract($GLOBALS);
	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $fld from $tbl");

	$r=getrow($fld,$tbl,"where id='$id'");
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label>". drops(1,'Aktiva,Passiva,Ekuitas,Pendapatan,Beban',$r[1])."</li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]'/></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label>". droprow('3','nomor,nama','akuntansi_akun',$r[3],' ORDER BY nama ASC')."</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label>". droprow('4','nomor,nama','akuntansi_akun',$r[4],' ORDER BY nama ASC')."</li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label>". drops(5,'tampil,sembunyi',$r[5])."</li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>
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
