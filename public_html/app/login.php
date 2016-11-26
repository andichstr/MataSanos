<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/conexiones/sesion.php');

//Session Structure:
//Se mantiene la sesion con Session ID: hash en md5 de $password + $email + (texto).
// Fórmula: md5($pass.$email.'57gjwe98r5u34209509jgjf9') 
// Session ID:  $_SESSION['ssid'] --> para usar en algun futuro..
// id usuario: $_SESSION['userid']
// Tipo de usuario : $_SESSION['roleuser']

session_start();

//Logearse
function login($data){
	$resultado = iniciar_sesion($data);
	if ($resultado != False){
		if ($resultado['mail']>"" and $resultado['password']>""){
			savesession($resultado);
			$role = $_SESSION['roleuser'];
			return $role;
		}else{
			echo json_encode('Has ingresado un email o contraseña incorrectos.');
			return False;
		}
	}else{echo json_encode('Has ingresado un email o contraseña incorrectos.');return false;}
}

//Guardar Session
function savesession($datos_sesion){
	$_SESSION['ssid'] = md5(key.$datos_sesion['password'].key2);
	$_SESSION['userid'] = $datos_sesion['id_usuario'];
	$_SESSION['mail'] = $datos_sesion['mail'];
	$_SESSION['nombre'] = $datos_sesion['nombre'];
	$_SESSION['roleuser'] = $datos_sesion['id_tipo_usuario'];
}


// Validar Datos (solo el email)
function test_input($data)
{
$data = trim($data); // Elimina espacio en blanco del inicio y final de la cadena.
$data = stripslashes($data); // Devuelve un string con las barras invertidas retiradas --> "\"
$data = htmlspecialchars($data); //  Convierte caracteres especiales en entidades HTML  Ejemplo:  Simbolo = '<'  entidad = '&lt;'
return $data;
}

function validar(){
	if (isset($_POST['email']) && isset($_POST['pass'])){
		$email = $_POST['email'];
		test_input($email);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
			echo json_encode('Email invalido');
			return False;
		}else{
			$data = [$_POST['email'],$_POST['pass']];
			return $data;
		}
	}else{
		echo json_encode('Faltan datos');
		return False;
	}
}


//---MAIN---// 
function main(){
	$res = validar();
	if ($res!=False){
		$login = login($res);
		if ($login != False){
			echo json_encode($login);
			}else{
				
			}
		}	
}	


main();
?>
