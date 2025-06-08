<?php 
session_start();
include_once("../conexion/conexion.php");
print_r($_REQUEST); exit();
//****DOCUMENTO ELECTRONICO PDF GENERADO
  // 	if($_FILES['documentoElectronicoPDF']['name']!=""){
  // 		$extension = explode(".",$_FILES['documentoElectronicoPDF']['name']);
  // 		$num = count($extension)-1;
  // 		$cNombreOriginal=$_FILES['documentoElectronicoPDF']['name'];
		// if($extension[$num]=="exe" OR $extension[$num]=="dll" OR $extension[$num]=="EXE" OR $extension[$num]=="DLL"){
		// 	$nFlgRestricUp=1;
  //  		}else{
		// 	//$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
		// 	$PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'documentos'.DIRECTORY_SEPARATOR;
		// 	move_uploaded_file($_FILES['documentoElectronicoPDF']['tmp_name'], "$PDF_DIR"."prueba111.pdf");
						
		// 	// $sqlDigt="INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) VALUES ('$RsUltTra[iCodTramite]', '$cNombreOriginal', '$nuevo_nombre')";
  //  // 			$rsDigt=sqlsrv_query($cnx,$sqlDigt);
  //  		}
  // 	}

sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET descripcion='".str_replace( '\"', '"', $_POST[descripcion])."' WHERE iCodTramite='$_POST[iCodTramite]'");

$tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'");
$RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
if ($RsTramitePDF->descripcion != ' ' AND $RsTramitePDF->descripcion != NULL){
	$rsJefe = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTramitePDF->iCodTrabajadorRegistro'");
	$RsJefe = sqlsrv_fetch_array($rsJefe);

	if (!empty($RsJefe['firma'])) { 
		$img=base64_encode($RsJefe['firma']); 
		$imgd='<img src="data:image/png;charset=utf8;base64,'.$img.'"/>';
	}else{
		$imgd = '';
	}

	$sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTramitePDF->cCodTipoDoc'";
	$rsTipDoc  = sqlsrv_query($cnx,$sqlTipDoc);
	$RsTipDoc  = sqlsrv_fetch_array($rsTipDoc);

	$sqlM1 = "SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos 
					  WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
	$rsM1  = sqlsrv_query($cnx,$sqlM1);
	
	if  (sqlsrv_has_rows($rsM1) > 0){
		$RsM1     = sqlsrv_fetch_object($rsM1);
		$movFecha = date("d-m-Y h:i:s", strtotime($RsM1->fFecDerivar));
	}else{
		$movFecha = '';
	}

	$sqlOfDerivar = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM1->iCodOficinaDerivar'";
	$rsOfDerivar  = sqlsrv_query($cnx,$sqlOfDerivar);
	$RsOfDerivar  = sqlsrv_fetch_object($rsOfDerivar);

  //set it to writable location, a place for temp generated PNG files
  $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode/temp'.DIRECTORY_SEPARATOR;
  
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
   $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/Sistema_Tramite_PCM/views/registroInternoDocumento_pdf.php?iCodTramite='.$RsTramitePDF->iCodTramite;

  // user data
  $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
  $filename = $PNG_TEMP_DIR.$codigoQr;
   
  QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	$content='<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" format="A4"> 
				      <page_header> 
				           <div style=" padding-top: 20px; padding-left: 40px; "><img style="width:300px" src="images/logo-ongei.png" alt="Logo"></div>
				      </page_header> 
				      <page_footer> 
				           
				      </page_footer> 

				      <br><br><br>
				      <div style=" text-align: right; ">'.trim($RsTipDoc['cDescTipoDoc']).utf8_decode(" N° ").$RsTramitePDF->cCodificacion.'</div>
				      <br>

				      <table style="width:650px; border: none; font-family:Times;font-size:13.5px;"> <!-- 595px -->
				        <tr>
				          <td style="width:20%">A</td><td style="width:80%">: '.$RsOfDerivar->cSiglaOficina.'</td>
				        </tr>
				        <tr>
				          <td style="width:20%">De</td>
				          <td style="width:80%">: '.$RsJefe["cNombresTrabajador"].' '.$RsJefe["cApellidosTrabajador"].'</td>
				        </tr>
				        <tr>
				          <td style="width:20%">Referencia</td><td style="width:80%"><b>: '.$RsTramitePDF->cReferencia.'</b></td>
				        </tr>

				        <tr>
				          <td style="width:20%">Fecha/H Derivo</td>
				          <td style="width:80%">: '.$movFecha.'</td>
				        </tr>

				        <tr>
				          <td style="width:20%">Asunto</td>
				          <td style="width:80%">: '.$RsTramitePDF->cAsunto.'</td>
				        </tr>
				                      
				      </table>
				      
				      <br><br>
				      <div style="font-family:Times;font-size:13.5px">'.$RsTramitePDF->descripcion.'</div>

				      <div align="right" style=" width: 100%;">
				        <br><br><br><br><br>
				        <div style="width: 30%; text-align: center; ">'.$imgd.'<p>Firma</p>
				        <p>'.$RsJefe["cNombresTrabajador"].' '.$RsJefe["cApellidosTrabajador"].'</p></div>
				      </div>
				      <div><img src="'.$PNG_WEB_DIR.basename($filename).'" />
				      <p style="font-size: 9px">'.$_REQUEST['data'].'</p>
				      </div>
					 </page>';

// ********************	START Ruta del documento electronico  **************************************************************
date_default_timezone_set("America/Lima");
$PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'documentos'.DIRECTORY_SEPARATOR;
$PDF_DIR1="c:/STD_DOCUMENTO/";
$docElectronico = str_replace(' ','_', trim($RsTipDoc['cDescTipoDoc'])).'_'.trim(str_replace('/','', str_replace('. ','', $RsTramitePDF->cCodificacion))).'_'.date("YmdHis").".pdf";
$nombreArchivo=$PDF_DIR.$docElectronico;
$nombreArchivo1=$PDF_DIR1.$docElectronico;
// ********************	END Ruta del documento electronico  **************************************************************
sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET codigoQr='$codigoQr' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");
sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET documentoElectronico='$docElectronico' WHERE iCodTramite='$RsTramitePDF->iCodTramite'");

require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4', 'es', false, 'UTF-8', array(mL, mT, mR, mB));
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($nombreArchivo, 'F');
		$html2pdf->Output($nombreArchivo1, 'F');	
	}catch(HTML2PDF_exception $e) {
		echo "erorrr".$e; 
	}
}
//****DOCUMENTO ELECTRONICO PDF GENERADO
echo json_encode(array('documentoElectronicoPDF' => $nombreArchivo1,'iCodTramite' => $RsTramitePDF->iCodTramite));
?>