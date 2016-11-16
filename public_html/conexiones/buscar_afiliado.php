<?php
require_once('configure.php');
require_once('conexion.php');

function main(){
	if (isset($_POST['dni'])){
		$dni = $_POST['dni'];
	}
	else{
		$dni = '25349662';
	}
	if (isset($_POST['apellido'])){
		$apellido = $_POST['apellido'];
	}
	else{
		$apellido = '%';
	}
	if (isset($_POST['numafiliado'])){
		$numafiliado = $_POST['numafiliado'];
	}
	else{
		$numafiliado = '';
	}
	if (isset($_POST['mail'])){
		$mail = $_POST['mail'];
	}
	else{
		$mail = '%';
	}
	buscar_afiliado($dni,$apellido,$numafiliado,$mail);
}

function buscar_afiliado($dni,$apellido,$numafiliado,$mail){
	$cn = new Conexion();
	$query = $cn->prepare("SELECT afiliados.dni, usuarios.apellido, afiliados.numero_afiliado, usuarios.mail FROM usuarios JOIN matasanos.afiliados ON usuarios.id_usuario = afiliados.id_usuario WHERE (lower(apellido) LIKE '%townsend%') and (lower(mail) LIKE '%vel@acturpis.org%')");
	$query->execute(array($dni));
	$datos = $query->fetchAll();
	$afiliados = array();
	$cn = NULL;
	foreach($datos as $row){
	array_push($afiliados,$row);
	}
	echo json_encode($datos);
}

main();
?>
