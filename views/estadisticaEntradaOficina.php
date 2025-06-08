<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: estadisticaEntradaOficina.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta Estadistica de los Documentos Pendientes,En Proceso y Finalizados por Oficinas
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

<div class="AreaTitulo">Estadisticas - Documentos de Entrada Oficina</div>




							<form name="frmConsultaEntrada" method="GET" action="consultaEntradaGeneral.php">
						<tr>
							<td colspan="4" >
							  <table border="0" align="center" cellpadding="0" cellspacing="0"><tr>
							    <td>Desde:&nbsp;<input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
							    <td width="20"></td>
							    <td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
							    </tr></table>						    </td>
							</tr>
						<tr>
							<td width="360"  >Oficina:</td>
							<td colspan="3" align="left" ><select name="iCodOficina" class="FormPropertReg form-control"  />
							  <option value="">Seleccione:</option>
							  	<?
	                $sqlOfi="SP_OFICINA_LISTA_COMBO "; 
                  $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodOficina"]==$_GET['iCodOficina']){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                  }
                  sqlsrv_free_stmt($rsOfi);
                  ?>
						  </select></td>
							</tr>
						<tr>
						  <td colspan="4"   align="center">
                          <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
                           <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
                          </td>
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
	<td width="174" class="headCellColum">DERIVADOS</td>
	<td width="174" class="headCellColum">FINALIZADOS</td>
	<td width="188" class="headCellColum">TOTALES</td>
  	</tr>
    <tr>
    <td colspan="7" bgcolor="#CCCCCC" >    </td>
    </tr>
    <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada con TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	           <? $sql1=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			      $sql1.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql1.=" WHERE fFecRecepcion IS  NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=1 AND iCodTupa IS NOT NULL ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql1.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs1=sqlsrv_query($cnx,$sql1);
				  $pendientes_ctupa=sqlsrv_has_rows($rs1);
			  	  echo $pendientes_ctupa;?>                        </td>
    <td valign="top" align="center">
    	       <? $sql2=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			      $sql2.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql2.=" WHERE fFecRecepcion IS NOT NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=1 AND iCodTupa IS NOT NULL 	 ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql2.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs2=sqlsrv_query($cnx,$sql2);
				  $proceso_ctupa=sqlsrv_has_rows($rs2);
			  	  echo $proceso_ctupa;?>    </td> 
    <td valign="top" align="center">
               <? $sql3=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			      $sql3.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql3.=" WHERE fFecRecepcion IS NOT NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=2 AND iCodTupa IS NOT NULL 	 ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql3.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs3=sqlsrv_query($cnx,$sql3);
				  $derivado_ctupa=sqlsrv_has_rows($rs3);
			  	  echo $derivado_ctupa;?></td>
    <td valign="top" align="center">
    	      <?  $sql4=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento,fFecRecepcion,fFecFinalizar  ";
			      $sql4.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql4.=" WHERE fFecRecepcion IS NOT NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=4 AND iCodTupa IS NOT NULL ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql4.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs4=sqlsrv_query($cnx,$sql4);
				  $finalizados_ctupa=sqlsrv_has_rows($rs4);
			  	  echo $finalizados_ctupa;?>		</td>
    <td valign="top" align="center">
    	<?   $total_ctupa=	$pendientes_ctupa + $proceso_ctupa + $derivado_ctupa + $finalizados_ctupa;
		     echo $total_ctupa;
    	?>    </td>
</tr>
  <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada sin TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	           <? $sql5=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			      $sql5.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql5.=" WHERE fFecRecepcion IS  NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=1 AND iCodTupa IS NULL ";
				 if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql5.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs5=sqlsrv_query($cnx,$sql5);
				  $pendientes_stupa=sqlsrv_has_rows($rs5);
			  	  echo $pendientes_stupa;?>       </td>
    <td valign="top" align="center">
    	       <? $sql6=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			      $sql6.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql6.=" WHERE fFecRecepcion IS NOT NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=1 AND iCodTupa IS NULL 	 ";
				 if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql6.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs6=sqlsrv_query($cnx,$sql6);
				  $proceso_stupa=sqlsrv_has_rows($rs6);
			  	  echo $proceso_stupa;?>    </td> 
    <td valign="top" align="center"> 
	           <? $sql7=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			      $sql7.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql7.=" WHERE fFecRecepcion IS NOT NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=2 AND iCodTupa IS NOT NULL 	 ";
				 if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql7.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs7=sqlsrv_query($cnx,$sql7);
				  $derivado_stupa=sqlsrv_has_rows($rs7);
			  	  echo $derivado_stupa;?></td>
    <td valign="top" align="center">
    	      <?  $sql8=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento,fFecRecepcion,fFecFinalizar  ";
			      $sql8.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  ";
				  $sql8.=" WHERE fFecRecepcion IS NOT NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=4 AND iCodTupa IS NULL ";
				  if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
				  $sql8.=" AND iCodOficinaDerivar='$_GET['iCodOficina']' order by Tra_M_Tramite_Movimientos.iCodTramite DESC ";
				  $rs8=sqlsrv_query($cnx,$sql8);
				  $finalizados_stupa=sqlsrv_has_rows($rs8);
			  	  echo $finalizados_stupa;?>		</td>
    <td valign="top" align="center">
    	<?   $total_stupa=	$pendientes_stupa + $proceso_stupa + $derivado_stupa + $finalizados_stupa;
		     echo $total_stupa;
    	?>    					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

			</fieldset>

<br>
<br>
<?   /*
    	

			<fieldset><legend>DOCUMENTOS VENCIDOS</legend>
<table width="1000" border="0" cellpadding="3" cellspacing="0" align="center">
<tr>
	<td width="244" class="headCellColum"> </td>
    <td width="1" bgcolor="#CCCCCC"></td>
	<td width="237" class="headCellColum">SILENCIO ADM. ( + )</td>
	<td width="244" class="headCellColum">SILENCIO ADM. ( - )</td> 
	<td width="244" class="headCellColum">TOTAL VENCIDOS.</td>
	</tr>
    <tr>
    <td colspan="5" bgcolor="#CCCCCC" >
    
    </td>
    </tr>
    <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada con TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	        <? 		      
			 $sql9=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,fFecRegistro,nTiempoRespuesta,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			 $sql9.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  , Tra_M_Tupa ";
			 $sql9.=" WHERE Tra_M_Tramite.iCodTupa=Tra_M_Tupa.iCodTupa AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=1 AND Tra_M_Tramite.iCodTupa IS NOT NULL ";
			 $sql9.=" AND DATEDIFF(DAY, fFecRegistro, GETDATE()) > nTiempoRespuesta  AND iCodOficinaDerivar='$_GET['iCodOficina']' AND nSilencio=1 ";
			 if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
			 $sql9.=" ORDER BY Tra_M_Tramite_Movimientos.iCodTramite DESC ";
			 $rs9=sqlsrv_query($cnx,$sql9);
			 $vencido_p1=sqlsrv_has_rows($rs9);
				  
		     $sql10=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,fFecRegistro,nTiempoRespuesta,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			 $sql10.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  , Tra_M_Tupa ";
			 $sql10.=" WHERE  Tra_M_Tramite.iCodTupa=Tra_M_Tupa.iCodTupa AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=4 AND Tra_M_Tramite.iCodTupa IS NOT NULL  ";
			 $sql10.=" AND DATEDIFF(DAY, fFecRegistro, fFecFinalizar) > nTiempoRespuesta  AND iCodOficinaDerivar='$_GET['iCodOficina']' AND nSilencio=1 ";
			 if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
			 $sql10.=" ORDER BY Tra_M_Tramite_Movimientos.iCodTramite DESC ";
			 $rs10=sqlsrv_query($cnx,$sql10);
			 $vencido_p2=sqlsrv_has_rows($rs10);
			
			 $vencido_positivo = $vencido_p1 + $vencido_p2 ;
			 echo $vencido_positivo;?>
                        </td>
    <td valign="top" align="center">
    	  <?  
			 $sql11=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,fFecRegistro,nTiempoRespuesta,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			 $sql11.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  , Tra_M_Tupa ";
			 $sql11.=" WHERE Tra_M_Tramite.iCodTupa=Tra_M_Tupa.iCodTupa AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=1 AND Tra_M_Tramite.iCodTupa IS NOT NULL ";
			 $sql11.=" AND DATEDIFF(DAY, fFecRegistro, GETDATE()) > nTiempoRespuesta  AND iCodOficinaDerivar='$_GET['iCodOficina']' AND nSilencio=0 ";
			 if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
			 $sql11.=" ORDER BY Tra_M_Tramite_Movimientos.iCodTramite DESC ";
			 $rs11=sqlsrv_query($cnx,$sql11);
			 $vencido_n1=sqlsrv_has_rows($rs11);
				  
		     $sql12=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,fFecRegistro,nTiempoRespuesta,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento ";
			 $sql12.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite  , Tra_M_Tupa ";
			 $sql12.=" WHERE  Tra_M_Tramite.iCodTupa=Tra_M_Tupa.iCodTupa AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=4 AND Tra_M_Tramite.iCodTupa IS NOT NULL  ";
			 $sql12.=" AND DATEDIFF(DAY, fFecRegistro, fFecFinalizar) > nTiempoRespuesta  AND iCodOficinaDerivar='$_GET['iCodOficina']' AND nSilencio=0 ";
			 if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
                  }
                  if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
                  }
                  if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
  	              $sql.=" AND Tra_M_Tramite.fFecRegistro BETWEEN '$fDesde' AND '$fHasta' ";
                  }	
			 $sql12.=" ORDER BY Tra_M_Tramite_Movimientos.iCodTramite DESC ";
			 $rs12=sqlsrv_query($cnx,$sql12);
			 $vencido_n2=sqlsrv_has_rows($rs12);
			
			 $vencido_negativo = $vencido_n1 + $vencido_n2 ;
			 echo $vencido_negativo;?>
    </td> 
    <td valign="top" align="center">
    	<?   $total_vencido= $vencido_positivo + $vencido_negativo;
		     echo $total_vencido;
    	?>
    </td>
</tr>
  <tr>
    <td valign="top" align="center"><strong>Documentos de Entrada sin TUPA</strong></td>
    <td bgcolor="#CCCCCC"></td>
    <td valign="top" align="center">
	           <? $sql13=" SELECT Tra_M_Tramite_Movimientos.iCodTramite,iCodTupa,iCodTupaClase,Tra_M_Tramite_Movimientos.nFlgTipoDoc,nEstadoMovimiento,fFecRecepcion,fFecFinalizar ";
			      $sql13.=" FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Tramite ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite ";
				  $sql13.=" WHERE fFecRecepcion IS  NULL AND Tra_M_Tramite_Movimientos.nFlgTipoDoc=1 AND nEstadoMovimiento=1 AND iCodTupa IS NULL ";
				  $rs13=sqlsrv_query($cnx,$sql13);
				  $pendientes_stupa=sqlsrv_has_rows($rs13);
			  	  echo $pendientes_stupa;?>
       </td>
    <td valign="top" align="center">
    	       <?php echo " - ";?>
    </td> 
    <td valign="top" align="center">
    	  <?   echo " - ";?>
    </td>
</tr>


</table>
			</fieldset>

            */ ?>   
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