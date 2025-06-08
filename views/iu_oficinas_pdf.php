<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_oficinas_pdf.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en PDF de la Tabla Oficinas
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
<page backtop="25mm" backbottom="15mm" backleft="10mm" backright="10mm">
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
	<td style="text-align: left;	width: 50%"><span style="font-size: 15px; font-weight: bold">REPORTE - OFICINAS</span></td>
	<td style="text-align: right;	width: 50%"><span style="font-size: 15px; font-weight: bold"><?=date("d-m-Y")?></span></td>
	</tr>
	</table>
	<br>
	<table style="width: 80%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 50%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">OFICINA</th>
				<th style="width: 20%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">SIGLA</th>
                <th style="width: 40%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">UBICACION</th>
			</tr>
		</thead>
		<tbody>
	<?
	    /*
       $sql="select * from Tra_M_Oficinas,Tra_M_Ubicacion_Oficina ";
       $sql.=" WHERE Tra_M_Oficinas.iCodUbicacion=Tra_M_Ubicacion_Oficina.iCodUbicacion ";
       if($_GET[cNomOficina]!=""){
       $sql.=" AND cNomOficina like '%$_GET[cNomOficina]%' ";
       }
       if($_GET[cSiglaOficina]!=""){
       $sql.=" AND cSiglaOficina='$_GET[cSiglaOficina]' ";
       }
	   if($_GET[cTipoUbicacion]!=""){
       $sql.=" AND Tra_M_Ubicacion_Oficina.iCodUbicacion='$_GET[cTipoUbicacion]'";
       }
       $sql.="ORDER BY iCodOficina ASC";*/
	   $sql="SP_OFICINA_LISTA '%$_GET[cNomOficina]%','$_GET[cSiglaOficina]','$_GET[cTipoUbicacion]' ,'$_GET[iFlgEstado]' ,'".$orden."' , '".$campo."' ";	  
	   $rs=sqlsrv_query($cnx,$sql);	

       while ($Rs=sqlsrv_fetch_array($rs)){

    ?>
		<tr>
        <td style="width: 50%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?php echo $Rs[cNomOficina];?></td>
        <td style="width: 20%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cSiglaOficina];?></td>
        <td style="width: 30%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cNomUbicacion];?></td>
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
         		
