<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_nuevo_corre_trab.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Mantenimiento de la Tabla Maestra Correlativos para el Perfil Administrador
          -> Crear Registro de correlativo interno
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creaci�n del programa.
 
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

<div class="AreaTitulo">Maestra correlativos - Profesional</div>

<?
require_once("../models/ad_busqueda.php");
?>


<form action="../controllers/ln_actualiza_correlativo.php" onSubmit="return validar(this)" method="post" name="frmCorrelativo">
<input type="hidden" name="opcion" value="6">

  <tr>
      <td colspan="4">
            <fieldset id="tfa_Datos" class="fieldset"  >
            <legend class="legend">Datos de Oficina</legend>
        <table border="0">
          <tr>
              <td width="85"></td>
              <td width="111" >Oficina:</td>
              <td width="373"  align="left">
              <select name="iCodOficina" class="FormPropertReg form-control" style="width:350px" onchange="releer()" />
                    <option value="">Seleccione:</option>
            <?
	                 $sqlOfi=" SP_OFICINA_LISTA_COMBO "; 
                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                 while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodOficina"]==$_REQUEST['iCodOficina']){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?></td>
           </tr>
           <tr>
              <td width="85"></td>
              <td width="111" >Trabajador:</td>
              <td width="373"  align="left">
              <select name="iCodTrabajador" class="FormPropertReg form-control" style="width:350px" onchange="releer()" />
                    <option value="">Seleccione:</option>
            <?
	                 $sqlOfi=" SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$_REQUEST['iCodOficina']'  And nFlgEstado=1   ORDER BY iCodCategoria DESC, cNombresTrabajador ASC "; 
                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                 while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodTrabajador"]==$_REQUEST[iCodTrabajador]){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodTrabajador"]." ".$selecClas.">".$RsOfi["cNombresTrabajador"]." ".$RsOfi["cApellidosTrabajador"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?></td>
           </tr>
           <tr>
              <td width="85"></td>
              <td >Tipo de Documento:</td>
              <td width="373"  align="left"><select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
									<option value="">Seleccione:</option>
									<?
									include_once("../conexion/conexion.php");
									$sqlTipo="SP_TIPO_DOCUMENTO_LISTA_CORRELATIVO_P $_REQUEST[iCodTrabajador]";
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
									</select></td>        
           </tr>
           <tr>

              <td >A&ntilde;o:</td>
              <td  align="left">
                             <select name="nNumAno"  class="FormPropertReg form-control" id="iCodUbicacion">
     	                        <option value="2011" selected="selected">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
	                            </select></td>
           </tr>
       
           <tr>
              <td height="46" colspan="3" align="center">
              <button class="btn btn-primary"  type="submit" id="Insert Oficina"   onMouseOver="this.style.cursor='hand'"> <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0"> </button>
              
              ������
				<button class="btn btn-primary" type="button" onclick="window.open('iu_correlativo_profesional.php?iCodOficina=<?=$_REQUEST['iCodOficina']?>&iCodTrabajador=<?=$_REQUEST[iCodTrabajador]?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>              </td>
           </tr>
        </table>
        </fieldset>

       
</form>
</td>
		</tr>
		</table>

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