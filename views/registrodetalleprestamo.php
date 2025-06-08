<?php header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Lima');
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");	
	$fFecActual = date("Ymd")." ".date("H:i:s");
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
	<?php
		// Inicio de aceptar el trámite dando click en el mismo
		// actualizar fecha del ÚNICO SELECCIONADO pendiente al momento de aceptarlo.
		$nFlgEstado     = $_GET['nFlgEstado'];
		if ($nFlgEstado == 1) { 
			// La primera vez nFlgEstado está en 1, luego cuando se acepta, cambia a 2, y no ya no se debe volver 
			// a ejecutar el siguiente código, ya que volvería a ctualizar la fecha.
			$iCodMovimiento = $_GET['iCodMovimiento'];
	 		$sqlMov = "UPDATE Tra_M_Tramite_Movimientos 
	 							 SET fFecRecepcion = '$fFecActual' 
	 							 WHERE iCodMovimiento = '$iCodMovimiento'";
	 		$rsUpdMov = sqlsrv_query($cnx,$sqlMov);
	 			
			$sqlMovData = "SELECT iCodTramite, iCodMovimiento, iCodTramiteDerivar, nEstadoMovimiento, iCodTrabajadorDelegado 
										 FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = '$iCodMovimiento'";
	 		$rsMovData  = sqlsrv_query($cnx,$sqlMovData);
			$RsMovData  = sqlsrv_fetch_array($rsMovData);
			
			if ($RsMovData['nEstadoMovimiento'] == 3 && $RsMovData['iCodTrabajadorDelegado'] == $_SESSION['CODIGO_TRABAJADOR'] ){
				$sqlMovDel = "UPDATE Tra_M_Tramite_Movimientos 
											SET fFecDelegadoRecepcion = '$fFecActual' 
											WHERE iCodMovimiento = '$iCodMovimiento'";
	 			$rsUpdMovDel = sqlsrv_query($cnx,$sqlMovDel);
			}
			
			if ($RsMovData['iCodTramiteDerivar'] != ""){
				$sqlUpdDev = "UPDATE Tra_M_Tramite_Movimientos 
											SET fFecRecepcion = '$fFecActual' 
											WHERE iCodTramite='".$RsMovData['iCodTramiteDerivar']."'";
				$rsUpdDev  = sqlsrv_query($cnx,$sqlUpdDev);
			}
	 		$sqlUpd = "UPDATE Tra_M_Tramite 
	 							 SET nFlgEstado = 2 
	 							 WHERE iCodTramite = '$RsMovData[iCodTramite]'";
			$rsUpd  = sqlsrv_query($cnx,$sqlUpd);
		}
		// Fin de aceptar el trámite dando click en el mismo
		$rs = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs = sqlsrv_fetch_array($rs);
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

<div class="AreaTitulo">tramite N&ordm;: <?=$Rs[cCodificacion]?></div>
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
		        <td width="300">
		        	<span><?php echo date("d-m-Y G:i:s", strtotime($Rs['fFecDocumento']))?></span>
        			<span style=font-size:10px><?/*=date("h:i A", strtotime($Rs['fFecDocumento']))*/?></span>
		        </td>
		        <td width="130" >Fecha de Registro:&nbsp;</td>
		        <td>
		        	<span><?echo date("d-m-Y G:i:s", strtotime($Rs['fFecRegistro']))?></span>
        			<span style=font-size:10px><?/*=date("h:i A", strtotime($Rs['fFecRegistro']))*/?></span>
		        </td>
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
		        <td width="130" >N&ordm; Documento:&nbsp;</td>
		        <td style="text-transform:uppercase"><?=$Rs['cNroDocumento']?></td>
		        <td width="130" >Referencia:&nbsp;</td>
		        <td>
		        <?php 
		        	$sqlReferencia = "SELECT * FROM Tra_M_Tramite TT
									              INNER JOIN Tra_M_Tramite_Referencias TR ON TT.iCodTramite = tr.iCodTramite
									              WHERE TT.iCodTramite = ".$_GET['iCodTramite'];
							$rsReferencia = sqlsrv_query($cnx,$sqlReferencia);
							while ($RsReferencia = sqlsrv_fetch_array($rsReferencia)){
								$sqlRef = "SELECT cDescTipoDoc FROM Tra_M_Tramite TT
							             INNER JOIN Tra_M_Tipo_Documento TD ON TT.cCodTipoDoc = TD.cCodTipoDoc
							             WHERE TT.iCodTramite = ".$RsReferencia['iCodTramiteRef'];
								$rsRef = sqlsrv_query($cnx,$sqlRef);
								$RsRef = sqlsrv_fetch_array($rsRef);
								echo $RsReferencia['cDescTipoDoc']." ".$RsReferencia['cReferencia'];
					}
		        ?>
		        </td>
		    </tr>
	    
		    <tr>
		        <td width="130"  valign="top">Asunto:&nbsp;</td>
		        <td width="300"><?=$Rs['cAsunto']?></td>
		        <td width="130"  valign="top">Observaciones:&nbsp;</td>
		        <td width="300"><?=$Rs[cObservaciones]?></td>
		    </tr>

		    <tr>
		        <td width="130"  valign="top">Estado:&nbsp;</td>
		        <td>
								<?
								switch ($Rs[nFlgEstado]) {
  							case 1:
									echo "Pendiente";
								break;
								case 2:
									echo "En Proceso";
								break;
								case 3:
									echo "Finalizado";
									$sqlFinTxt="SELECT * FROM Tra_M_Tramite_Movimientos WHERE nEstadoMovimiento=5 AND iCodTramite='$_GET[iCodTramite]' order by iCodMovimiento DESC";
			            $rsFinTxt=sqlsrv_query($cnx,$sqlFinTxt);
			            $RsFinTxt=sqlsrv_fetch_array($rsFinTxt);
			            echo "<div style=color:#7C7C7C>".$RsFinTxt[cObservacionesFinalizar]."</div>";
			            echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsFinTxt[fFecFinalizar]))/*date("d-m-Y", strtotime($RsFinTxt[fFecFinalizar]))*/."</div>";
								break;
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
				<fieldset id="tfa_GeneralEmp" class="fieldset">
		    <legend class="legend">
		    	<a href="javascript:;" onClick="muestra('zonaEmpresa')" class="LnkZonas">Datos de la Empresa <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div style="display:none" id="zonaEmpresa">
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
		          <td width="130" >Remite:</td>
		          <td width="315" style="text-transform:uppercase"><?=$Rs[cNomRemite]?></td>
		          <td width="130" >Direccion:</td>
		          <td><?=$RsRemi[cDireccion]?></td>
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
				<legend class="legend">
					<a href="javascript:;" onClick="muestra('zonaFlujo')" class="LnkZonas">Flujo de Trabajo Real
						<img src="images/icon_expand.png" width="16" height="13" border="0">
					</a>
				</legend>
		    <div id="zonaFlujo">
		    	<table border="0" width="860">
		    		<tr>
		    			<td align="left">
		    				<?php
		    					$sqlF = "SELECT * FROM Tra_M_Tramite_Movimientos 
		    									 WHERE (iCodTramite = '$_GET[iCodTramite]' OR iCodTramiteRel = '$_GET[iCodTramite]') AND 
		    									 			 (cFlgTipoMovimiento = 1 OR cFlgTipoMovimiento = 3) 
		    									 ORDER BY iCodMovimiento ASC";
		   						$rsF  = sqlsrv_query($cnx,$sqlF);
		    					while ($RsF = sqlsrv_fetch_array($rsF)){
		    				?>
		    		 		<?php 
		    		 				if ($contador < 1){
		       	 					$sqlOfiO = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsF[iCodOficinaOrigen]'";
			       					$rsOfiO  = sqlsrv_query($cnx,$sqlOfiO);
			       					$RsOfiO  = sqlsrv_fetch_array($rsOfiO);
			       		?>
			       		<style type="text/css">#area<?php echo $RsF[iCodMovimiento]; ?>{
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
		       	 		<button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF[iCodMovimiento]?>(event);" onmousemove="showdiv<?=$RsF[iCodMovimiento]?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.display='none';">

		       	 				<td height="35" valign="center">
		       	 					<div class="FlujoSquareData" style="padding-top:10px">
		       	 					<span style="font-size:16px">
		       	 						<?php 
		       	 							if ($RsF['iCodOficinaOrigen'] == 0) {
		       	 								echo "WEB";
		       	 							}else{
		       	 								echo $RsOfiO['cSiglaOficina'];
		       	 							}
		       	 						?>
		       	 					</span>
		       	 					</div>
		       	 				</td>
		       	 				<td><img src="images/icon_right.png" width="25" height="25" border="0"></td>
		       	 				</tr></table>
		       	 		</button>
								<div id="area<?=$RsF[iCodMovimiento]?>" align="left">
									<div align=center><?=$RsOfiO[cNomOficina]?></div>
									<!--Creado: --><?
													//echo "<span style=color:#6F3700>". date("d-m-Y G:i:s", strtotime($Rs[fFecMovimiento], 0, -6)))."</span>";
													//echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecMovimiento]))."</span>";
													//?>
									<br>
									Aceptadoo:
													<?
													if($RsF[fFecRecepcion]==""){
        											echo "<span style=color:#6F6F6F>sin aceptar</span>";
        									}Else{
        											echo "<span style=color:#6F3700>".date("d-m-Y G:i:s", strtotime($RsF[fFecRecepcion]))."</span>";
        											//echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecRecepcion]))."</span>";
        									}
													?>
									<br>
									Delegado:
									<?php
										if($RsF['iCodTrabajadorDelegado']!=""){
											$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsF['iCodTrabajadorDelegado']."'");
  										$RsDelg=sqlsrv_fetch_array($rsDelg);
  										echo "<span style=color:#6F3700>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</span>";
									sqlsrv_free_stmt($rsDelg);
									}
									?>
								</div>
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
		     	 			<button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF[iCodMovimiento]?>(event);" onmousemove="showdiv<?=$RsF[iCodMovimiento]?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.display='none';">

		       	 				<td height="35" valign="center">
		       	 					<div class="<?php if($RsF[cFlgTipoMovimiento]==1) echo "FlujoSquareData"?><?php if($RsF[cFlgTipoMovimiento]==3) echo "FlujoSquareAnexo"?>" style="padding-top:10px">
		       	 					<span style="font-size:16px;"><?=$RsOfiD[cSiglaOficina]?></span><br>
		       	 					</div>
		       	 				</td>
		       	 				<?php if($contador!=sqlsrv_has_rows($rsF)){?>
		       	 				<td><img src="images/icon_right.png" width="25" height="25" border="0"></td>
		       	 				<?php}?>
		       	 				</tr></table>
		       	 		</button>
								<div id="area<?=$RsF[iCodMovimiento]?>" align="left">
									<div align=center><?=$RsOfiD[cNomOficina]?></div>
									<!--Creado: --> <?
										//echo "<span style=color:#6F3700>".date("d-m-Y G:i:s", strtotime($Rs[fFecMovimiento], 0, -6)))."</span>";
										echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecMovimiento]))."</span>";
										?>
									<br>
									Aceptado:
													<?
													if($RsF[fFecRecepcion]==""){
        											echo "<span style=color:#6F6F6F>sin aceptar</span>";
        									}Else{
        											echo "<span style=color:#6F3700>".date("d-m-Y G:i:s", strtotime($RsF[fFecRecepcion]))."</span>";
        											//echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecRecepcion]))."</span>";
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
		    		<?
		    				//saltos linea:
		    				if($contador==7) echo " <img src=images/lineFlujo.png width=800 height=31> ";
		    				if($contador==14) echo " <img src=images/lineFlujo.png width=800 height=31> ";
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
        <?
		 if($Rs['iCodTupa']!=""){
		 ?>	
		<tr>
		<td>   
				<fieldset id="tfa_GeneralEmp" class="fieldset">
		    <legend class="legend"><a href="javascript:;" onClick="muestra('zonaFlujoProgramado')" class="LnkZonas">Flujo de Trabajo Programado<img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div style="display:none" id="zonaFlujoProgramado">
		    <table border="0" width="800">
		    <tr>
		    <td align="left">
		    		<?
		    		$sqlF="SELECT * FROM Tra_M_Mov_Flujo WHERE (iCodTupa='".$Rs['iCodTupa']."' ) ORDER BY iNumOrden ASC";
		   			$rsF=sqlsrv_query($cnx,$sqlF);
		    		while ($RsF=sqlsrv_fetch_array($rsF)){
		    		?>
		    		 <? 
		    		
		       	 		$sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsF['iCodOficina']'";
			       		$rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       		$RsOfiO=sqlsrv_fetch_array($rsOfiO);
						$contador2++;
			       ?>
			       		<style type="text/css">
								#area<?=$RsF[iCodMovFlujo]?>{
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
								function showdiv<?=$RsF[iCodMovFlujo]?>(event){
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
								
									document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.top = (tempY+margin);
									document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.left = (tempX+margin);
									document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.display='block';
								}
								-->
								</script>
		       	 		<button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF[iCodMovFlujo]?>(event);" onmousemove="showdiv<?=$RsF[iCodMovFlujo]?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.display='none';">

		       	 				<td height="35" valign="center">
	       	 				    <div class="FlujoSquareTupa" style="padding-top:10px">
		       	 					<span style="font-size:14px"><?=$RsOfiO[cSiglaOficina]?></span>
		       	 					</div>
		       	 				</td>
                                <?php if($contador2!=sqlsrv_has_rows($rsF)){?>
		       	 				<td ><img src="images/icon_right.png" width="25" height="25" border="0"></td>
                                <?php }?>
		       	 				</tr></table>
	       	 		</button>
								<div id="area<?=$RsF[iCodMovFlujo]?>" align="left">
									<div align=center><?=$RsOfiO[cNomOficina]?></div>
                                    Actividad:
										 <?
												   echo "<span style=color:#6F3700>".$RsF[cActividad]."</span>";
										 ?>
                                    <br>
									Dias: 
									      <?
													echo "<span style=color:#6F3700>".$RsF[nPlazo]."</span>";
        								  ?>
									<br>
									Detalle:
										  <?
										  			echo "<span style=color:#6F6F6F>".$RsF[cDesMovFlujo]."</span>";
        								  ?>
		        				</div>
		       	 <?
						
						
		    				//saltos linea:
		    				if($contador==7) echo " <img src=images/lineFlujo.png width=800 height=31> ";
		    				if($contador==14) echo " <img src=images/lineFlujo.png width=800 height=31> ";
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
        <?php }?>
        <tr>
		<td>  
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaOficina')" class="LnkZonas">Seguimiento de Tramite <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaOficina">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="120">Tipo Documento</td>
		       <td class="headCellColum" width="75">Fecha</td>
		       <td class="headCellColum" width="260">Asunto</td>
		       <td class="headCellColum" width="140">Observaciones</td>
		       <td class="headCellColum">Origen</td>
		       <td class="headCellColum">Oficina</td>
           <td class="headCellColum" width="120">Responsable / Fecha de Aceptado</td>
           <td class="headCellColum">Estado</td>
           <td class="headCellColum" width="120">Avances</td>
		      
		    </tr>
		   	<? 
		   // 	$sqlM = "SELECT 
					// 	iCodMovimiento, iCodTramite,iCodOficinaOrigen,fFecRecepcion,iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,cAsuntoDerivar,    
					// 	cObservacionesDerivar,cast(fFecDerivar as char) fFecDerivar,iCodTrabajadorDelegado,fFecDelegado, nEstadoMovimiento,cFlgTipoMovimiento,  cNumDocumentoDerivar,cReferenciaDerivar,iCodTramiteDerivar
					// FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='$_GET[iCodTramite]' OR iCodTramiteRel='$_GET[iCodTramite]') AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) ORDER BY iCodMovimiento ASC";

				$sqlM = "SELECT 
						iCodMovimiento, iCodTramite,iCodOficinaOrigen,fFecRecepcion,iCodOficinaDerivar,iCodTrabajadorDerivar,cCodTipoDocDerivar,cAsuntoDerivar,    
						cObservacionesDerivar, fFecDerivar,iCodTrabajadorDelegado,fFecDelegado, nEstadoMovimiento,cFlgTipoMovimiento,  cNumDocumentoDerivar,cReferenciaDerivar,iCodTramiteDerivar
					FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='$_GET[iCodTramite]' OR iCodTramiteRel='$_GET[iCodTramite]') AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) ORDER BY iCodMovimiento ASC";
		   	$rsM=sqlsrv_query($cnx,$sqlM);
		   	$recorrido=1;

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
		       	//echo $RsM[iCodTramite];
			      $sqlTpDcM="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsM[cCodTipoDocDerivar]'";
			      $rsTpDcM=sqlsrv_query($cnx,$sqlTpDcM);
				 // echo $sqlTpDcM;
			      $RsTpDcM=sqlsrv_fetch_array($rsTpDcM);
		       	switch ($RsM[cFlgTipoMovimiento]) {
  					case 1: //moviemiento normal
						if($recorrido==1){
							echo "<div style=color:#005EBB><b>".$Rs[cCodificacion]."</b></div>";	
							echo $RsTpDcM['cDescTipoDoc'];
			      			echo "<div style=color:#808080;text-transform:uppercase>".$Rs['cNroDocumento']."</div>";
			      		}
						else
						{
						echo "".$RsTpDcM['cDescTipoDoc'];
			      		//echo "<div>".$Rs[cReferencia]."</div>";
			      		echo "<div style=color:#808080>".$RsM['cNumDocumentoDerivar']."</div>";
						echo "<b>Interno<b>";
						}
			     	break;
			     	case 3: //movimiento anexo
				  $sqlAnexo="SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite='$RsM[iCodTramite]' ";
			      $rsAnexo=sqlsrv_query($cnx,$sqlAnexo);
			      $RsAnexo=sqlsrv_fetch_array($rsAnexo);
						    echo "<div style=color:#005EBB><b>".$RsAnexo[cCodificacion]."<b></div>";
			     			echo $RsTpDcM['cDescTipoDoc'];
			     			echo "<div style=color:#008000><b>Anexo<b></div>";
			     	break;
			     	case 5: //movimiento referencia
			     			echo $RsTpDcM['cDescTipoDoc'];
			     			echo "<div style=color:#808080><b>".$RsM[cReferenciaDerivar]."<b></div>";
				  $sqlTipo="SELECT nFlgTipoDoc FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='".$RsM['iCodTramiteDerivar']."' ";
			      $rsTipo=sqlsrv_query($cnx,$sqlTipo);
			      $RsTipo=sqlsrv_fetch_array($rsTipo);
						if($RsTipo[nFlgTipoDoc]==3){	
						echo "<b>Referencia : Salida<b>";}
						else if($RsTipo[nFlgTipoDoc]==2){
								echo "<b>Referencia : Interno<b>";
						}
						else if($RsTipo[nFlgTipoDoc]==1){
								echo "<b>Referencia : Entrada<b>";
						}
			     	break;			     	
			     	}
		       	?>
		    </td>
		    <td valign="top">
			    <span>
			    	<?php 
			    		echo date("d-m-Y", strtotime($RsM['fFecDerivar']));
			    	?>
			    </span>
					<span>
						<?php 
							echo date("h:i A", strtotime($RsM['fFecDerivar']));
						?>
					</span>
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
		     	 
		       <td valign="top"> <?
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaOrigen]'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	 ?>
		       </td>
		     	 <td valign="top">
		     	 	<?php
		     	 		$sqlOfiD = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaDerivar]'";
			       	$rsOfiD  = sqlsrv_query($cnx,$sqlOfiD);
			       	$RsOfiD  = sqlsrv_fetch_array($rsOfiD);
		     	 		echo "<a href=\"javascript:;\" title=\"".trim($RsOfiD[cNomOficina])."\">".$RsOfiD[cSiglaOficina]."</a>";
		     	 	?>
		     	 </td>
           <td align="center" valign="top">
           	<?php
		  				$rsResp = sqlsrv_query($cnx,"SELECT cApellidosTrabajador,cNombresTrabajador 
		  												       FROM Tra_M_Trabajadores 
		  												       WHERE iCodTrabajador = '$RsM[iCodTrabajadorDerivar]'");
          		$RsResp = sqlsrv_fetch_array($rsResp);
          		echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
		  				sqlsrv_free_stmt($rsResp);
		  
							if($RsM[cFlgTipoMovimiento] != 5){	
        				if($RsM[fFecRecepcion] == ""){
        					echo "<div style=color:#ff0000>sin aceptar</div>";
        				}else{
        					echo "<div style=color:#0154AF>aceptado</div>";
        					echo "<div style=color:#0154AF>".date("d-m-Y G:i:s", strtotime($RsM[fFecRecepcion]))/*date("d-m-Y", strtotime($RsM[fFecRecepcion])*/."</div>";
        				//echo "<div style=color:#0154AF;font-size:10px>".date("h:i A", strtotime($RsM[fFecRecepcion]))."</div>";
        				}
        			}else{
        				echo "";
        			}
        		?>
                 </td>
                 
                 <td valign="top" align="">
                 <?
				  if($RsM[cFlgTipoMovimiento]!=5){	
				 if($RsM[fFecRecepcion]!=""){
                 switch ($RsM['nEstadoMovimiento']) {
  						case 1:
  							echo "En Proceso";
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
				 }else {
					 echo "Pendiente";
				 }
				  }else { echo "";}
				  if($RsM['iCodTrabajadorDelegado']!=""){
  					$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsM['iCodTrabajadorDelegado']'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	echo "<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>";
						sqlsrv_free_stmt($rsDelg);
						echo "<div style=color:#0154AF>".date("d-m-Y G:i:s", strtotime($RsM[fFecDelegado]))/*date("d-m-Y", strtotime($RsM[fFecDelegado]))*/."</div>";
						//echo "<div style=color:#0154AF;font-size:10px>".date("h:i A", strtotime($RsM[fFecDelegado]))."</div>";
						
					}
					?>		
					</td>
                 
		     	 <td valign="top">
		     	 	<a href="listadoDeAvances.php?iCodTramite=<?=$RsM[iCodTramite]?>&iCodOficinaRegistro=<?=$_SESSION['iCodOficinaLogin']?>&iCodMovimiento=<?=$RsM[iCodMovimiento]?>" rel="lyteframe" title="Listado de Avances" rev="width: 600px; height: 400px; scrolling: auto; border:no">
        		 <img src="images/page_add.png" width="22" height="20" border="0">
        	</a>
		     	 	<?php
		    //  	 		if($RsM[cFlgTipoMovimiento] == 1){
			   //   			$sqlAvan = "SELECT * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento='$RsM[iCodMovimiento]' 
			   //   									ORDER BY iCodAvance DESC"
      //       		$rsAvan  = sqlsrv_query($cnx,$sqlAvan);
      //       		while ($RsAvan = sqlsrv_fetch_array($rsAvan)){
		    //  	 				$rsTrbA = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsAvan[iCodTrabajadorAvance]'");
      //     				$RsTrbA = sqlsrv_fetch_array($rsTrbA);
      //     				echo "<div style=font-size:10px;color:#623100>".$RsTrbA["cApellidosTrabajador"]." ".$RsTrbA["cNombresTrabajador"].":</div>";
						// 			sqlsrv_free_stmt($rsTrbA);
						// 			echo "<div style=font-size:10px;color:#808080>".date("d-m-Y G:i:s", strtotime($RsAvan[fFecAvance]))/*date("d-m-Y h:i a", strtotime($RsAvan[fFecAvance]))*/."&nbsp;</div>";
		    //  	 				echo "<div style=font-size:10px>".$RsAvan[cObservacionesAvance]."</div>";
		    //  	 				echo "<hr>";
		    // 				}
		    // 		}
						// if($RsM[cFlgTipoMovimiento] == 5){
						// 	$sqlRp = " SELECT cRptaOk FROM Tra_M_Tramite WHERE cCodificacion ='$RsM[cReferenciaDerivar]'";
						// 	$rsRp = sqlsrv_query($cnx,$sqlRp);
						// 	$RsRp = sqlsrv_fetch_array($rsRp);
						// 	echo $RsRp[cRptaOk];
						// }
		     	 ?>
		     	</td>
		     	
		    </tr> 
		    <?php
		    $contaMov++;
		    $recorrido++;
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
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaCopias')" class="LnkZonas">Copias<img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div  id="zonaCopias">
		    <table border="0" align="center" width="860">
		    <tr>
               <td class="headCellColum" width="146">Tip. Doc.:</td>
		       <td class="headCellColum" width="85">Origen:</td>
		       <td class="headCellColum" width="83">Destino:</td>
		       <td class="headCellColum" width="111">Responsable</td>
		       <td class="headCellColum" width="75">Derivado</td>
		       <td class="headCellColum" width="77">Aceptado</td>
		       <td class="headCellColum" width="137">Observaciones</td>
		       <td class="headCellColum" width="112">Indicación</td>
		    </tr>
		   	<? 
		   	$sqlCop="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND cFlgTipoMovimiento=4 ORDER BY iCodMovimiento ASC";
		   	$rsCop=sqlsrv_query($cnx,$sqlCop);
		   	//echo $sqlM;
		    while ($RsCop=sqlsrv_fetch_array($rsCop)){
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
             <td align="left">
		    		<?
		    	  $sqlTiC="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsCop[cCodTipoDocDerivar]'";
			      $rsTiC=sqlsrv_query($cnx,$sqlTiC);
				  $RsTiC=sqlsrv_fetch_array($rsTiC);
				  echo $RsTiC['cDescTipoDoc'];
				  echo "<div style=color:#808080>".$RsCop['cNumDocumentoDerivar']."</div>";
				
		    		?>
		    </td>
		    <td align="center">
		    		<?
		    		$sqlOfO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsCop[iCodOficinaOrigen]'";
			      $rsOfO=sqlsrv_query($cnx,$sqlOfO);
			      $RsOfO=sqlsrv_fetch_array($rsOfO);
		     	 	echo "<a style=text-decoration:none href=javascript:; title=\"".trim($RsOfO[cNomOficina])."\">".trim($RsOfO[cSiglaOficina])."</a>";
		    		?>
		    </td>
		    <td  align="center">
		    		<?
		    		$sqlOfC="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsCop[iCodOficinaDerivar]'";
			      $rsOfC=sqlsrv_query($cnx,$sqlOfC);
			      $RsOfC=sqlsrv_fetch_array($rsOfC);
				  	echo "<a style=text-decoration:none href=javascript:; title=\"".trim($RsOfC[cNomOficina])."\">".trim($RsOfC[cSiglaOficina])."</a>";
		     	 	
		    		?>
		    </td>
		    <td valign="top">
		       	<?
          	$rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsCop[iCodTrabajadorDerivar]'");
          	$RsResp=sqlsrv_fetch_array($rsResp);
          	echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
						sqlsrv_free_stmt($rsResp);
			if($RsCop['iCodTrabajadorDelegado']!=""){
  			$rsDelgC=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsCop['iCodTrabajadorDelegado']'");
          	$RsDelgC=sqlsrv_fetch_array($rsDelgC);
          	echo "<div style=color:#005B2E;font-size:12px>".$RsDelgC["cApellidosTrabajador"]." ".$RsDelgC["cNombresTrabajador"]."</div>";
						sqlsrv_free_stmt($rsDelgC);
					}
						
        		?>
		       </td>
		       <td valign="top">
		       		<span><?=date("d-m-Y G:i:s", strtotime($RsCop['fFecDerivar']))/*date("d-m-Y", strtotime($RsCop['fFecDerivar']))*/?></span>
					<span><?/*=date("h:i A", strtotime($RsCop['fFecDerivar']))*/?></span>
		       </td>
		       <td valign="top">
		       		<?
        			if($RsCop[fFecRecepcion]==""){
        					echo "<div style=color:#ff0000>sin aceptar</div>";
        			}Else{
        					echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsCop[fFecRecepcion]))/*date("d-m-Y", strtotime($RsCop[fFecRecepcion]))*/."</div>";
        			}
        			?>
		       </td>
		     	 <td valign="top" align="left"><?=$RsCop[cObservacionesDerivar]?></td>		       
			     <td valign="top" align="left">
			     		<?
			     		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsCop[iCodIndicacionDerivar]'";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              $RsIndic=sqlsrv_fetch_array($rsIndic);
                echo $RsIndic["cIndicacion"];
              sqlsrv_free_stmt($rsIndic);
			     		?>
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
		


		<tr>
		<td>   
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaTrabajador')" class="LnkZonas">Flujo Entre Trabajadores <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div style="display:none" id="zonaTrabajador">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="80">Oficina</td>
		       <td class="headCellColum" width="160">Origen</td>
		       <td class="headCellColum" width="160">Destino</td>
		       <td class="headCellColum" width="110">Enviado</td>
		       <td class="headCellColum" width="300">Observaciones</td>
		    </tr>
		   	<? 
		   	$sqlMvTr="SELECT * FROM Tra_M_Tramite_Trabajadores WHERE iCodTramite='$Rs[iCodTramite]' ORDER BY iCodMovTrabajador ASC";
		   	$rsMvTr=sqlsrv_query($cnx,$sqlMvTr);
		   	//echo $sqlM;
		    while ($RsMvTr=sqlsrv_fetch_array($rsMvTr)){
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
		    <td>

						<? 
		       	$sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMvTr['iCodOficina']'";
			      $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			      $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	?>		    	
		    </td>
		    <td valign="top">
		       	<?
          	$rsMvTrOr=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMvTr[iCodTrabajadorOrigen]'");
          	$RsMvTrOr=sqlsrv_fetch_array($rsMvTrOr);
          	echo $RsMvTrOr["cApellidosTrabajador"]." ".$RsMvTrOr["cNombresTrabajador"];
						sqlsrv_free_stmt($rsMvTrOr);
        		?>
		    </td>
		    <td valign="top">
		       	<?
          	$rsMvTrDs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMvTr[iCodTrabajadorDestino]'");
          	$RsMvTrDs=sqlsrv_fetch_array($rsMvTrDs);
          	echo $RsMvTrDs["cApellidosTrabajador"]." ".$RsMvTrDs["cNombresTrabajador"];
						sqlsrv_free_stmt($rsMvTrDs);
        		?>
		    </td>
		    <td valign="top">
		    		<span><?=date("d-m-Y G:i:s", strtotime($RsMvTr[fFecEnvio]))/*date("d-m-Y H:i", strtotime($RsMvTr[fFecEnvio]))*/?></span>
		    </td>
		    <td valign="top" align="left"><?=$RsMvTr[cObservaciones]?></td>		       
		    </tr> 
		    <?php}?>
		    </table>
		    </div>
		    <img src="images/space.gif" width="0" height="0"> 
		  	</fieldset>
		</td>
		</tr>		
		<tr>
		<td>   
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaTrabajadorDel')" class="LnkZonas">Copias a Trabajadores <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div  id="zonaTrabajador">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="80">Oficina</td>
		       <td class="headCellColum" width="160">Trabajador</td>
		       <td class="headCellColum" width="110">Delegado</td>
		       <td class="headCellColum" width="300">Observaciones</td>
		    </tr>
		   	<? 
		   	$sqlMvTr="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' And cFlgTipoMovimiento= 6 ORDER BY iCodMovimiento ASC";
		   	$rsMvTr=sqlsrv_query($cnx,$sqlMvTr);
		   	//echo $sqlM;
		    while ($RsMvTr=sqlsrv_fetch_array($rsMvTr)){
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
		    <td>

				<?php 
		       	$sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMvTr[iCodOficinaDerivar]'";
			    $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			    $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	?>
		    </td>
		    <td valign="top">
		       	<?php
          		$rsMvTrOr=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMvTr[iCodTrabajadorEnviar]'");
          		$RsMvTrOr=sqlsrv_fetch_array($rsMvTrOr);
          		echo $RsMvTrOr["cApellidosTrabajador"]." ".$RsMvTrOr["cNombresTrabajador"];
				sqlsrv_free_stmt($rsMvTrOr);
        		?>
		    </td>
		    <td valign="top">
		   		 <span><?= date("d-m-Y G:i:s", strtotime($RsMvTr[fFecDelegado]))/*date("d-m-Y G:i", strtotime($RsMvTr[fFecDelegado]))*/?></span>
		    </td>
		    <td valign="top" align="left"><?=$RsMvTr[cObservacionesDerivar]?></td>		       
		    </tr> 
		    <?php}?>
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