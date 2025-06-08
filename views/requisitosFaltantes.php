<?php
include_once('../conexion/conexion.php');
$params = array(
    $_POST['iCodTramite'],
    $_POST['iCodTupa']
);
$sql = "{call SP_REQUISITOS_FALTANTES (?,?) }";
$rs = sqlsrv_query($cnx, $sql, $params, array("Scrollable"=>"buffered"));
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
?>

<form name="formRequisitosFaltante" id="formRequisitosFaltante">
    <input type="hidden" name="nroRequisitosFaltantes" id="nroRequisitosFaltantes" value="<?=sqlsrv_num_rows($rs)?>">
    <table cellpadding="0" cellspacing="2" border="0"  class="table" id="tRequisitos">
        <?php
        while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)) {
            ?>
            <tr>
                <td valign=top width=155>
                    <label class='form-check-label' for='<?= $Rs["iCodTupaRequisito"] ?>'>
                        <input class='form-check-input' type='checkbox' name='iCodTupaRequisitoFaltante[]'
                               value='<?= $Rs["iCodTupaRequisito"] ?>'
                               id='<?= $Rs["iCodTupaRequisito"] ?>'>
                        <span><?= $Rs["cNomTupaRequisito"] ?></span>
                    </label>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>