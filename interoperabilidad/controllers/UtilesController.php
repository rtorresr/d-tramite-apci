<?php

class UtilesController
{
    public $idSesion;

    public function listarOficinas(){
        $this->idSesion = $_SESSION['IdSesion'];
        $utiles = new UtilesModel($this->idSesion);
        $resultado = $utiles->obtenerOficinas($_POST['tipo']);
        echo json_encode($resultado);
    }
}