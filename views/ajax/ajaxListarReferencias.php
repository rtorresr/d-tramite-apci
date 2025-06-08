<?php
if (isset($_POST['datos']) && $_POST['datos']!= ""){
    
    include_once("../../conexion/conexion.php");
    $codigosTramite = '';
    $datos = json_decode($_POST['datos'],true);
    for($i = 0; $i < count($datos); $i ++){
        $subDato = $datos[$i];
        if($i === 0){
            $codigosTramite .= $subDato['iCodTramiteRef'];
        } else {
            $codigosTramite .= ', '.$subDato['iCodTramiteRef'];
        }
    }

    $sql = "SELECT tra.iCodTramite, tra.nCud, doc.cDescTipoDoc, 
    CASE 
        WHEN tra.cNroDocumento IS NOT NULL
            THEN tra.cNroDocumento
        ELSE
            tra.cCodificacion
    END AS codificacion
    FROM Tra_M_Tramite AS tra
    INNER JOIN Tra_M_Tipo_Documento AS doc ON doc.cCodTipoDoc = tra.cCodTipoDoc
    WHERE iCodTramite in (".$codigosTramite.")";

    $rsRem=sqlsrv_query($cnx,$sql);
    if (sqlsrv_has_rows($rsRem)){
        $arrRemitentes = [];
        while ($RsRem = sqlsrv_fetch_array($rsRem)){
            $texto = trim($RsRem['nCud'])." / ".trim($RsRem['cDescTipoDoc'])." ".trim($RsRem['codificacion']);
            array_push($arrRemitentes, ["id" => trim($RsRem['iCodTramite']), "text" => $texto]);
        }
        sqlsrv_free_stmt($rsRem);
        echo json_encode($arrRemitentes);
    }
}else{
    $arrRemitentes = [];    
    echo json_encode($arrRemitentes);
}