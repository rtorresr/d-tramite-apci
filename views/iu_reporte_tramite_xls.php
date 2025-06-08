<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_reporte_tramite_xls.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL del Historial de Documentos Ingresados
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   Larry Ortiz        05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=iu_reporte_tramite_xls.xls");
include_once("../conexion/conexion.php");
    $anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
    $sql=" SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$trab' ";
	$rs=sqlsrv_query($cnx,$sql);
	$Rs=sqlsrv_fetch_array($rs);
	
    echo "<table width=780 border=0><tr><td align=center colspan=7>";
	echo "<H3>REPORTE - HISTORIAL DE DOCUMENTOS</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=7>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=center colspan=7>";
	echo "<H3>GENERADO POR - ".$Rs[cNombresTrabajador]." ".$Rs[cApellidosTrabajador]."</H3>";
	echo " ";
?>		
   <table style="width: 780px;border: solid 1px #5544DD; border-collapse: collapse" align="center">
     <thead>
      <tr>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Nro Evento</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Tipo Evento</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Fecha de Ocurrido</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Usuario Responsable</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Nro Tramite</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nFlgTipoDoc</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">cCodificacion</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">iCodTrabajadorRegistro</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">cCodTipoDoc</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">fFecDocumento</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">cNroDocumento</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">iCodRemitente</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">cAsunto</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">cObservaciones</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">cReferencia</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">iCodIndicacion</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nNumFolio</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nTiempoRespuesta</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nFlgEnvio</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">fFecPlazo</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nFlgRespuesta</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">iCodTupaClase</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">iCodTupa</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">fFecRegistro</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nCodBarra</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">cPassword</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nFlgEstado</th>
       <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">nFlgAnulado</th>
      </tr>
	 </thead>
     <tbody>
<?
$sql="SELECT * FROM Tra_M_Audit_Tramite ";
if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
$sql.=" WHERE [Tra_M_Audit_Tramite].fFecEvento BETWEEN  '".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and '".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."' ";
}
$_GET['cTipoEvento'];
if($_GET['cTipoEvento']!=""){
$sql.=" WHERE cTipoEvento='".$_GET['cTipoEvento']."'";
}
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;

while ($Rs=sqlsrv_fetch_array($rs)){
?>
 <tr>
	<td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[iCodEventoTramite]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[cTipoEvento]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[fFecEvento]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[usuario]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[iCodTramite]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nFlgTipoDoc]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[cCodificacion]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[iCodTrabajadorRegistro]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[cCodTipoDoc]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs['fFecDocumento']?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs['cNroDocumento']?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[iCodRemitente]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs['cAsunto']?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[cObservaciones]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[cReferencia]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[iCodIndicacion]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nNumFolio]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nTiempoRespuesta]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nFlgEnvio]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[fFecPlazo]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nFlgRespuesta]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[iCodTupaClase]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs['iCodTupa']?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs['fFecRegistro']?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nCodBarra]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[cPassword]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nFlgEstado]?></td>
    <td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[nFlgAnulado]?></td>
<?php }?>
	  </tbody>
    </table>  
