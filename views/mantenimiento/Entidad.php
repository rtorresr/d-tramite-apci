<?php
//require '../../vendor/autoload.php';

include_once("../../conexion/conexion.php");
session_start();

switch ($_POST['Evento']){
    case 'BuscarEntidad':
        $parametros = array(
            $_POST['page']??100,
            $_POST['search']??'',
            $_POST['tipoDocumento'] ?? 0
        );
        
        $sql = "{call UP_BUSCAR_ENTIDAD_SELECT_TWO (?,?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);

        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = [];
        while ($Rs = sqlsrv_fetch_array($rs)){
            array_push($data, ["id" => trim($Rs['id']), "text" => trim($Rs["text"])]);
        }

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
    break;

    case 'AgregarEntidad':
        $parametros = array(
            $_POST["Datos"]["tipoEntidad"],
            $_POST["Datos"]["siglaEntidad"]??'',
            $_POST["Datos"]["nombreEntidad"],
            $_POST["Datos"]["tipoDocumento"],
            $_POST["Datos"]["numeroDocumento"],
            $_POST["Datos"]["responsableEntidad"]??'',
            $_POST["Datos"]["cargoResponsableEntidad"]??'',
            $_POST["Datos"]["flgRequiereDireccion"] ?? 1,
            $_SESSION["IdSesion"]
        );

        $sql = "{call UP_AGREGAR_NUEVA_ENTIDAD (?,?,?,?,?,?,?,?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs);
        $data = ["id" => trim($Rs['id']), "text" => trim($Rs["text"])];

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;

    case 'ObternerDatos':
        $parametros = array(
            $_POST["idEntidad"]
        );

        $sql = "{call UP_OBTENER_DATOS_ENTIDAD (?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($rs);

        echo json_encode($Rs);
        break;
        
    case 'AgregarDependencia':
        $parametros = array(
            $_POST["Datos"]["idEntidadPadre"],
            $_POST["Datos"]["nombreDependenciaEntidad"],
            $_POST["Datos"]["siglaDependenciaEntidad"]??'',
            $_POST["Datos"]["nombreResponsableDependenciaEntidad"]??'',
            $_POST["Datos"]["cargoResponsableDependenciaEntidad"]??'',
            $_SESSION["IdSesion"]
        );

        $sql = "{call UP_AGREGAR_NUEVA_DEPENDENCIA (?,?,?,?,?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs);
        $data = ["id" => trim($Rs['id']), "text" => trim($Rs["text"])];

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;    

    case 'ListarEntidadesHijas':
        $parametros = array(
            $_POST['IdEntidadPadre']
        );

        $sql = "{call UP_LISTAR_ENTIDADES_HIJAS (?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = [];
        while ($Rs = sqlsrv_fetch_array($rs)){
            array_push($data, ["id" => trim($Rs['id']), "text" => trim($Rs["text"])]);
        }

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;

    case 'EditarEntidad':
        $parametros = array(
            $_POST["Datos"]["idEntidad"],
            $_POST["Datos"]["tipoEntidad"],
            $_POST["Datos"]["siglaEntidad"]??'',
            $_POST["Datos"]["nombreEntidad"],
            $_POST["Datos"]["tipoDocumento"],
            $_POST["Datos"]["numeroDocumento"],
            $_POST["Datos"]["responsableEntidad"]??'',
            $_POST["Datos"]["cargoResponsableEntidad"]??'',
            $_POST["Datos"]["flgRequiereDireccion"] ?? 1,
            $_SESSION["IdSesion"]
        );

        $sql = "{call UP_EDITAR_ENTIDAD (?,?,?,?,?,?,?,?,?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs);
        $data = ["id" => trim($Rs['id']), "text" => trim($Rs["text"])];

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;

    case 'EliminarEntidad':
        $parametros = array(
            $_POST["IdEntidad"]
            ,$_SESSION["IdSesion"]
        );

        $sql = "{call UP_ELIMINAR_ENTIDAD (?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;
    
    case 'EditarDependencia':
        $parametros = array(
            $_POST["Datos"]["idEntidad"],
            $_POST["Datos"]["nombreDependenciaEntidad"],
            $_POST["Datos"]["siglaDependenciaEntidad"]??'',
            $_POST["Datos"]["nombreResponsableDependenciaEntidad"]??'',
            $_POST["Datos"]["cargoResponsableDependenciaEntidad"]??'',
            $_SESSION["IdSesion"]
        );

        $sql = "{call UP_EDITAR_DEPENDENCIA (?,?,?,?,?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs);
        $data = ["id" => trim($Rs['id']), "text" => trim($Rs["text"])];

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;

    case 'EliminarDependencia':
        $parametros = array(
            $_POST["IdEntidad"]
            ,$_SESSION["IdSesion"]
        );

        $sql = "{call UP_ELIMINAR_DEPENDENCIA (?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;
}