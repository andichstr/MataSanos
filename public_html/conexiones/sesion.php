<?php
require_once('configure.php');
require_once('conexion.php');

function iniciar_sesion($data){
	$mail = $data[0];
	$pass = convert_pass($data[1]);
	$cn = new Conexion();
	$query = $cn->prepare("SELECT * FROM usuarios where mail=? and password=?");
	$query->execute(array($mail,$pass));
	$datos = $query->fetch();
	return $datos;
}

function convert_pass($pass){
	$key =  'dIifPmNOzV6pIYl8684fjfqckAwjxk9a';
	$key2 = '8HjPYTImY96oO3l65TPz7F7TQJHUSR9y';
	$passhashed = md5($key.$pass.$key2);
	return $passhashed;
}
?>
