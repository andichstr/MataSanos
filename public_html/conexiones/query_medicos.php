<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarMedico() {
    if (isset($_POST['especialidad'])){
        $especialiad = $_POST['especialidad'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT " . tabla_medicos_especialidades . ".id_medico, nombre, apellido, numero_matricula FROM " . tabla_medicos_especialidades . " INNER JOIN " . tabla_medicos . " ON " . tabla_medicos_especialidades . ".id_medico = " . tabla_medicos . ".id_medico INNER JOIN " . tabla_especialidades . " ON " . tabla_medicos_especialidades . ".id_especialidad = " . tabla_especialidades . ".id_especialidad WHERE (" . tabla_medicos_especialidades . ".id_especialidad = :especialidad)");
        $query->bindParam(':especialidad', $especialiad);
        $query->execute();
        $result = $query->fetchAll();
        if (isset($result) && (count($result) != 0)) {
            foreach ($result as $row) {
                echo '<tr><td>' . $row['nombre'] . ' ' . $row['apellido']. '</td><td>' . $row['numero_matricula'] . '</td>';
                echo '<td><p data-placement="top" data-toggle="tooltip" title="modificar datos"><button class="btn btn-primary btn-sm" onclick="modificarMedico(' . $row['id_medico'] . ');"><span class="glyphicon glyphicon-pencil"></span></button></p></td>';
                echo '<td><a href="#"><button class="btn btn-danger btn-sm" onclick="eliminarMedico(' . $row['id_medico'] . ');"><span class="glyphicon glyphicon-ban-circle"></span></button></a></td>';
            }
        } else {
            echo '0';
        }
        $con = null;
    }

}

buscarMedico();
?>
