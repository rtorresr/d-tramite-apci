<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_req_tupa.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de Requerimientos de Tupa para el Perfil Administrador 
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$cod = $_GET["cod"];
$sw = $_GET["sw"]??'';
$pag = $_GET['pag']??1;
$tampag = $_GET['cantidadfilas']??5;
$flgEliminar = $_GET['flg']??'';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
</head>
<body class="theme-default has-fixed-sidenav">
	<?php include("includes/menu.php");?>

    <!--Main layout-->
     <main class="mx-lg-5"  >
         <div class="container-fluid">
              <!--Grid row-->
             <div class="row wow fadeIn">
                  <!--Grid column-->
                 <div class="col-md-12 mb-12">
                      <!--Card-->
                     <div class="card">
                          <!-- Card header -->
                         <div class="card-header text-center "> >> Maestra Requisitos de Tupa</div>
                          <!--Card content-->
                         <div class="card-body">
                            <form name="form1" method="GET" action="iu_req_tupa.php">
                                <input type="hidden" name="cod" value="<?php echo $_GET['cod'];?>">
                                <table width="796" border="0" align="center">
                                  <tr>
                                      <td width="844" colspan="2" align="right">
                                          <button class="btn btn-primary" type="button" onclick="window.open('iu_tupa.php', '_self');" onMouseOver="this.style.cursor='hand'">
                                              <b>Regresar</b><img src="images/icon_retornar.png" width="17" height="17" border="0">
                                          </button>
                                          <button class="btn btn-primary" onClick="window.open('iu_req_tupa_xls.php?cod=<?=$_GET['cod']?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                              <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0">
                                          </button>
                                          <button class="btn btn-primary" onClick="window.open('iu_req_tupa_pdf.php?cod=<?=$_GET['cod']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                              <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0">
                                          </button>
                                      </td>
                                  </tr>
                                </table>
                            </form>

                             <div>
                                 <select name="cantidadfilas" id="cantidadfilas" class="mdb-select">
                                     <option value="5"  id="5">5</option>
                                     <option value="10" id="10">10</option>
                                     <option value="20" id="20">20</option>
                                     <option value="50" id="50">50</option>
                                 </select>
                                 <label>Cantidad</label>
                             </div>

                            <table width="800" border="1" align="center">
                                <input type="hidden" name="iCodTupaRequisito" value="<?=$Rs['iCodTupaRequisito'];?>">
                                <input type="hidden" name="iCodTupa" value="<?=$Rs['iCodTupa']?>">
                                <input type="hidden" name="cod" value="<?=$_GET['cod']?>">
                                <?php
                            // ordenamiento
                            if($_GET['campo']??''==""){
                                $campo="Requisito";
                            }else{
                                $campo=$_GET['campo'];
                            }

                            if($_GET['orden']??''==""){
                                $orden="ASC";
                            }else{
                                $orden=$_GET['orden'];
                            }
                            //invertir orden
                            if($orden=="ASC") $cambio="DESC";
                            if($orden=="DESC") $cambio="ASC";
                            /* $sql= " select * from Tra_M_Tupa_Requisitos ";
                            $sql.= " where iCodTupaRequisito >0 ";
                            $sql.= " AND iCodTupa ='$cod'" ;
                            $sql.= " ORDER BY nNumTupaRequisito ASC"; */
                             //echo $sql;
                             $sql= " SP_REQUISITO_TUPA_LISTA '$cod' ,'".$orden."' , '".$campo."'  " ;
                             $rs=sqlsrv_query($cnx,$sql,array(),array("Scrollable"=>"Buffered"));
                             $total = sqlsrv_num_rows($rs);
                             $reg1 = ($pag-1) * $tampag;
                            ?>
                                <tr>
                                    <td width="573" class="headCellColum">Nombre Requisito</td>
                                    <td width="126" class="headCellColum">Estado</td>
                                    <td width="79" class="headCellColum">Opciones</td>
                                </tr>
                                <?php
                                if($total==0){
                                    echo "NO SE ENCONTRARON REGISTROS<br>";
                                    echo "TOTAL DE REGISTROS : ".$total;
                                }else{
                                    echo "TOTAL DE REGISTROS : ".$total;
                                    for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                                        $Rs=sqlsrv_fetch_array($rs,3,5,$i);
                                            if ($color??'' == "#CEE7FF"){
                                                      $color = "#F9F9F9";
                                                        }else{
                                                      $color = "#CEE7FF";
                                                        }
                                                        if ($color == ""){
                                                      $color = "#F9F9F9";
                                                        }
                                ?>
                                        <tr bgcolor="<?=$color?>">
                                            <td align="left"><?=utf8_encode($Rs['cNomTupaRequisito'])?></td>
                                            <td>
                                                <?php
                                                if ($Rs['nEstadoTupaRequisito']==1) {
                                                    echo '<div style="color:#005E2F">Activo</div>';
                                                }else{
                                                    echo '<div style="color:#950000">Inactivo</div>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="../controllers/ln_elimina_req_tupa.php?id=<?=$Rs['iCodTupaRequisito']?>&cod=<?=$Rs['iCodTupa'];?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
                                                <?php
                                                if ($flgEliminar==1){
                                                 echo "<script> alert('No se puede eliminar requisito, uso en trámite.') </script>";
                                                }
                                                ?>
                                                <a href="/iu_actualiza_req_tupa.php?cod=<?=$Rs['iCodTupaRequisito'];?>&sw=9"><i class="fas fa-edit"></i></a>
                                            </td>
                                          </tr>

                                <?php
                                    }
                                }
                                ?>
                            </table>
                                <?php
                                include_once "../core/paginador.php";
                                echo paginar($pag, $total, $tampag, "iu_req_tupa.php?sw=8&cod=".$cod."&cantidadfilas=".$tampag."&pag=");
                                ?>

                            <table width="800" border="0" align="center">
                              <tr>
                                <td align="right"><a href="/iu_nuevo_req_tupa.php?cod=<?=$_GET['cod']?>&sw=8">Nuevo Requisito</a></td>
                              </tr>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
     </main>

    <?php
    include("includes/userinfo.php");
    include("includes/pie.php"); ?>
    <script>
        function ConfirmarBorrado()
        {
            if (confirm("Esta seguro de eliminar el registro?")){
                return true;
            }else{
                return false;
            }
        }

        //Para Cantidad de filas
        document.getElementById(<?php echo $tampag?>).selected = true;

        document.querySelector('select#cantidadfilas').addEventListener('change',function () {
            var valor =Number.parseInt(document.getElementById('cantidadfilas').value);
            var direc =window.location.pathname;
            window.location =direc+"?cod=<?=$_GET['cod']?>&sw=8&cantidadfilas="+valor;
        });
    </script>
</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>