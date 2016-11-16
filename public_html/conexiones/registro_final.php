<?php

include_once 'configure.php';
include_once 'conexion.php';

function buscarAfiliado() {
    if (isset($_REQUEST['dni']) && isset($_REQUEST['mail'])) {
        $dni = $_REQUEST['dni'];
        $mail = $_REQUEST['mail'];


        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("SELECT u.id_usuario, u.password FROM " . tabla_afiliados . " a JOIN " . tabla_usuarios . " u ON a.id_usuario=u.id_usuario WHERE u.mail = :mail AND a.dni=:dni");
        $query->bindParam(':dni', $dni);
        $query->bindParam(':mail', $mail);
        $query->execute();
        $result = $query->fetchAll();

        if (isset($result) && (count($result) != 0)) {
            
            $psw = $result[0]['password'];

            if ($psw!='') {
                return 'Usuario ya registrado!';
            } else {
                $id = $result[0]['id_usuario'];

                return $id;
            }
//       
        } else {
            return 'No hay coincidencias';
        }
        $con = null;
    }
}

echo buscarAfiliado();
