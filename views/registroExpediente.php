<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

<script Language="JavaScript">
<!--

function activaNatural(){
document.frmRegistro.tipoRemitente.value=1;
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1";
document.frmRegistro.submit();
return false;
}

function activaEmpresa(){
document.frmRegistro.tipoRemitente.value=2;
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1";
document.frmRegistro.submit();
return false;
}

function activaDerivar(){
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
document.frmRegistro.submit();
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmRegistro.submit();
}

function seleccionar_todo(){
	for (i=0;i<document.frmRegistro.elements.length;i++)
		if(document.frmRegistro.elements[i].type == "checkbox")	
			document.frmRegistro.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.frmRegistro.elements.length;i++)
		if(document.frmRegistro.elements[i].type == "checkbox")	
			document.frmRegistro.elements[i].checked=0
}

function Registrar()
{
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

//--></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
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

<div class="AreaTitulo">Registro - Expediente</div>	
		<form name="frmRegistro" method="POST">
		<input type="hidden" name="opcion" value="1">
		<?
		if($_POST[tipoRemitente]==1) $ValortipoRemitente=1;
		if($_POST[tipoRemitente]==2) $ValortipoRemitente=2;
		?>
		<input type="hidden" name="tipoRemitente" value="<?=$ValortipoRemitente?>">
		<input type="hidden" name="iCodRemitente" value="<?=$_POST[iCodRemitente]?>">		
		<table>
			
		<tr>
		<td>
			<table width="1030" border="0">
			<tr>
			<td valign="top" class="CellFormExpe" width="160">Tipo Remitente:</td>
			<td valign="top" colspan="3">
					<input type="radio" name="radioNatural" onclick="activaNatural();" <?php if($_POST[tipoRemitente]==1) echo "checked"?>> Persona Natural
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="radioEmpresa" onclick="activaEmpresa();" <?php if($_POST[tipoRemitente]==2) echo "checked"?>> Razon Social
			</td>
			</tr>
			<tr>
			<td valign="top" class="CellFormExpe" width="160">Remitente:</td>
			<td valign="top" colspan="3">
					<table cellpadding="0" cellspacing="0" border="0" <?php if($_POST[tipoRemitente]=="") echo "disabled"?>>
					<tr>
					<td align="right">Nombre:&nbsp;</td>
					<td>
						<?
						if($_GET[clear]==1){
							$iCodRemitente="";
						}Else{
							$iCodRemitente=$_POST[iCodRemitente];
						}
						include_once("../conexion/conexion.php");
						$sqlRem="SELECT * FROM Tra_M_Remitente ";
          	$sqlRem.="WHERE iCodRemitente='$iCodRemitente'";
          	$rsRem=sqlsrv_query($cnx,$sqlRem);
          	$RsRem=sqlsrv_fetch_array($rsRem);
						?>
						<table cellpadding="0" cellspacing="0" border="0">
						<tr>
						<td><input type="text" class="FormPropertExpe" name="cNombre" value="<?=$RsRem['cNombre']?>" size="72" <?php if($_POST[tipoRemitente]=="") echo "disabled"?> readonly></td>
						<td align="center">
							<?php if($_POST[tipoRemitente]!=""){?>
							<div class="FormSubmitExpe" style="width:70px;height:17px;padding-top:4px;" <?php if($_POST[tipoRemitente]=="") echo "disabled"?>><a style=" text-decoration:none" href="registroExpedienteRemitente.php?tipoRemitente=<?=$ValortipoRemitente?>&iCodTupaClase=<?=$_POST[iCodTupaClase]?>&iCodTupa=<?=$_POST['iCodTupa']?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&nFolios=<?=$_POST[nFolios]?>&nIndicativo=<?=$_POST[nIndicativo]?>&cObservaciones=<?=$_POST[cObservaciones]?>&nFlgDerivar=<?=$_POST[nFlgDerivar]?>" rel="lyteframe" title="Selección de Remitente" rev="width: 730px; height: 350px; scrolling: auto; border:no">Selección</a></div>
							<?php}?>
						</td>
						</tr>
						</table>
					</td>
					</tr>
					<tr>
					<td align="right">
						<?php if($_POST[tipoRemitente]==1) echo "DNI: "?>
						<?php if($_POST[tipoRemitente]==2) echo "RUC: "?>
						<?php if($_POST[tipoRemitente]=="") echo "DOC: "?>
						&nbsp;
					</td>
					<td><input type="text" class="FormPropertExpe" name="nNumDocumento" value="<?=$RsRem['nNumDocumento']?>" size="12" <?php if($_POST[tipoRemitente]=="") echo "disabled"?> readonly></td>
					</tr>
					<tr>
					<td align="right">Domicilio:&nbsp;</td><td><input type="text" class="FormPropertExpe" name="cDireccion" value="<?=$RsRem[cDireccion]?>" size="87" <?php if($_POST[tipoRemitente]=="") echo "disabled"?> readonly></td>
					</tr>
					</table>
						<?sqlsrv_free_stmt($rsRem);?>
			</td>
			</tr>

			<tr>
			<td valign="top" class="CellFormExpe" width="160">Clase de Procedimiento:</td>
			<td valign="top" colspan="3">
					<select name="iCodTupaClase" class="FormPropertExpe" style="width:110px" onChange="releer();" />
					<option value="">Seleccione:</option>
					<?
					$sqlClas="SELECT * FROM Tra_M_Tupa_Clase ";
          $sqlClas.="ORDER BY iCodTupaClase ASC";
          $rsClas=sqlsrv_query($cnx,$sqlClas);
          while ($RsClas=sqlsrv_fetch_array($rsClas)){
          	if($RsClas["iCodTupaClase"]==$_POST[iCodTupaClase]){
          		$selecClas="selected";
          	}Else{
          		$selecClas="";
          	}
          echo "<option value=".$RsClas["iCodTupaClase"]." ".$selecClas.">".$RsClas["cNomTupaClase"]."</option>";
          }
          sqlsrv_free_stmt($rsClas);
					?>
					</select>
			</td>
			</tr>

			<tr>
			<td valign="top" class="CellFormExpe" width="160">Procedimiento:</td>
			<td valign="top" colspan="3">
					<select name="iCodTupa" class="FormPropertExpe" style="width:700px" onChange="releer();" <?php if($_POST[iCodTupaClase]=="") echo "disabled"?> />
					<option value="">Seleccione:</option>
					<?
					$sqlTupa="SELECT * FROM Tra_M_Tupa ";
          $sqlTupa.="WHERE iCodTupaClase='$_POST[iCodTupaClase]'";
          $sqlTupa.="ORDER BY iCodTupa ASC";
          $rsTupa=sqlsrv_query($cnx,$sqlTupa);
          while ($RsTupa=sqlsrv_fetch_array($rsTupa)){
          	if($RsTupa["iCodTupa"]==$_POST['iCodTupa']){
          		$selecTupa="selected";
          	}Else{
          		$selecTupa="";
          	}
          echo "<option value=".$RsTupa["iCodTupa"]." ".$selecTupa.">".$RsTupa["cNomTupa"]."</option>";
          }
          sqlsrv_free_stmt($rsTupa);
					?>
					</select>
			</td>
			</tr>

			<tr>
			<td valign="top" class="CellFormExpe" width="160">Requisitos:</td>
			<td valign="top" colspan="3">
					<?
					$sqlTupaReq="SELECT * FROM Tra_M_Tupa_Requisitos ";
          $sqlTupaReq.="WHERE iCodTupa='$_POST['iCodTupa']'";
          $sqlTupaReq.="ORDER BY iCodTupaRequisito ASC";
          $rsTupaReq=sqlsrv_query($cnx,$sqlTupaReq);
					?>
					<fieldset><legend>
										<?php if(sqlsrv_has_rows($rsTupaReq)>0){?>
										<a href="javascript:seleccionar_todo()">Marcar todos</a> | 
										<a href="javascript:deseleccionar_todo()">Desmarcar</a> 
										<?php}?>
										</legend>
					<table cellpadding="0" cellspacing="2" border="0" width="850">
					<?
					if(sqlsrv_has_rows($rsTupaReq)>0){
						while ($RsTupaReq=sqlsrv_fetch_array($rsTupaReq)){
          		echo "<tr><td valign=top width=15><input type=\"checkbox\" name=\"iCodTupaRequisito[]\" value=\"".$RsTupaReq["iCodTupaRequisito"]."\"></td><td style=\"color:#1E642B;font-size:11px\">".$RsTupaReq["cNomTupaRequisito"]."</td></tr>";
          	}
          }Else{
          	echo "&nbsp;";
          }
          sqlsrv_free_stmt($rsTupaReq);
					?>					
					</table>
					</fieldset>
			</td>
			</tr>

			<tr>
			<td valign="top" class="CellFormExpe" width="160">Tipo de Documento:</td>
			<td valign="top" colspan="3">
					<select name="cCodTipoDoc" class="FormPropertExpe" style="width:100px" />
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
					</select>
					&nbsp;&nbsp;&nbsp;
					Folios:&nbsp;<input type="text" name="nNumFolio" value="<?=$_POST[nNumFolio]?>" class="FormPropertExpe" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>
			</td>
			</tr>

			<tr>
			<td valign="top" class="CellFormExpe" width="160">N�mero de Indicativo:</td>
			<td valign="top"><input type="text" name="cNroIndicativo" value="<?=$_POST[cNroIndicativo]?>" class="FormPropertExpe" style="width:200px" /></td>
			<td valign="top" class="CellFormExpe">&nbsp;&nbsp;&nbsp;Observaciones:</td>
			<td valign="top"><textarea name="cObservaciones" style="width:450px;height:55px" class="FormPropertExpe"><?=$_POST[cObservaciones]?></textarea></td>
			</tr>
			
			<tr>
			<td valign="top" class="CellFormExpe">Derivar ahora:</td>
			<td valign="top" colspan="3">
					<input type="checkbox" name="nFlgDerivar" value="1" <?php if($_POST[nFlgDerivar]==1) echo "checked"?> onclick="activaDerivar();">
					<?php if($_POST[nFlgDerivar]==1){?>
							<select name="iCodDependencia" style="width:400px;" class="FormPropertExpe">
							<option value="">Seleccione:</option>
							<?
							$sqlDep2="SELECT * FROM Tra_M_Dependencias ";
              $sqlDep2.= "ORDER BY cNomDependencia ASC";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
                echo "<option value=".$RsDep2["iCodDependencia"].">".$RsDep2["cNomDependencia"]."</option>";
              }
              mysql_free_result($rsDep2);
							?>
							</select>
					<?php}?>
			</td>
			</tr>
			
			<tr>
			<td colspan="4">
					<input name="button" type="button" class="FormSubmitExpe" value="Registrar" onclick="Registrar();">
			</td>
			</tr>
			</table>

		</form>

<tr>
<td width="1088" height="32" background="images/pcm_9.jpg">
<!-- **************** -->

<!-- **************** -->	
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>