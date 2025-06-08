<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
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
	echo "<td bgcolor=#0000CC><font color=#ffffff> Proceso</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 1</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 2</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 3</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 4</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 5</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 6</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 7</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 8</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 9</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 10</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 11</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 12</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Envio 13</td>";
	echo "</tr>";	
	
	include_once("../conexion/conexion.php");
	
	$sqlMov="SELECT iCodTramite,cCodificacion, fFecRegistro FROM Tra_M_Tramite where nFlgTipoDoc=1 and ffecregistro between '01-01-2013' and '02-01-2013'";
	$rsMov=sqlsrv_query($cnx,$sqlMov);
	while ($RsMov=sqlsrv_fetch_array($rsMov)){
		$sqlTra=" 	SELECT  O1.cSiglaOficina as Origen, O2.cSiglaOficina as Destino, M.fFecDerivar , W.cNombresTrabajador,W.cApellidosTrabajador 
					FROM Tra_M_Tramite T INNER JOIN Tra_M_Tramite_Movimientos M ON T.iCodTramite = M.iCodTramite
					INNER JOIN Tra_M_Oficinas O1 ON M.iCodOficinaOrigen = O1.iCodOficina  
					INNER JOIN Tra_M_Oficinas O2 ON M.iCodOficinaDerivar = O2.iCodOficina 
					INNER JOIN Tra_M_Trabajadores W ON M.iCodTrabajadorDerivar = W.iCodTrabajador
					WHERE T.iCodTramite = '".$RsMov["iCodTramite"]."'
					ORDER BY iCodMovimiento ASC";
		$rsTra=sqlsrv_query($cnx,$sqlTra);
		
		$i=1;
		echo "<tr>";			
				echo "<td valign=top>";
					echo $RsMov["cCodificacion"]." ( ".$RsMov["fFecRegistro"]." ) ";
				echo "</td>";	
				while ($RsTra=sqlsrv_fetch_array($rsTra))
				{
				echo "<td valign=top>";
					echo "<p>".$RsTra["Origen"]." - ".$RsTra["Destino"]."\r\n".$RsTra["cNombresTrabajador"]."  ".$RsTra["cApellidosTrabajador"]."\r\n".$RsTra["fFecDerivar"]."</p>";
				echo "</td>";
				$i++;
				}		
		echo "</tr>";	
	}	
  	echo "</table>";
?>