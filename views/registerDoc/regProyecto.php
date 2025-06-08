<?php
include_once("../../conexion/conexion.php");

session_start();
date_default_timezone_set('America/Lima');

$fFecActual = date('Ymd');
$nNumAno = date('Y');
$nNumMes = date('M');

//SI EXISTEN ARCHIVOS POR SUBIR
if (isset($_FILES['fileUpLoadDigital']) && ($_FILES['fileUpLoadDigital']['tmp_name'][0] !== '')) {
    $archivos = $_FILES['fileUpLoadDigital'];
}

$i_agrupadoTemp = $_POST['agrupadoTemp']??0;

// si es una respyesta existen
$i_codMovimiento = $_POST['iCodMov']??0;
$i_codMovimientosRespondidos = $_POST['iCodMovRespondidos']??'';
$i_nCud = $_POST['nCud']??'';
$i_iCodTramiteRespuesta = $_POST['iCodTramite']??0;

$nFlgTipoDoc =  $_POST["cCodTipoTra"];
$i_cCodTipoDoc =   $_POST['cCodTipoDoc'];
$i_iCodTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
$i_iCodOficinaLogin = $_SESSION['iCodOficinaLogin'];
$i_cAsunto =  $_POST['cAsunto'];
$i_cObservaciones =$_POST['cObservaciones']??'';
$i_cCuerpoDocumento = $_POST['editorOficina'];

if(isset($_POST['cReferencia'])){
    $cReferencia = [];
    foreach ($_POST['cReferencia'] as $key => $value) {
        $cReferencia[$key]['iCodTramiteRef'] = $value;
    }
    $i_cReferencia =  json_encode($cReferencia);
} else {
    $i_cReferencia = null;
}

if(isset($_POST['cAnexos'])){
    $cAnexos = [];
    foreach ($_POST['cAnexos'] as $key => $value) {
        $cAnexos[$key]['iCodDigital'] = $value;
    }
    $i_cAnexos =  json_encode($cAnexos);
} else {
    $i_cAnexos = null;
}

if(isset($_POST['cAnexosImprimibles'])){
    $cAnexosImprimibles = [];
    foreach ($_POST['cAnexosImprimibles'] as $key => $value) {
        $cAnexosImprimibles[$key]['iCodDigital'] = $value;
    }
    $i_cAnexosImprimibles =  json_encode($cAnexosImprimibles);
} else {
    $i_cAnexosImprimibles = null;
}

//por mientras
if ($_POST['fFecPlazo'] !== '') {
    $tiempoPlazo =  round((strtotime($_POST['fFecPlazo']) -  strtotime ($fFecActual)) / (60 * 60 * 24));
} else {
    $tiempoPlazo = 30;
}
$i_flgSigo = $_POST['flgSigo']??0;
$i_flgEncriptado = $_POST['flgEncriptado']??0;

$i_destinos = isset($_POST['DataDestinatario']) ? json_encode($_POST['DataDestinatario']) : '';

$i_cAgrupado = $_POST['cDocumentosEnTramite'];
//$i_iCodProyecto = null ;
if($_POST['iCodOficinaFirma'] === ''){
    $i_iCodOficinaFirmante = $_SESSION['iCodOficinaLogin'];
    $i_iCodTrabajadorFirmante = $_SESSION['CODIGO_TRABAJADOR'];
    $i_iCodPerfilFirmante = $_SESSION['iCodPerfilLogin'];
} else {
    $i_iCodOficinaFirmante = $_POST['iCodOficinaFirma'];
    $i_iCodTrabajadorFirmante = $_POST['iCodTrabajadorFirma'];
    $i_iCodPerfilFirmante = $_POST['iCodPerfilFirma'];
}

/*$i_DatosDespacho = json_encode(
    array(
        "IdTipoEnvio" => $_POST['IdTipoEnvio']??0,
        "ObservacionesDespacho" => $_POST['ObservacionesDespacho']??'',
        "DireccionDespacho" => $_POST['DireccionDespacho']??'',
        "DepartamentoDespacho" => $_POST['DepartamentoDespacho']??'',
        "ProvinciaDespacho" => $_POST['ProvinciaDespacho']??'',
        "DistritoDespacho" => $_POST['DistritoDespacho']??''
    )
);*/

if($i_destinos != '' && $i_destinos != null){
    $i_DatosDespacho = NULL;

    $params = array(
        $i_agrupadoTemp,
        $i_codMovimiento,
        $i_codMovimientosRespondidos,
        $i_nCud,
        $nFlgTipoDoc,
        $i_cCodTipoDoc,
        $i_iCodTrabajador,
        $i_iCodOficinaLogin,
        $i_cAsunto,
        $i_cObservaciones,
        $i_cCuerpoDocumento,
        $i_cReferencia,
        $i_cAnexos,
        $i_cAnexosImprimibles,
        $tiempoPlazo,
        $i_flgSigo,
        $i_iCodTramiteRespuesta,
        // $i_destinos,
        NULL,
        $i_cAgrupado,
        $i_iCodOficinaFirmante,
        $i_iCodTrabajadorFirmante,
        $i_iCodPerfilFirmante,
        // $i_DatosDespacho,
        NULL,
        $i_flgEncriptado        
    );

    $sqlAdd = "{call SP_DOC_ENTRADA_INTERNO_PROYECTO_INSERT (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
    $rs = sqlsrv_query($cnx, $sqlAdd, $params);
    if($rs === false) {
        echo "No se Pudo Registrar el Proyecto";
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    } else {
        while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
            $cAgrupado = $row['cAgrupado'];
            $iCodProyecto = $row['iCodProyecto'];
        }
    }

    foreach (json_decode($i_destinos) as $key => $value) {
        if($value->id == 0){
            if ($value->IdSede == 'null' || $value->IdSede == '' ){
                $value->IdSede = NULL;
            }
            $params = array(
                $iCodProyecto,
                $value->icodOficina ?? NULL,
                $value->icodResponsable ?? NULL,
                $value->iCodPerfil ?? NULL,

                $value->iCodRemitente ?? NULL,
                $value->flgMostrarDireccion ?? NULL,
                $value->IdSede ?? NULL,
                $value->cDireccion ?? NULL,
                
                $value->preFijo ?? NULL,
                $value->nombreResponsable ?? NULL,
                $value->cargoResponsable ?? NULL,

                $value->idTipoEnvio ?? NULL,
                $value->unidadOrganicaDstIOT ?? NULL,
                $value->personaDstIOT ?? NULL,
                $value->cargoPersonaDstIOT ?? NULL,
                $value->observacionesDespacho ?? NULL,
                $value->foliosDespacho ?? NULL,
                $value->idPersonaExterna ?? NULL,

                $value->cCopia ?? NULL,

                $_SESSION['IdSesion']
            );

            $sqlAdd = "{call SP_PROYECTO_DESTINO_INSERTAR (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sqlAdd, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
        }
    }

    echo $cAgrupado;
}
?>