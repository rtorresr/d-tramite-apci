<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: estadisticaEntradaGeneral.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta Estadistica de los Documentos Pendientes,En Proceso y Finalizados General
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
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">

function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}

//--></script>
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

<div class="AreaTitulo">Estadisticas - Documentos de Entrada</div>




							<form name="frmConsultaEntrada" method="GET" action="consultaEntradaGeneral.php">
						<tr>
							<td colspan="4" >
							  <table border="0" align="center" cellpadding="0" cellspacing="0"><tr>
							    <td>Desde:&nbsp;<input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
							    <td width="20"></td>
							    <td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td><td width="100" align="right"><button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button></td>
							    </tr></table>						    </td>
							</tr>
					</form>
   			  </table>
			</fieldset>

</form>



<?
  $fDesde=date("Ymd", strtotime($_GET['fDesde']));
	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia

  
   //echo $sql;
?>
<br>
<br>

			<fieldset><legend>DOCUMENTOS DE ENTRADA SEGUN SU ESTADO</legend>
<table width="1000" border="0" cellpadding="3" cellspacing="0" align="center">
<tr>
	<td width="244" class="headCellColum"> </td>
    <td width="0" bgcolor="#CCCCCC"></td>
	<td width="185" class="headCellColum">PENDIENTES</td>
	<td width="173" class="headCellColum">EN PROCESO</td> 
	<td width="174" class="headCellColum">FINALIZADOS</td>
	<td width="188" class="headCellColum">TOTALES</td>
  	</tr>
    <tr>
    <td colspan="6" bgcolor="#CCCCCC" >
    
    </td>
    </tr>
    <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada con TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	           <? $sql1="  SELECT iCodTramite,iCodTupa,iCodTupaClase,nFlgTipoDoc,nFlgEstado ";
			      $sql1.=" FROM  Tra_M_Tramite ";
				  $sql1.=" WHERE nFlgTipoDoc=1 AND nFlgEstado=1 AND iCodTupa IS NOT NULL ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  				  $sql1.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql1.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
   				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql1.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  				  }
				  $rs1=sqlsrv_query($cnx,$sql1);
				  $pendientes_ctupa=sqlsrv_has_rows($rs1);
			  	  echo $pendientes_ctupa;?>
                        </td>
    <td valign="top" align="center">
    	       <? $sql2="  SELECT iCodTramite,iCodTupa,iCodTupaClase,nFlgTipoDoc,nFlgEstado ";
			      $sql2.=" FROM  Tra_M_Tramite ";
				  $sql2.=" WHERE nFlgTipoDoc=1 AND nFlgEstado=2 AND iCodTupa IS NOT NULL 	 ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
				  $sql2.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql2.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
   				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql2.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  				  }
				  $rs2=sqlsrv_query($cnx,$sql2);
				  $proceso_ctupa=sqlsrv_has_rows($rs2);
			  	  echo $proceso_ctupa;?>
    </td> 
    <td valign="top" align="center">
    	      <?  $sql3="  SELECT iCodTramite,iCodTupa,iCodTupaClase,nFlgTipoDoc,nFlgEstado ";
			      $sql3.=" FROM  Tra_M_Tramite ";
				  $sql3.=" WHERE nFlgTipoDoc=1 AND nFlgEstado=3 AND iCodTupa IS NOT NULL ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
				  $sql3.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql3.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql3.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  				  }
				  $rs3=sqlsrv_query($cnx,$sql3);
				  $finalizados_ctupa=sqlsrv_has_rows($rs3);
			  	  echo $finalizados_ctupa;?>
		</td>
    <td valign="top" align="center">
    	<?   $total_ctupa=	$pendientes_ctupa + $proceso_ctupa + $finalizados_ctupa;
		     echo $total_ctupa;
    	?>
    </td>
</tr>
  <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada sin TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	           <? $sql4="  SELECT iCodTramite,iCodTupa,iCodTupaClase,nFlgTipoDoc,nFlgEstado ";
			      $sql4.=" FROM  Tra_M_Tramite ";
				  $sql4.=" WHERE nFlgTipoDoc=1 AND nFlgEstado=1 AND iCodTupa IS NULL ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
				  $sql4.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql4.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql4.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  				  }
				  $rs4=sqlsrv_query($cnx,$sql4);
				  $pendientes_stupa=sqlsrv_has_rows($rs4);
			  	  echo $pendientes_stupa;?>
       </td>
    <td valign="top" align="center">
    	       <? $sql5="  SELECT iCodTramite,iCodTupa,iCodTupaClase,nFlgTipoDoc,nFlgEstado ";
			      $sql5.=" FROM  Tra_M_Tramite ";
				  $sql5.=" WHERE nFlgTipoDoc=1 AND nFlgEstado=2 AND iCodTupa IS NULL 	 ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
				  $sql5.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql5.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql5.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
 				  }
				  $rs5=sqlsrv_query($cnx,$sql5);
				  $proceso_stupa=sqlsrv_has_rows($rs5);
			  	  echo $proceso_stupa;?>
    </td> 
    <td valign="top" align="center">
    	      <?  $sql6="  SELECT iCodTramite,iCodTupa,iCodTupaClase,nFlgTipoDoc,nFlgEstado ";
			      $sql6.=" FROM  Tra_M_Tramite ";
				  $sql6.=" WHERE nFlgTipoDoc=1 AND nFlgEstado=3 AND iCodTupa IS NULL ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
				  $sql6.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql6.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql6.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  				  }
				  $rs6=sqlsrv_query($cnx,$sql6);
				  $finalizados_stupa=sqlsrv_has_rows($rs6);
			  	  echo $finalizados_stupa;?>
		</td>
    <td valign="top" align="center">
    	<?   $total_stupa=	$pendientes_stupa + $proceso_stupa + $finalizados_stupa;
		     echo $total_stupa;
    	?>
    </td>
</tr>


</table>
			</fieldset>

<br>
<br>

			<fieldset><legend>DOCUMENTOS VENCIDOS</legend>
<table width="1000" border="0" cellpadding="3" cellspacing="0" align="center">
<tr>
	<td width="244" class="headCellColum"> </td>
    <td width="1" bgcolor="#CCCCCC"></td>
	<td width="237" class="headCellColum">SILENCIO ADM. ( + )</td>
	<td width="244" class="headCellColum">SILENCIO ADM. ( - )</td> 
	<td width="244" class="headCellColum">TOTAL VENCIDOS</td>
	</tr>
    <tr>
    <td colspan="5" bgcolor="#CCCCCC" >
    
    </td>
    </tr>
    <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada con TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	           <? $sql7=" SELECT iCodTramite,Tra_M_Tramite.iCodTupa,Tra_M_Tramite.fFecRegistro,Tra_M_Tupa.nDias, ";
			      $sql7.=" nSilencio,nFlgTipoDoc,nFlgEstado FROM  Tra_M_Tramite, Tra_M_Tupa  ";
				  $sql7.=" WHERE Tra_M_Tramite.iCodTupa=Tra_M_Tupa.iCodTupa  AND Tra_M_Tramite.iCodTupa IS NOT NULL	 ";
				  $sql7.=" AND (DATEDIFF(DAY,Tra_M_Tramite.fFecRegistro,GETDATE()) >Tra_M_Tupa.nDias) AND nSilencio=1	 ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
				  $sql7.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql7.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql7.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  				  }
				  $rs7=sqlsrv_query($cnx,$sql7);
				  $vencido_positivo=sqlsrv_has_rows($rs7);
			  	  echo $vencido_positivo;?>
                        </td>
    <td valign="top" align="center">
       	       <? $sql8=" SELECT iCodTramite,Tra_M_Tramite.iCodTupa,Tra_M_Tramite.fFecRegistro,Tra_M_Tupa.nDias, ";
			      $sql8.=" nSilencio,nFlgTipoDoc,nFlgEstado FROM  Tra_M_Tramite, Tra_M_Tupa  ";
				  $sql8.=" WHERE Tra_M_Tramite.iCodTupa=Tra_M_Tupa.iCodTupa  AND Tra_M_Tramite.iCodTupa IS NOT NULL	 ";
				  $sql8.=" AND (DATEDIFF(DAY,Tra_M_Tramite.fFecRegistro,GETDATE()) >Tra_M_Tupa.nDias) AND nSilencio=0	 ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
				  $sql8.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  				  }
  				  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  				  $sql8.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  				  }
  				  if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  				  $sql8.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  				  }
				  $rs8=sqlsrv_query($cnx,$sql8);
				  $vencido_negativo=sqlsrv_has_rows($rs8);
			  	  echo $vencido_negativo;?>
    </td> 
    <td valign="top" align="center">
    	       <? $total_cvencido=	$vencido_positivo +  $vencido_negativo;
		          echo $total_cvencido;
    	       ?>
    </td>
</tr>
  <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada sin TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	           <?php echo " - ";?>
       </td>
    <td valign="top" align="center">
    	       <?php echo " - ";?>
    </td> 
    <td valign="top" align="center">
         <? $sql9=" SELECT iCodTramite,fFecRegistro,nFlgTipoDoc,nFlgEstado FROM  Tra_M_Tramite ";
	        $sql9.=" WHERE  iCodTupa IS NULL AND nFlgTipoDoc=1 ";
		    $sql9.=" AND (DATEDIFF(DAY,Tra_M_Tramite.fFecRegistro,GETDATE()) >nTiempoRespuesta) AND nTiempoRespuesta!=0 ";
			if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
			$sql9.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
  			}
  			if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  			$sql9.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
  			}
  			if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
  			$sql9.=" AND Tra_M_Tramite.fFecRegistro BETWEEN  '$fDesde' and '$fHasta' ";
  			}
			$rs9=sqlsrv_query($cnx,$sql9);
			$total_svencido=sqlsrv_has_rows($rs9);
			echo $total_svencido;?>
    </td>
</tr>


</table>
			</fieldset>

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