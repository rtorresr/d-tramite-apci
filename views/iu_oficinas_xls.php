<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_oficinas_xls.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL  de la Tabla Oficinas
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   Larry Ortiz        05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
include_once("../conexion/conexion.php");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=iu_oficina_xls.xls");

    $anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
    echo "<table width=780 border=0><tr><td align=center colspan=3>";
	echo "<H3>REPORTE - OFICINAS</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=3>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=left colspan=3>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='$traRep' "; 
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog[cNombresTrabajador]." ".$Rslog[cApellidosTrabajador];
	echo " ";
?>	
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
    /*$sql="select * from Tra_M_Oficinas,Tra_M_Ubicacion_Oficina ";
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