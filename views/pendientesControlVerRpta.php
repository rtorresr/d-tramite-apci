<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv=Content-Type content=text/html; charset=utf-8>
	<title>SITDD</title>
	<META NAME="language" CONTENT="ES">
	<META content="1 days" name=REVISIT-AFTER>
	<META content=ES name=language>
	<META scheme=RFC1766 content=Spanish name=DC.Language>
	<meta http-equiv="content-type" content="text/html" />
	<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
	<!--<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />-->
	<SCRIPT LANGUAGE="JavaScript">
	<!-- Begin
	function sendValue (s){
	var selvalue = s.value;
	window.opener.document.getElementById('cReferencia').value = selvalue;
	window.close();
	}
	//  End -->
	</script>
</head>

<body>

		<table width="450" height="250" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
			<tr>
				<td align="left" valign="top">
					<!--<!--Main layout-->
 <main class="mx-lg-5">
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-md-12 mb-12">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">
CesarAc-->
					<div class="AreaTitulo">Detalles de Respuesta:</div>	
						<table width="400" border="0" cellpadding="2" cellspacing="3">
							<?php  
								include_once("../conexion/conexion.php");
								$idMovimiento = (int)($_GET["iCodMovimiento"]);
								// $sqlMov = "SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = '".$idMovimiento."' ";
								$sqlMov = "SELECT * FROM Tra_M_Tramite TT
													 INNER JOIN Tra_M_Tramite_Movimientos TM ON TT.iCodTramite = TM.iCodTramiteRespuesta
													 WHERE TM.iCodMovimiento = ".$idMovimiento;
								$rsMov  = sqlsrv_query($cnx,$sqlMov);
								$RsMov  = sqlsrv_fetch_array($rsMov);
							?>
							<tr>
								<td width="120" align="right" >Fecha:&nbsp;</td>
								<!-- <td align="left"><?=date("d-m-Y", strtotime($RsMov[fFecResponder]))?></td> -->
								<td align="left"><?php echo $RsMov['fFecRegistro']; ?></td>
							</tr>
							<tr>
								<td width="120" align="right" >Respondido por:&nbsp;</td>
								<td align="left">
								<?php
									// $rsDelg = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores
									// 											 WHERE iCodTrabajador='$RsMov[iCodTrabajadorResponder]'");
									$rsDelg = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores 
																				 WHERE iCodTrabajador='$RsMov['iCodTrabajadorDelegado']'");
									$RsDelg = sqlsrv_fetch_array($rsDelg);
									echo "<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>";
								?>
								</td>
							</tr>

							<tr>
								<td align="right" >Doc. de Respuesta:</td>
								<td align=left>
								<?php
									$sql = "SELECT Tra_M_Tramite.iCodTramite
															,cDescTipoDoc
															,Tra_M_Tramite.cCodificacion
															,fFecRegistro
															, cAsunto
															,Tra_M_Tramite.cObservaciones
															,Tra_M_Tramite.cCodTipoDoc 
												  FROM Tra_M_Tramite 
												  INNER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc = Tra_M_Tipo_Documento.cCodTipoDoc 
												  INNER JOIN Tra_M_Trabajadores ON Tra_M_Tramite.iCodTrabajadorRegistro=Tra_M_Trabajadores.iCodTrabajador
												  WHERE iCodTramite = '$RsMov[iCodTramiteRespuesta]' ";
									$rsRem = sqlsrv_query($cnx,$sql);
									$RsRem = sqlsrv_fetch_array($rsRem);
									// echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerDocT.php?iCodTramite=".$RsRem[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 450px; height: 240px; scrolling: auto; border:no\">".$RsRem[cCodificacion]."</a>";
									echo $RsRem[cCodificacion];
								?>
								</td>
							</tr>
							<tr>
								<td width="120" align="right" >Tipo Documento:&nbsp;</td>
								<td align=left>
								<?php
									$sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsMov[cCodTipoDoc]'";
									$rsTipDoc  = sqlsrv_query($cnx,$sqlTipDoc);
									$RsTipDoc = sqlsrv_fetch_array($rsTipDoc);
									echo $RsTipDoc['cDescTipoDoc'];
								?>
								</td>
							</tr>

							<tr>
								<td width="120" align="right" valign="top" >Asunto:&nbsp;</td>
								<td align="left"><?=$RsMov['cAsunto']?></td>
							</tr>

							<tr>
								<td width="120" align="right" valign="top" >Observaciones:&nbsp;</td>
								<td align="left"><?=$RsMov[cObservaciones]?></td>
							</tr>

							<tr>
								<td width="120" align="right" >Digital:&nbsp;</td>
								<td align="left">
								<?php
								// $sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$RsMov[iCodTramite]'";
								$sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$RsMov[iCodTramiteRespuesta]'";
									$rsDw  = sqlsrv_query($cnx,$sqlDw);
									if (sqlsrv_has_rows($rsDw) > 0){
										$RsDw = sqlsrv_fetch_array($rsDw);
										if($RsDw["cNombreNuevo"] != ""){
											if (file_exists("../cAlmacenArchivos/".trim($RsDw["cNombreNuevo"]))){
												echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
											}
										}
									}else{
										echo "<img src=images/space.gif width=16 height=16 border=0>";
									}
								?>
								</td>
							</tr>
						</table>
					<div>
				</td>
			</tr>
		</table>

</body>
</html>
<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>