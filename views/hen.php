<?php
if(($_GET['opcion']??'')==24){ //retirar movimientos oficinas
    $sqlX="DELETE FROM Tra_M_Tramite_Temporal WHERE iCodTemp='".$_GET['iCodTemp']."'";
    $rsX=sqlsrv_query($cnx,$sqlX);
    echo "<html>";
    echo "<head>";
    echo "</head>";
    echo "<body OnLoad='document.form_envio.submit()'>";
    echo "<form method='POST' name='form_envio' action='pendientesControlDerivar.php?clear=1#area'>";
    if (($_GET['iCodMovimientoAccion']??'')==''){
        $a=($_GET['MovimientoAccion']??'');
        $MovimientoAccion=unserialize($a);
        $i = 0;
        foreach ($MovimientoAccion as $v) {
            echo "<input type=hidden name=MovimientoAccion[] value='".$v."'>";
        }
    }
    if ($_GET['iCodMovimientoAccion']!=""){
        echo "<input type=hidden name=iCodMovimientoAccion value='".($_GET['iCodMovimientoAccion']??'')."'>";
    }
    echo "<input type=hidden name=cCodTipoDoc value='".($_GET['cCodTipoDoc']??'')."'>";
    echo "<input type=hidden name=iCodOficinaDerivar value='".($_GET['iCodOficinaDerivar']??'')."'>";
    echo "<input type=hidden name=iCodTrabajadorDerivar value='".($_GET['iCodTrabajadorDerivar']??'')."'>";
    echo "<input type=hidden name=iCodIndicacionDerivar value='".($_GET['iCodIndicacionDerivar']??'')."'>";
    echo "<input type=hidden name=cAsuntoDerivar value='".($_GET['cAsuntoDerivar']??'')."'>";
    echo "<input type=hidden name=cObservacionesDerivar value='".($_GET['cObservacionesDerivar']??'')."'>";
    echo "<input type=hidden name=nFlgCopias value='".($_GET['nFlgCopias']??'')."'>";
    echo "</form>";
    echo "</body>";
    echo "</html>";
}

?>