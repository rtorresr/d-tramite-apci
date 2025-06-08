<?php session_start();
if($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    $tipoRemitente = $_GET['tipoRemitente']??'';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <style>
            body{
                background: white;
            }
        </style>
    </head>
<body class="theme-default">
<div class="container">
    <form name="frmRegistro">
        <input type="hidden" name="opcion" value="1">
        <?	if($tipoRemitente==1) $ValortipoRemitente=1; if($tipoRemitente==2) $ValortipoRemitente=2;	?>
        <input type="hidden" name="tipoRemitente" value="<?=$ValortipoRemitente?>">
        <? require_once("../conexion/conexion.php");?>
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Agregar remitente</span>
                    </div>
                    <div class="card-body">
                        <fieldset>
                            <div class="row">
                                <div class="col s12 input-field">
                                        Tipo Persona:
                                        <p>
                                            <label for="tipoRemitente">
                                                <input type="radio" class="form-check-input" id="tipoRemitente" value="1" name="tipoRemitente" onclick="activaNatural();" <?php if($tipoRemitente==1) echo "checked"?>>
                                                <span>Persona Natural</span>
                                            </label>
                                        </p>
                                        <p>
                                            <label for="radioEmpresa">
                                                <input type="radio" class="form-check-input" id="radioEmpresa" value="2" name="tipoRemitente" onclick="activaEmpresa();" <?php if($tipoRemitente==2) echo "checked"?>>
                                                <span>Persona Jurídica</span>
                                            </label>
                                        </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 input-field">
                                    <input name="txtnom_remitente" id="txtnom_remitente" type="text" value="<?=$_GET['txtnom_remitente']??'';?>" maxlength="120" class="form-control form-control-sm">
                                    <label for="txtnom_remitente">
                                        <?php
                                            if($tipoRemitente==1 OR $tipoRemitente=="") echo "Nombre";
                                            if($tipoRemitente==2) echo "Razon Social:";
                                        ?>
                                    </label>
                                </div>
                                <div class="col s12 input-field">
                                    <input name="sigla" type="text" id="sigla" value="<?=$_GET['sigla']??'';?>" size="40" class="form-control form-control-sm">
                                    <label for="sigla">Sigla</label>
                                </div>
                                <div class="col s12 input-field">
                                    <select name="cTipoDocIdentidad" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                            searchable="Buscar aqui.." id="cTipoDocIdentidad"  >
                                        <option value="">Seleccione</option>
                                        <?php
                                        $sqlDoc="SELECT * FROM Tra_M_Doc_Identidad";
                                        $rsDoc=sqlsrv_query($cnx,$sqlDoc);
                                        while ($RsDoc=sqlsrv_fetch_array($rsDoc)){
                                            if($RsDoc["cTipoDocIdentidad"]==$_GET['cTipoDocIdentidad']){
                                                $selecClas="selected";
                                            }Else{
                                                $selecClas="";
                                            }
                                            echo utf8_encode("<option value=\"".$RsDoc["cTipoDocIdentidad"]."\" ".$selecClas.">".ucwords(strtolower($RsDoc["cDescDocIdentidad"]))."</option>");
                                        }
                                        sqlsrv_free_stmt($rsDoc);
                                        ?>
                                    </select>
                                    <label for="cTipoDocIdentidad">Documento</label>
                                </div>
                                <div class="col s12 input-field">
                                    <input name="txtnum_documento" id="txtnum_documento" type="text" value="<?=$_GET['txtnum_documento']??'';?>" size="20" class="form-control form-control-sm" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                    <label for="txtnum_documento">N&ordm; Documento</label>
                                </div>
                                <div class="col s12 input-field">
                                    <input name="txtdirec_remitente" id="txtdirec_remitente" type="text" value="<?=$_GET['txtdirec_remitente']??'';?>" maxlength="120" class="form-control form-control-sm">
                                    <label for="txtdirec_remitente">Dirección</label>
                                </div>
                                <div class="col s12 input-field">
                                    <input name="txtmail" type="text" id="txtmail" value="<?=$_GET['txtmail']??'';?>" size="40" class="form-control form-control-sm">
                                    <label for="txtmail">E-mail</label>
                                </div>
                                <div class="col s12 input-field">
                                        <input name="txtfono_remitente" id="txtfono_remitente" type="text" value="<?=$_GET['txtfono_remitente']??'';?>" size="15" class="form-control form-control-sm" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                        <label for="txtfono_remitente">Teléfono</label>
                                </div>
                                <div class="col s12 input-field">
                                    <input name="txtfax_remitente" id="txtfax_remitente" type="text" value="<?=$_GET['txtfax_remitente']??'';?>"  size="15" class="form-control form-control-sm" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                    <label for="txtfax_remitente">Fax</label>
                                </div>
                                <div class="col s12 input-field">
                                    <select name="cCodDepartamento" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." id="cCodDepartamento"  onChange="releer();">
                                        <option value="">Seleccione</option>
                                        <?php
                                            $sqlDep="select * from Tra_U_Departamento ";
                                            $rsDep=sqlsrv_query($cnx,$sqlDep);

                                            while ($RsDep=sqlsrv_fetch_array($rsDep)){
                                                if($RsDep["cCodDepartamento"]==$_GET['cCodDepartamento']){
                                                    $selecClas="selected";
                                                }else{
                                                    $selecClas="";
                                                }
                                                echo utf8_encode("<option value=".$RsDep["cCodDepartamento"]." ".$selecClas.">".ucwords(strtolower($RsDep["cNomDepartamento"]))."</option>");
                                            }

                                            sqlsrv_free_stmt($rsDep);
                                        ?>
                                    </select>
                                    <label for="cCodDepartamento">Departamento</label>
                                </div>
                                <div class="col s12 input-field">
                                    <select name="cCodProvincia" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." id="cCodProvincia" onChange="releer();" <?php if($_GET['cCodDepartamento']=="") echo "disabled"?> >
                                        <option value="">Seleccione</option>
                                        <?php
                                            $sqlPro="SELECT * from Tra_U_Provincia WHERE cCodDepartamento='$_GET[cCodDepartamento]' ";
                                            $rsPro=sqlsrv_query($cnx,$sqlPro);

                                            while ($RsPro=sqlsrv_fetch_array($rsPro)){
                                                if($RsPro["cCodProvincia"]==$_GET['cCodProvincia']){
                                                    $selecClas="selected";
                                                }else{
                                                    $selecClas="";
                                                }

                                                echo utf8_encode("<option value=".$RsPro["cCodProvincia"]." ".$selecClas.">".ucwords(strtolower($RsPro["cNomProvincia"]))."</option>");
                                            }

                                            sqlsrv_free_stmt($rsPro);
                                        ?>
                                    </select>
                                    <label for="cCodProvincia">Provincia</label>
                                </div>
                                <div class="col s12 input-field">
                                    <select name="cCodDistrito" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                            searchable="Buscar aqui.." id="cCodDistrito" <?php if($_GET['cCodProvincia']=="" || $_GET['cCodDepartamento']=="" ) echo "disabled"?> >
                                        <option value="">Seleccione</option>
                                        <?php
                                            $sqlDis="SELECT * from Tra_U_Distrito WHERE cCodDepartamento='".$_GET['cCodDepartamento']."' AND cCodProvincia='".$_GET['cCodProvincia']."'";
                                            $rsDis=sqlsrv_query($cnx,$sqlDis);
                                            while ($RsDis=sqlsrv_fetch_array($rsDis)){
                                                if($RsDis["cCodProvincia"]==$_POST['cCodProvincia']){
                                                    $selecClas="selected";
                                                }else{
                                                    $selecClas="";
                                                }
                                                echo utf8_encode("<option value=".$RsDis["cCodDistrito"]." ".$selecClas.">".ucwords(strtolower($RsDis["cNomDistrito"]))."</option>");
                                            }
                                            sqlsrv_free_stmt($rsDis);
                                        ?>
                                    </select>
                                    <label for="cCodDistrito">Distrito</label>
                                </div>
                                <div class="col s12 input-field">
                                    <input name="txtrep_remitente" type="text" id="txtrep_remitente" value="<?=$_GET['txtrep_remitente']??'';?>" size="40" class="form-control form-control-sm" style="text-transform:uppercase">
                                    <label for="txtrep_remitente">Representante</label>
                                </div>
                                <div class="col s12 input-field">
                                    <select name="txtflg_estado" id="txtflg_estado" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                            searchable="Buscar aqui..">
                                        <?php $txtflg_estado = $_GET['txtflg_estado']??'';?>
                                        <option value="1" <?php if($txtflg_estado==1) echo "selected"?>>Activo</option>
                                        <option value="2" <?php if($txtflg_estado==2) echo "selected"?>>Inactivo</option>
                                    </select>
                                    <label for="txtflg_estado">Estado</label>
                                </div>
                                <div class="col s12 input-field">
                                    <input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="NuevoRemitente();">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>   
            

            
            
        </div>
    </form>
</div>

<?php include("includes/pie.php"); ?>
<script Language="JavaScript">
    $('.mdb-select').formSelect();

    function activaNatural(){
        document.frmRegistro.tipoRemitente.value=1;
        document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
        document.frmRegistro.submit();
        return false;
    }

    function activaEmpresa(){
        document.frmRegistro.tipoRemitente.value=2;
        document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
        document.frmRegistro.submit();
        return false;
    }


    function releer(){
        document.frmRegistro.method="GET";
        document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
        document.frmRegistro.submit();
    }

    function NuevoRemitente()
    {
        if (document.frmRegistro.txtnom_remitente.value.length == "")
        {
            alert("Ingrese Nombre o Razón Social");
            document.frmRegistro.txtnom_remitente.focus();
            return (false);
        }
        document.frmRegistro.method="POST";
        document.frmRegistro.action="registroRemitentesDt.php";
        document.frmRegistro.submit();
    }

    </script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>