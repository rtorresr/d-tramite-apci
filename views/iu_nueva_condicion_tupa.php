<form action="../controllers/ln_nueva_condicion_tupa.php" method="post" name="form1">

<table width="600" border="0" bgcolor="#6699FF" align="center">
  <tr>
    <td colspan="2" class="style1"><div align="center">Crea Requisitos deTupa</div></td>
  </tr>
  <tr>
    <td>Codigo Tupa </td>
    <td><input name="txtcodtupa" type="text" id="txtcodtupa" value="<?php echo $_GET[tupa];?>" disabled="disabled">
      <input type="hidden" name="txtcod_tupa" value="<?php echo $_GET[tupa];?>"></td>
  </tr>
  <tr>
    <td>Requisito de Tupa </td>
    <td><label>
      <textarea name="txtrequisito" id="txtrequisito"></textarea>
    </label></td>
  </tr>
  <tr>
    <td>Obligatorio</td>
    <td>
      <select name="sltrec_obligatorio" id="sltrec_obligatorio">
        <option value="1">SI</option>
        <option value="0">NO</option>
      </select>

    <td colspan="2"><input name="Insert Trabajador2" type="submit" id="Insert Trabajador2" value="CREAR REQUISITO"></td>
    </tr>
</table>

</form> 
