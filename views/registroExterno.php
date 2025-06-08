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

function activaNatural()
{
document.frmRegistro.tipoRemitente.value=1;
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1";
document.frmRegistro.submit();
return false;

}

function activaEmpresa()
{
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

<div class="AreaTitulo">Registro - Externo</div>	
		<form name="frmRegistro" method="POST">
		<input type="hidden" name="opcion" value="2">
		<?
		if($_POST[tipoRemitente]==1) $ValortipoRemitente=1;
		if($_POST[tipoRemitente]==2) $ValortipoRemitente=2;
		?>
		<input type="hidden" name="tipoRemitente" value="<?=$ValortipoRemitente?>">
		<input type="hidden" name="iCodRemitente" value="<?=$_POST[iCodRemitente]?>">		
		<table>
			
		<tr>
		<td>
			<table>
			<tr>
			<td valign="top" class="CellFormExte">Tipo Remitente:</td>
			<td valign="top" colspan="3">
					<input type="radio" name="radioNatural" onclick="activaNatural();" <?php if($_POST[tipoRemitente]==1) echo "checked"?>> Persona Natural
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="radioEmpresa" onclick="activaEmpresa();" <?php if($_POST[tipoRemitente]==2) echo "checked"?>> Razon Social
			</td>
			</tr>
			<tr>
			<td valign="top" class="CellFormExte">Remitente:</td>
			<td valign="top" colspan="3">
						<?
						include_once("../conexion/conexion.php");
						if($_GET[clear]==1){
							$iCodRemitente="";
						}Else{
							$iCodRemitente=$_POST[iCodRemitente];
						}
						$sqlRem="SELECT * FROM Tra_M_Remitente ";
          	$sqlRem.="WHERE iCodRemitente='$iCodRemitente'";
          	$rsRem=sqlsrv_query($cnx,$sqlRem);
          	$RsRem=sqlsrv_fetch_array($rsRem);
						?>
					<table cellpadding="0" cellspacing="0" border="0" <?php if($_POST[tipoRemitente]=="") echo "disabled"?>>
					<tr>
					<td align="right">Nombre:&nbsp;</td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0">
						<tr>
						<td><input type="text" class="FormPropertExte" name="cNombre" value="<?=$RsRem['cNombre']?>" size="72" <?php if($_POST[tipoRemitente]=="") echo "disabled"?> readonly></td>
						<td align="center">
							<?php if($_POST[tipoRemitente]!=""){?>
							<div class="FormSubmitExte" style="width:70px;height:17px;padding-top:4px;" <?php if($_POST[tipoRemitente]=="") echo "disabled"?>><a style=" text-decoration:none" href="registroExternoRemitente.php?tipoRemitente=<?=$ValortipoRemitente?>&iCodTupaClase=<?=$_POST[iCodTupaClase]?>&iCodTupa=<?=$_POST['iCodTupa']?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&nFolios=<?=$_POST[nFolios]?>&nIndicativo=<?=$_POST[nIndicativo]?>&cObservaciones=<?=$_POST[cObservaciones]?>&nFlgDerivar=<?=$_POST[nFlgDerivar]?>" rel="lyteframe" title="Documentos Adjuntos" rev="width: 730px; height: 350px; scrolling: auto; border:no">Selección</a></div>
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
					<td><input type="text" class="FormPropertExte" name="nNumDocumento" value="<?=$RsRem['nNumDocumento']?>" size="12" <?php if($_POST[tipoRemitente]=="") echo "disabled"?> readonly></td>
					</tr>
					<tr>
					<td align="right">Domicilio:&nbsp;</td><td><input type="text" class="FormPropertExte" name="cDireccion" value="<?=$RsRem[cDireccion]?>" size="87" <?php if($_POST[tipoRemitente]=="") echo "disabled"?> readonly></td>
					</tr>
					</table>
			</td>
			</tr>
			
			<tr>
			<td valign="top" class="CellFormExte">Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:360px;height:55px" class="FormPropertExte"><?=$_POST['cAsunto']?></textarea>
					&nbsp;&nbsp;
			</td>
			<td valign="top" class="CellFormExte">Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:360px;height:55px" class="FormPropertExte"><?=$_POST[cObservaciones]?></textarea>
			</td>
			</tr>			

			<tr>
			<td valign="top" class="CellFormExte" width="160">Tipo de Documento:</td>
			<td valign="top" colspan="3">
					<select name="cCodTipoDoc" class="FormPropertExte" style="width:120px" />
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
					Folios:&nbsp;<input type="text" name="nNumFolio" value="<?=$_POST[nNumFolio]?>" class="FormPropertExte" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>
			</td>
			</tr>

			<tr>
			<td valign="top" class="CellFormExte">N�mero de Indicativo:</td>
			<td valign="top" colspan="3"><input type="text" name="cNroIndicativo" value="<?=$_POST[cNroIndicativo]?>" class="FormPropertExte" style="width:200px" /></td>
			</tr>
			
			<tr>
			<td valign="top" class="CellFormExte">Derivar ahora:</td>
			<td valign="top" colspan="3">
					<input type="checkbox" name="nFlgDerivar" value="1" <?php if($_POST[nFlgDerivar]==1) echo "checked"?> onclick="activaDerivar();">
					<?php if($_POST[nFlgDerivar]==1){?>
							<select name="iCodDependencia" style="width:400px;" class="FormPropertExte">
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
					<input name="button" type="button" class="FormSubmitExte" value="Registrar" onclick="Registrar();">
			</td>
			</tr>
			</table>

		</form>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

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