<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
	include_once("../conexion/conexion.php");
	$fFecActual=date("Ymd")." ".date("G:i:s");
	$fFecActual2=date("Y-m-d")." ".date("G:i:s");
	$rutaUpload="../cAlmacenArchivos/";
	$nNumAno=date("Y");

  $sqlUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
	$rsUsr=sqlsrv_query($cnx,$sqlUsr);
	$RsUsr=sqlsrv_fetch_array($rsUsr);
  
  function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
      $insertar_ceros='';
    	for($m=0; $m<$dif_diez; $m++){
            $insertar_ceros .= 0;
    	}
    	return $insertar_ceros .= $numero;
  }	
  
  switch ($_POST['opcion']) {
  case 1: // aceptar pendientes de profesional
  	For ($h=0, $hMax = count($_POST['iCodMovimiento']); $h< $hMax; $h++){
      	$iCodMovimiento=$_POST['iCodMovimiento'];
		$sqlRec="SELECT fFecRecepcion,iCodTrabajadorDerivar,nEstadoMovimiento FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$iCodMovimiento[$h]'";
		$rsRec=sqlsrv_query($cnx,$sqlRec);
		$RsRec=sqlsrv_fetch_array($rsRec);
		if($RsRec['iCodTrabajadorDerivar']==$_SESSION['CODIGO_TRABAJADOR'] && ( $RsRec['fFecRecepcion']==NULL or trim($RsRec['fFecRecepcion'])=="") ){
			$sqlMovR="UPDATE Tra_M_Tramite_Movimientos SET fFecRecepcion='$fFecActual' WHERE iCodMovimiento='$iCodMovimiento[$h]'";
   			$rsUpdMovR=sqlsrv_query($cnx,$sqlMovR);
		}
   		else{ 
			if($RsRec['nEstadoMovimiento']==3 && ($RsRec['fFecRecepcion']==NULL or trim($RsRec['fFecRecepcion'])=="")){
			$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET  fFecRecepcion='$fFecActual',fFecDelegadoRecepcion='$fFecActual' WHERE iCodMovimiento='$iCodMovimiento[$h]'";
   			$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
			}
			else{
			$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET fFecDelegadoRecepcion='$fFecActual' WHERE iCodMovimiento='$iCodMovimiento[$h]'";
   			$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
			}
		}
		}
		header("Location: profesionalPendientes.php");  
	break;
  case 2: // cambiar de estado al movimiento
   	$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=2 WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'");
		$RsMovData=sqlsrv_fetch_array($rsMovData);
		
		// crear nuevo registro en movimeintos por derivacion de oficina a otra
		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
		$sqlMov.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc, 						 iCodOficinaOrigen,     iCodOficinaDerivar,                cCodTipoDocDerivar,    cAsuntoDerivar,					  cObservacionesDerivar,    			fFecDerivar,	 cNumDocumentoDerivar,     nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento)";
		$sqlMov.=" VALUES ";
		$sqlMov.="('".$RsMovData['iCodTramite']."', '".$_SESSION['CODIGO_TRABAJADOR']."', $RsMovData[nFlgTipoDoc], '".$RsUsr['iCodOficina']."', '$_POST[iCodOficinaResponsable]', '".$_POST['cCodTipoDoc']."', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$fFecActual', '$_POST[cNumDocumento]', 1,                '$fFecActual',   1,           1)";
   	$rsMov=sqlsrv_query($cnx,$sqlMov);
		
		header("Location: profesionalPendientes.php");
	break;		
  case 3: // delegar movimiento
		$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=3, iCodTrabajadorDelegado='".$_POST['iCodTrabajadorDelegado']."', iCodIndicacionDelegado='$_POST[iCodIndicacionDelegado]', cObservacionesDelegado='$_POST[cObservacionesDelegado]', fFecDelegado='$fFecActual'  WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		header("Location: pendientesControl.php");
	break;
  case 4: // finalizar movimiento profesional
      		$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=5, iCodTrabajadorFinalizar='".$_SESSION['CODIGO_TRABAJADOR']."', cObservacionesFinalizar='$_POST[cObservacionesFinalizar]', fFecFinalizar='$fFecActual'  WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		// buscar iCodTramite
		$rsCodTra=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'");
		$RsCodTra=sqlsrv_fetch_array($rsCodTra);

		$sqlDelegado = "SELECT * FROM Tra_M_Tramite_Movimientos 
										WHERE iCodTramite='".$RsCodTra['iCodTramite']."' AND cFlgTipoMovimiento= 6 
										ORDER BY iCodMovimiento ASC";
		$rsDelegado = sqlsrv_query($cnx,$sqlDelegado);

		while ($RsDelegado = sqlsrv_fetch_array($rsDelegado)) {
			if ($RsDelegado['iCodTrabajadorRegistro'] == $RsDelegado['iCodTrabajadorEnviar']) {
				$sqlUpdTra="UPDATE Tra_M_Tramite SET nFlgEstado=3 WHERE iCodTramite='".$RsCodTra['iCodTramite']."'";
				$rsUpdTra=sqlsrv_query($cnx,$sqlUpdTra);
			}
		}
		
		header("Location: profesionalPendientes.php");
	break;
  case 5: // añadir avances del movimiento.
  	$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'");
		$RsMovData=sqlsrv_fetch_array($rsMovData);
		
		
		$sqlMov="INSERT INTO Tra_M_Tramite_Avance ";
		$sqlMov.="(iCodTramite,               iCodMovimiento,           iCodTrabajadorAvance,            cObservacionesAvance, 					fFecAvance)";
		$sqlMov.=" VALUES ";
		$sqlMov.="('".$RsMovData['iCodTramite']."', '".$_POST['iCodMovimiento']."', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_POST['cObservacionesAvance']."', '$fFecActual')";
   	$rsMov=sqlsrv_query($cnx,$sqlMov);
   	//echo $sqlMov;
		
		header("Location: profesionalPendientes.php");  
	break;
  case 6:
		$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".''??$_POST['iCodMovimiento']."'");
		$RsMovData=sqlsrv_fetch_array($rsMovData);
		error_log('PASO 0 ==>'.''??$_POST['iCodTrabajadorEnviar']);
		// cambiar estado del movimiento derivado
		if($RsMovData['cFlgTipoMovimiento']!=2){
			error_log('PASO 1 ==>'.''??$_POST['iCodTrabajadorEnviar']);
			if($RsMovData['nEstadoMovimiento']==3){
				error_log('PASO 2 ==>'.''??$_POST['iCodTrabajadorEnviar']);
				$sqlMov=" UPDATE Tra_M_Tramite_Movimientos ";
				$sqlMov.=" SET fFecDelegadoRecepcion=NULL, iCodTrabajadorDelegado = '".''??$_POST['iCodTrabajadorEnviar']."'  ";
				$sqlMov.=" WHERE iCodMovimiento =  '".''??$_POST['iCodMovimiento']."' ";
				$rsMov=sqlsrv_query($cnx,$sqlMov);
			} else {
				error_log('PASO 3 ==>'.''??$_POST['iCodTrabajadorEnviar']);
				$sqlMov=" UPDATE Tra_M_Tramite_Movimientos ";
				$sqlMov.=" SET fFecRecepcion=NULL, iCodTrabajadorDerivar = '".''??$_POST['iCodTrabajadorEnviar']."', iCodTrabajadorEnviar= '".''??$_POST['iCodTrabajadorEnviar']."' ";
				$sqlMov.=" WHERE iCodMovimiento =  '".$_POST['iCodMovimiento']."' ";
				$rsMov=sqlsrv_query($cnx,$sqlMov);
			}
		} else {
			error_log('PASO 4 ==>'.''??$_POST['iCodTrabajadorEnviar']);
			if($RsMovData['nEstadoMovimiento']==3){
			$sqlMov=" UPDATE Tra_M_Tramite_Movimientos ";
			$sqlMov.=" SET fFecDelegadoRecepcion=NULL, iCodTrabajadorDelegado = '".''??$_POST['iCodTrabajadorEnviar']."'  ";
			$sqlMov.=" WHERE iCodMovimiento =  '".''??$_POST['iCodMovimiento']."' ";
			$rsMov=sqlsrv_query($cnx,$sqlMov);
			}else {
				error_log('PASO 5 ==>'.''??$_POST['iCodTrabajadorEnviar']);
				$sqlMov=" UPDATE Tra_M_Tramite_Movimientos ";
				$sqlMov.=" SET fFecRecepcion=NULL, iCodTrabajadorDerivar = '".''??$_POST['iCodTrabajadorEnviar']."', iCodTrabajadorEnviar= '".''??$_POST['iCodTrabajadorEnviar']."' ";
				$sqlMov.=" WHERE iCodMovimiento =  '".''??$_POST['iCodMovimiento']."' ";
				$rsMov=sqlsrv_query($cnx,$sqlMov);
			}
		}		
		// agregar nuevo movimiento trabajador por accion ENVIAR
		$sqlMovAdd="INSERT INTO Tra_M_Tramite_Trabajadores ";
		$sqlMovAdd.="(iCodMovimiento,iCodTramite,iCodOficina,iCodTrabajadorOrigen,iCodTrabajadorDestino,cObservaciones,fFecEnvio)";
		$sqlMovAdd.=" VALUES ";
		$sqlMovAdd.="('".''??$_POST['iCodMovimiento']."', '".$RsMovData['iCodTramite']."', '".$_SESSION['iCodOficinaLogin']."', '".$_SESSION['CODIGO_TRABAJADOR']."', '".''??$_POST['iCodTrabajadorEnviar']."', '".$_POST['cObservacionesEnviar']."', '$fFecActual')";
   	$rsMovAdd=sqlsrv_query($cnx,$sqlMovAdd);
   	
		header("Location: profesionalPendientes.php");
	break;
  case 7: //responder pendientes profesional
  	if($_POST['cCodTipoDoc']!=45){
   	// comprobar o recoger correlativo
    $sqlCorr = "SELECT * FROM Tra_M_Correlativo_Trabajador 
    						WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."' 
    									AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' 
    									AND iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' 
    									AND nNumAno='$nNumAno'";
    $rsCorr = sqlsrv_query($cnx,$sqlCorr);
    if(sqlsrv_has_rows($rsCorr) > 0){
    	$RsCorr = sqlsrv_fetch_array($rsCorr);
    	$nCorrelativo = $RsCorr['nCorrelativo']+1;
    	
    	$sqlUpd = "UPDATE Tra_M_Correlativo_Trabajador 
    						 SET nCorrelativo='$nCorrelativo' 
    						 WHERE iCodCorrelTrabajador='$RsCorr[iCodCorrelTrabajador]' 
    						 			 AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' 
    						 			 AND nNumAno='$nNumAno'";
			$rsUpd = sqlsrv_query($cnx,$sqlUpd);
    }else{
    	$sqlAdCorr = "INSERT INTO Tra_M_Correlativo_Trabajador (cCodTipoDoc, iCodTrabajador,iCodOficina, nNumAno, nCorrelativo) 
    							  VALUES ('".$_POST['cCodTipoDoc']."', '".$_SESSION['CODIGO_TRABAJADOR']."','".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    	$rsAdCorr = sqlsrv_query($cnx,$sqlAdCorr);
    	$nCorrelativo = 1;
    }
    
    //leer sigla oficina
    $rsSigla = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    $RsSigla = sqlsrv_fetch_array($rsSigla);
    
    //leer user Trabajador
    $sqlNomUsr = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
    $rsNomUsr  = sqlsrv_query($cnx,$sqlNomUsr);
    $RsNomUsr  = sqlsrv_fetch_array($rsNomUsr);
    
		//Siglas del Trabajador
		$siglaN	= explode(" ",$RsNomUsr['cNombresTrabajador']);
		for($i = 0, $iMax = count($siglaN); $i < $iMax; $i++){
			$n[$i]= $siglaN[$i];
			$nx		=	$nx.$n[$i][0]; 
 		}
		$siglaP = explode(" ",$RsNomUsr['cApellidosTrabajador']);
		for($i = 0, $iMax = count($siglaP); $i < $iMax; $i++){
			$m[$i] = $siglaP[$i];
			$ny		 =	$ny.$m[$i][0]; 
 		}
    // armar correlativo
    $cCodificacion = add_ceros($nCorrelativo,5)."-".date("Y")."-SITDD/".trim($RsSigla['cSiglaOficina'])."-".strtoupper(trim($nx.$ny));
    }else{
			$cCodificacion = "";
			$cCodTipoDoc   = 45;
		}
    $sqlAdd = "INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	cAsunto,           cObservaciones,              fFecRegistro, nFlgEstado	)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(2,           2,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '$fFecActual', '$_POST[cAsuntoResponder]', '$_POST[cObservacionesResponder]',  '$fFecActual',1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."' ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
		$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."'";
		$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
		$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
		
  	if($_FILES['fileUpLoadDigital']['name']!=""){
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$nombre = count($extension)-2;
  			$nombre_en_bruto = $extension[$nombre];
  			$nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
				$nuevo_nombre = "Rpta-Prof-Mov-".$_POST['iCodMovimiento']."-".$nombre_original.".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				//$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodMovimiento, cNombreOriginal, cNombreNuevo) VALUES ('".$_POST['iCodMovimiento']."', '$cNombreOriginal', '$nuevo_nombre')"; //CesarAc
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite,iCodMovimiento, cNombreOriginal, cNombreNuevo) VALUES ('".$RsUltTra['iCodTramite']."','".$_POST['iCodMovimiento']."', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			
   			$rsUltDig=sqlsrv_query($cnx,"SELECT TOP 1 iCodDigital FROM Tra_M_Tramite_Digitales ORDER BY iCodDigital DESC");
				$RsUltDig=sqlsrv_fetch_array($rsUltDig);
  	}
	
		$sqlMovI = "INSERT INTO Tra_M_Tramite_Movimientos ";
		$sqlMovI.="(iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,iCodTrabajadorDelegado,fFecDelegado,fFecMovimiento,cObservacionesDelegado,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,nEstadoMovimiento,cFlgTipoMovimiento)";
		$sqlMovI.=" VALUES ";
		$sqlMovI.="('".$RsUltTra['iCodTramite']."','".$_SESSION['CODIGO_TRABAJADOR']."','2','".$_SESSION['iCodOficinaLogin']."','".$_SESSION['iCodOficinaLogin']."','$RsTJefe[iCodTrabajador]','$_POST[iCodTrabajadorResponder]','$fFecActual','$fFecActual','$_POST[cObservacionesResponder]','$_POST[cAsuntoResponder]','$_POST[cObservacionesResponder]', '$fFecActual',3,2)";
		$rsMovI = sqlsrv_query($cnx,$sqlMovI);
		
		$sqlMov="UPDATE Tra_M_Tramite_Movimientos 
						 SET nEstadoMovimiento = 4
						 		,cCodTipoDocResponder='".$_POST['cCodTipoDoc']."'
						 		,iCodTrabajadorResponder='$_POST[iCodTrabajadorResponder]'
						 		,cAsuntoResponder='$_POST[cAsuntoResponder]'
						 		,cObservacionesResponder='$_POST[cObservacionesResponder]'
						 		,iCodDigitalResponder='$RsUltDig[iCodDigital]'
						 		,fFecResponder='$fFecActual'
						 		,iCodTramiteRespuesta='".$RsUltTra['iCodTramite']."' 
						 	WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'";
		$rsUpdMov = sqlsrv_query($cnx,$sqlMov);
		//	echo $sqlMov;
		//	header("Location: profesionalPendientes.php");
	
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra['iCodTramite']."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=2>";
		if($nFlgRestricUp==1){
			echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
			echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
		}		
		echo "</form>";
		echo "</body>";
		echo "</html>";
		
		break;	
	case 8:
  	if($_POST['cCodTipoDoc']!=45){
    // comprobar o recoger correlativo
    $sqlCorr="SELECT * FROM Tra_M_Correlativo_Trabajador WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' AND nNumAno='$nNumAno'";
    $rsCorr=sqlsrv_query($cnx,$sqlCorr);
    if(sqlsrv_has_rows($rsCorr)>0){
    	$RsCorr=sqlsrv_fetch_array($rsCorr);
    	$nCorrelativo=$RsCorr['nCorrelativo']+1;
    	
    	$sqlUpd="UPDATE Tra_M_Correlativo_Trabajador SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelTrabajador='".$RsCorr['iCodCorrelTrabajador']."' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
			$rsUpd=sqlsrv_query($cnx,$sqlUpd);
    }Else{
    	$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Trabajador (cCodTipoDoc, iCodTrabajador, iCodOficina,nNumAno, nCorrelativo) VALUES ('".$_POST['cCodTipoDoc']."', '".$_SESSION['CODIGO_TRABAJADOR']."','".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    	$rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
    	$nCorrelativo=1;
    }
    
    //leer sigla oficina
    $rsSigla=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    $RsSigla=sqlsrv_fetch_array($rsSigla);
    
    //leer user Trabajador
    $sqlNomUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
    $rsNomUsr=sqlsrv_query($cnx,$sqlNomUsr);
    $RsNomUsr=sqlsrv_fetch_array($rsNomUsr);
	
	//Siglas del Trabajador
	$siglaN		=explode(" ",$RsNomUsr['cNombresTrabajador']);
	for($i = 0, $iMax = count($siglaN); $i < $iMax; $i++){
			$n[$i]	=  	$siglaN[$i];
			$nx		=	$nx.$n[$i][0]; 
 	}
	$siglaP		=explode(" ",$RsNomUsr['cApellidosTrabajador']);
	for($i = 0, $iMax = count($siglaP); $i < $iMax; $i++){
			$m[$i]	=  	$siglaP[$i];
			$ny		=	$ny.$m[$i][0]; 
 	}  
    
    // armar correlativo
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-PCM/".trim($RsSigla['cSiglaOficina'])."-".strtoupper(trim($nx.$ny));
    }	else {
		$cCodificacion="";
		$cCodTipoDoc=45;
	}  
	$sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgEnvio, nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	cAsunto,           cObservaciones,           fFecPlazo,    fFecRegistro, nFlgEstado,	 	iCodTrabajadorSolicitado	)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(1,2,2,'$cCodificacion','".$_SESSION['CODIGO_TRABAJADOR']."','".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '$fFecActual', '".$_POST['cAsuntoDerivar']."', '".$_POST['cObservacionesDerivar']."', '$fFecPlazo', '$fFecActual',1, '".$_SESSION['JEFE']."')";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite , nFlgClaseDoc FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
		$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."'";
		$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
		$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
		
		// Movimiento generado para el documento creado por derivacion
	$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    			$sqlAdMv.="(iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,  iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,iCodIndicacionDerivar,cPrioridadDerivar,   cAsuntoDerivar,           cObservacionesDerivar,            fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento)";
    			$sqlAdMv.=" VALUES ";
    			$sqlAdMv.="('".$RsUltTra['iCodTramite']."', '".$_SESSION['CODIGO_TRABAJADOR']."',2, '".$_SESSION['iCodOficinaLogin']."', '".$_POST['iCodOficinaDerivar']."', '".$_POST['iCodTrabajadorDerivar']."', '".$_POST['iCodIndicacionDerivar']."', 'Media','".$_POST['cAsuntoDerivar']."', '".$_POST['cObservacionesDerivar']."', '$fFecActual', '$fFecActual',  1, 						   1)";
    			$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
		
			// cambiar de estado al movimiento
   	$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=2 WHERE iCodMovimiento='".$_POST['iCodMovimientoAccion']."'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		
		$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".$_POST['iCodMovimientoAccion']."'");
		$RsMovData=sqlsrv_fetch_array($rsMovData);
		
		$sqlPerf=" SELECT iCodPerfil FROM Tra_M_Trabajadores WHERE iCodTrabajador = '".$_POST['iCodTrabajadorDerivar']."' ";
		$rsPerf=sqlsrv_query($cnx,$sqlPerf);
		$RsPerf=sqlsrv_fetch_array($rsPerf);
		// verificar si es un profesional
		if($RsPerf['iCodPerfil']!=4){
		// Movimiento generado para el documento principal	
	$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
		$sqlMov.="(iCodTramite, iCodTrabajadorRegistro, nFlgTipoDoc, iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,           iCodIndicacionDerivar,           cCodTipoDocDerivar,    cAsuntoDerivar,					  cObservacionesDerivar,    			fFecDerivar,	 cNumDocumentoDerivar,  nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento,       iCodTramiteDerivar)";
		$sqlMov.=" VALUES ";
		$sqlMov.="('".$RsMovData['iCodTramite']."', '".$_SESSION['CODIGO_TRABAJADOR']."',' ".$RsMovData['nFlgTipoDoc']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['iCodOficinaDerivar']."', '".$_POST['iCodTrabajadorDerivar']."', '".$_POST['iCodIndicacionDerivar']."', '$cCodTipoDoc', '".$_POST['cAsuntoDerivar']."', '".$_POST['cObservacionesDerivar']."', '$fFecActual', '$cCodificacion',      1,                '$fFecActual',   1,           1,	'".$RsUltTra['iCodTramite']."')";
	$rsMov=sqlsrv_query($cnx,$sqlMov);
	} else {
	/// Movimiento de ejemplo
	$sqlTJefe=" SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina = '".$_POST['iCodOficinaDerivar']."' and nFlgEstado =1 and iCodCategoria =5 ";
	$rsTJefe=sqlsrv_query($cnx,$sqlTJefe);
	$RsTJefe=sqlsrv_fetch_array($rsTJefe);
	// Movimiento generado para el documento principal	
	$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
		$sqlMov.="(iCodTramite,               iCodTrabajadorRegistro,         nFlgTipoDoc, 	 iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar, iCodTrabajadorDelegado,  fFecDelegado, iCodIndicacionDerivar, iCodIndicacionDelegado ,   cObservacionesDelegado,    cCodTipoDocDerivar,    cAsuntoDerivar,	cObservacionesDerivar,   fFecDerivar,	 cNumDocumentoDerivar,  nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento,       iCodTramiteDerivar)";
		$sqlMov.=" VALUES ";
	$sqlMov.="('".$RsMovData['iCodTramite']."', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$RsMovData['nFlgTipoDoc']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['iCodOficinaDerivar']."','".$RsTJefe['iCodTrabajador']."' , '".$_POST['iCodTrabajadorDerivar']."','$fFecActual', '".$_POST['iCodIndicacionDerivar']."', '".$_POST['iCodIndicacionDerivar']."', '".$_POST['cObservacionesDerivar']."', '$cCodTipoDoc', '".$_POST['cAsuntoDerivar']."', '".$_POST['cObservacionesDerivar']."', '$fFecActual', '$cCodificacion',      3,                '$fFecActual',   1,           1,	'".$RsUltTra['iCodTramite']."')";
   	$rsMov=sqlsrv_query($cnx,$sqlMov);
	}	

    if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}Else{
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('".$RsUltTra['iCodTramite']."', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}
   	
//		header("Location: profesionalPendientes.php");
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=profesionalPendientes.php>";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=cDescTipoDoc value=\"".$RsTipDoc['cDescTipoDoc']."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual2."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=\"".$RsUltTra['nFlgClaseDoc']."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>"; 
				
	break;
	case 9: //eliminar variable
		 unset($_SESSION['cCodSessionDrv']);
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=profesionalPendientes.php>";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
	 case 10:
		$sqlUpdTra="UPDATE Tra_M_Tramite_Movimientos SET iCodOficinaDerivar='$_POST[iCodOficinaDerivar]', iCodTrabajadorDerivar='".$_POST['iCodTrabajadorDerivar']."', cAsuntoDerivar='$_POST[cAsuntoDerivar]', cObservacionesDerivar='$_POST[cObservacionesDerivar]', iCodIndicacionDerivar='$_POST[iCodIndicacionDerivar]' WHERE iCodMovimiento='".$_POST['iCodMovimiento']."'";
		$rsUpdTra=sqlsrv_query($cnx,$sqlUpdTra);
		
		header("Location: profesionalDerivados.php");  
	break;
	}
	
	if($_GET['opcion']==10){ //anular respondido
		$sqlMov="UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=3, cCodTipoDocResponder=NULL, iCodTrabajadorResponder=NULL, cAsuntoResponder=NULL, cObservacionesResponder=NULL, iCodDigitalResponder=NULL, fFecResponder=NULL  WHERE iCodMovimiento='".$_GET['iCodMovimiento']."'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		header("Location: profesionalRespondidos.php");
	}
	if($_GET['opcion']==11){ //anular finalizado
		$sqlMov="UPDATE Tra_M_Tramite_Movimientos 
						 SET nEstadoMovimiento = 3, 
						 		iCodTrabajadorFinalizar = NULL, 
					 			cObservacionesFinalizar = NULL, 
					 			fFecFinalizar = NULL
						 WHERE iCodMovimiento='".$_GET['iCodMovimiento']."'";
		$rsUpdMov=sqlsrv_query($cnx,$sqlMov);
		header("Location: profesionalFinalizados.php");
	}
}Else{
	header("Location: ../index-b.php?alter=5");
}
?>