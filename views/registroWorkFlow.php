<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
	if (!isset($_SESSION["cCodSession"])){ 
			  $max_chars=round(rand(10,15));  
				$chars=array();
				for($i="a";$i<"z";$i++){
  				$chars[]=$i;
  				$chars[]="z";
				}
				for ($i=0; $i<$max_chars; $i++){
  				$letra=round(rand(0, 1));
  				if ($letra){ 
 						$clave.= $chars[round(rand(0,count($chars)-1))];
  				}else{ 
 						$clave.= round(rand(0, 9));
  				}
				}
    	$_SESSION["cCodSession"]=$clave;
		}
        include_once("../conexion/conexion.php");
        $cod = $_GET["cod"]??'';
        $sw = $_GET["sw"]??'';
        $s1 = $_GET["s1"]??'';
        $s2 = $_GET["s2"]??'';
        //cod=4&sw=7&s1=1&s2=2
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv=Content-Type content=text/html; charset=utf-8>
    <?php include("includes/head.php");?>
    <link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen">
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
                        <div class="card-header text-center"> Programacion de Flujo de Trabajo </div>
                        <!--Card content-->
                        <div class="card-body">
                            <?php
                            require_once("../models/ad_busqueda.php");
                            ?>
                            <form name="frmRegistro" method="POST" action="registroFlujo.php" enctype="multipart/form-data">
                                <input type="hidden" name="opcion" value="">
                                <input type="hidden" name="iCodTupa" value="<?php if($Rs['iCodTupa']??''!=""){ echo $Rs['iCodTupa'];}else{ echo $_POST['iCodTupa'];}?>">
                                <input type="hidden" name="cod" value="<?php if($cod!=""){ echo $cod;}else{ echo $_POST['cod'];}?>"/>
                                <input type="hidden" name="cNomTupa" value="<?php if($Rs['cNomTupa']??''!=""){ echo $Rs['cNomTupa'];}else{ echo $_POST['cNomTupa'];}?>">
                                <input type="hidden" name="nDias" value="<?php if($Rs['nDias']??''!=""){ echo $Rs['nDias'];}else{ echo $_POST['nDias'];}?>">
                                <input type="hidden" name="iCodOficina" value="<?php if($Rs['iCodOficina']??''!=""){ echo $Rs['iCodOficina'];}else{ echo $_POST['iCodOficina'];};?>">
                            <?php if ($_GET['alert']??''==1)
                                {
                             ?>
                                    <script Language="JavaScript">
                                        alert ("La Oficina ya ha Sido Creada Anteriormente");
                                    </script>
                            <?php } ?>
                            <?php if ($_GET['mensaje']??''==1)
                                {
                             ?>
                                    <script Language="JavaScript">
                                     alert ("La cantidad de dias excede a las del Documento Tupa");
                                    </script>
                            <?php } ?>
                                <table>
                                    <tr>
                                        <td >
                                            <table border=0>
                                                <tr>
                                                    <td valign="top"  width="153">Nombre del Doc. Tupa:</td>
                                                    <td width="370"  align="left"><?php if($Rs['cNomTupa']??''!=""){ echo $Rs['cNomTupa'];}else{ echo $_POST['cNomTupa'];}?></td>
                                                    <td  width="136">Oficina Responsable:</td>
                                                    <td width="263" align="left">
                                                        <?php if($Rs['iCodOficina']??''!=""){ $iCodOficina=$Rs['iCodOficina'];}else{ $iCodOficina=$_POST['iCodOficina'];};
                                                           $sqlOfi="SP_OFICINA_LISTA_AR $iCodOficina";
                                                           $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                                           $RsOfi=sqlsrv_fetch_array($rsOfi);
                                                           echo utf8_encode($RsOfi['cNomOficina']);
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"  width="153">Total de Dias:</td>
                                                    <td align="left"><?php if($Rs['nDias']??''!=""){ echo $Rs['nDias'];}else{ echo $_POST['nDias'];}?></td>
                                                    <td valign="top"  width="136"></td>
                                                    <td valign="top"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"  align="center">
                                                        <table border=1>
                                                            <tr>
                                                                <td align="center" valign="middle"><img src="images/icon_expandb.png" border="0" width="16" height="16"></td>
                                                                <td>
                                                                    <select name="iCodOficinaMovFlujo" style="width:300px;" class="FormPropertReg form-control" >
                                                                      <option value="">Seleccione Oficina:</option>
                                                                      <?php
                                                                        $sqlDep2="SP_OFICINA_LISTA_COMBO ";
                                                                        $rsDep2=sqlsrv_query($cnx,$sqlDep2);
                                                                        while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
                                                                            if($RsDep2['iCodOficina']==$Rs['iCodOficina']){
                                                                                $selecOfi="selected";
                                                                            }else{
                                                                                $selecOfi="";
                                                                            }
                                                                            echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".utf8_encode($RsDep2["cNomOficina"])."</option>";
                                                                        }
                                                                        sqlsrv_free_stmt($rsDep2);
                                                                      ?>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="cActividadMovFlujo" style="width:230px;" <?php echo $_GET["cActividad"]??'';?>/></td>
                                                                <td>
                                                                     <textarea name="cDesMovFlujo" style="width:300px;height:30px" class="FormPropertReg form-control"><?=$_POST['cDesMovFlujo']??''?></textarea>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="nPlazoMovFlujo" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
                                                                </td>
                                                                <td>
                                                                    <input name="button" type="button" class="btn btn-primary" value="Añadir" onclick="AddOficina();">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="headColumnas">Orden</td>
                                                                <td class="headColumnas">Oficina</td>
                                                                <td class="headColumnas">Actividad</td>
                                                                <td class="headColumnas">Detalle de Actividad</td>
                                                                <td class="headColumnas">Plazo</td>
                                                                <td class="headColumnas">Opcion</td>
                                                            </tr>
                                                            <?php
                                                            if($cod!=""){ $iCodTupa=$cod;}else{ $iCodTupa=$_POST['cod'];};
                                                            $sqlMovs="SELECT * FROM Tra_M_Mov_Flujo WHERE iCodTupa=".$iCodTupa."ORDER BY iNumOrden ASC";
                                                            $rsMovs=sqlsrv_query($cnx,$sqlMovs);
                                                            while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
                                                            ?>
                                                                <tr>
                                                                    <td><input type="text" name="iNumOrden[]"  value="<?=$RsMovs['iNumOrden']?>" style="width:30px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/><input type="hidden" name="iCodMovFlujo[]" value="<?=$RsMovs['iCodMovFlujo']?>" ></td>
                                                                    <td align="left">
                                                                        <?php
                                                                        $sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='".$RsMovs['iCodOficina']."'";
                                                                          $rsOfc=sqlsrv_query($cnx,$sqlOfc);
                                                                          $RsOfc=sqlsrv_fetch_array($rsOfc);
                                                                          echo utf8_encode($RsOfc["cNomOficina"]);
                                                                        ?>
                                                                    </td>
                                                                    <td align="left"><?php echo $RsMovs["cActividad"];?></td>
                                                                    <td align="left"><?=$RsMovs['cDesMovFlujo']?></td>
                                                                    <td align="left"><?=$RsMovs['nPlazo']?></td>
                                                                    <td align="center">
                                                                        <a href="registroFlujo.php?iCod=<?=$RsMovs['iCodMovFlujo']?>&opcion=6&iCodTupa=<?=$iCodTupa?>" onClick='return ConfirmarBorrado();'><img src="images/icon_del.png" border="0" width="16" height="16"></a>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                            </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <br>
                                                        <button class="btn btn-primary" onclick="Ordenar();"  onMouseOver="this.style.cursor='hand'" ><img src="images/icon_aceptar.png" width="17" height="17" border="0"></td><td style=" font-size:10px"><b>Ordenar</b>&nbsp;&nbsp; </button>&nbsp; &nbsp;
                                                        <button class="btn btn-primary" type="button" onclick="window.open('iu_tupa.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Regresar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    <!--/.Card-->
                </div>
                <!--Grid column-->
            </div>
            <!--Grid column-->
        </div>
        <!--Grid column-->
    </main>

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>
    <script Language="JavaScript">
        <!--
        function Registrar(){
            document.frmRegistro.opcion.value=2;
            document.frmRegistro.action="registroFlujo.php";
            document.frmRegistro.submit();
        }

        function AddOficina(){
            if (document.frmRegistro.iCodOficinaMovFlujo.value.length == "")
            {
                alert("Seleccione Oficina");
                document.frmRegistro.iCodOficinaMovFlujo.focus();
                return (false);
            }
            if (document.frmRegistro.cActividadMovFlujo.value.length == "")
            {
                alert("Ingresa una Actividad");
                document.frmRegistro.cActividadMovFlujo.focus();
                return (false);
            }
            if (document.frmRegistro.nPlazoMovFlujo.value.length == "")
            {
                alert("Ingresa un plazo en dias");
                document.frmRegistro.nPlazoMovFlujo.focus();
                return (false);
            }
            if (document.frmRegistro.cDesMovFlujo.value.length == "")
            {
                alert("Ingresa el detalle de la actividad");
                document.frmRegistro.cDesMovFlujo.focus();
                return (false);
            }
            document.frmRegistro.opcion.value=3;
            document.frmRegistro.action="registroFlujo.php";
            document.frmRegistro.submit();
        }

        function releer(){
            document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
            document.frmRegistro.submit();
        }

        function Ordenar()
        {
            document.frmRegistro.opcion.value=2;
            document.frmRegistro.action='registroFlujo.php';
            document.frmRegistro.method='POST';
            document.frmRegistro.submit();
        }
        function ConfirmarBorrado()
        {
            if (confirm("Esta seguro de eliminar el registro?")){
                return true;
            }else{
                return false;
            }
        }
        //--></script>
    <script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>