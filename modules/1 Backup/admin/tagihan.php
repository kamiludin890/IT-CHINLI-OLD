<?php global  $title, $mod, $tbl, $fld, $akses;
	$mod='admin/tagihan';
	$tbl='pos_tagihan';
	$fld='id,kode,tanggal,kegiatan,keterangan,status,kontak,total,tanggal1,jumlah1,tanggal2,jumlah2';

function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,salin,close,cetak');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('add,delete,filter,import,export');}
	}

function home(){extract($GLOBALS);
 	$limit = 12;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}

function editform($id,$btn){ extract($GLOBALS);  
	if(gubah($akses)!='Admin'){$btn='close';}
 	$kontak=$_SESSION['idkontak'];
	
	$row = mysql_query("select $fld from $tbl");
 	$r=getrow($fld,$tbl,"where id='$id'");
 	if(isset($kontak)) {$r[6]=$kontak;}
	$_SESSION['idinduk']=$id;
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' /></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label>".tgl('2',$r[2])."</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label>".drops('3','Piutang,Hutang',$r[3])."</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' /></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label>".drops('5','BelumLunas,Lunas',$r[5])."</li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label>".droprow('6','id,nama','pos_kontak',$r[6],'ORDER BY nama ASC')."</li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]'/></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label>".tgl('8',$r[8])."</li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[9]'/></li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label>".tgl('10',$r[10])."</li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><input class='text' name='11' value='$r[11]'/></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>
	</form>	";
 	}	

function cetak(){extract($GLOBALS);
	$id=$_SESSION['idinduk'];
	$document = file_get_contents("prints/tmp-kwitansi.rtf");
	$kwitansi=getrow("*","pos_tagihan","where id='$id'");
	$kontak=getrow("*","pos_kontak","where id='$kwitansi[kontak]'");
	$sales=getrow("*","pos_kontak","where id='$kwitansi[sales]'");

	$document = str_replace("[a1]", $kwitansi['kode'], $document);
	$document = str_replace("[a2]", $kwitansi['tanggal'], $document);
	$document = str_replace("[a3]", $kontak['nama'], $document);
	$document = str_replace("[a4]", terbilang($kwitansi['jumlah1']), $document); 
	$document = str_replace("[a5]", $kwitansi['keterangan'], $document);
	$document = str_replace("[a6]", $kwitansi['jumlah1'], $document);
	$document = str_replace("[a7]", $sales['nama'], $document);
	$document = str_replace("[a8]", $kontak['nama'], $document);


	
	$fr = fopen('prints/kwitansi.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/kwitansi.rtf')</script>";
	
//$word = new COM("word.application") or die("Unable to instantiate Word");
//$word->visible = false;
//$word->Documents->Open(realpath("prints/penjualan.rtf"));
//$word->ActiveDocument->PrintOut(1);
//$word->Quit();
//$word = null;
 	home();
}
 ?>