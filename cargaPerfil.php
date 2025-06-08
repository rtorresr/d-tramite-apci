<?php
include_once("conexion/conexion.php");
$sqlTem="select (select cDescPerfil from Tra_M_Perfil where iCodPerfil=o.iCodPerfil) as cDescPerfil,iCodPerfil from Tra_M_Perfil_Ususario o where iCodTrabajador='".$_POST['idTrabajador']."' AND iCodOficina = ".$_POST['oficina'];
$rsTem=sqlsrv_query($cnx,$sqlTem);
$valor = '';
while ($RsTem=sqlsrv_fetch_array($rsTem)) {
     $valor .= '<option value="'.$RsTem['iCodPerfil'].'">'.rtrim($RsTem['cDescPerfil']).'</option>';
}
echo $valor;

