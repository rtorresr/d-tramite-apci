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

<table cellpadding="0" cellspacing="0" border="0">
	
<tr>

	<?php include("includes/menu.php");?>

<div class="AreaTitulo">Maestra Oficinas</div>
<?
require_once("../models/ad_busqueda.php");
?>
<form action="../controllers/ln_actualiza_oficina.php" method="post" name="form1">

<table width="400" border="0" align="center">
  <tr>
    <td class="headCellColum" colspan="2" align="center">Actualizar Perfil </td>
  </tr>
  
  <tr>
    <td>Tipo de Perfil </td>
    <td><input name="txtperfil" type="text" id="txtperfil" value="<?php echo $Rs[cTipoPerfil]; ?>"></td>
  </tr>
  <tr>
    <td valign="top">Descripcion de Perfil </td>
    <td><label>
     <input name="textdescricion_perfil" type="text" id="textdescricion_perfil" value="<?php echo $Rs[cDescPerfil]; ?>"/>
    </label></td>
  </tr>
    
  <tr>
    <td align="center" colspan="2"><input name="Insert Perfil" type="submit" id="Insert Perfil" value="ACTUALIZAR PERFIL" /></td>
  </tr>
</table>

    <input name="txtcod_perfil" type="hidden" id="txtcod_perfil" value="<?php echo $Rs[nCodPerfil]; ?>">
  
</form>


<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>