<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaTramiteTupa.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta de los Documentos de Entrada
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
?>
<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>

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
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

<div class="AreaTitulo">Consulta de Fiscalizacion - Contenido</div>
<table class="table">
<tr>

	<br>
	
	<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
	<tr>
	<td width="98" class="headCellColum">N&ordm; Paquete</td>
  <td width="92" class="headCellColum">Registro</td>
	<td width="150" class="headCellColum">Registrado</td>
  <td width="530" class="headCellColum">Observaciones</td>
  <td width="83" class="headCellColum">Opciones</td>
	</tr>
	<?
	function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
    	for($m=0; $m<$dif_diez; $m++){
            @$insertar_ceros .= 0;
    	}
    	return $insertar_ceros .= $numero;
  }	
		$sql="SELECT * FROM Tra_M_Tramite_Fiscalizacion WHERE iCodPaquete='$_GET[iCodPaquete]'";	   
    $rs=sqlsrv_query($cnx,$sql);
		$Rs=sqlsrv_fetch_array($rs);
        		if ($color == "#DDEDFF"){
			  			$color = "#F9F9F9";
	    			}else{
			  			$color = "#DDEDFF";
	    			}
	    			if ($color == ""){
			  			$color = "#F9F9F9";
	    			}	
	?>
	<tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
 	<td valign="top" align="center">
    	<a href="javaScript:;" onClick="muestra('area<?=$Rs[iCodPaquete]?>')";><?=add_ceros($Rs[iCodPaquete],5)?></a>
  </td>
    <td valign="top" align="center" valign="top"><?
    	echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($Rs[fFecPaquete]))."</div>";
      echo "<div style=color:#0154AF;font-size:10px>".date("h:i A", strtotime($Rs[fFecPaquete]))."</div>";
      ?>
    </td>
    <td valign="top">
    	<?
    	$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'");
      $RsDelg=sqlsrv_fetch_array($rsDelg);
      echo "<span style=color:#6F3700>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</span>";
			sqlsrv_free_stmt($rsDelg);
    	?>
    </td>
    <td width="530" valign="top" style="text-align:justify;padding-left:10px;padding-right:10px;"><?=nl2br($Rs[cObservaciones])?></td> 
    <td valign="top" align="center">
				<?php if($Rs[cInformeDigital]!=""){
						if (file_exists("../cAlmacenArchivos/".$Rs[cInformeDigital])){
								echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($Rs[cInformeDigital])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($Rs[cInformeDigital])."\"></a>";
						}Else{
								echo "<img src=images/space.gif width=16 height=16 border=0>";
						}
				}Else{
								echo "<img src=images/space.gif width=16 height=16 border=0>";
				}
				?>
		</td>
 </tr>
 	
 <tr>
 	<td colspan="5" align="left" bgcolor="<?=$color?>" valign="top">
				
						<table width="100%">
						<tr>
						<td width="98" class="headCellColum">Nro Documento</td>
						<td width="142" class="headCellColum">Tipo Documento</td>
						<td width="184" class="headCellColum">Remitente</td> 
						<td width="92" class="headCellColum">Fecha Derivo</td>
						<td class="headCellColum">Asunto / TUPA</td>
  					<td width="83" class="headCellColum">Archivo</td>
						</tr>
				<?
				$sqlPq="SELECT * FROM Tra_M_Tramite WHERE iCodPaquete='$Rs[iCodPaquete]' ORDER BY iCodTramite DESC";	   
    		$rsPq=sqlsrv_query($cnx,$sqlPq);
				while ($RsPq=sqlsrv_fetch_array($rsPq)){?>
						<tr bgcolor="#ffffff">
    				<td valign="top" align="center">
    							<a href="registroDetalles.php?iCodTramite=<?=$RsPq[iCodTramite]?>"  rel="lyteframe" title="Detalle del Documento" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$RsPq[cCodificacion]?></a>
    					<?
    					echo "<div style=color:#727272>".date("d-m-Y", strtotime($RsPq['fFecRegistro']))."</div>";
    				  echo "<div style=color:#727272;font-size:10px>".date("h:i A", strtotime($RsPq['fFecRegistro']))."</div>";
    				  ?>
    				</td>
    				<td valign="top" align="left">
    					<?
    					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsPq[cCodTipoDoc]'";
							$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
							$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
							echo $RsTipDoc['cDescTipoDoc'];
							echo "<div style=color:#808080>".$RsPq['cNroDocumento']."</div>";
    					?>
    				</td>
    				<td valign="top" align="left">
    					<?
    							$sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$RsPq[iCodRemitente]'";
									$rsRemi=sqlsrv_query($cnx,$sqlRemi);
									$RsRemi=sqlsrv_fetch_array($rsRemi);
    							if($RsRemi['cTipoPersona']=='1'){ 
									   echo "<div style=color:#000000;>".$RsRemi['cNombre']."</div>";
    				  		   echo "<div style=color:#0154AF;font-size:10px>DNI: ".$RsRemi['nNumDocumento']."</div>";
									}else{
									   echo "<div style=color:#000000;>".$RsRemi['cNombre']."</div>";
									   echo "<div style=color:#408080;>".$RsRemi[cNomRemite]."</div>";
    				  		   echo "<div style=color:#0154AF;font-size:10px;>RUC:".$RsRemi['nNumDocumento']."</div>";
    				  		}
    				  ?>
    				</td> 
    				<? /* <td><?php echo $Rs[cRepresentante];?></td> */?>
    				<td valign="top" align="center">
    					<?
    							$sqlM="select TOP 1 * from Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsPq[iCodTramite]'";
    							//echo $sqlM;
    				  		$rsM=sqlsrv_query($cnx,$sqlM);
	  				  		if(sqlsrv_has_rows($rsM)>0){
	  				  			$RsM=sqlsrv_fetch_array($rsM);
    								echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsM['fFecDerivar']))."</div>";
    				  			echo "<div style=color:#0154AF;font-size:10px>".date("h:i A", strtotime($RsM['fFecDerivar']))."</div>";
    				  		}
							?>
						</td>
    				<td valign="top">
    					<?
    					echo $RsPq['cAsunto'];
    					if($RsPq['iCodTupa']!=""){
    						$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='$RsPq['iCodTupa']'";
    				  	$rsTup=sqlsrv_query($cnx,$sqlTup);
    				  	$RsTup=sqlsrv_fetch_array($rsTup);
    				  	echo "<div style=color:#0154AF>".$RsTup["cNomTupa"]."</div";
    				  }
    					?>
    				</td>
    				<td valign="top">

    							<?
    							$sqlDw="SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$RsPq[iCodTramite]'";
    				  		$rsDw=sqlsrv_query($cnx,$sqlDw);
    				  		if(sqlsrv_has_rows($rsDw)>0){
    				  			$RsDw=sqlsrv_fetch_array($rsDw);
    				  			if($RsDw["cNombreNuevo"]!=""){
								 			if (file_exists("../cAlmacenArchivos/".trim($RsDw["cNombreNuevo"]))){
												echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
											}Else{
												echo "<img src=images/space.gif width=16 height=16 border=0>";
											}
										}
    				  		}
    							?>
    				</td>
						</tr>
				<?php}?>
						</table>

 						</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

			<button class="btn btn-primary" onclick="window.open('consultaTramitePaquetes.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Retornar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
<!-- fin cierre borde azul -->
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>