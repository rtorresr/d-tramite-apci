<?php
/**
 * Created by PhpStorm.
 * User: anthonywainer
 * Date: 19/11/2018
 * Time: 18:40
 */

include_once("../../conexion/conexion.php");
date_default_timezone_set('America/Lima');
$idm = $_POST['iCodMovimiento'][0];

$sql= "SELECT * from vw_path_tramite where iCodMovimiento = $idm  AND iCodTipoDigital = $_POST[tipo] AND tipo = '$_POST[tabla]'";
$pro=sqlsrv_query($cnx,$sql);
$pro=sqlsrv_fetch_array($pro);

$arr = array(
    'url'=>$pro['cNombreNuevo'],
    'idtra'=>$pro['codigo']
);

echo json_encode($arr);
