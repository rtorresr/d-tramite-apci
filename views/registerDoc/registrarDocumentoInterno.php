<?php
/**
 * Created by PhpStorm.
 * User: anthonywainer
 * Date: 15/11/2018
 * Time: 14:48
 */
include_once("../../conexion/conexion.php");
//include('../../core/SFTPConnection.php');
//include_once("../../conexion/conexionSSH.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../../core/CURLConection.php");

session_start();
date_default_timezone_set('America/Lima');
//print_r($_REQUEST); exit();

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    $fFecActual = date('Ymd').' '.date('G:i:s');

    $nNumAno    = date('Y');
    $nNumMes    = date('M');

function add_ceros($numero,$ceros) {
    $insertar_ceros = 0;
    $order_diez = explode('.',$numero);
    $dif_diez = $ceros - strlen($order_diez[0]);
    for($m=0; $m<$dif_diez; $m++){
        $insertar_ceros .= 0;
    }
    return $insertar_ceros.= $numero;
}

if($_POST['fFecPlazo']!==''){
    $separado2=explode('-',$_POST['fFecPlazo']);
    $fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
}else{
    $fFecPlazo='null';
}
// comprobar o recoger correlativo
$sqlCorr = "SELECT * FROM Tra_M_Correlativo_Trabajador WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."' AND iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' AND nNumAno='".$nNumAno."'";
$rsCorr = sqlsrv_query($cnx,$sqlCorr);
if(sqlsrv_has_rows($rsCorr)>0){
    $RsCorr = sqlsrv_fetch_array($rsCorr);
    $nCorrelativo=$RsCorr['nCorrelativo'] + 1;

    $sqlUpd = "UPDATE Tra_M_Correlativo_Trabajador  SET nCorrelativo='".$nCorrelativo."' WHERE iCodCorrelTrabajador='".$RsCorr['iCodCorrelTrabajador']."'";
    $rsUpd = sqlsrv_query($cnx,$sqlUpd);
}else{
    $sqlAdCorr = "INSERT INTO Tra_M_Correlativo_Trabajador (cCodTipoDoc, iCodTrabajador, nNumAno, nCorrelativo) VALUES ('".$_POST['cCodTipoDoc']."', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$nNumAno."',1)";
    $rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
    $nCorrelativo=1;
}

//leer sigla oficina
$sqlNomOfi="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'";
$RsSigla=sqlsrv_query($cnx,$sqlNomOfi);
$RsSigla=sqlsrv_fetch_array($RsSigla);


//leer user Trabajador
$sqlNomUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
$rsNomUsr=sqlsrv_query($cnx,$sqlNomUsr);
$RsNomUsr=sqlsrv_fetch_array($rsNomUsr);

//Siglas del Trabajador
$siglaN = explode(' ',$RsNomUsr['cNombresTrabajador']);
$countSiglaN = count($siglaN);
$nx='';
for($i = 0; $i < $countSiglaN; $i++){
    $n[$i]= $siglaN[$i];
    if($n[$i]!='') {
        $nx	=$nx.$n[$i][0];
    }
}
$siglaP	= explode(' ',$RsNomUsr['cApellidosTrabajador']);
$countSiglaP = count($siglaP);
$ny='';
for($i = 0; $i < $countSiglaP; $i++){
    $m[$i]	=  	$siglaP[$i];
    if($m[$i]!='') {
        $ny = $ny . $m[$i][0];
    }
}

// armar correlativo
$cCodificacion = add_ceros($nCorrelativo,5).'-'.date('Y').'-APCI/'.trim($RsSigla['cSiglaOficina']);//.'-'.strtoupper(trim($nx.$ny));

if(!isset($_POST['nFlgEnvio'])){
    $_POST['nFlgEnvio']=1;
}else  if($_POST['nFlgEnvio']??''==1){
    $_POST['nFlgEnvio']='';
}

$sqlAdd = "INSERT INTO Tra_M_Tramite ";
$sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion, iCodTrabajadorRegistro, iCodOficinaRegistro,  cCodTipoDoc, fFecDocumento,	cAsunto, cObservaciones, fFecPlazo, fFecRegistro, nFlgEstado, nFlgEnvio,cCuerpoDocumento)";
$sqlAdd.=" VALUES ";
$sqlAdd.="(2,2,'".$cCodificacion."','".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '".$fFecActual."', '".$_POST['cAsunto']."', '".$_POST['cObservaciones']."', ".$fFecPlazo.", '".$fFecActual."',1, '".($_POST['nFlgEnvio']??'')."','".$_POST['editor']."')";
$rs=sqlsrv_query($cnx,$sqlAdd);

//Ultimo registro de tramite
$rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
$RsUltTra = sqlsrv_fetch_array($rsUltTra);
$sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."'";
$rsTipDoc = sqlsrv_query($cnx,$sqlTipDoc);
$RsTipDoc = sqlsrv_fetch_array($rsTipDoc);

$nomenclatura = str_replace('/','-',trim($RsSigla['cSiglaOficina'])).'/'.$nNumAno.'/'.str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])).'/'.$nNumMes.'/'.trim($RsNomUsr['cUsuario']);
$url_srv = $hostUpload.':'.$port.$path;
$url_f = 'docAnexos/'.$nomenclatura.'/';
$curl = new CURLConnection($url_srv.$fileUpload);

if( isset($_FILES['fileUpLoadDigital']) && $_FILES['fileUpLoadDigital']['name']!==''){
    $archivos = $_FILES['fileUpLoadDigital'];
    for ($i = 0; $i < count($archivos['tmp_name']); $i++) {
        $extension = explode('.', $archivos['name'][$i]);
        $num = count($extension) - 1;
        $cNombreOriginal = $archivos['name'][$i];

        $_FILES['fileUpLoadDigital']['tmp_name'] = $archivos['tmp_name'][$i];
        $_FILES['fileUpLoadDigital']['name'] = $archivos['name'][$i];
        $_FILES['fileUpLoadDigital']['type'] = $archivos['type'][$i];
        $_POST['path'] = $url_f;
        $_POST['name'] = 'fileUpLoadDigital';

        if ($extension[$num] == 'jpg' || $extension[$num] == 'jpeg' || $extension[$num] == 'png' || $extension[$num] == 'pdf' || $extension[$num] == 'doc' || $extension[$num] == 'docx' || $extension[$num] == 'xls' || $extension[$num] == 'xlsx' || $extension[$num] == 'ppt' || $extension[$num] == 'pptx') { //|| $extension[$num]==='dll' || $extension[$num]=== 'EXE' || $extension[$num]==='DLL'){
            $nuevo_nombre = str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])).'-'.str_replace('/','-',$cCodificacion).'-anexos-'.$i.'.'.$extension[$num];
            $_POST['new_name'] = $nuevo_nombre;
            $curl->uploadFile($_FILES, $_POST);

            // GUARDA EN LA BASE DE DATOS LA DIRECCION DEL DOCUMENTO SIN LA DIRECCION DEL SERVIDOR
            $url  = $url_srv.$url_f.$nuevo_nombre;
            $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $RsUltTra['iCodTramite'] . "', '" . $cNombreOriginal . "', '" . $url . "', '3')";
            $rsDigt = sqlsrv_query($cnx, $sqlDigt);
        }
    }
}

$sqlTJefe = " SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina = '".$_SESSION['iCodOficinaLogin']."' and nFlgEstado =1 and iCodCategoria =5 ";
$rsTJefe  = sqlsrv_query($cnx,$sqlTJefe);
$RsTJefe  = sqlsrv_fetch_array($rsTJefe);

$countlstTrabajadoresSel = count($_POST['lstTrabajadoresSel']);
for ($i=0;$i<$countlstTrabajadoresSel;$i++){
    $lstTrabajadoresSel=$_POST['lstTrabajadoresSel'];
    //echo "<li>".$lstTrabajadoresSel[$i];
    // agragar nuevo movimiento por accion ENVIAR
    $sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlMov.="(iCodTramite,	iCodTrabajadorRegistro,	nFlgTipoDoc, iCodOficinaOrigen, iCodOficinaDerivar,	iCodTrabajadorDerivar, iCodIndicacionDerivar, cPrioridadDerivar, cAsuntoDerivar, cObservacionesDerivar , fFecDerivar , fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, cCodTipoDocDerivar,cFlgCopia)";
    $sqlMov.=" VALUES ";
    $sqlMov.="('".$RsUltTra['iCodTramite']."', '".$_SESSION['CODIGO_TRABAJADOR']."', '2','".$_SESSION['iCodOficinaLogin']."', '".$_POST['iCodOficinaDerivar']."','".$lstTrabajadoresSel[$i]."','".$_POST['iCodIndicacion'][0]."','Media', '".$_POST['cAsunto']."',	'".$_POST['cObservaciones']."', '$fFecActual','".$fFecActual."',1,1,'".$_POST['cCodTipoDoc']."',0)";
    //$rsMov=sqlsrv_query($cnx,$sqlMov);
}

    if ($_SESSION['iCodPerfilLogin'] !== '3') {
        $sqlOfiRespuesta = "SELECT iCodOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0  AND iCodOficina =  " . $_SESSION['iCodOficinaLogin'];
    } else {
        $sqlofi = "select cSiglaOficina from Tra_M_Oficinas where iCodOficina =" . $_SESSION['iCodOficinaLogin'];
        $qofice = sqlsrv_query($cnx, $sqlofi);
        $siglaoficina = sqlsrv_fetch_array($qofice);

        if (strpos($siglaoficina['cSiglaOficina'], '-')) {
            $arrayoficina = explode("-", $siglaoficina['cSiglaOficina']);
            $oficinajefe = $arrayoficina[0];
        } else {
            $oficinajefe = 'DE';
        }
        $sqlOfiRespuesta = "SELECT iCodOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE RTRIM(cSiglaOficina) = '" . $oficinajefe . "'";
    }

    // ENCUENTRA LA OFICINA DEL JEFE INMEDIATO
    $rsOficinaRespuesta = sqlsrv_query($cnx, $sqlOfiRespuesta);
    $RsOficinaRespuesta = sqlsrv_fetch_array($rsOficinaRespuesta);

    // CODIGO DEL JEFE INMEDIATO
    $sqlTraJefe = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = " . $RsOficinaRespuesta['iCodOficina'] . " AND iCodPerfil = 3";
    $rsTraJefe = sqlsrv_query($cnx, $sqlTraJefe);
    $RsTraJefe = sqlsrv_fetch_array($rsTraJefe);

    //INGRESE MOVIMIENTO AL JEFE DIRECTO
    $sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlMov.="(iCodTramite,	iCodTrabajadorRegistro,	nFlgTipoDoc, iCodOficinaOrigen, iCodOficinaDerivar,	iCodTrabajadorDerivar, iCodIndicacionDerivar, cPrioridadDerivar, cAsuntoDerivar, cObservacionesDerivar , fFecDerivar , fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, cCodTipoDocDerivar,cFlgCopia)";
    $sqlMov.=" VALUES ";
    $sqlMov.="('".$RsUltTra['iCodTramite']."', '".$_SESSION['CODIGO_TRABAJADOR']."', '2','".$_SESSION['iCodOficinaLogin']."', '".$RsOficinaRespuesta['iCodOficina']."','".$RsTraJefe['iCodTrabajador']."','".$_POST['iCodIndicacion'][0]."','Media', '".$_POST['cAsunto']."',	'".$_POST['cObservaciones']."', '$fFecActual','".$fFecActual."',1,1,'".$_POST['cCodTipoDoc']."',0)";
    $rsMov=sqlsrv_query($cnx,$sqlMov);

    $countiCodIndicacion = count($_POST['iCodIndicacion']);
    $listaIndicacion = $_POST['iCodIndicacion'];
    for ($i=0;$i<$countiCodIndicacion;$i++){
        // agregar indicaciones
        $sqlMov="INSERT INTO Tra_M_Indicacion_Tramite ";
        $sqlMov.="(iCodTramite,	iCodIndicacion)";
        $sqlMov.=" VALUES ";
        $sqlMov.="('".$RsUltTra['iCodTramite']."', '".$listaIndicacion[$i]."')";
        $rsMov=sqlsrv_query($cnx,$sqlMov);
    }



//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
    //include("../plantilla.php");
    include("../documento_pdf_all.php");


   // $url =  str_replace('opt/stdd/files//','files/',$host.':'.$port_ngnix.$path.'/'.$nuevo_nombre);
    $idtra = $RsUltTra['iCodTramite'];
    $sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('".$RsUltTra['iCodTramite']."', '', '".$url."', '2')";
    $rsDigt=sqlsrv_query($cnx,$sqlDigt);

    $arr = array(
        'url'=>$url,
        'tra'=>$idtra
    );

    echo json_encode($arr);


}else{
    header("Location: ../../index-b.php?alter=5");
}
?>