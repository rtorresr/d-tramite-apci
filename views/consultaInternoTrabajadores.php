<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaInternoTrabajadores.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta de los Documentos Internos de Trabajadores
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
    $pag = $_GET['pag']??1;
    $tampag=$_GET['cantidadfilas']??5;
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
              document.frmConsultaEntrada.action="<?php echo $_SERVER['PHP_SELF']?>";
              document.frmConsultaEntrada.submit();
            }
        </script>
    </head>
    <body class="theme-default has-fixed-sidenav">
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
                             <div class="card-header text-center "> >> </div>
                              <!--Card content-->
                             <div class="card-body">
                                <div class="AreaTitulo">Consulta de Doc. Internos de Trabajadores</div>
                                <form name="frmConsultaEntrada" method="GET" action="consultaInternoTrabajadores.php">
                                    <input type="hidden" name="pag" value="<?=1?>">
                                    <tr>
                                        <td width="110" >N&ordm; Documento:</td>
                                        <td width="390" align="left">
                                            <input type="txt" name="cCodificacion" value="<?=$_GET['cCodificacion']??''?>" size="28" class="FormPropertReg form-control">
                                        </td>
                                        <td width="110" >Desde:</td>
                                        <td align="left">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" readonly name="fDesde" value="<?=$_GET['fDesde']??''?>" style="width:75px" class="FormPropertReg form-control">
                                                    </td>
                                                    <td><div class="boton" style="width:24px;height:20px">
                                                            <a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)">
                                                                <img src="images/icon_calendar.png" width="22" height="20" border="0">
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td width="20"></td>
                                                    <td >Hasta:&nbsp;
                                                        <input type="text" readonly name="fHasta" value="<?=$_GET['fHasta']??''?>" style="width:75px" class="FormPropertReg form-control">
                                                    </td>
                                                    <td>
                                                        <div class="boton" style="width:24px;height:20px">
                                                            <a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)">
                                                                <img src="images/icon_calendar.png" width="22" height="20" border="0">
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110" >Tipo Documento:</td>
                                        <td width="390" align="left">
                                            <select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" >
                                                <option value="">Seleccione:</option>
                                                <?php
                                                $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
                                                $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                                                $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                    if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
                                                        $selecTipo="selected";
                                                    } else {
                                                        $selecTipo="";
                                                    }
                                                    echo "<option value='".$RsTipo["cCodTipoDoc"]."' ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
                                                }
                                                sqlsrv_free_stmt($rsTipo);
                                                ?>
                                            </select>
                                        </td>
                                        <td width="110" >Asunto:</td>
                                        <td align="left">
                                            <input type="txt" name="cAsunto" value="<?=$_GET['cAsunto']??''?>" size="65" class="FormPropertReg form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110" >Enviado:</td>
                                        <td width="390" align="left">
                                           SI<input type="checkbox" name="SI" value="1" <?php if(($_GET['SI']??'')==1) echo "checked"?> >
                                         &nbsp;&nbsp;&nbsp;
                                           NO<input type="checkbox" name="NO" value="1" <?php if(($_GET['NO']??'')==1) echo "checked"?> />
                                        </td>
                                        <td width="110" >Observaciones:</td>
                                        <td align="left" class="CellFormRegOnly">
                                            <input type="txt" name="cObservaciones" value="<?=$_GET['cObservaciones']??''?>" size="65" class="FormPropertReg form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="10" ></td>
                                        <td height="10"></td>
                                        <td height="10" ></td>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="left">
                                            <table width="400" border="0" align="left">
                                               <tr>
                                                <td align="left">
                                                  Descarga &nbsp; <img src="images/icon_download.png" width="16" height="16" border="0" > &nbsp; &nbsp;
                                                  | &nbsp; &nbsp;  Editar &nbsp; <i class="fas fa-edit"></i>&nbsp;&nbsp;
                                                </td>
                                               </tr>
                                            </table>
                                        </td>
                                        <td colspan="2" align="right">
                                            <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b>
                                                <img src="images/icon_buscar.png" width="17" height="17" border="0">
                                            </button>
                                            &nbsp;
                                            <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b>
                                                <img src="images/icon_clear.png" width="17" height="17" border="0">
                                            </button>
                                            &nbsp;
                                            <button class="btn btn-primary" onclick="window.open('consultaInternoTrabajadores_xls.php?fDesde=<?=$_GET['fDesde']??''?>&fHasta=<?=$_GET['fHasta']??''?>&cCodificacion=<?=$_GET['cCodificacion']??''?>&SI=<?=$_GET['SI']?>&NO=<?=$_GET['NO']?>&cObservaciones=<?=$_GET['cObservaciones']?>&cAsunto=<?=$_GET['cAsunto']??''?>&cCodTipoDoc=<?=$_GET['cCodTipoDoc']??''?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b>
                                                <img src="images/icon_excel.png" width="17" height="17" border="0">
                                            </button>
                                            &nbsp;
                                            <button class="btn btn-primary" onclick="window.open('consultaInternoTrabajadores_pdf.php?fDesde=<?=$_GET['fDesde']??''?>&fHasta=<?=$_GET['fHasta']??''?>&cCodificacion=<?=$_GET['cCodificacion']??''?>&SI=<?=$_GET['SI']?>&NO=<?=$_GET['NO']?>&cObservaciones=<?=$_GET['cObservaciones']?>&cAsunto=<?=$_GET['cAsunto']??''?>&cCodTipoDoc=<?=$_GET['cCodTipoDoc']??''?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b>
                                                <img src="images/icon_pdf.png" width="17" height="17" border="0">
                                            </button>
                                        </td>
                                    </tr>
                                    <select name="cantidadfilas" id="filas" class="mdb-select" onchange="actualizarfilas()" >
                                        <option value="5"  id="5">5</option>
                                        <option value="10" id="10">10</option>
                                        <option value="20" id="20">20</option>
                                        <option value="50" id="50">50</option>
                                    </select>
                                    <label>Cantidad</label>
                                </form>
                                <?php
                                    // ordenamiento
                                    if(($_GET['campo']??'')==""){
                                        $campo="Tra_M_Tramite.iCodTramite";
                                    }Else{
                                        $campo=$_GET['campo'];
                                    }

                                    if(($_GET['orden']??'')==""){
                                        $orden="ASC";
                                    }Else{
                                        $orden=$_GET['orden'];
                                    }

                                    //invertir orden
                                    if($orden=="ASC") $cambio="DESC";
                                    if($orden=="DESC") $cambio="ASC";

                                    if(($_GET['fDesde']??'')!='' && ($_GET['fHasta']??'')!=''){
                                        $fDesde=date("Y-m-d",strtotime($_GET['fDesde']));
                                        $fHasta=date("Y-m-d",strtotime($_GET['fHasta']));

                                        function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                        $date_r = getdate(strtotime($date));
                                        $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                                        return $date_result;
                                        }
                                        $fHasta=dateadd($fHasta,1,0,0,0,0,0);
                                    } // + 1 dia
        /*
            $sql="  SELECT Tra_M_Tramite.iCodTramite,cDescTipoDoc,cCodificacion,fFecRegistro,cAsunto,cObservaciones,Tra_M_Tramite.nFlgEnvio ";
            $sql.=" FROM Tra_M_Tramite LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ";
            $sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
            $sql.=" WHERE Tra_M_Tramite.nFlgTipoDoc=2 AND Tra_M_Tramite.nFlgClaseDoc=2 ";
            if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
            $sql.=" AND Tra_M_Tramite.fFecRegistro>'$fDesde' ";
            }
            if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
            $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
            }

            if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
            $sql.=" AND Tra_M_Tramite.fFecRegistro<='$fHasta' ";
            }

            if($_GET[SI]==1 AND $_GET[NO]==1 ){
            $sql.=" AND (Tra_M_Tramite.nFlgEnvio=1 OR Tra_M_Tramite.nFlgEnvio IS NULL) ";
            }
            if($_GET[SI]==0 AND $_GET[NO]==1 ){
            $sql.=" AND Tra_M_Tramite.nFlgEnvio IS NULL ";
            }
            if($_GET[SI]==1 AND $_GET[NO]==0 ){
            $sql.=" AND Tra_M_Tramite.nFlgEnvio=1 ";
            }
            if($_GET['cCodificacion']!=""){
            $sql.=" AND Tra_M_Tramite.cCodificacion='".$_GET['cCodificacion']."' ";
            }
            if($_GET['cAsunto']!=""){
            $sql.=" AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
            }
            if($_GET[cObservaciones]!=""){
            $sql.=" AND Tra_M_Tramite.cObservaciones LIKE '%$_GET[cObservaciones]%' ";
            }
            if($_GET['cCodTipoDoc']!=""){
            $sql.=" AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
            }
            $sql.= " ORDER BY $campo $orden ";

                */

                                    $sql= " SP_CONSULTA_INTERNO_TRABAJADOR '".($fDesde??'')."', '".($fHasta??'')."','".($_GET['SI']??'')."','".($_GET['NO']??'')."',  '%".($_GET['cCodificacion']??'')."%', '%".($_GET['cAsunto']??'')."%',  '%".($_GET['cObservaciones']??'')."%', '".($_GET['cCodTipoDoc']??'')."', '$campo', '$orden' ";
            //echo $sql."<br>";
                                    $rs=sqlsrv_query($cnx,$sql,array(),array("Scrollable"=>"buffered"));
                                    //echo $sql;
                                ?>
                                <table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
                                    <tr>
                                        <td width="130" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=TipoDocumento&orden=<?=$cambio?>&cCodTipoDoc=<?=$_GET['cCodTipoDoc']??''?>"  style=" text-decoration:<?php if($campo=="TipoDocumento"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</td>
                                        <td width="150" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Codigo&orden=<?=$cambio?>&cCodificacion=<?=$_GET['cCodificacion']??''?>"  style=" text-decoration:<?php if($campo=="Codigo"){ echo "underline"; }Else{ echo "none";}?>">Nro Documento</td>
                                        <td width="100" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Fecha&orden=<?=$cambio?>"  style=" text-decoration:<?php if($campo=="Fecha"){ echo "underline"; }Else{ echo "none";}?>">Fecha</td>
                                        <td width="200" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=$_GET['cAsunto']??''?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto</td>
                                        <td class="headCellColum">Observaciones</td>
                                        <td width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=FlagEnvio&orden=<?=$cambio?>" style=" text-decoration:<?php if($campo=="FlagEnvio"){ echo "underline"; }Else{ echo "none";}?>">Enviado</td>
                                        <td width="80" class="headCellColum">Opciones</td>
                                    </tr>
                                    <?php
                                        if(($_GET['cCodificacion']??'')=="" && ($_GET['fDesde']??'')=="" && ($_GET['fHasta']??'')=="" && ($_GET['cCodTipoDoc']??'')=="" && ($_GET['cAsunto']??'')=="" && ($_GET['cObservaciones']??'')=="" && ($_GET['SI']??'')=="" && ($_GET['NO']??'')==""){
                                            $sqlin=" SP_CONSULTA_INTERNO_TRABAJADOR_CONTEO ";
                                            $rsin=sqlsrv_query($cnx,$sqlin,array(),array("Scrollable"=>"buffered"));
                                            $numrows=sqlsrv_num_rows($rsin);
                                         }
                                        else{
                                            $numrows=sqlsrv_num_rows($rs);
                                        }
                                        //Código para paginar
                                        $ini = ($pag-1) * $tampag;
                                        $fin= min($ini+$tampag,$numrows);
                                        if($numrows!=0) {
                                            for ($i = 0; $i < $numrows; $i++) {
                                                $Rs = sqlsrv_fetch_array($rs);
                                                if ($i >= $ini && $i < $fin) {
                                                    ?>
                                                    <tr bgcolor="<?= $color??'' ?>"
                                                        onMouseOver="this.style.backgroundColor='#BFDEFF'"
                                                        OnMouseOut="this.style.backgroundColor='<?= $color ?>'">
                                                        <td valign="top"
                                                            align="left"><?php echo $Rs['cDescTipoDoc']; ?></td>
                                                        <td valign="top" align="center">
                                                            <a href="registroTrabajadorDetalles.php?iCodTramite=<?= $Rs['iCodTramite'] ?>"
                                                               rel="lyteframe" title="Detalle del Documento"
                                                               rev="width: 970px; height: 550px; scrolling: auto; border:no"><?= $Rs['cCodificacion'] ?></a>
                                                            <?php
                                                            echo "<div style=color:#727272>".$Rs['fFecRegistro']->format("d-m-y")."</div>";
                                                            echo "<div style=color:#727272;font-size:10px>".$Rs['fFecRegistro']->format("g:i")."</div>";
                                                            ?>
                                                        </td>
                                                        <td valign="top" align="center">
                                                            <?php
                                                            echo "<div style=color:#727272>".$Rs['fFecRegistro']->format("d-m-y")."</div>";
                                                            echo "<div style=color:#727272;font-size:10px>".$Rs['fFecRegistro']->format("g:i")."</div>";
                                                            ?>
                                                        </td>
                                                        <td valign="top" align="left">
                                                            <?php
                                                            echo $Rs['cAsunto'];
                                                            if ($Rs['iCodTupa'] != "") {
                                                                $sqlTup = "SELECT * FROM Tra_M_Tupa WHERE iCodTupa='" . $Rs['iCodTupa'] . "'";
                                                                $rsTup = sqlsrv_query($cnx, $sqlTup);
                                                                $RsTup = sqlsrv_fetch_array($rsTup);
                                                                echo "<div style=color:#0154AF>" . $RsTup["cNomTupa"] . "</div";
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php /* <td><?php echo $Rs[cRepresentante];?></td> */ ?>
                                                        <td valign="top"><?php echo $Rs['cObservaciones']; ?></td>
                                                        <td valign="top" align="center">
                                                            <?php
                                                            if ($Rs['nFlgEnvio'] == 0) {
                                                                echo "NO";
                                                            }
                                                            if ($Rs['nFlgEnvio'] == 1) {
                                                                echo "SI";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td valign="top">
                                                            <?php
                                                            $tramitePDF = sqlsrv_query($cnx, "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='" . $Rs['iCodTramite'] . "'");
                                                            $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
                                                            //no se para que sirve el if de abajo
                                                            if ($RsTramitePDF->descripcion != NULL AND $RsTramitePDF->descripcion != ' ') {
                                                                ?>
                                                                <a href="registroInternoDocumento_pdf.php?iCodTramite=<?php echo $RsTramitePDF->iCodTramite; ?>"
                                                                   target="_blank" title="Documento Electrónico">
                                                                    <img src="images/1471041812_pdf.png" border="0"
                                                                         height="17" width="17">
                                                                </a>
                                                            <?php }
                                                            //al de arriba me refiero
                                                            $sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='".$Rs['iCodTramite']."'";
                                                            $rsDw = sqlsrv_query($cnx, $sqlDw,array(),array("Scrollable"=>"Buffered"));
                                                            if (sqlsrv_num_rows($rsDw) > 0) {
                                                                $RsDw = sqlsrv_fetch_array($rsDw);
                                                                if ($RsDw["cNombreNuevo"] != "") {
                                                                    if (file_exists("../cAlmacenArchivos/".trim($RsDw["cNombreNuevo"]))) {
                                                                        echo "<a href='download.php?direccion=../cAlmacenArchivos/&file=" . trim($RsDw["cNombreNuevo"]) . "'>
                                                                                    <img src='images/icon_download.png' border=0 width=16 height=16 alt='".trim($RsDw["cNombreNuevo"])."'>
                                                                                  </a>";
                                                                    }
                                                                }
                                                            }
                                                            echo "<a href='registroTrabajadorEdit.php?iCodTramite=" . $Rs['iCodTramite'] . "&URI=" . $_SERVER['REQUEST_URI'] . "'><img src='images/icon_edit.png' width='16' height='16' border='0'></a>";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </table>
                                 <!--Información inferior-->
                                 <div class="info-end">
                                     <br>
                                     <b>
                                         Resultados del <?php echo $ini +1 ; ?> al <?php echo $fin ; ?>
                                     </b>
                                     <br>
                                     <b>
                                         Total: <?php echo $numrows; ?>
                                     </b>
                                     <br>
                                 </div>
                                 <!--/Información inferior-->
                                 <br>
                                <?php
                                    require_once("../core/paginador.php");
                                    $dire="cCodificacion=".($_GET['cCodificacion']??'')."&fDesde=".($_GET['fDesde']??'')."&fHasta=".($_GET['fHasta']??'')."&cCodTipoDoc=".($_GET['cCodTipoDoc']??'')."&cAsunto=".($_GET['cAsunto']??'')."&cObservaciones=".($_GET['cObservaciones']??'')."";
                                    echo paginar($pag, $numrows, $tampag, "consultaInternoTrabajadores.php?".$dire."&cantidadfilas=".$tampag."&pag=");
                                ?>
                            </div>
                         </div>
                     </div>
                 </div>
            </div>
        </main>

        <?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>
        <map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
        <map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map>
        <script>
            document.getElementById(<?php echo $tampag?>).selected = true;

            function actualizarfilas(){
                document.frmConsultaEntrada.action="<?php echo $_SERVER['PHP_SELF']?>";
                document.frmConsultaEntrada.submit();
            }

        </script>
    </body>
</html>

<?php
} else {
   header("Location: ../index-b.php?alter=5");
}
?>