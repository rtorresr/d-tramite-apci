<?php
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;
$nNumAno = date('Y');
$nNumMes = date('m');

include_once("../conexion/conexion.php");
session_start();
set_time_limit(0);     ini_set('memory_limit', '3540M');
ob_start();
date_default_timezone_set('America/Lima');

$datos = $_POST;
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>D-Tramite</title>
    <?php include_once("template/styles.php"); ?>
</head>
<body>
    <header>
        <table>
            <tr id="logoMin">
                <td id="peruLogo" class="center" style="heigth: 50px; width: 50px; border:solid white 1.0pt; background:white;">
                    <img width="34" src="../dist/images/peru.png">
                </td>
                <td id="peruText" class="center minText" width="150" style="heigth: 50px; width: 50px; border:solid white 1.0pt;background:#C00000;">
                    <p>PERÚ</p>
                </td>
                <td class="minText" width="151" style="heigth: 50px; width: 150px;border:solid white 1.0pt;border-left:none; background:#333333;">
                    <p>Ministerio <br> de Relaciones Exteriores</p>
                </td>
                <td class="minText" width="180" style="heigth: 50px; width: 150px;border:solid white 1.0pt;border-left:  none;  background:#999999;">
                    <p>Agencia Peruana <br> de Cooperación Internacional</p>
                </td>

                <td class="minText" width="151" style="heigth: 50px; width: 150px; border:solid white 1.0pt;border-left:none;  background:silver;">
                    <p>Mesa de Partes</b>
                    </p>
                </td>
            </tr>
            <tr id="logoCaption">
                <td colspan="5">
                    <p>
                        "Decenio de la Igualdad de Oportunidades para mujeres y hombres"
                        <br>
                        "Año del Bicentenario, de la consolidación de nuestra Independencia y de la Conmemoración de las heroicas batallas de Junín y Ayacucho"
                    </p>
                </td>
            </tr>
        </table>
    </header>
<footer>
    <img class="footerImg" src="../dist/images/pie.png">
</footer>
<main class="formatoEntrega">
    <h1><?=$datos['DOCUMENTO']?></h1>

    <dl class="dl-custom">
        <dt>Responsable Mesa Partes APCI</dt>
        <dd><?=$datos['TRABAJADOR_MESA_PARTES']?></dd>

        <dt>Entidad responsable</dt>
        <dd><?=$datos['EMPRESA']?></dd>
        
        <dt>Responsable</dt>
        <dd><?=$datos['TRABAJADOR']?></dd>
        
        <dt>Tipo mensajeria</dt>
        <dd><?=$datos['TIPO_MENSAJERIA']?></dd>
        
        <!--<label>Nro de Orden: </label>
        <p><?//=$datos['NRO_ORDEN']?></p>-->
        <dt>Fecha y Hora</dt>
        <dd><?php $date = new DateTime($datos['FECHA']); echo $date->format('d-m-Y H:i:s');?></dd>
        
        <dt>Documentos</dt>
        <dd>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Nro</th>
                        <th>CUD</th>
                        <th>Documento</th>
                        <th>Dirección</th>
                        <th>Ubigeo</th>
                        <th>Zona</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $documentos = json_decode($_POST['DOCUMENTOS_DETALLE'], true);
                    foreach ($documentos AS $clave => $value){
                        $htmlcuerpo =  '<tr>
                                            <td>'.$value['NroItem'].'</td>
                                            <td>'.$value['Cud'].'</td>
                                            <td>'.$value['Documento'].'</td>
                                            <td>'.$value['Direccion'].'</td>
                                            <td>'.$value['DescDepartamento'].', '.$value['DescProvincia'].', '.$value['DescDistrito'].'</td>
                                            <td>'.$value['NomZonaEntrega'].'</td>
                                        </tr>';
                        echo $htmlcuerpo;
                    }
                ?>
                </tbody>
            </table>
        </dd>
    </dl>

    <div class="row">
        <div class="col">
            <div class="firma">
                <h4><?=$datos['TRABAJADOR_MESA_PARTES']?></h4>
                <small>Responsable Mesa Partes APCI</small>
            </div>                    
        </div>
        <div class="col">
            <div class="firma">
                <h4><?=$datos['TRABAJADOR']?></h4>
                <small>Responsable</small>
            </div>
        </div>
    </div>
</main>
</body>
</html>


<?php
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$contentido = ob_get_clean();

$dompdf = new DOMPDF();
$dompdf->loadHtml($contentido);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$dompdf->stream(str_replace('°', 'ro',str_replace(' ', '_',str_replace('/', '-',$datos['DOCUMENTO']))), array("Attachment" => false));
?>
