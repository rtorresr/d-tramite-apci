<?php
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
function Activar(){
document.frmConsultaEntrada.cReferenciaPCM.disabled = (document.frmConsultaEntrada.activar.checked) ? false : true;
document.frmConsultaEntrada.cNroDocumento.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.cReferencia.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.cAsunto.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.cCodificacion.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.cNombre.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.iCodOficina.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.iCodTupa.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.fDesde.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
document.frmConsultaEntrada.fHasta.disabled = (document.frmConsultaEntrada.activar.checked) ? true : false;
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

<div class="AreaTitulo">Consulta >> Prestamo </div>

	<table cellpadding="0" cellspacing="0" border="0" width="960"><tr><td><?php // ini table por fieldset ?>
				<fieldset><legend>Criterios de Búsqueda:</legend>

							<form name="frmConsultaEntrada" method="GET" action="consultaEntradaGeneral.php">
						<tr>
							<td width="110" >Numero de documento :</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57 || event.keyCode == 47 || event.keyCode == 46  ) event.returnValue = false;" ></td>
							
							<td width="110" >Desde:</td>
							<td align="left">
								<table cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
    									<?php
												if(trim($_REQUEST[fHasta])==""){$fecfin = date("d-m-Y 23:59");}  else { $fecfin = $_REQUEST[fHasta]; }
												if(trim($_REQUEST[fDesde])==""){$fecini = date("01-m-Y 00:00");} else { $fecini = $_REQUEST[fDesde]; }
											?>
											<input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:105px" class="FormPropertReg form-control">
										</td>
										<td>
                    	<div class="boton" style="width:24px;height:20px">
                    		<a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy hh:ii',this,true)">
                    			<img src="images/icon_calendar.png" width="22" height="20" border="0">
                    		</a>
                    	</div>
                    </td>
										<td width="20"></td>
										<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:105px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
						</tr>
					
                                
				
                   
						<tr>
                         
						<td colspan="4" align="right">
            	<!-- <table width="400" border="0" align="left">
              	<tr>
                	<td align="left">
                  	Descargar &nbsp; <img src="images/icon_download.png" width="16" height="16" border="0" > &nbsp; &nbsp;
	                          | &nbsp; &nbsp;  Edición &nbsp; <i class="fas fa-edit"></i>&nbsp;&nbsp;
                              | &nbsp; &nbsp; Anexos&nbsp; <img src="images/icon_anexo.png" width="16" height="16" border="0">&nbsp;&nbsp;                           </td>
                           </tr>
              </table> -->
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
                            
                            <!--button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button-->
                            
						</tr>
							</form>

</form>



<?
function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
$total_paginas = ceil($total/$por_pagina);
$anterior = $actual - 1;
$posterior = $actual + 1;
$minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
$maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
if ($actual>1)
$texto = "<a href=\"$enlace$anterior\"> << </a> ";
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
$texto .= "<a href=\"$enlace$posterior\"> >> </a>";
else
$texto .= "<b>>></b>";
return $texto;
}


if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
$tampag = 20;
$reg1 = ($pag-1) * $tampag;

// ordenamiento
if($_GET['campo']==""){
	$campo="Fecha";
}Else{
	$campo=$_GET['campo'];
}

if($_GET['orden']==""){
	$orden="DESC";
}Else{
	$orden=$_GET['orden'];
}

//invertir orden
if($orden=="ASC") $cambio="DESC";
if($orden=="DESC") $cambio="ASC";

 
  if($_GET[cReferenciaPCM]!=""  && $fecini=="" && $fecfin=="" && $_GET['cCodificacion']=="" && $_GET['iCodOficina']=="" &&  $_GET['cAsunto']=="" && $_GET[cReferencia]=="" && $_GET['iCodTupa']=="" && $_GET['cNombre']=="" && $_GET[iCodTrabajadoResponsable]=="" && $_GET['cNroDocumento']=="" && $_GET[cNomRemite]==""){
    /*$sqlpcm="SELECT * FROM Tra_M_Tramite ";
    $sqlpcm.=" WHERE (Tra_M_Tramite.nFlgTipoDoc=3) ";
    $sqlpcm.="AND Tra_M_Tramite.cCodificacion LIKE '%$_GET[cReferenciaPCM]%' ";
 	$sqlpcm.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
	$sqlpcm.="AND cReferencia IS NOT NULL AND cReferencia!='' "; */
	$sqlpcm="select * from T_MAE_PRESTAMO";
    $rspcm=sqlsrv_query($cnx,$sqlpcm);
	$salida = sqlsrv_has_rows($rspcm); $cont=0;
	if($salida != 0 ){
	 $sqlcod="SELECT TOP 100 * FROM Tra_M_Tramite ";
	 $sqlcod.=" WHERE (Tra_M_Tramite.nFlgTipoDoc=1) AND ( ";
    while($Rspcm=sqlsrv_fetch_array($rspcm)){
	 $cont=$cont+1;
	 $cadena.=" Tra_M_Tramite.cCodificacion = '$Rspcm[cReferencia]' ";
	 if($cont < $salida){ $cadena.=" OR  "; }
     }
	  $sqlcod.=" $cadena";
	  $sqlcod.=" ) ";
	  $rs=sqlsrv_query($cnx,$sqlcod);
	 }

	else if($salida == 0 )  {
	 $sqlcod="select * from T_MAE_PRESTAMO ";
	 $rs=sqlsrv_query($cnx,$sqlcod);
	} 
   }
    

  
  
  if($_GET[cReferenciaPCM]=="" or $fecini!="" or $fecfin!="" or $_GET['cCodificacion']!="" or $_GET['iCodOficina']!=""  or $_GET['cAsunto']!="" or $_GET[cReferencia]!="" or $_GET['iCodTupa']!="" or $_GET['cNombre']!="" or $_GET[iCodTrabajadoResponsable]!="" or $_GET['cNroDocumento']!="" or $_GET[cNomRemite]!=""){

	if($fecini!=''){$fecini=date("Ymd G:i", strtotime($fecini));}
    if($fecfin!=''){
    $fecfin=date("Y-m-d G:i", strtotime($fecfin));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd G:i", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fecfin=dateadd($fecfin,0,0,0,0,0,0); // + 1 dia
	}
	 if($_GET['iCodOficina']!=""){$opcion="op2";} else {$opcion="";}
      
      
        // consulta orginal y lista los prestamos
        // consulta orginal y lista los prestamos
	$sql.= "select * from T_MAE_PRESTAMO";	
    if($_GET['cCodificacion']!=''){
        $sql.=" where cod_documento='".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."'";
    }else{
        if($_GET['fDesde']!='' and $_GET['fHasta']!=''){
            $sql.=" where (fecha_solicitud>='".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and fecha_solicitud<='".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."')";
        }else{
            $sql.="";
        }
        
    }
      $sql.=" order by fecha_solicitud desc";
    $rs=sqlsrv_query($cnx,$sql);
      
  }
    //echo $sql;
   ////////
   $total = sqlsrv_has_rows($rs);
    
    function fechas($fecha){
        $a=explode(" ",$fecha);
        $b=$a[0];
        return $b;
    }

    

    $sql1= "select * from T_MAE_PRESTAMO";	
    if($_GET['cCodificacion']!=''){
        $sql1.=" where cod_documento='".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."' and";
    }else{
        if($_GET['fDesde']!=''){
            $sql1.=" where (fecha_solicitud>='".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and fecha_solicitud<='".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."')";
        }
    }
    $sql1.=" order by fecha_solicitud desc";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    //echo $sql1;
    ?>
    <table width="100%" border="0" cellpadding="3" cellspacing="3" align="center">
    <tr>
        <td width="10%" class="headCellColum"> Codigo / Oficina </td>
        <td width="20%" class="headCellColum">Fecha de solicitud / Fecha de entrega</td> 
        <td width="20%" class="headCellColum"> Documento solicitado / Remitente</td>
        <td width="50%" class="headCellColum">Asunto</td>
        <td width="10%" class="headCellColum">Fech. ingreso del documento</td>
        <td width="10%" class="headCellColum">Estado </td>
    </tr>
    <?php
    $coo=0;
    do{
        $coo+=1;
        if($coo%2==0){
            $color="#f0f0f0";
        }else{
            $color="";
        }
    ?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'">
        <td>
        <b>Codigo</b>
        <br>
        <?php echo $rs[codigo];?>
        <hr>
        <b>Oficina</b>
        <br>
         <?php
        $sqlx1= "select * from Tra_M_Oficinas where iCodOficina='$rs[oficina_solicitante]'";
        $queryx1=sqlsrv_query($cnx,$sqlx1);
        $rsx1=sqlsrv_fetch_array($queryx1);
        do{
            echo $rsx1['cNomOficina'];
        }while($rsx1=sqlsrv_fetch_array($queryx1));
    ?>
        </td>
        <td><b>Fecha de solicitud </b><br><?php echo fechas($rs[fecha_solicitud]);?>	
        <hr><b>Fecha de entrega</b><br><?php echo fechas($rs[fecha_entrega]);?></td>
        <td>
        <b>Documento solicitado</b><br>
        <?php echo $rs[cod_documento];?>	
        <hr>
        <b>Remiteente</b>
        <br>
        <?php 
        $sqlx= "select 
            cCodificacion,
            (select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodRemitente) as iCodRemitentex,
            cAsunto,fFecRegistro
            ,* from Tra_M_Tramite m
            where iCodTramite='$rs[icodtramite]'";
        $queryx=sqlsrv_query($cnx,$sqlx);
        $rsx=sqlsrv_fetch_array($queryx);

        do{
            echo $rsx['iCodRemitentex'];
        }while($rsx=sqlsrv_fetch_array($queryx));
        ?> 
        </td>

        <td>
        
        <?php 
        $sqlx= "select 
            cCodificacion,
            (select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodRemitente) as iCodRemitentex,
            cAsunto,fFecRegistro
            ,* from Tra_M_Tramite m
            where iCodTramite='$rs[icodtramite]'";
        $queryx=sqlsrv_query($cnx,$sqlx);
        $rsx=sqlsrv_fetch_array($queryx);

        do{
            echo $rsx['cAsunto'];
        }while($rsx=sqlsrv_fetch_array($queryx));
        ?> 
        
        </td>
        <td>
        
        <?php 
        $sqlx= "select 
            cCodificacion,
            (select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodRemitente) as iCodRemitentex,
            cAsunto,fFecRegistro
            ,* from Tra_M_Tramite m
            where iCodTramite='$rs[icodtramite]'";
        $queryx=sqlsrv_query($cnx,$sqlx);
        $rsx=sqlsrv_fetch_array($queryx);

        do{
            echo fechas($rsx['fFecRegistro']);
        }while($rsx=sqlsrv_fetch_array($queryx));
        ?> 
        
        </td>
        <td><?php 
            if($rs[Cod_estado_prestamo]==1){
                echo "Pendiente";
            }else{
                echo "<font color='green'><b>Entregado</b></font>";
            }
            ?>	</td>
    </tr>
    <?php
    }while($rs=sqlsrv_fetch_array($query));
?>
   <tr>
		<td colspan="6" align="center">
         <?php echo paginar($pag, $total, $tampag, "consultaEntradaGeneral.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&iCodOficina=".$_GET['iCodOficina']."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&iCodTupa=".$_GET['iCodTupa']."&cNombre=".$_GET['cNombre']."&iCodTrabajadoResponsable=".$_GET[iCodTrabajadoResponsable]."&cNroDocumento=".$_GET['cNroDocumento']."&cNomRemite=".$_GET[cNomRemite]."&pag=");
			//Página 1 <a href="javascript:;">2</a> <a href="javascript:;">3</a> <a href="javascript:;">4</a> <a href="javascript:;">5</a>
		 ?>	
		</td>
		</tr>
    </table>
<br>



 <!--tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
    <td valign="top" align="center">
    	<?php echo $Rs[codigo];?>	
    </td>
    <td valign="top" align="left"> 
    <?php
        $sql= "select * from Tra_M_Oficinas where iCodOficina='$Rs[oficina_solicitante]'";
        $query=sqlsrv_query($cnx,$sql);
        $rs=sqlsrv_fetch_array($query);
        do{
            echo $rs['cNomOficina'];
        }while($rs=sqlsrv_fetch_array($query));
    ?>
     </td>
    <td valign="top" align="left"> <?php echo $Rs[fecha_solicitud];?> </td> 
    <td valign="top" align="center"> <?php echo $Rs[fecha_entrega];?> </td>
    <td valign="top" align="left"> <?php echo $Rs[cod_documento];?> </td>
    <td valign="top"> 
        <?php 
        $sql= "select 
            cCodificacion,
            (select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodRemitente) as iCodRemitentex,
            cAsunto,fFecRegistro
            ,* from Tra_M_Tramite m
            where iCodTramite='$Rs[icodtramite]'";
        $query=sqlsrv_query($cnx,$sql);
        $rs=sqlsrv_fetch_array($query);

        do{
            echo $rs['iCodRemitentex'];
        }while($rs=sqlsrv_fetch_array($query));
        ?> 
    </td>
    <td valign="top">  <?php 
        $sql= "select 
            cCodificacion,
            (select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodRemitente) as iCodRemitentex,
            cAsunto,fFecRegistro
            ,* from Tra_M_Tramite m
            where iCodTramite='$Rs[icodtramite]'";
        $query=sqlsrv_query($cnx,$sql);
        $rs=sqlsrv_fetch_array($query);

        do{
            echo $rs['cAsunto'];
        }while($rs=sqlsrv_fetch_array($query));
        ?>  </td>
    <td valign="top"> 
      <?php 
        $sql= "select 
            cCodificacion,
            (select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodRemitente) as iCodRemitentex,
            cAsunto,fFecRegistro
            ,* from Tra_M_Tramite m
            where iCodTramite='$Rs[icodtramite]'";
        $query=sqlsrv_query($cnx,$sql);
        $rs=sqlsrv_fetch_array($query);

        do{
            echo $rs['fFecRegistro'];
        }while($rs=sqlsrv_fetch_array($query));
        ?> 
     </td>
    <td valign="top">
     <?php
         if($Rs[Cod_estado_prestamo]==1){
             echo "Pendiente";
         }else{
             echo "";
         }
     ?>
     </td>
</tr-->
    
     


    </td>
	  </tr>
		</table>
  


<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>