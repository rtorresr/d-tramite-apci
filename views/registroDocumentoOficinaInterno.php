<?php

include('../core/SFTPConnection.php');
include_once("../conexion/conexion.php");
include_once("../conexion/conexionSSH.php");

session_start();
date_default_timezone_set('America/Lima');

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    $fFecActual = date('Ymd').' '.date('G:i:s');
    $rutaUpload = '/opt/stdd/files/';
    $nNumAno    = date('Y');
    $nNumMes    = date('M');

    //leer sigla oficina
    $sqlNomOfi="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'";
    $RsSigla=sqlsrv_query($cnx,$sqlNomOfi);
    $RsSigla=sqlsrv_fetch_array($RsSigla);

    //leer user Trabajador
    $sqlNomUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
    $rsNomUsr=sqlsrv_query($cnx,$sqlNomUsr);
    $RsNomUsr=sqlsrv_fetch_array($rsNomUsr);



    ob_start();
    $sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
    $sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    $sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
    $sql.=" WHERE Tra_M_Tramite.iCodTramite='".$_POST['iCodTramite']."'";
    $rs=sqlsrv_query($cnx,$sql);
    while ($Rs=sqlsrv_fetch_array($rs)){
        ?>
        <page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
            <page_header>
                <div class="page_header" style="width:100%; text-align: center; margin-bottom: 2rem;">
                    <br><br>
                    <img src="../dist/images/cabecera.png">
                    <p class="page_header_tag" style="font-family: Arial; font-size: 9pt;"> <?= utf8_decode('"Decenio del Diálogo y de Igualdad de Oportunidades para Mujeres y Hombres"')?>
                        <br>
                        <?= utf8_decode('"Año del Diálogo y la Reconciliación Nacional"')?> </p>

                </div>
            </page_header>
            <page_footer>
                <div class="page_footer" style="width:100%; text-align: right; padding-right: 70px;">
                    <img src="../dist/images/pie.png">
                    <br><br>
                </div>
            </page_footer>
            <div class="page_content" style="margin-top: 130px;">
                <div>
                    <?php
                    $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=".$Rs['cCodTipoDoc']."";
                    $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
                    $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
                    $tipoDoc = $RsTipDoc['cDescTipoDoc'];
                    $numDoc = $Rs['cCodificacion'];
                    ?>
                    <p><?php echo $tipoDoc.' '.$numDoc; ?></p>
                </div>
                <div class="glosa" style="width:100%; text-align: right; padding-right: 70px; padding-left: 70px;">
                    <table width="100%">
                        <tr>
                            <td>
                                A
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <?php
                                $sqlOfiD="SELECT cNomOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iCodOficina='".$Rs['iCodOficinaDerivar']."'";
                                $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
                                $RsOfiD=sqlsrv_fetch_array($rsOfiD);
                                echo $RsOfiD['cNomOficina'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                De
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <?php
                                $sqlOfi1="SELECT * FROM Tra_M_Trabajadores,Tra_M_Oficinas WHERE Tra_M_Trabajadores.iCodOficina=Tra_M_Oficinas.iCodOficina AND Tra_M_Trabajadores.iCodTrabajador='".$Rs['iCodTrabajadorRegistro']."'";
                                $rsOfi1=sqlsrv_query($cnx,$sqlOfi1);
                                $RsOfi1=sqlsrv_fetch_array($rsOfi1);
                                echo $RsOfi1['cNomOficina'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Asunto
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <?php
                                echo ''.$Rs['cAsunto'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Referencia
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <?php
                                echo ''.$Rs['cReferencia'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Fecha
                            </td>
                            <td>
                                :
                            </td>
                            <td style="text-align: left;">
                                <?php
                                setlocale(LC_ALL,"es_ES");
                                $fecha = $Rs['fFecRegistro']->format('m/d/Y');
                                echo strftime('Miraflores, %e de %B del %Y', strtotime($fecha));
                                //   echo  ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="cuerpo">
                    <?php
                    echo $Rs['cCuerpoDocumento'];
                    ?>
                </div>

            </div>
        </page>

        <?php
    }
//*************************************
    $content = ob_get_clean();  set_time_limit(0);     ini_set('memory_limit', '3540M');

// conversion HTML => PDF
    require_once(dirname(__FILE__).'/../views/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P','A4', 'es', false, 'ISO-8859-15', 3);
        //$html2pdf->setDefaultFont('arialunicid0'); //add this line
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $separa=DIRECTORY_SEPARATOR;
        $tmp = dirname(tempnam (null,''));
        $tmp = $tmp.$separa."upload";
        if (!is_dir($tmp)) {
            mkdir($tmp);
        }
        $nuevo_nombre = str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])).'-'.str_replace('/','-',$numDoc).'.pdf';
        $files = [str_replace('/','-',trim($RsSigla['cSiglaOficina'])),$nNumAno,str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])),$nNumMes,trim($RsNomUsr['cUsuario']) ];
        $html2pdf->Output($tmp.$separa.$nuevo_nombre, 'F');
        $path = $sftp->createFolder($files,$rutaUpload.'/docNoFirmados');
        $sftp->uploadFile($tmp.$separa.$nuevo_nombre, $path.'/'.$nuevo_nombre);

    }
    catch(HTML2PDF_exception $e) { echo $e; }
    $url =  str_replace('opt/stdd/files//','files/',$host.':81'.$path.'/'.$nuevo_nombre);
    $idtra = $_POST['iCodTramite'];
    $sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('".$_POST['iCodTramite']."', '', '".$url."', '2')";

    $arr = array(
        'url'=>$url,
        'tra'=>$idtra
    );
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    echo json_encode($arr);


}else{
    header("Location: ../../index-b.php?alter=5");
}

?>