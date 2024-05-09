<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='pos/kontak_items';
	$tbl='pos_kontak_items';
	$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,keterangan,gambar,kontak';


function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	elseif($_POST['mysubmit']=='barang'){echo usermenu('close,pilihbanyak');}
	elseif($_POST['mysubmit']=='pilih'){echo usermenu('update,barang,delete,filter,import,export');}
	elseif($_POST['mysubmit']=='pilihbanyak'){echo usermenu('update,barang,delete,filter,import,export');}
	elseif($_GET['menu']=='barang'){echo usermenu('close,pilihbanyak');}
	else{echo usermenu('update,barang,delete,filter,import,export');}
	}

function home(){extract($GLOBALS);global  $title, $mod, $tbl,  $tbls, $fld;
//	$fld='id,kodebarang,harga,diskon,hargajual,kontak,lokasi';
	$induk=$_SESSION['idinduk'];
	$tbl='pos_kontak_items';
	$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,keterangan,gambar,kontak';


 	if ($rest==''){$rest=" WHERE kontak=$induk";} else {$rest.=" AND kontak=$induk";}
	$row = mysql_query("select id,kategori,nama,alamat,telpon,keterangan from pos_kontak");

	$kontak=getrow("id,kategori,nama,alamat,telpon,keterangan","pos_kontak","where id=$induk");	
	echo "<form name=myscan action='?mod=$mod&menu=tambah' method='post' id='contactform'>";
	echo "<ol>
	<li><label for='1'>".l(mysql_field_name($row, 0))."</label>$kontak[id]</li>
	<li><label for='2'>".l(mysql_field_name($row, 1))."</label>".l($kontak['kategori'])."</li>
	<li><label for='3'>".l(mysql_field_name($row, 2))."</label>$kontak[nama]</li>
	<li><label for='4'>".l(mysql_field_name($row, 3))."</label>$kontak[alamat]</li>
	<li><label for='5'>".l(mysql_field_name($row, 4))."</label>$kontak[telpon]</li>
	<li><label for='6'>".l(mysql_field_name($row, 5))."</label>$kontak[keterangan]</li>
	
	<li><label for='9'>Barcode:</label><input type=text name='barcode' id='barcode'class='text' >
	<button type=submit value='tambah' name='mybutton' class='formbutton' >".l('Scan')."</button></li>

	</ol></form>"; 
 echo "<script type='text/javascript' language='JavaScript'>document.forms['myscan'].elements['barcode'].focus();</script>";
 	$limit = 25;
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";

	}

function editform($id,$btn){ extract($GLOBALS);  

	$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,keterangan,gambar,kontak';

	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");	
	echo "<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />	
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' type=hidden />$r[1]</li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' type=hidden />$r[2]</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' type=hidden />$r[3]</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' type=hidden />$r[4]</li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]' id='harga' /></li>	
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]' id='diskon' /></li>	
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]' id='jumlah' /></li>	
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]' type=hidden />$r[8]</li>	
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[9]' type=hidden />$r[9]</li>	
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text' name='10' value='$r[10]' type=hidden />$r[10]</li>	
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>";
	echo "</form>	
	
	<script type='text/javascript'>
	(function(){
 	harga = document.getElementById('harga');
	diskon = document.getElementById('diskon');
	jumlah = document.getElementById('jumlah');

 	function calculate(){
 		jumlah.innerHTML = jumlah.value = harga.value == 0 || !harga.value? 0 : harga.value == 1? harga.value : harga.value - diskon.value;
 	}
	calculate();
 	diskon.onkeyup = diskon.onmouseout = calculate;
	harga.onkeyup = harga.onmouseout = calculate;
	
})();
</script> 

";
 	}		 
	
function barang(){extract($GLOBALS);

	$tbl='inventory_barang';
	$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,keterangan,gambar' ;


	$menu='barang';
	$limit = 25;
	$induk=$_POST['induk'];
	$id=$_POST['id'];

	$da=$_POST['da'];
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
	echo "<input type=hidden name=induk value=$induk >";
	echo "<input type=hidden name=menu value=$menu >";
	echo "<input type=hidden name=da value=$da >";
	echo "<input type=hidden name=sortir >";
	echo "<input type=hidden name=id value=$id >";
	echo "<input type=hidden name=tbl value=$tbl >";
	echo "<input type=hidden name=ids >";
 	echo "<table class=filterable id='table-k' ><thead><tr>";
 	echo "<tr> <td colspan=$jumkolom>";pagingv2($limit,$tbl,'barang',$mod,$rest); filter2($fld,'barang'); echo "</td></tr>";
 	echo "<th><input type=checkbox  onClick=checkUncheckAll(this) ></th>";
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>".l($kolom[$i])."</th>"; }
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  { 	
	echo "  <tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td align='center'><input type=checkbox  name='checkbox[]' value=$row[0] ></td>";
	for ($i = 0; $i < count($kolom); ++$i) { echo " <td class=difcursor onclick=editform($row[0],'pilih')> $row[$i] </td> "; }
	echo "</tr>";
	}
	echo "</tbody></table>";
	echo "</form>";
	echo "</div >";
	}
	
function tambah(){ extract($GLOBALS);
 	$induk=$_SESSION['idinduk'];

	$barang=getrow("*","inventory_barang"," where kode='$_POST[barcode]'");
	$kontak=$induk;

	if (!isset($barang[0])){ echo l('tidak_ditemukan')."<strong> $_POST[barcode] </strong>";} 
	else {
	$r=getrow("kode","pos_kontak_items"," where kode='$_POST[barcode]' and kontak='$kontak'");
	if (!isset($r[0])){ $query="INSERT INTO pos_kontak_items SET 
	kode='$_POST[barcode]', 
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	harga='$barang[harga]', 
	diskon='$barang[diskon]', 
	hargajual='$barang[hargajual]', 
	keterangan='$barang[keterangan]', 
	gambar='$barang[gambar]', 
	kontak='$kontak'";
	mysql_query($query)or die('Error 1 '.$query); }
	else { echo l('sudah_ada').": <b> $_POST[barcode] </b> </br>";}
	}
	home();	
	}	

function pilih(){ extract($GLOBALS);
 	$induk=$_SESSION['idinduk'];
	$id=$_POST['id'];
	$kontak=$induk;

	$barang=getrow("*","inventory_barang"," where id='$id'");
	$r=getrow("kode","pos_kontak_items"," where kode='$barang[kode]' and kontak='$kontak'");
	if (!isset($r[0])){ $query="INSERT INTO pos_kontak_items SET 
	kode='$barang[kode]', 
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	harga='$barang[harga]', 
	diskon='$barang[diskon]', 
	hargajual='$barang[hargajual]', 
	keterangan='$barang[keterangan]', 
	gambar='$barang[gambar]', 
	kontak='$kontak'";
	mysql_query($query)or die('Error 1 '.$query);
	echo l('ditambahkan')." <b> $barang[kode] </b></br>";} 
	else { echo l('sudah_ada')." <b> $barang[kode] </b> </br>";}
	home();	
	}	

function pilihbanyak(){ extract($GLOBALS);
 	$induk=$_SESSION['idinduk'];
	$iditem=$_POST['checkbox'];
	$kontak=$induk;

	for($i=0; $i < count($iditem); ++$i){
	$barang=getrow("*","inventory_barang"," where id='$iditem[$i]'");
	$r=getrow("kode","pos_kontak_items"," where kode='$barang[kode]' and kontak='$kontak'");
	if (!isset($r[0])){ $query="INSERT INTO pos_kontak_items SET 
	kode='$barang[kode]', 
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	harga='$barang[harga]', 
	diskon='$barang[diskon]', 
	hargajual='$barang[hargajual]', 
	keterangan='$barang[keterangan]', 
	gambar='$barang[gambar]', 
	kontak='$kontak'";
	mysql_query($query)or die('Error 1 '.$query);
	echo l('ditambahkan')." <b> $barang[kode] </b>!</br>";} 
	else { echo l('sudah_ada')." <b> $barang[kode] </b> !</br>";}
	}
	home();	
	}

function update(){extract($GLOBALS);
	echo "<script type='text/javascript'>window.location.href='?menu=update&mod=pos/kontak'</script>";
	}


 ?>