<?php
session_start();
if(isset($_SESSION['CODIGO_TRABAJADOR'])){
    header( "Location: views/main.php" );
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <title>Trámite Digital - D-Trámite</title>
    <link rel="icon" type="image/png" href="dist/images/favicon.png">
    <link rel="stylesheet" href="dist/styles/app.min.css?ver=1">
</head>

<body class="theme-default login" id="login">

<main>
    <div class="content content__left">
        <header class="">
            <a class="logo-container" href="./index-b.php">
                <figure>
                    <svg height="80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170.2 108.82">
                        <path fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="8px" d="M38.17,40S43,16.42,71,5.94c0,0,22.86-7.12,40.7,5.93,0,0,14,8.51,19.64,28.09,0,0,26.93-1.58,34,24.93,0,0,4.05,14.24-5.26,23.94,0,0-8.1,12.06-20.45,11.47S75.83,74.82,75.83,74.82s-9.72,26.27-36.64,27.46-32.4-18.2-32.4-18.2S-3.74,62.52,16.1,46.89C16.1,46.89,21,41.35,38.17,40Z"/>
                        <path fill="#e09c35" d="M22.35,90.84c3,.61,17.46,3.18,28.72-5.53,6.85-5.31,10.23-13,11.76-16.49a50.38,50.38,0,0,0,3.55-12c23.45,12,46.45,25,71.45,37-11-3.63-56-24.56-66.34-28.93,0,0-7.55,25-28.4,30.1C43.09,95,29.79,97.54,22.35,90.84Z"/>
                        <path fill="#e09c35" d="M49.83,108.82h89c-9.11-2.95-18.56-6.44-28.44-10.1-10.54-3.9-21-8.53-30.54-12.9a43.34,43.34,0,0,1-10,12A61.74,61.74,0,0,1,49.83,108.82Z"/>
                    </svg>
                    <figcaption>
                        <h1 class="brand">D-Trámite</h1>
                        <p class="small">Sistema de Trámite Digital</p>
                    </figcaption>
                </figure>
            </a>
        </header>
        <footer class="apci">
            <h1><a href="http://www.apci.gob.pe"><img src="dist/images/apci__logo--white.svg" width="125"></a></h1>
        </footer>
    </div>
    <div class="content content__right">
        <?php
            if (isset($_GET["alter"]))
                switch ($_GET["alter"]) {
                    case 2:
                        $observacion = "<p>Ha salido correctamente</p>";
                        $cardStatus="success";
                        $notificacion="
                                    <div class='rectangle'>
                                        <div class='notification-text'>
                                            $observacion
                                        </div>
                                    </div>
                                ";
                        break;
                    case 3:
                        $observacion = "<p>Datos de acceso vacios</p>";
                        $cardStatus="error";
                        $notificacion="
                                    <div class='rectangle'>
                                        <div class='notification-text'>
                                            $observacion
                                        </div>
                                    </div>
                                ";
                        break;
                    case 4:
                        $observacion = "<p>Usuario o contraseña incorrectas</p>";
                        $cardStatus="error";
                        $notificacion="
                                    <div class='rectangle'>
                                        <div class='notification-text'>
                                            $observacion
                                        </div>
                                    </div>
                                ";
                        break;
                    case 5:
                        $observacion = "<p>Usuario no autorizado</p>";
                        $cardStatus="error";
                        $notificacion="
                                    <div class='rectangle'>
                                        <div class='notification-text'>
                                            $observacion
                                        </div>
                                    </div>
                                ";
                        break;
                };
            if (isset($notificacion)){
                ?>
                <!--Card Danger-->
                <div class="card z-depth-0 card-<?php echo $cardStatus; ?>">
                    <div class="card-content">
                        <?php echo $observacion;?>
                    </div>
                </div>
        <?php } ?>

        <form method="POST" action="views/login.php" aria-label="Login" name="Datos">
            <div class="center">
                <h3>Bienvenido de nuevo</h3>
                <p>Ingrese a su cuenta</p>
            </div>
            <div class="row">
                <div class="col s12 input-field">
                    <input name="usuario" id="usuario" type="text" autocomplete="off" required>
                    <label for="usuario" data-error="Incorrecto" data-success="Correcto">Usuario</label>
                </div>
                <div class="col s12 input-field">
                    <input type="password" id="contrasena" name="contrasena" autocomplete="off" required>
                    <label for="contrasena" data-error="Incorrecto" data-success="Correcto" >Contraseña</label>
                    <button class="input-field__icon btn btn-link" id="toggleEye" type="button"><i class="fas fa-eye"></i></button>
                </div>
                <div class="col s12 form-ref-box">
                    <label for="recordar">
                        <input id="recordar" type="checkbox"><span>Recordar</span>
                    </label><span class="form-ref-link"><a href="#">¿Olvidó su clave?</a></span>
                </div>
                <div class="col s12 input-field">
                    <button class="btn btn-action-form btn-block waves-effect waves-light btn-large btn-primary" type="submit" onclick="loguear()">Iniciar Sesión</button>
                    <a style="margin-top: 1rem" href="https://www.screencast.com/t/xvEkqLLkeAaL" target="_blank" class="btn btn-action-form btn-block waves-effect waves-light btn-large btn-link" type="submit">Videos de ayuda</a>
                </div>
            </div>
        </form>
    </div>
</main>

<script src="dist/scripts/vendor.min.js?ver=1"></script>
<script type="text/javascript">
    function loguear() {
        if (document.Datos.usuario.value == "") {
            M.toast({html: 'Ingrese usuario', classes: 'rounded'});

        } else if (document.Datos.contrasena.value == "") {
            M.toast({html: 'Ingrese contraseña', classes: 'rounded'});

        } else {
            //document.Datos.submit();
            //debugger;
            $("#Datos").submit();
        }
    }
</script>
</body>
</html>