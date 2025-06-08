<?php

include_once("../../conexion/conexion.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../../core/CURLConection.php");

session_start();
date_default_timezone_set('America/Lima');

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    $fFecActual = date('Ymd').' '.date('G:i:s');
    $nNumAno    = date('Y');
    $nNumMes    = date('M');

    function add_ceros($numero,$ceros) {
        $insertar_ceros = 0;
        $order_diez = explode('.',$numero);
        $dif_diez = $ceros - strlen($order_diez[0]);
        for($m=0; $m<$dif_diez; $m++){
            $insertar_ceros .= 0;
        }
        return $insertar_ceros.= $numero;
    }

    $esProyecto = $_POST['proyecto']??'No';
    $flgSigo = $_POST['flgSigo']??0;
    $externo = $_POST['cCodTipoTra'];

    //SI EXISTEN ANEXOS A GRABAR
    if(isset($_POST['cAnexos'])){
        $anexos = $_POST['cAnexos'];
    }

    //SI EXISTEN REFERENCIAS
    if(isset($_POST['cReferencia'])){
        $referencias = $_POST['cReferencia'];
    }

    //SI EXISTEN ARCHIVOS POR SUBIR
    if (isset($_FILES['fileUpLoadDigital']) && ($_FILES['fileUpLoadDigital']['tmp_name'][0] !== '')) {
        $archivos = $_FILES['fileUpLoadDigital'];
    }

    // PROVIENE COMO RESPUESTA DE UN TRAMITE, BUSCA EL CODIGO DE TRAMITE DEL MOVIMIENTO DADO
    if(isset($_POST['iCodMovTramite'])){
        $rscodTra = sqlsrv_query($cnx, "SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = '".$_POST['iCodMovTramite']."'");
        $RscodTra = sqlsrv_fetch_array($rscodTra);
        $movimientoTra = $_POST['iCodMovTramite'];
        $iCodTramiteRespuesta = $RscodTra['iCodTramite'];
    }

    // PROVIENE COMO RESPUESTA DE UN PROYECTO, BUSCA EL CODIGO DE PROYECTO DEL MOVIMIENTO DADO
    if(isset($_POST['iCodMovProyecto'])){
        $rsProPro = sqlsrv_query($cnx, "SELECT iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = '".$_POST['iCodMovProyecto']."'");
        $RsProPro = sqlsrv_fetch_array($rsProPro);
        $movimientoPro = $_POST['iCodMovProyecto'];
        $iCodProyectoRespuesta = $RsProPro['iCodProyecto'];
    }

    // COSULTA TIPO DE DOCUMENTO
    if ($_POST['cCodTipoDoc'] !== '') {
        $sqlEspecial = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc = ".$_POST['cCodTipoDoc'];
        $rsEspecial  = sqlsrv_query($cnx,$sqlEspecial);
        $RsEspecial  = sqlsrv_fetch_array($rsEspecial);
    }
    //CONSULTA SI TIENE PLAZO
    if ($_POST['fFecPlazo']!==''){
        $separado2 = explode('-',$_POST['fFecPlazo']);
        $fFecPlazo = "'".$separado2[2].$separado2[1].$separado2[0]."'";
    }else{
        $fFecPlazo = 'null';
    }

    // SI ES PROYECTO
    if($esProyecto === 'Si') {
        // PROCEDIMIENTO DE CREACION DE PROYECTO, CREA AUTOMATICAMENTE FLAG DE ENVIO EN 0 POR QUE AUN NO ES DOCUMENTO
        $sqlAdd = " SP_DOC_ENTRADA_INTERNO_PROYECTO_INSERT 2 , ' ',	'" . $_SESSION['CODIGO_TRABAJADOR'] . "', '" . $_SESSION['iCodOficinaLogin'] . "','" . $_POST['cCodTipoDoc'] . "', '" . $fFecActual . "', ' ', ' ', '" . $_POST['cAsunto'] . "', '" . $_POST['cObservaciones'] . "', ' ', '" . $_POST['nNumFolio'] . "', " . $fFecPlazo . ",0, '" . $fFecActual . "',' ','',' ','" . $_POST['editorOficina'] . "', ' ', ' ' , '" . $_SESSION['cCodOfi'] . "' , '".$flgSigo."' , ' ',' ',' ',' ',' '";
        print_r($sqlAdd);
        $rs = sqlsrv_query($cnx, $sqlAdd);

        //ULTIMO PROYECTO CREADO
        $rsUltPro = sqlsrv_query($cnx, "SELECT TOP 1 iCodProyecto FROM Tra_M_Proyecto WHERE iCodTrabajadorRegistro ='" . $_SESSION['CODIGO_TRABAJADOR'] . "' ORDER BY iCodProyecto DESC");
        $RsUltPro = sqlsrv_fetch_array($rsUltPro);

        // REGISTRA CODIGO, RESPONSABLES, CARGO DEL DESTINO EXTERNO , ELIMINA LA SESSION GRABA Y CAMBIA A DOCUMENTO DE SALIDA SI ES EXTERNO
        if ($externo == '1') {
            $sqlDestinoExterno = "UPDATE Tra_M_Proyecto SET nFlgTipoDoc = 3 , iCodRemitente = '" . $_POST['nombreDestinoExterno'] . "', nombreResponsable = '" . $_POST['responsableDestinoExterno'] . "' , cargoResponsable = '" . $_POST['cargoResponsableDestinoExterno'] . "' , iCodSesionOficinaDestino = '' WHERE  iCodProyecto = " . $RsUltPro['iCodProyecto'];
            $rsDestinoExterno = sqlsrv_query($cnx, $sqlDestinoExterno);
        }

        //BUSCA EL JEFE DIRECTO Y LA OFICINA QUE PERTENECE
        if ($_SESSION['iCodPerfilLogin'] != '3') {
            $sqlOfiRespuesta = "SELECT iCodOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0  AND iCodOficina =  " . $_SESSION['iCodOficinaLogin'];
        } else {
            $sqlofi = "select iCodPadre from Tra_M_Oficinas where iCodOficina =" . $_SESSION['iCodOficinaLogin'];
            $qofice = sqlsrv_query($cnx, $sqlofi);
            $siglaoficina = sqlsrv_fetch_array($qofice);

            $sqlOfiRespuesta = "SELECT iCodOficina,cSiglaOficina FROM Tra_M_Oficinas WHERE iCodOficina = ".$siglaoficina['iCodPadre'];
        }


        // ENCUENTRA LA OFICINA DEL JEFE INMEDIATO
        $rsOficinaRespuesta = sqlsrv_query($cnx, $sqlOfiRespuesta);
        $RsOficinaRespuesta = sqlsrv_fetch_array($rsOficinaRespuesta);

        // CODIGO DEL JEFE INMEDIATO
        $sqlTraJefe = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = " . $RsOficinaRespuesta['iCodOficina'] . " AND iCodPerfil = 3";
        $rsTraJefe = sqlsrv_query($cnx, $sqlTraJefe);
        $RsTraJefe = sqlsrv_fetch_array($rsTraJefe);

        // INSERTA MOVIMIENTO DE PROYECTO HACIA EL JEFE DIRECTO
        $sqlMovPro = "INSERT INTO Tra_M_Tramite_Movimientos ";
        $sqlMovPro .= "(iCodProyecto,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,cFlgOficina,cCodTipoDocDerivar,paraAprobar)";
        $sqlMovPro .= " VALUES ";
        $sqlMovPro .= "('" . $RsUltPro['iCodProyecto'] . "','" . $_SESSION['CODIGO_TRABAJADOR'] . "', '' ,'" . $_SESSION['iCodOficinaLogin'] . "','" . $RsOficinaRespuesta['iCodOficina'] . "', '" . $RsTraJefe['iCodTrabajador'] . "','1','Media','" . $_POST['cAsunto'] . "','" . $_POST['cObservaciones'] . "','" . $fFecActual . "','" . $fFecActual . "',1,'1',1," . $_POST['cCodTipoDoc'] . ",1)";

        $rsMovPro = sqlsrv_query($cnx, $sqlMovPro);

        //ULTIMO MOVIMIENTO CREADO
        $sqlUltMovimiento = "SELECT TOP(1) iCodMovimiento FROM Tra_M_Tramite_Movimientos WHERE iCodTrabajadorRegistro = " . $_SESSION['CODIGO_TRABAJADOR'] . "  AND iCodOficinaOrigen = " . $_SESSION['iCodOficinaLogin'] . " ORDER BY iCodMovimiento DESC";
        $rsUltMovimiento = sqlsrv_query($cnx, $sqlUltMovimiento);
        $RsUltMovimiento = sqlsrv_fetch_array($rsUltMovimiento);

        // SI EL PROYECTO ES RESPUESTA DE UN DOCUMENTO
        if (isset($movimientoTra)) {
            // CAMBIA MOVIMIENTO DE LA BANDEJA DE PENDIENTES QUE SE ESTA RESPONDIENDO A RESPONDIDO
            $sqpResponder = "UPDATE Tra_M_Tramite_Movimientos  SET nEstadoMovimiento = 4 WHERE iCodMovimiento = " . $movimientoTra;
            $rsResponder = sqlsrv_query($cnx, $sqpResponder);

            //ACTUALIZA ULTIMO MOVIMIENTO CREADO CON EL MOVIMIENTO QUE ESTA RESPONDIENTO Y EL TRAMITE QUE ESTA RESPONDIENDO
            $sqpActUltMov = "UPDATE Tra_M_Tramite_Movimientos  SET iCodTramiteRespuesta = '" . $iCodTramiteRespuesta . "', iCodMovimientoRel = '" . $movimientoTra . "' WHERE iCodMovimiento = " . $RsUltMovimiento['iCodMovimiento'];
            $rsActUltMov = sqlsrv_query($cnx, $sqpActUltMov);

            //ACTUALZO EL PROYECTO CON EL TRAMITE QUE SE RESPONDE
            $rsActPro = sqlsrv_query($cnx,"UPDATE Tra_M_Proyecto SET iCodTramiteRespuesta = '".$iCodTramiteRespuesta."' WHERE iCodProyecto = ".$RsUltPro['iCodProyecto']);

            //GUARDA CUD DEL TRAMITE EN EL PROYECTO NUEVO
            $rsCud = sqlsrv_query($cnx,"SELECT nCud FROM Tra_M_Tramite WHERE iCodTramite = ".$iCodTramiteRespuesta);
            $RsCud = sqlsrv_fetch_array($rsCud);
            $rsActCud = sqlsrv_query($cnx,"UPDATE Tra_M_Proyecto SET nCud = '".$RsCud['nCud']."' WHERE iCodProyecto = ".$RsUltPro['iCodProyecto']);
        }

        //SI EL PROYECTO ES PROYECTO DE OTRO PROYECTO
        if (isset($movimientoPro)) {
            // CAMBIA MOVIMIENTO DE LA BANDEJA DE POR APROBAR QUE SE ESTA RESPONDIENDO EL PROYECTO A RESPONDIDO
            $sqpResponderPro = "UPDATE Tra_M_Tramite_Movimientos  SET nEstadoMovimiento = 4 WHERE iCodMovimiento = " . $movimientoPro;
            $RsResponderPro = sqlsrv_query($cnx, $sqpResponderPro);

            //ACTUALIZA ULTIMO MOVIMIENTO CREADO CON EL MOVIMIENTO QUE ESTA RESPONDIENTO Y EL PROYECTO QUE ESTA RESPONDIENDO
            $sqpActUltMov = "UPDATE Tra_M_Tramite_Movimientos  SET iCodProyectoRespuesta = '" . $iCodProyectoRespuesta . "', iCodMovimientoRel = '" . $movimientoPro . "' WHERE iCodMovimiento = " . $RsUltMovimiento['iCodMovimiento'];
            $rsActUltMov = sqlsrv_query($cnx, $sqpActUltMov);

            //ACTUALZO EL PROYECTO CON EL TRAMITE QUE SE RESPONDE
            $rsActPro = sqlsrv_query($cnx,"UPDATE Tra_M_Proyecto SET iCodProyectoRef = '".$iCodProyectoRespuesta."' WHERE iCodProyecto = ".$RsUltPro['iCodProyecto']);

            //GUARDA CUD DEL PROYECTO DEL QUE PROVIENE A AL RECIEN CREADO
            $rsCud = sqlsrv_query($cnx,"SELECT nCud FROM Tra_M_Proyecto WHERE iCodProyecto = ".$iCodProyectoRespuesta);
            $RsCud = sqlsrv_fetch_array($rsCud);
            if(TRIM($RsCud['nCud']) !== ''){
                $rsActCud = sqlsrv_query($cnx,"UPDATE Tra_M_Proyecto SET nCud = '".$RsCud['nCud']."' WHERE iCodProyecto = ".$RsUltPro['iCodProyecto']);
            }
        }

        // GUARDA LOS ANEXOS SELECCIONADOS COMO ANEXOS DEL PROYECTO
        if (isset($anexos)) {
            for ($i = 0; $i < count($anexos); $i++) {
                $anex = $anexos[$i];
                $rsdatosAnex = sqlsrv_query($cnx, "SELECT cNombreOriginal, cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE iCodDigital = " . $anex);
                $RsdatosAnex = sqlsrv_fetch_array($rsdatosAnex);

                $sqlanex = "INSERT INTO Tra_M_Tramite_Digitales (iCodProyecto, cNombreOriginal, cNombreNuevo, iCodTipoDigital) 
                                VALUES ('" . $RsUltPro['iCodProyecto'] . "', '" . $RsdatosAnex['cNombreOriginal'] . "', '" . $RsdatosAnex['cNombreNuevo'] . "', '3')";
                $rsanex = sqlsrv_query($cnx, $sqlanex);
            }
        }

        // SE GUARDAN LAS REFERENCIAS DEL PROYECTO SI ES QUE SE HAN AGREGADO
        if (isset($referencias)) {
            for ($i = 0; $i < count($referencias); $i++) {
                $ref = $referencias[$i];

                $sqlAdd = "INSERT INTO Tra_M_Tramite_Referencias ";
                $sqlAdd .= "(iCodTramiteRef, iCodProyecto)";
                $sqlAdd .= " VALUES ";
                $sqlAdd .= "('" . $ref . "', '" . $RsUltPro['iCodProyecto'] . "')";
                $rs = sqlsrv_query($cnx, $sqlAdd);
            }
        }

        //USUIARIO DEL TRABAJADOR
        $sqlNomUsr = "SELECT cUsuario FROM Tra_M_Trabajadores WHERE iCodTrabajador='" . $_SESSION['CODIGO_TRABAJADOR'] . "'";
        $rsNomUsr = sqlsrv_query($cnx, $sqlNomUsr);
        $RsNomUsr = sqlsrv_fetch_array($rsNomUsr);

        // CREA DATOS PARA GUARDAR DOCUMENTO EN EL SERVIDOR DE ARCHIVOS
        $nomenclatura = str_replace('/', '-', trim($RsOficinaRespuesta['cSiglaOficina'])) . '/' . $nNumAno . '/' . str_replace(' ', '-', trim($RsEspecial['cDescTipoDoc'])) . '/' . $nNumMes . '/' . trim($RsNomUsr['cUsuario']);
        $url_srv = $hostUpload . ':' . $port . $path;
        $url_f = 'docAnexos/' . $nomenclatura . '/';

        //GUARDA LOS ARCHIVOS NUEVOS CARGADOR
        if (isset($archivos)) {
            $curl = new CURLConnection($url_srv . $fileUpload);
            for ($i = 0; $i < count($archivos['tmp_name']); $i++) {
                $extension = explode('.', $archivos['name'][$i]);
                $num = count($extension) - 1;
                $cNombreOriginal = $archivos['name'][$i];

                $_FILES['fileUpLoadDigital']['tmp_name'] = $archivos['tmp_name'][$i];
                $_FILES['fileUpLoadDigital']['name'] = $archivos['name'][$i];
                $_FILES['fileUpLoadDigital']['type'] = $archivos['type'][$i];
                $_POST['path'] = $url_f;
                $_POST['name'] = 'fileUpLoadDigital';

                if ($extension[$num] == 'jpg' || $extension[$num] == 'jpeg' || $extension[$num] == 'png' || $extension[$num] == 'pdf' || $extension[$num] == 'doc' || $extension[$num] == 'docx' || $extension[$num] == 'xls' || $extension[$num] == 'xlsx' || $extension[$num] == 'ppt' || $extension[$num] == 'pptx') { //|| $extension[$num]==='dll' || $extension[$num]=== 'EXE' || $extension[$num]==='DLL'){
                    $nuevo_nombre = str_replace(' ', '-', trim($RsEspecial['cDescTipoDoc'])) . '-Proyecto-' . str_replace('/', '-', $RsUltPro['iCodProyecto']) . '-anexo-' . $i . '.' . $extension[$num];
                    $_POST['new_name'] = $nuevo_nombre;
                    $curl->uploadFile($_FILES, $_POST);

                    // GUARDA EN LA BASE DE DATOS LA DIRECCION DEL DOCUMENTO SIN LA DIRECCION DEL SERVIDOR
                    $url = $url_srv.$url_f . $nuevo_nombre;
                    $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodProyecto, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $RsUltPro['iCodProyecto'] . "', '" . $cNombreOriginal . "', '" . $url . "', '3')";
                    $rsDigt = sqlsrv_query($cnx, $sqlDigt);
                }
            }
        }
    }

    if($esProyecto === 'No') {
        // BUSCA EL CORRELATIVO DE LA OFICINA
        $sqlCorr = "SELECT * FROM Tra_M_Correlativo_Oficina WHERE cCodTipoDoc='" . $_POST['cCodTipoDoc'] . "' AND iCodOficina='" . $_SESSION['iCodOficinaLogin'] . "' AND nNumAno='" . $nNumAno . "'";
        $rsCorr = sqlsrv_query($cnx, $sqlCorr);

        if (sqlsrv_has_rows($rsCorr) > 0) {
            $RsCorr = sqlsrv_fetch_array($rsCorr);
            $nCorrelativo = $RsCorr['nCorrelativo'] + 1;

            $sqlUpd = "UPDATE Tra_M_Correlativo_Oficina  SET nCorrelativo='".$nCorrelativo."' WHERE iCodCorrelativo='" . $RsCorr['iCodCorrelativo'] . "'";
            $rsUpd = sqlsrv_query($cnx, $sqlUpd);
        } else {
            $sqlAdCorr = "INSERT INTO Tra_M_Correlativo_Oficina (cCodTipoDoc, iCodOficina, nNumAno, nCorrelativo) VALUES ('" . $_POST['cCodTipoDoc'] . "','" . $_SESSION['iCodOficinaLogin'] . "', '" . $nNumAno . "',1)";
            $rsAdCorr = sqlsrv_query($cnx, $sqlAdCorr);
            $nCorrelativo = 1;
        }

        //SIGLA DE LA OFICINA
        $rsSigla = sqlsrv_query($cnx, "SELECT cSiglaOficina, * FROM Tra_M_Oficinas WHERE iCodOficina='" . $_SESSION['iCodOficinaLogin'] . "'");
        $RsSigla = sqlsrv_fetch_array($rsSigla);

        // CODIFICACIÓN CON EL CORRELATIVO CREADO
        $cCodificacion = add_ceros($nCorrelativo, 4) . '-' . date('Y') . '-APCI/' . trim($RsSigla['cSiglaOficina']);

        //SE CREA EL TRAMITE CON FLAG DE ENVIO 0
        $sqlAdd = " SP_DOC_ENTRADA_INTERNO_INSERT 2 ,'" . $cCodificacion . "',	'" . $_SESSION['CODIGO_TRABAJADOR'] . "', '" . $_SESSION['iCodOficinaLogin'] . "','" . $_POST['cCodTipoDoc'] . "', '" . $fFecActual . "', ' ', ' ', '" . $_POST['cAsunto'] . "', '" . $_POST['cObservaciones'] . "', ' ', '" . $_POST['nNumFolio'] . "', " . $fFecPlazo . ",0, '" . $fFecActual . "','','',' ','" . $_POST['editorOficina'] . "'";
        $rsAdd = sqlsrv_query($cnx, $sqlAdd);

        //ULTIMO TRAMITE CREADO
        $rsUltTra = sqlsrv_query($cnx, "SELECT TOP 1 iCodTramite FROM Tra_M_Tramite WHERE iCodTrabajadorRegistro ='" . $_SESSION['CODIGO_TRABAJADOR'] . "' ORDER BY iCodTramite DESC");
        $RsUltTra = sqlsrv_fetch_array($rsUltTra);

        // AGREGA REMITENTE Y DATOS DEL RESPONSABLE SI ES EXTERNO, ADEMAS CAMBIA TIPO DE DOCUMENTO
        if($externo == '1'){
            $sqlDestinoExterno = "UPDATE Tra_M_Tramite SET nFlgTipoDoc = 3 , iCodRemitente = '".$_POST['nombreDestinoExterno']."', nombreResponsable = '".$_POST['responsableDestinoExterno']."' , cargoResponsable = '".$_POST['cargoResponsableDestinoExterno']."' WHERE iCodTramite = " . $RsUltTra['iCodTramite'];
            $rsDestinoExterno = sqlsrv_query($cnx, $sqlDestinoExterno);
        }

        // ACTUALIZA SI PROVIENE DEL SIGO O NO
        $sqlUpdate = "UPDATE Tra_M_Tramite SET flgSigo = '".$flgSigo."' WHERE iCodTramite = " . $RsUltTra['iCodTramite'];
        $rslUpdate = sqlsrv_query($cnx, $sqlUpdate);

        // GUARDA LOS ANEXOS SELECCIONADOS COMO ANEXOS DEL TRAMITE
        if (isset($anexos)) {
            for ($i = 0; $i < count($anexos); $i++) {
                $anex = $anexos[$i];
                $rsdatosAnex = sqlsrv_query($cnx, "SELECT cNombreOriginal, cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE iCodDigital = " . $anex);
                $RsdatosAnex = sqlsrv_fetch_array($rsdatosAnex);

                $sqlanex = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) 
                                VALUES ('" . $RsUltTra['iCodTramite'] . "', '" . $RsdatosAnex['cNombreOriginal'] . "', '" . $RsdatosAnex['cNombreNuevo'] . "', '3')";
                $rsanex = sqlsrv_query($cnx, $sqlanex);
            }
        }

        // SE GUARDAN LAS REFERENCIAS DEL PROYECTO SI ES QUE SE HAN AGREGADO
        if (isset($referencias)) {
            for ($i = 0; $i < count($referencias); $i++) {
                $ref = $referencias[$i];

                $sqlAdd = "INSERT INTO Tra_M_Tramite_Referencias ";
                $sqlAdd .= "(iCodTramiteRef, iCodTramite)";
                $sqlAdd .= " VALUES ";
                $sqlAdd .= "('" . $ref . "', '" . $RsUltTra['iCodTramite'] . "')";
                $rs = sqlsrv_query($cnx, $sqlAdd);
            }
        }

        //INSERTA MOVIMIENTOS POR CADA REGISTRO DE TABLA DE TRAMITE_TEMPORAL
        if($externo == '0'){
            // SACA LOS TRAMITES TEMPORALES DE LA SESSION QUE YA FUE MODIFICADA ANTERIORMENTE
            $sqlMv = "SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='" . $_SESSION['cCodOfi'] . "' ORDER BY iCodTemp ASC";
            $rsMv = sqlsrv_query($cnx,$sqlMv);

            while ($RsMv = sqlsrv_fetch_array($rsMv)) {
                // INGRESA MOVIMIENTO A TODOS LOS JEFES GRABADOS
                $sqlAdMv = "INSERT INTO Tra_M_Tramite_Movimientos ";
                $sqlAdMv .= "(iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cFlgCopia,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,cFlgOficina,cCodTipoDocDerivar)";
                $sqlAdMv .= " VALUES ";
                $sqlAdMv .= "('" . $RsUltTra['iCodTramite'] . "','" . $_SESSION['CODIGO_TRABAJADOR'] . "','2','" . $_SESSION['iCodOficinaLogin'] . "','" . $RsMv['iCodOficina'] . "', '" . $RsMv['iCodTrabajador'] . "','" . $RsMv['iCodIndicacion'] . "','" . $RsMv['cPrioridad'] . "','".$RsMv['flgCopia']."','" . $_POST['cAsunto'] . "','" . $_POST['cObservaciones'] . "','" . $fFecActual . "','" . $fFecActual . "',1,'1',1," . $_POST['cCodTipoDoc'] . ")";
                $rsAdMv = sqlsrv_query($cnx, $sqlAdMv);
            }

        // SI ES EXTERNO SE CREA MOVIMIENTO DIRECTAMENTE A MESA DE PARTES
        } else {
            $sqlAdMv = "INSERT INTO Tra_M_Tramite_Movimientos ";
            $sqlAdMv .= "(iCodTramite,iCodTrabajadorRegistro,nFlgTipoDoc,iCodOficinaOrigen,iCodOficinaDerivar,iCodTrabajadorDerivar,iCodIndicacionDerivar,cPrioridadDerivar,cFlgCopia,cAsuntoDerivar,cObservacionesDerivar,fFecDerivar,fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,cFlgOficina,cCodTipoDocDerivar)";
            $sqlAdMv .= " VALUES ";
            $sqlAdMv .= "('" . $RsUltTra['iCodTramite'] . "','" . $_SESSION['CODIGO_TRABAJADOR'] . "','3','" . $_SESSION['iCodOficinaLogin'] . "','363', '173','1','Alta','0','" . $_POST['cAsunto'] . "','" . $_POST['cObservaciones'] . "','" . $fFecActual . "','" . $fFecActual . "',1,'1',1," . $_POST['cCodTipoDoc'] . ")";
            $rsAdMv = sqlsrv_query($cnx, $sqlAdMv);
        }

        // SI ES UN DOCUMENTO DE RESPUESTA A OTRO TRAMITE
        if (isset($movimientoTra)) {
            // CAMBIA MOVIMIENTO DE LA BANDEJA DE PENDIENTES QUE SE ESTA RESPONDIENDO A RESPONDIDO
            $sqpResponder = "UPDATE Tra_M_Tramite_Movimientos  SET nEstadoMovimiento = 4 WHERE iCodMovimiento = ".$movimientoTra;
            $rsResponder = sqlsrv_query($cnx, $sqpResponder);

            //ACTUALIZA LOS ULTIMOS MOVIMIENTOS CREADOS CON EL MOVIMIENTO QUE ESTA RESPONDIENTO Y EL TRAMITE QUE ESTA RESPONDIENDO
            $sqpActUltMov = "UPDATE Tra_M_Tramite_Movimientos  SET iCodTramiteRespuesta = '" . $iCodTramiteRespuesta . "', iCodMovimientoRel = '" . $movimientoTra . "' WHERE iCodTramite = ".$RsUltTra['iCodTramite'];
            $rsActUltMov = sqlsrv_query($cnx, $sqpActUltMov);

            //ACTUALZO EL TRAMITE CON EL TRAMITE QUE SE RESPONDE
            $rsActPro = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET iCodTramiteRespuesta = '".$iCodTramiteRespuesta."' WHERE iCodTramite = ".$RsUltTra['iCodTramite']);

            //GUARDA CUD DEL TRAMITE EN EL TRAMITE NUEVO
            $rsCud = sqlsrv_query($cnx,"SELECT nCud FROM Tra_M_Tramite WHERE iCodTramite = ".$iCodTramiteRespuesta);
            $RsCud = sqlsrv_fetch_array($rsCud);
            $rsActCud = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nCud = '".$RsCud['nCud']."' WHERE iCodTramite = ".$RsUltTra['iCodTramite']);
        }

        //SI EL TRAMITE  PROYECTO
        if (isset($movimientoPro)) {
            // CAMBIA MOVIMIENTO DE LA BANDEJA DE POR APROBAR QUE SE ESTA RESPONDIENDO EL PROYECTO A RESPONDIDO
            $sqpResponderPro = "UPDATE Tra_M_Tramite_Movimientos  SET nEstadoMovimiento = 4 WHERE iCodMovimiento = " . $movimientoPro;
            $RsResponderPro = sqlsrv_query($cnx, $sqpResponderPro);

            //ACTUALIZA LOS ULTIMOS MOVIMIENTOS CREADOS CON EL MOVIMIENTO QUE ESTA RESPONDIENTO Y EL PROYECTO QUE ESTA RESPONDIENDO
            $sqpActUltMov = "UPDATE Tra_M_Tramite_Movimientos  SET iCodProyectoRespuesta = '" . $iCodProyectoRespuesta . "', iCodMovimientoRel = '" . $movimientoPro . "' WHERE iCodTramite = " . $RsUltTra['iCodTramite'];
            $rsActUltMov = sqlsrv_query($cnx, $sqpActUltMov);

            //ACTUALZO EL TRAMITE CON EL PROYECTO QUE SE RESPONDE
            $rsActPro = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET iCodProyectoRef = '".$iCodProyectoRespuesta."' WHERE iCodTramite = ".$RsUltTra['iCodTramite']);

            //GUARDA CUD DEL PROYECTO DEL QUE PROVIENE A AL RECIEN CREADO
            $rsCud = sqlsrv_query($cnx,"SELECT nCud FROM Tra_M_Proyecto WHERE iCodProyecto = ".$iCodProyectoRespuesta);
            $RsCud = sqlsrv_fetch_array($rsCud);
            if(TRIM($RsCud['nCud']) !== ''){
                $rsActCud = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nCud = '".$RsCud['nCud']."' WHERE iCodTramite = ".$RsUltTra['iCodTramite']);
            }

            // ACTUALIZA PROYECTO EN 1 PARA INDICAR QUE SE CREO UN DOCUMENTO
            $sqlUpProyecto = sqlsrv_query($cnx,"UPDATE Tra_M_Proyecto SET nFlgEnvio = '1' WHERE iCodProyecto = ".$iCodProyectoRespuesta);
        }

        //CONSULTA SI HAY CUD GUARDADO
        $rsCudHay = sqlsrv_query($cnx,"SELECT nCud FROM Tra_M_Tramite WHERE iCodTramite = ".$RsUltTra['iCodTramite']);
        $RsCudHay = sqlsrv_fetch_array($rsCudHay);

        // SI NO ES NINGUNO DE LOS CASOS REGISTRA NUEVO CUD
        if(TRIM($RsCudHay['nCud']) == ''){
            $sqlCorrCud = "SELECT max(nCorrelativo) nCorrelativo FROM Tra_M_Correlativo WHERE nNumAno = year(GETDATE())";
            $rsCorrCud = sqlsrv_query($cnx, $sqlCorrCud);
            if (sqlsrv_has_rows($rsCorrCud) > 0) {
                $RsCorrCud = sqlsrv_fetch_array($rsCorrCud);
                $nCorrelativoCud = $RsCorrCud['nCorrelativo'] + 1;
                $sqlUpdCud = "UPDATE Tra_M_Correlativo  SET nCorrelativo = ".($RsCorrCud['nCorrelativo'] + 1)." WHERE nNumAno= year(GETDATE())";
                $rsUpdCud = sqlsrv_query($cnx, $sqlUpdCud);
            } else {
                $nCorrelativoCud = 1;
                $sqlAdCorrCud = "INSERT INTO Tra_M_Correlativo (nCorrelativo, nNumAno) VALUES ('".$nCorrelativoCud."' , year(GETDATE()))";
                $rsAdCorrCud = sqlsrv_query($cnx, $sqlAdCorrCud);
            }
            // genera numero de cud
            $nCud = add_ceros($nCorrelativoCud,4)."-".$nNumAno;

            // actualiza tramite el numero de cud
            $sqlUpdateCud = "UPDATE Tra_M_Tramite SET nCud = '".$nCud."'  WHERE iCodTramite = " . $RsUltTra['iCodTramite'];
            $rslUpdateCud = sqlsrv_query($cnx, $sqlUpdateCud);
        }

        $fFecActual = date('d-m-Y G:i');

        //DATOS DEL TRABAJADOR
        $sqlNomUsr = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='" . $_SESSION['CODIGO_TRABAJADOR'] . "'";
        $rsNomUsr = sqlsrv_query($cnx, $sqlNomUsr);
        $RsNomUsr = sqlsrv_fetch_array($rsNomUsr);

        // ARMA RUTA DE LOS NUEVOS DOCUMENTOS
        $nomenclatura = str_replace('/', '-', trim($RsSigla['cSiglaOficina'])) . '/' . $nNumAno . '/' . str_replace(' ', '-', trim($RsEspecial['cDescTipoDoc'])) . '/' . $nNumMes . '/' . trim($RsNomUsr['cUsuario']);
        $url_srv = $hostUpload . ':' . $port . $path;
        $url_f = 'docAnexos/' . $nomenclatura . '/';


        if (isset($archivos)) {
            $curl = new CURLConnection($url_srv . $fileUpload);

            for ($i = 0; $i < count($archivos['tmp_name']); $i++) {
                $extension = explode('.', $archivos['name'][$i]);
                $num = count($extension) - 1;
                $cNombreOriginal = $archivos['name'][$i];


                $_FILES['fileUpLoadDigital']['tmp_name'] = $archivos['tmp_name'][$i];
                $_FILES['fileUpLoadDigital']['name'] = $archivos['name'][$i];
                $_FILES['fileUpLoadDigital']['type'] = $archivos['type'][$i];

                $_POST['path'] = $url_f;
                $_POST['name'] = 'fileUpLoadDigital';

                if ($extension[$num] == 'jpg' || $extension[$num] == 'jpeg' || $extension[$num] == 'png' || $extension[$num] == 'pdf' || $extension[$num] == 'doc' || $extension[$num] == 'docx' || $extension[$num] == 'xls' || $extension[$num] == 'xlsx' || $extension[$num] == 'ppt' || $extension[$num] == 'pptx') {
                    $nuevo_nombre = str_replace(' ', '-', trim($RsEspecial['cDescTipoDoc'])) . '-' . str_replace('/', '-', $cCodificacion) . '-anexos-' . $i . '.' . $extension[$num];
                    $_POST['new_name'] = $nuevo_nombre;
                    $curl->uploadFile($_FILES, $_POST);
                    $url = $url_srv . $url_f . $nuevo_nombre;
                    $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo, iCodTipoDigital) VALUES ('" . $RsUltTra['iCodTramite'] . "', '" . $cNombreOriginal . "', '" . $url . "', '3')";
                    $rsDigt = sqlsrv_query($cnx, $sqlDigt);

                }
            }
        }
//*************************************
        include("../documento_pdf.php");

        $arr = array(
            'url' => $url,
            'tra' => $RsUltTra['iCodTramite']
        );
        echo json_encode($arr);
    }
}else{
    header("Location: ../../index-b.php?alter=5");
}
