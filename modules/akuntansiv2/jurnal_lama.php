<?php global  $title, $mod, $tbl, $fld ,$p, $akses;
	$mod='akuntansiv2/jurnal';
	$tbl='akuntansiv2_jurnal';
	$fld='id,ref,tanggal,nomor,induk,nama,keterangan,debit,kredit,selisih,kode_dokumen,no_dokumen,tanggal_dokumen,nomor_aju,tanggal_aju,nomor_invoice,tanggal_invoice,no_po,nomor_surat_jalan,nomor_faktur,tanggal_faktur,ex_bc,tanggal_ex_bc,pembeda,ppnacc,dapatdikreditkan,tidakdapatdikreditkan' ;
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

		echo "<form action='?menu=home&mod=akuntansiv2/jurnal' method='POST'>
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



	$limit = 25;
 	$p = getrow("periode1,periode2","master_setting","");
if ($rest==''){$rest=" where tanggal BETWEEN '$rows1[awaltglakuntansi]' AND '$rows1[akhirtglakuntansi]'";} else { $rest.=" AND tanggal BETWEEN '$rows1[awaltglakuntansi]' AND '$rows1[akhirtglakuntansi]'";}
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']=$query;

}

function editform($id,$btn){ extract($GLOBALS);

	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");

//	echo  " <form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
//	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />
//	<ol>
//	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]'/></li>
//	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]'/></li>
//	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]'/></li>
//	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]'/></li>
//	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><textarea name='5' rows=8/>$r[5]</textarea></li>
//	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]'/></li>
//	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]'/></li>
//	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
//	</ol>
//	</form>	";

	echo "
	<form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<form name=myform action='?menu=home&mod=akuntansiv2/jurnal' method='post' id='contactform'>
		<table>
		<input type=hidden name=id value=$id />
		<input type=hidden name=mysubmit />
		<input type=hidden name='updateselisih' value='updateselisih' />
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


		$sql1="SELECT * FROM akuntansiv2_akun ORDER BY nomor";
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

		echo "
		<tr>
		 <td>Induk</td>
		 <td>:</td>
		 <td><input type='text' name='4' value='$r[4]' disabled></td>
		</tr>

		<tr>
		 <td>Nama</td>
		 <td>:</td>
		 <td><input type='text' name='5' value='$r[5]' disabled></td>
		</tr>



		<tr>
		 <td>Keterangan</td>
		 <td>:</td>
		 <td><input type='text' name='6' value='$r[6]'></td>
		</tr>

		<tr>
		 <td>Debit</td>
		 <td>:</td>
		 <td><input type='text' name='7' value='$r[7]'></td>
		</tr>

		<tr>
		 <td>Kredit</td>
		 <td>:</td>
		 <td><input type='text' name='8' value='$r[8]'></td>
		</tr>";

		echo "
		<tr>
		 <td>Selisih</td>
		 <td>:</td>
		 <td><input type='text' name='9' value='$r[9]'></td>
		</tr>

		<tr>
		<td>Kode Dokumen</td>
		<td>:</td>
		<td><select name='10' value='$r[10]'>
		<option value='$r[10]''>".$r[10]."</option>
		<option value='BC 2.3 IMPORT'>BC 2.3 IMPORT</option>
		<option value='BC 2.5 PIB'>BC 2.5 PIB</option>
		<option value='BC 2.7 KELUAR'>BC 2.7 KELUAR</option>
		<option value='BC 2.7 MASUK'>BC 2.7 MASUK</option>
		<option value='BC 3.0 PEB'>BC 3.0 PEB</option>
		<option value='BC 4.0 LOKAL'>BC 4.0 LOKAL</option>
		<option value='BC 4.1'>BC 4.1</option>
		<option value='BC 4.1 PENJUALAN'>BC 4.1 PENJUALAN</option>
		<option value='BC 2.6.2 HASIL SUBKON'>BC 2.6.2 HASIL SUBKON</option>
		<option value='BC 2.6.1 SUBKON'>BC 2.6.1 SUBKON</option>
		</select></td>
		</tr>

		<tr>
			 <td>Nomor Daftar</td>
		 <td>:</td>
		 <td><input type='text' name='11' value='$r[11]'></td>
		</tr>

		<tr>
			 <td>Tanggal Daftar</td>
		 <td>:</td>
		 <td><input type='text' name='12' value='$r[12]'></td>
		</tr>

		<tr>
			 <td>Nomor Aju</td>
		 <td>:</td>
		 <td><input type='text' name='13' value='$r[13]'></td>
		</tr>

		<tr>
			 <td>Tanggal Aju</td>
		 <td>:</td>
		 <td><input type='text' name='14' value='$r[14]'></td>
		</tr>

		<tr>
			 <td>Nomor Invoice</td>
		 <td>:</td>
		 <td><input type='text' name='15' value='$r[15]'></td>
		</tr>

		<tr>
			 <td>Tanggal Invoice</td>
		 <td>:</td>
		 <td><input type='date' name='16' value='$r[16]'></td>
		</tr>

		<tr>
			 <td>Nomor PO</td>
		 <td>:</td>
		 <td><input type='text' name='17' value='$r[17]'></td>
		</tr>

		<tr>
			 <td>Nomor Surat Jalan</td>
		 <td>:</td>
		 <td><input type='text' name='18' value='$r[18]'></td>
		</tr>

		<tr>
			 <td>Nomor Faktur</td>
		 <td>:</td>
		 <td><input type='text' name='19' value='$r[19]'></td>
		</tr>

		<tr>
			 <td>Tanggal Faktur</td>
		 <td>:</td>
		 <td><input type='date' name='20' value='$r[20]'></td>
		</tr>

		<tr>
			 <td>EX BC</td>
		 <td>:</td>
		 <td><input type='text' name='21' value='$r[21]'></td>
		</tr>

		<tr>
			 <td>Tanggal EX BC</td>
		 <td>:</td>
		 <td><input type='date' name='22' value='$r[22]'></td>
		</tr>

		<tr>
		<td>Dapat Di Kreditkan</td>
		<td>:</td>
		<td><select name='23' value='$r[23]'>
		<option value='$r[23]''>".$r[23]."</option>
		<option value='YA'>YA</option>
		<option value='TIDAK'>TIDAK</option>
		</select></td>
		</tr>

		 <tr>
			<td></td>
			<td></td>
			<td class='buttons'><button type='submit' value='$btn' name='mybutton' class='formbutton' $s>".l($btn)."</button></td>
		 </tr>
		</table>
	 </form></form>";


 	}
 ?>
