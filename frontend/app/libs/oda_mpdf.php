<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */

require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class OdaMpdf extends Mpdf {
  public string $logo = '';

  public function __construct(array $config = [], $container = null) {
    parent::__construct($config, $container);
    
    $this->SetSubject('Subject');
    $this->SetTitle('Title');

    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetAuthor(Config::get('config.institution.nombre'));
    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(10);
    $this->SetMargins(20, 15, 30 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $this->logo = '<a href="'.Config::get('config.institution.website').'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/ws_logo.png" alt="Logo" height="40"> </a>';

    $this->SetHTMLHeader("
      <div style=\"text-align: center; font-weight: bold;\">
        $this->logo 
      </div>");

    $this->SetHTMLFooter('
      <table width="100%">
        <tr>
          <td width="33%"><small>'.APP_NAME.'</small></td>
          <td width="33%" align="center">{PAGENO}/{nbpg}</td>
          <td width="33%" style="text-align: right;"></td>
        </tr>
      </table>');

  } //END-__construct  


}
// END-CLASS