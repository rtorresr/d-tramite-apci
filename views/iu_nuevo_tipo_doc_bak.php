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

<form action="../controllers/ln_nuevo_tipo_doc.php" method="post" name="form1">

<table width="700" border="0"  align="center">
  <tr>
    <td class="headCellColum" colspan="3"> Ingrese datos de Tipo de Documento </td>
  </tr>
  <tr>
    <td width="28">
    <td width="335" align="left">Descripcion del tipo de Documento </td>
    <td width="323"><label>
      <input name="textdesc_doc" type="text" id="textdesc_doc" />
    </label></td>
  </tr>
  <tr>
    <td>
    <td align="left">Sigla del Documento </td>
    <td><input name="txtsigla_doc" type="text" id="txtsigla_doc"></td>
  </tr>
  <tr>
    <td>
    <td align="left">Numero Correlativo del Documento </td>
    <td><input name="txtnum_corr" type="text" id="txtnum_corr"></td>
  </tr>
  <tr>
    <td>
    <td align="left">Flg de Entrada </td>
    <td>
      <label>
      <select name="txtflgentrada" id="txtflgentrada">
	  <option value=1 >Activo</option>
	  <option value=0 >Inactivo</option>
	  </select>
      </label></td>
  </tr>
  <tr>
    <td>
    <td align="left">Flg Interno </td>
    <td>
      <label>
      <select name="txtflginterno" id="txtflginterno">
	  <option value=1 >Activo</option>
	  <option value=0 >Inactivo</option>
      </select>
      </label></td>
  </tr>
  <tr>
    <td align="center" colspan="3"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="CREA TIPO DOCUMENTO" /></td>
  </tr>
</table>

</form>


					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>