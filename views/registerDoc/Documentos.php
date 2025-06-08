<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Spatie\Async\Pool;

//Load Composer's autoloader
require '../../vendor/autoload.php';


require_once("../../conexion/conexion.php");
require_once("../../core/CURLConection.php");
require_once("../../conexion/parametros.php");
require_once("../clases/DocDigital.php");
require_once("../clases/Email.php");
require_once("../clases/Log.php");
require_once('../clases/Zip.php');
include "phpqrcode/qrlib.php";

require_once('../invoker/config.php');


session_start();
date_default_timezone_set('America/Lima');
//momentaneo
$fFecActual = date('Ymd').' '.date('G:i:s');

function numeroPaginasPdf($binario)
    {
        $content = $binario;
        $count = 0;
        $regex  = "/\/Count\s+(\d+)/";
        $regex2 = "/\/Page\W*(\d+)/";
        $regex3 = "/\/N\s+(\d+)/";
        if(preg_match_all($regex, $content, $matches)) {
            $count = max($matches);
        }
        return $count[1];
    }

function enviarCorreoAsistentes($tramiteID, $nombre, $ruta, $cnx){
    $params = array(
        $tramiteID
    );

    $sqlCorreosAsistentes = "{call UP_LISTAR_CORREOS_NOTIFICACION (?) }";
    $rs = sqlsrv_query($cnx, $sqlCorreosAsistentes, $params);
    if($rs === false) {
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }

    $correos = [];
    while ( $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
        array_push($correos,$Rs['cMailTrabajador']);
    }

    $asunto = 'Documento firmado';
    $cuerpo = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#ccc!important"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width"><title>Alerta de envío</title><style>@media only screen{html{min-height:100%;background:#f3f3f3}}@media only screen and (max-width:596px){.small-float-center{margin:0 auto!important;float:none!important;text-align:center!important}}@media only screen and (max-width:596px){table.body img{width:auto;height:auto}table.body center{min-width:0!important}table.body .container{width:95%!important}table.body .columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:16px!important;padding-right:16px!important}table.body .columns .columns{padding-left:0!important;padding-right:0!important}table.body .collapse .columns{padding-left:0!important;padding-right:0!important}th.small-6{display:inline-block!important;width:50%!important}th.small-12{display:inline-block!important;width:100%!important}.columns th.small-12{display:block!important;width:100%!important}table.menu{width:100%!important}table.menu td,table.menu th{width:auto!important;display:inline-block!important}table.menu.vertical td,table.menu.vertical th{display:block!important}table.menu[align=center]{width:auto!important}}</style></head><body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#ccc!important;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"><span class="preheader" style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span>
    <table class="body" style="Margin:0;background:#ccc!important;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><center data-parsed style="min-width:580px;width:100%"><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%">
    <tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
    <tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table bgcolor="#2f4576" class="wrapper header with-bg-img--dark" align="center" style="background:#3b5998;border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:20px;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
    <tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-6 large-6 columns first" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:8px;text-align:left;width:274px">
    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
    <img src="https://www.apci.gob.pe/images/apps/dt__logo.png" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:195px"></th></tr></table></th><th class="small-6 large-6 columns last" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:8px;padding-right:16px;text-align:left;width:274px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><h6 class="text-right description" style="Margin:0;Margin-bottom:10px;color:#fff;font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:400;line-height:1.3;margin:0;margin-bottom:0;margin-top:0;padding:0;padding-top:0;text-align:right;word-wrap:normal">
    Alerta de envío</h6></th></tr></table></th></tr></tbody></table></td></tr></table></td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="24px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;hyphens:auto;line-height:24px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p class="lead" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:400;line-height:1.6;margin:0;margin-bottom:10px;padding:0;text-align:left">
    Estimado(a), <strong></strong>:</p><p style="Margin:0;Margin-bottom:10px;color:#484848;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.5;margin:0;margin-bottom:10px;padding:0;text-align:left">
    Se remite la información del documento que acaba de firmarse por el Sistema D-Trámite</p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
    <tbody><tr style="padding:0;text-align:left;vertical-align:top">
    <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table class="callout" style="Margin-bottom:16px;border-collapse:collapse;border-spacing:0;margin-bottom:16px;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th class="callout-inner secondary" style="Margin:0;background:#faf0e1;border:1px solid #986517;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:10px;text-align:left;width:100%">
    '.$nombre.'</th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table><table class="button expanded secondary" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;margin:0 0 16px 0;padding:0;text-align:left;vertical-align:top;width:100%!important"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#e09c35;border:0 solid #e09c35;border-collapse:collapse!important;color:#fefefe;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><center data-parsed style="min-width:0;width:100%">
    <a href="'.$ruta.'" align="center" class="float-center" style="Margin:0;border:0 solid #e09c35;border-radius:3px;color:#fefefe;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:700;line-height:1.3;margin:0;padding:8px 16px 8px 16px;padding-left:0;padding-right:0;text-align:center;text-decoration:none;width:100%">Ver Documento</a></center></td></tr></table></td><td class="expander" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0!important;text-align:left;vertical-align:top;visibility:hidden;width:0;word-wrap:break-word"></td></tr></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
    Atentamente,</p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
    D-Trámite - APCI</p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></tbody></table><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table align="center" class="container footer__container float-center" style="Margin:0 auto;background:#fefefe;background-color:transparent!important;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
    <table bgcolor="transparent" class="wrapper" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row footer__pos" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center"><img style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:auto" src="http://www.apci.gob.pe/images/apps/apci__logo.png" height="50"></p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">
    <small style="color:#616161!important;font-size:80%">Toda la información contenida en este mensaje es confidencial y de uso exclusivo de APCI.<br>Si ha recibido este mensaje por error, por favor proceda a eliminarlo y notificar al remitente.</small></p></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></table></td></tr></tbody></table><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></center></td></tr></table><!-- prevent Gmail on iOS font size manipulation --><div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div></body></html>';

    $mail = new Email();
    $mail->Enviar($asunto , $correos, $cuerpo);
}

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    switch ($_POST["Evento"]){
        case "DocumentosAgrupados":
            $params = [
                $_SESSION['iCodPerfilLogin'],
                $_SESSION['iCodOficinaLogin'],
                $_SESSION['CODIGO_TRABAJADOR']
            ];

           $sqlAgrupados = "{call SP_LISTAR_GRUPOS_USUARIO_VIGENTE (?,?,?)}";
            $rs = sqlsrv_query($cnx,$sqlAgrupados,$params);

            $json_data = array(
            "data" => $rs
            );
            $thing = $json_data;
            $data=array();
            while($Rs=sqlsrv_fetch_array($rs)){
                 $subdata=array();
                 $subdata["Valor"]=$Rs['cAgrupado'];
                 $subdata["Texto"]=$Rs['texto'];
                 $data[]=$subdata;
            }
            $thing["data"] = $data;
            echo json_encode($thing);
        break;

        case "ListarDocumentosUsuario":
            $sqlConsulta = "execute SP_CONSULTA_LISTA_DOCUMENTOS_USUARIO '".$_POST['Agrupado']."' ";
            $rsConsulta = sqlsrv_query($cnx,$sqlConsulta);

            $data = array();
            while($Rs=sqlsrv_fetch_array($rsConsulta,SQLSRV_FETCH_ASSOC)){
                $data[]=$Rs;
            }
            $recordsTotal=sqlsrv_num_rows($rsConsulta);
            $recordsFiltered=sqlsrv_num_rows($rsConsulta);

            $json_data = array(
                "draw"            => (int)($request['draw']??0),
                "recordsTotal"    => (int) $recordsTotal ,
                "recordsFiltered" => (int) $recordsFiltered ,
                "data"            => $data
            );

            echo json_encode($json_data);
        break;

        case "ListarDocumentosUsuarioCorrespondientes":
            $params = [
                $_POST['Agrupado'],
                $_SESSION['iCodPerfilLogin'],
                $_SESSION['iCodOficinaLogin'],
                $_SESSION['CODIGO_TRABAJADOR'],
                $_POST['Tipo'],
                $_POST['Codigo']
            ];

            $sqlAgrupados = "{call SP_LISTAR_GRUPOS_USUARIO_VIGENTE_CORRESPONDIENTE (?,?,?,?,?,?)}";
            $rsConsulta = sqlsrv_query($cnx,$sqlAgrupados,$params);

            $data = array();
            while($Rs=sqlsrv_fetch_array($rsConsulta,SQLSRV_FETCH_ASSOC)){
                $Rs['FecModifica'] = date("d/m/Y H:i:s", strtotime($Rs['FecModifica']));
                $data[]=$Rs;
            }
            $recordsTotal=sqlsrv_num_rows($rsConsulta);
            $recordsFiltered=sqlsrv_num_rows($rsConsulta);

            $json_data = array(
                "draw"            => (int)($request['draw']??0),
                "recordsTotal"    => (int) $recordsTotal ,
                "recordsFiltered" => (int) $recordsFiltered ,
                "data"            => $data
            );

            echo json_encode($json_data);
        break;

        case "DerivarJefeInmediato":
            $params = array(
                $_POST['cAgrupado'],
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin'],
                $_SESSION['iCodPerfilLogin']
            );
            $sqlEnvioJefeInmediato = "{call SP_DERIVAR_JEFE_INMEDIATO (?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlEnvioJefeInmediato, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "DerivarJefeVisado":
            $params = array(
                $_POST['codigo'],
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin'],
                $_SESSION['iCodPerfilLogin']
            );
            $sqlEnvioJefeVisado = "{call SP_DERIVAR_JEFE_VISADO (?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlEnvioJefeVisado, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "DerivarJefeProyecto":
            $params = array(
                json_encode($_POST['codigos']),
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin'],
                $_SESSION['iCodPerfilLogin']
            );
            $sqlEnvioJefeProyecto = "{call SP_DERIVAR_JEFE_PROYECTO (?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlEnvioJefeProyecto, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "DerivarDestino":            
            $pool = Pool::create();

            $responseG = new stdClass();
            $responseG->success = true;
            $responseG->mensaje = '';

            $paramsDP = array(
                $_POST['codigo']
            );
            
            $sqlDP = "{call SP_OBTENER_DATOS_TRAMITE (?) }";
            $rsDP = sqlsrv_query($cnx, $sqlDP, $paramsDP);
            if($rsDP === false) {
                http_response_code(500);                
                die(print_r(sqlsrv_errors()));
            }
            $RsDP = sqlsrv_fetch_array( $rsDP, SQLSRV_FETCH_ASSOC);

            $docDigitalP = new DocDigital($cnx);
            $docDigitalP->idTramite = $_POST['codigo'];
            $docDigitalP->idTipo = 0;
            $docDigitalP->idEntidad = 0;
            $docDigitalP->obtenerDocMayor();

            $rutaArchivo = RUTA_DTRAMITE.$docDigitalP->obtenerRutaDocDigital();

            if ($RsDP['IdInscripcion'] !== NULL AND $_POST['tipoDoc'] == 3){     
                // $destinatarios = json_decode($Rs['Destinatario']);

                // $destinatarios = reset($destinatarios);
                // $destinatarios = $destinatarios->nomRemitente;                

                $url = RUTA_SIGTI_SERVICIOS."/ApiD-Tramite/Api/Tramite/TRA_GET_0005";
                $data = array(
                    "CodInscripcion" => $RsDP['IdInscripcion'],
                    "CodObservacion" => ($RsDP['IdObservacion'] ?? '0'),
                    "CodMovimiento" => 0,
                    "CodTupa" => $RsDP['IdTupa'],
                    "Denominacion" => urlencode($RsDP['NombreEntidadRemitente']),
                    "listArchivo" => [$rutaArchivo],
                    "CodUsuario" => $_SESSION['idUsuarioSigcti']
                );

                $client = curl_init();
                curl_setopt($client, CURLOPT_URL, $url);
                curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($client, CURLOPT_POST, true);
                curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
                $response = json_decode(curl_exec($client));

                $log = new Log($cnx);                

                if(!$response->Success){
                    $responseG->success = false;
                    $responseG->mensaje = $response->MessageResult;

                    $datosMail = new stdClass();
                    $datosMail->asunto = 'Error en la ejecución';
                    $datosMail->correos = array(
                        CORREO_SIGCTI
                    );
                    $datosMail->cuerpo = "No se ha ejecutado el servicio $url con los siguientes parametros:<br/> ".json_encode($data);
                    
                    $log->logging($datosMail);
                }

                $datosDB = new stdClass();
                $datosDB->archivo = 'Documento.php';
                $datosDB->metodo = "DerivarDestino | $url";
                $datosDB->resultado = $response->Success ? 1 : 0;
                $datosDB->mensaje = $response->MessageResult;
                $datosDB->contenido = json_encode($data);             

                $log->logging(false, $datosDB);
            }            

            if($responseG->success){
                $flgCorrecto = true;
                
                if($_POST['tipoDoc'] == 2){
                    $paramsI = array(
                        $_POST['codigo'],
                        $_SESSION['CODIGO_TRABAJADOR'],
                        $_SESSION['iCodOficinaLogin'],
                        $_SESSION['iCodPerfilLogin'],
                        $_SESSION['IdSesion'],
                        0
                    );
                    
                    $sqlI = "{call SP_DERIVACION_DOCUMENTO_DESTINO (?,?,?,?,?,?) }";
                    $rsI = sqlsrv_query($cnx, $sqlI, $paramsI);
                    if($rsI === false) {
                        http_response_code(500);                
                        die(print_r(sqlsrv_errors()));
                    }

                    $Rs = sqlsrv_fetch_array( $rsI, SQLSRV_FETCH_ASSOC);

                    if($Rs['CodMovimiento'] == null || $Rs['CodMovimiento'] == ''){
                        $flgCorrecto = false;
                    }

                } else {
                    $paramsDestinos = array(
                        $_POST['codigo'],
                        0
                    );

                    $sqlDestinos = "{call SP_CONSULTA_DATOS_DOCUMENTO_DESTINATARIOS (?,?) }";
                    $rsDestinos = sqlsrv_query($cnx, $sqlDestinos, $paramsDestinos);
                    if($rsDestinos === false) {
                        http_response_code(500);
                        die(print_r(sqlsrv_errors()));
                    }
        
                    $totalEnviar = 0;
                    $sinEnviar = 0;
                    while( $row = sqlsrv_fetch_array($rsDestinos,SQLSRV_FETCH_ASSOC)){
                        $totalEnviar++;
                        // $data[]=$row;

                        $paramsE = array(
                            $_POST['codigo'],
                            $_SESSION['CODIGO_TRABAJADOR'],
                            $_SESSION['iCodOficinaLogin'],
                            $_SESSION['iCodPerfilLogin'],
                            $_SESSION['IdSesion'],
                            $row['iCodRemitente']
                        );
                        
                        $sqlE = "{call SP_DERIVACION_DOCUMENTO_DESTINO (?,?,?,?,?,?) }";
                        $rsE = sqlsrv_query($cnx, $sqlE, $paramsE);
                        if($rsE === false) {
                            http_response_code(500);                
                            die(print_r(sqlsrv_errors()));
                        }
                        
                        $Rs = sqlsrv_fetch_array( $rsE, SQLSRV_FETCH_ASSOC);

                        // $docDigital->obtenerDocDigitalPorId($Rs['IdDigital']);
                        // $rutaArchivo = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();

                        if($Rs['CodMovimiento'] != null && $Rs['CodMovimiento'] != ''){
                            $docDigital = new DocDigital($cnx);
                            $docDigital->idTramite = $_POST['codigo'];
                            $docDigital->idTipo = 0;
                            $docDigital->idEntidad = $row['iCodRemitente'];
                            $docDigital->obtenerDocMayor();
                            
                            if ($row['idTipoEnvio'] == 98){
                                $paramsDocumentos = array(
                                    '',
                                    'tramite',
                                    $_POST['codigo'],
                                    ''
                                );
                                $sqlAddDocumentos = "{call SP_CONSULTA_DATOS_DOCUMENTO (?,?,?,?) }";
                                $rsDocumento = sqlsrv_query($cnx, $sqlAddDocumentos, $paramsDocumentos);

                                if($rsDocumento === false) {
                                    $datosDBrsDocumento = new stdClass();
                                    $datosDBrsDocumento->archivo = 'Documento.php';
                                    $datosDBrsDocumento->metodo = "DerivarDestino | SP_CONSULTA_DATOS_DOCUMENTO";
                                    $datosDBrsDocumento->resultado = 0;
                                    $datosDBrsDocumento->mensaje = json_encode(sqlsrv_errors());
                                    $datosDBrsDocumento->contenido = json_encode($paramsDocumentos);             
                    
                                    $log->logging(false, $datosDBrsDocumento);
                                }

                                $rowDocumento = sqlsrv_fetch_array($rsDocumento,SQLSRV_FETCH_ASSOC);
                
                                $docDigitalNotificacion = new DocDigital($cnx);
                                $docDigitalNotificacion->idTramite = $row['idTramiteNotificacion'];
                                $docDigitalNotificacion->idTipo = 0;
                                $docDigitalNotificacion->idEntidad = 0;
                                $docDigitalNotificacion->obtenerDocMayor();

                                // $docDigitalNotificacion->obtenerDocDigitalPorId($Rs['IdDigitalNotificacion']);
                                $rutaArchivoNotificacion = RUTA_DTRAMITE.$docDigitalNotificacion->obtenerRutaDocDigital(); 
                
                                $url = RUTA_SERVICIO_CASILLA."/mpi/recibir-documento";
                
                                $anexosServicio = array();
                
                                $cedula = new stdClass();
                                $cedula->Tipo_Archivo = 1;
                                $cedula->Ruta_Archivo = $rutaArchivoNotificacion;
                                $cedula->NombreArchivo = $docDigitalNotificacion->name;
                                $anexosServicio[] = $cedula;
                
                                $principal = new stdClass();
                                $principal->Tipo_Archivo = 2;
                                $principal->Ruta_Archivo = $rutaArchivo;
                                $principal->NombreArchivo = $docDigital->name;
                                $anexosServicio[] = $principal;
                
                                if($rowDocumento['cAnexosImprimibles'] != NULL && $rowDocumento['cAnexosImprimibles'] != ''){
                                    foreach (json_decode($rowDocumento['cAnexosImprimibles']) as $key => $value) {
                                        $docDigitalAnexo = new DocDigital($cnx);
                                        $docDigitalAnexo->obtenerDocDigitalPorId($value->iCodDigital);
                                        $rutaArchivoAnexo = RUTA_DTRAMITE.$docDigitalAnexo->obtenerRutaDocDigital(); 
                                    
                                        $anexoImprimible = new stdClass();
                                        $anexoImprimible->Tipo_Archivo = 3;
                                        $anexoImprimible->Ruta_Archivo = $rutaArchivoAnexo;
                                        $anexoImprimible->NombreArchivo = $docDigitalAnexo->name;
                                        $anexosServicio[] = $anexoImprimible;
                                    }
                                }                
                
                                // $datosDespachoJson = json_decode($Rs['DatosDespacho']);
                                
                                $paramsDocumentosNotificacion = array(
                                    $row['idTramiteNotificacion']
                                );
                                $sqlDocumentosNotificacion = "{call SP_CONSULTA_DATOS_DOCUMENTO_NOTIFICACION (?) }";
                                $rsDocumentosNotificacion = sqlsrv_query($cnx, $sqlDocumentosNotificacion, $paramsDocumentosNotificacion);

                                if($rsDocumentosNotificacion === false) {
                                    $datosDBrsDocumentoNotificacion = new stdClass();
                                    $datosDBrsDocumentoNotificacion->archivo = 'Documento.php';
                                    $datosDBrsDocumentoNotificacion->metodo = "DerivarDestino | SP_CONSULTA_DATOS_DOCUMENTO_NOTIFICACION";
                                    $datosDBrsDocumdatosDBrsDocumentoNotificacionento->resultado = 0;
                                    $datosDBrsDocumentoNotificacion->mensaje = json_encode(sqlsrv_errors());
                                    $datosDBrsDocumentoNotificacion->contenido = json_encode($paramsDocumentosNotificacion);             
                    
                                    $log->logging(false, $datosDBrsDocumentoNotificacion);
                                }

                                $rowDocumentoNotificacion = sqlsrv_fetch_array($rsDocumentosNotificacion,SQLSRV_FETCH_ASSOC);
                
                                $data = array(
                                    "IdTramite" => (int)$_POST['codigo'],
                                    "Id_Usuario" => (int)($row['idPersonaExterna'] ?? '0'),
                                    "Tipo_Documento" => (int)$rowDocumento['cCodTipoDoc'],
                                    "Tipo_Documento_Desc" => trim($rowDocumento['cDescTipoDoc']),
                                    "NroDocumento" => $rowDocumento['cCodificacion'],
                                    "Asunto" => $rowDocumento['cAsunto'],
                                    "Observacion" => $row['observacionesDespacho'],
                                    "Id_Unidad_Organica" => $rowDocumento['iCodOficinaFirmante'],
                                    "Unidad_Organica" => $rowDocumento['OficinaFirmante'],
                                    "Id_Trabajador" => $rowDocumento['iCodTrabajadorFirmante'],
                                    "Nombre_Completo" => $rowDocumento['TrabajadorFirmante'],
                                    "Anexos" => $anexosServicio,
                                    "Nro_Cedula_Notificacion" => trim($rowDocumentoNotificacion['cDescTipoDoc']).' '.trim($rowDocumento['cCodificacion'])
                                );
                
                                $client = curl_init();
                                curl_setopt($client, CURLOPT_URL, $url);
                                curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
                                curl_setopt($client, CURLOPT_POST, true);
                
                                $header = [
                                    'Content-Type: application/json'
                                    ];
                                curl_setopt($client, CURLOPT_HTTPHEADER, $header);
                
                                curl_setopt($client, CURLOPT_POSTFIELDS, json_encode($data));
                                $response = json_decode(curl_exec($client));
                
                                $log = new Log($cnx);                
                
                                if($response->code != 200){
                                    $datosMail = new stdClass();
                                    $datosMail->asunto = 'Error en la ejecución';
                                    $datosMail->correos = array(
                                        CORREO_SOPORTE
                                    );
                                    $datosMail->cuerpo = "No se ha ejecutado el servicio $url con los siguientes parametros:<br/> ".json_encode($data);
                                    
                                    $log->logging($datosMail);
                                }
                
                                $datosDB = new stdClass();
                                $datosDB->archivo = 'Documento.php';
                                $datosDB->metodo = "DerivarDestino | $url";
                                $datosDB->resultado = $response->code == 200 ? 1 : 0;
                                $datosDB->mensaje = json_encode($response);
                                $datosDB->contenido = json_encode($data);             
                
                                $log->logging(false, $datosDB);
                
                                if($response->code == 200){
                                    $paramsCorreos = array(
                                        $_POST['codigo']
                                    );
                                    $sqlCorreos = "{call UP_LISTAR_CORREOS_NOTIFICACION (?) }";
                                    $rsCorreos = sqlsrv_query($cnx, $sqlCorreos, $paramsCorreos);
                                    if($rsCorreos === false) {
                                        $datosDBrsDocumento = new stdClass();
                                        $datosDBrsDocumento->archivo = 'Documento.php';
                                        $datosDBrsDocumento->metodo = "DerivarDestino | SP_CONSULTA_DATOS_DOCUMENTO";
                                        $datosDBrsDocumento->resultado = 0;
                                        $datosDBrsDocumento->mensaje = json_encode(sqlsrv_errors());
                                        $datosDBrsDocumento->contenido = json_encode($paramsCorreos);             
                        
                                        $log->logging(false, $datosDBrsDocumento);
                                    }
                                    $correosNoticiacion = [];
                                    while ( $RsCorreos = sqlsrv_fetch_array($rsCorreos, SQLSRV_FETCH_ASSOC)){
                                        array_push($correosNoticiacion,$RsCorreos['cMailTrabajador']);
                                    }
                
                                    $cuerpoNotificacion = "El documento ".$docDigital->name." ha sido notificado satisfactoriamente con N° de registro ".$response->result->id_Casilla." el día ".$response->result->fecha_Notifacion;
                
                                    $mail = new Email();
                                    $mail->Enviar('Cargo de Notificación de Casilla Electrónica - '.trim($rowDocumento['cDescTipoDoc']).' '.$rowDocumento['cCodificacion'] , $correosNoticiacion, $cuerpoNotificacion);
                                }                
                            }

                            $base64 = base64_encode($docDigital->obtenerDocBinario());
                            $paramsDespacho = array(
                                // $Rs['DatosDespacho'],
                                $Rs['CodMovimiento'],
                                $_POST['codigo'],
                                $row['iCodRemitente'],
                                $base64,
                                numeroPaginasPdf($docDigital->obtenerDocBinario()),
                                0,
                                $_SESSION['IdSesion']
                            );
                        
                            $sqlDespacho = "{call UP_INSERTAR_DESPACHO_DETALLE (?,?,?,?,?,?,?) }";
                            $rsDespacho = sqlsrv_query($cnx, $sqlDespacho, $paramsDespacho);
                            if($rsDespacho === false) {
                                http_response_code(500);                            
                                die(print_r(sqlsrv_errors()));
                            }
                        } else {
                            $sinEnviar++;
                        }
                    }

                    if($totalEnviar == $sinEnviar){
                        $flgCorrecto = false;
                    }
                }

                if($flgCorrecto){    
                    $nombres = $RsDP['NombreTrabajadorRegistro'];
                    $correo = $RsDP['CorreoTrabajadorRegistro'];
                    $nombre_doc = $docDigitalP->name;
                    $url_doc = $rutaArchivo;
        
                    $asunto = 'Documento generado';
                    $cuerpo = '<p>Estimado(a) '.$nombres.', el documento que proyecto ya fue firmado con el nombre: <a target="_blank" href="'.$url_doc.'" >'.$nombre_doc.'</a></p>';
        
                    $correos = [];
                    array_push($correos,$correo);

                    $mail = new Email();
                    $mail->Enviar($asunto, $correos, $cuerpo);
                }
    
                // $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                // try {
                //     //Server settings
                //     $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                //     $mail->isSMTP();                                      // Set mailer to use SMTP
                //     $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                //     $mail->SMTPAuth = true;                               // Enable SMTP authentication
                //     $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
                //     $mail->Password = 'Hacker147';                           // SMTP password
                //     $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                //     $mail->Port = 465;                                    // TCP port to connect to
    
                //     //Recipients
                //     $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                //     //$mail->addAddress('jatayauri@apci.gob.pe', 'Joe User');     // Add a recipient
                //     for ($e = 0; $e < count($correos); $e++){
                //         $mail->addAddress($correos[$e]);
                //     }
    
                //     //Content
                //     $mail->isHTML(true);// Set email format to HTML
                //     $mail->Subject = $asunto;
                //     $mail->Body = $cuerpo;
                //     $mail->CharSet = 'UTF-8';
                //     $mail->AltBody = 'No responder';
    
                //     $mail->send();
                //     // echo 'Message has been sent';
                // } catch (Exception $e) {
                //     $response->mensaje = 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                //     // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                // }                
            }
            
            echo json_encode($responseG);
            break;

        case "ObtenerDatosDocumentos":
            $params = array(
                $_POST['movimiento']??'',
                $_POST['tipo'],
                $_POST['codigo'],
                $_POST['agrupado']??''
            );
            $sqlAdd = "{call SP_CONSULTA_DATOS_DOCUMENTO (?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlAdd, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            if(sqlsrv_has_rows($rs)){
                while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
                    echo json_encode($row);
                }
            }
            break;

        case "ObtenerDatosDocumentosDestinatarios":
            $params = array(
                $_POST['tramite'],
                $_POST['proyecto']
            );
            $sqlAdd = "{call SP_CONSULTA_DATOS_DOCUMENTO_DESTINATARIOS (?,?) }";
            $rs = sqlsrv_query($cnx, $sqlAdd, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            $data=array();
            if(sqlsrv_has_rows($rs)){ 
                while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
                    $data[]=$row;
                }
            }

            echo json_encode($data);
            break;

        case "EliminarDestinatario":
            $params = array(
                $_POST['id'],
                $_SESSION['IdSesion']
            );
            $sqlUpAnular = "{call SP_DOCUMENTO_DESTINATARIO_ELIMINAR (?,?) }";
            $rs = sqlsrv_query($cnx, $sqlUpAnular, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "AnularDocumento":
            $params = array(
                $_POST['tipo'],
                $_POST['codigo'],
                2,
                2,
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodPerfilLogin'],
                $_SESSION['iCodOficinaLogin']
            );
            $sqlUpAnular = "{call SP_UPDATE_CAMBIO_ESTADO_DOCUMENTO (?,?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlUpAnular, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "GuardarDatos":
            $i_tipo = $_POST['cTipo'];
            $i_codigo = $_POST['cCodigo'];
            $nFlgTipoDoc =  $_POST["cCodTipoTra"];
            $i_cCodTipoDoc =   $_POST['cCodTipoDoc'];
            $i_cAsunto =  $_POST['cAsunto'];
            $i_cCuerpoDocumento = $_POST['editorOficina'];
            $i_cObservaciones =$_POST['cObservaciones'];

            if(isset($_POST['cReferencia'])){
                $cReferencia = [];
                foreach ($_POST['cReferencia'] as $key => $value) {
                    $cReferencia[$key]['iCodTramiteRef'] = $value;
                }
                $i_cReferencia =  json_encode($cReferencia);
            } else {
                $i_cReferencia = null;
            }

            if(isset($_POST['cAnexos'])){
                $cAnexos = [];
                foreach ($_POST['cAnexos'] as $key => $value) {
                    $cAnexos[$key]['iCodDigital'] = $value;
                }
                $i_cAnexos =  json_encode($cAnexos);
            } else {
                $i_cAnexos = null;
            }

            if(isset($_POST['cAnexosImprimibles'])){
                $cAnexosImprimibles = [];
                foreach ($_POST['cAnexosImprimibles'] as $key => $value) {
                    $cAnexosImprimibles[$key]['iCodDigital'] = $value;
                }
                $i_cAnexosImprimibles =  json_encode($cAnexosImprimibles);
            } else {
                $i_cAnexosImprimibles = null;
            }

            if ($_POST['fFecPlazo'] !== '') {
                $tiempoPlazo =  round(strtotime($_POST['fFecPlazo']) -  strtotime ($fFecActual) / (60 * 60 * 24));
            } else {
                $tiempoPlazo = 30;
            }

            $i_flgSigo = $_POST['flgSigo']??0;
            $i_flgEncriptado = $_POST['flgEncriptado']??0;
            $i_destinos = isset($_POST['DataDestinatario']) ? json_encode($_POST['DataDestinatario']) : '';

            $params = array(
                $i_tipo,
                $i_codigo,
                $nFlgTipoDoc,
                $i_cCodTipoDoc,
                $i_cAsunto,
                $i_cCuerpoDocumento,
                $i_cObservaciones,
                $i_cReferencia,
                $i_cAnexos,
                $i_cAnexosImprimibles,
                $tiempoPlazo,
                $i_flgSigo,
                $i_flgEncriptado,
                NULL,
                // $i_destinos,
                $_SESSION['CODIGO_TRABAJADOR']
            );
            $sqlUpdate = "{call SP_UPDATE_DATOS_DOCUMENTO (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlUpdate, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            if($i_destinos != ''){
                foreach (json_decode($i_destinos) as $key => $value) {
                    if($value->id == 0){
                        $params = array(
                            $i_codigo,
                            $value->icodOficina ?? NULL,
                            $value->icodResponsable ?? NULL,
                            $value->iCodPerfil ?? NULL,
            
                            $value->iCodRemitente ?? NULL,
                            $value->flgMostrarDireccion ?? NULL,
                            $value->IdSede ?? NULL,
                            $value->cDireccion ?? NULL,
                            
                            $value->preFijo ?? NULL,
                            $value->nombreResponsable ?? NULL,
                            $value->cargoResponsable ?? NULL,
            
                            $value->idTipoEnvio ?? NULL,
                            $value->unidadOrganicaDstIOT ?? NULL,
                            $value->personaDstIOT ?? NULL,
                            $value->cargoPersonaDstIOT ?? NULL,
                            $value->observacionesDespacho ?? NULL,
                            $value->foliosDespacho ?? NULL,
                            $value->idPersonaExterna ?? NULL,
            
                            $value->cCopia ?? NULL,
            
                            $_SESSION['IdSesion']
                        );
            
                        $sqlAdd = "{call SP_PROYECTO_DESTINO_INSERTAR (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
                        $rs = sqlsrv_query($cnx, $sqlAdd, $params);
                        if($rs === false) {
                            http_response_code(500);
                            die(print_r(sqlsrv_errors()));
                        }
                    }
                }
            }
            break;

        case "GuardarDatosDespacho":
            $params = array(
                $_POST['IdProyectoDespacho'],
                json_encode(
                    array(
                        "IdTipoEnvio" => $_POST['IdTipoEnvio']??0,
                        "ObservacionesDespacho" => $_POST['ObservacionesDespacho']??'',
                        "UnidadOrganicaDstIOT" => $_POST['UnidadOrganicaDstIOT']??'',
                        "PersonaDstIOT" => $_POST['PersonaDstIOT']??'',
                        "CargoPersonaDstIOT" => $_POST['CargoPersonaDstIOT']??'',
                        "DireccionDespacho" => $_POST['DireccionDespacho']??'',
                        "DepartamentoDespacho" => $_POST['DepartamentoDespacho']??'',
                        "ProvinciaDespacho" => $_POST['ProvinciaDespacho']??'',
                        "DistritoDespacho" => $_POST['DistritoDespacho']??'',
                        "IdPersonaExterna" => $_POST['IdPersonaExterna']??'',
                        "FoliosDespacho" => $_POST['FoliosDespacho']??''
                    )
                )
            );
            $sql = "{call UP_GUARDAR_DATOS_DESPACHO (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "GenerarDocumento":
            $params = array(
                $_POST['codigo'],
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin']
            );

            $sqlGenerarDoc = "{call SP_INSERT_TRAMITEXPROYECTO (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlGenerarDoc, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $dataFirma = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

            $params = array(
                0,
                $_POST['codigo']
            );
            $sqlAdd = "{call SP_CONSULTA_DATOS_DOCUMENTO_DESTINATARIOS (?,?) }";
            $rs = sqlsrv_query($cnx, $sqlAdd, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            
            $destinatarios = [];
            if(sqlsrv_has_rows($rs)){ 
                while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
                    $destinatarios[]=$row;
                }
            }
            $destinoExterno = [];
            if($dataFirma['nFlgTipoDoc'] == 2){
                $destinoExterno['iCodRemitente'] = 0;
                include("../documento_pdf.php");

                $flgSegundoPdf = 1;
                
                include("../documento_pdf.php");

                unset($flgSegundoPdf);
            } else {
                foreach($destinatarios as $indexE => $destinoExterno){
                    if($destinoExterno['idTramiteNotificacion'] != null && $destinoExterno['idTramiteNotificacion'] != 0){
                        $paramsN = array(
                            $destinoExterno['idTramiteNotificacion']
                        );
            
                        $sqlGenerarDocN = "{call SP_CONSULTA_DATOS_DOCUMENTO_NOTIFICACION (?) }";
                        $rsN = sqlsrv_query($cnx, $sqlGenerarDocN, $paramsN);
                        if($rsN === false) {
                            http_response_code(500);
                            die(print_r(sqlsrv_errors()));
                        }
                        $dataNotificacion= sqlsrv_fetch_array($rsN,SQLSRV_FETCH_ASSOC);
                    }
    
                    include("../documento_pdf.php");
                    // $resultado = array(
                    //     'url' => $ruta,
                    //     'cud' => $dataFirma['nCud']
                    // );
    
                    if($destinoExterno['idTramiteNotificacion'] != null && $destinoExterno['idTramiteNotificacion'] != 0){
                        include("../documento_notificacion_pdf.php");
                    }
    
                    $flgSegundoPdf = 1;
                    
                    include("../documento_pdf.php");
                    if($destinoExterno['idTramiteNotificacion'] != null && $destinoExterno['idTramiteNotificacion'] != 0){
                        include("../documento_notificacion_pdf.php");
                    }
    
                    unset($flgSegundoPdf);
                }                
            } 

            $resultado = array(
                'iCodTramite' => $dataFirma['iCodTramite'],
                'cud' => $dataFirma['nCud']
            );

            if($dataFirma['flgEncriptado'] == 1){
                $nombres = $dataFirma['nombreTrabajador'];
                $correo = $dataFirma['correoTrabajador'];
                $nombre_doc = $dataFirma['descDoc'].' '.$dataFirma['cCodificacion'];

                $asunto = 'CLAVE DOCUMENTO ENCRIPTADO';
                $cuerpo = '<p>Estimado(a) '.$nombres.', el documento '.$nombre_doc.' tiene como clave para su visualización: '.$dataFirma['clave'];

                $correos = [];
                array_push($correos,$correo);

                $mail = new Email();
                $mail->Enviar($asunto, $correos, $cuerpo);

                // $mail = new PHPMailer(true);
                // try {                
                //     $mail->SMTPDebug = 0;
                //     $mail->isSMTP(); 
                //     $mail->Host = 'smtp.gmail.com';
                //     $mail->SMTPAuth = true; 
                //     $mail->Username = 'd-tramite@apci.gob.pe';
                //     $mail->Password = 'Hacker147';
                //     $mail->SMTPSecure = 'ssl';                     
                //     $mail->Port = 465;
                //     $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                //     for ($e = 0; $e < count($correos); $e++){
                //         $mail->addAddress($correos[$e]);
                //     }
                //     $mail->isHTML(true);
                //     $mail->Subject = $asunto;
                //     $mail->Body = $cuerpo;
                //     $mail->CharSet = 'UTF-8';
                //     $mail->AltBody = 'No responder';
                //     $mail->send();
                // } catch (Exception $e) {
                //     //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                // }
            }

            echo json_encode($resultado);
            break;

        case "GenerarDocumentoLote":
            foreach ($_POST['Codigos'] as $i) {
                $params = array(
                    $i['codigo'],
                    $_SESSION['CODIGO_TRABAJADOR'],
                    $_SESSION['iCodOficinaLogin']
                );

                $sqlGenerarDoc = "{call SP_INSERT_TRAMITEXPROYECTO (?,?,?) }";
                $rs = sqlsrv_query($cnx, $sqlGenerarDoc, $params);
                if($rs === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
                $dataFirma = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

                $params = array(
                    0,
                    $i['codigo']
                );
                $sqlAdd = "{call SP_CONSULTA_DATOS_DOCUMENTO_DESTINATARIOS (?,?) }";
                $rs = sqlsrv_query($cnx, $sqlAdd, $params);
                if($rs === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }

                $destinatarios = [];
                if(sqlsrv_has_rows($rs)){ 
                    while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
                        $destinatarios[]=$row;
                    }
                }

                $destinoExterno = [];
                if($dataFirma['nFlgTipoDoc'] == 2){
                    $destinoExterno['iCodRemitente'] = 0;
                    include("../documento_pdf.php");
    
                    $flgSegundoPdf = 1;
                    
                    include("../documento_pdf.php");
    
                    unset($flgSegundoPdf);
                } else {
                    foreach($destinatarios as $indexE => $destinoExterno){
                        if($destinoExterno['idTramiteNotificacion'] != null && $destinoExterno['idTramiteNotificacion'] != 0){
                            $paramsN = array(
                                $destinoExterno['idTramiteNotificacion']
                            );
                
                            $sqlGenerarDocN = "{call SP_CONSULTA_DATOS_DOCUMENTO_NOTIFICACION (?) }";
                            $rsN = sqlsrv_query($cnx, $sqlGenerarDocN, $paramsN);
                            if($rsN === false) {
                                http_response_code(500);
                                die(print_r(sqlsrv_errors()));
                            }
                            $dataNotificacion= sqlsrv_fetch_array($rsN,SQLSRV_FETCH_ASSOC);
                        }
        
                        include("../documento_pdf.php");
                        // $resultado = array(
                        //     'url' => $ruta,
                        //     'cud' => $dataFirma['nCud']
                        // );
        
                        if($destinoExterno['idTramiteNotificacion'] != null && $destinoExterno['idTramiteNotificacion'] != 0){
                            include("../documento_notificacion_pdf.php");
                        }
        
                        $flgSegundoPdf = 1;
                        
                        include("../documento_pdf.php");
                        if($destinoExterno['idTramiteNotificacion'] != null && $destinoExterno['idTramiteNotificacion'] != 0){
                            include("../documento_notificacion_pdf.php");
                        }
        
                        unset($flgSegundoPdf);
                    }                
                }
    
                if($dataFirma['flgEncriptado'] == 1){
                    $nombres = $dataFirma['nombreTrabajador'];
                    $correo = $dataFirma['correoTrabajador'];
                    $nombre_doc = $dataFirma['descDoc'].' '.$dataFirma['cCodificacion'];
    
                    $asunto = 'CLAVE DOCUMENTO ENCRIPTADO';
                    $cuerpo = '<p>Estimado(a) '.$nombres.', el documento '.$nombre_doc.' tiene como clave para su visualización: '.$dataFirma['clave'];
    
                    $correos = [];
                    array_push($correos,$correo);

                    $mail = new Email();
                    $mail->Enviar($asunto, $correos, $cuerpo);
    
                    // $mail = new PHPMailer(true);
                    // try {                
                    //     $mail->SMTPDebug = 0;
                    //     $mail->isSMTP(); 
                    //     $mail->Host = 'smtp.gmail.com';
                    //     $mail->SMTPAuth = true; 
                    //     $mail->Username = 'd-tramite@apci.gob.pe';
                    //     $mail->Password = 'Hacker147';
                    //     $mail->SMTPSecure = 'ssl';                     
                    //     $mail->Port = 465;
                    //     $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                    //     for ($e = 0; $e < count($correos); $e++){
                    //         $mail->addAddress($correos[$e]);
                    //     }
                    //     $mail->isHTML(true);
                    //     $mail->Subject = $asunto;
                    //     $mail->Body = $cuerpo;
                    //     $mail->CharSet = 'UTF-8';
                    //     $mail->AltBody = 'No responder';
                    //     $mail->send();
                    // } catch (Exception $e) {
                    //     //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                    // }
                }                
            }
            
            echo json_encode(array(
                "ok" => true,
                "mensaje" => "Generados correctamente"
            ));
            break;

        case "ActualizaEstadosSellosDocumentos":
            $params = array(
                $_POST['tipo'],
                $_POST['codigo'],
                $_SESSION['CODIGO_TRABAJADOR']
            );

            $sqlActualizaEstado = "{call SP_UPDATE_ESTADOS_VISTO_FIRMA (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlActualizaEstado, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "RevisarDocumento":
            $params = array(
                $_POST['movimiento'][0],
                $_SESSION['CODIGO_TRABAJADOR']
            );
            $sqlUpRevisar = "{call SP_UPDATE_CAMBIO_REVISAR (?,?) }";
            $rs = sqlsrv_query($cnx, $sqlUpRevisar, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
            echo json_encode($Rs);
            break;

        case "ConsultaRespuestaDocumento":
            $params = array(
                $_POST['movimiento']
            );
            $sqlConsultaResp = "{call SP_CONSULTA_RESPONDER (?) }";
            $rs = sqlsrv_query($cnx, $sqlConsultaResp, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
            echo json_encode($Rs);
            break;

        case "RespuestaDocumento":
            $params = array(
                $_POST['movimiento'],
                $_SESSION['CODIGO_TRABAJADOR']
            );
            $sqlUpResp = "{call SP_UPDATE_CAMBIO_RESPONDER (?,?) }";
            $rs = sqlsrv_query($cnx, $sqlUpResp, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "Devolver":
            $params = array(
                $_POST['cAgrupado'],
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin'],
                $_SESSION['iCodPerfilLogin'],
                $_POST['cTrabajadorDevolver'],
                $_POST['cOficinaDevolver'],
                $_POST['obsDevolver']??''
            );

            $sqlEnvioVisto = "{call SP_ENVIAR_PARA_DEVOLUCION (?,?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlEnvioVisto, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "AnularTramiteGenerado":
            $params = array(
                $_POST['codigo'],
                'Documento anulado a solicitud del documento responsable de firma.',
                $_SESSION['IdSesion'],
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodPerfilLogin'],
                $_SESSION['iCodOficinaLogin']                
            );
            $sqlAnularDoc = "{call UP_ANULAR_DOCUMENTO_GENERADO (?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlAnularDoc, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "ValidarPassword":
            $params = array(
                $_POST['codigo'],
                $_POST['valor']
            );
            $sqlvalidar = "{call UP_VALIDAR_CONTRASEA (?,?) }";
            $rs = sqlsrv_query($cnx, $sqlvalidar, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $datos = new stdClass();
            if(sqlsrv_has_rows($rs)){                
                $datos->validacion = true;                                
            }else {
                $datos->validacion = false;  
            }
            echo json_encode($datos);
            break;

        case "BuscarEntidadSugerencia":
            $params = array(
                $_POST['cud'],
            );
            $sqlentidadsugerencia = "{call UP_ENTIDAD_SUGERENCIA (?) }";
            $rs = sqlsrv_query($cnx, $sqlentidadsugerencia, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $data = new stdClass();
            if(sqlsrv_has_rows($rs)){
                $data->tiene = true;
                $datos = array();
                while($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
                    array_push($datos,$Rs);
                }
                $data->datos = $datos;
            }else {
                $data->tiene = false;
            }                           
            echo json_encode($data);
            break;

        case "BuscarDocumentosAntecedentes":
            $params = array(
                $_POST['cud'],
            );
            $sqlentidadsugerencia = "{call UP_DOCUMENTOS_ANTECESORES (?) }";
            $rs = sqlsrv_query($cnx, $sqlentidadsugerencia, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $data = new stdClass();
            if(sqlsrv_has_rows($rs)){
                $data->tieneAntecendetes = true;
                $documentos = array();
                while($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
                    $datos = array();
                    $datos['id'] = $Rs['id'];
                    $datos['nombre'] = $Rs['nombre'];
                    $datos['fecha'] = $Rs['fecha'];
                    if($Rs['nroAnexos'] > 0){
                        $datos['tieneAnexos'] = true;
                    }else {
                        $datos['tieneAnexos'] = false;
                    }
                    $datos['flgEncriptado'] = $Rs['flgEncriptado'];
                    $datos['iCodTrabajadorFirmante'] = $Rs['iCodTrabajadorFirmante'];
                    $datos['iCodOficinaFirmante'] = $Rs['iCodOficinaFirmante'];
                    array_push($documentos,$datos);
                }
                $data->datos = $documentos;
            }else {
                $data->tieneAntecendetes = false;
            }

            echo json_encode($data);
            break;

        case "ConsultarRucInteroperabilidad":
            // $options = array(
            //     'exceptions'=>true,
            //     'trace'=>1,
            //     'location' => INTEROPERABILIDAD_ENTIDAD            
            // );
            // $client = new SoapClient(INTEROPERABILIDAD_ENTIDAD,$options);
            // $parameters = array(
            //     'vrucent' => trim($_POST['Ruc'])
            // );
            // $service = $client->validarEntidad($parameters);
            // $result = new stdClass();
            // $result->MessageResult = $service->return;
            $result = new stdClass();
            $result->MessageResult = '-1';
            echo json_encode($result);       
            break;

        case "ConsultarDocPermitidosInteroperabilidad":
            $options = array(
                'exceptions'=>true,
                'trace'=>1,
                'location' => INTEROPERABILIDAD_TRAMITE            
            );
            $client = new SoapClient(INTEROPERABILIDAD_TRAMITE,$options);
            $service = $client->getTipoDocumento();
            $result = new stdClass();
            $result->ListResult = $service->return;
            echo json_encode($result);            
            break;
        case "EvaluacionSigcti":
            $retorno = new StdClass();


            echo json_encode($retorno);            
            break;

        case "ObtenerArchivoComprimido":
            $response = new stdClass();
            $response->ok = false;

            $docDigital = new DocDigital($cnx);

            $nombreComprimido = date('Ymd').date('Gis').'firmaLote';
            $rutaTempZip = '../../archivosTemp/'.$nombreComprimido.'.zip';  
            $rutaTemp7z = '../../archivosTemp/'.$nombreComprimido.'.7z';       

            foreach ($_POST['Codigos'] as $i) {
                $paramsDatos = array(
                    '',
                    'tramite',
                    $i['codigo'],
                    ''
                );
                $sqlDatos = "{call SP_CONSULTA_DATOS_DOCUMENTO (?,?,?,?) }";
                $rsDatos = sqlsrv_query($cnx, $sqlDatos, $paramsDatos);
                if($rsDatos === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }

                $RsDatos = sqlsrv_fetch_array($rsDatos,SQLSRV_FETCH_ASSOC);              

                if($RsDatos['nFlgTipoDoc'] == 2){
                    $docDigital->idTramite = $i['codigo'];
                    $docDigital->idTipo = 0;
                    $docDigital->idEntidad = 0;
                    $docDigital->obtenerDocMayor();

                    if($docDigital->idDocDigital > 0){
                        if ($docDigital->idTipo == 2){    
                            $docDigital->idTramite = $i['codigo'];
                            $docDigital->idTipo = 8;
                            $docDigital->obtenerDocMayor();
                        }

                        $result = Zip::agregarArchivo($rutaTempZip,$i['codigo'].'-'.'0'.'-'.$docDigital->clearName,$docDigital->obtenerDocBinario());
                    }
                } else {
                    $params = array(
                        $i['codigo'],
                        0
                    );
                    $sqlAdd = "{call SP_CONSULTA_DATOS_DOCUMENTO_DESTINATARIOS (?,?) }";
                    $rs = sqlsrv_query($cnx, $sqlAdd, $params);
                    if($rs === false) {
                        http_response_code(500);
                        die(print_r(sqlsrv_errors()));
                    }
    
                    $destinatarios = [];
                    if(sqlsrv_has_rows($rs)){ 
                        while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
                            $destinatarios[]=$row;
                        }
                    }

                    foreach($destinatarios as $indexE => $destinoExterno){
                        $docDigital->idTramite = $i['codigo'];
                        $docDigital->idTipo = 0;
                        $docDigital->idEntidad = $destinoExterno['iCodRemitente'];
                        $docDigital->obtenerDocMayor();

                        if($docDigital->idDocDigital > 0){
                            if ($docDigital->idTipo == 2){    
                                $docDigital->idTramite = $i['codigo'];
                                $docDigital->idTipo = 8;
                                $docDigital->obtenerDocMayor();
                            }

                            $result = Zip::agregarArchivo($rutaTempZip,$i['codigo'].'-'.$destinoExterno['iCodRemitente'].'-'.$docDigital->clearName,$docDigital->obtenerDocBinario());
                        }

                        if($destinoExterno['idTipoEnvio'] == 98){
                            $docDigital->idTramite = $destinoExterno['idTramiteNotificacion'];
                            $docDigital->idTipo = 0;
                            $docDigital->idEntidad = 0;
                            $docDigital->obtenerDocMayor();

                            if($docDigital->idDocDigital > 0){
                                if ($docDigital->idTipo == 2){    
                                    $docDigital->idTramite = $destinoExterno['idTramiteNotificacion'];
                                    $docDigital->idTipo = 8;
                                    $docDigital->obtenerDocMayor();
                                }

                                $result = Zip::agregarArchivo($rutaTempZip,$destinoExterno['idTramiteNotificacion'].'-'.'0'.'-'.$docDigital->clearName,$docDigital->obtenerDocBinario());
                            }
                        }
                    }                
                }                
            }

            $command = 'arepack -e -F '.$rutaTemp7z.' '.$rutaTempZip.' 2>&1';
            $execResult = shell_exec($command);

            $agrupado = $_SESSION['iCodOficinaLogin'].$_SESSION['CODIGO_TRABAJADOR'].date("YmdGis");

            $comprimido = new DocDigital($cnx);
            $comprimido->idTipo = 3;
            $comprimido->idOficina = $_SESSION['iCodOficinaLogin'];
            $comprimido->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
            $comprimido->grupo = $agrupado;  
            
            $comprimido->tmp_name = $rutaTemp7z;
            $comprimido->name = $nombreComprimido.'.7z';
            $comprimido->type = "application/x-7z-compressed";

            if($comprimido->subirDocumento()){
                $response->ok = true;
                $response->data = $comprimido->idDocDigital;
            }

            DocDigital::eliminar($rutaTempZip);
            DocDigital::eliminar($rutaTemp7z);

            echo json_encode($response);
            break;

        case "ObtenerArgumentosFirmaLote":
            $docDigital = new DocDigital($cnx);
            $docDigital->obtenerDocDigitalPorId($_POST['IdDigitalLote']);

            $type=$_POST['Tipo'];
            $razon = 'Soy el autor del documento';
            $documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
            $posx =515;
            $posy =174;
            $documentName = $docDigital->clearName;
            $firma = "https://files.apci.gob.pe/srv-files/firmas/default/firma.png";

            $param ='{
                "app":"pcx",
                "mode":"lot-p",
                "clientId":"'.$CLIENTID.'",
                "clientSecret":"'.$CLIENTSECRET.'",
                "idFile":"MyForm",
                "type":"'.$type.'",
                "protocol":"S",
                "fileDownloadUrl":"'.$documenturl.'",
                "fileDownloadLogoUrl":"'.$SERVER_PATH.'/resources/img/iLogo1.png",
                "fileDownloadStampUrl":"'.$firma.'",
                "fileUploadUrl":"'.$FILEUPLOADURL.'",
                "contentFile":"'.$documentName.'",
                "reason":"'.$razon.'",
                "isSignatureVisible":"true",
                "stampAppearanceId":"2",
                "pageNumber":"0",
                "posx":"'.$posx.'",
                "posy":"'. $posy.'",
                "fontSize":"7",
                "dcfilter":".*FIR.*|.*FAU.*",
                "signatureLevel":"1",
                "maxFileSize":"5242880"
            }';

            $paramentro = base64_encode($param);
            echo json_encode(["args" => $paramentro]);
            break;

        case "RecuperarFirmadoLote":
            $response = new stdClass();
            $response->ok = false;

            $idDigital = $_POST['IdDigitalLote'];
            $docDigitalOriginal = new DocDigital($cnx);
            $docDigitalOriginal->obtenerDocDigitalPorId($idDigital);

            $docDigital = new DocDigital($cnx);
            $docDigital->idTipo = 3;

            $nombreFile = $docDigitalOriginal->clearName;

            $arrayExploded = explode('.',$nombreFile);
            $extension = '.'.array_pop($arrayExploded);
            $nuevoNombre = implode('.',$arrayExploded);

            $nombreFile = urlencode($nuevoNombre."[R]");

            $separa=DIRECTORY_SEPARATOR;
            $tmp = dirname(tempnam (null,''));

            $tmp_name7z = $tmp.$separa."upload".$separa.$nombreFile.'.7z';
            $tmp_nameZip = $tmp.$separa."upload".$separa.$nombreFile.'.zip';

            shell_exec('arepack -e -F '.$tmp_nameZip.' '.$tmp_name7z);

            $fileFirmado = new ZipArchive;            
            if ($fileFirmado->open($tmp_nameZip) === TRUE) 
            {          
                $tramiteID = 0;
                for($i = 0; $i < $fileFirmado->numFiles; $i++) 
                {   
                    $nombrei = $fileFirmado->getNameIndex($i);
                    $codigoi = explode('-',$nombrei)[0];
                    $destinoi = explode('-',$nombrei)[1];
                    $contenti = $fileFirmado->getFromIndex($i);
                    $tmp_namei = $tmp.$separa."upload".$separa.$nombrei;

                    $arrayNameSinR = explode('-',implode('',explode('[R]',$nombrei)));
                    array_shift($arrayNameSinR);
                    array_shift($arrayNameSinR);
                    $clearNamei = implode('-',$arrayNameSinR);

                    file_put_contents($tmp_namei,$contenti);

                    $docDigitali = new DocDigital($cnx);                    
                    $docDigitali->idTipo = 1;
                    $docDigitali->tmp_name = $tmp_namei;
                    $docDigitali->name = $clearNamei;
                    $docDigitali->type = 'application/pdf';
                    $docDigitali->idTramite = $codigoi;
                    $docDigitali->idEntidad = $destinoi;
                    $docDigitali->idOficina = $_SESSION['iCodOficinaLogin'];
                    $docDigitali->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];

                    if($docDigitali->subirDocumento()){
                        $params = array(
                            'f',
                            $codigoi,
                            $_SESSION['CODIGO_TRABAJADOR']
                        );
            
                        $sqlActualizaEstado = "{call SP_UPDATE_ESTADOS_VISTO_FIRMA (?,?,?) }";
                        $rs = sqlsrv_query($cnx, $sqlActualizaEstado, $params);
                        if($rs === false) {
                            http_response_code(500);
                            die(print_r(sqlsrv_errors()));
                        }

                        if($tramiteID != $codigoi){
                            $tramiteID = $codigoi;
                            $docDigitali->obtenerDocDigitalPorId($docDigitali->idDocDigital);
                            enviarCorreoAsistentes($tramiteID, $docDigitali->clearName, RUTA_DTRAMITE.$docDigitali->obtenerRutaDocDigital(), $cnx);
                        }                        
                    }                    
                }
            }

            $response->ok = true;
            
            echo json_encode($response);
            break;

        default :
            echo "sin data";
    }
}else{
    header("Location: ../../index-b.php?alter=5");
}
?>