<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */

require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class OdaPdfm {
  
  public function example1() {
    View::select(null, null); //Importante: Sin vista y sin tamplate
    $mpdf = new Mpdf(['tempDir' => APP_PATH.'/temp']);
    $mpdf->WriteHTML('¡Hola KumbiaPHP!');
    $mpdf->Output(); // Lo envía directamente al navegador
  } //END-example1
  
  
}
// END-CLASS-OdaPdf
