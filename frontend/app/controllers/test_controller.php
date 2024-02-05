<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class TestController extends AppController
{
  // $this->module_name, $this->controller_name, $this->action_name, 
  // $this->parameters, $this->limit_params, $this->scaffold, $this->data
  
  public function index() 
  {
    try 
    {
      $this->page_action = 'Inicio';
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
  }


  
}