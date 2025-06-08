<?php
$pageTitle = "Mantenimiento Correlativo Interno";
$activeItem = "iu_correlativo_interno.php";
$navExtended = true;

session_start();
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
                    <div class="card-header text-center ">CORRELATIVO INTERNO</div>
                    <!--Card content-->
                    <div class="card-body px-4 px-sm-5">

                        <form name="form1" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                            <div class="row justify-content-center">

                                <div class="col-12 col-md-8 col-xl-5">
                                    <label><strong>Oficina:</strong></label>
                                    <select name="iCodOficina"
                                            class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                            searchable="Buscar aqui..">
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

                                <div class="col-12 col-md-3 col-xl-2">
                                    <label><strong>A&ntilde;o:</strong></label>
                                    <select name="anho" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                        <option value="">Seleccione:</option>
                                        <option value="2018" <?php if($_REQUEST[anho]=="2018"){echo "selected";} ?>>2018</option>
                                        <option value="2019" <?php if($_REQUEST[anho]=="2019"){echo "selected";} ?>>2019</option>
                                        <option value="2020" <?php if($_REQUEST[anho]=="2020"){echo "selected";} ?>>2020</option>
                                    </select>
                                </div>


                                <div class="col-12">
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-">
                                            <a class="btn botenviar" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">
                                                Buscar&nbsp;<img src="images/icon_buscar.png" width="17" height="17" border="0">
                                            </a>
                                        </div>
                                        <div class="col-">
                                            <a class="btn botenviar" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'">
                                                Restablecer&nbsp;<img src="images/icon_clear.png" width="17" height="17" border="0">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <br>

                        <?php
                        function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                            $total_paginas = ceil($total/$por_pagina);
                            $anterior = $actual - 1;
                            $posterior = $actual + 1;
                            $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
                            $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;

                            if ($actual>1){
                                $texto = "<a href=\"$enlace$anterior\"><<</a> ";}
                            else{
                                $texto = "<b><<</b> ";}

                            if ($minimo!=1) $texto.= "... ";{}
                                for ($i=$minimo; $i<$actual; $i++){
                                    $texto .= "<a href=\"$enlace$i\">$i</a> ";
                                    $texto .= "<b>$actual</b> ";}
                                for ($i=$actual+1; $i<=$maximo; $i++){
                                    $texto .= "<a href=\"$enlace$i\">$i</a> ";}

                            if ($maximo!=$total_paginas) {$texto.= "... ";}

                            if ($actual<$total_paginas){
                                $texto .= "<a href=\"$enlace$posterior\">>></a>";}
                            else{
                                $texto .= "<b>>></b>";}
                            return $texto;
                        }

                        if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
                        $tampag = 15;

                        // ordenamiento
                        if($_GET['campo']??''==""){
                            $campo="Oficina";
                        }Else{
                            $campo=$_GET['campo'];
                        }

                        if($_GET['orden']??''==""){
                            $orden="ASC";
                        }Else{
                            $orden=$_GET['orden'];
                        }

                        //invertir orden
                        if($orden=="DESC") $cambio="ASC";
                        if($orden=="ASC") $cambio="DESC";

                        $icodo = $_REQUEST['iCodOficina']??'null';
                        $anio = $_REQUEST['anho']??date('Y');

                        $sql=" SP_CORRELATIVO_INTERNO_LISTA ".$icodo.",'$anio' ";
                        $rs=sqlsrv_query($cnx,$sql, array(), array('Scrollable' =>'buffered'));

                        ?>

                        <form class="row mt-3 justify-content-center mb-4" name="frmRegistro" method="POST" action="../controllers/ln_actualiza_correlativo.php">
                            <input type="hidden" name="opcion" value="1">
                                <input type="hidden" name="iCodOficina" value="<?=$_REQUEST['iCodOficina']?>">

                                <div class="col-12 col-md-11 col-xl-7">
                                    <a class="btn botenviar" href='iu_nuevo_corre_int.php?iCodOficina=<?=$_REQUEST['iCodOficina']??''?>'><i class="fas fa-plus"></i></a>

                                    <?php
                                    $numrows=sqlsrv_num_rows($rs);
                                    if($numrows==0){
                                        echo "No se encontraron registros. <br>";
                                        echo "Total de registros: ".$numrows;
                                    }else{
                                    echo "Total de registros: ".$numrows;}
                                    ?>

                                    <table class="table mb-1">
                                            <thead class="text-center">
                                                <tr>
                                                    <th class="headCellColum">TIPO DE DOCUMENTO</th>
                                                    <th class="headCellColum"> N&deg;</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php
                                                $reg1 = $reg1??0;
                                                while ($Rs= sqlsrv_fetch_array($rs)) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?= $Rs['cDescTipoDoc'];?>
                                                            <input type="hidden" name="cCodTipoDoc[]" value="<?php echo $Rs['cCodTipoDoc'];?>" />
                                                        </td>
                                                        <td align="right">
                                                            <input type="text" name="cCorrelativo[]" value="<?php echo trim($Rs['nCorrelativo']);?>"
                                                                   style="width:40px; text-align:right; background-color:rgba(134,134,134,0.76)"   <?php if($_REQUEST['cCorrelativo']??''!=trim($Rs['nCorrelativo'])){echo " style=background-color:#FFF;";  }  ?>
                                                                   onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
                                                        </td>
                                                    </tr>
                                                <?php
                                                     }
                                                ?>
                                        </tbody>
                                    </table>

                                    <!--
                                    <div class="row justify-content-center mb-3 mt-3">
                                        <div class="col-">
                                            <button class="botenviar" type="submit" style="border: none!important; padding: 0.5rem 1.2rem!important;">Guardar</button>
                                        </div>
                                    </div>-->
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
                                function ConfirmarBorrado()
                                {
                                    if (confirm("Esta seguro de eliminar el registro?")){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }

                                function Buscar()
                                {
                                    document.form1.action="<?=$_SERVER['PHP_SELF']?>";
                                    document.form1.submit();
                                }    $(document).ready(function() {
                                    $('.mdb-select').material_select();

                                });
                            </script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>