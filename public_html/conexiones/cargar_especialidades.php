<?php

include_once 'configure.php';
include_once 'conexion.php';

function cargarEspecialidades() {
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("SELECT descripcion FROM " . tabla_especialidades);
    $query->execute();
    $result = $query->fetchAll();
    if (isset($result)) {
        foreach ($result as $row) {
            echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
        }
    } else {
        echo 'No Data';
    }
    $con = null;
}

cargarEspecialidades();
?>
