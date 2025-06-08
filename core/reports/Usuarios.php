<?php
session_start();
include_once("../conexion/conexion.php");

?>
<page backtop="25mm" backbottom="15mm" backleft="10mm" backright="10mm">
    <page_header>
        <br>
        <table style="width: 1000px; border: solid 0px black;">
            <tr>
                <td style="text-align:left;	width: 20px"></td>
                <td style="text-align:left;	width: 980px">
                    <img style="width: 220px" src="images/cab.jpg" alt="Logo">
                </td>
            </tr>
        </table>
        <br><br>
    </page_header>
    <page_footer>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: center;	width: 40%">
                    <?php
                    $sqllog = "SELECT cNombresTrabajador, cApellidosTrabajador FROM tra_m_trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' ";
                    $rslog  = sqlsrv_query($cnx,$sqllog);
                    $Rslog  = sqlsrv_fetch_array($rslog);
                    echo utf8_encode($Rslog['cNombresTrabajador']." ".$Rslog['cApellidosTrabajador']);
                    ?></td>
                <td style="text-align: right;	width: 60%">página [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
        <br>
        <br>
    </page_footer>
    <hr>
    <table style="width: 100%; border: solid 0px black;">
        <tr>
            <td style="text-align: left;	width: 50%"><span style="font-size: 15px; font-weight: bold">REPORTE DE USUARIOS </span></td>
            <td style="text-align: right;	width: 50%"><span style="font-size: 15px; font-weight: bold"><?=date("d-m-Y")?></span></td>
        </tr>
    </table>
    <table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
        <thead>
        <tr>
            <td style="width: 20%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">RAZON SOCIAL / NOMBRES</td>
            <td style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DOCUMENTO</td>
            <td style="width: 13%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">CORREO</td>
            <td style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">PERFIL</td>
            <td style="width: 7%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">USUARIO</td>
            <td style="width: 10%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">ESTADO</td>
        </tr>
        </thead>
        <tbody>
        <?php
		$sql = "SELECT * FROM Tra_M_Trabajadores
            	INNER JOIN Tra_M_Perfil ON  Tra_M_Trabajadores.iCodPerfil=Tra_M_Perfil.iCodPerfil            	
            	WHERE iCodTrabajador > 0 AND Tra_M_Trabajadores.ES_EXTERNO = 0 ";

        if ($_GET['cNombreTrabajador'] != ""){
        	$sql.=" AND cNombresTrabajador LIKE '%".$_GET['cNombreTrabajador']."%' ";
    	}
		if ($_GET['cApellidosTrabajador'] != ""){
			$sql.=" AND cApellidosTrabajador like '%".$_GET['cApellidosTrabajador']."%' ";
		}
		if ($_GET['cNumDocIdentidad'] != ""){
			$sql.=" AND cNumDocIdentidad='".$_GET['cNumDocIdentidad']."' ";
		}
		if ($_GET['cTipoDocIdentidad'] != ""){
			$sql.=" AND cTipoDocIdentidad='".$_GET['cTipoDocIdentidad']."'";
		}
		if ($_GET['iCodPerfil'] != ""){
			$sql.=" AND Tra_M_Trabajadores.iCodPerfil='".$_GET['iCodPerfil']."'";
		}
		if ($_GET['txtestado'] != ""){
			$sql.=" AND nFlgEstado='".$_GET['txtestado']."'";
		        }
		$sql.="ORDER BY ".$_GET['campo'] . $_GET['orden'];
		//print $sql;

		error_log("rrrrr==>".$sql);

        $rs = sqlsrv_query($cnx,$sql);

		while ($Rs = sqlsrv_fetch_array($rs)){
	?>
        <tr>
            <?php
            $sqlDoc = "SELECT * FROM Tra_M_Doc_Identidad WHERE cTipoDocIdentidad = ".$Rs['cTipoDocIdentidad'];
            $rsDoc = sqlsrv_query($cnx,$sqlDoc);
            $RsDoc = sqlsrv_fetch_array($rsDoc);
            ?>
            <td style="width: 20%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cNombresTrabajador']);?></td>
            <td style="width: 10%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?php echo utf8_encode(trim($RsDoc['cDescDocIdentidad'])." : ".$Rs['cNumDocIdentidad']);?></td>
            <td style="width: 15%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cEmail']??'-';?></td>
            <td style="width: 8%; text-align: center; border: solid 1px #6F6F6F;font-size:10px" ><?=utf8_encode($Rs['cDescPerfil']);?></td>
            <td style="width: 10%; text-align: left; border: solid 1px #6F6F6F;font-size:10px" ><?=$Rs['cUsuario'];?>
            </td>
            <td style="width: 10%; border: solid 1px #6F6F6F;font-size:10px" >
                <?php
                if ($Rs['nFlgEstado'] == 1){
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
</page>