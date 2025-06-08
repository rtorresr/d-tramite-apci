<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_tipo_doc_xls.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL  de la Tabla Tipo de Documentos
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

    echo "<table width=780 border=0><tr><td align=center colspan=6>";
	echo "<H3>REPORTE - TIPO DE DOCUMENTOS</H3>";
	echo " ";

    echo "<table width=780 border=0><tr><td align=right colspan=6>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=left colspan=4>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='$traRep' "; 
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE  (nFlgInterno=1 or nFlgSalida=1 )  and  cCodTipoDoc='$_REQUEST[cCodTipoDoc]' ";
    $sqlTipo.="ORDER BY cDescTipoDoc ASC  ";
    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
	$RsTipo=sqlsrv_fetch_array($rsTipo);
	echo "GENERADO POR : ".$Rslog[cNombresTrabajador]." ".$Rslog[cApellidosTrabajador];
	echo "<br>Tipo de Documento : ".$RsTipo['cDescTipoDoc'];
	echo " ";
?>
<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Oficinas</th>
           	</tr>
		</thead>
		<tbody>
<?
    /* $sql="select * from Tra_M_Tipo_Documento ";
    $sql.=" WHERE cCodTipoDoc>0 ";
    if($_GET['cDescTipoDoc']!=""){
    $sql.=" AND cDescTipoDoc like '%$_GET['cDescTipoDoc']%' ";
    }
    if($_GET[cSiglaDoc]!=""){
    $sql.=" AND cSiglaDoc='$_GET[cSiglaDoc]' ";
    }
    $sql.="ORDER BY cCodTipoDoc ASC"; */
//	$sql="SP_TIPO_DOCUMENTO_LISTA '".$_GET['Entrada']."' , '".$_GET['Interno']."', '$_GET[Salida]' , '%$_GET['cDescTipoDoc']%' , '%$_GET[cSiglaDoc]%'  ,'".$orden."' , '".$campo."' ";
    $sql="SP_DOC_OFICINA_INTERNO_USO  '$_REQUEST[anho]', '$_REQUEST[cCodTipoDoc]' ";
//echo    $sql;
    $rs=sqlsrv_query($cnx,$sql);

    while ($Rs=sqlsrv_fetch_array($rs)){
	?>      
		<tr>
        <td style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs[cNomOficina];?></td>
        </tr>
	<?
     }
    ?>	   	
      </tbody>
	</table>