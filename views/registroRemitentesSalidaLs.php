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
        <?php include('includes/head.php');?>
    </head>
    <body>
    <div class="card-body">
        <div class="AreaTitulo">Seleccione Remitente: </div>
        <table width="100%" border="1" cellpadding="0" cellspacing="3">
            <tr>
                <td align="center"    width="560">NOMBRE REMITENTE &nbsp;&nbsp;/&nbsp;&nbsp; N&ordm; DOCUMENTO</td>
                <td align="center"    width="70">OPCION</td>
            </tr>
            <?php
            include_once("../conexion/conexion.php");
            $sqlRem="SELECT * FROM Tra_M_Remitente ";


            $sqlRem.="ORDER BY cNombre ASC";
            $rsRem=sqlsrv_query($cnx,$sqlRem);
            while ($RsRem=sqlsrv_fetch_array($rsRem)){
                if ($color??'' == "#e8f3ff"){
                    $color = "#FFFFFF";
                }else{
                    $color = "#e8f3ff";
                }
                if ($color == ""){
                    $color = "#FFFFFF";
                }
                ?>
                <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF';" onMouseOut="this.style.backgroundColor='<?=$color?>'">
                    <td width="560" style="font-family:'Arial Narrow';font-size:11px"><?php echo $RsRem["cNombre"]?> <?php if($RsRem["nNumDocumento"]!="") echo "- <b color=#A96705>".trim($RsRem["nNumDocumento"])."</b>"?></td>
                    <form name="selectform">
                        <td width="70">
                            <input name="cNombreRemitente" value="<?=trim($RsRem["cNombre"])?>" type="hidden">
                            <input name="iCodRemitente" value="<?=trim($RsRem['iCodRemitente'])?>" type="hidden">
                            <input name="txtdirec_remitente" value="<?=utf8_encode(trim($RsRem['cDireccion']))?>" type="hidden">
                            <input name="cCodDepartamento" value="<?=trim($RsRem['cDepartamento'])?>" type="hidden">
                            <input name="cCodProvincia" value="<?=trim($RsRem['cProvincia'])?>" type="hidden">
                            <input name="cCodDistrito" value="<?=trim($RsRem['cDistrito'])?>" type="hidden">
                            <input type=button value="seleccione" class="btn btn-primary" style="font-size:8px" onClick="sendValue(this.form.cNombreRemitente,this.form.iCodRemitente,this.form.txtdirec_remitente,this.form.cCodDepartamento,this.form.cCodProvincia,this.form.cCodDistrito);">
                        </td>
                    </form>
                </tr>
                <?php
            }
            sqlsrv_free_stmt($rsRem);
            ?>
        </table>
    </div>
    <script type="text/javascript" src="js_select/jquery-3.3.1.min.js"></script>
    <SCRIPT LANGUAGE="JavaScript">
        function sendValue (s,t,x,y,z,w){
            var selvalue1 = s.value;
            var selvalue2 = t.value;
            var selvalue3 = x.value;
            var selvalue4 = y.value;
            var selvalue5 = z.value;
            var selvalue6 = w.value;

            $.ajax({
                cache: false,
                method: "POST",
                url: "ajax/ajaxUbigeo.php",
                data: { departamento: selvalue4, provincia: selvalue5, distrito: selvalue6},
                datatype: "json",
                success: function (response) {
                    var json = eval('(' + response + ')');

                    window.opener.document.getElementById('cNombreRemitente').value = selvalue1;
                    window.opener.document.getElementById('iCodRemitente').value = selvalue2;
                    window.opener.document.getElementById('Remitente').value = selvalue2;
                    window.opener.document.getElementById('cNomRemite').value = (selvalue3+" "+json['dep'].trim()+", "+json['pro'].trim()+", "+json['dis'].trim());
                    window.opener.document.getElementById('txtdirec_remitente').value = selvalue3;
                    window.opener.document.getElementById('cCodDepartamento').value = selvalue4;
                    window.opener.document.getElementById('cCodProvincia').value = selvalue5;
                    window.opener.document.getElementById('cCodDistrito').value = selvalue6;
                    window.opener.document.frmRegistro.cNombreRemitente.focus();
                    window.close();
                }
            });


        }
        //  End -->
    </script>

    </body>
    </html>

<?php } else{
    header("Location: ../index-b.php?alter=5");
}
?>
