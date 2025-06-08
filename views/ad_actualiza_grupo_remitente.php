<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: ad_actualiza_grupo_remitente.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupos de Remitentes
          -> Actualizar Registro de Grupos de Remitentes
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creaci�n del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
$sql= "SP_GRUPO_REMITENTE_UPDATE '$_POST[txtgrupo]','$_POST[txtcod_grupo]' ";
$rs=sqlsrv_query($cnx,$sql);
sqlsrv_close($cnx);
header("Location: ../views/iu_grupo_remitentes.php");
?>
