<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_tupa_pdf.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en PDF de la Tabla de Tupas
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
				<?php
				   $sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' ";
				   $rslog=sqlsrv_query($cnx,$sqllog);
				   $Rslog=sqlsrv_fetch_array($rslog);
				   echo $Rslog['cNombresTrabajador']." ".$Rslog['cApellidosTrabajador'];
				?>
                </td>
				<td style="text-align: right;	width: 60%">página [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
        <br>
        <br>
	</page_footer>
	<br><br>
	<table style="width: 100%; border: solid 0px black;">
        <tr>
            <td style="text-align: left;	width: 50%"><span style="font-size: 15px; font-weight: bold">REPORTE - TUPAS</span></td>
            <td style="text-align: right;	width: 50%"><span style="font-size: 15px; font-weight: bold"><?=date("d-m-Y")?></span></td>
        </tr>
	</table>
	<br>
	<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">CLASE TUPA</th>
                <th style="width: 35%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">NOMBRE TUPA</th>
                <th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DIAS</th>
                <th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">OFICINA</th>
                <th style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ESTADO</th>
           	</tr>
		</thead>
		<tbody>
	<?php
	    /*$sql=" SELECT * FROM  Tra_M_Tupa,Tra_M_Oficinas,Tra_M_Tupa_Clase ";
        $sql.=" WHERE Tra_M_Tupa.iCodOficina=Tra_M_Oficinas.iCodOficina AND Tra_M_Tupa.iCodTupaClase=Tra_M_Tupa_Clase.iCodTupaClase ";
        if($_GET[cNomTupa]!=""){
        $sql.=" AND Tra_M_Tupa.cNomTupa like '%$_GET[cNomTupa]%' ";
        }
        if($_GET[iCodTupaClase]!=""){
        $sql.=" AND Tra_M_Tupa.iCodTupaClase='$_GET[iCodTupaClase]' ";
        }
	    if($_GET[txtestado]!=""){
        $sql.=" AND Tra_M_Tupa.nEstado='$_GET[txtestado]' ";
        }
        $sql.="ORDER BY Tra_M_Tupa.iCodTupa ASC"; */
		$sql="SP_TUPA_LISTA '".$_GET['iCodTupaClase']."','%".$_GET['cNomTupa']."%','".$_GET['txtestado']."' , '".$_GET['orden']."','".$_GET['campo']."'";
        $rs=sqlsrv_query($cnx,$sql);
        //echo $sql;

        while ($Rs=sqlsrv_fetch_array($rs)){
	   

	?>      
		<tr>
        <td style="width: 15%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cNomTupaClase'];?></td>
        <td style="width: 35%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cNomTupa']);?>
        </td>
        <td style="width: 15%; text-align: center; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['nDias'];?></td>
        <td style="width: 15%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cNomOficina'];?>
        </td>
        <td style="width: 10%; border: solid 1px #6F6F6F;font-size:10px" >
    <?php
    if($Rs['nEstado']==1){
    		echo "<div style=color:#005E2F;text-align:center>Activo</div>";
        }else{
    		echo "<div style=color:#950000;text-align:center>Inactivo</div>";
        }
	?>
        </td>	
        </tr>
	<?php
        }
    ?>
	   	
      </tbody>
	</table>
</page>

<?php
//*************************************

    error_reporting(0);
    ini_set('display_errors', 0);
	$content = ob_get_clean();
	set_time_limit(0);
	ini_set('memory_limit', '640M');

	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('L','A4', 'es', true, 'UTF-8', 3);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('exemple03.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?> 