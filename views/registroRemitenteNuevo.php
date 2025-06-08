<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Seleccion remitente
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script Language="JavaScript">
<!--
function activaNatural(){
document.frmRegistro.tipoRemitente.value=1;
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
document.frmRegistro.submit();
return false;
}

function activaEmpresa(){
document.frmRegistro.tipoRemitente.value=2;
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
document.frmRegistro.submit();
return false;
}


function releer(){
  document.frmRegistro.method="GET";
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmRegistro.submit();
}

function NuevoRemitente()
{
  if (document.frmRegistro.txtnom_remitente.value.length == "")
  {
    alert("Ingrese Nombre o Raz�n Social");
    document.frmRegistro.txtnom_remitente.focus();
    return (false);
  }
  document.frmRegistro.method="POST";
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}
 
//--></script>
</head>
<body>
 
<table width="500" height="300" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
<tr>
<td align="left" valign="top">

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

<div class="AreaTitulo">Nuevo Remitente:</div>	
<table cellpadding="0" cellspacing="0" border="0" width="520">
<tr>
			<form name="frmRegistro">
			<input type="hidden" name="opcion" value="10">
			<input type="hidden" name="cCodTipoDoc" value="<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>">
			<input type="hidden" name="fFecDocumento" value="<?=$_GET['fFecDocumento']?>">
			<input type="hidden" name="cNroDocumento" value="<?=$_GET['cNroDocumento']?>">
			<input type="hidden" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>">
			<input type="hidden" name="cObservaciones" value="<?=$_GET[cObservaciones]?>">
			<input type="hidden" name="iCodTupaClase" value="<?=$_GET[iCodTupaClase]?>">
			<input type="hidden" name="iCodTupa" value="<?=$_GET['iCodTupa']?>">
			<input type="hidden" name="cReferencia" value="<?=$_GET[cReferencia]?>">
			<input type="hidden" name="iCodOficinaResponsable" value="<?=$_GET[iCodOficinaResponsable]?>">
			<input type="hidden" name="iCodTrabajadorResponsable" value="<?=(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')?>">
			<input type="hidden" name="iCodIndicacion" value="<?=$_GET[iCodIndicacion]?>">
			<input type="hidden" name="nNumFolio" value="<?=$_GET[nNumFolio]?>">
			<input type="hidden" name="nFlgEnvio" value="<?=$_GET[nFlgEnvio]?>">
			<input type="hidden" name="cNomRemite" value="<?=$_GET[cNomRemite]?>">
			<input type="hidden" name="nFlgClaseDoc" value="<?=$_GET[nFlgClaseDoc]?>">
			<?
			if($_GET[tipoRemitente]==1) $ValortipoRemitente=1;
			if($_GET[tipoRemitente]==2) $ValortipoRemitente=2;
			?>
			<input type="hidden" name="tipoRemitente" value="<?=$ValortipoRemitente?>">
<td class="FondoFormRegistro">
<?
require_once("../conexion/conexion.php");
?>
		<table border="0">
    <tr>
    <td width="100" >Tipo Persona:</td>
    <td align="left">
    			<table><tr>
					<td><input type="radio" name="radioNatural" onclick="activaNatural();" <?php if($_GET[tipoRemitente]==1) echo "checked"?>> Persona Natural</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="radio" name="radioEmpresa" onclick="activaEmpresa();" <?php if($_GET[tipoRemitente]==2) echo "checked"?>> Persona Jur�dica</td>
					</tr></table>
		</td>
    </tr>
    
    <tr>
    <td width="100" >
    		<?
    		if($_GET[tipoRemitente]==1 OR $_GET[tipoRemitente]=="") echo "Nombre:";
    		if($_GET[tipoRemitente]==2) echo "Razon Social:";
    		?>	
    </td>
    <td align="left"><input name="txtnom_remitente" style="text-transform:uppercase" type="text" value="<?=$_GET[txtnom_remitente]?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
    </tr>
    
    <tr>
    <td width="100" >Documento:</td>
    <td align="left">
    		<select name="cTipoDocIdentidad" class="FormPropertReg form-control" id="cTipoDocIdentidad"  />
				<option value="">Seleccione:</option>
	      <?
	      $sqlDoc="SELECT * FROM Tra_M_Doc_Identidad"; 
    		$rsDoc=sqlsrv_query($cnx,$sqlDoc);
	      while ($RsDoc=sqlsrv_fetch_array($rsDoc)){
	  	  if($RsDoc["cTipoDocIdentidad"]==$_GET[cTipoDocIdentidad]){
        	$selecClas="selected";
        }Else{
          $selecClas="";
        }
        	echo "<option value=\"".$RsDoc["cTipoDocIdentidad"]."\" ".$selecClas.">".$RsDoc["cDescDocIdentidad"]."</option>";
        }
        sqlsrv_free_stmt($rsDoc);
        ?>
		    </select>
		</td>
		</tr>
		
    <tr>
    <td >N&ordm; Documento:</td>
    <td  align="left"><input name="txtnum_documento" type="text" value="<?=$_GET[txtnum_documento]?>" size="20" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></td>
    </tr>
    
    <tr>
    <td >Direcci�n:</td>
    <td  align="left"><input name="txtdirec_remitente" type="text" value="<?=$_GET[txtdirec_remitente]?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
    </tr>
    
    <tr>
    <td >E-mail:</td>
    <td align="left"><input name="txtmail" type="text" id="txtmail" value="<?=$_GET[txtmail]?>" size="40" class="FormPropertReg form-control"></td>
    </tr>
    
    <tr>
    <td >Telefono:</td>
    <td align="left"><input name="txtfono_remitente" type="text" value="<?=$_GET[txtfono_remitente]?>" size="15" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></td>
    </tr>
    
    <tr>
    <td >Fax:</td>
    <td align="left"><input name="txtfax_remitente" type="text" value="<?=$_GET[txtfax_remitente]?>"  size="15" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></td>
    </tr>
    
    <tr>
    <td >Departamento:</td>
    <td align="left">
				<select name="cCodDepartamento" class="FormPropertReg form-control" id="cCodDepartamento" style="width:236px" onChange="releer();"/>
				<option value="">Seleccione:</option>
				<?
        $sqlDep="select * from Tra_U_Departamento "; 
        $rsDep=sqlsrv_query($cnx,$sqlDep);
				while ($RsDep=sqlsrv_fetch_array($rsDep)){
	  	  		if($RsDep["cCodDepartamento"]==$_GET[cCodDepartamento]){
          			$selecClas="selected";
						}else{
          			$selecClas="";
						}
            echo "<option value=".$RsDep["cCodDepartamento"]." ".$selecClas.">".$RsDep["cNomDepartamento"]."</option>";
				}
        sqlsrv_free_stmt($rsDep);
        ?>
				</select>
		</td>
    </tr>
    
    <tr>
    <td >Provincia:</td>
    <td align="left">
    		<select name="cCodProvincia"  class="FormPropertReg form-control" id="cCodProvincia" onChange="releer();" style="width:236px" <?php if($_GET[cCodDepartamento]=="") echo "disabled"?> >
     	  <option value="">Seleccione:</option>
    		<?
        $sqlPro="SELECT * from Tra_U_Provincia WHERE cCodDepartamento='$_GET[cCodDepartamento]' ";
        $rsPro=sqlsrv_query($cnx,$sqlPro);
				while ($RsPro=sqlsrv_fetch_array($rsPro)){
	  	  		if($RsPro["cCodProvincia"]==$_GET[cCodProvincia]){
          			$selecClas="selected";
						}else{
          			$selecClas="";
						}
            echo "<option value=".$RsPro["cCodProvincia"]." ".$selecClas.">".$RsPro["cNomProvincia"]."</option>";
				}
        sqlsrv_free_stmt($rsPro);
			  ?>
				</select>
		</td>
    </tr>
    
    <tr>
    <td >Distrito:</td>
    <td align="left">
    		<select name="cCodDistrito" class="FormPropertReg form-control" id="cCodDistrito" style="width:236px" <?php if($_GET[cCodProvincia]=="" || $_GET[cCodDepartamento]=="" ) echo "disabled"?> />
				<option value="">Seleccione:</option>
    		<?
        $sqlDis="SELECT * from Tra_U_Distrito WHERE cCodDepartamento='$_GET[cCodDepartamento]' AND cCodProvincia='$_GET[cCodProvincia]'"; 
        $rsDis=sqlsrv_query($cnx,$sqlDis);
				while ($RsDis=sqlsrv_fetch_array($rsDis)){
	  	  		if($RsDis["cCodProvincia"]==$_POST[cCodProvincia]){
          		$selecClas="selected";
          	}else{
          		$selecClas="";
          	}
            echo "<option value=".$RsDis["cCodDistrito"]." ".$selecClas.">".$RsDis["cNomDistrito"]."</option>";
				}
				sqlsrv_free_stmt($rsDis);
        ?>
				</select>
		</td>
    </tr>
            
    <tr>
    <td >Representante:</td>
    <td align="left"><input name="txtrep_remitente" type="text" id="txtrep_remitente" value="<?=$_GET[txtrep_remitente]?>" size="40" class="FormPropertReg form-control" style="text-transform:uppercase"></td>
    </tr>
		 
    <tr>
    <td >Estado:</td>
    <td align="left">
  			<select name="txtflg_estado" id="txtflg_estado" class="FormPropertReg form-control">
    		<option value="1" <?php if($_GET[txtflg_estado]==1) echo "selected"?>>Activo</option>
    		<option value="2" <?php if($_GET[txtflg_estado]==2) echo "selected"?>>Inactivo</option>
    		</select>
		</td>
		</tr>
    
    <tr>
    <td colspan="2" align="center">
                <input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="NuevoRemitente();">
		</td>
    </tr>
    </table>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

</form>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>