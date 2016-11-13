<?php

include_once 'configure.php';
include_once 'conexion.php';

function eliminarMedico() {
    if (isset($_POST['id_medico'])){
        $id_medico = (int)$_POST['id_medico'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("DELETE FROM " . tabla_medicos . " WHERE (id_medico = :id_medico)");
        $query->bindParam(':id_medico', $id_medico);
        if ($query->execute()) {
            echo 'Usted eliminó al médico con éxito!<br>';
            echo 'Presione el botón cerrar o haga click fuera para salir.';
        } else {
            echo 'No Data';
        }
        $con = null;
    }
}

eliminarMedico();
?>
