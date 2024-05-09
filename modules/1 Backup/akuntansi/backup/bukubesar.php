<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row,$p, $akses ;
	
	$mod="akuntansi/bukubesar";
	$tbl='akuntansi_jurnal';
	$fld='id,tanggal,nomor,nama,keterangan,debit,kredit' ;
	$p = getrow("periode1,periode2","master_setting","");

function editmenu(){extract($GLOBALS);	
echo usermenu('export');
	} 
function home(){extract($GLOBALS); 	
	buku_besar(); 
	}

function buku_besar(){ extract($GLOBALS);
	$limit = 50;
	if (isset($_POST['akun']) ){  
	$akun=$_POST['akun'];
	$bb = getrow("nomor,nama","akuntansi_akun","where nomor=$akun");
	$rest ="where nomor=$akun  AND tanggal BETWEEN '$p[0];' AND '$p[1];'";} 
	else { $rest =" where nomor='111'  and tanggal BETWEEN '$p[0];' AND '$p[1];'";}
	 
 	if(isset($_POST['menu'])) {$rest="";} 
	if(isset($_POST['sortir'])) {$sortir="order by ". $_POST['sortir'];} else {$sortir="";}
	
	$datasec=$_POST['test'];
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld;}
	
	if(isset($_GET['page'])){ $noPage = $_GET['page'];} else $noPage = 1;
	$offset = ($noPage - 1) * $limit;
	
	$query = "SELECT $data FROM $tbl $rest $sortir LIMIT $offset, $limit  ";	
	$_SESSION['myquery']=$query;

	$result = mysql_query($query) or die('Error');
	echo "<div class=scroll>";
	echo "<form name=myform action=?mod=$mod&menu=aksi method=post ><input type=hidden name=mysubmit >";
	echo "<input type=hidden name=id value=$id >";
	echo "<input type=hidden name=tbl value=$tbl >";
	echo "<input type=hidden name=mod value=$mod >";
	echo "<input type=hidden name=ids >";

 	$result1=mysql_query("SELECT nomor, nama FROM akuntansi_akun ");  
	echo "<select name='akun' onChange=submitform('buku_besar'); return false;>";
	while ($r1=mysql_fetch_array($result1))  { 
	if($akun==$r1['nomor']){$t = 'selected'; }else{$t = '';} 
	echo"<option value=$r1[nomor] $t >$r1[nama] </option>";}	
	echo"</select>";	
//	echo"<button type=submit value='buku_besar' name='mybutton' class='formbutton' >Tampil</button>";
 	echo "<h2>".l('bukubesar')." $bb[nama] </h2>";
	echo  "Periode :". $p[0] . " s/d ". $p[1];

 	echo "<table class=sortable id='table-k' ><thead><tr>";
 	echo "<th>No</th>";
	$no=1;
	$kolom = explode(",", $data);
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th>$kolom[$i]</th>"; }	
	echo "<th>Saldo</th>";
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  { 	
	
	$debit      = $debit + $row['debit'];  
	$kredit     = $kredit + $row['kredit'];  
	$saldo		= $debit - $kredit;

	echo "<tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' >";
	echo "<td>$no</td>";
	for ($i = 0; $i < count($kolom); ++$i) { echo "<td class=difcursor >$row[$i]</td> "; }
	echo "<td class=difcursor >".format_rupiah($saldo)."</td> ";
	echo "</tr>";
	$no++;
	}
	echo "<tr>
	<td colspan=6> Total</td>	
	<td >".format_rupiah($debit)."</td>
	<td >".format_rupiah($kredit)." </td>
	<td >".format_rupiah($saldo)."</td>
	</tr>";
	echo "</tbody></table>";
	echo "</form>";
	echo "</div >";
	}
 ?>
