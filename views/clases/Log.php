<?php
class Log
{
    public $tramiteDbCnx;
    public $sesion;

    public function __construct($tramiteDbCnx)
    {
        $this->tramiteDbCnx = $tramiteDbCnx;
    }

    public function logging($datosCorreo = false, $datosBd = false){
        if ($datosCorreo){
            $this->enviarCorreo($datosCorreo->asunto, $datosCorreo->correos, $datosCorreo->cuerpo);
        }

        if ($datosBd){
            $this->registrarLog($datosBd->archivo, $datosBd->metodo, $datosBd->resultado, $datosBd->mensaje, $datosBd->contenido);
        }
    }

    private function enviarCorreo($asunto, $correos, $cuerpo){       
        $mail = new Email();
        $mail->Enviar($asunto, $correos, $cuerpo);
    }

    private function registrarLog($archivo, $metodo, $resultado, $mensaje = null, $contenido = null)
    {        
        $parametros = array(
            $archivo,
            $metodo,
            $resultado,
            $mensaje,
            $contenido
        );
        
        $store = "{CALL UP_REGISTRAR_LOG (?,?,?,?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$store,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        return true;
    }
}