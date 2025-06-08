<?php
include_once "../../conexion/conexion.php";

include_once("../../conexion/srv-Nginx.php");
include_once("../../conexion/parametros.php");
include_once("../../core/CURLConection.php");

require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

include_once("../../views/registerDoc/phpqrcode/qrlib.php");

date_default_timezone_set('America/Lima');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$url_srv = $hostUpload . ':' . $port . $path;

function generarQrMP ($codTramite,$estado,$cnx,$url_srv,$fileUpload,$codTrabajador) {
    if ($estado === 1) {
        $params = array(
            '',
            'tramite',
            $codTramite,
            ''
        );
        $sqldatos = "{call SP_CONSULTA_DATOS_DOCUMENTO (?,?,?,?) }";
        $rsdatos = sqlsrv_query($cnx, $sqldatos, $params);
        if($rsdatos === false) {
            print_r('Error al obtener datos del documento.');
            print_r('generar qr');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        if(sqlsrv_has_rows($rsdatos)){
            $Rrdatos = sqlsrv_fetch_array($rsdatos,SQLSRV_FETCH_ASSOC);
        }

        $tmp = dirname(tempnam(null, ''));
        $tmp = $tmp . "/upload/";
        if (!is_dir($tmp)) {
            mkdir($tmp, 0777, true);
        }

        $PNG_TEMP_DIR = $tmp;
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 2;

        $_REQUEST['data'] = $_SERVER['HTTP_HOST'] . '/views/consulta-web.php?cCodificacion='.$Rrdatos['nCud'].'&contrasena='.$Rrdatos['clave'];

        $codigoQr = 'QR' . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
        $filename = $PNG_TEMP_DIR . $codigoQr;
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);


        $nomenclatura = date('Y').'/'.date('m').'/'.date('d').'/'.$_SESSION['iCodOficinaLogin'].'/'.$_SESSION['CODIGO_TRABAJADOR'].'/'.$Rrdatos['cAgrupado'];
        $url_f = 'docEntrada/' . $nomenclatura . '/';

        $_FILES['fileUpLoadDigital']['tmp_name'] = $filename;
        $_FILES['fileUpLoadDigital']['name'] = $codigoQr;
        $_FILES['fileUpLoadDigital']['type'] = 'PNG';

        $_POST['path'] = $url_f;
        $_POST['name'] = 'fileUpLoadDigital';
        $_POST['new_name'] = $codigoQr;

        $curl = new CURLConnection($url_srv.$fileUpload);
        $curl->uploadFile($_FILES,$_POST);
        $urlQR = 'http://'.$url_srv.$url_f.$codigoQr;
        $curl->closeCurl();

        $paramtroQR = array(
            $urlQR,
            $codTramite,
            $codTrabajador
        );
        $sqlInsertarQR = "{call SP_INSERTAR_QR (?,?,?) }";
        $rsInsertarQR= sqlsrv_query($cnx, $sqlInsertarQR, $paramtroQR);
        if($rsInsertarQR === false) {
            print_r('Error al guardar url del QR en la bd.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    };
};

function generarCud ($codTramite, $estado,$cnx,$codTrabajador) {
    if ($estado === 1) {
        $parametro = array(
            $codTramite,
            $codTrabajador
        );
        $sqlCud = "{call SP_GENERAR_CUD (?,?) }";
        $rsSql = sqlsrv_query($cnx, $sqlCud, $parametro);
        if($rsSql === false) {
            print_r('Error al generar el cud.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    }
}

function generarHojaIngreso ($codTramite, $estado, $cnx,$url_srv) {
    $params = array(
        '',
        'tramite',
        $codTramite,
        ''
    );
    $sqldatos = "{call SP_CONSULTA_DATOS_DOCUMENTO (?,?,?,?) }";
    $rsdatos = sqlsrv_query($cnx, $sqldatos, $params);
    if($rsdatos === false) {
        print_r('Error al obtener datos del documento.');
        print_r('generar hoja ruta');
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }
    if(sqlsrv_has_rows($rsdatos)){
        $Rrdatos = sqlsrv_fetch_array($rsdatos,SQLSRV_FETCH_ASSOC);
    }

    $imagenQR = $Rrdatos['codigoQr'];

    $html = '<div class="card">
                <div class="card-header text-center ">';
    $html .=        'Registro de entrada';
    $html .=    '</div>
                <div class="card-body">
                    <div id="registroBarr">
                        <table align="center" cellpadding="3" cellspacing="3" border="0">
                            <tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial">
                                    <b>D-TRÁMITE</b>
                                </td>
                            </tr>';
    if ($Rrdatos['nFlgClaseDoc'] == 1){
        $html .=            '<tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial">
                                    <b>TUPA: </b>';
        $html .=                    $Rrdatos['nomtupa'];
        $html .=               '</td>
                             </tr>';
    }

    // if ($estado === 1) {
    //     $html .=            '<tr>
    //                             <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">
    //                                 <img src="';
    //     $html .=                    $imagenQR;
    //     $html .=                    '">
    //                             </td>
    //                         </tr>';
    // }

    $html .=                '<tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">DOCUMENTO: ';
    $html .=                        $Rrdatos['cDescTipoDoc'].' '.$Rrdatos['cNroDocumento'];
    $html .=                    '</td>
                            </tr>';

    if ($estado === 1) {
        $html .=            '<tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">CUD: ';
        $html .=                    $Rrdatos['nCud'];
        $html .=                '</td>
                            </tr>
                            <tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">CLAVE: ';
        $html .=                    $Rrdatos['clave'];
        $html .=                '</td>
                            </tr>';
    }

    $html .=                '<tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA: 
                                    <b>';
    $html .=                            $Rrdatos['fFecRegistro']->format("d-m-Y H:i:s");
    $html .=                        '</b>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>d-tramite.apci.gob.pe</b>
                                </td>
                            </tr>
                            <tr>
                                 <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">GENERADO POR: ';
    $html .=                        $Rrdatos['trabajador'];
    $html .=                     '</td>
                            </tr>
                            <tr>
                                 <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">REMITENTE: ';
    $html .=                        $Rrdatos['nomRemitente'];
    $html .=                    '</td>
                            </tr>
                        </table>
                    </div>
                    <br>';
    if ($estado === 1) {
        $html .= '<div style="font-family:arial;font-size:12px;color:#000000">
                        <b>Documento completo</b>
                     </div>';
    } else {
        $html .=        '<div style="font-family:arial;font-size:12px;color:#ff0000">
                        <b>Documento incompleto</b>
                     </div>';
    }
    return $html;
}

if (isset($_GET['c'])){
    $id = trim(base64_decode($_GET['c']));
    $_POST['Accion'] = "EnviarObservaciónRecibida";
}

switch ($_POST['Accion']) {
    case 'ListarRecibidosMpv':
        $params = [
            $_POST['IdEstado'],
            $_POST['search']['value'],
            $_POST["start"],
            $_POST["length"],
            $_POST['FecInicio'],
            $_POST['FecFin'],
            $_POST['IdCol'] ?? NULL
        ];
        
        $sql = "{call UP_MPV_LISTAR_MESA_PARTES_VIRTUAL (?,?,?,?,?,?,?)}";
        
        $rs = sqlsrv_query($cnx,$sql,$params);
        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors(), true));
        }
        
        $data = array();
        
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $item = $Rs;
            $item['FecDocumento'] = $Rs['FecDocumento'] != null ? $Rs['FecDocumento']->format( 'd/m/Y') : '';
            $item['FecRegistro'] = $Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'd/m/Y H:i:s') : '';
            $item['FecRegistroTramite'] = $Rs['FecRegistroTramite'] != null ? $Rs['FecRegistroTramite']->format( 'd/m/Y H:i:s') : '';

            $data[] = $item;
        }
        
        $VO_TOTREG = 0;
        while($res = sqlsrv_next_result($rs)){
            if( $res ) {
                while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                    $VO_TOTREG = $row['VO_TOTREG'];
                }
            } elseif ( is_null($res)) {
                echo "No se obtener datos!";
                return;
            } else {
                die(print_r(sqlsrv_errors(), true));
            }
        }
        
        $recordsTotal = $VO_TOTREG;
        $recordsFiltered = $VO_TOTREG;
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $data
        );
        
        echo json_encode($json_data);
        break;
    
    case "Recuperar":
        $params = [
            $_POST['IdMesaPartesVirtual']
        ];
        
        $sql = "{call UP_MPV_RECUPERAR_MESA_PARTES_VIRTUAL (?)}";
        
        $rs = sqlsrv_query($cnx,$sql,$params);
        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors(), true));
        }
        
        $data = array();
        
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $Rs['FecDocumento'] = $Rs['FecDocumento']->format( 'd-m-Y');
            $Rs['FecRegistro'] = $Rs['FecRegistro']->format( 'd-m-Y H:i:s');
            $data[]=$Rs;
        }

        $data = $data[0];

        $params = [
            $_POST['IdMesaPartesVirtual']
        ];
        
        $sql = "{call UP_MPV_RECUPERAR_MESA_PARTES_VIRTUAL_ARCHIVO (?)}";
        
        $rs = sqlsrv_query($cnx,$sql,$params);
        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors(), true));
        }
        
        $dataArchivos = array();
        
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $dataArchivos[]=$Rs;
        }

        $data["Archivos"] = $dataArchivos;

        echo json_encode($data);

        break;

    case "RegistrarTramite":
        $nCodBarra = random_int(100000000, 999999999);
        $max_chars = round(random_int(5,10));
        $chars = array();
        for($i='a';$i<'z';$i++){
            $chars[]=$i;
            $chars[]='z';
        }
        for ($i=0; $i<$max_chars; $i++){
            $letra=round(random_int(0, 1));
            if ($letra){
                $contrasena = $chars[round(random_int(0,count($chars)-1))];
            }else{
                $contrasena = round(random_int(0, 9));
            }
        }

        $cPassword = $contrasena;
        $an = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $clave = substr($an,rand(0,34),2).substr($an,rand(0,34),2).substr($an,rand(0,34),2).substr($an,rand(0,34),2).substr($an,rand(0,34),2);

        $cud_ingresado = $_POST['cud'];
        if ($cud_ingresado != ""){
            $cud_ingresado = explode("-",$cud_ingresado);

            $flgCud = 1;
            $nroCud = $cud_ingresado[0];
            $anioCud = $cud_ingresado[1];
        } else {
            $flgCud = 0;
            $nroCud = NULL;
            $anioCud = NULL;
        }

        $parametros = array(
            $_POST['IdMesaPartesVirtual'],
            $_SESSION['CODIGO_TRABAJADOR'],
            $_SESSION['iCodOficinaLogin'],
            $_SESSION['iCodPerfilLogin'],
            $nCodBarra,
            $cPassword,
            $clave,
            $_POST['folio'],
            $flgCud,
            $nroCud,
            $anioCud,
            $_POST['comentario'],
            $_POST['idTupa'],
            $_POST['idTipoDoc'],
            $_POST['numeroDoc']
        );

        $sqlregistro = "{call UP_MPV_REGISTRAR_MESA_PARTES_VIRTUAL_EN_TRAMITE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rsregistro = sqlsrv_fetch_array( $rsregistro,SQLSRV_FETCH_ASSOC);

        $respuesta = new StdClass();
        if ($Rsregistro['iCodTramite'] == 0){
            $respuesta->success = false;
            $respuesta->mensaje = $Rsregistro['Mensaje'];
        } else {
            generarCud($Rsregistro['iCodTramite'],1,$cnx,$_SESSION['CODIGO_TRABAJADOR']);

            if (TRIM($_POST['codInscripcionSIGCTI']) != '' ){
                $paramsDatosTramite = array(
                    '',
                    'tramite',
                    $Rsregistro['iCodTramite'],
                    ''
                );

                $sqldatosTramite = "{call SP_CONSULTA_DATOS_DOCUMENTO (?,?,?,?) }";
                $rsdatosTramite = sqlsrv_query($cnx, $sqldatosTramite, $paramsDatosTramite);
                if($rsdatosTramite === false) {
                    print_r('Error al obtener datos del documento.');
                    print_r('generar hoja ruta');
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
                $RrdatosTramite = sqlsrv_fetch_array($rsdatosTramite,SQLSRV_FETCH_ASSOC);
                $url = RUTA_SIGTI_SERVICIOS."/ApiD-Tramite/Api/Tramite/TRA_GET_0004?CodInscripcion=".$_POST['codInscripcionSIGCTI']."&CodTramite=".$Rsregistro['iCodTramite']."&nCud=".$RrdatosTramite['nCud'];
                $client = curl_init();
                curl_setopt($client, CURLOPT_URL, $url);
                curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
                $response = json_decode(curl_exec($client));
            }

            generarQrMP($Rsregistro['iCodTramite'],1,$cnx,$url_srv,$fileUpload,$_SESSION['CODIGO_TRABAJADOR']);
            $hojaRegistro = generarHojaIngreso ($Rsregistro['iCodTramite'],1,$cnx,$url_srv);

            $registro = DocDigital::obtenerDocsDigitalTramite($cnx, $Rsregistro['iCodTramite'], 5);
            $docDigitalMesa = new DocDigital($cnx);
            $docDigitalMesa->obtenerDocDigitalPorId($registro[0]);
            $docDigitalMesa->tmp_name = RUTA_DTRAMITE.$docDigitalMesa->obtenerRutaDocDigital();
            $docDigitalMesa->cargarDocumento();

            $asunto = 'Confirmación de registro - Mesa de partes digital APCI';

            $contenidoCuerpo = $hojaRegistro;
            $nombres = $_POST['NombreResponsable'];
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
                                <table align="center" class="container header__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row header" style="background:#001f4a;border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><img src="https://cdn.apci.gob.pe/dist/images/dt__logo.png" alt srcset width="160px" height="48px" class="m-auto" style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><h3 class="title" style="Margin:0;Margin-bottom:10px;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">'.$asunto.'</h3><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify">Estimado(a) '.$nombres.', su expediente ha sido registrado en el sistema de tramite documentario de la <b>Agencia Peruana de Cooperación Internacional -APCI</b>, por lo cual se remite el cargo de recepción para su posterior seguimiento.</p><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"></p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"></p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                                <table><tbody><tr><th>'.$contenidoCuerpo.'</th></tr><tr><th><p><small><strong>Nota: El Código Único Digital (CUD) asignado acredita la conformidad de la Mesa de Partes de la APCI a la documentación presentada.</strong></small></p></th></tr></tbody></table>
                            <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                                    <p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"><small><em></p></th></tr></table></th></tr></tbody></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></td></tr></tbody></table><table align="center" class="container footer__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
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
            array_push($correos,$_POST['Correo']);

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

            $respuesta->success = true;
            $respuesta->data = $hojaRegistro;
        }
        echo json_encode($respuesta);
        break;

    case 'EnviarObservación':
        $parametros = array(
            $_POST['IdMesaPartesVirtual'],
            $_SESSION['CODIGO_TRABAJADOR'],
            $_POST['Observacion']
        );

        $sqlregistro = "{call UP_MPV_REGISTRAR_OBSERVACION_MESA_PARTES_VIRTUAL (?,?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $nombres = $_POST['NombreResponsable'];
        $asunto = 'Notificación de expediente observado - Mesa de partes digital';
        $contenidoCuerpo = $_POST['Observacion'];
        $ruta = RUTA_DTRAMITE.'views/ajax/ajaxRegMpv.php?c='.base64_encode($_POST['IdMesaPartesVirtual']);
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
                            <table align="center" class="container header__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:0;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row header" style="background:#001f4a;border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:0;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><img src="https://cdn.apci.gob.pe/dist/images/dt__logo.png" alt srcset width="160px" height="48px" class="m-auto" style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:auto"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th></tr></tbody></table></td></tr></tbody></table><table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><h3 class="title" style="Margin:0;Margin-bottom:10px;color:#001f4a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">'.$asunto.'</h3><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify">Estimado(a) '.$nombres.', su expediente ha sido observado, por lo cual se remite las observación encontradas para su subsanación en el plazo máximo de 48 horas, posterior al plazo tendra que registrar nuevamente su expediente.</p><p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"></p><p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"></p><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                            <table><tbody><tr><th>Observaciones:<br/>'.$contenidoCuerpo.'</th></tr></tbody></table>
                        <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table>
                                <p class="text-justify" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:justify"><small><em>* Para ir al formulario de subsanación, por favor dar el acuso de recibido haciendo click <a href="'.$ruta.'"><u>Aquí</u></a>.</p></th></tr></table></th></tr></tbody></table><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td></tr></tbody></table></td></tr></tbody></table><table align="center" class="container footer__container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
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
        array_push($correos,$_POST['Correo']);

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

    case 'EnviarObservaciónRecibida':
        $parametros = array(
            $id,
            0
        );

        $sqlregistro = "{call UP_MPV_REGISTRAR_OBSERVACION_RECIBIDA_MESA_PARTES_VIRTUAL (?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $ruta = RUTA_DTRAMITE.'mesa-de-partes-virtual/registro.php?c='.base64_encode($id);

        header('Location: '.$ruta);        
        break;
    case 'AnularRegistro':
        $parametros = array(
            $_POST['IdMesaPartesVirtual'],
            $_SESSION['CODIGO_TRABAJADOR'],
            $_POST['Motivo']
        );

        $sqlregistro = "{call UP_MPV_ANULAR_MESA_PARTES_VIRTUAL (?,?,?) }";
        $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $respuesta = new StdClass();
        $respuesta->success = true;

        echo json_encode($respuesta);
        break;
    case 'ListarHistorico':
        $params = [
            $_POST['IdMesaPartesVirtual']
        ];
        
        $sql = "{call UP_MPV_LISTAR_MESA_PARTES_VIRTUAL_HISTORICO (?)}";
        
        $rs = sqlsrv_query($cnx,$sql,$params);
        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors(), true));
        }
        
        $data = array();
        
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $item = $Rs;
            $item['FecRegistro'] = $Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'd/m/Y H:i:s') : '';

            $data[] = $item;
        }
        
        echo json_encode($data);
        break;

    case 'DescargarListadoRecibidosMpv':
        $params = [
            $_POST['IdEstado'],
            $_POST['search'],
            $_POST["start"],
            $_POST["length"],
            $_POST['FecInicio'],
            $_POST['FecFin'],
            $_POST['IdCol'] ?? NULL
        ];
        
        $sql = "{call UP_MPV_LISTAR_MESA_PARTES_VIRTUAL (?,?,?,?,?,?,?)}";
        
        $rs = sqlsrv_query($cnx,$sql,$params);
        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors(), true));
        }

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-type: application/x-msexcel; charset=utf-8");
        header("Pragma: no-cache");
        header('Content-Encoding: UTF-8');
        header ("Content-Disposition: attachment; filename=Bandeja-Mesa-Partes-Digital-".date("d-m-Y").".xls" );
        header ("Content-Description: Reporte Bandeja Mesa Partes Digital" );
        
        $anho = date("Y");
        $datomes = date("m");
        $datomes = $datomes*1;
        $datodia = date("d");
        $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");    

        echo "<table width=780 border=0><tr><td align=center colspan=21>";
        echo "<img src='http://d-tramite.apci.gob.pe/dist/images/logo--sm.png'>";
        echo "</table>";
        
        echo "<table width=780 border=0><tr><td align=center colspan=21>";
        echo "<h3>Reporte Bandeja Mesa Partes Digital</h3>";
        echo "</table>";
        
        echo "<table width=780 border=0><tr><td align=right colspan=21>";
        echo "D-Tr&aacute;mite, ".$datodia." ".$meses[$datomes].' del '.$anho;
        echo "</table>";

        echo "<table width='780' border='1px'>";
        echo "<tr>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg;</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tipo de Entidad</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tipo de Doc. Entidad</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg de Doc. Entidad</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Nombre Entidad</td>";

        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Telefono de contacto</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Correo de contacto</td>";
        
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tipo de Doc.</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg de Doc.</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Fecha de Doc.</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Asunto</td>";

        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Es TUPA</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tramite</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Es SIGCTI</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg Constancia</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Es Reingreso</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg CUD Reingreso</td>";
        
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg CUD</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Fec. Registro D-tramite</td>";

        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Estado</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Fec. Registro Mesa de Partes Digital</td>";       
        
        echo "</tr>";
        
        $count = 1;
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $item = $Rs;
            $item['FecDocumento'] = $Rs['FecDocumento'] != null ? $Rs['FecDocumento']->format( 'd/m/Y') : '';
            $item['FecRegistro'] = $Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'd/m/Y H:i:s') : '';
            $item['FecRegistroTramite'] = $Rs['FecRegistroTramite'] != null ? $Rs['FecRegistroTramite']->format( 'd/m/Y H:i:s') : '';

            echo "<tr>";
            
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($count,"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['DesTipoEntidad'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['DesTipoDocEntidad'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['NumeroDocEntidad'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=left style='vertical-align: middle'>".mb_convert_encoding($item['NombreEntidad'],"HTML-ENTITIES","UTF-8")."</td>";

            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['TelefonoContacto'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['CorreoContacto'],"HTML-ENTITIES","UTF-8")."</td>";

            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['DesTipoDoc'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['NumeroDoc'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['FecDocumento'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=left style='vertical-align: middle'>".mb_convert_encoding($item['Asunto'],"HTML-ENTITIES","UTF-8")."</td>";
            
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding(($item['FlgEsTupa'] == '1' ? 'Si' : 'No'),"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=left style='vertical-align: middle'>".mb_convert_encoding($item['DesTupa'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding(($item['FlgSigcti'] == '1' ? 'Si' : 'No'),"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['NroSigcti'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding(($item['FlgTieneCud'] == '1' ? 'Si' : 'No'),"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding(($item['FlgTieneCud'] == '1' ? ($item['NroCud'].'-'.$item['AnioCud']) : ''),"HTML-ENTITIES","UTF-8")."</td>";
            
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['Cud'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['FecRegistroTramite'],"HTML-ENTITIES","UTF-8")."</td>";

            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['DesEstado'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['FecRegistro'],"HTML-ENTITIES","UTF-8")."</td>";

            echo "</tr>";

            $count ++;
        }
        break;
}