<?php
include_once "../../conexion/conexion.php";
session_start();
$VI_ASUNTO = $_POST['VI_ASUNTO']=="" ? "" : trim($_POST['VI_ASUNTO']);
$VI_NCUD = $_POST['VI_NCUD']==""? "" :trim($_POST['VI_NCUD']);
$VI_FFECREGISTRO_INICIO = $_POST['VI_FFECREGISTRO_INICIO'] =="" ? '' : trim($_POST['VI_FFECREGISTRO_INICIO']);
$VI_FFECREGISTRO_FINAL = $_POST['VI_FFECREGISTRO_FINAL'] =="" ? '' : trim($_POST['VI_FFECREGISTRO_FINAL']);
$VI_CCODTIPODOC = $_POST['VI_CCODTIPODOC']==0 ? 0 :$_POST['VI_CCODTIPODOC'];
$VI_CCODIFICACION = $_POST['VI_CCODIFICACION']=="" ? "" : trim($_POST['VI_CCODIFICACION']);
$VI_ICODOFICINAREGISTRO = $_POST['VI_ICODOFICINAREGISTRO']== 0? 0:$_POST['VI_ICODOFICINAREGISTRO'];
$VI_ICODESPECIALISTAREGISTRO = $_POST['VI_ICODESPECIALISTAREGISTRO']== 0? 0:$_POST['VI_ICODESPECIALISTAREGISTRO'];
$start =$_POST["start"]=="" ? 0 : $_POST["start"];
$length = $_POST["length"]=="" ? 10 : $_POST["length"];

$params = array(
    $VI_ASUNTO,
    $VI_NCUD,
    $VI_FFECREGISTRO_INICIO,
    $VI_FFECREGISTRO_FINAL,
    $VI_CCODTIPODOC,
    $VI_CCODIFICACION,
    $VI_ICODOFICINAREGISTRO,
    $VI_ICODESPECIALISTAREGISTRO,
    $start,
    $length
);

$sqlConsulta = "{call SP_CONSULTA_DOCUMENTOS_PENDIENTES_RESUMEN (?,?,?,?,?,?,?,?,?,?) }";
$rsConsulta = sqlsrv_query($cnx, $sqlConsulta, $params);
if($rsConsulta === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$data = array();
while($Rs=sqlsrv_fetch_array($rsConsulta)){
    $subdata=array();
    $subdata['VACIO']=$Rs['VACIO'];
    $subdata['CANTIDAD']=$Rs['CANTIDAD'];
    $subdata['TRABAJADOR_DESTINO']=$Rs['TRABAJADOR_DESTINO'];
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

$recordsTotal=$VO_TOTREG;
$recordsFiltered=$VO_TOTREG;
$json_data = array(
    "draw"            => (int)($_POST['draw']??0),
    "recordsTotal"    => (int) $recordsTotal ,
    "recordsFiltered" => (int) $recordsFiltered ,
    "data"            => $data
);

echo json_encode($json_data);
