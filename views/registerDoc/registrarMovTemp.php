<?php
/**
 * Created by PhpStorm.
 * User: jatayauri
 * Date: 12/10/2018
 * Time: 11:10
 */
session_start();

if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
    include_once("../../conexion/conexion.php");
    for ($i=0;$i<count($_POST['lstOficinasSel']);$i++){
        $lstOficinasSel=$_POST['lstOficinasSel'];

        $sqlTrb = "SELECT * FROM Tra_M_Perfil_Ususario TPU
					 			 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
					 			 WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '$lstOficinasSel[$i]'";
        $rsTrb=sqlsrv_query($cnx,$sqlTrb);
        $RsTrb=sqlsrv_fetch_array($rsTrb);

        $sqlAdd="INSERT INTO Tra_M_Tramite_Temporal ";
        $sqlAdd.="(iCodOficina,iCodTrabajador,iCodIndicacion,cPrioridad,cCodSession)";
        $sqlAdd.=" VALUES ";
        $sqlAdd.="('$lstOficinasSel[$i]','".$RsTrb['iCodTrabajador']."','".$_POST['iCodIndicacionSel']."','".$_POST['cPrioridad']."','".$_SESSION['cCodSessionDrv']."')";
        $rs=sqlsrv_query($cnx,$sqlAdd);
        sqlsrv_free_stmt($rsTrb);
    }

    //echo "oficina".$_POST['iCodOficina'];

    echo "<html>";
    echo "<head>";
    echo "</head>";
    echo "<body OnLoad='document.form_envio.submit();'>";
    if($_POST['iCodOficina']!=""){
        echo "<form method='POST' name='form_envio' action='pendientesControlDerivarAdm.php?iCodMovimientoAccion=".($_POST['iCodMovimiento']??'')."&iCodOficina=".($_POST['iCodOficina']??'')."&clear=1#area'>";
    }else{
        echo "<form method='POST' name='form_envio' action='../pendientesControlDerivar.php?clear=1#area'>";
    }
    if (isset($_POST['iCodMovimientoAccion'])) {
        if ($_POST['iCodMovimientoAccion'] != "") {
            for ($h = 0; $h < count($_POST['iCodMovimientoAccion']); $h++) {
                $MovimientoAccion = $_POST['iCodMovimientoAccion'];
                echo "<input type=hidden name=MovimientoAccion[] value='" . $MovimientoAccion[$h] . "'>";
            }
        }
    }
    if (isset($_POST['iCodMovimientoAccion2'])) {
        if ($_POST['iCodMovimientoAccion2'] != "") {
            echo "<input type=hidden name=iCodMovimientoAccion value='" . $_POST['iCodMovimientoAccion2'] . "'>";
        }
    }

    echo "<input type=hidden name=cCodTipoDoc value='".($_POST['cCodTipoDoc']??'')."'>";
    echo "<input type=hidden name=iCodOficinaDerivar value='".($_POST['iCodOficinaDerivar']??'')."'>";
    echo "<input type=hidden name=iCodTrabajadorDerivar value='".($_POST['iCodTrabajadorDerivar']??'')."'>";
    echo "<input type=hidden name=iCodIndicacionDerivar value='".($_POST['iCodIndicacionDerivar']??'')."'>";
    echo "<input type=hidden name=cAsuntoDerivar value='".($_POST['cAsuntoDerivar']??'')."'>";
    echo "<input type=hidden name=cObservacionesDerivar value='".($_POST['cObservacionesDerivar']??'')."'>";
    echo "<input type=hidden name=nFlgCopias value='".($_POST['nFlgCopias']??'')."'>";
    echo "</form>";
    echo "</body>";
    echo "</html>";
}else{
    header("Location: ../../index-b.php?alter=5");
}?>
