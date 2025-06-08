<?php
  $sqlES_EXTERNO = "SELECT ES_EXTERNO FROM Tra_M_Trabajadores WHERE iCodTrabajador = $id";
  $rsES_EXTERNO  = sqlsrv_query($cnx,$sqlES_EXTERNO);
  $RsES_EXTERNO  = sqlsrv_fetch_array($rsES_EXTERNO);

  $sql = "SP_TRABAJADORES_DELETE " . $id;
  $rs  = sqlsrv_query($cnx,$sql);
  sqlsrv_close($cnx);

  if ($RsES_EXTERNO['ES_EXTERNO'] == 1){
    header("Location: ../views/iu_trabajadores_externos.php?cNombreTrabajador=" . ($_GET['cNombreTrabajador']??'') . "&cApellidosTrabajador=" . ($_GET['cApellidosTrabajador']??'') . "&cTipoDocIdentidad=" . ($_GET['cTipoDocIdentidad']??'') . "&cNumDocIdentidad=" . ($_GET['cNumDocIdentidad']??'') . "&iCodPerfil=" . ($_GET['iCodPerfil']??'') . "&txtestado=" . ($_GET['txtestado']??'') . "&pag=" . ($pag??0));
  }elseif($RsES_EXTERNO['ES_EXTERNO'] == 0){
    header("Location: ../views/iu_trabajadores.php?cNombreTrabajador=" . ($_GET['cNombreTrabajador']??'') . "&cApellidosTrabajador=" . ($_GET['cApellidosTrabajador']??'') . "&cTipoDocIdentidad=" . ($_GET['cTipoDocIdentidad']??'') . "&cNumDocIdentidad=" . ($_GET['cNumDocIdentidad']??'') . "&iCodOficina=" . ($_GET['iCodOficina']??'') . "&iCodPerfil=" . ($_GET['iCodPerfil']??'') . "&iCodCategoria=" . ($_GET['iCodCategoria']??'') . "&txtestado=" . ($_GET['txtestado']??'') . "&pag=" . ($pag??0));
  }
?>