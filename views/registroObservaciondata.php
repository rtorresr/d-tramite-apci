<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroObservaciondata.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registra observacion para un tramitre de Salida
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
require_once("../conexion/conexion.php");
if($_GET[opcion]==2){
	$sql= "UPDATE Tra_M_Tramite_Movimientos SET cObservacionesFinalizar='$_POST[cObservacion]' WHERE iCodMovimiento='$_POST[iCodMovimiento]' ";
	$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
	sqlsrv_close($cnx);
	header("Location: ../views/pendientesFinalizados.php");
}
$sql= "UPDATE Tra_M_Doc_Salidas_Multiples SET cObservacion='$_POST[cObservacion]' , cNomRemite ='$_POST[cNomRemite]',
	   cDireccion= '$_POST[txtdirec_remitente]', cDepartamento='$_POST[cCodDepartamento]' , cProvincia='$_POST[cCodProvincia]' , 		
	   cDistrito='$_POST[cCodDistrito]' 	
 WHERE iCodTramite='$_POST[iCodTramite]' AND iCodAuto='$_POST[iCodAuto]'";
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
sqlsrv_close($cnx);
 
echo "<html> ";
echo "<head> ";
echo "<script languaje='javascript'> ";
echo "function recarga_padre_y_cierra_ventana(){ " ;
echo "window.opener.location.reload(); ";
echo "window.close(); ";
echo "} ";
echo "</script> ";
echo "</head>" ;
echo "<body onLoad='recarga_padre_y_cierra_ventana()'> ";
echo "</body> ";
echo "</html> ";
//header("Location: ../views/iu_doc_salidas_multiple.php?cod=".$_POST[iCodTramite]);
?>