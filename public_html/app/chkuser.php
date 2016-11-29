<?php

session_start();
// Chekear si esta logeado (antes que inicie sesion)

//Configuracion de roles (accesos a paginas)
$afiliado = ['turnos.php','solicitar_turno.php','editar_datos.php'];
$operador = ['alta_afiliado.php','solicitar_turno.php','buscar_afiliado.php','editar_datos.php','turnos.php'];
$administrativo = ['buscar_medico.php','buscar_afiliado.php','modificar_medico.php','alta_medico.php','alta_operador.php'];
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
				break;
			}	
		}
		if ($encontrado == False){
			header('Location: ./'.$roles[$role-1][0]);
		}	
	}
}

function main($roles){
	$page = basename($_SERVER['PHP_SELF']);
	$checkl = checkislogin();
	if ($page != 'index.php' && $checkl == False){ //si no hay usuario logueado 
            if($page=='registro.php'){ // y si la pagina actual es la de registro..
                return true;
            }else{
                header('Location: ./index.php');
            }
	}
	elseif ($page=='index.php' && $checkl==False){
		return True;
		}
	elseif ($page=='index.php' && $checkl==True){
		$role = $_SESSION['roleuser'];
		header('Location: ./'.$roles[$role-1][0]);
	}else{
		redirect($page,$roles);
	}
}
main($roles);
?>
