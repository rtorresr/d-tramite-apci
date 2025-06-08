<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
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
function Finalizar()
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
                         Finalizar Documento
                     </div>
                      <!--Card content-->
                     <div class="card-body">
							<form name="frmConsulta" method="POST">
							<input type="hidden" name="opcion" value="4">
                              <? 
							if($_POST['iCodMovimientoAccion']==""){
						for ($h=0;$h<count($_POST['MovimientoAccion']);$h++){
                    	$iCodMovimientoAccion=$_POST['MovimientoAccion'];
	                    ?>
                        <input type="hidden" name="iCodMovimiento[]" value="<?=$iCodMovimientoAccion[$h]?>" size="65" class="FormPropertReg form-control">
                        <?
								}	
                         		}
							else if($_POST['iCodMovimientoAccion']!=""){?>
							<input type="hidden" name="iCodMovimiento[]" value="<?=$_POST['iCodMovimientoAccion']?>">
							<?																		
							}
			            ?>	

		        	<!-- <tr>
		        		<td>
		        			<select name="cPrioridad" id="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
		        				<option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
		        				<option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
		        				<option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
		        			</select>
		        		</td>
		        	</tr> -->
							
							<tr>
							<td width="120"  valign="top">Observaciones:</td>
							<td align="left"><textarea name="cObservacionesFinalizar" style="width:400px;height:100px" class="FormPropertReg form-control"></textarea></td>
							</tr>
														
							<tr>
							<td colspan="2" align="right">
							<button class="btn btn-primary" onclick="Finalizar();" onMouseOver="this.style.cursor='hand'"> <b>Finalizar</b> <img src="images/icon_finalizar.png" width="17" height="17" border="0"> </button>
							&nbsp;&nbsp;
							<button class="btn btn-primary" onclick="window.open('pendientesControl.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
							
							</td>
							</tr>
							</form>

                     </div>



<?
include_once("../conexion/conexion.php");
include("includes/userinfo.php");
?>
</table>

<?php include("includes/pie.php");?>


             </div>

          </div>
      </div>

 </main>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>