<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
<!--
function Buscar()
{
  document.form1.action="<?=$_SERVER['PHP_SELF']?>";
  document.form1.submit();
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

<div class="AreaTitulo">HISTORIAL de Documentos Ingresados</div>

<form name="form1" method="GET" action="iu_reporte_tramite.php">

       <table width="900" border="0" align="center">
       <tr>
  	 <td width="45" height="47"  >Evento:</td>
<td width="256" ><? $sqlEve=" select  distinct cTipoEvento from Tra_M_Audit_Tramite "; 
	                $rsEve=sqlsrv_query($cnx,$sqlEve);
			     ?>
                    <select name="cTipoEvento" class="FormPropertReg form-control" />
     	            <option value="">Seleccione:</option>
	            <?  while ($RsEve=sqlsrv_fetch_array($rsEve)){
				    if($RsEve["cTipoEvento"]==$_GET[cTipoEvento]){
          		    $selecClas="selected";
          	        } Else{
          		    $selecClas="";
          	        }
	  	            echo "<option value=".$RsEve[cTipoEvento]." ".$selecClas.">".$RsEve[cTipoEvento]."</option>";
                    }
				    sqlsrv_free_stmt($rsEve);
                              ?>
            </select></td>
    <td width="94" >Fecha Inicial:</td>
    <td width="84">
      <input type="text" readonly name="fDesde" style="width:75px" class="FormPropertReg form-control" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>">
    </td>
    <td width="60"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'yyyy-mm-dd',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div>  
    </td>  	
    <td width="95" >Fecha Limite:</td>
    <td width="83">
      <input type="text" readonly name="fHasta" style="width:75px" class="FormPropertReg form-control" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>">
    </td> 
    <td width="149"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'yyyy-mm-dd',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div>
    </td>

  </tr>
  <tr>
    <td colspan="8">
      <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							�
                           <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
                             �
							<button class="btn btn-primary" onclick="window.open('iu_reporte_tramite_xls.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cTipoEvento=<?=$_GET['cTipoEvento']?>&trab=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('iu_reporte_tramite_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cTipoEvento=<?=$_GET['cTipoEvento']?>&trab=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
    </td>
  </tr>
</table>
 </fieldset>
  </td>
 </tr>
</table>
</form>



<?

function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
$total_paginas = ceil($total/$por_pagina);
$anterior = $actual - 1;
$posterior = $actual + 1;
$minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
$maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
if ($actual>1)
$texto = "<a href=\"$enlace$anterior\">�</a> ";
else
$texto = "<b>�</b> ";
if ($minimo!=1) $texto.= "... ";
for ($i=$minimo; $i<$actual; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
$texto .= "<b>$actual</b> ";
for ($i=$actual+1; $i<=$maximo; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
if ($maximo!=$total_paginas) $texto.= "... ";
if ($actual<$total_paginas)
$texto .= "<a href=\"$enlace$posterior\">�</a>";
else
$texto .= "<b>�</b>";
return $texto;
}


if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
$tampag = 50;
$reg1 = ($pag-1) * $tampag;

	$fDesde=date("Ymd", strtotime($_GET['fDesde']));
	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
  $date_r = getdate(strtotime($date));
  $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
  return $date_result;
				}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia


$sql="SELECT TOP(3000) * FROM Tra_M_Audit_Tramite ";
$sql.=" WHERE iCodEventoTramite > 0 ";
       if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
       	$sql.="AND Tra_M_Audit_Tramite.fFecEvento>'$fDesde' ";
       }
       if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
       	$sql.="AND Tra_M_Audit_Tramite.fFecEvento<='$fHasta' ";
       }
       if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
       	$sql.="AND Tra_M_Audit_Tramite.fFecEvento BETWEEN '$fDesde' AND '$fHasta' ";
       }
       $_GET['cTipoEvento'];
       if($_GET['cTipoEvento']!=""){
       $sql.=" AND cTipoEvento='".$_GET['cTipoEvento']."' ";
        }
	   $sql.=" ORDER BY iCodEventoTramite DESC ";	
       $rs=sqlsrv_query($cnx,$sql);
	////////
    $total = sqlsrv_has_rows($rs);
   //echo $sql;
       //echo $sql;
?>
<table width="1000" border="0" align="center">
<tr>
	<td class="headCellColum">Tipo Evento</td>
	<td class="headCellColum">Fecha de Ocurrido</td>
	<td class="headCellColum">Usuario Responsable</td>
	
	<?php //<td class="headCellColum">Nro Tramite</td>?>
	 <td class="headCellColum">Tipo de Registro</td>
	 
	<td class="headCellColum">Codigo de Registro</td>
	<td class="headCellColum">Registrado por Trabajador:</td>
	<td class="headCellColum">Tipo Documento</td>
	
	<?php // <td class="headCellColum">['fFecDocumento']</td>?>
	
	<td class="headCellColum">Numero de Documento</td>
	
	<td class="headCellColum">Remitente</td> 
	
<? /*	 <td class="headCellColum">['cAsunto']</td>
  <td class="headCellColum">[cObservaciones]</td>
	<td class="headCellColum">[cReferencia]</td>
	<td class="headCellColum">[iCodIndicacion]</td>
	<td class="headCellColum">[nNumFolio]</td>
	<td class="headCellColum">[nTiempoRespuesta]</td> 
	<td class="headCellColum">[nFlgEnvio]</td>
	<td class="headCellColum">[fFecPlazo]</td>
	<td class="headCellColum">[nFlgRespuesta]</td>
	<td class="headCellColum">[[iCodTupaClase]</td> */?>
	
	<td class="headCellColum">Fecha de Registro</td>
	<? /* <td class="headCellColum">[nCodBarra]</td> 
	<td class="headCellColum">[cPassword]</td> 
	<td class="headCellColum">[nFlgEstado]</td>
	<td class="headCellColum">[nFlgAnulado]</td> */?>
	</tr>
<?
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
        echo "TOTAL DE REGISTROS : ".$numrows;
///////////////////////////////////////////////////////
for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
sqlsrv_fetch_array($rs, $i);
$Rs=sqlsrv_fetch_array($rs);
///////////////////////////////////////////////////////
//while ($Rs=sqlsrv_fetch_array($rs)){
			if ($color == "#CEE7FF"){
			  $color = "#F9F9F9";
	    		}else{
			  $color = "#CEE7FF";
	    		}
	    		if ($color == ""){
			  $color = "#F9F9F9";
	    		}	
?>

<tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
    <td><?php echo $Rs[cTipoEvento];?></td>
    <td><?php echo date("d-m-Y", strtotime($Rs[fFecEvento]));?></td>
    <td><?php echo $Rs[usuario];?></td>
    <td><? 
    	if($Rs['iCodTupa']=="" && $Rs[iCodTupaClase]=="" && $Rs[nFlgTipoDoc]=="1")
    	{echo "Externos, sin Tupa";}
    	if($Rs['iCodTupa']!="" && $Rs[iCodTupaClase]!="" && $Rs[nFlgTipoDoc]=="1")
    	{echo "Externos, con Tupa";}
    	if($Rs[nFlgTipoDoc]=="2")
    	{echo "Internos";}
		if($Rs[nFlgTipoDoc]=="3")
    	{echo "Salidas";}
		if($Rs[nFlgTipoDoc]=="4")
    	{echo "Anexo";}
    	?> 
    
 
    <td><?php echo $Rs[cCodificacion];?></td>
    <td><? 
    	$sqlTrab="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
    	$rsTrab=sqlsrv_query($cnx,$sqlTrab);
    	$RsTrab=sqlsrv_fetch_array($rsTrab);
    	echo $RsTrab[cApellidosTrabajador].", ".$RsTrab[cNombresTrabajador];
    	?>
    </td>
    <td><? 
    	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$Rs[cCodTipoDoc]'";
    	$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
    	$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
    	echo $RsTipDoc['cDescTipoDoc'];
      ?>    
    <td><?php echo $Rs['cNroDocumento'];?></td>
    <td><? 
    	$sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
    	$rsRemi=sqlsrv_query($cnx,$sqlRemi);
    	$RsRemi=sqlsrv_fetch_array($rsRemi);
    	echo $RsRemi['cNombre'];?></td>
        
    
    <td><?php echo date("d-m-Y", strtotime($Rs['fFecRegistro']));?></td>
    
    
   </tr>
  
<?
}
}
?>
<tr>
		<td colspan="10" align="center">
         <?php echo paginar($pag, $total, $tampag, "iu_reporte_tramite.php?cTipoEvento=".$_GET[cTipoEvento]."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&pag=");
			//P�gina 1 <a href="javascript:;">2</a> <a href="javascript:;">3</a> <a href="javascript:;">4</a> <a href="javascript:;">5</a>
		 ?>	
		</td>
		</tr>
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