<?php session_start();
ini_set('date.timezone', 'America/Lima');
if($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<script Language="JavaScript">
<!--

function Agregar()
{
	if (formAdd.iCodPerfil.value.length == "")
  {
    alert("Seleccione Perfil");
    formAdd.iCodPerfil.focus();
    return (false);
  }
	if (formAdd.cNombreMenu.value.length == "")
  {
    alert("Ingrese Nombre de nuevo Menu");
    formAdd.cNombreMenu.focus();
    return (false);
  }
  document.formAdd.submit();
}


function Ordenar()
{
  document.formulario.submit();
}

//--></script>
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

<div class="AreaTitulo">Mantenimiento >> M. Calendario</div>

		
		
		
		
<?php
    function cero($num){
    if(strlen($num)==1){
        return "0".$num;
    }else{
        return $num;
    }
}
    
function fecha($fecha){
    $a=explode(" ",$fecha);
    $b=$a[0];
    //return $b;
    // -----
    $aa=explode("-",$b);
    $bb=cero($aa[0])."-".cero($aa[1])."-".$aa[2];
    return $bb;
}
    
function saber_dia($nombredia) {
$dias = array('', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');
$fecha = $dias[date('N', strtotime($nombredia))];
return $fecha;
}
?>
		

<form autocomplete="off" name="" method="get" action="calendario.php">
<table>
    <tr>
        <td>A&ntilde;o</td>
        <td>Mes</td>

    </tr>
    <tr>
        <td>
            <select name="anio">
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
            </select>
        </td>
        <td>
            <select name="mes">
                <?php
                    for($xx=1;$xx<=12;$xx++){
                ?>
                   <option value="<?php echo cero($xx);?>"><?php echo cero($xx);?></option>
                <?php
                    }
                ?>
            </select>
        </td>
        <td>
            <input type="submit" value="Buscar">
        </td>
    </tr>
</table>
</form>
            
<hr>
            

  
<?
/*$sql= "SELECT * FROM Tra_M_Perfil,Tra_M_Menu WHERE Tra_M_Perfil.cTipoPerfil=Tra_M_Menu.iCodPerfil ORDER BY Tra_M_Perfil.cDescPerfil,  Tra_M_Menu.nNombreOrden ASC ";*/
    
    if($_GET['anio']!='' and $_GET['mes']!=''){
        $anio_=$_GET['anio']."-".$_GET['mes']."-01";  // año-mes-dia || año-dia-mes
        $sql= "select * from T_MAE_CALENDARIO where 
                Month(dfecha_calendario) = Month('".$anio_."')
                AND Year(dfecha_calendario) = Year('".$anio_."')
                order by dfecha_calendario asc";
    }else{
        $sql= "select * from [dbo].[T_MAE_CALENDARIO] order by dfecha_calendario asc";
    }

$rs=sqlsrv_query($cnx,$sql);
//echo $sql;


?>
	<input type="hidden" name="opcion" value="4"> 
<tr>
	<td class="headCellColum">Fecha</td>
	<td class="headCellColum">Dia</td>
	<td class="headCellColum">Estado</td>
	</tr>
	<?
    
    if($_GET['anio']!='' and $_GET['mes']!=''){
        while ($Rs=sqlsrv_fetch_array($rs)){
                if ($color == "#CEE7FF"){
                  $color = "#F9F9F9";
            }else{
                  $color = "#CEE7FF";
            }
            if ($color == ""){
                    $color = "#F9F9F9";
            }	
        ?>
        <tr bgcolor="<?=$color?>">
            <td><?php echo fecha($Rs['dfecha_calendario']);?></td>
            <td>
               <?php
                   if($Rs['nutil']==1){
                       echo "<font color='red'><b>".saber_dia(fecha($Rs['dfecha_calendario']))."</b></font>";
                   }else{
                       echo saber_dia(fecha($Rs['dfecha_calendario']));
                   }
               ?>
            </td>
            <td>
            <?php
                if($Rs['nutil']==0){
                    $men="Laborable";
                    $estado=0;
                }else{
                    $men="No Laborable";
                    $estado=1;
                }
            ?>
            <a href="datacalendario.php?id=<?php echo fecha($Rs['dfecha_calendario']);?>&estado=<?php echo $estado;?>&anio=<?php echo $_GET['anio']?>&mes=<?php echo $_GET['mes']?>"> <?php echo $men;?> </a>
            </td>
        </tr>
        <?
        $Perfil=$Rs[cDescPerfil];
        }
    }else{
        echo "<tr>";
        echo "<td colspan='3'> vacio</centere></td>";
        echo "</tr>";
    }
?>
	

	



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