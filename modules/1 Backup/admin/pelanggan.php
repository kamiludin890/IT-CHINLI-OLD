<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='admin/kontak';
	$tbl='pos_kontak';
	$fld='id,kategori,nama,alamat,telpon,keterangan';

function editmenu(){extract($GLOBALS);
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close,items');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,salin,close,items');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close,items');}
	else{echo usermenu('add,delete,filter,import,export');}
	}

function home(){extract($GLOBALS);
 	$limit = 50;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}

function editform($id,$btn){ extract($GLOBALS);  
	if(gubah($akses)!='Admin'){$btn='close';}

 	if(isset($_POST['id']) && $_POST['id']!=''){$_SESSION['idinduk']=$_POST['id']; 
	echo "<script type='text/javascript'>window.location.href='?menu=home&mod=pos/kontak_items'</script>";
	}

	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit /><ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label>". drops('1','Supplier,Customer,Marketing',$r[1])."</li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' /></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' /></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]'/></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]'/></li> 
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol></form>	";
 	}

function update(){extract($GLOBALS);
	$id=$_SESSION['idinduk'];
	editform($id,'save');
	}

function doimport(){ extract($GLOBALS);
	require_once 'addon/excel_reader2.php';
	$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);
	$sukses = 0; $gagal = 0;
	for ($i=2; $i<=$baris; $i++) {

	$id = $data->val($i, 1);
	$kategori= $data->val($i, 2);
	$nama = $data->val($i, 3);
	$alamat = $data->val($i, 4);
	$telpon = $data->val($i, 5);
	$keterangan = $data->val($i, 6);

//	$fld='id,kategori,nama,alamat,telpon,keterangan';
	 
 	$query = "INSERT INTO pos_kontak (id,kategori,nama,alamat,telpon,keterangan)VALUES ('$id','$kategori','$nama','$alamat','$telpon','$keterangan')";
//		$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,banyak,keterangan,gambar' ;

	$hasil = mysql_query($query)or die(mysql_error()); 
	if ($hasil) $sukses++;
	else $gagal++;
	}
	echo "<h3>Proses import data selesai.</h3>";
	echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
	echo "Jumlah data yang gagal diimport : ".$gagal."</p>";
	home();
 }	
	
 ?>