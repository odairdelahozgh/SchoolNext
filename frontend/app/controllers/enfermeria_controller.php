<?php
/**
  * Controlador Secretaria  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class EnfermeriaController extends AppController
{
  protected function before_filter() {
    if ( !str_contains('enfermeria', Session::get('roll')) && !str_contains('admin', Session::get('roll')) ) {
      OdaFlash::warning('No tiene permiso de acceso al módulo ENFERMERÍA, fué redirigido');
      Redirect::to(Session::get('modulo'));
    }
  } //END-before_filter
    
    public function index() {
      $this->page_action = 'Inicio';
    }

    
    public function estudiantes() {
      $this->page_action = 'Estudiantes Activos';
      $this->data= (new Estudiante)->getList();
      View::template('list_details');
    }
    
} // END CLASS
