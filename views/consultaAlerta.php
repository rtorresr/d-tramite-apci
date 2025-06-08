<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaAlerta.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta de los Documentos por Vencer
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

<div class="AreaTitulo">Plazos</div>



							<form name="frmConsultaEntrada" method="GET" action="consultaAlerta.php">
						<tr>
							<td width="110" >N&ordm; Tr&aacute;mite:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td><input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:105px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:105px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
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
                          	<select name="iCodOficinaDes" class="FormPropertReg form-control" style="width:360px" onchange="releer();" />
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
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgEntrada=1 ";
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
							<td width="110" >Nro Documento:</td>
							<td width="390" align="left"><input type="txt" name="cNroDocumento" value="<?=$_GET['cNroDocumento']?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Proc. Tupa:</td>
							<td align="left" class="CellFormRegOnly">
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
					</select>										</td>
						</tr>
						<tr>
							<td height="10" ></td>
							<td height="10" align="left"></td>
              <td height="10" >Responsable:</td>
              <td height="10" align="left">
                       <select name="iCodTrabajadoResponsable" style="width:340px;" class="FormPropertReg form-control">
							<option value="">Seleccione:</option>
							<?
							$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina=$_GET[iCodOficinaDes] ";
                            $sqlTrb.= "ORDER BY cNombresTrabajador ASC";
                           $rsTrb=sqlsrv_query($cnx,$sqlTrb);
              while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	if($RsTrb[iCodTrabajador]==$_GET[iCodTrabajadoResponsable]){
              		$selecTrab="selected";
              	}Else{
              		$selecTrab="";
              	}
                echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
              }
              sqlsrv_free_stmt($rsTrb);
							?>
						  </select>
              	</td>
						</tr>
						<tr>
                         
							<td colspan="4" align="right"><button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
              �				<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
              �										</td>
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
$tampag = 15;
$reg1 = ($pag-1) * $tampag;

// ordenamiento
if($_GET['campo']==""){
	$campo="Fecha";
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


  $fDesde=date("Ymd H:i", strtotime($_GET['fDesde']));
  $fHasta=date("Ymd H:i", strtotime($_GET['fHasta']));

?>
<br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
	<td width="98" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Codificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>"  style=" text-decoration:<?php if($campo=="Codificacion"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; Tr&aacute;mite</a></td>
	<td width="142" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo Documento</a></td>
	<td width="84" class="headCellColum">N� de Dias Programados</td>
    <td width="84" class="headCellColum">N� de Dias Ejecutados</td>
    <td width="92" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Estado&orden=<?=$cambio?>&nFlgEstado=<?=$_GET[nFlgEstado]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>"  style=" text-decoration:<?php if($campo=="Estado"){ echo "underline"; }Else{ echo "none";}?>">Estado</a></td>
     <td width="92" class="headCellColum">Resultado</td>
	<td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&iCodTupa=<?=$_GET['iCodTupa']?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto / TUPA</a></td>
	</tr>
<? 
	 /* $sql=" SELECT top 500 cCodificacion, cCodTipoDoc,cNroDocumento,cAsunto,Tra_M_Tramite.nFlgEstado,iCodTupa,fFecRegistro,fFecFinalizar,Tra_M_Tramite_Movimientos.iCodOficinaDerivar,cNomOFicina,nTiempoRespuesta,DATEDIFF(DAY, fFecRegistro, GETDATE()) as Proceso ,DATEDIFF(DAY, fFecRegistro, fFecFinalizado) as Proceso2 ,nFlgEstado 
 FROM Tra_M_Tramite 
 LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite
 LEFT OUTER JOIN Tra_M_Oficinas ON Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Movimientos.iCodOficinaDerivar 
 WHERE Tra_M_Tramite.nFlgTipoDoc=1 and nTiempoRespuesta!=0 ";
  
  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	$sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  }
  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	$sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  }
  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  //$sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' and Tra_M_Tramite.fFecRegistro<'$fHasta' ";
  }
	if($_GET['cCodificacion']!=""){
     $sql.="AND Tra_M_Tramite.cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
  }
	if($_GET['cNroDocumento']!=""){
     $sql.="AND cNroDocumento LIKE '%$_GET['cNroDocumento']%' ";
  }
  if($_GET['cAsunto']!=""){
     $sql.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
  }
	if($_GET['iCodTupa']!=""){
     $sql.="AND Tra_M_Tramite.iCodTupa='$_GET['iCodTupa']' ";
  }
	if($_GET['cCodTipoDoc']!=""){
        $sql.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
  }
 	if($_GET[iCodOficinaOri]!=""){
   $sql.="AND Tra_M_Tramite_Movimientos.iCodOficinaOrigen='$_GET[iCodOficinaOri]' ";
  }
  if($_GET[iCodOficinaDes]!=""){
   $sql.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar='$_GET[iCodOficinaDes]' ";
  }
  if($_GET[iCodTrabajadoResponsable]!=""){
   $sql.="AND Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='$_GET[iCodTrabajadoResponsable]' ";
  }
	 $sql.= " ORDER BY $campo $orden";	 */  
	 $sql.= " SP_CONSULTA_ALERTAS '$_GET['fDesde']','$_GET['fHasta']','%".$_GET['cCodificacion']."%','%$_GET['cNroDocumento']%', '%".$_GET['cAsunto']."%', '$_GET['iCodTupa']', '".$_GET['cCodTipoDoc']."', '$_GET[iCodOficinaOri]', '$_GET[iCodOficinaDes]','$_GET[iCodTrabajadoResponsable]','$campo', '$orden' ";
   $rs=sqlsrv_query($cnx,$sql);
   ////////
   $total = sqlsrv_has_rows($rs);
   //echo $sql;
   
 if($_GET['cCodificacion']=="" && $_GET['fDesde']=="" && $_GET['fHasta']=="" && $_GET['cNroDocumento']=="" && $_GET[iCodOficinaOri]=="" && $_GET[iCodOficinaDes]=="" && $_GET['cCodTipoDoc']=="" && $_GET['cAsunto']=="" && $_GET[cReferencia]=="" && $_GET['iCodTupa']==""  && $_GET[iCodTrabajadoResponsable]==""){
  $sqlale=" SP_CONSULTA_ALERTAS_LISTA ";
$rsale=sqlsrv_query($cnx,$sqlale);
$numrows=sqlsrv_has_rows($rsale);
 }
else{
$numrows=sqlsrv_has_rows($rs);
}
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
        echo "TOTAL DE REGISTROS : ".$numrows;
///////////////////////////////////////////////////////
for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
sqlsrv_fetch_array($rs, $i);
$Rs=sqlsrv_fetch_array($rs);
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
    	echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
      echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
      ?>    </td>
    <td valign="middle" align="left">
    	<?
    	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$Rs[cCodTipoDoc]'";
			$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			echo $RsTipDoc['cDescTipoDoc'];
			echo "<div style=color:#808080;text-transform:uppercase>".$Rs['cNroDocumento']."</div>";
    	?>    </td>
    <td valign="top" align="center"><?=$Rs[nTiempoRespuesta]?> </td>
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
	            <?php if($Rs[Proceso] > $Rs[nTiempoRespuesta]  and $Rs[nFlgEstado]!=3){ 
	                echo "<div style='color:#950000'>VENCIDO</div>"; 
					
				  }
					else if($Rs[Proceso] < $Rs[nTiempoRespuesta] and $Rs[nFlgEstado]!=3){
				    echo "<div style='color:#950000'></div>"; 
				    
				  }
					else if($Rs[Proceso2] > $Rs[nTiempoRespuesta]  and $Rs[nFlgEstado]==3){ 
	                echo "<div style='color:#950000'>VENCIDO</div>"; 
					
				  }
				    else if($Rs[Proceso2] < $Rs[nTiempoRespuesta] and $Rs[nFlgEstado]==3){
					echo "<div style='color:#950000'></div>"; 
				
				  }
				?></td>
    <td valign="middle" align="left">
    	<?
    	echo $Rs['cAsunto'];
    	if($Rs['iCodTupa']!=""){
    		$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$Rs['iCodTupa']."'";
      	$rsTup=sqlsrv_query($cnx,$sqlTup);
      	$RsTup=sqlsrv_fetch_array($rsTup);
		?>
        <br>
      	<a href="registroDetalleFlujoTupa.php?iCodTupa=<?=$Rs['iCodTupa']?>" rel="lyteframe" title="Detalles Flujo Tupa" rev="width: 880px; height: 300px; scrolling: auto; border:no"><?=$RsTup["cNomTupa"]?></a>
		<?    $sqlReq= " SELECT * FROM Tra_M_Tupa_Requisitos WHERE iCodTupa=(SELECT iCodTupa FROM Tra_M_Tramite WHERE iCodTramite='$Rs[iCodTramite]') AND iCodTupaRequisito NOT IN 
			          (SELECT iCodTupaRequisito FROM Tra_M_Tramite_Requisitos WHERE iCodTramite='$Rs[iCodTramite]' ) ";
  		$rsReq=sqlsrv_query($cnx,$sqlReq);
      	$numReq=sqlsrv_has_rows($rsReq);
		if($numReq!=0){
      	echo "\n<div style=color:#FF0000>Faltan ".$numReq." Requisitos por cumplir</div>";
		}	
     }
    	?>    </td>
</tr>
  
<?
}
}
?> 
		<tr>
		<td colspan="7" align="center">
         <?php echo paginar($pag, $total, $tampag, "consultaAlerta.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&iCodOficinaOri=".$_GET[iCodOficinaOri]."&iCodOficinaDes=".(isset($_GET['iCodOficinaDes'])?$_GET['iCodOficinaDes']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&iCodTupa=".$_GET['iCodTupa']."&iCodTrabajadoResponsable=".$_GET[iCodTrabajadoResponsable]."&pag=");
			//P�gina 1 <a href="javascript:;">2</a> <a href="javascript:;">3</a> <a href="javascript:;">4</a> <a href="javascript:;">5</a>
		 ?>		</td>
		</tr>
</table>
    </td>
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