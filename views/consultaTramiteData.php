<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Proceso para acciones de documentos pendientes del punto de control y profesionales
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
	$fFecActual=date("Ymd")." ".date("H:i:s");
	$rutaUpload="../cAlmacenArchivos/";

  $sqlUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
	$rsUsr=sqlsrv_query($cnx,$sqlUsr);
	$RsUsr=sqlsrv_fetch_array($rsUsr);
  
  switch ($_POST[opcion]) {
  case 1:
  	// nuevo paquete
  	$sqlIns="INSERT INTO Tra_M_Tramite_Fiscalizacion ";
		$sqlIns.="(fFecPaquete,               iCodTrabajadorRegistro)";
		$sqlIns.=" VALUES ";
		$sqlIns.="('$fFecActual', '".$_SESSION['CODIGO_TRABAJADOR']."')";
   	$rsIns=sqlsrv_query($cnx,$sqlIns);
   	
   	//ult paquete
   	$rsUltPaq=sqlsrv_query($cnx,"SELECT TOP 1 iCodPaquete FROM Tra_M_Tramite_Fiscalizacion ORDER BY iCodPaquete DESC");
		$RsUltPaq=sqlsrv_fetch_array($rsUltPaq);
		
  	// recorrido array tramites
  	For ($h=0;$h<count($_POST[iCodTramite]);$h++){
      	$iCodTramite=$_POST[iCodTramite];
   			$sqlTra="UPDATE Tra_M_Tramite SET iCodPaquete='$RsUltPaq[iCodPaquete]' WHERE iCodTramite='$iCodTramite[$h]'";
   			$rsTra=sqlsrv_query($cnx,$sqlTra);
		}
		
		function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
    	for($m=0; $m<$dif_diez; $m++){
            @$insertar_ceros .= 0;
    	}
    	return $insertar_ceros .= $numero;
  	}
  	
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=consultaTramiteFiscalizacion.php>";
		echo "<input type=hidden name=iCodPaquete value=\"".add_ceros($RsUltPaq[iCodPaquete],5)."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
  case 2:
    if($_FILES['fileUpLoadDigital']['name']!=""){
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$nombre = count($extension)-2;
  			$nombre_en_bruto = $extension[$nombre];
  			$nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
				$nuevo_nombre = "Paquete-".$_POST[iCodPaquete]."-".$nombre_original.".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");

				$sqlUpd1="UPDATE Tra_M_Tramite_Fiscalizacion SET cInformeDigital='$nuevo_nombre' WHERE iCodPaquete='$_POST[iCodPaquete]'";
   			$rsUpd1=sqlsrv_query($cnx,$sqlUpd1);
  	}
   			$sqlUpd2="UPDATE Tra_M_Tramite_Fiscalizacion SET cObservaciones='$_POST[cObservaciones]' WHERE iCodPaquete='$_POST[iCodPaquete]'";
   			$rsUpd2=sqlsrv_query($cnx,$sqlUpd2);
				header("Location: consultaTramitePaquetes.php");	
	break;	
	}
	if($_GET[opcion]==3){ //retirar informe digital
			$sqlFiles = "SELECT * FROM Tra_M_Tramite_Fiscalizacion WHERE iCodPaquete='$_GET[iCodPaquete]'";
			$rsFiles = sqlsrv_query($cnx,$sqlFiles);
			$RsFiles = sqlsrv_fetch_array($rsFiles);
			If($RsFiles[cInformeDigital]!=""){
			     if (file_exists($rutaUpload.$RsFiles[cInformeDigital])){ 
  		   	       unlink($rutaUpload.$RsFiles[cInformeDigital]); 
			     }
			}
			$sqlUpd1="UPDATE Tra_M_Tramite_Fiscalizacion SET cInformeDigital=NULL WHERE iCodPaquete='$_GET[iCodPaquete]'";
			$rsUpd1=sqlsrv_query($cnx,$sqlUpd1);
   								
			header("Location: consultaTramitePaquetesEdit.php?iCodPaquete=".$_GET[iCodPaquete]);	
	}	
}Else{
	header("Location: ../index-b.php?alter=5");
}
?>