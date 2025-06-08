<?php
switch ($_POST['opcion']) {
    case 1:
        For ($j = 0, $jMax = count($_POST['cCorrelativo']); $j < $jMax; $j++) {
            $cCorrelativo = $_POST['cCorrelativo'];
            $cCodTipoDoc = $_POST['cCodTipoDoc'];
            echo $cCorrelativo[$j];
            echo $cCodTipoDoc[$j];
            $sqlU = "UPDATE Tra_M_Correlativo_Oficina SET nCorrelativo='$cCorrelativo[$j]' WHERE cCodTipoDoc='$cCodTipoDoc[$j]' And iCodOficina=$_REQUEST[iCodOficina]  And nNumAno=$_REQUEST[anho]";
            $rsU = sqlsrv_query($cnx,$sqlU);
        }
        header("Location: ../views/iu_correlativo_interno.php?iCodOficina=" . $_REQUEST['iCodOficina'] . "&anho=" . $_REQUEST['anho']);
        break;
    case 2:
        $sqlU = " INSERT INTO Tra_M_Correlativo_Oficina(cCodTipoDoc,iCodOficina,nNumAno,nCorrelativo) ";
        $sqlU.= " VALUES ( $_POST[cCodTipoDoc],$_REQUEST[iCodOficina], $_POST[nNumAno], 0) ";
        $rsU = sqlsrv_query($cnx,$sqlU);
        header("Location: ../views/iu_correlativo_interno.php?iCodOficina=" . $_REQUEST['iCodOficina']);
        break;
    case 3:
        For ($j = 0, $jMax = count($_POST['cCorrelativo']); $j < $jMax; $j++) {
            $cCorrelativo = $_POST['cCorrelativo'];
            $cCodTipoDoc = $_POST['cCodTipoDoc'];
            $sqlU = "UPDATE Tra_M_Correlativo_Salida SET nCorrelativo='$cCorrelativo[$j]' WHERE cCodTipoDoc='$cCodTipoDoc[$j]' And iCodOficina=$_REQUEST[iCodOficina] And nNumAno=$_REQUEST[anho]";
            $rsU = sqlsrv_query($cnx,$sqlU);
        }
        header("Location: ../views/iu_correlativo_salida.php?iCodOficina=" . $_REQUEST['iCodOficina']??'' . "&anho=" . $_REQUEST['anho']??'');
        break;
    case 4:
        $sqlU = " INSERT INTO Tra_M_Correlativo_Salida(cCodTipoDoc,iCodOficina,nNumAno,nCorrelativo) ";
        $sqlU.= " VALUES ( $_POST[cCodTipoDoc],$_REQUEST[iCodOficina], $_POST[nNumAno], 0) ";
        $rsU = sqlsrv_query($cnx,$sqlU);
        header("Location: ../views/iu_correlativo_salida.php?iCodOficina=" . $_REQUEST['iCodOficina']);
        break;
    case 5:
        For ($j = 0, $jMax = count($_POST['cCorrelativo']); $j < $jMax; $j++) {
            $cCorrelativo = $_POST['cCorrelativo'];
            $cCodTipoDoc = $_POST['cCodTipoDoc'];
            $sqlU = "UPDATE Tra_M_Correlativo_Trabajador SET nCorrelativo='$cCorrelativo[$j]' WHERE cCodTipoDoc='$cCodTipoDoc[$j]' And iCodTrabajador =$_REQUEST[iCodTrabajador] And nNumAno=$_REQUEST[anho] ";
            $rsU = sqlsrv_query($cnx,$sqlU);
        }
        header("Location: ../views/iu_correlativo_profesional.php?iCodOficina=" . $_REQUEST['iCodOficina'] . "&iCodTrabajador=" . $_REQUEST['iCodTrabajador'] . "&anho=" . $_REQUEST['anho']);
        break;
    case 6:
        $sqlU = " INSERT INTO Tra_M_Correlativo_Trabajador(cCodTipoDoc,iCodOficina,iCodTrabajador,nNumAno,nCorrelativo) ";
        $sqlU.= " VALUES ( $_POST[cCodTipoDoc],$_REQUEST[iCodOficina],$_REQUEST[iCodTrabajador], $_POST[nNumAno], 0) ";
        $rsU = sqlsrv_query($cnx,$sqlU);
        header("Location: ../views/iu_correlativo_profesional.php?iCodOficina=" . $_REQUEST['iCodOficina'] . "&iCodTrabajador=" . $_REQUEST['iCodTrabajador']);
        break;
}
//echo $sql;
?>

