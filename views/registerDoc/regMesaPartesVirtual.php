<?php
session_start();
include_once('../../conexion/conexion.php');
include_once("../../conexion/parametros.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../clases/DocDigital.php");
require_once("../clases/Log.php");

include_once("../../core/CURLConection.php");

date_default_timezone_set('America/Lima');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$nNumAno    = date('Y');
$nNumMes    = date('m');
$nNumDia    = date('d');

switch ($_REQUEST['Evento']) {
    case 'registroMesaPartesVirtual':
        $pin = '';
        $matriz = '0123456789';
        for ($i=0; $i<4; $i++){
            $pin .= substr($matriz,rand(0,9),1);
        }

        $parametros = array(
            $_POST['cCodTipoDoc'],
            $_POST['cNroDocumento'],
            $_POST['cAsunto'],
            $pin,
            $_POST['tipoEntidad'],
            $_POST['numeroDocumento'],
            $_POST['nomEntidad'],
            $_POST['dniResponsable'],
            $_POST['nomResponsable'],
            $_POST['cargoResponsable'],
            $_POST['telefonoContacto'],
            $_POST['correoContacto']
        );

        $sqlregistro = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL (?,?,?,?,?,?,?,?,?,?,?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

        $agrupado = date("Gis").$Rsregistro['ID_MESA_PARTES_VIRTUAL'];
        $nomenclatura = $nNumAno.'/'.$nNumMes.'/'.$nNumDia.'/'.$agrupado;
        $ruta = 'docEntradaMesaVirtual/'.$nomenclatura.'/';

        $datos = new stdClass();
        $datos->ruta = $ruta;

        $servidor = new stdClass();
        $servidor->host = $host;
        $servidor->puerto = $port;
        $servidor->ruta = $path;
        $servidor->fileUpload = $fileUpload;

        $archivoPrincipal = $_FILES['archivoPrincipal'];
        $arrayExploded = explode('.',$archivoPrincipal['name']);
        if (strtoupper(array_pop($arrayExploded)) == 'PDF') {
            $archivo = new stdClass();
            $archivo->tmp_name = $archivoPrincipal['tmp_name'];
            $archivo->name = $archivoPrincipal['name'];
            $archivo->type = $archivoPrincipal['type'];
            $archivo->size = $archivoPrincipal['size'];

            $url = DocDigital::cargarDocumento($archivo,$datos,$servidor);            
    
            $parametrosDocPrincipal = array(
                $Rsregistro['ID_MESA_PARTES_VIRTUAL'],
                5,
                $_FILES['archivoPrincipal']['name'],
                $url
            );
    
            $sqlDocPrincipal = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
            $rsDocPrincipal = sqlsrv_query($cnx, $sqlDocPrincipal, $parametrosDocPrincipal);
            if($rsDocPrincipal === false) {
                print_r('Error al registrar el archivo principal.');
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
        }        

        if (isset($_FILES['anexos'])){
            for($i = 0; $i < count($_FILES['anexos']['name']); $i++){

                $archivo = new stdClass();
                $archivo->tmp_name = $_FILES['anexos']['tmp_name'][$i];
                $archivo->name = $_FILES['anexos']['name'][$i];
                $archivo->type = $_FILES['anexos']['type'][$i];
                $archivo->size = $_FILES['anexos']['size'][$i];

                $url = DocDigital::cargarDocumento($archivo,$datos,$servidor);            
        
                $parametrosAnexos = array(
                    $Rsregistro['ID_MESA_PARTES_VIRTUAL'],
                    3,
                    $_FILES['anexos']['name'][$i],
                    $url
                );
        
                $sqlDocAnexo = "{call UP_REGISTRAR_MESA_PARTES_VIRTUAL_ARCHIVO (?,?,?,?) }";
                $rsDocAnexo = sqlsrv_query($cnx, $sqlDocAnexo, $parametrosAnexos);
                if($rsDocAnexo === false) {
                    print_r('Error al registrar el archivo principal.');
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
            }
        }

        $retorno = array(
            'codigo' => $Rsregistro['ID_MESA_PARTES_VIRTUAL']
        );
        $hash = base64_encode(json_encode($retorno));

        $nombres = $_POST['nomEntidad'];
        $correo = $_POST['correoContacto'];

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
                                <p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"><small><em>* Para finalizar su registro por favor ingrese el código de validación (PIN) en la pantalla de registro o si no haga clic en el siguiente enlace : <a href="'.RUTA_DTRAMITE.'views/mesa-partes-virtual.php?Evento=ValidarPin&hash='.$hash.'">Valida</a>.</p></th></tr></table></th></tr></tbody></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></td></tr></tbody></table><table align="center" class="container footer__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
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
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
            $mail->Password = 'Hacker147';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;
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
            
            echo $hash;
        } catch (Exception $e) {
            print_r('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;
    
    case "validacionCodigo":
        $datos = json_decode(base64_decode($_POST['hash']));
        $parametros = array(
            $datos->codigo,
            $_POST['pin']
        );

        $sqlregistro = "{call UP_VALIDAR_CODIGO_REGISTRO_MESA_PARTES_VIRTUAL (?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

        $respuesta = array(
            "estado" => $Rsregistro['ESTADO'],
            "mensaje" => $Rsregistro['MENSAJE'],
        );
        echo json_encode($respuesta);
        break;

    case "AsignarEntidad":
        $parametros = array(
            $_POST['Id'],
            $_POST['IdEntidad']
        );

        $sqlregistro = "{call UP_ASIGNAR_ENTIDAD_REGISTRO_MESA_PARTES_VIRTUAL (?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

        $respuesta = array(
            "estado" => $Rsregistro['ESTADO'],
            "mensaje" => $Rsregistro['MENSAJE'],
        );
        echo json_encode($respuesta);
        break;

    case "Validar":
        $parametros = array(
            $_POST['Id']
        );

        $sqlregistro = "{call UP_MIGRAR_REGISTRO_MESA_PARTES_VIRTUAL (?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

        $respuesta = array(
            "estado" => $Rsregistro['ESTADO'],
            "mensaje" => $Rsregistro['MENSAJE'],
        );
        echo json_encode($respuesta);
        break;
}
?>