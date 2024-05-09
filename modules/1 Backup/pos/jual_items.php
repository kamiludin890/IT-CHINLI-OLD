<?php global  $title, $mod, $tbl, $fld, $akses;
	$mod='pos/jual_items';
	$tbl='pos_transaksi_items';
	$fld='id,induk,kode,tanggal,kodebarang,kategori,nama,satuan,banyak,harga,diskon,hargajual,jual,lokasi,kontak,kegiatan' ;
	

function editmenu(){extract($GLOBALS);	
	$induk=$_SESSION['idinduk'];

	$jual=getrow("status,ppnstatus","pos_transaksi","where id=$induk");	
	
	
	switch ($_POST['mysubmit']){
    case "barang": $_SESSION['sb_barang']='barang'; break;
 	case "edit": echo usermenu('save,close'); break;
    case "pilih": 
    case "pilihbanyak": 
    case "close":  $_SESSION['sb_barang']='home';  break;
	}
	if ($_GET['res']=='h'){$_SESSION['sb_barang']='home';} 
	
	if ($_SESSION['sb_barang']=='barang'){ echo usermenu('pilihbanyak,close');} else{
	if($jual['status']=='Selesai'){$btn='cetak'; echo usermenu($btn);} else {echo usermenu('selesai,barang,delete');}}
	}

function home(){extract($GLOBALS);global  $result;
	$induk=$_SESSION['idinduk'];
		
	echo "	";

	$query="UPDATE pos_transaksi_items SET jual=hargajual*banyak WHERE induk='$induk'";
	mysql_query($query)or die('Error 1 '.$query); 
 
  	$jml=getrow("sum(jual)","pos_transaksi_items"," where induk='$induk'"); $subtotal=$jml['sum(jual)'];
	
	if (isset($jml[0])){
	$jual=getrow("ppnstatus","pos_transaksi","where id=$induk");	
	if($jual['ppnstatus']=='ya'){$ppn=$subtotal*0.1;} else {$ppn=0;}

	$query="UPDATE pos_transaksi SET subtotal='$subtotal', ppn=$ppn, total=subtotal+ppn  WHERE id='$induk'";
	mysql_query($query)or die('Error 1 '.$query); }


 	if ($rest==''){$rest=" WHERE induk=$induk";} else {$rest.=" AND induk=$induk";}

	$row = mysql_query("select * from pos_transaksi");
	$r=getrow("*","pos_transaksi","where id=$induk");
	$_SESSION['idlokasi']=$r['lokasi'];
	$_SESSION['idkontak']=$r['kontak'];

	if($r['status']=='Selesai'){$s="disabled='disabled'"; };

	echo "<form name=myscan action='?mod=$mod&menu=aksi' method='post' id='contactform'>";
	
	
	
	echo "<div id='kiri'>";
	echo "<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' type=hidden />$r[1]</li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' type=hidden />$r[2]</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' type=hidden />$r[3]</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' type=hidden />".l($r[4])."</li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]' type=hidden />$r[5]</li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]' type=hidden />$r[6]</li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]' type=hidden />".l($r[7])."</li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]' type=hidden />$r[8]</li>
	</ol>";
	echo "</div>";
	echo "<div id='kanan'>";
	echo "<ol>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text'  name='9'  value='$r[9]'  type=hidden />".format_rupiah($r[9])."</li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text'  name='10'  value='$r[10]' type=hidden />".format_rupiah($r[10])."</li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><input class='text'  name='11'  value='$r[11]' type=hidden id='total'  /><b>".format_rupiah($r[11])."</b></li>

	<li><label for='12'>".l(mysql_field_name($row, 12))."</label><input class='text' name='12' value='$r[12]' type=hidden />$r[12]</li>
	<li><label for='13'>".l(mysql_field_name($row, 13))."</label><input class='text' name='13' value='$r[13]' type=hidden />".l($r[13])."</li>
	
	<li><label for='14'>Barcode:</label>
	<input type=text name='banyak' id='banyak' class='banyak' value='1'>
	<input type=text name='barcode' id='barcode' class='barcode' $s >
	<button type=submit value='tambah'  name='mybutton' class='formbutton' $s >".l('scan')."</button></li>
	
	</ol>";
	echo "</div>";
	echo"<div class='clear'></div>";
	echo"
	
</form>
	
	
	
	
	"; 
 echo "<script type='text/javascript' language='JavaScript'>document.forms['myscan'].elements['barcode'].focus();</script>";
 	$limit = 25;
	$result='home';
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']="SELECT $fld from $tbl $rest ";
	}

function editform($id,$btn){ extract($GLOBALS);  
	if(gubah($akses)!='Admin'){$btn='close';}

//	$fld='id,induk,kode,tanggal,kodebarang,kategori,nama,satuan,banyak' ;
	$fld='id,induk,kode,tanggal,kodebarang,kategori,nama,satuan,banyak,harga,diskon,hargajual,jual,lokasi,kontak' ;

	$induk=$_SESSION['idinduk'];
	$jual=getrow("status","pos_transaksi","where id=$induk");
	if($jual['status']=='Selesai'){$s="disabled='disabled'"; $ro="readonly='readonly'";};

	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");	

	echo "<form name='myform' action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type='hidden' name='id' value='$id' /> <input type='hidden' name='mysubmit' /> 
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]' type=hidden />$r[1]</li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]' type=hidden />$r[2]</li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]' type=hidden />$r[3]</li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]' type=hidden />$r[4]</li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><input class='text' name='5' value='$r[5]' type=hidden />$r[5]</li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]' type=hidden />$r[6]</li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]' type=hidden />$r[7]</li>
	<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]' $ro /> </li>
	<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[9]' $ro /> </li>
	<li><label for='10'>".l(mysql_field_name($row, 10))."</label><input class='text' name='10' value='$r[10]' type=hidden />$r[10]</li>
	<li><label for='11'>".l(mysql_field_name($row, 11))."</label><input class='text' name='11' value='$r[11]' type=hidden />$r[11]</li>
	<li><label for='12'>".l(mysql_field_name($row, 12))."</label><input class='text' name='12' value='$r[12]' type=hidden />$r[12]</li>
	<li><label for='13'>".l(mysql_field_name($row, 13))."</label><input class='text' name='13' value='$r[13]' type=hidden />$r[13]</li>
	<li><label for='14'>".l(mysql_field_name($row, 14))."</label><input class='text' name='14' value='$r[14]' type=hidden />$r[14]</li>
	<li><label for='15'>".l(mysql_field_name($row, 15))."</label><input class='text' name='15' value='$r[15]' type=hidden />$r[15]</li>

	<li class='buttons'> <button type=submit value=$btn  name='mybutton' class='formbutton' $s >".l($btn)."</button></li>
	</ol></form>";
 	}		 

function barang(){extract($GLOBALS);
	$lokasi=$_SESSION['idlokasi'];
	$kontak=$_SESSION['idkontak'];
 
	$tbl='pos_kontak_items';
	$fld='id,kode,kategori,nama,satuan,harga,diskon,hargajual,keterangan,gambar,kontak';

 	if ($rest==''){$rest=" WHERE kontak=$kontak";} else {$rest.=" AND kontak=$kontak";}

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
	$lokasi=$_SESSION['idlokasi'];
	$kontak=$_SESSION['idkontak'];
	$banyak=$_POST['banyak'];
	
	$barang=getrow("*","pos_kontak_items"," where kode='$_POST[barcode]' AND kontak=$kontak");

	if (!isset($barang[0])){ echo "Tidak ditemukan Barang dengan kode : <strong> $_POST[barcode] </strong>";} 
	else { $r=getrow("kodebarang","pos_transaksi_items"," where kodebarang='$_POST[barcode]' and induk='$induk'");
	
//	$fld='id,induk,kode,tanggal,kodebarang,kategori,nama,satuan,banyak,harga,diskon,hargajual,jual,lokasi,kontak' ;

	if (!isset($r[0])){ $query="INSERT INTO pos_transaksi_items SET 
	kodebarang='$_POST[barcode]', 
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	banyak=$banyak, 
	harga='$barang[harga]', 
	diskon='$barang[diskon]', 
	hargajual='$barang[hargajual]', 
	jual=hargajual*banyak, 
	lokasi='$lokasi', 
	kontak='$kontak', 
	induk='$induk'"; }
	else { $query="UPDATE pos_transaksi_items SET banyak=banyak+$banyak, jual=hargajual*banyak WHERE kodebarang='$_POST[barcode]' and induk='$induk'"; }
	mysql_query($query)or die('Error 1 '.$query); 
	 echo l('ditambahkan')."<b>  $_POST[barcode] ($_POST[banyak])</b></br>";
	}
	home();	
	}	

function pilih(){ extract($GLOBALS);
 	$induk=$_SESSION['idinduk'];
	$lokasi=$_SESSION['idlokasi'];
	$kontak=$_SESSION['idkontak'];

	$id=$_POST['id'];
	$barang=getrow("*","pos_kontak_items"," where id='$id' ");
	$r=getrow("kodebarang","pos_transaksi_items"," where kodebarang='$barang[kode]' and induk='$induk'"); 
	
	if (!isset($r[0])){ $query="INSERT INTO pos_transaksi_items SET 
	kodebarang='$barang[kode]',  
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	banyak=1, 
	harga='$barang[harga]', 
	diskon='$barang[diskon]', 
	hargajual='$barang[hargajual]', 
	jual=hargajual*banyak, 
	lokasi='$lokasi', 
	kontak='$kontak', 
	induk='$induk'";
	mysql_query($query)or die('Error 1 '.$query);
	echo l('ditambahkan')." <b> $barang[kode] </b>!</br>";} 
	else { $query="UPDATE pos_transaksi_items SET banyak=banyak+ 1, jual=hargajual*banyak WHERE kodebarang='$barang[kode]' and induk='$induk'"; 
	mysql_query($query)or die('Error 1 '.$query);
	echo l('ditambahkan')." <b> $barang[kode] </b>!</br>";}
	home();
	}	

function pilihbanyak(){ extract($GLOBALS);
	$lokasi=$_SESSION['idlokasi'];
	$kontak=$_SESSION['idkontak'];
 	$induk=$_SESSION['idinduk'];
	$iditem=$_POST['checkbox'];

	for($i=0; $i < count($iditem); ++$i){
	$barang=getrow("*","pos_kontak_items"," where id='".$iditem[$i]."'");
	$r=getrow("kodebarang","pos_transaksi_items"," where kodebarang='$barang[kode]' and induk='$induk'");
	if (!isset($r[0])){ $query="INSERT INTO pos_transaksi_items SET 
	kodebarang='$barang[kode]',  
	kategori='$barang[kategori]', 
	nama='$barang[nama]', 
	satuan='$barang[satuan]', 
	banyak=1, 
	harga='$barang[harga]', 
	diskon='$barang[diskon]', 
	hargajual='$barang[hargajual]', 
	jual=hargajual*banyak, 
	lokasi='$lokasi', 
	kontak='$kontak', 
	induk='$induk'";
	mysql_query($query)or die('Error 1 '.$query);
	echo l('ditambahkan')." <b> $barang[kodebarang] </b>!</br>";} 
	else { $query="UPDATE pos_transaksi_items SET banyak=banyak+ 1, jual=hargajual*banyak WHERE kodebarang='$barang[kode]' and induk='$induk'"; 
	mysql_query($query)or die('Error 1 '.$query);
	 echo l('ditambahkan')."<b> $barang[kodebarang] </b> !</br>";}
	}
	home();
	}
	
function selesai(){extract($GLOBALS);
	$induk=$_SESSION['idinduk'];

	$jual=getrow("*","pos_transaksi","where id=$induk");	
	if($jual['ppnstatus']=='ya'){ $nofak=getfaktur("jualppn","-JL"); } else {$nofak=getfaktur("jual","-JNP");}
	$lokasi=$jual['lokasi'];
	$tanggal=date('Y-m-d');
	
	$query2="UPDATE pos_transaksi SET kode='$nofak', tanggal='$tanggal', status='Selesai' WHERE id='$induk'";
	mysql_query($query2)or die('Error 2'.$query2);

	$query2="UPDATE pos_transaksi_items SET kode='$nofak', tanggal='$tanggal', lokasi='$lokasi', kegiatan='jual' WHERE induk='$induk'";
	mysql_query($query2)or die('Error 2'.$query2);
	
	$query="Select kodebarang,banyak from pos_transaksi_items WHERE induk='$induk'";
	$result=mysql_query($query)or die('Error 1'.$query);
	while ($row=mysql_fetch_array($result))  { 	
	$banyak=$row['banyak'];
	if (!isset($row[0])){ echo "Gagal, barang tidak ditemukan";} 
	else { 	$query1="UPDATE inventory_lokasi_items SET banyak=banyak-'$row[banyak]' WHERE kode='$row[kodebarang]' and lokasi=$lokasi";}
	mysql_query($query1)or die('Error 1'.$query1);
	}
	
	
	
	$username= $_SESSION['username'];
	$user=getrow("otagihan,opersediaan","master_user","where email='$username'");	
	$otagihan=$user['otagihan'];
	$opersediaan=$user['opersediaan'];

	if ($otagihan=='ya'){
	$query5="INSERT INTO pos_tagihan(kode,tanggal,kegiatan,keterangan,status,kontak,total) 
	select kode,tanggal,'Piutang',keterangan,'Belum Lunas',kontak,total from pos_transaksi where id=$induk ";
	mysql_query($query5)or die('Error 5'.$query5);
	}
	if ($opersediaan=='ya'){

	$query4="INSERT INTO inventory_distribusi(kode,tanggal,pembuat,kegiatan,lokasi,kontak,keterangan,status) 
	select kode,tanggal,pembuat,'Keluar',lokasi,kontak,keterangan,'Selesai' from pos_transaksi where id=$induk ";
	mysql_query($query4)or die('Error 4'.$query4);
	
	$id=mysql_insert_id();
	
	$query3="INSERT INTO  inventory_distribusi_items (induk,kode,tanggal,kodebarang,nama,satuan,keluar,lokasi,kontak) 
	select $id,kode,tanggal,kodebarang,nama,satuan,banyak,lokasi,kontak from pos_transaksi_items where induk=$induk ";
	mysql_query($query3)or die('Error 3'.$query3);
	
	}
	
	echo "<script type='text/javascript'>window.location.href='?mod=$mod&menu=home'</script>";
//	home();	
	}	

function faktur(){extract($GLOBALS);
	$id=$_SESSION['idinduk'];
	$document = file_get_contents("prints/tmp-faktur.rtf");
	$jual=getrow("*","pos_transaksi","where id='$id'");
	$kontak=getrow("*","pos_kontak","where id='$jual[kontak]'");
	$sales=getrow("*","pos_kontak","where id='$jual[sales]'");
	$alamat=getrow("alamat","master_setting","");

	$document = str_replace("[a0]", $alamat['alamat'], $document);

	$document = str_replace("[a1]", $jual['kode'], $document);
	$document = str_replace("[a2]", $jual['sales'], $document);
	$document = str_replace("[a3]", $sales['nama'], $document);
	$document = str_replace("[a4]", $jual['tanggal'], $document);
	$document = str_replace("[a5]", $jual['kontak'], $document);
	$document = str_replace("[a6]", $kontak['nama'], $document);
	$document = str_replace("[a7]", $kontak['alamat'], $document);
	$document = str_replace("[a8]", $kontak['telpon'], $document);
	$document = str_replace("[a9]", $jual['keterangan'], $document);
	$document = str_replace("[a10]", terbilang($jual['total']), $document);
	$document = str_replace("[a11]", format_rupiah($jual['subtotal']), $document);
	$document = str_replace("[a12]", format_rupiah($jual['ppn']), $document);
	$document = str_replace("[a13]", format_rupiah($jual['total']), $document);
	$document = str_replace("[a14]", $jual['pembuat'], $document);

	$query = "SELECT * FROM pos_transaksi_items where induk='$id' ";	
	$result = mysql_query($query) or die('Error');

	while ($row=mysql_fetch_array($result))  { 	
//	$barang=getrow("nama","barang","where kode='$row[kodebarang]'");
	$b1 .=$row['kodebarang']." \par ";
	$b2 .=$row['nama']." \par ";
	$b3 .=$row['satuan']." \par ";
	$b4 .=$row['banyak']." \par ";
	$b5 .=$row['harga']." \par ";
	$b6 .=$row['diskon']." \par ";
	$b7 .=$row['jual']." \par ";

//	$a7=$a7+$row[jumlah];
//	$i++;
	}

	$document = str_replace("[aa1]", $b1, $document);
	$document = str_replace("[ab1]", $b2, $document);
	$document = str_replace("[ac1]", $b3, $document);
	$document = str_replace("[ad1]", $b4, $document);
	$document = str_replace("[ae1]", $b5, $document);
	$document = str_replace("[af1]", $b6, $document);
	$document = str_replace("[ag1]", $b7, $document);

	$fr = fopen('prints/faktur.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/faktur.rtf')</script>";
	
//$word = new COM("word.application") or die("Unable to instantiate Word");
//$word->visible = false;
//$word->Documents->Open(realpath("prints/penjualan.rtf"));
//$word->ActiveDocument->PrintOut(1);
//$word->Quit();
//$word = null;
 	home();
}

function cetak(){extract($GLOBALS);
	$id=$_SESSION['idinduk'];
	$document = file_get_contents("prints/tmp-penjualan.rtf");
	$jual=getrow("*","pos_transaksi","where id='$id'");
	$kontak=getrow("*","pos_kontak","where id='$jual[kontak]'");
	$sales=getrow("*","pos_kontak","where id='$jual[sales]'");
	$alamat=getrow("alamat","master_setting","");

	$document = str_replace("[a0]", $alamat['alamat'], $document);

	$document = str_replace("[a1]", $jual['kode'], $document);
	$document = str_replace("[a2]", $jual['sales'], $document);
	$document = str_replace("[a3]", $sales['nama'], $document);
	$document = str_replace("[a4]", $jual['tanggal'], $document);
	$document = str_replace("[a5]", $jual['kontak'], $document);
	$document = str_replace("[a6]", $kontak['nama'], $document);
	$document = str_replace("[a7]", $kontak['alamat'], $document);
	$document = str_replace("[a8]", $kontak['telpon'], $document);
	$document = str_replace("[a9]", $jual['keterangan'], $document);
	$document = str_replace("[a10]", terbilang($jual['total']), $document);
	$document = str_replace("[a11]", format_rupiah($jual['subtotal']), $document);
	$document = str_replace("[a12]", format_rupiah($jual['ppn']), $document);
	$document = str_replace("[a13]", format_rupiah($jual['total']), $document);
	$document = str_replace("[a14]", $jual['pembuat'], $document);

	$query = "SELECT * FROM pos_transaksi_items where induk='$id' ";	
	$result = mysql_query($query) or die('Error');

	while ($row=mysql_fetch_array($result))  { 	
//	$barang=getrow("nama","barang","where kode='$row[kodebarang]'");
	$b1 .=$row['kodebarang']." \par ";
	$b2 .=$row['nama']." \par ";
	$b3 .=$row['satuan']." \par ";
	$b4 .=$row['banyak']." \par ";
	$b5 .=$row['harga']." \par ";
	$b6 .=$row['diskon']." \par ";
	$b7 .=$row['jual']." \par ";

//	$a7=$a7+$row[jumlah];
//	$i++;
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
	
	$fr = fopen('prints/penjualan.rtf', 'w') ;
	fwrite($fr, $document);
	fclose($fr);
 	echo "<script type='text/javascript'>window.open('prints/penjualan.rtf')</script>";
	
//$word = new COM("word.application") or die("Unable to instantiate Word");
//$word->visible = false;
//$word->Documents->Open(realpath("prints/penjualan.rtf"));
//$word->ActiveDocument->PrintOut(1);
//$word->Quit();
//$word = null;
 	home();
}


 ?>