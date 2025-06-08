<?php

session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
</head>
<body>

    <table width="440" height="300" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
        <tr>
            <td align="left" valign="top">

                <div class="AreaTitulo">
                    Seleccione Oficina:
                </div>
		        <table width="100%" border="1" cellpadding="0" cellspacing="3">
                    <form method="POST" name="formulario" action="registerDoc/registrarMovTemp.php" target="_parent">
                        <input name="opcion" value="25" type="hidden">

                        <input name="iCodMovimientoAccion" value="<?=($_GET['iCodMovimiento']??'')?>" type="hidden">

                        <input type="hidden" name="iCodOficina" value="<?=($_GET['iCodOficina']??'')?>">
                        <input name="cCodTipoDoc" value="<?=($_GET['cCodTipoDoc']??'')?>" type="hidden">
                        <input name="iCodOficinaDerivar" value="<?=($_GET['iCodOficinaDerivar']??'')?>" type="hidden">
                        <input name="iCodTrabajadorDerivar" value="<?=($_GET['iCodTrabajadorDerivar']??'')?>" type="hidden">
                        <input name="cAsuntoDerivar" value="<?=($_GET['cAsuntoDerivar']??'')?>" type="hidden">
                        <input name="cObservacionesDerivar" value="<?=($_GET['cObservacionesDerivar']??'')?>" type="hidden">
                        <input name="iCodIndicacionDerivar" value="<?=($_GET['iCodIndicacionDerivar']??'')?>" type="hidden">
                        <input name="nFlgCopias" value="<?=($_GET['nFlgCopias']??'')?>" type="hidden">
                       <?php
                       if (isset($_GET['iCodMovimientoAccion'])){
                           if ($_GET['iCodMovimientoAccion']!=""){  ?>
                            <input name="iCodMovimientoAccion2" value="<?=($_GET['iCodMovimientoAccion']??'')?>" type="hidden">
                          <?php }else{
                               if ($_GET['iCodMovimientoAccion']===" ") {
                                   $a = stripslashes($_GET['MovimientoAccion']);
                                   $MovimientoAccion = unserialize($a);
                                   if (empty($MovimientoAccion)) {
                                       $i = 0;
                                       foreach ($MovimientoAccion as $v) {
                                           ?>
                                           <input name="iCodMovimientoAccion[]" value="<?= $v ?>" type="hidden">
                                           <?php $i++;
                                       }
                                   }
                               }
                            }
                       }
                            ?>
                        <tr>
                            <td align="center"    width="360">OFICINA</td>
                            <td align="center"    width="80">OPCION</td>
                        </tr>
                        <?php
                        include_once("../conexion/conexion.php");
                        $sqlOfic="SELECT * FROM Tra_M_Oficinas WHERE iFlgEstado=1 ORDER BY cNomOficina ASC";
                        $rsOfic=sqlsrv_query($cnx,$sqlOfic);
                        while ($RsOfic=sqlsrv_fetch_array($rsOfic)){
                        $color="";
                        if ($color == "#e8f3ff"){
                                $color = "#FFFFFF";
                          }else{
                                $color = "#e8f3ff";
                          }
                          if ($color == ""){
                                $color = "#FFFFFF";
                          }
                        ?>
                        <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF';" onMouseOut="this.style.backgroundColor='<?=$color?>'">
                            <td align=left><?=utf8_encode($RsOfic['cNomOficina'])?></td>
                            <td align="center">
                                <?php
                                $sqlAct="SELECT * FROM Tra_M_Tramite_Temporal WHERE iCodOficina='".$RsOfic['iCodOficina']."' AND cCodSession='".$_SESSION['cCodSessionDrv']."'";
                                $rsAct=sqlsrv_query($cnx,$sqlAct);
                                if(sqlsrv_has_rows($rsAct)<1){
                                ?>
                                <input type="checkbox" name="lstOficinasSel[]" value="<?=$RsOfic['iCodOficina']?>">
                                <?php } else { ?>
                                <input type="checkbox" name="none" disabled>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        }
                        sqlsrv_free_stmt($rsOfic);
                        ?>
                        <tr>
                            <td>
                                <select name="iCodIndicacionSel" style="width:220px;" class="FormPropertReg form-control">
                                <option value="">Seleccione Indicación:</option>
                                <?php
                                $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                                $sqlIndic .= "ORDER BY cIndicacion ASC";
                                $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                    if($RsIndic['iCodIndicacion']==3){
                                        $selecIndi="selected";
                                    }Else{
                                        $selecIndi="";
                                    }
                                  echo utf8_encode("<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>\n");
                                }
                                sqlsrv_free_stmt($rsIndic);
                                ?>
                                </select>

                                <select name="cPrioridad" class="size9" style="background-color:#FBF9F4">
                                    <option <?php if(isset($_POST['cPrioridad'])=="Alta") echo "selected"?> value="Alta">Alta</option>
                                    <option <?php if(isset($_POST['cPrioridad'])=="Media") echo "selected"?> value="Media" selected>Media</option>
                                    <option <?php if(isset($_POST['cPrioridad'])=="Baja") echo "selected"?> value="Baja">Baja</option>
                                </select>
                            </td>
                            <td align="center">
                                <input type="submit" value="Enviar" class="btn btn-primary">
                            </td>
                        </tr>
		        </form>
		        </table>
            </td>
        </tr>
    </table>

     </div>
 </main>

</body>
</html>

<?php } else {
   header("Location: ../index-b.php?alter=5");
}
?>