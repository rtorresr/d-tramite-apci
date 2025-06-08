<?php
require("../models/ad_login.php");
while ($Rs = sqlsrv_fetch_array($rs)) {
    echo $Rs[RAZON_SOCIAL] . "<br>";
}
echo sqlsrv_has_rows($rs);
sqlsrv_close($cnx);
?>