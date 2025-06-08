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
<div id="modal1" class="modal">
    <div class="modal-header">
        <h4 style="text-transform: capitalize"><?php echo $saludo. " ". $RsNom['cNombres']; ?></h4>
        <p>Por favor, seleccione el rol que desee usar ahora...</p>
    </div>
    <div class="modal-content">
        <form class="row mb-0"  method='POST' action='views/login_next.php' name='Datos'>
            <div class="input-field col s12 m12 l6">
                <input type="hidden" id="id_usuario" value="<?=$_SESSION['CODIGO_TRABAJADOR']?>">
                <select id="ddlOficina" name="ddlOficina">
                    <?php
                    include_once("conexion/conexion.php");

                    $sqlOfi="select distinct (select cNomOficina from Tra_M_Oficinas where iCodOficina=o.iCodOficina) as cDescOficina,o.iCodOficina  from Tra_M_Perfil_Ususario as o  where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
                    $getResults= sqlsrv_query($cnx, $sqlOfi);
                    while ( $row = sqlsrv_fetch_array( $getResults, SQLSRV_FETCH_ASSOC ))
                    {
                        echo '<option value="'.$row['iCodOficina'].'">'.rtrim($row['cDescOficina']).'</option>';
                    }

                    sqlsrv_free_stmt($getResults);
                    sqlsrv_close( $cnx);

                    ?>
                </select>

                <label>Área</label>
            </div>
            <div class="input-field col s12 m12 l6">
                <select id="ddlPerfil" name="ddlPerfil">
                </select>
                <label>Rol</label>
            </div>
            <!-- <p class="col s12 m12 l12">
                <label>
                    <input type="checkbox" />
                    <span>Recordar mi selección la próxima vez</span>
                </label>
            </p> -->
        </form>
    </div>
    <div class="modal-footer">
        <a href="./views/logout.php" class="modal-close waves-effect btn btn-link">Salir</a>
        <a href="#!" class="waves-effect btn btn-secondary" onClick="loguear2()">Seleccionar Rol</a>
    </div>
</div>
<script>
    $(document).ready(function(){
        if (isIOs()) {
            $('select').addClass('browser-default');
        } else {
            $('select').formSelect();
        }
        function  llenarArea(){
            var $oficina = $('#ddlOficina option:selected').val();
            var $idTrabajador = $('#id_usuario').val();
            $.ajax({
                cache: false,
                url: "cargaPerfil.php",
                method: "POST",
                data: {oficina :$oficina,idTrabajador:$idTrabajador},
                datatype:"text",
                success: function (response) {
                    $('#ddlPerfil').html(response);
                    $('#ddlPerfil').formSelect();
                }
            });
        }

        if($('#ddlOficina option:selected').val()){
            llenarArea();
        }
        $('#ddlOficina').change(function () {
            llenarArea();
        });

    });

    function loguear2() {
        document.Datos.submit();
    }
</script>