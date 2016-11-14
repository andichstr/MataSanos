<?php
session_start();

// Chekear si esta logeado (antes que inicie sesion)

//Configuracion de roles (accesos a paginas)
$afiliado = ['turnos','solicitar_turno','modificar_afiliado'];
$operador = ['alta_afiliado','alta_turno_afiliado','buscar_afiliado','modificar_afiliado','solicitar_turno','turnos'];
$administrativo = ['buscar_medico','buscar_afiliado','modificar_medico','alta_medico','alta_operador'];
$roles = [$afiliado,$operador,$administrativo];

function checkislogin(){
	if (isset($_SESSION['ssid'])){
	return True;
	}else{
	return False;
	}
}

function redirect($page,$roles){
	$encontrado = False;
	if (isset($_SESSION['roleuser'])){
		$role = $_SESSION['roleuser'];
		foreach ($roles[$role-1] as $pag){
			if ($page == $pag){
				$encontrado = True;
				echo json_encode('OK');
				break;
			}	
		}
		if ($encontrado == False){
			echo json_encode('./'.$roles[$role-1][0].'.php');
		}	
	}
}

function main($roles){
	if (isset($_POST['page'])){
		$page = $_POST['page'];
		$checkl = checkislogin();
		if ($page != 'login' && $checkl == False){
			echo json_encode('./index.php');
		}
		elseif ($page=='login' && $checkl==False){
			echo json_encode('OK');
			}
		elseif ($page=='login' && $checkl==True){
			$role = $_SESSION['roleuser'];
			echo json_encode('./'.$roles[$role-1][0].'.php');
		}else{
			redirect($page,$roles);
		}
	}
}

main($roles);
?>
