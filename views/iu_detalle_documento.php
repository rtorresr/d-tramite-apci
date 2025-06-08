<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/detalle.css" media="screen" />
<script language="javascript" type="text/javascript">
    function muestra(nombrediv) {
        if(document.getElementById(nombrediv).style.display == '') {
                document.getElementById(nombrediv).style.display = 'none';
        } else {
                document.getElementById(nombrediv).style.display = '';
        }
    }
</script>
</head>
<body>
		<?
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_GET[codmov]'");
		$Rs=sqlsrv_fetch_array($rs);
		?>

<!--Main layout-->
 <main class="mx-lg-5">
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-md-12 mb-12">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

<div class="AreaTitulo">Documento N&ordm;: <?=$_GET[codmov]?></div>
<table cellpadding="0" cellspacing="0" border="0" width="910">
<tr>
<td class="FondoFormRegistro">
		
		<table width="880" border="0" align="center">
		<tr>
		<td>
				<fieldset id="tfa_GeneralDoc" class="fieldset">
				<legend class="legend"><a href="javascript:;" onClick="muestra('zonaGeneral')" class="LnkZonas">Datos Generales <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaGeneral">
		    <table border="0" width="860">
		    <tr>
		        <td width="130" >Fecha del Documento:&nbsp;</td>
		        <td width="320">
		        	<span><?=date("d-m-Y", strtotime($Rs['fFecDocumento']))?></span>
        			<span style=font-size:10px><?=date("h:i A", strtotime($Rs['fFecDocumento']))?></span>
		        </td>
		        <td width="130" >Fecha de Registro:&nbsp;</td>
		        <td>
		        	<span><?=date("d-m-Y", strtotime($Rs['fFecRegistro']))?></span>
        			<span style=font-size:10px><?=date("h:i A", strtotime($Rs['fFecRegistro']))?></span>
		        </td>
		    </tr> 

		    <tr>
		        <td width="130" >N&ordm; Documento:&nbsp;</td>
		        <td><?=$Rs['cNroDocumento']?></td>
		        <td width="130" >Referencia:&nbsp;</td>
		        <td><?=$Rs[cReferencia]?></td>
		    </tr>

		    <tr>
		        <td width="130" >Tipo de Documento:&nbsp;</td>
		        <td>
		        		<? 
			          $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$Rs[cCodTipoDoc]'";
			          $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			          $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			          echo $RsTipDoc['cDescTipoDoc'];
		            ?>
		        </td>
		        <td width="130" >Folios:&nbsp;</td>
		        <td><?=$Rs[nNumFolio];?></td>
		    </tr>
	    
		    <tr>
		        <td width="130" >Asunto:&nbsp;</td>
		        <td><?=$Rs['cAsunto']?></td>
		        <td width="130" >Observaciones:&nbsp;</td>
		        <td><?=$Rs[cObservaciones]?></td>
		    </tr>

		    <tr>
		        <td width="130" >Tiempo respuesta:&nbsp;</td>
		        <td><?=$Rs[nTiempoRespuesta]?></td>
		        <td width="130" >Tiempo restante:&nbsp;</td>
		        <td>0</td>
		    </tr>
		    
		    </table>
		  	</div>
		  	<img src="images/space.gif" width="0" height="0">
				</fieldset>
		</td>
		</tr>
		
		<tr>
		<td>   
				<fieldset id="tfa_GeneralEmp" class="fieldset">
		    <legend class="legend"><a href="javascript:;" onClick="muestra('zonaEmpresa')" class="LnkZonas">Datos de la Empresa <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaEmpresa">
		    <table border="0">
		    <tr>
		          <td width="130" >Razon Social:</td>
		          <td width="315">
		          	<? 
			            $sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
			            $rsRemi=sqlsrv_query($cnx,$sqlRemi);
			            $RsRemi=sqlsrv_fetch_array($rsRemi);
			            echo $RsRemi['cNombre'];
		              ?>
		          </td>
		          <td width="130" >Ruc:</td>
		          <td><?=$RsRemi['nNumDocumento']?></td>
		    </tr> 
		    <tr>
		          <td width="130" >Direccion:</td>
		          <td width="315"><?=$RsRemi[cDireccion]?></td>
		          <td width="130" >Representante:</td>
		          <td><?=$RsRemi[cRepresentante]?></td>
		    </tr>   
		    <tr>
		          <td width="130" >E-mail:</td>
		          <td width="315"><?=$RsRemi[cEmail]?></td>
		          <td width="130" >Provincia:</td>
		          <td><?=$RsRemi[cProvincia]?></td>
		    </tr>
		    <tr>
		          <td width="130" >Telefono:</td>
		          <td width="315"><?=$RsRemi[nTelefono]?></td>
		          <td width="130" >Fax:</td>
		          <td><?=$RsRemi[nFax]?></td>
		          
		    </tr>
		    </table>
		    </div>
		    <img src="images/space.gif" width="0" height="0">
		  	</fieldset>
		</td>
		</tr>
		
		<tr>
		<td>   
				<fieldset id="tfa_GeneralEmp" class="fieldset">
		    <legend class="legend"><a href="javascript:;" onClick="muestra('zonaFlujo')" class="LnkZonas">Flujograma<img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div style="display:none" id="zonaFlujo">
		    <table border="1" width="860">
		    <tr>
		    <td align="center">
		    		<?
		    		$sqlF="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
		   			$rsF=sqlsrv_query($cnx,$sqlF);
		    		while ($RsF=sqlsrv_fetch_array($rsF)){
		    		?>
		    		 <? 
		    		 if($contador<1){
		       	 		$sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsF[iCodOficinaOrigen]'";
			       		$rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       		$RsOfiO=sqlsrv_fetch_array($rsOfiO);
			       ?>
			       		<style type="text/css">
								#area<?=$RsF[iCodMovimiento]?>{
									position: absolute;
									display:none;
									font-family:Arial;
									font-size:0.8em;
									border:1px solid #808080;
									background-color:#f1f1f1;
								}
								</style>
								<script type="text/javascript">
								<!--
								function showdiv<?=$RsF[iCodMovimiento]?>(event){
									margin=8;
									var IE = document.all?true:false;
									if (!IE) document.captureEvents(Event.MOUSEMOVE)
								
									if(IE){ 
										tempX = event.clientX + document.body.scrollLeft;
										tempY = event.clientY + document.body.scrollTop;
									}else{ 
										tempX = event.pageX;
										tempY = event.pageY;
									}
									if (tempX < 0){tempX = 0;}
									if (tempY < 0){tempY = 0;}
								
									document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.top = (tempY+margin);
									document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.left = (tempX+margin);
									document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.display='block';
								}
								-->
								</script>
								<div id="area<?=$RsF[iCodMovimiento]?>" align="left">
									Creado: <?
													echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecMovimiento]))."</span>";
        									echo " <span style=color:#6F3700;font-size:8px>".date("h:i A", strtotime($RsF[fFecMovimiento]))."</span>";
													?>
									<br>
									Estado: <span style=color:#6F3700>
													<?
													switch ($RsF['nEstadoMovimiento']){
  												case 1:
  													echo "Pendiente";
  												break;
  												case 2:
  													echo "Derivado";
  												break;
  												case 3:
  													echo "Delegado";
  												break;
  												case 4:
  													echo "Respondido";
  												break;
  												case 5:
  													echo "Finalizado";
  												break;
  												}
													?>
													</span>
									<br>
									Aceptado:
													<?
													if($RsF[fFecRecepcion]==""){
        											echo "<span style=color:#ff0000>sin aceptar</span>";
        									}Else{
        											echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecRecepcion]))."</span>";
        											echo " <span style=color:#6F3700;font-size:8px>".date("h:i A", strtotime($RsF[fFecRecepcion]))."</span>";
        									}
													?>
									<br>
									Delegado:
													<?
													if($RsF['iCodTrabajadorDelegado']!=""){
  												$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsF['iCodTrabajadorDelegado']."'");
          								$RsDelg=sqlsrv_fetch_array($rsDelg);
          								echo "<span style=color:#6F3700>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</span>";
													sqlsrv_free_stmt($rsDelg);
													}
													?>
								</div>
		       	 		<button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF[iCodMovimiento]?>(event);" onmousemove="showdiv<?=$RsF[iCodMovimiento]?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.display='none';">

		       	 				<td height="46" valign="center">
		       	 					<div class="FlujoSquareData">
		       	 					<span style="font-size:12px"><?=$RsOfiO[cSiglaOficina]?></span><br>
		       	 					<span style="font-size:8px"><?=trim($RsOfiO[cNomOficina])?></span>
		       	 					</div>
		       	 				</td>
		       	 				<td><img src="images/icon_right.png" width="25" height="25" border="0"></td>
		       	 				</tr></table>
		       	 		</button>
		       	 <?
						 }
		     	 	  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsF[iCodOficinaDerivar]'";
			        	$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			        	$RsOfiD=sqlsrv_fetch_array($rsOfiD);
			        	$contador++;
			       ?>
			       		<style type="text/css">
								#area<?=$RsF[iCodMovimiento]?>{
									position: absolute;
									display:none;
									font-family:Arial;
									font-size:0.8em;
									border:1px solid #808080;
									background-color:#f1f1f1;
								}
								</style>
								<script type="text/javascript">
								<!--
								function showdiv<?=$RsF[iCodMovimiento]?>(event){
									margin=8;
									var IE = document.all?true:false;
									if (!IE) document.captureEvents(Event.MOUSEMOVE)
								
									if(IE){ 
										tempX = event.clientX + document.body.scrollLeft;
										tempY = event.clientY + document.body.scrollTop;
									}else{ 
										tempX = event.pageX;
										tempY = event.pageY;
									}
									if (tempX < 0){tempX = 0;}
									if (tempY < 0){tempY = 0;}
								
									document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.top = (tempY+margin);
									document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.left = (tempX+margin);
									document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.display='block';
								}
								-->
								</script>
								<div id="area<?=$RsF[iCodMovimiento]?>" align="left">
									Creado: <?
													echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecMovimiento]))."</span>";
        									echo " <span style=color:#6F3700;font-size:8px>".date("h:i A", strtotime($RsF[fFecMovimiento]))."</span>";
													?>
									<br>
									Estado: <span style=color:#6F3700>
													<?
													switch ($RsF['nEstadoMovimiento']){
  												case 1:
  													echo "Pendiente";
  												break;
  												case 2:
  													echo "Derivado";
  												break;
  												case 3:
  													echo "Delegado";
  												break;
  												case 4:
  													echo "Respondido";
  												break;
  												case 5:
  													echo "Finalizado";
  												break;
  												}
													?>
													</span>
									<br>
									Aceptado:
													<?
													if($RsF[fFecRecepcion]==""){
        											echo "<span style=color:#ff0000>sin aceptar</span>";
        									}Else{
        											echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecRecepcion]))."</span>";
        											echo " <span style=color:#6F3700;font-size:8px>".date("h:i A", strtotime($RsF[fFecRecepcion]))."</span>";
        									}
													?>
									<br>
									Delegado:
													<?
													if($RsF['iCodTrabajadorDelegado']!=""){
  												$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsF['iCodTrabajadorDelegado']."'");
          								$RsDelg=sqlsrv_fetch_array($rsDelg);
          								echo "<span style=color:#6F3700>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</span>";
													sqlsrv_free_stmt($rsDelg);
													}
													?>
								</div>
		     	 			<button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF[iCodMovimiento]?>(event);" onmousemove="showdiv<?=$RsF[iCodMovimiento]?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.display='none';">

		       	 				<td height="46" valign="center">
		       	 					<div class="FlujoSquareData">
		       	 					<span style="font-size:12px"><?=$RsOfiD[cSiglaOficina]?></span><br>
		       	 					<span style="font-size:8px"><?=trim($RsOfiD[cNomOficina])?></span>
		       	 					</div>
		       	 				</td>
		       	 				<?php if($contador!=sqlsrv_has_rows($rsF)){?>
		       	 				<td><img src="images/icon_right.png" width="25" height="25" border="0"></td>
		       	 				<?php}?>
		       	 				</tr></table>
		       	 		</button>
		    		<?
		    				//saltos linea:
		    				if($contador==4) echo "<br><br>";
		    		}
		    		?>
		    	
		    </td>
		    </tr> 
		    </table>
		    </div>
		    <img src="images/space.gif" width="0" height="0">
		  	</fieldset>
		</td>
		</tr>		
		
		<tr>
		<td>   
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaOficina')" class="LnkZonas">Flujo Entre Oficinas <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaOficina">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="120">Tipo Documento</td>
		       <td class="headCellColum" width="120">Referencia</td>
		       <td class="headCellColum" width="75">Fecha</td>
		       <td class="headCellColum" width="150">Asunto</td>
		       <td class="headCellColum" width="150">Observaciones</td>
		       <td class="headCellColum" width="120">Avances</td>
		       <td class="headCellColum">Origen</td>
		       <td class="headCellColum">Destino</td>
		    </tr>
		   	<? 
		   	$sqlM="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
		   	$rsM=sqlsrv_query($cnx,$sqlM);
		   	//echo $sqlM;
		    while ($RsM=sqlsrv_fetch_array($rsM)){
		      	if ($color == "#CEE7FF"){
			  			$color = "#F9F9F9";
		  			}else{
			  			$color = "#CEE7FF";
		  			}
		  			if ($color == ""){
			  			$color = "#F9F9F9";
		  			}	
				?>
		    <tr bgcolor="<?=$color?>">
		    <td valign="top">
		       	<?
		       	$sqlTpDcM="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsM[cCodTipoDocDerivar]'";
			      $rsTpDcM=sqlsrv_query($cnx,$sqlTpDcM);
			      $RsTpDcM=sqlsrv_fetch_array($rsTpDcM);
			      echo $RsTpDcM['cDescTipoDoc'];
		       	?>
		       </td>
		       <td valign="top"><?=$RsM['cNroDocumento']?></td>
		       <td valign="top">
		       		<span><?=date("d-m-Y", strtotime($RsM['fFecDerivar']))?></span>
		       </td>
		       <td valign="top" align="left">
		       		<?
		       		if($contaMov==0){
		       			echo $Rs['cAsunto'];
		       		}Else{
		       			echo $RsM[cAsuntoDerivar];
		       		}
		       		?>
		       </td>
		     	 <td valign="top" align="left">
		     	 		<?
		     	 		if($contaMov==0){
		       			echo $Rs[cObservaciones];
		       		}Else{
		       			echo $RsM[cObservacionesDerivar];
		       		}
		     	 		?>
		     	 </td>
		     	 
		     	 <td valign="top"><?=$RsM['iCodOficina']?></td>
		     	 
		       <td valign="top"> <?
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaOrigen]'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	 ?>
		       </td>
		     	 <td valign="top"> <?
		     	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaDerivar]'";
			       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
		     	 		echo "<a href=\"javascript:;\" title=\"".trim($RsOfiD[cNomOficina])."\">".$RsOfiD[cSiglaOficina]."</a>";
		     	 	?>
		     	 </td>
		    </tr> 
		    <?
		    $contaMov++;
		    }
		    ?>
		    </table> 
		    </div>
		    <img src="images/space.gif" width="0" height="0"> 
		  	</fieldset>
		</td>
		</tr>

		<tr>
		<td>   
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaTrabajador')" class="LnkZonas">Flujo Entre Trabajadores <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div style="display:none" id="zonaTrabajador">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="120">Trabajador</td>
		       <td class="headCellColum" width="80">Derivado</td>
		       <td class="headCellColum" width="80">Aceptado</td>
		       <td class="headCellColum" width="250">Observaciones</td>
		       <td class="headCellColum" width="200">Avances</td>
		       <td class="headCellColum">Doc.Generado</td>
		    </tr>
		   	<? 
		   	$sqlT="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND cFlgTipoMovimiento=2 ORDER BY iCodMovimiento ASC";
		   	$rsT=sqlsrv_query($cnx,$sqlT);
		   	//echo $sqlM;
		    while ($RsT=sqlsrv_fetch_array($rsT)){
		      	if ($color == "#CEE7FF"){
			  			$color = "#F9F9F9";
		  			}else{
			  			$color = "#CEE7FF";
		  			}
		  			if ($color == ""){
			  			$color = "#F9F9F9";
		  			}	
				?>
		    <tr bgcolor="<?=$color?>">
		    <td valign="top">
		       	<?
          	$rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsT[iCodTrabajadorEnviar]'");
          	$RsResp=sqlsrv_fetch_array($rsResp);
          	echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
						sqlsrv_free_stmt($rsResp);
        		?>
		       </td>
		       <td valign="top">
		       		<span><?=date("d-m-Y", strtotime($RsT[fFecEnviar]))?></span>
		       </td>
		       <td valign="top">
		       		<?
        			if($RsT['fFecDelegadoRecepcion']==""){
        					echo "<div style=color:#ff0000>sin aceptar</div>";
        			}Else{
        					echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsT['fFecDelegadoRecepcion']))."</div>";
        			}
        			?>
		       </td>
		     	 <td valign="top" align="left"><?=$RsT[cObservacionesEnviar]?></td>		       
			     <td valign="top" align="left">
			     	
			     </td>
			     <td valign="top" align="left">
			     	
			     </td>
		    </tr> 
		    <?
		    }
		    ?>
		    </table>
		    </div>
		    <img src="images/space.gif" width="0" height="0"> 
		  	</fieldset>
		</td>
		</tr>		
		</table>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<div>		
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
