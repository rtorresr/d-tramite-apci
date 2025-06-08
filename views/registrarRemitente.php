<?php
include_once("../conexion/conexion.php");
if(!isset($_POST['datos']['nRemitente'])){
    $nombre = $_POST['nombre'];
} else {
    $nombre = $_POST['datos']['nRemitente'];
}

if($_POST['nuevo'] == '1'){
    if ( $_POST['datos']['nRemitente'] !== '') {
        $params = array(
            $_POST['datos']['nRemitente'],
            $_POST['datos']['nNumDocumento'],
            $_POST['datos']['cSiglaRemitente'],
            $_POST['datos']['nResponsableRemitente'],
            $_POST['datos']['nResponsableCargoRemitente'],
            $_POST['datos']['direccion'],
            $_POST['datos']['cDepartamento']??'',
            $_POST['datos']['cProvincia']??'',
            $_POST['datos']['cDistrito']??'',
            $_POST['datos']['codigoMRE']??'',
            $_POST['datos']['idTipoRemitente']??''
        );
        $sqlConsultaRemitente = "{call SP_REMITENTE_INSERT (?,?,?,?,?,?,?,?,?,?,?) }";
        $rs = sqlsrv_query($cnx, $sqlConsultaRemitente, $params);
        if ($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
        echo $Rs['mensaje'];
    } else {
        echo '¡Faltan datos!';
    }

} else {
    if ( $_POST['datos']['nRemitente'] !== '') {
        $params = array(
            $_POST['iCodRemitente'],
            $_POST['datos']['nRemitente'],
            $_POST['datos']['nNumDocumento'],
            $_POST['datos']['cSiglaRemitente'],
            $_POST['datos']['nResponsableRemitente'],
            $_POST['datos']['nResponsableCargoRemitente'],
            $_POST['datos']['direccion'],
            $_POST['datos']['cDepartamento']??'',
            $_POST['datos']['cProvincia']??'',
            $_POST['datos']['cDistrito']??'',
            $_POST['datos']['codigoMRE']??'',
            $_POST['datos']['idTipoRemitente']??''
        );
        $sqlConsultaRemitente = "{call SP_REMITENTE_UPDATE (?,?,?,?,?,?,?,?,?,?,?,?) }";
        $rs = sqlsrv_query($cnx, $sqlConsultaRemitente, $params);
        if ($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
        echo $Rs['mensaje'];
    } else {
        echo '¡Faltan datos!';
    }

    /*$sqlRegact = "UPDATE Tra_M_Remitente SET cNombre = '".$_POST['datos']['nRemitente']."' ,
     cDireccion = '".$_POST['datos']['direccion']."' , 
     cDepartamento = '".$_POST['datos']['cDepartamento']."',
     cProvincia = '".$_POST['datos']['cProvincia']."' , 
     cDistrito = '".$_POST['datos']['cDistrito']."' , 
     cSiglaRemitente = '".$_POST['datos']['cSiglaRemitente']."' 
    WHERE iCodRemitente = ".$_POST['iCodRemitente'] ;
    $rsRegact = sqlsrv_query($cnx,$sqlRegact);
    echo "¡Remitente actualizado Correctamente!";*/
}
?>
