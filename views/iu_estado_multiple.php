<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
<!--


function seleccionar_todo(){
	for (i=0;i<document.formulario.elements.length;i++)
		if(document.formulario.elements[i].type == "checkbox")	
			document.formulario.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.formulario.elements.length;i++)
		if(document.formulario.elements[i].type == "checkbox")	
			document.formulario.elements[i].checked=0
}

function Registrar()
{
  document.formulario.submit();
  
}

//--></script>
</head>
<body>

<table width="603" height="262" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
<tr>
<td width="599" height="260" align="left" valign="top">

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

<div class="AreaTitulo">ESTADO DE DOCUMENTO:</div>	
		<table cellpadding="0" cellspacing="0" border="0" width="583"><tr><td width="583"><?php // ini table por fieldset ?>
			<fieldset><legend>Completar:</legend>
					<table cellpadding="3" cellspacing="3" border="0" width="538">
						<form name="frmConsultaEntrada" method="POST" action="../controllers/ln_nuevo_estado_multiple.php"
									target="_parent" enctype="multipart/form-data">
							<input type="hidden" name="codigoTramite" id="codigoTramite" value="<?php echo $_POST['codigoTramite']; ?>" />
            	<?php
								require_once("../conexion/conexion.php");
								for ($h=0;$h<count($_POST[iCodAuto]);$h++){
									$iCodAuto = $_POST[iCodAuto];
	         		?>
							<input type="hidden" name="iCodAuto[]" value="<?=$iCodAuto[$h]?>" size="65" class="FormPropertReg form-control">
             	<?php 
								$sql = "SELECT * FROM Tra_M_Doc_Salidas_Multiples WHERE iCodAuto=$iCodAuto[$h] ";
								}
								$rs = sqlsrv_query($cnx,$sql);
								$Rs = sqlsrv_fetch_array($rs);
							?>
						<tr>
							<td width="9" >&nbsp;</td>
							<td width="140" >Estado de Cargo:</td>
							<td width="359" align="left"><select name="cFlgEstado" class="FormPropertReg form-control" style="width:180px" />
							  <?
							if($Rs[cFlgEstado]!=1 and $Rs[cFlgEstado]!=2 and $Rs[cFlgEstado]!=3)
							{ echo "<option value='' selected>Seleccione:</option>";
							} 
							if($Rs[cFlgEstado]==3){	
			                echo "<option value='03' selected>Pendiente</option>";
		                                            }
		                    else{
			                echo "<option value='03' >Pendiente</option>";
		                        } 
                            if($Rs[cFlgEstado]==1){	
			                echo "<option value='01' selected>Notificado</option>";
		                                            }
		                    else{
			                echo "<option value='01' >Notificado</option>";
		                        }
		                    if($Rs[cFlgEstado]==2){	
			                echo "<option value='02' selected>Devuelto</option>";
		                                            }
		                    else{
			                echo "<option value='02' >Devuelto</option>";
		                        }
								
							
						  ?>
                            </select></td>
						</tr>
                        <tr>
							<td width="9" >&nbsp;</td>
							
							<td width="140" >Fecha:</td>
							<td align="left">

									<td><input type="text" readonly name="fRespuesta" value="<?php if($Rs[fRespuesta]!=""){echo date("d-m-Y", strtotime($Rs[fRespuesta]));} else if($_GET[fRespuesta]==""){ echo date("d-m-Y");}else {echo $_REQUEST[fRespuesta];}?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fRespuesta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									</tr></table>
							</td>
						</tr>
                        <tr>
							<td width="9" >&nbsp;</td>
							
							<td width="140" >Observaciones:</td>
							<td align="left"><input type="txt" name="cObservaciones" value="<?=trim($Rs[cObservaciones])?>" size="65" class="FormPropertReg form-control">
							</td>
						</tr>
            <tr>
							<td width="9" >&nbsp;</td>
							<td width="140" >Recibido por:</td>
							<td align="left"><input type="txt" name="cRecibido" value="<?=trim($Rs[cRecibido])?>" size="65" class="FormPropertReg form-control">
							</td>
						</tr>
            
            <tr>
							<td width="9" >&nbsp;</td>
							<td width="140" >N&deg; Devoluci&oacute;n de Cargo:</td>
							<td align="left">
								<input type="txt" name="cNumGuia" value="<?=trim($Rs[cNumGuia])?>" size="65" class="FormPropertReg form-control">
							</td>
						</tr>

						<tr>
							<td width="9" >&nbsp;</td>
							<td valign="top" >Adjuntar Archivo:</td>
							<td valign="top" colspan="3">
								<input type="file" class="FormPropertReg form-control" name="fileUpLoadDigital" style="width:420px;" />
							</td>
						</tr>

						<tr>
							<td colspan="4" align="center">
              	<button class="btn btn-primary"  type="submit" id="Insert Estado" onMouseOver="this.style.cursor='hand'">
              		<table cellspacing="0" cellpadding="0">
              			<tr>
              				<td style=" font-size:10px"><b>GUARDAR</b>&nbsp;&nbsp;</td>

              			</tr>
              		</table>
              	</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             		<button class="btn btn-primary" type="button" onclick="window.open('consultaTramiteCargo.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
							</td>
            </tr>
					</form>
				    </table>
			  </fieldset>

		<div>					</div>
                 </div>
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