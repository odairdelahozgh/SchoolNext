<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';
// ODAIR
const APP_NAME= "SchoolNEXT>>";
const FILE_UPLOAD_PATH   = PUBLIC_PATH.'files/upload/';
const FILE_DOWNLOAD_PATH = PUBLIC_PATH.'files/download/';
const IMG_UPLOAD_PATH   = PUBLIC_PATH.'img/upload/';
const IMG_DOWNLOAD_PATH = PUBLIC_PATH.'img/download/';

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
    public $breadcrumb  = 'Inicio';

    public $theme       = 'dark';
    public $themei      = 'd';
    public $user_id     = 0;

    /**
     * Crea el BreadCrumb
     *
     * @example <?= _Icons::solid('flag', 'w3-small'); ?>
     *
     * @param string|null $icon: nombre del ícono solid
     * @param string|null $size: tamaño w3-tiny. w3-small, w3-large, w3-xlarge, w3-xxlarge, w3-xxxlarge, w3-jumbo]
     * 
     * @return string
     *
     */
    protected function bc($param=null) {
        if (is_null($param)) {
            return 'Inicio';
        }
        
        $ARuta = explode(';',$param);
        $breadcrumb = _Tag::linkBC('', 'Inicio');
        if (count($ARuta)==1) {
            return $breadcrumb.'&nbsp;'._Icons::solid('angles-right', "w3-small").'&nbsp;'.$ARuta[0];
        }
        
        if (count($ARuta)==2) {
            return $breadcrumb
                   .'&nbsp;'._Tag::linkBC(strtolower($ARuta[0]), $ARuta[0])
                   .'&nbsp;'._Icons::solid('angles-right', "w3-small").'&nbsp;'.$ARuta[1];
        }

    }


    final protected function initialize() {
        if (!Session::get('usuario_logged')) {
            Redirect::to("auth/login");
            return false;
        }
        $this->breadcrumb = $this->bc();
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
