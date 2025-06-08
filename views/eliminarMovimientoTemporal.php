<?php 
session_start();
include_once("../conexion/conexion.php");

$sqlAdd="DELETE FROM Tra_M_Tramite_Temporal WHERE iCodTemp= ".$_POST['iCodTemp'];
$rs=sqlsrv_query($cnx,$sqlAdd);
