<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
	include_once("../conexion/conexion.php");
	$fFecActual=date("Ymd")." ".date("G:i:s"); 
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
  switch ($_POST[opcion]) {
  case 1: //registro de documentos de entrada //////////////////////////////////////////////////////
  	$nCodBarra=rand(1000000000,9999999999);
  
  	$max_chars=round(rand(5,10));  
		$chars=array();
		for($i="a";$i<"z";$i++){
  		$chars[]=$i;
  		$chars[]="z";
		}
		for ($i=0; $i<$max_chars; $i++){
  		$letra=round(rand(0, 1));
  		if ($letra){ 
 				$clave.= $chars[round(rand(0,count($chars)-1))];
  		}else{ 
 				$clave.= round(rand(0, 9));
  		}
		}
		$cPassword=$clave;
		
    	$rsCorr=sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo FROM Tra_M_Correlativo WHERE nFlgTipoDoc=1 AND nNumAno='$nNumAno'");
		$RsCorr=sqlsrv_fetch_array($rsCorr);
		$CorrelativoAsignar=$RsCorr[nCorrelativo]+1;
		
		$rsCorrConcurso=sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo FROM Tra_M_Correlativo_Concurso WHERE nFlgTipoDoc=1 AND nConcurso=6 AND nNumAno='$nNumAno'");
		$RsCorrConcurso=sqlsrv_fetch_array($rsCorrConcurso);
		$ConcursoAsignar=$RsCorrConcurso[nCorrelativo]+1;
		
		$rsUpdCorr=sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo SET nCorrelativo='$CorrelativoAsignar' WHERE nFlgTipoDoc=1 AND nNumAno='$nNumAno'");
		
		$rsUpdCorrConcurso=sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo_Concurso SET nCorrelativo='$ConcursoAsignar' WHERE nFlgTipoDoc=1 AND nConcurso=6 AND nNumAno='$nNumAno'");
		
		$cCodificacion=date("Y").add_ceros($CorrelativoAsignar,5);
		$CodConcurso="CPOR-2-".add_ceros($ConcursoAsignar,4);
  	
   if ($_POST[nFlgClaseDoc] == 2){ //sql sin tupa
		$cNroDocumento	= stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
		$cNomRemite		  = stripslashes(htmlspecialchars($_POST[cNomRemite], ENT_QUOTES));
		$cAsunto		    = stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
		$cObservaciones	= stripslashes(htmlspecialchars($_POST[cObservaciones], ENT_QUOTES));
		$nNumFolio		  = stripslashes(htmlspecialchars($_POST[nNumFolio], ENT_QUOTES));
		$cReferencia	  = stripslashes(htmlspecialchars($_POST[cReferencia], ENT_QUOTES));
		$archivoFisico	= stripslashes(htmlspecialchars($_POST[archivoFisico], ENT_QUOTES));
		//  Sql es ejecutado en SP
			
			if($_POST[nFlgEnvio]==""){
			$_POST[nFlgEnvio]=1;
			}
			else  if($_POST[nFlgEnvio]==1){
			$_POST[nFlgEnvio]="";
			}
			
			$sqlAdd.="SP_DOC_ENTRADA_SIN_TUPA_INSERT '$cCodificacion','".$_SESSION['CODIGO_TRABAJADOR']."','".$_SESSION['iCodOficinaLogin']."','$_POST[cCodTipoDoc]','$fFecActual','$cNroDocumento','$_POST[iCodRemitente]','$cNomRemite','$cAsunto','$cObservaciones','$cReferencia','$_POST[iCodIndicacion]','$nNumFolio','$_POST[nTiempoRespuesta]','$_POST[nFlgEnvio]','$fFecActual','$nCodBarra','$cPassword','$_POST[fechaDocumento]','$archivoFisico' ";
    }
    
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //echo $sqlAdd;
    
    $rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite WHERE iCodTrabajadorRegistro='".$_SESSION['CODIGO_TRABAJADOR']."' and iCodOficinaRegistro='".$_SESSION['iCodOficinaLogin']."' ORDER BY iCodTramite DESC");
	$RsUltTra=sqlsrv_fetch_array($rsUltTra);
	
	$rsUpdTraConcurso=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET cCodConcurso='$CodConcurso' WHERE iCodTramite='$RsUltTra[iCodTramite]' ");
    
   	if($_POST[iCodOficinaResponsable]!=""){
//  Sql es ejecutado en SP			
				$sqlMov="SP_DOC_ENTRADA_MOVIMIENTO_INSERT '$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST[iCodIndicacion]', '$fFecActual',  '$fFecActual',   '$_POST[nFlgEnvio]'";
   			$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}
   	
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
				if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}Else{
						$nuevo_nombre = $cCodificacion."-".$RsUltTra[iCodTramite].".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}	
		$fFecActual=date("d-m-Y G:i"); 
	echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroConcluidoC.php>";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=cConcurso value=\"".$CodConcurso."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=\"".$_POST[nFlgClaseDoc]."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
 
	
	}
	
	if($_GET[opcion]==6){ //retirar movimientos oficinas
		$sqlX="DELETE FROM Tra_M_Tramite_Temporal WHERE iCodTemp='$_GET[iCodTemp]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficina.php#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_GET[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
   			echo "<input type=hidden name=iCodIndicacion value=\"".$_GET[iCodIndicacion]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_GET[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_GET[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
   			echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}
	
	if($_GET[opcion]==7){ //retirar movimientos oficinas (edit)
		$sqlX="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$_GET[iCodMovimiento]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficinaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."clear=1#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_GET[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
   			echo "<input type=hidden name=iCodIndicacion value=\"".$_GET[iCodIndicacion]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_GET[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_GET[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}
	
	if($_GET[opcion]==13){ //retirar adjunto
		$sqlFiles="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'"; 
		$rsFiles=sqlsrv_query($cnx,$sqlFiles);
		$RsFiles=sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload.trim($RsFiles[cNombreNuevo]))){ 
   	     unlink($rutaUpload.trim($RsFiles[cNombreNuevo])); 
	   }
    $rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'");
		header("Location: registroSinTupaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}	

	if($_GET[opcion]==14){ //retirar adjunto
		$sqlFiles="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'"; 
		$rsFiles=sqlsrv_query($cnx,$sqlFiles);
		$RsFiles=sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload.trim($RsFiles[cNombreNuevo]))){ 
   	     unlink($rutaUpload.trim($RsFiles[cNombreNuevo])); 
	   }
    $rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'");
		header("Location: registroConTupaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}	
	
	if($_GET[opcion]==15){ //retirar adjunto
		$sqlFiles="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'"; 
		$rsFiles=sqlsrv_query($cnx,$sqlFiles);
		$RsFiles=sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload.trim($RsFiles[cNombreNuevo]))){ 
   	     unlink($rutaUpload.trim($RsFiles[cNombreNuevo])); 
	   }
    $rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'");
		header("Location: registroAnexoEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}	
	
	if($_GET[opcion]==16){ //retirar adjunto intrno oficinas
		$sqlFiles="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'"; 
		$rsFiles=sqlsrv_query($cnx,$sqlFiles);
		$RsFiles=sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload.trim($RsFiles[cNombreNuevo]))){ 
   	     unlink($rutaUpload.trim($RsFiles[cNombreNuevo])); 
	   }
    $rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'");
		header("Location: registroOficinaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}		

	if($_GET[opcion]==17){ //retirar adjunto intrno oficinas
		$sqlFiles="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'"; 
		$rsFiles=sqlsrv_query($cnx,$sqlFiles);
		$RsFiles=sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload.trim($RsFiles[cNombreNuevo]))){ 
   	     unlink($rutaUpload.trim($RsFiles[cNombreNuevo])); 
	   }
    $rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'");
		header("Location: registroTrabajadorEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}		

	if($_GET[opcion]==18){ //retirar adjunto salida
		$sqlFiles="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'"; 
		$rsFiles=sqlsrv_query($cnx,$sqlFiles);
		$RsFiles=sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload.trim($RsFiles[cNombreNuevo]))){ 
   	     unlink($rutaUpload.trim($RsFiles[cNombreNuevo])); 
	   }
    $rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'");
		header("Location: registroSalidaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}
  if($_GET[opcion]==19){ //retirar referencia
		$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='$_GET[iCodReferencia]'");
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
    if($_GET[sal]==3){
    echo "<form method=POST name=form_envio action=registroSalida.php#area>";
	}
	else if($_GET[sal]==4){
    echo "<form method=POST name=form_envio action=registroEspecial.php#area>";
	}else{
   	echo "<form method=POST name=form_envio action=registroOficina.php#area>";
	}
   	echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
   	echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   	echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
   	echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
	echo "<input type=hidden name=cNombreRemitente value=\"".$_GET[cNombreRemitente]."\">";
	echo "<input type=hidden name=cNomRemite value=\"".$_GET[cNomRemite]."\">";
	echo "<input type=hidden name=iCodRemitente value=\"".$_GET[iCodRemitente]."\">";
	echo "<input type=hidden name=Remitente value=\"".$_GET[Remitente]."\">";			
   	echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
   	echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
		echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">";
   	echo "</form>";
   	echo "</body>";
   	echo "</html>";
	}
  if($_GET[opcion]==20){ //retirar referencia
		$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='$_GET[iCodReferencia]'");
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
	if($_GET[sal]==3){
	echo "<form method=POST name=form_envio action=registroSalidaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI].">";
	}
	else if($_GET[sal]==4){
	echo "<form method=POST name=form_envio action=registroEspecialEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI].">";
	}else {
   	echo "<form method=POST name=form_envio action=registroOficinaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI].">";
	}
	echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
   	echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   	echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
   	echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
   	echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
   	echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
		echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">";
   	echo "</form>";
   	echo "</body>";
   	echo "</html>";
	}	
	if($_GET[opcion]==21){ //retirar movimientos oficinas
		$sqlX="DELETE FROM Tra_M_Tramite_Temporal WHERE iCodTemp='$_GET[iCodTemp]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroSalida.php#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_GET[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_GET[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
   			echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">";
   			echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}
	if($_GET[opcion]==22){ //retirar movimientos salida (edit)
		$sqlX="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$_GET[iCodMovimiento]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroSalidaCopy.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."clear=1#area>";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}	
	if($_GET[opcion]==23){ //retirar interno oficina
		
		$sqlUpd="UPDATE Tra_M_Correlativo_Oficina SET nCorrelativo='$_GET[nCorrelativo]' WHERE iCodCorrelativo='$_GET[iCodCorrelativo]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
		$sqlY="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]'";
		$rsY=sqlsrv_query($cnx,$sqlY);
			
		$sqlX="DELETE FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=GET name=form_envio action=".$_GET[URI].">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}
	if($_GET[opcion]==24){ //retirar movimientos oficinas
		$sqlX="DELETE FROM Tra_M_Tramite_Temporal WHERE iCodTemp='$_GET[iCodTemp]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=pendientesControlDerivar.php?clear=1#area>";
			 if ($_GET[iCodMovimientoAccion]==""){ 
            $a=stripslashes($_GET[MovimientoAccion]);
            $MovimientoAccion=unserialize($a);
			$i = 0; 
			foreach ($MovimientoAccion as $v) {
	      	echo "<input type=hidden name=MovimientoAccion[] value=\"".$v."\">";
            	}            
			}
			if ($_GET[iCodMovimientoAccion]!=""){ 					    
            echo "<input type=hidden name=iCodMovimientoAccion value=\"".$_GET[iCodMovimientoAccion]."\">";
            } 
   			echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   			echo "<input type=hidden name=iCodOficinaDerivar value=\"".$_GET[iCodOficinaDerivar]."\">";
   			echo "<input type=hidden name=iCodTrabajadorDerivar value=\"".$_GET['iCodTrabajadorDerivar']."\">";
   			echo "<input type=hidden name=iCodIndicacionDerivar value=\"".$_GET[iCodIndicacionDerivar]."\">";
   			echo "<input type=hidden name=cAsuntoDerivar value=\"".$_GET[cAsuntoDerivar]."\">";
   			echo "<input type=hidden name=cObservacionesDerivar value=\"".$_GET[cObservacionesDerivar]."\">";
   			echo "<input type=hidden name=nFlgCopias value=\"".$_GET[nFlgCopias]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}	
	if($_GET[opcion]==25){ //retirar movimientos oficinas
		$sqlX="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$_GET[iCodTemp]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=GET name=form_envio action=pendientesDerivadosEdit.php>";
   			echo "<input type=hidden name=iCodMovimientoDerivar value=\"".$_GET[iCodMovimientoDerivar]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}	
	if($_GET[opcion]==26){ //retirar copias sin Tupa
		$sqlDel="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento=".$id;
		$rsDel=sqlsrv_query($cnx,$sqlDel);
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=GET name=form_envio action=registroSinTupaEdit.php#area>";
	echo "<input type=hidden name=iCodTramite value=\"".$idt."\">";
	echo "<input type=hidden name=URI value=\"".$URI."\">";
	echo "</form>";
   	echo "</body>";
   	echo "</html>";
	}
	if($_GET[opcion]==27){ //retirar referencia
		$sqlDel="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento=".$id;
		$rsDel=sqlsrv_query($cnx,$sqlDel);
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=GET name=form_envio action=registroConTupaEdit.php#area>";
	echo "<input type=hidden name=iCodTramite value=\"".$idt."\">";
	echo "<input type=hidden name=URI value=\"".$URI."\">";
   	echo "</form>";
   	echo "</body>";
   	echo "</html>";
	}
	if($_GET[opcion]==28){ //retirar referencia
	$sqlUpd="UPDATE Tra_M_Correlativo_Salida SET nCorrelativo='$_GET[nCorrelativo]' WHERE iCodCorrelativo='$_GET[iCodCorrelativo]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
		$sqlY="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]'";
		$rsY=sqlsrv_query($cnx,$sqlY);
		
		$sqlZ="DELETE FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite='$_GET[iCodTramite]'";
		$rsZ=sqlsrv_query($cnx,$sqlZ);
			
		$sqlX="DELETE FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		
		    echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=GET name=form_envio action=".$_GET[URI].">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	}
}Else{
	header("Location: ../index-b.php?alter=5");
}


?>