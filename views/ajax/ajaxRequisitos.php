<?php
include_once("../../conexion/conexion.php");

$sqlDias = "SELECT nDias,iCodOficina FROM Tra_M_Tupa WHERE iCodTupa= ".$_POST['iCodTupa'];
$rsDias = sqlsrv_query($cnx,$sqlDias);
$RsDias = sqlsrv_fetch_array($rsDias);

$data = [];
$data['dias'] = $RsDias['nDias'];

$sqlTupaReq="SELECT iCodTupaRequisito,cNomTupaRequisito FROM Tra_M_Tupa_Requisitos WHERE nEstadoTupaRequisito = 1 AND iCodTupa='".$_POST['iCodTupa']."' ORDER BY iCodTupaRequisito ASC";
$rsTupaReq = sqlsrv_query($cnx,$sqlTupaReq);
$datos = [];
if (sqlsrv_has_rows($rsTupaReq)){
    while ($RsTupaReq=sqlsrv_fetch_array($rsTupaReq)){
        $con = "<tr>
                       <td valign=top width=155>
                           <label class='form-check-label' for='".$RsTupaReq["iCodTupaRequisito"]."'>
                           <input class='form-check-input' type='checkbox' name='iCodTupaRequisito[]' value='".$RsTupaReq["iCodTupaRequisito"]."' id='".$RsTupaReq["iCodTupaRequisito"]."' ><span>".$RsTupaReq["cNomTupaRequisito"]."</span></label>
                       </td>
                    </tr>";
        array_push($datos,$con);
    };
    $data['datos']= $datos;
}else{
    $data['datos']=  0;
}
sqlsrv_free_stmt($rsTupaReq);
echo json_encode($data);