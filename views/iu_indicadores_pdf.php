<?php
    require __DIR__.'/../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;
    try {
        ob_start();
        include dirname(__FILE__) . '/../reports/Motivos.php';
        $content = ob_get_clean();
        set_time_limit(0);
        ini_set('memory_limit', '340M');
        $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', 3);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content);
        $html2pdf->output('motivos.pdf');
    } catch (Html2PdfException $e) {
        $html2pdf->clean();
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getHtmlMessage();
    }

?>   
         		
