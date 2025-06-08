<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
  include_once("../conexion/conexion.php");
//cDescTipoDoc=&Entrada=1&Interno=&Salida=&pag=2
$pag = $_GET['pag']??0;
    $pageTitle = "Mantenimiento Tipo de Documento";
    $activeItem = "iu_tipo_doc.php";
    $navExtended = true;
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
                    <div class="card-header text-center ">Mantenimiento Tipo de Documentos</div>
                    <!--Card content-->
                    <div class="card-body">
                        <form name="form1" method="GET" action="iu_tipo_doc.php">
                            <div class="form-row">
                                <div class="col-lg-2">
                                    Tipo de Documento:
                                    <input name="cDescTipoDoc"  class="FormPropertReg form-control" type="text" value="" />
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="Entrada" class="form-check-input" id="Entrada" value="1" <?php if(isset($_GET['Entrada']))if($_GET['Entrada']==1) echo "checked"?> >
                                        <label class="form-check-label" for="Entrada">Entradas</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="Interno" class="form-check-input" id="Interno" value="1" <?php if(isset($_GET['Interno'])) if($_GET['Interno']==1) echo "checked"?> >
                                        <label class="form-check-label" for="Interno">Internos</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="Salida" class="form-check-input" id="Salida" value="1" <?php if(isset($_GET['Salida'])) if($_GET['Salida']==1) echo "checked"?> >
                                        <label class="form-check-label" for="Salida">Salidas</label>
                                    </div>
                                </div>
                            </div>
                              &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'">
                                <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b>
                                <img src="images/icon_clear.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary" onClick="window.open('iu_tipo_doc_xls.php?cDescTipoDoc=<?=$_GET['cDescTipoDoc']??''?>&cSiglaDoc=<?=$_GET['cSiglaDoc']??''?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET['Salida']??''?>&orden=<?=$_GET['orden']??''?>&campo=<?=$_GET['campo']??''?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']??''?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary" onClick="window.open('iu_tipo_doc_pdf.php?cDescTipoDoc=<?=$_GET['cDescTipoDoc']??''?>&cSiglaDoc=<?=$_GET['cSiglaDoc']??''?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET['Salida']??''?>&orden=<?=$_GET['orden']??''?>&campo=<?=$_GET['campo']??''?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0">
                            </button>
                            <?= "<a class='btn btn-primary' href='iu_nuevo_tipo_doc.php'>Nuevo Tipo Documento</a>";?>
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
                        if(isset($_GET['campo'])) {
                            if ($_GET['campo'] == "") {
                                $campo = "Tipo";
                            } Else {
                                $campo = $_GET['campo'];
                            }
                        }else{
                            $campo = "";
                        }

                        if(isset($_GET['orden'])) {
                            if($_GET['orden']==""){
                                $orden="ASC";
                            }Else{
                                $orden=$_GET['orden'];
                            }
                        }else{
                            $orden = "";
                        }

                        //invertir orden
                        if($orden=="ASC") $cambio="DESC";
                        if($orden=="DESC") $cambio="ASC";

                        //echo "==>".$_GET['cDescTipoDoc3'];
                        $sql="SP_TIPO_DOCUMENTO_LISTA '".($_GET['Entrada']??'')."' , '".($_GET['Interno']??'')."', '".($_GET['Salida']??'')."' , '%".($_GET['cDescTipoDoc']??'')."%' , '%".($_GET['cSiglaDoc']??'')."%' ,'".$orden."' , '".$campo."' ";
                        $rs=sqlsrv_query($cnx,$sql, array(), array('Scrollable' =>'buffered'));
                        $total = sqlsrv_has_rows($rs);
                        ?>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width="181" class="headCellColum">
                                        <a href="<?=$_SERVER['PHP_SELF']?>?campo=Tipo&orden=<?=$cambio??''?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']??''?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET['Salida']??''?>"  style=" text-decoration:<?php if($campo=="Tipo"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></th>
                                    <th width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Entrada&orden=<?=$cambio??''?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET['Salida']??''?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']??''?>"  style=" text-decoration:<?php if($campo=="Entrada"){ echo "underline"; }Else{ echo "none";}?>">Entradas</a></th>
                                    <th width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Interno&orden=<?=$cambio??''?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET['Salida']??''?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']??''?>"  style=" text-decoration:<?php if($campo=="Interno"){ echo "underline"; }Else{ echo "none";}?>">Internos</a></th>
                                    <th width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Salida&orden=<?=$cambio??''?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET['Salida']??''?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']??''?>"  style=" text-decoration:<?php if($campo=="Salida"){ echo "underline"; }Else{ echo "none";}?>">Salidas</a></th>
                                    <th width="80" class="headCellColum">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                $numrows=sqlsrv_has_rows($rs);
                                if($numrows==0){
                                        echo "NO SE ENCONTRARON REGISTROS<br>";
                                }else{

                                while ($Rs=sqlsrv_fetch_array($rs)){
                                //while ($Rs=sqlsrv_fetch_array($rs)){
                                        if (isset($color)) {
                                            if ($color == "#CEE7FF") {
                                                $color = "#F9F9F9";
                                            } else {
                                                $color = "#CEE7FF";
                                            }
                                            if ($color == "") {
                                                $color = "#F9F9F9";
                                            }
                                        }
                                ?>
                                <tr bgcolor="<?=$color??''?>">
                                    <td height="23" align="left"><?php echo utf8_encode($Rs['cDescTipoDoc']);?></td>
                                    <td>
                                        <a  href="../controllers/ln_actualiza_flg_tipo_doc.php?Entrada=<?php echo $Rs['nFlgEntrada'];?>&id=<?php echo $Rs['cCodTipoDoc'];?>" >
                                                <label>
                                                     <?php if($Rs['nFlgEntrada']=='1'){echo 'SÍ';} else{echo 'NO';}?>
                                                    <span class="slider round"></span>
                                                </label>
                                        </a>

                                    </td>
                                    <td><a href="../controllers/ln_actualiza_flg_tipo_doc.php?Interno=<?php echo $Rs['nFlgInterno'];?>&id=<?php echo $Rs['cCodTipoDoc'];?>" ><?php if($Rs['nFlgInterno']=='1'){echo 'SI';} else{echo 'NO';}?></a></td>
                                    <td><a href="../controllers/ln_actualiza_flg_tipo_doc.php?Salida=<?php echo $Rs['nFlgSalida'];?>&id=<?php echo $Rs['cCodTipoDoc'];?>" ><?php if($Rs['nFlgSalida']=='1'){echo 'SI';} else{echo 'NO';}?></a></td>
                                    <td>

                                        <?php
                                          $sqlTipoDeDoc = "SELECT COUNT(*) AS 'TOTAL' FROM Tra_M_Tramite WHERE cCodTipoDoc = ".$Rs['cCodTipoDoc'];
                                          $rsTipoDeDoc  = sqlsrv_query($cnx,$sqlTipoDeDoc);
                                          $RsTipoDeDoc  = sqlsrv_fetch_array($rsTipoDeDoc);

                                          if ($RsTipoDeDoc['TOTAL'] == 0) {
                                        ?>
                                          <a href="../controllers/ln_elimina_tipo_doc.php?id=<?php echo $Rs['cCodTipoDoc'];?>&Entrada=<?=$_REQUEST['Entrada']??''?>&Interno=<?=$_REQUEST['Interno']??''?>&Salida=<?=$_REQUEST['Salida']??''?>&cDescTipoDoc=<?=$_REQUEST['cDescTipoDoc']??''?>&pag=<?=$pag??''?>" onClick='return ConfirmarBorrado();'">
                                          <i class="far fa-trash-alt"></i>
                                        </a>
                                        <?php
                                          }
                                        ?>
                                            <a href="../views/iu_actualiza_tipo_doc.php?cod=<?php echo $Rs['cCodTipoDoc'];?>&sw=5&Entrada=<?php echo $Rs['nFlgEntrada']?>&Interno=<?php echo $Rs['nFlgInterno']?>&Salida=<?php echo $Rs['nFlgSalida']?>&cDescTipoDoc=<?= utf8_encode($Rs['cDescTipoDoc'])?>&pag=<?=$pag?>">
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

                        <?php
                        echo "TOTAL DE REGISTROS : ".$numrows."\t"; ?>

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