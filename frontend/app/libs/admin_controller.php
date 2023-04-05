<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador para proteger los controladores que heredan
 * Para empezar a crear una convención de seguridad y módulos
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los métodos aquí definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
abstract class AdminController extends Controller
{
    public $page_action = '';
    public $page_title  = 'Titulo Pagina';
    public $breadcrumb  = 'Inicio';

    public $theme       = 'dark';
    public $themei      = 'd';
    public $user_id     = 0;

    public $page_module = '';
    public $id_instit   = '';
    
    public array  $arrData = [];
    public object $Modelo;
    public array  $fieldsToShow = [];
    public array  $fieldsToShowLabels = [];
    public array  $fieldsToHidden = [];
    public string $nombre_post   = '';
    public string $nombre_modelo = '';
    

    final protected function initialize()
    {
      $this->user_id = Session::get('id');
      $this->id_instit = Config::get('config.institution.id_name');
      $this->theme = (Session::get('theme')) ? Session::get('theme') : 'dark' ;
      $this->themei = substr($this->theme,0,1);

      $this->nombre_modelo = OdaUtils::singularize($this->controller_name);
      $this->nombre_post   = strtolower(OdaUtils::pluralize( $this->nombre_modelo ));
      //OdaLog::alert("$this->nombre_post : $this->nombre_modelo");
    }

    final protected function finalize() {
        //$this->page_title = trim($this->page_title).' | '.APP_NAME;
        $this->page_action = (!$this->page_action) ? $this->action_name : $this->page_action;
        $this->page_title  = strtoupper($this->controller_name) .' - ' . $this->page_action .' | ' .APP_NAME;
        
    }

}
