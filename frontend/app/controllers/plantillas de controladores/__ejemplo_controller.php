<?php
/**
  * Controlador Maestros  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class OdairController extends AppController
{
    //public $theme="w3-theme-blue-grey";
    // FILTROS de AppControler: Initialize --> BeforeFilter --> AfterFilter --> Finalize.
    // =======================
    // Útiles para comprobaciones a nivel de aplicación:
    // [verificar el módulo que se esta intentando acceder, sesiones de usuarios, etc. 
    // Igualmente se puede usar para proteger nuestro controlador de información inadecuada.
    
    /*protected function initialize() {
      // Se llama antes de ejecutar el controlador
    }*/
    
    protected function before_filter() {
      // antes de cualquier acción
    }

    protected function after_filter() { 
      // después de cada acción
    }
    
    /*protected function finalize() { 
      // después de ejecutar el controlador
    }*/

    // VARIABLES DEL CONTROLADOR
    // ==========================
    // $this->module_name, $this->controller_name, $this->parameters, $this->action_name
    // $this->limit_params, $scaffold, $data
    
    public function index() {
      $this->page_action = 'Inicio Odair';
      DwAudit::warning('ojo warning', 'mensaje ojo'); // test
      DwAudit::error('ojo error',  'mensaje ojo'); // test
      DwAudit::debug('ojo debug',  'mensaje ojo'); // test
      DwAudit::info('ojo info',  'mensaje ojo'); // test
      
      OdaFlash::valid("Mensaje : $this->page_action", true);
      OdaFlash::error("Mensaje ERROR: $this->page_action", true);
      OdaFlash::warning("Mensaje : $this->page_action", true);
      OdaFlash::info("Mensaje INFO: $this->page_action", true);      

    }

} // END CLASS
