<?php
session_start();
$pageTitle = "Mantenimiento Correlativo Salida";
$activeItem = "iu_correlativo_salida.php";
$navExtended = true;
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
                    <div class="card-header text-center "> Mantenimiento >> M. Correlativo SALIDA </div>
                    <!--Card content-->
                    <div class="card-body">
                        <form name="form1" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <label>Oficina:</label>
                                    <select name="iCodOficina" class="FormPropertReg mdb-select colorful-select dropdown-primary"   searchable="Buscar aqui..">
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
                                    <label>A&ntilde;o:</label>
                                    <select name="anho" class="FormPropertReg mdb-select colorful-select dropdown-primary"   searchable="Buscar aqui.." >
                                        <option value="">Seleccione:</option>
                                        <option value="2018" <?php if($_REQUEST[anho]=="2018"){echo "selected";} ?>>2018</option>
                                        <option value="2019" <?php if($_REQUEST[anho]=="2019"){echo "selected";} ?>>2019</option>
                                        <option value="2020" <?php if($_REQUEST[anho]=="2020"){echo "selected";} ?>>2020</option>
                                    </select>
                                </div>

                            <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">
                                <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'">
                                <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0">
                            </button>
                            <a class="btn btn-primary" href='iu_nuevo_corre_sal.php?iCodOficina=<?=$_REQUEST['iCodOficina']??''?>'>Nuevo Correlativo</a>
                            </div>
                        </form>

                        <?php
                        function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                        $total_paginas = ceil($total/$por_pagina);
                        $anterior = $actual - 1;
                        $posterior = $actual + 1;
                        $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
                        $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
                        if ($actual>1)
                        $texto = "<a href=\"$enlace$anterior\">«</a> ";
                        else
                        $texto = "<b>«</b> ";
                        if ($minimo!=1) $texto.= "... ";
                        for ($i=$minimo; $i<$actual; $i++)
                        $texto .= "<a href=\"$enlace$i\">$i</a> ";
                        $texto .= "<b>$actual</b> ";
                        for ($i=$actual+1; $i<=$maximo; $i++)
                        $texto .= "<a href=\"$enlace$i\">$i</a> ";
                        if ($maximo!=$total_paginas) $texto.= "... ";
                        if ($actual<$total_paginas)
                        $texto .= "<a href=\"$enlace$posterior\">»</a>";
                        else
                        $texto .= "<b>»</b>";
                        return $texto;
                        }


                        if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
                        $tampag = 15;
                        $reg1 = ($pag-1) * $tampag;

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
                        $sql=" SP_CORRELATIVO_SALIDA_LISTA ".$icodo.",'$anio'";
                        //echo $sql;

                        $rs=sqlsrv_query($cnx,$sql, array(), array('Scrollable' =>'buffered'));
                        ?>
                        <form name="frmRegistro" method="POST" action="../controllers/ln_actualiza_correlativo.php">
                            <input type="hidden" name="opcion" value="3">
                            <input type="hidden" name="iCodOficina" value="<?=$_REQUEST['iCodOficina']?>">
                            <input type="hidden" name="anho" value="<?=$_REQUEST[anho]?>">
                            <table class="table" align="center">
                                <thead>
                                    <tr>
                                        <th width="357" class="headCellColum">Tipo de Documento</th>
                                        <th width="50" class="headCellColum"> N&deg;</th>
                                     <!--	<td width="112" class="headCellColum">Opciones</td> /-->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $numrows=sqlsrv_num_rows($rs);
                                    if($numrows==0){
                                            echo "NO SE ENCONTRARON REGISTROS<br>";
                                            echo "TOTAL DE REGISTROS : ".$numrows;
                                    }else{
                                             echo "TOTAL DE REGISTROS : ".$numrows;

                                    ///	//////
                                while ($Rs=sqlsrv_fetch_array($rs)){
                                            //////////////////
                                            //while ($Rs=sqlsrv_fetch_array($rs)){
                                    $color = '';
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
                                            <td align="left"><?php echo $Rs['cDescTipoDoc'];?><input type="hidden" name="cCodTipoDoc[]" value="<?php echo $Rs['cCodTipoDoc'];?>" /></td>
                                            <td  align="center"><input type="text" name="cCorrelativo[]" value="<?php echo trim($Rs['nCorrelativo']);?>"   style="width:40px; text-align:right; background-color:#F93"   <?php if($_REQUEST['cCorrelativo']??''!=trim($Rs['nCorrelativo'])){echo " style=background-color:#FFF;";  }  ?> onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" /> </td>
                                         </tr>

                                        <?php
}
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <td align="center" colspan="2"><button class="btn btn-primary" type="submit" onMouseOver="this.style.cursor='hand'"> <b>ACTUALIZAR</b>  </button></td>
                                    <tr>
                                    <?php
}
                                    ?>
                                </tfoot>
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