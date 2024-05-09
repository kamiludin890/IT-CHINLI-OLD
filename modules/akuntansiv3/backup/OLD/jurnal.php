<?php global  $title, $mod, $tbl, $fld ,$p, $akses;
	$mod='akuntansiv3/jurnal';
	$tbl='akuntansiv3_jurnal';
	$fld='id,ref,tanggal,nomor,nama,keterangan,debit,kredit' ;
 	$p = getrow("periode1,periode2","master_setting","");

function editmenu(){extract($GLOBALS);	
	if ($_POST['mysubmit']=='add'){echo usermenu('insert,close');} 
	elseif($_POST['mysubmit']=='edit'){echo usermenu('save,close');}
	elseif($_POST['mysubmit']=='filter'){echo usermenu('filter,close');}
	else{echo usermenu('add,delete,filter,export');}
	}
	
function home(){extract($GLOBALS);	
	$limit = 25;
 	$p = getrow("periode1,periode2","master_setting","");
 	if ($rest==''){$rest=" where tanggal BETWEEN '$p[0]' AND '$p[1]'";} else { $rest.=" AND tanggal BETWEEN '$p[0]' AND '$p[1]'";}
	table($tbl,$fld,$limit,$rest,$mod);
	$_SESSION['myquery']=$query;

}

function editform($id,$btn){ extract($GLOBALS);  
	if(gubah($akses)!='Admin'){$btn='close';}
	$row = mysql_query("select $fld from $tbl");
	$r=getrow($fld,$tbl,"where id='$id'");	
	echo  " <form name=myform action='?mod=$mod&menu=aksi' method='post' id='contactform'>
	<input type=hidden name=id value=$id /><input type=hidden name=mysubmit />
	<ol>
	<li><label for='1'>".l(mysql_field_name($row, 1))."</label><input class='text' name='1' value='$r[1]'/></li>
	<li><label for='2'>".l(mysql_field_name($row, 2))."</label><input class='text' name='2' value='$r[2]'/></li>
	<li><label for='3'>".l(mysql_field_name($row, 3))."</label><input class='text' name='3' value='$r[3]'/></li>
	<li><label for='4'>".l(mysql_field_name($row, 4))."</label><input class='text' name='4' value='$r[4]'/></li>
	<li><label for='5'>".l(mysql_field_name($row, 5))."</label><textarea name='5' rows=8/>$r[5]</textarea></li>
	<li><label for='6'>".l(mysql_field_name($row, 6))."</label><input class='text' name='6' value='$r[6]'/></li>
	<li><label for='7'>".l(mysql_field_name($row, 7))."</label><input class='text' name='7' value='$r[7]'/></li>
	<li class='buttons'><button type=submit value=$btn name='mybutton' class='formbutton' >".l($btn)."</button></li>
	</ol>
	</form>	";
 	}	
 ?>