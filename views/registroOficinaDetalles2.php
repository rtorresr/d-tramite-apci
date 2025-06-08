<?php
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
                        echo $Rs['cCodTipoDoc']??'-';
			          $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$Rs['cCodTipoDoc']."'";
			          $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			          $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			          echo utf8_encode(ucwords(strtolower($RsTipDoc['cDescTipoDoc'])));
		            ?>
		        </td>
		        <td width="130" >Fecha:&nbsp;</td>
		        <td>
		        	<span><?=$Rs['fFecRegistro']->format("d-m-Y")?></span>
        			<span style=font-size:10px><?=$Rs['fFecRegistro']->format("h:i A")?></span>
		        </td>
		    </tr> 
		    
		    <tr>
		        <td width="130" >N&ordm; Documento:&nbsp;</td>
		        <td style="text-transform:uppercase"><?=$Rs['cCodificacion']??'-'?></td>
		        <td width="130" >Digital:&nbsp;</td>
		        <td style="text-transform:uppercase">
		        		<?php
						$sqlDw="SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='".($_GET['iCodTramite']??'')."'";
      					$rsDw=sqlsrv_query($cnx,$sqlDw);
      					if(sqlsrv_has_rows($rsDw)>0){
      						$RsDw=sqlsrv_fetch_array($rsDw);
      						if($RsDw["cNombreNuevo"]!=""){
				 						if (file_exists("../cAlmacenArchivos/".trim($Rs1['nombre_archivo']))){
											echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
										}
									}
      					}Else{
      						echo "<img src=images/space.gif width=16 height=16>";
      					}
      					?>	
		        </td>
		    </tr>
	    
		    <tr>
		        <td width="130"  valign="top">Asunto:&nbsp;</td>
		        <td width="300"><?=utf8_encode(strtolower($Rs['cAsunto']))?></td>
		        <td width="130"  valign="top">Observaciones:&nbsp;</td>
		        <td width="300"><?=utf8_encode(strtolower($Rs['cObservaciones']))?></td>
		    </tr>

		    <tr>
		        <td width="130" >Referencias:&nbsp;</td>
		        <td >
								<?php
								$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='".($_GET['iCodTramite']??'')."'";
          			$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          			while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
          					$sqlTrRf="SELECT * FROM Tra_M_Tramite WHERE cCodificacion='".$RsRefs['cReferencia']."'";
          					$rsTrRf=sqlsrv_query($cnx,$sqlTrRf);
          					$RsTrRf=sqlsrv_fetch_array($rsTrRf);
          					switch ($RsTrRf['nFlgTipoDoc']){
  										case 1: $ScriptPHP="registroDetalles.php"; break;
  										case 2: $ScriptPHP="registroOficinaDetalles.php"; break;
  										case 3: $ScriptPHP="registroSalidaDetalles.php"; break;
  									}
								?>
								<span><a href="<?=$ScriptPHP?>?iCodTramite=<?=$RsTrRf['iCodTramite']?>"><?=trim($RsRefs['cReferencia'])?></a></span>&nbsp;&nbsp;&nbsp;
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
									$sqlFinTxt="SELECT * FROM Tra_M_Tramite_Movimientos WHERE nEstadoMovimiento=5 And cFlgTipoMovimiento!=4 AND iCodTramite='".($_GET['iCodTramite']??'')."'";
			            $rsFinTxt=sqlsrv_query($cnx,$sqlFinTxt);
			            $RsFinTxt=sqlsrv_fetch_array($rsFinTxt);
			            echo "<div style=color:#7C7C7C>".$RsFinTxt['cObservacionesFinalizar']."</div>";
			            echo "<div style=color:#0154AF>".$RsFinTxt['fFecFinalizar']->format("d-m-Y")."</div>";
								break;
								}
								?>		        	
		        </td>
		    </tr>
		    <tr>
		        <td width="130" >Doc. Principal:&nbsp;</td>
		        <td >
								<?php
								 
	$rsTraDe=sqlsrv_query($cnx,"SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar ='".$Rs['iCodTramite']."' ");
	$RsTraDe=sqlsrv_fetch_array($rsTraDe);
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='".$RsTraDe['iCodTramite']."' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		switch ($RsTrax['nFlgTipoDoc']){
  				case 1: $ScriptPHP="registroDetalles.php"; break;
  				case 2: $ScriptPHP="registroOficinaDetalles.php"; break;
  				case 3: $ScriptPHP="registroSalidaDetalles.php"; break;
  				}
  				?>
                    <span><a href="<?=$ScriptPHP??''?>?iCodTramite=<?=$RsTraDe['iCodTramite']?>"><?=trim($RsTrax['cCodificacion'])?></a></span>&nbsp;&nbsp;&nbsp;
																
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
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaOficina')" class="LnkZonas">Flujo <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaOficina">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="100">Oficinas</td>
		       <td class="headCellColum" width="200">Documento</td>
		       <td class="headCellColum" width="300">Indicacion</td>
           <td class="headCellColum" width="400">Responsable</td>
		       <td class="headCellColum" width="120">Fecha Derivo</td>
                <td class="headCellColum" width="120">Fecha de Aceptado</td>
		       <td class="headCellColum" width="100">Estado</td>
		    </tr>
		   	<?php
		   	$sqlM="SELECT * FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='".($_GET['iCodTramite']??'')."' OR iCodTramiteRel='".($_GET['iCodTramite']??'')."') AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) ORDER BY iCodMovimiento ASC";
		   	$rsM=sqlsrv_query($cnx,$sqlM);
		   	//echo $sqlM;
            $contaMov =0;
		    while ($RsM=sqlsrv_fetch_array($rsM)){
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
			          		echo utf8_encode(ucwords(strtolower($RsTipDoc1['cDescTipoDoc'])))."<br>";
							echo "<a style=\"color:#0067CE\" href=\"registroDetalles.php?iCodTramite=".$Rs['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 850px; height: 350px; scrolling: auto; border:no\">";
			          		echo $Rs['cCodificacion'];
							echo "</a>";   
              }Else{
              			$sqlTipDoc2="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$RsM['cCodTipoDocDerivar']."'";
					          $rsTipDoc2=sqlsrv_query($cnx,$sqlTipDoc2);
					          $RsTipDoc2=sqlsrv_fetch_array($rsTipDoc2);
			          		echo utf8_encode(ucwords(strtolower($RsTipDoc2['cDescTipoDoc'])))."<br>";
			          		echo "<a style=\"color:#0067CE\" href=\"registroDetalles.php?iCodTramite=".$RsM['iCodTramiteDerivar']."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 850px; height: 350px; scrolling: auto; border:no\">";
							echo $RsM['cNumDocumentoDerivar'];
							echo "</a>";             	
              }
		       		?>
		    </td>
		    <td valign="top" align="left">
		       		<?php
                    echo ($RsM['iCodIndicacionDerivar']?'':'-');
                    $sqlIndi=" SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion = '".$RsM['iCodIndicacionDerivar']."'";
			 	$rsIndi=sqlsrv_query($cnx,$sqlIndi);
              	$RsIndi=sqlsrv_fetch_array($rsIndi);
              	echo utf8_encode(ucwords(strtolower($RsIndi["cIndicacion"])));
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
					}		
		       		?>
            </td>
		    <td valign="top">
		       		<span><?=($RsM['fFecDerivar']? $RsM['fFecDerivar']->format("d-m-Y"): '-' )?></span>
		    </td>
			<td align="center" valign="top">
            <?php
        	if($RsM['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000>Sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>Aceptado</div>";
        			echo "<div style=color:#0154AF>".($RsM['fFecRecepcion']?$RsM['fFecRecepcion']->format("d-m-Y"):'-')."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".($RsM['fFecRecepcion']?$RsM['fFecRecepcion']->format("h:i A"):'-')."</div>";
        	}
        	?>
            </td>
		    <td valign="top" align="center">
		     	 		<?php
						  if($RsM['fFecRecepcion']!=""){
		     	 			switch ($RsM['nEstadoMovimiento']) {
  							case 1:
									echo "En Proceso";
								break;
								case 2:
									echo "Derivado"; //movimiento derivado a otra ofi
								break;
								case 3:
									echo "Delegado";
								break;
								case 5:
									echo "Finalizado";
								break;
								}
						  } else{
							  echo "Pendiente";
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
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaCopias')" class="LnkZonas">Copias <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div style="display:none" id="zonaCopias">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="200">Oficinas</td>
		       <td class="headCellColum" width="400">Indicacion</td>
               <td class="headCellColum" width="400">Responsable</td>
               <td class="headCellColum" width="120">Fecha Derivo</td>
               <td class="headCellColum" width="120">Fecha de Aceptado</td>
               <td class="headCellColum" width="100">Estado</td>
		    </tr>
		   	<?php
		   	$sqlM="SELECT * FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='".($_GET['iCodTramite']??'')."' OR iCodTramiteRel='".($_GET['iCodTramite']??'')."') AND (cFlgTipoMovimiento=4) ORDER BY iCodMovimiento ASC";
		   	$rsM=sqlsrv_query($cnx,$sqlM);
		   	//echo $sqlM;
		    while ($RsM=sqlsrv_fetch_array($rsM)){
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
		    		 echo "<table width=\"200\" border=\"0\"><tr>";
		    		 
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
		    <td valign="top" align="left">
             <?php $sqlIndi=" SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion = '".$RsM['iCodIndicacionDerivar']."'";
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
              	echo utf8_encode(ucwords(strtolower($RsTrbR["cNombresTrabajador"]." ".$RsTrbR["cApellidosTrabajador"])));
              	sqlsrv_free_stmt($rsTrbR);
		       		}
		       		?>
		    </td>
		    <td valign="top">
		       		<span><?=$RsM['fFecDerivar']->format("d-m-Y")?></span>
		    </td>
			<td align="center" valign="top">
            <?php
        	if($RsM['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>aceptado</div>";
        			echo "<div style=color:#0154AF>".($RsM['fFecRecepcion']?$RsM['fFecRecepcion']->format("d-m-Y"):'-')."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".($RsM['fFecRecepcion']?$RsM['fFecRecepcion']->format("h:i A"):'-')."</div>";
        	}
        	?>
            </td>
		    <td valign="top" align="center">
		     	 		<?php
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
									echo "Finalizado";
								break;
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

		</table>
    <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
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
