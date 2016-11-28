<?php

include_once 'configure.php';
include_once 'conexion.php';

function eliminarMedico() {
    if (isset($_POST['id_medico'])) {
        $id = $_POST['id_medico'];
        $estado = consultar_estado($id);
        if ($estado == 0) {
            $activo = 1;
        } else {
            $activo = 0;
        }
        $cn = new Conexion();
        $query = $cn->prepare("UPDATE " . tabla_medicos . " SET activo = ? WHERE (id_medico=?)");
        $query->execute(array($activo, $id));
        $datos = $query->rowCount();
        $cn = NULL;
        echo json_encode($activo);
    }
}

function consultar_estado($id) {
    $con = new Conexion();
    $query = $con->prepare("SELECT activo FROM " . tabla_medicos . " WHERE (id_medico=:id_medico)");
    $query->bindParam(':id_medico', $id);
    $query->execute();
    $datos = $query->fetch();
    $con = NULL;
    return $datos['activo'];
}

eliminarMedico();
?>
