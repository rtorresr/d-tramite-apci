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
</head>
<body>


	



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

<div class="AreaTitulo">HISTORIAL de MOVIMIENTOS DE Documentos</div>
<form name="form1" method="GET" action="iu_reporte_tramite_movimientos.php">
<table width="900" border="0" align="center">
  <tr>
    <td colspan="4">Criterios de Busqueda </td>
  </tr>
  <tr>
  	 <td width="45" >Evento:</td>
    <td width="256" ><? $sqlEve=" select  distinct cTipoEvento from Tra_M_Audit_Tramite "; 
	        
            $rsEve=sqlsrv_query($cnx,$sqlEve);
			?>
                                <select name="cTipoEvento" id="cTipoEvento"  />
     	                          <option value="">Seleccione:</option>
	                          <? while ($RsEve=sqlsrv_fetch_array($rsEve)){
	  	                          echo "<option value=".$RsEve[cTipoEvento]." ".$selecClas.">".$RsEve[cTipoEvento]."</option>";
                                 }
								 
                                 sqlsrv_free_stmt($rsEve);
                              ?>
            </select></td>
 
    <td width="94">Fecha Inicial:</td>
    <td width="84">
      <input type="text" readonly name="fDesde" style="width:75px" class="FormPropertDepen" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>">
    </td>
    <td width="60"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'yyyy-mm-dd',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div>  
    </td>  	
    <td width="95">Fecha Limite:</td>
    <td width="83">
      <input type="text" readonly name="fHasta" style="width:75px" class="FormPropertDepen" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>">
    </td> 
    <td width="149"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'yyyy-mm-dd',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div>
    </td>

  </tr>
  <tr>
    <td colspan="8">
      <input type="submit" name="Submit" value="Iniciar Busqueda" />
			<input type="button" value="Restablecer" name="inicio" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');">
			<input type="button" value="Rep. Excel" name="inicio" onClick="window.open('iu_reporte_tramite_movimientos_xls.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cTipoEvento=<?=$_GET['cTipoEvento']?>', '_self');">
			<input type="button" value="Rep. PDF" name="inicio" onClick="window.open('iu_reporte_tramite_movimientos_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cTipoEvento=<?=$_GET['cTipoEvento']?>', '_blank');">
			<input type="button" value="Ampliar Detalle" name="inicio" onClick="window.open('iu_reporte_tramite_movimientos.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?> rel="lyteframe" title="Detalle del Documento" rev="width: 950px; height: 400px; scrolling: auto; border:no"><?=$RsTra['cCodificacion']?>">
    </td>
  </tr>
</table>
</form>

<table class="table">

<?

require_once("../conexion/conexion.php");

  $fDesde=date("Ymd", strtotime($_GET['fDesde']));
	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
  $date_r = getdate(strtotime($date));
  $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
  return $date_result;
				}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia

$sql="SELECT * FROM Tra_M_Audit_Tramite_Movimientos ";
 
       if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
       	$sql.="WHERE Tra_M_Audit_Tramite_Movimientos.fFecEvento>'$fDesde' ";
       }
       if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
       	$sql.="WHERE Tra_M_Audit_Tramite_Movimientos.fFecEvento<='$fHasta' ";
       }
       if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
       	$sql.="WHERE Tra_M_Audit_Tramite_Movimientos.fFecEvento BETWEEN '$fDesde' AND '$fHasta' ";
       }
       $_GET['cTipoEvento'];
       if($_GET['cTipoEvento']!=""){
       $sql.=" WHERE cTipoEvento='".$_GET['cTipoEvento']."'";
       }
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
?>

<tr>
	<td class="headCellColum">Nro Evento</td>
	<td class="headCellColum">Tipo Evento</td>
	<td class="headCellColum">Fecha de Ocurrido</td>
	<td class="headCellColum">Usuario Responsable</td>
	<td class="headCellColum">Nro Movimiento</td>
	<td class="headCellColum">[iCodTramite]</td> 
  <td class="headCellColum">[iCodTrabajadorRegistro]</td>
  <td class="headCellColum">[nFlgTipoDoc]</td>
  <td class="headCellColum">[iCodOficinaOrigen]</td>
  <td class="headCellColum">[fFecRecepcion]</td>
  <td class="headCellColum">[iCodOficinaDerivar]</td>
  <td class="headCellColum">[iCodTrabajadorDerivar]</td> 
  <td class="headCellColum">[cCodTipoDocDerivar]</td>
  <td class="headCellColum">[iCodIndicacionDerivar]</td>
  <td class="headCellColum">[cAsuntoDerivar]</td>
  <td class="headCellColum">[cObservacionesDerivar]</td> 
  <td class="headCellColum">['fFecDerivar']</td>
  <td class="headCellColum">['iCodTrabajadorDelegado']</td>
  <td class="headCellColum">[iCodIndicacionDelegado]</td> 
  <td class="headCellColum">[cObservacionesDelegado]</td>
  <td class="headCellColum">[fFecDelegado]</td>
  <td class="headCellColum">[iCodTrabajadorFinalizar]</td>
  <td class="headCellColum">[cObservacionesFinalizar]</td>
  <td class="headCellColum">[fFecFinalizar]</td>
  <td class="headCellColum">[fFecMovimiento]</td> 
  <td class="headCellColum">['nEstadoMovimiento']></td>
  <td class="headCellColum">[nFlgEnvio]</td>
  <td class="headCellColum">[cFlgCopia]</td>
	</tr>
<?
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "no hay trabajadores registrados<br>";
}else{

while ($Rs=sqlsrv_fetch_array($rs)){
			if ($color == "#CEE7FF"){
			  $color = "#F9F9F9";
	    		}else{
			  $color = "#CEE7FF";
	    		}
	    		if ($color == ""){
			  $color = "#F9F9F9";
	    		}	
?>

<tr bgcolor="<?=$color?>">
    <td><?php echo $Rs[iCodEventoMovimiento];?></td>
    <td><?php echo $Rs[cTipoEvento];?></td>
    <td><?php echo $Rs[fFecEvento];?></td>
    <td><?php echo $Rs[usuario];?></td>
    <td><?php echo $Rs[iCodMovimiento];?></td>
    <td><?php echo $Rs[iCodTramite];?></td>
    <td><?php echo $Rs[iCodTrabajadorRegistro];?></td>
    <td><?php echo $Rs[nFlgTipoDoc];?></td>
    <td><?php echo $Rs[iCodOficinaOrigen];?></td>
    <td><?php echo $Rs[fFecRecepcion];?></td>
    <td><?php echo $Rs[iCodOficinaDerivar];?></td>
    <td><?php echo $Rs[iCodTrabajadorDerivar];?></td>
    <td><?php echo $Rs[cCodTipoDocDerivar];?></td>
    <td><?php echo $Rs[iCodIndicacionDerivar];?></td>
    <td><?php echo $Rs[cAsuntoDerivar];?></td>
    <td><?php echo $Rs[cObservacionesDerivar];?></td>
    <td><?php echo $Rs['fFecDerivar'];?></td>
    <td><?php echo $Rs['iCodTrabajadorDelegado'];?></td>
    <td><?php echo $Rs[iCodIndicacionDelegado];?></td>
    <td><?php echo $Rs[cObservacionesDelegado];?></td>
    <td><?php echo $Rs[fFecDelegado];?></td>
    <td><?php echo $Rs[iCodTrabajadorFinalizar];?></td>
    <td><?php echo $Rs[cObservacionesFinalizar];?></td>
    <td><?php echo $Rs[fFecFinalizar];?></td>
    <td><?php echo $Rs[fFecMovimiento];?></td>
    <td><?php echo $Rs['nEstadoMovimiento'];?></td>
    <td><?php echo $Rs[nFlgEnvio];?></td>
    <td><?php echo $Rs[cFlgCopia];?></td>
   </tr>
 
<?
}
}
?>
</table>
<table width="800" border="0" align="center">
  <tr>
    <td align="right"><?
/* echo "<a href='iu_nuevo_trabajador.php'>Nuevo Trabajador</a>"; */
?>
 					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

  
  
  
<div>		

<?php include("includes/userinfo.php");?>


</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>