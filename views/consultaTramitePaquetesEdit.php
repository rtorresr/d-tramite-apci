<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
	function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
    	for($m=0; $m<$dif_diez; $m++){
            @$insertar_ceros .= 0;
    	}
    	return $insertar_ceros .= $numero;
  }	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
</head>
<body>

<table width="725" height="130" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
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

<div class="AreaTitulo">Paquete N&ordm;: <?=add_ceros($_GET[iCodPaquete],5)?> - editar Observaciones:</div>
		<br>
		<table width="100%" border="0" cellpadding="0" cellspacing="3">
			<form method="POST" name="formulario" action="consultaTramiteData.php" target="_parent" enctype="multipart/form-data">
			<input type="hidden" name="iCodPaquete" value="<?=$_GET[iCodPaquete]?>">
			<input type="hidden" name="opcion" value="2">			
		<tr>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<?
					include_once("../conexion/conexion.php");
					$sql="SELECT * FROM Tra_M_Tramite_Fiscalizacion WHERE iCodPaquete='$_GET[iCodPaquete]'";	   
    			$rs=sqlsrv_query($cnx,$sql);
					$Rs=sqlsrv_fetch_array($rs);
					?>
					<textarea name="cObservaciones" style="width:550px;height:100px" class="FormPropertReg form-control"><?=trim($Rs[cObservaciones])?></textarea>
			</td>
		</tr>
		
		<tr>
				<td valign="top" >Adjuntar Informe:</td>
				<td valign="center">
					<?php if($Rs[cInformeDigital]==""){?>
						<input type="file" name="fileUpLoadDigital" class="FormPropertReg form-control" style="width:490px;" />
					<?php } else{?>
						<table><tr>
							<td><?=$Rs[cInformeDigital]?>&nbsp;<a href="consultaTramiteData.php?iCodPaquete=<?=$_GET[iCodPaquete]?>&opcion=3"><i class="far fa-trash-alt"></i> quitar</a></td>
						</tr>
						</table>
					<?php}?>
				</td>
			</tr>
		
		<tr>
			<td colspan="2">

				<input name="button" type="submit" class="btn btn-primary" value="Actualizar">

			</td>
		</tr>
			</form>
		</table>
		<br>
<div>		
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>