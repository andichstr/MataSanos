<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarDias() {
    if (isset($_POST['id_medico']) && isset($_POST['especialidad'])){
        $id_medico = $_POST['id_medico'];
        $id_especialidad = $_POST['especialidad'];
        $fecha=date("Y-m-d");
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT DISTINCT fecha FROM " . tabla_turnos . " WHERE (id_medico = :id_medico) AND "
                . "(id_especialidad = :id_especialidad) AND (id_afiliado IS NULL) AND (fecha>=:fecha)");
        
        $query->bindParam(':id_medico', $id_medico);
        $query->bindParam(':id_especialidad', $id_especialidad);
        $query->bindParam(':fecha', $fecha);
  
        if ($query->execute()){
            $result = $query->fetchAll();
            if (isset($result) && (count($result) != 0)) {
                foreach ($result as $row) {
                    echo '<option value=' . $row['fecha'] . '>' . $row['fecha'] . '</option>';
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

buscarDias();
?>
