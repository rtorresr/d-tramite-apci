<?php
/**
 * Created by PhpStorm.
 * User: acachay
 * Date: 13/12/2018
 * Time: 16:25
 */

require __DIR__ . '/../vendor/autoload.php';
include '../conexion/conexion.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
set_time_limit(0);     ini_set('memory_limit', '3540M');
ob_start();
date_default_timezone_set('America/Lima');
function sliceString($formatted_tag,$n=2){
    $formatted_tag =explode(' ', $formatted_tag);
    $oooo = "";
    for ($i = 0,$iMax = count($formatted_tag);  $i<= $iMax; $i++){
        if ($i>0 && ($i%$n == 0)){
            $oooo .= " <br> ".$formatted_tag[$i];
        }else{
            $oooo .= " ".$formatted_tag[$i];
        }
    }
    return $oooo;
}
$idt = $_REQUEST['idt'];

$sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sql.=" WHERE Tra_M_Tramite.iCodTramite='".$idt."'";
$rs=sqlsrv_query($cnx,$sql);
while ($Rs=sqlsrv_fetch_array($rs)){
    $sqlTipDoc="SELECT dbo.Tra_M_Tipo_Documento.cCodTipoDoc, dbo.Tra_M_Tipo_Documento.cDescTipoDoc, dbo.Tra_M_Plantilla.parametros FROM dbo.Tra_M_Tipo_Documento 
                        INNER JOIN dbo.Tra_M_Plantilla ON dbo.Tra_M_Plantilla.cCodTipoDoc = dbo.Tra_M_Tipo_Documento.cCodTipoDoc WHERE dbo.Tra_M_Tipo_Documento.cCodTipoDoc=".$Rs['cCodTipoDoc'];
    $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
    $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
    $tipoDoc = $RsTipDoc['cDescTipoDoc'];
    $param = eval("return ".$RsTipDoc['parametros'].";");
    $numDoc = $Rs['cCodificacion'] ?? '';

    $sqlofi = "select cSiglaOficina as sigla  from Tra_M_Oficinas where iCodOficina =".$Rs['iCodOficinaRegistro'];
    $qofice=sqlsrv_query($cnx,$sqlofi);
    $siglaoficina=sqlsrv_fetch_array($qofice);

    if (strpos($siglaoficina['sigla'], '-')){
        $arrayoficina = explode("-", $siglaoficina['sigla']);
        $oficinajefe = $arrayoficina[1];
    }else{
        $oficinajefe = $siglaoficina;
    }

    if (trim($oficinajefe) == "MP"){
        $oficinajefe = "OGA";
    }
    $sqlIDjefe = "SELECT iCodOficina FROM dbo.Tra_M_Perfil_Ususario where iCodPerfil=3 and iCodOficina = (select iCodOficina  from Tra_M_Oficinas where cSiglaOficina like '%$oficinajefe')";
    $idJefe=sqlsrv_query($cnx,$sqlIDjefe);
    $idJefe=sqlsrv_fetch_array($idJefe);

    $sqlofi = "select cNomOficina as oficina  from Tra_M_Oficinas where iCodOficina =".$idJefe['iCodOficina'];
    $qofice=sqlsrv_query($cnx,$sqlofi);
    $siglaoficina=sqlsrv_fetch_array($qofice);
    $words = array('Y', 'De','E');
    $regex = '/\b(' . implode( '|', $words) . ')\b/i';
    $formatted_tag = preg_replace_callback( $regex, function( $matches) {
        return strtolower( $matches[1]);
    }, ucwords(mb_strtolower(trim($siglaoficina['oficina']))));
    $oooo = sliceString($formatted_tag,3);

    $sqlDatos2 = "SELECT A.iCodMovimiento,	A.iCodTramite,	A.iCodTrabajadorRegistro,	A.iCodOficinaOrigen,	iCodOficinaDerivar,	iCodTrabajadorDerivar, (	RTRIM( C.cNombresTrabajador ) + ' ' + RTRIM( C.cApellidosTrabajador )) AS nombresTrabajadorDeriva, dbo.GetCargo(A.iCodTrabajadorDerivar) as cargo ";
    $sqlDatos2 .= " FROM	Tra_M_Tramite_Movimientos A	INNER JOIN Tra_M_Trabajadores C ON A.iCodTrabajadorDerivar = C.iCodTrabajador  ";
    $sqlDatos2 .= " WHERE	A.iCodTramite = ".$Rs['iCodTramite'];
    $rsDatos2=sqlsrv_query($cnx,$sqlDatos2);
    $destino = '';
    $remite  = '';
    $fecha  = '';
    while ($RsDatos2=sqlsrv_fetch_array($rsDatos2)){
        if ($RsDatos2['nombresTrabajadorDeriva'] != '') {
            $destino = "<h2>" . $RsDatos2['nombresTrabajadorDeriva'] . "</h2>".'<p>' . $RsDatos2['cargo'] . '</p> <br>';
        }else{
            $sqlDatos2 = "SELECT	A.iCodTramite,	A.iCodRemitente,	RTRIM( C.cNombre ) as nombre ";
            $sqlDatos2 .= " FROM	Tra_M_Tramite A	INNER JOIN Tra_M_Remitente C ON A.iCodRemitente = C.iCodRemitente ";
            $sqlDatos2 .= " WHERE	A.iCodTramite = ".$Rs['iCodTramite'];
            $rsDatos2=sqlsrv_query($cnx,$sqlDatos2);
            $RsDatos2=sqlsrv_fetch_array($rsDatos2);
            $destino = "<h2>" . $RsDatos2['nombre'] . "</h2>";
        }
        $sqlDatos = " SELECT A.iCodMovimiento,	A.iCodTramite,	A.iCodTrabajadorRegistro,";
        $sqlDatos .= " (RTRIM (B.cNombresTrabajador)+' '+ RTRIM (B.cApellidosTrabajador)) AS nombresTrabajadorRegistro, ";
        $sqlDatos .= " A.iCodOficinaOrigen,	dbo.GetCargo(A.iCodTrabajadorRegistro) as cargo ";
        $sqlDatos .= " FROM	Tra_M_Tramite_Movimientos A	INNER JOIN Tra_M_Trabajadores B ON A.iCodTrabajadorRegistro = B.iCodTrabajador	 ";
        $sqlDatos .= " WHERE A.iCodTramite = ".$Rs['iCodTramite']; //".$Rs['iCodMovimiento']."AND

        $rsDatos3=sqlsrv_query($cnx,$sqlDatos);
        $RsDatos3=sqlsrv_fetch_array($rsDatos3);

        $remite="<h2>" .$RsDatos3['nombresTrabajadorRegistro']  . "</h2> <p>".$RsDatos3['cargo'].'</p>';
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $fecha = $Rs['fFecRegistro']->format('m/d/Y');

    }

?>

    <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>Header and Footer example</title>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                font-family: Calibri, Arial, sans-serif;
                text-align: justify;
                margin-top: 4.5cm;
                margin-left: 3cm;
                margin-right: 2.5cm;
                margin-bottom: 2.5cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 1cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
                margin: 0 auto;
                text-align: center;
                width: 85%;
                left: 50%;
                margin-left: -37.5%;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 3cm; 
                right: 2.5cm;
                height: 2cm;
            }

            footer {
                text-align: right;
            }

            hr {
                //page-break-after: always;
                border: 0;
            }

            .center {
                text-align: center;
            }

            #logoMin {
                color: #FFFFFF;
            }

            #logoCaption {
                color: #515151;
                text-align: center;
                font-size: 10px;
            }

            .minText p {                 
                font-size: 11.5px;
                font-weight: 700;
                padding-left: 7px;
                padding-right: 7px;
            }

            h1 {
                font-size: 14px;
                text-align: center;
                text-decoration: underline;
                font-weight: 700;
                text-transform: uppercase;
                margin-bottom: 0.75cm;
            }

            h2 {
                font-size: 14px;
                margin: 0;
                text-align: left;
            }

            .subtitle {
                text-align: left;
            }

            .subtitle h3 {
                font-size: 14px;
            }

            .item {
                text-align: left;
                width: 80px;
                vertical-align: text-top;
            }

            .desc {
                text-align: left;
                vertical-align: text-top;
            }

            .desc p {
                margin: 0;
            }

            .glosa {
                width:100%;
            }

            .glosa {
                padding-bottom: 10px;
                border-bottom: 1px solid #515151;
                margin-bottom: 20px;
            }

            .dots {
                width: 10px;
                vertical-align: text-top;
            }
        </style>
    </head>

    <body>
    <?php
    if ($param['head'] === 'title'){
        include ('template/head.php');
    }else{
        echo "sello de agua";
    }
    ?>

        <footer>
            <img class="footerImg" src="../dist/images/pie.png">
        </footer>
        <main>
            <div class="glosa">
                <?php
                $nomenclaturaCentro= '<h1>'.$tipoDoc.' '.$numDoc.'</h1>';
                $destinatario = '<tr><td class="item">A </td> <td class="dots"> : </td> <td class="desc">'.$destino.'</td></tr>';
                $tablai = '<table width="100%">';
                $separador = '<tr><td colspan="3" style="height:5px"></td> </tr>';
                $remitente = '<tr> <td class="item"> De </td> <td> : </td> <td class="desc">'.$remite.' </td> </tr>';
                $asunto = '<tr> <td class="item"> Asunto </td> <td> : </td><td class="desc">'.sliceString($Rs['cAsunto'],8).'</td></tr>';
                $referencia = '<tr> <td class="item">Referencia </td><td>:</td><td class="desc">'.((trim($Rs['cReferencia']) === 'NULL')?'-':$Rs['cReferencia']).'</td></tr>';
                $fecha='<tr><td class="item"> Fecha </td><td>:</td><td  class="desc">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </td> </tr>';
                $tablaf = '</table>';

                $descripcionCuenpo = $Rs['descripcion'].$Rs['cCuerpoDocumento'];
                //check($clean);
                $cuerpo = '</div>'.$descripcionCuenpo;

                foreach ($param['body'] as $pp){
                    eval ('echo $'.$pp.';');
                }
                ?>



        </main>
    </body>
    </html>

    <?php
}
$content = ob_get_clean();
//echo $content;

$dompdf = new DOMPDF();
$dompdf->loadHtml($content);
$dompdf->render();
$dompdf->stream("demo.pdf", array("Attachment" => false));
exit(0);