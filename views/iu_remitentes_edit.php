<?php
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
function releer(){
  document.form1.action="<?=$_SERVER['PHP_SELF']?>?iCodRemitente=<?=$_GET[iCodRemitente]?>&clear=1";
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
$sql= "select * from Tra_M_Remitente where iCodRemitente=".$_GET[iCodRemitente];
$rs=sqlsrv_query($cnx,$sql);
$Rs=sqlsrv_fetch_array($rs);
?>
<form action="iu_remitentes_data.php" onSubmit="return validar(this)" method="POST" name="form1">
<input type="hidden" name="iCodRemitente" value="<?=$_GET[iCodRemitente]?>">
<input type="hidden" name="opcion" value="2">

  <tr>
      <td colspan="4">
            <fieldset id="tfa_DatosPersonales" class="fieldset"  >
            <legend class="legend">Datos Remitente</legend>
        <table border="0">
           <tr>
              <td width="114" height="32"></td>
              <td width="90" >Tipo Persona:</td>
              <td width="15"></td>
              <td width="420" align="left">
              	<?
              	if($_GET[clear]==""){
              		$cTipoPersona=$Rs['cTipoPersona'];
              	}Else{
              		$cTipoPersona=$_POST['cTipoPersona'];
              	}
              	?>
              	<select name="cTipoPersona" class="FormPropertReg form-control" id="cTipoPersona" style="width:147px">
              	<option value='1' <?php if($cTipoPersona==1) echo "selected"?>>Persona Natural</option>
              	<option value='2' <?php if($cTipoPersona==2) echo "selected"?>>Persona Juridica</option>
		            </select>
		          </td>
           </tr>
          <tr>
            <td width="114"></td>
            <td width="90" >Nombre:</td>
            <td width="15"></td>
            <td width="420"  align="left"><input name="cNombre" style="text-transform:uppercase" type="text" id="cNombre" value="<?php if($_GET[clear]==""){ echo trim($Rs['cNombre']); }Else{ echo $_POST['cNombre']; }?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
          </tr>
          <tr>

            <td >Sigla:</td>

            <td align="left">
              <input name="cSiglaRemitente" style="text-transform:uppercase" type="text" id="cSiglaRemitente" 
                     value="<?php if($_GET[clear]==""){ echo trim($Rs[cSiglaRemitente]); }else{ echo $_POST[cSiglaRemitente]; }?>" maxlength="120" size="20" class="FormPropertReg form-control" />
            </td>
          </tr>
          <tr>
            <td width="114"></td>
            <td width="90" >Documento:</td>
            <td width="15"></td>
            <td width="420" align="left">
            <?php 
              $sqlDoc = "SELECT * FROM Tra_M_Doc_Identidad"; 
              $rsDoc  = sqlsrv_query($cnx,$sqlDoc);
            ?>
              <select name="cTipoDocIdentidad" class="FormPropertReg form-control" id="cTipoDocIdentidad"  />
                <option value="">Seleccione:</option>
                  <?php
                    while ($RsDoc=sqlsrv_fetch_array($rsDoc)){
                      if($_GET[clear]==""){
                        if($RsDoc["cTipoDocIdentidad"]==$Rs[cTipoDocIdentidad]){
                          $selecClas = "selected";
                        }else{
                          $selecClas="";
                        }
                      }else{
												if($RsDoc["cTipoDocIdentidad"]==$_POST[cTipoDocIdentidad]){
          		      			$selecClas="selected";
                        }else{
                          $selecClas="";
          	        		}
                      }
                      echo "<option value=".$RsDoc["cTipoDocIdentidad"]." ".$selecClas.">".$RsDoc["cDescDocIdentidad"]."</option>";
                    }
                    sqlsrv_free_stmt($rsDoc);
                  ?>
              </select>
		        </td>
          </tr> 
          <tr>

              <td >Nro. Documento:</td>

              <td align="left"><input name="nNumDocumento" type="text" id="nNumDocumento" value="<?php if($_GET[clear]==""){ echo trim($Rs['nNumDocumento']); }Else{ echo $_POST['nNumDocumento']; }?>" size="20" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/></td>
           </tr>
           <tr>

              <td >Direcci&oacute;n:</td>

              <td align="left"><input name="cDireccion" type="text" id="cDireccion" value="<?php if($_GET[clear]==""){ echo trim($Rs[cDireccion]); }Else{ echo $_POST[cDireccion]; }?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >E-mail:</td>

              <td align="left"><input name="cEmail" type="text" id="cEmail" value="<?php if($_GET[clear]==""){ echo trim($Rs[cEmail]); }Else{ echo $_POST[cEmail]; }?>" size="40" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Telefono:</td>

              <td align="left"><input name="nTelefono" type="text" id="nTelefono" value="<?php if($_GET[clear]==""){ echo trim($Rs[nTelefono]); }Else{ echo $_POST[nTelefono]; }?>" size="15" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Fax:</td>

              <td align="left"><input name="nFax" type="text" id="nFax" value="<?php if($_GET[clear]==""){ echo trim($Rs[nFax]); }Else{ echo $_POST[nFax]; }?>" size="15" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Departamento:</td>

              <td align="left">
                  <select name="cDepartamento" style="width:236px" onChange="releer();" class="FormPropertReg form-control">
                  <option value="">Seleccione:</option>
              		<?
              		$sqlDep="select * from Tra_U_Departamento order by cCodDepartamento "; 
                  $rsDep=sqlsrv_query($cnx,$sqlDep);
              		while ($RsDep=sqlsrv_fetch_array($rsDep)){
			         				if($_GET[clear]==""){
			         						if($RsDep["cCodDepartamento"]==trim($Rs[cDepartamento])){
          		     					$selecDep="selected";
          	         			}else{
          		     					$selecDep="";
          	         			}
          	         			$cDepartamento=trim($Rs[cDepartamento]);
          	         			
          	         	}Else{
			         						if($RsDep["cCodDepartamento"]==$_POST[cDepartamento]){
          		     					$selecDep="selected";
          	         			}else{
          		     					$selecDep="";
          	         			}
          	         			$cDepartamento=$_POST[cDepartamento];
          	         	}
                   		echo "<option value=\"".$RsDep[cCodDepartamento]."\" ".$selecDep.">".$RsDep[cNomDepartamento]."</option>";
                  }
                  sqlsrv_free_stmt($rsDep);
              		?>
                  </select>
			  </td>
           </tr>
           <tr>

              <td >Provincia:</td>

              <td align="left">
									<select name="cProvincia" style="width:236px" onChange="releer();" class="FormPropertReg form-control">
									<option>Seleccione:</option>
									<?
									$sqlPro="SELECT * from Tra_U_Provincia WHERE cCodDepartamento='$cDepartamento' order by cNomProvincia ";
									$rsPro=sqlsrv_query($cnx,$sqlPro);
									while ($RsPro=sqlsrv_fetch_array($rsPro)){
			         				if($_GET[clear]==""){
			         						if($RsPro["cCodProvincia"]==trim($Rs[cProvincia])){
          		     					$selecPrv="selected";
          	         			}else{
          		     					$selecPrv="";
          	         			}
          	         			$cProvincia=trim($Rs[cProvincia]);
          	         	}Else{
			         						if($RsPro["cCodProvincia"]==$_POST[cProvincia]){
          		     					$selecPrv="selected";
          	         			}else{
          		     					$selecPrv="";
          	         			}
          	         			$cProvincia=$_POST[cProvincia];
          	         	}									
											echo "<option value=".$RsPro[cCodProvincia]." ".$selecPrv.">".$RsPro[cNomProvincia]."</option>";
									} 
									sqlsrv_free_stmt($rsPro);
									?>
									</select>
           </td>
           </tr>
           <tr>

              <td >Distrito:</td>

              <td align="left">
									<select name="cDistrito" style="width:236px" class="FormPropertReg form-control">
								 	<option>Seleccione:</option>
								  <?
								  $sqlDis="SELECT * from Tra_U_Distrito WHERE cCodDepartamento='$cDepartamento' AND cCodProvincia='$cProvincia' order by cNomDistrito "; 
									$rsDis=sqlsrv_query($cnx,$sqlDis);
								  while ($RsDis=sqlsrv_fetch_array($rsDis)){
								  		if($_GET[clear]==""){
			         						if($RsDis["cCodDistrito"]==trim($Rs[cDistrito])){
          		     					$selecDist="selected";
          	         			}else{
          		     					$selecDist="";
          	         			}
          	         	}Else{
			         						if($RsDis["cCodDistrito"]==$_POST[cDistrito]){
          		     					$selecDist="selected";
          	         			}else{
          		     					$selecDist="";
          	         			}
          	         	}	
										echo "<option value=\"".$RsDis[cCodDistrito]."\" ".$selecDist.">".$RsDis[cNomDistrito]."</option>";
								  } 
									sqlsrv_free_stmt($rsDis);
									?>
								</select>
			</td>
           </tr>
           <tr>

              <td >Representante:</td>

              <td align="left"><input name="cRepresentante" type="text" id="cRepresentante" value="<?php if($_GET[clear]==""){ echo trim($Rs[cRepresentante]); }Else{ echo $_POST[cRepresentante]; }?>" size="30" class="FormPropertReg form-control"></td>
           </tr>
           <tr>

              <td >Estado:</td>

              <td align="left">
              		<?
              		if($_GET[clear]==""){
              			$cFlag=$Rs[cFlag];
              		}Else{
              			$cFlag=$_POST[cFlag];
              		}
              		?>
           				<select name="cFlag" id="txtflg_estado" class="FormPropertReg form-control" >
   								<option value="1" <?php if($cFlag==1) echo "selected"?>>Activo</option>
   								<option value="2" <?php if($cFlag==2) echo "selected"?>>Inactivo</option>
    							</select>
     					</td>
           </tr>
           <tr>
               <td height="33" colspan="4" align="center">
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
      
<div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
