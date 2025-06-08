<?php
session_start();
$pageTitle = "Mantenimiento de Trabajadores";
$activeItem = "iu_trabajadores.php";
$navExtended = true;

if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
    include_once("../conexion/conexion.php");

    $rsFont = sqlsrv_query($cnx,"SELECT iCodSubMenu FROM Tra_M_Menu_Items WHERE cScriptSubMenu LIKE '%iu_trabajadores.php%'");
    $RsFont = sqlsrv_fetch_array($rsFont);
    $sqlSub = "SELECT iCodMenuLista FROM Tra_M_Menu_Lista WHERE iCodSubMenu = ".$RsFont['iCodSubMenu']." AND iCodMenu IN (SELECT iCodMenu FROM Tra_M_Menu WHERE iCodPerfil ='".($_SESSION['iCodPerfilLogin']??'')."')";
    $rsSub  = sqlsrv_query($cnx,$sqlSub);
    $numProfile = sqlsrv_has_rows($rsSub);
}
if ($numProfile > 0){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php"); ?>

</head>
<body class="theme-default has-fixed-sidenav">

<?php include("includes/menu.php"); ?>

<!--Main layout-->
<main>
    <div class="navbar-fixed actionButtons searchForm">
        <nav style="">
            
                <div class="nav-wrapper">
                    <div class="row" style="">
                        <div class="col s6 input-field">
                            <ul id="nav-mobile" class="">
                               <li><a class="botpelota ml-auto mb-4 btn btn-primary" title="Agregar" href="iu_nuevo_trabajador.php" style=""><i class="fas fa-fw fa-plus"></i> <span>Agregar</span></a></a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
        </nav>
    </div>
    <div class="container">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-12">
                <!--Card-->
                <div class="card mb-5">
                    <!-- Card header -->
                    <div class="card-header text-center "> Lista de Usuarios </div>
                    <!--Card content-->
                    <!-- <a class="botpelota ml-auto mb-4" title="Agregar" href="iu_nuevo_trabajador.php" style="margin-bottom: 1rem"><i class="fas fa-plus"></i></a> -->
                    <div class="card-body d-flex px-4 px-lg-5">
                        <table id="tablaTrabajadores" class="display striped highlight bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Oficina</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Documento</th>
                                <th>N° Documento</th>
                                <th>Correo</th>
                                <th>Usuario</th>
                                <th>Estado</th>
                                <th data-priority="1">Opciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>


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
         $('.mdb-select').formSelect();
   });
</script>

<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>

<script>
    //Sidebar
    function enviarUsuario(idu){
        getSpinner('Enviando Correo');
        $.get('enviarUsuario.php', {'codU':idu}, function () {
            deleteSpinner();
            M.toast({html: 'Enviado Correctamente'});
        })
    }    
    
    $(document).ready(function () {
        

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });


        let tablaTrabajadores = $('#tablaTrabajadores').DataTable({
            processing: true,
            serverSide: true,
            pagingType: 'full_numbers',
            responsive: true,
            ajax: 'ajaxtablas/ajaxtrabajadores.php',
            language: {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                    'selectRow': true
                    }
                }
                ],
            'select': {
            'style': 'multi'
            }, 
            'order': [[1, 'asc']],
            drawCallback: function( settings ) {
                //$(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tablaTrabajadores_length"]').formSelect();
            },
            dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
            buttons: [
                //{ extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar' },
                //{ extend: 'csv', text: '<i class="fas fa-file-excel"></i> CSV' },
                { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel' },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
            ],
        });


        //var count = tablaTrabajadores.rows( { selected: true } ).count();
 
        tablaTrabajadores
        .on( 'select', function ( e, dt, type, indexes ) {
            //count++;
             var count = tablaTrabajadores.rows( { selected: true } ).count();

             console.log(e + dt + type + indexes);
             
            if(count > 1) {
                console.log("Hay más de un elemento seleccionado");
            }else{
                console.log("Hay menos de dos elementos seleccionado");
            }
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            //count--;
             var count = tablaTrabajadores.rows( { selected: true } ).count();
            if(count > 1) {
                console.log("Hay más de un elemento seleccionado");
            }else{
                console.log("Hay menos de dos elementos seleccionado");
            }
        } );
    });
</script>
</body>
</html>
<?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>