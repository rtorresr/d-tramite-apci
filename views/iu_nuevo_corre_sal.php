<?php
session_start();
$pageTitle = "Agregar Correlativo Salida";
$activeItem = "iu_correlativo_salida.php";
$navExtended = true;
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
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
                    <div class="card-header text-center ">Maestra correlativos - SALIDAS</div>                      
                    <!--Card content-->                     
                    <div class="card-body">
                        <?php
        require_once("../models/ad_busqueda.php");
                        ?>
                        <form action="../controllers/ln_actualiza_correlativo.php" onSubmit="return validar(this)" method="post" name="frmCorrelativo">
                            <input type="hidden" name="opcion" value="4">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <label>Oficina:</label>
                                    <select name="iCodOficina" onchange="releer()" class="FormPropertReg mdb-select colorful-select dropdown-primary"   searchable="Buscar aqui..">
                                        <option value="">Seleccione:</option>
                                            <?php
                                                     $sqlOfi=" SP_OFICINA_LISTA_COMBO ";
                                                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                     while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                                     if($RsOfi["iCodOficina"]==$_REQUEST['iCodOficina']){
                                                                                $selecClas="selected";
                                                     }Else{
                                                            $selecClas="";
                                                     }
                                                     echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                                                     }
                                                     sqlsrv_free_stmt($rsOfi);
                                                  ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Tipo de Documento:</label>
                                    <select name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary"   searchable="Buscar aqui..">
                                        <option value="">Seleccione:</option>
                                        <?php
   include_once("../conexion/conexion.php");
                                           $sqlTipo="SP_TIPO_DOCUMENTO_LISTA_CORRELATIVO_S $_REQUEST[iCodOficina]";
                                           $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                           while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
                                                   $selecTipo="selected";
                                                }Else{
                                                   $selecTipo="";
                                                }
                                                echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
                                            }
                                            sqlsrv_free_stmt($rsTipo);
                                         ?>
                                     </select>
                                </div>
                                <div class="col-md-3">
                                     <label>A&ntilde;o:</label>
                                     <select name="nNumAno"  class="FormPropertReg mdb-select colorful-select dropdown-primary"   searchable="Buscar aqui.." id="iCodUbicacion">
                                           <option value="2018" selected="selected">2018</option>
                                           <option value="2019">2019</option>
                                           <option value="2020">2020</option>
                                     </select>
                                </div>
                                <button class="btn btn-primary"  type="submit" id="Insert Oficina"   onMouseOver="this.style.cursor='hand'">
                                    <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0">
                                </button>
                                <button class="btn btn-primary" type="button" onclick="window.open('iu_correlativo_salida.php?iCodOficina=<?=$_GET['iCodOficina']?>', '_self');"
                                        onMouseOver="this.style.cursor='hand'">
                                    <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0">
                                </button>
                            </div>
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
        function validar(f) {
            var error = "Por favor, antes de crear complete:\n\n";
            var a = "";
            if (f.iCodOficina.value == "") {
                a += " Ingrese una Oficina";
                alert(error + a);
            }
            else if (f.cCodTipoDoc.value == "") {
                a += " Ingrese un Documento";
                alert(error + a);
            }
            return (a == "");
        }
        function releer(){
            document.frmCorrelativo.action="<?=$_SERVER['PHP_SELF']?>#area";
            document.frmCorrelativo.submit();
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