<?php
include('../../koneksi.php');
$conn=mysql_connect(s('db_server'), s('db_user'), s('db_password')) or die(mysql_error()) ;
mysql_select_db(s('db_name'));

include('../../addon/xml/ExcelWriterXML.php');

function rupiah($angka){
  $hasil_rupiah = "" . number_format($angka,2,'.','');
  return $hasil_rupiah;
 }

function getrow($fname,$tbname,$rest){
 	$result=mysql_query("SELECT $fname FROM $tbname $rest");
	$r=mysql_fetch_array($result);
	return $r;
	}

function bln($b) {
	$kini=date('Y').'-'.$b.'-'.date('d');
	$s=array(
	0 => date("Y-m-01", strtotime($kini)),
	1 => date("Y-m-t", strtotime($kini)),
	2 =>date("F", strtotime($kini))
	);
	return $s;
}
$r=getrow('lapbul1,lapbul4,lapbul0','master_setting','');
$bln=bln($r[0]); $periode=$bln[2] ;
$xml = new ExcelWriterXML('bukubesar.xml');

$xml->docTitle('Buku Besar');
$xml->docAuthor('Robert F Greer');
$xml->docCompany('Greers.Org');
$xml->docManager('Wife');

$xml->showErrorSheet(true);

$format3 = $xml->addStyle('wraptext_top');
$format3->alignWraptext();
$format3->alignHorizontal('Center');
$format3->fontSize('12');
$format3->fontBold();

$format1 = $xml->addStyle('th');
$format1->fontBold();
$format1->border('All',1,'Black','Continuous');


$sheet1 = $xml->addSheet('Bukubesar');


//Ambil Saldo Awal
$username=$_GET['username'];//USERNAME
$akun=$_GET['akun'];//AKUN

if ($akun=='01') {
	$akun_all="nomor NOT IN ('','A-1','A-2','A-3')";
}else {
	$akun_all="nomor='$akun'";
}

$sql22="SELECT * FROM master_user WHERE email='$username'";
$result22= mysql_query($sql22);
$rows22=mysql_fetch_array($result22);

$query23="SELECT SUM(debit) FROM akuntansiv2_jurnal WHERE $akun_all AND tanggal BETWEEN '$rows22[saldo_awal_buku_besar1]' AND '$rows22[saldo_awal_buku_besar2]'";
$result23=mysql_query($query23);
$row23=mysql_fetch_array($result23);

$query24="SELECT SUM(kredit) FROM akuntansiv2_jurnal WHERE $akun_all AND tanggal BETWEEN '$rows22[saldo_awal_buku_besar1]' AND '$rows22[saldo_awal_buku_besar2]'";
$result24=mysql_query($query24);
$row24=mysql_fetch_array($result24);

$query31="SELECT * FROM akuntansiv2_jurnal WHERE $akun_all";
$result31=mysql_query($query31);
$row31=mysql_fetch_array($result31);

    $totaldebit=$row23['SUM(debit)'];
    $totalkredit=$row24['SUM(kredit)'];
    $pembedaakun=$row31['pembeda_saldo_awal'];
    $saldoawal=$totaldebit - $totalkredit;
    $saldo_bulan_sebelumnya=rupiah($saldoawal);
//End Ambil Saldo Awal


$sheet1->writeString(1, 1, 'BUKUBESAR','wraptext_top');
$sheet1->writeString(2, 1, 'PT CHINLI PLASTIC MATERIALS INDONESIA','wraptext_top');
$sheet1->writeString(3, 1, "(Saldo Sebelumnya $rows22[saldo_awal_buku_besar1] s/d $rows22[saldo_awal_buku_besar2]) and (Mutasi Periode $rows22[mutasi_buku_besar1] s/d $rows22[mutasi_buku_besar2])",'wraptext_top');
$sheet1->cellMerge(1,1,8,0);
$sheet1->cellMerge(2,1,8,0);
$sheet1->cellMerge(3,1,8,0);

$sheet1->writeString(5, 1, 'No','th');$sheet1->cellMerge(5,1,0,1);
$sheet1->writeString(5, 2, 'TANGGAL','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 3, 'REF','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 4, 'NOMOR','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 5, 'KODE','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 6, 'INVOICE FAKTUR','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 7, 'KETERANGAN','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 8, 'DEBIT','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 9, 'KREDIT','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(5, 10, 'SALDO','th'); $sheet1->cellMerge(5,0,1,0);
$sheet1->writeString(6, 2, 'Saldo bulan sebelumnya','th'); $sheet1->cellMerge(6,2,7,0);
$sheet1->writeString(6, 10, $saldo_bulan_sebelumnya,'th'); $sheet1->cellMerge(6,0,1,0);// Nilai Saldo Bulan Sebelumnya



$jurnal=mysql_query("select akuntansiv2_jurnal.*  from akuntansiv2_jurnal
where $akun_all and tanggal between '$rows22[mutasi_buku_besar1]' and '$rows22[mutasi_buku_besar2]'
order by tanggal,kode_posting asc") or die (mysql_error());
$i=7;
$no=1;
$saldo=$saldoawal;
while ($data=mysql_fetch_array($jurnal)){
// inilah perhitungan matematka biasa untuk menghitung saldo disimpan d dalam looping while {}
if ($data[debit]==0) { $saldo=$saldo+$data[debit]-$data[kredit] ;} else
{$saldo=$saldo+$data[debit];}
// SAmpai sinilah perhitungan matematka biasa untuk menghitung saldo
//<td>$no.</td>
$test_nilai_debit=rupiah($data['debit']);
$test_nilai_kredit=rupiah($data['kredit']);
$test_nilai_saldo=rupiah($saldo);

//Ambil Nomor invoice_faktur
$sql214="SELECT invoice_faktur FROM akuntansiv2_posting WHERE ref='$data[ref]'";
$result214= mysql_query($sql214);
$rows214=mysql_fetch_array($result214);

$sheet1->writeString($i, 1, $no);
$sheet1->writeString($i, 2, $data['tanggal']);//nomor
$sheet1->writeString($i, 3, $data['ref']);//tanggal
$sheet1->writeString($i, 4, $data['nomor']);//pemasok
$sheet1->writeString($i, 5, $data['kode_posting']);//pemasok
$sheet1->writeString($i, 6, $rows214['invoice_faktur']);//pemasok
$sheet1->writeString($i, 7, $data['nama']);//NOMOR
$sheet1->writeString($i, 8, $test_nilai_debit);//JENIS
$sheet1->writeString($i, 9, $test_nilai_kredit);//pemasok
$sheet1->writeString($i, 10, $test_nilai_saldo);//pemasok


//mencari nilai total
$jumlahD=$jumlahD+$data[debit];
$jumlahK=$jumlahK+$data[kredit];
$i++;
$no++;}
$sa=$i+1;

$test_total_saldo_debit=rupiah($jumlahD);
$test_total_saldo_kredit=rupiah($jumlahK);
$test_nilai_saldo=rupiah($saldo);

//SALDO AKHIR
$sheet1->writeString($sa, 7, 'JUMLAH','th'); $sheet1->cellMerge($sa,0,7,0);
$sheet1->writeString($sa, 8, $test_total_saldo_debit,'th'); $sheet1->cellMerge($sa,0,1,0);
$sheet1->writeString($sa, 9, $test_total_saldo_kredit,'th'); $sheet1->cellMerge($sa,0,1,0);
$sheet1->writeString($sa, 10, $test_nilai_saldo,'th'); $sheet1->cellMerge($sa,0,1,0);


$xml->sendHeaders();
$xml->writeData();


?>
