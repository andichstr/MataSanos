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
        $i = 1;
        foreach ($result as $row) {
            echo '<option value="' . $i . '">' . $row[0] . '</option>';
            $i += 1;
        }
    } else {
        echo 'No Data';
    }
    $con = null;
}

cargarEspecialidades();
?>
