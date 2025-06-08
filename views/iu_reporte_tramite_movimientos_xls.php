<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=iu_reporte_tramite_movimientos_xls.xls");

echo "<table width=780 border=0><tr><td align=right colspan=30>";
echo "</td></tr><tr><td align=center colspan=30>";
echo "<br>REPORTE - HISTORIAL DE MOVIMIENTOS DE DOCUMENTOS</b>";
echo " ";

echo "<table width=780 border=1><tr>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Nro Evento</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Tipo Evento</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Fecha de Ocurrido</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Usuario Responsable</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> Nro Movimiento</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodTramite]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodTrabajadorRegistro]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [nFlgTipoDoc]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodOficinaOrigen]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [fFecRecepcion]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodOficinaDerivar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodTrabajadorDerivar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [cCodTipoDocDerivar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodIndicacionDerivar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [cAsuntoDerivar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [cObservacionesDerivar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> ['fFecDerivar']</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> ['iCodTrabajadorDelegado']</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodIndicacionDelegado]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [cObservacionesDelegado]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [fFecDelegado]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [iCodTrabajadorFinalizar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [cObservacionesFinalizar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [fFecFinalizar]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [fFecMovimiento]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> ['nEstadoMovimiento']</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [nFlgEnvio]</td>";
echo "<td bgcolor=#0000CC><font color=#ffffff> [cFlgCopia]</td>";
echo "</tr>";

require_once("../conexion/conexion.php");

$sql="SELECT * FROM Tra_M_Audit_Tramite_Movimientos ";

//$sql.= " GROUP BY iCodOficinaResponsable ";
if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
$sql.=" WHERE [Tra_M_Audit_Tramite_Movimientos].fFecEvento BETWEEN  '".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and '".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."' ";
}
$_GET['cTipoEvento'];
if($_GET['cTipoEvento']!=""){
$sql.=" WHERE cTipoEvento='".$_GET['cTipoEvento']."'";
}
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;

while ($Rs=sqlsrv_fetch_array($rs)){
	echo "<tr>";
  echo "<td>".$Rs[iCodEventoMovimiento]."</td>";
  echo "<td>".$Rs[cTipoEvento]."</td>";
  echo "<td>".$Rs[fFecEvento]."</td>";
  echo "<td>".$Rs[usuario]."</td>";
  echo "<td>".$Rs[iCodMovimiento]."</td>";
  echo "<td>".$Rs[iCodTramite]."</td>";
  echo "<td>".$Rs[iCodTrabajadorRegistro]."</td>";
  echo "<td>".$Rs[nFlgTipoDoc]."</td>";
  echo "<td>".$Rs[iCodOficinaOrigen]."</td>";
  echo "<td>".$Rs[fFecRecepcion]."</td>";
  echo "<td>".$Rs[iCodOficinaDerivar]."</td>";
  echo "<td>".$Rs[iCodTrabajadorDerivar]."</td>";
  echo "<td>".$Rs[cCodTipoDocDerivar]."</td>";
  echo "<td>".$Rs[iCodIndicacionDerivar]."</td>";
  echo "<td>".$Rs[cAsuntoDerivar]."</td>";
  echo "<td>".$Rs[cObservacionesDerivar]."</td>";
  echo "<td>".$Rs['fFecDerivar']."</td>";
  echo "<td>".$Rs['iCodTrabajadorDelegado']."</td>";
  echo "<td>".$Rs[iCodIndicacionDelegado]."</td>";
  echo "<td>".$Rs[cObservacionesDelegado]."</td>";
  echo "<td>".$Rs[fFecDelegado]."</td>";
  echo "<td>".$Rs[iCodTrabajadorFinalizar]."</td>";
  echo "<td>".$Rs[cObservacionesFinalizar]."</td>";
  echo "<td>".$Rs[fFecFinalizar]."</td>";
  echo "<td>".$Rs[fFecMovimiento]."</td>";
  echo "<td>".$Rs['nEstadoMovimiento']."</td>";
  echo "<td>".$Rs[nFlgEnvio]."</td>";
  echo "<td>".$Rs[cFlgCopia]."</td>";
  echo "</tr>";
 }
echo "</table>";
?>