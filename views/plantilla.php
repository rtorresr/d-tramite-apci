<?php
/**
 * Created by PhpStorm.
 * User: anthonywainer
 * Date: 06/12/2018
 * Time: 16:25
 */

require __DIR__ . '/../vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
set_time_limit(0);     ini_set('memory_limit', '3540M');
ob_start();
// instantiate and use the dompdf class
$dompdf = new Dompdf();
include('../conexion/conexion.php');
//include 'documento_pdf.php';
?>

    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Header and Footer example</title>
        <style type="text/css">
            @page {
                margin: 2cm;
            }
            body {
                font-family: sans-serif;
                margin: 0.5cm 0;
                text-align: justify;
            }
            #header,
            #footer {
                position: fixed;
                left: 0;
                right: 0;
                color: #aaa;
                font-size: 0.9em;
            }
            #header {
                top: 0;
                border-bottom: 0.1pt solid #aaa;
            }
            #footer {
                bottom: 0;
                border-top: 0.1pt solid #aaa;
            }
            #header table,
            #footer table {
                width: 100%;
                border-collapse: collapse;
                border: none;
            }

            #header td,
            #footer td {
                padding: 0;
                width: 80%;
            }

            .page-number {
                text-align: center;
            }

            .page-number:before {
                content: "Page " counter(page);
            }

            hr {
                page-break-after: always;
                border: 0;
            }

        </style>

    </head>

    <body>

    


    </body>
</html>

<?php
$content = ob_get_clean();
//echo $content; exit();
$dompdf->loadHtml($content);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();
$nuevo_nombre = str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])).'-'.str_replace('/','-',$cCodificacion).'.pdf';
$dompdf->stream($nuevo_nombre, array("Attachment" => false));
$output = $dompdf->output();