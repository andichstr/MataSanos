<?php

include_once 'configure.php';
include_once 'conexion.php';
require '../../PHPMailer-master/PHPMailerAutoload.php';


if (isset($_REQUEST['nombre']) && isset($_REQUEST['apellido']) &&
        isset($_REQUEST['dni']) && isset($_REQUEST['genero']) &&
        isset($_REQUEST['fecha_nacimiento']) && isset($_REQUEST['mail']) &&
        isset($_REQUEST['localidad']) && isset($_REQUEST['os']) && isset($_REQUEST['numAfi']) && isset($_REQUEST['direccion']) &&
        isset($_REQUEST['telefono']) && isset($_REQUEST['celular']) && isset($_REQUEST['comentarios'])) {
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $dni = $_REQUEST['dni'];
    $genero = $_REQUEST['genero'];
    $fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
    $mail = $_REQUEST['mail'];
    $os = $_REQUEST['os'];
    $numAfi = $_REQUEST['numAfi'];
    $localidad = $_REQUEST['localidad'];
    $direccion = $_REQUEST['direccion'];
    $telefono = $_REQUEST['telefono'];
    $celular = $_REQUEST['celular'];
    $comentarios = $_REQUEST['comentarios'];
} else {
    echo 'Campos no seteados<br>';
    return false;
}

function persistirUsuario($nombre, $apellido, $mail) {
    $token = generar_token();
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("INSERT INTO " . tabla_usuarios . " (nombre, apellido, mail, id_tipo_usuario, token) VALUES (:nombre, :apellido, :mail, 1, :token)"); //id_tipo_usuario=1 es afiliado
    $query->bindParam(':nombre', $nombre);
    $query->bindParam(':apellido', $apellido);
    $query->bindParam(':mail', $mail);
    $query->bindParam(':token', $token);

    if ($query->execute()) {
        $id = $con->lastInsertId();

        return $id;
    } else {
        echo '0';
        return false;
    }
}

function persistirAfiliado($id, $dni, $genero, $fecha, $id_obra, $num_afi, $direccion, $localidad, $telefono, $celular, $comentarios) {
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("INSERT INTO " . tabla_afiliados . " (id_usuario, dni, genero, fecha_nacimiento, id_obra_social, "
            . "numero_afiliado, direccion, localidad, telefono, celular, comentarios, activo) "
            . "VALUES (:id, :dni, :genero, :fecha_nacimiento, :id_obra, :num_afi, :direccion, :localidad, :telefono, :celular, :comentarios,1)");
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
        enviar_mail($mail, $nombre, $token);

        return $id;
    } else {
        echo '0';
        return false;
    }
}

function generar_token() {
    $micro = microtime();
    $token = md5($micro);
    return $token;
}

$id_usuario = persistirUsuario($nombre, $apellido, $mail);

if ($id_usuario) { //si se persistio el usuario..
    persistirAfiliado($id_usuario, $dni, $genero, $fecha_nacimiento, $os, $numAfi, $direccion, $localidad, $telefono, $celular, $comentarios);
    echo $id_usuario;
}

function enviar_mail($email, $name, $token) {
    $link = 'http://localhost/MataSanosVistas/public_html/registro.php?token=' . $token;
    $mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';
//        'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = user_mail;                 // SMTP username
    $mail->Password = pass_mail;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(user_mail, 'Clínica MataSanos S.A.');
    $mail->addAddress($email);     // Add a recipient
//$mail->addAddress('gustidaniel@hotmail.com', 'Joe User');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Invitación al sistema de Gestión de Turnos';
    $mail->Body = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
            . '<h1>Hola ' . $name . '!</h1><p>Haz sido dada/o de alta en el sistema de Gestión de Turnos de la Clínica MataSanos S.A.</p>'
            . '<p>Para poder iniciar sesión y comenzar a utilizar tu cuenta deberás completar el registro ingresando en la siguiente dirección.<p>'
            . '<p><a href="' . $link . '">' . $link . '</a></p>';

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients. Clínica MataSanos';
    $mail->CharSet = 'UTF-8';
    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 1;
    }
}
?>

