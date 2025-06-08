<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Pantalla formulario para finalizar 1 pendiente
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

<div class="AreaTitulo">documentos Finalizados</div>	




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
							<td colspan="4" align="right">
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
							</td>
						</tr>
							</form>

				
				<br>

				<tr>
                <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; Tramite</a></td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">Nombre / Razón Social</a></td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">Asunto / Procedimiento TUPA</a></td>
                <td class="headColumnas">Derivado</td>
				<td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">Recepción</a></td>
				<td class="headColumnas">Finalizado:</td>
				<td class="headColumnas">Revertir:</td>
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
				
				include_once("../conexion/conexion.php");
				
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
	$campo="Tra_M_Tramite.iCodTramite";
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
        $sqlTra.="AND Tra_M_Tramite.cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
       }
       if($_GET['cAsunto']!=""){
        $sqlTra.="AND Tra_M_Tramite_Movimientos.cAsuntoDerivar LIKE '%".$_GET['cAsunto']."%' ";
       }
        //$sqlTra.="AND Tra_M_Tramite_Movimientos.iCodOficinaOrigen!='".$_SESSION['iCodOficinaLogin']."' ";
        $sqlTra.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' ";
        $sqlTra.="AND Tra_M_Tramite_Movimientos.nEstadoMovimiento=4 ";
        
        $sqlTra.= "ORDER BY Tra_M_Tramite_Movimientos.fFecFinalizar DESC";
        //echo $sqlTra;
        $rsTra=sqlsrv_query($cnx,$sqlTra);
		//
        $total = sqlsrv_has_rows($rsTra);
		$numrows=sqlsrv_has_rows($rsTra);
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
         echo "TOTAL DE REGISTROS : ".$numrows;
//////////////////////////////////////////////////////
        for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
        sqlsrv_fetch_array($rsTra, $i);
        $RsTra=sqlsrv_fetch_array($rsTra);
///////////////////////////////////////////////////////
      //while ($RsTra=sqlsrv_fetch_array($rsTra)){
        		if ($color == "#DDEDFF"){
			  			$color = "#F9F9F9";
	    			}else{
			  			$color = "#DDEDFF";
	    			}
	    			if ($color == ""){
			  			$color = "#F9F9F9";
	    			}
        ?>
        <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF';" OnMouseOut="this.style.backgroundColor='<?=$color?>'">
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
      ?>
        </td>
         <td width="95" valign="top" align="left">
		 <?
		  if($RsTra['nFlgTipoDoc']==1){
          $rsTDoc=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDocDerivar]'");
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
        	<div style="font-size:10px"><?=date("h:i A", strtotime($RsTra['fFecDerivar']));?></div>
        </td>
        <td width="80" align="left" valign="top">
					<?
        	if($RsTra['fFecRecepcion']==""){
        			echo "<div style=color:#ff0000>sin aceptar</div>";
        	}Else{
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecRecepcion']))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("h:i A", strtotime($RsTra['fFecRecepcion']))."</div>";
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
          echo "<div style=color:#727272;font-size:10px>".date("h:i A", strtotime($RsTra[fFecFinalizar]))."</div>";
            ?>
 				</td>
 				<td>
 					<a href="pendientesData.php?iCodMovimiento=<?=$RsTra['iCodMovimiento']?>&opcion=11"><img src="images/icon_retornar.png" width="16" height="16" border="0"></a>
 				</td>
      	</tr>
        <?
		}
        }
        sqlsrv_free_stmt($rsTra);
				?>
						</form>		
				</table>
		<?php echo paginar($pag, $total, $tampag, "pendientesFinalizados.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&pag="); ?>

        	
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

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