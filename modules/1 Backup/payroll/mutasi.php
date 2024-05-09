<?php global $mod;
	$mod='payroll/Mutasi';
function editmenu(){extract($GLOBALS);}

function kalender(){
		echo "
		<link rel='stylesheet' href='modules/tools/kalender_combo/jquery-ui.css'>
		<link rel='stylesheet' href='/resources/demos/style.css'>
		<script src='modules/tools/kalender_combo/jquery-1.12.4.js'></script>
		<script src='modules/tools/kalender_combo/jquery-ui.js'></script>

		<script>
		$( function() {
			$( '.date' ).datepicker({
				dateFormat: 'yy-mm-dd'
			});
		} );
		</script>
		</head>
		<body>";
		//<label >Date:</label>
		//<input type='text' id='date'>
return;}

function combobox(){
	echo "
	 <link href='modules/tools/kalender_combo/select2.min.css' rel='stylesheet' />
	 <script src='modules/tools/kalender_combo/select2.min.js'></script>

	<script type='text/javascript'>
	 $(document).ready(function() {
	     $('.comboyuk').select2();
	 });
	</script>";
return;}

function home(){extract($GLOBALS);
	include 'style.css';
	echo kalender();
	echo combobox();

	//AMBIL POST UTAMA START
	$pilihan_departement=$_POST['pilihan_departement'];
	$pencarian=$_POST['pencarian'];
	$pilihan_pencarian=$_POST['pilihan_pencarian'];


	//UPDATE BAGIAN
	$pilihan_id_bagian=$_POST['pilihan_id_bagian'];//Array
	$id_pilihan=$_POST['id_pilihan'];//Array
	$id_nomor_id=$_POST['id_nomor_id'];//Array
	$bagian_sebelumnya=$_POST['bagian_sebelumnya'];//array
	$pilihan_departement_update=$_POST['pilihan_departement_update'];//array

	if ($id_pilihan) {
	$no=0;
	$count=count($_POST['id_pilihan']);
	for($i=0; $i < $count; ++$i){

	if ($pilihan_id_bagian[$no]==''){}else{

		$sql_cari_nama="SELECT bagian,departement FROM payroll_jamkerja WHERE id='$pilihan_id_bagian[$no]'";
		$result_cari_nama=mysql_query($sql_cari_nama);
		$rows_cari_nama=mysql_fetch_array($result_cari_nama);

		$update="UPDATE payroll_data_karyawan SET bagian='$rows_cari_nama[bagian]',jam_kerja='$rows_cari_nama[bagian]',departement='$rows_cari_nama[departement]' WHERE id='$id_pilihan[$no]'";
		mysql_query($update);

		$update1="UPDATE payroll_absensi SET bagian='$rows_cari_nama[bagian]',jam_kerja='$rows_cari_nama[bagian]',departement='$rows_cari_nama[departement]' WHERE nomor_id='$id_nomor_id[$no]'";
		mysql_query($update1);
	}

	$no++;}
	}

	//Pilihan Departement & Bagian START
	echo "<h2><center>Mutasi Pegawai</center></h2>";
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/mutasi'>
	<tr>
	<td width='60px' valign='top'>Departement</td>
	<td>:</td>
	<td valign='top'>
	 <select class='comboyuk' name='pilihan_departement' style='width:auto'>";
	 $sql113="SELECT Departement FROM payroll_pilihan ORDER BY urut";
	 $result113=mysql_query($sql113);
  	 echo "<option value='$pilihan_departement'>".$pilihan_departement."</option>";
	 while ($rows113=mysql_fetch_array($result113)) {
	   echo "<option value='$rows113[Departement]'>".$rows113[Departement]."</option>";}
	echo "
	</select>
	</td>
	</tr>";
	echo "
	 <input type='hidden' name='pencarian' value='$pencarian'>
 	 <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
	 <td><input type='submit' value='Tampil'></td>
	</tr>
	</form>
	</table>
	</br>";
	//Pilihan Departement & Bagian END

//Pencarian
if ($pilihan_departement) {
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/mutasi'>
	<tr>
	 <td>Cari</td>
	 <td>:</td>
	 <td><input type='text' name='pencarian' value='$pencarian'></td>
	 <td><select name='pilihan_pencarian'>
			<option value='$pilihan_pencarian'>".$pilihan_pencarian."</option>
			<option value='nik'>nik</option>
			<option value='nama'>nama</option>
			<option value='departement'>departement</option>
			<option value='bagian'>bagian</option>
	 </td>
	 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
	 <td><input type='submit' value='Cari'></td>
	</tr>
	</form>
	</table>
	</br>";

echo "<form action='?menu=home&mod=payroll/mutasi' method='POST' name='forminputtanggal' enctype='multipart/form-data'>";

//Tabel Utama
echo "
<table class='tabel_utama' width=100% align=center>

<input type='hidden' name='pencarian' value='$pencarian'>
<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
<input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
<input type='submit' value='Simpan' style='width:100%'></br>

<thead style='background-color:#C0C0C0;'>
<th align=center width=3%>No</th>
<th align=center width=auto>Nik</th>
<th align=center width=auto>Nama</th>
<th align=center width=auto>Bagian</th>
<th align=center width=auto>Pindah Ke</th>
</thead>";

if ($_POST['pencarian']) {
	$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";
}

$sql13="SELECT * FROM payroll_data_karyawan WHERE departement='$pilihan_departement' $if_pencarian";
$result13=mysql_query($sql13);
$no=1;
while ($rows13=mysql_fetch_array($result13)) {

	$warnaGenap="#FFFFF";
	$warnaGanjil="#CEF6F5";
	if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}


echo "<input type='hidden' name='id_pilihan[]' value='$rows13[id]'>";
echo "<input type='hidden' name='id_nomor_id[]' value='$rows13[nomor_id]'>";
echo "<input type='hidden' name='bagian_sebelumnya[]' value='$rows13[bagian]'>";

echo "<tr>
<td style=background-color:$color; align=center>$no</td>
<td style=background-color:$color; align=center>$rows13[nik]</td>
<td style=background-color:$color; align=center>$rows13[nama]</td>
<td style=background-color:$color; align=center>$rows13[bagian]</td>
<td><select class='comboyuk' name='pilihan_id_bagian[]' style='width:100%'>
	 <option value=''></option>";
$sql1="SELECT departement,bagian,id FROM payroll_jamkerja ORDER BY departement,urut";
$result1=mysql_query($sql1);
while ($rows1=mysql_fetch_array($result1)) {
	 echo "<option value='$rows1[id]'>".$rows1[departement]." - ".$rows1[bagian]."</option>";}
echo "
</td>
</tr>";
$no++;}
echo "</form>";
echo "</table>";

}


}//END HOME
//END PHP?>
