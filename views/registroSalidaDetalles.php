<?php
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
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
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

<div class="AreaTitulo">DETALLE DE DOCUMENTO SALIDA</div>
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
		        		<? 
			          $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$Rs[cCodTipoDoc]'";
			          $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			          $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			          echo $RsTipDoc['cDescTipoDoc'];
		            ?>
		        </td>
		        <td width="130" >Fecha:&nbsp;</td>
		        <td>
		        	<span><?echo date("d-m-Y G:i:s", strtotime($Rs['fFecRegistro']))?></span>
        			<span style=font-size:10px><?/*=date("h:i A", strtotime($Rs['fFecRegistro']))*/?></span>
		        </td>
		    </tr> 
		    
		    <tr>
		        <td width="130" >N&ordm; Documento:&nbsp;</td>
		        <td style="text-transform:uppercase"><?=$Rs[cCodificacion]?></td>
		        <!-- <td width="130" >Referencia:&nbsp;</td>
		        <td style="text-transform:uppercase"><?=$Rs[cReferencia]?></td> -->
		    </tr>

		    <tr>
		        <td width="130" >Solicitado por:&nbsp;</td>
		        <td width="300">
								<?
								$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorSolicitado]'";
              	$rsTrb=sqlsrv_query($cnx,$sqlTrb);
              	$RsTrb=sqlsrv_fetch_array($rsTrb);
              	echo $RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"];
              	sqlsrv_free_stmt($rsTrb);
								?>		        	
		        </td>
		        <td width="130"  valign="top"></td>
		        <td width="300">
		        	
		        </td>
		    </tr>
	    
		    <tr>
		        <td width="130"  valign="top">Asunto:&nbsp;</td>
		        <td width="300"><?=$Rs['cAsunto']?></td>
		        <td width="130"  valign="top">Observaciones:&nbsp;</td>
		        <td width="300"><?=$Rs[cObservaciones]?></td>
		    </tr>




		    <tr>
		        <td width="130"  valign="top">Folios:&nbsp;</td>
		        <td width="300"><?=$Rs[nNumFolio]?></td>
		        <td width="130"  valign="top">Fecha Plazo:&nbsp;</td>
		        <td width="300">
		        	<?
		        	if($Rs[fFecPlazo]!=""){
		        		echo date("d-m-Y", strtotime($Rs[fFecPlazo]));
		        	}
		        	?>
		        </td>
		    </tr>	
		    
		    <tr>
		        <td width="130"  valign="top">Requiere Respuesta:&nbsp;</td>
		        <td width="300">
		        		<?
		        		if($Rs[nFlgRpta]==""){
		        			echo "No";
		        		}Else{
		        			echo "Si";
		        		}
		        		?>
		        </td>
		        <td width="130"  valign="top">Estado:&nbsp;</td>
		        <td width="300">
		        		<?
		        		switch ($Rs[nFlgEstado]) {
  							case 1: 
  									echo "Pendiente";
			     			break;
			     			case 2:
			     					echo "En Proceso";
			     			break;
			     			case 4:
			     					echo "Finalizado";
			     			break;
			     			}
		        		?>
		        </td>
		    </tr>
		    <tr>
		      <td >Destino:&nbsp;</td>
		      <td><?
								if($Rs[iCodRemitente]!=""){
										$sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
			          		$rsRemi=sqlsrv_query($cnx,$sqlRemi);
			          		$RsRemi=sqlsrv_fetch_array($rsRemi);
			          		echo $RsRemi['cNombre'];
			          }Else{
			          		echo "Multiple";
			          }
								?></td>
		    <td  valign="top">Digital:</td>
		    <td>
		    	<?php
	            	$tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
	  				$RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
					
					if ($RsTramitePDF->descripcion != NULL AND $RsTramitePDF->descripcion!=' ') {
	            ?>
	            <a href="registerDoc/pdf_digital_salida.php?iCodTramite=<?php echo $RsTramitePDF->iCodTramite;?>" target="_blank" title="Documento Electrónico">
	            	<img src="images/1471041812_pdf.png" border="0" height="17" width="17">
	            </a>
	            <?php } ?>
		      	<?php
					$sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
      				$rsDw  = sqlsrv_query($cnx,$sqlDw);
      				
      				if (sqlsrv_has_rows($rsDw) > 0){
      					$RsDw = sqlsrv_fetch_array($rsDw);
      					
      					if ($RsDw["cNombreNuevo"] != ""){
				 			if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
								$sqlCondicion = " SP_CONDICION_REGISTRO_TRABAJADOR '$Rs[iCodOficinaRegistro]', '".$_SESSION['iCodOficinaLogin']."','".$_SESSION['CODIGO_TRABAJADOR']."' ";
								$rsCondicion = sqlsrv_query($cnx,$sqlCondicion);
								$RsCondicion = sqlsrv_fetch_array($rsCondicion);
							
								if ($RsCondicion["Total"] == "1"){
									echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
								}else{
									$sqlCondicion2 = " SP_CONDICION_DOCUMENTO_REGISTRO '$Rs[iCodOficinaRegistro]' ";
									$rsCondicion2  = sqlsrv_query($cnx,$sqlCondicion2);
									$RsCondicion2  = sqlsrv_fetch_array($rsCondicion2);
									
									if ($RsCondicion2["Total"] == "0"){
										echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
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
		      <td >Referencias:</td>
		      <td><?
								$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_GET[iCodTramite]'";
          			$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          			while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
          					$sqlTrRf="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$RsRefs[cReferencia]'";
          					$rsTrRf=sqlsrv_query($cnx,$sqlTrRf);
          					$RsTrRf=sqlsrv_fetch_array($rsTrRf);
          					switch ($RsTrRf[nFlgTipoDoc]){
  										case 1: $ScriptPHP="registroDetalles.php"; break;
  										case 2: $ScriptPHP="registroOficinaDetalles.php"; break;
  										case 3: $ScriptPHP="registroSalidaDetalles.php"; break;
  									}
								?>
								<span><a href="<?=$ScriptPHP?>?iCodTramite=<?=$RsTrRf[iCodTramite]?>"><?=trim($RsRefs[cReferencia])?></a></span>&nbsp;&nbsp;&nbsp;
								<?php}?></td>
		      <td  valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
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
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaCopias')" class="LnkZonas">Copias <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaCopias">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="200">Oficinas</td>
		       <td class="headCellColum" width="400">Responsable</td>
               <td class="headCellColum" width="400">Indicacion</td>
		       <td class="headCellColum" width="120">Fecha Derivo</td>
		       <td class="headCellColum" width="100">Estado</td>
		    </tr>
		   	<? 
		   	$sqlM="SELECT * FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='$_GET[iCodTramite]' OR iCodTramiteRel='$_GET[iCodTramite]') AND (cFlgTipoMovimiento=4) ORDER BY iCodMovimiento ASC";
		   	$rsM=sqlsrv_query($cnx,$sqlM);
		   	//echo $sqlM;
		    while ($RsM=sqlsrv_fetch_array($rsM)){
		      	if ($color == "#FFECEC"){
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
		    			
		    		 <? 
		    		 echo "<table width=\"200\" border=\"0\"><tr>";
		    		 
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaOrigen]'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<td width=90 align=right><a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a></td>";
							
						 echo "<td width=20>&nbsp;-&nbsp;</td>";
						 
		     	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaDerivar]'";
			       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
		     	 	 echo "<td width=90 align=left><a href=\"javascript:;\" title=\"".trim($RsOfiD[cNomOficina])."\">".$RsOfiD[cSiglaOficina]."</a></td>";
		     	 	 
		     	 	 echo "</tr></table>";
		     	 	?>
		     	
		    </td>		    	
		    <td valign="top" align="left">
		       		<?
		       		if($RsM[iCodTrabajadorDerivar]!=""){
		       			$sqlTrbR="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsM[iCodTrabajadorDerivar]'";
              	$rsTrbR=sqlsrv_query($cnx,$sqlTrbR);
              	$RsTrbR=sqlsrv_fetch_array($rsTrbR);
              	echo $RsTrbR["cNombresTrabajador"]." ".$RsTrbR["cApellidosTrabajador"];
              	sqlsrv_free_stmt($rsTrbR);
		       		}
		       		?>
		    </td>
            <td valign="top" align="left">
             <?  $sqlIndi=" SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion = '$RsM[iCodIndicacionDerivar]'";
			 	$rsIndi=sqlsrv_query($cnx,$sqlIndi);
              	$RsIndi=sqlsrv_fetch_array($rsIndi);
              	echo $RsIndi["cIndicacion"];
              	sqlsrv_free_stmt($rsIndi);
			 ?>
            </td>
		    <td valign="top">
		       		<span><?=date("d-m-Y", strtotime($RsM['fFecDerivar']))?></span>
		    </td>

		    <td valign="top" align="center">
		     	 	<?
		     	 		if($RsM[fFecRecepcion]==""){
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
  				}Else if($RsM[fFecRecepcion]!=""){ 
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
