<?php
date_default_timezone_set('America/Lima');
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){

	if (!isset($_SESSION["cCodSessionDrv"])){
		$fecSesDrv = date("Ymd-Gis");
		$_SESSION['cCodSessionDrv']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesDrv;
	}
	if (!isset($_SESSION["cCodRef"])){
		$fecSesRef=date("Ymd-Gis");
		$_SESSION['derDerivo']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesRef;
	}
	include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
    <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
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
                    <?php print_r($_SESSION)?>
                    <div class="card-header text-center ">Derivar Documento : <?=$RsDoc['cCodificacion']??''?> </div>
                    <!--Card content-->
                    <div class="card-body">
                        <?php
                        $sqlDoc=" SELECT Tra_M_Tramite.cCodificacion,Tra_M_Tramite_Movimientos.cFlgTipoMovimiento FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite AND iCodMovimiento='".($_GET['iCodMovimientoAccion']??'')."'";
                        $rsDoc=sqlsrv_query($cnx,$sqlDoc);
                        $RsDoc=sqlsrv_fetch_array($rsDoc);
                        ?>
                        <form name="frmConsulta" method="POST" enctype="multipart/form-data">
                            <fieldset>
                            <table>
                            <tr>
                                <input type="hidden" name="opcion" value="">
                                <input type="hidden" name="dev" value="1">
                                <input type="hidden" name="iCodMovimiento" value="<?=$_GET['iCodMovimientoAccion']??''?>">
                                <input type="hidden" name="nFlgCopias" value="<?php if($_POST['nFlgCopias']??''==1) echo "1"?>">
                                <input type="hidden" name="cFlgTipoMovimientoOrigen" value="<?=$RsDoc['cFlgTipoMovimiento']??''?>">
                                <input type="hidden" name="FechaPlazoFinal" value="<?=((isset($_POST['FechaPlazoFinal']))?$_POST['FechaPlazoFinal']:'')?>">

                                <?php
                                    if (isset($_POST['MovimientoAccion'])){
                                        for ($h = 0; $h < count($_POST['MovimientoAccion']); $h++) {
                                            $MovimientoAccion = $_POST['MovimientoAccion'];
                                            $est = "disabled";
                                            ?>
                                            <input type="hidden" name="MovimientoAccion[]"
                                                   value="<?= $MovimientoAccion[$h] ?>" size="65"
                                                   class="FormPropertReg form-control">
                                            <?php
                                        }
                                    }
                                    if (isset($_POST['iCodMovimientoAccion'])) {
                                        if ($_POST['iCodMovimientoAccion'] != "") {
                                            $est = "";
                                            ?>
                                            <input type="hidden" name="iCodMovimientoAccion"
                                                   value="<?= $_POST['iCodMovimientoAccion'] ?>" size="65"
                                                   class="FormPropertReg form-control">
                                            <?php
                                        }
                                    }
                                ?>
                                <td width="520" >Derivar a:
                                    <select name="iCodOficinaDerivar"  class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." autofocus onChange="releer();">
                                         <option value="">Seleccione:</option>
                                                <?php
                                                    $sqlOfVirtual = "SELECT iCodOficina FROM Tra_M_Oficinas";
                                                    $rsOfVirtual  = sqlsrv_query($cnx,$sqlOfVirtual);
                                                    $RsOfVirtual  = sqlsrv_fetch_array($rsOfVirtual);
                                                    $iCodOficinaVirtual = $RsOfVirtual['iCodOficina'];
                                                    $sqlDep2 = "SELECT * FROM Tra_M_Oficinas 
                                                                            WHERE iFlgEstado != 0 
                                                                                        AND iCodOficina != '".$_SESSION['iCodOficinaLogin']."'
                                                                                        AND iCodOficina != $iCodOficinaVirtual
                                                                            ORDER BY cNomOficina ASC";
                                        $rsDep2  = sqlsrv_query($cnx,$sqlDep2);
                                        while ($RsDep2 = sqlsrv_fetch_array($rsDep2)){
                                            if($RsDep2['iCodOficina'] == $_POST['iCodOficinaDerivar']){
                                                $selecOfi = "selected";
                                            }else{
                                                $selecOfi = "";
                                            }
                                            echo utf8_encode("<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".trim($RsDep2["cNomOficina"])." | ".trim($RsDep2["cSiglaOficina"])."</option>");
                                        }
                                        sqlsrv_free_stmt($rsDep2);
                                                ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td width="120" >
                                    Responsable:
                                    <select name="iCodTrabajadorDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                        <?php if($_POST['iCodOficinaDerivar']==""){?>
                                        <option value="" >Seleccione Trabajador:</option>
                                        <?php }
                                            $sqlTrb = "SELECT * FROM Tra_M_Perfil_Ususario TPU
                                                                 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
                                                                 WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '".$_POST['iCodOficinaDerivar']."'";
                                    $rsTrb  = sqlsrv_query($cnx,$sqlTrb);
                                    while ($RsTrb = sqlsrv_fetch_array($rsTrb)){
                                        if($RsTrb['iCodTrabajador']==$_POST['iCodTrabajadorDerivar']){
                                            $selecTrab="selected";
                                        }else{
                                            $selecTrab="";
                                        }
                                        if ($RsTrb["encargado"] == 1){
                                            $encar = "(Encargado)";
                                        }else{
                                            $encar = "";
                                        }
                                      echo utf8_encode("<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]." ".$encar."</option>");
                                    }
                                         sqlsrv_free_stmt($rsTrb);
                                                ?>
                                    </select>
                                </td>
                            </tr>

                            <tr >
                                <td width="520" >Indicación:</td>
                                <td align="left" class="CellFormRegOnly">
                                    <select name="iCodIndicacionDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                        <option value="">Seleccione Indicación:</option>
                                        <?php
                                        $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                                        $sqlIndic .= "ORDER BY cIndicacion ASC";
                                        $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                        while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                            if($RsIndic['iCodIndicacion']==$_POST['iCodIndicacionDerivar']){
                                                $selecIndi="selected";
                                            }Else{
                                                $selecIndi="";
                                            }
                                          echo utf8_encode("<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>");
                                        }
                                        sqlsrv_free_stmt($rsIndic);
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td >Prioridad:</td>
                                <td class="CellFormRegOnly">
                                    <select name="cPrioridad" id="cPrioridad" class="size9 FormPropertReg mdb-select colorful-select dropdown-primary"
                                            searchable="Buscar aqui..">
                                        <option <?php if(isset($_POST['cPrioridad'])=="Alta") echo "selected"?> value="Alta">Alta</option>
                                        <option <?php if(isset($_POST['cPrioridad'])=="Media") echo "selected"?> value="Media" selected>Media</option>
                                        <option <?php if(isset($_POST['cPrioridad'])=="Baja") echo "selected"?> value="Baja">Baja</option>
                                    </select>
                                </td>
                            </tr>
                            </table>
                        </fieldset>
                        <fieldset>
                        <legend class="LnkZonas"></legend>

                            <table>
                                    <tr>
                                        <td width="120" >Tipo de Documento:</td>
                                        <td align="left" class="CellFormRegOnly">
                                            <select name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." <?=$est?>  >
                                                <span style="color:#F00; size:14pt">Cambiar, para adjuntar nuevo documento </span>
                                                <?php
                                                    include_once("../conexion/conexion.php");
                                                    $sqlTipo = "SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 ORDER BY cDescTipoDoc ASC ";
                                                    $rsTipo  = sqlsrv_query($cnx,$sqlTipo);
                                                    while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
                                                        //if($RsTipo["cCodTipoDoc"] == $_POST[cCodTipoDoc] OR $RsTipo["cCodTipoDoc"] == 45){
                                                        if($RsTipo["cCodTipoDoc"] == $_POST['cCodTipoDoc']){
                                                        // if($RsTipo["cCodTipoDoc"] == $_POST[cCodTipoDoc] OR $RsTipo["cCodTipoDoc"] == 81){
                                                            $selecTipo = "selected";
                                                        }else{
                                                            $selecTipo = "";
                                                        }
                                                        echo utf8_encode("<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>");
                                                    }
                                                    sqlsrv_free_stmt($rsTipo);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td width="15%"  valign="top">Asunto:</td>
                                        <td align="left" width="30%">
                                            <textarea name="cAsuntoDerivar" style="width:100%;height:55px" class="FormPropertReg form-control"><?= $_POST['cAsuntoDerivar']??''?></textarea>
                                        </td>
                                        <td width="15%"  valign="top">Observaciones:</td>
                                        <td align="left" width="40%">
                                            <textarea name="cObservacionesDerivar" style="width:100%;height:55px" class="FormPropertReg form-control"><?= $_POST['cObservacionesDerivar']??'' ?></textarea></td>
                                    </tr>

                            </table>
                        </fieldset>
                        <?php
                        $y=0;
                        if (isset($_POST['iCodMovimientoAccion'])) {
                            if ($_POST['iCodMovimientoAccion'] != "") {
                                $rsCop = sqlsrv_query($cnx, "SELECT icodtramite,iCodOficinaDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento=" . $_POST['iCodMovimientoAccion']);
                                $RsCop = sqlsrv_fetch_array($rsCop);
                                if (isset($RsCop['icodtramite'])) {
                                        $rsTip = sqlsrv_query($cnx, "SELECT nFlgTipoDoc FROM Tra_M_Tramite WHERE icodtramite=" . $RsCop['icodtramite']);
                                        $RsTip = sqlsrv_fetch_array($rsTip);
                                        if ($RsTip['nFlgTipoDoc'] != 2) {
                                            $y = 1;
                                        }else {
                                            $x = 0;
                                            $y = 0;
                                            if (isset($_POST['MovimientoAccion'])) {
                                                for ($h = 0; $h < count($_POST['MovimientoAccion']); $h++) {
                                                    $MovimientoAccion = $_POST['MovimientoAccion'];
                                                    $rsCop = sqlsrv_query($cnx, "SELECT icodtramite,iCodOficinaDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento=" . $MovimientoAccion[$h]);
                                                    $RsCop = sqlsrv_fetch_array($rsCop);
                                                    $rsTip = sqlsrv_query($cnx, "SELECT nFlgTipoDoc FROM Tra_M_Tramite WHERE icodtramite=" . $RsCop['icodtramite']);
                                                    $RsTip = sqlsrv_fetch_array($rsTip);
                                                    if ($RsTip['nFlgTipoDoc'] != 2) {
                                                        $x++;
                                                    }
                                                }
                                            }

                                        $y = $x;
                                    }
                                }
                            }
                        }
                        ?>
                  <fieldset>
                    <legend class="LnkZonas">
                    <?php
                        if($y==0){ echo "Otros Destinos:"; }
                        else { echo "Copias a Otros Destinos:";}
                    ?>
                    </legend>
                      <table align="left">
                        <tr>
                            <td  valign="top"></td>
                            <td align="left">

                            <table border=0><tr>
                          <?php if(isset($_POST['nFlgCopias'])){
                              if (isset($_POST['MovimientoAccion'])){
                                  $compactada=serialize($_POST['MovimientoAccion']);
                                  $compactada=urlencode($compactada);
                              }

                              ?>
                          <td align="center">
                            <div  >
                                <a class="btn btn-primary"
                                     href="PendientesCopiasOficinasLs.php?iCodMovimientoAccion=<?=$_POST['iCodMovimientoAccion']??''?>&MovimientoAccion=<?=$compactada??''?>&cCodTipoDoc=<?=$_POST['cCodTipoDoc']??''?>&iCodOficinaDerivar=<?=$_POST['iCodOficinaDerivar']??''?>&iCodTrabajadorDerivar=<?=$_POST['iCodTrabajadorDerivar']??''?>&cAsuntoDerivar=<?=$_POST['cAsuntoDerivar']??''?>&cObservacionesDerivar=<?=$_POST['cObservacionesDerivar']??''?>&iCodIndicacionDerivar=<?=$_POST['iCodIndicacionDerivar']??''?>&nFlgCopias=<?=$_POST['nFlgCopias']??''?>"
                                     rel="lyteframe" title="Lista de Oficinas" rev="width: 500px; height: 550px; scrolling: auto; border:no">Seleccione Oficinas
                                </a>
                            </div>
                          </td>
                      <?php } ?>
                      <?php if(isset($_POST['nFlgCopias'])==""){?>
                      <td valign="top">
                          <div class="form-check">
                              <input type="radio" class="form-check-input" id="ad" name="radioMultiple" onclick="activaCopias();">
                              <label class="form-check-label" for="ad">Activar</label>
                          </div>
                      </td>
                        <?php } ?>
                      </tr></table>

                                <?php
                                    // selec de copias temporales
                                    $sqlMovs = "SELECT * FROM Tra_M_Tramite_Temporal 
                                                            WHERE cCodSession='".$_SESSION['cCodSessionDrv']."' ORDER BY iCodTemp ASC";
                          $rsMovs  = sqlsrv_query($cnx,$sqlMovs);
                                    if(sqlsrv_has_rows($rsMovs)>0){
                                ?>
                                <table class="table">
                                    <tr>
                                        <td class="headColumnas" width="25">De</td>
                                        <td class="headColumnas" width="375">Oficina</td>
                                        <td class="headColumnas" width="375">Responsable</td>
                                        <td class="headColumnas" width="175">Indicacion</td>
                                        <td class="headColumnas" width="60">Prioridad</td>
                                        <?php if($y==0){?>
                                        <td class="headColumnas" width="60">Copia</td>
                                        <?php } ?>
                                        <td class="headColumnas">X</td>
                                    </tr>


                                        <?php
                        while ($RsMovs = sqlsrv_fetch_array($rsMovs)){
                                        ?>
                                        <tr>
                                    <td align="center" valign="top">
                                    <?php
                                    if(isset($RsCop['iCodOficinaDerivar'])) {
                                        $sqlOfO = "SELECT cNomOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iCodOficina='" . $RsCop['iCodOficinaDerivar'] . "'";
                                        $rsOfO = sqlsrv_query($cnx, $sqlOfO);
                                        $RsOfO = sqlsrv_fetch_array($rsOfO);
                                        echo "<a style=text-decoration:none href=javascript:; title=\"" . trim($RsOfO['cNomOficina']) . "\">" . trim($RsOfO['cSiglaOficina']) . "</a>";
                                    }else{echo '-';}
                                    ?>
                                    </td>
                                        <td align="left">
                                        <?php

$sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsMovs['iCodOficina']."'";
                            $rsOfc=sqlsrv_query($cnx,$sqlOfc);
                            $RsOfc=sqlsrv_fetch_array($rsOfc);
                            echo utf8_encode($RsOfc["cNomOficina"]);
                                        ?>
                                        </td>
                          <td align="left">
                                        <?php
// $sqlTrab = "SELECT * FROM Tra_M_Trabajadores
                                            // 					  WHERE iCodTrabajador='$RsMovs[iCodTrabajador]' AND iCodCategoria=5";
                                          $sqlTrab = "SELECT * FROM Tra_M_Trabajadores 
                                                                WHERE iCodTrabajador='".$RsMovs['iCodTrabajador']."'";
                                $rsTrab = sqlsrv_query($cnx,$sqlTrab);
                                $RsTrab = sqlsrv_fetch_array($rsTrab);
                                echo utf8_encode($RsTrab["cNombresTrabajador"]." ".$RsTrab["cApellidosTrabajador"]);
                                        ?>
                            <!-- <a style=" text-decoration:none" href="PendientesCopiasRespEdit.php?cod=<?=$RsMovs[iCodTemp]?>&ofi=<?=$RsMovs['iCodOficina']?>&trab=<?=$RsMovs['iCodTrabajador']?>&iCodMovimientoAccion=<?=$_POST['iCodMovimientoAccion']?>&MovimientoAccion=<?=isset($compactada)?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&iCodOficinaDerivar=<?=$_POST['iCodOficinaDerivar']?>&iCodTrabajadorDerivar=<?=$_POST['iCodTrabajadorDerivar']?>&cAsuntoDerivar=<?=$_POST['cAsuntoDerivar']?>&cObservacionesDerivar=<?=$_POST['cObservacionesDerivar']?>&iCodIndicacionDerivar=<?=$_POST['iCodIndicacionDerivar']?>&nFlgCopias=<?=$_POST['nFlgCopias']?>" rel="lyteframe" title="Editar Responsable" rev="width: 500px; height: 550px; scrolling: auto; border:no"><img src="images/icon_edit.png" width="16" height="16" alt="Editar Responsable" border="0"></a> -->
                                        </td>
                                        <td align="left">
                                            <?php
                                                $sqlInd="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='".$RsMovs['iCodIndicacion']."'";
                                                $rsInd=sqlsrv_query($cnx,$sqlInd);
                                                $RsInd=sqlsrv_fetch_array($rsInd);
                                                echo utf8_encode($RsInd["cIndicacion"]);
                                            ?>
                                        </td>
                                        <td align="left">
                                            <?=$RsMovs['cPrioridad']?>
                                        </td>
                                            <?php if($y==0){?>
                                        <td align="left">
                                            <div class="form-check">
                                                <input type="checkbox" name="Copia[]" id="ma2" value="<?=$RsMovs['iCodTemp']?>" class="form-check-input"
                                                       onclick="activaOpciones1();" >
                                                <label class="form-check-label" for="ma2"></label>
                                            </div>
                                        </td>
                                          <?php }?>
                                        <td align="center">
                                            <a class="btn btn-primary"
                                                    href="registerDoc/regDerivar.php?iCodTemp=<?=$RsMovs['iCodTemp']??''?>&opcion=24&iCodMovimientoAccion=<?=$_POST['iCodMovimientoAccion']??''?>&MovimientoAccion=<?=$compactada??''?>&cCodTipoDoc=<?=$_POST['cCodTipoDoc']??''?>&iCodOficinaDerivar=<?=$_POST['iCodOficinaDerivar']??''?>&iCodTrabajadorDerivar=<?=$_POST['iCodTrabajadorDerivar']??''?>&cAsuntoDerivar=<?=$_POST['cAsuntoDerivar']??''?>&cObservacionesDerivar=<?=$_POST['cObservacionesDerivar']??''?>&iCodIndicacionDerivar=<?=$_POST['iCodIndicacionDerivar']??''?>&nFlgCopias=<?=$_POST['nFlgCopias']??''?>">
                                                <img src="images/icon_del.png" border="0" width="16" height="16">
                                                Eliminar
                                            </a>
                                        </td>
                                        </tr>
                                        <?php } ?>
                                        </table>
                                <?php } ?>
                        </td>
                        </tr>
                    </table>
                   </fieldset>
                   <table>
                    <tr>
                    <td colspan="2" align="right">
                    <button class="btn btn-primary" onclick="Derivar();" onMouseOver="this.style.cursor='hand'"> <b>Registrar</b> <img src="images/icon_.png" width="17" height="17" border="0"> </button>&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;
                    <button class="btn btn-primary" onclick="Volver();" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
                    </td>
                    </tr>
                   </table>
                   </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php");?>
    <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
    <script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script Language="JavaScript">
        $(document).ready(function() {
            $('.mdb-select').material_select();

        });

            function activaCopias(){
                document.frmConsulta.nFlgCopias.value="1";
                document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
                document.frmConsulta.submit();
                return false;
            }

        var miPopup
        function Buscar(){
            miPopup=window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,status=yes,resizable=0,scrollbars=yes,top=100,left=100');
        }

        function AddReferencia(){
            document.frmConsulta.opcion.value=29;
            document.frmConsulta.action="registroData.php";
            document.frmConsulta.submit();
        }

        function releer(){
            document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
            document.frmConsulta.submit();
        }

        function Derivar()
        {
            if (document.frmConsulta.cCodTipoDoc.value.length == "")
            {
                alert("Seleccione Tipo Documento");
                document.frmConsulta.cCodTipoDoc.focus();
                return (false);
            }
            if (document.frmConsulta.iCodOficinaDerivar.value.length == "")
            {
                alert("Seleccione Derivar a:");
                document.frmConsulta.iCodOficinaDerivar.focus();
                return (false);
            }
            if (document.frmConsulta.iCodTrabajadorDerivar.value.length == "")
            {
                alert("Seleccione Responsable");
                document.frmConsulta.iCodTrabajadorDerivar.focus();
                return (false);
            }
            if (document.frmConsulta.iCodIndicacionDerivar.value.length == "")
            {
                alert("Seleccione Indicación");
                document.frmConsulta.iCodIndicacionDerivar.focus();
                return (false);
            }

            document.frmConsulta.action="pendientesData.php";
            document.frmConsulta.opcion.value=2;
            document.frmConsulta.submit();
        }
        function Volver(){
            document.frmConsulta.action="registroData.php";
            document.frmConsulta.opcion.value=27;
            document.frmConsulta.submit();
        }
    </script>

<script>
    CKEDITOR.replace( 'descripcion' );
</script>

</body>
</html>

    <?php
}Else{
   header("Location: ../index-b.php?alter=5");
}
?>