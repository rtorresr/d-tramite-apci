<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv=Content-Type content=text/html; charset=utf-8>
    <title>SITDD</title>
    <link type="text/css" rel="stylesheet" href="css/detalle.css" media="screen" />
    <script language="javascript" type="text/javascript">
        function muestra(nombrediv) {
            if(document.getElementById(nombrediv).style.display == '') {
                    document.getElementById(nombrediv).style.display = 'none';
            } else {
                    document.getElementById(nombrediv).style.display = '';
            }
        }
    </script>
</head>
<body>
		<?php
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$_GET['iCodTupa']."'");
		$Rs=sqlsrv_fetch_array($rs);
		?>

    <!--Main layout-->
    <main>
        <div class="AreaTitulo">Documento Tupa: <?=utf8_encode($Rs['cNomTupa'])?></div>
        <table cellpadding="0" cellspacing="0" border="0" width="800">
            <tr>
                <td width="800" class="FondoFormRegistro">
                    <table width="800" border="0" align="center">
                        <tr>
                            <td>
                                <fieldset id="tfa_GeneralEmp" class="fieldset">
                                    <legend class="legend"><a href="javascript:;" onClick="muestra('zonaFlujo')" class="LnkZonas">Flujo de Trabajo Programado<img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
                                    <table border="0" width="800">
                                        <tr>
                                                <td align="left">
                                                    <?php
                                                    $sqlF="SELECT * FROM Tra_M_Mov_Flujo WHERE iCodTupa='".$_GET['iCodTupa']."' ORDER BY iNumOrden ASC";
                                                    $rsF=sqlsrv_query($cnx,$sqlF);
                                                    $contador=0;
                                                    while ($RsF=sqlsrv_fetch_array($rsF)){
                                                        $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsF['iCodOficina']."'";
                                                        $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
                                                        $RsOfiO=sqlsrv_fetch_array($rsOfiO);
                                                        $contador++;
                                                    ?>
                                                    <style type="text/css">
                                                #area<?=$RsF['iCodMovFlujo']?>{
                                                    position: absolute;
                                                    display:none;
                                                    font-family:Arial;
                                                    font-size:0.8em;
                                                    border:1px solid #808080;
                                                    background-color:#f1f1f1;
                                                }
                                                </style>
                                                    <script type="text/javascript">
                                                <!--
                                                function showdiv<?=$RsF['iCodMovFlujo']?>(event){
                                                    margin=8;
                                                    var IE = document.all?true:false;
                                                    if (!IE) document.captureEvents(Event.MOUSEMOVE)

                                                    if(IE){
                                                        tempX = event.clientX + document.body.scrollLeft;
                                                        tempY = event.clientY + document.body.scrollTop;
                                                    }else{
                                                        tempX = event.pageX;
                                                        tempY = event.pageY;
                                                    }
                                                    if (tempX < 0){tempX = 0;}
                                                    if (tempY < 0){tempY = 0;}

                                                    document.getElementById('area<?=$RsF['iCodMovFlujo']?>').style.top = (tempY+margin);
                                                    document.getElementById('area<?=$RsF['iCodMovFlujo']?>').style.left = (tempX+margin);
                                                    document.getElementById('area<?=$RsF['iCodMovFlujo']?>').style.display='block';
                                                }
                                                -->
                                                </script>
                                                    <button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF['iCodMovFlujo']?>(event);" onmousemove="showdiv<?=$RsF['iCodMovFlujo']?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF['iCodMovFlujo']?>').style.display='none';"></button>
                                                </td>
                                                <td height="35" align="center">
                                                    <div class="FlujoSquareTupa" style="padding-top:10px">
                                                        <span style="font-size:14px"><?=$RsOfiO['cSiglaOficina']?></span>
                                                    </div>
                                                </td>
                                                <?php if($contador!=sqlsrv_num_rows($rsF)){?>
                                                <td ><img src="images/icon_rig  ht.png" width="25" height="25" border="0"></td>
                                                <?php }?>
                                         </tr>
                                    </table>
                                    <div id="area<?=$RsF['iCodMovFlujo']?>" align="left">
                                                    <div align=center><?=$RsOfiO['cNomOficina']?></div>
                                                    Actividad:
                                                         <?php
                                                                   echo "<span style=color:#6F3700>".$RsF['cActividad']."</span>";
                                                         ?>
                                                    <br>
                                                    Dias:
                                                          <?php
                                                                    echo "<span style=color:#6F3700>".$RsF['nPlazo']."</span>";
                                                          ?>
                                                    <br>
                                                    Detalle:
                                                          <?php
                                                                    echo "<span style=color:#6F6F6F>".$RsF['cDesMovFlujo']."</span>";
                                                          ?>
                                                </div>
                                    <?php
                                        /*
                                        $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsF['iCodOficina']'";
                                        $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
                                        $RsOfiD=sqlsrv_fetch_array($rsOfiD);
                                        $contador++;
                                   ?>
                                        <style type="text/css">
                                                #area<?=$RsF[iCodMovFlujo]?>{
                                                    position: absolute;
                                                    display:none;
                                                    font-family:Arial;
                                                    font-size:0.8em;
                                                    border:1px solid #808080;
                                                    background-color:#f1f1f1;
                                                }
                                                </style>
                                                <script type="text/javascript">
                                                <!--
                                                function showdiv<?=$RsF[iCodMovFlujo]?>(event){
                                                    margin=8;
                                                    var IE = document.all?true:false;
                                                    if (!IE) document.captureEvents(Event.MOUSEMOVE)

                                                    if(IE){
                                                        tempX = event.clientX + document.body.scrollLeft;
                                                        tempY = event.clientY + document.body.scrollTop;
                                                    }else{
                                                        tempX = event.pageX;
                                                        tempY = event.pageY;
                                                    }
                                                    if (tempX < 0){tempX = 0;}
                                                    if (tempY < 0){tempY = 0;}

                                                    document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.top = (tempY+margin);
                                                    document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.left = (tempX+margin);
                                                    document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.display='block';
                                                }
                                                -->
                                                </script>
                                            <button class="FlujoSquareEmpty" onMouseOver="this.style.cursor='hand';showdiv<?=$RsF[iCodMovFlujo]?>(event);" onmousemove="showdiv<?=$RsF[iCodMovFlujo]?>(event);" onmouseout="javascript:document.getElementById('area<?=$RsF[iCodMovFlujo]?>').style.display='none';">

                                                <td height="35" valign="center">
                                                    <div class="<?php if($RsF[cFlgTipoMovimiento]==1) echo "FlujoSquareData"?><?php if($RsF[cFlgTipoMovimiento]==3) echo "FlujoSquareAnexo"?>" style="padding-top:10px">
                                                    <span style="font-size:16px;"><?=$RsOfiD[cSiglaOficina]?></span><br>
                                                    </div>
                                                </td>
                                                <?php if($contador!=sqlsrv_has_rows($rsF)){?>
                                                <td><img src="images/icon_right.png" width="25" height="25" border="0"></td>
                                                <?php}?>
                                                </tr></table>
                                        </button>
                                                <div id="area<?=$RsF[iCodMovFlujo]?>" align="left">
                                                    <div align=center><?=$RsOfiD[cNomOficina]?></div>
                                                    Creado: <?
                                                                    echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecMovimiento]))."</span>";
                                                            echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecMovimiento]))."</span>";
                                                                    ?>
                                                    <br>
                                                    Aceptado:
                                                                    <?
                                                                    if($RsF[fFecRecepcion]==""){
                                                                    echo "<span style=color:#6F6F6F>sin aceptar</span>";
                                                            }Else{
                                                                    echo "<span style=color:#6F3700>".date("d-m-Y", strtotime($RsF[fFecRecepcion]))."</span>";
                                                                    echo " <span style=color:#6F3700;font-size:8px>".date("h:iA", strtotime($RsF[fFecRecepcion]))."</span>";
                                                            }
                                                                    ?>
                                                    <br>
                                                    Delegado:
                                                                    <?
                                                                    if($RsF['iCodTrabajadorDelegado']!=""){
                                                                $rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsF['iCodTrabajadorDelegado']."'");
                                                        $RsDelg=sqlsrv_fetch_array($rsDelg);
                                                        echo "<span style=color:#6F3700>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</span>";
                                                                    sqlsrv_free_stmt($rsDelg);
                                                                    }
                                                                    ?>
                                                </div>
                                    <? */
                                            //saltos linea:
                                            if($contador==7) echo " <img src=images/lineFlujo.png width=800 height=31> ";
                                            if($contador==14) echo " <img src=images/lineFlujo.png width=800 height=31> ";
                                                    }
                                    ?>

                                </fieldset>
                            </td>
                        </tr>
                    </table>
                    <img src="images/space.gif" width="0" height="0">
                </td>
            </tr>
           </table>
     </main>

<div>		
</body>
</html>

<?php } else {
   header("Location: ../index-b.php?alter=5");
}
?>
