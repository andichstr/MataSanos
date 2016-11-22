<?php

include_once 'configure.php';
include_once 'conexion.php';


define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '\app\validate_o_actions.php');
require_once(__ROOT__ . '\app\validardatos.php');


session_start();

function reservarTurno() {
    $resultado = validar_o();
    if ($resultado != False) {
        $id_afiliado = $resultado;
        if (isset($_POST['id_medico']) && isset($_POST['especialidad']) && isset($_POST['dia']) && isset($_POST['horario'])) {
            if (validar_numero($_POST['id_medico']) && validar_numero($_POST['especialidad'])) {
                $id_medico = $_POST['id_medico'];
                $id_especialidad = $_POST['especialidad'];
                $dia = $_POST['dia'];
                $horario = $_POST['horario'];
                $con = new Conexion();
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = $con->prepare("UPDATE " . tabla_turnos . " SET id_afiliado=:id_afiliado WHERE (id_medico=:id_medico) AND (id_especialidad=:id_especialidad) AND (fecha=:dia) AND (horario=:horario)");
                $query->bindParam(':id_medico', $id_medico);
                $query->bindParam(':id_especialidad', $id_especialidad);
                $query->bindParam(':id_afiliado', $id_afiliado);
                $query->bindParam(':dia', $dia);
                $query->bindParam(':horario', $horario);
                if ($query->execute()) {
                    echo 'Si';
                } else {
                    echo '0';
                }
                $con = null;
            } else {
                echo 'Campos invalidos';
            }
        } else {
            echo 'Campos no seteados';
        }
    } else {
        echo 'No tienes acceso a esta funcionlidad';
    }
}

reservarTurno();
?>
