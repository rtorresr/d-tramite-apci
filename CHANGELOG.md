# Changelog
Todos los cambios importantes serán anotados en este documento.

Formato basado en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)

## [2.0.0] - 2019-01-16
### Added
- Se ha mejorado la funcionalidad en la opción de respuesta de documentos, permitiendo incluir otro destinatario diferente al origen del documento, además se ha incluido una referenciación automatizada que permitirá una mejor trazabilidad del documento.
- Se ha mejorado el proceso de digitalización en mesa de partes, debido a que se ha observado que algunos archivos no estaban siendo cargados en el sistema, para estar seguros sobre el correcto funcionamiento de la red se ha revisado el switch (conmutador) del primer piso, el cual muestra perdida de paquetes, lo que ocasionaba que no se pudieran subir algunos archivos. Se ha implementado una bandeja de archivos incompletos para evitar esta problemática.
- Se ha agregado la funcionalidad de cuentas multiroles, que incluyen más de un firma lo cual facilita que los jefes y/o especialistas puedan firmar y visar con diferentes sellos gráficos.
- Se ha mejorado la funcionalidad para adjuntar anexos en los documentos, ahora permite gestionar (adicionar y suprimir) anexos según lo requiera el usuario, así como el tipo de anexo que se adjuntará (Word, Excel, Pdf).
- Se ha incluido las dependencias de STPAD, TRANSPARENCIA, ACCESO A LA INFORMACIÓN PÚBLICA, EJECUTORA COACTIVA y CAFAE en el sistema.
- Se ha concluido con la funcionalidad para el envío de documentos externos, adicionando los campos Departamento, Provincia y Distrito al destinatario del documento.
- Se ha incluido en la funcionalidad de generación del documento PDF,  información referente a archivos adjuntos y CUD en la parte inferior del mismo.
- Se ha incluido la funcionalidad de agregar copias a distintos destinatarios en la generación de documentos internos.
- Se ha estandarizado la información de Ubigeo en los remitentes de los documentos externos.
- Se ha incluido la funcionalidad de “Postergar Documentos” automáticamente, para evitar la pérdida de documentos cuando no se concluye el proceso de firmado. Estos documentos se derivan temporalmente a la “Bandeja Por Aprobar” hasta que el usuario concluye satisfactoria el firmado.
- Se ha incluido la funcionalidad para la delegación de firma (se ha agregado la posibilidad de que el asesor firme a nombre del Director Ejecutivo)

### Changed
- Se ha actualizado el editor de texto, la cual incluye funcionalidades nuevas (sangría de párrafos, pegado desde Excel y Word, colores, etc), para mejorar el proceso de registro de un documento.
- Se ha optimizado el registro de destinatarios de los proyectos internos, los cuales se han incluido en el formulario de “Revisar Documento” para evitar el reingreso de la información y agilizar el proceso de registro.
- Se ha adicionado un botón para visualizar los documentos escaneados en la Consulta General, facilitando el seguimiento de los documentos gestionados en el sistema.
- Las indicaciones y prioridad de los documentos se han ubicado únicamente en las derivaciones y delegaciones, retirándolos  del formulario de creación de proyectos y documentos.

### Pending
- Se implementará la funcionalidad para que los jefes puedan generar memorandos para el personal de su dirección. (fecha de implementación: 25/01/2019)
- Se ha avanzado en un 60% la nueva funcionalidad de creación de múltiples proyectados en un solo movimiento. (fecha de implementación: 29/01/2019)
- Se está avanzando en el desarrollo de nuevos reportes como enviados, firmados, proyectos, etc. (fecha de implementación: 31/01/2019)
- Se está desarrollando la funcionalidad para envío de documentos múltiples externos. (fecha de implementación: 31/01/2019)
- Se actualizará el diseño las plantillas con el manual de imagen institucional aprobado. (fecha de implementación: 22/01/2019)

## [2.0.1] - 2019-01-16

### Added 
ajaxPostFirma.php
- Se creo para que cambie el estado de movimiento a firmado y cambie el estado de tramite a completado

### Changed
registroOficina.php
- Se agrego validación para cuando se quiere enviar proyecto a especialista no sea posible. 
- Se cambió el sending por sendingmultiple para que solo haya un success al finalizar la subida de todos
los documentos adjuntos (anteriormente por cada file hacia el script de success).

firmarDocumento.php
-Se redirecciono el volver a la ventana principal.
- Se cambió para el firma en vez de obtener datos por GET sea por POST.
- Al ser firmado correctamente recien se actuaoiza los movimientos.

ajaxPostVisto.php
-Se modificó ajax al vissar que cambia de estado el movimiento, anteriormente cambiaba a derivado
ahora se cambia a visado

envioVisto.php
-Se modifico para al aceptar el envío para visto el movimiento del proyecto anterior cambie a respondido

flujodoc.php
-Se actualizó el flujo del documento para que busqué aquellos anteriorres y posteriores

save.php
- Se cambiò logica de inserción de los digitales para cuando es visto y firmado, además se depuró para 
que solo sea inserción del documento.

registrarDocumentoInterno.php
- Se agregó la numeración de anexos para que no se sobre escriban al ser subidos al servidor.

registroDocumentoOficina.php 
- Se modificó el registro de proyectos al de desarrollo puesto que el store de registro de producción
es diferente.

bandeja-por-aprobar.php
- Se habilitó la firma para especialistas.
- Se quito input sin uso cuando se manda para firmar.
- Se modifico la función de success cuando el documento fue visado correctamente.
- Se reemplazó el secondary button por el boton de firma.
- El boton de visto se cambio el parametro obtenido.

pathTramite.php 
- Se cambió nombre de respuesta a idtra

consulta-general.php
- Se cambió el consultaFlujo.php por flujodoc.php

documento_pdf.php

Se modificó el generador de pdf para los documentos internos multiples a mas de 13 personas.

envioVisto.php
El movimiento se actualzia a visado y ya no a derivado.

previsualizacion-pdf.php
- Se cambió para la misma funcionalidad del documento_pdf.php

registroTrabajador.php
- Lo mismo que en registro oficina para el success


