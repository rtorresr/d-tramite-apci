<?
require_once("../conexion/conexion.php");
require_once("../models/ad_busqueda.php");

?>

<form action="../controllers/ln_actualiza_doc_identidad.php" method="post" name="form1">

<table width="500" border="0" bgcolor="#6699FF" align="center">
  <tr>
    <td colspan="2" class="style1">Actualizar  Documento de Identidad  </td>
    
  </tr>
  
    <td>Documento de Identidad </td>
    <td><input name="txttipo_doc_ident" type="text" id="txttipo_doc_ident" value="<?php echo $Rs[cDescDocIdentidad]; ?>"></td>
  </tr>
  <tr>
    <td align="center"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="ACTUALIZA "></td>
    </tr>
</table>
 <input name="txtcod_doc_ident" type="hidden" id="txtcod_doc_ident" value="<?php echo $Rs[cTipoDocIdentidad]; ?>">
</form>