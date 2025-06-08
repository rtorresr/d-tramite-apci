<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$fFechaHora=date("d-m-Y  G:i");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
    <script language="Javascript">
        var ventana;
        function crearVentana() {
             ventana = window.open("registroConCluidoPrint.php?nCodBarra=<?=$_GET['nCodBarra']??''?>&cCodificacion=<?=$_GET['cCodificacion']??''?>&cPassword=<?=$_GET['Password']??''?>&fFechaHora=<?=$fFechaHora?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']??''?>","nuevo","width=370,height=200");
             setTimeout(cerrarVentana,6000);
        }
        function cerrarVentana(){
             ventana.close();
        }
    </script>
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
                         <div class="card-header text-center "> >> </div>
                          <!--Card content-->
                         <div class="card-body">
                                <div class="AreaTitulo">Registro - <?php if($_GET['nFlgClaseDoc']===1) echo "Interno Oficina"?><?php if($_GET['nFlgClaseDoc']===2) echo "Interno Trabajadores"?><?php if($_GET['nFlgClaseDoc']===3) echo "SALIDA"?><?php if($_GET['nFlgClaseDoc']===4) echo "SALIDA ESPECIAL" ?></div>
                            <table class="table">
                                <tr>
                                    <td class="FondoFormRegistro">
                                        <br><br>
                                        <table align="center" cellpadding="3" cellspacing="3" border="0">
                                            <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b></td></tr>
                                            <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial"><?php if($_GET['cDescTipoDoc']==""){ echo "REGISTRO"; }Else{ echo $_GET['cDescTipoDoc'];}?> N&ordm;:&nbsp;<?=$_GET['cCodificacion'] ?></i></td></tr>
                                            <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$_GET['fFecActual']?></b></td></tr>
                                            <tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b></td></tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-primary" style="width:120px" onclick="crearVentana();"
                                                            onMouseOver="this.style.cursor='hand'">
                                                        <table cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td style=" font-size:10px"><b>Imprimir Ficha</b>&nbsp;&nbsp;</td>
                                                                <td><img src="images/icon_print.png" width="17" height="17" border="0"></td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <?php
                                                    if ($_GET['iCodRemitente']??'' == 0  AND $_GET['nFlgTipoDoc'] == 3){
                                                        $sqlSal = "SP_DOC_SALIDA_MULTIPLE_DL '".$_GET['iCodTramite']."' ";
                                                        $rsSal  = sqlsrv_query($cnx,$sqlSal);
                                                ?>
                                                        <td>
                                                            <button class="btn btn-primary" type="button" onclick="window.open('iu_doc_salidas_multiple.php?cod=<?=$_GET['iCodTramite']?>', '_self');" onMouseOver="this.style.cursor='hand'">
                                                                <table cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style=" font-size:10px"><b>Agregar Destinatarios</b>&nbsp;&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </button>
                                                        </td>
                                                <?php }
                                                    if ($_GET['nFlgTipoDoc'] != 3){
                                                ?>
                                                        <td>
                                                            <button class="btn btn-primary" style="width:120px height:20px" onclick="window.open('registroInternoHojasDeRuta_pdf.php?cCodificacion=<?=$_GET['cCodificacion']?>&iCodTramite=<?=$_GET['iCodTramite']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                <table cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style=" font-size:10px"><b>Hoja de Trámite</b>&nbsp;&nbsp;</td>
                                                                        <td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
                                                                    </tr>
                                                                </table>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary" style="width:120px height:20px" onclick="window.open('documento_pdf.php?cCodificacion=<?=$_GET['cCodificacion']?>&iCodTramite=<?=$_GET['iCodTramite']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                <table cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style=" font-size:10px"><b>Ver Documento</b>&nbsp;&nbsp;</td>
                                                                        <td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
                                                                    </tr>
                                                                </table>
                                                            </button>
                                                        </td>
                                                        <?php
                                                            $tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$_GET['iCodTramite']."'");
                                                            $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
                                                            if (!empty($RsTramitePDF->descripcion)) {
                                                        ?>
                                                                <td>
                                                                    <button class="btn btn-primary" style="width:120px" onclick="window.open('registroInternoDocumento_pdf.php?iCodTramite=<?=$_GET['iCodTramite']?>', '_blank');" onMouseOver="this.style.cursor='hand'">
                                                                        <table cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td style=" font-size:10px"><b>Documento</b>&nbsp;&nbsp;</td>
                                                                                <td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </button>
                                                                </td>
                                                <?php       }
                                                    } else if ($_GET['nFlgTipoDoc'] == 3){ }
                                                ?>
                                            </tr>
                                        </table>
                                        <?php if($_GET['nFlgRestricUp']??'' == 1){ ?>
                                            <div style="font-family:arial;font-size:12px;color:#ff0000">
                                                <br>
                                                    El archivo seleccionado "<b><?=$_GET['cNombreOriginal']?></b>" para "Adjuntar Archivo"
                                                <br>
                                                    no ha sido registrado debido a una restricción en la extensión.
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </main>

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>
</body>
</html>
<?php
} else {
   header("Location: ../index-b.php?alter=5");
}
?>