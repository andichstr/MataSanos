<?php
include_once 'configure.php';
include_once 'conexion.php';

function persistirMedicoEspecialidades() {
    if (isset($_REQUEST['id_medico']) && isset($_REQUEST['especialidades'])) {
        $id_medico = $_REQUEST['id_medico'];
        $especialidades = $_REQUEST['especialidades'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO " . tabla_medicos_especialidades . " (id_medico, id_especialidad) VALUES (:id_medico, :id_especialidad)");
        for ($i=0; $i<count($especialidades); $i++){
            $query->bindParam(':id_medico', $id_medico);
            $query->bindParam(':id_especialidad', $especialidades[$i]);
            if ($query->execute()) {
                $resp = 'Si';
               
            } else {
                $resp = 'No';
            }
        }
        echo $resp;
    } else {
        echo 'Campos no seteados';
    }
}
persistirMedicoEspecialidades();


