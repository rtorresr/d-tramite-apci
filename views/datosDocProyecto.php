<?php
include_once("../conexion/conexion.php");
date_default_timezone_set('America/Lima');
if (($_POST['flag']??0) == 1){
    $idm = $_POST['iCodMovimiento'];
}else {
    $idm = $_POST['iCodMovimiento'][0];
}

$sqlMovP = "SELECT iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$idm;
$rsMovP = sqlsrv_query($cnx,$sqlMovP);
$RsMovP = sqlsrv_fetch_array($rsMovP);


$sqlCont = "SELECT cCodTipoDoc ,cAsunto, cObservaciones, flgSigo, nFlgTipoDoc, iCodSesionOficinaDestino, ARCHIVO_FISICO,iCodRemitente,
 nombreResponsable, cargoResponsable FROM Tra_M_Proyecto WHERE iCodProyecto = ".$RsMovP['iCodProyecto'];
$rsCont = sqlsrv_query($cnx,$sqlCont);
$RsCont = sqlsrv_fetch_array($rsCont);
$data = [];
$data['asunto'] = $RsCont['cAsunto'];
$data['codigoDoc'] = $RsCont['cCodTipoDoc'];
$data['observaciones'] = $RsCont['cObservaciones']??'';
$data['sigo'] = $RsCont['flgSigo'];
if($RsCont['nFlgTipoDoc'] == 2) {
    $data['externo'] = 0 ;
} else {
    $data['externo'] = 1;
}
if($data['externo'] == 1){
    $sqlRemitente = "SELECT cNombre, cDireccion, cNomDepartamento, cNomProvincia, cNomDistrito
FROM Tra_M_Remitente AS remi 
INNER JOIN Tra_U_Departamento AS dep ON dep.cCodDepartamento = remi.cDepartamento
INNER JOIN Tra_U_Provincia AS pro ON pro.cCodDepartamento = remi.cDepartamento AND pro.cCodProvincia = remi.cProvincia
INNER JOIN Tra_U_Distrito AS dis ON dis.cCodDepartamento = remi.cDepartamento AND dis.cCodProvincia = remi.cProvincia AND dis.cCodDistrito = remi.cDistrito
WHERE iCodRemitente = ".$RsCont['iCodRemitente'];
    $rsRemitente = sqlsrv_query($cnx,$sqlRemitente);
    $RsRemitente = sqlsrv_fetch_array($rsRemitente);
    $data['nombreDestinatario'] = rtrim($RsRemitente['cNombre']);
    $data['direccion'] = rtrim($RsRemitente['cDireccion'])." ".rtrim($RsRemitente['cNomDepartamento'])."/".rtrim($RsRemitente['cNomProvincia'])."/".rtrim($RsRemitente['cNomDistrito']);
    $data['responsable'] = rtrim($RsCont['nombreResponsable']);
    $data['cargo'] = rtrim($RsCont['cargoResponsable']);
}


if(rtrim($RsCont['iCodSesionOficinaDestino']) !== ''){
    $sqlDestino = "SELECT iCodTemp, cNomOficina, cNombresTrabajador, cApellidosTrabajador, cIndicacion, cPrioridad 
FROM Tra_M_Tramite_Temporal AS temp
INNER JOIN Tra_M_Oficinas AS ofi ON ofi.iCodOficina = temp.iCodOficina
INNER JOIN Tra_M_Trabajadores AS trab ON trab.iCodTrabajador = temp.iCodTrabajador
INNER JOIN Tra_M_Indicaciones AS ind ON ind.iCodIndicacion = temp.iCodIndicacion WHERE cCodSession = '".rtrim($RsCont['iCodSesionOficinaDestino'])."'";
    $rsDestino = sqlsrv_query($cnx, $sqlDestino);
    $info = [];
    while ($RsDestino = sqlsrv_fetch_array($rsDestino)){
        $destino = [];
        $destino['iCodTemp'] = $RsDestino['iCodTemp'];
        $destino['cNomOficina'] = $RsDestino['cNomOficina'];
        $destino['cNombresTrabajador'] = $RsDestino['cNombresTrabajador'];
        $destino['cApellidosTrabajador'] = $RsDestino['cApellidosTrabajador'];
        $destino['cIndicacion'] = $RsDestino['cIndicacion'];
        $destino['cPrioridad'] = $RsDestino['cPrioridad'];
        $info[] = $destino;
    }
    $data['destinos'] = $info;
    $data['tieneDestino'] = 1;
} else {
    $data['tieneDestino'] = 0;
}



echo json_encode($data);