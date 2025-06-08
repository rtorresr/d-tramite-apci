<?php
session_start();

$pageTitle = "Configuración de perfil";
$activeItem = "perfil.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
<!--        <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>-->
<!--        <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />-->
<!--        <link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>-->
<!--        <script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>-->
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <?php
    require_once("../conexion/conexion.php");
    $sql= "select * from Tra_M_Trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    ?>

    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><button class="btn btn-primary" type="button" id="actualiza" onclick="editar()"><i class="fas fa-save fa-fw left"></i><span>Actualizar</span></button></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <form class="card-body px-3 px-xl-5" method="post" action="../models/ad_trabajadores_data.php" aria-label="DatosUsuario" name="datos">
                <div class="row">
                    <div class="col s12">
                        <div class="card hoverable">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Datos del usuario</legend>
                                    <div class="row">
                                        <div class="col m3 input-field">
                                            <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $Rs['cUsuario'];?>" disabled>
                                            <label for="usuario">Usuario</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="correo" name='correo' class="form-control" value="<?php echo $Rs['cMailTrabajador'];?>" disabled>
                                            <label for="correo">Correo</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="ultimoacceso" name='ultimoacceso' class="form-control" value="<?php echo $Rs['fUltimoAcceso']->format('d/m/Y H:i:s');?>" disabled>
                                            <label for="ultimoacceso">Última conexión:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m3 input-field">
                                            <input type="text" id="nombres" name='nombres' class="form-control editable" value="<?php echo trim($Rs['cNombresTrabajador']);?>" disabled>
                                            <label for="nombres">Nombres</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="apellidos" name='apellidos' class="form-control editable" value="<?php echo trim($Rs['cApellidosTrabajador']);?>" disabled>
                                            <label for="apellidos">Apellidos</label>
                                        </div>
                                        <?php
                                            $TipDocIden = $Rs['cTipoDocIdentidad'];
                                            $sqlTipodoc = "select * from Tra_M_Doc_Identidad where cTipoDocIdentidad =$TipDocIden";
                                            $rsIden=sqlsrv_query($cnx,$sqlTipodoc);
                                            $RsIden=sqlsrv_fetch_array($rsIden);
                                        ?>
                                        <div class="col m3 input-field">
                                            <input type="text" id="documento" name='documento' class="form-control editable" value="<?php echo trim($Rs['cNumDocIdentidad']);?>" disabled>
                                            <label for="documento"><?php echo $RsIden['cDescDocIdentidad'];?></label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="direccion" name='direccion' class="form-control editable" value="<?php echo trim($Rs['cDireccionTrabajador']);?>" disabled>
                                            <label for="direccion">Dirección</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="telefono1" name='telefono1' class="form-control editable" value="<?php echo trim($Rs['cTlfTrabajador1']);?>" disabled>
                                            <label for="telefono1">Teléfono 1</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="telefono2" name='telefono2' class="form-control editable" value="<?php echo trim($Rs['cTlfTrabajador2']);?>" disabled>
                                            <label for="telefono2">Teléfono 2</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Perfiles asignados</legend>
                                    <table id="tblRoles" class="striped highlight">
                                        <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>PERFIL</th>
                                            <th>OFICINA</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sqlConsultaPerfiles ="select (select cDescPerfil from Tra_M_Perfil where iCodPerfil=p.iCodPerfil) as nPerfil,
                                                    (select cNomOficina from Tra_M_Oficinas where iCodOficina=p.iCodOficina) as nOficina 
                                                    from Tra_M_Perfil_Ususario p where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
                                        $rsConsultaPerfiles=sqlsrv_query($cnx,$sqlConsultaPerfiles);
                                        $i=1;
                                        while($RsConsultaPerfiles=sqlsrv_fetch_array($rsConsultaPerfiles)){
                                            echo "<tr>
                                                                <td>".$i."</td>  
                                                                <td>".$RsConsultaPerfiles['nPerfil']."</td>
                                                                <td>".$RsConsultaPerfiles['nOficina']."</td>
                                                              </tr>";
                                            $i++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

            <input type="hidden" name="opcion" value="2">
            </form>
        </div>
    </main>

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>

    <!--Actualizar datos de perfil -->
    <script>
        $(function(){
            $("#tblRoles").dataTable({
                dom: 'tr',
                "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            });
        })
        function editar(){
            var elementos= document.getElementsByClassName("editable");
            var i=0;
            while (i < elementos.length){
                elementos[i].removeAttribute("disabled");
                //elementos[i].style.background = "#0b30bb2e";
                elementos[i].classList.add("editing");
                //elementos[i].style.borderRadius = "10px";
                i++;
            }
            var boton = document.getElementById("actualiza");
            boton.innerText = "Guardar";
            boton.setAttribute("onclick","loguear()");
        }

        function loguear(){
            document.datos.submit();
        }

    </script>

    <!--Drag and Drop-->
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
        }
    </script>

    </body>
    </html>

    <?php } else{
    header("Location: ../index-b.php?alter=5");}
?>