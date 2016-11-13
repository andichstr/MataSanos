<?php

include_once 'configure.php';
include_once 'conexion.php';

function persistirOperador() {
    if (isset($_REQUEST['nombre']) && isset($_REQUEST['apellido']) && isset($_REQUEST['mail']) && isset($_REQUEST['password'])) {
        $nombre = $_REQUEST['nombre'];
        $apellido = $_REQUEST['apellido'];
        $mail = $_REQUEST['mail'];
        $password = convert_pass($_REQUEST['password']);
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO " . tabla_usuarios . " (nombre, apellido, mail, password, id_tipo_usuario) VALUES (:nombre, :apellido, :mail, :password, 2)");
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellido', $apellido);
        $query->bindParam(':mail', $mail);
        $query->bindParam(':password', $password);
        if ($query->execute()) {
            echo 'Usted dio de alta satisfactoriamente al operador ' . $nombre . ' ' . $apellido . '.<br>';
            echo 'Presione el botón cerrar o haga click fuera para salir.';
        } else {
            echo '0';
        }
    } else {
        echo 'Campos no seteados';
    };
};

function convert_pass($pass){
	$key =  'dIifPmNOzV6pIYl8684fjfqckAwjxk9a';
	$key2 = '8HjPYTImY96oO3l65TPz7F7TQJHUSR9y';
	$passhashed = md5($key.$pass.$key2);
	return $passhashed;
};

persistirOperador();

?>

