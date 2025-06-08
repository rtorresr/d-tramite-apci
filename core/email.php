<?php
/**
 * Created by PhpStorm.
 * User: anthonywainer
 * Date: 18/12/2018
 * Time: 10:41
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
    $mail->Password = 'Hacker147';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
    //$mail->addAddress('jatayauri@apci.gob.pe', 'Joe User');     // Add a recipient
    for ($e = 0; $e < count($correos); $e++){
        $mail->addAddress($correos[$e]);
    }
                  // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body = $cuerpo;
    // $mail->Body    = '<p>Estimado, <strong>'.$nombres.'</strong>, sus credenciales para ingresar al <strong>Sistema de APCI (D-Trámite)</strong> son los siguientes:</p>';
    // $mail->Body    .= '<dl>';
    // $mail->Body    .= '<dt style="font-weight: 700;">Enlace:</dt><dd style="margin-bottom: .5rem; margin-left: 0;"><a href="'.$url.'" target="_blank" >'.$url.'</a></dd>';
    // $mail->Body    .= '<dt style="font-weight: 700;">Usuario:</dt><dd style="margin-bottom: .5rem; margin-left: 0;"> '.$usuario.' </dd>';
    // $mail->Body    .= '<dt style="font-weight: 700;">Contraseña:</dt><dd style="margin-bottom: .5rem; margin-left: 0;"> '.$password.' </dd>';
    // $mail->Body    .= '<dl>';

    //$mail->Body    .= '<p><img src="'.$url.'/dist/images/logo--sm.png" /></p>';
    $mail->CharSet = 'UTF-8';
    $mail->AltBody = 'No responder';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}