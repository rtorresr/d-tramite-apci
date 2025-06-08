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
	echo "<td bgcolor=#0000CC><font color=#ffffff> Tipo</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Trabajador de Registro</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Tipo Documento</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> N&ordm; Doc.</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Oficina Destino</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Responsable</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Delegado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Asunto</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Institucion</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Remitente</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Documento</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Derivado</td>";
	
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
	$sqlTra="SELECT * FROM Tra_M_Tramite_Movimientos		z 
WHERE Z.iCodTramite IN 
(		 
		 SELECT  iCodTramite
		 FROM [db_pcm_gob_pe_std].[dbo].[Tra_M_Tramite_Movimientos] a
		 WHERE 
				a.iCodOficinaOrigen = 303
			AND a.fFecDerivar > '2012-07-23 00:00:00.000' and a.fFecDerivar <= '2013-04-05 00:00:00.000'
			--AND a.nEstadoMovimiento!=5
			AND a.iCodTramite IN 
		 (	SELECT  d.iCodTramite 
			FROM Tra_M_Tramite_Movimientos d  
			WHERE 
				d.iCodOficinaDerivar =	303 
			AND d.nEstadoMovimiento= 2 
			AND d.fFecDerivar	>	'2012-07-23 00:00:00.000' and d.fFecDerivar <= '2013-04-05 00:00:00.000'
		  )
			AND a.iCodMovimiento IN 
			(	SELECT  b.iCodMovimiento FROM Tra_M_Tramite_Movimientos b 
				WHERE /*iCodOficinaDerivar!=12 and */  
			--	b.nEstadoMovimiento!=5  
			--AND cFlgTipoMovimiento!=5 AND 
			b.iCodTramite=a.iCodTramite 
			AND fFecMovimiento = 
			   (	SELECT MAX(fFecMovimiento) 
					FROM Tra_M_Tramite_Movimientos e 
					WHERE e.iCodTramite=b.iCodTramite 
				--		AND  b.nEstadoMovimiento!=5
				)
			)
)
	AND z.fFecMovimiento	= 
			   (	SELECT MAX(w.fFecMovimiento) 
					FROM Tra_M_Tramite_Movimientos w 
					WHERE w.iCodTramite=z.iCodTramite 
					--	AND  z.nEstadoMovimiento!=5
				)
	AND z.iCodOficinaDerivar != 303	";
   $rsTra=sqlsrv_query($cnx,$sqlTra);
  while ($RsTra=sqlsrv_fetch_array($rsTra)){
  	echo "<tr>";			
		echo "<td valign=top>";
		if($RsTra['nFlgTipoDoc']==1)
		{ echo "Entrada";
		}
		else
		{
		  echo "Interno";	
		}
		echo "</td>";
		
		echo "<td valign=top>";
		 $rsReg=sqlsrv_query($cnx,"SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra[iCodTrabajadorRegistro]."'");
          $RsReg=sqlsrv_fetch_array($rsReg);
          echo $RsReg["cApellidosTrabajador"].", ".$RsReg["cNombresTrabajador"];
			sqlsrv_free_stmt($rsReg);		
		echo "</td>";
		
			$rsDoc=sqlsrv_query($cnx,"SELECT cCodTipoDoc,cCodificacion,cAsunto,iCodRemitente,cNomRemite,fFecDocumento FROM Tra_M_Tramite WHERE iCodTramite='".$RsTra['iCodTramite']."'");
			$RsDoc=sqlsrv_fetch_array($rsDoc);
		echo "<td valign=top>";
		$rsTip=sqlsrv_query($cnx,"SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsDoc[cCodTipoDoc]'");
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
          $rsRem=sqlsrv_query($cnx,"SELECT cNombre FROM Tra_M_Remitente WHERE iCodRemitente='$RsDoc[iCodRemitente]'");
          $RsRem=sqlsrv_fetch_array($rsRem);
          echo $RsRem["cNombre"];
					sqlsrv_free_stmt($rsRem);
		echo "</td>";
		echo "<td valign=top>".$RsDoc[cNomRemite]."</td>";
		echo "<td valign=top><br>";
		echo date("d-m-Y G:i", strtotime($RsDoc['fFecDocumento']));
		echo "</td>";
		echo "<td valign=top><br>";
		echo date("d-m-Y G:i", strtotime($RsTra['fFecDerivar']));
		echo "</td>";
		
		
		
		
		
		echo "</tr>";
}
		echo "</table>"
?>