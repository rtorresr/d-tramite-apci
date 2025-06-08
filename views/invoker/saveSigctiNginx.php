<?php
include_once("../../conexion/conexion.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../../core/CURLConection.php");
require_once('../clases/DocDigital.php');

session_start();
$nNumAno    = date('Y');
$nNumMes    = date('m');
$nNumDia    = date('d');

$agrupado = "SIGCTI".date("YmdGis");

$archivos = $_FILES['fileUpLoadDigital'];
$nomenclatura = $nNumAno.'/'.$nNumMes.'/'.$nNumDia.'/'."SIGCTI".'/'."SIGCTI".'/'.$agrupado;
$url_srv = $host . ':' . $port . $path;
$url_f = 'docEntrada/'.$nomenclatura.'/';

$curl = new CURLConnection($url_srv . $fileUpload);

$datos = [];
try {
//for ($i = 0; $i < count($archivos['tmp_name']); $i++) {
$datosParcial = [];
$extension = explode('.', $archivos['name']);
$num = count($extension) - 1;

$nombre = DocDigital::formatearNombre($archivos['name'],true,['/'],'');

$_FILES['fileUpLoadDigital']['tmp_name'] = $archivos['tmp_name'];
$_FILES['fileUpLoadDigital']['name'] = $archivos['name'];
$_FILES['fileUpLoadDigital']['type'] = $archivos['type'];

$_POST['path'] = $url_f;
$_POST['name'] = 'fileUpLoadDigital';

if ($extension[$num] == 'jpg' || $extension[$num] == 'jpeg' || $extension[$num] == 'png' || $extension[$num] == 'pdf' || $extension[$num] == 'doc' || $extension[$num] == 'docx' || $extension[$num] == 'xls' || $extension[$num] == 'xlsx' || $extension[$num] == 'ppt' || $extension[$num] == 'pptx')
{
    $_POST['new_name'] = $nombre;
    $curl->uploadFile($_FILES, $_POST);
    $url = $url_f . $nombre;

    $datosParcial['original'] = $archivos['name'];
    $datosParcial['nuevo'] = $url;

    $parametros = array(
        NULL,
        $agrupado,
        $archivos['name'],
        $url,
        5,
	    '',
        0
    );

    $sqlInsertarDigital = "{call SP_INGRESO_DOCUMENTO_NUEVO (?,?,?,?,?,?,?) }";
    $rs = sqlsrv_query($cnx, $sqlInsertarDigital, $parametros);
    if($rs === false) {
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }
    $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
    $datosParcial['codigo'] = $Rs['iCodDigital'];
}

$datos = $datosParcial;
} finally {
    echo json_encode($datos);
}
//}

?>