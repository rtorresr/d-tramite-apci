<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");

//cCodificacion=&fDesde=&fHasta=&cCodTipoDoc=&cAsunto=&cReferencia=&SI=&NO=&iCodOficinaOri=&iCodOficinaDes=&pag=2
$cCodificacion=$_GET["cCodificacion"];
$fDesde=$_GET["fDesde"];
$fHasta=$_GET["fHasta"];
$cCodTipoDoc=$_GET["cCodTipoDoc"];
$cAsunto=$_GET["cAsunto"];
$cReferencia=$_GET["cReferencia"];
$SI=$_GET["SI"];
$NO=$_GET["NO"];
$iCodOficinaOri=$_GET["iCodOficinaOri"];
$iCodOficinaDes=$_GET["iCodOficinaDes"];
$pag=$_GET["pag"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
//$pag = $_GET[$pag];
function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}

//--></script>
</head>
<body>

	<?php include("includes/menu.php");?>



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

<div class="AreaTitulo">Consulta >> Doc. Internos Generales (L)</div>




							<form name="frmConsultaEntrada" method="GET" action="consultaInternoGeneral.php">
						<tr>
							<td width="110" >N&ordm; Documento:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td>
								<?
								if(trim($_REQUEST[fHasta])==""){$fecfin = $_REQUEST[fHasta];}  else { $fecfin = $_REQUEST[fHasta]; }
								if(trim($_REQUEST[fDesde])==""){$fecini =$_REQUEST[fDesde];} else { $fecini = $_REQUEST[fDesde]; }
								?>                           
                                    <input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>
							</td>
						</tr>
						<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:260px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 And cCodTipoDoc!=45 ";
									$sqlTipo.="ORDER BY cDescTipoDoc ASC";
          				            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          				while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          					if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
          						$selecTipo="selected";
          					}Else{
          						$selecTipo="";
          					}
          				echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          				}
          				sqlsrv_free_stmt($rsTipo);
									?>
									</select></td>
							<td width="110" >Asunto:</td>
							<td align="left"><input type="txt" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="65" class="FormPropertReg form-control">
							</td>
						</tr>
						<tr>
							<td width="110" >Enviado:</td>
							<td width="390" align="left">
						      SI<input type="checkbox" name="SI" value="1" <?php if($_GET[SI]==1) echo "checked"?> />
							   &nbsp;&nbsp;&nbsp;
	                          NO<input type="checkbox" name="NO" value="1" <?php if($_GET[NO]==1) echo "checked"?> />
                               </td>
							<td width="110" >Observaciones:</td>
							<td align="left" class="CellFormRegOnly"><input type="txt" name="cObservaciones" value="<?=$_GET[cObservaciones]?>" size="65" class="FormPropertReg form-control">
						  </td>
						</tr>
												<tr>
						  <td >Oficina Origen:</td>
						  <td align="left">
                  	<select name="iCodOficinaOri" class="FormPropertReg form-control" style="width:360px" />
     	            <option value="">Seleccione:</option>
	              <? 
	                 $sqlOfi="SP_OFICINA_LISTA_COMBO"; 
                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                 while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodOficina"]==$_GET[iCodOficinaOri]){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?>
            </select></td>
						  <td >Oficina Destino:</td>
						  <td align="left">
                          	<select name="iCodOficinaDes" class="FormPropertReg form-control" style="width:360px"  />
     	            <option value="">Seleccione:</option>
	              <? 
	                 $sqlOfi="SP_OFICINA_LISTA_COMBO "; 
                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                 while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodOficina"]==$_GET[iCodOficinaDes]){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?>
            </select></td>
						  </tr>
						<tr>
                         
							<td colspan="2" align="left">&nbsp;</td>
                          <td colspan="2" align="right">
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
                           <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
                             &nbsp;
			    <?php // ordenamiento
                if($_GET['campo']==""){ $campo="Fecha"; }Else{ $campo=$_GET['campo']; }
                if($_GET['orden']==""){ $orden="DESC"; }Else{ $orden=$_GET['orden']; } ?>
				<button class="btn btn-primary" onclick="window.open('consultaInternoGeneral_xls.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&cObservaciones=<?=$_GET[cObservaciones]?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficinaOri=<?=$_GET['iCodOficinaOri']?>&iCodOficinaDes=<?=$_GET['iCodOficinaDes']?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&orden=<?=$orden?>&campo=<?=$campo?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('consultaInternoGeneral_pdf.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&cObservaciones=<?=$_GET[cObservaciones]?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficinaOri=<?=$_GET['iCodOficinaOri']?>&iCodOficinaDes=<?=$_GET['iCodOficinaDes']?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
							
							</td>
						</tr>
							</form>

</form>



<?
function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
	
	"</br>";
$total_paginas = ceil($total/$por_pagina);
$anterior = $actual - 1;
$posterior = $actual + 1;
$minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
$maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
if ($actual>1)
$texto = "<a href=\"$enlace$anterior\">�</a> ";
else
$texto = "<b>�</b> ";
if ($minimo!=1) $texto.= "... ";
for ($i=$minimo; $i<$actual; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
$texto .= "<b>$actual</b> ";
for ($i=$actual+1; $i<=$maximo; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
if ($maximo!=$total_paginas) $texto.= "... ";
if ($actual<$total_paginas)
$texto .= "<a href=\"$enlace$posterior\">�</a>";
else
$texto .= "<b>�</b>";
return $texto;
}


if (!isset($pag)) 
	$pag = 1; // Por defecto, pagina 1
	$tampag = 20;
	$reg1 = ($pag-1) * $tampag;

//invertir orden
if($orden=="ASC") $cambio="DESC";
if($orden=="DESC") $cambio="ASC";

	if($fecini!=''){$fecini=date("Ymd", strtotime($fecini));}
    if($fecfin!=''){
		$fecfin=date("Y-m-d", strtotime($fecfin));
		function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
			$date_r = getdate(strtotime($date));
			$date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
			return $date_result;
		}
		$fecfin=dateadd($fecfin,1,0,0,0,0,0); // + 1 dia
	}

	$sql.= " SP_CONSULTA_INTERNO_GENERAL '$fecini','$fecfin','$_GET[SI]','$_GET[NO]','%".$_GET['cCodificacion']."%','%".$_GET['cAsunto']."%','%$_GET[cObservaciones]%','".$_GET['cCodTipoDoc']."','$_GET[iCodOficinaOri]','$_GET[iCodOficinaDes]','$campo','$orden' ";
    $rs    = sqlsrv_query($cnx,$sql);
	$total = sqlsrv_has_rows($rs);
?>
<br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
 <td width="101" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Fecha&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="fFecRegistro"){ echo "underline"; }Else{ echo "none";}?>">Fecha</a></td>
 <td width="147" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Oficina&orden=<?=$cambio?>&cNomOficina=<?=$_GET[cNomOficina]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Oficina"){ echo "underline"; }Else{ echo "none";}?>">Oficina Origen</a></td>
	<td width="158" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
    <td width="401" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto</a></td>
	<td width="145" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="cNomOficina"){ echo "underline"; }Else{ echo "none";}?>">Oficina Destino</a></td>
  	</tr>
<?
if($fecini=="" && $fecfin=="" && $_GET['cCodTipoDoc']=="" && $_GET['cAsunto']=="" && $_GET['cCodificacion']=="" && $_GET[cReferencia]=="" && $_GET[SI]=="" && $_GET[NO]=="" && $_GET[iCodOficinaOri]=="" && $_GET[iCodOficinaDes]=="" ){
	$sqlin   = "SP_CONSULTA_INTERNO_GENERAL_LISTA '$_GET[iCodOficinaOri]','$_GET[iCodOficinaDes]'";
  	$rsin    = sqlsrv_query($cnx,$sqlin);
	$numrows = sqlsrv_has_rows($rsin);
 }
else{
	$numrows = sqlsrv_has_rows($rs);
} 
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
         echo "TOTAL DE REGISTROS : ".$numrows;
	for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
		sqlsrv_fetch_array($rs, $i);
		$Rs=sqlsrv_fetch_array($rs);

		if ($color == "#DDEDFF"){
			$color = "#F9F9F9";
		}else{
			$color = "#DDEDFF";
		}
		if ($color == ""){
			$color = "#F9F9F9";
		}	
?>

 <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
    <td valign="top" align="center">
    	<?
    	echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
    	echo "<div style=color:#727272;font-size:10px>".date("G:i:s", strtotime($Rs['fFecRegistro']))."</div>";
		$sqlTra="SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
			$rsTra=sqlsrv_query($cnx,$sqlTra);
			$RsTra=sqlsrv_fetch_array($rsTra);
			echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";	 
			?>
		</td>
    <td valign="top" align="left"><?php echo $Rs[cNomOficina];
	echo "<div style=color:#808080;>".$Rs[cNombresTrabajador]." ".$Rs[cApellidosTrabajador]."</div>";
	?></td>
    <td valign="top" align="left">
	    <?	
			echo $Rs['cDescTipoDoc'];
			echo "<br>";
			echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
			echo $Rs[cCodificacion];
			echo "</a>";
			?>
			<br>
    <?php 
        if($Rs[nFlgEnvio]==0){
        echo "<font color=red>(Por Aprobar)</font>";
        }else{
        echo "";
        }
    ?>
			
		</td>
    <td valign="top" width="401" align="left"><?=$Rs['cAsunto']?></td>
     <td valign="top" align="left">
	        <? 
			    echo $Rs[Destino];			
			   ?></td>         
</tr>
  
<? 
  }
  }?> 
<tr>
		<td colspan="8" align="center">
         <?php echo paginar($pag, $total, $tampag, "consultaInternoL.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&SI=".$_GET[SI]."&NO=".$_GET[NO]."&iCodOficinaOri=".$_GET[iCodOficinaOri]."&iCodOficinaDes=".(isset($_GET['iCodOficinaDes'])?$_GET['iCodOficinaDes']:'')."&pag=");?>
         </td>
		</tr>
</table>
 	  </tr>
		</table>  


<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>