<?php global $mod, $tbl, $fld,$cfield_name, $kolom, $title, $sekarang,$row,$id_user, $akses;
	$mod='salescl/salesreport';
function editmenu(){extract($GLOBALS);	}

function home(){extract($GLOBALS); 	
	echo "	<div id='navbar' align='center'>
	<div id='login_menu' >
	<div id='new-user-col' ><br /><br /> 
	
	<h2> Welcome </h2>
 	<form action='?menu=signin' method='post'>
	</div>
	<div id='signup-user-col'> 
	<img src='themes/images/images3.jpg' />
	
	<br />Untuk Jasa Pembuatan Software, Hubungi: wawan@0813.8099.4695
	</div>
	<div class='spacer'></div>
	</div>
	</div>";
}
 ?>
