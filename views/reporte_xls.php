<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_xls.xls");

echo "<table width=780 border=0><tr><td align=right colspan=6>";
echo "</td></tr><tr><td align=center colspan=6>";
echo "<br>REPORTE - LISTA DE DOCUMENTOS</b>";
echo " ";

echo "<table width=780 border=1><tr>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Nro Documento</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Nro Referencia</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Remitente</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Representante</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Fecha Derivo</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Asunto</td>";
echo "</tr>";

require_once("../conexion/conexion.php");

$sql="SELECT [Tra_M_tramite].cCodificacion,[Tra_M_tramite].cNroDocumento,[Tra_M_Remitente].cNombre,[Tra_M_Remitente].cRepresentante,[Tra_M_tramite].fFecDocumento,[Tra_M_tramite].cAsunto ";
$sql.= " FROM [Tra_M_tramite] INNER JOIN [Tra_M_Remitente]  ON ([Tra_M_Remitente].iCodRemitente=[Tra_M_Tramite].iCodRemitente) ";
if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
$sql.=" WHERE [Tra_M_tramite].fFecDocumento BETWEEN  '".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and '".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."' ";
}
$rs=sqlsrv_query($cnx,$sql);

//echo $sql;

while ($Rs=sqlsrv_fetch_array($rs)){
	echo "<tr>";
  echo "<td>".$Rs[cCodificacion]."</td>";
  echo "<td>".$Rs['cNroDocumento']."</td>";
  echo "<td>".$Rs['cNombre']."</td>";
  echo "<td>".$Rs[cRepresentante]."</td>";
  echo "<td>".$Rs['fFecDocumento']."</td>";
  echo "<td>".$Rs['cAsunto']."</td>";
  echo "</tr>";
 }
echo "</table>";
?>