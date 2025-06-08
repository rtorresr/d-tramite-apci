<?php
session_start();
date_default_timezone_set('America/Lima');

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    function add_ceros($numero,$ceros) {
        $insertar_ceros = 0;
        $order_diez = explode('.',$numero);
        $dif_diez = $ceros - strlen($order_diez[0]);
        for($m=0; $m<$dif_diez; $m++){
            $insertar_ceros .= 0;
        }
        return $insertar_ceros.= $numero;
    }

    include_once('../../conexion/conexion.php');
    include_once("../../conexion/srv-Nginx.php");
    include_once("../../core/CURLConection.php");

    $fFecActual = date('Ymd').' '.date('G:i:s');
    $nNumAno    = date('Y');
    $nNumMes    = date('M');
    $fFechaHora   = date("d-m-Y  G:i");

    if(!isset($_SESSION['cCodRef'])){
        $Fecha = date('Ymd-Gis');
        $_SESSION['cCodRef']=$_SESSION['CODIGO_TRABAJADOR'].'-'.$_SESSION['iCodOficinaLogin'].'-'.$Fecha;
    }

    switch ($_POST['opcion'] ){
        case 1: // registro por mesa de partes
            echo '<style>td,th {text-align: center!important;}</style>';

            // agrega referencias a tabla referencias sin cod de tramite
            if(isset($_POST['cReferencia'])){
                for ($i = 0; $i < count($_POST['cReferencia']); $i++){
                    $ref = $_POST['cReferencia'][$i];
                    $rsCref = sqlsrv_query($cnx, "SELECT cCodificacion  FROM Tra_M_Tramite WHERE iCodTramite = ".$ref);
                    $RsCref = sqlsrv_fetch_array($rsCref);

                    $sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
                    $sqlAdd.="(iCodTramiteRef,  cReferencia, cCodSession, cDesEstado, iCodTipo,identificador)";
                    $sqlAdd.=" VALUES ";
                    $sqlAdd.="('".$ref."','".$RsCref['cCodificacion']."', '".$_SESSION['cCodRef']."', 'PENDIENTE', 1,' ')";
                    $rs=sqlsrv_query($cnx,$sqlAdd);
                }
            }

            // genera codigo de barra


            //genera  clave


            $nNumFolio		  = stripslashes(htmlspecialchars($_POST['nNumFolio'], ENT_QUOTES));
            $cNomRemite		  = stripslashes(htmlspecialchars($_POST['cNomRemite'], ENT_QUOTES));
            $archivoFisico	= stripslashes(htmlspecialchars($_POST['archivoFisico'], ENT_QUOTES));
            $completo = $_POST['nFlgEnvio']??1;
            $documentoCargado = $_POST['documentoCargado'];
            $fDoc = date("Ymd G:i:s", strtotime($_POST['fechaDocumento']));

            // Si esta completo deriva , guarda documento de entrada, genera codificación y guarda fecha plazo rwal
            if ($completo == 1 ) {

                //Genera el correlativo
                //$rsCorr = sqlsrv_query($cnx,"SELECT TOP 1 nCorrelativo FROM Tra_M_Correlativo  WHERE nNumAno='".$nNumAno."'");
                $rsCorr = sqlsrv_query($cnx,"SELECT max(nCorrelativo)  nCorrelativo FROM Tra_M_Correlativo  WHERE nNumAno= year(GETDATE()) ");
                if(sqlsrv_has_rows($rsCorr)) {
                    $RsCorr = sqlsrv_fetch_array($rsCorr);
                    $CorrelativoAsignar = $RsCorr['nCorrelativo'] + 1;
                    //$rsUpdCorr = sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo SET nCorrelativo='".$CorrelativoAsignar."' WHERE nNumAno='".$nNumAno."'");
                    $rsUpdCorr = sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo SET nCorrelativo= nCorrelativo+1 WHERE nNumAno=year(GETDATE()) ");
                }else{
                    $CorrelativoAsignar=1;
                    //$rsUpdCorr = sqlsrv_query($cnx,"INSERT INTO Tra_M_Correlativo (nCorrelativo,nNumAno) VALUES ('".$CorrelativoAsignar."','".$nNumAno."')");
                    $rsUpdCorr = sqlsrv_query($cnx,"INSERT INTO Tra_M_Correlativo (nCorrelativo,nNumAno) VALUES ('".$CorrelativoAsignar."', year(GETDATE()) )");
                }

                // -------- codificación ---------------------------
                // INICIO DE MODIFICACION (busca la sede)
                $sqlSede = "SELECT TD.CODIGO_SEDE AS 'CODIGO_SEDE' FROM (Tra_M_Trabajadores AS TT INNER JOIN Tra_U_Departamento AS TD ON TT.CODIGO_SEDE = TD.CODIGO_SEDE)";
                $sqlSede.= "WHERE TT.iCodTrabajador = '".$_SESSION['CODIGO_TRABAJADOR']."'";
                $rsSede = sqlsrv_query($cnx,$sqlSede);
                $RsSede = sqlsrv_fetch_array($rsSede);
                $codigo_sede = $RsSede['CODIGO_SEDE'];
                $year = date('Y');

                // Están pidiendo el siguiente formaro: E-sede-Año-correlativo
                $cCodificacion = add_ceros($CorrelativoAsignar,4)."-".$year;
                // FIN DE MODIFICACION
                // -------- codificación ---------------------------

                // registro en la tabla de trámite
                if ($_POST['nFlgClaseDoc']??'' == 1){ //sql con tupa
                    //fecha plazo
                    $tRespuesta = $_POST['nTiempoRespuesta'];
                    $fechamax = date("Ymd G:i:s",strtotime($fFecActual."+ ".$tRespuesta." days"));
                    $sqlAdd = "SP_DOC_ENTRADA_CON_TUPA_INSERT '".$cCodificacion."', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '".$fDoc."', '".$cNroDocumento."', '".($_POST['iCodRemitente']??'')."', '".$cNomRemite."', '".$cAsunto."', '".$cObservaciones."', '".$_POST['iCodTupaClase']."', '".$_POST['iCodTupa']."', ' ', '".$_POST['iCodIndicacion']."', '".$nNumFolio."', '".$_POST['nTiempoRespuesta']."', '1',  '".$fFecActual."', '".$nCodBarra."', '".$cPassword."','".$fechamax."','".$archivoFisico."','".$clave."'";

                } else { //sin tupa
                    $fechamax = date("Ymd G:i:s",strtotime($fFecActual."+ 30 days"));
                    $sqlAdd ="SP_DOC_ENTRADA_SIN_TUPA_INSERT '$cCodificacion', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '$fDoc', '$cNroDocumento', '".($_POST['iCodRemitente']??'')."', '$cNomRemite', '$cAsunto', '$cObservaciones', ' ', '".$_POST['iCodIndicacion']."', '$nNumFolio', '30',' 1','$fFecActual',  '$nCodBarra', '$cPassword','$fechamax','$archivoFisico','$clave'";
                }
                $rs = sqlsrv_query($cnx,$sqlAdd);

                $rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite  WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."'ORDER BY iCodTramite DESC");
                $RsUltTra = sqlsrv_fetch_array($rsUltTra);

                //derivacion
                $sqlMov = "SP_DOC_ENTRADA_MOVIMIENTO_INSERT '" . $RsUltTra['iCodTramite'] . "', '" . $_SESSION['CODIGO_TRABAJADOR'] . "', '" . $_SESSION['iCodOficinaLogin'] . "', '" . $_POST['iCodOficinaResponsable'] . "', '" . $_POST['iCodTrabajadorResponsable'] . "', '" . $_POST['cCodTipoDoc'] . "', '" . $_POST['iCodIndicacion'] . "', '" . $fFecActual . "',  '" . $fFecActual . "',   '" . ($_POST['nFlgEnvio']??1) . "'";
                $rsMov = sqlsrv_query($cnx, $sqlMov);

                //nomenclatura de documento
                $sqlTipDoc = "SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='" . $_POST['cCodTipoDoc'] . "'";
                $rsTipDoc = sqlsrv_query($cnx, $sqlTipDoc);
                $RsTipDoc = sqlsrv_fetch_array($rsTipDoc);
                $sqlNomUsr = "SELECT cUsuario FROM Tra_M_Trabajadores WHERE iCodTrabajador='" . $_SESSION['CODIGO_TRABAJADOR'] . "'";
                $rsNomUsr = sqlsrv_query($cnx, $sqlNomUsr);
                $RsNomUsr = sqlsrv_fetch_array($rsNomUsr);

                $nomenclatura = $nNumAno . '/' . str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '/' . $nNumMes . '/' . trim($RsNomUsr['cUsuario']);
                $url_srv = $hostUpload . ':' . $port . $path;
                $url_f = 'docEntrada/' . $nomenclatura . '/';
                $nuevo_nombre = str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '-' . str_replace('/', '-', $cCodificacion) . '.pdf';
                $url = $url_srv . $url_f . $nuevo_nombre;

                //conexion del curl
                $curl = new CURLConnection($url_srv . $fileUpload);

                if($documentoCargado === '1') {
                    $rsUpfec = sqlsrv_query($cnx, "UPDATE Tra_M_Tramite SET fFecPlazo = '" . $fechamax . "' , FECHA_DOCUMENTO = '" . $fechamax . "' WHERE iCodTramite = " . $RsUltTra['iCodTramite']);
                    //guarda documento
                    if (isset($_FILES['fileUpLoadDigital']) && $_FILES['fileUpLoadDigital']['name'] !== '') {
                        $extension = explode('.', $_FILES['fileUpLoadDigital']['name'][0]);
                        $num = count($extension) - 1;
                        /*$nuevo_nombre = str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '-' . str_replace('/', '-', $cCodificacion) . '.' . $extension[$num];*/
                        $cNombreOriginal = $_FILES['fileUpLoadDigital']['name'][0];
                        $_FILES['fileUpLoadDigital']['tmp_name'] = $_FILES['fileUpLoadDigital']['tmp_name'][0];
                        $_FILES['fileUpLoadDigital']['name'] = $_FILES['fileUpLoadDigital']['name'][0];
                        $_FILES['fileUpLoadDigital']['type'] = $_FILES['fileUpLoadDigital']['type'][0];
                        $_POST['path'] = $url_f;
                        $_POST['name'] = 'fileUpLoadDigital';

                        if ($extension[$num] == 'jpg' || $extension[$num] == 'jpeg' || $extension[$num] == 'png' || $extension[$num] == 'pdf' || $extension[$num] == 'doc' || $extension[$num] == 'docx' || $extension[$num] == 'xls' || $extension[$num] == 'xlsx' || $extension[$num] == 'ppt' || $extension[$num] == 'pptx' ) {
                            $nFlgRestricUp = 0;
                            $_POST['new_name'] = $nuevo_nombre;
                            $curl->uploadFile($_FILES, $_POST);
                        } else {
                            $nFlgRestricUp = 1;
                        }
                    }
                } else {
                    $fechamax = date("Ymd G:i:s",strtotime($fFecActual."+ 2 days"));
                    $rsUpfec = sqlsrv_query($cnx, "UPDATE Tra_M_Tramite SET fFecPlazo = '" . $fechamax . "' , FECHA_DOCUMENTO = '".$fechamax."' , nTiempoRespuesta = 2 , nFlgEnvio = 0 WHERE iCodTramite = " . $RsUltTra['iCodTramite']);
                };

                // genera el QR -------------------------------------------------------------------------
                include "phpqrcode/qrlib.php";
                $sqlClave = "SELECT clave FROM Tra_M_Tramite WHERE iCodTramite = '" . $RsUltTra['iCodTramite'] . "'";
                $rsClave = sqlsrv_query($cnx, $sqlClave);
                $RsClave = sqlsrv_fetch_array($rsClave);
                $clave = $RsClave['clave'];

                // crea temporal
                $tmp = dirname(tempnam(null, ''));
                $tmp = $tmp . "/upload/";
                if (!is_dir($tmp)) {
                    mkdir($tmp, 0777, true);
                }

                // establece direcciones temporal y de guardado
                $PNG_TEMP_DIR = $tmp;
                $PNG_WEB_DIR = $nomenclatura;

                $errorCorrectionLevel = 'L';
                $matrixPointSize = 2;

                // direccion que redirige
                $_REQUEST['data'] = $_SERVER['HTTP_HOST'] . '/views/consulta-web.php?cCodificacion='.$cCodificacion.'&contrasena='.$clave;

                //genera nombre del qr
                $codigoQr = 'test' . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
                $filename = $PNG_TEMP_DIR . $codigoQr;
                QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

                $nuevo_nombre_QR = str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '-' . str_replace('/', '-', $cCodificacion) . '.png';

                $_FILES['fileUpLoadDigital']['tmp_name'] = $filename;
                $_FILES['fileUpLoadDigital']['name'] = $codigoQr;
                $_FILES['fileUpLoadDigital']['type'] = 'PNG';

                $_POST['path'] = $url_f;
                $_POST['name'] = 'fileUpLoadDigital';
                $_POST['new_name'] = $nuevo_nombre_QR;

                $curl->uploadFile($_FILES, $_POST);
                $urlQR = 'http://' . $url_srv . $url_f . $nuevo_nombre_QR;
                $curl->closeCurl();

                sqlsrv_query($cnx, "UPDATE Tra_M_Tramite SET codigoQR = '" . $urlQR . "' , documentoElectronico = '" .$url. "' WHERE iCodTramite = " . $RsUltTra['iCodTramite']);

                $img_final = "<img src=" . $urlQR . ">";

                $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $RsUltTra['iCodTramite'] . "', '" . ($cNombreOriginal??'') . "', '" . $url . "', '5')";
                $rsDigt = sqlsrv_query($cnx, $sqlDigt);

                // -------------------------------------------------------
                // Derivar inmediatamente: correo instantaneo
                // -------------------------------------------------------
                /*if ($_POST['ActivarDestino'] === 1) {
                    $idtramitenew   =   $RsCodigoTramite['iCodTramite'];
                    $responsable    =   $_POST['iCodTrabajadorResponsable'];
                    $tipodocumento  =   $_POST['cCodTipoDoc'];
                    $codx           =   $cCodificacion;
                    $remitente      =   $_POST['cNombreRemitente'];
                    $opc=1; // por aprobar
                    include("email.php");
                }*/

                // registro concluido cuerpo
                echo '<div class="card">
            <div class="card-header text-center ">';

                if ($_POST['nFlgClaseDoc']??'' == 1){
                    echo "Registro de entrada con tupa";
                } else {
                    echo "Registro de entrada sin tupa";
                }

                echo '</div>
              <div class="card-body">
                   <div id="registroBarr">
                        <table align="center" cellpadding="3" cellspacing="3" border="0">
                            <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>D-TRÁMITE</b></td></tr>
                            <tr>
                            <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">';
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
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>d-tramite.apci.gob.pe</b>
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

                                    <!--<button class="btn btn-secondary" onclick="crearVentana();"><i class="fas fa-print"></i> <span>Imprimir Ficha</span></button>-->
                        <br>';
                if($nFlgRestricUp??'' === 1){
                    echo '<div style="font-family:arial;font-size:12px;color:#ff0000">
                                El archivo seleccionado "<b>';
                    echo $cNombreOriginal;
                    echo '</b>" para "Adjuntar Archivo" <br>no ha sido registrado debido a una restricción en la extensión.</div>';
                }

                echo            '</div>
                </div>';

                echo '<script>
        var ventana;
        function crearVentana() {
            ventana = window.open("registroConCluidoPrint.php?iCodTramite='.$RsUltTra['iCodTramite'].'&nCodBarra='.$nCodBarra.'&cCodificacion='.$cCodificacion.'&cPassword='.$cPassword.'&fFechaHora='.$fFechaHora.'","nuevo","width=330,height=240");
            setTimeout(cerrarVentana,6000);
        }
        function cerrarVentana(){
            ventana.close();
        }
    </script>';
            }
            else {  // genera tramite sin  codificacion, con plazo 2 dias, y derivación

                //fecha plazo
                $fechamax = date("Ymd G:i:s",strtotime($fFecActual."+ 2 days"));

                // registro en la tabla de trámite
                if ($_POST['nFlgClaseDoc']??'' == 1){ //sql con tupa
                    $sqlAdd = "SP_DOC_ENTRADA_CON_TUPA_INSERT ' ', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '".$fDoc."', '".$cNroDocumento."', '".$_POST['iCodRemitente']."', '".$cNomRemite."', '".$cAsunto."', '".$cObservaciones."', '".$_POST['iCodTupaClase']."', '".$_POST['iCodTupa']."', ' ', '".$_POST['iCodIndicacion']."', '".$nNumFolio."', '2', '0',  '".$fFecActual."', '".$nCodBarra."', '".$cPassword."','".$fechamax."','".$archivoFisico."','".$clave."'";
                } else { //sin tupa
                    $sqlAdd ="SP_DOC_ENTRADA_SIN_TUPA_INSERT ' ', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '$fDoc', '$cNroDocumento', '".$_POST['iCodRemitente']."', '$cNomRemite', '$cAsunto', '$cObservaciones', ' ', '".$_POST['iCodIndicacion']."', '$nNumFolio', '2',' 0','$fFecActual',  '$nCodBarra', '$cPassword','$fechamax','$archivoFisico','$clave'";
                }
                $rs = sqlsrv_query($cnx,$sqlAdd);

                $rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite  WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."'ORDER BY iCodTramite DESC");
                $RsUltTra = sqlsrv_fetch_array($rsUltTra);

                $rsUpTra = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET fFecPlazo = '".$fechamax."' WHERE iCodTramite = ".$RsUltTra['iCodTramite']);

                //derivacion
                $sqlMov = "SP_DOC_ENTRADA_MOVIMIENTO_INSERT '" . $RsUltTra['iCodTramite'] . "', '" . $_SESSION['CODIGO_TRABAJADOR'] . "', '" . $_SESSION['iCodOficinaLogin'] . "', '" . $_POST['iCodOficinaResponsable'] . "', '" . $_POST['iCodTrabajadorResponsable'] . "', '" . $_POST['cCodTipoDoc'] . "', '" . $_POST['iCodIndicacion'] . "', '" . $fFecActual . "',  '" . $fFecActual . "',   '" . ($_POST['nFlgEnvio']??1) . "'";
                $rsMov = sqlsrv_query($cnx, $sqlMov);

                echo '<div class="card">
                    <div class="card-header text-center ">';
                echo "Registro de entrada incompleto";
                echo '</div>
                    <div class="card-body">
                        <div id="registroBarr">
                            <table align="center" cellpadding="3" cellspacing="3" border="0">
                                <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>D-TRÁMITE</b></td></tr>
                                <tr>
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">Código QR no generado';
                echo                '</td>
                                </tr>
                                <tr>
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">';
                echo 'Documento sin numero de trámite';
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
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>d-tramite.apci.gob.pe</b>
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
                        <!--<table>
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
                        </table>-->
                        <br>';
                echo            '</div>
                </div>';

                echo '<script>
        var ventana;
        function crearVentana() {
            ventana = window.open("registroConCluidoPrint.php?iCodTramite='.$RsUltTra['iCodTramite'].'&nCodBarra='.$nCodBarra.'&cCodificacion=&cPassword='.$cPassword.'&fFechaHora='.$fFechaHora.'","nuevo","width=330,height=240");
            setTimeout(cerrarVentana,6000);
        }
        function cerrarVentana(){
            ventana.close();
        }
    </script>';
            };

            if ($_POST['nFlgClaseDoc']??'' == 1){
                // ingresar requisitos
                $iCodTupaRequisito = $_POST['iCodTupaRequisito'];
                $num=count($_POST['iCodTupaRequisito']);
                for ($h=0;$h<$num;$h++){
                    $sqlIns="SP_DOC_ENTRADA_REQ_CON_TUPA_INSERT '".$iCodTupaRequisito[$h]."','".$RsUltTra['iCodTramite']."'";
                    $rsIns = sqlsrv_query($cnx,$sqlIns);
                }
            }

            // ingresa referencias
            $sqlRefcnt="select iCodReferencia from Tra_M_Tramite_Referencias where cCodSession='".$_SESSION['cCodRef']."'";
            $rsCnT=sqlsrv_query($cnx,$sqlRefcnt);

            if (sqlsrv_has_rows($rsCnT)){
                $sqlUptRef="UPDATE Tra_M_Tramite_Referencias   SET iCodTramite = '".$RsUltTra['iCodTramite']."', cDesEstado = 'COMPLETADO'  WHERE cCodSession='".$_SESSION['cCodRef']."'";
                $rsUptr = sqlsrv_query($cnx,$sqlUptRef);
            }
            unset($_SESSION['cCodRef']);

            break;

        case 2: // anular tramite
            echo 1;
            break;

        case 3: // completar documento
            echo '<style>td,th {text-align: center!important;}</style>';
            $tramite = $_POST['iCodTramite'];
            $rsTra = sqlsrv_query($cnx,'SELECT nFlgClaseDoc, iCodTupa, cCodTipoDoc , nCodBarra, cPassword, DocumentoElectronico, codigoQR, nCud, clave FROM Tra_M_Tramite WHERE iCodTramite = '.$tramite);
            $RsTra = sqlsrv_fetch_array($rsTra);

            // fecha maxima , tiempo y requisitos si es tupa
            if ($RsTra['nFlgClaseDoc'] == 1) {
                if(isset($_POST['iCodTupaRequisito'])) {
                    $iCodTupaRequisito = $_POST['iCodTupaRequisito'];
                    $num = count($_POST['iCodTupaRequisito']);
                    for ($h = 0; $h < $num; $h++) {
                        $sqlIns = "SP_DOC_ENTRADA_REQ_CON_TUPA_INSERT '" . $iCodTupaRequisito[$h] . "','" . $tramite . "'";
                        $rsIns = sqlsrv_query($cnx, $sqlIns);
                    }
                }
                $rsTiempo = sqlsrv_query($cnx, "SELECT nDias FROM Tra_M_Tupa WHERE iCodTupa = " . $RsTra['iCodTupa']);
                $RsTiempo = sqlsrv_fetch_array($rsTiempo);
                $tRespuesta = $RsTiempo['nDias'];
            } else {
                $tRespuesta = 30;
            }
            $fechamax = date("Ymd G:i:s", strtotime($fFecActual . "+ " . $tRespuesta . " days"));

            $url_srv = $hostUpload . ':' . $port . $path;
            $curl = new CURLConnection($url_srv . $fileUpload);

            if(is_null($RsTra['DocumentoElectronico'])) {
                //Genera el correlativo
                $rsCorr = sqlsrv_query($cnx, "SELECT max(nCorrelativo)  nCorrelativo FROM Tra_M_Correlativo  WHERE nNumAno= year(GETDATE()) ");
                if (sqlsrv_has_rows($rsCorr)) {
                    $RsCorr = sqlsrv_fetch_array($rsCorr);
                    $CorrelativoAsignar = $RsCorr['nCorrelativo'] + 1;
                    $rsUpdCorr = sqlsrv_query($cnx,"UPDATE Tra_M_Correlativo SET nCorrelativo= nCorrelativo+1 WHERE nNumAno=year(GETDATE()) ");
                } else {
                    $CorrelativoAsignar = 1;
                    $rsUpdCorr = sqlsrv_query($cnx, "INSERT INTO Tra_M_Correlativo (nCorrelativo,nNumAno) VALUES ('".$CorrelativoAsignar."', year(GETDATE()) )");
                }

                // -------- codificación ---------------------------
                // INICIO DE MODIFICACION (busca la sede)
                $sqlSede = "SELECT TD.CODIGO_SEDE AS 'CODIGO_SEDE' FROM (Tra_M_Trabajadores AS TT INNER JOIN Tra_U_Departamento AS TD ON TT.CODIGO_SEDE = TD.CODIGO_SEDE)";
                $sqlSede .= "WHERE TT.iCodTrabajador = '" . $_SESSION['CODIGO_TRABAJADOR'] . "'";
                $rsSede = sqlsrv_query($cnx, $sqlSede);
                $RsSede = sqlsrv_fetch_array($rsSede);
                $codigo_sede = $RsSede['CODIGO_SEDE'];
                $year = date('Y');

                // Están pidiendo el siguiente formaro: E-sede-Año-correlativo
                $cCodificacion = add_ceros($CorrelativoAsignar, 4) . "-" . $year;
                // FIN DE MODIFICACION
                // -------- codificación ---------------------------

                //guarda documento
                $sqlTipDoc = "SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='" . $RsTra['cCodTipoDoc'] . "'";
                $rsTipDoc = sqlsrv_query($cnx, $sqlTipDoc);
                $RsTipDoc = sqlsrv_fetch_array($rsTipDoc);
                $sqlNomUsr = "SELECT cUsuario FROM Tra_M_Trabajadores WHERE iCodTrabajador='" . $_SESSION['CODIGO_TRABAJADOR'] . "'";
                $rsNomUsr = sqlsrv_query($cnx, $sqlNomUsr);
                $RsNomUsr = sqlsrv_fetch_array($rsNomUsr);

                $nomenclatura = $nNumAno . '/' . str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '/' . $nNumMes . '/' . trim($RsNomUsr['cUsuario']);

                if (isset($_FILES['fileUpLoadDigital']) && $_FILES['fileUpLoadDigital']['name'] !== '') {
                    $extension = explode('.', $_FILES['fileUpLoadDigital']['name'][0]);
                    $num = count($extension) - 1;
                    $cNombreOriginal = $_FILES['fileUpLoadDigital']['name'][0];

                    $url_f = 'docEntrada/' . $nomenclatura . '/';
                    $_FILES['fileUpLoadDigital']['tmp_name'] = $_FILES['fileUpLoadDigital']['tmp_name'][0];
                    $_FILES['fileUpLoadDigital']['name'] = $_FILES['fileUpLoadDigital']['name'][0];
                    $_FILES['fileUpLoadDigital']['type'] = $_FILES['fileUpLoadDigital']['type'][0];

                    $_POST['path'] = $url_f;
                    $_POST['name'] = 'fileUpLoadDigital';

                    if ($extension[$num] == 'jpg' || $extension[$num] == 'jpeg' || $extension[$num] == 'png' || $extension[$num] == 'pdf' || $extension[$num] == 'doc' || $extension[$num] == 'docx' || $extension[$num] == 'xls' || $extension[$num] == 'xlsx' || $extension[$num] == 'ppt' || $extension[$num] == 'pptx' ) {
                        $nFlgRestricUp = 0;
                        $nuevo_nombre = str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '-' . str_replace('/', '-', $cCodificacion) . '.' . $extension[$num];
                        $_POST['new_name'] = $nuevo_nombre;
                        $curl->uploadFile($_FILES, $_POST);

                        $url = $url_srv . $url_f . $nuevo_nombre;

                        $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $tramite . "', '" . $cNombreOriginal . "', '" . $url . "', '5')";
                        $rsDigt = sqlsrv_query($cnx, $sqlDigt);
                    } else {
                        $nFlgRestricUp = 1;
                    }
                }

                // genera el QR -------------------------------------------------------------------------
                include "phpqrcode/qrlib.php";
                $sqlClave = "SELECT clave FROM Tra_M_Tramite WHERE iCodTramite = '" . $tramite . "'";
                $rsClave = sqlsrv_query($cnx, $sqlClave);
                $RsClave = sqlsrv_fetch_array($rsClave);
                $clave = $RsClave['clave'];

                // crea temporal
                $tmp = dirname(tempnam(null, ''));
                $tmp = $tmp . "/upload/";
                if (!is_dir($tmp)) {
                    mkdir($tmp, 0777, true);
                }

                // establece direcciones temporal y de guardado
                $PNG_TEMP_DIR = $tmp;
                $PNG_WEB_DIR = $nomenclatura;

                $errorCorrectionLevel = 'L';
                $matrixPointSize = 2;

                // direccion que redirige
                $_REQUEST['data'] = $_SERVER['HTTP_HOST'] . '/views/consulta-web.php?cCodificacion=' . $cCodificacion.'&contrasena='.$clave;

                //genera nombre del qr
                $codigoQr = 'test' . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
                $filename = $PNG_TEMP_DIR . $codigoQr;
                QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

                $nuevo_nombre_QR = str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '-' . str_replace('/', '-', $cCodificacion) . '.png';

                $_FILES['fileUpLoadDigital']['tmp_name'] = $filename;
                $_FILES['fileUpLoadDigital']['name'] = $codigoQr;
                $_FILES['fileUpLoadDigital']['type'] = 'PNG';
                $_POST['new_name'] = $nuevo_nombre_QR;
                $curl->uploadFile($_FILES, $_POST);
                $urlQR = 'http://' . $url_srv . $url_f . $nuevo_nombre_QR;
                $curl->closeCurl();

                $img_final = "<img src=" . $urlQR . ">";


                $sqlTraUp = "UPDATE Tra_M_Tramite SET nCud = '" . $cCodificacion . "' , nFlgEnvio = 1, cCodificacion =  '" . $cCodificacion . "' , nTiempoRespuesta = " . $tRespuesta . " , fFecPlazo = '" . $fechamax . "' , FECHA_DOCUMENTO = '" . $fechamax . "' , documentoElectronico = '" . $url . "' , codigoQR = '" . $urlQR . "' , ARCHIVO_FISICO = '" . $_POST['archivoFisico'] . "'  WHERE iCodTramite = " . $tramite;
                $rsTraUp = sqlsrv_query($cnx, $sqlTraUp);
                $rsMovUp = sqlsrv_query($cnx, "UPDATE Tra_M_Tramite_Movimientos SET fFecDerivar = '" . $fFecActual . "' WHERE iCodTramite = " . $tramite);
            } else {
                $cCodificacion = $RsTra['nCud'];
                $clave = $RsTra['clave'];

                $urlQR = $RsTra['codigoQR'];
                $direc = explode('/',$RsTra['DocumentoElectronico']);
                $url_f = $direc[2].'/'.$direc[3].'/'.$direc[4].'/'.$direc[5].'/'.$direc[6].'/';
                $nuevo_nombre = $direc[7];

                if (isset($_FILES['fileUpLoadDigital']) && $_FILES['fileUpLoadDigital']['name'] !== '') {
                    $extension = explode('.', $_FILES['fileUpLoadDigital']['name'][0]);
                    $num = count($extension) - 1;
                    $cNombreOriginal = $_FILES['fileUpLoadDigital']['name'][0];

                    $_FILES['fileUpLoadDigital']['tmp_name'] = $_FILES['fileUpLoadDigital']['tmp_name'][0];
                    $_FILES['fileUpLoadDigital']['name'] = $_FILES['fileUpLoadDigital']['name'][0];
                    $_FILES['fileUpLoadDigital']['type'] = $_FILES['fileUpLoadDigital']['type'][0];

                    $_POST['path'] = $url_f;
                    $_POST['name'] = 'fileUpLoadDigital';

                    if ($extension[$num] == 'jpg' || $extension[$num] == 'jpeg' || $extension[$num] == 'png' || $extension[$num] == 'pdf' || $extension[$num] == 'doc' || $extension[$num] == 'docx' || $extension[$num] == 'xls' || $extension[$num] == 'xlsx' || $extension[$num] == 'ppt' || $extension[$num] == 'pptx' ) {
                        $nFlgRestricUp = 0;
                        $_POST['new_name'] = $nuevo_nombre;
                        $curl->uploadFile($_FILES, $_POST);
                    } else {
                        $nFlgRestricUp = 1;
                    }
                }
                $sqlTraUp = "UPDATE Tra_M_Tramite SET nFlgEnvio = 1, nTiempoRespuesta = " . $tRespuesta . " , fFecPlazo = '" . $fechamax . "' , FECHA_DOCUMENTO = '" . $fechamax . "' , ARCHIVO_FISICO = '" . $_POST['archivoFisico'] . "'  WHERE iCodTramite = " . $tramite;
                $rsTraUp = sqlsrv_query($cnx, $sqlTraUp);
                $rsMovUp = sqlsrv_query($cnx, "UPDATE Tra_M_Tramite_Movimientos SET fFecDerivar = '" . $fFecActual . "' WHERE iCodTramite = " . $tramite);
                $rsDigt = sqlsrv_query($cnx, "UPDATE Tra_M_Tramite_Digitales SET cNombreOriginal = '" . $cNombreOriginal . "' WHERE iCodTramite = ".$tramite);

                $img_final = "<img src=" . $urlQR . ">";
            }

            // registro concluido cuerpo
            echo '<div class="card">
            <div class="card-header text-center ">';

            if ($RsTra['nFlgClaseDoc'] == 1){
                echo "Registro de entrada con tupa";
            } else {
                echo "Registro de entrada sin tupa";
            }

            echo '</div>
              <div class="card-body">
                   <div id="registroBarr">
                        <table align="center" cellpadding="3" cellspacing="3" border="0">
                            <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>D-TRÁMITE</b></td></tr>
                            <tr>
                            <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">';
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
                                    <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>d-tramite.apci.gob.pe</b>
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
                        <!--<table>
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
                        </table>-->
                        <br>';
            if($nFlgRestricUp === 1){
                echo '<div style="font-family:arial;font-size:12px;color:#ff0000">
                                El archivo seleccionado "<b>';
                echo $cNombreOriginal;
                echo '</b>" para "Adjuntar Archivo" <br>no ha sido registrado debido a una restricción en la extensión.</div>';
            }

            echo            '</div>
                </div>';

            echo '<script>
        var ventana;
        function crearVentana() {
            ventana = window.open("registroConCluidoPrint.php?iCodTramite='.$tramite.'&nCodBarra='.$RsTra['nCodBarra'].'&cCodificacion='.$cCodificacion.'&cPassword='.$RsTra['cPassword'].'&fFechaHora='.$date->format("Y-m-d H:i:s").'","nuevo","width=330,height=240");
            setTimeout(cerrarVentana,6000);
        }
        function cerrarVentana(){
            ventana.close();
        }
    </script>';
            break;
    }

}else{
    header("Location: ../../index-b.php?alter=5");
}

?>