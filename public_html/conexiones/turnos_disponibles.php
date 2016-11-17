<?php

include_once 'configure.php';
include_once 'conexion.php';

session_start();

function cargarTurnos() {
    if (isset($_SESSION['userid'])) {
        $id_afiliado = $_SESSION['userid'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT t.id_turno, t.fecha, m.nombre, m.apellido, t.horario FROM " . tabla_turnos . " t INNER JOIN " . tabla_medicos . " m ON t.id_medico=m.id_medico WHERE (id_afiliado=:id_afiliado)");
        $query->bindParam(':id_afiliado', $id_afiliado);
        if($query->execute()){
            $result = $query->fetchAll();
            if (isset($result) && (count($result) != 0)) {
                foreach ($result as $row) {
                    echo '<tr><td>' . $row['fecha'] . '</td><td>' . $row['nombre'] . ' ' . $row['apellido'] . '</td><td>' . $row['horario'] . '</td>';
                    echo '<td><button class="btn btn-danger btn-sm" onclick="cancelarTurno(' . $row['id_turno'] . ');"><span class="glyphicon glyphicon-ban-circle"></span></button></td>';
                }
            } else {
                echo 'No';
            }
        }
    }
    $con = null;
}

cargarTurnos();
?>
