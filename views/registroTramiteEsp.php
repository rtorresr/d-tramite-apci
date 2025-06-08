<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroTramiteEsp.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Modificar el Registro de un Documento y sus Movimientos
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   Larry Ortiz       24/01/2011    Creación del programa.
 
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
function ConfirmarBorrado()
{
 if (confirm("Esta seguro de eliminar el registro?")){
  return true; 
 }else{ 
  return false; 
 }
}

function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}

function Seleccione()
{
  document.frmTramiteEsp.action='registroTramiteEdit.php'; 
  document.frmTramiteEsp.submit();
}
//--></script>
<meta http-equiv="Content-Type" content="text/html; charset=UFT-8" />
<style type="text/css">
body {
	background-image: url(images/background.jpg);
}
</style>
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

<div class="AreaTitulo">Editar Documento</div>
<table class="table">
 <tr>

	<table cellpadding="0" cellspacing="0" border="0" width="950" align="center"><tr><td><?php // ini table por fieldset ?>

						<table cellpadding="3" cellspacing="3" border="0" width="950">
							<form name="frmConsultaEntrada" method="GET" action="registroTramiteEsp.php">
						<tr>
							<td width="108" >N&ordm; Documento:</td>
							<td width="346" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="40" class="FormPropertReg form-control">
                                                        </td>
							<td width="140" >Desde:</td>
							<td align="left">

									<td><input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:105px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:105px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
						</tr>
                       
                       <tr>
							<td width="108" >Tipo Doc:</td>
							<td width="346" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:260px" >
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
							<td width="140" >Tipo de Tramite:</td>
							<td width="317" align="left"><select name="nFlgTipoDoc" class="FormPropertReg form-control" style="width:260px" >
									<option value="">Seleccione:</option>
									<option value="1">Entrada</option>
                                    <option value="2">Internos</option>
                                    <option value="3">Salidas</option>
                                    <option value="4">Anexos</option>
									</select>
                                                        </td>
						</tr>
                        
                        <tr>
							<td colspan="4"  align="center">

							    <td ><button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							      &nbsp;
							      <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
						        </td>
							    </tr></table>						    </td>
							</tr> 

							</form>



 
<?
  $fDesde=date("Ymd H:i", strtotime($_GET['fDesde']));
  $fHasta=date("Ymd H:i", strtotime($_GET['fHasta']));
	
	/*
	$fHasta=date("Y-m-d H:i", strtotime($_GET['fHasta']));
	
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd H:i", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
	}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
	*/
	
	
	 ?> 
    <input type="hidden" name="iCodTramite" value="<?=trim($RsCod[cCodificacion])?>">
   
 <?
	// consulta de los datos relacionados del documento
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
$tampag = 10;
$reg1 = ($pag-1) * $tampag;

	 $sql=" SELECT  TOP 100 Tra_M_Tramite.nFlgTipoDoc as tipo,  *  ";
	 $sql.=" FROM  Tra_M_Tramite LEFT JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ";
	 $sql.=" WHERE  Tra_M_Tramite.iCodTramite > 0 ";
	
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
   if($_GET['nFlgTipoDoc']!=""){
     $sql.="AND Tra_M_Tramite.nFlgTipoDoc LIKE '%$_GET['nFlgTipoDoc']%' ";
  }
   if($_GET['cCodTipoDoc']!=""){
     $sql.="AND Tra_M_Tramite.cCodTipoDoc LIKE '%$_GET['cCodTipoDoc']%' ";
  }
     $sql.=" ORDER BY Tra_M_Tramite.iCodTramite DESC";	   
     $rs=sqlsrv_query($cnx,$sql);
	 $numrows=sqlsrv_has_rows($rs);
	  $total = sqlsrv_has_rows($rs);
	  //  echo $sql;
 ?>
     <br>
   <br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
	<td width="98" class="headCellColum">Tipo de TRÁMITE</td>
	<td width="98" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Codificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Codificacion"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; TRÁMITE</a></td>
	<td width="142" class="headCellColum"><a  href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo Documento</a></td>
	 
	<td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto / TUPA</a></td>
  <td width="83" class="headCellColum">Opciones</td>
	</tr>
<?

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
 	 <td valign="top" align="left">
    	<?
			//echo $Rs[nFlgTipoDoc];
    		if($Rs[tipo]==1){
				echo "ENTRADA";
			}
			else if($Rs[tipo]==2){
				echo "INTERNO";
			}
			else if($Rs[tipo]==3){
				echo "SALIDA";
			}
			else if($Rs[tipo]==4){
				echo "ANEXO";
			}
    	?>
    </td>
    <td valign="top" align="center">
    	<?php if($Rs[tipo]!=4){?>
    			<a href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramite]?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
    	<?php }else{?>
    			<a  href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramiteRel]?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
    	<?php }?>
    	<?
    	echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
        echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
	  	 $sqlTra="SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
			$rsTra=sqlsrv_query($cnx,$sqlTra);
			$RsTra=sqlsrv_fetch_array($rsTra);
			echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
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
    <td valign="top" align="left">
    	<?
    		echo $Rs['cDescTipoDoc'];
			echo "<div style=color:#808080;text-transform:uppercase>".$Rs['cNroDocumento']."</div>";
    	?>
    </td>
   
    <? /* <td><?php echo $Rs[cRepresentante];?></td> */?>
   
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
		if($numReq>0){
      	echo "\n<div style=color:#FF0000>Faltan ".$numReq." Requisitos por cumplir</div>";
		}			  
      }
    	?>
    </td>
    <td >
    <form name="frmTramiteEsp" method="POST" action="buscarTramiteEdit.php">
       	 <input type="hidden" name="iCodTramite" value="<?=trim($Rs[iCodTramite])?>">
         <input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
    	<button class="btn btn-primary" type="submit" onMouseOver="this.style.cursor='hand'"> <b>Seleccione</b>  </button>
        </form>
    	<a href="registroDataEdicion.php?id=<?=$Rs[iCodTramite]?>&opcion=26" onClick='return ConfirmarBorrado();'><img src="images/icon_del.png" width="16" height="16" alt="Eliminar Grupo de Destinos" border="0"></a> 
       
     
    </td>
</tr>
  
<?
}
}
?> 
		
        <tr>
		<td colspan="6" align="center">
         <?php echo paginar($pag, $total, $tampag, "registroTramiteEsp.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&nFlgTipoDoc=".$_GET['nFlgTipoDoc']."&pag=");
			//P�gina 1 <a href="javascript:;">2</a> <a href="javascript:;">3</a> <a href="javascript:;">4</a> <a href="javascript:;">5</a>
		 ?>	
		</td>
		</tr>
</table>
  

   
</td>
 </tr>
   </table>
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
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>