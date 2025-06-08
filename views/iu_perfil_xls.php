<?php
include_once("../conexion/conexion.php");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=iu_perfil_xls.xls");

    $anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
	echo "<table width=780 border=0><tr><td align=center colspan=3>";
	echo "<H3>REPORTE - PERFILES</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=3>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=left colspan=3>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='".($traRep??'')."' ";
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".utf8_encode($Rslog['cNombresTrabajador']." ".$Rslog['cApellidosTrabajador']);
	echo " ";
?>	
	<table style="width: 80%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th colspan="3" style="width: 50%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">PERFIL</th>
			</tr>
		</thead>
		<tbody>
		<?php
    $sql=" SP_PERFIL_LISTA '%".$_GET['cDescPerfil']."%' ,'".($orden??'')."' , '".($campo??'')."' ";
    $rs=sqlsrv_query($cnx,$sql);
    while ($Rs=sqlsrv_fetch_array($rs)){
   	?>
		<tr>	
          <td colspan="3" style="width: 30%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo utf8_encode($Rs['cDescPerfil']);?></td>
        </tr>
	<?php
        }
    ?>
	   	
      </tbody>
	</table>