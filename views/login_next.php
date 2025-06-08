<?php session_start();

    include_once("../conexion/conexion.php");
    $_SESSION['iCodOficinaLogin']=$_POST['ddlOficina'];
    $_SESSION['iCodPerfilLogin']=$_POST['ddlPerfil'];

    $sqlPerfilUsu = 'select  iCodCargo, firma, visto, flgDelegacion, flgEspecialistas, restricciones, flgEncriptacion
                    from Tra_M_Perfil_Ususario 
                    where iCodTrabajador='.$_SESSION['CODIGO_TRABAJADOR'].' AND iCodOficina = '.$_SESSION['iCodOficinaLogin'].' AND iCodPerfil = '.$_SESSION['iCodPerfilLogin'];

    $rsPerfilUsu  = sqlsrv_query($cnx,$sqlPerfilUsu);
    $RsPerfilUsu  = sqlsrv_fetch_array($rsPerfilUsu);

    $_SESSION['iCodCargo']=$RsPerfilUsu["iCodCargo"];
    $_SESSION['firma']=$RsPerfilUsu["firma"];
    $_SESSION['VistoBueno']=$RsPerfilUsu["visto"];
    $_SESSION['flgDelegacion']=$RsPerfilUsu["flgDelegacion"];
    $_SESSION['flgEspecialistas']=$RsPerfilUsu["flgEspecialistas"];    
    $_SESSION['Restricciones'] = $RsPerfilUsu["restricciones"] == null ? [] : json_decode($RsPerfilUsu["restricciones"]);
    $_SESSION['flgEncriptacion']=$RsPerfilUsu["flgEncriptacion"];

    $params = array(
        $_SESSION['iCodOficinaLogin'],
        $_SESSION['CODIGO_TRABAJADOR'],
        $_SESSION['iCodPerfilLogin']
    );
    $sqlCrearSesion = "{call UP_INSERTAR_SESION (?,?,?) }";
    $rs = sqlsrv_query($cnx, $sqlCrearSesion, $params);
    if($rs === false) {
        print_r('Error al registrar la sesion.');
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }

    $Rs = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC);
    $_SESSION['IdSesion'] = $Rs['IDENTIDAD'];
    header("Location: main.php");
?>