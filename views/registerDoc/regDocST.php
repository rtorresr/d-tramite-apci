<?php session_start();
date_default_timezone_set('America/Lima');

$fFechaHora   = date("d-m-Y  G:i");

function add_ceros($numero,$ceros) {
    $order_diez = explode(".",$numero);
    $dif_diez = $ceros - strlen($order_diez[0]);
    $insertar_ceros = '';
    for($m=0; $m<$dif_diez; $m++){
        $insertar_ceros .= 0;
    }
    return $insertar_ceros .= $numero;
}

if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
    include_once("../../conexion/conexion.php");
    $fFecActual = date("Ymd")." ".date("G:i:s");
    $rutaUpload = "../../cAlmacenArchivos/";
    $nNumAno    = date("Y");

  		if(($_SESSION['cCodRef']??'')==""){
            $Fecha = date("Ymd-Gis");
            $_SESSION['cCodRef']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$Fecha;
        }
  		$nCodBarra = random_int(100,999);

  		$max_chars = round(random_int(5,10));
			$chars = array();
			for($i="a";$i<"z";$i++){
                $chars[]=$i;
                $chars[]="z";
            }
            $clave='';
			for ($i=0; $i<$max_chars; $i++){
                $letra=round(random_int(0, 1));
                if ($letra){
                    $clave.= $chars[round(random_int(0,count($chars)-1))];
                }else{
                    $clave.= round(random_int(0, 9));
                }
            }
			$cPassword = $clave;

    	$rsCorr = sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo 
    					   						 FROM Tra_M_Correlativo 
    					   						 WHERE nFlgTipoDoc = 1 AND nNumAno='$nNumAno'");

			$RsCorr = sqlsrv_fetch_array($rsCorr);
			$CorrelativoAsignar = $RsCorr['nCorrelativo']+1;

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
    	// Están pidiendo el siguiente formaro: E-sede-Año-correlativo
    	$cCodificacion = "E".$codigo_sede.$year.add_ceros($CorrelativoAsignar,5);
    	// FIN DE MODIFICACION

    	/* I MAX */
    	// $clave= random_int(1000000000,9999999999);
    	$an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    	$clave = substr($an,random_int(0,34),2).substr($an,random_int(0,34),2).substr($an,random_int(0,34),2).substr($an,random_int(0,34),2).substr($an,random_int(0,34),2);
    	/* F MAX */

    	if (($_POST['nFlgClaseDoc']??'') == 1){ //sql con tupa
            //  Sql es ejecutado en SP
            $cNroDocumento	= stripslashes(htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES));
            $cNomRemite		  = stripslashes(htmlspecialchars($_POST['cNomRemite'], ENT_QUOTES));
            $cAsunto		    = stripslashes(htmlspecialchars($_POST['cAsunto'], ENT_QUOTES));
            $cObservaciones	= stripslashes(htmlspecialchars($_POST['cObservaciones'], ENT_QUOTES));
            $nNumFolio		  = stripslashes(htmlspecialchars($_POST['nNumFolio'], ENT_QUOTES));
            $cReferencia	  = stripslashes(htmlspecialchars($_POST['cReferencia'], ENT_QUOTES));
            $archivoFisico	= stripslashes(htmlspecialchars($_POST['archivoFisico'], ENT_QUOTES));

             //if($_POST['nFlgEnvio'] == ""){
             	$_POST['nFlgEnvio'] = 1;
            // }else  if($_POST['nFlgEnvio'] == 1){
             	//$_POST['nFlgEnvio'] = "";
             //}

            if ($_POST['ActivarDestino'] == 1) {
                $mantenerPendiente = 1; // SI HA SIDO ENVIADO CON TUPA
            }else{
                $mantenerPendiente = 0; // NO HA SIDO ENVIADO CON TUPA
            }
            /* I MAX */
            $cObservaciones = htmlspecialchars($_POST['cNroDocumento'], ENT_QUOTES);

            $fechamax=$_POST['fechaDocumento'];
            $fe1=explode('-',$fechamax);
            // EN PRONVERSION
            $fe2= $fe1[1]."-".$fe1[0]."-".$fe1[2];
            // EN LCP
            //$fe2= $fe1[0]."-".$fe1[1]."-".$fe1[2];
            $fechamax=$fe2;

            $sqlAdd = "SP_DOC_ENTRADA_CON_TUPA_INSERT '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '
            ".($_POST['cCodTipoDoc']??'')."', '$fFecActual', '$cNroDocumento', '".($_POST['iCodRemitente']??'')."', '$cNomRemite', '$cAsunto', '$cObservaciones', '
            ".($_POST['iCodTupaClase']??'')."', '".($_POST['iCodTupa']??'')."', '$cReferencia', '".($_POST['iCodIndicacion']??'')."', '$nNumFolio', '".($_POST['nTiempoRespuesta']??'')."', '
            $mantenerPendiente',  '$fFecActual', '$nCodBarra', '$cPassword','$fechamax','$archivoFisico','$clave'";
            /* F MAX */
        }

    	if ($_POST['nFlgClaseDoc'] == 2){ //sql sin tupa
            $cNroDocumento	= stripslashes(htmlspecialchars(($_POST['cNroDocumento']??''), ENT_QUOTES));
            $cNomRemite		  = stripslashes(htmlspecialchars(($_POST['cNomRemite']??''), ENT_QUOTES));
            $cAsunto		    = stripslashes(htmlspecialchars(($_POST['cAsunto']??''), ENT_QUOTES));
            $cObservaciones	= stripslashes(htmlspecialchars(($_POST['cObservaciones']??''), ENT_QUOTES));
            $nNumFolio		  = stripslashes(htmlspecialchars(($_POST['nNumFolio']??''), ENT_QUOTES));
            $cReferencia	  = stripslashes(htmlspecialchars(($_POST['cReferencia']??''), ENT_QUOTES));
            $archivoFisico	= stripslashes(htmlspecialchars(($_POST['archivoFisico']??''), ENT_QUOTES));


             if ($_POST['nFlgEnvio'] == ""){
                 $mantenerPendiente= $_POST['nFlgEnvio'] = 1;
             }else  if ($_POST['nFlgEnvio'] == 1){
                 $mantenerPendiente= $_POST['nFlgEnvio'] = "";
             }
            /*if ($_POST['ActivarDestino'] == 1) { // Si Derivar inmediatamente
                $mantenerPendiente = 1; // SI HA SIDO ENVIADO SIN TUPA Y EN PUNTO DE CONTROL ESTARIA PENDIENTE DE APROBACIÓN
            }else{
                $mantenerPendiente = 0; // NO HA SIDO ENVIADO SIN TUPA Y NO SE VISUALIZA EN PUNTO DE CONTROL YA QUE FALTA
                // POSIBLEMENTE, AGREGAR ALGO MAS AL DOCUMENTO, ANTES DE SER ENVIADO INMEDIATAMENTE
            }*/
            //  Sql es ejecutado en SP
            /* I MAX*/
            $fechamax=$_POST['fechaDocumento'];
            $fe1=explode('-',$fechamax);
            // EN PRONVERSION
            $fe2= $fe1[1]."-".$fe1[0]."-".$fe1[2];
            // EN LCP
            //$fe2= $fe1[0]."-".$fe1[1]."-".$fe1[2];
            $fechamax=$fe2;
            $sqlAdd = '';

            $sqlAdd.="SP_DOC_ENTRADA_SIN_TUPA_INSERT '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".($_POST['cCodTipoDoc']??'')."', '$fFecActual', '$cNroDocumento', '".($_POST['iCodRemitente']??'')."', '$cNomRemite', '$cAsunto', '$cObservaciones', '$cReferencia', '".($_POST['iCodIndicacion']??'')."', '$nNumFolio', '".($_POST['nTiempoRespuesta']??'')."',' $mantenerPendiente','$fFecActual',  '$nCodBarra', '$cPassword','$fechamax','$archivoFisico','$clave'";

        }

    	$rs = sqlsrv_query($cnx,$sqlAdd);

    	$rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite 
    													 WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."' 
    													 ORDER BY iCodTramite DESC");
			$RsUltTra = sqlsrv_fetch_array($rsUltTra);
		if (isset($_POST['iCodTupaRequisito'])) {
            for ($h = 0; $h < count($_POST['iCodTupaRequisito']); $h++) {
                $iCodTupaRequisito = ($_POST['iCodTupaRequisito'] ?? '');
                //  Sql es ejecutado en SP
                $sqlIns = "SP_DOC_ENTRADA_REQ_CON_TUPA_INSERT '$iCodTupaRequisito[$h]', '" . $RsUltTra['iCodTramite'] . "' ";
                //	$sqlIns="INSERT INTO Tra_M_Tramite_Requisitos (iCodTupaRequisito, iCodTramite) VALUES ('$iCodTupaRequisito[$h]', '$RsUltTra['iCodTramite']') ";
                $rsIns = sqlsrv_query($cnx, $sqlIns);
            }
        }

			if($_POST['iCodOficinaResponsable']!=""){
                //  Sql es ejecutado en SP
                $sqlMov = "SP_DOC_ENTRADA_MOVIMIENTO_INSERT '".($RsUltTra['iCodTramite']??'')."', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['iCodOficinaResponsable']."', '".$_POST['iCodTrabajadorResponsable']."', '".$_POST['cCodTipoDoc']."', '".$_POST['iCodIndicacion']."', '$fFecActual',  '$fFecActual',   '".$_POST['nFlgEnvio']."'";
                $rsMov = sqlsrv_query($cnx,$sqlMov);
            }
        if (empty($_FILES['fileUpLoadDigital'])) {
            if ($_FILES['fileUpLoadDigital'] != "") {
                for ($i = 0; $i <= strlen($_FILES['fileUpLoadDigital']); $i++) {
                    include_once("../../conexion/conexion.php");
                    $extension = explode(".", $_FILES['fileUpLoadDigital']['name'][$i]);
                    $num = count($extension) - 1;
                    $cNombreOriginal = $_FILES['fileUpLoadDigital']['name'][$i];
                    if ($extension[$num] == "exe" OR $extension[$num] == "dll" OR $extension[$num] == "EXE" OR $extension[$num] == "DLL") {
                        $nFlgRestricUp = 1;
                    } Else {
                        $nuevo_nombre = $cCodificacion . "-" . $RsUltTra['iCodTramite'] . "." . $extension[$num];
                        move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'][$i], "$rutaUpload$nuevo_nombre");

                        $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('" . $RsUltTra['iCodTramite'] . "', '$cNombreOriginal', '$nuevo_nombre')";
                        $rsDigt = sqlsrv_query($cnx, $sqlDigt);
                    }
                }
            }
        }
	//////////////////////////////////////////////////////
	// 	$sqlIns="select * from Tra_M_Tramite_Referencias where cCodSession=".$_SESSION['cCodRef'];
	//	$rsDigt=sqlsrv_query($cnx,$sqlDigt);
	$sqlRefcnt="select count(iCodReferencia) as CntRef from Tra_M_Tramite_Referencias where cCodSession='".$_SESSION['cCodRef']."'";
	//echo $sqlRefcnt;
	$rsCnT1=sqlsrv_query($cnx,$sqlRefcnt);
	$RsCnT2=sqlsrv_fetch_array($rsCnT1);
	$conteo2=$RsCnT2[0];

    if ($conteo2>=1){
        $sqlTraF="SELECT TOP 1 iCodTramite FROM Tra_M_Tramite where iCodTrabajadorRegistro='".$_SESSION['CODIGO_TRABAJADOR']."' order by fFecRegistro desc";
        $rsTraf1=sqlsrv_query($cnx,$sqlTraF);
        $RsTraf2=sqlsrv_fetch_array($rsTraf1);

        $sqlUptRef="UPDATE Tra_M_Tramite_Referencias   SET iCodTramite = '".$RsTraf2[0]."'  WHERE cCodSession='".$_SESSION['cCodRef']."'";
        $rsUptr = sqlsrv_query($cnx,$sqlUptRef);
    }

	$sqlCodigoTramite = "SELECT TOP 1 iCodTramite FROM Tra_M_Tramite ORDER BY iCodTramite DESC";
	$rsCodigoTramite  = sqlsrv_query($cnx,$sqlCodigoTramite);
	$RsCodigoTramite  = sqlsrv_fetch_array($rsCodigoTramite);



    // -------------------------------------------------------
    // Derivar inmediatamente: correo instantaneo
    // -------------------------------------------------------
    if (($_POST['ActivarDestino']??'') == 1) {
        $idtramitenew   =   $RsCodigoTramite['iCodTramite'];
        $responsable    =   $_POST['iCodTrabajadorResponsable'];
        $tipodocumento  =   $_POST['cCodTipoDoc'];
        $codx           =   $cCodificacion;
        $remitente      =   $_POST['cNombreRemitente'];
        $opc=1; // pro aprobar
        include("email.php");
    }
    // -------------------------------------------------------

	//unset($_SESSION['cCodRef']);
	/*echo "<html>";
	echo "<head>";
	echo "</head>";
	echo "<body OnLoad=\"document.form_envio.submit();\">";
	echo "<form method=POST name=form_envio action=registroConcluido.php>";
	echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
	echo "<input type=hidden name=nCodBarra value=\"".$nCodBarra."\">";
	echo "<input type=hidden name=cPassword value=\"".$cPassword."\">";
	echo "<input type=hidden name=iCodTramite value=\"".$RsCodigoTramite['iCodTramite']."\">";*/
	//echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
	//echo "<input type=hidden name=nFlgClaseDoc value=\"".$_POST['nFlgClaseDoc']."\">";

	//if($nFlgRestricUp == 1){
      //  echo "<input type=hidden name=nFlgRestricUp value=\"1\">";
      //  echo "<input type=hidden name=cNombreOriginal value=\"".$cNombreOriginal."\">";
    //}

    echo '<div class="card">
            <div class="card-header text-center ">';

	if($_POST['nFlgClaseDoc'] == '1'){
	    echo "Registro de entrada con tupa";
	}
	if($_POST['nFlgClaseDoc'] == '2'){
	    echo "Registro de entrada sin tupa";
	};
    echo '</div>
              <div class="card-body">
                   <div id="registroBarr">
                        <table align="center" cellpadding="3" cellspacing="3" border="0">
                            <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b></td></tr>
                            <tr>
                            <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">';

    $sqlRefcnt = "SELECT clave FROM Tra_M_Tramite WHERE cCodificacion = '".$cCodificacion."'";
    $rsCnT1 = sqlsrv_query($cnx,$sqlRefcnt);
    $RsCnT2 = sqlsrv_fetch_array($rsCnT1);
    $clave  = $RsCnT2[0];
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode\temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'registerDoc/phpqrcode/temp/';
    include "phpqrcode/qrlib.php";
    if (!file_exists('c:/STD_DOCUMENTO')){
        mkdir('c:/STD_DOCUMENTO', 0777, true);}
    if (!file_exists($PNG_TEMP_DIR)){
        mkdir($PNG_TEMP_DIR);}
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 2;
    $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/tramite_DOCUMENTARIO DIGITAL/ver_tramite.php?expediente='.$cCodificacion;
    $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    $filename = $PNG_TEMP_DIR.$codigoQr;
    QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    $img_final="<img src=".$PNG_WEB_DIR.basename($filename).">";

    echo $img_final;

    echo      '</td>
             </tr>
             <tr>
                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">';
    echo "Tramite N° ".$cCodificacion;
    echo             '</i>
                </td>
             </tr>
             <tr>
               <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">CLAVE: ';
    echo $clave;
    echo           '</i>
                </td>
              </tr>
              <tr>
                 <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA: 
                         <b>';

    if (!empty($fFecActual)) {
        $date = date_create($fFecActual);
        echo $date->format("Y-m-d H:i:s");
    };
    echo                                     '</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b>
                                    </td>
                                </tr>';

    $sqlGenerador = "SELECT cNombresTrabajador, cApellidosTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
    $rsGenerador  = sqlsrv_query($cnx,$sqlGenerador);
    $RsGenerador  = sqlsrv_fetch_object($rsGenerador);

    echo                       '<tr>
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">';
    echo "GENERADO POR :".$RsGenerador->cApellidosTrabajador.", ".$RsGenerador->cNombresTrabajador;

    echo                           '</td>
                                </tr>
                            </table>
                        </div>
                        <table>
                            <tr>
                                <td>
                                    <button class="btn btn-primary" style="width:120px" onclick="crearVentana();">
                                        <table cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style=" font-size:10px"><b>Imprimir Ficha</b>&nbsp;&nbsp;</td>
                                                <td><img src="images/icon_print.png" width="17" height="17" border="0"></td>
                                            </tr>
                                        </table>
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <br>';

    if($nFlgRestricUp??'' == 1){
        echo '<div style="font-family:arial;font-size:12px;color:#ff0000">
                                El archivo seleccionado "<b>';
        echo $cNombreOriginal;
        echo '</b>" para "Adjuntar Archivo" <br>no ha sido registrado debido a una restricción en la extensión.</div>';
    }

    echo            '</div>
                </div>';

    echo '<script language="Javascript">
        var ventana;
        function crearVentana() {
            ventana = window.open("registroConCluidoPrint.php?iCodTramite='.$RsCodigoTramite['iCodTramite'].'&nCodBarra='.$nCodBarra.'&cCodificacion='.$cCodificacion.'&cPassword='.$cPassword.'&fFechaHora='.$fFechaHora.'","nuevo","width=330,height=240");
            setTimeout(cerrarVentana,6000);
        }

        function cerrarVentana(){
            ventana.close();
        }
    </script>';


} else {
    header("Location: ../../index-b.php?alter=5");
} ?>