<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
    include_once("../conexion/conexion.php");
    ///////////////////////////////////////////////
    //PARA LCP
    $fFecActual = date("Ymd")." ".date("H:i:s");
    //PARA PRO INVERSION
    //$fFecActual = date("Ydm")." ".date("H:i:s");
    ///////////////////////////////////////////////
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

    switch ($_POST['opcion']){
        case 1: // Envio para Corrección del documento
            try {
                for ($h = 0; $h < count($_POST['iCodMovimiento']); $h++) {
                    $iCodMovimiento = $_POST['iCodMovimiento'][0];
                    $sqlMov = " SELECT iCodProyecto, iCodOficinaOrigen, iCodTrabajadorRegistro, cCodTipoDocDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = " . $iCodMovimiento;
                    $rsMov = sqlsrv_query($cnx, $sqlMov);
                    $RsMov = sqlsrv_fetch_array($rsMov);

                    $sqlTra = " SELECT cAsunto FROM Tra_M_Proyecto WHERE iCodProyecto = ".$RsMov['iCodProyecto'];
                    $rsTra = sqlsrv_query($cnx,$sqlTra);
                    $RsTra = sqlsrv_fetch_array($rsTra);

                    // ingresa nuevo movimiento
                    $sqlAdMv = "INSERT INTO Tra_M_Tramite_Movimientos (iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen, iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,fFecMovimiento,nEstadoMovimiento,cFlgTipoMovimiento,paraAprobar,iCodProyecto)";
                    $sqlAdMv .= " VALUES ";
                    $sqlAdMv .= "('" . $_SESSION['CODIGO_TRABAJADOR'] . "',1,'" . $_SESSION['iCodOficinaLogin'] . "','" . $RsMov['iCodOficinaOrigen'] . "', '" . $RsMov['iCodTrabajadorRegistro'] . "','".$RsMov['cCodTipoDocDerivar']."',19,'Media','" . str_replace('\"', '"',$RsTra['cAsunto']) . "', '" . $_POST['comentario'] . "','$fFecActual','$fFecActual',1,1,1,'".$RsMov['iCodProyecto']."' )";
                    $rsAdMv = sqlsrv_query($cnx, $sqlAdMv);

                    // cambiar de estado al movimiento anterior
                    $sqlMov = "UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=6 WHERE iCodMovimiento='$iCodMovimiento'";
                    $rsUpdMov = sqlsrv_query($cnx, $sqlMov);

                    // cambiar estado de tramite
                    $sqlUpdTra = " UPDATE Tra_M_Proyecto SET nFlgEstado = 2 WHERE iCodProyecto = ".$RsMov['iCodProyecto'];
                    $rsUpdTra = sqlsrv_query($cnx,$sqlUpdTra);

                }
                echo json_encode(1);
            } catch (Exception $e) {
                echo json_encode($e);
            }
            break;
        case 2: // Envio documento corregido
            try {
                for ($h = 0; $h < count($_POST['iCodMovimiento']); $h++) {
                    $iCodMovimiento = $_POST['iCodMovimiento'][0];
                    $sqlMov = " SELECT iCodProyecto, iCodOficinaOrigen, iCodTrabajadorRegistro, cCodTipoDocDerivar, cObservacionesDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = " . $iCodMovimiento;
                    $rsMov = sqlsrv_query($cnx, $sqlMov);
                    $RsMov = sqlsrv_fetch_array($rsMov);

                    $sqlTra = " SELECT cAsunto FROM Tra_M_Proyecto WHERE iCodProyecto = ".$RsMov['iCodProyecto'];
                    $rsTra = sqlsrv_query($cnx,$sqlTra);
                    $RsTra = sqlsrv_fetch_array($rsTra);

                    // ingresa nuevo movimiento
                    $sqlAdMv = "INSERT INTO Tra_M_Tramite_Movimientos (iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen, iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,fFecMovimiento,nEstadoMovimiento,cFlgTipoMovimiento,paraAprobar,iCodProyecto)";
                    $sqlAdMv .= " VALUES ";
                    $sqlAdMv .= "('" . $_SESSION['CODIGO_TRABAJADOR'] . "',1,'" . $_SESSION['iCodOficinaLogin'] . "','" . $RsMov['iCodOficinaOrigen'] . "', '" . $RsMov['iCodTrabajadorRegistro'] . "','".$RsMov['cCodTipoDocDerivar']."',19,'Media','" . str_replace('\"', '"',$RsTra['cAsunto']) . "', ' ','$fFecActual','$fFecActual',1,1,1,'".$RsMov['iCodProyecto']."' )";
                    $rsAdMv = sqlsrv_query($cnx, $sqlAdMv);

                    // cambiar de estado al movimiento anterior
                    $sqlMov = "UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento=6 WHERE iCodMovimiento='$iCodMovimiento'";
                    $rsUpdMov = sqlsrv_query($cnx, $sqlMov);

                    // cambiar estado de tramite
                    $sqlUpdTra = " UPDATE Tra_M_Proyecto SET nFlgEstado = 2 WHERE iCodProyecto = ".$RsMov['iCodProyecto'];
                    $rsUpdTra = sqlsrv_query($cnx,$sqlUpdTra);
                }
                echo json_encode(1);
            } catch (Exception $e) {
                echo json_encode($e);
            }
            break;
        case 3: //prueba
            echo json_encode(1);
            break;
    }

}else{
    header("Location: ../index-b.php?alter=5");
}
?>