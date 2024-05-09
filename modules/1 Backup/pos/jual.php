<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='pos/jual';
	$tbl='pos_transaksi';
	$fld='id,kode,tanggal,pembuat,kegiatan,lokasi,keterangan,status,kontak,subtotal,ppn,total,sales,ppnstatus' ;

function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('lanjut,close');} 
//	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('add,delete,filter,export');}
	}

function home(){extract($GLOBALS);	global  $result;
	$fld='id,kode,tanggal,pembuat,lokasi,keterangan,status,kontak,subtotal,ppn,total' ;
 	if ($rest==''){$rest=" where kegiatan='jual'";} else { $rest.=" and kegiatan='jual'";}
	$limit = 50;
	$result='home' ;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}
	
function editform($id,$btn){ extract($GLOBALS); 
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");
	$username=$_SESSION['username'];
	$lokasi=getrow('lokasi,kontak','master_user',"where email='$username'");
		
	if($id==''){
	$r[2]=date('Y-m-d');
	$r[3]=$username;
	$r[4]="jual";
	$r[5]=$lokasi['lokasi'];
	$r[7]="Proses";
	$r[8]=$lokasi['kontak'];
	$btn="lanjut";
	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' type=hidden />$r[1]</li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' type=hidden /> $r[2]</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' type=hidden /> $r[3]</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))." Kegiatan</label><input class='text' name='4' value='$r[4]' type=hidden /> $r[4]</li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label>". droprow('5','id,nama','inventory_lokasi',$r[5],'')."</li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text'  name='6'  value='$r[6]' /></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text'  name='7'  value='$r[7]' type=hidden />$r[7]</li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label>". droprow('8','id,nama','pos_kontak',$r[8],"where kategori='customer'" )."</li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text'  name='9'  value='$r[9]' type=hidden />$r[9]</li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text'  name='10'  value='$r[10]' type=hidden />$r[10]</li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><input class='text'  name='11'  value='$r[11]' type=hidden />$r[11]</li>
	<li><label for='12'>".l(mysql_field_name($row, 12))."</label>". droprow('12','id,nama','pos_kontak',$r[12],"where kategori='marketing'")."</li>
	<li><label for='13'>".l(mysql_field_name($row, 13))."</label>".drops('13','ya,tidak',$r[13])."</li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol></form> ";
	}
	else{ $_SESSION['idinduk']=$id; $_SESSION['idkontak']=$r[8]; 
	echo "<script type='text/javascript'>window.location.href='?menu=home&mod=pos/jual_items&res=h'</script>";
	}
 	}	

function lanjut(){ extract($GLOBALS);
	$query="INSERT INTO pos_transaksi SET 
	tanggal= '$_POST[2]', 
	pembuat='$_POST[3]', 
	kegiatan='$_POST[4]', 
	lokasi='$_POST[5]',
	keterangan='$_POST[6]',
	status='$_POST[7]',
	kontak='$_POST[8]',
	subtotal='$_POST[9]',
	ppn='$_POST[10]',
	total='$_POST[11]',
	sales='$_POST[12]',
	ppnstatus='$_POST[13]'
	";
	mysql_query($query)or die('Error 1'.$query); 	
	$id=mysql_insert_id();
	$_SESSION['idinduk']=$id; 
	echo "<script type='text/javascript'>window.location.href='?menu=home&mod=pos/jual_items'</script>";
  	}	

?>