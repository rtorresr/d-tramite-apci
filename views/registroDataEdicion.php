<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
	include_once("../conexion/conexion.php");
	$fFecRegistro  = date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i:s", strtotime($_POST['fFecRegistro']));
	$fFecDocumento = date("Ymd", strtotime($_POST['fFecDocumento']))." ".date("G:i:s", strtotime($_POST['fFecDocumento']));
	$fFecActual    = date("Ymd")." ".date("G:i:s");
	$rutaUpload    = "../docs/";
	$nNumAno       = date("Y");
	
  function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
    	for($m=0; $m<$dif_diez; $m++){
            @$insertar_ceros .= 0;
    	}
    	return $insertar_ceros .= $numero;
  }	
  switch ($_POST[opcion]) {
  case 1: //registro de documentos de entrada
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
		
   // $rsCorr=sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo FROM Tra_M_Correlativo WHERE nFlgTipoDoc=1 AND nNumAno='$nNumAno'");
	//	$RsCorr=sqlsrv_fetch_array($rsCorr);
	//	$CorrelativoAsignar=$RsCorr[nCorrelativo]+1;
		
	//	$rsUpdCorr=sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo SET nCorrelativo='$CorrelativoAsignar' WHERE nFlgTipoDoc=1 AND nNumAno='$nNumAno'");
		
	//	$cCodificacion=date("Y").add_ceros($CorrelativoAsignar,5);
  	
    if ($_POST[nFlgClaseDoc] == 1){ //sql con tupa
    	$sqlAdd="INSERT INTO Tra_M_Tramite ";
    	$sqlAdd.="(nFlgTipoDoc,cCodificacion,iCodTrabajadorRegistro,cCodTipoDoc,fFecDocumento,cNroDocumento,iCodRemitente,           cNomRemite,cAsunto,cObservaciones,iCodTupaClase,iCodTupa,cReferencia,iCodIndicacion,nNumFolio,nTiempoRespuesta,           nFlgEnvio,nFlgClaseDoc,fFecRegistro,nCodBarra,cPassword,nFlgEstado,FECHA_DOCUMENTO, ARCHIVO_FISICO)";
    	$sqlAdd.=" VALUES ";
    	$sqlAdd.="(1,UPPER('$_POST[cCodificacion]'),'$_POST[iCodTrabajadorRegistro]','$_POST[cCodTipoDoc]','$fFecDocumento','".$_POST['cNroDocumento']."','$_POST[iCodRemitente]',UPPER('$_POST[cNomRemite]'),'$_POST['cAsunto']','$_POST[cObservaciones]','$_POST[iCodTupaClase]','$_POST['iCodTupa']','$_POST[cReferencia]','$_POST[iCodIndicacion]','$_POST[nNumFolio]','$_POST[nTiempoRespuesta]','$_POST[nFlgEnvio]', 1,'$fFecRegistro','$nCodBarra','$cPassword',1,'$fFecDocumento'	,'$_POST[archivoFisico]')";
    	//echo $sqlAdd;
    }
    if ($_POST[nFlgClaseDoc] == 2){ //sql sin tupa
			$sqlOfiT = "SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]' AND nFlgEstado = 1 ";
			$rsOfiT  = sqlsrv_query($cnx,$sqlOfiT);
			$RsOfiT  = sqlsrv_fetch_array($rsOfiT);
	   	$sqlAdd  = "INSERT INTO Tra_M_Tramite ";
    	$sqlAdd.="(nFlgTipoDoc,cCodificacion,iCodTrabajadorRegistro,iCodOficinaRegistro,cCodTipoDoc,fFecDocumento,cNroDocumento,           iCodRemitente,cNomRemite,cAsunto,cObservaciones,cReferencia,iCodIndicacion,nNumFolio,nTiempoRespuesta,nFlgEnvio,           nFlgClaseDoc,fFecRegistro,nCodBarra,cPassword,nFlgEstado,FECHA_DOCUMENTO,ARCHIVO_FISICO)";
    	$sqlAdd.=" VALUES ";
    	$sqlAdd.="(1,UPPER('$_POST[cCodificacion]'),'$_POST[iCodTrabajadorRegistro]','$RsOfiT['iCodOficina']','$_POST[cCodTipoDoc]','$fFecDocumento','".$_POST['cNroDocumento']."','$_POST[iCodRemitente]',UPPER('$_POST[cNomRemite]'),'$_POST['cAsunto']','$_POST[cObservaciones]','$_POST[cReferencia]','$_POST[iCodIndicacion]','$_POST[nNumFolio]','$_POST[nTiempoRespuesta]', '$_POST[nFlgEnvio]', 2,              '$fFecRegistro','$nCodBarra','$cPassword',1,'$_POST['fFecDocumento']','$_POST[archivoFisico]')";
    }
    $rs =sqlsrv_query($cnx,$sqlAdd);
    
    $rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
    For ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      	$iCodTupaRequisito= $_POST[iCodTupaRequisito];
				$sqlIns="INSERT INTO Tra_M_Tramite_Requisitos (iCodTupaRequisito, iCodTramite) VALUES ('$iCodTupaRequisito[$h]', '$RsUltTra[iCodTramite]') ";
   			$rsIns=sqlsrv_query($cnx,$sqlIns);
		}
		
		if($_POST[iCodOficinaResponsable]!=""){
			
				$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
				$sqlMov.="(iCodTramite,              iCodTrabajadorRegistro,         nFlgTipoDoc, iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    iCodIndicacionDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,          cFlgTipoMovimiento)";
				$sqlMov.=" VALUES ";
				$sqlMov.="('$RsUltTra[iCodTramite]', '$_POST[iCodTrabajadorRegistro]', 1,           '1', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST[iCodIndicacion]', '$fFecRegistro', 1,                '$fFecRegistro',   '$_POST[nFlgEnvio]',1)";
   			$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}
   	
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$nombre = count($extension)-2;
  			$nombre_en_bruto = $extension[$nombre];
  			$nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
				$nuevo_nombre = $cCodificacion."-".$RsUltTra[iCodTramite].".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
  	}
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroConcluido.php>";
		echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=\"".$_POST[nFlgClaseDoc]."\">";
		echo "<input type=hidden name=fFecDocumento value=\"".$_POST['fFecDocumento']."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
  case 2: //registrar interno oficinas
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
   
    // comprobar o recoger correlativo
   
   // $sqlCorr="SELECT * FROM Tra_M_Correlativo_Oficina WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
    //$rsCorr=sqlsrv_query($cnx,$sqlCorr);
    //if(sqlsrv_has_rows($rsCorr)>0){
    	//$RsCorr=sqlsrv_fetch_array($rsCorr);
    	//$nCorrelativo=$RsCorr[nCorrelativo]+1;
    	
    	//$sqlUpd="UPDATE Tra_M_Correlativo_Oficina SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
			//$rsUpd=sqlsrv_query($cnx,$sqlUpd);
    //}Else{
    	//$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Oficina (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    //	$rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
    //	$nCorrelativo=1;
    //}
    
    //leer oficina
    $rsOfi=sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]' And nFlgEstado=1 ");
    $RsOfi=sqlsrv_fetch_array($rsOfi);
    
	// Jefe de Oficina 
    $rsJefe=sqlsrv_query($cnx,"SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina='$RsOfi['iCodOficina']' AND iCodCategoria='5' ");
	$RsJefe=sqlsrv_fetch_array($rsJefe);
    // armar correlativo
	
    //$cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-PCM/".trim($RsSigla[cSiglaOficina]);
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc,			 nFlgClaseDoc,			 cCodificacion, 		iCodTrabajadorRegistro,   iCodOficinaRegistro,      		
			   cCodTipoDoc,      	 fFecDocumento,		iCodTrabajadorSolicitado, 	cReferencia, 				cAsunto,          
			   cObservaciones, 		 nFlgRpta,			nNumFolio,					fFecPlazo,    				nFlgEnvio,          
			   fFecRegistro, 		 cSiglaAutor, 		nFlgEstado)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(		2,           1,          UPPER('$_POST[cCodificacion]'),	'$_POST[iCodTrabajadorRegistro]',		'$RsOfi['iCodOficina']', 	
				'$_POST[cCodTipoDoc]', '$fFecDocumento', '$RsJefe[iCodTrabajador]', '$_POST[cReferencia]', 	'$_POST['cAsunto']', 
				'$_POST[cObservaciones]',  '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, 			'$_POST[nFlgEnvio]', '$fFecRegistro',UPPER('$_POST[cSiglaAutor]'), 1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);

		//Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
		
	$sqlMv="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSession]' ORDER BY iCodTemp ASC";
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
		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar,   iCodIndicacionDerivar,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,  cFlgOficina)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$RsUltTra[iCodTramite]', '$_POST[iCodTrabajadorRegistro]',     2,          '$RsOfi['iCodOficina']', '$RsMv['iCodOficina']', '$RsMv[iCodTrabajador]', '$RsMv[iCodIndicacion]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1, 				'$cFlgTipoMovimiento',1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
			
   }
  
 // relacion por ferencias
    $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodSession]'";
    $rsRefs=sqlsrv_query($cnx,$sqlRefs);
    if(sqlsrv_has_rows($rsRefs)>0){
    	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
				$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
				if(sqlsrv_has_rows($rsBusRef)>0){
					$RsBusRef=sqlsrv_fetch_array($rsBusRef);
					if($RsBusRef[nFlgTipoDoc]==1){						
							$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSession]'";
		    			$rsMv2=sqlsrv_query($cnx,$sqlMv2);
		    			$RsMv2=sqlsrv_fetch_array($rsMv2);
		
							//  Sql es ejecutado en SP
							//  El SP esta desarrollado pero no se ha hecho el reemplazo en las lineas de abajo porque no se sabe como probrar 
						//  $sqlAdRf.="SP_DOC_ENTRADA_MOV_INTERNO_REF_INSERT '$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual'  )";
		
							$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
		    			$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento	,			iCodTramiteDerivar)";
		    			$sqlAdRf.=" VALUES ";
		    			$sqlAdRf.="('$RsBusRef[iCodTramite]',  '$_POST[iCodTrabajadorRegistro]',     2,          '$RsOfi['iCodOficina']', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', UPPER('$_POST[cCodificacion]'),  '$fFecActual',   1, 						    5	,			'$RsUltTra[iCodTramite]')";
		    			$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
		    	}
				}
				$sqlUpdR="UPDATE Tra_M_Tramite_Referencias SET iCodTramite='$RsUltTra[iCodTramite]', cCodSession='' WHERE iCodReferencia='$RsRefs[iCodReferencia]'";
				$rsUpdR=sqlsrv_query($cnx,$sqlUpdR);
    	}
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
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",'$_POST[cCodificacion]').".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}
  	
    unset($_SESSION[cCodSession]);
    
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
		echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=1>";
		if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
  case 3: //a�adir movimiento temporal
		$sqlAdd="INSERT INTO Tra_M_Tramite_Temporal ";
    $sqlAdd.="(iCodOficina,              iCodTrabajador,             iCodIndicacion,            cPrioridad,          cCodSession)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="('$_POST[iCodOficinaMov]','$_POST[iCodTrabajadorMov]','$_POST[iCodIndicacionMov]','$_POST[cPrioridad]','$_SESSION[cCodSession]')";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficinaAd.php#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
			echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   			echo "<input type=hidden name=fFecDocumento value=\"".$_POST['fFecDocumento']."\">";
			echo "<input type=hidden name=fFecRegistro value=\"".$_POST['fFecRegistro']."\">";
			echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
			echo "<input type=hidden name=iCodTrabajadorRegistro value=\"".$_POST[iCodTrabajadorRegistro]."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_POST[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=iCodIndicacion value=\"".$_POST[iCodIndicacion]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_POST[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_POST[fFecPlazo]."\">";
			echo "<input type=hidden name=cSiglaAutor value=\"".$_POST[cSiglaAutor]."\">";
			echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
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
    
    // armar correlativo
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-SITDD/".trim($RsSigla[cSiglaOficina])."-".strtoupper(trim($RsNomUsr[cUsuario]));
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        cCodTipoDoc,           fFecDocumento,	cAsunto,           cObservaciones,           fFecPlazo,    fFecRegistro, nFlgEstado)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(2,           2,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST['cAsunto']', '$_POST[cObservaciones]', $fFecPlazo, '$fFecActual',1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
    if($_FILES['fileUpLoadDigital']['name']!=""){
    		$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
			  $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			  $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			  
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
				$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
  	}
    
		for ($i=0;$i<count($_POST[lstTrabajadoresSel]);$i++){
			$lstTrabajadoresSel=$_POST[lstTrabajadoresSel];
			//echo "<li>".$lstTrabajadoresSel[$i];    
			// agragar nuevo movimiento por accion ENVIAR
			$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,								nFlgTipoDoc, iCodTrabajadorRegistro,				 iCodOficinaOrigen,           fFecMovimiento,  nEstadoMovimiento, iCodTrabajadorEnviar,      cObservacionesEnviar, 		 fFecEnviar,    cFlgTipoMovimiento, nFlgEnvio)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$RsUltTra[iCodTramite]', '2', 				 '".$_SESSION['CODIGO_TRABAJADOR']."', $_SESSION['iCodOficinaLogin'], '$fFecActual',   1,									'$lstTrabajadoresSel[$i]', '$_POST[cObservaciones]', '$fFecActual', 2,                  '$_POST[nFlgEnvio]')";
   		$rsMov=sqlsrv_query($cnx,$sqlMov);
		}
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=2>";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 5: // registro salida
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
   
    // comprobar o recoger correlativo
   
   // $sqlCorr="SELECT * FROM Tra_M_Correlativo_Salida WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
   // $rsCorr=sqlsrv_query($cnx,$sqlCorr);
    //if(sqlsrv_has_rows($rsCorr)>0){
    //	$RsCorr=sqlsrv_fetch_array($rsCorr);
    //	$nCorrelativo=$RsCorr[nCorrelativo]+1;
    	
    //	$sqlUpd="UPDATE Tra_M_Correlativo_Salida SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
		//	$rsUpd=sqlsrv_query($cnx,$sqlUpd);
    //}Else{
    	//$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Salida (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    //	$rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
    //	$nCorrelativo=1;
    //}
    
    //leer  oficina
   $rsOfi=sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]'");
    $RsOfi=sqlsrv_fetch_array($rsOfi);
    
    // Jefe de Oficina 
    $rsJefe=sqlsrv_query($cnx,"SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina='$RsOfi['iCodOficina']' AND iCodCategoria='5' ");
	$RsJefe=sqlsrv_fetch_array($rsJefe);
    
	$sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,     		iCodOficinaRegistro,   cCodTipoDoc,           fFecDocumento,	iCodTrabajadorSolicitado, 				  cReferencia, 				   cAsunto,           cObservaciones, 				   iCodIndicacion, 					 nFlgRpta,					 nNumFolio,						fFecPlazo, cSiglaAutor,   				fFecRegistro,	 iCodRemitente,					nFlgEstado, 	nFlgEnvio, 				cNomRemite)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(3,           1,		UPPER('$_POST[cCodificacion]'),'$_POST[iCodTrabajadorRegistro]', '$RsOfi['iCodOficina']', '$_POST[cCodTipoDoc]', '$fFecDocumento', '$RsJefe[iCodTrabajador]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', 3    , '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, UPPER('$_POST[cSiglaAutor]'), '$fFecRegistro', '$_POST[iCodRemitente]',1,		1,	
	UPPER('$_POST[cNomRemite]'))";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
		
		if(!empty($_POST[iCodRemitente])){
		$sqlAddCargo="INSERT INTO Tra_M_Doc_Salidas_Multiples ";
  		$sqlAddCargo.="(iCodTramite,              cCodificacion,    iCodRemitente,          iCodOficina,                  cAsunto,          cFlgEnvio, iCodTrabajadorRegistro,	cFlgEstado) ";
   		$sqlAddCargo.="VALUES ";
   		$sqlAddCargo.="('$RsUltTra[iCodTramite]' ,UPPER('$_POST[cCodificacion]'),'$_POST[iCodRemitente]',  '$RsOfi['iCodOficina']', '$_POST['cAsunto']', 1,       '$_POST[iCodTrabajadorRegistro]',	3) ";
   			$rsAddCargo=sqlsrv_query($cnx,$sqlAddCargo);
  	}
  	
		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    				$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   fFecMovimiento, nEstadoMovimiento, nFlgEnvio,		cFlgTipoMovimiento)";
    				$sqlAdMv.=" VALUES ";
    				$sqlAdMv.="('$RsUltTra[iCodTramite]',  '$_POST[iCodTrabajadorRegistro]', 3,           '$RsOfi['iCodOficina']', 1,                  3,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1,			1)";
    				$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  		
  	$sqlMv="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSession3]' ORDER BY iCodTemp ASC";
    $rsMv=sqlsrv_query($cnx,$sqlMv);
    while ($RsMv=sqlsrv_fetch_array($rsMv)){
			$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    	$sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar,   iCodIndicacionDerivar,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento, cFlgOficina)";
    	$sqlAdMv.=" VALUES ";
    	$sqlAdMv.="('$RsUltTra[iCodTramite]', '$_POST[iCodTrabajadorRegistro]',     3,           '$RsOfi['iCodOficina']', '$RsMv['iCodOficina']', '$RsMv[iCodTrabajador]', '$RsMv[iCodIndicacion]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1, 						   4,                   1)";
    	$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
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
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
  	}
		
		if($_POST[cReferencia]!=""){
    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cReferencia]' ";
				$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
				if(sqlsrv_has_rows($rsBusRef)>0){
						$RsBusRef=sqlsrv_fetch_array($rsBusRef);
						if($RsBusRef[nFlgTipoDoc]==1){
								$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    						$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,  iCodIndicacionDerivar,  cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, nFlgEnvio,			iCodTramiteDerivar)";
    						$sqlAdRf.=" VALUES ";
    						$sqlAdRf.="('$RsBusRef[iCodTramite]', '$_POST[iCodTrabajadorRegistro]',     3,           '$RsOfi['iCodOficina']', '$_POST[cCodTipoDoc]',  1,                   3,                      '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', UPPER('$_POST[cCodificacion]'),   '$fFecActual',  1, 						    5,                  1,		'$RsUltTra[iCodTramite]')";
    						$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
    				}
				}
    }
    
    unset($_SESSION[cCodSession3]);
			
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
		echo "<input type=hidden name=nFlgTipoDoc value=3>";
		echo "<input type=hidden name=nFlgClaseDoc value=3>";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 7: // registro anexo
		$nCodBarra=rand(1000000000,9999999999);
		// armar correlativo
   	// $rsCntTra=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramiteRel='$_POST[iCodTramite]'");
		//$UltNumAnexo=sqlsrv_has_rows($rsCntTra)+1;
		
    $cCodificacion = $_POST[cCodificacion]."-".$_POST[cIndice];
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc,nFlgClaseDoc,cCodificacion,iCodTrabajadorRegistro,cCodTipoDoc,cAsunto,cObservaciones,nNumFolio,						 fFecDocumento,fFecRegistro,nFlgEstado,iCodTramiteRel,nCodBarra)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(4,1,'$cCodificacion','$_POST[iCodTrabajadorRegistro]','$_POST[cCodTipoDoc]','$_POST['cAsunto']','$_POST[cObservaciones]','$_POST[nNumFolio]','$fFecDocumento','$fFecRegistro',1,'$_POST[cCodificacion]','$nCodBarra')";
    $rs = sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra = sqlsrv_fetch_array($rsUltTra);
    
	 //leer  oficina
   	$rsOfi = sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]'");
    $RsOfi = sqlsrv_fetch_array($rsOfi);
	
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$nombre = count($extension)-2;
  			$nombre_en_bruto = $extension[$nombre];
  			$nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
				$nuevo_nombre = $cCodificacion."-".$RsUltTra[iCodTramite].".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) 
										VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt  = sqlsrv_query($cnx,$sqlDigt);
   			
   			$rsUltDoc = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
				$RsUltDoc = sqlsrv_fetch_array($rsUltDoc);
  	}
  	
  	if($_POST[nFlgEnvio]==1){
  		
  		$sqlUpdEnvio="UPDATE Tra_M_Tramite SET nFlgEnvio='$_POST[nFlgEnvio]' WHERE iCodTramite='$RsUltTra[iCodTramite]'";
			$rsUpdEnvio=sqlsrv_query($cnx,$sqlUpdEnvio);
  		
  		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    cAsuntoDerivar, 	   cObservacionesDerivar,    iCodDigital, 								iCodTramiteRel, 				fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$RsUltTra[iCodTramite]', '$_POST[iCodTrabajadorRegistro]', 4, 		'$RsOfi['iCodOficina']', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$RsUltDoc[iCodDigital]', '$_POST[iCodTramite]', '$fFecActual', 1,                '$fFecActual',   1,					 3)";
   		$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}
   	//echo $rsMov;
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroAnexoConcluido.php target=_parent>";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
		
	break;
	case 8:  // actualizar tramite con tupa
	//  Sql es ejecutado en SP
 	$fFecActual=$_POST['fFecRegistro'];
	$fFecRegistro=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i:s", strtotime($_POST['fFecRegistro']));
	$fFecDocumento=date("Ymd", strtotime($_POST['fFecDocumento']))." ".date("G:i:s", strtotime($_POST['fFecDocumento']));
   	
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
	$sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
	$sqlUpd.="nFlgTipoDoc='1', ";
	$sqlUpd.="nFlgClaseDoc='1', ";
	$sqlUpd.="iCodOficinaRegistro='$_POST[iCodOficinaRegistro]', ";
	$sqlUpd.="iCodTrabajadorRegistro='$_POST[iCodTrabajadorRegistro]', ";
    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
    $sqlUpd.="cCodificacion='$_POST[cCodificacion]', ";
    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="iCodTupaClase='$_POST[iCodTupaClase]', ";
    $sqlUpd.="iCodTupa='$_POST['iCodTupa']', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="iCodIndicacion='$_POST[iCodIndicacion]', ";
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="nTiempoRespuesta='$_POST[nTiempoRespuesta]', ";
	$sqlUpd.="cNomRemite='$_POST[cNomRemite]', ";
	$sqlUpd.="fFecRegistro='$fFecRegistro', ";
	$sqlUpd.="fFecDocumento='$fFecDocumento', ";	
	$sqlUpd.="nFlgEnvio='$_POST[nFlgEnvio]', ";
	$sqlUpd.="nFlgAnulado='$_POST[nFlgAnulado]' ";		
	$sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
	$rsUpd=sqlsrv_query($cnx,$sqlUpd);
	
	$sqlUpd2="UPDATE Tra_M_Tramite_Movimientos SET ";
	$sqlUpd2.="iCodOficinaDerivar='$_POST[iCodOficinaResponsable]', ";
	$sqlUpd2.="iCodTrabajadorDerivar='$_POST[iCodTrabajadorResponsable]' ";
    $sqlUpd2.="WHERE iCodMovimiento='$_POST[iCodMovimientox]'";
	$rsUpd2=sqlsrv_query($cnx,$sqlUpd2);
	//	echo $sqlUpd;
		
		$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Requisitos WHERE iCodTramite='$_POST[iCodTramite]'");
		
		For ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      	$iCodTupaRequisito= $_POST[iCodTupaRequisito];
				$sqlIns="INSERT INTO Tra_M_Tramite_Requisitos (iCodTupaRequisito, iCodTramite) VALUES ('$iCodTupaRequisito[$h]', '$_POST[iCodTramite]') ";
   			$rsIns=sqlsrv_query($cnx,$sqlIns);
		}
		
	 //leer oficina
    $rsOfi=sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]'");
    $RsOfi=sqlsrv_fetch_array($rsOfi);
		
	if($_POST[nFlgEnvio]==1){
				$rsUpd2=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'");
				$rsUpd3=sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET nFlgEnvio=1 WHERE iCodTramite='$_POST[iCodTramite]'");
   	}
		
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$nombre = count($extension)-2;
  			$nombre_en_bruto = $extension[$nombre];
  			$nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
				$nuevo_nombre = $_POST[cCodificacion]."-".$_POST[iCodTramite].".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
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
    echo "</form>";
	break;
	case 9: // actualizar tramite sin tupa
	$fFecRegistro=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i:s", strtotime($_POST['fFecRegistro']));
	$fFecDocumento=date("Ymd", strtotime($_POST['fFecDocumento']))." ".date("G:i:s", strtotime($_POST['fFecDocumento']));
	
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
	$sqlUpd.="nFlgTipoDoc='1', ";
	$sqlUpd.="nFlgClaseDoc='2', ";
	$sqlUpd.="iCodOficinaRegistro='$_POST[iCodOficinaRegistro]', ";
    $sqlUpd.="iCodTrabajadorRegistro='$_POST[iCodTrabajadorRegistro]', ";
    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
    $sqlUpd.="cCodificacion='$_POST[cCodificacion]', ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="iCodIndicacion='$_POST[iCodIndicacion]', ";
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="nTiempoRespuesta='$_POST[nTiempoRespuesta]', ";
    $sqlUpd.="cNomRemite='$_POST[cNomRemite]', ";
	$sqlUpd.="fFecRegistro='$fFecRegistro', ";
	$sqlUpd.="fFecDocumento='$fFecDocumento', ";
	$sqlUpd.="nFlgEnvio='$_POST[nFlgEnvio]', ";
	$sqlUpd.="nFlgAnulado='$_POST[nFlgAnulado]' ";		
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
	
	$sqlUpd2="UPDATE Tra_M_Tramite_Movimientos SET ";
	$sqlUpd2.="iCodOficinaDerivar='$_POST[iCodOficinaResponsable]', ";
	$sqlUpd2.="iCodTrabajadorDerivar='$_POST[iCodTrabajadorResponsable]' ";
    $sqlUpd2.="WHERE iCodMovimiento='$_POST[iCodMovimientox]'";
	$rsUpd2=sqlsrv_query($cnx,$sqlUpd2);
		
	 //leer oficina
    $rsOfi=sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]'");
    $RsOfi=sqlsrv_fetch_array($rsOfi);
		if($_POST[nFlgEnvio]==1){
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
		
		if($_FILES['fileUpLoadDigital']['name']!=""){
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$nombre = count($extension)-2;
  			$nombre_en_bruto = $extension[$nombre];
  			$nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
				$nuevo_nombre = $_POST[cCodificacion]."-".$_POST[iCodTramite].".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
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
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "</form>";
	break;
	case 10: // nuevo remitente
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
	$cCodificacion=$_POST[cCodificacion]."-".$_POST[cIndice];
	
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
	$sqlUpd.="nFlgTipoDoc='4', ";
	$sqlUpd.="nFlgClaseDoc='1', ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
	$sqlUpd.="cCodificacion='$cCodificacion', ";
    $sqlUpd.="iCodTrabajadorRegistro='$_POST[iCodTrabajadorRegistro]', ";
    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
    $sqlUpd.="iCodRemitente='$_POST[iCodRemitente]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
	$sqlUpd.="fFecDocumento='$fFecDocumento', ";
	$sqlUpd.="fFecRegistro='$fFecRegistro', ";
	$sqlUpd.="nFlgEstado='1', ";
	$sqlUpd.="iCodTramiteRel='$_POST[cCodificacion]', ";
	$sqlUpd.="nFlgEnvio='$_POST[nFlgEnvio]', ";	
	$sqlUpd.="nFlgAnulado='$_POST[nFlgAnulado]' ";	
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
	$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
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
	
	 //leer oficina
    $rsOfi=sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]'");
    $RsOfi=sqlsrv_fetch_array($rsOfi);
		
  	if($_POST[nFlgEnvio]==1){
  		$sqlUpdEnvio="UPDATE Tra_M_Tramite SET nFlgEnvio='$_POST[nFlgEnvio]' WHERE iCodTramite='$_POST[iCodTramite]'";
			$rsUpdEnvio=sqlsrv_query($cnx,$sqlUpdEnvio);
  		
  		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    cAsuntoDerivar, 	   cObservacionesDerivar,    iCodDigital, 						iCodTramiteRel, 				fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$_POST[iCodTramite]', '$_POST[iCodTrabajadorRegistro]', 4, 			'$RsOfi['iCodOficina']', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$RsUltDig[iCodDigital]', '$_POST[iCodTramite]', '$fFecRegistro', 1,                '$fFecRegistro',   1,					 3)";
   		$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}
   	
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
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$_POST[nCodBarra]."\">";
		echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
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

		if($_POST[mismaObs]==1){
			$cObservaciones=$RsTram[cObservaciones];
		}Else{
			$cObservaciones=$_POST[cObservaciones];
		}
		
		for($i=1; $i<=$_POST[CantCopias]; $i++){
			$recolector=$i-1;
			$iCodOficinaResponsableSelect=$iCodOficinaResponsable[$recolector];
			$iCodTrabajadorResponsableSelect=$iCodTrabajadorResponsable[$recolector];
			$iCodIndicacionSelect=$iCodIndicacion[$recolector];
			$nFlgEnvioSelect=$nFlgEnvio[$recolector];
  		
  		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,              iCodTrabajadorDerivar,              cAsuntoDerivar, 	   cObservacionesDerivar,   cCodTipoDocDerivar,     iCodIndicacionDerivar,   fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,          cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 1, 						'".$_SESSION['iCodOficinaLogin']."', '$iCodOficinaResponsableSelect', '$iCodTrabajadorResponsableSelect', '$RsTram['cAsunto']', '$cObservaciones',       '$RsTram[cCodTipoDoc]', '$iCodIndicacionSelect', '$fFecActual', 1,                '$fFecActual',   '$nFlgEnvioSelect',	4)";
   		//echo $sqlMov."<br><br>";
   		$rsMov=sqlsrv_query($cnx,$sqlMov);
  	}
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroCopiaConcluido.php target=_parent>";
		echo "<input type=hidden name=cCodificacion value=\"".$RsTram[cCodificacion]."\">";
		echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;	
	case 13: // actualizar interno oficina
	
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
    $fFecRegistro=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i:s", strtotime($_POST['fFecRegistro']));
	$fFecDocumento=date("Ymd", strtotime($_POST['fFecDocumento']))." ".date("G:i:s", strtotime($_POST['fFecDocumento']));
	
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
	$sqlUpd.="nFlgTipoDoc='2', ";
	$sqlUpd.="nFlgClaseDoc='1' , ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
	$sqlUpd.="cCodificacion='$_POST[cCodificacion]', ";
	$sqlUpd.="iCodOficinaRegistro='$_POST[iCodOficinaRegistro]', ";
	$sqlUpd.="iCodTrabajadorRegistro='$_POST[iCodTrabajadorRegistro]', ";
    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
	$sqlUpd.="fFecRegistro='$fFecRegistro', ";
	$sqlUpd.="fFecDocumento='$fFecDocumento', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo, ";
	$sqlUpd.="cSiglaAutor='$_POST[cSiglaAutor]', ";
	$sqlUpd.="nFlgEnvio='$_POST[nFlgEnvio]', ";
	$sqlUpd.="nFlgAnulado='$_POST[nFlgAnulado]' ";	
	$sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
	//echo $sqlUpd;	
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
		
		if($_POST[nFlgEnvio]=1){
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
   			}Else{
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion]).".".$extension[$num];
						move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
						$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   					$rsDigt=sqlsrv_query($cnx,$sqlDigt);
   			}
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
  case 14: //a�adir movimiento de oficina edit
 	 	$fFecRegistro=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i:s", strtotime($_POST['fFecRegistro']));
		$fFecDocumento=date("Ymd", strtotime($_POST['fFecDocumento']))." ".date("G:i:s", strtotime($_POST['fFecDocumento']));
   //leer oficina
    $rsOfi=sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]'");
    $RsOfi=sqlsrv_fetch_array($rsOfi);
  
    		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    		$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,       iCodTrabajadorDerivar,       iCodIndicacionDerivar,       cPrioridadDerivar,       cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, cFlgOficina)";
    		$sqlAdMv.=" VALUES ";
    		$sqlAdMv.="('$_POST[iCodTramite]', '$_POST[iCodTrabajadorRegistro]',     2,        '$_POST[iCodOficinaRegistro]', '$_POST[iCodOficinaMov]', '$_POST[iCodTrabajadorMov]', '$_POST[iCodIndicacionMov]', '$_POST[cPrioridadMov]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecRegistro', '$fFecRegistro',  1,                 1, 						1)";
    		$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    		
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroTramiteEdit_Interno.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
			echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_POST[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
			echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
			echo "<input type=hidden name=nFlgTipoDoc value=\"".$_POST[nFlgTipoDoc]."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_POST[cObservaciones]."\">";
   			echo "<input type=hidden name=iCodIndicacion value=\"".$_POST[iCodIndicacion]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_POST[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_POST[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_POST[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_POST[nFlgEnvio]."\">";
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
			$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,						nFlgTipoDoc, iCodTrabajadorRegistro,				 iCodOficinaOrigen,           fFecMovimiento,           nEstadoMovimiento, iCodTrabajadorEnviar,      cObservacionesEnviar, 		 fFecEnviar,              cFlgTipoMovimiento, nFlgEnvio)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$_POST[iCodTramite]', '2', 				 '".$_SESSION['CODIGO_TRABAJADOR']."', $_SESSION['iCodOficinaLogin'], '$_POST[fFecMovimiento]', 1,								 '$lstTrabajadoresSel[$i]', '$_POST[cObservaciones]', '$_POST[fFecMovimiento]', 2,                  '$_POST[nFlgEnvio]')";
   		$rsMov=sqlsrv_query($cnx,$sqlMov);
		}
		
		
		if($_FILES['fileUpLoadDigital']['name']!=""){
				$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
			  $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			  $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			
  			$cNombreOriginal=$_FILES['fileUpLoadDigital']['name'];
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
  			$nombre = count($extension)-2;
  			$nombre_en_bruto = $extension[$nombre];
  			$nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
				$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion]).".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
  	}
		
		echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=POST name=form_envio action=registroInternoActualizado.php#area>";
		echo "<input type=hidden name=iCodTramite value=\"".$_POST[iCodTramite]."\">";
   	echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "</form>";
	break;
	case 16: // actualizar salida
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
	 if($_POST[iCodRemitente]==""){
    		$iCodRemitente="NULL";
    }Else{
    		$iCodRemitente=$_POST[iCodRemitente];
    }
	
    $fFecRegistro=date("Ymd", strtotime($_POST['fFecRegistro']))." ".date("G:i:s", strtotime($_POST['fFecRegistro']));
	$fFecDocumento=date("Ymd", strtotime($_POST['fFecDocumento']))." ".date("G:i:s", strtotime($_POST['fFecDocumento']));
	
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="nFlgTipoDoc='3', ";
	$sqlUpd.="nFlgClaseDoc='1', ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
	$sqlUpd.="cCodificacion='$_POST[cCodificacion]', ";
	$sqlUpd.="iCodOficinaRegistro='$_POST[iCodOficinaRegistro]', ";
    $sqlUpd.="iCodTrabajadorRegistro='$_POST[iCodTrabajadorRegistro]', ";
    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo, ";
    $sqlUpd.="cSiglaAutor='$_POST[cSiglaAutor]' , ";
	$sqlUpd.="iCodRemitente='$iCodRemitente', ";
	$sqlUpd.="cNomRemite= '$_POST[cNomRemite]', ";
	$sqlUpd.="fFecRegistro='$fFecRegistro', ";
	$sqlUpd.="fFecDocumento='$fFecDocumento' ,";
	$sqlUpd.="nFlgAnulado='$_POST[nFlgAnulado]' ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		//echo $sqlUpd;
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
  	 //leer oficina
    $rsOfi=sqlsrv_query($cnx,"SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_POST[iCodTrabajadorRegistro]'");
    $RsOfi=sqlsrv_fetch_array($rsOfi);
	
  	 	$sqlMv="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]'";
    $rsMv=sqlsrv_query($cnx,$sqlMv);
	  $RsMv=sqlsrv_fetch_array($rsMv);
	  if(sqlsrv_has_rows($rsMv)==0){
  					$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    				$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   fFecMovimiento, nEstadoMovimiento, nFlgEnvio)";
    				$sqlAdMv.=" VALUES ";
    				$sqlAdMv.="('$_POST[iCodTramite]', '$_POST[iCodTrabajadorRegistro]', 3,            '$_POST[iCodOficinaRegistro]', 						1,                  3,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecRegistro', '$fFecRegistro',  1,                 1)";
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
	$sqlAddRemx=" SP_DOC_SALIDA_MULTIPLE_INSERT '$_POST[iCodTramite]' ,'$RsBusCod[cCodificacion]','$iCodRemitente', '$_POST[iCodOficinaRegistro]', '$_POST['cAsunto']', '$_POST[iCodTrabajadorRegistro]' ";
    $rsAddRemx=sqlsrv_query($cnx,$sqlAddRemx);
	}
	if($numRemx = 1){
	$sqlAddRem=" UPDATE Tra_M_Doc_Salidas_Multiples "; 
	$sqlAddRem.=" SET iCodRemitente='$iCodRemitente'";
	$sqlAddRem.=" WHERE iCodTramite = '$_POST[iCodTramite]' ";
	$rsAddRem=sqlsrv_query($cnx,$sqlAddRem);
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
   	echo "<input type=hidden name=nFlgTipoDoc value=3>";
   	echo "</form>";
	break;
	case 17: // registro salida especial
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
   
    // comprobar o recoger correlativo
   // $sqlCorr="SELECT * FROM Tra_M_Correlativo_Salida WHERE cCodTipoDoc='$_POST[cCodTipoDoc]' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='$nNumAno'";
  //  $rsCorr=sqlsrv_query($cnx,$sqlCorr);
  //  if(sqlsrv_has_rows($rsCorr)>0){
  //  	$RsCorr=sqlsrv_fetch_array($rsCorr);
   // 	$nCorrelativo=$RsCorr[nCorrelativo]+1;
    	
    //	$sqlUpd="UPDATE Tra_M_Correlativo_Salida SET nCorrelativo='$nCorrelativo' WHERE iCodCorrelativo='$RsCorr[iCodCorrelativo]'";
	//		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
   // }Else{
   // 	$sqlAdCorr="INSERT INTO Tra_M_Correlativo_Salida (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('$_POST[cCodTipoDoc]', '".$_SESSION['iCodOficinaLogin']."', '$nNumAno',1)";
    //	$rsAdCorr=sqlsrv_query($cnx,$sqlAdCorr);
   // 	$nCorrelativo=1;
  //  }
    
    //leer sigla oficina
    $rsSigla=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    $RsSigla=sqlsrv_fetch_array($rsSigla);
    
    //leer sigla oficina solicitante
    $rsSiglaSol=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$_POST[iCodOficinaSolicitado]'");
    $RsSiglaSol=sqlsrv_fetch_array($rsSiglaSol);
    
    // armar correlativo
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-SITDD/".trim($RsSigla[cSiglaOficina])."-".trim($RsSiglaSol[cSiglaOficina]);
    
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        cCodTipoDoc,           fFecDocumento,	iCodOficinaSolicitado, 				  cReferencia, 				   cAsunto,           cObservaciones, 				   iCodIndicacion, 					 nFlgRpta,					 nNumFolio,						fFecPlazo,  cSiglaAutor,   				 fFecRegistro,	 iCodRemitente,					nFlgEstado)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(3,           2,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST[iCodOficinaSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[iCodIndicacion]', '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]', '$fFecActual', '$_POST[iCodRemitente]',1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
    if($_FILES['fileUpLoadDigital']['name']!=""){
				$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
			  $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			  $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			      	
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
				$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
  	}
    
		if($_POST[iCodOficinaResponsable]!=""){
				$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    		$sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   						  iCodIndicacionDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento)";
    		$sqlAdMv.=" VALUES ";
    		$sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodIndicacion]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual', 1)";
    		$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  	}

		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=nFlgTipoDoc value=3>";
		echo "<input type=hidden name=nFlgClaseDoc value=3>";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 18: // actualizar salida
    if($_POST[fFecPlazo]!=""){
    	$separado2=explode("-",$_POST[fFecPlazo]);
    	$fFecPlazo="'".$separado2[2].$separado2[1].$separado2[0]."'";
    }Else{
    	$fFecPlazo="NULL";
    }
    
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="iCodIndicacion='$_POST[iCodIndicacion]', ";
    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo, ";
    $sqlUpd.="cSiglaAutor='$_POST[cSiglaAutor]' ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
		if($_FILES['fileUpLoadDigital']['name']!=""){
				$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$_POST[cCodTipoDoc]'";
			  $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			  $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			
  			$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  			$num = count($extension)-1;
				$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$_POST[cCodificacion])."-SALIDA.".$extension[$num];
				move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
				
				$sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$_POST[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
   			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
  	}
  	
  	if($_POST[iCodOficinaResponsable]!=""){
  			if($_POST[derivado]==""){
  					$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    				$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   						  iCodIndicacionDerivar,   cAsuntoDerivar,    cObservacionesDerivar,   fFecDerivar,  fFecMovimiento, nEstadoMovimiento)";
    				$sqlAdMv.=" VALUES ";
    				$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 3,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodIndicacion]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual', 1)";
    				$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  			}
  			if($_POST[derivado]==1){
  					$sqlUpdM="UPDATE Tra_M_Tramite_Movimientos SET ";
    				$sqlUpdM.="iCodOficinaDerivar='$_POST[iCodOficinaResponsable]', ";
    				$sqlUpdM.="iCodIndicacionDerivar='$_POST[iCodIndicacion]', ";
    				$sqlUpdM.="cAsuntoDerivar='$_POST['cAsunto']', ";
    				$sqlUpdM.="cObservacionesDerivar='$_POST[cObservaciones]', ";
    				$sqlUpdM.="fFecDerivar='$fFecActual' ";
    				$sqlUpdM.="WHERE iCodMovimiento='$_POST[iCodMovimiento]'";
    				$rsUpdM=sqlsrv_query($cnx,$sqlUpdM);
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
   	echo "<input type=hidden name=nFlgTipoDoc value=3>";
   	echo "</form>";
	break;	
	
case 20: //a�adir movimiento temporal
		for ($i=0;$i<count($_POST[lstOficinasSel]);$i++){
			$lstOficinasSel=$_POST[lstOficinasSel];
   		
   		$sqlTrb="SELECT TOP 1 * FROM Tra_M_Trabajadores WHERE iCodOficina='$lstOficinasSel[$i]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
      $rsTrb=sqlsrv_query($cnx,$sqlTrb);
      $RsTrb=sqlsrv_fetch_array($rsTrb);
			
    	$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    	$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento,cFlgOficina)";
    	$sqlAdMv.=" VALUES ";
    	$sqlAdMv.="('$_POST[iCodTramite]', '$_POST[iCodTrabajadorRegistro]',     2,            '$_POST[iCodOficinaRegistro]', '$lstOficinasSel[$i]', '$RsTrb[iCodTrabajador]', '$_POST[iCodIndicacion]', '$_POST[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1,                 1)";
    	$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    		
    	//echo $sqlAdd;
    	
    	sqlsrv_free_stmt($rsTrb);
		}  
    	$sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$_POST[iCodTramite];
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
		echo "<input type=hidden name=nFlgTipoDoc  value=\"".$_GET['nFlgTipoDoc']."\">";
        echo "<input type=hidden name=iCodTrabajadorRegistro value=\"".$_GET[iCodTrabajadorRegistro]."\">";
        echo "<input type=hidden name=iCodOficinaRegistro value=\"".$_GET[iCodOficinaRegistro]."\">";
        echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_GET[iCodTrabajadorSolicitado]."\">";
        echo "<input type=hidden name=fFecDocumento value=\"".$_GET['fFecDocumento']."\">";
        echo "<input type=hidden name=fFecRegistro value=\"".$_GET['fFecRegistro']."\">"; 
		echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
		echo "<input type=hidden name=cCodificacion value=\"".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."\">";
        echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
		echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">"; 
        echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
		echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">"; 
		echo "<input type=hidden name=iCodTramiteRef value=\"".$_GET[iCodTramiteRef]."\">";
        echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">"; 
        echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
		echo "<input type=hidden name=nFlgRpta value=\"".$_GET[nFlgRpta]."\">"; 		
		echo "<input type=hidden name=fFecPlazo value=\"".$_GET[fFecPlazo]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	 case 21: //a�adir referencia temporal
		$sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
    $sqlAdd.="(iCodTramiteRef,	cReferencia,          cCodSession)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="('$_POST[iCodTramiteRef]','$_POST[cReferencia]', '$_SESSION[cCodSession]')";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficinaAd.php#area>";
			echo "<input type=hidden name=iCodTrabajadorRegistro value=\"".$_POST[iCodTrabajadorRegistro]."\">";
			echo "<input type=hidden name=fFecDocumento value=\"".$_POST['fFecDocumento']."\">";
			echo "<input type=hidden name=fFecRegistro value=\"".$_POST['fFecRegistro']."\">";
			echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
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
	 case 22: //copia
			
		$fFecDerivar=date("Ymd", strtotime($_POST['fFecDerivar']))." ".date("G:i:s", strtotime($_POST['fFecDerivar']));
								
		$sqlU = " UPDATE Tra_M_Tramite_Movimientos SET iCodOficinaOrigen='$_POST[iCodOficinaOrigen]', iCodOficinaDerivar='$_POST[iCodOficinaDerivar]', iCodTrabajadorDerivar='$_POST[iCodTrabajadorDerivar]', iCodIndicacionDerivar='$_POST[iCodIndicacion]' ,cAsuntoDerivar='$_POST[cAsuntoDerivar]', cObservacionesDerivar='$_POST[cObservacionesDerivar]', nEstadoMovimiento= '$_POST['nEstadoMovimiento']' , cCodTipoDocDerivar= '$_POST[cCodTipoDoc]',cNumDocumentoDerivar = '$_POST[cCodificacion]',   fFecDerivar='$fFecDerivar' ";
		if(trim($_POST[fFecRecepcion])!=""){
		$fFecRecepcion=date("Ymd", strtotime($_POST[fFecRecepcion]))." ".date("G:i:s", strtotime($_POST[fFecRecepcion]));
				$sqlU .=" ,fFecRecepcion='$fFecRecepcion', "; 
		}
		else {  $sqlU .=" ,fFecRecepcion=NULL, "; }
		if(trim($_POST[fFecDelegado])!=""){
		$fFecDelegado=date("Ymd", strtotime($_POST[fFecDelegado]))." ".date("G:i:s", strtotime($_POST[fFecDelegado]));
				$sqlU .=" fFecDelegado='$fFecDelegado', "; 
		}
		else { 	$sqlU .=" fFecDelegado=NULL, "; }		
		if($_POST[cFlgTipoMovimiento]=="1"){
				$sqlU .="cFlgTipoMovimiento='4', ";
		}	else {	$sqlU .="cFlgTipoMovimiento='1', "; }	
		$sqlU .="iCodTrabajadorRegistro='$_POST[iCodTrabajadorRegistro]', ";
		$sqlU .="iCodTrabajadorDelegado='$_POST[iCodTrabajadorResponsable]' ";
		$sqlU .= " WHERE iCodMovimiento='$_POST[iCodMovimiento]' ";	
		$rsU = sqlsrv_query($cnx,$sqlU);
			//echo $sqlU;
		
		$sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$_POST[iCodTramite];
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
		
	break;
	 case 23: //a�adir referencia temporal
	
		$fFecDerivar=date("Ymd", strtotime($_POST['fFecDerivar']))." ".date("G:i:s", strtotime($_POST['fFecDerivar']));
		
		
				$sqlU = " UPDATE Tra_M_Tramite_Movimientos SET iCodOficinaOrigen='$_POST[iCodOficinaOrigen]', iCodOficinaDerivar='$_POST[iCodOficinaDerivar]', iCodTrabajadorDerivar='$_POST[iCodTrabajadorDerivar]', iCodIndicacionDerivar='$_POST[iCodIndicacion]' ,cAsuntoDerivar='$_POST[cAsuntoDerivar]', cObservacionesDerivar='$_POST[cObservacionesDerivar]', nEstadoMovimiento= '$_POST['nEstadoMovimiento']' , cCodTipoDocDerivar= '$_POST[cCodTipoDoc]',cNumDocumentoDerivar = '$_POST[cCodificacion]',   fFecDerivar='$fFecDerivar' ";
		if(trim($_POST[fFecRecepcion])!=""){
		$fFecRecepcion=date("Ymd", strtotime($_POST[fFecRecepcion]))." ".date("G:i:s", strtotime($_POST[fFecRecepcion]));
				$sqlU .=" ,fFecRecepcion='$fFecRecepcion', "; 
		}
		else {
				$sqlU .=" ,fFecRecepcion=NULL, "; 
		}
		if(trim($_POST[fFecDelegado])!=""){
		$fFecDelegado=date("Ymd", strtotime($_POST[fFecDelegado]))." ".date("G:i:s", strtotime($_POST[fFecDelegado]));
				$sqlU .=" fFecDelegado='$fFecDelegado', "; 
		}
		else {
				$sqlU .=" fFecDelegado=NULL, "; 
		}		
		if($_POST[cFlgTipoMovimiento]=="1"){
				$sqlU .="cFlgTipoMovimiento='4', ";
		}	else {
				$sqlU .="cFlgTipoMovimiento='1', ";
		}	
				$sqlU .="iCodTrabajadorRegistro='$_POST[iCodTrabajadorRegistro]', ";
				$sqlU .="iCodTrabajadorDelegado='$_POST[iCodTrabajadorResponsable]' ";
				$sqlU .= " WHERE iCodMovimiento='$_POST[iCodMovimiento]' ";
				$rsU = sqlsrv_query($cnx,$sqlU);



		$sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$_POST[iCodTramite];
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 24:
	  $sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$_POST[iCodTramite];
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
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
   			echo "<form method=POST name=form_envio action=registroOficinaAd.php#area>";
			echo "<input type=hidden name=cCodificacion value=\"".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."\">";
   			echo "<input type=hidden name=fFecDocumento value=\"".$_GET['fFecDocumento']."\">";
			echo "<input type=hidden name=fFecRegistro value=\"".$_GET['fFecRegistro']."\">";
			echo "<input type=hidden name=iCodTrabajadorRegistro value=\"".$_GET[iCodTrabajadorRegistro]."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_GET[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">";
			echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
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
	
	if($_GET[opcion]==7){ //retirar movimientos oficinas (edit)
		$sqlX="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$_GET[iCodMovimiento]'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		
		$sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$_GET[iCodTramite];
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
		echo "<input type=hidden name=nFlgTipoDoc  value=\"".$_GET['nFlgTipoDoc']."\">";
        echo "<input type=hidden name=iCodTrabajadorRegistro value=\"".$_GET[iCodTrabajadorRegistro]."\">";
        echo "<input type=hidden name=iCodOficinaRegistro value=\"".$_GET[iCodOficinaRegistro]."\">";
        echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_GET[iCodTrabajadorSolicitado]."\">";
        echo "<input type=hidden name=fFecDocumento value=\"".$_GET['fFecDocumento']."\">";
        echo "<input type=hidden name=fFecRegistro value=\"".$_GET['fFecRegistro']."\">"; 
		echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
		echo "<input type=hidden name=cCodificacion value=\"".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."\">";
        echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
		echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">"; 
        echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
		echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">"; 
		echo "<input type=hidden name=iCodTramiteRef value=\"".$_GET[iCodTramiteRef]."\">";
        echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">"; 
        echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
		echo "<input type=hidden name=nFlgRpta value=\"".$_GET[nFlgRpta]."\">"; 		
		echo "<input type=hidden name=fFecPlazo value=\"".$_GET[fFecPlazo]."\">";
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
  	echo "<form method=POST name=form_envio action=registroOficinaAd.php#area>";
  	echo "<input type=hidden name=fFecDocumento value=\"".$_GET['fFecDocumento']."\">";
	echo "<input type=hidden name=fFecRegistro value=\"".$_GET['fFecRegistro']."\">";
	echo "<input type=hidden name=cCodificacion value=\"".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."\">";
   	echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
	echo "<input type=hidden name=iCodTrabajadorRegistro value=\"".$_GET[iCodTrabajadorRegistro]."\">";
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
  if($_GET[opcion]==20){ //retirar referencia
		$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='$_GET[iCodReferencia]'");
    echo "<html>";
   	echo "<head>";
   	echo "</head>";
   	echo "<body OnLoad=\"document.form_envio.submit();\">";
   	echo "<form method=POST name=form_envio action=registroOficinaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI].">";
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
			echo "<input type=hidden name=fFecDocumento value=\"".$_GET['fFecDocumento']."\">";
			echo "<input type=hidden name=fFecRegistro value=\"".$_GET['fFecRegistro']."\">";
			echo "<input type=hidden name=cCodificacion value=\"".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."\">";
   			echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
			echo "<input type=hidden name=iCodTrabajadorRegistro value=\"".$_GET[iCodTrabajadorRegistro]."\">";
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
   			echo "<form method=POST name=form_envio action=registroSalidaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."clear=1#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
   			echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
   			echo "<input type=hidden name=iCodIndicacion value=\"".$_GET[iCodIndicacion]."\">";
   			echo "<input type=hidden name=nFlgRpta value=\"".$_GET[nFlgRpta]."\">";
   			echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
   			echo "<input type=hidden name=fFecPlazo value=\"".$_GET[fFecPlazo]."\">";
   			echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
   			echo "<input type=hidden name=cNombreRemitente value=\"".$_GET[cNombreRemitente]."\">";
				echo "<input type=hidden name=cNomRemite value=\"".$_GET[cNomRemite]."\">";
				echo "<input type=hidden name=iCodRemitente value=\"".$_GET[iCodRemitente]."\">";				
				echo "<input type=hidden name=radioSeleccion value=\"".$_GET[radioSeleccion]."\">";
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
	if($_GET[opcion]==24){ //retirar copias
		
		$sqlY="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento=".$id;
		$rsY=sqlsrv_query($cnx,$sqlY);
			
		      $sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$idt;
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	}		
	if($_GET[opcion]==25){ //retirar copias
		
		$sqlY="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento=".$id;
		$rsY=sqlsrv_query($cnx,$sqlY);
			
		   $sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$idt;
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	}	
	if($_GET[opcion]==26){ //retirar copias
		
		$sqlY="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite=".$id;
		$rsY=sqlsrv_query($cnx,$sqlY);
		$sqlX="DELETE FROM Tra_M_Tramite_Digitales WHERE iCodTramite=".$id;
		$rsX=sqlsrv_query($cnx,$sqlX);
		$sqlZ="DELETE FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite=".$id;
		$rsZ=sqlsrv_query($cnx,$sqlZ);
		$sqlW="DELETE FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite=".$id;
		$rsW=sqlsrv_query($cnx,$sqlW);
		$sqlT="DELETE FROM Tra_M_Tramite_Requisitos WHERE iCodTramite=".$id;
		$rsT=sqlsrv_query($cnx,$sqlT);
		$sqlM="DELETE FROM Tra_M_Tramite_Avance WHERE iCodTramite=".$id;
		$rsM=sqlsrv_query($cnx,$sqlM);
		$sqlN="DELETE FROM Tra_M_Tramite WHERE iCodTramite=".$id;
		$rsN=sqlsrv_query($cnx,$sqlN);
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroTramiteEsp.php>";
		echo "</form>";
		echo "</body>";
		echo "</html>";
	}			
}Else{
	header("Location: ../index-b.php?alter=5");
}


?>