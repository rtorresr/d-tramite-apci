<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: A�adir avances de profesional
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
function Avance()
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

<div class="AreaTitulo">Agregar Avance</div>	

				<table cellpadding="0" cellspacing="0" border="0" width="500"><tr><td><?php // ini table por fieldset ?>
				<fieldset>
						<table cellpadding="3" cellspacing="3" border="0" width="580">
							<?
							include_once("../conexion/conexion.php");
							$rsMovData=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".$_GET['iCodMovimientoAccion']."'");
							$RsMovData=sqlsrv_fetch_array($rsMovData);
		
							$sqlAvn="SELECT * FROM Tra_M_Tramite_Avance WHERE iCodTramite='$RsMovData[iCodTramite]' ORDER BY iCodAvance DESC";
              $rsAvn=sqlsrv_query($cnx,$sqlAvn);
              while ($RsAvn=sqlsrv_fetch_array($rsAvn)){
              ?>
              <tr>
							<td width="120" valign="top" align="right" width="160">
							<?
							$rsTrbA=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsAvn[iCodTrabajadorAvance]'");
          		$RsTrbA=sqlsrv_fetch_array($rsTrbA);
          		echo "<div style=font-size:10px;color:#623100>".$RsTrbA["cApellidosTrabajador"]." ".$RsTrbA["cNombresTrabajador"].":</div>";
							sqlsrv_free_stmt($rsTrbA);
							echo "<div style=font-size:10px;color:#005128>".date("d-m-Y h:i a", strtotime($RsAvn[fFecAvance]))."&nbsp;</div>";
							?>
							</td>
							<td align="left" valign="top"><?=$RsAvn[cObservacionesAvance]?></td>
							</tr>
              <?php}?>

							<form name="frmConsulta" method="POST">
							<input type="hidden" name="opcion" value="5">
							<input type="hidden" name="iCodMovimiento" value="<?=((isset($_GET['iCodMovimientoAccion']))?$_GET['iCodMovimientoAccion']:'')?>">
							
							<tr>
							<td width="120"  valign="top">Observaciones:</td>
							<td align="left"><textarea name="cObservacionesAvance" style="width:420px;height:100px" class="FormPropertReg form-control"></textarea></td>
							</tr>
														
							<tr>
							<td colspan="2" align="right">
							<button class="btn btn-primary" onclick="Avance();" onMouseOver="this.style.cursor='hand'"> <b>Avance</b> <img src="images/icon_avance.png" width="17" height="17" border="0"> </button>
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