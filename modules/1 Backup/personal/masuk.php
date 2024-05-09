<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='personal/masuk';
	$tbl='inventory_distribusi';
	$fld='id,kode,tanggal,pembuat,kegiatan,lokasi,kontak,keterangan,status' ;

function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('lanjut,close');} 
//	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('delete,lokasi,barang,update');}
	}

function home(){extract($GLOBALS);	global  $result;
	$fld='id,kode,tanggal,pembuat,lokasi,keterangan,status' ;
 	if ($rest==''){$rest=" where kegiatan='masuk'";} else { $rest.=" and kegiatan='masuk'";}
	$limit = 50;
	$result='home' ;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}
	
function editform($id,$btn){ extract($GLOBALS); 
	echo 	$hasil=$_POST['hasil'];
	$ro="readonly='readonly'; style=border:none;";

//	$induk=$_SESSION['idinduk'];
	$induk=1;

	$tbl='inventory_distribusi_items';
	$fld='id,tanggal,kodebarang,nama,satuan,masuk,keterangan' ;
	
 	if ($rest==''){$rest=" WHERE induk=$induk";} else {$rest.=" AND induk=$induk";}

	$masuk=getrow("*","inventory_distribusi","where id=$induk");
	$row = mysql_query("select * from inventory_distribusi");
	
	$_SESSION['idlokasi']=$masuk['lokasi'];
	
	if($masuk['status']=='Selesai'){$s="disabled='disabled'"; };

	echo "<form name=myscan action='?mod=$mod&menu=aksi' method='post' id='contactform'>";
	echo "<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$masuk[1]' $ro /> </li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$masuk[2]' $ro /> </li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$masuk[3]' $ro /></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$masuk[4]' $ro /></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$masuk[5]' $ro /></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$masuk[6]' $ro /></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$masuk[7]' $ro /></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$masuk[8]' $ro /></li>
	</ol></form>"; 
	 echo "<script type='text/javascript' language='JavaScript'>document.forms['myscan'].elements['barcode'].focus();</script>";
   
   
//table   
	$limit = 25;
//	$induk=$_POST['induk'];
	$id=$_POST['id'];

	$da=$_POST['da'];
	if($da=='ASC') {$da='DESC';} else {$da='ASC';}
	if($_POST['sortir']!="") {$sortir="order by ". $_POST['sortir'] ." $da";} else {$sortir="";}
	
	$datasec=$_POST['test'];
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld;}
	$offset = get_offset($limit);
	
	$query = "SELECT $data FROM $tbl $rest $sortir LIMIT $offset, $limit  ";	
//	$rows = mysql_query($query);

	$result = mysql_query($query) or die('Error Select'.$query);
	$no=1;
	$kolom = explode(",", $data);
	$jumkolom=count($kolom)+1;

 	echo "<form name=myform action=?mod=$mod&menu=aksi method=post ><input type=hidden name=mysubmit >";
	echo "<input type=hidden name=menu value=$menu >";
	echo "<input type=hidden name=da value=$da >";
	echo "<input type=hidden name=sortir >";
	echo "<input type=hidden name=induk value=$induk >";
	echo "<input type=hidden name=id value=$id >";
	echo "<input type=hidden name=tbl value=$tbl >";
	echo "<input type=hidden name=ids >";
	echo "<input type=hidden name=items >";
	
	echo "<input type=text name='barcode' id='barcode'class='text' $s > <input type=submit name=tambah value=tambah>";

 	echo "<table class=filterable id='table-k' ><thead><tr>";
 	echo "<th><input type=checkbox  onClick=checkUncheckAll(this) ></th>";
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>".l($kolom[$i])."</th>"; }
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  { 	
	echo "  <tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td align='center'><input type=checkbox  name='checkbox[]' value=$row[0] ><input type=hidden name='ids[]' value=$row[0] > </td>";
	echo " <td > $row[0] </td> ";
	echo " <td > $row[1] </td> ";
	echo " <td > $row[2] </td> ";
	echo " <td > $row[3] </td> ";
	echo " <td > $row[4] </td> ";
	echo " <td > <input type=text name='masuk[]' value=$row[5] > </td> ";
	echo " <td > $row[6] </td> ";
	echo "</tr>";
	}
	echo "</tbody></table>";

	echo "</form>";
	
// end table
  	}	
	
 

function beraksi(){extract($GLOBALS);
// if (isset($_POST['hasil'])){ pilih();}

if (isset($_POST['untuk'])&& $_POST['untuk']=='lokasi'){ getlokasi();}
if (isset($_POST['untuk'])&& $_POST['untuk']=='barang'){ pilih();}
if (isset($_POST['untuk'])&& $_POST['untuk']=='pilihbanyak'){  pilihbanyak();}
 
if (isset($_POST['update'])){ iupdate(); }
if (isset($_POST['delete'])){ hapus(); }
if (isset($_POST['tambah'])){ tambah(); }
if (isset($_POST['barang'])){ barang(); }
if (isset($_POST['lokasi'])){ lokasi(); }

}

function lokasi(){extract($GLOBALS);
	$tbl='inventory_lokasi';
	$fld='id,nama,alamat,keterangan' ;
	echo "<form name='myform' method='post' action='?mod=master/select'>
	<input type='hidden' name='asal' value='personal/masuk'>
	<input type='hidden' name='tbl' value='$tbl'>
	<input type='hidden' name='fld' value='$fld'>
	<input type='hidden' name='untuk' value='lokasi'>
	<script language='Javascript'>document.myform.submit();</script></form>";
 	}


function barang(){extract($GLOBALS);
	$tbl='inventory_lokasi_items';
	$fld='id,kode,kategori,nama,satuan,banyak,keterangan,batas,kadaluarsa,lokasi,gambar' ;
	echo "<form name='myform' method='post' action='?mod=master/select'>
	<input type='hidden' name='asal' value='personal/masuk'>
	<input type='hidden' name='tbl' value='$tbl'>
	<input type='hidden' name='fld' value='$fld'>
	<input type='hidden' name='untuk' value='barang'>
	<script language='Javascript'>document.myform.submit();</script></form>";
 	}

function getlokasi(){extract($GLOBALS);
	echo "lokasi";
	editform($id,$btn); 
	}

function hapus(){extract($GLOBALS);
	$kolom = explode(",", $_POST['tbl']);
	$tbl=$kolom[0];
	$induk=$_POST['induk'];
	$checked = $_POST['checkbox'];
	$count = count($checked);

	for($i=0; $i < $count; ++$i){	
	$query ="DELETE FROM $tbl WHERE id='$checked[$i]'"; 
	$result=mysql_query($query) or die('Error Delete, '.$query); }
	editform($id,$btn); 
	}

function pilih(){ extract($GLOBALS);
	$id=1;
//	echo $_POST['hasil'];
//	$barang=getrow("kode,nama,satuan,keterangan","inventory_lokasi_items"," where kode='$_POST[hasil]' AND lokasi=$lokasi");
	$barang=getrow("kode,nama,satuan,keterangan","inventory_lokasi_items"," where id='$_POST[hasil]'");
	if (!isset($barang[0])){ echo l('tidak_ditemukan')."<strong> $_POST[hasil] </strong>";}
	else {
	$r=getrow("kodebarang","inventory_distribusi_items"," where kodebarang='$barang[kode]' and induk='$id'");
	if (!isset($r[0])){ $query="INSERT INTO inventory_distribusi_items SET 
	kodebarang='$barang[kode]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	masuk=1, 
	keterangan='$barang[keterangan]', 
	induk='$id'";
	mysql_query($query)or die('Error 1 '.$query); 
	echo l('ditambahkan')."<b> $_POST[barcode] </b> </br>";}
	else { $query="UPDATE inventory_distribusi_items SET masuk=masuk + 1 WHERE kodebarang='$barang[kode]' and induk='$id'"; 
	mysql_query($query)or die('Error 1 '.$query); 
	echo l('ditambahkan')."<b> $_POST[barcode] </b> </br>";}
	}
	 editform($id,$btn); 
	}

function pilihbanyak(){ extract($GLOBALS);
echo 	$id=1;
	
		$kolom = explode(",", $_POST['hasil']);
	for ($i = 0; $i < count($kolom); ++$i ) { //echo  $kolom[$i]."<br>"; 

//editform($id,$btn); 
	
	$barang=getrow("kode,nama,satuan,keterangan","inventory_lokasi_items"," where id='".$kolom[$i]."'");
	$r=getrow("kodebarang","inventory_distribusi_items"," where kodebarang='$barang[kode]' and induk='$id'");
	if (!isset($r[0])){ $query="INSERT INTO inventory_distribusi_items SET 
	kodebarang='$barang[kode]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	masuk=1, 
	keterangan='$barang[keterangan]', 
	induk='$id'";
	mysql_query($query)or die('Error 1 '.$query);
	echo  l('ditambahkan')." <b> $barang[kode] </b></br>";} 
	else { $query="UPDATE inventory_distribusi_items SET masuk=masuk + 1 WHERE kodebarang='$barang[kode]' and induk='$id'"; 
	mysql_query($query)or die('Error 1 '.$query);
	echo  l('ditambahkan')." <b> $barang[kode] </b></br>";}
	
	
	}
	 
  editform($id,$btn); 

	}
	
function update(){extract($GLOBALS);
	$induk=$_POST['induk'];
	
	$checked = $_POST['masuk'];
	$ids= $_POST['ids'];
	$count = count($checked);

	for($i=0; $i < $count; ++$i){	
	$query ="UPDATE inventory_distribusi_items SET masuk=$checked[$i] WHERE id=$ids[$i]"; 
	$result=mysql_query($query) or die('Error Delete, '.$query); }
	editform($id,$btn); 
	
	}
	
?>