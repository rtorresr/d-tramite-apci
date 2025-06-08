<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
	include_once("../conexion/conexion.php");
	$fFecActual = date("Ymd")." ".date("G:i:s"); 
	$rutaUpload = "../cAlmacenArchivos/";
	$nNumAno    = date("Y");
	
  function add_ceros($numero,$ceros) {
    $order_diez = explode(".",$numero);
    $dif_diez = $ceros - strlen($order_diez[0]);
    for($m=0; $m<$dif_diez; $m++){
    	@$insertar_ceros .= 0;
    }
    return $insertar_ceros .= $numero;
  }

  switch ($_POST['opcion']) {
  	case 1: //registro de documentos de entrada //////////////////////////////////////////////////////
  		if($_SESSION[cCodRef]==""){
	  		$Fecha = date("Ymd-Gis");	
	  		$_SESSION['cCodRef']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$Fecha;
	  	}
  		$nCodBarra = rand(1000000000,9999999999);
  
  		$max_chars = round(rand(5,10));  
			$chars = array();
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
			$cPassword = $clave;
	
    	$rsCorr = sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo 
    					   						 FROM Tra_M_Correlativo 
    					   						 WHERE nFlgTipoDoc = 1 AND nNumAno='$nNumAno'");

			$RsCorr = sqlsrv_fetch_array($rsCorr);
			$CorrelativoAsignar = $RsCorr[nCorrelativo]+1;
		
			$rsUpdCorr = sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo 
							  								SET nCorrelativo='$CorrelativoAsignar' 
							  								WHERE nFlgTipoDoc = 1 AND nNumAno='$nNumAno'");
	
			// ORIGINAL		
			// $cCodificacion = date("Y").add_ceros($CorrelativoAsignar,5);

			// INICIO DE MODIFICACION
			$sqlSede = "SELECT TD.CODIGO_SEDE AS 'CODIGO_SEDE' FROM Tra_M_Trabajadores TT
									INNER JOIN Tra_U_Departamento TD ON TT.CODIGO_SEDE = TD.CODIGO_SEDE
									WHERE TT.iCodTrabajador = '".$_SESSION['CODIGO_TRABAJADOR']."'";
			$rsSede = sqlsrv_query($cnx,$sqlSede);
			$RsSede = sqlsrv_fetch_array($rsSede);
			$codigo_sede = $RsSede['CODIGO_SEDE'];

    	$year = substr(date("Y"), -2);
    	$cCodificacion = "E".add_ceros($CorrelativoAsignar,5).$year.$codigo_sede;
    	// FIN DE MODIFICACION
  	
    	if ($_POST[nFlgClaseDoc] == 1){ //sql con tupa
				//  Sql es ejecutado en SP
				$cNroDocumento	= stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
				$cNomRemite		  = stripslashes(htmlspecialchars($_POST[cNomRemite], ENT_QUOTES));
				$cAsunto		    = stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
				$cObservaciones	= stripslashes(htmlspecialchars($_POST[cObservaciones], ENT_QUOTES));
				$nNumFolio		  = stripslashes(htmlspecialchars($_POST[nNumFolio], ENT_QUOTES));
				$cReferencia	  = stripslashes(htmlspecialchars($_POST[cReferencia], ENT_QUOTES));
				$archivoFisico	= stripslashes(htmlspecialchars($_POST[archivoFisico], ENT_QUOTES));
		
				if($_POST[nFlgEnvio] == ""){
					$_POST[nFlgEnvio] = 1;
				}else  if($_POST[nFlgEnvio] == 1){
					$_POST[nFlgEnvio] = "";
				}
		
				$cObservaciones = htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES);
      	$sqlAdd = "SP_DOC_ENTRADA_CON_TUPA_INSERT '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$cNroDocumento', '$_POST[iCodRemitente]', '$cNomRemite', '$cAsunto', '$cObservaciones', '$_POST[iCodTupaClase]', '$_POST['iCodTupa']', '$cReferencia', '$_POST[iCodIndicacion]', '$nNumFolio', '$_POST[nTiempoRespuesta]', '$_POST[nFlgEnvio]',  '$fFecActual', '$nCodBarra', '$cPassword','$_POST[fechaDocumento]','$archivoFisico'";
    	}
    
    	if ($_POST[nFlgClaseDoc] == 2){ //sql sin tupa
				$cNroDocumento	= stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
				$cNomRemite		  = stripslashes(htmlspecialchars($_POST[cNomRemite], ENT_QUOTES));
				$cAsunto		    = stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
				$cObservaciones	= stripslashes(htmlspecialchars($_POST[cObservaciones], ENT_QUOTES));
				$nNumFolio		  = stripslashes(htmlspecialchars($_POST[nNumFolio], ENT_QUOTES));
				$cReferencia	  = stripslashes(htmlspecialchars($_POST[cReferencia], ENT_QUOTES));
				$archivoFisico	= stripslashes(htmlspecialchars($_POST[archivoFisico], ENT_QUOTES));
		
				if ($_POST[nFlgEnvio] == ""){
					$_POST[nFlgEnvio] = 1;
				}else  if ($_POST[nFlgEnvio] == 1){
					$_POST[nFlgEnvio] = "";
				}
				//  Sql es ejecutado en SP
				$sqlAdd.="SP_DOC_ENTRADA_SIN_TUPA_INSERT '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$cNroDocumento', '$_POST[iCodRemitente]', '$cNomRemite', '$cAsunto', '$cObservaciones', '$cReferencia', '$_POST[iCodIndicacion]', '$nNumFolio', '$_POST[nTiempoRespuesta]', '$_POST[nFlgEnvio]','$fFecActual',  '$nCodBarra', '$cPassword','$_POST[fechaDocumento]','$archivoFisico'";
    	}
    	$rs = sqlsrv_query($cnx,$sqlAdd);
    
    	$rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite 
    													 WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."' 
    													 ORDER BY iCodTramite DESC");
			$RsUltTra = sqlsrv_fetch_array($rsUltTra);
	    
    	for ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      	$iCodTupaRequisito= $_POST[iCodTupaRequisito];
				//  Sql es ejecutado en SP
				$sqlIns="SP_DOC_ENTRADA_REQ_CON_TUPA_INSERT '$iCodTupaRequisito[$h]', '$RsUltTra[iCodTramite]' ";     	
				//	$sqlIns="INSERT INTO Tra_M_Tramite_Requisitos (iCodTupaRequisito, iCodTramite) VALUES ('$iCodTupaRequisito[$h]', '$RsUltTra[iCodTramite]') ";
   			$rsIns = sqlsrv_query($cnx,$sqlIns);
			}
		
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
	//////////////////////////////////////////////////////
	// 	$sqlIns="select * from Tra_M_Tramite_Referencias where cCodSession=".$_SESSION[cCodRef];
	//	$rsDigt=sqlsrv_query($cnx,$sqlDigt);
	$sqlRefcnt="select count(iCodReferencia) as CntRef from Tra_M_Tramite_Referencias where cCodSession='".$_SESSION[cCodRef]."'";
	//echo $sqlRefcnt;
	$rsCnT1=sqlsrv_query($cnx,$sqlRefcnt);
	$RsCnT2=sqlsrv_fetch_array($rsCnT1);
	$conteo2=$RsCnT2[0];
	
if ($conteo2>=1){
	$sqlTraF="SELECT TOP 1 iCodTramite FROM Tra_M_Tramite where iCodTrabajadorRegistro='".$_SESSION['CODIGO_TRABAJADOR']."' order by fFecRegistro desc";
	$rsTraf1=sqlsrv_query($cnx,$sqlTraF);
	$RsTraf2=sqlsrv_fetch_array($rsTraf1);
	
	$sqlUptRef="UPDATE Tra_M_Tramite_Referencias   SET iCodTramite = '".$RsTraf2[0]."'  WHERE cCodSession='".$_SESSION[cCodRef]."'";
	$rsUptr = sqlsrv_query($cnx,$sqlUptRef);
	}

	unset($_SESSION[cCodRef]);
	echo "<html>";
	echo "<head>";
	echo "</head>";
	echo "<body OnLoad=\"document.form_envio.submit();\">";
	echo "<form method=POST name=form_envio action=registroConcluido.php>";
	echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
	echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
	echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
	echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
	echo "<input type=hidden name=nFlgClaseDoc value=\"".$_POST[nFlgClaseDoc]."\">";
	
	if($nFlgRestricUp == 1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}
	echo "</form>";
	echo "</body>";
	echo "</html>";
	break;
  case 2: //registrar interno oficinas
  	if ($_POST[fFecPlazo]!=""){
  		$separado2 = explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo = "'".$separado2[2].$separado2[1].$separado2[0]."'";
    }else{
    	$fFecPlazo = "NULL";
    }
   
    // comprobar o recoger correlativo
    $sqlCorr = "SELECT * FROM Tra_M_Correlativo_Oficina 
    					  WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' 
    				          AND iCodOficina='".$_SESSION['iCodOficinaLogin']."'
    				          AND nNumAno='$nNumAno'";
    $rsCorr  = sqlsrv_query($cnx,$sqlCorr);
    
    if (sqlsrv_has_rows($rsCorr) > 0){
    	$RsCorr       = sqlsrv_fetch_array($rsCorr);
    	$nCorrelativo = $RsCorr[nCorrelativo]+1;
    	
    	$sqlUpd = "UPDATE Tra_M_Correlativo_Oficina 
    			       SET nCorrelativo='$nCorrelativo' 
    			       WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
    	$rsUpd  = sqlsrv_query($cnx,$sqlUpd);
    }else{
    	$sqlAdCorr = "INSERT INTO Tra_M_Correlativo_Oficina (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    	$rsAdCorr = sqlsrv_query($cnx,$sqlAdCorr);
    	$nCorrelativo = 1;
    }
    
    //leer sigla oficina
    $rsSigla = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    $RsSigla = sqlsrv_fetch_array($rsSigla);
    
    // armar correlativo
    // ORIGINAL
    $cCodificacion = add_ceros($nCorrelativo,5)."-".date("Y")."/".trim($RsSigla[cSiglaOficina]);

    // Inicio para generar el correlativo interno (Ej I000271701)
    $rsSede = sqlsrv_query($cnx,"SELECT CODIGO_SEDE FROM Tra_M_Trabajadores WHERE iCodTrabajador=".$_SESSION['CODIGO_TRABAJADOR']);
    $RsSede = sqlsrv_fetch_array($rsSede);

    $rsCorrI = sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo FROM Tra_M_Correlativo WHERE nFlgTipoDoc='9' AND nNumAno='$nNumAno'");
		$RsCorrI = sqlsrv_fetch_array($rsCorrI);
		$CorrelativoAsignarI = $RsCorrI['nCorrelativo'] + 1;
		$rsUpdCorrI = sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo 
															 SET nCorrelativo=$$CorrelativoAsignarI 
															 WHERE nFlgTipoDoc='9' AND nNumAno='$nNumAno'");

		$year = substr(date("Y"), -2);
    $cCodificacionI = "I".add_ceros($CorrelativoAsignarI,5).$year.$RsSede['CODIGO_SEDE'];
    // Fin para generar el correlativo interno (Ej I000271701)

    // Jefe de Oficina 
    $rsJefe = sqlsrv_query($cnx,"SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' And nFlgEstado=1 AND iCodCategoria='5' ");
		$RsJefe = sqlsrv_fetch_array($rsJefe);
	
		//  Sql es ejecutado en SP
		// if ($_POST['nFlgEnvio'] == ""){
		// 	$_POST['nFlgEnvio'] = 1;
		// }else if($_POST['nFlgEnvio'] == 1){	
		// }

		// Con la mejora, la variable $_POST['nFlgEnvio'] siempre tendrá el valor de "0" para que esté pendiente
		// Pero cuando el jefe lo apruebe, entonces cambiará al valor de "1" que es aprobado.

		$sqlAdd.=" SP_DOC_ENTRADA_INTERNO_INSERT '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."','$_POST[cCodTipoDoc]', '$fFecActual', '$RsJefe[iCodTrabajador]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[nFlgEnvio]', '$fFecActual','$_POST[cSiglaAutor]', '".str_replace( '\"', '"', $_POST[descripcion])."','$_POST[archivoFisico]'";
    $rs = sqlsrv_query($cnx,$sqlAdd);
    
		///////////////////
		$sqlCodTramite = "SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC";
		$rsCodTramite  = sqlsrv_query($cnx,$sqlCodTramite);
		$RsCodTramite  = sqlsrv_fetch_array($rsCodTramite);

		$sqlUpdate = "UPDATE Tra_M_Tramite
					  SET cCodificacionI = '$cCodificacionI'
					  WHERE iCodTramite = $RsCodTramite[iCodTramite]";
		$rslUpdate = sqlsrv_query($cnx,$sqlUpdate);
	///////////////////

		//Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."' ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
		
		$sqlMv="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodOfi]' ORDER BY iCodTemp ASC";
    	$rsMv=sqlsrv_query($cnx,$sqlMv);
   			
		if (isset($_POST['Copia'])){
  		 $Copia = $_POST['Copia']; 
  		 $n        = count($Copia);
  		 $h        = 0;
		 
		}
	    while ($RsMv=sqlsrv_fetch_array($rsMv)){

		//  Sql es ejecutado en SP
			$x=1;
			for ($h=0;$h<$n;$h++){
			if($RsMv[iCodTemp]==$Copia[$h]  ){   //  Seleccion de Copia
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
		$sqlPerf=" SELECT iCodPerfil FROM Tra_M_Trabajadores WHERE iCodTrabajador = '$RsMv[iCodTrabajador]' ";
		$rsPerf=sqlsrv_query($cnx,$sqlPerf);
		$RsPerf=sqlsrv_fetch_array($rsPerf);
		// verificar si es un profesional
		if($RsPerf[iCodPerfil]!=4){
	
		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar,   iCodIndicacionDerivar,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,  cFlgOficina)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$RsMv['iCodOficina']', '$RsMv[iCodTrabajador]', '$RsMv[iCodIndicacion]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1, 				'$cFlgTipoMovimiento',1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
		}else {
	$sqlTJefe=" SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina = '$RsMv['iCodOficina']' and nFlgEstado =1 and iCodCategoria =5 ";
		$rsTJefe=sqlsrv_query($cnx,$sqlTJefe);
		$RsTJefe=sqlsrv_fetch_array($rsTJefe);
		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar, iCodTrabajadorDelegado, fFecDelegado, iCodIndicacionDerivar, iCodIndicacionDelegado ,cObservacionesDelegado,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,  cFlgOficina)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$RsMv['iCodOficina']'  ,'$RsTJefe[iCodTrabajador]', '$RsMv[iCodTrabajador]', '$fFecActual' , '$RsMv[iCodIndicacion]', '$RsMv[iCodIndicacion]', '$_POST[cObservaciones]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual', 3, 				'$cFlgTipoMovimiento',1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
		}
   }
	//$sqlAdMv="SP_DOC_ENTRADA_MOV_INTERNO_INSERT '$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     '".$_SESSION['iCodOficinaLogin']."', '$RsMv['iCodOficina']', '$RsMv[iCodTrabajador]', '$RsMv[iCodIndicacion]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual' ";
		
    
    // relacion por ferencias
    $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodRef]'";
    $rsRefs=sqlsrv_query($cnx,$sqlRefs);
    if(sqlsrv_has_rows($rsRefs)>0){
    	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
				$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
				if(sqlsrv_has_rows($rsBusRef)>0){
					$RsBusRef=sqlsrv_fetch_array($rsBusRef);
					if($RsBusRef[nFlgTipoDoc]==1){						
							$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodOfi]'";
		    			$rsMv2=sqlsrv_query($cnx,$sqlMv2);
		    			$RsMv2=sqlsrv_fetch_array($rsMv2);
		
							//  Sql es ejecutado en SP
							//  El SP esta desarrollado pero no se ha hecho el reemplazo en las lineas de abajo porque no se sabe como probrar 
						//  $sqlAdRf.="SP_DOC_ENTRADA_MOV_INTERNO_REF_INSERT '$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual'  )";
		
							$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
		    			$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento	,			iCodTramiteDerivar)";
		    			$sqlAdRf.=" VALUES ";
		    			$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual',   1, 						    5	,			'$RsUltTra[iCodTramite]')";
		    			$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
		    	}
				}
				$sqlUpdR="UPDATE Tra_M_Tramite_Referencias SET iCodTramite='$RsUltTra[iCodTramite]', cDesEstado='REGISTRADO' WHERE iCodReferencia='$RsRefs[iCodReferencia]'";
				$rsUpdR=sqlsrv_query($cnx,$sqlUpdR);
    	}
    }
    
 //    $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
	// $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
	// $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			  
 //    if($_FILES['fileUpLoadDigital']['name']!=""){
 //  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
 //  			$num = count($extension)-1;
 //  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
	// 			if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
	// 					$nFlgRestricUp=1;
 //   			}else{
	// 					$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
	// 					move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
	// 					$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
 //   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
 //   			}
 //  	}

  	//****DOCUMENTO ELECTRONICO PDF GENERADO
  // 	if($_FILES['documentoElectronicoPDF']['name']!=""){
  // 		$extension = explode(".",$_FILES['documentoElectronicoPDF']['name']);
  // 		$num = count($extension)-1;
  // 		$cNombreOriginal=$_FILES['documentoElectronicoPDF']['name'];
		// if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
		// 	$nFlgRestricUp=1;
  //  		}else{
		// 	//$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
		// 	$PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'documentos'.DIRECTORY_SEPARATOR;
		// 	move_uploaded_file($_FILES['documentoElectronicoPDF']['tmp_name'], "$PDF_DIR"."prueba111.pdf");
						
		// 	// $sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
  //  // 			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
  //  		}
  // 	}

  // 	//****DOCUMENTO ELECTRONICO PDF GENERADO

  // 		$tramitePDF=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$RsUltTra[iCodTramite]'");
  // 		$RsTramitePDF=sqlsrv_fetch_object($tramitePDF);
  // 		if($RsTramitePDF->descripcion != ' ' AND $RsTramitePDF->descripcion != NULL){

		// 	$rsJefe=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTramitePDF->iCodTrabajadorRegistro'");
	 //        $RsJefe=sqlsrv_fetch_array($rsJefe);
	 //        if (!empty($RsJefe['firma'])) { 
	 //        	$img=base64_encode($RsJefe['firma']); 
	 //        	$imgd='<img src="data:image/png;charset=utf8;base64,'.$img.'"/>';
		//     }else{
		//     	$imgd='';
		//     }
	          

	 //        $sqlM1="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
	 //        $rsM1=sqlsrv_query($cnx,$sqlM1);

	 //        if(sqlsrv_has_rows($rsM1)>0){
	 //            $RsM1=sqlsrv_fetch_object($rsM1);
	 //            $movFecha=date("d-m-Y h:i:s", strtotime($RsM1->fFecDerivar));
	 //        }else{
	 //        	$movFecha='';
	 //        }

	 //        $sqlOfDerivar="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM1->iCodOficinaDerivar'";
	 //        $rsOfDerivar=sqlsrv_query($cnx,$sqlOfDerivar);
	 //        $RsOfDerivar=sqlsrv_fetch_object($rsOfDerivar);

	 //        //set it to writable location, a place for temp generated PNG files
	 //        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode/temp'.DIRECTORY_SEPARATOR;
	        
	 //        //html PNG location prefix
	 //        $PNG_WEB_DIR = 'phpqrcode/temp/';

	 //        include "phpqrcode/qrlib.php";    
	        
	 //        //ofcourse we need rights to create temp dir
	 //        if (!file_exists($PNG_TEMP_DIR))
	 //            mkdir($PNG_TEMP_DIR);
	      
	 //        //$filename = $PNG_TEMP_DIR.'test.png';

	 //        $errorCorrectionLevel = 'L';   
	 //        $matrixPointSize = 2;
	 //        //$_REQUEST['data']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
	 //         $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/Sistema_Tramite_PCM/views/registroInternoDocumento_pdf.php?iCodTramite='.$RsTramitePDF->iCodTramite;

	 //        // user data
	 //        $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	 //        $filename = $PNG_TEMP_DIR.$codigoQr;
	         
	 //        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

		// 	$content='<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" format="A4"> 
		// 			      <page_header> 
		// 			           <div style=" padding-top: 20px; padding-left: 40px; "><img style="width:300px" src="images/logo-ongei.png" alt="Logo"></div>
		// 			      </page_header> 
		// 			      <page_footer> 
					           
		// 			      </page_footer> 

		// 			      <br><br><br>
		// 			      <div style=" text-align: right; ">'.trim($RsTipDoc['cDescTipoDoc']).' N° '.$RsTramitePDF->cCodificacion.'</div>
		// 			      <br>

		// 			      <table style="width:650px; border: none; font-family:Times;font-size:13.5px;"> <!-- 595px -->
		// 			        <tr>
		// 			          <td style="width:20%">A</td><td style="width:80%">: '.$RsOfDerivar->cSiglaOficina.'</td>
		// 			        </tr>
		// 			        <tr>
		// 			          <td style="width:20%">De</td>
		// 			          <td style="width:80%">: '.$RsJefe["cNombresTrabajador"].' '.$RsJefe["cApellidosTrabajador"].'</td>
		// 			        </tr>
		// 			        <tr>
		// 			          <td style="width:20%">Referencia</td><td style="width:80%"><b>: '.$RsTramitePDF->cReferencia.'</b></td>
		// 			        </tr>

		// 			        <tr>
		// 			          <td style="width:20%">Fecha/H Derivo</td>
		// 			          <td style="width:80%">: '.$movFecha.'</td>
		// 			        </tr>

		// 			        <tr>
		// 			          <td style="width:20%">Asunto</td>
		// 			          <td style="width:80%">: '.$RsTramitePDF->cAsunto.'</td>
		// 			        </tr>
					                      
		// 			      </table>
					      
		// 			      <br><br>
		// 			      <div style="font-family:Times;font-size:13.5px">'.$RsTramitePDF->descripcion.'</div>

		// 			      <div align="right" style=" width: 100%;">
		// 			        <br><br><br><br><br>
		// 			        <div style="width: 30%; text-align: center; ">'.$imgd.'<p>Firma</p>
		// 			        <p>'.$RsJefe["cNombresTrabajador"].' '.$RsJefe["cApellidosTrabajador"].'</p></div>
		// 			      </div>
		// 			      <div><img src="'.$PNG_WEB_DIR.basename($filename).'" />
		// 			      <p style="font-size: 9px">'.$_REQUEST['data'].'</p>
		// 			      </div>
		// 			 </page>';

		//  	// ********************	START Ruta del documento electronico  **************************************************************
		//  	date_default_timezone_set("America/Lima");
		//   	$PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'documentos'.DIRECTORY_SEPARATOR;
		//   	$docElectronico = trim(str_replace('/','', str_replace('. ','', $RsTramitePDF->cCodificacion))).'_'.date("YmdHis").".pdf";
		//   	$nombreArchivo=$PDF_DIR.$docElectronico;
		//   	// ********************	END Ruta del documento electronico  **************************************************************
		//   	sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET codigoQr='$codigoQr' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");
		//   	sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET documentoElectronico='$docElectronico' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");
		    
		//  	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
		// 	try
		// 	{
		// 		$html2pdf = new HTML2PDF('P','A4', 'es', false, 'UTF-8', array(mL, mT, mR, mB));
		// 		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		// 		$html2pdf->Output($nombreArchivo, 'F');
		// 	}
		// 	catch(HTML2PDF_exception $e) { echo $e; }

		// }
  		//****DOCUMENTO ELECTRONICO PDF GENERADO

  	
  //  		unset($_SESSION["cCodRef"]);
		// unset($_SESSION["cCodOfi"]);
		// $fFecActual=date("d-m-Y G:i"); 
		// echo "<html>";
		// echo "<head>";
		// echo "</head>";
	 //    echo "<body OnLoad=\"document.form_envio.submit();\">";
		// echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		// echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		// echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
		// echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		// echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
		// echo "<input type=hidden name=nFlgClaseDoc value=1>";
		// if($nFlgRestricUp==1){
		// echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		// echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
		// }
		// echo "</form>";
		// echo "</body>";
		// echo "</html>";////DESCOMENTE
  	 		unset($_SESSION["cCodRef"]);
		unset($_SESSION["cCodOfi"]);
		$fFecActual=date("d-m-Y G:i"); 
		echo "<html>";
		echo "<head>";
		echo "</head>";
	  echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=\"POST\" name=\"form_envio\" action=\"registroInternoGenerarDocumento.php\">";
		echo "<input type=\"hidden\" name=\"iCodTramite\" value=\"".$RsUltTra[iCodTramite]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";////DESCOMENTE
	break;
  case 3: //añadir movimiento temporal
		$sqlAdd="INSERT INTO Tra_M_Tramite_Temporal ";
    	$sqlAdd.="(iCodOficina,              iCodTrabajador,             iCodIndicacion,            cPrioridad,          cCodSession)";
    	$sqlAdd.=" VALUES ";
    	$sqlAdd.="('$_POST[iCodOficinaMov]','$_POST[iCodTrabajadorMov]','$_POST[iCodIndicacionMov]','$_POST[cPrioridad]','$_SESSION[cCodOfi]')";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficina.php#area>";
   			echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
				echo "<input type=hidden name=cSiglaAutor value=\"".$_POST[cSiglaAutor]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
  case 4: //registro interno trabajador
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
    
    // comprobar o recoger correlativo
    $sqlCorr="SELECT * FROM Tra_M_Correlativo_Trabajador WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' AND nNumAno='$nNumAno'";
    $rsCorr=sqlsrv_query($cnx,$sqlCorr);
    if(sqlsrv_has_rows($rsCorr)>0){
    	$RsCorr=sqlsrv_fetch_array($rsCorr);
    	$nCorrelativo=$RsCorr[nCorrelativo]+1;
    	
    	$sqlUpd="UPDATE Tra_M_Correlativo_Trabajador SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelTrabajador='$RsCorr[iCodCorrelTrabajador]'";
			$rsUpd=sqlsrv_query($cnx,$sqlUpd);
    }Else{
    	$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Trabajador (cCodTipoDoc, iCodTrabajador, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['CODIGO_TRABAJADOR']."', '$nNumAno',1)";
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
	$siglaN		=explode(" ",$RsNomUsr[cNombresTrabajador]);
	for($i = 0; $i < count($siglaN); $i++){
			$n[$i]	=  	$siglaN[$i];
			$nx		=	$nx.$n[$i][0]; 
 	}
	$siglaP		=explode(" ",$RsNomUsr[cApellidosTrabajador]);
	for($i = 0; $i < count($siglaP); $i++){
			$m[$i]	=  	$siglaP[$i];
			$ny		=	$ny.$m[$i][0]; 
 	}  
    // armar correlativo
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-SITDD/".trim($RsSigla[cSiglaOficina])."-".strtoupper(trim($nx.$ny));
    		
			if($_POST[nFlgEnvio]==""){
			$_POST[nFlgEnvio]=1;
			}
			else  if($_POST[nFlgEnvio]==1){
			$_POST[nFlgEnvio]="";
			}
			
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	cAsunto,           cObservaciones,           fFecPlazo,    fFecRegistro, nFlgEstado,	nFlgEnvio	)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(2,           2,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST['cAsunto']', '$_POST[cObservaciones]', $fFecPlazo, '$fFecActual',1, '$_POST[nFlgEnvio]')";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
	/* if($_POST[nFlgEnvio]=1){
			$sqlUpdT="UPDATE Tra_M_Tramite SET nFlgEnvio=1 WHERE iCodTramite='$RsUltTra[iCodTramite]'";
			$rsUpdT=sqlsrv_query($cnx,$sqlUpdT);
			
			$sqlUpdM="UPDATE Tra_M_Tramite_Movimientos SET nFlgEnvio=1 WHERE iCodTramite='$RsUltTra[iCodTramite]'";
			$rsUpdM=sqlsrv_query($cnx,$sqlUpdM);
		} */
	
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
    // Previa version se usaba el campo de Envio ahora el de Derivo
	/* 	$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,								nFlgTipoDoc, iCodTrabajadorRegistro,				 iCodOficinaOrigen,           fFecMovimiento,  nEstadoMovimiento, iCodTrabajadorEnviar,      cObservacionesEnviar, 		 fFecEnviar,    cFlgTipoMovimiento, nFlgEnvio)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$RsUltTra[iCodTramite]', '2', 				 '".$_SESSION['CODIGO_TRABAJADOR']."', $_SESSION['iCodOficinaLogin'], '$fFecActual',   1,									'$lstTrabajadoresSel[$i]', '$_POST[cObservaciones]', '$fFecActual', 2,                  '$_POST[nFlgEnvio]')"; */
			
	$sqlTJefe=" SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina = '".$_SESSION['iCodOficinaLogin']."' and nFlgEstado =1 and iCodCategoria =5 ";
	$rsTJefe=sqlsrv_query($cnx,$sqlTJefe);
	$RsTJefe=sqlsrv_fetch_array($rsTJefe);
		for ($i=0;$i<count($_POST[lstTrabajadoresSel]);$i++){
			$lstTrabajadoresSel=$_POST[lstTrabajadoresSel];
			//echo "<li>".$lstTrabajadoresSel[$i];    
			// agragar nuevo movimiento por accion ENVIAR			
		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(		iCodTramite,			iCodTrabajadorRegistro,	  nFlgTipoDoc, 				 iCodOficinaOrigen,           iCodOficinaDerivar,			iCodTrabajadorDerivar,	 iCodTrabajadorDelegado,	fFecDelegado,  fFecMovimiento, cObservacionesDelegado, cAsuntoDerivar, 	cObservacionesDerivar , 	fFecDerivar , 	 nEstadoMovimiento,  cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', '2', 				  '".$_SESSION['iCodOficinaLogin']."', '".$_SESSION['iCodOficinaLogin']."','$RsTJefe[iCodTrabajador]','$lstTrabajadoresSel[$i]','$fFecActual','$fFecActual', '$_POST[cObservaciones]',		  '$_POST['cAsunto']',	'$_POST[cObservaciones]', '$fFecActual', 		3,		 					2)";
			
			$rsMov=sqlsrv_query($cnx,$sqlMov);
		}	
			
		/*	for ($i=0;$i<count($_POST[lstTrabajadoresSel]);$i++){
			$lstTrabajadoresSel=$_POST[lstTrabajadoresSel];
			//echo "<li>".$lstTrabajadoresSel[$i];    
			// agragar nuevo movimiento por accion ENVIAR			
		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(		iCodTramite,			iCodTrabajadorRegistro,	  nFlgTipoDoc, 				 iCodOficinaOrigen,           iCodOficinaDerivar,			iCodTrabajadorDerivar,	 iCodTrabajadorEnviar,	  fFecMovimiento,        cAsuntoDerivar,   cObservacionesDerivar, 		 fFecDerivar, nEstadoMovimiento,          cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', '2', 				  '".$_SESSION['iCodOficinaLogin']."', '".$_SESSION['iCodOficinaLogin']."','$lstTrabajadoresSel[$i]','$lstTrabajadoresSel[$i]','$fFecActual', 		  '$_POST['cAsunto']',	'$_POST[cObservaciones]', '$fFecActual', 		1,		 					2)";
			
			$rsMov=sqlsrv_query($cnx,$sqlMov);
		} */



		
			echo "<html>";
			echo "<head>";
			echo "</head>";
			echo "<body OnLoad=\"document.form_envio.submit();\">";
			echo "<form method=POST name=form_envio action=registroInternoObs.php>";
			echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
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
	case 5: // registro salida /////////////////////////////////////////////////////////////////////////////
		if ($_POST[fFecPlazo] != ""){
	    $separado2 = explode("-",$_POST[fFecPlazo]);
	    $fFecPlazo = "'".$separado2[2].$separado2[1].$separado2[0]."'";
	  }else{
	  	$fFecPlazo="NULL";
	  }
	  // comprobar o recoger correlativo
	  $sqlCorr = "SELECT * FROM Tra_M_Correlativo_Salida 
	  						WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
	  $rsCorr  = sqlsrv_query($cnx,$sqlCorr);
	  if (sqlsrv_has_rows($rsCorr) > 0){
	  	$RsCorr = sqlsrv_fetch_array($rsCorr);
	    $nCorrelativo = $RsCorr[nCorrelativo]+1;
	    	
	    $sqlUpd = "UPDATE Tra_M_Correlativo_Salida SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
			$rsUpd  = sqlsrv_query($cnx,$sqlUpd);
		}else{
			$sqlAdCorr = "INSERT INTO Tra_M_Correlativo_Salida (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) 
										VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
	    $rsAdCorr  = sqlsrv_query($cnx,$sqlAdCorr);
	    $nCorrelativo = 1;
	  }
    
	  // leer sigla oficina
	  $rsSigla = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
	  $RsSigla = sqlsrv_fetch_array($rsSigla);
	    
	  // armar correlativo
	  $cCodificacion = add_ceros($nCorrelativo,5)."-".date("Y")."/SITDD/".trim($RsSigla[cSiglaOficina]);
	    
		// Jefe de Oficina
	  $rsJefe = sqlsrv_query($cnx,"SELECT iCodTrabajador FROM Tra_M_Trabajadores 
	  											 WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nFlgEstado = 1  AND iCodCategoria = '5' ");
		$RsJefe = sqlsrv_fetch_array($rsJefe);
		
		//  Sql es ejecutado en SP
	  $sqlAdd.=" SP_DOC_SALIDA_INSERT '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$RsJefe[iCodTrabajador]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]', '$fFecActual', '$_POST[iCodRemitente]','$_POST[cNomRemite]','".str_replace( '\"', '"', $_POST[descripcion] )."','$_POST[archivoFisico]' ";

   	$rs = sqlsrv_query($cnx,$sqlAdd);
	   
	  //Ultimo registro de tramite
		$rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite 
														 WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."' 
														 ORDER BY iCodTramite DESC");
		$RsUltTra = sqlsrv_fetch_array($rsUltTra);
    	
		if ($_POST[iCodRemitente]>0){
			//  Sql es ejecutado en SP
	    $sqlAddCargo.=" SP_DOC_SALIDA_MULTIPLE_INSERT '$RsUltTra[iCodTramite]' ,'$cCodificacion','$_POST[iCodRemitente]', $_SESSION['iCodOficinaLogin'], '$_POST['cAsunto']', '".$_SESSION['CODIGO_TRABAJADOR']."' , '$_POST[txtdirec_remitente]',		'$_POST[cCodDepartamento]',	'$_POST[cCodProvincia]',	 '$_POST[cCodDistrito]', '$_POST[cNomRemite]' ";
	   	$rsAddCargo = sqlsrv_query($cnx,$sqlAddCargo);
  	}
  	
		$sqlAdMv = "INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlAdMv.="(iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodIndicacionDerivar,cAsuntoDerivar,    cObservacionesDerivar,fFecDerivar,fFecMovimiento,nEstadoMovimiento,nFlgEnvio,cFlgTipoMovimiento)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$RsUltTra[iCodTramite]','".$_SESSION['CODIGO_TRABAJADOR']."',3,'".$_SESSION['iCodOficinaLogin']."',1,3,'$_POST['cAsunto']','$_POST[cObservaciones]','$fFecActual','$fFecActual',1,1,1)";
    $rsAdMv = sqlsrv_query($cnx,$sqlAdMv);
  		
	  $sqlMv = "SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodOfi]' ORDER BY iCodTemp ASC";
	    $rsMv=sqlsrv_query($cnx,$sqlMv);
	    while ($RsMv=sqlsrv_fetch_array($rsMv)){
				$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
	    	$sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar,   iCodIndicacionDerivar,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento, cFlgOficina)";
	    	$sqlAdMv.=" VALUES ";
	    	$sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,            '".$_SESSION['iCodOficinaLogin']."', '$RsMv['iCodOficina']', '$RsMv[iCodTrabajador]', '$RsMv[iCodIndicacion]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1, 						   4,                   1)";
	    	$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
	    }
		

		$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
		$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
		$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);

	   

  	
	  	// relacion por ferencias
	    $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodRef]'";
	    $rsRefs=sqlsrv_query($cnx,$sqlRefs);
	    if(sqlsrv_has_rows($rsRefs)>0){
	    	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
	    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
					$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
					if(sqlsrv_has_rows($rsBusRef)>0){
						$RsBusRef=sqlsrv_fetch_array($rsBusRef);
						if($RsBusRef[nFlgTipoDoc]==1){						
								$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodOfi]'";
			    			$rsMv2=sqlsrv_query($cnx,$sqlMv2);
			    			$RsMv2=sqlsrv_fetch_array($rsMv2);
			
								//  Sql es ejecutado en SP
								//  El SP esta desarrollado pero no se ha hecho el reemplazo en las lineas de abajo porque no se sabe como probrar 
							//  $sqlAdRf.="SP_DOC_ENTRADA_MOV_INTERNO_REF_INSERT '$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual'  )";
			
								$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
			    			$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento	,			iCodTramiteDerivar)";
			    			$sqlAdRf.=" VALUES ";
			    			$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual',   1, 						    5	,			'$RsUltTra[iCodTramite]')";
			    			$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
			    	}
					}
					$sqlUpdR="UPDATE Tra_M_Tramite_Referencias SET iCodTramite='$RsUltTra[iCodTramite]', cDesEstado='REGISTRADO' WHERE iCodReferencia='$RsRefs[iCodReferencia]'";
					$rsUpdR=sqlsrv_query($cnx,$sqlUpdR);
	    	}
	    }


  //   	$tramitePDF=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$RsUltTra[iCodTramite]'");
  // 		$RsTramitePDF=sqlsrv_fetch_object($tramitePDF);
  		
  // 		if($RsTramitePDF->descripcion != ' ' AND $RsTramitePDF->descripcion != NULL){
  			
 	// 		$rsJefe=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTramitePDF->iCodTrabajadorRegistro'");
	 //        $RsJefe=sqlsrv_fetch_array($rsJefe);
	 //        if (!empty($RsJefe['firma'])) { 
	 //        	$img=base64_encode($RsJefe['firma']); 
	 //        	$imgd='<img src="data:image/png;charset=utf8;base64,'.$img.'"/>';
		//     }else{
		//     	$imgd='';
		//     }
	          

	 //        $sqlM1="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
	 //        $rsM1=sqlsrv_query($cnx,$sqlM1);
	 //        if(sqlsrv_has_rows($rsM1)>0){
	 //            $RsM1=sqlsrv_fetch_object($rsM1);
	 //            $movFecha=date("d-m-Y h:i:s", strtotime($RsM1->fFecDerivar));
	 //        }else{
	 //        	$movFecha='';
	 //        }

	 //        $sqlOfDerivar="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM1->iCodOficinaDerivar'";
	 //        $rsOfDerivar=sqlsrv_query($cnx,$sqlOfDerivar);
	 //        $RsOfDerivar=sqlsrv_fetch_object($rsOfDerivar);

	 //        //set it to writable location, a place for temp generated PNG files
	 //        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode/temp'.DIRECTORY_SEPARATOR;
	        
	 //        //html PNG location prefix
	 //        $PNG_WEB_DIR = 'phpqrcode/temp/';

	 //        include "phpqrcode/qrlib.php";    
	        
	 //        //ofcourse we need rights to create temp dir
	 //        if (!file_exists($PNG_TEMP_DIR))
	 //            mkdir($PNG_TEMP_DIR);
	      
	 //        //$filename = $PNG_TEMP_DIR.'test.png';

	 //        $errorCorrectionLevel = 'L';   
	 //        $matrixPointSize = 2;
	 //        //$_REQUEST['data']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
	 //         $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/Sistema_Tramite_PCM/views/registroSalidaDocumento_pdf.php?iCodTramite='.$RsTramitePDF->iCodTramite;

	 //        // user data
	 //        $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	 //        $filename = $PNG_TEMP_DIR.$codigoQr;
	         
	 //        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

		// 	$content='<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" format="A4"> 
		// 			      <page_header> 
		// 			           <div style=" padding-top: 20px; padding-left: 40px; "><img style="width:300px" src="images/logo-ongei.png" alt="Logo"></div>
		// 			      </page_header> 
		// 			      <page_footer> 
					           
		// 			      </page_footer> 

		// 			      <br><br><br>
		// 			      <div style=" text-align: right; ">'.trim($RsTipDoc['cDescTipoDoc']).' N° '.$RsTramitePDF->cCodificacion.'</div>
		// 			      <br>

		// 			      <table style="width:650px; border: none; font-family:Times;font-size:13.5px;"> <!-- 595px -->
		// 			        <tr>
		// 			          <td style="width:20%">A</td><td style="width:80%">: '.$RsOfDerivar->cSiglaOficina.'</td>
		// 			        </tr>
		// 			        <tr>
		// 			          <td style="width:20%">De</td>
		// 			          <td style="width:80%">: '.$RsJefe["cNombresTrabajador"].' '.$RsJefe["cApellidosTrabajador"].'</td>
		// 			        </tr>
		// 			        <tr>
		// 			          <td style="width:20%">Referencia</td><td style="width:80%"><b>: '.$RsTramitePDF->cReferencia.'</b></td>
		// 			        </tr>

		// 			        <tr>
		// 			          <td style="width:20%">Fecha/H Derivo</td>
		// 			          <td style="width:80%">: '.$movFecha.'</td>
		// 			        </tr>

		// 			        <tr>
		// 			          <td style="width:20%">Asunto</td>
		// 			          <td style="width:80%">: '.$RsTramitePDF->cAsunto.'</td>
		// 			        </tr>
					                      
		// 			      </table>
					      
		// 			      <br><br>
		// 			      <div style="font-family:Times;font-size:13.5px">'.$RsTramitePDF->descripcion.'</div>

		// 			      <div align="right" style=" width: 100%;">
		// 			        <br><br><br><br><br>
		// 			        <div style="width: 30%; text-align: center; ">'.$imgd.'<p>Firma</p></div>
		// 			      </div>
		// 			      <div><img src="'.$PNG_WEB_DIR.basename($filename).'" />
		// 			      <p style="font-size: 9px">'.$_REQUEST['data'].'</p>
		// 			      </div>
		// 			 </page>';

		//  	// ********************	START Ruta del documento electronico  **************************************************************
		//  	date_default_timezone_set("America/Lima");
		//   	$PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'documentos'.DIRECTORY_SEPARATOR;
		//   	$docElectronico = trim(str_replace('/','', str_replace('. ','', $RsTramitePDF->cCodificacion))).'_'.date("YmdHis").".pdf";
		//   	$nombreArchivo=$PDF_DIR.$docElectronico;
		//   	// ********************	END Ruta del documento electronico  **************************************************************
		//   	sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET codigoQr='$codigoQr' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");
		//   	sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET documentoElectronico='$docElectronico' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");
		    
		//  	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
		// 	try
		// 	{
		// 		$html2pdf = new HTML2PDF('P','A4', 'es', false, 'UTF-8', array(mL, mT, mR, mB));
		// 		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		// 		$html2pdf->Output($nombreArchivo, 'F');
		    
		// 	}
		// 	catch(HTML2PDF_exception $e) { echo $e; }
		// }

	//     unset($_SESSION[cCodRef]);
	// 	unset($_SESSION[cCodOfi]);
	// 	$fFecActual=date("d-m-Y G:i"); 
	// 	echo "<html>";
	// 	echo "<head>";
	// 	echo "</head>";
	// 	echo "<body OnLoad=\"document.form_envio.submit();\">";
	// 	echo "<form method=POST name=form_envio action=registroInternoSalidaObs.php>";
	// 	echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
	// 	echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
	// 	echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
	// 	echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
	// 	echo "<input type=hidden name=iCodRemitente value=\"".$_POST[iCodRemitente]."\">";
	// 	echo "<input type=hidden name=nFlgTipoDoc value=3>";
	// 	echo "<input type=hidden name=nFlgClaseDoc value=3>";
	// if($nFlgRestricUp==1){
	// 	echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
	// 	echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	// }		
	// 	echo "</form>";
	// 	echo "</body>";
	// 	echo "</html>";

	    unset($_SESSION[cCodRef]);
		unset($_SESSION[cCodOfi]);
		$fFecActual=date("d-m-Y G:i"); 
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=\"form_envio\" action=\"registroSalidaGenerarDocumento.php\">";
		echo "<input type=\"hidden\" name=\"iCodTramite\" value=\"".$RsUltTra[iCodTramite]."\">";	
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 7: // registro anexo
		$nCodBarra = rand(1000000000,9999999999);
		// armar correlativo
    	$rsCntTra    = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramiteRel='$_POST[iCodTramite]'");
		$UltNumAnexo = sqlsrv_has_rows($rsCntTra) + 1;
		
    	$cCodificacion = $_POST['cCodificacion']."-".$UltNumAnexo;
		//  Sql es ejecutado en SP
		$sqlAdd.="SP_DOC_ANEXO_INSERT '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '".$_POST['cNroDocumento']."', '$_POST['cAsunto']', '$_POST[iCodRemitente]', '$_POST[cNomRemite]', '$_POST[cObservaciones]', '$_POST[nNumFolio]', '$fFecActual', '$fFecActual', '$_POST[iCodTramite]', '$nCodBarra' " ;

    	$rs = sqlsrv_query($cnx,$sqlAdd);
    
    	//Ultimo registro de tramite
		$rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra = sqlsrv_fetch_array($rsUltTra);
    
		if ($_FILES['fileUpLoadDigital']['name'] != ""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$cNombreOriginal = $_FILES['fileUpLoadDigital']['name'];

  			if ($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
  				$nFlgRestricUp = 1;
   			}else{
   				$nuevo_nombre = $cCodificacion."-".$RsUltTra[iCodTramite].".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				$sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) 
							VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
				$rsDigt = sqlsrv_query($cnx,$sqlDigt);
			}   					
			$rsUltDoc = sqlsrv_query($cnx,"SELECT TOP 1 iCodDigital FROM Tra_M_Tramite_Digitales 
									 WHERE iCodTramite = '$RsUltTra[iCodTramite]' 
									 ORDER BY iCodTramite DESC");
			$RsUltDoc = sqlsrv_fetch_array($rsUltDoc);
		}
  	
  		if ($_POST[nFlgEnvio] == 1){
  			$sqlUpdEnvio = "UPDATE Tra_M_Tramite SET nFlgEnvio='$_POST[nFlgEnvio]' WHERE iCodTramite='$RsUltTra[iCodTramite]'";
			$rsUpdEnvio  = sqlsrv_query($cnx,$sqlUpdEnvio);
			//  Sql es ejecutado en SP

			$sqlMov.=" SP_DOC_ANEXO_MOVIMIENTO_INSERT  '$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 	'".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$RsUltDoc[iCodDigital]', '$_POST[iCodTramite]', '$fFecActual', '$fFecActual' ";
			$rsMov = sqlsrv_query($cnx,$sqlMov);
		}
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroAnexoConcluido.php target=_parent>";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
		if ($nFlgRestricUp == 1){
			echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
			echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
		}
		echo "</form>";
		echo "</body>";
		echo "</html>";
		break;
	case 8:  // actualizar tramite con tupa
	//  Sql es ejecutado en SP
 	$fFecActual=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i",strtotime($_POST['fFecRegistro']));
    $fFecActual2=date("d-m-Y G:i"); 
		$cNroDocumento	=stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
		$cNomRemite		=stripslashes(htmlspecialchars($_POST[cNomRemite], ENT_QUOTES));
		$cAsunto		=stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
		$cObservaciones	=stripslashes(htmlspecialchars($_POST[cObservaciones], ENT_QUOTES));
		$nNumFolio		=stripslashes(htmlspecialchars($_POST[nNumFolio], ENT_QUOTES));
		$cReferencia	=stripslashes(htmlspecialchars($_POST[cReferencia], ENT_QUOTES));
	$sqlUpd="SP_DOC_ENTRADA_CON_TUPA_UPDATE  '$_POST[cCodTipoDoc]', '$cNroDocumento', '$_POST[iCodRemitente]', '$cAsunto', '$cObservaciones', '$_POST[iCodTupaClase]',  '$_POST['iCodTupa']',  '$cReferencia',  '$_POST[iCodIndicacion]','$nNumFolio', '$_POST[nTiempoRespuesta]', '$cNomRemite','$fFecActual','$fFecActual', '$_POST[iCodTramite]' "; 
	
//    $sqlUpd="UPDATE Tra_M_Tramite SET ";
//    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
//    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
//    $sqlUpd.="iCodRemitente='$_POST[iCodRemitente]', ";
//    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
//    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
//    $sqlUpd.="iCodTupaClase='$_POST[iCodTupaClase]', ";
//    $sqlUpd.="iCodTupa='$_POST['iCodTupa']', ";
//    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
//    $sqlUpd.="iCodIndicacion='$_POST[iCodIndicacion]', ";
//    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
//    $sqlUpd.="nTiempoRespuesta='$_POST[nTiempoRespuesta]', ";
//		$sqlUpd.="cNomRemite='$_POST[cNomRemite]' ";
//    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
	
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		//echo $sqlUpd;
		
		
		$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Requisitos WHERE iCodTramite='$_POST[iCodTramite]'");
		
		For ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      	$iCodTupaRequisito= $_POST[iCodTupaRequisito];
				$sqlIns="INSERT INTO Tra_M_Tramite_Requisitos (iCodTupaRequisito, iCodTramite) VALUES ('$iCodTupaRequisito[$h]', '$_POST[iCodTramite]') ";
   			$rsIns=sqlsrv_query($cnx,$sqlIns);
		}
		
		if($_POST[iCodOficinaResponsable]!="" AND $_POST[numMov]==0){
				$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
				$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc, iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    iCodIndicacionDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, cFlgTipoMovimiento)";
				$sqlMov.=" VALUES ";
				$sqlMov.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 1,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST[iCodIndicacion]', '$fFecActual', 1,                '$fFecActual',   1)";
   			$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}	
	
	// actualizacion de detalle	
	$sqlUpdMovimineto=" SP_DOC_ENTRADA_MOV '$_POST[iCodTramite]' ";	
	$rsUpdMovimineto=sqlsrv_query($cnx,$sqlUpdMovimineto);
	$RsUpdMovimineto=sqlsrv_fetch_array($rsUpdMovimineto);
	
	$sqlUpdMovE=" SP_DOC_ENTRADA_MOV_UPDATE '$_POST[cCodTipoDoc]', '$cAsunto', '$cObservaciones','$fFecActual', '$RsUpdMovimineto[iCodMovimiento]' ";	
	$rsUpdMovE=sqlsrv_query($cnx,$sqlUpdMovE);
		
		if($_POST[nFlgEnvio]==1){
				$rsUpd2=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'");
				$rsUpd3=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'");
   	}
		
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
				if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}Else{
						$nuevo_nombre = $_POST[cCodificacion]."-".$_POST[iCodTramite].".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}
  	
  	$rsTram=sqlsrv_query($cnx,"SELECT nCodBarra FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'");
		$RsTram=sqlsrv_fetch_array($rsTram);
		
		echo "<html>";
   	echo "<head>";
   	echo "</head>";
  	echo "<body OnLoad=\"document.form_envio.submit();\">";
 	echo "<form method=POST name=form_envio action=registroActualizado.php#area>";
   	echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   	echo "<input type=hidden name=nCodBarra value=\"".$RsTram[nCodBarra]."\">";
	echo "<input type=hidden name=fFecActual2 value=\"".$fFecActual2."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";
	break;
	case 9: // actualizar tramite sin tupa
//  Sql es ejecutado en SP
	$fFecActual=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i",strtotime($_POST['fFecRegistro']));
    $fFecActual2=date("d-m-Y G:i");


		$cNroDocumento	=stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
		$cNomRemite		=stripslashes(htmlspecialchars($_POST[cNomRemite], ENT_QUOTES));
		$cAsunto		=stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
		$cObservaciones	=stripslashes(htmlspecialchars($_POST[cObservaciones], ENT_QUOTES));
		$nNumFolio		=stripslashes(htmlspecialchars($_POST[nNumFolio], ENT_QUOTES));
		$cReferencia	=stripslashes(htmlspecialchars($_POST[cReferencia], ENT_QUOTES));
	$sqlUpd="SP_DOC_ENTRADA_SIN_TUPA_UPDATE  '$_POST[cCodTipoDoc]', '$cNroDocumento', '$_POST[iCodRemitente]', '$cAsunto', '$cObservaciones', '$cReferencia',  '$_POST[iCodIndicacion]','$nNumFolio', '$_POST[nTiempoRespuesta]', '$cNomRemite', '$fFecActual','$fFecActual','$_POST[iCodTramite]'";



		$rsUpd=sqlsrv_query($cnx,$sqlUpd);//		echo $sqlUpd;
		
	// si selecciono oficina y los movimientos estan vacios.
		if($_POST[iCodOficinaResponsable]!="" AND $_POST[numMov]==0){
						$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
						$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc, iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    iCodIndicacionDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, cFlgTipoMovimiento)";
						$sqlMov.=" VALUES ";
						$sqlMov.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 1,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST[iCodIndicacion]', '$fFecActual', 1,                '$fFecActual',   1)";
   					$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}
	
	if($_POST[nFlgEnvio]==1){
				$rsUpd2=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nFlgEnvio=0 WHERE iCodTramite='$_POST[iCodTramite]'");
				$rsUpd3=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET nFlgEnvio=0 WHERE iCodTramite='$_POST[iCodTramite]'");
		} else {
				$rsUpd2=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'");
				$rsUpd3=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'");
		}
   	
   	if($_POST[numMov]==1){
   			if($_POST[iCodOficinaResponsable]!=$_POST[iCodOfi]){
   					$rsMovA=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET iCodOficinaDerivar='$_POST[iCodOficinaResponsable]' WHERE iCodMovimiento='$_POST[iCodMov]'");
   			}
   			if($_POST[iCodTrabajadorResponsable]!=$_POST[iCodTra]){
   					$rsMovB=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET iCodTrabajadorDerivar='$_POST[iCodTrabajadorResponsable]' WHERE iCodMovimiento='$_POST[iCodMov]'");
   			}
   	}
	
	// actualizacion de detalle	
	$sqlUpdMov=" SP_DOC_ENTRADA_MOV '$_POST[iCodTramite]' ";	
	$rsUpdMov=sqlsrv_query($cnx,$sqlUpdMov);
	$RsUpdMov=sqlsrv_fetch_array($rsUpdMov);
	
	$sqlUpdMovE=" SP_DOC_ENTRADA_MOV_UPDATE '$_POST[cCodTipoDoc]', '$cAsunto', '$cObservaciones','$fFecActual', '$RsUpdMov[iCodMovimiento]' ";	
	
	$rsUpdMovE=sqlsrv_query($cnx,$sqlUpdMovE);
		
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
				$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
				if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}Else{
						$nuevo_nombre = $_POST[cCodificacion]."-".$_POST[iCodTramite].".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}
		
		$rsTram=sqlsrv_query($cnx,"SELECT nCodBarra FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'");
		$RsTram=sqlsrv_fetch_array($rsTram);
		
		
		
		echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=POST name=form_envio action=registroActualizado.php#area>";
   	echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   	echo "<input type=hidden name=nCodBarra value=\"".$RsTram[nCodBarra]."\">";
	echo "<input type=hidden name=fFecActual2 value=\"".$fFecActual2."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";
	break;
	case 10: // nuevo remitente
	
    // Se desarrolló el SP pero no se sabe como probarlo por eso no se implementa 
		// $sql="(SP_REMITENTE_REG_INSERT $_POST[tipoRemitente], '$_POST[txtnom_remitente]', '$_POST[cTipoDocIdentidad]', '$_POST[txtnum_documento]', '$_POST[txtdirec_remitente]', '$_POST[txtmail]', '$_POST[txtfono_remitente]', '$_POST[txtfax_remitente]', '$_POST[cCodDepartamento]', '$_POST[cCodProvincia]', '$_POST[cCodDistrito]', '$_POST[txtrep_remitente]','$_POST[txtflg_estado]') ";
		
		$sql="INSERT INTO Tra_M_Remitente ";
		$sql.="(cTipoPersona,           cNombre,                     cTipoDocIdentidad,           nNumDocumento,              cDireccion,                   cEmail,						nTelefono,  									nFax,                       cDepartamento,              cProvincia,              cDistrito,             cRepresentante,             cFlag) ";
    $sql.=" VALUES ";
    $sql.="($_POST[tipoRemitente], '$_POST[txtnom_remitente]', '$_POST[cTipoDocIdentidad]', '$_POST[txtnum_documento]', '$_POST[txtdirec_remitente]', '$_POST[txtmail]', '$_POST[txtfono_remitente]', '$_POST[txtfax_remitente]', '$_POST[cCodDepartamento]', '$_POST[cCodProvincia]', '$_POST[cCodDistrito]', '$_POST[txtrep_remitente]','$_POST[txtflg_estado]') ";

		$rs=sqlsrv_query($cnx,$sql);
		sqlsrv_close($cnx);
		
		$rsUltRem=sqlsrv_query($cnx,"SELECT TOP 1 iCodRemitente FROM Tra_M_Remitente ORDER BY iCodRemitente DESC");
		$RsUltRem=sqlsrv_fetch_array($rsUltRem);
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		if($_POST[nFlgClaseDoc]==1){
			echo "<form method=POST name=form_envio action=registroConTupa.php#area target=\"_parent\">";
		}
		if($_POST[nFlgClaseDoc]==2){
			echo "<form method=POST name=form_envio action=registroSinTupa.php#area target=\"_parent\">";
		}
		echo "<input type=hidden name=tipoRemitente value=\"".$_POST[tipoRemitente]."\">";
		echo "<input type=hidden name=iCodRemitente value=\"".$RsUltRem[iCodRemitente]."\">";
		echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
		echo "<input type=hidden name=cNroDocumento value=\"".$_POST['cNroDocumento']."\">";
		echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
		echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
		echo "<input type=hidden name=iCodTupaClase value=\"".$_POST[iCodTupaClase]."\">";
		echo "<input type=hidden name=iCodTupa value=\"".$_POST['iCodTupa']."\">";
		echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
		echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_POST[iCodOficinaResponsable]."\">";
		echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".$_POST[iCodTrabajadorResponsable]."\">";
		echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
		echo "<input type=hidden name=iCodIndicacion value=\"".$_POST[iCodIndicacion]."\">";
		echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
		echo "<input type=hidden name=cNomRemite value=\"".$_POST[cNomRemite]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 11: // actualizar anexo
//  Sql es ejecutado en SP

		$sqlUpd="SP_DOC_ANEXO_UPDATE  '$_POST[cCodTipoDoc]', '$_POST[nNumFolio]', '".$_POST['cNroDocumento']."', '$_POST[iCodRemitente]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[iCodTramite]'";

//    $sqlUpd="UPDATE Tra_M_Tramite SET ";
//    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
//    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
//    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
//    $sqlUpd.="iCodRemitente='$_POST[iCodRemitente]', ";
//    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
//    $sqlUpd.="cObservaciones='$_POST[cObservaciones]' ";
//    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";

		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
//		echo $sqlUpd;

		
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
				if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}Else{
						$nuevo_nombre = $_POST[cCodificacion]."-".$_POST[iCodTramite].".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
   			
   			$rsUltDig=sqlsrv_query($cnx,"SELECT TOP 1 iCodDigital FROM Tra_M_Tramite_Digitales ORDER BY iCodDigital DESC");
				$RsUltDig=sqlsrv_fetch_array($rsUltDig);
  	}
		
  	if($_POST[nFlgEnvio]==1){
  		$sqlUpdEnvio="UPDATE Tra_M_Tramite SET nFlgEnvio='$_POST[nFlgEnvio]' WHERE iCodTramite='$_POST[iCodTramite]'";
			$rsUpdEnvio=sqlsrv_query($cnx,$sqlUpdEnvio);
  		
  		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    cAsuntoDerivar, 	   cObservacionesDerivar,    iCodDigital, 						iCodTramiteRel, 				fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 4, 						'".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$RsUltDig[iCodDigital]', '$_POST[iCodTramite]', '$fFecActual', 1,                '$fFecActual',   1,					 3)";
   		$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}
	
	//Actualizar Flujo
	$sqlDetMovF="UPDATE Tra_M_Tramite_Movimientos SET cAsuntoDerivar= '$_POST['cAsunto']' , cObservacionesDerivar= '$_POST[cObservaciones]' WHERE iCodTramite = '$_POST[iCodTramite]' AND cFlgTipoMovimiento= 3 AND  nFlgTipoDoc = 4  ";
	$rsDetMovF=sqlsrv_query($cnx,$sqlDetMovF);
   	
   	if($_POST[iCodOficinaResponsable]!=$_POST[iCodOfi]){
   					$rsMovA=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET iCodOficinaDerivar='$_POST[iCodOficinaResponsable]' WHERE iCodMovimiento='$_POST[iCodMovimiento]'");
   	}
   	if($_POST[iCodTrabajadorResponsable]!=$_POST[iCodTra]){
   					$rsMovB=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET iCodTrabajadorDerivar='$_POST[iCodTrabajadorResponsable]' WHERE iCodMovimiento='$_POST[iCodMovimiento]'");
   	}

		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroAnexoConcluido.php target=_parent>";
		echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$_POST[nCodBarra]."\">";
		echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}		
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 12: // registrar copias
	  $rsTram=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'");
		$RsTram=sqlsrv_fetch_array($rsTram);

	/*	if($_POST[mismaObs]==1){
			$cObservaciones=$RsTram[cObservaciones];
		}Else{
			$cObservaciones=$_POST[cObservaciones];
		}
		*/
		for($i=1; $i<=$_POST[CantCopias]; $i++){
			$recolector=$i-1;
			$iCodOficinaResponsableSelect=$iCodOficinaResponsable[$recolector];
			$iCodTrabajadorResponsableSelect=$iCodTrabajadorResponsable[$recolector];
			$iCodIndicacionSelect=$iCodIndicacion[$recolector];
			$nFlgEnvioSelect=$nFlgEnvio[$recolector];
  		    if($_POST[mismaObs]==1){
				   $cObservaciones[$recolector] =$RsTram[cObservaciones];
                     $cObservacionesSelect = $cObservaciones[$recolector];
			}else{
			$cObservacionesSelect=$cObservaciones[$recolector];
			}
  		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,              iCodTrabajadorDerivar,              cAsuntoDerivar, 	   cObservacionesDerivar,   cCodTipoDocDerivar,     iCodIndicacionDerivar,   fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,          cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 1, 						'".$_SESSION['iCodOficinaLogin']."', '$iCodOficinaResponsableSelect', '$iCodTrabajadorResponsableSelect', '$RsTram['cAsunto']', '$cObservacionesSelect',       '$RsTram[cCodTipoDoc]', '$iCodIndicacionSelect', '$fFecActual', 1,                '$fFecActual',   1,	4)";
   		//echo $sqlMov."<br><br>";
   		$rsMov=sqlsrv_query($cnx,$sqlMov);
  	}
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroCopiaConcluido.php target=_parent>";
		echo "<input type=hidden name=cCodificacion value=\"".$RsTram[cCodificacion]."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$RsTram[nCodBarra]."\">";
		echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
		
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;	
	case 13: // actualizar interno oficina
		$fFecActual2=date("d-m-Y G:i"); 	
		if($_POST[fFecPlazo]!=""){
	    	$separado2=explode("-",$_POST[fFecPlazo]);
	    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
	    }else{
	    	$fFecPlazo="NULL";
	    }
		//  Sql es ejecutado en SP
    	$fFecActual=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i",strtotime($_POST['fFecRegistro']));
    	$sqlUpd="SP_DOC_ENTRADA_INTERNO_UPDATE '$_POST[cCodTipoDoc]', '$_POST[iCodTrabajadorSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]' , '$fFecActual' , '$_POST[iCodTramite]' ";
    // 	$sqlUpd="UPDATE Tra_M_Tramite SET 
				//     cCodTipoDoc				=	'$_POST[cCodTipoDoc]',
				//     iCodTrabajadorSolicitado=	'$_POST[iCodTrabajadorSolicitado]',
				//     cReferencia				=	UPPER('$_POST[cReferencia]'),
				//     cAsunto					=	'$_POST['cAsunto']', 
				//     cObservaciones			=	'$_POST[cObservaciones]', 
				//     nFlgRpta				=	'$_POST[nFlgRpta]',    
				//     nNumFolio				=	'$_POST[nNumFolio]',
				//     fFecPlazo				=	'$fFecPlazo',
				//     cSiglaAutor				=	UPPER('$_POST[cSiglaAutor]') ,
				// 	fFecDocumento			=	'$fFecActual',
				// 	fFecRegistro			=	'$fFecActual',
				// 	descripcion			=	'".str_replace('\"', '"', $_POST[descripcion])."'
				// WHERE 
				// 	iCodTramite				=	'$_POST[iCodTramite]'";
    
//    $sqlUpd="UPDATE Tra_M_Tramite SET ";
//    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
//    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
//    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
//    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
//    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
//    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
//    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
//    $sqlUpd.="fFecPlazo=$fFecPlazo ";
//    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);

		$sqlMv="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]' AND cFlgOficina=1 ORDER BY iCodMovimiento ASC";
    	$rsMv=sqlsrv_query($cnx,$sqlMv);
    	if (isset($_POST['Copia'])){
  			$Copia = $_POST['Copia'];
  			$n        = count($Copia);
  			$h        = 0;
		}
	    while ($RsMv=sqlsrv_fetch_array($rsMv)){
			$x=1;
			for ($h=0;$h<$n;$h++){
				if($RsMv[iCodMovimiento]==$Copia[$h]  ){   //  Seleccion de Copia
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
	 				
			$sqlUpdM="UPDATE Tra_M_Tramite_Movimientos SET ";
			$sqlUpdM.="cFlgTipoMovimiento='$cFlgTipoMovimiento' ";
			$sqlUpdM.="WHERE iCodMovimiento='$RsMv[iCodMovimiento]'";
			$rsUpdM=sqlsrv_query($cnx,$sqlUpdM);
			
	    }		 	
		
		$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
		$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
		$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
		
		if($_POST[nFlgEnvio]==""){
			$sqlUpdT="UPDATE Tra_M_Tramite SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'";
			$rsUpdT=sqlsrv_query($cnx,$sqlUpdT);
			
			$sqlUpdM="UPDATE Tra_M_Tramite_Movimientos SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'";
			$rsUpdM=sqlsrv_query($cnx,$sqlUpdM);
		}

		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
			if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
				$nFlgRestricUp=1;
   			}else{
				$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion]).".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   				$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  		}
  		//Actualizar Detalle
		$sqlDetMov="UPDATE Tra_M_Tramite_Movimientos SET cAsuntoDerivar= '$_POST['cAsunto']' , cObservacionesDerivar= '$_POST[cObservaciones]' WHERE iCodTramite = '$_POST[iCodTramite]'";
		$rsDetMov=sqlsrv_query($cnx,$sqlDetMov);
		//Actualizar Flujo
		$sqlDetFlu=" SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite = '$_POST[iCodTramite]' ";
		$rsDetFlu=sqlsrv_query($cnx,$sqlDetFlu);
		$RsDetFlu=sqlsrv_fetch_array($rsDetFlu);
		$sqlDetMovF="UPDATE Tra_M_Tramite_Movimientos SET cAsuntoDerivar= '$_POST['cAsunto']' , cObservacionesDerivar= '$_POST[cObservaciones]' WHERE cNumDocumentoDerivar = '$RsDetFlu[cCodificacion]' AND cFlgTipoMovimiento= 1 ";
		$rsDetMovF=sqlsrv_query($cnx,$sqlDetMovF);
	
  	// relacion por ferencia
    $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_POST[iCodTramite]'";
    $rsRefs=sqlsrv_query($cnx,$sqlRefs);
    if(sqlsrv_has_rows($rsRefs)>0){
    	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
    				$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
						$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
						if(sqlsrv_has_rows($rsBusRef)>0){
								$RsBusRef=sqlsrv_fetch_array($rsBusRef);
								if($RsBusRef[nFlgTipoDoc]==1){
										$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]' ORDER BY iCodMovimiento ASC";
    								$rsMv2=sqlsrv_query($cnx,$sqlMv2);
    								$RsMv2=sqlsrv_fetch_array($rsMv2);
										
										$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsBusRef[iCodTramite]' AND cFlgTipoMovimiento=5");
										
										$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    								$sqlAdRf.="(iCodTramite,
    											iCodTrabajadorRegistro,
    											nFlgTipoDoc, iCodOficinaOrigen,
    											cCodTipoDocDerivar,
    											iCodOficinaDerivar,
    											iCodTrabajadorDerivar,
    											iCodIndicacionDerivar,
    											cPrioridadDerivar,
    											cAsuntoDerivar,
    											cObservacionesDerivar,
    											fFecDerivar,
    											nFlgEnvio,
    											cReferenciaDerivar,
    											fFecMovimiento,
    											nEstadoMovimiento,
    											cFlgTipoMovimiento,
iCodTramiteDerivar)";
    								$sqlAdRf.=" VALUES ";
    								$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', 1,         '$cCodificacion',  '$fFecActual',   1, 						    5,	'$RsUltTra[iCodTramite]')";
    								$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
    						}
						}
				}
    }

    //*************************START DOCUMENTO ELECTRONICO
  //   	$tramitePDF=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$RsUltTra[iCodTramite]'");
  // 		$RsTramitePDF=sqlsrv_fetch_object($tramitePDF);
  		
  // 		if($RsTramitePDF->descripcion != ' ' AND $RsTramitePDF->descripcion != NULL){
  			
 	// 		$rsJefe=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTramitePDF->iCodTrabajadorRegistro'");
	 //        $RsJefe=sqlsrv_fetch_array($rsJefe);
	 //        if (!empty($RsJefe['firma'])) { 
	 //        	$img=base64_encode($RsJefe['firma']); 
	 //        	$imgd='<img src="data:image/png;charset=utf8;base64,'.$img.'"/>';
		//     }else{
		//     	$imgd='';
		//     }
	          

	 //        $sqlM1="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
	 //        $rsM1=sqlsrv_query($cnx,$sqlM1);
	 //        if(sqlsrv_has_rows($rsM1)>0){
	 //            $RsM1=sqlsrv_fetch_object($rsM1);
	 //            $movFecha=date("d-m-Y h:i:s", strtotime($RsM1->fFecDerivar));
	 //        }else{
	 //        	$movFecha='';
	 //        }

	 //        $sqlOfDerivar="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM1->iCodOficinaDerivar'";
	 //        $rsOfDerivar=sqlsrv_query($cnx,$sqlOfDerivar);
	 //        $RsOfDerivar=sqlsrv_fetch_object($rsOfDerivar);

	 //        //set it to writable location, a place for temp generated PNG files
	 //        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode/temp'.DIRECTORY_SEPARATOR;
	        
	 //        //html PNG location prefix
	 //        $PNG_WEB_DIR = 'phpqrcode/temp/';

	 //        include "phpqrcode/qrlib.php";    
	        
	 //        //ofcourse we need rights to create temp dir
	 //        if (!file_exists($PNG_TEMP_DIR))
	 //            mkdir($PNG_TEMP_DIR);
	      
	 //        //$filename = $PNG_TEMP_DIR.'test.png';

	 //        $errorCorrectionLevel = 'L';   
	 //        $matrixPointSize = 2;
	 //        //$_REQUEST['data']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
	 //         $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/Sistema_Tramite_PCM/views/registroSalidaDocumento_pdf.php?iCodTramite='.$RsTramitePDF->iCodTramite;

	 //        // user data
	 //        $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	 //        $filename = $PNG_TEMP_DIR.$codigoQr;
	         
	 //        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

		// 	$content='<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" format="A4"> 
		// 			      <page_header> 
		// 			           <div style=" padding-top: 20px; padding-left: 40px; "><img style="width:300px" src="images/logo-ongei.png" alt="Logo"></div>
		// 			      </page_header> 
		// 			      <page_footer> 
					           
		// 			      </page_footer> 

		// 			      <br><br><br>
		// 			      <div style=" text-align: right; ">'.trim($RsTipDoc['cDescTipoDoc']).' N° '.$RsTramitePDF->cCodificacion.'</div>
		// 			      <br>

		// 			      <table style="width:650px; border: none; font-family:Times;font-size:13.5px;"> <!-- 595px -->
		// 			        <tr>
		// 			          <td style="width:20%">A</td><td style="width:80%">: '.$RsOfDerivar->cSiglaOficina.'</td>
		// 			        </tr>
		// 			        <tr>
		// 			          <td style="width:20%">De</td>
		// 			          <td style="width:80%">: '.$RsJefe["cNombresTrabajador"].' '.$RsJefe["cApellidosTrabajador"].'</td>
		// 			        </tr>
		// 			        <tr>
		// 			          <td style="width:20%">Referencia</td><td style="width:80%"><b>: '.$RsTramitePDF->cReferencia.'</b></td>
		// 			        </tr>

		// 			        <tr>
		// 			          <td style="width:20%">Fecha/H Derivo</td>
		// 			          <td style="width:80%">: '.$movFecha.'</td>
		// 			        </tr>

		// 			        <tr>
		// 			          <td style="width:20%">Asunto</td>
		// 			          <td style="width:80%">: '.$RsTramitePDF->cAsunto.'</td>
		// 			        </tr>
					                      
		// 			      </table>
					      
		// 			      <br><br>
		// 			      <div style="font-family:Times;font-size:13.5px">'.$RsTramitePDF->descripcion.'</div>

		// 			      <div align="right" style=" width: 100%;">
		// 			        <br><br><br><br><br>
		// 			        <div style="width: 30%; text-align: center; ">'.$imgd.'<p>Firma</p></div>
		// 			      </div>
		// 			      <div><img src="'.$PNG_WEB_DIR.basename($filename).'" />
		// 			      <p style="font-size: 9px">'.$_REQUEST['data'].'</p>
		// 			      </div>
		// 			 </page>';

		//  	// ********************	START Ruta del documento electronico  **************************************************************
		//  	date_default_timezone_set("America/Lima");
		//   	$PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'documentos'.DIRECTORY_SEPARATOR;
		//   	$docElectronico = trim(str_replace('/','', str_replace('. ','', $RsTramitePDF->cCodificacion))).'_'.date("YmdHis").".pdf";
		//   	$nombreArchivo=$PDF_DIR.$docElectronico;
		//   	// ********************	END Ruta del documento electronico  **************************************************************
		//   	sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET codigoQr='$codigoQr' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");
		//   	sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET documentoElectronico='$docElectronico' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");
		    
		//  	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
		// 	try
		// 	{
		// 		$html2pdf = new HTML2PDF('P','A4', 'es', false, 'UTF-8', array(mL, mT, mR, mB));
		// 		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		// 		$html2pdf->Output($nombreArchivo, 'F');
		    
		// 	}
		// 	catch(HTML2PDF_exception $e) { echo $e; }
		// }
	//*************************END DOCUMENTO ELECTRONICO

	unset($_SESSION[cCodRef]);
	unset($_SESSION[cCodOfi]);	
		echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=POST name=form_envio action=registroInternoActualizado.php#area>";
	echo "<input type=hidden name=fFecActual2 value=\"".$fFecActual2."\">";
	echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
		echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
   	echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";
	break;
  case 14: //añadir movimiento de oficina edit
  		$sqlPerf=" SELECT iCodPerfil FROM Tra_M_Trabajadores WHERE iCodTrabajador = '$_POST[iCodTrabajadorMov]' ";
		$rsPerf=sqlsrv_query($cnx,$sqlPerf);
		$RsPerf=sqlsrv_fetch_array($rsPerf);
		// verificar si es un profesional
		if($RsPerf[iCodPerfil]!=4){
    		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    		$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,       iCodTrabajadorDerivar,       iCodIndicacionDerivar,       cPrioridadDerivar,       cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento,cFlgOficina)";
    		$sqlAdMv.=" VALUES ";
    		$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaMov]', '$_POST[iCodTrabajadorMov]', '$_POST[iCodIndicacionMov]', '$_POST[cPrioridadMov]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1,                 1)";
    		$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    		} else {
$sqlTJefe=" SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina = '$_POST[iCodOficinaMov]' and nFlgEstado =1 and iCodCategoria =5 ";
	$rsTJefe=sqlsrv_query($cnx,$sqlTJefe);
	$RsTJefe=sqlsrv_fetch_array($rsTJefe);
		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar, iCodTrabajadorDelegado, fFecDelegado, iCodIndicacionDerivar, iCodIndicacionDelegado ,cObservacionesDelegado,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,  cFlgOficina)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaMov]'  ,'$RsTJefe[iCodTrabajador]', '$_POST[iCodTrabajadorMov]', '$fFecActual' , '$_POST[iCodIndicacionMov]', '$_POST[iCodIndicacionMov]', '$_POST[cObservaciones]', '$_POST[cPrioridadMov]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual', 3, 				'$cFlgTipoMovimiento',1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
			}
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficinaEdit.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
				echo "<input type=hidden name=cSiglaAutor value=\"".$_POST[cSiglaAutor]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
	case 15: // actualizar interno trabajadores
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
    
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
		$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]'");
		
		for ($i=0;$i<count($_POST[lstTrabajadoresSel]);$i++){
			$lstTrabajadoresSel=$_POST[lstTrabajadoresSel];
			$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos (iCodTramite,
			iCodTrabajadorRegistro,	
			nFlgTipoDoc,
			iCodOficinaOrigen,
			iCodOficinaDerivar,
			iCodTrabajadorDerivar,
			iCodTrabajadorEnviar,
			fFecMovimiento,
			nEstadoMovimiento,
			cAsuntoDerivar,
			cObservacionesDerivar,
			fFecDerivar,
			cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$_POST[iCodTramite]',
			'".$_SESSION['CODIGO_TRABAJADOR']."',
			'2',
			'".$_SESSION['iCodOficinaLogin']."',
			'".$_SESSION['iCodOficinaLogin']."',
			'$lstTrabajadoresSel[$i]',
			'$lstTrabajadoresSel[$i]',
			'$_POST[fFecMovimiento]', 
			1,
			'$_POST['cAsunto']',
			'$_POST[cObservaciones]',
			'$fFecActual', 2)";
	   		$rsMov=sqlsrv_query($cnx,$sqlMov);
		}
		
		if($_POST[nFlgEnvio]=1){
			$sqlUpdT="UPDATE Tra_M_Tramite SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'";
			$rsUpdT=sqlsrv_query($cnx,$sqlUpdT);
			
			$sqlUpdM="UPDATE Tra_M_Tramite_Movimientos SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'";
			$rsUpdM=sqlsrv_query($cnx,$sqlUpdM);
		}
		
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
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion]).".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}
		
		echo "<html>";
   	echo "<head>";
   	echo "</head>";
  	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=POST name=form_envio action=registroInternoActualizado.php#area>";
		echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
   	echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";
	break;
	case 16: // actualizar salida
	    if($_POST[fFecPlazo]!=""){
	    	$separado2=explode("-",$_POST[fFecPlazo]);
	    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
	    }else{
	    	$fFecPlazo="NULL";
	    }
	    
	    if($_POST[iCodRemitente]==""){
	    		$iCodRemitente="NULL";
	    }else{
	    		$iCodRemitente=$_POST[iCodRemitente];
	    }
    
//  Sql es ejecutado en SP
	$fFecActual=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i",strtotime($_POST['fFecRegistro']));
	$fFecActual2=date("d-m-Y G:i"); 	
	$sqlUpd="SP_DOC_SALIDA_UPDATE '$_POST[cCodTipoDoc]', '$_POST[iCodTrabajadorSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]', $iCodRemitente, '$_POST[cNomRemite]', '$fFecActual', '$_POST[iCodTramite]' ";
	//echo  $sqlUpd;
	$sqlUpd="UPDATE Tra_M_Tramite SET 
				    cCodTipoDoc				=	'$_POST[cCodTipoDoc]',
				    iCodTrabajadorSolicitado=	'$_POST[iCodTrabajadorSolicitado]',
				    cReferencia				=	UPPER('$_POST[cReferencia]'),
				    cAsunto					=	'$_POST['cAsunto']', 
				    cObservaciones			=	'$_POST[cObservaciones]', 
				    nFlgRpta				=	'$_POST[nFlgRpta]',    
				    nNumFolio				=	'$_POST[nNumFolio]',
				    fFecPlazo				=	'$fFecPlazo',
				    cSiglaAutor				=	UPPER('$_POST[cSiglaAutor]') ,
					fFecDocumento			=	'$fFecActual',
					fFecRegistro			=	'$fFecActual',
					descripcion				=	'".str_replace('\"', '"', $_POST[descripcion])."'
				WHERE 
					iCodTramite				=	'$_POST[iCodTramite]'";
			//echo $sqlUpd."<br>";

		$rsUpd=sqlsrv_query($cnx,$sqlUpd);

		$sqlBusCod="SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite= '$_POST[iCodTramite]' ";
		$rsBusCod=sqlsrv_query($cnx,$sqlBusCod);
		$RsBusCod=sqlsrv_fetch_array($rsBusCod);
		
		$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
		$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
		$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);

		if ($_FILES['documentoElectronicoPDF']['name']!=""){
  			$extension = explode(".",$_FILES['documentoElectronicoPDF']['name']);
  			$num       = count($extension)-1;
  			$cNombreOriginal = $_FILES['documentoElectronicoPDF']['name'];
			
			if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}else{
   				$nuevo_nombre = str_replace(' ','_', trim($RsTipDoc['cDescTipoDoc'])).'_'.trim(str_replace('/','', str_replace('. ','', $RsBusCod[cCodificacion]))).'_'.date("YmdHis").".pdf";
				//$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion])."-SALIDA.".$extension[$num];
				move_uploaded_file($_FILES['documentoElectronicoPDF']['tmp_name'], "$rutaUpload2$nuevo_nombre");
				//documentoElectronico	=	'$_POST[documentoElectronicoPDF]',
				$sqlFiles = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'"; 
				$rsFiles  = sqlsrv_query($cnx,$sqlFiles);
				$RsFiles  = sqlsrv_fetch_array($rsFiles);
			   	
		    	$rsActualiza = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET documentoElectronico = '$nuevo_nombre' WHERE iCodTramite='$_POST[iCodTramite]'");
		    	//echo "UPDATE Tra_M_Tramite SET documentoElectronico = '$nuevo_nombre' WHERE iCodTramite='$_POST[iCodTramite]'"."<br>";
   			}
  		}
		
		if ($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num       = count($extension)-1;
  			$cNombreOriginal = $_FILES['fileUpLoadDigital']['name'];
			
			if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
						$nFlgRestricUp=1;
   			}else{
				$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion])."-SALIDA.".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
				$sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) 
							VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   				$rsDigt  = sqlsrv_query($cnx,$sqlDigt);
   			}
  		}
  	
  	$sqlMv="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]'";
    $rsMv=sqlsrv_query($cnx,$sqlMv);
	  $RsMv=sqlsrv_fetch_array($rsMv);
	  if(sqlsrv_has_rows($rsMv)==0){
  					$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    				$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   fFecMovimiento, nEstadoMovimiento, nFlgEnvio)";
    				$sqlAdMv.=" VALUES ";
    				$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 3,            '".$_SESSION['iCodOficinaLogin']."', 1,                  3,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1)";
    				$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  	}
  	
  	// relacion por ferencia
    $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_POST[iCodTramite]'";
    $rsRefs=sqlsrv_query($cnx,$sqlRefs);
    if(sqlsrv_has_rows($rsRefs)>0){
    	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
    				$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
						$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
						if(sqlsrv_has_rows($rsBusRef)>0){
								$RsBusRef=sqlsrv_fetch_array($rsBusRef);
								if($RsBusRef[nFlgTipoDoc]==1){
										$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]' ORDER BY iCodMovimiento ASC";
    								$rsMv2=sqlsrv_query($cnx,$sqlMv2);
    								$RsMv2=sqlsrv_fetch_array($rsMv2);
										
										$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsBusRef[iCodTramite]' AND cFlgTipoMovimiento=5");
										
										$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    								$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   nFlgEnvio, cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,
iCodTramiteDerivar)";
    								$sqlAdRf.=" VALUES ";
    								$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', 1,         '$cCodificacion',  '$fFecActual',   1, 						    5,	'$RsUltTra[iCodTramite]')";
    								$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
    						}
						}
				}
    }
	
	
	if($_POST[iCodRemitente]>0){
	$sqlRemx="SELECT iCodRemitente FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite='$_POST[iCodTramite]' ";
	$rsRemx=sqlsrv_query($cnx,$sqlRemx);
	$numRemx=sqlsrv_has_rows($rsRemx);
	if($numRemx < 1){
	$sqlAddRemx=" SP_DOC_SALIDA_MULTIPLE_INSERT '$_POST[iCodTramite]' ,'$RsBusCod[cCodificacion]','$iCodRemitente', $_SESSION['iCodOficinaLogin'], '$_POST['cAsunto']', '".$_SESSION['CODIGO_TRABAJADOR']."' , '$_POST[txtdirec_remitente]',		'$_POST[cCodDepartamento]',	'$_POST[cCodProvincia]',	 '$_POST[cCodDistrito]', '$_POST[cNomRemite]'  ";
	//echo $sqlAddRemx;
    $rsAddRemx=sqlsrv_query($cnx,$sqlAddRemx);
	}
	if($numRemx = 1){
	$sqlAddRem=" UPDATE Tra_M_Doc_Salidas_Multiples "; 
	$sqlAddRem.=" SET iCodRemitente='$iCodRemitente', ";
	$sqlAddRem.=" cCodificacion ='$RsBusCod[cCodificacion]', ";
	$sqlAddRem.=" cDireccion ='$_POST[txtdirec_remitente]', ";
	$sqlAddRem.=" cDepartamento ='$_POST[cCodDepartamento]', ";
	$sqlAddRem.=" cProvincia ='$_POST[cCodProvincia]', ";
	$sqlAddRem.=" cDistrito ='$_POST[cCodDistrito]' ";
	$sqlAddRem.=" WHERE iCodTramite = '$_POST[iCodTramite]' ";
	$rsAddRem=sqlsrv_query($cnx,$sqlAddRem);
	}
	}
	unset($_SESSION[cCodRef]);
	unset($_SESSION[cCodOfi]);
		echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
  	echo "<form method=POST name=form_envio action=registroInternoActualizado.php#area>";
	echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
	echo "<input type=hidden name=fFecActual2 value=\"".$fFecActual2."\">";
   	echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   	echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "<input type=hidden name=nFlgTipoDoc value=3>";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";	break;
	case 17: // registro salida especial
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
   
    // comprobar o recoger correlativo
    $sqlCorr="SELECT * FROM Tra_M_Correlativo_Salida WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
    $rsCorr=sqlsrv_query($cnx,$sqlCorr);
    if(sqlsrv_has_rows($rsCorr)>0){
    	$RsCorr=sqlsrv_fetch_array($rsCorr);
    	$nCorrelativo=$RsCorr[nCorrelativo]+1;
    	
    	$sqlUpd="UPDATE Tra_M_Correlativo_Salida SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
			$rsUpd=sqlsrv_query($cnx,$sqlUpd);
    }Else{
    	$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Salida (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    	$rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
    	$nCorrelativo=1;
    }
    
    //leer sigla oficina
    $rsSigla=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    $RsSigla=sqlsrv_fetch_array($rsSigla);
    
    //leer sigla oficina solicitante
    $rsSiglaSol=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$_POST[iCodOficinaSolicitado]'");
    $RsSiglaSol=sqlsrv_fetch_array($rsSiglaSol);
    
	//leer el jefe de la oficina solicitante igual al responsable
	$rsJefe=sqlsrv_query($cnx,"SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' And nFlgEstado=1 AND iCodCategoria='5' ");
	$RsJefe=sqlsrv_fetch_array($rsJefe);
	
	// armar correlativo
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-SITDD/".trim($RsSigla[cSiglaOficina])."-".trim($RsSiglaSol[cSiglaOficina]);
    
    // Se desarrolló el SP pero no se sabe como probarlo por eso no se implementa
    //$sqlAdd="SP_DOC_SALIDA_ESP_INSERT '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST[iCodOficinaSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', 6,              '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]', '$fFecActual', '$_POST[iCodRemitente]' ";
    
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	iCodOficinaSolicitado, 				   cReferencia, 				   cAsunto,           cObservaciones, 				 iCodIndicacion, nFlgRpta,					 nNumFolio,						fFecPlazo,  cSiglaAutor,   				 fFecRegistro,	 iCodRemitente,					 nFlgEstado, nFlgEnvio,			cNomRemite,		iCodTrabajadorSolicitado)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(3,           2,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST[iCodOficinaSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', 6,              '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]', '$fFecActual', '$_POST[iCodRemitente]', 1,          1,
	'$_POST[cNomRemite]',	$RsJefe[iCodTrabajador]	)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
		
		if($_POST[iCodRemitente]>0){
	$sqlAddCargo="SP_DOC_SALIDA_MULTIPLE_INSERT '$RsUltTra[iCodTramite]' ,'$cCodificacion','$_POST[iCodRemitente]', $_SESSION['iCodOficinaLogin'], '$_POST['cAsunto']', '".$_SESSION['CODIGO_TRABAJADOR']."' , '$_POST[txtdirec_remitente]',		'$_POST[cCodDepartamento]',	'$_POST[cCodProvincia]',	 '$_POST[cCodDistrito]', '$_POST[cNomRemite]' ";
    		
		
   		//	echo $sqlAddCargo."<br>";
   			$rsAddCargo=sqlsrv_query($cnx,$sqlAddCargo);
  	}

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
    
		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, nFlgEnvio, cFlgTipoMovimiento )";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,            '".$_SESSION['iCodOficinaLogin']."', 1,                  6,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual', 1,                  1, 			1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
	
	$sqlMv="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodOfi]' ORDER BY iCodTemp ASC";
    $rsMv=sqlsrv_query($cnx,$sqlMv);
    while ($RsMv=sqlsrv_fetch_array($rsMv)){
			$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    	$sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar,   iCodIndicacionDerivar,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento, cFlgOficina)";
    	$sqlAdMv.=" VALUES ";
    	$sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,            '".$_SESSION['iCodOficinaLogin']."', '$RsMv['iCodOficina']', '$RsMv[iCodTrabajador]', '$RsMv[iCodIndicacion]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1, 						   4,                   1)";
    	$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    }

  	// relacion por ferencia
    $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodRef]'";
    $rsRefs=sqlsrv_query($cnx,$sqlRefs);
    if(sqlsrv_has_rows($rsRefs)>0){
    	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
				$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
				if(sqlsrv_has_rows($rsBusRef)>0){
					$RsBusRef=sqlsrv_fetch_array($rsBusRef);
					if($RsBusRef[nFlgTipoDoc]==1){						
							$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodOfi]'";
		    			$rsMv2=sqlsrv_query($cnx,$sqlMv2);
		    			$RsMv2=sqlsrv_fetch_array($rsMv2);
		
							//  Sql es ejecutado en SP
							//  El SP esta desarrollado pero no se ha hecho el reemplazo en las lineas de abajo porque no se sabe como probrar 
						//  $sqlAdRf.="SP_DOC_ENTRADA_MOV_INTERNO_REF_INSERT '$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual'  )";
		
							$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
		    			$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento	,			iCodTramiteDerivar)";
		    			$sqlAdRf.=" VALUES ";
		    			$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual',   1, 						    5	,			'$RsUltTra[iCodTramite]')";
		    			$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
		    	}
				}
				$sqlUpdR="UPDATE Tra_M_Tramite_Referencias SET iCodTramite='$RsUltTra[iCodTramite]', cDesEstado='REGISTRADO' WHERE iCodReferencia='$RsRefs[iCodReferencia]'";
				$rsUpdR=sqlsrv_query($cnx,$sqlUpdR);
    	}
    }
		$fFecActual2=date("d-m-Y G:i"); 
		unset($_SESSION[cCodRef]);
		unset($_SESSION[cCodOfi]);
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=fFecActual2 value=\"".$fFecActual2."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual2."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
		echo "<input type=hidden name=iCodRemitente value=\"".$_POST[iCodRemitente]."\">";
		echo "<input type=hidden name=nFlgTipoDoc value=3>";
		echo "<input type=hidden name=nFlgClaseDoc value=4>";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}		
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 18: // actualizar salida especial
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
    
    if($_POST[radioMultiple]==1){
    		$iCodRemitente="NULL";
    }Else{
    		$iCodRemitente=$_POST[iCodRemitente];
    }
	
    $separado2=explode("-",$_POST[cCodificacion]);
    $cCodificacion2=$separado2[0]."-".$separado2[1]."-".$separado2[2];
		
	//leer sigla oficina solicitante
    $rsSiglaSol=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$_POST[iCodOficinaSolicitado]'");
    $RsSiglaSol=sqlsrv_fetch_array($rsSiglaSol);
    
	// armar correlativo
    $cCodificacion=$cCodificacion2."-".trim($RsSiglaSol[cSiglaOficina]);	
	
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="iCodIndicacion=3, "; //conocimiento y fines
    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo, ";
    $sqlUpd.="cSiglaAutor='$_POST[cSiglaAutor]', ";
    $sqlUpd.="iCodRemitente=$iCodRemitente, ";
    $sqlUpd.="nFlgEnvio=1 ,";
	$sqlUpd.="cNomRemite='$_POST[cNomRemite]' , ";
	$sqlUpd.="iCodOficinaSolicitado='$_POST[iCodOficinaSolicitado]' , ";
	$sqlUpd.="cCodificacion= '$cCodificacion'  ";
	$sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
	
		$sqlBusCod="SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite= '$_POST[iCodTramite]' ";
		$rsBusCod=sqlsrv_query($cnx,$sqlBusCod);
		$RsBusCod=sqlsrv_fetch_array($rsBusCod);
		
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
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion])."-SALIDA.".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}
  	

  	$sqlMv="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]'";
    $rsMv=sqlsrv_query($cnx,$sqlMv);
	  $RsMv=sqlsrv_fetch_array($rsMv);
	  if(sqlsrv_has_rows($rsMv)==0){
  					$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    				$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   fFecMovimiento, nEstadoMovimiento, nFlgEnvio,	cFlgTipoMovimiento)";
    				$sqlAdMv.=" VALUES ";
    				$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 3,            '".$_SESSION['iCodOficinaLogin']."', 1,                  3,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1,				1)";
    				$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  	}
  	
   	// relacion por ferencia
    $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_POST[iCodTramite]'";
    $rsRefs=sqlsrv_query($cnx,$sqlRefs);
    if(sqlsrv_has_rows($rsRefs)>0){
    	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
    				$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
						$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
						if(sqlsrv_has_rows($rsBusRef)>0){
								$RsBusRef=sqlsrv_fetch_array($rsBusRef);
								if($RsBusRef[nFlgTipoDoc]==1){
										$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]' ORDER BY iCodMovimiento ASC";
    								$rsMv2=sqlsrv_query($cnx,$sqlMv2);
    								$RsMv2=sqlsrv_fetch_array($rsMv2);
										
										$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsBusRef[iCodTramite]' AND cFlgTipoMovimiento=5");
										
										$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    								$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   nFlgEnvio, cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,
iCodTramiteDerivar)";
    								$sqlAdRf.=" VALUES ";
    								$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', 1,         '$cCodificacion',  '$fFecActual',   1, 						    5,	'$RsUltTra[iCodTramite]')";
    								$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
    						}
						}
				}
    }
		// actualizacion de detalle	
	$sqlUpdMovimineto=" SP_DOC_ENTRADA_MOV '$_POST[iCodTramite]' ";	
	$rsUpdMovimineto=sqlsrv_query($cnx,$sqlUpdMovimineto);
	$RsUpdMovimineto=sqlsrv_fetch_array($rsUpdMovimineto);
	
	$sqlUpdMovE=" SP_DOC_SALIDA_MOV_UPDATE  '$_POST['cAsunto']', '$_POST[cObservaciones]','$fFecActual', '$RsUpdMovimineto[iCodMovimiento]','$_POST[iCodTramite]' ";	
	$rsUpdMovE=sqlsrv_query($cnx,$sqlUpdMovE);
	
	if($_POST[iCodRemitente]>0){
	$sqlRemx="SELECT iCodRemitente FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite='$_POST[iCodTramite]' ";
	$rsRemx=sqlsrv_query($cnx,$sqlRemx);
	$numRemx=sqlsrv_has_rows($rsRemx);
	if($numRemx < 1){
	$sqlAddRemx=" SP_DOC_SALIDA_MULTIPLE_INSERT '$_POST[iCodTramite]' ,'$RsBusCod[cCodificacion]','$iCodRemitente', $_SESSION['iCodOficinaLogin'], '$_POST['cAsunto']', '".$_SESSION['CODIGO_TRABAJADOR']."' , '$_POST[txtdirec_remitente]',		'$_POST[cCodDepartamento]',	'$_POST[cCodProvincia]',	 '$_POST[cCodDistrito]', '$_POST[cNomRemite]'";
    $rsAddRemx=sqlsrv_query($cnx,$sqlAddRemx);
		
	}
	if($numRemx = 1){
	$sqlAddRem=" UPDATE Tra_M_Doc_Salidas_Multiples "; 
	$sqlAddRem.=" SET iCodRemitente='$iCodRemitente' , ";
	$sqlAddRem.=" cDireccion ='$_POST[txtdirec_remitente]', ";
	$sqlAddRem.=" cDepartamento ='$_POST[cCodDepartamento]', ";
	$sqlAddRem.=" cProvincia ='$_POST[cCodProvincia]', ";
	$sqlAddRem.=" cDistrito ='$_POST[cCodDistrito]' ";
	$sqlAddRem.=" WHERE iCodTramite = '$_POST[iCodTramite]' ";
	$rsAddRem=sqlsrv_query($cnx,$sqlAddRem);
	}
	}
	unset($_SESSION[cCodRef]);
	unset($_SESSION[cCodOfi]);
		$fFecActual2=date("d-m-Y G:i"); 
		echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=POST name=form_envio action=registroInternoActualizado.php#area>";
		echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
   	echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
	echo "<input type=hidden name=fFecActual2 value=\"".$fFecActual2."\">";
   	echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "<input type=hidden name=nFlgTipoDoc value=3>";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";
	break;
  case 19: //añadir movimiento temporal
		for ($i=0;$i<count($_POST[lstOficinasSel]);$i++){
			$lstOficinasSel=$_POST[lstOficinasSel];
   		
   		$sqlTrb="SELECT TOP 1 * FROM Tra_M_Trabajadores WHERE iCodOficina='$lstOficinasSel[$i]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
      $rsTrb=sqlsrv_query($cnx,$sqlTrb);
      $RsTrb=sqlsrv_fetch_array($rsTrb);
			
			$sqlAdd="INSERT INTO Tra_M_Tramite_Temporal ";
    	$sqlAdd.="(iCodOficina,           iCodTrabajador,           iCodIndicacion,          cPrioridad,           cCodSession)";
    	$sqlAdd.=" VALUES ";
    	$sqlAdd.="('$lstOficinasSel[$i]', '$RsTrb[iCodTrabajador]', '$_POST[iCodIndicacion]', '$_POST[cPrioridad]', '$_SESSION[cCodOfi]')";
    	$rs=sqlsrv_query($cnx,$sqlAdd);
    	//echo $sqlAdd;
    	
    	sqlsrv_free_stmt($rsTrb);
		}  
    
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficina.php#area>";
   			echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_POST[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_POST[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_POST[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
  case 20: //añadir movimiento temporal
		for ($i=0;$i<count($_POST[lstOficinasSel]);$i++){
			$lstOficinasSel=$_POST[lstOficinasSel];
   		
   		$sqlTrb="SELECT TOP 1 * FROM Tra_M_Trabajadores WHERE iCodOficina='$lstOficinasSel[$i]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
      $rsTrb=sqlsrv_query($cnx,$sqlTrb);
      $RsTrb=sqlsrv_fetch_array($rsTrb);
			
    	$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    	$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento,cFlgOficina)";
    	$sqlAdMv.=" VALUES ";
    	$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$lstOficinasSel[$i]', '$RsTrb[iCodTrabajador]', '$_POST[iCodIndicacion]', '$_POST[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1,                 1)";
    	$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    		
    	//echo $sqlAdd;
    	
    	sqlsrv_free_stmt($rsTrb);
		}  
    
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficinaEdit.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."#area>";
   			echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_POST[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_POST[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_POST[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
  case 21: //añadir referencia temporal
		if ($_SESSION['cCodRef'] == ""){
		  	$Fecha = date("Ymd-Gis");	
		  	$_SESSION['cCodRef'] = $_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$Fecha;
		}
		  
		if ($_POST['iCodTramite'] != ""){
			$sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
	    $sqlAdd.="(iCodTramiteRef,	cReferencia, iCodTramite, cCodSession, cDesEstado, iCodTipo)";
	    $sqlAdd.=" VALUES ";
	    $sqlAdd.="('$_POST[iCodTramiteRef]','$_POST[cReferencia]', '$_POST[iCodTramite]','$_SESSION[cCodRef]', 'PENDIENTE', 1)";
		}else{
			$sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
		  $sqlAdd.="(iCodTramiteRef,	cReferencia, cCodSession, cDesEstado, iCodTipo)";
		  $sqlAdd.=" VALUES ";
		  $sqlAdd.="('$_POST[iCodTramiteRef]','$_POST[cReferencia]', '$_SESSION[cCodRef]', 'PENDIENTE', 1)";
	 	}

	  $rs = sqlsrv_query($cnx,$sqlAdd);
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";

		if ($_POST['sal'] == 3){
			echo "<form method=POST name=form_envio action=registroSalida.php#area>";
		}else if ($_POST['sal'] == 4){
			echo "<form method=POST name=form_envio action=registroEspecial.php#area>";
		}else if ($_POST['sal'] == 5){
			$sqlUP = "UPDATE Tra_M_Tramite SET nFlgEnvioNoti=3 WHERE iCodTramite='".$_POST[iCodTramiteRef]."'";
			$rs    = sqlsrv_query($cnx,$sqlUP);
			//	echo $sqlUP;
			//	update Tra_M_Tramite set nFlgEnvioNoti=3 where  iCodTramite=$_POST[iCodTramiteRef]
			echo "<form method=GET name=form_envio action=registroSinTupaEdit.php#area>";
			echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_POST[iCodOficinaResponsable]."\">";
			echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".$_POST[iCodTrabajadorResponsable]."\">";
			echo "<input type=hidden name=ActivarDestino value=\"".$_POST[ActivarDestino]."\">";
			echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
		}else if($_POST['sal']==1){
			$sqlUP = "UPDATE Tra_M_Tramite SET nFlgEnvioNoti = 3 WHERE iCodTramite='".$_POST[iCodTramiteRef]."'";
	    	$rs    = sqlsrv_query($cnx,$sqlUP);
			//	echo $sqlUP;
			//	update Tra_M_Tramite set nFlgEnvioNoti=3 where  iCodTramite=$_POST[iCodTramiteRef]
			// echo "<form method=POST name=form_envio action=registroSinTupaExterno.php#area>";
			echo "<form method=POST name=form_envio action=registroSinTupa.php#area>";
			echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_POST[iCodOficinaResponsable]."\">";
			echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".$_POST[iCodTrabajadorResponsable]."\">";
			echo "<input type=hidden name=ActivarDestino value=\"".$_POST[ActivarDestino]."\">";
		}else if ($_POST['sal'] == 2){
			$sqlUP = "UPDATE Tra_M_Tramite SET nFlgEnvioNoti = 3 WHERE iCodTramite='".$_POST[iCodTramiteRef]."'";
	    	$rs    = sqlsrv_query($cnx,$sqlUP);
			//	echo $sqlUP;
			//	update Tra_M_Tramite set nFlgEnvioNoti=3 where  iCodTramite=$_POST[iCodTramiteRef]
			echo "<form method=POST name=form_envio action=registroConTupa.php#area>";
			echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_POST[iCodOficinaResponsable]."\">";
			echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".$_POST[iCodTrabajadorResponsable]."\">";
			echo "<input type=hidden name=ActivarDestino value=\"".$_POST[ActivarDestino]."\">";
			echo "<input type=hidden name=iCodTupaClase value=\"".$_POST[iCodTupaClase]."\">";
			echo "<input type=hidden name=iCodTupa value=\"".$_POST['iCodTupa']."\">";
		}else if($_POST['sal']==7){ //Registro de entrada sin tupa (externo), es decir, de un usuario web
			$sqlUP = "UPDATE Tra_M_Tramite SET nFlgEnvioNoti = 3 WHERE iCodTramite='".$_POST[iCodTramiteRef]."'";
	    	$rs    = sqlsrv_query($cnx,$sqlUP);
			//	echo $sqlUP;
			//	update Tra_M_Tramite set nFlgEnvioNoti=3 where  iCodTramite=$_POST[iCodTramiteRef]
			// echo "<form method=POST name=form_envio action=registroSinTupaExterno.php#area>";
			echo "<form method=POST name=form_envio action=registroSinTupaExterno.php#area>";
			echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_POST[iCodOficinaResponsable]."\">";
			echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".$_POST[iCodTrabajadorResponsable]."\">";
			echo "<input type=hidden name=ActivarDestino value=\"".$_POST[ActivarDestino]."\">";
		}else if ($_POST['sal'] == 8){
			$sqlUP = "UPDATE Tra_M_Tramite SET nFlgEnvioNoti = 3 WHERE iCodTramite='".$_POST[iCodTramiteRef]."'";
	    	$rs    = sqlsrv_query($cnx,$sqlUP);
			//	echo $sqlUP;
			//	update Tra_M_Tramite set nFlgEnvioNoti=3 where  iCodTramite=$_POST[iCodTramiteRef]
			echo "<form method=POST name=form_envio action=registroConTupaAd.php#area>";
			echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_POST[iCodOficinaResponsable]."\">";
			echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".$_POST[iCodTrabajadorResponsable]."\">";
			echo "<input type=hidden name=ActivarDestino value=\"".$_POST[ActivarDestino]."\">";
			echo "<input type=hidden name=iCodTupaClase value=\"".$_POST[iCodTupaClase]."\">";
			echo "<input type=hidden name=iCodTupa value=\"".$_POST['iCodTupa']."\">";
		}else {
			echo "<form method=POST name=form_envio action=registroOficina.php#area>";
		}

		if ($_POST['sal'] == 4){
			echo "<input type=hidden name=iCodOficinaSolicitado value=\"".$_POST["iCodOficinaSolicitado"]."\">";	
		}
	  echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
	  echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
		echo "<input type=hidden name=cNroDocumento value=\"".$_POST['cNroDocumento']."\">";
	  echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
	  echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
		echo "<input type=hidden name=cNombreRemitente value=\"".$_POST[cNombreRemitente]."\">";
		echo "<input type=hidden name=cNomRemite value=\"".$_POST[cNomRemite]."\">";
		echo "<input type=hidden name=iCodRemitente value=\"".$_POST[iCodRemitente]."\">";
		echo "<input type=hidden name=Remitente value=\"".$_POST[Remitente]."\">";			
	  echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
	  echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
		echo "<input type=hidden name=cSiglaAutor value=\"".$_POST[cSiglaAutor]."\">";
		echo "<input type=hidden name=fechaDocumento value=\"".$_POST[fechaDocumento]."\">";
		echo "<input type=hidden name=archivoFisico value=\"".$_POST[archivoFisico]."\">";
	  echo "</form>";
	  echo "</body>";
	  echo "</html>";
	  break;
  case 22: //añadir referencia de oficina edit
   	$sqlAdMv="INSERT INTO Tra_M_Tramite_Referencias ";
    $sqlAdMv.="(iCodTramiteRef,				iCodTramite,          cReferencia, 	cCodSession, cDesEstado, iCodTipo)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$_POST[iCodTramiteRef]','$_POST[iCodTramite]', '$_POST[cReferencia]','$_SESSION[cCodRef]', 'REGISTRADO', 1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    //echo $sqlAdMv;
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
		if($_POST[sal]==3){
			echo "<form method=POST name=form_envio action=registroSalidaEdit.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";	
		}else if($_POST[sal]==4){
			echo "<form method=POST name=form_envio action=registroEspecialEdit.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";	
		}else{
			echo "<form method=POST name=form_envio action=registroOficinaEdit.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";
		}
		echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   	echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
			echo "<input type=hidden name=iCodOficinaSolicitado value=\"".$_POST[iCodOficinaSolicitado]."\">";
				echo "<input type=hidden name=cSiglaAutor value=\"".$_POST[cSiglaAutor]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
  case 23: //añadir movimiento temporal
		$sqlAdd="INSERT INTO Tra_M_Tramite_Temporal ";
    $sqlAdd.="(iCodOficina,              iCodTrabajador,             iCodIndicacion,            cPrioridad,          cCodSession)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="('$_POST[iCodOficinaMov]','$_POST[iCodTrabajadorMov]','$_POST[iCodIndicacionMov]','$_POST[cPrioridad]','$_SESSION[cCodOfi]')";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
			if($_POST[Especial]!=""){
   			echo "<form method=POST name=form_envio action=registroEspecial.php#area>";
			}
			else{
				echo "<form method=POST name=form_envio action=registroSalida.php#area>";
			}
   			echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
			echo "<input type=hidden name=iCodOficinaSolicitado value=\"".$_POST[iCodOficinaSolicitado]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_POST[nFlgRpta]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_POST[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
				echo "<input type=hidden name=cSiglaAutor value=\"".$_POST[cSiglaAutor]."\">";
				echo "<input type=hidden name=cNombreRemitente value=\"".$_POST[cNombreRemitente]."\">";
				echo "<input type=hidden name=cNomRemite value=\"".$_POST[cNomRemite]."\">";
				echo "<input type=hidden name=iCodRemitente value=\"".$_POST[iCodRemitente]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
  case 24: //añadir movimiento de oficina edit
    		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    		$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,       iCodTrabajadorDerivar,       iCodIndicacionDerivar,       cPrioridadDerivar,       cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento,cFlgOficina)";
    		$sqlAdMv.=" VALUES ";
    		$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaMov]', '$_POST[iCodTrabajadorMov]', '$_POST[iCodIndicacionMov]', '$_POST[cPrioridadMov]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 4,                 1)";
    		$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    		
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
			if($_POST[Especial]!=""){
			echo "<form method=POST name=form_envio action=registroEspecialEdit.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";	
			}
			else{
   			echo "<form method=POST name=form_envio action=registroSalidaCopy.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";
			}
			echo "<input type=hidden name=pag value=\"".$_POST[pag]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
  case 25: //añadir movimiento temporal
		for ($i=0;$i<count($_POST[lstOficinasSel]);$i++){
			$lstOficinasSel=$_POST[lstOficinasSel];
   		
   		$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$lstOficinasSel[$i]' and iCodCategoria=5";
   		
      $rsTrb=sqlsrv_query($cnx,$sqlTrb);
      $RsTrb=sqlsrv_fetch_array($rsTrb);
      
      		$sqlAdd="INSERT INTO Tra_M_Tramite_Temporal ";
    			$sqlAdd.="(iCodOficina,           iCodTrabajador,           iCodIndicacion,          cPrioridad,           cCodSession)";
    			$sqlAdd.=" VALUES ";
    			$sqlAdd.="('$lstOficinasSel[$i]', '$RsTrb[iCodTrabajador]', '$_POST[iCodIndicacionSel]', '$_POST[cPrioridad]', '$_SESSION[cCodSessionDrv]')";
    			
    			$rs=sqlsrv_query($cnx,$sqlAdd);
    	
    	sqlsrv_free_stmt($rsTrb);
		}  
    
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
			if(trim($_POST['iCodOficina'])!=""){
			echo "<form method=POST name=form_envio action=pendientesControlDerivarAdm.php?iCodMovimientoAccion=$_POST[iCodMovimiento]&iCodOficina=$_POST['iCodOficina']&clear=1#area>";
			}else{
   			echo "<form method=POST name=form_envio action=pendientesControlDerivar.php?clear=1#area>";
			}
			if($_POST['iCodMovimientoAccion']!=""){
			for ($h=0;$h<count($_POST['iCodMovimientoAccion']);$h++){
                    	$MovimientoAccion=$_POST['iCodMovimientoAccion'];
	      	echo "<input type=hidden name=MovimientoAccion[] value=\"".$MovimientoAccion[$h]."\">";
            	}            
			}
			if($_POST[iCodMovimientoAccion2]!=""){					    
            echo "<input type=hidden name=iCodMovimientoAccion value=\"".$_POST[iCodMovimientoAccion2]."\">";
            } 
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=iCodOficinaDerivar value=\"".$_POST[iCodOficinaDerivar]."\">";
   			echo "<input type=hidden name=iCodTrabajadorDerivar value=\"".$_POST[iCodTrabajadorDerivar]."\">";
   			echo "<input type=hidden name=iCodIndicacionDerivar value=\"".$_POST[iCodIndicacionDerivar]."\">";
   			echo "<input type=hidden name=cAsuntoDerivar value=\"".$_POST[cAsuntoDerivar]."\">";
   			echo "<input type=hidden name=cObservacionesDerivar value=\"".$_POST[cObservacionesDerivar]."\">";
   			echo "<input type=hidden name=nFlgCopias value=\"".$_POST[nFlgCopias]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
	case 26: //añadir movimiento temporal
		for ($i=0;$i<count($_POST[lstOficinasSel]);$i++){
			$lstOficinasSel=$_POST[lstOficinasSel];
   		
   		$sqlTrb="SELECT TOP 1 * FROM Tra_M_Trabajadores WHERE iCodOficina='$lstOficinasSel[$i]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
      $rsTrb=sqlsrv_query($cnx,$sqlTrb);
      $RsTrb=sqlsrv_fetch_array($rsTrb);
	 
	  $rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramiteDerivar,cNumDocumentoDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]' and iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' and (iCodTramiteDerivar!='' and iCodTramiteDerivar is not NULL)  ORDER BY iCodMovimiento DESC  ");
	  $RsUltTra=sqlsrv_fetch_array($rsUltTra);
      
    		$sqlCpy="INSERT INTO Tra_M_Tramite_Movimientos ";
				$sqlCpy.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,          iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,       cPrioridadDerivar,    cAsuntoDerivar, 	        cObservacionesDerivar,             cCodTipoDocDerivar,    fFecDerivar,  nEstadoMovimiento, fFecMovimiento, nFlgEnvio, cFlgTipoMovimiento, cNumDocumentoDerivar, iCodTramiteDerivar)";
				$sqlCpy.=" VALUES ";
				$sqlCpy.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', $_POST[nFlgTipoDoc], 	'".$_SESSION['iCodOficinaLogin']."', '$lstOficinasSel[$i]', '$RsTrb[iCodTrabajador]', '$_POST[iCodIndicacionSel]', '$_POST[cPrioridad]', '$_POST[cAsuntoDerivar]', '$_POST[cObservacionesDerivar]', '$_POST[cCodTipoDoc]', '$fFecActual', 1,                '$fFecActual',   1,				  4,  '$RsUltTra['cNumDocumentoDerivar']','$RsUltTra['iCodTramiteDerivar']')";
				$rsCpy=sqlsrv_query($cnx,$sqlCpy);

    	sqlsrv_free_stmt($rsTrb);
		}  
    
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=GET name=form_envio action=pendientesDerivadosEdit.php>";
   			echo "<input type=hidden name=iCodMovimientoDerivar value=\"".$_POST[iCodMovimientoDerivar]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
	 case 27: //eliminar variable
		 unset($_SESSION[cCodSessionDrv]);
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=pendientesControl.php>";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
	 case 28: //editar el responsable
	 	
				$sqlUp="  UPDATE Tra_M_Tramite_Temporal ";
    			$sqlUp.=" SET  iCodTrabajador = '$_POST[lstRespSel]' ";
    			$sqlUp.=" WHERE iCodTemp ='$_POST[cod]' ";
    			$rsUp=sqlsrv_query($cnx,$sqlUp);
    	    		 
		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
			if(trim($_POST['iCodOficina'])!=""){
			echo "<form method=POST name=form_envio action=pendientesControlDerivarAdm.php?iCodMovimientoAccion=$_POST[iCodMovimiento]&iCodOficina=$_POST['iCodOficina']&clear=1#area>";
			}else{
   			echo "<form method=POST name=form_envio action=pendientesControlDerivar.php?clear=1#area>";
			}
			if($_POST['iCodMovimientoAccion']!=""){
			for ($h=0;$h<count($_POST['iCodMovimientoAccion']);$h++){
                    	$MovimientoAccion=$_POST['iCodMovimientoAccion'];
	      	echo "<input type=hidden name=MovimientoAccion[] value=\"".$MovimientoAccion[$h]."\">";
            	}            
			}
			if($_POST[iCodMovimientoAccion2]!=""){					    
            echo "<input type=hidden name=iCodMovimientoAccion value=\"".$_POST[iCodMovimientoAccion2]."\">";
            } 
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=iCodOficinaDerivar value=\"".$_POST[iCodOficinaDerivar]."\">";
   			echo "<input type=hidden name=iCodTrabajadorDerivar value=\"".$_POST[iCodTrabajadorDerivar]."\">";
   			echo "<input type=hidden name=iCodIndicacionDerivar value=\"".$_POST[iCodIndicacionDerivar]."\">";
   			echo "<input type=hidden name=cAsuntoDerivar value=\"".$_POST[cAsuntoDerivar]."\">";
   			echo "<input type=hidden name=cObservacionesDerivar value=\"".$_POST[cObservacionesDerivar]."\">";
   			echo "<input type=hidden name=nFlgCopias value=\"".$_POST[nFlgCopias]."\">";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
	 case 29: //añadir referencia temporal en derivo
	$sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
    $sqlAdd.="(iCodTramiteRef,	cReferencia,          cCodSession, cDesEstado, iCodTipo)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="('$_POST[iCodTramiteRef]','$_POST[cReferencia]', '$_SESSION[cCodRef]', 'PENDIENTE', 2)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
			if($_POST[dev]==1){
			echo "<form method=POST name=form_envio action=pendientesControlDerivar.php#area>";
			}else{
   			echo "<form method=POST name=form_envio action=pendientesDerivadosEdit.php#area>";
			}
   			echo "<input type=hidden name=iCodMovimiento value=\"".$_POST[iCodMovimiento]."\">";
   			echo "<input type=hidden name=nFlgCopias value=\"".$_POST[nFlgCopias]."\">";
   			echo "<input type=hidden name=cFlgTipoMovimientoOrigen value=\"".$_POST[cFlgTipoMovimientoOrigen]."\">";
   			echo "<input type=hidden name=iCodMovimientoAccion value=\"".$_POST['iCodMovimientoAccion']."\">";
			echo "<input type=hidden name=iCodOficinaDerivar value=\"".$_POST[iCodOficinaDerivar]."\">";
			echo "<input type=hidden name=iCodTrabajadorDerivar value=\"".$_POST[iCodTrabajadorDerivar]."\">";
			echo "<input type=hidden name=iCodIndicacionDerivar value=\"".$_POST[iCodIndicacionDerivar]."\">";
			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";			
   			echo "<input type=hidden name=cAsuntoDerivar value=\"".$_POST[cAsuntoDerivar]."\">";
   			echo "<input type=hidden name=cObservacionesDerivar value=\"".$_POST[cObservacionesDerivar]."\">";
			echo "</form>";
   			echo "</body>";
   			echo "</html>";
		break;
	case 30: // Subir Digital - interno oficina
		$fFecActual2=date("d-m-Y G:i"); 	
		if ($_POST[fFecPlazo] != ""){
    		$separado2 = explode("-",$_POST[fFecPlazo]);
    		$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    	}else{
    		$fFecPlazo="NULL";
    	}
		//  Sql es ejecutado en SP
    	$fFecActual=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i",strtotime($_POST['fFecRegistro']));
 
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
			$cNombreOriginal = $_FILES['fileUpLoadDigital']['name'];
			if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
				$nFlgRestricUp=1;
			}else{
				$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion]).".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
					
				$sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) 
							VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
				$rsDigt  = sqlsrv_query($cnx,$sqlDigt);
			}
  		}
		unset($_SESSION[cCodRef]);
		unset($_SESSION[cCodOfi]);	
		echo "<html>";
   		echo "<head>";
   		echo "</head>";
   		echo "<body OnLoad=\"document.form_envio.submit();\">";
   		echo "<form method=POST name=form_envio action=registroInternoActualizado.php#area>";
		echo "<input type=hidden name=fFecActual2 value=\"".$fFecActual2."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
		echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
   		echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   		echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   		echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
		if ($nFlgRestricUp == 1){
			echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
			echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
		}   	
   		echo "</form>";
		break;
	case 31:
		if ($_SESSION[cCodRef] == ""){
		  	$Fecha = date("Ymd-Gis");	
		  	$_SESSION['cCodRef'] = $_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$Fecha;
		  }
	  	
	  	$nCodBarra = rand(1000000000,9999999999);
	  
	  	$max_chars = round(rand(5,10));  
		$chars = array();
		for($i="a";$i<"z";$i++){
	  		$chars[] = $i;
	  		$chars[] = "z";
		}
		for ($i=0; $i<$max_chars; $i++){
	  		$letra = round(rand(0, 1));
	  		if ($letra){
	  			$clave.= $chars[round(rand(0,count($chars)-1))];
	  		}else{
	  			$clave.= round(rand(0, 9));
	  		}
		}
		$cPassword = $clave;
		
	    $rsCorr = sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo 
	    					   FROM Tra_M_Correlativo 
	    					   WHERE nFlgTipoDoc = 1 AND nNumAno='$nNumAno'");

		$RsCorr = sqlsrv_fetch_array($rsCorr);
		$CorrelativoAsignar = $RsCorr[nCorrelativo] + 1;
			
		$rsUpdCorr = sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo 
								  SET nCorrelativo = '$CorrelativoAsignar' 
								  WHERE nFlgTipoDoc = 1 AND nNumAno='$nNumAno'");
		
		// ORIGINAL		
		// $cCodificacion = date("Y").add_ceros($CorrelativoAsignar,5);

		// INICIO DE MODIFICACION
		$sqlSede = "SELECT TD.CODIGO_SEDE AS 'CODIGO_SEDE' FROM Tra_M_Trabajadores TT
					INNER JOIN Tra_U_Departamento TD ON TT.CODIGO_SEDE = TD.CODIGO_SEDE
					WHERE TT.iCodTrabajador = '".$_SESSION['CODIGO_TRABAJADOR']."'";
		$rsSede = sqlsrv_query($cnx,$sqlSede);
		$RsSede = sqlsrv_fetch_array($rsSede);
		$codigo_sede = $RsSede['CODIGO_SEDE'];

	    $year = substr(date("Y"), -2);
	    $cCodificacion = "E".add_ceros($CorrelativoAsignar,5).$year.$codigo_sede;
	    // FIN DE MODIFICACION
	  	
	    if ($_POST['nFlgClaseDoc'] == 1){ //sql con tupa
			//  Sql es ejecutado en SP
			$cNroDocumento	= stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
			$cNomRemite		= stripslashes(htmlspecialchars($_POST[cNomRemite], ENT_QUOTES));
			$cAsunto		= stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
			$cObservaciones	= stripslashes(htmlspecialchars($_POST[cObservaciones], ENT_QUOTES));
			$nNumFolio		= stripslashes(htmlspecialchars($_POST[nNumFolio], ENT_QUOTES));
			$cReferencia	= stripslashes(htmlspecialchars($_POST[cReferencia], ENT_QUOTES));
			
			if ($_POST[nFlgEnvio] == ""){
				$_POST[nFlgEnvio] = 1;
			}else  
				if ($_POST[nFlgEnvio] == 1){
					$_POST[nFlgEnvio] = "";
				}

			$cObservaciones = htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES);
	      	$sqlAdd = "SP_DOC_ENTRADA_CON_TUPA_INSERT '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$cNroDocumento', '$_POST[iCodRemitente]', '$cNomRemite', '$cAsunto', '$cObservaciones', '$_POST[iCodTupaClase]', '$_POST['iCodTupa']', '$cReferencia', '$_POST[iCodIndicacion]', '$nNumFolio', '$_POST[nTiempoRespuesta]', '$_POST[nFlgEnvio]',  '$fFecActual', '$nCodBarra', '$cPassword'";
	    }
	    
	    if ($_POST['nFlgClaseDoc'] == 2){ //sql sin tupa
			$cNroDocumento	= stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
			$cNomRemite		= stripslashes(htmlspecialchars($_POST[cNomRemite], ENT_QUOTES));
			$cAsunto		= stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
			$cObservaciones	= stripslashes(htmlspecialchars($_POST[cObservaciones], ENT_QUOTES));
			$nNumFolio		= stripslashes(htmlspecialchars($_POST[nNumFolio], ENT_QUOTES));
			$cReferencia	= stripslashes(htmlspecialchars($_POST[cReferencia], ENT_QUOTES));
			
			if ($_POST[nFlgEnvio] == ""){
				$_POST[nFlgEnvio] = 1;
			}else  
				if($_POST[nFlgEnvio] == 1){
					$_POST[nFlgEnvio] = "";
				}
				//  Sql es ejecutado en SP
				$sqlAdd.="SP_DOC_ENTRADA_SIN_TUPA_INSERT '$cCodificacion','".$_SESSION['CODIGO_TRABAJADOR']."','".$_SESSION['iCodOficinaLogin']."','$_POST[cCodTipoDoc]','$fFecActual','$cNroDocumento','$_POST[iCodRemitente]','$cNomRemite','$cAsunto','$cObservaciones','$cReferencia','$_POST[iCodIndicacion]','$nNumFolio','$_POST[nTiempoRespuesta]','$_POST[nFlgEnvio]','$fFecActual','$nCodBarra','$cPassword','$_POST[fechaDocumento]',''";
	    }
	    $rs = sqlsrv_query($cnx,$sqlAdd);
	    
	    $rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite 
	    						 WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."' 
	    						 ORDER BY iCodTramite DESC");
		$RsUltTra = sqlsrv_fetch_array($rsUltTra);
	    
	    for ($h=0; $h<count($_POST[iCodTupaRequisito]); $h++){
	      	$iCodTupaRequisito = $_POST[iCodTupaRequisito];
			//  Sql es ejecutado en SP
			$sqlIns = "SP_DOC_ENTRADA_REQ_CON_TUPA_INSERT '$iCodTupaRequisito[$h]', '$RsUltTra[iCodTramite]' ";     	
			//	$sqlIns="INSERT INTO Tra_M_Tramite_Requisitos (iCodTupaRequisito, iCodTramite) VALUES ('$iCodTupaRequisito[$h]', '$RsUltTra[iCodTramite]') ";
	   		$rsIns = sqlsrv_query($cnx,$sqlIns);
		}
			
		if ($_POST[iCodOficinaResponsable] != ""){
			//  Sql es ejecutado en SP			
			$sqlMov = "SP_DOC_ENTRADA_MOVIMIENTO_INSERT '$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST[iCodIndicacion]', '$fFecActual',  '$fFecActual',   '$_POST[nFlgEnvio]'";
	   		$rsMov = sqlsrv_query($cnx,$sqlMov);
	   	}
	   	
		if ($_FILES['fileUpLoadDigital']['name'] != ""){
			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
	  		$num = count($extension)-1;
	  		$cNombreOriginal = $_FILES['fileUpLoadDigital']['name'];
			if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
				$nFlgRestricUp = 1;
			}else{
				$nuevo_nombre = $cCodificacion."-".$RsUltTra[iCodTramite].".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
							
				$sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) 
							VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
	   			$rsDigt  = sqlsrv_query($cnx,$sqlDigt);
	   		}
	  	}	
		
		$sqlRefcnt = "SELECT COUNT(iCodReferencia) AS CntRef FROM Tra_M_Tramite_Referencias WHERE cCodSession='".$_SESSION[cCodRef]."'";
		$rsCnT1    = sqlsrv_query($cnx,$sqlRefcnt);
		$RsCnT2    = sqlsrv_fetch_array($rsCnT1);
		$conteo2   = $RsCnT2[0];
		
		if ($conteo2 >= 1){
			$sqlTraF = "SELECT TOP 1 iCodTramite FROM Tra_M_Tramite where iCodTrabajadorRegistro='".$_SESSION['CODIGO_TRABAJADOR']."' order by fFecRegistro desc";
			$rsTraf1 = sqlsrv_query($cnx,$sqlTraF);
			$RsTraf2 = sqlsrv_fetch_array($rsTraf1);
		
			$sqlUptRef = "UPDATE Tra_M_Tramite_Referencias   SET iCodTramite = '".$RsTraf2[0]."'  WHERE cCodSession='".$_SESSION[cCodRef]."'";
			$rsUptr    = sqlsrv_query($cnx,$sqlUptRef);
		}

		unset($_SESSION[cCodRef]);
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroConcluido.php>";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
		echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=\"".$_POST[nFlgClaseDoc]."\">";
		
		if($nFlgRestricUp == 1){
			echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
			echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
		}
		echo "</form>";
		echo "</body>";
		echo "</html>";
		break;
	}
	// FIN DE TODOS LOSCASE CON POST
	
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
  if ($_GET[opcion] == 19){ //retirar referencia
   if ($_GET[sal] == 1 or $_GET[sal] == 2){
	  $sqlAn  = "SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='".$iCodReferencia."'";
	  $rsAn   = sqlsrv_query($cnx,$sqlAn);
    $RsRefs = sqlsrv_fetch_array($rsAn);
	  //echo $sqlAn;
	  // $sqlUP="SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$RsRefs[iCodTramiteRef]."'";
	  // $rsUP=sqlsrv_query($cnx,$sqlUP);
    // $RsUp=sqlsrv_fetch_array($rsUP);
	  $sqlUP = "UPDATE Tra_M_Tramite SET nFlgEnvioNoti = 1 WHERE iCodTramite='".$RsRefs[iCodTramiteRef]."'";
    $rs    = sqlsrv_query($cnx,$sqlUP);
		//	update Tra_M_Tramite set nFlgEnvioNoti=3 where  iCodTramite=$_POST[iCodTramiteRef]
		//	echo $sqlUP;
	 }
	 $rsDel = sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='$_GET[iCodReferencia]'");
   echo "<html>";
   echo "<head>";
   echo "</head>";
   echo "<body OnLoad=\"document.form_envio.submit();\">";
   if ($_GET[sal] == 3){
   	echo "<form method=POST name=form_envio action=registroSalida.php#area>";
		}else if ($_GET[sal] == 4){
    	echo "<form method=POST name=form_envio action=registroEspecial.php#area>";
		}else if ($_GET[sal] == 1){
			echo "<form method=POST name=form_envio action=registroSinTupa.php#area>";
			echo "<input type=hidden name=cNroDocumento value=\"".$_GET['cNroDocumento']."\">";
			echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
			echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')."\">";
			echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_GET[iCodOficinaResponsable]."\">";
			echo "<input type=hidden name=ActivarDestino value=\"".$_GET[ActivarDestino]."\">";
		}else if ($_GET[sal] == 2){
			echo "<form method=POST name=form_envio action=registroConTupa.php#area>";
			echo "<input type=hidden name=cNroDocumento value=\"".$_GET['cNroDocumento']."\">";
			echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
			echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')."\">";
			echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_GET[iCodOficinaResponsable]."\">";
			echo "<input type=hidden name=ActivarDestino value=\"".$_GET[ActivarDestino]."\">";
			echo "<input type=hidden name=iCodTupaClase value=\"".$_GET[iCodTupaClase]."\">";
			echo "<input type=hidden name=iCodTupa value=\"".$_GET['iCodTupa']."\">";
		}
		if($_GET["sal"]==4){
			echo "<input type=hidden name=iCodOficinaSolicitado value=\"".$_GET["iCodOficinaSolicitado"]."\">";	
		}
	
		echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
   	echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
		//echo "<input type=hidden name=cNroDocumento value=\"".$_GET['cNroDocumento']."\">";
   	echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
		echo "<input type=hidden name=cNombreRemitente value=\"".$_GET[cNombreRemitente]."\">";
		echo "<input type=hidden name=cNomRemite value=\"".$_GET[cNomRemite]."\">";
		echo "<input type=hidden name=iCodRemitente value=\"".$_GET[iCodRemitente]."\">";
		echo "<input type=hidden name=Remitente value=\"".$_GET[Remitente]."\">";			
   	echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
   	echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
		echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">";
		echo "<input type=hidden name=archivoFisico value=\"".$_GET[archivoFisico]."\">";
		echo "<input type=hidden name=fechaDocumento value=\"".$_GET[fechaDocumento]."\">";
   	echo "</form>";
   	echo "</body>";
   	echo "</html>";
	}
  if ($_GET[opcion] == 20){ //retirar referencia
	$rsDel = sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='$_GET[iCodReferencia]'");
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
	if($_GET[sal]==3){
	echo "<form method=POST name=form_envio action=registroSalidaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI].">";
	}
	else if($_GET[sal]==4){
	echo "<form method=POST name=form_envio action=registroEspecialEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI].">";
	}
	else if($_GET[sal]==1){
	echo "<form method=POST name=form_envio action=registroSinTupaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI].">";
	echo "<input type=hidden name=cNroDocumento value=\"".$_GET['cNroDocumento']."\">";
	echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
	echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')."\">";
	echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_GET[iCodOficinaResponsable]."\">";
	echo "<input type=hidden name=ActivarDestino value=\"".$_GET[ActivarDestino]."\">";

	}
	else {
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
	if($_GET[opcion]==29){ //retirar referencia
		$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='$_GET[iCodReferencia]'");
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
    if($_GET[dev]==1){
    echo "<form method=POST name=form_envio action=pendientesControlDerivar.php#area>";
	}else{
   	echo "<form method=POST name=form_envio action=pendientesDerivadosEdit.php#area>";
	}
   echo "<input type=hidden name=iCodMovimiento value=\"".$_GET[iCodMovimiento]."\">";
   echo "<input type=hidden name=nFlgCopias value=\"".$_GET[nFlgCopias]."\">";
   echo "<input type=hidden name=cFlgTipoMovimientoOrigen value=\"".$_GET[cFlgTipoMovimientoOrigen]."\">";
   echo "<input type=hidden name=iCodMovimientoAccion value=\"".$_GET[iCodMovimientoAccion]."\">";
   echo "<input type=hidden name=iCodOficinaDerivar value=\"".$_GET[iCodOficinaDerivar]."\">";
   echo "<input type=hidden name=iCodTrabajadorDerivar value=\"".$_GET['iCodTrabajadorDerivar']."\">";
   echo "<input type=hidden name=iCodIndicacionDerivar value=\"".$_GET[iCodIndicacionDerivar]."\">";
   echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   echo "<input type=hidden name=cAsuntoDerivar value=\"".$_GET[cAsuntoDerivar]."\">";
   echo "<input type=hidden name=cObservacionesDerivar value=\"".$_GET[cObservacionesDerivar]."\">";
   echo "</form>";
   echo "</body>";
   echo "</html>";
	}

	if($_GET[opcion]==30){ //retirar documento electrónico
		$sqlFiles = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'"; 
		$rsFiles  = sqlsrv_query($cnx,$sqlFiles);
		$RsFiles  = sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload2.trim($RsFiles[documentoElectronico]))){ 
   	     unlink($rutaUpload2.trim($RsFiles[documentoElectronico])); 
	   }
    $rsDel=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite 
    					SET documentoElectronico = NULL,
    						codigoQr = NULL
    					WHERE iCodTramite='$_GET[iCodTramite]'");
		header("Location: registroOficinaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}
	if($_GET[opcion]==31){ //retirar documento electrónico salida
		$sqlFiles = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'"; 
		$rsFiles  = sqlsrv_query($cnx,$sqlFiles);
		$RsFiles  = sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload2.trim($RsFiles[documentoElectronico]))){ 
   	     unlink($rutaUpload2.trim($RsFiles[documentoElectronico])); 
	   }
    $rsDel=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite 
    					SET documentoElectronico = NULL,
    						codigoQr = NULL
    					WHERE iCodTramite='$_GET[iCodTramite]'");
		header("Location: registroSalidaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}
	if($_GET[opcion]==32){ //retirar documento complementario salida
		$sqlFiles = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'"; 
		$rsFiles  = sqlsrv_query($cnx,$sqlFiles);
		$RsFiles  = sqlsrv_fetch_array($rsFiles);
	   if (file_exists($rutaUpload.trim($RsFiles[cNombreNuevo]))){ 
   	     unlink($rutaUpload.trim($RsFiles[cNombreNuevo])); 
	   }

	   $rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Digitales WHERE iCodDigital='$_GET[iCodDigital]'");
		header("Location: registroSalidaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."#area");
	}
}else{
	header("Location: ../index-b.php?alter=5");
}
?>