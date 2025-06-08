<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<script>
function validar(f) {
 var error = "Por favor, antes de crear complete:\n\n";
 var a = "";
 
  if (f.cNombresTrabajador.value == "") {
  a += " Ingrese Nombre de Trabajador";
  alert(error + a);
 }
 else if (f.cApellidosTrabajador.value == "") {
  a += " Ingrese Apellidos de Trabajador";
  alert(error + a);
 } 

 else if (f.cUsuario.value == "") {
  a += " Ingrese el Usuario";
  alert(error + a);
 }
 else if (f.cPassword.value == "") {
  a += " Ingrese el Password";
  alert(error + a);
 }
 else if (f.txtestado.value == "") {
  a += " Seleccione Estado del Trabajador";
  alert(error + a);
 }
  
 return (a == "");
 
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.form1.cMailTrabajador.value)){
	} else {
		alert("Email incorrecto");
		document.form1.cMailTrabajador.focus();
		return false;
	}

 
}
 
function validarEmail(valor) {
	onclick="validarEmail(this.form1.cMailTrabajador.value);"
if (/^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/.test(valor)){
alert("La dirección de email " + valor + " es correcta.") 
return (true)
} else {
alert("La dirección de email " + valor + " es incorrecta.");
return (false);
}
}
</script>
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

<div class="AreaTitulo">Maestra Usuarios Web</div>

<?
require_once("../models/ad_busqueda.php");
?>

<form action="../controllers/ln_nuevo_trabajador.php" onSubmit="return validar(this)" method="post" name="form1">
<table class="table">
 <tr>
 <td>
 <table border="0" align="center">

            <fieldset id="tfa_DatosPersonales" class="fieldset"  >
            <legend class="legend">Datos Personales</legend>
        <table border="0">
        <tr>              
              <td width="90" >Raz&oacute;n social/Nombre:</td>
              <td width="268" align="left">
                <input name="cNombresTrabajador" type="text" id="cNombresTrabajador"  size="40" class="FormPropertReg form-control" value="<?php $_GET['cNombresTrabajador']; ?>" readonly/>
              </td>
              <td align="center">
                <div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;">
                  <a style=" text-decoration:none" href="javascript:;" 
                     onClick="window.open('listarRemitentes.php','popuppage','width=750,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a>
                </div>
              </td>
           </tr>
           <tr>
              <td width="90" >Documento:</td>
              <td width="268" align="left">
                <input name="identificacion" type="text" id="identificacion"  size="40" class="FormPropertReg form-control"
                       value="<?php echo $_GET['identificacion']; ?>" readonly/>
              </td>
             </tr>
             <tr>                 
              <td width="85" >Nro. Doc.:</td>
              <td width="266" align="left">
                <input name="cNumDocIdentidad" type="text" id="cNumDocIdentidad" value="<?php $_GET['iCodRemitente']; ?>"  
                       maxlength="20" size="40" class="FormPropertReg form-control"
                       onkeypress="if (event.keyCode > 31 && ( event.keyCode < 48 || event.keyCode > 57)) event.returnValue = false;" readonly/>
              </td>
           </tr>
           <tr>
             <td width="90" >Nro Tr&aacute;mite:</td>
             <td width="268" align="left">
                <input type="text" size="40" id="cCodificacion" name="cCodificacion" class="FormPropertReg form-control" value='<?php $_POST[cCodificacion]; ?>' readonly />
              </td>
             <td align="center">
              <div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;">
                <a style=" text-decoration:none" href="javascript:;" 
                   onClick="window.open('listarTramites.php','popuppage','width=750,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a>
              </div>
              </td>
           </tr>
           
           <tr>
              <td width="90" >Estado:</td>
              <td width="268" align="left"><select name="txtestado" class="FormPropertReg form-control" id="txtestado">
                               <option value="" >Seleccione:</option>
                              <? 
			                     if ($Rs[nFlgEstado]==1){
	  	                         echo "<OPTION value=1 selected>Activo</OPTION> ";
		                         }
		                         else{
		                         echo "<OPTION value=1 selected>Activo</OPTION> ";
		                         }
                                 if ($Rs[nFlgEstado]==0){
	  	                         echo "<OPTION value=0>Inactivo</OPTION> ";
		                         }
		                         else{
		                         echo "<OPTION value=0>Inactivo</OPTION> ";
		                             }
	                          ?>    
                              </select>
                              </td>
             </tr>      
            <tr>
              <td colspan="5" align="center">
                <button class="btn btn-primary" type="submit" id="Insert Trabajador" onMouseOver="this.style.cursor='hand'">
                  <table cellspacing="0" cellpadding="0">
                    <tr>
                      <td style=" font-size:10px">
                        <b>Crear</b>&nbsp;&nbsp;
                      </td>
                      <td>
                        <img src="images/page_add.png" width="17" height="17" border="0">
                      </td>
                    </tr>
                  </table>
                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				        <button class="btn btn-primary" type="button" onclick="window.open('iu_trabajadores_externos.php', '_self');" onMouseOver="this.style.cursor='hand'">
                  <table cellspacing="0" cellpadding="0">
                    <tr>
                      <td style=" font-size:10px">
                        <b>Cancelar</b>&nbsp;&nbsp;
                      </td><td><img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
                </td>
           </tr>           
            </table>            
                            </fieldset>
    
     </td>
     <td colspan="4" valign="top">
            <fieldset id="tfa_DatosPersonales" class="fieldset"  >
            <legend class="legend">Datos de Usuario</legend>
            <table border="0"> 
            <tr>
              <td width="85" >Perfil:</td>
              <td width="266" align="left">
                <?php //Consulta para rellenar el combo Perfil
                  $sqlPer = "SELECT * FROM Tra_M_Perfil WHERE cDescPerfil LIKE 'Web' "; 
                  $rsPer  = sqlsrv_query($cnx,$sqlPer);
                  $RsPer  = sqlsrv_fetch_array($rsPer);
                ?>
                <select name="iCodPerfil" class="FormPropertReg form-control" id="iCodPerfil"/>
                  <option value=<?php echo $RsPer["iCodPerfil"]; ?>><?php echo $RsPer["cDescPerfil"]; ?></option>
                </select>
              </td>
           </tr>
           
           <tr>
              <td width="90" >Usuario:</td>
              <td width="268" align="left"><input name="cUsuario" type="text" id="cUsuario"  size="15" class="FormPropertReg form-control" value="<?=$_GET[cUsuario]?>" /><?php if($_GET[cUsuario]!="") echo "*"?></td> <?php if ($mensaje=="1") echo "<script> alert('El Nombre de Usuario ya Existe')</script>" ?>
            </tr>
            <tr> 
              <td width="85" >Password:</td>
              <td width="266" align="left"><input name="cPassword" type="text" id="cPassword" value="<?=$_GET[cPassword]?>" size="15" class="FormPropertReg form-control" /></td>
           </tr>           
        </table>
        </fieldset>
    

</form>

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
