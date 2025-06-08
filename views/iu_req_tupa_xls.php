<?php
include_once("../conexion/conexion.php");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=iu_req_tupa_xls.xls");

echo "<table width=780 border=0><tr><td align=right colspan=5>";
echo "</td></tr><tr><td align=center colspan=9>";
echo "<br>REPORTE - LISTA DE REQUERIMIENTOS DE TUPAS</b>";
echo " ";

	echo "<table width=780 border=0><tr><td align=left colspan=4>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='".$_GET['traRep']."'";
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog['cNombresTrabajador']." ".$Rslog['cApellidosTrabajador'];
	echo " ";
?>
<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 16%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TUPA</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">NOMBRE REQUISITO</th>
                <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ESTADO</th>
           	</tr>
		</thead>
		<tbody>
<?php
$sql= " SP_REQUISITO_TUPA_LISTA '".$_GET['cod']."' ,'' , '' " ;
//echo $sql;
$rs=sqlsrv_query($cnx,$sql);
while ($Rs=sqlsrv_fetch_array($rs)){
 ?>
		<tr>	
          <td  style="width: 16%; text-align: left; border: solid 1px #6F6F6F;font-size:10px">
		  <?php
          $sqlTup="SELECT cNomTupa FROM Tra_M_Tupa  WHERE iCodTupa='".$Rs['iCodTupa']."'";
          $rsTup=sqlsrv_query($cnx,$sqlTup);
          $RsTup=sqlsrv_fetch_array($rsTup);
		  echo $RsTup['cNomTupa'];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo $Rs['cNomTupaRequisito'];?></td>
          <td  style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php if ($Rs['nEstadoTupaRequisito']==1){ echo "<div style='color:#005E2F;text-align:center'>Activo</div>"; }Else{ echo "<div style='color:#950000;text-align:center'>Inactivo</div>"; }?></td>
         </tr>
	<?php
        }
    ?>
    </tbody>
</table>