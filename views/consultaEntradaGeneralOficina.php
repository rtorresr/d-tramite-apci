<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR']!=""){
 include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

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
                    <div class="card-header text-center ">Consulta >> Doc. Entradas Generales (L)</div>
                    <!--Card content-->
                    <div class="card-body">

						<form name="frmConsultaEntrada" method="GET" action="consultaEntradaGeneralOficina.php">
                            <div class="form-row">
                                <div class="col-lg-2 ">
                                    <label for="cCodificacion">N&ordm; Tr&aacute;mite:</label>
                                    <input type="text" name="cCodificacion" id="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control" >
                                </div>
                                <?php
                                if(trim($_REQUEST[fHasta])==""){$fecfin = $_REQUEST[fHasta];}  else { $fecfin = $_REQUEST[fHasta]; }
                                if(trim($_REQUEST[fDesde])==""){$fecini = $_REQUEST[fDesde];} else { $fecini = $_REQUEST[fDesde]; }
                                ?>
                                <div class="col-lg-2 ">
                                    <div class="md-form">
                                        <input placeholder="dd-mm-aaaa" value="<?=$fecini?>" type="text"
                                               id="date-picker-example" name="fDesde"  class="FormPropertReg form-control datepicker">
                                        <label for="date-picker-example">Desde:</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 ">
                                    <div class="md-form">
                                        <input placeholder="dd-mm-aaaa" name="fHasta" value="<?=$fecfin?>" type="text"
                                               id="date-picker-example"  class="FormPropertReg form-control datepicker">
                                        <label for="date-picker-example">Hasta:</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 ">
                                    <label>Tipo Documento:</label>
                                    <select name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary" >
                                        <option value="">Seleccione:</option>
                                        <?php
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
                                <div class="col-lg-3">
                                    <div class="md-form">
                                        <!-- Anteriormente Asunto era Asunto -->
                                         <textarea type="text" name="cAsunto" id="cAsunto"
                                                   class="md-textarea md-textarea-auto form-control FormPropertReg" rows="1"><?=stripslashes($_GET['cAsunto'])?></textarea>
                                        <label for="cAsunto">Asunto:</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 ">
                                    <label for="cNroDocumento">Nro de Documento:</label>
                                    <input type="text" name="cNroDocumento" id="cNroDocumento" value="<?=$_GET['cNroDocumento']?>" size="28" class="FormPropertReg form-control" >
                                </div>
                                <div class="col-lg-2 ">
                                    <label for="cReferencia">Nro Referencia:</label>
                                    <input type="text" name="cReferencia" id="cReferencia" value="<?=$_GET[cReferencia]?>" size="28" class="FormPropertReg form-control" >
                                </div>
                                <div class="col-lg-2 ">
                                    <label for="cNombre">Instituci&oacute;n:</label>
                                    <input type="text" name="cNombre" id="cNombre" value="<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>" size="28" class="FormPropertReg form-control" >
                                </div>
                                <div class="col-lg-2 ">
                                    <label for="cNomRemite">Remitente:</label>
                                    <input type="text" name="cNomRemite" id="cNomRemite" value="<?=$_GET[cNomRemite]?>" size="28" class="FormPropertReg form-control" >
                                </div>
                                <div class="col-lg-2 ">
                                    <label>Oficina Origen:</label>
                                    <select name="iCodOficinaOri" class="FormPropertReg mdb-select colorful-select dropdown-primary" >
                                        <option value="">Seleccione:</option>
                                        <?php
$sqlOfi="SP_OFICINA_LISTA_COMBO";
                                        $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                        while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                            if($RsOfi["iCodOficina"]==$_GET[iCodOficinaOri]){
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
                                <div class="col-lg-2 ">
                                    <label>Oficina Destino:</label>
                                    <select name="iCodOficinaDes" class="FormPropertReg mdb-select colorful-select dropdown-primary" onchange="releer();">
                                        <option value="">Seleccione:</option>
                                        <?php
$sqlOfi="SP_OFICINA_LISTA_COMBO ";
                                        $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                        while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                            if($RsOfi["iCodOficina"]==$_GET[iCodOficinaDes]){
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
                                <div class="col-lg-2 ">
                                    <label>Proc. Tupa:</label>
                                    <select name="iCodTupa" class="FormPropertReg mdb-select colorful-select dropdown-primary" >
                                        <option value="">Seleccione:</option>
                                        <?php
$sqlTupa="SELECT * FROM Tra_M_Tupa ";
                                        $sqlTupa.="ORDER BY iCodTupa ASC";
                                        $rsTupa=sqlsrv_query($cnx,$sqlTupa);
                                        while ($RsTupa=sqlsrv_fetch_array($rsTupa)){
                                            if($RsTupa["iCodTupa"]==$_GET['iCodTupa']){
                                                $selecTupa="selected";
                                            } Else{
                                                $selecTupa="";
                                            }
                                            echo utf8_encode("<option value=".$RsTupa["iCodTupa"]." ".$selecTupa.">".$RsTupa["cNomTupa"]."</option>");
                                        }
                                        sqlsrv_free_stmt($rsTupa);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 ">
                                    <label>Responsable:</label>
                                    <select name="iCodTrabajadoResponsable" class="FormPropertReg mdb-select colorful-select dropdown-primary" >
                                        <?php
$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina=$_GET[iCodOficinaDes] ";
                                        $sqlTrb.= "ORDER BY cNombresTrabajador ASC";
                                        $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                                        while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
                                            if($RsTrb[iCodTrabajador]==$_GET[iCodTrabajadoResponsable]){
                                                $selecTrab="selected";
                                            }Else{
                                                $selecTrab="";
                                            }
                                            echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                                        }
                                        sqlsrv_free_stmt($rsTrb);
                                        ?>
                                    </select>
                                </div>

                                <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">
                                    <b>Buscar</b>&nbsp;<img src="images/icon_buscar.png" width="17" height="17" border="0">
                                </button>
                                <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self'); return false;	"
                                                  onMouseOver="this.style.cursor='hand'">
                                    <b>Restablecer</b><img src="images/icon_clear.png" width="17" height="17" border="0">
                                </button>
                                    <button class="btn btn-primary" onclick="window.open('consultaEntradaGeneralOficina_xls.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&iCodTrabajadoResponsable=<?=$_GET[iCodTrabajadoResponsable]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&cNomRemite=<?=$_GET[cNomRemite]?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'">
                                        <b>a Excel</b><img src="images/icon_excel.png" width="17" height="17" border="0">
                                    </button>
                                    <button class="btn btn-primary" onclick="window.open('consultaEntradaGeneralOficina_pdf.php?fecini=<?=$fecini?>&fecfin=<?=$fecfin?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&iCodTupa=<?=$_GET['iCodTupa']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&iCodOficinaOri=<?=$_GET[iCodOficinaOri]?>&iCodOficinaDes=<?=((isset($_GET['iCodOficinaDes']))?$_GET['iCodOficinaDes']:'')?>&cNomRemite=<?=$_GET[cNomRemite]?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                        <b>a Pdf</b>&nbsp;&nbsp;<img src="images/icon_pdf.png" width="17" height="17" border="0">
                                    </button>
                            </div>
						</form>
                        </div>
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
                        $texto = "<b>«</b> ";
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
                        $texto .= "<b>»</b>";
                        return $texto;
                        }

                        //ARTURO
                        $pag = $_GET["pag"];
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
                        }else{
                            $orden=$_GET['orden'];
                        }

                        //invertir orden
                        if ($orden == "ASC"){
                            $cambio="DESC";
                        }
                        if ($orden == "DESC"){
                            $cambio="ASC";
                        }

                        if ($fecini != ''){
                            $fecini = date("Ymd", strtotime($fecini));
                        }
                        if ($fecfin != ''){
                            $fecfin = date("Y-m-d", strtotime($fecfin));
                            function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                $date_r = getdate(strtotime($date));
                                $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                                return $date_result;
                            }
                            $fecfin = dateadd($fecfin,1,0,0,0,0,0); // + 1 dia
                        }
                         $sql.= " SP_CONSULTA_ENTRADA_GENERAL_OFICINA '$fecini','$fecfin','%".$_GET['cCodificacion']."%','%$_GET[cReferencia]%','%".$_GET['cAsunto']."%','$_GET['iCodTupa']','".$_GET['cCodTipoDoc']."','%$_GET['cNombre']%','%$_GET[cNomRemite]%','$_GET[iCodOficinaOri]','$_GET[iCodOficinaDes]', '%$_GET['cNroDocumento']%', '$campo', '$orden'";
                        $rs = sqlsrv_query($cnx,$sql);
                        $total = sqlsrv_has_rows($rs);
                        ?>
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="98"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Codificacion&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Codificacion"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; Tr&aacute;mite</a></th>
                                    <th width="142"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo Documento</a></th>
                                    <th width="300">Remitente</th>
                                    <th width="92">Fecha Derivo</th>
                                    <th><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto / TUPA</a></th>
                                </tr>
                            </thead>
                        <?php
        if($fecini=="" && $fecfin=="" && $_GET['cCodificacion']=="" && $_GET[iCodOficinaOri]=="" && $_GET[iCodOficinaDes]=="" && $_GET['cCodTipoDoc']=="" && $_GET['cAsunto']=="" && $_GET[cReferencia]=="" && $_GET['iCodTupa']=="" && $_GET['cNombre']=="" && $_GET[iCodTrabajadoResponsable]=="" && $_GET['cNroDocumento']=="" && $_GET[cNomRemite]==""){
                            $sqltra  = " SP_CONSULTA_ENTRADA_GENERAL_LISTA ";
                            $rstra   = sqlsrv_query($cnx,$sqltra);
                            $numrows = sqlsrv_has_rows($rstra);
                        }else{
                            $numrows = sqlsrv_has_rows($rs);
                        }
                        if ($numrows == 0){
                            echo "NO SE ENCONTRARON REGISTROS<br>";
                            echo "TOTAL DE REGISTROS : ".$numrows;
                        }else{
                            echo "TOTAL DE REGISTROS : ".$numrows;
                        ///////////////////////////////////////////////////////
                        for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                            sqlsrv_fetch_array($rs, $i);
                            $Rs = sqlsrv_fetch_array($rs);
                        ///////////////////////////////////////////////////////
                        //while ($Rs=sqlsrv_fetch_array($rs)){
                            if ($color == "#DDEDFF"){
                                $color = "#F9F9F9";
                            }else{
                                $color = "#DDEDFF";
                            }
                            if ($color == ""){
                                $color = "#F9F9F9";
                            }
                        ?>

                         <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
                            <td valign="top" align="center">
                                <?php if($Rs[nFlgTipoDoc]!=4){?>
                                    <a href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramite]?>" rel="lyteframe" title="Detalle del Trámite"
                                         rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?>
                                    </a>
                            <?php } else{?>
                                <a href="registroDetalles.php?iCodTramite=<?=$Rs[Relacionado]?>" rel="lyteframe" title="Detalle del Trámite"
                                     rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?>
                                </a>
                            <?php}?>
                            <?php
    $sqlTra = "SELECT cApellidosTrabajador, cNombresTrabajador, ES_EXTERNO FROM Tra_M_Trabajadores 
                                                     WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
                                    $rsTra  = sqlsrv_query($cnx,$sqlTra);
                                    $RsTra  = sqlsrv_fetch_array($rsTra);
                                    echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
                                    if ($RsTra['ES_EXTERNO'] == 1) {
                                        echo "<div style=color:#FF00FF;>Usuario Web</div>";
                                    }
                            ?>
                           </td>
                            <td valign="top" align="left">
                            <?php
                                echo $Rs['cDescTipoDoc'];
                                    echo "<div style=color:#808080;text-transform:uppercase>".$Rs['cNroDocumento']."</div>";
                                    if ($Rs[nFlgEnvio] == 0) {
                                        $mensaje = "Pendiente de derivacion";
                                    }
                                    echo "<div style=color:#FF0000;text-transform:uppercase>".$mensaje."</div>";
                                ?>
                            </td>
                            <td valign="top" align="left">
                                <?php
    $sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
                                    $rsRemi=sqlsrv_query($cnx,$sqlRemi);
                                    $RsRemi=sqlsrv_fetch_array($rsRemi);
                                    echo "<div style=color:#000000;>".$RsRemi['cNombre']."</div>";
                                        if($Rs[cNomRemite]!=""){
                                            if($RsRemi['cTipoPersona']==1){ echo "<div style=color:#408080>Personal Natural:</div>"; }
                                        }
                                    echo "<div style=color:#408080;text-transform:uppercase>".$Rs[cNomRemite]."</div>";

                              if($Rs[nFlgTipoDoc]==4){
                                        echo "<div style=color:#006600;><b>ANEXO</b></div>";
                                    }
                              ?>
                            </td>
                            <? /* <td><?php echo $Rs[cRepresentante];?></td> */?>
                            <td valign="top" align="center">
                                <?php
    if($Rs[nFlgTipoDoc]!=4){
                                    if($Rs[nFlgEnvio]==1){
                                        $sqlM="select TOP 1 * from Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]'";
                                    $rsM=sqlsrv_query($cnx,$sqlM);
                                        $RsM=sqlsrv_fetch_array($rsM);
                                        if($RsM) {
                                            $date = date_create(strtotime($RsM['fFecDerivar']));
                                            $fFecRegistro = $date->format( 'd-m-Y H:i:s');
                                            echo "<div style=color:#0154AF>" . $fFecRegistro . "</div>";

                                        }

                                }
                              }Else{
                                    $sqlM="select TOP 1 * from Tra_M_Tramite_Movimientos WHERE iCodTramiteRel='$Rs[iCodTramiteRel]'";
                                    $rsM=sqlsrv_query($cnx,$sqlM);
                                    $RsM=sqlsrv_fetch_array($rsM);
                                    $date = date_create(strtotime($RsM['fFecDerivar']));
                                    $fFecRegistro = $date->format( 'd-m-Y');
                                    echo "<div style=color:#0154AF>".$fFecRegistro."</div>";
                                    echo "<div style=color:#0154AF;font-size:10px>".$date->format( 'G:i')."</div>";
                              }
                                    ?>
                                </td>
                            <td valign="top" align="left">
                                <?php
    echo $Rs['cAsunto'];
                                if($Rs['iCodTupa']!=""){
                                    $sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$Rs['iCodTupa']."'";
                                $rsTup=sqlsrv_query($cnx,$sqlTup);
                                $RsTup=sqlsrv_fetch_array($rsTup);
                                ?>
                                <br>
                               <a href="registroDetalleFlujoTupa.php?iCodTupa=<?=$Rs['iCodTupa']?>" rel="lyteframe" title="Detalles Flujo Tupa" rev="width: 880px; height: 300px; scrolling: auto; border:no"><?=utf8_encode($RsTup["cNomTupa"])?></a>
                                <?php
    }
                                echo utf8_encode("<div style=color:#808080;text-transform:uppercase>".$Rs[cReferencia]."</div>");
                                if($Rs['iCodTupa']!=""){
                                 $sqlReq= " SELECT * FROM Tra_M_Tupa_Requisitos WHERE iCodTupa=(SELECT iCodTupa FROM Tra_M_Tramite WHERE iCodTramite='$Rs[iCodTramite]') AND iCodTupaRequisito NOT IN 
                                              (SELECT iCodTupaRequisito FROM Tra_M_Tramite_Requisitos WHERE iCodTramite='$Rs[iCodTramite]' ) ";
                                $rsReq=sqlsrv_query($cnx,$sqlReq);
                                $numReq=sqlsrv_has_rows($rsReq);
                                if($numReq!=0){
                                echo "\n<div style=color:#FF0000>Faltan ".$numReq." Requisitos por cumplir</div>";
                                }
                                }
                                ?>
                            </td>

                        </tr>

                        <?php
        }
                        }
                        ?>
                                <tr>
                                <td colspan="6" align="center">
                                 <?php echo paginar($pag, $total, $tampag, "consultaEntradaGeneralOficina.php?cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&iCodOficinaOri=".$_GET[iCodOficinaOri]."&iCodOficinaDes=".(isset($_GET['iCodOficinaDes'])?$_GET['iCodOficinaDes']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cReferencia=".$_GET[cReferencia]."&iCodTupa=".$_GET['iCodTupa']."&cNombre=".$_GET['cNombre']."&iCodTrabajadoResponsable=".$_GET[iCodTrabajadoResponsable]."&cNroDocumento=".$_GET['cNroDocumento']."&cNomRemite=".$_GET[cNomRemite]."&pag=");
                                    //Página 1 <a href="javascript:;">2</a> <a href="javascript:;">3</a> <a href="javascript:;">4</a> <a href="javascript:;">5</a>
                                 ?>
                                </td>
                                </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
    $('.datepicker').pickadate({
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
    });
    $('.mdb-select').material_select();
    function Buscar(){
          document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
          document.frmConsultaEntrada.submit();
    }

    function releer(){
         document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>#area";
         document.frmConsultaEntrada.submit();
    }
</script>
 <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>