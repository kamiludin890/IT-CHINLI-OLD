<?php global $mod;
	$mod='akuntansiv2/laporanlabarugi';
function editmenu(){extract($GLOBALS);}

function ambil_variabel($nama_database,$kolom) {
	$result1=mysql_query("SELECT $kolom FROM $nama_database");
	while ($rows1=mysql_fetch_array($result1)) {
	$nilai=preg_replace('/"/', ' ', $rows1[$kolom]);
	$datasecs[]="".$nilai."";}
	$data=implode('","', $datasecs);
	$hasil='"'.$data.'"';
return $hasil;}

function jumlahhari($month,$year){
$hai = date('t', mktime(0, 0, 0, $month, 1, $year));
return $hai;}

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
include 'style.css';
$column_header='tanggal,ref,nomor,keterangan,keterangan_posting,debit,kredit,kode_posting,tanggal_input';
//$column='ref,tanggal,tanggal_input,nomor,nama,keterangan,debit,kredit,kode_posting,pembuat,tgl_dibuat';

$nama_database='akuntansiv2_jurnal';
//$nama_database_items='admin_purchasing_items';
$address='?menu=home&mod=akuntansiv2/laporanlabarugi';

if ($_SESSION['bahasa']){$bahasa=$_SESSION['bahasa'];}else{$bahasa='ina';}
$pilihan_tahun=$_POST['pilihan_tahun'];

$tanggal_paling_awal="2019-01-01";
$awal_januari_kurang_satu=date('Y-m-d',strtotime('-1 days', strtotime("$pilihan_tahun-01-01")));

$akhir_januari="$pilihan_tahun-01-".jumlahhari(1,$pilihan_tahun)."";
$akhir_februari="$pilihan_tahun-02-".jumlahhari(2,$pilihan_tahun)."";
$akhir_maret="$pilihan_tahun-03-".jumlahhari(3,$pilihan_tahun)."";
$akhir_april="$pilihan_tahun-04-".jumlahhari(4,$pilihan_tahun)."";
$akhir_mei="$pilihan_tahun-05-".jumlahhari(5,$pilihan_tahun)."";
$akhir_juni="$pilihan_tahun-06-".jumlahhari(6,$pilihan_tahun)."";
$akhir_juli="$pilihan_tahun-07-".jumlahhari(7,$pilihan_tahun)."";
$akhir_agustus="$pilihan_tahun-08-".jumlahhari(8,$pilihan_tahun)."";
$akhir_september="$pilihan_tahun-09-".jumlahhari(9,$pilihan_tahun)."";
$akhir_oktober="$pilihan_tahun-10-".jumlahhari(10,$pilihan_tahun)."";
$akhir_november="$pilihan_tahun-11-".jumlahhari(11,$pilihan_tahun)."";
$akhir_desember="$pilihan_tahun-12-".jumlahhari(12,$pilihan_tahun)."";



//HEADER
echo "<h2 style='color:red;'>PT. CHINLI PLASTIC TECHNOLOGY INDONESIA</h2>";
echo "<h3>Profit & Loss Statement</h3>";
//HEADER END

//TAHUN
echo "<table>";
echo "<form method='POST'>";
echo "<tr>";
	echo "<td>Tahun</td>";
	echo "<td>:</td>";
		echo "
		<td><select name='pilihan_tahun'>";
		echo "<option value='$pilihan_tahun'>$pilihan_tahun</option>";
		$now=date('Y')+3;
		for ($a=date('Y')-3;$a<=$now;$a++)
		 {echo "<option value='".$a."'>".$a."</option>";}
		 echo "</select></td>";
echo "<td><input type='submit' name='submit' value='Show'></td>";
echo "</tr>";
echo "</form>";
echo "</table>";
//TAHUN END
if ($pilihan_tahun) {


//MULAI TABLE
echo "<table style='width:100%; background-color:white;'>";

//HEADER BULAN
echo "<thead style='font-weight:bold; text-align:center;  white-space:nowrap; height:30px;'>";
	echo "<th colspan=2></th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(1,$pilihan_tahun)."-Jan-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(2,$pilihan_tahun)."-Feb-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(3,$pilihan_tahun)."-Mar-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(4,$pilihan_tahun)."-Apr-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(5,$pilihan_tahun)."-Mei-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(6,$pilihan_tahun)."-Jun-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(7,$pilihan_tahun)."-Jul-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(8,$pilihan_tahun)."-Agust-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(9,$pilihan_tahun)."-Sept-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(10,$pilihan_tahun)."-Okt-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(11,$pilihan_tahun)."-Nov-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(12,$pilihan_tahun)."-Des-$pilihan_tahun</th>";
	echo "<th style='border-bottom:1px solid; border-top:1px solid;'>Tahun $pilihan_tahun</th>";
echo "</thead>";
//HEADER BULAN END



//---------------------------------------------------------------------------------------------------------------------------------------------------------------------



//TAMPILAN Total Pendapatan
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2></td>";
echo "</tr>";

			$pembeda_laba_rugi='Total Pendapatan';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
				$lima_digit_pertama=substr($rows[nomor],0,5);

				//RUMUS PENJUMLAHAN
				$result2=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor LIKE '$lima_digit_pertama%' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows2=mysql_fetch_array($result2);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$rows2[januari]+$rows2[februari]+$rows2[maret]+$rows2[april]+$rows2[mei]+$rows2[juni]+$rows2[juli]+$rows2[agustus]+$rows2[september]+$rows2[oktober]+$rows2[november]+$rows2[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir2)."</td>";

				//GRAND TOTAL
				$total_januari=$rows2[januari]+$total_januari;
				$total_februari=$rows2[februari]+$total_februari;
				$total_maret=$rows2[maret]+$total_maret;
				$total_april=$rows2[april]+$total_april;
				$total_mei=$rows2[mei]+$total_mei;
				$total_juni=$rows2[juni]+$total_juni;
				$total_juli=$rows2[juli]+$total_juli;
				$total_agustus=$rows2[agustus]+$total_agustus;
				$total_september=$rows2[september]+$total_september;
				$total_oktober=$rows2[oktober]+$total_oktober;
				$total_november=$rows2[november]+$total_november;
				$total_desember=$rows2[desember]+$total_desember;
				//GRAND TOTAL END
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_januari)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_februari)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_maret)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_april)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_mei)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juni)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juli)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_agustus)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_september)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_oktober)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_november)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_desember)."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir=$total_januari+$total_februari+$total_maret+$total_april+$total_mei+$total_juni+$total_juli+$total_agustus+$total_september+$total_oktober+$total_november+$total_desember;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_akhir)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total Pendapatan END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------



//TAMPILAN Total Biaya Langsung
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2>HARGA POKOK PENJUALAN</td>";
echo "</tr>";

			$pembeda_laba_rugi='Total Biaya Langsung';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
				$lima_digit_pertama=substr($rows[nomor],0,5);

				//RUMUS PENJUMLAHAN
				$result2=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor LIKE '$lima_digit_pertama%' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows2=mysql_fetch_array($result2);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$rows2[januari]+$rows2[februari]+$rows2[maret]+$rows2[april]+$rows2[mei]+$rows2[juni]+$rows2[juli]+$rows2[agustus]+$rows2[september]+$rows2[oktober]+$rows2[november]+$rows2[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir2)."</td>";

				//GRAND TOTAL
				$total_januari1=$rows2[januari]+$total_januari1;
				$total_februari1=$rows2[februari]+$total_februari1;
				$total_maret1=$rows2[maret]+$total_maret1;
				$total_april1=$rows2[april]+$total_april1;
				$total_mei1=$rows2[mei]+$total_mei1;
				$total_juni1=$rows2[juni]+$total_juni1;
				$total_juli1=$rows2[juli]+$total_juli1;
				$total_agustus1=$rows2[agustus]+$total_agustus1;
				$total_september1=$rows2[september]+$total_september1;
				$total_oktober1=$rows2[oktober]+$total_oktober1;
				$total_november1=$rows2[november]+$total_november1;
				$total_desember1=$rows2[desember]+$total_desember1;
				//GRAND TOTAL END
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_januari1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_februari1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_maret1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_april1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_mei1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juni1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juli1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_agustus1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_september1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_oktober1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_november1)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_desember1)."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$total_januari1+$total_februari1+$total_maret1+$total_april1+$total_mei1+$total_juni1+$total_juli1+$total_agustus1+$total_september1+$total_oktober1+$total_november1+$total_desember1;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_akhir1)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total Biaya Langsung END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------



//TAMPILAN Total Biaya Tidak Langsung
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2></td>";
echo "</tr>";

			$pembeda_laba_rugi='Total Biaya Tidak Langsung';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
				$lima_digit_pertama=substr($rows[nomor],0,5);

				//RUMUS PENJUMLAHAN
				$result2=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor LIKE '$lima_digit_pertama%' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows2=mysql_fetch_array($result2);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$rows2[januari]+$rows2[februari]+$rows2[maret]+$rows2[april]+$rows2[mei]+$rows2[juni]+$rows2[juli]+$rows2[agustus]+$rows2[september]+$rows2[oktober]+$rows2[november]+$rows2[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir2)."</td>";

				//GRAND TOTAL
				$total_januari2=$rows2[januari]+$total_januari2;
				$total_februari2=$rows2[februari]+$total_februari2;
				$total_maret2=$rows2[maret]+$total_maret2;
				$total_april2=$rows2[april]+$total_april2;
				$total_mei2=$rows2[mei]+$total_mei2;
				$total_juni2=$rows2[juni]+$total_juni2;
				$total_juli2=$rows2[juli]+$total_juli2;
				$total_agustus2=$rows2[agustus]+$total_agustus2;
				$total_september2=$rows2[september]+$total_september2;
				$total_oktober2=$rows2[oktober]+$total_oktober2;
				$total_november2=$rows2[november]+$total_november2;
				$total_desember2=$rows2[desember]+$total_desember2;
				//GRAND TOTAL END
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_januari2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_februari2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_maret2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_april2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_mei2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juni2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juli2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_agustus2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_september2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_oktober2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_november2)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_desember2)."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$total_januari2+$total_februari2+$total_maret2+$total_april2+$total_mei2+$total_juni2+$total_juli2+$total_agustus2+$total_september2+$total_oktober2+$total_november2+$total_desember2;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_akhir2)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total Biaya Tidak Langsung END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "<tr style='height:15px;'><td></td></tr>";
//TOTAL HARGA POKOK PENJUALAN
$grand_total_aset_januari=$total_januari1+$total_januari2;
$grand_total_aset_februari=$total_februari1+$total_februari2;
$grand_total_aset_maret=$total_maret1+$total_maret2;
$grand_total_aset_april=$total_april1+$total_april2;
$grand_total_aset_mei=$total_mei1+$total_mei2;
$grand_total_aset_juni=$total_juni1+$total_juni2;
$grand_total_aset_juli=$total_juli1+$total_juli2;
$grand_total_aset_agustus=$total_agustus1+$total_agustus2;
$grand_total_aset_september=$total_september1+$total_september2;
$grand_total_aset_oktober=$total_oktober1+$total_oktober2;
$grand_total_aset_november=$total_november1+$total_november2;
$grand_total_aset_desember=$total_desember1+$total_desember2;

echo "<tr style='font-weight:bold; white-space:nowrap; color:red;'>";
	echo "<td></td>";
	echo "<td style='border-bottom-style:double; border-top:1px solid;'>Total Harga Pokok Penjualan</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_januari)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_februari)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_maret)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_april)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_mei)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juni)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juli)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_agustus)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_september)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_oktober)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_november)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_desember)."</td>";

	//GRAND TOTAL AKHIR
	$grand_total_aset_akhir=$grand_total_aset_januari+$grand_total_aset_februari+$grand_total_aset_maret+$grand_total_aset_april+$grand_total_aset_mei+$grand_total_aset_juni+$grand_total_aset_juli+$grand_total_aset_agustus+$grand_total_aset_september+$grand_total_aset_oktober+$grand_total_aset_november+$grand_total_aset_desember;
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir)."</td>";

echo "</tr>";
//TOTAL HARGA POKOK PENJUALAN END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "<tr style='height:15px;'><td></td></tr>";
//TOTAL LABA KOTOR
$grand_total_aset_januari1=$total_januari-$grand_total_aset_januari;
$grand_total_aset_februari1=$total_februari-$grand_total_aset_februari;
$grand_total_aset_maret1=$total_maret-$grand_total_aset_maret;
$grand_total_aset_april1=$total_april-$grand_total_aset_april;
$grand_total_aset_mei1=$total_mei-$grand_total_aset_mei;
$grand_total_aset_juni1=$total_juni-$grand_total_aset_juni;
$grand_total_aset_juli1=$total_juli-$grand_total_aset_juli;
$grand_total_aset_agustus1=$total_agustus-$grand_total_aset_agustus;
$grand_total_aset_september1=$total_september-$grand_total_aset_september;
$grand_total_aset_oktober1=$total_oktober-$grand_total_aset_oktober;
$grand_total_aset_november1=$total_november-$grand_total_aset_november;
$grand_total_aset_desember1=$total_desember-$grand_total_aset_desember;

echo "<tr style='font-weight:bold; white-space:nowrap; color:red;'>";
	echo "<td></td>";
	echo "<td style='border-bottom-style:double; border-top:1px solid;'>Laba Kotor</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_januari1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_februari1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_maret1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_april1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_mei1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juni1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juli1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_agustus1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_september1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_oktober1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_november1)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_desember1)."</td>";

	//GRAND TOTAL AKHIR
	$grand_total_aset_akhir1=$grand_total_aset_januari1+$grand_total_aset_februari1+$grand_total_aset_maret1+$grand_total_aset_april1+$grand_total_aset_mei1+$grand_total_aset_juni1+$grand_total_aset_juli1+$grand_total_aset_agustus1+$grand_total_aset_september1+$grand_total_aset_oktober1+$grand_total_aset_november1+$grand_total_aset_desember1;
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir1)."</td>";

echo "</tr>";
//TOTAL  LABA KOTOR END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------



//TAMPILAN Total Biaya Operasional
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2></td>";
echo "</tr>";

			$pembeda_laba_rugi='Total Biaya Operasional';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
				$lima_digit_pertama=substr($rows[nomor],0,5);

				//RUMUS PENJUMLAHAN
				$result2=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor LIKE '$lima_digit_pertama%' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows2=mysql_fetch_array($result2);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$rows2[januari]+$rows2[februari]+$rows2[maret]+$rows2[april]+$rows2[mei]+$rows2[juni]+$rows2[juli]+$rows2[agustus]+$rows2[september]+$rows2[oktober]+$rows2[november]+$rows2[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir2)."</td>";

				//GRAND TOTAL
				$total_januari3=$rows2[januari]+$total_januari3;
				$total_februari3=$rows2[februari]+$total_februari3;
				$total_maret3=$rows2[maret]+$total_maret3;
				$total_april3=$rows2[april]+$total_april3;
				$total_mei3=$rows2[mei]+$total_mei3;
				$total_juni3=$rows2[juni]+$total_juni3;
				$total_juli3=$rows2[juli]+$total_juli3;
				$total_agustus3=$rows2[agustus]+$total_agustus3;
				$total_september3=$rows2[september]+$total_september3;
				$total_oktober3=$rows2[oktober]+$total_oktober3;
				$total_november3=$rows2[november]+$total_november3;
				$total_desember3=$rows2[desember]+$total_desember3;
				//GRAND TOTAL END
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_januari3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_februari3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_maret3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_april3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_mei3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juni3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juli3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_agustus3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_september3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_oktober3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_november3)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_desember3)."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir3=$total_januari3+$total_februari3+$total_maret3+$total_april3+$total_mei3+$total_juni3+$total_juli3+$total_agustus3+$total_september3+$total_oktober3+$total_november3+$total_desember3;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_akhir3)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total Biaya Operasional END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------



//TAMPILAN Total Biaya Umum Dan Administrasi
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2>Biaya Umum dan Administrasi</td>";
echo "</tr>";

			$pembeda_laba_rugi='Total Biaya Umum dan Administrasi';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
				$lima_digit_pertama=substr($rows[nomor],0,5);

				//RUMUS PENJUMLAHAN
				$result2=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor LIKE '$lima_digit_pertama%' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows2=mysql_fetch_array($result2);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$rows2[januari]+$rows2[februari]+$rows2[maret]+$rows2[april]+$rows2[mei]+$rows2[juni]+$rows2[juli]+$rows2[agustus]+$rows2[september]+$rows2[oktober]+$rows2[november]+$rows2[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir2)."</td>";

				//GRAND TOTAL
				$total_januari4=$rows2[januari]+$total_januari4;
				$total_februari4=$rows2[februari]+$total_februari4;
				$total_maret4=$rows2[maret]+$total_maret4;
				$total_april4=$rows2[april]+$total_april4;
				$total_mei4=$rows2[mei]+$total_mei4;
				$total_juni4=$rows2[juni]+$total_juni4;
				$total_juli4=$rows2[juli]+$total_juli4;
				$total_agustus4=$rows2[agustus]+$total_agustus4;
				$total_september4=$rows2[september]+$total_september4;
				$total_oktober4=$rows2[oktober]+$total_oktober4;
				$total_november4=$rows2[november]+$total_november4;
				$total_desember4=$rows2[desember]+$total_desember4;
				//GRAND TOTAL END
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_januari4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_februari4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_maret4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_april4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_mei4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juni4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juli4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_agustus4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_september4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_oktober4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_november4)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_desember4)."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir4=$total_januari4+$total_februari4+$total_maret4+$total_april4+$total_mei4+$total_juni4+$total_juli4+$total_agustus4+$total_september4+$total_oktober4+$total_november4+$total_desember4;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_akhir4)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total Biaya Umum Dan Administrasi END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "<tr style='height:15px;'><td></td></tr>";
//Total Biaya Operasional
$grand_total_aset_januari2=$total_januari3+$total_januari4;
$grand_total_aset_februari2=$total_februari3+$total_februari4;
$grand_total_aset_maret2=$total_maret3+$total_maret4;
$grand_total_aset_april2=$total_april3+$total_april4;
$grand_total_aset_mei2=$total_mei3+$total_mei4;
$grand_total_aset_juni2=$total_juni3+$total_juni4;
$grand_total_aset_juli2=$total_juli3+$total_juli4;
$grand_total_aset_agustus2=$total_agustus3+$total_agustus4;
$grand_total_aset_september2=$total_september3+$total_september4;
$grand_total_aset_oktober2=$total_oktober3+$total_oktober4;
$grand_total_aset_november2=$total_november3+$total_november4;
$grand_total_aset_desember2=$total_desember3+$total_desember4;

echo "<tr style='font-weight:bold; white-space:nowrap; color:red;'>";
	echo "<td></td>";
	echo "<td style='border-bottom-style:double; border-top:1px solid;'>Total Biaya Operasional </td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_januari2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_februari2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_maret2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_april2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_mei2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juni2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juli2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_agustus2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_september2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_oktober2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_november2)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_desember2)."</td>";

	//GRAND TOTAL AKHIR
	$grand_total_aset_akhir2=$grand_total_aset_januari2+$grand_total_aset_februari2+$grand_total_aset_maret2+$grand_total_aset_april2+$grand_total_aset_mei2+$grand_total_aset_juni2+$grand_total_aset_juli2+$grand_total_aset_agustus2+$grand_total_aset_september2+$grand_total_aset_oktober2+$grand_total_aset_november2+$grand_total_aset_desember2;
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir2)."</td>";
echo "</tr>";
//Total Biaya Operasional END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "<tr style='height:15px;'><td></td></tr>";
//Laba Setelah Operasional
$grand_total_aset_januari3=$grand_total_aset_januari1-$grand_total_aset_januari2;
$grand_total_aset_februari3=$grand_total_aset_februari1-$grand_total_aset_februari2;
$grand_total_aset_maret3=$grand_total_aset_maret1-$grand_total_aset_maret2;
$grand_total_aset_april3=$grand_total_aset_april1-$grand_total_aset_april2;
$grand_total_aset_mei3=$grand_total_aset_mei1-$grand_total_aset_mei2;
$grand_total_aset_juni3=$grand_total_aset_juni1-$grand_total_aset_juni2;
$grand_total_aset_juli3=$grand_total_aset_juli1-$grand_total_aset_juli2;
$grand_total_aset_agustus3=$grand_total_aset_agustus1-$grand_total_aset_agustus2;
$grand_total_aset_september3=$grand_total_aset_september1-$grand_total_aset_september2;
$grand_total_aset_oktober3=$grand_total_aset_oktober1-$grand_total_aset_oktober2;
$grand_total_aset_november3=$grand_total_aset_november1-$grand_total_aset_november2;
$grand_total_aset_desember3=$grand_total_aset_desember1-$grand_total_aset_desember2;

echo "<tr style='font-weight:bold; white-space:nowrap; color:red;'>";
	echo "<td></td>";
	echo "<td style='border-bottom-style:double; border-top:1px solid;'>Laba Setelah Operasional</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_januari3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_februari3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_maret3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_april3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_mei3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juni3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juli3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_agustus3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_september3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_oktober3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_november3)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_desember3)."</td>";

	//GRAND TOTAL AKHIR
	$grand_total_aset_akhir3=$grand_total_aset_januari3+$grand_total_aset_februari3+$grand_total_aset_maret3+$grand_total_aset_april3+$grand_total_aset_mei3+$grand_total_aset_juni3+$grand_total_aset_juli3+$grand_total_aset_agustus3+$grand_total_aset_september3+$grand_total_aset_oktober3+$grand_total_aset_november3+$grand_total_aset_desember3;
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir3)."</td>";

echo "</tr>";
//Laba Setelah Operasional END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------



//TAMPILAN Total PENDAPATAN LAINNYA
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2>PENDAPATAN LAINNYA</td>";
echo "</tr>";

			$pembeda_laba_rugi='Total PENDAPATAN LAINNYA';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
				$lima_digit_pertama=substr($rows[nomor],0,5);

				//RUMUS PENJUMLAHAN
				$result2=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor LIKE '$lima_digit_pertama%' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows2=mysql_fetch_array($result2);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$rows2[januari]+$rows2[februari]+$rows2[maret]+$rows2[april]+$rows2[mei]+$rows2[juni]+$rows2[juli]+$rows2[agustus]+$rows2[september]+$rows2[oktober]+$rows2[november]+$rows2[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir2)."</td>";

				//GRAND TOTAL
				$total_januari5=$rows2[januari]+$total_januari5;
				$total_februari5=$rows2[februari]+$total_februari5;
				$total_maret5=$rows2[maret]+$total_maret5;
				$total_april5=$rows2[april]+$total_april5;
				$total_mei5=$rows2[mei]+$total_mei5;
				$total_juni5=$rows2[juni]+$total_juni5;
				$total_juli5=$rows2[juli]+$total_juli5;
				$total_agustus5=$rows2[agustus]+$total_agustus5;
				$total_september5=$rows2[september]+$total_september5;
				$total_oktober5=$rows2[oktober]+$total_oktober5;
				$total_november5=$rows2[november]+$total_november5;
				$total_desember5=$rows2[desember]+$total_desember5;
				//GRAND TOTAL END
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_januari5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_februari5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_maret5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_april5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_mei5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juni5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juli5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_agustus5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_september5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_oktober5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_november5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_desember5)."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir5=$total_januari5+$total_februari5+$total_maret5+$total_april5+$total_mei5+$total_juni5+$total_juli5+$total_agustus5+$total_september5+$total_oktober5+$total_november5+$total_desember5;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_akhir5)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total PENDAPATAN LAINNYA END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


//TAMPILAN Total BIAYA LAINNYA
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2>BIAYA LAINNYA</td>";
echo "</tr>";

			$pembeda_laba_rugi='Total BIAYA LAINNYA';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
				$lima_digit_pertama=substr($rows[nomor],0,5);

				//RUMUS PENJUMLAHAN
				$result2=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor LIKE '$lima_digit_pertama%' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows2=mysql_fetch_array($result2);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows2[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir2=$rows2[januari]+$rows2[februari]+$rows2[maret]+$rows2[april]+$rows2[mei]+$rows2[juni]+$rows2[juli]+$rows2[agustus]+$rows2[september]+$rows2[oktober]+$rows2[november]+$rows2[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir2)."</td>";

				//GRAND TOTAL
				$total_januari7=$rows2[januari]+$total_januari7;
				$total_februari7=$rows2[februari]+$total_februari7;
				$total_maret7=$rows2[maret]+$total_maret7;
				$total_april7=$rows2[april]+$total_april7;
				$total_mei7=$rows2[mei]+$total_mei7;
				$total_juni7=$rows2[juni]+$total_juni7;
				$total_juli7=$rows2[juli]+$total_juli7;
				$total_agustus7=$rows2[agustus]+$total_agustus7;
				$total_september7=$rows2[september]+$total_september7;
				$total_oktober7=$rows2[oktober]+$total_oktober7;
				$total_november7=$rows2[november]+$total_november7;
				$total_desember7=$rows2[desember]+$total_desember7;
				//GRAND TOTAL END
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_januari7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_februari7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_maret7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_april7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_mei7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juni7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_juli7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_agustus7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_september7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_oktober7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_november7)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_desember7)."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir7=$total_januari7+$total_februari7+$total_maret7+$total_april7+$total_mei7+$total_juni7+$total_juli7+$total_agustus7+$total_september7+$total_oktober7+$total_november7+$total_desember7;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($total_akhir7)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total BIAYA LAINNYA END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "<tr style='height:15px;'><td></td></tr>";
//Laba Sebelum Pajak Penghasilan
$grand_total_aset_januari4=$grand_total_aset_januari3+$total_januari5+$total_januari7;
$grand_total_aset_februari4=$grand_total_aset_februari3+$total_februari5+$total_februari7;
$grand_total_aset_maret4=$grand_total_aset_maret3+$total_maret5+$total_maret7;
$grand_total_aset_april4=$grand_total_aset_april3+$total_april5+$total_april7;
$grand_total_aset_mei4=$grand_total_aset_mei3+$total_mei5+$total_mei7;
$grand_total_aset_juni4=$grand_total_aset_juni3+$total_juni5+$total_juni7;
$grand_total_aset_juli4=$grand_total_aset_juli3+$total_juli5+$total_juli7;
$grand_total_aset_agustus4=$grand_total_aset_agustus3+$total_agustus5+$total_agustus7;
$grand_total_aset_september4=$grand_total_aset_september3+$total_september5+$total_september7;
$grand_total_aset_oktober4=$grand_total_aset_oktober3+$total_oktober5+$total_oktober7;
$grand_total_aset_november4=$grand_total_aset_november3+$total_november5+$total_november7;
$grand_total_aset_desember4=$grand_total_aset_desember3+$total_desember5+$total_desember7;

echo "<tr style='font-weight:bold; white-space:nowrap; color:red;'>";
	echo "<td></td>";
	echo "<td style='border-bottom-style:double; border-top:1px solid;'>Laba Sebelum Pajak Penghasilan</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_januari4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_februari4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_maret4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_april4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_mei4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juni4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juli4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_agustus4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_september4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_oktober4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_november4)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_desember4)."</td>";

	//GRAND TOTAL AKHIR
  $grand_total_aset_akhir4=$grand_total_aset_januari4+$grand_total_aset_februari4+$grand_total_aset_maret4+$grand_total_aset_april4+$grand_total_aset_mei4+$grand_total_aset_juni4+$grand_total_aset_juli4+$grand_total_aset_agustus4+$grand_total_aset_september4+$grand_total_aset_oktober4+$grand_total_aset_november4+$grand_total_aset_desember4;
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir4)."</td>";

echo "</tr>";
//Laba Sebelum Pajak Penghasilan END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------



//TAMPILAN Laba Setelah Pajak Penghasilan
echo "<tr style='font-weight:bold;'>";
echo "<td></td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2></td>";
echo "</tr>";

			$pembeda_laba_rugi='Laba Setelah Pajak Penghasilan';
			$result=mysql_query("SELECT nomor,nama,master FROM akuntansiv2_akun WHERE pembeda_laba_rugi='$pembeda_laba_rugi' ORDER BY nomor");
			while ($rows=mysql_fetch_array($result)) {
			echo "<tr style='white-space:nowrap;'>";
			//IF TAMPILAN MASTER
			if ($rows[master]=='ya'){$tampilan_bold="font-weight:bold;"; $tampilan_border="border-bottom:1px solid; border-top:1px solid;";}else{$tampilan_bold=""; $tampilan_border="";}
			//IF TAMPILAN MASTER END

				//NOMOR NAMA
				echo "<td style='$tampilan_bold'>$rows[nomor]</td>";
				echo "<td style='$tampilan_bold'>$rows[nama]</td>";
				//NOMOR NAMA END

			//TAMPILAN MASTER
			if ($rows[master]=='ya'){
			}////TAMPILAN MASTER END


			//TAMPILAN BUKAN MASTER
			else{
				//RUMUS PENJUMLAHAN
				$result1=mysql_query("SELECT
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$awal_januari_kurang_satu', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-01-01' AND '$akhir_januari', kredit, 0)) as januari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_januari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-02-01' AND '$akhir_februari', kredit, 0)) as februari,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_februari', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-03-01' AND '$akhir_maret', kredit, 0)) as maret,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_maret', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-04-01' AND '$akhir_april', kredit, 0)) as april,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_april', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-05-01' AND '$akhir_mei', kredit, 0)) as mei,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_mei', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-06-01' AND '$akhir_juni', kredit, 0)) as juni,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juni', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-07-01' AND '$akhir_juli', kredit, 0)) as juli,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_juli', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-08-01' AND '$akhir_agustus', kredit, 0)) as agustus,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_agustus', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-09-01' AND '$akhir_september', kredit, 0)) as september,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_september', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-10-01' AND '$akhir_oktober', kredit, 0)) as oktober,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_oktober', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-11-01' AND '$akhir_november', kredit, 0)) as november,
					SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', debit, 0)) - SUM(IF(tanggal BETWEEN '$tanggal_paling_awal' AND '$akhir_november', kredit, 0)) + SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', debit, 0)) - SUM(IF(tanggal BETWEEN '$pilihan_tahun-12-01' AND '$akhir_desember', kredit, 0)) as desember
					FROM akuntansiv2_jurnal where nomor='$rows[nomor]' AND pembeda_laba_rugi='$pembeda_laba_rugi'");
				$rows1=mysql_fetch_array($result1);
				//RUMUS PENJUMLAHAN END

				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[januari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[februari])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[maret])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[april])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[mei])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juni])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[juli])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[agustus])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[september])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[oktober])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[november])."</td>";
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($rows1[desember])."</td>";

				//TOTAL AKHIR KANAN
				$total_akhir1=$rows1[januari]+$rows1[februari]+$rows1[maret]+$rows1[april]+$rows1[mei]+$rows1[juni]+$rows1[juli]+$rows1[agustus]+$rows1[september]+$rows1[oktober]+$rows1[november]+$rows1[desember];
				echo "<td style='text-align:right; $tampilan_bold $tampilan_border'>".rupiah($total_akhir1)."</td>";

				$total_januari6=$rows1[januari]+$total_januari6;
				$total_februari6=$rows1[februari]+$total_februari6;
				$total_maret6=$rows1[maret]+$total_maret6;
				$total_april6=$rows1[april]+$total_april6;
				$total_mei6=$rows1[mei]+$total_mei6;
				$total_juni6=$rows1[juni]+$total_juni6;
				$total_juli6=$rows1[juli]+$total_juli6;
				$total_agustus6=$rows1[agustus]+$total_agustus6;
				$total_september6=$rows1[september]+$total_september6;
				$total_oktober6=$rows1[oktober]+$total_oktober6;
				$total_november6=$rows1[november]+$total_november6;
				$total_desember6=$rows1[desember]+$total_desember6;
			}////TAMPILAN BUKAN MASTER END
			echo "</tr>";
			}

			//TOTAL
			$grand_total_aset_januari5=$grand_total_aset_januari4-$total_januari6;
			$grand_total_aset_februari5=$grand_total_aset_februari4-$total_februari6;
			$grand_total_aset_maret5=$grand_total_aset_maret4-$total_maret6;
			$grand_total_aset_april5=$grand_total_aset_april4-$total_april6;
			$grand_total_aset_mei5=$grand_total_aset_mei4-$total_mei6;
			$grand_total_aset_juni5=$grand_total_aset_juni4-$total_juni6;
			$grand_total_aset_juli5=$grand_total_aset_juli4-$total_juli6;
			$grand_total_aset_agustus5=$grand_total_aset_agustus4-$total_agustus6;
			$grand_total_aset_september5=$grand_total_aset_september4-$total_september6;
			$grand_total_aset_oktober5=$grand_total_aset_oktober4-$total_oktober6;
			$grand_total_aset_november5=$grand_total_aset_november4-$total_november6;
			$grand_total_aset_desember5=$grand_total_aset_desember4-$total_desember6;

			echo "<tr style='font-weight:bold; white-space:nowrap;'>";
				echo "<td></td>";
				echo "<td style='border-bottom-style:double; border-top:1px solid;'>$pembeda_laba_rugi</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_januari5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_februari5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_maret5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_april5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_mei5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juni5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juli5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_agustus5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_september5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_oktober5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_november5)."</td>";
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_desember5)."</td>";

				//TOTAL AKHIR KANAN
				$grand_total_aset_akhir5=$grand_total_aset_januari5+$grand_total_aset_februari5+$grand_total_aset_maret5+$grand_total_aset_april5+$grand_total_aset_mei5+$grand_total_aset_juni5+$grand_total_aset_juli5+$grand_total_aset_agustus5+$grand_total_aset_september5+$grand_total_aset_oktober5+$grand_total_aset_november5+$grand_total_aset_desember5;
				echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir5)."</td>";

			echo "</tr>";
			//TOTAL END
	//TAMPILAN Total Laba Setelah Pajak Penghasilan END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


//Laba  PER 31 DESEMBER
echo "<tr style='height:15px;'><td></td></tr>";
$pilihan_tahun_kurang_satu=$pilihan_tahun-1;
echo "<tr style='font-weight:bold; white-space:nowrap; color:red;'>";
	echo "<td></td>";
	echo "<td style='border-bottom-style:double; border-top:1px solid;'>Laba PER 31 DESEMBER $pilihan_tahun_kurang_satu</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_januari5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_februari5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_maret5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_april5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_mei5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juni5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_juli5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_agustus5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_september5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_oktober5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_november5)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_desember5)."</td>";

	//TOTAL AKHIR KANAN
	$grand_total_aset_akhir5=$grand_total_aset_januari5+$grand_total_aset_februari5+$grand_total_aset_maret5+$grand_total_aset_april5+$grand_total_aset_mei5+$grand_total_aset_juni5+$grand_total_aset_juli5+$grand_total_aset_agustus5+$grand_total_aset_september5+$grand_total_aset_oktober5+$grand_total_aset_november5+$grand_total_aset_desember5;
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir5)."</td>";

echo "</tr>";
////Laba  PER 31 DESEMBER  END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "<tr style='height:25px;'><td></td></tr>";

echo "<tr style='font-weight:bold;'>";
echo "<td colspan=4>PT. CHINLI PLASTIC MATERIALS INDONESIA</td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2>Profit & Loss Statement</td>";
echo "</tr>";
echo "<tr style='font-weight:bold; white-space:nowrap;'>";
echo "<td colspan=2>Tahun $pilihan_tahun</td>";
echo "</tr>";

//HEADER BULAN
echo "<tr style='font-weight:bold; text-align:center;  white-space:nowrap;'>";
	echo "<td colspan=2></td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(1,$pilihan_tahun)."-Jan-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(2,$pilihan_tahun)."-Feb-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(3,$pilihan_tahun)."-Mar-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(4,$pilihan_tahun)."-Apr-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(5,$pilihan_tahun)."-Mei-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(6,$pilihan_tahun)."-Jun-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(7,$pilihan_tahun)."-Jul-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(8,$pilihan_tahun)."-Agust-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(9,$pilihan_tahun)."-Sept-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(10,$pilihan_tahun)."-Okt-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(11,$pilihan_tahun)."-Nov-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>".jumlahhari(12,$pilihan_tahun)."-Des-$pilihan_tahun</td>";
	echo "<td style='border-bottom:1px solid; border-top:1px solid;'>Tahun $pilihan_tahun</td>";
echo "</tr>";
//HEADER BULAN END


//Laba Di Tahan Di Akhir Bulan
$laba_ditahan_akhir_bulan_saldo_awal=0;
$laba_ditahan_akhir_bulan_januari=$laba_ditahan_akhir_bulan_saldo_awal+$grand_total_aset_januari5;
$laba_ditahan_akhir_bulan_februari=$laba_ditahan_akhir_bulan_januari+$grand_total_aset_februari5;
$laba_ditahan_akhir_bulan_maret=$laba_ditahan_akhir_bulan_februari+$grand_total_aset_maret5;
$laba_ditahan_akhir_bulan_april=$laba_ditahan_akhir_bulan_maret+$grand_total_aset_april5;
$laba_ditahan_akhir_bulan_mei=$laba_ditahan_akhir_bulan_april+$grand_total_aset_mei5;
$laba_ditahan_akhir_bulan_juni=$laba_ditahan_akhir_bulan_mei+$grand_total_aset_juni5;
$laba_ditahan_akhir_bulan_juli=$laba_ditahan_akhir_bulan_juni+$grand_total_aset_juli5;
$laba_ditahan_akhir_bulan_agustus=$laba_ditahan_akhir_bulan_juli+$grand_total_aset_agustus5;
$laba_ditahan_akhir_bulan_september=$laba_ditahan_akhir_bulan_agustus+$grand_total_aset_september5;
$laba_ditahan_akhir_bulan_oktober=$laba_ditahan_akhir_bulan_september+$grand_total_aset_oktober5;
$laba_ditahan_akhir_bulan_november=$laba_ditahan_akhir_bulan_oktober+$grand_total_aset_november5;
$laba_ditahan_akhir_bulan_desember=$laba_ditahan_akhir_bulan_november+$grand_total_aset_desember5;

//Laba Di Tahan di Awal Bulan
$laba_ditahan_awal_bulan_januari=$laba_ditahan_akhir_bulan_saldo_awal;
$laba_ditahan_awal_bulan_februari=$laba_ditahan_akhir_bulan_januari;
$laba_ditahan_awal_bulan_maret=$laba_ditahan_akhir_bulan_februari;
$laba_ditahan_awal_bulan_april=$laba_ditahan_akhir_bulan_maret;
$laba_ditahan_awal_bulan_mei=$laba_ditahan_akhir_bulan_april;
$laba_ditahan_awal_bulan_juni=$laba_ditahan_akhir_bulan_mei;
$laba_ditahan_awal_bulan_juli=$laba_ditahan_akhir_bulan_juni;
$laba_ditahan_awal_bulan_agustus=$laba_ditahan_akhir_bulan_juli;
$laba_ditahan_awal_bulan_september=$laba_ditahan_akhir_bulan_agustus;
$laba_ditahan_awal_bulan_oktober=$laba_ditahan_akhir_bulan_september;
$laba_ditahan_awal_bulan_november=$laba_ditahan_akhir_bulan_oktober;
$laba_ditahan_awal_bulan_desember=$laba_ditahan_akhir_bulan_november;


//Laba Di Tahan di Awal Bulan
echo "<tr style='white-space:nowrap;'>";
	echo "<td style=''></td>";
	echo "<td style=''>Laba Ditahan Awal Bulan</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_januari)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_februari)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_maret)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_april)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_mei)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_juni)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_juli)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_agustus)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_september)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_oktober)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_november)."</td>";
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_desember)."</td>";

	//TOTAL AKHIR KANAN
	//$laba_ditahan_awal_bulan_akhir=$laba_ditahan_awal_bulan_januari+$laba_ditahan_awal_bulan_februari+$laba_ditahan_awal_bulan_maret+$laba_ditahan_awal_bulan_april+$laba_ditahan_awal_bulan_mei+$laba_ditahan_awal_bulan_juni+$laba_ditahan_awal_bulan_juli+$laba_ditahan_awal_bulan_agustus+$laba_ditahan_awal_bulan_september+$laba_ditahan_awal_bulan_oktober+$laba_ditahan_awal_bulan_november+$laba_ditahan_awal_bulan_desember;
	echo "<td style='text-align:right;'>".rupiah($laba_ditahan_awal_bulan_akhir)."</td>";

echo "</tr>";
//Laba Di Tahan Di Awal Bulan End

//Laba / (Rugi) Bersih
echo "<tr style='font-weight:; white-space:nowrap;'>";
	echo "<td></td>";
	echo "<td style=''>Laba / (Rugi) Bersih</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_januari5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_februari5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_maret5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_april5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_mei5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_juni5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_juli5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_agustus5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_september5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_oktober5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_november5)."</td>";
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_desember5)."</td>";

	//GRAND TOTAL
	$grand_total_aset_akhir5=$grand_total_aset_januari5+$grand_total_aset_februari5+$grand_total_aset_maret5+$grand_total_aset_april5+$grand_total_aset_mei5+$grand_total_aset_juni5+$grand_total_aset_juli5+$grand_total_aset_agustus5+$grand_total_aset_september5+$grand_total_aset_oktober5+$grand_total_aset_november5+$grand_total_aset_desember5;
	echo "<td style='text-align:right;'>".rupiah($grand_total_aset_akhir5)."</td>";

echo "</tr>";
//Laba / (Rugi) Bersih END

//Adjusment
echo "<tr style='font-weight:; white-space:nowrap;'>";
	echo "<td></td>";
	echo "<td style=''>Adjusment</td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
	echo "<td style='text-align:right;'></td>";
echo "</tr>";
//Adjusment END

//Laba Di Tahan Di Akhir Bulan
echo "<tr style='font-weight:bold; white-space:nowrap; color:red;'>";
	echo "<td></td>";
	echo "<td style='border-bottom-style:double; border-top:1px solid;'>Laba Ditahan Akhir Bulan</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_januari)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_februari)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_maret)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_april)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_mei)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_juni)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_juli)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_agustus)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_september)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_oktober)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_november)."</td>";
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($laba_ditahan_akhir_bulan_desember)."</td>";

	//GRAND TOTAL AKHIR
	echo "<td style='text-align:right; border-bottom-style:double; border-top:1px solid;'>".rupiah($grand_total_aset_akhir5)."</td>";

echo "</tr>";
//Laba Di Tahan Di Akhir Bulan END


//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "</table>";
}//END TABLE


//START UTAMA
	//echo pilihan_bulan_tahun($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header);
	//echo tabel($address,$pilihan_tahun,$pilihan_bulan,$column,$column_header,$nama_database,$nama_database_items);
//END UTAMA


}//END HOME
//END PHP?>
