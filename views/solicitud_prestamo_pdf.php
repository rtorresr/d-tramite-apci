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

$queryDatosSolicitud = "select
	sp.IdOficinaRequerida,
	o.cNomOficina,
	sp.FecRegistro,
	sp.NroSolicitud
from T_Solicitud_Prestamo as sp
	inner join Tra_M_Oficinas as o on o.iCodOficina = sp.IdOficinaRequerida
where sp.FlgEliminado = 1 and sp.IdSolicitudPrestamo = ".$data['IdSolicitudPrestamo'];
$rsDatosSolicitud = sqlsrv_query($cnx, $queryDatosSolicitud);
$datosSolicitud = sqlsrv_fetch_array($rsDatosSolicitud, SQLSRV_FETCH_ASSOC);

#1. Declaramos las variables
$titulo = 'SERVICIO ARCHIVISTICO N° '.$datosSolicitud['NroSolicitud'];

$asunto = "Solicitud de préstamos de documentos";

$timestamp = $datosSolicitud['FecRegistro'] instanceof \DateTimeInterface
    ? $datosSolicitud['FecRegistro']->getTimestamp()
    : strtotime((string) $datosSolicitud['FecRegistro']);

$fecha = ucfirst(strftime('%A, %e de %B del %Y', $timestamp));

$queryDatosSolicitudDetalle = "select
	spd.IdDetallePrestamo,
	spd.ExpedienteDocumento,
	spd.TipoDocumental,
	spd.NumeroDocumento,
	spd.FechaDocumento,
	spd.DescripcionDocumento,
	spd.FlgDocDigital,
	spd.IdTipoServicio,
	tc.NombreContenido as NombreTipoServicio
from T_Solicitud_Prestamo_Detalle as spd
	left join Tra_M_Tipo_Contenido as tc on tc.IdContenido = spd.IdTipoServicio
where spd.FlgEliminado = 1 and spd.IdSolicitudPrestamo = ".$data['IdSolicitudPrestamo'];
$rsDatosSolicitudDetalle = sqlsrv_query($cnx, $queryDatosSolicitudDetalle);

$datosSolicitudDetalle = [];
while ($row = sqlsrv_fetch_array($rsDatosSolicitudDetalle, SQLSRV_FETCH_ASSOC)) {
    $datosSolicitudDetalle[] = $row;
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
    include ('../template/head.php');
?>

<main>
    <style>
        .serv-archivistico {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .serv-archivistico h1 {
            text-align: center;
            font-size: 12pt;
        }
        .serv-archivistico table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }
        .serv-archivistico td {
            padding: 5px;
            vertical-align: top;
            border: 1px solid #000;
        }
        .serv-archivistico .tabla-sin-bordes td {
            border: none;
            padding: 3px;
        }
        .serv-archivistico .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
        }
        .serv-archivistico .checked {
            background-color: #000;
        }
        .serv-archivistico .espaciado {
            margin-top: 1em;
            margin-bottom: 0.5em;
        }
    </style>
    
    <div class="serv-archivistico">
        <h1><?=$titulo;?></h1>
        <table class="tabla-sin-bordes">
            <tr>
                <td><strong>Asunto:</strong></td>
                <td><?=$asunto;?></td>
            </tr>
            <tr>
                <td><strong>Fecha:</strong></td>
                <td><?=$fecha;?></td>
            </tr>
        </table>

        <?php
            foreach($datosSolicitudDetalle as $detalle){
        ?>
            <table>
                <tr>
                    <td><strong>SECCIÓN</strong></td>
                    <td colspan="7"><?=$datosSolicitud['cNomOficina'];?></td>
                </tr>
                <tr>
                    <td><strong>SERIE DOCUMENTAL</strong></td>
                    <td colspan="7"><?=$detalle['ExpedienteDocumento'];?></td>
                </tr>
                <tr>
                    <td><strong>TIPO DOCUMENTAL</strong></td>
                    <td colspan="7"><?=$detalle['TipoDocumental'];?></td>
                </tr>
                <tr>
                    <td><strong>N° DEL DOCUMENTO</strong></td>
                    <td colspan="7"><?=$detalle['NumeroDocumento'];?></td>
                </tr>
                <tr>
                    <td><strong>DESCRIPCIÓN DEL DOCUMENTO</strong></td>
                    <td colspan="7"><?=$detalle['DescripcionDocumento'];?></td>
                </tr>
                <tr>
                    <td><strong>FECHA DEL DOCUMENTO</strong></td>
                    <td colspan="7">
                        <?php
                            if ($detalle['FechaDocumento'] instanceof DateTime) {
                                echo $detalle['FechaDocumento']->format('d/m/Y');
                            } elseif (!empty($detalle['FechaDocumento'])) {
                                $fecha = date_create($detalle['FechaDocumento']);
                                echo $fecha ? $fecha->format('d/m/Y') : $detalle['FechaDocumento'];
                            } else {
                                echo '';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="8"><strong>MODALIDAD DE SERVICIO ARCHIVÍSTICO</strong></td>
                </tr>
                <tr>
                    <td>REPRODUCCIÓN FÍSICA DE DOCUMENTO</td>
                    <td><span class="checkbox <?=($detalle['FlgDocDigital'] == 1 && $detalle['IdTipoServicio'] == 110 ? 'checked' : '');?>"></span></td>
                    <td>REPRODUCCIÓN DIGITAL DE DOCUMENTO</td>
                    <td><span class="checkbox <?=($detalle['FlgDocDigital'] == 0 ? 'checked' : '');?>"></span></td>
                    <td>CONSULTA DE DOCUMENTO</td>
                    <td><span class="checkbox <?=($detalle['FlgDocDigital'] == 1 && $detalle['IdTipoServicio'] == 58 ? 'checked' : '');?>"></span></td>
                    <td>PRÉSTAMO FÍSICO DE DOCUMENTO</td>
                    <td><span class="checkbox <?=($detalle['FlgDocDigital'] == 1 && $detalle['IdTipoServicio'] == 59 ? 'checked' : '');?>"></span></td>
                </tr>
            </table>

        <?php
            }
        ?>

        <p class="espaciado">
            El presente documento cuenta con el visto bueno del colaborador de la dependencia, quien de ser el caso debe recoger lo solicitado en el archivo central, y la firma del responsable del archivo de gestión.
        </p>
    </div>
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
$docDigital->size = filesize($urlTemp);

$docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
$docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
$docDigital->sesion = $_SESSION['IdSesion'];

$docDigital->subirDocumentoSecundario();

if (!isset($flgSegundoPdf)){
    $ruta = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();
}

$idDocDigital = $docDigital->idDocDigital;
?>