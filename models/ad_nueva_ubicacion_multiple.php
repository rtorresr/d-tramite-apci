<?php
  $fFecActual = date("Ymd", strtotime($_POST[fEntrega])) . " " . date("G:i:s");

  if (strlen($_POST['cPais']) == 0) {
    for ($h = 0; $h < count($_POST[iCodAuto]); $h++) {
      $iCodAuto = $_POST[iCodAuto];
      $sql = "UPDATE Tra_M_Doc_Salidas_Multiples  
              SET cDireccion='$_POST[cDireccion]'
                  ,cDepartamento='$_POST[cDepartamento]'
                  ,cProvincia='$_POST[cProvincia]'
                  ,cDistrito='$_POST[cDistrito]'
                  ,CODIGO_PAIS=NULL
                  ,cFlgEnvio='$cFlgEnvio'
              WHERE iCodAuto='$iCodAuto[$h]' ";
      $rs = sqlsrv_query($cnx,$sql, $cnx);
    }
  }else{
    $cPais = $_POST['cPais'];
    $cFlgEnvio = 3; // Internacional
    for ($h = 0; $h < count($_POST[iCodAuto]); $h++) {
      $iCodAuto = $_POST[iCodAuto];
      $sql = "UPDATE Tra_M_Doc_Salidas_Multiples  
              SET cDireccion='$_POST[cDireccion]'
                  ,cDepartamento='$_POST[cDepartamento]'
                  ,cProvincia='$_POST[cProvincia]'
                  ,cDistrito='$_POST[cDistrito]'
                  ,CODIGO_PAIS='$cPais'
                  ,cFlgEnvio='$cFlgEnvio'
              WHERE iCodAuto='$iCodAuto[$h]' ";
      $rs = sqlsrv_query($cnx,$sql, $cnx);
    }
  }
  sqlsrv_close($cnx);
  header("Location: ../views/consultaTramiteCargo.php");
?>