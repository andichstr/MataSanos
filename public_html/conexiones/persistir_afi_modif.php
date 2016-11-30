<?php

include_once 'configure.php';
include_once 'conexion.php';
define('__ROOT__', dirname(dirname(__FILE__)));
include_once(__ROOT__ . '/app/validate_o_actions.php');
include_once(__ROOT__ . '/app/convertir_pass.php');
include_once(__ROOT__ . '/app/validardatos.php');
require_once(__ROOT__ . '/app/Validate.php');

function main() {
    $respuesta = validar_o();
    if ($respuesta != False) {
        if (($_SESSION['roleuser']) == 1 and validar_dat_afi()) {
            $AFILIADO = True;

            $id_usuario = $respuesta;
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $mail = $_POST['mail'];

            if ($_POST['password'] != '') { //si se modifico pass..
                $pass = convert_pass($_POST['password']);
//                echo $pass;
            } else {
                $pass = 0;
            }

            $id_afiliado = persistirUsuario($AFILIADO, $nombre, $apellido, $mail, $pass, $id_usuario, true);

            if ($id_afiliado != False) {
                $genero = $_POST['genero'];
                $fechanac = $_POST['fecha_nacimiento'];
                persistirAfiliado($AFILIADO, $id_usuario, '', $genero, $fechanac, '', '', '', '', '', '', '');
            }
        } elseif (($_SESSION['roleuser']) == 2 and validar_dat_ope()) {
            $AFILIADO = False;

            $id_usuario = $respuesta;
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $mail = $_POST['mail'];
            $mail_m = $_SESSION['mail_m'];
            $id_afiliado = persistirUsuario($AFILIADO, $nombre, $apellido, $mail, '', $id_usuario, $mail_m);

            if ($id_afiliado != False) {
                $dni = $_POST['dni'];
                $genero = $_POST['genero'];
                $fecha_n = $_POST['fecha_nacimiento'];
                $os = $_POST['os'];
                $numAfi = $_POST['numAfi'];
                $direccion = $_POST['direccion'];
                $localidad = $_POST['localidad'];
                $telefono = $_POST['telefono'];
                $celular = $_POST['celular'];
                $comentarios = $_POST['comentarios'];
                persistirAfiliado($AFILIADO, $id_usuario, $dni, $genero, $fecha_n, $os, $numAfi, $direccion, $localidad, $telefono, $celular, $comentarios);
            } else {
                echo 'Ha ocurrido un error al intentar modificar los datos.';
            }
        } else {
            echo 'Se estan ingresando datos no validos. No ingreses caracteres especiales. Revisa el formulario.';
        }
    } else {
        echo '¡¡¡No tienes acceso a modificar los datos!!!';
    }
}

function persistirUsuario($AFILIADO, $nombre, $apellido, $mail, $pass, $id, $mail_m) {
    if ($pass !== 0) {
//        echo 'se crea el set con pass';
        $sqlSet = " SET nombre=:nombre, apellido=:apellido, mail=:mail, password=:pass WHERE id_usuario=:id";
    } else {
//                echo 'se crea el set SIN pass';

        $sqlSet = " SET nombre=:nombre, apellido=:apellido, mail=:mail WHERE id_usuario=:id";
    }


    if ($AFILIADO) {
        $sql = "UPDATE " . tabla_usuarios . $sqlSet;
    } else if (!$AFILIADO) {
        if ($mail_m) {
            $sql = "UPDATE " . tabla_usuarios . " SET nombre=:nombre, apellido=:apellido, mail=:mail WHERE id_usuario=:id";
        } else {
            $sql = "UPDATE " . tabla_usuarios . " SET nombre=:nombre, apellido=:apellido WHERE id_usuario=:id";
        }
    }
    try {
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare($sql);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellido', $apellido);
        if ($mail !== '' and $mail_m == true) {
            $query->bindParam(':mail', $mail);
        }
        if ($pass != '' && $pass !== 0) {
//            echo 'Se bindeo la pass';
            $query->bindParam(':pass', $pass);
        }
        $query->bindParam(':id', $id);

        if ($query->execute()) {
            return $id;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return False;
    }
}

function persistirAfiliado($AFILIADO, $id, $dni, $genero, $fecha, $id_obra, $num_afi, $direccion, $localidad, $telefono, $celular, $comentarios) {
    if ($AFILIADO) {
        $sql = "UPDATE " . tabla_afiliados . " SET genero=:genero, fecha_nacimiento=:fecha_nacimiento WHERE id_usuario=:id";
    } else if (!$AFILIADO) {
        $sql = "UPDATE " . tabla_afiliados . " SET dni=:dni, genero=:genero, fecha_nacimiento=:fecha_nacimiento, id_obra_social=:id_obra, numero_afiliado=:num_afi, direccion=:direccion, localidad=:localidad, telefono=:telefono, celular=:celular, comentarios=:comentarios WHERE id_usuario=:id";
    }
    try {
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare($sql);
        $query->bindParam(':id', $id);
        if ($dni != '') {
            $query->bindParam(':dni', $dni);
        }
        $query->bindParam(':genero', $genero);
        $query->bindParam(':fecha_nacimiento', $fecha);
        if ($id_obra != '') {
            $query->bindParam(':id_obra', $id_obra);
        }
        if ($num_afi != '') {
            $query->bindParam(':num_afi', $num_afi);
        }
        if ($direccion != '') {
            $query->bindParam(':direccion', $direccion);
        }
        if ($localidad != '') {
            $query->bindParam(':localidad', $localidad);
        }
        if ($telefono != '') {
            $query->bindParam(':telefono', $telefono);
        }
        if ($celular != '') {
            $query->bindParam(':celular', $celular);
        }
        if ($comentarios != '') {
            $query->bindParam(':comentarios', $comentarios);
        }

        if ($query->execute()) {
            echo true;
        } else {
            echo false;
        }
    } catch (Exception $e) {
        echo 'Ha ocurrido un error. Intente mas tarde.';
    }
}

main();
?>
