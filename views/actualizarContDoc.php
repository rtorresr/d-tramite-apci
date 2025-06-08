<?php
include_once("../conexion/conexion.php");

$idm = $_POST['iCodMovimiento'][0];
$contenido = $_POST['contenido'];

$sqlMovP = "SELECT iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$idm;
$rsMovP = sqlsrv_query($cnx,$sqlMovP);
$RsMovP = sqlsrv_fetch_array($rsMovP);

$sqlActu = "UPDATE Tra_M_Proyecto SET  cCuerpoDocumento = '".$contenido."' WHERE iCodProyecto = ".$RsMovP['iCodProyecto'];
$rsActu = sqlsrv_query($cnx,$sqlActu);

echo "¡Documento actulizado!";