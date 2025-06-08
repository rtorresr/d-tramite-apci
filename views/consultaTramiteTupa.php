<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaTramiteTupa.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta de los Documentos de Entrada
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

<div class="AreaTitulo">Consulta >> Tramites Tupa</div>




							<form name="frmConsultaEntrada" method="GET" action="consultaTramiteTupa.php">
						<tr>
							<td width="110" >N&ordm; Tr&aacute;mite:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57 || event.keyCode == 47 || event.keyCode == 46  ) event.returnValue = false;"></td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td><input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>
							</td>
						</tr>
						<tr>
							<td width="110" >Proc. Tupa:</td>
							<td width="390" align="left"> 
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
					             </select>
                          </td>
							<td width="110" >Estado:</td>
							<td align="left"><label>
							  <select name="nFlgEstado" id="nFlgEstado" class="FormPropertReg form-control">
							    <option value="">Seleccione:</option>
							    <option value="1"  <?php if($_GET[nFlgEstado]==1){ echo 'selected';} ?>>Pendiente</option>
							    <option value="2"  <?php if($_GET[nFlgEstado]==2){ echo 'selected';} ?>>En Proceso</option>
							    <option value="3"  <?php if($_GET[nFlgEstado]==3){ echo 'selected';} ?>>Finalizado</option>
						          </select>
							</label>							</td>
						</tr>
						<tr>
							<td width="110" >Oficina:</td>
							<td width="390" align="left">
                            <select name="iCodOficina" class="FormPropertReg form-control" style="width:360px" />
     	                     <option value="">Seleccione:</option>
	                      <?   
	                           $sqlOfi="SP_OFICINA_LISTA_COMBO"; 
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
							<td width="110" >Resultado:</td>
							<td align="left" class="CellFormRegOnly"><label>
							  <select name="nSilencio" id="nSilencio" class="FormPropertReg form-control">
							    <option value="" selected>Seleccione:</option>
                                <option value="1" <?php if($_GET[nSilencio]==1){ echo 'selected';} ?>>Silencio Adm. Positivo</option>
						        <option value="0" <?php if($_GET[nSilencio]==0 && $_GET[nSilencio]!=""){ echo 'selected';} ?>>Silencio Adm. Negativo</option>
						      </select>
							</label>										</td>
						</tr>
						<tr>
                         
							<td colspan="4" align="right"><button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
              &nbsp;
			   <?php // ordenamiento
                  if($_GET['campo']==""){ $campo="Fresgistro"; }Else{ $campo=$_GET['campo']; }
                  if($_GET['orden']==""){ $orden="DESC"; }Else{ $orden=$_GET['orden']; }
               ?>
							<button class="btn btn-primary" onclick="window.open('consultaTramiteTupa_xls.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&nSilencio=<?=$_GET[nSilencio]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('consultaTramiteTupa_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&nSilencio=<?=$_GET[nSilencio]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
							&nbsp;
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
$tampag = 30;
$reg1 = ($pag-1) * $tampag;

//invertir orden
if($orden=="ASC") $cambio="DESC";
if($orden=="DESC") $cambio="ASC";
	
    if($_GET['fDesde']!='' && $_GET['fHasta']!=''){
    $fDesde=date("Ymd", strtotime($_GET['fDesde']));
	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
	} // + 1 dia
	/*
	$sql=" SELECT iCodTramite, cCodificacion,fFecRegistro,fFecFinalizado,Tra_M_Tupa.iCodOficina,cNomOFicina,cNomTupa,nSilencio,nDias,DATEDIFF(DAY, fFecRegistro, GETDATE()) as Proceso ,DATEDIFF(DAY, fFecRegistro, fFecFinalizado) as Proceso2 ,nFlgEstado ";
    $sql.=" FROM Tra_M_Tramite LEFT OUTER JOIN Tra_M_Tupa ON Tra_M_Tramite.iCodTupa=Tra_M_Tupa.iCodTupa ";
    $sql.=" LEFT OUTER JOIN Tra_M_Oficinas ON Tra_M_Oficinas.iCodOficina=Tra_M_Tupa.iCodOficina ";
    $sql.=" WHERE Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.iCodTupa IS NOT NULL ";
    if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	$sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
    }
    if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	$sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
    }
    if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
    $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
    }
	if($_GET[nFlgEstado]!=""){
	$sql.=" AND nFlgEstado='$_GET[nFlgEstado]' ";
	}
	if($_GET[nSilencio]!=""){
	$sql.=" AND nSilencio='$_GET[nSilencio]'";
	}	
	if($_GET['cCodificacion']!=""){
     $sql.="AND Tra_M_Tramite.cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
    }
	if($_GET['cNroDocumento']!=""){
     $sql.="AND Tra_M_Tramite.cNroDocumento='$_GET['cNroDocumento']' ";
    }
	if($_GET['cAsunto']!=""){
     $sql.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
    }
	if($_GET['iCodTupa']!=""){
     $sql.="AND Tra_M_Tramite.iCodTupa='$_GET['iCodTupa']' ";
    }
	if($_GET['iCodOficina']!=""){
    $sql.="AND Tra_M_Tupa.iCodOficina='$_GET['iCodOficina']' ";
    }
    $sql.= " ORDER BY $campo $orden ";	  
	
	*/
	
	$sql.= "SP_CONSULTA_TRAMITE_TUPA '$fDesde', '$fHasta','$_GET[nFlgEstado]','$_GET[nSilencio]','%".$_GET['cCodificacion']."%','%$_GET['cNroDocumento']%', '%".$_GET['cAsunto']."%','$_GET['iCodTupa']', '$_GET['iCodOficina']','$campo', '$orden' ";
	
	 
    $rs=sqlsrv_query($cnx,$sql);
	$total = sqlsrv_has_rows($rs);
   //echo $sql;
?>
<br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
	<td width="98" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Codificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&nSilencio=<?=$_GET[nSilencio]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>"  style=" text-decoration:<?php if($campo=="Codificacion"){ echo "underline"; }Else{ echo "none";}?>">N� Documento</a></td>
    <td width="92" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Fresgistro&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&nSilencio=<?=$_GET[nSilencio]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>"  style=" text-decoration:<?php if($campo=="Fresgistro"){ echo "underline"; }Else{ echo "none";}?>">Fecha de Registro</a></td>
	<td width="142" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=CodOficina&orden=<?=$cambio?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&nSilencio=<?=$_GET[nSilencio]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>"  style=" text-decoration:<?php if($campo=="CodOficina"){ echo "underline"; }Else{ echo "none";}?>">Oficina</a></td>
	<td width="250" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=nTupa&orden=<?=$cambio?>&cNomTupa=<?=$_GET[cNomTupa]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&nSilencio=<?=$_GET[nSilencio]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>"  style=" text-decoration:<?php if($campo=="nTupa"){ echo "underline"; }Else{ echo "none";}?>">Procedimiento TUPA</a></td>
	<td width="84" class="headCellColum">N� de D&iacute;as Programados</td>
    <td width="84" class="headCellColum">N� de D&iacute;as Ejecutados</td>
    <td width="92" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=nfEstado&orden=<?=$cambio?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&nSilencio=<?=$_GET[nSilencio]?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>"  style=" text-decoration:<?php if($campo=="nfEstado"){ echo "underline"; }Else{ echo "none";}?>">Estado</a></td>
    <td width="83" class="headCellColum">Resultado</td>
	</tr>
<?
 if($_GET['fDesde']=="" && $_GET['fHasta']=="" && $_GET[nFlgEstado]=="" && $_GET[nSilencio]=="" && $_GET['cCodificacion']=="" && $_GET['cNroDocumento']=="" && $_GET['cAsunto']=="" && $_GET['iCodTupa']=="" && $_GET['cCodTipoDoc']=="" && $_GET['cNombre']=="" && $_GET['iCodOficina']==""){
/*$sqltu=" SELECT Tra_M_Tramite.iCodTupa  FROM Tra_M_Tramite ";
$sqltu.=" WHERE Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.iCodTupa IS NOT NULL ";*/

$sqltu= "SP_CONSULTA_TRAMITE_TUPA_CONTEO";
$rstu=sqlsrv_query($cnx,$sqltu);
$numrows=sqlsrv_has_rows($rstu);
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
    	<a href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramite]?>"  rel="lyteframe" title="Detalle del Documento" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
      </td>
    <td valign="top" align="center"><?
    	echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
      echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
      ?></td>
    <td valign="top" align="left"><?=$Rs[cNomOFicina]?></td> 
    <td valign="top" align="left"><?=$Rs[cNomTupa]?></td>
    <td valign="top" align="center"><?=$Rs[nDias]?> </td>
    <td valign="top" align="center"><? 
	              if($Rs[nFlgEstado]==1){
					echo $Rs[Proceso];
					}
				  else if($Rs[nFlgEstado]==2){
					echo $Rs[Proceso];
					}
				  else if($Rs[nFlgEstado]==3){
					echo $Rs[Proceso2];
					} 
				   
				   ?></td>
    <td valign="top" align="center">
	            <?php
    if($Rs[nFlgEstado]==1){
					echo "<div style='color:#005E2F'>PENDIENTE</div>";
					}
					else if($Rs[nFlgEstado]==2){
					echo "<div style='color:#0154AF'>EN PROCESO</div>";
					}
					else if($Rs[nFlgEstado]==3){
					echo "FINALIZADO";
					echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($Rs[fFecFinalizado]))."</div>";
                    echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($Rs[fFecFinalizado]))."</div>";
					}
				?>
    </td>
    <td valign="top" align="center">
	            <?php if($Rs[Proceso] > $Rs[nDias] and $Rs[nSilencio]==1 and $Rs[nFlgEstado]!=3){ 
	                echo "<div style='color:#950000'>VENCIDO</div>"; 
					echo "<div style='color:#950000'>SAP</div>";
				  }
					else if($Rs[Proceso] > $Rs[nDias] and $Rs[nSilencio]==0 and $Rs[nFlgEstado]!=3){
				    echo "<div style='color:#950000'>VENCIDO</div>"; 
				    echo "<div style='color:#950000'>SAN</div>"; 
				  }
					else if($Rs[Proceso2] > $Rs[nDias] and $Rs[nSilencio]==1  and $Rs[nFlgEstado]==3){ 
	                echo "<div style='color:#950000'>VENCIDO</div>"; 
					echo "<div style='color:#950000'>SAP</div>";
				  }
				    else if($Rs[Proceso2] > $Rs[nDias] and $Rs[nSilencio]==0  and $Rs[nFlgEstado]==3){
					echo "<div style='color:#950000'>VENCIDO</div>"; 
				    echo "<div style='color:#950000'>SAN</div>"; 
				  }
				?></td>
 </tr>
  
<?
}
}
?> 
<tr>
		<td colspan="8" align="center">
      <?php echo paginar($pag, $total, $tampag, "consultaTramiteTupa.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&nFlgEstado=".$_GET[nFlgEstado]."&nSilencio=".$_GET[nSilencio]."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cNroDocumento=".$_GET['cNroDocumento']."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&iCodTupa=".$_GET['iCodTupa']."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cNombre=".$_GET['cNombre']."&iCodOficina=".$_GET['iCodOficina']."&pag=");?>
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