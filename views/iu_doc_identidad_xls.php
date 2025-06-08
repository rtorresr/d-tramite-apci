<?
session_start();
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_doc_identidad_xls.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL  de la Tabla Documentos de Identidad
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   Larry Ortiz        05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
include_once("../conexion/conexion.php");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=iu_usuario_xls.xls");

    $anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");

    echo "<table width=780 border=0><tr><td align=center colspan=3>";
	echo "<H3>REPORTE - DOCUMENTOS DE IDENTIDAD</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=3>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=left colspan=3>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador=".$_SESSION['CODIGO_TRABAJADOR'];    
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog[cNombresTrabajador]." ".$Rslog[cApellidosTrabajador];
	echo " ";
?>
     <table style="width: 780px;border: solid 1px #5544DD; border-collapse: collapse" align="center">
     <thead>
      <tr>
       <th colspan="3" style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TIPO</th>
      </tr>
	 </thead>
     <tbody>
	<?
    $sql= " SP_DOC_IDENTIDAD_LISTA '%$_GET[cDescDocIdentidad]%' ,'".$_GET['orden']."' , '".$_GET['campo']."' ";
    $rs=sqlsrv_query($cnx,$sql);
	while ($Rs=sqlsrv_fetch_array($rs)){
	?>
	 <tr>
		<td colspan="3" style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?=$Rs[cDescDocIdentidad]?></td>
	 </tr>
<?php }?>
	  </tbody>
    </table>  