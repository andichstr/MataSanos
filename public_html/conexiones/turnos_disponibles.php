<?php

include_once 'configure.php';
include_once 'conexion.php';

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/app/validate_o_actions.php');


function cargarTurnos() {
	$resultado = validar_o();
    if ($resultado != False){
        $id_afiliado = $resultado;
        consultarturnos($id_afiliado);
	}
	else {
		echo 'No';
	}
}
function consultarturnos($id_afiliado){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT t.id_turno, t.fecha, m.nombre, m.apellido, t.horario FROM " . tabla_turnos . " t INNER JOIN " . tabla_medicos . " m ON t.id_medico=m.id_medico WHERE (id_afiliado=:id_afiliado)");
        $query->bindParam(':id_afiliado', $id_afiliado);
        if($query->execute()){
            $result = $query->fetchAll();
            if (isset($result) && (count($result) != 0)) {
                foreach ($result as $row) {
                    echo '<tr><td>' . $row['fecha'] . '</td><td>' . $row['nombre'] . ' ' . $row['apellido'] . '</td><td>' . $row['horario'] . '</td>';
                    echo '<td><button class="btn btn-danger btn-sm" onclick="cancelarTurno(' . $row['id_turno'] . ');"><span class="glyphicon glyphicon-ban-circle"></span></button></td>';
                }
            } else {
                echo 'No'.$id_afiliado;
            }
        }
        $con = null;
}
    
cargarTurnos();
?>
