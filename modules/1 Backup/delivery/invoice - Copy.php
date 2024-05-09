<?php global  $title, $mod, $tbl, $fld, $tbl1, $fld1, $akses ;
	$mod='delivery/invoice';
	$tbl='delivery_invoice';
	
	$fld='id,';
	for ($i=1;$i<=12; ++$i){$items[]="invf".$i ; };
	$fld.=implode(",", $items);
	$fld.=',item';


	$tbl1='sales_po_items';
	$fld1='id,induk,namabarang,ukuran,tebal,hardness,warna,size,qty,totalqty,unitprice,amount' ;

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
	$cari=l('cari');
	
	if($id==''){ $r[1]=getnum("invoice","CLI");}
	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	<input type=hidden name=par value=$id />";	
	
	echo"<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' /></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><textarea name='2' rows=6 cols=50 >$r[2]</textarea></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label>". tgl('3', $r[3])."</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label>". tgl('4', $r[4])."</li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]' /></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]' /></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]' /></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]' /></li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[9]' /></li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text' name='10' value='$r[10]' /></li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label>".droprow('11','id,bank','master_bank',$r[11],"" )."</li>
	<li><label for='12'>".l(mysql_field_name($row, 12))."</label><input class='text' name='12' value='$r[12]' /></li>
	<li><label for='13'>".l(mysql_field_name($row, 13))."</label><input class='text' name='13' value='$r[13]' /></li>
	<li class='buttons'><button type=submit value='save' name='mybutton' class='formbutton' >".l('save')."</button></li>
 	</ol>";
	
 	echo "<div id='kiri'></div>";
	echo"<div class='clear'></div>";

	echo "</form>";
	
//	 	$limit = 25;
//	$offset = get_offset($limit);
//	$query = "SELECT $fld1 FROM $tbl1 where induk='$id' LIMIT $offset, $limit  ";	


   	$limit = 25;
//	$item1=$r['item'];
//	$mod='inventory/keluar_items';
//	$tbl='inventory_distribusi_items';
//	$fld='id,tanggal,kodebarang,nama,satuan,keluar' ;
//	$fld='id,induk,kode,tanggal,kodebarang,nama,satuan,keluar,lokasi,kontak,keterangan' ;
	
	$rest="where induk='$id'";
	detail($tbl1,$fld1,$limit,$rest,$mod);
	
// end table

	}


function cetak(){extract($GLOBALS);
	$id=$_POST['id'];
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");

	$document = file_get_contents("prints/tmp-invoice.rtf");
	
	$fld='id,';
	for ($i=1;$i<=12; ++$i){
	$tmp="[a".$i."]";
	$document = str_replace($tmp, $r[$i], $document);
	};
	
	$fr = fopen('prints/invoice.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/invoice.rtf')</script>";
	
 	home();
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