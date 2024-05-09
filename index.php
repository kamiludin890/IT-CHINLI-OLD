<?php
session_start();
ob_start();
error_reporting(0);
include('koneksi.php');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');


$connection=mysql_connect(s('db_server'), s('db_user'), s('db_password')) or die(mysql_error()) ;
mysql_select_db(s('db_name'));


//if(isset($_GET['bhs'])){$_SESSION['bahasa']=$_GET['bhs'];}
//if(isset($_SESSION['bahasa'])){$bhs=$_SESSION['bahasa']; $lang='lang/'.$bhs.'.php';} else {$lang='lang/id.php';}

if(isset($_GET['bhs'])){$_SESSION['bahasa']=$_GET['bhs'];}
if(isset($_SESSION['bahasa'])){$bhs=$_SESSION['bahasa']; } else {$bhs='ina';}

function l($id){ extract($GLOBALS);
 	$result=mysql_query("SET NAMES utf8");
 	$result=mysql_query("SELECT $bhs FROM master_bahasa where kode='$id'");
	$r=mysql_fetch_array($result);
	return $r[0];}

function toptitle(){extract($GLOBALS);
if(isset($_GET['mod'])){$mod=$_GET['mod']; } else {$mod='master/home';}

	echo "<span class='title'><img src='themes/images/logo.png' alt='stokbarang' /></span> <br /> ";
 	echo "<span class='bahasa'> ".l('bahasa').": <a href=?mod=$mod&bhs=ina>ID</a> | <a href=?mod=$mod&bhs=eng>EN</a> | <a href=?mod=$mod&bhs=cn>CN</a></span>";

	}


  function ambilhari($tanggal){
    //fungsi mencari namahari
    //format $tgl YYYY-MM-DD
    //harviacode.com
    $tgl=substr($tanggal,8,2);
    $bln=substr($tanggal,5,2);
    $thn=substr($tanggal,0,4);
    $info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
    switch($info){
        case '0': return "Minggu"; break;
        case '1': return "Senin"; break;
        case '2': return "Selasa"; break;
        case '3': return "Rabu"; break;
        case '4': return "Kamis"; break;
        case '5': return "Jumat"; break;
        case '6': return "Sabtu"; break;
    };
}

function satpam($id){
	if(isset($_SESSION['aksesid'])){ $aksesid=$_SESSION['aksesid'];

	$result=mysql_query("select akses from master_akses where id=$aksesid");
	$r=mysql_fetch_array($result);
	$userakses= $r['akses'];
	$kolom = explode(",", $userakses);
	$max=count($kolom);
	for ($i=0; $i< $max; ++$i){
	$r=getrow("judul","master_menu"," where id=$kolom[$i]");
	if ($r['judul']==$id){$hasil="oke"; break;} else {$hasil="gagal";}
	}

	return $hasil;
	}
	}

function validasi(){extract($GLOBALS);

	if(isset($_SESSION['username'])){
	$string =$_SESSION['username'];

	$result=mysql_query("SELECT lisensi FROM master_user WHERE email='$string'");
	$r=mysql_fetch_array($result);

	$lisensi=$r['lisensi'];
//	$mentah='wawan@sismadi.co.id,master,inventory,pos,akuntansi,exim';

	$key = 'bebekbakar to (en/de)crypt';
	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $mentah, MCRYPT_MODE_CBC, md5(md5($key))));
	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($lisensi), MCRYPT_MODE_CBC, md5(md5($key))), "\0");


//	echo "encrypted :".$encrypted."<br>";
//	echo "string :".$string."<br>";
//	echo "lisensi :".$lisensi."<br>";
	$decrypted='wawan@sismadi.com,master,inventory,pos,akuntansi,exim,delivery,sales,salescl,report,admin,laporan';

//	echo "descrypted 2:".$decrypted."<br>";

	$email=explode(',',$decrypted);
//	echo "descrypted 2:".$email[0]."<br>";
//$sql="DELETE FROM inventory_barang ORDER BY id LIMIT 10";
//$sql="DELETE FROM inventory_barang WHERE id NOT IN ( SELECT id  FROM ( SELECT id FROM inventory_barang ORDER BY id DESC LIMIT 10 ) x  ); ";

	if ($string!=$email[0]){ $result=mysql_query("SELECT id FROM inventory_barang"); $rowcount  = mysql_num_rows($result);
//	if ($rowcount >10) {mysql_query($sql); }
//	echo  l('v_free').", <a href='http://stokbarang.org' >www.stokbarang.org</a> ";
	} else {echo  "License to $string "; }
	}


	$array=explode(',',$decrypted);
	$inarray= explode('/',$_GET['mod'] );
	if (!in_array($inarray[0],$array)){ echo "<script type='text/javascript'>window.location.href='?menu=signform'</script>";}

	}

include(s('sis_theme'));

function import(){extract($GLOBALS);
	echo "<form method=post enctype='multipart/form-data' action=?mod=$mod&menu=doimport>
	Silakan Pilih File Excel: <input name=userfile type='file'>
	<input name=upload type=submit value=Import>
	</form>";
	}
function profiles(){extract($GLOBALS);

	$query = "SELECT id FROM master_user WHERE ol='on'";
 	$result=mysql_query($query,$connection);
	$rowcount  = mysql_num_rows($result);

	if(isset( $_SESSION['username'])) { $username= $_SESSION['username'];
	echo l('welcome')." <a style='font-size:15px;' href=?mod=master/profile&menu=profile> <b> $username </b> </a> | <a style='font-size:15px;' href=?menu=signout>".l('logout')."</a>|";//|<a href=?mod=master/profile&menu=online>".l('online'). " ( $rowcount ) </a>|
	}
	else {echo "<a style='font-size:15px;' href=?menu=signform><b>".l('login')."</b></a> |"; }// <a href='#'>".l('help')."</a>
	}

function menuv3($parent, $level) {
	$aksesid=$_SESSION['aksesid'];
//	$aksesid=1;
	$result=mysql_query("select akses from akses where id=$aksesid");
	$r=mysql_fetch_array($result);
	$tbl = 'menu';
	$userakses= $r['akses'];
	$result = mysql_query("SELECT a.id, a.urut, a.judul, a.url, Deriv1.Count FROM menu
	a LEFT OUTER JOIN (SELECT induk, COUNT(*) AS Count FROM menu GROUP BY induk)
	Deriv1 ON a.id = Deriv1.induk WHERE a.id in ($userakses) AND a.induk=". $parent ." and status='tampil' ORDER BY a.urut ASC");
	echo "<ul id='menu'>";
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['Count'] > 0) {
		echo "<li ><a href='". $row['url'] . "' title='". $row['judul'] . "' ><img src='images/61.png' alt='' /> " . $row['judul'] . "</a>";
		menu($row['id'], $level + 1); echo "</li>"; }
		elseif ($row['Count']==0) {
		echo "<li><a href='". $row['url'] . "' title='". $row['judul'] . "' ><img src='images/61.png' alt='' /> " . $row['judul'] . "</a></li>";
		}
		else;
		}
	echo "</ul>";
	}

function topnav(){
  	if(isset($_SESSION['aksesid'])){ $aksesid=$_SESSION['aksesid'];// } else {$aksesid=1; }

 	$result=mysql_query("select pintas from master_akses where id=$aksesid");
	$r=mysql_fetch_array($result);
	$userakses= $r['pintas'];
	if(isset($_GET['mod'])){$panel= explode('/',$_GET['mod'] );	$map=$panel[0];
	if($map=='') {$map="Login";} }

	echo  "<div class='toolbar'>
	<div class='toolbarLeft'></div>
	";

	$query2="SELECT judul,url,induk FROM master_menu WHERE id='$userakses' AND status='tampil'";
	$result2=mysql_query($query2);
	while ($r2 = mysql_fetch_assoc($result2)){
	$judul = strtolower($r2['judul']);
	echo"<div class='toolbarContent'><a href='$r2[url]'><div class='tools $judul'></div>".l($judul)."</a>|</div> ";
	}
	echo"
	<div class='toolbarRight'></div>
	<div style='clear:both;'></div>
	</div>";
	}
	}


function usermenu($btn){extract($GLOBALS);
// $akses=cakses();
//if(nambah($akses)!='boleh' && gubah($akses)!='Admin'){$r='salin,add,save,delete,import,ambil,lanjut';}
if(nambah($akses)!='boleh' ){$r='salin,add,import,ambil,lanjut';}
if(gubah($akses)!='Admin'){$r.='save,delete';}
else{$r='';}
$usermenu='';
	$kolom = explode(",", $btn);
	for ($i = 0; $i < count($kolom); ++$i ) {
if ( in_array ($kolom[$i] , explode(',',$r) ) ) {$s="style='float: left;display:none;'";} else {$s="style='float: left;'";}
	$usermenu .="<div $s  >  <a href=javascript:submitform('$kolom[$i]')> <div  class='tools $kolom[$i]'> </div> ".l($kolom[$i])."</a></div> "; }
	return $usermenu;
	}

function usermenu1($btn){extract($GLOBALS);
// $akses=cakses();
//if(nambah($akses)!='boleh' && gubah($akses)!='Admin'){$r='salin,add,save,delete,import,ambil,lanjut';}
if(nambah($akses)!='boleh' ){$r='salin,add,import,ambil,lanjut';}
if(gubah($akses)!='Admin'){$r.='save,delete';}
else{$r='';}
$usermenu='';
	$kolom = explode(",", $btn);
	for ($i = 0; $i < count($kolom); ++$i ) {
if ( in_array ($kolom[$i] , explode(',',$r) ) ) {$s="style='float: left;display:none;'";} else {$s="style='float: left;'";}
	$usermenu .="<div $s ><a href=javascript:submitform1('$kolom[$i]')> <div  class='tools $kolom[$i]'> </div> ".l($kolom[$i])."</a></div> "; }
	return $usermenu;
	}




//DISINI MENU it inventory
function navigation(){
  	if(isset($_SESSION['aksesid'])){ $aksesid=$_SESSION['aksesid']; //} else {$aksesid=1; }
	$result=mysql_query("select akses from master_akses where id=$aksesid");
	$r=mysql_fetch_array($result);
	$userakses= $r['akses'];
	if(isset($_GET['mod'])){$panel= explode('/',$_GET['mod'] );	$map=$panel[0];}else {$map="Login";}
	//$map= strtolower($map);

  date_default_timezone_set('Asia/Jakarta');
  $waktu_sekarang=date("Y-m-d H:i:s");
  $username_akses=$_SESSION['username'];
  $status='Mengakses';
  $keterangan="$username_akses Membuka Menu ".l($map)."";
  $ip_address=getClientIP();

  //Catat Menu yang diakses
  $catat_waktu_logout="INSERT INTO history_login (waktu_akses,status,username,ip_address_akses,keterangan)VALUES('$waktu_sekarang','$status','$username_akses','$ip_address','$keterangan')";
  $eksekusi_catat_waktu_login=mysql_query($catat_waktu_logout);

  if ($_SESSION[username]=='beacukai' AND $map=='exim') {
    echo "<div class='subHeader'> <div>Dokumen Pabean </div> </div>";
  }
  elseif ($_SESSION[username]=='beacukai' AND $map=='Laporanversidua') {
      echo "<div class='subHeader'> <div>Laporan </div> </div>";
  }else{
    echo "<div class='subHeader'> <div>".l($map)." </div> </div>";
  }

	echo "<div class='navPanel'>";
	$query1="SELECT id,url,judul FROM master_menu WHERE id in ($userakses) and map='$map' AND status='tampil' order by urut asc";
	$result1=mysql_query($query1);
	while ($r1 = mysql_fetch_assoc($result1)) {
	$judul = strtolower($r1['judul']);

  //Sub Menu
	echo "<a href='$r1[url]'>  <div class='tools $judul'> </div> " .l($judul)."</a>";

  $test_kode1=$r1['id'];
  //echo "$test_kode1";
	}
	echo "</div>";

//DISINI DAFTAR MENU IT inventory
	echo "<div class='navSelect'>
	<div class='navSeparator'></div>";
	$query2="SELECT judul,url,induk FROM master_menu WHERE id in ($userakses) and induk=0 AND status='tampil' order by urut asc";
	$result2=mysql_query($query2);
	while ($r2 = mysql_fetch_assoc($result2)) {
	$judul = strtolower($r2['judul']);
  //Menu
  if ($_SESSION[username]=='beacukai' AND $r2[judul] =='Exim') {
    echo " <a href='$r2[url]'> <div class='tools $judul'></div>Dokumen Pabean</a>";
  }
  elseif ($_SESSION[username]=='beacukai' AND $r2[judul] =='Laporanversidua') {
    echo " <a href='$r2[url]'> <div class='tools $judul'></div>Laporan</a>";
  }
  else {
    echo " <a href='$r2[url]'> <div class='tools $judul'></div> ".l($judul)."</a>";
  }

  //Catat Akses Menu
  $test_kode=$r2['url'];
  //echo "coba $test_kode";
}
	echo "</div>";

	}}

function title(){extract($GLOBALS);
	$panel= explode('/',$mod );	 $akses=ucwords($panel[1]);
	$panel= explode('_',$akses); $title=ucwords($panel[0]);
	return $title;
	}

  function catat_submenu($submenu){
    if ($submenu==''){}else{

    $query1="SELECT id,url,judul FROM master_menu WHERE id in ($userakses) and map='$map' AND status='tampil' order by urut asc";
  	$result1=mysql_query($query1);
  	$r1 = mysql_fetch_array($result1);
    $test_kode1=$r1['url'];

    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang=date("Y-m-d H:i:s");
    $username_akses=$_SESSION['username'];
    $status='Mengakses SubMenu';

    $sql23="SELECT * FROM master_bahasa WHERE kode='$ijin_catat'";
  	$result23= mysql_query($sql23);
  	$rows23=mysql_fetch_array($result23);
    $judul_bahasa=$rows23['ina'];

    $keterangan="$username_akses Membuka SubMenu $judul_bahasa";
    $ip_address=getClientIP();

    //Catat Akses Sub Menu
    $catat_akses_submenu="INSERT INTO history_login (waktu_akses,status,username,ip_address_akses,keterangan)VALUES('$waktu_sekarang','$status','$username_akses','$ip_address','$keterangan')";
    $eksekusi_catat_akses_submenu=mysql_query($catat_akses_submenu);
  }}


  function tanggal_waktu(){
    date_default_timezone_set('Asia/Jakarta');
    return $tanggal_waktu=date("Y-m-d H:i:s");
  }


function content(){
	if(!isset($_GET['mod'])){include 'modules/master/home.php'; } else  {include 'modules/'.$_GET['mod'].'.php'; }
	if(isset($_GET['export'])){echo "export";}
	$panel= explode('/',$mod );	$id=$panel[0]; $akses=ucwords($panel[1]);
	$panel= explode('_',$akses); $akses=ucwords($panel[0]);
	$judul = strtolower(title());

  date_default_timezone_set('Asia/Jakarta');
  $waktu_sekarang=date("Y-m-d H:i:s");
  $username_akses=$_SESSION['username'];
  $status='Mengakses';
  $keterangan="$username_akses Membuka Menu Sub Menu ".l($judul)."";
  $ip_address=getClientIP();

  //Catat Menu yang diakses
  $catat_waktu_logout="INSERT INTO history_login (waktu_akses,status,username,ip_address_akses,keterangan)VALUES('$waktu_sekarang','$status','$username_akses','$ip_address','$keterangan')";
  $eksekusi_catat_waktu_login=mysql_query($catat_waktu_logout);

	echo"
	<div class='subHeader latar'> <div>".l($judul)." </div> </div>
	<div class='subHeader1'><div class='toolbar'><div class='toolbarContent'>";
	if (satpam($akses)=='oke' || $akses=='Home') { editmenu(); }
	echo"</div></div></div>

	<div class='contentPanel' id='contentPanel'>";
//	if (satpam($akses)=='oke' || $akses=='Home') { if(!isset($_GET['menu'])){home();} else {$_GET['menu'](); }}
	if (satpam($akses)=='oke' ||$akses=='Home') { if(!isset($_GET['menu'])){home();} else {$_GET['menu'](); }}
	else{ echo "<script type='text/javascript'>window.location.href='?menu=signform'</script>"; }
	echo"</div>";
	}
 ?>

<script type="text/javascript" >
function setFocus(id) {	document.getElementById(id).focus(); }

function asub(frm) { document.getElementById(frm).submit();}

function filter (phrase, _id){
	var words = phrase.value.toLowerCase().split(" ");
	var table = document.getElementById(_id);
	var ele;
	for (var r = 1; r < table.rows.length; r++){
	ele = table.rows[r].innerHTML.replace(/<['^>']+>/g,"");
	var displayStyle = 'none';
	for (var i = 0; i < words.length; i++) {
	if (ele.toLowerCase().indexOf(words[i])>=0)
	displayStyle = '';
	else {	displayStyle = 'none';
	break;
	}}
	table.rows[r].style.display = displayStyle;	}}

function fsortir(id,mybutton){
	document.myform.sortir.value=id
	document.myform.mysubmit.value=mybutton
	document.myform.submit()}

function editform(id,mybutton){
	document.myform.id.value=id
	document.myform.mysubmit.value=mybutton
	document.myform.submit()}

function submitform(mybutton){
	document.myform.mysubmit.value=mybutton
	document.myform.submit()}

function submitform1(mybutton){
	document.myform1.mysubmit.value=mybutton
	document.myform1.submit()}

function submititem(mybutton){
	document.myitem.mysubmit.value=mybutton
	document.myitem.submit()}

function dropitem(){
	var men=document.getElementById(dropmenu).value;
	document.myitem.mysubmit.value=men
	document.myitem.submit()}

function nofaktur(faktur){
	document.getElementById(faktur).value=faktur}
function idfaktur(faktur){
	document.getElementById(id).value=faktur}
function isNumberKey(evt){
	var charCode=(evt.which)? evt.which : event.keyCode
	if(charCode>31&&(charCode<48 || charCode>57))
	return false
	return true}
function showtgl(id){

	var idhari='hari'+id;
	var idbulan='bulan'+id;
	var idtahun='tahun'+id;
	var idtgl='tgl'+id;

	var hari = document.getElementById(idhari).value;
	var bulan = document.getElementById(idbulan).value;
	var tahun = document.getElementById(idtahun).value;

	document.getElementById(idtgl).value=tahun+-+bulan+-+hari;
	return;	}
function popitup(url){
	newwindow=window.open(url,'name','height=400,width=750')
	if(window.focus){newwindow.focus()}}
function goToURL($url){
	window.location=$url}
function totaljual(subtotal){
	document.getElementById('subtotal').value=subtotal}
function checkUncheckAll(theElement){
	var theForm=theElement.form,z=0
	for(z=0;z<theForm.length;z++){
	if(theForm[z].type=='checkbox'&&theForm[z].name !='checkall'){theForm[z].checked=theElement.checked;}}}
function hitung(){
	var subtotal=parseFloat(document.getElementById('subtotal').value);
	var ppn= parseFloat(subtotal * 0.1);

	document.getElementById('ppn').value=ppn;
	document.getElementById('total').value= parseFloat(subtotal + ppn);
	return;	}



function calculate(){
 var total= parseFloat(document.getElementById('total').value);
	 document.getElementById('ppn').value = total * 0.1;
     document.getElementById('diskon').value = 0;
 var ppn= parseFloat(total * 0.1);
 var subtotal= total + ppn ;
 var diskon= parseFloat(document.getElementById('diskon').value);
 var grandtotal= subtotal - diskon;;
     document.getElementById('subtotal').value = subtotal;
     document.getElementById('grandtotal').value = grandtotal;
     return;}

function hhjual(){
	var harga=parseFloat(document.getElementById('harga').value);
	var diskon=parseFloat(document.getElementById('diskon').value);
	var banyak=parseFloat(document.getElementById('banyak').value);

	document.getElementById('hargajual').value= parseFloat(harga-diskon);
	document.getElementById('jumlah').value= arseFloat(hargajual*banyak);
		}


</script>
<?php

//if(!isset($_SESSION['username'])) { login(); }

function gantitangal(){
	list( $year, $month, $day ) = explode( $date, '-' );
	echo "$day-$month-$year";
	}


function export(){extract($GLOBALS);
	echo "<script type='text/javascript'>window.open('addon/export.php?table=$tbl&m=$mod')</script>";
	echo "Export Done !";
	echo "<br> Back to <a href='?menu=home&mod=$mod'> Home </a>";
	echo "<META HTTP-EQUIV=Refresh CONTENT='1; URL=http:?menu=home&mod=$mod'>";
//	home();
	}


//Project History Login
function signform(){ extract($GLOBALS);
	echo "	<div id='navbar' align='center'>
	<div id='login_menu' >
	<div id='new-user-col' ><br /><br />
	<h2>Login User</h2>
 	<form action='?menu=signin' method='post'>
	<ul>
	<li><label for='email'>".l('username')." :</label><input type='text' id='email' size='18' name='username' value='' /></li>
	<li><label for='psw'>".l('password')." :</label><input type='password' id='psw' size='18' name='password' value='' /></li>
	<li><button   type=submit value='login'  name='mybutton' class='formbutton' >".l('login')."</button></li>
	</ul>
	</form>
	</div>

	<div class='spacer'></div>
	</div>
	</div>";
	}


  function getClientIP() {

      if (isset($_SERVER)) {

          if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
              return $_SERVER["HTTP_X_FORWARDED_FOR"];

          if (isset($_SERVER["HTTP_CLIENT_IP"]))
              return $_SERVER["HTTP_CLIENT_IP"];

          return $_SERVER["REMOTE_ADDR"];
      }

      if (getenv('HTTP_X_FORWARDED_FOR'))
          return getenv('HTTP_X_FORWARDED_FOR');

      if (getenv('HTTP_CLIENT_IP'))
          return getenv('HTTP_CLIENT_IP');

      return getenv('REMOTE_ADDR');
  }

function signin(){ extract($GLOBALS);
	$username=$_POST['username'];
	$password=$_POST['password'];

	$username_gagal_login=$_POST['username'];

	$query = "SELECT email,sandi,akses FROM master_user WHERE email='$username' AND sandi='$password' ";
 	$result=mysql_query($query,$connection);
	$rowcount  = mysql_num_rows($result);
	$row=mysql_fetch_array($result);

	$username=$row['email'];
	$aksesid=$row['akses'];
	$userid=$row['email'];
	$_SESSION['username']=$username;
	$_SESSION['userid']=$userid;
	$_SESSION['aksesid']=$aksesid;

  date_default_timezone_set('Asia/Jakarta');
  $waktu_sekarang=date("Y-m-d H:i:s");
  $ip_address=getClientIP();
  if ($username=='') {$status='Gagal Login';} else {$status='logIn';}

  //perintah IF Penentu Gagal Login atau ngga
  if ($rowcount == 1) {
  //Catat Waktu Login
  $catat_waktu_login="INSERT INTO history_login (waktu_akses,status,username,password,ip_address_akses)VALUES('$waktu_sekarang','$status','$username','$password','$ip_address')";
  $eksekusi_catat_waktu_login=mysql_query($catat_waktu_login);

  $query ="UPDATE master_user SET ol='on' WHERE email='$username'";
  $result=mysql_query($query) or die('Error Signin, '.$query);

  echo "<script type='text/javascript'>window.location.href='?menu=home'</script>";
	}
	else{
    $status='Wrong Login';
    //Catat Gagal Login
    $catat_waktu_login="INSERT INTO history_login (waktu_akses,status,username,password,ip_address_akses)VALUES('$waktu_sekarang','$status','$username_gagal_login','$password','$ip_address')";
    $eksekusi_catat_waktu_login=mysql_query($catat_waktu_login);

	signform();
	}}

function signout(){
	$query ="UPDATE master_user SET ol='off' WHERE email='$_SESSION[username]'";
	$result=mysql_query($query) or die('Error Logout, '.$query);

  date_default_timezone_set('Asia/Jakarta');
  $waktu_sekarang=date("Y-m-d H:i:s");

  $catat_waktu_logout="INSERT INTO history_login (waktu_akses,status,username,ip_address_akses)VALUES('$waktu_sekarang','logOut','$_SESSION[username]','$ip_address')";
  $eksekusi_catat_waktu_login=mysql_query($catat_waktu_logout);

	unset($_SESSION['username']);
	session_destroy();
	echo "<script type='text/javascript'>window.location.href='?menu=signform'</script>";
	}


function welcome(){extract($GLOBALS);
	echo "<div class='info'><h2> Welcome </h2></div>";
	echo "Selamat datang !";
	}

function aksi(){extract($GLOBALS);
	if (isset($_POST['mybutton'])){  $_POST['mybutton']();} else {
	if (isset($_POST['mysubmit'])){  $_POST['mysubmit']();}}
	}

function close(){extract($GLOBALS);
	echo "<script type='text/javascript'>window.location.href='?mod=$mod&menu=home'</script>";
	}

function back(){extract($GLOBALS);
	echo "<script type='text/javascript'> history.back()</script>";
	}

function add(){extract($GLOBALS);
	editform('','insert');
	}

function salin(){extract($GLOBALS);
insert();
}

function insert(){extract($GLOBALS);
	//$gopage=
	$id=$_POST['id'];
	$kolom = explode(",", $fld);
	if (isset($_POST['nol'])) {$i=0;} else {$i=1;}
	for ( ;$i< count($kolom); ++$i){$datasecs[]=$kolom[$i]."='".$_POST[$i]."'" ; };
	$data=implode(",", $datasecs);
	$query ="INSERT INTO $tbl SET $data";
	$result=mysql_query($query)or die('Error Insert, '.$query);
	echo "<script type='text/javascript'>window.location.href='?mod=$mod&menu=home'</script>";
	}

function edit(){extract($GLOBALS);
	$id=$_POST['id'];
	if(isset($_POST['induk']) && $_POST['induk']!=''){$id=$_POST['induk'];}
	editform($id,'save');
	}

function save(){extract($GLOBALS);
	$kolom = explode(",", $fld);
	for ($i=1; $i< count($kolom); ++$i){$datasecs[]=$kolom[$i]."='".$_POST[$i]."'" ; };
	$data=implode(",", $datasecs);
	$query ="UPDATE $tbl SET $data WHERE id='$_POST[id]'";
	$result=mysql_query($query)or die('Error Upate, '.$query);
	echo "<script type='text/javascript'>window.location.href='?mod=$mod&menu=home'</script>";
	}

function delete(){extract($GLOBALS);
	$kolom = explode(",", $_POST['tbl']);

	$tbl=$kolom[0];
	$induk=$_POST['induk'];

	$checked = $_POST['checkbox'];
	$count = count($checked);

	for($i=0; $i < $count; ++$i){
	$query ="DELETE FROM $tbl WHERE id='$checked[$i]'";
	$result=mysql_query($query) or die('Error Delete, '.$query); }
	if(isset($_POST['items'])){editform($induk,'save');} else {
	echo "<script type='text/javascript'>window.location.href='?mod=$mod&menu=home'</script>";}
	}


  function deleteposting(){extract($GLOBALS);
  	$kolom = explode(",", $_POST['tbl']);

  	$tbl=$kolom[0];
  	$induk=$_POST['induk'];

  	$checked = $_POST['checkbox'];
  	$count = count($checked);

  	for($i=0; $i < $count; ++$i){
  	$query ="DELETE FROM akuntansi_posting WHERE id='$checked[$i]'";
    $query2="SELECT ref FROM akuntansi_posting WHERE id='$checked[$i]'";
    $result2=mysql_query($query2);
    while ($row2=mysql_fetch_array($result2)) {
      $query1 ="DELETE FROM akuntansi_jurnal WHERE ref='$row2[ref]'";
      $result1=mysql_query($query1);}

    $result=mysql_query($query) or die('Error Delete, '.$query);}

  	if(isset($_POST['items'])){editform($induk,'save');} else {
  	echo "<script type='text/javascript'>window.location.href='?mod=$mod&menu=home'</script>";}
  }

function table($tbl, $fld, $limit, $rest, $mod){
$r=getrow('cn','master_bahasa',"where ina='simpan'");
//echo "bahasa cn: ". $r[0];

validasi();
//if (isset($_GET['q'])){ $induk='';}
//echo 	$_GET['q'];
//echo 	$_SESSION['selectid'];

 //	$menu='home';
if (!isset($_POST['induk'])){ $induk='';}
if (!isset($_POST['id'])){ $id='';}
if (!isset($_POST['da'])){ $da='';}
if (!isset($_POST['sortir'])){ $sortir='';}
if (!isset($_POST['test'])){ $test='';}

//	$menu=$_POST['menu'];

if (isset($_POST['da'])){ $da=$_POST['da'] ; if($da=='ASC') {$da='DESC';} else {$da='ASC';}}

if (isset($_POST['sortir'])){ if($_POST['sortir']!="") {$sortir="order by ". $_POST['sortir'] ." $da" ;} else {$sortir="";}  }

//	if(isset($_POST['sortir'])) {$sortir="order by ". $_POST['sortir'] ." $da" ;} else {$sortir="";}
	if(isset($_POST['menu'])) {$menu=$_POST['menu'];} else {$menu="home";}


	if (isset($_POST['test'])){ $datasec=$_POST['test']; }
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld;}

	if(isset($_GET['page'])){ $noPage = $_GET['page'];} else $noPage = 1;
	$offset = ($noPage - 1) * $limit;

	//$offset = get_offset($limit);

	$query = "SELECT $data FROM $tbl $rest $sortir LIMIT $offset, $limit  ";
	$result = mysql_query($query) or die('Error Select'.$query);
	$no=1;
	$kolom = explode(",", $data);
	$jumkolom=count($kolom)+1;

//	echo "<div>";
//	echo "<form onSubmit='return false'> <input name='filt' onkeyup=\"filter(this, 'table-k', '1')\" type='text' class='inputboxSearch'></form>";
//	echo "<div class='clr'></div>";
	echo "<div class=scroll>";
	echo "<form name=myform action=?mod=$mod&menu=aksi method=post ><input type=hidden name=mysubmit >";
	echo "<input type=hidden name=menu value=$menu >";
	echo "<input type=hidden name=da value=$da >";
	echo "<input type=hidden name=sortir >";
	echo "<input type=hidden name=btn value='tbl' >";
	echo "<input type=hidden name=btns  >";
	echo "<input type=hidden name=induk >";
	echo "<input type=hidden name=id  >";
	echo "<input type=hidden name=tbl value=$tbl >";
	echo "<input type=hidden name=ids >";
	echo "<table id='table-k' >";

	echo "<tr> <td colspan=$jumkolom>";pagingv2($limit,$tbl,$menu,$mod,$rest); filter2($fld,'home'); echo "</td></tr></table>";

 	echo "<table class='filterable latar' id='table-k' ><thead>";

 //	echo "<tr> <th colspan=$jumkolom>";pagingv2($limit,$tbl,$menu,$mod,$rest); filter2($fld,'home'); echo "</th></tr>";
 	echo "<tr> <th ><input type=checkbox  onClick=checkUncheckAll(this) ></th>";
//	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th style='cursor:pointer;' onclick=fsortir('$kolom['$i']','edot')>$kolom['$i']</th>"; }
	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th style='cursor:pointer;' onclick=fsortir('$kolom[$i]','edot')>".l($kolom[$i]) ."</th>"; }
	echo "</tr></thead><tbody>";

	while ($row=mysql_fetch_array($result))  {
	echo "  <tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
	echo "<td align='center'><input type=checkbox  name='checkbox[]' value=$row[0] ></td>";
	for ($i = 0; $i < count($kolom); ++$i) { echo " <td style='cursor:pointer;' onclick=editform($row[0],'edit')> $row[$i] </td> "; }
	echo "</tr>";
	}
	echo "</tbody></table>";
	echo "</form>";
	echo "</div >";
	}

function detail($tbl, $fld, $limit, $rest, $mod,$id){
echo "ini id: ".$id;
//if (!isset($_POST['induk'])){ $induk='';}
//if (!isset($_POST['id'])){ $id='';}
//if (!isset($_POST['da'])){ $da='';}
//if (!isset($_POST['sortir'])){ $sortir='';}
//if (!isset($_POST['test'])){ $test='';}

//	$menu=$_POST['menu'];

if (isset($_POST['da'])){ $da=$_POST['da'] ; if($da=='ASC') {$da='DESC';} else {$da='ASC';}}

if (isset($_POST['sortir'])){ if($_POST['sortir']!="") {$sortir="order by ". $_POST['sortir'] ." $da" ;} else {$sortir="";}  }

	if(isset($_POST['menu'])) {$menu=$_POST['menu'];} else {$menu="home";}


	if (isset($_POST['test'])){ $datasec=$_POST['test']; }
	if (isset($datasec)) { $data=implode(",",$datasec); }else{$data=$fld;}

	if(isset($_GET['page'])){ $noPage = $_GET['page'];} else $noPage = 1;
	$offset = ($noPage - 1) * $limit;

	$query = "SELECT $data FROM $tbl $rest $sortir LIMIT $offset, $limit  ";
	$result = mysql_query($query) or die('Error Select'.$query);
	$no=1;
	$kolom = explode(",", $data);
	$jumkolom=count($kolom)+1;

	echo "<div class=scroll>";
 	echo "<table class='filterable latar' id='table-k' ><thead>";
 	echo "<tr>";

//	function detail($tbl, $fld, $limit, $rest, $mod){

	echo "<tr> <td colspan=$jumkolom>";pagingv3($limit,$tbl,$menu,$mod,$rest,$id); echo "</td></tr>";

	for ($i = 0; $i < count($kolom); ++$i ) { echo "<th >".l($kolom[$i]) ."</th>"; }
	echo "</tr></thead><tbody>";
	while ($row=mysql_fetch_array($result))  {
	echo "  <tr onMouseOver=this.bgColor='#F4F4F6' onMouseOut=this.bgColor='white' > ";
 	for ($i = 0; $i < count($kolom); ++$i) { echo " <td> $row[$i] </td> "; }
	echo "</tr>";}
	echo "</tbody></table>";
	echo "</div >";
	}

function edot(){extract($GLOBALS);
	$id=$_POST['sortir'];
	$da=$_POST['da'];
	$menu=$_POST['menu'];
 	$_POST['menu']();

//	echo " mana ". $_POST['menu'];
	}

function itemmenu($btn){
	$kolom = explode(",", $btn);
	for ($i = 0; $i < count($kolom); ++$i ) {
	$usermenu .="<a href=javascript:submititem('$kolom[$i]')> <img src='images/$kolom[$i].png' /> $kolom[$i]</a> "; }
	return $usermenu;
	}

function gubah($id){
//	if(isset($_SESSION['username'])){	$string =$_SESSION['username'];

	$aksesid=$_SESSION['aksesid'];
	$r=getrow('edit','master_akses',"where id='$aksesid'");
	$rs=getrow("id","master_menu"," where judul='$id'");
	if ( in_array ($rs['id'] , explode(',',$r['edit']) ) ) { $gubah='Admin';} else {  $gubah='User';}
	return $gubah;
	}

function nambah($id){
//	if(isset($_SESSION['username'])){	$string =$_SESSION['username'];

	$aksesid=$_SESSION['aksesid'];
	$r=getrow('tambah','master_akses',"where id='$aksesid'");
	$rs=getrow("id","master_menu"," where judul='$id'");
	if ( in_array ($rs['id'] , explode(',',$r['tambah']) ) ) { $nambah='boleh';} else {  $namhab='tidakboleh';}
	return $nambah;
	}



function tgl($name, $val){
	$sekarang=date('Y-m-d');
	if($val==''){

	$hari=date('d');
	$bulan=date('m');
	$tahun=date('Y');
	}

else{
	$hari=substr($val, 8, 2);
	$bulan=substr($val, 5, 2);
	$tahun=substr($val, 0, 4);}


	$idhari='hari'.$name;
	$idbulan='bulan'.$name;
	$idtahun='tahun'.$name;
	$idtgl='tgl'.$name;

	$tgl = "<select name=hari  id=$idhari onblur=showtgl($name) class=chari >";
	for ($i =1; $i <=31; $i++) 	{
	if($hari == $i){$s = 'selected'; }else{$s = '';}
	$tgl .= "<option value=$i $s >$i</option>"; }
	$tgl .= "</select>";

	$tgl .= "<select name=bulan  id=$idbulan onblur=showtgl($name) class=cbulan >";
	for ($n =1; $n <=12; $n++) 	{
	if($bulan == $n){$s = 'selected'; }else{$s = '';}
	$tgl .= "<option value=$n $s >$n</option>"; }
	$tgl .= "</select>";

	$tgl .= "<input   type=text name=tahun id=$idtahun onblur=showtgl($name) SIZE=4 MAXLENGTH=4 onkeypress='return isNumberKey(event)' value=$tahun class=ctahun class='text' >";
	$val=$tahun.'-'.$bulan.'-'.$hari;
	$tgl .= "<input  type=hidden name=$name  id=$idtgl value=$val>";
	return $tgl ;
	}

function drops($name, $fld, $val){
	$drops = "<select name=$name  >";
	$k = explode(",", $fld);
	for ($i = 0; $i < count($k); $i++) 	{
	if($val == $k[$i]){$s = 'selected'; }else{$s = '';}
	$drops .= "<option value='$k[$i]' $s >".l($k[$i])."</option>"; }
	$drops .= "</select>";
	return $drops;
	}

function droprow($cmb, $fname, $tbname, $val, $rest){
	$query="SELECT $fname FROM $tbname $rest";
	$result = mysql_query($query);
	$droprow = "<select name=$cmb >";
	while($t = mysql_fetch_array($result)){
	if($val == $t[0] ){$s = 'selected'; }else{$s = '';}
	$droprow .= "<option value='$t[0]' $s >$t[1]</option>"; }
	$droprow .= "</select>";
	return $droprow;
	}
function droprowv2($cmb, $fname, $tbname, $val, $rest){
	$query="SELECT $fname FROM $tbname $rest";
	$result = mysql_query($query);
	$droprow ="<select name=$cmb onChange=submitform('persamaan'); return false;>";
	while($t = mysql_fetch_array($result)){
	if($val == $t[0] ){$s = 'selected'; }else{$s = '';}
	$droprow .="<option value='$t[0]' $s >$t[1]</option>"; }
	$droprow .="</select>";
	return $droprow;
	}

function dropmenu($cmb, $fname, $tbname, $val){
	$query="SELECT $fname FROM $tbname ";
	$result = mysql_query($query);
	$dropmenu = "<select name=$cmb >";
	$dropmenu .= "<option value='0' $s >Top</option>";

	while($t = mysql_fetch_array($result)){
		if($val == $t[0] ){$s = 'selected'; }else{$s = '';}
	$dropmenu .= "<option value='$t[0]' $s >$t[1] </option>"; }
	$dropmenu .= "</select>";
	return $dropmenu;
	}

function id($mod){
	if($_GET['mod']==$mod){ echo " class='current'"; }
	}

function format_rupiah($angka){
	$rupiah=number_format($angka,0,',','.');
	return $rupiah;
	}

function get_offset($limit){extract($GLOBALS); global $offset;
	if(isset($_GET['page'])){ $noPage = $_GET['page'];} else $noPage = 1;
	$offset = ($noPage - 1) * $limit;
	return $offset ;
	}

function pagingv2($limit,$tbl,$menu,$mod,$rest){
	if(isset($_GET['page'])){ $noPage = $_GET['page'];
//	$_SESSION['noPage ']=$noPage;
	}
	else $noPage = 1;
//	$thepages="?mod=$mod&menu=home";
	$thepages="?mod=$mod&menu=$menu";
	$hasil  = mysql_query("SELECT COUNT(*) AS Count FROM $tbl $rest");
	$data  = mysql_fetch_array($hasil);
	$count = $data['Count'];
	$jumPage = ceil($count/$limit);
	echo "
	<div style='float:right'>
	<form name='menuform'>
	<input type=hidden name='gege' value='s'>".l('jumlah_data').": $count, ".l('halaman').":
	<select name='menu2'
	onChange='top.location.href = this.form.menu2.options[this.form.menu2.selectedIndex].value;
	return false;'>";
	for ($i =1; $i <=$jumPage; $i++) 	{
	if($noPage == $i){$s = 'selected'; }else{$s = '';}
	echo"<option value=$thepages&page=$i $s >$i</option>"; }
	echo"</select>
	</form></div>";
	}

function pagingv3($limit,$tbl,$menu,$mod,$rest,$id){

echo "ini ".$id;
	if(isset($_GET['page'])){ $noPage = $_GET['page'];
//	$_SESSION['noPage ']=$noPage;
	}
	else $noPage = 1;
//	$thepages="?mod=$mod&menu=home";
	$thepages="?mod=$mod&menu=pag&id=$id";
	$hasil  = mysql_query("SELECT COUNT(*) AS Count FROM $tbl $rest");
	$data  = mysql_fetch_array($hasil);
	$count = $data['Count'];
	$jumPage = ceil($count/$limit);
	echo "
	<div style='float:right'>
	<form name='menuform'>
	<input type=hidden name=id value=$id >
	<input type=hidden name='gege' value='s'>".l('jumlah_data').": $count, ".l('halaman').":
	<select name='menu2'
	onChange='top.location.href = this.form.menu2.options[this.form.menu2.selectedIndex].value;
	return false;'>";
	for ($i =1; $i <=$jumPage; $i++) 	{
	if($noPage == $i){$s = 'selected'; }else{$s = '';}
	echo"<option value=$thepages&page=$i $s >$i</option>"; }
	echo"</select>
	</form></div>";
	}

function filter(){extract($GLOBALS);
	$id=(int)$_POST['id'];
	$kolom = explode(",", $fld);
	echo "
	<form name=myform action=?mod=$mod&menu=hasilfilter method=post id='contactform'>";
	echo "<input type=hidden name=id value=$id >";
	echo "<input type=hidden name=mysubmit />
	<ol>";
	echo "<li><label>Kolom:</label><select name='test[']' multiple='multiple'>";
	for ($i = 0; $i < count($kolom); $i++) { echo"<option  value=$kolom[$i] >$kolom[$i]</option>";}
	echo"</select><br/>";

	echo"<li><label>Filter 1:</label> <input type=text name=txtcari1> ";
	echo"<select name=kategori1>";
	for ($i = 0; $i < count($kolom); $i++) { echo"<option>$kolom[$i]</option>";}
	echo"</select></li>";

	echo"<li><label>Filter 2:</label> <input type=text name=txtcari2> ";
	echo"<select name=kategori2>";
	for ($i = 0; $i < count($kolom); $i++) { echo"<option>$kolom[$i]</option>";}
	echo"</select></li>";

	echo"<li><label>Criteria:</label> ";
	echo"<select name=o>";
	echo"<option>AND</option>";
	echo"<option>OR</option>";
	echo"</select>";
	echo"</li>";
	echo"<li><label>ORDER By:</label> ";
	echo"<select  name='sortir'>";
	for ($i = 0; $i < count($kolom); $i++) { echo"<option>$kolom[$i]</option>";}
	echo"</select>";
	echo" <li class='buttons'><label for='10'></label> <input type='submit' class='formbutton' value=filter name='mybutton'/></li> ";
//	echo"<button type=submit value=Filter>Filter</button>";
	echo"
	</ol>
	</form>	";

	}

function hasilfilter (){ extract($GLOBALS);
	global $rest;
	$txtcari1=$_POST['txtcari1'];
	$kategori1=$_POST['kategori1'];
	$txtcari2=$_POST['txtcari2'];
	$kategori2=$_POST['kategori2'];
	$sortir=$_POST['sortir'];
	$o=$_POST['o'];
	$rest="";
		if($txtcari1!=""){
			if($rest==""){ $rest.=" where $kategori1 like '%$txtcari1%' ";}
			else { $rest.=" where $kategori1 like '%$txtcari1%' ";}
			}
		if($txtcari2!=""){
			if($rest==""){ $rest.=" where $kategori2 like '%$txtcari2%' ";}
			else { $rest.="$o  $kategori2 like '%$txtcari2%' ";}
			}

		if($rest!=""){ $rest=$rest; }else{}

	$_SESSION['rest']=$rest;
	$_SESSION['sortir']=$sortir;
	home();
	}

function upload(){extract($GLOBALS);
	echo "<div class='sort'>
		<form enctype=multipart/form-data action=?menu=hasilupload method=POST>
		<label>Pilih File</label><input name=uploaded type=file class='field'>
		<br/>
		<br/>
		<input type='submit' value='Upload' class='button'>
		</form>
		</div>";
	}

function hasilupload(){extract($GLOBALS);
	$target = "./images/";
	$target = $target . basename( $_FILES['uploaded']['name']) ;
	$ok=1;
	if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)){
	echo "<div class='sort'>
		<h1>Upload berhasil ! </h1>
		<form >
		<label>Alamat file:</label><input name=2 type=text value=$target  class='field'/ accept='*.drp'><br />
		</form>
		</div>";
		}
	else {echo "<div class=myadmin><h1>Gagal upload</h1></div>"; uploadform();}
	}

function terbilang($x){
	$abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	if ($x < 12)
	return " " . $abil[$x];
	elseif ($x < 20)
	return Terbilang($x - 10) . "belas";
	elseif ($x < 100)
	return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
	elseif ($x < 200)
	return " seratus" . Terbilang($x - 100);
	elseif ($x < 1000)
	return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
	elseif ($x < 2000)
	return " seribu" . Terbilang($x - 1000);
	elseif ($x < 1000000)
	return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
	elseif ($x < 1000000000)
	return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
	}

function setsesi($sname,$sval){extract($GLOBALS);
	$_SESSION[$sname]=$sval;
	return $id;
	}

function getsesi($sname){extract($GLOBALS);
	 if(isset($_SESSION[$sname])) { $id = $_SESSION[$sname];}else{$id=(int)1;}
	 return $id;
	}

function getlabel(){
	$_string = str_replace("_", " ", $_GET['mod']);
	$_string = ucwords($_string);
	echo $_string;
	}

function romawi($n){
	$romawi = explode(",", 'sismadi,I,II,III,IV,V,VI,VII,VIII,IX,X,XI,XII');
	return $romawi[$n];
	}

function about(){
	echo  "<div class='News'>";   echo "</div>";
	echo  "<div class='Welcome mod'>";
	echo " wawan sismadi <br>";
	echo " email : wawan.sismadi@gmail.com<br>";
	echo " mobile : +6281380994695<br>";
	echo " </div>";
	}

function menu($parent, $level) {
	$aksesid=$_SESSION['aksesid'];
//	$aksesid=1;
	$result=mysql_query("select akses from akses where id=$aksesid");
	$r=mysql_fetch_array($result);
	$tbl = 'menu';
	$userakses= $r['akses'];
	$result = mysql_query("SELECT a.id, a.urut, a.judul, a.url, Deriv1.Count FROM menu
	a LEFT OUTER JOIN (SELECT induk, COUNT(*) AS Count FROM menu GROUP BY induk)
	Deriv1 ON a.id = Deriv1.induk WHERE a.id in ($userakses) AND a.induk=". $parent ." and status='tampil' ORDER BY a.urut ASC");
	echo "<ul id='menu'>";
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['Count'] > 0) {
		echo "<li ><a href='". $row['url'] . "' title='". $row['judul'] . "' ><img src='images/61.png' alt='' /> " . $row['judul'] . "</a>";
		menu($row['id'], $level + 1); echo "</li>"; }
		elseif ($row['Count']==0) {
		echo "<li><a href='". $row['url'] . "' title='". $row['judul'] . "' ><img src='images/61.png' alt='' /> " . $row['judul'] . "</a></li>";

		}
		else;
		}
	echo "</ul>";
	}

function getrow($fname,$tbname,$rest){
 	$result=mysql_query("SELECT $fname FROM $tbname $rest");
	$r=mysql_fetch_array($result);
	return $r;
	}

function getfaktur($fld,$lvl){
	$r=getrow("kode,$fld","master_setting","");
	$id= $r[$fld]+1;

	$query ="UPDATE master_setting SET $fld='$id' ";
	$result=mysql_query($query)or die('Error Upate, '.$query);

	$getfaktur = str_pad($id, 4, '0', STR_PAD_LEFT);
	$getfaktur .= "/" .$r['kode'].$lvl;
	$getfaktur .= "/" .romawi(date('n'));
	$getfaktur .= "/" .date('Y');
	return   $getfaktur;
	}

function filter2($items,$result){extract($GLOBALS);
	$txtcari1=$_SESSION['txtcari1'];
	$selectid=$_SESSION['selectid'];
	$selectdate=$_SESSION['selectdate'];
	echo"<div style='float:left'>";
//echo"	<input name=\"tag\" type=\"text\" id=\"tag\" size=\"20\"/>";
	echo l('cari')."  <input type=hidden name=result value=$result ><input type=text name=txtcari1 id=tag  value=$txtcari1 > ";
	echo "<select name=kategori1>";
	$kolom = explode(",", $items);
	for ($i = 1; $i < count($kolom); $i++) 	{ if($selectid==$kolom[$i]){$s = 'selected'; }else{$s = '';}
	echo"<option  $s value=$kolom[$i] >".l($kolom[$i])."</option>";	}
	echo"</select>";

$result = mysql_query("SHOW COLUMNS FROM $tbl LIKE 'tanggal'");
$exists = (mysql_num_rows($result))?TRUE:FALSE;

if($exists==true){
 	$username= $_SESSION['username'];
	$r=getrow('periode','master_user',"where email='$username'");
	$kini=date('Y-m-d');
	$awal=date("Y-m-01", strtotime($kini) ) ;
	$akhir=date("Y-m-t", strtotime($kini) ) ;

	$page = array(
	0 => l('semuaperiode'),
	1 => l('hariini')." (".$kini.")",
	2 => l('bulanini')." (".$awal ." s/d ". $akhir.")",
	3 => l('pilihan')." ("."$r[0]".")"
	 );

	echo " Periode : <select name=kategori2>";
	foreach($page as $key => $value) {
	if($selectdate==$key){$s = 'selected'; }else{$s = '';}
	echo"<option  $s value=$key >$value</option>";
	}
	echo"</select>";
}

echo"<button type=submit value='dofilter2' name='mybutton' class='formbutton' >".l('filter')."</button></div>";
	}

function dofilter2(){ global $rest;
	$_SESSION['txtcari1']=$_POST['txtcari1'];
	$_SESSION['selectid']=$_POST['kategori1'];
	$_SESSION['selectdate']=$_POST['kategori2'];
	$txtcari1=$_POST['txtcari1'];
	$kategori1=$_POST['kategori1'];
 	$kat=$_POST['kategori2'];

$kini=date('Y-m-d');
$awal=date("Y-m-01", strtotime($kini) ) ;
$akhir=date("Y-m-t", strtotime($kini) ) ;

$username= $_SESSION['username'];
$r=getrow('periode','master_user',"where email='$username'");
$pilih = explode("s/d", $r[0]);
$pawal=$pilih[0];
$pakhir=$pilih[1];

$d="";
if($kat==1){$d=" and tanggal='$kini' ";}
if($kat==2){$d=" and tanggal between  '$awal'  and '$akhir' ";}
if($kat==3){$d=" and tanggal between  '$pawal'  and '$pakhir' ";}



	$rest="";
//		if($txtcari1!=""){
			if($rest==""){ $rest.=" where $kategori1 like '%$txtcari1%' $d ";}
			else { $rest.="  where $kategori1 like '%$txtcari1%' $d ";}
//			}
	$_SESSION['rest']=$rest;
	$_POST['result']();

	}

function ddparam($name,$val,$rest){
	$query="SELECT isi FROM master_param where nama='$rest'";
	$result = mysql_query($query);
	$row=mysql_fetch_array($result);
	$ddmenu = "<select name='$name' >";
	$k = explode(",", $row[0]);
	for ($i = 0; $i < count($k); $i++) 	{
	if($val == '$k[$i]'){$s = 'selected'; }else{$s = '';}
	$ddmenu .= "<option value='$k[$i]' $s >$k[$i]</option>"; }
	$ddmenu .= "</select>";
	return $ddmenu;
	}
ob_end_flush();
?>
