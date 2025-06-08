<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_nuevo_corre_sal.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Mantenimiento de la Tabla Maestra Correlativos para el Perfil Administrador
          -> Crear Registro de correlativo interno
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<script>
function validar(f) {
 var error = "Por favor, antes de crear complete:\n\n";
 var a = "";
  if (f.iCodOficina.value == "") {
  a += " Ingrese una Oficina";
  alert(error + a);
 }
 else if (f.cCodTipoDoc.value == "") {
  a += " Ingrese un Documento";
  alert(error + a);
 }  
 return (a == "");
}
function releer(){
  document.frmCorrelativo.action="<?=$_SERVER['PHP_SELF']?>#area";
  document.frmCorrelativo.submit();
}
</script>
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

<div class="AreaTitulo">Maestra correlativos - SALIDAS</div>

<?
require_once("../models/ad_busqueda.php");
?>


<form action="cst_actualiza_correlativo.php" onSubmit="return validar(this)" method="post"  name="frmCorrelativo">
<input type="hidden" name="opcion" value="4">

  <tr>
      <td colspan="4">
            <fieldset id="tfa_Datos" class="fieldset"  >
            <legend class="legend">Datos de Oficina</legend>
        <table border="0">
           <tr>
              <td width="85"></td>
              <td width="111" ></td>
              <td width="373"  align="left">
                  <input type="hidden" name="iCodOficina" value="<?php echo $_SESSION['iCodOficinaLogin'];?>">
                  </td>
           </tr>
           <tr>
              <td width="85"></td>
              <td >Tipo de Documento:</td>
              <td width="373"  align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
									include_once("../conexion/conexion.php");
									$sqlTipo="SP_TIPO_DOCUMENTO_LISTA_CORRELATIVO_S $_REQUEST['iCodOficina']";
          				$rsTipo=sqlsrv_query($cnx,$sqlTipo);
          				while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          					if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
          						$selecTipo="selected"; 
          					}Else{
          						$selecTipo="";
          					}
          				echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          				}
          				sqlsrv_free_stmt($rsTipo);
									?>
									</select>
      
          </td>        
           </tr>
           <tr>

              <td >A&ntilde;o:</td>
              <td  align="left">
                             <select name="nNumAno"  class="FormPropertReg form-control" id="iCodUbicacion">
                                <option value="2017" selected="selected">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
	                            </select></td>
           </tr>
       
           <tr>
              <td height="46" colspan="3" align="center">
              <button class="btn btn-primary"  type="submit" id="Insert Oficina"   onMouseOver="this.style.cursor='hand'"> <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0"> </button>
                  
                <button class="btn btn-primary" type="button" onclick="window.open('cst_correlativo_salida.php?iCodOficina=<?=$_GET['iCodOficina']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>              </td>
           </tr> 
        </table>
        </fieldset>

       
</form>


<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>