<?php
session_start();
	if($_SESSION['CODIGO_TRABAJADOR']!=""){
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
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getState(departamentoId) {		
		
		var strURL="iu_provincia.php?departamento="+departamentoId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('statediv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getCity(departamentoId,provinciaId) {		
		var strURL="iu_distrito.php?departamento="+departamentoId+"&provincia="+provinciaId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('citydiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}







function funcion(bol, frm, chkbox) { 
for (var i=0;i < frmConsultaTramiteCargo.elements[chkbox].length;i++) { // Dentro de todos los elementos, seleccionamos lo que tengan el mismo nombre que el seleccionado
elemento = frmConsultaTramiteCargo.elements[chkbox][i]; // Ahora es bidimensional
elemento.checked = (bol) ? true : false;
} 
}

function Buscar()
{
  document.frmConsultaTramiteCargoOficina.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaTramiteCargoOficina.submit();
}

function releer(){
  document.frmConsultaTramiteCargoOficina.action="<?=$_SERVER['PHP_SELF']?>#area";
  document.frmConsultaTramiteCargoOficina.submit();
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

<div class="AreaTitulo">Consulta >> Control de Cargos (L)</div>




							<form name="frmConsultaTramiteCargoOficina" method="POST" action="consultaTramiteCargoOficina.php"  >
						<tr>
							<td width="94" >N&ordm; Documento:</td>
							<td width="376" align="left"><input type="txt" name="cCodificacion" value="<?=$_REQUEST[cCodificacion]?>" size="28" class="FormPropertReg form-control"></td>
							<td width="96" >Desde:</td>
							<td colspan="5" align="left">

									<td>
    <?
	if(trim($_REQUEST[fDesde])==""){$fecini = date("01-m-Y");} else { $fecini = $_REQUEST[fDesde]; }
	if(trim($_REQUEST[fHasta])==""){$fecfin = date("d-m-Y");} else { $fecfin = $_REQUEST[fHasta]; }
	?>                             
                                    <input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
						</tr>
						<tr>
							<td width="94" >Tipo Documento:</td>
							<td width="376" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgSalida=1";
          				            $sqlTipo.="ORDER BY cDescTipoDoc ASC";
          				            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          				while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          					if($RsTipo["cCodTipoDoc"]==$_REQUEST[cCodTipoDoc]){
          						$selecTipo="selected";
          					}Else{
          						$selecTipo="";
          					}
          				echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          				}
          				sqlsrv_free_stmt($rsTipo);
									?>
									</select></td>
							<td width="96" >Raz&oacute;n Social:</td>
							<td colspan="5" align="left"><input type="txt" name="cNombre" value="<?=$_REQUEST['cNombre']?>" size="65" class="FormPropertReg form-control">							</td>
						</tr>
						<tr>
						  <td >Oficina Origen:</td>
						  <td align="left"><select name="iCodOficina" class="FormPropertReg form-control" style="width:360px" />
     	            <option value="">Seleccione:</option>
	              <? 
	                 $sqlOfi="SP_OFICINA_LISTA_COMBO "; 
                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                 while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodOficina"]==$_REQUEST['iCodOficina']){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?>
            </select></td>
							<td width="96" >Direcci&oacute;n:</td>
							<td colspan="5" align="left" class="CellFormRegOnly"><input type="txt" name="cDireccion" value="<?=$_REQUEST[cDireccion]?>" size="65" class="FormPropertReg form-control">						  </td>
						</tr>
						<tr>
						  <td width="94" >Departamento:</td>
						  <td width="376" align="left"><?   
                             $sqlDep="select * from Tra_U_Departamento order by cCodDepartamento "; 
                             $rsDep=sqlsrv_query($cnx,$sqlDep);
                        ?>
						    <select name="cCodDepartamento" onchange="releer();" style="width:236px">
						      <option value="">Seleccione:</option>
						      <?   while ($RsDep=sqlsrv_fetch_array($rsDep)){
			                if($RsDep["cCodDepartamento"]==$_REQUEST[cCodDepartamento]){
          		            $selecDep="selected";
          	                }else{
          		            $selecDep="";
          	                 }
                            echo "<option value=".$RsDep["cCodDepartamento"]." ".$selecDep.">".$RsDep[cNomDepartamento]."</option>";
                             }
                             sqlsrv_free_stmt($rsDep);
                        ?>
					        </select></td>
					        <td  >Estado:</td>
						  <td width="189" align="left" >
                          <select name="cFlgEstado" class="FormPropertReg form-control" style="width:180px">
							<option value="" selected>Seleccione:</option>
                            <option value="03" <?php if($_REQUEST[cFlgEstado]=="03") echo "selected" ?>>Pendiente</option>
                            <option value="01" <?php if($_REQUEST[cFlgEstado]=="01") echo "selected" ?>>Notificado</option>
                            <option value="02" <?php if($_REQUEST[cFlgEstado]=="02") echo "selected" ?>>Devuelto</option>
						  </select></td>
						  <!-- <td  >Orden de Servicio:</td>
						  <td colspan="5" align="left" ><span class="CellFormRegOnly">
						    <input type="txt" name="cOrdenServicio" value="<?=$_REQUEST[cOrdenServicio]?>" size="65" class="FormPropertReg form-control" />
						  </span></td> -->
						  </tr>
							<tr>
							  <td  >Provincia:</td>
							  <td  align="left"><?   
          $sqlPro="SELECT cCodDepartamento,cCodProvincia,cNomProvincia FROM Tra_U_Provincia WHERE cCodDepartamento='$_POST[cCodDepartamento]'  order by cNomProvincia ASC "; 
                             $rsPro=sqlsrv_query($cnx,$sqlPro);
                        ?>
							    <select  name="cCodProvincia" <?php if($_POST[cCodDepartamento]=="") echo "disabled"?> style="width:236px" onchange="releer();">
							      <option value="">Seleccione:</option>
							      <?   while ($RsPro=sqlsrv_fetch_array($rsPro)){
			                if($RsPro["cCodProvincia"]==$_REQUEST[cCodProvincia]){
          		            $selecPro="selected";
          	                }else{
          		            $selecPro="";
          	                 }
                            echo "<option value=".$RsPro["cCodProvincia"]." ".$selecPro.">".$RsPro[cNomProvincia]."</option>";
                             }
                             sqlsrv_free_stmt($rsDep);
                        ?>
						        </select></td>
						 <!-- <td  >Estado:</td>
						  <td width="189" align="left" >
                          <select name="cFlgEstado" class="FormPropertReg form-control" style="width:180px">
							<option value="" selected>Seleccione:</option>
                            <option value="03" <?php if($_REQUEST[cFlgEstado]=="03") echo "selected" ?>>Pendiente</option>
                            <option value="01" <?php if($_REQUEST[cFlgEstado]=="01") echo "selected" ?>>Notificado</option>
                            <option value="02" <?php if($_REQUEST[cFlgEstado]=="02") echo "selected" ?>>Devuelto</option>
						  </select></td> -->
						  <td  >Nacional</td>
              <td align="left">
                <input type="checkbox" name="cFlgNacional" value="1" <?php if($_REQUEST['cFlgNacional'] == 1) echo "checked"?> />
              </td>
              <td  >Internacional</td>
              <td align="left">
                <input type="checkbox" name="cFlgInternacional" value="1" <?php if($_REQUEST['cFlgInternacional'] == 1) echo "checked"?> />
              </td>
						  
						  <td width="38"  >&nbsp;</td>
						  <td width="28" align="left" >&nbsp;</td>
						  <td width="59"  >&nbsp;</td>
						  <td width="45" align="left" >&nbsp;</td>
						  </tr>
						<tr>
						  <td >Distrito:</td>
						  <td align="left"><?      $sqlDis="SELECT cCodDepartamento,cCodProvincia,cCodDistrito,cNomDistrito FROM Tra_U_Distrito WHERE cCodProvincia='$_POST[cCodProvincia]' AND cCodDepartamento='$_POST[cCodDepartamento]' order by cNomDistrito ASC "; 
		                 $rsDis=sqlsrv_query($cnx,$sqlDis);
		?>
						    <select  name="cCodDistrito" <?php if($_REQUEST[cCodProvincia]=="") echo "disabled"?> style="width:236px">
						      <option value="">Seleccione:</option>
						      <?   while ($RsDis=sqlsrv_fetch_array($rsDis)){
			                if($RsDis["cCodDistrito"]==$_REQUEST[cCodDistrito]){
          		            $selecDis="selected";
          	                }else{
          		            $selecDis="";
          	                 }
                            echo "<option value=".$RsDis["cCodDistrito"]." ".$selecDis.">".$RsDis[cNomDistrito]."</option>";
                             }
                             sqlsrv_free_stmt($rsDep);
                        ?>
					        </select></td>
              <td  >Local</td>
              <td align="left">
                <input type="checkbox" name="cFlgLocal" value="1" <?php if($_REQUEST['cFlgLocal'] == 1) echo "checked"?> />
              </td>
              <td >Urgente:</td>
              <td align="left">
                <input type="checkbox" name="cFlgUrgente" value="1" <?php if($_REQUEST['cFlgUrgente'] == 1) echo "checked"?> />
                  <label for="checkbox"></label>
              </td>
                            <!-- <td  >Local</td>
                            <td align="left" ><input type="checkbox" name="cFlgLocal" value="1" <?php if($_REQUEST[cFlgLocal]==1) echo "checked"?> /></td>
                            <td  >Nacional</td>
                            <td align="left" ><input type="checkbox" name="cFlgNacional" value="1" <?php if($_REQUEST[cFlgNacional]==1) echo "checked"?> /></td> -->
						</tr>
						<tr>
                         
							<td colspan="2" align="left">
                                                      </td>
                          <td colspan="6" align="right">
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							�
                           <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
                     �<?php // ordenamiento
                        if($_GET['campo']==""){ $campo="Fecha"; }Else{$campo=$_GET['campo'];}
                        if($_GET['orden']==""){ $orden="DESC"; }Else{ $orden=$_GET['orden']; } 
					  ?>
							<button class="btn btn-primary" onclick="window.open('consultaTramiteCargoOficina_xls.php?fDesde=<?=$fecini?>&fHasta=<?=$fecfin?>&cCodificacion=<?=$_REQUEST[cCodificacion]?>&cCodTipoDoc=<?=$_REQUEST[cCodTipoDoc]?>&cFlgUrgente=<?=$_REQUEST[cFlgUrgente]?>&iCodTrabajadorEnvio=<?=$_REQUEST[iCodTrabajadorEnvio]?>&cNombre=<?=$_REQUEST['cNombre']?>&cDireccion=<?=$_REQUEST[cDireccion]?>&cOrdenServicio=<?=$_REQUEST[cOrdenServicio]?>&ChxfRespuesta=<?=$_REQUEST[ChxfRespuesta]?>&cFlgLocal=<?=$_REQUEST[cFlgLocal]?>&cFlgNacional=<?=$_REQUEST[cFlgNacional]?>&cFlgInternacional=<?=$_REQUEST[cFlgInternacional]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&cFlgEstado=<?=$_REQUEST[cFlgEstado]?>&cCodDepartamento=<?=$_REQUEST[cCodDepartamento]?>&cCodProvincia=<?=$_REQUEST[cCodProvincia]?>&cCodDistrito=<?=$_REQUEST[cCodDistrito]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							�
							<!-- <button class="btn btn-primary" onclick="window.open('consultaTramiteCargoOficina_pdf.php?fDesde=<?=$_REQUEST[fDesde]?>&fHasta=<?=$_REQUEST[fHasta]?>&cCodificacion=<?=$_REQUEST[cCodificacion]?>&cCodTipoDoc=<?=$_REQUEST[cCodTipoDoc]?>&cFlgUrgente=<?=$_REQUEST[cFlgUrgente]?>&cFlgLocal=<?=$_REQUEST[cFlgLocal]?>&cFlgNacional=<?=$_REQUEST[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_REQUEST[iCodTrabajadorEnvio]?>&ChxfRespuesta=<?=$_REQUEST[ChxfRespuesta]?>&cNombre=<?=$_REQUEST['cNombre']?>&cDireccion=<?=$_REQUEST[cDireccion]?>&cOrdenServicio=<?=$_REQUEST[cOrdenServicio]?>&cFlgEstado=<?=$_REQUEST[cFlgEstado]?>&cCodDepartamento=<?=$_REQUEST[cCodDepartamento]?>&cCodProvincia=<?=$_REQUEST[cCodProvincia]?>&cCodDistrito=<?=$_REQUEST[cCodDistrito]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button> -->
							</td>
						</tr>
							
						</table>
			</fieldset>




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
$tampag = 40;
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
		if($_REQUEST[ChxfRespuesta]=="" && $_REQUEST[fEntrega]==""){			
		$fecfin=dateadd($fecfin,1,0,0,0,0,0); // + 1 dia
		}else{
			$fecfin=dateadd($fecfin,0,0,0,0,0,0); // + 1 dia
		}
	}
	
   	$sql.= " SP_CONSULTA_TRAMITE_CARGO '$fecini', '$fecfin','$_REQUEST[ChxfRespuesta]','$_REQUEST[fEntrega]', '%$_REQUEST[cCodificacion]%', '%$_REQUEST['cNombre']%','%$_REQUEST[cDireccion]%', '$_REQUEST[cCodTipoDoc]', '$_REQUEST[cOrdenServicio]', '$_REQUEST[cFlgUrgente]', '$_REQUEST[iCodTrabajadorEnvio]', '$_REQUEST[cFlgLocal]','$_REQUEST[cFlgNacional]','$_REQUEST[cFlgInternacional]','$_REQUEST['iCodOficina']','$_REQUEST[cFlgEstado]','$_REQUEST[cCodDepartamento]','$_REQUEST[cCodProvincia]','$_REQUEST[cCodDistrito]','$campo','$orden'";
   	//echo $sql; 
    $rs = sqlsrv_query($cnx,$sql);
		$total = sqlsrv_has_rows($rs);
?>
<form name="frmCargo" method="GET" action="consultaTramiteCargoOficina.php"  >
<br>
<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
   <td width="98" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Fecha&orden=<?=$cambio?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Fecha"){ echo "underline"; }Else{ echo "none";}?>">Fecha</a></td>
    <td width="98" class="headCellColum">Oficina Origen</td>
	<td width="98" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Documento</a></td>
	<td width="142" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Nombre&orden=<?=$cambio?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Nombre"){ echo "underline"; }Else{ echo "none";}?>">Destinatario</a></td>
    <td width="176" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Direccion&orden=<?=$cambio?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Direccion"){ echo "underline"; }Else{ echo "none";}?>">Dirección</a></td>

	<td width="124" class="headCellColum">
		<a href="<?=$_SERVER['PHP_SELF']?>?campo=Trabajador&orden=<?=$cambio?>&cNombresTrabajador=<?=$_GET[cNombresTrabajador]?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&iCodOficina=<?=$_GET['iCodOficina']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"
			style=" text-decoration:<?php if($campo=="FechaAceptacion"){ echo "underline"; }Else{ echo "none";}?>">Fecha aceptacion</a>
	</td>

	<td width="124" class="headCellColum">
		<a href="<?=$_SERVER['PHP_SELF']?>?campo=Trabajador&orden=<?=$cambio?>&cNombresTrabajador=<?=$_GET[cNombresTrabajador]?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&iCodOficina=<?=$_GET['iCodOficina']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"
			style=" text-decoration:<?php if($campo=="Trabajador"){ echo "underline"; }Else{ echo "none";}?>">Entrega a Mensajeria</a>
	</td>
   
   <td width="143" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Estado&orden=<?=$cambio?>&cFlgEstado=<?=$_GET[cFlgEstado]?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Estado"){ echo "underline"; }Else{ echo "none";}?>">Estado Cargo</a></td>

   <td width="146" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Estado&orden=<?=$cambio?>&cFlgEstado=<?=$_GET[cFlgEstado]?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Estado"){ echo "underline"; }Else{ echo "none";}?>"></a></td>
	</tr>
<?
if( $fecini=="" && $fecfin=="" && $_REQUEST[cCodificacion]=="" && $_REQUEST[cCodTipoDoc]=="" && $_REQUEST['iCodOficina']=="" && $_REQUEST[cFlgUrgente]=="" && $_REQUEST[iCodTrabajadorEnvio]=="" && $_REQUEST['cNombre']=="" && $_REQUEST[cDireccion]=="" && $_REQUEST[cOrdenServicio]=="" && $_REQUEST[ChxfRespuesta]=="" && $_REQUEST[cFlgLocal]=="" && $_REQUEST[cFlgNacional]=="" ){
$sqlcargo=" SP_CONSULTA_TRAMITE_CARGO_LISTA  ";
$rscargo=sqlsrv_query($cnx,$sqlcargo);
$numrows = sqlsrv_has_rows($rscargo);
}else{  
	$numrows=sqlsrv_has_rows($rs);
}
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
        echo "TOTAL DE REGISTROS : ".$numrows;
for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
	for ($h=0;$h<count($_POST[iCodAuto]);$h++){
      	$iCodAuto= $_POST[iCodAuto];
		if($Rs[iCodAuto]==$iCodAuto[$h]){
   			$Checkear="checked";
		}
	}
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
 	<td valign="middle" align="left">
 		<?php 
 			echo "<div style=color:#03F>".$Rs['cDescTipoDoc']."</div>";
      echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
      echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
		 	$sqlTra = "SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores 
		 	           WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
		  $rsTra  = sqlsrv_query($cnx,$sqlTra);
		  $RsTra  = sqlsrv_fetch_array($rsTra);
   		echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
     ?> 
  </td> 
  <td valign="middle" align="left"><?php echo $Rs[cNomOficina];
	  $sqlTra="SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorSolicitado]'";
			$rsTra=sqlsrv_query($cnx,$sqlTra);
			$RsTra=sqlsrv_fetch_array($rsTra);
		echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
	  ?></td>
    <td valign="middle" align="left">
	<?
		if ($Rs['cFlgUrgente'] == 1) {
        echo "<font color='#FF0000'>URGENTE</font>"."<br>";
      }
	echo "<div>";
     	echo "<a style=\"color:#0067CE\" href=\"registroSalidaDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
    echo $Rs[cCodificacion];
    echo "</a>";
    echo "</div>";
    ?>    </td>
    <td valign="middle" align="left"><?=$Rs['cNombre']?><br>
	<? 
		echo "<div style=text-transform:uppercase;color:#06F>".$Rs[cNomRemite]."</div>";
     /*  if(trim($Rs[cNomRemite])==""){
	   echo "<div style=text-transform:uppercase;color:#06F>".$Rs[TRemitente]."</div>";
	   } */ ?>    	</td>
       <td align="left" valign="middle">
    			<?php if(trim($Rs[cDireccion])!=""){echo $Rs[cDireccion]." - ";} else {echo ""; }
				  if($Rs[cNomDepartamento]!=""){ echo $Rs[cNomDepartamento]."- ";} else{ echo "";}
				  if($Rs[cNomProvincia]!=""){ echo $Rs[cNomProvincia]." - ";} else { echo "";}
                  if($Rs[cDistrito]!=""){ echo $Rs[cNomDistrito];} else {echo "";}?>                </td>

		<td valign="middle" align="center"> ....
	  <?php
      if (isset($Rs['fecha_Acepta_Mensajeria'])) {
        echo "<div style=color:#727272>".$Rs['fecha_Acepta_Mensajeria']."</div>";
      } 
	  	//echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs[FECHA_DOCUMENTO]))."</div>";
      //echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs[FECHA_DOCUMENTO]))."</div>";
	  ?>
	  </td>

    <td valign="middle" align="left">
	<?php echo $Rs[cNombresTrabajador]." ".$Rs[cApellidosTrabajador];?>      <?php if(trim($Rs[fEntrega])!=""){
      echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs[fEntrega]))."</div>";
      echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs[fEntrega]))."</div>";
	  }
	  if($Rs[cNumGuiaServicio]!=''){
      echo "<div style=color:#03F>".$Rs[cNumGuiaServicio]."</div>";
      }
	  ?>
	  	
	  </td>
	
    <td valign="middle" align="left">
	<?php if($Rs[cFlgEstado]==1 or $Rs[cFlgEstado]==2){ 
	   if($Rs[cFlgEstado]==1){ $estado= "<div style='color:#FF0000'>NOTIFICADO.</div>";} else if($Rs[cFlgEstado]==2){$estado= "<div style='color:#FF0000'>DEVUELTO.</div>";}
	   if(trim($Rs[fRespuesta])!=""){$fecha= " El ".date("d-m-Y", strtotime($Rs[fRespuesta]));}else{ $fecha= "";}
	   if(trim($Rs[cRecibido])!=""){$recibido= ". Recibido por: ".$Rs[cRecibido];}else{ $recibido= "";}
	   if(trim($Rs[cObservaciones])!=""){$Observacion= " , con Observacion: ".$Rs[cObservaciones];}else{ $Observacion= "";}
	   $estado_cargo= "".$estado.$fecha.$recibido.$Observacion."";
	   echo $estado_cargo;
	  }
	  else{
	   if($Rs[cFlgEstado]==3){echo  "<div style='color:#FF0000'>PENDIENTE.</div>";} 
		  else{
	  echo "";
		  }
	  }
	 ?>
	 <?php 
	 	$sqlTotal = "SELECT COUNT(*) AS 'TOTAL' FROM Tra_M_Tramite_Digitales WHERE iCodTramite = '$Rs[iCodTramite]'";
    $rsTotal  = sqlsrv_query($cnx,$sqlTotal);
    $RsTotal  = sqlsrv_fetch_array($rsTotal);

    if (isset($Rs['fecha_Acepta_Mensajeria'])) {
      if ($RsTotal['TOTAL'] > 1 ) {
        // $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]'";
        //$sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite = '$Rs[iCodTramite]' ORDER BY iCodDigital DESC";
        $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales_Mensajeria WHERE iCodTramite = '$Rs[iCodTramite]' 
                 AND iCodAuto = '$Rs[iCodAuto]' ";
        $rsDw  = sqlsrv_query($cnx,$sqlDw);
        if (sqlsrv_has_rows($rsDw) > 0){
          $RsDw = sqlsrv_fetch_array($rsDw);
          if ($RsDw['cNombreNuevo'] != ""){
            if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
            	echo "<br>";
            	echo "-----";
            	echo "<br>";
              echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
            }
          }
        }else{
          echo "<img src=images/space.gif width=16 height=16 border=0>";
        }
      }
    } 
        // $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]'";
        // $rsDw  = sqlsrv_query($cnx,$sqlDw);
        // if (sqlsrv_has_rows($rsDw) > 0){
        //   $RsDw = sqlsrv_fetch_array($rsDw);
        //   if ($RsDw['cNombreNuevo'] != ""){
        //     if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
        //     	echo "<br>";
        //     	echo "-----";
        //     	echo "<br>";
        //       echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
        //     }
        //   }
        // }else{
        //   echo "<img src=images/space.gif width=16 height=16 border=0>";
        // }
      ?>
	 </td>
	 <td valign="middle" align="center">
      <!-- <input type="checkbox" name="iCodAuto[]" value="<?php echo $Rs['iCodAuto']; ?>" onClick="setCodTramite(this);"
             data-codTramite="<?php echo $Rs['iCodTramite']; ?>"> -->
      <?php 
        // $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]'";
        // $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite = '$Rs[iCodTramite]'";
        //$sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales_Mensajeria WHERE iCodTramite = '$Rs[iCodTramite]'";
        $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales_Mensajeria WHERE iCodTramite = '$Rs[iCodTramite]' 
                 AND iCodAuto = '$Rs[iCodAuto]' ";
        //echo $sqlDw;
        $rsDw  = sqlsrv_query($cnx,$sqlDw);
        if (sqlsrv_has_rows($rsDw) > 0){
          $RsDw = sqlsrv_fetch_array($rsDw);
          if ($RsDw['cNombreNuevo'] != ""){
            if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
              echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
            }
          }
        }else{
          echo "<img src=images/space.gif width=16 height=16 border=0>";
        }
      ?>
    </td>
</tr>
 

<?
}
}
?> 
<tr>
		<td colspan="7" align="center">
        <?php echo paginar($pag, $total, $tampag, "consultaTramiteCargoOficina.php?fDesde=".$_REQUEST[fDesde]."&fHasta=".$_REQUEST[fHasta]."&cCodificacion=".$_REQUEST[cCodificacion]."&cCodTipoDoc=".$_REQUEST[cCodTipoDoc]."&cFlgUrgente=".$_REQUEST[cFlgUrgente]."&cFlgLocal=".$_REQUEST[cFlgLocal]."&cFlgNacional=".$_REQUEST[cFlgNacional]."&iCodTrabajadorEnvio=".$_REQUEST[iCodTrabajadorEnvio]."&cNombre=".$_REQUEST['cNombre']."&cDireccion=".$_REQUEST[cDireccion]."&cOrdenServicio=".$_REQUEST[cOrdenServicio]."&ChxfRespuesta=".$_REQUEST[ChxfRespuesta]."&pag=");?>          </td>
		</tr>
</table>
  </form> 
    </td>
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