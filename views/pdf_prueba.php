<?php
/**
 * Created by PhpStorm.
 * User: dcamarena
 * Date: 6/11/2018
 * Time: 5:27 PM
 */
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
ob_start();
date_default_timezone_set('America/Lima');
include_once("../conexion/conexion.php");
$idt = $_REQUEST['iCodTramite'];
$sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
//$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sql.=" WHERE Tra_M_Tramite.iCodTramite='".$idt."'";
$rs=sqlsrv_query($cnx,$sql);

while ($Rs=sqlsrv_fetch_array($rs)){
    ?>

    <page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
        <style>
            .pageHeader {
                width:100%; text-align: center; margin-bottom: 2rem;
                padding-top: 20px;
            }

            .pageContent {
                margin-top: 100px;
                text-align: justify;
                white-space: pre-wrap;
                word-break: break-all;
            }

            .pageContent p {
                color: tomato;
                text-align: justify;
                white-space: pre-wrap;
                word-break: break-all;
            }

            h1 {
                font-size: 14px;
                text-align: center;
                text-decoration: underline
                font-weigh: 700;
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
            }

            .desc {
                text-align: left;
            }

            .desc p {
                margin: 0;
            }

            .glosa,
            .cuerpo {
                width:100%;
                padding-right: 40px;
                padding-left: 40px;
            }

            .glosa {
                padding-bottom: 0px;
            }

            hr {
                height: 1px;
            }

            .dots {
                width: 10px;
            }
        </style>
        <page_header>
            <div class="pageHeader">
                <img src="../dist/images/cabecera.png">
                <p class="page_header_tag" style="font-family: Arial; font-size: 9pt;"> <?= '"Decenio de la Igualdad de Oportunidades para mujeres y hombres"'?>
                    <br>
                    <?php echo '"Año de la recuperación y consolidación de la economía peruana"'?>
                </p>
            </div>
        </page_header>
        <page_footer>
            <div class="page_footer" style="width:100%; text-align: right; padding-right: 70px;">
                <img src="../dist/images/pie.png">
                <br><br>
            </div>
        </page_footer>
        <div class="pageContent">
            <div>
                <?php
                $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=".$Rs['cCodTipoDoc']."";
                $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
                $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
                $tipoDoc = $RsTipDoc['cDescTipoDoc'];
                $numDoc = $Rs['cCodificacion'] ?? '';
                ?>
                
                <h1><?php echo $tipoDoc.' '.$numDoc; ?></h1><br>
            </div>
            <div class="glosa">
                <table width="100%">
                    <tr>
                        <td class="item">
                            A
                        </td>
                        <td class="dots">
                            :
                        </td>
                        <td class="desc">
                            <?php
                            $sqlDatos2 = "SELECT A.iCodMovimiento,	A.iCodTramite,	A.iCodTrabajadorRegistro,	A.iCodOficinaOrigen,	iCodOficinaDerivar,	iCodTrabajadorDerivar, (	RTRIM( C.cNombresTrabajador ) + ' ' + RTRIM( C.cApellidosTrabajador )) AS nombresTrabajadorDeriva, dbo.GetCargo(A.iCodTrabajadorDerivar) as cargo ";
                            $sqlDatos2 .= " FROM	Tra_M_Tramite_Movimientos A	INNER JOIN Tra_M_Trabajadores C ON A.iCodTrabajadorDerivar = C.iCodTrabajador  ";
                            $sqlDatos2 .= " WHERE	A.iCodTramite = ".$Rs['iCodTramite'];
                            $rsDatos2=sqlsrv_query($cnx,$sqlDatos2);
                            $RsDatos2=sqlsrv_fetch_array($rsDatos2);
                            if ($RsDatos2['nombresTrabajadorDeriva'] != '') {
                                echo "<h2>" . $RsDatos2['nombresTrabajadorDeriva'] . "</h2>";
                                echo '<p>' . $RsDatos2['cargo'] . '</p>';
                            }else{
                                $sqlDatos2 = "SELECT	A.iCodTramite,	A.iCodRemitente,	RTRIM( C.cNombre ) as nombre ";
                                $sqlDatos2 .= " FROM	Tra_M_Tramite A	INNER JOIN Tra_M_Remitente C ON A.iCodRemitente = C.iCodRemitente ";
                                $sqlDatos2 .= " WHERE	A.iCodTramite = ".$Rs['iCodTramite'];
                                $rsDatos2=sqlsrv_query($cnx,$sqlDatos2);
                                $RsDatos2=sqlsrv_fetch_array($rsDatos2);
                                echo "<h2>" . $RsDatos2['nombre'] . "</h2>";
                            }

                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height:5px"></td>
                    </tr>
                    <tr>
                        <td class="item">
                            De
                        </td>
                        <td>
                            :
                        </td>
                        <td class="desc">
                            <?php
                            $sqlDatos = " SELECT A.iCodMovimiento,	A.iCodTramite,	A.iCodTrabajadorRegistro,";
                            $sqlDatos .= " (RTRIM (B.cNombresTrabajador)+' '+ RTRIM (B.cApellidosTrabajador)) AS nombresTrabajadorRegistro, ";
                            $sqlDatos .= " A.iCodOficinaOrigen,	dbo.GetCargo(A.iCodTrabajadorRegistro) as cargo ";
                            $sqlDatos .= " FROM	Tra_M_Tramite_Movimientos A	INNER JOIN Tra_M_Trabajadores B ON A.iCodTrabajadorRegistro = B.iCodTrabajador	 ";
                            $sqlDatos .= " WHERE A.iCodTramite = ".$Rs['iCodTramite']; //".$Rs['iCodMovimiento']."AND

                            $rsDatos3=sqlsrv_query($cnx,$sqlDatos);
                            $RsDatos3=sqlsrv_fetch_array($rsDatos3);

                            echo "<h2>" .$RsDatos3['nombresTrabajadorRegistro']  . "</h2>";
                            echo '<p>'.$RsDatos3['cargo'].'</p>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height:5px"></td>
                    </tr>
                    <tr>
                        <td class="item">
                            Asunto
                        </td>
                        <td>
                            :
                        </td>
                        <td class="desc">
                            <?php
                            echo $Rs['cAsunto'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height:5px"></td>
                    </tr>
                    <tr>
                        <td class="item">
                            Referencia
                        </td>
                        <td>
                            :
                        </td>
                        <td class="desc">
                            <?php
                            echo $Rs['cReferencia'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height:5px"></td>
                    </tr>
                    <tr>
                        <td class="item">
                            Fecha
                        </td>
                        <td>
                            :
                        </td>
                        <td  class="desc">
                            <?php
                            setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
                            $fecha = $Rs['fFecRegistro']->format('m/d/Y');
                            echo strftime('Miraflores, %e de %B del %Y', strtotime($fecha));
                            //   echo  ?>
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="cuerpo">
                <?php
                echo $Rs['descripcion'].$Rs['cCuerpoDocumento'];
                ?>
            </div>

        </div>
    </page>
    <?php
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$content = ob_get_clean();  set_time_limit(0);     ini_set('memory_limit', '3540M');

// conversion HTML => PDF
require_once(dirname(__FILE__).'/../views/html2pdf/html2pdf.class.php');

$html2pdf = new HTML2PDF('P','A4', 'es', true, 'UTF-8', 3);
//$html2pdf->setDefaultFont('arialunicid0'); //add this line
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
//$html2pdf->writeHTML($content);
$separa=DIRECTORY_SEPARATOR;
$tmp = dirname(tempnam (null,''));
$tmp = $tmp.$separa."upload";

/*if ( !is_dir($tmp)) {
    mkdir($tmp);
}
$url_f = 'docNoFirmados/'.$nomenclatura.'/';

$_POST['path'] = $url_f;
$_POST['name'] = 'fileUpLoadDigital';
$nuevo_nombre = str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])).'-'.str_replace('/','-',$cCodificacion).'.pdf';*/

$nuevo_nombre = "example.pdf";
$html2pdf->Output($tmp.$separa.$nuevo_nombre, 'T');

/*$_FILES['fileUpLoadDigital']['tmp_name'] = $tmp.$separa.$nuevo_nombre;
$_FILES['fileUpLoadDigital']['name'] = $nuevo_nombre;
$_FILES['fileUpLoadDigital']['type'] = 'PDF';
$_POST['new_name'] = $nuevo_nombre;
$curl->uploadFile($_FILES, $_POST);
//$sftp->uploadFile($_FILES['fileUpLoadDigital']['tmp_name'][0], $path.'/'.$nuevo_nombre);
//$url =  str_replace('opt/stdd/files//','files/',$host.':'.$port_ngnix.$path.'/'.$nuevo_nombre);
$url  = $url_srv.$url_f.$nuevo_nombre;
$curl->closeCurl();*/


?>
