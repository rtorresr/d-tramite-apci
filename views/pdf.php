<?php
include '../conexion/conexion.php';
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;

ob_start();
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>SITDD</title>
        <?php include("template/styles.php"); ?>
        <style>
            h4, h5 {
                text-align: center;
            }
            p {
                font-size: 12px;
            }
            label {
                font-weight: bold;
                font-size: 12px;
            }
            .subtitulo {
                font-weight: bold;
                font-size: 14px;
            }
            

        </style>
    </head>
    <body>
    <header>
        <table style="margin-left: 20px">
            <tr id="logoMin">
                <td id="peruLogo" class="center" style="heigth: 50px; width: 60px; border:solid white 1.0pt; background:white;">
                    <img width="34" src="../dist/images/peru.png">
                </td>
                <td id="peruText" class="center minText" width="150" style="heigth: 50px; width: 60px; border:solid white 1.0pt;background:#C00000;">
                    <p>PERÚ</p>
                </td>
                <td class="minText" width="151" style="heigth: 50px; width: 200px;border:solid white 1.0pt;border-left:none; background:#333333;">
                    <p>Ministerio <br> de Relaciones Exteriores</p>
                </td>
                <td class="minText" width="180" style="heigth: 50px; width: 200px;border:solid white 1.0pt;border-left:  none;  background:#999999;">
                    <p>Agencia Peruana <br> de Cooperación Internacional</p>
                </td>
            </tr>
            <tr id="logoCaption">
                <td colspan="5">
                    <p>
                        <?php echo '"Decenio de la Igualdad de Oportunidades para mujeres y hombres"';?>
                        <br>
                        <?php echo '"Año del Bicentenario, de la consolidación de nuestra Independencia y de la Conmemoración de las heroicas batallas de Junín y Ayacucho"';?>
                    </p>
                </td>
            </tr>
        </table>
        </header>
        <main>
            <h3>SOLICITUD N° {{numero}} DE ACCESO A LA INFORMACIÓN PÚBLICA</h3>
            <h4>(Texto Único Ordenado de la Ley N° 27806, Ley de Transparencia y Acceso a la Información Pública, aprobado por Decreto Supremo N° 043-2003-PCM)</h4>
            
            <section>
                <p class="subtitulo">I. FUNCIONARIO RESPONSABLE DE ENTREGAR LA INFORMACIÓN:<p>
                <p>Lic. Cecilia Pacheco Torres</p>
            </section>
            <section>
                <p class="subtitulo">II. DATOS DEL SOLICITANTE:<p>
                <p>
                    <label>APELLIDOS Y NOMBRES / RAZÓN SOCIAL</label>
                    <p>{{Ddatos}}</p>
                </p>
                <p>
                    <label>DOCUMENTO DE IDENTIDAD</label>
                    <p>{{Ddatos}}</p>
                </p>
                <p>
                    <label>DOMICILIO</label>
                    <p>{{Ddatos}}</p>
                </p>
                    <label>UBIGEO</label>
                    <p>{{Ddatos}}</p>
                </p>
                </p>
                    <label>TELÉFONO</label>
                    <p>{{Ddatos}}</p>
                </p>
                </p>
                    <label>CORREO ELECTRÓNICO</label>
                    <p>{{Ddatos}}</p>
                </p>
            </section>
            <section>
                <p class="subtitulo">III. INFORMACIÓN SOLICITADA:<p>
                <p>{{Ddatos}}</p>
            </section>
            <section>
                <p class="subtitulo">IV. DEPENDENCIA DE LA CUAL SE REQUIERE LA INFORMACIÓN:<p>
                <p>{{Ddatos}}</p>
            </section>
            <section>
                <p class="subtitulo">V. FORMA DE ENTREGA DE LA INFORMACIÓN<p>
                <p>{{Ddatos}}</p>
            </section>
        </main>
        <footer>
            <img class="footerImg" src="../dist/images/pie.png">
        </footer>
    </body>
</html>

<?php
$content = ob_get_clean();
$nuevo_nombre = "documento.php";

$dompdf = new DOMPDF();
$dompdf->loadHtml($content);
$dompdf->render();
$dompdf->stream($nuevo_nombre, array("Attachment" => false));
$output = $dompdf->output();
?>