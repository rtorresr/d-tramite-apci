<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Proceso para lectura de pendientes profesional
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

function activaOpciones2(){
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
	document.formulario.OpAceptar.filters.alpha.opacity=50;
	document.formulario.OpEnviar.filters.alpha.opacity=100;
	document.formulario.OpDelegar.filters.alpha.opacity=100;
	document.formulario.OpFinalizar.filters.alpha.opacity=100;
	document.formulario.OpAvance.filters.alpha.opacity=100;	
return false;
}


function activaAceptar()
{
  document.formulario.opcion.value=10;
  document.formulario.method="POST";
  document.formulario.action="pendientesData.php";
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
  document.formulario.action="pendientesProfesionalEnviar.php";
  document.formulario.submit();
}

function activaDelegar()
{
  document.formulario.action="pendientesProfesionalResponder.php";
  document.formulario.submit();
}

function activaFinalizar()
{
  document.formulario.action="pendientesProfesionalFinalizar.php";
  document.formulario.submit();
}

function activaAvance()
{
  document.formulario.action="pendientesProfesionalAvance.php";
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
							<button class="btn btn-primary" onclick="window.open('pendientesProfesionalPdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Limpiar</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
							</td>
						</tr>
							</form>

				

					<form name="formulario">
					<input type="hidden" name="opcion" value="">
				<tr>
				<td align="left" valign="bottom">
						<button class="FormBotonAccion btn btn-primary" name="OpAceptar" disabled onclick="activaAceptar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_aceptar.png" width="17" height="17" border="0">Aceptar</button>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpEnviar" disabled onclick="activaEnviar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_derivar.png" width="17" height="17" border="0">Enviar </button>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpDelegar" disabled onclick="activaDelegar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_delegar.png" width="17" height="17" border="0">Responder </button>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpFinalizar" disabled onclick="activaFinalizar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_finalizar.png" width="17" height="17" border="0">Finalizar </button>
						<span style="font-size:18px">&#124;&nbsp;</span>
						<button class="FormBotonAccion btn btn-primary" name="OpAvance" disabled onclick="activaAvance();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_avance.png" width="17" height="17" border="0">Avance </button>
				</td>
				</tr>
				</table>
				

				<tr>
				<td class="headColumnas">N&ordm; Documento</td>
				<td class="headColumnas">Nombre / Razón Social</td>
				<td class="headColumnas">Asunto / Procedimiento TUPA</td>
				<td class="headColumnas">Derivado</td>
				<td class="headColumnas">Recepción</td>
				<td class="headColumnas">Estado</td>
				<td class="headColumnas">Opción</td>
				</tr>
				
				<?
				$fDesde=date("Ymd", strtotime($_GET['fDesde']));
			 	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));

				function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    				  $date_r = getdate(strtotime($date));
    				  $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    				  return $date_result;
				}
				$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
				
				$sqlTra="SELECT * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos ";
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
        $sqlTra.="AND Tra_M_Tramite.cCodificacion='".$_GET['cCodificacion']."' ";
       }
       if($_GET['cAsunto']!=""){
        $sqlTra.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
       }
       if($_GET['cCodTipoDoc']!=""){
        $sqlTra.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
       }
        $sqlTra.="AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' AND Tra_M_Tramite_Movimientos.nFlgEnviado=0) ";
        $sqlTra.="OR Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."' AND Tra_M_Tramite_Movimientos.nFlgEnviado=0) ";
        $sqlTra.= "ORDER BY Tra_M_Tramite.iCodTramite DESC";
        $rsTra=sqlsrv_query($cnx,$sqlTra);
        //echo $sqlTra;
        while ($RsTra=sqlsrv_fetch_array($rsTra)){
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
        <td width="92" valign="top"><?=$RsTra['cCodificacion']?></td>
        <td width="210" align="left" valign="top">
        	<?
          $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
          $RsRem=sqlsrv_fetch_array($rsRem);
          echo $RsRem["cNombre"];
					sqlsrv_free_stmt($rsRem);
        	?>
        </td>
        <td width="300" align="left" valign="top"><?=$RsTra['cAsunto']?></td>
        <td width="80" align="left" valign="top">
        	<?php if($RsTra['cFlgTipoMovimiento']==1){?>
        	<div><?=date("d-m-Y", strtotime($RsTra['fFecDerivar']));?></div>
        	<div style="font-size:10px"><?=date("G:i", strtotime($RsTra['fFecDerivar']));?></div>
        	<?php}?>
        	<?php if($RsTra['cFlgTipoMovimiento']==2){?>
        	<div><?=date("d-m-Y", strtotime($RsTra[fFecEnviar]));?></div>
        	<div style="font-size:10px"><?=date("G:i", strtotime($RsTra[fFecEnviar]));?></div>
        	<?php}?>
        </td>
        <td width="80" align="left" valign="top">
        	<?
        	if($RsTra['fFecDelegadoRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecDelegadoRecepcion']))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra['fFecDelegadoRecepcion']))."</div>";
        	}
        	?>
        </td>
        <td width="150" valign="top">
        	<?
        	echo "<div style=color:#0154AF><b>";
        	switch ($RsTra['nEstadoMovimiento']){
  				case 1:
  					echo "Pendiente";
  				break;
  				case 2:
  					echo "Derivado";
  				break;
  				case 3:
  					echo "Delegado";
  				break;
  				case 4:
  					echo "Respondido";
  				break;
  				case 5:
  					echo "Finalizado";
  				break;
  				}
  				echo "</b></div>";
  				if($RsTra['cFlgTipoMovimiento']==2){
  					echo "<div style=color:#773C00>Enviado</div>";
  				}
  				if($RsTra['iCodTrabajadorDelegado']!=""){
						echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra[fFecDelegado]))."</div>";
						echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra[fFecDelegado]))."</div>";
					}
        	?>
        </td>
        <td width="60" valign="top">
        	<?php if($RsTra['fFecDelegadoRecepcion']==""){?>
        			<input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
        	<?php } else{?>
							<input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2();">
       		<?php}?>
        	
        	<?
        	/*$rsDig=sqlsrv_query($cnx,"SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='".$RsTra['iCodTramite']."' ORDER BY iCodDigital DESC");
          if(sqlsrv_has_rows($rsDig)>0){
          	$RsDig=sqlsrv_fetch_array($rsDig);
        		echo "<div><a href=\"download.php?direccion=../cAlmacenArchivos/&file=".$RsDig["cNombreNuevo"]."\"><img src=\"images/icon_download.png\" width=18 height=18 border=0 alt=\"Descargar Adjunto\"></a></div>";
        	}*/
        	?>
        </td>
      	</tr>
        <?
        }
        sqlsrv_free_stmt($rsTra);
				?>
						</form>		
				</table>
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