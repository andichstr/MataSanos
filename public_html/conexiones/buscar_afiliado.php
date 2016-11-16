<?php
require_once('configure.php');
require_once('conexion.php');

function main(){
	if (isset($_POST['dni']) and ($_POST['dni'] != '')){
		$dni = $_POST['dni'];
	}
	else{
		$dni = '%';
	}
	if (isset($_POST['apellido']) and ($_POST['apellido'] != '')){
		$apellido = '%'.strtolower($_POST['apellido']).'%';
	}
	else{
		$apellido = '%';
	}
	if (isset($_POST['numafiliado']) and ($_POST['numafiliado'] != '')){
		$numafiliado = $_POST['numafiliado'];
	}
	else{
		$numafiliado = '%';
	}
	if (isset($_POST['mail']) and ($_POST['mail'] != '')){
		$mail = '%'.strtolower($_POST['mail']).'%';
	}
	else{
		$mail = '%';
	}
	buscar_afiliado($dni,$apellido,$numafiliado,$mail);
}

function buscar_afiliado($dni,$apellido,$numafiliado,$mail){
	$cn = new Conexion();
	$query->execute(array($dni,$apellido,$numafiliado,$mail));
	$datos = $query->fetchAll();
	$afiliados = array();
	$cn = NULL;
	foreach($datos as $row){
	array_push($afiliados,['dni' => $row['dni'],'nombre' => $row['nombre']." ".$row['apellido'],'numAfi' => $row['numero_afiliado'],'activo' => $row['activo']]);
	}
	echo json_encode($afiliados);
}

main();
?>
