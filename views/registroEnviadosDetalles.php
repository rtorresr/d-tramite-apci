<? header('Content-Type: text/html; charset=UTF-8');
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
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs=sqlsrv_fetch_array($rs);
		?>
<div class="AreaTitulo">DETALLE DE DOCUMENTO TRABAJADOR</div>
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
		        	<span><?=date("d-m-Y G:i:s", strtotime(substr($Rs['fFecRegistro'], 0, -6)))/*date("d-m-Y", strtotime($Rs['fFecRegistro']))*/?></span>
        			<span style=font-size:10px><?/*=date("h:i A", strtotime($Rs['fFecRegistro']))*/?></span>
		        </td>
		    </tr> 
		    
		    <tr>
		        <td width="130" >N&ordm; Documento:&nbsp;</td>
		        <td style="text-transform:uppercase"><?=$Rs[cCodificacion]?></td>
		        <td width="130" >Observaciones:</td>
	        <td style="text-transform:uppercase"><?=$Rs[cObservaciones]?></td>
		    </tr>
	    
		    <tr>
		        <td width="130"  valign="top">Asunto:&nbsp;</td>
		        <td width="300"><?=$Rs['cAsunto']?></td>
		        <td width="130"  valign="top">Digital:</td>
		        <td width="300">
		        <?php
	            	$tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
	  				$RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
					
					if ($RsTramitePDF->descripcion != NULL AND $RsTramitePDF->descripcion != ' ') {
	            ?>
	            <a href="registroInternoDocumento_pdf.php?iCodTramite=<?php echo $RsTramitePDF->iCodTramite;?>" target="_blank" title="Documento Electrónico">
	            	<img src="images/1471041812_pdf.png" border="0" height="17" width="17">
	            </a>
	            <?php } ?>
		        <?php
						$sqlDw="SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
      					$rsDw=sqlsrv_query($cnx,$sqlDw);
      					if(sqlsrv_has_rows($rsDw)>0){
      						$RsDw=sqlsrv_fetch_array($rsDw);
      						if($RsDw["cNombreNuevo"]!=""){
				 						if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
											echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
										}
									}
      					}Else{
      						echo "<img src=images/space.gif width=16 height=16>";
      					}
								?></td>
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
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaOficina')" class="LnkZonas">Flujo <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaOficina">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="205">Trabajador Emisor</td>
		       <td class="headCellColum" width="316">Trabajador Receptor</td>
		       <td class="headCellColum" width="106">Fecha Derivo</td>
		       <td class="headCellColum" width="215">Observaci&oacute;n</td>
		    </tr>
		   	<? 
		   	$sqlM="SELECT * FROM Tra_M_Tramite_Trabajadores  WHERE iCodTramite='$Rs[iCodTramite]'  ORDER BY iCodMovTrabajador ASC";
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
		       	  $sqlTrab="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsM[iCodTrabajadorOrigen]'";
			      $rsTrab=sqlsrv_query($cnx,$sqlTrab);
			      $RsTrab=sqlsrv_fetch_array($rsTrab);
		       	  echo $RsTrab[cNombresTrabajador]." ".$RsTrab[cApellidosTrabajador]." ";
				  ?>		     	
		    </td>		    	
		    <td valign="top" align="left">
		       		<?
		       	  $sqlTraD="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsM[iCodTrabajadorDestino]'";
			      $rsTraD=sqlsrv_query($cnx,$sqlTraD);
			      $RsTraD=sqlsrv_fetch_array($rsTraD);
		     	  echo $RsTraD[cNombresTrabajador]." ".$RsTraD[cApellidosTrabajador]." ";
		       		?>
		    </td>
		    <td valign="top"> 
		       		<span><?=date("d-m-Y", strtotime(substr($RsM[fFecEnvio], 0, -6)))/*date("d-m-Y", strtotime($RsM[fFecEnvio]))*/?></span>
		    </td>

		    <td valign="top" align="center"><?=$RsM[cObservaciones];?>
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

<div>		
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
