<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */
require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfListasClase extends Mpdf 
{
  private array $arr_periodos = [1=>'P1', 2=>'P2', 3=>'P3', 4=>'P4'];
  public function __construct(array $config = [], $container = null) 
  {
    parent::__construct($config, $container);

    $this->SetTitle('LISTAS DE CLASE');
    $this->SetAuthor(Config::get('institutions.'.INSTITUTION_KEY.'.nombre'));
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetSubject('LISTAS DE CLASE');
    $this->SetKeywords('listas, clase');

    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(9);
    $this->SetMargins(15, 5, 30 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $logo = '<a href="'.Config::get('institutions.'.INSTITUTION_KEY.'.website').'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/'.Config::get('institutions.'.INSTITUTION_KEY.'.logo').'" alt="Logo" height="40"> </a>';
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
  }


  public function encabezado(&$tabla, int $periodo = 1): void
  {
    $col_periodos = [];
    if ($periodo>1) {
      $col_periodos = array_slice($this->arr_periodos, 1, $periodo-1);
    }

    $head = array_merge (
      ['No.', 'Estudiante'], 
      array_values($col_periodos), 
      ["Prom", "Nota", "Partici", "Tareas", "Ev. Oral", "Ev. Escri", "Clase", "Actitud", "Final", "P.A.", "Asist"]
    );
    
    $tabla->setHead($head, '', ['style="width: 0.5cm;"', 'style="width: 6cm;"', 'style="width: 0.8cm;"']);
  }
  
/* 
  public function cuerpo(&$tabla, $key, $registro, int $periodo = 1): void
  {
    $cols = array_merge(
      [ ($key+1), $registro->estudiante_nombre],
      array_slice($this->arr_periodos, 0, $periodo-1),
      array_fill(1, 11, ''),
    );

    $tabla->addRow($cols);
  }
 */

  
 public function cuerpo(&$tabla, $key, $registro, int $periodo = 1): void
 {
  $notas = [];
  for ($p=1; $p<=($periodo-1); $p++) { 
    $notas[] = "$registro->nota_final_periodo_{$p}";
    /*
    if (array_key_exists($p, $registro)) {
    } else {
      $notas[] = 0;
    }
      */
   }

   $cols = array_merge(
     [ $key, $registro->nombre_estudiante],
     $notas,
     array_fill(1, 11, ''),
   );

   $tabla->addRow($cols);
 }


  public function pie(): string
  {
    return '<hr>'.str_repeat('<br>', 2);
  }

  

}