<?php  header('Content-Type: text/html; charset=UTF-8');
session_start();
$pageTitle = "Documentos por aprobar";
$activeItem = "documentosPorAprobar.php";
$navExtended = true;
date_default_timezone_set('America/Lima');
if($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
include("secure_string.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>

</head>
<body class="theme-default has-fixed-sidenav">

<?php include("includes/menu.php");?>

<!--Main layout-->
<main class="mx-lg-5">
    <div class="container-fluid">
        <!--Grid row-->
        <div class="row wow fadeIn">
            <!--Grid column-->
            <div class="col-md-12 mb-12">
                <!--Card-->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header text-center ">Consulta >> Doc. Por Aprobar</div>
                    <!--Card content-->
                    <div class="card-body">
        				<fieldset><legend>Criterios de B&uacute;squeda:</legend>
						<form name="frmConsultaEntrada" method="GET" action="consultaInternoOficina.php">
						<tr>
							<td width="110" >N&ordm; Documento:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
							<td width="110" >Desde:</td>
							<td align="left">

									<td>
                            <?php
                                $dia  = date('d');
                                $mes  = date('m');
                                $anio = date('Y');
                                $fechaInicio = "01"."-".$mes."-".$anio;
                                $fechaFin = $dia."-".$mes."-".$anio;

                                    // if(trim($_REQUEST[fHasta])==""){$fecfin = $_REQUEST[fHasta];}  else { $fecfin = $_REQUEST[fHasta]; }
                                    // if(trim($_REQUEST[fDesde])==""){$fecini = $_REQUEST[fDesde];} else { $fecini = $_REQUEST[fDesde]; }

                                    if(trim($_REQUEST[fHasta])==""){$fecfin = $fechaFin;}  else { $fecfin = $_REQUEST[fHasta]; }
                                    if(trim($_REQUEST[fDesde])==""){$fecini = $fechaInicio;} else { $fecini = $_REQUEST[fDesde]; }

                                ?>
                                    <input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>
							</td>
						</tr>
						<tr>
							<td width="110" >Tipo Documento:</td>
							<td width="390" align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 And cCodTipoDoc!=45  ";
          				            $sqlTipo.="ORDER BY cDescTipoDoc ASC";
          				            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          				while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          					if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
          						$selecTipo="selected";
          					}Else{
          						$selecTipo="";
          					}
          				echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          				}
          				sqlsrv_free_stmt($rsTipo);
									?>
									</select></td>
							<td width="110" >Asunto:</td>
							<td align="left"><input type="txt" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="65" class="FormPropertReg form-control">
							</td>
						</tr>
						<tr>
              <td width="110" >         </td>
							<td width="390" align="left">
						      <!-- SI<input type="checkbox" name="SI" value="1" <?php if($_GET[SI]==1) echo "checked"?> />
							   &nbsp;&nbsp;&nbsp;
	                NO<input type="checkbox" name="NO" value="1" <?php if($_GET[NO]==1) echo "checked"?> /> -->
              </td>
							<td width="110" >Observaciones:</td>
							<td align="left" class="CellFormRegOnly">
								<input type="txt" name="cObservaciones" value="<?=$_GET[cObservaciones]?>" size="65" class="FormPropertReg form-control">
							</td>
						</tr>
						<tr>
							<td height="10" ></td>
              <td height="10"></td>
              <td height="10" >Oficina Destino:</td>
              <td height="10">
              	<select name="iCodOficina" class="FormPropertReg form-control" style="width:360px" />
     	            <option value="">Seleccione:</option>
	              		<?php 
	                 		$sqlOfi = "SP_OFICINA_LISTA_COMBO "; 
                      $rsOfi  = sqlsrv_query($cnx,$sqlOfi);
	                 		while ($RsOfi = sqlsrv_fetch_array($rsOfi)){
	  	             			if ($RsOfi["iCodOficina"] == $_GET['iCodOficina']){
													$selecClas = "selected";
          	         		}else{
          		      			$selecClas = "";
                     		}
                   	 		echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?>
                </select>
              </td>
						</tr>
						<tr>
                         
							<!-- <td colspan="2" align="left">
              	<table width="400" border="0" align="left">
                	<tr>
                  	<td align="left">
                              Descargar &nbsp; <img src="images/icon_download.png" width="16" height="16" border="0" > &nbsp; &nbsp;
	                          | &nbsp; &nbsp;  Editar &nbsp; <i class="fas fa-edit"></i>&nbsp;&nbsp;&nbsp; Hoja de Tr&aacute;mite &nbsp;<img src="images/icon_print.png" width="16" height="16" border="0">
	                  </td>
                  </tr>
                </table>
              </td> -->
                          <td colspan="2" align="right">
											<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">
												<table cellspacing="0" cellpadding="0">
													<tr>
														<td style=" font-size:10px"><b>Buscar</b>&nbsp;&nbsp;</td>
														<td>
															<img src="images/icon_buscar.png" width="17" height="17" border="0">
														</td>
													</tr>
												</table>
											</button>
							&nbsp;
              <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
                             &nbsp;
                             <?php // ordenamiento
                                if($_GET['campo']==""){ $campo="Fecha"; }Else{ $campo=$_GET['campo']; }
								if($_GET['orden']==""){ $orden="DESC"; }Else{ $orden=$_GET['orden']; }?>
							<button class="btn btn-primary" onclick="window.open('consultaInternoOficina_xls.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&cObservaciones=<?=$_GET[cObservaciones]?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&session=<?=$_SESSION['iCodOficinaLogin']?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&Jefe=<?=$_SESSION['JEFE']?>&iCodOficina=<?=$_GET['iCodOficina']?>&campo=<?=$campo?>&orden=<?=$orden?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<!-- <button class="btn btn-primary" onclick="window.open('consultaInternoOficina_pdf.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&cObservaciones=<?=$_GET[cObservaciones]?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&campo=<?=$campo?>&orden=<?=$orden?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button> -->
							
							</td>
						</tr>
							</form>
                        </fieldset>


                        <?php
                        function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                        $total_paginas = ceil($total/$por_pagina);
                        $anterior = $actual - 1;
                        $posterior = $actual + 1;
                        $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
                        $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
                        if ($actual>1)
                        $texto = "<a href=\"$enlace$anterior\">«</a> ";
                        else
                        $texto = "<b><<</b> ";
                        if ($minimo!=1) $texto.= "... ";
                        for ($i=$minimo; $i<$actual; $i++)
                        $texto .= "<a href=\"$enlace$i\">$i</a> ";
                        $texto .= "<b>$actual</b> ";
                        for ($i=$actual+1; $i<=$maximo; $i++)
                        $texto .= "<a href=\"$enlace$i\">$i</a> ";
                        if ($maximo!=$total_paginas) $texto.= "... ";
                        if ($actual<$total_paginas)
                        $texto .= "<a href=\"$enlace$posterior\">»</a>";
                        else
                        $texto .= "<b>>></b>";
                        return $texto;
                        }


                        if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
                        $tampag = 15;
                        $reg1 = ($pag-1) * $tampag;

                        //invertir orden
                        if($orden=="ASC") $cambio="DESC";
                        if($orden=="DESC") $cambio="ASC";

                            $fecinix= secureSQL($fecini);
                            $fecfinx= secureSQL($fecfin);
                            $SIx= secureSQL($_GET[SI]);
                            $NOx= secureSQL($_GET[NO]);
                            $cCodificacionx= secureSQL($_GET['cCodificacion']);
                            $cAsuntox= secureSQL($_GET['cAsunto']);
                            $cObservacionesx= secureSQL($_GET[cObservaciones]);
                            $cCodTipoDocx= secureSQL($_GET['cCodTipoDoc']);
                            $iCodOficinax= secureSQL($_GET['iCodOficina']);
                            $OfiLog= secureSQL($_SESSION['iCodOficinaLogin']);
                            $campox= secureSQL($campo);
                            $ordenx= secureSQL($orden);

                            if ($fecinix!=''){$fecinix=date("Ymd", strtotime($fecinix));}
                           if( $fecfinx!=''){
                            $fecfinx=date("Y-m-d", strtotime($fecfinx));
                            function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                            $date_r = getdate(strtotime($date));
                            $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                            return $date_result;
                                        }
                            $fecfinx=dateadd($fecfinx,1,0,0,0,0,0); // + 1 dia
                            }

                            $sql.= " USP_CONSULTA_DOC_APROBAR_INTERNO '$fecinix', '$fecfinx',  '$SIx', '$NOx',  '%$cCodificacionx%', '%$cAsuntox%',  '%$cObservacionesx%', '$cCodTipoDocx' ,'$iCodOficinax','$OfiLog', '$campox', '$ordenx' ";
                            $rs    = sqlsrv_query($cnx,$sql);
                            $total = sqlsrv_has_rows($rs);
                        ?>
                        <br>
                        <table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
                        <tr>
                          <td width="120" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Fecha&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="fFecRegistro"){ echo "underline"; }Else{ echo "none";}?>">Fecha</a></td>
                            <td width="150" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
                          <td width="130" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Nombre&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Nombre"){ echo "underline"; }Else{ echo "none";}?>">Responsable</a></td>
                            <td width="200" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cReferencia=<?=$_GET[cReferencia]?>&SI=<?=$_GET[SI]?>&NO=<?=$_GET[NO]?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>" class="Estilo1" style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto</a></td>
                            <td class="headCellColum">Observaciones</td>
                          <td width="100" class="headCellColum">Oficina Destino</td>
                          <td width="80" class="headCellColum">Opciones</td>
                            </tr>
                        <?php
                        if($_GET['cCodificacion']=="" && $fecinix=="" && $fecfinx=="" && $_GET['cCodTipoDoc']=="" && $_GET['cAsunto']=="" &&  $_GET['iCodOficina']=="" && $_GET[SI]=="" && $_GET[NO]=="" ){
                           $sqlin   = " USP_CONSULTA_DOC_APROBAR_INTERNO_LISTA '$OfiLog' ";
                           $rsin    = sqlsrv_query($cnx,$sqlin);
                           $numrows = sqlsrv_has_rows($rsin);
                         }
                        else{
                            $numrows = sqlsrv_has_rows($rs);
                        }

                        if ($numrows == 0){
                                echo "NO SE ENCONTRARON REGISTROS<br>";
                                echo "TOTAL DE REGISTROS : ".$numrows;
                        }else{
                                echo "TOTAL DE REGISTROS : ".$numrows;
                        for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                            sqlsrv_fetch_array($rs, $i);
                            $Rs = sqlsrv_fetch_array($rs);
                            //while ($Rs=sqlsrv_fetch_array($rs)){
                          if ($color == "#DDEDFF"){
                            $color = "#F9F9F9";
                          }else{
                            $color = "#DDEDFF";
                          }
                            if ($color == ""){
                                $color = "#F9F9F9";
                            }
                        ?>

                            <tr bgcolor="<?php echo $color; ?>" onMouseOver="this.style.backgroundColor='#BFDEFF'"
                                    OnMouseOut="this.style.backgroundColor='<?php echo $color; ?>'" >
                            <td valign="top" align="center">
                                <?php
                                    echo $Rs['cCodificacionI'];
                                    echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
                                echo "<div style=color:#727272;font-size:10px>".date("G:i:s", strtotime($Rs['fFecRegistro']))."</div>";
                                    $sqlTra = "SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
                                        $rsTra  = sqlsrv_query($cnx,$sqlTra);
                                        $RsTra  = sqlsrv_fetch_array($rsTra);
                                        echo $Rs[cNombresTrabajador]." ".$Rs[cApellidosTrabajador];
                                    ?>
                                </td>

                            <td valign="top" align="left">
                              <?php
                                    echo $Rs['cDescTipoDoc'];
                                    // echo "<div><a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del Trámite\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                                    // echo $Rs[cCodificacion];
                                    // echo "</a></div>";
                                    $Correlativo  = substr($Rs[cCodificacion],0,5);
                                    $AnhoRegistro = date("Y", strtotime($Rs['fFecRegistro']));
                                    $sqlCorre = "SELECT * FROM Tra_M_Correlativo_Oficina 
                                                             WHERE cCodTipoDoc='$Rs[cCodTipoDoc]' AND iCodOficina='$Rs[iCodOficinaRegistro]' AND nNumAno='$AnhoRegistro'";
                                        $rsCorre = sqlsrv_query($cnx,$sqlCorre);
                                        $RsCorre = sqlsrv_fetch_array($rsCorre);
                                    ?>
                                    <br>
                                    <?php
                                  $sql1   = "SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite='".$Rs['iCodTramite']."'";
                                  $query1 = sqlsrv_query($cnx,$sql1);
                                  $rs1    = sqlsrv_fetch_array($query1);
                                  do{
                                        echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del Trámite\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                                      echo $rs1['cCodificacion'];
                                      echo "</a>";
                                  }while($rs1 = sqlsrv_fetch_array($query1));
                                  echo  "<br>";
                                  echo "Pendiente";
                                    ?>
                                    <br>
                                    <?php
                                        if($Rs[nFlgEnvio]==0){
                                        echo "<font color=red>(Por Aprobar)</font>";
                                        }else{
                                        echo "";
                                        }
                                    ?>

                                </td>

                            <td valign="top" align="left">
                                <?php
                                    $sqlTra = "SELECT * FROM Tra_M_Perfil_Ususario TPU
                                             INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
                                             WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."'";

                                    //$sqlTra="SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['JEFE']."'";

                                    $rsTra=sqlsrv_query($cnx,$sqlTra);
                                    $RsTra=sqlsrv_fetch_array($rsTra);
                                    echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";	 ?>
                            </td>
                            <td valign="top" align="left"><?=$Rs['cAsunto']?></td>
                            <td valign="top" align="left"><?=$Rs[cObservaciones]?></td>
                            <td valign="top" align="left">
                                <?php
$sqlDes= " SELECT TOP 1 Tra_M_Tramite.iCodTramite,cNombresTrabajador,cApellidosTrabajador,cNomOficina FROM Tra_M_Tramite ";
                                $sqlDes.= " LEFT OUTER JOIN Tra_M_Tramite_Movimientos on Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
                                        $sqlDes.= " LEFT OUTER JOIN Tra_M_Trabajadores on Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar=Tra_M_Trabajadores.iCodTrabajador, Tra_M_Oficinas ";
                                $sqlDes.= " WHERE Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Movimientos.iCodOficinaDerivar AND Tra_M_Tramite.nFlgTipoDoc=2 AND Tra_M_Tramite.nFlgClaseDoc=1 ";
                                        $sqlDes.= " AND Tra_M_Tramite.iCodTramite='$Rs[iCodTramite]' ";
                                        $rsDes=sqlsrv_query($cnx,$sqlDes);
                                        $RsDes=sqlsrv_fetch_array($rsDes);
                                        echo $RsDes[cNomOficina];
                                        echo "<div style=color:#727272>".$RsDes[cNombresTrabajador]." ".$RsDes[cApellidosTrabajador]."</div>";

                                    ?>
                                </td>
                        <?php
           /*  <td valign="middle" align="left">
                                <?php
    $rsBusc=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$Rs[cReferencia]'");
                                    if(sqlsrv_has_rows($rsBusc)>0){
                                        $RsBusc=sqlsrv_fetch_array($rsBusc);
                                        echo "<a href=\"registroDetalles.php?iCodTramite=".$RsBusc[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del Trámite\" rev=\"width: 970px; height: 550px; scrolling: auto; border:no\">";
                                    }
                                    echo "<div style=text-transform:uppercase>".$Rs[cReferencia]."</div>";
                                    echo "</a>"
                                ?>
                            </td>
                        */?>
                            <td valign="top">

                            <table>
                                <tr>
                                    <td>

                        <?php
                            $sqlx= "select descripcion from Tra_M_Tramite where iCodTramite='".$Rs[iCodTramite]."'";
                            $queryx=sqlsrv_query($cnx,$sqlx);
                            $rsx=sqlsrv_fetch_array($queryx);

                            do{
                                $tiempox=$rsx['descripcion'];
                            }while($rsx=sqlsrv_fetch_array($queryx));

                                $abc=strlen(rtrim(ltrim($tiempox)));
                                if($abc>0){
                            ?>
                          <a href="ver_digital.php?iCodTramite=<?=$Rs[iCodTramite]?>" rel="lyteframe" title="Ver Detalle Documento" rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                        <img src="images/1471041812_pdf.png" border="0" height="17" width="17">
                                        </a>
                        &nbsp;
                                        <a href="pdf_digital.php?iCodTramite=<?=$Rs[iCodTramite]?>" title="Descargar Detalle Documento" rev="width: 970px; height: 550px; scrolling: auto; border:no" target="_blank">
                                        <img src="images/icon_print.png" border="0" height="17" width="17">
                                        </a>

                            <?php
                                }
                            ?>

                                    </td>
                                    <td>
                                        <a href="registroObsAntesAprobar.php?iCodTramite=<?=$Rs[iCodTramite]?>&pag=1" title="Observar tramite"
                                                     rel="lyteframe" title="Modificar Observacion" rev="width: 410px; height: 280px; scrolling: no; border:no">
                                                    <img src="images/icon_observacion.png" width="17" height="17" border="0">
                                                </a>



                                    </td>
                                    <td>
                                            <a href="ajax/aprobarTramite.php?iCodTramite=<?=$Rs[iCodTramite]?>&iCodJefe=<?=$_SESSION['CODIGO_TRABAJADOR']?>" title="Aprobar tramite" onclick="return confirm('Esta seguro de Aprobar el Documento')" class="confirmation">
                                                    <img src="images/icon_aceptar.png" width="17" height="17" border="0">
                                                </a>

                                       <script>
                          var elems = document.getElementsByClassName('confirmation');
                            var confirmIt = function (e) {
                                if (!confirm('Esta seguro de Aprobar el Documento')) e.preventDefault();
                            };
                                        </script>

                                    </td>
                                </tr>
                            </table>


                                    <?php


                                        $sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]'";
                                    $rsDw  = sqlsrv_query($cnx,$sqlDw);
                                    if (sqlsrv_has_rows($rsDw) > 0){
                                        $RsDw = sqlsrv_fetch_array($rsDw);
                                        if ($RsDw["cNombreNuevo"] != ""){
                                            if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
                                                        $sqlCondicion =" SP_CONDICION_REGISTRO_TRABAJADOR '$Rs[iCodOficinaRegistro]','".$_SESSION['iCodOficinaLogin']."','".$_SESSION['CODIGO_TRABAJADOR']."' ";
                                                        $rsCondicion = sqlsrv_query($cnx,$sqlCondicion);
                                                        $RsCondicion = sqlsrv_fetch_array($rsCondicion);
                                                        if ($RsCondicion["Total"] == "1"){
                                                            echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\" ><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
                                                        }else{
                                                            $sqlCondicion2 = " SP_CONDICION_DOCUMENTO_REGISTRO '$Rs[iCodOficinaRegistro]' ";
                                                            $rsCondicion2  = sqlsrv_query($cnx,$sqlCondicion2);
                                                            $RsCondicion2  = sqlsrv_fetch_array($rsCondicion2);
                                                            if ($RsCondicion2["Total"] == "0"){
                                                                echo "<a title=\"Documento Complementario\" href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
                                                            }
                                                        }
                                                    }
                                                }
                                    }else{
                                        echo "<img src=images/space.gif width=16 height=16>";
                                    }
                                        $sqlRep = "SELECT fFecRecepcion FROM Tra_M_Tramite_Movimientos 
                                                             WHERE iCodTramite = $Rs[iCodTramite] AND (fFecRecepcion IS NOT NULL OR fFecRecepcion != '')";
                                            $rsRep  = sqlsrv_query($cnx,$sqlRep);
                                            $sqlDev = "SELECT iCodTramiteDerivar FROM Tra_M_Tramite_Movimientos 
                                                                 WHERE iCodTramiteDerivar = $Rs[iCodTramite] AND cFlgTipoMovimiento != 5 ";
                                            $rsDev  = sqlsrv_query($cnx,$sqlDev);

                                            if ($_SESSION['CODIGO_TRABAJADOR'] == 10576){
                                                echo "<a href=\"registroOficinaDownLoad.php?iCodTramite=".$Rs[iCodTramite]."&URI=".$_SERVER['REQUEST_URI']."\"><img src=\"images/icon_download_1.png\" width=\"17\" height=\"17\" alt=\"Subir Documento\" border=\"0\"></a>";
                                            }
                                            ?>




                            </td>
                            </tr>

                        <?php
        }
                        }

                        ?>
                        <tr>
                                <td colspan="8" align="center">
                                 <?php echo paginar($pag, $total, $tampag, "consultaInternoOficina.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&iCodOficina=".$_GET['iCodOficina']."&SI=".$_GET[SI]."&NO=".$_GET[NO]."&pag=");?>
                                 </td>
                                </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>

<script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>

<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">

    function ConfirmarBorrado()
    {
        if (confirm("Esta seguro de eliminar el registro?")){
            return true;
        }else{
            return false;
        }
    }
    function Buscar()
    {
        document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
        document.frmConsultaEntrada.submit();
    }
</script>
<script>
	$(document).ready(function(){
		$('.aprobar').click(function(event) {
			var iCodTramite = $(this).attr('data-codTramite');
      var parametros = {
          "iCodTramite" : iCodTramite
      };

      $.ajax({
          data : parametros,
          url  : 'ajax/aprobarTramite.php',
          type : 'post'
      }).done(function(response) {
      	alert("El tramite ha sido Aprobado");
      	window.location="registroInternoObsDEG.php?iCodTramite="+iCodTramite+"&aprobado=1";
      });
		});

		$('.observar').click(function(event) {
			var iCodTramite = $(this).attr('data-codTramite');
      var parametros = {
          "iCodTramite" : iCodTramite
      };

      $.ajax({
          data : parametros,
          url  : 'ajax/aprobarTramite.php',
          type : 'post'
      }).done(function(response) {
      	alert("El tramite ha sido Aprobado");
      	window.location="registroInternoObsDEG.php?iCodTramite="+iCodTramite+"&aprobado=1";
      });
		});
	});
</script>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>