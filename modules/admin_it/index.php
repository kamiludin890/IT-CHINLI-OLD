<?php
session_start();
$urlini="/modules/admin_it/";
$nama_db ="a_aktivitas_user";
$valuecari = $_SESSION["cari"];
include('function.php');
$user =$_SESSION['username'];
include('a_head.php');
?>
<div style="margin-left:0.5%; ">
    <div class="position-absolute top-0 start-50 translate-middle">
        <h1 class="ms-5">Aktivitas user</h1>
    </div>
    <div class="mt-5 ">
        <form class="d-flex" role="search" method="POST">
            <input class="form-control me-2" type="search" placeholder="Cari" aria-label="Search" name="valuecari"
                value="<?=$_POST['valuecari']?>">
            <button class="btn btn-outline-success" type="submit" style="margin-left:2.5px" name="cari"
                value="cari">Search</button>
        </form>
    </div>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">User</th>
                    <th scope="col">Device Name / IP</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">

                <?php 
                //"SELECT * FROM $nama_db WHERE user= '$h' OR pc_name= '$h' OR status= '$h' OR kode_aktivitas= '$h' OR aktivitas= '$h' OR `waktu` = '$h'"
				$batas = 50;
				$halaman = isset($_POST['halaman'])?(int)$_POST['halaman'] : 1;
				$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;
                $valuecari = $_POST['valuecari'];
                if($valuecari!=''){
                    $data = mysql_query("SELECT * FROM $nama_db WHERE user= '$valuecari' OR pc_name= '$valuecari' OR status= '$valuecari' OR kode_aktivitas= '$valuecari' OR aktivitas LIKE '%$valuecari%'");
                    $jumlah_data = mysql_num_rows($data);
                    $total_halaman = ceil($jumlah_data / $batas);
                    $data_pegawai = mysql_query("SELECT * FROM $nama_db WHERE user= '$valuecari' OR pc_name= '$valuecari' OR status= '$valuecari' OR kode_aktivitas= '$valuecari' OR aktivitas LIKE '%$valuecari%' ORDER BY id DESC limit $halaman_awal, $batas ");
                }else{
				    $data = mysql_query("SELECT * FROM $nama_db");
				    $jumlah_data = mysql_num_rows($data);
				    $total_halaman = ceil($jumlah_data / $batas);
				    $data_pegawai = mysql_query("SELECT * FROM $nama_db ORDER BY id DESC limit $halaman_awal, $batas ");
                }
				$nomor = $halaman_awal+1;
				while($d = mysql_fetch_array($data_pegawai)){
					?>
                <tr>
                    <td><?php echo $nomor++;?></td>
                    <td><?php echo $d['user']; ?></td>
                    <td><?php echo $d['pc_name']; ?></td>
                    <td><?php echo $d['status']; ?></td>
                    <td><?php echo $d['kode_aktivitas']; ?></td>
                    <td><?php echo $d['aktivitas']; ?></td>
                </tr>
                <?php
				}
                if($_POST['halaman'] <= 1 OR $_POST['halaman']='' ){
                    $pembatashal1 = "hidden";
                }else{}
                if($_POST['halaman'] >= $total_halaman){
                    $pembatashal2 = "hidden";
                }else{};
				?>

            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-start">
        <form method="POST">
            <input type="text" name="valuecari" value="<?=$_POST['valuecari']?>" hidden>
            <input type="submit" class="btn btn-primary m-1" name="halaman" value="<?=$halaman-1?>" <?=$pembatashal1?>>
        </form>
        <form method="POST">
            <input type="text" name="valuecari" value="<?=$_POST['valuecari']?>" hidden>
            <input type="submit" class="btn btn-primary m-1" name="halaman" value="<?=$halaman+1?>" <?=$pembatashal2?>>
        </form>
    </div>
</div>
<?php

include('a_footer.php');
?>