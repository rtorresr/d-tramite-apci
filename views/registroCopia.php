<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php"); ?>

<script Language="JavaScript">
<!--
function releer(){
  document.frmRegistro.action="<?php echo $_SERVER['PHP_SELF'] ?>?iCodTramite=<?php echo $_POST[iCodTramite] ?>&clear=1#area";
  document.frmRegistro.submit();
}
function Registrar(){
  document.frmRegistro.opcion.value=12;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}
//--></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
<body>

<table cellpadding="0" cellspacing="0" border="0">
    <tr>

            <?php include("includes/menu.php"); ?>
        </td>
    </tr>
    <tr>

    </tr>
    <tr>

            <?php
            $rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'");
            $Rs=sqlsrv_fetch_array($rs);
            ?>
            <a name="area"></a>
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

            <div class="AreaTitulo">Registro - Copias</div>
            <form name="frmRegistro" method="POST">
                <input type="hidden" name="opcion" value="12"/>
                <input type="hidden" name="CantCopias" value="<?php echo $_POST[CantCopias] ?>"/>
                <input type="hidden" name="iCodTramite" value="<?php echo $_POST[iCodTramite] ?>"/>
                <input type="hidden" name="mismaObs" value="<?php echo $_POST[mismaObs] ?>"/>
                <input type="hidden" name="URI" value="<?php echo $_POST[URI] ?>"/>
		<table class="table">
		<tr>
                    <td class="FondoFormRegistro">
			<table width="100%" border=0>
			<tr>
                            <td width="150" >Tramite N&ordm;: &nbsp;</td>
                            <td width="320" class="CellFormRegOnly" style="font-size:16px"><?php echo $Rs[cCodificacion] ?></td>
                            <td width="130" >Fecha de Registro:&nbsp;</td>
                            <td>
                                <span><?php echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecRegistro'], 0, -6)))/*date("d-m-Y", strtotime($Rs['fFecRegistro'])) */?></span>
                                <span style=font-size:10px><?/*php echo date("h:i A", strtotime($Rs['fFecRegistro'])) */?></span>
                            </td>


                        </tr> 
			<?php
			for($i=1; $i <= $_POST["CantCopias"]; $i++){
			?>
			<tr>
                            <td colspan="5">&nbsp;
                                <?php
                                $recolector = $i-1;
                                /*
                                $iCodOficinaResponsableSelect = $iCodOficinaResponsable[$recolector];
                                $iCodTrabajadorResponsableSelect = $iCodTrabajadorResponsable[$recolector];
                                $iCodIndicacionSelect = $iCodIndicacion[$recolector];
                                $nFlgEnvioSelect = $nFlgEnvio[$recolector];
                                $cObservacionesSelect = $cObservaciones[$recolector];
                                */
                                $iCodOficinaResponsableSelect = $_POST["iCodOficinaResponsable"][$recolector];
                                $iCodTrabajadorResponsableSelect = $_POST["iCodTrabajadorResponsable"][$recolector];
                                $iCodIndicacionSelect = $_POST["iCodIndicacion"][$recolector];
                                $nFlgEnvioSelect = $_POST["nFlgEnvio"][$recolector];
                                $cObservacionesSelect = $_POST["cObservaciones"][$recolector];
                                ?>
                            </td>
			</tr>
			<tr>
                            <td colspan="5" style="background-color: #004080;color:#ffffff" align="left" valign="center" height="25px">&nbsp;&nbsp;Destino <?php echo $i ?>:</td>
			</tr>
			<tr>
                            <td valign="top"  width="150">Oficina:</td>
                            <td colspan="2">
                                <select name="iCodOficinaResponsable[]" style="width:340px;" class="FormPropertReg form-control" onChange="releer();">
                                    <option value="">Seleccione:</option>
                                        <?php
                                        $sqlOf = "SELECT * FROM Tra_M_Oficinas ORDER BY cNomOficina ASC";
                                        $rsOf  = sqlsrv_query($cnx,$sqlOf);
                                        $auxData = array();
                                        while ($RsOf = sqlsrv_fetch_array($rsOf)){
                                            $auxData[] = $RsOf;
                                            $selecOfi = "";
                                            if($_GET["clear"] == 1){
                                                if($RsOf["iCodOficina"] == $iCodOficinaResponsableSelect){
                                                    $selecOfi = "selected";
                                                }else{
                                                    $selecOfi = "";
                                                }
                                            }
                                            echo "<option value=\"".$RsOf["iCodOficina"]."\" ".$selecOfi.">".$RsOf["cNomOficina"]."</option>";
                                        }
                                        //mysql_free_result($rsOf);
                                    ?>
                                </select>
                            </td>
                            <td width="150"  valign="top">Observaciones:&nbsp;</td>
                            <td rowspan="4">
                            <?php
                            if($_POST["mismaObs"]==1){
                                $cObservaciones[$recolector] = $Rs[cObservaciones];
                                $cObservacionesSelect = $cObservaciones[$recolector];
                           ?>
                                <textarea name="cObservaciones[]" style="width:340px;height:55px" class="FormPropertReg form-control" disabled><?php echo $cObservacionesSelect ?></textarea>
                            <?php 
                            }else{
                            ?>
                                <?php
                                if($_GET[clear]==""){
                                ?>
                                <textarea name="cObservaciones[]" style="width:340px;height:55px" class="FormPropertReg form-control"><?php echo $cObservacionesSelect ?></textarea>
                                <?php 
                                }else{ 
                                ?>
                                <textarea name="cObservaciones[]" style="width:340px;height:55px" class="FormPropertReg form-control"><?php echo $cObservacionesSelect ?></textarea>
                                <?php 
                                }
                                ?>
                            <?php 
                            }
                            ?>
           
                            </td>
			</tr>
			<tr>
        <td valign="top" >Responsable</td>
        <td colspan="3">
          <select name="iCodTrabajadorResponsable[]" style="width:340px;" class="FormPropertReg form-control">
            <?php
              $sqlTrb = "SELECT * FROM Tra_M_Trabajadores
                         WHERE iCodTrabajador = (SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario 
                                   WHERE iCodOficina = '$iCodOficinaResponsableSelect' AND iCodPerfil = 3)";
              $rsTrb = sqlsrv_query($cnx,$sqlTrb);
              while ($RsTrb = sqlsrv_fetch_array($rsTrb)){
                if($_GET[clear] == 1){
                  if($RsTrb[iCodTrabajador] == $iCodTrabajadorResponsableSelect){
                    $selecTrab = "selected";
                  }else{
                    $selecTrab = "";
                  }
                }
                echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
              }
              sqlsrv_free_stmt($rsTrb);
            ?>
            </select>
        </td>
			</tr>
			<tr>
          <td valign="top"  width="150">Indicación:</td>
          <td valign="top" colspan="3">
              <select name="iCodIndicacion[]" style="width:250px;" class="FormPropertReg form-control">|
                  <option value="">Seleccione:</option>
                      <?php
                      $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                      $sqlIndic .= "ORDER BY cIndicacion ASC";
                      $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                      while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                          if($_GET[clear]==""){  
                              if($RsIndic[iCodIndicacion]==3){
                                  $selecIndi="selected";
                              }else{
                                  $selecIndi="";
                              }              			
                          }
                          if($_GET[clear]==1){
                              if($RsIndic[iCodIndicacion]==$iCodIndicacionSelect ){
                                  $selecIndi="selected";
                              }else{
                                  $selecIndi="";
                              }              	
                          }
                        echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
                      }
                      sqlsrv_free_stmt($rsIndic);
                      ?>
              </select>
          </td>
      </tr>
			<tr>
        <td valign="top" >Enviar Inmediatamente:</td>
        <td valign="top" colspan="3">
            <input type="checkbox" name="nFlgEnvio[]" value="1" checked="checked" <?php //if($nFlgEnvioSelect==1) echo "checked" ?>/>

        </td>
			</tr>
			<?php
                        }
                        ?>
			<tr>
                            <td colspan="4">

                                    <input name="button" type="button" class="btn btn-primary" value="Generar Copias" onclick="Registrar();"/>

                            </td>
			</tr>
                    </table>
		</td>
            </tr>
            </table>
        </form>
    </div>		
    </td>
</tr>
<tr>
    <td><img width="1088" height="11" src="images/pcm_8.jpg" border="0"/></td>
</tr>
<?php include("includes/userinfo.php") ?>
</table>

<?php include("includes/pie.php") ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>