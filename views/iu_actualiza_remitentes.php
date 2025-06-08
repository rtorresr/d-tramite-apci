<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_actualiza_remitentes.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Mantenimiento de la Tabla Maestra de Remitentes para el Perfil Administrador
          -> Actualizar Registro de Remitentes
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creaci�n del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script Language="JavaScript">
<!--
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getState(departamentoId) {		
		
		var strURL="iu_provincia.php?departamento="+departamentoId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('statediv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getCity(departamentoId,provinciaId) {		
		var strURL="iu_distrito.php?departamento="+departamentoId+"&provincia="+provinciaId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('citydiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}

function releer(){
  document.form1.action="<?=$_SERVER['PHP_SELF']?>";
  document.form1.submit();
}

function validar(f) {
 var error = "Por favor, antes de crear complete:\n\n";
 var a = "";
 
  if (f.tipo_persona.value == "") {
  a += " Ingrese Tipo de Persona";
  alert(error + a);
 } 
 else if (f.txtnom_remitente.value == "") {
  a += " Ingrese Nombre de Remitente";
  alert(error + a);
 } 
 return (a == "");
 
}
 
//--></script>
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

<div class="AreaTitulo">Maestra Remitentes</div>

<?
require_once("../models/ad_busqueda.php");
?>
<form action="../controllers/ln_actualiza_remitente.php" onSubmit="return validar(this)" method="POST" name="form1">
<input type="hidden" name="iCodRemitente" value="<?=$Rs[iCodRemitente]?>">

  <tr>
      <td colspan="4">
            <fieldset id="tfa_DatosPersonales" class="fieldset"  >
            <legend class="legend">Datos Remitente</legend>
        <table border="0">
           <tr>
              <td width="114"></td>
              <td width="90" >Tipo Persona:</td>
              <td width="15"></td>
              <td width="420" align="left"><select name="tipo_persona" class="FormPropertReg form-control" id="tipo_persona" style="width:147px">
						  <?php
if($Rs['cTipoPersona']==1){
			                echo "<option value='01' selected>Persona Natural</option>";
		                                            }
		                    else{
			                echo "<option value='01' >Persona Natural</option>";
		                        }
		                    if($Rs['cTipoPersona']==2){	
			                echo "<option value='02' selected>Persona Juridica</option>";
		                                            }
		                    else{
			                echo "<option value='02' >Persona Juridica</option>";
		                        }
						  ?>
		                      </select>              </td>
           </tr>
           <tr>
              <td width="114"></td>
              <td width="90" >Nombre:</td>
              <td width="15"></td>
              <td width="420"  align="left"><input name="txtnom_remitente" type="text" id="txtnom_remitente" value="<?php echo trim($Rs['cNombre']); ?>"  value="<?php echo (isset($_POST['txtnom_remitente'])) ? $_POST['txtnom_remitente'] : ''; ?>"  maxlength="120" size="70" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

             <td >Sigla</td>

             <td align="left"><input name="cSiglaRemitente" type="text"  id="cSiglaRemitente" value="<?php echo trim($Rs[cSiglaRemitente]); ?>" maxlength="120" size="70" class="FormPropertReg form-control" /></td>
           </tr>
            <tr>
            <td width="114"></td>
              <td width="90" >Documento:</td>
              <td width="15"></td>
              <td width="420" align="left">
              		<?php
  $sqlDoc="SP_DOC_IDENTIDAD_LISTA_COMBO ";
                  $rsDoc=sqlsrv_query($cnx,$sqlDoc);
	                ?>
              		<select name="cTipoDocIdentidad" class="FormPropertReg form-control" id="cTipoDocIdentidad"  />
            		  
              		<option value="">Seleccione:</option>
	                <? while ($RsDoc=sqlsrv_fetch_array($rsDoc)){
	  	                         if($RsDoc["cTipoDocIdentidad"]==$Rs[cTipoDocIdentidad]){
          		                 $selecClas="selected";
          	                     }Else{
          		                 $selecClas="";
          	                          }
                                 echo "<option value=".$RsDoc["cTipoDocIdentidad"]." ".$selecClas.">".$RsDoc["cDescDocIdentidad"]."</option>";
                                 }
                                 sqlsrv_free_stmt($rsDoc);
                              ?>
		                         </select>                              </td>
              </tr> 
           <tr>

              <td >Nro. Documento:</td>

              <td align="left"><input name="txtnum_documento" type="text" id="txtnum_documento" value="<?php echo trim($Rs['nNumDocumento']); ?>" size="40" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/></td>
           </tr>
           <tr>

              <td >Direccion:</td>

              <td align="left"><input name="cDireccion" type="text" id="cDireccion" value="<?php echo trim($Rs[cDireccion]); ?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >E-mail:</td>

              <td align="left"><input name="txtmail" type="text" id="txtmail" value="<?php echo trim($Rs[cEmail]); ?>" size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Telefono:</td>

              <td align="left"><input name="txtfono_remitente" type="text" id="txtfono_remitente" value="<?php echo trim($Rs[nTelefono]); ?>" size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Fax:</td>

              <td align="left"><input name="txtfax_remitente" type="text" id="txtfax_remitente" value="<?php echo trim($Rs[nFax]); ?>" size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Departamento:</td>

              <td align="left">
			  			<?
              $sqlDep="select * from Tra_U_Departamento order by cCodDepartamento "; 
              $rsDep=sqlsrv_query($cnx,$sqlDep);
              ?>
                   <select name="cCodDepartamento" onchange="getState(this.value)" style="width:236px"><option>Seleccione:</option>
              <?   while ($RsDep=sqlsrv_fetch_array($rsDep)){
			         if($RsDep["cCodDepartamento"]==$Rs[cDepartamento]){
          		     $selecDep="selected";
          	         }else{
          		     $selecDep="";
          	         }
                   echo "<option value='$RsDep[cCodDepartamento]' >".$RsDep[cNomDepartamento]."</option>";
                   }
                   sqlsrv_free_stmt($rsDep);
              ?>
                   </select>
			  </td>
           </tr>
           <tr>

              <td >Provincia:</td>

              <td align="left">
               <p id="statediv">
               <select  name="cCodProvincia" <?php if($_POST[cCodDepartamento]=="") echo "disabled"?> style="width:236px">
                  <option>Seleccione:</option>
               </select></td>
           </tr>
           <tr>

              <td >Distrito:</td>

              <td align="left">
			   <p id="citydiv"> 
               <select  name="cCodDistrito" <?php if($_POST[cCodProvincia]=="") echo "disabled"?> style="width:236px">
                  <option>Seleccione:</option>       
               </select>
			</td>
           </tr>
           <tr>

              <td >Representante:</td>

              <td align="left"><input name="txtrep_remitente" type="text" id="txtrep_remitente" value="<?php echo trim($Rs[cRepresentante]); ?>" size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Estado:</td>

              <td align="left">
           <?   $arreglo=array(array("COD"=>1,"VALUE"=>"Activo"),array("COD"=>2,"VALUE"=>"Inactivo"));
  
  ?>
  <select name="txtflg_estado" id="txtflg_estado" class="FormPropertReg form-control" >
   		
   	<? for($i=0;$i<2;$i++){ 
    	if($_POST["txtflg_estado"]==$arreglo[$i]["COD"]){  
		?>
    <option value="<?php echo $arreglo[$i]["COD"] ?>" selected><?php echo $arreglo[$i]["VALUE"] ?></option>
    <?
    	}
	
    	else{ ?>
    <option value="<?php echo $arreglo[$i]["COD"] ?>"><?php echo $arreglo[$i]["VALUE"] ?></option>
    
     <?
     		}
		}
	 ?>
     </select>
     </td>
           </tr>
           <tr>
               <td colspan="4" align="center">
               <button class="btn btn-primary"  type="submit" id="Actualizar Remitente" onMouseOver="this.style.cursor='hand'"> <b>Actualizar</b> <img src="images/page_refresh.png" width="17" height="17" border="0"> </button>
               ������
				<button class="btn btn-primary" type="button" onclick="window.open('iu_remitentes.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>               </td>
           </tr>
       </table>
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

</form>  
</td>
		</tr>
		</table>
      

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
