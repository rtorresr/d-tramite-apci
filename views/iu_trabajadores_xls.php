<?php
session_start();
    include_once("../conexion/conexion.php");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=iu_usuarios_xls.xls");

    $anho    = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses   = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	
    echo "<table width=780 border=0><tr><td align=center colspan=7>";
	echo "<H3>REPORTE DE USUARIOS</H3>";
	echo " ";
	
	echo "<table width=780 border=0><tr><td align=right colspan=7>";
	echo "SITDD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo " ";
		
	echo "<table width=780 border=0><tr><td align=left colspan=7>";
	$sqllog = "SELECT cNombresTrabajador, cApellidosTrabajador FROM tra_m_trabajadores WHERE iCodTrabajador=".$_SESSION['CODIGO_TRABAJADOR']; 
	$rslog  = sqlsrv_query($cnx,$sqllog);
	$Rslog  = sqlsrv_fetch_array($rslog);
	echo "GENERADO POR : ".$Rslog['cNombresTrabajador']." ".$Rslog['cApellidosTrabajador'];
?>
<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
    <thead>
        <tr>
            <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">NOMBRES</th>
            <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">APELLIDOS</th>
            <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">CORREO</th>
            <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">PERFIL</th>
            <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">USUARIO</th>
            <th style="width: 8%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ESTADO</th>
    	</tr>
	</thead>
	<tbody>
<?php	
    $sql = "SELECT * FROM Tra_M_Trabajadores
            INNER JOIN Tra_M_Perfil ON  Tra_M_Trabajadores.iCodPerfil=Tra_M_Perfil.iCodPerfil
            WHERE (iCodTrabajador) > 0 AND Tra_M_Trabajadores.ES_EXTERNO = 0 ";
    if($_GET['cNombreTrabajador']!=""){
        $sql.=" AND cNombresTrabajador LIKE '%".$_GET['cNombreTrabajador']."%' ";
    }
    if($_GET['cApellidosTrabajador']!=""){
        $sql.=" AND cApellidosTrabajador LIKE '%".$_GET['cApellidosTrabajador']."%' ";
    }
    if($_GET['cNumDocIdentidad']!=""){
        $sql.=" AND cNumDocIdentidad='".$_GET['cNumDocIdentidad']."' ";
    }
    if($_GET['cTipoDocIdentidad']!=""){
        $sql.=" AND cTipoDocIdentidad='".$_GET['cTipoDocIdentidad']."'";
    }
    if($_GET['iCodPerfil']!=""){
        $sql.=" AND Tra_M_Trabajadores.iCodPerfil='".$_GET['iCodPerfil']."'";
    }
    if($_GET['txtestado']!=""){
        $sql.=" AND nFlgEstado='".$_GET['txtestado']."'";
    }		
    $sql.=" ORDER BY ".$_GET['campo'] . $_GET['orden'];
    echo  error_log("TRABAJADORES ==>".$sql);
    $rs = sqlsrv_query($cnx,$sql);
    
	while ($Rs = sqlsrv_fetch_array($rs)){
?>
    <tr>
        <td style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cNombresTrabajador']);?></td>
        <td style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cApellidosTrabajador']);?></td>
        <td style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cEmail']??'');?></td>
        <td style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cDescPerfil']);?></td>
        <td style="width: 8%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cUsuario']);?></td>
        <td style="width: 8%; text-align: center; border: solid 1px #6F6F6F;font-size:10px" ><?php if($Rs['nFlgEstado']=='1'){ echo "<div style='color:#005E2F'>Activo</div>"; }else{ echo "<div style='color:#950000'>Inactivo</div>"; }?></td>
    </tr>
<?php
    }
?>	   	
    </tbody>
</table>