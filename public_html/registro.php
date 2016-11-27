<?php
require_once 'app/chkuser.php';
require_once 'conexiones/configure.php';
require_once 'conexiones/conexion.php';

if(isset($_REQUEST['token'])){
    if(verificar_token($_REQUEST['token'])){
        include_once 'templates/registro.html';
    }else{
        header('location: index.php');
    }
}else{
       header('location: index.php');
}


function verificar_token($token) {

    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("SELECT u.id_usuario FROM " . tabla_usuarios . " u WHERE u.token = :token  AND (u.password IS NULL OR u.password  = '')");
    $query->bindParam(':token', $token);
    $query->execute();
    $result = $query->fetchAll();

    if (count($result) == 1) {
        return true;
    }
    return false;
}




?>
