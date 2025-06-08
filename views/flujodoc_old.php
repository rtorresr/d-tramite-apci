<?php
date_default_timezone_set('America/Lima');
include_once("../conexion/conexion.php");

if (isset($_POST['iCodMovimiento'])){
    $rsflujo = sqlsrv_query($cnx, "SELECT iCodTramite,iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$_POST['iCodMovimiento'][0]);
    $Rsflujo = sqlsrv_fetch_array($rsflujo);

    if($Rsflujo['iCodTramite'] !== null ){
        $codigoBus = $Rsflujo['iCodTramite'];
        $tipoBus = 't';
    } else {
        $codigoBus = $Rsflujo['iCodProyecto'];
        $tipoBus = 'p';
    }
} else {
    if (!isset($_POST['tipo'])) {
        $codigoBus = $_POST['codigo'][0];
        $tipoBus = 't';
    } else {
        $codigoBus = $_POST['codigo'][0];
        $tipoBus = 'p';
    }
}


/*$codigoBus = $_GET['codigo'];
$tipoBus = $_GET['tipo'];*/

function siglasOficina ($codigoOfi,$conexion){
    $rssiglas = sqlsrv_query($conexion,"SELECT TRIM(cSiglaOficina) AS oficina FROM Tra_M_Oficinas WHERE iCodOficina = ".$codigoOfi);
    $Rssiglas = sqlsrv_fetch_array($rssiglas);
    return $Rssiglas['oficina'];
}

function nombresTrabajador ($codigoTra,$conexion){
    $rstrabajador = sqlsrv_query($conexion,"SELECT TRIM(cNombresTrabajador)+' '+TRIM(cApellidosTrabajador) AS nombres FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$codigoTra);
    $Rstrabajador = sqlsrv_fetch_array($rstrabajador);
    return $Rstrabajador['nombres'];
}

function estadosMovimiento ($estado,$aprobar,$visado,$firmado){
    switch ($estado){
        case 0:
            return 'Pendiente';
            break;
        case 1:
            if($aprobar == '0'){
                return 'En proceso';
            } else {
                if($firmado == '1'){
                    return 'Para firmar';
                } else if ($visado == '1') {
                    return 'Para visar';
                } else {
                    return 'Para aprobar';
                }
            }
            break;

        case 2:
            return 'Derivado';
            break;

        case 3:
            return 'Delegado';
            break;

        case 4:
            return 'Respondido';
            break;

        case 5:
            return 'Finalizado';
            break;

        case 6:
            return 'Rechazado';
            break;

        case 7:
            return 'Cancelado';
            break;

        case 8:
            return 'Visado';
            break;

        case 9:
            return 'Firmado';
            break;
    }
}

function listarMovimiento($tipo,$codigo,$conexion,$clase = " "){
    if($tipo === 't'){
        $atributo = 'iCodTramite';
    } else {
        $atributo = 'iCodProyecto';
    }

    $rsMov = sqlsrv_query($conexion,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE ".$atributo." = ".$codigo." order by 1 desc" );
    ?>
<div class="collapsible-body">
<table class="table bordered striped highlight">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Copia</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    <?php
    WHILE ($RsMov = sqlsrv_fetch_array($rsMov)){
        echo '<tr class="'.$clase.'">
           <td>'. $RsMov['fFecMovimiento']->format('d-m-Y H:i:s') .'</td>
           <td><strong>'.siglasOficina($RsMov['iCodOficinaOrigen'],$conexion).'
           </strong><br/ >'.nombresTrabajador($RsMov['iCodTrabajadorRegistro'],$conexion).'</td>
           <td><strong>'.siglasOficina($RsMov['iCodOficinaDerivar'],$conexion).'
           </strong><br />'.nombresTrabajador($RsMov['iCodTrabajadorDerivar'],$conexion).'</td>
           <td>'.$RsMov['cFlgCopia'].'</td>
           <td>'.estadosMovimiento($RsMov['nEstadoMovimiento'],$RsMov['paraAprobar'],$RsMov['paraVistar'],$RsMov['paraFirmar']).'</td>  
        </tr>';
    }
    ?>
</tbody>
</table>
</div>
</li>
    <?php
}

function datosDocumento($tipo,$codigo,$conexion,$clase = ' '){
    if($tipo === 't'){
        $tabla = 'Tra_M_Tramite';
        $atributo = 'iCodTramite';
        $documento = '<span class="new badge green" data-badge-caption="">T</span>';
    } else {
        $tabla = 'Tra_M_Proyecto';
        $atributo = 'iCodProyecto';
        $documento = '<span class="new badge gray" data-badge-caption="">P</span>';
    }
    $sqlDatos = "SELECT tipo.cDescTipoDoc, 
                    CASE 
                        WHEN tab.cNroDocumento IS NOT NULL THEN TRIM(tab.cNroDocumento)
                        ELSE TRIM(tab.cCodificacion)
                    END AS numeracion, 
                    tab.nCud, tab.fFecRegistro
                FROM ".$tabla." AS tab 
                LEFT JOIN Tra_M_Tipo_Documento AS tipo ON tab.cCodTipoDoc = tipo.cCodTipoDoc
                WHERE ".$atributo." = ".$codigo;
    $rsDatos = sqlsrv_query($conexion,$sqlDatos);
    $RsDatos = sqlsrv_fetch_array($rsDatos);
    $datos = "<li class='".$clase."'><div class='collapsible-header'><header style='display: flex'><div style='padding-right: 0.5rem'>" .$documento. "</div><div>CUD: ".$RsDatos['nCud']. "<br>".$RsDatos['cDescTipoDoc']." N° ".$RsDatos['numeracion']."<br><span style='color: rgba(0, 0, 0, 0.49)'>". $RsDatos['fFecRegistro']->format('d-m-Y H:i:s') ."</span></div></header></div>";
    echo $datos;
}

function consultaPosterior($tipo,$codigo,$conexion){
    if($tipo === 't'){
        $atributo = 'iCodTramiteRespuesta';
    } else {
        $atributo = 'iCodProyectoRef';
    }

    $rsTablaTramite = sqlsrv_query($conexion,"SELECT iCodTramite FROM Tra_M_Tramite WHERE ".$atributo." = ".$codigo);
    $rsTablaProyecto = sqlsrv_query($conexion,"SELECT iCodProyecto FROM Tra_M_Proyecto WHERE ".$atributo." = ".$codigo);

    $resultado = [];
    if(sqlsrv_has_rows($rsTablaTramite)){
        $resultado['tiene'] = 1;
        $RsTablaTramite = sqlsrv_fetch_array($rsTablaTramite);
        $resultado['codigo'] = $RsTablaTramite['iCodTramite'];
        $resultado['tipo'] = 't';
    } else if (sqlsrv_has_rows($rsTablaProyecto)){
        $resultado['tiene'] = 1;
        $RsTablaProyecto = sqlsrv_fetch_array($rsTablaProyecto);
        $resultado['codigo'] = $RsTablaProyecto['iCodProyecto'];
        $resultado['tipo'] = 'p';
    } else {
        $resultado['tiene'] = 0;
    }

    return $resultado;
}

function consultaAnterior($tipo,$codigo,$conexion){
    if($tipo === 't'){
        $tabla = 'Tra_M_Tramite';
        $atributo = 'iCodTramite';
    } else {
        $tabla = 'Tra_M_Proyecto';
        $atributo = 'iCodProyecto';
    }

    $rsBuscaAnterior = sqlsrv_query($conexion,"SELECT iCodTramiteRespuesta, iCodProyectoRef FROM ".$tabla." WHERE ".$atributo." = ".$codigo);
    $RsBuscaAnterior = sqlsrv_fetch_array($rsBuscaAnterior);

    $resultado = [];
    if($RsBuscaAnterior['iCodTramiteRespuesta'] !== null && $RsBuscaAnterior['iCodTramiteRespuesta'] != 0){
        $resultado['tiene'] = 1;
        $resultado['codigo'] = $RsBuscaAnterior['iCodTramiteRespuesta'];
        $resultado['tipo'] = 't';
    } else if ($RsBuscaAnterior['iCodProyectoRef'] !== null){
        $resultado['tiene'] = 1;
        $resultado['codigo'] = $RsBuscaAnterior['iCodProyectoRef'];
        $resultado['tipo'] = 'p';
    } else {
        $resultado['tiene'] = 0;
    }
    return $resultado;
}
 ?>
<ul class="collapsible">
<?php 
//ANTERIOR AL TRAMITE
//Busca hasta el mas antiguo
$buscaAnt = consultaAnterior($tipoBus,$codigoBus,$cnx);
if($buscaAnt['tiene'] === 1) {
    while ($buscaAnt['tiene'] === 1) {
        $datosUlt = $buscaAnt;
        $buscaAnt = consultaAnterior($buscaAnt['tipo'], $buscaAnt['codigo'], $cnx);
    }
    datosDocumento($datosUlt['tipo'], $datosUlt['codigo'], $cnx,'');
    listarMovimiento($datosUlt['tipo'], $datosUlt['codigo'], $cnx,'');

    //Busca siguientes hasta el tramite actual
    $buscaSig = consultaPosterior($datosUlt['tipo'],$datosUlt['codigo'],$cnx);
    while ($buscaSig['tiene'] === 1){
        if($buscaSig['tipo'] === $tipoBus && $buscaSig['codigo'] == $codigoBus) {
            break;
        }
        datosDocumento($buscaSig['tipo'],$buscaSig['codigo'],$cnx);
        listarMovimiento($buscaSig['tipo'],$buscaSig['codigo'],$cnx);
        $buscaSig = consultaPosterior($buscaSig['tipo'],$buscaSig['codigo'],$cnx);
    }
}

//TRAMITE BUSCADO
?>
    <?php
    
        datosDocumento($tipoBus,$codigoBus,$cnx, 'active');
        listarMovimiento($tipoBus,$codigoBus,$cnx);
    ?>

<?php

//POSTERIOR AL TRAMITE
$buscaPost = consultaPosterior($tipoBus,$codigoBus,$cnx);
while ($buscaPost['tiene'] === 1){
    datosDocumento($buscaPost['tipo'],$buscaPost['codigo'],$cnx);
    listarMovimiento($buscaPost['tipo'],$buscaPost['codigo'],$cnx);
    $buscaPost = consultaPosterior($buscaPost['tipo'],$buscaPost['codigo'],$cnx);
}

?>
</ul>

<script>
    $('.collapsible').collapsible();
</script>