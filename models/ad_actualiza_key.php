<?php
  require_once("../conexion/conexion.php");

  $sqlES_EXTERNO = "SELECT ES_EXTERNO FROM Tra_M_Trabajadores WHERE iCodTrabajador = '".($_POST['cod']??'')."'";
  $rsES_EXTERNO  = sqlsrv_query($cnx,$sqlES_EXTERNO);
  $RsES_EXTERNO  = sqlsrv_fetch_array($rsES_EXTERNO);

  $cPassword = md5($_POST['usr'] . $_POST['contrasena']);
  $sql = "UPDATE Tra_M_Trabajadores SET cPassword='$cPassword' WHERE iCodTrabajador='".($_POST['cod']??'')."'";
  $rs = sqlsrv_query($cnx,$sql);
  sqlsrv_close($cnx);

  if ($RsES_EXTERNO['ES_EXTERNO'] == 1){
    header("Location: ../views/iu_trabajadores_externos.php?cNombreTrabajador=" . ($_POST['cNombreTrabajadorx']??'') . "&cApellidosTrabajador=" . ($_POST['cApellidosTrabajadorx']??'') . "&cTipoDocIdentidad=" . ($_POST['cTipoDocIdentidadx']??'') . "&cNumDocIdentidad=" . ($_POST['cNumDocIdentidadx']??'') . "&iCodPerfil=" . ($_POST['iCodPerfilx']??'') . "&txtestado=" . ($_POST['txtestadox']??'') . "&pag=" . ($_POST['pagx']??'') . "");
  }elseif ($RsES_EXTERNO['ES_EXTERNO'] == 0){
    header("Location: ../views/iu_trabajadores.php?cNombreTrabajador=");
  }
?>