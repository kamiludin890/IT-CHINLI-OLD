<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Edit Faktur Masukkan.xls");
?>
<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td style="text-align:center;border:1px solid;">ID jangan dihapus/diubah</td>
            <td style="text-align:center;border:1px solid;">Tanggal</td>
            <td style="text-align:center;border:1px solid;">Pembeli</td>
            <td style="text-align:center;border:1px solid;">NPWP</td>
            <td style="text-align:center;border:1px solid;">Nomor Faktur</td>
            <td style="text-align:center;border:1px solid;">Nomor Invoice</td>
            <td style="text-align:center;border:1px solid;">No Pendaftaran</td>
            <td style="text-align:center;border:1px solid;">No Aju</td>
            <td style="text-align:center;border:1px solid;">Jenis</td>
            <td style="text-align:center;border:1px solid;">Keterangan</td>
            <td style="text-align:center;border:1px solid;">DPP</td>
            <td style="text-align:center;border:1px solid;">PPN</td>
            <td style="text-align:center;border:1px solid;">Dept</td>
            <td style="text-align:center;border:1px solid;">Kashbank(Cash FLow)</td>
            <td style="text-align:center;border:1px solid;">Outstanding</td>
            <td style="text-align:center;border:1px solid;">Amount USD</td>
            <td style="text-align:center;border:1px solid;">Tanggal bayar</td>
            <td style="text-align:center;border:1px solid;">Nomor Voucher</td>
            <td style="text-align:center;border:1px solid;">Tidak Dipungut Biaya DPP</td>
            <td style="text-align:center;border:1px solid;">Tidak Dipungut Biaya PPN</td>
            <td style="text-align:center;border:1px solid;">Dipungut Biaya DPP</td>
            <td style="text-align:center;border:1px solid;">Dipungut Biaya PPN</td>
            <td style="text-align:center;border:1px solid;">Nilai</td>
            <td style="text-align:center;border:1px solid;">Hasil</td>
            <td style="text-align:center;border:1px solid;">Pembelian Bahan Baku Import</td>
            <td style="text-align:center;border:1px solid;">Pembelian Bahan Penolong</td>
        </tr>
    </thead>
    <?php
$host2="localhost:3318";$user2="root";$password2="merdeka170845";$database2="sb_dagang";
$koneksi2=mysql_connect($host2,$user2,$password2);mysql_select_db($database2,$koneksi2);
?>

    <?php
if(!empty($_POST['check_list'])) {
    $k = count($_POST['check_list']);
    foreach($_POST['check_list'] as $check) { 
    $query=mysql_query("SELECT * FROM akuntansiv3_faktur_masukkan WHERE id='$check'"); 
    $row = mysql_fetch_array($query);   
    echo"<tr>
    <td style='border:1px solid;text-align:center;'>$row[id]</td>
    <td style='border:1px solid;text-align:center;'>$row[tanggal]</td>
    <td style='border:1px solid;'>$row[pembeli]</td>
    <td style='border:1px solid;'>'$row[no_npwp]</td>
    <td style='border:1px solid;'>'$row[no_faktur]</td>
    <td style='border:1px solid;'>$row[no_invoice_masukkan]</td>
    <td style='border:1px solid;'>$row[no_pendaftaran]</td>
    <td style='border:1px solid;'>'$row[no_aju]</td>
    <td style='border:1px solid;'>$row[jenis_doc]</td>
    <td style='border:1px solid;'>$row[keterangan]</td>
    <td style='border:1px solid;'>$row[amount_rp]</td>
    <td style='border:1px solid;'>$row[ppn]</td>
    <td style='border:1px solid;'>$row[departement]</td>
    <td style='border:1px solid;'>$row[kasbank_cash_flow]</td>
    <td style='border:1px solid;'>$row[outstanding]</td>
    <td style='border:1px solid;'>$row[ammount_usd]</td>
    <td style='border:1px solid;text-align:center;'>$row[tanggal_bayar]</td>
    <td style='border:1px solid;'>$row[no_voucher]</td>
    <td style='border:1px solid;'>$row[nilai]</td>
    <td style='border:1px solid;'>$row[hasil]</td>
    <td style='border:1px solid;'>$row[tidak_dipungut_dpp]</td>
    <td style='border:1px solid;'>$row[tidak_dipungut_ppn]</td>
    <td style='border:1px solid;'>$row[dipungut_dpp]</td>
    <td style='border:1px solid;'>$row[dipungut_ppn]</td>
    <td style='border:1px solid;'>$row[pembelian_bahan_baku_import]</td>
    <td style='border:1px solid;'>$row[pembelian_bahan_penolong_produksi]</td>
    </tr>";
    }
}
?>
</table>