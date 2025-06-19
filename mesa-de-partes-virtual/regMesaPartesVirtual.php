<?php

include_once('config/datosConexion.php');
include_once('config/parametros.php');
include_once("../views/clases/DocDigital.php");
require_once("../views/clases/Email.php");
require_once("../views/clases/Log.php");
require_once('../vendor/autoload.php');

include_once("../core/CURLConection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$nNumAno    = date('Y');
$nNumMes    = date('m');
$nNumDia    = date('d');

switch ($_POST['Evento']) {
    case 'EnviarCodigoValidacion':
        $pin = '';
        $matriz = '0123456789';
        for ($i=0; $i<4; $i++){
            $pin .= substr($matriz,rand(0,9),1);
        }

        $nombres = $_POST['Nombre'];
        $correo = $_POST['Correo'];

        $parametros = array(
            $pin,
            $correo            
        );

        $sqlregistro = "{call UP_REGISTRAR_CODIGO_VALIDACION (?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $asunto = 'Validación de correo electronico - Mesa de partes digital APCI';
        $cuerpo = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#e5f1f8!important">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width">
            <title>'.$asunto.'</title>
            <style>
                @media only screen {
                    html {
                        min-height: 100%;
                        background: #f3f3f3
                    }
                }
        
                @media only screen and (max-width:596px) {
                    .small-float-center {
                        margin: 0 auto !important;
                        float: none !important;
                        text-align: center !important
                    }
                }
        
                @media only screen and (max-width:596px) {
                    table.body img {
                        width: auto;
                        height: auto
                    }
        
                    table.body center {
                        min-width: 0 !important
                    }
        
                    table.body .container {
                        width: 95% !important
                    }
        
                    table.body .columns {
                        height: auto !important;
                        -moz-box-sizing: border-box;
                        -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                        padding-left: 16px !important;
                        padding-right: 16px !important
                    }
        
                        table.body .columns .columns {
                            padding-left: 0 !important;
                            padding-right: 0 !important
                        }
        
                    th.small-1 {
                        display: inline-block !important;
                        width: 8.33333% !important
                    }
        
                    th.small-10 {
                        display: inline-block !important;
                        width: 83.33333% !important
                    }
        
                    th.small-12 {
                        display: inline-block !important;
                        width: 100% !important
                    }
        
                    .columns th.small-12 {
                        display: block !important;
                        width: 100% !important
                    }
        
                    table.menu {
                        width: 100% !important
                    }
        
                        table.menu td, table.menu th {
                            width: auto !important;
                            display: inline-block !important
                        }
        
                        table.menu[align=center] {
                            width: auto !important
                        }
                }
            </style>
        </head>
        <body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#e5f1f8!important;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;padding-top:30px;text-align:left;width:100%!important">
            <span class="preheader" style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span><table class="body" style="Margin:0;background:#e5f1f8!important;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding:0;text-align:left;vertical-align:top">
                    <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        <center data-parsed style="min-width:580px;width:100%">
                            <table align="center" class="container header__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row header" style="background:#001f4a;border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><img src="https://cdn.apci.gob.pe/dist/images/dt__logo.png" alt srcset width="160px" height="48px" class="m-auto" style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><h3 class="title" style="Margin:0;Margin-bottom:10px;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">'.$asunto.'</h3><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify">Estimado(a) '.$nombres.', su código de validación para el registro de su documento en la Mesa de partes digital del <strong>Sistema de Trámite Documentario de la APCI (D-Tramite)</strong> es: </p><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"></p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"></p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table class="callout" style="Margin-bottom:16px;border-collapse:collapse;border-spacing:0;margin-bottom:16px;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th class="callout-inner secondary token" style="Margin:0;background:#bed9ff;border:0 none;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:10px;text-align:left;width:100%"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:0!important;padding-right:0!important;text-align:left;width:100%"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:center"><h1 class="text-center m-0 p-0" style="Margin:0;Margin-bottom:10px;color:#001f4a;font-family:"Courier New",Courier,monospace;font-size:48px;font-weight:700;line-height:1.3;margin:0!important;margin-bottom:10px;padding:0!important;text-align:center;word-wrap:normal">'.$pin.'</h1></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                                <p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"><small><em>* Para finalizar su registro por favor ingrese el código de validación (PIN) en la pantalla de registro.</p></th></tr></table></th></tr></tbody></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></td></tr></tbody></table><table align="center" class="container footer__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
                                <tbody>
                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                            <table bgcolor="#eaeaea" class="wrapper footer" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                <tr style="padding:0;text-align:left;vertical-align:top">
                                                    <td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                        <table class="row footer text-center" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="footer__item footer_1 small-12 large-3 columns first" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:8px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="8px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:8px;font-weight:400;hyphens:auto;line-height:8px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><img src="http://cdn.apci.gob.pe/dist/images/apci__logo--large--color.png" alt width="150px" height="55px" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="8px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:8px;font-weight:400;hyphens:auto;line-height:8px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th></tr></table></th><th class="footer__item footer_1 small-12 large-3 columns" valign="bottom" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#515151;font-family:Helvetica,Arial,sans-serif;font-size:80%;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><a href="https://goo.gl/maps/okU3vgEAtUp5vaYcA" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">Av. José Pardo 261,<br>Miraflores 15074, Lima, Perú</a></p></th></tr></table></th><th class="footer__item footer_1 small-12 large-3 columns last" valign="bottom" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#515151;font-family:Helvetica,Arial,sans-serif;font-size:80%;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><a href="tel:+5116173600" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">(511) 617-3600</a><br><a href="mailto:d-tramite@apci.gob.pe" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">d-tramite@apci.gob.pe</a></p></th></tr></table></th></tr></tbody></table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table bgcolor="#fefefe" class="wrapper" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-1 large-1 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:8px;text-align:left;width:32.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"></th></tr></table></th><th class="small-10 large-10 columns" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:467.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><center data-parsed style="min-width:435.33px;width:100%"><table align="center" class="menu float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:auto!important"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:10px;padding-right:10px;text-align:center"><a href="http://www.peru.gob.pe" style="Margin:0;color:#9bd8ff;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><img class="small-float-center" width="<th class="small-1 large-1 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:32.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"></th></tr></table></th></tr></tbody></table><table class="row footer__pos" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                                <tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><center data-parsed style="min-width:532px;width:100%"><small align="center" class="float-center" style="color:#cacaca;font-size:80%">Toda la información contenida en este mensaje es confidencial y de uso exclusivo de usuarios del D-Trámite de la APCI. Si ha recibido este mensaje por error, por favor proceda a eliminarlo y notificar al remitente.</small></center></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                        </center>
                    </td>
                </tr>
            </table><div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
        </body>
        </html>';

        $correos = [];
        array_push($correos,$correo);

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = MAIL_SERVER;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = MAIL_AUTH;                               // Enable SMTP authentication
            $mail->Username = MAIL_USER;                 // SMTP username
            $mail->Password = MAIL_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = MAIL_SSL;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = MAIL_PORT;
            $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
            for ($e = 0; $e < count($correos); $e++){
                $mail->addAddress($correos[$e]);
            }
            $mail->isHTML(true);// Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->CharSet = 'UTF-8';
            $mail->AltBody = 'No responder';

            $mail->send();
        } catch (Exception $e) {
            http_response_code(500);
            die(print_r('Error al enviar el correo.'));
        }
        break;

    case 'RegistrarDocumento':
        if($_POST['ID_TUPA'] == 44){
            $agrupado = '363'.'318'.date("YmdGis");

            $docDigital = new DocDigital($cnx);
            $docDigital->idTipo = 12;
            $docDigital->idOficina = 363;
            $docDigital->idTrabajador = 318;
            $docDigital->grupo = $agrupado;

            $archivoPrincipal = $_FILES['ARCHIVO_PRINCIPAL_PROCESO'];
            $arrayExploded = explode('.',$archivoPrincipal['name']);
            if (strtoupper(array_pop($arrayExploded)) == 'PDF') {
                $docDigital->tmp_name = $archivoPrincipal['tmp_name'];
                $docDigital->name = $archivoPrincipal['name'];
                $docDigital->type = $archivoPrincipal['type'];
                $docDigital->size = $archivoPrincipal['size'];

                if(!$docDigital->subirDocumento()){
                    http_response_code(500);
                    die(print_r('Error al guardar el archivo principal.'));
                }

                $parametros = array(
                    $_POST['ID_TIPO_ENTIDAD'],
                    $_POST['ID_TIPO_DOC_ENTIDAD'],
                    $_POST['NUM_DOC_ENTIDAD'],
                    $_POST['NOM_ENTIDAD'],
                    $_POST['NOM_RESPONSABLE'],

                    $_POST['DESC_PROCESO'],
                    354, // OFICINA DERIVAR
                    $_POST['CORREO_CONTACTO'],
                    $_POST['PIN'],
                    $docDigital->idDocDigital
                );

                $sqlregistro = "{call USP_INGRESO_TRAMITE_DERIVA_CONVOCATORIA_CAS (?,?,?,?,?,?,?,?,?,?) }";

                $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
                if($rsregistro === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors(), true));
                    die(print_r('Error al registrar el documento.'));
                }
            }
        } else {
            $parametros = array(
                $_POST['ID_TIPO_ENTIDAD'],
                $_POST['ID_TIPO_DOC_ENTIDAD'],
                $_POST['NUM_DOC_ENTIDAD'],
                $_POST['NOM_ENTIDAD'],
                $_POST['ID_TIPO_DOC_RESPONSABLE'],
                $_POST['DNI_RESPONSABLE'],
                $_POST['NOM_RESPONSABLE'],
                $_POST['DIRECCION_ENTIDAD'],
                $_POST['ID_DEPARTEMENTO'],
                $_POST['ID_PROVINCIA'],
                $_POST['ID_DISTRITO'],
                $_POST['TELEFONO_CONTACTO'],            
                $_POST['CORREO_CONTACTO'],
                $_POST['FLG_TIENE_CUD'],
                $_POST['NRO_CUD'],
                $_POST['ANIO_CUD'],
                $_POST['ID_TIPO_DOC'],
                $_POST['NUMERO_DOC'],
                $_POST['FEC_DOC'],
                $_POST['FOLIOS'],
                $_POST['ASUNTO'],
                $_POST['FLG_ES_TUPA'],
                $_POST['ID_TIPO_PROCEDIMIENTO'],
                $_POST['ID_TUPA'],
                $_POST['FLG_SIGCTI'],
                $_POST['NRO_SOLICITUD_SIGCTI'],
                $_POST['ID_SIGCTI'],
                $_POST['PIN']
            );

            $sqlregistro = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
            $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
            if($rsregistro === false) {
                http_response_code(500);
                die(print_r('Error al registrar el documento.'));
            }

            $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

            if ($Rsregistro["CODIGO"] == 0){
                http_response_code(500);
                die(print_r($Rsregistro["MENSAJE"]));
            }

            $idRegistroMesaPartes = $Rsregistro["CODIGO"];

            $agrupado = date("Gis").$idRegistroMesaPartes;

            $datos = new stdClass();

            $docDigital = new DocDigital($cnx);
            $docDigital->idTipo = 12;
            $docDigital->idOficina = 0;
            $docDigital->idTrabajador = 0;
            $docDigital->grupo = $agrupado;

            $archivoPrincipal = $_FILES['ARCHIVO_PRINCIPAL'];
            $arrayExploded = explode('.',$archivoPrincipal['name']);
            if (strtoupper(array_pop($arrayExploded)) == 'PDF') {
                $docDigital->tmp_name = $archivoPrincipal['tmp_name'];
                $docDigital->name = $archivoPrincipal['name'];
                $docDigital->type = $archivoPrincipal['type'];
                $docDigital->size = $archivoPrincipal['size'];

                $docDigital->clearName = $docDigital::formatearNombre($docDigital->name,true,[' ']);
                if (!$docDigital::validarFormato($docDigital::obternerExtension($docDigital->clearName))){
                    throw new \Exception('Formato no aceptado');
                }

                if($docDigital->cargarDocumento()){
                    $ruta = $docDigital::rutaCarpetas($docDigital).$docDigital->clearName;
                    $parametrosDocPrincipal = array(
                        $idRegistroMesaPartes,
                        5,
                        $archivoPrincipal['name'],
                        $ruta
                    );
                
                    $sqlDocPrincipal = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
                    $rsDocPrincipal = sqlsrv_query($cnx, $sqlDocPrincipal, $parametrosDocPrincipal);
                    if($rsDocPrincipal === false) {
                        http_response_code(500);
                        die(print_r('Error al registrar el archivo principal.'));
                    }
                } else {
                    http_response_code(500);
                    die(print_r('Error al guardar el archivo principal.'));
                }
            }
            
            if (isset($_FILES['ANEXOS'])){
                for($i = 0; $i < count($_FILES['ANEXOS']['name']); $i++){
                    $docDigital->idDocDigital = null;
                    $docDigital->idTramite = null;
                    $docDigital->path = null;     

                    $docDigital->tmp_name = $_FILES['ANEXOS']['tmp_name'][$i];
                    $docDigital->name = $_FILES['ANEXOS']['name'][$i];
                    $docDigital->type = $_FILES['ANEXOS']['type'][$i];
                    $docDigital->size = $_FILES['ANEXOS']['size'][$i];

                    $docDigital->clearName = $docDigital::formatearNombre($docDigital->name,true,[' ']);
                    $docDigital->path = '';

                    if (!$docDigital::validarFormato($docDigital::obternerExtension($docDigital->clearName))){
                        throw new \Exception('Formato no aceptado');
                    }

                    if($docDigital->cargarDocumento()){
                        $ruta = $docDigital::rutaCarpetas($docDigital).$docDigital->clearName;
                        $parametrosAnexos = array(
                            $idRegistroMesaPartes,
                            3,
                            $_FILES['ANEXOS']['name'][$i],
                            $ruta
                        );
                
                        $sqlDocAnexo = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
                        $rsDocAnexo = sqlsrv_query($cnx, $sqlDocAnexo, $parametrosAnexos);
                        if($rsDocAnexo === false) {                        
                            http_response_code(500);
                            die(print_r('Error al registrar el anexo'.$_FILES['ANEXOS']['name'][$i].'.'));
                        }
                    } else {
                        http_response_code(500);
                        die(print_r('Error al guardar el anexo'.$_FILES['ANEXOS']['name'][$i].'.'));
                    }           
                }
            }

            if (isset($_POST['ANEXOS_SIGCTI'])){
                for($i = 0; $i < count($_POST['ANEXOS_SIGCTI']); $i++){
                    
                    $item = json_decode($_POST['ANEXOS_SIGCTI'][$i]);
                    $parametrosAnexos = array(
                        $idRegistroMesaPartes,
                        3,
                        $item->original,
                        $item->nuevo
                    );
            
                    $sqlDocAnexo = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
                    $rsDocAnexo = sqlsrv_query($cnx, $sqlDocAnexo, $parametrosAnexos);
                    if($rsDocAnexo === false) {                        
                        http_response_code(500);
                        die(print_r('Error al registrar el anexo'.$item->original.'.'));
                    }
                }
            }
        }
        
        if ($_POST['ID_TIPO_ENTIDAD'] == 62){
            $nombres = $_POST['NOM_ENTIDAD'];
        } else {
            $nombres = $_POST['NOM_RESPONSABLE'];
        }

        $correo = $_POST['CORREO_CONTACTO'];

        $asunto = 'Confirmación de Registro - Mesa de partes digital APCI';
        $cuerpo = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#e5f1f8!important">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width">
            <title>'.$asunto.'</title>
            <style>
                @media only screen {
                    html {
                        min-height: 100%;
                        background: #f3f3f3
                    }
                }
        
                @media only screen and (max-width:596px) {
                    .small-float-center {
                        margin: 0 auto !important;
                        float: none !important;
                        text-align: center !important
                    }
                }
        
                @media only screen and (max-width:596px) {
                    table.body img {
                        width: auto;
                        height: auto
                    }
        
                    table.body center {
                        min-width: 0 !important
                    }
        
                    table.body .container {
                        width: 95% !important
                    }
        
                    table.body .columns {
                        height: auto !important;
                        -moz-box-sizing: border-box;
                        -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                        padding-left: 16px !important;
                        padding-right: 16px !important
                    }
        
                        table.body .columns .columns {
                            padding-left: 0 !important;
                            padding-right: 0 !important
                        }
        
                    th.small-1 {
                        display: inline-block !important;
                        width: 8.33333% !important
                    }
        
                    th.small-10 {
                        display: inline-block !important;
                        width: 83.33333% !important
                    }
        
                    th.small-12 {
                        display: inline-block !important;
                        width: 100% !important
                    }
        
                    .columns th.small-12 {
                        display: block !important;
                        width: 100% !important
                    }
        
                    table.menu {
                        width: 100% !important
                    }
        
                        table.menu td, table.menu th {
                            width: auto !important;
                            display: inline-block !important
                        }
        
                        table.menu[align=center] {
                            width: auto !important
                        }
                }
            </style>
        </head>
        <body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#e5f1f8!important;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;padding-top:30px;text-align:left;width:100%!important">
            <span class="preheader" style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span><table class="body" style="Margin:0;background:#e5f1f8!important;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding:0;text-align:left;vertical-align:top">
                    <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        <center data-parsed style="min-width:580px;width:100%">
                            <table align="center" class="container header__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:610px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row header" style="background:#001f4a;border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                        <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                            <tbody>
                                                <tr style="padding:0;text-align:left;vertical-align:top">
                                                    <td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <img src="https://cdn.apci.gob.pe/dist/images/dt__logo.png" alt srcset width="160px" height="48px" class="m-auto" style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><h3 class="title" style="Margin:0;Margin-bottom:10px;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">'.$asunto.'</h3><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify">Estimado(a) '.$nombres.', su documento ha sido registrado satisfactoriamente en la la Mesa de partes digital del <strong>Sistema de Trámite Documentario de la APCI (D-Tramite)</strong>, se le enviará un correo de confirmación cuando el expediente haya sido recepcionado.</p>
                                            <p><small><strong>Nota: La constancia de presentación no implica la conformidad a la documentación presentada, en tanto está sujeta a la revisión del personal de la Mesa de Partes de la APCI.</strong></small></p>
                                <p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"></p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"></p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                            </th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                                <tbody>
                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                            <table bgcolor="#eaeaea" class="wrapper footer" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                <tr style="padding:0;text-align:left;vertical-align:top">
                                                    <td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                        <table class="row footer text-center" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="footer__item footer_1 small-12 large-3 columns first" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:8px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="8px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:8px;font-weight:400;hyphens:auto;line-height:8px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><img src="http://cdn.apci.gob.pe/dist/images/apci__logo--large--color.png" alt width="150px" height="55px" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="8px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:8px;font-weight:400;hyphens:auto;line-height:8px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th></tr></table></th><th class="footer__item footer_1 small-12 large-3 columns" valign="bottom" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#515151;font-family:Helvetica,Arial,sans-serif;font-size:80%;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><a href="https://goo.gl/maps/okU3vgEAtUp5vaYcA" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">Av. José Pardo 261,<br>Miraflores 15074, Lima, Perú</a></p></th></tr></table></th><th class="footer__item footer_1 small-12 large-3 columns last" valign="bottom" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#515151;font-family:Helvetica,Arial,sans-serif;font-size:80%;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><a href="tel:+5116173600" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">(511) 617-3600</a><br><a href="mailto:d-tramite@apci.gob.pe" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">d-tramite@apci.gob.pe</a></p></th></tr></table></th></tr></tbody></table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table bgcolor="#fefefe" class="wrapper" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-1 large-1 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:8px;text-align:left;width:32.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"></th></tr></table></th><th class="small-10 large-10 columns" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:467.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><center data-parsed style="min-width:435.33px;width:100%"><table align="center" class="menu float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:auto!important"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:10px;padding-right:10px;text-align:center"><a href="http://www.peru.gob.pe" style="Margin:0;color:#9bd8ff;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><img class="small-float-center" width="<th class="small-1 large-1 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:32.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"></th></tr></table></th></tr></tbody></table><table class="row footer__pos" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                                <tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><center data-parsed style="min-width:532px;width:100%"><small align="center" class="float-center" style="color:#cacaca;font-size:80%">Toda la información contenida en este mensaje es confidencial y de uso exclusivo de usuarios del D-Trámite de la APCI. Si ha recibido este mensaje por error, por favor proceda a eliminarlo y notificar al remitente.</small></center></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                        </center>
                    </td>
                </tr>
            </table><div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
        </body>
        </html>';

        $correos = [];
        array_push($correos,$correo);

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = MAIL_SERVER;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = MAIL_AUTH;                               // Enable SMTP authentication
            $mail->Username = MAIL_USER;                 // SMTP username
            $mail->Password = MAIL_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = MAIL_SSL;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = MAIL_PORT;
            $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
            for ($e = 0; $e < count($correos); $e++){
                $mail->addAddress($correos[$e]);
            }
            $mail->isHTML(true);// Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->CharSet = 'UTF-8';
            $mail->AltBody = 'No responder';
            $mail->send();
        } catch (Exception $e) {            
            http_response_code(500);
            die(print_r('Error al enviar el correo de confirmación.'));
        }

        break;	

    case 'SubsanarDocumento':
        $parametros = array(
            $_POST['ID_MESA_PARTES_VIRTUAL'],
            $_POST['ID_TIPO_ENTIDAD'],
            $_POST['ID_TIPO_DOC_ENTIDAD'],
            $_POST['NUM_DOC_ENTIDAD'],
            $_POST['NOM_ENTIDAD'],
            $_POST['ID_TIPO_DOC_RESPONSABLE'],
            $_POST['DNI_RESPONSABLE'],
            $_POST['NOM_RESPONSABLE'],
            $_POST['DIRECCION_ENTIDAD'],
            $_POST['ID_DEPARTEMENTO'],
            $_POST['ID_PROVINCIA'],
            $_POST['ID_DISTRITO'],
            $_POST['TELEFONO_CONTACTO'],            
            $_POST['CORREO_CONTACTO'],
            $_POST['FLG_TIENE_CUD'],
            $_POST['NRO_CUD'],
            $_POST['ANIO_CUD'],
            $_POST['ID_TIPO_DOC'],
            $_POST['NUMERO_DOC'],
            $_POST['FEC_DOC'],
            $_POST['FOLIOS'],
            $_POST['ASUNTO'],
            $_POST['FLG_ES_TUPA'],
            $_POST['ID_TIPO_PROCEDIMIENTO'],
            $_POST['ID_TUPA'],
            json_encode(isset($_POST['ANEXOS_ANTERIORES']) ? $_POST['ANEXOS_ANTERIORES'] : array())
        );

        $sqlregistro = "{call UP_SUBSANAR_MESA_PARTES_VIRTUAL (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            http_response_code(500);
            die(print_r('Error al registrar el documento.'));
        }

        $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

        if ($Rsregistro["CODIGO"] == 0){
            http_response_code(500);
            die(print_r($Rsregistro["MENSAJE"]));
        }

        $idRegistroMesaPartes = $_POST['ID_MESA_PARTES_VIRTUAL'];

        $agrupado = date("Gis").$idRegistroMesaPartes;
        
        $datos = new stdClass();

        $docDigital = new DocDigital($cnx);
        $docDigital->idTipo = 12;
        $docDigital->idOficina = 0;
        $docDigital->idTrabajador = 0;
        $docDigital->grupo = $agrupado;

        if(isset($_FILES['ARCHIVO_PRINCIPAL'])){
            $archivoPrincipal = $_FILES['ARCHIVO_PRINCIPAL'];
            $arrayExploded = explode('.',$archivoPrincipal['name']);
            if (strtoupper(array_pop($arrayExploded)) == 'PDF') {
                $docDigital->tmp_name = $archivoPrincipal['tmp_name'];
                $docDigital->name = $archivoPrincipal['name'];
                $docDigital->type = $archivoPrincipal['type'];
                $docDigital->size = $archivoPrincipal['size'];

                $docDigital->clearName = $docDigital::formatearNombre($docDigital->name,true,[' ']);
                if (!$docDigital::validarFormato($docDigital::obternerExtension($docDigital->clearName))){
                    throw new \Exception('Formato no aceptado');
                }

                if($docDigital->cargarDocumento()){
                    $ruta = $docDigital::rutaCarpetas($docDigital).$docDigital->clearName;
                    $parametrosDocPrincipal = array(
                        $idRegistroMesaPartes,
                        5,
                        $_FILES['ARCHIVO_PRINCIPAL']['name'],
                        $ruta
                    );
            
                    $sqlDocPrincipal = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
                    $rsDocPrincipal = sqlsrv_query($cnx, $sqlDocPrincipal, $parametrosDocPrincipal);
                    if($rsDocPrincipal === false) {
                        http_response_code(500);
                        die(print_r('Error al registrar el archivo principal.'));
                    }
                } else {
                    http_response_code(500);
                    die(print_r('Error al guardar el archivo principal.'));
                }
            }        
        }

        if (isset($_FILES['ANEXOS'])){
            for($i = 0; $i < count($_FILES['ANEXOS']['name']); $i++){
                $docDigital->idDocDigital = null;
                $docDigital->idTramite = null;
                $docDigital->path = null;    
                
                $docDigital->tmp_name = $_FILES['ANEXOS']['tmp_name'][$i];
                $docDigital->name = $_FILES['ANEXOS']['name'][$i];
                $docDigital->type = $_FILES['ANEXOS']['type'][$i];
                $docDigital->size = $_FILES['ANEXOS']['size'][$i];

                $docDigital->clearName = $docDigital::formatearNombre($docDigital->name,true,[' ']);
                $docDigital->path = '';
                
                if (!$docDigital::validarFormato($docDigital::obternerExtension($docDigital->clearName))){
                    throw new \Exception('Formato no aceptado');
                }

                if($docDigital->cargarDocumento()){
                    $ruta = $docDigital::rutaCarpetas($docDigital).$docDigital->clearName;
                    $parametrosAnexos = array(
                        $idRegistroMesaPartes,
                        3,
                        $_FILES['ANEXOS']['name'][$i],
                        $ruta
                    );
            
                    $sqlDocAnexo = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
                    $rsDocAnexo = sqlsrv_query($cnx, $sqlDocAnexo, $parametrosAnexos);
                    if($rsDocAnexo === false) {                        
                        http_response_code(500);
                        die(print_r('Error al registrar el anexo'.$_FILES['ANEXOS']['name'][$i].'.'));
                    }
                } else {
                    http_response_code(500);
                    die(print_r('Error al guardar el anexo'.$_FILES['ANEXOS']['name'][$i].'.'));
                }
                                
            }
        }

        // if (isset($_POST['ANEXOS_SIGCTI'])){
        //     for($i = 0; $i < count($_POST['ANEXOS_SIGCTI']); $i++){
                
        //         $item = json_decode($_POST['ANEXOS_SIGCTI'][$i]);
        //         $parametrosAnexos = array(
        //             $idRegistroMesaPartes,
        //             3,
        //             $item->original,
        //             $item->nuevo
        //         );
        
        //         $sqlDocAnexo = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
        //         $rsDocAnexo = sqlsrv_query($cnx, $sqlDocAnexo, $parametrosAnexos);
        //         if($rsDocAnexo === false) {                        
        //             http_response_code(500);
        //             die(print_r('Error al registrar el anexo'.$item->original.'.'));
        //         }              
        //     }
        // }

        break;	

    case "ObtenerDatosDNI":
        $url = RUTA_SERVICIOS_PIDE."/ApiPide/token";
        $data = array(
            "UserName" =>  USUARIO,
            "Password" =>   PASSWORD,
            "grant_type" => GRANT_TYPE
        );

        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($client, CURLOPT_POST, true);
        curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = json_decode(curl_exec($client));

        $urlRENIEC = RUTA_SERVICIOS_PIDE."/ApiPide/Api/Reniec/REC_GET_0001?dni=".$_POST["DNI"];
        $clientRENIEC = curl_init();
        curl_setopt($clientRENIEC, CURLOPT_URL, $urlRENIEC);
        curl_setopt($clientRENIEC,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($clientRENIEC, CURLOPT_HTTPHEADER, array(
            'Authorization: '.$response->token_type.' '. $response->access_token
        ));
        $responseRENIEC = json_decode(curl_exec($clientRENIEC));

        $nombre = null;
        $nombreCorto = null;
        $direccion = null;
        $direccionCorto = null;
        $ubigeo = null;

        if($responseRENIEC->EntityResult != null){
            $data = $responseRENIEC->EntityResult;

                $nombreReducido = substr($data->Nombres, 0, 1); 
                $PaternoReducido = substr($data->Paterno, 0, 1); 
                $MaternoReducido = substr($data->Materno, 0, 1); 
                $nombreCompletoConAsterisco = $nombreReducido . ' *****';
                $paternoConAsterisco = $PaternoReducido . ' *****';
                $maternoConAsterisco = $MaternoReducido . ' *****';
                //LA DIRECCION MUESTRA LA INICIAL Y LO DEMAS CON *
                $direccionOriginal = $data->Direccion;
                $palabras = explode(' ', $direccionOriginal);
                $direccionReducida = '';
                foreach ($palabras as $palabra) {
                    if (strlen($palabra) > 0) {
                        $direccionReducida .= strtoupper($palabra[0]) . str_repeat('*', strlen($palabra) - 1) . ' ';
                    }
                }
                $DireccionReducidoConAsterisco = trim($direccionReducida); 

            //esto es para que registre
            $nombre = '<label for="txtNombComp">Nombre completo</label><input class="form-control" id="txtNombComp" type="text" placeholder="Ej. JUAN SOTO SANCHEZ" disabled="disabled" required value="'.$data->Nombres.' '.$data->Paterno.' '.$data->Materno.'">';
            $direccion = '<label for="txtDireccion">Dirección</label>
            <input class="form-control" id="txtDireccion" type="text" placeholder="Ej. Calle Los Girasoles 123 Int. 11, Piso 4" required value="'.$data->Direccion.'">
            <div class="invalid-feedback">
                Por favor, ingrese la dirección.
            </div>';

            //esto para que muestre
            $nombreCorto = '<label for="txtNombCompCorto">Nombre completo</label><input class="form-control" id="txtNombCompCorto" type="text" placeholder="Ej. JUAN SOTO SANCHEZ" disabled="disabled" required value="'.$nombreCompletoConAsterisco.' '.$paternoConAsterisco.' '.$maternoConAsterisco.'">';
            $direccionCorto = '<label for="txtDireccion">Dirección</label>
            <input class="form-control" id="txtDireccion" type="text" placeholder="Ej. Calle Los Girasoles 123 Int. 11, Piso 4" required value="'.$DireccionReducidoConAsterisco.'" disabled="disabled">
            <div class="invalid-feedback">
                Por favor, ingrese la dirección.
            </div>';
            $ubigeo = $data->Ubigeo;
        }elseif($responseRENIEC->EntityResult['direccion'] == null 
            || $responseRENIEC->EntityResult['direccionCorto'] == null
            || $responseRENIEC->EntityResult['nombre'] == null
            || $responseRENIEC->EntityResult['nombreCorto'] == null
            || $responseRENIEC->EntityResult['ubigeo'] == null
            ) {
                $nombre = '<label for="txtNombComp">Nombre completo</label><input class="form-control" id="txtNombComp" type="text" placeholder="Ingrese su nombre completo" required value="">';
                $nombreCorto = '<label for="txtNombCompCorto">Nombre completo</label><input class="form-control" id="txtNombCompCorto" type="text" placeholder="Ej. JUAN SOTO SANCHEZ" disabled="disabled" required value="123">';
                $direccion = '<label for="txtDireccion">Dirección</label>
                <input class="form-control" id="txtDireccion" type="text" placeholder="Ej. Calle Los Girasoles 123 Int. 11, Piso 4" required value="">
                <div class="invalid-feedback">
                    Por favor, ingrese la dirección.
                </div>';
                $direccionCorto = '<label for="txtDireccionCorto">Dirección</label>
                <input class="form-control" id="txtDireccionCorto" type="text" placeholder="Ej. Calle Los Girasoles 123 Int. 11, Piso 4" required value="" disabled="disabled">
                <div class="invalid-feedback">
                    Por favor, ingrese la dirección.
                </div>';
                $ubigeo = "";
        } else {
                $nombre = '<label for="txtNombComp">Nombre completo</label><input class="form-control" id="txtNombComp" type="text" placeholder="Ingrese su nombre completo" required value="">';
                $nombreCorto = '<label for="txtNombCompCorto">Nombre completo</label><input class="form-control" id="txtNombCompCorto" type="text" placeholder="Ej. JUAN SOTO SANCHEZ" disabled="disabled" required value="123">';
                $direccion = '<label for="txtDireccion">Dirección</label>
                <input class="form-control" id="txtDireccion" type="text" placeholder="Ej. Calle Los Girasoles 123 Int. 11, Piso 4" required value="">
                <div class="invalid-feedback">
                    Por favor, ingrese la dirección.
                </div>';
                $direccionCorto = '<label for="txtDireccionCorto">Dirección</label>
                <input class="form-control" id="txtDireccionCorto" type="text" placeholder="Ej. Calle Los Girasoles 123 Int. 11, Piso 4" required value="" disabled="disabled">
                <div class="invalid-feedback">
                    Por favor, ingrese la dirección.
                </div>';
                $ubigeo = "";
        }

        $obtRes = new stdClass();
        $obtRes->nombre = $nombre;
        $obtRes->nombreCorto = $nombreCorto;
        $obtRes->direccion = $direccion;
        $obtRes->direccionCorto = $direccionCorto;
        $obtRes->ubigeo = $ubigeo;

        echo json_encode($obtRes);
        break;

    case "ObtenerDatosRUC":
        $url = RUTA_SERVICIOS_PIDE."/ApiPide/token";
        $data = array(
            "UserName" =>  USUARIO,
            "Password" =>   PASSWORD,
            "grant_type" => GRANT_TYPE
        );

        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($client, CURLOPT_POST, true);
        curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = json_decode(curl_exec($client));

        $urlSUNAT = RUTA_SERVICIOS_PIDE."/ApiPide/Api/Sunat/".$_POST["RUC"]."/DatosPrincipales";
        $clientSUNAT = curl_init();
        curl_setopt($clientSUNAT, CURLOPT_URL, $urlSUNAT);
        curl_setopt($clientSUNAT,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($clientSUNAT, CURLOPT_HTTPHEADER, array(
            'Authorization: '.$response->token_type.' '. $response->access_token
        ));
        $responseSUNAT = json_decode(curl_exec($clientSUNAT));

        $denominacion = null;

        if ($responseSUNAT->Success) {
            $data = $responseSUNAT->EntityResult;

            $denominacion = '<label for="txtDenInst">Denominación</label>
            <input class="form-control" id="txtDenInst" type="text" placeholder="Ej. Caritas Arquidiocesana de Huancayo" disabled="disabled" value="'.str_replace('"', '', trim($data->ddp_nombre)).'">';           
        }

        $obtRes = new stdClass();
        $obtRes->denominacion = $denominacion;

        echo json_encode($obtRes);
        break;


    case "ObtenerDatosConstancia":
        $url = RUTA_SERVICIOS_PIDE."/ApiPide/token";
        $data = array(
            "UserName" =>  USUARIO,
            "Password" =>   PASSWORD,
            "grant_type" => GRANT_TYPE
        );

        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($client, CURLOPT_POST, true);
        curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = json_decode(curl_exec($client));

        $urlCons = RUTA_SERVICIOS_PIDE."/ApiD-Tramite/Api/Tramite/TRA_GET_0002?id=".$_POST["NumSol"];
        $clientCons = curl_init();
        curl_setopt($clientCons, CURLOPT_URL, $urlCons);
        curl_setopt($clientCons,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($clientCons, CURLOPT_HTTPHEADER, array(
            'Authorization: '.$response->token_type.' '. $response->access_token
        ));
        $responseCons = json_decode(curl_exec($clientCons));

        $data = '';
        if ($responseCons->Success) {
            $data = $responseCons->EntityResult;
        }
        
        $obtRes = new stdClass();
        $obtRes->data = $data;
        $obtRes->mensaje = $responseCons->MessageResult;

        echo json_encode($obtRes);
        break;
    case 'EnviarSolicitudNuevoTramite':        
        $nombres = $_POST["Nombre"];
        $telefono = $_POST["Telefono"];
        $correo = $_POST["Correo"];
        $nuevoTramite = $_POST["NuevoTramite"];

        $datos = new stdClass();

        $docDigital = new DocDigital($cnx);
        $docDigital->idTipo = 13;
        $docDigital->idOficina = 0;
        $docDigital->idTrabajador = 0;
        $docDigital->grupo = date("Gis");
        $docDigital->sesion = 0;

        $archivoPrincipal = $_FILES['ArchivoPrincipalNuevoTipo'];

        if (strtoupper(DocDigital::obternerExtension($archivoPrincipal['name'])) == 'PDF') {
            $docDigital->tmp_name = $archivoPrincipal['tmp_name'];
            $docDigital->name = $archivoPrincipal['name'];
            $docDigital->type = $archivoPrincipal['type'];
            $docDigital->size = $archivoPrincipal['size'];

            if(!$docDigital->subirDocumentoSecundario()){
                http_response_code(500);
                die(print_r('No se pudo guardar el archivo principal.'));
            }
        } else {
            http_response_code(500);
            die(print_r('No se puede registrar el archivo principal, debe ser del tipo PDF.'));
        }

        $parametros = array(            
            $telefono,
            $correo,
            $nombres,
            $nuevoTramite,
            $docDigital->idDocDigital
        );

        $sqlregistro = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_SOLICITUD_NUEVO_TRAMITE (?,?,?,?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            http_response_code(500);
            die(print_r('Error al registrar el documento.'));
        }

        $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

        if ($Rsregistro["CODIGO"] == 0){
            http_response_code(500);
            die(print_r($Rsregistro["MENSAJE"]));
        } 

        $asunto = 'Solicitud de Registro de Nuevo Tipo de Trámite - Mesa de partes digital APCI';

        $cuerpo = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#e5f1f8!important">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width">
            <title>'.$asunto.'</title>
            <style>
                @media only screen {
                    html {
                        min-height: 100%;
                        background: #f3f3f3
                    }
                }
        
                @media only screen and (max-width:596px) {
                    .small-float-center {
                        margin: 0 auto !important;
                        float: none !important;
                        text-align: center !important
                    }
                }
        
                @media only screen and (max-width:596px) {
                    table.body img {
                        width: auto;
                        height: auto
                    }
        
                    table.body center {
                        min-width: 0 !important
                    }
        
                    table.body .container {
                        width: 95% !important
                    }
        
                    table.body .columns {
                        height: auto !important;
                        -moz-box-sizing: border-box;
                        -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                        padding-left: 16px !important;
                        padding-right: 16px !important
                    }
        
                        table.body .columns .columns {
                            padding-left: 0 !important;
                            padding-right: 0 !important
                        }
        
                    th.small-1 {
                        display: inline-block !important;
                        width: 8.33333% !important
                    }
        
                    th.small-10 {
                        display: inline-block !important;
                        width: 83.33333% !important
                    }
        
                    th.small-12 {
                        display: inline-block !important;
                        width: 100% !important
                    }
        
                    .columns th.small-12 {
                        display: block !important;
                        width: 100% !important
                    }
        
                    table.menu {
                        width: 100% !important
                    }
        
                        table.menu td, table.menu th {
                            width: auto !important;
                            display: inline-block !important
                        }
        
                        table.menu[align=center] {
                            width: auto !important
                        }
                }
            </style>
        </head>
        <body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#e5f1f8!important;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;padding-top:30px;text-align:left;width:100%!important">
            <span class="preheader" style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span><table class="body" style="Margin:0;background:#e5f1f8!important;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding:0;text-align:left;vertical-align:top">
                    <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        <center data-parsed style="min-width:580px;width:100%">
                            <table align="center" class="container header__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row header" style="background:#001f4a;border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><img src="https://cdn.apci.gob.pe/dist/images/dt__logo.png" alt srcset width="160px" height="48px" class="m-auto" style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><h3 class="title" style="Margin:0;Margin-bottom:10px;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">'.$asunto.'</h3><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify">Estimados señores de Mesa de Partes de la APCI, se ha solicitado el registro del nuevo tipo de trámite por parte del administrado <b>'.$nombres.' </b> con teléfono '.$telefono.' y correo '.$correo.', el cual es el siguiente: </p><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"></p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"></p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table class="callout" style="Margin-bottom:16px;border-collapse:collapse;border-spacing:0;margin-bottom:16px;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th class="callout-inner secondary token" style="Margin:0;background:#bed9ff;border:0 none;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:10px;text-align:left;width:100%"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:0!important;padding-right:0!important;text-align:left;width:100%"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:10px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:center"><h1 class="text-center m-0 p-0" style="Margin:0;Margin-bottom:10px;color:#001f4a;font-family:"Courier New",Courier,monospace;font-size:48px;font-weight:700;line-height:1.3;margin:0!important;margin-bottom:10px;padding:0!important;text-align:center;word-wrap:normal">'.$nuevoTramite.'</h1></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                                </th></tr></table></th></tr></tbody></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></td></tr></tbody></table><table align="center" class="container footer__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
                                <tbody>
                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                            <table bgcolor="#eaeaea" class="wrapper footer" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                <tr style="padding:0;text-align:left;vertical-align:top">
                                                    <td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                        <table class="row footer text-center" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="footer__item footer_1 small-12 large-3 columns first" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:8px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="8px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:8px;font-weight:400;hyphens:auto;line-height:8px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><img src="http://cdn.apci.gob.pe/dist/images/apci__logo--large--color.png" alt width="150px" height="55px" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="8px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:8px;font-weight:400;hyphens:auto;line-height:8px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th></tr></table></th><th class="footer__item footer_1 small-12 large-3 columns" valign="bottom" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#515151;font-family:Helvetica,Arial,sans-serif;font-size:80%;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><a href="https://goo.gl/maps/okU3vgEAtUp5vaYcA" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">Av. José Pardo 261,<br>Miraflores 15074, Lima, Perú</a></p></th></tr></table></th><th class="footer__item footer_1 small-12 large-3 columns last" valign="bottom" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:129px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#515151;font-family:Helvetica,Arial,sans-serif;font-size:80%;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><a href="tel:+5116173600" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">(511) 617-3600</a><br><a href="mailto:d-tramite@apci.gob.pe" style="Margin:0;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">d-tramite@apci.gob.pe</a></p></th></tr></table></th></tr></tbody></table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table bgcolor="#fefefe" class="wrapper" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-1 large-1 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:8px;text-align:left;width:32.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"></th></tr></table></th><th class="small-10 large-10 columns" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:467.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><center data-parsed style="min-width:435.33px;width:100%"><table align="center" class="menu float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:auto!important"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:10px;padding-right:10px;text-align:center"><a href="http://www.peru.gob.pe" style="Margin:0;color:#9bd8ff;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><img class="small-float-center" width="<th class="small-1 large-1 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:32.33px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"></th></tr></table></th></tr></tbody></table><table class="row footer__pos" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                                <tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><center data-parsed style="min-width:532px;width:100%"><small align="center" class="float-center" style="color:#cacaca;font-size:80%">Toda la información contenida en este mensaje es confidencial y de uso exclusivo de usuarios del D-Trámite de la APCI. Si ha recibido este mensaje por error, por favor proceda a eliminarlo y notificar al remitente.</small></center></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                        </center>
                    </td>
                </tr>
            </table><div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
        </body>
        </html>';

        $correos = [];
        array_push($correos,MAIL_MESA_PARTES);

        $archivos = [];

        $archivoPrincipal = [
            "contenido" => $docDigital->obtenerDocBinario(),
            "nombre" => $docDigital->name,
            "encoding" => "base64",
            "type" => $docDigital->type
        ];

        array_push($archivos,$archivoPrincipal);

        $mail = new Email();
        $mail->Enviar($asunto, $correos, $cuerpo, $archivos);
        break;

}

?>