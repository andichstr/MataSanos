<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarHorarios() {
    if (isset($_POST['dia']) && isset($_POST['id_medico']) && isset($_POST['especialidad'])){
        echo 'entro';
        $id_medico = $_POST['id_medico'];
        $id_especialidad = $_POST['especialidad'];
        $dia = $_POST['dia'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT horario FROM " . tabla_turnos . " WHERE (fecha = :dia) AND (id_medico = :id_medico) AND (id_especialidad = :id_especialidad) AND (id_afiliado IS NULL)");
        $query->bindParam(':id_medico', $id_medico);
        $query->bindParam(':id_especialidad', $id_especialidad);
        $query->bindParam(':dia', $dia);
        if ($query->execute()){
            $result = $query->fetchAll();
            if (isset($result) && (count($result) != 0)) {
                foreach ($result as $row) { 
                    echo '<option value=' . $row['horario'] . '>' . $row['horario'] . '</option>';
                }
            } else {
                echo '0';
            }
        } else {
            echo 'No se ejecutó la consulta';
        }
        $con = null;
    }

}

buscarHorarios();
?>