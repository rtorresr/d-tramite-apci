<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>


                                        <?php
                                            include_once("../conexion/conexion.php");
                                            $sqlOfic="SELECT * FROM Tra_M_Oficinas  WHERE iFlgEstado=1";
                                            $sqlOfic.=" ORDER BY cNomOficina ASC";
                                            $rsOfic=sqlsrv_query($cnx,$sqlOfic);
                                        ?>
                                <form method="POST" name="formulario"  target="_parent">
                                    <table width="100%" border="1" cellpadding="0" cellspacing="3">
                                    <tr>
                                        <td align="center"    width="360">OFICINA</td>
                                        <td align="center"    width="80">OPCION</td>
                                    </tr>
                                    <?php
                                        while ($RsOfic=sqlsrv_fetch_array($rsOfic)){
                                            if ($color??'' == "#e8f3ff"){
                                                $color = "#FFFFFF";
                                            } else {
                                                $color = "#e8f3ff";
                                            }
                                    ?>
                                            <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF';" onMouseOut="this.style.backgroundColor='<?=$color?>'">
                                                <td align=left><?=$RsOfic['cNomOficina']??''?></td>
                                                <td align="center">
                                                    <?php
                                                    $sqlAct="SELECT * FROM Tra_M_Tramite_Temporal WHERE iCodOficina='".$RsOfic['iCodOficina']."' AND cCodSession='".$_SESSION['cCodOfi']."'";
                                                    $rsAct=sqlsrv_query($cnx,$sqlAct);
                                                    if(!sqlsrv_has_rows($rsAct)){
                                                    ?>
                                                        <label>
                                                            <input type="checkbox" name="lstOficinasSel[]" value="<?php echo $RsOfic['iCodOficina'];?>">
                                                            <span></span>
                                                        </label>
                                                        
                                                    <?php } else { ?>
                                                        <label>
                                                            <input type="checkbox" name="none" disabled>
                                                            <span></span>
                                                        </label>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                     <?php
                                        }
                                        sqlsrv_free_stmt($rsOfic);
                                     ?>
                                    <tr>
                                        <td>
                                            <select name="iCodIndicacion" id="iCodIndicacion" style="width:220px;display: block" class="FormPropertReg form-control">
                                                <option value="">Seleccione Indicación:</option>
                                                <?php
                                                $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                                                $sqlIndic.= "ORDER BY cIndicacion ASC";
                                                echo $sqlIndic;
                                                $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                                while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                                    if($RsIndic['iCodIndicacion']==3){
                                                        $selecIndi="selected";
                                                    }else{
                                                        $selecIndi="";
                                                    }
                                                    echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>\n";
                                                }
                                                sqlsrv_free_stmt($rsIndic);
                                                ?>
                                            </select>
                                            <select name="cPrioridad" id="cPrioridad" class="size9" style="width:100px;background-color:#FBF9F4;display: block">
                                                <option <?php if($_POST['cPrioridad']??''=="Alta"){ echo "selected";} ?> value="Alta">Alta</option>
                                                <option <?php if($_POST['cPrioridad']??''=="Media"){ echo "selected";} ?> value="Media" selected>Media</option>
                                                <option <?php if($_POST['cPrioridad']??''=="Baja"){ echo "selected";} ?> value="Baja">Baja</option>
                                            </select>
                                        </td>
                                        <td align="center">
                                            <input type="button" value="Enviar" class="btn btn-primary" onclick="enviarVariasOficinasMovimientoTemporal()">
                                        </td>
                                    </tr>
                            </table>
                                </form>
<script language="JavaScript">
        function enviarVariasOficinasMovimientoTemporal() {

            var parameters = {
                iCodIndicacion: $("#iCodIndicacion").val(),
                cPrioridad: $("#cPrioridad").val(),
                'lstOficinasSel[]' : []
            };
            $("input[name='lstOficinasSel[]']:checked").each(function() {
               parameters['lstOficinasSel[]'].push($(this).val());
            });

            window.opener.insertarVariasOficinasMovimientoTemporal.php
            window.opener.onload=parameters;
            window.opener.focus() ;
            window.close();
        }
</script>

<?php
} else {
   header("Location: ../index-b.php?alter=5");
}
?>