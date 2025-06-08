<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/detalle.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>

<!-- NUEVO  SELECT CON SUGERENCIAS -->
<link rel="stylesheet" href="css_select/select2.min.css">
<link rel="stylesheet" href="css_select/style.css">
<!-- NUEVO  SELECT CON SUGERENCIAS -->

<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script language="javascript" type="text/javascript">

function activaDestino(){
	if (document.frmRegistro.nFlgEnvio.value==1){
			document.frmRegistro.nFlgEnvio.value="";
	} else {
			document.frmRegistro.nFlgEnvio.value=1;
	}
return false;
}
    
function releer(codOfi){	
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>";
  document.frmRegistro.codOficina.value=codOfi;
  document.frmRegistro.submit();
}

function Registrar(){
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  if (document.frmRegistro.cNroDocumento.value.length == "")
  {
    alert("Ingrese N�mero de Documento");
    document.frmRegistro.cNroDocumento.focus();
    return (false);
  }

  if (document.frmRegistro.fechaDocumento.value.length == "")
  {
    alert("Ingrese Fecha de Documento");
    document.frmRegistro.fechaDocumento.focus();
    return (false);
  }

  if (document.frmRegistro.cNombreRemitente.value.length == "")
  {
    alert("Ingrese Nombre de Remitente");
    document.frmRegistro.cNombreRemitente.focus();
    return (false);
  }
  
  if (document.frmRegistro.nFlgEnvio.value==1)
  {
  		if (document.frmRegistro.iCodOficinaResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Destino");
  		  document.frmRegistro.iCodOficinaResponsable.focus();
  		  return (false);
  		}
  		if (document.frmRegistro.iCodTrabajadorResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Responsable");
  		  document.frmRegistro.iCodTrabajadorResponsable.focus();
  		  return (false);
  		}
  }
  document.frmRegistro.opcion.value=7;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

</script>
</head>
<body>
	<?php
		$rs = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs = sqlsrv_fetch_array($rs);
	?>
 
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

<div class="AreaTitulo">Documento N&ordm;: <?=$Rs[cCodificacion]?> - a�adir ANEXO</div>
<table cellpadding="0" cellspacing="0" border="0" width="910">
<tr>
<td class="FondoFormRegistro">
		
		<table width="880" border="0" align="center">
		<tr>
		<td>   
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend">Datos de Anexo<img src="images/icon_expand.png" width="16" height="13" border="0"></legend>
		    <div id="zonaAnexo">
		    		<table><tr>
		    		<form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
						<input type="hidden" name="opcion" value="">
						<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
						<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
						<input type="hidden" name="nFlgEnvio" value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
						<input type="hidden" name="codOficina" value="">
		    		<td>
						
						<table cellpadding="2" cellspacing="2" border="0" width="860">
						<tr>
						<td valign="top"  width="160">Tipo de Documento:</td>
						<td valign="top">
								<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
								<option value="">Seleccione:</option>
								<?php
								$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
      			    $sqlTipo.="ORDER BY cDescTipoDoc ASC";
      			    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
      			    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
      			    	if($RsTipo["cCodTipoDoc"]==$_POST[cCodTipoDoc]){
      			    		$selecTipo="selected";
      			    	}else{
      			    		$selecTipo="";
      			    	}
      			    echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
      			    }
      			    sqlsrv_free_stmt($rsTipo);
								?>
							</select>&nbsp;<span class="FormCellRequisito">*</span>
						</td>
						<td valign="top" >Folios:</td>
						<td>
							<input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;}else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/></td>
						</tr>
						
						<tr>
						<td valign="top"  width="150">N&ordm; del Documento:</td>
						<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNroDocumento" value="<?=$_POST['cNroDocumento']?>" class="FormPropertReg form-control" style="width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
						</tr>						

						<tr>
							<td  valign="top">Fecha del Documento:</td>
							<td>
								<input type="text" name="fechaDocumento" value="<?php echo $_POST['fechaDocumento'] ?>" style="width:120px" class="FormPropertReg form-control" readonly>
								<div class="boton" style="width:24px;height:20px;display:inline">
									<a href="javascript:;" onclick="displayCalendar(document.forms[0].fechaDocumento,'dd-mm-yyyy hh:ii',this,true)">
										<img src="images/icon_calendar.png" width="22" height="20" border="0">
									</a>
								</div>
								&nbsp;<span class="FormCellRequisito">*</span>
							</td>
						</tr>

						<tr>
						<td valign="top" >Remitente / Instituci&oacute;n:</td>
						<td valign="top" colspan="3">
								<table cellpadding="0" cellspacing="2" border="0">
								<tr>
								<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?=$_POST[cNombreRemitente]?>" style="width:380px" readonly></td>
								<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
								<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a> </div></td>
								<td>&nbsp;<span class="FormCellRequisito">*</span></td>
								</tr>
								</table>
								<input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
								<input id="Remitente" name="Remitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
						</td>
						</tr>
						
						<tr>
						<td valign="top" >Remite:</td>
						<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNomRemite" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg form-control" style="width:250px" /></td>
						</tr>						
						
						<tr>
						<td valign="top"  width="150">Oficina:</td>
						<td>
							<select name="iCodOficinaResponsable" style="width:290px;" class="js-example-basic-single" 
											onChange="releer(this.value);">
								<option value="">Seleccione:</option>
									<?php
										$sqlDep2="SELECT * FROM Tra_M_Oficinas WHERE iFlgEstado != 0  ";
      			        $sqlDep2.= "ORDER BY cNomOficina ASC";
      			        $rsDep2 = sqlsrv_query($cnx,$sqlDep2);
      			        while ($RsDep2 = sqlsrv_fetch_array($rsDep2)){
      			        	if($RsDep2['iCodOficina']==$_POST[iCodOficinaResponsable]){
      			        		$selecOfi="selected";
      			        	}else{
      			        		$selecOfi="";
      			        	}
      			          echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".trim($RsDep2["cNomOficina"])." | ".trim($RsDep2["cSiglaOficina"])."</option>";
      			        }
      			        sqlsrv_free_stmt($rsDep2);
										?>
							</select>
						</td>
						<td valign="top" >Responsable</td>
						<td>
							<select name="iCodTrabajadorResponsable" style="width:290px;" class="FormPropertReg combobox">
								<?php
					 				$sqlTrb = "SELECT * FROM Tra_M_Perfil_Ususario TPU
					 									 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
					 									 WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '$_POST[codOficina]'";

      			      $rsTrb  = sqlsrv_query($cnx,$sqlTrb);
      			      while ($RsTrb = sqlsrv_fetch_array($rsTrb)){
      			      	if($RsTrb[iCodTrabajador] == $_POST[iCodTrabajadorResponsable]){
      			        	$selecTrab = "selected";
      			        }else{
      			        	$selecTrab = "";
      			        }
      			        echo "<option style=\"font-weight:bold;font-size:8px;\" value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
      			        }
      			        sqlsrv_free_stmt($rsTrb);
								?>
							</select>
						</td>
						</tr>
						<tr>
						<td valign="top"  width="160">Asunto:</td>
						<td valign="top" colspan="3"><textarea name="cAsunto" style="width:450px;height:50px;font-family:arial" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea></td>
						</tr>
						
						<tr>
						<td valign="top"  width="160">Observaciones:</td>
						<td valign="top" colspan="3"><textarea name="cObservaciones" style="width:450px;height:50px;font-family:arial" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea></td>
						</tr>
						
						<tr>
							<td valign="top"  width="160">Adjuntar Archivo:</td>
							<td valign="top" colspan="3">
								<input type="file" class="FormPropertReg form-control" name="fileUpLoadDigital" style="width:500px;" />
								</td>
						</tr>
						
						<tr>
						<td valign="top" >Derivar Inmediatamente:</td>
						<td valign="top" colspan="3">
							<input type="checkbox" name="ActivarDestino" value="1">
							<!-- <input type="checkbox" name="ActivarDestino" value="1" checked
								   onclick="activaDestino();" <?php if($_POST[ActivarDestino]==1) echo "checked"?>> -->
						</td>
						</tr>						
						
						<tr>
						<td colspan="4"> 
							<input name="button" type="button" class="btn btn-primary" value="Adjuntar Anexo" onclick="Registrar();">
						</td>		
						</tr>

						</table>
		    </div>
		    <img src="images/space.gif" width="0" height="0"> 
		  	</fieldset>
		</td>
		</tr>		
		</table>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<div>		
</body>

<!-- NUEVO  SELECT CON SUGERENCIAS -->
<script type="text/javascript" src="js_select/jquery.min.js"></script>
<script type="text/javascript" src="js_select/select2.min.js"></script>
<script src="js_select/index.js"></script>
<!-- NUEVO  SELECT CON SUGERENCIAS -->
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>