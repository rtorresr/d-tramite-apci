<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_nuevo_tupa.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Mantenimiento de la Tabla Maestra de Tupa para el Perfil Administrador
          -> Crear Registro de Tupa
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
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />

</head>
<body class="theme-default has-fixed-sidenav">

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
                    <div class="card-header text-center "> Maestra Tupa </div>
                        <?php
                        require_once("../models/ad_busqueda.php");
                        ?>
                    <div class="card-body">
                        <form action="../controllers/ln_nuevo_tupa.php" onSubmit="return validar(this)" method="post" name="form1">
                            <table class="table">
                                 <tr>
                                     <td>
                                         <table border="0" align="center"  >
                                           <tr>
                                              <td colspan="4">
                                                    <fieldset id="tfa_DatosPersonales" class="fieldset"  >
                                                        <legend class="legend">Datos Tupa</legend>
                                                        <table border="0">
                                                           <tr>
                                                              <td width="90"></td>
                                                              <td width="200" >Clase de Procedimiento:</td>
                                                              <td width="15"></td>
                                                              <td width="420" align="left">
                                                                  <?php //Consulta para rellenar el combo Oficina
                                                                  $sqlOfi="SP_CLASE_TUPA_LISTA_COMBO ";
                                                                  $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                                  ?>
                                                                  <select name="iCodTupaClase" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Seleccione.." id="iCodTupaClase"  >
                                                                      <option value="">Seleccione:</option>
                                                                      <?php
                                                                      while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                                                          if($RsOfi["iCodTupaClase"]==$_POST['iCodTupaClase']??''){
                                                                              $selecClas="selected";
                                                                          }else{
                                                                              $selecClas="";
                                                                          }
                                                                          echo "<option value=".$RsOfi["iCodTupaClase"]." ".$selecClas.">".$RsOfi["cNomTupaClase"]."</option>";
                                                                      }
                                                                      sqlsrv_free_stmt($rsOfi);
                                                                      ?>
                                                                  </select>
                                                              </td>
                                                           </tr>
                                                           <tr>
                                                              <td width="90"></td>
                                                              <td width="200" >Nombre de Tupa:</td>
                                                              <td width="15"></td>
                                                              <td width="420"  align="left"><input name="txtdesc_tupa" type="text" id="txtdesc_tupa" maxlength="150" size="90" class="FormPropertReg form-control"></td>
                                                           </tr>
                                                           <tr>
                                                             <td >Silencio Administrativo:</td>
                                                             <td  align="left">
                                                                     <select name="txtsilencio" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                             searchable="Seleccione.." id="txtsilencio">
                                                                       <option value="" selected="selected">Seleccione:</option>
                                                                  <?php
                                                                        if ($Rs['nSilencio']==1){
                                                                            echo "<OPTION value=1>Silencio Adm. Positivo</OPTION> ";
                                                                        }else{
                                                                            echo "<OPTION value=1>Silencio Adm. Positivo</OPTION> ";
                                                                        }
                                                                        if ($Rs['nSilencio']==0){
                                                                            echo "<OPTION value=0>Silencio Adm. Negativo</OPTION> ";
                                                                        }else{
                                                                            echo "<OPTION value=0>Silencio Adm. Negativo</OPTION> ";
                                                                        }
                                                                  ?>
                                                                     </select>
                                                             </td>
                                                           </tr>
                                                           <tr>
                                                              <td >Duracion (dias):</td>
                                                              <td  align="left"><input name="txtdia_tupa" type="text" id="txtdia_tupa" maxlength="3"  size="40" class="FormPropertReg form-control" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></td>
                                                           </tr>
                                                           <tr>
                                                              <td >Oficina:</td>
                                                              <td  align="left">
                                                                  <?php //Consulta para rellenar el combo Oficina
                                                                  $sqlOfi="SP_OFICINA_LISTA_COMBO ";
                                                                  $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                                  ?>
                                                                  <select name="iCodOficina" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Seleccione:" id="iCodOficina"  >
                                                                      <option value="">Seleccione...</option>
                                                                      <?php
                                                                      while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                                                          if($RsOfi["iCodOficina"]==$_POST['iCodOficina']??''){
                                                                              $selecClas="selected";
                                                                          }else{
                                                                              $selecClas="";
                                                                          }
                                                                          echo utf8_encode("<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>");
                                                                      }
                                                                      sqlsrv_free_stmt($rsOfi);
                                                                      ?>
                                                                  </select>
                                                              </td>
                                                           </tr>
                                                            <tr>
                                                              <td width="90"></td>
                                                              <td width="200" >Estado:</td>
                                                              <td width="15"></td>
                                                              <td width="420" align="left" >
                                                                  <select name="txtestado" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Seleccione.." id="txtestado">
                                                                      <option value="" >Seleccione:</option>
                                                                        <?php
                                                                        if ($_REQUEST['txtestado']==1){
                                                                            echo "<OPTION value=1 selected>Activo</OPTION> ";
                                                                        }else{
                                                                            echo "<OPTION value=1 selected>Activo</OPTION> ";
                                                                        }
                                                                        if ($_REQUEST['txtestado']==2){
                                                                            echo "<OPTION value=2>Inactivo</OPTION> ";
                                                                        }else{
                                                                            echo "<OPTION value=2>Inactivo</OPTION> ";
                                                                        }
                                                                        ?>
                                                                  </select>
                                                              </td>
                                                           </tr>
                                                           <tr>
                                                                <td height="36" colspan="5" align="center">
                                                                    <button class="btn btn-primary"  type="submit" id="Insert Tupa" onMouseOver="this.style.cursor='hand'"> <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0"> </button>
                                                                    <button class="btn btn-primary" type="button" onclick="window.open('iu_tupa.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
                                                                </td>
                                                           </tr>
                                                        </table>
                                                    </fieldset>
                                             </td>
                                           </tr>
                                          </table>
                                     </td>
                                 </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <!--/.Card-->
            </div>
            <!--Grid column-->
        </div>
        <!--Grid column-->
    </div>
    <!--Grid column-->
</main>

<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>
    <script>
        function validar(f) {
            var error = "Por favor, antes de crear complete:\n\n";
            var a = "";
            if (f.iCodTupaClase.value == "") {
                a += " Ingrese una Clase";
                alert(error + a);
            }
            else if (f.txtdesc_tupa.value == "") {
                a += " Ingrese Descripción de Tupa";
                alert(error + a);
            }
            else if (f.txtdia_tupa.value == "") {
                a += " Ingrese Cantidad de Dias";
                alert(error + a);
            }
            else if (f.iCodOficina.value == "") {
                a += " Seleccione una Oficina";
                alert(error + a);
            }
            else if (f.txtestado.value == "") {
                a += " Seleccione Estado de Tupa";
                alert(error + a);
            }

            return (a == "");

        }

        $(document).ready(function() {
            $('.mdb-select').material_select();

        });
    </script>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
