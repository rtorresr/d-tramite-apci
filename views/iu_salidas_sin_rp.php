<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaSalidaGeneral.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta General de los Documentos de Salida
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------


*****************************************************************************************/
?>
<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
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

<div class="AreaTitulo">Consulta >> Doc. Salidas Generales</div>

	<legend>Criterios de B�squeda:</legend>

							<form name="frmConsultaEntrada" method="GET" onSubmit="return validar(this)" action="consultaEntradaGeneral.php">
						<tr>
							<td width="110" >N&ordm; Documento:</td>
							<td width="390" colspan="4" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td>
    <?
if(trim($_REQUEST[fHasta])==""){$fecfin = $_REQUEST[fHasta];} else { $fecfin = $_REQUEST[fHasta]; }
if(trim($_REQUEST[fDesde])==""){$fecini = $_REQUEST[fDesde];} else { $fecini = $_REQUEST[fDesde]; }
	?>                     
                                    <input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
						</tr>
						<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" colspan="4" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:260px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgSalida=1";
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
						  <td >Instituci&oacute;n:</td>
						  <td colspan="4" align="left"><input type="txt" name="cNombre" value="<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>" size="65" class="FormPropertReg form-control" /></td>
						  <td >Observaciones:</td>
						  <td align="left" class="CellFormRegOnly"><input type="txt" name="cObservaciones" value="<?=$_GET[cObservaciones]?>" size="65" class="FormPropertReg form-control" /></td>
						  </tr>
						<tr>
						  <td height="10" >Destinatario:</td>
						  <td height="10" colspan="4" align="left"><input type="txt" name="cNomRemite" value="<?=$_GET[cNomRemite]?>" size="65" class="FormPropertReg form-control" /></td>
						  <td height="10" >&nbsp;</td>
						  <td height="10">&nbsp;</td>
						  </tr>
						<tr>
							<td height="10" >Requiere Respuesta:</td>
							<td height="10">
                            SI<input type="checkbox" name="RespuestaSI" value="1" onclick="this.form.Respuesta.disabled = (this.checked) ? false : true;" <?php if($_GET[RespuestaSI]==1) echo "checked"?>  />
							   &nbsp;&nbsp;&nbsp;
	                        NO<input type="checkbox" name="RespuestaNO" value="1" <?php if($_GET[RespuestaNO]==1) echo "checked"?> /></td>
                            <td >&nbsp;</td>
                            <td >Respuesta:</td>
                            <td><label>
                            <select name="Respuesta" id="Respuesta" <?php if($_GET[RespuestaSI]!=1){ echo "disabled";} ?> >
                                <option value="0">seleccione:</option>
                                <option value="1" <?php if($_GET[Respuesta]==1){echo 'selected';} ?> style=color:#950000>Pendiente</option>
                                <option value="2" <?php if($_GET[Respuesta]==2){echo 'selected';} ?> style=color:#0154AF>Recibido</option>
                            </select>
                            </label></td>
                          <td height="10" >Oficina Origen:</td>
                       <td height="10">
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
                         
							<td colspan="7" align="right">
                            <table width="400" border="0" align="left">
                           <tr>
                            <td align="left">
                              Descargar &nbsp; <img src="images/icon_download.png" width="16" height="16" border="0" > &nbsp; &nbsp;
	                          | &nbsp; &nbsp;  Editar &nbsp; <i class="fas fa-edit"></i>&nbsp;&nbsp;
                              | &nbsp; &nbsp; Respuesta &nbsp; <img src="images/icon_avance.png" width="16" height="16" border="0">&nbsp;&nbsp;
                              | &nbsp; &nbsp; M&uacute;ltiple &nbsp; <img src="images/page_copy.png" width="16" height="16" border="0">&nbsp;&nbsp;|  Copia a Oficina&nbsp; <img src="images/icon_delegar.png" width="16" height="16" border="0">                           </td>
                           </tr>
                          </table>
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							�
							<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
              �     <?php // ordenamiento
                       if($_GET['campo']==""){ $campo="Codigo"; }Else{ $campo=$_GET['campo']; }
                       if($_GET['orden']==""){ $orden="DESC"; }Else{ $orden=$_GET['orden']; } ?>
							<button class="btn btn-primary" onclick="window.open('consultaSalidaGeneral_xls.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&RespuestaSI=<?=$_GET[RespuestaSI]?>&RespuestaNO=<?=$_GET[RespuestaNO]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&Respuesta=<?=$_GET[Respuesta]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&orden=<?=$orden?>&campo=<?=$campo?>&iCodOficina=<?=$_GET['iCodOficina']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							�
							<button class="btn btn-primary" onclick="window.open('consultaSalidaGeneral_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&RespuestaSI=<?=$_GET[RespuestaSI]?>&RespuestaNO=<?=$_GET[RespuestaNO]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&Respuesta=<?=$_GET[Respuesta]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&orden=<?=$orden?>&campo=<?=$campo?>&iCodOficina=<?=$_GET['iCodOficina']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
    						</td>
						</tr>
							</form>
						</table>
			</fieldset>

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

//invertir orden
if($orden=="ASC") $cambio="DESC";
if($orden=="DESC") $cambio="ASC";

	if ($fecini!=''){$fecini=date("Ymd", strtotime($fecini));}
    if( $fecfin!=''){
    $fecfin=date("Y-m-d", strtotime($fecfin));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fecfin=dateadd($fecfin,1,0,0,0,0,0); // + 1 dia
	$fecini=dateadd($fecini,0,0,0,0,0,0);
	}
?>
<br>
<table width="1037" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
    <td width="64" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Fecha&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&RespuestaSI=<?=$_GET[RespuestaSI]?>&RespuestaNO=<?=$_GET[RespuestaNO]?>&iCodOficina=<?=$_GET['iCodOficina']?>&Respuesta=<?=$_GET[Respuesta]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Fecha"){ echo "underline"; }Else{ echo "none";}?>">Fecha</a></td>
    <td width="140" class="headCellColum">Oficina de Origen</td> 
	<td width="140" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&RespuestaSI=<?=$_GET[RespuestaSI]?>&RespuestaNO=<?=$_GET[RespuestaNO]?>&iCodOficina=<?=$_GET['iCodOficina']?>&Respuesta=<?=$_GET[Respuesta]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
	<td width="200" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&RespuestaSI=<?=$_GET[RespuestaSI]?>&RespuestaNO=<?=$_GET[RespuestaNO]?>&iCodOficina=<?=$_GET['iCodOficina']?>&Respuesta=<?=$_GET[Respuesta]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto</a></td>
	<td width="105" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Observacion&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&RespuestaSI=<?=$_GET[RespuestaSI]?>&RespuestaNO=<?=$_GET[RespuestaNO]?>&iCodOficina=<?=$_GET['iCodOficina']?>&Respuesta=<?=$_GET[Respuesta]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Observacion"){ echo "underline"; }Else{ echo "none";}?>">Dirección</a></td>
    <td width="98" class="headCellColum">Destino</td>
    <td colspan="2" class="headCellColum">Requiere Respuesta</td>
<? /*    <td width="80" class="headCellColum">Opciones</td> */?>
	</tr>
<?
 $sql="SP_CONSULTA_SALIDA_GENERAL_NOTIFICADOS '$fecini', '$fecfin','$_GET[RespuestaSI]', '$_GET[RespuestaNO]', '%".$_GET['cCodificacion']."%', '%".$_GET['cAsunto']."%', '%$_GET[cObservaciones]%', '".$_GET['cCodTipoDoc']."','%$_GET['cNombre']%','%$_GET[cNomRemite]%','$_GET[Respuesta]','$_GET['iCodOficina']','$campo','$orden' ";
   $rs=sqlsrv_query($cnx,$sql);
   $total = sqlsrv_has_rows($rs);
   echo $sql;

  if($_GET['cCodificacion']=="" && $fecini=="" && $fecfin=="" && $_GET['cCodTipoDoc']=="" && $_GET['cAsunto']=="" && $_GET[RespuestaSI]=="" && $_GET[RespuestaNO]=="" && $_GET['iCodOficina']=="" && $_GET[Respuesta]=="" && $_GET['cNombre']=="" && $_GET[cObservaciones]==""){
   $sqlsa="  SP_CONSULTA_SALIDA_GENERAL_CONTEO '$_GET['iCodOficina']'  ";
   $rssa=sqlsrv_query($cnx,$sqlsa);
   $numrows=sqlsrv_has_rows($rssa);
 }
else{
$numrows=sqlsrv_has_rows($rs);
}
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
         echo "TOTAL DE REGISTROS : ".$numrows;
for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
sqlsrv_fetch_array($rs, $i);
$Rs=sqlsrv_fetch_array($rs);
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
   	<?
     echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
     echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
	 echo "<div style=color:#808080;>".$Rs[cNombresTrabajador]." ".$Rs[cApellidosTrabajador]."</div>";	
		?>    </td> 
    <td valign="middle" align="left">
	<?php echo $Rs[cNomOficina];
	$sqlJef="SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$Rs[iCodTrabajadorSolicitado]."'";
	$rsJef=sqlsrv_query($cnx,$sqlJef);
	$RsJef=sqlsrv_fetch_array($rsJef);
	echo "<div style=color:#808080;>".$RsJef[cNombresTrabajador]." ".$RsJef[cApellidosTrabajador]."</div>";	 	
	?></td>
    <td valign="top" align="left">
		<?
	 	echo $Rs['cDescTipoDoc'];
    echo "<div>";
    if($Rs[nFlgClaseDoc]==1){
    	echo "<a style=\"color:#0067CE\" href=\"registroSalidaDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
    }
    if($Rs[nFlgClaseDoc]==2){
    	echo "<a style=\"color:#0067CE\" href=\"registroEspecialDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
    }
    echo $Rs[cCodificacion];
    echo "</a>";
    echo "</div>";
    ?>    </td>
    <td valign="top" align="left"><?=$Rs['cAsunto']?></td>
    <td valign="top" align="left">
	<? 
		$sqlDir=" SELECT cDireccion, cDepartamento, cProvincia, cDistrito FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite=".$Rs[iCodTramite] ;	
		$rsDir= sqlsrv_query($cnx,$sqlDir);
		if($Dirnum=sqlsrv_has_rows($rsDir)<=1){
		$RsDir= sqlsrv_fetch_array($rsDir);
	  $rsDep=sqlsrv_query($cnx,"SELECT cNomDepartamento 	FROM Tra_U_Departamento WHERE cCodDepartamento='".$RsDir[cDepartamento]."'");
	  $RsDep=sqlsrv_fetch_array($rsDep);
	  $rsPro=sqlsrv_query($cnx,"SELECT cNomProvincia 	FROM Tra_U_Provincia 	WHERE cCodDepartamento='".$RsDir[cDepartamento]."' And cCodProvincia='".$RsDir[cProvincia]."'");
	  $RsPro=sqlsrv_fetch_array($rsPro);
	  $rsDis=sqlsrv_query($cnx,"SELECT cNomDistrito	 	FROM Tra_U_Distrito 	WHERE cCodDepartamento='".$RsDir[cDepartamento]."' And cCodProvincia='".$RsDir[cProvincia]."' And cCodDistrito='".$RsDir[cDistrito]."'");
	  $RsDis=sqlsrv_fetch_array($rsDis);
	  echo $RsDir[cDireccion]."<br>";
	  echo $RsDep[cNomDepartamento];
	  if($RsPro[cNomProvincia]!=""){echo " - ".$RsPro[cNomProvincia];}
	  if($RsDis[cNomDistrito]!=""){echo " - ".$RsDis[cNomDistrito];	}
		}
	 ?></td>
    <td valign="top" align="left">
    <?
	if($Rs[iCodRemitente]!=0){
	   echo  $Rs['cNombre'];
	   echo "<div style=text-transform:uppercase;color:#06F>".$Rs[cNomRemite]."</div>";
	}
	else if($Rs[iCodRemitente]==0){
	   echo "MULTIPLE"; 
	}
	else if($Rs[iCodRemitente]==-1){
	   echo "NO ASIGNADO"; 
	}
	?></td> 
    <td width="63" colspan="2"  align="center" valign="middle"> 
    <? 
	     if($Rs[nFlgRpta]==1 && $Rs[cRptaOK]!="" )
		   { echo "<div style='color:#0154AF'>SI / RECIBIDA</div>";
		     echo "<div>".$Rs[cRptaOK]."</div>"; 
		   } 
		 else if($Rs[nFlgRpta]==1 && $Rs[cRptaOK]=="" )
		   { echo "<div style='color:#950000'>SI / PENDIENTE</div>";
		     } 
		 else if($Rs[nFlgRpta]==0 && $Rs[cRptaOK]=="" )
		   { echo "NO / ------"; }  
    
	 ?>    </td>
<? /*        <td valign="top">

    			<?
    			$sqlDw="SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]'";
      		$rsDw=sqlsrv_query($cnx,$sqlDw);
      		if(sqlsrv_has_rows($rsDw)>0){
      			$RsDw=sqlsrv_fetch_array($rsDw);
      			if($RsDw["cNombreNuevo"]!=""){
				 			if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
								echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
							}
						}
      		}Else{
      			echo "<img src=images/space.gif width=16 height=16 border=0>";
      		}
			if($Rs[iCodRemitente]>0){
			echo "<a href=\"registroSalidaCopy.php?iCodTramite=".$Rs[iCodTramite]."&URI=".$_SERVER['REQUEST_URI']."&pag=2\"><img src=\"images/icon_delegar.png\" width=\"16\" height=\"16\" alt=\"Agregar Copia a Oficina\" border=\"0\"></a>";
			}
			if($Rs[iCodRemitente]==0){
			$sqlCount=" SELECT iCodAuto FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite=".$Rs[iCodTramite];
			$rsCount=sqlsrv_query($cnx,$sqlCount, $cnx);
			$Count= sqlsrv_has_rows($rsCount);
			if($Count>0){
			echo "<a href=\"registroSalidaCopy.php?iCodTramite=".$Rs[iCodTramite]."&URI=".$_SERVER['REQUEST_URI']."&pag=2\"><img src=\"images/icon_delegar.png\" width=\"16\" height=\"16\" alt=\"Agregar Copia a Oficina\" border=\"0\"></a>";
			}
			}
      		if($Rs[nFlgClaseDoc]==1){
    				echo "<a href=\"registroSalidaEdit.php?iCodTramite=".$Rs[iCodTramite]."&URI=".$_SERVER['REQUEST_URI']."\"><img src=\"images/icon_edit.png\" width=\"16\" height=\"16\" alt=\"Editar Documento\" border=\"0\"></a>";
    			}
    			if($Rs[nFlgClaseDoc]==2){
    				echo "<a href=\"registroEspecialEdit.php?iCodTramite=".$Rs[iCodTramite]."&URI=".$_SERVER['REQUEST_URI']."\"><img src=\"images/icon_edit.png\" width=\"16\" height=\"16\" alt=\"Editar Documento\" border=\"0\"></a>";
    			}
    	if($Rs[iCodRemitente]==0){
        echo "<a href='iu_doc_salidas_multiple.php?cod=$Rs[iCodTramite]'><img src='images/page_copy.png' width='16' height='16' alt=\"Asociar Destinos Multiples\" border='0'></a>";
		}Else{
      	echo "<img src=images/space.gif width=16 height=16 border=0>";
    }
	  if($Rs[nFlgRpta]==1 ){
	echo " <a style=\"color:#0067CE\" href=\"registroRespuesta.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle de la Respuesta\" rev=\"width: 410px; height: 280px; scrolling: no; border:no\"><img src='images/icon_avance.png' width='16' height='16' border='0'></a>";
    }
		?>    </td> */?>
</tr>
  
<?
}
}
?> 
<tr>
<td colspan="10" align="center">
         <?php echo paginar($pag, $total, $tampag, "consultaSalidaGeneral.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".$_REQUEST[fDesde]."&fHasta=".$_REQUEST[fHasta]."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&RespuestaSI=".$_GET[RespuestaSI]."&RespuestaNO=".$_GET[RespuestaNO]."&iCodOficina=".$_GET['iCodOficina']."&Respuesta=".$_GET[Respuesta]."&cNombre=".$_GET['cNombre']."&cObservaciones=".$_GET[cObservaciones]."&pag=");?>         </td>
		</tr>
</table>
  	  </tr>
		</table>  


<?php include("includes/userinfo.php");?>

</table>


<?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>