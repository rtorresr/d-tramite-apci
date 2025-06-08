<?php
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");
$fFecActual = date("Ymd")." ".date("H:i:s");

$sqlMovP = "SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$_POST['iCodMovimiento'][0];
$rsMovP = sqlsrv_query($cnx,$sqlMovP);
$RsMovP = sqlsrv_fetch_array($rsMovP);
$rs = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite = ".$RsMovP['iCodTramite']);
$Rs = sqlsrv_fetch_array($rs);
?>
<p>Viendo el flujo del <?php echo "<strong>Trámite N°. " . $Rs['cCodificacion'] . "</strong>"; ?>.</p>
<div class="">Seguimiento de trámite</div>
<div class="">
    <table class="striped bordered highlight responsive-table">
        <thead>
        <tr>
            <th>Documento</th>
            <th>Fecha</th>
            <th>Asunto</th>
            <th>Observaciones</th>
            <th>Origen</th>
            <th>Oficina</th>
            <th>Responsable / Fecha de Aceptado</th>
            <th>Estado</th>
            <!--<th>Avances</th>
            <th>Archivo</th>-->
        </tr>
        </thead>
        <?php
        $sqlM = "SELECT iCodMovimiento,iCodTramite,iCodOficinaOrigen,fFecRecepcion,iCodOficinaDerivar,iCodTrabajadorDerivar,
                                                cCodTipoDocDerivar,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,iCodTrabajadorDelegado,fFecDelegado,
                                                nEstadoMovimiento,cFlgTipoMovimiento,cNumDocumentoDerivar,cReferenciaDerivar,iCodTramiteDerivar
                                FROM Tra_M_Tramite_Movimientos 
                                WHERE (iCodTramite='".$RsMovP['iCodTramite']."' OR iCodTramiteRel='".$RsMovP['iCodTramite']."') 
                                            AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) 
                                ORDER BY iCodMovimiento ASC";
        $rsM = sqlsrv_query($cnx,$sqlM);
        $recorrido = 1;
        $contaMov = 0;

        while ($RsM=sqlsrv_fetch_array($rsM)){ ?>
            <tr>
                <td>
                    <?php
                    //echo $RsM['iCodTramite'];
                    $sqlTpDcM="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$RsM['cCodTipoDocDerivar']."'";
                    $rsTpDcM=sqlsrv_query($cnx,$sqlTpDcM);
                    // echo $sqlTpDcM;
                    $RsTpDcM=sqlsrv_fetch_array($rsTpDcM);

                    switch ($RsM['cFlgTipoMovimiento']) {
                        case 1: //moviemiento normal
                            if($recorrido==1){
                                echo $RsTpDcM['cDescTipoDoc'];
                                echo $Rs['cCodificacion'];
                                echo $Rs['cNroDocumento'];
                            }
                            else
                            {
                                echo $RsTpDcM['cDescTipoDoc'];
                                //echo "<div>".$Rs[cReferencia]."</div>";
                                echo $RsM['cNumDocumentoDerivar'];
                                echo "<b>Interno<b>";
                            }
                            break;
                        case 3: //movimiento anexo
                            $sqlAnexo="SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite='".$RsM['iCodTramite']."' ";
                            $rsAnexo=sqlsrv_query($cnx,$sqlAnexo);
                            $RsAnexo=sqlsrv_fetch_array($rsAnexo);
                            echo $RsTpDcM['cDescTipoDoc'];
                            echo $RsAnexo['cCodificacion'];
                            echo "<b>Anexo<b>";
                            break;
                        case 5: //movimiento referencia
                            echo $RsTpDcM['cDescTipoDoc'];
                            echo $RsM['cReferenciaDerivar'];
                            $sqlTipo="SELECT nFlgTipoDoc FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='".$RsM['iCodTramiteDerivar']."' ";
                            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                            $RsTipo=sqlsrv_fetch_array($rsTipo);
                            if($RsTipo['nFlgTipoDoc']==3){
                                echo "<b>Referencia: Salida<b>";}
                            else if($RsTipo['nFlgTipoDoc']==2){
                                echo "<b>Referencia: Interno<b>";
                            }
                            else if($RsTipo['nFlgTipoDoc']==1){
                                echo "<b>Referencia: Entrada<b>";
                            }
                            break;
                    } ?>
                </td>
                <td>
                    <?php echo (isset($RsM['fFecDerivar'])?$RsM['fFecDerivar']->format("d-m-Y"):'-'); ?> <?php echo (isset($RsM['fFecDerivar'])?$RsM['fFecDerivar']->format("h:i A"):'-'); ?>
                </td>
                <td>
                    <?php
                    if($contaMov==0){
                        echo ((ucfirst(strtolower($Rs['cAsunto']))));
                    }else{
                        echo ((ucfirst(strtolower($RsM['cAsuntoDerivar']))));
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if($contaMov==0){
                        echo (ucfirst(strtolower($Rs['cObservaciones'])));
                    }Else{
                        echo (ucfirst(strtolower($RsM['cObservacionesDerivar'])));
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsM['iCodOficinaOrigen']."'";
                    $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
                    $RsOfiO=sqlsrv_fetch_array($rsOfiO);
                    echo "<a class=\"tooltipped\" href=\"javascript:;\" data-position=\"bottom\" data-tooltip=\"".trim($RsOfiO['cNomOficina'])."\">".$RsOfiO['cSiglaOficina']."</a>";
                    ?>
                </td>
                <td>
                    <?php
                    $sqlOfiD = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsM['iCodOficinaDerivar']."'";
                    $rsOfiD  = sqlsrv_query($cnx,$sqlOfiD);
                    $RsOfiD  = sqlsrv_fetch_array($rsOfiD);
                    echo "<a class=\"tooltipped\" href=\"javascript:;\" data-position=\"bottom\" data-tooltip=\"".trim($RsOfiD['cNomOficina'])."\">".$RsOfiD['cSiglaOficina']."</a>";
                    ?>
                </td>
                <td>
                    <?php
                    $rsResp = sqlsrv_query($cnx,"SELECT cApellidosTrabajador,cNombresTrabajador 
                                                                            FROM Tra_M_Trabajadores 
                                                                            WHERE iCodTrabajador = '".$RsM['iCodTrabajadorDerivar']."'");
                    $RsResp = sqlsrv_fetch_array($rsResp);
                    echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
                    sqlsrv_free_stmt($rsResp);

                    if($RsM['cFlgTipoMovimiento'] != 5){
                        if($RsM['fFecRecepcion'] == ""){
                            echo "<div style=color:#ff0000>sin aceptar</div>";
                        }else{
                            echo "<div style=color:#0154AF>aceptado</div>";
                            echo $RsM['fFecRecepcion']->format("d-m-Y") . " " . $RsM['fFecRecepcion']->format("h:i A");
                        }
                    }else{
                        echo "";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $sqlRpta = "SELECT COUNT(*) AS 'TOTAL' FROM Tra_M_Tramite TT 
                                        INNER JOIN Tra_M_Tramite_Movimientos TM ON TT.iCodTramite = TM.iCodTramiteRespuesta 
                                        WHERE TM.iCodMovimiento = '".$RsM['iCodMovimiento']."' ";
                    $rsRpta = sqlsrv_query($cnx,$sqlRpta);
                    $RsRpta = sqlsrv_fetch_array($rsRpta);
                    if($RsM['cFlgTipoMovimiento']!=5){
                        switch ($RsM['nEstadoMovimiento']){
                            case 1:
                                echo "Pendiente"."<br>";
                                if ($RsRpta['TOTAL'] >0) {
                                    echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                }
                                break;
                            case 2:
                                echo "Derivado"."<br>";
                                if ($RsRpta['TOTAL'] >0) {
                                    echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                }
                                break;
                            case 3:
                                echo "Delegado"."<br>";
                                if ($RsRpta['TOTAL'] >0) {
                                    echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                }
                                break;
                            case 4:
                                echo "Respondido";
                                echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";

                                break;
                            case 5:
                                echo "Finalizado"."<br>";
                                if ($RsRpta['TOTAL'] >0) {
                                    echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                }
                                break;
                            case 6:
                                echo "Rechazado"."<br>";
                                if ($RsRpta['TOTAL'] >0) {
                                    echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                }
                                break;
                            case 7:
                                echo "Cancelado"."<br>";
                                if ($RsRpta['TOTAL'] >0) {
                                    echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsM['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 500px; height: 300px; scrolling: auto; border:no\">RESPONDIDO</a>";
                                }
                                break;
                        }
                    }else{
                        echo "";
                    }

                    if($RsM['iCodTrabajadorDelegado']!=""){
                        $rsDelg = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsM['iCodTrabajadorDelegado']."'");
                        $RsDelg = sqlsrv_fetch_array($rsDelg);
                        echo "<div style=color:#005B2E;font-size:12px>".utf8_encode(ucwords(strtolower($RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"])))."</div>";
                        sqlsrv_free_stmt($rsDelg);
                        echo "<div style=color:#0154AF>".$RsM['fFecDelegado']->format("d-m-Y")/*date("d-m-Y", strtotime($RsM['fFecDelegado']))*/."</div>";
                        echo "<div style=color:#0154AF;font-size:10px>".$RsM['fFecDelegado']->format("h:i A")."</div>";
                    }
                    ?>
                </td>
                <?php
                $tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$RsMovP['iCodTramite']."'");
                $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);

                if ($RsTramitePDF->descripcion != NULL AND $RsTramitePDF->descripcion!=' ') { ?>
                <?php } ?>


                <?php
                $tramitePDF   = sqlsrv_query($cnx,"select descripcion,* from Tra_M_Tramite where iCodTramite='".$RsM['iCodTramiteDerivar']."'");
                $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);

                if (strlen(rtrim(ltrim($RsTramitePDF->descripcion??'')))>0) { ?>
                    <?php
                }
                if ($RsM['cFlgTipoMovimiento'] == 1){
                    if ($contaMov == 0){
                        $rsDig = sqlsrv_query($cnx,"SELECT TOP 1 * FROM Tra_M_Tramite_Digitales 
                                                                WHERE iCodTramite = '".$RsMovP['iCodTramite']."' 
                                                                ORDER BY iCodDigital DESC");
                        if (sqlsrv_has_rows($rsDig) > 0){
                            $RsDig = sqlsrv_fetch_array($rsDig);
                            echo "<div><a href=\"download.php?direccion=../cAlmacenArchivos/&file=".$RsDig["cNombreNuevo"]."\"><img src=\"images/icon_download.png\" width=18 height=18 border=0 alt=\"Descargar Adjunto\"></a></div>";
                        }
                    }else{
                        $sqlBusT = "SELECT * FROM Tra_M_Tramite 
                                                            WHERE cCodificacion = '".$RsM['cNumDocumentoDerivar']."' AND iCodTramite='".$RsM['iCodTramiteDerivar']."'";
                        $rsBusT  = sqlsrv_query($cnx,$sqlBusT);
                        if (sqlsrv_has_rows($rsBusT) > 0){
                            $RsBusT = sqlsrv_fetch_array($rsBusT);
                            $rsDig  = sqlsrv_query($cnx,"SELECT TOP 1 * FROM Tra_M_Tramite_Digitales 
                                                                    WHERE iCodTramite='".$RsBusT['iCodTramite']."' 
                                                                    ORDER BY iCodDigital DESC");
                            if (sqlsrv_has_rows($rsDig) > 0){
                                $RsDig = sqlsrv_fetch_array($rsDig);
                                echo "<div><a href=\"download.php?direccion=../cAlmacenArchivos/&file=".$RsDig["cNombreNuevo"]."\"><img src=\"images/icon_download.png\" width=18 height=18 border=0 alt=\"Descargar Adjunto\"></a></div>";
                            }
                        }
                    }
                }

                if ($RsM['cFlgTipoMovimiento'] == 3){
                    $sqlDw = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='".$RsM['iCodTramite']."'";
                    $rsDw  = sqlsrv_query($cnx,$sqlDw);

                    if (sqlsrv_has_rows($rsDw) > 0){
                        $RsDw = sqlsrv_fetch_array($rsDw);
                        echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
                    }
                }

                if ($RsM['cFlgTipoMovimiento'] == 5){
                    $sqlDi = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$RsM['iCodTramiteDerivar']."'";
                    $rsDi  = sqlsrv_query($cnx,$sqlDi);

                    if (sqlsrv_has_rows($rsDi) > 0){
                        $RsDi  = sqlsrv_fetch_array($rsDi);
                        $sqlDx = "SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='".$RsDi['iCodTramite']."'";
                        $rsDx  = sqlsrv_query($cnx,$sqlDx);

                        if (sqlsrv_has_rows($rsDx) > 0){
                            $RsDx = sqlsrv_fetch_array($rsDx);
                            echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDx["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDx["cNombreNuevo"])."\"></a>";
                        }
                    }
                }
                ?>

            </tr>
            <?php
            $contaMov++;
            $recorrido++;
        }
        ?>
    </table>
</div>
