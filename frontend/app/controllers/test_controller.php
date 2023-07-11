<?php
/**
  * Controlador Secretaria  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class TestController extends AppController
{
    // $this->module_name, $this->controller_name, $this->action_name, 
    // $this->parameters, $this->limit_params, $this->scaffold, $this->data
    
    public function index() {
      $this->page_action = 'Inicio';
    }
    
} // END CLASS
