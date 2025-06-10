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

$queryDatosSolicitud = "select
    sp.IdOficinaSolicitante,
	sp.IdOficinaRequerida,
	o.cNomOficina,
    os.cNomOficina as cNomOficinaSolicitante,
	sp.FecRegistro,
	sp.NroCargoDevolucion,
    [dbo].[fn_NombreTrabajador](sp.IdTrabajadorSolicitante) as trabajadorSolicitante,
    sp.FecNotificacionEntrega,
    sp.FecDevolucion
from T_Solicitud_Prestamo as sp
	inner join Tra_M_Oficinas as o on o.iCodOficina = sp.IdOficinaRequerida
    inner join Tra_M_Oficinas as os on os.iCodOficina = sp.IdOficinaSolicitante
where sp.FlgEliminado = 1 and sp.IdSolicitudPrestamo = ".$IdSolicitudPrestamo;
$rsDatosSolicitud = sqlsrv_query($cnx, $queryDatosSolicitud);
$datosSolicitud = sqlsrv_fetch_array($rsDatosSolicitud, SQLSRV_FETCH_ASSOC);

//DETERMINAMOS CABECERA DEL DOCUMENTO
//DETERMINA EL PADRE SI ES SUBDIRECCION
$sqlofi = "select cSiglaOficina as sigla  from Tra_M_Oficinas where iCodOficina =".$datosSolicitud['IdOficinaSolicitante'];
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
$titulo = 'CARGO DE DEVOLUCION DE SERVICIO ARCHIVISTICO N° '.$datosSolicitud['NroCargoDevolucion'];

$fechaEntrega = '';
if ($datosSolicitud['FecNotificacionEntrega'] instanceof DateTime) {
    $fechaEntrega = $datosSolicitud['FecNotificacionEntrega']->format('d/m/Y');
} elseif (!empty($datosSolicitud['FecNotificacionEntrega'])) {
    $fechaTmp = date_create($datosSolicitud['FecNotificacionEntrega']);
    $fechaEntrega = $fechaTmp ? $fechaTmp->format('d/m/Y') : $datosSolicitud['FecNotificacionEntrega'];
}

$fechaDevolucion = '';
if ($datosSolicitud['FecDevolucion'] instanceof DateTime) {
    $fechaDevolucion = $datosSolicitud['FecDevolucion']->format('d/m/Y');
} elseif (!empty($datosSolicitud['FecDevolucion'])) {
    $fechaTmpDev = date_create($datosSolicitud['FecDevolucion']);
    $fechaDevolucion = $fechaTmpDev ? $fechaTmpDev->format('d/m/Y') : $datosSolicitud['FecDevolucion'];
}

$queryDatosSolicitudDetalle = "select
	spd.IdDetallePrestamo,
	spd.ExpedienteDocumento,
	spd.TipoDocumental,
	spd.NumeroDocumento,
	spd.FechaDocumento,
	spd.DescripcionDocumento,
	spd.FlgDocDigitalOfrecido,
	spd.IdTipoServicioOfrecido,
	tc.NombreContenido as NombreTipoServicio
from T_Solicitud_Prestamo_Detalle as spd
	left join Tra_M_Tipo_Contenido as tc on tc.IdContenido = spd.IdTipoServicioOfrecido
where spd.FlgEliminado = 1 and spd.IdSolicitudPrestamo = ".$IdSolicitudPrestamo;
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
            margin-bottom: 30px;
        }
        .serv-archivistico .datos {
            margin-bottom: 20px;
        }
        .serv-archivistico table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        .serv-archivistico table, .serv-archivistico th, .serv-archivistico td {
            border: 1px solid #000;
        }
        .serv-archivistico th {
            text-align: center;
            background-color: #f0f0f0;
        }
        .serv-archivistico td {
            padding: 6px;
            vertical-align: top;
        }
    </style>
    
    <div class="serv-archivistico">
        <h1><?=$titulo?></h1>

        <div class="datos">
            <table>
                <tbody>
                    <tr>
                        <td style="background-color: #f0f0f0;"><strong>USUARIO ATENDIDO:</strong></td>
                        <td><?=$datosSolicitud['trabajadorSolicitante']?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #f0f0f0;"><strong>DEPENDENCIA:</strong></td>
                        <td><?=$datosSolicitud['cNomOficinaSolicitante']?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3><u>Documentación atendida</u></h3>

        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>DESCRIPCIÓN DOCUMENTAL</th>
                    <th>SERIE DOCUMENTAL</th>
                    <th>MODALIDAD DE SERVICIO</th>
                    <!-- <th>FOLIOS</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($datosSolicitudDetalle as $index => $detalle){
                ?>
                <tr>
                    <td style="text-align:center;"><?=$index + 1?></td>
                    <td><?=$detalle['DescripcionDocumento']?></td>
                    <td><?=$detalle['ExpedienteDocumento']?></td>
                    <td><?=($detalle['FlgDocDigitalOfrecido'] == 1 ? 'Préstamo Digital de Documento' : $detalle['NombreTipoServicio']);?></td>
                    <!-- <td style="text-align:center;">20</td> -->
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>

        <h3><u>Fecha de entrega de documentación</u></h3>

        <table style="width: 30%">
            <tbody>
                <tr>
                    <td><?=$fechaEntrega?></td>
                </tr>
            </tbody>
        </table>

        <h3><u>Fecha de devolución de documentación</u></h3>
        
        <table style="width: 30%">
            <tbody>
                <tr>
                    <td><?=$fechaDevolucion?></td>
                </tr>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
    <?php


$content = ob_get_clean();

$nuevo_nombre = "cargo-prestamo-devolucion-".str_replace("/","-", $datosSolicitud['NroCargoDevolucion']).'.pdf';

$dompdf = new DOMPDF();
$dompdf->loadHtml($content);
$dompdf->render();

// $dompdf->stream($nuevo_nombre, [
//     "Attachment" => false // false = se muestra en el navegador
// ]);

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

$docDigital->idRegistroTabla = $IdSolicitudPrestamo;

$docDigital->idTipo = 21;

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