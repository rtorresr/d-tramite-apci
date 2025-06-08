<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php"); ?>
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
	function Activar(){
		document.frmConsultaEntrada.cReferenciaPCM.disabled = (document.frmConsultaEntrada.activar.checked) ? false : true;
		document.frmConsultaEntrada.cNroDocumento.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.cReferencia.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.cAsunto.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.cCodificacion.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.cNombre.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.iCodOficina.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.iCodTupa.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.fDesde.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.fHasta.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
		document.frmConsultaEntrada.cNomRemite.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
	}
</script>
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

<div class="AreaTitulo">Consulta >> Doc. Entrada Grupo</div>

	<table cellpadding="0" cellspacing="0" border="0" width="960"><tr><td><?php // ini table por fieldset ?>


							<form name="frmConsultaEntrada" method="GET" action="consultaEntradaPersonal.php">
					<tr>
							<td width="110" >N&ordm; TRÁMITE:</td>
							<td width="390" align="left">
								<input type="text" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control">
								</td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td>
    <?
	if(trim($_REQUEST[fHasta])!="") { $fecfin = $_REQUEST[fHasta]; }							
	if(trim($_REQUEST[fDesde])!="") { $fecini = $_REQUEST[fDesde]; }
	?>                    
                                    <input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:105px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:105px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
						</tr>
						<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:260px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgEntrada='1' ";
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
							<td align="left"><input type="txt" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="65" class="FormPropertReg form-control">							</td>
						</tr>
						<tr>
						  <td >Nro de Documento:</td>
						  <td align="left"><input type="txt" name="cNroDocumento" value="<?=$_GET['cNroDocumento']?>" size="28" class="FormPropertReg form-control"></td>
						  <td >Proc. Tupa:</td>
						  <td align="left">
                          <select name="iCodTupa" class="FormPropertReg form-control" style="width:360px" />
					<option value="">Seleccione:</option>
					<? 
					$sqlTupa="SELECT * FROM Tra_M_Tupa ";
                    $sqlTupa.="ORDER BY iCodTupa ASC";
                    $rsTupa=sqlsrv_query($cnx,$sqlTupa);
                    while ($RsTupa=sqlsrv_fetch_array($rsTupa)){
          	        if($RsTupa["iCodTupa"]==$_GET['iCodTupa']){
          		    $selecTupa="selected";
          	        } Else{
          		    $selecTupa="";
          	        }
                    echo "<option value=".$RsTupa["iCodTupa"]." ".$selecTupa.">".$RsTupa["cNomTupa"]."</option>";
                    }
                    sqlsrv_free_stmt($rsTupa);
					?>
					</select>	</td>
						  </tr>
						<tr>
							<td width="110" >Nro Referencia:</td>
							<td width="390" align="left"><input type="txt" name="cReferencia" value="<?=$_GET[cReferencia]?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Oficina:</td>
							<td align="left" >
                            <select name="iCodOficina" class="FormPropertReg form-control" style="width:360px" />
     	            <option value="">Seleccione:</option>
	              <? 
	                 $sqlOfi="SP_OFICINA_LISTA_COMBO "; 
                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                 while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodOficina"]==$_GET['iCodOficina']){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?>
            		</select>
            	</td>
						</tr>
						
						<tr>
							<td height="10" >Doc. SITDD:</td>
						  <td height="10" align="left">
						  	<input type="text" name="cReferenciaPCM" value="<?=$_GET[cReferenciaPCM]?>" size="28" class="FormPropertReg form-control" 
						  				 disabled="disabled" >
						    <label>
						    	<input type="checkbox" name="activar" onclick="Activar(this);" value="1" 
						    				 <?php if($_GET[activar]==1) echo "checked"?> />
					      </label>
					    </td>
              <td height="10" >Instituci&oacute;n:</td>
              <td height="10" align="left">
              	<input type="text" name="cNombre" value="<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>" size="65" class="FormPropertReg form-control">
              </td>
						</tr>
            
            <tr>
						  <td height="10" >&nbsp;</td>
						  <td height="10" align="left">&nbsp;</td>
						  <td height="10" >Remitente:</td>
						  <td height="10" align="left"><input type="txt" name="cNomRemite" value="<?=$_GET[cNomRemite]?>" size="65" class="FormPropertReg form-control" /></td>
						  </tr>
						<tr>
                         
							<td colspan="4" align="right">
              	<table width="400" border="0" align="left">
                	<tr>
                  	<td align="left">
                              Descarga &nbsp; <img src="images/icon_download.png" width="16" height="16" border="0" > &nbsp; &nbsp;
	                          | &nbsp; &nbsp;  Edición &nbsp; <i class="fas fa-edit"></i>&nbsp;&nbsp;
                              | &nbsp; &nbsp; Anexos&nbsp; <img src="images/icon_anexo.png" width="16" height="16" border="0">&nbsp;&nbsp;                           
                    </td>
                  </tr>
                </table>
								<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td style=" font-size:10px"><b>Buscar</b>&nbsp;&nbsp;</td>
											<td><img src="images/icon_buscar.png" width="17" height="17" border="0"></td>
										</tr>
									</table>
								</button>
							�
								<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');"
												onMouseOver="this.style.cursor='hand'">
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td style=" font-size:10px"><b>Restablecer</b>&nbsp;&nbsp;</td>
											<td><img src="images/icon_clear.png" width="17" height="17" border="0"></td>
										</tr>
									</table>
								</button>
              �
								<button class="btn btn-primary" onclick="window.open('consultaEntradaPersonal_xls.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cNomRemite=<?=$_GET[cNomRemite]?>&iCodOficina=<?=$_GET['iCodOficina']?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&cReferenciaPCM=<?=$_GET[cReferenciaPCM]?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							�
							<!-- <button class="btn btn-primary" onclick="window.open('consultaEntradaPersonal_pdf.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cNomRemite=<?=$_GET[cNomRemite]?>&iCodOficina=<?=$_GET['iCodOficina']?>&cReferenciaPCM=<?=$_GET[cReferenciaPCM]?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button> -->
					  </tr>
							</form>

</form>


<?php
$sqlVal= " SELECT iCodTrabajador FROM Tra_M_Grupo_Tramite_Detalle WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' ";
	$rsVal=sqlsrv_query($cnx,$sqlVal);
   	$Val = sqlsrv_has_rows($rsVal);
if($Val>0){	

function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
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


if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
$tampag = 20;
$reg1 = ($pag-1) * $tampag;

// ordenamiento
if($_GET['campo']==""){
	$campo="Tra_M_Tramite.cCodificacion";
}Else{
	$campo=$_GET['campo'];
}

if($_GET['orden']==""){
	$orden="DESC";
}Else{
	$orden=$_GET['orden'];
}

//invertir orden
if($orden=="ASC") $cambio="DESC";
if($orden=="DESC") $cambio="ASC";

	if($fecini!=''){$fecini=date("Ymd G:i", strtotime($fecini));}
    if($fecfin!=''){
    $fecfin=date("Y-m-d G:i", strtotime($fecfin));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd G:i", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fecfin=dateadd($fecfin,0,0,0,0,0,0); // + 1 dia
	}
//CASO NUEVO SOLO CUANDO EL CAMPO DOC. PEROINVERSION EST� CON DATA Y LOS DEM�S VAC�OS
if (isset($_GET['cReferenciaPCM'])) {
	$sqlDocSITDD = "SELECT * FROM Tra_M_Tramite WHERE (Tra_M_Tramite.nFlgTipoDoc IN (1,3)) AND Tra_M_Tramite.cCodificacion = (SELECT cReferencia FROM Tra_M_Tramite WHERE (Tra_M_Tramite.nFlgTipoDoc IN (1,3)) AND Tra_M_Tramite.cCodificacion = '$_GET[cReferenciaPCM]')";
	$rs = sqlsrv_query($cnx,$sqlDocSITDD);
}else{
	// CASO EN EL QUE SOLO DOS CAMPOS ESTón CON DATA Y LOS DEM�S ESTón VAC�OS
	if (($_GET['cReferenciaPCM'] != "" OR $_GET['cCodTipoDoc'] != "") && $_GET['cCodificacion'] == "" && $_GET['iCodOficina'] == "" &&
		  $_GET['cAsunto'] == "" && $_GET['cReferencia'] == "" && $_GET['iCodTupa'] == "" && $_GET['cNombre'] == "" && 
		  $_GET['iCodTrabajadoResponsable'] == "" && $_GET['cNroDocumento'] == "" && $_GET['cNomRemite'] == ""){
	  $sqlpcm = "SELECT * FROM Tra_M_Tramite ";
	  $sqlpcm.=" WHERE (Tra_M_Tramite.nFlgTipoDoc=3) ";
	  $sqlpcm.="AND Tra_M_Tramite.cCodificacion LIKE '%$_GET[cReferenciaPCM]%' ";
	 	$sqlpcm.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
		$sqlpcm.="AND cReferencia IS NOT NULL AND cReferencia!='' ";
	  $rspcm = sqlsrv_query($cnx,$sqlpcm);
		$salida = sqlsrv_has_rows($rspcm);
		if ($salida != 0 ){
	    while ($Rspcm = sqlsrv_fetch_array($rspcm)){
		 		$sqlcod = "SELECT TOP 100 * FROM Tra_M_Tramite ";
		 		$sqlcod.=" WHERE (Tra_M_Tramite.nFlgTipoDoc=1) ";
	    	$sqlcod.="AND Tra_M_Tramite.cCodificacion = '$Rspcm[cReferencia]' ";
	    	$rs = sqlsrv_query($cnx,$sqlcod);
		 	}
		}else if($salida == 0 ){
		 	$sqlcod="SELECT TOP 100 * FROM Tra_M_Tramite ";
		 	$sqlcod.=" WHERE (Tra_M_Tramite.nFlgTipoDoc IN (1,3)) ";
	    $sqlcod.="AND Tra_M_Tramite.cCodificacion = '$_GET[cReferenciaPCM]' ";
			$rs = sqlsrv_query($cnx,$sqlcod);
		}
		echo $sqlcod;
	}
	// CASO EN EL QUE TODOS LOS CAMPOS ESTón CON DATA, EXCEPTO DOC. PRO INVERSION QUE EST� EN BLANCO
	if ($_GET['cReferenciaPCM'] == "" OR $fecini != "" OR $fecfin != "" OR $_GET['cCodificacion'] != "" OR $_GET['iCodOficina'] != "" OR 
			$_GET['cAsunto'] != "" OR $_GET['cReferencia'] != "" OR $_GET['iCodTupa'] != "" OR $_GET['cNombre'] != "" OR 
			$_GET['iCodTrabajadoResponsable'] != "" OR $_GET['cNroDocumento'] != "" OR $_GET['cNomRemite'] != ""){
		$sqlgrupo = " SELECT iCodGrupoTramite FROM Tra_M_Grupo_Tramite_Detalle WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' ";
	  $rsgrupo  = sqlsrv_query($cnx,$sqlgrupo);
	  $Rsgrupo  = sqlsrv_fetch_array($rsgrupo);
	   
	  $sqlDet= " SELECT iCodTrabajador FROM Tra_M_Grupo_Tramite_Detalle WHERE iCodGrupoTramite='$Rsgrupo[iCodGrupoTramite]' ";
	  $rsDet=sqlsrv_query($cnx,$sqlDet);
	  $Det = sqlsrv_has_rows($rsDet);
	  $cont=0;
	  $cont2=0;
		
		if($_GET[cReferenciaPCM] == "" OR $fecini != "" OR $fecfin != "" OR $_GET['cCodificacion'] != "" OR $_GET['iCodOficina'] == "" OR
			 $_GET['cAsunto'] == "" OR $_GET[cReferencia] == "" OR $_GET['iCodTupa'] == "" OR $_GET['cNombre'] == "" OR
			 $_GET[iCodTrabajadoResponsable] == "" OR $_GET['cNroDocumento'] == "" OR $_GET[cNomRemite] == ""){
	  	$sql = "SELECT TOP 1000 * FROM Tra_M_Tramite ";
			$A=1;
		}else{
			$sql = "SELECT * FROM Tra_M_Tramite ";	  
	  }

		if ($_GET['iCodOficina'] != ""){
			$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
		}
	  if($_GET['cNombre'] != ""){
	  	$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
		}
	  $sql.=" WHERE (Tra_M_Tramite.nFlgTipoDoc=1 OR Tra_M_Tramite.nFlgTipoDoc=4) AND ( ";
	  while ($RsDet = sqlsrv_fetch_array($rsDet)){
			$cont  = $cont+1;
		  $cont2 = $cont2+1;
	  	$sql.="  Tra_M_Tramite.iCodTrabajadorRegistro='$RsDet[iCodTrabajador]' "; 
	  	if($cont < $Det){ $sql.=" OR  "; }
	  	if($cont2 >= $Det){ $sql.=" ) "; }
		}
	  if($fecini != "" AND $fecfin == ""){
	  	$sql.=" AND Tra_M_Tramite.fFecRegistro > '$fecini' ";
	  }
	  if ($fecini == "" AND $fecfin != ""){
	  	$sql.=" AND Tra_M_Tramite.fFecRegistro<= '$fecfin'  ";
	  }
	  if ($fecini != "" && $fecfin != ""){
	  //$sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
	  $sql.=" AND ( Tra_M_Tramite.fFecRegistro > '$fecini' and Tra_M_Tramite.fFecRegistro <= '$fecfin' ) ";
	  }
		if ($_GET['cCodificacion'] != ""){
	    $sql.="AND Tra_M_Tramite.cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
	  }
		if ($_GET[cReferencia] != ""){
	    $sql.="AND Tra_M_Tramite.cReferencia LIKE '%$_GET[cReferencia]%' ";
	  }
	  if ($_GET['cAsunto'] != ""){
	    $sql.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
	  }
		if ($_GET['iCodTupa'] != ""){
	    $sql.="AND Tra_M_Tramite.iCodTupa='$_GET['iCodTupa']' ";
	  }
		if ($_GET['cCodTipoDoc'] != ""){
	  	$sql.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
	  }
	  if($_GET['cNombre'] != ""){
	   $sql.="AND Tra_M_Remitente.cNombre LIKE '%$_GET['cNombre']%' ";
	  }
	  if ($_GET[cNomRemite] != ""){
	  	$sql.="AND Tra_M_Tramite.cNomRemite LIKE '%$_GET[cNomRemite]%' ";
	  }
		if ($_GET['iCodOficina'] != ""){
	  	$sql.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar='$_GET['iCodOficina']' ";
	  }
	  if ($_GET['cNroDocumento'] != ""){
	  	$sql.="AND Tra_M_Tramite.cNroDocumento LIKE '%$_GET['cNroDocumento']%' ";
	  }
		$sql.= " ORDER BY Tra_M_Tramite.fFecRegistro DESC";
	  $rs = sqlsrv_query($cnx,$sql);
	}	
}
  //echo $sql;
 	$total = sqlsrv_has_rows($rs);
?>
<br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
	<td width="98" class="headCellColum">
		<a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; TRÁMITE</a></td>
	<td width="142" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodTipoDoc&orden=<?=$cambio?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodTipoDoc"){ echo "underline"; }Else{ echo "none";}?>">Tipo Documento</a></td>
	<td width="300" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.iCodRemitente&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.iCodRemitente"){ echo "underline"; }Else{ echo "none";}?>">Remitente</a></td>
	<td width="92" class="headCellColum">Fecha Derivo</td>
	<td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cAsunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cAsunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto / TUPA</a></td>
  <td width="83" class="headCellColum">Opciones</td>
	</tr>
<?php
$numrows = sqlsrv_has_rows($rs);
if ($numrows == 0){ 
	echo "NO SE ENCONTRARON REGISTROS<br>";
	echo "TOTAL DE REGISTROS : ".$numrows;
}else{
	echo "TOTAL DE REGISTROS : ".$numrows;
	
///////////////////////////////////////////////////////
for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
	sqlsrv_fetch_array($rs, $i);
	$Rs = sqlsrv_fetch_array($rs);
///////////////////////////////////////////////////////
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
    			<a href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramite]?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
    	<?php } else{?>
    			<a href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramiteRel]?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
    	<?php}?>
    	<?
    	echo "<div style=color:#727272>".date("d-m-Y G:i:s", strtotime($Rs['fFecRegistro']))."</div>";
      //echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
	  $sqlTra="SELECT cApellidosTrabajador,cNombresTrabajador, ES_EXTERNO FROM Tra_M_Trabajadores 
	  	WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
			$rsTra=sqlsrv_query($cnx,$sqlTra);
			$RsTra=sqlsrv_fetch_array($rsTra);
			echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
			if ($RsTra['ES_EXTERNO'] == 1) {
				echo "<div style=color:#FF00FF;>Usuario Web</div>";
			}
	$sqlCop="SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND cFlgTipoMovimiento=4 ORDER BY iCodMovimiento ASC";
    $rsCop=sqlsrv_query($cnx,$sqlCop);
	$numCop=sqlsrv_has_rows($rsCop);
	if($numCop >0){
	 echo "<div style=color:#FF0000;font-size:12px>Copias (".$numCop.")</div>";	
	}
	else {
	 echo "";
	}
      ?>
    </td>
    <td align="left" valign="top">
    	<?
    	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$Rs[cCodTipoDoc]'";
			$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			echo $RsTipDoc['cDescTipoDoc'];
			echo "<div style=color:#808080;text-transform:uppercase>".$Rs['cNroDocumento']."</div>";
			//echo "nFlgEnvio ".$Rs[nFlgEnvio];
			if ($Rs[nFlgEnvio] == 0) {
				$mensaje = "Pendiente de derivación";
				//$mensaje = $Rs[nFlgEnvio];
			}elseif ($Rs[nFlgEnvio] == 1) {
				$mensaje = "";
			}
			echo "<div style=color:#FF0000;text-transform:uppercase>".$mensaje."</div>";
			//echo "<div style=color:#FF0000;text-transform:uppercase>".$Rs[nFlgEnvio]."</div>";
    	?>
    </td>
    <td valign="top" align="left">
    	<?
    	$sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
			$rsRemi=sqlsrv_query($cnx,$sqlRemi);
			$RsRemi=sqlsrv_fetch_array($rsRemi);
			echo "<div style=color:#000000;>".$RsRemi['cNombre']."</div>";
				if($Rs[cNomRemite]!=""){
					if($RsRemi['cTipoPersona']==1){ echo "<div style=color:#408080>Personal Natural:</div>"; }
				}
			echo "<div style=color:#408080;text-transform:uppercase>".$Rs[cNomRemite]."</div>";
      
      if($Rs[nFlgTipoDoc]==4){
				echo "<div style=color:#006600;><b>ANEXO</b></div>";
			}
      ?>
    </td> 
    <td valign="top" align="center">
    	<?
    	if($Rs[nFlgTipoDoc]!=4){
    		if($Rs[nFlgEnvio]==1){
    			$sqlM="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]'";
      		$rsM = sqlsrv_query($cnx,$sqlM);
	    		$RsM = sqlsrv_fetch_array($rsM);
    			echo "<div style=color:#0154AF>".date("d-m-Y G:i:s", strtotime($RsM['fFecDerivar']))."</div>";
    			//echo "<div style=color:#0154AF>".date("d-m-Y G:i:s", strtotime($RsM['fFecDerivar']))."</div>";
    			//echo "<div style=color:#0154AF>".date("d-m-Y G:i:s", strtotime($Rs['fFecDocumento']))."</div>";
					//echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsM['fFecDerivar']))."</div>";
      	}
      }else{
      		$sqlM="select TOP 1 * from Tra_M_Tramite_Movimientos WHERE iCodTramiteRel='$Rs[iCodTramiteRel]'";
      		$rsM=sqlsrv_query($cnx,$sqlM);
	    		$RsM=sqlsrv_fetch_array($rsM);
    			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsM['fFecDerivar']))."</div>";
      		echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsM['fFecDerivar']))."</div>";
      }
			?>
		</td>
    <td valign="top" align="left">
    	<?
    	echo $Rs['cAsunto'];
    	if($Rs['iCodTupa']!=""){
    		$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$Rs['iCodTupa']."'";
      	$rsTup=sqlsrv_query($cnx,$sqlTup);
      	$RsTup=sqlsrv_fetch_array($rsTup);
      	echo "<div style=color:#0154AF>".$RsTup["cNomTupa"]."</div>";
		    $sqlReq= " SELECT * FROM Tra_M_Tupa_Requisitos WHERE iCodTupa=(SELECT iCodTupa FROM Tra_M_Tramite WHERE iCodTramite='$Rs[iCodTramite]') AND iCodTupaRequisito NOT IN 
			          (SELECT iCodTupaRequisito FROM Tra_M_Tramite_Requisitos WHERE iCodTramite='$Rs[iCodTramite]' ) ";
  		$rsReq=sqlsrv_query($cnx,$sqlReq);
      	$numReq=sqlsrv_has_rows($rsReq);
		if($numReq>0){
      	echo "\n<div style=color:#FF0000>Faltan ".$numReq." Requisitos por cumplir</div>";			  
		}
	  }
	  if(trim($Rs[cReferencia])!=""){
	 echo "<div style=color:#808080;text-transform:uppercase>Referencia : ".$Rs[cReferencia]."</div>";
	  }
    	?>
    </td>
    <td valign="top">

    		<?php
            	$tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$Rs[iCodTramite]'");
  				$RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
				
				if ($RsTramitePDF->descripcion != NULL AND $RsTramitePDF->descripcion!=' ') {
            ?>
            <a href="registroInternoDocumento_pdf.php?iCodTramite=<?php echo $RsTramitePDF->iCodTramite;?>" target="_blank" title="Documento Electrónico">
            	<img src="images/1471041812_pdf.png" border="0" height="17" width="17">
            </a>
            <?php } ?>
    		<?php
    			$sqlDw="SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]'";
      		$rsDw=sqlsrv_query($cnx,$sqlDw);
      		if(sqlsrv_has_rows($rsDw)>0){
      			$RsDw=sqlsrv_fetch_array($rsDw);
      			if($RsDw["cNombreNuevo"]!=""){
				 			if (file_exists("../cAlmacenArchivos/".trim($RsDw["cNombreNuevo"]))){
								echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
							}
						}
      		}else{
      			echo "<img src=images/space.gif width=16 height=16 border=0>";
      		}
    			?>
    			<?php if($Rs[nFlgTipoDoc]==1){?>
    				<?php if($Rs[nFlgClaseDoc]==1){?>
    				<a href="registroConTupaEdit.php?iCodTramite=<?=$Rs[iCodTramite]?>&URI=<?=$_SERVER['REQUEST_URI']?>"><i class="fas fa-edit"></i></a>
    				<?php}?>
    				<?php if($Rs[nFlgClaseDoc]==2){?>
    				<a href="registroSinTupaEdit.php?iCodTramite=<?=$Rs[iCodTramite]?>&URI=<?=$_SERVER['REQUEST_URI']?>"><i class="fas fa-edit"></i></a>
    				<?php}?>
    				<a href="registroAnexo.php?iCodTramite=<?=$Rs[iCodTramite]?>" rel="lyteframe" title="Anexo del Documento" rev="width: 970px; height: 520px; scrolling: auto; border:no"><img src="images/icon_anexo.png" width="16" height="16" border="0"></a>
    				
    				<a href="registroCopiaNumero.php?iCodTramite=<?=$Rs[iCodTramite]?>&URI=<?=$_SERVER['REQUEST_URI']?>" rel="lyteframe" title="Agregar Copias" rev="width: 450px; height: 160px; scrolling: auto; border:no"><img src="images/icon_copy.png" width="16" height="16" border="0"></a>
    			<?php}?>
    				
    			
    			<?php if($Rs[nFlgTipoDoc]==4){?>
        		<a href="registroAnexoEdit.php?iCodTramite=<?=$Rs[iCodTramite]?>&URI=<?=$_SERVER['REQUEST_URI']?>" rel="lyteframe" title="Editar Anexo" rev="width: 970px; height: 410px; scrolling: auto; border:no"><img src="images/icon_edit_anexo.png" width="16" height="16" border="0"></a>
        		<img src="images/space.gif" width="16" height="16" border="0">
      		<?php}?>
    </td>
</tr>
  
<?
}
}
?> 
		<tr>
		<td colspan="6" align="center">
        <?
        echo paginar($pag, $total, $tampag, "consultaEntradaPersonal.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&iCodOficina=".$_GET['iCodOficina']."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&iCodTupa=".$_GET['iCodTupa']."&cNombre=".$_GET['cNombre']."&iCodTrabajadoResponsable=".$_GET[iCodTrabajadoResponsable]."&cNroDocumento=".$_GET['cNroDocumento']."&cNomRemite=".$_GET[cNomRemite]."&pag=");
		 		?>
		</td>
		</tr>
</table>
<?  }
else {
		echo "USUARIO SIN ASOCIACION A UN GRUPO<br>";
     }
?>	 
    </td>
	  </tr>
		</table>



<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?

}else{
   header("Location: ../index-b.php?alter=5");
}
?>