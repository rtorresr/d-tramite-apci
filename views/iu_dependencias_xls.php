<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=iu_oficina_xls.xls");

echo "<table width=780 border=0><tr><td align=right colspan=3>";
echo "</td></tr><tr><td align=center colspan=3>";
echo "<br>REPORTE - LISTA DE DEPENDENCIAS</b>";
echo " ";

echo "<table width=780 border=1><tr>";
echo "<td bgcolor=#0000CC><font color=#ffffff> COD DEPENDENCIA</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> DEPENDENCIA</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> SIGLA</td>";
echo "</tr>";

require_once("../conexion/conexion.php");
$sql="select * from Tra_M_Dependencias ";
$sql.=" WHERE iCodDependencia>0 ";
if($_GET[cNomDependencia]!=""){
$sql.=" AND cNomDependencia like '%$_GET[cNomDependencia]%' ";
}
if($_GET[cSiglaDependencia]!=""){
$sql.=" AND cSiglaDependencia='$_GET[cSiglaDependencia]' ";
}
$sql.="ORDER BY iCodDependencia ASC";
$rs=sqlsrv_query($cnx,$sql);

while ($Rs=sqlsrv_fetch_array($rs)){
	echo "<tr>";
  echo "<td>".$Rs[iCodDependencia]."</td>";
  echo "<td>".$Rs[cNomDependencia]."</td>";
  echo "<td>".$Rs[cSiglaDependencia]."</td>";
	echo "</tr>";
}
echo "</table>";
?>