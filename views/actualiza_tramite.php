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
	
	<?php
	    $sql= "select * from Tra_M_Tramite where iCodTramite='".$_GET['id']."'";
	    $query=sqlsrv_query($cnx,$sql);
	    $rs=sqlsrv_fetch_array($query);
	    do{
            $flg=$rs['nFlgTipoDoc'];
            if($flg==2){
                $a1=$rs['cCodificacionI'];
            }else{
                $a1=$rs['cCodificacion'];
            }
	        
	    }while($rs=sqlsrv_fetch_array($query));
	?>
	
   <a href="tramite_elimina.php">[Regresar]</a>
    <hr>
    <table>
        <tr>
            <td>cCodificacion Interno:</td>
            <td><input type="text" name="" value="<?php echo $a1;?>" readonly></td>

            <td>Trabajador registro:</td>
            <td><input type="text" name="" value="<?php echo $a2;?>" readonly></td>
        </tr>
        <tr>





        </tr>
        <tr>





        </tr>
    </table>
    
    <table border="1">
        <tr>
            <td>Cod Movimiento</td>
            <td>Trabajador Registro</td>
            <td>Tipo doc. flag</td>
            <td>Cod Oficina Origen</td>
            
            <td>estado movimiento</td>
            <td>Cod oficina derivar</td>
            <td>cod Trabajador derivar</td>
            <td>cod indicacion <derivar></derivar></td>
            <td>asunto derivar</td>
            <td>observaci.. derivar</td>
            <td>cod trabaj. delegado</td>
            <td>flag envio</td>
            <td>op1</td>
            <td>op2</td>
        </tr>
        <?php
            $sql= "select * from Tra_M_Tramite_Movimientos where iCodTramite='".$_GET['id']."'";
            $query=sqlsrv_query($cnx,$sql);
            $rs=sqlsrv_fetch_array($query);
            do{
        ?>
           <tr>
            <td><?php echo $rs[iCodMovimiento];?></td>
            <td><?php echo $rs[iCodTrabajadorRegistro];?></td>
            <td><?php echo $rs[nFlgTipoDoc];?></td>
            <td><?php echo $rs[iCodOficinaOrigen];?></td>
            
            <td><?php echo $rs['nEstadoMovimiento'];?></td>
            <td><?php echo $rs[iCodOficinaDerivar];?></td>
            <td><?php echo $rs[iCodTrabajadorDerivar];?></td>
            <td><?php echo $rs[iCodIndicacionDerivar];?></td>
            <td><?php echo substr($rs[cAsuntoDerivar],0,10)."...";?></td>
            <td><?php echo $rs[cObservacionesDerivar];?></td>
            <td><?php echo $rs['iCodTrabajadorDelegado'];?></td>
            <td><?php echo $rs[nFlgEnvio];?></td>
            <td>Editar</td>
            <td>
            
            <?php
                if($rs[iCodMovimiento]!=''){
            ?>
            <a href="eliminar_movi.php?idmov=<?php echo $rs[iCodMovimiento];?>&id=<?php echo $_GET['id'];?>">Eliminar</a>
            <?php
                }
            ?>
            </td>
        </tr>
        <?php
            }while($rs=sqlsrv_fetch_array($query));
        ?>
    </table>
	
	
	
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