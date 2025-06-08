<?php
session_start();
require_once('../../conexion/conexion.php');
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

require_once("../../core/CURLConection.php");
require_once "phpqrcode/qrlib.php";

date_default_timezone_set('America/Lima');

function generarQrMP ($codTramite,$estado,$cnx) {
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

        $docDigital = new DocDigital($cnx);
        $docDigital->idTipo = 7;
        $docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
        $docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
        $docDigital->grupo = $Rrdatos['cAgrupado'];
        $docDigital->idTramite = $codTramite;

        $docDigital->tmp_name = $filename;
        $docDigital->name = $codigoQr;
        $docDigital->type = 'PNG';

        if(!$docDigital->subirDocumento()){
            print_r('Error, no se pudo guardar el QR en el servidor.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        
        $urlQR = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();

        $paramtroQR = array(
            $urlQR,
            $codTramite,
            $_SESSION['CODIGO_TRABAJADOR']
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

function generarCud ($codTramite, $estado,$cnx) {
    if ($estado === 1) {
        $parametro = array(
            $codTramite,
            $_SESSION['CODIGO_TRABAJADOR']
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

function generarHojaIngreso ($codTramite, $estado, $cnx) {
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

    if ($estado === 1) {
        $html .=            '<tr>
                                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">
                                    <img src="';
        $html .=                    $imagenQR;
        $html .=                    '">
                                </td>
                            </tr>';
    }

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

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    switch ($_POST['Evento']) {
        case 'registroMesaPartes':

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

            if (isset($_POST['nFlgClaseDoc'])) {
                $claseTupa = $_POST['iCodTupaClase'];
                $tupa = $_POST['iCodTupa'];
                $tupaRequisitos = json_encode($_POST['iCodTupaRequisito']??array());
            } else {
                $claseTupa = NULL;
                $tupa = NULL;
                $tupaRequisitos = '';
            }

            $fechaDoc = date('Y-m-d',strtotime($_POST['fechaDocumento']));

            $parametros = array(
                $_POST['codInscripcionSIGCTI'] == 0 ? 0 : $_POST['codInscripcionSIGCTI'],
                TRIM($_POST['nroConstanciaSIGCTIEnvio']) == '' ? '' : $_POST['nroConstanciaSIGCTIEnvio'],
                $_POST['cNroDocumento'],
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin'],
                $_SESSION['iCodPerfilLogin'],
                $_POST['cCodTipoDoc'],
                $fechaDoc,
                $_POST['iCodRemitente'],
                $_POST['cNombreRemitente'],
                $_POST['direccionRemi']??'',
                $_POST['cNomRemitente'],
                $_POST['cCargoRemitente'],
                $_POST['cAsunto'],
                $_POST['cObservaciones'],
                $_POST['nNumFolio'],
                $_POST['nFlgClaseDoc'] ?? 2,
                $claseTupa,
                $tupa,
                $nCodBarra,
                $cPassword,
                $clave,
                isset($_POST['cReferencia']) ? json_encode($_POST['cReferencia']) : '',
                isset($_POST['documentoEntrada']) ? json_encode($_POST['documentoEntrada']) : '',
                $tupaRequisitos,
                $_POST['nCud']?? ''
            );

            $sqlregistro = "{call SP_INGRESO_MESA_PARTES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
            $rsregistro = sqlsrv_query($cnx, $sqlregistro, $parametros);
            if($rsregistro === false) {
                print_r('Error al registrar el documento.');
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            while($next_rs = sqlsrv_next_result($rsregistro)){
                if( $next_rs ) {
                    $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);
                } elseif( is_null($next_rs)) {
                    echo "No se pudo obtener datos";
                    return;
                } else {
                    print_r('Error al obtener datos despues de registrar.');
                    http_response_code(500);
                    die(print_r(sqlsrv_errors(), true));
                }
            }

            generarCud($Rsregistro['iCodTramite'],$Rsregistro['estado'],$cnx);

            if ($_POST['codInscripcionSIGCTI'] != 0 && TRIM($_POST['nroConstanciaSIGCTIEnvio']) != '' ){
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

            generarQrMP ($Rsregistro['iCodTramite'],$Rsregistro['estado'],$cnx);
            $hojaRegistro = generarHojaIngreso ($Rsregistro['iCodTramite'],$Rsregistro['estado'],$cnx);

            if($Rsregistro['estado'] == 1 && isset($_POST['documentoEntrada'])){
                $registro = DocDigital::obtenerDocsDigitalTramite($cnx, $Rsregistro['iCodTramite'], 5);
                $docDigitalMesa = new DocDigital($cnx);
                $docDigitalMesa->obtenerDocDigitalPorId($registro[0]);
                $docDigitalMesa->tmp_name = RUTA_DTRAMITE.$docDigitalMesa->obtenerRutaDocDigital();
                $docDigitalMesa->cargarDocumento();
            }

            echo $hojaRegistro;
            break;

        case "registroRequisitosFaltantes":
            if (($_POST["nroRequisitosFaltantes"] - count($_POST["iCodTupaRequisitoFaltante"])) === 0) {
                $completo = 1;
            } else {
                $completo = 0;
            }

            $parametros = array(
                $_POST['iCodTramite'],
                isset($_POST['iCodTupaRequisitoFaltante']) ? json_encode($_POST['iCodTupaRequisitoFaltante']) : ''
            );

            $sqlreqFaltantes = "{call SP_REQUISITOS_FALTANTES_INSERT (?,?) }";
            $rsreqFaltantes = sqlsrv_query($cnx, $sqlreqFaltantes, $parametros);
            if($rsreqFaltantes === false) {
                print_r('Error al registrar los requisitos faltantes.');
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            generarCud($_POST['iCodTramite'],$completo,$cnx);
            generarQrMP ($_POST['iCodTramite'],$completo,$cnx);

            break;

        case "registroDocumentoPdf":
            $params = array(
                $_POST['iCodTramite'],
                json_encode($_POST['documentoEntrada'])
            );
            $sql = "{call UP_REGISTRO_DOC_MESA_PARTES (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            if(isset($_POST['documentoEntrada'])){
                $registro = DocDigital::obtenerDocsDigitalTramite($cnx, $_POST['iCodTramite'], 5);
                $docDigitalMesa = new DocDigital($cnx);
                $docDigitalMesa->obtenerDocDigitalPorId($registro[0]);
                $docDigitalMesa->tmp_name = RUTA_DTRAMITE.$docDigitalMesa->obtenerRutaDocDigital();
                $docDigitalMesa->cargarDocumento();
            }
            break;

        case "derivarMesaPartes":
            $params = array(
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin'],
                $_POST['iCodTramite'],
                $_POST['codEsTupa'],
                $_POST['iCodTupa']??0,
                $_POST['iCodOficina']??0,
                $_POST['iCodIndicacion']??0,
                $_POST['prioridad']??''
            );
            $sql = "{call SP_DERIVAR_MESA_PARTES (?,?,?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "anularMesaPartes":
            $codigos = $_POST['values'];
            $params = array(
                $_SESSION['CODIGO_TRABAJADOR'],
                $_SESSION['iCodOficinaLogin'],
                json_encode($_POST['values'])
            );
            $sql = "{call SP_ANULAR_MESA_PARTES (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case "consultarHojaRuta":
            $hojaRegistro = generarHojaIngreso ($_POST['codTramite'],1,$cnx);

            echo $hojaRegistro;
            break;
    }

}else{
    header("Location: ../../index-b.php?alter=5");
}

?>