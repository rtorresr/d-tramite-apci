<?php
date_default_timezone_set('America/Lima');
require_once("../conexion/conexion.php");
require_once("../conexion/parametros.php");
require_once('clases/DocDigital.php');
require_once("clases/Log.php");
require_once('../vendor/autoload.php');

if(isset($_POST['cud']) && $_POST['cud'] != null && trim($_POST['cud']) != '') {
    $parametrosListarGrupo = array(
        $_POST['cud']
    );
    $sqlListarGrupos= "{call UP_LISTAR_GRUPOS_POR_CUD (?) }";
    $rsListarGrupos = sqlsrv_query($cnx, $sqlListarGrupos, $parametrosListarGrupo);
    if($rsListarGrupos === false) {
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }
}else {
    $parametrosListarGrupo = array(
        $_POST['iCodMovimiento'][0]??0,
        $_POST['tipo']??'ninguno',
        $_POST['codigo']??0
    );
    $sqlListarGrupos= "{call SP_LISTAR_GRUPOS (?,?,?) }";
    $rsListarGrupos = sqlsrv_query($cnx, $sqlListarGrupos, $parametrosListarGrupo);
    if($rsListarGrupos === false) {
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }
}

$mostrarComentario = true;
if(isset($_POST['ocultarCom']) && $_POST['ocultarCom'] != null && trim($_POST['ocultarCom']) != '' && trim($_POST['ocultarCom']) == '1') {
    $mostrarComentario = false;
}

?>
<div class="row">
    <div class="col s12">
        <div class="card">
            <span class="card-title" style="display: block; line-height: 32px; margin-bottom: 8px; background: #d2e4f3; padding: 0 10px;"><!--Flujo del expediente--> <?//=$_POST['cud']?></span>
            <div class="card-content">                
            <?php
                $grupo = '';
                ?>
                <table class="table bordered striped highlight">
                    <thead>
                    <tr>
                        <th>Documento</th>                                                
                        <th>Acción</th>                                                
                        <th>Origen</th>                                                
                        <th>Destino</th>
                        <th>Fecha</th>
                        <?php if($mostrarComentario){ ?>                                                                                     
                        <th>Instrucción</th>
                        <?php } ?>
                        <?php if($mostrarComentario){ ?>   
                        <th>Plazo</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                <?php

                $docDigital = new DocDigital($cnx);        

                while ($RsListaGrupos = sqlsrv_fetch_array($rsListarGrupos)){
                    if ($grupo != $RsListaGrupos['cAgrupado']){
                        
                        $parametrosMov = array(
                            $RsListaGrupos['cAgrupado']
                        );
                        $sqlMov= "{call SP_FLUJO_DOCUMENTO (?) }";
                        $rsMov = sqlsrv_query($cnx, $sqlMov, $parametrosMov);
                        if($rsMov === false) {
                            http_response_code(500);
                            die(print_r(sqlsrv_errors()));
                        }
                        ?>
                            
                        <?php
                        $codigo = '';
                        $datos = array();
                        while ($RsMov = sqlsrv_fetch_array($rsMov)){
                            if($codigo != '' && $codigo != $RsMov['codigo']){   
                                $imprimir = 1;                                     
                                foreach ($datos as $valor){
                                    if($valor['nEstadoAnterior'] == 1 || $valor['nEstadoAnterior'] == 0 || $valor['nEstadoAnterior'] == 11){
                                        $style = 'style="background: yellow;"';
                                    }else{
                                        $style = '';
                                    }
                                    echo '<tr '.$style.'>';
                                    $origen = '';
                                    if(trim($valor['origen']) != '' && trim($valor['origen']) != 'Interno'){
                                        $origen = '<small><b>Externo:</b> '.trim($valor['origen']).'</small><br>';
                                    }
                                    if ($imprimir == 1){
                                        if ($valor['tipo'] == 'T'){
                                            echo '<td rowspan="'.count($datos).'">'.$origen.trim($valor['tipoDocumento']).' '.trim($valor['NroDocumento']).'</td>';
                                        }else {
                                            echo '<td rowspan="'.count($datos).'">PROYECTO '.trim($valor['tipoDocumento']).' '.trim($valor['NroDocumento']).'</td>';
                                        };
                                        $imprimir = 0;
                                    }
                                    echo '<td>'.$valor['estadoAnterior'].'</td>                                                
                                        <td><strong>'.$valor['oficinaOrigen'].'</strong><br/ >'.$valor['trabajadorOrigen'].'</td>                                                
                                        <td><strong>'.$valor['oficinaDerivar'].'</strong><br />'.$valor['trabajadorDerivar'].'</td>
                                        <td>'. $valor['fechaEnviado']->format('d-m-Y H:i:s') .'</td>';

                                    if($mostrarComentario){
                                        echo '<td>'. $valor['observacionMov'];
                                        
                                        if ($valor['adjuntosArchivar'] != null && $valor['adjuntosArchivar'] != '') {
                                            $anexos = explode("|", $valor['adjuntosArchivar']);
                                            foreach ($anexos as $valor) {
                                                $docDigital->obtenerDocDigitalPorId($valor);
                                                echo '<br/><a href="'.RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital().'" target="_blank">'.$docDigital->name.'</a>';
                                            }
                                        }

                                        echo '</td>';
                                    }
                                    if($mostrarComentario){
                                      echo '<td>';
                                      if (isset($valor['FecPlazo']) && $valor['FecPlazo'] != null && $valor['FecPlazo'] != ""){
                                          echo $valor['FecPlazo']->format('d-m-Y');
                                      }
                                      echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                                $codigo = $RsMov['codigo'];
                                unset($datos);
                                $datos = array();
                                array_push($datos,$RsMov);                                        
                                if($RsMov['nEstadoMovimiento'] == 1 || $RsMov['nEstadoMovimiento'] == 0 || $RsMov['nEstadoMovimiento'] == 11){                                            
                                    $adicional = array(
                                        'nEstadoAnterior' => $RsMov['nEstadoMovimiento'],
                                        'estadoAnterior' => $RsMov['estado'],
                                        'oficinaOrigen' => $RsMov['oficinaDerivar'],
                                        'trabajadorOrigen' => $RsMov['trabajadorDerivar'],
                                        'oficinaDerivar' => '---',
                                        'trabajadorDerivar' => '',
                                        'fechaEnviado' => $RsMov['fechaEnviado'],
                                        'observacionMov' => $RsMov['observacionMov'],
                                        'adjuntosArchivar' => $RsMov['adjuntosArchivar'],
                                        'FecPlazo' => $RsMov['FecPlazo'],
                                        'origen' => $RsMov['origen']
                                    );
                                    array_push($datos,$adicional);
                                }
                                if($RsMov['nEstadoMovimiento'] == 5){
                                    $adicional = array(
                                        'nEstadoAnterior' => $RsMov['nEstadoMovimiento'],
                                        'estadoAnterior' => $RsMov['estado'],
                                        'oficinaOrigen' => $RsMov['oficinaDerivar'],
                                        'trabajadorOrigen' => $RsMov['trabajadorDerivar'],
                                        'oficinaDerivar' => '---',
                                        'trabajadorDerivar' => '',
                                        'fechaEnviado' => $RsMov['fechaDerivado'],
                                        'observacionMov' => $RsMov['obsevacionFinalizar'],
                                        'adjuntosArchivar' => $RsMov['adjuntosArchivar'],
                                        'FecPlazo' => $RsMov['FecPlazo'],
                                        'origen' => $RsMov['origen']
                                    );
                                    array_push($datos,$adicional);
                                }                                                                                                                                                  
                            }else {
                                $codigo = $RsMov['codigo'];
                                array_push($datos,$RsMov);
                                if($RsMov['nEstadoMovimiento'] == 1 || $RsMov['nEstadoMovimiento'] == 0 || $RsMov['nEstadoMovimiento'] == 11){                                            
                                    $adicional = array(
                                        'nEstadoAnterior' => $RsMov['nEstadoMovimiento'],
                                        'estadoAnterior' => $RsMov['estado'],
                                        'oficinaOrigen' => $RsMov['oficinaDerivar'],
                                        'trabajadorOrigen' => $RsMov['trabajadorDerivar'],
                                        'oficinaDerivar' => '---',
                                        'trabajadorDerivar' => '',
                                        'fechaEnviado' => $RsMov['fechaEnviado'],
                                        'observacionMov' => $RsMov['observacionMov'],
                                        'adjuntosArchivar' => $RsMov['adjuntosArchivar'],
                                        'FecPlazo' => $RsMov['FecPlazo'],
                                        'origen' => $RsMov['origen']
                                    );
                                    array_push($datos,$adicional);
                                }
                                if($RsMov['nEstadoMovimiento'] == 5){
                                    $adicional = array(
                                        'nEstadoAnterior' => $RsMov['nEstadoMovimiento'],
                                        'estadoAnterior' => $RsMov['estado'],
                                        'oficinaOrigen' => $RsMov['oficinaDerivar'],
                                        'trabajadorOrigen' => $RsMov['trabajadorDerivar'],
                                        'oficinaDerivar' => '---',
                                        'trabajadorDerivar' => '',
                                        'fechaEnviado' => $RsMov['fechaDerivado'],
                                        'observacionMov' => $RsMov['obsevacionFinalizar'],
                                        'adjuntosArchivar' => $RsMov['adjuntosArchivar'],
                                        'FecPlazo' => $RsMov['FecPlazo'],
                                        'origen' => $RsMov['origen']
                                    );
                                    array_push($datos,$adicional);
                                }
                                continue;
                            }                                                                             
                        }
                        $imprimir = 1;                                     
                        foreach ($datos as $valor){
                            if($valor['nEstadoAnterior'] == 1 || $valor['nEstadoAnterior'] == 0 || $valor['nEstadoAnterior'] == 11){
                                $style = 'style="background: yellow;"';
                            }else{
                                $style = '';
                            }
                            echo '<tr '.$style.'>';
                            $origen = '';
                            if(trim($valor['origen']) != '' && trim($valor['origen']) != 'Interno'){
                                $origen = '<small><b>Externo:</b> '.trim($valor['origen']).'</small><br>';
                            }
                            if ($imprimir == 1){
                                if ($valor['tipo'] == 'T'){
                                    echo '<td rowspan="'.count($datos).'">'.$origen.trim($valor['tipoDocumento']).' '.trim($valor['NroDocumento']).'</td>';
                                }else {
                                    echo '<td rowspan="'.count($datos).'">PROYECTO '.trim($valor['tipoDocumento']).' '.trim($valor['NroDocumento']).'</td>';
                                };
                                $imprimir = 0;
                            }
                            echo '<td>'.$valor['estadoAnterior'].'</td>
                                <td><strong>'.$valor['oficinaOrigen'].'</strong><br/ >'.$valor['trabajadorOrigen'].'</td>                                        
                                <td><strong>'.$valor['oficinaDerivar'].'</strong><br />'.$valor['trabajadorDerivar'].'</td>                                        
                                <td>'.($valor['fechaEnviado'] == null ? '' :  $valor['fechaEnviado']->format('d-m-Y H:i:s'))  .'</td>';

                            if($mostrarComentario){
                                echo '<td>'. $valor['observacionMov'];
                                if ($valor['adjuntosArchivar'] != null && $valor['adjuntosArchivar'] != '') {
                                    $anexos = explode("|", $valor['adjuntosArchivar']);
                                    foreach ($anexos as $valor) {
                                        $docDigital->obtenerDocDigitalPorId($valor);
                                        echo '<br/><a href="'.RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital().'" target="_blank">'.$docDigital->name.'</a>';
                                    }
                                }

                                echo '</td>';
                            }
                            if($mostrarComentario){
                              echo '<td>';
                              if (isset($valor['FecPlazo']) && $valor['FecPlazo'] != null && $valor['FecPlazo'] != ""){
                                  echo $valor['FecPlazo']->format('d-m-Y');
                              }
                              echo '</td>';
                            }
                            
                            echo '</tr>';
                        }
                        unset($datos);
                        $grupo = $RsListaGrupos['cAgrupado'];
                    } else {
                        continue;
                    }
                }

                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 