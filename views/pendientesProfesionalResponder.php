<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Responder pendientes desde Profesional
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
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
function Delegar()
{
  document.frmConsulta.action="pendientesData.php";
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

<div class="AreaTitulo">Responder Documento</div>	

				<table cellpadding="0" cellspacing="0" border="0" width="500"><tr><td><?php // ini table por fieldset ?>
				<fieldset>
						<table cellpadding="3" cellspacing="3" border="0" width="620">
							<form name="frmConsulta" method="POST">
							<input type="hidden" name="opcion" value="3">
							<input type="hidden" name="iCodMovimiento" value="<?=((isset($_GET['iCodMovimientoAccion']))?$_GET['iCodMovimientoAccion']:'')?>">

						<tr>
							<td width="120" >Tipo de Documento:</td>
							<td align="left">
									<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:220px" />
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
						</tr>
							
						<tr>
							<td width="120" >Responder a:</td>
							<td align="left" class="CellFormRegOnly">
									<select name="iCodTrabajadorDelegado" style="width:252px;" class="FormPropertReg form-control">
									<option value="">Seleccione:</option>
									<?
									include_once("../conexion/conexion.php");
									$sqlTrb="SELECT * FROM Tra_M_Trabajadores ";
              		$sqlTrb.="WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' ";
              		$sqlTrb.="AND iCodTrabajador!='".$_SESSION['CODIGO_TRABAJADOR']."' ";
              		$sqlTrb .= "ORDER BY cApellidosTrabajador ASC";
              		$rsTrb=sqlsrv_query($cnx,$sqlTrb);
              		while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              		  echo "<option value=\"".$RsTrb["iCodTrabajador"]."\">".$RsTrb["cApellidosTrabajador"]." ".$RsTrb["cNombresTrabajador"]."</option>";
              		}
              		sqlsrv_free_stmt($rsTrb);
									?>
									</select>
							</td>
							</tr>
							
							<tr>
							<td width="120" >Asunto:</td>
							<td align="left"><textarea name="cAsuntoDerivar" style="width:460px;height:55px" class="FormPropertReg form-control"></textarea></td>
							</tr>

							<tr>
							<td width="120" >Observaciones:</td>
							<td align="left"><textarea name="cObservacionesDerivar" style="width:460px;height:55px" class="FormPropertReg form-control"></textarea></td>
							</tr>
														
							<tr>
							<td width="120" >Archivo:</td>
							<td align="left"><input type="file" name="UploadFile" class="FormPropertReg form-control" size="50"></td>
							</tr>

							<tr>
							<td colspan="2" align="right">
							<button class="btn btn-primary" onclick="Delegar();" onMouseOver="this.style.cursor='hand'"> <b>Responder</b> <img src="images/icon_delegar.png" width="17" height="17" border="0"> </button>
							&nbsp;&nbsp;
							<button class="btn btn-primary" onclick="window.open('pendientesProfesional.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
							</td>
							</tr>
							</form>



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