<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte en EXCEL a partir de una lista de pendientes.
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ReportePendientes.xls");
	
	$anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
	echo "<table width=780 border=0><tr><td align=center colspan=7>";
	echo "<H3>REPORTE - PENDIENTES</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=7>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=1><tr>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> OFICINA</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> CANTIDAD.</td>";
	echo "</tr>";	
	
	include_once("../conexion/conexion.php");
		if($_GET['fDesde']!=""){ $fDesde=date("Y-m-d", strtotime($_GET['fDesde'])); }
			    if($_GET['fHasta']!=""){
				$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));

				function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    				  $date_r = getdate(strtotime($date));
    				  $date_result = date("Y-m-d", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    				  return $date_result;
				}
				$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
				}

  $sqlTra= "select  iCodOficina,count(cNombresTrabajador) as Total from Tra_M_Trabajadores
where Tra_M_Trabajadores.nFlgEstado=1 
group  by iCodOficina ";
  $rsTra=sqlsrv_query($cnx,$sqlTra);
  while ($RsTra=sqlsrv_fetch_array($rsTra)){
  	echo "<tr>";
		echo "<td valign=top>";
           $sqlSig="SP_OFICINA_LISTA_AR '$RsTra['iCodOficina']'";
			  $rsSig=sqlsrv_query($cnx,$sqlSig);
              $RsSig=sqlsrv_fetch_array($rsSig);
                echo $RsSig["cNomOficina"];
		echo "</td>";
		
		echo "<td valign=top>";
         echo $RsTra[Total];
		echo "</td>";
		echo "</tr>";
}
		echo "</table>"
?>