<?
require_once("../conexion/conexion.php");
require_once("../models/ad_busqueda.php");

?>

<form action="../controllers/ln_actualiza_tipo_doc.php" method="post" name="form1">

<table width="500" border="0" bgcolor="#6699FF" align="center">
  <tr>
    <td colspan="2" class="style1" align="center">Actualiza Tipo de Documento </td>
    
  </tr>
  <tr>
    <td width="227">Descripcion del tipo de Documento </td>
    <td width="263"><label>
      
      <input name="textdesc_doc" type="text" id="textdesc_doc" value="<?php echo $Rs['cDescTipoDoc']; ?>" size="30">
    </label></td>
  </tr>
  <tr>
    <td>Sigla del Documento </td>
    <td><input name="txtsigla_doc" type="text" id="txtsigla_doc" value="<?php echo $Rs[cSiglaDoc]; ?>"></td>
  </tr>
  <tr>
    <td>Numero Correlativo del Documento </td>
    <td><input name="txtnum_corr" type="text" id="txtnum_corr" value="<?php echo $Rs[nNumCorrelativo]; ?>"></td>
  </tr>
  <tr>
    <td>Flg de Entrada </td>
    <td><label>
      <select name="txtflgentrada" id="txtflgentrada">
	  <?
	  	if($Rs[nFlgEntrada]==1){
			echo "<option value=1 selected>Activo</option>";
		}
		else{
			echo "<option value=1 >Activo</option>";
		}
		if($Rs[nFlgEntrada]==0){
			echo "<option value=0 selected>Inactivo</option>";
		}
		else{
			echo "<option value=0 >Inactivo</option>";
		}
		
	  ?>
      </select>
      </label></td>
  </tr>
  <tr>
    <td>Flg Interno </td>
    <td><label>
      <select name="txtflginterno" id="txtflginterno">
	  <?
	  	if($Rs[nFlgInterno]==1){
			echo "<option value=1 selected>Activo</option>";
		}
		else{
			echo "<option value=1 >Activo</option>";
		}
		if($Rs[nFlgEntrada]==0){
			echo "<option value=0 selected>Inactivo</option>";
		}
		else{
			echo "<option value=0 >Inactivo</option>";
		}
		
	  ?>
	  
      </select>
      </label></td>
  </tr>
  <tr>
    <td align="center"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="CREA TIPO DOCUMENTO"></td>
    </tr>
</table>
 <input name="txtcod_tipo_doc" type="hidden" id="txtcod_tipo_doc" value="<?php echo $Rs[cCodTipoDoc]; ?>">
</form>