<?php
/**
 * Created by PhpStorm.
 * User: usi15
 * Date: 26/09/2019
 * Time: 10:18
 */

class UtilesModel extends ModeloBase
{
    public $idSesion;

    public function __construct($idSesion)
    {
        parent::__construct();
        $this->idSesion = $idSesion;
    }

    public function obtenerOficinas($tipo){
        $parametros = array(
            $tipo,
            $this->idSesion
        );
        $nomStore = "[DBO].[UP_LISTAR_OFICINAS]";
        return $this->ejecutar($nomStore, $parametros);
    }
}