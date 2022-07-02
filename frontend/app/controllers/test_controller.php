<?php
/**
  * Controlador Secretaria  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class TestController extends AppController
{

    // VARIABLES DEL CONTROLADOR
    // ==========================
    // $this->module_name, $this->controller_name, $this->parameters, $this->action_name
    // $this->limit_params, $scaffold, $data
    
    public function index() {
      $this->page_title = 'Inicio';
      $this->page_action = 'M&oacute;dulo Test';
    }
    
} // END CLASS
