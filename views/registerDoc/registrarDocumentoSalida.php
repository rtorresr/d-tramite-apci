<?php
/**
 * Created by PhpStorm.
 * User: anthonywainer
 * Date: 26/11/2018
 * Time: 15:57
 */

include_once("../../conexion/conexion.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../../core/CURLConection.php");

session_start();
date_default_timezone_set('America/Lima');
//print_r($_REQUEST); exit();

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    $fFecActual = date('Ymd').' '.date('G:i:s');

    $nNumAno    = date('Y');
    $nNumMes    = date('M');

    function add_ceros($numero,$ceros) {
        $insertar_ceros = 0;
        $order_diez = explode('.',$numero);
        $dif_diez = $ceros - strlen($order_diez[0]);
        for($m=0; $m<$dif_diez; $m++){
            $insertar_ceros .= 0;
        }
        return $insertar_ceros.= $numero;
    }

    // agrega referencias a tabla referencias sin cod de tramite
    if(isset($_POST['cReferencia'])){
        for ($i = 0; $i < count($_POST['cReferencia']); $i++){
            $ref = $_POST['cReferencia'][$i];
            $rsCref = sqlsrv_query($cnx, "SELECT cCodificacion  FROM Tra_M_Tramite WHERE iCodTramite = ".$ref);
            $RsCref = sqlsrv_fetch_array($rsCref);

            $sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
            $sqlAdd.="(iCodTramiteRef,  cReferencia,          cCodSession, cDesEstado, iCodTipo,identificador)";
            $sqlAdd.=" VALUES ";
            $sqlAdd.="('".$ref."','".$RsCref['cCodificacion']."', '".$_SESSION['cCodRef']."', 'PENDIENTE', 1,' ')";
            $rs=sqlsrv_query($cnx,$sqlAdd);
        }
    }

    $fecPlazoInicial = $_POST['fFecPlazo']??'';
    if ($fecPlazoInicial !== ''){
        $separado2 = explode('-',$_POST['fFecPlazo']??'');
        if  ($separado2!='') $fFecPlazo = "'".$separado2[2].$separado2[1].$separado2[0]."'";
    } else {
        $fFecPlazo='null';
    }
    // comprobar o recoger correlativo
    $sqlCorr = "SELECT * FROM Tra_M_Correlativo_Salida WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."' AND iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nNumAno='".$nNumAno."'";
    $rsCorr  = sqlsrv_query($cnx,$sqlCorr);

    if (sqlsrv_has_rows($rsCorr)){
        $RsCorr = sqlsrv_fetch_array($rsCorr);
        $nCorrelativo = $RsCorr['nCorrelativo']+1;

        $sqlUpd = "UPDATE Tra_M_Correlativo_Salida SET nCorrelativo='".$nCorrelativo."' WHERE iCodCorrelativo='".$RsCorr['iCodCorrelativo']."'";
        $rsUpd  = sqlsrv_query($cnx,$sqlUpd);
    } else {
        $sqlAdCorr = "INSERT INTO Tra_M_Correlativo_Salida (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('".$_POST['cCodTipoDoc']."', '".$_SESSION['iCodOficinaLogin']."', '".$nNumAno."',1)";
        $rsAdCorr  = sqlsrv_query($cnx,$sqlAdCorr);
        $nCorrelativo = 1;
    }

    // leer sigla oficina
    $rsSigla = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'");
    $RsSigla = sqlsrv_fetch_array($rsSigla);

    // armar correlativo
    $cCodificacion = add_ceros($nCorrelativo,5).'-'.date('Y').'/SITDD/'.trim($RsSigla['cSiglaOficina']);

    // Jefe de Oficina
    $rsJefe = sqlsrv_query($cnx,"SELECT iCodTrabajador FROM Tra_M_Trabajadores  WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nFlgEstado = 1  AND iCodCategoria = '5' ");
    $RsJefe = sqlsrv_fetch_array($rsJefe);

    //  Sql es ejecutado en SP
    // Por defecto este SP coloca el valor de nFlgEnvio en 0 (internamente) indicando que no está aprobado todavía.
    if($_POST['iCodRemitente']==-1) {
        $irm = 'null';
    }else{
        $irm = $_POST['iCodRemitente'];
    }
    $nfl = $_POST['nFlgRpta']??'null';
    $sqlAdd=" SP_DOC_SALIDA_INSERT '".$cCodificacion."',	'".$_SESSION['CODIGO_TRABAJADOR']."', '".$_SESSION['iCodOficinaLogin']."', '".$_POST['cCodTipoDoc']."', '".$fFecActual."', '".$RsJefe['iCodTrabajador']."', '".($_POST['cReferencia']??'')."', '".$_POST['cAsunto']."', '".$_POST['cObservaciones']."', ".$nfl.", '".$_POST['nNumFolio']."', ".$fFecPlazo.", '".($_POST['cSiglaAutor']??'')."', '".$fFecActual."', ".$irm.",'".$_POST['cNomRemite']."','".str_replace( '\"', '"', $_POST['editor'] )."','".$_POST['archivoFisico']."' ";
    $rs = sqlsrv_query($cnx,$sqlAdd);

    //Ultimo registro de tramite
    $rsUltTra = sqlsrv_query($cnx,"SELECT TOP 1 iCodTramite FROM Tra_M_Tramite  WHERE iCodTrabajadorRegistro ='".$_SESSION['CODIGO_TRABAJADOR']."' ORDER BY iCodTramite DESC");
    $RsUltTra = sqlsrv_fetch_array($rsUltTra);
    $nuevoCodigoTramite = $RsUltTra['iCodTramite'];

    if ($_POST['iCodRemitente']>0){
        //  Sql es ejecutado en SP
        $sqlAddCargo=" SP_DOC_SALIDA_MULTIPLE_INSERT '".$RsUltTra['iCodTramite']."' ,'".$cCodificacion."','".$_POST['iCodRemitente']."', ".$_SESSION['iCodOficinaLogin'].", '".$_POST['cAsunto']."', '".$_SESSION['CODIGO_TRABAJADOR']."' , '".$_POST['txtdirec_remitente']."',		'".$_POST['cCodDepartamento']."',	'".$_POST['cCodProvincia']."',	 '".$_POST['cCodDistrito']."', '".$_POST['cNomRemite']."' ";
        $rsAddCargo = sqlsrv_query($cnx,$sqlAddCargo);
    }

    $sqlAdMv = "INSERT INTO Tra_M_Tramite_Movimientos ";
    $sqlAdMv.="(iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodIndicacionDerivar,cAsuntoDerivar, cObservacionesDerivar,fFecDerivar,fFecMovimiento,nEstadoMovimiento,nFlgEnvio,cFlgTipoMovimiento)";
    $sqlAdMv.=" VALUES ";
    $sqlAdMv.="('".$RsUltTra['iCodTramite']."','".$_SESSION['CODIGO_TRABAJADOR']."',2,'".$_SESSION['iCodOficinaLogin']."',null,3,'".$_POST['cAsunto']."','".$_POST['cObservaciones']."','".$fFecActual."','".$fFecActual."',1,1,1)";
    $rsAdMv = sqlsrv_query($cnx,$sqlAdMv);

    $sqlMv = "SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='".$_SESSION['iCodOficinaLogin']."' ORDER BY iCodTemp ASC";
    $rsMv=sqlsrv_query($cnx,$sqlMv);
    while ($RsMv=sqlsrv_fetch_array($rsMv)){
        $sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos ";
        $sqlAdMv.="(iCodTramite, iCodTrabajadorRegistro, nFlgTipoDoc, iCodOficinaOrigen, iCodOficinaDerivar, iCodTrabajadorDerivar, iCodIndicacionDerivar, cPrioridadDerivar, cAsuntoDerivar, cObservacionesDerivar, fFecDerivar, fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento, cFlgOficina)";
        $sqlAdMv.=" VALUES ";
        $sqlAdMv.="('".$RsUltTra['iCodTramite']."', '".$_SESSION['CODIGO_TRABAJADOR']."', 3,'".$_SESSION['iCodOficinaLogin']."', '".$RsMv['iCodOficina']."', '".$RsMv['iCodTrabajador']."', '".$RsMv['iCodIndicacion']."', '".$RsMv['cPrioridad']."', '".$_POST['cAsunto']."', '".$_POST['cObservaciones']."', '".$fFecActual."', '".$fFecActual."',1,4,1)";
        $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
    }

    $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."'";
    $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
    $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);

    if (isset($_SESSION['cCodRef'])) {
        // relacion por ferencias
        $sqlRefs = "SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='" . $_SESSION['cCodRef'] . "'";
        $rsRefs = sqlsrv_query($cnx, $sqlRefs);
        if (sqlsrv_has_rows($rsRefs)) {
            while ($RsRefs = sqlsrv_fetch_array($rsRefs)) {
                $sqlBusRef = "SELECT * FROM Tra_M_Tramite WHERE cCodificacion='" . $RsRefs['cReferencia'] . "'";
                $rsBusRef = sqlsrv_query($cnx, $sqlBusRef);
                if (sqlsrv_has_rows($rsBusRef)) {
                    $RsBusRef = sqlsrv_fetch_array($rsBusRef);
                    if ($RsBusRef['nFlgTipoDoc'] === 1) {
                        $sqlMv2 = "SELECT TOP 1 * FROM Tra_M_Tramite_Temporal WHERE cCodSession='" . $_SESSION['cCodOfi'] . "'";
                        $rsMv2 = sqlsrv_query($cnx, $sqlMv2);
                        $RsMv2 = sqlsrv_fetch_array($rsMv2);
                        //  Sql es ejecutado en SP
                        //  El SP esta desarrollado pero no se ha hecho el reemplazo en las lineas de abajo porque no se sabe como probrar
                        //  $sqlAdRf.="SP_DOC_ENTRADA_MOV_INTERNO_REF_INSERT '$RsBusRef[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     '".$_SESSION['iCodOficinaLogin']."', '$_POST[cCodTipoDoc]',  '$RsMv2['iCodOficina']', '$RsMv2[iCodTrabajador]', '$RsMv2[iCodIndicacion]', '$RsMv2[cPrioridad]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$fFecActual', '$cCodificacion',  '$fFecActual'  )";

                        $sqlAdRf = "INSERT INTO Tra_M_Tramite_Movimientos ";
                        $sqlAdRf .= "(iCodTramite,iCodTrabajadorRegistro, nFlgTipoDoc, iCodOficinaOrigen, cCodTipoDocDerivar, iCodOficinaDerivar, iCodTrabajadorDerivar, iCodIndicacionDerivar, cPrioridadDerivar, cAsuntoDerivar, cObservacionesDerivar, fFecDerivar, cReferenciaDerivar,fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,iCodTramiteDerivar)";
                        $sqlAdRf .= " VALUES ";
                        $sqlAdRf .= "('" . $RsBusRef['iCodTramite'] . "', '" . $_SESSION['CODIGO_TRABAJADOR'] . "', 2,'" . $_SESSION['iCodOficinaLogin'] . "', '" . $_POST['cCodTipoDoc'] . "',  '" . $RsMv2['iCodOficina'] . "', '" . $RsMv2['iCodTrabajador'] . "', '" . $RsMv2['iCodIndicacion'] . "', '" . $RsMv2['cPrioridad'] . "', '" . $_POST['cAsunto'] . "', '" . $_POST['cObservaciones'] . "', '" . $fFecActual . "', '" . $cCodificacion . "',  '" . $fFecActual . "', 1,5,'" . $RsUltTra['iCodTramite'] . "')";
                        $rsAdRf = sqlsrv_query($cnx, $sqlAdRf);
                    }
                }
                $sqlUpdR = "UPDATE Tra_M_Tramite_Referencias SET iCodTramite='" . $RsUltTra['iCodTramite'] . "', cDesEstado='REGISTRADO' WHERE iCodReferencia='" . $RsRefs['iCodReferencia'] . "'";
                $rsUpdR = sqlsrv_query($cnx, $sqlUpdR);
            }
        }
    }
    //echo $_POST['codJefe'];
    if ($_POST['codJefe']??'' !== '') {
        $iCodJefe 		 = $_POST['codJefe'];
        echo $iCodJefe;
        $sqlTrabajador = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$iCodJefe;
        $rsTrabajador  = sqlsrv_query($cnx,$sqlTrabajador);
        $RsTrabajador  = sqlsrv_fetch_array($rsTrabajador);
        $cNomJefe = trim($RsTrabajador['cNombresTrabajador']).' '.trim($RsTrabajador['cApellidosTrabajador']);
    }

    if ($_POST['esJefe']??'' === 1) {
        $iCodTramite = $nuevoCodigoTramite;
        $fechaDeAprobacion = date("Ymd")." ".date("G:i:s");
        $sqlUpdate = "UPDATE Tra_M_Tramite SET nFlgEnvio = 1, FECHA_DOCUMENTO = getdate(), iCodJefe = '".$iCodJefe."', cNomJefe = '".$cNomJefe."' WHERE iCodTramite = ".$iCodTramite;
        $rsUpdate = sqlsrv_query($cnx,$sqlUpdate);
    }
    // -------------------------------------------------------
    // Derivar inmediatamente: correo instantaneo
    // -------------------------------------------------------
    $idtramitenew=$nuevoCodigoTramite;
    $opc=2; // pro aprobar
    //include 'email.php';
    // -------------------------------------------------------

    $fFecActual=date('d-m-Y G:i');

//leer user Trabajador
    $sqlNomUsr = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='" . $_SESSION['CODIGO_TRABAJADOR'] . "'";
    $rsNomUsr = sqlsrv_query($cnx, $sqlNomUsr);
    $RsNomUsr = sqlsrv_fetch_array($rsNomUsr);

//Siglas del Trabajador
    $siglaN = explode(' ', trim($RsNomUsr['cNombresTrabajador']));
    $countSiglaN = count($siglaN);
    $nx = '';
    $n= [];
    for ($i = 0; $i < $countSiglaN; $i++) {
        $n[$i] = $siglaN[$i];
        if ($n[$i] != '') {
            $nx = $nx . $n[$i][0];
        }
    }
    $siglaP = explode(' ', $RsNomUsr['cApellidosTrabajador']);
    $countSiglaP = count($siglaP);
    $ny = '';
    for ($i = 0; $i < $countSiglaP; $i++) {
        $m[$i] = $siglaP[$i];
        if ($m[$i] != '') {
            $ny = $ny . $m[$i][0];
        }
    }
    $sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."'";
    $rsTipDoc = sqlsrv_query($cnx,$sqlTipDoc);
    $RsTipDoc = sqlsrv_fetch_array($rsTipDoc);
// armar correlativo
    //.'-'.strtoupper(trim($nx.$ny));
    $nomenclatura = str_replace('/', '-', trim($RsSigla['cSiglaOficina'])) . '/' . $nNumAno . '/' . str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '/' . $nNumMes . '/' . trim($RsNomUsr['cUsuario']);
    $url_srv = $hostUpload . ':' . $port . $path;

    $curl = new CURLConnection($url_srv . $fileUpload);

    if (isset($_FILES['fileUpLoadDigital']) && $_FILES['fileUpLoadDigital']['name'] !== '') {
        $extension = explode('.', $_FILES['fileUpLoadDigital']['name'][0]);
        $num = count($extension) - 1;

        $cNombreOriginal = $_FILES['fileUpLoadDigital']['name'][0];


        $url_f = 'docFirmados/' . $nomenclatura . '/';
        $_FILES['fileUpLoadDigital']['tmp_name'] = $_FILES['fileUpLoadDigital']['tmp_name'][0];
        $_FILES['fileUpLoadDigital']['name'] = $_FILES['fileUpLoadDigital']['name'][0];
        $_FILES['fileUpLoadDigital']['type'] = $_FILES['fileUpLoadDigital']['type'][0];

        $_POST['path'] = $url_f;
        $_POST['name'] = 'fileUpLoadDigital';

        if ($extension[$num] === 'pdf') { //|| $extension[$num]==='dll' || $extension[$num]=== 'EXE' || $extension[$num]==='DLL'){
            //$nFlgRestricUp=1;
            //}else{
            $nuevo_nombre = str_replace(' ', '-', trim($RsTipDoc['cDescTipoDoc'])) . '-' . str_replace('/', '-', $cCodificacion) . '-anexos' . '.' . $extension[$num];
            $_POST['new_name'] = $nuevo_nombre;

            $curl->uploadFile($_FILES, $_POST);
            //$sftp->uploadFile($_FILES['fileUpLoadDigital']['tmp_name'][0], $path.'/'.$nuevo_nombre);
            //$url =  str_replace('opt/stdd/files//','files/',$host.':'.$port_ngnix.$path.'/'.$nuevo_nombre);

            $url = $url_srv . $url_f . $nuevo_nombre;

            $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $RsUltTra['iCodTramite'] . "', '" . $cNombreOriginal . "', '" . $url . "', '3')";
            $rsDigt = sqlsrv_query($cnx, $sqlDigt);
        }
    }
    unset($_SESSION['cCodRef']);
    unset($_SESSION['cCodOfi']);

   include("../documento_pdf.php");

    // $url =  str_replace('opt/stdd/files//','files/',$host.':'.$port_ngnix.$path.'/'.$nuevo_nombre);
    $idtra = $RsUltTra['iCodTramite'];
    $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $RsUltTra['iCodTramite'] . "', '', '" . $url . "', '2')";
    $rsDigt = sqlsrv_query($cnx, $sqlDigt);

    $arr = array(
        'url' => $url,
        'tra' => $idtra
    );
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    echo json_encode($arr);



}else{
    header("Location: ../../index-b.php?alter=5");
}
