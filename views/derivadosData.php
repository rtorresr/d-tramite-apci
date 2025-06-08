<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
    include_once("../conexion/conexion.php");

    $fFecActual = date("Ymd")." ".date("H:i:s");
    $rutaUpload = "../cAlmacenArchivos/";
    $nNumAno    = date("Y");

    function add_ceros($numero,$ceros){
        $order_diez = explode(".",$numero);
        $dif_diez = $ceros - strlen($order_diez[0]);
        $insertar_ceros = '';
        for($m=0; $m<$dif_diez; $m++){
            $insertar_ceros .= 0;
        }
        $insertar_ceros.= $numero;
        return $insertar_ceros;
    }

    $sqlUsr = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
    $rsUsr  = sqlsrv_query($cnx,$sqlUsr);
    $RsUsr  = sqlsrv_fetch_array($rsUsr);

    switch ($_POST['opcion']) {
        case 1: // cancelar derivacion
            try {
                for ($h = 0; $h < count($_POST['iCodMovimiento']); $h++) {
                    $iCodMovimiento = $_POST['iCodMovimiento'][$h];
                    $sqlMov = " SELECT iCodTramite, iCodOficinaDerivar, iCodTrabajadorDerivar, cCodTipoDocDerivar, iCodIndicacionDerivar,cPrioridadDerivar,cAsuntoDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = " . $iCodMovimiento;
                    $rsMov = sqlsrv_query($cnx, $sqlMov);
                    $RsMov = sqlsrv_fetch_array($rsMov);

                    /*$sqlAdMv = "INSERT INTO Tra_M_Tramite_Movimientos (iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen, iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,fFecMovimiento,nEstadoMovimiento,cFlgTipoMovimiento,)";
                    $sqlAdMv .= " VALUES ";
                    $sqlAdMv .= "('" . $RsMov['iCodTramite'] . "','" .  $RsMov['iCodTrabajadorRegistro'] . "',1,'" . $RsMov['iCodTrabajadorRegistro'] . "','" . $RsMov['iCodOficinaOrigen'] . "', '" . $RsMov['iCodTrabajadorRegistro'] . "','".$RsMov['cCodTipoDocDerivar']."',19,'Media','" . str_replace('\"', '"',$RsTra['cAsunto']) . "', '" . $_POST['motRechazo'] . "','$fFecActual','$fFecActual',1,1)";
                    $rsAdMv = sqlsrv_query($cnx, $sqlAdMv);*/

                    // BUSCAR penultipo mov
                    /*$rsBus = sqlsrv_query($cnx,"SELECT iCodMovimiento FROM ( SELECT row_number() OVER (ORDER BY iCodMovimiento DESC) numrow, iCodMovimiento FROM Tra_M_Tramite_Movimientos WHERE iCodTramite = ".$RsMov['iCodTramite']." ) AS SUBDATA WHERE numrow = 2");
                    print_r($rsBus);
                    $RsBus = sqlsrv_fetch_array($rsBus);*/

                    // insertar movimiento
                    $sqlMov = "INSERT INTO Tra_M_Tramite_Movimientos (iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen, iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cAsuntoDerivar,fFecDerivar,fFecMovimiento,cFlgTipoMovimiento,nEstadoMovimiento,cObservacionesDerivar)" ;
                    $sqlMov.= " VALUES('".$RsMov['iCodTramite']."', '".$RsMov['iCodTrabajadorDerivar']."', '1', '".$RsMov['iCodOficinaDerivar']."', '".$_SESSION['iCodOficinaLogin']."', '".$_SESSION['CODIGO_TRABAJADOR']."', '".$RsMov['cCodTipoDocDerivar']."', '".$RsMov['iCodIndicacionDerivar']."', '".$RsMov['cPrioridadDerivar']."', '".$RsMov['cAsuntoDerivar']."', '".$fFecActual."', '".$fFecActual."', '1', '1', '".$_POST['motCancelacion']."')";
                    /*$sqlMov .= "(SELECT iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen, iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cAsuntoDerivar,fFecDerivar,cFlgTipoMovimiento
                                FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$RsBus['iCodMovimiento'].")";*/

                    $rsMov = sqlsrv_query($cnx,$sqlMov);

                    /*$rsUltMov = sqlsrv_query($cnx, "SELECT TOP (1) iCodMovimiento FROM  Tra_M_Tramite_Movimientos ORDER BY iCodMovimiento DESC");
                    $RsUltMov = sqlsrv_fetch_array($rsUltMov);*/

                    /*$qslUpUlMov = "UPDATE Tra_M_Tramite_Movimientos SET fFecMovimiento = '".$fFecActual."' , fFecRecepcion = '".$fFecActual."' , nEstadoMovimiento = 1 , cObservacionesDerivar = '".$_POST['motCancelacion']."' WHERE iCodMovimiento = ".$RsUltMov['iCodMovimiento'];
                    $rsUpUlMov = sqlsrv_query($cnx,$qslUpUlMov);*/

                    // cambiar de estado al movimiento anterior
                    $sqlMov = "UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=7 WHERE iCodMovimiento='$iCodMovimiento'";
                    $rsUpdMov = sqlsrv_query($cnx, $sqlMov);

                    // cambiar estado de tramite
                    $sqlUpdTra = " UPDATE Tra_M_Tramite SET nFlgEstado = 2, nFlgEnvio = 1 WHERE iCodTramite = ".$RsMov['iCodTramite'];
                    $rsUpdTra = sqlsrv_query($cnx,$sqlUpdTra);

                }
                echo json_encode(1);
            } catch (Exception $e) {
                echo json_encode($e);
            }
            break;

    }
}else{
    header("Location: ../index-b.php?alter=5");
}
?>