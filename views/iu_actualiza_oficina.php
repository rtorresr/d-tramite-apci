<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
  include_once("../conexion/conexion.php");
  $cod = $_GET['cod'];
  $sw = $_GET["sw"];
  $se = $_GET["se"];
  $cNomOficina = $_GET["cNomOficina"];
  $cSiglaOficina = $_GET["cSiglaOficina"];
  $cTipoUbicacion = $_GET["cTipoUbicacion"];
  $iFlgEstado = $_GET["iFlgEstado"];
  $pag = $_GET['pag'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
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
                    <div class="card-header text-center ">Maestra Oficinas</div>
                    <!--Card content-->
                    <div class="card-body">
                        <?php
        require_once("../models/ad_busqueda.php");
                        ?>
                        <form action="../controllers/ln_actualiza_oficina.php" onSubmit="return validar(this)" method="post" name="form1">
                        <input type="hidden" name="iCodOficina" value="<?=$Rs['iCodOficina']?>"/>
                        <input type="hidden" name="cNomOficina2" value="<?=$Rs[cNomOficina]?>"/>
                        <input type="hidden" name="cSiglaOficina2" value="<?=$Rs[cSiglaOficina]?>"/>
                        <input type="hidden" name="cNomOficinax" value="<?=$cNomOficina?>"/>
                        <input type="hidden" name="cSiglaOficinax" value="<?=$cSiglaOficina?>"/>
                        <input type="hidden" name="iFlgEstadox" value="<?=$iFlgEstado?>"/>
                        <input type="hidden" name="pagx" value="<?=$pag?>"/>
                        <legend class="legend">Datos de Oficina</legend>
                         Nombre de Oficina:
                            <input name="cNomOficina" type="text" id="cNomOficina" value="<?=trim($Rs[cNomOficina])?>"  maxlength="150" size="50"
                                   class="FormPropertReg form-control"/><?php if($_GET[cNomOficina]!="") echo "nombre existente"?>
                         Sigla de Oficina:
                            <input name="cSiglaOficina" type="text" id="cSiglaOficina" value="<?=trim($Rs[cSiglaOficina])?>" maxlength="10"
                                   size="50" class="FormPropertReg form-control"/><?php if($_GET[cSiglaOficina]!="") echo "sigla existente"?>

                         Estado:
                         <select name="iFlgEstado" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                 searchable="Buscar aqui.." id="iFlgEstado">
                                           <option value="">Seleccione:</option>
                                               <option value="0" <?php if($Rs[iFlgEstado]==0){echo selected;} ?>>Inactivo</option>
                                           <option value="1" <?php if($Rs[iFlgEstado]==1){echo selected;} ?>>Activo</option>
                         </select>
                         <button class="btn btn-primary"  type="submit" id="Actualizar Oficina" onMouseOver="this.style.cursor='hand'">
                             <b>Actualizar</b> <img src="images/page_refresh.png" width="17" height="17" border="0">
                         </button>
                         <button class="btn btn-primary" type="button" onclick="window.open('iu_oficinas.php', '_self');" onMouseOver="this.style.cursor='hand'">
                             <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0">
                         </button>

                         <table class="table">
                              <?php
                                $sqlTrabPorOficina = "SELECT * FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '$_GET[cod]'";
                                $rs  = sqlsrv_query($cnx,$sqlTrabPorOficina);
                              ?>
                              <tr>
                                <td class="headCellColum">Nombres</td>
                                <td class="headCellColum">Apellidos</td>
                                <td class="headCellColum">Perfil</td>
                              </tr>
                                <?php
                                  $numrows = sqlsrv_has_rows($rs);
                                  if ($numrows==0){
                                    echo "NO SE ENCONTRARON REGISTROS<br>";
                                    echo "TOTAL DE REGISTROS : ".$numrows;
                                  }else{
                                    echo "TOTAL DE REGISTROS : ".$numrows;
                                    while ($Rs = sqlsrv_fetch_array($rs)) {
                                      if ($color == "#CEE7FF"){
                                        $color = "#F9F9F9";
                                      }else{
                                        $color = "#CEE7FF";
                                      }
                                      if ($color == ""){
                                        $color = "#F9F9F9";
                                      }
                                ?>
                              <tr bgcolor="<?=$color?>">
                                  <td align="left">
                                    <?php
                                      $sqlTrabajador = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$Rs['iCodTrabajador'];
                                      $rsTrabajador  = sqlsrv_query($cnx,$sqlTrabajador);
                                      $RsTrabajador  = sqlsrv_fetch_array($rsTrabajador);
                                      echo $RsTrabajador['cNombresTrabajador'];
                                    ?>
                                  </td>
                                  <td align="left">
                                    <?php
                                      $sqlTrabajador = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$Rs['iCodTrabajador'];
                                      $rsTrabajador  = sqlsrv_query($cnx,$sqlTrabajador);
                                      $RsTrabajador  = sqlsrv_fetch_array($rsTrabajador);
                                      echo $RsTrabajador['cApellidosTrabajador'];
                                    ?>
                                  </td>
                                  <td align="left">
                                    <?php
                                      $sqlPerfil = "SELECT cDescPerfil FROM Tra_M_Perfil WHERE iCodPerfil = ".$Rs['iCodPerfil'];
                                      $rsPerfil  = sqlsrv_query($cnx,$sqlPerfil);
                                      $RsPerfil  = sqlsrv_fetch_array($rsPerfil);
                                      echo $RsPerfil['cDescPerfil'];
                                    ?>
                                  </td>
                              </tr>
                                <?php
                                    }
                                  }
                                ?>
                          </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>
                        <script>
                            $('.mdb-select').material_select();
                            function validar(f) {
                                var error = "Por favor, antes de crear complete:\n\n";
                                var a = "";
                                if (f.cNomOficina.value == "") {
                                    a += " Ingrese una Oficina";
                                    alert(error + a);
                                }else if (f.cSiglaOficina.value == "") {
                                    a += " Ingrese una Sigla";
                                    alert(error + a);
                                }
                                return (a == "");
                            }
                        </script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
