
<!-- JQuery -->
<!--<script type="text/javascript" src="js_select/jquery-3.3.1.min.js"></script>-->
<!-- Bootstrap tooltips -->
<!--<script type="text/javascript" src="js_select/popper.min.js"></script>-->
<!-- Bootstrap core JavaScript -->
<!--<script type="text/javascript" src="js_select/bootstrap.min.js"></script>-->
<!-- MDB core JavaScript -->
<!-- <script type="text/javascript" src="js_select/mdb.min.js"></script>-->
<?php
$hora= date('H')-1;

if($hora<12){
    $saludo = "Buenos dias, ";
}elseif ($hora<17){
    $saludo = "Buenas tardes, ";
}else{
    $saludo = "Buenas noches, ";
}
?>
<div id="modalCambioContrasena" class="modal">
    <div class="modal-header">
        <h4 style="text-transform: capitalize">Cambio de contraseña</h4>
    </div>
    <div class="modal-content">
        <form name="datos">
            <div class="row">
                <div class="col s12 m12">
                            <div class="row">
                                <div class="col m4 input-field offset-m2">
                                    <?php
                                    require_once("../conexion/conexion.php");
                                    $sql= "select cUsuario from Tra_M_Trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
                                    $rs=sqlsrv_query($cnx,$sql);
                                    $Rs=sqlsrv_fetch_array($rs);
                                    sqlsrv_free_stmt($rs);
                                    ?>
                                    <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo trim($Rs['cUsuario']);?>" disabled>
                                    <input name="cUsuario" type="hidden" value="<?php echo trim($Rs['cUsuario']); ?>">
                                    <label for="usuario">Usuario</label>
                                </div>
                                <div class="col m4 input-field">
                                    <input type="password" id="nuevo" name="nuevo" class="form-control" placeholder="Nueva contraseña"  >
                                    <label for="nuevo">Nueva Contraseña</label>
                                    <button id="nuevoboton" type="button" class="input-field__icon btn btn-link" onclick="mostrar()"><i class="fas fa-eye"></i></button>
                                </div>
                                </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a class="waves-effect btn btn-secondary" id="cambiarContrasenaBtn">Cambiar</a>
        <a class="modal-close waves-effect btn btn-secondary">Cancelar</a>
    </div>
</div>

<div id="modal1" class="modal">
    <div class="modal-header">
        <h4 style="text-transform: capitalize"><?php echo $saludo. " ". $RsNom['cNombres']; ?></h4>
        <p>Por favor, selecciona el rol que deseas usar ahora...</p>
    </div>
    <div class="modal-content">
        <form class="row"  method='POST' action='../views/login_next.php' name='Datos'>
            <input type='hidden' value=' <?php echo $_SESSION['CODIGO_TRABAJADOR'] ?>' name='id_usuario' id="id_usuario">
            <div class="input-field col s12 m12 l6">
                <select id="ddlOficina" name="ddlOficina">
                    <?php
                    //include("../../conexion/conexion.php");
                    $sqlOfi="select distinct (select cNomOficina from Tra_M_Oficinas where iCodOficina=o.iCodOficina) as cDescOficina,o.iCodOficina  from Tra_M_Perfil_Ususario as o where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
                    $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                    //echo $sqlOfi;
                    while ($RsTem=sqlsrv_fetch_array($rsOfi)) {
                        echo '<option value="'.$RsTem['iCodOficina'].'">'.rtrim($RsTem['cDescOficina']).'</option>';
                    }
                    ?>
                </select>
                <label>Área</label>
            </div>
            <div class="input-field col s12 m12 l6">
                <select id="ddlPerfil" name="ddlPerfil">
                </select>
                <label>Rol</label>
            </div>
            <p class="col s12">
                <label>
                    <input type="checkbox" />
                    <span>Recordar mi selección la próxima vez</span>
                </label>
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect btn btn-secondary" onClick="loguear2()">Seleccionar Rol</a>
    </div>
</div>
<script src="../dist/scripts/vendor.min.js?ver=4.0.4"></script>
<script>

    $(document).ready(function(){

        $('#modal1').modal();

        $('.modal').modal();

        $('select').formSelect();
        function  llenarArea(){
            var $oficina = $('#ddlOficina option:selected').val();
            var $idTrabajador = $('#id_usuario').val();
            $.ajax({
                cache: false,
                url: "../cargaPerfil.php",
                method: "POST",
                data: {oficina :$oficina,idTrabajador:$idTrabajador},
                datatype:"text",
                success: function (response) {
                    // getSpinner();
                    $('#ddlPerfil').html(response);
                    $('#ddlPerfil').formSelect();
                    // deleteSpinner();
                }
            });
        }

        if($('#ddlOficina option:selected').val()){

            llenarArea();
        }
        $('#ddlOficina').change(function () {
            //getSpinner();
            llenarArea();
            //deleteSpinner();
        });

    });


    function loguear2() {
        document.Datos.submit();
    }

    function mostrar() {
        document.getElementById("nuevo").setAttribute('type','text');
        document.getElementById('nuevoboton').setAttribute('onclick','nomostrar()');
        document.getElementById('nuevoboton').innerHTML = '<i class="fas fa-eye-slash"></i>';
    }
    function nomostrar() {
        document.getElementById('nuevo').setAttribute('type','password');
        document.getElementById('nuevoboton').setAttribute('onclick','mostrar()');
        document.getElementById('nuevoboton').innerHTML = '<i class="fas fa-eye"></i>';
    }

    $('#cambiarContrasenaBtn').on('click',function (e) {
        e.preventDefault();
        let elems = document.querySelector('#modalCambioContrasena');
        let instance = M.Modal.getInstance(elems);
        let usuario = $('form[name="datos"] input[name="cUsuario"]').val();
        let contran = $('form[name="datos"] input[name="nuevo"]').val();
        if(contran === ''){
            $.alert({
                title: '¡Falta nueva contraseña!',
                content: '',
                columnClass: 'col s8 offset-s2  m6 offset-m3  l4 offset-l4'
            });
            return false;
        } else {
            $.ajax({
                cache: false,
                url: '../models/ad_trabajadores_data.php',
                method: 'POST',
                data: {
                    opcion: 3,
                    cUsuario: usuario,
                    nuevo: contran
                },
                success: function () {
                    instance.close();
                    M.toast({html: '¡Contraseña cambiada!'});
                }
            });
        }
    })

</script>
<script src="../assets/scripts/ckeditor/ckeditor.js"></script>
