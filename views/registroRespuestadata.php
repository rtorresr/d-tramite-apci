<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroRespuestadata.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registra respuesta para un tramitre de Salida
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
require_once("../conexion/conexion.php");
$sql= "UPDATE Tra_M_Tramite SET cRptaOK='$_POST[cRptaOK]' WHERE iCodTramite='$_POST[iCodTramite]'";
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
sqlsrv_close($cnx);
if($cod!=2){
header("Location: ../views/consultaSalidaGeneral.php");
}
else if($cod==2){
	header("Location: ../views/consultaSalidaOficina.php");
}
?>