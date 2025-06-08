<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_tupa.php
SISTEMA: SISTEMA  DE TRAMITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar la Tabla Maestra de Tupa para el Perfil Administrador
PROPIETARIO: AGENCIA PERUANA DE COOPERACION INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        DescripciOn
------------------------------------------------------------------------
1.0   APCI       03/08/2018   CreaciOn del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
$pag = $_GET['pag']??1;
$tampag = $_GET['cantidadfilas']??5;

If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
    <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" >
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
                            Mantenimiento >> TUPA
                        </div>
                        <!--Card content-->
                        <div class="card-body">
                            <form name="form1" method="GET" action="iu_tupa.php">
                                 <fieldset>
                                     <legend>Criterios de B&uacute;squeda</legend>
                                      <strong>Clase de Procedimiento:</strong>
                                          <?php //Consulta para rellenar el combo Oficina
                                               $sqlTup="SP_CLASE_TUPA_LISTA_COMBO ";
                                               $rsTup=sqlsrv_query($cnx,$sqlTup);
                                            ?>
                                      <select name="iCodTupaClase" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                              searchable="Buscar aqui.." id="TupaClase"  >
                                           <option value="">Seleccione:</option>
                                                <?php
                                                while ($RsTup=sqlsrv_fetch_array($rsTup)){
                                                                            if($RsTup['iCodTupaClase']==$_REQUEST['iCodTupaClase']??''){
                                                                                $selecClas="selected";
                                                                            }else{
                                                                                $selecClas="";
                                                                            }
                                                                            echo "<option value=".$RsTup["iCodTupaClase"]." ".$selecClas.">".$RsTup["cNomTupaClase"]."</option>";
                                                                        }
                                                                        sqlsrv_free_stmt($rsTup);
                                                 ?>
                                      </select>

                                     <strong>Nombre de Procedimiento Tupa:</strong>
                                     <input name="cNomTupa" class="FormPropertReg form-control" type="text" value="<?=$_REQUEST['cNomTupa']??''?>" />

                                     <strong>Estado:</strong>
                                     <select name="txtestado"  class="FormPropertReg form-control" id="txtestado">
                                          <option value="" selected>Seleccione:</option>
                                                                            <?php  if (($_REQUEST['txtestado']??'')==1){
                                                                                echo "<OPTION value=1 selected>Activo</OPTION> ";
                                                                            }
                                                                            else{
                                                                                echo "<OPTION value=1>Activo</OPTION> ";
                                                                            }
                                                                            if (($_REQUEST['txtestado']??'')==2){
                                                                                echo "<OPTION value=2 selected>Inactivo</OPTION> ";
                                                                            }
                                                                            else{
                                                                                echo "<OPTION value=2>Inactivo</OPTION> ";
                                                                            }
                                                                            ?>
                                     </select>

                                     <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'">
                                         <b>Buscar</b>&nbsp;<img src="images/icon_buscar.png" width="17" height="17" border="0">
                                     </button>
                                 </fieldset>
                             </form>
                            <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>','_self');" onMouseOver="this.style.cursor='hand'">
                                <b>Restablecer</b>&nbsp;&nbsp;<img src="images/icon_clear.png" width="17" height="17" border="0">
                            </button>
                            <?php
                            // ordenamiento
                            if($_GET['campo']??''==""){
                                $campo="Nombre";
                            }else{
                                $campo=$_GET['campo'];
                            }

                            if($_GET['orden']??''==""){
                                $orden="ASC";
                            }else{
                                $orden=$_GET['orden'];
                            }

                            //invertir orden
                            if($orden=="DESC") $cambio="ASC";
                            if($orden=="ASC") $cambio="DESC";
                            ?>
                            <button class="btn btn-primary" onClick="window.open('iu_tupa_xls.php?cNomTupa=<?=$_GET['cNomTupa']?>&iCodTupaClase=<?=$_GET['iCodTupaClase']?>&txtestado=<?=$_GET['txtestado']?>&orden=<?=$orden?>&campo=<?=$campo?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                <b>a Excel</b>&nbsp;<img src="images/icon_excel.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary" onClick="window.open('iu_tupa_pdf.php?cNomTupa=<?=$_GET['cNomTupa']?>&iCodTupaClase=<?=$_GET['iCodTupaClase']?>&txtestado=<?=$_GET['txtestado']?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                <b>a Pdf</b>&nbsp;&nbsp;<img src="images/icon_pdf.png" width="17" height="17" border="0">
                            </button>
                            <a class="btn btn-default" href='iu_nuevo_tupa.php'>Nuevo Tupa</a>
                            <hr>
                            <table class="table">
                              <?php
                                            /*
                                            $sql="select * from Tra_M_Tupa ";
                                            $sql.=" WHERE iCodTupa>0 ";
                                            if($_GET[iCodTupaClase]!=""){
                                            $sql.=" AND iCodTupaClase='$_GET[iCodTupaClase]' ";
                                            }
                                            if($_GET[cNomTupa]!=""){
                                            $sql.=" AND cNomTupa like '%$_GET[cNomTupa]%' ";
                                            }
                                            if($_GET['txtestado']!=""){
                                            $sql.=" AND nEstado='".$_GET['txtestado']."'";
                                                    }
                                            $sql.="ORDER BY iCodTupa ASC"; */

                                            $sql="SP_TUPA_LISTA '".($_GET['iCodTupaClase']??'')."' , '%".($_GET['cNomTupa']??'')."%' , '".($_GET['txtestado']??'')."' , '".$orden."' , '".$campo."'  ";
                                            $rs=sqlsrv_query($cnx,$sql,array(),array('Scrollable'=>'Buffered'));
                                            $total = sqlsrv_num_rows($rs);
                                            $reg1 = ($pag-1) * $tampag;
                                            ?>
                                            <div>
                                                <select name="cantidadfilas" id="cantidadfilas" class="mdb-select">
                                                    <option value="5"  id="5">5</option>
                                                    <option value="10" id="10">10</option>
                                                    <option value="20" id="20">20</option>
                                                    <option value="50" id="50">50</option>
                                                </select>
                                                <label>Cantidad</label>
                                            </div>
                                            <tr>
                                                <td width="63" class="headCellColum"><a style=" text-decoration:<?php if($campo=="Clase"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Clase&orden=<?=$cambio?>&cNomOficina=<?=$_GET['cNomOficina']??''?>">Clase</a></td>
                                                <td width="79" class="headCellColum">N&ordm; de Requisitos</td>
                                                <td width="317" class="headCellColum"><a style=" text-decoration:<?php if($campo=="Nombre"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Nombre&orden=<?=$cambio?>&cNomTupa=<?=$_GET['cNomTupa']??''?>">Tupa</a></td>
                                                <td width="74" class="headCellColum"><a style=" text-decoration:<?php if($campo=="Silencio"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Silencio&orden=<?=$cambio?>">Silencio Adm.</a></td>
                                                <td width="84" class="headCellColum"><a style=" text-decoration:<?php if($campo=="Dias"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Dias&orden=<?=$cambio?>">Dias de Tupa</a></td>
                                                <td width="67" class="headCellColum"><a style=" text-decoration:<?php if($campo=="Estado"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Estado&orden=<?=$cambio?>&cNomOficina=<?=$_GET['cNomOficina']??''?>">Estado</a></td>
                                                <td width="70" class="headCellColum">Opciones</td>
                                                <td width="70" class="headCellColum">Op. Flujo</td>
                                            </tr>
                                            <?php
                                            $numrows=sqlsrv_num_rows($rs);
                                            if($numrows==0){
                                                echo "NO SE ENCONTRARON REGISTROS<br>";
                                                echo "TOTAL DE REGISTROS : ".$numrows;
                                            } else {
                                                echo "<div align=\"center\">TOTAL DE REGISTROS : $numrows  </div><br>";
                                                for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                                                    $Rs=sqlsrv_fetch_array($rs,3,5,$i);
                                                    //while ($Rs=sqlsrv_fetch_array($rs)){
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
                                                        <td><?php
                                                            $sqlTuc="SELECT * FROM Tra_M_Tupa_Clase WHERE iCodTupaClase=".$Rs['iCodTupaClase'];
                                                            $rsTuc=sqlsrv_query($cnx,$sqlTuc);
                                                            $RsTuc=sqlsrv_fetch_array($rsTuc);
                                                            echo $RsTuc['cNomTupaClase'];
                                                            ?>
                                                        </td>
                                                        <td align="center"><?php
                                                            $sqlReq="SELECT * FROM Tra_M_Tupa_Requisitos WHERE iCodTupa='".$Rs['iCodTupa']."'";
                                                            $rsReq=sqlsrv_query($cnx,$sqlReq,array(),array('Scrollable'=>'Buffered'));
                                                            $RsReq=sqlsrv_num_rows($rsReq);
                                                            echo $RsReq;
                                                            ?>
                                                        </td>
                                                        <td align="left">
                                                            <a href="/iu_req_tupa.php?cod=<?php echo $Rs['iCodTupa'];?>&sw=8"><?php echo $Rs['cNomTupa'];?></a>
                                                        </td>
                                                        <td align="center"><?php if ($Rs['nSilencio']==1){
                                                                echo "SAP";
                                                            }
                                                            else if ($Rs['nSilencio']==0){
                                                                echo "SAN";
                                                            }
                                                            ?></td>
                                                        <td align="center"><?php echo $Rs['nDias'];?></td>
                                                        <td align="center"><?php if($Rs['nEstado']==1){?>
                                                                <div style="color:#005E2F">Activo</div>
                                                            <?php }else{?>
                                                                <div style="color:#950000">Inactivo</div>
                                                            <?php }?></td>
                                                        <td>
                                                                <a href="/views/iu_actualiza_tupa.php?cod=<?=$Rs['iCodTupa'];?>&sw=7&s1=<?=$Rs['iCodTupaClase']?>&s2=<?=$Rs['iCodOficina']?>&iCodTupaClase=<?=$Rs['iCodTupaClase']?>&cNomTupa=<?=utf8_encode($Rs['cNomTupa'])?>&txtestado=<?=$Rs['nEstado']?>&pag=<?=$pag?>"><img src="images/icon_edit.png" width="16" height="16" alt="Actualizar Doc Tupa" border="0"></a>
                                                                <?php if($RsReq==0){?>
                                                                    <a href="../controllers/ln_elimina_tupa.php?id=<?=$Rs['iCodTupa']?>&iCodTupaClase=<?=$Rs['iCodTupaClase']?>&cNomTupa=<?=utf8_encode($Rs['cNomTupa'])?>&txtestado=<?=$Rs['nEstado']?>&pag=<?=$pag?>" onClick="return ConfirmarBorrado()" ><img src="images/icon_del.png" width="16" height="16" alt="Eliminar Doc Tupa" border="0"></a>
                                                                <?php }
                                                                else if($RsReq > 0){
                                                                    ?>
                                                                    <img src="images/icon_del_off.png" width="16" alt="No se puede Eliminar Doc Tupa" height="16" border="0">
                                                                <?php }?>
                                                        </td>
                                                        <td>
                                                                <a href="registroDetalleFlujoTupa.php?iCodTupa=<?=$Rs['iCodTupa']?>" rel="lyteframe" title="Detalles Flujo Tupa" rev="width: 880px; height: 300px; scrolling: auto; border:no"><img src="images/icon_view.png" alt="Ver detalles del remitente" width="16" height="16" border="0"></a>
                                                                <a href="/registroWorkFlow.php?cod=<?php echo $Rs['iCodTupa'];?>&sw=7&s1=<?=$Rs['iCodTupaClase']?>&s2=<?=$Rs['iCodOficina']?>"><img src="images/workflow.png" width="28" height="20" alt="Generar Flujo de Documentos Tupa" border="0"></a>
                                                        </td>
                                                    </tr>

                                                    <?php
    }
                                            }
                                            ?>
                            </table>
                            <?php
                            include_once "../core/paginador.php";
                            echo paginar($pag, $total, $tampag, "iu_tupa.php?iCodTupaClase=".($_GET['iCodTupaClase']??'')."&cNomTupa=".($_GET['cNomTupa']??'')."&txtestado=".($_GET['txtestado']??'')."&cantidadfilas=".$tampag."&pag=");?>


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

        //Para Cantidad de filas
        document.getElementById(<?php echo $tampag?>).selected = true;

        document.querySelector('select#cantidadfilas').addEventListener('change',function () {
            var valor =Number.parseInt(document.getElementById('cantidadfilas').value);
            var direc =window.location.pathname;
            window.location =direc+"?cantidadfilas="+valor;
        });

    </script>
    <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>