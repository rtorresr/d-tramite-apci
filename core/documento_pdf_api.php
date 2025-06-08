<?php
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
if (isset($_POST['contenidoHtml'])) {
    ?>
    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Generador de PDF</title>
        <?php
            if (isset($_POST['contenidoStyle'])) {
                echo $_POST['contenidoStyle'];
            }
        ?>
    </head>
    <body>
        <?php
            echo $_POST['contenidoHtml'];
        ?>
    </body>
    </html>
    <?php
    try {
        $content = ob_get_clean();

        $orientacion = isset($_POST['orientacion']) ?? "portrait";
        $tamano = isset($_POST['tamano']) ?? "A4";

        $dompdf = new DOMPDF();
        $dompdf->loadHtml($content);
        $dompdf->setPaper($tamano, $orientacion);
        $dompdf->render();

        $output = $dompdf->output();
        $base64 = base64_encode($output);

        $datos = array(
            "Base64Pdf" => $base64
        );

        $success = true;
        $mensaje = "PDF creado correctamente.";
        http_response_code(200);
    } catch (Exception $e) {
        $mensaje = $e->getMessage();
        $success = false;
        $datos = array();
        http_response_code(400);
    }
} else {
    $mensaje = "Paramatros no ingresados, debe ingresar contenidoHtml";
    $mensaje = $_POST;
    $success = false;
    $datos = array();
    http_response_code(400);
}

echo json_encode(array(
    "Success"       => $success,
    "MessageResult" => $mensaje,
    "ListResult"    => null,
    "EntityResult"  => $datos
));


