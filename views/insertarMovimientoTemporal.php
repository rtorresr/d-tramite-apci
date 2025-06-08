<?php 
session_start();
include_once("../conexion/conexion.php");

$oficinaMov = $_POST['iCodOficinaMov']??'';
$iCodTrabajadorMov = $_POST['iCodTrabajadorMov']??'';
$iCodIndicacionMov = $_POST['iCodIndicacionMov']??'' ;
$cPrioridad= $_POST['cPrioridad']??'';
$cCopia = $_POST['cCopia'];
if($cCopia == '1'){
    $iCodIndicacionMov = 2;
}

//COSNULTA SI YA FUE INGRESADO
$rsconsulta = sqlsrv_query($cnx,"SELECT iCodTemp FROM Tra_M_Tramite_Temporal WHERE cCodSession = '".$_SESSION['cCodOfi']."' AND iCodOficina = ".$oficinaMov." AND iCodTrabajador = ".$iCodTrabajadorMov);
if(!sqlsrv_has_rows($rsconsulta)){

    //REGISTRA Y ENVIA
    $sqlAdd = "INSERT INTO Tra_M_Tramite_Temporal (iCodOficina,iCodTrabajador,iCodIndicacion,cPrioridad,cCodSession,flgCopia)
           VALUES ('".$oficinaMov."','".$iCodTrabajadorMov."','".$iCodIndicacionMov."','".$cPrioridad."','".$_SESSION['cCodOfi']."','".$cCopia."')";
    $rs = sqlsrv_query($cnx,$sqlAdd);


    $sqlMovs = "SELECT temp.iCodTemp,Tra_M_Oficinas.cNomOficina, Tra_M_Trabajadores.cNombresTrabajador, Tra_M_Trabajadores.cApellidosTrabajador,
            CASE
                WHEN temp.flgCopia = 0
                    THEN ''
                ELSE
                    'Copia'
            END AS cCopia
            FROM Tra_M_Tramite_Temporal  AS temp
            INNER JOIN Tra_M_Oficinas ON Tra_M_Oficinas.iCodOficina = temp.iCodOficina 
            INNER JOIN Tra_M_Trabajadores ON Tra_M_Trabajadores.iCodTrabajador = temp.iCodTrabajador
            WHERE temp.cCodSession = '".$_SESSION['cCodOfi']."' 
            ORDER BY temp.iCodTemp DESC" ;
    $rsMovs = sqlsrv_query($cnx,$sqlMovs);
    $result = array();
    while ($tramiteTemporal = sqlsrv_fetch_array($rsMovs)){
        $result[]=$tramiteTemporal;
    }
    echo json_encode($result);
}


