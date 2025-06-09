<style>
  #miid::placeholder {
  color: #666666;
  text-align: left;
  padding-top: 10px;
  overflow: hidden;
  resize: none;
  border-radius: 4px;
          margin: 10px;
}
 </style>
<?php
session_start();
$pageTitle = "Actualizar de Trabajador";
$activeItem = "iu_actualiza_trabajadores.php";
$navExtended = false;


If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>        
</head>
<body class="theme-default has-fixed-sidenav" >
    <?php include("includes/menu.php");?>
    <a name="area"></a>    

    <!--Main layout-->
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">            
            <?php
                $sql= "select * from Tra_M_Trabajadores where iCodTrabajador='".$_GET['cod']."'";
                $rs=sqlsrv_query($cnx,$sql);
                $Rs=sqlsrv_fetch_array($rs);
            ?>
                <form action="../controllers/ln_actualiza_trabajador.php" method="post" name="form1">
                    <input type="hidden" name="iCodTrabajador" value="<?=$_GET['cod']?>">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Datos Personales</legend>
                                        <div class="row">
                                            <div class="col s12 m6 input-field">
                                                <input name="cNombresTrabajador" type="text" id="cNombresTrabajador" value="<?=trim($Rs['cNombresTrabajador'])?>" class="FormPropertReg form-control">
                                                <label for="cNombresTrabajador">Nombres</label>
                                            </div>
                                            <div class="col s12 m6 input-field">                                                            
                                                <input name="cApellidosTrabajador" type="text" id="cApellidosTrabajador" class="FormPropertReg form-control" value="<?=trim($Rs['cApellidosTrabajador'])?>">
                                                <label for="cApellidosTrabajador">Apellidos</label>
                                            </div>
                                            <div class="col s12 m6 input-field">                                                            
                                                <?php
                                                $sqlDoc="select * from Tra_M_Doc_Identidad ";
                                                $rsDoc=sqlsrv_query($cnx,$sqlDoc);
                                                ?>
                                                <select name="cTipoDocIdentidad" class="FormPropertReg form-control" id="cTipoDocIdentidad">
                                                    <?php
                                                    while ($RsDoc=sqlsrv_fetch_array($rsDoc)){
                                                        if($RsDoc['cTipoDocIdentidad']==$Rs['cTipoDocIdentidad']){
                                                            $selecClas="selected";
                                                        } else{
                                                            $selecClas="";
                                                        }
                                                        echo "<option value=".$RsDoc['cTipoDocIdentidad']." ".$selecClas.">".$RsDoc['cDescDocIdentidad']."</option>";
                                                    }
                                                    sqlsrv_free_stmt($rsDoc);
                                                    ?>
                                                </select>
                                                <label for="cTipoDocIdentidad">Documento:&nbsp;</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="cNumDocIdentidad" type="text" id="cNumDocIdentidad" class="FormPropertReg form-control" value="<?=trim($Rs['cNumDocIdentidad'])?>" onkeypress="if (event.keyCode > 31 && ( event.keyCode < 48 || event.keyCode > 57)) event.returnValue = false;">
                                                <label for="cNumDocIdentidad">N° Doc.</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <input name="cDireccionTrabajador" type="text" id="cDireccionTrabajador" class="FormPropertReg form-control" value="<?=trim($Rs['cDireccionTrabajador'])?>">
                                                <label for="cDireccionTrabajador">Direccion</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <input name="cMailTrabajador" type="text" id="cMailTrabajador" class="FormPropertReg form-control" value="<?=trim($Rs['cMailTrabajador'])?>">
                                                <label for="cMailTrabajador">E-mail</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="cTlfTrabajador1" type="text" id="cTlfTrabajador1" class="FormPropertReg form-control" value="<?=trim($Rs['cTlfTrabajador1'])?>">
                                                <label for="cTlfTrabajador1">Telefono 1</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="cTlfTrabajador2" type="text" id="cTlfTrabajador2" class="FormPropertReg form-control" value="<?=trim($Rs['cTlfTrabajador2'])?>">
                                                <label for="cTlfTrabajador2">Telefono 2</label>
                                            </div>
                                            <div class="col s12 m6 input-field">                                                        
                                                <?php
                                                $sqlOfi="SP_OFICINA_LISTA_COMBO ";
                                                $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                ?>
                                                        <select name="iCodOficina" class="FormPropertReg" id="iCodOficina">
                                                            <option value="0">Seleccione:</option>
                                                            <?php
                                                            while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                                                if($RsOfi["iCodOficina"]==$Rs['iCodOficina']){
                                                                    $selecClas="selected";
                                                                }else{
                                                                    $selecClas="";
                                                                }
                                                                echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                                                            }
                                                            sqlsrv_free_stmt($rsOfi);
                                                            ?>
                                                        </select>
                                                        <label class="select">Oficina:&nbsp;</label>
                                            </div>                                                  
                                            <div class="col s12 m6 input-field">                                                            
                                                <select name="txtestado" class="FormPropertReg" id="txtestado">}
                                                        <?php
                                                            if ($Rs['nFlgEstado']==1){
                                                                echo '<option value="1" selected>Activo</option>';
                                                            }
                                                            else{
                                                                echo '<option value="1">Activo</option>';
                                                            }
                                                            if ($Rs['nFlgEstado']==0){
                                                                echo '<option value="0" selected>Inactivo</option>';
                                                            }
                                                            else{
                                                                echo '<option value=0>Inactivo</option>';
                                                            }
                                                        ?>
                                                </select>
                                                <label for="txtestado">Estado:&nbsp;</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <!--input name="comentario" type="text" id="comentario" class="FormPropertReg form-control" value="<?=trim($Rs['comentario'])?>">
                                                <label for="comentario">descripcion: --/--/---- [medio] - Comentario</label-->
                                                <textarea name="comentario" cols="10" rows="50" id="miid" placeholder="Descripción: --/--/---- [medio] - Comentario" style=""><?=trim($Rs['comentario'])?></textarea>
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Usuario</legend>
                                            <div class="row">
                                                <div class="col s12 m6 input-field">                                                    
                                                    <input name="cUsuario" type="text" id="cUsuario" class="FormPropertReg form-control" value="<?=trim($Rs['cUsuario'])?>">
                                                    <label for="cUsuario">Usuario</label>
                                                </div>                                               
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col s12 m2 offset-m4 input-field">
                                                    <button class="botenviar"  type="submit" id="Actualizar Trabajador"  onMouseOver="this.style.cursor='hand'">Actualizar</button>
                                                </div>
                                                <div class="col s12 m2 input-field">
                                                    <button class="botenviar" type="button" onclick="window.open('iu_trabajadores.php', '_self');" onMouseOver="this.style.cursor='hand'">Cancelar</button>
                                                </div>
                                            </div>
                                    </fieldset>
                                </div>
                            </div>                                                                                                        
                        </div>
                    </div>
                </form>
                <form>
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Perfiles</legend>
                                        <a title="Agregar" class='btn btn-primary' href='iu_nuevo_nivel.php?op=1&id=<?php echo $_GET['cod'];?>' style="margin-bottom: 1rem; margin-left: 1rem;"><i class="fas fa-plus"></i><span>Agregar</span></a>
                                        <div class="row">
                                        <?php
                                        $sqlTrabajadorPerfiles = "SELECT * FROM Tra_M_Perfil_Ususario where iCodTrabajador='".$_GET['cod']."'";
                                        $rsTrabajadorPerfil  = sqlsrv_query($cnx,$sqlTrabajadorPerfiles);
                                        ?>
                                            <div class="col s12">
                                                <table class="table-sm table-responsive table-hover">
                                                    <thead class="text-center" style="border-bottom: solid 1px rgba(0,0,0,0.47)">
                                                        <tr>
                                                            <th>Perfil</th>
                                                            <th>Oficina</th>
                                                            <th>Cargo</th>
                                                            <th>Delegación</th>
                                                            <th>Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $numrows = sqlsrv_has_rows($rsTrabajadorPerfil);
                                                    if ($numrows==0){
                                                        echo "NO SE ENCONTRARON REGISTROS<br>";
                                                        echo "TOTAL DE REGISTROS : ".$numrows;
                                                    }else {
                                                        while ($RsTrabajadorPerfil = sqlsrv_fetch_array($rsTrabajadorPerfil)) {
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $sqlPerfil = "SELECT cDescPerfil FROM Tra_M_Perfil WHERE iCodPerfil = '".$RsTrabajadorPerfil['iCodPerfil']."'";
                                                                $rsPerfil = sqlsrv_query($cnx,$sqlPerfil);
                                                                $RsPerfil = sqlsrv_fetch_object($rsPerfil);
                                                                echo $RsPerfil->cDescPerfil;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $sqlOficina = "SELECT cNomOficina, cSiglaOficina FROM Tra_M_oficinas WHERE iCodOficina = '".$RsTrabajadorPerfil['iCodOficina']."'";
                                                                $rsOficina = sqlsrv_query($cnx, $sqlOficina);
                                                                if(sqlsrv_has_rows($rsOficina)) {
                                                                    $RsOficina2 = sqlsrv_fetch_object($rsOficina);
                                                                    echo $RsOficina2->cSiglaOficina . " | " . $RsOficina2->cNomOficina;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $sqlCargo = "SELECT descripcion FROM Tra_M_Cargo WHERE iCodCargo = '".$RsTrabajadorPerfil['iCodCargo']."'";
                                                                $rsCargo = sqlsrv_query($cnx,$sqlCargo);
                                                                $RsCargo = sqlsrv_fetch_object($rsCargo);
                                                                echo $RsCargo->descripcion;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($RsTrabajadorPerfil['flgDelegacion'] == 0){
                                                                    echo 'No';
                                                                };
                                                                if ($RsTrabajadorPerfil['flgDelegacion'] == 1){
                                                                    echo 'Si';
                                                                };
                                                                ?>
                                                            </td>
                                                                <td class="text-center">
                                                                <a title="Eliminar" href="data_nuevo_nivel.php?op=2&id_perfil=<?php echo $RsTrabajadorPerfil['iCodPerfilUsuario']; ?>&idd=<?php echo $_GET['cod'] ?>">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>                
                                        </div>
                                    </fieldset>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </form>                      
        </div>
    </main>
    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    <script>
        $("select").on("change",function () {
            $(this).formSelect();
        });
    </script>
    <script>
        function validar(f) {
            var error = "Por favor, antes de crear complete:\n\n";
            var a = "";

            if (f.cNombresTrabajador.value == "") {
                a += " Ingrese Nombre de Trabajador";
                alert(error + a);
            }
            else if (f.cApellidosTrabajador.value == "") {
                a += " Ingrese Apellidos de Trabajador";
                alert(error + a);
            }

            else if (f.cUsuario.value == "") {
                a += " Ingrese el Usuario";
                alert(error + a);
            }
            else if (f.cPassword.value == "") {
                a += " Ingrese el Password";
                alert(error + a);
            }
            else if (f.txtestado.value == "") {
                a += " Seleccione Estado del Trabajador";
                alert(error + a);
            }

            return (a == "");

            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.form1.cMailTrabajador.value)){
            } else {
                alert("Email incorrecto");
                document.form1.cMailTrabajador.focus();
                return false;
            }


        }

        function validarEmail(valor) {
            onclick="validarEmail(this.form1.cMailTrabajador.value);"
            if (/^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/.test(valor)){
                alert("La dirección de email " + valor + " es correcta.")
                return (true)
            } else {
                alert("La dirección de email " + valor + " es incorrecta.");
                return (false);
            }
        }
    </script>
    </body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>