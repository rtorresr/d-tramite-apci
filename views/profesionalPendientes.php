<?php
session_start();
$pageTitle = "Bandeja de Pendientes - Profesional";
$activeItem = "profesionalPendientes.php";
$navExtended = true;
$pag = $_GET['pag']??1;
if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
if(isset($_GET['cantidadfilas'])){$tampag = $_GET['cantidadfilas'];}
else{$tampag=5;}
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

	include_once("../conexion/conexion.php");
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
                    <div class="card-header text-center "> BANDEJA DE PENDIENTES - PROFESIONAL</div>
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
                                                    <label class="select">Documentos:</label><br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="Entrada" value="1" class="form-check-input" id="Entrada" <?php if(''??$_GET['Entrada']==1) echo "checked"?>  >
                                                        <label class="form-check-label" for="Entrada">Entrada</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="Interno" value="1" class="form-check-input" id="Internos" <?php if(''??$_GET['Interno']==1) echo "checked"?>  >
                                                        <label class="form-check-label" for="Internos">Internos</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="md-form">
                                                        <input placeholder="dd-mm-aaaa" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" type="text"
                                                               id="fDesde" name="fDesde" class="FormPropertReg form-control datepicker">
                                                        <label for="fDesde">Desde:</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="md-form">
                                                        <input placeholder="dd-mm-aaaa" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" type="text"
                                                               id="fHasta" name="fHasta" class="FormPropertReg form-control datepicker">
                                                        <label for="fHasta">Hasta:</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="md-form">
                                                        <input type="text" id="cCodificacion" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control">
                                                        <label for="cCodificacion">N&ordm; Documento:</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="md-form">
                                                        <input type="text" id="cAsunto" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="65" class="FormPropertReg form-control">
                                                        <label for="cAsunto">Asunto:</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="cCodTipoDoc" class="select">Tipo Documento:</label>
                                                    <select name="cCodTipoDoc" id="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                            searchable="Buscar aqui..">
                                                        <option value="">Seleccione:</option>
                                                        <?php
                                                        include_once("../conexion/conexion.php");
                                                        $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
                                                        $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                                                        $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                        while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                            if($RsTipo["cCodTipoDoc"]==''??$_GET['cCodTipoDoc']){
                                                                $selecTipo="selected";
                                                            }Else{
                                                                $selecTipo="";
                                                            }
                                                            echo  utf8_encode("<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>");
                                                        }
                                                        sqlsrv_free_stmt($rsTipo);
                                                        ?>
                                                    </select>
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
                                                                    <button class="botpelota waves-effect btn-sm mx-1" title="Excel" onclick="window.open('profesionalExcel.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficina=<?=$_SESSION['iCodOficinaLogin']?>&iCodTrabajador=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                        <i class="far fa-file-excel"></i>
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
                                        <form name="formulario">
                                            <input type="hidden" name="opcion" value="">
                                            <input type="hidden" name="responder" value="1">
                                            <input type="hidden" name="iCodTramiteSel" id="iCodTramiteSel" value="" />

                                            <div class="row justify-content-center">
                                                <button class="FormBotonAccion botenviar ml-auto mx-2" title="Aceptar Documento" name="OpAceptar" disabled onclick="activaAceptar();"
                                                        onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Aceptar&nbsp;<i class="fas fa-clipboard-check"></i>
                                                </button>
                                                <button class="FormBotonAccion botenviar mx-2" name="OpEnviar" disabled onclick="activaEnviar();" title="Enviar a Profesional de la Oficina"
                                                        onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Enviar&nbsp;<i class="far fa-envelope"></i>
                                                </button>
                                                <button class="FormBotonAccion botenviar mx-2" name="OpDerivo" disabled onclick="activaDerivo();" title="Derivar a Oficina del Grupo"
                                                        onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Derivar&nbsp;<i class="far fa-share-square"></i>
                                                </button>
                                                <button class="FormBotonAccion botenviar mx-2" name="OpDelegar" disabled onclick="activaDelegar();" title="Responder al Jefe"
                                                        onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Responder&nbsp;<i class="fas fa-user-friends"></i>
                                                </button>
                                                <button class="FormBotonAccion botenviar mx-2" name="OpFinalizar" disabled onclick="activaFinalizar();" title="Finalizar Documento"
                                                        onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50);background-color: #1565c080">Finalizar&nbsp;<i class="fas fa-stopwatch"></i>
                                                </button>
                                                <button class="FormBotonAccion botenviar mx-2" name="OpAvance" disabled onclick="activaAvance();" title="Agregar un Avance"
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
                                                    <script>document.getElementById('<?php echo $tampag?>').selected=true;</script>
                                                </div>
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
                                                    $reg1 = ($pag>2?($pag-1) * $tampag:0);

                                                    // ordenamiento
                                                    $campo = '';
                                                    if(''??$_GET['campo']==""){
                                                        $campo="Tra_M_Tramite_Movimientos.iCodMovimiento";
                                                    }Else{
                                                        $campo=$_GET['campo']??'';
                                                    }
                                                    $orden = '';
                                                    if(''??$_GET['orden']==""){
                                                        $orden="DESC";
                                                    }Else{
                                                        $orden=$_GET['orden']??'';
                                                    }

                                                    //invertir orden
                                                    if($orden === "ASC") $cambio="DESC";
                                                    if($orden === "DESC") $cambio="ASC";

                                                    $fDesde=$_GET['fDesde']??'';
                                                    $fHasta=$_GET['fHasta']??'';

                                                    function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                                        $date_r = getdate(strtotime($date));
                                                        $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
                                                        return $date_result;
                                                    }
                                                    $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia

                                                    $sqlTra="SELECT Tra_M_Tramite.iCodTramite as Tramite,*, (convert(char(10),fFecRecepcion, 120) +  + Convert(char(8),fFecRecepcion, 114))  as fFecRecepcion,	
                                                                  (convert(char(10),fFecDelegado, 120) +  + Convert(char(8),fFecDelegado, 114))  as fFecDelegado,
                                                                 (convert(char(10),fFecDelegadoRecepcion, 120) +  + Convert(char(8),fFecDelegadoRecepcion, 114))  as fFecDelegadoRecepcion, Convert(char(10),FechaPlazoFinal, 120)  as FechaPlazoFinal
                                                              FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos ";
                                                    $sqlTra.="WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
                                                    if(''??$_GET['Entrada']==1 AND ''??$_GET['Interno']==""){
                                                        $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=1 ";
                                                    }
                                                    if(''??$_GET['Entrada']=="" AND ''??$_GET['Interno']==1){
                                                        $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=2 ";
                                                    }
                                                    if(''??$_GET['Entrada']==1 AND ''??$_GET['Interno']==1){
                                                        $sqlTra.="AND (Tra_M_Tramite.nFlgTipoDoc=1 OR Tra_M_Tramite.nFlgTipoDoc=2) ";
                                                    }
                                                    if(''??$_GET['fDesde']!="" AND ''??$_GET['fHasta']==""){
                                                        $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar>'$fDesde' ";
                                                    }
                                                    if(''??$_GET['fDesde']=="" AND ''??$_GET['fHasta']!=""){
                                                        $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar<='$fHasta' ";
                                                    }
                                                    if(''??$_GET['fDesde']!="" AND ''??$_GET['fHasta']!=""){
                                                        $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar BETWEEN '$fDesde' AND '$fHasta' ";
                                                    }
                                                    if(''??$_GET['cCodificacion']!=""){
                                                        $sqlTra.="AND Tra_M_Tramite.cCodificacion like '%".$_GET['cCodificacion']."%' ";
                                                    }
                                                    if(''??$_GET['cAsunto']!=""){
                                                        $sqlTra.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
                                                    }
                                                    if(''??$_GET['cCodTipoDoc']!=""){
                                                        $sqlTra.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
                                                    }
                                                    $sqlTra.="AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) ";
                                                    $sqlTra.="OR (Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') ) ";
                                                    $sqlTra.=" And Tra_M_Tramite_Movimientos.nEstadoMovimiento!=2 ";
                                                    $sqlTra.=" And Tra_M_Tramite.nFlgEnvio=1 ";
                                                    $sqlTra.="AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
                                                    $sqlTra.="ORDER BY Tra_M_Tramite_Movimientos.iCodMovimiento DESC";

                                                    //echo "consulta".$sqlTra;


                                                    $rsTra=sqlsrv_query($cnx,$sqlTra);
                                                    //print $sqlTra;

                                                    ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover ">
                                                    <thead class="text-center text-white" style="border-bottom: solid 1px rgba(0,0,0,0.47);background-color: #0f58ab">
                                                    <tr>
                                                        <th class="headColumnas">N&ordm; Documento</th>
                                                        <th class="headColumnas">Tipo Documento / Razón Social</th>
                                                        <th class="headColumnas">Asunto / Procedimiento TUPA</th>
                                                        <th class="headColumnas" width="80">Origen</th>
                                                        <th class="headColumnas" width="130">Delegado por  / Obs. Delegar</th>
                                                        <th class="headColumnas" width="80">Fecha/Estado</th>
                                                        <th class="headColumnas">Recepción</th>
                                                        <th class="headColumnas">Opción</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $numrows=sqlsrv_has_rows($rsTra);
                                                    $total = sqlsrv_has_rows($rsTra);
                                                    if($numrows==0){
                                                    }else{
                                                        ///////////////////////////////////////////////////////
                                                        $iMax = min($numrows,($reg1 + $tampag));
                                                        for ($i=$reg1; $i< $iMax; $i++) {
                                                            sqlsrv_fetch_array($rsTra, $i);
                                                            $RsTra=sqlsrv_fetch_array($rsTra);
                                                            ///////////////////////////////////////////////////////
                                                            //   while ($RsTra=sqlsrv_fetch_array($rsTra))
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
                                                                <td width="92" valign="top">
                                                                    <?php        if($RsTra['nFlgTipoDoc']==1){?>
                                                                        <a class="modal-trigger tooltipped" data-send="<?=$RsTra['iCodTramite']?>" onclick="getvalue(this)" data-position="left" data-tooltip="Detalle del Trámite" href="#modal1bpp" >
                                                                            <?=utf8_encode(ucwords(strtolower($RsTra['cCodificacion'])))?></a>
                                                                        <!--<a href="registroDetalles.php?iCodTramite=<?//=$RsTra['iCodTramite']?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?//=utf8_encode(ucwords(strtolower($RsTra['cCodificacion'])))?>
                                                                        </a>-->
                                                                    <?php }
                                                                    if($RsTra['nFlgTipoDoc']==2){
                                                                        echo "INTERNO";}
                                                                    if($RsTra['nFlgTipoDoc']==3){
                                                                        echo "SALIDA";}
                                                                    if($RsTra['nFlgTipoDoc']==4){
                                                                        ?>
                                                                        <a class="modal-trigger tooltipped" data-send="<?=$RsTra['iCodTramiteRel']??''?>" onclick="getvalue(this)" data-position="left" data-tooltip="Detalle del Trámite" href="#modal1bpp" >
                                                                            <?=utf8_encode(ucwords(strtolower($RsTra['cCodificacion']??'')))?></a>
                                                                        <!--<a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramiteRel']??''?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no">
                                                                            <?//=utf8_encode(ucwords(strtolower($RsTra['cCodificacion']??'')))?>
                                                                        </a>-->
                                                                    <?php } ?>
                                                                    <?php        echo "<div style=color:#727272>".''??$RsTra['fFecRegistro']->format("d-m-Y")."</div>";
                                                                    echo "<div style=color:#727272;font-size:10px>".''??$RsTra['fFecRegistro']->format("G:i")."</div>";
                                                                    if($RsTra['cFlgTipoMovimiento']==6){
                                                                        echo "<div style=color:#800000;font-size:10px;text-align:center>COPIA</div>";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td width="210" align="left" valign="top">
                                                                    <?php        $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTra[cCodTipoDoc]'";
                                                                    $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
                                                                    $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
                                                                    echo "<div>".utf8_encode(ucwords(strtolower($RsTipDoc['cDescTipoDoc'])))."</div>";
                                                                    if($RsTra['nFlgTipoDoc']==1 ){
                                                                        echo "<div style=color:#808080;text-transform:uppercase>".$RsTra['cNroDocumento']."</div>";
                                                                    }else if($RsTra['nFlgTipoDoc']==2 ){
                                                                        echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                                                                        echo $RsTra['cCodificacion'];
                                                                        echo "</a>";
                                                                    }else if($RsTra['nFlgTipoDoc']==3 ){
                                                                        echo "<br>";
                                                                        echo "<a style=\"color:#0067CE\" href=\"registroSalidaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
                                                                        echo $RsTra['cCodificacion'];
                                                                        echo "</a>";
                                                                    }
                                                                    $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
                                                                    $RsRem=sqlsrv_fetch_array($rsRem);
                                                                    echo utf8_encode(ucwords(strtolower($RsRem["cNombre"])));
                                                                    sqlsrv_free_stmt($rsRem);
                                                                    ?>
                                                                </td>
                                                                <td width="240" align="left" valign="top"><?=$RsTra['cAsunto']?></td>
                                                                <td align="center" valign="top">
                                                                    <?php        $sqlOfi="SP_OFICINA_LISTA_AR '$RsTra[iCodOficinaOrigen]'";
                                                                    $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                                    $RsOfi=sqlsrv_fetch_array($rsOfi);
                                                                    echo "<a href=\"javascript:;\" title=\"".utf8_encode(ucwords(strtolower(trim($RsOfi['cNomOficina']))))."\">".$RsOfi['cSiglaOficina']."</a>";
                                                                    sqlsrv_free_stmt($rsOfi);
                                                                    ?>
                                                                </td>
                                                                <td width="60" align="left" valign="top">
                                                                    <?php
                                                                    $sqlTrb = "SELECT * FROM Tra_M_Perfil_Ususario TPU
                                                                     INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
                                                                     WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."'";

                                                                    //$rsResp = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$_SESSION[JEFE]'");
                                                                    $rsResp = sqlsrv_query($cnx,$sqlTrb);
                                                                    $RsResp = sqlsrv_fetch_array($rsResp);
                                                                    echo "<div align=left>".utf8_encode(ucwords(strtolower($RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"])))."</div>";
                                                                    sqlsrv_free_stmt($rsResp);

                                                                    $sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsTra[iCodIndicacionDelegado]'";
                                                                    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                                                    $RsIndic=sqlsrv_fetch_array($rsIndic);
                                                                    echo "<div style=color:#808080;font-size:10px align=left>".utf8_encode(ucwords(strtolower($RsIndic["cIndicacion"])))."</div>";
                                                                    sqlsrv_free_stmt($rsIndic);
                                                                    ?>
                                                                    <div align="left"><?="Obs. ".$RsTra['cObservacionesDelegado']?></div>

                                                                </td>
                                                                <td width="100" valign="top">
                                                                    <?php if($RsTra['cFlgTipoMovimiento']==2){
                                                                        echo "<div style=color:#773C00>Enviado</div>";
                                                                    }
                                                                    echo "<div style=color:#0154AF><b>";
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
                                                                            echo "Finalizado";
                                                                            break;
                                                                    }
                                                                    echo "</b></div>";

                                                                    if($RsTra['iCodTrabajadorDelegado']!=""){
                                                                        echo "<div style=color:#0154AF>".''??$RsTra['fFecDelegado']->format("d-m-Y")."</div>";
                                                                        echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecDelegado']->format("G:i")."</div>";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td width="80" align="left" valign="top">
                                                                    <?php        if($RsTra['cFlgTipoMovimiento']!=2){
                                                                        if($RsTra['nEstadoMovimiento']==3){
                                                                            if($RsTra['fFecDelegadoRecepcion']==""){
                                                                                echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                            }Else{
                                                                                echo "<div style=color:#0154AF>aceptado</div>";
                                                                                echo "<div style=color:#0154AF>".''??$RsTra['fFecDelegadoRecepcion']->format("d-m-Y")."</div>";
                                                                                echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecDelegadoRecepcion']->format("G:i")."</div>";
                                                                            }
                                                                        }else{
                                                                            if($RsTra['cFlgTipoMovimiento']==6){
                                                                                if($RsTra['fFecDelegadoRecepcion']==""){
                                                                                    echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                                }Else{
                                                                                    echo "<div style=color:#0154AF>aceptado</div>";
                                                                                    echo "<div style=color:#0154AF>".''??$RsTra['fFecDelegadoRecepcion']->format("d-m-Y")."</div>";
                                                                                    echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecDelegadoRecepcion']->format("G:i")."</div>";
                                                                                }
                                                                            }
                                                                            else {
                                                                                if($RsTra['fFecRecepcion']==""){
                                                                                    echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                                }Else{
                                                                                    echo "<div style=color:#0154AF>aceptado</div>";
                                                                                    echo "<div style=color:#0154AF>".''??$RsTra['fFecRecepcion']->format("d-m-Y")."</div>";
                                                                                    echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecRecepcion']->format("G:i")."</div>";
                                                                                }
                                                                            }
                                                                        }
                                                                    }else {
                                                                        if($RsTra['fFecRecepcion']==""){
                                                                            echo "<div style=color:#ff0000>sin aceptar</div>";
                                                                        }Else{
                                                                            echo "<div style=color:#0154AF>aceptado</div>";
                                                                            echo "<div style=color:#0154AF>".''??$RsTra['fFecRecepcion']->format("d-m-Y")."</div>";
                                                                            echo "<div style=color:#0154AF;font-size:10px>".''??$RsTra['fFecRecepcion']->format("G:i")."</div>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td width="60" valign="top">
                                                                    <?php        if($RsTra['cFlgTipoMovimiento']!=2){
                                                                        if($RsTra['nEstadoMovimiento']==3){
                                                                            if($RsTra['fFecDelegadoRecepcion']==""){?>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" name="iCodMovimiento[]" class="form-check-input" id="iCodMovimiento<?=$RsTra['iCodMovimiento']?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
                                                                                    <label class="form-check-label" for="iCodMovimiento<?=$RsTra['iCodMovimiento']?>"> </label>
                                                                                </div>
                                                                            <?php }else{
                                                                                if($RsTra['cFlgTipoMovimiento']!=6){ ?>
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>" name="iCodMovimientoAccion" iCodTramite = "<?php echo $RsTra['iCodTramite']; ?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2(this);">
                                                                                        <label class="form-check-label" for="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>"></label>
                                                                                    </div>
                                                                                <?php } else{?>
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
                                                                                        <label class="form-check-label" for="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>"></label>
                                                                                    </div>
                                                                                <?php }
                                                                            }
                                                                        }else {
                                                                            if($RsTra['cFlgTipoMovimiento']==6){
                                                                                if($RsTra['fFecDelegadoRecepcion']==""){?>
                                                                                    <div class="form-check">
                                                                                        <input type="checkbox" name="iCodMovimiento[]" class="form-check-input" id="iCodMovimiento<?=$RsTra['iCodMovimiento']?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
                                                                                        <label class="form-check-label" for="iCodMovimiento<?=$RsTra['iCodMovimiento']?>"> </label>
                                                                                    </div>
                                                                                <?php }else {?>
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
                                                                                        <label class="form-check-label" for="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>"></label>
                                                                                    </div>
                                                                                <?php   }
                                                                            }
                                                                            else{
                                                                                if($RsTra['fFecRecepcion']==""){ ?>
                                                                                    <div class="form-check">
                                                                                        <input type="checkbox" name="iCodMovimiento[]" class="form-check-input" id="iCodMovimiento<?=$RsTra['iCodMovimiento']?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
                                                                                        <label class="form-check-label" for="iCodMovimiento<?=$RsTra['iCodMovimiento']?>"> </label>
                                                                                    </div>
                                                                                <?php	} else { ?>
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" id="iCodMovimientoAccion" name="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>" iCodTramite = "<?php echo $RsTra['iCodTramite']; ?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2(this);">
                                                                                        <label class="form-check-label" for="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>"></label>
                                                                                    </div>
                                                                                <?php	}
                                                                            }
                                                                        }
                                                                    }else{
                                                                        if($RsTra['nEstadoMovimiento']==3){
                                                                            if($RsTra['fFecDelegadoRecepcion']==""){?>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" name="iCodMovimiento[]" class="form-check-input" id="iCodMovimiento<?=$RsTra['iCodMovimiento']?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
                                                                                    <label class="form-check-label" for="iCodMovimiento<?=$RsTra['iCodMovimiento']?>"> </label>
                                                                                </div>
                                                                            <?php }else{
                                                                                if($RsTra['cFlgTipoMovimiento']!=6){ ?>
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2();">
                                                                                        <label class="form-check-label" for="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>"></label>
                                                                                    </div>
                                                                                <?php } else{?>
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
                                                                                        <label class="form-check-label" for="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>"></label>
                                                                                    </div>
                                                                                <?php }
                                                                            }
                                                                        }else {
                                                                            if($RsTra['fFecRecepcion']==""){ ?>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" name="iCodMovimiento[]" class="form-check-input" id="iCodMovimiento<?=$RsTra['iCodMovimiento']?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
                                                                                    <label class="form-check-label" for="iCodMovimiento<?=$RsTra['iCodMovimiento']?>"> </label>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <div class="form-check">
                                                                                    <input type="radio" class="form-check-input" id="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>" name="iCodMovimientoAccion" iCodTramite = "<?php echo $RsTra['iCodTramite']; ?>" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2(this);">
                                                                                    <label class="form-check-label" for="iCodMovimientoAccion<?=$RsTra['iCodMovimiento']?>"></label>
                                                                                </div>
                                                                            <?php }
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <!--inicio henry-->
                                                                    <?php if($RsTra['nFlgTipoDoc']==1){;?>
                                                                        <hr>
                                                                        <?php
                                                                        $fecha = strtotime(date('Y-m-d'));
                                                                        //$fecha2=strtotime($RsTra['FechaPlazoFinal']);
                                                                        $fecha22=date_create($RsTra['FechaPlazoFinal']);
                                                                        $fecha33=date_format($fecha22,"Y-m-d");
                                                                        //echo "fecha 1".date('d-m-Y');
                                                                        // echo "fecha 2".$fecha33;

                                                                        $fecha2=strtotime($fecha33);
                                                                        if($fecha33==''){
                                                                            echo "";
                                                                        }else if($fecha33==date('Y-m-d')){
                                                                            echo "<span style='color:red'>Hoy Vence</span>";
                                                                        }else if($fecha33>date('Y-m-d')){
                                                                            // date_format($datefd, 'Y-m-d')
                                                                            $fecha = strtotime(date('Y-m-d'));
                                                                            //$fecha2=strtotime($RsTra['FechaPlazoFinal']);
                                                                            $fecha22=date_create($RsTra['FechaPlazoFinal']);
                                                                            $fecha33=date_format($fecha22,"Y-m-d");
                                                                            $fecha2=strtotime($fecha33);

                                                                            // $fecha2 = strtotime(date($RsTra['FechaPlazoFinal']));
                                                                            $min = 60; //60 segundos
                                                                            $hora = 60*$min;
                                                                            $dia = 24*$hora;
                                                                            $mes = date('t')*$dia;
                                                                            $diasfinalies=floor($fecha2/$dia) - floor($fecha/$dia);



                                                                            //echo "fecha2 ".$fecha2;
                                                                            echo "<span style='color:red'> Quedan ".$diasfinalies." Dia(s) </span>";
                                                                        }else if($fecha33<date('Y-m-d')){
                                                                            $fecha = strtotime(date('Y-m-d'));
                                                                            $fecha2 = strtotime(date($RsTra['FechaPlazoFinal']));
                                                                            $min = 60; //60 segundos
                                                                            $hora = 60*$min;
                                                                            $dia = 24*$hora;
                                                                            $mes = date('t')*$dia;
                                                                            $diasfinalies=floor($fecha2/$dia) - floor($fecha/$dia);

                                                                            echo "<span style='color:red'>Vencio hace ".abs($diasfinalies)." Dia(s)</span>";
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                    <!--fin henry-->
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
                                                    Resultados del <?php echo $reg1+1 ; ?> al <?php echo min($total,($reg1+$tampag)) ; ?>
                                                </b>
                                                <br>
                                                <b>
                                                    Total: <?php echo $total; ?>
                                                </b>
                                                <br>
                                            </div>
                                            <br>
                                            <?php echo paginar($pag, $total, $tampag, "profesionalPendientes.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&cantidadfilas=".(isset($_GET['cantidadfilas'])?$_GET['cantidadfilas']:'')."&pag="); ?>
                                        </form>
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

<div id="modal1bpp" class="modal">
    <div class="modal-content"></div>
</div>

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php");?>

<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
    // Data Picker Initialization
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

    function getvalue(e) {
        const codigo = e.dataset.send;
        const nodocontent= document.querySelector('div#modal1bpp').querySelector('div.modal-content');

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

    //Para Cantidad de filas
    function actualizarfilas(){
        var valor =Number.parseInt(document.getElementById('filas').value);
        var direc =window.location.pathname;
        window.location =direc+"?cantidadfilas="+valor;
    }

    function activaOpciones1(){
        for (j=0;j<document.formulario.elements.length;j++){
            if(document.formulario.elements[j].type == "radio"){
            }
        }
        document.formulario.OpAceptar.disabled=false;
        document.formulario.OpEnviar.disabled=true;
        document.formulario.OpDelegar.disabled=true;
        document.formulario.OpFinalizar.disabled=true;
        document.formulario.OpAvance.disabled=true;
        document.formulario.OpAceptar.style.removeProperty("background-Color");
        document.formulario.OpAceptar.filters.alpha.opacity=100;
        document.formulario.OpEnviar.filters.alpha.opacity=50;
        document.formulario.OpDelegar.filters.alpha.opacity=50;
        document.formulario.OpFinalizar.filters.alpha.opacity=50;
        document.formulario.OpAvance.filters.alpha.opacity=50;
        return false;
    }

    function activaOpciones2(event){
        //alert(event.attr('iCodTramite'));
        for (i=0;i<document.formulario.elements.length;i++){
            if(document.formulario.elements[i].type == "checkbox"){
                document.formulario.elements[i].checked=0;
                //document.formulario.iCodTramite.value=event.;
            }
        }
        document.formulario.OpAceptar.disabled=true;
        document.formulario.OpEnviar.disabled=false;
        document.formulario.OpDelegar.disabled=false;
        document.formulario.OpFinalizar.disabled=false;
        document.formulario.OpAvance.disabled=false;
        document.formulario.OpDerivo.disabled=false;
        document.formulario.OpEnviar.style.removeProperty("background-Color");
        document.formulario.OpDelegar.style.removeProperty("background-Color");
        document.formulario.OpFinalizar.style.removeProperty("background-Color");
        document.formulario.OpAvance.style.removeProperty("background-Color");
        document.formulario.OpDerivo.style.removeProperty("background-Color");
        document.formulario.OpAceptar.filters.alpha.opacity=50;
        document.formulario.OpEnviar.filters.alpha.opacity=100;
        document.formulario.OpDelegar.filters.alpha.opacity=100;
        document.formulario.OpFinalizar.filters.alpha.opacity=100;
        document.formulario.OpAvance.filters.alpha.opacity=100;
        document.formulario.OpDerivo.filters.alpha.opacity=100;
        return false;
    }

    function activaOpciones3(){
        for (i=0;i<document.formulario.elements.length;i++){
            if(document.formulario.elements[i].type == "checkbox"){
                document.formulario.elements[i].checked=0;
            }
        }
        document.formulario.OpAceptar.disabled=true;
        document.formulario.OpEnviar.disabled=true;
        document.formulario.OpDelegar.disabled=true;
        document.formulario.OpFinalizar.disabled=false;
        document.formulario.OpAvance.disabled=true;
        document.formulario.OpDerivo.disabled=true;
        document.formulario.OpFinalizar.style.removeProperty("background-Color");
        document.formulario.OpAceptar.filters.alpha.opacity=50;
        document.formulario.OpEnviar.filters.alpha.opacity=50;
        document.formulario.OpDelegar.filters.alpha.opacity=50;
        document.formulario.OpFinalizar.filters.alpha.opacity=100;
        document.formulario.OpAvance.filters.alpha.opacity=50;
        document.formulario.OpDerivo.filters.alpha.opacity=50;
        return false;
    }

    function activaAceptar()
    {
        document.formulario.opcion.value=1;
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
        // Antes
        //document.formulario.action="profesionalResponder.php";
        // Después
        var codTramiteSel;
        for (i=0;i<document.formulario.elements.length;i++){
            if(document.formulario.elements[i].type == "radio"){
                if (document.formulario.elements[i].checked == true) {
                    codTramiteSel = document.formulario.elements[i].getAttribute('iCodTramite');
                }
            }
        }
        document.getElementById("iCodTramiteSel").value = codTramiteSel;
        document.formulario.action="registroOficina.php";
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

    function activaDerivo()
    {
        document.formulario.action="profesionalDerivo.php";
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