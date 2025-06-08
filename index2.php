<?php
    session_start();
    date_default_timezone_set('America/Lima');

    if( $_SESSION['CODIGO_TRABAJADOR']!=="" ){
        include_once("conexion/conexion.php");

        $sqlNom=" select (RTRIM(cNombresTrabajador)+' '+RTRIM(cApellidosTrabajador)) AS cNombres from Tra_M_Trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
        $rsNom=sqlsrv_query($cnx,$sqlNom);
        $RsNom=sqlsrv_fetch_array($rsNom);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>

        <title>Sistema de Trámite Digital - D-tramite</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="dist/styles/app.min.css?ver=1">
        <link href="views/css/main.css" rel="stylesheet">
    </head>

    <body class="theme-default has-fixed-sidenav">
        <header class="mainHeader">
            <div class="navbar-fixed">
                <nav class="navbar">
                    <div class="nav-wrapper">
                        <a class="brand-logo" href="#">Seleccionando perfil</a>
                        <ul class="right" id="nav-mobile">
                            <li>
                                <a class="profile-trigger" href="#!" data-target="dropdownProfile">
                                    <div class="profile">
                                        <p class="name"><?php echo utf8_encode($RsNom['cNombres']); ?></p>
                                    </div>
                                    <picture>
                                        <!--<img src="dist/images/foto.jpg" alt="<?php/* echo utf8_encode($RsNom['cNombres']); */?>" srcset="" width="36" height="36">-->
                                        <span class="fa-stack">
                                            <i class="fas fa-square fa-stack-2x"></i>
                                            <i class="fas fa-user fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </picture>
                                </a>
                                <ul class="dropdown-content" id="dropdownProfile" style="top:100% !important">
                                    <li><a href="perfil.php">Configuración</a></li>
                                    <li><a href="acceso.php">Contraseña</a></li>
                                    <li class="divider"></li>
                                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span style="padding-left:0.5rem">Salir</span></a></li>
                                </ul>
                            </li>
                        </ul>
                        <a class="sidenav-trigger left" href="#!" data-target="slide-out"><i class="fas fa-bars"></i></a>
                    </div>
                </nav>
            </div>
            <ul class="sidenav sidenav-fixed" id="slide-out"  >
                <li>
                    <a class="logo-container" href="./main.php">
                        <figure>
                            <svg height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170.2 108.82">
                                <path fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="8px" d="M38.17,40S43,16.42,71,5.94c0,0,22.86-7.12,40.7,5.93,0,0,14,8.51,19.64,28.09,0,0,26.93-1.58,34,24.93,0,0,4.05,14.24-5.26,23.94,0,0-8.1,12.06-20.45,11.47S75.83,74.82,75.83,74.82s-9.72,26.27-36.64,27.46-32.4-18.2-32.4-18.2S-3.74,62.52,16.1,46.89C16.1,46.89,21,41.35,38.17,40Z"/>
                                <path fill="#e09c35" d="M22.35,90.84c3,.61,17.46,3.18,28.72-5.53,6.85-5.31,10.23-13,11.76-16.49a50.38,50.38,0,0,0,3.55-12c23.45,12,46.45,25,71.45,37-11-3.63-56-24.56-66.34-28.93,0,0-7.55,25-28.4,30.1C43.09,95,29.79,97.54,22.35,90.84Z"/>
                                <path fill="#e09c35" d="M49.83,108.82h89c-9.11-2.95-18.56-6.44-28.44-10.1-10.54-3.9-21-8.53-30.54-12.9a43.34,43.34,0,0,1-10,12A61.74,61.74,0,0,1,49.83,108.82Z"/>
                            </svg>
                            <figcaption>
                                <h1>D-Trámite</h1>
                            </figcaption>
                        </figure>
                    </a>
                </li>
                <li class="bold active">
                    <a class="waves-effect waves-primary" href="./main.php" title="Inicio">
                        <i class="fa-fw fas fa-home"></i><span>Inicio</span>
                    </a>
                </li>
            </ul>
        </header>

        <main>
        </main>

        <footer class="page-footer mainFooter">
            <div class="container">
                <div class="row">
                    <div class="col s6 m3">
                        <img class="apci-logo" src="dist/images/apci__logo--large--blue.svg" alt="APCI" style="width:200px">
                    </div>
                </div>
            </div>
        </footer>

        <script src="dist/scripts/vendor.min.js?ver=4.0.5"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('.modal');
                var options = {
                    dismissible: false
                }
                var instances = M.Modal.init(elems, options);

                instances[0].open();
            });

        </script>
        <?php include_once 'views/includes/includePerfil.php';?>

    </body>

    </html>
<?php
    } else {
        header("Location: index-b.php?alter=5");
    }
?>