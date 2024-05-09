<?php global  $d,$akses,$p;
$d= array(
'mod'=>'akuntansiv3/laporan',
'tbl'=>'akuntansiv3_jurnal',
'hd'=>'0',
'lmt'=>25
);

$p=getrow("awaltglakuntansi,akhirtglakuntansi","master_user","");

function editmenu(){extract($GLOBALS);
	echo usermenu('export');
	}

	echo "</br>";
	$awaltglakuntansi = $_POST['tanggal1'];
	$akhirtglakuntansi = $_POST['tanggal2'];
	$username10=$_SESSION['username'];

	$sql1="SELECT * FROM master_user WHERE email='$username10'";
	$result1= mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);

		echo "<form action='?menu=home&mod=akuntansiv3/laporan' method='POST'>
					<label>Tanggal</label>
					<input type='date' name='tanggal1'>
					s/d
					<input type='date' name='tanggal2'>
					<input type='submit' value='saring'>
				  </form>";

		echo "<h3>Periode $rows1[awaltglakuntansi] s/d $rows1[akhirtglakuntansi]</h3>";

if ($awaltglakuntansi==0) {
}else {
	$upload = "UPDATE master_user SET awaltglakuntansi='$awaltglakuntansi',akhirtglakuntansi='$akhirtglakuntansi' WHERE email='$username10' ";
	$hasil = mysql_query($upload);
	echo "<meta http-equiv='refresh' content='0.0001'/>";
}

function home(){extract($GLOBALS);



neraca();
	}

function ayoo(){extract($GLOBALS);
	$selectid=$_POST['menu'];
	$selectid();
	}

function dropmenu2(){extract($GLOBALS);
	$selectid=$_POST['menu'];
	echo "<form name=myform action='?mod=$d[mod]&menu=aksi' method='post' id='contactform'><input type=hidden name=mysubmit />";
	echo "<div style=''>";
	echo "<select name='menu' id='dropmenu' onChange=submitform('ayoo'); return false; >";

	$kolom = explode(",", "Neraca,Laba_Rugi,Ekuitas");
	for ($i = 0; $i < count($kolom); $i++) 	{
	if($selectid==$kolom[$i]){$s = 'selected'; }else{$s = '';}
	echo "<option value='$kolom[$i]' $s />".l($kolom[$i])."</option>";	}
	echo "</select></div ></form>";
 	}

function laba_rugi(){extract($GLOBALS); 	global $tl;
	$rest=" WHERE tanggal BETWEEN '$p[0];' AND '$p[1];' ";
 	$rest .=" AND akuntansiv3_akun.nomor=akuntansiv3_jurnal.nomor ";
 	$rest .=" AND akuntansiv3_akun.kelompok='pendapatan' ";
 	$rest .=" GROUP BY akuntansiv3_akun.nomor ORDER BY akuntansiv3_akun.nomor ASC";
	dropmenu2();
 	$query = "SELECT * ,sum(akuntansiv3_jurnal.debit) AS debit, sum(akuntansiv3_jurnal.kredit) as kredit FROM akuntansiv3_jurnal,akuntansiv3_akun $rest ";
	$_SESSION['myquery']=$query;
	$result = mysql_query($query) or die('Error');
	echo "<h2>".l('laporan_rugi_laba')."</h2>";
//	echo l('periode'). $p[0] . " s/d ". $p[1];
 	echo "<table class=sortable id='table-k' ><thead><tr>";
	echo "<tr><th>No.</th><th>".l('nama')."</th><th>".l('debit')."</th><th>".l('kredit')."</th></tr>";
	echo "<tr><td colspan=2>".l('pendapatan')."</td><td></td><td></td></tr>";
	$no=1;
	while ($row=mysql_fetch_array($result)) {
	$saldo=$row['debit'] - $row['kredit'];
	if ($saldo>=0) {$debit=$saldo; $kredit=0; }	else {$debit=0; $kredit=-$saldo;};
	$tkredit = $tkredit + $kredit;
	$jp= $tkredit;
	$kredit		= format_rupiah($kredit);
	$skredit	= format_rupiah($tkredit);
	echo "<tr><td>$no<input type=hidden name=id[$no] value=$row[0]></td><td>$row[nama]</td><td></td><td>$kredit</td></tr>";
	$no++;
	}
	echo "<tr><td colspan=2>".l('jumlah_pendapatan')."</td><td></td><td><b>$skredit</b></td></tr>";
	echo "<tr><td colspan=2></td><td></td><td></td></tr>";

	$query2 = "SELECT * ,sum(akuntansiv3_jurnal.debit) AS debit, sum(akuntansiv3_jurnal.kredit) as kredit FROM akuntansiv3_jurnal,akuntansiv3_akun
	WHERE tanggal BETWEEN '$p[0];' AND '$p[1];' and akuntansiv3_akun.nomor=akuntansiv3_jurnal.nomor AND akuntansiv3_akun.kelompok='beban' GROUP BY akuntansiv3_akun.nomor ORDER BY akuntansiv3_akun.nomor ASC";
	$result2 = mysql_query($query2) or die('Error');

	echo "<tr><td colspan=2>".l('beban_beban')."</td><td></td><td></td></tr>";
	$no=1;
	while ($row=mysql_fetch_array($result2))  {
	$saldo		= $row['debit'] - $row['kredit'];
	if ($saldo>=0) {$debit=$saldo; $kredit=0;}else {$debit=0; $kredit=-$saldo;};
	$tdebit       = $tdebit + $debit;
	$jb= $tdebit;
	$debit		= format_rupiah($debit);
	$sdebit		= format_rupiah($tdebit);
	echo "<tr><td>$no<input type=hidden name=id[$no] value=$row[id]></td><td> $row[nama] </td><td>$debit</td><td></td></tr>";
	$no++;
	}
	$tl = $jp-$jb;

	echo "<tr><td colspan=2>".l('jumlah_beban')."</td><td ><b>$sdebit </b></td><td ></td></tr>";
	echo "<tr><td colspan=2>".l('laba_bersih')."</td><td></td><td><b>".format_rupiah($tl)."</b></td></tr>";
	echo "</table>";
	echo " </div>";
	}

function ekuitas(){extract($GLOBALS); global $modal;
 	dropmenu2();
	$query = "SELECT * ,sum(akuntansiv3_jurnal.debit) AS debit, sum(akuntansiv3_jurnal.kredit) as kredit FROM akuntansiv3_jurnal,akuntansiv3_akun
	WHERE tanggal BETWEEN '$p[0];' AND '$p[1];' and akuntansiv3_akun.nomor=akuntansiv3_jurnal.nomor AND akuntansiv3_akun.kelompok='ekuitas' GROUP BY akuntansiv3_akun.nomor ORDER BY akuntansiv3_akun.nomor ASC";
	$_SESSION['myquery']=$query;
	$result = mysql_query($query) or die('Error');

	echo "<h2>".l('laporan_ekuitas')."</h2>";
// 	echo l('periode').$p[0] . " s/d ". $p[1];
 	echo "<table class=sortable id='table-k' ><thead><tr>";
	echo "<tr><th>No.</th><th>".l('nama')."</th><th>".l('debit')."</th><th>".l('kredit')."</th></tr>";
	$no=1;
	while ($row=mysql_fetch_array($result))  {
	$saldo		= $row['debit'] - $row['kredit'];
	if ($saldo>=0) {$debit=$saldo; $kredit=0;} else {$debit=0; $kredit=-$saldo;};
	$tdebit       = $tdebit + $debit;
	$tkredit      = $tkredit + $kredit;
	$jp= $tkredit;

	$debit		= format_rupiah($debit);
	$sdebit		= format_rupiah($tdebit);
	$kredit		= format_rupiah($kredit);
	$skredit	= format_rupiah($tkredit);

	echo "<tr><td>$no  <input type=hidden name=id[$no] value=$row[0]></td><td> $row[nama] </td><td> $debit </td><td> $kredit  </td></tr>";
	$no++;
	}
	$jdebit		= $tdebit;
	$jkredit	= $tkredit+$tl;
	$modal		= $jkredit-$jdebit;
	$rp_jdebit	= format_rupiah($jdebit);
	$rp_jkredit	= format_rupiah($jkredit);
	$rp_tl		= format_rupiah($tl);
	$rp_modal	= format_rupiah($modal);

	echo "<tr><td colspan=2>".l('total')."</td>	<td ><b>$sdebit </b></td><td ><b>$skredit </b></td></tr>";
	echo "<tr><td colspan=2>".l('laba_bersih')."</td><td></td><td><b>$rp_tl</b></td></tr>";
	echo "<tr><td colspan=2>".l('jumlah')."</td><td >$rp_jdebit</td>  <td > $rp_jkredit</td></tr>";
	echo "<tr><td colspan=2>".l('modal')."</td><td></td><td><b>$rp_modal</b></td></tr>";
	echo "</table>";
	echo " </div>";
	}

function neraca(){extract($GLOBALS); 	global $tl;
	dropmenu2();

	$query = "SELECT * ,sum(akuntansiv3_jurnal.debit) AS debit, sum(akuntansiv3_jurnal.kredit) as kredit FROM akuntansiv3_jurnal,akuntansiv3_akun
	WHERE tanggal BETWEEN '$p[0];' AND '$p[1];' and akuntansiv3_akun.nomor=akuntansiv3_jurnal.nomor AND akuntansiv3_akun.kelompok='aktiva' GROUP BY akuntansiv3_akun.nomor ORDER BY akuntansiv3_akun.nomor ASC";
	$_SESSION['myquery']=$query;

	$result = mysql_query($query) or die('Error');

 	echo "<h2>".l('laporan_neraca')."</h2>";
//	echo l('periode'). $p[0] . " s/d ". $p[1];
 	echo "<table class=sortable id='table-k' ><thead><tr>";
	echo "<tr><th>No.</th><th>".l('nama')."</th><th>".l('debit')."</th><th>".l('kredit')."</th></tr>";
	echo "<tr><td colspan=2>".l('aktiva')."</td><td></td><td></td></tr>";
	$no=1;
	while ($row=mysql_fetch_array($result))  {
	$saldo		= $row['debit'] - $row['kredit'];
	if ($saldo>=0) {$debit=$saldo; $kredit=0;} else {$debit=0; $kredit=-$saldo;};
	$tdebit       = $tdebit + $debit;
	$tkredit       = $tkredit + $kredit;
	$jb= $tdebit;
	$jp= $tkredit;
	$debit		= format_rupiah($debit);
	$sdebit		= format_rupiah($tdebit);
	$kredit		= format_rupiah($kredit);
	$skredit	= format_rupiah($tkredit);

	echo "<tr><td>$no  <input type=hidden name=id[$no] value=$row[0]></td><td> $row[nama] </td><td> $debit  </td><td> $kredit </td></tr>";
	$no++;
	}
	echo "<tr><td colspan=2>".l('total')."</td>	<td > $sdebit </td><td ><b>$skredit </b></td></tr>";
	echo "<tr><td colspan=2>".l('jumlah_aktiva')."</td>	<td > $sdebit </td><td ><b>$skredit </b></td></tr>";
	echo "<tr><td colspan=2> </td><td></td><td></td></tr>";

	$query2 = "SELECT * ,sum(akuntansiv3_jurnal.debit) AS debit, sum(akuntansiv3_jurnal.kredit) as kredit FROM akuntansiv3_jurnal,akuntansiv3_akun
	WHERE tanggal BETWEEN '$p[0];' AND '$p[1];' and akuntansiv3_akun.nomor=akuntansiv3_jurnal.nomor AND akuntansiv3_akun.kelompok='passiva' GROUP BY akuntansiv3_akun.nomor ORDER BY akuntansiv3_akun.nomor ASC";
	$result2 = mysql_query($query2) or die('Error');
	echo "<tr><td colspan=2>".l('passiva')."</td><td></td><td></td></tr>";
	$no=1;
	while ($row=mysql_fetch_array($result2))  {
	$saldo		= $row['debit'] - $row['kredit'];
	if ($saldo>=0) {$debit=$saldo; $kredit=0;} else {$debit=0; $kredit=-$saldo;};

	$tdebit       = $tdebit + $debit;
	$tkredit      = $tkredit + $kredit;
	$jb= $tdebit;
	$jp= $tkredit;
	$debit		= format_rupiah($debit);
	$sdebit		= format_rupiah($tdebit);
	$kredit		= format_rupiah($kredit);
	$skredit	= format_rupiah($tkredit);

	echo "<tr><td>$no<input type=hidden name=id[$no] value=$row[id]></td><td> $row[nama] </td><td> $debit  </td><td> $kredit  </td></tr>";
	$no++;
	}
	$tl = $jp-$jb;
	$rp_tl	= format_rupiah($tl);
	$rp_modal	= format_rupiah($modal);
	$passsiva= $tkredit+$modal;
	$rp_passsiva	= format_rupiah($passsiva);

	echo "<tr><td colspan=2>".l('modal')."</td><td></td><td><b>$rp_modal</b></td></tr>";
	echo "<tr><td colspan=2>".l('total')."</td><td><b>$sdebit </b></td> <td >$rp_passsiva </td></tr>";
	echo "<tr><td colspan=2>".l('jumlah_passiva')."</td><td ><b>$sdebit </b></td> <td >$skredit </td></tr>";
	echo "</table>";
	echo " </div>";
	}
 ?>
