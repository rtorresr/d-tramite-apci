<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<meta http-equiv=Content-Type content=text/html; charset=UFT-8 charset=utf-8>
<title>SITDD</title>

<script language="javascript" type="text/javascript">

function activaDestino(){
	if (document.frmRegistro.nFlgEnvio.value==1){
			document.frmRegistro.nFlgEnvio.value="";
	} else {
			document.frmRegistro.nFlgEnvio.value=1;
	}
return false;
}
    
function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>";
  document.frmRegistro.submit();
}

function Registrar(){
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  if (document.frmRegistro.nNumFolio.value.length == "")
  {
    alert("Ingrese N�mero de Folios");
    document.frmRegistro.nNumFolio.focus();
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
  document.frmRegistro.action="registroDataEdicion.php";
  document.frmRegistro.submit();
}

</script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<style type="text/css">

</style>
</head>
<body>
		<?
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs=sqlsrv_fetch_array($rs);
		?>

<table cellpadding="0" cellspacing="0" border="0" align="center">

<tr>

	<?php include("includes/menu.php");?>
	<a name="area"></a>

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
		    		</tr></table>
						
						<table cellpadding="2" cellspacing="2" border="0" width="860">
						<tr>
						<td valign="top"  width="160">Tipo de Documento:</td>
						<td valign="top">
								<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
								<option value="">Seleccione:</option>
								<?
								$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
      			    $sqlTipo.="ORDER BY cDescTipoDoc ASC";
      			    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
      			    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
      			    	if($RsTipo["cCodTipoDoc"]==$_POST[cCodTipoDoc]){
      			    		$selecTipo="selected";
      			    	}Else{
      			    		$selecTipo="";
      			    	}
      			    echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
      			    }
      			    sqlsrv_free_stmt($rsTipo);
								?>
							</select>&nbsp;<span class="FormCellRequisito">*</span>
						</td>
						<td valign="top" >Folios:</td>
						<td><input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;}else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/>&nbsp;<span class="FormCellRequisito">*</span></td>
						</tr>
						 <tr>
			    <td valign="top" >N&ordm; del Tramite:</td>
			  <td valign="top" ><input type="text" name="cCodificacion" value="<?=$_POST[cCodificacion]?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:150px" />&nbsp; - &nbsp;<input type="text" name="cIndice" value="<?=$_POST[cIndice]?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:80px" /></td>
              <td  width="160">Trabajador de Registro:</td>
			<td> <select name="iCodTrabajadorRegistro" style="width:340px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
					<? $sqlTrb="SELECT * FROM Tra_M_Trabajadores ";
                       $sqlTrb .= "ORDER BY cNombresTrabajador ASC";
                       $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                       while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	       if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorRegistro]){
              		   $selecTrab="selected";
              	       }Else{
              		   $selecTrab="";
              	       }
                       echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                       }
                       sqlsrv_free_stmt($rsTrb);
		 		   ?>
				   </select></td>
			  </tr>	
             
						<tr>
						<td valign="top"  width="150">N&ordm; del Documento:</td>
						<td valign="top" colspan="3"><input type="text" name="cNroDocumento" value="<?=$_POST['cNroDocumento']?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:250px" /></td>
						</tr>						

						<tr>
						<td valign="top" >Remitente:</td>
						<td valign="top" colspan="3">
								<table cellpadding="0" cellspacing="2" border="0">
								<tr>
								<td align="right" width="70" style="color:#7E7E7E">Nombre:&nbsp;</td>
								<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?=$_POST[cNombreRemitente]?>" style="width:380px" readonly></td>
								<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
								<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a> </div></td>
								</tr>
								<tr>
								<td align="right" width="70" style="color:#7E7E7E">Documento:&nbsp;</td>
								<td colspan="3"><input id="nNumDocumento" name="nNumDocumento" value="<?=$_POST['nNumDocumento']?>" class="FormPropertReg form-control" style="width:100px" readonly></td>
								</tr>
								</table>
								<input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
						</td>
						</tr>
						
						<tr>
						<td valign="top" >Remite:</td>
						<td valign="top" colspan="3"><input type="text" name="cNomRemite" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:250px" /></td>
						</tr>						
						
						<tr>
						<td valign="top"  width="150">Destino:</td>
						<td>
										<select name="iCodOficinaResponsable" style="width:290px;" class="FormPropertReg form-control" onChange="loadResponsables(this.value);">
										<option value="">Seleccione:</option>
										<?
										$sqlDep2="SELECT * FROM Tra_M_Oficinas ";
      			        $sqlDep2.= "ORDER BY cNomOficina ASC";
      			        $rsDep2=sqlsrv_query($cnx,$sqlDep2);
      			        while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
      			        	if($RsDep2['iCodOficina']==$_POST[iCodOficinaResponsable]){
      			        		$selecOfi="selected";
      			        	}Else{
      			        		$selecOfi="";
      			        	}
      			          echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
      			        }
      			        sqlsrv_free_stmt($rsDep2);
										?>
										</select>
						</td>
						<td valign="top" >Responsable:</td>
						<td>
							<select name="iCodTrabajadorResponsable" id="responsable" style="width:340px;" class="FormPropertReg form-control"></select>
						</td>
						</tr>
						
						<tr>
						<td valign="top"  width="160">Contenido:</td>
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
						<td valign="top" >Enviar Inmediatamente:</td>
						<td valign="top" colspan="3"><input type="checkbox" name="ActivarDestino" value="1" onclick="activaDestino();" <?php if($_POST[ActivarDestino]==1) echo "checked"?>></td>
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


<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>
<script src="scripts/select_ajax.js"></script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
