<?
session_start();
include_once("../conexion/conexion.php");
function obtend_dias_trasnc($ano1,$mes1,$dia1,$ano2,$mes2,$dia2){
		$Date1=mktime(0,0,0,$mes1,$dia1,$ano1); 
		$Date2=mktime(4,12,0,$mes2,$dia2,$ano2); 
		$segundos_diferencia = $Date2-$Date1; 
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
		$dias_diferencia = abs($dias_diferencia); 
		$dias_diferencia = floor($dias_diferencia); 
		return ($dias_diferencia);
}

$sqlVCTupa="SELECT * FROM Tra_M_Tramite ";
$sqlVCTupa.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
																						//AND Tra_M_Tramite_Movimientos.fFecRecepcion IS NOT NULL 
$sqlVCTupa.="WHERE Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 AND (Tra_M_Tramite.nFlgEstado=1 OR Tra_M_Tramite.nFlgEstado=2)";
$rsVCTupa=sqlsrv_query($cnx,$sqlVCTupa);
echo "<table border=1 cellpadding=2 style=font-family:arial;font-size:12px>";
while ($RsVCTupa=sqlsrv_fetch_array($rsVCTupa)){
			$difDiasCnTupa=obtend_dias_trasnc(date("Y"),date("n"),date("j"),date("Y", strtotime($RsVCTupa['fFecDocumento'])),date("n", strtotime($RsVCTupa['fFecDocumento'])),date("j", strtotime($RsVCTupa['fFecDocumento'])));
			
			if((($RsVCTupa[nTiempoRespuesta]-$difDiasCnTupa)==0) OR (($RsVCTupa[nTiempoRespuesta]-$difDiasCnTupa)==2)){
						$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsVCTupa[iCodTrabajadorDerivar]'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	
          	$correoEnviar=trim($RsDelg[cMailTrabajador]);
						$nombreEnviar=trim($RsDelg[cNombresTrabajador]).' '.trim($RsDelg[cApellidosTrabajador]);
          	
          	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsVCTupa[cCodTipoDoc]'";
			      $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			      $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
						
						/*
						echo "<tr>
						<td>iCodTra: ".$RsVCTupa[iCodTramite]."</td>
						<td>iCodMov: ".$RsVCTupa[iCodMovimiento]."</td> 
						<td>Codifi: ".$RsVCTupa[cCodificacion]."</td>
						<td>Transcurridos: ".$difDiasCnTupa."</td>
						<td>Tiempo rpta: ".$RsVCTupa[nTiempoRespuesta]."</td>
						<td>Diferencia: ".($RsVCTupa[nTiempoRespuesta]-$difDiasCnTupa)."</td>
						<td>".$nombreEnviar."</td>
						<td>".$correoEnviar."</td>
						</tr>";
						*/
						
						$time = date("l F dS Y h:i:s A"); 
      	 		$mensajeH ='<html>';
						$mensajeH.='<head>';
						$mensajeH.='<title>Notificaci�n del Sistema de Informaci�n de Tr�mite DOCUMENTARIO DIGITAL</title>';
						$mensajeH.='</head>';
						$mensajeH.='<body style=font-family:arial;font-size:12>';
						$mensajeH.='<table width=600><tr><td>';
						$mensajeH.='<h3>Estimado(a) '.$nombreEnviar.'!</h3>';
						if(($RsVCTupa[nTiempoRespuesta]-$difDiasCnTupa)==2){
							$mensajeH.='Ha recibido una notificaci�n generada automaticamente, indicando que el Documento tiene <b>2 d�as por vencer</b>:<br><br>';
						}
						if(($RsVCTupa[nTiempoRespuesta]-$difDiasCnTupa)==0){
							$mensajeH.='Ha recibido una notificaci�n generada automaticamente, indicando que el Documento <b>vence el d�a de hoy</b></b>:<br><br>';
						}
						$mensajeH.='<table>';
						$mensajeH.='<tr><td align=right>Tr�mite N&ordm; :&nbsp;</td><td><b>'.$RsVCTupa[cCodificacion].'</b></td></tr>';
						$mensajeH.='<tr><td align=right>Tipo Documento:&nbsp;</td><td><b>'.$RsTipDoc['cDescTipoDoc'].'</b></td></tr>';
						$mensajeH.='<tr><td valign=top align=right>Asunto:&nbsp;</td><td><b>'.$RsVCTupa['cAsunto'].'</b></td></tr>';
						$mensajeH.='</table><br><br>';
						$mensajeH.='Favor de ingresar al <a>Sistema de Informaci�n de Tramite DOCUMENTARIO DIGITAL</a> ingresando su usuario y password para revisar su contenido.<br><br>';
						$mensajeH.='- - - - - - - - - - - - - - - - - -<br>';
						$mensajeH.='PCM - SITD';
						$mensajeH.='</p>';
						$mensajeH.='<hr/><font style=font-size:10px>Fecha : '.$time.'<br>';
						$mensajeH.='Mensaje enviado desde: '.$_SERVER[REMOTE_ADDR];
						$mensajeH.=' ';
						$mensajeH.='</body>';
						$mensajeH.='</html>';
						
						
						
						If($correoEnviar!=""){
      					define('DISPLAY_XPM4_ERRORS', true);
								require_once 'smtp/mail.php';
								$m = new MAIL;
								$m->From('tramiteDOCUMENTARIO DIGITAL@pcm.gob.pe', 'PCM - SITD');
								$m->AddTo($correoEnviar, $nombreEnviar);
								//$m->AddTo('cmacazana@gmail.com', 'APCI');
								$m->Subject('Notificacion SITD');
								$m->Html = array(
													'content'  => $mensajeH,
													'charset'  => 'UFT-8',
													'encoding' => 'base64'
													);
								$c = $m->Connect('192.168.145.10', 25, 'tramiteDOCUMENTARIO DIGITAL', 'tramite23') or die(print_r($m->Result));
								$m->Send($c);
								$m->Disconnect();
								echo "<div>enviado</div>";
      			}
      			
			}
}
?>
</table>
