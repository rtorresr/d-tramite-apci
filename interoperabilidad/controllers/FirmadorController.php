<?php
require_once("../views/clases/DocDigital.php");
require_once("../views/clases/Log.php");

class FirmadorController
{
    private $urlDocumento;
    private $nombreDocumento;
    private $tipo;
    private $tipoFirma;
    private $nroVisto;
    private $nomDoc;
    private $posx;
    private $posy;
    private $firma;
    private $razon;
    private $apariencia;
    private $cud;  /*CUD*/

    public function argumentosFirmador(){
        $this->tipo = $_POST['type'];
        $this->urlDocumento = $_POST['urlDocFirmar'];
        $this->nomDoc = $_POST['nombreDocumentoFirmar'];        
        $this->tipoFirma = $_POST['tipFirma'];
        $this->nroVisto = $_POST['nroVisto'];
        $this->cud = $_POST['cud'];   /*CUD*/

        /*print_r('DATOS');
        print_r($this->nomDoc);
        print_r('<br>');
        print_r('CUD:'.$this->cud);
        print_r('<br>');
        print_r('ESO FUE EL CUD');*/
        // $urlArray = explode("/", $this->urlDocumento);
        // $this->nomDoc = DocDigital::formatearNombre(array_pop($urlArray),true,[' ']);

        if ($this->tipoFirma =='f'){
            $this->firma = "files.apci.gob.pe/srv-files/firmas/default/firma.png";
            $this->razon = 'Soy el autor del documento';
            $this->posx = 515;
            $this->posy = 174;
            $this->apariencia = 2;

        }else if ($this->tipoFirma =='v'){
            $this->firma = $_SESSION['VistoBueno'];
            $this->razon = 'Visto Bueno';
            $this->posx =6;
            $this->posy =174 + 84*((int) $this->nroVisto);
            $this->apariencia = 2;

        } else if ($this->tipoFirma =='c') {
            $this->firma = "files.apci.gob.pe/srv-files/firmas/default/apci__logo--mini--color.png";
            //$this->razon = 'Cargo del documento';
            $this->razon = 'Cargo documento   CUD: '.$this->cud;    /*CUD*/
            $this->posx = 420;
            $this->posy = 20;
            $this->apariencia = 0;
        }

        $param ='{
			"app":"pdf",
			"fileUploadUrl":"'.FILE_UPLOAD_URL.'",
			"reason":"'.$this->razon.'",
			"type":"'.$this->tipo.'",
			"clientId":"'.FIRMA_CLIENTE_ID.'",
			"clientSecret":"'.FIRMA_CLIENTE_SECRET.'",
			"dcfilter":".*FIR.*|.*FAU.*",
			"fileDownloadUrl":"'.$this->urlDocumento.'",
			"posx":"'.$this->posx.'",
			"posy":"'. $this->posy.'",
			"outputFile":"'.$this->nomDoc.'",
			"protocol":"S",
			"contentFile":"demo.pdf",
			"stampAppearanceId":"'.$this->apariencia.'",
			"isSignatureVisible":"true",
			"idFile":"MyForm",
			"fileDownloadLogoUrl":"'.SERVER_PATH_INVOKER.'/resources/img/iLogo1.png",
			"fileDownloadStampUrl":"'.$this->firma.'",
			"pageNumber":"0",
			"maxFileSize":"5242880",
			"fontSize":"6",			
			"timestamp":"true"
		}';

        echo  base64_encode($param);
    }
}