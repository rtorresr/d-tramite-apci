<?php
/**
 * Created by PhpStorm.
 * User: acachay
 * Date: 14/11/2018
 * Time: 15:47
 */
class coreTable
{
    private $connection;

    public function __construct($cnx){
        $this->connection = $cnx;
    }

//-----------------funciones de orden----------------
    function limit ( $consulta){
        $limit='';
        if ( isset($consulta['start']) && $consulta['length'] ) {
            $limit = " OFFSET ".$consulta['start']." ROWS FETCH NEXT ".$consulta['length']." ROWS ONLY";
        }
        return $limit;
    }

    function filter ( $consulta, $columna)  {
        $filtro = '';
        if (!empty($consulta['search']['value'])) {
            $cadena = ' ';
            $valor = $consulta['search']['value'];
            for ($i = 0, $n = count($columna); $i < $n; $i++) {
                if ($i != ($n - 1)) {
                    $cadena .= $columna[$i] . " LIKE '%" . $valor . "%' OR  ";
                } else {
                    $cadena .= $columna[$i] . " LIKE '%" . $valor . "%' ";
                }
            }
            $filtro .= " AND ( " . $cadena . " ) ";
        }

        return $filtro;
    }
    function order ( $consulta, $columna ,$primerorden){
        $orden = '';
        if (isset($consulta['order'])) {
            for ( $i=0, $ien=count($consulta['order']) ; $i<$ien ; $i++ ) {
                $indeceColumna=(int)$consulta['order'][$i]['column'];
                $nombreColumna=$columna[$indeceColumna];
                $direccion=$consulta['order'][$i]['dir'];
                $orden.=" ORDER BY ".$nombreColumna." ".$direccion." ";
            }
        } else {
            $nombreColumna=$columna[$primerorden];
            $orden.=" ORDER BY ".$nombreColumna." DESC ";
        }
        return $orden;
    }

    function concatColumnas($columnas){
        //-----------------funciones-----------------
        $variables='';
        for ($i = 0, $n = count($columnas); $i < $n; $i++) {
            if ($i != ($n - 1)) {
                $variables .= " ".$columnas[$i]. ", ";
            } else {
                $variables .= " ".$columnas[$i];
            }
        }
        return $variables;
    }

    public function datos($request, $columnas, $tabla, $where, $primerorden) {

            //variables de búsqueda
            $limite=$this->limit($request);
            $busqueda=$this->filter($request,$columnas);
            $orden=$this->order($request,$columnas,$primerorden);
            $variables=$this->concatColumnas($columnas);

    //------------EDITE SU CONSULTA----------//
    //consulta agregar despues del where la busqueda con un and y agregar varibales y orden despues del select

            $consultaTotal="SELECT ".$variables."  FROM ".$tabla;

            $consultaFiltrada=$consultaTotal." WHERE 1=1 ".$busqueda.($where??'');

    //--------------------------------------//
            $sql=$consultaFiltrada." ".$orden." ".$limite;

    //consulta a la base de datos
            $rsTotal=sqlsrv_query($this->connection,$consultaTotal,array(),array('Scrollable'=>'Buffered'));
            $recordsTotal=sqlsrv_num_rows($rsTotal);

            $rsFiltrada=sqlsrv_query($this->connection,$consultaFiltrada,array(),array('Scrollable'=>'Buffered'));
            $recordsFiltered=sqlsrv_num_rows($rsFiltrada);
            $rs=sqlsrv_query($this->connection,$sql);

        $json_data = array(
            "draw"            => (int)($request['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $rs
        );

        return $json_data;


    }



}


