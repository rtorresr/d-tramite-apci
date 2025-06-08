<?php
session_start();
$pageTitle = "Agregar Perfil";
$activeItem = "iu_nuevo_nivel.php";
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
                $sql= "select * from Tra_M_Trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
                $rs=sqlsrv_query($cnx,$sql);
                $Rs=sqlsrv_fetch_array($rs);
            ?>
                <form action="data_nuevo_nivel.php" method="post" name="form1" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                    <input type="hidden" name="op" value="<?php echo $_GET['op'];?>">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Datos Perfil</legend>
                                        <div class="row">                                            
                                            <div class="col s12 m6 input-field"> 
                                                <select name="oficina" id="oficina" class="FormPropertReg">
                                                    <option value="">Seleccione:</option>
                                                    <?php
                                                        $sqlPer = "SELECT * FROM Tra_M_Oficinas WHERE iFlgEstado != 0 AND flgEliminado = 0 ORDER BY cNomOficina ASC";
                                                        $rsPer  = sqlsrv_query($cnx,$sqlPer);
                                                        while ($RsPer = sqlsrv_fetch_array($rsPer)){
                                                            echo "<option value=".$RsPer["iCodOficina"].">".$RsPer["cNomOficina"]." | ".$RsPer["cSiglaOficina"]."</option>";
                                                        }
                                                        sqlsrv_free_stmt($rsPer);
                                                    ?>
                                                </select>    
                                                <label for="oficina" >Oficina:&nbsp;</label>
                                            </div>                                                  
                                            <div class="col s12 m6 input-field"> 
                                                <select name="perfil" id="perfil" class="FormPropertReg">
                                                    <option value="">Seleccione:</option>
                                                    <?php
                                                        $sqlPer="select * from Tra_M_Perfil order by cDescPerfil asc ";
                                                        $rsPer=sqlsrv_query($cnx,$sqlPer);
                                                        while ($RsPer=sqlsrv_fetch_array($rsPer)){
                                                            echo "<option value=".$RsPer["iCodPerfil"].">".$RsPer["cDescPerfil"]."</option>";
                                                        }
                                                        sqlsrv_free_stmt($rsPer);
                                                    ?>
                                                </select>   
                                                <label for="perfil" >Perfil:&nbsp;</label>
                                            </div>
                                            <div class="col s12 m6 input-field"> 
                                                <select name="cargo" id="cargo" class="FormPropertReg">
                                                    <option value="">Seleccione:</option>
                                                    <?php
                                                    $sqlPer="select * from Tra_M_Cargo order by descripcion asc ";
                                                    $rsPer=sqlsrv_query($cnx,$sqlPer);
                                                    while ($RsPer=sqlsrv_fetch_array($rsPer)){
                                                        echo "<option value=".$RsPer["iCodCargo"].">".$RsPer["descripcion"]."</option>";
                                                    }
                                                    sqlsrv_free_stmt($rsPer);
                                                    ?>
                                                </select>  
                                                <label for="cargo" >Cargo:&nbsp;</label>
                                            </div>
                                            <div class="col s12 m6 input-field"> 
                                                <p>
                                                    <label>
                                                        <input type="checkbox" name="delegado" value="1">
                                                        <span>Delegado</span>
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>                                                                                                       
                        </div>
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Restricciones</legend>
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col s12">
                                                <select id="restricciones" class="js-example-basic-multiple-limit browser-default" name="restricciones[]" multiple="multiple"></select>                                           
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>                                                                                                       
                        </div>
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Sellos</legend>
                                        <div class="row">                                            
                                            <div class="col s12 m6 input-field">
                                                <span for="firma" >Firma:&nbsp;</span>
                                                <input name="firma" id="firma" type="file">                                           
                                            </div>                                                  
                                            <div class="col s12 m6 input-field">
                                                <span for="vistobueno" >Visto Bueno:&nbsp;</span>
                                                <input name="VistoBueno" id="vistobueno" type="file">                                                
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col s12 m2 offset-m4 input-field">
                                                <button class="botenviar" type="button" id="Insert Trabajador" onclick="validar();" onMouseOver="this.style.cursor='hand'">Agregar</button>
                                            </div>
                                            <div class="col s12 m2 input-field">
                                                <button class="botenviar" type="button" onclick="window.history.back();" onMouseOver="this.style.cursor='hand'">Cancelar</button>
                                            </div>
                                        </div>
                                    <fieldset>
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

        function validar(){
            if (document.querySelector("#oficina").value.trim() == ""){
                return $.alert("Falta oficina!");
            }
            if (document.querySelector("#perfil").value.trim() == ""){
                return $.alert("Falta perfil!");
            }
            if (document.querySelector("#cargo").value.trim() == ""){
                return $.alert("Falta cargo!");
            }
            if (document.querySelector("#firma").value.trim() == ""){
                return $.alert("Falta firma!");
            }
            if (document.querySelector("#vistobueno").value.trim() == ""){
                return $.alert("Falta visto bueno!");
            }
            document.querySelector("form[name='form1']").submit();
        }

        $('#restricciones').select2({
            placeholder: 'Seleccione y busque',
            maximumSelectionLength: 10,
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al referencia.</p>";
                },
                "searching": function() {
                    return "Buscando..";
                },
                "inputTooShort": function() {
                    return "Ingrese más de 3 letras ...";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'mantenimiento/Menu.php',
                dataType: 'json',
                type: 'POST',
                data: function (params) {
                    var query = {
                        search: params.term,
                        Evento: 'BuscarMenuItem'
                    }
                    return query;
                },
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>
    </body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>