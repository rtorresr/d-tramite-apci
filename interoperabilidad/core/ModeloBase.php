<?php

class ModeloBase
{
    private $db;

    public function __construct()
    {
        $this->db = new  Db();
    }

    public function establecer($objeto){
        foreach ($objeto as $key => $value){
            $this->$key = $value;
        }
    }

    protected function ejecutar($nomStore, $parametros = array()){
        if (count($parametros) == 0){
            $sql = "{ CALL $nomStore }";
        } else {
            $string = implode(",", array_fill(0, count($parametros), '?'));
            $sql = "{ CALL $nomStore ( $string ) }";
        }
        return $this->db->query($sql, $parametros);
    }
}