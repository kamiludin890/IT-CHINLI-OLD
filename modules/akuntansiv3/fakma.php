<?php
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
$idtab = $_GET['id'];
$query = mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE id='$idtab'");
$row = mysql_fetch_array($query);
echo"<div style='align-item:left;'>";
echo"<div  style='background-color:grey;width:80px;text-align:center;border-radius:5%;'><a href='http://192.168.2.16:8098/index.php?menu=home&mod=akuntansiv3/fakturmasukkan_dev' style='color:white;text-decoration:none;'>Kembali</a></div>";
echo"<form method='POST' action='global'> <input type='hidden' name='id' value='$idtab'> ";//action='window.parent.location.reload()' onSubmit='window.close()'
echo"<div style=''><h1>Menu Edit</h1><table>";
echo"
<tr>
<th style='text-align:left;'>Pembeli</th><td>:</td>
<td>$row[pembeli]</td>
</tr>
<tr>
<th style='text-align:left;'>Tanggal</th><td>:</td>
<td><input type='text' name='tanggal' value='$row[tanggal]'></td>
</tr>
<tr>
<th style='text-align:left;'>No Faktur</th><td>:</td>
<td><input type='text' name='nofaktur' value='$row[no_faktur]'></td>
</tr>
</tr>
<tr>
<th style='text-align:left;'>No Invoice</th><td>:</td>
<td><input type='text' name='noinvoice' value='$row[no_invoice_masukkan]'></td>
</tr>
<tr>
<th style='text-align:left;'>Keterangan</th><td>:</td>
<td><input type='text' name='keterangan' value='$row[keterangan]'></td>
</tr>
<tr>
<th style='text-align:left;'>Total Rp</th><td>:</td>
<td><input type='text' name='totalrp' value='$row[amount_rp]'></td>
</tr>
<tr>
<th style='text-align:left;'>PPN</th><td>:</td>
<td><input type='text' name='ppn' value='$row[ppn]'></td>
</tr>
<tr>
<th style='text-align:left;'>Nilai</th><td>:</td>
<td><input type='text' name='nilai' value='$row[nilai]'></td>
</tr>
<tr>
<th style='text-align:left;'>Hasil</th><td>:</td>
<td><input type='text' name='hasil' value='$row[hasil]'></td>
</tr>
<tr>
<th style='text-align:left;'>Kas Bank(Cash Flow)</th><td>:</td>
<td><input type='text' name='kasbank' value='$row[kasbank_cash_flow]'></td>
</tr>
<tr>
<th style='text-align:left;'>Out Standing</th><td>:</td>
<td><input type='text' name='outstanding' value='$row[outstanding]'></td>
</tr>
<tr>
<th style='text-align:left;'>Total USD</th><td>:</td>
<td><input type='text' name='totalusd' value='$row[ammount_usd]'></td>
</tr>
<tr>
<th style='text-align:left;'>Tanggal Bayar</th><td>:</td>
<td><input type='text' name='tanggalbayar' value='$row[tanggal_bayar]'></td>
</tr>
<tr>
<th style='text-align:left;'>No Voucher</th><td>:</td>
<td><input type='text' name='novoucher' value='$row[no_voucher]'></td>
</tr>
<tr>
<th style='text-align:left;'>Tidak dipungut biaya DPP</th><td>:</td>
<td><input type='text' name='tdkdpp' value='$row[tidak_dipungut_dpp]'></td>
</tr>
<tr>
<th style='text-align:left;'>Tidak dipungut biaya PPN</th><td>:</td>
<td><input type='text' name='tdkppn' value='$row[tidak_dipungut_ppn]'></td>
</tr>
<tr>
<th style='text-align:left;'>Dipungut biaya DPP</th><td>:</td>
<td><input type='text' name='dipudpp' value='$row[dipungut_dpp]'></td>
</tr>
<tr>
<th style='text-align:left;'>Dipungut biaya PPN</th><td>:</td>
<td><input type='text' name='dipuppn' value='$row[dipungut_ppn]'></td>
</tr>
<tr>
<th style='text-align:left;'>Pembelian bahan baku import</th><td>:</td>
<td><input type='text' name='pembelianbahan' value='$row[pembelian_bahan_baku_import]'></td>
</tr>
<tr>
<th style='text-align:left;'>Pembelian bahan penolong produksi</th><td>:</td>
<td><input type='text' name='penolongprod' value='$row[pembelian_bahan_penolong_produksi]'></td>
</tr>
";
echo"</table></div>";
echo"<input type='hidden' name='submitbalik' value='kamil'>";
echo"<input type='submit' name='submit' value='Update Data'>";
echo"</form>";
if(isset($_POST['submit'])){
    $idtab = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $nofaktur = $_POST['nofaktur'];
    $noinvoice = $_POST['noinvoice'];
    $keterangan = $_POST['keterangan'];
    $totalrp = $_POST['totalrp'];
    $ppn = $_POST['ppn'];
    $nilai = $_POST['nilai'];
    $hasil = $_POST['hasil'];
    $kasbank = $_POST['kasbank'];
    $outstanding = $_POST['outstanding'];
    $totalusd = $_POST['totalusd'];
    $tglbayar = $_POST['tanggalbayar'];
    $novoucher = $_POST['novoucher'];
    $tdkdpp = $_POST['tdkdpp'];
    $tdkppn = $_POST['tdkppn'];
    $dipudpp = $_POST['dipudpp'];
    $dipuppn = $_POST['dipuppn'];
    $pembelianbahan = $_POST['pembelianbahan'];
    $penolongprod = $_POST['penolongprod'];
    $kamil = $_POST['submitbalik'];
    mysql_query("UPDATE akuntansiv3_faktur_masukkan SET tanggal='$tanggal',no_faktur='$nofaktur',no_invoice_masukkan='$noinvoice',keterangan='$keterangan',amount_rp='$totalrp',ppn='$ppn',nilai='$nilai',hasil='$hasil',kasbank_cash_flow='$kasbank',outstanding='$outstanding',amount_usd='$totalusd',tgl_bayar='$tglbayar',no_voucher='$novoucher',tidak_dipungut_dpp='$tdkdpp' WHERE id='$idtab' ");
    echo"<script>window.location.href=('http://192.168.2.16:8098/index.php?menu=home&mod=akuntansiv3/fakturmasukkan_dev')</script>";
// echo"$idtab tanggal $tanggal no faktur $nofaktur no invoice $noinvoice <br>UPDATE akuntansiv3_faktur_masukkan SET tanggal='$tanggal' WHERE id='$idtab' "; 
}
echo"</div>";

?>