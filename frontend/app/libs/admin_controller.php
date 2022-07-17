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

    final protected function initialize()
    {
    }

    final protected function finalize() {
        $this->page_title = trim($this->page_title).' | '.APP_NAME;
        
    }

}
