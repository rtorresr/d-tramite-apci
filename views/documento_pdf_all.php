<?php
/**
 * Created by PhpStorm.
 * Users: anthonywainer, dcamarena
 * Date: 6/11/2018
 * Time: 5:27 PM
 */
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;

/*include_once("../conexion/conexion.php");
session_start();*/

set_time_limit(0);     ini_set('memory_limit', '3540M');
ob_start();
date_default_timezone_set('America/Lima');
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
//$RsUltTra['iCodTramite'] = $_GET['codigo'];
// LAS DEMAS CONSULTAS NACEN DE ESTA
$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite = '".$RsUltTra['iCodTramite']."'");
$Rs=sqlsrv_fetch_array($rs);

$sqlTipDoc="SELECT dbo.Tra_M_Tipo_Documento.cCodTipoDoc, dbo.Tra_M_Tipo_Documento.cDescTipoDoc, dbo.Tra_M_Plantilla.parametros FROM dbo.Tra_M_Tipo_Documento 
            INNER JOIN dbo.Tra_M_Plantilla ON dbo.Tra_M_Plantilla.cCodTipoDoc = dbo.Tra_M_Tipo_Documento.cCodTipoDoc WHERE dbo.Tra_M_Tipo_Documento.cCodTipoDoc=".$Rs['cCodTipoDoc'];
$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
$tipoDoc = trim($RsTipDoc['cDescTipoDoc']);
$param = eval("return ".$RsTipDoc['parametros'].";");
$numDoc = $tipoDoc.' N° '.$Rs['cCodificacion'];

//DETERMINAMOS CABECERA DEL DOCUMENTO
//DETERMINA EL PADRE SI ES SUBDIRECCION
$sqlofi = "select cSiglaOficina as sigla  from Tra_M_Oficinas where iCodOficina =".$Rs['iCodOficinaRegistro'];
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

if($Rs['nFlgTipoDoc'] == '2') {
    // DESTINOS INTERNOS
    $sqlDestinos = "SELECT 
 (	RTRIM( C.cNombresTrabajador ) + ' ' + RTRIM( C.cApellidosTrabajador )) AS nombreCompleto,
 TRIM(E.descripcion) AS cargo
FROM	Tra_M_Tramite_Movimientos A	
INNER JOIN Tra_M_Trabajadores C ON A.iCodTrabajadorDerivar = C.iCodTrabajador 
INNER JOIN Tra_M_Perfil_Ususario D ON A.iCodOficinaDerivar = D.iCodOficina AND A.iCodTrabajadorDerivar = D.iCodTrabajador
LEFT JOIN Tra_M_Cargo E ON E.iCodCargo = D.iCodCargo
WHERE	A.iCodTramite = ".$Rs['iCodTramite']." AND cFlgCopia = 0 AND (D.iCodPerfil = 3 OR D.iCodPerfil = 4)";
    $rsDestinos=sqlsrv_query($cnx,$sqlDestinos);
    $destino = '';
    while ($RsDestinos=sqlsrv_fetch_array($rsDestinos)){
        if ($RsDestinos['nombreCompleto'] != '') {
            $destino .= "<h2>" . $RsDestinos['nombreCompleto'] . "</h2>".'<p>' . $RsDestinos['cargo'] . '</p><br>';
        }
    }
} else {
    //DESTINO EXTERNO
    $sqlRemitente = "SELECT remi.cNombre, remi.cDireccion, dep.cCodDepartamento, dep.cNomDepartamento, pro.cCodProvincia,pro.cNomProvincia, dis.cNomDistrito
                                FROM Tra_M_Remitente AS remi LEFT OUTER JOIN Tra_U_Departamento AS dep ON
                                dep.cCodDepartamento = remi.cDepartamento LEFT OUTER JOIN Tra_U_Provincia AS pro ON
                                pro.cCodDepartamento = remi.cDepartamento AND pro.cCodProvincia = remi.cProvincia
                                LEFT OUTER JOIN Tra_U_Distrito AS dis ON dis.cCodDepartamento = remi.cDepartamento AND
                                dis.cCodProvincia = remi.cProvincia AND dis.cCodDistrito = remi.cDistrito WHERE
                                iCodRemitente = " .$Rs['iCodRemitente'];
    $rsRemitente = sqlsrv_query($cnx, $sqlRemitente);
    $RsRemitente = sqlsrv_fetch_array($rsRemitente);

    if ($RsRemitente['cNomDepartamento'] !== null){
        if($RsRemitente['cCodDepartamento'] === '15' || $RsRemitente['cCodDepartamento'] === '26'){
            $ubigeo = '';
        } else {
            $ubigeo = $RsRemitente['cNomDepartamento'].', ';
        }

        if($RsRemitente['cNomProvincia'] !== null){
            if($RsRemitente['cCodDepartamento'] === '15' && $RsRemitente['cCodProvincia'] === '01'){
                $ubigeo .= '';
            } else {
                $ubigeo .= $RsRemitente['cNomProvincia'].', ';
            }

            if($RsRemitente['cNomDistrito'] !== null){
                $ubigeo .= $RsRemitente['cNomDistrito'].'.-';
            }
        }
        $ubigeo = '<span style="text-decoration: underline">'.$ubigeo.'</span>';
    }

    // DESTINO
    if($_POST['prefijoNombre'] !== ''){
        $persona = $_POST['prefijoNombre'].'<br>';
    } else {
        $persona = 'Señor(a)<br>';
    }

    $destinoi = '<p class="destinatario">';
    if($Rs['nombreResponsable'] !== ''){
        $responsable  = '<strong>'.$Rs['nombreResponsable'].'</strong><br>';
    }
    if($Rs['cargoResponsable'] !== ''){
        $cargo  = $Rs['cargoResponsable'].'<br>';
    }
    $nombreRe = $RsRemitente['cNombre'].'<br>';
    if(trim($RsRemitente['cDireccion']) !== ''){
        $direccion = trim($RsRemitente['cDireccion']).'<br>';
    }
    $destinof = '</p>';
}

 //  REMITENTE
if($_SESSION['iCodPerfilLogin'] == '20'){
    $rsDirector = sqlsrv_query($cnx,"SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = ".$_SESSION['iCodOficinaLogin']." AND iCodPerfil = 3");
    $RsDirector = sqlsrv_fetch_array($rsDirector);
    $perfil = 3;
    $trabajador = $RsDirector['iCodTrabajador'];
} else {
    $perfil = $_SESSION['iCodPerfilLogin'];
    $trabajador = $_SESSION['CODIGO_TRABAJADOR'];
}

$sqlRemitente = "SELECT CONCAT(TRIM(trab.cNombresTrabajador),' ',TRIM(trab.cApellidosTrabajador)) AS nombreCompleto, car.descripcion AS cargo 
                     FROM Tra_M_Perfil_Ususario AS pu
                    INNER JOIN Tra_M_Trabajadores AS trab ON trab.iCodTrabajador = pu.iCodTrabajador
                    INNER JOIN Tra_M_Cargo AS car ON car.iCodCargo = pu.iCodCargo
                    WHERE pu.iCodOficina = ".$_SESSION['iCodOficinaLogin']." AND pu.iCodTrabajador = ".$trabajador." AND pu.iCodPerfil = ".$perfil;
$rsRemitente=sqlsrv_query($cnx,$sqlRemitente);
$RsRemitente=sqlsrv_fetch_array($rsRemitente);
$remite="<h2>" .$RsRemitente['nombreCompleto']  . "</h2> <p>".$RsRemitente['cargo'].'</p>';

setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
$fecha = $Rs['fFecRegistro']->format('m/d/Y');

//REFERENCIAS
$sqlreferencias = "SELECT 
                            CASE
                                WHEN tra.cNroDocumento IS NOT NULL
                                    THEN CONCAT(RTRIM(tipo.cDescTipoDoc),' ',RTRIM(tra.cNroDocumento))
                                ELSE
                                    CONCAT(RTRIM(tipo.cDescTipoDoc),' ',RTRIM(tra.cCodificacion))
                            END AS referencia
                            FROM Tra_M_Tramite_Referencias AS ref
                            LEFT OUTER JOIN Tra_M_Tramite AS tra ON ref.iCodTramiteRef = tra.iCodTramite
                            LEFT OUTER JOIN Tra_M_Tipo_Documento AS tipo ON tipo.cCodTipoDoc = tra.cCodTipoDoc
                            WHERE ref.iCodTramite = '".$Rs['iCodTramite']."'";
$referencias=sqlsrv_query($cnx,$sqlreferencias);
if (sqlsrv_has_rows($referencias)){
    $cadenaRef = '';
    while ($ref=sqlsrv_fetch_array($referencias)){
        $cadenaRef .= trim($ref['referencia']). '<br>';
    }
}

// LISTA LOS ADJUNTOS
$rsAnexos = sqlsrv_query($cnx, "SELECT cNombreOriginal, cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE iCodTramite = ".$Rs['iCodTramite']);
if(sqlsrv_has_rows($rsAnexos)){
    $addAnex = '';
    while ($RsAnexos = sqlsrv_fetch_array($rsAnexos)){
        if(trim($RsAnexos['cNombreOriginal']) == ''){
            $nuevoNom = explode('/',trim($RsAnexos['cNombreNuevo']));
            $nuevoNom = $nuevoNom[count($nuevoNom)-1];
            $addAnex.= '<li>'.$nuevoNom.'</li>';
        } else {
            $addAnex.= '<li>'.trim($RsAnexos['cNombreOriginal']).'</li>';
        }
    }
    $adjuntos = '<div class="pre-footer">Adjuntos: <ul>'.$addAnex.'</ul></div>';
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>SITDD</title>
    <style>
        /**
            Set the margins of the page to 0, so the footer and the header
            can be of the full height and width !
         **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            font-family: Calibri, Arial, sans-serif;
            font-size: 11pt;
            text-align: justify;
            margin-top: 4.5cm;
            margin-left: 3cm;
            margin-right: 2.5cm;
            margin-bottom: 2.5cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            margin: 0 auto;
            text-align: center;
            width: 85%;
            left: 50%;
            margin-left: -37.5%;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 3cm;
            right: 2.5cm;
            height: 2cm;
        }

        footer {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        #logoMin {
            color: #FFFFFF;
        }

        #logoCaption {
            color: #515151;
            text-align: center;
            font-size: 10px;
        }

        .minText p {
            font-size: 9pt;
            font-weight: 700;
            padding-left: 7px;
            padding-right: 7px;
        }

        h1 {
            font-size: 11pt;
            text-align: center;
            text-decoration: underline;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.75cm;
        }

        .asesor {
            font-size: 8pt;
            text-align: center;
            text-decoration: overline;
            text-transform: uppercase;
            width: auto;
            margin: 0 auto;
            line-height: 1rem;
        }
        .cargo {
            font-size: 8pt;
            text-align: center;
        }

        .left-align {
            text-align: left;
        }

        .no-underline {
            text-decoration: none;
        }

        h2 {
            font-size: 11pt;
            margin: 0;
            text-align: left;
        }

        .subtitle {
            text-align: left;
        }

        .subtitle h3 {
            font-size: 11pt;
        }

        .item   {
            text-align: left;
            width: 80px;
            vertical-align: text-top;
        }

        .desc {
            text-align: left;
            vertical-align: text-top;
        }

        .desc p {
            margin: 0;
        }

        .glosa {
            width:100%;
            padding-bottom: 10px;
            border-bottom: 1px solid #515151;
            margin-bottom: 20px;
        }

        .glosa.oficio, .glosa.carta{
            border-bottom: 1px solid transparent!important;
        }

        .glosa.oficio .fecha {
            margin-bottom: 40px;
        }

        .glosa.oficio h1 {
            margin-bottom: 0px;
        }

        .glosa.oficio .destinatario,
        .glosa.carta .destinatario {
            margin-bottom: 40px;
            border-bottom: 1px solid transparent!important;
        }

        .glosa dl {
            display: flex;
            margin-bottom: 0;
            margin-top: 0;
        }

        .glosa dl .item {
            position: relative;
        }

        .glosa dl .desc::before {
            position: absolute;
            content: ' : ';
            left: -10px;
            top: 0;
        }

        .glosa dl .desc {
            position: relative;
            margin-left: 80px;
        }

        .dots {
            width: 10px;
            vertical-align: text-top;
        }

        .overlined {
            border-bottom: 1px solid #000000;
            border-top: 1px solid #000000;
            width: auto;
            max-width: 50%;
            white-space: normal;
        }

        .pre-footer {
            font-size: 8px !important;
            margin-top: 3rem;
        }

    </style>
</head>
<body>
<?php
if ($param['head'] === 'title'){
    include ('template/head.php');
}else{
    echo "sello de agua";
}
?>
<footer>
    <img class="footerImg" src="../../dist/images/pie.png">
</footer>
<main>
    <div class="glosa <?php echo trim(strtolower($tipoDoc));?>">
        <?php
        switch (trim($tipoDoc)) {
            case 'OFICIO':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class="overlined"><strong>Asunto:</strong> '.sliceString($Rs['cAsunto'],10).'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').$nombreRe.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef)){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            case 'OFICIO MULTIPLE':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class="overlined"><strong>Asunto: </strong> '.sliceString($Rs['cAsunto'],10).'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').$nombreRe.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef)){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            case 'CARTA':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class=""><strong>Asunto:</strong> '.sliceString($Rs['cAsunto'],10).'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').$nombreRe.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef)){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            case 'CARTA MULTIPLE':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class=""><strong>Asunto:</strong> '.sliceString($Rs['cAsunto'],10).'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').$nombreRe.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef)){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            default:
                if((RTRIM($tipoDoc) == 'MEMORANDUM' || RTRIM($tipoDoc) == 'INFORME')  && $Rs['nFlgTipoDoc'] == '3'){
                    if($Rs['iCodOficinaRegistro'] == '356'){
                        $destino = "<h2>" . $Rs['nombreResponsable'] . "</h2>".'<p>'.$nombreRe.'</p>';
                    } else {
                        $destino = "<h2>" . $Rs['nombreResponsable'] . "</h2>".'<p>' . $Rs['cargoResponsable'].'</p><p>'.$RsRemitente['cNombre'].'</p>';
                        $remite .= '<p>Agencia Peruana de Cooperación Internacional</p>';
                    }
                };
                $nomenclaturaCentro= '<h1>'.$numDoc.'</h1>';
                $tablai = '';
                $destinatario = '<dl class="destinatario"><dt class="item">A</dt><dd class="desc">'.$destino.'</dd></dl>';
                $remitente = '<dl class="remitente"><dt class="item">De</dt><dd class="desc">'.$remite.' </dd></dl>';
                $separador = '';
                $asunto = '<dl class="asunto"><dt class="item">Asunto</dt><dd class="desc">'.sliceString($Rs['cAsunto'],8).'</dd></dl>';

                if(isset($cadenaRef)){
                    $referencia = '<dl class="referencia"><dt class="item">Referencia</dt><dd class="desc">'.$cadenaRef.'</dd></dl>';
                } else {
                    $referencia = '';
                }

                $fecha='<dl class="fecha"><dt class="item">Fecha</dt><dd class="desc">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).'</dd></dl>';
                $tablaf = '';

                break;
        }
        $descripcionCuenpo = $Rs['cCuerpoDocumento'];
        $cuerpo = '</div>'.$descripcionCuenpo;

        foreach ($param['body'] as $pp){
            eval ('echo $'.$pp.';');
        }
        if($_SESSION['iCodPerfilLogin'] == '20'){
            echo '<p class="asesor">'.$RsRemitente['nombreCompleto'].'</p><br><p class="cargo">'.$RsRemitente['cargo'].'</p>';
        }
        echo '<span class="pre-footer">CUD: '.$Rs['nCud'].'</span>';
        echo ($adjuntos??'');
        ?>
</main>
</body>
</html>
    <?php

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$content = ob_get_clean();

// conversion HTML => PDF
$nuevo_nombre = str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])).'-'.str_replace('/','-',rtrim($Rs['cCodificacion'])).'.pdf';

$dompdf = new DOMPDF();
$dompdf->loadHtml($content);
$dompdf->render();
//$dompdf->stream($nuevo_nombre, array("Attachment" => false));


$output = $dompdf->output();
$separa=DIRECTORY_SEPARATOR;
$tmp = dirname(tempnam (null,''));
$tmp = $tmp.$separa."upload";

if ( !is_dir($tmp)) {
    mkdir($tmp);
}
$url_f = 'docNoFirmados/'.$nomenclatura.'/';

$_POST['path'] = $url_f;
$_POST['name'] = 'fileUpLoadDigital';

file_put_contents($tmp.$separa.$nuevo_nombre, $output);

$_FILES['fileUpLoadDigital']['tmp_name'] = $tmp.$separa.$nuevo_nombre;
$_FILES['fileUpLoadDigital']['name'] = $nuevo_nombre;
$_FILES['fileUpLoadDigital']['type'] = 'PDF';
$_POST['new_name'] = $nuevo_nombre;
$curl->uploadFile($_FILES, $_POST);
$url  = $url_srv.$url_f.$nuevo_nombre;
$curl->closeCurl();

$sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $RsUltTra['iCodTramite'] . "', '".$nuevo_nombre."', '" . $url . "', '2')";
$rsDigt = sqlsrv_query($cnx, $sqlDigt);
?>
