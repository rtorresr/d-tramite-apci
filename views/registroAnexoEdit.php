<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/detalle.css" media="screen" />
<script language="javascript" type="text/javascript">
function muestra(nombrediv) {
    if(document.getElementById(nombrediv).style.display == '') {
            document.getElementById(nombrediv).style.display = 'none';
    } else {
            document.getElementById(nombrediv).style.display = '';
    }
}

function activaDestino(){
	if (document.frmRegistro.nFlgEnvio.value==1){
			document.frmRegistro.nFlgEnvio.value="";
	} else {
			document.frmRegistro.nFlgEnvio.value=1;
	}
return false;
}
    
function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1";
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
  document.frmRegistro.opcion.value=11;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

</script>
</head>
<body>
		<?
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs=sqlsrv_fetch_array($rs);
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

<div class="AreaTitulo">Anexo N&ordm;: <?=$Rs[cCodificacion]?> - edici�n</div>
<table cellpadding="0" cellspacing="0" border="0" width="910">
<tr>
<td class="FondoFormRegistro">
		
		<table width="880" border="0" align="center">
		<tr>
		<td>   
		  	<fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaAnexo')" class="LnkZonas">Datos de Anexo<img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div id="zonaAnexo">
		    	<table><tr><form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data"> 
						<input type="hidden" name="opcion" value="">
						<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
						<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
						<input type="hidden" name="nCodBarra" value="<?=trim($Rs[nCodBarra])?>">
						<?
						$sqlMov="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]' ORDER BY iCodMovimiento DESC";
            $rsMov=sqlsrv_query($cnx,$sqlMov);
						$RsMov=sqlsrv_fetch_array($rsMov);
            echo "<input type=hidden name=iCodOfi value=".$RsMov[iCodOficinaDerivar].">";
            echo "<input type=hidden name=iCodTra value=".$RsMov[iCodTrabajadorDerivar].">";
						?>
						<input type="hidden" name="UpdTrabajador" value="<?=$RsMov[iCodTrabajadorDerivar]?>">
						<input type="hidden" name="iCodMovimiento" value="<?=$RsMov[iCodMovimiento]?>">
						<input type="hidden" name="nFlgEnvio" value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
						
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
      			    	if($_GET[clear]==""){
          						if($RsTipo["cCodTipoDoc"]==$Rs[cCodTipoDoc]){
          							$selecTipo="selected";
          						}Else{
          							$selecTipo="";
          						}
          				}Else{
      			    			if($RsTipo["cCodTipoDoc"]==$_POST[cCodTipoDoc]){
      			    				$selecTipo="selected";
      			    			}Else{
      			    				$selecTipo="";
      			    			}
      			    	}
      			    echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
      			    }
      			    sqlsrv_free_stmt($rsTipo);
								?>
							</select>&nbsp;<span class="FormCellRequisito">*</span>
						</td>
						<td valign="top" >Folios:</td>
						<td><input type="text" name="nNumFolio" value="<?php if($_GET[clear]==""){ echo $Rs[nNumFolio]; }{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>&nbsp;<span class="FormCellRequisito">*</span></td>
						</tr>

						<tr>
						<td valign="top"  width="200">N&ordm; del Documento:</td>
						<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNroDocumento" value="<?php if($_GET[clear]==""){ echo trim($Rs['cNroDocumento']); }Else{ echo $_POST['cNroDocumento'];}?>" class="FormPropertReg form-control" style="width:250px" /></td>
						</tr>
						
								<?
								$sqlRmt="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente=$Rs[iCodRemitente]";
      			    $rsRmt=sqlsrv_query($cnx,$sqlRmt);
      			    $RsRmt=sqlsrv_fetch_array($rsRmt);
								?>
						<tr>
						<td valign="top" >Remitente / Instituci�n:</td>
						<td valign="top" colspan="3">
								<table cellpadding="0" cellspacing="2" border="0">
								<tr>
								<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?php if($_GET[clear]==""){ echo trim($RsRmt['cNombre']); }Else{ echo $_POST[cNombreRemitente];}?>" style="width:380px" readonly></td>
								<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
								<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a> </div></td>
								</tr>
								</table>
								<input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?php if($_GET[clear]==""){ echo $Rs[iCodRemitente]; }Else{ echo $_POST[iCodRemitente];}?>">
                                <input id="Remitente" name="Remitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
						</td>
						</tr>

						<tr>
						<td valign="top"  width="200">Remite:</td>
						<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNomRemite" value="<?php if($_GET[clear]==""){ echo trim($Rs[cNomRemite]); }Else{ echo $_POST[cNomRemite];}?>" class="FormPropertReg form-control" style="width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
						</tr>
						
						<tr>
						<td valign="top"  width="150">Destino:</td>
						<td>
							<select name="iCodOficinaResponsable" style="width:300px;" class="FormPropertReg form-control" onChange="releer();">
							<option value="">Seleccione:</option>
							<?
							$sqlOfic="SELECT * FROM Tra_M_Oficinas ORDER BY cNomOficina ASC";
              $rsOfic=sqlsrv_query($cnx,$sqlOfic);
              while ($RsOfic=sqlsrv_fetch_array($rsOfic)){
              	if($_GET[clear]==""){
          					if($RsOfic["iCodOficina"]==$RsMov[iCodOficinaDerivar]){
          						$selecOfi="selected";
          					}Else{
          						$selecOfi="";
          					}
          			}Else{
          					if($RsOfic["iCodOficina"]==$_POST[iCodOficinaResponsable]){
          						$selecOfi="selected";
          					}Else{
          						$selecOfi="";
          					}
          			}
                echo "<option value=".$RsOfic["iCodOficina"]." ".$selecOfi.">".$RsOfic["cNomOficina"]."</option>";
              }
							?>
							</select>
						</td>
						<td valign="top" >Responsable:</td>
						<td>
							<?
							if($_GET[clear]==""){
									$iCodOficinaResponsable=$RsMov[iCodOficinaDerivar];
							}Else{
									$iCodOficinaResponsable=$_POST[iCodOficinaResponsable];
							}
							?>
							<select name="iCodTrabajadorResponsable" style="width:300px;" class="FormPropertReg form-control">
							<?
							$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$iCodOficinaResponsable' And (iCodPerfil=3 or iCodPerfil=5 ) ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
              $rsTrb=sqlsrv_query($cnx,$sqlTrb);
              while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	if($_GET[clear]==""){
              			if($RsTrb[iCodTrabajador]==$RsMov[iCodTrabajadorDerivar]){
              				$selecTrab="selected";
              			}Else{
              				$selecTrab="";
              			}
              	}Else{
              			if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorResponsable]){
              				$selecTrab="selected";
              			}Else{
              				$selecTrab="";
              			}              		
              	}
                echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
              }
              sqlsrv_free_stmt($rsTrb);
							?>
							</select>
						</td>
						</tr>
						
						<tr>
						<td valign="top"  width="160">Contenido:</td>
						<td valign="top" colspan="3"><textarea name="cAsunto" style="width:450px;height:50px;font-family:arial" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs['cAsunto']); }{ echo $_POST['cAsunto'];}?></textarea></td>
						</tr>
						
						<tr>
						<td valign="top"  width="160">Observaciones:</td>
						<td valign="top" colspan="3"><textarea name="cObservaciones" style="width:450px;height:50px;font-family:arial" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs[cObservaciones]); }{ echo $_POST[cObservaciones];}?></textarea></td>
						</tr>
						
						<tr>
						<td valign="top"  width="160">Adjuntar Archivo:</td>
						<td valign="top" colspan="3">
								<?
								$sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          			$rsDig=sqlsrv_query($cnx,$sqlDig);
          			if(sqlsrv_has_rows($rsDig)>0){
          					$RsDig=sqlsrv_fetch_array($rsDig);
          					if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
												echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
												echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=15&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
										}Else{
          							echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:450px;\" />";
          					}
          			}Else{
          					echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:450px;\" />";
          			}
								?>
						</td>
						</tr>
						
								<?
								if($_GET[clear]==""){
										if($Rs[nFlgEnvio]==1){
												$marcarEnvio="checked disabled";
										}
								}Else{
										if($_POST[ActivarDestino]==1){
												$marcarEnvio="checked";
										}
								}
								?>
						<tr>
						<td valign="top" >Enviar Inmediatamente:</td>
						<td valign="top" colspan="3"><input type="checkbox" name="ActivarDestino" value="1" onclick="activaDestino();" <?=$marcarEnvio?>></td>
						</tr>					
						
						<tr>
						<td colspan="4">
						<input name="button" type="button" class="btn btn-primary" value="Actualizar Anexo" onclick="Registrar();">
						</td>		
						</tr>
						</table>
		    </div>
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
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
