<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>
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
                    <div class="card-header text-center ">Enviar Documento</div>
                    <!--Card content-->
                    <div class="card-body">
						<form name="frmConsulta" method="POST">
							<input type="hidden" name="opcion" value="6">
							<input type="hidden" name="iCodMovimiento" value="<?=((isset($_GET['iCodMovimientoAccion']))?$_GET['iCodMovimientoAccion']:'')?>">
                            <div class="row">
                                <div class="col-lg-2">
                                    Enviar a:
                                    <select name="iCodTrabajadorEnviar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                        <option value="">Seleccione:</option>
                                        <?php
                                        include_once("../conexion/conexion.php");
                                        $sqlCodPeril = "SELECT iCodPerfil FROM Tra_M_Perfil_Ususario WHERE iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
                                        $rsCodPerfil = sqlsrv_query($cnx,$sqlCodPeril);
                                        $RsCodPerfil = sqlsrv_fetch_array($rsCodPerfil);

                                        $sqlTrb = "SELECT TMT.iCodTrabajador AS iCodTrabajador,
																		TMT.cApellidosTrabajador AS cApellidosTrabajador, 
																		TMT.cNombresTrabajador AS cNombresTrabajador  
														 FROM Tra_M_Perfil_Ususario TMU 
														 INNER JOIN Tra_M_Trabajadores TMT ON TMU.iCodTrabajador = TMT.iCodTrabajador
														 WHERE TMU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."' AND
														 			 TMU.iCodPerfil = '$RsCodPerfil[iCodPerfil]'";
                                        $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                                        while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
                                            echo utf8_encode("<option value=\"".$RsTrb["iCodTrabajador"]."\">".ucwords(strtolower($RsTrb["cApellidosTrabajador"]." ".utf8_decode($RsTrb["cNombresTrabajador"])))."</option>");
                                        }
                                        sqlsrv_free_stmt($rsTrb);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="md-form">
                                        <textarea name="cObservacionesEnviar" id="cObservacionesEnviar" class="md-textarea form-control md-textarea-auto"></textarea>
                                        <label for="cObservacionesEnviar">Observaciones:</label>
                                    </div>
                                </div>
                            </div>
							<button class="btn btn-primary" onclick="Delegar();" onMouseOver="this.style.cursor='hand'">
                                <b>Enviar</b>
                                <img src="images/icon_delegar.png" width="17" height="17" border="0">
                            </button>
							&nbsp;&nbsp;
							<a class="btn btn-primary" href="profesionalPendientes.php" >
                                <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0">
                            </a>

						</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>

<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<script Language="JavaScript">
    $('.mdb-select').material_select();
    function Delegar()
    {
        document.frmConsulta.action="profesionalData.php";
        document.frmConsulta.submit();
    }
   </script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>