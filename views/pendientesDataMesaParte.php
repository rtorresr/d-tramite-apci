<?php
session_start();
include_once("../conexion/conexion.php");
require_once("../conexion/parametros.php");
require_once('clases/DocDigital.php');
require_once("clases/Log.php");
require_once('../vendor/autoload.php');

require_once("clases/Email.php");
/*try {
    foreach($_POST['datos'] as $item):
        
            $nombres = $item['nomResponsableDer'];
            $correo = $item['correo'];
            echo $correo;
    endforeach;

} catch (\Throwable $th) {
    var_dump($th->getMessage());
}
exit;*/

    foreach($_POST['iCodMovimiento'] as $value):
        $params = array(
        $_SESSION['CODIGO_TRABAJADOR'],
        $_SESSION['iCodOficinaLogin'],
        $value,
        json_encode($_POST['datos'])
             );
        $sqlDer = "{call SP_DERIVAR_MULTIPLE_MESA_PARTES (?,?,?,?) }";
        $rs = sqlsrv_query($cnx, $sqlDer, $params);
               if($rs === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }  

            /* echo�'1';*/
         endforeach;
            
         if($_POST['incriptado'] == 1){

            $sqlTrb = "SELECT clave,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite = '".$_POST['iCodTramite']."'";
            $rsTrb  = sqlsrv_query($cnx,$sqlTrb);
            $result = array();
            while($reponsable = sqlsrv_fetch_array($rsTrb, SQLSRV_FETCH_ASSOC)){
                $result[]= $reponsable;
            }
            /*ACTUALIZAR PARA ENVIO JC*/ 
            $result=$result[0];

            $sqlTrbe = "UPDATE Tra_M_Tramite  SET flgEncriptado= 1 WHERE iCodTramite = '".$_POST['iCodTramite']."'";
            $rsTrbe  = sqlsrv_query($cnx,$sqlTrbe);

         foreach($_POST['datos'] as $item):

                #enviar al correo, ahora si prueba
                    $nombres = $item['nomResponsableDer'];
                    $correo = $item['correo'];
    
                    $nombre_doc = $result['cDescTipoDoc'].' '.$result['cDescTipoDoc'];
    
                    $asunto = 'CLAVE DOCUMENTO ENCRIPTADO';
                    $cuerpo = '<p>Estimado(a) '.$nombres.', el documento '.$nombre_doc.' tiene como clave para su visualización: '.$result['clave'];
    
                    $correos = [];
                    array_push($correos,$correo);
    
                    try {
                        $mail = new Email();
                        $mail->Enviar($asunto, $correos, $cuerpo);
    
                    } catch (\Throwable $th) {
                        var_dump($th->getMessage());
                    }
         endforeach;
        }

?>