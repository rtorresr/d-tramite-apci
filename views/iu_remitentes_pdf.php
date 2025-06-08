<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_remitentes_pdf.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en PDF de la Tabla Remitentes
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
	<br><br>
	<table style="width: 100%; border: solid 0px black;">
	<tr>
	<td style="text-align: left;	width: 50%"><span style="font-size: 15px; font-weight: bold">REPORTE - REMITENTES</span></td>
	<td style="text-align: right;	width: 50%"><span style="font-size: 15px; font-weight: bold"><?=date("d-m-Y")?></span></td>
	</tr>
	</table>
	<br>
	<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">NOMBRE</th>
                <th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DOCUMENTO</th>
                <th style="width: 25%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DIRECCION</th>
                <th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">E-MAIL</th>
                <th style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TELEFONO</th>
                <th style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ESTADO</th>
			</tr>
		</thead>
		<tbody>
	<?	
	$sql="select  top (100) * from Tra_M_Remitente ";
$sql.=" WHERE iCodRemitente>0 ";
if($_GET['cNombre']!=""){
$sql.=" AND cNombre like '%'+'%$_GET['cNombre']%'+'%' ";
}
if($_GET['nNumDocumento']!=""){
$sql.=" AND nNumDocumento='%'+'%$_GET['nNumDocumento']%'+'%' ";
}
$sql.="ORDER BY ".$_GET['campo']." ".$_GET['orden']."  ";

	//$sql="SP_REMITENTE_LISTA  '%$_GET['cNombre']%', '%$_GET['nNumDocumento']%' ";
    $rs=sqlsrv_query($cnx,$sql);

    while ($Rs=sqlsrv_fetch_array($rs)){

 ?>
	    <tr>
        <td style="width: 15%; border: solid 1px #6F6F6F;font-size:10px">
		<?     if($Rs['cTipoPersona']=='1'){ 
			   echo "<div style=color:#000000;text-align:center>Persona Natural</div>";
               echo "<div style=color:#0154AF;font-size:10px;text-align:center>".$Rs['cNombre']."</div>";
			   }
			   else if($Rs['cTipoPersona']=='2'){
			   echo "<div style=color:#000000;text-align:center>Persona Jur�dica</div>";
               echo "<div style=color:#0154AF;font-size:10px;text-align:center>".$Rs['cNombre']."</div>";}?>
		</td>
        <td style="width: 15%; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs['nNumDocumento'];?></td>
        <td style="width: 25%; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cDireccion];?></td>
        <td style="width: 15%; text-align: justify; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cEmail];?></td>
        <td style="width: 10%; text-align: justify; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[nTelefono];?></td>
        <td style="width: 10%; text-align: justify; border: solid 1px #6F6F6F;font-size:10px">
		 <?  if($Rs[cFlag]==1){
    		 echo "<div style=color:#005E2F;text-align:center>Activo</div>";
             }else{
    	     echo "<div style=color:#950000;text-align:center>Inactivo</div>";
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