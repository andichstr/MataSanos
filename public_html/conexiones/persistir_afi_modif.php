<?php

include_once 'configure.php';
include_once 'conexion.php';

if (isset($_REQUEST['nombre']) && isset($_REQUEST['apellido']) &&
        isset($_REQUEST['dni']) && isset($_REQUEST['genero']) &&
        isset($_REQUEST['fecha_nacimiento']) && isset($_REQUEST['mail']) &&
        isset($_REQUEST['localidad']) && isset($_REQUEST['os']) && isset($_REQUEST['numAfi']) && isset($_REQUEST['direccion']) &&
        isset($_REQUEST['telefono']) && isset($_REQUEST['celular']) && isset($_REQUEST['password'])) {
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $dni = $_REQUEST['dni'];
    $genero = $_REQUEST['genero'];
    $fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
    $mail = $_REQUEST['mail'];
    $os = $_REQUEST['os'];
    $numAfi = $_REQUEST['numAfi'];
    $localidad = $_REQUEST['localidad'];
    $direccion = $_REQUEST['direccion'];
    $telefono = $_REQUEST['telefono'];
    $celular = $_REQUEST['celular'];
    $pass = convert_pass($_REQUEST['password']) ;
    $id=$_REQUEST['id_usuario'];
    
} else {
    echo 'Faltan campos requeridos.';
//    return false;
}

function persistirUsuario($nombre, $apellido, $mail, $pass, $id) {

    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("UPDATE " . tabla_usuarios . " SET nombre=:nombre, apellido=:apellido, mail=:mail, password=:pass WHERE id_usuario=:id"); //id_tipo_usuario=1 es afiliado
    $query->bindParam(':nombre', $nombre);
    $query->bindParam(':apellido', $apellido);
    $query->bindParam(':mail', $mail);
    $query->bindParam(':pass', $pass);
    $query->bindParam(':id',$id);

    if ($query->execute()) {
        echo "usuario modificado persistido con id:" . $id . "<br>";
        return $id;
    } else {
        echo 'problema al modificar usuario con id: '.$id;
        return false;
    }
}

function persistirAfiliado($id, $dni, $genero, $fecha, $id_obra, $num_afi, $direccion, $localidad, $telefono, $celular) {
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("UPDATE " . tabla_afiliados . " SET dni=:dni, genero=:genero, fecha_nacimiento=:fecha_nacimiento, id_obra_social=:id_obra, "
            . "numero_afiliado=:num_afi, direccion=:direccion, localidad=:localidad, telefono=:telefono, celular=:celular "
            . "WHERE id_usuario=:id");

    $query->bindParam(':id', $id);
    $query->bindParam(':dni', $dni);
    $query->bindParam(':genero', $genero);
    $query->bindParam(':fecha_nacimiento', $fecha);
    $query->bindParam(':id_obra', $id_obra);
    $query->bindParam(':num_afi', $num_afi);
    $query->bindParam(':direccion', $direccion);
    $query->bindParam(':localidad', $localidad);
    $query->bindParam(':telefono', $telefono);
    $query->bindParam(':celular', $celular);
    //$query->bindParam(':comentarios', $comentarios);

    if ($query->execute()) {

        echo '<br><b>Afiliado Modificado Persistido con id: ' . $id . '</b>';
        return $id;
    } else {
        echo 'Afiliado NO persistido con id: '.$id;
        return false;
    }
}

function convert_pass($pass){
	$key =  'dIifPmNOzV6pIYl8684fjfqckAwjxk9a';
	$key2 = '8HjPYTImY96oO3l65TPz7F7TQJHUSR9y';
	$passhashed = md5($key.$pass.$key2);
	return $passhashed;
};

$id_usuario = persistirUsuario($nombre, $apellido, $mail, $pass, $id );

if ($id_usuario) { //si se persistio el usuario..
    persistirAfiliado($id_usuario, $dni, $genero, $fecha_nacimiento, $os, $numAfi, $direccion, $localidad, $telefono, $celular);
}
?>

