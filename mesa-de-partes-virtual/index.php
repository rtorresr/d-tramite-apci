<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Bienvenido">
    <title>APCI - Mesa de Partes Digital</title>
    <link rel="apple-touch-icon-precomposed" href="https://cdn.apci.gob.pe/dist/images/apple-touch-icon-152x152.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="https://cdn.apci.gob.pe/dist/images/mstile-144x144.png">
    <link rel="icon" href="https://cdn.apci.gob.pe/dist/images/favicon-32x32.png" sizes="32x32">
    <link href="https://cdn.apci.gob.pe/dist/styles/app.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="dist/styles/app.css" type="text/css" rel="stylesheet">

</head>

<body class="theme-yellow dashboard sidebarless contained bg-mapamundi" id="noSidebar">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="icon-facebook-fill" viewbox="0 0 50 50">
            <path
                d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z">
            </path>
        </symbol>
        <symbol id="icon-dribbble-fill" viewbox="0 0 50 50">
            <path
                d="M22.58 28c.42 1.97 1.05 3.93 1.72 5.18-1.1 1.8-2.4 2.82-3.68 2.82C17.29 36 17 33.36 17 32.12c0-.19-.06-5.12 3.12-5.12 1.26 0 2.23.81 2.23.81C22.42 27.88 22.5 27.94 22.58 28zM26.29 14.05c.47.66.75 2.69.75 7.45 0 2.53-.12 5.52-1.05 8.09-.62-2-1.03-4.7-1.03-8.22C24.96 18.13 25.68 15.09 26.29 14.05z">
            </path>
            <path
                d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M35.93,28.84c-0.76,2.34-2.89,8.14-6.11,8.14c-1.02,0-2.39-0.04-3.7-1.32c-1.47,2-3.3,3.34-5.47,3.34C16.06,39,14,35.51,14,32.05c0-3.67,1.88-8,6.13-8c0.72,0,1.38,0.13,1.95,0.33c-0.08-1-0.08-1.8-0.08-3C22,21.27,22.04,11,26.17,11C28.14,11,30,12.77,30,21.5c0,3.12-0.53,7.65-2.38,11.38c0.8,1.04,1.6,1.37,2.13,1.12c1.5-0.72,2.46-3.25,3.36-6.01c0.25-0.75,1.08-1.16,1.85-0.93C35.74,27.3,36.18,28.1,35.93,28.84z">
            </path>
        </symbol>
        <symbol id="icon-linkedin-fill" viewbox="0 0 50 50">
            <path
                d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56c3.97,0,7.19,2.73,7.19,8.26V39z">
            </path>
        </symbol>
        <symbol id="icon-youtube-fill" viewbox="0 0 50 50">
            <path
                d="M44.9,14.5c-0.4-2.2-2.3-3.8-4.5-4.3C37.1,9.5,31,9,24.4,9c-6.6,0-12.8,0.5-16.1,1.2c-2.2,0.5-4.1,2-4.5,4.3C3.4,17,3,20.5,3,25s0.4,8,0.9,10.5c0.4,2.2,2.3,3.8,4.5,4.3c3.5,0.7,9.5,1.2,16.1,1.2s12.6-0.5,16.1-1.2c2.2-0.5,4.1-2,4.5-4.3c0.4-2.5,0.9-6.1,1-10.5C45.9,20.5,45.4,17,44.9,14.5z M19,32V18l12.2,7L19,32z">
            </path>
        </symbol>
        <symbol id="icon-open-book-fill" viewbox="0 0 50 50">
            <path fill="none" stroke-miterlimit="10" stroke-width="2" d="M25 42L25 9"></path>
            <path
                d="M43,8v30c-10,0-18,4-18,4s-8-4-18-4V8H2v35h1c12.612,0,21.506,3.875,21.595,3.914l0.406,0.18l0.404-0.18C25.494,46.875,34.388,43,47,43h1V8H43z">
            </path>
            <path fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"
                d="M25,9c0,0-8-4-18-4v33c10,0,18,4,18,4s8-4,18-4V5C33,5,25,9,25,9z"></path>
        </symbol>
        <symbol id="icon-default" viewBox="0 0 512 512">
            <path
                d="M156.5,447.7l-12.6,29.5c-18.7-9.5-35.9-21.2-51.5-34.9l22.7-22.7C127.6,430.5,141.5,440,156.5,447.7z M40.6,272H8.5 c1.4,21.2,5.4,41.7,11.7,61.1L50,321.2C45.1,305.5,41.8,289,40.6,272z M40.6,240c1.4-18.8,5.2-37,11.1-54.1l-29.5-12.6 C14.7,194.3,10,216.7,8.5,240H40.6z M64.3,156.5c7.8-14.9,17.2-28.8,28.1-41.5L69.7,92.3c-13.7,15.6-25.5,32.8-34.9,51.5 L64.3,156.5z M397,419.6c-13.9,12-29.4,22.3-46.1,30.4l11.9,29.8c20.7-9.9,39.8-22.6,56.9-37.6L397,419.6z M115,92.4 c13.9-12,29.4-22.3,46.1-30.4l-11.9-29.8c-20.7,9.9-39.8,22.6-56.8,37.6L115,92.4z M447.7,355.5c-7.8,14.9-17.2,28.8-28.1,41.5 l22.7,22.7c13.7-15.6,25.5-32.9,34.9-51.5L447.7,355.5z M471.4,272c-1.4,18.8-5.2,37-11.1,54.1l29.5,12.6 c7.5-21.1,12.2-43.5,13.6-66.8H471.4z M321.2,462c-15.7,5-32.2,8.2-49.2,9.4v32.1c21.2-1.4,41.7-5.4,61.1-11.7L321.2,462z M240,471.4c-18.8-1.4-37-5.2-54.1-11.1l-12.6,29.5c21.1,7.5,43.5,12.2,66.8,13.6V471.4z M462,190.8c5,15.7,8.2,32.2,9.4,49.2h32.1 c-1.4-21.2-5.4-41.7-11.7-61.1L462,190.8z M92.4,397c-12-13.9-22.3-29.4-30.4-46.1l-29.8,11.9c9.9,20.7,22.6,39.8,37.6,56.9 L92.4,397z M272,40.6c18.8,1.4,36.9,5.2,54.1,11.1l12.6-29.5C317.7,14.7,295.3,10,272,8.5V40.6z M190.8,50 c15.7-5,32.2-8.2,49.2-9.4V8.5c-21.2,1.4-41.7,5.4-61.1,11.7L190.8,50z M442.3,92.3L419.6,115c12,13.9,22.3,29.4,30.5,46.1 l29.8-11.9C470,128.5,457.3,109.4,442.3,92.3z M397,92.4l22.7-22.7c-15.6-13.7-32.8-25.5-51.5-34.9l-12.6,29.5 C370.4,72.1,384.4,81.5,397,92.4z">
            </path>
            <circle cx="256" cy="364" r="28">
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="r"
                    values="28;14;28;28;14;28;"></animate>
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="opacity"
                    values="1;0;1;1;0;1;"></animate>
            </circle>
            <path opacity="1"
                d="M263.7,312h-16c-6.6,0-12-5.4-12-12c0-71,77.4-63.9,77.4-107.8c0-20-17.8-40.2-57.4-40.2c-29.1,0-44.3,9.6-59.2,28.7 c-3.9,5-11.1,6-16.2,2.4l-13.1-9.2c-5.6-3.9-6.9-11.8-2.6-17.2c21.2-27.2,46.4-44.7,91.2-44.7c52.3,0,97.4,29.8,97.4,80.2 c0,67.6-77.4,63.5-77.4,107.8C275.7,306.6,270.3,312,263.7,312z">
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="opacity"
                    values="1;0;0;0;0;1;"></animate>
            </path>
            <path opacity="0"
                d="M232.5,134.5l7,168c0.3,6.4,5.6,11.5,12,11.5h9c6.4,0,11.7-5.1,12-11.5l7-168c0.3-6.8-5.2-12.5-12-12.5h-23 C237.7,122,232.2,127.7,232.5,134.5z">
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="opacity"
                    values="0;0;1;1;0;0;"></animate>
            </path>
        </symbol>
    </svg>
    <div class="preloader"></div>
    <div class="wrapper">
        <header class="main-header bg-primary-dark">
            <div class="container"><a class="brand" href="index.php"><img
                        src="https://cdn.apci.gob.pe/dist/images/apci__logo--full.svg" alt="alt" height="30"></a></div>
        </header>
        <main class="page-wrapper d-flex align-items-center justify-content-between">
            <section class="page-content container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6">
                        <h1 class="text-primary mb-4" style="font-weight: 700">Mesa de partes digital<br>de la APCI</h1>
                        <p class="lead">Para mayor facilidad, ahora contamos con una Mesa de partes digital que le
                            permitirá el envío de documentos a la APCI.</p>
                        <button class="btn btn-sm btn-outline-primary" type="button"><i
                                class="bi bi-file-arrow-down"></i> <a href="http://files.apci.gob.pe/srv-files/Documentacion/manual-de-usuario-mesa-de-partes-digital.pdf">Manual de usuario</a></button><br/><br/>
                        
                                <button class="btn btn-sm btn-outline-primary" type="button"><i
                                class="bi bi-file-arrow-down"></i> <a href="https://files.apci.gob.pe/srv-files/Documentacion/Instructivo-para-entidades.pdf">Instructivo para entidades que realizan un Procedimiento Administrativo

</a></button>

                    </div>
                    <div class="col-4">
                        <form name="MyForm" id="MyForm" method="POST">
                            <input type="hidden" id="tipoPersona" name="tipoPersona" value="" />
                            <div class="card mb-5 bg-white rounded">
                                <img class="card-img-top" src="https://cdn.apci.gob.pe/dist/images/card-img--pn.png"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Persona natural</h5>
                                    <p class="card-text">Soy persona natural y deseo ingresar mi documento</p>
                                </div>
                                <div class="card-body">
                                    <p class="card-link mb-0 text-primary">
                                        <a class="stretched-link"
                                            href="javascript:envioTipoPersona('registro.php', '60')">Ingresar</a>
                                    </p>
                                </div>

                            </div>
                            <div class="card mb-5 bg-white rounded">
                                <img class="card-img-top" src="https://cdn.apci.gob.pe/dist/images/card-img--pj.png"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Persona jurídica</h5>
                                    <p class="card-text">Soy persona natural que representa a una empresa/entidad.</p>
                                </div>
                                <div class="card-body">
                                    <p class="card-link mb-0 text-primary">
                                        <a class="stretched-link"
                                            href="javascript:envioTipoPersona('registro.php', '62')">Ingresar</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <footer class="footer text-center"></footer>
        </main>
    </div>

    <script src="https://cdn.apci.gob.pe/dist/scripts/app.lite.js"></script>
    <script src="https://cdn.apci.gob.pe/dist/scripts/vendor/fontawesome-5.12.0/all.min.js"></script>
    <script>
    function envioTipoPersona(url, tipoP) {
        var form = document.getElementById("MyForm");
        var tipoPersona = document.getElementById("tipoPersona");
        tipoPersona.value = tipoP;
        form.action = url;
        form.submit();
    }
    </script>
</body>

</html>