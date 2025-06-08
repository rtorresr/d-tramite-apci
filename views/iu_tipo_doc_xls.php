<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_tipo_doc_xls.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL  de la Tabla Tipo de Documentos
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   Larry Ortiz        05/09/2018      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
include_once("../conexion/conexion.php");
session_start();
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
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' ";
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".($Rslog['cNombresTrabajador']??'')." ".($Rslog['cApellidosTrabajador']??'');
	echo " ";
?>
<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">COD DOCUMENTO</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ENTRADAS</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">INTERNOS</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">SALIDAS</th>
           	</tr>
		</thead>
		<tbody>
<?php
	$sql="SP_TIPO_DOCUMENTO_LISTA '".($_GET['Entrada']??'')."' , '".($_GET['Interno']??'')."', '".($_GET['Salida']??'')."' , '%".($_GET['cDescTipoDoc']??'')."%' , '%".($_GET['cSiglaDoc']??'')."%'  ,'".($orden??'')."' , '".($campo??'')."' ";
    $rs=sqlsrv_query($cnx,$sql);

    while ($Rs=sqlsrv_fetch_array($rs)){
	?>      
		<tr>
        <td style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cDescTipoDoc'];?></td>
        <td style="width: 8%; text-align: center; border: solid 1px #6F6F6F;font-size:10px" ><?php if($Rs['nFlgEntrada']=='1'){echo 'SI';} else{echo 'NO';}?></td>
        <td style="width: 8%; text-align: center; border: solid 1px #6F6F6F;font-size:10px" ><?php if($Rs['nFlgInterno']=='1'){echo 'SI';} else{echo 'NO';}?></td>
        <td style="width: 8%; text-align: center; border: solid 1px #6F6F6F;font-size:10px" ><?php if($Rs['nFlgSalida']=='1'){echo 'SI';} else{echo 'NO';}?></td>
        </tr>
	<?php
     }
    ?>	   	
      </tbody>
	</table>