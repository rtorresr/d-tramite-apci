<?php
session_start();
//Inicia valores paginacion
$pag = $_GET['pag']??1;
$tampag=$_GET['cantidadfilas']??5;
date_default_timezone_set('America/Lima');
if($_SESSION['CODIGO_TRABAJADOR']!=""){

    function cifras($num){
        if(strlen($num)==1){
            return "0".$num;
        }else{
            return $num;
        }
    }

    function fecha($fecha){
        $a=explode(" ",$fecha);
        $b=$a[0];

        $aa=explode("-",$b);
        $bb=cifras($aa[0])."-".cifras($aa[1])."-".$aa[2];
        return $bb;
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php"); ?>
        <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
        <link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
    </head>
    <body class="theme-default has-fixed-sidenav" >
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
                        <div class="card-header text-center "> BANDEJA DE PENDIENTES</div>
                        <!--Card content-->
                        <div class="card-body d-flex px-4 px-lg-5">

                            <div class="card ml-3" id="tablaResutado">
                                <div class="card-body px-4 px-lg-5">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-xl-11">
                                            <form name="formulario">
                                                <input type="hidden" name="opcion" value="">
                                                <input type="hidden" name="Entradax" value="<?=isset($_GET['Entrada'])?$_GET['Entrada']:''?>"  />
                                                <input type="hidden" name="Internox" value="<?=isset($_GET['Interno'])?$_GET['Interno']:''?>"  />
                                                <input type="hidden" name="Anexox" value="<?=isset($_GET['Anexo'])?$_GET['Anexo']:''?>"  />
                                                <input type="hidden" name="fDesdex" value="<?=isset($_GET['fDesde'])?$_GET['fDesde']:''?>"  />
                                                <input type="hidden" name="fHastax" value="<?=isset($_GET['fHasta'])?$_GET['fHasta']:''?>"  />
                                                <input type="hidden" name="cCodificacionx" value="<?=isset($_GET['cCodificacion'])?$_GET['cCodificacion']:''?>"  />
                                                <input type="hidden" name="cAsuntox" value="<?=isset($_GET['cAsunto'])?$_GET['cAsunto']:''?>"  />
                                                <input type="hidden" name="cCodTipoDocx" value="<?=isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:''?>"  />
                                                <input type="hidden" name="iCodTrabajadorDelegadox" value="<?=isset($_GET['cCodTipoDoc'])?$_GET['iCodTrabajadorDelegado']:''?>"  />
                                                <input type="hidden" name="iCodTemax" value="<?=isset($_GET['iCodTema'])?$_GET['iCodTema']:''?>"  />
                                                <input type="hidden" name="Aceptadox" value="<?=isset($_GET['Aceptado'])?$_GET['Aceptado']:''?>"  />
                                                <input type="hidden" name="SAceptadox" value="<?=isset($_GET['SAceptado'])?$_GET['SAceptado']:''?>"  />
                                                <input type="hidden" name="pagx" value="<?=isset($_GET['pag'])?$_GET['pag']:''?>"  />
                                                <input type="hidden" name="FechaPlazoFinal" value="<?=isset($_GET['FechaPlazoFinal'])?$_GET['FechaPlazoFinal']:''?>"  />
                                                <?php
                                                if(isset($_GET['fDesde'])){ if($_GET['fDesde']!=""){ $fDesde=date_format("Ymd", date_create(strtotime($_GET['fDesde']))); }}else {$fDesde='';}
                                                if(isset($_GET['fHasta'])){ if($_GET['fHasta']!=""){
                                                    $fHasta=date_format("Y-m-d", date_create(strtotime($_GET['fHasta'])));

                                                    function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                                        $date_r = getdate(strtotime($date));
                                                        $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
                                                        return $date_result;
                                                    }
                                                    $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
                                                }}else{
                                                    $fHasta="";
                                                }

                                                // ordenamiento
                                                if(isset($_GET['campo'])){ if($_GET['campo']==""){
                                                    $campo="Fecha";
                                                }Else{
                                                    $campo=$_GET['campo'];
                                                }}else{
                                                    $campo='';
                                                }

                                                if(isset($_GET['orden'])){  if($_GET['orden']==""){
                                                    $orden="DESC";
                                                }Else{
                                                    $orden=$_GET['orden'];
                                                }}else{
                                                    $orden='';
                                                }

                                                //invertir orden
                                                $cambio='';
                                                if(isset($orden)){ if($orden=="ASC") $cambio="DESC";
                                                if($orden=="DESC") $cambio="ASC";}


                                                $sqlTra = " SP_BANDEJA_PENDIENTES '".($fDesde??'')."','".($fHasta??'')."','".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."','".(isset($_GET['Interno'])?$_GET['Interno']:'')."','".(isset($_GET['Anexo'])?$_GET['Anexo']:'')."','%".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."%', ";
                                                $sqlTra.= "'%".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."%','".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."','".(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')."','".(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')."','".(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')."','".(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')."','".(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')."','".(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')."','".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
                                                //print_r($sqlTra); die();
                                                ?>

                                                <div class="row justify-content-center">
                                                    <button class="FormBotonAccion botenviar ml-auto mx-2" name="OpAceptar" disabled onclick="activaAceptar();"
                                                            onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Aceptar&nbsp;<i class="fas fa-clipboard-check"></i>
                                                    </button>
                                                    <button class="FormBotonAccion botenviar mx-2" name="OpDerivar" disabled onclick="activaDerivar();"
                                                            onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Derivar&nbsp;<i class="far fa-share-square"></i>
                                                    </button>
                                                    <button class="FormBotonAccion botenviar mx-2" name="OpDelegar" disabled onclick="activaDelegar();"
                                                            onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Delegar&nbsp;<i class="fas fa-user-friends"></i>
                                                    </button>
                                                    <button class="FormBotonAccion botenviar mx-2" name="OpFinalizar" disabled onclick="activaFinalizar();"
                                                            onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Finalizar&nbsp;<i class="fas fa-stopwatch"></i>
                                                    </button>
                                                    <button class="FormBotonAccion botenviar mx-2" name="OpAvance" disabled onclick="activaAvance();"
                                                            onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Avance&nbsp;<i class="fab fa-hubspot"></i>
                                                    </button>
                                                </div>
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
                                                            <th class="headColumnas"></th>
                                                            <th class="headColumnas">
                                                                <a href="<?=$_SERVER['PHP_SELF']?>?campo=Codigo&orden=<?=$cambio?>&Tra_M_Tramite.cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Codigo"){ echo "underline"; }Else{ echo "none";}?>">
                                                                    N&ordm; Trámite</a>
                                                            </th>
                                                            <th class="headColumnas">
                                                                <a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&nFlgTipoDoc=<?=(isset($_GET['nFlgTipoDoc'])?$_GET['nFlgTipoDoc']:'')?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento
                                                                </a>
                                                            </th>
                                                            <th class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cNombre&orden=<?=$cambio?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>"  style=" text-decoration:<?php if($campo=="cNombre"){ echo "underline"; }Else{ echo "none";}?>">
                                                                    Nombre / Razón Social</a>
                                                            </th>
                                                            <th class="headColumnas">
                                                                <a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto / Procedimiento TUPA</a>
                                                            </th>
                                                            <th class="headColumnas">Derivado Por</th>
                                                            <th class="headColumnas">
                                                                <a href="<?=$_SERVER['PHP_SELF']?>?campo=Recepcion&orden=<?=$cambio?>&fFecRecepcion=<?=(isset($_GET['fFecRecepcion'])?$_GET['fFecRecepcion']:'')?>"  style=" text-decoration:<?php if($campo=="Recepcion"){ echo "underline"; }Else{ echo "none";}?>">Recepción</a>
                                                            </th>
                                                            <th class="headColumnas">
                                                                <a href="<?=$_SERVER['PHP_SELF']?>?campo=Trabajador&orden=<?=$cambio?>&iCodTrabajadorDerivar=<?=(isset($_GET['iCodTrabajadorDerivar'])?$_GET['iCodTrabajadorDerivar']:'')?>"  style=" text-decoration:<?php if($campo=="Trabajador"){ echo "underline"; }Else{ echo "none";}?>">
                                                                    Responsable/ Delegado</a>
                                                            </th>
                                                            <th class="headColumnas">
                                                                <a href="<?=$_SERVER['PHP_SELF']?>?campo=Estado&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Estado"){ echo "underline"; }Else{ echo "none";}?>">Estado / Avance</a>
                                                            </th>
                                                            <th class="headColumnas">Opción</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        //Código para paginar
                                                        $rsTra = sqlsrv_query($cnx,$sqlTra,array(),array("Scrollable"=>"buffered"));
                                                        $numrows=sqlsrv_num_rows($rsTra);
                                                        $ini = ($pag-1) * $tampag;
                                                        $fin= min($ini+$tampag,$numrows);
                                                        if ($numrows !== 0){
                                                            for ($i=0; $i< $numrows; $i++) {
                                                                $RsTra = sqlsrv_fetch_array($rsTra);
                                                                if ($i >= $ini && $i < $fin) {
                                                        //fin del bloque (incluir al final las llaves })

                                                        //$numrows=sqlsrv_has_rows($rsTra);
                                                        //if (isset($numrows)) {
                                                        //    if ($numrows == 0) {
                                                        //    } else {
                                                        //        while ($RsTra = sqlsrv_fetch_array($rsTra)) {
                                                                    $color = '';
                                                                    if ($color == "#DDEDFF") {
                                                                        $color = "#F9F9F9";
                                                                    } else {
                                                                        $color = "#DDEDFF";
                                                                    }
                                                                    if ($color == "") {
                                                                        $color = "#F9F9F9";
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td><input type="hidden" name="FechaPlazoFinal"
                                                                                   value="<?php echo $RsTra['FechaPlazoFinal']; ?>">
                                                                        </td>
                                                                    </tr>
                                                                    <tr bgcolor="<?= $color ?>"
                                                                        onMouseOver="this.style.backgroundColor='#BFDEFF'"
                                                                        OnMouseOut="this.style.backgroundColor='<?= $color ?>'">
                                                                        <td>
                                                                            <?php if ($RsTra['fFecRecepcion'] != "") { ?>
                                                                                    <label for="ma<?= $RsTra['iCodMovimiento'] ?>">
                                                                                    <input type="checkbox" name="MovimientoAccion[]" id="ma<?= $RsTra['iCodMovimiento'] ?>" value="<?= $RsTra['iCodMovimiento'] ?>" onclick="activaOpciones4();">
                                                                                    <span></span>
                                                                                    </label>
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if ($RsTra['nFlgTipoDoc'] == 1) { ?>
                                                                                <a href="registroDetalles.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>&iCodMovimiento=<?= $RsTra['iCodMovimiento'] ?>&nFlgEstado=<?= $RsTra['nFlgEstado'] ?>"
                                                                                   rel="lyteframe"
                                                                                   title="Detalle del Tr?mite"
                                                                                   rev="width: 970px; height: 550px; scrolling: auto; border:no"><?= $RsTra['cCodificacion'] ?></a>
                                                                            <?php
                                                                            }
                                                                            if ($RsTra['nFlgTipoDoc'] == 2) {
                                                                                echo "INTERNO " . $RsTra['cCodificacionI'];
                                                                            }
                                                                            if ($RsTra['nFlgTipoDoc'] == 3) {
                                                                                echo "SALIDA";
                                                                            }
                                                                            if ($RsTra['nFlgTipoDoc'] == 4) {
                                                                                ?>
                                                                                <a href="registroDetalles.php?iCodTramite=<?= $RsTra['iCodTramiteRel'] ?>&iCodMovimiento=<?= $RsTra['iCodMovimiento'] ?>&nFlgEstado=<?= $RsTra['nFlgEstado'] ?>"
                                                                                   rel="lyteframe"
                                                                                   title="Detalle del Tr?mite"
                                                                                   rev="width: 970px; height: 550px; scrolling: auto; border:no"><?= $RsTra['cCodificacion'] ?></a>
                                                                            <?php
                                                                            } ?>
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
                                                                            <?php
                                                                            //$date = date_create(strtotime($RsTra['fFecRegistro']));
                                                                            $date = $RsTra['fFecRegistro'];
                                                                            $fFecRegistro = $date->format( 'd-m-Y');
                                                                            $horaRegistro = $date->format( 'H:i:s');

                                                                            echo "<div style=color:#727272>" . $fFecRegistro. "</div>";
                                                                            echo "<div style=color:#727272;font-size:10px>" . $horaRegistro . "</div>";
                                                                            if ($RsTra['cFlgTipoMovimiento'] == 4) {
                                                                                echo "<div style=color:#FF0000;font-size:12px>Copia</div>";
                                                                            }
                                                                            $sqlTrax = "SELECT * FROM Tra_M_Tramite TRA
                                    INNER JOIN Tra_M_Trabajadores TRAB ON TRA.iCodTrabajadorRegistro = TRAB.iCodTrabajador
                                    WHERE TRA.iCodTramite = " . $RsTra['iCodTramite'];
                                                                            $rsTrax = sqlsrv_query($cnx, $sqlTrax);
                                                                            $RsTrax = sqlsrv_fetch_array($rsTrax);
                                                                            echo utf8_encode("<div style=color:#808080;>" . $RsTrax['cNombresTrabajador'] . " " . $RsTrax['cApellidosTrabajador'] . "</div>");
                                                                            if ($RsTrax['ES_EXTERNO'] == 1) {
                                                                                echo "<div style=color:#FF00FF;>Usuario Web</div>";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td >
                                                                            <?php echo utf8_encode($RsTra['cDescTipoDoc']);
                                                                            if($RsTra['nFlgTipoDoc']==1 ){
                                                                                echo utf8_encode("<div style=color:#808080;text-transform:uppercase>".$RsTra['cNroDocumento']."</div>");
                                                                            }
                                                                            else if($RsTra['nFlgTipoDoc']==2 ){
                                                                                echo "<br>";
                                                                                echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del Tr?mite\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                                                                                echo utf8_encode($RsTra['cCodificacion']);
                                                                                echo "</a>";
                                                                            }
                                                                            else if($RsTra['nFlgTipoDoc']==3 ){
                                                                                echo "<br>";
                                                                                echo "<a style=\"color:#0067CE\" href=\"registroSalidaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del Tr?mite\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
                                                                                echo utf8_encode($RsTra['cCodificacion']);
                                                                                echo "</a>";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td >
                                                                            <?php
                                                                            echo utf8_encode($RsTra['cNomRemite']);
                                                                            $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
                                                                            $RsRem=sqlsrv_fetch_array($rsRem);
                                                                            if($RsRem['cTipoPersona']=='1'){
                                                                                echo utf8_encode("<div style=color:#000000;>".$RsRem['cNombre']."</div>");
                                                                                echo "<div style=color:#0154AF;font-size:10px;text-align:left>DNI: ".$RsRem['nNumDocumento']."</div>";
                                                                            }else if ($RsRem['cTipoPersona']=='2') {
                                                                                echo utf8_encode("<div style=color:#000000;>".$RsRem['cNombre']."</div>");
                                                                                echo utf8_encode("<div style=color:#408080;>".$RsTra['cNomRemite']."</div>");
                                                                                echo "<div style=color:#0154AF;font-size:10px;>RUC:".$RsRem['nNumDocumento']."</div>";
                                                                            } else {
                                                                                echo utf8_encode("<div style=color:#000000;>".$RsRem['cNombre']."</div>");
                                                                            }
                                                                            sqlsrv_free_stmt($rsRem);

                                                                            if($RsTra['cFlgTipoMovimiento']==3){
                                                                                echo utf8_encode("<div style=color:#006600;><b>ANEXO</b></div>");
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td >
                                                                            <?php
                                                                            echo utf8_encode($RsTra['cAsunto']);
                                                                            if($RsTra['iCodTupa']!=""){
                                                                                $sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$RsTra['iCodTupa']."'";
                                                                                $rsTup=sqlsrv_query($cnx,$sqlTup);
                                                                                $RsTup=sqlsrv_fetch_array($rsTup);
                                                                                echo utf8_encode("<div style=color:#0154AF>".$RsTup["cNomTupa"]."</div");
                                                                            }
                                                                            ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php

                                                                            $sqlSig = "SP_OFICINA_LISTA_AR '$RsTra[iCodOficinaOrigen]'";
                                                                            $rsSig  = sqlsrv_query($cnx,$sqlSig);
                                                                            $RsSig  = sqlsrv_fetch_array($rsSig);
                                                                            echo utf8_encode($RsSig["cSiglaOficina"]);
                                                                            sqlsrv_free_stmt($rsSig);
                                                                            if($RsTra['iCodTramiteDerivar']!=""){
                                                                                $sqlTraD = "SELECT cCodificacion, iCodTramite,cCodTipoDoc FROM tra_M_Tramite WHERE iCodTramite='".$RsTra['iCodTramiteDerivar']."'";
                                                                                //echo "consulta".$sqlTraD;
                                                                                $rsTraD  = sqlsrv_query($cnx,$sqlTraD);
                                                                                $RsTraD  = sqlsrv_fetch_array($rsTraD);
                                                                                $sqlTipDoc1 = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$RsTraD['cCodTipoDoc']."'";
                                                                                $rsTipDoc1  = sqlsrv_query($cnx,$sqlTipDoc1);
                                                                                $RsTipDoc1  = sqlsrv_fetch_array($rsTipDoc1);
                                                                                echo utf8_encode(" <div style=color:#0154AF;font-size:10px align=left>".$RsTipDoc1['cDescTipoDoc']."</div>");
                                                                                echo utf8_encode("<div style=color:#0154AF;font-size:10px align=left>".$RsTraD['cCodificacion']."</div>");
                                                                            }
                                                                            $sqlIndic = "SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='".$RsTra['iCodIndicacionDerivar']."'";
                                                                            $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                                                            $RsIndic=sqlsrv_fetch_array($rsIndic);
                                                                            echo utf8_encode("<div style=color:#808080;font-size:10px align=left>".$RsIndic["cIndicacion"]."</div>");
                                                                            sqlsrv_free_stmt($rsIndic);
                                                                            ?>

                                                                            <?php
                                                                            $sqlfecha1 =  "SELECT iCodMovimiento,iCodTramite,iCodOficinaOrigen,fFecRecepcion,iCodOficinaDerivar,iCodTrabajadorDerivar,
                                    cCodTipoDocDerivar,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,iCodTrabajadorDelegado,fFecDelegado, 
                                    nEstadoMovimiento,cFlgTipoMovimiento,cNumDocumentoDerivar,cReferenciaDerivar,iCodTramiteDerivar 
                                FROM Tra_M_Tramite_Movimientos 
                                WHERE (iCodTramite='".$RsTra['iCodTramite']."' OR iCodTramiteRel='".$RsTra['iCodTramite']."') 
                                            AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) 
                                ORDER BY iCodMovimiento DESC";
                                                                            $rsFecha1 = sqlsrv_query($cnx,$sqlfecha1);

                                                                            while ($RsFecha1 = sqlsrv_fetch_array($rsFecha1)) {
                                                                                if ($_SESSION['iCodOficinaLogin'] == $RsFecha1['iCodOficinaDerivar']) {
                                                                                    $fFecDerivar = $RsFecha1['fFecDerivar'];
                                                                                }
                                                                            }
                                                                            if (isset($fFecDerivar)) {
                                                                                //$datefd = date_create(strtotime($fFecDerivar));
                                                                                //echo "<div style=color:#0154AF>".date_format($datefd, 'd-m-Y')."</div>";
                                                                                //echo "<div style=color:#0154AF;font-size:10px>".date_format($datefd, 'G:i')."</div>";

                                                                                echo "<div style=color:#0154AF;font-size:10px>".date_format($fFecDerivar,'d-m-Y')."</div>";
                                                                                echo "<div style=color:#0154AF;font-size:10px>".date_format($fFecDerivar,'G:i')."</div>";

                                                                            }else{
                                                                                $rsFecha1 = sqlsrv_query($cnx,$sqlfecha1);
                                                                                $RsFecha1 = sqlsrv_fetch_array($rsFecha1);
                                                                            }
                                                                            ?>

                                                                            <?php if(isset($RsTra['iCodMovAsociado'])) if($RsTra['iCodMovAsociado']!=""){
                                                                                $sqlAsoc="SELECT cNumDocumentoDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento==".$RsTra['iCodMovAsociado'];
                                                                                $rsAsoc=sqlsrv_query($cnx,$sqlAsoc);
                                                                                $numAsoc=sqlsrv_num_rows($rsAsoc);
                                                                                $RsModA=sqlsrv_fetch_array($rsAsoc);
                                                                                if($numAsoc>0){
                                                                                    echo "Doc. Asociado </br>";
                                                                                    echo $RsModA['cNumDocumentoDerivar'];
                                                                                }} ?>

                                                                        </td>
                                                                        <td >
                                                                            <?php

                                                                            //$date = date_create(strtotime($RsTra['fFecRegistro']));
                                                                            ///
                                                                            $sqlfecha =  "SELECT TOP 1 iCodMovimiento, iCodTramite,iCodOficinaOrigen,fFecRecepcion,iCodOficinaDerivar,iCodTrabajadorDerivar,
                                    cCodTipoDocDerivar,cAsuntoDerivar, cObservacionesDerivar, fFecDerivar,iCodTrabajadorDelegado,fFecDelegado, 
                                    nEstadoMovimiento,cFlgTipoMovimiento, cNumDocumentoDerivar,cReferenciaDerivar,iCodTramiteDerivar 
                                FROM Tra_M_Tramite_Movimientos 
                                WHERE (iCodTramite='".$RsTra['iCodTramite']."' OR iCodTramiteRel='".$RsTra['iCodTramite']."') 
                                            AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) 
                                ORDER BY iCodMovimiento DESC";

                                                                            $rsFecha = sqlsrv_query($cnx,$sqlfecha);
                                                                            $RsFecha = sqlsrv_fetch_array($rsFecha);


                                                                            if(is_null($RsFecha['fFecRecepcion'])){
                                                                                echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                            } else {
                                                                                echo "<div style=color:#0154AF>aceptado</div>";
                                                                                echo "<div style=color:#0154AF>".$RsFecha['fFecRecepcion']->format("d-m-Y")."</div>";
                                                                                echo "<div style=color:#0154AF;font-size:10px>".$RsFecha['fFecRecepcion']->format("G:i")."</div>";
                                                                            }
                                                                            ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php


                                                                            $rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra['iCodTrabajadorDerivar']."'");
                                                                            $RsResp=sqlsrv_fetch_array($rsResp);
                                                                            echo utf8_encode($RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"]);
                                                                            sqlsrv_free_stmt($rsResp);



                                                                            if($RsTra['iCodTrabajadorDelegado']!=""){
                                                                                $sqlDelg="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra['iCodTrabajadorDelegado']."' ";

                                                                                //echo "delegado".$RsTra['fFecDelegadoRecepcion'];

                                                                                $rsDelg=sqlsrv_query($cnx,$sqlDelg);
                                                                                $RsDelg=sqlsrv_fetch_array($rsDelg);
                                                                                echo utf8_encode("<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>");
                                                                                sqlsrv_free_stmt($rsDelg);
                                                                                if($RsTra['fFecDelegadoRecepcion']==""){
                                                                                    echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                                }Else{

                                                                                    $sql= "select fFecDelegado from Tra_M_Tramite_Movimientos where iCodTramite='".$RsTra['iCodTramite']."'";

                                                                                    //echo "consulta".$sql;
                                                                                    $query=sqlsrv_query($cnx,$sql);
                                                                                    $rs=sqlsrv_fetch_array($query);
                                                                                    do{
                                                                                        if($rs['fFecDelegado']!=''){
                                                                                            $tiempo=$rs['fFecDelegado'];
                                                                                        }
                                                                                    }while($rs=sqlsrv_fetch_array($query));
                                                                                    //echo "tiempo:".$tiempo;

                                                                                    echo "<div style=color:#0154AF>aceptado</div>";
                                                                                    echo "<div style=color:#0154AF>".date_format($tiempo, "d-m-Y")."</div>";
                                                                                    echo "<div style=color:#0154AF;font-size:10px;>".date_format($tiempo, "G:i")."</div>";
                                                                                }
                                                                            }
                                                                            if($RsTra['nEstadoMovimiento']==4){ //respondido
                                                                                echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsTra['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                                                            }
                                                                            ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php

                                                                            if($RsTra['fFecRecepcion']==""){
                                                                                switch ($RsTra['nEstadoMovimiento']){
                                                                                    case 1:
                                                                                        echo "Pendiente";
                                                                                        break;
                                                                                    case 2:
                                                                                        echo "Derivado";
                                                                                        break;
                                                                                    case 3:
                                                                                        echo "Asignado";
                                                                                        break;
                                                                                    case 4:
                                                                                        echo "Finalizado";
                                                                                        break;
                                                                                }
                                                                            }else{
                                                                                echo "En Proceso";
                                                                            }
                                                                            $sqlAvan = "SELECT TOP(1) * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento = '".$RsTra['iCodMovimiento']."' ORDER BY iCodAvance DESC";
                                                                            $rsAvan = sqlsrv_query($cnx,$sqlAvan);
                                                                            if(sqlsrv_num_rows($rsAvan) > 0){
                                                                                $RsAvan = sqlsrv_fetch_array($rsAvan);
                                                                                echo "<hr>";
                                                                            }
                                                                            ?>
                                                                            <a href="listadoDeAvances.php?iCodTramite=<?=$RsTra['iCodTramite']?>&iCodOficinaRegistro=<?=$_SESSION['iCodOficinaLogin']?>&iCodMovimiento=<?=$RsTra['iCodMovimiento']?>" rel="lyteframe" title="Listado de Avances" rev="width: 600px; height: 400px; scrolling: auto; border:no">
                                                                                <img src="images/page_add.png" width="22" height="20" border="0">
                                                                            </a>
                                                                        </td>
                                                                        <td width="78" valign="middle">
                                                                            <?php
                                                                            if (isset($RsTra['cFlgTipoMovimiento'])) {
                                                                            if ($RsTra['cFlgTipoMovimiento'] != 4){
                                                                                ?>
                                                                                <?php if ($RsTra['fFecRecepcion'] == ""){ ?>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" name="iCodMovimiento[]" id="<?= $RsTra['iCodMovimiento'] ?>" value="<?= $RsTra['iCodMovimiento'] ?>"
                                                                                           class="form-check-input" onclick="activaOpciones1();">
                                                                                    <label class="form-check-label" for="<?= $RsTra['iCodMovimiento'] ?>"></label>
                                                                                </div>

                                                                                <?php
                                                                            }else{ ?>
                                                                                <?php if ($RsTra['cFlgTipoMovimiento'] != 3){ ?>
                                                                                <div class="form-check">
                                                                                    <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"
                                                                                           value="<?= $RsTra['iCodMovimiento'] ?>" onclick="activaOpciones2();" name="iCodMovimientoAccion">
                                                                                    <label class="form-check-label" for="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"></label>
                                                                                </div>

                                                                                <?php
                                                                            }else{ ?>
                                                                                <div class="form-check">
                                                                                    <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"
                                                                                           value="<?= $RsTra['iCodMovimiento'] ?>" onclick="activaOpciones2();" name="iCodMovimientoAccion">
                                                                                    <label class="form-check-label" for="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"></label>
                                                                                </div>
                                                                                <?php
                                                                            } ?>

                                                                                <?php if ($RsTra['iCodTupa'] == "" && $RsTra['nFlgTipoDoc'] == 1){ ?>
                                                                                <a href="registroDiasVigencia.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>" rel="lyteframe"
                                                                                   title="Ingresar Plazo de tramite" rev="width: 440px; height: 180px; scrolling: auto; border:no"><img
                                                                                            src="images/icon_calendar.png" width="22" height="20" border="0"></a>
                                                                                <?php
                                                                            } ?>

                                                                                <?php if ($RsTra['nFlgTipoDoc'] == 1 or $RsTra['nFlgTipoDoc'] == 2){ ?>
                                                                                <a href="registroTemaSelect.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>&iCodOficinaRegistro=<?= $_SESSION['iCodOficinaLogin'] ?>"
                                                                                   rel="lyteframe" title="Vincular Tema" rev="width: 600px; height: 400px; scrolling: auto; border:no"><img
                                                                                            src="images/page_add.png" width="22" height="20" border="0"></a>
                                                                                <?php
                                                                            } ?>
                                                                                <!-- Inicio Max -->
                                                                                <?php
                                                                            if ($RsTra['flg_libreblanco'] == '' OR $RsTra['flg_libreblanco'] == '0'){
                                                                                ?>
                                                                                <a title="Libro Blanco" href="flg_libroblanco.php?opcion=1&iCodTramite=<?= $RsTra['iCodTramite'] ?>&page=1">
                                                                                    <img src="images/notebook_0.png" border='0' alt="Libro Blanco">
                                                                                </a>
                                                                                <?php
                                                                            }else{
                                                                                ?>
                                                                                <a title="Libro Blanco" href="flg_libroblanco.php?opcion=0&iCodTramite=<?= $RsTra['iCodTramite'] ?>&page=1">
                                                                                    <img src="images/notebook_1.png" border='0' alt="Libro Blanco">
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                                ?>
                                                                                <!-- Fin Max -->
                                                                                <?php
                                                                            } ?>
                                                                                <?php
                                                                            }
                                                                            else if ($RsTra['cFlgTipoMovimiento'] == 4){
                                                                            if ($RsTra['fFecRecepcion'] == ""){ ?>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" name="iCodMovimiento[]" id="ma<?= $RsTra['iCodMovimiento'] ?>"
                                                                                           value="<?= $RsTra['iCodMovimiento'] ?>" class="form-check-input" onclick="activaOpciones1();">
                                                                                    <label class="form-check-label" for="ma<?= $RsTra['iCodMovimiento'] ?>"></label>
                                                                                </div>
                                                                            <?php }else{
                                                                            if ($RsTra['nFlgTipoDoc'] == 3){ ?>
                                                                                <div class="form-check">
                                                                                    <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"
                                                                                           value="<?= $RsTra['iCodMovimiento'] ?>" onclick="activaOpciones2();" name="iCodMovimientoAccion">
                                                                                    <label class="form-check-label" for="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"></label>
                                                                                </div>
                                                                            <?php }else{ ?>
                                                                                <div class="form-check">
                                                                                    <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"
                                                                                           value="<?= $RsTra['iCodMovimiento'] ?>" onclick="activaOpciones2();" name="iCodMovimientoAccion">
                                                                                    <label class="form-check-label" for="iCodMovimientoAccion<?= $RsTra['iCodMovimiento'] ?>"></label>
                                                                                </div>
                                                                                <!-- <input type="radio" name="iCodMovimientoAccion" value="<?= $RsTra['iCodMovimiento'] ?>" onclick="activaOpciones2();"> -->
                                                                                <a href="registroTemaSelect.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>&iCodOficinaRegistro=<?= $_SESSION['iCodOficinaLogin'] ?>"
                                                                                   rel="lyteframe" title="Vincular Tema" rev="width: 600px; height: 400px; scrolling: auto; border:no"><img
                                                                                            src="images/page_add.png" width="22" height="20" border="0"></a>
                                                                            <?php }
                                                                            }
                                                                            }// fin de cFlgTipoMovimiento = 4
                                                                            ?>
                                                                            <?php
                                                                            $tramitePDF = sqlsrv_query($cnx, "select descripcion,* from Tra_M_Tramite where iCodTramite='" . $RsTra['iCodTramite'] . "'");
                                                                            $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);

                                                                            if (strlen(rtrim(ltrim($RsTramitePDF->descripcion))) > 0) {
                                                                            ?>
                                                                            <hr>

                                                                                <a href="ver_digital.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>" rel="lyteframe" title="Ver Detalle Documento"
                                                                                   rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                                                                    <img src="images/1471041812_pdf.png" border="0" height="17" width="17">
                                                                                </a>

                                                                                <a href="pdf_digital.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>" title="Descargar Detalle Documento"
                                                                                   rev="width: 970px; height: 550px; scrolling: auto; border:no" target="_blank">
                                                                                    <img src="images/icon_print.png" border="0" height="17" width="17">
                                                                                </a>
                                                                            <?php }
                                                                            $consulta = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite =  " . $RsTra['iCodTramite'];
                                                                            $resultado = sqlsrv_query($cnx, $consulta);
                                                                            $data = sqlsrv_fetch_array($resultado);
                                                                            if ($data["cNombreNuevo"]) {
                                                                            $a = '../cAlmacenArchivos/&file=' . trim($data["cNombreNuevo"]);
                                                                            $b = $RsTra['iCodMovimiento'];
                                                                            $c = $RsTra['nFlgEstado'];
                                                                            ?>
                                                                                <script>
                                                                                    function url(a, b, c) {
                                                                                        var URLactual = window.location;
                                                                                        window.open('download.php?direccion=' + a + '&iCodMovimiento=' + b + '&nFlgEstado=' + c, '_blank');
                                                                                        setTimeout('document.location.reload()', 100)
                                                                                    }
                                                                                </script>
                                                                                <a href="javascript:url('<?php echo $a; ?>','<?php echo $b ?>','<?php echo $c ?>')"
                                                                                   title="Documento Complementario">
                                                                                    <?php
                                                                                    echo "<img src=images/icon_download.png border=0 width=16 height=16 alt=\"" . trim($data["cNombreNuevo"]) . "\">";
                                                                                    ?>
                                                                                </a>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <?php if ($RsTra['iCodTupa'] == "" && $RsTra['nFlgTipoDoc'] == 1){
                                                                            ; ?>

                                                                            <hr>
                                                                                <?php
                                                                                $fecha = strtotime(date('Y-m-d'));
                                                                                $fecha22 = date_create($RsTra['FechaPlazoFinal']);
                                                                                $fecha33 = date_format($fecha22, "Y-m-d");
                                                                                $fecha2 = strtotime($fecha33);
                                                                                if ($fecha33 == '') {
                                                                                    echo "";
                                                                                } else if ($fecha33 == date('Y-m-d')) {
                                                                                    echo "<span style='color:red'>Hoy Vence</span>";
                                                                                } else if ($fecha33 > date('Y-m-d')) {
                                                                                    $fecha = strtotime(date('Y-m-d'));
                                                                                    $fecha22 = date_create($RsTra['FechaPlazoFinal']);
                                                                                    $fecha33 = date_format($fecha22, "Y-m-d");
                                                                                    $fecha2 = strtotime($fecha33);

                                                                                    $min = 60; //60 segundos
                                                                                    $hora = 60 * $min;
                                                                                    $dia = 24 * $hora;
                                                                                    $mes = date('t') * $dia;
                                                                                    $diasfinalies = floor($fecha2 / $dia) - floor($fecha / $dia);


                                                                                    //echo "fecha2 ".$fecha2;
                                                                                    echo "<span style='color:red'> Quedan " . $diasfinalies . " Dia(s) </span>";
                                                                                } else if ($fecha33 < date('Y-m-d')) {
                                                                                    $fecha = strtotime(date('Y-m-d'));
                                                                                    $fecha2 = strtotime(date($RsTra['FechaPlazoFinal']));
                                                                                    $min = 60; //60 segundos
                                                                                    $hora = 60 * $min;
                                                                                    $dia = 24 * $hora;
                                                                                    $mes = date('t') * $dia;
                                                                                    $diasfinalies = floor($fecha2 / $dia) - floor($fecha / $dia);

                                                                                    echo "<span style='color:red'>Vencio hace " . abs($diasfinalies) . " Dia(s)</span>";
                                                                                }
                                                                                ?>
                                                                                <?php
                                                                            }
                                                                            }
                                                                            ?>

                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            sqlsrv_free_stmt($rsTra);
                                                        }
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
                                                echo paginar($pag, $numrows, $tampag, "pendientesControl.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&iCodTrabajadorResponsable=".(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')."&iCodTrabajadorDelegado=".(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&Anexo=".(isset($_GET['Anexo'])?$_GET['Anexo']:'')."&Aceptado=".(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')."&SAceptado=".(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')."&iCodTema=".(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')."&campo=".$campo."&orden=".$orden."&cantidadfilas=".$tampag."&pag="); ?>                                            </form>
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
        document.getElementById(<?php echo $tampag?>).selected = true;

        function actualizarfilas(){
            var valor =Number.parseInt(document.getElementById('filas').value);
            var direc =window.location.pathname;
            window.location =direc+"?cantidadfilas="+valor;
        }


        function activaOpciones1(){
            for (j=0; j < document.formulario.elements.length; j++){
                if(document.formulario.elements[j].type == "radio"){
                    document.formulario.elements[j].checked = 0;
                }
            }
            document.formulario.OpAceptar.disabled=false;
            document.formulario.OpDerivar.disabled=true;
            document.formulario.OpDelegar.disabled=true;
            document.formulario.OpFinalizar.disabled=true;
            document.formulario.OpAvance.disabled=true;
            document.formulario.OpAceptar.style.removeProperty("background-Color");
            document.formulario.OpAceptar.filters.alpha.opacity=100;
            document.formulario.OpDerivar.filters.alpha.opacity=50;
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
            document.formulario.OpDerivar.disabled=false;
            document.formulario.OpDelegar.disabled=false;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=false;
            document.formulario.OpDerivar.style.removeProperty("background-Color");
            document.formulario.OpDelegar.style.removeProperty("background-Color");
            document.formulario.OpFinalizar.style.removeProperty("background-Color");
            document.formulario.OpAvance.style.removeProperty("background-Color");
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpDerivar.filters.alpha.opacity=100;
            document.formulario.OpDelegar.filters.alpha.opacity=100;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=100;
            return false;
        }

        function activaOpciones5(){
            for (i=0;i<document.formulario.elements.length;i++){
                if(document.formulario.elements[i].type == "checkbox"){
                    document.formulario.elements[i].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=true;
            document.formulario.OpDerivar.disabled=true; // CUANDO ES COPIA Y SE HA ACEPTADO ENTONCES NO SE PUEDE DERIVAR
            document.formulario.OpDelegar.disabled=false;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=false;
            document.formulario.OpDelegar.style.removeProperty("background-Color");
            document.formulario.OpFinalizar.style.removeProperty("background-Color");
            document.formulario.OpAvance.style.removeProperty("background-Color");
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpDerivar.filters.alpha.opacity=100;
            document.formulario.OpDelegar.filters.alpha.opacity=100;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=100;
            return false;
        }

        function activaOpciones3(){
            for (i=0;i<document.formulario.elements.length;i++){
                if(document.formulario.elements[i].type == "checkbox"){
                    document.formulario.elements[i].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=true;
            document.formulario.OpDerivar.disabled=true;
            document.formulario.OpDelegar.disabled=false;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=true;
            document.formulario.OpDelegar.style.removeProperty("background-Color");
            document.formulario.OpFinalizar.style.removeProperty("background-Color");
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpDerivar.filters.alpha.opacity=50;
            document.formulario.OpDelegar.filters.alpha.opacity=50;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=50;
            return false;
        }

        function activaOpciones4(){
            for (j=0;j<document.formulario.elements.length;j++){
                if(document.formulario.elements[j].type == "radio"){
                    document.formulario.elements[j].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=true;
            document.formulario.OpDerivar.disabled=false;
            document.formulario.OpDelegar.disabled=false;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=false;
            document.formulario.OpDerivar.style.removeProperty("background-Color");
            document.formulario.OpDelegar.style.removeProperty("background-Color");
            document.formulario.OpFinalizar.style.removeProperty("background-Color");
            document.formulario.OpAvance.style.removeProperty("background-Color");
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpDerivar.filters.alpha.opacity=100;
            document.formulario.OpDelegar.filters.alpha.opacity=100;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=100;
            return false;
        }

        function activaAceptar()
        {
            document.formulario.opcion.value=1;
            document.formulario.method="POST";
            document.formulario.action="pendientesData.php";
            document.formulario.submit();
        }


        function activaDelegar()
        {
            document.formulario.method="POST";
            document.formulario.action="pendientesControlDelegar.php";
            document.formulario.submit();
        }

        function activaFinalizar()
        {
            document.formulario.method="POST";
            document.formulario.action="pendientesControlFinalizar.php";
            document.formulario.submit();
        }

        function activaAvance()
        {
            document.formulario.method="POST";
            document.formulario.action="pendientesControlAvance.php";
            document.formulario.submit();
        }

        function Buscar()
        {
            document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>";
            document.frmConsulta.submit();
        }
    </script>
    </body>
    </html>

    <?php
}Else{
    header("Location: ../index-b.php?alter=5");
}
?>