<?php
include_once "../../conexion/conexion.php";

include_once("../../conexion/srv-Nginx.php");
include_once("../../conexion/parametros.php");
include_once("../../core/CURLConection.php");

require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

include_once("../../views/registerDoc/phpqrcode/qrlib.php");

date_default_timezone_set('America/Lima');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

switch ($_POST['Accion']) {
    case 'ListarReporte':
        $params = [
            $_POST['Cud'],
            $_POST['NroDocumento'],
            $_POST['Asunto'],
            $_POST['Entidad'],
            $_POST['IdTipoDocumento'],
            $_POST['IdTipoIngreso'],
            $_POST['IdTipoEntidad'],
            $_POST['IdTipoTramiteClase'],
            $_POST['IdTupa'],
            $_POST['FecIni'],
            $_POST['FecFin'],
            $_POST["start"],
            $_POST["length"]
        ];
        
        $sql = "{call UP_REPORTE_MESA_PARTES (?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        
        $rs = sqlsrv_query($cnx,$sql,$params);
        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors(), true));
        }
        
        $data = array();
        
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $item = $Rs;
            $item['FechaRegistro'] = $Rs['FechaRegistro'] != null ? $Rs['FechaRegistro']->format( 'd/m/Y') : '';
            $item['FechaDocumento'] = $Rs['FechaDocumento'] != null ? $Rs['FechaDocumento']->format( 'd/m/Y') : '';

            $data[] = $item;
        }
        
        $VO_TOTREG = 0;
        while($res = sqlsrv_next_result($rs)){
            if( $res ) {
                while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                    $VO_TOTREG = $row['VO_TOTREG'];
                }
            } elseif ( is_null($res)) {
                echo "No se obtener datos!";
                return;
            } else {
                die(print_r(sqlsrv_errors(), true));
            }
        }
        
        $recordsTotal = $VO_TOTREG;
        $recordsFiltered = $VO_TOTREG;
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $data
        );
        
        echo json_encode($json_data);
        break;

    case 'DescargarListadoReporte':
        $params = [
            $_POST['Cud'],
            $_POST['NroDocumento'],
            $_POST['Asunto'],
            $_POST['Entidad'],
            $_POST['IdTipoDocumento'],
            $_POST['IdTipoIngreso'],
            $_POST['IdTipoEntidad'],
            $_POST['IdTipoTramiteClase'],
            $_POST['IdTupa'],
            $_POST['FecIni'],
            $_POST['FecFin'],
            $_POST["start"],
            $_POST["length"]
        ];
        
        $sql = "{call UP_REPORTE_MESA_PARTES (?,?,?,?,?,?,?,?,?,?,?,?,?)}";

        $rs = sqlsrv_query($cnx,$sql,$params);
        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors(), true));
        }

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-type: application/x-msexcel; charset=utf-8");
        header("Pragma: no-cache");
        header('Content-Encoding: UTF-8');
        header ("Content-Disposition: attachment; filename=Reporte-Mesa-Partes".date("d-m-Y").".xls" );
        header ("Content-Description: Reporte Mesa Partes" );
        
        $anho = date("Y");
        $datomes = date("m");
        $datomes = $datomes*1;
        $datodia = date("d");
        $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");    

        echo "<table width=780 border=0><tr><td align=center colspan=21>";
        echo "<img src='http://d-tramite.apci.gob.pe/dist/images/logo--sm.png'>";
        echo "</table>";
        
        echo "<table width=780 border=0><tr><td align=center colspan=21>";
        echo "<h3>Reporte Bandeja Mesa Partes Digital</h3>";
        echo "</table>";
        
        echo "<table width=780 border=0><tr><td align=right colspan=21>";
        echo "D-Tr&aacute;mite, ".$datodia." ".$meses[$datomes].' del '.$anho;
        echo "</table>";

        echo "<table width='780' border='1px'>";
        echo "<tr>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg;</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tipo de Ingreso</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tipo de Entidad</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Nombre Entidad</td>";

        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg CUD</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Fec. Registro D-tramite</td>";
        
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tipo de Doc.</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg de Doc.</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Fecha de Doc.</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Asunto</td>";      
        
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tipo de Tramite</td>";
        echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Tramite</td>";       
        
        echo "</tr>";
        
        $count = 1;
        while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
            $item = $Rs;
            $item['FechaRegistro'] = $Rs['FechaRegistro'] != null ? $Rs['FechaRegistro']->format( 'd/m/Y') : '';
            $item['FechaDocumento'] = $Rs['FechaDocumento'] != null ? $Rs['FechaDocumento']->format( 'd/m/Y') : '';

            echo "<tr>";
            
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($count,"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['TipoRegistro'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['TipoEntidad'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=left style='vertical-align: middle'>".mb_convert_encoding($item['Entidad'],"HTML-ENTITIES","UTF-8")."</td>";

            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['Cud'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['FechaRegistro'],"HTML-ENTITIES","UTF-8")."</td>";

            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['TipoDocumento'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['NroDocumento'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($item['FechaDocumento'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=left style='vertical-align: middle'>".mb_convert_encoding($item['Asunto'],"HTML-ENTITIES","UTF-8")."</td>";
                  
            echo "<td align=left style='vertical-align: middle'>".mb_convert_encoding($item['TupaClase'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=left style='vertical-align: middle'>".mb_convert_encoding($item['Tupa'] == null ? '' : $item['Tupa'],"HTML-ENTITIES","UTF-8")."</td>";

            echo "</tr>";

            $count ++;
        }
        break;
}