<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador para proteger los controladores que heredan
 * Para empezar a crear una convenciÃ³n de seguridad y mÃ³dulos
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los mÃ©todos aquÃ­ definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
abstract class AdminController extends Controller
{
    public $page_action = '';
    public $page_title  = 'T¨ªtulo P¨¢gina';
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
