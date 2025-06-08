<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=iu_trabajadores_xls.xls");

echo "<table width=780 border=0><tr><td align=right colspan=9>";
echo "</td></tr><tr><td align=center colspan=9>";
echo "<br>REPORTE - LISTA DE TRABAJADORES</b>";
echo " ";

echo "<table width=780 border=1><tr>";
echo "<td bgcolor=#0000CC><font color=#ffffff> COD TRABAJADOR</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> NOMBRES</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> APELLIDOS</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> TIPO DOC</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> NRO DOC</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> DIRECCION</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> E-MAIL</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> TELEFONO</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> ESTADO</td>";

echo "</tr>";

require_once("../conexion/conexion.php");
$sql="select * from Tra_M_Trabajadores ";
$sql.=" WHERE iCodTrabajador>0 ";
if($_GET[cApellidosTrabajador]!=""){
$sql.=" AND cApellidosTrabajador like '%$_GET[cApellidosTrabajador]%' ";
}
if($_GET[cNumDocIdentidad]!=""){
$sql.=" AND cNumDocIdentidad='$_GET[cNumDocIdentidad]' ";
}
$sql.="ORDER BY iCodTrabajador ASC";
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;

while ($Rs=sqlsrv_fetch_array($rs)){
	echo "<tr>";
  echo "<td>".$Rs[iCodTrabajador]."</td>";
  echo "<td>".$Rs[cNombresTrabajador]."</td>";
  echo "<td>".$Rs[cApellidosTrabajador]."</td>";
  echo "<td>".$Rs[cTipoDocIdentidad]."</td>";
  echo "<td>".$Rs[cNumDocIdentidad]."</td>";
  echo "<td>".$Rs[cDireccionTrabajador]."</td>";
  echo "<td>".$Rs[cMailTrabajador]."</td>";
  echo "<td>".$Rs[cTlfTrabajador1]."</td>";
  echo "<td>".$Rs[nFlgEstado]."</td>";
  echo "</tr>";
}
echo "</table>";
?>