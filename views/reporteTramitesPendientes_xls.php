<?php
session_start();
	include_once("../conexion/conexion.php");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=reporteTramitesPendientes.xls");
	
	$anho    = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
	echo "<table width=780 border=0><tr><td align=center colspan=9>";
	echo "<H3>REPORTE - TRAMITES PENDIENTES</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=9>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=left colspan=9>";
	$sqllog = "SELECT cNombresTrabajador, cApellidosTrabajador FROM tra_m_trabajadores 
						 WHERE iCodTrabajador = '".$_SESSION['CODIGO_TRABAJADOR']."' ";
	$rslog  = sqlsrv_query($cnx,$sqllog);
	$Rslog  = sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog[cNombresTrabajador]." ".$Rslog[cApellidosTrabajador];
	echo " ";
?>	
	<table style="width: 780px;border: solid 1px #5544DD; border-collapse: collapse" align="center">
  	<thead>
    	<tr>
      	<th style="width: 30%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Oficina</th>
       	<th style="width: 50%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">Pendientes</th>
      </tr>
	 	</thead>
   	<tbody>
			<?php	 
				$sql   = "SELECT * FROM Tra_M_Oficinas ORDER BY cNomOficina";
   			$rs    = sqlsrv_query($cnx,$sql);
   			$total = sqlsrv_has_rows($rs);
				
				// $sql   = "EXECUTE USP_REPORTE_TRAMITES_PENDIENTES";
			 //   $rs    = sqlsrv_query($cnx,$sql);
			 //   $total = sqlsrv_has_rows($rs);
			  while ($Rs = sqlsrv_fetch_array($rs)){
			?>
			<tr>
				<td style="width:780px;text-align:left;border: solid 1px #6F6F6F;font-size:10px;">
					<?php
	 					echo "<div style=color:#808080;>".$Rs['cNomOficina']."</div>";
					?>
	 			</td>
    		<td style="width:780px;text-align:center;border: solid 1px #6F6F6F;font-size:10px;">
    			<?php 
    				$sqlBtn1 = "SP_BANDEJA_PENDIENTES  '','','','','','', ";
  					$sqlBtn1.= "'','','','','','','','','$Rs['iCodOficina']','Fecha','DESC' ";
  					$rsBtn1 = sqlsrv_query($cnx,$sqlBtn1, $cnx);
  					$total1 = sqlsrv_has_rows($rsBtn1);
    				echo "<div style=color:#808080;>".$total1."</div>";
    			?>
    		</td>
  		</tr>
  		<?php 
  			}
  		?>
	  </tbody>
	</table>