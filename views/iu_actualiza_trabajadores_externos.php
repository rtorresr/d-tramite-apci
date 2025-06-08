<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR']!=""){
	include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include("includes/head.php"); ?>
	<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>


	<?php include("includes/menu.php"); ?>
</td>
</tr>
<tr>
	<td><img width="1088" height="11" src="images/pcm_6.jpg" border="0"></td>
</tr>

<tr>



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

<div class="AreaTitulo">Maestra Actualiza Usuarios Web</div>


<?php
  $sql = "SELECT * FROM Tra_M_Trabajadores TT 
          INNER JOIN Tra_M_Remitente TR ON LTRIM(RTRIM(TT.cNumDocIdentidad)) = LTRIM(RTRIM(TR.nNumDocumento)) 
          WHERE TT.iCodTrabajador>0 AND TT.ES_EXTERNO = 1 AND TT.nFlgEstado IN (1,0) AND TT.iCodTrabajador = $_GET[cod]";
  $rs  = sqlsrv_query($cnx,$sql);
  $Rs  = sqlsrv_fetch_array($rs);
?>

<form action="../controllers/ln_actualiza_trabajador.php" method="post" name="form1" enctype="multipart/form-data">
  <input type="hidden" name="iCodTrabajador"        value="<?=$Rs[iCodTrabajador];?>">
  <input type="hidden" name="cNombreTrabajadorx" 	value="<?=$cNombreTrabajador?>">
  <input type="hidden" name="cApellidosTrabajadorx" value="<?=$cApellidosTrabajador?>">
  <input type="hidden" name="cTipoDocIdentidadx"	value="<?=$cTipoDocIdentidad?>">
  <input type="hidden" name="cNumDocIdentidadx" 	value="<?=$cNumDocIdentidad?>">
  <input type="hidden" name="iCodOficinax"			value="<?=$iCodOficina?>">
  <input type="hidden" name="iCodPerfilx" 			value="<?=$iCodPerfil?>">
  <input type="hidden" name="iCodCategoriax" 		value="<?=$iCodCategoria?>">
  <input type="hidden" name="txtestadox" 			value="<?=$txtestado?>">
  <input type="hidden" name="pagx" 					value="<?=$pag?>">

<?php
  $cNombreTrabajador    = $_GET[cNombreTrabajador];
  $cApellidosTrabajador = $_GET[cApellidosTrabajador];
  $cTipoDocIdentidad    = $_GET[cTipoDocIdentidad];
  $cNumDocIdentidad     = $_GET[cNumDocIdentidad];
  $iCodOficina          = $_GET['iCodOficina'];
  $iCodPerfil           = $_GET[iCodPerfil];
  $iCodCategoria        = $_GET[iCodCategoria];
  $txtestado            = $_GET[txtestado];
  $pag                  = $_GET[pag];
 ?>
<table class="table">
 <tr>
 <td>
 <table border="0" align="center">

            <fieldset id="tfa_DatosPersonales" class="fieldset">
            <legend>Datos Personales</legend>
            <table border="0">
       	  <tr>

       	  	<td width="90" >Raz&oacute;n social/Nombre:</td>
       	  	<td width="268" align="left">
              <input type="text" name="cNombresTrabajador" id="cNombresTrabajador" size="40" class="FormPropertReg form-control" 
              		 value="<?php echo $_GET['cNombreTrabajador']; ?>" readonly />
            </td>
            <td align="center">
              <div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;">
                <a style=" text-decoration:none" href="javascript:;" 
                    onClick="window.open('listarRemitentes.php','popuppage','width=750,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a>
              </div>
            </td>
          </tr>  
          
          <tr>
            <?php 
              $DNI_RUC = $_GET["cTipoDocIdentidad"];
              if (!empty($DNI_RUC)) {
                if ($DNI_RUC == 1) {
                  $identificacion = 'DNI';
                }elseif ($DNI_RUC == 2) {
                  $identificacion = 'RUC';
                }
              }
            ?>
            <td width="90" >Documento:</td>
            <td width="268" align="left">
                <input name="identificacion" type="text" id="identificacion"  size="40" class="FormPropertReg form-control" 
                       value="<?php echo $identificacion; ?>" readonly/>
            </td>
          </tr>   
          
          <tr>
            <td width="85" >Nro. Doc.:</td>
            <td width="266" align="left">
              <input name="cNumDocIdentidad" type="text" id="cNumDocIdentidad" value="<?php echo $_GET[cNumDocIdentidad]; ?>" 
                      size="40" class="FormPropertReg form-control"  onkeypress="if (event.keyCode > 31 && ( event.keyCode < 48 || event.keyCode > 57)) event.returnValue = false;" readonly/>
            </td>
          </tr>
           
          <tr>
            <td width="90" >Estado:</td>
            <td width="268" align="left"><select name="txtestado" class="FormPropertReg form-control" id="txtestado">
                              <? 
			                     if ($Rs[nFlgEstado]==1){
	  	                         echo "<OPTION value=1 selected>Activo</OPTION> ";
		                         }
		                         else{
		                         echo "<OPTION value=1>Activo</OPTION> ";
		                         }
                                 if ($Rs[nFlgEstado]==0){
	  	                         echo "<OPTION value=0 selected>Inactivo</OPTION> ";
		                         }
		                         else{
		                         echo "<OPTION value=0>Inactivo</OPTION> ";
		                             }
	                          ?>    
                              </select>                              </td>
             </tr>
                
             <tr>¿
              <td height="35" colspan="5" align="center">
              <button class="btn btn-primary"  type="submit" id="Actualizar Trabajador" onMouseOver="this.style.cursor='hand'">
                <table cellspacing="0" cellpadding="0">
                  <tr>
                    <td style=" font-size:10px"><b>Actualizar</b>&nbsp;&nbsp;</td>
                    <td><img src="images/page_refresh.png" width="17" height="17" border="0"></td>
                  </tr>
                </table>
              </button>
              <button class="btn btn-primary" type="button" onclick="window.open('iu_trabajadores_externos.php?cNombreTrabajador=<?=$cNombreTrabajador?>&cApellidosTrabajador=<?=$cApellidosTrabajador?>&cTipoDocIdentidad=<?=$cTipoDocIdentidad?>&cNumDocIdentidad=<?=$cNumDocIdentidad?>&iCodOficina=<?=$iCodOficina?>&iCodPerfil=<?=$iCodPerfil?>&iCodCategoria=<?=$iCodCategoria?>&txtestado=<?=$txtestado?>&pag=<?=$_GET[pag]?>', '_self');"
                onMouseOver="this.style.cursor='hand'">
                <table cellspacing="0" cellpadding="0">
                  <tr>
                    <td style=" font-size:10px"><b>Cancelar</b>&nbsp;&nbsp;</td>
                    <td><img src="images/icon_retornar.png" width="17" height="17" border="0"></td>
                  </tr>
                </table>
              </button>
            </td>
          </tr>
             </table> 
             </fieldset>
    
     </td>
     <td colspan="4"  valign="top">
      <fieldset id="tfa_DatosPersonales" class="fieldset"  >
        <legend >Datos de Usuario</legend>
          <table border="0">
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
           
           
              <td width="85" >Usuario:</td>
              <td width="266" align="left">
                <input name="cUsuario" type="text" id="cUsuario" value="<?php echo trim($Rs[cUsuario]); ?>" size="15" 
                      class="FormPropertReg form-control" /></td>
           </tr>
           <tr>
              <td width="71"></td>
              
              <td width="85" ></td>
              <td width="266"></td>
           </tr>
           
        </table>
        </fieldset>
    

</form>   



<?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php"); ?>

</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>
