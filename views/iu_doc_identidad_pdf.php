<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_doc_identidad_pdf.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en PDF de la Tabla Documentos de Identidad
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   Larry Ortiz        05/09/2018      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
ob_start();
//*************************************
 include_once("../conexion/conexion.php"); 
?>
<page backtop="25mm" backbottom="10mm" backleft="10mm" backright="10mm">
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
	
	
	<table style="width: 100%; border: solid 0px black;">
	<tr>
	<td style="text-align: left;	width: 50%"><span style="font-size: 15px; font-weight: bold">REPORTE - DOCUMENTOS DE IDENTIDAD</span></td>
	<td style="text-align: right;	width: 50%"><span style="font-size: 15px; font-weight: bold"><?=date("d-m-Y")?></span></td>
	</tr>
	</table>
	<br>
	<table style="width: 60%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 40%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TIPO</th>
         	</tr>
		</thead>
		<tbody>
	<?
      $sql= " SP_DOC_IDENTIDAD_LISTA '%$_GET[cDescDocIdentidad]%' ,'".$orden."' , '".$campo."' ";
       $rs=sqlsrv_query($cnx,$sql);
       while ($Rs=sqlsrv_fetch_array($rs)){
	    ?>
		<tr>
          <td style="width: 40%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cDescDocIdentidad];?></td>
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
