<?php
/**
  * Controlador Padres  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class PadresController extends AppController
{
    //=============
    public function index() {
      $this->page_action = 'M&oacute;dulo Padres';
    }    
    
    //=============
    public function contabilidad() {
      $this->page_title = 'Contabilidad Padres';
      $this->page_action = 'Información Contable';
      View::select('contabilidad');
    }    


} // END CLASS
