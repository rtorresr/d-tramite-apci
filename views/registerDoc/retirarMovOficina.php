<?php
/**
 * Created by PhpStorm.
 * User: jatayauri
 * Date: 12/10/2018
 * Time: 10:39
 */
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
    include_once("../../conexion/conexion.php");
    $sqlX="DELETE FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".$_GET['iCodTemp']."'";
    $rsX=sqlsrv_query($cnx,$sqlX);
    echo "<html>";
    echo "<head>";
    echo "</head>";
    echo "<body OnLoad='document.form_envio.submit();'>";
    echo "<form method=GET name=form_envio action=../pendientesDerivadosEdit.php>";
    echo "<input type=hidden name=iCodMovimientoDerivar value='".$_GET['iCodMovimientoDerivar']."'>";
    echo "</form>";
    echo "</body>";
    echo "</html>";
}else{
    header("Location: ../../index-b.php?alter=5");
}?>
