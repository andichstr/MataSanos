<?php

include_once 'configure.php';
include_once 'conexion.php';

session_start();

function reservarTurno() {
    if (isset($_POST['id_medico']) && isset($_POST['especialidad']) && isset($_POST['dia']) && isset($_POST['horario']) && isset($_SESSION['userid'])) {
        $id_afiliado = $_SESSION['userid'];
        $id_medico = $_POST['id_medico'];
        $id_especialidad = $_POST['especialidad'];
        $dia = $_POST['dia'];
        $horario = $_POST['horario'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("UPDATE " . tabla_turnos . " SET id_afiliado=:id_afiliado WHERE (id_medico=:id_medico) AND (id_especialidad=:id_especialidad) AND (fecha=:dia) AND (horario=:horario)");
        $query->bindParam(':id_medico', $id_medico);
        $query->bindParam(':id_especialidad', $id_especialidad);
        $query->bindParam(':id_afiliado', $id_afiliado);
        $query->bindParam(':dia', $dia);
        $query->bindParam(':horario', $horario);
        if ($query->execute()) {
            echo 'Si';
        } else {
            echo '0';
        }
    } else {
        echo 'Campos no seteados';
        echo 'iduser: ' . $_SESSION['userid'];
        echo 'idmedico: ' . $_POST['id_medico'];
        echo 'idespecialidad: ' . $_POST['especialidad'];
        echo 'dia: ' . $_POST['dia'];
        echo 'horario: ' . $_POST['horario'];
    }
    $con = null;
}

echo 'iduser: ' . $_SESSION['userid'];
echo 'idmedico: ' . $_POST['id_medico'];
echo 'idespecialidad: ' . $_POST['especialidad'];
echo 'dia: ' . $_POST['dia'];
echo 'horario: ' . $_POST['horario'];
reservarTurno();
?>