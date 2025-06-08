<?php session_start();
	include_once("../conexion/conexion.php");

    $id=$_GET['id'];

    // Eliminamos los movimientos primero
    $sql= "select * from Tra_M_Tramite_Movimientos where iCodTramite='".$id."'";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    do{
        $sql1= "delete Tra_M_Tramite_Movimientos where iCodMovimiento='".$rs['iCodMovimiento']."'";
        sqlsrv_query($cnx,$sql1);
    }while($rs=sqlsrv_fetch_array($query));

    // Eliminamos la maestra segundo
    $sql2= "delete Tra_M_Tramite where iCodTramite='".$id."'";
    sqlsrv_query($cnx,$sql2);
?>
<meta http-equiv="refresh" content="0;URL='tramite_elimina.php'" />    