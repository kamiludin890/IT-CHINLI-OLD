<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='delivery/sales_contract';
	$tbl='delivery_sales_contract';
	
	$fld='id,';
	for ($i=1;$i<=10; ++$i){$items[]="scf".$i ; };
	$fld.=implode(",", $items);
	$fld.=',item';

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
		$cari=constant('cari');

	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	<input type=hidden name=par value=$id />";	
	
	echo"<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' /></li>
	<li><label><B>PARTY A</B></label><input type=button value=$cari  onclick=submitform('partya') > </li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><textarea name='2' rows=6 cols=50 >$r[2]</textarea></li>
	<li><label><B>PARTY B</B></label><input type=button value=$cari  onclick=submitform('partyb') ></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><textarea name='3' rows=6 cols=50 >$r[3]</textarea></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><textarea name='4' rows=6 cols=50 >$r[4]</textarea></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><textarea name='5' rows=6 cols=50 >$r[5]</textarea></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><textarea name='6' rows=6 cols=50 >$r[6]</textarea></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><textarea name='7' rows=6 cols=50 >$r[7]</textarea></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><textarea name='8' rows=6 cols=50 >$r[8]</textarea></li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><textarea name='9' rows=6 cols=50 >$r[9]</textarea></li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><textarea name='10' rows=6 cols=50 >$r[10]</textarea></li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><textarea name='11' rows=6 cols=50 >$r[11]</textarea></li>
	</ol>";
	
	echo "<fieldset> <legend>Action</legend>";
 	echo "<div id='kiri'><ol>
		<li class='buttons'><button type=submit value='save' name='mybutton' class='formbutton' >".l('save')."</button></li>
	</ol></div></fieldset>";

	echo"<div class='clear'></div>";

	echo "</form>";
	
  	$limit = 25;
	$item1=$r['item'];
	$mod='inventory/keluar_items';
	$tbl='inventory_distribusi_items';
//	$fld='id,tanggal,kodebarang,nama,satuan,keluar' ;
	$fld='id,induk,kode,tanggal,kodebarang,nama,satuan,keluar,lokasi,kontak,keterangan' ;
	$rest="where kode='$item1'";
	detail($tbl,$fld,$limit,$rest,$mod);	
// end table

	}


function cetak(){extract($GLOBALS);
	$id=$_POST['id'];
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");

	$document = file_get_contents("prints/tmp-sales_contract.rtf");
	
	$fld='id,';
	for ($i=1;$i<=10; ++$i){
	$tmp="[a".$i."]";
	$document = str_replace($tmp, $r[$i], $document);
	};
	
	$fr = fopen('prints/sales_contract.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/sales_contract.rtf')</script>";
	
 	home();
}


function beraksi(){extract($GLOBALS);
// if (isset($_POST['hasil'])){ pilih();}

if (isset($_POST['untuk'])&& $_POST['untuk']=='partya'){ getpartya();}
if (isset($_POST['untuk'])&& $_POST['untuk']=='partyb'){ getpartyb();}
//if (isset($_POST['untuk'])&& $_POST['untuk']=='barang'){ pilih();}
//if (isset($_POST['untuk'])&& $_POST['untuk']=='pilihbanyak'){  pilihbanyak();}
 
//if (isset($_POST['update'])){ iupdate(); }
//if (isset($_POST['delete'])){ hapus(); }
//if (isset($_POST['tambah'])){ tambah(); }
//if (isset($_POST['barang'])){ barang(); }
//if (isset($_POST['lokasi'])){ lokasi(); }

}

function partya(){extract($GLOBALS);
	echo "par:". $par=$_POST['par'];
	echo "par:". $btn2=$_POST['btn2'];
//	echo "par:". $par=4;

	$tbl='inventory_kontak';
	$fld='id,kategori,nama,alamat,npwp' ;
	echo "<form name='myform' method='post' action='?mod=master/select'>
	<input type='hidden' name='par' value='$par'>
	<input type='hidden' name='asal' value='delivery/sales_contract'>
	<input type='hidden' name='tbl' value='$tbl'>
	<input type='hidden' name='fld' value='$fld'>
	<input type='hidden' name='untuk' value='partya'>
	<input type='hidden' name='btn2' value='$btn2'>
	<script language='Javascript'>document.myform.submit();</script></form>";

}
function partyb(){extract($GLOBALS);
	echo "par:". $par=$_POST['par'];
		echo "par:". $par=$_POST['par'];

//	echo "par:". $par=4;

	$tbl='inventory_kontak';
	$fld='id,kategori,nama,alamat,npwp' ;
	echo "<form name='myform' method='post' action='?mod=master/select'>
	<input type='hidden' name='par' value='$par'>
	<input type='hidden' name='asal' value='delivery/sales_contract'>
	<input type='hidden' name='tbl' value='$tbl'>
	<input type='hidden' name='fld' value='$fld'>
	<input type='hidden' name='untuk' value='partyb'>
	<input type='hidden' name='btn2' value='$btn2'>
	<script language='Javascript'>document.myform.submit();</script></form>";

}

function getpartya(){extract($GLOBALS);
echo "par:".$id=$_POST['par'];
echo "par:".$btn2=$_POST['btn2'];
 // if (isset($_POST['hasil'])){ pilih();}
	echo "hasilnya : ".$_POST['hasil'];
 	$kontak=getrow("id,nama,alamat,npwp","inventory_kontak"," where id='$_POST[hasil]'");
 	echo "lokasi" .$kontak['nama'];
 	$var="$kontak[1] \n $kontak[2]\n $kontak[3]";
 	$query="UPDATE delivery_sales_contract SET 
 	scf2='$var'	WHERE id='$id'"; 
	mysql_query($query)or die('Error 1 '.$query);
 	editform($id,$btn2); 
	}
	
function getpartyb(){extract($GLOBALS);
echo "par:".$id=$_POST['par'];
echo "par:".$btn2=$_POST['btn2'];

 // if (isset($_POST['hasil'])){ pilih();}
	echo "hasilnya : ".$_POST['hasil'];
 	$kontak=getrow("id,nama,alamat,npwp","inventory_kontak"," where id='$_POST[hasil]'");
 	echo "lokasi" .$kontak['nama'];
 	$var="$kontak[1] \n $kontak[2]\n $kontak[3]";
 	$query="UPDATE delivery_sales_contract SET 
 	scf3='$var'	WHERE id='$id'"; 
	mysql_query($query)or die('Error 1 '.$query);
 	editform($id,$btn2); 
	}


?>