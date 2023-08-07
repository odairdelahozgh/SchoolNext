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
    //public $theme       = 'w3-theme-windsor-blue-grey';

    final protected function initialize() {
    }

    final protected function finalize() {
        $this->page_action = (!$this->page_action) ? $this->action_name : $this->page_action;
        $this->page_title = strtoupper($this->controller_name) .' - ' . $this->page_action .' | ' .APP_NAME;
    }

}
