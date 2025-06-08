<?

session_start();
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_remitentes_xls.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL  de la Tabla Remitentes
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   Larry Ortiz        05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
include_once("../conexion/conexion.php");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=iu_remitente_xls.xls");

    $anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
    echo "<table width=780 border=0><tr><td align=center colspan=7>";
	echo "<H3>REPORTE - REMITENTES</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=7>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=left colspan=7>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador=".$_SESSION['CODIGO_TRABAJADOR']; 
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog[cNombresTrabajador]." ".$Rslog[cApellidosTrabajador];
	echo " ";
?>
<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TIPO REMITENTE</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">NOMBRE REMITENTE</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">NRO DOCUMENTO</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DIRECCION</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">E-MAIL</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TELEFONO</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ESTADO</th>
			</tr>
		</thead>
		<tbody>
<?	

$sql="select  top (500) * from Tra_M_Remitente ";
$sql.=" WHERE iCodRemitente>0 ";
if($_GET['cNombre']!=""){
$sql.=" AND cNombre like '%'+'%$_GET['cNombre']%'+'%' ";
}
if($_GET['nNumDocumento']!=""){
$sql.=" AND nNumDocumento='%'+'%$_GET['nNumDocumento']%'+'%' ";
}
$sql.="ORDER BY $_GET['campo']  $_GET['orden'] ";

//$sql="SP_REMITENTE_LISTA  '%$_GET['cNombre']%', '%$_GET['nNumDocumento']%' ";
$rs=sqlsrv_query($cnx,$sql);

while ($Rs=sqlsrv_fetch_array($rs)){
 ?>
		<tr>	
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs['cTipoPersona'];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs['cNombre'];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs['nNumDocumento'];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cDireccion];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cEmail];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[nTelefono];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs[cFlag];?></td>
        </tr>
	<?
        }
    ?>
	   	
      </tbody>
	</table>