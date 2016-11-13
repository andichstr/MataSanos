<?php

include_once 'configure.php';
include_once 'conexion.php';

function persistirMedico() {
    if (isset($_REQUEST['nombre']) && isset($_REQUEST['apellido']) && isset($_REQUEST['dni']) && isset($_REQUEST['genero']) && isset($_REQUEST['fecha_nacimiento']) && isset($_REQUEST['mail']) && isset($_REQUEST['localidad']) && isset($_REQUEST['direccion']) && isset($_REQUEST['telefono']) && isset($_REQUEST['matricula'])) {
        $nombre = $_REQUEST['nombre'];
        $apellido = $_REQUEST['apellido'];
        $dni = $_REQUEST['dni'];
        $genero = $_REQUEST['genero'];
        $fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
        $mail = $_REQUEST['mail'];
        $localidad = $_REQUEST['localidad'];
        $direccion = $_REQUEST['direccion'];
        $telefono = $_REQUEST['telefono'];
        $matricula = $_REQUEST['matricula'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO " . tabla_medicos . " (nombre, apellido, dni, genero, fecha_nacimiento, mail, localidad, direccion, telefono, numero_matricula) VALUES (:nombre, :apellido, :dni, :genero, :fecha_nacimiento, :mail, :localidad, :direccion, :telefono, :matricula)");
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellido', $apellido);
        $query->bindParam(':dni', $dni);
        $query->bindParam(':genero', $genero);
        $query->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $query->bindParam(':mail', $mail);
        $query->bindParam(':localidad', $localidad);
        $query->bindParam(':direccion', $direccion);
        $query->bindParam(':telefono', $telefono);
        $query->bindParam(':matricula', $matricula);
        if ($query->execute()) {
            $id = $con->lastInsertId();
            echo $id;
        } else {
            echo '0';
        }
    } else {
        echo 'Campos no seteados';
    }
}

persistirMedico();
?>
