<?php global $mod;
$mod='admincls/inputyield';
function editmenu(){extract($GLOBALS);}

function home(){extract($GLOBALS);
include 'function.php';
include 'style.css';
$address='?mod=admincls/inputyield';

echo kalender();
echo combobox();


$pencarian=$_POST['pencarian'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];
$nomor_halaman=$_POST['halaman'];


//UPDATE SELESAI ARRAY DARI FINISH
$id_yield=$_POST['id_yield'];
$id_item=$_POST['id_item'];
if ($id_yield) {
$no=0;for($i=0; $i < count($_POST['id_yield']); ++$i){

if ($id_yield[$no]!='') {
  $yield=$id_yield[$no];
  $id_sales=$id_item[$no];
  mysql_query("UPDATE sales_po SET id_yield='$yield' WHERE id='$id_sales'");
}

$no++;}
echo "<script type='text/javascript'>window.close();</script>";
}//UPDATE SELESAI ARRAY DARI FINISH END



echo "<table>";
echo "<form method='POST'>";
  echo "<td>Pencarian</td>";
  echo "<td>:</td>";
  echo "<td><input type='text' name='pencarian' value='$pencarian'></td>";
  echo "<td>
  <select name='pilihan_pencarian'>
  <option value='$pilihan_pencarian'>".ambil_database(eng,pusat_bahasa,"kode='$pilihan_pencarian'")."</option>
  <option value='tanggal'>Date</option>
  <option value='po_nomor'>PO Number</option>
  <option value='line_batch'>Line / Batch</option>
  <option value='dari'>Buyer</option>
  <option value='model'>Model</option>";
  echo "
  </select>
  </td>";
  //echo "<input type='hidden' name='halaman' value='$nomor_halaman'>";
  echo "<td><input type='submit' name='submit' value='Show'></td>";
echo "</form>";
echo "</table>";




echo "<table class='tabel_utama'>";

echo "<thead>";
  echo "<th>NO</th>";
  echo "<th>".ambil_database(eng,pusat_bahasa,"kode='tanggal'")."</th>";
  echo "<th>".ambil_database(eng,pusat_bahasa,"kode='po_nomor'")."</th>";
  echo "<th>".ambil_database(eng,pusat_bahasa,"kode='line_batch'")."</th>";
  echo "<th>".ambil_database(eng,pusat_bahasa,"kode='dari'")."</th>";
  echo "<th>".ambil_database(eng,pusat_bahasa,"kode='model'")."</th>";
  echo "<th>".ambil_database(eng,pusat_bahasa,"kode='yield'")."</th>";
echo "</thead>";


if ($pilihan_pencarian) {
  $script_pencarian="AND $pilihan_pencarian LIKE '%$pencarian%'";
}

//PAGING
$halaman = 20;
$page = isset($nomor_halaman) ? (int)$nomor_halaman : 1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$result = mysql_query("SELECT * FROM sales_po WHERE status NOT LIKE 'Selesai' $script_pencarian ORDER BY tanggal DESC");
$total = mysql_num_rows($result);
$pages = ceil($total/$halaman);
$query = mysql_query("SELECT * FROM sales_po WHERE status NOT LIKE 'Selesai' $script_pencarian ORDER BY tanggal DESC LIMIT $mulai, $halaman")or die(mysql_error);
$no =$mulai+1;
//PAGING


echo "<form method='POST' action='#'>";
while($rows=mysql_fetch_array($query)){

echo "<tr>";
  echo "<td>$no</td>";
  echo "<td>$rows[tanggal]</td>";
  echo "<td>$rows[po_nomor]</td>";
  echo "<td>$rows[line_batch]</td>";
  echo "<td>$rows[dari]</td>";
  echo "<td>$rows[model]</td>";


  echo "<td>
  <select class='comboyuk' name='id_yield[]'>
  <option value='$rows[id_yield]'>".ambil_database(yield,sales_mastermodel,"id='$rows[id_yield]'")."</option>";
  $result113=mysql_query("SELECT * FROM sales_mastermodel");
  while ($rows113=mysql_fetch_array($result113)) {
  echo "<option value='$rows113[id]'>$rows113[yield]</option>";}
  echo "
  </select>
  </td>";

	echo "<input type='hidden' name='id_item[]' value='$rows[id]'>";
echo "</tr>";

$no++;}

echo "<input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		  <input type='hidden' name='pencarian' value='$pencarian'>
		  <input type='hidden' name='halaman' value='$nomor_halaman'>";
echo "<tr>";
echo "<td colspan='6'></td>";
echo "<td><input type='image' src='modules/gambar/save.png' width='30' height'30' name='simpan' value='Simpan'></td>";
echo "</tr>";
echo "</form>";
echo "</table>";

//PAGING KLIK
if ($total > '50') {
echo "<table>
<form method ='post' action='$address'>
<tr>
 <td>Halaman</td>
 <td>:</td>
			<td><select name='halaman'>
			<option value='$nomor_halaman'>".$nomor_halaman."</option>";
  for ($i=1; $i<=$pages; $i++){
echo "<option value='$i'>$i</option>";}
echo "</td>";
		 echo "
		 <input type='hidden' name='pilihan_pencarian' value='$pilihan_pencarian'>
		 <input type='hidden' name='pencarian' value='$pencarian'>
		 <td><input type='submit' value='".ambil_database(eng,pusat_bahasa,"kode='tampil'")."'></td>
		</tr>
		</form>
		</table>";}
//PAGING KLIK END





}//END HOME
//END PHP?>
