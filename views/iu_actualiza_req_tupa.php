<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_actualiza_req_tupa.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Mantenimiento de la Tabla Maestra de Requerimientos de Tupa para el Perfil Administrador
          -> Actualizar Registro de Requerimientos de Tupa
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
$cod = $_GET["cod"];
$sw = $_GET["sw"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
    <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
    <script>
        function validar(f) {
         var error = "Por favor, antes de actualizar complete:\n\n";
         var a = "";
          if (f.cNomTupaRequisito.value == "") {
          a += " Ingrese un requisito";
          alert(error + a);
         }
         else if (f.txtestado.value == "") {
          a += " Seleccione estado";
          alert(error + a);
         }

         return (a == "");

        }
    </script>
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
                     <div class="card-header text-center "> >> Maestra de Requisitos Tupa </div>
                      <!--Card content-->
                     <div class="card-body">
                        <?php require_once("../models/ad_busqueda.php");?>
                        <form action="../controllers/ln_actualiza_req_tupa.php" onSubmit="return validar(this)" method="post" name="form1">
                            <input type="hidden" name="iCodTupaRequisito" value="<?=$Rs['iCodTupaRequisito'];?>">
                            <input type="hidden" name="iCodTupa" value="<?=$Rs['iCodTupa'];?>">
                            <tr>
                                <td colspan="4">
                                    <fieldset id="tfa_Requisito" class="fieldset">
                                    <legend class="legend">Datos de Requisito</legend>
                                        <table border="0">
                                           <tr>
                                              <td ></td>
                                              <td align="left">
                                                  <div class="md-form">
                                                      <textarea type="text" id="cNomTupaRequisito" name="cNomTupaRequisito" class="FormPropertReg md-textarea md-textarea-auto form-control" rows="2">
                                                          <?=utf8_encode(trim($Rs['cNomTupaRequisito']))?>
                                                      </textarea>
                                                      <label for="cNomTupaRequisito">Nombre Requisito:</label>
                                                  </div>
                                           </tr>
                                           <tr>
                                              <td >Estado:</td>
                                              <td align="left">
                                                  <select name="txtestado" class="FormPropertReg form-control" id="txtestado">
                                                              <?php
                                                                 if ($Rs['nEstadoTupaRequisito']==1){
                                                                    echo "<OPTION value=1 selected>Activo</OPTION> ";
                                                                 }else{
                                                                    echo "<OPTION value=1>Activo</OPTION> ";
                                                                 }
                                                                 if ($Rs['nEstadoTupaRequisito']==0){
                                                                    echo "<OPTION value=0 selected>Inactivo</OPTION> ";
                                                                 }else{
                                                                    echo "<OPTION value=0>Inactivo</OPTION> ";
                                                                 }
                                                              ?>
                                                  </select>
                                              </td>
                                           </tr>
                                           <tr>
                                              <td colspan="4" align="center">
                                                <button class="btn btn-primary"  type="submit" id="Actualizar Requisito" onMouseOver="this.style.cursor='hand'"> <b>Actualizar</b> <img src="images/page_refresh.png" width="17" height="17" border="0"> </button>
                                                <button class="btn btn-primary"   type="button" onclick="window.open('iu_req_tupa.php?cod=<?php echo $Rs['iCodTupa'];?>&sw=8', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
                                              </td>
                                           </tr>
                                        </table>
                                    </fieldset>
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