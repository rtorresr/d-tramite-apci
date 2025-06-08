<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
	$sql = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite = ".$_GET['iCodTramite'];
	$rs  = sqlsrv_query($cnx,$sql);
	$Rs  = sqlsrv_fetch_object($rs);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script Language="JavaScript">

	function Registrar(){
  	if (document.frmRegistro.cObservacion.value.length == "")
  	{
    	alert("Ingrese Observacion");
    	document.frmRegistro.cObservacion.focus();
    	return (false);
  	}
  	document.frmRegistro.submit();
	}
</script>
</head>
<body>
	<table width="350" height="240"  cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff" align="center" >
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

				<div class="AreaTitulo">Ingresar Observacion</div>
				<form method="POST" name="frmRegistro" action="actualizarObsAntesAprobar.php" target="_parent">
					<table width="351" border="0" cellpadding="0" cellspacing="3" align="center">
						<tr>
		  				<td width="230">
								<input type="hidden" name="iCodTramite" value="<?php echo $_GET['iCodTramite']; ?>">
								<input type="hidden" name="pag" value="<?php echo $_GET['pag']; ?>">
								<tr><td colspan="2">&nbsp;</td></tr>
							<td colspan="2" align="center">
		    				<textarea name="cObservacion" style="width:300px;height:70px" class="FormPropertReg form-control"><?php echo $Rs->MENSAJE_OBS; ?></textarea>
		    			</td>
		    		</tr>
    				<tr>
							<td height="37" colspan="2" align="center">
                              <?php
                                  if($_GET['pag']==1){
                              ?>
			  				<input name="button" type="button" class="btn btn-primary" value="Continuar" onclick="Registrar();">
			  				<?php
                                  } 
			  				?>
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
}else{
   header("Location: ../index-b.php?alter=5");
}
?>