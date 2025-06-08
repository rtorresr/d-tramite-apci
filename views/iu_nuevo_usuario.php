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

<div class="AreaTitulo">Maestra Usuarios del Sistema</div>



<form action="../controllers/ln_nuevo_usuario.php" method="post" name="form1">

<table width="600" border="0" bgcolor="#C7C5CD" align="center">
  <tr>
    <td class="headCellColum" colspan="3"><div align="center">Ingrese datos de Usuario </div></td>
    
  </tr>
  <tr>
  	<td width="61">
    <td width="260">Codigo Trabajador </td>
    <td width="265"><input name="txtcod_trabajador" type="text" id="txtcod_trabajador"></td>
  </tr>
  <tr>
  	<td width="61">
    <td>Codigo Perfil </td>
    <td><label>
	
<?
$sql= "select * from Tra_M_Perfil ";
$rs=sqlsrv_query($cnx,$sql);


	?>
      <select name="txtcod_perfil" id="txtcod_perfil">
	  <? while ($Rs=sqlsrv_fetch_array($rs)){
	   	
			echo "<option value=".$Rs[cTipoPerfil]." >".$Rs[cDescPerfil]."</option>";
			
	   }?>
      </select>
      </label></td>
  </tr>
  <tr>
  	<td width="61">
    <td>Nombre de Usuario</td>
    <td><input name="txtusuario" type="text" id="txtusuario"></td>
  </tr>
  <tr>
  	<td width="61">
    <td>Password</td>

    <td><label>
      <input name="txtpassword" type="text" id="txtpassword">
    </label></td>
  </tr>
  <tr>
  	<td width="61">
    <td>Fecha de Creacion </td>
    <td><input name="txtfech_creacion" type="text" id="txtfech_creacion"  value="<?  echo date("Y-m-d")." ".date("h:i:s");?>"></td>
  </tr>
  <tr>
  	<td width="61">
    <td>Estado</td>
    <td><label>
      <select name="txtestado" id="txtestado">
	  <option value=1 selected>Activo</option>
	  <option value=0 selected>Inactivo</option>  
	  </select>
      </label></td>
  </tr>
  
    <tr>
    <td align="center" colspan="3"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="CREA USUARIO"></td>
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