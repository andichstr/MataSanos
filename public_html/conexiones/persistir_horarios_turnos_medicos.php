<?php

include_once 'configure.php';
include_once 'conexion.php';

print_r($_POST['especialidades']);
print_r($_POST['horarios'][0]['duracion']);

function persistirTurnosMedicosHorarios() {//retornara los id de los turnos nuevos
    if (isset($_POST['id_medico']) && isset($_POST['especialidades']) && isset($_POST['horarios'])) {
        $turnos_persistir = []; //array que guardara los id de los turnos que se generaros en la ultima alta.
        $id_medico = $_POST['id_medico'];
        $especialidades = $_POST['especialidades'];
        $horarios = $_POST['horarios'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO " . tabla_horarios_turnos_medicos . " (id_medico, id_especialidad, dia, horario_inicio, horario_fin, duracion_turno_minutos) VALUES (:id_medico, :id_especialidad, :dia, :horario_inicio, :horario_fin, :duracion)");
        $query->bindParam(':id_medico', $id_medico);
        for ($i = 0; $i < count($especialidades); $i++) {
            $query->bindParam(':id_especialidad', $especialidades[$i]);
            for ($a = 0; $a < count($horarios); $a++) {
                $query->bindParam(':dia', $horarios[$a]['dia']);
                $query->bindParam(':horario_inicio', $horarios[$a]['horarioInicio']);
                $query->bindParam(':horario_fin', $horarios[$a]['horarioFin']);
                $query->bindParam(':duracion', $horarios[$a]['duracion']);
                if ($query->execute()) {
                    $turnos_persistir[] = $con->lastInsertId();
                    $resp = 'Sisi';
                } else {
                    $resp = 'Nono';
                }
            }
        }// fin del for
        echo $resp;
        return $turnos_persistir;
    } else {
        echo 'Campos no seteados';
    }
    $con = NULL;
}

function persistir_turnos($turnos) {
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("SELECT * " . tabla_horarios_turnos_medicos . " WHERE id_horarios_turnos_medicos=:id");
//        $query->bindParam(':id_medico', $id_medico);
    for ($a = 0; $a < count($turnos); $a++) { //por cada turno nuevo para persistir..
        $query->bindParam(':dia', $turnos[$a]);
        if ($query->execute()) {
            $turno = $query->fetchAll();
            
            
            $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//insertar turno..
            $query2 = $con->prepare("INSERT INTO " . tabla_turnos . "(horario, fecha, id_medico, id_especialidad) VALUES (:horario, :fecha, :medico, :especialidad)");
            
            
            
            
            
        } else {
            $resp = 'Nono';
        }
    }
}

print_r(persistirTurnosMedicosHorarios());
?>

