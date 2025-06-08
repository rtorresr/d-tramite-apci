<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?><style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
-->
</style></head>
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


<table class="table">
<tr>
	<td class="">
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="1000" align="center">
		<tr>
		<td valign="top" width="400">
			
			
			
	</td>
	<td width="250"  valign="top">
	</td>
	

	<td width="400" bgcolor="#c6dcf0" valign="top">
    <? 
		include_once("../conexion/conexion.php");
		if($_SESSION['iCodPerfilLogin']==2){ ?>
			<table>
			<tr>
			<td class="FondoFormBordes" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td height="22" align="center" class="headColumnas"  ><b>SUMARIO</b></td></tr>
					<tr><td align="left">
		<?php
		
			$sqlTra= " SP_SUMARIO_OFICINA '".$_SESSION['iCodOficinaLogin']."' ";
			$rsTra=sqlsrv_query($cnx,$sqlTra);
			$RsTra=sqlsrv_fetch_array($rsTra);
			
			
		?>
						
						<div style="padding-left:3px;padding-right:3px;">A la fecha la oficina<em> <b><?php echo $RsTra[noOficina];?></b></em>mantiene <span style="color:#ff0000"><b><?php echo $RsTra[nuTotalPendientes];?></b></span> documentos en su Bandeja de Pendiente.</div>
                    </td></tr>
					<tr>
						<td>
								<table border="1" cellpadding="2" cellspacing="2" width="100%">
								<tr>
								<td bgcolor="#AA5500"  > Tipo Documento</td>
								<td bgcolor="#844200"  > Pendientes</td>
								<td bgcolor="#844200"  ><div align="center">En Proceso</div></td>
								<td bgcolor="#4682B4"  ><div align="center"><span class="Estilo2">TOTAL</span></div></td>
								</tr>
								<tr>
								<td>Entradas con Tupa</td>
								<td align="center"><?php echo $RsTra[nuSinAceptarTupa];?></td>
								<td align="center"><?php echo $RsTra[nuEnProcesoTupa];?></td>
								<td align="center" style="color:#0154AF">
								<?php
									$totTupa=$RsTra[nuSinAceptarTupa]+$RsTra[nuEnProcesoTupa];
									echo $totTupa;
								?>
								</td>
								</tr>
								<tr>
								<td>Entradas sin Tupa</td>
								<td align="center"><?php echo $RsTra[nuSinAceptarSTupa];?></td>
								<td align="center"><?php echo $RsTra[nuEnProcesoSTupa];?></td>
								<td align="center" style="color:#0154AF">
								<?php
									$totSTupa=$RsTra[nuSinAceptarSTupa]+$RsTra[nuEnProcesoSTupa];
									echo $totSTupa;
								?>
								</td>
								</tr>
								<tr>
                                <td>Internos</td>
								<td align="center"><?php echo $RsTra[nuSinAceptarInterno];?></td>
								<td align="center"><?php echo $RsTra[nuEnProcesoInterno];?></td>
								<td align="center" style="color:#0154AF">
								<?php
									$totInterno=$RsTra[nuSinAceptarInterno]+$RsTra[nuEnProcesoInterno];
									echo $totInterno;
								?>
								</td>
								</tr>
								<tr>
								<td bgcolor="#4682B4"><span class="Estilo2"><strong>TOTAL</strong></span></td>
								<td align="center"><b><?php echo $RsTra[nuSinAceptar];?></b></td>
								<td align="center"><b><?php echo $RsTra[nuEnProceso];?></b></td>
								<td align="center" bgcolor="#FFFFFF"><b>
								<?php
									$totSumario=$RsTra[nuSinAceptar]+$RsTra[nuEnProceso];
									echo $totSumario;
								?></b></td>
								</tr>
								</table>
						</td>
					</tr>
					</table>
            <?php
				}        
			?> 			
       <? 
	 if( $_SESSION['iCodPerfilLogin']==4 or $_SESSION['iCodPerfilLogin']==14){
	   ?>     
        <table>
			<tr>
			<td class="FondoFormBordes" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td height="22" align="center" class="headColumnas"  ><b>SUMARIO</b></td></tr>
					<tr><td align="left">
						<?
						
						//////////////////////////
						
						
								$sqlPndPro="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And Tra_M_Tramite.nFlgEnvio=1 AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')))  AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6))  ";
				
        $rsPndPro=sqlsrv_query($cnx,$sqlPndPro);
		
        $totalpendientespro = sqlsrv_has_rows($rsPndPro);
						
						//////////////////////////
						
						
						
				$sqlSTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And Tra_M_Tramite.nFlgEnvio=1 AND 
				((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR
				Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) OR
				Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') AND 
				(Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR 
				Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR
				(Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6 )) AND
				Tra_M_Tramite.nFlgClaseDoc=2 and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is null";
						
						
						/////////////////////////////////
						
    			  $sqlPnd="SELECT * FROM Tra_M_Tramite ";
    			  $sqlPnd.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlPnd.="WHERE Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion=NULL AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 ";
    			  $rsPnd=sqlsrv_query($cnx,$sqlPnd);
    			
    			  //en proceso c/Tupa
    			  $sqlCTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM 
      [dbo].[Tra_M_Tramite],[dbo].[Tra_M_Tramite_Movimientos] WHERE 
       Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite
	   And Tra_M_Tramite.nFlgEnvio=1 
       AND Tra_M_Tramite.nFlgTipoDoc=1 
       and Tra_M_Tramite.nFlgClaseDoc=1 
       and Tra_M_Tramite_Movimientos.fFecDelegado is null
       AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND
       ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado=

'".$_SESSION['CODIGO_TRABAJADOR']."' OR
        Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar=

'".$_SESSION['CODIGO_TRABAJADOR']."'))  OR 
        Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar=

'".$_SESSION['CODIGO_TRABAJADOR']."') AND 
        (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR
         Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR 
         (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND 
         Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsCTupa=sqlsrv_query($cnx,$sqlCTupa); 
				  
				  
				  //////con TUPA NUEVO----
				/*  
				  
				  otepa
				  
				  //////
    			  
    			  //en proceso s/Tupa
    			  /*$sqlSTupa="SELECT * FROM Tra_M_Tramite ";
    			  $sqlSTupa.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlSTupa.="WHERE Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion IS NOT NULL AND (Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 ) AND Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.nFlgClaseDoc=2 AND Tra_M_Tramite.nFlgEstado=2";*/
    			  $rsSTupa=sqlsrv_query($cnx,$sqlSTupa);
    			  
    			  //en proceso Interno
    			  $sqlInt="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And Tra_M_Tramite.nFlgEnvio=1 and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is null AND  Tra_M_Tramite.nFlgTipoDoc=2 AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')))  AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsInt=sqlsrv_query($cnx,$sqlInt);
    			  

    			  
    			  //en proceso Vencido c/Tupa
    			 
    			  $sqlVCTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM 
       [dbo].[Tra_M_Tramite],[dbo].[Tra_M_Tramite_Movimientos] WHERE 
       Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite 
       AND Tra_M_Tramite.nFlgTipoDoc=1 
       and Tra_M_Tramite.nFlgClaseDoc=1 
       and Tra_M_Tramite_Movimientos.fFecDelegado is not null
       AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND
       ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado=

'".$_SESSION['CODIGO_TRABAJADOR']."' OR
        Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar=

'".$_SESSION['CODIGO_TRABAJADOR']."'))  OR 
        Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar=

'".$_SESSION['CODIGO_TRABAJADOR']."') AND 
        (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR
         Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR 
         (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND 
         Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsVCTupa=sqlsrv_query($cnx,$sqlVCTupa);
    			  
    			  
    			  //en proceso Vencido s/Tupa
    			 
    			  $sqlVSTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite AND 
				((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR
				Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."'))) 
				 AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR 
				Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR
				(Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6 )) AND
				Tra_M_Tramite.nFlgClaseDoc=2 and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is not null";
    			  $rsVSTupa=sqlsrv_query($cnx,$sqlVSTupa);

    			  
    			  //en proceso Vencido Internos
    			 
    			  $sqlVeInt="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is not null AND  Tra_M_Tramite.nFlgTipoDoc=2 AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."'))) AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsVeInt=sqlsrv_query($cnx,$sqlVeInt);
						?>
						
						<div style="padding-left:3px;padding-right:3px;">A la fecha <i><?=trim($RsUsr[cNombresTrabajador])?>, <?=trim($RsUsr[cApellidosTrabajador])?></i> mantiene <span style="color:#ff0000"><b><?=$totalpendientespro;?></b></span> documento<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> en su Bandeja de Pendiente<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?>.</div>
					</td></tr>
					<tr>
						<td>
								<table border="1" cellpadding="2" cellspacing="2" width="100%">
								<tr>
								<td bgcolor="#AA5500"  > Tipo Documento</td>
								<td bgcolor="#844200"  > Pendientes</td>
								<td bgcolor="#844200"  ><div align="center">En Proceso</div></td>
								<td bgcolor="#4682B4"  ><div align="center"><span class="Estilo2">TOTAL</span></div></td>
								</tr>
								<tr>
								<td>Entradas con Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsCTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVCTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsVCTupa);?></td>
								</tr>
								<tr>
								<td>Entradas sin Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsSTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVSTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsVSTupa);?></td>
								</tr>
								<tr>
								<td>Internos</td>
								<td align="center"><?=sqlsrv_has_rows($rsInt);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVeInt);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsInt)+sqlsrv_has_rows($rsVeInt);?></td>
								</tr>
								<tr>
								<td bgcolor="#4682B4"><span class="Estilo2"><strong>TOTAL</strong></span></td>
								<td align="center"><strong>
								  <?=(sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsInt))?>
								</strong></td>
								<td align="center"><strong>
								  <?=(sqlsrv_has_rows($rsVCTupa)+sqlsrv_has_rows($rsVSTupa)+sqlsrv_has_rows($rsVeInt))?>
								</strong></td>
								<td align="center"><b><?=$totalpendientespro;?></b></td>
								</tr>
								</table>
						</td>
					</tr>
					</table>
              <?php } ?>
     <?php  if($_SESSION['iCodPerfilLogin']!=4 && $_SESSION['iCodPerfilLogin']!=2  && $_SESSION['iCodPerfilLogin']!=14)
	 { 
	 ?>
			<table>
			<tr>
			<td class="FondoFormBordes" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td height="22" align="center" class="headColumnas"  ><b>SUMARIO</b></td></tr>
					<tr><td align="left">
			<?php
			$sqlTra= " SP_SUMARIO_OFICINA '".$_SESSION['iCodOficinaLogin']."' ";
			error_log("LOGIN ==>".$sqlTra);
			$rsTra=sqlsrv_query($cnx,$sqlTra);
			$RsTra=sqlsrv_fetch_array($rsTra);
			
			?>
						
						<div style="padding-left:3px;padding-right:3px;">A la fecha la oficina<em> <b>
			<?php
			echo $RsTra[noOficina];
				?>
						</b></em>mantiene <span style="color:#ff0000"><b><?php echo $RsTra[nuTotalPendientes];?></b></span> documentos en su Bandeja de Pendientes.</div>
                    </td></tr>
					<tr>
						<td>
								<table border="1" cellpadding="2" cellspacing="2" width="100%">
								<tr>
								<td bgcolor="#AA5500"  > Tipo Documento</td>
								<td bgcolor="#844200"  > Pendientes</td>
								<td bgcolor="#844200"  ><div align="center">En Proceso</div></td>
								<td bgcolor="#4682B4"  ><div align="center"><span class="Estilo2">TOTAL</span></div></td>
								</tr>
								<tr>
								<td>Entradas con Tupa</td>
								<td align="center"><?php echo $RsTra[nuSinAceptarTupa];?></td>
								<td align="center"><?php echo $RsTra[nuEnProcesoTupa];?></td>
								<td align="center" style="color:#0154AF">
								<?php
									$totTupa=$RsTra[nuSinAceptarTupa]+$RsTra[nuEnProcesoTupa];
									echo $totTupa;
								?>
								</td>
								</tr>
								<tr>
								<td>Entradas sin Tupa</td>
								<td align="center"><?php echo $RsTra[nuSinAceptarSTupa];?></td>
								<td align="center"><?php echo $RsTra[nuEnProcesoSTupa];?></td>
								<td align="center" style="color:#0154AF">
								<?php
									$totSTupa=$RsTra[nuSinAceptarSTupa]+$RsTra[nuEnProcesoSTupa];
									echo $totSTupa;
								?>
								</td>
								</tr>
								<tr>
                                <td>Internos</td>
								<td align="center"><?php echo $RsTra[nuSinAceptarInterno];?></td>
								<td align="center"><?php echo $RsTra[nuEnProcesoInterno];?></td>
								<td align="center" style="color:#0154AF">
								<?php
									$totInterno=$RsTra[nuSinAceptarInterno]+$RsTra[nuEnProcesoInterno];
									echo $totInterno;
								?>
								  </td>
								</tr>
								<tr>
								<td>Salidas</td>
								<td align="center"><?php echo $RsTra[nuSinAceptarSalida];?></td>
								<td align="center"><?php echo $RsTra[nuEnProcesoSalida];?></td>
								<td align="center" style="color:#0154AF">
								<?php
									$totSalida=$RsTra[nuSinAceptarSalida]+$RsTra[nuEnProcesoSalida];
									echo $totSalida;
								?>
								</td>
								</tr>
								<tr>
								<td bgcolor="#4682B4"><span class="Estilo2"><strong>TOTAL</strong></span></td>
								<td align="center"><b><?php echo $RsTra[nuSinAceptar];?></b></td>
								<td align="center"><b><?php echo $RsTra[nuEnProceso];?></b></td>
								<td align="center" bgcolor="#FFFFFF"><b>
								<?php
									$totSumario=$RsTra[nuSinAceptar]+$RsTra[nuEnProceso];
									echo $totSumario;
								?>
								</b></td>
								</tr>
								</table>
						</td>
					</tr>
					</table>
        <?php 
		}
		?>        
			</td>
			</tr>
			</table>      
	</td>
	</tr>
	</table>

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
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>