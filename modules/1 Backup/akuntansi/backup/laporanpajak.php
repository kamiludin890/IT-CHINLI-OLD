<?php global  $title, $mod, $tbl, $fld, $akses;
	$mod='akuntansi/laporanpajak';
	$tbl='pos_transaksi';
	$fld='id,kode,tanggal,pembuat,kegiatan,lokasi,keterangan,status,kontak' ;

function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('pembelian,penjualan,export');}
	}

function home(){extract($GLOBALS);	
	penjualan();
	}
function penjualan(){extract($GLOBALS);	
	if(isset($_POST['lokasi'])){$lokasi=$_POST['lokasi'];}
	if(isset($_POST['kontak'])){$kontak=$_POST['kontak'];}
	$periode= getrow("periode1,periode2","master_setting","");
	echo "<form name=myform action=?mod=$mod&menu=aksi method=post>
	<input type=hidden name=mysubmit />";
	echo "<table >
	<tr><td>".l('periode')."</td><td> $periode[0] s/d $periode[1]</td><tr>
	<tr><td>".l('lokasi')."</td><td>". droprow('lokasi', 'id,nama', 'inventory_lokasi',$lokasi,'') ." </td><tr>
	<tr><td>".l('kontak')."</td><td>". droprow("kontak","id,nama","pos_kontak",$kontak," where kategori='Customer'") ."
	<button type=submit value='penjualan' name='mybutton' class='formbutton' >".l('penjualan')."</button></td>
	</tr>
	</table>";

	$tbl='pos_transaksi';
	$fld='id,kode,tanggal,pembuat,kegiatan,lokasi,keterangan,status,kontak,total' ;
	$limit = 50;
	$rest=" where tanggal between '$periode[0]' and '$periode[1]' and kegiatan='jual'";	

	echo "<div class=scroll>";
	echo "<table class=sortable id='table-k'><thead><tr>";
	echo "<th><input type=checkbox  onClick=checkUncheckAll(this)  ></th>";

	$kolom = explode(",", "id,kode,tanggal,pembuat,kegiatan,lokasi,keterangan,status,kontak,jumlah");
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>".l($kolom[$i])."</th>"; }
	echo "</tr></thead><tbody>";
	$no=1;
	$total=0;

	$query = "SELECT * FROM pos_transaksi 
	where tanggal between '$periode[0]' and '$periode[1]' 
	and kegiatan='jual' 
	and lokasi='$lokasi' and kontak='$kontak'
	";	

	$_SESSION['myquery']=$query;

	$result = mysql_query($query) or die('Error');

	while ($r=mysql_fetch_array($result))  { 
	$kontak= getrow("nama","pos_kontak"," where id='$r[kontak]'");
	$lokasi= getrow("id,nama","inventory_lokasi"," where id='$r[lokasi]'");
	echo "<tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td> $no</td> ";
	echo "<td> $r[id] </td>";
	echo "<td> $r[kode] </td>";
	echo "<td> $r[tanggal] </td>";
	echo "<td> $r[pembuat] </td>";
	echo "<td> $r[kegiatan] </td>";
	echo "<td> $lokasi[nama] </td>";
	echo "<td> $r[keterangan] </td>";
	echo "<td> $r[status] </td>";
	echo "<td> $kontak[nama] </td>";
	echo "<td> $r[total] </td>";
	echo "</tr>";
	$total=$total+$r['total'];
	$no++;
	}
	echo "<tr><td colspan=10 align='right'> Total </td><td> $total</td></tr>";
	
	echo "</tbody></table>";
	echo "</div>";
	echo "</form>";	
	echo " </div>    ";

}

function pembelian(){extract($GLOBALS);	
	if(isset($_POST['lokasi'])){$lokasi=$_POST['lokasi'];}
	if(isset($_POST['kontak'])){$kontak=$_POST['kontak'];}
	$periode= getrow("periode1,periode2","master_setting","");

	echo "<form name=myform action=?mod=$mod&menu=aksi method=post>
	<input type=hidden name=mysubmit />";
	echo "<table >
	<tr><td>".l('periode')."</td><td> $periode[0] s/d $periode[1]</td><tr>
	<tr><td>".l('lokasi')."</td><td>". droprow('lokasi', 'id,nama', 'inventory_lokasi',$lokasi,'') ."</td><tr>
	<tr><td>".l('kontak')."</td><td>". droprow("kontak","id,nama","pos_kontak",$kontak," where kategori='Supplier'") ."
	<button type=submit value='pembelian' name='mybutton' class='formbutton' >".l('pembelian')."</button></td></td>
	</tr>
	</table>";

	$tbl='pos_transaksi';
	$fld='id,kode,tanggal,pembuat,kegiatan,lokasi,keterangan,status,kontak' ;
	$limit = 50;
	$rest=" where tanggal between '$periode[0]' and '$periode[1]' and kegiatan='beli'";	
	

	echo "<div class=scroll>";
	echo "<table class=sortable id='table-k'><thead><tr>";
	echo "<th><input type=checkbox  onClick=checkUncheckAll(this)  ></th>";

	$kolom = explode(",", "id,kode,tanggal,pembuat,kegiatan,lokasi,keterangan,status,kontak,jumlah");
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>".l($kolom[$i])."</th>"; }
	echo "</tr></thead><tbody>";
	$no=1;
	$total=0;

	$query = "SELECT * FROM pos_transaksi 
	where tanggal between '$periode[0]' and '$periode[1]' 
	and kegiatan='beli' 
	and lokasi='$lokasi' and kontak='$kontak'
	";	
	$_SESSION['myquery']=$query;

	$result = mysql_query($query) or die('Error');

	while ($r=mysql_fetch_array($result))  { 
	$kontak= getrow("nama","pos_kontak"," where id='$r[kontak]'");
	$lokasi= getrow("id,nama","inventory_lokasi"," where id='$r[lokasi]'");
	echo "<tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td> $no</td> ";
	echo "<td> $r[id] </td>";
	echo "<td> $r[kode] </td>";
	echo "<td> $r[tanggal] </td>";
	echo "<td> $r[pembuat] </td>";
	echo "<td> $r[kegiatan] </td>";
	echo "<td> $lokasi[nama] </td>";
	echo "<td> $r[keterangan] </td>";
	echo "<td> $r[status] </td>";
	echo "<td> $kontak[nama] </td>";
	echo "<td> $r[total] </td>";
	echo "</tr>";
	$total=$total+$r['total'];
	$no++;
	}
	echo "<tr><td colspan=10 align='right'> Total </td><td> $total</td></tr>";
	echo "</tbody></table>";
	echo "</div>";
	echo "</form>";	
	echo "</div>";
}
?>