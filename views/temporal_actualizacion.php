<?
include_once("../conexion/conexion.php");
$sql="SELECT * FROM Tra_M_Tramite WHERE Tra_M_Tramite.nFlgTipoDoc=1 AND nFlgClaseDoc IS NULL";
$rs=sqlsrv_query($cnx,$sql);
while ($Rs=sqlsrv_fetch_array($rs)){
	if($Rs[iCodTupaClase]!=""){
		$sqlUpd="UPDATE Tra_M_Tramite SET nFlgClaseDoc=1 WHERE iCodTramite='$Rs[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		echo "Tramite: ".$Rs[iCodTramite]." actualizado a clase 1";	
	}Else{
		$sqlUpd="UPDATE Tra_M_Tramite SET nFlgClaseDoc=2 WHERE iCodTramite='$Rs[iCodTramite]'";
		$rsUpd=sqlsrv_query($cnx,$sqlUpd);
		echo "Tramite: ".$Rs[iCodTramite]." actualizado a clase 2";	
	}
}
?>