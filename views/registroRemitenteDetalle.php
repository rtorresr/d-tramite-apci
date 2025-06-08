<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
require_once("../conexion/conexion.php");
?>


                 <main>
                     <div class="container">
                         <form name="frmRegistroRemitente">
                             <input type="hidden" name="opcion" value="1">
                             <?php
                             if(!isset($_GET['clear'])){$dir=$_GET['txtdirec_remitentex'];}
                             else{ $dir = $_POST['txtdirec_remitente']??'';}
                             if(!isset($_GET['clear'])){$dep=$_GET['cCodDepartamentox'];}
                             else{$dep = $_POST['cCodDepartamento']??'';}
                             if(!isset($_GET['clear'])){$pro=$_GET['cCodProvinciax'];}
                             else{$pro = $_POST['cCodProvincia']??'';}
                             if(!isset($_GET['clear'])){ $dis=$_GET['cCodDistritox'];}
                             else{$dis =  $_POST['cCodDistrito']??'';}
                             ?>
                             <input id="iCodRemitentex" name="iCodRemitentex" type="hidden" value="<?=$_REQUEST['iCodRemitente']?>">
                             <input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$_REQUEST['iCodRemitente']?>">
                             <input id="txtdirec_remitentex" name="txtdirec_remitentex" type="hidden" value="<?=$dir??''?>">
                             <input id="cCodDepartamentox" name="cCodDepartamentox" type="hidden" value="<?=$dep??''?>">
                             <input id="cCodProvinciax" name="cCodProvinciax" type="hidden" value="<?=$pro??''?>">
                             <input id="cCodDistritox" name="cCodDistritox" type="hidden" value="<?=$dis??''?>">
                             <div class="row">
                                 <div class="col s12 m12">
                                     <div class="card hoverable">
                                         <div class="card-body">
                                             <fieldset>
                                                 <legend>Datos</legend>
                                                 <div class="row">
                                                     <div class="col s12 m12 l12 input-field">
                                                         <input id="txtdirec_remitente" name="txtdirec_remitente" type="text" value="<?=$dir??''?>" maxlength="120" size="70" class="FormPropertReg form-control">
                                                         <label for="txtdirec_remitente">Dirección</label>
                                                     </div>
                                                     <div class="col s12 m12 l12 input-field">
                                                         <select name="cCodDepartamento" class="FormPropertReg form-control" id="cCodDepartamento" style="width:236px" onChange="releer()">
                                                             <option value="">Seleccione</option>
                                                             <?php
                                                             $sqlDep="select * from Tra_U_Departamento ";
                                                             $rsDep=sqlsrv_query($cnx,$sqlDep);
                                                             while ($RsDep=sqlsrv_fetch_array($rsDep)){
                                                                 if($RsDep["cCodDepartamento"]==$dep){
                                                                     $selecClas="selected";
                                                                 }else{
                                                                     $selecClas="";
                                                                 }
                                                                 echo utf8_encode("<option value=".$RsDep["cCodDepartamento"]." ".$selecClas.">".$RsDep["cNomDepartamento"]."</option>");
                                                             }
                                                             sqlsrv_free_stmt($rsDep);
                                                             ?>
                                                         </select>
                                                         <label for="cCodDepartamento">Departamento</label>
                                                     </div>
                                                     <div class="col s12 m12 l12 input-field">
                                                         <select name="cCodProvincia"  class="FormPropertReg form-control" id="cCodProvincia" onChange="releer()" style="width:236px" <?php if($dep=="") echo "disabled"?> >
                                                             <option value="">Seleccione:</option>
                                                             <?php
                                                             $sqlPro="SELECT * from Tra_U_Provincia WHERE cCodDepartamento=".$dep;
                                                             $rsPro=sqlsrv_query($cnx,$sqlPro);
                                                             while ($RsPro=sqlsrv_fetch_array($rsPro)){
                                                                 if($RsPro["cCodProvincia"]==$pro){
                                                                     $selecPro="selected";
                                                                 }else{
                                                                     $selecPro="";
                                                                 }
                                                                 echo utf8_encode("<option value=".$RsPro["cCodProvincia"]." ".$selecPro.">".$RsPro["cNomProvincia"]."</option>");
                                                             }
                                                             sqlsrv_free_stmt($rsPro);
                                                             ?>
                                                         </select>
                                                         <label for="cCodProvincia">Provincia</label>
                                                     </div>
                                                     <div class="col s12 m12 l12 input-field">
                                                         <select name="cCodDistrito" class="FormPropertReg form-control" id="cCodDistrito" onChange="releer()" style="width:236px" <?php if($dep=="" || $pro=="" ) echo "disabled"?> >
                                                             <option value="">Seleccione:</option>
                                                             <?php
                                                             $sqlDis="SELECT * from Tra_U_Distrito WHERE cCodDepartamento='$dep' AND cCodProvincia='$pro'";
                                                             $rsDis=sqlsrv_query($cnx,$sqlDis);
                                                             while ($RsDis=sqlsrv_fetch_array($rsDis)){
                                                                 if($RsDis["cCodDistrito"]==$dis){
                                                                     $selecDis="selected";
                                                                 }else{
                                                                     $selecDis="";
                                                                 }
                                                                 echo utf8_encode("<option value=".$RsDis["cCodDistrito"]." ".$selecDis.">".$RsDis["cNomDistrito"]."</option>");
                                                             }
                                                             sqlsrv_free_stmt($rsDis);
                                                             ?>
                                                         </select>
                                                         <label for="cCodDistrito">Distrito</label>
                                                     </div>
                                                 </div>
                                             </fieldset>
                                         </div>
                                     </div>
                                 </div>
                             </div>
<!--                             <input name="button" type="button" class="btn btn-primary" value="Modificar" onClick="sendValue(this.form.txtdirec_remitente,this.form.cCodDepartamento,this.form.cCodProvincia,this.form.cCodDistrito);">-->
                         </form>
                     </div>
                 </main>

    <script>
        $(document).ready(function(){
            $('select').formSelect();
        });

        function sendValue (s,t,x,y){
            var selvalue1 = s.value;
            var selvalue2 = t.value;
            var selvalue3 = x.value;
            var selvalue4 = y.value;
            let parametros = {
                opcion: 1,
                cDireccion: selvalue1,
                cDepartamento: selvalue2,
                cProvincia: selvalue3,
                cDistrito: selvalue4,
                iCodRemitente: '<?=$_REQUEST['iCodRemitente']; ?>'
            };

            let dep = $( "#cCodDepartamento option:selected" ).text();
            let pro = $( "#cCodProvincia option:selected" ).text();
            let dis = $( "#cCodDistrito option:selected" ).text();

            $.ajax({
                cache: false,
                url: "iu_remitentes_data.php",
                method: "POST",
                data: parametros,
                datatype: "text",
                success: function () {
                    window.opener.document.getElementById('txtdirec_remitente').value = selvalue1;
                    window.opener.document.getElementById('cNomRemite').value = selvalue1+' '+dep.trim()+', '+pro.trim()+', '+dis.trim();
                    window.opener.document.getElementById('cCodDepartamento').value = selvalue2;
                    window.opener.document.getElementById('cCodProvincia').value = selvalue3;
                    window.opener.document.getElementById('cCodDistrito').value = selvalue4;
                    window.opener.document.frmRegistro.cNomRemite.focus();
                    window.close();
                }
            });
        }

        function releer(){
            document.frmRegistro.method="POST";
            document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1";
            document.frmRegistro.submit();
        }
        function NuevoRemitente()
        {
            if (document.frmRegistro.txtnom_remitente.value.length == "")
            {
                alert("Ingrese Nombre o Razón Social");
                document.frmRegistro.cNombreRemitente.focus();
                return (false);
            }
            document.frmRegistro.method="POST";
            document.frmRegistro.action="registroRemitentesDt.php";
            document.frmRegistro.submit();
        }
    </script>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>