<?
require_once("../conexion/conexion.php");
require_once("../models/ad_busqueda.php");

?>

<form action="../controllers/ln_actualiza_usuario.php" method="post" name="form1">

<table width="600" border="0" bgcolor="#6699FF" align="center">
  <tr>
    <td colspan="2" class="style1"><div align="center">Ingrese datos de Trabajador</div></td>
    
  </tr>
  <tr>
    <td>Codigo Trabajador </td>
    <td><input name="txtcod_trabajador" type="text" id="txtcod_trabajador" value="<?php echo $Rs[cCodTrabajador]; ?>"></td>
  </tr>
  <tr>
    <td>Codigo Perfil </td>
    <td><select name="txtcod_perfil" id="txtcod_perfil">
        <? 
			if ($Rs[nCodPerfil]==2){
	  	echo "<OPTION value=2 selected>2</OPTION> ";
		}
		else{
		echo "<OPTION value=2>2</OPTION> ";
		}
        if ($Rs[cTipoPerfil]==5){
	  	echo "<OPTION value=5 selected>5</OPTION> ";
		}
		else{
		echo "<OPTION value=5>5</OPTION> ";
		}
	   ?>
            </select>
			
					
			
			</td>
  </tr>
  <tr>
    <td>Nombre de Usuario</td>
    <td><input name="txtusuario" type="text" id="txtusuario" value="<?php echo $Rs[cUsuario]; ?>"></td>
  </tr>
  <tr>
    <td>Password</td>

    <td><label>
      <input name="txtpassword" type="text" id="txtpassword" value="<?php echo $Rs[cPassword]; ?>">
    </label></td>
  </tr>
  <tr>
    <td>Fecha de Creacion </td>
    <td><input name="txtfech_creacion" type="text" id="txtfech_creacion"  value="<?php echo $Rs[fFecCreacion]; ?>"></td>
  </tr>
  <tr>
    <td>Estado</td>
    <td><select name="txtestado" id="txtestado">
        <? 
			if ($Rs[nFlgEstado]==1){
	  	echo "<OPTION value=1 selected>Activo</OPTION> ";
		}
		else{
		echo "<OPTION value=1>Activo</OPTION> ";
		}
        if ($Rs[nFlgEstado]==0){
	  	echo "<OPTION value=0 selected>Inactivo</OPTION> ";
		}
		else{
		echo "<OPTION value=0>Inactivo</OPTION> ";
		}
	   ?>
	   
	   
	    
      </select></td>
  </tr>
  
    <tr>
    <td align="center"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="Actualizar Datos"></td>
    </tr>
</table>
<input type="hidden" name="txtcodusuario" value="<?php echo $Rs[cCodUsuario];?>">

</form>

