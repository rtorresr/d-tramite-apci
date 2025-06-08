<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte General
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
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

<div class="AreaTitulo">Reporte de Documentos</div>



<form name="form1" method="GET" action="reporte.php">
<table width="900" border="0" align="center">
  <tr>
    <td colspan="4">Criterios de Busqueda </td>
  </tr>
  
  <tr>
    <td>Fecha Inicial:</td>
    <td><label>
      <input type="text" readonly name="fDesde" style="width:75px" class="FormPropertDepen" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>">
      <input type="button" value="..." style="width:22px" onclick="displayCalendar(document.forms[0].fDesde,'yyyy-mm-dd',this,false)">
    </label>
    </td>  	
    <td>Fecha Limite:</td>
    <td><label>
      <input type="text" readonly name="fHasta" style="width:75px" class="FormPropertDepen" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>">
      <input type="button" value="..." style="width:22px" onclick="displayCalendar(document.forms[0].fHasta,'yyyy-mm-dd',this,false)">
    </label>
    </td>

  </tr>
  <tr>
    <td colspan="4"> 
      <input type="submit" name="Submit" value="Iniciar Busqueda" />
			<input type="button" value="Restablecer" name="inicio" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');">
			<input type="button" value="Rep. Excel" name="inicio" onClick="window.open('reporte_xls.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>', '_self');">
			<input type="button" value="Rep. PDF" name="inicio" onClick="window.open('reporte_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>', '_blank');">
    </td>
  </tr>
</table>
</form>

<table class="table">

<?
//require_once("../models/ad_usuario.php");

$sql="SELECT [Tra_M_tramite].cCodificacion,[Tra_M_tramite].cNroDocumento,[Tra_M_Remitente].cNombre,[Tra_M_Remitente].cRepresentante,[Tra_M_tramite].fFecDocumento,[Tra_M_tramite].cAsunto ";
$sql.= " FROM [Tra_M_tramite] INNER JOIN [Tra_M_Remitente]  ON ([Tra_M_Remitente].iCodRemitente=[Tra_M_Tramite].iCodRemitente) ";
//$sql.= " GROUP BY iCodOficinaResponsable ";
if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
$sql.=" WHERE [Tra_M_tramite].fFecDocumento BETWEEN  '".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and '".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."' ";
}
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
?>

<tr>
	<td class="headCellColum">Nro Documento</td>
	<td class="headCellColum">Nro Referencia</td>
	<td class="headCellColum">Remitente</td> 
	<td class="headCellColum">Representante</td>
	<td class="headCellColum">Fecha Derivo</td>
	<td class="headCellColum">Asunto</td>
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
    <td><?php echo $Rs[cCodificacion];?></td>
    <td><?php echo $Rs['cNroDocumento'];?></td>
    <td><?php echo $Rs['cNombre'];?></td>
    <td><?php echo $Rs[cRepresentante];?></td>
    <td><?php echo $Rs['fFecDocumento'];?></td>
    <td><?php echo $Rs['cAsunto'];?></td>
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

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>