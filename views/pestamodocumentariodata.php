<?php session_start();
include_once("../conexion/conexion.php");	    
    ini_set('date.timezone', 'America/Lima');

    // 1: pendinte
    // 2: Entregado
    if($_GET['estado']==1 or $_GET['estado']==2){
        $insert="update T_MAE_PRESTAMO set Cod_estado_prestamo='".$_GET['estado']."', fecha_entrega=GETDATE() where codigo='".$_GET['id']."'";
    }else if($_GET['estado']==3){
        $insert="delete from T_MAE_PRESTAMO where codigo='".$_GET['id']."'";
    }
    sqlsrv_query($cnx,$insert);
    //echo $insert;
?>
<meta http-equiv="refresh" content="0;URL='prestamoDOCUMENTARIO DIGITAL.php'" />    