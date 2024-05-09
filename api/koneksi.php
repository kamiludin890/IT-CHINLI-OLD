<?php
// Membuat variabel, ubah sesuai dengan nama host dan database pada hosting
$host	= "localhost:3318";
$user	= "root";
$pass	= "merdeka170845";
$db	= "db_kampus";

//Menggunakan objek mysqli untuk membuat koneksi dan menyimpan nya dalam variabel $mysqli
$mysqli = new mysqli($host, $user, $pass, $db);

?>
