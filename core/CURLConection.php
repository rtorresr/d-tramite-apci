<?php
class CURLConnection{
    private $curl;

    public function __construct($url)
    {
        $this->curl = curl_init($url);
    }

    function build_post_fields( $data,$existingKeys='',&$returnArray=[]){
        if(($data instanceof CURLFile) or !(is_array($data) or is_object($data))){
            $returnArray[$existingKeys]=$data;
            return $returnArray;
        }
        else{
            foreach ($data as $key => $item) {
                $this->build_post_fields($item,$existingKeys?$existingKeys."[$key]":$key,$returnArray);
            }
            return $returnArray;
        }
    }

    public function uploadFile($FILES, $POST) {
        // Prepare the cURL file to upload, including file name and MIME type
        $post = array(
            $POST["name"] => new CurlFile($FILES[$POST["name"]]["tmp_name"], $FILES[$POST["name"]]["type"], $FILES[$POST["name"]]["name"]),
        );

        // Include the other $_POST fields from the form?
        $post = array_merge($post, $POST);
        //print_r($post); exit();
        // Prepare the cURL call to upload the external script
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:54.0) Gecko/20100101 Firefox/54.0");
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS,  $this->build_post_fields($post));
        $respuesta = curl_exec($this->curl);

        if($respuesta){
            $respuesta = json_decode($respuesta);
            if (!$respuesta->success){
                throw new Exception($respuesta->mensaje);
            }
        } else {
            throw new Exception(curl_error($this->curl));
        }        
    }
    public function closeCurl(){
        curl_close($this->curl);
    }
}
?>
