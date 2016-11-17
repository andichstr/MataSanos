<?php

//require_once 'app/chkuser.php';
require_once 'configure.php';
require_once 'conexion.php';

if (isset($_REQUEST['token']) && isset($_REQUEST['dni']) && isset($_REQUEST['pass'])) {
    
    if (verificar_token($_REQUEST['token'])) {
        if ($_REQUEST['pass'] == '') {
            echo 'No dejar la contraseña en blanco. ';
        } else {
            if (verificar_dni($_REQUEST['token'],$_REQUEST['dni'])) {
                $con = new Conexion();
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = $con->prepare("UPDATE " . tabla_usuarios . " u  SET u.password=:pass WHERE u.token=:token");
                $query->bindParam(':pass', convert_pass($_REQUEST['pass']));
                $query->bindParam(':token', $_REQUEST['token']);

                if ($query->execute()) {
                    echo "Registro Completo";
                } else {
                      echo 'Error al completar Registro.';
                }
                $con = null;
            } else {
                echo 'El DNI ingresado no coincide con nuestros registros. Comuníquiese telefónicamente.';
            }
        }
    }else{
        echo 'Error al completar Registro.';
    }
} else {
  echo 'Error al completar Registro.';
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

function verificar_dni($token,$dni) {

    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("SELECT u.id_usuario FROM " . tabla_usuarios . " u INNER JOIN ". tabla_afiliados." a ON a.id_usuario=u.id_usuario WHERE u.token = :token AND a.dni=:dni");
    $query->bindParam(':token', $token);
    $query->bindParam(':dni', $dni);
    $query->execute();
    $result = $query->fetchAll();

    if (count($result) == 1) {
        return true;
    }
    return false;
}


function convert_pass($pass) {
    $key = 'dIifPmNOzV6pIYl8684fjfqckAwjxk9a';
    $key2 = '8HjPYTImY96oO3l65TPz7F7TQJHUSR9y';
    $passhashed = md5($key . $pass . $key2);
    return $passhashed;
}
