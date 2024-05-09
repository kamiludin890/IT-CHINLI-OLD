<?php global  $title, $mod, $tbl,  $tbls, $fld, $akses;
//	$mod='inventory/lokasi_items';
//	$tbl='inventory_lokasi_items';
//	$fld='id,kode,kategori,nama,satuan,banyak,keterangan,batas,kadaluarsa,lokasi,gambar' ;


	$mod='delivery/sales_contract';
	$tbl='delivery_sales_contract';
	
	$fld='id,';
	for ($i=1;$i<=13; ++$i){$items[]="scf".$i ; };
	$fld.=implode(",", $items);


function editmenu(){extract($GLOBALS);	
	
	switch ($_POST['mysubmit']){
    case "barang": $_SESSION['sb_barang']='barang'; break;
    case "edit": 
    case "pilih": 
    case "pilihbanyak": 
    case "close":  $_SESSION['sb_barang']='home';  break;
	}
	if ($_SESSION['sb_barang']=='barang'){ echo usermenu('pilihbanyak,close');} else{ echo usermenu('update,barang,delete,filter,import,export');}

	
	}

function home(){extract($GLOBALS);global  $title, $mod, $tbl,  $tbls, $fld;
	$induk=$_SESSION['idinduk'];
	$tbl='inventory_lokasi_items';
	//$fld='id,kode,nama,satuan,banyak,lokasi' ;
	$fld='id,kode,kategori,nama,satuan,banyak,keterangan,batas,kadaluarsa,lokasi,gambar' ;

 	if ($rest==''){$rest=" WHERE lokasi=$induk";} else {$rest.=" AND lokasi=$induk";}

	$lokasi=getrow("id,nama,alamat,keterangan","inventory_lokasi","where id=$induk");	
	echo "<form name=myscan action='?mod=$mod&menu=tambah' method='post' id='contactform'>
	<input type=hidden name=menu value=home />	
	";
	echo "<ol>
	<li><label for='1'>".l('ID')."ID</label>$lokasi[id]</li>
	<li><label for='2'>".l('Nama')."</label>$lokasi[nama]</li>
	<li><label for='3'>".l('Alamat')."</label>$lokasi[alamat]</li>
	<li><label for='4'>".l('Keterangan')."</label>$lokasi[keterangan]</li>
	<li><label for='5'>".l('kodebarang').":</label><input type=text name='barcode' id='barcode'class='text' >
	<button type=submit value='tambah'  name='mybutton' class='formbutton' >".l('scan')."</button></li>
	</ol></form>"; 
 echo "<script type='text/javascript' language='JavaScript'>document.forms['myscan'].elements['barcode'].focus();</script>";
 	$menu='home';
 	$limit = 25;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";

	}

function editform($id,$btn){ extract($GLOBALS);  
	if(gubah($akses)!='Admin'){$btn='close';}

	$ro="readonly='readonly'; style=border:none;";
	$row = mysql_query("select $fld from $tbl");

	$r=getrow($fld,$tbl,"where id='$id'");	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	<ol>
	
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' $ro/></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' $ro/></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' $ro/></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' $ro/></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text'  name='5'  value='$r[5]' /></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text'  name='6'  value='$r[6]' $ro/></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text'  name='7'  value='$r[7]' /></li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text'  name='8'  value='$r[8]' /></li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text'  name='9'  value='$r[9]' $ro/></li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text'  name='10'  value='$r[10]' $ro/></li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><input class='text'  name='11'  value='$r[11]' $ro/></li>

	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>

	</ol>
	</form>	";
 	}		 
	
function barang(){extract($GLOBALS);
	$tbl='inventory_barang';
//	$fld='id,kode,kategori,nama,satuan,keterangan' ;
	$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,banyak,keterangan,gambar' ;

	$menu='barang';
	$limit = 25;
	$induk=$_POST[induk];
	$id=$_POST[id];

	$da=$_POST[da];
	if($da=='ASC') {$da='DESC';} else {$da='ASC';}
	if($_POST['sortir']!="") {$sortir="order by ". $_POST['sortir'] ." $da";} else {$sortir="";}

	$datasec=$_POST['test'];
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld;}
	$offset = get_offset($limit);
	
	$query = "SELECT $data FROM $tbl $rest $sortir LIMIT $offset, $limit  ";	
	$result = mysql_query($query) or die('Error Select'.$query);
	$no=1;
	$kolom = explode(",", $data);
	$jumkolom=count($kolom)+1;

	echo "<div class=scroll>";
	echo "<form name=myform action=?mod=$mod&menu=aksi method=post ><input type=hidden name=mysubmit >";
	echo "<input type=hidden name=menu value=$menu >";
	echo "<input type=hidden name=da value=$da >";
	echo "<input type=hidden name=sortir >";
	echo "<input type=hidden name=induk value=$induk >";
	echo "<input type=hidden name=id value=$id >";
	echo "<input type=hidden name=tbl value=$tbl >";
	echo "<input type=hidden name=ids >";
 	echo "<table class=filterable id='table-k' ><thead><tr>";
 	echo "<tr> <td colspan=$jumkolom>";pagingv2($limit,$tbl,'barang',$mod,$rest); filter2($fld,'barang'); echo "</td></tr>";
 	echo "<th><input type=checkbox  onClick=checkUncheckAll(this) ></th>";
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th  style='cursor:pointer;' onclick=fsortir('$kolom[$i]','edot') >$kolom[$i]</th>"; }
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  { 	
	echo "  <tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td align='center'><input type=checkbox  name='checkbox[]' value=$row[0] ></td>";
	for ($i = 0; $i < count($kolom); ++$i) { echo " <td style='cursor:pointer;' onclick=editform($row[0],'pilih')> $row[$i] </td> "; }
	echo "</tr>";
	}
	echo "</tbody></table>";
	echo "</form>";
	echo "</div >";
	}	

function tambah(){ extract($GLOBALS);
 	$induk=$_SESSION['idinduk'];
	$batas='';
	$kadaluarsa='';

	$barang=getrow("*","inventory_barang"," where kode='$_POST[barcode]'");
	$lokasi=$induk;

	if (!isset($barang[0])){ echo "Tidak ditemukan Barang dengan kode : <strong> $_POST[barcode] </strong>";} 
	else {
	$r=getrow("kode","inventory_lokasi_items"," where kode='$_POST[barcode]' and lokasi='$lokasi'");
	if (!isset($r[0])){ 
	$query="INSERT INTO inventory_lokasi_items SET 
	kode='$barang[kode]', 
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	banyak='$barang[banyak]', 
	keterangan='$barang[keterangan]', 
	batas='$batas', 
	kadaluarsa='$kadaluarsa', 
	lokasi='$lokasi',
	gambar='$barang[gambar]'";
	mysql_query($query)or die('Error 1 '.$query); }
	else { echo "Barang <b> $_POST[barcode] </b> Sudah ada </br>";}
	}
	home();	
	}	

function pilih(){ extract($GLOBALS);
 	$induk=$_SESSION['idinduk'];
	$id=$_POST['id'];
	$lokasi=$induk;
	$batas='';
	$kadaluarsa='';

//	$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,banyak,keterangan,gambar' ;
//	$fld='id,kode,kategori,nama,satuan,banyak,keterangan,batas,kadaluarsa,lokasi' ;

	$barang=getrow("*","inventory_barang"," where id='$id'");

	$r=getrow("kode","inventory_lokasi_items"," where kode='$barang[kode]' and lokasi='$lokasi'");
	if (!isset($r[0])){ 
	$query="INSERT INTO inventory_lokasi_items SET 
	kode='$barang[kode]', 
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	banyak='$barang[banyak]', 
	keterangan='$barang[keterangan]', 
	batas='$batas', 
	kadaluarsa='$kadaluarsa', 
	lokasi='$lokasi',
	gambar='$barang[gambar]'";
	mysql_query($query)or die('Error 1 '.$query);
	echo "Barang <b> $barang[kode] </b>, ditambahkan!</br>";} 
	else { echo "Barang <b> $barang[kode] </b> Sudah ada !</br>";}
	home();
	}	

function pilihbanyak(){ extract($GLOBALS);
 	$induk=$_SESSION['idinduk'];
	$iditem=$_POST['checkbox'];
	$kodeitem= $_POST['kodeitem'];
	$lokasi=$induk;
	$batas='';
	$kadaluarsa='';

	for($i=0; $i < count($iditem); ++$i){
	$barang=getrow("*","inventory_barang"," where id='".$iditem[$i]."'");
	$r=getrow("kode","inventory_lokasi_items"," where kode='$barang[kode]' and lokasi='$lokasi'");
	if (!isset($r[0])){ 
	$query="INSERT INTO inventory_lokasi_items SET 
	kode='$barang[kode]', 
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	banyak='$barang[banyak]', 
	keterangan='$barang[keterangan]', 
	batas='$batas', 
	kadaluarsa='$kadaluarsa', 
	lokasi='$lokasi',
	gambar='$barang[gambar]'";
	mysql_query($query)or die('Error 1 '.$query);
	echo "Barang <b> $barang[kode] </b>, ditambahkan!</br>";} 
	else { echo "Barang <b> $barang[kode] </b> Sudah ada </br>";}
	}
	home();
	}
function update(){extract($GLOBALS);
	echo "<script type='text/javascript'>window.location.href='?menu=update&mod=inventory/lokasi'</script>";
	}
 ?>