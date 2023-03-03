<?php
/**
  * Controlador Secretaria  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class SicologiaController extends AppController
{
    
    public function index() {
      $this->page_action = 'M&oacute;dulo Sicolog&iacute;a';
      $this->data = (new Evento)->getEventosDashboard();
    }
    
    public function estudiantes() {
      $this->page_title = 'Estudiantes Activos';
      $this->data = (new Estudiante)->getListSicologia(estado:1);
      View::select('estudiantes/index');
    }
    

} // END CLASS
