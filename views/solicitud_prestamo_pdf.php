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

//DETERMINAMOS CABECERA DEL DOCUMENTO
//DETERMINA EL PADRE SI ES SUBDIRECCION
$sqlofi = "select cSiglaOficina as sigla  from Tra_M_Oficinas where iCodOficina =".$data['IdOficinaSolicitante'];
$qofice=sqlsrv_query($cnx,$sqlofi);
$siglaoficina=sqlsrv_fetch_array($qofice);
if (strpos($siglaoficina['sigla'], '-')){
    $arrayoficina = explode("-", $siglaoficina['sigla']);
    $oficinajefe = $arrayoficina[0];
}else{
    $oficinajefe = $siglaoficina['sigla'];
}

//CONVIENRTE EL FORMATO DEL NOMBRE
$sqloficina = "select iCodOficina, cNomOficina as oficina  from Tra_M_Oficinas where cSiglaOficina like '".trim($oficinajefe)."'";
$rsoficina=sqlsrv_query($cnx,$sqloficina);
$siglaoficina=sqlsrv_fetch_array($rsoficina);
$words = array('Y', 'De','E');
$regex = '/\b(' . implode( '|', $words) . ')\b/i';
$formatted_tag = preg_replace_callback( $regex, function( $matches) {
    return strtolower( $matches[1]);
}, ucwords(mb_strtolower(trim($siglaoficina['oficina']))));
$oooo = sliceString($formatted_tag,3);

#1. Declaramos las variables
$titulo = 'SERVICIO ARCHIVISTICO N° '.$data['NOMBRE_DOC'];

# Tipo de servicio
$sqlTipoServicio = "select distinct IIF(de.FlgDocDigital = 0, 'escaneo', (select tc.NombreContenido from Tra_M_Tipo_Contenido as tc where tc.IdContenido = de.IdTipoServicio ) ) + ' ' +IIF(de.FlgDocDigital = 0, 'digital', 'físico') as tipo
                from T_Solicitud_Prestamo_Detalle as de
                where de.FlgEliminado = 1 and de.IdSolicitudPrestamo = ".$data['IdSolicitudPrestamo'];
$rsTipoServicio=sqlsrv_query($cnx,$sqlTipoServicio);

$tipoServicio = "";
while( $RsTipoServicio = sqlsrv_fetch_array($rsTipoServicio,SQLSRV_FETCH_ASSOC)){
    $tipoServicio.= $RsTipoServicio['tipo']." ,";
}
$tipoServicio = substr($tipoServicio, 0, -1);

$asunto = "Solicitud de ".$tipoServicio." de documentos";
$fecha= strftime('%A, %e de %B del %Y', strtotime(date('m/d/Y')));

# Oficina solicitante
$sqlOficina = "SELECT cNomOficina, cSiglaOficina FROM Tra_M_Oficinas WHERE iCodOficina = ".$data['IdOficinaSolicitante'];
$rsOficina=sqlsrv_query($cnx,$sqlOficina);
$RsOficina = sqlsrv_fetch_array($rsOficina,SQLSRV_FETCH_ASSOC);
$seccion = $RsOficina['cNomOficinac']." - ".$RsOficina['cSiglaOficina'];

if (isset($flgSegundoPdf)){    
    $tmp = dirname(tempnam(null, ''));
    $tmp = $tmp . "/qrImagen/";
    if (!is_dir($tmp)) {
        mkdir($tmp, 0777, true);
    }
    $PNG_TEMP_DIR = $tmp;
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 2;

    $rutaRedirect = $_SERVER['HTTP_HOST'] . '/verifica.php?cud=&clave=';
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
</head>
<body>
<?php
    if ($param['head'] === 'title'){
        include ('template/head.php');
    }
?>
<p><?=$titulo;?></p>

<footer>
    <?php if (isset($flgSegundoPdf)){ ?>
        <table style="width: 100%; border-top: 1px solid #CC9933;">
            <tr>
                <td style="padding-left: 0.15rem;" valign="top">
                    <p style="word-wrap:break-word; margin-bottom: 0; white-space:normal; font-size: 55%; font-style: italic; line-height: 1; text-align: justify; color: #999"><strong>Esta es una copia auténtica imprimible de un documento electrónico archivado en la Agencia Peruana de Cooperación Internacional,</strong> aplicando lo dispuesto por el Art. 25 de D.S. 070-2013-PCM y la Tercera Disposición Complementaria Final del D.S. 26-2016-PCM. Su autenticidad e integridad pueden ser contrastadas a través de la siguiente dirección web: https://d-tramite.apci.gob.pe/verifica.php con clave: <?=$dataFirma['clave']?></p>
                </td>                    
                <td style="text-align: right; padding-top: 5px">
                    <img class="footerImg" src="../../dist/images/bicentenario-pie.png" height="48" />
                </td>
                <td style="text-align: right; padding-top: 5px">
                    <img class="footerImg" src="../../dist/images/con-punche-peru.png" height="48" />
                </td>
            </tr>
        </table>
    <?php } else { ?>
        <img class="footerImg" src="../../dist/images/pie.png">
    <?php } ?>
</footer>
<main>
    <div class="glosa">
        <?php if (isset($flgSegundoPdf)){
            echo '<table style="width: 100%">
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
        }?>
</main>
</body>
</html>
    <?php


$content = ob_get_clean();

$nuevo_nombre = "solicitud-prestamo-".str_replace("/","-", $data['NOMBRE_DOC']).'.pdf';

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

$docDigital->idRegistroTabla = $data['IdSolicitudPrestamo'];
if (isset($flgSegundoPdf)){
    $docDigital->idTipo = 16;
} else {
    $docDigital->idTipo = 15;
}

$docDigital->tmp_name = $urlTemp;
$docDigital->name = $nuevo_nombre;
$docDigital->type = 'application/pdf';

$docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
$docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];

$docDigital->subirDocumentoSecundario();

if (!isset($flgSegundoPdf)){
    $ruta = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();
}

$idDocDigital = $docDigital->idDocDigital;
?>