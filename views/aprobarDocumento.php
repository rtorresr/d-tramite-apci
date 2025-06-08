<?php
    if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){

        include_once('../conexion/conexion.php');

        $obs = $_POST['observaciones']??'';

        $sqlMov = 'SELECT iCodMovimiento,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cAsuntoDerivar,cObservacionesDerivar,cPrioridadDerivar,fFecMovimiento,nEstadoMovimiento,cFlgTipoMovimiento,cFlgOficina,iCodTramiteRespuesta,paraAprobar,paraFirmar,paraVistar,iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = 588';
        $rsMov = sqlsrv_query($cnx,$sqlMov);
        $RsMov  = sqlsrv_fetch_array($rsMov);

        if($obs !== ''){
            $sqlAprobacion = 'INSERT INTO Tra_M_Tramite_Movimientos (iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cAsuntoDerivar,cObservacionesDerivar,cPrioridadDerivar,fFecMovimiento,nEstadoMovimiento,cFlgTipoMovimiento,cFlgOficina,iCodTramiteRespuesta,paraAprobar,paraFirmar,paraVistar,iCodProyecto) ';
            $sqlAprobacion .= "VALUES ('".$RsMov['iCodTrabajadorDerivar']."','".$RsMov['nFlgTipoDoc']."','".$RsMov['iCodOficinaDerivar']."','".$RsMov['iCodOficinaOrigen']."','".$RsMov['iCodTrabajadorRegistro']."','".$RsMov['cCodTipoDocDerivar']."','".$RsMov['iCodIndicacionDerivar']."','".$RsMov['cAsuntoDerivar']."','".$obs."','".$RsMov['cPrioridadDerivar']."','".date('Y-m-d h:i:s')."','".$RsMov['nEstadoMovimiento']."','".$RsMov['cFlgTipoMovimiento']."','".$RsMov['cFlgOficina']."','".$RsMov['iCodTramiteRespuesta']."',1,0,0,'".$RsMov['iCodProyecto']."')";
            $rsAprobacion = sqlsrv_query($cnx,$sqlAprobacion);
            $RsAprobacion = sqlsrv_fetch_array($rsAprobacion);

            $sqlActualizar = "UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento = 4 WHERE iCodMovimiento = ".$RsMov['iCodMovimiento'];
            $rsActualizar = sqlsrv_query($cnx,$sqlActualizar);
            $RsActualizar = sqlsrv_fetch_array($rsActualizar);

        }else{
            $sqlAprobacion = 'INSERT INTO Tra_M_Tramite_Movimientos (iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,iCodIndicacionDerivar,cAsuntoDerivar,cObservacionesDerivar,cPrioridadDerivar,fFecMovimiento,nEstadoMovimiento,cFlgTipoMovimiento,cFlgOficina,iCodTramiteRespuesta,paraAprobar,paraFirmar,paraVistar,iCodProyecto) ';
            $sqlAprobacion .= "VALUES ('".$RsMov['iCodTrabajadorDerivar']."','".$RsMov['nFlgTipoDoc']."','".$RsMov['iCodOficinaDerivar']."','".$RsMov['iCodOficinaOrigen']."','".$RsMov['iCodTrabajadorRegistro']."','".$RsMov['cCodTipoDocDerivar']."','".$RsMov['iCodIndicacionDerivar']."','".$RsMov['cAsuntoDerivar']."','','".$RsMov['cPrioridadDerivar']."','".date('Y-m-d h:i:s')."','".$RsMov['nEstadoMovimiento']."','".$RsMov['cFlgTipoMovimiento']."','".$RsMov['cFlgOficina']."','".$RsMov['iCodTramiteRespuesta']."',1,0,1,'".$RsMov['iCodProyecto']."')";
            $rsAprobacion = sqlsrv_query($cnx,$sqlAprobacion);
            $RsAprobacion = sqlsrv_fetch_array($rsAprobacion);

            $sqlActualizar = "UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento = 4 WHERE iCodMovimiento = ".$RsMov['iCodMovimiento'];
            $rsActualizar = sqlsrv_query($cnx,$sqlActualizar);
            $RsActualizar = sqlsrv_fetch_array($rsActualizar);
        }


    }
?>
