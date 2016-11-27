<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarHorarios() {
    if (isset($_POST['dia']) && isset($_POST['id_medico']) && isset($_POST['especialidad'])){
        $id_medico = $_POST['id_medico'];
        $id_especialidad = $_POST['especialidad'];
        $dia = $_POST['dia'];
        $hora= date('H:i:s');
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT horario FROM " . tabla_turnos . " WHERE (fecha = :dia) AND (id_medico = :id_medico) AND "
                . "(id_especialidad = :id_especialidad) AND (id_afiliado IS NULL) AND (horario>:hora)");
        
        $query->bindParam(':id_medico', $id_medico);
        $query->bindParam(':id_especialidad', $id_especialidad);
        $query->bindParam(':dia', $dia);
        $query->bindParam(':hora', $hora);

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