<?php 
session_start();
ob_start();
include_once("../conexion/conexion.php");
// iCodCategoria = 5 corresponde a 'Jefe de Oficina'

// $sqlTrb = "SELECT *,CASE 
// 	         WHEN encargado ='1' THEN '| (Encargado)' 
//            ELSE '' END as encargado 
//            FROM Tra_M_Trabajadores
//            WHERE iCodOficina='$_POST[iCodOficinaResponsable]' AND iCodCategoria = 5 ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
$sqlTrb = "SELECT *,
            CASE 
				WHEN encargado ='1' THEN '| (Encargado)' 
          		ELSE '' END as encargado 
				FROM Tra_M_Trabajadores
				WHERE iCodTrabajador in
				 (SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario 
				WHERE iCodOficina = '$_POST[iCodOficinaResponsable]' AND iCodPerfil = 3)";
$rsTrb = sqlsrv_query($cnx,$sqlTrb);
$result = array();
while($reponsable = sqlsrv_fetch_array($rsTrb)){
    $result[]= $reponsable;
}
echo json_encode($result);
?>