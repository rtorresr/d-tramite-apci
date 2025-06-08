<?php
	include_once("../conexion/conexion.php");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=consultaTramiteCargoLoc.xls");
	
	$anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	$sqlOfis1=" SELECT iCodOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado=1 ORDER BY cSiglaOficina ASC"; 		   
	$rsOfis1=sqlsrv_query($cnx,$sqlOfis1);
	$num=sqlsrv_has_rows($rsOfis1);
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
	}
	if ($fDesde!=''){$fDesde=date("Ymd", strtotime($_REQUEST[fDesde]));} else {$fDesde=0;}
   if( $_REQUEST[fHasta]!=''){$fHasta=date("Y-m-d", strtotime($_REQUEST[fHasta]));    
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia 
	}
	else {$fHasta = 0;}
	
	echo "<table width=780 border=0><tr><td align=center colspan=12>";
	echo "<H3>ESTADISTICA DE ENVIO A NIVEL LIMA METROPOLITANA</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=12>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=left colspan=7>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='$traRep' "; 
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog[cNombresTrabajador]." ".$Rslog[cApellidosTrabajador];
	echo " ";
	?>
							<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
                            <thead>
                                <tr>
                                    <th colspan="1" style="text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ENVIADOS POR</th>
                                    <th colspan="<?=$num?>" style="text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">PRO INVERSION</th>
                                     <th colspan="1" style="text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TOTAL POR</th>	
                                </tr>
                            	<tr>
                                    <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DISTRITO</th>
        <? $sqlOfis=" SELECT iCodOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado=1 ORDER BY cSiglaOficina ASC"; 		   
		$rsOfis=sqlsrv_query($cnx,$sqlOfis);
		    while ($RsOfis=sqlsrv_fetch_array($rsOfis)){
		   ?>
                     <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8"><?php echo $RsOfis[cSiglaOficina];?></th>
          <?   }  ?>                      
                      <th style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DISTRITO</th>
								
								</tr>
							</thead>
							<tbody>
							<?
	
		?>
         <?php //$sqlDep="SELECT cCodDepartamento,cNomDepartamento FROM Tra_U_Departamento"; 		  
			$sqlDep="SELECT cCodDepartamento,cCodDistrito,cCodProvincia,cNomDistrito
  FROM Tra_U_Distrito where
  cCodDepartamento=15 and cCodProvincia=01 or cCodDepartamento=07 order by cNomDistrito ASC";
				   $rsDep=sqlsrv_query($cnx,$sqlDep);
		    while ($RsDep=sqlsrv_fetch_array($rsDep)){
		   ?>
			  <tr>
                 <td style="width:8%;text-align:left;border: solid 1px #6F6F6F;font-size:10px;"><?  echo $RsDep[cNomDistrito];?></td>
              	 <? $sqlOfis2=" SELECT iCodOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado=1 ORDER BY cSiglaOficina ASC"; 		   
						
						$rsOfis2=sqlsrv_query($cnx,$sqlOfis2);
						while ($RsOfis2=sqlsrv_fetch_array($rsOfis2)){
		  // while ($RsOfis2=sqlsrv_fetch_array($rsOfis2)){
		   ?>
                   
                 <td style="width:8%;text-align:center;border: solid 1px #6F6F6F;font-size:10px;">
                     
					 <?
					  
					 // echo $RsDep[cNomDepartamento];
   
   					$sqlexcel="SELECT dbo.fn_Rep_Cargo_local($RsOfis2['iCodOficina'],'$RsDep[cCodDepartamento]','$RsDep[cCodProvincia]','$RsDep[cCodDistrito]','$fDesde','$fHasta')";
					 $rsContar=sqlsrv_query($cnx,$sqlexcel);
					 	$RsContar=sqlsrv_fetch_array($rsContar);
						echo $RsContar[0];
					?></td>
             
                <?   }  ?>                   
              </tr>	
          <?   }  ?>
          <tr>
                 <td colspan="1" style="text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">TOTAL POR OFICINAS</td> 
           <?  for($i=1;$i<=$num;$i++) { 
				
   	
		  ?>     
                 <td  style="text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8"><? ?></td>
           <?   }  ?>      
                 <td  style="text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8"><? ?></td>            </tr>   		  			
						  </tbody>
							 </table>  