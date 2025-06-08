<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_entrega_motorizado.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Datos de Envio
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   Larry Ortiz        12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
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

<table width="603" height="345" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
<tr>
<td width="599" height="343" align="left" valign="top">

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

	
<div class="AreaTitulo">ENTREGA A MOTORIZADO:</div>	
	<table cellpadding="0" cellspacing="0" border="0" width="510"><tr><td width="510"><?php // ini table por fieldset ?>
			<fieldset><legend>Completar:</legend>
					<table cellpadding="3" cellspacing="3" border="0" width="500">
						<form name="frmConsultaEntrada" method="POST" action="../controllers/ln_nueva_entrega_motorizado.php" target="_parent">
						<? 
						require_once("../conexion/conexion.php");
						for ($h=0;$h<count($_POST[iCodAuto]);$h++){
                    	$iCodAuto=$_POST[iCodAuto];
	                    ?>
						<input type="hidden" name="iCodAuto[]" value="<?=$iCodAuto[$h]?>" size="65" class="FormPropertReg form-control">
                        <? 
						$sql="SELECT * FROM Tra_M_Doc_Salidas_Multiples WHERE iCodAuto=$iCodAuto[$h] ";
						}
						$rs=sqlsrv_query($cnx,$sql);
						$Rs=sqlsrv_fetch_array($rs);
						?>
                        
                        <tr>
							<td height="10" ></td>
                           
                          <td width="131"  valign="middle">Envio Local:</td>
							<td align="left"><input type="radio" name="cFlgEnvio" id="radio" value="1"  <?php if($Rs[cFlgEnvio]==1) echo "checked";  ?>/> </td>
							<td align="left"  valign="middle">Envio Nacional:&nbsp; </td>
							<td align="left"  valign="middle"><input type="radio" name="cFlgEnvio" id="radio2" value="2" <?php if($Rs[cFlgEnvio]==2) echo "checked";  ?> /></td>
						</tr>
						<tr>
							<td width="18" >&nbsp;</td>
							
							<td width="131" >Pedido de Servicio:</td>
							<td colspan="3" align="left"><input type="txt" name="cOrdenServicio" value="<?=$Rs[cOrdenServicio]?>" size="55" class="FormPropertReg form-control">							</td>
						</tr>
                         <tr>
							<td width="18" >&nbsp;</td>
							
							<td width="131" >Fecha de Entrega:</td>
							<td colspan="3" align="left">

									<td><input type="text" readonly name="fEntrega" value="<?php if($Rs[fEntrega]!=""){echo date("d-m-Y", strtotime($Rs[fEntrega]));} else if($_GET[fEntrega]==""){ echo date("d-m-Y");}else {echo $_GET[fEntrega];}?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fEntrega,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									</tr></table>							</td>
						</tr>
						<tr>
							<td width="18" >&nbsp;</td>
							
							<td width="131" >Responsable de Envio:</td>
							<td width="359" colspan="3" align="left"><select name="iCodTrabajadorEnvio" class="FormPropertReg form-control" style="width:180px" />
							<option value="">Seleccione:</option>
							<?
							  $sqlTrab="SELECT * FROM Tra_M_Trabajadores WHERE iCodCategoria=2 OR iCodCategoria=3 OR iCodCategoria=4  ORDER BY cNombresTrabajador,cApellidosTrabajador";
          				      $rsTrab=sqlsrv_query($cnx,$sqlTrab);
          				      while ($RsTrab=sqlsrv_fetch_array($rsTrab)){
          					  if($RsTrab["iCodTrabajador"]== $Rs[iCodTrabajadorEnvio]){
          					  $selec="selected";
          					  }Else{
          				      $selec="";
          					  }  
          				      echo "<option value=".$RsTrab["iCodTrabajador"]." ".$selec.">".$RsTrab["cNombresTrabajador"]." ".$RsTrab["cApellidosTrabajador"]."</option>";
          				     }
          				sqlsrv_free_stmt($rsTrab);
							?>
							</select></td>
						</tr>
                        <tr>
                          <td >&nbsp;</td>
                          <td >N� Guia de Servicio</td>
                          <td colspan="3" align="left"><input type="txt" name="cNumGuiaServicio" value="<?=trim($Rs[cNumGuiaServicio])?>" size="65" class="FormPropertReg form-control"></td>
                        </tr>
                        <tr>
							<td width="18" >&nbsp;</td>
							
							<td width="131" >Muy Urgente:</td>
							<td width="359" colspan="3" align="left">
							  <input type="checkbox" name="cFlgUrgente" value="1" <?php if($Rs[cFlgUrgente]==1) echo "checked"?>  />							</td>
						</tr>
                       
						
						<tr>
                         
							<td colspan="6" align="center">
                            <button class="btn btn-primary"  type="submit" id="Insert Indicador" onMouseOver="this.style.cursor='hand'"> <b>GUARDAR</b>  </button>
������				������
   <button class="btn btn-primary" type="button" onclick="window.open('consultaTramiteCargo.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button> </td>
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