<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */

require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfBoletines extends Mpdf {
  
  public function __construct(array $config = [], $container = null) {
    parent::__construct($config, $container);
    
    $this->SetSubject('Boletin de Notas');
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetAuthor(Config::get('config.institution.nombre'));
    $this->SetTitle( strtoupper(TBoletin::Boletin->label().' de Notas'));
    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(10);
    $this->SetMargins(20, 15, 48 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $logo = '<a href="'.Config::get('config.institution.website').'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/ws_logo.png" alt="Logo" height="40"> </a>';
    $this->SetHTMLHeader("
    <div style=\"text-align: center; font-weight: bold;\">
        $logo <br> <h2>$this->title</h2>
    </div>");

    //<td width="33%">{DATE j-m-Y}</td>
    $this->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%"></td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;"></td>
        </tr>
    </table>');
    
  } //END-__construct  


  public function encabezadoBloqueBoletines(array $Params = []): string {
    [ $estudiante_nombre, $periodo, $annio, $salon ] = $Params;
    
    $col11 = '<b>ALUMNO:</b>';
    $col12 = '<b>'.strtoupper($estudiante_nombre) .'</b>';
    $col13 = "<b>PERIODO 0$periodo - $annio</b>";
    
    $col21 = '<b>GRADO:</b>';
    $col22 = '<b>'.strtoupper($salon).'</b>';
    $col23 = '';
    
    $head = new OdaTable(_attrs: 'class="w3-rounded" bgcolor="#87CEEB" cellspacing="5" cellpadding="5" border="0" width="100%"');
    $head->addRow([ $col11, $col12, $col13 ], attrs_td: ['','colspan'=>3, 'colspan'=>2]);
    $head->addRow([ $col21, $col22, $col23 ], attrs_td: ['','colspan'=>3, 'colspan'=>2]);
    return $head;
  } //END-encabezadoBloqueBoletines
  
  public function pieBloqueBoletines(array $Params = []): string {
    [ $img_tabla_rango, $firma_director, $nombre_director ] = $Params;
    
    $col1 = $img_tabla_rango;
    $col3 = $firma_director.'<br><b>DIRECTOR DE GRUPO</b><br>'.strtoupper($nombre_director);
    $foot = new OdaTable('style="width: 100%;"');
    $foot->addRow( [$col1, '', $col3], attrs_td: ['style="width: 33%;"', 'style="width: 33%;"']);
    
    return str_repeat('<br>', 2) .$foot;
  } //END-pieBloqueBoletines
  
}
// END-CLASS-OdaPdf