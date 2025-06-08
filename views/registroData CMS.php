<?
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
		
    $rsCorr=sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo FROM Tra_M_Correlativo WHERE nFlgTipoDoc=1 AND nNumAno='$nNumAno'");
		$RsCorr=sqlsrv_fetch_array($rsCorr);
		$CorrelativoAsignar=$RsCorr[nCorrelativo]+1;
		
		$rsUpdCorr=sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo SET nCorrelativo='$CorrelativoAsignar' WHERE nFlgTipoDoc=1 AND nNumAno='$nNumAno'");
		
		$cCodificacion=date("Y").add_ceros($CorrelativoAsignar,5);
  	
    if($_POST[nFlgClaseDoc]==1){ //sql con tupa
    	$sqlAdd="INSERT INTO Tra_M_Tramite ";
    	$sqlAdd.="(nFlgTipoDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento, cNroDocumento,           iCodRemitente,           cNomRemite,            cAsunto,          cObservaciones,           iCodTupaClase,            iCodTupa,          cReferencia,            iCodIndicacion,          nNumFolio,           nTiempoRespuesta,           nFlgEnvio,           nFlgClaseDoc,   fFecRegistro,  nCodBarra,    cPassword,   nFlgEstado)";
    	$sqlAdd.=" VALUES ";
    	$sqlAdd.="(1,           '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '".$_POST['cNroDocumento']."', '$_POST[iCodRemitente]', '$_POST[cNomRemite]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[iCodTupaClase]', '$_POST['iCodTupa']', '$_POST[cReferencia]', '$_POST[iCodIndicacion]', '$_POST[nNumFolio]', '$_POST[nTiempoRespuesta]', '$_POST[nFlgEnvio]', 1,              '$fFecActual', '$nCodBarra', '$cPassword', 1)";
    }
    if($_POST[nFlgClaseDoc]==2){ //sql sin tupa
    	$sqlAdd="INSERT INTO Tra_M_Tramite ";
    	$sqlAdd.="(nFlgTipoDoc, cCodificacion,    iCodTrabajadorRegistro,         iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento, cNroDocumento,           iCodRemitente,           cNomRemite,           cAsunto,           cObservaciones,           cReferencia,           iCodIndicacion,           nNumFolio,           nTiempoRespuesta,           nFlgEnvio,           nFlgClaseDoc,   fFecRegistro,   nCodBarra,    cPassword,    nFlgEstado)";
    	$sqlAdd.=" VALUES ";
    	$sqlAdd.="(1,           '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '".$_POST['cNroDocumento']."', '$_POST[iCodRemitente]', '$_POST[cNomRemite]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[cReferencia]', '$_POST[iCodIndicacion]', '$_POST[nNumFolio]', '$_POST[nTiempoRespuesta]', '$_POST[nFlgEnvio]', 2,              '$fFecActual',  '$nCodBarra', '$cPassword', 1)";
    }
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //echo $sqlAdd;
    
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
				$sqlMov.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 1,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST[iCodIndicacion]', '$fFecActual', 1,                '$fFecActual',   '$_POST[nFlgEnvio]',1)";
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
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroConcluido.php>";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
		echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
		echo "<input type=hidden name=nFlgClaseDoc value=\"".$_POST[nFlgClaseDoc]."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}
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
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion, 		iCodTrabajadorRegistro,         iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	iCodTrabajadorSolicitado, 					 cReferencia, 				 cAsunto,           cObservaciones, 				  nFlgRpta,					  nNumFolio,						fFecPlazo,    nFlgEnvio,           fFecRegistro,  nFlgEstado)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(2,           1,           '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."','$_POST[cCodTipoDoc]', '$fFecActual', '$_POST[iCodTrabajadorSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[nFlgEnvio]', '$fFecActual', 1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);

		//Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
		
		$sqlMv="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSession]'";
    $rsMv=sqlsrv_query($cnx,$sqlMv);
    while ($RsMv=sqlsrv_fetch_array($rsMv)){
				$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    		$sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar,   iCodIndicacionDerivar,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento)";
    		$sqlAdMv.=" VALUES ";
    		$sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$RsMv['iCodOficina']', '$RsMv[iCodTrabajador]', '$RsMv[iCodIndicacion]', '$RsMv[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1, 						   1)";
    		$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    		//echo $sqlMv."<br>";
    }
    
    // relacion por ferencia
    if($_POST[cReferencia]!=""){
    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cReferencia]'";
				$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
				if(sqlsrv_has_rows($rsBusRef)>0){
					$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSession]'";
    			$rsMv2=sqlsrv_query($cnx,$sqlMv2);
    			$RsMv2=sqlsrv_fetch_array($rsMv2);
    			
					$RsBusRef=sqlsrv_fetch_array($rsBusRef);
					$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    			$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento)";
    			$sqlAdRf.=" VALUES ";
    			$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual',   1, 						    5)";
    			$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
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
						$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
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
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
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
   			echo "<form method=POST name=form_envio action=registroOficina.php#area>";
   			echo "<input type=hidden name=radioSeleccion value=\"".$_POST[radioSeleccion]."\">";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=fFecDocumento value=\"".$_POST['fFecDocumento']."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_POST[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
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
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-PCM/".trim($RsSigla[cSiglaOficina])."-".strtoupper(trim($RsNomUsr[cUsuario]));
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	cAsunto,           cObservaciones,           fFecPlazo,    fFecRegistro, nFlgEstado)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(2,           2,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST['cAsunto']', '$_POST[cObservaciones]', $fFecPlazo, '$fFecActual',1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
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
	case 5: // registro salida
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
    
    // armar correlativo
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-PCM/".trim($RsSigla[cSiglaOficina]);
    
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	iCodTrabajadorSolicitado, 				  cReferencia, 				   cAsunto,           cObservaciones, 				  iCodIndicacion, nFlgRpta,					 nNumFolio,						fFecPlazo, cSiglaAutor,   				fFecRegistro,	 iCodRemitente,					    nFlgEstado, nFlgEnvio)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(3,           1,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST[iCodTrabajadorSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', 6,              '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]', '$fFecActual', '$_POST[iCodRemitente]', 1,          1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
		if($_POST[iCodRemitente]!=""){
    		$sqlAddCargo="INSERT INTO Tra_M_Doc_Salidas_Multiples ";
    		$sqlAddCargo.="(iCodTramite,              cCodificacion,    iCodRemitente,          iCodOficina,                  cAsunto,          cFlgEnvio, iCodTrabajadorRegistro) ";
    		$sqlAddCargo.="VALUES ";
    		$sqlAddCargo.="('$RsUltTra[iCodTramite]' ,'$cCodificacion','$_POST[iCodRemitente]', $_SESSION['iCodOficinaLogin'], '$_POST['cAsunto']', 1,        '".$_SESSION['CODIGO_TRABAJADOR']."') ";
   			//echo $sqlAddCargo."<br>";
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
    $sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, nFlgEnvio)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,            '".$_SESSION['iCodOficinaLogin']."', 1,                  6,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  	
  	// relacion por ferencia
    if($_POST[cReferencia]!=""){
    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cReferencia]'";
				$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
				if(sqlsrv_has_rows($rsBusRef)>0){
					$RsBusRef=sqlsrv_fetch_array($rsBusRef);
					$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    			$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,  iCodIndicacionDerivar,  cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, nFlgEnvio)";
    			$sqlAdRf.=" VALUES ";
    			$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  1,                   6,                      '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',   '$fFecActual',  1, 						    5,                  1)";
    			$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
				}
    }
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
		echo "<input type=hidden name=nFlgTipoDoc value=3>";
		echo "<input type=hidden name=nFlgClaseDoc value=3>";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}		
		echo "</form>";
		echo "</body>";
		echo "</html>";
	break;
	case 7: // registro anexo
		$nCodBarra=rand(1000000000,9999999999);
		
		// armar correlativo
    $rsCntTra=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramiteRel='$_POST[iCodTramite]'");
		$UltNumAnexo=sqlsrv_has_rows($rsCntTra)+1;
		
    $cCodificacion=$_POST[cCodificacion]."-".$UltNumAnexo;
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion, 		iCodTrabajadorRegistro,         iCodOficinaRegistro,           cCodTipoDoc,           cNroDocumento,           cAsunto,            iCodRemitente,          cNomRemite,           cObservaciones, 				   nNumFolio,						 fFecDocumento, fFecRegistro,  nFlgEstado, iCodTramiteRel,        nCodBarra)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(4,           1,           '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '".$_POST['cNroDocumento']."', '$_POST['cAsunto']', '$_POST[iCodRemitente]', '$_POST[cNomRemite]', '$_POST[cObservaciones]', '$_POST[nNumFolio]', '$fFecActual', '$fFecActual', 1,					 '$_POST[iCodTramite]', '$nCodBarra')";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
    
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
   					$rsUltDoc=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
						$RsUltDoc=sqlsrv_fetch_array($rsUltDoc);
  	}
  	
  	if($_POST[nFlgEnvio]==1){
  		
  		$sqlUpdEnvio="UPDATE Tra_M_Tramite SET nFlgEnvio='$_POST[nFlgEnvio]' WHERE iCodTramite='$RsUltTra[iCodTramite]'";
			$rsUpdEnvio=sqlsrv_query($cnx,$sqlUpdEnvio);
  		
  		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    cAsuntoDerivar, 	   cObservacionesDerivar,    iCodDigital, 								iCodTramiteRel, 				fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 4, 						'".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$RsUltDoc[iCodDigital]', '$_POST[iCodTramite]', '$fFecActual', 1,                '$fFecActual',   1,					 3)";
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
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}
		echo "</form>";
		echo "</body>";
		echo "</html>";
		
	break;
	case 8:  // actualizar tramite con tupa
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
    $sqlUpd.="iCodRemitente='$_POST[iCodRemitente]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="iCodTupaClase='$_POST[iCodTupaClase]', ";
    $sqlUpd.="iCodTupa='$_POST['iCodTupa']', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="iCodIndicacion='$_POST[iCodIndicacion]', ";
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="nTiempoRespuesta='$_POST[nTiempoRespuesta]', ";
		$sqlUpd.="cNomRemite='$_POST[cNomRemite]' ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
		
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
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";
	break;
	case 9: // actualizar tramite sin tupa
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
    $sqlUpd.="iCodRemitente='$_POST[iCodRemitente]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="iCodIndicacion='$_POST[iCodIndicacion]', ";
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="nTiempoRespuesta='$_POST[nTiempoRespuesta]', ";
    $sqlUpd.="cNomRemite='$_POST[cNomRemite]' ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
		// si selecciono oficina y los movimientos estan vacios.
		if($_POST[iCodOficinaResponsable]!="" AND $_POST[numMov]==0){
						$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
						$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc, iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    iCodIndicacionDerivar,    fFecDerivar,   nEstadoMovimiento, fFecMovimiento, cFlgTipoMovimiento)";
						$sqlMov.=" VALUES ";
						$sqlMov.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 1,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST[iCodIndicacion]', '$fFecActual', 1,                '$fFecActual',   1)";
   					$rsMov=sqlsrv_query($cnx,$sqlMov);
   	}

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
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
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
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="cNroDocumento='".$_POST['cNroDocumento']."', ";
    $sqlUpd.="iCodRemitente='$_POST[iCodRemitente]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]' ";
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
		
  	if($_POST[nFlgEnvio]==1){
  		$sqlUpdEnvio="UPDATE Tra_M_Tramite SET nFlgEnvio='$_POST[nFlgEnvio]' WHERE iCodTramite='$_POST[iCodTramite]'";
			$rsUpdEnvio=sqlsrv_query($cnx,$sqlUpdEnvio);
  		
  		$sqlMov="INSERT INTO Tra_M_Tramite_Movimientos ";
			$sqlMov.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,                iCodTrabajadorDerivar,              cCodTipoDocDerivar,    cAsuntoDerivar, 	   cObservacionesDerivar,    iCodDigital, 						iCodTramiteRel, 				fFecDerivar,   nEstadoMovimiento, fFecMovimiento, nFlgEnvio,   cFlgTipoMovimiento)";
			$sqlMov.=" VALUES ";
			$sqlMov.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 4, 						'".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaResponsable]', '$_POST[iCodTrabajadorResponsable]', '$_POST[cCodTipoDoc]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$RsUltDig[iCodDigital]', '$_POST[iCodTramite]', '$fFecActual', 1,                '$fFecActual',   1,					 3)";
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
		echo "<input type=hidden name=cCodificacion value=\"".$_POST[cCodificacion]."\">";
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
    
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		
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
    if($_POST[cReferencia]!=""){
    		if($_POST[cReferenciaOriginal]!=$_POST[cReferencia]){
    				$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cReferencia]'";
						$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
						if(sqlsrv_has_rows($rsBusRef)>0){
							
							$sqlMv2="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_POST[iCodTramite]' ORDER BY iCodMovimiento ASC";
    					$rsMv2=sqlsrv_query($cnx,$sqlMv2);
    					$RsMv2=sqlsrv_fetch_array($rsMv2);
    					
							$RsBusRef=sqlsrv_fetch_array($rsBusRef);
							
							$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsBusRef[iCodTramite]' AND cFlgTipoMovimiento=5");
							
							$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    					$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,    iCodTrabajadorDerivar,    iCodIndicacionDerivar,    cPrioridadDerivar,    cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   nFlgEnvio, cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento)";
    					$sqlAdRf.=" VALUES ";
    					$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', 1,         '$cCodificacion',  '$fFecActual',   1, 						    5)";
    					$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
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
    		$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
    		$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar,       iCodTrabajadorDerivar,       iCodIndicacionDerivar,       cPrioridadDerivar,       cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento)";
    		$sqlAdMv.=" VALUES ";
    		$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaMov]', '$_POST[iCodTrabajadorMov]', '$_POST[iCodIndicacionMov]', '$_POST[cPrioridadMov]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1)";
    		$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    		
    		echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad=\"document.form_envio.submit();\">";
   			echo "<form method=POST name=form_envio action=registroOficinaEdit.php?iCodTramite=".$_POST[iCodTramite]."&URI=".$_POST[URI]."&clear=1#area>";
   			echo "<input type=hidden name=cCodTipoDoc value=\"".$_POST[cCodTipoDoc]."\">";
   			echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_POST[iCodTrabajadorSolicitado]."\">";
   			echo "<input type=hidden name=cReferencia value=\"".$_POST[cReferencia]."\">";
   			echo "<input type=hidden name=cAsunto value=\"".$_POST['cAsunto']."\">";
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
    }Else{
    	$fFecPlazo="NULL";
    }
    
    if($_POST[iCodRemitente]==""){
    		$iCodRemitente="NULL";
    }Else{
    		$iCodRemitente="'".$_POST[iCodRemitente]."'";
    }
    	
    
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="iCodTrabajadorSolicitado='$_POST[iCodTrabajadorSolicitado]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="iCodIndicacion=6, ";  //conocimiento y fines
    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo, ";
    $sqlUpd.="cSiglaAutor='$_POST[cSiglaAutor]', ";
    $sqlUpd.="iCodRemitente=$iCodRemitente, ";
    $sqlUpd.="nFlgEnvio=1 ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);

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
    				$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   fFecMovimiento, nEstadoMovimiento, nFlgEnvio)";
    				$sqlAdMv.=" VALUES ";
    				$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 3,            '".$_SESSION['iCodOficinaLogin']."', 1,                  6,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1)";
    				$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  	}
  	
  	// relacion por ferencia
    if($_POST[cReferencia]!=""){
    		if($_POST[cReferenciaOriginal]!=$_POST[cReferencia]){
    				$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cReferencia]'";
						$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
						if(sqlsrv_has_rows($rsBusRef)>0){
							$RsBusRef=sqlsrv_fetch_array($rsBusRef);
							
							$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsBusRef[iCodTramite]' AND cFlgTipoMovimiento=5");
							
							$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    					$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar,      fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, nFlgEnvio)";
    					$sqlAdRf.=" VALUES ";
    					$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  1,                  6,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$_POST[cCodificacion]', '$fFecActual',  1, 						     5,                  1)";
    					$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
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
   	echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "<input type=hidden name=nFlgTipoDoc value=3>";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
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
    
    // armar correlativo
    $cCodificacion=add_ceros($nCorrelativo,5)."-".date("Y")."-PCM/".trim($RsSigla[cSiglaOficina])."-".trim($RsSiglaSol[cSiglaOficina]);
    
    
    $sqlAdd="INSERT INTO Tra_M_Tramite ";
    $sqlAdd.="(nFlgTipoDoc, nFlgClaseDoc, cCodificacion,     iCodTrabajadorRegistro,        iCodOficinaRegistro,           cCodTipoDoc,           fFecDocumento,	iCodOficinaSolicitado, 				   cReferencia, 				   cAsunto,           cObservaciones, 				 iCodIndicacion, nFlgRpta,					 nNumFolio,						fFecPlazo,  cSiglaAutor,   				 fFecRegistro,	 iCodRemitente,					 nFlgEstado, nFlgEnvio)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="(3,           2,					  '$cCodificacion',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]', '$fFecActual', '$_POST[iCodOficinaSolicitado]', '$_POST[cReferencia]', '$_POST['cAsunto']', '$_POST[cObservaciones]', 6,              '$_POST[nFlgRpta]', '$_POST[nNumFolio]', $fFecPlazo, '$_POST[cSiglaAutor]', '$fFecActual', '$_POST[iCodRemitente]', 1,          1)";
    $rs=sqlsrv_query($cnx,$sqlAdd);
    
    //Ultimo registro de tramite
		$rsUltTra=sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC");
		$RsUltTra=sqlsrv_fetch_array($rsUltTra);
		
		if($_POST[iCodRemitente]!=""){
    		$sqlAddCargo="INSERT INTO Tra_M_Doc_Salidas_Multiples ";
    		$sqlAddCargo.="(iCodTramite,              cCodificacion,    iCodRemitente,           iCodOficina,                  cAsunto,           cFlgEnvio,iCodTrabajadorRegistro) ";
    		$sqlAddCargo.="VALUES ";
    		$sqlAddCargo.="('$RsUltTra[iCodTramite]' ,'$cCodificacion','$_POST[iCodRemitente]', $_SESSION['iCodOficinaLogin'], '$_POST['cAsunto']', 1,        '".$_SESSION['CODIGO_TRABAJADOR']."') ";
   			//echo $sqlAddCargo."<br>";
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
    $sqlAdMv.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, nFlgEnvio)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('$RsUltTra[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,            '".$_SESSION['iCodOficinaLogin']."', 1,                  6,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual', 1,                  1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);

  	// relacion por ferencia
    if($_POST[cReferencia]!=""){
    		$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cReferencia]'";
				$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
				if(sqlsrv_has_rows($rsBusRef)>0){
					$RsBusRef=sqlsrv_fetch_array($rsBusRef);
					$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    			$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar,  iCodIndicacionDerivar,  cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar, fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, nFlgEnvio)";
    			$sqlAdRf.=" VALUES ";
    			$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  1,                   6,                      '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',   '$fFecActual',  1, 						    5,                  1)";
    			$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
				}
    }
		
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=registroInternoObs.php>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
		echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
		echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
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
    		$iCodRemitente="'".$_POST[iCodRemitente]."'";
    }
    
    $sqlUpd="UPDATE Tra_M_Tramite SET ";
    $sqlUpd.="cCodTipoDoc='$_POST[cCodTipoDoc]', ";
    $sqlUpd.="cReferencia='$_POST[cReferencia]', ";
    $sqlUpd.="cAsunto='$_POST['cAsunto']', ";
    $sqlUpd.="cObservaciones='$_POST[cObservaciones]', ";
    $sqlUpd.="iCodIndicacion=6, "; //conocimiento y fines
    $sqlUpd.="nFlgRpta='$_POST[nFlgRpta]', ";    
    $sqlUpd.="nNumFolio='$_POST[nNumFolio]', ";
    $sqlUpd.="fFecPlazo=$fFecPlazo, ";
    $sqlUpd.="cSiglaAutor='$_POST[cSiglaAutor]', ";
    $sqlUpd.="iCodRemitente=$iCodRemitente, ";
    $sqlUpd.="nFlgEnvio=1 ";
    $sqlUpd.="WHERE iCodTramite='$_POST[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);

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
    				$sqlAdMv.="(iCodTramite,           iCodTrabajadorRegistro,         nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   fFecMovimiento, nEstadoMovimiento, nFlgEnvio)";
    				$sqlAdMv.=" VALUES ";
    				$sqlAdMv.="('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."', 3,            '".$_SESSION['iCodOficinaLogin']."', 1,                  6,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$fFecActual',  1,                 1)";
    				$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
  	}
  	
  	// relacion por ferencia
    if($_POST[cReferencia]!=""){
    		if($_POST[cReferenciaOriginal]!=$_POST[cReferencia]){
    				$sqlBusRef="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cReferencia]'";
						$rsBusRef=sqlsrv_query($cnx,$sqlBusRef);
						if(sqlsrv_has_rows($rsBusRef)>0){
							$RsBusRef=sqlsrv_fetch_array($rsBusRef);
							
							$rsDel=sqlsrv_query($cnx,"DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsBusRef[iCodTramite]' AND cFlgTipoMovimiento=5");
							
							$sqlAdRf="INSERT INTO Tra_M_Tramite_Movimientos ";
    					$sqlAdRf.="(iCodTramite,              iCodTrabajadorRegistro,             nFlgTipoDoc, iCodOficinaOrigen,              cCodTipoDocDerivar,    iCodOficinaDerivar, iCodIndicacionDerivar, cAsuntoDerivar,    cObservacionesDerivar,    fFecDerivar,   cReferenciaDerivar,      fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento, nFlgEnvio)";
    					$sqlAdRf.=" VALUES ";
    					$sqlAdRf.="('$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     3,           '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  1,                  6,                     '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$_POST[cCodificacion]', '$fFecActual',  1, 						     5,                  1)";
    					$rsAdRf=sqlsrv_query($cnx,$sqlAdRf);
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
   	echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
   	echo "<input type=hidden name=URI value=\"".$_POST[URI]."\">";
   	echo "<input type=hidden name=nFlgTipoDoc value=3>";
	if($nFlgRestricUp==1){
		echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
		echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
	}   	
   	echo "</form>";
	break;
  case 19: //a�adir movimiento temporal
		for ($i=0;$i<count($_POST[lstOficinasSel]);$i++){
			$lstOficinasSel=$_POST[lstOficinasSel];
   		
   		$sqlTrb="SELECT TOP 1 * FROM Tra_M_Trabajadores WHERE iCodOficina='$lstOficinasSel[$i]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
      $rsTrb=sqlsrv_query($cnx,$sqlTrb);
      $RsTrb=sqlsrv_fetch_array($rsTrb);
			
			$sqlAdd="INSERT INTO Tra_M_Tramite_Temporal ";
    	$sqlAdd.="(iCodOficina,           iCodTrabajador,           iCodIndicacion,          cPrioridad,           cCodSession)";
    	$sqlAdd.=" VALUES ";
    	$sqlAdd.="('$lstOficinasSel[$i]', '$RsTrb[iCodTrabajador]', '$_POST[iCodIndicacion]', '$_POST[cPrioridad]', '$_SESSION[cCodSession]')";
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
	
}Else{
	header("Location: ../index-b.php?alter=5");
}


?>