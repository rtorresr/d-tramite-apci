<?php 
include_once "../../conexion/conexion.php";
include_once "../clases/DocDigital.php";
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

session_start();
$fechainiano = new DateTime('first day of january '. date('Y'));
$fechafinano = new DateTime('last day of december '. date('Y'));

$data = json_decode(base64_decode($_GET['var']));
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-type: application/x-msexcel; charset=utf-8");
header("Pragma: no-cache");
header('Content-Encoding: UTF-8');
header ("Content-Disposition: attachment; filename=ConsultaGeneral.xls" );
header ("Content-Description: Consulta General" );
// header('Content-Type: text/html; charset=UTF-8');
// header("Content-type: application/vnd.ms-excel");
// header("Content-Disposition: attachment; filename=ConsultaGeneral.xls");

    $evento = $data->datos[0];
    
    $anho = date("Y");
	$datomes = date("m");
	$datomes = $datomes*1;
	$datodia = date("d");
	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
    
    echo "<table width=780 border=0><tr><td align=center colspan=7>";
	echo "<img src='http://d-tramite.apci.gob.pe/dist/images/logo--sm.png'>";
    echo "</table>";
    
    echo "<table width=780 border=0><tr><td align=center colspan=9>";
	echo "<h3>CONSULTA GENERAL</h3>";
	echo "</table>";
	
	echo "<table width=780 border=0><tr><td align=right colspan=9>";
	echo "D-Tr&aacute;mite, ".$datodia." ".$meses[$datomes].' del '.$anho;
	echo "</table>";
	
    echo "<table width='780' border='1px'><tr>";
    echo "<td bgcolor=#CDEBF8 colspan='6' align=center><font color=##1B365D>Datos del Documento</td>";
    echo "<td bgcolor=#CDEBF8 colspan='2' align=center><font color=##1B365D>Datos del Origen</td>";
    echo "<td bgcolor=#CDEBF8 colspan='1' align=center><font color=##1B365D>Datos del Destino</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg;</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> N&deg; CUD</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Origen de Doc.</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Documento</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Asunto</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Fecha del Doc.</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Proyectado Por</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Responsable de Firma</td>";
	echo "<td bgcolor=#CDEBF8 align=center><font color=##1B365D> Destino</td>";
	echo "</tr>";
	

switch($evento){
    case 'DataTableData':
         
        if (isset($data->datos[10]) && is_array($data->datos[10]) && count($data->datos[10])>0){
            $trabajadorOrigen = json_encode($data->datos[10]);
        } else {
            $trabajadorOrigen = null;
        }

        if (isset($data->datos[13]) && is_array($data->datos[13]) && count($data->datos[13])>0){
            $trabajadorDestino = json_encode($data->datos[13]);
        } else {
            $trabajadorDestino = null;
        }


        $params = array(
            $data->datos[1],
            $data->datos[2],
            $data->datos[3],
            $data->datos[4],
            $data->datos[5],
            $data->datos[6],
            $data->datos[7],
            $data->datos[8],
            $data->datos[9],
            $trabajadorOrigen,
            $data->datos[11],
            $data->datos[12],
            $trabajadorDestino,
            $data->datos[14],
            $data->datos[15],
            $data->datos[16],
            $data->datos[17],
            $data->datos[18],
            $data->start,
            $data->length
        );

        if ($data->datos[2] == '1'){
            $storedName = 'SP_CONSULTA_GENERAL_EMITIDOS';
        } else {
            $storedName = 'SP_CONSULTA_GENERAL_PROYECTADOS';
        }
        

        $sql = "{call ".$storedName." (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $rs = sqlsrv_query($cnx, $sql, $params);

        
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        
        while($Rs=sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
            echo "<tr>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($Rs['row_id'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($Rs['cud'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($Rs['origen_doc'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".mb_convert_encoding($Rs['nro_documento'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=justify style='vertical-align: middle'>".mb_convert_encoding($Rs['asunto'],"HTML-ENTITIES","UTF-8")."</td>";
            echo "<td align=center style='vertical-align: middle'>".$Rs['fecha_doc']->format( 'd-m-Y')."</td>";

            $params = array(
                $Rs['codigo']
            );
    
            if ($Rs['tipo'] == 'T'){
                $storedName = 'SP_CONSULTA_GENERAL_EMITIDOS_OBTENER_INFORMACION';
            } else {
                $storedName = 'SP_CONSULTA_GENERAL_PROYECTADOS_OBTENER_INFORMACION';
            }
    
            $sql = "{call ".$storedName." (?) }";
            $rsDet = sqlsrv_query($cnx, $sql, $params);

            while($RsDet=sqlsrv_fetch_array($rsDet,SQLSRV_FETCH_ASSOC)){
                echo "<td align=justify style='vertical-align: middle'>".mb_convert_encoding($RsDet['autor'],"HTML-ENTITIES","UTF-8")."</td>";
                echo "<td align=justify style='vertical-align: middle'>".mb_convert_encoding($RsDet['firmante'],"HTML-ENTITIES","UTF-8")."</td>";
                echo "<td align=justify style='vertical-align: middle'>";
                if($RsDet['tipoDoc']==3){
                    $destinos = json_decode($RsDet['destinos'],true);
                    for ($i = 0; $i<count($destinos); $i++){
                        echo " ".mb_convert_encoding($destinos[$i]['entidad_destino'],"HTML-ENTITIES","UTF-8")." <br/>";
                    }
                }else{
                    $destinos = json_decode($RsDet['destinos'],true);
                    for ($i = 0; $i<count($destinos); $i++){
                        if ($destinos[$i]['flgCopia'] == '1'){
                            echo "<strong><u>Cc.</u></strong> ".mb_convert_encoding($destinos[$i]['trabajador_destino'],"HTML-ENTITIES","UTF-8")." (".utf8_decode($destinos[$i]['oficina_destino']).") <br/>";
                        } else {
                            echo " ".mb_convert_encoding($destinos[$i]['trabajador_destino'],"HTML-ENTITIES","UTF-8")." (".utf8_decode($destinos[$i]['oficina_destino']).") <br/>";
                        }                        
                    }
                }
                
                echo"</td>";
                echo "</tr>";
            }
            
        }
        echo "</table>";

    break;
}

