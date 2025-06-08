<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Registro de Documento";
$activeItem = "registro-de-documento.php";
$navExtended = true;

$nNumAno    = date("Y");
if($_SESSION['CODIGO_TRABAJADOR']!=""){
	if (!isset($_SESSION["cCodRef"])){
		$fecSesRef = date("Ymd-Gis");
		$_SESSION['cCodRef'] = $_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesRef;
	}
	if (!isset($_SESSION["cCodOfi"])){
		$fecSesOfi=date("Ymd-Gis");
		$_SESSION['cCodOfi']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesOfi;
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link href="includes/component-dropzone.css" rel="stylesheet">

</head>
<body class="theme-default has-fixed-sidenav" onload="mueveReloj()">
<?php include("includes/menu.php");?>
<a name="area"></a>

<!--Main layout-->
 <main>
    <div class="navbar-fixed actionButtons">
        <nav>
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="">
                    <li><a href="javascript:;" id="rsit" class="btn btn-primary"><i class="fas fa-save fa-fw left"></i><span>Registrar</span></a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container">
        <?php
            include_once("../conexion/conexion.php");
            $sqlProfesional = "SELECT TMPU.iCodPerfil AS iCodPerfil FROM Tra_M_Trabajadores TMT 
                                                    INNER JOIN Tra_M_Perfil_Ususario TMPU ON TMT.iCodTrabajador = TMPU.iCodTrabajador
                                                    WHERE TMT.iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
            $rsProfesional = sqlsrv_query($cnx,$sqlProfesional);
            $RsProfesional = sqlsrv_fetch_array($rsProfesional);
            if ($RsProfesional['iCodPerfil'] == 4){ // Perfil Profesional tiene código 4
                $esProfesional = 1;
            }else{
                $esProfesional = 0;
            }

        if (isset($_GET["msg"])){
            switch ($_GET["msg"]){
                case 1:
                    $observacion = "<p>Se Registro el documento correctamente.</p>";
                    $cardStatus="success";
                    $notificacion="
                                    <div class='rectangle'>
                                        <div class='notification-text'>
                                            $observacion
                                        </div>
                                    </div>
                                ";
                break;
            }
        }

            $sqlUsr = "SELECT TMT.iCodOficina AS iCodOficina FROM Tra_M_Trabajadores TMT
                                    INNER JOIN Tra_M_Oficinas TMO ON TMT.iCodOficina = TMO.iCodOficina
                                    INNER JOIN Tra_M_Categoria TMC ON TMT.iCodCategoria = TMC.iCodCategoria
                                    WHERE TMT.iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
            $rsUsr  = sqlsrv_query($cnx,$sqlUsr);
            $RsUsr  = sqlsrv_fetch_array($rsUsr);

            $sqlEmail = "SELECT iCodTrabajador, cMailTrabajador FROM Tra_M_Trabajadores 
                                    WHERE iCodOficina = '".$RsUsr['iCodOficina']."' AND iCodCategoria = 5";
            $rsEmail  = sqlsrv_query($cnx,$sqlEmail);
            $RsEmail  = sqlsrv_fetch_array($rsEmail);

            if (isset($notificacion)){
            ?>
            <!--Card Danger-->
            <div class="card z-depth-0 card-<?php echo $cardStatus; ?>">
                <div class="card-content">
                    <?php echo $observacion;?>
                </div>
            </div>
        <?php } ?>
        <form name="frmRegistro" id="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
            <input type="hidden" name="opcion" value="">
            <input type="hidden" name="radioSeleccion" value="">
            <input type="hidden" name="nFlgRpta" value="">
            <!-- $_GET['responder'] == 10 CUANDO VIENE DE PROFESIONAL QJUE QUIERE RESPONDER -->
            <input type="hidden" name="responder" value=<?php echo $_GET['responder']??''; ?>>
            <input type="hidden" name="fFecPlazo" value="">
            <input type="hidden" name="iCodTrabajadorJefe" value="<?php echo trim($RsEmail['iCodTrabajador']); ?>" />
            <input type="hidden" name="id_identificador" value="<?php echo random_int(100,999);?>">
            <input type="hidden" name="cMailTrabajador" value="<?php echo trim($RsEmail['cMailTrabajador']); ?>" />
            <input type="hidden" name="Jefe" value="<?=$_SESSION['JEFE']?>">
            <input type="hidden" name="iCodTramiteSel" value="<?=$_GET['iCodTramiteSel']??''?>">
            <input type="hidden" name="ListaDeCopias[]">

            <?php
                $sqlPerfil = "SELECT iCodPerfil FROM Tra_M_Perfil_Ususario WHERE iCodTrabajador=".$_SESSION['CODIGO_TRABAJADOR']." AND iCodOficina = ".$_SESSION['iCodOficinaLogin'];
                    $rsPefil   = sqlsrv_query($cnx,$sqlPerfil);
                    $RsPefil   = sqlsrv_fetch_array($rsPefil);
                    $porAprobar = '';
                    if ($RsPefil['iCodPerfil'] === 3) {
                        $porAprobar = '';
                        //echo "Punto de Control - Jefes";
                    }elseif ($RsPefil['iCodPerfil'] === 4) {
                        $porAprobar = '(Por Aprobar)';
                        //echo "Profesional";
                    }elseif ($RsPefil['iCodPerfil'] === 19) {
                        $porAprobar = '(Por Aprobar)';
                        //echo "Punto de Control - Asistentes";
                    }elseif ($RsPefil['iCodPerfil'] === 20) {
                        $porAprobar = '(Por Aprobar)';
                        //echo "Punto de Control - Especial";
                    }
            ?>
            <?php
                $idReferencia = $_POST['idReferencia']??'';
                if($idReferencia !== ''){

                    $sqlDocRefRespuesta = 'SELECT A.iCodTramite,B.nCud,A.cCodTipoDocDerivar,C.cDescTipoDoc,B.cCodificacion,A.iCodOficinaOrigen FROM Tra_M_Tramite_Movimientos A INNER JOIN Tra_M_Tramite B ON A.iCodTramite = B.iCodTramite INNER JOIN Tra_M_Tipo_Documento C ON A.cCodTipoDocDerivar = C.cCodTipoDoc WHERE A.iCodMovimiento = '.$_POST['idReferencia'];
                    //echo $sqlDocRefRespuesta;

                    $rsDocRefRespuesta   = sqlsrv_query($cnx,$sqlDocRefRespuesta);
                    $RsDocRefRespuesta   = sqlsrv_fetch_array($rsDocRefRespuesta);
            ?>
            <div class="row">
                <div class="col s9">
                    <div class="card card-info">
                        <div class="card-content">
                            <input type="hidden" value="<?php echo $RsDocRefRespuesta['iCodTramite']; ?>" name="iCodTramiteRespuesta">
                            Respondiendo el documento <strong><?php echo $RsDocRefRespuesta['cDescTipoDoc'].' N° '.trim($RsDocRefRespuesta['cCodificacion']);?></strong>, con expediente <strong><?=$RsDocRefRespuesta['nCud'] ?></strong>
                        </div>
                    </div>
                </div>

            </div>
            <?php } ?>
            <div class="row">
                <div class="col s12 m9">
                    <div class="card hoverable">
                        <div class="card-body">
                            <fieldset>
                                <legend>Datos del documento</legend>
                                <div class="row">
                                    <div class="col m3 input-field" id="idProyecto">
                                        <div class="switch">
                                            <label>
                                                No Proyectado
                                                <input type="checkbox" id="Proyecto" name="proyecto" value="Si">
                                                <span class="lever"></span>
                                                Proyectado
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m3 input-field">
                                        <select name="cCodTipoTra" id="cCodTipoTra" class="FormPropertReg form-control" onChange="plantilla()" >
                                            <option value="">Interno</option>
                                            <option value="">Externo</option>
                                        </select>
                                        <label for="cCodTipoTra">Tipo de Trámite</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select name="cCodTipoDoc" id="cCodTipoDoc" class="FormPropertReg form-control" onChange="plantilla()" >
                                            <option value="">Seleccione</option>
                                                <?php
                                                    $sqlTipo = "SELECT * FROM Tra_M_Tipo_Documento   WHERE nFlgInterno = 1 AND cCodTipoDoc != 45  ORDER BY cDescTipoDoc ASC";
                                                    $rsTipo = sqlsrv_query($cnx,$sqlTipo);
                                                    while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
                                                        if($RsTipo["cCodTipoDoc"] == ($_POST['cCodTipoDoc']??'')){
                                                            $selecTipo = "selected";
                                                        }else{
                                                            $selecTipo = "";
                                                        }
                                                        echo "<option value='".trim($RsTipo["cCodTipoDoc"])."' ".$selecTipo.">".trim($RsTipo["cDescTipoDoc"])."</option>";
                                                    }
                                                    sqlsrv_free_stmt($rsTipo);
                                            ?>
                                        </select>
                                        <label for="cCodTipoDoc">Tipo de Documento</label>
                                    </div>
                                    
                                    <!--<div class="col s12 m3 input-field" id="posibleCodifa">
                                        <input placeholder="Se autogenerará" type="text" id="posibleCodificacion" class="FormPropertReg form-control disabled" disabled />
                                        <label class="active" for="posibleCodificacion">Número de Documento</label>
                                    </div>-->
                                    <div class="col s5 m3 input-field">
                                        <input placeholder="dd-mm-aaaa" value="<?=$_GET['fFecPlazo']??''?>" type="text" id="fFecPlazo" name="fFecPlazo" class="FormPropertReg form-control datepicker">
                                        <label for="fFecPlazo">Fecha de Plazo</label>
                                        <span class="helper-text" data-error="wrong" data-success="right">Opcional</span>
                                    </div>
                                    <div class="col s5 m3 input-field">
                                        <input id="reloj" value="&nbsp;" type="text" name="reloj" class="FormPropertReg form-control" onfocus="window.document.frmRegistro.reloj.blur()">
                                        <label for="reloj">Fecha de Registro</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m6 input-field">
                                        <textarea name="cAsunto" class="FormPropertReg materialize-textarea"><?=$_POST['cAsunto']??''?></textarea>
                                        <label for="cAsunto">Asunto</label>
                                    </div>
                                    <div class="col s12 m6 input-field">
                                        <textarea id="cObservaciones" name="cObservaciones" class="FormPropertReg materialize-textarea"><?php echo $_POST['cObservaciones']??''; ?></textarea>
                                        <label for="cObservaciones">Observaciones</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s2 m2 input-field">
                                        <input id="nNumFolio" type="number" name="nNumFolio" value="<?php if(($_POST['nNumFoliociones']??'')==""){echo 1;} else { echo $_POST['nNumFoliociones'];}?>" class="FormPropertReg form-control"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>
                                        <label for="nNumFolio" class="active">Folios</label>
                                    </div>
                                    <div class="col s4 m4 input-field">
                                        <div class="switch">
                                            <label>
                                                Nuevo tramite
                                                <input type="checkbox" id="flgSigo" name="flgSigo" value="1">
                                                <span class="lever"></span>
                                                Proviene del Sigo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m12 input-field">
                                        <textarea name="editorOficina" id="editorOficina"></textarea>
                                        <!--<label for="editor">Contenido del documento</label>-->
                                    </div>
                                    <div class="col m6 input-field" style="display: none;">
                                        <select id="cSiglaAutor" name="cSiglaAutor" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                            <option value="">Seleccione</option>
                                                <?php
                                                    $sqlTipo = "SELECT iCodTrabajador,
                                                            (SELECT (rtrim(ltrim(cNombresTrabajador))+' '+cApellidosTrabajador) AS nombre FROM Tra_M_Trabajadores WHERE iCodTrabajador=mu.iCodTrabajador) AS nombreapellido
                                                            FROM Tra_M_Perfil_Ususario mu 
                                                            WHERE icodOficina ='".$_SESSION['iCodOficinaLogin']."'";

                                                $rsTipo = sqlsrv_query($cnx,$sqlTipo);
                                                while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
                                                    if($RsTipo['iCodTrabajador'] == ($_POST['cCodTipoDoc']??'')){
                                                        $selecTipo = "selected";
                                                    }else{
                                                        $selecTipo = "";
                                                    }
                                                    if($RsTipo['nombreapellido']!=''){
                                                        echo "<option value=".$RsTipo["iCodTrabajador"]." ".$selecTipo.">".$RsTipo["nombreapellido"]."</option>";
                                                    }
                                                }
                                                sqlsrv_free_stmt($rsTipo);
                                            ?>
                                        </select>
                                        <label for="cSiglaAutor">Autor</label>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Datos del destinatario</legend>
                                <?php
                                    if($idReferencia !== ''){
                                ?>
                                        <div class="row" id="noPro">
                                            <div class="col m6 input-field">
                                                <?php
                                                    $sqlOfiRespuesta = "SELECT iCodOficina,cNomOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0  AND iCodOficina =  ".$RsDocRefRespuesta['iCodOficinaOrigen'];
                                                    $rsOfiRespuesta  = sqlsrv_query($cnx,$sqlOfiRespuesta);
                                                    $RsOfiRespuesta  = sqlsrv_fetch_array($rsOfiRespuesta);
                                                ?>
                                                <input type="hidden" name="iCodOficinaResponsable" value="<?php echo $RsOfiRespuesta['iCodOficina'];?>">
                                                <input name="oficinaDestino" placeholder="Oficina Destino" type="text" id="oficinaDestino" class="FormPropertReg form-control disabled"  value="<?php echo $RsOfiRespuesta['cNomOficina'];?>" disabled />
                                                <label class="active" for="oficinaDestino">Oficina Destino</label>
                                            </div>
                                            <div class="col m6 input-field">
                                                <?php
                                                $sqlJefeDestino = "SELECT iCodTrabajador,iCodOficina,cNombresTrabajador,cApellidosTrabajador,iCodPerfil FROM Tra_M_Trabajadores WHERE iCodTrabajador = (SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario  WHERE iCodOficina = '".$RsDocRefRespuesta['iCodOficinaOrigen']."' AND iCodPerfil = 3)";
                                                $rsJefeDestino  = sqlsrv_query($cnx,$sqlJefeDestino);
                                                $RsJefeDestino = sqlsrv_fetch_array($rsJefeDestino);
                                                ?>
                                                <input type="hidden" name="iCodTrabajadorResponsable" value="<?php echo $rsJefeDestino['iCodTrabajador'];?>">
                                                <input name="responsableDestino" placeholder="Responsable" type="text" id="responsableDestino" class="FormPropertReg form-control disabled"  value="<?php echo rtrim($RsJefeDestino['cNombresTrabajador']).', '.rtrim($RsJefeDestino['cApellidosTrabajador']);?>" disabled />
                                                <label class="active" for="responsableDestino">Responsable</label>
                                            </div>
                                        </div>
                                 <?php
                                    }
                                    else {?>
                                            <div class="row" id="noPro">
                                                <div class="col m12">
                                                    <div id="areaOficina">
                                                        <div class="row">
                                                            <div class="col s12 m6 input-field">
                                                                <select name="iCodOficinaResponsable"
                                                                        id="iCodOficinaMov"
                                                                        class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                        searchable="Buscar aqui.."
                                                                        onChange="loadResponsables(this.value);">
                                                                    <option value="">Seleccione Oficina</option>
                                                                    <?php
                                                                    $sqlOficina = "SELECT * FROM Tra_M_Oficinas  WHERE iFlgEstado != 0  AND iCodOficina !=  " . $_SESSION['iCodOficinaLogin'] . "ORDER BY cNomOficina ASC";

                                                                    $rsOficina = sqlsrv_query($cnx, $sqlOficina);
                                                                    while ($RsDep2 = sqlsrv_fetch_array($rsOficina)) {
                                                                        if ($RsDep2['iCodOficina'] === ($_POST['iCodOficinaResponsable'] ?? '')) {
                                                                            $selecOfi = "selected";
                                                                        } else {
                                                                            $selecOfi = "";
                                                                        }
                                                                        echo "<option value=" . $RsDep2["iCodOficina"] . " " . $selecOfi . ">" . trim($RsDep2["cNomOficina"]) . " | " . trim($RsDep2["cSiglaOficina"]) . "</option>";
                                                                    }
                                                                    sqlsrv_free_stmt($rsDep2);
                                                                    ?>
                                                                </select>
                                                                <label for="iCodOficinaMov">Oficina</label>
                                                            </div>
                                                            <!-- <div class="col s2 input-field">
                                                                <input type="hidden" name="iCodTrabajadorResponsable"  id="responsablei">
                                                                <label id="responsable" >Responsable</label>
                                                            </div> -->
                                                            <div class="input-field input-disabled col s12 m6">
                                                                <input type="hidden" name="iCodTrabajadorResponsable"
                                                                       id="responsablei">
                                                                <input class="disabled" value="&nbsp;" id="responsable"
                                                                       type="text">
                                                                <label class="active"
                                                                       for="responsable">Responsable</label>
                                                            </div>
                                                            <div class="col s12 m3 input-field">
                                                                <select name="iCodIndicacionMov" id="iCodIndicacionMov"
                                                                        class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                        searchable="Buscar aqui..">
                                                                    <option value="" disabled selected>Seleccione
                                                                    </option>
                                                                    <?php
                                                                    $sqlIndic = "SELECT * FROM Tra_M_Indicaciones ";
                                                                    $sqlIndic .= "ORDER BY cIndicacion ASC";
                                                                    $rsIndic = sqlsrv_query($cnx, $sqlIndic);
                                                                    while ($RsIndic = sqlsrv_fetch_array($rsIndic)) {
                                                                        if ($RsIndic['iCodIndicacion'] == ($_POST['iCodIndicacionMov'] ?? '') or $RsIndic['iCodIndicacion'] == 3) {
                                                                            $selecIndi = "selected";
                                                                        } else {
                                                                            $selecIndi = "";
                                                                        }
                                                                        echo "<option value=" . trim($RsIndic["iCodIndicacion"]) . " " . $selecIndi . ">" . trim($RsIndic["cIndicacion"]) . "</option>";
                                                                    }
                                                                    sqlsrv_free_stmt($rsIndic);
                                                                    ?>
                                                                </select>
                                                                <label for="iCodIndicacionMov">Indicación</label>
                                                            </div>
                                                            <div class="col s12 m3 input-field">
                                                                <select name="cPrioridad" id="cPrioridad"
                                                                        class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                        searchable="Buscar aqui..">
                                                                    <option <?php if (($_POST['cPrioridad'] ?? '') === "Alta") echo "selected" ?>
                                                                            value="Alta">Alta
                                                                    </option>
                                                                    <option <?php if (($_POST['cPrioridad'] ?? '') === "Media") echo "selected" ?>
                                                                            value="Media" selected>Media
                                                                    </option>
                                                                    <option <?php if (($_POST['cPrioridad'] ?? '') === "Baja") echo "selected" ?>
                                                                            value="Baja">Baja
                                                                    </option>
                                                                </select>
                                                                <label for="cPrioridad">Prioridad</label>
                                                            </div>
                                                            <div class="col s2">
                                                                <br>
                                                                <input name="button" type="button"
                                                                       class="btn btn-secondary"
                                                                       value="Agregar destinatario"
                                                                       onclick="insertarMovimientoTemporal()">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="display:none" id="areaMultiple">
                                                        <a class="btn btn-secondary" id="listaOficinas"">Seleccionar
                                                        Oficinas</a>
                                                    </div>
                                                    <table class="hoverable striped" width="1000">
                                                        <thead>
                                                        <tr>
                                                            <td class="headColumnas">Oficina</td>
                                                            <td class="headColumnas">Trabajador</td>
                                                            <td class="headColumnas">Indicaci&oacute;n</td>
                                                            <td class="headColumnas">Prioridad</td>
                                                            <td class="headColumnas">Copia</td>
                                                            <td class="headColumnas">Opci&oacute;n</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="listaMovimientoTemporal">
                                                        </tbody>
                                                    </table>
                                                    <?php if (($_POST['radioSeleccion'] ?? '') == 1) { ?>
                                                        <script language="javascript" type="text/javascript">
                                                            activaOficina();
                                                        </script>
                                                    <?php } ?>
                                                    <?php if (($_POST['radioSeleccion'] ?? '') == 2) { ?>
                                                        <script language="javascript" type="text/javascript">
                                                            activaMultiple();
                                                        </script>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php
                                    }
                                ?>
                                <div class="row" style="display: none" id="siPro">
                                    <div class="col m6 input-field">
                                        <?php
                                        if ($_SESSION['iCodPerfilLogin'] != 3){
                                            $sqlOfiRespuesta = "SELECT iCodOficina,cNomOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0  AND iCodOficina =  ".$_SESSION['iCodOficinaLogin'];
                                        } else {
                                            $sqlofi = "select cSiglaOficina as sigla  from Tra_M_Oficinas where iCodOficina =".$_SESSION['iCodOficinaLogin'];
                                            $qofice=sqlsrv_query($cnx,$sqlofi);
                                            $siglaoficina=sqlsrv_fetch_array($qofice);

                                            if (strpos($siglaoficina['sigla'], '-')){
                                                $arrayoficina = explode("-", $siglaoficina['sigla']);
                                                $oficinajefe = $arrayoficina[0];
                                            }else{
                                                //$oficinajefe = $siglaoficina['sigla'];
                                                $oficinajefe = 'DE';
                                            }

                                            $sqlOfiRespuesta = "SELECT iCodOficina, cNomOficina FROM Tra_M_Oficinas WHERE RTRIM(cSiglaOficina) = '".$oficinajefe."'";
                                        }
                                        $rsOfiRespuesta  = sqlsrv_query($cnx,$sqlOfiRespuesta);
                                        $RsOfiRespuesta  = sqlsrv_fetch_array($rsOfiRespuesta);
                                        ?>
                                        <input type="hidden" name="iCodOficinaResponsable" value="<?php echo $RsOfiRespuesta['iCodOficina'];?>">
                                        <input name="oficinaDestino" placeholder="Oficina Destino" type="text" id="oficinaDestino" class="FormPropertReg form-control disabled"  value="<?php echo $RsOfiRespuesta['cNomOficina'];?>" disabled />
                                        <label class="active" for="oficinaDestino">Oficina Destino</label>
                                    </div>
                                    <div class="col m6 input-field">
                                        <?php
                                        $sqlJefeDestino = "SELECT iCodTrabajador,iCodOficina,cNombresTrabajador,cApellidosTrabajador,iCodPerfil FROM Tra_M_Trabajadores WHERE iCodTrabajador = (SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario  WHERE iCodOficina = '".$RsOfiRespuesta['iCodOficina']."' AND iCodPerfil = 3)";
                                        $rsJefeDestino  = sqlsrv_query($cnx,$sqlJefeDestino);
                                        $RsJefeDestino = sqlsrv_fetch_array($rsJefeDestino);
                                        ?>
                                        <input type="hidden" name="iCodTrabajadorResponsable" value="<?php echo $rsJefeDestino['iCodTrabajador'];?>">
                                        <input name="responsableDestino" placeholder="Responsable" type="text" id="responsableDestino" class="FormPropertReg form-control disabled"  value="<?php echo rtrim($RsJefeDestino['cNombresTrabajador']).', '.rtrim($RsJefeDestino['cApellidosTrabajador']);?>" disabled />
                                        <label class="active" for="responsableDestino">Responsable</label>
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card hoverable transparent">
                        <div class="card-body">
                            <fieldset>
                                <legend>Referencias</legend>
                                <div class="row">
                                    <div class="col m12">
                                        <select id="cReferencia" class="js-example-basic-multiple-limit browser-default" name="cReferencia[]" multiple="multiple"></select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Archivo</legend>
                                <div class="row">
                                    <div class="col m12 input-field">
                                        <textarea name="archivoFisico" id="archivoFisico" class="FormPropertReg materialize-textarea"><?php echo trim($_POST['archivoFisico']??''); ?></textarea>
                                        <label for="archivoFisico">Archivo F&iacute;sico</label>
                                        <?php
                                            // $sqlEsProfesional = "SELECT iCodPerfil FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
                                            $sqlEsProfesional = "SELECT iCodPerfil FROM Tra_M_Perfil_Ususario 
                                                                                    WHERE iCodTrabajador = '".$_SESSION['CODIGO_TRABAJADOR']."' AND iCodOficina = '".$_SESSION['iCodOficinaLogin']."'";
                                            $rsEsProfesional  = sqlsrv_query($cnx,$sqlEsProfesional);
                                            $RsEsProfesional  = sqlsrv_fetch_array($rsEsProfesional);
                                            //if ($RsEsProfesional['iCodPerfil'] != 4) { // INICIO DE Si (NO) es PROFESIONAL
                                        ?>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Adjuntar Archivo</legend>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                        <div id="dropzone" class="dropzone"></div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset id="anexosProyecto" style="display: none">
                                <legend>Anexos de Proyecto</legend>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                        <ul></ul>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="esJefe" value="<?php echo $valor??''; ?>">
            <input type="hidden" name="codJefe" value="<?php echo $codJefe??''; ?>">
            <input type="hidden" name="nFlgEnvio" value="0">
        </form>
        <form name="frmFirmas" action="firmarDocumento.php"  method="POST">
            <input type="hidden" name="menu" value="registroOficina.php">
            <input type="hidden" name="idtra" id="idtra">
            <input type="hidden" name="urlfirm" id="urlfirm">
        </form>
</main>
<footer class="bottomInfo">
    <div class="container">
    <div class="row">
        <div class="col s12">
            <ul class="collection with-header">
                <li class="collection-header"><h6>Proyectos agregados</h6></li>
                <li id="item-1" class="collection-item">
                    <div>
                        <p><strong>Proyecto de Memorandum</strong><br>Remite informaciòn de Transparencia<br><span>OGA</span></p>
                        
                        <nav class="nav-actions">
                            <a href="#!" class="secondary-content btn btn-link danger"><i class="fas fa-trash"></i></a>
                            <a href="#!" class="secondary-content btn btn-link"><i class="fas fa-edit"></i></a>
                        </nav>
                    </div>
                </li>
                <li id="item-2" class="collection-item">
                    <div>
                        <p><strong>Proyecto de Carta</strong><br>Responde consulta a OONGD<br><span>Caritas del Perú</span></p>
                        <nav class="nav-actions">
                            <a href="#!" class="secondary-content btn btn-link danger"><i class="fas fa-trash"></i></a>
                            <a href="#!" class="secondary-content btn btn-link"><i class="fas fa-edit"></i></a>
                        </nav>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    </div>
</footer>

<div class="fixed-action-btn">
  <a class="btn-floating btn-large btn-primary">
    <i class="fas fa-plus"></i> <span>Agregar proyecto</span>
  </a>
</div>  

<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>

<script>
    $(function(){
        $(".danger").on("click", function(e) {
            e.preventDefault();
            $.confirm({
                title: 'Confirm!',
                content: 'Simple confirm!',
                buttons: {
                    confirmar: function () {
                        $.alert('Confirmed!');
                    },
                    cancelar: function () {
                        $.alert('Canceled!');
                    }
                }
            });
        });
    });
    <?php
    if($_SESSION['iCodPerfilLogin'] == 4 OR $_SESSION['iCodPerfilLogin'] == 19){
        ?>
        $('div#idProyecto').addClass('input-disabled');
        $('input[name="proyecto"]').prop('checked',true);
        $('div.row #noPro').css('display','none');
        $('div.row #siPro').css('display','block');
    <?php }
    ?>

    CKEDITOR.replace( 'editorOficina', {
        language: 'es'
    });

    CKEDITOR.config.allowedContent = true;
    CKEDITOR.config.pasteFromWordRemoveFontStyles = true;

    $('.datepicker').datepicker({
        i18n: {
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
            weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
            weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
            weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"],
            cancel: "Cancelar",
            clear: "Limpiar"
        },
        format: 'dd-mm-yyyy',
        //formatSubmit: 'dd-mm-yyyy',
        disableWeekends: true,
        autoClose: true,
        showClearBtn: true
    });

    $('#cReferencia.js-example-basic-multiple-limit').select2({
        placeholder: 'Seleccione y busque',
        maximumSelectionLength: 10,
        minimumInputLength: 3,
        "language": {
            "noResults": function(){
                return "<p>No se encontró al remitente.</p>";
            },
            "searching": function() {

                return "Buscando..";
            },
            "inputTooShort": function() {

                return "Ingrese más de 3 letras ...";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        ajax: {
            url: 'ajax/ajaxReferencias.php',
            dataType: 'json',
            delay: 100,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    function mueveReloj(){
        momentoActual = new Date();
        anho = momentoActual.getFullYear();
        mes = (momentoActual.getMonth()) + 1;
        dia = momentoActual.getDate();
        hora = momentoActual.getHours();
        minuto = momentoActual.getMinutes();
        segundo = momentoActual.getSeconds();
        if((mes>=0)&&(mes<=9)){ mes="0"+mes; }
        if((dia>=0)&&(dia<=9)){ dia="0"+dia; }
        if((hora>=0)&&(hora<=9)){ hora="0"+hora; }
        if((minuto>=0)&&(minuto<=9)){ minuto="0"+minuto; }
        if ((segundo>=0)&&(segundo<=9)){ segundo="0"+segundo; }
        horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo;
        document.frmRegistro.reloj.value=horaImprimible;
        setTimeout("mueveReloj()",1000)
    };

    function numCorre (codigoDoc, codigoOficina, numAnio){
        var parametros = {
            'cCodTipoDoc' : codigoDoc,
            'iCodOficina' : codigoOficina,
            'nNumAno'	  : numAnio
        };

        $.ajax({
            type: 'POST',
            url: 'ajaxCorrelativo.php',
            data: parametros,
            dataType: 'json',
            success: function(correlativo){
                //  alert('success');
                // alert(correlativo);
                // console.log(correlativo);
                var correlativo = correlativo;
                $.each(correlativo,function(index,value)
                {
                    $('#posibleCodificacion').val(value + " "+ '<?php echo $porAprobar; ?>');
                });
            },
            error: function(xhr){
                alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                //console.log(e);
                //alert('Error Processing your Request 6!!');
            }
        });
    }

    $('#cCodTipoDoc').on('change', function () {
        let cCodTipoDoc = document.getElementById("cCodTipoDoc").value;
        numCorre(cCodTipoDoc,<?php echo $_SESSION['iCodOficinaLogin']; ?>,<?php echo $nNumAno; ?>);
    });


    function activaOficina()
    {
        document.frmRegistro.radioMultiple.checked = false;
        document.frmRegistro.radioOficina.checked = true;
        document.frmRegistro.radioSeleccion.value="1";
        muestra('areaOficina');
        document.getElementById('areaMultiple').style.display = 'none';
        return false;
    }

    function activaMultiple()
    {
        document.frmRegistro.radioMultiple.checked = true;
        document.frmRegistro.radioOficina.checked = false;
        document.frmRegistro.radioSeleccion.value="2";
        muestra('areaMultiple');
        document.getElementById('areaOficina').style.display = 'none';
        return false;
    }

    function muestra(nombrediv) {
        if(document.getElementById(nombrediv).style.display == '') {
            document.getElementById(nombrediv).style.display = 'none';
        } else {
            document.getElementById(nombrediv).style.display = '';
        }
    }

    function AddOficina(){
        if (document.frmRegistro.iCodOficinaMov.value.length == "")
        {
            alert("Seleccione Oficina");
            document.frmRegistro.iCodOficinaMov.focus();
            return (false);
        }
        if (document.frmRegistro.iCodTrabajadorMov.value.length == "")
        {
            alert("Seleccione Trabajador");
            document.frmRegistro.iCodTrabajadorMov.focus();
            return (false);
        }
        if (document.frmRegistro.iCodIndicacionMov.value.length == "")
        {
            alert("Seleccione Indicación");
            document.frmRegistro.iCodIndicacionMov.focus();
            return (false);
        }
        document.frmRegistro.opcion.value=3;
        document.frmRegistro.action="registroData.php";
        document.frmRegistro.submit();
    }

    function Registrar(){
        var test = [];
        $("input[name='Copia[]']:checked").each(function() {
            test.push($(this).val());
        });
        if(!$('#Proyecto').is(':checked')){
            if ($("#iCodOficinaMov").val() == ""){
                alert("Seleccione Oficina");
                return false;
            }
        }

        if (document.frmRegistro.cCodTipoDoc.value.length == "")
        {
            alert("Seleccione Clase Documento");
            document.frmRegistro.cCodTipoDoc.focus();
            return false;
        }
        $("input[name='ListaDeCopias[]']").val(test);
        return true;
        //document.frmRegistro.opcion.value=2;
        //document.frmRegistro.action="registroData.php";
        //document.frmRegistro.submit();
    }

    var miPopup;
    function Buscar(){
        miPopup=window.open('registroBuscarDoc.php?buscar=Buscar','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
    }


    $(document).ready(function() {
        M.updateTextFields();

        $('.mdb-select').formSelect();

        $('#listaMovimientoTemporal').append('<tr><td colspan="6" align="center"><img src="images/cargando.gif" width="100px"></td></tr>');

        var parameters = {};
        var itemsMT = "";

        $.ajax({
            type: 'POST',
            url: 'listarMovimientoTemporal.php',
            data: parameters,
            dataType: 'json',
            success: function(s){
                $.each(s,function(index,value)
                {
                    if(value.encargado==1){
                        value.encargado="(Encargado)";
                    }else{
                        value.encargado="";
                    }

                    itemsMT += '<tr>'
                    itemsMT += '<td align="left">'+value.cNomOficina+'</td>'
                    itemsMT += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+' '+value.encargado+'</td>'
                    itemsMT += '<td align="left">'+value.cIndicacion+'</td>'
                    itemsMT += '<td align="left">'+value.cPrioridad+'</td>'
                    itemsMT += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
                    itemsMT += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><i class="fas fa-trash-alt"></i></a></td>'
                    itemsMT += '</tr>'
                });
                $("#listaMovimientoTemporal").html(itemsMT);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });

        let valor = <?=($_POST['idproyecto']??0)?>;
        if (valor !== 0){
            $.ajax({
                cache: false,
                url: "editDoc.php",
                method: "POST",
                data: {iCodMovimiento: valor, flag : 1},
                datatype: "text",
                success: function (response) {
                    if (CKEDITOR.instances.editorOficina.getData()){
                        CKEDITOR.instances.editorOficina.setData('');
                    }
                    CKEDITOR.instances.editorOficina.setData(response);
                }
            });
            $('#cCodTipoDoc').attr('onChange','');
            $.ajax({
                cache: false,
                url: "datosDocProyecto.php",
                method: "POST",
                data: {iCodMovimiento: valor, flag : 1},
                datatype: "json",
                success: function (response) {
                    let json = eval('(' + response + ')');
                    let codigoDoc = json.codigoDoc;
                    let asunto = json.asunto;
                    let observacion = json.observaciones;
                    let sigo = json.sigo;

                    numCorre(codigoDoc,<?php echo $_SESSION['iCodOficinaLogin']; ?>,<?php echo $nNumAno; ?>);
                    $('textarea[name="cAsunto"]').val(asunto).next().addClass('active');
                    //$('textarea[name="cAsunto"]').next().addClass('active');
                    $('textarea[name="cObservaciones"]').val(observacion).next().addClass('active');
                    //$('textarea[name="cAsunto"]').next().addClass('active');
                    $('select[name="cCodTipoDoc"] option[value="'+codigoDoc+'"]').prop('selected',true);
                    $('select[name="cCodTipoDoc"]').formSelect();

                    if(sigo == '1'){
                        $('input[name="flgSigo"]').prop('checked',true);
                        console.log('entra');
                    }
                    if(json.tieneAnexos == '1') {
                        $('#anexosProyecto').css('display', 'block');
                        let cont = 1;
                        console.log(json.anexos);
                        json.anexos.forEach(function (elemento) {
                            $('#anexosProyecto div.row div.col ul').append('<li><a href="http://'+elemento+'" target="_blank">Anexo-'+cont+'</a></li>');
                            cont++;
                        })
                    }
                    $('form[name="frmRegistro"]').append('<input type="hidden" name="iCodMovProyecto" value="'+valor+'">');
                }
            });
        }

    });


    function loadResponsables(value)
    {
        $("#responsable > option").remove();
        $('#responsable').append('<option value="">Cargando Datos...</option>');

        var parametros = {
            'iCodOficinaResponsable' : value
        };

        $.ajax({
            type: 'POST',
            url: 'loadResponsableRIO.php',
            data: parametros,
            dataType: 'json',
            success: function(list){
                $('#responsable').html('Cargando Datos...');

                console.log(list);
                //var opcion = "<option value=''>Seleccione un responsable</option>";
                var opcion = "";
                $.each(list,function(index,value)
                {
                    if (value.iCodCategoria == 5){
                        idtt = value.iCodTrabajador;
                    }else{
                        idtt = value.iCodTrabajador;
                    }

                    if(value.encargado==1){
                        value.encargado="(Encargado)";
                    }else{
                        value.encargado="";
                    }

                    opcion += value.cNombresTrabajador.trim() + " " +  value.cApellidosTrabajador.trim() + " " + value.encargado;
                });
                console.log(idtt,opcion);
                $('#responsablei').val(idtt);
                $('#responsable').val(opcion);

            },
            error: function(e){
                console.log(e);
                alert('Error Processing your Request 6!!');
            }
        });
    }

    function insertarMovimientoTemporal(){

        $('#listaMovimientoTemporal').append('<tr><td colspan="6" align="center"><img src="images/cargando.gif" width="100px"></td></tr>');

        var parameters = {
            iCodOficinaMov: $("#iCodOficinaMov").val(),
            iCodTrabajadorMov: $("#responsablei").val(),
            iCodIndicacionMov: $("#iCodIndicacionMov").val(),
            cPrioridad: $("#cPrioridad").val()
        };

        var items = "";

        $.ajax({
            type: 'POST',
            url: 'insertarMovimientoTemporal.php',
            data: parameters,
            dataType: 'json',
            success: function(s){
                $.each(s,function(index,value)
                {
                    if(value.encargado==1){
                        value.encargado="(Encargado)";
                    }else{
                        value.encargado="";
                    }

                    items += '<tr>'
                    items += '<td align="left">'+value.cNomOficina+'</td>'
                    items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+' '+value.encargado+'</td>'
                    items += '<td align="left">'+value.cIndicacion+'</td>'
                    items += '<td align="left">'+value.cPrioridad+'</td>'
                    items += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
                    items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><i class="fas fa-trash-alt"></i></a></td>'
                    items += '</tr>'
                });
                $("#listaMovimientoTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request 7!!');
            }
        });
        //alert('Oficina Registrada');
    }

    function eliminarMovimientoTemporal(argument){

        $('#listaMovimientoTemporal').append('<tr><td colspan="6" align="center"><img src="images/cargando.gif" width="100px"></td></tr>');

        var parameters = {iCodTemp:argument};
        var items = "";

        $.ajax({
            type: 'POST',
            url: 'eliminarMovimientoTemporal.php',
            data: parameters,
            dataType: 'json',
            success: function(s){
                $.each(s,function(index,value)
                {
                    if(value.encargado==1){
                        value.encargado="(Encargado)";
                    }else{
                        value.encargado="";
                    }

                    items += '<tr>'
                    items += '<td align="left">'+value.cNomOficina+'</td>'
                    items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+' '+value.encargado+'</td>'
                    items += '<td align="left">'+value.cIndicacion+'</td>'
                    items += '<td align="left">'+value.cPrioridad+'</td>'
                    items += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
                    items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><i class="fas fa-trash-alt"></i></a></td>'
                    items += '</tr>'
                });
                $("#listaMovimientoTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request 8!!');
            }
        });
    }

    function insertarVariasOficinasMovimientoTemporal(argument){
        var items = "";
        $.ajax({
            type: 'POST',
            url: 'insertarVariasOficinasMovimientoTemporal.php',
            data: argument,
            dataType: 'json',
            success: function(s){

                $.each(s,function(index,value) {
                    if(value.encargado==1){
                        value.encargado="(Encargado)";
                    }else{
                        value.encargado="";
                    }

                    items += '<tr>'
                    items += '<td align="left">'+value.cNomOficina+'</td>'
                    items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+' '+value.encargado+'</td>'
                    items += '<td align="left">'+value.cIndicacion+'</td>'
                    items += '<td align="left">'+value.cPrioridad+'</td>'
                    items += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
                    items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><i class="fas fa-trash-alt"></i></a></td>'
                    items += '</tr>'
                });

                $("#listaMovimientoTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request 9!!');
            }
        });
    }
</script>
<script src="includes/dropzone.js"></script>
<script>
    Dropzone.autoDiscover = false;
    $("#dropzone").dropzone({
        url: "registerDoc/registrarDocumentoOficina.php",
        paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
        autoProcessQueue: false,
        maxFiles: 10,
        acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
        addRemoveLinks: true,
        maxFilesize: 1200, // MB
        uploadMultiple: true,
        parallelUploads: 10,

        dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
        dictInvalidFileType: "Archivo no válido",
        dictMaxFilesExceeded: "Solo 10 archivos son permitidos",
        dictCancelUpload: "Cancelar",
        dictRemoveFile: "Remover",
        dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
        dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
        dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",

        init: function () {
            // First change the button to actually tell Dropzone to     process the queue.
            var myDropzone = this;
            $("#rsit").on("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                if (Registrar()){
                    queuedFiles = myDropzone.getQueuedFiles();
                    if ((queuedFiles.length > 0)) {
                        myDropzone.processQueue();
                    }else{
                        var blob = new Blob();
                        blob.upload = { 'chunked': myDropzone.defaultOptions.chunking };
                        myDropzone.uploadFile(blob);
                    }
                }
            });
            this.on('sending', function(file, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                /*CKEDITOR.instances.editorOficina.updateElement();
                //seleccionar('lstTrabajadoresSel');
                var data = $('#frmRegistro').serializeArray();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                getSpinner('generando Documento');*/
            });

            this.on('sendingmultiple', function(file, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                console.log("multiple");
                /*CKEDITOR.instances.editor.updateElement();
                var data = $('form#frmRegistro').serializeArray();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });*/

                CKEDITOR.instances.editorOficina.updateElement();
                //seleccionar('lstTrabajadoresSel');
                var data = $('#frmRegistro').serializeArray();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                getSpinner('generando Documento');
            });
            // on add file
            this.on("addedfile", function(file) {
                console.log(file);
            });
            // on error
            this.on("error", function(file, response) {
                console.log("error");
                console.log(response);
            });

            // on success
            this.on("success", function(file, response) {
                // submit form
                deleteSpinner();
                if (!$('input[name=proyecto]').is(':checked')) {
                    var json = eval('(' + response + ')');
                    console.log(response);
                    console.log("Registro Concluido");
                    console.log(json['tra']);
                    $('#idtra').val(json['tra']);
                    $('#urlfirm').val(json['url']);

                    let valor = <?=($_POST['idproyecto']??0)?>;
                    if (valor !== 0){
                        $.confirm({
                            title: '¿Enviar para visto?',
                            content: ' ',
                            buttons: {
                                Si: function () {
                                    $.ajax({
                                        cache: false,
                                        method: "POST",
                                        url: "envioVisto.php",
                                        data: {codigo: json['tra'] , codMovPro: valor},
                                        datatype: "json",
                                        success: function () {
                                            M.toast({html: '¡Se envió para visto!'});
                                            setTimeout(function(){ window.location = "registroOficina.php"; }, 2000);
                                        }
                                    });
                                },
                                No: function () {
                                    document.frmFirmas.submit();
                                }
                            }
                        });
                    }else {
                        document.frmFirmas.submit();
                    }
                }else {
                    M.toast({ html: 'Enviado Correctamente'});
                    setTimeout(function(){ window.location = "registroOficina.php"; }, 2000);
                }
            });

        }
    });

    function plantilla () {
        const codTipoDoc = $('#cCodTipoDoc').val();
        if (CKEDITOR.instances.editorOficina.getData('')) {
            CKEDITOR.instances.editorOficina.setData('');
        }
        $.ajax({
            cache: false,
            method: "POST",
            url: "ajax/parametrosPlantilla.php",
            data: {codigo: codTipoDoc},
            datatype: "json",
            success: function (response) {
                console.log(response);
                var res = eval('(' + response + ')');
                if (res.flag == 1) {
                    console.log('Tiene parametros');
                    const param = eval('(' + res.editables + ')');
                    let htmltext = '';
                    param.forEach(function (valor) {
                        htmltext +="<div class='subtitle'><h3 contenteditable='false' >"+valor+"</h3><div ><p class='clase-par'></p></div></div>"
                    });
                    CKEDITOR.instances.editorOficina.insertHtml(htmltext);
                } else {
                    console.log('No tiene parametros');
                }
            }
        });
    }

    $('#Proyecto').on('change',function (e) {
        e.preventDefault();
        if ($(this).is(':checked'))
        {
            $('#posibleCodifa').css('display','none');
            $('div.row #noPro').css('display','none');
            $('div.row #siPro').css('display','block');
        } else {
            $('#posibleCodifa').css('display','block');
            $('div.row #noPro').css('display','block');
            $('div.row #siPro').css('display','none');
        }
    });

</script>
</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>