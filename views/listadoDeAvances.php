<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
</head>

<body>
  <table width="400" height="350"  cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff" align="center" >
    <tr>
      <td  align="left" valign="top">
          <div class="AreaTitulo">Lista de Avances</div>
            <table cellpadding="0" cellspacing="0" border="0" width="600">
              <tr>

                  <table cellpadding="0" cellspacing="0" border="0" width="300"><tr><td><?php // ini table por fieldset ?>
                    <fieldset>
                      <table cellpadding="3" cellspacing="3" border="0" width="300">
                        <?php
                          include_once("../conexion/conexion.php");
                          $sqlMov = "SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$_GET[iCodMovimiento]'";
                          $rsMovData = sqlsrv_query($cnx,$sqlMov);
                          $RsMovData = sqlsrv_fetch_array($rsMovData);
    
                          $sqlAvn = "SELECT * FROM Tra_M_Tramite_Avance WHERE iCodTramite='$RsMovData[iCodTramite]' 
                                     ORDER BY iCodAvance DESC";
                          $rsAvn  = sqlsrv_query($cnx,$sqlAvn);
                          while ($RsAvn = sqlsrv_fetch_array($rsAvn)){
                        ?>
                        <tr>
                          <td width="120" valign="top" align="right" width="160">
                            <?php
                              $rsTrbA = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsAvn[iCodTrabajadorAvance]'");
                              $RsTrbA = sqlsrv_fetch_array($rsTrbA);
                              echo "<div style=font-size:10px;color:#623100>".$RsTrbA["cApellidosTrabajador"]." ".$RsTrbA["cNombresTrabajador"].":</div>";
                              sqlsrv_free_stmt($rsTrbA);
                              //echo "<div style=font-size:10px;color:#005128>".date("d-m-Y h:i a", strtotime($RsAvn[fFecAvance]))."&nbsp;</div>";
                              echo "<div style=font-size:10px;color:#005128>".date("d-m-Y h:i a", strtotime(substr($RsAvn[fFecAvance], 0, -6)))."&nbsp;</div>";
                            ?>
                        </td>
                        <td align="left" valign="top"><?=$RsAvn[cObservacionesAvance]?></td>
                      </tr>
                      <?php
                        }
                      ?>
                      </table>
                    </fieldset>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        </div>
      </td>
    </tr>
  </table>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>