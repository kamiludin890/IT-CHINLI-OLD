<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row,$id_user, $akses;
	$mod='admin_it/home';
function editmenu(){extract($GLOBALS);	}

function home(){extract($GLOBALS);
	echo"<h1>Wait for loading<h1>";
	header("Location:http://192.168.2.16:8098/modules/admin_it/");
}
 ?>