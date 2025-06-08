<?php session_start();
ini_set('date.timezone', 'America/Lima');
ob_start();
//*************************************
include_once("../conexion/conexion.php");
	//sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET descripcion='".str_replace( '\"', '"', $_GET[descripcion])."' WHERE iCodTramite='$_GET[iCodTramite]'");
  $tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$_GET['iCodTramite']."'");
  $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);

  $rsJefe = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTramitePDF->iCodTrabajadorRegistro'");
  $RsJefe = sqlsrv_fetch_array($rsJefe);
  if (!empty($RsJefe['firma'])) { 
  	$img = base64_encode($RsJefe['firma']); 
    $imgd='<img src="data:image/png;charset=utf8;base64,'.$img.'"/>';
	}else{
		$imgd='';
	}
	          
  $sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTramitePDF->cCodTipoDoc'";
	$rsTipDoc  = sqlsrv_query($cnx,$sqlTipDoc);
	$RsTipDoc  = sqlsrv_fetch_array($rsTipDoc);

  $sqlM1 = "SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos 
  					WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
  $rsM1  = sqlsrv_query($cnx,$sqlM1);

  if(sqlsrv_has_rows($rsM1)>0){
  	$RsM1     = sqlsrv_fetch_object($rsM1);
  	$movFecha = date("d-m-Y h:i:s", strtotime($RsM1->fFecDerivar));
  }else{
  	$movFecha = '';
  }

  $sqlOfDerivar = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM1->iCodOficinaDerivar'";
  $rsOfDerivar  = sqlsrv_query($cnx,$sqlOfDerivar);
  $RsOfDerivar  = sqlsrv_fetch_object($rsOfDerivar);

  //set it to writable location, a place for temp generated PNG files
  $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode\temp'.DIRECTORY_SEPARATOR;

  //html PNG location prefix
  $PNG_WEB_DIR = 'phpqrcode/temp/';
    
  include "phpqrcode/qrlib.php";    
  
  //ofcourse we need rights to create temp dir
  if (!file_exists('c:/STD_DOCUMENTO'))
	mkdir('c:/STD_DOCUMENTO', 0777, true);

  if (!file_exists($PNG_TEMP_DIR))
      mkdir($PNG_TEMP_DIR);

  //$filename = $PNG_TEMP_DIR.'test.png';

  $errorCorrectionLevel = 'L';   
  $matrixPointSize = 2;
  //$_REQUEST['data']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 

  // Falla < ----------------------------------
  $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/pro/views/pdf_digital.php?iCodTramite='.$RsTramitePDF->iCodTramite;
    
  //echo $_REQUEST['data'];
  // user data
  $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
  $filename = $PNG_TEMP_DIR.$codigoQr;
    
  //echo $codigoQr;
   
  QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	$img_logo= "<img style='width:300px' src='images/1.png' alt='Logo'>";
	$img_final="<img src=".$PNG_WEB_DIR.basename($filename)." />";

$query = "SELECT TOP 1 *,
(select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodOficinaOrigen) as institucion,
(select cNomRemite from Tra_M_Tramite where iCodTramite=m.iCodTramite) as destinatario,
(select cNomOficina from [dbo].[Tra_M_Oficinas] where iCodOficina=m.iCodOficinaDerivar) as paraOficina,
(select (RTRIM(cNombresTrabajador)+ ', ' +RTRIM(cApellidosTrabajador)) as cNombresTrabajador from [dbo].[Tra_M_Trabajadores] where iCodTrabajador=m.iCodTrabajadorDerivar) as para,
(select cNomOficina from [dbo].[Tra_M_Oficinas] where iCodOficina=m.iCodOficinaOrigen) as deOficina,
(select (RTRIM(cNombresTrabajador)+ ', ' +RTRIM(cApellidosTrabajador)) as cNombresTrabajador from [dbo].[Tra_M_Trabajadores] where iCodTrabajador=m.iCodTrabajadorRegistro) as de
FROM Tra_M_Tramite_Movimientos m
WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 
ORDER BY iCodMovimiento ASC";

$rs = sqlsrv_query($cnx,$query);

$y = sqlsrv_fetch_array($rs);
$codigoTramite = $y['iCodTramite'];

$sqlFlgTipoDerivo = "SELECT nFlgTipoDerivo FROM Tra_M_Tramite WHERE iCodTramite = ".$codigoTramite;

$rsFlgTipoDerivo = sqlsrv_query($cnx,$sqlFlgTipoDerivo);
$RsFlgTipoDerivo = sqlsrv_fetch_array($rsFlgTipoDerivo);
// Si nFlgTipoDerivo es 1, entonces el documento proviene de una derivación.
// Si nFlgTipoDerivo no es 1 (NULL), entonces el documento proviene de un registro de documento interno.
if ($RsFlgTipoDerivo['nFlgTipoDerivo'] == 1) {
	$rs = sqlsrv_query($cnx,$query);
	while ($x = sqlsrv_fetch_array($rs)){
    $instituto      =   $x['institucion'];
    $destinatario   =   $x['destinatario'];
    $para           =   $x['para'];
    $paraoficina    =   $x['paraOficina'];
    $de             =   $x['de'];
    $deoficina      =   $x['deOficina'];
    $codigoTramite	= 	$x['iCodTramite'];
	}

	$ofiRegistro = "SELECT iCodOficinaRegistro FROM Tra_M_Tramite WHERE iCodTramite = ".$codigoTramite;
	$rsRegistro  = sqlsrv_query($cnx,$ofiRegistro);
	$RsRegistro  = sqlsrv_fetch_array($rsRegistro);

	$sqlTrb = "SELECT * FROM Tra_M_Perfil_Ususario TPU
					 	 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
					 	 WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '$RsRegistro[iCodOficinaRegistro]'";
	$rsTrb  = sqlsrv_query($cnx,$sqlTrb);
	$RsTrb  = sqlsrv_fetch_array($rsTrb);

	$de = RTRIM($RsTrb['cNombresTrabajador']).", ".RTRIM($RsTrb['cApellidosTrabajador']);

  $sqlFecDoc = "SELECT fFecDocumento FROM Tra_M_Tramite WHERE iCodTramite = ".$codigoTramite;
  $rssqlFecDoc = sqlsrv_query($cnx,$sqlFecDoc);
  $RssqlFecDoc = sqlsrv_fetch_array($rssqlFecDoc);
  $movFecha = $RssqlFecDoc['fFecDocumento'];
	
 //  $getdate = "SELECT getdate() AS 'HOY'";
	// $rsGetDate = sqlsrv_query($cnx,$getdate);
	// $RsGetDate = sqlsrv_fetch_array($rsGetDate);
	// $movFecha = $RsGetDate['HOY'];

}else{
	$rs = sqlsrv_query($cnx,$query);
	while ($x = sqlsrv_fetch_array($rs)){
    $instituto      =   $x['institucion'];
    $destinatario   =   $x['destinatario'];
    $para           =   $x['para'];
    $paraoficina    =   $x['paraOficina'];
    $de             =   $x['de'];
    $deoficina      =   $x['deOficina'];
    $codigoTramite	= 	$x['iCodTramite'];
	}
	$sqlAprobar = "SELECT iCodJefe, cNomJefe, FECHA_DOCUMENTO FROM Tra_M_Tramite WHERE iCodTramite = ".$codigoTramite;
	$rsAprobar  = sqlsrv_query($cnx,$sqlAprobar);
	$RsAprobar  = sqlsrv_fetch_object($rsAprobar);
	$de         = $RsAprobar->cNomJefe;
	$movFecha		= $RsAprobar->FECHA_DOCUMENTO;
}  
	/*------------------------------------------------------------------------------*/

    $content='
        <page pageset="new" backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" footer="page">
            <page_header><!-- Cabecera de pagina --> </page_header>
            

                        <table style="width:100%; border: none; font-family:arial;font-size:12px;">
                        <tr>
                            <td colspan="2">'.$img_logo.'</td>
                            <td colspan="2" align="right">'.trim($RsTipDoc['cDescTipoDoc']).utf8_decode(" N° ").$RsTramitePDF->cCodificacion.'</td>
                        </tr>
                        
                        <tr><td colspan="4"><br></td></tr>
                        
					        <tr>
					          <td style="width:20%">Para</td><td style="width:80%">: '.$para.'</td>
					        </tr>
					        <tr>
					          <td style="width:20%">Oficina</td>
					          <td style="width:80%">: '.$paraoficina.'</td>
					        </tr>
                            <tr><td colspan=2><br></td></tr>
					        <tr>
					          <td style="width:20%">De</td><td style="width:80%">: '.$de.'</td>
					        </tr>
					        <tr>
					          <td style="width:20%">Oficina</td>
					          <td style="width:80%">: '.$deoficina.'</td>
					        </tr>
                            <tr><td colspan=2><br></td></tr>
					        <tr>
					          <td style="width:20%">Fecha</td>
					          <td style="width:80%">: '.$movFecha.'</td>
					        </tr>

					        <tr>
					          <td style="width:20%">Asunto</td>
					          <td style="width:80%">: '.$RsTramitePDF->cAsunto.'</td>
					        </tr>
                            <tr><td colspan=2><br></td></tr>
					                      
					      </table>
            
    ';
    $num1=1;
        for($xx=0;$xx<=500;$xx++){
            $sql= "select SUBSTRING(descripcion,$num1,250) as descripcion from Tra_M_Tramite where iCodTramite='$_GET[iCodTramite]'";
            $query=sqlsrv_query($cnx,$sql);
            
            while ($fila = sqlsrv_fetch_array($query)) {
                 $content.=rtrim(ltrim($fila[descripcion]));
            }
            $num1+=250;
        
        }
    
    $content.='
        <br><br><br><br><br>
        <div style="align:right;">
        <table style="width:200%; border: none; font-family:arial;font-size:12px;" align="right">
        <tr><td align="center">
            '.$imgdx.'
            <hr>
            Firma
            <br>
            '.$de.'
            <br>
            <font size=10px>Con el usuario y clave se da validez al documento emitido.</font>
         
        </div>
        
            <page_footer>
                <!--- Pie de pagina -->
            </page_footer>
        </page>
    ';

    echo $content;

	/*------------------------------------------------------------------------------*/

	$content = ob_get_clean();  set_time_limit(0);     ini_set('memory_limit', '640M');
    
	// conversion HTML => PDF
  $nombre = trim($RsTipDoc['cDescTipoDoc']).utf8_decode(" N° ").$RsTramitePDF->cCodificacion.rand(10,99).".pdf";
	require_once(dirname(__FILE__) . '/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4', 'es', false, 'UTF-8', 3);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($nombre);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>