<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarMedico() {
    if (isset($_POST['id_medico'])){
        $id = $_POST['id_medico'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT * FROM " . tabla_medicos . " WHERE id_medico = :id");
        $query->bindParam(':id', $id);
        if ($query->execute()){
            $result = $query->fetchAll();
            if (isset($result) && (count($result) != 0)) {
                $json = json_encode($result[0]);
                echo $json;
            } else {
                echo '0';
            }
        }
        $con = null;
    }

}

buscarMedico();
?>

