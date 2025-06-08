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


$sqlCont = "SELECT cCuerpoDocumento FROM Tra_M_Proyecto WHERE iCodProyecto = ".$RsMovP['iCodProyecto'];
$rsCont = sqlsrv_query($cnx,$sqlCont);
$RsCont = sqlsrv_fetch_array($rsCont);
echo $RsCont['cCuerpoDocumento'];