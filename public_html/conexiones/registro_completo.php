<?php

include_once 'configure.php';
include_once 'conexion.php';

if (isset($_REQUEST['id_usuario']) && isset($_REQUEST['pass'])) {

    if ($_REQUEST['pass'] == '') {
        echo 'No dejar la contraseña en blanco. ';
    } else {
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("UPDATE " . tabla_usuarios . " u SET u.password=:pass WHERE u.id_usuario=:id");
        $query->bindParam(':pass', $pass);
        $query->bindParam(':id', $id);

        if ($query->execute()) {
            echo "1";
        } else {
            echo "0";
        }
        $con = null;
    }

    $pass = convert_pass($_REQUEST['pass']);
    $id = $_REQUEST['id_usuario'];
} else {
    echo "No se han seteado los datos";
}

function convert_pass($pass) {
    $key = 'dIifPmNOzV6pIYl8684fjfqckAwjxk9a';
    $key2 = '8HjPYTImY96oO3l65TPz7F7TQJHUSR9y';
    $passhashed = md5($key . $pass . $key2);
    return $passhashed;
}

