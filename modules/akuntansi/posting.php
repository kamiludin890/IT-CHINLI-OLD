<?php global $mod;
	$mod='akuntansi/posting';
function editmenu(){extract($GLOBALS);}

function ambil_variabel($nama_database,$kolom) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode('","', $datasecs);
	$hasil='"'.$data.'"';
return $hasil;}

function pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $pecah_column;}

function nilai_pecah($column){
	$pecah_column=explode (",",$column);
	$nilai_jumlah_pecahan=count($pecah_column);
return $nilai_jumlah_pecahan;}


function home(){extract($GLOBALS);
include ('function.php');
$column_header='tanggal,kode,persamaan,jenis_kas,keterangan,status';
$column='tanggal,kode,persamaan,jenis_kas,keterangan,pembuat,tgl_dibuat';

//$column_items='po_nomor,line_batch,departement,kode_barang,material_description_po,satuan,qty_purchasing,price_usd,amount_usd,price_rp,amount_rp,etd,remark';
//$kolom_input='id_po,departement,kode_barang,material_description_po,satuan,qty_purchasing,price_usd,price_rp,etd,remark';

$nama_database='akuntansi_posting_master';
$nama_database_items='akuntansi_posting';

$address='?menu=home&mod=akuntansi/posting';

if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}


if (base64_decrypt($_GET['opsi'],"XblImpl1!A@")=='item') {
$opsi=base64_decrypt($_GET['opsi'],"XblImpl1!A@");
$id=base64_decrypt($_GET['id'],"XblImpl1!A@");
$nomor_halaman=$_GET['halaman'];
$pilihan_tahun=$_GET['pilihan_tahun'];
$pilihan_bulan=$_GET['pilihan_bulan'];
$pilihan_pencarian=$_GET['pilihan_pencarian'];
$pencarian=$_GET['pencarian'];}
if ($_POST[opsi]=='item') {
$opsi=$_POST['opsi'];
$id=$_POST['id'];
$nomor_halaman=$_POST['halaman'];
$pilihan_tahun=$_POST['pilihan_tahun'];
$pilihan_bulan=$_POST['pilihan_bulan'];
$pilihan_pencarian=$_POST['pilihan_pencarian'];
$pencarian=$_POST['pencarian'];}


//FINISH status
if ($_GET['fnh']) {
	mysql_query("UPDATE $nama_database SET status='Selesai',validasi='Valid' WHERE id='$id'");

	$tanggal=ambil_database(tanggal,$nama_database,"id='$id'");
	$tanggal_input=ambil_database(tgl_dibuat,$nama_database,"id='$id'");
	$kode_posting=ambil_database(kode,$nama_database,"id='$id'");
	$nama=ambil_database(keterangan,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");


	//Hapus Dulu
	mysql_query("DELETE FROM akuntansi_jurnal WHERE induk_master='$id'");

$result=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
while ($rows=mysql_fetch_array($result)) {


//DEBIT
$keterangan_debit=ambil_database(nama,akuntansi_akun,"nomor='$rows[debit]'");
$pembeda_saldo_awal_debit=ambil_database(kolom,akuntansi_akun,"nomor='$rows[debit]'");
$pembeda_laba_rugi_debit=ambil_database(pembeda_laba_rugi,akuntansi_akun,"nomor='$rows[debit]'");
		mysql_query("INSERT INTO akuntansi_jurnal SET
			induk='$rows[id]',
			induk_master='$id',
			ref='$rows[ref]',
			tanggal='$tanggal',
			tanggal_input='$tanggal_input',
			nama='$nama',
			nomor='$rows[debit]',
			keterangan='$keterangan_debit',
			debit='$rows[nominal_debit]',
			kredit='',
			pembeda_saldo_awal='$pembeda_saldo_awal_debit',
			pembeda_laba_rugi='$pembeda_laba_rugi_debit',
			kode_posting='$kode_posting'");

//KREDIT
$keterangan_kredit=ambil_database(nama,akuntansi_akun,"nomor='$rows[kredit]'");
$pembeda_saldo_awal_kredit=ambil_database(kolom,akuntansi_akun,"nomor='$rows[kredit]'");
$pembeda_laba_rugi_kredit=ambil_database(pembeda_laba_rugi,akuntansi_akun,"nomor='$rows[kredit]'");
		mysql_query("INSERT INTO akuntansi_jurnal SET
			induk='$rows[id]',
			induk_master='$id',
			ref='$rows[ref]',
			tanggal='$tanggal',
			tanggal_input='$tanggal_input',
			nama='$nama',
			nomor='$rows[kredit]',
			keterangan='$keterangan_kredit',
			debit='',
			kredit='$rows[nominal_kredit]',
			pembeda_saldo_awal='$pembeda_saldo_awal_kredit',
			pembeda_laba_rugi='$pembeda_laba_rugi_kredit',
			kode_posting='$kode_posting'");

	//KREDIT KEDUA
	$keterangan_kredit_kedua=ambil_database(nama,akuntansi_akun,"nomor='$rows[kredit_kedua]'");
	$pembeda_saldo_awal_kredit_kedua=ambil_database(kolom,akuntansi_akun,"nomor='$rows[kredit_kedua]'");
	$pembeda_laba_rugi_kredit_kedua=ambil_database(pembeda_laba_rugi,akuntansi_akun,"nomor='$rows[kredit_kedua]'");
			mysql_query("INSERT INTO akuntansi_jurnal SET
				induk='$rows[id]',
				induk_master='$id',
				ref='$rows[ref]',
				tanggal='$tanggal',
				tanggal_input='$tanggal_input',
				nama='$nama',
				nomor='$rows[kredit_kedua]',
				keterangan='$keterangan_kredit_kedua',
				debit='',
				kredit='$rows[nominal_kredit_kedua]',
				pembeda_saldo_awal='$pembeda_saldo_awal_kredit_kedua',
				pembeda_laba_rugi='$pembeda_laba_rugi_kredit_kedua',
				kode_posting='$kode_posting'");
	}
}//END FINISH


//START ITEM
if ($opsi=='item'){
	include 'style.css';

	//Kembali
	echo "<table><tr><td>";
	echo "<a href='$address&opsi=".base64_encrypt("home","XblImpl1!A@")."&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian'><img src='modules/gambar/back.png' width='25px'/></a>";
	echo "</td>";
	echo "</tr></table>";
	//Kembali END


//HEADER
	echo "<table style='font-size:22px;'>";

		echo "<tr>";
			echo "<td>Tanggal</td>";
			echo "<td>:</td>";
			echo "<td>".ambil_database(tanggal,akuntansi_posting_master,"id='$id'")."</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td>Kode</td>";
			echo "<td>:</td>";
			echo "<td>".ambil_database(kode,akuntansi_posting_master,"id='$id'")."</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td>Jenis Kas</td>";
			echo "<td>:</td>";
			echo "<td>".ambil_database(jenis_kas,akuntansi_posting_master,"id='$id'")."</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td>Keterangan</td>";
			echo "<td>:</td>";
			echo "<td>".ambil_database(keterangan,akuntansi_posting_master,"id='$id'")."</td>";
		echo "</tr>";

		$kelompok=ambil_database(kelompok,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
		$keterangan=ambil_database(keterangan,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
		echo "<tr>";
			echo "<td>Persamaan</td>";
			echo "<td>:</td>";
			echo "<td>$kelompok | $keterangan</td>";
		echo "</tr>";

		$debit=ambil_database(debit,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
		$nama_debit=ambil_database(nama,akuntansi_akun,"nomor='$debit'");
		echo "<tr>";
			echo "<td>Debit</td>";
			echo "<td>:</td>";
			echo "<td>$debit | $nama_debit</td>";
		echo "</tr>";

		$kredit=ambil_database(kredit,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
		$nama_kredit=ambil_database(nama,akuntansi_akun,"nomor='$kredit'");
		echo "<tr>";
			echo "<td>Kredit</td>";
			echo "<td>:</td>";
			echo "<td>$kredit | $nama_kredit</td>";
		echo "</tr>";

		$kredit_kedua=ambil_database(kredit_kedua,akuntansi_persamaan,"id='".ambil_database(persamaan,akuntansi_posting_master,"id='$id'")."'");
		$nama_kredit_kedua=ambil_database(nama,akuntansi_akun,"nomor='$kredit_kedua'");
		echo "<tr>";
			echo "<td>Kredit Kedua</td>";
			echo "<td>:</td>";
			echo "<td>$kredit_kedua | $nama_kredit_kedua</td>";
		echo "</tr>";

	echo "</table>";
//HEADER END

//$column_header='ref,jenis_doc,kontak,tanggal_doc,nomor_aju,invoice_faktur,kurs,jatuh_tempo,ppn,jumlah_ppn,nilai_ppn,bayar,sisa,nominal_debit,nominal_kredit,nominal_kredit_kedua,catatan,status';
$column_header='ref,jenis_doc,kontak,tanggal_doc,nomor_aju,invoice_faktur,bayar,nilai_ppn,ppn,jumlah_ppn,catatan';
$pecah_column_header=explode (",",$column_header);
$nilai_jumlah_pecahan_header=count($pecah_column_header);


//Tombol Input DOKUMEN BAYAR
if (ambil_database(status,akuntansi_posting_master,"id='$id'")!="Selesai"){
	echo "<table style='margin-top:20px;'>";
		echo "<tr>";

			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/akuntansi/posting_tambah.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Tambah".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";
				echo "<td> | </td>";
			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/akuntansi/posting_inputbc.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1500,height=550'.'\')">'."Dokumen BC".'</a>';//<img src='modules/gambar/tambah.png' width='30px' height='30px'/>
			echo "</td>";
				echo "<td> | </td>";
			echo "<td>";
				echo '<a href="#" style="" onClick="window.open(\''."modules/akuntansi/posting_edit.php?id=".base64_encrypt($id,'XblImpl1!A@')."".'\', \''.'mywindow'.'\', \''.'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=350'.'\')">'."Edit".'</a>';//<img src='modules/gambar/edit.png' width='30px' height='30px'/>
			echo "</td>";
				echo "<td> | </td>";
			echo "<td>";
				echo '<a onclick="return confirm(\''."Are you sure to finish?".'\')" href="'."$address&id=".base64_encrypt($id,"XblImpl1!A@")."&opsi=".base64_encrypt("item","XblImpl1!A@")."&fnh=fnh&halaman=$nomor_halaman&pilihan_tahun=$pilihan_tahun&pilihan_bulan=$pilihan_bulan&pilihan_pencarian=$pilihan_pencarian&pencarian=$pencarian".'">Finish</a>';//<img src="modules/gambar/finish.png" width="60px"/>
			echo "</td>";

		echo "</tr>";
	echo "</table>";
}
//Tombol Input DOKUMEN BAYAR END


echo "<table class='tabel_utama' style='width:auto;'>";
	//HEADER TABEL
	echo "<thead>";
		echo "<th style=''><strong>No</strong></th>";
	$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
		$sql3="SELECT $bahasa,kode FROM master_bahasa WHERE kode='$pecah_column_header[$no]'";
		$result3=mysql_query($sql3);
		$rows3=mysql_fetch_array($result3);
		echo "<th><strong>".$rows3[$bahasa]."</strong></th>";
	$no++;}
	echo "</thead>";
	//HEADER END


//ISI TABEL
$result=mysql_query("SELECT * FROM $nama_database_items WHERE induk='$id'");
$urut=1;
while ($rows=mysql_fetch_array($result)) {

	echo "<tr style='height:50px;'>";
	echo "<td>$urut</td>";
		$no=0;for($i=0; $i < $nilai_jumlah_pecahan_header; ++$i){
			if ($pecah_column_header[$no]=='ppn' OR $pecah_column_header[$no]=='jumlah_ppn' OR $pecah_column_header[$no]=='bayar') {
				echo "<td style='text-align:right'>".rupiah_pembulatan_round($rows[$pecah_column_header[$no]])."</td>";
			}else {
				echo "<td>".$rows[$pecah_column_header[$no]]."</td>";
			}
		$no++;}

	echo "</tr>";

$grand_total_bayar=$rows[bayar]+$grand_total_bayar;
$grand_total_ppn=$rows[ppn]+$grand_total_ppn;
$grand_jumlah_ppn=$rows[jumlah_ppn]+$grand_jumlah_ppn;

$urut++;}

echo "<tr style='height:25px; font-weight:bold;'>
<td colspan=7>TOTAL</td>
<td>".rupiah_pembulatan_round($grand_total_bayar)."</td>
<td></td>
<td>".rupiah_pembulatan_round($grand_total_ppn)."</td>
<td>".rupiah_pembulatan_round($grand_jumlah_ppn)."</td>
<td></td>
</tr>";
echo "</table>";
//ISI TABEL END


}else{
	//START UTAMA
	echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
	//END UTAMA
}


}//END HOME
//END PHP?>
