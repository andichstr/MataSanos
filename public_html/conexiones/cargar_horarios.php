<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarHorarios() {
    if (isset($_POST['dia'])){
        $dia = $_POST['dia'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT horario FROM " . tabla_turnos . " WHERE (fecha = :dia)");
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

