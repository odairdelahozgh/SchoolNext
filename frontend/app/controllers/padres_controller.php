<?php
/**
  * Controlador Padres  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class PadresController extends AppController
{
    //=============
    public function index(): void {
      $this->page_action = 'M&oacute;dulo Padres';
    }    
    
    //=============
    public function contabilidad(): void {
      $this->page_action = 'Información Contable';
      //$this->data = [];
      //View::select('');
    }
    
    public function estudiantes(): void {
      $this->page_action = 'Estudiantes a Cargo';
      $this->arrData['periodo'] = Session::get('periodo');
      $this->data = (new Estudiante)->getListPadres($this->user_id);
      View::select('estudiantes/index');
    }
    
} // END CLASS
