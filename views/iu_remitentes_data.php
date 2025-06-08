<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Procesos para registro de documentos de entrada
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
	include_once("../conexion/conexion.php");
  switch ($_POST['opcion']) {
    case 1: // actualiza direccion
          $sqlDire = "UPDATE Tra_M_Remitente SET 
                      cDireccion='".$_POST['cDireccion']."',
                      cDepartamento='".$_POST['cDepartamento']."',
					  cProvincia='".$_POST['cProvincia']."',
					  cDistrito='".$_POST['cDistrito']."' 
					  WHERE iCodRemitente = ".$_POST['iCodRemitente'];
          $rsDire = sqlsrv_query($cnx,$sqlDire);
          break;
	case 2: // actualizar anexo
		$sql= "UPDATE Tra_M_Remitente SET  
					cTipoPersona='".$_POST['cTipoPersona']."',
					cNombre=UPPER('".$_POST['cNombre']."'),
					cSiglaRemitente=UPPER('".$_POST[cSiglaRemitente]."'),
					cTipoDocIdentidad='".$_POST[cTipoDocIdentidad]."',
					nNumDocumento='".$_POST['nNumDocumento']."',
					cDireccion='".$_POST[cDireccion]."',
					cEmail='$_POST[cEmail]',
					nTelefono='$_POST[nTelefono]',
					nFax='$_POST[nFax]',
					cDepartamento='$_POST[cDepartamento]',
					cProvincia='$_POST[cProvincia]',
					cDistrito='$_POST[cDistrito]',
					cRepresentante='$_POST[cRepresentante]',
					cFlag='$_POST[cFlag]' 
					where iCodRemitente='$_POST[iCodRemitente]'";
		$rs=sqlsrv_query($cnx,$sql);
		sqlsrv_close($cnx);
		header("Location: iu_remitentes.php");
	break;
	}
	
	if($_GET['opcion']==3){ //retirar remitente
		$sqlX="DELETE FROM Tra_M_Remitente WHERE iCodRemitente='$_GET[iCodRemitente]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		header("Location: iu_remitentes.php?cNombre=".$cNombre."&nNumDocumento=".$nNumDocumento."&campo=".$campo."&orden=".$orden);
	}
	
}Else{
	header("Location: ../index-b.php?alter=5");
}


?>