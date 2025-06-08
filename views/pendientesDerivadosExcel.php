<?
session_start();
ob_start();
/**************************************************************************************
NOMBRE DEL PROGRAMA: pendientesFinalizadosGeneralExcel.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte en EXCEL a partir de una lista de pendientes.
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ReporteDerivados.xls");
	
	$anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
	echo "<table width=780 border=0><tr><td align=center colspan=7>";
	echo "<H3>REPORTE - DERIVADOS </H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=7>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=1><tr>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Dia</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Mes</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Ano</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Tipo</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Trabajador de Registro</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Tipo Documento</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> N&ordm; Tramite</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Oficina Destino</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Responsable</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Delegado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Trab. Finaliza</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Asunto</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Nombre / Razon Social</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Remitente</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Documento</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Derivado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Recepcion</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Finalizado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Estado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Delegado Fin</td>";
	echo "</tr>";	
	
	include_once("../conexion/conexion.php");
		if($_GET['fDesde']!=""){ $fDesde=date("Ymd", strtotime($_GET['fDesde'])); }
			    if($_GET['fHasta']!=""){
				$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));

				function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    				  $date_r = getdate(strtotime($date));
    				  $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    				  return $date_result;
				}
				$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
				}

$sqlTra.= " SP_BANDEJA_DERIVADOS '".$_GET['Entrada']."','".$_GET['Interno']."','$fDesde','$fHasta','%".$_GET['cCodificacion']."%','%".$_GET['cAsunto']."%','".$_SESSION['iCodOficinaLogin']."','".$_GET['cCodTipoDoc']."','".$_GET['iCodTema']."' ,'$_GET[iCodOficinaDes]','$campo','$orden'";
//echo $sqlTra;
  $rsTra=sqlsrv_query($cnx,$sqlTra);
  while ($RsTra=sqlsrv_fetch_array($rsTra)){
  	echo "<tr>";
		echo "<td valign=top>";
		//echo date("d", strtotime($RsTra['fFecDocumento']));
		echo date("d", strtotime(substr($RsTra['fFecDocumento'], 0, -6)));
		echo "</td>";
		
		echo "<td valign=top>";
		//echo date("m", strtotime($RsTra['fFecDocumento']));
		echo date("m", strtotime(substr($RsTra['fFecDocumento'], 0, -6)));
		echo "</td>";
		
		echo "<td valign=top>";
		//echo date("Y", strtotime($RsTra['fFecDocumento']));
		echo date("Y", strtotime(substr($RsTra['fFecDocumento'], 0, -6)));
		echo "</td>";
		
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
		 $rsReg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra[iCodTrabajadorRegistro]."'");
          $RsReg=sqlsrv_fetch_array($rsReg);
          echo $RsReg["cApellidosTrabajador"].", ".$RsReg["cNombresTrabajador"];
			sqlsrv_free_stmt($rsReg);
		echo "</td>";
		
		echo "<td valign=top>".$RsTra['cDescTipoDoc']."</td>";
		
		echo "<td valign=top align=left>".$RsTra['cCodificacion']."</td>";
		
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
		echo "<td valign=top>";
		
  					$rsFin=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTra[iCodTrabajadorFinalizar]'");
          	$RsFin=sqlsrv_fetch_array($rsFin);
          	echo trim($RsFin["cApellidosTrabajador"]).", ".$RsFin["cNombresTrabajador"];
						sqlsrv_free_stmt($rsFin);
				
		echo "</td>";		
		
		echo "<td valign=top>".$RsTra['cAsunto']."</td>";
		echo "<td valign=top>";
          $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
          $RsRem=sqlsrv_fetch_array($rsRem);
          echo $RsRem["cNombre"];
					sqlsrv_free_stmt($rsRem);
		echo "</td>";
		echo "<td valign=top>".$RsTra['cNomRemite']."</td>";
		echo "<td valign=top><br>";
		//echo date("d-m-Y G:i", strtotime($RsTra['fFecDocumento']));
		echo date("d-m-Y G:i", strtotime(substr($RsTra['fFecDocumento'], 0, -6)));
		echo "</td>";
		echo "<td valign=top><br>";
		//echo date("d-m-Y G:i", strtotime($RsTra['fFecDerivar']));
		echo date("d-m-Y G:i", strtotime(substr($RsTra['fFecDerivar'], 0, -6)));
		echo "</td>";
		echo "<td valign=top>";
        	if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000;text-align:center>sin aceptar</div>";
        	}Else{
        			//echo date("d-m-Y G:i", strtotime($RsTra['fFecRecepcion']));
					echo date("d-m-Y G:i", strtotime(substr($RsTra['fFecRecepcion'], 0, -6)));
        	}
		echo "</td>";
		echo "<td valign=top>";
           			//echo date("d-m-Y G:i", strtotime($RsTra[fFecFinalizar]));
					echo date("d-m-Y G:i", strtotime(substr($RsTra[fFecFinalizar], 0, -6)));
		echo "</td>";
		
		echo "<td valign=top>";
        	 if($RsTra['cFlgTipoMovimiento']!=6){	
				 if($RsTra['fFecRecepcion']!=""){
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
				 }else {
					 if($RsTra['nFlgTipoDoc']==3){
					 echo "";
					 }
					 else {echo "Pendiente";}
				 }
				  }else { echo "";}
					
		echo "</td>";
		echo "</td>";
		echo "<td valign=top>";
        	if($RsTra['fFecDelegadoRecepcion']==""){
        			echo "";
        	}Else{
        			//echo date("d-m-Y G:i", strtotime($RsTra['fFecDelegadoRecepcion']));
					echo date("d-m-Y G:i:s", strtotime(substr($RsTra['fFecDelegadoRecepcion'], 0, -6)));
        	}
		echo "</td>";
		echo "</tr>";
}
		echo "</table>"
?>