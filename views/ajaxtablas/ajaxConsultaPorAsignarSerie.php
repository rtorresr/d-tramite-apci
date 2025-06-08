<?php
include_once "../../conexion/conexion.php";
session_start();

$params = array(
    $_SESSION['IdSesion']
);

$sql = "{call UP_BANDEJA_DOC_SERIE_POR_ASIGNAR (?) }";
$rs = sqlsrv_query($cnx, $sql, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}

$data = array();
try {
    $contador = 0;
    while($Rs=sqlsrv_fetch_array($rs)){
        $subdata=array();
        $subdata['rowId'] = $contador;
        $subdata['IdTramite']=$Rs['IdTramite'];
        $subdata['Cud']=$Rs['Cud'];
        $subdata['Documento']=$Rs['Documento'];
        $subdata['Asunto']=$Rs['Asunto'];
        $subdata['NroAdjuntos']=$Rs['NroAdjuntos'];
        $subdata['FecRegistro']=$Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'd-m-Y H:i:s') : '';
        $data[]=$subdata;
        $contador ++;
    }
    $VO_TOTREG=0;

    while($res = sqlsrv_next_result($rs)){
        if( $res ) {
            while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                $VO_TOTREG=$row['VO_TOTREG'];
            }
        } elseif( is_null($res)) {
            echo "No se Pudo Registrar el Proyecto";
            return;
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    $recordsTotal=$VO_TOTREG;
    $recordsFiltered=$VO_TOTREG;
    $json_data = array(
        "draw"            => (int)($_POST['draw']??0),
        "recordsTotal"    => (int) $recordsTotal ,
        "recordsFiltered" => (int) $recordsFiltered ,
        "data"            => $data
    );

    echo json_encode($json_data);
} catch (\Throwable $th) {
    die(print_r($th, true));
}
