<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php"); ?>

<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>

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
                    <div class="card-header text-center "> Consulta >> Tr&aacute;mites Pendientes (L) </div>
                    <!--Card content-->
                    <div class="card-body">
					<legend>Acciones:</legend>
                    <button class="btn btn-primary" onclick="window.open('reporteTramitesPendientes_xls.php','_self'); return false;"
                                    onMouseOver="this.style.cursor='hand'">
                       <b>a Excel</b><img src="images/icon_excel.png" width="17" height="17" border="0">
                    </button>
					<button class="btn btn-primary" onclick="window.open('consultaSalidaGeneral_pdf.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&RespuestaSI=<?=$_GET[RespuestaSI]?>&RespuestaNO=<?=$_GET[RespuestaNO]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cNomRemite=<?=$_GET[cNomRemite]?>&Respuesta=<?=$_GET[Respuesta]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&orden=<?=$orden?>&campo=<?=$campo?>&iCodOficina=<?=$_GET['iCodOficina']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
						<b>a Pdf</b><img src="images/icon_pdf.png" width="17" height="17" border="0">
                    </button>
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
                    $tampag = 20;
                    $reg1 = ($pag-1) * $tampag;

                    //invertir orden
                    if($orden=="ASC") $cambio="DESC";
                    if($orden=="DESC") $cambio="ASC";

                    ?>
	                <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <td width="120" class="headCellColum">Oficina</td>
                                <td width="120" class="headCellColum">Pendientes</td>
                            </tr>
                        </thead>

                        <?php
                         if($fecini!=''){$fecini=date("Ymd", strtotime($fecini));}
                            if($fecfin!=''){
                            $fecfin=date("Y-m-d", strtotime($fecfin));
                            function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                            $date_r = getdate(strtotime($date));
                            $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                            return $date_result;
                                        }
                            $fecfin=dateadd($fecfin,1,0,0,0,0,0); // + 1 dia
                            }

                             // $sql   = "EXECUTE USP_REPORTE_TRAMITES_PENDIENTES";
                          //  $rs    = sqlsrv_query($cnx,$sql);
                          //  $total = sqlsrv_has_rows($rs);

                           $sql   = "SELECT * FROM Tra_M_Oficinas ORDER BY cNomOficina";
                           $rs    = sqlsrv_query($cnx,$sql);
                           $numrows = sqlsrv_has_rows($rs);

                            if($numrows==0){
                                echo "NO SE ENCONTRARON REGISTROS<br>";
                            }else{
                                while ($Rs=sqlsrv_fetch_array($rs)){
                                    if ($color == "#DDEDFF"){
                                        $color = "#F9F9F9";
                                }else{
                                        $color = "#DDEDFF";
                                }
                                if ($color == ""){
                                        $color = "#F9F9F9";
                                }
                        ?>
                        <tbody>
                            <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
                            <td valign="top" align="left">
                                <?php
                                        echo "<div style=color:#808080;>".utf8_encode($Rs['cNomOficina'])."</div>";
                                    ?>
                                </td>
                            <td valign="middle" align="center">
                                <?php
                                    $sqlBtn1 = "SP_BANDEJA_PENDIENTES  '','','','','','', ";
                                    $sqlBtn1.= "'','','','','','','','','$Rs['iCodOficina']','Fecha','DESC' ";
                                    $rsBtn1 = sqlsrv_query($cnx,$sqlBtn1, $cnx2);
                                    $total1 = sqlsrv_has_rows($rsBtn1);
                                    echo $total1;
                                    ?>
                                </td>
                            </tr>
                        </tbody>
  
                        <?php
        }
                        }
                        ?>
                    </table>
 	                <?php echo paginar($pag, $total, $tampag, "reporteTramitesPendientes.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&RespuestaSI=".$_GET[RespuestaSI]."&RespuestaNO=".$_GET[RespuestaNO]."&iCodOficina=".$_GET['iCodOficina']."&Respuesta=".$_GET[Respuesta]."&cNombre=".$_GET['cNombre']."&cObservaciones=".$_GET[cObservaciones]."&pag=");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
function Buscar(){
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}
</script>
<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>