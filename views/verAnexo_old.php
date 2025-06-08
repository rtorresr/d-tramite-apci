<?php
include_once("../conexion/conexion.php");
include_once("../conexion/parametros.php");
include_once("../conexion/srv-Nginx.php");
include_once("DocDigital.php");
date_default_timezone_set('America/Lima');


if (isset($_POST['iCodMovimiento'])) {
    $idm = $_POST['iCodMovimiento'];

    $sqlMovP = "SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = " . $idm;
    $rsMovP = sqlsrv_query($cnx, $sqlMovP);
    $RsMovP = sqlsrv_fetch_array($rsMovP);

    $sql = "SELECT '".$url_srv."' + cNombreNuevo AS cNombreNuevo ,cNombreOriginal, iCodDigital from Tra_M_Tramite_Digitales where iCodTramite = " . $RsMovP["iCodTramite"] . " AND iCodTipoDigital = '3' ORDER BY iCodDigital ASC";
} else {
    $sql = "SELECT '".$url_srv."' + cNombreNuevo AS cNombreNuevo ,cNombreOriginal, iCodDigital from Tra_M_Tramite_Digitales where iCodTramite = " . $_POST["codigo"] . " AND iCodTipoDigital = '3' ORDER BY iCodDigital ASC";
}
$pros=sqlsrv_query($cnx,$sql);

if($pros === false) {
    $data['tieneAnexos'] = '0';
    echo json_encode($data);
} else {
    if (sqlsrv_has_rows($pros)) {
        $data['tieneAnexos'] = '1';        

        $configuracion = new stdClass();
        $configuracion->cnxBd = $cnx;
        $configuracion->cnxRepositorio = RUTA_REPOSITORIO;
        $configuracion->visualizador = RUTA_VISOR_REPOSITORIO;
        $configuracion->ngnix = $url_srv;
        $configuracion->descargaAnexo = RUTA_DTRAMITE.RUTA_DESCARGA_ANEXOS;

        $docDigital = new DocDigital($configuracion);

        $anexos = array();
        while ($RsPro = sqlsrv_fetch_array($pros)) {
            $info = array();

            if (rtrim($RsPro['cNombreOriginal']) == '') {
                $nombre = explode('/', rtrim($RsPro['cNombreNuevo']));
                $nombre = $nombre[8];
                $info['nombre'] = $nombre;
            } else {
                $info['nombre'] = rtrim($RsPro['cNombreOriginal']);
            }

            $info['url'] = $docDigital->obtenerRutaDocDigital($RsPro['iCodDigital']);
            $anexos[] = $info;
        }
        $data['anexos'] = $anexos;

        echo json_encode($data);
    } else {
        $data['tieneAnexos'] = '0';
        echo json_encode($data);
    }
}