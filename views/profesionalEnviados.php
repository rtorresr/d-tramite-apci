<?php
session_start();
$pageTitle = "Bandeja de Enviados - Profesional";
$activeItem = "profesionalEnviados.php";
$navExtended = true;
//Inicia valores paginacion
$pag = $_GET['pag']??1;
if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
if(isset($_GET['cantidadfilas'])){$tampag = $_GET['cantidadfilas'];}
else{$tampag=5;}
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
    <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body class="theme-default has-fixed-sidenav">

<?php include("includes/menu.php");?>

<!--Main layout-->
 <main>
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-md-12 mb-12">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center ">BANDEJA DE ENVIADOS - PROFESIONAL</div>
                      <!--Card content-->
                     <div class="card-body d-flex px-4 px-lg-5">
                         <div class="wrapper">
                             <nav class="navbar-expand py-0">
                                 <button type="button" title="Búsqueda" id="sidebarCollapse" class="botenviar float-left" style="padding: 0rem 8px!important; border: none; margin-left: -18px; border-radius: 10px;">
                                     <i class="fas fa-align-right"></i>
                                 </button>
                             </nav>
                             <!-- Sidebar -->
                             <nav id="sidebar" class="py-0">
                                 <div class="card">
                                     <div class="card-header">Criterios de Búsqueda</div>
                                     <div class="card-body">
                                         <form name="frmConsulta" method="GET">
                                             <input type="hidden" name="cantidadfilas" value="<?=$tampag?>">
                                             <div class="row justify-content-center">
                                                 <div class="col-12 mb-2">
                                                     <label class="select">Documento:</label><br>
                                                     <div class="form-check form-check-inline">
                                                         <input type="checkbox" name="Entrada" class="form-check-input" id="Entrada" value="1" <?php if(($_GET['Entrada']??'')==1) echo "checked"?> onclick="activaEntrada();">
                                                         <label class="form-check-label" for="Entrada">Entrada </label>&nbsp;&nbsp;
                                                     </div>
                                                     <div class="form-check form-check-inline">
                                                         <input type="checkbox" name="Interno" class="form-check-input" id="Interno" value="1" <?php if(($_GET['Interno']??'')==1) echo "checked"?> onclick="activaInterno();">
                                                         <label class="form-check-label" for="Interno">Internos </label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12 col-sm-6">
                                                     <div class="md-form">
                                                         <input placeholder="dd-mm-aaaa" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" type="text"
                                                                id="date-picker-example" name="fDesde"  class="FormPropertReg form-control datepicker">
                                                         <label for="date-picker-example">Desde:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12 col-sm-6">
                                                     <div class="md-form">
                                                         <input placeholder="dd-mm-aaaa" name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" type="text"
                                                                id="date-picker-example"  class="FormPropertReg form-control datepicker">
                                                         <label for="date-picker-example">Hasta:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div class="md-form">
                                                         <input name="cCodificacion" type="text" id="cCodificacion" class="FormPropertReg form-control" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>">
                                                         <label for="cCodificacion">N&ordm; Documento:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div class="md-form">
                                                         <input type="text" name="cAsunto" id="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" class="FormPropertReg form-control">
                                                         <label for="cAsunto" >Asunto:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div >
                                                         <label for="cCodTipoDoc" class="select">Tipo Documento:</label>
                                                         <select name="cCodTipoDoc" id="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                 searchable="Buscar aqui..">
                                                             <option value="">Seleccione:</option>
                                                             <?php include_once("../conexion/conexion.php");
                                                             $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
                                                             $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                                                             $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                             while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                                 if($RsTipo["cCodTipoDoc"]==($_GET['cCodTipoDoc']??'')){
                                                                     $selecTipo="selected";
                                                                 }Else{
                                                                     $selecTipo="";
                                                                 }
                                                                 echo utf8_encode("<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>");
                                                             }
                                                             sqlsrv_free_stmt($rsTipo);
                                                             ?>
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div class="row justify-content-center py-0">
                                                         <div class="col- mx-3 mb-3">
                                                             <button class="botenviar" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">Buscar</button>
                                                         </div>
                                                         <div class="col- mx-3">
                                                             <button class="botenviar"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'">Restablecer</button>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </form>
                                     </div>
                                 </div>
                             </nav>
                         </div>
                         <?php
                            function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                                $total_paginas = ceil($total/$por_pagina);
                                $anterior = $actual - 1;
                                $posterior = $actual + 1;
                                $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
                                $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;

                                if ($actual>1)
                                    $texto = "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center flex-wrap'>
                                                      <li class='page-item'><a class='page-link' href='$enlace$anterior'>Anterior</a></li> ";
                                else
                                    $texto = "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center   flex-wrap'>
                                                       <li class='page-item disabled'><a class='page-link' href='#'>Anterior</a></li> ";

                                if ($minimo!=1) $texto.= "... ";

                                for ($i=$minimo; $i<$actual; $i++)
                                    $texto .= "  <li class='page-item'><a class='page-link' href='$enlace$i'>$i</a></li> ";

                                $texto .= "<li class='page-item active'>
                                                  <a class='page-link' href='#'>$actual<span class='sr-only'>(current)</span></a></li>";

                                for ($i=$actual+1; $i<=$maximo; $i++)
                                    $texto .= "<li class='page-item'><a class='page-link' href='$enlace$i'>$i</a></li> ";


                                if ($maximo!=$total_paginas) $texto.= "... ";

                                if ($actual<$total_paginas)
                                    $texto .= "<li class='page-item'><a class='page-link' href='$enlace$posterior'>Siguiente</a></li></ul></nav>";
                                else
                                    $texto .= "<li class='page-item disabled'><a class='page-link' href='$enlace$posterior'>Siguiente</a></li></ul></nav>";

                                return $texto;
                            }

                   $reg1 = ($pag-1) * $tampag;

                  // ordenamiento
                   $campo = "";
                   if(($_GET['campo']??'')==""){
                   $campo="Tra_M_Tramite_Movimientos.iCodMovimiento";
                   }Else{
                   $campo=$_GET['campo']??'';
                   }
                    $campo = '';
                  if(($_GET['orden']??'')==""){
                    $orden="DESC";
                 }Else{
                    $orden=$_GET['orden']??'';
                 }

                 //invertir orden
                 if($orden==="ASC") $cambio="DESC";
                 if($orden==="DESC") $cambio="ASC";

                            $fDesde=$_GET['fDesde']??'';
                            $fHasta=$_GET['fHasta']??'';

                            function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                  $date_r = getdate(strtotime($date));
                                  $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
                                  return $date_result;
                            }
                            $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia

                            $sqlTra = "SELECT   c.cFlgTipoMovimiento, c.nEstadoMovimiento, 
                                (convert(char(10),c.fFecDelegadoRecepcion, 120) +  + Convert(char(8),c.fFecDelegadoRecepcion, 114))  as fFecDelegadoRecepcion,
                                (convert(char(10),c.fFecRecepcion , 120) +  + Convert(char(8),c.fFecRecepcion , 114))  as fFecRegistroz, 
                                (convert (char(10), fFecEnvio,120)+ + Convert(char(8),fFecEnvio , 114))  as fFecEnvioz,
                                *
                               FROM Tra_M_Tramite a, Tra_M_Tramite_Trabajadores b, Tra_M_Tramite_Movimientos c 
                               WHERE a.iCodTramite = b.iCodTramite ";
                         if(($_GET['Entrada']??'')==1 AND ($_GET['Interno']??'')==""){
                             $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=1 ";
                         }
                         if(($_GET['Entrada']??'')=="" AND ($_GET['Interno']??'')==1){
                             $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=2 ";
                         }
                         if(($_GET['Entrada']??'')==1 AND ($_GET['Interno']??'')==1){
                             $sqlTra.="AND (Tra_M_Tramite.nFlgTipoDoc=1 OR Tra_M_Tramite.nFlgTipoDoc=2) ";
                         }
                         if(($_GET['fDesde']??'')!="" AND ($_GET['fHasta']??'')==""){
                             $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar>'$fDesde' ";
                         }
                         if(($_GET['fDesde']??'')=="" AND ($_GET['fHasta']??'')!=""){
                             $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar<='$fHasta' ";
                         }
                         if(($_GET['fDesde']??'')!="" AND ($_GET['fHasta']??'')!=""){
                             $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar BETWEEN '$fDesde' AND '$fHasta' ";
                         }
                         if(($_GET['cCodificacion']??'')!=""){
                             $sqlTra.="AND Tra_M_Tramite.cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
                         }
                         if(($_GET['cAsunto']??'')!=""){
                             $sqlTra.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
                         }
                         if(($_GET['cCodTipoDoc']??'')!=""){
                             $sqlTra.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
                         }
                    $sqlTra.=" AND (b.iCodTrabajadorOrigen='".$_SESSION['CODIGO_TRABAJADOR']."' AND b.iCodTrabajadorDestino!='".$_SESSION['CODIGO_TRABAJADOR']."' ) ";
                    $sqlTra.="AND b.iCodOficina='".$_SESSION['iCodOficinaLogin']."' and b.iCodMovimiento =c.iCodMovimiento  ";
                    $sqlTra.= "ORDER BY a.iCodTramite DESC";
                    $rsTra  = sqlsrv_query($cnx,$sqlTra);
                    $total  = sqlsrv_has_rows($rsTra);
                ?>
                         <div class="card ml-3" id="tablaResutado">
                             <div class="card-body px-4 px-lg-5">
                                 <div class="row justify-content-center">
                                     <div class="col-12 col-xl-11">
                                         <div class="row justify-content-between">
                                             <div class="col-10 col-sm-3 col-md-2 mt-3">
                                                 <select name="cantidadfilas" id="filas" class="mdb-select" onchange="actualizarfilas()" >
                                                     <option value="5"  id="5">5</option>
                                                     <option value="10" id="10">10</option>
                                                     <option value="20" id="20">20</option>
                                                     <option value="50" id="50">50</option>
                                                 </select>
                                                 <label>Cantidad</label>
                                                 <script>document.getElementById(<?php echo $tampag?>).selected = true;</script>
                                             </div>
                                         </div>
                                         <div class="table-responsive">
                                             <table class="table table-hover ">
                                                 <thead class="text-center text-white" style="border-bottom: solid 1px rgba(0,0,0,0.47);background-color: #0f58ab">
                                                 <tr>
                                                     <td>N&ordm; Documento</td>
                                                     <td>Nombre / Razón Social</td>
                                                     <td>Asunto / Procedimiento TUPA</td>
                                                     <td>Envio</td>
                                                     <td>Recepción</td>
                                                     <td>Estado</td>
                                                 </tr>
                                                 </thead>
                                                 <tbody>
                                                 <?php
                                                 $numrows=sqlsrv_has_rows($rsTra);
                                                 if($numrows==0){
                                                 }else{

///////////////////////////////////////////////////////
                                                     for ($i=$reg1, $iMax = min($total,$reg1 + $tampag); $i< $iMax; $i++) {
                                                         sqlsrv_fetch_array($rsTra, $i);
                                                         $RsTra=sqlsrv_fetch_array($rsTra);
///////////////////////////////////////////////////////
                                                         // while ($RsTra=sqlsrv_fetch_array($rsTra))
                                                         $color ='';
                                                         if ($color === "#DDEDFF"){
                                                             $color = "#F9F9F9";
                                                         }else{
                                                             $color = "#DDEDFF";
                                                         }
                                                         if ($color == ""){
                                                             $color = "#F9F9F9";
                                                         }
                                                         ?>
                                                         <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'">
                                                             <td>
                                                                 <?php if($RsTra['nFlgTipoDoc']==1){?>
                                                                     <a href="registroEnviadosDetalles.php?iCodTramite=<?=$RsTra['iCodTramite']?>"  rel="lyteframe"
                                                                        title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                                                         <?=utf8_encode($RsTra['cCodificacion'])?>
                                                                     </a>
                                                                 <?php}
                                                                 if($RsTra['nFlgTipoDoc']==2){
                                                                     echo "INTERNO";}
                                                                 if($RsTra['nFlgTipoDoc']==3){
                                                                     echo "SALIDA";}
                                                                 if($RsTra['nFlgTipoDoc']==4){
                                                                     ?>
                                                                     <a href="registroEnviadosDetalles.php?iCodTramite=<?=$RsTra['iCodTramiteRel']?>"  rel="lyteframe"
                                                                        title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                                                         <?=utf8_encode($RsTra['cCodificacion'])?>
                                                                     </a>
                                                                 <?php } ?>
                                                                 <?php     echo "<div style=color:#727272>".''??$RsTra['fFecRegistroz']->format("d-m-Y")/*date("d-m-Y", strtotime($RsTra['fFecRegistro']))*/."</div>";
                                                                 echo "<div style=color:#727272;font-size:10px>".''??$RsTra['fFecRegistroz']->format("G:i")."</div>";
                                                                 if($RsTra['cFlgTipoMovimiento']==6){
                                                                     echo "<div style=color:#800000;font-size:10px;text-align:center>COPIA</div>";
                                                                 }
                                                                 ?>
                                                             </td>
                                                             <td>
                                                                 <?php
                                                                 $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'";
                                                                 $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
                                                                 $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
                                                                 echo utf8_encode("<div>".$RsTipDoc['cDescTipoDoc']."</div>");
                                                                 if($RsTra['nFlgTipoDoc']==1 ){
                                                                     echo "<div style=color:#808080;text-transform:uppercase>".$RsTra['cNroDocumento']."</div>";
                                                                 }else if($RsTra['nFlgTipoDoc']==2 ){
                                                                     echo "<a style=\"color:#0067CE\" href=\"registroEnviadosDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                                                                     echo $RsTra['cCodificacion'];
                                                                     echo "</a>";
                                                                 }else if($RsTra['nFlgTipoDoc']==3 ){
                                                                     echo "<br>";
                                                                     echo "<a style=\"color:#0067CE\" href=\"registroEnviadosDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
                                                                     echo $RsTra['cCodificacion'];
                                                                     echo "</a>";
                                                                 }
                                                                 $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
                                                                 $RsRem=sqlsrv_fetch_array($rsRem);
                                                                 echo utf8_encode($RsRem["cNombre"]);
                                                                 sqlsrv_free_stmt($rsRem);
                                                                 ?>
                                                             </td>
                                                             <td><?=utf8_encode($RsTra['cAsunto'])?></td>
                                                             <td>
                                                                 <div><?=''??$RsTra['fFecEnvioz']->format("d-m-Y")/*date("d-m-Y", strtotime($RsTra[fFecEnvio]))*/;?></div>
                                                                 <div style="font-size:10px"><?=''??$RsTra['fFecEnvioz']->format("G:i");?></div>
                                                             </td>
                                                             <td>
                                                                 <?php     if($RsTra['cFlgTipoMovimiento']!=2){
                                                                     if($RsTra['nEstadoMovimiento']==3){
                                                                         if($RsTra['fFecDelegadoRecepcion']==""){
                                                                             echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                         }Else{
                                                                             echo "<div style=color:#0154AF>aceptado</div>";
                                                                             echo "<div style=color:#0154AF>".''??$RsTra['fFecDelegadoRecepcion']->format("d-m-Y")/*date("d-m-Y", strtotime($RsTra['fFecDelegadoRecepcion']))*/."</div>";
                                                                             echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecDelegadoRecepcion']->format("G:i")."</div>";
                                                                         }
                                                                     }else{
                                                                         if($RsTra['cFlgTipoMovimiento']==6){
                                                                             if($RsTra['fFecDelegadoRecepcion']==""){
                                                                                 echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                             }Else{
                                                                                 echo "<div style=color:#0154AF>aceptado</div>";
                                                                                 echo "<div style=color:#0154AF>".''??$RsTra['fFecDelegadoRecepcion']->format("d-m-Y")/*date("d-m-Y", strtotime($RsTra['fFecDelegadoRecepcion']))*/."</div>";
                                                                                 echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecDelegadoRecepcion']->format("G:i")."</div>";
                                                                             }
                                                                         }
                                                                         else {
                                                                             if($RsTra['fFecRecepcion']==""){
                                                                                 echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                             }Else{
                                                                                 echo "<div style=color:#0154AF>aceptado</div>";
                                                                                 echo "<div style=color:#0154AF>".''??$RsTra['fFecRecepcion']->format("d-m-Y")/*date("d-m-Y", strtotime($RsTra['fFecRecepcion']))*/."</div>";
                                                                                 echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecRecepcion']->format("G:i")."</div>";
                                                                             }
                                                                         }
                                                                     }
                                                                 }else {
                                                                     if($RsTra['fFecRecepcion']==""){
                                                                         echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                     }Else{
                                                                         echo "<div style=color:#0154AF>aceptado</div>";
                                                                         echo "<div style=color:#0154AF>".''??$RsTra['fFecRecepcion']->format("d-m-Y")/*date("d-m-Y", strtotime($RsTra['fFecRecepcion']))*/."</div>";
                                                                         echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecRecepcion']->format("G:i")."</div>";
                                                                     }
                                                                 }
                                                                 ?>
                                                             </td>
                                                             <td>
                                                                 <?php     echo "<div style=color:#0154AF><b>";
                                                                 switch ($RsTra['nEstadoMovimiento']){
                                                                     case 1:
                                                                         echo "En proceso";
                                                                         break;
                                                                     case 2:
                                                                         echo "Derivado";
                                                                         break;
                                                                     case 3:
                                                                         echo "Delegado";
                                                                         break;
                                                                     case 4:
                                                                         echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsTra['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">Respondido</a>";
                                                                         break;
                                                                     case 5:
                                                                         echo "Finalizado";
                                                                         break;
                                                                 }
                                                                 echo "</b></div>";
                                                                 if($RsTra['cFlgTipoMovimiento']==2){
                                                                     echo "<div style=color:#773C00>Enviado</div>";
                                                                 }
                                                                 ?>
                                                             </td>

                                                         </tr>
                                                         <?php
         }
                                                 }
                                                 sqlsrv_free_stmt($rsTra);
                                                 ?>
                                                 </tbody>
                                             </table>
                                         </div>
                                         <!--Información inferior-->
                                         <div class="info-end">
                                             <br>
                                             <b>
                                                 Resultados del <?php echo $reg1+1 ; ?> al <?php echo min($total,$reg1+$tampag) ; ?>
                                             </b>
                                             <br>
                                             <b>
                                                 Total: <?php echo $total; ?>
                                             </b>
                                             <br>
                                         </div>
                                         <br>
                                         <?php echo paginar($pag, $total, $tampag, "profesionalEnviados.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&cantidadfilas=".(isset($_GET['cantidadfilas'])?$_GET['cantidadfilas']:'')."&pag="); ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
 <?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>
    <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>

    <script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
    <script Language="JavaScript">
        $(document).ready(function() {
            $('.datepicker').pickadate({
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                format: 'dd-mm-yyyy',
                formatSubmit: 'dd-mm-yyyy',
            });
            $('.mdb-select').material_select();

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });


        });

        //Para Cantidad de filas
        function actualizarfilas(){
            var valor =Number.parseInt(document.getElementById('filas').value);
            var direc =window.location.pathname;
            window.location =direc+"?cantidadfilas="+valor;
        }

        function activaOpciones1(){
            for (j=0;j<document.formulario.elements.length;j++){
                if(document.formulario.elements[j].type == "radio"){
                    document.formulario.elements[j].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=false;
            document.formulario.OpEnviar.disabled=true;
            document.formulario.OpDelegar.disabled=true;
            document.formulario.OpFinalizar.disabled=true;
            document.formulario.OpAvance.disabled=true;
            document.formulario.OpAceptar.filters.alpha.opacity=100;
            document.formulario.OpEnviar.filters.alpha.opacity=50;
            document.formulario.OpDelegar.filters.alpha.opacity=50;
            document.formulario.OpFinalizar.filters.alpha.opacity=50;
            document.formulario.OpAvance.filters.alpha.opacity=50;
            return false;
        }

        function activaOpciones2(){
            for (i=0;i<document.formulario.elements.length;i++){
                if(document.formulario.elements[i].type == "checkbox"){
                    document.formulario.elements[i].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=true;
            document.formulario.OpEnviar.disabled=false;
            document.formulario.OpDelegar.disabled=false;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=false;
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpEnviar.filters.alpha.opacity=100;
            document.formulario.OpDelegar.filters.alpha.opacity=100;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=100;
            return false;
        }


        function activaAceptar()
        {
            document.formulario.opcion.value=10;
            document.formulario.method="POST";
            document.formulario.action="profesionalData.php";
            document.formulario.submit();
        }

        function activaEnviar()
        {
            document.formulario.OpAceptar.value="";
            document.formulario.OpEnviar.value="";
            document.formulario.OpDelegar.value="";
            document.formulario.OpFinalizar.value="";
            document.formulario.OpAvance.value="";
            document.formulario.opcion.value=1;
            document.formulario.method="GET";
            document.formulario.action="profesionalEnviar.php";
            document.formulario.submit();
        }

        function activaDelegar()
        {
            document.formulario.action="profesionalResponder.php";
            document.formulario.submit();
        }

        function activaFinalizar()
        {
            document.formulario.action="profesionalFinalizar.php";
            document.formulario.submit();
        }

        function activaAvance()
        {
            document.formulario.action="profesionalAvance.php";
            document.formulario.submit();
        }

        function Buscar()
        {
            document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>";
            document.frmConsulta.submit();
        }


        //--></script>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>