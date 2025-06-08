<?php
session_start();
unset($_SESSION['fUltimoAcceso']);
unset($_SESSION['iCodOficinaLogin']);
unset($_SESSION['iCodPerfilLogin']);
unset($_SESSION['CODIGO_TRABAJADOR']);
session_destroy();
?>