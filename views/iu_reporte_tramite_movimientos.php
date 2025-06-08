<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_reporte_tramite_movimientos.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de Remitentes para el Perfil Administrador 
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       12/11/2010   Creaci�n del programa.
 
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
<script Language="JavaScript">

function Buscar()
{
  document.frmTramiteMovimiento.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmTramiteMovimiento.submit();
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

<div class="AreaTitulo">HISTORIAL de MOVIMIENTOS DE Documentos</div>

        
<form name="frmTramiteMovimiento" method="GET" action="iu_reporte_tramite_movimientos.php">
<table width="900" border="0" align="center">
  <tr>
    <td colspan="4">Criterios de Busqueda </td>
  </tr>
  <tr>
  	 <td width="45" height="37"  >Evento:</td>
<td width="256" align="left"><? $sqlEve=" select  distinct cTipoEvento from Tra_M_Audit_Tramite "; 
	        
            $rsEve=sqlsrv_query($cnx,$sqlEve);
			?>
               <select name="cTipoEvento" id="cTipoEvento"  class="FormPropertReg form-control" />
     	        <option value="">Seleccione:</option>
	            <? while ($RsEve=sqlsrv_fetch_array($rsEve)){
			      if($RsEve["cTipoEvento"]==$_GET["cTipoEvento"]){
          			 $selecTipo="selected";
            	  }Else{
          			 $selecTipo="";
          		  }
          			 echo "<option value=".$RsEve["cTipoEvento"]." ".$selecTipo.">".$RsEve["cTipoEvento"]."</option>";
	  	          }
					sqlsrv_free_stmt($rsEve);
                ?>
            </select></td>
 
    <td width="94" >Fecha Inicial:</td>
    <td width="84">
      <input type="text" readonly name="fDesde"  class="FormPropertReg form-control" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:105px">
    </td>
    <td width="60"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div> 
    </td>  	
    <td width="95" >Fecha Limite:</td>
    <td width="83">
      <input type="text" readonly name="fHasta"  class="FormPropertReg form-control" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:105px">
    </td> 
    <td width="149"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div>
    </td>

  </tr>
  <tr>
    <td height="40" colspan="8"> 
    <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
    <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
              &nbsp;
    <button class="btn btn-primary" onclick="window.open('iu_reporte_tramite_movimientos_xls.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cTipoEvento=<?=$_GET['cTipoEvento']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							&nbsp;
    <button class="btn btn-primary" onclick="window.open('iu_reporte_tramite_movimientos_pdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cTipoEvento=<?=$_GET['cTipoEvento']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
	<? /*			 			&nbsp;
     <button class="btn btn-primary" onclick="window.open('iu_reporte_tramite_movimientos_detalle.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cTipoEvento=<?=$_GET['cTipoEvento']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>Ampliar Detalle</b>  </button>
							&nbsp;  */ ?>
    		
    </td>
  </tr>
</table>
</form>

<table width="1000" border="0" align="center">

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
$tampag = 15;
$reg1 = ($pag-1) * $tampag;

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
	   $sql.=" ORDER BY iCodEventoMovimiento DESC"; 
       $rs=sqlsrv_query($cnx,$sql);
 ////////
   $total = sqlsrv_has_rows($rs);
//echo $sql;
?>

<tr>
	<td class="headCellColum">Tipo Evento</td>
	<td class="headCellColum">Fecha de Ocurrido</td>
	<td class="headCellColum">Usuario Responsable</td>
	<td class="headCellColum">Nro Movimiento</td>
	<td class="headCellColum">Tramite</td> 
    <td class="headCellColum">Trabajador de Registro</td>
    <td class="headCellColum">Tipo de Documento</td>
    <td class="headCellColum">Oficina de Origen</td>
    <td class="headCellColum">Fecha de Recepcion</td>
    <td class="headCellColum">Oficina a Derivar</td>
    <td class="headCellColum">Trabajador a Derivar</td> 
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
 //while ($Rs=sqlsrv_fetch_array($rs))
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
    <td>
	<? 
	    echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs[fFecEvento]))."</div>";
	    echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs[fFecEvento]))."</div>";
    ?></td>
    <td><?php echo $Rs[usuario];?></td>
    <td><?php echo $Rs[iCodMovimiento];?></td>
    <td><?php echo $Rs[iCodTramite];?></td> 
    <td><?php echo $Rs[iCodTrabajadorRegistro];?></td>
    <td>
		<? 
		if($Rs[nFlgTipoDoc]==1)
    	{echo "Entradas";}
    	else if($Rs[nFlgTipoDoc]==2)
    	{echo "Internos";}
		else if($Rs[nFlgTipoDoc]==3)
    	{echo "Salidas";}
		else if($Rs[nFlgTipoDoc]==4)
    	{echo "Anexo";}	
		?></td>
    <td>
		<? 
			$sqlOfi="SELECT cNomOficina FROM Tra_M_Oficinas WHERE  iCodOficina='$Rs[iCodOficinaOrigen]'";
			$rsOfi=sqlsrv_query($cnx,$sqlOfi);
			$RsOfi=sqlsrv_fetch_array($rsOfi);
			echo $RsOfi[cNomOficina];
		?></td>
    <td><? 
	    echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs[fFecRecepcion]))."</div>";
		echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs[fFecRecepcion]))."</div>"; 
	?></td>
    <td>
		<? 
			$sqlDes="SELECT cNomOficina FROM Tra_M_Oficinas WHERE  iCodOficina='$Rs[iCodOficinaDerivar]'";
			$rsDes=sqlsrv_query($cnx,$sqlDes);
			$RsDes=sqlsrv_fetch_array($rsDes);
			echo $RsDes[cNomOficina];
		?></td>
    <td><?php echo $Rs[iCodTrabajadorDerivar];?></td> 
</tr>
 
<?
}
}
?>
 <tr>
		<td colspan="11" align="center">
   <?php echo paginar($pag, $total, $tampag, "iu_reporte_movimientos.php?cTipoEvento=".$_GET[cTipoEvento]."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&pag=");
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

  
 </td>
  </tr>
	</table>

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