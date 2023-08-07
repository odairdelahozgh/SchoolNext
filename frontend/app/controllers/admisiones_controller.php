<?php
/**
  * Controlador Admisiones
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class AdmisionesController extends DmzController
{
    
  public function index() {
    try {
      $this->page_action = 'Inicio';
      View::select('auth-commingsoon-v1', 'looper/auth-comingsoon-v1');

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-index

  
} // END CLASS