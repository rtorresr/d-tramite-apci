<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
  include_once("../conexion/conexion.php");
  //inicia variables paginacion
  $pag = $_GET['pag']??0;
  if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
  if(isset($_GET['cantidadfilas'])){$tampag = $_GET['cantidadfilas'];}
  else{$tampag=5;}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
</head>
<body>
<?php include("includes/menu.php");?>
<style>
    .wrapper {
        width: 100%;
        position: absolute;
        z-index: 100;
        height: auto;
    }
    #sidebar {
        display: none;
    }
    #tablaResutado{
        width: 100%;
        border: none!important;
        box-shadow: none!important;
    }
    #sidebar.active {
        display: flex;
        width: 75%;
    }
    #sidebar label{
        font-size: 0.8rem!important;
        margin-bottom: 0!important;
    }
    .info-end ,.page-link{
        font-size: 0.8rem!important;
    }
    #nuevoPerfil{
        margin-right: 2rem!important;
    }
    @media (min-width: 576px) {
        #sidebar.active {
            width: 60%;
        }
    }
    @media (min-width: 992px) {
        #sidebar.active {
            width: 50%;
        }
        #sidebarCollapse{
            margin-left: -35px!important;
        }
        .info-end ,.page-link{
            font-size: 1rem!important;
        }
        #nuevoPerfil{
            margin-right: 0!important;
        }
    }
    @media (min-width: 1200px) {
        #sidebar.active {
            width: 30%;
        }
    }
    .md-form{
        margin-bottom: 0.5rem!important;
    }
    thead a{
        color:white!important;
    }
    thead a:hover{
        color: #bdbdbd !important;
    }

</style>

<!--Main layout-->
<main class="mx-lg-5">
    <div class="container-fluid">
        <!--Grid row-->
        <div class="row wow fadeIn">
            <!--Grid column-->
            <div class="col-12">
                <!--Card-->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header text-center ">LISTA DE PERFILES</div>

                    <!--Card content-->
                    <div class="card-body d-flex px-4 px-lg-5">
                        <div class="wrapper">
                            <nav class="navbar-expand py-0">
                                <button type="button" title="Búsqueda" id="sidebarCollapse" class="botenviar float-left" style="padding: 0rem 8px!important; border: none; margin-left: -18px; border-radius: 10px;">
                                    <i class="fas fa-align-right"></i>
                                </button>
                            </nav>

                            <!-- Sidebar -->
                            <nav id="sidebar" class="py-0">
                                <div class="card w-100">
                                    <div class="card-header">Criterio de Búsqueda</div>
                                    <div class="card-body">
                                        <form name="form1" method="GET" action="iu_perfil.php">
                                            <input type="hidden" name="cantidadfilas" value="<?=$tampag??''?>">
                                            <div class="form-row">
                                                <div class="col-12">
                                                    <div class="md-form">
                                                        <input name="cDescPerfil" type="text" id="cDescPerfil" class="FormPropertReg form-control" value="<?=$_GET['cDescPerfil']??''?>">
                                                        <label for="cDescPerfil">Tipo de Perfil</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row justify-content-center py-0">
                                                        <div class="col- mx-3 mb-3">
                                                            <button class="botenviar" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'">Buscar</button>
                                                        </div>
                                                        <div class="col- mx-3">
                                                            <button class="botenviar"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'">Restablecer</button>
                                                        </div>
                                                    </div>
                                                    <div class="card" style="background-color: rgba(231,234,238,0.42)">
                                                        <div class="card-body">
                                                            <div class="row pl-3 pl-lg-5">
                                                                Exportar en:
                                                            </div>
                                                            <div class="row justify-content-center">
                                                                <div class="col-">
                                                                    <button class="botpelota waves-effect btn-sm mx-1" title="Excel" onClick="window.open('iu_perfil_xls.php?cDescPerfil=<?=$_GET['cDescPerfil']??''?>&campo=<?=$_GET['campo']??''?>&orden=<?=$_GET['orden']??''?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']??''?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                        <i class="far fa-file-excel"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="col-">
                                                                    <button class="botpelota waves-effect btn-sm mx-1" title="Pdf" onClick="window.open('iu_perfil_pdf.php?cDescPerfil=<?=$_GET['cDescPerfil']??''?>&campo=<?=$_GET['campo']??''?>&orden=<?=$_GET['orden']??''?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                        <i class="far fa-file-pdf"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <?php
                        function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                                            $total_paginas = ceil($total/$por_pagina);
                                            $anterior = $actual - 1;
                                            $posterior = $actual + 1;
                                            $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
                                            $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
                
                                            if ($actual>1)
                                                $texto = "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center flex-wrap'>
                                                          <li class='page-item'><a class='page-link' href='$enlace$anterior'>Anterior</a></li> ";
                                            else
                                                $texto = "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center flex-wrap'>
                                                           <li class='page-item disabled'><a class='page-link' href='#'>Anterior</a></li> ";
                
                                            if ($minimo!=1) $texto.= "... ";
                
                                            for ($i=$minimo; $i<$actual; $i++)
                                                $texto .= "  <li class='page-item'><a class='page-link' href='$enlace$i'>$i</a></li> ";
                
                                            $texto .= "<li class='page-item active'>
                                                      <a class='page-link' href='#'>$actual<span class='sr-only'>(current)</span></a></li>";
                
                                            for ($i=$actual+1; $i<=$maximo; $i++)
                                                $texto .= "<li class='page-item'><a class='page-link' href='$enlace$i'>$i</a></li> ";
                
                
                                            if ($maximo!=$total_paginas) $texto.= "... ";
                
                                            if ($actual<$total_paginas)
                                                $texto .= "<li class='page-item'><a class='page-link' href='$enlace$posterior'>Siguiente</a></li></ul></nav>";
                                            else
                                                $texto .= "<li class='page-item disabled'><a class='page-link' href='$enlace$posterior'>Siguiente</a></li></ul></nav>";
                
                                            return $texto;
                                        }

                        //calcula para el conteo
                        $reg1 = ($pag-1) * $tampag;

                        // ordenamiento
                        if(($_GET['campo']??'')==""){
                          $campo="Perfil";
                        }Else{
                          $campo=$_GET['campo'];
                        }

                        if(($_GET['orden']??'')==""){
                          $orden="ASC";
                        }Else{
                          $orden=$_GET['orden'];
                        }

                        //invertir orden
                        if($orden=="ASC") $cambio="DESC";
                        if($orden=="DESC") $cambio="ASC";

                        //Consulta tabla
                        $sql=" SP_PERFIL_LISTA '%".($_GET['cDescPerfil']??'')."%' ,'".$orden."' , '".$campo."' ";

                        ?>

                        <div class="card ml-3" id="tablaResutado">
                            <div class="card-body pl-3 pl-sm-5 pr-lg-5">
                                <div class="row">
                                    <?php
                                    $rs=sqlsrv_query($cnx,$sql);
                                    $total = sqlsrv_has_rows($rs);
                                    $numrows=sqlsrv_has_rows($rs);
                                    ?>
                                    <a class="botpelota ml-auto mb-4" title="Agregar" id="nuevoPerfil" href='iu_nuevo_perfil.php' style="margin-bottom: 1rem"><i class="fas fa-plus"></i></a>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col">
                                        <div class="row justify-content-between">
                                            <div class="col-8 col-sm-3 col-md-2">
                                                <select name="cantidadfilas" id="filas" class="mdb-select" onchange="actualizarfilas()" >
                                                    <option value="5"  id="5">5</option>
                                                    <option value="10" id="10">10</option>
                                                    <option value="20" id="20">20</option>
                                                    <option value="50" id="50">50</option>
                                                </select>
                                                <label>Cantidad</label>
                                            </div>
                                        </div>
                                        <table id="tablaDatos" class="table-sm table-responsive table-hover">
                                            <thead class="text-center text-white" style="border-bottom: solid 1px rgba(0,0,0,0.47);background-color: #0f58ab">
                                                <tr>
                                                    <th>
                                                        <a href="<?=$_SERVER['PHP_SELF']?>?campo=Perfil&orden=<?=$cambio??''?>&cDescPerfil=<?=$_GET['cDescPerfil']??''?>"
                                                           style=" text-decoration:<?php if($campo=="Perfil"){ echo "underline"; }Else{ echo "none";}?>">Descripcion</a>
                                                    </th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            if($numrows!==0){
                                                    for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                                                        sqlsrv_fetch_array($rs, $i);
                                                        $Rs=sqlsrv_fetch_array($rs);
                                                    ?>
                                                        <tr>
                                                            <td><?php echo utf8_encode($Rs['cDescPerfil']);?></td>
                                                            <td class="text-center">
                                                                <a title="Eliminar" href="../controllers/ln_elimina_perfil.php?id=<?php echo $Rs['iCodPerfil'];?>" onClick='return ConfirmarBorrado();'">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </a>
                                                                <a title="Editar" href="/iu_actualiza_perfil.php?cod=<?php echo $Rs['iCodPerfil'];?>&sw=4">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <!--Información inferior-->
                                        <div class="info-end">
                                            <br>
                                            <b>
                                                Resultados del <?php echo $reg1+1 ; ?> al <?php echo min($reg1+$tampag, $total) ; ?>
                                            </b>
                                            <br>
                                            <b>
                                                Total: <?php echo $total; ?>
                                            </b>
                                            <br>
                                        </div>
                                        <br>
                                        <!--/Información inferior-->
                                        <?php echo paginar($pag, $total, $tampag, "iu_perfil?&cantidadfilas=".$tampag."&pag=");?>

                                    </div>
                                </div>
                            </div>
                        </div>
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
<!--Main layout-->
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

    $(document).ready(function() {
        $('.mdb-select').material_select();
    });

    //Sidebar
    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
    //fin

    //Para Cantidad de filas
    document.getElementById(<?php echo $tampag?>).selected = true;

    function actualizarfilas(){
        var valor =Number.parseInt(document.getElementById('filas').value);
        var direc =window.location.pathname;
        window.location =direc+"?cantidadfilas="+valor;
    }
    //fin
</script>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>