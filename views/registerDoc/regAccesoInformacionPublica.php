<?php
session_start();
include_once('../../conexion/conexion.php');
include_once("../../conexion/parametros.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../clases/DocDigital.php");

include_once("../../core/CURLConection.php");
include "phpqrcode/qrlib.php";


date_default_timezone_set('America/Lima');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

require '../../vendor/autoload.php';
$url_srv = $hostUpload . ':' . $port . $path;

$nNumAno    = date('Y');
$nNumMes    = date('m');
$nNumDia    = date('d');

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

        $nomenclatura = date('Y').'/'.date('m').'/'.date('d').'/'.ID_MESA_PARTES_OFICINA.'/'.ID_MESA_PARTES_VIRTUAL_USUARIO.'/'.$Rrdatos['cAgrupado'];
        $url_f = 'docEntrada/' . $nomenclatura . '/';

        $_FILES['fileUpLoadDigital']['tmp_name'] = $filename;
        $_FILES['fileUpLoadDigital']['name'] = $codigoQr;
        $_FILES['fileUpLoadDigital']['type'] = 'PNG';

        $_POST['path'] = $url_f;
        $_POST['name'] = 'fileUpLoadDigital';
        $_POST['new_name'] = $codigoQr;

        $curl = new CURLConnection($url_srv.$fileUpload);
        $curl->uploadFile($_FILES,$_POST);
        $urlQR = $url_srv.$url_f.$codigoQr;
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

function generarHojaIngreso ($codTramite, $estado, $cnx,$url_srv, $mostrarQr = true) {
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

    if ($mostrarQr){
        if ($estado === 1) {
            $html .=            '<tr>
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">
                                        <img src="';
            $html .=                    $imagenQR;
            $html .=                    '">
                                    </td>
                                </tr>';
        }
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
                            </tr>';
    $html .=                '<tr>
                                <td>
                                    <a href="http://'.$_SERVER['HTTP_HOST'].'/views/consulta-web.php?cCodificacion='.$Rrdatos['nCud'].'&contrasena='.$Rrdatos['clave'].'">Enlace de Seguimiento</a>
                                </td>
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

function registrarSolicitud ($datos,$idTramite,$cnx,$url_srv,$fileUpload) {
    ob_start();
    ?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
            <title>SITDD</title>
            <?php include("../template/styles.php"); ?>
            <style>
                h4, h5 {
                    text-align: center;
                }
                p {
                    font-size: 12px;
                }
                label {
                    font-weight: bold;
                    font-size: 12px;
                }
                .subtitulo {
                    font-weight: bold;
                    font-size: 14px;
                }
                

            </style>
        </head>
        <body>
        <header>
            <table style="margin-left: 20px">
                <tr id="logoMin">
                    <td id="peruLogo" class="center" style="heigth: 50px; width: 60px; border:solid white 1.0pt; background:white;">
                        <img width="34" src="../../dist/images/peru.png">
                    </td>
                    <td id="peruText" class="center minText" width="150" style="heigth: 50px; width: 60px; border:solid white 1.0pt;background:#C00000;">
                        <p>PERÚ</p>
                    </td>
                    <td class="minText" width="151" style="heigth: 50px; width: 200px;border:solid white 1.0pt;border-left:none; background:#333333;">
                        <p>Ministerio <br> de Relaciones Exteriores</p>
                    </td>
                    <td class="minText" width="180" style="heigth: 50px; width: 200px;border:solid white 1.0pt;border-left:  none;  background:#999999;">
                        <p>Agencia Peruana <br> de Cooperación Internacional</p>
                    </td>
                </tr>
                <tr id="logoCaption">
                    <td colspan="5">
                        <p>
                            <?php echo '"Decenio de la Igualdad de Oportunidades para mujeres y hombres"';?>
                            <br>
                            <?php echo '"Año del Bicentenario, de la consolidación de nuestra Independencia y de la Conmemoración de las heroicas batallas de Junín y Ayacucho"';?>
                            <br>
                            <!-- <php echo '"Año del Bicentenario del Congreso de la República del Perú"'?> -->
                        </p>
                    </td>
                </tr>
            </table>
            </header>
            <main>
                <h3 style="text-align: center">SOLICITUD DE ACCESO A LA INFORMACIÓN PÚBLICA</h3>
                <h4>(Texto Único Ordenado de la Ley N° 27806, Ley de Transparencia y Acceso a la Información Pública, aprobado por Decreto Supremo N° 043-2003-PCM)</h4>
                
                <section>
                    <p class="subtitulo">I. FUNCIONARIO RESPONSABLE DE ENTREGAR LA INFORMACIÓN (Alterno):<p>
                    <p>Lic. Gloria Bejarano Noblecilla</p>
                </section>
                <section>
                    <p class="subtitulo">II. DATOS DEL SOLICITANTE:<p>
                    <p>
                        <label>
                            <?php if($datos['ID_TIPO_PERSONA'] == 60){ ?>
                                APELLIDOS Y NOMBRES
                            <?php } else{?>
                                RAZÓN SOCIAL
                            <?php }?>
                        </label>
                        <p>
                            <?php if($datos['ID_TIPO_PERSONA'] == 60){ 
                                echo $datos['NOM_PERSONA']." ".$datos['APE_PATERNO_PERSONA']." ".$datos['APE_MATERNO_PERSONA'];
                            } else{
                                echo $datos['NOM_PERSONA'];
                            }?>
                        </p>
                    </p>
                    <?php if ($datos['DES_TIPO_DOCUMENTO'] != null && $datos['DES_TIPO_DOCUMENTO'] != ''){?>
                    <p>
                        <label>DOCUMENTO DE IDENTIDAD</label>
                        <p><?=$datos['DES_TIPO_DOCUMENTO']?></p>
                    </p>
                    <?php }?>
                    <?php if ($datos['NRO_DOCUMENTO'] != null && $datos['NRO_DOCUMENTO'] != ''){?>
                    <p>
                        <label>NRO DOCUMENTO</label>
                        <p><?=$datos['NRO_DOCUMENTO']?></p>
                    </p>
                    <?php }?>
                    <p>
                        <label>DOMICILIO</label>
                        <p><?=$datos['DIRECCION']?></p>
                    </p>
                        <!-- <label>UBIGEO</label>
                        <p><?=$datos['DES_DEPARTAMENTO']?> / <?=$datos['DES_PROVINCIA']?> / <?=$datos['DES_DISTRITO']?></p>
                    </p> -->
                    <?php if($datos['TELEFONO_CONTACTO'] != null && $datos['TELEFONO_CONTACTO'] != '') { ?>
                    <p>
                        <label>TELÉFONO</label>
                        <p><?=$datos['TELEFONO_CONTACTO']?></p>
                    </p>
                    <?php } ?>
                    <?php if($datos['CORREO_CONTACTO'] != null && $datos['CORREO_CONTACTO'] != '') { ?>
                    <p>
                        <label>CORREO ELECTRÓNICO</label>
                        <p><?=$datos['CORREO_CONTACTO']?></p>
                    </p>
                    <?php } ?>
                </section>
                <section>
                    <p class="subtitulo">III. INFORMACIÓN SOLICITADA:<p>
                    <p><?=$datos['INFORMACION_SOLICITADA']?></p>
                </section>
                <section>
                    <p class="subtitulo">V. FORMA DE ENTREGA DE LA INFORMACIÓN<p>
                    <p>
                        <?php 
                            if($datos['ID_FORMATO_ENTREGA'] == 91){
                                echo $datos['DESC_FORMATO_ENTREGA'];
                            } else {
                                echo $datos['DES_FORMATO_ENTREGA'];
                            }
                        ?>
                    </p>
                </section>
            </main>
            <footer>
                <img class="footerImg" src="../../dist/images/pie.png">
            </footer>
        </body>
    </html>
    <?php
    $content = ob_get_clean();

    $nombre = 'SOLICITUD-'.$datos['NRO_SOLICITUD'].'.pdf';

    $dompdf = new DOMPDF();
    $dompdf->loadHtml($content);
    $dompdf->render();

    $output = $dompdf->output();

    $separa=DIRECTORY_SEPARATOR;
    $tmp = dirname(tempnam (null,''));
    $tmp = $tmp.$separa."upload";

    if ( !is_dir($tmp)) {
        mkdir($tmp);
    }
    $urlTemp = $tmp.$separa.$nombre;
    file_put_contents($urlTemp, $output);
    $agrupado = ID_MESA_PARTES_OFICINA.ID_MESA_PARTES_VIRTUAL_USUARIO.date('Y').date('m').date('d');
    $nomenclatura = date('Y').'/'.date('m').'/'.date('d').'/'.ID_MESA_PARTES_OFICINA.'/'.ID_MESA_PARTES_VIRTUAL_USUARIO.'/'.$agrupado;
    $url_f = 'docEntrada/' . $nomenclatura . '/';
    
    $nombreNuevo = DocDigital::formatearNombre($nombre,true,['/'],'');

    $_FILES['fileUpLoadDigital']['tmp_name'] = $urlTemp;
    $_FILES['fileUpLoadDigital']['name'] = $nombre;
    $_FILES['fileUpLoadDigital']['type'] = 'pdf';

    $_POST['path'] = $url_f;
    $_POST['name'] = 'fileUpLoadDigital';
    $_POST['new_name'] = $nombreNuevo;
    
    $curl = new CURLConnection($url_srv.$fileUpload);
    $curl->uploadFile($_FILES,$_POST);    
    $curl->closeCurl();
    $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite,cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES (".$idTramite.",'".$nombre."','".$url_f.$nombreNuevo."',5)";
    $rsDigt = sqlsrv_query($cnx, $sqlDigt);

    if($rsDigt === false) {
        print_r('Error guardar el documento');
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }

    return $url_srv.$url_f.$nombre;
};

switch ($_REQUEST['Evento']) {
    case 'registroAccesoInformacionPublica':
        
        $pin = '';
        $matriz = '0123456789';
        for ($i=0; $i<4; $i++){
            $pin .= substr($matriz,rand(0,9),1);
        }

        $parametros = array(
            $_POST['tipoPersona'],
            $_POST['nombreEntidad'],
            $_POST['apePaterno'] ?? null,
            $_POST['apeMaterno'] ?? null,
            $_POST['tipoDoc'],            
            $_POST['numeroDocumento'],
            $_POST['direccion'],
            $_POST['departamento'] ?? null,
            $_POST['provincia'] ?? null,
            $_POST['distrito'] ?? null,
            $_POST['telefonoContacto'],
            $_POST['correoContacto'],
            $_POST['informacion'],
            $_POST['dependencia'] ?? null,
            $_POST['formaEntrega'],
            $_POST['descOtraForma'] ?? null,
            $pin,
        );

        $sqlregistro = "{call SOLICITUD.UP_ACCESO_INFORMACION_PUBLICA_REGISTRAR (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        
        $rsregistro = sqlsrv_query($cnxAIP, $sqlregistro, $parametros);
        if($rsregistro === false) {
            print_r('Error al registrar el documento.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rsregistro = sqlsrv_fetch_array( $rsregistro, SQLSRV_FETCH_ASSOC);

        try {
            $retorno = array(
                'codigo' => $Rsregistro['ID_SOLICITUD']
            );
            echo base64_encode(json_encode($retorno));
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

        $sqlregistro = "{call SOLICITUD.UP_ACCESO_INFORMACION_PUBLICA_VALIDAR_CODIGO (?,?) }";
        $rsregistro = sqlsrv_query($cnxAIP, $sqlregistro, $parametros);
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

    case 'registroMesaPartes':
        $datos = json_decode(base64_decode($_POST['hash']));
        $paramrecuperar = array(
            $datos->codigo
        );
        
        $sqlrecuperar = "{call SOLICITUD.UP_SOLICITUD_RECUPERAR (?) }";
        $rsrecuperar = sqlsrv_query($cnxAIP, $sqlrecuperar, $paramrecuperar);
        if($rsrecuperar === false) {
            print_r('Error al recuperar los datos.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $RsDatosSolicitud = sqlsrv_fetch_array($rsrecuperar, SQLSRV_FETCH_ASSOC);
        
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
        
        $fechaDoc = $RsDatosSolicitud['FEC_REGISTRO']->format('Y-m-d');
        
        $parametros = array(
            NULL,
            NULL,
            $RsDatosSolicitud['NRO_SOLICITUD'],
            ID_MESA_PARTES_VIRTUAL_USUARIO,
            ID_MESA_PARTES_OFICINA,
            ID_MESA_PARTES_PERFIL,
            ID_SOLICITUD,
            $fechaDoc,
            $RsDatosSolicitud['ID_ENTIDAD'],
            NULL,
            NULL,
            NULL,
            NULL,
            'Solicitud de Acceso a la Información Pública',
            NULL,
            0,
            2,
            $claseTupa,
            $tupa,
            $nCodBarra,
            $cPassword,
            $clave,
            '',
            NULL,
            $tupaRequisitos,
            ''
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

        $pAgregarTramite = array(
            $datos->codigo,
            $Rsregistro['iCodTramite']
        );

        $sqlAgregarTramite = "{call SOLICITUD.UP_SOLICITUD_AGREGAR_TRAMITE (?,?) }";
        $rsAgregarTramite = sqlsrv_query($cnxAIP, $sqlAgregarTramite, $pAgregarTramite);
        if($rsAgregarTramite === false) {
            print_r('Error al recuperar los datos.');
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        generarCud($Rsregistro['iCodTramite'],$Rsregistro['estado'],$cnx,ID_MESA_PARTES_VIRTUAL_USUARIO);
        generarQrMP($Rsregistro['iCodTramite'],$Rsregistro['estado'],$cnx,$url_srv,$fileUpload,ID_MESA_PARTES_VIRTUAL_USUARIO);
        
        $rutaSolicitud = registrarSolicitud($RsDatosSolicitud,$Rsregistro['iCodTramite'],$cnx,$url_srv,$fileUpload);
        $hoja = generarHojaIngreso ($Rsregistro['iCodTramite'],$Rsregistro['estado'],$cnx,$url_srv,false);

        $cuerpoHtml = $hoja.'<a href="'.$rutaSolicitud.'">Ver Solicitud</a>';

        if ($RsDatosSolicitud['CORREO_CONTACTO'] != null && $RsDatosSolicitud['CORREO_CONTACTO'] != ''){
            $correos = [];
            array_push($correos,$RsDatosSolicitud['CORREO_CONTACTO']);

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
                $mail->Subject = 'Constancia de registro de solicitud de Acceso a la información pública';
                $mail->Body = $cuerpoHtml;
                $mail->CharSet = 'UTF-8';
                $mail->AltBody = 'No responder';

                $mail->send();
            } catch (Exception $e) {
                print_r('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
        }

        $hojaRuta = generarHojaIngreso ($Rsregistro['iCodTramite'],$Rsregistro['estado'],$cnx,$url_srv);
        echo $hojaRuta;
        break;
}
?>