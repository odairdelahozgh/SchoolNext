<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador DMZ (Sin seguridad)
 *
 * Todos las controladores heredan de esta clase en un nivel superior
 * por lo tanto los métodos aquí definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
abstract class DmzController extends Controller
{
  public $page_action = '';
  public $page_title  = 'Título Página';
  //public $theme     = 'w3-theme-windsor-blue-grey';

  public int  $_data_count = 0;
  public array  $arrData = [];
  public object $Modelo;
  public array  $fieldsToShow = [];
  public array  $fieldsToShowLabels = [];
  public array  $fieldsToHidden = [];
  public string $nombre_post = '';
  public string $nombre_modelo = '';
  

  public string $theme = 'dark';
  public string $themei = 'd';
  
  public ?int $user_id = 0;
  public ?string $user_name = '';
  public string $_instituto_id = '';
  public string $_instituto_nombre = '';
  public int $_periodo_actual = 0;
  
  final protected function initialize() {
    try {
    $this->data = [0];
    
    $this->user_id = 0;
    $this->user_name = 'anonimo';
    $this->_periodo_actual = Config::get(var: 'config.academic.periodo_actual');

    $this->_instituto_id = Config::get('institutions.'.INSTITUTION_KEY.'.id');
    $this->_instituto_nombre = Config::get('institutions.'.INSTITUTION_KEY.'.nombre');
    $this->theme = 'dark' ;
    $this->themei = substr($this->theme,0,1);
    
    $this->nombre_post   = strtolower(OdaUtils::pluralize($this->controller_name));
    $this->nombre_modelo = ucfirst(OdaUtils::singularize($this->controller_name));
    
    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
    
  }

  final protected function finalize() {
    try {
    $this->page_action = (!$this->page_action) ? $this->action_name : $this->page_action;
    $this->page_title = strtoupper($this->controller_name) .' - ' . $this->page_action .' | ' .Config::get('institutions.'.INSTITUTION_KEY.'.nombre');
    
    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
  }

}
