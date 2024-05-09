<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='report/spkproduksi';
	$tbl='report_spkproduksi';
	
	$fldi='id,';
	for ($i=1;$i<=10; ++$i){$items[]="spkpf".$i ; };
	$fldi.=implode(",", $items);
	$fld=$fldi;
	
function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,salin,close');}
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
	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	<input type=hidden name=par value=$id />";	
	
	echo"<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' /></li>
	<!--<li><label></label><button type=submit value=partya name='mybutton' class='formbutton' >".l('cari')."</button></li>-->
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' /></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' /></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' /></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]' /></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]' /></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label>". tgl('7', $r[7])."</li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]' /></li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[9]' /></li>

	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><textarea name='10' rows=6 cols=50 >$r[10]</textarea></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>

	</ol>";
	echo "</form>";
	
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

function partya(){extract($GLOBALS);
	echo "par:". $par=$_POST['par'];
	echo "par:". $btn2=$_POST['btn2'];
//	echo "par:". $par=4;

	$tbl='inventory_kontak';
	$fld='id,kategori,nama,alamat,npwp' ;
	echo "<form name='myform' method='post' action='?mod=master/select'>
	<input type='hidden' name='par' value='$par'>
	<input type='hidden' name='asal' value='delivery/invoice'>
	<input type='hidden' name='tbl' value='$tbl'>
	<input type='hidden' name='fld' value='$fld'>
	<input type='hidden' name='untuk' value='partya'>
	<input type='hidden' name='btn2' value='$btn2'>
	<script language='Javascript'>document.myform.submit();</script></form>";

}
function bank(){extract($GLOBALS);
	echo "par:". $par=$_POST['par'];
		echo "par:". $par=$_POST['par'];

//	echo "par:". $par=4;

	$tbl='master_bank';
	$fld='id,bank,nama,rekening,keterangan' ;
	echo "<form name='myform' method='post' action='?mod=master/select'>
	<input type='hidden' name='par' value='$par'>
	<input type='hidden' name='asal' value='delivery/invoice'>
	<input type='hidden' name='tbl' value='$tbl'>
	<input type='hidden' name='fld' value='$fld'>
	<input type='hidden' name='untuk' value='bank'>
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
 	$query="UPDATE delivery_invoice SET 
 	invf2='$var'	WHERE id='$id'"; 
	mysql_query($query)or die('Error 1 '.$query);
 	editform($id,$btn2); 
	}
	
function getbank(){extract($GLOBALS);
echo "par:".$id=$_POST['par'];
echo "par:".$btn2=$_POST['btn2'];

 // if (isset($_POST['hasil'])){ pilih();}
	echo "hasilnya : ".$_POST['hasil'];
 	$bank=getrow("id,bank,nama,rekening,keterangan","master_bank"," where id='$_POST[hasil]'");
 	echo "lokasi" .$kontak['nama'];
 	$var="$bank[1] \n $bank[2]\n $bank[3]";
 	$query="UPDATE delivery_invoice SET 
 	invf11='$var'	WHERE id='$id'"; 
	mysql_query($query)or die('Error 1 '.$query);
 	editform($id,$btn2); 
	}


?>