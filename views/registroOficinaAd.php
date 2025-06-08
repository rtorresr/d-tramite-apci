<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Registro de documentos para Oficinas
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
			if (!isset($_SESSION["cCodSession"])){ 
			  $max_chars=round(rand(10,15));  
				$chars=array();
				for($i="a";$i<"z";$i++){
  				$chars[]=$i;
  				$chars[]="z";
				}
				for ($i=0; $i<$max_chars; $i++){
  				$letra=round(rand(0, 1));
  				if ($letra){ 
 						$clave.= $chars[round(rand(0,count($chars)-1))];
  				}else{ 
 						$clave.= round(rand(0, 9));
  				}
				}
    	$_SESSION["cCodSession"]=$clave;
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

<script Language="JavaScript">
<!--

function activaOficina()
{
document.frmRegistro.radioMultiple.checked = false;
document.frmRegistro.radioOficina.checked = true;
document.frmRegistro.radioSeleccion.value="1";
muestra('areaOficina');
document.getElementById('areaMultiple').style.display = 'none';
return false;
}

function activaMultiple()
{
document.frmRegistro.radioMultiple.checked = true;
document.frmRegistro.radioOficina.checked = false;
document.frmRegistro.radioSeleccion.value="2";
muestra('areaMultiple');
document.getElementById('areaOficina').style.display = 'none';
return false;
}

function muestra(nombrediv) {
    if(document.getElementById(nombrediv).style.display == '') {
            document.getElementById(nombrediv).style.display = 'none';
    } else {
            document.getElementById(nombrediv).style.display = '';
    }
}



function Registrar(){
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Clase Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  document.frmRegistro.opcion.value=2;
  document.frmRegistro.action="registroDataEdicion.php";
  document.frmRegistro.submit();
}

function AddOficina(){
	if (document.frmRegistro.iCodOficinaMov.value.length == "")
  {
    alert("Seleccione Oficina");
    document.frmRegistro.iCodOficinaMov.focus();
    return (false);
  }
	if (document.frmRegistro.iCodTrabajadorMov.value.length == "")
  {
    alert("Seleccione Trabajador");
    document.frmRegistro.iCodTrabajadorMov.focus();
    return (false);
  }
	if (document.frmRegistro.iCodIndicacionMov.value.length == "")
  {
    alert("Seleccione Indicaci�n");
    document.frmRegistro.iCodIndicacionMov.focus();
    return (false);
  }  
  document.frmRegistro.opcion.value=3;
  document.frmRegistro.action="registroDataEdicion.php";
  document.frmRegistro.submit();
}

function AddReferencia(){
	if (document.frmRegistro.cReferencia.value.length == "")
  {
    alert("Ingrese Referencia");
    document.frmRegistro.cReferencia.focus();
    return (false);
  }
  document.frmRegistro.opcion.value=21;
  document.frmRegistro.action="registroDataEdicion.php";
  document.frmRegistro.submit();
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
  document.frmRegistro.submit();
}


//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
 
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

<div class="AreaTitulo">Registro - Interno Oficina</div>	
		<table class="table">
			<form name="frmRegistro" method="POST" action="registroDataEdicion.php" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
			<input type="hidden" name="radioSeleccion" value="">
            <input type="hidden" name="nFlgRpta" value="">
            <input type="hidden" name="fFecPlazo" value="">
            
          
		<tr>
		<td class="FondoFormRegistro">
			<table border=0>
			<tr>
			<td valign="top"  width="160">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:200px" />
					<option value="">Seleccione:</option>
					<?
					include_once("../conexion/conexion.php");
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 ORDER BY cDescTipoDoc ASC";
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
			<td  width="160">Fecha  Registro:</td>
			<td>
			<td><input type="text" readonly name="fFecRegistro" value="<?php if($Rs['fFecRegistro']!=""){echo date("d-m-Y G:i", strtotime($Rs['fFecRegistro'])); } else {echo $_REQUEST['fFecRegistro'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
				</tr></table></td>
			</tr>
            <tr>
			    <td valign="top" >N&ordm; del Tramite:</td>
			  <td valign="top" ><input type="text" name="cCodificacion" value="<?=$_REQUEST[cCodificacion]?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
              <td  width="160">Fecha del Documento:</td>
			<td>
			<td><input type="text" readonly name="fFecDocumento" value="<?php if($Rs['fFecDocumento']!=""){echo date("d-m-Y G:i", strtotime($Rs['fFecDocumento'])); } else {echo $_REQUEST['fFecDocumento'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDocumento,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
				</tr></table></td>
			  </tr>
			<tr>
			<td valign="top"  width="150"></td>
			<td valign="top" ></td>
            <td width="114" >Trabajador de Registro:&nbsp;</td>
		          <td width="255" align="left"><select name="iCodTrabajadorRegistro" style="width:340px;" class="FormPropertReg form-control">
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
				   </select>
                    </td>
			</tr>
           	<tr>
			<td valign="top"  width="160">Asunto:</td>
			<td>
            <textarea name="cAsunto" style="width:336px;height:55px" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea>
					&nbsp;&nbsp;
					
			</td>
			<td valign="top"  width="160">Observaciones:</td>
			<td valign="top"><textarea name="cObservaciones" style="width:320px;height:55px" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea>
					
			</td>
			</tr>
			<tr>
				<td valign="top" >Folios:</td>
				<td valign="top"><input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;} else { echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/></td>
				<td valign="top"  width="160">Referencia(s):</td>
				<td valign="top">
					<table border=0><tr>
					<td align="center"><input type="text" name="cReferencia" value="<?=$_POST[cReferencia]?>" class="FormPropertReg form-control" style="width:100px;text-transform:uppercase" />
                    <input type="hidden" name="iCodTramiteRef"  value="<?=$_POST[iCodTramiteRef]?>"  /></td>
					<td align="center"><div class="btn btn-primary" style="width:50px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="AddReferencia();">A�adir</a> </div></td>
					<td align="center" style="width:25px" /></td>
					<td align="center"><div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar Registro</a> </div></td>
					</tr></table>
					<table border=0><tr><td>
						<?
						$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodSession]'";
          	$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
						?>
						<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?><a href="registroDataEdicion.php?&iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=19&radioSeleccion=<?=$_POST[radioSeleccion]?>&cCodificacion=<?=$_POST[cCodificacion]?>&fFecDocumento=<?=$_POST['fFecDocumento']?>&fFecRegistro=<?=$_POST['fFecRegistro']?>&iCodTrabajadorRegistro=<?=$_POST[iCodTrabajadorRegistro]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="13" height="13"></a></span>&nbsp;
						<?php}?>
					 
							
				</td>
			</tr>			
			<tr>
				<td valign="top" >Adjuntar Archivo:</td>
				<td valign="top" colspan="3"><input type="file" name="fileUpLoadDigital" class="FormPropertReg form-control" style="width:400px;" /></td>
			</tr>

			<tr>
			<td valign="top" >Enviar inmediatamente:</td>
			<td valign="top">
					<input type="checkbox" name="nFlgEnvio" value="1" <?php if($_POST[nFlgEnvio]==1) echo "checked"?>>
			</td>
			<td valign="top"  >Sigla Autor:</td>
			<td valign="top"><input type="text" style="text-transform:uppercase" name="cSiglaAutor" value="<?=$_POST[cSiglaAutor]?>" class="FormPropertReg form-control" style="width:60px;" /></td>
			</tr>
			
			<tr>
			<td valign="top" >Destino:</td>
			<td colspan="3" align="left">
				
					<table border=0><tr>
          <td valign="top"><input type="radio" name="radioOficina" onclick="activaOficina();" <?php if($_POST[radioSeleccion]==1) echo "checked"?> onChange="releer();">Un Destino</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td valign="top"><input type="radio" name="radioMultiple" onclick="activaMultiple();" <?php if($_POST[radioSeleccion]==2) echo "checked"?> onChange="releer();">M�ltiple</td>
					</tr></table>				
				
					<div style="display:none" id="areaOficina">
							<table border=0>
							<tr>
							<td>
									<select name="iCodOficinaMov" style="width:280px;" class="FormPropertReg form-control" onChange="releer();">
									<option value="">Seleccione Oficina:</option>
									<?
									$sqlDep2="SP_OFICINA_LISTA_COMBO";
          		    $rsDep2=sqlsrv_query($cnx,$sqlDep2);
          		    while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
          		    	if($RsDep2['iCodOficina']==$_POST[iCodOficinaMov]){
          		    		$selecOfi="selected";
          		    	}Else{
          		    		$selecOfi="";
          		    	}
          		      echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
          		    }
          		    mysql_free_result($rsDep2);
									?>
									</select>
							</td>
							<td>
									<select name="iCodTrabajadorMov" style="width:220px;" class="FormPropertReg form-control">
									<?php if($_POST[iCodOficinaMov]==""){?>
									<option value="">Seleccione Trabajador:</option>
									<?php}?>
									<?
									$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$_POST[iCodOficinaMov]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
          		    $rsTrb=sqlsrv_query($cnx,$sqlTrb);
          		    while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
          		    	if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorResponsable]){
          		    		$selecTrab="selected";
          		    	}Else{
          		    		$selecTrab="";
          		    	}
          		      echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
          		    }
          		    sqlsrv_free_stmt($rsTrb);
									?>
									</select>
							</td>
							<td>
									<select name="iCodIndicacionMov" style="width:200px;" class="FormPropertReg form-control">
									<option value="">Seleccione Indicaci�n:</option>
									<?
									$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
          		    $sqlIndic .= "ORDER BY cIndicacion ASC";
          		    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
          		    while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
          		    	if($RsIndic[iCodIndicacion]==$_POST[iCodIndicacionMov]){
          		    		$selecIndi="selected";
          		    	}Else{
          		    		$selecIndi="";
          		    	}              	
          		      echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
          		    }
          		    sqlsrv_free_stmt($rsIndic);
									?>
									</select>
							</td>
							<td>
									<select name="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
          		    <option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
          		    <option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
          		    <option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
          		    </select>
							</td>
							<td>
									<input name="button" type="button" class="btn btn-primary" value="A�adir" onclick="AddOficina();">
							</td>
							</tr>
							</table>
					</div>

					<div style="display:none" id="areaMultiple">
							<table><tr>
							<td align="center"><div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="registroOficinaLs.php?cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&iCodTrabajadorSolicitado=<?=$_POST[iCodTrabajadorSolicitado]?>&cReferencia=<?=$_POST[cReferencia]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nFlgRpta=<?=$_POST[nFlgRpta]?>&nNumFolio=<?=$_POST[nNumFolio]?>&fFecPlazo=<?=$_POST[fFecPlazo]?>" rel="lyteframe" title="Lista de Oficinas" rev="width: 500px; height: 550px; scrolling: auto; border:no">Seleccionar Oficinas</a> </div></td>
							</tr></table>
					</div>					
			
		</td>
		</tr>

				<?php if($_POST[radioSeleccion]==1){?>
					 <script language="javascript" type="text/javascript">
					 	activaOficina();
					 </script>
				<?php}?>
				<?php if($_POST[radioSeleccion]==2){?>
					 <script language="javascript" type="text/javascript">
					 	activaMultiple();
					 </script>
				<?php}?>
		
		<tr>
		<td colspan="4" align="center">
					
					<table border="1" width="1000">
					<tr>
					<td class="headColumnas">Oficina</td>
					<td class="headColumnas">Trabajador</td>
					<td class="headColumnas">Indicacion</td>
					<td class="headColumnas">Prioridad</td>
                    <td class="headColumnas">Copia</td>
					<td class="headColumnas">Opcion</td>
					</tr>
					<?
					$sqlMovs="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSession]' ORDER BY iCodTemp ASC";
          $rsMovs=sqlsrv_query($cnx,$sqlMovs);
          while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
					?>
					<tr>
					<td align="left">
					<?
					$sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs['iCodOficina']'";
          $rsOfc=sqlsrv_query($cnx,$sqlOfc);
          $RsOfc=sqlsrv_fetch_array($rsOfc);
          echo $RsOfc["cNomOficina"];
					?>
					</td>
					<td align="left">
						<?
						$sqlTra="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMovs[iCodTrabajador]' ";
            $rsTra=sqlsrv_query($cnx,$sqlTra);
						$RsTra=sqlsrv_fetch_array($rsTra);
            echo $RsTra["cNombresTrabajador"]." ".$RsTra["cApellidosTrabajador"];
						?>
					</td>
					<td align="left">
						<?
						$sqlInd="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsMovs[iCodIndicacion]'";
            $rsInd=sqlsrv_query($cnx,$sqlInd);
            $RsInd=sqlsrv_fetch_array($rsInd);
            echo $RsInd["cIndicacion"];
						?>
					</td>
					<td align="left">
						<?=$RsMovs[cPrioridad]?>
					</td>
                     <td>
                    <input type="checkbox" 	name="Copia[]"  value="<?=$RsMovs[iCodTemp]?>"/>
                    </td>
					<td align="center">
						<a href="registroDataEdicion.php?iCodTemp=<?=$RsMovs[iCodTemp]?>&opcion=6&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cCodificacion=<?=$_POST[cCodificacion]?>&fFecDocumento=<?=$_POST['fFecDocumento']?>&fFecRegistro=<?=$_POST['fFecRegistro']?>&iCodTrabajadorRegistro=<?=$_POST[iCodTrabajadorRegistro]?>&iCodTrabajadorSolicitado=<?=$_POST[iCodTrabajadorSolicitado]?>&cReferencia=<?=$_POST[cReferencia]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&iCodIndicacion=<?=$_POST[iCodIndicacion]?>&nFlgRpta=<?=$_POST[nFlgRpta]?>&nNumFolio=<?=$_POST[nNumFolio]?>&fFecPlazo=<?=$_POST[fFecPlazo]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="16" height="16"></a>
					</td>
					</tr>
					<?
          }
					?>
				
					</table>
			</td>
			</tr>			
			
			<tr>
			<td colspan="4"> 
					<input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="Registrar();">
			</td>
			</tr>
			</table>
		</td>
		</tr>
        </form>
		</table>
		
</div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>