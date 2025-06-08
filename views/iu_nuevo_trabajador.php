<?php
session_start();
$pageTitle = "Nuevo trabajador";
$activeItem = "iu_trabajadores.php";
$navExtended = true;


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
                require_once("../models/ad_busqueda.php");
            ?>
                <form action="../controllers/ln_nuevo_trabajador.php" onSubmit="return validar(this)" method="post" name="form1">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Datos Personales</legend>
                                        <div class="row">
                                            <div class="col s12 m6 input-field">
                                                <input name="cNombresTrabajador" type="text" id="cNombresTrabajador" value="" class="FormPropertReg form-control">
                                                <label for="cNombresTrabajador">Nombres</label>
                                            </div>
                                            <div class="col s12 m6 input-field">                                                            
                                                <input name="cApellidosTrabajador" type="text" id="cApellidosTrabajador" class="FormPropertReg form-control" value="">
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
                                                        echo "<option value=".$RsDoc['cTipoDocIdentidad'].">".$RsDoc['cDescDocIdentidad']."</option>";
                                                    }
                                                    sqlsrv_free_stmt($rsDoc);
                                                    ?>
                                                </select>
                                                <label for="cTipoDocIdentidad">Documento:&nbsp;</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="cNumDocIdentidad" type="text" id="cNumDocIdentidad" class="FormPropertReg form-control" onkeypress="if (event.keyCode > 31 && ( event.keyCode < 48 || event.keyCode > 57)) event.returnValue = false;">
                                                <label for="cNumDocIdentidad">N° Doc.</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <input name="cDireccionTrabajador" type="text" id="cDireccionTrabajador" class="FormPropertReg form-control">
                                                <label for="cDireccionTrabajador">Direccion</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <input name="cMailTrabajador" type="text" id="cMailTrabajador" class="FormPropertReg form-control">
                                                <label for="cMailTrabajador">E-mail</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="cTlfTrabajador1" type="text" id="cTlfTrabajador1" class="FormPropertReg form-control">
                                                <label for="cTlfTrabajador1">Telefono 1</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="cTlfTrabajador2" type="text" id="cTlfTrabajador2" class="FormPropertReg form-control">
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
                                                                echo "<option value=".$RsOfi["iCodOficina"].">".$RsOfi["cNomOficina"]."</option>";
                                                            }
                                                            sqlsrv_free_stmt($rsOfi);
                                                            ?>
                                                        </select>
                                                        <label class="select">Oficina:&nbsp;</label>
                                            </div>                                                  
                                            <div class="col s12 m6 input-field">                                                            
                                                <select name="txtestado" class="FormPropertReg" id="txtestado">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>                                                        
                                                </select>
                                                <label for="txtestado">Estado:&nbsp;</label>
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
                                                    <input name="cUsuario" type="text" id="cUsuario" class="FormPropertReg form-control">
                                                        <?php
                                                        if(($_GET['cUsuario']??'')!="") {echo "*";}
                                                        if (($mensaje??'')=="1") {echo "<script> alert('El Nombre de Usuario ya Existe')</script>";}
                                                        ?>
                                                    <label for="cUsuario">Usuario</label>
                                                </div>
                                                <div class="col s12 m6 input-field">
                                                    <input name="cPassword" type="text" id="cPassword" class="FormPropertReg form-control">
                                                    <label for="cPassword">Password</label>
                                                </div>                                                
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col s12 m2 offset-m4 input-field">
                                                    <button class="botenviar"  type="submit" id="Insert Trabajador"  onMouseOver="this.style.cursor='hand'">Crear</button>
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
