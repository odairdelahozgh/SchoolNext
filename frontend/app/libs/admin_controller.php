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
  public string $page_action = '';
  public string $page_title = 'Titulo Pagina';
  
  public $breadcrumb;

  public string $theme = 'dark';
  public string $themei = 'd';
  public ?int $user_id = 0;
  public ?string $user_name = '';
  public ?string $user_nombre_completo = '';

  public string $page_module = '';
  public string $id_instit = '';
  public string $_instit_name = '';
  
  public array  $arrData = [];
  public object $Modelo;
  public array  $fieldsToShow = [];
  public array  $fieldsToShowLabels = [];
  public array  $fieldsToHidden = [];
  public string $nombre_post = '';
  public string $nombre_modelo = '';

    
  // PARA LA GENERACIÓN DE ARCHIVOS
  public ?string $file_tipo = null;
  public ?string $file_name = null;
  public ?string $file_title = null;
  public bool $file_download = true;
  public string $file_orientation = 'L';
  public $_now = null;
  
  
  protected function before_filter()
  {
    if (Input::isAjax()) {
        View::template(null);
    }
  }


  final protected function initialize(): void
  {
      $this->breadcrumb = new OdaBreadcrumb();
      $this->user_id = Session::get('id');
      $this->user_name = Session::get('username');
      $this->user_nombre_completo = trim(Session::get('nombres').' '.Session::get('apellido1').' '.Session::get('apellido2'));
      
      $this->id_instit = Config::get('config.institution.id_name');
      $this->_instit_name = Config::get('config.institution.nombre');
      $this->theme = (Session::get('theme')) ? Session::get('theme') : 'dark' ;
      $this->themei = substr($this->theme,0,1);
      
      $this->nombre_modelo = OdaUtils::singularize($this->controller_name);
      $this->nombre_post   = strtolower(OdaUtils::pluralize( $this->nombre_modelo ));
      $this->_now = new DateTime("now", new DateTimeZone("America/Bogota"));
  }

  
  final protected function finalize(): void 
  {
      $this->page_action = (!$this->page_action) ? $this->action_name : $this->page_action;
      $this->page_title  = strtoupper($this->controller_name) .' - ' . $this->page_action .' | ' .APP_NAME;
  }



}