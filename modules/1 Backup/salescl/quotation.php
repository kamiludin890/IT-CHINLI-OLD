<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='salescl/quotation';
	$tbl='salescl_quotation';
	
	$fld='id,kode,tanggal,';
	for ($i=1;$i<=12; ++$i){$items[]="sqf".$i ; };
	$fld.=implode(",", $items);

function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('cetak,save,salin,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	elseif($_GET['menu']=='profile'){echo usermenu('save');}
	else{echo usermenu('add,delete,filter,export');}
	}
function home(){extract($GLOBALS);	global  $result;	
	$limit = 50;
	$result='home' ;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}



	
function editform($id,$btn){ extract($GLOBALS); 

	$btn2=$btn;
//$id=$_SESSION['idinduk'];
//	echo $induk=$_POST['induk'];
//	echo "par:".	$id;
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");
	
	if($id==''){ $r[1]=getnum("quotation","CL");}
	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	<input type=hidden name=par value=$id />";	
	
	echo"<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' /></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label>". tgl('2', $r[2])."</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label>". droprow('3','id,nama','pos_kontak',$r[3],"where kategori='customer'" )."</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' /></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]' /></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]' /></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]' /></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]' /></li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[9]' /></li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text' name='10' value='$r[10]' /></li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><input class='text' name='11' value='$r[11]' /></li>
	<li><label for='12'>".l(mysql_field_name($row, 12))."</label><input class='text' name='12' value='$r[12]' /></li>
	<li><label for='13'>".l(mysql_field_name($row, 13))."</label><input class='text' name='13' value='$r[13]' /></li>
	<li><label for='14'>".l(mysql_field_name($row, 14))."</label><input class='text' name='14' value='$r[14]' /></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>
	<div class='clear'></div>";
	echo "</form>";
	}

 function cetak(){extract($GLOBALS);
echo 	$id=$_POST['id'];
//	$id=$_POST['induk'];
 	$id=$_POST['id'];
	$r=getrow($fld,$tbl,"where id='$id'");
	$document = file_get_contents("prints/tmp-quotation.rtf");

	$fld='id,kode,tanggal,';
	for ($i=1;$i<=14; ++$i){
	$tmp="[a".$i."]";
	$document = str_replace($tmp, $r[$i], $document);
	};
	
 //	$document = str_replace("[a1]", $main['model'], $document);
//	$document = str_replace("[a2]", $main['warna'], $document);
//	$document = str_replace("[a3]", $main['nama'], $document);
	
	$kolom = explode(",", $r[10]);
if ($kolom[0]=='id'){ 
	$document = str_replace("[a8a]", "X", $document);
	$document = str_replace("[a8b]", $kolom[1], $document); 
	$document = str_replace("[a8c]", "", $document);
	$document = str_replace("[a8d]", "", $document); } ELSE{
	$document = str_replace("[a8a]", "", $document);
	$document = str_replace("[a8b]", "", $document); 
	$document = str_replace("[a8c]", "X", $document);
	$document = str_replace("[a8d]", $kolom[1], $document); } 
 
 if ($kolom[3]=='idr'){ 
	$document = str_replace("[a8e]", "X", $document);
	$document = str_replace("[a8f]", "", $document); } ELSE{
	$document = str_replace("[a8e]", "", $document);
	$document = str_replace("[a8f]", "X", $document);} 

	
	$query = "SELECT * FROM report_formula_items where induk='$id' ";	
	$result = mysql_query($query) or die('Error');
	while ($row=mysql_fetch_array($result))  { 	
//	$barang=getrow("nama","barang","where kode='$row[kodebarang]'");
	$b1 .=$row['pembagian']." \par ";
	$b2 .=$row['bahanbaku']." \par ";
	$b3 .=$row['qty']." \par ";
	$b4 .=$row['satuan']." \par ";

//	$a7=$a7+$row[jumlah];
//	$i++;
	}

	$document = str_replace("[aa1]", $b1, $document);
	$document = str_replace("[ab1]", $b2, $document);
	$document = str_replace("[ac1]", $b3, $document);
	$document = str_replace("[ad1]", $b4, $document);

 
	
	$fr = fopen('prints/quotation.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/quotation.rtf')</script>";
	
 
 //	home();
}


function beraksi(){extract($GLOBALS);
// if (isset($_POST['hasil'])){ pilih();}

if (isset($_POST['untuk'])&& $_POST['untuk']=='partya'){ getpartya();}
if (isset($_POST['untuk'])&& $_POST['untuk']=='bank'){ getbank();}
//if (isset($_POST['untuk'])&& $_POST['untuk']=='barang'){ pilih();}
//if (isset($_POST['untuk'])&& $_POST['untuk']=='pilihbanyak'){  pilihbanyak();}
 
//if (isset($_POST['update'])){ iupdate(); }
//if (isset($_POST['delete'])){ hapus(); }
//if (isset($_POST['tambah'])){ tambah(); }
//if (isset($_POST['barang'])){ barang(); }
//if (isset($_POST['lokasi'])){ lokasi(); }
 
}

 
function getnum($fld,$kode){
	$r=getrow("$fld","master_setting","");
	$id= $r[$fld]+1; 
	$query ="UPDATE master_setting SET $fld='$id' ";
	$result=mysql_query($query)or die('Error Upate, '.$query);  
	return $kode."-".date('Y')."-".str_pad($id, 5, '0', STR_PAD_LEFT); 
	}


?>