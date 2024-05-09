<?php global $mod;
$mod='payroll/Resign';
function editmenu(){extract($GLOBALS);}


function home(){extract($GLOBALS);

	//AMBIL POST UTAMA START
	$pilihan_departement=$_POST['pilihan_departement'];
	$pilihan_bagian=$_POST['pilihan_bagian'];
	$pilihan_tahun=$_POST['pilihan_tahun'];
	$pilihan_bulan=$_POST['pilihan_bulan'];
	$pencarian=$_POST['pencarian'];
	//AMBIL POST UTAMA END

	//Pilihan Departement & Bagian START
	echo "<h2><center>Karyawan Resign</center></h2>";
	echo "
	<table>
	<form method ='post' action='?menu=home&mod=payroll/Resign'>
	<tr>
	<td width='60px' valign='top'>Departement</td>
	<td>:</td>
	<td valign='top'>
	 <select name='pilihan_departement' style='width:auto'>";
	 $sql113="SELECT Departement FROM payroll_pilihan ORDER BY urut";
	 $result113=mysql_query($sql113);
  	 echo "<option value='$pilihan_departement'>".$pilihan_departement."</option>";
	 while ($rows113=mysql_fetch_array($result113)) {
	   echo "<option value='$rows113[Departement]'>".$rows113[Departement]."</option>";}
	echo "
	</select>
	</td>
	</tr>";
	if ($pilihan_departement) {
	echo "
	<tr>
	<td>Bagian</td>
	<td>:</td>
	<td><select name='pilihan_bagian'>
		 <option value='$pilihan_bagian'>".$pilihan_bagian."</option>";
	$sql1="SELECT bagian FROM payroll_jamkerja WHERE departement='$pilihan_departement'";
	$result1=mysql_query($sql1);
	while ($rows1=mysql_fetch_array($result1)) {
		 echo "<option value='$rows1[bagian]'>".$rows1[bagian]."</option>";}
	echo "
	</td>
	</tr>
	<tr>";}
	echo "
	 <td><input type='submit' value='Tampil'></td>
	</tr>
	</form>
	</table>
	</br>";
	//Pilihan Departement & Bagian END

//TABEL START
if ($pilihan_bagian){

	//Pilihan TANGGAL & TAHUN START
	echo "<table>
	<form method ='post' action='?menu=home&mod=payroll/Resign'>
	<tr>
	 <td>Habis Kontrak di Bulan</td>
	 <td>:</td>
	 <td><select name='pilihan_bulan'>
			<option value='$pilihan_bulan'>".$pilihan_bulan."</option>
			<option value='01'>01</option>
			<option value='02'>02</option>
			<option value='03'>03</option>
			<option value='04'>04</option>
			<option value='05'>05</option>
			<option value='06'>06</option>
			<option value='07'>07</option>
			<option value='08'>08</option>
			<option value='09'>09</option>
			<option value='10'>10</option>
			<option value='11'>11</option>
			<option value='12'>12</option>
	 </td>
	 <td>Tahun</td>
	 <td>:</td>
	 <td><select name='pilihan_tahun'>
			<option value='$pilihan_tahun'>".$pilihan_tahun."</option>
			<option value='2020'>2020</option>
			<option value='2021'>2021</option>
			<option value='2022'>2022</option>
			<option value='2023'>2023</option>
	 </td>
	 <input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
	 <input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
	 <td><input type='submit' value='Tampil'></td>
	</tr>
	</form>
	</table>
	</br>";
	//Pilihan TANGGAL & TAHUN END

//TABEL PILIHAN BULAN START
if ($pilihan_bulan) {

	//TABEL
	echo "
	<table class=table width=100% align=center border=1>
	<tr style='background-color:#C0C0C0;'>
	<th align=center width=20>No</th>
	<th align=center width=auto>Departement</th>
	<th align=center width=auto>Bagian</th>
	<th align=center width=auto>Nik</th>
	<th align=center width=auto>Nama</th>
	<th align=center width=auto>Lama Bekerja</th>
	</tr>";

	$sql1="SELECT * FROM payroll_data_karyawan WHERE resign='YA'";
	$result1=mysql_query($sql1);
	$no=1;
	while ($rows1=mysql_fetch_array($result1)) {
	echo "<tr>
	<td style=background-color:$color; align=center>$no</td>
	<td style=background-color:$color; align=center>$rows1[departement]</td>
	<td style=background-color:$color; align=center>$rows1[bagian]</td>
	<td style=background-color:$color; align=center>$rows1[nik]</td>
	<td style=background-color:$color; align=center>$rows1[nama]</td>
	<td style=background-color:$color; align=center>Lama Bekerja</td>
	</tr>";
$no++;}
echo "</table>";


}//TABEL PILIHAN BULAN END
}//TABEL END - PILIHAN BAGIAN


}//END HOME
//END PHP?>
