<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroDias.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registra cantidad de dias para un tramitre
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
require_once("../conexion/conexion.php");
$sql= "UPDATE Tra_M_Tramite SET iCodTema='$_POST['iCodTema']' WHERE iCodTramite='$_POST[iCodTramite]'";
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
sqlsrv_close($cnx);
header("Location: ../views/pendientesControl.php");
?>