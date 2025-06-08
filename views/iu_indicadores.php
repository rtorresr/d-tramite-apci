<?php
session_start();
$pageTitle = "Mantenimiento de Motivos";
$activeItem = "iu_indicadores.php";
$navExtended = true;
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$pag = $_GET['pag']??0;
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
                     <div class="card-header text-center ">
                         Administración de Motivos
                     </div>
                      <!--Card content-->
                     <div class="card-body">
                        <form name="form1" method="GET" action="iu_indicadores.php">
                            Motivo:<input name="cIndicacion" class="FormPropertReg form-control" type="text" value="<?=$_GET['cIndicacion']??''?>" />
                            <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'">
                                <b>Buscar</b>
                                <img src="images/icon_buscar.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'">
                                <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary" onClick="window.open('iu_indicadores_xls.php?cIndicacion=<?=$_GET['cIndicacion']??''?>&orden=<?=$orden??''?>&campo=<?=$campo??''?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']??''?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary" onClick="window.open('iu_indicadores_pdf.php?cIndicacion=<?=$_GET['cIndicacion']??''?>&orden=<?=$orden??''?>&campo=<?=$campo??''?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0">
                            </button>
                            <a class='btn btn-primary' href='iu_nuevo_indicador.php'>Nueva Motivo</a>
                        </form>
                        <?php
                            function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                                $total_paginas = ceil($total/$por_pagina);
                                $anterior = $actual - 1;
                                $posterior = $actual + 1;
                                $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
                                $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
                                if ($actual>1)
                                $texto = "<a href=\"$enlace$anterior\"><<</a> ";
                                else
                                $texto = "<b><<</b> ";
                                if ($minimo!=1) $texto.= "... ";
                                for ($i=$minimo; $i<$actual; $i++)
                                $texto .= "<a href=\"$enlace$i\">$i</a> ";
                                $texto .= "<b>$actual</b> ";
                                for ($i=$actual+1; $i<=$maximo; $i++)
                                $texto .= "<a href=\"$enlace$i\">$i</a> ";
                                if ($maximo!=$total_paginas) $texto.= "... ";
                                if ($actual<$total_paginas)
                                $texto .= "<a href=\"$enlace$posterior\">>></a>";
                                else
                                $texto .= "<b>>></b>";
                                return $texto;
                            }

                            if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
                            $tampag = 15;
                            $reg1 = ($pag-1) * $tampag;

                        // ordenamiento
                        if (isset($_GET['campo'])){
                            if($_GET['campo']==""){
                                $campo="Indicador";
                            }Else{
                                $campo=$_GET['campo'];
                            }
                        }else{
                            $campo="";
                        }
                        if (isset($_GET['orden'])){
                            if($_GET['orden']==""){
                                $orden="ASC";
                            }Else{
                                $orden=$_GET['orden'];
                            }
                        }else{
                            $orden="";
                        }

                        //invertir orden
                        if($orden=="ASC") $cambio="DESC";
                        if($orden=="DESC") $cambio="ASC";

                        $sql=" SP_INDICADORES_LISTA '%".($_GET['cIndicacion']??'')."%' ,'".$orden."' , '".$campo."'  ";
                        $rs=sqlsrv_query($cnx,$sql, array(), array('Scrollable' =>'buffered'));
                        $total = sqlsrv_has_rows($rs);
                        //echo $sql;
                        ?>
                        <table class="table table-sm">
                        <tr>
                            <td class="headCellColum">
                                <a style=" text-decoration:<?php if($campo=="Indicador"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Indicador&orden=<?=$cambio??''?>&cIndicacion=<?=$_GET['cIndicacion']??''?>">Descripción:</a></td>
                          <td class="headCellColum">Opciones</td>
                            </tr>
                            <?php
                        $numrows=sqlsrv_has_rows($rs);
                              if($numrows==0){
                                echo "NO SE ENCONTRARON REGISTROS<br>";
                        }else{
                         while ($Rs= sqlsrv_fetch_array($rs)) {
                        if (isset($color)) {
                            if ($color == "#CEE7FF") {
                                $color = "#F9F9F9";
                            } else {
                                $color = "#CEE7FF";
                            }
                            if ($color == "") {
                                $color = "#F9F9F9";
                            }
                        }else{
                            $color='';
                        }
                        ?>
                        <tr bgcolor="<?=$color?>">
                            <td align="left"><?php echo ucwords(strtolower($Rs['cIndicacion']));?></td>
                            <td>
                                <a href="../controllers/ln_elimina_indicador.php?id=<?php echo $Rs['iCodIndicacion'];?>" onClick='return ConfirmarBorrado();'">
                                <i class="far fa-trash-alt"></i>
                                </a>
                                <a href="../views/iu_actualiza_indicador.php?cod=<?php echo $Rs['iCodIndicacion'];?>&sw=11"><i class="fas fa-edit"></i></a>
                            </td>
                          </tr>

                        <?php
                        }
                        }
                        ?>
                        </table>
                        <?php
                            echo "TOTAL DE REGISTROS : ".$numrows; ?>
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
                         </script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>