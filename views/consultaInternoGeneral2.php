<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaInternoGeneral.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta de los Documentos Internos Generales
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

<div class="AreaTitulo">Consulta de Documentos Internos</div>




							<form name="frmConsultaEntrada" method="GET" action="consultaInternoGeneral.php">
						<tr>
							<td width="110" >N&ordm; Documento:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td><input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>
							</td>
						</tr>
						<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:260px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 ";
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
                         
							<td colspan="2" align="left">
                            <table width="400" border="0" align="left">
                           <tr>
                            <td align="left">
                              Descarga &nbsp; <img src="images/icon_download.png" width="16" height="16" border="0" > &nbsp; &nbsp;
	                          | &nbsp; &nbsp;  Editar &nbsp; <i class="fas fa-edit"></i>&nbsp;&nbsp;&nbsp; </td>
                           </tr>
                          </table>
                          </td>
                          <td colspan="2" align="right">
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
                           <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
                             &nbsp;
			    <?php // ordenamiento
                if($_GET['campo']==""){ $campo="Tra_M_Tramite.fFecRegistro"; }Else{ $campo=$_GET['campo']; }
                if($_GET['orden']==""){ $orden="DESC"; }Else{ $orden=$_GET['orden']; } ?>
				<button class="btn btn-primary" onclick="window.open('consultaInternoGeneral_xls.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&cObservaciones=<?=$_GET[cObservaciones]?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficinaOri=<?=$_GET['iCodOficinaOri']?>&iCodOficinaDes=<?=$_GET['iCodOficinaDes']?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&orden=<?=$orden?>&campo=<?=$campo?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('consultaInternoGeneral_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&cObservaciones=<?=$_GET[cObservaciones]?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficinaOri=<?=$_GET['iCodOficinaOri']?>&iCodOficinaDes=<?=$_GET['iCodOficinaDes']?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
							
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

	
	
    $fDesde=date("Ymd", strtotime($_GET['fDesde']));
	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia

    $sql= "SELECT TOP 500 Tra_M_Tramite.iCodTramite,cDescTipoDoc,iCodTrabajadorRegistro,Tra_m_oficinas.cNomOficina,Tra_M_Tramite.cCodificacion,fFecRegistro,cAsunto, cReferencia,cObservaciones,cApellidosTrabajador,cNombresTrabajador,Tra_M_Tramite.nFlgEnvio,nFlgClaseDoc,iCodOficinaRegistro ";
    $sql.="FROM Tra_M_Tramite ";
	if($_GET[iCodOficinaOri]!="" or $_GET[iCodOficinaDes]!=""){
  	$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
  }
    $sql.="LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ";
    $sql.="LEFT OUTER JOIN Tra_M_Trabajadores ON Tra_M_Tramite.iCodTrabajadorSolicitado=Tra_M_Trabajadores.iCodTrabajador ";
    $sql.="LEFT OUTER JOIN Tra_m_oficinas on Tra_M_Tramite.iCodOficinaRegistro=Tra_m_oficinas.iCodOficina ";
	
	  $sql.="WHERE Tra_M_Tramite.nFlgTipoDoc=2 AND Tra_M_Tramite.nFlgClaseDoc=1 ";
    if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	$sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
    }
    if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	$sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
    }
    if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	$sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
    }	
    if($_GET[SI]==1 AND $_GET[NO]==1 ){
    $sql.=" AND (Tra_M_Tramite.nFlgEnvio=1 OR Tra_M_Tramite.nFlgEnvio=0) ";
    }
    if($_GET[SI]==0 AND $_GET[NO]==1 ){
    $sql.=" AND Tra_M_Tramite.nFlgEnvio=0 ";
    }
    if($_GET[SI]==1 AND $_GET[NO]==0 ){
    $sql.=" AND Tra_M_Tramite.nFlgEnvio=1 ";
    }	
    if($_GET['cCodificacion']!=""){
    $sql.="AND Tra_M_Tramite.cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
    }
	if($_GET['cAsunto']!=""){
    $sql.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
    }
	if($_GET[cObservaciones]!=""){
    $sql.="AND Tra_M_Tramite.cObservaciones LIKE '%$_GET[cObservaciones]%' ";
    }
	if($_GET['cCodTipoDoc']!=""){
    $sql.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
    }	   
	if($_GET[iCodOficinaOri]!=""){
   $sql.="AND Tra_M_Tramite.iCodOficinaRegistro='$_GET[iCodOficinaOri]' ";
  }
  if($_GET[iCodOficinaDes]!=""){
   $sql.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar='$_GET[iCodOficinaDes]' AND nEstadoMovimiento!=2 ";
  }
	$sql.= " ORDER BY $campo $orden";	   
    $rs=sqlsrv_query($cnx,$sql);
	$total = sqlsrv_has_rows($rs);
   //echo $sql;
?>
<br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
 <td width="70" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.fFecRegistro&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Tra_M_Tramite.fFecRegistro"){ echo "underline"; }Else{ echo "none";}?>">Fecha</a></td>
 <td width="150" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cNomOficina&orden=<?=$cambio?>&cNomOficina=<?=$_GET[cNomOficina]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="cNomOficina"){ echo "underline"; }Else{ echo "none";}?>">Oficina Origen</a></td>
	<td width="150" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cDescTipoDoc&orden=<?=$cambio?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="cDescTipoDoc"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
     <td width="150" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cNombresTrabajador&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="cNombresTrabajador"){ echo "underline"; }Else{ echo "none";}?>">Responsable</a></td>
	<td width="200" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo= Tra_M_Tramite.cAsunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo==" Tra_M_Tramite.cAsunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto</a></td>
	<td class="headCellColum">Observaciones</td>
   <td width="100" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="cNomOficina"){ echo "underline"; }Else{ echo "none";}?>">Oficina Destino</a></td>
  	<td width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cReferencia&orden=<?=$cambio?>&cReferencia=<?=$_GET[cReferencia]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cReferencia"){ echo "underline"; }Else{ echo "none";}?>">Nro de Referencia</a></td>
  <td width="75" class="headCellColum">Opciones</td>
	</tr>
<?
if($_GET['fDesde']=="" && $_GET['fHasta']=="" && $_GET['cCodTipoDoc']=="" && $_GET['cAsunto']=="" && $_GET['cCodificacion']=="" && $_GET[cReferencia]=="" && $_GET[SI]=="" && $_GET[NO]=="" && $_GET[iCodOficinaOri]=="" && $_GET[iCodOficinaDes]=="" ){
  $sqlin= "SELECT Tra_M_Tramite.iCodTramite FROM Tra_M_Tramite ";
    if($_GET[iCodOficinaOri]!="" or $_GET[iCodOficinaDes]!=""){
  	$sqlin.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    }
    $sqlin.="WHERE Tra_M_Tramite.nFlgTipoDoc=2 AND Tra_M_Tramite.nFlgClaseDoc=1 ";
	$rsin=sqlsrv_query($cnx,$sqlin);
$numrows=sqlsrv_has_rows($rsin);
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
//while ($Rs=sqlsrv_fetch_array($rs))
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
    	echo "<div style=color:#727272;font-size:10px>".date("h:i A", strtotime($Rs['fFecRegistro']))."</div>";
		$sqlTra="SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
			$rsTra=sqlsrv_query($cnx,$sqlTra);
			$RsTra=sqlsrv_fetch_array($rsTra);
			echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";	 
			?>
		</td>
    <td valign="top" align="left"><?=$Rs[cNomOficina];?></td>
    <td valign="top" align="left">
	    <?	
			echo $Rs['cDescTipoDoc'];
			echo "<br>";
			echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
			echo $Rs[cCodificacion];
			echo "</a>";
			?>
		</td>
        <td valign="top" align="left"><?=$Rs[cNombresTrabajador]?> <?=$Rs[cApellidosTrabajador]?></td>
    <td valign="top" align="left"><?=$Rs['cAsunto']?></td>
    <td valign="top" align="left"><?=$Rs[cObservaciones];?></td>
     <td valign="top" align="left">
	        <? $sqlDes= " SELECT  Tra_M_Tramite.iCodTramite,cNombresTrabajador,cApellidosTrabajador,cNomOficina FROM Tra_M_Tramite "; 
               $sqlDes.= " LEFT OUTER JOIN Tra_M_Tramite_Movimientos on Tra_M_Tramite.icodtramite=Tra_M_Tramite_Movimientos.icodtramite ";
			   $sqlDes.= " LEFT OUTER JOIN Tra_M_Trabajadores on Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar=Tra_M_Trabajadores.iCodTrabajador, Tra_M_Oficinas ";
               $sqlDes.= " WHERE Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Movimientos.iCodOficinaDerivar AND Tra_M_Tramite.nFlgTipoDoc=2 AND Tra_M_Tramite.nFlgClaseDoc=1 ";
			   $sqlDes.= " AND Tra_M_Tramite.iCodTramite='$Rs[iCodTramite]' ";
			   $rsDes=sqlsrv_query($cnx,$sqlDes);
			   $numDes=sqlsrv_has_rows($rsDes);
			   if($numDes>1){echo "MULTIPLE";   }
			   else{ 
			    $RsDes=sqlsrv_fetch_array($rsDes); 
			    echo $RsDes[cNomOficina]; 
				echo "<div style=color:#727272>".$RsDes[cNombresTrabajador]." ".$RsDes[cApellidosTrabajador]."</div>"; 
				 }
			   ?></td>
    <td valign="top" align="left"><?php echo "<div style=text-transform:uppercase>".$Rs[cReferencia]."</div>"; ?></td>
    <td valign="top" width="75">

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
      			echo "<img src=images/space.gif width=16 height=16>";
      		}
    			echo "<a href=\"registroOficinaEdit.php?iCodTramite=".$Rs[iCodTramite]."&URI=".$_SERVER['REQUEST_URI']."\"><img src=\"images/icon_edit.png\" width=\"16\" height=\"16\" border=\"0\"></a>";
    			?>
		</td>
        
</tr>
  
<? 
  }
  }?> 
<tr>
		<td colspan="8" align="center">
         <?php echo paginar($pag, $total, $tampag, "consultaInternoGeneral.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&SI=".$_GET[SI]."&NO=".$_GET[NO]."&iCodOficinaOri=".$_GET[iCodOficinaOri]."&iCodOficinaDes=".(isset($_GET['iCodOficinaDes'])?$_GET['iCodOficinaDes']:'')."&pag=");?>
         </td>
		</tr>
</table>
 	  </tr>
		</table>  
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>