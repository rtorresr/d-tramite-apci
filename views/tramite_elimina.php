<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
	$fFechaHora = date("d-m-Y  G:i");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php"); ?>
<script language="Javascript">
	var ventana;
	function crearVentana() {
  	ventana = window.open("registroConCluidoPrint.php?nCodBarra=<?=$_POST[nCodBarra]?>&cCodificacion=<?=$_POST[cCodificacion]?>&cPassword=<?=$_POST[cPassword]?>&fFechaHora=<?=$fFechaHora?>&cDescTipoDoc=<?=$_POST['cDescTipoDoc']?>","nuevo","width=330,height=240");
    setTimeout(cerrarVentana,6000);
	}

function cerrarVentana(){
  ventana.close();
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

<div class="AreaTitulo">Tramite / movimiento</div>	
	<!--/*
	    ////////////////////////////////////////////////////////////////////////////////////
	*/-->
	<br>
	<form action="tramite_elimina.php" method="post">
	<table>
	    <tr>
	        <td><b>Tramite:</b> <input type="text" name="tramite" style="width=500px;" value="<?php echo $_POST['tramite'];?>" size="60" maxlength="60"></td>
	         <td>
           <?php
               if($_POST['tipo']==2){
                   $act1='selected';
                   $act2='';
               }else if($_POST['tipo']==1){
                   $act1='';
                   $act2='selected';
               }else{
                    $act1='selected';
                   $act2='';
               }
           ?>
            <select class="select2" name='tipo'> 
                <option value="2" <?php echo $act1;?>>Interno</option> 
                 <option value="1" <?php echo $act2;?>>Salida</option>
            </select>
            </td>
	        <td><input type="submit" value="Buscar"></td>
	    </tr>
	</table>
	</form>
	<hr>
	
	
	
	<?php
	    if($_POST['tramite']!=''){
	?>
	
	<table width='100%'>
	 <tr>
	        <td width='20%'>Codigo</td>
	        <td>tramite</td>
	        <td width='10%'></td>
	        <td width='10%'></td>
	    </tr>
        <?php
            $tipo=$_POST['tipo'];
            if($tipo==2){
                $msg="cCodificacionI='".$_POST['tramite']."'";
            }else if($tipo==1){
                $msg="cCodificacion='".$_POST['tramite']."'";
            }
            $sql= "select * from tra_m_tramite where ".$msg;
            $query=sqlsrv_query($cnx,$sql);
            $rs=sqlsrv_fetch_array($query);
 
            do{
                if($rs['iCodTramite']!=''){
        ?>
          <tr>
           <td><?php echo $rs['iCodTramite'];?></td>
	        <td><?php echo $_POST['tramite'];?></td>
	        <td>
	        <a href='actualiza_tramite.php?id=<?php echo $rs['iCodTramite'];?>'>Editar</a>
	        </td>
	        <td><a href='eliminar_tramite.php?id=<?php echo $rs['iCodTramite'];?>'>Eliminar</a></td>
	        </tr>
        <?php
                }
            }while($rs=sqlsrv_fetch_array($query));

            
        ?>
	</table>
	
	<?php
        }
	?>
	
	
	
	<!--/*
	    ////////////////////////////////////////////////////////////////////////////////////
	*/-->
</div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>