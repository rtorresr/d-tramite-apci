<?php
session_start();
$pageTitle = "Bandeja de Derivados - Profesional";
$activeItem = "profesionalDerivados.php";
$navExtended = true;

//Inicia valores paginacion
$pag = $_GET['pag']??1;
if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
if(isset($_GET['cantidadfilas'])){$tampag = $_GET['cantidadfilas'];}
else{$tampag=5;}
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />

</head>
<body class="theme-default has-fixed-sidenav" >
<?php include("includes/menu.php");?>

<!--Main layout-->
 <main>
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-12 mb-2">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center "></div>
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
                                                         <label class="form-check-label" for="Entrada">Entrada </label>
                                                     </div>
                                                     <div class="form-check form-check-inline">
                                                         <input type="checkbox" name="Interno" class="form-check-input" id="Interno" value="1" <?php if(($_GET['Interno']??'')==1) echo "checked"?> onclick="activaInterno();">
                                                         <label class="form-check-label" for="Interno">Internos </label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12 col-sm-6">
                                                     <div class="md-form">
                                                         <input placeholder="dd-mm-aaaa" value="<?=($_GET['fDesde']??'')?>" type="text"
                                                                id="date-picker-example" name="fDesde"  class="FormPropertReg form-control datepicker">
                                                         <label for="date-picker-example">Desde:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12 col-sm-6">
                                                     <div class="md-form">
                                                         <input placeholder="dd-mm-aaaa" name="fHasta" value="<?=($_GET['fHasta']??'')?>" type="text"
                                                                id="date-picker-example"  class="FormPropertReg form-control datepicker">
                                                         <label for="date-picker-example">Hasta:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div class="md-form">
                                                         <input name="cCodificacion" type="text" id="cCodificacion" class="FormPropertReg form-control" value="<?=($_GET['cCodificacion']??'')?>">
                                                         <label for="cCodificacion">N&ordm; Documento:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div class="md-form">
                                                         <input type="text" name="cAsunto" id="cAsunto" value="<?=($_GET['cAsunto']??'')?>" class="FormPropertReg form-control">
                                                         <label for="cAsunto" >Asunto:</label>
                                                     </div>
                                                 </div>
                                                 <div class="col-12 col-sm-6">
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
                                                 <div class="col-12 col-sm-6">
                                                     <div >
                                                         <label for="iCodTema" class="select">Tema:</label>
                                                         <select name="iCodTema" id="iCodTema" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                 searchable="Buscar aqui..">
                                                             <option value="">Seleccione:</option>
                                                             <?php $sqlTem="SELECT * FROM Tra_M_Temas WHERE  iCodOficina = '".$_SESSION['iCodOficinaLogin']."' ";
                                                             $sqlTem .= "ORDER BY cDesTema ASC";
                                                             $rsTem=sqlsrv_query($cnx,$sqlTem);
                                                             while ($RsTem=sqlsrv_fetch_array($rsTem)){
                                                                 if($RsTem['iCodTema']==($_GET['iCodTema']??'')){
                                                                     $selecTem="selected";
                                                                 }Else{
                                                                     $selecTem="";
                                                                 }
                                                                 echo utf8_encode("<option value=\"".$RsTem["iCodTema"]."\" ".$selecTem.">".$RsTem["cDesTema"]." ".$RsTem["cNombresTrabajador"]."</option>");
                                                             }
                                                             sqlsrv_free_stmt($rsTem);
                                                             ?>
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div >
                                                         <label for="iCodOficinaDes" class="select">Oficina Destino:</label>
                                                         <select name="iCodOficinaDes" id="iCodOficinaDes" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                 searchable="Buscar aqui..">
                                                             <option value="">Seleccione:</option>
                                                             <?php $sqlOfi="SP_OFICINA_LISTA_COMBO ";
                                                             $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                             while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                                                 if($RsOfi["iCodOficina"]==($_GET['iCodOficinaDes']??'')){
                                                                     $selecClas="selected";
                                                                 }Else{
                                                                     $selecClas="";
                                                                 }
                                                                 echo utf8_encode("<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>");
                                                             }
                                                             sqlsrv_free_stmt($rsOfi);
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
                                                     <div class="card" style="background-color: rgba(231,234,238,0.42)">
                                                         <div class="card-body">
                                                             <div class="row pl-3 pl-lg-5">
                                                                 Exportar en:
                                                             </div>
                                                             <div class="row justify-content-center">
                                                                 <div class="col-">
                                                                     <button class="botpelota waves-effect btn-sm mx-1" title="Excel" onclick="window.open('pendientesDerivadosExcel.php?fDesde=<?=($_GET['fDesde']??'')?>&fHasta=<?=('' ?? $_GET['fHasta'])?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorFinalizar=<?=((isset($_GET['iCodTrabajadorFinalizar']))?$_GET['iCodTrabajadorFinalizar']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&iCodOficina=<?=$_SESSION['iCodOficinaLogin']?>', '_self');" onMouseOver="this.style.cursor='hand'">
                                                                         <i class="far fa-file-excel"></i>
                                                                     </button>
                                                                 </div>
                                                                 <div class="col-">
                                                                     <button class="botpelota waves-effect btn-sm mx-1" title="Pdf" onclick="window.open('pendientesDerivadosPdf.php?fDesde=<?=($_GET['fDesde']??'')?>&fHasta=<?=('' ?? $_GET['fHasta'])?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Anexo=<?=(isset($_GET['Anexo'])?$_GET['Anexo']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorResponsable=<?=(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')?>&iCodTrabajadorDelegado=<?=(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&Aceptado=<?=(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')?>&SAceptado=<?=(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                         <i class="far fa-file-pdf"></i>
                                                                     </button>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </form>
                                     </div>
                                 </div>
                             </nav>
                         </div>



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
                                                 <script>document.getElementById('<?php echo $tampag ?>').selected=true;</script>
                                             </div>
                                         </div>
                                         <div class="table-responsive">
                                             <table class="table table-hover">
                                                 <thead class="text-center text-white" style="border-bottom: solid 1px rgba(0,0,0,0.47);background-color: #0f58ab">
                                                 <tr>
                                                     <?php $cambio=''; $campo=''?>
                                                     <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Codigo&orden=<?= $cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" style=" text-decoration:<?php if($campo=="Codigo"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; TRÁMITE</a></td>
                                                     <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
                                                     <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">Nombre / Razón Social</a></td>
                                                     <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto / Procedimiento TUPA</a></td>
                                                     <td class="headColumnas">Derivado</td>
                                                     <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">Derivado A:</a></td>
                                                     <td class="headColumnas">Edit</td>
                                                 </tr>
                                                 </thead>
                                                 <tbody>
                                                 <?php
                                                 $fDesde = ''; $fHasta='';
                                                 if(($_GET['fDesde']??'')!=""){ $fDesde=date("Ymd", strtotime($_GET['fDesde'])); }
                                                 if(('' ?? $_GET['fHasta'])!=""){
                                                     $fHasta=date("d-m-Y", strtotime($_GET["fHasta"]));
                                                     function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                                         $date_r = getdate(strtotime($date));
                                                         $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                                                         return $date_result;
                                                     }
                                                     $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
                                                 }
                                                 include_once("../conexion/conexion.php");

                                                 function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                                                     $total_paginas = ceil($total/$por_pagina);
                                                     $anterior = $actual - 1;
                                                     $posterior = $actual + 1;
                                                     $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
                                                     $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;

                                                     if ($actual>1)
                                                         $texto = "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center flex-wrap'><li class='page-item'><a class='page-link' href='$enlace$anterior'>Anterior</a></li> ";
                                                     else
                                                         $texto = "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center   flex-wrap'><li class='page-item disabled'><a class='page-link' href='#'>Anterior</a></li> ";

                                                     if ($minimo!=1) $texto.= "... ";

                                                     for ($i=$minimo; $i<$actual; $i++)
                                                         $texto .= "  <li class='page-item'><a class='page-link' href='$enlace$i'>$i</a></li> ";

                                                     $texto .= "<li class='page-item active'><a class='page-link' href='#'>$actual<span class='sr-only'>(current)</span></a></li>";

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
                                                 $campo = '';
                                                 if(($_GET['campo']??'')==""){
                                                     $campo="Derivado";
                                                 }Else{
                                                     $campo=$_GET['campo'];
                                                 }
                                                 $orden = '';
                                                 if(($_GET['orden']??'')==""){
                                                     $orden="DESC";
                                                 }Else{
                                                     $orden=$_GET['orden'];
                                                 }

                                                 //invertir orden
                                                 if("ASC" === $orden) $cambio="DESC";
                                                 if("DESC" === $orden) $cambio="ASC";

                                                 $sqlTra = "SP_BANDEJA_DERIVADOS_PROFESIONAL '".($_GET['Entrada']??'')."','".($_GET['Interno']??'')."','$fDesde','$fHasta','%".($_GET['cCodificacion']??'')."%','%".($_GET['cAsunto']??'')."%','".$_SESSION['iCodOficinaLogin']."','".$_SESSION['CODIGO_TRABAJADOR']."','".($_GET['cCodTipoDoc']??'')."','".($_GET['iCodTema']??'')."' ,'".($_GET['iCodOficinaDes']??'')."','$campo','$orden'";
                                                 $rsTra = sqlsrv_query($cnx,$sqlTra);
                                                 // echo $sqlTra;
                                                 $total = sqlsrv_has_rows($rsTra);
                                                 $numrows=sqlsrv_has_rows($rsTra);
                                                 if($numrows==0){
                                                 }else{
                                                     ///////////////////////////////////////////////////////
                                                     for ($i=$reg1, $iMax = min( $total,$reg1 + $tampag); $i< $iMax; $i++) {
                                                         sqlsrv_fetch_array($rsTra, $i);
                                                         $RsTra=sqlsrv_fetch_array($rsTra);
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
                                                         <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF';" OnMouseOut="this.style.backgroundColor='<?=$color?>'">
                                                             <td width="95" valign="top" align="left">
                                                                 <?php if($RsTra['nFlgTipoDoc']==1){?>
                                                                     <a class="modal-trigger tooltipped" data-send="<?=$RsTra['iCodTramite']?>" onclick="getvalue(this)" data-position="left" data-tooltip="Detalle del Trámite" href="#modal1bpd" >
                                                                         <?=$RsTra['cCodificacion']?>
                                                                     </a>
                                                                     <!--<a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramite']?>"  rel="lyteframe" title="Detalle del TRÁMITE"
                                                                        rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                                                         <?=$RsTra['cCodificacion']?>
                                                                     </a>-->
                                                                 <?php }
                                                                 if($RsTra['nFlgTipoDoc']==2){
                                                                     echo "INTERNO";}
                                                                 if($RsTra['nFlgTipoDoc']==3){
                                                                     echo "SALIDA";}
                                                                 if($RsTra['nFlgTipoDoc']==4){
                                                                     ?>
                                                                     <a class="modal-trigger tooltipped" data-send="<?=$RsTra['cCodificacion']?>" onclick="getvalue(this)" data-position="left" data-tooltip="Detalle del Trámite" href="#modal1bpd" >
                                                                         <?=$RsTra['cCodificacion']?>
                                                                     </a>
                                                                     <!--<a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramiteRel']?>"  rel="lyteframe" title="Detalle del TRÁMITE"
                                                                        rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$RsTra['cCodificacion']?></a>-->
                                                                 <?php }

                                                                 $date = $RsTra['fFecRegistro'];
                                                                 $fFecRegistro =$date->format( 'd-m-Y H:i:s');
                                                                 echo "<div style=color:#727272>".$fFecRegistro."</div>";
                                                                 if($RsTra['cFlgTipoMovimiento']==4){
                                                                     echo "<div style=color:#FF0000;font-size:12px>Copia</div>";
                                                                 }

                                                                 ?>
                                                             </td>
                                                             <td width="95" valign="top" align="left">
                                                                 <?php
                                                                 if($RsTra['nFlgTipoDoc']==1  ){
                                                                     echo $RsTra['Documento'];
                                                                     echo "<div style=color:#808080;text-transform:uppercase>".$RsTra['cNroDocumento']."</div>";
                                                                 }else{
                                                                     //echo $RsTra['iCodTramite']."-";
                                                                     $sqlTrm="SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$RsTra['iCodTramite']."'";
                                                                     $rsTrm=sqlsrv_query($cnx,$sqlTrm);
                                                                     $RsTrm=sqlsrv_fetch_array($rsTrm);
                                                                     $sqlTpDcM="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$RsTrm['cCodTipoDoc']."'";
                                                                     $rsTpDcM=sqlsrv_query($cnx,$sqlTpDcM);
                                                                     $RsTpDcM=sqlsrv_fetch_array($rsTpDcM);
                                                                     echo $RsTpDcM['cDescTipoDoc'];
                                                                     echo "<br>";
                                                                     echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                                                                     echo $RsTra['cCodificacion'];
                                                                     echo "</a>";
                                                                 }
                                                                 ?>
                                                             </td>
                                                             <td width="188" align="left" valign="top">
                                                                 <?php
                                                                 $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
                                                                 $RsRem=sqlsrv_fetch_array($rsRem);
                                                                 echo $RsRem["cNombre"];
                                                                 echo $RsTra["cNomRemite"]??'-';
                                                                 sqlsrv_free_stmt($rsRem);
                                                                 ?>
                                                             </td>
                                                             <td align="left" valign="top"><?=$RsTra['cAsunto']?></td>
                                                             <td width="100" align="left" valign="top">
                                                                 <?php $date = $RsTra['fFecDerivar'];
                                                                 $fFecDerivar = ''??$date->format( 'd-m-Y H:i:s');
                                                                 echo $RsTra['cAsuntoDerivar'];?>
                                                                 <div style="color:#0154AF"><?=$fFecDerivar;?></div>
                                                             </td>
                                                             <td width="100" valign="top" align="left">
                                                                 <?php     $rsOfic=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsTra['iCodOficinaDerivar']."'");
                                                                 $RsOfic=sqlsrv_fetch_array($rsOfic);
                                                                 echo "<a href=javascript:; title=\"".$RsOfic["cNomOficina"]."\">".$RsOfic["cSiglaOficina"]."</a>";
                                                                 sqlsrv_free_stmt($rsOfic);
                                                                 if($RsTra['fFecRecepcion']==""){
                                                                     echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                 }Else{
                                                                     $date = $RsTra['fFecRecepcion'];
                                                                     echo "<div style=color:#0154AF>".$date->format( 'd-m-Y')."</div>";
                                                                     echo "<div style=color:#0154AF;font-size:10px>".$date->format( 'G:i')."</div>";
                                                                 }

                                                                 ?>
                                                             </td>
                                                             <td>
                                                                 <?php
                                                                 $sqlChk="SELECT TOP 1 Tra_M_Tramite.iCodTramite, Tra_M_Tramite_Movimientos.iCodTramite, Tra_M_Tramite_Movimientos.iCodOficinaOrigen, Tra_M_Tramite_Movimientos.iCodOficinaDerivar, Tra_M_Tramite.nFlgEnvio, Tra_M_Tramite_Movimientos.nFlgTipoDoc, Tra_M_Tramite.cCodificacion, Tra_M_Tramite_Movimientos.iCodMovimiento FROM Tra_M_Tramite ,Tra_M_Tramite_Movimientos ";
                                                                 $sqlChk.="WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
                                                                 $sqlChk.="AND Tra_M_Tramite_Movimientos.iCodOficinaOrigen='".($_SESSION['iCodOficinaLogin']??'')."' ";
                                                                 $sqlChk.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar!='".($_SESSION['iCodOficinaLogin']??'')."' ";
                                                                 $sqlChk.="AND Tra_M_Tramite.nFlgEnvio=1 ";
                                                                 $sqlChk.="AND nEstadoMovimiento!=2 ";
                                                                 $sqlChk.="AND Tra_M_Tramite_Movimientos.nFlgTipoDoc!=3 ";
                                                                 $sqlChk.="AND Tra_M_Tramite.cCodificacion='".($RsTra['cCodificacion']??'')."' ";
                                                                 $sqlChk.="ORDER BY iCodMovimiento ASC";
                                                                 $rsChk=sqlsrv_query($cnx,$sqlChk);
                                                                 $RsChk=sqlsrv_fetch_array($rsChk);
                                                                 if($RsChk['iCodMovimiento']==$RsTra['iCodMovimiento']){
                                                                 ?>
                                                                 <a href="profesionalDerivadosEdit.php?iCodMovimientoDerivar=<?=$RsTra['iCodMovimiento']?>"><i class="fas fa-edit"></i>
                                                                     <?php } ?>
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
                                                 Resultados del <?php echo $reg1+1 ; ?> al <?php echo min( $total,$reg1+$tampag) ; ?>
                                             </b>
                                             <br>
                                             <b>
                                                 Total: <?php echo $total; ?>
                                             </b>
                                             <br>
                                             <?php echo paginar($pag, $total, $tampag, "profesionalDerivados.php?fDesde=".($_GET['fDesde']??'')."&fHasta=".($_GET['fHasta']??'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&iCodTema=".(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&cantidadfilas=".(isset($_GET['cantidadfilas'])?$_GET['cantidadfilas']:'')."&pag="); ?>
                                         </div>
                                         <br>
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

<div id="modal1bpd" class="modal">
    <div class="modal-content"></div>
</div>



 <?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<script Language="JavaScript">


    $('.datepicker').datepicker({
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
    });
    $('.mdb-select').formSelect();
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
        function Buscar()
        {
            document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>";
            document.frmConsulta.submit();
        }

    //Para Cantidad de filas
    function actualizarfilas(){
        var valor =Number.parseInt(document.getElementById('filas').value);
        var direc =window.location.pathname;
        window.location =direc+"?cantidadfilas="+valor;
    }


    function getvalue(e) {
        const codigo = e.dataset.send;
        const nodocontent= document.querySelector('div#modal1bpd').querySelector('div.modal-content');

        $.ajax({
            cache: false,
            method: 'get',
            url: 'registroDetalles.php',
            data: { iCodTramite : codigo },
            datatype: 'text',
            success: function (response) {
                nodocontent.innerHTML=response;
            }
        });

    };

    function muestra(nombrediv) {
        if(document.getElementById(nombrediv).style.display == '') {
            document.getElementById(nombrediv).style.display = 'none';
        } else {
            document.getElementById(nombrediv).style.display = '';
        }
    }
</script>


</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>