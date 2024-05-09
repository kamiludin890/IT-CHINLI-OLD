<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='admincls/purchasingimport';
	$tbl='admin_purchasingimport';
//	$fld='id,kode,model,warna,nama,kekerasan,items' ;


	$fld='id,kode,tanggal,';
	for ($i=1;$i<=9; ++$i){$items[]="apf".$i ; };
	$fld.=implode(",", $items);


function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,salin,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	elseif($_GET['menu']=='profile'){echo usermenu('save');}
	else{echo usermenu('add,delete,filter,export');}
	}

function home(){extract($GLOBALS);
 	$limit = 25;
	table($tbl,$fld,$limit,$rest,$mod);
		$_SESSION['myquery']="SELECT $fld from $tbl $rest ";

	}

function editform($id,$btn){ extract($GLOBALS);  
 	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=mysubmit /><input type=hidden name=id value=$id />
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]'/></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label>". tgl('2', $r[2])."</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]'/></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]'/></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><textarea name='5' rows=6 cols=100 >$r[5]</textarea></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]'/></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]'/></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]'/></li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[8]'/></li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label>". tgl('10', $r[10])."</li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><textarea name='11' rows=6 cols=100 >$r[11]</textarea></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>
 	</form>	";
 	 
  	}	

function beraksi(){extract($GLOBALS);
// if (isset($_POST['hasil'])){ pilih();}

//if (isset($_POST['untuk'])&& $_POST['untuk']=='partya'){ getpartya();}
//if (isset($_POST['untuk'])&& $_POST['untuk']=='bank'){ getbank();}
//if (isset($_POST['untuk'])&& $_POST['untuk']=='barang'){ pilih();}
//if (isset($_POST['untuk'])&& $_POST['untuk']=='pilihbanyak'){  pilihbanyak();}
 
if (isset($_POST['update'])){ iupdate(); }
if (isset($_POST['delete'])){ hapus(); }
if (isset($_POST['tambah'])){ tambah(); }
//if (isset($_POST['barang'])){ barang(); }
//if (isset($_POST['lokasi'])){ lokasi(); }

}	

function tambah(){ extract($GLOBALS);
	$id=$_POST['id'];
 $query="INSERT INTO report_formula_items SET 
	pembagian='$_POST[pembagian]', 
	bahanbaku='$_POST[bahanbaku]', 
	qty='$_POST[qty]', 
	satuan='$_POST[satuan]', 
 	induk='$id'";
	mysql_query($query)or die('Error 1 '.$query); 
	
	editform($id,'save'); 
	}

function hapus(){extract($GLOBALS);
	$kolom = explode(",", $_POST['tbl']);
	$tbl=$kolom[0];
	$induk=$_POST['induk'];
	$checked = $_POST['checkbox'];
	$count = count($checked);

	for($i=0; $i < $count; ++$i){	
	$query ="DELETE FROM report_formula_items WHERE id='$checked[$i]'"; 
	$result=mysql_query($query) or die('Error Delete, '.$query); }
	editform($id,'save'); 
	}

function update(){extract($GLOBALS);
	$induk=$_POST['induk'];
	$id=$_POST['induk'];
	$checked = $_POST['masuk'];
	$ids= $_POST['ids'];
	$count = count($checked);
	for($i=0; $i < $count; ++$i){	
	$query ="UPDATE report_formula_items SET kekerasan=$checked[$i] WHERE id=$ids[$i]"; 
	$result=mysql_query($query) or die('Error Delete, '.$query); }
editform($id,'save'); 	}
	
	
  ?>