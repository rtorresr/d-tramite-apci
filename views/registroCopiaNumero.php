<?
header('Content-Type: text/html; charset=UTF-8');
/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: PendienteData.php
  SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
  OBJETIVO: Seleccion remitente
  PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver   Autor                 Fecha          Descripción
  ------------------------------------------------------------------------
  1.0   APCI    12/11/2010      Creación del programa.
  ------------------------------------------------------------------------
 * *************************************************************************************** */
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != "") {
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <title>SITDD</title>
            <meta NAME="language" CONTENT="ES"/>
            <meta content="1 days" name="REVISIT-AFTER"/>
            <meta content="ES" name="language"/>
            <meta scheme="RFC1766" content="Spanish" name="DC.Language"/>
            <meta http-equiv="content-type" content="text/html" />
            <link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
            <script Language="JavaScript">
                <!--
            function Registrar() {
                    if (document.frmRegistro.CantCopias.value.length == "")
                    {
                        alert("Ingrese cantidad de copias");
                        document.frmRegistro.CantCopias.focus();
                        return (false);
                    }
                    document.frmRegistro.submit();
                }
                //--></script>
        </head>
        <body>
             
                <table width="380" height="150" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
                    <tr>
                        <td align="left" valign="top">
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
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

                                <div class="AreaTitulo">Agregar Copias:</div>	
                                <form method="POST" name="frmRegistro" action="registroCopia.php" target="_parent">
                                    <input type="hidden" name="iCodTramite" value="<?= $_GET[iCodTramite] ?>"/>
                                    <input type="hidden" name="URI" value="<?= $_GET[URI] ?>"/>
                                    <table width="370" border="0" cellpadding="0" cellspacing="3" align="center">
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="230" align="right">Ingrese cantidad de copias:</td>
                                            <td><input type="text" name="CantCopias" style="width:20px;text-align:right" onKeypress="if (event.keyCode < 45 || event.keyCode > 57)event.returnValue = false;"/></td>
                                        </tr>
                                        <tr>
                                            <td width="230" align="right">Registrar la misma observación para todos los destinatarios?:</td>
                                            <td><input type="checkbox" name="mismaObs" value="1"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                 <input name="button" type="button" class="btn btn-primary" value="Continuar" onclick="Registrar();"/>
                                                <script language="JavaScript" type="text/javascript">if (document.frmRegistro)document.frmRegistro('CantCopias').focus();</script>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>		
                        </td>
                    </tr>
                </table>

        </body>
    </html>

    <?php
} else {
    header("Location: ../index-b.php?alter=5");
}
?>