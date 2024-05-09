<?php global  $title, $mod, $tbl, $fld, $tbl1, $fld1, $akses ;
	$mod='admincls/popurchasing';
	$tbl='admin_popurchasing';
//	$tbl='report_pembelian';
//	$fld='id,kode,model,warna,nama,kekerasan,items' ;

	$fld='id,kode,tanggal,';
	for ($i=1;$i<=6; ++$i){$items[]="fpf".$i ; };
	$fld.=implode(",", $items);

	$tbl1='admin_popurchasing_items';
	$fld1='id,induk,namabarang,jumlah,unit,satuan,tanggalpenyerahan,keterangan' ;

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
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'><input type=hidden name=mysubmit />
	<input type=hidden name=id value=$id />
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]'/></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label>". tgl('2', $r[2])."</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]'/></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]'/></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><textarea cols=100  name='5' rows=6>$r[5]</textarea></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]'/></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]'/></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]'/></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol> </form>";
	
	$tambah=l('tambah');
	//$fld1='id,induk,namabarang,jumlah,unit,satuan,tanggalpenyerahan,keterangan' ;

 	echo "<form name=myform1 action=?mod=$mod&menu=aksi method=post id='contactform'><input type=hidden name=mysubmit >";
	echo "<input type=hidden name=induk value=$id >";
	$c= explode(",", $fld1);
	echo "<ol>
	<li><label for='1'>".l($c[2])."</label><input class='text' name='1' ></li>
	<li><label for='2'>".l($c[3])."</label><input class='text' name='2' ></li>
	<li><label for='3'>".l($c[4])."</label><input class='text' name='3' ></li>
	<li><label for='4'>".l($c[5])."</label><input class='text' name='4' ></li>
	<li><label for='5'>".l($c[6])."</label>". tgl('5', '')."</li>
	<li><label for='6'>".l($c[7])."</label><input class='text' name='6' ></li>
	<li class='buttons'> <input type=button value=$tambah  onclick=submitform1('tambah') ></li>
	</ol> ";
	
 	$limit = 25;
	$offset = get_offset($limit);
	$query = "SELECT $fld1 FROM $tbl1 where induk='$id' LIMIT $offset, $limit  ";	

	$result = mysql_query($query) or die('Error Select'.$query);
	$no=1;
	$kolom = explode(",", $fld1);
	$jumkolom=count($kolom)+1;

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
	echo " <td> $row[0] </td> ";
	echo " <td> $row[1]</td> ";
	echo " <td> $row[2]</td> ";
	echo " <td> <input name='jumlah[]' value='$row[3]' ></td> ";
	echo " <td> $row[4]</td> ";
	echo " <td> $row[5]</td> ";
	echo " <td> $row[6]</td> ";
	echo " <td> $row[7]</td> ";
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
 
 	}	

function beraksi(){extract($GLOBALS);
	if (isset($_POST['update'])){ iupdate(); }
	if (isset($_POST['delete'])){ hapus(); }
	if (isset($_POST['tambah'])){ tambah(); }
}	

function tambah(){ extract($GLOBALS);
	$id=$induk=$_POST['induk'];
	$fld1='induk,namabarang,jumlah,unit,satuan,tanggalpenyerahan,keterangan' ;

	$kolom = explode(",", $fld1);		
	for ($i=1;$i< count($kolom); ++$i){$datasecs[]=$kolom[$i]."='".$_POST[$i]."'" ; };
	$data=implode(",", $datasecs);
	echo '<br>'.	
	$query ="INSERT INTO $tbl1 SET induk='$id',$data";
	$result=mysql_query($query)or die('Error Insert, '.$query);  
	editform($id,'save'); 
	}

function hapus(){extract($GLOBALS);
	$id=$induk=$_POST['induk'];
	$checked = $_POST['checkbox'];
	$count = count($checked);
	for($i=0; $i < $count; ++$i){	
	$query ="DELETE FROM $tbl1 WHERE id='$checked[$i]'"; 
	$result=mysql_query($query) or die('Error Delete, '.$query); }
	editform($id,'save'); 
	}

function update(){extract($GLOBALS);
	$id=$induk=$_POST['induk'];
	$checked = $_POST['jumlah'];
	$ids= $_POST['ids'];
	$count = count($checked);
	for($i=0; $i < $count; ++$i){	
	$query ="UPDATE $tbl1 SET jumlah=$checked[$i] WHERE id=$ids[$i]"; 
	$result=mysql_query($query) or die('Error Delete, '.$query); }
	editform($id,'save'); 	
}

function cetak(){extract($GLOBALS);
	$id=$_POST['induk'];

	$document = file_get_contents("prints/tmp-popurchasing.rtf");
	$main=getrow($fld,$tbl,"where id='$id'");

 	$document = str_replace("[a1]", $main[1], $document);
	$document = str_replace("[a2]", $main[2], $document);
	$document = str_replace("[a3]", $main[3], $document);
	$document = str_replace("[a4]", $main[4], $document);
	$document = str_replace("[a5]", $main[6], $document);
	$document = str_replace("[a6]", $main[7], $document);
	$document = str_replace("[a7]", $main[8], $document);

//	$tbl1='admin_popurchasing_items';
//	$fld1='id,induk,namabarang,jumlah,unit,satuan,tanggalpenyerahan,keterangan' ;

	$query = "SELECT $fld1 FROM $tbl1 where induk='$id' ";	
	$result = mysql_query($query) or die('Error');
		$i=1;
	while ($row=mysql_fetch_array($result))  { 	
	$b1 .=$i." \par ";
	$b2 .=$row['2']." \par ";
	$b3 .=$row['3']." \par ";
	$b4 .=$row['4']." \par ";
	$b5 .=$row['5']." \par ";
	$b6 .=$row['6']." \par ";
	$b7 .=$row['7']." \par ";
	$i++;
	}

	$document = str_replace("[aa1]", $b1, $document);
	$document = str_replace("[ab1]", $b2, $document);
	$document = str_replace("[ac1]", $b3, $document);
	$document = str_replace("[ad1]", $b4, $document);
	$document = str_replace("[ae1]", $b5, $document);
	$document = str_replace("[af1]", $b6, $document);
	$document = str_replace("[ag1]", $b7, $document);

	
//	for ($i = 0; $i <= 10; ++$i ) { 
//	$document = str_replace("[aa$i]", $i, $document);
//	$document = str_replace("[ab$i]", $i, $document);
//	$document = str_replace("[ac$i]", $i, $document);
//	$document = str_replace("[ad$i]", $i, $document);
//	$document = str_replace("[ae$i]", $i, $document);
//	$document = str_replace("[af$i]", $i, $document);
//	$document = str_replace("[ag$i]", $i, $document);
//		}
	
	$fr = fopen('prints/popurchasing.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/popurchasing.rtf')</script>";
	
//$word = new COM("word.application") or die("Unable to instantiate Word");
//$word->visible = false;
//$word->Documents->Open(realpath("prints/penjualan.rtf"));
//$word->ActiveDocument->PrintOut(1);
//$word->Quit();
//$word = null;
 	editform($id,'save'); 
}
	
  ?>