<?php session_start();
	include_once("../conexion/conexion.php");

    $id=$_GET['id'];
    $idmov=$_GET['idmov'];

    $sql1= "delete Tra_M_Tramite_Movimientos where iCodMovimiento='".$idmov."'";
    sqlsrv_query($cnx,$sql1);
?>
<meta http-equiv="refresh" content="0;URL='actualiza_tramite.php?id=<?php echo $id;?>'" />    