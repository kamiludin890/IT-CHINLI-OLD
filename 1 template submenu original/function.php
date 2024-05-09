<?php

function hapus($id,$nama_database,$nama_database_items){
	$string_delete="DELETE FROM $nama_database WHERE id='$id'";
	$ekskusi=mysql_query($string_delete);

	$string_delete_items="DELETE FROM $nama_database_items WHERE induk='$id'";
	$ekskusi2=mysql_query($string_delete_items);
return;}

//Pilihan BULAN & TAHUN START
function pilihan_bulan_tahun($pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$pecah_column_header,$nilai_pecah_column_header){
	echo "<table style='font-size:10px;'>
	<form method ='post'>
	<tr>
	 <td>".b(bulan)."</td>
	 <td>:</td>
	 <td><select name='pilihan_bulan' style='font-size:10px;'>
			<option value='$pilihan_bulan'>".$pilihan_bulan."</option>
			<option value=''></option>
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
	 <td>".b(tahun)."</td>
	 <td>:</td>";
	 echo "
	 <td><select name='pilihan_tahun' style='font-size:10px;'>";
	 echo "<option value='$pilihan_tahun'>$pilihan_tahun</option>";
	 $now=date('Y')+3;
	 for ($a=date('Y')-1;$a<=$now;$a++)
		{echo "<option value='".$a."'>".$a."</option>";}
		echo "</select></td>";

//KOLOM PENCARIAN
if ($pilihan_bulan != '' OR $pilihan_tahun != '') {
	echo "
	</table>
	<table><tr>
	<td style='font-size:10px;'>".b(pencarian)."</td>
	<td>:</td>
	<td><input type='text' style='font-size:10px;' name='pencarian' value='$pencarian'></td>
	</tr><tr>
	<td style='font-size:10px;'>".b(kolom)."</td>
	<td>:</td>
	<td><select name='pilihan_pencarian' style='font-size:10px;'>";
	echo "<option value='$pilihan_pencarian'>".b($pilihan_pencarian)."</option>";
	$no=0;for($i=0; $i < $nilai_pecah_column_header; ++$i){
		echo "<option value='$pecah_column_header[$no]'>".b($pecah_column_header[$no])."</option>";
	$no++;}
	echo "
	</select>
	</td>";}
//KOLOM PENCARIAN END

echo "
<td><input type='submit' style='font-size:10px;' value='".b(tampil)."'></td>
</tr>
</form>
</table>
</br>";
	//Pilihan TANGGAL & TAHUN END
return ;}
//Pilihan BULAN & TAHUN START


//TABEL START
function tabel($nama_database,$nama_database_items,$pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian,$pecah_column_header,$nilai_pecah_column_header,$nomor_halaman,$pilihan_bulan_tahun,$id_hal,$pecah_column_input,$nilai_pecah_column_input,$column_print){
include 'modules/master/style.css';

//KOLOM PENCARIAN Jika tanpa pilihan Bulan dan Tahun
if ($pilihan_bulan_tahun!=1) {
	echo "<table style='font-size:10px;'>
	<form method ='post'>";
	echo "
	<tr>
	<td style='font-size:10px;'>".b(pencarian)."</td>
	<td>:</td>
	<td><input type='text' style='font-size:10px;' name='pencarian' value='$pencarian'></td>
	</tr><tr>
	<td style='font-size:10px;'>".b(kolom)."</td>
	<td>:</td>
	<td><select name='pilihan_pencarian' style='font-size:10px;'>";
	echo "<option value='$pilihan_pencarian'>".b($pilihan_pencarian)."</option>";
	$no=0;for($i=0; $i < $nilai_pecah_column_header; ++$i){
		echo "<option value='$pecah_column_header[$no]'>".b($pecah_column_header[$no])."</option>";
	$no++;}
	echo "
	</select>
	</td>
	<td><input type='submit' style='font-size:10px;' value='".b(tampil)."'></td>
	</tr></form></table>";}
//KOLOM PENCARIAN Jika tanpa pilihan Bulan dan Tahun END


//DELETE
if ($_POST['delete']) {
	echo hapus($_POST['delete'],$nama_database,$nama_database_items);
}else{}
//DELETE END


$ijin_tambah='yes'; $ijin_update='yes';//IJIN TAMBAH DAN UPDATE

//TAMBAH DATA ARRAY
if ($_POST['opsi_input'] == 'tambah' AND $ijin_tambah == 'yes'){
$no=0;for($i=0; $i < $nilai_pecah_column_input; ++$i){
	if ($pecah_column_input[$no]==pembuat){$isi_kolom=$_SESSION['username'];}//Untuk Pembuat
	elseif ($pecah_column_input[$no]==tgl_dibuat){$isi_kolom=date('Y-m-d H:i:s');}//Untuk Waktu Pertama di Input
else{$isi_kolom=$_POST[$pecah_column_input[$no]];}
$datasecs[]=$pecah_column_input[$no]."='".$isi_kolom."'";
$no++;}

$data=implode(",", $datasecs);
$insert ="INSERT INTO $nama_database SET $data";
mysql_query($insert);
}//TAMBAH DATA ARRAY	END

//EDIT DATA ARRAY
if ($_POST['opsi_input'] == 'edit' AND $ijin_update == 'yes'){
$id=$_POST['id'];
$no=0;for($i=0; $i < $nilai_pecah_column_input; ++$i){
$nama_kolom=$pecah_column_input[$no];
if ($pecah_column_input[$no]==pembuat){$isi_kolom=$_SESSION['username'];}//Untuk Pembuat
else{$isi_kolom=$_POST[$pecah_column_input[$no]];}
$update="UPDATE $nama_database SET $nama_kolom='$isi_kolom' WHERE id='$id'";
mysql_query($update);
$no++;}
}//EDIT DATA ARRAY END

//TAMBAH
echo "<table style='margin-top:20px;'><tr>";
if (check_tambah($id_hal)==1) {
	$hal=ambil_database(url,master_menu,"id='$id_hal'");
	//Tambah
	echo "<form method ='post' action=''>";
	echo "<td><input type='image' src='themes/sub_menu/tambah.png' width='25' height'25' name='kembali' value='kembali'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='tambah' value='tambah'></td></form>";
	//Tambah END
}else{}

//PRINT EXCEL
if (check_print($id_hal)==1) {
	$hal=ambil_database(url,master_menu,"id='$id_hal'");
	echo "<td><form method ='POST' action='modules/tools/print_excel/print_excel.php' target='_blank'>";
	echo "<input type='image' src='themes/sub_menu/save_excel.png' width='25' height'25' name='print' value='print'>
				<input type='hidden' name='nama_database1' value='$nama_database'>
				<input type='hidden' name='pilihan_bulan1' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_tahun1' value='$pilihan_tahun'>
				<input type='hidden' name='pencarian1' value='$pencarian'>
				<input type='hidden' name='pilihan_pencarian1' value='$pilihan_pencarian'>
				<input type='hidden' name='pilihan_bulan_tahun1' value='$pilihan_bulan_tahun'>
				<input type='hidden' name='judul_excel' value='$hal'>
				<input type='hidden' name='column_print' value='$column_print'>
				</form></td>";
}else{}
////PRINT EXCEL END

//PRINT PDF
if (check_print_pdf($id_hal)==1) {
	$hal=ambil_database(url,master_menu,"id='$id_hal'");
	echo "<td><form method ='POST' action='modules/tools/print_pdf/laporan-pdf.php' target='_blank'>";
	echo "<input type='image' src='themes/sub_menu/save_pdf.png' width='25' height'25' name='print' value='print'>
				<input type='hidden' name='nama_database1' value='$nama_database'>
				<input type='hidden' name='pilihan_bulan1' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_tahun1' value='$pilihan_tahun'>
				<input type='hidden' name='pencarian1' value='$pencarian'>
				<input type='hidden' name='pilihan_pencarian1' value='$pilihan_pencarian'>
				<input type='hidden' name='pilihan_bulan_tahun1' value='$pilihan_bulan_tahun'>
				<input type='hidden' name='judul_pdf' value='$hal'>
				<input type='hidden' name='column_print' value='$column_print'>
				</form></td>";
}else{}
////PRINT PDF END
echo "</tr></table>";

//HEADER TABEL
echo "<table class='tabel_utama' style='margin-top:0px;'>";
echo "<thead>";
	echo "<th style=''><strong>No</strong></th>";
$no=0;for($i=0; $i < $nilai_pecah_column_header; ++$i){
	echo "<th><strong>".b($pecah_column_header[$no])."</strong></th>";
$no++;}
	echo "<th colspan='3' style=''><strong>".b(opsi)."</strong></th>";
echo "</thead>";
//HEADER END

//ISI TABEL
if ($pilihan_bulan OR $pilihan_tahun){$if_tanggal="WHERE tanggal LIKE '$pilihan_tahun-$pilihan_bulan%'";}else{$if_tanggal="";}
if ($pencarian AND $pilihan_bulan_tahun==1){$if_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian="";}
if ($pencarian AND $pilihan_bulan_tahun!=1){$if_pencarian1="WHERE $pilihan_pencarian LIKE '%$pencarian%'";}else{$if_pencarian1="";}

//PAGING
$halaman = 50;
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT	* FROM $nama_database $if_tanggal $if_pencarian $if_pencarian1");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT * FROM $nama_database $if_tanggal $if_pencarian $if_pencarian1 ORDER BY id DESC LIMIT $mulai, $halaman");//or die(mysql_error)
$no =$mulai+1;
//PAGING

while ($rows1=mysql_fetch_array($query)){
$warnaGenap="white";$warnaGanjil="#CEF6F5";if ($no % 2 == 0){$color=$warnaGenap;}else{$color = $warnaGanjil;}
echo "<tr>";
echo "<td style='background-color:$color;'>$no</td>";
$no_items=0;for($i=0; $i < $nilai_pecah_column_header; ++$i){
	echo "<td style='background-color:$color;'>".$rows1[$pecah_column_header[$no_items]]."</td>";
$no_items++;}


//EDIT
if (check_edit($id_hal)==1) {
	$hal=ambil_database(url,master_menu,"id='$id_hal'");
	echo "<form method ='post' action=''>";
	echo "<td><input type='image' src='themes/sub_menu/edit.png' width='25' height'25' name='kembali' value='kembali'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='edit' value='$rows1[id]'></td></form>";
}else{}
//EDIT END

//ITEM
if (check_item($id_hal)==1) {
	$hal=ambil_database(url,master_menu,"id='$id_hal'");
	echo "<form method ='post' action=''>";
	echo "<td><input type='image' src='themes/sub_menu/item.png' width='25' height'25' name='kembali' value='kembali'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'>
				<input type='hidden' name='item' value='$rows1[id]'></td></form>";
}else{}
//ITEM END

//DELETE
if (check_hapus($id_hal)==1) {
$hal=ambil_database(url,master_menu,"id='$id_hal'");
echo '<form method="POST" action="" onsubmit="return confirm(\''."Delete it?".'\');">';
echo "<td><input type='image' src='themes/sub_menu/delete.png' width='25' height'25' name='kembali' value='kembali'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='delete' value='$rows1[id]'></td></form>";
}else{}
//DELETE END


$no++;}
echo "</table>";

//PAGING KLIK
if ($total > '50') {
echo "<table>
<form method ='post' action='$address'>
<tr>
 <td>(Data:$total) Halaman</td>
 <td>:</td>
			<td><select name='halaman'>";
echo "<option value='$nomor_halaman'>$nomor_halaman</option>";
  for ($i=1; $i<=$pages; $i++){
echo "<option value='$i'>$i</option>";}
echo "</td>";
echo "<td> / $pages</td>";
		 echo "
		 <input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
		 <input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
		 <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		 <td><input type='submit' value='".b(tampil)."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END
return ;}
//TABEL END

//TAMPILAN TAMBAH
function tampilan_tambah_edit($edit,$nama_database,$pecah_column_input,$nilai_pecah_column_input,$nomor_halaman,$pilihan_bulan,$pilihan_tahun,$pencarian,$pilihan_pencarian){
include 'modules/master/style.css';
if ($edit==''){$opsi_input='tambah';}else{$opsi_input='edit';}

//KEMBALI
echo "<form method ='post' action=''>";
echo "<td><input type='image' src='themes/sub_menu/back.png' width='25' height'25' name='kembali' value='kembali'>
			<input type='hidden' name='halaman' value='$nomor_halaman'>
			<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
			<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
			<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
			<input type='hidden' name='pencarian' value='$pencarian'>
			<input type='hidden' name='tambah' value=''></td></form>";
//KEMBALI END


$sql5="SELECT * FROM $nama_database WHERE id='$edit'";
$result5=mysql_query($sql5);
$rows5=mysql_fetch_array($result5);

echo kalender();
echo combobox();

//TABEL ISI / EDIT
echo "<form method ='post' enctype='multipart/form-data'>";
		echo "<table class='kolom_isi'>";
		$no=0;for($i=0; $i < $nilai_pecah_column_input; ++$i){
			echo "<tr>";
			//HEADER
			echo "<td id='kolom_isi_th'><strong>".b($pecah_column_input[$no])."</strong></td>";
			//HEADER END

			//PENENTU KOLOM DISABLED DAN TANGGAL
			if ($pecah_column_input[$no] == 'id' OR $pecah_column_input[$no] == 'pembuat' OR $pecah_column_input[$no] == 'tgl_dibuat'){$disabled='readonly';}else{$disabled='';}
			if ($pecah_column_input[$no] == 'tanggal'){$format_tgl="class='date' required";}else{$format_tgl="";}
			//PENENTU KOLOM DISABLED DAN TANGGAL END

			//KOLOM ISI
			echo "<td><input type='text' $format_tgl name='$pecah_column_input[$no]' value='".$rows5[$pecah_column_input[$no]]."' $disabled style='width:95%; border-radius:4px; text-align:center;' autocomplete='off' required></td>";
			//KOLOM ISI END

			echo "</tr>";
		$no++;}

	echo "</table><table>";
	echo "<tr><td><input type='image' src='themes/sub_menu/save.png' width='25' height'25' name='simpan' value='Simpan'>
				<input type='hidden' name='opsi_input' value='$opsi_input'>
				<input type='hidden' name='id' value='$rows5[id]'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'></td></form>";

	echo "<form method ='post'>";
	echo "<td><input type='image' src='themes/sub_menu/back.png' width='25' height'25' name='kembali' value='kembali'>
				<input type='hidden' name='halaman' value='$nomor_halaman'>
				<input type='hidden' name='pilihan_tahun' value='$pilihan_tahun'>
				<input type='hidden' name='pilihan_bulan' value='$pilihan_bulan'>
				<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
				<input type='hidden' name='pencarian' value='$pencarian'></td></tr></form>";
	echo "</tr>";
	echo "</table>";

return ;}
//TAMPILAN TAMBAH END

?>
