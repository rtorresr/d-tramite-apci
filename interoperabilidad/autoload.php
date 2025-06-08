<?php
function configuracion_autoload($classname){
    $ruta = '../interoperabilidad/config/'.$classname.'.php';
    if (file_exists($ruta)){
        include $ruta;
    }
}

function controller_autoload($classname){
    $ruta = '../interoperabilidad/controllers/'.$classname.'.php';
    if (file_exists($ruta)){
        include $ruta;
    }
}

function core_autoload($classname){
    $ruta = '../interoperabilidad/core/'.$classname.'.php';
    if (file_exists($ruta)){
        include $ruta;
    }
}

function model_autoload($classname){
    $ruta = '../interoperabilidad/models/'.$classname.'.php';
    if (file_exists($ruta)){
        include $ruta;
    }
}

spl_autoload_register('configuracion_autoload');
spl_autoload_register('controller_autoload');
spl_autoload_register('core_autoload');
spl_autoload_register('model_autoload');
