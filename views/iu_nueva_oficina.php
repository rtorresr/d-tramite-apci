<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_nueva_oficina.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Mantenimiento de la Tabla Maestra Oficina para el Perfil Administrador
          -> Crear Registro de Oficina
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />

</head>
<body>

<table cellpadding="0" cellspacing="0" border="0">
<tr>

        <?php include("includes/menu.php");?>
    </td>
</tr>
<tr>

</tr>

<tr>


<!--Main layout--> <main class="mx-lg-5">     <div class="container-fluid">          <!--Grid row-->         <div class="row wow fadeIn">              <!--Grid column-->             <div class="col-md-12 mb-12">                  <!--Card-->                 <div class="card">                      <!-- Card header -->                     <div class="card-header text-center ">                         Mantenimiento >> M. OFICINAS                     </div>                      <!--Card content-->                     <div class="card-body">


<?
require_once("../models/ad_busqueda.php");
?>

<form action="../controllers/ln_nueva_oficina.php" onSubmit="return validar(this)" method="post" name="form1">

  <tr>
      <td colspan="4">
        <fieldset id="tfa_DatosPersonales" class="fieldset"  >
        <legend class="legend">Datos de Oficina</legend>
        <table border="0">
           <tr>
              <td width="114"></td>
              <td >Nombre de Oficina:</td>
              <td width="325"  align="left"><input name="cNomOficina" type="text" id="cNomOficina" maxlength="150" size="50" class="FormPropertReg form-control" value="<?=$_GET[cNomOficina]?>"/><?php if($_GET[cNomOficina]!="") echo "nombre existente"?></td>
           </tr>
           <tr>
              <td width="114"></td>
              <td >Sigla de Oficina:</td>
              <td width="325"  align="left"><input name="cSiglaOficina" type="text" id="cSiglaOficina" maxlength="10" style="text-transform:uppercase" size="50" class="FormPropertReg form-control" value="<?=$_GET[cSiglaOficina]?>"/><?php if($_GET[cSiglaOficina]!="") echo "sigla existente"?></td>
           </tr>
     <!--      <tr>

              <td >Ubicacion:</td>
              <td  align="left">
                <?/* //Consulta para rellenar el combo Ubicacion Oficina
                    $sqlUbi="SP_UBICACION_OFICINA_LISTA_COMBO "; 
                    $rsUbi=sqlsrv_query($cnx,$sqlUbi);
                    */?>
                    <select name="iCodUbicacion"  class="FormPropertReg form-control" id="iCodUbicacion">
                    <option value="">Seleccione:</option>
                    <?/* while ($RsUbi=sqlsrv_fetch_array($rsUbi)){
                     if($RsUbi["iCodUbicacion"]=="1"){
                     $selecClas="selected";
                    }Else{
                     $selecClas="";
                    }
                    echo "<option value=".$RsUbi["iCodUbicacion"]." ".$selecClas.">".$RsUbi["cNomUbicacion"]."</option>";
                    }
                    sqlsrv_free_stmt($rsUbi);
                */?>
                    </select>
              </td>
           </tr>-->
           <tr>

              <td >Estado:</td>
              <td  align="left">
                <select name="iFlgEstado"  class="FormPropertReg mdb-select colorful-select dropdown-primary"
                        searchable="Seleccione.."  id="iFlgEstado">

                    <option value="0">Inactivo</option>
                   <option value="1" selected>Activo</option>
                 </select>
              </td>
           </tr>

           <tr>
              <td height="46" colspan="3" align="center">
                <button class="btn btn-primary"  type="submit" id="Insert Oficina"   onMouseOver="this.style.cursor='hand'"> <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0"> </button>
                <button class="btn btn-primary" type="button" onclick="window.open('iu_oficinas.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
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

</div>		
</td>
</tr>
<tr>
<td><img width="1088" height="11" src="images/pcm_8.jpg" border="0"/></td>
<?php include("includes/userinfo.php");?>


<?php include("includes/pie.php");?>
    <script>
        function validar(f) {
            var error = "Por favor, antes de crear complete:\n\n";
            var a = "";
            if (f.cNomOficina.value == "") {
                a += " Ingrese una Oficina";
                alert(error + a);
            }else if (f.cSiglaOficina.value == "") {
                a += " Ingrese una Sigla";
                alert(error + a);
            }/*else if (f.iCodUbicacion.value == "") {
        a += " Seleccione una Ubicacion";
        alert(error + a);
    }*/
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