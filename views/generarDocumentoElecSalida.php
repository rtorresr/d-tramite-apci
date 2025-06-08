<?php  session_start();
include_once("../conexion/conexion.php");

$sqlTra="UPDATE Tra_M_Tramite SET descripcion='".str_replace( '\"', '"', $_POST['descripcion'])."' WHERE iCodTramite='$_POST[iCodTramite]'";
$rsTra=sqlsrv_query($cnx,$sqlTra);
echo "<a class='btn btn-primary' href='registerDoc/pdf_digital_salida.php?iCodTramite=$_POST[iCodTramite]' target='_blank' class='majorpoints btn-info btn'>";
echo "Descargar PDF</a>";

?>