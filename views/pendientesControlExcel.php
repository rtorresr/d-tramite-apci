<? header('Content-Type: text/html; charset=UTF-8');
//ARTURO
session_start();
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte en EXCEL a partir de una lista de pendientes.
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creación del programa.
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
	echo "<td bgcolor=#0000CC><font color=#ffffff> Dia</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Mes</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Ano</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Tipo</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> N&ordm; Doc.</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Derivado por</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Responsable</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Delegado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Asunto</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Institucion</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Remitente</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Documento</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Derivado</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Recepción</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Avance</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Copia</td>";
	echo "<td bgcolor=#0000CC><font color=#ffffff> Est.</td>";
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
/*	$sqlTra="SELECT * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos ";
  $sqlTra.="WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
  if($_GET['Entrada']==1 AND $_GET['Interno']==""){
  $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=1 ";
  }
  if($_GET['Entrada']=="" AND $_GET['Interno']==1){
   $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=2 ";
  }
  if($_GET['Entrada']==1 AND $_GET['Interno']==1){
   $sqlTra.="AND (Tra_M_Tramite.nFlgTipoDoc=1 OR Tra_M_Tramite.nFlgTipoDoc=2) ";
  }
  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	$sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar>'$fDesde' ";
  }
  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	$sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar<='$fHasta' ";
  }
  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	$sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar BETWEEN '$fDesde' AND '$fHasta' ";
  }
  if($_GET['cCodificacion']!=""){
   $sqlTra.="AND Tra_M_Tramite.cCodificacion='".$_GET['cCodificacion']."' ";
  }
  if($_GET['cAsunto']!=""){
   $sqlTra.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
  }
  if($_GET['cCodTipoDoc']!=""){
   $sqlTra.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
  }
  if($_GET['iCodTrabajadorDelegado']!=""){
   $sqlTra.="AND Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='$_GET['iCodTrabajadorDelegado']' ";
  }
  if($_GET['EstadoMov']==""){
   $sqlTra.="AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3) ";
  }Else{
  		if($_GET['EstadoMov']==1){
   		$sqlTra.="AND Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 ";
   	}
   	if($_GET['EstadoMov']==2){
   		$sqlTra.="AND Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 ";
   	}
   	if($_GET['EstadoMov']==3){
   		$sqlTra.="AND Tra_M_Tramite_Movimientos.fFecRecepcion!='' ";
   	}
  }
  $sqlTra.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar='$_GET['iCodOficina']' ";
  $sqlTra.= "ORDER BY Tra_M_Tramite.iCodTramite DESC";*/
  $sqlTra= " SP_BANDEJA_PENDIENTES  '$fDesde','$fHasta','".$_GET['Entrada']."','".$_GET['Interno']."','$_GET['Anexo']','%".$_GET['cCodificacion']."%', ";
  //ARTURO
  $sqlTra.= "'%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','$_GET['iCodTrabajadorResponsable']','$_GET['iCodTrabajadorDelegado']','".$_GET['iCodTema']."','$_GET['EstadoMov']','$_GET['Aceptado']','$_GET['SAceptado']', '".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
 
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
		
		echo "<td valign=top>".$RsTra['cCodificacion']."</td>";
		
		echo "<td valign=top>";
           $sqlSig="SP_OFICINA_LISTA_AR '$RsTra[iCodOficinaOrigen]'";
			  $rsSig=sqlsrv_query($cnx,$sqlSig);
              $RsSig=sqlsrv_fetch_array($rsSig);
                echo $RsSig["cNomOficina"];
		echo "</td>";
		
		echo "<td valign=top>";
          $rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra['iCodTrabajadorDerivar']."'");
          $RsResp=sqlsrv_fetch_array($rsResp);
          echo trim($RsResp["cApellidosTrabajador"])." ".$RsResp["cNombresTrabajador"];
					sqlsrv_free_stmt($rsResp);
		echo "</td>";
		
		echo "<td valign=top>";
        					$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_GET['iCodTrabajadorDelegado']."'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	echo trim($RsDelg["cApellidosTrabajador"]).", ".$RsDelg["cNombresTrabajador"];
						sqlsrv_free_stmt($rsDelg);					
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
		//echo date("d-m-Y", strtotime($RsTra['fFecDocumento']))." ".date("h:i A", strtotime($RsTra['fFecDocumento']));
		echo date("d-m-Y G:i:s", strtotime(substr($RsTra['fFecDocumento'], 0, -6)));
		
		echo "</td>";
		echo "<td valign=top><br>";
		//echo date("d-m-Y", strtotime($RsTra['fFecDerivar']))." ".date("h:i A", strtotime($RsTra['fFecDerivar']));
		echo date("d-m-Y G:i:s", strtotime(substr($RsTra['fFecDerivar'], 0, -6)));
		
		echo "</td>";
		echo "<td valign=top>";
        	if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000;text-align:center>sin aceptar</div>";
        	}Else{
			/* date("d-m-Y", strtotime($RsTra['fFecRecepcion']))." ".date("h:i A", strtotime($RsTra['fFecRecepcion']))*/
        			echo "<div style=color:#0154AF;text-align:center>".date("d-m-Y G:i:s", strtotime(substr($RsTra['fFecDerivar'], 0, -6)))."</div>";
        	   	}
		echo "</td>";
		echo "<td valign=top>";
        	$sqlAvan="SELECT TOP(1) * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento='$RsTra['iCodMovimiento']' ORDER BY iCodAvance DESC";
            		$rsAvan=sqlsrv_query($cnx,$sqlAvan);
					if(sqlsrv_has_rows($rsAvan)>0){
            		$RsAvan=sqlsrv_fetch_array($rsAvan);
						echo "<div style=font-size:10px>".$RsAvan[cObservacionesAvance]."</div>";
					}
					
		echo "</td>";
		echo "<td valign=top>";
        	if($RsTra['cFlgTipoMovimiento']==4){
				echo "COPIA";
			}	
			else{
				echo "ORIGINAL";
					}
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
		echo "</tr>";
}
		echo "</table>"
?>