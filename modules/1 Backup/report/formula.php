<?php global  $title, $mod, $tbl, $fld,$tbl1, $fld1, $akses ;
	$mod='report/formula';
	$tbl='report_formula';
	$fld='id,kode,tanggal,model,warna,nama,kekerasan,items' ;

	$tbl1='report_formula_items';
	$fld1='id,pembagian,bahanbaku,qty,satuan' ;

function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,salin,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	elseif($_GET['menu']=='profile'){echo usermenu('save');}
	else{echo usermenu('add,delete,filter,export');}
	}

function home(){extract($GLOBALS);
 	$limit = 12;
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
	<li><label for='4'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]'/></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>";
	
	$tambah=l('tambah');
	echo "<ol>
	<li><label for='1'>".l('pembagian')."</label>". ddparam('pembagian','','pembagian')."</li>
	<li><label for='2'>".l('bahanbaku')."</label><input class='text' name='bahanbaku' ></li>
	<li><label for='3'>".l('qty')."</label><input class='text' name='qty' ></li>
	<li><label for='4'>".l('satuan')."</label>". ddparam('satuan','','satuan')."</li>
	<li class='buttons'> <input type=button value=$tambah  onclick=submitform('tambah') ></li>
	</ol></form>";
	
	
 	$limit = 25;
 	$id=$_POST['id'];

	$da=$_POST['da'];
	if($da=='ASC') {$da='DESC';} else {$da='ASC';}
	if($_POST['sortir']!="") {$sortir="order by ". $_POST['sortir'] ." $da";} else {$sortir="";}
	
	$datasec=$_POST['test'];
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld1;}
	$offset = get_offset($limit);
	
	$query = "SELECT id,pembagian,bahanbaku,qty,satuan FROM report_formula_items where induk='$id' $sortir LIMIT $offset, $limit  ";	
//	$rows = mysql_query($query);

	$result = mysql_query($query) or die('Error Select'.$query);
	$no=1;
	$kolom = explode(",", $data);
	$jumkolom=count($kolom)+1;

 	echo "<form name=myform1 action=?mod=$mod&menu=aksi method=post ><input type=hidden name=mysubmit >";
	echo "<input type=hidden name=menu value=$menu >";
	echo "<input type=hidden name=da value=$da >";
	echo "<input type=hidden name=sortir >";
	echo "<input type=hidden name=induk value=$id >";
	echo "<input type=hidden name=id value=$id >";
	echo "<input type=hidden name=tbl value=$tbl >";
	echo "<input type=hidden name=ids >";
	echo "<input type=hidden name=items >";
  
	echo" <div class='subHeader1'><div class='toolbar'><div class='toolbarContent'>"; 
	echo usermenu1('update,hapus,cetak');
	echo"</div></div></div>";
	
  	echo "<table class=filterable id='table-k' ><thead>";
 	echo"<tr>";
 	echo "<th><input type=checkbox  onClick=checkUncheckAll(this) ></th>";
	
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>".l($kolom[$i])."</th>"; }
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  { 	
	echo "  <tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td align='center'><input type=checkbox  name='checkbox[]' value=$row[0] ><input type=hidden name='ids[]' value=$row[0] > </td>";
	echo " <td > $row[0] </td> ";
	echo " <td > <input name='pembagian[]' value='$row[1]' >  </td> ";
	echo " <td > <input name='bahanbaku[]' value='$row[2]' > </td> ";
	echo " <td > <input name='qty[]' value='$row[3]' ></td> ";
	echo " <td > <input name='satuan[]' value='$row[4]' >  </td> ";
//	echo " <td > <input type=text name='masuk[]' value=$row[5] > </td> ";
	echo "</tr>";
	}
	echo "</tbody></table>";
 
 	$query = "SELECT sum(qty) as total FROM report_formula_items where satuan='g' and induk='$id' ";	
	$result = mysql_query($query) or die('Error Select'.$query);
	$row=mysql_fetch_array($result);

	$query1 = "SELECT sum(qty) as total FROM report_formula_items where satuan='Kg' and induk='$id' ";	
	$result1 = mysql_query($query1) or die('Error Select'.$query1);
	$row1=mysql_fetch_array($result1);

	$tg=$row[0]/1000;
	$tKg=$row1[0];
	$total=$tg+$tKg;
	echo "Total :$total <input type=hidden name='total' value=$total >";
	echo "</form>";
// end table
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
 	editform($induk,'save');   
  	}

function update(){extract($GLOBALS);
	$induk=$_POST['induk'];
	$ids= $_POST['ids'];
	$count = count($ids);
 	$pembagian= $_POST['pembagian'];
 	$bahanbaku= $_POST['bahanbaku'];
 	$qty= $_POST['qty'];
 	$satuan= $_POST['satuan'];
	for($i=0; $i < $count; ++$i){	
	$query ="UPDATE report_formula_items SET 
	pembagian='$pembagian[$i]', bahanbaku='$bahanbaku[$i]', qty=$qty[$i], satuan='$satuan[$i]' WHERE id=$ids[$i]"; 
	$result=mysql_query($query) or die('Error Update, '.$query); }
	editform($induk,'save'); 	
	}



function cetak(){extract($GLOBALS);
//	$id=$_SESSION['idinduk'];
		$id=$_POST['induk'];
		$total=$_POST['total'];

	$document = file_get_contents("prints/tmp-formula.rtf");
	$main=getrow("*","report_formula","where id='$id'");
 
 	$document = str_replace("[a1]", $main['model'], $document);
	$document = str_replace("[a2]", $main['warna'], $document);
	$document = str_replace("[a3]", $main['nama'], $document);
	$document = str_replace("[a4]", $main['kekerasan'], $document);
	$document = str_replace("[a5]", $total, $document);

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

	
//	for ($i = 0; $i <= 10; ++$i ) { 
//	$document = str_replace("[aa$i]", $i, $document);
//	$document = str_replace("[ab$i]", $i, $document);
//	$document = str_replace("[ac$i]", $i, $document);
//	$document = str_replace("[ad$i]", $i, $document);
//	$document = str_replace("[ae$i]", $i, $document);
//	$document = str_replace("[af$i]", $i, $document);
//	$document = str_replace("[ag$i]", $i, $document);
//		}
	
	$fr = fopen('prints/formula.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/formula.rtf')</script>";
	
//$word = new COM("word.application") or die("Unable to instantiate Word");
//$word->visible = false;
//$word->Documents->Open(realpath("prints/penjualan.rtf"));
//$word->ActiveDocument->PrintOut(1);
//$word->Quit();
//$word = null;
 	home();
}

	
  ?>