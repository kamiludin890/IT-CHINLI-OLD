<?php global  $title, $mod, $tbl, $fld, $tbl2, $fld2, $akses ;
	$mod='delivery/invoice';
	$tbl='delivery_invoice';
	
	$fld='id,';
	for ($i=1;$i<=12; ++$i){$items[]="invf".$i ; };
	$fld.=implode(",", $items);
	$fld.=',item';

	$tbl2='delivery_invoice_items';
	$fld2='id,induk,kodebarang,namabarang,ukuran,tebal,hardness,warna,size,qty,totalqty,unitprice,amount';

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
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	";
	
echo "<fieldset><legend>HEADER</legend>";
	echo "<div id='kiri'><ol>
	<li><label for='1'>".l(mysql_field_name($row,1))."</label><input class='text' name='1' value='$r[1]' /></li>
	<li><label for='2'>".l(mysql_field_name($row,2))."</label><input class='text' name='2' value='$r[2]' /></li>
	<li><label for='3'>".l(mysql_field_name($row,3))."</label><input class='text' name='3' value='$r[3]' /></li>
	<li><label for='4'>".l(mysql_field_name($row,4))."</label><input class='text' name='4' value='$r[4]' /></li>
	<li><label for='5'>".l(mysql_field_name($row,5))."</label><input class='text' name='5' value='$r[5]' /></li>
	<li><label for='6'>".l(mysql_field_name($row,6))."</label><input class='text'  name='6'  value='$r[6]' /></li>
	<li><label for='7'>".l(mysql_field_name($row,7))."</label><input class='text'  name='7'  value='$r[7]' /></li>
	</ol></div>";
	echo "<div id='kanan'><ol>
	<li><label for='8'>".l(mysql_field_name($row,8))."</label><input class='text'  name='8'  value='$r[8]' /></li>
	<li><label for='9'>".l(mysql_field_name($row,9))."</label><input class='text'  name='9'  value='$r[9]' /></li>
	<li><label for='10'>".l(mysql_field_name($row,10))."</label><input class='text'  name='10'  value='$r[10]' /></li>
	<li><label for='11'>".l(mysql_field_name($row,11))."</label><input class='text'  name='11'  value='$r[11]' /></li>
	<li><label for='12'>".l(mysql_field_name($row,12))."</label><input class='text'  name='12'  value='$r[12]' /></li>
	</ol></div></fieldset>";
	echo"<div class='clear'></div>";

	echo "<fieldset> <legend>Action</legend>";
 	echo "<div id='kiri'><ol>
		<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol></div></fieldset>";

echo "$r[1]";	
echo "<br> ini id: $id";	


	$tambah=l('tambah');
	echo "<ol>
	<li><label for='11'>".l('kodebarang')."</label><input class='text' name='items11' ></li>
	<li><label for='1'>".l('namabarang')."</label><input class='text' name='items1' ></li>
	<li><label for='2'>".l('ukuran')."</label><input class='text' name='items2' ></li>
	<li><label for='3'>".l('tebal')."</label><input class='text' name='items3' ></li>
	<li><label for='4'>".l('hardness')."</label><input class='text' name='items4' ></li>
	<li><label for='5'>".l('warna')."</label><input class='text' name='items5' ></li>
	<li><label for='6'>".l('size')."</label><input class='text' name='items6' ></li>
	<li><label for='7'>".l('qty')."</label><input class='text' name='items7' ></li>
	<li><label for='8'>".l('totalqty')."</label><input class='text' name='items8' ></li>
	<li><label for='9'>".l('unitprice')."</label><input class='text' name='items9' ></li>
	<li><label for='10'>".l('amount')."</label><input class='text' name='items10' ></li>
	<li><label for='11'>".l('kodebarang')."</label><input class='text' name='items11' ></li>
	
	<li class='buttons'> <input type=button value=$tambah  onclick=submitform('tambah') ></li>
	</ol>";
	
	echo"<div class='clear'></div>";
	echo"</form>";
	
	
	$limit = 2;
	if(isset($_POST['id'])) {	$id=$_POST['id'];}

	$da=$_POST['da'];
	if($da=='ASC') {$da='DESC';} else {$da='ASC';}
	if($_POST['sortir']!="") {$sortir="order by ". $_POST['sortir'] ." $da";} else {$sortir="";}
	
	$datasec=$_POST['test'];
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld1;}
	$offset = get_offset($limit);
	
	$rest ="where induk='$id' ";
	$data='id,kodebarang,namabarang,ukuran,tebal,hardness,warna,size,qty,totalqty,unitprice,amount';

	//$query = "SELECT $data FROM $tbl2 where induk='$id' $sortir LIMIT $offset, $limit  ";	
	$query = "SELECT $data FROM $tbl2 $rest  $sortir LIMIT $offset, $limit ";	
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
	echo "<tr> <td colspan=$jumkolom>";pagingv3($limit,$tbl2,$menu,$mod,$rest,$id); echo "</td></tr>";

 	echo"<tr>";
 	echo "<th><input type=checkbox  onClick=checkUncheckAll(this) ></th>";
	
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>".l($kolom[$i])."</th>"; }
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  { 	
	echo "  <tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td align='center'><input type=checkbox  name='checkbox[]' value=$row[0] ><input type=hidden name='ids[]' value=$row[0] > </td>";
	echo " <td > $row[0] </td> ";
	echo " <td > <input name='1[]' value='$row[1]' ></td> ";
	echo " <td > <input name='2[]' value='$row[2]' ></td> ";
	echo " <td > <input name='3[]' value='$row[3]' ></td> ";
	echo " <td > <input name='4[]' value='$row[4]' ></td> ";
	echo " <td > <input name='5[]' value='$row[5]' ></td> ";
	echo " <td > <input name='6[]' value='$row[6]' ></td> ";
	echo " <td > <input name='7[]' value='$row[7]' ></td> ";
	echo " <td > <input name='8[]' value='$row[8]' ></td> ";
	echo " <td > <input name='9[]' value='$row[9]' ></td> ";
	echo " <td > <input name='10[]' value='$row[10]' ></td> ";
	echo " <td > <input name='11[]' value='$row[11]' ></td> ";
	echo "</tr>";
	}
	echo "</tbody></table>";
	echo "</form>";
	
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
echo "=".	$inv=$_POST[1];

// 	$t= explode(",", $_POST[8]);
//	echo "sum(a) = " . array_sum($t) . "\n";
//	$_POST[9]=array_sum($t);
	$_POST[items10]=($_POST[items9] * $_POST[items8]);


//	$fld2='id,namabarang,ukuran,tebal,hardness,warna,size,qty,totalqty,unitprice,amount';

 	$query="INSERT INTO $tbl2 SET 
	namabarang='$_POST[items1]', 
	ukuran='$_POST[items2]', 
	tebal='$_POST[items3]', 
	hardness='$_POST[items4]', 
	warna='$_POST[items5]', 
	size='$_POST[items6]', 
	qty='$_POST[items7]', 
	totalqty='$_POST[items8]', 
	unitprice='$_POST[items9]', 
	amount='$_POST[items10]', 
	kodebarang='$_POST[items11]', 
 	induk='$id'";
	mysql_query($query)or die('Error 1 '.$query); 
	
	
 	$query="INSERT INTO exim_bc27k_items SET 
	deskripsi='$_POST[items1]', 
	jumlah='$_POST[items8]', 
	nilai='$_POST[items10]', 
	kodebarang='$_POST[items11]', 
 	induk='$inv'";
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
	$query ="DELETE FROM $tbl2 WHERE id='$checked[$i]'"; 
	$result=mysql_query($query) or die('Error Delete: , '.$query); }
 	editform($induk,'save');   
  	}

function update(){extract($GLOBALS);
	$induk=$_POST['induk'];
	$ids= $_POST['ids'];
	$count = count($ids);
	
 	$str1= $_POST['1'];
 	$str2= $_POST['2'];
 	$str3= $_POST['3'];
 	$str4= $_POST['4'];
 	$str5= $_POST['5'];
 	$str6= $_POST['6'];
 	$str7= $_POST['7'];
 	$str8= $_POST['8'];
 	$str9= $_POST['9'];
 	$str10= $_POST['10'];
 	$str11= $_POST['11'];
	
	
//		$fld2='id,induk,banyak,nama,nopo,suratjalan,harga,jumlah' ;

	for($i=0; $i < $count; ++$i){	
	$query ="UPDATE $tbl2 SET 
	namabarang='$str1[$i]', 
	ukuran='$str2[$i]', 
	tebal='$str3[$i]', 
	hardness='$str4[$i]', 
	warna='$str5[$i]', 
	size='$str6[$i]', 
	qty='$str7[$i]', 
	totalqty='$str8[$i]', 
	unitprice='$str9[$i]', 
	amount='$str10[$i]'
	kodebarang='$str11[$i]'
	WHERE id=$ids[$i]"; 
	$result=mysql_query($query) or die('Error Update: , '.$query); }
	editform($induk,'save'); 	
	}



function cetak(){extract($GLOBALS);
	$id=$_POST['id'];

//	$fld='id,kode,tanggal,';
//	for ($i=1;$i<=44; ++$i){$items[]="bc23f".$i ; };
//	$fld.=implode(",", $items);

	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");
	$document = file_get_contents("prints/tmp-invoice.rtf");
	
	for ($i=1;$i<=50; ++$i){		
	$tmp="[a".$i."]";
	$v=$i+2;

	$document = str_replace($tmp, $r[$v], $document);
	};
	
	
	$query = "SELECT * FROM $tbl2 where induk='$id' ";	
	$result = mysql_query($query) or die('Error '. $query );
	$i=1;
	while ($row=mysql_fetch_array($result))  { 	
	$b0 .=$i." \par ";
	$b1 .=$row[2]." \par ";
	$b2 .=$row[3]." \par ";
	$b3 .=$row[4]." \par ";
	$b4 .=$row[5]." \par ";
	$b5 .=$row[6]." \par ";
	$b6 .=$row[7]." \par ";
	$i++;
	}

	$document = str_replace("[ab0]", $b0, $document);
	$document = str_replace("[ab1]", $b1, $document);
	$document = str_replace("[ab2]", $b2, $document);
	$document = str_replace("[ab3]", $b3, $document);
	$document = str_replace("[ab4]", $b4, $document);
	$document = str_replace("[ab5]", $b5, $document);
	$document = str_replace("[ab6]", $b6, $document);


	$fr = fopen('prints/invoice.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/invoice.rtf')</script>";
	
//$word = new COM("word.application") or die("Unable to instantiate Word");
//$word->visible = false;
//$word->Documents->Open(realpath("prints/penjualan.rtf"));
//$word->ActiveDocument->PrintOut(1);
//$word->Quit();
//$word = null;
// 	home();
	
	editform($id,'save'); 
}

function pag(){extract($GLOBALS);
 	$id=$_GET['id'];
	editform($id,'save');
	}

?>