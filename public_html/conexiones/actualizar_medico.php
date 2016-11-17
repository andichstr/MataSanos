<?php

include_once 'configure.php';
include_once 'conexion.php';

function actualizarMedico() {
    if (isset($_POST['id_medico']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['dni']) && isset($_POST['genero']) && isset($_POST['fecha_nacimiento']) && isset($_POST['mail']) && isset($_POST['localidad']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['matricula'])) {
        $id_medico = $_POST['id_medico'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $genero = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $mail = $_POST['mail'];
        $localidad = $_POST['localidad'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $matricula = $_POST['matricula'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("UPDATE " . tabla_medicos . " SET nombre=:nombre, apellido=:apellido, dni=:dni, genero=:genero, fecha_nacimiento=:fecha_nacimiento, mail=:mail, localidad=:localidad, direccion=:direccion, telefono=:telefono, numero_matricula=:matricula WHERE (id_medico=:id)");
        $query->bindParam(':id', $id_medico);
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
            echo 'Si';
        } else {
            echo '0';
        }
    } else {
        echo 'Campos no seteados';
    }
}

actualizarMedico();
?>
