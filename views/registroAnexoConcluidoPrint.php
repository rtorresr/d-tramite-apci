<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
require("core.php");
$p_bcType = 1;
$p_text = $_GET[nCodBarra];
$p_textEnc = $_GET[nCodBarra];
$p_xDim = 1;
$p_w2n = 3;
$p_charHeight = 50;
$p_charGap = $p_xDim;
$p_type = 2;
$p_label = "N";
$p_checkDigit = "N";
$p_rotAngle = 0;
$dest = "wrapper.php?p_bcType=$p_bcType&p_text=$p_textEnc" . 
				"&p_xDim=$p_xDim&p_w2n=$p_w2n&p_charGap=$p_charGap&p_invert=$p_invert&p_charHeight=$p_charHeight" .
				"&p_type=$p_type&p_label=$p_label&p_rotAngle=$p_rotAngle&p_checkDigit=$p_checkDigit"
?>
<!DOCTYPE html>
<html lang="es">
<head>
</head>
<body>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="340" height="21">

	<table align="center" cellpadding="3" cellspacing="3" border="0">
	<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b></td></tr>
	<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;"><img src="<?php echo $dest;?>" ALT="<?php echo strtoupper($p_text); ?>" width="260"></td></tr>
	<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">ANEXO N&ordm;:&nbsp;<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?></i></td></tr>
    <!-- I MAX -->  
    <?php 
        $codigo = substr($_GET['cCodificacion'],0,10);
        $sqlRefcnt = "SELECT clave FROM Tra_M_Tramite WHERE cCodificacion = '".$codigo."'";
        $rsCnT1 = sqlsrv_query($cnx,$sqlRefcnt);
        $RsCnT2 = sqlsrv_fetch_array($rsCnT1);
        $clave  = $RsCnT2[0];
    ?>
    <tr>
        <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">CLAVE:&nbsp;<?php echo $clave; ?></i>
        </td>
    </tr>
    <!-- F MAX -->
	<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$_GET[fFechaHora]?></b></td></tr>
	<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b></td></tr>
    <?php 
        $sqlGenerador = "SELECT cNombresTrabajador, cApellidosTrabajador 
                         FROM Tra_M_Trabajadores 
                         WHERE iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
        $rsGenerador  = sqlsrv_query($cnx,$sqlGenerador);
        $RsGenerador  = sqlsrv_fetch_object($rsGenerador);
      ?>
      
      <tr>
        <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">
          <?php 
            echo "GENERADO POR :".$RsGenerador->cApellidosTrabajador.", ".$RsGenerador->cNombresTrabajador;
          ?>
        </td>
      </tr>
	</table>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<script language="JavaScript" type="text/javascript">
<!--

var da = (document.all) ? 1 : 0;
var pr = (window.print) ? 1 : 0;
var mac = (navigator.userAgent.indexOf("Mac") != -1);

function printWin()
{
    if (pr) {
        // NS4+, IE5+
        window.print();
    } else if (!mac) {
        // IE3 and IE4 on PC
        VBprintWin();
    } else {
        // everything else
        handle_error();
    }
}

window.onerror = handle_error;
window.onafterprint = function() {window.close()}

function handle_error()
{
    window.alert('Su navegador no admite la opci�n de impresi�n. Presione Control/Opci�n + P para imprimir.');
    return true;
}

if (!pr && !mac) {
    if (da) {
        // This must be IE4 or greater
        wbvers = "8856F961-340A-11D0-A96B-00C04FD705A2";
    } else {
        // this must be IE3.x
        wbvers = "EAB22AC3-30C1-11CF-A7EB-0000C05BAE0B";
    }

    document.write("<OBJECT ID=\"WB\" WIDTH=\"0\" HEIGHT=\"0\" CLASSID=\"CLSID:");
    document.write(wbvers + "\"> </OBJECT>");
}

// -->
</script>
  <script language="VBSCript" type="text/vbscript">
<!--

sub window_onunload
    on error resume next
    ' Just tidy up when we leave to be sure we aren't
    ' keeping instances of the browser control in memory
    set WB = nothing
end sub

sub VBprintWin
    OLECMDID_PRINT = 6
    on error resume next

    ' IE4 object has a different command structure
    if da then
        call WB.ExecWB(OLECMDID_PRINT, 1)
    else
        call WB.IOleCommandTarget.Exec(OLECMDID_PRINT, 1, "", "")
    end if
end sub

' -->
</script>
<script language="JavaScript" type="text/javascript">
<!--
printWin();
// -->
</script>
</body>
</html>
<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>