<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Exportar a PDF desde Pendientes de Profesional
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
ob_start();

//*************************************
?>
<page backtop="25mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header>
		<table style="width: 100%; border: solid 0px black;">
			<tr>
				<td style="text-align: center;	width: 100%">
					<img style="width: 93%;" src="images/pdf_head.jpg" alt="Logo">
				</td>
			</tr>
		</table>
	</page_header>
	<page_footer>
		<table style="width: 100%; border: solid 0px black;">
			<tr>
				<td style="text-align: right;	width: 100%">p�gina [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
	</page_footer>
	
	
	<table style="width: 100%; border: solid 0px black;">
	<tr>
	<td style="text-align: left;	width: 50%"><span style="font-size: 15px; font-weight: bold">Reporte Pendientes</span></td>
	<td style="text-align: right;	width: 50%"><span style="font-size: 15px; font-weight: bold"><?=date("d-m-Y")?></span></td>
	</tr>
	</table>
	<br>
	<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 10%; text-align: center; border: solid 1px #2D96FF; background: #E1F0FF">N&ordm; Doc.</th>
				<th style="width: 20%; text-align: center; border: solid 1px #2D96FF; background: #E1F0FF">R.Social</th>
				<th style="width: 30%; text-align: center; border: solid 1px #2D96FF; background: #E1F0FF">Asunto</th>
				<th style="width: 10%; text-align: center; border: solid 1px #2D96FF; background: #E1F0FF">Derivado</th>
				<th style="width: 10%; text-align: center; border: solid 1px #2D96FF; background: #E1F0FF">Recepción</th>
				<th style="width: 15%; text-align: center; border: solid 1px #2D96FF; background: #E1F0FF">Responsable</th>
				<th style="width: 5%; text-align: center; border: solid 1px #2D96FF; background: #E1F0FF">Est.</th>
			</tr>
		</thead>
		<tbody>
				<?
				include_once("../conexion/conexion.php");
				$fDesde=date("Ymd", strtotime($_GET['fDesde']));
			 	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));

				function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    				  $date_r = getdate(strtotime($date));
    				  $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    				  return $date_result;
				}
				$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
				
				$sqlTra="SELECT * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos ";
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
        $sqlTra.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' ";
        $sqlTra.="AND Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' ";
        $sqlTra.= "ORDER BY Tra_M_Tramite.iCodTramite DESC";
        $rsTra=sqlsrv_query($cnx,$sqlTra);
        while ($RsTra=sqlsrv_fetch_array($rsTra)){
        ?>
			<tr>
				<td style="width: 10%; text-align: center; border: solid 1px #2D96FF;font-size:10px"><?=$RsTra['cCodificacion']?></td>
				<td style="width: 20%; text-align: left; border: solid 1px #2D96FF;font-size:10px">
					<?
          $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
          $RsRem=sqlsrv_fetch_array($rsRem);
          echo $RsRem["cNombre"];
					sqlsrv_free_stmt($rsRem);
        	?>
				</td>
				<td style="width: 30%; text-align: left; border: solid 1px #2D96FF;font-size:10px"><?=$RsTra['cAsunto']?></td>
				<td style="width: 10%; border: solid 1px #2D96FF;font-size:10px">
					<div style="text-align:center"><?=date("d-m-Y", strtotime($RsTra['fFecDerivar']));?></div>
        	<div style="text-align:center"><?=date("G:i", strtotime($RsTra['fFecDerivar']));?></div>
				</td>
				<td style="width: 10%; border: solid 1px #2D96FF;font-size:10px">
					<?
        	if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000;text-align:center>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF;text-align:center>".date("d-m-Y", strtotime($RsTra['fFecRecepcion']))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px;text-align:center>".date("G:i", strtotime($RsTra['fFecRecepcion']))."</div>";
        	}
        	?>
				</td>
				<td style="width: 15%; text-align: center; border: solid 1px #2D96FF;font-size:10px">
					<?
          $rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra['iCodTrabajadorDerivar']."'");
          $RsResp=sqlsrv_fetch_array($rsResp);
          echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
					sqlsrv_free_stmt($rsResp);
        	?>
				</td>
				<td style="width: 5%; text-align:center; border: solid 1px #2D96FF;font-size:10px">
					<?
        	switch ($RsTra['nEstadoMovimiento']){
  				case 1:
  					echo "Pnd";
  				break;
  				case 2:
  					echo "Der";
  				break;
  				case 3:
  					echo "Del";
  				break;
  				case 4:
  					echo "Res";
  				break;
  				case 5:
  					echo "Fin";
  				break;
  				}
  				?>
				</td>
			</tr>
<?
}
?>
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
		$html2pdf = new HTML2PDF('P','A4', 'es', false, 'UTF-8', 3);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('exemple03.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>