<?php
/**
 * Created by PhpStorm.
 * User: usi15
 * Date: 07/11/2018
 * Time: 09:46 AM
 */

include_once "../../conexion/conexion.php";


//tipo de consulta
$request=$_GET;

//columnas de busqueda y ordenamiento
$columnas=array(
    0   =>  'cNomOficina',
    1   =>  'cApellidosTrabajador',
    2   =>  'cNombresTrabajador',
    3   =>  'cDescDocIdentidad',
    4   =>  'cNumDocIdentidad',
    5   =>  'cMailTrabajador',
    6   =>  'cUsuario',
    7   =>  'nFlgEstado',
    8   =>  'iCodTrabajador'
);


//-----------------funciones de orden----------------
function limit ( $consulta){
    $limit='';
    if ( isset($consulta['start']) && $consulta['length'] ) {
        $limit = " OFFSET ".$consulta['start']." ROWS FETCH NEXT ".$consulta['length']." ROWS ONLY";
    }
    return $limit;
}
function filter ( $consulta, $columna)
{
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
function order ( $consulta, $columna ){
    $orden = '';
    if (isset($consulta['order'])) {
        for ( $i=0, $ien=count($consulta['order']) ; $i<$ien ; $i++ ) {
            $indeceColumna=intval($consulta['order'][$i]['column']);
            $nombreColumna=$columna[$indeceColumna];
            $direccion=$consulta['order'][$i]['dir'];
            $orden.=" ORDER BY ".$nombreColumna." ".$direccion." ";
        }
    }
    return $orden;
}
//-----------------funciones-----------------

$variables='';
for ($i = 0, $n = count($columnas); $i < $n; $i++) {
    if ($i != ($n - 1)) {
        $variables .= " ".$columnas[$i]. ", ";
    } else {
        $variables .= " ".$columnas[$i];
    }
}

//variables de búsqueda
$limite=limit($request);
$busqueda=filter($request,$columnas);
$orden=order($request,$columnas);


//------------EDITE SU CONSULTA----------//
//consulta agregar despues del where la busqueda con un and y agregar varibales y orden despues del select

$consultaFiltrada="SELECT ".$variables." FROM 
                    Tra_M_Trabajadores AS t inner join Tra_M_Oficinas AS o ON t.iCodOficina=o.iCodOficina
                    left join Tra_M_Doc_Identidad AS i ON i.cTipoDocIdentidad = t.cTipoDocIdentidad 
                    WHERE 1=1 ".$busqueda;

$consultaTotal="SELECT * FROM Tra_M_Trabajadores ";
//--------------------------------------//

$sql=$consultaFiltrada." ".$orden." ".$limite;


//consulta a la base de datos
$rsTotal=sqlsrv_query($cnx,$consultaTotal,array(),array('Scrollable'=>'Buffered'));
$recordsTotal=sqlsrv_num_rows($rsTotal);

$rsFiltrada=sqlsrv_query($cnx,$consultaFiltrada,array(),array('Scrollable'=>'Buffered'));
$recordsFiltered=sqlsrv_num_rows($rsFiltrada);

$rs=sqlsrv_query($cnx,$sql);
$data=array();
while($Rs=sqlsrv_fetch_array($rs)){
    $subdata=array();

    $subdata[]=$Rs['cNomOficina'];
    $subdata[]=$Rs['cApellidosTrabajador'];
    $subdata[]=$Rs['cNombresTrabajador'];
    $subdata[]=$Rs['cDescDocIdentidad'];
    $subdata[]=$Rs['cNumDocIdentidad'];
    $subdata[]=$Rs['cMailTrabajador'];
    $subdata[]=$Rs['cUsuario'];

    if($Rs['nFlgEstado']==1){
        $subdata[]='Activo';
    }else{
        $subdata[]='Inactivo';
    }

    $subdata[]="<nav class='nav-actions'>
                <a class='waves-effect waves-light btn btn-link nav-action-link' title='Editar' href='../views/iu_actualiza_trabajadores.php?cod=".$Rs['iCodTrabajador']."'><i class='fas fa-edit'></i></a>
                <a class='waves-effect waves-light btn btn-link nav-action-link' href='../views/iu_actualiza_key.php?cod=".$Rs['iCodTrabajador']."&usr=".$Rs['cUsuario']."' title='Cambio de Contraseña'><i class='fas fa-key'></i></a>
                <a class='waves-effect waves-light btn btn-link nav-action-link' onclick='enviarUsuario(".$Rs['iCodTrabajador'].")' title='Enviar Correo'><i class='fas fa-envelope'></i></a>
                <a class='waves-effect waves-light btn btn-link nav-action-link danger' href='../controllers/ln_elimina_trabajador.php?id=".$Rs['iCodTrabajador']." ' onClick='ConfirmarBorrado();' title='Eliminar' ><i class='far fa-trash-alt'></i></a></nav>";

    $data[]=$subdata;
}

$json_data = array(
    "draw"            => intval($request['draw']??0),
    "recordsTotal"    => intval( $recordsTotal ),
    "recordsFiltered" => intval( $recordsFiltered ),
    "data"            => $data
);

echo json_encode($json_data);