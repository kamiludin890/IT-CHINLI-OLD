<?php global $mod;
	$mod='payroll/lemburan';
	function editmenu(){extract($GLOBALS);}

function home(){extract($GLOBALS);
include 'style.css';

	echo "<head>
	<style>
	table tr:hover td {
		background: #f2f2f2;
		background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(yellow));
		background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
	}
	</style>
	</head>";

		//AMBIL POST UTAMA START
		$pilihan_departement=$_POST['pilihan_departement'];
		$pilihan_bagian=$_POST['pilihan_bagian'];
		$input_lembur=$_POST['input_lembur'];
		$nomor_id=$_POST['nomor_id'];
		$pilihan_bulan=$_POST['pilihan_bulan'];
		$pilihan_tahun=$_POST['pilihan_tahun'];
		$edit_pembagian_ot=$_POST['edit_pembagian_ot'];
		$tanggal_edit_pembagian=$_POST['tanggal_edit_pembagian'];
		$eksekusi_update_edit=$_POST['eksekusi_update_edit'];
		//AMBIL POST UTAMA END


		//Pilihan Departement & Bagian START
		echo "<h2><center>Input Lemburan</center></h2>";
		echo "
		<table>
		<form method ='post' action='?menu=home&mod=payroll/Lemburan'>
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
		$sql1="SELECT bagian FROM payroll_jamkerja WHERE departement='$pilihan_departement' ORDER by urut";
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


//START Tabel PERTAMA
if ($pilihan_bagian != '' AND $input_lembur == '') {
		echo "
		<table style='background-color:white;' class='tabel_utama' width=100% align=center>
		<thead style='background-color:#C0C0C0;'>
		<th align=center width=3%>No</th>
		<th align=center width=auto>Nik</th>
		<th align=center width=auto>Nama</th>
		<th align=center width=auto>Departement</th>
		<th align=center width=auto>Bagian</th>
		<th align=center width=1%>Opsi</th>
		</thead>";

		$sql5="SELECT * FROM payroll_data_karyawan WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian'";
		$result5=mysql_query($sql5);
		$no=1;
		while ($rows5=mysql_fetch_array($result5)) {

			$warnaGenap="#FFFFF";
			$warnaGanjil="#CEF6F5";
			if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}

  echo "<tr>
				<td style=background-color:$color; align=center>$no</td>
				<td style=background-color:$color; align=center>$rows5[nik]</td>
				<td style=background-color:$color; align=center>$rows5[nama]</td>
				<td style=background-color:$color; align=center>$rows5[departement]</td>
				<td style=background-color:$color; align=center>$rows5[bagian]</td>";

	echo "
				<form action='?menu=home&mod=payroll/Lemburan' method='POST'>
				<input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
				<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
				<input type='hidden' name='nomor_id' value='$rows5[nomor_id]'/>
				<input type='hidden' name='input_lembur' value='input_lembur'/>";
	echo "<td style='font-weight:bold; background-color:$color; text-align:center; '><input type='image' src='modules/gambar/edit.png' width='30' height'30' name='submit1' value='Input Form'></td>";
	echo "</form>";

	echo "
				</tr>";
				$no++;}
}//END TABEL PERTAMA


//START TABEL KEDUA
if ($input_lembur) {

	//Pilihan TANGGAL & TAHUN START
	echo "<table>
	<form method ='post' action='?menu=home&mod=payroll/Lemburan'>
	<tr>
	 <td>Bulan</td>
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
	 <input type='hidden' name='nomor_id' value='$nomor_id'/>
	 <input type='hidden' name='input_lembur' value='$input_lembur'/>
	 <td><input type='submit' value='Tampil'></td>
	</tr>
	</form>
	</table>
	</br>";
	//Pilihan TANGGAL & TAHUN END

	//Buka Tabel EDI PEMBAGIAN
	if ($eksekusi_update_edit) {
		$ot1=$_POST['ot1'];
		$ot2=$_POST['ot2'];
		$ot3=$_POST['ot3'];
		$ot4=$_POST['ot4'];
		$update1="UPDATE payroll_absensi SET ot1='$ot1',ot2='$ot2',ot3='$ot3',ot4='$ot4' WHERE nomor_id='$nomor_id' AND tanggal='$tanggal_edit_pembagian'";
		$eksekusi_update1=mysql_query($update1);
	}
		echo "
		<form action='?menu=home&mod=payroll/lemburan' method='POST'>
		<table>
		<input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
		<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
		<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		<input type='hidden' name='nomor_id' value='$nomor_id'/>
		<input type='hidden' name='input_lembur' value='$input_lembur'/>
		<input type='hidden' name='edit_pembagian_ot' value='edit_pembagian_ot'/>
		<td style='font-weight:bold; background-color:#FFFFFF; text-align:center; '><input type='submit' name='submit2' value='Edit Pembagian OT'>
		</table>
		</form></br>";

		if ($edit_pembagian_ot) {
		echo "Edit Pembagian OT Manual</h2>";
		echo "
		<table>
		<form method ='post' action='?menu=home&mod=payroll/Lemburan'>
		<tr>
		 <td>Tanggal</td>
		 <td>:</td>
		 <td><select name='tanggal_edit_pembagian'>
 			 <option value='$tanggal_edit_pembagian'>".$tanggal_edit_pembagian."</option>";
 		$sql1="SELECT tanggal FROM payroll_absensi WHERE nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' ORDER BY tanggal";
 		$result1=mysql_query($sql1);
 		while ($rows1=mysql_fetch_array($result1)) {
 			 echo "<option value='$rows1[tanggal]'>".$rows1[tanggal]."</option>";}
 		echo "
 		</td>
		</tr>";
		echo "
		<tr>
		<td>OT 1</td>
		<td>:</td>
		<td><input type='text' name='ot1' value='$ot1' style='width:85px'></td>

		<td>OT 2</td>
		<td>:</td>
		<td><input type='number' name='ot2' value='$ot2' style='width:85px'></td>

		<td>OT 3</td>
		<td>:</td>
		<td><input type='number' name='ot3' value='$ot3' style='width:85px'></td>

		<td>OT 4</td>
		<td>:</td>
		<td><input type='number' name='ot4' value='$ot4' style='width:85px'></td>
		</tr>
		<tr>";

		echo "<input type='hidden' name='pilihan_departement' value='$pilihan_departement'>
					<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'>
					<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
					<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
					<input type='hidden' name='nomor_id' value='$nomor_id'/>
					<input type='hidden' name='input_lembur' value='$input_lembur'/>
					<input type='hidden' name='eksekusi_update_edit' value='eksekusi_update_edit'>";

		echo "
		 <td><input type='submit' value='Update'></td>
		</tr>
		</form>
		</table>
		</br>";
		}
	//kembali Tabel EDI PEMBAGIAN END


//START UPDATE LEMBURAN
	$data1=$_POST['id_absensi'];
	$data2=$_POST['jumlah_jam_lembur'];
	$data3=$_POST['hari'];
	$data4=$_POST['departement'];
	$data5=$_POST['bagian'];
	$data6=$_POST['nomor_id_2'];

if ($data1 != '' AND $data2 != '') {
	$no=0;
	$count=count($_POST['jumlah_jam_lembur']);
	for($i=0; $i < $count; ++$i){

		$update="UPDATE payroll_absensi SET lembur='$data2[$no]' WHERE id='$data1[$no]'";
		$eksekusi_update=mysql_query($update);

//RUMUS UPDATE LEMBURAN
if ($data2[$no] == '00:00:00' OR $data2[$no] == '00:00' OR $data2[$no] == '' ) {
	$ot1='0';$ot2='0';$ot3='0';$ot4='0';
	$update1="UPDATE payroll_absensi SET ot1='$ot1',ot2='$ot2',ot3='$ot3',ot4='$ot4' WHERE id='$data1[$no]'";
	$eksekusi_update1=mysql_query($update1);
}else {
	$lanjut='ya';
	$nomor_id_2=$data6[$no];
	$pilihan_departement_2=$data4[$no];
	$pilihan_bagian_2=$data5[$no];
}
	$no++;}

if($lanjut=='ya'){
	$sql8="SELECT * FROM payroll_absensi WHERE departement='$pilihan_departement_2' AND bagian='$pilihan_bagian_2' AND nomor_id='$nomor_id_2' ORDER BY lembur";
	$result8=mysql_query($sql8);
	while($rows8=mysql_fetch_array($result8)){
		$ambiljam = substr($rows8['lembur'],0,2);
		$ambilmenit = substr($rows8['lembur'],3,2);
		$ambilmenitdarijam = $ambiljam*60;
		$total_menit = $ambilmenit+$ambilmenitdarijam;

		$sql7="SELECT * FROM payroll_jamkerjaitems WHERE departement='$rows8[departement]' AND bagian='$rows8[bagian]' AND shift='$rows8[shift]' AND hari LIKE '%SABTU%'";
		$result7=mysql_query($sql7);
		$rows7=mysql_fetch_array($result7);

		if ($rows7['hari'] == 'SABTU') {$penentu_sabtu='ada';}else{$penentu_sabtu='tidak_ada';}

		if ($rows8['hari'] == 'Senin' OR $rows8['hari'] == 'Selasa' OR $rows8['hari'] == 'Rabu' OR $rows8['hari'] == 'Kamis' OR $rows8['hari'] == 'Jumat') {
		  if ($total_menit >= '60'){$sisa_dari_ot1=$total_menit-60;  $ot1=1.5;}elseif($total_menit < '60'){$ot1='0';}//OT1
		  if ($sisa_dari_ot1 >= '360'){$sisa_dari_ot2=$sisa_dari_ot1-360;  $ot2=12;}elseif($sisa_dari_ot1 < '360'){$kurang300=$sisa_dari_ot1/30; $ambilmenitot2=floor($kurang300)*30; $ot2=$ambilmenitot2/60*2;}//OT2
		  if ($sisa_dari_ot2 >= '60'){$sisa_dari_ot3=$sisa_dari_ot2-60;  $ot3=3;}elseif($sisa_dari_ot2 < '60'){$kurang60=$sisa_dari_ot2/30; $ambilmenitot3=floor($kurang60)*30; $ot3=$ambilmenitot3/60*3;}//OT3
		  if ($sisa_dari_ot3 >= '120'){$sisa_dari_ot4=$sisa_dari_ot3-120;  $kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}elseif($sisa_dari_ot3 < '120'){$kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}//OT4
		}

		if ($rows8['hari'] == 'Sabtu') {
		  if ($penentu_sabtu == 'ada') {
		    if ($total_menit >= '60'){$sisa_dari_ot1=$total_menit-60;  $ot1=1.5;}elseif($total_menit < '60'){$ot1='0';}//OT1
		    if ($sisa_dari_ot1 >= '360'){$sisa_dari_ot2=$sisa_dari_ot1-360;  $ot2=12;}elseif($sisa_dari_ot1 < '360'){$kurang300=$sisa_dari_ot1/30; $ambilmenitot2=floor($kurang300)*30; $ot2=$ambilmenitot2/60*2;}//OT2
		    if ($sisa_dari_ot2 >= '60'){$sisa_dari_ot3=$sisa_dari_ot2-60;  $ot3=3;}elseif($sisa_dari_ot2 < '60'){$kurang60=$sisa_dari_ot2/30; $ambilmenitot3=floor($kurang60)*30; $ot3=$ambilmenitot3/60*3;}//OT3
		    if ($sisa_dari_ot3 >= '120'){$sisa_dari_ot4=$sisa_dari_ot3-120;  $kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}elseif($sisa_dari_ot3 < '120'){$kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}//OT4
		  }
		  elseif ($penentu_sabtu == 'tidak_ada') {
		    if ($total_menit >= '0'){$sisa_dari_ot1=$total_menit-0;  $ot1=0;}elseif($total_menit < ''){$ot1='0';}//OT1
		    if ($sisa_dari_ot1 >= '420'){$sisa_dari_ot2=$sisa_dari_ot1-420;  $ot2=14;}elseif($sisa_dari_ot1 < '420'){$kurang300=$sisa_dari_ot1/30; $ambilmenitot2=floor($kurang300)*30; $ot2=$ambilmenitot2/60*2;}//OT2
		    if ($sisa_dari_ot2 >= '60'){$sisa_dari_ot3=$sisa_dari_ot2-60;  $ot3=3;}elseif($sisa_dari_ot2 < '60'){$kurang60=$sisa_dari_ot2/30; $ambilmenitot3=floor($kurang60)*30; $ot3=$ambilmenitot3/60*3;}//OT3
		    if ($sisa_dari_ot3 >= '120'){$sisa_dari_ot4=$sisa_dari_ot3-120;  $kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}elseif($sisa_dari_ot3 < '120'){$kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}//OT4
		  }
		}

		if ($rows8['hari'] == 'Minggu') {
		  if ($total_menit >= '0'){$sisa_dari_ot1=$total_menit-0;  $ot1=0;}elseif($total_menit < ''){$ot1='0';}//OT1
		  if ($sisa_dari_ot1 >= '420'){$sisa_dari_ot2=$sisa_dari_ot1-420;  $ot2=14;}elseif($sisa_dari_ot1 < '420'){$kurang300=$sisa_dari_ot1/30; $ambilmenitot2=floor($kurang300)*30; $ot2=$ambilmenitot2/60*2;}//OT2
		  if ($sisa_dari_ot2 >= '60'){$sisa_dari_ot3=$sisa_dari_ot2-60;  $ot3=3;}elseif($sisa_dari_ot2 < '60'){$kurang60=$sisa_dari_ot2/30; $ambilmenitot3=floor($kurang60)*30; $ot3=$ambilmenitot3/60*3;}//OT3
		  if ($sisa_dari_ot3 >= '120'){$sisa_dari_ot4=$sisa_dari_ot3-120;  $kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}elseif($sisa_dari_ot3 < '120'){$kurang120=$sisa_dari_ot3/30; $ambilmenitot4=floor($kurang120)*30; $ot4=$ambilmenitot4/60*4;}//OT4
		}

		$update1="UPDATE payroll_absensi SET ot1='$ot1',ot2='$ot2',ot3='$ot3',ot4='$ot4' WHERE id='$rows8[id]'";
		$eksekusi_update1=mysql_query($update1);
}
}//RUMUS UPDATE LEMBURAN


}//END UPDATE LEMBURAN

	//AMBIL POST KEDUA START
	$jumlah_jam_lembur=$_POST['jumlah_jam_lembur'];
	$id_absensi=$_POST['id_absensi'];
	//AMBIL POST KEDUA END

	echo "
	<table style='background-color:white;' class='tabel_utama' width=100% align=center>
	<thead style='background-color:#C0C0C0;'>
	<th align=center width=3%>No</th>
	<th align=center width=auto>Nik</th>
	<th align=center width=auto>Nama</th>
	<th align=center width=15%>Hari</th>
	<th align=center width=15%>Tanggal</th>
	<th align=center width=15%>Shift</th>
	<th align=center width=1%>Jumlah Jam</th>
	<th align=center width=1%>OT 1</th>
	<th align=center width=1%>OT 2</th>
	<th align=center width=1%>OT 3</th>
	<th align=center width=1%>OT 4</th>
	</thead>";

	$sql6="SELECT * FROM payroll_absensi WHERE departement='$pilihan_departement' AND bagian='$pilihan_bagian' AND nomor_id='$nomor_id' AND tanggal LIKE '$pilihan_tahun-$pilihan_bulan%' ORDER BY tanggal";
	$result6=mysql_query($sql6);
	$no=1;
	while ($rows6=mysql_fetch_array($result6)) {

		$warnaGenap="#FFFFF";
		$warnaGanjil="#CEF6F5";
		if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}

		if ($rows6[shift]) {$color1=$color; $shift=$rows6[shift]; $disabled='';}else {$color1=red; $shift="Mohon Diisi !"; $disabled="readonly";}

		echo "<tr>
					<td style=background-color:$color; align=center>$no</td>
					<td style=background-color:$color; align=center>$rows6[nik]</td>
					<td style=background-color:$color; align=center>$rows6[nama]</td>
					<td style=background-color:$color; align=center><strong>$rows6[hari]</strong></td>
					<td style=background-color:$color; align=center><strong>$rows6[tanggal]</strong></td>
					<td style=background-color:$color1; align=center><strong>$shift</strong></td>";

		echo "
					<form action='?menu=home&mod=payroll/Lemburan' method='POST'>
					<input type='hidden' name='pilihan_departement' value='$pilihan_departement'/>
					<input type='hidden' name='pilihan_bagian' value='$pilihan_bagian'/>
					<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'/>
					<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'/>
					<input type='hidden' name='nomor_id' value='$nomor_id'/>
					<input type='hidden' name='nomor_id_2[]' value='$nomor_id'/>
					<input type='hidden' name='id_absensi[]' value='$rows6[id]'/>
					<input type='hidden' name='hari[]' value='$rows6[hari]'/>
					<input type='hidden' name='departement[]' value='$rows6[departement]'/>
					<input type='hidden' name='bagian[]' value='$rows6[bagian]'/>
					<input type='hidden' name='input_lembur' value='input_lembur'/>";

					echo "<td style='background-color:$color; text-align:center; '>
					<input type='text' style='width:52px;' name='jumlah_jam_lembur[]' value='$rows6[lembur]' $disabled></td>";

		echo "<td style=background-color:$color; align=center><strong>$rows6[ot1]</strong></td>";
		echo "<td style=background-color:$color; align=center><strong>$rows6[ot2]</strong></td>";
		echo "<td style=background-color:$color; align=center><strong>$rows6[ot3]</strong></td>";
		echo "<td style=background-color:$color; align=center><strong>$rows6[ot4]</strong></td>";
$no++;}
	echo "<tr><td colspan=11;><input type='submit' style='width:100%;' name='submit' value='Simpan'/></tr></td>";
	echo "</form>";
}
//END TABEL KEDUA

}//END HOME
//END PHP?>
