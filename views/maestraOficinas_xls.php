<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=iu_oficina_xls.xls");

echo "<table width=780 border=0><tr><td align=right colspan=3>";
echo "</td></tr><tr><td align=center colspan=3>";
echo "<br>REPORTE - LISTA DE OFICINAS</b>";
echo " ";

echo "<table width=780 border=1><tr>";
echo "<td bgcolor=#0000CC><font color=#ffffff> COD OFICINA</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> NOMBRE OFICINA</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> SIGLA</td>";
echo "</tr>";

require_once("../conexion/conexion.php");
$sql="select * from Tra_M_Oficinas ";
$sql.=" WHERE iCodOficina>0 ";
if($_GET[cNomOficina]!=""){
$sql.=" AND cNomOficina like '%$_GET[cNomOficina]%' ";
}
if($_GET[cSiglaOficina]!=""){
$sql.=" AND cSiglaOficina='$_GET[cSiglaOficina]' ";
}
$sql.="ORDER BY iCodOficina ASC";
$rs=sqlsrv_query($cnx,$sql);

while ($Rs=sqlsrv_fetch_array($rs)){
	echo "<tr>";
  echo "<td>".$Rs['iCodOficina']."</td>";
  echo "<td>".$Rs[cNomOficina]."</td>";
  echo "<td>".$Rs[cSiglaOficina]."</td>";
	echo "</tr>";
}
echo "</table>";
?>