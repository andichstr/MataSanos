<?php
require_once('conexion.php');

function iniciar_sesion($data){
	$mail = $data[0];
	$pass = convert_pass($data[1]);
	$cn = new Conexion();
	$query = $cn->prepare("SELECT * FROM " . tabla_usuarios . " where mail=? and password=?");
	$query->execute(array($mail,$pass));
	$datos = $query->fetch();
	if ($datos['id_tipo_usuario']==1){
		if (verificar_activo($datos['id_usuario'])){
			return $datos;
			}
		else{echo json_encode('No se puede iniciar sesión porque no estas activo.');return false;}
	}
	else if ($datos['id_tipo_usuario'] == 2 or $datos['id_tipo_usuario'] == 3){return $datos;}
	else{return False;}
	
}

function convert_pass($pass){
	$passhashed = md5(key.$pass.key2);
	return $passhashed;
}

function verificar_activo($id){
	$con = new Conexion();
	$query = $con->prepare("SELECT * FROM " . tabla_afiliados . " where id_usuario=?");
	$query->execute(array($id));
	$datos = $query->fetch();
	if ($datos['activo'] == 1){
		return True;
		}
	else{return False;}
}
?>
