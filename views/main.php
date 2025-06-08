    <?php session_start();

global $pageTitle, $activeItem, $navExtended;

$pageTitle = "Bienvenido de nuevo";
$activeItem = "main.php";
$navExtended = false;

If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?></head>
<body id="home" class="theme-default has-fixed-sidenav">

<?php include("includes/menu.php");?>

<!--Main layout-->
<main>
    <div class="container">

        <!--Grid row-->
        <div class="row">
            <div class="col s12">
            <h6>Bandejas</h6>
            </div>
            <?php if( $_SESSION['iCodPerfilLogin'] != 1 ) : ?>
                <!--Grid column-->
                <!--<div class="col s12 m3">-->

                    <!--Card-->
                    <!--<div class="card card-main">


                        <div class="card-content">
                            <a href="./bandeja-de-entrada.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Bandeja de Entrada</h2>
                                    </div>
                                    <div class="card-icon">
                                        <?php
                                        /*if ($_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20 ){
                                            $sqlCon = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '$_SESSION[iCodOficinaLogin]' AND iCodPerfil = 3";
                                            $rsCon = sqlsrv_query($cnx,$sqlCon);
                                            $RsCon = sqlsrv_fetch_array($rsCon);

                                            $where = " WHERE iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND ( iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR']." OR iCodTrabajadorDerivar = ".$RsCon['iCodTrabajador']." )" ;
                                        } else {
                                            $where = " WHERE iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR'] ;
                                        }

                                            $sqlQuery = "SELECT COUNT([iCodMovimiento]) as iCodMovimiento  
                                                            FROM [dbo].[vw_bandeja_entrada_profesional]
                                                            ".$where;

                                            //var_dump($sqlQuery);
                                            $rsQuery = sqlsrv_query($cnx,$sqlQuery);
                                            $RsQuery = sqlsrv_fetch_array($rsQuery);
                                            
                                            echo '<span class="number">' . $RsQuery['iCodMovimiento'] . '</span>';*/
                                        ?>
                                        <i class="fas fa-mail-bulk"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>-->
                    <!--/.Card-->

                <!--</div>-->

                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="./bandeja-de-pendientes.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Bandeja de Recibidos</h2>
                                    </div>
                                    <div class="card-icon">
                                        <?php
                                        $params = [
                                            $_SESSION['CODIGO_TRABAJADOR'],
                                            $_SESSION['iCodOficinaLogin'],
                                            $_SESSION['iCodPerfilLogin']
                                        ];

                                        $sqlBdRecibidos = "{call SP_BANDEJA_RECIBIDOS (?,?,?)}";

                                        $rsBdRecibidos = sqlsrv_query($cnx,$sqlBdRecibidos,$params,array('Scrollable' =>'buffered'));

                                        if($rsBdRecibidos === false) {
                                            die(print_r(sqlsrv_errors(), true));
                                        }
                                        while( $row = sqlsrv_fetch_array( $rsBdRecibidos, SQLSRV_FETCH_ASSOC)){
                                            $nNroDocsRecibidos = $row['VO_TOTREG'];
                                        }
                                        // $nNroDocsRecibidos = sqlsrv_num_rows($rsBdRecibidos);
                                        echo '<span class="number">' . $nNroDocsRecibidos . '</span>';
                                        ?>
                                        <i class="fas fa-mail-bulk"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--<div class="col s12 m4">

                    <div class="card card-main">

                        <div class="card-content">
                            <a href="./bandeja-de-derivados.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Bandeja de Derivados</h2>
                                    </div>
                                    <div class="card-icon">
                                        <?php
                                        /*if ($_SESSION['iCodPerfilLogin'] == 3 || $_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20){
                                            $sqlCon = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '$_SESSION[iCodOficinaLogin]' AND iCodPerfil = 3";
                                            $rsCon = sqlsrv_query($cnx,$sqlCon);
                                            $RsCon = sqlsrv_fetch_array($rsCon);

                                            //$where = " AND iCodOficinaOrigen = ".$_SESSION['iCodOficinaLogin']." AND ( iCodTrabajadorRegistro = ".$_SESSION['CODIGO_TRABAJADOR']." OR iCodTrabajadorRegistro = ".$RsCon['iCodTrabajador']." )" ;
                                            $where2 = " WHERE iCodOficinaOrigen = '".$_SESSION['iCodOficinaLogin']."'";
                                        } else {
                                            $where2 = " WHERE iCodOficinaOrigen = ".$_SESSION['iCodOficinaLogin']." AND iCodTrabajadorRegistro = ".$_SESSION['CODIGO_TRABAJADOR'] ;
                                        }

                                        $sqlQuery4 = "SELECT COUNT([iCodMovimiento]) as iCodMovimiento  
                                                            FROM [dbo].[vw_bandeja_derivados]
                                                            ".$where2;

                                        $resQuery4 = sqlsrv_query($cnx,$sqlQuery4);
                                        $ResQuery4 = sqlsrv_fetch_array($resQuery4);

                                        echo '<span class="number">' . $ResQuery4['iCodMovimiento'] . '</span>';*/
                                        ?>
                                        <i class="fas fa-box"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>-->

                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="./bandeja-de-trabajo.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Bandeja de trabajo</h2>
                                    </div>
                                    <div class="card-icon">
                                        <?php
                                        $params = [
                                            $_SESSION['iCodPerfilLogin'],    
                                            $_SESSION['iCodOficinaLogin'],
                                            $_SESSION['CODIGO_TRABAJADOR']
                                        ];

                                        $sqlTrabajo = "{call SP_GRUPOS_BANDEJA_TRABAJO (?,?,?)}";
                                        $rsTrabajo = sqlsrv_query($cnx,$sqlTrabajo,$params,array('Scrollable'=>'Buffered'));

                                        echo '<span class="number">' . sqlsrv_num_rows($rsTrabajo) . '</span>';
                                        ?>
                                        <i class="fas fa-envelope-open-text"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>

                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="./bandeja-por-aprobar.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Bandeja por Aprobar</h2>
                                    </div>
                                    <div class="card-icon">
                                        <?php
                                        if ($_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20 ){
                                            $sqlCon = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '".$_SESSION['iCodOficinaLogin']."' AND iCodPerfil = 3";
                                            $rsCon = sqlsrv_query($cnx,$sqlCon);
                                            $RsCon = sqlsrv_fetch_array($rsCon);

                                            $where3 = " WHERE iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND ( iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR']." OR iCodTrabajadorDerivar = ".$RsCon['iCodTrabajador']." )" ;
                                        } else {
                                            $where3 = " WHERE iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR'] ;
                                        }

                                            $sqlQuery2 = "SELECT COUNT([iCodMovimiento]) as iCodMovimiento  
                                                            FROM [dbo].[vw_bandeja_por_aprobar]
                                                            ".$where3;

                                            //var_dump($sqlQuery2);
                                            $resQuery2 = sqlsrv_query($cnx,$sqlQuery2);
                                            $ResQuery2 = sqlsrv_fetch_array($resQuery2);
                                            
                                            echo '<span class="number">' . $ResQuery2['iCodMovimiento'] . '</span>';
                                        ?>
                                        <i class="fas fa-stamp"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->
            <?php else: ?>
                <!-- <h2>Puede administrar este panel</h2> -->
            <?php endif; ?>
        </div>


        <div class="row">
        <div class="col s12">
            <h6>Reportes</h6>
            </div>
                <div class="col s12 m4">
                    <div class="card card-main">
                        <div class="card-content">
                            <a href="./consulta-general.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Consulta General</h2>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="consulta-emitidos.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Consulta de Emitidos</h2>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>

                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="./consulta-delegados.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Consulta de Delegados</h2>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>

                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="./consulta-derivados.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Consulta de Derivados</h2>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>

                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="./consulta-pendientes.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Consulta de Pendientes</h2>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>

                <!--<div class="col s12 m3">
                    <div class="card card-main">
                        <div class="card-content">
                            <a href="./consulta-finalizados.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Consulta de Finalizados</h2>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>-->

                <div class="col s12 m4">

                    <!--Card-->
                    <div class="card card-main">

                        <!--Card content-->
                        <div class="card-content">
                            <a href="./consulta-archivados.php">
                                <div class="card-wrapper">
                                    <div class="card-data">
                                        <h2>Consulta de Archivados</h2>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->
        </div>
        <!--Grid row-->

        <!--Grid row-->

    </div>
</main>
<!--Main layout-->


<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>


<?php
// --------------------------- Pendientes ----------------------------------
// Punto de control - Jefes = 3
// Punto de control - Asistentes = 19
// Profesional = 4

// --------------------------- Derivados ----------------------------------

/*$sqlBtn2 = "SP_BANDEJA_DERIVADOS '','','','','%%','%%','".$_SESSION['iCodOficinaLogin']."','','' ,'','Derivado','DESC'";
$rsBtn2 = sqlsrv_query( $cnx,$sqlBtn2);
$total2 = sqlsrv_has_rows($rsBtn2);

// --------------------------- Finalizados ----------------------------------
// Punto de control - Jefes = 3
// Punto de control - Asistentes = 19
// Profesional = 4
if($_SESSION['iCodPerfilLogin']==3 OR $_SESSION['iCodPerfilLogin'] == 19){
    $sqlBtn3 = "SP_BANDEJA_FINALIZADOS 'op1' ,'','','','', '', '', '".$_SESSION['iCodOficinaLogin']."','','' , 'DESC' ";
    $rsBtn3 = sqlsrv_query( $cnx,$sqlBtn3);
    $total3 = sqlsrv_has_rows($rsBtn3);
}else{
    $sqlBtn3 = "SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' ) OR Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."' ) AND Tra_M_Tramite_Movimientos.nEstadoMovimiento=5 ORDER BY Tra_M_Tramite.iCodTramite DESC ";
    $rsBtn3 = sqlsrv_query( $cnx,$sqlBtn3);
    $total3 = sqlsrv_has_rows($rsBtn3);
}


// --------------------------- Enviados ----------------------------------
$sqlBtn4 = "SELECT *, c.cFlgTipoMovimiento,c.nEstadoMovimiento, c.fFecDelegadoRecepcion,c.fFecRecepcion FROM Tra_M_Tramite a, Tra_M_Tramite_Trabajadores b, Tra_M_Tramite_Movimientos c WHERE a.iCodTramite = b.iCodTramite AND (b.iCodTrabajadorOrigen='".$_SESSION['CODIGO_TRABAJADOR']."' AND b.iCodTrabajadorDestino!='".$_SESSION['CODIGO_TRABAJADOR']."' ) AND b.iCodOficina='".$_SESSION['iCodOficinaLogin']."' and b.iCodMovimiento =c.iCodMovimiento ORDER BY a.iCodTramite DESC";
$rsBtn4 = sqlsrv_query( $cnx,$sqlBtn4);
$total4 = sqlsrv_has_rows($rsBtn4);


// --------------------------- Respondidos ----------------------------------
$sqlBtn5 = "SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' ) OR Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."' ) AND Tra_M_Tramite_Movimientos.nEstadoMovimiento=4 ORDER BY Tra_M_Tramite.iCodTramite DESC   ";
$rsBtn5 = sqlsrv_query( $cnx,$sqlBtn5);
$total5 = sqlsrv_has_rows($rsBtn5);*/
?>
</body>
</html>

<?php
} else {
   header("Location: ../index-b.php?alter=5");
}
?>