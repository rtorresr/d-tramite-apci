<?php
  include("clasesCorreo/class.phpmailer.php");
	include("clasesCorreo/class.smtp.php");

	$cuerpo = 'Mensaje html para el correo que se enviara';
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = "ssl"; 
	$mail->Host = "smtp.gmail.com"; 
	$mail->Port = 465; 
	$mail->Username = "pruebadesarrollo11@gmail.com"; 
	$mail->Password = "developer111"; 

	$mail->From = "pruebadesarrollo11@gmail.com";
	$mail->FromName = "Usuario";
	$mail->Subject = "Reporte de Pendientes"; 
	$mail->AltBody = "Hola"; 
	$mail->MsgHTML($cuerpo); 
	$mail->AddAddress("informaticachristiangarcia@gmail.com", "Destinatario"); 
	$mail->IsHTML(true);

	if (!$mail->Send()){ 
		echo "ERROR: " . $mail->ErrorInfo; 
	}else{ 
		echo "Mensaje enviado correctamente";
	} 
	// include_once("../conexion/conexion.php");

	// $codigoTramite = $_GET['iCodTramite'];
	// $sqlTramite = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite = ".$codigoTramite;
	// $rsTramite  = sqlsrv_query($cnx,$sqlTramite);
	// $RsTramite  = sqlsrv_fetch_object($rsTramite);
	
	// $codigoJefe = $_GET['iCodTrabajadorJefe'];
	// $sqlJefe    = "SELECT cNombresTrabajador, cApellidosTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$codigoJefe;
	// $rsJefe     = sqlsrv_query($cnx,$sqlJefe);
	// $RsJefe     = sqlsrv_fetch_object($rsJefe);

?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Tr&aacute;mite pendiente de aprobaci&oacute;n</h1>
	<p>
		<?php
			$dirigido = "Sr(a). ".trim($RsJefe->cApellidosTrabajador)." ".trim($RsJefe->cNombresTrabajador). "Usted tiene el siguiente or aprobar";
			echo $dirigido;
		?>
	</p>
	<table border="1">
		<tr>
			<th>Categor&iacute;a</th>
			<th>Tipo</th>
			<th>C&oacute;digo</th>
			<th>Asunto</th>
			<th>Observaciones</th>
			<th>Sigla autor</th>
			<th>Fecha registro</th>
			<th>Acci&oacute;n</th>
		</tr>
		<tbody>
			<tr>
				<td align="center">
					<?php 
						if ($RsTramite->nFlgTipoDoc == 2) {
							$categoria = "Doc. Interno Oficina";
						}else{
							$categoria = "Doc. de Salida Oficina";
						}
						echo $categoria;
					?>
				</td>
				<td align="center">
					<?php
						$sqlTipoDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc = ".$RsTramite->cCodTipoDoc;
						$rsTipoDoc  = sqlsrv_query($cnx,$sqlTipoDoc);
						$RsTipoDoc  = sqlsrv_fetch_object($rsTipoDoc);
						echo $RsTipoDoc->cDescTipoDoc;
					?>
				</td>
				<td align="center">
					<?php 
						if ($RsTramite->nFlgTipoDoc == 2) {
							echo $RsTramite->cCodificacionI;
						}else{
							echo "Pendiente";
						}
					?>
				</td>
				<td align="center">
					<?php 
						echo $RsTramite->cAsunto;
					?>
				</td>
				<td align="center">
					<?php 
						echo $RsTramite->cObservaciones;
					?>
				</td>
				<td align="center">
					<?php 
						echo $RsTramite->cSiglaAutor;	
					?>
				</td>
				<td align="center">
					<?php
						echo $RsTramite->fFecRegistro;
					?>
				</td>
				<td align="center">
					<a href="">Aprobar</a>
				</td>
			</tr>
		</tbody>
	</table>
	
</body>
</html>

<?php 
/*
destinatario
Asunto
link al documento 
*/
?> -->