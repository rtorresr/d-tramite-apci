<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_nuevo_tema.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Mantenimiento de la Tabla Maestra de Temas para el Perfil Administrador
          -> Crear Registro de Tema
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
   if (f.cDesTema.value == "") {
  a += " Ingrese un Tema";
  alert(error + a);
 }
  else if (f.iCodOficina.value == "") {
  a += " Seleccione una Oficina";
  alert(error + a);
 } 
   
 return (a == "");
 
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

<div class="AreaTitulo">Maestra Temas</div>

<form action="../controllers/ln_nuevo_tema.php" onSubmit="return validar(this)" method="post" name="form1">

            <fieldset id="tfa_DatosPersonales" class="fieldset"  >
            <legend class="legend">Datos de Tema</legend>
        <table border="0">
           <tr>
              <td width="75"></td>
              <td width="159" >Tema :</td>
              <td width="15"></td>
              <input name="cDesTema" type="text" maxlength="30"  size="40" class="FormPropertReg form-control" value="<?=$_GET[cDesTema]?>"><?php if($_GET[cDesCategoria]!="") echo "Categoria existente"?></td>
           </tr>
         <?php if($_SESSION['iCodPerfilLogin']==1){ ?>  
           <tr>
              <td width="75"></td>
              <td width="159" >Oficina :</td>
              <td width="15"></td>
              <td width="420" align="left">
                 <select name="iCodOficina" class="FormPropertReg form-control" style="width:360px" />
     	            <option value="">Seleccione:</option>
	              <? 
	                 $sqlOfi="SP_OFICINA_LISTA_COMBO "; 
                     $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                 while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	             if($RsOfi["iCodOficina"]==$_GET['iCodOficina']){
												$selecClas="selected";
          	         }Else{
          		      		$selecClas="";
                     }
                   	 echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                     }
                     sqlsrv_free_stmt($rsOfi);
                  ?>
            </select></td>
           </tr>
          <?php }
		  else { ?>  
			<input name="iCodOficina" type="hidden"  value="<?=$_SESSION['iCodOficinaLogin']?>">  
		 <?php }?>
           <tr>
               <td height="36" colspan="4" align="center">
               <button class="btn btn-primary"  type="submit" id="Insert Tema" onMouseOver="this.style.cursor='hand'"> <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0"> </button>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="btn btn-primary" type="button" onclick="window.open('iu_tema.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
             </td>
           </tr>
        </table>
        </fieldset>
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


<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>

