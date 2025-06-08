<?php 
echo "cCodTipoDoc ".$_POST[cCodTipoDoc]."<br>"; 
echo "cReferencia ".$_POST[cReferencia]."<br>"; 
echo "cAsunto ".$_POST['cAsunto']."<br>";
echo "cObservaciones ".$_POST[cObservaciones]."<br>";
echo "nFlgRpta ".$_POST[nFlgRpta]."<br>"; 
echo "nNumFolio ".$_POST[nNumFolio]."<br>";
echo "nFlgEnvio ".$_POST[nFlgEnvio]."<br>";
echo "cSiglaAutor ".$_POST[cSiglaAutor]."<br>";
echo "editor1 $_POST['cAsunto'] <br>";
echo ord("h")."<br>";
echo ord("hello")."<br>";
$r="";
echo (str_replace( '\"', '"', $_POST['cAsunto'] ))."Hola";

