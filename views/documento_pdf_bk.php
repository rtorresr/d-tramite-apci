<?php
/**
 * Created by PhpStorm.
 * User: dcamarena
 * Date: 6/11/2018
 * Time: 5:27 PM
 */
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
//ob_start();
$idt = ($RsUltTra?$RsUltTra['iCodTramite']:$_REQUEST['iCodTramite']);
//$idt = $_REQUEST['iCodTramite'];

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

$sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sql.=" WHERE Tra_M_Tramite.iCodTramite='".$idt."'";
$rs=sqlsrv_query($cnx,$sql);
while ($Rs=sqlsrv_fetch_array($rs)){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Documento_PDF</title>
        <style>
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

            /*.glosa,*/
            .cuerpo {
                width:400px;
                padding-bottom: 0px;
                /*  padding-right: 40px;*/
                padding-left: 40px;
            }

            .glosa {
                width:100%;
                padding-bottom: 0px;
                padding-right: 40px;
                padding-left: 40px;
            }

        </style>
    </head>
    <body>


    <?php
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
    $words = array('Y', 'De');
    $regex = '/\b(' . implode( '|', $words) . ')\b/i';
    $formatted_tag = preg_replace_callback( $regex, function( $matches) {
        return strtolower( $matches[1]);
    }, ucwords(mb_strtolower(trim($siglaoficina['oficina']))));
    $oooo = sliceString($formatted_tag,2);

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
    <!-- cabecera -->
    <div id="header">
        <?php
        if ($param['head'] === 'title'){
            include ('template/head.php');
        }else{
            echo "sello de agua";
        }
        ?>

    </div>
    <!-- Fin de cabecera -->

    <div class="page_content" style="padding-top: 180px;">
        <?php
        $nomenclaturaCentro= '<div><h1>'.$tipoDoc.' '.$numDoc.'</h1><br></div>';
        $destinatario = '<tr><td class="item">A </td> <td class="dots"> : </td> <td class="desc">'.$destino.'</td></tr>';
        $tablai = '<div class="glosa"> <table width="100%">';
        $separador = '<tr><td colspan="3" style="height:5px"></td> </tr>';
        $remitente = '<tr> <td class="item"> De </td> <td> : </td> <td class="desc">'.$remite.' </td> </tr>';
        $asunto = '<tr> <td class="item"> Asunto </td> <td> : </td><td class="desc">'.sliceString($Rs['cAsunto'],8).'</td></tr>';
        $referencia = '<tr> <td class="item">Referencia </td><td>:</td><td class="desc">'.((trim($Rs['cReferencia']) === 'NULL')?'-':$Rs['cReferencia']).'</td></tr>';
        $fecha='<tr><td class="item"> Fecha </td><td>:</td><td  class="desc">'.strftime('Miraflores, %e de %B del %Y', strtotime($fecha)).' </td> </tr>';
        $tablaf = '</table><hr /></div>';
        $hr = '<br><hr />';

        $descripcionCuenpo = $Rs['descripcion'].$Rs['cCuerpoDocumento'];
        //check($clean);
        $cuerpo = '<div class="cuerpo" >'.$descripcionCuenpo.'</div>';

        foreach ($param['body'] as $pp){
            eval ('echo $'.$pp.';');
        }
        ?>
    </div>

    <div id="footer">
        <div class="page-number"></div>
        <div class="page_footer" >
            <img src="../dist/images/pie.png">
            <br><br>
        </div>
    </div>

    </body>
    </html>
    <?php
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//$content = ob_get_clean();  set_time_limit(0);     ini_set('memory_limit', '3540M');

// conversion HTML => PDF
/*require_once($path.'/../views/html2pdf/html2pdf.class.php');

    $html2pdf = new HTML2PDF('P','A4', 'es', true, 'UTF-8');
    //$html2pdf->setDefaultFont('arialunicid0'); //add this line
    $html2pdf->pdf->SetDisplayMode('real','single');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $separa=DIRECTORY_SEPARATOR;
    $tmp = dirname(tempnam (null,''));
    $tmp = $tmp.$separa."upload";

    if ( !is_dir($tmp)) {
        mkdir($tmp);
    }
    $url_f = 'docNoFirmados/'.$nomenclatura.'/';

    $_POST['path'] = $url_f;
    $_POST['name'] = 'fileUpLoadDigital';
    $nuevo_nombre = str_replace(' ','-',trim($RsTipDoc['cDescTipoDoc'])).'-'.str_replace('/','-',$cCodificacion).'.pdf';

    $html2pdf->Output($tmp.$separa.$nuevo_nombre, 'T');

   /* $_FILES['fileUpLoadDigital']['tmp_name'] = $tmp.$separa.$nuevo_nombre;
    $_FILES['fileUpLoadDigital']['name'] = $nuevo_nombre;
    $_FILES['fileUpLoadDigital']['type'] = 'PDF';
    $_POST['new_name'] = $nuevo_nombre;
    $curl->uploadFile($_FILES, $_POST);
    //$sftp->uploadFile($_FILES['fileUpLoadDigital']['tmp_name'][0], $path.'/'.$nuevo_nombre);
    //$url =  str_replace('opt/stdd/files//','files/',$host.':'.$port_ngnix.$path.'/'.$nuevo_nombre);
    $url  = $url_srv.$url_f.$nuevo_nombre;
    $curl->closeCurl();*/


?>

