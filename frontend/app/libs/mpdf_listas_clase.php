<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */

require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfListasClase extends Mpdf {
  
  public function __construct(array $config = [], $container = null) {
    parent::__construct($config, $container);
    
    $this->SetSubject('LISTAS DE CLASE');
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetAuthor(Config::get('config.institution.nombre'));
    $this->SetTitle('LISTAS DE CLASE');
    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(9);
    $this->SetMargins(10, 5, 48 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $logo = '<a href="'.Config::get('config.institution.website').'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/ws_logo.png" alt="Logo" height="40"> </a>';
    $this->SetHTMLHeader("
    <div style=\"text-align: center; font-weight: bold;\"> $logo </div>");

    //<td width="33%">{DATE j-m-Y}</td>
    $this->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%">SchoolNEXT>></td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;">Listas de Clase</td>
        </tr>
    </table>');
    
  } //END-__construct  


  public function encabezadoBloque(array $Params = []): string {
    //[ $profesor_nombre, $periodo, $annio, $salon ] = $Params;
    
    $cols = [
      'No.',
      'Estudiante',
      "Notas",
      "Promedio",
      "Participación",
      "Tareas-Talleres",
      "Eval. Orales",
      "Eval. Escritas",
      "Trab. clase",
      "Act",
      "Final",
      "P.A.",
      "Asistencia",
    ]; 
  
    $head = new OdaTable(_attrs: 'bgcolor="red" color="white" cellspacing="0" cellpadding="0" bordercolor="white"  border="1" width="100%"');
    $head->addRow($cols);
    return $head;
  } //END-encabezadoBloque
  
  public function pieBloque(array $Params = []): string {
    //[ $img_tabla_rango, $firma_director, $nombre_director ] = $Params;
    
    $col1 = 'clo1';
    $col2 = 'clo2';
    $col3 = 'clo3';
    $foot = new OdaTable('style="width: 100%;"');
    $foot->addRow( [$col1, $col2, $col3], attrs_td: []);
    
    return str_repeat('<br>', 2) .$foot;
  } //END-pieBloque
  
}
// END-CLASS-OdaPdf