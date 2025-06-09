<?php
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;

include_once("../conexion/conexion.php");
include_once("../conexion/parametros.php");
session_start();
set_time_limit(0);     ini_set('memory_limit', '3540M');
ob_start();
date_default_timezone_set('America/Lima');
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');

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

function add_ceros($numero,$ceros) {
    $insertar_ceros = 0;
    $order_diez = explode('.',$numero);
    $dif_diez = $ceros - strlen($order_diez[0]);
    for($m=0; $m<$dif_diez; $m++){
        $insertar_ceros .= 0;
    }
    return $insertar_ceros.= $numero;
}

// JEFE NOMBRE Y SIGLAS DE LA UNIDAD
function oficinaJefe ($siglas){
    if (strpos($siglas, '-')){
        $arrayoficina = explode("-", $siglas);
        $oficinajefe = $arrayoficina[0];
    }else{
        $oficinajefe = 'DE';
    }
    return  $oficinajefe;
};

//NOMBRE DEL HEAD  TERCER CUADRADO
function nombreHead($siglas){
    if (strpos($siglas, '-')){
        $arrayoficina = explode("-", $siglas);
        $oficina = $arrayoficina[0];
    } else{
        if(isset($_POST['proyecto']) && $_SESSION['iCodPerfilLogin'] == '3'){
            $oficina = 'DE';
        } else {
            $oficina = $siglas;
        }
    }
    return  $oficina;
}

$fecha = date('d/m/Y');
$hora = date('G:i:s');

$sqlOfi = "SELECT cNomOficina, cSiglaOficina  FROM Tra_M_Oficinas WHERE iCodOficina =".$_POST['iCodOficinaFirmante'];
$rsOfi=sqlsrv_query($cnx,$sqlOfi);
$RsOfi=sqlsrv_fetch_array($rsOfi);

// NOMBRE DE LA OFICINA EN EL HEAD
$words = array('Y', 'De','E');
$regex = '/\b(' . implode( '|', $words) . ')\b/i';
$formatted_tag = preg_replace_callback( $regex, function( $matches) {
    return strtolower( $matches[1]);
}, ucwords(mb_strtolower(trim($RsOfi['cNomOficina']))));
$oooo = sliceString(trim($formatted_tag),3);
// NUMERO DEL DOCUMENTO
$numDoc = 'CÉDULA DE NOTIFICACIÓN Nº XXX-'.date('Y').'-APCI/'.trim($RsOfi['cSiglaOficina']);

$asunto = $_POST['cAsunto'];

$params = array(
    0,
    $_POST['id']
);
$sqlAdd = "{call SP_CONSULTA_DATOS_DOCUMENTO_DESTINATARIOS (?,?) }";
$rs = sqlsrv_query($cnx, $sqlAdd, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}

// $destinatarios = [];
// if(sqlsrv_has_rows($rs)){ 
//     while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
//         $destinatarios[]=$row;
//         if(isset($row['FoliosDespacho'])){
//             $folios=$row['FolioDespacho'];
//         }
//     }
// }

foreach($destinatarios as $i => $e){
    if($e['iCodRemitente'] == $_POST['destinatario']){
        $destinatarios = $e;
    }
}

// $destinatarios = json_decode($_POST['destinatarios']);
// $destinatarios = $destinatarios[0];

$entidad = $destinatarios['nomRemitente'];
$direccion = $destinatarios['cDireccion'];

$ubigeo = explode('|',$direccion);
$direccion = $ubigeo[0];
unset($ubigeo[0]);
unset($ubigeo[1]);

$ubigeo = implode('<br>', $ubigeo);

$documento = trim($_POST['cDescTipoDoc']).' N° XXX-'.date('Y').'-APCI/'.trim($RsOfi['cSiglaOficina']);

$nroDocEntidad = $destinatarios['nroDocumento'];
// $despacho = json_decode($_POST['despacho']);
//$folios = isset($destinatarios->FoliosDespacho) ? $destinatarios->FoliosDespacho : 0;
$folios = $destinatarios['foliosDespacho'];
$observacion = isset($destinatarios->ObservacionesDespacho) ? $destinatarios->ObservacionesDespacho : '';
$oficinaRegistro = $_POST['OficinaFirmante'];

$addAnex = '';
if(isset($_POST['cAnexosImprimibles']) && $_POST['cAnexosImprimibles'] != ''){
    $anexos = json_decode($_POST['cAnexosImprimibles']);
    $addAnex = '';
    for ($i = 0; $i < count($anexos); $i++) {
        $anex = $anexos[$i] -> iCodDigital;
        $rsdatosAnex = sqlsrv_query($cnx, "SELECT cNombreOriginal, cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE iCodDigital = ".$anex);
        $RsdatosAnex = sqlsrv_fetch_array($rsdatosAnex);

        if(trim($RsdatosAnex['cNombreOriginal']) == ''){
            $nuevoNom = explode('/',trim($RsdatosAnex['cNombreNuevo']));
            $nuevoNom = $nuevoNom[count($nuevoNom)-1];
            $addAnex.= '<dt>'.$nuevoNom.'</dt>';
        } else {
            $addAnex.= '<dt>'.trim($RsdatosAnex['cNombreOriginal']).'</dt>';
        }
    }
}

$firma = '
        <table style="width: 100%;">
            <tr>
                <td style="width: 55px; vertical-align: top;">
                    <img class="" src="../dist/images/apci__loco__square.png" width="55" height="55" />
                </td>
                <td style="padding-left: 0.35rem; vertical-align: top;">
                    <p style="line-height: 1; margin-top: 0; padding-top:0;">
                        <span style="font-size: 70%; display: block;">Previsualización de firma: </span>
                        <strong style="font-size: 70%; color: #333366">Previsualización de firma</strong><br>
                        <span style="font-size: 70%;">Previsualización de firma</span>
                        <span style="font-size: 60%; padding-top: 0.25rem; display: block;">Motivo: Previsualización de firma</span>
                    </p>
                </td>
            </tr>
        </table>
        ';

if($_SESSION['flgDelegacion'] == 1 && $_SESSION['iCodOficinaLogin'] == 356){
    $firma = '
        <table style="width: 100%;">
            <tr>
                <td style="width: 55px; vertical-align: top;">
                    <img class="" src="../dist/images/apci__loco__square.png" width="55" height="55" />
                </td>
                <td style="padding-left: 0.35rem; vertical-align: top;">
                    <p style="line-height: 1; margin-top: 0; padding-top:0;">
                        <strong style="font-size: 70%; color: #333366">Previsualización de firma</strong><br>
                        <span style="font-size: 70%;margin-bottom: 12px; display:block;">Previsualización de firma</span>

                        <span style="font-size: 70%; display: block;">Firmado digitalmente por: </span>                                    
                        <span style="font-size: 70%; color: #333366">Previsualización de firma</span>
                        <span style="font-size: 60%; padding-top: 0.25rem; display: block;">Motivo: Previsualización de firma</span> 
                    </p>
                </td>
            </tr>
        </table>
    ';
}

?>
    
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>SITDD</title>
        <?php include_once("template/styles.php"); ?>
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
                letter-spacing: 0px;
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
        <header>
            <table>
                <tr id="logoMin">
                    <td id="peruLogo" class="center" style="heigth: 50px; width: 50px; border:solid white 1.0pt; background:white;">
                        <img width="34" src="../dist/images/peru.png">
                    </td>
                    <td id="peruText" class="center minText" width="150" style="heigth: 50px; width: 50px; border:solid white 1.0pt;background:#C00000;">
                        <p>PERÚ</p>
                    </td>
                    <td class="minText" width="151" style="heigth: 50px; width: 150px;border:solid white 1.0pt;border-left:none; background:#333333;">
                        <p>Ministerio <br> de Relaciones Exteriores</p>
                    </td>
                    <td class="minText" width="180" style="heigth: 50px; width: 150px;border:solid white 1.0pt;border-left:  none;  background:#999999;">
                        <p>Agencia Peruana <br> de Cooperación Internacional</p>
                    </td>

                    <td class="minText" width="151" style="heigth: 50px; width: 150px; border:solid white 1.0pt;border-left:none;  background:silver;">
                        <p><?= $oooo;?></b>
                        </p>
                    </td>
                </tr>
                <tr id="logoCaption">
                    <td colspan="5">
                        <p>
                            <?php echo DENOMINACION_DECENIO;?>
                            <br>
                            <?php echo DENOMINACION_ANIO_1?>
                            <?php echo DENOMINACION_ANIO_2 != '' ? '<br>'.DENOMINACION_ANIO_2 : ''?>
                        </p>
                    </td>
                </tr>
            </table>
        </header>
        <footer>
            <img class="footerImg" src="../dist/images/pie.png">
        </footer>
        <main>
            <div class="canvas">
                <div class="text-center">
                    <p><strong>Fecha: <?=$fecha?></strong></p>
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
                        </tr>-->
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
                            <th scope="row">Anexos:</th>
                            <td>
                                <dl>
                                    <?=$addAnex?>
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

// conversion HTML => PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->render();

$output = $dompdf->output();

$b64Doc = chunk_split(base64_encode($output));
echo $b64Doc;
?>