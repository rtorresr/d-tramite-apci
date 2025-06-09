<?php
/**
 * Created by PhpStorm.
 * User: acachay
 * Date: 12/11/2018
 * Time: 14:31
 */
/* Initialize webservice with your WSDL */
/* Set your parameters for the request */
ini_set('max_execution_time', 300);
set_time_limit(300);

$options = array(
    'exceptions'=>true,
    'trace'=>1,
    //'stream_context' => stream_context_create($arrContextOptions)
);
$url = '';


if (isset($_REQUEST['dni'])){
    $params = array(
            "nuDniConsulta" => $_REQUEST['dni'], //44069967
            "nuDniUsuario" => 40413882,   // DE lUIS RODRIGUEZ
            "nuRucUsuario" => 20504915523,
            "password" => 40413882,
    );
    $url = 'https://ws5.pide.gob.pe/services/ReniecConsultaDni?wsdl';
    //$url = 'https://ws2.pide.gob.pe/services/RENIECCDni?wsdl';
    $client = new SoapClient($url, $options);
    $query = $client->consultar(array('arg0'=>$params));
    }else{
        $params = array(
            "numruc" => $_REQUEST['ruc']
        );
        $url= 'https://ws3.pide.gob.pe/services/SunatConsultaRuc?wsdl';
        $client = new SoapClient($url, $options);
        /*$funciones      = $client->__getFunctions();
        foreach ($funciones as $key => $value) {
            list($funcion) = explode(' ', $value);
            $funcion = str_replace('_Response', '', $funcion);
            $funcion = str_replace('Response', '', $funcion);
            echo $funcion . "<br>";
        }*/
        $query = $client->getDatosPrincipales($params);
    }

if ($_REQUEST['type']==='json'){
    if (isset($_REQUEST['dni'])){
        $dp = $query->return->datosPersona;
    }else{
        $dp = $query->getDatosPrincipalesReturn;
    }
    array_walk_recursive($dp, function(&$val) {
        $val = utf8_encode($val);
    });
    echo (json_encode($dp, JSON_FORCE_OBJECT| JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
    exit();
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="assets/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>SOAP</title>
</head>
<body>

<div class="container">
    <!-- Start your project here-->
    <section class="section">

        <!--Section heading-->
        <h2 class="h1-responsive font-weight-bold text-center my-5">SOAP APCI</h2>
        <!--Section description-->
        <p class="text-center w-responsive mx-auto mb-5">Tienes dudas ponte en contacto con Nosotros.</p>

        <div class="row">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="reniec-tab" data-toggle="tab" href="#reniec" role="tab" aria-controls="reniec" aria-selected="true">RENIEC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">SUNAT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">OTRO</a>
                </li>
            </ul>
            <br>
            <div class="tab-content row" id="myTabContent">
                <div class="tab-pane fade show active" id="reniec" role="tabpanel" aria-labelledby="reniec-tab">
                    <!--Grid column-->
                    <div class="col-md-12 mb-md-12 mb-12">
                        <form id="contact-form" name="contact-form"  method="POST">
                            <!--Grid row-->
                            <div class="row">
                                <!--Grid column-->
                                <div class="col-md-12">
                                    <div class="md-form mb-12">
                                        <input type="text" id="dni" name="dni" class="form-control">
                                        <label for="name" class="">DNI</label>
                                    </div>
                                </div>
                                <!--Grid column-->
                            </div>
                        </form>

                        <div class="text-center text-md-left">
                            <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Enviar</a>
                        </div>

                        <!--Grid column-->
                        <div class="col-md-12">
                            <ul >
                                <li>
                                    <p>Primer Apellido: <?=$query->return->datosPersona->apPrimer?></p>
                                </li>

                                <li>
                                    <p>Segundo Apellido:<?=$query->return->datosPersona->apSegundo?></p>
                                </li>

                                <li>
                                    <p>Dirección:<?=$query->return->datosPersona->direccion?></p>
                                </li>
                                <li>
                                    <p>Estado Civil:<?=$query->return->datosPersona->estadoCivil?></p>
                                </li>

                                <li>
                                    <p>Prenombres: <?=$query->return->datosPersona->prenombres?></p>
                                </li>

                                <li>
                                    <p>Restriccion:<?=$query->return->datosPersona->restriccion?></p>
                                </li>
                                <li>
                                    <p>Ubigeo:<?=$query->return->datosPersona->ubigeo?></p>
                                </li>
                                <li>
                                    Foto:
                                    <img src="data:image/png;base64, <?=base64_encode($query->return->datosPersona->foto)?>" class="img-fluid" alt="Responsive image">
                                </li>
                            </ul>
                        </div>
                        <!--Grid column-->

                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <!--Grid column-->
                    <div class="col-md-12 mb-md-12 mb-12">
                        <form id="contact-form" name="contact-form"  method="POST">
                            <!--Grid row-->
                            <div class="row">
                                <!--Grid column-->
                                <div class="col-md-12">
                                    <div class="md-form mb-12">
                                        <input type="text" id="ruc" name="ruc" class="form-control">
                                        <label for="name" class="">RUC</label>
                                    </div>
                                </div>
                                <!--Grid column-->
                            </div>
                        </form>

                        <div class="text-center text-md-left">
                            <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Enviar</a>
                        </div>

                        <!--Grid column-->
                        <div class="col-md-12">
                            <ul >
                                <li>
                                    <p>RAZÓN SOCIAL: <?=$query->getDatosPrincipalesReturn->ddp_nombre?></p>
                                </li>

                                <li>
                                    <p>DIRECCIÓN:<?=$query->getDatosPrincipalesReturn->ddp_nomvia?></p>
                                </li>


                            </ul>
                        </div>
                        <!--Grid column-->

                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi
                    farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia
                    banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi
                    whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't
                    heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.
                </div>
            </div>


    </section>
    <!--Section: Contact v.2-->
</div>

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="assets/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="assets/js/mdb.min.js"></script>

</body>
</html>