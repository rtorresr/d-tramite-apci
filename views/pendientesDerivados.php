<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
//Inicia valores paginacion
$pag=($_GET['pag']??1);
$tampag=($_GET['cantidadfilas']??5);

if($_SESSION['CODIGO_TRABAJADOR']!==''){
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
    </head>
    <body>
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
                        <div class="card-header text-center ">
                            BANDEJA DE DERIVADOS
                        </div>
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
                                                            <input type="checkbox" name="Entrada" class="form-check-input" id="Entrada" value="1" <?php  if (isset($_GET['Entrada'])){if($_GET['Entrada'] ===1){echo 'checked';}else{echo '';}}?> onclick="activaEntrada();">
                                                            <label class="form-check-label" for="Entrada">Entrada </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" name="Interno" class="form-check-input" id="Interno" value="1" <?php if(isset($_GET['Interno'])){if($_GET['Interno'] ===1) {echo 'checked';}else{echo '';}}?> onclick="activaInterno();">
                                                            <label class="form-check-label" for="Interno">Internos </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="md-form">
                                                            <input placeholder="dd-mm-aaaa" value="<?=(isset($_GET['fDesde'])??'')?>" type="text"
                                                                   id="date-picker-example" name="fDesde"  class="FormPropertReg form-control datepicker">
                                                            <label for="date-picker-example">Desde:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="md-form">
                                                            <input placeholder="dd-mm-aaaa" name="fHasta" value="<?=(isset($_GET['fHasta'])??'')?>" type="text"
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
                                                                <?php    include_once("../conexion/conexion.php");
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
                                                                <?php
                                                                $sqlTem="SELECT * FROM Tra_M_Temas WHERE  iCodOficina = '".$_SESSION['iCodOficinaLogin']."' ";
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
                                                        <div >
                                                            <label for="iCodOficinaDes" class="select">Oficina Destino:</label>
                                                            <select name="iCodOficinaDes" id="iCodOficinaDes" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                    searchable="Buscar aqui..">
                                                                <option value="">Seleccione:</option>
                                                                <?php    $sqlOfi="SP_OFICINA_LISTA_COMBO ";
                                                                $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                                while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                                                    if($RsOfi["iCodOficina"]==$_GET['iCodOficinaDes']){
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
                                                                        <button class="botpelota waves-effect btn-sm mx-1" title="Excel" onclick="window.open('pendientesDerivadosExcel.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorFinalizar=<?=((isset($_GET['iCodTrabajadorFinalizar']))?$_GET['iCodTrabajadorFinalizar']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&iCodOficina=<?=$_SESSION['iCodOficinaLogin']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                            <i class="far fa-file-excel"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-">
                                                                        <button class="botpelota waves-effect btn-sm mx-1" title="Pdf" onclick="window.open('pendientesDerivadosPdf.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Anexo=<?=(isset($_GET['Anexo'])?$_GET['Anexo']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorResponsable=<?=(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')?>&iCodTrabajadorDelegado=<?=(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&Aceptado=<?=(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')?>&SAceptado=<?=(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')?>', '_blank');" onMouseOver="this.style.cursor='hand'">
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
                                                    </tr>
                                                    <td>
                                                        <a href="<?=$_SERVER['PHP_SELF']?>?campo=Codigo&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Codigo"){ echo "underline"; }Else{ echo "none";}?>">
                                                            N° Trámite</a>
                                                    </td>
                                                    <td>
                                                        <a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">
                                                            Tipo de Documento</a>
                                                    </td>
                                                    <td>
                                                        <a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">
                                                            Nombre / Razón Social</a>
                                                    </td>
                                                    <td>
                                                        <a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">
                                                            Asunto / Procedimiento TUPA
                                                        </a>
                                                    </td>
                                                    <td>Derivado</td>
                                                    <td>
                                                        <a href="<?=$_SERVER['PHP_SELF']?>?campo=Tra_M_Tramite.cCodificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Tra_M_Tramite.cCodificacion"){ echo "underline"; }Else{ echo "none";}?>">
                                                            Derivado A:
                                                        </a>
                                                    </td>
                                                    <td>Edit</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $fdesde = $_GET['fDesde'] ?? '';
                                                    $fhasta = $_GET['fHasta'] ?? '';
                                                    if($fdesde!==''){
                                                        $fDesde=date("Ymd", strtotime($fdesde));
                                                    }else{
                                                        $fDesde = '';
                                                    }
                                                    if($fhasta!==''){
                                                        $fHasta=date('d-m-Y', strtotime($fhasta));
                                                        function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                                            $date_r = getdate(strtotime($date));
                                                            $date_result = date('Ymd', mktime(($date_r['hours']+$hh),($date_r['minutes']+$mn),($date_r['seconds']+$ss),($date_r['mon']+$mm),($date_r['mday']+$dd),($date_r['year']+$yy)));
                                                            return $date_result;
                                                        }
                                                        $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
                                                    }else{
                                                        $fHasta = '';
                                                    }
                                                    include_once('../conexion/conexion.php');
                                                    // ordenamiento
                                                    if(isset($_GET['campo'])){
                                                        if($_GET['campo']===''){
                                                            $campo="Fecha";
                                                        }Else{
                                                            $campo=$_GET['campo'];
                                                        }
                                                    }else{
                                                        $campo='';
                                                    }

                                                    if(isset($_GET['orden'])){
                                                        if($_GET['orden']===''){
                                                            $orden="DESC";
                                                        }
                                                        Else{
                                                            $orden=$_GET['orden'];
                                                        }
                                                    }else{
                                                        $orden='';
                                                    }

                                                    //invertir orden
                                                    $cambio='';
                                                    if(isset($orden)){
                                                        if($orden==='ASC') {
                                                            $cambio = 'DESC';
                                                        }
                                                    }

                                                    $Entrada = $_GET['Entrada'] ?? '';
                                                    $Interno = $_GET['Interno'] ?? '';
                                                    $cCodificacion = $_GET['cCodificacion'] ?? '';
                                                    $cAsunto = $_GET['cAsunto'] ?? '';
                                                    $cCodTipoDoc =  $_GET['cCodTipoDoc'] ?? '';
                                                    $iCodTema = $_GET['iCodTema'] ?? '';
                                                    $iCodOficinaDes =  $_GET['iCodOficinaDes'] ?? '';

                                                    $sqlTra= " SP_BANDEJA_DERIVADOS '".$Entrada."','".$Interno."','$fDesde','$fHasta','%".$cCodificacion."%','%".$cAsunto."%','".$_SESSION['iCodOficinaLogin']."','".$cCodTipoDoc."','".$iCodTema."' ,'".$iCodOficinaDes."','".$campo."','".$orden."'";
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

                                                                //if($numrows!==0){
                                                                ///////////////////////////////////////////////////////
                                                                //while ($RsTra = sqlsrv_fetch_array($rsTra)){
                                                                // for ($i=$reg1, $iMax = min($reg1 + $tampag, $total); $i < $iMax; $i++) {
                                                                //sqlsrv_fetch_array($rsTra, $i);
                                                                //$RsTra=sqlsrv_fetch_array($rsTra);
                                                                $color = '';
                                                                if ($color === '#DDEDFF') {
                                                                    $color = '#F9F9F9';
                                                                } else {
                                                                    $color = '#DDEDFF';
                                                                }
                                                                if ($color === '') {
                                                                    $color = '#F9F9F9';
                                                                }
                                                                ?>
                                                                <tr bgcolor="<?= $color ?>"
                                                                    onMouseOver="this.style.backgroundColor='#BFDEFF'"
                                                                    OnMouseOut="this.style.backgroundColor='<?= $color ?>'">
                                                                    <td>
                                                                        <?php if ($RsTra['nFlgTipoDoc'] === 1) { ?>
                                                                            <a href="registroDetalles.php?iCodTramite=<?= $RsTra['iCodTramite'] ?>"
                                                                               rel="lyteframe"
                                                                               title="Detalle del Trámite"
                                                                               rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                                                                <?= utf8_encode($RsTra['cCodificacion']) ?>
                                                                            </a>
                                                                        <?php }
                                                                        if ($RsTra['nFlgTipoDoc'] === 2) {
                                                                            echo 'INTERNO';
                                                                        }
                                                                        if ($RsTra['nFlgTipoDoc'] === 3) {
                                                                            echo 'SALIDA';
                                                                        }
                                                                        if ($RsTra['nFlgTipoDoc'] === 4) {
                                                                            ?>
                                                                            <a href="registroDetalles.php?iCodTramite=<?= $RsTra['iCodTramiteRel'] ?>"
                                                                               rel="lyteframe"
                                                                               title="Detalle del Trámite"
                                                                               rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                                                                <?= utf8_encode($RsTra['cCodificacion']) ?>
                                                                            </a>
                                                                        <?php }
                                                                        $datefd = date_create($RsTra['fFecRegistro']);
                                                                        echo '<div style=color:#727272>' . date_format($datefd, 'd/m/Y') . '</div>';
                                                                        echo '<div style=color:#727272;font-size:10px>' . date_format($datefd, 'G:i') . '</div>';

                                                                        if ($RsTra['cFlgTipoMovimiento'] === 4) {
                                                                            echo '<div style=color:#FF0000;font-size:12px>Copia</div>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($RsTra['nFlgTipoDoc'] === 1) {
                                                                            echo $RsTra['Documento'];
                                                                            echo '<div style=color:#808080;text-transform:uppercase>' . $RsTra['cNroDocumento'] . '</div>';
                                                                        } else {

                                                                            $sqlTrm = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='" . $RsTra['iCodTramite'] . "'";
                                                                            $rsTrm = sqlsrv_query($cnx, $sqlTrm);
                                                                            $RsTrm = sqlsrv_fetch_array($rsTrm);
                                                                            $sqlTpDcM = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='" . $RsTrm['cCodTipoDoc'] . "'";
                                                                            $rsTpDcM = sqlsrv_query($cnx, $sqlTpDcM);
                                                                            $RsTpDcM = sqlsrv_fetch_array($rsTpDcM);
                                                                            echo $RsTpDcM['cDescTipoDoc'];
                                                                            echo '<br>';
                                                                            echo '<a style=color:#0067CE href=registroOficinaDetalles.php?iCodTramite=' . $RsTra['iCodTramite'] . ' rel=lyteframe title="Detalle del Trámite" rev="width: 970px; height: 450px; scrolling: auto; border:no">';
                                                                            echo utf8_encode($RsTra['cCodificacion']);
                                                                            echo '</a>';
                                                                        }
                                                                        ?>
                                                                        <br>
                                                                        <b>
                                                                            <?php
                                                                            if (ltrim(rtrim($RsTra['cPrioridadDerivar'])) === "Alta") {
                                                                                echo "<span style='color=#ff0000'>Alta</span>";
                                                                            } elseif (ltrim(rtrim($RsTra['cPrioridadDerivar'])) === "Media") {
                                                                                echo "<span style='color=#07b52f'>Media</span>";
                                                                            } elseif (ltrim(rtrim($RsTra['cPrioridadDerivar'])) === "Baja") {
                                                                                echo "<span style='color=#aecc05'>Baja</span>";
                                                                            }
                                                                            ?>
                                                                        </b>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        echo $RsTra['cNomRemite'] ?? '';
                                                                        $rsRem = sqlsrv_query($cnx, "SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='" . $RsTra['iCodRemitente'] . "'");
                                                                        $RsRem = sqlsrv_fetch_array($rsRem);
                                                                        echo utf8_encode($RsRem['cNombre']);
                                                                        sqlsrv_free_stmt($rsRem);
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo utf8_encode($RsTra['cAsunto']); ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $fechafd = date_create($RsTra['fFecDerivar']);
                                                                        echo '<div style=color:#0154AF>' . date_format($datefd, 'd-m-Y') . '</div>';
                                                                        echo '<div style=color:#0154AF>' . date_format($datefd, 'G:i') . '</div>';
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $rsOfic = sqlsrv_query($cnx, 'SELECT * FROM Tra_M_Oficinas WHERE iCodOficina=' . $RsTra['iCodOficinaDerivar']);
                                                                        $RsOfic = sqlsrv_fetch_array($rsOfic);
                                                                        echo '<a href=javascript:; title=' . utf8_encode($RsOfic['cSiglaOficina']) . '>' . utf8_encode($RsOfic['cNomOficina']) . '</a>';
                                                                        sqlsrv_free_stmt($rsOfic);
                                                                        if ($RsTra['fFecRecepcion'] === '') {
                                                                            echo '<div style=color:#ff0000>sin aceptar</div>';
                                                                        } Else {
                                                                            echo '<div style=color:#0154AF;font-size:10px>' . date('d/m/Y', strtotime($RsTra['fFecRecepcion'])) . '</div>';
                                                                            echo '<div style=color:#0154AF;font-size:10px>' . date('G:i', strtotime($RsTra['fFecRecepcion'])) . '</div>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $sqlChk = "SELECT TOP 1 Tra_M_Tramite.iCodTramite, Tra_M_Tramite_Movimientos.iCodTramite
                                                                                 ,Tra_M_Tramite_Movimientos.iCodOficinaOrigen, Tra_M_Tramite_Movimientos.iCodOficinaDerivar
                                                                                 ,Tra_M_Tramite.nFlgEnvio, Tra_M_Tramite_Movimientos.nFlgTipoDoc, Tra_M_Tramite.cCodificacion
                                                                                 ,Tra_M_Tramite_Movimientos.iCodMovimiento 
                                                                            FROM Tra_M_Tramite, Tra_M_Tramite_Movimientos ";
                                                                        $sqlChk .= "WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
                                                                        $sqlChk .= "AND Tra_M_Tramite_Movimientos.iCodOficinaOrigen='" . $_SESSION['iCodOficinaLogin'] . "' ";
                                                                        $sqlChk .= "AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar!='" . $_SESSION['iCodOficinaLogin'] . "' ";
                                                                        $sqlChk .= "AND Tra_M_Tramite.nFlgEnvio=1 ";
                                                                        $sqlChk .= "AND nEstadoMovimiento!=2 ";
                                                                        $sqlChk .= "AND Tra_M_Tramite_Movimientos.nFlgTipoDoc!=3 ";
                                                                        $sqlChk .= "AND Tra_M_Tramite.cCodificacion='" . $RsTra['cCodificacion'] . "' ";
                                                                        $sqlChk .= "ORDER BY iCodMovimiento ASC";
                                                                        $rsChk = sqlsrv_query($cnx, $sqlChk);
                                                                        $RsChk = sqlsrv_fetch_array($rsChk);


                                                                        if ($RsChk['iCodMovimiento'] === $RsTra['iCodMovimiento']){
                                                                        ?>
                                                                        <a href="pendientesControlDerivarGenerarEditar.php?iCodMovimientoDerivar=<?= $RsTra['iCodMovimiento'] ?>"><i
                                                                                    class="fas fa-edit"></i>
                                                                            <?php
                                                                            $sql = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='" . $RsTra['iCodTramite'] . "'";
                                                                            $tramitePDF = sqlsrv_query($cnx, $sql);
                                                                            $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
                                                                            if ($RsTramitePDF->descripcion !== NULL && $RsTramitePDF->descripcion !== '') {
                                                                                ?>
                                                                                <a href="registroInternoDocumento_pdf.php?iCodTramite=<?php echo $RsTramitePDF->iCodTramite; ?>"
                                                                                   target="_blank"
                                                                                   title="Documento"><img
                                                                                            src="images/1471041812_pdf.png"
                                                                                            border="0" height="17"
                                                                                            width="17"></a>
                                                                                <?php
                                                                            }
                                                                            }

                                                                            $sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='" . $RsTra['iCodTramite'] . "'";
                                                                            $rsDw = sqlsrv_query($cnx, $sqlDw);

                                                                            if (sqlsrv_has_rows($rsDw) > 0) {
                                                                                $RsDw = sqlsrv_fetch_array($rsDw);

                                                                                if ($RsDw["cNombreNuevo"] !== '') {
                                                                                    if (file_exists("../cAlmacenArchivos/" . trim($RsDw['cNombreNuevo']))) {
                                                                                        echo '<a href=\"download.php?direccion=../cAlmacenArchivos/&file=' . trim($RsDw['cNombreNuevo']) . '\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"' . trim($RsDw['cNombreNuevo']) . '\"></a>';
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo '<img src=images/space.gif width=16 height=16 border=0>';
                                                                            }

                                                                            $libreBlanco = $RsTra['flg_libreblanco'] ?? '';
                                                                            if ($libreBlanco === '' || $libreBlanco === '0') {
                                                                                ?>
                                                                                <a title="Libro Blanco"
                                                                                   href="flg_libroblanco.php?opcion=1&iCodTramite=<?= $RsTra['iCodTramite'] ?>&page=3">
                                                                                    <img src="images/notebook_0.png"
                                                                                         border='0' alt="Libro Blanco">
                                                                                </a>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <a title="Libro Blanco"
                                                                                   href="flg_libroblanco.php?opcion=0&iCodTramite=<?= $RsTra['iCodTramite'] ?>&page=3">
                                                                                    <img src="images/notebook_1.png"
                                                                                         border='0' alt="Libro Blanco">
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
                                            echo paginar($pag, $numrows, $tampag, 'pendientesDerivados.php?fDesde='.(isset($_GET['fDesde'])?$_GET['fDesde']:'').'&fHasta='.(isset($_GET['fHasta'])?$_GET['fHasta']:'').'&cCodificacion='.(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'').'&cAsunto='.(isset($_GET['cAsunto'])?$_GET['cAsunto']:'').'&iCodTema='.(isset($_GET['iCodTema'])?$_GET['iCodTema']:'').'&iCodOficinaDes='.(isset($_GET['iCodOficinaDes'])?$_GET['iCodOficinaDes']:'').'&cCodTipoDoc='.(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'').'&Entrada='.(isset($_GET['Entrada'])?$_GET['Entrada']:'').'&Interno='.(isset($_GET['Interno'])?$_GET['Interno']:'').'&cantidadfilas='.(isset($_GET['cantidadfilas'])?$_GET['cantidadfilas']:'').'&pag='); ?>

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
    <?php include 'includes/userinfo.php'; ?>

    <?php include 'includes/pie.php';?>
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
    </script>
    </body>
    </html>

<?php }
    else{
    header('Location: ../index-b.php?alter=5');
    }
?>