<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaTramiteCargo_pdf.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte General en PDF de los Documentos de Cargos
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0  Larry Ortiz          05/09/2018      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
ob_start();
//*************************************
include_once("../conexion/conexion.php");
?>
<page backtop="15mm" backbottom="15mm" backleft="10mm" backright="10mm">
	<page_header>
		<br>
		<table style="width: 1000px; border: solid 0px black;">
			<tr>
				<td style="text-align:left;	width: 20px"></td>
				<td style="text-align:left;	width: 980px">
					<img style="width: 220px" src="images/cab.jpg" alt="Logo">
				</td>
			</tr>
		</table>
        <br><br>
	</page_header>
	<page_footer>
		<table style="width: 100%; border: solid 0px black;">
			<tr>
                <td style="text-align: center;	width: 40%">
				<? 
				   $sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' ";
				   $rslog=sqlsrv_query($cnx,$sqllog);
				   $Rslog=sqlsrv_fetch_array($rslog);
				   echo $Rslog[cNombresTrabajador]." ".$Rslog[cApellidosTrabajador];
				?></td>
				<td style="text-align: right;	width: 60%">p�gina [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
        <br>
        <br>
	</page_footer>
	
	<table style="width: 1000px; border: solid 0px black;">
	<tr>
	<td style="text-align:center;width:1000px"><span style="font-size: 15px; font-weight: bold">REPORTE - DERIVADOS</span></td>
	</tr>
	</table>
	<br><br>
	<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
          <thead>
            <tr>
              <th style="width: 4%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Tipo</th>
              <th style="width: 9%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Tipo Documento</th>
              <th style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">N&ordm; Doc.</th>
              <th style="width: 12%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Oficina Destino</th>
              <th style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Responsable</th>
              <th style="width: 7%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Trab. Finaliza</th>
              <th style="width: 13%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Asunto</th>
              <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Recepción</th>
              <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Finalizado</th>
              <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Estado</th>
              <th style="width: 11%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Comentario</th>
			</tr>
		 </thead>
	 <tbody>
		<?
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
  $rsTra=sqlsrv_query($cnx,$sqlTra);
 // echo $sqlTra;
  while ($RsTra=sqlsrv_fetch_array($rsTra)){
				 ?>
					 <tr>
				      <td style="width:4%;text-align:center;border: solid 1px #6F6F6F;font-size:10px;">
					  <? 
					  if($RsTra['nFlgTipoDoc']==1) { echo "Entrada"; }else { echo "Interno";}?></td>
				      <td style="width:9%;text-align:center;border: solid 1px #6F6F6F;font-size:10px;text-transform:uppercase;"><?=$RsTra['cDescTipoDoc']?></td>
					   <td style="width:10%;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$RsTra['cCodificacion']?></td>
                       <td style="width:12%;text-align:left;border: solid 1px #6F6F6F;font-size:10px;">
					   <?  
					   $sqlSig="SP_OFICINA_LISTA_AR '".$RsTra['iCodOficinaDerivar']."'";
			  		   $rsSig=sqlsrv_query($cnx,$sqlSig);
              		   $RsSig=sqlsrv_fetch_array($rsSig);
                	   echo $RsSig["cNomOficina"];
					   ?></td>
                       <td style="width:10%;text-align:left;border: solid 1px #6F6F6F;font-size:10px;">
					   <?  
					   $rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra['iCodTrabajadorDerivar']."'");
          			   $RsResp=sqlsrv_fetch_array($rsResp);
          			   echo trim($RsResp["cApellidosTrabajador"]).", ".$RsResp["cNombresTrabajador"];
					   sqlsrv_free_stmt($rsResp);
					   ?></td>
					   <td style="width:7%;text-align:left;border: solid 1px #6F6F6F;font-size:10px;">
					   <? 
					   $rsFin=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTra[iCodTrabajadorFinalizar]'");
          			   $RsFin=sqlsrv_fetch_array($rsFin);
          			   echo trim($RsFin["cApellidosTrabajador"]).", ".$RsFin["cNombresTrabajador"];
					   sqlsrv_free_stmt($rsFin);
					   ?></td> 
                       <td style="width:13%;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$RsTra['cAsunto']?></td> 
                      <td  style="width:8%;text-align:center;border: solid 1px #6F6F6F;font-size:10px;text-transform:uppercase">
					  <? 
				  if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000;text-align:center>sin aceptar</div>";
        		  }Else{
        			echo "<div style=color:#0154AF;>".date("d-m-Y G:i:s", strtotime(substr($RsTra['fFecRecepcion'], 0, -6)))/*date("d-m-Y", strtotime($RsTra['fFecRecepcion']))*/."</div>";
        			//echo "<div style=color:#0154AF;font-size:10px;>".date("h:i A", strtotime($RsTra['fFecRecepcion']))."</div>";
        		  }
			 		?></td> 
                    <td style="width:8%;text-align:center;border: solid 1px #6F6F6F;font-size:10px;text-transform:uppercase">
					<?
					echo "<div style=color:#0154AF;>".date("d-m-Y G:i:s", strtotime(substr($RsTra[fFecFinalizar], 0, -6)))/*date("d-m-Y", strtotime($RsTra[fFecFinalizar]))*/."</div>";
        			//echo "<div style=color:#0154AF;font-size:10px;>".date("h:i A", strtotime($RsTra[fFecFinalizar]))."</div>"; 
					?></td> 
                    <td style="width:8%;text-align:center;border: solid 1px #6F6F6F;font-size:10px;text-transform:uppercase">
					<?php
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
					?></td> 
         <td style="width:11%;text-align:center;left: solid 1px #6F6F6F;font-size:10px;"><?=$RsTra[cObservacionesFinalizar]?></td>
		</tr>
						  <?php }?>
						  </tbody>
							 </table>
</page>

<?
//*************************************


	$content = ob_get_clean();  set_time_limit(0);     ini_set('memory_limit', '640M');

	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('L','A4', 'es', false, 'UTF-8', 3);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('exemple03.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>   
         		
