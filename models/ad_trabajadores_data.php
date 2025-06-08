<?php session_start();
If ($_SESSION['CODIGO_TRABAJADOR'] != "") {
    require_once("../conexion/conexion.php");
    switch ($_POST['opcion']) {
        case 2:
            //actualizamos datos del perfil del usuario
            $sqlActualiza = "update Tra_M_Trabajadores set cNombresTrabajador='".$_POST['nombres']."',cApellidosTrabajador='".$_POST['apellidos']."',";
            $sqlActualiza.=  "cNumDocIdentidad='".$_POST['documento']."',cDireccionTrabajador='".$_POST['direccion']."',cTlfTrabajador1='".$_POST['telefono1']."',";
            $sqlActualiza.= "cTlfTrabajador2='".$_POST['telefono2']."' where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
            $rsActualiza=sqlsrv_query($cnx,$sqlActualiza);
            sqlsrv_close($cnx);
            header("Location: ../views/perfil.php");
            break;
        case 3: //cambio de contraseña
            $cPassword = md5($_POST['cUsuario'] . $_POST['nuevo']);
            $sql = "UPDATE Tra_M_Trabajadores SET ";
            $sql.="cUsuario='".$_POST['cUsuario']."', cPassword='".$cPassword."' ";
            $sql.="WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
            $rs = sqlsrv_query($cnx,$sql);
            sqlsrv_close($cnx);
            //header("Location: ../views/main.php");
            break;
    }
}else{
    header("Location: ../index-b.php?alter=5");
}
?>