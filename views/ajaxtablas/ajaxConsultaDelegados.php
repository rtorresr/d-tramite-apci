<?php
include_once "../../conexion/conexion.php";
session_start();
$VI_NCUD = $_POST['VI_NCUD']==""? "" :trim($_POST['VI_NCUD']);
//$VI_ICODOFICINAREGISTRO =$_POST['VI_ICODOFICINAREGISTRO']??0;
$VI_ICODOFICINAREGISTRO = $_SESSION['iCodOficinaLogin'];
$VI_FFECREGISTRO_INICIO = $_POST['VI_FFECREGISTRO_INICIO'] =="" ? '' : $_POST['VI_FFECREGISTRO_INICIO'];
$VI_FFECREGISTRO_FINAL = $_POST['VI_FFECREGISTRO_FINAL'] =="" ? '' : $_POST['VI_FFECREGISTRO_FINAL'];
//$VI_ASUNTO = $_POST['VI_ASUNTO']=="" ? "" : trim($_POST['VI_ASUNTO']);
//$VI_CCODTIPODOC = $_POST['VI_CCODTIPODOC']=="" ? 0 :$_POST['VI_CCODTIPODOC'];
//$VI_CCODTIPODOC = 0;
//$VI_CCODIFICACION = $_POST['VI_CCODIFICACION']=="" ? "" : trim($_POST['VI_CCODIFICACION']);
$VI_USARIODELEGADO = $_POST['VI_USARIODELEGADO'] ==""?"": trim($_POST['VI_USARIODELEGADO']);
$VI_ESTADO = $_POST['VI_ESTADO'] ==""?"": trim($_POST['VI_ESTADO']);
$start =$_POST["start"]=="" ? 0 : $_POST["start"];
$length = $_POST["length"]=="" ? 10 : $_POST["length"];

//echo $start; 
$sqlConsulta = "execute SP_CONSULTA_DOCUMENTOS_DELEGADOS '".$VI_NCUD."',".$VI_ICODOFICINAREGISTRO.",'".$VI_FFECREGISTRO_INICIO."','".$VI_FFECREGISTRO_FINAL."','".$VI_USARIODELEGADO."','".$VI_ESTADO."',".$start.",". $length;

$rsConsulta = sqlsrv_query($cnx,$sqlConsulta);

if($rsConsulta === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();
try {
    //code...

while($Rs=sqlsrv_fetch_array($rsConsulta)){

    $subdata=array();
    $subdata['iCodTrabajadorFirmante']=$Rs['iCodTrabajadorFirmante'];
    $subdata['iCodOficinaFirmante']=$Rs['iCodOficinaFirmante'];
    $subdata['ICODTRAMITE']=$Rs['ICODTRAMITE'];
    $subdata['CUD']=$Rs['CUD'];
    $subdata['TIPO']=$Rs['TIPO'];
    $subdata['TIPO_DOCUMENTO']=$Rs['TIPO_DOCUMENTO'].' '.$Rs['NRO_DOCUMENTO'];
    $subdata['ASUNTO']=$Rs['ASUNTO'];
    $subdata['OFICINA_ORIGIN']=$Rs['OFICINA_ORIGIN'];
    $subdata['TRABAJADOR_ORIGEN']=$Rs['TRABAJADOR_ORIGEN'];
    $subdata['TRABAJADOR_DERIVAR']=$Rs['TRABAJADOR_DESTINO'];    
    $subdata['FEC_DOCUMENTO']=($Rs['FEC_DOCUMENTO'] != null || $Rs['FEC_DOCUMENTO'] != '') ? $Rs['FEC_DOCUMENTO']->format( 'd/m/Y H:i:s') : '';
    $subdata['DESTINO']=$Rs['DESTINO'];
    $subdata['FEC_REGISTRO']=$Rs['FEC_REGISTRO'] != null ? $Rs['FEC_REGISTRO']->format( 'd/m/Y H:i:s') : '';
    $subdata['ESTADO_TRAMITE']=$Rs['ESTADO_TRAMITE'];
    $subdata['flgEncriptado']=$Rs['flgEncriptado'];
    $subdata['origen']=$Rs['origen'];
    $subdata['ENTIDAD']=$Rs['ENTIDAD'] ?? '';
    $data[]=$subdata;
}
$VO_TOTREG=0;

while($res = sqlsrv_next_result($rsConsulta)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rsConsulta, SQLSRV_FETCH_ASSOC)){
            $VO_TOTREG=$row['VO_TOTREG'];
        }
    } elseif( is_null($res)) {
        echo "No se Pudo Registrar el Proyecto";
        return;
    } else {
        die(print_r(sqlsrv_errors(), true));
    }                    
}

$recordsTotal=$VO_TOTREG;//sqlsrv_num_rows($rsConsulta);
$recordsFiltered=$VO_TOTREG;//sqlsrv_num_rows($rsConsulta);
$json_data = array(
    "draw"            => (int)($_POST['draw']??0),
    "recordsTotal"    => (int) $recordsTotal ,
    "recordsFiltered" => (int) $recordsFiltered ,
    "data"            => $data    
);

echo json_encode($json_data);
} catch (\Throwable $th) {
    die(print_r($th, true));
}
