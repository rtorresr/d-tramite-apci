<?php
include_once("../../conexion/conexion.php");
$sqlParam = "SELECT paramEditable FROM Tra_M_Tipo_Documento as td INNER JOIN Tra_M_Plantilla AS pt ON td.cCodTipoDoc = pt.cCodTipoDoc WHERE td.cCodTipoDoc = ".$_POST['codigo'];
$rsParam = sqlsrv_query($cnx,$sqlParam);


if (sqlsrv_has_rows($rsParam)){
    $RsParam = sqlsrv_fetch_array($rsParam);
    $data['flag'] = 1;
    $data['editables'] = $RsParam['paramEditable'];

    echo json_encode($data);
} else {
    $data['flag'] = 0;
    echo json_encode($data);
}
?>