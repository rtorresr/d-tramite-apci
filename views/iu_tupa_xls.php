<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_tupa_xls.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte general en EXCEL  de la Tabla de Tupas
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   Larry Ortiz        05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
include_once("../conexion/conexion.php");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=iu_tupa_xls.xls");

    $anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
    echo "<table width=780 border=0><tr><td align=center colspan=6>";
	echo "<H3>REPORTE - TUPAS</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=6>";
	echo "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
		
	echo "<table width=780 border=0><tr><td align=left colspan=6>";
	$sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='".$_GET['traRep']."' ";
	$rslog=sqlsrv_query($cnx,$sqllog);
	$Rslog=sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog['cNombresTrabajador']." ".$Rslog['cApellidosTrabajador'];
	echo " ";
?>

<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">CLASE TUPA</th>
                <th style="width: 35%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">NOMBRE TUPA</th>
                <th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DIAS</th>
                <th style="width: 15%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">OFICINA</th>
                <th style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ESTADO</th>
           	</tr>
		</thead>
		<tbody>
<?php
    /*$sql=" SELECT * FROM  Tra_M_Tupa,Tra_M_Oficinas,Tra_M_Tupa_Clase ";
    $sql.=" WHERE Tra_M_Tupa.iCodOficina=Tra_M_Oficinas.iCodOficina AND Tra_M_Tupa.iCodTupaClase=Tra_M_Tupa_Clase.iCodTupaClase ";
    if($_GET[cNomTupa]!=""){
    $sql.=" AND Tra_M_Tupa.cNomTupa like '%$_GET[cNomTupa]%' ";
    }
    if($_GET[iCodTupaClase]!=""){
    $sql.=" AND Tra_M_Tupa.iCodTupaClase='$_GET[iCodTupaClase]' ";
    }
	if($_GET[txtestado]!=""){
    $sql.=" AND Tra_M_Tupa.nEstado='$_GET[txtestado]' ";
    }
    $sql.="ORDER BY Tra_M_Tupa.iCodTupa ASC";*/

	$sql="SP_TUPA_LISTA '".$_GET['iCodTupaClase']."','%".$_GET['cNomTupa']."%','".$_GET['txtestado']."' , '".$_GET['orden']."','".$_GET['campo']."' ";
    $rs=sqlsrv_query($cnx,$sql);
    //echo $sql;

    while ($Rs=sqlsrv_fetch_array($rs)){
?>      
		<tr>
        <td style="width: 15%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cNomTupaClase'];?></td>
        <td style="width: 35%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cNomTupa'];?>
        </td>
        <td style="width: 15%; text-align: center; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['nDias'];?></td>
        <td style="width: 15%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cNomOficina'];?>
        </td>
        <td style="width: 10%; border: solid 1px #6F6F6F;font-size:10px" >
    <?php
    if($Rs['nEstado']==1){
    		echo "<div style=color:#005E2F;text-align:center>Activo</div>";
        }else{
    		echo "<div style=color:#950000;text-align:center>Inactivo</div>";
     }
	?>
        </td>	
        </tr>
	<?php
        }
    ?>
	   	
      </tbody>
	</table>