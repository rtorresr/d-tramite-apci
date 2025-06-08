<?php
require_once('clases/DocDigital.php');
require_once('clases/Log.php');
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
$nNumAno = date('Y');
$nNumMes = date('m');
$nNumDia = date('d');

set_time_limit(0);     
ini_set('memory_limit', '3540M');
ob_start();
date_default_timezone_set('America/Lima');
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');


if (!function_exists('sliceString')){
    function sliceString($formatted_tag,$n=2){
        $formatted_tag =explode(' ', $formatted_tag);
        $oooo = "";
        for ($i = 0,$iMax = count($formatted_tag);  $i<= $iMax; $i++){
            if ($i>0 && ($i%$n == 0)){
                $oooo .= " <br> ".($formatted_tag[$i]??'');
            }else{
                $oooo .= " ".($formatted_tag[$i]??'');
            }
        }
        return $oooo;
    }
}

$fecha = $dataNotificacion['fecha'] != null ? $dataNotificacion['fecha']->format('d/m/Y') : '';
$hora = date('G:i:s');

$sqlOfi = "select cNomOficina, cSiglaOficina  from Tra_M_Oficinas where iCodOficina = ".$dataFirma['iCodOficinaFirmante'];
$rsOfi=sqlsrv_query($cnx,$sqlOfi);
$RsOfi=sqlsrv_fetch_array($rsOfi);

$words = array('Y', 'De','E');
$regex = '/\b(' . implode( '|', $words) . ')\b/i';
$formatted_tag = preg_replace_callback( $regex, function( $matches) {
    return strtolower( $matches[1]);
}, ucwords(mb_strtolower(trim($RsOfi['cNomOficina']))));
$oooo = sliceString($formatted_tag,3);

$numDoc = $dataNotificacion['cDescTipoDoc'].' N° '.$dataNotificacion['cCodificacion'];

$sqlRemitente = "SELECT CONCAT(TRIM(trab.cNombresTrabajador),' ',TRIM(trab.cApellidosTrabajador)) AS nombreCompleto, car.descripcion AS cargo 
                     FROM Tra_M_Perfil_Ususario AS pu
                    INNER JOIN Tra_M_Trabajadores AS trab ON trab.iCodTrabajador = pu.iCodTrabajador
                    INNER JOIN Tra_M_Cargo AS car ON car.iCodCargo = pu.iCodCargo
                    WHERE pu.iCodOficina = ".$dataFirma['iCodOficinaFirmante']." 
                    AND pu.iCodTrabajador = ".$dataFirma['iCodTrabajadorFirmante']." AND pu.iCodPerfil = ".$dataFirma['iCodPerfilFirmante'];

$rsRemitente=sqlsrv_query($cnx,$sqlRemitente);
$RsRemitente=sqlsrv_fetch_array($rsRemitente);

$asunto = $dataFirma['cAsunto'];

// $destinatarios = json_decode($dataFirma['destinatarios']);
// $destinatarios = $destinatarios[0];

$destinatariosE = $destinoExterno;

$entidad = $destinatariosE['nomRemitente'];
$direccion = $destinatariosE['cDireccion'];

$ubigeo = explode('|',$direccion);
$direccion = $ubigeo[0];
unset($ubigeo[0]);
unset($ubigeo[1]);

$ubigeo = implode('<br>', $ubigeo);

$documento = $dataFirma['descDoc'].' N° '.$dataFirma['cCodificacion'];

$nroDocEntidad = $destinatariosE['nroDocumento'];
// $despacho = json_decode($dataFirma['despacho']);
$folios = isset($destinatariosE['FoliosDespacho']) ? $destinatariosE['FoliosDespacho'] : 0;
$observacion = isset($destinatariosE['ObservacionesDespacho']) ? $destinatariosE['ObservacionesDespacho'] : '';
$oficinaRegistro = $dataNotificacion['OficinaFirmante'];

$adjuntos = '';
if($dataFirma['cAnexosImprimibles'] !== null){
    $cAnexos = json_decode($dataFirma['cAnexosImprimibles'],true);
    $addAnex = '';
    foreach ($cAnexos AS $key => $value){
        $rsAnexos = sqlsrv_query($cnx, "SELECT cNombreOriginal, cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE iCodDigital = ".$value['iCodDigital']);
        $RsAnexos = sqlsrv_fetch_array($rsAnexos);
        if(trim($RsAnexos['cNombreOriginal']) == ''){
            $nuevoNom = explode('/',trim($RsAnexos['cNombreNuevo']));
            $nuevoNom = $nuevoNom[count($nuevoNom)-1];
            $addAnex.= '<dt>'.$nuevoNom.'</dt>';
        } else {
            $addAnex.= '<dt>'.trim($RsAnexos['cNombreOriginal']).'</dt>';
        }
    }
    $adjuntos = $addAnex;
}

$firma = '';
if (isset($flgSegundoPdf)){
    if($_SESSION['flgDelegacion'] == 1 && $_SESSION['iCodOficinaLogin'] == 356){
        $firma = '
            <table style="width: 100%">
                <tr>
                    <td style="width: 55px">
                        <img class="" src="../../dist/images/apci__loco__square.png" width="55" height="55" />
                    </td>
                    <td style="padding-left: 0.35rem;">
                        <p style="line-height: 1">
                            <strong style="font-size: 70%; color: #333366">'.$RsRemitente['nombreCompleto'].'</strong>
                            <span style="font-size: 70%;">'.$RsRemitente['cargo'].'</span><br>

                            <span style="font-size: 70%; margin-bottom: 0.25rem;display: block;">Firmado digitalmente por: </span>                                    
                            <span style="font-size: 70%; color: #333366">'.$_SESSION['nombresTrabajador'].'</span>
                            <span style="font-size: 60%; padding-top: 0.25rem; display: block;">Motivo: Delegación de firma RDE N° 153-2023-APCI/DE</span>                                 
                        </p>
                    </td>
                </tr>
            </table>
        ';
    } else {
        $firma = '
            <table style="width: 100%">
                <tr>
                    <td style="width: 55px">
                        <img class="" src="../../dist/images/apci__loco__square.png" width="55" height="55" />
                    </td>
                    <td style="padding-left: 0.35rem;">
                        <p style="line-height: 1">
                            <span style="font-size: 70%; margin-bottom: 0.25rem;display: block;">Firmado digitalmente por: </span>
                            <strong style="font-size: 70%; color: #333366">'.$RsRemitente['nombreCompleto'].'</strong><br>
                            <span style="font-size: 70%;">'.$RsRemitente['cargo'].'</span>
                            <span style="font-size: 60%; padding-top: 0.25rem; display: block;">Motivo: Soy autor del documento</span>                                 
                        </p>
                    </td>
                </tr>
            </table>
        ';
    }
}

if (isset($flgSegundoPdf)){
    $tmp = dirname(tempnam(null, ''));
    $tmp = $tmp . "/qrImagen/";
    if (!is_dir($tmp)) {
        mkdir($tmp, 0777, true);
    }
    $PNG_TEMP_DIR = $tmp;
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 2;

    $rutaRedirect = $_SERVER['HTTP_HOST'] . '/verifica.php?cud='.$dataNotificacion['nCud'].'&clave='.$dataNotificacion['clave'];
    $codigoQr = 'QR' . md5($rutaRedirect . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
    $filename = $PNG_TEMP_DIR . $codigoQr;

    QRcode::png($rutaRedirect, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>SITDD</title>
    <?php include("template/styles.php"); ?>
    <style>
        table {
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table td, .table th {
            padding: 0.3rem;
            vertical-align: top;
            border: 1px solid #666;
        }

        th {
            text-align: inherit;
        }

        .text-center {
            text-align: center;
        }

        dl {
            margin: 0;
        }

        dl dd {
            margin-left: 0;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
<?php
    include ('template/head.php');
?>

<footer>
    <?php if (isset($flgSegundoPdf)){ ?>
        <table style="width: 100%; border-top: 1px solid #CC9933;">
            <tr>
                <td style="padding-left: 0.15rem;" valign="top">
                    <p style="word-wrap:break-word; margin-bottom: 0; white-space:normal; font-size: 60%; font-style: italic; line-height: 1; text-align: justify; color: #999"><strong>Esta es una copia auténtica imprimible de un documento electrónico archivado en la Agencia Peruana de Cooperación Internacional,</strong> aplicando lo dispuesto por el Art. 25 de D.S. 070-2013-PCM y la Tercera Disposición Complementaria Final del D.S. 26-2016-PCM. Su autenticidad e integridad pueden ser contrastadas a través de la siguiente dirección web: https://d-tramite.apci.gob.pe/verifica.php con clave: <?=$dataNotificacion['clave']?></p>
                </td>
                <!-- <td style="text-align: right; padding-top: 5px">
                    <img class="footerImg" src="../../dist/images/footerPCM.png" height="40" />
                </td> -->
                <td style="text-align: right; padding-top: 5px">
                    <img class="footerImg" src="../../dist/images/bicentenario-pie.png" height="45" />
                </td>
            </tr>
        </table>
    <?php } else { ?>
        <img class="footerImg" src="../../dist/images/pie.png">
    <?php
        }
    ?>
</footer>
<main>
    <div class="canvas">
        <div class="text-center">
            <p><strong><?=$fecha?></strong></p>
            <p><strong>Anexo Nº 05</strong></p>
            <p><strong>Formato de Cédula de Notificación Electrónica</strong></p>
            <p><strong><?=$numDoc?></strong></p>
        </div>
        <!-- <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Neque vel ad a accusantium rerum ab consequuntur perferendis exercitationem nihil fuga nisi sint hic dignissimos natus unde ea molestiae, aut atque.</p> -->
        <table class="table table-sm">
            <tbody>
                <!-- <tr>
                    <th scope="row">Expediente</th>
                    <td><?//=$asunto?></td>
                </tr> -->
                <tr>
                    <th scope="row">Nombre o denominación del administrado:</th>
                    <td><?=$entidad?></td>
                </tr>
                <!-- <tr>
                    <th scope="row">Domicilio</th>
                    <td>
                        <address>
                            <?//=$direccion?><br>
                            <?//=$ubigeo?>
                        </address>
                    </td>
                </tr> -->
                <tr>
                    <th scope="row">Número de Casilla Electrónica (dirección):</th> 
                    <td>
                        <dl>
                            <dt><?=$nroDocEntidad?></dt>
                        </dl>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Acto o actuación administrativa notificada:</th>
                    <td>
                        <dl>
                            <dt><?=$documento?></dt>
                        </dl>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Anexos</th>
                    <td>
                        <dl>
                            <?=$adjuntos?>
                        </dl>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Número de Folios (total):</th>
                    <td>
                        <dl>
                            <?=$folios?>
                        </dl>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Dependencia de la APCI emisor/a del acto o actuación administrativa notificada:</th>
                    <td>
                        <dl>
                            <?=$oficinaRegistro?>
                        </dl>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Comentarios (en caso corresponda, lo comprendido adicionalmente en el artículo 24, numeral 24.1, del TUO de la Ley Nº 27444):</th>
                    <td>
                        <dl>
                            <?=$observacion?>
                        </dl>
                    </td>
                </tr>
            </tbody>
        </table>
        <?=$firma;?>                            
    </div>
</main>
</body>
</html>

<?php

$content = ob_get_clean();

$nuevo_nombre = DocDigital::formatearNombre(str_replace(' ','-',trim($dataNotificacion['cDescTipoDoc'])).'-'.str_replace('/','-',rtrim($dataNotificacion['cCodificacion'])),false,[' ']).'.pdf';
$nuevo_nombre = $destinoExterno['idTramiteNotificacion'].'-'.$destinoExterno['iCodRemitente'].'-'.$nuevo_nombre;

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
$urlTemp = $tmp.$separa.$nuevo_nombre;
file_put_contents($urlTemp, $output);

$docDigital = new DocDigital($cnx);

if (isset($flgSegundoPdf)){
    $docDigital->idTipo = 8;
} else {
    $docDigital->idTipo = 2;
}

$docDigital->tmp_name = $urlTemp;
$docDigital->name = $nuevo_nombre;
$docDigital->type = 'application/pdf';

$docDigital->idTramite = $destinoExterno['idTramiteNotificacion'];
$docDigital->idEntidad = $destinoExterno['iCodRemitente'];
$docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
$docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];

$docDigital->subirDocumento();

?>