<?php

include_once 'configure.php';
include_once 'conexion.php';
echo $_POST['id_medico'];
echo $_POST['especialidades'];
echo $_POST['horarios'];
function persistirMedicoEspecialidades() {
    if (isset($_POST['id_medico']) && isset($_POST['especialidades']) && isset($_POST['horarios'])) {
        $id_medico = $_POST['id_medico'];
        $especialidades = $_POST['especialidades'];
        $horarios = $_POST['horarios'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO " . tabla_medicos_especialidades . " (id_medico, id_especialidad, dia, horario_inicio, horario_fin, duracion_turno_minutos) VALUES (:id_medico, :id_especialidad, :dia, :horario_inicio, :horario_fin, :duracion_turno_minutos)");
        $query->bindParam(':id_medico', $id_medico);
        for ($i=0; $i<count($especialidades); $i++){
            $query->bindParam(':id_especialidad', $especialidades[$i]);
            for ($a=0; $a<count($horarios); $a++){
                $query->bindParam(':dia',$horarios[$a].dia);
                $query->bindParam(':horario_inicio',$horarios[$a].horarioInicio);
                $query->bindParam(':horario_fin',$horarios[$a].horarioFin);
                $query->bindParam(':duracion',$horarios[$a].duracion);
                if ($query->execute()) {
                    $resp = 'Sisi';
                } else {
                    $resp = 'Nono';
                }
            }
        }
        echo $resp;
    } else {
        echo 'Campos no seteados';
    }
}

persistirMedicoEspecialidades();
?>

