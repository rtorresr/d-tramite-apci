<?php
include_once "../../conexion/conexion.php";
session_start();

switch ($_POST['evento']){
    case 'porRecibir':
        $params = [
            $_SESSION['IdSesion']
        ];

        $sql = "{call UP_PRESTAMO_DETALLE_POR_RECIBIR (?)}";

        $rs = sqlsrv_query($cnx,$sql,$params);

        if($rs === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $data = array();
        $contador = 0;
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $subdata=array();
            $subdata['rowId'] = $contador;
            $subdata['IdDetallePrestamo'] = $Rs['IdDetallePrestamo'];
            $subdata['oficinaDestino'] = $Rs['oficinaDestino'];
            $subdata['documento'] = $Rs['documento'];
            $subdata['servicio'] = $Rs['servicio'];
            $subdata['FecNotificacionEntrega'] = $Rs['FecNotificacionEntrega'] != null ? $Rs['FecNotificacionEntrega']->format( 'Y-m-d H:i:s') : '';
            $subdata['CantidadNotificaciones'] = $Rs['CantidadNotificaciones'];
            $subdata['UltimaFecNotificacion'] = $Rs['UltimaFecNotificacion'] != null ? $Rs['UltimaFecNotificacion']->format( 'Y-m-d H:i:s') : '';
            $subdata['idSolicitudPrestamo'] = $Rs['idSolicitudPrestamo'];
            $data[]=$subdata;
            $contador++;
        }

        $VO_TOTREG = 0;
        while($res = sqlsrv_next_result($rs)){
            if( $res ) {
                while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                    $VO_TOTREG = $row['VO_TOTREG'];
                }
            } elseif ( is_null($res)) {
                echo "No se obtener datos!";
                return;
            } else {
                die(print_r(sqlsrv_errors(), true));
            }
        }

        $recordsTotal = $VO_TOTREG;
        $recordsFiltered = $VO_TOTREG;
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $data
        );

        echo json_encode($json_data);
        break;

    case 'porDevolver':
        $params = [
            $_SESSION['IdSesion']
        ];

        $sql = "{call UP_PRESTAMO_DETALLE_POR_DEVOLVER (?)}";

        $rs = sqlsrv_query($cnx,$sql,$params);

        if($rs === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $data = array();
        $contador = 0;
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $subdata=array();
            $subdata['rowId'] = $contador;
            $subdata['IdDetallePrestamo'] = $Rs['IdDetallePrestamo'];
            $subdata['oficinaDestino'] = $Rs['oficinaDestino'];
            $subdata['documento'] = $Rs['documento'];
            $subdata['servicio'] = $Rs['servicio'];
            $subdata['fechaRecepcion'] = $Rs['FecRecibido'] != null ? $Rs['FecRecibido']->format( 'Y-m-d H:i:s') : '';
            $subdata['cantidadAmpliaciones'] = $Rs['CantAmpliacionesPlazo'];
            $subdata['fechaPlazo'] = $Rs['FecPlazoDevolucion'] != null ? $Rs['FecPlazoDevolucion']->format( 'Y-m-d H:i:s') : '';
            $subdata['flgFueraPlazo'] = $Rs['FlgFueraPlazo'];
            $subdata['flgDocDigitalOfrecido'] = $Rs['FlgDocDigitalOfrecido'];
            $subdata['idDocDigital'] = $Rs['IdDocDigital'];
            $subdata['flgSolicitudAmpliacionPlaza'] = $Rs['FlgSolicitudAmpliacionPlaza'];
            $subdata['observacion'] = $Rs['Observacion'];
            $subdata['idSolicitudPrestamo'] = $Rs['IdSolicitudPrestamo'];
            $data[]=$subdata;
            $contador++;
        }

        $VO_TOTREG = 0;
        while($res = sqlsrv_next_result($rs)){
            if( $res ) {
                while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                    $VO_TOTREG = $row['VO_TOTREG'];
                }
            } elseif ( is_null($res)) {
                echo "No se obtener datos!";
                return;
            } else {
                die(print_r(sqlsrv_errors(), true));
            }
        }

        $recordsTotal = $VO_TOTREG;
        $recordsFiltered = $VO_TOTREG;
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $data
        );

        echo json_encode($json_data);
        break;
    default:
        break;
}

