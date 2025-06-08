<?php 
session_start();
include_once("../conexion/conexion.php");

$sqlMovs="SELECT temp.iCodTemp,Tra_M_Oficinas.cNomOficina, Tra_M_Trabajadores.cNombresTrabajador, Tra_M_Trabajadores.cApellidosTrabajador,
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
            ORDER BY temp.iCodTemp DESC";
$rsMovs=sqlsrv_query($cnx,$sqlMovs);

$result = array();
while($tramiteTemporal = sqlsrv_fetch_array($rsMovs)){
    $result[]= $tramiteTemporal; 
}

echo json_encode($result);
?>