<?php

session_start();
If ($_SESSION['CODIGO_TRABAJADOR'] != "") {
    header("Location: ../index.html");
} Else {
    header("Location: ../index-b.php?alter=5");
}
?>