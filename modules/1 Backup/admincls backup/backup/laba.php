<?php global  $title, $mod, $tbl, $fld, $akses ;
	$mod='admincls/laba';

	$tbl='pos_transaksi_items';
	$fld='id,induk,kode,tanggal,kodebarang,kategori,nama,satuan,banyak,harga,diskon,hargajual,beli,jual,lokasi,kontak' ;


function editmenu(){extract($GLOBALS);	
	echo usermenu('laba,export');
	}

function home(){extract($GLOBALS);	
 	laba();	
 	}
	
function laba(){extract($GLOBALS);	
	if(isset($_POST['lokasi'])){$lokasi=$_POST['lokasi'];}
	if(isset($_POST['kode'])){$kode=$_POST['kode'];}
	$periode= getrow("periode1,periode2","master_setting","");

	echo "<form name=myform action=?mod=$mod&menu=aksi method=post>
	<input type=hidden name=mysubmit />";
	echo "<table >
	<tr><td>".l('periode')."</td><td> $periode[0] s/d $periode[1]</td><tr>
	<tr><td>".l('namabarang')."</td><td>". droprow('kode', 'kode,nama', 'inventory_barang', $kode,'ORDER BY nama ASC') ."
	<button type=submit value='laba'  name='mybutton' class='formbutton' >".l('lihat')."</button>
	</td>
	</tr>
	</table>";


	$tbl='pos_transaksi_items';
	$fld='id,induk,kode,tanggal,kodebarang,kategori,nama,satuan,banyak,harga,diskon,hargajual,jual,lokasi,kontak,kegiatan' ;

 	$limit = 50;
	$rest=" where tanggal between '$periode[0]' and '$periode[1]' and kodebarang='$_POST[kode]'";	
 
	echo "<div class=scroll>";
	echo "<table class=sortable id='table-k'><thead><tr>";
	echo "<th><input type=checkbox  onClick=checkUncheckAll(this)  ></th>";

 	$kolom = explode(",", "kode,tanggal,kodebarang,kategori,nama,satuan,banyak,harga,diskon,hargajual,jual,hargabeli,laba");
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>".l($kolom[$i])."</th>"; }
	echo "</tr></thead><tbody>";
	$no=1;
	$stock=0;
	$query = "SELECT $fld FROM $tbl where tanggal between '$periode[0]' and '$periode[1]' and kodebarang='$_POST[kode]' and kegiatan='jual' ";	

	$_SESSION['myquery']=$query;

$beli= getrow("hargajual","pos_transaksi_items"," where kodebarang='$_POST[kode]' and kegiatan='beli'");

	$result = mysql_query($query) or die('Error');
	while ($r=mysql_fetch_array($result))  { 
		

	$barang = getrow("nama,satuan,kode","inventory_barang"," where kode='$r[kodebarang]'");
	$lokasi= getrow("id,nama","inventory_lokasi"," where id='$r[lokasi]'");
	echo "<tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	
	
	
//		$kolom = explode(",", "kode,tanggal,kodebarang,kategori,nama,satuan,banyak,harga,diskon,hargajual,jual,hargabeli,laba");

	
	echo "<td> $no</td> ";
	echo "<td> $r[kode] </td>";
	echo "<td> $r[tanggal] </td>";
	echo "<td> $r[kodebarang] </td>";
	echo "<td> $r[kategori] </td>";
	echo "<td> $r[nama] </td>";
	echo "<td> $r[satuan]  </td>";
	echo "<td> $r[banyak]  </td>";
	echo "<td> $r[harga]  </td>";
	echo "<td> $r[diskon] </td>";
	echo "<td> $r[hargajual] </td>";
	echo "<td> $r[jual] </td>";
	echo "<td> $beli[hargajual] </td>";
	$laba=$r['hargajual']-$beli['hargajual']*$r['banyak'];
	echo "<td> $laba</td>";
	echo "</tr>";
	$no++;
	}
	echo "</tbody></table>";
	echo "</div>";
	echo "</form>";	
	echo " </div>    ";
	}

 ?>