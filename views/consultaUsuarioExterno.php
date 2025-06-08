<?php session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="content-type" content="text/html; charset=UFT-8">
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">


function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}
function releer(){
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>#area";
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

<div class="AreaTitulo">Consulta >> Doc. Entrada (Web)</div>
<table class="table">
	<tr>



						<form name="frmConsultaEntrada" method="GET" action="consultaEntradaGeneralOficina.php">
							<tr>
								<td width="110" >N&ordm; Tr&aacute;mite:</td>
								<td width="390" align="left">
									<input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control">
								</td>
								<td width="110" >Desde:</td>
								<td align="left">
									<table cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td>
												<?php
													if(trim($_REQUEST[fHasta])==""){$fecfin = $_REQUEST[fHasta];}else{ $fecfin = $_REQUEST[fHasta]; }
													if(trim($_REQUEST[fDesde])==""){$fecini = $_REQUEST[fDesde];}else{ $fecini = $_REQUEST[fDesde]; }
												?>                              
												<input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:105px" class="FormPropertReg form-control">
											</td>
											<td>
												<div class="boton" style="width:24px;height:20px">
													<a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,true)">
														<img src="images/icon_calendar.png" width="22" height="20" border="0">
													</a>
												</div>
											</td>
											<td width="20"></td>
											<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:105px" class="FormPropertReg form-control">
											</td>
											<td>
												<div class="boton" style="width:24px;height:20px">
													<a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,true)">
														<img src="images/icon_calendar.png" width="22" height="20" border="0">
													</a>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
          				            $sqlTipo.="ORDER BY cDescTipoDoc ASC";
          				            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          				while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          					if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
          						$selecTipo="selected";
          					}else{
          						$selecTipo="";
          					}
          				echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          				}
          				sqlsrv_free_stmt($rsTipo);
									?>
									</select></td>
							<td width="110" >Asunto:</td>
							<td align="left"><input type="txt" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="50" class="FormPropertReg form-control">							</td>
						</tr>
						<tr>
						  <td >Nro de Documento:</td>
						  <td align="left"><input type="txt" name="cNroDocumento" value="<?=$_GET['cNroDocumento']?>" size="28" class="FormPropertReg form-control"></td>
						  <td width="110" >Nro Referencia:</td>
						  <td width="390" align="left"><input type="txt" name="cReferencia" value="<?=$_GET[cReferencia]?>" size="28" class="FormPropertReg form-control"></td>
						  </tr>
						<tr>
							<td height="10" >Remitente:</td>
							<td height="10" align="left"><input type="txt" name="cNomRemite" value="<?=$_GET[cNomRemite]?>" size="50" class="FormPropertReg form-control" /></td>
						</tr>
						

				<tr>
					<td colspan="4" align="right">
						<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">
							<table cellspacing="0" cellpadding="0">
								<tr>
									<td style=" font-size:10px"><b>Buscar</b>&nbsp;&nbsp;
									</td>
									<td><img src="images/icon_buscar.png" width="17" height="17" border="0"></td>
								</tr>
							</table>
						</button>
						<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self'); return false;"
								onMouseOver="this.style.cursor='hand'">
							<table cellspacing="0" cellpadding="0">
								<tr>
									<td style=" font-size:10px"><b>Restablecer</b>&nbsp;&nbsp;</td>
									<td><img src="images/icon_clear.png" width="17" height="17" border="0"></td>
								</tr>
							</table>
						</button>
						
						<button class="btn btn-primary" onclick="window.open('consultaDocEntradaExterno_xls.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&cNomRemite=<?=$_GET[cNomRemite]?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'">
							<table cellspacing="0" cellpadding="0">
								<tr>
									<td style=" font-size:10px"><b>a Excel</b>&nbsp;&nbsp;</td>
									<td><img src="images/icon_excel.png" width="17" height="17" border="0"></td>
								</tr>
							</table>
						</button>

						<!-- <button class="btn btn-primary" onclick="window.open('consultaDocEntradaExterno_pdf.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&cNomRemite=<?=$_GET[cNomRemite]?>', '_blank'); return false;" onMouseOver="this.style.cursor='hand'">
							<table cellspacing="0" cellpadding="0">
								<tr>
									<td style=" font-size:10px"><b>a Pdf</b>&nbsp;&nbsp;</td>
									<td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
								</tr>
							</table>
						</button> -->

						<? /*<button class="btn btn-primary" onclick="window.open('consultaEntradaHojaRuta_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>H.Ruta</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>	*/?>
              			</td>
					</tr>
							</form>

</form>



<?
function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
$total_paginas = ceil($total/$por_pagina);
$anterior = $actual - 1;
$posterior = $actual + 1;
$minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
$maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
if ($actual>1)
$texto = "<a href=\"$enlace$anterior\">�</a> ";
else
$texto = "<b><<</b> ";
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
$texto .= "<b>>></b>";
return $texto;
}

//ARTURO
$pag = $_GET["pag"];
if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
$tampag = 20;
$reg1 = ($pag-1) * $tampag;

// ordenamiento
if($_GET['campo']==""){
	$campo="Fecha";
}Else{
	$campo=$_GET['campo'];
}

if($_GET['orden']==""){
	$orden="DESC";
}else{
	$orden=$_GET['orden'];
}

//invertir orden
if ($orden == "ASC"){
	$cambio="DESC";	
}
if ($orden == "DESC"){
	$cambio="ASC";	
}

if ($fecini != ''){
	$fecini = date("Ymd", strtotime($fecini));
}
if ($fecfin != ''){
	$fecfin = date("Y-m-d", strtotime($fecfin));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
		$date_r = getdate(strtotime($date));
    	$date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    	return $date_result;
	}
	$fecfin = dateadd($fecfin,1,0,0,0,0,0); // + 1 dia
}
//  $sql.= " SP_CONSULTA_ENTRADA_GENERAL_OFICINA '$fecini','$fecfin','%".$_GET['cCodificacion']."%','%$_GET[cReferencia]%','%".$_GET['cAsunto']."%','$_GET['iCodTupa']','".$_GET['cCodTipoDoc']."','%$_GET['cNombre']%','%$_GET[cNomRemite]%','$_GET[iCodOficinaOri]','$_GET[iCodOficinaDes]', '%$_GET['cNroDocumento']%', '$campo', '$orden'";
// $rs    = sqlsrv_query($cnx,$sql);
// $total = sqlsrv_has_rows($rs);
?>
<br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
	<td width="98" class="headCellColum">
		<a href="<?=$_SERVER['PHP_SELF']?>?campo=Codificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"
		   style=" text-decoration:<?php if($campo=="Codificacion"){ echo "underline"; }else{ echo "none";}?>">N&ordm; Tr&aacute;mite
		</a>
	</td>
	<td width="192" class="headCellColum">
		<a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>"
		   style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }else{ echo "none";}?>">Tipo Documento
		 </a>
	</td>
	<td width="240" class="headCellColum">Remitente</td> 
	<!-- <td width="92" class="headCellColum">Fecha Derivo</td> -->
	<td class="headCellColum">
		<a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>"
		   style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }else{ echo "none";}?>">Asunto
		</a>
	</td>
</tr>
<?php
	if ($fecini == "" && $fecfin == "" && $_GET['cCodificacion'] == "" && $_GET[iCodOficinaOri] == "" && $_GET[iCodOficinaDes] == "" &&
		$_GET['cCodTipoDoc'] == "" && $_GET['cAsunto'] == "" && $_GET[cReferencia] == "" && $_GET['iCodTupa'] == "" && $_GET['cNombre'] == "" &&
		$_GET[iCodTrabajadoResponsable] == "" && $_GET['cNroDocumento'] == "" && $_GET[cNomRemite] == ""){
 		$sqltra  = "SELECT * FROM Tra_M_Tramite TRAM 
								INNER JOIN Tra_M_Trabajadores TRAB ON TRAM.iCodTrabajadorRegistro = TRAB.iCodTrabajador 
								WHERE (TRAM.nFlgTipoDoc = 1 OR TRAM.nFlgTipoDoc = 4) 
						  				AND TRAB.iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR']."
						  				AND TRAB.ES_EXTERNO = 1";
		// $rstra   = sqlsrv_query($cnx,$sqltra);
		// $numrows = sqlsrv_has_rows($rstra);
 		$rs   = sqlsrv_query($cnx,$sqltra);
 		$total = sqlsrv_has_rows($rs);
		$numrows = sqlsrv_has_rows($rs);
	}else{
		$sql = " SP_CONSULTA_DOC_ENTRADA_EXTERNO '$fecini','$fecfin','%".$_GET['cCodificacion']."%','%$_GET[cReferencia]%','%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','%$_GET['cNombre']%','%$_GET[cNomRemite]%','%$_GET['cNroDocumento']%','$campo','$orden',$_SESSION['CODIGO_TRABAJADOR']";
		$rs    = sqlsrv_query($cnx,$sql);
		$total = sqlsrv_has_rows($rs);
		$numrows = sqlsrv_has_rows($rs);
	}
	
	if ($numrows == 0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
	}else{
        echo "TOTAL DE REGISTROS : ".$numrows;

	for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
		sqlsrv_fetch_array($rs, $i);
		$Rs = sqlsrv_fetch_array($rs);
		//while ($Rs=sqlsrv_fetch_array($rs)){
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
    	<?php if($Rs[nFlgTipoDoc]!=4){?>
    		<a href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramite]?>" rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
    	<?php } else{?>
    		<a href="registroDetalles.php?iCodTramite=<?=$Rs[Relacionado]?>" rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
    	<?php}?>
    	<?php  
    		$sqlTra = "SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores 
    				   WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
			$rsTra  = sqlsrv_query($cnx,$sqlTra);
			$RsTra  = sqlsrv_fetch_array($rsTra);
			echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
      	?>
    </td>
    <td valign="top" align="center">
    	<?php
    		$sqlNomDoc = "SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc = " .$Rs[cCodTipoDoc];
    		$rsNomDoc  = sqlsrv_query($cnx,$sqlNomDoc);
    		$RsNomDoc  = sqlsrv_fetch_array($rsNomDoc);
    		echo $RsNomDoc['cDescTipoDoc'];
			echo "<div style=color:#808080;text-transform:uppercase>".$Rs['cNroDocumento']."</div>";
    	?>
    </td>
    <td valign="top" align="center">
    	<?php
    		$sqlRemi = "SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
			$rsRemi  = sqlsrv_query($cnx,$sqlRemi);
			$RsRemi  = sqlsrv_fetch_array($rsRemi);
			echo "<div style=color:#000000;>".$RsRemi['cNombre']."</div>";
			if ($Rs[cNomRemite] != ""){
				if ($RsRemi['cTipoPersona'] == 1){
					echo "<div style=color:#408080>Personal Natural:</div>"; 
				}
			}
			echo "<div style=color:#408080;text-transform:uppercase>".$Rs[cNomRemite]."</div>";
			
      		if($Rs[nFlgTipoDoc]==4){
				echo "<div style=color:#006600;><b>ANEXO</b></div>";
			}
      	?>
    </td>
    <!-- <td valign="top" align="center">
    	<?
    	if($Rs[nFlgTipoDoc]!=4){
    		if($Rs[nFlgEnvio]==1){
    			$sqlM="select TOP 1 * from Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]'";
      		$rsM=sqlsrv_query($cnx,$sqlM);
	    		$RsM=sqlsrv_fetch_array($rsM);
    			echo "<div style=color:#0154AF>".date("d-m-Y G:i:s", strtotime($RsM['fFecDerivar']))."</div>";
      		
      	}
      }else{
      		$sqlM="select TOP 1 * from Tra_M_Tramite_Movimientos WHERE iCodTramiteRel='$Rs[iCodTramiteRel]'";
      		$rsM=sqlsrv_query($cnx,$sqlM);
	    		$RsM=sqlsrv_fetch_array($rsM);
    			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsM['fFecDerivar']))."</div>";
      		echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsM['fFecDerivar']))."</div>";
      }
			?>
		</td> -->
    <td valign="top" align="left">
    	<?
    	echo $Rs['cAsunto'];
    	if($Rs['iCodTupa']!=""){
    		$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$Rs['iCodTupa']."'";
      	$rsTup=sqlsrv_query($cnx,$sqlTup);
      	$RsTup=sqlsrv_fetch_array($rsTup);
		?>
        <br>
       <a href="registroDetalleFlujoTupa.php?iCodTupa=<?=$Rs['iCodTupa']?>" rel="lyteframe" title="Detalles Flujo Tupa" rev="width: 880px; height: 300px; scrolling: auto; border:no"><?=$RsTup["cNomTupa"]?></a>
		<? 
		} 
		echo "<div style=color:#808080;text-transform:uppercase>".$Rs[cReferencia]."</div>";
		if($Rs['iCodTupa']!=""){
		 $sqlReq= " SELECT * FROM Tra_M_Tupa_Requisitos WHERE iCodTupa=(SELECT iCodTupa FROM Tra_M_Tramite WHERE iCodTramite='$Rs[iCodTramite]') AND iCodTupaRequisito NOT IN 
			          (SELECT iCodTupaRequisito FROM Tra_M_Tramite_Requisitos WHERE iCodTramite='$Rs[iCodTramite]' ) ";
  		$rsReq=sqlsrv_query($cnx,$sqlReq);
      	$numReq=sqlsrv_has_rows($rsReq);
		if($numReq!=0){
      	echo "\n<div style=color:#FF0000>Faltan ".$numReq." Requisitos por cumplir</div>";
		}			  
        }
    	?>
    </td>
    
</tr>
  
<?
}
}
?> 
		<tr>
		<td colspan="6" align="center">
         <?php echo paginar($pag, $total, $tampag, "consultaEntradaGeneralOficina.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&iCodOficinaOri=".$_GET[iCodOficinaOri]."&iCodOficinaDes=".(isset($_GET['iCodOficinaDes'])?$_GET['iCodOficinaDes']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&iCodTupa=".$_GET['iCodTupa']."&cNombre=".$_GET['cNombre']."&iCodTrabajadoResponsable=".$_GET[iCodTrabajadoResponsable]."&cNroDocumento=".$_GET['cNroDocumento']."&cNomRemite=".$_GET[cNomRemite]."&pag=");
			//P�gina 1 <a href="javascript:;">2</a> <a href="javascript:;">3</a> <a href="javascript:;">4</a> <a href="javascript:;">5</a>
		 ?>	
		</td>
		</tr>
</table>
    </td>
	  </tr>
		</table>
  


<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>
<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>