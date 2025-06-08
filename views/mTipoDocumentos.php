<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
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
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

<div class="AreaTitulo">Maestra Tipo de Documentos</div>	



<table width="600" border="1" align="center">
  <tr>
    <td colspan="2">Criterios de Busqueda </td>
  </tr>
  <tr>
    <td>Nombre de Documento </td>
    <td><label>
      <input name="cUsuario" type="text" id="cUsuario" />
    </label></td>
  </tr>
  <tr>
    <td><label>
      <input type="submit" name="Submit" value="Iniciar Busqueda" />
    </label></td>
    <td><label>
      <input type="reset" name="Submit2" value="Restablecer" />
    </label></td>
  </tr>
</table>


<table width="700" border="1" align="center">
  <tr>
    <td colspan="7" bgcolor="#0099FF"><div align="center">Tipos de Documento</div></td>
  </tr>
  

<?
require_once("conexion/conexion.php");
require_once("models/ad_tipo_doc.php");

echo "<tr><td>CodTipoDocumento</td><td>DescTipoDocumento</td><td>Sigladocumento</td><td>NumeroCorrelativo</td><td>FlgEntrada</td><td>FlgInterno</td><td>Opciones</td></tr>"; 
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "no hay tipos de documentos registrados<br>";
}
else{
while ($Rs=sqlsrv_fetch_array($rs)){ ?>

<tr>
    <td height="42" bgcolor="#FFFF64"><?php echo $Rs[cCodTipoDoc];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs['cDescTipoDoc'];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs[cSiglaDoc];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs[nNumCorrelativo];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs[nFlgEntrada];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs[nFlgInterno];?></td>
    
	<td><a href="ln_elimina_tipo_doc.php?id=<?php echo $Rs[cCodTipoDoc];?>">Anular</a>
	<br>
	<a href="iu_actualiza_tipo_doc.php?cod=<?php echo $Rs[cCodTipoDoc];?> &sw=5">Actualizar</a></td>
</tr>
  
<?
}
}
?>
</table>

<?echo "<a class='btn btn-primary' href='iu_nuevo_tipo_doc.php'>Nuevo Tipo Documento</a>";
?>
</td>
  </tr>
</table>



					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<tr>
<td width="1088" height="32" background="images/pcm_9.jpg">
<!-- **************** -->

<!-- **************** -->	
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>