<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public $server;
    public $auth;
    public $user;
    public $password;
    public $ssl;
    public $port;

    public $asunto;
    public $correos;
    public $cuerpo;

    public function __construct()
    {
        $this->server = MAIL_SERVER;
        $this->auth = MAIL_AUTH;
        $this->user = MAIL_USER;
        $this->password = MAIL_PASSWORD;
        $this->ssl = MAIL_SSL;
        $this->port = MAIL_PORT;
    }

    public function Enviar($asunto, $correos, $cuerpo, $archivosBinary = null){
        $mail = new PHPMailer(false);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->server;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = $this->auth;                               // Enable SMTP authentication
            $mail->Username = $this->user;                 // SMTP username
            $mail->Password = $this->password;                           // SMTP password
            $mail->SMTPSecure = $this->ssl;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->port;
            $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
            for ($e = 0; $e < count($correos); $e++){
                $mail->addAddress($correos[$e]);
            }
            $mail->isHTML(true);// Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->CharSet = 'UTF-8';
            $mail->AltBody = 'No responder';

            if($archivosBinary != null){
                for ($e = 0; $e < count($archivosBinary); $e++){
                    $mail->AddStringAttachment($archivosBinary[$e]['contenido'], $archivosBinary[$e]['nombre'], $archivosBinary[$e]['encoding'], $archivosBinary[$e]['type']);
                }
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}