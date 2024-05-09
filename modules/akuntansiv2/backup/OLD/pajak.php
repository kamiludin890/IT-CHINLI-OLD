<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='akuntansiv2/pajak';
	$tbl='akuntansiv2_pajak';
	
	$fld='id,';
	for ($i=1;$i<=21; ++$i){$items[]="pajakf".$i ; };
	$fld.=implode(",", $items);



//	$fld='id,f1,f2,f3,f4,f5,f6,f7,f8,f9,f10' ;

function editmenu(){extract($GLOBALS);	
//	if ($_POST['mysubmit']=='add'){echo usermenu('lanjut,close');} 
//	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
//	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
//	else{echo usermenu('add,delete,filter,export');}
	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('cetak,save,salin,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	elseif($_GET['menu']=='profile'){echo usermenu('save');}
	else{echo usermenu('add,delete,filter,export');}

	}

function home(){extract($GLOBALS);	global  $result;	

 //	if ($rest==''){$rest=" where kegiatan='jual'";} else { $rest.=" and kegiatan='jual'";}
	$limit = 50;
	$result='home' ;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}
	
function editform($id,$btn){ extract($GLOBALS); 

	
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");

	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	";
	
	echo "<fieldset><legend>HEADER</legend>";
	echo "<div id='kiri'><ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' /></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' /></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' /></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' /></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]' /></li>
	</ol></div>";
	echo "<div id='kanan'><ol>
		<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text'  name='6'  value='$r[6]' /></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text'  name='7'  value='$r[7]' /></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text'  name='8'  value='$r[8]' /></li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text'  name='9'  value='$r[9]' /></li>
	</ol></div></fieldset>";
	
	echo "<fieldset><legend>DATA PEMBERITAHUAN</legend>";
	echo "<div id='kiri'><ol>
	<li><label><B>TPB ASAL BARANG</B></label></li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text' name='10' value='$r[10]' /></li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><input class='text' name='11' value='$r[11]' /></li>
	<li><label for='12'>".l(mysql_field_name($row, 12))."</label><input class='text' name='12' value='$r[12]' /></li>
	<li><label for='13'>".l(mysql_field_name($row, 13))."</label><input class='text' name='13' value='$r[13]' /></li>
	</ol></div>";
	echo "<div id='kanan'><ol>
	<li><label><B>TPB TUJUAN BARANG</B></label></li>
	<li><label for='14'>".l(mysql_field_name($row, 14))."</label><input class='text' name='14' value='$r[14]' /></li>
	<li><label for='15'>".l(mysql_field_name($row, 15))."</label><input class='text' name='15' value='$r[15]' /></li>
	<li><label for='16'>".l(mysql_field_name($row, 16))."</label><input class='text' name='16' value='$r[16]' /></li>
	<li><label for='17'>".l(mysql_field_name($row, 17))."</label><input class='text' name='17' value='$r[17]' /></li>
	</ol></div></fieldset>";

	echo "<fieldset><legend>DOKUMEN PELENGKAP PABEAN</legend>";
	echo "<div id='kiri'><ol>
	<li><label for='18'>".l(mysql_field_name($row, 18))."</label><input class='text' name='18' value='$r[18]' /></li>
	<li><label for='19'>".l(mysql_field_name($row, 19))."</label><input class='text' name='19' value='$r[19]' /></li>
	<li><label for='20'>".l(mysql_field_name($row, 20))."</label><input class='text' name='20' value='$r[20]' /></li>
	</ol></div>";
	echo "<div id='kanan'><ol>
	<li><label for='21'>".l(mysql_field_name($row, 21))."</label><input class='text' name='21' value='$r[21]' /></li>
	</ol></div></fieldset>";
	
	
	echo "<fieldset> <legend>Action</legend>";
 	echo "<div id='kiri'><ol>
		<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol></div></fieldset>";

	echo"<div class='clear'></div>";
	echo"</form>";
	
	}


function cetak(){extract($GLOBALS);
	$id=$_POST['id'];
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");


	$document = file_get_contents("prints/tmp-pajak.rtf");
	
//	$jual=getrow("*","pos_transaksi","where id='$id'");
//	$kontak=getrow("*","pos_kontak","where id='$jual[kontak]'");
//	$sales=getrow("*","pos_kontak","where id='$jual[sales]'");
//	$alamat=getrow("alamat","master_setting","");
//	$alamat=getrow("alamat","master_setting","");

	$fld='id,';
	for ($i=1;$i<=21; ++$i){
		
	$tmp="[a".$i."]";
	$document = str_replace($tmp, $r[$i], $document);
	
	
	
	};
	
//	$fld.=implode(",", $items);

//  $document = str_replace("[a1]", "nopeng", $document);
//	$document = str_replace("[a2]", "kantor asal", $document);
//	$document = str_replace("[a3]", "kantor tujuan", $document);
//	$document = str_replace("[a4]", "jenis tpb asak", $document);
//	$document = str_replace("[a5]", "jenis tpb tujuan", $document);
//
//	$document = str_replace("[b1]", "npwp", $document);
//	$document = str_replace("[b2]", "nama", $document);
//	$document = str_replace("[b3]", "alamat", $document);
//	$document = str_replace("[b4]", "no izin tpb", $document);
//	$document = str_replace("[b5]", "npwp penerima", $document);
//	$document = str_replace("[b6]", "nama penerima", $document);
//	$document = str_replace("[b7]", "alamat penerima", $document);
//	$document = str_replace("[b8]", "no izin tpb penerima", $document);
//
//	$document = str_replace("[c1]", "invoice", $document);
//	$document = str_replace("[c2]", "packing list", $document);
//	$document = str_replace("[c3]", "kontrak", $document);
//	$document = str_replace("[c4]", "surat jalan", $document);
//	$document = str_replace("[c5]", "surat pesetujuan", $document);
//	$document = str_replace("[c6]", "lainnya", $document);
//
//	$document = str_replace("[d1]", "no tgl bc27", $document);
//	$document = str_replace("[d2]", "tanggalnya", $document);
//
//	$document = str_replace("[e1]", "usd", $document);
//	$document = str_replace("[e2]", "cif", $document);
//	$document = str_replace("[e3]", "hrga pnyerahan", $document);
//
//	$document = str_replace("[f1]", "mobil", $document);
//	$document = str_replace("[f2]", "b 3670 abc", $document);
//
//	$document = str_replace("[g1]", "merek n no", $document);
//	$document = str_replace("[g2]", "11 plbg", $document);
//
//	$document = str_replace("[ab0]", "no", $document);
//	$document = str_replace("[ab1]", "INSOCK (15-4503 TPX) EOR-13 KM707+BLACK", $document);
//	$document = str_replace("[ab2]", "jumlah", $document);
//	$document = str_replace("[ab3]", "satuan", $document);
//
//	$document = str_replace("[h1]", "tempat dan tgl", $document);
//	$document = str_replace("[h2]", "nama ttd", $document);
//
//	$document = str_replace("[i1]", "nama", $document);
//	$document = str_replace("[i2]", "nip", $document);

	

//  $document = str_replace("[a0]", $alamat['alamat'], $document);
//
//	$document = str_replace("[a1]", $jual['kode'], $document);
//	$document = str_replace("[a2]", $jual['sales'], $document);
//	$document = str_replace("[a3]", $sales['nama'], $document);
//	$document = str_replace("[a4]", $jual['tanggal'], $document);
//	$document = str_replace("[a5]", $jual['kontak'], $document);
//	$document = str_replace("[a6]", $kontak['nama'], $document);
//	$document = str_replace("[a7]", $kontak['alamat'], $document);
//	$document = str_replace("[a8]", $kontak['telpon'], $document);
//	$document = str_replace("[a9]", $jual['keterangan'], $document);
//	$document = str_replace("[a10]", terbilang($jual['total']), $document);
//	$document = str_replace("[a11]", format_rupiah($jual['subtotal']), $document);
//	$document = str_replace("[a12]", format_rupiah($jual['ppn']), $document);
//	$document = str_replace("[a13]", format_rupiah($jual['total']), $document);
//	$document = str_replace("[a14]", $jual['pembuat'], $document);
//
//	$query = "SELECT * FROM pos_transaksi_items where induk='$id' ";	
//	$result = mysql_query($query) or die('Error');
//
//	while ($row=mysql_fetch_array($result))  { 	
////	$barang=getrow("nama","barang","where kode='$row[kodebarang]'");
//	$b1 .=$row['kodebarang']." \par ";
//	$b2 .=$row['nama']." \par ";
//	$b3 .=$row['satuan']." \par ";
//	$b4 .=$row['banyak']." \par ";
//	$b5 .=$row['harga']." \par ";
//	$b6 .=$row['diskon']." \par ";
//	$b7 .=$row['jual']." \par ";
//
////	$a7=$a7+$row[jumlah];
////	$i++;
//	}
//
//	$document = str_replace("[aa1]", $b1, $document);
//	$document = str_replace("[ab1]", $b2, $document);
//	$document = str_replace("[ac1]", $b3, $document);
//	$document = str_replace("[ad1]", $b4, $document);
//	$document = str_replace("[ae1]", $b5, $document);
//	$document = str_replace("[af1]", $b6, $document);
//	$document = str_replace("[ag1]", $b7, $document);

	
//	for ($i = 0; $i <= 10; ++$i ) { 
//	$document = str_replace("[aa$i]", $i, $document);
//	$document = str_replace("[ab$i]", $i, $document);
//	$document = str_replace("[ac$i]", $i, $document);
//	$document = str_replace("[ad$i]", $i, $document);
//	$document = str_replace("[ae$i]", $i, $document);
//	$document = str_replace("[af$i]", $i, $document);
//	$document = str_replace("[ag$i]", $i, $document);
//		}
	
	$fr = fopen('prints/pajak.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/pajak.rtf')</script>";
	
//$word = new COM("word.application") or die("Unable to instantiate Word");
//$word->visible = false;
//$word->Documents->Open(realpath("prints/penjualan.rtf"));
//$word->ActiveDocument->PrintOut(1);
//$word->Quit();
//$word = null;
 	home();
}



?>