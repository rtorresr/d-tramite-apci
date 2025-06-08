<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

include_once("../../conexion/conexion.php");
include_once("../../conexion/srv-Nginx.php");
session_start();

switch ($_POST['Evento']){
    case 'RegistrarOrden':
        if (isset($_POST['flgEnvioPropio'])){
            $parametros = array(
                1
                ,NULL
                ,$_POST['codEmpresaResponsable']??NULL
                ,$_POST['nroDNI']??''
                ,$_POST['nombreResponsableExterno']??''
                ,json_encode($_POST['despachoDetalle'])
                ,$_SESSION['IdSesion']
            );
        } else {
            $parametros = array(
                0
                ,$_POST['codTrabajadorMensajeria']??NULL
                ,NULL
                ,''
                ,''
                ,json_encode($_POST['despachoDetalle'])
                ,$_SESSION['IdSesion']
                );
        }

        $sql = "{call UP_INSERTAR_ORDEN_DESPACHO (?,?,?,?,?,?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
        echo json_encode($Rs);
        break;

    case 'FinalizarEntrega':
        $parametros = array(
             $_POST['codDespachoOrden']
            ,$_POST['nroOrden']
            ,json_encode($_POST['documentoEntrega'])
            ,$_SESSION['IdSesion']
        );

        $sql = "{call UP_ACTUALIZAR_ORDEN_DESPACHO_FINALIZAR_ENTREGA (?,?,?,?)}";
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;

    case 'RegistrarDevolucion':
        if (isset($_POST['flgEnvioPropioDevolucion'])) {
            $parametros = array(
                1
                ,$_POST['nroDevolucion']
                ,NULL
                ,$_POST['codEmpresaMensajeriaDevolucion']??NULL
                ,$_POST['nroDNIDevolucion']??''
                ,$_POST['nombreResponsableExternoDevolucion']??''
                ,json_encode($_POST['despachoDetalleDevolucion'])
                ,json_encode($_POST['documentoDevolucion'])
                ,$_SESSION['IdSesion']
                );
        } else {
            $parametros = array(
                0
                ,$_POST['nroDevolucion']
                ,$_POST['codTrabajadorMensajeriaDevolucion']??NULL
                ,NULL
                ,''
                ,''
                ,json_encode($_POST['despachoDetalleDevolucion'])
                ,json_encode($_POST['documentoDevolucion'])
                ,$_SESSION['IdSesion']
                );
        }

        $sql = "{call UP_INSERTAR_DESPACHO_DEVOLUCION (?,?,?,?,?,?,?,?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;

    case 'ListarDetalleDevolucion':
        $parametros = array(
            $_POST['IdDespachoDevolucion']
        );

        $sql = "{call UP_LISTAR_DESPACHO_DETALLE_DEVOLUCION (?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $data = array();
        while ($Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            array_push($data, $Rs);
        }
        $recordsTotal=sqlsrv_num_rows($rs);
        $recordsFiltered=sqlsrv_num_rows($rs);

        $json_data = array(
            "draw"            => (int)($request['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $data
        );

        echo json_encode($json_data);
        break;

    case 'CompletarDevolucion':
        $fechaContacto = date('Y-m-d',strtotime($_POST['FecContactoCompletar']));

        $parametros = array(
            $_POST['flgNotificacionCorrecto']??0
            ,$_POST['codigoDetalle']
            ,$fechaContacto
            ,$_POST['codContacto']
            ,$_POST['codTipoContacto']
            ,$_POST['observacionComDev']
            ,$_POST['nroVisitasDev']
            ,$_POST['codTipoMalNotificado']??NULL
            ,json_encode($_POST['documentoCargo'])
            ,$_SESSION['IdSesion']
        );

        $sql = "{call UP_COMPLETAR_DEVOLUCION (?,?,?,?,?,?,?,?,?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

        while($res = sqlsrv_next_result($rs)){
            if( $res ) {
                while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                    $resultado = $row;
                }
            } elseif( is_null($res)) {
                echo "No se Pudo Registrar el Proyecto";
                return;
            } else {
                die(print_r(sqlsrv_errors(), true));
            }
        }
        $Rs = $resultado;

        $nombreDoc = $Rs['NombreDocumento'];
        $RutaCargo = $Rs['RutaCargo'];
        $ObservacionesCargo = $Rs['ObservacionesCargo'];
        $correo = json_decode($Rs['CorreosCargo'], true);

        $asunto = 'Cargo del documento '.$nombreDoc;
        $cuerpo = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#ccc!important"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width"><title>Alerta de cargo de documento</title><style>@media only screen{html{min-height:100%;background:#f3f3f3}}@media only screen and (max-width:596px){.small-float-center{margin:0 auto!important;float:none!important;text-align:center!important}}@media only screen and (max-width:596px){table.body img{width:auto;height:auto}table.body center{min-width:0!important}table.body .container{width:95%!important}table.body .columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:16px!important;padding-right:16px!important}table.body .columns .columns{padding-left:0!important;padding-right:0!important}table.body .collapse .columns{padding-left:0!important;padding-right:0!important}th.small-6{display:inline-block!important;width:50%!important}th.small-12{display:inline-block!important;width:100%!important}.columns th.small-12{display:block!important;width:100%!important}table.menu{width:100%!important}table.menu td,table.menu th{width:auto!important;display:inline-block!important}table.menu.vertical td,table.menu.vertical th{display:block!important}table.menu[align=center]{width:auto!important}}</style></head><body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#ccc!important;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"><span class="preheader" style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span>
                    <table class="body" style="Margin:0;background:#ccc!important;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><center data-parsed style="min-width:580px;width:100%"><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%">
                    <tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
                    <tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table bgcolor="#2f4576" class="wrapper header with-bg-img--dark" align="center" style="background:#3b5998;border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:20px;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                    <tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-6 large-6 columns first" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:8px;text-align:left;width:274px">
                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                    <img src="http://www.apci.gob.pe/images/apps/dt__logo.png" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:195px"></th></tr></table></th><th class="small-6 large-6 columns last" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:8px;padding-right:16px;text-align:left;width:274px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><h6 class="text-right description" style="Margin:0;Margin-bottom:10px;color:#fff;font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:400;line-height:1.3;margin:0;margin-bottom:0;margin-top:0;padding:0;padding-top:0;text-align:right;word-wrap:normal">
                    Alerta de cargo de documento</h6></th></tr></table></th></tr></tbody></table></td></tr></table></td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="24px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;hyphens:auto;line-height:24px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p class="lead" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:400;line-height:1.6;margin:0;margin-bottom:10px;padding:0;text-align:left">
                    Estimado(a), <strong></strong>:</p><p style="Margin:0;Margin-bottom:10px;color:#484848;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.5;margin:0;margin-bottom:10px;padding:0;text-align:left">
                    Se remite el cargo retornado a la APCI por mesa de partes a través del Sistema D-Trámite del documento : '.$nombreDoc.'</p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                    <tbody><tr style="padding:0;text-align:left;vertical-align:top">
                    <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table class="callout" style="Margin-bottom:16px;border-collapse:collapse;border-spacing:0;margin-bottom:16px;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th class="callout-inner secondary" style="Margin:0;background:#faf0e1;border:1px solid #986517;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:10px;text-align:left;width:100%">
                    <p><strong>Documento</strong></p><p>'.$nombreDoc.'</p>'.(trim($ObservacionesCargo) == "" ? "" : "<p><strong>Observación</strong></p><p>".$ObservacionesCargo."</p>" ).'</th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table><table class="button expanded secondary" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;margin:0 0 16px 0;padding:0;text-align:left;vertical-align:top;width:100%!important"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#e09c35;border:0 solid #e09c35;border-collapse:collapse!important;color:#fefefe;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><center data-parsed style="min-width:0;width:100%">
                    <a href="'.$url_srv.$RutaCargo.'" align="center" class="float-center" style="Margin:0;border:0 solid #e09c35;border-radius:3px;color:#fefefe;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:700;line-height:1.3;margin:0;padding:8px 16px 8px 16px;padding-left:0;padding-right:0;text-align:center;text-decoration:none;width:100%">Ver Documento</a></center></td></tr></table></td><td class="expander" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0!important;text-align:left;vertical-align:top;visibility:hidden;width:0;word-wrap:break-word"></td></tr></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
                    Atentamente,</p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
                    D-Trámite - APCI</p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></tbody></table><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><table align="center" class="container footer__container float-center" style="Margin:0 auto;background:#fefefe;background-color:transparent!important;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                    <table bgcolor="transparent" class="wrapper" align="center" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row footer__pos" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" valign="middle" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center"><img style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:auto" src="http://www.apci.gob.pe/images/apps/apci__logo.png" height="50"></p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">
                    <small style="color:#616161!important;font-size:80%">Toda la información contenida en este mensaje es confidencial y de uso exclusivo de APCI.<br>Si ha recibido este mensaje por error, por favor proceda a eliminarlo y notificar al remitente.</small></p></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></table></td></tr></tbody></table><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></center></td></tr></table><!-- prevent Gmail on iOS font size manipulation --><div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div></body></html>';
        ;

        $correos = [];
        foreach ($correo AS $i => $j){
            array_push($correos,$j['cMailTrabajador']);
        }

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

            //Content
            $mail->isHTML(true);// Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->CharSet = 'UTF-8';
            $mail->AltBody = 'No responder';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        break;
    default:
        echo 'Sin data';
        break;
}


