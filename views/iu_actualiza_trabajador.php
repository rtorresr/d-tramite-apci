<?php
require_once("../conexion/conexion.php");
require_once("../models/ad_busqueda.php");

?>
<form action="../controllers/ln_actualiza_trabajador.php" method="post" name="form1">
  <table width="600" border="0" bgcolor="#6699FF" align="center">
    <tr>
      <td colspan="2" class="style1"><div align="center">Actualisacion de Datos </div></td>
    </tr>
    <tr>
      <td width="236">Codigo Oficina</td>
      <td width="354">
        <label>
		<?
$sql1= "select * from Tra_M_Dependencias ";
$rs1=sqlsrv_query($cnx,$sql1);
	?>
        <select name="txtcod_oficina" id="txtcod_oficina">
				<? while ($Rs1=sqlsrv_fetch_array($rs1)){
	   				if($Rs[cCodOficina]==$Rs1[cCodOficina]){
						echo "<option value=".$Rs1[cCodOficina]." selected>".$Rs1[cNomOficina]."</option>";
						}
					else{
						echo "<option value=".$Rs1[cCodOficina]." >".$Rs1[cNomOficina]."</option>";
						}
			
	   }?>
		
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Nombre de trabajador</td>
      <td><input name="txtnom_trabajador" type="text" id="txtnom_trabajador" value="<?php echo $Rs[cNombresTrabajador]; ?>" /></td>
    </tr>
    <tr>
      <td>Apellido Trabajador</td>
      <td><input name="txtape_trabajador" type="text" id="txtape_trabajador" value="<?php echo $Rs[cApellidosTrabajador]; ?>" /></td>
    </tr>
    <tr>
      <td>Tipo de documento de Identidad</td>
      <td><select name="tipo_doc" id="tipo_doc">
          <?
    if($Rs[cTipoDocIdentidad]==01){	
			echo "<option value='02' selected>DNI</option>";
		}
		else{
			echo "<option value='02' >DNI</option>";
		}
		if($Rs[cTipoDocIdentidad]==02){	
			echo "<option value='02' selected>Libreta Militar</option>";
		}
		else{
			echo "<option value='02' >Libreta Militar</option>";
		}
		if($Rs[cTipoDocIdentidad]==03){	
			echo "<option value='03' selected>CARNET DE EXTRANGERIA</option>";
		}
		else{
			echo "<option value='03' >CARNET DE EXTRANGERIA</option>";
		}
		
     ?>
      </select></td>
    </tr>
    <tr>
      <td>Nro Documento</td>
      <td><input name="txtnum_doc_identidad" type="text" id="txtnum_doc_identidad" value="<?php echo $Rs[cNumDocIdentidad]; ?>" /></td>
    </tr>
    <tr>
      <td>Direccion</td>
      <td><input name="txtdirec_trabajador" type="text" id="txtdirec_trabajador" value="<?php echo $Rs[cDireccionTrabajador]; ?>" /></td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="txtmail" type="text" id="txtmail" value="<?php echo $Rs[cMailTrabajador]; ?>" /></td>
    </tr>
    <tr>
      <td>Telefono</td>
      <td><input name="txtfono_trabajador" type="text" id="txtfono_trabajador" value="<?php echo $Rs[cTlfTrabajador1]; ?>" /></td>
    </tr>
    <tr>
      <td>Telefono Alternativo</td>
      <td><input name="txtfono_alternativo" type="text" id="txtfono_alternativo" value="<?php echo $Rs[cTlfTrabajador2]; ?>" /></td>
    </tr>
    <tr>
      <td>Flag Estado</td>
      <td><label>
        <select name="txtflg_estado" id="txtflg_estado">
		<?
		if($Rs[nFlgEstado]==1){
			echo "<option value='1' selected>Activo</option>";
		}
		else{
			echo "<option value='1'>Activo</option>";
		}
		
		if($Rs[nFlgEstado]==0){
			echo "<option value='0' selected>Inactivo</option>";
		}
		else{
			echo "<option value='0'>Inactivo</option>";
		}

		?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><div align="left">
        <input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="Actualiza Datos" />        
      </td>
      </td>
    </tr>
  </table>
  <input type="hidden" name="txtcodtraba" value="<?php echo $Rs[cCodTrabajador];?>">
</form>