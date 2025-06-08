<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
ini_set('date.timezone', 'America/Lima');
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
  if ($_GET['nCodBarra'] != ""){
    require("core.php");
    $p_bcType     = 1;
    $p_text       = $_GET['nCodBarra'];
    $p_textEnc    = $_GET['nCodBarra'];
    $p_xDim       = 1;
    $p_w2n        = 3;
    $p_charHeight = 50;
    $p_charGap    = $p_xDim;
    $p_type       = 2;
    $p_label      = "N";
    $p_checkDigit = "N";
    $p_rotAngle   = 0;
    $dest         = "wrapper.php?p_bcType=".$p_bcType."&p_text=".$p_textEnc."&p_xDim=".$p_xDim."&p_w2n=".$p_w2n."&p_charGap=".$p_charGap."&p_invert=".($p_invert??'')."&p_charHeight=".$p_charHeight."&p_type=".$p_type."&p_label=".$p_label."&p_rotAngle=".$p_rotAngle."&p_checkDigit=".$p_checkDigit."";
    }
  include_once("../conexion/conexion.php");
  $sqlTramite = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite=".$_GET['iCodTramite'];
  $tramitePDF   = sqlsrv_query($cnx,$sqlTramite);
  $RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
    </head>
    <?php

           /*$sqlRefcnt = "SELECT clave FROM Tra_M_Tramite WHERE cCodificacion = '".$_GET['cCodificacion']."'";
           $rsCnT1 = sqlsrv_query($cnx,$sqlRefcnt);
           $RsCnT2 = sqlsrv_fetch_array($rsCnT1);
           $clave  = $RsCnT2[0];*/

             //set it to writable location, a place for temp generated PNG files
              /*$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'registerDoc\phpqrcode\temp'.DIRECTORY_SEPARATOR;

              //html PNG location prefix
              $PNG_WEB_DIR = 'registerDoc/phpqrcode/temp/';

              include "registerDoc/phpqrcode/qrlib.php";

              //ofcourse we need rights to create temp dir
              if (!file_exists('c:/STD_DOCUMENTO')){
              mkdir('c:/STD_DOCUMENTO', 0777, true);}

              if (!file_exists($PNG_TEMP_DIR)){
                  mkdir($PNG_TEMP_DIR);}

              //$filename = $PNG_TEMP_DIR.'test.png';

              $errorCorrectionLevel = 'L';
              $matrixPointSize = 2;
              //$_REQUEST['data']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                // Falla < ----------------------------------
            //$_REQUEST['data']=$_SERVER['HTTP_HOST'].'/pro/views/pdf_digital_salida.php?iCodTramite='.$_GET['iCodTramite'];
            $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/pro/views/pdf_digital_salida.php?iCodTramite='.$RsTramitePDF->iCodTramite;
            //$_REQUEST['data']='http://sitdd.apci.gob.pe/consulta/ver_tramite.php?expediente='.$_GET['cCodificacion'].'&clave='.$clave.'';

                //echo $_REQUEST['data'];
              // user data
              $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
              $filename = $PNG_TEMP_DIR.$codigoQr;

                //echo $codigoQr;

              QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);*/

    ?>

    <style>
        body{
            margin: 0px;
            padding: 0px;
        }

        .letra{
            font-size: 9px;
            font-family: 'Arial',sans-serif;
        }
        .titulo{
            font-size: 15px;
            font-family: 'Arial',sans-serif;
        }
    </style>

    <body>

    <!--<table cellpadding="0" cellspacing="0" border="0" width='100px' class="letra">

          <tr>
              <td >
                  <?php //echo $img_final="<img src=".($PNG_WEB_DIR??'').basename($filename??'')." height='75px'>" ?>
              </td>
              <td>
                  <table cellpadding="0" cellspacing="0" border="0" width='100%' class="letra">
                      <tr>
                          <td>
                              <span class="titulo"><?//=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?></span>
                              <br>
                            <span class="letra">CLAVE: <?php// echo $clave;?>
                                <br>
                                  <?php/*
                      $fFecActual = $_GET['fFechaHora'];
                      if (!empty($fFecActual)) {
                        $date = date_create($fFecActual);
                        echo $date->format("Y-m-d H:i:s");
                      }*/
                    ?>
                              </span>
         <br>
    <span class="letra"> <b>sitdd.apci.gob.pe</b></span>

    <?php/*

            $sqlOfi="select 
            (select cUsuario from Tra_M_Trabajadores where iCodTrabajador=tm.iCodTrabajadorRegistro) as
            iCodTrabajadorRegistro from Tra_M_Tramite tm
            where cCodificacion='".($_GET['cCodificacion']??'')."'";
            $rsOfi=sqlsrv_query($cnx,$sqlOfi);
            while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                echo "Usuario: ".$RsOfi["iCodTrabajadorRegistro"];
            }
*/
    ?>

                          </td>
                      </tr>
                  </table>
              </td>
              <td>
                  &nbsp;
              </td>
          </tr>
      </table>-->

       <?php

       ?>
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="340" height="21">
              <table align="center" cellpadding="3" cellspacing="3" border="0">
                <tr>
                  <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>D-TRÁMITE</b>
                </td>
              </tr>

              <tr>
                <td align="center"
                  style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">
                    <?php
                      // if ($RsTramite->nFlgEnvio == 0 AND $RsTramite->nFlgClaseDoc == 2) { // PENDIENTE
                      //   echo "TRAMITE Nro: ".$RsTramite->cCodificacion;
                      // }
                      echo "TRAMITE Nro: ".$RsTramitePDF->cCodificacion;
                    ?>
                </td>
              </tr>

              <?php
                if ($_GET['nCodBarra']??'' != ''){
              ?>
                <tr>
                  <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">
                      <?php
                      echo "<img src='".$RsTramitePDF->codigoQr."' height='75px'>"
                      ?>
                    <!--<img src="<?php// echo $dest;?>" ALT="<?php// echo strtoupper($p_text); ?>" width="260">-->
                  </td>
                </tr>
              <?php
                }
               ?>

                <!-- <tr>
                  <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">
                  <?php
                      if ($_GET['cDescTipoDoc'] == ""){
                        echo "TRÁMITE";
                      }else{
                        if ($_GET['aprobadoPrint'] == 1) {
                          echo $_GET['cDescTipoDoc']." ";
                          echo $_GET['cCodificacion'];
                        }
                      }
                  ?>
                  </td>
                </tr> -->

              <?//if($_GET[nCodBarra]!=""){?>
              <!--<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">CONTRASEÑA:&nbsp;<b><?=$_GET[cPassword]?></b></td></tr>-->
              <?//}?>
              <?php
                /*$primerCaracter = substr($RsTramitePDF->cCodificacion,0,1);
                if ($primerCaracter == "E")*/ //{ // Cuando el trámite es de entrada, pudiendo ser con tupa o sin tupa
              ?>
                <tr>
                  <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">CLAVE:&nbsp;
                    <?php
                      echo $RsTramitePDF->clave;
                    ?>
                    </i>
                  </td>
                </tr>
              <?php
                //}
              ?>

              <tr>
                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$_GET['fFechaHora']?></b>
                </td>
              </tr>

              <tr>
                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>d-tramite.apci.gob.pe</b>
                </td>
              </tr>

              <?php
                $sqlGenerador = "SELECT cNombresTrabajador, cApellidosTrabajador 
                                 FROM Tra_M_Trabajadores 
                                 WHERE iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
                $rsGenerador  = sqlsrv_query($cnx,$sqlGenerador);
                $RsGenerador  = sqlsrv_fetch_object($rsGenerador);
              ?>

              <tr>
                <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">
                  <?php
                    echo "GENERADO POR :".$RsGenerador->cApellidosTrabajador.", ".$RsGenerador->cNombresTrabajador;
                  ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

    <?php

    ?>

    <script language="JavaScript" type="text/javascript">
    <!--

    var da = (document.all) ? 1 : 0;
    var pr = (window.print) ? 1 : 0;
    var mac = (navigator.userAgent.indexOf("Mac") != -1);

    function printWin()
    {
        if (pr) {
            // NS4+, IE5+
            window.print();
        } else if (!mac) {
            // IE3 and IE4 on PC
            VBprintWin();
        } else {
            // everything else
            handle_error();
        }
    }

    window.onerror = handle_error;
    window.onafterprint = function() {window.close()}

    function handle_error()
    {
        window.alert('Su navegador no admite la opción de impresión. Presione Control/Opción + P para imprimir.');
        return true;
    }

    if (!pr && !mac) {
        if (da) {
            // This must be IE4 or greater
            wbvers = "8856F961-340A-11D0-A96B-00C04FD705A2";
        } else {
            // this must be IE3.x
            wbvers = "EAB22AC3-30C1-11CF-A7EB-0000C05BAE0B";
        }

        document.write("<OBJECT ID=\"WB\" WIDTH=\"0\" HEIGHT=\"0\" CLASSID=\"CLSID:");
        document.write(wbvers + "\"> </OBJECT>");
    }

    // -->
    </script>
      <script language="VBSCript" type="text/vbscript">

    </script>
    <script language="JavaScript" type="text/javascript">
    <!--
    printWin();
    // -->
    </script>
    </body>
    </html>
<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>