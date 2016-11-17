<?php

include_once 'configure.php';
include_once 'conexion.php';

function cancelarTurno() {
    if (isset($_POST['id_turno'])) {
        $id_turno = $_POST['id_turno'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("UPDATE " . tabla_turnos . " SET id_afiliado=NULL WHERE (id_turno=:id_turno)");
        $query->bindParam(':id_turno', $id_turno);
        if ($query->execute()) {
            echo 'Si';
        } else {
            echo '0';
        }
        $con = null;
    } else {
        echo 'Datos no seteados';
    }
}

cancelarTurno();
?>

