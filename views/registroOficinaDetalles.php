<?php header('Content-Type: text/html; charset=UTF-8');
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>
<link type="text/css" rel="stylesheet" href="css/detalle.css" media="screen" />
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>
<?php
    $rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".($_GET['iCodTramite']??'')."'");
    $Rs=sqlsrv_fetch_array($rs);
?>

<div class="AreaTitulo">DETALLE DE DOCUMENTO INTERNO - OFICINA</div>
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
		        <td width="130" >Tipo de Documento:&nbsp;</td>
		        <td width="300">
		        		<?php
                        if ($Rs['cCodTipoDoc']===" ") {
                            $sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='" . $Rs['cCodTipoDoc'] . "'";
                            $rsTipDoc = sqlsrv_query($cnx, $sqlTipDoc);
                            $RsTipDoc = sqlsrv_fetch_array($rsTipDoc);
                            echo utf8_encode(ucwords(strtolower($RsTipDoc['cDescTipoDoc'])));
                        }else { echo "-"; }
		            ?>
		        </td>
		        <td width="130" >Fecha:&nbsp;</td>
		        <td>
		        	<span>
                        <?php
                        $f=$Rs['fFecRegistro'];
                        echo ($f?$f->format("d-m-Y"):'-');?></span>
        			<span style=font-size:10px><?=($f?$f->format("h:i A"):'-')?></span>
		        </td>
		    </tr>

		    <tr>
		    	<td width="130" >N&ordm; Documento:&nbsp;</td>
		      <td style="text-transform:uppercase"><?=$Rs['cCodificacion']?></td>
		      <td width="130" >Digital:&nbsp;</td>
		      <td style="text-transform:uppercase">
		      	<?php
		        	$tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$_GET['iCodTramite']."'");
  						$RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
							if ($RsTramitePDF->descripcion != NULL AND $RsTramitePDF->descripcion!=' ') {
                            ?>
                            <a href="pdf_digital.php?iCodTramite=<?php echo utf8_encode(ucwords(strtolower($RsTramitePDF->iCodTramite)));?>
                                            "target="_blank" title="Documento Electronico">
                                <img src="images/1471041812_pdf.png" border="0" height="17" width="17">
                            </a>
                <?php       }else echo "-"?>
            <?php
		        	$sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='".$_GET['iCodTramite']."'";
      				$rsDw  = sqlsrv_query($cnx,$sqlDw);
      				if (sqlsrv_has_rows($rsDw) > 0){
      					$RsDw = sqlsrv_fetch_array($rsDw);
      					if ($RsDw["cNombreNuevo"] != ""){
      						if (file_exists("../cAlmacenArchivos/".trim($Rs1['nombre_archivo']))){
										$sqlCondicion = " SP_CONDICION_REGISTRO_TRABAJADOR '$Rs[iCodOficinaRegistro]', '".$_SESSION['iCodOficinaLogin']."','".$_SESSION['CODIGO_TRABAJADOR']."' ";
										$rsCondicion = sqlsrv_query($cnx,$sqlCondicion);
										$RsCondicion = sqlsrv_fetch_array($rsCondicion);
										if ($RsCondicion["Total"] == "1"){
											echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
										}else{
											$sqlCondicion2 = " SP_CONDICION_DOCUMENTO_REGISTRO '$Rs[iCodOficinaRegistro]' ";
											$rsCondicion2  = sqlsrv_query($cnx,$sqlCondicion2);
											$RsCondicion2  = sqlsrv_fetch_array($rsCondicion2);
											if($RsCondicion2["Total"]=="0"){
												echo "<a title=\"Documento Complementario\" href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
											}
										}
									}
								}
      				}else{
      					echo "<img src=images/space.gif width=16 height=16>";
      				}
						?>	
		      </td>
		    </tr>
	    
		    <tr>
              <td width="130"  valign="top">Asunto:&nbsp;</td>
		      <td width="300"><?= empty($Rs['cAsunto'])?"-":utf8_encode(ucwords(strtolower($Rs['cAsunto']))) ?></td>
		      <td width="130"  valign="top">Observaciones:&nbsp;</td>
		      <td width="300"><?= ($Rs['cObservaciones']===" ")?"-":utf8_encode(strtolower($Rs['cObservaciones'])) ?></td>
		    </tr>

		    <tr>
		        <td width="130" >Referencias:&nbsp;</td>
		        <td >
					<?php
					$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='".$_GET['iCodTramite']."'";
          			$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          			while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
          					$sqlTrRf="SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$RsRefs[iCodTramiteRef]'";
          					$rsTrRf=sqlsrv_query($cnx,$sqlTrRf);
          					$RsTrRf=sqlsrv_fetch_array($rsTrRf);
          					switch ($RsTrRf['nFlgTipoDoc']){
  										case 1: $ScriptPHP="registroDetalles.php"; break;
  										case 2: $ScriptPHP="registroOficinaDetalles.php"; break;
  										case 3: $ScriptPHP="registroSalidaDetalles.php"; break;
  									}
								?>
								<span><a href="<?=$ScriptPHP?>?iCodTramite=<?=$RsTrRf['iCodTramite']?>"><?=empty($RsRefs['cReferencia'])?"-":utf8_encode(ucwords(strtolower(trim($RsRefs['cReferencia']))))?></a></span>&nbsp;&nbsp;&nbsp;
								<?php } ?>								
		        </td>
                <td width="130"  valign="top">Estado:&nbsp;</td>
		        <td>
				    <?php
						switch ($Rs['nFlgEstado']) {
  							case 1:
									echo "Pendiente";
								break;
								case 2:
									echo "En Proceso";
								break;
								case 3:
									echo "Finalizado";
									$sqlFinTxt="SELECT * FROM Tra_M_Tramite_Movimientos WHERE nEstadoMovimiento=5 And cFlgTipoMovimiento!=4 AND iCodTramite='".$_GET['iCodTramite']."'";
                                    $rsFinTxt=sqlsrv_query($cnx,$sqlFinTxt);
                                    $RsFinTxt=sqlsrv_fetch_array($rsFinTxt);
                                    echo "<div style=color:#7C7C7C>"."Obs. ".utf8_encode(strtolower($RsFinTxt['cObservacionesFinalizar']??''))."</div>";
                                    echo "<div style=color:#0154AF>".(isset($RsFinTxt['fFecFinalizaresFinalizar'])?$RsFinTxt['fFecFinalizaresFinalizar']->format("d-m-Y"):'-')."</div>";
								break;
						}
					?>
		        </td>
		    </tr>
			<tr>
		        <td width="130" >Doc. Principal:&nbsp;</td>
		        <td >
					<?php
                        $rsTraDe=sqlsrv_query($cnx,"SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar ='".$Rs['iCodTramite']."' and cFlgTipoMovimiento != 5 ");
                        $RsTraDe=sqlsrv_fetch_array($rsTraDe);
                        $rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='".$RsTraDe['iCodTramite']."' ");
                        $RsTrax=sqlsrv_fetch_array($rsTrax);
                        switch ($RsTrax['nFlgTipoDoc']){
                                case 1: $ScriptPHP="registroDetalles.php"; break;
                                case 2: $ScriptPHP="registroOficinaDetalles.php"; break;
                                case 3: $ScriptPHP="registroSalidaDetalles.php"; break;
                                }
  				    ?>
                    <span><a href="<?=$ScriptPHP??''?>?iCodTramite=<?=$RsTraDe['iCodTramite']??''?>">
                            <?=trim($RsTrax['cCodificacion'])?>
                         </a>
                    </span>&nbsp;&nbsp;&nbsp;
		        </td>
                <td width="130"  valign="top">&nbsp;</td>
		        <td>        	
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
		  	<legend class="legend">
		  		<a href="javascript:;" onClick="muestra('zonaOficina')" class="LnkZonas">Flujo <img src="images/icon_expand.png" width="16" height="13" border="0"></a>
		  	</legend>
		    <div id="zonaOficina">
		    	<table border="0" align="center" width="860">
		    	<tr>
		       	<td class="headCellColum" width="100">Oficinas</td>
		       	<td class="headCellColum" width="200">Documento</td>
		       	<td class="headCellColum" width="300">Indicacion</td>
           	<td class="headCellColum" width="400">Responsable / Delegado</td>
           	<td class="headCellColum" width="120">Fecha Derivo</td>
           	<td class="headCellColum" width="120">Fecha de Aceptado</td>
		       	<td class="headCellColum" width="100">Estado</td>
           	<td width="106" class="headCellColum">Avance</td>
           	<td width="106" class="headCellColum">PDF</td>
          </tr>
		   	<?php 
		   		$sqlM = "SELECT * FROM Tra_M_Tramite_Movimientos 
		   						 WHERE (iCodTramite='".$_GET['iCodTramite']."' OR iCodTramiteRel='".$_GET['iCodTramite']."') AND 
		   						 			 (cFlgTipoMovimiento = 1 OR cFlgTipoMovimiento = 3 OR cFlgTipoMovimiento = 5) 
		   						 ORDER BY iCodMovimiento ASC";	
		   		//echo $sqlM; 
		   		$rsM  = sqlsrv_query($cnx,$sqlM);
    
                $filapdfelectronico=0;
                $contaMov =0;
		    	while ($RsM = sqlsrv_fetch_array($rsM)){
                    $color ='';
                    if ($color === "#CEE7FF"){
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

		    			<?php 
			    		 	echo "<table width=\"100\" border=\"0\"><tr>";
			    		 	$sqlOfiO = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsM['iCodOficinaOrigen']."'";
				       	$rsOfiO  = sqlsrv_query($cnx,$sqlOfiO);
				       	$RsOfiO  = sqlsrv_fetch_array($rsOfiO);
			       	 	echo "<td width=90 align=right><a href=\"javascript:;\" title=\"".utf8_encode(ucwords(strtolower(trim($RsOfiO['cNomOficina']))))."\">".$RsOfiO['cSiglaOficina']."</a></td>";
								echo "<td width=20>&nbsp;-&nbsp;</td>";
							 
			     	 	  $sqlOfiD = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsM['iCodOficinaDerivar']."'";
				        $rsOfiD  = sqlsrv_query($cnx,$sqlOfiD);
				        $RsOfiD  = sqlsrv_fetch_array($rsOfiD);
			     	 	  echo "<td width=90 align=left><a href=\"javascript:;\" title=\"".trim($RsOfiD['cNomOficina'])."\">".$RsOfiD['cSiglaOficina']."</a></td>";
			     	 	  echo "</tr></table>";
			     	 	?>
			    </td>
		    	<td valign="top" align="left" width="250">
		    		<?php
		       		if($RsM['cCodTipoDocDerivar']==''){
              			$sqlTipDoc1="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$Rs['cCodTipoDoc']."'";
					          $rsTipDoc1=sqlsrv_query($cnx,$sqlTipDoc1);
					          $RsTipDoc1=sqlsrv_fetch_array($rsTipDoc1);
			          		echo utf8_encode(ucwords(strtolower($RsTipDoc1['cDescTipoDoc'])))."<br>";
					echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles2.php?iCodTramite=".$Rs['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 850px; height: 370px; scrolling: auto; border:no\">";
			          		echo $Rs['cCodificacion'];
							echo "</a>";   
              }else{
              			$sqlTipDoc2="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$RsM['cCodTipoDocDerivar']."'";
					          $rsTipDoc2=sqlsrv_query($cnx,$sqlTipDoc2);
					          $RsTipDoc2=sqlsrv_fetch_array($rsTipDoc2);
			          		echo $RsTipDoc2['cDescTipoDoc']."<br>";
			          		echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles2.php?iCodTramite=".$RsM['iCodTramiteDerivar']."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 850px; height: 370px; scrolling: auto; border:no\">";
							echo $RsM['cNumDocumentoDerivar'];
							echo "</a>"; 							          	
              }		
			  		if($RsM['cFlgTipoMovimiento']==5){ echo $RsM['cReferenciaDerivar']; echo "<br/>";   echo "Referencia : Interno"; }
		       		?>
		    </td>
		    <td valign="top" align="left">
		       		<?php  $sqlIndi=" SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion = '".$RsM['iCodIndicacionDerivar']."'";
			 	$rsIndi=sqlsrv_query($cnx,$sqlIndi);
              	$RsIndi=sqlsrv_fetch_array($rsIndi);
              	echo utf8_encode($RsIndi["cIndicacion"]);
              	sqlsrv_free_stmt($rsIndi);
			 ?>
					
		    </td>
            <td valign="top" align="left">
             <?php
		       	if($RsM['iCodTrabajadorDerivar']!=""){
		       	$sqlTrbR="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsM['iCodTrabajadorDerivar']."'";
              	$rsTrbR=sqlsrv_query($cnx,$sqlTrbR);
              	$RsTrbR=sqlsrv_fetch_array($rsTrbR);
              	echo utf8_encode(ucwords(strtolower($RsTrbR["cNombresTrabajador"]." ".$RsTrbR["cApellidosTrabajador"])));
              	sqlsrv_free_stmt($rsTrbR);
		       		}
					if($RsM['iCodTrabajadorDelegado']!=""){
  					$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsM['iCodTrabajadorDelegado']."'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	echo "<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>";
						sqlsrv_free_stmt($rsDelg);
						echo "<div style=color:#0154AF>".(isset($RsM['fFecDerivar'])?$RsM['fFecDelegado']->format("d-m-Y G:i:s"):'-')/*date("d-m-Y", strtotime($RsM['fFecDelegado']))." ".date("G:i", strtotime($RsM['fFecDelegado']))*/."</div>";
        			
					}	
		       		?>
        </td>
		    <td valign="top">
		    	<span><?= (isset($RsM['fFecDerivar'])?$RsM['fFecDerivar']->format("d-m-Y G:i:s"):'-')?></span>
		    </td>
			<td align="center" valign="top">
      <?php
      	$sqlEstado = "SELECT iCodJefe,cNomJefe,FECHA_DOCUMENTO FROM Tra_M_Tramite WHERE iCodTramite = ".$RsM['iCodTramite'];
      	$rsEstado  = sqlsrv_query($cnx,$sqlEstado);
      	$RsEstado  = sqlsrv_fetch_array($rsEstado);

      	if($RsEstado['FECHA_DOCUMENTO'] == ""){
      		echo "<div style=color:#ff0000>sin aceptar</div>";
        }else{
       		echo "<div style=color:#0154AF>aceptado</div>";  
          $sqlfecha = "SELECT TOP 1 iCodMovimiento, iCodTramite,iCodOficinaOrigen,fFecRecepcion,iCodOficinaDerivar,
          													iCodTrabajadorDerivar,cCodTipoDocDerivar,cAsuntoDerivar,cObservacionesDerivar, 
          													fFecDerivar,iCodTrabajadorDelegado,fFecDelegado,nEstadoMovimiento,cFlgTipoMovimiento, 
          													cNumDocumentoDerivar,cReferenciaDerivar,iCodTramiteDerivar 
											 FROM Tra_M_Tramite_Movimientos 
											 WHERE (iCodTramite='".$_GET['iCodTramite']."' OR iCodTramiteRel='".$_GET['iCodTramite']."') 
															AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) 
											 ORDER BY iCodMovimiento DESC";
					$rsFecha = sqlsrv_query($cnx,$sqlfecha);
					$RsFecha = sqlsrv_fetch_array($rsFecha);
        	echo "<div style=color:#0154AF>".(isset($RsFecha['fFecRecepcion'])?$RsFecha['fFecRecepcion']->format("d-m-Y G:i:s"):'-')."</div>";
        }

      ?>
        </td>
		    <td valign="top" align="center">
		    	<?php
		    		if(($RsM['fFecRecepciongado']??'')!=""){
		     	 		switch ($RsM['nEstadoMovimiento']){
  							case 1:
									echo "En Proceso";
									break;
								case 2:
									echo "Derivado"; //movimiento derivado a otra oficina
									break;
								case 3:
									echo "Delegado";
									break;
								case 4:
									//echo "Respondido";
  								echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
  								break;
								case 5:
									echo "Finalizado";
									break;
							}
						}else{
						  if($RsM['cFlgTipoMovimiento']==5){ 
						  	echo "";
						 	}else{
								echo "Pendiente";
							}
						}
		     	?>
		    </td>
        <td>
					<?php
    				$sqlAvan = "SELECT TOP(1) * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento='".$RsM['iCodMovimiento']."' ORDER BY iCodAvance DESC";
    				$rsAvan  = sqlsrv_query($cnx,$sqlAvan);
						if(sqlsrv_has_rows($rsAvan) > 0){
     					$RsAvan = sqlsrv_fetch_array($rsAvan);
							echo "<hr>";
							echo "<div style=font-size:10px>".$RsAvan['cObservacionesAvance']."</div>";
						}
					?>
				</td>
				<td valign="top" align="center">
					<?php 

						if (isset($RsM['iCodTramiteDerivar'])) {
							$sqlDigital = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite=".$RsM['iCodTramiteDerivar'];
							$rsDigital  = sqlsrv_query($cnx,$sqlDigital);
							$RsDigital  = sqlsrv_fetch_array($rsDigital);
							if (isset($RsDigital['cNombreNuevo'])) {
							echo "<div><a href=\"download.php?direccion=../cAlmacenArchivos/&file=".$RsDigital['cNombreNuevo']."\"><img src=\"images/icon_download.png\" width=18 height=18 border=0 alt=\"Descargar Adjunto\"></a></div>";
							}
						}else{
							$sqlDigital = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite=".$_GET['iCodTramite'];
							$rsDigital  = sqlsrv_query($cnx,$sqlDigital);
							$RsDigital  = sqlsrv_fetch_array($rsDigital);
							if (isset($RsDigital['cNombreNuevo'])) {
							echo "<div><a href=\"download.php?direccion=../cAlmacenArchivos/&file=".$RsDigital['cNombreNuevo']."\"><img src=\"images/icon_download.png\" width=18 height=18 border=0 alt=\"Descargar Adjunto\"></a></div>";
							}
						}
                    
                        // DOCUMENTOS ELECTRONICOS  ---- max henrry
                        $filapdfelectronico+=1;
                        if($filapdfelectronico==1){
                            $RsM['iCodTramiteDerivar']=$_GET['iCodTramite'];
                        }
                        
                        $sqlPDF = "select * from Tra_M_Tramite where iCodTramite='".$RsM['iCodTramiteDerivar']."'";
                        $rsPDF  = sqlsrv_query($cnx,$sqlPDF);
                        $RsPDF  = sqlsrv_fetch_array($rsPDF);
                    
                        if (strlen(rtrim(ltrim($RsPDF['descripcion'])))>0) {
                            ?>
                                <a href="pdf_digital.php?iCodTramite=<?=$RsM['iCodTramiteDerivar']?>" title="Documento Electronico"
                                   rev="width: 970px; height: 550px; scrolling: auto; border:no" target="_blank">
                                <img src="images/1471041812_pdf.png" border="0" height="17" width="17">
                                </a>&nbsp;
                            <?php
                        }
                        // --------------- max henrry
	 				?>
				</td>
		  </tr> 
		  	<?php

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
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaCopias')" class="LnkZonas">Copias <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div  id="zonaCopias">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="100">Oficinas</td>
		       <td class="headCellColum" width="200">Documento</td>
		       <td class="headCellColum" width="400">Indicacion</td>
               <td class="headCellColum" width="400">Responsable / Delegado</td>
               <td class="headCellColum" width="120">Fecha Derivo</td>
               <td class="headCellColum" width="120">Fecha de Aceptado</td>
               <td class="headCellColum" width="100">Estado</td>
                <td width="106" class="headCellColum">Avance</td>
		    </tr>
		   	<?php 
		   		$sqlM = "SELECT * FROM Tra_M_Tramite_Movimientos 
		   						 WHERE (iCodTramite='".$_GET['iCodTramite']."' OR iCodTramiteRel='".$_GET['iCodTramite']."') AND 
		   						 			 (cFlgTipoMovimiento=4) 
		   						 ORDER BY iCodMovimiento ASC";
		   		$rsM  = sqlsrv_query($cnx,$sqlM);
		    	while ($RsM = sqlsrv_fetch_array($rsM)){
		      	if ($color === "#FFECEC"){
			  			$color = "#F9F9F9";
		  			}else{
			  			$color = "#FFECEC";
		  			}
		  			if ($color == ""){
			  			$color = "#F9F9F9";
		  			}	
				?>
		    <tr bgcolor="<?=$color?>">
		    <td valign="top">
		    			
		    		 <?php
		    		 echo "<table width=\"100\" border=\"0\"><tr>";
		    		 
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsM['iCodOficinaOrigen']."'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<td width=90 align=right><a href=\"javascript:;\" title=\"".trim($RsOfiO['cNomOficina'])."\">".$RsOfiO['cSiglaOficina']."</a></td>";
							
						 echo "<td width=20>&nbsp;-&nbsp;</td>";
						 
		     	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsM['iCodOficinaDerivar']."'";
			       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
		     	 	 echo "<td width=90 align=left><a href=\"javascript:;\" title=\"".trim($RsOfiD['cNomOficina'])."\">".$RsOfiD['cSiglaOficina']."</a></td>";
		     	 	 
		     	 	 echo "</tr></table>";
		     	 	?>
		     	
		    </td>
            <td valign="top" align="left" width="250">
         		  <?php
		       		if($RsM['cCodTipoDocDerivar']==''){
              			$sqlTipDoc1="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$Rs['cCodTipoDoc']."'";
					          $rsTipDoc1=sqlsrv_query($cnx,$sqlTipDoc1);
					          $RsTipDoc1=sqlsrv_fetch_array($rsTipDoc1);
			          		echo $RsTipDoc1['cDescTipoDoc']."<br>";
							echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles2.php?iCodTramite=".$Rs['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 850px; height: 370px; scrolling: auto; border:no\">";
			          		echo $Rs['cCodificacion'];
							echo "</a>";   
              }Else{
              			$sqlTipDoc2="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$RsM['cCodTipoDocDerivar']."'";
					          $rsTipDoc2=sqlsrv_query($cnx,$sqlTipDoc2);
					          $RsTipDoc2=sqlsrv_fetch_array($rsTipDoc2);
			          		echo $RsTipDoc2['cDescTipoDoc']."<br>";
			          		echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles2.php?iCodTramite=".$RsM['iCodTramiteDerivar']."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 850px; height: 370px; scrolling: auto; border:no\">";
							echo $RsM['cNumDocumentoDerivar'];
							echo "</a>";             	
              }
		       		?>
		    </td>
             <td valign="top" align="left">
             <?php  $sqlIndi=" SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion = '".$RsM['iCodIndicacionDerivar']."'";
			 	$rsIndi=sqlsrv_query($cnx,$sqlIndi);
              	$RsIndi=sqlsrv_fetch_array($rsIndi);
              	echo $RsIndi["cIndicacion"];
              	sqlsrv_free_stmt($rsIndi);
			 ?>
            </td>		    	
		    <td valign="top" align="left">
		       		<?php
		       		if($RsM['iCodTrabajadorDerivar']!=""){
		       			$sqlTrbR="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsM['iCodTrabajadorDerivar']."'";
              	$rsTrbR=sqlsrv_query($cnx,$sqlTrbR);
              	$RsTrbR=sqlsrv_fetch_array($rsTrbR);
              	echo $RsTrbR["cNombresTrabajador"]." ".$RsTrbR["cApellidosTrabajador"];
              	sqlsrv_free_stmt($rsTrbR);
		       		}
						if($RsM['iCodTrabajadorDelegado']!=""){
  					$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsM['iCodTrabajadorDelegado']."'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	echo "<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>";
						sqlsrv_free_stmt($rsDelg);
						echo "<div style=color:#0154AF>".(isset($RsM['fFecDelegado'])?$RsM['fFecDelegado']->format("d-m-Y G:i:s"):'-')/*date("d-m-Y", strtotime($RsM['fFecDelegado']))." ".date("G:i", strtotime($RsM['fFecDelegado']))*/."</div>";
					}
		       		?>
		    </td>
           
		    <td valign="top">
		       		<span><?=(isset($RsM['fFecDerivar'])?$RsM['fFecDerivar']->format("d-m-Y G:i:s"):'-')/*date("d-m-Y", strtotime($RsM['fFecDerivar']))*/?></span>
		    </td>
			<td align="center" valign="top">
            <?php
        	if($RsM['fFecRecepciongado']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>aceptado</div>";
        			echo "<div style=color:#0154AF>".(isset($RsM['fFecRecepciongado'])?$RsM['fFecRecepciongado']->format("d-m-Y G:i:s"):'-')/*date("d-m-Y", strtotime($RsM['fFecRecepciongado']))*/."</div>";
        			//echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsM['fFecRecepciongado']))."</div>";
        	}
        	?>
            </td>
		    <td valign="top" align="center">
		     	 		<?php
		     	 		if($RsM['fFecRecepciongado']==""){
		     	 			switch ($RsM['nEstadoMovimiento']) {
  							case 1:
									echo "Pendiente";
								break;
								case 2:
									echo "En Proceso"; //movimiento derivado a otra ofi
								break;
								case 3:
									echo "En Proceso"; //por delegar a otro trabajador
								break;
								case 4:
									echo "Respondido";
								break;
								case 5:
									echo "Finalizado";
								break;
								}
  				}Else if($RsM['fFecRecepciongado']!=""){ 
						switch ($RsM['nEstadoMovimiento']) {
  							case 1:
									echo "En Proceso";
								break;
								case 2:
									echo "En Proceso"; //movimiento derivado a otra ofi
								break;
								case 3:
									echo "En Proceso"; //por delegar a otro trabajador
								break;
								case 4:
									echo "Respondido";
								break;
								case 5:
									echo "Finalizado";
								break;
								}  					
  				}
		     	 		?>
		    </td>
             <td>
<?php
    $sqlAvan="SELECT TOP(1) * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento='".$RsM['iCodMovimiento']."'  ORDER BY iCodAvance DESC";
    $rsAvan=sqlsrv_query($cnx,$sqlAvan);
	if(sqlsrv_has_rows($rsAvan)>0){
     $RsAvan=sqlsrv_fetch_array($rsAvan);
		echo "<hr>";
		echo "<div style=font-size:10px>".$RsAvan['cObservacionesAvance']."</div>";
	}
?>	
</td>
		    </tr> 
		    <?php
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
		    <div  id="zonaTrabajador">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="80">Oficina</td>
		       <td class="headCellColum" width="160">Origen</td>
		       <td class="headCellColum" width="160">Destino</td>
		       <td class="headCellColum" width="110">Enviado</td>
		       <td class="headCellColum" width="300">Observaciones</td>
		    </tr>
		   	<?php 
		   	$sqlMvTr="SELECT * FROM Tra_M_Tramite_Trabajadores WHERE iCodTramite='".$Rs['iCodTramite']."' ORDER BY iCodMovTrabajador ASC";
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
		       	$sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsMvTr['iCodOficina']."'";
			      $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			      $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO['cNomOficina'])."\">".$RsOfiO['cSiglaOficina']."</a>";
		       	?>		    	
		    </td>
		    <td valign="top">
		       	<?php
          	$rsMvTrOr=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsMvTr['iCodTrabajadorOrigen']."'");
          	$RsMvTrOr=sqlsrv_fetch_array($rsMvTrOr);
          	echo $RsMvTrOr["cApellidosTrabajador"]." ".$RsMvTrOr["cNombresTrabajador"];
						sqlsrv_free_stmt($rsMvTrOr);
        		?>
		    </td>
		    <td valign="top">
		       	<?php
          	$rsMvTrDs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsMvTr['iCodTrabajadorDestino']."'");
          	$RsMvTrDs=sqlsrv_fetch_array($rsMvTrDs);
          	echo $RsMvTrDs["cApellidosTrabajador"]." ".$RsMvTrDs["cNombresTrabajador"];
						sqlsrv_free_stmt($rsMvTrDs);
        		?>
		    </td>
		    <td valign="top">
		    		<span><?=(isset($RsMvTr['fFecEnvio'])?$RsMvTr['fFecEnvio']->format("d-m-Y G:i:s"):'-')/*date("d-m-Y H:i", strtotime($RsMvTr['fFecEnvio']))*/?></span>
		    </td>
		    <td valign="top" align="left"><?=$RsMvTr['cObservaciones']?></td>		       
		    </tr> 
		    <?php } ?>
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
		   	<?php 
		   	$sqlMvTr="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='".$Rs['iCodTramite']."' And cFlgTipoMovimiento= 6 ORDER BY iCodMovimiento ASC";
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
		       	$sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsMvTr['iCodOficinaDerivar']."'";
			      $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			      $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO['cNomOficina'])."\">".$RsOfiO['cSiglaOficina']."</a>";
		       	?>		    	
		    </td>
		    <td valign="top">
		       	<?php
          	$rsMvTrOr=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsMvTr['iCodTrabajadorEnviar']."'");
          	$RsMvTrOr=sqlsrv_fetch_array($rsMvTrOr);
          	echo $RsMvTrOr["cApellidosTrabajador"]." ".$RsMvTrOr["cNombresTrabajador"];
						sqlsrv_free_stmt($rsMvTrOr);
        		?>
		    </td>
		   <td valign="top">
		    		<span><?=(isset($RsMvTr['fFecDelegado'])?$RsMvTr['fFecDelegado']->format("d-m-Y G:i:s"):'-')/*date("d-m-Y G:i", strtotime($RsMvTr['fFecDelegado']))*/?></span>
		    </td>
		    <td valign="top" align="left"><?=$RsMvTr['cObservacionesDerivar']?></td>		       
		    </tr> 
		    <?php } ?>
		    </table>
		    </div>
		    <img src="images/space.gif" width="0" height="0"> 
		  	</fieldset>

<div>
    <script language="javascript" type="text/javascript">
        function muestra(nombrediv) {
            if(document.getElementById(nombrediv).style.display == '') {
                document.getElementById(nombrediv).style.display = 'none';
            } else {
                document.getElementById(nombrediv).style.display = '';
            }
        }
    </script>
</body>
</html>
<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
