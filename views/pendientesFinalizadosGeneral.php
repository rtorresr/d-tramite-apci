<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Lista de pendientes parar el punto de control.
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
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
	document.formulario.OpDerivar.disabled=true;
	document.formulario.OpDelegar.disabled=true;
	document.formulario.OpFinalizar.disabled=true;
	document.formulario.OpAvance.disabled=true;
	document.formulario.OpAceptar.filters.alpha.opacity=100;
	document.formulario.OpDerivar.filters.alpha.opacity=50;
	document.formulario.OpDelegar.filters.alpha.opacity=50;
	document.formulario.OpFinalizar.filters.alpha.opacity=50;
	document.formulario.OpAvance.filters.alpha.opacity=50;
return false;
}

function activaOpciones2(){
	for (i=0;i<document.formulario.elements.length;i++){
		if(document.formulario.elements[i].type == "checkbox"){
			document.formulario.elements[i].checked=0;
		}
	}
	document.formulario.OpAceptar.disabled=true;
	document.formulario.OpDerivar.disabled=false;
	document.formulario.OpDelegar.disabled=false;
	document.formulario.OpFinalizar.disabled=false;
	document.formulario.OpAvance.disabled=false;
	document.formulario.OpAceptar.filters.alpha.opacity=50;
	document.formulario.OpDerivar.filters.alpha.opacity=100;
	document.formulario.OpDelegar.filters.alpha.opacity=100;
	document.formulario.OpFinalizar.filters.alpha.opacity=100;
	document.formulario.OpAvance.filters.alpha.opacity=100;
return false;
}

function activaOpciones3(){
	for (i=0;i<document.formulario.elements.length;i++){
		if(document.formulario.elements[i].type == "checkbox"){
			document.formulario.elements[i].checked=0;
		}
	}
	document.formulario.OpAceptar.disabled=true;
	document.formulario.OpDerivar.disabled=true;
	document.formulario.OpDelegar.disabled=true;
	document.formulario.OpFinalizar.disabled=false;
	document.formulario.OpAvance.disabled=true;
	document.formulario.OpAceptar.filters.alpha.opacity=50;
	document.formulario.OpDerivar.filters.alpha.opacity=50;
	document.formulario.OpDelegar.filters.alpha.opacity=50;
	document.formulario.OpFinalizar.filters.alpha.opacity=100;
	document.formulario.OpAvance.filters.alpha.opacity=50;
return false;
}

function activaAceptar()
{
  document.formulario.opcion.value=1;
  document.formulario.method="POST";
  document.formulario.action="pendientesData.php";
  document.formulario.submit();
}

function activaDerivar()
{
  document.formulario.OpAceptar.value="";
  document.formulario.OpDerivar.value="";
  document.formulario.OpDelegar.value="";
  document.formulario.OpFinalizar.value="";
  document.formulario.OpAvance.value="";
  document.formulario.opcion.value=1;
  document.formulario.method="GET";
  document.formulario.action="pendientesControlDerivar.php";
  document.formulario.submit();
}

function activaDelegar()
{
  document.formulario.action="pendientesControlDelegar.php";
  document.formulario.submit();
}

function activaFinalizar()
{
  document.formulario.action="pendientesControlFinalizar.php";
  document.formulario.submit();
}

function activaAvance()
{
  document.formulario.action="pendientesControlAvance.php";
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

<div class="AreaTitulo">documentos finalizados Generales</div>	




							<form name="frmConsulta" method="GET">
                	<tr>
							<td width="110" >Documentos:</td>
							<td width="390" align="left"><input type="checkbox" name="Entrada" value="1" <?php if($_GET['Entrada']==1) echo "checked"?>  />
							  Entrada  &nbsp;&nbsp;&nbsp;
						  <input type="checkbox" name="Interno" value="1" <?php if($_GET['Interno']==1) echo "checked"?> >Internos  &nbsp;&nbsp;&nbsp;</td>
						  <td width="110" >Desde:</td>
							<td align="left">

									<td><input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
						</tr>
						<tr>
							<td width="110" >N&ordm; Documento:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Asunto:</td>
							<td align="left"><input type="txt" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="65" class="FormPropertReg form-control">							</td>
						</tr>
						<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left">
									<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
									include_once("../conexion/conexion.php");
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
									</select>							</td>
							<td width="110" >Finalizo:</td>
							<td align="left" class="CellFormRegOnly">
									<select name="iCodTrabajadorFinalizar" style="width:192px;" class="FormPropertReg form-control">
									<option value="">Seleccione:</option>
									<?
									$sqlTrb="SELECT * FROM Tra_M_Trabajadores ";
              		$sqlTrb.="WHERE iCodOficina = ".$_GET['iCodOficina'];
              		$sqlTrb .= "ORDER BY cApellidosTrabajador ASC";
              		$rsTrb=sqlsrv_query($cnx,$sqlTrb);
              		while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              			if($RsTrb[iCodTrabajador]==$_GET[iCodTrabajadorFinalizar]){
              				$selecTrab="selected";
              			}Else{
              				$selecTrab="";
              			}
              		  echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cApellidosTrabajador"]." ".$RsTrb["cNombresTrabajador"]."</option>";
              		}
              		sqlsrv_free_stmt($rsTrb);
									?>
									</select>
					  </td>
						</tr>
						<tr>
						  <td height="10" >Tema:</td>
						  <td  align="left"><select name="iCodTema" style="width:192px;" class="FormPropertReg form-control">
						    <option value="">Seleccione:</option>
						    <?
									$sqlTem="SELECT * FROM Tra_M_Temas WHERE  iCodOficina = '".$_SESSION['iCodOficinaLogin']."' ";
              			           	$sqlTem .= "ORDER BY cDesTema ASC";
              		$rsTem=sqlsrv_query($cnx,$sqlTem);
              		while ($RsTem=sqlsrv_fetch_array($rsTem)){
              			if($RsTem['iCodTema']==$_GET['iCodTema']){
              				$selecTem="selected";
              			}Else{
              				$selecTem="";
              			}
              		  echo "<option value=\"".$RsTem["iCodTema"]."\" ".$selecTem.">".$RsTem["cDesTema"]." ".$RsTem["cNombresTrabajador"]."</option>";
              		}
              		sqlsrv_free_stmt($rsTem);
									?>
						    </select></td>
						  <td height="10" >&nbsp;</td>
						  <td>&nbsp;</td>
						  </tr>
						<tr>
							<td height="10" >Oficina:</td>
                            <td  align="left">
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
            </select></td>
                        <td height="10" >&nbsp;</td>
                        <td>&nbsp;</td>            
						</tr>
						<tr>
							<td colspan="4" align="right">
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;&nbsp;
                            <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>�
                            &nbsp;&nbsp;
							<button class="btn btn-primary" onclick="window.open('pendientesFinalizadosGeneralExcel.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorFinalizar=<?=((isset($_GET['iCodTrabajadorFinalizar']))?$_GET['iCodTrabajadorFinalizar']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
													�
														</td>
						</tr>
							</form>

				
						
				<?
				if($_GET['fDesde']!=""){ $fDesde=date("Y-m-d", strtotime($_GET['fDesde'])); }
			    if($_GET['fHasta']!=""){
				$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));

				function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    				  $date_r = getdate(strtotime($date));
    				  $date_result = date("Y-m-d", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    				  return $date_result;
				}
				$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
				}
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

			$sqlTra= " SP_BANDEJA_FINALIZADOS_REPORTE 'op1', '".$_GET['Entrada']."','".$_GET['Interno']."','$fDesde','$fHasta','".$_GET['cCodificacion']."', ";
			$sqlTra.= " '".$_GET['cAsunto']."','$_GET['iCodOficina']', '".$_GET['cCodTipoDoc']."', '".$_GET['iCodTema']."', '$_GET[iCodTrabajadorFinalizar]' ";
        $rsTra=sqlsrv_query($cnx,$sqlTra);
		
        $total = sqlsrv_has_rows($rsTra);
		//echo $sqlTra;
	   ?>	

				<tr>
        <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=op2&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op2"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; TRÁMITE</a></td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=op3&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op3"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
				<td class="headColumnas">Nombre / Razón Social</td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=op4&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op4"){ echo "underline"; }Else{ echo "none";}?>">Asunto / Procedimiento TUPA</a></td>
                <td class="headColumnas">Derivado</td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=op5&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op5.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">Recepción</a></td>
                <td class="headColumnas">Respuesta del Delegado:</td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=op1&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op1"){ echo "underline"; }Else{ echo "none";}?>">Finalizado:</a></td>
				
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
       // while ($RsTra=sqlsrv_fetch_array($rsTra)){
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
   <td width="95" valign="top" align="left">
          <?php if($RsTra['nFlgTipoDoc']==1){?>
    			<a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramite']?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$RsTra['cCodificacion']?></a>
    	<?php }
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
      if($RsTra['cFlgTipoMovimiento']==4){
		 echo "<div style=color:#FF0000;font-size:12px>Copia</div>";	
		}
	  ?>
      
        </td>
         <td width="95" valign="top" align="left">
		 <?
		  if($RsTra['nFlgTipoDoc']==1){
          $rsTDoc=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'");
          $RsTDoc=sqlsrv_fetch_array($rsTDoc);
          echo $RsTDoc["cDescTipoDoc"];
					sqlsrv_free_stmt($rsTDoc);
          echo "<div style=color:#808080;text-transform:uppercase>".$RsTra['cNroDocumento']."</div>";
		  }
		  else {
		  $rsTDoc=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'");
          $RsTDoc=sqlsrv_fetch_array($rsTDoc);
          echo $RsTDoc["cDescTipoDoc"];
		  sqlsrv_free_stmt($rsTDoc);
		  echo "<br>";
		  echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
			echo $RsTra['cCodificacion'];
			echo "</a>";
		  }
		  ?></td>
        <td width="188" align="left" valign="top">
        	<?
          $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
          $RsRem=sqlsrv_fetch_array($rsRem);
          echo $RsRem["cNombre"];
					sqlsrv_free_stmt($rsRem);
        	?>
        </td>
        <td align="left" valign="top"><?=$RsTra['cAsunto']?></td>
        <td width="80" align="left" valign="top">
        	<div><?=date("d-m-Y", strtotime($RsTra['fFecDerivar']));?></div>
        	<div style="font-size:10px"><?=date("G:i", strtotime($RsTra['fFecDerivar']));?></div>
        </td>
        <td width="80" align="left" valign="top">
					<?
        	if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecRecepcion']))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra['fFecRecepcion']))."</div>";
        	}
        	?>
        </td>
       <td>
       <?
       		if($RsTra['iCodTrabajadorDelegado']!=""){
  		    $rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_GET['iCodTrabajadorDelegado']."'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	echo "<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>";
						sqlsrv_free_stmt($rsDelg);
						echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra[fFecDelegado]))."</div>";
						echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra[fFecDelegado]))."</div>";
					}
					if($RsTra[iCodTrabajadorResponder]!=""){ //respondido
						echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsTra['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 480px; height: 270px; scrolling: auto; border:no\">RESPONDIDO</a>";
					}
        	?>
       </td>
        <td valign="top" align="left">
          
           <?=$RsTra[cObservacionesFinalizar]?> 
           <br>
        	<?
          $rsFina=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTra[iCodTrabajadorFinalizar]'");
          $RsFina=sqlsrv_fetch_array($rsFina);
          echo "<div style=color:#0154AF>".$RsFina["cApellidosTrabajador"]." ".$RsFina["cNombresTrabajador"]."</div>";
					sqlsrv_free_stmt($rsFina);
          echo "<div style=color:#727272>".date("d-m-Y", strtotime($RsTra[fFecFinalizar]))."</div>";
          echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($RsTra[fFecFinalizar]))."</div>";
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
                <?php echo paginar($pag, $total, $tampag, "pendientesControl.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&iCodTrabajadorDelegado=".(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&Anexo=".(isset($_GET['Anexo'])?$_GET['Anexo']:'')."&Aceptado=".(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')."&SAceptado=".(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')."&campo=".$campo."&orden=".$orden."&pag="); ?>


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