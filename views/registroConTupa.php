<?php
session_start();

$pageTitle = "Registro con TUPA";
$activeItem = "registroConTupa.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){
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
        <main>
            <div class="navbar-fixed actionButtons">
                <nav>
                    <div class="nav-wrapper">
                        <ul id="nav-mobile" class="">
                            <li><a class="btn btn-primary" id="rsit" value="Registrar"><i class="fas fa-save fa-fw left"></i>Registrar</a></li>
                            <!--<li><a class="btn btn-link" href="#" href="javascript:;" onClick="Buscar();"><i class="fas fa-plus fa-fw left"></i> Agregar Referencia</a></li>-->
                            <li><a id="btnReference" class="btn btn-link modal-trigger" href="#modalReference"><i class="fas fa-plus fa-fw left"></i> Agregar Referencia</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="container">
                <form name="frmRegistro" id="frmRegistro" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="opcion" value="1">
                    <input type="hidden" name="sal" value="2">
                    <input type="hidden" name="nFlgClaseDoc" value="1">

                    <?php if(!isset($_POST['ActivarDestino'])) $_POST['ActivarDestino']=""; ?>
                    <input type="hidden" name="nFlgEnvio" value="<?php if($_POST['ActivarDestino']==1) echo "1" ?>">
                    
                    <div class="row">
                        <div class="col s12 m9">
                            <div class="card hoverable">
                                <!--<div class="card-header">
                                    <span class="card-title">Registro de entrada con tupa</span>
                                </div>-->
                                <div class="card-body">
                                        <fieldset>
                                            <legend>Datos del documento</legend>
                                            <div class="row">
                                                <div class="col m6 input-field">
                                                    <select id="cCodTipoDoc" name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary" />
                                                        <option value="">Seleccione</option>
                                                        <?php
                                                            include_once("../conexion/conexion.php");
                                                            $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgEntrada=1 ";
                                                            $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                                                            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                            
                                                            while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                                if($RsTipo["cCodTipoDoc"]==($_POST['cCodTipoDoc']??'')){
                                                                    $selecTipo="selected";
                                                                }else{
                                                                    $selecTipo="";
                                                                }
                                                                echo utf8_encode("<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>");
                                                            }

                                                            sqlsrv_free_stmt($rsTipo);
                                                        ?>
                                                    </select>
                                                    <label for="cCodTipoDoc">Tipo de Documento</label>
                                                </div>
                                                <div class="col m3 input-field">
                                                    <input placeholder="Seleccione fecha" value="<?=($_POST['fechaDocumento']??'')?>" type="text" id="fecDocumentoCT" name="fechaDocumento" class="FormPropertReg formSelect datepicker">
                                                    <label for="fecDocumentoCT">Fecha del Documento</label>
                                                </div>
                                                <div class="col m3 input-field">
                                                    <input type="text" value="&nbsp;" id="FormPropertReg" name="reloj" class="FormPropertReg disabled"  onfocus="window.document.frmRegistro.reloj.blur()">
                                                    <label class="active" for="FormPropertReg">Fecha de Registro</label>
                                                </div>
                                                <div class="col m6 input-field">
                                                    <textarea id="cAsunto" name="cAsunto"  class="materialize-textarea FormPropertReg"><?=((isset($_POST['cAsunto']))?$_POST['cAsunto']:'')?></textarea>
                                                    <label for="cAsunto">Asunto</label>
                                                </div>
                                                <div class="col m6 input-field">
                                                    <textarea id="cObservaciones" name="cObservaciones"  class="materialize-textarea FormPropertReg"><?=((isset($_POST['cObservaciones']))?$_POST['cObservaciones']:'')?></textarea>
                                                    <label for="cObservaciones">Observaciones</label>
                                                </div>
                                                <div class="col m1 input-field">
                                                    <input type="number" min="1" name="nNumFolio" value="<?php if(!isset($_POST['nNumFolio'])){echo 1;} else { echo $_POST['nNumFolio'];}?>" class="FormPropertReg" />
                                                    <label class="active">Folios</label>
                                                </div>
                                                <div class="col m5 input-field">
                                                    <select name="iCodIndicacion" class="FormPropertReg mdb-select colorful-select dropdown-primary">
                                                        <option value="">Seleccione</option>
                                                            <?php
                                                            $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                                                            $sqlIndic .= "ORDER BY cIndicacion ASC";
                                                            $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                                            if (!isset($_POST['iCodIndicacion'])) $_POST['iCodIndicacion']="";
                                                            while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                                                if($RsIndic['iCodIndicacion']==$_POST['iCodIndicacion'] OR $RsIndic['iCodIndicacion']==3){
                                                                    $selecIndi="selected";
                                                                }else{
                                                                    $selecIndi="";
                                                                }
                                                                echo utf8_encode("<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>");
                                                            }
                                                            sqlsrv_free_stmt($rsIndic);
                                                            ?>
                                                    </select>
                                                    <label>Indicaci&oacute;n</label>
                                                </div>
                                                <div class="col m6 input-field">
                                                    <input type="text" id="cNroDocumento" name="cNroDocumento" value="<?=$_POST['cNroDocumento']??''?>"  class="materialize-textarea FormPropertReg">
                                                    <label for="cNroDocumento">N° de Documento</label>
                                                </div>
                                            </div>
                                            <?php /*<div class="row">
                                                <div class="col m6 input-field">
                                                    <div class="invalid-feedback">
                                                        <?php
                                                            if (isset($_POST['cNroDocumento'])){
                                                                $sqlChek = "SELECT cNroDocumento FROM Tra_M_tramite WHERE cNroDocumento = '".$_POST['cNroDocumento']."'";
                                                                $rsChek  = sqlsrv_query($cnx,$sqlChek);
                                                                $numChek = sqlsrv_has_rows($rsChek);

                                                                if ($numChek > 0) {
                                                                    $validate = 'invalid';
                                                                    $fondo1 = "style=background-color:#FF3333;color:#000";
                                                                    $eti="<span class='helper-text' data-error='wrong' data-success='right'>El número ingresado ya existe</span>";
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                    <button name="button" type="button" class="btn btn-link prefix" onclick="releer();" ><i class="fas fa-search"></i></button>
                                                    <input type="text" name="cNroDocumento" value="<?=stripslashes($_POST['cNroDocumento']??'')?>" class="FormPropertReg validate <?=((isset($validate))?$validate:'')?>" id="cNroDocumento" />
                                                    <label for="cNroDocumento">Número de Documento</label>
                                                    <?=($eti??'')?>
                                                </div> 
                                            </div>*/?>
                                        </fieldset>
                                        <fieldset>
                                                <legend>Datos del TUPA</legend>
                                                <div class="row">
                                                    <div class="col m6 input-field">
                                                        <select name="iCodTupaClase" class="FormPropertReg mdb-select colorful-select dropdown-primary" style="width:110px" 	onChange="releer();" >
                                                            <option value="">Seleccione:</option>
                                                            <?php
                                                                $sqlClas = "SELECT * FROM Tra_M_Tupa_Clase ";
                                                                $sqlClas.="ORDER BY iCodTupaClase ASC";
                                                                $rsClas  = sqlsrv_query($cnx,$sqlClas);

                                                                while ($RsClas = sqlsrv_fetch_array($rsClas)){
                                                                    if ($RsClas['iCodTupaClase'] == ($_POST['iCodTupaClase']??'')){
                                                                        $selecClas = "selected";
                                                                    }else{
                                                                        $selecClas="";
                                                                    }
                                                                    echo "<option value=".$RsClas["iCodTupaClase"]." ".$selecClas.">".$RsClas["cNomTupaClase"]."</option>";
                                                                }
                                                                sqlsrv_free_stmt($rsClas);
                                                            ?>
                                                        </select>
                                                        <label>Clase de Procedimiento</label>
                                                    </div>
                                                    <div class="col m6 input-field">
                                                        
                                                        <select name="iCodTupa" class="FormPropertReg mdb-select colorful-select dropdown-primary" style="width:900px"
                                                            onChange="releer();" <?php if(!isset($_POST['iCodTupaClase'])) echo "disabled"?> >
                                                            <option value="">Seleccione</option>
                                                                <?php
                                                                    $sqlTupa = "SELECT * FROM Tra_M_Tupa ";
                                                                    $sqlTupa.="WHERE iCodTupaClase='".$_POST['iCodTupaClase']."'";
                                                                    $sqlTupa.="ORDER BY iCodTupa ASC";

                                                                    $rsTupa  = sqlsrv_query($cnx,$sqlTupa);
                                                                    if (!isset($_POST['iCodTupa'])) $_POST['iCodTupa']="";
                                                                    while ($RsTupa = sqlsrv_fetch_array($rsTupa)){
                                                                        if($RsTupa["iCodTupa"] == $_POST['iCodTupa']){
                                                                            $selecTupa = "selected";
                                                                        }else{
                                                                            $selecTupa = "";
                                                                        }
                                                                        echo utf8_encode("<option value=".$RsTupa["iCodTupa"]." ".$selecTupa.">".$RsTupa["cNomTupa"]."</option>");
                                                                    }
                                                                    sqlsrv_free_stmt($rsTupa);
                                                                ?>
                                                        </select>
                                                        <label>Procedimiento</label>
                                                        <?php
                                                        if(!isset($_POST['nTiempoRespuesta'])){
                                                            $sqltiempo="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$_POST['iCodTupa']."'";
                                                            $rstiempo=sqlsrv_query($cnx,$sqltiempo);
                                                            $Rstiempo=sqlsrv_fetch_array($rstiempo);
                                                            $_POST['nTiempoRespuesta']=$Rstiempo['nDias'];
                                                            sqlsrv_free_stmt($rstiempo);
                                                        } ?>
                                                        <input name="nTiempoRespuesta" type="hidden" value="<?php echo $_POST['nTiempoRespuesta']; ?>">
                                                    </div>
                                                    <div class="col m12">
                                                        <label>Requisitos</label>
                                                        <div class="invalid-feedback">
                                                            <?php
                                                                $sqlTupaReq="SELECT * FROM Tra_M_Tupa_Requisitos ";
                                                                $sqlTupaReq.="WHERE iCodTupa='".$_POST['iCodTupa']."'";
                                                                $sqlTupaReq.="ORDER BY iCodTupaRequisito ASC";
                                                                $rsTupaReq = sqlsrv_query($cnx,$sqlTupaReq);
                                                            ?>
                                                        </div>
                                                        <div>
                                                                <?php if(sqlsrv_has_rows($rsTupaReq)>0){?>
                                                                    <a href="javascript:seleccionar_todo()">Marcar todos</a> |
                                                                    <a href="javascript:deseleccionar_todo()">Desmarcar</a>
                                                                <?php } ?>
                                                            <table cellpadding="0" cellspacing="2" border="0"  class="table">
                                                                <?php
                                                                    if (sqlsrv_has_rows($rsTupaReq)>0){
                                                                        while ($RsTupaReq=sqlsrv_fetch_array($rsTupaReq)){
                                                                            $Checkear = "";
                                                                            if(isset($_POST['iCodTupaRequisito'])){
                                                                                for ($h = 0; $h < count($_POST['iCodTupaRequisito']); $h++) {
                                                                                    $iCodTupaRequisito = $_POST['iCodTupaRequisito'];
                                                                                    if ($RsTupaReq['iCodTupaRequisito'] == $iCodTupaRequisito[$h]) {
                                                                                        $Checkear = "checked";
                                                                                    }
                                                                                }
                                                                            }
                                                                            echo utf8_encode(
                                                                                    "<tr>
                                                                                                <td valign=top width=155>
                                                                                                    <label class='form-check-label' for='".$RsTupaReq["iCodTupaRequisito"]."'><input class='form-check-input' type='checkbox' name='iCodTupaRequisito[]' value='".$RsTupaReq["iCodTupaRequisito"]."' id='".$RsTupaReq["iCodTupaRequisito"]."' ".$Checkear."><span>".$RsTupaReq["cNomTupaRequisito"]."</span></label>
                                                                                                </td>
                                                                                            </tr>");
                                                                        }
                                                                        /*<div class="form-check">
                                                                        <input type="checkbox" name="ActivarDestino" value="1" class="form-check-input" id="derivarCT">
                                                                            <label class="form-check-label" for="derivarCT">Derivar inmediatamente:</label>                                                              </div>*/
                                                                    }else{
                                                                        echo "&nbsp;";
                                                                    }
                                                                    sqlsrv_free_stmt($rsTupaReq);
                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                               
                                                </div>
                                            </fieldset>
                                        <fieldset>
                                            <legend>Datos del remitente</legend>
                                            <div class="row">
                                                <div class="col l6 input-field ">
                                                    <input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg" value="<?php if(isset($_POST['cNombreRemitente'])) echo $_POST['cNombreRemitente']?>"  readonly>
                                                    <label for="cNombreRemitente" class="active">Remitente / Instituci&oacute;n:</label>
                                                    <button style="right:3rem" class="input-field__icon btn btn-link" type="button" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');"><i class="fas fa-fw fa-search"></i></button>
                                                    <button class="input-field__icon btn btn-link" type="button" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');"><i class="fas fa-fw fa-plus"></i></button>
                                                    <input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?php if(isset($_POST['iCodRemitente'])) echo $_POST['iCodRemitente']?>">
                                                    <input id="Remitente" name="Remitente" type="hidden" value="<?php if(isset($_POST['iCodRemitente'])) echo $_POST['iCodRemitente']?>">
                                                </div>
                                                <div class="col m6 input-field">
                                                    <input id="cNomRemite" type="text" name="cNomRemite" style="text-transform:uppercase" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg" style="text-transform:uppercase" /><span class="FormCellRequisito"></span>
                                                    <label for="cNomRemite">Responsable</label>
                                                </div>                           
                                            </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Datos del destinatario</legend>
                                                
                                                <div class="row">
                                                    <div class="invalid-feedback">
                                                            <?php
                                                                $sqlTupDat = "SELECT * FROM Tra_M_Tupa ";
                                                                $sqlTupDat.="WHERE iCodTupa='".$_POST['iCodTupa']."'";
                                                                $rsTupDat  = sqlsrv_query($cnx,$sqlTupDat);
                                                                //echo $sqlTupDat;
                                                                $RsTupDat  = sqlsrv_fetch_array($rsTupDat);
                                                            ?>
                                                    </div>
                                                    <div class="col m6 input-field">
                                                        <select name="iCodOficinaResponsable" class="disabled js-example-basic-single mdb-select colorful-select dropdown-primary" onChange="releer();" <?php //if($RsTupDat['iCodOficina'] != ""){echo "disabled"}?>>
                                                                <!--<option value="">Seleccione:</option>-->
                                                                <?php
                                                                    $ofi = $RsTupDat['iCodOficina'];
                                                                    //$sqlOfVirtual = "SELECT iCodOficina FROM Tra_M_Oficinas WHERE cNomOficina LIKE '%VIRTUAL%'";
                                                                    //$rsOfVirtual  = sqlsrv_query($cnx,$sqlOfVirtual);
                                                                    //$RsOfVirtual  = sqlsrv_fetch_array($rsOfVirtual);
                                                                    //$iCodOficinaVirtual = $RsOfVirtual['iCodOficina'];
                                                                    $sqlDep2 = "SELECT * FROM Tra_M_Oficinas WHERE iFlgEstado != 0 AND iCodOficina='".$RsTupDat['iCodOficina']."' ORDER BY cNomOficina ASC";
                                                                    $rsDep2  = sqlsrv_query($cnx,$sqlDep2);
                                                                    while ($RsDep2 = sqlsrv_fetch_array($rsDep2)){
                                                                        if ($RsDep2['iCodOficina'] == $ofi) {
                                                                            echo utf8_encode("<option value='" . $RsDep2['iCodOficina'] . "' selected > " . trim($RsDep2['cNomOficina']) . " | " . trim($RsDep2["cSiglaOficina"]) . "</option>");
                                                                        }
                                                                    }
                                                                    sqlsrv_free_stmt($rsDep2);
                                                                ?>
                                                        </select>
                                                        <label>Oficina</label>
                                                    </div>
                                                    <div class="col m6 input-field">
                                                        <select name="iCodTrabajadorResponsable" class="disabled FormPropertReg combobox mdb-select colorful-select 	dropdown-primary"  <?php //if($RsTupDat['iCodOficina']=="") echo "disabled"?>>
                                                            <?php
                                                                //  Consulta anterior
                                                                // $sqlTrb = "SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$ofi' AND (iCodPerfil=3 OR iCodPerfil=5 )
                                                                // 					 ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
                                                                // $sqlTrb = "SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$ofi' AND iCodCategoria = 5
                                                                // 					 ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";

                                                                $sqlTrb = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador = (
                                                                        SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario 
                                                                        WHERE iCodOficina = '".$ofi."' AND iCodPerfil = 3)";
                                                                $rsTrb  = sqlsrv_query($cnx,$sqlTrb);
                                                                $RsTrb = sqlsrv_fetch_array($rsTrb);
                                                                //while ($RsTrb = sqlsrv_fetch_array($rsTrb)){
                                                                //        if ($RsTrb['iCodTrabajador'] == $_POST['iCodTrabajadorResponsable']){
                                                                //                $selecTrab = "selected";
                                                                //        }else{
                                                                //                $selecTrab = "";
                                                                //        }
                                                                echo utf8_encode("<option selected='selected' value='".$RsTrb["iCodTrabajador"]."' >".rtrim($RsTrb["cNombresTrabajador"])." ".rtrim($RsTrb["cApellidosTrabajador"])."</option>");
                                                                //}
                                                                //sqlsrv_free_stmt($rsTrb);
                                                            ?>
                                                        </select>
                                                        <label>Responsable</label>
                                                    </div>
                                                    <div class="col m6">
                                                        <div class="form-check">
                                                            <label class="form-check-label" for="derivarCT">
                                                                <input type="checkbox" name="ActivarDestino" value="1" class="form-check-input" id="derivarCT">
                                                                <span>Derivar inmediatamente</span>
                                                            </label>
                                                        </div>
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

                                                <ul class="collection">
                                                <?php
                                                    $sqlRefs = "SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='".($_SESSION['cCodRef']??'')."'";
                                                    $rsRefs  = sqlsrv_query($cnx,$sqlRefs);
                                                    //var_dump(sqlsrv_fetch_array($rsRefs));
                                                    
                                                    while ($RsRefs = sqlsrv_fetch_array($rsRefs)){
                                                        ?>
                                                        <li class="collection-item">
                                                            <div><?=$RsRefs['cReferencia']?>
                                                                <a class="secondary-content" href="registroData.php?iCodReferencia=<?=($RsRefs['iCodReferencia']??'')?>&opcion=19&iCodTramite=<?=$_GET['iCodTramite']??''?>&sal=2&URI=<?=$_GET['URI']??''?>&radioSeleccion=<?=$_POST['radioSeleccion']??''?>&cNombreRemitente=<?=$_POST['cNombreRemitente']??''?>&iCodTrabajadorResponsable=<?=$_POST['iCodTrabajadorResponsable']??''?>&iCodOficinaResponsable=<?=$_POST['iCodOficinaResponsable']??''?>&cNroDocumento=<?=$_POST['cNroDocumento']??''?>&cNomRemite=<?=$_POST['cNomRemite']??''?>&ActivarDestino=<?=$_POST['ActivarDestino']??''?>&iCodRemitente=<?=$_POST['iCodRemitente']??''?>&Remitente=<?=$_POST['Remitente']??''?>&cCodTipoDoc=<?=$_POST['cCodTipoDoc']??''?>&cAsunto=<?=$_POST['cAsunto']??''?>&iCodTupaClase=<?=$_POST['iCodTupaClase']??''?>&iCodTupa=<?=$_POST['iCodTupa']??''?>&cObservaciones=<?=$_POST['cObservaciones']??''?>&nNumFolio=<?=$_POST['nNumFolio']??''?>&nFlgEnvio=<?=$_POST['nFlgEnvio']??''?>&cSiglaAutor=<?=$_POST['cSiglaAutor']??''?>&archivoFisico=<?=$_POST['archivoFisico']??''?>&fechaDocumento=<?=$_POST['fechaDocumento']??''?>">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <?php
                                                        //$array1[]=$RsRefs['cReferencia'];
                                                        //$array2[]=$RsRefs['iCodTramiteRef'];
                                                    }
                                                ?>
                                                </ul>

                                                <input type="hidden" readonly="readonly" name="cReferencia" value="<?=($_POST['cReferencia']??'')?>" class="FormPropertReg" style="width:140px;text-transform:uppercase" >
                                                <input type="hidden" name="iCodTramiteRef" value="<?=($_POST['iCodTramiteRef']??'')?>"  >
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>Archivo</legend>
                                        <div class="row">
                                            <div class="file-field input-field col s12">
                                                <?php
                                                if (empty($_FILES['fileUpLoadDigital']['name'] )) {
                                                    $fileUploadDigital = $_FILES['fileUpLoadDigital']['name'] ?? '';
                                                    if ($fileUploadDigital != null) {
                                                        $_SESSION['ArchivoPDF'] = $_FILES['fileUpLoadDigital']['tmp_name'] . "/" . $_FILES['fileUpLoadDigital']['name'];
                                                        echo $_FILES['fileUpLoadDigital']['name'];
                                                    }
                                                }
                                                ?>

                                                <div id="dropzone" class="dropzone" style="width:100%"></div>
                                            </div>
                                        </div>

                                        <!--<div class="row">
                                            <div class="file-field input-field col s12">
                                                <div class="btn btn-secondary">
                                                    <span><i class="fas fa-paperclip"></i></span>
                                                    <input type="file" name="fileUpLoadDigital" class="FormPropertReg" />
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text">
                                                </div>
                                            </div>
                                        </div>-->
                                        
                                        <div class="row">
                                            <div class="col m12 input-field">
                                                <textarea name="archivoFisico" id="archivoFisico" class="FormPropertReg materialize-textarea"><?php //echo trim($_POST['archivoFisico']??''); ?></textarea>
                                                <label for="archivoFisico">Archivo F&iacute;sico</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        
        <div id="modalReference" class="modal modal-fixed-footer modal-fixed-header">
            <div class="modal-header">
                <h4>Agregar referencia</h4>
            </div>
            <div class="modal-content"></div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>

        <div id="modalConcluido" class="modal modal-fixed-footer modal-fixed-header">
            <div class="modal-header">
                <h4>Registro concluido</h4>
            </div>
            <div class="modal-content"></div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>

        <?php include("includes/userinfo.php"); ?>
        <?php include("includes/pie.php"); ?>

    <script>
        function activaDestino()
        {
            if (document.frmRegistro.nFlgEnvio.value==1){
                document.frmRegistro.nFlgEnvio.value="";
            } else {
                document.frmRegistro.nFlgEnvio.value=1;
            }
            return false;
        }

        function mueveReloj()
        {
            momentoActual = new Date()
            anho = momentoActual.getFullYear()
            mes = (momentoActual.getMonth())+1
            dia = momentoActual.getDate()
            hora = momentoActual.getHours()
            minuto = momentoActual.getMinutes()
            segundo = momentoActual.getSeconds()
            if((mes>=0)&&(mes<=9)){ mes="0"+mes; }
            if((dia>=0)&&(dia<=9)){ dia="0"+dia; }
            if((hora>=0)&&(hora<=9)){ hora="0"+hora; }
            if((minuto>=0)&&(minuto<=9)){ minuto="0"+minuto; }
            if ((segundo>=0)&&(segundo<=9)){ segundo="0"+segundo; }
            horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo
            document.frmRegistro.reloj.value=horaImprimible
            setTimeout("mueveReloj()",1000)
        }

        function activaDerivar()
        {
            document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
            document.frmRegistro.submit();
            return false;
        }

        function releer()
        {
            document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
            document.frmRegistro.submit();
        }

        function seleccionar_todo()
        {
            for (i=0;i<document.frmRegistro.elements.length;i++)
                if(document.frmRegistro.elements[i].type == "checkbox")
                    document.frmRegistro.elements[i].checked=1
        }

        function deseleccionar_todo()
        {
            for (i=0;i<document.frmRegistro.elements.length;i++)
                if(document.frmRegistro.elements[i].type == "checkbox")
                    document.frmRegistro.elements[i].checked=0
        }

        var miPopup;

        function Buscar()
        {
            miPopup = window.open('registroBuscarDocEnt.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
        }


        function Registrar()
        {
            if (document.frmRegistro.nFlgEnvio.value=="") {
                if (document.frmRegistro.cCodTipoDoc.value.length == "") {
                    alert("Seleccione Tipo de Documento");
                    document.frmRegistro.cCodTipoDoc.focus();
                    return (false);
                }

                if (document.frmRegistro.cNroDocumento.value.length == "") {
                    alert("Ingrese Número del Documento");
                    document.frmRegistro.cNroDocumento.focus();
                    return (false);
                }

                if (document.frmRegistro.iCodRemitente.value.length == "") {
                    alert("Seleccione Remitente");
                    return (false);
                }

                if (document.frmRegistro.iCodTupaClase.value.length == "") {
                    alert("Seleccione una Clase de Procedimiento TUPA");
                    return (false);
                }

                if (document.frmRegistro.iCodTupa.value.length == "") {
                    alert("Seleccione un Procedimiento TUPA");
                    return (false);
                }

                //  if (document.frmRegistro.nFlgEnvio.value==1)
                if (document.frmRegistro.nFlgEnvio.value=="") {
                    if (document.frmRegistro.iCodOficinaResponsable.value.length == "") {
                        document.frmRegistro.nFlgEnvio.value=1;
                    }
                }
                return (true);
                /*document.frmRegistro.action="registroData.php";
                document.frmRegistro.submit();*/

            } else if(document.frmRegistro.nFlgEnvio.value==1) {

                if (document.frmRegistro.cCodTipoDoc.value.length == "") {
                    alert("Seleccione Tipo de Documento");
                    document.frmRegistro.cCodTipoDoc.focus();
                    return (false);
                }

                if (document.frmRegistro.cNroDocumento.value.length == "") {
                    alert("Ingrese Número del Documento");
                    document.frmRegistro.cNroDocumento.focus();
                    return (false);
                }

                if (document.frmRegistro.iCodRemitente.value.length == "") {
                    alert("Seleccione Remitente");
                    return (false);
                }

                if (document.frmRegistro.iCodTupaClase.value.length == "") {
                    alert("Seleccione una Clase de Procedimiento TUPA");
                    return (false);
                }

                if (document.frmRegistro.iCodTupa.value.length == "") {
                    alert("Seleccione un Procedimiento TUPA");
                    return (false);
                }

                // if (document.frmRegistro.nFlgEnvio.value==1)
                if (document.frmRegistro.nFlgEnvio.value=="1") {
                    if (document.frmRegistro.iCodOficinaResponsable.value.length == "") {
                        alert("Para enviar seleccione Oficina");
                        return (false);
                    }

                    if (document.frmRegistro.iCodTrabajadorResponsable.value.length == "") {
                        alert("Para enviar seleccione Responsable");
                        return (false);
                    }
                }
                return (true);

                /*document.frmRegistro.action="registroData.php";
                document.frmRegistro.submit();*/
            }
        }

        function go()
        {
            w = new ActiveXObject("WScript.Shell");
            //w.run("c:\\envioSMS.jar", 1, true);
            w.run("G:\\refirma\\1.1.0\\ReFirma-1.1.0.jar", 1, true);//G:\refirma\1.1.0\ReFirma-1.1.0.jar
            return true;
        }

    </script>
    <script src="includes/dropzone.js"></script>
    <script>
        $(document).ready(function() {
            //$('.modal').modal();
            $('.mdb-select').formSelect();

            $("#btnReference").on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    cache: false,
                    url: "registroBuscarDocEnt.php",
                    method: "POST",
                    //data: {},
                    datatype: "json",
                    success : function(response) {
                        //console.log(response);
                        $('#modalReference div.modal-content').html(response);
                    }
                });
            });
        });

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

        Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
            url: "registerDoc/regDocCT.php",
            paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
            autoProcessQueue: false,
            maxFiles: 2,
            acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
            addRemoveLinks: true,
            maxFilesize: 1200, // MB
            uploadMultiple: true,
            parallelUploads: 2,

            dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
            dictInvalidFileType: "Archivo no válido",
            dictMaxFilesExceeded: "Solo 2 archivos son permitidos",
            dictCancelUpload: "Cancelar",
            dictRemoveFile: "Remover",
            dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
            dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
            dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",

            init: function () {
                // First change the button to actually tell Dropzone to process the queue.
                var myDropzone = this;

                $("#rsit").on("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    flag = Registrar();
                    if (flag){
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
                    var data = $('form').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                });

                this.on('sendingmultiple', function(file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    console.log("multiple");
                    var data = $('form').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                });
                // on add file
                this.on("addedfile", function(file) {
                    console.log(file);
                });
                // on error
                this.on("error", function(file, response) {
                    console.log(response);
                });

                // on success
                this.on("success", function(file, response) {
                    // submit form
                    console.log("correcto");
                    let elems = document.querySelector('#modalConcluido');
                    let instance = M.Modal.getInstance(elems);
                    $('#modalConcluido div.modal-content').html(response);
                    //$("form")[0].reset();
                    instance.open();
                });

            }

        })
    </script>
    </body>
    </html>
<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>	