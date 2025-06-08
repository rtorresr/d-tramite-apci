<style>
    .pagination li.active {
        background-color: #ff9e1b;
</style>
<?php
function paginar($pagactual, $total, $por_pagina, $enlace) {
    $total_paginas = ceil($total/$por_pagina);
    $anterior = $pagactual - 1;
    $posterior = $pagactual + 1;

    if ($pagactual>1) {
        $texto = "<ul class='pagination'>
                    <li class='waves-effect'><a href='$enlace$anterior'><i class='material-icons'><</i></a></li>";
    }else{
        $texto = "<ul class='pagination'>
                    <li class='disabled'><a href='#'><i class='material-icons'><</i></a></li>";
    }
    for ($i=1; $i<$pagactual; $i++){
        $texto .= "<li class='waves-effect'><a href='$enlace$i'>$i</a></li>";
    }

    $texto .= "<li class='active'><a href='#'>$pagactual</a></li>";

    for ($i=$pagactual+1; $i<=$total_paginas; $i++) {
        $texto .= "<li class='waves-effect'><a href='$enlace$i'>$i</a></li> ";
    }
    if ($pagactual<$total_paginas) {
        $texto .= "<li class='waves-effect'><a href='$enlace$posterior'><i class='material-icons'>></i></a></li></ul>";
    }else {
        $texto .= "<li class='disabled'><a href='#'><i class='material-icons'>></i></a></li></ul>";
    }
    return $texto;
}
?>