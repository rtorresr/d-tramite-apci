<?
include_once("../conexion/conexion.php");
include("secure_string.php");
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_web_window.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta Estado del Tramite
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creaci�n del programa.
 
------------------------------------------------------------------------


*****************************************************************************************/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link rel="stylesheet" href="css/detalle_web.css" type="text/css" />
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
require_once("../conexion/conexion.php");
   if($_GET['cCodificacion']!=""){ //obtener el codigo del documento
   $x= secureSQL($_GET['cCodificacion']);
   
  // $x=str_replace($_GET['cCodificacion'],"'","''");
   	$sqlCod= "SP_WEBCONSULTA_MAESTRA_LISTA '$x'  ";
  
    //$sqlCod=" SELECT * FROM Tra_M_Tramite WHERE cCodificacion='".$_GET['cCodificacion']."' ";
	$rsCod=sqlsrv_query($cnx,$sqlCod);
	$numrows=sqlsrv_has_rows($rsCod);
    if($numrows==0){ 
		echo "No Se Encuentra ese Documento<br>";
    }
	else {
	$RsCod=sqlsrv_fetch_array($rsCod);
 		
		$rs=sqlsrv_query($cnx,"SP_WEBCONSULTA_MAESTRA_LISTAXCODTRAMITE '".$RsCod[iCodTramite]."' ");
//	$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$RsCod[iCodTramite]'");

		$Rs=sqlsrv_fetch_array($rs);
		?>

        
 <table  width=882 border="0" cellspacing="0" cellpadding="1" align="center"> 
    <tr  align="center"> 
      <td width="880" >
        <table width = "97%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr> 
            <td  align="left"><img src="images/cab.jpg"  border="0"></td>
            <td ></td>
          </tr>
          <tr>
            <td ></td>
            <td ></td>  
          </tr>
        </table>
				
        <br>
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
		        <td width="310" class="CellFormDet">
		        	<span><?=date("d-m-Y", strtotime($Rs['fFecDocumento']))?></span>
        			<span style=font-size:10px><?=date("h:i A", strtotime($Rs['fFecDocumento']))?></span>		        </td>
		        <td width="140" >Fecha de Registro:&nbsp;</td>
		        <td width="262" class="CellFormDet">
		        	<span><?=date("d-m-Y", strtotime($Rs['fFecRegistro']))?></span>
        			<span style=font-size:10px><?=date("h:i A", strtotime($Rs['fFecRegistro']))?></span>		        </td>
		    </tr> 

		    <tr>
		        <td width="130" >N&ordm; Documento:&nbsp;</td>
		        <td class="CellFormDet"><?=$Rs['cNroDocumento']?></td>
		        <td width="140" >Referencia:&nbsp;</td>
		        <td class="CellFormDet"><?=$Rs[cReferencia]?></td>
		    </tr>

		    <tr>
		        <td width="130" >Tipo de Documento:&nbsp;</td>
		        <td class="CellFormDet">
		        		<? 
			          $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$Rs[cCodTipoDoc]'";
			          $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			          $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			          echo $RsTipDoc['cDescTipoDoc'];
		            ?>
		        </td>
		        <td width="140" >Folios:&nbsp;</td>
		        <td class="CellFormDet"><?=$Rs[nNumFolio];?></td>
		    </tr>
	    
		    <tr>
		        <td width="130" >Asunto:&nbsp;</td>
		        <td class="CellFormDet"><?=$Rs['cAsunto']?></td>
		        <td width="140" >Observaciones:&nbsp;</td>
		        <td class="CellFormDet"><?=$Rs[cObservaciones]?></td>
		    </tr>

		    <tr>
		        <td width="130" >Tiempo respuesta:&nbsp;</td>
		        <td class="CellFormDet"><?=$Rs[nTiempoRespuesta]?></td>
		        <td width="140" >&nbsp;</td>

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
		    <div style="display:none" id="zonaEmpresa">
		    <table border="0" width="860">
		    <tr>
		          <td width="130" >Razon Social:</td>
		          <td width="310" class="CellFormDet">
		          	<? 
			            $sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
//								$sqlRemi="SP_WEBCONSULTA_MAESTRA_REMITENTEXCODREMITENTE '$Rs[iCodRemitente]'";
			            $rsRemi=sqlsrv_query($cnx,$sqlRemi);
			            $RsRemi=sqlsrv_fetch_array($rsRemi);
			            echo $RsRemi['cNombre'];
		              ?>
		          </td>
		          <td width="140" >Ruc:</td>
		          <td class="CellFormDet"><?=$RsRemi['nNumDocumento']?></td>
		    </tr> 
		    <tr>
		          <td width="130" >Direccion:</td>
		          <td width="310" class="CellFormDet"><?=$RsRemi[cDireccion]?></td>
		          <td width="140" >Representante:</td>
		          <td class="CellFormDet"><?=$RsRemi[cRepresentante]?></td>
		    </tr>   
		    <tr>
		          <td width="130" >E-mail:</td>
		          <td width="310" class="CellFormDet"><?=$RsRemi[cEmail]?></td>
		          <td width="140" >Provincia:</td>
		          <td class="CellFormDet"><?=$RsRemi[cProvincia]?></td>
		    </tr>
		    <tr>
		          <td width="130" >Telefono:</td>
		          <td width="310" class="CellFormDet"><?=$RsRemi[nTelefono]?></td>
		          <td width="140" >Fax:</td>
		          <td class="CellFormDet"><?=$RsRemi[nFax]?></td>
		          
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
		    <div id="zonaFlujo">
		    <table border="0" width="860">
		    <tr>
		    <td align="left">
		    		<?
		    		$sqlF="SP_WEBCONSULTA_MOVIMIENTO_LISTA '$RsCod[iCodTramite]' ";

//		    		$sqlF="SELECT * FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='$RsCod[iCodTramite]' OR iCodTramiteRel='$RsCod[iCodTramite]') AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3) ORDER BY iCodMovimiento ASC";
		   			
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
		       	 		<button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF[iCodMovimiento]?>(event);" onmousemove="showdiv<?=$RsF[iCodMovimiento]?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF[iCodMovimiento]?>').style.display='none';">

		       	 				<td height="35" valign="center">
		       	 					<div class="FlujoSquareData" style="padding-top:10px">
		       	 					<span style="font-size:16px"><?=$RsOfiO[cSiglaOficina]?></span>
		       	 					</div>
		       	 				</td>
		       	 				<td><img src="images/icon_right.png" width="25" height="25" border="0"></td>
		       	 				</tr></table>
		       	 		</button>
								<div id="area<?=$RsF[iCodMovimiento]?>" align="left">
									<div align=center><?=$RsOfiO[cNomOficina]?></div>
									Creado: <?
													echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecMovimiento]))."</span>";
        									echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecMovimiento]))."</span>";
													?>
									<br>
									Aceptado:
													<?
													if($RsF[fFecRecepcion]==""){
        											echo "<span style=color:#6F6F6F>sin aceptar</span>";
        									}Else{
        											echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecRecepcion]))."</span>";
        											echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecRecepcion]))."</span>";
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
									Creado: <?
													echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecMovimiento]))."</span>";
        									echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecMovimiento]))."</span>";
													?>
									<br>
									Aceptado:
													<?
													if($RsF[fFecRecepcion]==""){
        											echo "<span style=color:#6F6F6F>sin aceptar</span>";
        									}Else{
        											echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecRecepcion]))."</span>";
        											echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecRecepcion]))."</span>";
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
		
		<tr>
		<td>   
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaOficina')" class="LnkZonas">Flujo Entre Oficinas <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaOficina">
		    <table border="0" align="center" width="860">
		    <tr>
		       <td class="headCellColum" width="120">Tipo Documento</td>
		       <td class="headCellColum" width="75">Fecha</td>
		       <td class="headCellColum" width="200">Asunto</td>
		       <td class="headCellColum" width="200">Observaciones</td>
		       <td class="headCellColum">Origen</td>
		       <td class="headCellColum">Destino</td>
		       <td class="headCellColum" width="120">Avances</td>
		       </tr>
		   	<? 
		   	$sqlM="SP_WEBCONSULTA_MOVIMIENTO_LISTA '$RsCod[iCodTramite]' ";

//	   	$sqlM="SELECT * FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='$RsCod[iCodTramite]' OR iCodTramiteRel='$RsCod[iCodTramite]') AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3) ORDER BY iCodMovimiento ASC";
		   
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
		    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'">
		    <td valign="top" class="CellFormCol" ><?=$RsM[iCodMovimiento]?>-
		       	<?
			      if($RsM[cFlgTipoMovimiento]==1){
			      		$sqlTpDcM="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsM[cCodTipoDocDerivar]'";
			      		$rsTpDcM=sqlsrv_query($cnx,$sqlTpDcM);
			      		$RsTpDcM=sqlsrv_fetch_array($rsTpDcM);
			      		echo $RsTpDcM['cDescTipoDoc'];
			      		//echo "<div>".$Rs[cReferencia]."</div>";
			      		echo "<div style=color:#808080>".$RsM['cNumDocumentoDerivar']."</div>";
			      		echo "<div style=color:#808080>".$Rs['cNroDocumento']."</div>";
			     	}Else{
			     			echo $RsTpDcM['cDescTipoDoc'];
			     			echo "<div style=color:#008000><b>ANEXO<b></div>";
			     	}
		       	?>		    </td>
		    <td valign="top" class="CellFormCol">
		       		<span><?=date("d-m-Y", strtotime($RsM['fFecDerivar']))?></span>		    </td>
		    <td valign="top" align="left" class="CellFormCol">
		       		<?
		       		if($contaMov==0){
		       			echo $Rs['cAsunto'];
		       		}Else{
		       			echo $RsM[cAsuntoDerivar];
		       		}
		       		?>		    </td>
		    <td valign="top" align="left" class="CellFormCol">
		     	 		<?
		     	 		if($contaMov==0){
		       			echo $Rs[cObservaciones];
		       		}Else{
		       			echo $RsM[cObservacionesDerivar];
		       		}
		     	 		?>		     	 </td>
		     	 
		       <td valign="top" class="CellFormCol"> <?
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaOrigen]'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	 ?>		       </td>
		     	 <td valign="top" class="CellFormCol"> <?
		     	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaDerivar]'";
			       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
		     	 		echo "<a href=\"javascript:;\" title=\"".trim($RsOfiD[cNomOficina])."\">".$RsOfiD[cSiglaOficina]."</a>";
		     	 	?>		     	 </td>
		     	 <td valign="top" class="CellFormCol">
		     	 	<?
			     	$sqlAvan="SELECT * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento='$RsM[iCodMovimiento]' ORDER BY iCodAvance DESC";
            $rsAvan=sqlsrv_query($cnx,$sqlAvan);
            while ($RsAvan=sqlsrv_fetch_array($rsAvan)){
		     	 			$rsTrbA=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsAvan[iCodTrabajadorAvance]'");
          			$RsTrbA=sqlsrv_fetch_array($rsTrbA);
          			echo "<div style=font-size:10px;color:#623100>".$RsTrbA["cApellidosTrabajador"]." ".$RsTrbA["cNombresTrabajador"].":</div>";
								sqlsrv_free_stmt($rsTrbA);
								echo "<div style=font-size:10px;color:#808080>".date("d-m-Y h:i a", strtotime($RsAvan[fFecAvance]))."&nbsp;</div>";
		     	 			echo "<div style=font-size:10px>".$RsAvan[cObservacionesAvance]."</div>";
		     	 			echo "<hr>";
		    		}
		     	 	?>		     	 </td>
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

        <BR>
        <table  cellpadding="0" cellspacing="0"  bgcolor="#FFFFFF" align="center">
          <tr> 
            <td height="21" valign="top" > 
<div align="left"><font class="CellFormDet"> Referencias 
            : </font></div></td>
            <td colspan="3" valign="top" ><font class="Titulo_Dato"></font></td>
          </tr>
          <tr valign="bottom"> 
            <td height="18" colspan="4"  align="left"><small><small><font face="Verdana" color="#999999"><b>Indicaciones</b></font></small></small></td>
          </tr>
          <tr> 
            <td width="230" align="left"><small><small><font face="Verdana" size="-4" color="#999999">01.ACCION NECESARIA</font></small></small></td>
            <td width="197" align="left"><small><small><font size="-4" face="Verdana" color="#999999">02.ESTUDIO E INFORME</font></small></small></td>
            <td width="188" align="left"><font size="-4" face="Verdana, Arial, Helvetica, sans-serif" color="#999999">03.CONOCIMIENTO Y FINES</font></td>
          </tr>
          <tr> 
            <td width="230" align="left"><small><small><font size="-4" face="Verdana" color="#999999">04.FORMULAR RESPUESTA</font></small></small></td>
            <td width="197" align="left"><small><small><font size="-4" face="Verdana" color="#999999">05.POR CORRESPONDERLE</font></small></small></td>
            <td width="188" align="left"><font size="-4" face="Verdana, Arial, Helvetica, sans-serif" color="#999999">06.TRANSCRIBIR</font></td>
          </tr>
          <tr> 
            <td width="230" align="left"><small><small><font size="-4" face="Verdana" color="#999999">07.PROYECTAR DISPOSITIVO</font></small></small></td>
            <td width="197" align="left"><small><small><font size="-4" face="Verdana" color="#999999">08.FIRMAR Y/O REVISAR</font></small></small></td>
            <td width="188" align="left"><font size="-4" face="Verdana, Arial, Helvetica, sans-serif" color="#999999">09.ARCHIVAR</font></td>
          </tr>
          <tr> 
            <td width="230" align="left"><font color="#999999"><small><small><font size="-4" face="Verdana">10.CONOCIMIENTO Y RESPUESTA</font></small></small></font></td>
            <td width="197" align="left"><small><small><font size="-4" face="Verdana" color="#999999">11.PARA COMENTARIOS</font></small></small></td>
            <td width="188" align="left"><small><small><font size="-4" face="Verdana, Arial, Helvetica, sans-serif" color="#999999"></font></small></small></td>
          </tr>
        </table>
      </td>
    </tr>
</table>
  <?  
      }
	}	 
?>     
</body>
</html>
