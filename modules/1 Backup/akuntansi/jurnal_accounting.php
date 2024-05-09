<?php global  $d,$akses;
$d= array(
'mod'=>'akuntansi/jurnal',
'tbl'=>'akuntansi_jurnal',
'fld'=>'id,ref,tanggal,nomor,nama,keterangan,debit,kredit,induk,kode_dokumen',
'hd'=>'0',
'lmt'=>50
);

$p = getrow("periode1,periode2","master_setting","");




function editmenu(){extract($GLOBALS);
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');}
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('add,delete,filter,export');}
	}

function home(){extract($GLOBALS);
	$awaltglakuntansi = $_POST['tanggal1'];
	$akhirtglakuntansi = $_POST['tanggal2'];
	$username10=$_SESSION['username'];

	$sql1="SELECT * FROM master_user WHERE email='$username10'";
	$result1= mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);

		echo "<form action='?menu=home&mod=akuntansi/jurnal' method='POST'>
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


	$d[lmt] = 25;
 	$p = getrow("periode1,periode2","master_setting","");
 	if ($rest==''){$rest=" where tanggal BETWEEN '$rows1[awaltglakuntansi]' AND '$rows1[akhirtglakuntansi]'";} else { $rest.=" AND tanggal BETWEEN '$rows1[awaltglakuntansi]' AND '$rows1[akhirtglakuntansi]'";}
	table($d[tbl],$d[fld],$d[lmt],$rest,$d[mod],$d[hd]);
	$_SESSION['myquery']=$query;

}

function editform(){ extract($GLOBALS);
	$id=$_POST['id'];

	if ($id>0) {
	if ($_POST['mysubmit']=='add'){$btn='insert';
	} else {{$btn='save';}}
$_SESSION['sbsources']= array( 'mod' => $d['mod'], 'id' => $id );
	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $d[fld] from $d[tbl]");
	$r=getrow($d[fld],$d[tbl],"where id='$id'");
	//echo  " <form name=myform action='?mod=$d[mod]&menu=aksi' method='post' id='contactform'>
	//<input type=hidden name=ed[id] value=$id /><input type=hidden name=mysubmit />
	//<ol>
	//<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]'/></li>
	//<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]'/></li>
	//<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]'/></li>
	//<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]'/></li>
	//<li><label for='5'>".l(mysql_field_name($row, 5))."</label><textarea name='5' rows=8/>$r[5]</textarea></li>
	//<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]'/></li>
	//<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]'/></li>
	//<li><label for='8'>".l(mysql_field_name($row, 8))."</label><input class='text' name='8' value='$r[8]'/></li>
	//<li><label for='9'>".l(mysql_field_name($row, 9))."</label><input class='text' name='9' value='$r[9]'/></li>
	//<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' $s >".l($btn)."</button></li>
	//</ol>
	//</form>	";

	echo "
	<form name=myform action='?mod=$d[mod]&menu=aksi' method='post' id='contactform'>
		<table>
		<input type=hidden name=ed[id] value=$id /><input type=hidden name=mysubmit />
		<tr>
		 <td>Ref</td>
		 <td>:</td>
		 <td><input type='text' name='1' value='$r[1]'></td>
		</tr>

		<tr>
		 <td>Tanggal</td>
		 <td>:</td>
		 <td><input type='date' name='2' value='$r[2]'></td>
		</tr>";


		$sql1="SELECT * FROM akuntansi_akun ORDER BY nomor";
		$result1= mysql_query($sql1);
		echo "
		<tr>
		<td>Nomor</td>
		<td>:</td>
		<td><select name='3' value='$r[3]'>";
		echo "
		<option value='$r[3]'>".$r[3]."</option>";
		while ($rows1=mysql_fetch_array($result1)){
		echo "
		<option value='$rows1[nomor]'>".$rows1['nomor']." - ".$rows1['nama']."</option>
		";}
		echo "
		</select></td>
		</tr>";

		$sql2="SELECT * FROM akuntansi_akun ORDER BY nomor";
		$result2= mysql_query($sql2);
		echo "
		<tr>
		<td>Nama</td>
		<td>:</td>
		<td><select name='4' value='$r[4]'>";
		echo "
		<option value='$r[4]'>".$r[4]."</option>";
		while ($rows2=mysql_fetch_array($result2)){
		echo "
		<option value='$rows2[nama]'>".$rows2['nomor']." - ".$rows2['nama']."</option>
		";}
		echo "
		</select></td>
		</tr>";

		echo "
		<tr>
		 <td>Keterangan</td>
		 <td>:</td>
		 <td><input type='text' name='5' value='$r[5]'></td>
		</tr>

		<tr>
		 <td>Debit</td>
		 <td>:</td>
		 <td><input type='text' name='6' value='$r[6]'></td>
		</tr>

		<tr>
		 <td>Kredit</td>
		 <td>:</td>
		 <td><input type='text' name='7' value='$r[7]'></td>
		</tr>";

		$sql3="SELECT * FROM akuntansi_akun ORDER BY nomor";
		$result3= mysql_query($sql3);
		echo "
		<tr>
		<td>Induk</td>
		<td>:</td>
		<td><select name='8' value='$r[8]'>";
		echo "
		<option value='$r[8]'>".$r[8]."</option>";
		while ($rows3=mysql_fetch_array($result3)){
		echo "
		<option value='$rows3[induk]'>".$rows3['nomor']." - ".$rows3['nama']."</option>
		";}
		echo "
		</select></td>
		</tr>";

		echo "
		<tr>
		<td>Kode Dokumen</td>
		<td>:</td>
		<td><select name='9' value='$r[9]'>
		<option value='$r[9]''>".$r[9]."</option>
		<option value='27k'>27k</option>
		<option value='25'>25</option>
		<option value='261'>261</option>
		<option value='262'>262</option>
		<option value='41'>41</option>
		<option value='40'>40</option>
		<option value='23'>23</option>
		<option value='27m'>27m</option>
		</select></td>
		</tr>

		 <tr>
			<td></td>
			<td></td>
			<td class='buttons'><button type='submit' value='$btn' name='mybutton' class='formbutton' $s>".l($btn)."</button></td>
		 </tr>
		</table>
	 </form>";



}elseif ($id==0) {

	if ($_POST['mysubmit']=='add'){$btn='insert';
	} else {{$btn='save';}}
$_SESSION['sbsources']= array( 'mod' => $d['mod'], 'id' => $id );
	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $d[fld] from $d[tbl]");
	$r=getrow($d[fld],$d[tbl],"where id='$id'");


	echo "
	<form name=myform action='?mod=$d[mod]&menu=aksi' method='post' id='contactform'>
		<table>
		<input type=hidden name=ed[id] value=$id /><input type=hidden name=mysubmit />
		<tr>
		 <td>Ref</td>
		 <td>:</td>
		 <td><input type='text' name='1'></td>
		</tr>

		<tr>
		 <td>Tanggal</td>
		 <td>:</td>
		 <td><input type='date' name='2'></td>
		</tr>";


		$sql1="SELECT * FROM akuntansi_akun ORDER BY nomor";
		$result1= mysql_query($sql1);
		echo "
		<tr>
		<td>Nomor</td>
		<td>:</td>
		<td><select name='3'>";
		while ($rows1=mysql_fetch_array($result1)){
		echo "
		<option value='$rows1[nomor]'>".$rows1['nomor']." - ".$rows1['nama']."</option>
		";}
		echo "
		</select></td>
		</tr>";

		$sql2="SELECT * FROM akuntansi_akun ORDER BY nomor";
		$result2= mysql_query($sql2);
		echo "
		<tr>
		<td>Nama</td>
		<td>:</td>
		<td><select name='4'>";
		while ($rows2=mysql_fetch_array($result2)){
		echo "
		<option value='$rows2[nama]'>".$rows2['nomor']." - ".$rows2['nama']."</option>
		";}
		echo "
		</select></td>
		</tr>";

		echo "
		<tr>
		 <td>Keterangan</td>
		 <td>:</td>
		 <td><input type='text' name='5'></td>
		</tr>

		<tr>
		 <td>Debit</td>
		 <td>:</td>
		 <td><input type='text' name='6'></td>
		</tr>

		<tr>
		 <td>Kredit</td>
		 <td>:</td>
		 <td><input type='text' name='7'></td>
		</tr>";

		$sql3="SELECT * FROM akuntansi_akun ORDER BY nomor";
		$result3= mysql_query($sql3);
		echo "
		<tr>
		<td>Induk</td>
		<td>:</td>
		<td><select name='8'>";
		while ($rows3=mysql_fetch_array($result3)){
		echo "
		<option value='$rows3[induk]'>".$rows3['nomor']." - ".$rows3['nama']."</option>
		";}
		echo "
		</select></td>
		</tr>";

		echo "
		<tr>
		<td>Kode Dokumen</td>
		<td>:</td>
		<td><select name='9'>
		<option value=''></option>
		<option value='27k'>27k</option>
		<option value='25'>25</option>
		<option value='261'>261</option>
		<option value='262'>262</option>
		<option value='41'>41</option>
		<option value='40'>40</option>
		<option value='23'>23</option>
		<option value='27m'>27m</option>
		</select></td>
		</tr>

		 <tr>
			<td></td>
			<td></td>
			<td class='buttons'><button type='submit' value='$btn' name='mybutton' class='formbutton' $s>".l($btn)."</button></td>
		 </tr>
		</table>
	 </form>";


}
}

?>
