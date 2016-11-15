<?php

include_once 'configure.php';
include_once 'conexion.php';

if (isset($_REQUEST['nombre']) && isset($_REQUEST['apellido']) && 
            isset($_REQUEST['dni']) && isset($_REQUEST['genero']) && 
            isset($_REQUEST['fecha_nacimiento']) && isset($_REQUEST['mail']) && 
            isset($_REQUEST['localidad']) && isset($_REQUEST['os']) && isset($_REQUEST['numAfi']) && isset($_REQUEST['direccion']) && 
            isset($_REQUEST['telefono']) && isset($_REQUEST['celular']) && isset($_REQUEST['comentarios'])) 
        {
        $nombre = $_REQUEST['nombre'];
        $apellido = $_REQUEST['apellido'];
        $dni = $_REQUEST['dni'];
        $genero = $_REQUEST['genero'];
        $fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
        $mail = $_REQUEST['mail'];
        $os=$_REQUEST['os'];
        $numAfi=$_REQUEST['numAfi'];
        $localidad = $_REQUEST['localidad'];
        $direccion = $_REQUEST['direccion'];
        $telefono = $_REQUEST['telefono'];
        $celular = $_REQUEST['celular'];
        $comentarios=$_REQUEST['comentarios'];
            } else {
                echo 'Campos no seteados';
                return false;
            }

function persistirUsuario($nombre, $apellido, $mail) {
    
        
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO ".tabla_usuarios." (nombre, apellido, mail, id_tipo_usuario) VALUES (:nombre, :apellido, :mail, 1)"); //id_tipo_usuario=1 es afiliado
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellido', $apellido);
        $query->bindParam(':mail', $mail);
      
        if ($query->execute()) {
            $id = $con->lastInsertId();
            echo "usuario persistido con id:". $id."<br>";
            return $id;
        } else {
            echo '0';
            return false;
        }

}

function persistirAfiliado($id,$dni,$genero,$fecha,$id_obra,$num_afi,$direccion, $localidad,$telefono,$celular,$comentarios){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO ".tabla_afiliados." (id_usuario, dni, genero, fecha_nacimiento, id_obra_social, "
                . "numero_afiliado, direccion, localidad, telefono, celular, comentarios) "
                . "VALUES (:id, :dni, :genero, :fecha_nacimiento, :id_obra, :num_afi, :direccion, :localidad, :telefono, :celular, :comentarios)"); 
        $query->bindParam(':id', $id);
        $query->bindParam(':dni', $dni);
        $query->bindParam(':genero', $genero);
        $query->bindParam(':fecha_nacimiento', $fecha);
        $query->bindParam(':id_obra', $id_obra);
        $query->bindParam(':num_afi', $num_afi);
        $query->bindParam(':direccion', $direccion);
        $query->bindParam(':localidad', $localidad);
        $query->bindParam(':telefono', $telefono);
        $query->bindParam(':celular', $celular);
        $query->bindParam(':comentarios', $comentarios);

        if ($query->execute()) {
            
            echo '<br><b>Afiliado Persistido con id: '.$id.'</b>';
            return $id;
        } else {
            echo '0';
            return false;
        }
    
    
}

$id_usuario= persistirUsuario($nombre,$apellido,$mail);

if($id_usuario){ //si se persistio el usuario..
    
    persistirAfiliado($id_usuario,$dni,$genero,$fecha_nacimiento,$os,$numAfi,$direccion,$localidad,$telefono,$celular,$comentarios);
    
}

?>

