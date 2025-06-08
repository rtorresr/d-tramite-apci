<?php
//header('Content-Type: text/html; charset=UTF-8');
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

<div class="row">
    <div class="col s12">
        <div class="card">
        <span class="card-title" style="display: block; line-height: 32px; margin-bottom: 8px; background: #d2e4f3; padding: 0 10px;">Datos Generales</span>
        <div class="card-content">
            <small class="overline"><?php echo 'CUD ' . $Rs['nCud'];?></small>
            <h5 class="subtitle" style="margin-top: 0">
            <?php
                    $sqlTipDoc="SELECT cDescTipoDoc FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$Rs['cCodTipoDoc']."'";
                    $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
                    $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
                    echo  $RsTipDoc['cDescTipoDoc'] . $Rs['cNroDocumento'];
                    
                ?>

                <?php
                    echo "<span class='badge blue white-text'>Aceptado</span>"
                    // switch ($Rs['nFlgEstado']) {
                    //     case 1:
                    //             echo "<span class='badge blue white-text'>Sin Aceptar</span>";
                    //         break;
                    //     case 2:
                    //             echo "<span class='badge red white-text'>Pendiente</span>";
                    //         break;
                    //     case 3:
                    //         echo "<span class='badge black white-text'>Finalizado</span>";
                    //         $sqlFinTxt="SELECT cObservacionesFinalizar, fFecFinalizar FROM Tra_M_Tramite_Movimientos WHERE nEstadoMovimiento=5 AND iCodTramite='".$RsMovP['iCodTramite']."' order by iCodMovimiento DESC";
                    //         $rsFinTxt=sqlsrv_query($cnx,$sqlFinTxt);
                    //         $RsFinTxt=sqlsrv_fetch_array($rsFinTxt);
                    //         echo "<div style=color:#7C7C7C>".$RsFinTxt['cObservacionesFinalizar']."</div>";
                    //         echo "<div style=color:#0154AF>".$RsFinTxt['fFecFinalizar']->format("d-m-Y")."</div>";
                    //         break;
                    // }
                ?>
            </h5>
            <p><?php echo $Rs['cAsunto'];?></p>

            <?php
                $sqlReferencia = "SELECT iCodTramiteRef, cReferencia FROM Tra_M_Tramite TT INNER JOIN Tra_M_Tramite_Referencias TR ON TT.iCodTramite = tr.iCodTramite WHERE TT.iCodTramite = ".$RsMovP['iCodTramite'];
                $rsReferencia = sqlsrv_query($cnx,$sqlReferencia);
                if ($rsReferencia) {
                    echo '<small class="overline" style="display:blocK; padding-top: 1rem">Referencia</small>';
                    while ($RsReferencia = sqlsrv_fetch_array($rsReferencia)){
                        $sqlRef = "SELECT cDescTipoDoc FROM Tra_M_Tramite TT INNER JOIN Tra_M_Tipo_Documento TD ON TT.cCodTipoDoc = TD.cCodTipoDoc WHERE TT.iCodTramite = ".$RsReferencia['iCodTramiteRef'];
                        $rsRef = sqlsrv_query($cnx,$sqlRef);
                        $RsRef = sqlsrv_fetch_array($rsRef);
                        echo  $RsRef['cDescTipoDoc']." ".$RsReferencia['cReferencia'];
                    }
                }
            ?>
            <?php if(!empty($Rs['cObservaciones'])) {?>
                <small class="overline" style="display:blocK; padding-top: 1rem">Observaciones</small>
                <?php echo $Rs['cObservaciones']; ?>
            <?php } ?>
        </div>
        <div class="card-action">
            <span><strong>F. Doc.</strong> <?php echo ($Rs['fFecDocumento']?$Rs['fFecDocumento']->format("d/m/Y"):'-')?> <?=($Rs['fFecDocumento']?$Rs['fFecDocumento']->format("h:i A"):'-')?></span> | 
            <span><strong>F. Reg.</strong> <?php echo ($Rs['fFecRegistro']?$Rs['fFecRegistro']->format("d/m/Y"):'-')?> <?php echo ($Rs['fFecRegistro']?$Rs['fFecRegistro']->format("h:i A"):'-')?></span> | 
            <span><strong>Folios</strong> <?php echo $Rs['nNumFolio']; ?></span>
        </div>
        </div>
    </div>
</div>

<?php if( $Rs['iCodRemitente'] != null ) {
    $fechaCorte = new DateTime('2020-02-16');
    if ($Rs['fFecRegistro'] > $fechaCorte){        
        $sqlRemi="SELECT NumeroDocumento AS NumDocumento, NombreEntidad AS Nombre FROM T_Entidad WHERE IdEntidad ='".$Rs['iCodRemitente']."'";
        $rsRemi=sqlsrv_query($cnx,$sqlRemi);
        $RsRemi = sqlsrv_fetch_array($rsRemi);
    } else {        
        $sqlRemi="SELECT nNumDocumento AS NumDocumento, cNombre AS Nombre FROM Tra_M_Remitente WHERE iCodRemitente='".$Rs['iCodRemitente']."'";
        $rsRemi=sqlsrv_query($cnx,$sqlRemi);
        $RsRemi = sqlsrv_fetch_array($rsRemi);
    }

    
    ?>

    <div class="row">
        <div class="col s12">
            <div class="card">
                <span class="card-title" style="display: block; line-height: 32px; margin-bottom: 8px; background: #d2e4f3; padding: 0 10px;">Datos de la empresa</span>
                <div class="card-content">
                    <small class="overline"><?php echo 'RUC ' . $RsRemi['NumDocumento'];?></small>
                    <h5 class="subtitle" style="margin-top: 0">
                        <?=$RsRemi['Nombre']?>
                    </h5>
                    <?//=$RsRemi['cDireccion']?>

                    <?php
                        // if(isset($RsRemi['cDepartamento']) && trim($RsRemi['cDepartamento']) !== '' ) {
                        //     $rsDep = sqlsrv_query($cnx, "SELECT cNomDepartamento FROM Tra_U_Departamento WHERE cCodDepartamento = " . $RsRemi['cDepartamento']);
                        //     $RsDep = sqlsrv_fetch_array($rsDep);

                        //     $rsPro = sqlsrv_query($cnx, "SELECT cNomProvincia FROM Tra_U_Provincia WHERE cCodDepartamento = " . $RsRemi['cDepartamento'] . " AND cCodProvincia = " . $RsRemi['cProvincia']);
                        //     $RsPro = sqlsrv_fetch_array($rsPro);

                        //     $rsDis = sqlsrv_query($cnx, "SELECT cNomDistrito FROM Tra_U_Distrito WHERE cCodDepartamento = " . $RsRemi['cDepartamento'] . " AND cCodProvincia = " . $RsRemi['cProvincia'] . " AND cCodDistrito = " . $RsRemi['cDistrito']);
                        //     $RsDis = sqlsrv_fetch_array($rsDis);

                        //     echo $RsDep['cNomDepartamento'] . " / " . $RsPro['cNomProvincia'] . " / " . $RsDis['cNomDistrito'];
                        // }
                    ?>
                </div>

                <!-- <div class="card-action">
                    <span><strong>Rep.</strong> <?//=$RsRemi['cRepresentante']?> <?php //if($RsRemi['cEmail']) echo' | ' . $RsRemi['cEmail']; ?><?php //if($RsRemi['nTelefono']) echo ' | <strong>Tel. </strong>' . $RsRemi['nTelefono']; ?><?php //if($RsRemi['nCelular']) echo ' | <strong>Cel. </strong> ' . $RsRemi['nCelular']; ?></span>  
                </div> -->
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function(){
        $('.collapsible').collapsible();
        $('.tooltipped').tooltip();
    });
</script>