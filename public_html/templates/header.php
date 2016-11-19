<?php
function main2(){
	if (isset($_SESSION['ssid'])){
		if ($_SESSION['roleuser']==1){
			include_once 'navbar_afi.html';
		}
		elseif($_SESSION['roleuser']==2){
			include_once 'navbar_ope.html';
		}
		elseif($_SESSION['roleuser']==3){
			include_once 'navbar_adm.html';
		}
	}
	else{
		include_once 'navbar.html';
		}
}
main2();
?>
