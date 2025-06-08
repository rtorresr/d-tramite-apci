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

$numDoc = $dataFirma['descDoc'].' N° '.$dataFirma['cCodificacion'];
if (trim($dataFirma['descDoc']) == 'NOTA DIPLOMATICA'){
    $numDoc = 'NOTA '.$dataFirma['cCodificacion'];
}

if (trim($dataFirma['descDoc']) == 'NOTA CIRCULAR'){
    $numDoc = 'NOTA CIRCULAR '.$dataFirma['cCodificacion'];
}

$param = eval("return ".$dataFirma['plantillaParametros'].";");

//DETERMINAMOS CABECERA DEL DOCUMENTO
//DETERMINA EL PADRE SI ES SUBDIRECCION
$sqlofi = "select cSiglaOficina as sigla  from Tra_M_Oficinas where iCodOficina =".$dataFirma['iCodOficinaFirmante'];
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


$cargo='';
$responsable='';
if($dataFirma['nFlgTipoDoc'] == '2') {
    // $destinatariosInternos = json_decode($dataFirma['destinatarios'],true);
    $destinatariosInternos = $destinatarios;
    $destino = '';
    $conCopia = '';
    foreach ($destinatariosInternos AS $key => $value){
        if ($value['cCopia'] == '0'){
            $sqlDestinos = "SELECT car.descripcion AS cargo 
                  FROM Tra_M_Perfil_Ususario AS pu 
                  INNER JOIN Tra_M_Cargo AS car ON car.iCodCargo =  pu.iCodCargo
                  WHERE iCodPerfil = ".$value['iCodPerfil']." AND iCodOficina = ".$value['icodOficina']." AND iCodTrabajador = ".$value['icodResponsable'];
            $rsDestinos=sqlsrv_query($cnx,$sqlDestinos);
            $RsDestinos=sqlsrv_fetch_array($rsDestinos);
            if ($value['nomResponsable'] != '') {
                $cargo = $RsDestinos['cargo'];
                $destino .= "<h2>" . $value['nomResponsable'] . "</h2>".'<p>' . $cargo . '</p>';
            }
        } else {
            $siglaoficinaCopia = explode(' | ',$value['nomOficina']);
            if($conCopia === ''){
                $conCopia .= $siglaoficinaCopia[0];
            } else {
                $conCopia .= ', '.$siglaoficinaCopia[0];
            }
        }
    }
} else {
    $conCopia = '';
    // $destinatariosExternos = json_decode($dataFirma['destinatarios'],true);
    // $destinatariosExternos = $destinatariosExternos[0];

    $destinatariosExternos = $destinoExterno;

    if (trim($dataFirma['descDoc']) == 'NOTA DIPLOMATICA' || trim($dataFirma['descDoc']) == 'NOTA CIRCULAR'){
        //DESTINO EXTERNO
        $sqlRemitente = "SELECT NombreEntMRE AS cNombre, CodigoMRE, '' AS cDireccion FROM Tra_M_Entidad_MRE WITH (NOLOCK) WHERE IdEntidadMRE = " .$destinatariosExternos['iCodRemitente'];
        $rsRemitente = sqlsrv_query($cnx, $sqlRemitente);
        $RsRemitente = sqlsrv_fetch_array($rsRemitente);

        $ubigeo = '<span style="text-decoration: underline">Lima.-</span>';
        $direccion = '';

        $nombreRe = $RsRemitente['cNombre'];
    } else {
        if(($destinatariosExternos['flgRequiereDireccion'] ?? 1) == 1){
            $datosSede = explode(' | ',$destinatariosExternos['cDireccion']);
            $direccion = $datosSede[0].'<br>';
            $pais = $datosSede[1];
            $ubigeoText = $datosSede[2];
            if(trim($ubigeoText) == ''){            
                $ubigeoText = $pais;
            }
            if ($destinatariosExternos['flgMostrarDireccion'] == '0'){
                $ubigeoText = 'Presente.-';
                $direccion = '<br>';
            }
        } else {
            $ubigeoText = '';
            $direccion = '<br>';
        }
        
        $ubigeo = '<span style="text-decoration: underline">'.($ubigeoText??'').'</span>';

        $nombreRe = $destinatariosExternos['nomRemitente'];
    }

    // DESTINO
    if($destinatariosExternos['preFijo'] !== ''){
        $persona = $destinatariosExternos['preFijo'].'<br>';
    } else {
        $persona = 'Señor(a)<br>';
    }

    $destinoi = '<p class="destinatario">';
    if($destinatariosExternos['nombreResponsable'] !== ''){
        $responsable  = '<strong>'.$destinatariosExternos['nombreResponsable'].'</strong><br>';
    }
    if($destinatariosExternos['cargoResponsable'] !== ''){
        $cargo  = $destinatariosExternos['cargoResponsable']/*.'<br>'*/;
    }

    $destinof = '</p>';
}
$sqlRemitente = "SELECT CONCAT(TRIM(trab.cNombresTrabajador),' ',TRIM(trab.cApellidosTrabajador)) AS nombreCompleto, car.descripcion AS cargo 
                     FROM Tra_M_Perfil_Ususario AS pu
                    INNER JOIN Tra_M_Trabajadores AS trab ON trab.iCodTrabajador = pu.iCodTrabajador
                    INNER JOIN Tra_M_Cargo AS car ON car.iCodCargo = pu.iCodCargo
                    WHERE pu.iCodOficina = ".$dataFirma['iCodOficinaFirmante']." 
                    AND pu.iCodTrabajador = ".$dataFirma['iCodTrabajadorFirmante']." AND pu.iCodPerfil = ".$dataFirma['iCodPerfilFirmante'];

$rsRemitente=sqlsrv_query($cnx,$sqlRemitente);
$RsRemitente=sqlsrv_fetch_array($rsRemitente);
$remite="<h2>" .$RsRemitente['nombreCompleto']  . "</h2> <p>".$RsRemitente['cargo'].'</p>';

setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
$fecha = date('m/d/Y');

//REFERENCIAS
$cadenaRef = '';
if($dataFirma['cReferencia'] !== null){
    $cReferencias = json_decode($dataFirma['cReferencia'],true);    
    foreach ($cReferencias AS $key => $value){
        $sqlreferencias = "SELECT 
                            CASE
                                WHEN tra.cNroDocumento IS NOT NULL
                                    THEN CONCAT(RTRIM(tipo.cDescTipoDoc),' N° ',RTRIM(tra.cNroDocumento))
                                ELSE
                                    CONCAT(RTRIM(tipo.cDescTipoDoc),' N° ',RTRIM(tra.cCodificacion))
                            END AS referencia
                            FROM Tra_M_Tramite AS tra
                            LEFT OUTER JOIN Tra_M_Tipo_Documento AS tipo ON tipo.cCodTipoDoc = tra.cCodTipoDoc
                            WHERE tra.iCodTramite = '".$value['iCodTramiteRef']."'";
        $referencias=sqlsrv_query($cnx,$sqlreferencias);
        $ref=sqlsrv_fetch_array($referencias);
        $cadenaRef .= trim($ref['referencia']). ' <br>';
    }
}

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
            $addAnex.= '<li>'.$nuevoNom.'</li>';
        } else {
            $addAnex.= '<li>'.trim($RsAnexos['cNombreOriginal']).'</li>';
        }
    }
    $adjuntos = $addAnex;
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

    $rutaRedirect = $_SERVER['HTTP_HOST'] . '/verifica.php?cud='.$dataFirma['nCud'].'&clave='.$dataFirma['clave'];
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
?>
<?php } else if ($param['head'] === 'resolucion'){ ?>
    <header style="top: 3cm;">
        <table>
            <tr >
                <td class="center" style="width:620px;">
                    <img width="150" src="../dist/images/escudo-resoluciones.png">
                </td>
            </tr>
        </table>
    </header>
<?php } else if ($param['head'] === 'resolucioncoactiva'){ ?>
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
        </table>                
    </header>
<?php
    }else{
        echo "";
    }
?>

<footer>
    <?php
    if(trim($dataFirma['descDoc']) !== 'NOTA DIPLOMATICA' && trim($dataFirma['descDoc']) !== 'NOTA CIRCULAR'){
    ?>
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
    <?php
        }
    }
    ?>
</footer>
<main>
    <div class="glosa <?php echo trim(strtolower($dataFirma['descDoc']));?>">
        <?php
        switch (trim($dataFirma['descDoc'])) {
            case 'OFICIO':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class="overlined"><strong>Asunto:</strong> '.$dataFirma['cAsunto'].'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').'<br>'.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef) && $cadenaRef != ''){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            case 'OFICIO MULTIPLE':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class="overlined"><strong>Asunto: </strong> '.$dataFirma['cAsunto'].'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').'<br>'.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef) && $cadenaRef != ''){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            case 'CARTA':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class=""><strong>Asunto:</strong> '.$dataFirma['cAsunto'].'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').'<br>'.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef) && $cadenaRef != ''){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            case 'CARTA MULTIPLE':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class=""><strong>Asunto:</strong> '.$dataFirma['cAsunto'].'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').' '.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef) && $cadenaRef != ''){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;
            case 'RESOLUCION DIRECTORAL':
                $fecha='<p class="fecha fechaDerecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="no-underline">'.$numDoc.'</h1>';
                break;
            case 'RESOLUCION COACTIVA':                        
                $destinatario= '<table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
                                    <tr>
                                        <td class="left" style="width:120px; border: 1px solid black; border-collapse: collapse;">                           
                                        EXPEDIENTE
                                        </td>
                                        <td class="left" style="width:10px;text-align:center; border: 1px solid black; border-collapse: collapse;">
                                        :
                                        </td>
                                        <td class="left" style="border: 1px solid black; border-collapse: collapse;">'
                                        .$dataFirma['cAsunto'].'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left" style="width:120px; border: 1px solid black; border-collapse: collapse;">                           
                                        MATERIA
                                        </td>
                                        <td class="left" style="width:10px;text-align:center; border: 1px solid black; border-collapse: collapse;">
                                        :
                                        </td>
                                        <td class="left" style="border: 1px solid black; border-collapse: collapse;">                           
                                            PROCEDIMIENTO DE EJECUCIÓN COACTIVA
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left" style="width:120px; border: 1px solid black; border-collapse: collapse;">                           
                                        EJECUTANTE
                                        </td>
                                        <td class="left" style="width:10px;text-align:center; border: 1px solid black; border-collapse: collapse;">
                                        :
                                        </td>
                                        <td class="left" style="border: 1px solid black; border-collapse: collapse;">                           
                                            AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL - APCI
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left" style="width:120px; border: 1px solid black; border-collapse: collapse;">                           
                                        OBLIGADO
                                        </td>
                                        <td class="left" style="width:10px;text-align:center; border: 1px solid black; border-collapse: collapse;">
                                        :
                                        </td>
                                        <td class="left" style="border: 1px solid black; border-collapse: collapse;">                           
                                            '.$nombreRe.'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left" style="width:120px; border: 1px solid black; border-collapse: collapse;">                           
                                        RUC
                                        </td>
                                        <td class="left" style="width:10px;text-align:center; border: 1px solid black; border-collapse: collapse;">
                                        :
                                        </td>
                                        <td class="left" style="border: 1px solid black; border-collapse: collapse;">                           
                                            '.$destinatariosExternos['nroDocumento'].'
                                        </td>
                                    </tr>
                                </table>';
                break;
            case 'CARTA CIRCULAR':
                $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                $asunto = '<p class=""><strong>Asunto:</strong> '.$dataFirma['cAsunto'].'</p>';
                $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').' '.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                if(isset($cadenaRef) && $cadenaRef != ''){
                    $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                } else {
                    $referencia = '';
                }
                break;

            case 'NOTA DIPLOMATICA':
                $fecha='<p class="fecha fechaDerecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                break;
        
            case 'NOTA CIRCULAR':
                $fecha='<p class="fecha fechaDerecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                break;

            default:
                if((RTRIM($dataFirma['descDoc']) == 'MEMORANDUM' || RTRIM($dataFirma['descDoc']) == 'INFORME')  && $dataFirma['nFlgTipoDoc'] == '3'){
                    $destino = $destinoi.'<span class="upperCase">'.($responsable??'').'</span>'.($cargo??'').' '.$nombreRe.'<br>'.$destinof;
                    $remite .= '<p>AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL</p>';
                };
                $nomenclaturaCentro= '<h1>'.$numDoc.'</h1>';
                $tablai = '';
                $destinatario = '<dl class="destinatario"><dt class="item">A</dt><dd class="desc">'.$destino.'</dd></dl>';

                $remitente = '<dl class="remitente"><dt class="item">De</dt><dd class="desc">'.$remite.' </dd></dl>';
                $separador = '';
                $asunto = '<dl class="asunto"><dt class="item">Asunto</dt><dd class="desc">'.$dataFirma['cAsunto'].'</dd></dl>';

                if(isset($cadenaRef) && $cadenaRef != ''){
                    $referencia = '<dl class="referencia"><dt class="item">Referencia</dt><dd class="desc">'.$cadenaRef.'</dd></dl>';
                } else {
                    $referencia = '';
                }

                $fecha='<dl class="fecha"><dt class="item">Fecha</dt><dd class="desc">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).'</dd></dl>';
                //$fecha='<dl class="fecha"><dt class="item">Fecha</dt><dd class="desc">Miraflores, 21 de octubre del 2019</dd></dl>';
                $tablaf = '';

                break;
        }
        $descripcionCuenpo = $dataFirma['cCuerpoDocumento'];
        $cuerpo = '</div>'.$descripcionCuenpo;


        foreach ($param['body'] as $pp){
            eval ('echo $'.$pp.';');
        }

        if (isset($flgSegundoPdf)){
            if($_SESSION['flgDelegacion'] == 1 && $_SESSION['iCodOficinaLogin'] == 356){
                echo '
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
                echo '
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

        echo '<p class="pre-footer footer-info">';
        if (RTRIM($dataFirma['descDoc']) == 'NOTA DIPLOMATICA' || RTRIM($dataFirma['descDoc']) == 'NOTA CIRCULAR'){
            echo '<span>A la Honorable</span>';
            echo '<span style="padding-top: 0;">'.$nombreRe.'</span>';
            echo '<span style="padding-top: 0;">Lima.-</span>';
        }
            echo ($adjuntos !== "") ? "<span>Adjuntos. <ol>" . $adjuntos . "</ol></span>" : "";
            echo ($conCopia !== "") ? "<span>Cc. " . $conCopia . "</span>" : "";
            echo ($dataFirma['nCud'] !== NULL) ? '<span class="cud">CUD. ' . $dataFirma['nCud'] . '</span>' : '<span class="cud">CUD. -'. date("Y") .'</span>';
            echo '<span class="siglas">'.$dataFirma['cSiglaAutor'].'</span>';
        echo '</p>';
        ?>
</main>
</body>
</html>
    <?php


$content = ob_get_clean();

$nuevo_nombre = DocDigital::formatearNombre(str_replace(' ','-',trim($dataFirma['descDoc'])).'-'.str_replace('/','-',rtrim($dataFirma['cCodificacion'])),false,[' ']).'.pdf';
$nuevo_nombre = $dataFirma['iCodTramite'].'-'.$destinoExterno['iCodRemitente'].'-'.$nuevo_nombre;

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

$docDigital->idTramite = $dataFirma['iCodTramite'];
$docDigital->idEntidad = $destinoExterno['iCodRemitente'];
$docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
$docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];

$docDigital->subirDocumento();

if (!isset($flgSegundoPdf)){
    $ruta = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
}

?>