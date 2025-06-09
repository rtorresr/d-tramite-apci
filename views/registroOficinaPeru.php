<!DOCTYPE html>
<html>
<head>
        <title>Firma Peru Web</title>  	
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />	
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>     
        <link href="https://getbootstrap.com/docs/4.6/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>        
        <script src="https://getbootstrap.com/docs/4.6/dist/js/bootstrap.bundle.min.js" ></script>
        <script type="text/javascript">
            //<![CDATA[
            console.log("JQuery de la web demo: " + $.fn.jquery);
            //]]>
        </script>    
    </head>
<body> 


    <script type="text/javascript">
        var jqFirmaPeru = jQuery.noConflict(true);

        function signatureInit(){
            alert('PROCESO INICIADO');
        }

        function signatureOk(){
            alert('DOCUMENTO FIRMADO');
        }

        function signatureCancel(){
            alert('OPERACIÓN CANCELADA');
        }

       /* // Función para codificar en Base64
        function base64EncodeUnicode(str) {
            return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
                function toSolidBytes(match, p1) {
                    return String.fromCharCode('0x' + p1);
                }));
        }*/




function base64EncodeUnicode(str) {
    // Codifica texto unicode en base64 (equivalente a base64_encode en PHP)
    return btoa(unescape(encodeURIComponent(str)));
}

function sendParam() {

    const pades = "PAdES";
    const idDigital=1146057;
       
    const firmaInitParams = {
        //param_url: "http://192.168.10.18/views/invoker/postArgumentsPeru.php?pades="+pades+"&idDigital="+idDigital,
        param_url: "http://localhost/d-tramite-final/views/invoker/postArgumentsPeru.php?pades="+pades+"&idDigital="+idDigital,
        param_token: "eyJhbGciOiJFUzUxMiIsInR5cCI6IkpXVCIsImtpZCI6IjE2NTUzMjY3MTI3NDEifQ.eyJpc3MiOiJQbGF0YWZvcm1hIE5hY2lvbmFsIGRlIEZpcm1hIERpZ2l0YWwgLSBGaXJtYSBQZXLDuiIsInN1YiI6IkZpcm1hZG9yIiwiZXhwIjoxNzQ2NzM0MjM2LCJpYXQiOjE3NDY2NDc4MzYsImp0aSI6Inc0TnpwVWs4N3pJd05UQTBPVEUxTlRJemNQYk0zM0VyeVEiLCJ2ZXIiOiIxLjAuMCYxLjEuMCIsImVudCI6ImVudGl0eV90eXBlPVNpbiBlc3BlY2lmaWNhciwgZW50aXR5PUFnZW5jaWEgUGVydWFuYSBkZSBDb29wZXJhY2nDs24gSW50ZXJuYWNpb25hbCwgaW5pdGlhbHM9QVBDSSwgZG9jdW1lbnQ9MjA1MDQ5MTU1MjMiLCJhcHAiOiJELVRSQU1JVEUiLCJhaWQiOiJjN1RTSzVMSml2WDIwWkhpQ2t1VzFCQldXNCtJUjc0aUdKMERQNjhXZlY1bGQ3RXhiQWtpZDZlVVhmcHI3ekNxIiwidG9rIjoiTUtoTTA3SWJJSWZuN3FTRWFpa0daRU5KS0FyYmdNSDNHTzBmalFlTFkwdHZVUytUdHphZ29LT2ozV0hnVUJ2MWQ3bDBDNnAzTG5JS3FNUnFxMkV6OVE9PSIsIm13cyI6IldlUWFTSjNwTWFVQzNVN1BNYkJ3SENrNHV6UEVSZXQ2VVJicjRiRGdUZlM4dzNzOGlQVldBeDlOZEYzQnZCUzNjbjJGRmZ5TXB3dit3OU9Da21XMFRRPT0ifQ.ANC-lY0oQUk4CZjBMi8pcngeWmOtntmQmTcXS0Vtnh2Hc_rBSuGhdOZpW7HlDkDZHSeM_GmifWn5v5k5koz5AfQ-AfomeYqdWWsGSUoEu1eNL3q9K5eoNrGG5GtxYkQLeO4Mso48jIgfGqfUP_L7vzrEhunKhAOEO4Zozn8edI057DYl",
        document_extension: "pdf"
    };
    const jsonString = JSON.stringify(firmaInitParams);

    const base64Param = base64EncodeUnicode(jsonString);
    
    const port = "48596";
    
    // Llama al cliente de Firma Perú
    startSignature(port, base64Param);
}
        
    </script>

    <!-- Poner la URL del servicio firmaperu.min.js -->	
    <script src="https://apps.firmaperu.gob.pe/web/clienteweb/firmaperu.min.js"></script>        
        <!--<script src="http://localhost:8080/web/clienteweb/firmaperu.min.js"></script>-->    
        <div id="addComponent" style="display:none;"></div>

        <button type="button" class="btn btn-lg btn-primary" onclick="sendParam();">INICIAR FIRMA</button>   
</body>
</html>
