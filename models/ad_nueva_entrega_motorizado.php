<?php
  $fFecActual = date("Ymd", strtotime($_POST[fEntrega])) . " " . date("G:i:s");
  for ($h = 0; $h < count($_POST[iCodAuto]); $h++) {
    $iCodAuto = $_POST[iCodAuto];
    $sql = "UPDATE Tra_M_Doc_Salidas_Multiples 
            SET iCodTrabajadorEnvio = '$_POST[iCodTrabajadorEnvio]',
                cFlgEnvio = '$_POST[cFlgEnvio]',
                cOrdenServicio = '$_POST[cOrdenServicio]',
                fEntrega = '$fFecActual',
                cFlgUrgente = '$_POST[cFlgUrgente]',
                cNumGuiaServicio = '$_POST[cNumGuiaServicio]' 
            WHERE iCodAuto = '$iCodAuto[$h]' ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
  }
  sqlsrv_close($cnx);
  header("Location: ../views/consultaTramiteCargo.php");
?>

