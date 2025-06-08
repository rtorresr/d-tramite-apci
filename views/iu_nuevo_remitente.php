<?php
$query=$_GET["query"];
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
  include_once("../conexion/conexion.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script Language="JavaScript">
<!--
function ocultar(query)
{

if(query="abrir")
{
//document.getElementById("reloj").innerHTML=diames+"/"+mes+"/"+anio +" " + horas+":"+minutos+":"+segundos;
//document.getElementsByName("t2")
//documetn.form1.button
var control=document.getElementsByName("button")
control.value="Regresar";
//self.close()
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
  document.form1.txtnom_remitente.focus();
  alert(error + a);
 } 
 else if (f.txtdirec_remitente.value == "") {
  a += " Ingrese Direccion del Remitente";
  document.form1.txtdirec_remitente.focus();
  alert(error + a);
 } 
 
 return (a == "");
 
}
 
//--></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body >

<div id ="registro" style="width:1088px; height:auto; overflow:hidden">

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

<form action="../controllers/ln_nuevo_remitente.php" onSubmit="return validar(this)" method="post" name="form1">

  <tr>
      <td colspan="4">
            <fieldset id="tfa_DatosPersonales" class="fieldset"  >
            <legend >Datos Remitente</legend>
        <table border="0">
           <tr>
              <td width="114" height="32"></td>
              <td width="90" >Tipo Persona:</td>
              <td width="15"></td>
              <td width="420" align="left">
              <select name="tipo_persona" class="FormPropertReg form-control" id="tipo_persona" style="width:147px" />
                <option value="" selected="selected">Seleccione:</option>
                  <?php 
                    $sqlPer = "SELECT DISTINCT cTipoPersona FROM Tra_M_Remitente"; 
                                $rsPer=sqlsrv_query($cnx,$sqlPer);
								
	                         while ($RsPer=sqlsrv_fetch_array($rsPer)){
								 if($RsPer["cTipoPersona"]==$_POST[tipo_persona]){
          		                    $selecPer="selected";
								}else{
									$selecPer="";
								}
								 if($RsPer["cTipoPersona"]==1){
									echo "<option value=".$RsPer["cTipoPersona"]." ".$selecPer.">Persona Natural</option>";
								 }
								 else{
									echo "<option value=".$RsPer["cTipoPersona"]." ".$selecPer.">Persona Juridica</option>";
									 }    
	   	                   }
							 sqlsrv_free_stmt($rsPer);
						  ?>
		                     </select>
              </td>
           </tr>
           <tr>
              <td width="114"></td>
              <td width="90" >Nombre:</td>
              <td width="15"></td>
              <input name="txtnom_remitente"  style="text-transform:uppercase" type="text"  id="txtnom_remitente" value="<?=$_POST[txtnom_remitente]?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

             <td >Sigla:</td>

             <td align="left"><input name="cSiglaRemitente" style="text-transform:uppercase" type="text"  id="cSiglaRemitente" value="<?=$_POST[cSiglaRemitente]?>" maxlength="120" size="70" class="FormPropertReg form-control" /></td>
           </tr>
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
	  	                         if($RsDoc["cTipoDocIdentidad"]==$_POST[cTipoDocIdentidad]){
          		                 $selecClas="selected";
          	                     }Else{
          		                 $selecClas="";
          	                          }
                                 echo "<option value=".$RsDoc["cTipoDocIdentidad"]." ".$selecClas.">".$RsDoc["cDescDocIdentidad"]."</option>";
                                 }
                                 sqlsrv_free_stmt($rsDoc);
                              ?>
		                         </select>                              </td>
           <tr>

              <td >Nro. Documento:</td>

              <td  align="left"><input name="txtnum_documento" type="text" id="txtnum_documento" value="<?=$_POST[txtnum_documento]?>" size="40" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/></td>
           </tr>
           <tr>

              <td >Direcci&oacute;n:</td>

              <td  align="left"><input name="txtdirec_remitente" type="text" id="txtdirec_remitente" value="<?=$_POST[txtdirec_remitente]?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >E-mail:</td>

              <td align="left"><input name="txtmail" type="text" id="txtmail" value="<?=$_POST[txtmail]?>" size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Telefono:</td>

              <td align="left"><input name="txtfono_remitente" type="text" id="txtfono_remitente" value="<?=$_POST[txtfono_remitente]?>" size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Fax:</td>

              <td align="left"><input name="txtfax_remitente" type="text" id="txtfax_remitente" value="<?=$_POST[txtfax_remitente]?>"  size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Departamento:</td>

              <td align="left"><?php
     $sqlDep="select * from Tra_U_Departamento ";
                     $rsDep=sqlsrv_query($cnx,$sqlDep);
	              ?>
                     <select name="cCodDepartamento" class="FormPropertReg form-control" id="cCodDepartamento" style="width:236px" onChange="releer();"/>
     	             <option value="">Seleccione:</option>
	              <? while ($RsDep=sqlsrv_fetch_array($rsDep)){
	  	             if($RsDep["cCodDepartamento"]==$_POST[cCodDepartamento]){
          		     $selecClas="selected";
          	         }else{
          		     $selecClas="";
          	         }
                     echo "<option value=".$RsDep["cCodDepartamento"]." ".$selecClas.">".$RsDep["cNomDepartamento"]."</option>";
                     }
                     sqlsrv_free_stmt($rsDep);
                  ?>
		             </select></td>
           </tr>
           <tr>

              <td >Provincia:</td>

              <td align="left"><?php
     $sqlPro="SELECT * from Tra_U_Provincia ";
                     $sqlPro.=" WHERE  cCodDepartamento like '$_POST[cCodDepartamento]' ";
                     $rsPro=sqlsrv_query($cnx,$sqlPro);
                     //echo $sqlPro;
	              ?>
                     <select name="cCodProvincia"  class="FormPropertReg form-control" id="cCodProvincia" onChange="releer();" style="width:236px" <?php if($_POST[cCodDepartamento]=="") echo "disabled"?> >
     	             <option value="">Seleccione:</option>
	              <? while ($RsPro=sqlsrv_fetch_array($rsPro)){
	  	             if($RsPro["cCodProvincia"]==$_POST[cCodProvincia]){
          		     $selecClas="selected";
          	         }else{
          		     $selecClas="";
          	              }
                     echo "<option value=".$RsPro["cCodProvincia"]." ".$selecClas.">".$RsPro["cNomProvincia"]."</option>";
                          }
                     sqlsrv_free_stmt($rsPro);
			      ?>
                     </select></td>
           </tr>
           <tr>

              <td >Distrito:</td>

              <td align="left"><?php
     $sqlDis="SELECT * from Tra_U_Distrito ";
                     $sqlDis.=" WHERE cCodDepartamento like '$_POST[cCodDepartamento]' ";
                     $sqlDis.=" AND cCodProvincia like '$_POST[cCodProvincia]'"; 
                     $rsDis=sqlsrv_query($cnx,$sqlDis);
                     //echo $sqlDis;
	              ?>
                     <select name="cCodDistrito" class="FormPropertReg form-control" id="cCodDistrito" style="width:236px" <?php if($_POST[cCodProvincia]=="" || $_POST[cCodDepartamento]=="" ) echo "disabled"?> />
     	             <option value="">Seleccione:</option>
	              <? while ($RsDis=sqlsrv_fetch_array($rsDis)){
	  	    	  	 if($RsDis["cCodProvincia"]==$_POST[cCodProvincia]){
          		     $selecClas="selected";
          	         }else{
          		     $selecClas="";
          	              }
                     echo "<option value=".$RsDis["cCodDistrito"]." ".$selecClas.">".$RsDis["cNomDistrito"]."</option>";
                                                             }
                     sqlsrv_free_stmt($rsDis);
                  ?>
                     </select></td>
           </tr>
            
           <tr>

              <td >Representante:</td>

              <td align="left"><input name="txtrep_remitente" type="text" id="txtrep_remitente" value="<?=$_POST[txtrep_remitente]?>" size="40" class="FormPropertReg form-control" v></td>
           </tr>
		 
           <tr>

              <td >Estado:</td>

              <td align="left">
              <?
  
  $arreglo=array(array("COD"=>1,"VALUE"=>"Activo"),array("COD"=>2,"VALUE"=>"Inactivo"));
  
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
         
           </tr>
           <tr>
               <td height="30" colspan="4" align="center">
                <button class="btn btn-primary"  type="submit" id="Insert Remitente" onMouseOver="this.style.cursor='hand'"> <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0"> </button>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="btn btn-primary" type="button" onclick="window.open('iu_remitentes.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
               </td>
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

<?php include("includes/userinfo.php");?>
</div>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
