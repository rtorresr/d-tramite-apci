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
	$nNumAno=date("Y");
	
  function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
    	for($m=0; $m<$dif_diez; $m++){
            @$insertar_ceros .= 0;
    	}
    	return $insertar_ceros .= $numero;
  }		

  $sqlUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
	$rsUsr=sqlsrv_query($cnx,$sqlUsr);
	$RsUsr=sqlsrv_fetch_array($rsUsr);
  
  switch ($_POST[opcion]) {
  case 1:
  	// actualizar fecha de los pendientes al momento de aceptarlos.
  	For ($h=0;$h<count($_POST[iCodMovimiento]);$h++){
      	$iCodMovimiento=$_POST[iCodMovimiento];
   			$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET fFecRecepcion='$fFecActual' WHERE iCodMovimiento='$iCodMovimiento[$h]'";
   			$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
   			
			$sqlMovData="SELECT iCodTramite,iCodMovimiento,iCodTramiteDerivar, nEstadoMovimiento, iCodTrabajadorDelegado FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$iCodMovimiento[$h]'";
   			$rsMovData=sqlsrv_query($cnx,$sqlMovData);
				$RsMovData=sqlsrv_fetch_array($rsMovData);
			
			if($RsMovData['nEstadoMovimiento']==3 && $RsMovData['iCodTrabajadorDelegado']==$_SESSION['CODIGO_TRABAJADOR'] ){
			$sqlMovDel="UPDATE Tra_M_Tramite_Movimientos SET fFecDelegadoRecepcion='$fFecActual' WHERE iCodMovimiento='$iCodMovimiento[$h]'";
   			$rsUpdMovDel=sqlsrv_query($cnx,$sqlMovDel);
			}
			
			if($RsMovData['iCodTramiteDerivar']!=""){
			$sqlUpdDev="UPDATE Tra_M_Tramite_Movimientos SET fFecRecepcion='$fFecActual' WHERE iCodTramite='".$RsMovData['iCodTramiteDerivar']."'";
				$rsUpdDev=sqlsrv_query($cnx,$sqlUpdDev);
			//echo $sqlUpdDev;
			}
   			$sqlUpd="UPDATE Tra_M_Tramite SET nFlgEstado=2 WHERE iCodTramite='$RsMovData[iCodTramite]'";
				$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		}
		header("Location: pendientesControl.php");
	break;
  case 2: 
  //derivacion movimiento
  if($_POST['iCodMovimientoAccion']==""){
  	for ($h=0;$h<count($_POST['MovimientoAccion']);$h++){
         $MovimientoAccion=$_POST['MovimientoAccion'];
    /*  if($_POST[cCodTipoDoc]!=45){
    			// comprobar o recoger correlativo para generar interno
    			$sqlCorr="SELECT * FROM Tra_M_Correlativo_Oficina WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
    			$rsCorr=sqlsrv_query($cnx,$sqlCorr);
    			if(sqlsrv_has_rows($rsCorr)>0){
    				$RsCorr=sqlsrv_fetch_array($rsCorr);
    				$nCorrelativo=$RsCorr[nCorrelativo]+1;
    				
    				$sqlUpd="UPDATE Tra_M_Correlativo_Oficina SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
						$rsUpd=sqlsrv_query($cnx,$sqlUpd);
    			}Else{
    				$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Oficina (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    				$rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
    				$nCorrelativo=1;
    			}
	
    			//leer sigla oficina
    			$rsSigla=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    			$RsSigla=sqlsrv_fetch_array($rsSigla);
    			
    			// armar correlativo
    			$cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-PCM/".trim($RsSigla[cSiglaOficina]);
    }	else {*/
		$cCodificacion="";
		$cCodTipoDoc=45;
	/*	}  */
     			$sqlAdd="INSERT INTO Tra_M_Tramite ";
    			$sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion, 		iCodTrabajadorRegistro,         iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	cAsunto,                 cObservaciones, 				   fFecRegistro,  nFlgEstado, iCodTrabajadorSolicitado )";
    			$sqlAdd.=" VALUES ";
    			$sqlAdd.="(2,           1,           '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$cCodTipoDoc', '$fFecActual', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$fFecActual', 1,			'$_SESSION[JEFE]')";
    			$rs=sqlsrv_query($cnx,$sqlAdd);
    			//Ultimo registro de tramite
					$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
					$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    			
    			$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    			$sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,           iCodTrabajadorDerivar,           iCodIndicacionDerivar,            cPrioridadDerivar,   cAsuntoDerivar,           cObservacionesDerivar,            fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento)";
    			$sqlAdMv.=" VALUES ";
    			$sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaDerivar]', '$_POST[iCodTrabajadorDerivar]', '$_POST[iCodIndicacionDerivar]', 'Media',              '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$fFecActual', '$fFecActual',  1, 						   1)";
    			$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  
  	// cambiar de estado al movimiento
   	$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=2 WHERE iCodMovimiento='$MovimientoAccion[$h]'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$MovimientoAccion[$h]'");
		$RsMovData=sqlsrv_fetch_array($rsMovData);
		
		 $sqlTip="SELECT nFlgTipoDoc FROM Tra_M_Tramite WHERE iCodTramite='$RsMovData[iCodTramite]'";
		$rsTip=sqlsrv_query($cnx,$sqlTip);
			$RsTip=sqlsrv_fetch_array($rsTip);
	//	echo $sqlTip."<br>";		
		
		// crear nuevo registro en movimiento por derivacion de oficina a otra
		
				// por movimiento copias
				if($_POST[cFlgTipoMovimientoOrigen]==4){
					$cFlgTipoMovimientoRec=4;
				}Else{
					$cFlgTipoMovimientoRec=1;
				}
		
		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
		$sqlMov.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc, 						 iCodOficinaOrigen,             iCodOficinaDerivar,           iCodTrabajadorDerivar,           iCodIndicacionDerivar,           cCodTipoDocDerivar,    cAsuntoDerivar,					  cObservacionesDerivar,    			fFecDerivar,	 cNumDocumentoDerivar,  nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento,       iCodTramiteDerivar)";
		$sqlMov.=" VALUES ";
		$sqlMov.="('$RsMovData[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaDerivar]', '$_POST[iCodTrabajadorDerivar]', '$_POST[iCodIndicacionDerivar]', '$cCodTipoDoc', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$fFecActual', '$cCodificacion',      1,                '$fFecActual',   1,           '$cFlgTipoMovimientoRec',	'$RsUltTra[iCodTramite]')";
   	$rsMov=sqlsrv_query($cnx,$sqlMov);
   	

		$sqlTmp="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSessionDrv]' ORDER BY iCodTemp ASC";
    $rsTmp=sqlsrv_query($cnx,$sqlTmp);
	if($RsTip[nFlgTipoDoc]!=2){
    while ($RsTmp=sqlsrv_fetch_array($rsTmp)){
   			$sqlCpy="INSERT INTO Tra_M_Tramite_Movimientos ";
				$sqlCpy.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc,              iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar, 	        cObservacionesDerivar,           cCodTipoDocDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio, cFlgTipoMovimiento, iCodTramiteDerivar)";
				$sqlCpy.=" VALUES ";
				$sqlCpy.="('$RsMovData[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], 	'".$_SESSION['iCodOficinaLogin']."', '$RsTmp['iCodOficina']', '$RsTmp[iCodTrabajador]', '$RsTmp[iCodIndicacion]', '$RsTmp[cPrioridad]', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$cCodTipoDoc', '$fFecActual', 1,                '$fFecActual',   1,				 4, '$RsUltTra[iCodTramite]')";
				$rsCpy=sqlsrv_query($cnx,$sqlCpy);
   		}
	}
	if($RsTip[nFlgTipoDoc]==2){
		if (isset($_POST['Copia'])){
  		 $Copia = $_POST['Copia'];
  		 $n        = count($Copia);
  		 $w        = 0;
		}
		
		 while ($RsTmp=sqlsrv_fetch_array($rsTmp)){
			 $x=1;
		for ($w=0;$w<$n;$w++){
		if($RsTmp[iCodTemp]==$Copia[$w]  ){   //  Seleccion de Copia
		 	$x =4;
		}
		else{		// Sin Copia
			$y =1;
		}
	}	
		if($x==4){
		$cFlgTipoMovimiento=4;
		}
		else if($x!=4){
		$cFlgTipoMovimiento=1;
		}
   			$sqlCpy="INSERT INTO Tra_M_Tramite_Movimientos ";
				$sqlCpy.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc,              iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar, 	        cObservacionesDerivar,           cCodTipoDocDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio, cFlgTipoMovimiento,cNumDocumentoDerivar, iCodTramiteDerivar )";
				$sqlCpy.=" VALUES ";
				$sqlCpy.="('$RsMovData[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], 	'".$_SESSION['iCodOficinaLogin']."', '$RsTmp['iCodOficina']', '$RsTmp[iCodTrabajador]', '$RsTmp[iCodIndicacion]', '$RsTmp[cPrioridad]', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$cCodTipoDoc', '$fFecActual', 1,                '$fFecActual',   1,	'$cFlgTipoMovimiento', '$cCodificacion' ,'$RsUltTra[iCodTramite]')";
				$rsCpy=sqlsrv_query($cnx,$sqlCpy);
				// echo $sqlCpy;
   		}  
	}
   /*	$sqlX="DELETE FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSessionDrv]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		unset($_SESSION[cCodSessionDrv]);    */  	
   	
   	// descrip de tipo de documento
   	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$cCodTipoDoc'";
		$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
		$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
		
   	if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
				$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
				if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}Else{
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
	  	}
	}
	//echo $h;
	
}
else if($_POST['iCodMovimientoAccion']!=""){
 if($_POST[cCodTipoDoc]!=45){
    			// comprobar o recoger correlativo para generar interno
    			$sqlCorr="SELECT * FROM Tra_M_Correlativo_Oficina WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
    			$rsCorr=sqlsrv_query($cnx,$sqlCorr);
    			if(sqlsrv_has_rows($rsCorr)>0){
    				$RsCorr=sqlsrv_fetch_array($rsCorr);
    				$nCorrelativo=$RsCorr[nCorrelativo]+1;
    				
    				$sqlUpd="UPDATE Tra_M_Correlativo_Oficina SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
						$rsUpd=sqlsrv_query($cnx,$sqlUpd);
    			}Else{
    				$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Oficina (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    				$rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
    				$nCorrelativo=1;
    			}
	
    			//leer sigla oficina
    			$rsSigla=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    			$RsSigla=sqlsrv_fetch_array($rsSigla);
    			
    			// armar correlativo
    			$cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-PCM/".trim($RsSigla[cSiglaOficina]);
    }	else {
		$cCodificacion="";
		}
    			$sqlAdd="INSERT INTO Tra_M_Tramite ";
    			$sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion, 		iCodTrabajadorRegistro,         iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	cAsunto,                 cObservaciones, 				   fFecRegistro,  nFlgEstado,		iCodTrabajadorSolicitado)";
    			$sqlAdd.=" VALUES ";
    			$sqlAdd.="(2,           1,           '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$fFecActual', 1,	'$_SESSION[JEFE]'	)";
    			$rs=sqlsrv_query($cnx,$sqlAdd);
    			
    			//Ultimo registro de tramite
					$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
					$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    			
    			$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    			$sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,           iCodTrabajadorDerivar,           iCodIndicacionDerivar,            cPrioridadDerivar,   cAsuntoDerivar,           cObservacionesDerivar,            fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento)";
    			$sqlAdMv.=" VALUES ";
    			$sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaDerivar]', '$_POST[iCodTrabajadorDerivar]', '$_POST[iCodIndicacionDerivar]', 'Media',              '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$fFecActual', '$fFecActual',  1, 						   1)";
    			$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  
  	// cambiar de estado al movimiento
   	$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=2 WHERE iCodMovimiento='$_POST['iCodMovimientoAccion']'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$_POST['iCodMovimientoAccion']'");
		$RsMovData=sqlsrv_fetch_array($rsMovData);
		
		 $sqlTip="SELECT nFlgTipoDoc FROM Tra_M_Tramite WHERE icodtramite='$RsMovData[iCodTramite]'";
		$rsTip=sqlsrv_query($cnx,$sqlTip);
			$RsTip=sqlsrv_fetch_array($rsTip);
		
		// crear nuevo registro en movimiento por derivacion de oficina a otra
		
				// por movimiento copias
				if($_POST[cFlgTipoMovimientoOrigen]==4){
					$cFlgTipoMovimientoRec=4;
				}Else{
					$cFlgTipoMovimientoRec=1;
				}
		
		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
		$sqlMov.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc, 						 iCodOficinaOrigen,             iCodOficinaDerivar,           iCodTrabajadorDerivar,           iCodIndicacionDerivar,           cCodTipoDocDerivar,    cAsuntoDerivar,					  cObservacionesDerivar,    			fFecDerivar,	 cNumDocumentoDerivar,  nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento,       iCodTramiteDerivar)";
		$sqlMov.=" VALUES ";
		$sqlMov.="('$RsMovData[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaDerivar]', '$_POST[iCodTrabajadorDerivar]', '$_POST[iCodIndicacionDerivar]', '$_POST[cCodTipoDoc]', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$fFecActual', '$cCodificacion',      1,                '$fFecActual',   1,           '$cFlgTipoMovimientoRec',	'$RsUltTra[iCodTramite]')";
   	$rsMov=sqlsrv_query($cnx,$sqlMov);
   	

		$sqlTmp="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSessionDrv]' ORDER BY iCodTemp ASC";
    $rsTmp=sqlsrv_query($cnx,$sqlTmp);
	if($RsTip[nFlgTipoDoc]!=2){
    while ($RsTmp=sqlsrv_fetch_array($rsTmp)){
   			$sqlCpy="INSERT INTO Tra_M_Tramite_Movimientos ";
				$sqlCpy.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc,              iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar, 	        cObservacionesDerivar,           cCodTipoDocDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio, cFlgTipoMovimiento, iCodTramiteDerivar)";
				$sqlCpy.=" VALUES ";
				$sqlCpy.="('$RsMovData[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], 	'".$_SESSION['iCodOficinaLogin']."', '$RsTmp['iCodOficina']', '$RsTmp[iCodTrabajador]', '$RsTmp[iCodIndicacion]', '$RsTmp[cPrioridad]', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$_POST[cCodTipoDoc]', '$fFecActual', 1,                '$fFecActual',   1,				 4, '$RsUltTra[iCodTramite]')";
				$rsCpy=sqlsrv_query($cnx,$sqlCpy);
   		}
	}
	if($RsTip[nFlgTipoDoc]==2){
		if (isset($_POST['Copia'])){
  		 $Copia = $_POST['Copia'];
  		 $n        = count($Copia);
  		 $h        = 0;
		}
		
		 while ($RsTmp=sqlsrv_fetch_array($rsTmp)){
			 $x=1;
		for ($h=0;$h<$n;$h++){
		if($RsTmp[iCodTemp]==$Copia[$h]  ){   //  Seleccion de Copia
		 	$x =4;
		}
		else{		// Sin Copia
			$y =1;
		}
	}	
		if($x==4){
		$cFlgTipoMovimiento=4;
		}
		else if($x!=4){
		$cFlgTipoMovimiento=1;
		}
   			$sqlCpy="INSERT INTO Tra_M_Tramite_Movimientos ";
				$sqlCpy.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc,              iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar, 	        cObservacionesDerivar,           cCodTipoDocDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio, cFlgTipoMovimiento,cNumDocumentoDerivar, iCodTramiteDerivar )";
				$sqlCpy.=" VALUES ";
				$sqlCpy.="('$RsMovData[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], 	'".$_SESSION['iCodOficinaLogin']."', '$RsTmp['iCodOficina']', '$RsTmp[iCodTrabajador]', '$RsTmp[iCodIndicacion]', '$RsTmp[cPrioridad]', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$_POST[cCodTipoDoc]', '$fFecActual', 1,                '$fFecActual',   1,	'$cFlgTipoMovimiento', '$cCodificacion' ,'$RsUltTra[iCodTramite]')";
				$rsCpy=sqlsrv_query($cnx,$sqlCpy);
   		}  
	}
  /* 	$sqlX="DELETE FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSessionDrv]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		unset($_SESSION[cCodSessionDrv]);   	

   	*/
   	
   	// descrip de tipo de documento
   	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
		$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
		$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
		
   	if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
				$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
				if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}Else{
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
	  	}
}	
		// header("Location: pendientesControl.php");
		$sqlX="DELETE FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSessionDrv]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		unset($_SESSION[cCodSessionDrv]);  
			
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroDerivado.php>";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=cDescTipoDoc value=\"".$RsTipDoc['cDescTipoDoc']."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual2."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=\"".$_POST[nFlgClaseDoc]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
  case 3:
  	// delegar movimiento
	for ($h=0;$h<count($_POST[iCodMovimiento]);$h++){
	  $iCodMovimiento= $_POST[iCodMovimiento];
		$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=3, iCodTrabajadorDelegado='$_POST['iCodTrabajadorDelegado']', iCodIndicacionDelegado='$_POST[iCodIndicacionDelegado]',  cObservacionesDelegado='$_POST[cObservacionesDelegado]', fFecDelegado='$fFecActual'  WHERE iCodMovimiento='$iCodMovimiento[$h]'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		if($_SESSION['CODIGO_TRABAJADOR']==$_POST['iCodTrabajadorDelegado']){
			$sqlMovDe="UPDATE Tra_M_Tramite_Movimientos SET fFecDelegadoRecepcion='$fFecActual' WHERE iCodMovimiento='$iCodMovimiento[$h]'";
		$rsUpdMovDe=sqlsrv_query($cnx,$sqlMovDe);
		}
		if($_POST[iCodDelOrig]!=$_POST['iCodTrabajadorDelegado']){
		$sqlMovFec="UPDATE Tra_M_Tramite_Movimientos SET fFecDelegadoRecepcion=NULL WHERE iCodMovimiento='$iCodMovimiento[$h]'";
		$rsUpdMovFec=sqlsrv_query($cnx,$sqlMovFec);
		}
		
		$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$iCodMovimiento[$h]'");
		$RsMovData=sqlsrv_fetch_array($rsMovData);
		
		$rsDelCc=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimientoRel='$iCodMovimiento[$h]'");
		
		for ($i=0;$i<count($_POST[lstTrabajadoresSel]);$i++){
			$lstTrabajadoresSel=$_POST[lstTrabajadoresSel];
   		
   		$sqlCpy="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlCpy.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc,             iCodOficinaOrigen,             iCodOficinaDerivar,            iCodTrabajadorEnviar,      iCodIndicacionDerivar,					  cObservacionesDerivar,            fFecDelegado,  fFecDerivar,   fFecMovimiento, nEstadoMovimiento, nFlgEnvio, cFlgTipoMovimiento,iCodMovimientoRel)";
			$sqlCpy.=" VALUES ";
			$sqlCpy.="('$RsMovData[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], '".$_SESSION['iCodOficinaLogin']."', '".$_SESSION['iCodOficinaLogin']."', '$lstTrabajadoresSel[$i]', '$_POST[iCodIndicacionDelegado]', '$_POST[cObservacionesDelegado]', '$fFecActual', '$fFecActual', '$fFecActual',  1,                 1,					6, '$iCodMovimiento[$h]')";
			$rsCpy=sqlsrv_query($cnx,$sqlCpy);
		}
		
	}
		header("Location: pendientesControl.php");
	break;
  case 4:
  	// finalizar movimiento
	for ($h=0;$h<count($_POST[iCodMovimiento]);$h++){
	  $iCodMovimiento= $_POST[iCodMovimiento];
	
		$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=5, iCodTrabajadorFinalizar='".$_SESSION['CODIGO_TRABAJADOR']."', cObservacionesFinalizar='$_POST[cObservacionesFinalizar]', fFecFinalizar='$fFecActual'  WHERE iCodMovimiento='$iCodMovimiento[$h]'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		// buscar iCodTramite
	$rsCodTra=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$iCodMovimiento[$h]' And cFlgTipoMovimiento=1 ");
		$RsCodTra=sqlsrv_fetch_array($rsCodTra);
		
		//listar movimientos
	$rsListaMov=sqlsrv_query($cnx,"SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsCodTra[iCodTramite]' And cFlgTipoMovimiento=1 ORDER BY iCodMovimiento DESC ");
		$RsListaMov=sqlsrv_fetch_array($rsListaMov);
		
		if($RsCodTra[iCodMovimiento]==$RsListaMov[iCodMovimiento]){
		$sqlUpdTra="UPDATE Tra_M_Tramite SET nFlgEstado=3 WHERE iCodTramite='$RsCodTra[iCodTramite]'";
		$rsUpdTra=sqlsrv_query($cnx,$sqlUpdTra);
		}
		}
		header("Location: pendientesControl.php");  
	break;
  case 5:
  for ($h=0;$h<count($_POST[iCodMovimiento]);$h++){
	  $iCodMovimiento= $_POST[iCodMovimiento];
	  $sqlMovData="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$iCodMovimiento[$h]'";
  	  $rsMovData=sqlsrv_query($cnx,$sqlMovData);
	  	$RsMovData=sqlsrv_fetch_array($rsMovData);
		
		// a�adir avances del movimiento.
		$sqlMov="INSERT INTO Tra_M_Tramite_Avance ";
		$sqlMov.="(iCodTramite,               iCodMovimiento,           iCodTrabajadorAvance,            cObservacionesAvance, 					fFecAvance)";
		$sqlMov.=" VALUES ";
		$sqlMov.="('$RsMovData[iCodTramite]', '$iCodMovimiento[$h]', '".$_SESSION['CODIGO_TRABAJADOR']."', '$_POST[cObservacionesAvance]', '$fFecActual')";
   	$rsMov=sqlsrv_query($cnx,$sqlMov);
   	//echo $sqlMov;
  }
		header("Location: pendientesControl.php");  
	break;
  case 6:
		$sqlUpdTra="UPDATE Tra_M_Tramite_Movimientos SET iCodOficinaDerivar='$_POST[iCodOficinaDerivar]', iCodTrabajadorDerivar='$_POST[iCodTrabajadorDerivar]', cAsuntoDerivar='$_POST[cAsuntoDerivar]', cObservacionesDerivar='$_POST[cObservacionesDerivar]', iCodIndicacionDerivar='$_POST[iCodIndicacionDerivar]' WHERE iCodMovimiento='$_POST[iCodMovimiento]'";
		$rsUpdTra=sqlsrv_query($cnx,$sqlUpdTra);
		
		header("Location: pendientesDerivados.php");  
	break;
	}
	
	if($_GET[opcion]==11){ //anular finalizado
		$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=1, iCodTrabajadorFinalizar=NULL, cObservacionesFinalizar=NULL, fFecFinalizar=NULL  WHERE iCodMovimiento='$_GET[iCodMovimiento]'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		// buscar iCodTramite
		$rsCodTra=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$_GET[iCodMovimiento]'");
		$RsCodTra=sqlsrv_fetch_array($rsCodTra);
		
		$sqlUpdTra="UPDATE Tra_M_Tramite SET nFlgEstado=2 WHERE iCodTramite='$RsCodTra[iCodTramite]'";
		$rsUpdTra=sqlsrv_query($cnx,$sqlUpdTra);
		header("Location: pendientesFinalizados.php");
	}	

}Else{
	header("Location: ../index-b.php?alter=5");
}
?>