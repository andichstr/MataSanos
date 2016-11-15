<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarAfiliado() {
    if (isset($_REQUEST['id_afiliado'])){
        $id = $_REQUEST['id_afiliado'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT * FROM " . tabla_afiliados ." a JOIN ". tabla_usuarios. " u ON a.id_usuario=u.id_usuario WHERE u.id_usuario = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetchAll();
        if (isset($result) && (count($result) != 0)) {
//            foreach ($result as $row) {
//                echo '<tr><td>' . $row['nombre'] . ' ' . $row['apellido']. '</td><td>' . $row['numero_matricula'] . '</td>';
//                echo '<td><p data-placement="top" data-toggle="tooltip" title="modificar datos"><button class="btn btn-primary btn-sm" onclick="modificarMedico(' . $row['id_medico'] . ');"><span class="glyphicon glyphicon-pencil"></span></button></p></td>';
//                echo '<td><a href="#"><button class="btn btn-danger btn-sm" onclick="eliminarMedico(' . $row['id_medico'] . ');"><span class="glyphicon glyphicon-ban-circle"></span></button></a></td>';
//            }
            $json = json_encode($result[0]);//

            return $json;
        
        } else {
            echo '0';
        }
        $con = null;
    }

}

echo buscarAfiliado();



