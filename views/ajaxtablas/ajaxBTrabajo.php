<?php
include_once "../../conexion/conexion.php";
// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
session_start();

$params = [
    $_SESSION['iCodPerfilLogin'],    
    $_SESSION['iCodOficinaLogin'],
    $_SESSION['CODIGO_TRABAJADOR']    
];

$sqlBdRecibidos = "{call SP_GRUPOS_BANDEJA_TRABAJO (?,?,?)}";

$rsBdRecibidos = sqlsrv_query($cnx,$sqlBdRecibidos,$params);

if($rsBdRecibidos === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rsBdRecibidos, SQLSRV_FETCH_ASSOC)){
    // if ($Rs['texto'] != null){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['agrupado']= $Rs['cAgrupado'];
    $subdata['mov'] = $Rs['iCodMovimiento'];
    $subdata['documento'] = $Rs['nomTipoDoc'].' '.$Rs['cCodificacion'];
    $subdata['asunto'] = $Rs['cAsunto'];
    $subdata['cud'] = $Rs['nCud'];
    // $subdata['fechaModificacion'] = strtotime($Rs['fecModifica']);
    $subdata['fechaModificacion'] = date("d/m/Y H:i:s", strtotime($Rs['fecModifica']));
    //  strtotime()->format( 'd/m/Y H:i:s');
    $subdata['tipo'] = $Rs['tipo'];
    $subdata['codigo'] = $Rs['codigo'];
    $subdata['corresponde'] = $Rs['corresponde'];
    $subdata['contieneDoc'] = $Rs['contieneDoc'];
    $subdata['nFlgTipoDoc'] = $Rs['nFlgTipoDoc'];
    $subdata['proyectoIni'] = $Rs['proyectoIni'];
    // $datos = explode(' | ',$Rs['texto']);
    // $subdata['documento']=$datos[0]??'';
    // $subdata['asunto']=$datos[1]??'';
    // $subdata['cud']=$datos[2]??'';
    // $subdata['fechaModificacion'] =  (trim($datos[3]) != '') ? trim($datos[3]) : '';
    $data[]=$subdata;
    $contador ++;
    // }
}

// $VO_TOTREG = 0;
// while($res = sqlsrv_next_result($rsBdRecibidos)){
//     if( $res ) {
//         while( $row = sqlsrv_fetch_array( $rsBdRecibidos, SQLSRV_FETCH_ASSOC)){
//             $VO_TOTREG = $row['VO_TOTREG'];
//         }
//     } elseif ( is_null($res)) {
//         echo "No se obtener datos!";
//         return;
//     } else {
//         die(print_r(sqlsrv_errors(), true));
//     }
// }

$recordsTotal = count($data);
$recordsFiltered = count($data);
$json_data = array(
    "draw"            => (int)($_POST['draw']??0),
    "recordsTotal"    => (int) $recordsTotal ,
    "recordsFiltered" => (int) $recordsFiltered ,
    "data"            => $data
);

echo json_encode($json_data);