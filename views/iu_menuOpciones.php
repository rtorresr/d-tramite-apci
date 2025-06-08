<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

</head>
<body>
<?php include("includes/menu.php");?>

<style>
    .form-control{
        font-size: 0.8rem!important;
    }
    .md-form{
        margin-top: 1rem!important;
        margin-bottom: 0.8rem!important;
    }
    .dropdown-content li>a, .dropdown-content li>span {
        font-size: 0.8rem!important;
    }
    .select-wrapper .search-wrap {
        padding-top: 0rem!important;
        margin: 0 0.2rem!important;
    }
    .select-wrapper input.select-dropdown {
        font-size: 0.9rem!important;
    }
    label.select{
        margin-bottom: 0!important;
        font-size: 0.8rem!important;
    }
    @media (min-width: 576px) {
        .md-form {
            margin-top: 2.3rem !important;
        }
    }
    @media (min-width: 576px) {
        input[value='Agregar']{
            margin-top: 2rem!important;
        }
    }
    @media (min-width: 992px) {
        input[value='Ordenar Perfiles']{
            margin-top: 2.2rem!important;
        }
    }
    td{
        border: none!important;
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
                    <div class="card-header text-center ">LISTA DE PERMISOS POR PERFIL</div>
                    <!--Card content-->
                    <div class="card-body">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-11 col-lg-9 col-xl-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="../models/ad_menuOpciones_data.php" method="POST" name="formAdd">
                                                    <input type="hidden" name="opcion" value="5">
                                                    <div class="row justify-content-center">
                                                        <div class="col-12 col-sm-7 col-md-5  col-xl-6">
                                                            <label class="select">Perfil</label>
                                                            <select name="iCodPerfil" class="FormPropertReg mdb-select colorful-select dropdown-primary"   searchable="Buscar aqui..">
                                                                <option value="">Seleccione:</option>
                                                                <?php    $sqlPer="select * from Tra_M_Perfil ";
                                                                $rsPer=sqlsrv_query($cnx,$sqlPer);
                                                                while ($RsPer=sqlsrv_fetch_array($rsPer)){
                                                                    if($RsPer["iCodPerfil"]==$Rs['iCodPerfil']){
                                                                        $selecP="selected";
                                                                    }Else{
                                                                        $selecP="";
                                                                    }
                                                                    echo "<option value=".$RsPer["iCodPerfil"]." ".$selecP.">".$RsPer["cDescPerfil"]."</option>";
                                                                }
                                                                sqlsrv_free_stmt($rsPer);
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-sm-5 col-md-4 col-xl-4">
                                                            <label class="select">Menu</label>
                                                            <select name="cNombreMenu" class="FormPropertReg mdb-select colorful-select dropdown-primary">
                                                                <option value="">Disponibles:</option>
                                                                <option value="REGISTRO">REGISTRO</option>
                                                                <option value="BANDEJA">BANDEJA</option>
                                                                <option value="CONSULTA">CONSULTA</option>
                                                                <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-">
                                                            <input name="button" type="button" class="botenviar"  value="Agregar" onclick="Agregar();">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-xl-4 mt-3">
                                        <div class="row justify-content-center">
                                            <div class="col-">
                                                <input name="button" type="button" class="botenviar" value="Ordenar Perfiles" onclick="Ordenar();">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        /*$sql= "SELECT * FROM Tra_M_Perfil,Tra_M_Menu WHERE Tra_M_Perfil.cTipoPerfil=Tra_M_Menu.iCodPerfil ORDER BY Tra_M_Perfil.cDescPerfil,  Tra_M_Menu.nNombreOrden ASC ";*/
                        $sql= "SP_MENU_OPCIONES_LISTA  ";
                        $rs=sqlsrv_query($cnx,$sql);
                        ?>
                        <div class="card">
                            <div class="card-body px-5">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-lg-11 col-xl-9">
                                        <table class="table-sm table-responsive table-hover">
                                            <form action="../models/ad_menuOpciones_data.php" method="POST" name="formulario">
                                                <input type="hidden" name="opcion" value="4">
                                                <thead class="text-center" style="border-bottom: solid 1px rgba(0,0,0,0.47)">
                                                <tr>
                                                    <th>Perfil</th>
                                                    <th>Menu</th>
                                                    <th>Sub Opciones</th>
                                                    <th>Opciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
    $Perfil="";
                                                while ($Rs=sqlsrv_fetch_array($rs)){
                                                    if($Rs[cDescPerfil]!=$Perfil || $Perfil==""){
                                                        echo "<tr style='border-top: solid 1px rgba(0,0,0,0.34)'>";
                                                    }Else{
                                                        echo "<tr>";
                                                    }
                                                    ?>
                                                        <td class="text-center">
                                                            <?php
                                                            if($Rs[cDescPerfil]!=$Perfil){
                                                                echo $Rs[cDescPerfil];
                                                            }Else{
                                                                echo "&nbsp;";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php/*$sqlSm= "SELECT * FROM Tra_M_Menu_Items,Tra_M_Menu_Lista WHERE Tra_M_Menu_Items.iCodSubMenu=Tra_M_Menu_Lista.iCodSubMenu AND Tra_M_Menu_Lista.iCodMenu='$Rs[iCodMenu]' ORDER BY Tra_M_Menu_Lista.nOrden ASC";*/
                                                            $sqlSm= "SP_MENU_ITEMS_LISTA '$Rs[iCodMenu]' ";
                                                            $rsSm=sqlsrv_query($cnx,$sqlSm);
                                                            ?>
                                                            <table class="table">
                                                                <tbody class="w-100">
                                                                    <tr>
                                                                        <td><?=strtoupper($Rs[cNombreMenu])?></td>
                                                                        <td>
                                                                            <input type="text" name="nNombreOrden[]" class="text-center mx-0" style="width: 25px;" value="<?=$Rs['nNombreOrden']?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                                                            <input type="hidden" name="iCodMenu[]" value="<?=$Rs[iCodMenu]?>">
                                                                        </td>
                                                                        <td>
                                                                            <?php if($RsSm=sqlsrv_has_rows($rsSm)==0){?>
                                                                                <a href="../models/ad_menuOpciones_data.php?opcion=6&iCodMenu=<?=$Rs['iCodMenu']?>"><i class="far fa-trash-alt"></i></a>
                                                                            <?php } else{?>
                                                                                <img src="images/icon_del_off.png" width="16" height="16" border="0">
                                                                            <?php}?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table class="table">
                                                                <tbody>
                                                                <?php    while ($RsSm=sqlsrv_fetch_array($rsSm)) {
                                                                    ?>
                                                                    <tr>
                                                                        <td  class="py-0" bgcolor="<?= trim($RsSm[cCodColor]) ?>">&#149;&nbsp;<?= $RsSm[cNombreSubMenu] ?></td>
                                                                        <td  class="py-0 pb-1" style="width: 50px!important;">
                                                                            <input type="text" name="nOrden[]" class="text-center mx-0" style="width: 25px;" value="<?= $RsSm[nOrden] ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                                                            <input type="hidden" name="iCodMenuLista[]" value="<?= $RsSm[iCodMenuLista] ?>"></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="iu_menuOpciones_edit.php?iCodMenu=<?=$Rs[iCodMenu]?>"><i class="fas fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                $Perfil=$Rs[cDescPerfil];
                                                }
                                                ?>
                                                </tbody>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

	                </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

<script>if(<?php echo $_GET[error]?>){alert('¡Menu ya agregado!');}</script>
    <script Language="JavaScript">
        <!--

        function Agregar()
        {
            if (formAdd.iCodPerfil.value.length == "")
            {
                alert("Seleccione Perfil");
                formAdd.iCodPerfil.focus();
                return (false);
            }
            if (formAdd.cNombreMenu.value.length == "")
            {
                alert("Ingrese Nombre de nuevo Menu");
                formAdd.cNombreMenu.focus();
                return (false);
            }
            document.formAdd.submit();
        }


        function Ordenar()
        {
            document.formulario.submit();
        }

        //--></script>

<script>
    //mdboostrap selection
    $(document).ready(function() {
        $('.mdb-select').material_select();
    });
</script>
</body>
</html>

<?php }
else{
   header("Location: ../index-b.php?alter=5");
}
?>