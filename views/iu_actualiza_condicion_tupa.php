<?
require_once("../conexion/conexion.php");
require_once("../models/ad_busqueda.php");
?>
<form action="../controllers/ln_actualiza_condicion_tupa.php" method="post" name="form1">
<input type="hidden" name="cCodDetTupa" value="<?=$Rs[cCodDetTupa]?>">
<input type="hidden" name="cCodTupa" value="<?=$Rs[cCodTupa]?>">
<table width="600" border="0" bgcolor="#6699FF" align="center">
  <tr>
    <td colspan="2" class="style1"><div align="center">Crea Requisitos deTupa</div></td>
  </tr>
  <tr>
    <td>Requisito de Tupa </td>
    <td><label>
      <textarea name="cDesDetTupa" id="cDesDetTupa"><?=$Rs[cDesDetTupa]?></textarea>
    </label></td>
  </tr>
  <tr>
    <td>Obligatorio</td>
    <td>
	  
	  <select name="nFlgObligatorio" id="nFlgObligatorio">
	  <?php if ($Rs[nFlgObligatorio]==1){
	  	echo "<option value=1 selected>Obligatorio</option> ";
		}
		else{
		echo "<option value=1 >Obligatorio</option> ";
		}
        if ($Rs[nFlgObligatorio]==0){
	  	echo "<option value=0 selected>No Obligatorio</option> ";
		}
		else{
		echo "<OPTION value=0>NO Obligatorio</OPTION> ";
		}
	  ?>
	  </select>
	  
	  

    <td colspan="2"><input name="Insert Trabajador2" type="submit" id="Insert Trabajador2" value="CREAR REQUISITO"></td>
    </tr>
</table>

</form> 
