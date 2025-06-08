<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$sqlDerivo="SELECT iCodOficina FROM Tra_M_Grupo_Oficina_Detalle WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' ";
$rs=sqlsrv_query($cnx,$sqlDerivo);
$numOfi=sqlsrv_has_rows($rs);
if($numOfi>0){
$derivar="1";
}

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
<!--

function activaOpciones1(){
	for (j=0;j<document.formulario.elements.length;j++){
		if(document.formulario.elements[j].type == "radio"){
			document.formulario.elements[j].checked=0;
		}
	}	
	document.formulario.OpAceptar.disabled=false;
	document.formulario.OpEnviar.disabled=true;
	document.formulario.OpDelegar.disabled=true;
	document.formulario.OpFinalizar.disabled=true;
	document.formulario.OpAvance.disabled=true;
	document.formulario.OpAceptar.filters.alpha.opacity=100;
	document.formulario.OpEnviar.filters.alpha.opacity=50;
	document.formulario.OpDelegar.filters.alpha.opacity=50;
	document.formulario.OpFinalizar.filters.alpha.opacity=50;
	document.formulario.OpAvance.filters.alpha.opacity=50;
return false;
}

function activaOpciones2(argument){
	if (argument.checked==true) {
		document.getElementById("OpDelegar").setAttribute( "onClick", "activaDelegar("+argument.parentNode.parentNode.children[3].children[1].value+")" );
	}

	for (i=0;i<document.formulario.elements.length;i++){
		if(document.formulario.elements[i].type == "checkbox"){
			document.formulario.elements[i].checked=0;
		}
	}
	document.formulario.OpAceptar.disabled=true;
	document.formulario.OpEnviar.disabled=false;
	document.formulario.OpDelegar.disabled=false;
	document.formulario.OpFinalizar.disabled=false;
	document.formulario.OpAvance.disabled=false;
	<?php if($derivar=="1"){ ?>
	document.formulario.OpDerivo.disabled=false;
	<?php } ?>
	document.formulario.OpAceptar.filters.alpha.opacity=50;
	document.formulario.OpEnviar.filters.alpha.opacity=100;
	document.formulario.OpDelegar.filters.alpha.opacity=100;
	document.formulario.OpFinalizar.filters.alpha.opacity=100;
	document.formulario.OpAvance.filters.alpha.opacity=100;	
	<?php if($derivar=="1"){ ?>
	document.formulario.OpDerivo.filters.alpha.opacity=100;
	<?php } ?>
	return false;

}

function activaOpciones3(){
	for (i=0;i<document.formulario.elements.length;i++){
		if(document.formulario.elements[i].type == "checkbox"){
			document.formulario.elements[i].checked=0;
		}
	}
	document.formulario.OpAceptar.disabled=true;
	document.formulario.OpEnviar.disabled=true;
	document.formulario.OpDelegar.disabled=true;
	document.formulario.OpFinalizar.disabled=false;
	document.formulario.OpAvance.disabled=true;
	document.formulario.OpDerivo.disabled=true;
	document.formulario.OpAceptar.filters.alpha.opacity=50;
	document.formulario.OpEnviar.filters.alpha.opacity=50;
	document.formulario.OpDelegar.filters.alpha.opacity=50;
	document.formulario.OpFinalizar.filters.alpha.opacity=100;
	document.formulario.OpAvance.filters.alpha.opacity=50;
	document.formulario.OpDerivo.filters.alpha.opacity=50;	
return false;
}

function activaAceptar()
{
  document.formulario.opcion.value=1;
  document.formulario.method="POST";
  document.formulario.action="profesionalData.php";
  document.formulario.submit();
}

function activaEnviar()
{
  document.formulario.OpAceptar.value="";
  document.formulario.OpEnviar.value="";
  document.formulario.OpDelegar.value="";
  document.formulario.OpFinalizar.value="";
  document.formulario.OpAvance.value="";
  document.formulario.opcion.value=1;
  document.formulario.method="GET";
  document.formulario.action="profesionalEnviar.php";
  document.formulario.submit();
}

function activaDelegar(argument)
{
  document.formulario.action="profesionalResponder.php";
  document.formulario.opcion.value=1;
  document.formulario.iCodOficina1.value=argument;
  document.formulario.submit();
}

function activaFinalizar()
{
  document.formulario.action="profesionalFinalizar.php";
  document.formulario.submit();
}

function activaAvance()
{
  document.formulario.action="profesionalAvance.php";
  document.formulario.submit();
}

function activaDerivo()
{
  document.formulario.action="profesionalDerivo.php";
  document.formulario.submit();
}

function Buscar()
{
  document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsulta.submit();
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

<div class="AreaTitulo">documentos pendientes - Profesional</div>




							<form name="frmConsulta" method="GET">
							
						<tr>
							<td width="110" >Documentos:</td>
							<td width="390" align="left"><input type="checkbox" name="Entrada" value="1" <?php if($_GET['Entrada']==1) echo "checked"?> onclick="activaEntrada();">Entrada  &nbsp;&nbsp;&nbsp;<input type="checkbox" name="Interno" value="1" <?php if($_GET['Interno']==1) echo "checked"?> onclick="activaInterno();">Internos</td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td><input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>
							</td>
						</tr>
						<tr>
							<td width="110" >N&ordm; Documento:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Asunto:</td>
							<td align="left"><input type="txt" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="65" class="FormPropertReg form-control">
							</td>
						</tr>
						<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left">
									<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
						$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
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
									</select>
							</td>
							<td width="110" ></td>
							<td align="left" class="CellFormRegOnly">
									
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
						<tr>
							<td colspan="4" align="right">
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
              <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
              &nbsp;
							<button class="btn btn-primary" onclick="window.open('profesionalExcel.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficina=<?=$_SESSION['iCodOficinaLogin']?>&iCodTrabajador=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
              &nbsp; 
						<? /*	<button class="btn btn-primary" onclick="window.open('profesionalPendientesPdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>*/  ?>
							</td>
						</tr>
							</form>

				

					<form name="formulario">
					<input type="hidden" name="opcion" value="">
					<input type="hidden" name="iCodOficina1" id="iCodOficina1" value="">
				<tr>
				<td align="left" valign="bottom">
						<button class="FormBotonAccion btn btn-primary" name="OpAceptar" disabled onclick="activaAceptar();" title="Aceptar Documento" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_aceptar.png" alt="Aceptar Documento" width="17" height="17" border="0">Aceptar</button>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpEnviar" disabled onclick="activaEnviar();" title="Enviar a Profesional de la Oficina" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_delegar.png" alt="Enviar a Profesional de la Oficina" width="17" height="17" border="0">Enviar </button>
                        <?php if($derivar=="1"){ ?>
                        <span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpDerivo" disabled onclick="activaDerivo();" title="Derivar a Oficina del Grupo" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_derivar.png" alt="Derivar a Oficina del Grupo" width="19" height="19" border="0">Derivar </button>
                        <?php } ?>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpDelegar"  id="OpDelegar" disabled onclick="activaDelegar();" title="Responder al Jefe" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/envio.png" alt="Responder al Jefe" width="20" height="20" border="0">Responder </button>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpFinalizar" disabled onclick="activaFinalizar();" title="Finalizar Documento" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_finalizar.png"  alt="Finalizar Documento" width="17" height="17" border="0">Finalizar </button>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpAvance" disabled onclick="activaAvance();" title="Agregar un Avance" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_avance.png" alt="Agregar un Avance" width="17" height="17" border="0">Avance </button>
                        
				</td>
				</tr>
				</table>
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
	   $campo="Tra_M_Tramite_Movimientos.iCodMovimiento";
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
	 
				$fDesde=date("Ymd", strtotime(substr($_GET['fDesde'], 0, -6)));
			 	$fHasta=date("Y-m-d",strtotime(substr($_GET['fHasta'], 0, -6)));

				function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    				  $date_r = getdate(strtotime($date));
    				  $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    				  return $date_result;
				}
				$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
				
				$sqlTra="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos ";
        $sqlTra.="WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
       if($_GET['Entrada']==1 AND $_GET['Interno']==""){
        $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=1 ";
       }
       if($_GET['Entrada']=="" AND $_GET['Interno']==1){
        $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=2 ";
       }
       if($_GET['Entrada']==1 AND $_GET['Interno']==1){
        $sqlTra.="AND (Tra_M_Tramite.nFlgTipoDoc=1 OR Tra_M_Tramite.nFlgTipoDoc=2) ";
       }
       if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
       	$sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar>'$fDesde' ";
       }
       if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
       	$sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar<='$fHasta' ";
       }
       if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
       	$sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar BETWEEN '$fDesde' AND '$fHasta' ";
       }
       if($_GET['cCodificacion']!=""){
        $sqlTra.="AND Tra_M_Tramite.cCodificacion like '%".$_GET['cCodificacion']."%' ";
       }
       if($_GET['cAsunto']!=""){
        $sqlTra.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
       }
       if($_GET['cCodTipoDoc']!=""){
        $sqlTra.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
       }
        $sqlTra.="AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) ";
        $sqlTra.="OR (Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') ) ";
		$sqlTra.=" And Tra_M_Tramite_Movimientos.nEstadoMovimiento!=2 ";
		$sqlTra.=" And Tra_M_Tramite.nFlgEnvio=1 ";
        $sqlTra.="AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
        $sqlTra.="ORDER BY Tra_M_Tramite_Movimientos.iCodMovimiento DESC";
        
				$rsTra=sqlsrv_query($cnx,$sqlTra);
        //
        $total = sqlsrv_has_rows($rsTra);
			//	echo $sqlTra;
 ?>		<br>	

				<tr>
				<td class="headColumnas">N&ordm; Documento</td>
				<td class="headColumnas">Tipo Documento / Razón Social</td>
				<td class="headColumnas">Asunto / Procedimiento TUPA</td>
        <td class="headColumnas" width="80">Origen</td>
				<td class="headColumnas" width="130">Delegado por  / Obs. Delegar</td>
				<td class="headColumnas" width="80">Fecha/Estado</td>
				<td class="headColumnas">Recepción</td>
				<td class="headColumnas">Opción</td>
				</tr>
 <? 
   $numrows=sqlsrv_has_rows($rsTra);
   if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
   }else{
        echo "TOTAL DE REGISTROS : ".$numrows;            
///////////////////////////////////////////////////////
       for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
       sqlsrv_fetch_array($rsTra, $i);
       $RsTra=sqlsrv_fetch_array($rsTra);
///////////////////////////////////////////////////////		               
     //   while ($RsTra=sqlsrv_fetch_array($rsTra))
        		if ($color == "#DDEDFF"){
			  			$color = "#F9F9F9";
	    			}else{
			  			$color = "#DDEDFF";
	    			}
	    			if ($color == ""){
			  			$color = "#F9F9F9";
	    			}
        ?>
        <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'">
        <td width="92" valign="top">
        	<?
            	if($RsTra['nFlgTipoDoc']==1){?>
    			<a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramite']?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$RsTra['cCodificacion']?></a>
    		<?php}
		    	if($RsTra['nFlgTipoDoc']==2){
			 			echo "INTERNO";}
               if($RsTra['nFlgTipoDoc']==3){
			 			echo "SALIDA";}         
					if($RsTra['nFlgTipoDoc']==4){ 
		  	?>
    			<a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramiteRel']?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$RsTra['cCodificacion']?></a>
    		<?php}?>
    		<?
    		echo "<div style=color:#727272>".date("d-m-Y", strtotime($RsTra['fFecRegistro']))."</div>";
      	echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($RsTra['fFecRegistro']))."</div>";
      	if($RsTra['cFlgTipoMovimiento']==6){
      		echo "<div style=color:#800000;font-size:10px;text-align:center>COPIA</div>";
      	}
      	?>
        </td>
        <td width="210" align="left" valign="top">
        	<?
        	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'";
					$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
					$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
					echo "<div>".$RsTipDoc['cDescTipoDoc']."</div>";
					if($RsTra['nFlgTipoDoc']==1 ){
		  			echo "<div style=color:#808080;text-transform:uppercase>".$RsTra['cNroDocumento']."</div>";
		  		}else if($RsTra['nFlgTipoDoc']==2 ){
						echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
						echo $RsTra['cCodificacion'];
						echo "</a>";
		  		}else if($RsTra['nFlgTipoDoc']==3 ){
						echo "<br>";	
						echo "<a style=\"color:#0067CE\" href=\"registroSalidaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
						echo $RsTra['cCodificacion'];
            echo "</a>";
    			}	
          $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
          $RsRem=sqlsrv_fetch_array($rsRem);
          echo $RsRem["cNombre"];
					sqlsrv_free_stmt($rsRem);
        	?>
        </td>
        <td width="240" align="left" valign="top"><?=$RsTra['cAsunto']?></td>
        <td align="center" valign="top">
        	<?
        	$sqlOfi="SP_OFICINA_LISTA_AR '$RsTra[iCodOficinaOrigen]'";
          $rsOfi=sqlsrv_query($cnx,$sqlOfi);
          $RsOfi=sqlsrv_fetch_array($rsOfi);
          echo "<a href=\"javascript:;\" title=\"".trim($RsOfi[cNomOficina])."\">".$RsOfi[cSiglaOficina]."</a>";
          sqlsrv_free_stmt($rsOfi);
				?>
				<input type="hidden" name="origen1" id="origen1" value="<?php echo $RsTra[iCodOficinaOrigen]; ?>">
        </td>
        <td width="60" align="left" valign="top"> 
        		<?
				$rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_SESSION[JEFE]'");
          $RsResp=sqlsrv_fetch_array($rsResp);
          echo "<div align=left>".$RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"]."</div>";
					sqlsrv_free_stmt($rsResp);
			
        		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsTra[iCodIndicacionDelegado]'";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              $RsIndic=sqlsrv_fetch_array($rsIndic);
                echo "<div style=color:#808080;font-size:10px align=left>".$RsIndic["cIndicacion"]."</div>";
              sqlsrv_free_stmt($rsIndic);
        		?>
        	<div align="left"><?=$RsTra[cObservacionesDelegado]?></div>
        	
        </td>
        <td width="100" valign="top">
        	<?

  				if($RsTra['cFlgTipoMovimiento']==2){
  					echo "<div style=color:#773C00>Enviado</div>";
  				}
        	echo "<div style=color:#0154AF><b>";
        	switch ($RsTra['nEstadoMovimiento']){
  				case 1:
  					echo "En proceso";
  				break;
  				case 2:
  					echo "Derivado";
  				break;
  				case 3:
  					echo "Delegado";
  				break;
  				case 4:
  					echo "Finalizado";
  				break;
  				}
  				echo "</b></div>";

  				if($RsTra['iCodTrabajadorDelegado']!=""){
						echo "<div style=color:#0154AF>".date("d-m-Y",strtotime($RsTra[fFecDelegado]))."</div>";
						echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra[fFecDelegado]))."</div>";
					}
        	?>
        </td>        
        <td width="80" align="left" valign="top"> 
        	<? 
		if($RsTra['cFlgTipoMovimiento']!=2){	
		  if($RsTra['nEstadoMovimiento']==3){	
        	if($RsTra['fFecDelegadoRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>aceptado</div>";
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime(substr($RsTra['fFecDelegadoRecepcion'], 0, -6)))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime(substr($RsTra['fFecDelegadoRecepcion'], 0, -6))) ."</div>";
        	}
		  }else{
		  	if($RsTra['cFlgTipoMovimiento']==6){
				if($RsTra['fFecDelegadoRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        		}Else{
        			echo "<div style=color:#0154AF>aceptado</div>";
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecDelegadoRecepcion']))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra['fFecDelegadoRecepcion']))."</div>";
        	}
			}
			else {
		    	if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        		}Else{
        			echo "<div style=color:#0154AF>aceptado</div>";
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecRecepcion']))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra['fFecRecepcion']))."</div>";
				}	
			}
		  }
		}else {
			if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>aceptado</div>";
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecRecepcion']))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra['fFecRecepcion']))."</div>";
			}	
		}	
        	?>
        </td>
        <td width="60" valign="top">
        	<? 
			if($RsTra['cFlgTipoMovimiento']!=2){	
			if($RsTra['nEstadoMovimiento']==3){		
			if($RsTra['fFecDelegadoRecepcion']==""){?>
        			<input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
        	<?php }else{
        			if($RsTra['cFlgTipoMovimiento']!=6){ ?>
        			<input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2(this)">
        			<?php } else{?>
							<input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
       		<?  }
       		}
			}else {
				if($RsTra['cFlgTipoMovimiento']==6){
					if($RsTra['fFecDelegadoRecepcion']==""){?>
				     <input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
				<?php }else {?>
					 <input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
       		<?    }
				}
			else{	
				if($RsTra['fFecRecepcion']==""){ ?>
				<input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
			<?	} else { ?>
			<input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2(this)">
			<?	}
			}
			}
			}else{
			if($RsTra['nEstadoMovimiento']==3){		
			if($RsTra['fFecDelegadoRecepcion']==""){?>
        			<input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
        	<?php }else{
        			if($RsTra['cFlgTipoMovimiento']!=6){ ?>
        			<input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2(this)">
        			<?php } else{?>
							<input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
       		<?  }
       		}
			}else {
				if($RsTra['fFecRecepcion']==""){ ?>
                <input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
				<?php } else { ?>
				<input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2(this)">
				<?php }
				}
			}			
			?>
        </td>
      	</tr>
        <?
        }
		}
        sqlsrv_free_stmt($rsTra);
				?>
						</form>		
				</table>
     <?php echo paginar($pag, $total, $tampag, "profesionalPendientes.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&pag="); ?>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
 <?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>