<?php
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;

include_once("../conexion/conexion.php");
session_start();
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

function add_ceros($numero,$ceros) {
    $insertar_ceros = 0;
    $order_diez = explode('.',$numero);
    $dif_diez = $ceros - strlen($order_diez[0]);
    for($m=0; $m<$dif_diez; $m++){
        $insertar_ceros .= 0;
    }
    return $insertar_ceros.= $numero;
}

$fFecActual = date('Ymd').' '.date('G:i:s');

$nCud = '';
if(isset($_POST['iCodMovProyecto'])){
    $rsProPro = sqlsrv_query($cnx, " SELECT nCud FROM Tra_M_Proyecto WHERE iCodProyecto = (SELECT iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = '".$_POST['iCodMovProyecto']."')");
    $RsProPro = sqlsrv_fetch_array($rsProPro);
    $nCud = $RsProPro['nCud'];
}

if(isset($_POST['iCodMovTramite'])){
    $rsProPro = sqlsrv_query($cnx, " SELECT nCud FROM Tra_M_Tramite WHERE iCodTramite = (SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = '".$_POST['iCodMovTramite']."')");

    $RsProPro = sqlsrv_fetch_array($rsProPro);
    $nCud = $RsProPro['nCud'];
}

$siglasAutor = $_POST['cSiglaAutor'];

$sqlTipDoc="SELECT dbo.Tra_M_Tipo_Documento.cCodTipoDoc, dbo.Tra_M_Tipo_Documento.cDescTipoDoc, dbo.Tra_M_Plantilla.parametros FROM dbo.Tra_M_Tipo_Documento 
            INNER JOIN dbo.Tra_M_Plantilla ON dbo.Tra_M_Plantilla.cCodTipoDoc = dbo.Tra_M_Tipo_Documento.cCodTipoDoc WHERE dbo.Tra_M_Tipo_Documento.cCodTipoDoc= '".$_POST['cCodTipoDoc']."'";
$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
$tipoDoc = TRIM($RsTipDoc['cDescTipoDoc']);

$param = eval("return ".$RsTipDoc['parametros'].";");

$rsSigla = sqlsrv_query($cnx,"SELECT cSiglaOficina FROM Tra_M_Oficinas WHERE iCodOficina='".$_POST['iCodOficinaFirmante']."'");
$RsSigla = sqlsrv_fetch_array($rsSigla);

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

$oficinajefe = $RsSigla['cSiglaOficina'];
$sqlIDjefe = "SELECT iCodOficina FROM dbo.Tra_M_Perfil_Ususario where iCodPerfil=3 and iCodOficina = (select iCodOficina  from Tra_M_Oficinas where cSiglaOficina like '$oficinajefe')";
$idJefe=sqlsrv_query($cnx,$sqlIDjefe);
$idJefe=sqlsrv_fetch_array($idJefe);

$sigla = $oficinajefe;
$oficina = $idJefe['iCodOficina'];


// REMITENTE
$sqlRemitente = "SELECT CONCAT(TRIM(trab.cNombresTrabajador),' ',TRIM(trab.cApellidosTrabajador)) AS nombreCompleto, car.descripcion AS cargo 
                     FROM Tra_M_Perfil_Ususario AS pu
                    INNER JOIN Tra_M_Trabajadores AS trab ON trab.iCodTrabajador = pu.iCodTrabajador
                    INNER JOIN Tra_M_Cargo AS car ON car.iCodCargo = pu.iCodCargo
                    WHERE pu.iCodOficina = ".$_POST['iCodOficinaFirmante']." 
                    AND pu.iCodTrabajador = ".$_POST['iCodTrabajadorFirmante']." AND pu.iCodPerfil = ".$_POST['iCodPerfilFirmante'];

$rsRemitente=sqlsrv_query($cnx,$sqlRemitente);
$RsRemitente=sqlsrv_fetch_array($rsRemitente);
$remite="<h2>" .$RsRemitente['nombreCompleto']  . "</h2> <p>".$RsRemitente['cargo'].'</p>';

// NOMBRE DE LA OFICINA EN EL HEAD
$nombreOf = "SELECT iCodOficina FROM dbo.Tra_M_Perfil_Ususario where iCodPerfil=3 and iCodOficina = (select iCodOficina  from Tra_M_Oficinas where cSiglaOficina like '".nombreHead($RsSigla['cSiglaOficina'])."')";
$rsnombreOf=sqlsrv_query($cnx,$nombreOf);
$RsnombreOf=sqlsrv_fetch_array($rsnombreOf);
$sqlofi = "select cNomOficina as oficina  from Tra_M_Oficinas where iCodOficina =".$RsnombreOf['iCodOficina'];
$qofice=sqlsrv_query($cnx,$sqlofi);
$siglaoficina=sqlsrv_fetch_array($qofice);
$words = array('Y', 'De','E');
$regex = '/\b(' . implode( '|', $words) . ')\b/i';
$formatted_tag = preg_replace_callback( $regex, function( $matches) {
    return strtolower( $matches[1]);
}, ucwords(mb_strtolower(trim($siglaoficina['oficina']))));
$oooo = sliceString($formatted_tag,3);

// NUMERO DEL DOCUMENTO
$numDoc = $tipoDoc.' N° &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -'.date('Y').'-APCI/'.TRIM($sigla);
if($tipoDoc == 'NOTA INFORMATIVA'){
    $numDoc .= '/'.$siglasAutor;
}
if($tipoDoc == 'NOTA DIPLOMATICA'){
    $numDoc = 'NOTA RE (APC) Nro. &nbsp;&nbsp;';
}

if($tipoDoc == 'NOTA CIRCULAR'){
    $numDoc = 'NOTA CIRCULAR RE (APC) Nro. &nbsp;&nbsp;';
}

// FECHA DEL DOCUMENTO
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
$fecha = date('Ymd').' '.date('G:i:s');

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

$destinatarios = [];
if(sqlsrv_has_rows($rs)){ 
    while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
        $destinatarios[]=$row;
    }
}

if($_POST['nFlgTipoDoc'] == '2') {
    //DESTINATARIOS
    $destino = '';
    $conCopia = '';
    // $destinatarios = json_decode($_POST['destinatarios']);
    for($j = 0; $j < count($destinatarios); $j ++){
        $dest = $destinatarios[$j];
        if($dest['cCopia'] == '0'){
            $sqlCarg = "SELECT CAR.descripcion
                    FROM Tra_M_Perfil_Ususario PER
                    LEFT JOIN Tra_M_Cargo CAR ON PER.iCodCargo = CAR.iCodCargo
                    WHERE iCodOficina = ".$dest['icodOficina']." AND iCodTrabajador = ".$dest['icodResponsable']." AND iCodPerfil = ".$dest['iCodPerfil'];
            $rsCAR = sqlsrv_query($cnx,$sqlCarg);
            $RsCar=sqlsrv_fetch_array($rsCAR);
            $cargo = $RsCar['descripcion'];

            $destino .= "<h2>" .$dest['nomResponsable']."</h2>".'<p>' . $cargo . '</p>';
        } else {
            $siglaoficinaCopia = explode(' | ',$dest['nomOficina']);
            if($conCopia === ''){
                $conCopia .= $siglaoficinaCopia[0];
            } else {
                $conCopia .= ', '.$siglaoficinaCopia[0];
            }
        }
    }
} else {
    $conCopia = '';
    // $destinatarioExt = json_decode($_POST['destinatarios'],true);
    // $destinatarioExt = $destinatarioExt[0];

    
    foreach($destinatarios as $i => $e){
        if($e['iCodRemitente'] == $_POST['destinatario']){
            $destinatarioExt = $e;
        }
    }

    if ($_POST['cCodTipoDoc'] !== '13' && $_POST['cCodTipoDoc'] !== '41'){
        $datosSede = explode(' | ',$destinatarioExt['cDireccion']);
        $direccion = $datosSede[0].'<br>';
        $pais = $datosSede[1] ?? '';
        $ubigeoText = $datosSede[2] ?? '';
        if(trim($ubigeoText) == ''){            
            $ubigeoText = $pais;
        }

        if ($destinatarioExt['flgMostrarDireccion'] == '0'){
            $ubigeoText = 'Presente.-';
            $direccion = '<br>';
        }
        $ubigeo = '<span style="text-decoration: underline">'.($ubigeoText??'').'</span>';

        $nombreRe = $destinatarioExt['nomRemitente'];
    } else {
        //DESTINO EXTERNO
        $sqlRemitente = "SELECT NombreEntMRE AS cNombre, CodigoMRE, '' AS cDireccion FROM Tra_M_Entidad_MRE WITH (NOLOCK) WHERE IdEntidadMRE = " .$destinatarioExt['iCodRemitente'];
        $rsRemitente = sqlsrv_query($cnx, $sqlRemitente);
        $RsRemitente = sqlsrv_fetch_array($rsRemitente);

        $ubigeo = '<span style="text-decoration: underline">Lima.-</span>';
        $direccion = '';

        $nombreRe = $RsRemitente['cNombre'].'<br>';
    }

    // DESTINO
    if($destinatarioExt['preFijo'] !== ''){
        $persona = $destinatarioExt['preFijo'].'<br>';
    } else {
        $persona = 'Señor(a)<br>';
    }

    $destinoi = '<p class="destinatario">';
    if($destinatarioExt['nombreResponsable'] !== ''){
        $responsable  = '<strong>'.$destinatarioExt['nombreResponsable'].'</strong><br>';
    }
    if($destinatarioExt['cargoResponsable'] !== ''){
        $cargo  = $destinatarioExt['cargoResponsable'].'<br>';
    }

    $destinof = '</p>';
}

//REFERENCIAS SI EXISTEN
if(isset($_POST['cReferencia']) && $_POST['cReferencia'] !== null && $_POST['cReferencia'] !== '' ) {
    $referenciasCods = json_decode($_POST['cReferencia'], true);
    $cadenaRef = '';
    for ($i = 0; $i < count($referenciasCods); $i++){
        $ref = $referenciasCods[$i]['iCodTramiteRef'];
        $sqlreferencias = "select 
                                CASE
                                WHEN tra.cNroDocumento IS NOT NULL
                                    THEN CONCAT(RTRIM(tipo.cDescTipoDoc),' ',RTRIM(tra.cNroDocumento))
                                ELSE
                                    CONCAT(RTRIM(tipo.cDescTipoDoc),' ',RTRIM(tra.cCodificacion))
                            END AS referencia
                            from  Tra_M_Tramite AS tra 
                            LEFT OUTER JOIN Tra_M_Tipo_Documento AS tipo ON tipo.cCodTipoDoc = tra.cCodTipoDoc
                            where iCodTramite = ".$ref;
        $referencias=sqlsrv_query($cnx,$sqlreferencias);
        if(sqlsrv_has_rows($referencias)){
            $ref=sqlsrv_fetch_array($referencias);
            $cadenaRef .= trim($ref['referencia']). ' <br>';
        }
    }
}

// LISTA LOS ADJUNTOS
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
            $addAnex.= '<li>'.$nuevoNom.'</li>';
        } else {
            $addAnex.= '<li>'.trim($RsdatosAnex['cNombreOriginal']).'</li>';
        }
    }
}
if(isset($addAnex)){
    $adjuntos = $addAnex;
}
    ?>
    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>SITDD</title>
        <?php include_once("template/styles.php"); ?>
    </head>
    <body class="<?php echo trim(strtolower($tipoDoc));?>">
        <?php if ($param['head'] === 'title'){ ?>
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
                                <?php echo '"Decenio de la Igualdad de Oportunidades para mujeres y hombres"';?>
                                <br>
                                <?php echo '"Año del Bicentenario, de la consolidación de nuestra Independencia y de la Conmemoración de las heroicas batallas de Junín y Ayacucho"'?>
                                <br>
                                <?php echo ''?>
                            </p>
                        </td>
                    </tr>
                </table>
            </header>            
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
        <?php } else{ ?>

        <?php } ?>
    <footer>
        <?php
            if(trim($tipoDoc) !== 'NOTA DIPLOMATICA' && trim($tipoDoc) !== 'RESOLUCION DIRECTORAL' && trim($tipoDoc) !== 'NOTA CIRCULAR') {
                ?>
                    <img class="footerImg" src="../dist/images/pie.png">
                <?php
            }
        ?>
    </footer>
    <main class="<?php echo trim(strtolower($tipoDoc));?>">
        <div class="glosa <?php echo trim(strtolower($tipoDoc));?>">
            <?php
                switch (trim($tipoDoc)) {
                    case 'OFICIO':
                        $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                        $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                        $asunto = '<p class="overlined"><strong>Asunto:</strong> '.$_POST['cAsunto'].'</p>';
                        $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').' '.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;
                        if(isset($cadenaRef)){
                            $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                        }else {
                            $referencia = '';
                        }

                        break;

                    case 'OFICIO MULTIPLE':
                        $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                        $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                        $asunto = '<p class="overlined"><strong>Asunto:</strong> '.$_POST['cAsunto'].'</p>';
                        $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').' '.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                        if(isset($cadenaRef)){
                            $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                        }else {
                            $referencia = '';
                        }

                        break;
                    
                    case 'CARTA':
                        $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                        $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                        $asunto = '<p class=""><strong>Asunto:</strong> '.$_POST['cAsunto'].'</p>';
                        $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').' '.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                        if(isset($cadenaRef) && $cadenaRef != ''){
                            $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                        } else {
                            $referencia = '';
                        }
                        break;

                    case 'CARTA MULTIPLE':
                        $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                        $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                        $asunto = '<p class=""><strong>Asunto:</strong> '.$_POST['cAsunto'].'</p>';
                        $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').' '.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                        if(isset($cadenaRef)){
                            $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                        } else {
                            $referencia = '';
                        }

                        break;

                    case 'CARTA CIRCULAR':
                        $fecha='<p class="fecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                        $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.'</h1>';
                        $asunto = '<p class=""><strong>Asunto:</strong> '.$_POST['cAsunto'].'</p>';
                        $destinatario = $destinoi.$persona.($responsable??'').($cargo??'').' '.$nombreRe.'<br>'.($direccion??'').($ubigeo??'').$destinof;

                        if(isset($cadenaRef)){
                            $referencia = '<p><strong>Referencia</strong>: '.$cadenaRef.'</p>';
                        } else {
                            $referencia = '';
                        }

                        break;

                    case 'NOTA DIPLOMATICA':
                        $fecha='<p class="fecha fechaDerecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                        $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.' '.$RsRemitente['CodigoMRE'].'</h1>';
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
                                                .$_POST['cAsunto'].'
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
                                                    '.$destinatarioExt['nroDocumento'].'
                                                </td>
                                            </tr>
                                        </table>';
                        break;
                    case 'NOTA CIRCULAR':
                        $fecha='<p class="fecha fechaDerecha">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </p>';
                        $nomenclaturaCentro= '<h1 class="left-align no-underline">'.$numDoc.' </h1>';
                        break;  
                    default:
                        if((RTRIM($tipoDoc) == 'MEMORANDUM' || RTRIM($tipoDoc) == 'INFORME')  && $_POST['nFlgTipoDoc'] == '3'){
                            $destino = $destinoi.'<span class="upperCase">'.($responsable??'').'</span>'.($cargo??'').' '.$nombreRe.'<br>'.$destinof;
                            $remite .= '<p>AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL</p>';
                        };

                        $nomenclaturaCentro= '<h1>'.$numDoc.'</h1>';
                        $tablai = '';

                        $destinatario = '<dl class="destinatario"><dt class="item">A</dt><dd class="desc">'.$destino.'</dd></dl>';

                        $remitente = '<dl class="remitente"><dt class="item">De</dt><dd class="desc">'.$remite.' </dd></dl>';
                        $separador = '';
                        $asunto = '<dl class="asunto"><dt class="item">Asunto</dt><dd class="desc">'.$_POST['cAsunto'].'</dd></dl>';

                        if(isset($cadenaRef)){
                            $referencia = '<dl class="referencia"><dt class="item">Referencia</dt><dd class="desc">'.$cadenaRef.'</dd></dl>';
                        } else {
                            $referencia = '';
                        }

                        $fecha='<dl class="fecha"><dt class="item">Fecha</dt><dd class="desc">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).'</dd></dl>';
                        $tablaf = '';

                        break;
                }

            $descripcionCuerpo = $_POST['cCuerpoDocumento'];

            $cuerpo = '</div><div>'.$descripcionCuerpo.'</div>';

            foreach ($param['body'] as $pp){
                eval ('echo $'.$pp.';');
            }

    //echo '<pre>';
    //var_dump($conCopia);
    //var_dump($adjuntos);
    //var_dump($nCud);
    //echo '</pre>';
            if($_SESSION['flgDelegacion'] == 1 && $_SESSION['iCodOficinaLogin'] == 356){
                echo '
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
            } else if ($tipoDoc == 'RESOLUCION DIRECTORAL') { 
                echo '
                    <table style="width: 100%;">
                        <tr>
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
            } else {
                echo '
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
            }

            echo '<p class="pre-footer footer-info">';
            if (trim($tipoDoc) == 'NOTA DIPLOMATICA' || trim($tipoDoc) == 'NOTA CIRCULAR'){
                echo '<span>A la Honorable</span>';
                echo '<span style="padding-top: 0;">'.$RsRemitente['cNombre'].'</span>';
                echo '<span style="padding-top: 0;">Lima.-</span>';
            }
            echo ($adjuntos !== "") ? "<span>Adjuntos. <ol>" . $adjuntos . "</ol></span>" : "";
            echo ($conCopia !== "") ? "<span>Cc. " . $conCopia . "</span>" : "";
            echo ($nCud !== '') ? '<span class="cud">CUD. ' . $nCud . '</span>' : '<span class="cud">CUD. -'. date("Y") .'</span>';
            echo '<span class="siglas">'.$siglasAutor.'</span>';
            echo '</p>';
            ?>
    </main>
    </body>
    </html>
    <?php

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$content = ob_get_clean();

//print_r($content);die();

// conversion HTML => PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->render();

// $dompdf->stream("mypdf.pdf", [ "Attachment" => false]);

$output = $dompdf->output();

$b64Doc = chunk_split(base64_encode($output));
echo $b64Doc;
?>