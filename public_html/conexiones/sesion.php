<?php
require_once('conexion.php');

function iniciar_sesion($data){
	$mail = $data[0];
	$pass = convert_pass($data[1]);
	$cn = new Conexion();
	$query = $cn->prepare("SELECT * FROM " . tabla_usuarios . " where mail=? and password=?");
	$query->execute(array($mail,$pass));
	$datos = $query->fetch();
	return $datos;
}

function convert_pass($pass){
	$passhashed = md5(key.$pass.key2);
	return $passhashed;
}
?>
