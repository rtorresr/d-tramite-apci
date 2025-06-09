<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
 
include_once "../../conexion/conexion.php";
session_start();
$fechainiano = new DateTime('first day of january '. date('Y'));
$fechafinano = new DateTime('last day of december '. date('Y'));

$evento = $_POST['Evento'];

switch ($evento){
    case 'DataTableData':   
        if (isset($_POST['trabajadorOrigen']) && is_array($_POST['trabajadorOrigen'])){
            $trabajadorOrigen = json_encode($_POST['trabajadorOrigen']);
        } else {
            $trabajadorOrigen = null;
        }

        if (isset($_POST['trabajadorDestino']) && is_array($_POST['trabajadorDestino'])){
            $trabajadorDestino = json_encode($_POST['trabajadorDestino']);
        } else {
            $trabajadorDestino = null;
        }

        $params = array(
            $_POST['tipoOrigen'],
            $_POST['tipoTramite'],
            $_POST['estadoTramite'],
            $_POST['numExpediente'],
            $_POST['tipoDocumento'],
            $_POST['numDocumento'],
            $_POST['asunto'],
            $_POST['entidadOrigen'],
            $_POST['oficinaOrigen'],
            $trabajadorOrigen,
            $_POST['entidadDestino'],
            $_POST['oficinaDestino'],
            $trabajadorDestino,
            $_POST['tipoFecha'],
            $_POST['fechaInicio'],
            $_POST['fechaFin'],
            $_POST['anioDocumento'],
            $_POST['rangoFecha'],
            $_POST['start'],
            $_POST['length'],
            $_POST['flgExterno']
        );

        if ($_POST['tipoTramite'] == '1'){
            $storedName = 'SP_CONSULTA_GENERAL_EMITIDOS';
        } else {
            $storedName = 'SP_CONSULTA_GENERAL_PROYECTADOS';
        }

        $sql = "{call ".$storedName." (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $rs = sqlsrv_query($cnx, $sql, $params);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = array();
        while($Rs=sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
            $subdata=array();
            $subdata = $Rs;
            // $subdata['fecha_doc']=$Rs['fecha_doc']->format( 'd-m-Y'); 
            $subdata['fecha_doc'] = ($Rs['fecha_doc'] == NULL) ? NULL : $Rs['fecha_doc']->format( 'd/m/Y'); 
            $data[]=$subdata;
        }

        $VO_TOTREG=0;
        while($res = sqlsrv_next_result($rs)){
            if( $res ) {
                while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                    $VO_TOTREG = $row['VO_TOTREG'];
                }
            } elseif( is_null($res)) {
                echo "No se Pudo Registrar el Proyecto";
                return;
            } else {
                die(print_r(sqlsrv_errors(), true));
            }                    
        }

        sqlsrv_free_stmt($rs);

        $recordsTotal=$VO_TOTREG;
        $recordsFiltered=$VO_TOTREG;
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $data    
        );

        echo json_encode($json_data);
    break;

    case 'DataTableDetalle':
        $params = array(
            $_POST['codigo']
        );

        if ($_POST['tipoTramite'] == 'T'){
            $storedName = 'SP_CONSULTA_GENERAL_EMITIDOS_OBTENER_INFORMACION';
        } else {
            $storedName = 'SP_CONSULTA_GENERAL_PROYECTADOS_OBTENER_INFORMACION';
        }

        $sql = "{call ".$storedName." (?) }";
        $rs = sqlsrv_query($cnx, $sql, $params);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = array();
        while($Rs=sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
            $subdata=array();
            $subdata = $Rs;
            $data[] = $subdata;
        }

        echo json_encode($data);
    break;

}
