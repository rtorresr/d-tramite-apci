<?php
session_start();
ob_start();
//*************************************
include_once("../conexion/conexion.php");
?>
<page backtop="25mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <hr>
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
                    $sqllog="select cNombresTrabajador, cApellidosTrabajador from tra_m_trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."' ";
                    $rslog=sqlsrv_query($cnx,$sqllog);
                    $Rslog=sqlsrv_fetch_array($rslog);
                    echo $Rslog['cNombresTrabajador']." ".$Rslog['cApellidosTrabajador'];
                    ?></td>
                <td style="text-align: right;	width: 60%">página [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
        <br>
        <br>
    </page_footer>


    <table style="width: 100%; border: solid 0px black;">
        <tr>
            <td style="text-align: left;	width: 50%"><span style="font-size: 15px; font-weight: bold">REPORTE - PERFILES</span></td>
            <td style="text-align: right;	width: 50%"><span style="font-size: 15px; font-weight: bold"><?=date("d-m-Y")?></span></td>
        </tr>
    </table>
    <br>
    <table style="width: 55%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
        <thead>
        <tr>
            <th style="width: 45%; text-align: center; border: solid 1px #6F6F6F; background: #D8D8D8">DESCRIPCION</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql=" SP_PERFIL_LISTA '%".($_GET['cDescPerfil']??'')."%' ,'".($orden??'')."' , '".($campo??'')."' ";
        $rs=sqlsrv_query($cnx,$sql);

        while ($Rs=sqlsrv_fetch_array($rs)){
            ?>
            <tr>
                <td style="width: 45%; text-align: left; border: solid 1px #6F6F6F;font-size:10px"><?php echo utf8_encode($Rs['cDescPerfil']??'');?></td>

            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>
</page>
