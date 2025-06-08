<?php
session_start();
//Inicia valores paginacion
$pag=($_GET['pag']??1);
$tampag=($_GET['cantidadfilas']??5);
header('Content-Type: text/html; charset=utf-8');
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
    <style>
        .wrapper {
            width: auto%;
            position: absolute;
            z-index: 100;
            height: auto;
        }
        #sidebar {
            display: none;
        }
        #tablaResutado{
            width: 100%;
            border: none!important;
            box-shadow: none!important;
        }
        #sidebar.active {
            display: flex;
            width: 95%;
        }
        #sidebar label{
            font-size: 0.8rem!important;
            margin-bottom: 0!important;
        }
        .info-end ,.page-link{
            font-size: 0.8rem!important;
        }
        @media (min-width: 576px) {
            #sidebar.active {
                width: 80%;
            }
        }
        @media (min-width: 768px) {
            #sidebar.active {
                width: 60%;
            }
        }
        @media (min-width: 992px) {
            #sidebarCollapse{
                margin-left: -35px!important;
            }
            .info-end ,.page-link{
                font-size: 1rem!important;
            }
        }
        @media (min-width: 1200px) {
            #sidebar.active {
                width: 40%;
            }
        }

        .form-control{
            font-size: 0.8rem!important;
        }
        .md-form{
            margin-top: 1rem!important;
            margin-bottom: 0.8rem!important;
        }
        .dropdown-content li>a, .dropdown-content li>span {
            font-size: 0.8rem!important;
        }
        .select-wrapper .search-wrap {
            padding-top: 0rem!important;
            margin: 0 0.2rem!important;
        }
        .select-wrapper input.select-dropdown {
            font-size: 0.9rem!important;
        }
        label.select{
            margin-bottom: 0!important;
            font-size: 0.8rem!important;
        }
        thead a{
            color:white!important;
        }
        thead a:hover{
            color: #bdbdbd !important;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>
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
                         <div class="card-header text-center ">
                             BANDEJA DE FINALIZADOS
                         </div>
                          <!--Card content-->
                         <div class="card-body  d-flex px-4 px-lg-5">
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
                                                             <input type="checkbox" name="Entrada" class="form-check-input" id="Entrada" value="1" <?php if($_GET['Entrada']==1) echo "checked"?> onclick="activaEntrada();">
                                                             <label class="form-check-label" for="Entrada">Entrada </label>&nbsp;&nbsp;
                                                         </div>
                                                         <div class="form-check form-check-inline">
                                                             <input type="checkbox" name="Interno" class="form-check-input" id="Interno" value="1" <?php if($_GET['Interno']==1) echo "checked"?> onclick="activaInterno();">
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
                                                                     if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
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
                                                                     if($RsTem['iCodTema']==$_GET['iCodTema']){
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
                                                         <div class="row justify-content-center py-0">
                                                             <div class="col- mx-3 mb-3">
                                                                 <button class="botenviar" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">Buscar</button>
                                                             </div>
                                                             <div class="col- mx-3">
                                                                 <button class="botenviar"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'">Restablecer</button>
                                                             </div>
                                                         </div>

                                                         <?php // end table por fieldset
                                                         // ordenamiento
                                                         if($_GET['campo']==""){	$campo="op1";}Else{$campo=$_GET['campo'];}
                                                         if($_GET['orden']==""){	$orden="DESC";}Else{	$orden=$_GET['orden'];}
                                                         //invertir orden
                                                         if($orden=="ASC") $cambio="DESC";
                                                         if($orden=="DESC") $cambio="ASC";
                                                         ?>

                                                         <div class="card" style="background-color: rgba(231,234,238,0.42)">
                                                             <div class="card-body">
                                                                 <div class="row pl-3 pl-lg-5">
                                                                     Exportar en:
                                                                 </div>
                                                                 <div class="row justify-content-center">
                                                                     <div class="col-">
                                                                         <button class="botpelota waves-effect btn-sm mx-1" title="Excel" onclick="window.open('pendientesFinalizadosExcel.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorFinalizar=<?=((isset($_GET['iCodTrabajadorFinalizar']))?$_GET['iCodTrabajadorFinalizar']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&iCodOficina=<?=$_SESSION['iCodOficinaLogin']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                             <i class="far fa-file-excel"></i>
                                                                         </button>
                                                                     </div>
                                                                     <div class="col-">
                                                                         <button class="botpelota waves-effect btn-sm mx-1" title="Pdf" onclick="window.open('pendientesFinalizadosPdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Anexo=<?=(isset($_GET['Anexo'])?$_GET['Anexo']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorResponsable=<?=(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')?>&iCodTrabajadorDelegado=<?=(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&Aceptado=<?=(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')?>&SAceptado=<?=(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')?>', '_blank');" onMouseOver="this.style.cursor='hand'">
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
                                                 </div>
                                             </div>
                                             <div class="table-responsive">
                                                 <table class="table table-hover ">
                                                     <thead class="text-center text-white" style="border-bottom: solid 1px rgba(0,0,0,0.47);background-color: #0f58ab">
                                                     <tr>
                                                         <th><a href="<?=$_SERVER['PHP_SELF']?>?campo=op2&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op2"){ echo "underline"; }Else{ echo "none";}?>">
                                                                 N&ordm; Trámite</a>
                                                         </th>
                                                         <th><a href="<?=$_SERVER['PHP_SELF']?>?campo=op3&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op3"){ echo "underline"; }Else{ echo "none";}?>">
                                                                 Tipo de Documento</a>
                                                         </th>
                                                         <th>Nombre / Razón Social</th>
                                                         <th><a href="<?=$_SERVER['PHP_SELF']?>?campo=op4&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op4"){ echo "underline"; }Else{ echo "none";}?>">Asunto / Procedimiento TUPA</a></th>
                                                         <th>Derivado</th>
                                                         <th><a href="<?=$_SERVER['PHP_SELF']?>?campo=op5&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op5.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">
                                                                 Recepción</a></th>
                                                         <th>Respuesta del Delegado:</th>
                                                         <th><a href="<?=$_SERVER['PHP_SELF']?>?campo=op1&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="op1"){ echo "underline"; }Else{ echo "none";}?>">Finalizado:</a></th>
                                                         <th>Revertir:</th>
                                                     </tr>
                                                     </thead>
                                                     <tbody>
                                                     <?php
                                                     if(isset($_GET['fDesde'])){ $fDesde=date("Ymd", strtotime($_GET['fDesde'])); }
                                                     if(isset($_GET['fHasta'])){
                                                         // $fDesde=date("Ymd", strtotime($_GET['fDesde']));
                                                         $fHasta=date("d-m-Y", strtotime($_GET['fHasta']));
                                                         function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                                             $date_r = getdate(strtotime($date));
                                                             $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                                                             return $date_result;
                                                         }
                                                         $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
                                                     }
                                                     include_once("../conexion/conexion.php");

                                                 //$reg1 = ($pag-1) * $tampag;
                                                 $sqlTra= " SP_BANDEJA_FINALIZADOS '$campo' ,'".($_GET['Entrada']??'')."','".($_GET['Interno']??'')."','".($fDesde??'')."','".($fHasta??'')."', '".($_GET['cCodificacion']??'')."', '".($_GET['cAsunto']??'')."', '".$_SESSION['iCodOficinaLogin']."','".($_GET['cCodTipoDoc']??'')."','".($_GET['iCodTema']??'')."' , '$orden' ";
                                                 //$rsTra=sqlsrv_query($cnx,$sqlTra);
                                                 //$total = sqlsrv_has_rows($rsTra);

                                               //Código para paginar
                                                $rsTra = sqlsrv_query($cnx,$sqlTra,array(),array("Scrollable"=>"buffered"));
                                                $numrows=sqlsrv_num_rows($rsTra);
                                                $ini = ($pag-1) * $tampag;
                                                $fin= min($ini+$tampag,$numrows);
                                                if ($numrows !== 0) {
                                                    for ($i = 0; $i < $numrows; $i++) {
                                                        $RsTra = sqlsrv_fetch_array($rsTra);
                                                        if ($i >= $ini && $i < $fin) {
                                                            //fin del bloque (incluir al final las llaves })

                                                            //$numrows=sqlsrv_has_rows($rsTra);
                                                            //if($numrows!==0){
                                                            //////////////////////////////////////////////////////
                                                            //    for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                                                            //         sqlsrv_fetch_array($rsTra, $i);
                                                            //         $RsTra=sqlsrv_fetch_array($rsTra);
                                                            ///////////////////////////////////////////////////////
                                                            //while ($RsTra=sqlsrv_fetch_array($rsTra)){
                                                            if ($color == "#DDEDFF") {
                                                                $color = "#F9F9F9";
                                                            } else {
                                                                $color = "#DDEDFF";
                                                            }
                                                            if ($color == "") {
                                                                $color = "#F9F9F9";
                                                            }
                                                            ?>
                                                            <tr bgcolor="<?= $color ?>"
                                                                onMouseOver="this.style.backgroundColor='#BFDEFF';"
                                                                OnMouseOut="this.style.backgroundColor='<?= $color ?>'">
                                                                <td>
                                                                    <?php
                                                                    if ($RsTra['nFlgTipoDoc'] == 1) { ?>
                                                                        <a href="registroDetalles.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>"
                                                                           rel="lyteframe" title="Detalle del Trámite"
                                                                           rev="width: 970px; height: 550px; scrolling: auto; border:no"><?= $RsTra['cCodificacion'] ?></a>
                                                                    <?php }

                                                                    if ($RsTra['nFlgTipoDoc'] == 2) {
                                                                        echo "INTERNO";
                                                                    }
                                                                    if ($RsTra['nFlgTipoDoc'] == 3) {
                                                                        echo "SALIDA";
                                                                    }
                                                                    if ($RsTra['nFlgTipoDoc'] == 4) { ?>
                                                                        <a href="registroDetalles.php?iCodTramite=<?= $RsTra['iCodTramiteRel'] ?>"
                                                                           rel="lyteframe" title="Detalle del Trámite"
                                                                           rev="width: 970px; height: 550px; scrolling: auto; border:no"><?= $RsTra['cCodificacion'] ?></a>
                                                                    <?php } ?>

                                                                    <?php //echo " <div style=color:#727272>". date("d-m-Y", strtotime($RsTra['fFecRegistro']))."</div>";

                                                                    echo " <div style=color:#727272>" . $RsTra['fFecRegistro'] . "</div>";
                                                                    echo "<div style=color:#727272;font-size:10px>" . date("G:i", strtotime($RsTra['fFecRegistro'])) . "</div>";

                                                                    //echo "<div style=color:#727272>".$RsTra['fFecRegistro']."</div>";
                                                                    //echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($RsTra['fFecRegistro']))."</div>";

                                                                    if ($RsTra['cFlgTipoMovimiento'] == 4) {
                                                                        echo "<div style=color:#FF0000;font-size:12px>Copia</div>";
                                                                    }
                                                                    ?>
                                                                    <br>
                                                                    <b>
                                                                        <?php
                                                                        if (ltrim(rtrim($RsTra['cPrioridadDerivar'])) == "Alta") {
                                                                            echo "<font color='#ff0000'>Alta</font>";
                                                                        } elseif (ltrim(rtrim($RsTra['cPrioridadDerivar'])) == "Media") {
                                                                            echo "<font color='#07b52f'>Media</font>";
                                                                        } elseif (ltrim(rtrim($RsTra['cPrioridadDerivar'])) == "Baja") {
                                                                            echo "<font color='#aecc05'>Baja</font>";
                                                                        }
                                                                        ?>
                                                                    </b>
                                                                </td>
                                                                <td>
                                                                    <?php if ($RsTra['nFlgTipoDoc'] == 1) {
                                                                        $rsTDoc = sqlsrv_query($cnx, "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'");
                                                                        $RsTDoc = sqlsrv_fetch_array($rsTDoc);
                                                                        echo $RsTDoc["cDescTipoDoc"];
                                                                        sqlsrv_free_stmt($rsTDoc);
                                                                        echo "<div style=color:#808080;text-transform:uppercase>" . $RsTra['cNroDocumento'] . "</div>";
                                                                    } else {
                                                                        $rsTDoc = sqlsrv_query($cnx, "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'");
                                                                        $RsTDoc = sqlsrv_fetch_array($rsTDoc);
                                                                        echo $RsTDoc["cDescTipoDoc"];
                                                                        sqlsrv_free_stmt($rsTDoc);
                                                                        echo "<br>";
                                                                        echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=" . $RsTra['iCodTramite'] . "\" rel=\"lyteframe\" title=\"Detalle del Trámite\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                                                                        echo $RsTra['cCodificacion'];
                                                                        echo "</a>";
                                                                    }
                                                                    ?></td>
                                                                <td>
                                                                    <?php
                                                                    $rsRem = sqlsrv_query($cnx, "SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='" . $RsTra['iCodRemitente'] . "'");
                                                                    $RsRem = sqlsrv_fetch_array($rsRem);
                                                                    echo $RsRem["cNombre"];
                                                                    sqlsrv_free_stmt($rsRem);
                                                                    ?>
                                                                    <?= $RsTra['cNomRemite'] ?>
                                                                </td>
                                                                <td><?= $RsTra['cAsunto'] ?></td>
                                                                <td>
                                                                    <!--<div> <?= date("d-m-Y", strtotime($RsTra['fFecDerivar'])); ?></div>-->
                                                                    <div> <?= $RsTra['fFecDerivar']; ?></div>
                                                                    <div style="font-size:10px"><?= date("G:i", strtotime($RsTra['fFecDerivar'])); ?></div>
                                                                </td>
                                                                <td>
                                                                    <?php if ($RsTra['fFecRecepcion'] == "") {
                                                                        echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                    } Else {
                                                                        // echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecRecepcion']))."</div>";
                                                                        echo "<div style=color:#0154AF>" . $RsTra['fFecRecepcion'] . "</div>";
                                                                        echo "<div style=color:#0154AF;font-size:10px>" . date("G:i", strtotime($RsTra['fFecRecepcion'])) . "</div>";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($RsTra['iCodTrabajadorDelegado'] != "") {
                                                                        $rsDelg = sqlsrv_query($cnx, "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='" . $_GET['iCodTrabajadorDelegado'] . "'");
                                                                        $RsDelg = sqlsrv_fetch_array($rsDelg);
                                                                        echo "<div style=color:#005B2E;font-size:12px>" . $RsDelg["cApellidosTrabajador"] . " " . $RsDelg["cNombresTrabajador"] . "</div>";
                                                                        sqlsrv_free_stmt($rsDelg);
                                                                        echo "<div style=color:#0154AF>" . date("d-m-Y", strtotime($RsTra[fFecDelegado])) . "</div>";
                                                                        echo "<div style=color:#0154AF;font-size:10px>" . date("G:i", strtotime($RsTra[fFecDelegado])) . "</div>";
                                                                    }
                                                                    if ($RsTra[iCodTrabajadorResponder] != "") { //respondido
                                                                        echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=" . $RsTra['iCodMovimiento'] . "\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 480px; height: 270px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>

                                                                    <?= $RsTra[cObservacionesFinalizar] ?>
                                                                    <br>
                                                                    <?php $rsFina = sqlsrv_query($cnx, "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTra[iCodTrabajadorFinalizar]'");
                                                                    $RsFina = sqlsrv_fetch_array($rsFina);
                                                                    echo "<div style=color:#0154AF>" . $RsFina["cApellidosTrabajador"] . " " . $RsFina["cNombresTrabajador"] . "</div>";
                                                                    sqlsrv_free_stmt($rsFina);
                                                                    //echo " <div style=color:#727272>".date("d-m-Y", strtotime($RsTra[fFecFinalizar]))."</div>";
                                                                    echo " <div style=color:#727272>" . $RsTra[fFecFinalizar] . "</div>";
                                                                    echo "<div style=color:#727272;font-size:10px>" . date("G:i", strtotime($RsTra[fFecFinalizar])) . "</div>";
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <a href="pendientesData.php?iCodMovimiento=<?= $RsTra['iCodMovimiento'] ?>&opcion=11">
                                                                        <img src="images/icon_retornar.png" width="16"
                                                                             height="16" border="0"
                                                                             alt="Revertir Estado de Documento">
                                                                    </a>
                                                                    <?php echo "<a style=\"color:#0067CE\" href=\"registroObsFinalizar.php?iCodMovimiento=" . $RsTra['iCodMovimiento'] . "\" rel=\"lyteframe\" title=\"Modificar Observacion\" rev=\"width: 410px; height: 280px; scrolling: no; border:no\"><img src='images/icon_avance.png' width='16' height='16' border='0'></a>";
                                                                    ?>
                                                                    <a href="registroTemaSelect.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>&iCodOficinaRegistro=<?= $_SESSION['iCodOficinaLogin'] ?>"
                                                                       rel="lyteframe" title="Vincular Tema"
                                                                       rev="width: 600px; height: 400px; scrolling: auto; border:no">
                                                                        <img src="images/page_add.png" width="22"
                                                                             height="20" border="0">
                                                                    </a>
                                                                    <?php
                                                                    if ($RsTra['flg_libreblanco'] == '' or $RsTra['flg_libreblanco'] == '0') {
                                                                        ?>
                                                                        <a title="Libro Blanco"
                                                                           href="flg_libroblanco.php?opcion=1&iCodTramite=<?= $RsTra['iCodTramite'] ?>&page=2">
                                                                            <img src="images/notebook_0.png" border='0'
                                                                                 alt="Libro Blanco">
                                                                        </a>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <a title="Libro Blanco"
                                                                           href="flg_libroblanco.php?opcion=0&iCodTramite=<?= $RsTra['iCodTramite'] ?>&page=2">
                                                                            <img src="images/notebook_1.png" border='0'
                                                                                 alt="Libro Blanco">
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                        }
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
                                                     <?php if($numrows>0){ ?>
                                                     Resultados del <?php echo $ini +1 ; ?> al <?php echo $fin ;} ?>
                                                 </b>
                                                 <br>
                                                 <b>
                                                     Total: <?php echo $numrows; ?>
                                                 </b>
                                                 <br>
                                             </div>
                                             <br>
                                             <?php
                                             include_once "../core/paginador.php";
                                             echo paginar($pag, $numrows, $tampag, "pendientesFinalizados.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&iCodTema=".(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&cantidadfilas=".(isset($_GET['cantidadfilas'])?$_GET['cantidadfilas']:'')."&pag="); ?>
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
        function Buscar()
        {
            document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>";
            document.frmConsulta.submit();
        }

        //Para Cantidad de filas
        document.getElementById(<?php echo $tampag?>).selected = true;

        function actualizarfilas(){
            var valor =Number.parseInt(document.getElementById('filas').value);
            var direc =window.location.pathname;
            window.location =direc+"?cantidadfilas="+valor;
        }
        //--></script>
</body>
</html>
<?php
} else{
   header("Location: ../index-b.php?alter=5");
}
?>