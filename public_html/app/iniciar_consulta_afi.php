<?php
session_start();
function main(){
	if (isset($_POST['id']) && isset($_SESSION['roleuser'])){
		$_SESSION['id_afiliado'] = $_POST['id'];
		echo json_encode(True);
		}
		else {echo json_encode(False);}
}
main();
