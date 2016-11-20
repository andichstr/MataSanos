<?php

include_once 'configure.php';
include_once 'conexion.php';
define('__ROOT__', dirname(dirname(__FILE__)));
include_once(__ROOT__.'.\app\validate_o_actions.php');

function buscarAfiliado() {
	$respuesta = validar_o();
    if ($respuesta != False){
        $id = $respuesta;
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT * FROM " . tabla_afiliados ." a JOIN ". tabla_usuarios. " u ON a.id_usuario=u.id_usuario WHERE u.id_usuario = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetchAll();
        if (isset($result) && (count($result) != 0)) {
            $json = json_encode($result[0]);
            echo $json;
        
        } else {
            echo '0';
        }
        $con = null;
    }
    else{
		echo '0';
		}

}
buscarAfiliado();



