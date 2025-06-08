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
	echo "<td bgcolor=#0000CC><font color=#ffffff> Trabajador de Registro</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Documento Principal</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Tipo Documento</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> N&ordm; Doc.</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Oficina Destino</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Responsable</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Asunto</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Institucion</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Remitente</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Documento</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Derivado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Recepci�n</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Est.</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Delegado</td>";
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
	$sqlTra=" 		SELECT DISTINCT  t.cCodTipoDoc,t.iCodOficinaRegistro,t.iCodTrabajadorRegistro,t.iCodTramite ,t.cCodificacion, t.iCodOficinaRegistro,
( CASE 
	WHEN t.nFlgEstado =1  THEN 'PENDIENTE' 
	WHEN t.nFlgEstado =2  THEN 'PROCESO'
	WHEN t.nFlgEstado =3  THEN 'FINALIZADO'
  END) AS EstadoDocumento ,
   (SELECT a.nEstadoMovimiento FROM Tra_M_Tramite_Movimientos a
   WHERE a.iCodTramite = t.iCodTramite 
			AND a.fFecDerivar	>	'2012-07-23 00:00:00.000' and a.fFecDerivar <= '2013-04-06 00:00:00.000'
		  	AND a.fFecDerivar = 
			   (	SELECT MAX(e.fFecDerivar) 
					FROM Tra_M_Tramite_Movimientos e 
					WHERE e.iCodTramite=a.iCodTramite 
				)
			 AND a.iCodMovimiento =
				(
				SELECT MAX(w.iCodMovimiento) 
				FROM Tra_M_Tramite_Movimientos w 
				WHERE w.iCodTramite=a.iCodTramite 				
				)	
			)	as nEstadoMovimiento,	
	(SELECT a.iCodOficinaDerivar FROM Tra_M_Tramite_Movimientos a
   WHERE a.iCodTramite = t.iCodTramite 
			AND a.fFecDerivar	>	'2012-07-23 00:00:00.000' and a.fFecDerivar <= '2013-04-06 00:00:00.000'
		  	AND a.fFecDerivar = 
			   (	SELECT MAX(e.fFecDerivar) 
					FROM Tra_M_Tramite_Movimientos e 
					WHERE e.iCodTramite=a.iCodTramite 
				)
			 AND a.iCodMovimiento =
				(
				SELECT MAX(w.iCodMovimiento) 
				FROM Tra_M_Tramite_Movimientos w 
				WHERE w.iCodTramite=a.iCodTramite 				
				)	
			)	as iCodOficinaDerivar	
,	
	(SELECT a.iCodTrabajadorDerivar FROM Tra_M_Tramite_Movimientos a
   WHERE a.iCodTramite = t.iCodTramite 
			AND a.fFecDerivar	>	'2012-07-23 00:00:00.000' and a.fFecDerivar <= '2013-04-06 00:00:00.000'
		  	AND a.fFecDerivar = 
			   (	SELECT MAX(e.fFecDerivar) 
					FROM Tra_M_Tramite_Movimientos e 
					WHERE e.iCodTramite=a.iCodTramite 
				)
			 AND a.iCodMovimiento =
				(
				SELECT MAX(w.iCodMovimiento) 
				FROM Tra_M_Tramite_Movimientos w 
				WHERE w.iCodTramite=a.iCodTramite 				
				)	
			)	as iCodTrabajadorDerivar
,	
	(SELECT a.fFecDerivar FROM Tra_M_Tramite_Movimientos a
   WHERE a.iCodTramite = t.iCodTramite 
			AND a.fFecDerivar	>	'2012-07-23 00:00:00.000' and a.fFecDerivar <= '2013-04-06 00:00:00.000'
		  	AND a.fFecDerivar = 
			   (	SELECT MAX(e.fFecDerivar) 
					FROM Tra_M_Tramite_Movimientos e 
					WHERE e.iCodTramite=a.iCodTramite 
				)
			 AND a.iCodMovimiento =
				(
				SELECT MAX(w.iCodMovimiento) 
				FROM Tra_M_Tramite_Movimientos w 
				WHERE w.iCodTramite=a.iCodTramite 				
				)	
			)	as fFecDerivar	,	
	(SELECT a.fFecRecepcion FROM Tra_M_Tramite_Movimientos a
   WHERE a.iCodTramite = t.iCodTramite 
			AND a.fFecDerivar	>	'2012-07-23 00:00:00.000' and a.fFecDerivar <= '2013-04-06 00:00:00.000'
		  	AND a.fFecDerivar = 
			   (	SELECT MAX(e.fFecDerivar) 
					FROM Tra_M_Tramite_Movimientos e 
					WHERE e.iCodTramite=a.iCodTramite 
				)
			 AND a.iCodMovimiento =
				(
				SELECT MAX(w.iCodMovimiento) 
				FROM Tra_M_Tramite_Movimientos w 
				WHERE w.iCodTramite=a.iCodTramite 				
				)	
			)	as fFecRecepcion
			
FROM Tra_M_Tramite t LEFT JOIN Tra_M_Tramite_Movimientos m ON t.iCodTramite=m.iCodTramite 
WHERE iCodOficinaRegistro = 303
AND cCodTipoDoc = 15
AND fFecDerivar > '2012-07-23 00:00:00.000' and fFecDerivar <= '2013-04-06 00:00:00.000'
";
 
  $rsTra=sqlsrv_query($cnx,$sqlTra);
  while ($RsTra=sqlsrv_fetch_array($rsTra)){
  	echo "<tr>";			
		
		echo "<td valign=top>";
		 $rsReg=sqlsrv_query($cnx,"SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra[iCodTrabajadorRegistro]."'");
          $RsReg=sqlsrv_fetch_array($rsReg);
          echo $RsReg["cApellidosTrabajador"].", ".$RsReg["cNombresTrabajador"];
			sqlsrv_free_stmt($rsReg);		
		echo "</td>";
		
			$rsDoc=sqlsrv_query($cnx,"SELECT cAsunto,iCodRemitente,cNomRemite,fFecDocumento FROM Tra_M_Tramite WHERE iCodTramite='".$RsTra['iCodTramite']."'");
			$RsDoc=sqlsrv_fetch_array($rsDoc);
		
		//----- Documento Principal --------//
		echo "<td valign=top>";
		if($RsTra[cCodTipoDoc]!=45){echo $RsTra['cCodificacion']; }
		else{
		$rsDev=sqlsrv_query($cnx,"select iCodTramite from Tra_M_Tramite_Movimientos where iCodTramiteDerivar ='".$RsTra['iCodTramite']."'");
          $RsDev=sqlsrv_fetch_array($rsDev);
			$rsDev2=sqlsrv_query($cnx,"select cCodificacion,cCodTipoDoc from Tra_M_Tramite_Movimientos where iCodTramite ='".$RsDev[iCodTramite]."'");
			$RsDev2=sqlsrv_fetch_array($rsDev2);
			$sqlTip2="SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc ='".$RsDev2[cCodTipoDoc]."'";
			echo $sqlTip2;
		  $rsTip2=sqlsrv_query($cnx,"SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc ='".$RsDev2[cCodTipoDoc]."'");
		  $RsTip2=sqlsrv_fetch_array($rsTip2);
          echo $RsTip2["cDescTipoDoc"]." ".$RsDev2["cCodificacion"];
					sqlsrv_free_stmt($rsTip2);
				}
		echo "</td>";
		//---------------------------------//	
		
		echo "<td valign=top>";
		$rsTip=sqlsrv_query($cnx,"SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'");
          $RsTip=sqlsrv_fetch_array($rsTip);
          echo $RsTip["cDescTipoDoc"];
					sqlsrv_free_stmt($rsTip);
		echo "</td>";
		
		echo "<td valign=top>".$RsDoc[cCodificacion]."</td>";
		
		echo "<td valign=top>";
           $sqlSig="SP_OFICINA_LISTA_AR '".$RsTra['iCodOficinaDerivar']."'";
			  $rsSig=sqlsrv_query($cnx,$sqlSig);
              $RsSig=sqlsrv_fetch_array($rsSig);
                echo $RsSig["cNomOficina"];
		echo "</td>";
		
		echo "<td valign=top>";
          $rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra['iCodTrabajadorDerivar']."'");
          $RsResp=sqlsrv_fetch_array($rsResp);
          echo trim($RsResp["cApellidosTrabajador"]).", ".$RsResp["cNombresTrabajador"];
					sqlsrv_free_stmt($rsResp);
		echo "</td>";
		
		echo "<td valign=top>";
		
  					$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_GET['iCodTrabajadorDelegado']."'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	echo trim($RsDelg["cApellidosTrabajador"]).", ".$RsDelg["cNombresTrabajador"];
						sqlsrv_free_stmt($rsDelg);
				
		echo "</td>";		
		
		echo "<td valign=top>".$RsDoc['cAsunto']."</td>";
		echo "<td valign=top>";
         
		echo "</td>";
		echo "<td valign=top></td>";
		echo "<td valign=top><br>";	
		echo "</td>";
		echo "<td valign=top><br>";
		echo date("d-m-Y G:i", strtotime($RsTra['fFecDerivar']));
		echo "</td>";
		echo "<td valign=top>";
        	if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000;text-align:center>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF;text-align:center>".date("d-m-Y G:i", strtotime($RsTra['fFecRecepcion']))."</div>";
        	}
		echo "</td>";
		
		echo "<td valign=top>";
        					
                 switch ($RsTra['nEstadoMovimiento']) {
  						case 1:
  							echo "En Proceso";
  						break;
  						case 2:
  							echo "Derivado";
  						break;
  						case 3:
  							echo "Delegado";
  						break;
						case 4:
  							echo "Respondido";
  						break;
  						case 5:
  							echo "Finalizado";
  						break;
  						}
				
				 
					
		echo "</td>";
		echo "</td>";
		echo "<td valign=top>";
        	
		echo "</td>";
		
		echo "</tr>";
}
		echo "</table>"
?>