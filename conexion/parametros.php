<?php
// define("RUTA_DTRAMITE","http://localhost/d-tramite/");
define("RUTA_DTRAMITE","http://localhost:8000/");

define("FLG_AMBIENTE", 0); // 0 desarrollo, 1 produccion, 2 calidad

define("ID_APLICACION", 1);

define("ID_MOD_TRAMITE", 1);
define("ID_MOD_TRAMITE_SECUNDARIO", 2);

//define("ID_MOD_DESPACHO", 1);

define("RUTA_SIGTI_SERVICIOS", "http://dev.apci.gob.pe");
// define("RUTA_SIGTI_SERVICIOS", "http://localhost:64157/");
define("RUTA_SERVICIOS_PIDE", "https://qas.apci.gob.pe");


define("INTEROPERABILIDAD_ENTIDAD","http://200.48.76.125/wsentidad/Entidad?wsdl");
define("INTEROPERABILIDAD_TRAMITE","http://200.48.76.125/wsiopidetramite/IOTramite?wsdl");
define("FOLDER_TEMPS","archivosTemp");
define("ID_MESA_PARTES_VIRTUAL_USUARIO","318"); //cambiar a 318 en produccion
define("ID_MESA_PARTES_OFICINA","363");
define("ID_MESA_PARTES_PERFIL","2");
define("ID_SOLICITUD","37");

define("MAIL_SERVER","smtp.gmail.com");
define("MAIL_AUTH",true);
define("MAIL_USER","d-tramite@apci.gob.pe");
define("MAIL_PASSWORD","Hacker147");
define("MAIL_SSL",true);
define("MAIL_PORT",465);

define("FLG_GESTOR",false);
define("FLG_DOBLE_REPOSITORIO",false);

define("FILES_HOST","http://filesp.apci.gob.pe");
define("FILES_PORT","83");
define("FILES_PATH","/srv-files/");
define("FILES_FILE_UPLOAD","curl-srv.php");

define("RUTA_REPOSITORIO","http://192.168.1.83/Servicio_LF/Service1.svc?wsdl");
// define("RUTA_VISOR_REPOSITORIO","192.168.1.83/Visor_PDF/Visor/frmVisor_PDF.aspx?ID_DOC=");
// define("RUTA_DESCARGA_ANEXOS","views/descargaAnexos.php?id=");

define("VISOR_ARCHIVOS","mostrarDocumento.php?d=");

define("CORREO_SIGCTI","sigcti@apci.gob.pe");
define("CORREO_SOPORTE","soporte@apci.gob.pe");

define("RUTA_SERVICIO_CASILLA","http://192.168.1.43:8090/api");

define("DENOMINACION_DECENIO",'"Decenio de la Igualdad de Oportunidades para mujeres y hombres"');
define("DENOMINACION_ANIO_1",'"Año de la unidad, la paz y el desarrollo"');
define("DENOMINACION_ANIO_2",'');

define("USUARIO_SSO","8/user-dtramite");
define("PASSWORD_SSO","123456");
define("GRANT_TYPE_SSO","password");
?>