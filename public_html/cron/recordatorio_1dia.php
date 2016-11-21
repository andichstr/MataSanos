<?php

include_once '../conexiones/configure.php';
include_once '../conexiones/conexion.php';

require '../../PHPMailer-master/PHPMailerAutoload.php';

function recordatorio1dia() {
    $fecha = date('Y-m-d', strtotime('+1 day'));
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("SELECT u.mail, u.nombre, u.apellido, t.horario FROM " . tabla_turnos . " t INNER JOIN " . tabla_usuarios . " u ON (t.id_afiliado=u.id_usuario) WHERE (fecha = :fecha)");
    $query->bindParam(':fecha', $fecha);
    if ($query->execute()) {
        $result = $query->fetchAll();
        if (isset($result) || count($result > 0)) {
            foreach ($result as $row) {
                enviar_mail($row['mail'], $row['nombre'], $row['apellido'], $row['horario']);
            }
        } else {
            echo 'No';
        }
    } else {
        echo 'No Data';
    }
    $con = null;
}

function enviar_mail($email, $nombre, $apellido, $horario) {
    $link = 'http://localhost/MataSanosVistas/public_html/registro.php?token=' . $token;
    $mail = new PHPMailer;
    $mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';
//        'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = user_mail;                 // SMTP username
    $mail->Password = pass_mail;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(user_mail, 'Clínica MataSanos S.A.');
//    $mail->addAddress($email);     // Add a recipient
//$mail->addAddress('gustidaniel@hotmail.com', 'Joe User');     // Add a recipient
//    $mail->addAddress('andi.schus@live.com.ar');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Recordatorio, 1 día para tu turno médico!';
    $mail->Body = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
            . '<h1>Hola!</h1><p>Hola ' . $nombre . ' ' . $apellido . ', desde la Clínica MataSanos S.A., queríamos avisarle que no se olvide de su turno de mañana, a las' . $horario . 'hs. </p>'
            . '<p>No olvide que puede cancelar su turno y/o solicitar uno nuevo en nuestra <a href="http://www.matasanos.com.ar/">Página Web</a>, o simplemente llamándo telefónicamente, al número 011-4545-4545.<p>'
            . '<p>Muchas gracias por elegirnos, y estamos a su entera dispocisión!</p>';

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients. Clínica MataSanos';
    $mail->CharSet = 'UTF-8';
    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 1;
    }
}

recordatorio1dia();
?>
