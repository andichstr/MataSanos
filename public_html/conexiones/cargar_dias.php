<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarDias() {
    if (isset($_POST['id_medico'])){
        $id_medico = $_POST['id_medico'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT fecha FROM " . tabla_turnos . " WHERE (id_medico = :id)");
        $query->bindParam(':id', $id_medico);
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
