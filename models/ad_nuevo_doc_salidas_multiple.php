<?php

$op=$_GET['op'];
if ($op == 1) {
    $sqlCount = "  SELECT iCodRemitente FROM Tra_M_Grupo_Remitente_Detalle WHERE iCodGrupo='" . $_POST[cGrupo] . "' and iCodRemitente NOT IN 
   (SELECT  T.iCodRemitente FROM Tra_M_Doc_Salidas_Multiples T WHERE T.iCodTramite='$_POST[txtcod_tramite]') ";
    $rsCount = sqlsrv_query($cnx,$sqlCount, $cnx);
    $numrows = sqlsrv_has_rows($rsCount);

    for ($i = 1; $i <= $numrows; $i++) {
        while ($RsCount = sqlsrv_fetch_array($rsCount)) {
            $sqlTramite = " SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[txtcod_tramite]' ";
            $rsTramite = sqlsrv_query($cnx,$sqlTramite, $cnx);
            $RsTramite = sqlsrv_fetch_array($rsTramite);

            $sqlOficina = "SELECT DISTINCT Tra_M_Trabajadores.iCodOficina from Tra_M_Trabajadores,Tra_M_Tramite ,Tra_M_Oficinas WHERE  Tra_M_Trabajadores.iCodTrabajador = Tra_M_Tramite.iCodTrabajadorRegistro AND Tra_M_Trabajadores.iCodOficina=Tra_M_Oficinas.iCodOficina AND iCodTrabajadorRegistro='$RsTramite[iCodTrabajadorRegistro]' ";
            $rsOficina = sqlsrv_query($cnx,$sqlOficina, $cnx);
            $RsOficina = sqlsrv_fetch_array($rsOficina);

            $sqlRemitente = " SELECT * FROM Tra_M_Remitente WHERE  iCodRemitente='$RsCount[iCodRemitente]' ";
            $rsRemitente = sqlsrv_query($cnx,$sqlRemitente, $cnx);
            $RsRemitente = sqlsrv_fetch_array($rsRemitente);

            $sql = " INSERT INTO Tra_M_Doc_Salidas_Multiples (iCodTramite ,cCodificacion,iCodRemitente,iCodOficina,cAsunto,cDireccion , cFlgEnvio,iCodTrabajadorRegistro,cFlgEstado,cDepartamento,cProvincia,cDistrito)  VALUES ('$_POST[txtcod_tramite]','$RsTramite[cCodificacion]' ,'$RsCount[iCodRemitente]' ,'$RsOficina['iCodOficina']','$RsTramite['cAsunto']' ,'$RsRemitente[cDireccion]','$RsTramite[nFlgEnvio]','$RsTramite[iCodTrabajadorRegistro]',3,'$RsRemitente[cDepartamento]','$RsRemitente[cProvincia]','$RsRemitente[cDistrito]')  ";
            //echo $sql;

            $rs = sqlsrv_query($cnx,$sql, $cnx);
        }
    }
    header("Location: ../views/iu_doc_salidas_multiple.php?cod=" . $_POST[txtcod_tramite]);
}

if ($op == 2) {
  for ($h = 0; $h < count($_POST[iCodRemitente]); $h++) {
    $iCodRemitente = $_POST[iCodRemitente];

    $sqlTramite = " SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[CodTramite]' ";
    $rsTramite = sqlsrv_query($cnx,$sqlTramite, $cnx);
    $RsTramite = sqlsrv_fetch_array($rsTramite);

    $sqlOficina = "SELECT DISTINCT Tra_M_Trabajadores.iCodOficina from Tra_M_Trabajadores,Tra_M_Tramite ,Tra_M_Oficinas WHERE  Tra_M_Trabajadores.iCodTrabajador = Tra_M_Tramite.iCodTrabajadorRegistro AND Tra_M_Trabajadores.iCodOficina=Tra_M_Oficinas.iCodOficina AND iCodTrabajadorRegistro='$RsTramite[iCodTrabajadorRegistro]' ";
    $rsOficina = sqlsrv_query($cnx,$sqlOficina, $cnx);
    $RsOficina = sqlsrv_fetch_array($rsOficina);

    $sqlRemitente = " SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$iCodRemitente[$h]' ";
    $rsRemitente = sqlsrv_query($cnx,$sqlRemitente, $cnx);
    $RsRemitente = sqlsrv_fetch_array($rsRemitente);

    $sql = "INSERT INTO Tra_M_Doc_Salidas_Multiples (iCodTramite,cCodificacion,iCodRemitente,iCodOficina,cAsunto,cDireccion,cFlgEnvio,iCodTrabajadorRegistro,cFlgEstado,cDepartamento,cProvincia,cDistrito)  VALUES    ('$_POST[CodTramite]' ,'$RsTramite[cCodificacion]','$iCodRemitente[$h]', '$RsOficina['iCodOficina']','$RsTramite['cAsunto']' ,'$RsRemitente[cDireccion]' ,'$RsTramite[nFlgEnvio]','$RsTramite[iCodTrabajadorRegistro]',3,'$RsRemitente[cDepartamento]','$RsRemitente[cProvincia]','$RsRemitente[cDistrito]')  ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
  }
    header("Location: ../views/iu_doc_salidas_multiple.php?cod=" . $_POST[CodTramite]);
}
?>