<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarMedico() {
    if (isset($_POST['especialidad'])){
        $especialiad = $_POST['especialidad'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT " . tabla_medicos_especialidades . ".id_medico, nombre, apellido, numero_matricula FROM " . tabla_medicos_especialidades . " INNER JOIN " . tabla_medicos . " ON " . tabla_medicos_especialidades . ".id_medico = " . tabla_medicos . ".id_medico  WHERE (" . tabla_medicos_especialidades . ".id_especialidad = :especialidad) AND activo=1");
        $query->bindParam(':especialidad', $especialiad);
        if ($query->execute()){
            $result = $query->fetchAll();
            if (isset($result) && (count($result) != 0)) {
                foreach ($result as $row) {
                    echo '<option value=' . $row['id_medico'] . '>' . $row['nombre'] . ' ' . $row['apellido'] . '</option>';
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

buscarMedico();
?>

