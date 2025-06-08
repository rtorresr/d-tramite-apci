<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registro de documentos para Oficinas
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

<script Language="JavaScript">
<!--
function agregar(){
	var bNoAgregar;
	bNoAgregar=false;

	for(i=0; i<=document.frmRegistro.lstOficinas.length-1; i++){
		if(document.frmRegistro.lstOficinas.options[i].selected){ 
			for(z=0;z<=document.frmRegistro.lstOficinasSel.length-1;z++){
				if(document.frmRegistro.lstOficinas.options[i].text==document.frmRegistro.lstOficinasSel.options[z].text){
					alert("�La Dependencia ''" + document.frmRegistro.lstOficinas.options[i].text + "'' ya est� a�adida!");
					bNoAgregar=true;
				break; 
				}
			} 
			if(bNoAgregar==false){
				document.frmRegistro.lstOficinasSel.length++;
				document.frmRegistro.lstOficinasSel.options[document.frmRegistro.lstOficinasSel.length-1].text= document.frmRegistro.lstOficinas.options[i].text;
				document.frmRegistro.lstOficinasSel.options[document.frmRegistro.lstOficinasSel.length-1].value= document.frmRegistro.lstOficinas.options[i].value; 
			}
		}
	} 
}

function retirar(tipoLst){
var ArrayProvincias=new Array();
var ArrayProfesiones=new Array();
var Contador;
Contador=0;
	for(i=0;i<=document.frmRegistro.lstOficinasSel.length-1;i++){
		if((document.frmRegistro.lstOficinasSel.options[i].text!="")&&(document.frmRegistro.lstOficinasSel.options[i].selected==false)){
			ArrayProvincias[Contador]=document.frmRegistro.lstOficinasSel.options[i].text;
			Contador=Contador+1;
		}
	}
	document.frmRegistro.lstOficinasSel.length=Contador;
	for(i=0;i<Contador;i++){
		document.frmRegistro.lstOficinasSel.options[i].text=ArrayProvincias[i];
	}
}

function seleccionar(obj) {
	Elem=document.getElementById(obj).options;
	for(i=0;i<Elem.length;i++)
	Elem[i].selected=true;
}

function Registrar()
{
	<?php if($_POST[cCodTipoDoc]==1){?>
	seleccionar('lstOficinasSel');
	<?php}?>
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

function releer()
{
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmRegistro.submit();
}

//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
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

<div class="AreaTitulo">Registro - Dependencia</div>	
		<table class="table">
			<form name="frmRegistro" method="POST" action="registroData.php">
			<input type="hidden" name="opcion" value="4">
		<tr>
		<td class="FondoFormRegistro">
			<table>
			<tr>
			<td valign="top" >Tipo de Documento:</td>
			<td valign="top" colspan="3">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:120px" onChange="releer();" />
					<option value="">Seleccione:</option>
					<?
					include_once("../conexion/conexion.php");
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
					<span class="CellFormRegOnly">Fecha de Plazo:</span>
					<input type="text" readonly name="fFecPlazo" style="width:75px" class="FormPropertReg form-control" value="<?=$_POST[fFecCaducidad]?>"><input type="button" value=" ... " style="width:22px" onclick="displayCalendar(document.forms[0].fFecPlazo,'yyyy-mm-dd',this,false)">
			</td>
			</tr>
			
			<tr>
			<td valign="top" >Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:390px;height:55px" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea>
					&nbsp;&nbsp;
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:390px;height:55px" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea>
			</td>
			</tr>

			<tr>
			<td valign="top" >Referencia:</td>
			<td valign="top" colspan="3">
					<textarea name="cReferencia" style="width:390px;height:55px" class="FormPropertReg form-control"><?=$_POST[cReferencia]?></textarea>
			</tr>


			<?php if($_POST[cCodTipoDoc]==1){?>
			<tr>
			<td valign="top" >Delegar a:</td>
			<td valign="top" colspan="3">
					<table>
					<tr>
					<td>
							<select id="lstOficinas" name="lstOficinas[]" style="width:400px;" size="6" class="FormPropertReg form-control" multiple>
							<?
							$sqlDep="SELECT * FROM Tra_M_Oficinas ";
              $sqlDep .= "ORDER BY cNomOficina ASC";
              $rsDep=sqlsrv_query($cnx,$sqlDep);
              while ($RsDep=sqlsrv_fetch_array($rsDep)){
                echo "<option value=".$RsDep["iCodOficina"].">".$RsDep["cNomOficina"]."</option>";
              }
              mysql_free_result($rsDep);
							?>
							</select><br>
					</td>
					<td width="80">
							<a style="color:#006F00" href="javascript:agregar();"><img src="images/icon_add_trabajador.png" width="22" height="22" border="0"> A�adir</a>&nbsp;
							<div style="height:10px"></div>
							<div align="right"><a style="color:#800000" href="javascript:retirar();">Quitar <img src="images/icon_del_trabajador.png" width="22" height="22" border="0"></a></div>
					</td>
					<td>
							<select id="lstOficinasSel" name="lstOficinasSel[]" style="width:400px;" size="6" class="FormPropertReg form-control" multiple>
							</select>
					</td>
					</tr>
					</table>
			</td>
			</tr>
			
			<tr>
			<td valign="top" >Acciones:</td>
			<td valign="top" colspan="3" width="760">
					<fieldset>
					<table width="740" border="0" cellspacing="0">
          <tr> 
            <td width="20"><input type="checkbox" name="Acciones[]" value="1"></td>
            <td width="180" class="size8">Conocimiento y fines</td>
            <td width="50"></td>
            <td width="20"><input type="checkbox" name="Acciones[]" value="2"></td>
            <td width="180" class="size8">Revisi&oacute;n y an&aacute;lisis</td>
            <td width="50"></td>
            <td width="20"><input type="checkbox" name="Acciones[]" value="3"></td>
            <td width="220" class="size8">Preparar respuesta</td>
          </tr>
          <tr> 
            <td width="20"><input type="checkbox" name="Acciones[]" value="4"></td>
            <td width="180" class="size8">Acci&oacute;n</td>
            <td width="50"></td>
            <td width="20"><input type="checkbox" name="Acciones[]" value="5"></td>
            <td width="180" class="size8">Preparar Informe</td>
            <td width="50"></td>
            <td width="20"><input type="checkbox" name="Acciones[]" value="6"></td>
            <td width="220" class="size8">Contestar directamente</td>
          </tr>
          <tr> 
            <td><input type="checkbox" name="Acciones[]" value="7"></td>
            <td class="size8">Coodinar</td>

            <td><input type="checkbox" name="Acciones[]" value="8"></td>
            <td class="size8">Reformular Informe</td>

            <td><input type="checkbox" name="Acciones[]" value="9"></td>
            <td class="size8">Designar representante</td>
          </tr>
          <tr> 
            <td><input type="checkbox" name="Acciones[]" value="10"></td>
            <td class="size8">Tr&aacute;mite correspondiente</td>

            <td><input type="checkbox" name="Acciones[]" value="11"></td>
            <td class="size8">Exposici&oacute;n de Motivos</td>

            <td><input type="checkbox" name="Acciones[]" value="12"></td>
            <td class="size8">Reiterar</td>
          </tr>
          <tr> 
            <td><input type="checkbox" name="Acciones[]" value="13"></td>
            <td class="size8">Opini&oacute;n / Recomendaci&oacute;n</td>

            <td><input type="checkbox" name="Acciones[]" value="14"></td>
            <td class="size8">Ayuda Memoria</td>

            <td><input type="checkbox" name="Acciones[]" value="15"></td>
            <td class="size8">Regularizar</td>
          </tr>
          <tr> 
            <td><input type="checkbox" name="Acciones[]" value="16"></td>
            <td class="size8">Comentarios</td>

            <td><input type="checkbox" name="Acciones[]" value="17"></td>
            <td class="size8">Proyectar Resoluci&oacute;n</td>

            <td><input type="checkbox" name="Acciones[]" value="18"></td>
            <td class="size8">Proceder seg&uacute;n normatividad vigente</td>
          </tr>
          <tr> 
            <td><input type="checkbox" name="Acciones[]" value="19"></td>
            <td class="size8">Correcci&oacute;n</td>

            <td><input type="checkbox" name="Acciones[]" value="20"></td>
            <td class="size8">Visaci&oacute;n</td>

            <td><input type="checkbox" name="Acciones[]" value="21"></td>
            <td class="size8">Proceder seg&uacute;n disponibilidad presupuestal</td>
          </tr>
        	</table>
        </fieldset>
			</td>
			</tr>
			<?php}?>

			<?php if($_POST[cCodTipoDoc]>1){?>
			<tr>
			<td valign="top" >Derivar a:</td>
			<td valign="top" colspan="3">
							<select name="iCodOficina" class="FormPropertReg form-control">
							<option value="">Seleccione:</option>
							<?
							$sqlDep2="SELECT * FROM Tra_M_Oficinas ";
              $sqlDep2.= "ORDER BY cNomOficina ASC";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
              	if($RsDep2["iCodOficina"]==$_POST['iCodOficina']){
              		$selectDep="selected";
              	}Else{
              		$selectDep="";
              	}
                echo "<option value=".$RsDep2["iCodOficina"]." ".$selectDep.">".$RsDep2["cNomOficina"]."</option>";
              }
              mysql_free_result($rsDep2);
							?>
							</select>
			</td>
			</tr>
			<?php}?>

			<tr>
			<td valign="top" >Requiere respuesta:</td>
			<td valign="top" colspan="3">
					<input type="checkbox" name="respuesta" value="1">
			</td>
			</tr>
			
			<tr>
			<td colspan="4"> 
					<input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="Registrar();">
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
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>