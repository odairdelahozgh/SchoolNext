<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todos las controladores heredan de esta clase en un nivel superior
 * por lo tanto los métodos aquií definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
abstract class AppController extends Controller
{
    public $page_action = '';
    public $page_title  = 'Título Página';
    public $breadcrumb;

    public $theme       = 'dark';
    public $themei      = 'd';
    public $user_id     = 0;
    public $id_instit   = '';

    final protected function initialize() {
        if (!Session::get('usuario_logged')) {
            Redirect::to("auth/login");
            return false;
        }
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->class_ul = 'breadcrumb';
        //$this->breadcrumb->addCrumb(0, '&#127968;');
        $this->breadcrumb->addCrumb(0, '&#127968;', '');
        $this->user_id = Session::get('id');
        //$optTheme = (date("H",time())<18) ? 'light' : 'dark' ;
        $this->id_instit = Config::get('institucion.id_name');
        $this->theme = (Session::get('theme')) ? Session::get('theme') : 'dark' ;
        $this->themei = substr($this->theme,0,1);
    }
    
    final protected function finalize() {
        $this->page_action = (!$this->page_action) ? $this->action_name : $this->page_action;
        $this->page_title = strtoupper($this->controller_name) .' - ' . $this->page_action .' | ' .APP_NAME;
    }

}
